<?php

namespace Database\Seeders;

use App\Models\Universite;
use Illuminate\Database\Seeder;

class EsikSeeder extends Seeder
{
    /**
     * Doğrulanmış Dr. Öğr. Üyesi eşiklerini ilgili üniversitenin yönergesine bağlar.
     */
    public function run(): void
    {
        /** @var list<array<int, mixed>> $veri */
        $veri = require database_path('data/esikler.php');

        foreach ($veri as $satir) {
            [$ad, $kadro, $alan, $minToplam, $yayinMin, $indexMin, $ydsMin, $notlar] = $satir;
            $kosullar = $satir[8] ?? null;

            $universite = Universite::query()->where('ad', $ad)->with('yonergeler')->first();
            $yonerge = $universite?->yonergeler->first();

            if ($yonerge === null) {
                $this->command?->warn("Yönerge bulunamadı: {$ad}");

                continue;
            }

            $yonerge->esikler()->updateOrCreate(
                ['kadro' => $kadro, 'alan' => $alan],
                [
                    'min_toplam' => $minToplam,
                    'yayin_min' => $yayinMin,
                    'index_min' => $indexMin,
                    'yds_min' => $ydsMin,
                    'notlar' => $notlar,
                    'kosullar' => $kosullar,
                    'kaynak' => 'pdf',
                ],
            );
        }
    }
}
