<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Çeyreksiz `Scopus` kayıtları en alt basamağa taşınır.
     *
     * Sözlük Scopus dergilerini çeyrekliğe göre ayırdı; genel `Scopus`
     * etiketi artık yalnız cetvel tarafında. Kaydın çeyrekliği bilinmiyor,
     * §0 uyarınca EN DÜŞÜK basamak seçiliyor — aday hak ettiğinden fazlasını
     * görmesin. Çeyrekliğini bilen aday kaydını kendisi yükseltebilir.
     */
    public function up(): void
    {
        DB::table('faaliyetler')
            ->whereIn('kategori', ['makale', 'tez_yayini', 'atif'])
            ->where('kaynak', 'Scopus')
            ->update(['kaynak' => 'Scopus (Q4)']);
    }

    public function down(): void
    {
        DB::table('faaliyetler')
            ->whereIn('kategori', ['makale', 'tez_yayini', 'atif'])
            ->where('kaynak', 'Scopus (Q4)')
            ->update(['kaynak' => 'Scopus']);
    }
};
