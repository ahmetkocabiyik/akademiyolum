<?php

namespace Database\Factories;

use App\Enums\CvBolumu;
use App\Enums\CvSablonu;
use App\Enums\CvYaziTipi;
use App\Models\CvProfili;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CvProfili>
 */
class CvProfiliFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'ad' => fake()->name(),
            'unvan' => 'Dr. Öğr. Üyesi',
            'kurum' => 'Mersin Üniversitesi',
            'bolum' => 'İlahiyat Fakültesi',
            'eposta' => fake()->safeEmail(),
            'telefon' => null,
            'sehir' => 'Mersin',
            'web' => null,
            'ozet' => null,
            'egitimler' => [],
            'deneyimler' => [],
            'beceriler' => [],
            'diller' => [],
            'haric_faaliyetler' => [],
            'sablon' => CvSablonu::Resmi,
            'renk' => CvProfili::RENKLER[0],
            'yazi_tipi' => CvYaziTipi::Sans,
            'bolumler' => CvBolumu::varsayilan(),
        ];
    }
}
