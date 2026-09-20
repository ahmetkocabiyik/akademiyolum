@props([
    'kadrolar',
    'hedefKadro',
    'sehirler',
])

<flux:card class="flex flex-col gap-4">
    <flux:heading size="sm">Filtreler</flux:heading>

    <flux:select wire:model.live="hedefKadro" label="Hedef Kadro" size="sm">
        @foreach ($kadrolar as $deger => $etiket)
            <flux:select.option :value="$deger">{{ $etiket }}</flux:select.option>
        @endforeach
    </flux:select>

    <flux:input wire:model.live.debounce.300ms="arama" icon="magnifying-glass" placeholder="Üniversite ara..." size="sm" clearable />

    <flux:select wire:model.live="turFiltre" label="Üniversite Türü" size="sm">
        <flux:select.option value="">Tümü</flux:select.option>
        <flux:select.option value="devlet">Devlet</flux:select.option>
        <flux:select.option value="vakif">Vakıf</flux:select.option>
    </flux:select>

    {{-- Yalnız yönergesi girili üniversitelerin şehirleri; sonuç vermeyecek
         bir şehir listede görünmemeli. --}}
    <flux:select wire:model.live="sehirFiltre" label="Şehir" size="sm">
        <flux:select.option value="">Tüm şehirler</flux:select.option>
        @foreach ($sehirler as $sehir)
            <flux:select.option :value="$sehir">{{ $sehir }}</flux:select.option>
        @endforeach
    </flux:select>

    <flux:text class="text-[11px] text-ink-subtle">Analiz <strong>{{ $kadrolar[$hedefKadro] }}</strong> kadrosuna atama kriterlerine göredir.</flux:text>
</flux:card>
