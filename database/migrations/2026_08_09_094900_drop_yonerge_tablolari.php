<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Eski puanlama motorunun tabloları kaldırılır.
     *
     * Yönergeler artık veritabanında değil, sürüm kontrolündeki veri
     * dosyalarında tutuluyor (database/data/yonerge, database/data/cetvel) ve
     * App\Services\Scoring\Sart\SartDeposu tarafından okunuyor. Yönerge verisi
     * kullanıcı verisi değil, uygulamanın kendi bilgisi; migration'la seed
     * edilmesi hem kaynağı gizliyor hem de sürüm takibini imkânsız kılıyordu.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('yonerge_id');
            $table->dropColumn('yonerge');
        });

        Schema::dropIfExists('yonerge_esikleri');
        Schema::dropIfExists('yonerge_kurallari');
        Schema::dropIfExists('yonergeler');
    }

    public function down(): void
    {
        Schema::create('yonergeler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('universite_id')->nullable()->constrained('universiteler')->cascadeOnDelete();
            $table->string('anahtar')->unique();
            $table->string('ad');
            $table->string('kadro')->default('docentlik');
            $table->unsignedSmallInteger('yil')->nullable();
            $table->unsignedInteger('uak_hedef')->default(0);
            $table->unsignedInteger('universite_hedef')->default(0);
            $table->timestamps();
        });

        Schema::create('yonerge_kurallari', function (Blueprint $table) {
            $table->id();
            $table->foreignId('yonerge_id')->constrained('yonergeler')->cascadeOnDelete();
            $table->string('kategori');
            $table->unsignedInteger('tavan')->default(0);
            $table->unsignedInteger('varsayilan_puan')->default(0);
            $table->json('puanlar')->nullable();
            $table->timestamps();
            $table->unique(['yonerge_id', 'kategori']);
        });

        Schema::create('yonerge_esikleri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('yonerge_id')->constrained('yonergeler')->cascadeOnDelete();
            $table->string('kadro')->default('dr_ogr_uyesi');
            $table->string('alan')->default('genel');
            $table->unsignedInteger('min_toplam');
            $table->unsignedInteger('yayin_min')->nullable();
            $table->unsignedInteger('index_min')->nullable();
            $table->unsignedSmallInteger('yds_min')->nullable();
            $table->text('notlar')->nullable();
            $table->json('kosullar')->nullable();
            $table->string('kaynak')->default('tahmini');
            $table->timestamps();
            $table->unique(['yonerge_id', 'kadro', 'alan']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('yonerge')->nullable()->after('avesis_id');
            $table->foreignId('yonerge_id')->nullable()->after('yonerge')->constrained('yonergeler')->nullOnDelete();
        });
    }
};
