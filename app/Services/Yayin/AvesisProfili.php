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
 *     kaynak: string|null,
 *     uyari: string|null,
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
            'kaynak' => $indeks['kaynak'],
            'uyari' => $indeks['uyari'],
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
                    // Bitiş yılı: yönergeler tamamlanmış projeyi sayıyor.
                    // Süren projede yıl boş kalıyor, aday kendisi girecek.
                    'yil' => $this->projeYili($oge),
                    'kaynak' => $this->fon($duz),
                    'uyari' => null,
                ];
            }
        }

        return $kayitlar;
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
