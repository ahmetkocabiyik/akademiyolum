<?php

namespace App\Enums;

enum Kategori: string
{
    case Makale = 'makale';
    case Kitap = 'kitap';
    case TezYayini = 'tez_yayini';
    case Atif = 'atif';
    case EgitimOgretim = 'egitim_ogretim';
    case Editorluk = 'editorluk';
    case ToplumsalKatki = 'toplumsal_katki';
    case Diger = 'diger';

    /**
     * Human-readable Turkish label.
     */
    public function label(): string
    {
        return match ($this) {
            self::Makale => 'Makale',
            self::Kitap => 'Kitap',
            self::TezYayini => 'Tez Yayını',
            self::Atif => 'Atıf',
            self::EgitimOgretim => 'Eğitim-Öğretim',
            self::Editorluk => 'Editörlük',
            self::ToplumsalKatki => 'Toplumsal Katkı',
            self::Diger => 'Diğer Etkinlik',
        };
    }

    /**
     * Heroicon name used across the dashboard.
     */
    public function ikon(): string
    {
        return match ($this) {
            self::Makale => 'document-text',
            self::Kitap => 'book-open',
            self::TezYayini => 'pencil-square',
            self::Atif => 'link',
            self::EgitimOgretim => 'academic-cap',
            self::Editorluk => 'scissors',
            self::ToplumsalKatki => 'heart',
            self::Diger => 'star',
        };
    }

    /**
     * Brand colour key used for badges/bars (maps to CSS tokens).
     */
    public function renk(): string
    {
        return match ($this) {
            self::Makale => 'brand',
            self::Kitap => 'cat-purple',
            self::TezYayini => 'gold',
            self::Atif => 'cat-teal',
            self::EgitimOgretim => 'cat-green',
            self::Editorluk => 'cat-amber',
            self::ToplumsalKatki => 'cat-red',
            self::Diger => 'ink-subtle',
        };
    }

    /**
     * All cases as value => label, handy for select inputs.
     *
     * @return array<string, string>
     */
    public static function secenekler(): array
    {
        return array_reduce(
            self::cases(),
            fn (array $carry, self $kategori) => $carry + [$kategori->value => $kategori->label()],
            [],
        );
    }
}
