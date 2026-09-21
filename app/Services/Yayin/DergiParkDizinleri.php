<?php

namespace App\Services\Yayin;

use App\Models\Dergi;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

/**
 * Bir derginin dizin listesini DergiPark'tan okur.
 *
 * NEDEN BURADAN: puanı belirleyen dizin bilgisi (SCIE, ESCI, Scopus, TR
 * Dizin) künyede yok ve açık bir toplu listesi de yok — Scimago Cloudflare
 * arkasında, Clarivate lisanslı, TR Dizin'in kendi arama servisi hata
 * veriyor, OpenAlex'in Scopus bayrağı boş geliyor. DergiPark her derginin
 * dizinlerini kendi sayfasında yayımlıyor ve robots.txt bu sayfaları
 * serbest bırakıyor (kapalı olan yalnız /search ve /login).
 *
 * DergiPark'ın kendi uyarısı sayfanın başında yazılı: "Her veri tabanından
 * dergilerin dizin güncelliği kontrol edilmelidir. DergiPark sorumluluk
 * almamaktadır." Bu yüzden buradan çıkan şey ÖNERİ; kademeyi aday onaylıyor.
 */
class DergiParkDizinleri
{
    /** Yerel kopyanın tazelik süresi (gün). */
    private const TAZELIK = 90;

    /** DOI çözülürken tarayıcı gibi tanıtılmak gerekiyor; sade istemciye 503 dönüyor. */
    private const TARAYICI = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) '
        .'AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0 Safari/537.36';

    public function __construct(
        private readonly string $taban = 'https://dergipark.org.tr',
        private readonly string $doiTaban = 'https://doi.org',
    ) {}

    /**
     * DOI'nin gittiği adresten DergiPark dergi kısaltmasını çıkarır.
     *
     * DergiPark'ta olmayan dergi için null döner — çağıran bunu kaydedip
     * bir daha sormamalı, yoksa her açılışta boşa istek gider.
     */
    public function slugBul(string $doi): ?string
    {
        $doi = trim($doi);

        if ($doi === '') {
            return null;
        }

        $adres = "{$this->doiTaban}/".ltrim($doi, '/');

        // Yönlendirmeler ELLE izleniyor. doi.org iki adımda varıyor
        // (doi.org → dergipark.org.tr/tr/doi/… → /tr/pub/<slug>/article/…)
        // ve kısaltma ancak ikincisinde beliriyor. İstemciye bıraksaydık son
        // adresi yalnız gerçek ağ isteğinde okuyabilirdik — sahte yanıtla
        // sınanamayan bir kod olurdu.
        for ($adim = 0; $adim < 5; $adim++) {
            if (preg_match('~dergipark\.org\.tr/[^/]+/pub/([^/?\#]+)~i', $adres, $esles) === 1) {
                return $esles[1];
            }

            try {
                $yanit = Http::withUserAgent(self::TARAYICI)
                    ->withoutRedirecting()
                    ->timeout(15)
                    ->get($adres);
            } catch (ConnectionException) {
                return null;
            }

            $konum = trim((string) $yanit->header('Location'));

            if ($konum === '') {
                return null;
            }

            $adres = str_starts_with($konum, 'http') ? $konum : $this->mutlakla($adres, $konum);
        }

        return null;
    }

    /**
     * Göreli Location başlığını bir önceki adresin köküne bağlar.
     */
    private function mutlakla(string $onceki, string $konum): string
    {
        $parca = parse_url($onceki);
        $kok = ($parca['scheme'] ?? 'https').'://'.($parca['host'] ?? '');

        return $kok.'/'.ltrim($konum, '/');
    }

    /**
     * Derginin dizin listesi. Yerel kopya tazeyse ağa çıkılmaz.
     */
    public function dergi(string $slug): ?Dergi
    {
        $dergi = Dergi::query()->firstWhere('slug', $slug);

        if ($dergi !== null && $dergi->kontrol_edildi_at?->gt(now()->subDays(self::TAZELIK))) {
            return $dergi;
        }

        try {
            $yanit = Http::withUserAgent(self::TARAYICI)
                ->timeout(20)
                ->get("{$this->taban}/tr/pub/{$slug}/indexes");
        } catch (ConnectionException) {
            // Eski kopya varsa bayat hâli yoktan iyidir.
            return $dergi;
        }

        if ($yanit->failed()) {
            return $dergi;
        }

        $html = $yanit->body();

        return Dergi::query()->updateOrCreate(['slug' => $slug], [
            'ad' => $this->ad($html),
            'atif_dizinleri' => $this->bolum($html, 'Atıf Dizinleri'),
            'diger_dizinler' => $this->bolum($html, 'Diğer Dizinler'),
            'kontrol_edildi_at' => now(),
        ]);
    }

    /**
     * Sayfadaki bir dizin bölümünün adları.
     *
     * Yapı sabit: <h3>Atıf Dizinleri</h3> ardından bir <table>, her <tr>'de
     * iki bağlantı — ilki logo görseli, ikincisi adın kendisi. Görselli
     * bağlantı metinsiz olduğu için METNİ OLAN SON bağlantı alınıyor.
     *
     * @return list<string>
     */
    private function bolum(string $html, string $baslik): array
    {
        $desen = '~<h3[^>]*>\s*'.preg_quote($baslik, '~').'\s*</h3>(.*?)</table>~si';

        if (preg_match($desen, $html, $esles) !== 1) {
            return [];
        }

        preg_match_all('~<tr[^>]*>(.*?)</tr>~si', $esles[1], $satirlar);

        $adlar = [];

        foreach ($satirlar[1] as $satir) {
            preg_match_all('~<a[^>]*>(.*?)</a>~si', $satir, $baglantilar);

            foreach (array_reverse($baglantilar[1]) as $icerik) {
                $ad = $this->sadelestir($icerik);

                if ($ad !== '') {
                    $adlar[] = $ad;

                    break;
                }
            }
        }

        return array_values(array_unique($adlar));
    }

    private function ad(string $html): ?string
    {
        if (preg_match('~<title>(.*?)</title>~si', $html, $esles) !== 1) {
            return null;
        }

        // "Dizinler - Dergi Adı - Dergi Adı" → ortadaki parça.
        $parcalar = array_map(fn (string $p): string => trim($p), explode(' - ', $this->sadelestir($esles[1])));

        return $parcalar[1] ?? null;
    }

    private function sadelestir(string $ham): string
    {
        $metin = html_entity_decode(strip_tags($ham), ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return trim((string) preg_replace('/\s+/u', ' ', $metin));
    }
}
