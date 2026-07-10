<?php

namespace Database\Factories;

use App\Models\Yonerge;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Yonerge>
 */
class YonergeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'universite_id' => null,
            'anahtar' => fake()->unique()->slug(3),
            'ad' => 'Doçentlik Yönergesi',
            'kadro' => 'docentlik',
            'yil' => 2026,
            'uak_hedef' => 100,
            'universite_hedef' => fake()->numberBetween(140, 240),
        ];
    }

    /**
     * Config'teki İlahiyat kategori kurallarını yönergeye ekler.
     */
    public function ilahiyatKurallari(): static
    {
        return $this->afterCreating(function (Yonerge $yonerge): void {
            /** @var array<string, array{tavan: int, puanlar: array<string, int>, varsayilan: int}> $kategoriler */
            $kategoriler = config('yonerge.setler.ilahiyat_2026.kategoriler');

            foreach ($kategoriler as $kategori => $kural) {
                $yonerge->kurallar()->create([
                    'kategori' => $kategori,
                    'tavan' => $kural['tavan'],
                    'varsayilan_puan' => $kural['varsayilan'],
                    'puanlar' => $kural['puanlar'],
                ]);
            }
        });
    }
}
