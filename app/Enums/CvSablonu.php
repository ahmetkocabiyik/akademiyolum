<?php

namespace App\Enums;

/**
 * CV şablonu — yalnızca SUNUM değişir, içerik değişmez.
 *
 * Dört şablon aynı bölümleri aynı sırada basar; fark tipografi, başlık çizgisi
 * ve iki sütunun ağırlığında. Şablonun içeriği değiştirmesine izin verilseydi
 * aday "Minimal"e geçince yayınlarının eksildiğini sanırdı.
 */
enum CvSablonu: string
{
    case Resmi = 'resmi';
    case Minimal = 'minimal';
    case Prestijli = 'prestijli';
    case Sade = 'sade';

    public function etiket(): string
    {
        return match ($this) {
            self::Resmi => 'Resmî',
            self::Minimal => 'Minimal',
            self::Prestijli => 'Prestijli',
            self::Sade => 'Sade',
        };
    }

    public function aciklama(): string
    {
        return match ($this) {
            self::Resmi => 'Renkli başlık bandı, iki sütun',
            self::Minimal => 'İnce çizgiler, bol boşluk',
            self::Prestijli => 'Koyu başlık, altın vurgu',
            self::Sade => 'Tek renk, çıktıya dost',
        };
    }
}
