<?php

namespace App\Services\Scoring;

/**
 * Tek bir asgari koşul (ör. "toplamda en az 100 puan").
 */
readonly class Kosul
{
    public function __construct(
        public string $ad,
        public int $gerekli,
        public int $mevcut,
        public bool $bilgi = false,
    ) {}

    public function saglandi(): bool
    {
        return $this->mevcut >= $this->gerekli;
    }

    public function eksik(): int
    {
        return max(0, $this->gerekli - $this->mevcut);
    }

    public function oran(): int
    {
        if ($this->gerekli <= 0) {
            return 100;
        }

        return (int) min(100, round($this->mevcut / $this->gerekli * 100));
    }
}
