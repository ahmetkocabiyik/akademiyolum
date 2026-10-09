<?php

namespace Database\Factories;

use App\Enums\Plan;
use App\Models\AbonelikTalebi;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AbonelikTalebi>
 */
class AbonelikTalebiFactory extends Factory
{
    /**
     * Varsayılan: bekleyen, aylık Akademisyen talebi.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'plan' => Plan::Akademisyen,
            'donem' => 'aylik',
            'durum' => AbonelikTalebi::BEKLIYOR,
        ];
    }
}
