<?php

namespace Database\Factories;

use App\Enums\YoneticiIslemi;
use App\Models\IslemKaydi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<IslemKaydi>
 */
class IslemKaydiFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'yonetici_eposta' => fake()->safeEmail(),
            'hedef_eposta' => fake()->safeEmail(),
            'islem' => YoneticiIslemi::AskiyaAldi,
            'ip' => fake()->ipv4(),
        ];
    }
}
