<?php

namespace App\Enums;

enum TemelAlan: string
{
    case Sosyal = 'sosyal';
    case Fen = 'fen';
    case Muhendislik = 'muhendislik';
    case Saglik = 'saglik';
    case Egitim = 'egitim';
    case Ilahiyat = 'ilahiyat';
    case Hukuk = 'hukuk';
    case Filoloji = 'filoloji';
    case GuzelSanatlar = 'guzel_sanatlar';
    case Mimarlik = 'mimarlik';
    case Ziraat = 'ziraat';
    case Spor = 'spor';

    /**
     * Human-readable Turkish label (ÜAK Doçentlik Temel Alanı adları).
     */
    public function label(): string
    {
        return match ($this) {
            self::Sosyal => 'Sosyal, Beşeri ve İdari Bilimler',
            self::Fen => 'Fen Bilimleri ve Matematik',
            self::Muhendislik => 'Mühendislik',
            self::Saglik => 'Sağlık Bilimleri',
            self::Egitim => 'Eğitim Bilimleri',
            self::Ilahiyat => 'İlahiyat',
            self::Hukuk => 'Hukuk',
            self::Filoloji => 'Filoloji',
            self::GuzelSanatlar => 'Güzel Sanatlar',
            self::Mimarlik => 'Mimarlık, Planlama ve Tasarım',
            self::Ziraat => 'Ziraat, Orman ve Su Ürünleri',
            self::Spor => 'Spor Bilimleri',
        };
    }

    /**
     * Bu temel alana ait yaygın fakülteler (fakülte dropdown'ı için).
     * Bir fakülte birden fazla temel alanda görünebilir (ör. Edebiyat/Fen-Edebiyat).
     *
     * @return list<string>
     */
    public function fakulteler(): array
    {
        return match ($this) {
            self::Sosyal => [
                'İktisadi ve İdari Bilimler Fakültesi',
                'İşletme Fakültesi',
                'Siyasal Bilgiler Fakültesi',
                'İletişim Fakültesi',
                'Edebiyat Fakültesi',
                'Fen-Edebiyat Fakültesi',
                'İnsan ve Toplum Bilimleri Fakültesi',
                'Dil ve Tarih-Coğrafya Fakültesi',
                'Turizm Fakültesi',
            ],
            self::Fen => [
                'Fen Fakültesi',
                'Fen-Edebiyat Fakültesi',
            ],
            self::Muhendislik => [
                'Mühendislik Fakültesi',
                'Mühendislik ve Mimarlık Fakültesi',
                'Teknoloji Fakültesi',
            ],
            self::Saglik => [
                'Tıp Fakültesi',
                'Diş Hekimliği Fakültesi',
                'Eczacılık Fakültesi',
                'Sağlık Bilimleri Fakültesi',
                'Hemşirelik Fakültesi',
                'Veteriner Fakültesi',
            ],
            self::Egitim => [
                'Eğitim Fakültesi',
                'Eğitim Bilimleri Fakültesi',
            ],
            self::Ilahiyat => [
                'İlahiyat Fakültesi',
                'İslami İlimler Fakültesi',
            ],
            self::Hukuk => [
                'Hukuk Fakültesi',
            ],
            self::Filoloji => [
                'Edebiyat Fakültesi',
                'Fen-Edebiyat Fakültesi',
                'Dil ve Tarih-Coğrafya Fakültesi',
            ],
            self::GuzelSanatlar => [
                'Güzel Sanatlar Fakültesi',
                'Güzel Sanatlar, Tasarım ve Mimarlık Fakültesi',
                'Devlet Konservatuvarı',
            ],
            self::Mimarlik => [
                'Mimarlık Fakültesi',
                'Mimarlık ve Tasarım Fakültesi',
                'Mühendislik ve Mimarlık Fakültesi',
                'Güzel Sanatlar, Tasarım ve Mimarlık Fakültesi',
            ],
            self::Ziraat => [
                'Ziraat Fakültesi',
                'Orman Fakültesi',
                'Su Ürünleri Fakültesi',
            ],
            self::Spor => [
                'Spor Bilimleri Fakültesi',
            ],
        };
    }

    /**
     * @return array<string, string>
     */
    public static function secenekler(): array
    {
        return array_reduce(
            self::cases(),
            fn (array $carry, self $alan) => $carry + [$alan->value => $alan->label()],
            [],
        );
    }
}
