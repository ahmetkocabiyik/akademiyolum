<?php

return [

    /*
    |--------------------------------------------------------------------------
    | AI Sağlayıcı
    |--------------------------------------------------------------------------
    |
    | Aktif sohbet sağlayıcısı: 'stub' (deterministik, anahtarsız), 'claude'
    | (gerçek Anthropic API) veya 'openai' (gerçek OpenAI API). Varsayılan 'stub'
    | — anahtar hazır olunca .env'de AI_SAGLAYICI ve ilgili anahtarı ayarlayın.
    |
    */

    'saglayici' => env('AI_SAGLAYICI', 'stub'),

    /*
    |--------------------------------------------------------------------------
    | Jüri Raporu
    |--------------------------------------------------------------------------
    |
    | Jüri raporu on adımlık tek bir yanıtta üretiliyor; sohbet için yeterli olan
    | 1024 token raporu ortasından keser. Sağlayıcı aynı, yalnızca token tavanı
    | ve zaman aşımı ayrı.
    |
    */

    'juri' => [
        'max_tokens' => (int) env('AI_JURI_MAX_TOKENS', 8192),
    ],

    'claude' => [
        'anahtar' => env('ANTHROPIC_API_KEY'),
        'model' => env('AI_MODEL', 'claude-sonnet-5'),
        'max_tokens' => (int) env('AI_MAX_TOKENS', 1024),
    ],

    'openai' => [
        'anahtar' => env('OPENAI_API_KEY'),
        'model' => env('OPENAI_MODEL', 'gpt-4o'),
        'max_tokens' => (int) env('AI_MAX_TOKENS', 1024),
    ],

];
