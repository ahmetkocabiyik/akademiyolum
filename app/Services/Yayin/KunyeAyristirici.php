<?php

namespace App\Services\Yayin;

use App\Console\Commands\UniversiteBirimleriCek;
use App\Enums\Kategori;

/**
 * İçe aktarılan ham künye metnini künye alanlarına ayırır
 * ({@see Kategori::kunyeAlanlari()}).
 *
 * Kaynaklar ve biçimleri:
 *   APBS makale   "DERGİ ADI, vol. 19, no. 1, pp. 1-10 · Uluslararası"
 *   AVESİS makale "Dergi Adı, cilt.23, sa.1, ss.12-30, 2026 (ESCI, Scopus)"
 *   APBS bildiri  "Sempozyum Adı (25.04.2025 - 30.04.2025) · 1 Uluslararası"
 *   APBS kitap    "Yayın Evi: Fecr, Basım Sayısı: 1, ISBN: 978-…, Sayfa Sayısı: 450 · Kitap"
 *   APBS tez      "ÖĞRENCİ ADI · ÜNİVERSİTE - ENSTİTÜ - ANABİLİM DALI · Yüksek Lisans"
 *   APBS idari    "İdari Görev · Kurum"
 *   DergiPark     sayı etiketi "Cilt: 13 Sayı: 1"
 *
 * TEMKİNLİ: yalnız kesin tanınan işaretler okunuyor (cilt/vol., sayı/no.,
 * sayfa/pp./ss., "Anahtar: değer"). Emin olunmayan parça boş kalıyor;
 * yanlış bir dergi adı CV'de boş alandan daha kötü. Boş kalan alan
 * künyede ham metinle tamamlanıyor (App\Services\Cv\KunyeYazici).
 */
class KunyeAyristirici
{
    /**
     * @return array<string, string> yalnız kategorinin künye anahtarları, boşlar yok
     */
    public function ayristir(Kategori $kategori, string $ham): array
    {
        $parcalar = array_values(array_filter(array_map('trim', explode(' · ', trim($ham))), fn (string $p) => $p !== ''));

        if ($parcalar === []) {
            return [];
        }

        $alanlar = match ($kategori) {
            Kategori::Makale, Kategori::TezYayini => $this->dergi($parcalar[0]),
            Kategori::Bildiri => $this->bildiri($parcalar[0]),
            // APBS her satırı ayrı parça yazıyor ("Yayın Evi: …", "Bölüm Adı: …");
            // değer kendi parçasının sonunda bitiyor, sistem dipnotlarına taşmıyor.
            Kategori::Kitap => array_merge(...array_map(fn (string $p) => $this->anahtarDeger($p), array_reverse($parcalar))),
            Kategori::TezDanismanligi => $this->tez($parcalar),
            Kategori::IdariGorev => ($parcalar[0] === 'İdari Görev' && isset($parcalar[1])) ? ['kurum' => $parcalar[1]] : [],
            default => [],
        };

        $alanlar = array_filter(array_map(fn (string $d) => trim($d, " ,.\t"), $alanlar), fn (string $d) => $d !== '');

        return array_intersect_key($alanlar, $kategori->kunyeAlanlari());
    }

    /**
     * DergiPark sayı etiketi ("Cilt: 13 Sayı: 1", "Yıl 2023, Cilt 13, Sayı 1").
     *
     * @return array{cilt?: string, sayi?: string}
     */
    public function dergiParkSayisi(string $etiket): array
    {
        $alanlar = [];

        if (preg_match('/Cilt:?\s*([0-9IVXLC]+)/iu', $etiket, $m) === 1) {
            $alanlar['cilt'] = $m[1];
        }

        if (preg_match('/Say[ıi]:?\s*([0-9]+(?:[-\/][0-9]+)?|Özel)/iu', $etiket, $m) === 1) {
            $alanlar['sayi'] = $m[1];
        }

        return $alanlar;
    }

    /**
     * "Dergi, vol. 19, no. 1, pp. 1-10" — dergi adı, tanınan ilk işaretten
     * önceki parçalar. Hiç işaret yoksa ve parça tek başına bir adsa ad.
     *
     * @return array<string, string>
     */
    private function dergi(string $metin): array
    {
        // Sondaki dizin parantezi: "(ESCI, Scopus)".
        $metin = trim(preg_replace('/\s*\([^()]*\)\s*$/u', '', $metin) ?? $metin);
        $tokenlar = array_map('trim', explode(',', $metin));
        $alanlar = [];
        $ad = [];
        $isaretGoruldu = false;

        foreach ($tokenlar as $token) {
            $isaret = match (true) {
                preg_match('/^(?:vol|cilt|volume)\.?\s*(.+)$/iu', $token, $m) === 1 => ['cilt', $m[1]],
                preg_match('/^(?:no|sa|sayı|issue)\.?\s*(.+)$/iu', $token, $m) === 1 => ['sayi', $m[1]],
                preg_match('/^(?:pp|ss|s|p)\.\s*(.+)$/iu', $token, $m) === 1 => ['sayfa', $m[1]],
                preg_match('/^(?:19|20)\d\d$/', $token) === 1 => ['yil', $token],
                default => null,
            };

            if ($isaret !== null) {
                $isaretGoruldu = true;
                $alanlar[$isaret[0]] ??= $isaret[1];

                continue;
            }

            if (! $isaretGoruldu) {
                $ad[] = $token;
            }
        }

        unset($alanlar['yil']);

        $dergi = implode(', ', $ad);

        if ($dergi !== '' && preg_match('/\p{L}/u', $dergi) === 1) {
            $alanlar['dergi'] = $dergi;
        }

        return $alanlar;
    }

    /**
     * APBS: "Sempozyum Adı (25.04.2025 - 30.04.2025)". AVESİS: "Kongre Adı,
     * Şehir, Ülke, 19 - 22 Haziran 2019, ss.12-20, (Özet Bildiri)".
     *
     * Kongre adı virgül içerebiliyor ("International Learning, Teaching and
     * Educational Research Congress"), o yüzden ad baştan değil SONDAN
     * kuruluyor: tarih parçasından hemen önceki bir ya da iki parça yer
     * (ülke; tek kelimeyse önündeki şehir), kalanı ad. Ayrımın emin
     * olunamadığı yerde (tarih yok, tek parça) yer boş kalıyor.
     *
     * @return array<string, string>
     */
    private function bildiri(string $metin): array
    {
        $metin = trim(preg_replace('/\s*\(\d{1,2}\.\d{1,2}\.\d{4}\s*-\s*\d{1,2}\.\d{1,2}\.\d{4}\)\s*/u', ' ', $metin) ?? $metin);
        $tokenlar = array_values(array_filter(array_map('trim', explode(',', $metin)), fn (string $t) => $t !== ''));
        $alanlar = [];

        foreach ($tokenlar as $token) {
            if (preg_match('/^(?:pp|ss|s|p)\.\s*(.+)$/iu', $token, $m) === 1) {
                $alanlar['sayfa'] = $m[1];
            }
        }

        // Ad + yer: tarih, sayfa ya da parantezli tür parçasına kadar olanlar.
        // İlk parça hep ad: "EJERCongress 2019" yıl taşıyor ama tarih değil.
        $once = [];

        foreach ($tokenlar as $i => $token) {
            if ($i > 0 && (self::tarihParcasi($token) || preg_match('/^(?:pp|ss|s|p)\./iu', $token) === 1 || str_starts_with($token, '('))) {
                break;
            }

            $once[] = $token;
        }

        $tarihVar = count($once) < count($tokenlar);
        $yer = [];

        if ($tarihVar && count($once) >= 2 && self::yerAdi(end($once))) {
            array_unshift($yer, array_pop($once));

            // Şehir: tek kelimeyse ve önünde hâlâ ad kalıyorsa.
            if (count($once) >= 2 && self::yerAdi(end($once)) && ! str_contains(end($once), ' ')) {
                array_unshift($yer, array_pop($once));
            }
        }

        $alanlar['toplanti'] = implode(', ', $once);

        if ($yer !== []) {
            $alanlar['yer'] = implode(', ', $yer);
        }

        return $alanlar;
    }

    /**
     * Toplantı tarihi parçası: gün aralığı ("19 - 22 Haziran 2019") ya da ay adı.
     */
    private static function tarihParcasi(string $parca): bool
    {
        return preg_match('/\b\d{1,2}\s*-\s*\d{1,2}\b/u', $parca) === 1
            || preg_match('/\b(?:Ocak|Şubat|Mart|Nisan|Mayıs|Haziran|Temmuz|Ağustos|Eylül|Ekim|Kasım|Aralık|January|February|March|April|May|June|July|August|September|October|November|December)\b/iu', $parca) === 1;
    }

    /**
     * Yer adı gibi mi: büyük harfle başlayan, en çok iki kelime, toplantı
     * adı sözcüğü taşımayan ("Ankara", "Türkiye", "New York").
     */
    private static function yerAdi(string $parca): bool
    {
        return preg_match("/^\p{Lu}[\p{L}.'\-]*(?: \p{Lu}[\p{L}.'\-]*)?$/u", $parca) === 1
            && preg_match('/\b(?:Congress|Conference|Symposium|Workshop|Meeting|Kongre|Sempozyum|Konferans|Çalıştay|and|ve|of)\b/iu', $parca) !== 1;
    }

    /**
     * "Yayın Evi: X, ISBN: Y, Sayfa Sayısı: 450, Kitap Adı: Z, Editör: W".
     *
     * @return array<string, string>
     */
    private function anahtarDeger(string $metin): array
    {
        $anahtarlar = [
            'yayinevi' => 'Yay[ıi]n\s*Evi|Yay[ıi]nevi|Publisher',
            'isbn' => 'ISBN',
            'sayfa' => 'Sayfa\s*Say[ıi]s[ıi]|Sayfa\s*Aral[ıi][ğg][ıi]|Sayfalar|Sayfa|Pages',
            'kitap_adi' => 'Kitap\s*Ad[ıi]|Book',
            'editor' => 'Edit[öo]r(?:ler)?|Editors?',
            'yer' => 'Bas[ıi]m\s*Yeri|Yay[ıi]n\s*Yeri|Şehir',
        ];

        $alanlar = [];

        foreach ($anahtarlar as $alan => $desen) {
            // Değer, bir sonraki "Anahtar:" ya da metnin sonuna kadar.
            if (preg_match('/(?:^|,\s*)(?:'.$desen.')\s*:\s*(.+?)(?=,\s*[\p{L} ]{2,25}:|$)/iu', $metin, $m) === 1) {
                $alanlar[$alan] = $m[1];
            }
        }

        return $alanlar;
    }

    /**
     * APBS: [ÖĞRENCİ, "ÜNİVERSİTE - ENSTİTÜ - ABD", "Yüksek Lisans"].
     * Büyük harfle gelen ad başlık harfine çevriliyor.
     *
     * @param  list<string>  $parcalar
     * @return array<string, string>
     */
    private function tez(array $parcalar): array
    {
        if (count($parcalar) < 2) {
            return [];
        }

        $alanlar = [];

        // AVESİS: "Yönetilen Tezler · CAN G. (Danışman) H.Hakan(Öğrenci), Doktora, 2020".
        if (preg_match('/(?:\)|^|·)\s*([^()·]+?)\s*\(Öğrenci\)/u', implode(' · ', $parcalar), $m) === 1) {
            return ['ogrenci' => self::baslikHarfi(trim($m[1]))];
        }

        // APBS: ad gibi görünüyorsa (tire yok, en fazla beş sözcük, "tez" değil).
        if (! str_contains($parcalar[0], ' - ') && count(preg_split('/\s+/u', $parcalar[0]) ?: []) <= 5
            && preg_match('/\btez/iu', $parcalar[0]) !== 1) {
            $alanlar['ogrenci'] = self::baslikHarfi($parcalar[0]);
        }

        if (str_contains($parcalar[1], ' - ') || preg_match('/ÜN[İI]VERS[İI]TE|UNIVERS/iu', $parcalar[1]) === 1) {
            $alanlar['universite'] = self::baslikHarfi($parcalar[1]);
        }

        return $alanlar;
    }

    /**
     * Tamamı büyük harfse başlık harfine çevirir (Türkçe I/İ doğru).
     */
    private static function baslikHarfi(string $metin): string
    {
        if (mb_strtoupper($metin, 'UTF-8') !== $metin || preg_match('/\p{L}/u', $metin) !== 1) {
            return $metin;
        }

        // "A.GÜL" tek kelime sayılıyor; noktadan sonraki harf de büyük olsun.
        return (string) preg_replace_callback(
            '/\.(\p{Ll})/u',
            fn (array $m): string => '.'.($m[1] === 'i' ? 'İ' : mb_strtoupper($m[1], 'UTF-8')),
            UniversiteBirimleriCek::baslikHarfi($metin),
        );
    }
}
