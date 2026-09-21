@props(['yayin'])

@php
    $y = $yayin;
    $sebep = $y['ekli_sebep'] ?? null;
    $ekliEtiket = $sebep === 'baslik' ? 'Aynı başlık zaten var' : 'Zaten ekli';
    $rozet = ['makale' => 'Makale', 'bildiri' => 'Bildiri', 'kitap' => 'Kitap'][$y['kategori']] ?? $y['kategori'];
@endphp

{{-- Zaten ekli satır listeden ÇIKARILMIYOR: aday aynı yayını neden
     seçemediğini görebilmeli, yoksa "bulunamadı" sanıp elle ikinci kez
     ekliyor. --}}
<label @class([
    'flex items-start gap-3 px-4 py-3 transition',
    'cursor-pointer hover:bg-canvas' => ! $sebep,
    'opacity-60' => (bool) $sebep,
])>
    @if ($sebep)
        <flux:icon name="check-circle" variant="solid" class="mt-0.5 size-4 shrink-0 text-cat-green" />
    @else
        {{-- .live: ertelenmiş bağlamada "N yayını ekle" sayacı işaretlemeden
             sonra 0'da kalıyordu — aday hiçbir şey seçmemiş sanıyor. --}}
        <input type="checkbox"
            wire:model.live="secilenler"
            value="{{ $y['doi'] }}"
            aria-label="{{ $y['baslik'] }}"
            class="mt-0.5 size-4 shrink-0 cursor-pointer rounded border-line text-brand focus:ring-brand" />
    @endif

    <div class="min-w-0 flex-1">
        <div class="text-sm font-medium leading-snug text-ink">{{ $y['baslik'] }}</div>

        <div class="mt-1 flex flex-wrap items-center gap-x-2 gap-y-1 text-xs text-ink-subtle">
            @if ($y['dergi'])
                <span class="truncate font-medium text-ink-muted">{{ $y['dergi'] }}</span>
                <span>·</span>
            @endif
            <span>{{ $y['yil'] ?? 'yıl yok' }}</span>
            <span>·</span>
            <flux:badge size="sm" color="zinc">{{ $rozet }}</flux:badge>

            {{-- ORCID süzgecinden gelen satır adayın olduğu KESİN; ad
                 sorgusundan gelen yalnızca aday adıyla benzeşiyor. --}}
            @if ($y['kesin'])
                <flux:badge size="sm" color="green">ORCID eşleşmesi</flux:badge>
            @endif

            @if ($sebep)
                <flux:badge size="sm" color="zinc">{{ $ekliEtiket }}</flux:badge>
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

        <a href="https://doi.org/{{ $y['doi'] }}" target="_blank" rel="noopener"
            x-on:click.stop
            class="mt-1 inline-flex items-center gap-1 text-[11px] text-ink-subtle underline hover:text-brand">
            <flux:icon name="arrow-top-right-on-square" class="size-3" />{{ $y['doi'] }}
        </a>
    </div>
</label>
