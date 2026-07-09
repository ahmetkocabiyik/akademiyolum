<?php

namespace App\Services\Scoring;

use App\Enums\Kategori;

/**
 * Bir kategorinin puanlama sonucu.
 */
readonly class KategoriSonuc
{
    public function __construct(
        public Kategori $kategori,
        public int $hamPuan,
        public int $puan,
        public int $tavan,
        public int $adet,
    ) {}

    /**
     * Tavana göre doluluk yüzdesi (0-100).
     */
    public function yuzde(): int
    {
        if ($this->tavan <= 0) {
            return 0;
        }

        return (int) min(100, round($this->puan / $this->tavan * 100));
    }

    /**
     * Ham puan tavanı aştı mı?
     */
    public function tavanAsildi(): bool
    {
        return $this->hamPuan > $this->tavan;
    }
}
