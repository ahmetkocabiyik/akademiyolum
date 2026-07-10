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
        Schema::table('universiteler', function (Blueprint $table) {
            $table->string('yonerge_url')->nullable()->after('tur');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('universiteler', function (Blueprint $table) {
            $table->dropColumn('yonerge_url');
        });
    }
};
