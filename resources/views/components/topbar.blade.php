@props([
    'title' => null,
    'pill' => null,
])

{{-- flux:main padding'inden (p-6 lg:p-8) taşarak tam-genişlik topbar (05_yonerge_analizi.html) --}}
<div {{ $attributes->class('-mx-6 -mt-6 mb-6 flex h-14 items-center justify-between gap-4 border-b border-line bg-surface px-6 lg:-mx-8 lg:-mt-8 lg:mb-8 lg:px-8') }}>
    <div class="flex min-w-0 items-center gap-3">
        @if ($title)
            <h1 class="truncate text-base font-semibold text-ink">{{ $title }}</h1>
        @endif
        @if ($pill)
            <span class="hidden shrink-0 items-center gap-1.5 rounded-full border border-cat-green/20 bg-cat-green-light px-2.5 py-1 text-[11px] font-medium text-cat-green sm:inline-flex">
                <span class="size-1.5 rounded-full bg-cat-green"></span>{{ $pill }}
            </span>
        @endif
    </div>
    <div class="flex shrink-0 items-center gap-2">
        {{ $slot }}
    </div>
</div>
