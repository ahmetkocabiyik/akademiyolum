<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Abonelik paketlerinin panelden düzenlenen bilgileri. Paket KİMLİĞİ
 * (`plan`) koddaki Plan enum'u: plan kısıtlamaları koda bağlanacağı için
 * paket eklenip silinmiyor, yalnızca bilgileri değişiyor. Satırlar ilk
 * kullanımda varsayılanlarla oluşturuluyor (PaketKatalogu).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paketler', function (Blueprint $table) {
            $table->id();
            $table->string('plan')->unique();
            $table->string('ad');
            $table->string('aciklama')->nullable();
            // Kuruş cinsinden; ondalık para kayan noktada tutulmaz.
            $table->unsignedInteger('aylik_fiyat_kurus')->default(0);
            // Boş: yıllık fiyat yok, 12 ay × aylık önerilir.
            $table->unsignedInteger('yillik_fiyat_kurus')->nullable();
            $table->json('ozellikler');
            $table->string('buton_metni');
            // Satışta değilse tanıtım sayfasında görünmez; mevcut aboneler etkilenmez.
            $table->boolean('satista')->default(true);
            $table->boolean('one_cikan')->default(false);
            $table->foreignId('guncelleyen_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paketler');
    }
};
