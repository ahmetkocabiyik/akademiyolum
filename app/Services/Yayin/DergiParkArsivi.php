<?php

namespace App\Services\Yayin;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * DergiPark dergi arşivlerini okur — DOI'si olmayan eski yayınlar için.
 *
 * NEDEN GEREKLİ: dergiler DOI'ye sonradan geçti ve geriye dönük vermediler.
 * Politeknik Dergisi'nin arşivi 2002'ye iniyor ama Crossref'teki ilk DOI
 * 2018; Gazi Üniv. J. of Science 2003'ten yayında, ilk DOI 2019. Yani
 * Crossref araması adayın 2014–2019 öncesi yayınlarını hiç göremiyor, oysa
 * atama dosyasında tam o yıllar var.
 *
 * ROBOTS: DergiPark yalnız /search ve /login'i kapatıyor; arşiv ve sayı
 * sayfaları serbest.
 *
 * Eski sayılar bir daha değişmiyor, bu yüzden hem arşiv hem sayı sayfaları
 * önbelleğe alınıyor — aday sayıları tararken aynı dergiyi defalarca
 * indirmesin.
 *
 * @phpstan-type Sayi array{id: string, etiket: string, tarih: string|null, yil: int|null}
 * @phpstan-type Makale array{id: string, baslik: string, yazarlar: list<string>}
 */
class DergiParkArsivi
{
    private const TARAYICI = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) '
        .'AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0 Safari/537.36';

    /** Arşiv listesi değişebilir (yeni sayı); tek sayının içeriği değişmez. */
    private const ARSIV_OMRU = 60 * 60 * 24 * 7;

    private const SAYI_OMRU = 60 * 60 * 24 * 30;

    public function __construct(private readonly string $taban = 'https://dergipark.org.tr') {}

    /**
     * Girilen adresten ya da kısaltmadan dergi kısaltması.
     *
     * Aday ya tam adresi yapıştırıyor ya da kısaltmayı yazıyor; ikisi de
     * kabul ediliyor çünkü hangisini yapıştırdığını bilmiyor.
     */
    public function kisaltma(string $girdi): ?string
    {
        $girdi = trim($girdi);

        if (preg_match('~dergipark\.org\.tr/[^/]+/pub/([^/?\#\s]+)~i', $girdi, $esles) === 1) {
            return $esles[1];
        }

        return preg_match('~^[a-z0-9][a-z0-9\-]{1,60}$~i', $girdi) === 1 ? mb_strtolower($girdi) : null;
    }

    /**
     * Derginin sayıları, yenisi önce.
     *
     * Tarih arşiv sayfasında sayının yanında duruyor; sayfayı açmadan yıl
     * süzgeci kurulabilsin diye oradan alınıyor. Henüz yayımlanmamış sayının
     * tarihi boş.
     *
     * @return list<Sayi>
     */
    public function sayilar(string $kisaltma): array
    {
        return $this->arsiv($kisaltma)['sayilar'];
    }

    /**
     * Derginin adı (arşiv sayfasından). Faaliyet künyesine yazılıyor: aday
     * listesinde "hangi dergi" görünsün ve aynı dergideki önceki kademe
     * seçimi {@see KaynakOnerici} tarafından bulunabilsin.
     */
    public function ad(string $kisaltma): ?string
    {
        return $this->arsiv($kisaltma)['ad'];
    }

    /**
     * @return array{ad: string|null, sayilar: list<Sayi>}
     */
    private function arsiv(string $kisaltma): array
    {
        return Cache::remember("dergipark.arsiv.{$kisaltma}", self::ARSIV_OMRU, function () use ($kisaltma): array {
            $html = $this->getir("/tr/pub/{$kisaltma}/archive");

            if ($html === null) {
                return ['ad' => null, 'sayilar' => []];
            }

            // Her sayı kendi bağlantısıyla başlayan bir parça; tarihi o
            // parçanın içinde. Bağlantıdan bağlantıya bölmek, kartların
            // iç yapısına bağlı kalmadan ikisini eşliyor.
            $parcalar = preg_split('~(?=<a[^>]*href="/tr/pub/'.preg_quote($kisaltma, '~').'/issue/\d+")~', $html) ?: [];

            $sayilar = [];

            foreach ($parcalar as $parca) {
                $desen = '~^<a[^>]*href="/tr/pub/'.preg_quote($kisaltma, '~').'/issue/(\d+)"[^>]*>(.*?)</a>~s';

                if (preg_match($desen, $parca, $esles) !== 1) {
                    continue;
                }

                $tarih = preg_match('~(\d{1,2})\.(\d{1,2})\.(\d{4})~', mb_substr($parca, 0, 1200), $t) === 1
                    ? sprintf('%04d-%02d-%02d', (int) $t[3], (int) $t[2], (int) $t[1])
                    : null;

                $sayilar[$esles[1]] = [
                    'id' => $esles[1],
                    'etiket' => $this->sadelestir($esles[2]),
                    'tarih' => $tarih,
                    'yil' => $tarih === null ? null : (int) substr($tarih, 0, 4),
                ];
            }

            return [
                'ad' => preg_match('~<h1[^>]*>(.*?)</h1>~s', $html, $esles) === 1
                    ? ($this->sadelestir($esles[1]) ?: null)
                    : null,
                'sayilar' => array_values($sayilar),
            ];
        });
    }

    /**
     * Bir sayıdaki makaleler.
     *
     * @return list<Makale>
     */
    public function makaleler(string $kisaltma, string $sayiId): array
    {
        return Cache::remember("dergipark.sayi.{$kisaltma}.{$sayiId}", self::SAYI_OMRU, function () use ($kisaltma, $sayiId): array {
            $html = $this->getir("/tr/pub/{$kisaltma}/issue/{$sayiId}");

            if ($html === null) {
                return [];
            }

            $parcalar = preg_split('~(?=<a[^>]*class="art-title)~', $html) ?: [];

            $makaleler = [];

            foreach ($parcalar as $parca) {
                $desen = '~^<a[^>]*href="[^"]*/article/(\d+)"[^>]*class="art-title[^"]*"[^>]*>(.*?)</a>~s';

                if (preg_match($desen, $parca, $esles) !== 1) {
                    continue;
                }

                $baslik = $this->sadelestir($esles[2]);

                if ($baslik === '') {
                    continue;
                }

                $makaleler[$esles[1]] = [
                    'id' => $esles[1],
                    'baslik' => $baslik,
                    'yazarlar' => $this->yazarlar($parca),
                ];
            }

            return array_values($makaleler);
        });
    }

    /**
     * Yazar adları yalnız `author-meta-container` içinden alınıyor: sayfanın
     * başka yerlerindeki span'ler (etiketler, istatistikler) yazar sanılırsa
     * ad eşleşmesi herkesi yakalar.
     *
     * @return list<string>
     */
    private function yazarlar(string $parca): array
    {
        if (preg_match('~<div class="author-meta-container">(.*?)</div>~s', $parca, $esles) !== 1) {
            return [];
        }

        preg_match_all('~<span[^>]*>(.*?)</span>~s', $esles[1], $spanlar);

        return array_values(array_filter(array_map(
            fn (string $ad): string => $this->sadelestir($ad),
            $spanlar[1],
        )));
    }

    private function getir(string $yol): ?string
    {
        try {
            $yanit = Http::withUserAgent(self::TARAYICI)->timeout(20)->get($this->taban.$yol);
        } catch (ConnectionException) {
            return null;
        }

        return $yanit->successful() ? $yanit->body() : null;
    }

    private function sadelestir(string $ham): string
    {
        $metin = html_entity_decode(strip_tags($ham), ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return trim((string) preg_replace('/\s+/u', ' ', $metin));
    }
}
