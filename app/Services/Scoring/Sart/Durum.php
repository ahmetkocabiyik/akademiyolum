<?php

namespace App\Services\Scoring\Sart;

/**
 * Bir şart düğümünün üç değerli sonucu.
 *
 * `Belirsiz`, motorun bilerek verdiği bir cevaptır: koşul yanlış değil, veri
 * eksik olduğu için karara bağlanamıyor (tarihsiz faaliyet, girilmemiş YDS,
 * beyana bağlı madde). İki değerli mantıkta bu durumlar sessizce "sağlanmadı"
 * ya da "sağlandı" sayılıp yanlış sonuç üretiyordu.
 */
enum Durum: string
{
    case Saglandi = 'saglandi';
    case Saglanmadi = 'saglanmadi';
    case Belirsiz = 'belirsiz';

    public function etiket(): string
    {
        return match ($this) {
            self::Saglandi => 'Sağlandı',
            self::Saglanmadi => 'Sağlanmadı',
            self::Belirsiz => 'Belirsiz',
        };
    }

    /**
     * Rozet/çubuk rengi (CSS değişkeni).
     */
    public function renk(): string
    {
        return match ($this) {
            self::Saglandi => 'var(--color-cat-green)',
            self::Saglanmadi => 'var(--color-cat-red)',
            self::Belirsiz => 'var(--color-cat-purple)',
        };
    }

    /**
     * Heroicon adı.
     */
    public function ikon(): string
    {
        return match ($this) {
            self::Saglandi => 'check-circle',
            self::Saglanmadi => 'x-circle',
            self::Belirsiz => 'question-mark-circle',
        };
    }

    /**
     * Kleene "ve": biri kesin olumsuzsa sonuç olumsuz, hepsi olumluysa olumlu,
     * aksi hâlde belirsiz.
     *
     * @param  list<self>  $durumlar
     */
    public static function ve(array $durumlar): self
    {
        if ($durumlar === []) {
            return self::Saglandi;
        }

        if (in_array(self::Saglanmadi, $durumlar, true)) {
            return self::Saglanmadi;
        }

        return in_array(self::Belirsiz, $durumlar, true) ? self::Belirsiz : self::Saglandi;
    }

    /**
     * Kleene "veya": biri kesin olumluysa sonuç olumlu, hepsi olumsuzsa olumsuz,
     * aksi hâlde belirsiz.
     *
     * @param  list<self>  $durumlar
     */
    public static function veya(array $durumlar): self
    {
        if ($durumlar === []) {
            return self::Saglanmadi;
        }

        if (in_array(self::Saglandi, $durumlar, true)) {
            return self::Saglandi;
        }

        return in_array(self::Belirsiz, $durumlar, true) ? self::Belirsiz : self::Saglanmadi;
    }

    /**
     * Kleene "k ile": en az k tanesi sağlanmalı. Sağlananlar k'ya ulaştıysa
     * olumlu; sağlananlar + belirsizler bile k'ya ulaşamıyorsa olumsuz.
     *
     * @param  list<self>  $durumlar
     */
    public static function kIle(array $durumlar, int $k): self
    {
        $saglanan = count(array_filter($durumlar, fn (self $d) => $d === self::Saglandi));

        if ($saglanan >= $k) {
            return self::Saglandi;
        }

        $belirsiz = count(array_filter($durumlar, fn (self $d) => $d === self::Belirsiz));

        return ($saglanan + $belirsiz) >= $k ? self::Belirsiz : self::Saglanmadi;
    }
}
