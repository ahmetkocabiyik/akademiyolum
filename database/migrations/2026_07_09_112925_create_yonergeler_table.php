<?php

use App\Models\Universite;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('yonergeler', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Universite::class)->nullable()->constrained('universiteler')->nullOnDelete();
            $table->string('anahtar')->unique();
            $table->string('ad');
            $table->string('kadro')->default('docentlik'); // docentlik | dr_ogr_uyesi
            $table->unsignedSmallInteger('yil')->default(2026);
            $table->unsignedInteger('uak_hedef')->default(100);
            $table->unsignedInteger('universite_hedef')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('yonergeler');
    }
};
