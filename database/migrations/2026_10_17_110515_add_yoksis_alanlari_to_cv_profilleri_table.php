<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * YÖK EK-4A özgeçmişinin sorduğu, CV'de olmayan alanlar.
     */
    public function up(): void
    {
        Schema::table('cv_profilleri', function (Blueprint $table) {
            $table->date('dogum_tarihi')->nullable()->after('ad');
            // [{unvan, kurum, alan, yil}] — Doçentlik, Profesörlük…
            $table->json('akademik_unvanlar')->nullable()->after('deneyimler');
            // [{kurulus, gorev, yil}] — bilimsel kuruluş üyelikleri
            $table->json('uyelikler')->nullable()->after('akademik_unvanlar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cv_profilleri', function (Blueprint $table) {
            $table->dropColumn(['dogum_tarihi', 'akademik_unvanlar', 'uyelikler']);
        });
    }
};
