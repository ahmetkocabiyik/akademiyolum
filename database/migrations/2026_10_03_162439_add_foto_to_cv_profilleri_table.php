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
            // `local` (özel) diskteki yol; dosya public/ dışında, yalnızca
            // sahibine CvFotoController üzerinden akıtılıyor.
            $table->string('foto')->nullable()->after('ozet');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cv_profilleri', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
    }
};
