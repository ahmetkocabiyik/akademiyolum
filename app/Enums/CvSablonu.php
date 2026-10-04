<?php

namespace App\Enums;

/**
 * CV şablonu — yalnızca SUNUM değişir, içerik değişmez.
 *
 * İki şablon aynı bölümleri aynı sırada basar; fark tipografi, başlık çizgisi
 * ve iki sütunun ağırlığında. Şablonun içeriği değiştirmesine izin verilseydi
 * aday "Minimal"e geçince yayınlarının eksildiğini sanırdı.
 */
enum CvSablonu: string
{
    case Minimal = 'minimal';
    case Prestijli = 'prestijli';

    public function etiket(): string
    {
        return match ($this) {
            self::Minimal => 'Minimal',
            // Değer `prestijli` kalıyor (kayıtlı CV'ler onu taşıyor); yalnızca ad değişti.
            self::Prestijli => 'Kurumsal',
        };
    }

    public function aciklama(): string
    {
        return match ($this) {
            self::Minimal => 'İnce çizgiler, bol boşluk',
            self::Prestijli => 'Koyu başlık, altın vurgu',
        };
    }
}
