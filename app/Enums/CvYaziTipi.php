<?php

namespace App\Enums;

/**
 * CV'nin yazı ailesi. Değer doğrudan CSS `font-family` yığınına çevrilir;
 * şablonda serbest metin tutulsa aday kayıtlı CV'sini açtığında font sessizce
 * tarayıcı varsayılanına düşerdi.
 *
 * Web fontları (DM Sans dışındakiler) yalnızca CV sayfasında yükleniyor
 * ({@see self::webFontlari()}); Georgia ve Times sistem fontu.
 */
enum CvYaziTipi: string
{
    case Sans = 'sans';
    case Serif = 'serif';
    case Times = 'times';
    case Poppins = 'poppins';
    case Montserrat = 'montserrat';
    case Raleway = 'raleway';

    public function etiket(): string
    {
        return match ($this) {
            self::Sans => 'DM Sans',
            self::Serif => 'Georgia',
            self::Times => 'Times New Roman',
            self::Poppins => 'Poppins',
            self::Montserrat => 'Montserrat',
            self::Raleway => 'Raleway',
        };
    }

    public function aciklama(): string
    {
        return match ($this) {
            self::Sans => 'Modern ve okunur',
            self::Serif => 'Klasik ve akademik',
            self::Times => 'Geleneksel, jüri dosyalarında yaygın',
            self::Poppins => 'Geometrik ve yuvarlak hatlı',
            self::Montserrat => 'Geniş ve güçlü başlıklar',
            self::Raleway => 'İnce ve zarif',
        };
    }

    public function yigin(): string
    {
        return match ($this) {
            self::Sans => "'DM Sans', ui-sans-serif, system-ui, sans-serif",
            self::Serif => "Georgia, 'Times New Roman', ui-serif, serif",
            self::Times => "'Times New Roman', Times, ui-serif, serif",
            self::Poppins => "'Poppins', ui-sans-serif, system-ui, sans-serif",
            self::Montserrat => "'Montserrat', ui-sans-serif, system-ui, sans-serif",
            self::Raleway => "'Raleway', ui-sans-serif, system-ui, sans-serif",
        };
    }

    /**
     * CV sayfasının yüklemesi gereken web fontları (fonts.bunny.net). Kalınlıklar
     * şablonun kullandıkları: gövde 400, satır başlığı 600, ad 700, bölüm
     * başlığı 800. Bunny Türkçe harfleri (latin-ext) kendiliğinden veriyor.
     */
    public static function webFontlari(): string
    {
        return 'https://fonts.bunny.net/css?family=poppins:400,500,600,700,800|montserrat:400,500,600,700,800|raleway:400,500,600,700,800&display=swap';
    }
}
