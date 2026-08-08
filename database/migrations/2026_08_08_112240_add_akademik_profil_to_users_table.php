<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Şart ağacının `donem` ve `metrik` yapraklarının okuduğu akademik profil.
     *
     * Bunlar faaliyet satırı DEĞİL, adaya ait skaler değerlerdir; korpustaki
     * yönergelerin %78'i en az birini arıyor. Hepsi nullable: girilmemiş bir
     * değer koşulu "sağlanmadı" yapmaz, "belirsiz" yapar.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Dönem referans tarihleri ("doktora sonrası", "doçentlik sonrası"...)
            $table->date('lisans_tarihi')->nullable()->after('temel_alan');
            $table->date('doktora_tarihi')->nullable()->after('lisans_tarihi');
            $table->date('docentlik_tarihi')->nullable()->after('doktora_tarihi');
            $table->date('son_atama_tarihi')->nullable()->after('docentlik_tarihi');

            // Yabancı dil: eşik birimin öğretim diline göre kademeli olabiliyor.
            $table->string('program_dili')->nullable()->after('son_atama_tarihi');
            $table->unsignedSmallInteger('yds_puani')->nullable()->after('program_dili');

            // Sayaç ölçütleri
            $table->unsignedSmallInteger('h_indeksi')->nullable()->after('yds_puani');
            $table->unsignedInteger('atif_sayisi')->nullable()->after('h_indeksi');
            $table->unsignedSmallInteger('ders_yariyil')->nullable()->after('atif_sayisi');
            $table->unsignedSmallInteger('yurtdisi_ay')->nullable()->after('ders_yariyil');
            $table->unsignedSmallInteger('tez_danismanlik')->nullable()->after('yurtdisi_ay');
            $table->unsignedSmallInteger('doktora_tez_danismanlik')->nullable()->after('tez_danismanlik');
            $table->unsignedSmallInteger('proje_yurutuculuk')->nullable()->after('doktora_tez_danismanlik');
            $table->unsignedSmallInteger('proje_arastirmaci')->nullable()->after('proje_yurutuculuk');
            $table->unsignedSmallInteger('proje_danisman')->nullable()->after('proje_arastirmaci');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'lisans_tarihi', 'doktora_tarihi', 'docentlik_tarihi', 'son_atama_tarihi',
                'program_dili', 'yds_puani', 'h_indeksi', 'atif_sayisi', 'ders_yariyil',
                'yurtdisi_ay', 'tez_danismanlik', 'doktora_tez_danismanlik',
                'proje_yurutuculuk', 'proje_arastirmaci', 'proje_danisman',
            ]);
        });
    }
};
