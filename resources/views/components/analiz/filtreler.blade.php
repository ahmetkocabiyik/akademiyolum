@props([
    'kadrolar',
    'hedefKadro',
    'sehirler',
])

<flux:card class="flex flex-col gap-4">
    <flux:heading size="sm">Filtreler</flux:heading>

    <flux:select wire:model.live="hedefKadro" label="Hedef Kadro">
        @foreach ($kadrolar as $deger => $etiket)
            <flux:select.option :value="$deger">{{ $etiket }}</flux:select.option>
        @endforeach
    </flux:select>

    <flux:input wire:model.live.debounce.300ms="arama" icon="magnifying-glass" placeholder="Üniversite ara..." clearable />

    <flux:select wire:model.live="turFiltre" label="Üniversite Türü">
        <flux:select.option value="">Tümü</flux:select.option>
        <flux:select.option value="devlet">Devlet</flux:select.option>
        <flux:select.option value="vakif">Vakıf</flux:select.option>
    </flux:select>

    {{-- Yalnız yönergesi girili üniversitelerin şehirleri; sonuç vermeyecek
         bir şehir listede görünmemeli. Liste uzun (onlarca il): yazarak
         süzülüyor, filtre ancak listeden seçilince uygulanıyor. --}}
    <x-combobox model="sehirFiltre" :secenekler="$sehirler" label="Şehir"
        placeholder="Tüm şehirler" tumu-etiketi="Tüm şehirler" :secim-zorunlu="true"
        bos="Bu adla yönergesi girilmiş bir şehir yok." :sinir="100" />

    <flux:text class="text-xs text-ink-subtle">Analiz <strong>{{ $kadrolar[$hedefKadro] }}</strong> kadrosuna atama kriterlerine göredir.</flux:text>
</flux:card>
