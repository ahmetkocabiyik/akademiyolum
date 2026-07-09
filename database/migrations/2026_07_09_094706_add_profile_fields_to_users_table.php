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
        Schema::table('users', function (Blueprint $table) {
            $table->string('unvan')->nullable()->after('name');
            $table->string('universite')->nullable()->after('unvan');
            $table->string('fakulte')->nullable()->after('universite');
            $table->string('bolum')->nullable()->after('fakulte');
            $table->string('alan')->nullable()->after('bolum');
            $table->string('orcid')->nullable()->after('alan');
            $table->string('avesis_id')->nullable()->after('orcid');
            $table->string('yonerge')->nullable()->after('avesis_id');
            $table->timestamp('onboarded_at')->nullable()->after('yonerge');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'unvan',
                'universite',
                'fakulte',
                'bolum',
                'alan',
                'orcid',
                'avesis_id',
                'yonerge',
                'onboarded_at',
            ]);
        });
    }
};
