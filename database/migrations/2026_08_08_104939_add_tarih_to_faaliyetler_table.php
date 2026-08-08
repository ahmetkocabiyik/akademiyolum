<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Faaliyetin yayım/gerçekleşme tarihi.
     *
     * Korpustaki yönergelerin %77'si faaliyeti bir zaman penceresine hapsediyor
     * ("doktora sonrası", "doçentlik sonrası", "son atamadan bu yana", "son 5
     * yılda"). Bu alan olmadan o koşullar değerlendirilemiyordu. Nullable:
     * tarihi girilmemiş faaliyet, dönem kapsamlı bir koşulda "sağlanmadı"
     * değil "belirsiz" üretir.
     */
    public function up(): void
    {
        Schema::table('faaliyetler', function (Blueprint $table) {
            $table->date('tarih')->nullable()->after('donem');
        });
    }

    public function down(): void
    {
        Schema::table('faaliyetler', function (Blueprint $table) {
            $table->dropColumn('tarih');
        });
    }
};
