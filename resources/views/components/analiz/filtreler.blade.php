@props([
    'kadrolar',
    'hedefKadro',
    'sehirler',
])

<flux:card class="flex flex-col gap-4">
    <flux:heading size="sm">Filtreler</flux:heading>

    <x-secim-listesi model="hedefKadro" canli label="Hedef Kadro" :secenekler="$kadrolar" />

    <flux:input wire:model.live.debounce.300ms="arama" icon="magnifying-glass" placeholder="Üniversite ara..." clearable />

    <x-secim-listesi model="turFiltre" canli label="Üniversite Türü"
        :secenekler="['' => 'Tümü', 'devlet' => 'Devlet', 'vakif' => 'Vakıf']" />

    {{-- Yalnız yönergesi girili üniversitelerin şehirleri; sonuç vermeyecek
         bir şehir listede görünmemeli. Liste uzun (onlarca il): yazarak
         süzülüyor, filtre ancak listeden seçilince uygulanıyor. --}}
    <x-combobox model="sehirFiltre" :secenekler="$sehirler" label="Şehir"
        placeholder="Tüm şehirler" tumu-etiketi="Tüm şehirler" :secim-zorunlu="true"
        bos="Bu adla yönergesi girilmiş bir şehir yok." :sinir="100" />

    <flux:text class="text-xs text-ink-subtle">Analiz <strong>{{ $kadrolar[$hedefKadro] }}</strong> kadrosuna atama kriterlerine göredir.</flux:text>
</flux:card>
