<?php

namespace App\Services\Scoring;

use App\Enums\Kategori;
use App\Models\Faaliyet;

/**
 * Puanlama motoru: bir faaliyet kümesini kural setine göre kategori tavanları
 * uygulayarak toplam puana ve kategori dağılımına dönüştürür.
 */
class PuanRaporu
{
    public function __construct(private readonly RuleSet $ruleSet) {}

    /**
     * @param  iterable<Faaliyet>  $faaliyetler
     */
    public function olustur(iterable $faaliyetler): RaporSonucu
    {
        /** @var array<string, array{ham: int, adet: int}> $birikim */
        $birikim = [];

        foreach (Kategori::cases() as $kategori) {
            $birikim[$kategori->value] = ['ham' => 0, 'adet' => 0];
        }

        foreach ($faaliyetler as $faaliyet) {
            $anahtar = $faaliyet->kategori->value;
            $birikim[$anahtar]['ham'] += $faaliyet->puan;
            $birikim[$anahtar]['adet']++;
        }

        $kategoriSonuclari = [];
        $toplamPuan = 0;

        foreach (Kategori::cases() as $kategori) {
            $ham = $birikim[$kategori->value]['ham'];
            $tavan = $this->ruleSet->tavan($kategori);
            $puan = min($ham, $tavan);
            $toplamPuan += $puan;

            $kategoriSonuclari[$kategori->value] = new KategoriSonuc(
                kategori: $kategori,
                hamPuan: $ham,
                puan: $puan,
                tavan: $tavan,
                adet: $birikim[$kategori->value]['adet'],
            );
        }

        return new RaporSonucu(
            kategoriler: $kategoriSonuclari,
            toplamPuan: $toplamPuan,
            uakHedef: $this->ruleSet->uakHedef,
            universiteHedef: $this->ruleSet->universiteHedef,
        );
    }
}
