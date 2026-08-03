<?php

namespace App\Services\AI;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

/**
 * OpenAI Chat Completions API üzerinden gerçek sağlayıcı.
 * Anahtar config('ai.openai.anahtar') ile verilir.
 */
class OpenAiSaglayici implements SohbetSaglayici
{
    public function __construct(
        private readonly string $anahtar,
        private readonly string $model,
        private readonly int $maxTokens = 1024,
    ) {}

    public function yanitla(string $sistemPrompt, array $mesajlar): string
    {
        $mesajlar = array_map(fn (array $mesaj): array => [
            'role' => $mesaj['rol'],
            'content' => $mesaj['icerik'],
        ], array_values($mesajlar));

        array_unshift($mesajlar, ['role' => 'system', 'content' => $sistemPrompt]);

        try {
            $yanit = Http::withToken($this->anahtar)
                ->timeout(60)
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => $this->model,
                    'max_tokens' => $this->maxTokens,
                    'messages' => $mesajlar,
                ]);
        } catch (ConnectionException) {
            throw SaglayiciException::ulasilamadi();
        }

        if ($yanit->failed()) {
            throw SaglayiciException::httpDurumundan($yanit->status());
        }

        return (string) $yanit->json('choices.0.message.content', '');
    }
}
