<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Kapanmış ve mükerrer üniversiteleri seçim listesinden kaldırır.
 *
 * UniversiteSeeder yalnızca ekleyip günceller, silmez; data dosyasından
 * çıkarılan kayıt veritabanında kalıyordu. Kullanıcı tablosu üniversiteyi
 * metin olarak tuttuğu için bunları seçmiş kullanıcının profili etkilenmez.
 *
 *   İstanbul Şehir Üniversitesi — 2020'de kapatıldı (programları Marmara'ya).
 *   Süleyman Şah Üniversitesi — 2016'da KHK ile kapatıldı.
 *   Tunceli Munzur Üniversitesi — "Munzur Üniversitesi"nin mükerrer kaydı.
 */
return new class extends Migration
{
    public const KALDIRILANLAR = [
        'İstanbul Şehir Üniversitesi',
        'Süleyman Şah Üniversitesi',
        'Tunceli Munzur Üniversitesi',
    ];

    public function up(): void
    {
        DB::table('universiteler')->whereIn('ad', self::KALDIRILANLAR)->delete();
    }

    public function down(): void
    {
        // Geri alınmaz: kayıtlar yalnızca isimden ibaretti, yönerge verileri yok.
    }
};
