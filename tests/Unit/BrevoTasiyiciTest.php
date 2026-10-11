<?php

use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Bridge\Brevo\Transport\BrevoApiTransport;

test('MAIL_MAILER=brevo, Brevo HTTP API taşıyıcısını anahtarıyla kurar', function () {
    config(['services.brevo.key' => 'xkeysib-test']);

    $tasiyici = Mail::mailer('brevo')->getSymfonyTransport();

    expect($tasiyici)->toBeInstanceOf(BrevoApiTransport::class)
        ->and((string) $tasiyici)->toBe('brevo+api://api.brevo.com')
        ->and((new ReflectionProperty($tasiyici, 'key'))->getValue($tasiyici))->toBe('xkeysib-test');
});
