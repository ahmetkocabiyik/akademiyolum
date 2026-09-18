<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Çeyreksiz `Scopus Dergi` editörlük kayıtları en alt basamağa taşınır.
     *
     * Acıbadem'in 2.G satırı "WoS All Databases ya da SCOPUS Q1-Q2
     * kapsamındaki dergi" diyor; kaynak Scopus'un yalnız üst iki çeyreğini
     * sayıyor. Sözlükte editörlük tarafında çeyreklik olmadığı için satırın
     * Scopus tarafı hiç bağlanamıyordu. Çeyreklik eklendi; genel
     * `Scopus Dergi` artık yalnız cetvel tarafında.
     *
     * Mevcut kaydın çeyrekliği bilinmiyor, §0 uyarınca EN DÜŞÜK basamak
     * seçiliyor. Çeyrekliğini bilen aday kaydını kendisi yükseltebilir.
     */
    public function up(): void
    {
        DB::table('faaliyetler')
            ->where('kategori', 'editorluk')
            ->where('kaynak', 'Scopus Dergi')
            ->update(['kaynak' => 'Scopus Dergi (Q4)']);
    }

    public function down(): void
    {
        DB::table('faaliyetler')
            ->where('kategori', 'editorluk')
            ->where('kaynak', 'Scopus Dergi (Q4)')
            ->update(['kaynak' => 'Scopus Dergi']);
    }
};
