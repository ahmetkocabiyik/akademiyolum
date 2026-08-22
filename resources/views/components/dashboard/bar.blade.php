@props([
    'label',
    'yuzde' => 0,
    'color' => 'var(--color-brand)',
])

{{-- Etiket sütunu dar; koşulun tam metni tooltip'te kalır. --}}

<div class="flex items-center gap-3">
    <span class="w-28 shrink-0 truncate text-xs text-ink-muted" title="{{ $label }}">{{ $label }}</span>
    <div class="h-1.5 flex-1 overflow-hidden rounded-full bg-line">
        <div class="h-full rounded-full" style="width: {{ min(100, $yuzde) }}%; background: {{ $color }}"></div>
    </div>
    <span class="w-10 text-right text-[11px] font-medium text-ink-muted">%{{ $yuzde }}</span>
</div>
