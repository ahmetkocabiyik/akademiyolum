<?php

namespace App\Services\AI;

use App\Enums\JuriAdimi;
use App\Enums\JuriAgirligi;

/**
 * Jüri raporu için deterministik sahte sağlayıcı.
 *
 * Anahtarsız geliştirme ve testler için: {@see StubSaglayici} sohbet metni
 * döndürüyor, jüri katmanı ise JSON bekliyor. İkisi tek sınıfta toplanırsa
 * sahte sağlayıcı promptu "sohbet mi rapor mu" diye koklamak zorunda kalırdı.
 */
class StubJuriSaglayici implements SohbetSaglayici
{
    /**
     * Ağırlıklar iskeletin kendisini sınıyor: kritik, uyarı ve bilgi kartları
     * birlikte çizilmeli. Harita JuriAdimi'nin BÜTÜN adımlarını kapsar; yeni bir
     * adım eklenip buraya yazılmazsa statik analiz eksik anahtarı bildirir.
     *
     * @var array<string, JuriAgirligi>
     */
    private const AGIRLIKLAR = [
        'kriterler' => JuriAgirligi::Bilgi,
        'envanter' => JuriAgirligi::Notr,
        'eslestirme' => JuriAgirligi::Uyari,
        'puan_hesabi' => JuriAgirligi::Kritik,
        'bosluklar' => JuriAgirligi::Kritik,
        'niteliksel_elestiri' => JuriAgirligi::Uyari,
        'plan' => JuriAgirligi::Olumlu,
        'senaryolar' => JuriAgirligi::Uyari,
        'riskler' => JuriAgirligi::Uyari,
        'karar' => JuriAgirligi::Kritik,
    ];

    public function yanitla(string $sistemPrompt, array $mesajlar): string
    {
        $adimlar = [];

        foreach (JuriAdimi::cases() as $adim) {
            $adimlar[$adim->value] = [
                'agirlik' => self::AGIRLIKLAR[$adim->value]->value,
                'icerik' => $this->icerik($adim),
            ];
        }

        return (string) json_encode([
            'adimlar' => $adimlar,
            'ozet' => 'Bu rapor sahte sağlayıcıyla üretildi: ölçümler gerçek, '
                .'metinler örnektir. Gerçek değerlendirme için AI_SAGLAYICI ayarını yapın.',
        ], JSON_UNESCAPED_UNICODE);
    }

    private function icerik(JuriAdimi $adim): string
    {
        return "**{$adim->baslik()}** — örnek içerik.\n\n".$adim->istem();
    }
}
