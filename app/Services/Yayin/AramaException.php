<?php

namespace App\Services\Yayin;

use RuntimeException;

/**
 * Yayın araması yapılamadı. Mesajlar doğrudan adaya gösteriliyor: teknik
 * ayrıntı değil, ne yapabileceğini söylüyorlar.
 */
class AramaException extends RuntimeException
{
    public static function ulasilamadi(): self
    {
        return new self('Yayın veritabanına şu an ulaşılamıyor. Biraz sonra tekrar deneyin.');
    }

    /**
     * Kurumsal profil sunucusu yanıt vermedi.
     *
     * "Kayıt bulunamadı"dan AYRI ileti: APBS zaman zaman dakikalarca 504
     * veriyor ve o sırada "profilinizde okunabilir kayıt yok" demek adayı
     * profilinin boş olduğuna inandırırdı.
     */
    public static function profileUlasilamadi(string $sistem): self
    {
        return new self("{$sistem} şu an yanıt vermiyor. Sunucusu yoğun olabilir; biraz sonra tekrar deneyin.");
    }

    public static function httpDurumundan(int $durum): self
    {
        return new self(match (true) {
            $durum === 429 => 'Çok fazla arama yapıldı, bir dakika sonra tekrar deneyin.',
            $durum >= 500 => 'Yayın veritabanı geçici olarak hizmet veremiyor. Biraz sonra tekrar deneyin.',
            default => 'Arama tamamlanamadı. Ad yazımını sadeleştirip tekrar deneyin.',
        });
    }
}
