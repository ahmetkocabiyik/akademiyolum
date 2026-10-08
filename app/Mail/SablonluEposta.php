<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Panelden düzenlenen şablondan üretilmiş e-posta.
 *
 * Yalnızca HAZIR metin taşıyor (konu, HTML, düz metin), model değil: kuyruk
 * işlendiğinde kullanıcı silinmiş olsa bile mail gider. Kuyrukta ve
 * veritabanı işlemi tamamlandıktan SONRA (afterCommit): geri alınan bir kayıt
 * ya da abonelik için mail gitmesin, mail sunucusu yavaşsa istek beklemesin.
 */
class SablonluEposta extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $konu,
        public string $govdeHtml,
        public string $duzMetin,
    ) {
        $this->afterCommit();
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->konu);
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.sablonlu',
            text: 'mail.sablonlu-metin',
            with: ['icerik' => $this->govdeHtml, 'metin' => $this->duzMetin],
        );
    }
}
