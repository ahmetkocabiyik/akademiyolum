<?php

return [

    /*
    |--------------------------------------------------------------------------
    | AI Sağlayıcı
    |--------------------------------------------------------------------------
    |
    | Aktif sohbet sağlayıcısı: 'stub' (deterministik, anahtarsız) veya 'claude'
    | (gerçek Anthropic API). Varsayılan 'stub' — anahtar hazır olunca .env'de
    | AI_SAGLAYICI=claude yapıp ANTHROPIC_API_KEY ekleyin.
    |
    */

    'saglayici' => env('AI_SAGLAYICI', 'stub'),

    'claude' => [
        'anahtar' => env('ANTHROPIC_API_KEY'),
        'model' => env('AI_MODEL', 'claude-sonnet-5'),
        'max_tokens' => (int) env('AI_MAX_TOKENS', 1024),
    ],

];
