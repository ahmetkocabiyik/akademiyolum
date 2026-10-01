<?php

namespace App\Enums;

/**
 * Bir rapor adımının ağırlığı — kartın şeridini ve rozetini belirler.
 *
 * Ağırlığı YZ seçer (hangi adımın kritik olduğu dosyaya göre değişir), ama
 * değerler SABİT: tanınmayan bir ağırlık gelirse rapor okunamadı sayılır,
 * ekran boş renk basmaz.
 */
enum JuriAgirligi: string
{
    case Kritik = 'kritik';
    case Uyari = 'uyari';
    case Olumlu = 'olumlu';
    case Bilgi = 'bilgi';
    case Notr = 'notr';

    public function etiket(): string
    {
        return match ($this) {
            self::Kritik => 'Kritik',
            self::Uyari => 'Dikkat',
            self::Olumlu => 'Olumlu',
            self::Bilgi => 'Bilgi',
            self::Notr => 'Not',
        };
    }

    public function renk(): string
    {
        return match ($this) {
            self::Kritik => 'var(--color-cat-red)',
            self::Uyari => 'var(--color-cat-amber)',
            self::Olumlu => 'var(--color-cat-green)',
            self::Bilgi => 'var(--color-brand)',
            self::Notr => 'var(--color-ink-subtle)',
        };
    }

    /** Flux rozet rengi. */
    public function rozet(): string
    {
        return match ($this) {
            self::Kritik => 'red',
            self::Uyari => 'amber',
            self::Olumlu => 'green',
            self::Bilgi => 'blue',
            self::Notr => 'zinc',
        };
    }
}
