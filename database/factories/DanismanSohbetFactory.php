<?php

namespace Database\Factories;

use App\Models\DanismanSohbet;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DanismanSohbet>
 */
class DanismanSohbetFactory extends Factory
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
            'baslik' => fake()->sentence(4),
        ];
    }
}
