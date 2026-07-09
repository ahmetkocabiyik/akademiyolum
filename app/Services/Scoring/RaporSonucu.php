<?php

namespace App\Services\Scoring;

use App\Enums\Kategori;

/**
 * Puanlama motorunun ürettiği tam rapor.
 */
readonly class RaporSonucu
{
    /**
     * @param  array<string, KategoriSonuc>  $kategoriler  Kategori değeri => sonuç
     */
    public function __construct(
        public array $kategoriler,
        public int $toplamPuan,
        public int $uakHedef,
        public int $universiteHedef,
    ) {}

    /**
     * Belirli bir kategorinin sonucu.
     */
    public function kategori(Kategori $kategori): KategoriSonuc
    {
        return $this->kategoriler[$kategori->value];
    }

    /**
     * Tüm kategori sonuçları (liste).
     *
     * @return list<KategoriSonuc>
     */
    public function tumKategoriler(): array
    {
        return array_values($this->kategoriler);
    }

    /**
     * ÜAK hedefine göre tamamlanma yüzdesi (0-100).
     */
    public function uakYuzde(): int
    {
        return $this->yuzde($this->uakHedef);
    }

    /**
     * Üniversite barajına göre tamamlanma yüzdesi (0-100).
     */
    public function universiteYuzde(): int
    {
        return $this->yuzde($this->universiteHedef);
    }

    /**
     * ÜAK hedefine kalan puan.
     */
    public function kalanUakPuan(): int
    {
        return max(0, $this->uakHedef - $this->toplamPuan);
    }

    /**
     * Toplam onaylı faaliyet sayısı.
     */
    public function toplamAdet(): int
    {
        return array_sum(array_map(fn (KategoriSonuc $s) => $s->adet, $this->kategoriler));
    }

    private function yuzde(int $hedef): int
    {
        if ($hedef <= 0) {
            return 0;
        }

        return (int) min(100, round($this->toplamPuan / $hedef * 100));
    }
}
