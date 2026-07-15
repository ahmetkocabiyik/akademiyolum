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

        // Tüm Türkiye üniversiteleri (onboarding/arama için) — yönergesiz oluşturulur.
        /** @var list<array{0: string, 1: string, 2: string}> $universiteler */
        $universiteler = require database_path('data/universiteler.php');

        foreach ($universiteler as [$ad, $sehir, $tur]) {
            Universite::query()->create(['ad' => $ad, 'sehir' => $sehir, 'tur' => $tur]);
        }

        // Üniversiteye özel Ek-1 puan cetvelleri (yoksa ÜAK cetveline düşülür).
        /** @var array<string, array<string, array{tavan: int, puanlar: array<string, int>, varsayilan: int}>> $cetveller */
        $cetveller = require database_path('data/cetveller.php');

        // Yönerge yalnızca doğrulanmış eşik verisi olan üniversiteler için oluşturulur;
        // gerçek eşikler EsikSeeder tarafından bu yönergelere bağlanır. (Tahmini baraj yok.)
        /** @var list<array<int, mixed>> $esikVerisi */
        $esikVerisi = require database_path('data/esikler.php');

        foreach (collect($esikVerisi)->pluck(0)->unique() as $ad) {
            $universite = Universite::query()->where('ad', $ad)->first();

            if ($universite === null) {
                continue;
            }

            $this->yonergeOlustur(
                anahtar: str($ad)->slug().'-yonerge',
                ad: $ad.' — Akademik Yükseltilme Yönergesi',
                kadro: 'docentlik',
                uakHedef: 100,
                universiteHedef: 0,
                kategoriKurallari: $cetveller[$ad] ?? $kategoriKurallari,
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
