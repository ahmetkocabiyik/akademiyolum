<?php

namespace App\Services\Yayin;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

/**
 * Adayın yayınlarını Crossref künyelerinden bulur.
 *
 * NEDEN DERGİPARK DEĞİL: DergiPark arama sayfasını robots.txt ile bütün
 * botlara kapatıyor (`Disallow: /tr/search`) ve tarayıcı olmayan isteğe 503
 * dönüyor; platform çapında API'si de yok. Aynı makaleler Crossref'te duruyor:
 * DOI alan her dergi künyeyi oraya teslim etmek zorunda, DergiPark dergilerinin
 * çoğu da DOI kullanıyor. Crossref'in API'si bu iş için yayımlanmış, ücretsiz
 * ve anahtarsız.
 *
 * NE GELMİYOR — İNDEKS: dergi SCIE mi, Q2 mi, TR Dizin mi; Crossref bilmiyor,
 * o bilgi Clarivate ile Elsevier'in ticari ürünü. Puanı belirleyen alan tam
 * olarak o olduğu için içe aktarılan kayıt `kaynak`sız iniyor ve kademeyi aday
 * seçiyor. Bu servis asla kademe tahmin etmez.
 *
 * İKİ SORGU, İKİ AYRI ZAYIFLIK:
 *   - ORCID süzgeci kesin ama EKSİK: yayıncı ORCID'i göndermediyse makale yok.
 *   - Ad sorgusu geniş ama KİRLİ: Crossref alakaya göre sıralıyor ve adın
 *     hiçbir yazarda geçmediği yayınlar da dönüyor (gerçek sorguda 30
 *     sonucun yarısı başka kişilerindi).
 * İkisi birleştiriliyor; ORCID'den gelen hiç elenmiyor, ad sorgusundan gelen
 * ise yazarlarından biri SOYADI taşımıyorsa atılıyor. Ölçüt neden soyad:
 * "herhangi bir kelime" denendi ve tutmadı — "Kasım" yaygın bir ad, başka
 * kişilerin yayınları süzgeçten geçiyordu. Tam ad eşleşmesi de aranmıyor,
 * künyelerde "K. Binici" gibi kısaltmalar var.
 *
 * @phpstan-type Yayin array{
 *     doi: string,
 *     baslik: string,
 *     dergi: string,
 *     yil: int|null,
 *     tarih: string|null,
 *     yazarlar: list<string>,
 *     sira: int|null,
 *     yakin: bool,
 *     kategori: string,
 *     kesin: bool,
 * }
 */
class CrossrefArama
{
    /**
     * Crossref yayın türü → bizim kategori. Listede olmayan tür (veri seti,
     * ön baskı, bileşen...) atlanıyor: faaliyet cetvelinde karşılığı yok ve
     * "diger" kategorisine atmak adayın listesini çöple doldurur.
     */
    private const TURLER = [
        'journal-article' => 'makale',
        'proceedings-article' => 'bildiri',
        'book-chapter' => 'kitap',
        'book' => 'kitap',
        'monograph' => 'kitap',
    ];

    /** Crossref'ten yalnız kullandığımız alanlar isteniyor. */
    private const ALANLAR = 'DOI,title,container-title,ISSN,issued,author,type,volume,issue,page,publisher,ISBN';

    public function __construct(
        private readonly AdEslestirici $adlar = new AdEslestirici,
        private readonly string $taban = 'https://api.crossref.org',
        private readonly ?string $posta = null,
    ) {}

    /**
     * @return list<Yayin> yıl azalan sırada, DOI'ye göre tekilleştirilmiş
     */
    public function ara(string $ad, ?string $orcid = null, int $adet = 30): array
    {
        $ad = trim($ad);
        $orcid = $this->orcidDuzelt($orcid);

        if ($ad === '' && $orcid === null) {
            return [];
        }

        $yayinlar = [];

        // ORCID önce: aynı DOI iki sorgudan da gelirse kesin olan kazanır.
        if ($orcid !== null) {
            foreach ($this->sorgula(['filter' => "orcid:{$orcid}"], $adet) as $ham) {
                $this->biriktir($yayinlar, $ham, $ad, kesin: true);
            }
        }

        if ($ad !== '') {
            foreach ($this->sorgula(['query.author' => $ad], $adet) as $ham) {
                $this->biriktir($yayinlar, $ham, $ad, kesin: false);
            }
        }

        $yayinlar = array_values($yayinlar);

        // Kesinlik sırası: ORCID eşleşmesi → adı yazarlar arasında tam geçen
        // → kalanlar. Her kümede yeni yayın önce. Yıla göre tek sıralama
        // gürültüyü kesinlerin arasına serpiştiriyordu.
        usort($yayinlar, fn (array $a, array $b): int => [$b['kesin'], $b['sira'] !== null, $b['yil'] ?? 0]
            <=> [$a['kesin'], $a['sira'] !== null, $a['yil'] ?? 0]);

        return $yayinlar;
    }

    /**
     * @param  array<string, string>  $parametre
     * @return list<array<string, mixed>>
     */
    private function sorgula(array $parametre, int $adet): array
    {
        $parametre['rows'] = (string) $adet;
        $parametre['select'] = self::ALANLAR;

        // Crossref'in "polite pool"u: iletişim adresi veren istemciye daha
        // yüksek hız veriliyor. Adres yoksa istek yine çalışır.
        if ($this->posta !== null && $this->posta !== '') {
            $parametre['mailto'] = $this->posta;
        }

        try {
            $yanit = Http::acceptJson()
                ->withUserAgent($this->kimlik())
                ->timeout(15)
                ->retry(2, 300, throw: false)
                ->get("{$this->taban}/works", $parametre);
        } catch (ConnectionException) {
            throw AramaException::ulasilamadi();
        }

        if ($yanit->failed()) {
            throw AramaException::httpDurumundan($yanit->status());
        }

        $kayitlar = $yanit->json('message.items');

        return is_array($kayitlar) ? array_values($kayitlar) : [];
    }

    /**
     * @param  array<string, Yayin>  $yayinlar
     * @param  array<string, mixed>  $ham
     */
    private function biriktir(array &$yayinlar, array $ham, string $ad, bool $kesin): void
    {
        $kayit = $this->kayit($ham, $ad, $kesin);

        if ($kayit === null || isset($yayinlar[$kayit['doi']])) {
            return;
        }

        // Ad sorgusunun gürültüsü: yazarlarının hiçbiri adla kelime
        // paylaşmıyorsa bu yayın adayın olamaz. ORCID'den gelen elenmez.
        if (! $kesin && ! $kayit['yakin']) {
            return;
        }

        $yayinlar[$kayit['doi']] = $kayit;
    }

    /**
     * @param  array<string, mixed>  $ham
     * @return Yayin|null
     */
    private function kayit(array $ham, string $ad, bool $kesin): ?array
    {
        $kategori = self::TURLER[$ham['type'] ?? ''] ?? null;
        $doi = mb_strtolower(trim((string) ($ham['DOI'] ?? '')));
        $baslik = trim((string) (($ham['title'] ?? [])[0] ?? ''));

        if ($kategori === null || $doi === '' || $baslik === '') {
            return null;
        }

        $yazarlar = $this->yazarlar($ham['author'] ?? []);
        $esleme = $this->adlar->esles($yazarlar, $ad);

        return [
            'doi' => $doi,
            'baslik' => $baslik,
            'dergi' => trim((string) (($ham['container-title'] ?? [])[0] ?? '')),
            // Künye ayrıntısı (CV ve YÖK EK-4A özgeçmişi için).
            'cilt' => trim((string) ($ham['volume'] ?? '')),
            'sayi' => trim((string) ($ham['issue'] ?? '')),
            'sayfa' => trim((string) ($ham['page'] ?? '')),
            'yayinevi' => trim((string) ($ham['publisher'] ?? '')),
            'isbn' => trim((string) (($ham['ISBN'] ?? [])[0] ?? '')),
            'yil' => $this->yil($ham),
            'tarih' => $this->tarih($ham),
            'yazarlar' => $yazarlar,
            'sira' => $esleme['sira'],
            'yakin' => $esleme['yakin'],
            'kategori' => $kategori,
            'kesin' => $kesin,
        ];
    }

    /**
     * @param  mixed  $ham
     * @return list<string>
     */
    private function yazarlar($ham): array
    {
        if (! is_array($ham)) {
            return [];
        }

        $adlar = [];

        foreach ($ham as $yazar) {
            if (! is_array($yazar)) {
                continue;
            }

            // Kurum yazarlarında given/family yok, tek parça `name` var.
            $ad = isset($yazar['name'])
                ? (string) $yazar['name']
                : trim(((string) ($yazar['given'] ?? '')).' '.((string) ($yazar['family'] ?? '')));

            if (trim($ad) !== '') {
                $adlar[] = trim($ad);
            }
        }

        return $adlar;
    }

    /**
     * @param  array<string, mixed>  $ham
     */
    private function yil(array $ham): ?int
    {
        $parca = ($ham['issued']['date-parts'] ?? [[]])[0] ?? [];

        return isset($parca[0]) && is_numeric($parca[0]) ? (int) $parca[0] : null;
    }

    /**
     * Künye tarihi (Y-m-d); ay/gün yoksa 01 varsayılıyor.
     *
     * GELECEK TARİH BOŞ DÖNER: erken erişimde künye ileri tarihli olabiliyor,
     * oysa dönem koşulları "doçentlikten sonra" gibi kıyaslar yapıyor ve
     * olmamış bir tarih sessizce yanlış sonuç üretir. Yıl listede görünür,
     * tam tarihi aday girer.
     *
     * @param  array<string, mixed>  $ham
     */
    private function tarih(array $ham): ?string
    {
        $parca = ($ham['issued']['date-parts'] ?? [[]])[0] ?? [];

        if (! isset($parca[0]) || ! is_numeric($parca[0])) {
            return null;
        }

        $tarih = sprintf(
            '%04d-%02d-%02d',
            (int) $parca[0],
            isset($parca[1]) ? (int) $parca[1] : 1,
            isset($parca[2]) ? (int) $parca[2] : 1,
        );

        return $tarih > now()->format('Y-m-d') ? null : $tarih;
    }

    /**
     * "https://orcid.org/0000-0002-1825-0097" ve "0000000218250097" gibi
     * yazımları tek biçime indirir; geçersizse null.
     */
    private function orcidDuzelt(?string $orcid): ?string
    {
        if ($orcid === null) {
            return null;
        }

        $sade = preg_replace('/[^0-9X]/', '', mb_strtoupper(trim($orcid))) ?? '';

        if (strlen($sade) !== 16) {
            return null;
        }

        return implode('-', str_split($sade, 4));
    }

    private function kimlik(): string
    {
        $ad = config('app.name', 'Akademiyolum');

        return $this->posta ? "{$ad} (mailto:{$this->posta})" : (string) $ad;
    }
}
