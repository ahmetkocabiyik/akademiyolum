@props([
    'sidebar' => false,
    'href' => null,
])

<a href="{{ $href ?? route('home') }}" {{ $attributes->merge(['class' => 'inline-flex items-center gap-2.5']) }}>
    <span @class([
        'flex size-9 shrink-0 items-center justify-center rounded-lg bg-navy text-gold',
        'ring-1 ring-white/10' => $sidebar,
    ])>
        <x-app-logo-icon class="size-5" />
    </span>
    <span @class([
        'brand-wordmark text-xl leading-none',
        'text-white' => $sidebar,
        'text-navy' => ! $sidebar,
    ])>Akademiyolum</span>
</a>
