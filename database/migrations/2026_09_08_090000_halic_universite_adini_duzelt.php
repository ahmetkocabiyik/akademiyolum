<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const ESKI = 'Halic Üniversitesi';

    private const YENI = 'Haliç Üniversitesi';

    /**
     * Üniversite adındaki eksik çengel düzeltilir.
     *
     * `universiteler.php` ve `database/data/yonerge/halic.php` kurumu
     * "Haliç Üniversitesi" diye anıyor; tabloda ise çengelsiz "Halic"
     * yazıyordu. Yönerge Analizi ekranı tablodaki adı alıp `SartDeposu`ya
     * veriyor, orada karşılaştırma PHP tarafında BAYT BAYT yapıldığı için iki
     * yazım tutmuyordu: Haliç'in yönergesi girili olduğu hâlde aday onu
     * "temel alanınıza ölçüt tanımlamayan üniversiteler" arasında görüyordu.
     *
     * `UniversiteSeeder` bunu kendi başına düzeltemez: MySQL'in varsayılan
     * harmanlaması aksanı yok saydığı için `updateOrCreate(['ad' => 'Haliç…'])`
     * çengelsiz satırı BULUYOR ve adı değiştirmeden güncelliyor. Aynı sebeple
     * buradaki karşılaştırmalar da veritabanına bırakılmıyor, PHP'de bayt bayt
     * yapılıyor — {@see 2026_08_29_140000_munzur_universite_adini_duzelt.php}
     * tarzı düz bir `where('ad', $yeni)` MySQL'de erken dönerdi. (`BINARY`
     * çözüm değil: testler SQLite üzerinde koşuyor, orada öyle bir sözdizimi
     * yok.)
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
        if ($this->idleri('universiteler', 'ad', $yeni) !== []) {
            return;
        }

        DB::table('universiteler')
            ->whereIn('id', $this->idleri('universiteler', 'ad', $eski))
            ->update(['ad' => $yeni]);

        DB::table('users')
            ->whereIn('id', $this->idleri('users', 'universite', $eski))
            ->update(['universite' => $yeni]);
    }

    /**
     * Sütunu verilen değere BAYT BAYT eşit olan satırların id'leri.
     *
     * @return list<int>
     */
    private function idleri(string $tablo, string $sutun, string $deger): array
    {
        $idler = [];

        foreach (DB::table($tablo)->select('id', $sutun)->get() as $satir) {
            if ($satir->{$sutun} === $deger) {
                $idler[] = (int) $satir->id;
            }
        }

        return $idler;
    }
};
