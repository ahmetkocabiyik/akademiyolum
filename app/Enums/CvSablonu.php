<?php

namespace App\Enums;

/**
 * CV şablonu — yalnızca SUNUM değişir, içerik değişmez.
 *
 * Tasarımlı iki şablon aynı bölümleri aynı sırada basar; fark tipografi,
 * başlık çizgisi ve iki sütunun ağırlığında. Şablonun içeriği değiştirmesine
 * izin verilseydi aday "Minimal"e geçince yayınlarının eksildiğini sanırdı.
 *
 * YÖK Formatı farklı: atama başvurusunda istenen resmî EK-4A özgeçmişi.
 * Başlıkları, sırası ve biçimi sabit; renk, yazı tipi ve bölüm seçimi ona
 * uygulanmaz. Yine aynı veriyi basar, yalnız EK-4A'nın başlıklarına dağıtır.
 */
enum CvSablonu: string
{
    case Minimal = 'minimal';
    case Prestijli = 'prestijli';
    case YokEk4a = 'yok_ek4a';

    public function etiket(): string
    {
        return match ($this) {
            self::Minimal => 'Minimal',
            // Değer `prestijli` kalıyor (kayıtlı CV'ler onu taşıyor); yalnızca ad değişti.
            self::Prestijli => 'Kurumsal',
            self::YokEk4a => 'YÖK Formatı',
        };
    }

    public function aciklama(): string
    {
        return match ($this) {
            self::Minimal => 'İnce çizgiler, bol boşluk',
            self::Prestijli => 'Koyu başlık, altın vurgu',
            self::YokEk4a => 'Resmî EK-4A özgeçmiş',
        };
    }

    /** Biçimi sabit resmî format mı (renk, yazı tipi, bölüm seçimi uygulanmaz)? */
    public function resmi(): bool
    {
        return $this === self::YokEk4a;
    }
}
