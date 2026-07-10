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

        // Türkiye üniversiteleri. Baraj/kadro/yıl placeholder — üniversite adından
        // deterministik türetilir (gerçek yönerge verisi ileride girilecek).
        /** @var list<array{0: string, 1: string, 2: string}> $universiteler */
        $universiteler = require database_path('data/universiteler.php');

        foreach ($universiteler as [$ad, $sehir, $tur]) {
            $tohum = crc32($ad);
            $baraj = 55 + ($tohum % 71);        // 55–125
            $kadro = $tohum % 3 === 0 ? 'dr_ogr_uyesi' : 'docentlik';
            $yil = 2024 + ($tohum % 3);         // 2024–2026

            $universite = Universite::query()->create([
                'ad' => $ad,
                'sehir' => $sehir,
                'tur' => $tur,
            ]);

            $this->yonergeOlustur(
                anahtar: str($ad)->slug().'-'.$kadro,
                ad: $ad.' — '.($kadro === 'docentlik' ? 'Doçentlik' : 'Dr. Öğr. Üyesi'),
                kadro: $kadro,
                uakHedef: 100,
                universiteHedef: $baraj,
                kategoriKurallari: $kategoriKurallari,
                universite: $universite,
                yil: $yil,
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
        int $yil = 2026,
    ): void {
        $yonerge = Yonerge::query()->create([
            'universite_id' => $universite?->id,
            'anahtar' => $anahtar,
            'ad' => $ad,
            'kadro' => $kadro,
            'yil' => $yil,
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
