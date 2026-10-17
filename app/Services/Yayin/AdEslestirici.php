<?php

namespace App\Services\Yayin;

/**
 * Aday adını künyedeki yazar adlarıyla karşılaştırır.
 *
 * Hem Crossref künyeleri hem DergiPark arşiv sayfaları kullanıyor; kural tek
 * yerde durmalı, yoksa iki tarafta farklı kişiyi bulurlar.
 */
class AdEslestirici
{
    /**
     * Adayı yazar listesinde arar.
     *
     * Üç ayrı soru, üç ayrı kesinlik:
     *   sira    — TAM eşleşme. Rolü belirliyor ve bazı yönergelerde puanı
     *             doğrudan değiştiriyor, o yüzden zorlanmıyor: bulunamazsa null.
     *   uyumlu  — AYNI yazar hem soyadı hem adı taşıyor; ad tam ya da baş harf
     *             ("Eşref Şahin", "E. Şahin", "Mehmet Eşref Şahin"). "Enes
     *             Şahin" uyumlu değil. Crossref ad aramasının süzgeci bu:
     *             yalnız soyada bakınca 28 sonucun 23'ü başka kişilerindi.
     *   yakin   — SOYADI taşıyan bir yazar var mı. En gevşek ölçüt; tek bir
     *             derginin arşivini tararken yeterli.
     *
     * @param  list<string>  $yazarlar
     * @return array{sira: int|null, uyumlu: bool, yakin: bool}
     */
    public function esles(array $yazarlar, string $ad): array
    {
        $aranan = $this->kelimeler($ad);

        if ($aranan === []) {
            return ['sira' => null, 'uyumlu' => false, 'yakin' => false];
        }

        $anahtar = implode(' ', $aranan);
        $soyad = $this->soyad($ad);
        $adlar = array_values(array_diff($aranan, $soyad));

        $sira = null;
        $uyumlu = false;
        $yakin = false;

        foreach ($yazarlar as $i => $yazar) {
            $yazarKelimeleri = $this->kelimeler($yazar);

            if ($sira === null && implode(' ', $yazarKelimeleri) === $anahtar) {
                $sira = $i + 1;
            }

            if ($soyad !== [] && array_intersect($soyad, $yazarKelimeleri) !== []) {
                $yakin = true;
                $uyumlu = $uyumlu || self::adUyar($adlar, array_diff($yazarKelimeleri, $soyad));
            }
        }

        return ['sira' => $sira, 'uyumlu' => $uyumlu || $sira !== null, 'yakin' => $yakin];
    }

    /**
     * Aranan adlardan biri yazarda tam ya da baş harf olarak geçiyor mu
     * (baş harf hangi tarafta olursa olsun)?
     * Aranan yalnız soyadıysa ad karşılaştırılmaz.
     *
     * @param  list<string>  $adlar  aranan kişinin adları (soyad hariç)
     * @param  array<int, string>  $yazarAdlari  yazarın adları (soyad hariç)
     */
    private static function adUyar(array $adlar, array $yazarAdlari): bool
    {
        if ($adlar === []) {
            return true;
        }

        foreach ($yazarAdlari as $kelime) {
            foreach ($adlar as $ad) {
                // Baş harf iki yönde: künyede "E. Şahin" ya da aranan "K. Binici".
                if ($kelime === $ad
                    || (mb_strlen($kelime) === 1 && str_starts_with($ad, $kelime))
                    || (mb_strlen($ad) === 1 && str_starts_with($kelime, $ad))) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Girilen addan soyad kelimeleri.
     *
     * "Kasım Binici" → [binici] · "BİNİCİ, Kasım" → [binici]. Virgül varsa
     * öncesi soyad sayılıyor (künye yazımı), yoksa son kelime (günlük yazım).
     * İki harfli parçalar (baş harfler) atılıyor.
     *
     * Ölçüt neden soyad: "herhangi bir kelime" denendi ve tutmadı — "Kasım"
     * yaygın bir ad, başka kişilerin yayınları süzgeçten geçiyordu.
     *
     * @return list<string>
     */
    public function soyad(string $ad): array
    {
        $parca = str_contains($ad, ',')
            ? substr($ad, 0, (int) strpos($ad, ','))
            : (string) (array_slice(preg_split('/\s+/', trim($ad)) ?: [], -1)[0] ?? '');

        return array_values(array_filter(
            $this->kelimeler($parca),
            fn (string $kelime): bool => mb_strlen($kelime) >= 3,
        ));
    }

    /**
     * Addaki kelimeler, karşılaştırılabilir hâlde.
     *
     * Türkçe harfler elle iniyor: mb_strtolower "İ"yi i + birleşen nokta
     * yapıyor ve "BİNİCİ" ile "Binici" eşleşmiyor. Kelimeler ayrıca
     * SIRALANIYOR — künyelerde "Kasım Binici" de "BİNİCİ, Kasım" da geçiyor.
     *
     * @return list<string>
     */
    public function kelimeler(string $ad): array
    {
        $ad = strtr($ad, [
            'İ' => 'i', 'I' => 'i', 'ı' => 'i', 'Ş' => 's', 'ş' => 's',
            'Ğ' => 'g', 'ğ' => 'g', 'Ü' => 'u', 'ü' => 'u', 'Ö' => 'o',
            'ö' => 'o', 'Ç' => 'c', 'ç' => 'c',
        ]);

        $ad = mb_strtolower($ad, 'UTF-8');
        $ad = preg_replace('/[^a-z\s]/u', ' ', $ad) ?? '';

        $kelimeler = array_values(array_filter(explode(' ', $ad)));
        sort($kelimeler);

        return $kelimeler;
    }
}
