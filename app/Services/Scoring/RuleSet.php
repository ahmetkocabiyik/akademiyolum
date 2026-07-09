<?php

namespace App\Services\Scoring;

use App\Enums\Kategori;
use App\Models\Yonerge;
use InvalidArgumentException;

/**
 * Bir yönerge kural setinin bellek içi temsili. Faz 1'de config'ten,
 * Faz 2'de veritabanından üretilecek.
 *
 * @phpstan-type KategoriKurali array{tavan: int, puanlar: array<string, int>, varsayilan: int}
 */
readonly class RuleSet
{
    /**
     * @param  array<string, KategoriKurali>  $kategoriler
     */
    public function __construct(
        public string $anahtar,
        public string $ad,
        public int $uakHedef,
        public int $universiteHedef,
        public array $kategoriler,
    ) {}

    /**
     * Config'teki bir set anahtarından RuleSet üretir.
     */
    public static function fromConfig(?string $anahtar = null): self
    {
        $anahtar ??= config('yonerge.varsayilan');
        $set = config("yonerge.setler.{$anahtar}");

        if ($set === null) {
            throw new InvalidArgumentException("Yönerge seti bulunamadı: {$anahtar}");
        }

        return new self(
            anahtar: $anahtar,
            ad: $set['ad'],
            uakHedef: $set['uak_hedef'],
            universiteHedef: $set['universite_hedef'],
            kategoriler: $set['kategoriler'],
        );
    }

    /**
     * Veritabanındaki bir yönerge kaydından RuleSet üretir.
     */
    public static function fromYonerge(Yonerge $yonerge): self
    {
        $yonerge->loadMissing('kurallar');

        $kategoriler = [];
        foreach ($yonerge->kurallar as $kural) {
            $kategoriler[$kural->kategori->value] = [
                'tavan' => $kural->tavan,
                'puanlar' => $kural->puanlar ?? [],
                'varsayilan' => $kural->varsayilan_puan,
            ];
        }

        return new self(
            anahtar: $yonerge->anahtar,
            ad: $yonerge->ad,
            uakHedef: $yonerge->uak_hedef,
            universiteHedef: $yonerge->universite_hedef,
            kategoriler: $kategoriler,
        );
    }

    /**
     * Bir kategorinin puan tavanı.
     */
    public function tavan(Kategori $kategori): int
    {
        return $this->kategoriler[$kategori->value]['tavan'] ?? 0;
    }

    /**
     * Bir kategorinin kaynağa göre puan tablosu.
     *
     * @return array<string, int>
     */
    public function puanlar(Kategori $kategori): array
    {
        return $this->kategoriler[$kategori->value]['puanlar'] ?? [];
    }

    /**
     * Eşleşme bulunamadığında kullanılacak varsayılan puan.
     */
    public function varsayilanPuan(Kategori $kategori): int
    {
        return $this->kategoriler[$kategori->value]['varsayilan'] ?? 0;
    }
}
