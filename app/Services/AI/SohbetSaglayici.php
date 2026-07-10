<?php

namespace App\Services\AI;

/**
 * Sağlayıcı-bağımsız sohbet (LLM) arayüzü. Stub veya gerçek (Claude) sağlayıcı
 * bu arayüzü uygular; uygulama kodu yalnızca bu arayüze bağımlıdır.
 */
interface SohbetSaglayici
{
    /**
     * Sistem promptu ve sohbet geçmişine göre bir asistan yanıtı üretir.
     *
     * @param  list<array{rol: string, icerik: string}>  $mesajlar  rol: user|assistant
     */
    public function yanitla(string $sistemPrompt, array $mesajlar): string;
}
