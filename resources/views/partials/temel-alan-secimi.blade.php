{{--
    Temel alan (bkz. App\Concerns\FakulteBolumSecimi::temelAlanGruplari).
    Üniversitenin yönergesi girildiyse yalnızca ölçüt tanımladığı alanlar
    listelenir; en alttaki "Alanım listede yok…" kalanları da açar. Seçili
    alan tanımsızsa liste zaten tam açılır ve uyarı çıkar.
--}}
@php
    $gruplar = $this->temelAlanGruplari();
    $tumu = $this->tanimsizAlanlarGorunsun();

    $liste = match (true) {
        $gruplar['tanimsiz'] === [] => [['baslik' => null, 'secenekler' => $gruplar['tanimli']]],
        ! $tumu => [
            ['baslik' => null, 'secenekler' => $gruplar['tanimli']],
            ['baslik' => null, 'secenekler' => [$this::TUM_ALANLAR => 'Alanım listede yok…']],
        ],
        default => [
            ['baslik' => $universite.' yönergesinde tanımlı', 'secenekler' => $gruplar['tanimli']],
            ['baslik' => 'Bu yönergede tanımlı değil', 'secenekler' => $gruplar['tanimsiz']],
        ],
    };
@endphp

<div>
    <x-secim-listesi model="temelAlan" canli :gruplar="$liste"
        label="Temel Alan (yönerge grubu)" :description="$aciklama ?? null" />

    @if ($this->temelAlanTanimsiz())
        <flux:text class="mt-2 text-xs text-amber-700 dark:text-amber-400" data-temel-alan-uyarisi>
            {{ $universite }} yönergesi bu temel alan için ölçüt tanımlamıyor; yönerge analizi bu üniversitede sonuç vermez. Alanınız doğruysa böyle bırakabilirsiniz.
        </flux:text>
    @elseif ($tumu && $gruplar['tanimsiz'] !== [])
        <flux:text class="mt-2 text-xs">
            Tüm temel alanlar listelendi. {{ $universite }} yönergesinin ölçüt tanımlamadığı alanlar ayrı grupta.
        </flux:text>
    @endif
</div>
