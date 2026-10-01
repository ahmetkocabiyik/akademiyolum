<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Adayın CV'si — kullanıcı başına TEK satır.
     *
     * Künye alanları (unvan, kurum, bölüm, e-posta) users tablosunda da var ama
     * burada KOPYALANIYOR: CV'de yazan unvan ile sistemdeki unvan aynı olmak
     * zorunda değil. Aday CV'sinde "Dr." yazmak isterken profilde "Arş. Gör."
     * kalabilir ve CV'yi düzenlemek yönerge analizinin kadro hesabını
     * değiştirmemeli. Alanlar ilk açılışta profilden DOLDURULUR, sonra kendi
     * hayatını yaşar.
     *
     * Yayınlar kopyalanmıyor: faaliyet kayıtlarından okunuyor, yalnızca CV dışı
     * bırakılanların kimliği `haric_faaliyetler`da tutuluyor. Kopyalansaydı
     * aday yayınını düzelttiğinde CV eski hâliyle kalırdı.
     */
    public function up(): void
    {
        Schema::create('cv_profilleri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();

            // Künye
            $table->string('ad')->nullable();
            $table->string('unvan')->nullable();
            $table->string('kurum')->nullable();
            $table->string('bolum')->nullable();
            $table->string('eposta')->nullable();
            $table->string('telefon')->nullable();
            $table->string('sehir')->nullable();
            $table->string('web')->nullable();
            $table->text('ozet')->nullable();

            // Listeler
            $table->json('egitimler');
            $table->json('deneyimler');
            $table->json('beceriler');
            $table->json('diller');
            $table->json('haric_faaliyetler');

            // Sunum
            $table->string('sablon');
            $table->string('renk');
            $table->string('yazi_tipi');
            $table->json('bolumler');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cv_profilleri');
    }
};
