@props(['yayin'])

@php $y = $yayin; @endphp

<label @class([
    'flex items-start gap-3 px-4 py-3 transition',
    'cursor-pointer hover:bg-canvas' => ! $y['ekli'],
    'opacity-60' => $y['ekli'],
])>
    @if ($y['ekli'])
        <flux:icon name="check-circle" variant="solid" class="mt-0.5 size-4 shrink-0 text-cat-green" />
    @else
        <input type="checkbox"
            wire:model.live="arsivSecilenler"
            value="{{ $y['anahtar'] }}"
            aria-label="{{ $y['baslik'] }}"
            class="mt-0.5 size-4 shrink-0 cursor-pointer rounded border-line text-brand focus:ring-brand" />
    @endif

    <div class="min-w-0 flex-1">
        <div class="text-sm font-medium leading-snug text-ink">{{ $y['baslik'] }}</div>

        <div class="mt-1 flex flex-wrap items-center gap-x-2 gap-y-1 text-xs text-ink-subtle">
            <span>{{ $y['sayi'] }}</span>
            <span>·</span>
            <span>{{ $y['yil'] ?? 'yıl yok' }}</span>
            @if ($y['ekli'])
                <flux:badge size="sm" color="zinc">Zaten ekli</flux:badge>
            @endif
        </div>

        @if ($y['yazarlar'])
            <div class="mt-1 truncate text-xs text-ink-subtle">
                {{ implode(', ', $y['yazarlar']) }}
                @if ($y['sira'] === null)
                    <span class="text-cat-amber-text">· sıranız bulunamadı</span>
                @endif
            </div>
        @endif
    </div>
</label>
