@props([
    'ozet',
    'durumFiltre',
    'gorunum',
    'karsilastirma',
])

{{-- Özet bar: durum sayaçları + sıralama + görünüm --}}
<div class="flex flex-wrap items-center justify-between gap-3 rounded-xl border border-line bg-surface px-4 py-2.5">
    {{-- Sayaçlar aynı zamanda filtre: bir duruma tıklamak listeyi o duruma
         daraltır, aynı sayaca yeniden tıklamak geri alır. Sayıların KENDİSİ
         daralmaz — hep tüm dağılımı gösterir, yoksa "Yetersiz"e tıklayan aday
         diğerlerini sıfır görürdü. "Toplam" filtreyi temizleyen sayaç. --}}
    <div class="flex items-center gap-3">
        @foreach ([['Toplam', $ozet['toplam'], 'var(--color-ink)', ''], ['Yetersiz', $ozet['yetersiz'], 'var(--color-cat-red)', 'yetersiz'], ['Yakın', $ozet['yakin'], 'var(--color-cat-amber)', 'yakin'], ['Onay Gerek', $ozet['eksik_bilgi'], 'var(--color-cat-amber)', 'eksik_bilgi'], ['Uygun', $ozet['uygun'], 'var(--color-cat-green)', 'uygun'], ['Ölçüt Yok', $ozet['alan_yok'], 'var(--color-ink-subtle)', 'alan_yok']] as [$etiket, $sayi, $renk, $durum])
            @if (! $loop->first)<div class="h-8 w-px bg-line"></div>@endif
            @php $secili = $durumFiltre === $durum; @endphp
            <button type="button"
                wire:click="{{ $durum === '' ? "\$set('durumFiltre', '')" : "durumSec('{$durum}')" }}"
                aria-pressed="{{ $secili ? 'true' : 'false' }}"
                aria-label="{{ $durum === '' ? 'Durum filtresini temizle' : $etiket.' olanları göster' }}"
                @class([
                    'rounded-lg px-2 py-1 text-center transition',
                    'bg-canvas ring-1 ring-inset ring-line' => $secili,
                    'hover:bg-canvas' => ! $secili,
                ])>
                <div class="font-serif text-lg font-bold leading-none" style="color: {{ $renk }}">{{ $sayi }}</div>
                <div @class([
                    'mt-1 text-[10px] leading-tight',
                    'font-semibold text-ink' => $secili,
                    'text-ink-subtle' => ! $secili,
                ])>{{ $etiket }}</div>
            </button>
        @endforeach
    </div>

    <div class="flex items-center gap-2">
        <flux:select wire:model.live="siralama" size="sm" class="w-40">
            <flux:select.option value="oran">Eşleşme Oranı</flux:select.option>
            <flux:select.option value="baraj_artan">Puan Barajı (Artan)</flux:select.option>
            <flux:select.option value="baraj_azalan">Puan Barajı (Azalan)</flux:select.option>
            <flux:select.option value="alfabetik">Alfabetik</flux:select.option>
        </flux:select>

        @unless ($karsilastirma)
            <div class="flex rounded-lg border border-line p-0.5">
                <button type="button" wire:click="$set('gorunum', 'grid')" aria-label="Izgara görünümü" @class([
                    'flex size-7 items-center justify-center rounded-md transition',
                    'bg-brand-light text-brand' => $gorunum === 'grid',
                    'text-ink-subtle hover:text-ink' => $gorunum !== 'grid',
                ])>
                    <flux:icon name="squares-2x2" class="size-4" />
                </button>
                <button type="button" wire:click="$set('gorunum', 'list')" aria-label="Liste görünümü" @class([
                    'flex size-7 items-center justify-center rounded-md transition',
                    'bg-brand-light text-brand' => $gorunum === 'list',
                    'text-ink-subtle hover:text-ink' => $gorunum !== 'list',
                ])>
                    <flux:icon name="bars-3" class="size-4" />
                </button>
            </div>
        @endunless
    </div>
</div>
