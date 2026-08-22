<?php

namespace Database\Seeders;

use App\Models\Universite;
use Illuminate\Database\Seeder;

/**
 * Türkiye'deki üniversiteleri seed eder.
 *
 * Yönerge verisi ARTIK SEED EDİLMİYOR: şart ağaçları ve puan cetvelleri
 * database/data/yonerge ve database/data/cetvel altındaki dosyalarda duruyor,
 * App\Services\Scoring\Sart\SartDeposu onları doğrudan okuyor. Bu tabloya
 * yalnızca arama/filtre için üniversite listesi giriyor.
 */
class UniversiteSeeder extends Seeder
{
    public function run(): void
    {
        /** @var list<array{0: string, 1: string, 2: string}> $universiteler */
        $universiteler = require database_path('data/universiteler.php');

        foreach ($universiteler as [$ad, $sehir, $tur]) {
            Universite::query()->updateOrCreate(['ad' => $ad], ['sehir' => $sehir, 'tur' => $tur]);
        }
    }
}
