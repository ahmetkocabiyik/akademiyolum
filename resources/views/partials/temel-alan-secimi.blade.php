{{--
    Temel alan (bkz. App\Concerns\FakulteBolumSecimi::temelAlanGruplari).
    Üniversitenin yönergesi girildiyse ölçüt tanımladığı alanlar üstte;
    kalanlar gizlenmez, ayrı grupta durur ve seçilirse uyarı çıkar.
--}}
@php($gruplar = $this->temelAlanGruplari())

<div>
    <flux:select wire:model.live="temelAlan" label="Temel Alan (yönerge grubu)" :description="$aciklama ?? null">
        @if ($gruplar['tanimsiz'] === [])
            @foreach ($gruplar['tanimli'] as $deger => $etiket)
                <flux:select.option :value="$deger">{{ $etiket }}</flux:select.option>
            @endforeach
        @else
            <optgroup label="{{ $universite }} yönergesinde tanımlı">
                @foreach ($gruplar['tanimli'] as $deger => $etiket)
                    <flux:select.option :value="$deger">{{ $etiket }}</flux:select.option>
                @endforeach
            </optgroup>
            <optgroup label="Bu yönergede tanımlı değil">
                @foreach ($gruplar['tanimsiz'] as $deger => $etiket)
                    <flux:select.option :value="$deger">{{ $etiket }}</flux:select.option>
                @endforeach
            </optgroup>
        @endif
    </flux:select>

    @if ($this->temelAlanTanimsiz())
        <flux:text class="mt-2 text-xs text-amber-700 dark:text-amber-400" data-temel-alan-uyarisi>
            {{ $universite }} yönergesi bu temel alan için ölçüt tanımlamıyor; yönerge analizi bu üniversitede sonuç vermez. Alanınız doğruysa böyle bırakabilirsiniz.
        </flux:text>
    @endif
</div>
