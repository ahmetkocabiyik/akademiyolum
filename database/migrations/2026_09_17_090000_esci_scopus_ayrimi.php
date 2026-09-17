<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const GENEL = ['ESCI / Scopus', 'ESCI / Scopus Dergi'];

    /**
     * `ESCI / Scopus` kayıtları alt kademeye taşınır.
     *
     * Sözlük ESCI ile Scopus'u ayırdı; genel etiket artık yalnız cetvel
     * tarafında yaşıyor ve adaya sorulmuyor. Hangi indeks olduğu kayıttan
     * okunamıyor, o yüzden §0 uyarınca kaynakların ayrım yaptığı yerlerde
     * DÜŞÜK kalan seçiliyor.
     *
     * Ayrım yapan altı kaynağın dördünde Scopus daha düşük (Akdeniz 30↔50,
     * Kocaeli 20↔25, Hitit 10↔14, KTÜ atıf 2↔3), birinde ESCI düşük
     * (Aksaray 18↔20). Çoğunluk Scopus yönünde, göç oraya yapılıyor;
     * kaydını düzeltmek isteyen aday ESCI'yi kendisi seçebilir.
     */
    public function up(): void
    {
        DB::table('faaliyetler')->where('kaynak', 'ESCI / Scopus')->update(['kaynak' => 'Scopus']);
        DB::table('faaliyetler')->where('kaynak', 'ESCI / Scopus Dergi')->update(['kaynak' => 'Scopus Dergi']);
    }

    /**
     * Geri alma TAM DEĞİL: hangi `Scopus` kaydının göçle geldiği bilinmiyor.
     */
    public function down(): void
    {
        DB::table('faaliyetler')->where('kaynak', 'Scopus')->update(['kaynak' => self::GENEL[0]]);
        DB::table('faaliyetler')->where('kaynak', 'Scopus Dergi')->update(['kaynak' => self::GENEL[1]]);
    }
};
