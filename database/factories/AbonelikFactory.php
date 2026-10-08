<?php

namespace Database\Factories;

use App\Enums\Plan;
use App\Models\Abonelik;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Abonelik>
 */
class AbonelikFactory extends Factory
{
    /**
     * Varsayılan: bugün başlamış, bir ay süren Akademisyen aboneliği.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'plan' => Plan::Akademisyen,
            'baslangic' => now()->toDateString(),
            'bitis' => now()->addMonth()->toDateString(),
            'kaynak' => 'elle',
            'tutar_kurus' => 29900,
            'not' => null,
        ];
    }

    /** Süresi dün dolmuş abonelik. */
    public function bitmis(): static
    {
        return $this->state(fn () => [
            'baslangic' => now()->subMonths(2)->toDateString(),
            'bitis' => now()->subDay()->toDateString(),
        ]);
    }

    public function iptal(): static
    {
        return $this->state(fn () => ['iptal_edildi_at' => now()]);
    }
}
