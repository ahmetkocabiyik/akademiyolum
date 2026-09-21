@props(['kayit'])

@php
    $k = $kayit;
    $rozet = ['makale' => 'Makale', 'bildiri' => 'Bildiri', 'kitap' => 'Kitap', 'proje' => 'Proje'][$k['kategori']] ?? $k['kategori'];
@endphp

<label @class([
    'flex items-start gap-3 px-4 py-3 transition',
    'cursor-pointer hover:bg-canvas' => ! $k['ekli'],
    'opacity-60' => $k['ekli'],
])>
    @if ($k['ekli'])
        <flux:icon name="check-circle" variant="solid" class="mt-0.5 size-4 shrink-0 text-cat-green" />
    @else
        <input type="checkbox"
            wire:model.live="avesisSecilenler"
            value="{{ $k['id'] }}"
            aria-label="{{ $k['baslik'] }}"
            class="mt-0.5 size-4 shrink-0 cursor-pointer rounded border-line text-brand focus:ring-brand" />
    @endif

    <div class="min-w-0 flex-1">
        <div class="text-sm font-medium leading-snug text-ink">{{ $k['baslik'] }}</div>

        <div class="mt-1 flex flex-wrap items-center gap-x-2 gap-y-1 text-xs text-ink-subtle">
            <flux:badge size="sm" color="zinc">{{ $rozet }}</flux:badge>
            <span>{{ $k['yil'] ?? 'yıl yok' }}</span>

            {{-- Kademe okunabildiyse rozet olarak görünür: aday neyin
                 yazılacağını eklemeden ÖNCE görsün. --}}
            @if ($k['kaynak'])
                <flux:badge size="sm" color="green">{{ $k['kaynak'] }}</flux:badge>
            @elseif ($k['uyari'])
                <span class="text-cat-amber-text">{{ $k['uyari'] }}</span>
            @endif

            @if ($k['ekli'])
                <flux:badge size="sm" color="zinc">Zaten ekli</flux:badge>
            @endif
        </div>

        @if ($k['kunye'])
            <div class="mt-1 truncate text-xs text-ink-subtle">{{ $k['kunye'] }}</div>
        @endif
    </div>
</label>
