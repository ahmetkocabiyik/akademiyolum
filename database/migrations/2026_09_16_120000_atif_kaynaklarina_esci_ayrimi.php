<?php

use App\Enums\Kategori;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const GENEL = 'WoS / Scopus';

    private const DUSUK = 'ESCI / Scopus';

    /**
     * Atıf kaynağı `WoS / Scopus` olan kayıtlar alt kademeye taşınır.
     *
     * Sözlük atıfta çekirdek indeksle (SCIE/SSCI/AHCI) ESCI'yi ayırdı; genel
     * etiket artık yalnız CETVEL tarafında yaşıyor ve adaya sorulmuyor
     * ({@see Kategori::GENEL_KAYNAKLAR}). Genel etiketle girilmiş
     * eski kayıt, ayrım yapan bir cetvel satırına DÜŞMEZ — motorun eşlemesi
     * tek yönlü: kapsamlı kayıt genel satırı karşılar, tersi olmaz.
     *
     * Hangi kademeye taşınacağı kayıttan okunamıyor, o yüzden §0 uyarınca
     * DÜŞÜK olanı seçiliyor: aday ESCI atfı görür, hak ettiğinden fazlasını
     * değil. Kaydını düzeltmek isteyen aday üst kademeyi kendisi seçebilir.
     */
    public function up(): void
    {
        DB::table('faaliyetler')
            ->where('kategori', 'atif')
            ->where('kaynak', self::GENEL)
            ->update(['kaynak' => self::DUSUK]);
    }

    /**
     * Geri alma TAM DEĞİL: `ESCI / Scopus` kayıtlarının hangisinin göçle
     * geldiği bilinmiyor, hepsi genel etikete döner.
     */
    public function down(): void
    {
        DB::table('faaliyetler')
            ->where('kategori', 'atif')
            ->where('kaynak', self::DUSUK)
            ->update(['kaynak' => self::GENEL]);
    }
};
