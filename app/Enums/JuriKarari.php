<?php

namespace App\Enums;

/**
 * Raporun tepesindeki net karar.
 *
 * Karar YZ'ye SORULMAZ: şart ağacı sonucundan türetilir. Aksi hâlde aynı
 * dosya için Yönerge Analizi "uygun", jüri raporu "başvuramaz" diyebilirdi —
 * iki ekran aynı motoru kullandığı hâlde aday hangisine inanacağını bilemezdi.
 */
enum JuriKarari: string
{
    case Basvurabilir = 'basvurabilir';
    case Sinirda = 'sinirda';
    case Basvuramaz = 'basvuramaz';

    public function etiket(): string
    {
        return match ($this) {
            self::Basvurabilir => 'BAŞVURABİLİR',
            self::Sinirda => 'SINIRDA',
            self::Basvuramaz => 'BAŞVURAMAZ',
        };
    }

    /**
     * Kararın gerekçesi — rozetin altında, tek cümle.
     */
    public function aciklama(): string
    {
        return match ($this) {
            self::Basvurabilir => 'Yönergenin bütün asgari koşulları karşılanıyor.',
            self::Sinirda => 'Kesin olarak karşılanmayan koşul yok, ama bazı koşullar '
                .'onayınızı ya da eksik bilgiyi bekliyor.',
            self::Basvuramaz => 'En az bir asgari koşul kesin olarak karşılanmıyor.',
        };
    }

    public function renk(): string
    {
        return match ($this) {
            self::Basvurabilir => 'var(--color-cat-green)',
            self::Sinirda => 'var(--color-cat-purple)',
            self::Basvuramaz => 'var(--color-cat-red)',
        };
    }

    /** Flux rozet rengi. */
    public function rozet(): string
    {
        return match ($this) {
            self::Basvurabilir => 'green',
            self::Sinirda => 'purple',
            self::Basvuramaz => 'red',
        };
    }

    public function ikon(): string
    {
        return match ($this) {
            self::Basvurabilir => 'check-circle',
            self::Sinirda => 'question-mark-circle',
            self::Basvuramaz => 'x-circle',
        };
    }
}
