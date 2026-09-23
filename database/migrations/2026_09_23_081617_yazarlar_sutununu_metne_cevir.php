<?php

use App\Services\Scoring\Sart\MaddeKatalogu;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * `yazarlar` 255 karaktere sığmıyor.
 *
 * APBS'ten içe aktarılan gerçek bir profilde çok yazarlı bildirilerin yazar
 * listesi 255 karakteri aşıyor ve ekleme "Data too long" ile yarıda
 * kalıyordu.
 *
 * KESİP YAZMAK ÇÖZÜM DEĞİL: puan motoru yazar sayısını bu alandaki
 * virgülleri sayarak buluyor ({@see MaddeKatalogu})
 * ve az yazar DAHA YÜKSEK çarpan demek. Kesilmiş bir liste adaya hak
 * etmediği puanı verirdi; alanın kendisi büyüyor.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('faaliyetler', function (Blueprint $tablo): void {
            $tablo->text('yazarlar')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('faaliyetler', function (Blueprint $tablo): void {
            $tablo->string('yazarlar')->nullable()->change();
        });
    }
};
