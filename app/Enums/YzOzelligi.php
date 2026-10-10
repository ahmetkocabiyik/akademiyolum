<?php

namespace App\Enums;

/**
 * Sağlayıcısı panelden ayrı ayrı seçilen YZ özellikleri.
 */
enum YzOzelligi: string
{
    case Danisman = 'danisman';
    case Juri = 'juri';

    public function etiket(): string
    {
        return match ($this) {
            self::Danisman => 'YZ Danışman',
            self::Juri => 'YZ Jüri Analizi',
        };
    }

    public function aciklama(): string
    {
        return match ($this) {
            self::Danisman => 'Adayın sorularını profiline göre yanıtlayan sohbet.',
            self::Juri => 'On adımlık jüri raporu; tek yanıtta uzun JSON üretir.',
        };
    }
}
