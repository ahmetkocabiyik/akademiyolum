<?php

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
        Schema::table('cv_profilleri', function (Blueprint $table) {
            // Boş: çizgiler ana rengi izler.
            $table->string('cizgi_renk')->nullable()->after('renk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cv_profilleri', function (Blueprint $table) {
            $table->dropColumn('cizgi_renk');
        });
    }
};
