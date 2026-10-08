<?php

use App\Enums\EpostaTuru;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Panelden düzenlenen e-posta şablonları. Satır yoksa koddaki varsayılan
 * kullanılır ({@see EpostaTuru}); "varsayılana dön" satırı siler.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eposta_sablonlari', function (Blueprint $table) {
            $table->id();
            $table->string('tur')->unique();
            $table->string('konu');
            // Markdown + {degisken} yer tutucuları; Blade değil (bkz. EpostaGonderici).
            $table->text('govde');
            $table->boolean('aktif')->default(true);
            $table->foreignId('guncelleyen_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eposta_sablonlari');
    }
};
