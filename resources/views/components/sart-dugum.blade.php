{{--
    Bir şart ağacı düğümünü özyinelemeli çizer.

    @param \App\Services\Scoring\Sart\SartSonucu $dugum
    @param int $derinlik  İç içe geçme seviyesi (girinti için)
--}}
@props(['dugum', 'derinlik' => 0])

@php
    $renk = $dugum->durum->renk();
    $birlestirici = $dugum->cocuklar !== [];
    $olculur = $dugum->gerekli !== null && ! $dugum->beyan;
@endphp

<div @class(['flex flex-col gap-1.5', 'border-l border-line pl-3' => $derinlik > 0])>
    <div class="flex items-start justify-between gap-2 text-xs">
        <span class="flex min-w-0 items-start gap-1.5 text-ink-muted">
            @if ($dugum->beyan)
                <flux:icon name="information-circle" class="mt-px size-4 shrink-0 text-ink-subtle" />
            @else
                <flux:icon :name="$dugum->durum->ikon()" variant="solid" class="mt-px size-4 shrink-0" style="color: {{ $renk }}" />
            @endif
            <span @class(['min-w-0', 'font-semibold text-ink' => $birlestirici])>{{ $dugum->aciklama }}</span>
        </span>

        <span class="shrink-0 font-semibold" style="color: {{ $dugum->beyan ? 'var(--color-ink-subtle)' : $renk }}">
            @if ($dugum->beyan)
                belge ile
            @elseif ($olculur)
                {{ $dugum->mevcut }} / {{ $dugum->gerekli }}
            @else
                {{ $dugum->durum->etiket() }}
            @endif
        </span>
    </div>

    @if ($olculur && ! $birlestirici)
        <div class="h-1 overflow-hidden rounded-full bg-line">
            <div class="h-full rounded-full" style="width: {{ $dugum->oran() }}%; background: {{ $renk }}"></div>
        </div>
    @endif

    {{-- Belirsizlik, koşulun sağlanmadığı anlamına gelmez: veri eksik. --}}
    @if ($dugum->belirsizlikNedeni && ! $dugum->beyan)
        <div class="text-[11px] text-cat-amber">{{ $dugum->belirsizlikNedeni }}</div>
    @endif

    @if ($dugum->beyan)
        <div class="text-[11px] text-ink-subtle">Bu koşul otomatik doğrulanamaz, belge ile teyit edilir.</div>
    @endif

    @foreach ($dugum->cocuklar as $i => $cocuk)
        <x-sart-dugum :dugum="$cocuk" :derinlik="$derinlik + 1" :wire:key="'dugum-'.$derinlik.'-'.$i" />
    @endforeach

    {{-- Telafi dalı: ana koşul sağlanmadığında yönergenin sunduğu alternatif. --}}
    @if ($dugum->telafi)
        <div class="rounded-lg border border-line bg-canvas p-2">
            <div class="mb-1 flex items-center gap-1 text-[10px] font-semibold uppercase tracking-wider text-ink-subtle">
                <flux:icon name="arrow-path-rounded-square" class="size-3" />
                {{ $dugum->telafiIleSaglandi() ? 'Telafi ile sağlandı' : 'Yönergenin sunduğu telafi' }}
            </div>
            <x-sart-dugum :dugum="$dugum->telafi" :derinlik="0" />
        </div>
    @endif
</div>
