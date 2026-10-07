<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * CV'deki "ORCID / Web" alanı yalnızca ORCID oldu; sütun da adını alıyor.
 *
 * Kayıtlı değerler çıplak kimliğe indiriliyor: orcid.org adresi
 * `0000-0000-0000-000X` biçimine, küçük x büyüğe. ORCID olmayan değer (web
 * adresi) temizleniyor — alan artık her zaman maskeli, öyle bir değer ekranda
 * bozulur ve bir sonraki kayıtta anlamsız bir ORCID olarak geri yazılırdı.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cv_profilleri', function (Blueprint $table) {
            $table->renameColumn('web', 'orcid');
        });

        DB::table('cv_profilleri')->whereNotNull('orcid')->orderBy('id')->each(function (object $satir): void {
            $kimlik = strtoupper((string) preg_replace('#^(https?://)?(www\.)?orcid\.org/#i', '', trim((string) $satir->orcid)));

            DB::table('cv_profilleri')->where('id', $satir->id)->update([
                'orcid' => preg_match('/^\d{4}-\d{4}-\d{4}-\d{3}[\dX]$/', $kimlik) === 1 ? $kimlik : null,
            ]);
        });
    }

    /**
     * Sütun adı geri alınır; temizlenen web adresleri geri gelmez.
     */
    public function down(): void
    {
        Schema::table('cv_profilleri', function (Blueprint $table) {
            $table->renameColumn('orcid', 'web');
        });
    }
};
