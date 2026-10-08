@props([
    'label',
    'accent' => 'brand',
    'meta' => null,
])

@php
    $accentVar = [
        'brand' => 'var(--color-brand)',
        'gold' => 'var(--color-gold)',
        'red' => 'var(--color-cat-red)',
        'green' => 'var(--color-cat-green)',
    ][$accent] ?? 'var(--color-brand)';
@endphp

<div class="relative overflow-hidden rounded-xl border border-line bg-surface px-4 py-4">
    <div class="absolute inset-x-0 top-0 h-[3px]" style="background: {{ $accentVar }}"></div>
    <div class="text-2xs font-semibold uppercase tracking-wide text-ink-subtle">{{ $label }}</div>
    <div class="mt-2">{{ $slot }}</div>
    @if ($meta)
        <div class="mt-2 flex items-center gap-1.5">{{ $meta }}</div>
    @endif
</div>
