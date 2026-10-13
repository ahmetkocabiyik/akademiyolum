<?php

namespace Database\Factories;

use App\Models\Universite;
use App\Models\UniversiteBirimi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UniversiteBirimi>
 */
class UniversiteBirimiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'universite_id' => Universite::factory(),
            'fakulte' => fake()->randomElement(['Mühendislik Fakültesi', 'Tıp Fakültesi', 'Eğitim Fakültesi']),
            'bolum' => fake()->unique()->word(),
        ];
    }
}
