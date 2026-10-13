<?php

namespace Database\Seeders;

use App\Models\Universite;
use App\Models\UniversiteBirimi;
use App\Services\Kurum\BirimKatalogu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Üniversitelerin fakülte ve programlarını database/data/universite-birimleri.json
 * dosyasından yükler (bkz. universite:birimleri-cek).
 *
 * Tablo baştan yazılır: atlas her yıl program kapatıp açıyor, güncelleme
 * yerine silip yazmak kapanan programları da temizliyor. Kullanıcı tablosu
 * buraya bağlı değil (fakülte metin olarak saklanıyor), silmek güvenli.
 */
class UniversiteBirimiSeeder extends Seeder
{
    public function run(): void
    {
        /** @var array<string, array<string, list<string>>> $veri */
        $veri = json_decode((string) file_get_contents(BirimKatalogu::veriDosyasi()), true, flags: JSON_THROW_ON_ERROR);

        $kimlikler = Universite::query()->pluck('id', 'ad');
        $satirlar = [];

        foreach ($veri as $universite => $fakulteler) {
            $kimlik = $kimlikler[$universite] ?? null;

            if ($kimlik === null) {
                continue;
            }

            foreach ($fakulteler as $fakulte => $bolumler) {
                foreach ($bolumler as $bolum) {
                    $satirlar[] = ['universite_id' => $kimlik, 'fakulte' => $fakulte, 'bolum' => $bolum];
                }
            }
        }

        DB::transaction(function () use ($satirlar): void {
            UniversiteBirimi::query()->delete();

            foreach (array_chunk($satirlar, 500) as $parca) {
                UniversiteBirimi::query()->insert($parca);
            }
        });
    }
}
