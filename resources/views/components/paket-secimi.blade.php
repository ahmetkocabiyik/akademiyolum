@props(['paketler', 'secili' => '', 'model' => 'paket'])

{{--
    Paket kartları (radyo düğmesi gibi). Kurulumun paket adımında ve
    Ayarlar → Abonelik'te ortak. Seçim `$model` özelliğine yazılıyor.

    @var \Illuminate\Support\Collection<string, \App\Models\Paket> $paketler
--}}
<div class="flex flex-col gap-2.5" role="radiogroup" aria-label="Paket">
    @foreach ($paketler as $deger => $secenek)
        <button type="button" wire:key="paket-{{ $deger }}" wire:click="$set('{{ $model }}', '{{ $deger }}')"
            role="radio" aria-checked="{{ $secili === $deger ? 'true' : 'false' }}"
            @class([
                'kart-tikla flex items-start gap-3 rounded-xl border p-4 text-start',
                'border-brand bg-brand-light ring-1 ring-brand' => $secili === $deger,
                'border-line hover:border-ink-subtle' => $secili !== $deger,
            ])>
            <span @class([
                'mt-0.5 flex size-5 shrink-0 items-center justify-center rounded-full border-2',
                'border-brand' => $secili === $deger,
                'border-zinc-300' => $secili !== $deger,
            ])>
                @if ($secili === $deger)
                    <span class="size-2.5 rounded-full bg-brand"></span>
                @endif
            </span>
            <span class="min-w-0 flex-1">
                <span class="flex items-baseline justify-between gap-2">
                    <span class="font-semibold text-ink">
                        {{ $secenek->ad }}
                        @if ($secenek->one_cikan)
                            <flux:badge size="sm" color="blue" class="ms-1">En popüler</flux:badge>
                        @endif
                    </span>
                    <span class="shrink-0 text-sm font-semibold text-ink">
                        {{ $secenek->aylik_fiyat_kurus === 0 ? 'Ücretsiz' : \App\Models\Paket::fiyatMetni($secenek->aylik_fiyat_kurus).' / ay' }}
                    </span>
                </span>
                @if ($secenek->aciklama)
                    <span class="mt-0.5 block text-sm text-ink-muted">{{ $secenek->aciklama }}</span>
                @endif
                @if ($secenek->ozellikler !== [])
                    <span class="mt-1.5 block text-xs text-ink-subtle">{{ implode(' · ', array_slice($secenek->ozellikler, 0, 4)) }}</span>
                @endif
            </span>
        </button>
    @endforeach
</div>
