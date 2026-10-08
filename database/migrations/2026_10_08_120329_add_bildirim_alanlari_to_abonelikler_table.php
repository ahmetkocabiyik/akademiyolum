<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Zamanlanmış bildirimlerin "gönderildi" izleri: görev her gün çalışıyor,
 * aynı abonelik için hatırlatma ya da "sona erdi" maili ikinci kez gitmesin.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('abonelikler', function (Blueprint $table) {
            $table->timestamp('hatirlatma_gonderildi_at')->nullable()->after('iptal_edildi_at');
            $table->timestamp('bitis_bildirimi_gonderildi_at')->nullable()->after('hatirlatma_gonderildi_at');
        });
    }

    public function down(): void
    {
        Schema::table('abonelikler', function (Blueprint $table) {
            $table->dropColumn(['hatirlatma_gonderildi_at', 'bitis_bildirimi_gonderildi_at']);
        });
    }
};
