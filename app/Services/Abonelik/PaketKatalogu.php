<?php

namespace App\Services\Abonelik;

use App\Enums\Plan;
use App\Models\Paket;
use Illuminate\Support\Collection;

/**
 * Paket bilgilerinin tek okuma noktası (istek başına bir kez okunur;
 * AppServiceProvider'da `scoped`).
 *
 * Tablo boşsa ya da bir paketin satırı yoksa varsayılanlarla OLUŞTURULUR:
 * böylece her ortamda üç paket de vardır ve panelde düzenlenecek bir satır
 * bulunur. Migration koda bağımlı kalmasın diye tohumlama burada.
 */
class PaketKatalogu
{
    /** @var Collection<string, Paket>|null */
    private ?Collection $paketler = null;

    /**
     * Üç paket, Plan sırasıyla, plan değerine göre anahtarlı.
     *
     * @return Collection<string, Paket>
     */
    public function hepsi(): Collection
    {
        if ($this->paketler !== null) {
            return $this->paketler;
        }

        $kayitlar = Paket::query()->get()->keyBy(fn (Paket $p) => $p->plan->value);
        $paketler = collect();

        foreach (Plan::cases() as $plan) {
            $paketler[$plan->value] = $kayitlar->get($plan->value)
                ?? Paket::query()->create(['plan' => $plan->value, 'satista' => true] + $plan->varsayilan());
        }

        return $this->paketler = $paketler;
    }

    public function bilgi(Plan $plan): Paket
    {
        return $this->hepsi()->get($plan->value) ?? throw new \LogicException("Paket yok: {$plan->value}");
    }

    /**
     * Tanıtım sayfasında gösterilecekler: satıştakiler.
     *
     * @return Collection<string, Paket>
     */
    public function satistakiler(): Collection
    {
        return $this->hepsi()->filter(fn (Paket $p) => $p->satista);
    }

    /**
     * Abonelik atarken önerilen tutar (kuruş): 12 ayda yıllık fiyat varsa o,
     * yoksa ay × aylık fiyat.
     */
    public function onerilenTutar(Plan $plan, int $ay): int
    {
        $paket = $this->bilgi($plan);

        if ($ay === 12 && $paket->yillik_fiyat_kurus !== null) {
            return $paket->yillik_fiyat_kurus;
        }

        return $paket->aylik_fiyat_kurus * $ay;
    }

    /** Panelde kayıttan sonra: bu istekte de güncel bilgiler okunsun. */
    public function yenile(): void
    {
        $this->paketler = null;
    }
}
