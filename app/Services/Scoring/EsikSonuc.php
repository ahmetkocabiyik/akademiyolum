<?php

namespace App\Services\Scoring;

/**
 * Bir yönerge eşiğine karşı değerlendirme sonucu.
 */
readonly class EsikSonuc
{
    /**
     * @param  list<Kosul>  $kosullar
     */
    public function __construct(
        public array $kosullar,
        public int $toplam,
        public bool $uygun,
        public string $durum,   // uygun | yakin | yetersiz
        public int $oran,       // en zayıf koşulun doluluk oranı (0-100)
        public ?int $ydsMin = null,
    ) {}

    /**
     * Sağlanmayan (bilgi amaçlı olmayan) koşullar.
     *
     * @return list<Kosul>
     */
    public function eksikler(): array
    {
        return array_values(array_filter(
            $this->kosullar,
            fn (Kosul $k) => ! $k->bilgi && ! $k->saglandi(),
        ));
    }
}
