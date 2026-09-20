@use('App\Enums\Kategori')

@props([
    'dagilim',
    'toplam',
])

{{-- Kategori dağılımı (bu yönergenin kendi cetveline göre) --}}
<div>
    <flux:heading size="sm">Puanımın Dağılımı</flux:heading>
    <flux:text class="!mt-0.5 !text-[11px] text-ink-subtle">Faaliyetleriniz bu üniversitenin kendi cetveline göre yeniden puanlandı.</flux:text>

    @php
        $enYuksek = max(1, collect($dagilim)->max('puan') ?? 1);
    @endphp
    <div class="mt-3 flex flex-col gap-2.5">
        @foreach ($dagilim as $deger => $satir)
            @php $kategori = Kategori::tryFrom($deger); @endphp
            @continue (! $kategori)
            <div wire:key="kat-{{ $deger }}">
                <div class="flex items-center justify-between gap-2 text-xs">
                    <span class="flex min-w-0 items-center gap-1.5 text-ink-muted">
                        <flux:icon :name="$kategori->ikon()" class="size-3.5 shrink-0" style="color: var(--color-{{ $kategori->renk() }})" />
                        <span class="truncate">{{ $kategori->label() }}</span>
                        <span class="shrink-0 text-ink-subtle">({{ $satir['adet'] }})</span>
                    </span>
                    <span class="shrink-0 font-semibold text-ink">{{ $satir['puan'] }} pt</span>
                </div>
                <div class="mt-1.5 h-1 overflow-hidden rounded-full bg-line">
                    <div class="baraj-cubuk h-full rounded-full" style="width: {{ (int) round($satir['puan'] / $enYuksek * 100) }}%; background: var(--color-{{ $kategori->renk() }})"></div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-3 flex items-baseline justify-between rounded-lg bg-canvas px-3 py-2">
        <span class="text-xs font-medium text-ink-muted">Toplam</span>
        <span class="font-serif text-lg font-bold text-ink">{{ $toplam === null ? '—' : $toplam.' pt' }}</span>
    </div>
</div>
