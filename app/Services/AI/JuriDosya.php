<?php

namespace App\Services\AI;

use App\Enums\JuriKarari;

/**
 * Jüri masasına konan dosya: motorun ÖLÇTÜĞÜ her şey.
 *
 * YZ'ye yalnızca bu dosya verilir ve ölçümleri değiştirmesi değil yorumlaması
 * istenir. Rapor ekranındaki sayılar da buradan basılır — böylece Yönerge
 * Analizi, Dashboard ve jüri raporu aynı sayıyı söyler.
 */
readonly class JuriDosya
{
    /**
     * @param  list<array{etiket: string, mevcut: int, gerekli: int, oran: int}>  $olcumler
     */
    public function __construct(
        public string $universite,
        public string $hedefKadro,
        public ?string $birim,
        public string $alan,
        public JuriKarari $karar,
        public array $olcumler,
        /** Prompta giren düz metin dosya özeti. */
        public string $metin,
    ) {}
}
