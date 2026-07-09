<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('faaliyetler', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string('kategori');
            $table->string('tur');
            $table->string('baslik');
            $table->string('yazarlar')->nullable();
            $table->string('donem')->nullable();
            $table->string('kaynak')->nullable();
            $table->unsignedInteger('puan')->default(0);
            $table->string('durum')->default('beklemede');
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'kategori']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faaliyetler');
    }
};
