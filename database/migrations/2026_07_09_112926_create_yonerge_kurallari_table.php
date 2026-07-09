<?php

use App\Models\Yonerge;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('yonerge_kurallari', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Yonerge::class)->constrained('yonergeler')->cascadeOnDelete();
            $table->string('kategori');
            $table->unsignedInteger('tavan')->default(0);
            $table->unsignedInteger('varsayilan_puan')->default(0);
            $table->json('puanlar')->nullable();
            $table->timestamps();

            $table->unique(['yonerge_id', 'kategori']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('yonerge_kurallari');
    }
};
