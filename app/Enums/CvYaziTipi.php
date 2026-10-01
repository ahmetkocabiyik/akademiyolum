<?php

namespace App\Enums;

/**
 * CV'nin yazı ailesi. Değer doğrudan CSS `font-family` yığınına çevrilir;
 * şablonda serbest metin tutulsa aday kayıtlı CV'sini açtığında font sessizce
 * tarayıcı varsayılanına düşerdi.
 */
enum CvYaziTipi: string
{
    case Sans = 'sans';
    case Serif = 'serif';
    case Times = 'times';

    public function etiket(): string
    {
        return match ($this) {
            self::Sans => 'DM Sans',
            self::Serif => 'Georgia',
            self::Times => 'Times New Roman',
        };
    }

    public function aciklama(): string
    {
        return match ($this) {
            self::Sans => 'Modern ve okunur',
            self::Serif => 'Klasik ve akademik',
            self::Times => 'Geleneksel, jüri dosyalarında yaygın',
        };
    }

    public function yigin(): string
    {
        return match ($this) {
            self::Sans => "'DM Sans', ui-sans-serif, system-ui, sans-serif",
            self::Serif => "Georgia, 'Times New Roman', ui-serif, serif",
            self::Times => "'Times New Roman', Times, ui-serif, serif",
        };
    }
}
