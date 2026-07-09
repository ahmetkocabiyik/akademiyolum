<?php

namespace App\Services\Scoring;

use App\Models\Faaliyet;

/**
 * Tek bir faaliyetin ham puanını, kural setindeki kaynak tablosuna göre hesaplar.
 * Faaliyet kaydedilmeden de çalışır (kategori + kaynak yeterlidir).
 */
class PuanHesaplayici
{
    public function __construct(private readonly RuleSet $ruleSet) {}

    /**
     * Faaliyetin kategori ve kaynağına göre ham puanını döndürür.
     */
    public function hesapla(Faaliyet $faaliyet): int
    {
        $puanlar = $this->ruleSet->puanlar($faaliyet->kategori);

        if ($faaliyet->kaynak !== null && isset($puanlar[$faaliyet->kaynak])) {
            return $puanlar[$faaliyet->kaynak];
        }

        return $this->ruleSet->varsayilanPuan($faaliyet->kategori);
    }
}
