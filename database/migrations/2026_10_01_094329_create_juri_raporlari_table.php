<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * YZ jüri raporları — her satır bir çalıştırmanın DONMUŞ sonucu.
     *
     * Rapor yeniden üretilmiyor, saklanıyor: aday aynı dosya için "sert jüri"
     * ile "mentör" raporunu yan yana okuyabilsin ve iki ay sonra ne yazıldığını
     * görebilsin diye. Yeniden üretilse metin her seferinde başka çıkardı.
     *
     * `karar` ve `olcumler` YZ'den DEĞİL şart ağacı motorundan geliyor; sütunda
     * durmalarının sebebi raporun yazıldığı ANDAKİ ölçümü korumak. Aday sonradan
     * yayın eklediğinde eski rapor kendi sayılarıyla okunabilir kalır.
     */
    public function up(): void
    {
        Schema::create('juri_raporlari', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Hedef, yönerge dosyalarındaki eşik kimliğiyle saklanıyor:
            // üniversite ADI + kadro + birim. Universite tablosuna foreign key
            // verilmedi, çünkü eşikler ada göre çözülüyor (SartDeposu::bul).
            $table->string('universite');
            $table->string('hedef_kadro');
            $table->string('birim')->nullable();
            $table->string('alan');

            $table->string('sapka');
            $table->string('sertlik');
            $table->string('karar');

            // Ölçümler: [{etiket, mevcut, gerekli, oran}] — raporun başındaki
            // çubuklar. Adımlar: adım anahtarı => {agirlik, icerik}.
            $table->json('olcumler');
            $table->json('adimlar');
            $table->text('ozet');

            $table->timestamps();

            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('juri_raporlari');
    }
};
