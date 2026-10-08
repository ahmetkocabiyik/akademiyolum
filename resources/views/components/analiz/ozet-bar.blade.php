@use('App\Livewire\YonergeAnalizi', 'Analiz')

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
         diğerlerini sıfır görürdü. "Toplam" filtreyi temizleyen sayaç.
         Dar ekranda altı sayaç sığmıyor; satır yatay kayıyor, kesilmiyor. --}}
    <div class="-mx-1 flex min-w-0 max-w-full items-center gap-3 overflow-x-auto px-1">
        @foreach ([
            ['Toplam', $ozet['toplam'], 'var(--color-ink)', ''],
            [Analiz::ETIKET['yetersiz'], $ozet['yetersiz'], Analiz::RENK['yetersiz'], 'yetersiz'],
            [Analiz::ETIKET['yakin'], $ozet['yakin'], Analiz::RENK['yakin'], 'yakin'],
            [Analiz::ETIKET['eksik_bilgi'], $ozet['eksik_bilgi'], Analiz::RENK['eksik_bilgi'], 'eksik_bilgi'],
            [Analiz::ETIKET['uygun'], $ozet['uygun'], Analiz::RENK['uygun'], 'uygun'],
            ['Ölçüt Yok', $ozet['alan_yok'], 'var(--color-ink-subtle)', 'alan_yok'],
        ] as [$etiket, $sayi, $renk, $durum])
            @if (! $loop->first)<div class="h-8 w-px shrink-0 bg-line"></div>@endif
            @php $secili = $durumFiltre === $durum; @endphp
            <button type="button"
                wire:click="{{ $durum === '' ? "\$set('durumFiltre', '')" : "durumSec('{$durum}')" }}"
                aria-pressed="{{ $secili ? 'true' : 'false' }}"
                aria-label="{{ $durum === '' ? 'Durum filtresini temizle' : $etiket.' olanları göster' }}"
                @class([
                    'shrink-0 rounded-lg px-2 py-1 text-center transition',
                    'bg-canvas ring-1 ring-inset ring-line' => $secili,
                    'hover:bg-canvas' => ! $secili,
                ])>
                <div class="font-serif text-lg font-bold leading-none" style="color: {{ $renk }}">{{ $sayi }}</div>
                <div @class([
                    'mt-1 text-2xs leading-tight',
                    'font-semibold text-ink' => $secili,
                    'text-ink-subtle' => ! $secili,
                ])>{{ $etiket }}</div>
            </button>
        @endforeach
    </div>

    <div class="flex items-center gap-2">
        <flux:select wire:model.live="siralama" class="w-52">
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
