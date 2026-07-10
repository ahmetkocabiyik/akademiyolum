<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Http;

/**
 * Anthropic Claude Messages API üzerinden gerçek sağlayıcı.
 * Anahtar config('ai.claude.anahtar') ile verilir.
 */
class ClaudeSaglayici implements SohbetSaglayici
{
    public function __construct(
        private readonly string $anahtar,
        private readonly string $model,
        private readonly int $maxTokens = 1024,
    ) {}

    public function yanitla(string $sistemPrompt, array $mesajlar): string
    {
        $yanit = Http::withHeaders([
            'x-api-key' => $this->anahtar,
            'anthropic-version' => '2023-06-01',
        ])
            ->timeout(60)
            ->post('https://api.anthropic.com/v1/messages', [
                'model' => $this->model,
                'max_tokens' => $this->maxTokens,
                'system' => $sistemPrompt,
                'messages' => array_map(fn (array $mesaj): array => [
                    'role' => $mesaj['rol'],
                    'content' => $mesaj['icerik'],
                ], array_values($mesajlar)),
            ])
            ->throw();

        return (string) $yanit->json('content.0.text', '');
    }
}
