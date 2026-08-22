<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Program/birim seçimi.
 *
 * Bazı yönergeler (ör. Sabancı) kriterleri temel alana değil PROGRAMA göre
 * yazıyor: aynı `muhendislik` alanında Bilgisayar Bilimleri ile Endüstri
 * Mühendisliği farklı şartlara tabi. Program bilinmeden doğru eşik seçilemez.
 *
 * `fakulte`/`bolum` alanlarından ayrı tutuldu: onlar genel bir listeden
 * geliyor, bu alan doğrudan yönerge verisindeki `birim` değerleriyle eşleşir.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('birim')->nullable()->after('bolum');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('birim');
        });
    }
};
