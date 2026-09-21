<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * DergiPark'ın dergi dizin sayfalarının yerel kopyası.
     *
     * Her faaliyet için o sayfayı yeniden çekmek hem yavaş hem kaba: aynı
     * dergide onlarca yayını olan aday aynı sayfayı onlarca kez indirirdi.
     * `kontrol_edildi_at` tazeliği söylüyor — DergiPark'ın kendi uyarısı da
     * "dizin güncelliğini kontrol edin" diyor, kopya süresiz saklanmaz.
     */
    public function up(): void
    {
        Schema::create('dergiler', function (Blueprint $tablo) {
            $tablo->id();
            $tablo->string('slug')->unique();
            $tablo->string('ad')->nullable();
            /** Puanı belirleyen dizinler (SCIE, ESCI, Scopus, TR Dizin…). */
            $tablo->json('atif_dizinleri')->nullable();
            /** Uzun kuyruk (EBSCO, SOBİAD, Index Copernicus…). */
            $tablo->json('diger_dizinler')->nullable();
            $tablo->timestamp('kontrol_edildi_at')->nullable();
            $tablo->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dergiler');
    }
};
