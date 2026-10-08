@props([
    'label',
    'yuzde' => 0,
    'color' => 'var(--color-brand)',
    'sira' => 0,
])

{{-- Etiket sütunu dar; koşulun tam metni tooltip'te kalır. --}}

@php
    $dolu = min(100, $yuzde);
    // Çubuklar sırayla dolsun: koşullar yukarıdan aşağı okunuyor. Gecikme
    // 8. çubuktan sonra sabitleniyor, yoksa uzun listede bekleme uzuyor.
    $gecikme = min($sira, 8) * 60;
@endphp

<div class="flex items-center gap-3">
    <span class="w-28 shrink-0 truncate text-xs text-ink-muted" title="{{ $label }}">{{ $label }}</span>
    <div class="h-1.5 flex-1 overflow-hidden rounded-full bg-line"
        role="progressbar" aria-label="{{ $label }}"
        aria-valuenow="{{ $dolu }}" aria-valuemin="0" aria-valuemax="100">
        <div class="baraj-cubuk h-full rounded-full"
            style="width: {{ $dolu }}%; background: {{ $color }}; --cubuk-gecikme: {{ $gecikme }}ms"></div>
    </div>
    <span class="w-10 text-right text-xs font-medium text-ink-muted">%{{ $yuzde }}</span>
</div>
