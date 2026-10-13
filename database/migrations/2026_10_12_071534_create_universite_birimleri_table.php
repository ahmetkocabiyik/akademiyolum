<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Üniversitelerin fakülte/yüksekokul ve programları (YÖK Atlas tercih
 * kılavuzundan). Kurulum ve profil ekranlarında fakülte ve bölüm
 * seçenekleri buradan gelir. Kaynak: database/data/universite-birimleri.json
 * (bkz. universite:birimleri-cek), UniversiteBirimiSeeder ile yüklenir.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('universite_birimleri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('universite_id')->constrained('universiteler')->cascadeOnDelete();
            $table->string('fakulte');
            $table->string('bolum');

            $table->unique(['universite_id', 'fakulte', 'bolum']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('universite_birimleri');
    }
};
