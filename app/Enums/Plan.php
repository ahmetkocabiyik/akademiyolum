<?php

namespace App\Enums;

/**
 * Abonelik planları — tanıtım sayfasındaki fiyatlandırmayla aynı.
 *
 * Planın uygulamaya yansıması (faaliyet sınırı, YZ ekranlarının kilidi) henüz
 * YOK; bu enum şimdilik kaydı ve paneli besliyor. Sınırlar geldiğinde buraya
 * yöntem olarak eklenecek, tek kaynak burası kalacak.
 */
enum Plan: string
{
    case Ucretsiz = 'ucretsiz';
    case Akademisyen = 'akademisyen';
    case Kurumsal = 'kurumsal';

    public function etiket(): string
    {
        return match ($this) {
            self::Ucretsiz => 'Ücretsiz',
            self::Akademisyen => 'Akademisyen',
            self::Kurumsal => 'Kurumsal',
        };
    }

    /** Aylık liste fiyatı (TL). Abonelik satırı gerçekte ödeneni ayrıca tutar. */
    public function aylikFiyat(): int
    {
        return match ($this) {
            self::Ucretsiz => 0,
            self::Akademisyen => 299,
            self::Kurumsal => 999,
        };
    }

    /** Flux rozet rengi. */
    public function rozet(): string
    {
        return match ($this) {
            self::Ucretsiz => 'zinc',
            self::Akademisyen => 'blue',
            self::Kurumsal => 'amber',
        };
    }

    /**
     * Abonelikle atanabilen planlar; ücretsiz plan aboneliksiz durumun adı,
     * satır olarak yazılmıyor.
     *
     * @return list<self>
     */
    public static function ucretliler(): array
    {
        return [self::Akademisyen, self::Kurumsal];
    }
}
