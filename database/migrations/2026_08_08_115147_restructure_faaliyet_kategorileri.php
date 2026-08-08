<?php

use App\Services\Scoring\Sart\ProfilCozucu;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Faaliyet kategorileri yönerge korpusuna göre yeniden düzenlenir.
     *
     * 1) `yazar_rolu` → `rol`: alan artık yalnızca yazarlığı değil, adayın
     *    faaliyetteki görevini taşıyor (projede yürütücü/araştırmacı/danışman,
     *    tez danışmanlığında danışman/eş danışman).
     *
     * 2) `toplumsal_katki` ve `diger` kategorileri proje, patent, bildiri, ödül
     *    ve tez danışmanlığını zorla barındırıyordu; bu faaliyetler kendi
     *    kategorilerine taşınır.
     *
     * 3) Atıf ve proje sayaçları `users` tablosundan kaldırılır — bu değerler
     *    artık faaliyet satırlarından türetiliyor ({@see ProfilCozucu}).
     */
    public function up(): void
    {
        Schema::table('faaliyetler', function (Blueprint $table) {
            $table->renameColumn('yazar_rolu', 'rol');
        });

        // Eski kaynak etiketi → [yeni kategori, yeni kaynak, rol]
        $tasima = [
            'toplumsal_katki' => [
                'Uluslararası Patent' => ['patent', 'Uluslararası Patent', null],
                'Ulusal Patent' => ['patent', 'Ulusal Patent', null],
                'AB/TÜBİTAK Koordinatör' => ['proje', 'AB Çerçeve / Ufuk', 'yurutucu'],
                'AB/TÜBİTAK Araştırmacı' => ['proje', 'AB Çerçeve / Ufuk', 'arastirmaci'],
                'Kamu Ar-Ge / Danışman' => ['proje', 'Diğer Kamu Kurumu', 'danisman'],
                'BAP Yürütücü' => ['proje', 'BAP (Üniversite)', 'yurutucu'],
            ],
            'diger' => [
                'Ödül (YÖK/TÜBİTAK/TÜBA)' => ['odul', 'TÜBİTAK / TÜBA Ödülü', null],
                'Doktora Tez Danışmanlığı' => ['tez_danismanligi', 'Doktora Tezi', 'danisman'],
                'Yüksek Lisans Tez Danışmanlığı' => ['tez_danismanligi', 'Yüksek Lisans Tezi', 'danisman'],
                'Uluslararası Bildiri (CPCI)' => ['bildiri', 'Uluslararası Tam Metin (CPCI)', null],
                'Diğer Bildiri' => ['bildiri', 'Ulusal Tam Metin', null],
            ],
        ];

        foreach ($tasima as $eskiKategori => $eslemeler) {
            foreach ($eslemeler as $eskiKaynak => [$kategori, $kaynak, $rol]) {
                DB::table('faaliyetler')
                    ->where('kategori', $eskiKategori)
                    ->where('kaynak', $eskiKaynak)
                    ->update(array_filter([
                        'kategori' => $kategori,
                        'kaynak' => $kaynak,
                        'rol' => $rol,
                    ], fn ($v) => $v !== null));
            }
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'atif_sayisi',
                'ders_yariyil',
                'tez_danismanlik',
                'doktora_tez_danismanlik',
                'proje_yurutuculuk',
                'proje_arastirmaci',
                'proje_danisman',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('atif_sayisi')->nullable();
            $table->unsignedSmallInteger('ders_yariyil')->nullable();
            $table->unsignedSmallInteger('tez_danismanlik')->nullable();
            $table->unsignedSmallInteger('doktora_tez_danismanlik')->nullable();
            $table->unsignedSmallInteger('proje_yurutuculuk')->nullable();
            $table->unsignedSmallInteger('proje_arastirmaci')->nullable();
            $table->unsignedSmallInteger('proje_danisman')->nullable();
        });

        Schema::table('faaliyetler', function (Blueprint $table) {
            $table->renameColumn('rol', 'yazar_rolu');
        });
    }
};
