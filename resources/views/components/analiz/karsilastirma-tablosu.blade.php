@use('App\Livewire\YonergeAnalizi', 'Analiz')

@props([
    'satirlar',
    'kadroEtiketi',
])

{{-- Karşılaştırma tablosu --}}
<flux:card class="overflow-x-auto !p-0">
    <table class="w-full border-collapse text-sm">
        <thead>
            <tr class="border-b border-line text-left text-2xs uppercase tracking-wide text-ink-subtle">
                <th class="px-4 py-2.5 font-semibold">Üniversite</th>
                <th class="px-4 py-2.5 font-semibold">Kadro</th>
                <th class="px-4 py-2.5 font-semibold">Min. Baraj</th>
                <th class="px-4 py-2.5 font-semibold">Puanım</th>
                <th class="px-4 py-2.5 font-semibold">Eşleşme</th>
                <th class="px-4 py-2.5 font-semibold">Fark</th>
                <th class="px-4 py-2.5 font-semibold">Durum</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($satirlar as $s)
                @php $renk = Analiz::RENK[$s['durum']]; @endphp
                <tr class="cursor-pointer border-b border-line transition-colors last:border-0 hover:bg-canvas"
                    wire:key="krs-{{ $s['universite']->id }}"
                    wire:click="detayAc({{ $s['universite']->id }})"
                    x-on:click="$wire.detayAcik = true">
                    <td class="px-4 py-2.5">
                        <div class="flex items-center gap-1.5">
                            <span class="font-medium text-ink">{{ $s['universite']->ad }}</span>
                            <flux:icon name="check-badge" variant="solid" class="size-3.5 text-brand" title="Doğrulandı" />
                        </div>
                        <div class="text-xs text-ink-subtle">{{ $s['universite']->sehir }} · {{ $s['universite']->tur === 'vakif' ? 'Vakıf' : 'Devlet' }}</div>
                    </td>
                    <td class="px-4 py-2.5 text-ink-muted">{{ $kadroEtiketi }}</td>
                    <td class="px-4 py-2.5 font-serif font-bold text-ink">{{ $s['baraj'] ?? '—' }}</td>
                    <td class="px-4 py-2.5 font-serif font-bold text-ink">{{ $s['toplam'] ?? '—' }}</td>
                    <td class="px-4 py-2.5 font-serif font-bold" style="color: {{ $renk }}">%{{ $s['oran'] }}</td>
                    <td class="px-4 py-2.5 font-serif font-bold" style="color: {{ $renk }}">{{ $s['baraj'] === null ? '—' : ($s['kalan'] === 0 ? '+'.($s['toplam'] - $s['baraj']) : '-'.$s['kalan']) }}</td>
                    <td class="px-4 py-2.5"><flux:badge :color="Analiz::ROZET[$s['durum']]" size="sm">{{ Analiz::ETIKET[$s['durum']] }}</flux:badge></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</flux:card>
