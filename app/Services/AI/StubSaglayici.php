<?php

namespace App\Services\AI;

/**
 * Deterministik sahte sağlayıcı. Gerçek API anahtarı olmadan geliştirme ve
 * testler için kullanılır; çıktı sabittir. Gerçek Claude sağlayıcısı hazır
 * olunca config'ten değiştirilir.
 */
class StubSaglayici implements SohbetSaglayici
{
    public function yanitla(string $sistemPrompt, array $mesajlar): string
    {
        return <<<'TXT'
        Profilinize göre öncelik sıralamalı bir yol haritası hazırladım:

        1. **SCI/SSCI makale yayınlayın** — Doçentlik için en kritik ve yüksek puanlı alan.
        2. **Tez danışmanlığı ekleyin** — Asgari şartlardan biridir.
        3. **Toplumsal katkı faaliyeti girin** — Zorunlu asgari şart.
        4. **Uluslararası bildiri sunun** — Hızlı puan kazanımı sağlar.

        Bu adımları tamamlarsanız ÜAK hedefinize önemli ölçüde yaklaşırsınız. Hangi adımı detaylandırmamı istersiniz?
        TXT;
    }
}
