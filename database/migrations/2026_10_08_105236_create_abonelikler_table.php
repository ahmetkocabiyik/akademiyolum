<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Abonelik GEÇMİŞİ: kullanıcı satırında tek bir "plan" alanı değil, her
 * dönem ayrı satır. Bugün admin elle atıyor (havale, kurum anlaşması);
 * ödeme sağlayıcısı (iyzico/PayTR) geldiğinde aynı tabloya `kaynak = odeme`
 * satırları yazılacak, panel değişmeyecek.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('abonelikler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('plan');
            $table->date('baslangic');
            // Boş: süresiz (ör. kurum anlaşması, test hesabı).
            $table->date('bitis')->nullable();
            $table->string('kaynak')->default('elle');
            // Kuruş cinsinden; ondalık para kayan noktada tutulmaz.
            $table->unsignedInteger('tutar_kurus')->nullable();
            $table->text('not')->nullable();
            $table->foreignId('olusturan_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('iptal_edildi_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'baslangic']);
            $table->index('bitis');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abonelikler');
    }
};
