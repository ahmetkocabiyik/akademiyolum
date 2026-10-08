<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Panelden geçici olarak yayından kaldırılmış yönergeler.
 *
 * Yönerge verisi kodda (database/data/yonerge); bu tablo yalnızca üstüne
 * binen bir "gizle" katmanı. Üniversite ADIYLA eşleşiyor: yönerge dosyaları
 * üniversiteyi adıyla tanımlıyor, `universiteler` tablosunda karşılığı
 * olmayan yönergeler de var.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gizli_yonergeler', function (Blueprint $table) {
            $table->id();
            $table->string('universite')->unique();
            $table->string('neden');
            $table->foreignId('gizleyen_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gizli_yonergeler');
    }
};
