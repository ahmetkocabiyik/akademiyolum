<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('yonerge_esikleri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('yonerge_id')->constrained('yonergeler')->cascadeOnDelete();
            $table->string('kadro')->default('dr_ogr_uyesi'); // dr_ogr_uyesi | docentlik | profesor
            $table->string('alan')->default('genel');
            $table->unsignedInteger('min_toplam');
            $table->unsignedInteger('yayin_min')->nullable();   // makale/yayın kategorilerinden asgari puan
            $table->unsignedInteger('index_min')->nullable();   // SCIE/SSCI/AHCI vb. asgari puan
            $table->unsignedSmallInteger('yds_min')->nullable();
            $table->text('notlar')->nullable();
            $table->string('kaynak')->default('tahmini');       // pdf | tahmini
            $table->timestamps();

            $table->unique(['yonerge_id', 'kadro', 'alan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('yonerge_esikleri');
    }
};
