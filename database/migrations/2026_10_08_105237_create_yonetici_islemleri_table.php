<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Yöneticinin yaptığı her işlemin kaydı: kim, kime, ne, ne zaman.
 *
 * Kayıtlar kullanıcı silinince de kalır: hedef ve yönetici yabancı anahtarları
 * null'a düşer, kimlik `hedef_eposta` / `yonetici_eposta` anlık görüntüsünden
 * okunur. Aksi hâlde "kullanıcıyı sildi" kaydı silinen kullanıcıyla birlikte
 * giderdi.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('yonetici_islemleri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('yonetici_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('yonetici_eposta')->nullable();
            $table->foreignId('hedef_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('hedef_eposta')->nullable();
            $table->string('islem');
            $table->json('detay')->nullable();
            $table->string('ip', 45)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['hedef_user_id', 'created_at']);
            $table->index('islem');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('yonetici_islemleri');
    }
};
