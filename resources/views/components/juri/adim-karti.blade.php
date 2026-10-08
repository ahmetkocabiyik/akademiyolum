@props([
    'sira',
    'adim',
    'agirlik',
    'icerik',
    'etiket' => null,
    'acik' => false,
])

{{--
    Tek bir rapor adımı. Kartın sol şeridi ve rozet rengi adımın AĞIRLIĞINDAN
    geliyor (JuriAgirligi); şablonda renk haritası tutulmuyor.

    Açılır kapanır: on adımın tamamı açık gelirse rapor beş ekran boyu uzuyor ve
    aday nerede olduğunu kaybediyor. İlk adım açık başlar.
--}}
<div x-data="{ acik: @js($acik) }"
    class="overflow-hidden rounded-xl border border-line bg-surface"
    style="border-inline-start: 3px solid {{ $agirlik->renk() }}">

    <button type="button" x-on:click="acik = ! acik" :aria-expanded="acik ? 'true' : 'false'"
        class="flex w-full items-center gap-3 px-4 py-3.5 text-start transition hover:bg-canvas">

        <span class="flex size-7 shrink-0 items-center justify-center rounded-full font-serif text-xs font-bold"
            style="color: {{ $agirlik->renk() }}; background: color-mix(in srgb, {{ $agirlik->renk() }} 12%, transparent)">
            {{ $sira }}
        </span>

        <span class="min-w-0 flex-1">
            <span class="block truncate text-sm font-semibold text-ink">{{ $adim->baslik() }}</span>
            <span class="mt-0.5 block truncate text-xs text-ink-subtle">{{ $adim->altBaslik() }}</span>
        </span>

        <flux:badge :color="$agirlik->rozet()" size="sm" class="shrink-0">
            {{ $etiket ?? $agirlik->etiket() }}
        </flux:badge>

        <flux:icon name="chevron-down" class="size-4 shrink-0 text-ink-subtle transition"
            x-bind:class="acik && 'rotate-180'" />
    </button>

    <div x-cloak x-show="acik" class="border-t border-line px-4 py-3.5">
        <x-juri.markdown :icerik="$icerik" />
    </div>
</div>
