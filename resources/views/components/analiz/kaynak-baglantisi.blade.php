@props([
    'url',
    'baslik',
    'altBaslik',
])

{{-- Yönerge belgesine giden satır. İki yerde kullanılıyor: okuduğumuz PDF
     kopyası ve üniversitenin resmi sayfası. --}}
<a href="{{ $url }}" target="_blank" rel="noopener"
    class="flex items-center gap-3 rounded-xl border border-line bg-canvas p-3 transition hover:border-brand hover:bg-brand-light">
    <div class="flex size-9 shrink-0 items-center justify-center rounded-lg bg-cat-red-light text-cat-red">
        <flux:icon name="document-text" variant="solid" class="size-5" />
    </div>
    <div class="min-w-0 flex-1">
        <div class="text-xs font-semibold text-ink">{{ $baslik }}</div>
        <div class="truncate text-xs text-ink-subtle" title="{{ $altBaslik }}">
            {{ $altBaslik }}
        </div>
    </div>
    <flux:icon name="arrow-top-right-on-square" class="size-4 shrink-0 text-ink-subtle" />
</a>
