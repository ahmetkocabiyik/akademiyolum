<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const ESKI = 'Tunceli Munzur Üniversitesi';

    private const YENI = 'Munzur Üniversitesi';

    /**
     * Üniversite adı yönergedeki ve resmî kullanımdaki yazımla hizalanır.
     *
     * `database/data/yonerge/munzur.php` ile üniversitenin kendi yönergesi
     * kurumu "Munzur Üniversitesi" diye anıyor; `universiteler.php` ise
     * eski adıyla "Tunceli Munzur Üniversitesi" diyordu. Yönerge Analizi
     * ekranı `Universite` tablosunu gezip her satırın adıyla eşik aradığı
     * için iki yazım tutmayınca Munzur'un eşikleri adaya hiç görünmezdi.
     *
     * Satır YERİNDE güncelleniyor: `UniversiteSeeder` `ad` alanına göre
     * `updateOrCreate` yaptığından, yalnızca veri dosyasını değiştirmek yeni
     * bir satır açıp eskisini öksüz bırakırdı.
     *
     * `users.universite` ad tutan bir metin sütunu; o da birlikte taşınıyor.
     */
    public function up(): void
    {
        $this->yenidenAdlandir(self::ESKI, self::YENI);
    }

    public function down(): void
    {
        $this->yenidenAdlandir(self::YENI, self::ESKI);
    }

    private function yenidenAdlandir(string $eski, string $yeni): void
    {
        // Hedef ad zaten varsa (taze seed) yapacak bir şey yok; iki satırı
        // birleştirmeye kalkmak sessizce veri kaybettirirdi.
        if (DB::table('universiteler')->where('ad', $yeni)->exists()) {
            return;
        }

        DB::table('universiteler')->where('ad', $eski)->update(['ad' => $yeni]);
        DB::table('users')->where('universite', $eski)->update(['universite' => $yeni]);
    }
};
