<?php

namespace App\Services\Scoring;

use App\Models\Faaliyet;
use Illuminate\Support\Collection;

/**
 * Yapısal alt-koşulları (adet / yazarlık / "veya") kullanıcının faaliyetlerine
 * karşı değerlendirir. Her koşul bir {@see Kosul} sonucu üretir.
 *
 * Koşul şeması (yonerge_esikleri.kosullar içindeki her eleman):
 *   ['aciklama' => string, 'kategori'? => string, 'kaynaklar'? => list<string>,
 *    'yazar'? => 'tek'|'baslica', 'min_adet'? => int]
 *   veya: ['aciklama' => string, 'veya' => list<filtre>]  // seçeneklerden biri sağlanınca geçer
 */
class KosulDegerlendirici
{
    /**
     * @param  iterable<Faaliyet>  $faaliyetler
     * @param  list<array<string, mixed>>  $kosullar
     * @return list<Kosul>
     */
    public function degerlendir(iterable $faaliyetler, array $kosullar): array
    {
        $faaliyetler = collect($faaliyetler);

        return array_map(
            fn (array $kosul): Kosul => $this->tekKosul($faaliyetler, $kosul),
            array_values($kosullar),
        );
    }

    /**
     * @param  Collection<int, Faaliyet>  $faaliyetler
     * @param  array<string, mixed>  $kosul
     */
    private function tekKosul(Collection $faaliyetler, array $kosul): Kosul
    {
        $ad = (string) ($kosul['aciklama'] ?? 'Koşul');

        // "bilgi": otomatik doğrulanamaz (tarih/süre/oran) — belge ile teyit edilir.
        if (! empty($kosul['bilgi'])) {
            return new Kosul($ad, 0, 0, bilgi: true);
        }

        // "veya": seçeneklerden herhangi biri sağlanırsa koşul geçer.
        if (isset($kosul['veya'])) {
            $saglandi = collect($kosul['veya'])->contains(
                fn (array $secenek): bool => $this->adet($faaliyetler, $secenek) >= (int) ($secenek['min_adet'] ?? 1)
            );

            return new Kosul($ad, 1, $saglandi ? 1 : 0);
        }

        return new Kosul($ad, (int) ($kosul['min_adet'] ?? 1), $this->adet($faaliyetler, $kosul));
    }

    /**
     * Filtreye (kategori/kaynaklar/yazar) uyan faaliyet sayısı.
     *
     * @param  Collection<int, Faaliyet>  $faaliyetler
     * @param  array<string, mixed>  $filtre
     */
    private function adet(Collection $faaliyetler, array $filtre): int
    {
        return $faaliyetler->filter(function (Faaliyet $f) use ($filtre): bool {
            if (isset($filtre['kategori']) && $f->kategori->value !== $filtre['kategori']) {
                return false;
            }

            if (isset($filtre['kaynaklar']) && ! in_array($f->kaynak, $filtre['kaynaklar'], true)) {
                return false;
            }

            if (isset($filtre['yazar'])) {
                $rol = $f->rol;

                if ($filtre['yazar'] === 'tek' && $rol !== 'tek') {
                    return false;
                }

                if ($filtre['yazar'] === 'baslica' && ! in_array($rol, ['tek', 'baslica'], true)) {
                    return false;
                }
            }

            return true;
        })->count();
    }
}
