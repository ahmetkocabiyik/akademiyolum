<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * YZ özelliklerinin (Danışman, Jüri Analizi) panelden seçilen sağlayıcı ve
 * modeli. Satır yoksa .env'deki varsayılan geçerli (YzAyarlari). API
 * anahtarları burada TUTULMAZ; .env'de kalır.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('yz_ayarlari', function (Blueprint $table) {
            $table->id();
            $table->string('ozellik')->unique();
            $table->string('saglayici');
            // Boş: sağlayıcının .env'deki varsayılan modeli.
            $table->string('model')->nullable();
            $table->foreignId('guncelleyen_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('yz_ayarlari');
    }
};
