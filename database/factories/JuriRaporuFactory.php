<?php

namespace Database\Factories;

use App\Enums\JuriAdimi;
use App\Enums\JuriAgirligi;
use App\Enums\JuriKarari;
use App\Enums\JuriSapkasi;
use App\Enums\JuriSertligi;
use App\Models\JuriRaporu;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<JuriRaporu>
 */
class JuriRaporuFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'universite' => 'Mersin Üniversitesi',
            'hedef_kadro' => 'docentlik',
            'birim' => null,
            'alan' => 'sosyal',
            'sapka' => JuriSapkasi::UakUzmani,
            'sertlik' => JuriSertligi::Gercekci,
            'karar' => JuriKarari::Basvuramaz,
            'olcumler' => [
                ['etiket' => 'Toplam puan', 'mevcut' => 30, 'gerekli' => 220, 'oran' => 14],
            ],
            'adimlar' => collect(JuriAdimi::cases())
                ->mapWithKeys(fn (JuriAdimi $adim) => [$adim->value => [
                    'agirlik' => JuriAgirligi::Bilgi->value,
                    'icerik' => $adim->baslik().' içeriği.',
                ]])
                ->all(),
            'ozet' => fake()->sentence(12),
        ];
    }
}
