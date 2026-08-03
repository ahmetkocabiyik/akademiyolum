<?php

namespace App\Services\AI;

use RuntimeException;

/**
 * YZ Danışman sağlayıcısından (Claude/OpenAI) gelen ve kullanıcıya doğrudan
 * gösterilebilecek anlaşılır Türkçe mesaj taşıyan hata.
 */
class SaglayiciException extends RuntimeException
{
    /**
     * HTTP durum koduna göre kullanıcı dostu bir hata üretir.
     */
    public static function httpDurumundan(int $durum): self
    {
        return new self(match ($durum) {
            401, 403 => 'Yapay zekâ sağlayıcısına erişim reddedildi. API anahtarınızı kontrol edin.',
            429 => 'Kullanım limitiniz dolmuş görünüyor. Lütfen sağlayıcı hesabınıza bakiye yükleyip tekrar deneyin.',
            500, 502, 503, 504 => 'Yapay zekâ sağlayıcısı şu anda yanıt veremiyor. Lütfen birazdan tekrar deneyin.',
            default => 'Danışman yanıtı alınamadı. Lütfen daha sonra tekrar deneyin.',
        });
    }

    /**
     * Sağlayıcıya hiç ulaşılamadığında (ağ/timeout) kullanılır.
     */
    public static function ulasilamadi(): self
    {
        return new self('Yapay zekâ sağlayıcısına ulaşılamadı. İnternet bağlantınızı kontrol edip tekrar deneyin.');
    }
}
