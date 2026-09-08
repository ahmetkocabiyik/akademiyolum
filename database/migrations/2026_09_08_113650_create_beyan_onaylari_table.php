<?php

use App\Services\Scoring\Sart\SartSonucu;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Adayın "bu belgem var" işaretleri.
     *
     * Bir satır TEK bir eşiğin TEK bir beyan koşulunu kapsıyor: aynı cümle
     * başka bir üniversitenin yönergesinde de geçse orada ayrıca işaretlenir.
     * Yönergeler aynı şeyi farklı kapsamla isteyebiliyor ("doktora sonrası
     * altı ay" kimi yerde yurt dışı, kimi yerde yurt içi de sayıyor); tek bir
     * işareti hepsine yaymak adayın vermediği bir beyanı üretirdi.
     *
     * `kosul_anahtari` koşul METNİNDEN türetiliyor
     * ({@see SartSonucu::beyanAnahtariUret()}),
     * ağaçtaki konumdan değil: yönerge dosyası düzenlenince düğümler yer
     * değiştirir ve konuma bağlı bir işaret sessizce başka koşula yapışırdı.
     */
    public function up(): void
    {
        Schema::create('beyan_onaylari', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('esik_anahtari');
            $table->string('kosul_anahtari', 32);
            $table->timestamps();

            // İşaret var/yok bilgisidir; aynı koşul iki kez işaretlenemez.
            $table->unique(['user_id', 'esik_anahtari', 'kosul_anahtari'], 'beyan_onaylari_benzersiz');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beyan_onaylari');
    }
};
