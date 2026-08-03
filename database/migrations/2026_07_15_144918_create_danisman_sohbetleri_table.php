<?php

use App\Models\DanismanSohbet;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('danisman_sohbetleri', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string('baslik')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'updated_at']);
        });

        Schema::table('danisman_mesajlari', function (Blueprint $table) {
            $table->foreignIdFor(DanismanSohbet::class)
                ->nullable()
                ->after('user_id')
                ->constrained('danisman_sohbetleri')
                ->cascadeOnDelete();
        });

        $this->mevcutMesajlariTasi();
    }

    /**
     * Sohbet kavramı öncesi kaydedilmiş mesajları, kullanıcı başına tek bir
     * sohbete taşıyarak korur.
     */
    private function mevcutMesajlariTasi(): void
    {
        $kullaniciIdleri = DB::table('danisman_mesajlari')
            ->whereNull('danisman_sohbet_id')
            ->distinct()
            ->pluck('user_id');

        foreach ($kullaniciIdleri as $userId) {
            $ilkMesaj = DB::table('danisman_mesajlari')
                ->where('user_id', $userId)
                ->orderBy('id')
                ->value('icerik');

            $sohbetId = DB::table('danisman_sohbetleri')->insertGetId([
                'user_id' => $userId,
                'baslik' => $ilkMesaj ? mb_substr($ilkMesaj, 0, 60) : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('danisman_mesajlari')
                ->where('user_id', $userId)
                ->whereNull('danisman_sohbet_id')
                ->update(['danisman_sohbet_id' => $sohbetId]);
        }
    }

    public function down(): void
    {
        Schema::table('danisman_mesajlari', function (Blueprint $table) {
            $table->dropConstrainedForeignIdFor(DanismanSohbet::class);
        });

        Schema::dropIfExists('danisman_sohbetleri');
    }
};
