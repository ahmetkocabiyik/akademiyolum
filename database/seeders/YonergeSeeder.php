<?php

namespace Database\Seeders;

use App\Models\Universite;
use App\Models\Yonerge;
use Illuminate\Database\Seeder;

class YonergeSeeder extends Seeder
{
    /**
     * Yönergeleri, kategori kurallarını config'teki İlahiyat setinden alarak seed eder.
     * Üniversiteler yalnızca puan barajı (universite_hedef) bakımından farklılaşır.
     */
    public function run(): void
    {
        /** @var array<string, array{tavan: int, puanlar: array<string, int>, varsayilan: int}> $kategoriKurallari */
        $kategoriKurallari = config('yonerge.setler.ilahiyat_2026.kategoriler');

        // Genel ÜAK yönergesi (üniversiteye bağlı değil).
        $this->yonergeOlustur(
            anahtar: 'uak-ilahiyat-2026',
            ad: 'ÜAK Doçentlik — İlahiyat 2026',
            kadro: 'docentlik',
            uakHedef: 100,
            universiteHedef: 220,
            kategoriKurallari: $kategoriKurallari,
            universite: null,
        );

        // Üniversiteye özel yönergeler (baraj farklı).
        // Not: Barajlar placeholder — kategori tavanları toplamına (~134) göre
        // erişilebilir aralıkta tutuldu. Faz 2'de gerçek yönerge verisiyle güncellenecek.
        $universiteler = [
            ['ad' => 'Mersin Üniversitesi', 'sehir' => 'Mersin', 'tur' => 'devlet', 'baraj' => 90, 'kadro' => 'docentlik'],
            ['ad' => 'Necmettin Erbakan Üniversitesi', 'sehir' => 'Konya', 'tur' => 'devlet', 'baraj' => 60, 'kadro' => 'dr_ogr_uyesi'],
            ['ad' => 'Ankara Üniversitesi', 'sehir' => 'Ankara', 'tur' => 'devlet', 'baraj' => 120, 'kadro' => 'docentlik'],
            ['ad' => 'Marmara Üniversitesi', 'sehir' => 'İstanbul', 'tur' => 'devlet', 'baraj' => 100, 'kadro' => 'docentlik'],
            ['ad' => 'İstanbul 29 Mayıs Üniversitesi', 'sehir' => 'İstanbul', 'tur' => 'vakif', 'baraj' => 55, 'kadro' => 'dr_ogr_uyesi'],
            ['ad' => 'Sakarya Üniversitesi', 'sehir' => 'Sakarya', 'tur' => 'devlet', 'baraj' => 80, 'kadro' => 'docentlik'],
        ];

        foreach ($universiteler as $veri) {
            $universite = Universite::query()->create([
                'ad' => $veri['ad'],
                'sehir' => $veri['sehir'],
                'tur' => $veri['tur'],
            ]);

            $this->yonergeOlustur(
                anahtar: str($veri['ad'])->slug().'-'.$veri['kadro'],
                ad: $veri['ad'].' — '.($veri['kadro'] === 'docentlik' ? 'Doçentlik' : 'Dr. Öğr. Üyesi'),
                kadro: $veri['kadro'],
                uakHedef: 100,
                universiteHedef: $veri['baraj'],
                kategoriKurallari: $kategoriKurallari,
                universite: $universite,
            );
        }
    }

    /**
     * @param  array<string, array{tavan: int, puanlar: array<string, int>, varsayilan: int}>  $kategoriKurallari
     */
    private function yonergeOlustur(
        string $anahtar,
        string $ad,
        string $kadro,
        int $uakHedef,
        int $universiteHedef,
        array $kategoriKurallari,
        ?Universite $universite,
    ): void {
        $yonerge = Yonerge::query()->create([
            'universite_id' => $universite?->id,
            'anahtar' => $anahtar,
            'ad' => $ad,
            'kadro' => $kadro,
            'yil' => 2026,
            'uak_hedef' => $uakHedef,
            'universite_hedef' => $universiteHedef,
        ]);

        foreach ($kategoriKurallari as $kategori => $kural) {
            $yonerge->kurallar()->create([
                'kategori' => $kategori,
                'tavan' => $kural['tavan'],
                'varsayilan_puan' => $kural['varsayilan'],
                'puanlar' => $kural['puanlar'],
            ]);
        }
    }
}
