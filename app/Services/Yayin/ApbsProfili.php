<?php

namespace App\Services\Yayin;

use App\Enums\Kategori;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * APBS (Akademik Personel Bilgi Sistemi) profilinden faaliyet okur.
 *
 * NE: Mersin Üniversitesi'nin kendi yazdığı akademik künye sistemi —
 * apbs.mersin.edu.tr/profiles/410660. AVESİS DEĞİL: adres yapısı
 * (/profiles/<sicil no>), bölüm adları ve HTML'i başka. Altyapısı AdminLTE,
 * verisi kendi dipnotuna göre "Yöksis, Doi.org, Web of Science, TRDizin"den
 * geliyor.
 *
 * AVESİS'E GÖRE ARTI: ÇEYREKLİK YAZIYOR. Yayın satırında indeksin yanında
 * ayrı bir rozette Q1–Q4 duruyor. Bu, sözlüğün en çok kullanılan kademe
 * ailesini ("SCIE/SSCI (Q1)") ilk kez tahmin etmeden doldurabildiğimiz
 * yer; AVESİS'te o kademeler zorunlu olarak boş iniyordu.
 *
 * AVESİS'E GÖRE EKSİ: kayıtların kimliği yok. Her satır yalnız HTML;
 * kalıcı bir kayıt numarası ya da bağlantısı bulunmuyor. Kimlik künyeden
 * türetiliyor (bölüm + sekme + başlık + yıl), tıpkı AVESİS'in kimliksiz
 * bölümlerinde olduğu gibi.
 *
 * SUNUCU KIRILGAN: eşzamanlı birkaç istekte 504 veriyor. Bölümler bu yüzden
 * SIRAYLA okunuyor ve sonuç 6 saat saklanıyor.
 *
 * ROBOTS: sitede robots.txt yok (404); profil sayfaları herkese açık ve
 * giriş istemiyor.
 *
 * @phpstan-type Kayit array{
 *     id: string,
 *     kategori: string,
 *     baslik: string,
 *     yazarlar: string,
 *     kunye: string,
 *     yil: int|null,
 *     doi: string|null,
 *     kaynak: string|null,
 *     uyari: string|null,
 *     rol: string|null,
 *     atlandi: bool,
 * }
 */
class ApbsProfili implements ProfilOkuyucu
{
    private const TARAYICI = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) '
        .'AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0 Safari/537.36';

    /** Profil içeriği aday güncelledikçe değişiyor; kopya kısa ömürlü. */
    private const OMUR = 60 * 60 * 6;

    /** Tek bölüm için beklenecek süre. */
    private const ZAMAN_ASIMI = 25;

    /**
     * Bütün bölümler için toplam süre.
     *
     * SUNUCU YAVAŞLAYABİLİYOR: yoğun anlarda tek sayfa 40 saniye sürüyor,
     * 14 bölüm de sırayla okunuyor. Bütçe bitince kalan bölümler okunmamış
     * sayılıyor; aday dakikalarca dönen bir düğmeye bakmıyor.
     */
    private const BUTCE = 90;

    /**
     * Okunan bölümler — profil menüsündeki sırayla.
     *
     * `deneyimler` listenin sonunda: tek "callout" kullanmayan bölüm o
     * (zaman tüneli düzeni), ayrı okunuyor.
     *
     * @var list<string>
     */
    private const BOLUMLER = [
        'makaleler', 'bildiriler', 'kitaplar', 'projeler', 'oduller',
        'patentler', 'tasarimlar', 'editorlukler', 'hakemlikler',
        'tez_danismanliklari', 'sanatsal_faaliyetler', 'arastirma_sertifikalari',
        'uyelikler', 'deneyimler',
    ];

    /** Proje fon programı → sözlükteki kademe. Sıra önemli: ilk eşleşen. */
    private const FONLAR = [
        ['desen' => '/t[üu]b[İIıi]tak/iu', 'kaynak' => 'TÜBİTAK'],
        ['desen' => '/t[üu]seb/iu', 'kaynak' => 'TÜSEB'],
        ['desen' => '/ufuk|horizon|avrupa birli[ğg]i|[çc]er[çc]eve program/iu', 'kaynak' => 'AB Çerçeve / Ufuk'],
        ['desen' => '/2209|[öo][ğg]renci/iu', 'kaynak' => 'Öğrenci Projesi (2209 vb.)'],
        ['desen' => '/\bbap\b|y[üu]ksek[öo][ğg]retim kurumlar/iu', 'kaynak' => 'BAP (Üniversite)'],
        ['desen' => '/di[ğg]er uluslararas/iu', 'kaynak' => 'Diğer Uluslararası Fon'],
        ['desen' => '/[öo]zel sekt[öo]r|sanayi|stk/iu', 'kaynak' => 'Özel Sektör / STK'],
        ['desen' => '/kamu|bakanl[ıi]k|kalk[ıi]nma ajans/iu', 'kaynak' => 'Diğer Kamu Kurumu'],
    ];

    /** Projedeki görev rozeti → {@see Kategori::roller()} anahtarı. */
    private const ROLLER = [
        '/y[üu]r[üu]t[üu]c[üu]|koordinat[öo]r/iu' => 'yurutucu',
        '/ara[şs]t[ıi]rmac[ıi]/iu' => 'arastirmaci',
        '/dan[ıi][şs]man/iu' => 'danisman',
        '/bursiyer/iu' => 'bursiyer',
    ];

    /**
     * Son okumada ulaşılamayan bölüm sayısı.
     *
     * APBS'te her bölüm HER profilde var (boşsa "bulunamadı" kutusu
     * dönüyor), o yüzden okunamayan bölüm gerçekten bir eksik.
     */
    private int $eksik = 0;

    public function sistem(): string
    {
        return 'apbs';
    }

    public function eksikBolum(): int
    {
        return $this->eksik;
    }

    public function ad(): string
    {
        return 'APBS';
    }

    public function ornekAdres(): string
    {
        return 'https://apbs.mersin.edu.tr/profiles/410660';
    }

    /**
     * Profil adresini ayrıştırır.
     *
     * SUNUCU ADI SIKI SÜZÜLÜYOR: adresi aday veriyor, isteği biz atıyoruz.
     * `apbs.<kurum>.edu.tr` dışına çıkılmazsa bu alan bir SSRF kapısı
     * olamaz. Kalıp Mersin'e sabitlenmedi — aynı yazılımı kuran başka bir
     * üniversite çıkarsa adresi tanınsın; markup tutmazsa kayıt okunamaz,
     * aday da "okunabilir kayıt bulunamadı" görür.
     *
     * @return array{taban: string, kullanici: string}|null
     */
    public function adres(string $girdi): ?array
    {
        $girdi = trim($girdi);

        if (preg_match('~^(?:https?://)?(?:www\.)?(apbs\.[a-z0-9\-]+(?:\.[a-z0-9\-]+)*\.edu\.tr)/profiles/(\d{1,12})~i', $girdi, $esles) !== 1) {
            return null;
        }

        return ['taban' => 'https://'.mb_strtolower($esles[1]), 'kullanici' => $esles[2]];
    }

    /**
     * Profildeki faaliyetler.
     *
     * @param  array{taban: string, kullanici: string}  $adres
     * @return list<Kayit>
     */
    public function kayitlar(array $adres): array
    {
        $anahtar = 'apbs.'.md5($adres['taban'].'/'.$adres['kullanici']);
        $kopya = Cache::get($anahtar);

        if (is_array($kopya)) {
            // Kopya yalnız EKSİKSİZ okumadan kuruluyor.
            $this->eksik = 0;

            /** @var list<Kayit> $kopya */
            return $kopya;
        }

        $kayitlar = [];
        $gorulen = [];
        $okunan = 0;
        $this->eksik = 0;
        $bitis = microtime(true) + self::BUTCE;

        foreach (self::BOLUMLER as $bolum) {
            $html = microtime(true) < $bitis
                ? $this->getir("{$adres['taban']}/profiles/{$adres['kullanici']}/{$bolum}")
                : null;

            if ($html === null) {
                $this->eksik++;

                continue;
            }

            $okunan++;

            foreach ($this->bolum($bolum, $html) as $kayit) {
                // Kimlik künyeden türetildiği için aynı kayıt iki kez
                // listelenirse aynı kimliği alıyor. İkincisi eleniyor:
                // ekrandaki `wire:key` tekil olmalı ve zaten aynı faaliyet.
                if ($kayit['id'] !== '' && isset($gorulen[$kayit['id']])) {
                    continue;
                }

                $gorulen[$kayit['id']] = true;
                $kayitlar[] = $kayit;
            }
        }

        // Hiçbir bölüm okunamadıysa sorun profilde değil sunucuda; aday
        // "profilim boş" sanmamalı.
        if ($okunan === 0) {
            throw AramaException::profileUlasilamadi($this->ad());
        }

        // EKSİK OKUMA SAKLANMIYOR: yarım liste 6 saat boyunca doğru
        // sanılırdı ve aday kalan kayıtları bir daha göremezdi.
        if ($this->eksik === 0) {
            Cache::put($anahtar, $kayitlar, self::OMUR);
        }

        return $kayitlar;
    }

    /**
     * Bir bölüm sayfasındaki kayıtlar.
     *
     * @return list<Kayit>
     */
    private function bolum(string $bolum, string $html): array
    {
        if ($bolum === 'deneyimler') {
            return $this->deneyimler($html);
        }

        $kayitlar = [];

        foreach ($this->sekmeler($html) as [$sekme, $govde]) {
            foreach (preg_split('~(?=<div class="callout callout-)~', $govde) ?: [] as $oge) {
                if (! str_contains($oge, '<div class="callout callout-')) {
                    continue;
                }

                $kayit = $this->oge($bolum, $sekme, self::ilkDiv($oge));

                if ($kayit !== null) {
                    $kayitlar[] = $kayit;
                }
            }
        }

        return $kayitlar;
    }

    /**
     * Bir kayıt kutusu ("callout").
     *
     * @return Kayit|null
     */
    private function oge(string $bolum, string $sekme, string $oge): ?array
    {
        if (preg_match('~<h5[^>]*>(.*?)</h5>~s', $oge, $esles) !== 1) {
            return null;
        }

        $baslik = $this->duz($esles[1]);

        // Boş bölümün kendisi de bir kutu: "Ulusal kategoride proje
        // bulunamadı!". Kayıt değil, atlanan da değil.
        if ($baslik === '' || preg_match('/bulunamad[ıi]/iu', $baslik) === 1) {
            return null;
        }

        $rozet = $this->rozetler($oge);
        $satirlar = $this->satirlar($oge);
        $metin = $baslik.' '.implode(' ', $satirlar).' '.implode(' ', $rozet);

        $esleme = $this->esleme($bolum, $sekme, $rozet, $metin);

        if ($esleme === null) {
            return ['atlandi' => true] + $this->bosKayit();
        }

        $yil = $this->yil($rozet['success'] ?? '') ?? $this->yil(implode(' ', $satirlar));
        [$yazarlar, $kunye] = $this->kunye($bolum, $satirlar);

        return [
            // KİMLİK KÜNYEDEN TÜRETİLİYOR: APBS kayıtlarına numara vermiyor.
            // Kademe de kimliğe giriyor, çünkü aynı kitabın hem kendisi hem
            // bir bölümü aynı adla listelenebiliyor; ikisi ayrı faaliyet.
            'id' => 'x:'.md5($bolum.'|'.$sekme.'|'.$baslik.'|'.($yil ?? '').'|'.($esleme['kaynak'] ?? '')),
            'kategori' => $esleme['kategori'],
            'baslik' => $baslik,
            'yazarlar' => $yazarlar,
            'kunye' => trim($kunye.($sekme !== '' ? " · {$sekme}" : ''), ' ·'),
            'yil' => $yil,
            'doi' => $this->doi($oge),
            'kaynak' => $esleme['kaynak'],
            'uyari' => $esleme['uyari'] ?? null,
            'rol' => $esleme['rol'] ?? null,
            'atlandi' => false,
        ];
    }

    /**
     * Bölüm + sekme + rozetler → hangi kategori, hangi kademe.
     *
     * Eşlenemeyen bölümler bilerek listede yok:
     *   "Akademik Görevler" ve "Üniversite Dışı Deneyimler" profil bilgisi,
     *   faaliyet değil ({@see self::deneyimler}). "Araştırma Sertifikaları"
     *   bölümündeki katılım belgeleri sözlükte karşılığı olmadığı için
     *   atlanıyor; yalnız düzenleme görevleri alınıyor.
     *
     * @param  array<string, string>  $rozet
     * @return array{kategori: string, kaynak: string|null, uyari?: string|null, rol?: string|null}|null
     */
    private function esleme(string $bolum, string $sekme, array $rozet, string $metin): ?array
    {
        return match ($bolum) {
            'makaleler' => ['kategori' => 'makale'] + $this->indeks($sekme, $rozet),
            'bildiriler' => ['kategori' => 'bildiri', 'kaynak' => $this->bildiri($sekme, $rozet)],
            'kitaplar' => ['kategori' => 'kitap', 'kaynak' => $this->kitapTuru($sekme, $rozet, $metin)],
            'projeler' => [
                'kategori' => 'proje',
                'kaynak' => $this->fon($metin),
                'rol' => $this->rol($rozet['info'] ?? ''),
            ],
            'oduller' => ['kategori' => 'odul', 'kaynak' => $this->odul($metin)],
            'patentler' => ['kategori' => 'patent', 'kaynak' => $this->patent($sekme, $metin)],
            // "Tasarımlar" bölümü TESCİLLİ tasarımı değil tasarım İŞİNİ
            // listeliyor; sözlükteki "Endüstriyel Tasarım" tescil demek.
            // Kademe boş, aday seçer.
            'tasarimlar' => ['kategori' => 'patent', 'kaynak' => null],
            'editorlukler' => $this->editorluk($rozet),
            'hakemlikler' => ['kategori' => 'editorluk', 'kaynak' => 'Hakemlik'],
            'tez_danismanliklari' => [
                'kategori' => 'tez_danismanligi',
                'kaynak' => $this->tez(($rozet['primary'] ?? '').' '.$sekme),
            ],
            // Sergi mi konser mi, jürili mi, kişisel mi: sözlükte yüzden
            // fazla kademe var ve APBS listesi bu ayrımı yazmıyor.
            'sanatsal_faaliyetler' => ['kategori' => 'sanatsal_etkinlik', 'kaynak' => null],
            // Bu bölüm hem kongre DÜZENLEME görevini hem salt katılım
            // belgesini tutuyor. Rozet görevi yazıyor; katılım belgesinin
            // sözlükte karşılığı yok, atlanıyor.
            'arastirma_sertifikalari' => preg_match('/d[üu]zenle/iu', $rozet['success'] ?? '') === 1
                ? ['kategori' => 'diger', 'kaynak' => null]
                : null,
            // Kurumun kendi kurulu mu dış kuruluş mu, künyeden anlaşılmıyor.
            'uyelikler' => ['kategori' => 'idari_gorev', 'kaynak' => null],
            default => null,
        };
    }

    /**
     * Makalenin kademesi: indeks rozeti + çeyreklik rozeti.
     *
     * ÇEYREKLİK BURADA VAR ve kademeyi o belirliyor. Çeyrekliği yazmayan
     * bir SCIE kaydına "SCIE/SSCI (Q4)" demek adaya hak etmediği puanı
     * verebilirdi; kademe boş kalıyor ve gerekçesi adaya yazılıyor.
     *
     * AHCI ile ESCI'de çeyreklik aranmıyor: sözlükte o kademelerin tek
     * karşılığı var.
     *
     * @param  array<string, string>  $rozet
     * @return array{kaynak: string|null, uyari: string|null}
     */
    private function indeks(string $sekme, array $rozet): array
    {
        $indeks = $rozet['info'] ?? '';
        $ceyrek = preg_match('/^Q([1-4])$/i', trim($rozet['danger'] ?? ''), $esles) === 1
            ? 'Q'.$esles[1]
            : null;

        $aile = match (true) {
            (bool) preg_match('/ahci|arts ?& ?humanities|sanat ve be[şs]eri/iu', $indeks) => 'AHCI',
            (bool) preg_match('/sci.?expanded|\bscie?\b|\bssci\b|social sciences citation|science citation/iu', $indeks) => 'SCIE/SSCI',
            (bool) preg_match('/\besci\b|emerging sources/iu', $indeks) => 'ESCI',
            (bool) preg_match('/scopus/iu', $indeks) => 'Scopus',
            (bool) preg_match('/tr.?d[İIıi]z[İIıi]n|trdizin/iu', $indeks) => 'TR Dizin',
            default => null,
        };

        return match (true) {
            $aile === 'AHCI' => ['kaynak' => 'AHCI', 'uyari' => null],
            $aile === 'ESCI' => ['kaynak' => 'ESCI', 'uyari' => null],
            $aile === 'TR Dizin' => ['kaynak' => 'TR Dizin', 'uyari' => null],
            $aile === null => ['kaynak' => $this->hakemliUlusal($sekme, $rozet), 'uyari' => null],
            $ceyrek !== null => ['kaynak' => "{$aile} ({$ceyrek})", 'uyari' => null],
            default => [
                'kaynak' => null,
                'uyari' => "{$aile} — çeyrekliği (Q1–Q4) bu kayıtta yazmıyor, kademeyi siz seçin.",
            ],
        };
    }

    /**
     * Çekirdek indekste olmayan makalenin kademesi.
     *
     * YALNIZ ULUSAL SEKMEDE ve yalnız "Hakemli" rozeti varsa yazılıyor:
     * o ikisi birlikte sözlükteki "Diğer Ulusal Hakemli" satırının tam
     * tanımı.
     *
     * ULUSLARARASI SEKMEDE YAZILMIYOR. Orada indeks rozeti "Index
     * Copernicus", "DRJI", "google scholar" gibi şeyler taşıyor ve
     * bunların "Diğer Uluslararası İndeks" sayılıp sayılmayacağı
     * yönergeden yönergeye değişiyor; adına bakıp karar vermek fazla
     * saymak olurdu.
     *
     * @param  array<string, string>  $rozet
     */
    private function hakemliUlusal(string $sekme, array $rozet): ?string
    {
        return preg_match('/^ulusal$/iu', trim($sekme)) === 1
            && preg_match('/hakemli/iu', $rozet['primary'] ?? '') === 1
                ? 'Diğer Ulusal Hakemli'
                : null;
    }

    /**
     * Bildirinin kademesi: sekme (uluslararası/ulusal) + tür rozeti.
     *
     * CPCI ayrımı yazmıyor, bu yüzden "Uluslararası Tam Metin (CPCI)" değil
     * bir alt kademe olan "Uluslararası Tam Metin" yazılıyor (§0: eksik
     * say, fazla sayma).
     *
     * @param  array<string, string>  $rozet
     */
    private function bildiri(string $sekme, array $rozet): ?string
    {
        $yer = match (true) {
            (bool) preg_match('/uluslararas/iu', $sekme) => 'Uluslararası',
            (bool) preg_match('/ulusal/iu', $sekme) => 'Ulusal',
            default => null,
        };

        if ($yer === null) {
            return null;
        }

        $tur = $rozet['primary'] ?? '';

        return match (true) {
            (bool) preg_match('/davetli/iu', $tur) => "Davetli Konuşmacı ({$yer})",
            (bool) preg_match('/tam metin/iu', $tur) => "{$yer} Tam Metin",
            (bool) preg_match('/[öo]zet|poster/iu', $tur) => "{$yer} Özet/Poster",
            default => null,
        };
    }

    /**
     * Kitabın kademesi.
     *
     * ULUSLARARASI/ULUSAL AYRIMI YOK: bu bölümün sekmeleri "Kitap" ve
     * "Kitap Bölümü", yani tür ekseni. Ayrımı gözetmeyen ortak etiketler
     * yazılıyor; ayrımı arayan yönergede kayıt eşleşmez, bu da fazla
     * saymaktan iyidir.
     *
     * @param  array<string, string>  $rozet
     */
    private function kitapTuru(string $sekme, array $rozet, string $metin): string
    {
        if (preg_match('/kitap b[öo]l[üu]m/iu', $sekme) === 1 || preg_match('/B[öo]l[üu]m Ad[ıi]\s*:/iu', $metin) === 1) {
            return 'Kitap Bölümü';
        }

        return match (true) {
            (bool) preg_match('/ders kitab|metot/iu', $rozet['info'] ?? '') => 'Ders / Metot Kitabı',
            (bool) preg_match('/ansiklopedi/iu', $metin) => 'Ansiklopedi Maddesi',
            default => 'Uluslararası/Ulusal Kitap',
        };
    }

    /**
     * Editörlüğün kademesi: görev rozeti, sonra derginin indeksi.
     *
     * Çeyreklik bu bölümde YAZMIYOR (rozet sırası dergi türü / indeks /
     * görev). WoS ve Scopus dergilerinde kademe bu yüzden boş kalıyor:
     * sözlükte o aileler yalnız çeyrekli duruyor.
     *
     * @param  array<string, string>  $rozet
     * @return array{kategori: string, kaynak: string|null, uyari?: string|null}
     */
    private function editorluk(array $rozet): array
    {
        $gorev = $rozet['danger'] ?? '';
        $tur = $rozet['primary'] ?? '';
        $indeks = $rozet['info'] ?? '';

        if (preg_match('/kitap/iu', $tur) === 1) {
            return ['kategori' => 'editorluk', 'kaynak' => 'Kitap Editörlüğü'];
        }

        if (preg_match('/yay[ıi]n kurulu|editorial board/iu', $gorev) === 1) {
            return ['kategori' => 'editorluk', 'kaynak' => 'Yayın Kurulu Üyeliği'];
        }

        if (preg_match('/hakem/iu', $gorev) === 1) {
            return ['kategori' => 'editorluk', 'kaynak' => 'Hakemlik'];
        }

        return match (true) {
            (bool) preg_match('/\besci\b|emerging sources/iu', $indeks) => [
                'kategori' => 'editorluk', 'kaynak' => 'ESCI Dergi',
            ],
            (bool) preg_match('/tr.?d[İIıi]z[İIıi]n|trdizin/iu', $indeks) => [
                'kategori' => 'editorluk', 'kaynak' => 'TR Dizin Dergi',
            ],
            (bool) preg_match('/scopus/iu', $indeks) => [
                'kategori' => 'editorluk', 'kaynak' => null,
                'uyari' => 'Scopus — çeyrekliği (Q1–Q4) bu kayıtta yazmıyor, kademeyi siz seçin.',
            ],
            (bool) preg_match('/sci.?expanded|\bscie\b|\bssci\b|\bahci\b|\bwos\b/iu', $indeks) => [
                'kategori' => 'editorluk', 'kaynak' => null,
                'uyari' => 'WoS — çeyrekliği (Q1–Q4) bu kayıtta yazmıyor, kademeyi siz seçin.',
            ],
            default => ['kategori' => 'editorluk', 'kaynak' => null],
        };
    }

    /**
     * Patent kademesi.
     *
     * Türü künyede açıkça yazıyorsa o; yazmıyorsa sekmenin ulusal/
     * uluslararası ayrımı. Sekme bu bölümde gerçekten kapsamı anlatıyor
     * (kayıt "Uluslararası kategoride patent" başlığı altında duruyor).
     */
    private function patent(string $sekme, string $metin): ?string
    {
        $tur = match (true) {
            (bool) preg_match('/faydal[ıi] model/iu', $metin) => 'Faydalı Model',
            (bool) preg_match('/end[üu]striyel tasar[ıi]m/iu', $metin) => 'Endüstriyel Tasarım',
            (bool) preg_match('/[ıi]slah[çc][ıi]|[çc]e[şs]it tescil/iu', $metin) => 'Islahçı Hakkı / Çeşit Tescili',
            (bool) preg_match('/yaz[ıi]l[ıi]m/iu', $metin) => 'Yazılım',
            default => null,
        };

        if ($tur !== null) {
            return $tur;
        }

        return match (true) {
            (bool) preg_match('/uluslararas/iu', $sekme) => 'Uluslararası Patent',
            (bool) preg_match('/ulusal/iu', $sekme) => 'Ulusal Patent',
            default => null,
        };
    }

    /**
     * Ödülün kademesi — yalnız veren kurum adından KESİN çıkanlar.
     *
     * "Sözel sunum 3. Ödülü" gibi serbest metinler boş bırakılıyor:
     * yarışma derecesi mi ulusal bilim ödülü mü, künyeden anlaşılmıyor.
     */
    private function odul(string $metin): ?string
    {
        return match (true) {
            (bool) preg_match('/geb[İIıi]p|twas/iu', $metin) => 'TÜBA GEBİP / TWAS Teşvik Ödülü',
            (bool) preg_match('/t[üu]b[İIıi]tak|t[üu]ba\b/iu', $metin) => 'TÜBİTAK / TÜBA Ödülü',
            (bool) preg_match('/\by[öo]k\b/iu', $metin) => 'YÖK Ödülü',
            (bool) preg_match('/\berc\b|ufuk avrupa|horizon/iu', $metin) => 'Ufuk Avrupa / ERC Ödülü',
            (bool) preg_match('/burs|scholarship|fellowship/iu', $metin) => 'Burs',
            default => null,
        };
    }

    private function tez(string $metin): ?string
    {
        return match (true) {
            (bool) preg_match('/t[ıi]pta uzmanl[ıi]k|di[şs] hekimli[ğg]i|sanatta yeterlik|yan dal/iu', $metin) => 'Tıpta/Diş/Sanatta Yeterlik Tezi',
            (bool) preg_match('/doktora/iu', $metin) => 'Doktora Tezi',
            (bool) preg_match('/y[üu]ksek lisans/iu', $metin) => 'Yüksek Lisans Tezi',
            default => null,
        };
    }

    /**
     * İdari görev unvanı → kademe. Sıra önemli: "Müdür Yardımcısı"
     * "Müdür"den ÖNCE denenmeli, yoksa yardımcılık müdürlük sayılır.
     */
    private function gorev(string $baslik): ?string
    {
        return match (true) {
            (bool) preg_match('/rekt[öo]r yard/iu', $baslik) => 'Rektör Yardımcısı',
            (bool) preg_match('/rekt[öo]r/iu', $baslik) => 'Rektör',
            (bool) preg_match('/(dekan|m[üu]d[üu]r) yard/iu', $baslik) => 'Dekan Yrd. / Müdür Yrd.',
            (bool) preg_match('/uygulama ve ara[şs]t[ıi]rma merkez/iu', $baslik) => 'Uygulama ve Araştırma Merkezi Müdürü',
            (bool) preg_match('/dekan|enstit[üu] m[üu]d[üu]r|y[üu]ksekokul m[üu]d[üu]r/iu', $baslik) => 'Dekan / Enstitü-YO Müdürü',
            (bool) preg_match('/b[öo]l[üu]m ba[şs]kan yard/iu', $baslik) => 'Bölüm Başkan Yardımcısı',
            (bool) preg_match('/b[öo]l[üu]m ba[şs]kan/iu', $baslik) => 'Bölüm Başkanı',
            (bool) preg_match('/anabilim dal[ıi]|koordinat[öo]r/iu', $baslik) => 'Anabilim Dalı Başkanı / Koordinatörlük',
            (bool) preg_match('/kurul|komisyon/iu', $baslik) => 'Kurul / Komisyon Üyeliği',
            default => null,
        };
    }

    private function fon(string $metin): ?string
    {
        foreach (self::FONLAR as $fon) {
            if (preg_match($fon['desen'], $metin) === 1) {
                return $fon['kaynak'];
            }
        }

        return null;
    }

    private function rol(string $metin): ?string
    {
        foreach (self::ROLLER as $desen => $rol) {
            if (preg_match($desen, $metin) === 1) {
                return $rol;
            }
        }

        return null;
    }

    /**
     * "Deneyimler" bölümü — zaman tüneli düzeni, callout yok.
     *
     * YALNIZ İDARİ GÖREVLER alınıyor. "Akademik Görevler" adayın unvan
     * geçmişi (profesörlük, doçentlik), "Üniversite Dışı Deneyimler" ise
     * özgeçmiş bilgisi; ikisi de puanlanan bir faaliyet değil. Sayıları
     * yine de atlanan olarak bildiriliyor ki aday "eksik geldi" sanmasın.
     *
     * @return list<Kayit>
     */
    private function deneyimler(string $html): array
    {
        $kayitlar = [];

        foreach ($this->sekmeler($html) as [$sekme, $govde]) {
            $idari = preg_match('/[İIıi]dari g[öo]rev/iu', $sekme) === 1;

            foreach (preg_split('~(?=<div class="timeline timeline-inverse")~', $govde) ?: [] as $blok) {
                if (preg_match('~<h3 class="timeline-header">\s*<a[^>]*>(.*?)</a>~s', $blok, $esles) !== 1) {
                    continue;
                }

                $baslik = $this->duz($esles[1]);

                if ($baslik === '') {
                    continue;
                }

                if (! $idari) {
                    $kayitlar[] = ['atlandi' => true] + $this->bosKayit();

                    continue;
                }

                $kurum = preg_match('~<div class="timeline-body">(.*?)</div>~s', $blok, $g) === 1
                    ? $this->duz($g[1])
                    : '';

                // Zaman tünelinde iki etiket var: üstte bitiş ("Devam
                // ediyor" ya da yıl), altta başlangıç yılı. Sonuncusu
                // alınıyor: görevin başladığı yıl.
                $yil = $this->yil($this->duz($blok));

                $kayitlar[] = [
                    'id' => 'x:'.md5('deneyimler|'.$baslik.'|'.$kurum.'|'.($yil ?? '')),
                    'kategori' => 'idari_gorev',
                    'baslik' => $baslik,
                    'yazarlar' => '',
                    'kunye' => trim('İdari Görev'.($kurum !== '' ? " · {$kurum}" : ''), ' ·'),
                    'yil' => $yil,
                    'doi' => null,
                    'kaynak' => $this->gorev($baslik),
                    'uyari' => null,
                    'rol' => null,
                    'atlandi' => false,
                ];
            }
        }

        return $kayitlar;
    }

    /**
     * Sayfadaki sekmeler: etiket + gövde.
     *
     * Etiket sekme çubuğundaki bağlantıdan geliyor; yanındaki kayıt sayısı
     * rozeti atılıyor. Sekmesiz bölümlerde (Ödüller) etiket boş kalır.
     *
     * @return list<array{0: string, 1: string}>
     */
    private function sekmeler(string $html): array
    {
        $etiketler = [];

        preg_match_all('~<a[^>]*href="#(custom-content-above-[a-z]+)"[^>]*>(.*?)</a>~s', $html, $baglar, PREG_SET_ORDER);

        foreach ($baglar as $bag) {
            $etiketler[$bag[1]] = $this->duz(
                preg_replace('~<span class="kucuk_sayi_iconu.*?</span>~s', ' ', $bag[2]) ?? $bag[2]
            );
        }

        $sekmeler = [];

        foreach (preg_split('~(?=<div class="tab-pane)~', $html) ?: [] as $blok) {
            if (preg_match('~^<div class="tab-pane[^>]*id="([^"]+)"~', $blok, $esles) !== 1) {
                continue;
            }

            $sekmeler[] = [$etiketler[$esles[1]] ?? '', $blok];
        }

        return $sekmeler;
    }

    /**
     * Kutunun rozetleri: sınıf → ilk dolu değer.
     *
     * Rozet sırası bölüme göre anlam değiştiriyor (makalede success=yıl,
     * info=indeks, danger=çeyreklik; projede success=durum, primary=fon,
     * info=görev), bu yüzden burada yorumlanmıyor; {@see self::esleme}
     * hangi rozetin ne olduğunu biliyor.
     *
     * @return array<string, string>
     */
    private function rozetler(string $oge): array
    {
        preg_match_all('~<span class="badge badge-([a-z]+)[^"]*">(.*?)</span>~s', $oge, $esles, PREG_SET_ORDER);

        $rozetler = [];

        foreach ($esles as $rozet) {
            $deger = $this->duz($rozet[2]);

            if ($deger !== '' && ! isset($rozetler[$rozet[1]])) {
                $rozetler[$rozet[1]] = $deger;
            }
        }

        return $rozetler;
    }

    /**
     * Parçayı ilk `<div>`inin kapandığı yerde keser.
     *
     * Kutular bir sonraki kutunun başından bölünüyor; SON kutunun ardından
     * sayfanın geri kalanı (alt bilgi, "Bu sistemdeki veriler…", "BAUM 2024
     * © Mersin Üniversitesi") da parçaya giriyordu. Kitapta yazar satırı
     * SON satır olduğu için alt bilgi yazar diye kaydediliyordu.
     */
    private static function ilkDiv(string $html): string
    {
        if (preg_match_all('~<(/?)div\b[^>]*>~i', $html, $etiketler, PREG_OFFSET_CAPTURE) === 0) {
            return $html;
        }

        $derinlik = 0;

        foreach ($etiketler[0] as $sira => [$etiket, $konum]) {
            $derinlik += $etiketler[1][$sira][0] === '/' ? -1 : 1;

            if ($derinlik === 0) {
                return substr($html, 0, $konum + strlen($etiket));
            }
        }

        return $html;
    }

    /**
     * Kutunun künye satırları — rozetler, görseller ve başlık dışındakiler.
     *
     * @return list<string>
     */
    private function satirlar(string $oge): array
    {
        $govde = preg_replace('~<h5[^>]*>.*?</h5>~s', ' ', $oge) ?? $oge;
        $govde = preg_replace('~<span class="badge[^"]*">.*?</span>~s', ' ', $govde) ?? $govde;
        $govde = preg_replace('~<a class="badge"[^>]*>.*?</a>~s', ' ', $govde) ?? $govde;
        $govde = preg_replace('~<img[^>]*>~', ' ', $govde) ?? $govde;

        $satirlar = [];

        foreach (preg_split('~</?(?:p|div)[^>]*>~', $govde) ?: [] as $parca) {
            $metin = $this->duz($parca);

            if ($metin !== '' && $metin !== '–' && $metin !== '-') {
                $satirlar[] = $metin;
            }
        }

        return $satirlar;
    }

    /**
     * Yazar satırı ile künye satırını ayırır.
     *
     * Yayın kutularında düzen sabit: makale ve bildiride ilk satır künye
     * (dergi/kongre), ikincisi yazarlar. Kitapta yazarlar SONDA; "Yayın
     * Evi:" ve "Bölüm Adı:" ile başlayan satırlar künyenin kendisi.
     *
     * @param  list<string>  $satirlar
     * @return array{0: string, 1: string} yazarlar, künye
     */
    private function kunye(string $bolum, array $satirlar): array
    {
        if ($satirlar === []) {
            return ['', ''];
        }

        if (in_array($bolum, ['makaleler', 'bildiriler'], true)) {
            return [$satirlar[1] ?? '', $satirlar[0]];
        }

        if ($bolum === 'kitaplar') {
            $son = end($satirlar);

            if (preg_match('/^(Yay[ıi]n Evi|B[öo]l[üu]m Ad[ıi])\s*:/iu', $son) === 1) {
                return ['', implode(' · ', $satirlar)];
            }

            return [$son, implode(' · ', array_slice($satirlar, 0, -1))];
        }

        return ['', implode(' · ', $satirlar)];
    }

    /**
     * DOI, kayıt kutusundaki "Link" rozetinde duruyor.
     */
    private function doi(string $oge): ?string
    {
        if (preg_match('~href="https?://(?:dx\.)?doi\.org/(10\.[^"\s]+)~i', $oge, $esles) === 1) {
            return mb_strtolower(rtrim(urldecode($esles[1]), '.'));
        }

        return null;
    }

    private function yil(string $metin): ?int
    {
        preg_match_all('~\b(19\d\d|20\d\d)\b~', $metin, $yillar);

        return $yillar[1] === [] ? null : (int) end($yillar[1]);
    }

    /**
     * @return Kayit
     */
    private function bosKayit(): array
    {
        return [
            'id' => '', 'kategori' => '', 'baslik' => '', 'yazarlar' => '', 'kunye' => '',
            'yil' => null, 'doi' => null, 'kaynak' => null, 'uyari' => null, 'rol' => null,
            'atlandi' => true,
        ];
    }

    private function getir(string $adres): ?string
    {
        try {
            $yanit = Http::withUserAgent(self::TARAYICI)->timeout(self::ZAMAN_ASIMI)->get($adres);
        } catch (ConnectionException) {
            return null;
        }

        return $yanit->successful() ? $yanit->body() : null;
    }

    private function duz(string $ham): string
    {
        $metin = html_entity_decode(strip_tags($ham), ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return trim((string) preg_replace('/\s+/u', ' ', $metin));
    }
}
