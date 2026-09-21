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
     * İki ayrı soru, iki ayrı kesinlik:
     *   sira  — TAM eşleşme. Rolü belirliyor ve bazı yönergelerde puanı
     *           doğrudan değiştiriyor, o yüzden zorlanmıyor: bulunamazsa null.
     *   yakin — SOYADI taşıyan bir yazar var mı. Geniş aramaların gürültüsünü
     *           eliyor ama "K. Binici" gibi kısaltmaları atmıyor.
     *
     * @param  list<string>  $yazarlar
     * @return array{sira: int|null, yakin: bool}
     */
    public function esles(array $yazarlar, string $ad): array
    {
        $aranan = $this->kelimeler($ad);

        if ($aranan === []) {
            return ['sira' => null, 'yakin' => false];
        }

        $anahtar = implode(' ', $aranan);
        $soyad = $this->soyad($ad);

        $sira = null;
        $yakin = false;

        foreach ($yazarlar as $i => $yazar) {
            $yazarKelimeleri = $this->kelimeler($yazar);

            if ($sira === null && implode(' ', $yazarKelimeleri) === $anahtar) {
                $sira = $i + 1;
            }

            if ($soyad !== [] && array_intersect($soyad, $yazarKelimeleri) !== []) {
                $yakin = true;
            }
        }

        return ['sira' => $sira, 'yakin' => $yakin];
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
