<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Resmî ve Sade şablonları kaldırıldı. Onları seçmiş CV'ler Minimal'e
 * taşınıyor: ikisi de beyaz başlıklıydı, en yakın kalan şablon o. Taşınmasa
 * `sablon` enum dönüşümü bu satırlarda hata verirdi.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::table('cv_profilleri')
            ->whereIn('sablon', ['resmi', 'sade'])
            ->update(['sablon' => 'minimal']);
    }

    /**
     * Geri alınamaz: hangi satırın Resmî, hangisinin Sade olduğu bilgisi
     * taşımada kayboluyor.
     */
    public function down(): void
    {
        //
    }
};
