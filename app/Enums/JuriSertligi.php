<?php

namespace App\Enums;

/**
 * Raporun tonu. Şapka gibi bu da yalnızca ÜSLUBU etkiler; ölçüm motordan gelir.
 */
enum JuriSertligi: string
{
    case Nazik = 'nazik';
    case Gercekci = 'gercekci';
    case Sert = 'sert';

    public function etiket(): string
    {
        return match ($this) {
            self::Nazik => 'Nazik',
            self::Gercekci => 'Gerçekçi',
            self::Sert => 'Sert',
        };
    }

    /**
     * Seçili düğmenin rengi.
     */
    public function renk(): string
    {
        return match ($this) {
            self::Nazik => 'var(--color-cat-green)',
            self::Gercekci => 'var(--color-cat-amber-text)',
            self::Sert => 'var(--color-cat-red)',
        };
    }

    public function ton(): string
    {
        return match ($this) {
            self::Nazik => 'Üslubun yapıcı ve cesaret verici olsun. Eksikleri gizlemeden, '
                .'ama adayın emeğini görerek yaz.',
            self::Gercekci => 'Üslubun ölçülü ve mesleki olsun. Ne yumuşatma ne de dramatize '
                .'etme; jüri odasında konuşulduğu gibi yaz.',
            self::Sert => 'Üslubun doğrudan ve tavizsiz olsun. Adayın lehine hiçbir varsayım '
                .'yapma, dosyanın zayıf yerlerini açıkça adlandır.',
        };
    }
}
