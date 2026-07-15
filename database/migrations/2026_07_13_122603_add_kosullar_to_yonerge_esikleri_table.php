<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('yonerge_esikleri', function (Blueprint $table) {
            // Yapısal alt-koşullar (adet/yazarlık/veya). Düz puan barajlarının yanında.
            $table->json('kosullar')->nullable()->after('yds_min');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('yonerge_esikleri', function (Blueprint $table) {
            $table->dropColumn('kosullar');
        });
    }
};
