<?php

namespace App\Services\Yayin;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * AVESİS akademik profilinden faaliyet okur.
 *
 * NEDEN GEREKLİ: Crossref ile DergiPark yalnız YAYIN veriyor; 15 faaliyet
 * kategorisinin 3'ü. AVESİS adayın kendi tuttuğu künye — projeler, dersler,
 * jüri üyelikleri, ödüller hep orada. Üstelik yayında DERGİ İNDEKSİNİ de
 * taşıyor: `data-filters="esci,scopus"` gibi makine okunur anahtarlarla.
 * Bu, puanı belirleyen alanı doğrudan doldurabildiğimiz tek kaynak.
 *
 * TEK KURULUM YOK: AVESİS her üniversitede ayrı (avesis.ktu.edu.tr,
 * avesis.deu.edu.tr…). Ortak bir API de yok. Ama yazılım aynı: robots.txt'si
 * de sayfa yapısı da bire bir eşleşiyor, o yüzden tek okuyucu hepsini
 * karşılıyor. Aday kendi profil adresini veriyor.
 *
 * ROBOTS: AVESİS yalnız indirme uçlarını (/*\/indir*, /*\/download*),
 * /journal/*, /nr/* ve birkaç grafik ucunu kapatıyor; profil sayfaları
 * serbest ve site kendi sitemap'ini yayımlıyor.
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
 *     atlandi: bool,
 * }
 */
class AvesisProfili
{
    private const TARAYICI = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) '
        .'AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0 Safari/537.36';

    /** Profil içeriği aday güncelledikçe değişiyor; kopya kısa ömürlü. */
    private const OMUR = 60 * 60 * 6;

    /**
     * AVESİS'in yayın listesindeki indeks anahtarları → sözlükteki kademe.
     *
     * `sci_ssci_ahci` ve `scopus` için kademe YAZILMIYOR: sözlükte o
     * kademeler yalnız çeyrekli var (Q1–Q4) ve çeyreklik bu listede yok.
     * Uydurmak adayın hak etmediği yönergeyi "uygun" gösterirdi.
     *
     * `sci_ssci_ahci_esci` bir ÜST KÜME anahtarı (ESCI'li kayıtta da
     * görünüyor), tek başına bir şey söylemiyor; yok sayılıyor.
     *
     * @var array<string, array{kaynak: string|null, ad: string}>
     */
    private const INDEKSLER = [
        'sci_ssci_ahci' => ['kaynak' => null, 'ad' => 'SCI-E/SSCI/AHCI'],
        'esci' => ['kaynak' => 'ESCI', 'ad' => 'ESCI'],
        'scopus' => ['kaynak' => null, 'ad' => 'Scopus'],
        'trdizin' => ['kaynak' => 'TR Dizin', 'ad' => 'TR Dizin'],
    ];

    /** Proje fon programı → sözlükteki kademe. Sıra önemli: ilk eşleşen. */
    private const FONLAR = [
        ['desen' => '/t[üu]b[İIıi]tak/iu', 'kaynak' => 'TÜBİTAK'],
        ['desen' => '/t[üu]seb/iu', 'kaynak' => 'TÜSEB'],
        ['desen' => '/ufuk|horizon|[çc]er[çc]eve/iu', 'kaynak' => 'AB Çerçeve / Ufuk'],
        ['desen' => '/2209|[öo][ğg]renci/iu', 'kaynak' => 'Öğrenci Projesi (2209 vb.)'],
        ['desen' => '/y[üu]ksek[öo][ğg]retim kurumlar|\bbap\b/iu', 'kaynak' => 'BAP (Üniversite)'],
        ['desen' => '/di[ğg]er uluslararas/iu', 'kaynak' => 'Diğer Uluslararası Fon'],
        ['desen' => '/[öo]zel sekt[öo]r|sanayi|stk/iu', 'kaynak' => 'Özel Sektör / STK'],
        ['desen' => '/kamu/iu', 'kaynak' => 'Diğer Kamu Kurumu'],
    ];

    /**
     * Profil adresini ayrıştırır.
     *
     * SUNUCU ADI SIKI SÜZÜLÜYOR: adresi aday veriyor ve isteği biz
     * atıyoruz. `avesis.<bir şey>.edu.tr` dışına çıkılmazsa bu alan bir
     * SSRF kapısı olamaz.
     *
     * @return array{taban: string, kullanici: string}|null
     */
    public function adres(string $girdi): ?array
    {
        $girdi = trim($girdi);

        if (preg_match('~^(?:https?://)?(avesis\.[a-z0-9\-]+(?:\.[a-z0-9\-]+)*\.edu\.tr)/([A-Za-z0-9._\-]{2,60})~i', $girdi, $esles) !== 1) {
            return null;
        }

        $kullanici = $esles[2];

        // Profil değil, sitenin kendi sayfaları.
        if (in_array(mb_strtolower($kullanici), ['yayin', 'proje', 'arama', 'researcher', 'yayinlar', 'projeler', 'detayli-arama', 'hakkinda', 'iletisim', 'home', 'user', 'content'], true)) {
            return null;
        }

        return ['taban' => 'https://'.mb_strtolower($esles[1]), 'kullanici' => $kullanici];
    }

    /**
     * Profildeki yayınlar ve projeler.
     *
     * @param  array{taban: string, kullanici: string}  $adres
     * @return list<Kayit>
     */
    public function kayitlar(array $adres): array
    {
        $anahtar = 'avesis.'.md5($adres['taban'].'/'.$adres['kullanici']);

        return Cache::remember($anahtar, self::OMUR, fn (): array => [
            ...$this->yayinlar($adres),
            ...$this->projeler($adres),
            ...$this->sayfa($adres, 'bilimselfaaliyetler'),
            ...$this->sayfa($adres, 'deneyim'),
            ...$this->sayfa($adres, 'basarilar'),
        ]);
    }

    /**
     * @param  array{taban: string, kullanici: string}  $adres
     * @return list<Kayit>
     */
    private function yayinlar(array $adres): array
    {
        $html = $this->getir("{$adres['taban']}/{$adres['kullanici']}/yayinlar");

        if ($html === null) {
            return [];
        }

        $kayitlar = [];

        foreach ($this->bolumler($html) as [$bolumAdi, $govde]) {
            $kategori = match (true) {
                (bool) preg_match('/makale/iu', $bolumAdi) => 'makale',
                (bool) preg_match('/bildiri/iu', $bolumAdi) => 'bildiri',
                (bool) preg_match('/kitap/iu', $bolumAdi) => 'kitap',
                default => null,
            };

            if ($kategori === null) {
                continue;
            }

            foreach (preg_split('~(?=<div class="pub-item)~', $govde) ?: [] as $oge) {
                $kayit = $this->yayin($oge, $kategori);

                if ($kayit !== null) {
                    $kayitlar[] = $kayit;
                }
            }
        }

        return $kayitlar;
    }

    /**
     * @return Kayit|null
     */
    private function yayin(string $oge, string $kategori): ?array
    {
        if (preg_match('~href="/yayin/([0-9a-f\-]{36})/[^"]*"[^>]*>(.*?)</a>~s', $oge, $bag) !== 1) {
            return null;
        }

        $baslik = $this->baslik($bag[2]);

        if ($baslik === '') {
            return null;
        }

        // İki `citation` bloğu var: ilki yazarlar, ikincisi künye satırı
        // ("Dergi Adı, cilt.23, sa.1, 2026 (ESCI, Scopus)").
        preg_match_all('~<div class="citation"[^>]*>(.*?)</div>~s', $oge, $bloklar);

        $yazarlar = $this->duz($bloklar[1][0] ?? '');
        $kunye = $this->duz($bloklar[1][1] ?? '');
        $indeks = $this->indeks($oge);

        return [
            'id' => $bag[1],
            'kategori' => $kategori,
            'baslik' => $baslik,
            'yazarlar' => $yazarlar,
            'kunye' => $kunye,
            'yil' => $this->yil($kunye),
            'doi' => $this->doi($oge),
            'kaynak' => $indeks['kaynak'],
            'uyari' => $indeks['uyari'],
            'atlandi' => false,
        ];
    }

    /**
     * @param  array{taban: string, kullanici: string}  $adres
     * @return list<Kayit>
     */
    private function projeler(array $adres): array
    {
        $html = $this->getir("{$adres['taban']}/{$adres['kullanici']}/projeler");

        if ($html === null) {
            return [];
        }

        $kayitlar = [];

        foreach ($this->bolumler($html) as [, $govde]) {
            foreach (preg_split('~(?=<h3 class="project-item)~', $govde) ?: [] as $oge) {
                if (preg_match('~href="/proje/([0-9a-f\-]{36})/[^"]*"[^>]*>(.*?)</a>~s', $oge, $bag) !== 1) {
                    continue;
                }

                $baslik = $this->baslik($bag[2]);

                if ($baslik === '') {
                    continue;
                }

                $duz = $this->duz($oge);

                $kayitlar[] = [
                    'id' => $bag[1],
                    'kategori' => 'proje',
                    'baslik' => $baslik,
                    'yazarlar' => '',
                    'kunye' => $duz,
                    'doi' => null,
                    // Bitiş yılı: yönergeler tamamlanmış projeyi sayıyor.
                    // Süren projede yıl boş kalıyor, aday kendisi girecek.
                    'yil' => $this->projeYili($oge),
                    'kaynak' => $this->fon($duz),
                    'uyari' => null,
                    'atlandi' => false,
                ];
            }
        }

        return $kayitlar;
    }

    /**
     * Bölüm adı → hangi kategori, hangi kademe.
     *
     * Eşlenemeyen bölümler bilerek listede yok:
     *   "Akademik Ünvanlar" ve "Akademi Dışı Deneyim" profil bilgisi,
     *   faaliyet değil. Jüri üyeliklerinin tez dışı olanları (personel
     *   sınavı, doçentlik sınavı) ve kongrelere yalnız KATILIMCI olarak
     *   gidilenler sözlükte karşılığı olmadığı için atlanıyor — uydurma
     *   bir kategoriye atmak adayın listesini kirletirdi, üstelik salt
     *   katılımı puanlanan bir kademeye yazmak fazla saymak olurdu.
     *   Atlananların sayısı ekranda yazıyor.
     *
     * @return array{kategori: string, kaynak: string|null}|null
     */
    private function bolumEslemesi(string $bolum, string $baslik, string $aciklama): ?array
    {
        $metin = $baslik.' '.$aciklama;

        return match (true) {
            // ── /deneyim
            (bool) preg_match('/y[öo]netimsel g[öo]rev/iu', $bolum) => [
                'kategori' => 'idari_gorev', 'kaynak' => $this->gorev($baslik),
            ],
            (bool) preg_match('/verdi[ğg]i ders/iu', $bolum) => [
                'kategori' => 'egitim_ogretim', 'kaynak' => $this->ders($aciklama),
            ],
            (bool) preg_match('/y[öo]netilen tez/iu', $bolum) => [
                'kategori' => 'tez_danismanligi', 'kaynak' => $this->tez($aciklama),
            ],

            // ── /bilimselfaaliyetler
            (bool) preg_match('/dergilerdeki faaliyet/iu', $bolum) => [
                'kategori' => 'editorluk', 'kaynak' => 'Yayın Kurulu Üyeliği',
            ],
            (bool) preg_match('/yay[ıi]nlarda hakemlik/iu', $bolum) => [
                'kategori' => 'editorluk', 'kaynak' => 'Hakemlik',
            ],
            // Proje hakemliği yayın hakemliği değil: kademe boş, aday seçer.
            (bool) preg_match('/projelerde hakemlik/iu', $bolum) => [
                'kategori' => 'editorluk', 'kaynak' => null,
            ],
            (bool) preg_match('/kurulu[şs]lardaki [üu]yelik/iu', $bolum) => [
                'kategori' => 'idari_gorev',
                // Kurumun kendi kurulu mu dış kuruluş mu, künyeden
                // anlaşılmıyor; kademe boş bırakılıyor.
                'kaynak' => null,
            ],
            (bool) preg_match('/yay[ıi]nc[ıi]l[ıi]k etkinli/iu', $bolum) => [
                'kategori' => 'toplumsal_katki', 'kaynak' => 'Bilim İletişimi / Popüler Yayın',
            ],
            (bool) preg_match('/bilimsel dan[ıi][şs]manl[ıi]k/iu', $bolum) => [
                'kategori' => 'toplumsal_katki', 'kaynak' => null,
            ],
            (bool) preg_match('/j[üu]ri [üu]yelik/iu', $bolum) => preg_match('/tez|yeterlik/iu', $metin) === 1
                ? ['kategori' => 'tez_danismanligi', 'kaynak' => 'Tez İzleme / Jüri Üyeliği']
                : null,

            // ── /basarilar
            (bool) preg_match('/[öo]d[üu]l/iu', $bolum) => [
                'kategori' => 'odul', 'kaynak' => $this->odul($baslik.' '.$aciklama),
            ],
            (bool) preg_match('/kongre ve sempozyum/iu', $bolum) => $this->toplanti($metin),

            default => null,
        };
    }

    /**
     * Ödülün kademesi — yalnız veren kurum adından KESİN çıkanlar.
     *
     * "Sözel sunum 3. Ödülü" gibi serbest metinler boş bırakılıyor:
     * yarışma derecesi mi ulusal bilim ödülü mü, künyeden anlaşılmıyor ve
     * yanlış kademe adayın hak etmediği puanı verirdi.
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

    /**
     * Kongre/sempozyum katılımı — rolüne göre.
     *
     * Salt KATILIMCI olunan toplantı atlanıyor: sözlükte puanlanan bir
     * karşılığı yok ve bir adayın profilinde yüzlercesi olabiliyor.
     *
     * Ulusal/uluslararası ayrımı künyeden KESİN çıkmıyor (Türkiye'de
     * yapılan uluslararası kongre de var), bu yüzden kademe boş; aday
     * seçiyor.
     *
     * @return array{kategori: string, kaynak: string|null}|null
     */
    private function toplanti(string $metin): ?array
    {
        return match (true) {
            (bool) preg_match('/davetli konu[şs]mac[ıi]/iu', $metin) => ['kategori' => 'bildiri', 'kaynak' => null],
            (bool) preg_match('/oturum ba[şs]kan|panelist|moderat[öo]r/iu', $metin) => ['kategori' => 'diger', 'kaynak' => null],
            (bool) preg_match('/d[üu]zenleme kurulu|bilim kurulu/iu', $metin) => ['kategori' => 'diger', 'kaynak' => null],
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

    private function ders(string $metin): ?string
    {
        return match (true) {
            // "Yüksek Lisans" içinde "Lisans" geçiyor: üstü önce denenmeli.
            (bool) preg_match('/y[üu]ksek lisans|doktora|lisans[üu]st[üu]/iu', $metin) => 'Lisansüstü Ders',
            (bool) preg_match('/[öo]n ?lisans|lisans/iu', $metin) => 'Lisans/Önlisans Ders',
            default => null,
        };
    }

    private function tez(string $metin): ?string
    {
        return match (true) {
            (bool) preg_match('/t[ıi]pta uzmanl[ıi]k|di[şs] hekimli[ğg]i|sanatta yeterlik/iu', $metin) => 'Tıpta/Diş/Sanatta Yeterlik Tezi',
            (bool) preg_match('/doktora/iu', $metin) => 'Doktora Tezi',
            (bool) preg_match('/y[üu]ksek lisans/iu', $metin) => 'Yüksek Lisans Tezi',
            default => null,
        };
    }

    /**
     * Bölümlü bir profil sayfasını (bilimselfaaliyetler, deneyim) okur.
     *
     * Bu sayfalarda yayınlardaki gibi her kayda düşen bir kimlik yok.
     * Kimliği olmayan kayda künyeden TÜRETİLMİŞ bir kimlik veriliyor
     * (bölüm + başlık + dönem): aynı görevi iki ayrı dönem yapmış aday
     * ikisini de eklesin, aynı kayıt iki kez eklenmesin.
     *
     * @param  array{taban: string, kullanici: string}  $adres
     * @return list<Kayit>
     */
    private function sayfa(array $adres, string $yol): array
    {
        $html = $this->getir("{$adres['taban']}/{$adres['kullanici']}/{$yol}");

        if ($html === null) {
            return [];
        }

        $kayitlar = [];

        foreach ($this->bolumler($html) as [$bolumAdi, $govde]) {
            foreach (preg_split('~(?=<li[\s>])~', $govde) ?: [] as $oge) {
                if (! str_contains($oge, 'class="title"')) {
                    continue;
                }

                foreach ($this->ogeler($oge, $bolumAdi) as $kayit) {
                    $kayitlar[] = $kayit;
                }
            }
        }

        return $kayitlar;
    }

    /**
     * Bir `<li>` içindeki kayıt(lar).
     *
     * ÇOĞUL: "Verdiği Dersler" bölümünde tek bir `<li>` aynı düzeydeki
     * birkaç dersi birden taşıyor (düzey etiketi ortak, her ders ayrı
     * başlık).
     *
     * @return list<Kayit>
     */
    private function ogeler(string $oge, string $bolumAdi): array
    {
        $etiket = preg_match('~<span class="shaded-label">(.*?)</span>~s', $oge, $e) === 1 ? $this->duz($e[1]) : '';
        $duzey = preg_match('~<span style="font-size: 90%[^"]*">(.*?)</span>~s', $oge, $e) === 1 ? $this->duz($e[1]) : '';
        // Kimi kayıtta başlık bağlantısı boş ve asıl ad `citation`'da
        // duruyor (Yayıncılık Etkinlikleri'nde "TV Programı" gibi).
        $kunyeAdi = preg_match('~<div class="citation"[^>]*>(.*?)</div>~s', $oge, $e) === 1 ? $this->duz($e[1]) : '';
        $aciklama = preg_match('~<div class="description">(.*?)</div>\s*</li>~s', $oge, $e) === 1
            ? $this->duz($e[1])
            : $this->duz(preg_replace('~<h3.*?</h3>~s', ' ', $oge) ?? '');

        preg_match_all('~<h3[^>]*class="title"[^>]*>(.*?)</h3>~s', $oge, $basliklar);

        $kayitlar = [];

        foreach ($basliklar[1] as $ham) {
            $baslik = $this->baslik(preg_replace('~<span class="shaded-label">.*?</span>~s', ' ', $ham) ?? $ham);

            if ($baslik === '') {
                $baslik = $kunyeAdi;
            }

            if ($baslik === '') {
                continue;
            }

            $esleme = $this->bolumEslemesi($bolumAdi, $baslik, $duzey.' '.$aciklama);

            if ($esleme === null) {
                $kayitlar[] = ['atlandi' => true] + $this->bosKayit();

                continue;
            }

            $kimlik = preg_match('~href="/[a-z\-]+/([0-9a-f\-]{36})/~', $ham, $e) === 1
                ? $e[1]
                : 'x:'.md5($bolumAdi.'|'.$baslik.'|'.$etiket);

            $kayitlar[] = [
                'id' => $kimlik,
                'kategori' => $esleme['kategori'],
                'baslik' => $baslik,
                'yazarlar' => '',
                'kunye' => trim($this->bolumAdi($bolumAdi).($etiket !== '' ? " · {$etiket}" : '').($aciklama !== '' ? " · {$aciklama}" : ''), ' ·'),
                'yil' => $this->yil($etiket) ?? $this->yil($aciklama),
                'doi' => null,
                'kaynak' => $esleme['kaynak'],
                'uyari' => null,
                'atlandi' => false,
            ];
        }

        return $kayitlar;
    }

    /**
     * Bölüm başlığındaki kayıt sayısı rozetini atar: "Verdiği Dersler 2"
     * değil "Verdiği Dersler".
     */
    private function bolumAdi(string $ham): string
    {
        return trim((string) preg_replace('~\s+\d+$~', '', $ham));
    }

    /**
     * @return Kayit
     */
    private function bosKayit(): array
    {
        return [
            'id' => '', 'kategori' => '', 'baslik' => '', 'yazarlar' => '', 'kunye' => '',
            'yil' => null, 'doi' => null, 'kaynak' => null, 'uyari' => null, 'atlandi' => true,
        ];
    }

    /**
     * Sayfadaki açılır bölümler: başlık + gövde.
     *
     * @return list<array{0: string, 1: string}>
     */
    private function bolumler(string $html): array
    {
        $bolumler = [];

        foreach (preg_split('~(?=<div class="ac-item)~', $html) ?: [] as $blok) {
            if (preg_match('~<div class="item-head[^"]*">(.*?)</div>~s', $blok, $bas) !== 1) {
                continue;
            }

            $bolumler[] = [$this->duz($bas[1]), $blok];
        }

        return $bolumler;
    }

    /**
     * İndeks anahtarlarından kademe. Birden çok anahtar varsa en üstteki
     * kazanıyor; {@see INDEKSLER} sırası kademe sırası.
     *
     * @return array{kaynak: string|null, uyari: string|null}
     */
    private function indeks(string $oge): array
    {
        if (preg_match('~data-filters="([^"]*)"~', $oge, $esles) !== 1) {
            return ['kaynak' => null, 'uyari' => null];
        }

        $anahtarlar = array_map('trim', explode(',', $esles[1]));

        foreach (self::INDEKSLER as $anahtar => $kademe) {
            if (! in_array($anahtar, $anahtarlar, true)) {
                continue;
            }

            return $kademe['kaynak'] !== null
                ? ['kaynak' => $kademe['kaynak'], 'uyari' => null]
                : ['kaynak' => null, 'uyari' => "{$kademe['ad']} — çeyrekliği (Q1–Q4) burada yazmıyor, kademeyi siz seçin."];
        }

        return ['kaynak' => null, 'uyari' => null];
    }

    /**
     * DOI, listenin kendisinde duruyor.
     *
     * Yayın künyesinde ayrı bir alan yok ama PlumX rozetinin adresinde
     * (`plu.mx/plum/a/?doi=10.…`) yazılı. Buradan alınması mükerrer
     * denetimini Crossref'ten gelen kayıtlarla eşleştiriyor; yoksa aynı
     * makale iki ayrı yoldan iki kez eklenebiliyordu.
     */
    private function doi(string $oge): ?string
    {
        foreach (['~[?&]doi=(10\.[^\s"&<>]+)~i', '~doi\.org/(10\.[^\s"<>]+)~i'] as $desen) {
            if (preg_match($desen, $oge, $esles) === 1) {
                return mb_strtolower(rtrim(urldecode($esles[1]), '.'));
            }
        }

        return null;
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

    private function projeYili(string $oge): ?int
    {
        if (preg_match('~<span class="shaded-label">(.*?)</span>~s', $oge, $esles) !== 1) {
            return null;
        }

        $yillar = [];
        preg_match_all('~\b(19\d\d|20\d\d)\b~', $this->duz($esles[1]), $yillar);

        return $yillar[1] === [] ? null : (int) end($yillar[1]);
    }

    private function yil(string $kunye): ?int
    {
        preg_match_all('~\b(19\d\d|20\d\d)\b~', $kunye, $yillar);

        return $yillar[1] === [] ? null : (int) end($yillar[1]);
    }

    /**
     * Başlık `<strong>` içinde; önündeki sıra numarası ("1.") ve AVESİS
     * verisinden gelen başıboş noktalama atılıyor.
     */
    private function baslik(string $ham): string
    {
        $govde = preg_match('~<strong[^>]*>(.*?)</strong>~s', $ham, $esles) === 1 ? $esles[1] : $ham;

        return trim($this->duz($govde), " .\u{00A0}");
    }

    private function getir(string $adres): ?string
    {
        try {
            $yanit = Http::withUserAgent(self::TARAYICI)->timeout(30)->get($adres);
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
