<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Yalnızca `php artisan admin:yap` komutuyla verilir; arayüzden değil.
            $table->boolean('super_admin')->default(false)->after('password');
            // Doluysa hesap askıda: oturum açılamaz, açık oturum kapatılır.
            $table->timestamp('askiya_alindi_at')->nullable()->after('super_admin');
            $table->timestamp('son_giris_at')->nullable()->after('askiya_alindi_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['super_admin', 'askiya_alindi_at', 'son_giris_at']);
        });
    }
};
