<?php

namespace App\Enums;

/**
 * Seçilebilir YZ sağlayıcıları. Anahtar ve varsayılan model config/ai.php'de
 * (.env); panel yalnızca hangisinin kullanılacağını seçer.
 */
enum YzSaglayiciTuru: string
{
    case Claude = 'claude';
    case OpenAi = 'openai';
    case Stub = 'stub';

    public function etiket(): string
    {
        return match ($this) {
            self::Claude => 'Claude (Anthropic)',
            self::OpenAi => 'OpenAI',
            self::Stub => 'Sahte yanıt (deneme)',
        };
    }

    /** API anahtarı tanımlı mı; sahte sağlayıcının anahtarı yok. */
    public function anahtarVar(): bool
    {
        return $this === self::Stub || filled(config("ai.{$this->value}.anahtar"));
    }

    /** .env'deki varsayılan model; sahte sağlayıcıda yok. */
    public function varsayilanModel(): ?string
    {
        return $this === self::Stub ? null : config("ai.{$this->value}.model");
    }

    /**
     * Panelde sunulanlar: sahte sağlayıcı canlıda kullanıcıya uydurma yanıt
     * döndüreceği için yalnızca canlı dışında.
     *
     * @return list<self>
     */
    public static function secilebilenler(): array
    {
        return app()->isProduction() ? [self::Claude, self::OpenAi] : self::cases();
    }
}
