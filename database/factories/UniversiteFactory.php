<?php

namespace Database\Factories;

use App\Models\Universite;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Universite>
 */
class UniversiteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ad' => fake()->city().' Üniversitesi',
            'sehir' => fake()->city(),
            'tur' => fake()->randomElement(['devlet', 'vakif']),
        ];
    }
}
