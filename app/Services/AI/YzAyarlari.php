<?php

namespace App\Services\AI;

use App\Enums\YzOzelligi;
use App\Enums\YzSaglayiciTuru;
use App\Models\YzAyari;
use Illuminate\Database\QueryException;
use RuntimeException;

/**
 * YZ özelliklerinin sağlayıcı seçiminin tek okuma noktası.
 *
 * Panelde seçim yapılmışsa o, yoksa .env'deki AI_SAGLAYICI geçerli. Seçim
 * her çözümlemede okunur: panelde değişen sağlayıcı bir sonraki mesajda
 * devreye girer.
 */
class YzAyarlari
{
    /**
     * @return array{saglayici: YzSaglayiciTuru, model: string|null}
     */
    public function secim(YzOzelligi $ozellik): array
    {
        $ayar = $this->kayit($ozellik);

        if ($ayar !== null) {
            return [
                'saglayici' => $ayar->saglayici,
                'model' => $ayar->model ?? $ayar->saglayici->varsayilanModel(),
            ];
        }

        $saglayici = YzSaglayiciTuru::tryFrom((string) config('ai.saglayici')) ?? YzSaglayiciTuru::Stub;

        return ['saglayici' => $saglayici, 'model' => $saglayici->varsayilanModel()];
    }

    /** Panelde kaydedilmiş satır; tablo henüz yoksa (migration öncesi) null. */
    public function kayit(YzOzelligi $ozellik): ?YzAyari
    {
        try {
            return YzAyari::query()->where('ozellik', $ozellik->value)->first();
        } catch (QueryException) {
            return null;
        }
    }

    /**
     * Özelliğin seçili sağlayıcısını kurar. Sahte sağlayıcı özelliğe göre
     * değişiyor: jüri katmanı metin değil JSON okuyor. Token tavanı verilmezse
     * sağlayıcının .env'deki tavanı.
     */
    public function saglayici(YzOzelligi $ozellik, ?int $maxTokens = null): SohbetSaglayici
    {
        ['saglayici' => $tur, 'model' => $model] = $this->secim($ozellik);

        if ($tur === YzSaglayiciTuru::Stub) {
            return $ozellik === YzOzelligi::Juri ? new StubJuriSaglayici : new StubSaglayici;
        }

        if (! $tur->anahtarVar()) {
            throw new RuntimeException(match ($tur) {
                YzSaglayiciTuru::Claude => 'ANTHROPIC_API_KEY tanımlı değil.',
                YzSaglayiciTuru::OpenAi => 'OPENAI_API_KEY tanımlı değil.',
            });
        }

        $anahtar = (string) config("ai.{$tur->value}.anahtar");
        $maxTokens ??= (int) config("ai.{$tur->value}.max_tokens");

        return match ($tur) {
            YzSaglayiciTuru::Claude => new ClaudeSaglayici(anahtar: $anahtar, model: (string) $model, maxTokens: $maxTokens),
            YzSaglayiciTuru::OpenAi => new OpenAiSaglayici(anahtar: $anahtar, model: (string) $model, maxTokens: $maxTokens),
        };
    }
}
