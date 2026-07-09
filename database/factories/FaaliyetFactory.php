<?php

namespace Database\Factories;

use App\Enums\Kategori;
use App\Models\Faaliyet;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Faaliyet>
 */
class FaaliyetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'kategori' => Kategori::Makale,
            'tur' => 'Dergi Makalesi',
            'baslik' => fake()->sentence(6),
            'yazarlar' => '1 Yazar',
            'donem' => 'tez_disi',
            'kaynak' => 'TR Dizin',
            'puan' => 10,
            'durum' => 'onaylandi',
            'meta' => null,
        ];
    }

    /**
     * Set the category for the activity.
     */
    public function kategori(Kategori $kategori): static
    {
        return $this->state(fn (array $attributes) => [
            'kategori' => $kategori,
        ]);
    }

    /**
     * Mark the activity as pending approval.
     */
    public function beklemede(): static
    {
        return $this->state(fn (array $attributes) => [
            'durum' => 'beklemede',
        ]);
    }
}
