<?php

use App\Services\AI\OpenAiSaglayici;
use App\Services\AI\SaglayiciException;
use App\Services\AI\SohbetSaglayici;
use Illuminate\Support\Facades\Http;

test('OpenAI API yanıtını ayrıştırır ve sistem promptunu ekler', function () {
    Http::fake([
        'api.openai.com/*' => Http::response([
            'choices' => [
                ['message' => ['role' => 'assistant', 'content' => 'Merhaba akademisyen!']],
            ],
        ]),
    ]);

    $saglayici = new OpenAiSaglayici('sk-test', 'gpt-4o', 512);

    $yanit = $saglayici->yanitla('Sen bir danışmansın.', [
        ['rol' => 'user', 'icerik' => 'Selam'],
    ]);

    expect($yanit)->toBe('Merhaba akademisyen!');

    Http::assertSent(function ($request) {
        return $request->url() === 'https://api.openai.com/v1/chat/completions'
            && $request->hasHeader('Authorization', 'Bearer sk-test')
            && $request['model'] === 'gpt-4o'
            && $request['max_tokens'] === 512
            && $request['messages'][0] === ['role' => 'system', 'content' => 'Sen bir danışmansın.']
            && $request['messages'][1] === ['role' => 'user', 'content' => 'Selam'];
    });
});

test('429 kotası dolunca anlaşılır bakiye mesajı fırlatılır', function () {
    Http::fake([
        'api.openai.com/*' => Http::response(['error' => ['message' => 'quota']], 429),
    ]);

    $saglayici = new OpenAiSaglayici('sk-test', 'gpt-4o', 512);

    expect(fn () => $saglayici->yanitla('Sistem', [['rol' => 'user', 'icerik' => 'Selam']]))
        ->toThrow(SaglayiciException::class, 'bakiye yükleyip');
});

test('geçersiz anahtarda erişim reddi mesajı fırlatılır', function () {
    Http::fake([
        'api.openai.com/*' => Http::response(['error' => ['message' => 'invalid']], 401),
    ]);

    $saglayici = new OpenAiSaglayici('sk-yanlis', 'gpt-4o', 512);

    expect(fn () => $saglayici->yanitla('Sistem', [['rol' => 'user', 'icerik' => 'Selam']]))
        ->toThrow(SaglayiciException::class, 'API anahtarınızı kontrol edin');
});

test('AI_SAGLAYICI=openai olunca OpenAiSaglayici çözümlenir', function () {
    config([
        'ai.saglayici' => 'openai',
        'ai.openai.anahtar' => 'sk-test',
        'ai.openai.model' => 'gpt-4o',
        'ai.openai.max_tokens' => 1024,
    ]);

    expect(app(SohbetSaglayici::class))->toBeInstanceOf(OpenAiSaglayici::class);
});

test('OpenAI anahtarı yoksa hata fırlatılır', function () {
    config(['ai.saglayici' => 'openai', 'ai.openai.anahtar' => null]);

    app(SohbetSaglayici::class);
})->throws(RuntimeException::class, 'OPENAI_API_KEY tanımlı değil.');
