<?php

namespace Database\Factories;

use App\Models\DanismanMesaj;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DanismanMesaj>
 */
class DanismanMesajFactory extends Factory
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
            'rol' => 'user',
            'icerik' => fake()->sentence(),
        ];
    }

    public function asistan(): static
    {
        return $this->state(fn (array $attributes) => ['rol' => 'assistant']);
    }
}
