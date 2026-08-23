<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Makalenin YAYIN TÜRÜ — özgün araştırma, derleme, kısa makale, editöre mektup.
 *
 * Yönergeler aynı dergide yayımlanmış iki çalışmayı türüne göre farklı
 * puanlıyor: Ege 1(a) Q1 özgün makale 75, 1(b) Q1 derleme 60, 1(c) Q1 editöre
 * mektup 25. `kaynak` alanı yalnızca dergiyi (indeks + çeyreklik) taşıdığı için
 * bu ayrım ifade edilemiyordu ve o kalemler cetvellere girilemiyordu.
 *
 * `rol` alanının yayın türü karşılığı: cetvel maddeleri `roller` gibi `turler`
 * ile sınırlanabiliyor.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('faaliyetler', function (Blueprint $table) {
            $table->string('yayin_turu')->nullable()->after('rol');
        });
    }

    public function down(): void
    {
        Schema::table('faaliyetler', function (Blueprint $table) {
            $table->dropColumn('yayin_turu');
        });
    }
};
