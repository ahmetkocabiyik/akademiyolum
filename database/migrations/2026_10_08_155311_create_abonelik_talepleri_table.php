<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Ücretli paket TALEPLERİ: online ödeme gelene kadar kullanıcı onboarding'de
 * paketi seçer, yönetici ödemeyi aldıktan sonra talebi aboneliğe çevirir.
 * Ödeme sağlayıcısı geldiğinde talep yerine ödeme sayfası açılacak.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('abonelik_talepleri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('plan');
            $table->string('donem');
            // bekliyor · tamamlandi · kapatildi
            $table->string('durum')->default('bekliyor');
            $table->foreignId('abonelik_id')->nullable()->constrained('abonelikler')->nullOnDelete();
            $table->foreignId('sonuclandiran_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('sonuclandi_at')->nullable();
            $table->timestamps();

            $table->index(['durum', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abonelik_talepleri');
    }
};
