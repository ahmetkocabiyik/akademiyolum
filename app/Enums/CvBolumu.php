<?php

namespace App\Enums;

/**
 * CV'de açılıp kapatılabilen bölümler.
 *
 * Görünürlük sözlüğünün anahtarları bu enum'dan geliyor: serbest dizgi
 * kullanılsaydı şablondaki yazım hatası bölümü sessizce kapalı gösterirdi.
 */
enum CvBolumu: string
{
    case Ozet = 'ozet';
    case Egitim = 'egitim';
    case Deneyim = 'deneyim';
    case Yayinlar = 'yayinlar';
    case Beceriler = 'beceriler';
    case Diller = 'diller';
    case Foto = 'foto';

    public function etiket(): string
    {
        return match ($this) {
            self::Ozet => 'Özet / Biyografi',
            self::Egitim => 'Eğitim',
            self::Deneyim => 'Deneyim',
            self::Yayinlar => 'Yayınlar ve Faaliyetler',
            self::Beceriler => 'Uzmanlık Alanları',
            self::Diller => 'Diller',
            self::Foto => 'Fotoğraf / Baş Harfler',
        };
    }

    /**
     * Varsayılan görünürlük sözlüğü — hepsi açık.
     *
     * @return array<string, bool>
     */
    public static function varsayilan(): array
    {
        $bolumler = [];

        foreach (self::cases() as $bolum) {
            $bolumler[$bolum->value] = true;
        }

        return $bolumler;
    }
}
