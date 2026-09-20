@props([
    'adlar',
])

{{-- Temel alanı hiç kapsanmayanlar. Kart olarak gösteriliyor ki aday tek tek
     arayıp "yönergesi yok mu?" diye düşünmesin, ama SONUÇLARIN ALTINDA ve ayrı
     başlık altında: dar temel alanlarda bu liste 50'yi aşıyor (ziraatte 59,
     ilahiyatta 53) ve gerçek sonuçların arasına karışsa listeyi boğardı. --}}
<div class="mt-8">
    <div class="mb-3 flex items-baseline gap-2">
        <flux:heading size="sm">Temel alanınıza ölçüt tanımlamayan üniversiteler</flux:heading>
        <flux:text size="sm" class="text-ink-subtle">{{ count($adlar) }} üniversite</flux:text>
    </div>
    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($adlar as $ad)
            <flux:card class="border-dashed !py-4">
                <flux:heading size="sm" class="text-ink-subtle">{{ $ad }}</flux:heading>
                <flux:text size="sm" class="mt-1 text-ink-subtle">
                    Bu üniversitede sizin temel alanınıza ait bir eşik bulunamadı.
                </flux:text>
            </flux:card>
        @endforeach
    </div>
</div>
