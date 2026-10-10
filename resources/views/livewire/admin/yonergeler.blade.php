@use('App\Livewire\Admin\Yonergeler')
@use('App\Services\Yonetim\YonergeOzeti')

@php
    $durumRozeti = ['dogrulandi' => 'green', 'taslak' => 'amber', 'gizli' => 'red', 'yok' => 'zinc'];
@endphp

<div>
    <x-topbar title="Yönergeler" :pill="count($this->satirlar).' üniversite'" />

    <flux:text class="mb-4">
        Yönerge verisi kodda tutuluyor ve testlerle doğrulanıyor; buradan görülür. Künye bilgileri ve geçici olarak yayından
        kaldırma üniversitenin sayfasında. Kapsam, girilmiş kadro × temel alan bileşimi sayısıdır (en fazla {{ YonergeOzeti::TAM_KAPSAM }}).
    </flux:text>

    <div class="flex flex-col gap-4">
        {{-- Telefonda durum düğmeleri tek satırda yana kayar; geniş ekranda
             aramanın yanında sarılır. --}}
        <div class="flex flex-col gap-3 rounded-xl border border-line bg-surface p-4 sm:flex-row sm:flex-wrap sm:items-center">
            <flux:input wire:model.live.debounce.300ms="arama" icon="magnifying-glass" placeholder="Üniversite ya da şehir..." clearable class="w-full sm:w-auto sm:min-w-64 sm:flex-1" />
            <div class="-mx-4 flex gap-1.5 overflow-x-auto px-4 [mask-image:linear-gradient(to_right,black_85%,transparent)] [scrollbar-width:none] sm:mx-0 sm:flex-wrap sm:px-0 sm:[mask-image:none]">
                <button type="button" wire:click="$set('durum', '')" @class(['shrink-0 whitespace-nowrap rounded-lg px-3 py-2 text-sm font-medium transition', 'bg-brand text-white' => $durum === '', 'text-ink-muted hover:bg-canvas' => $durum !== ''])>
                    Tümü <span class="opacity-70">{{ count($this->tumu) }}</span>
                </button>
                @foreach (Yonergeler::DURUMLAR as $deger => $etiket)
                    <button type="button" wire:click="$set('durum', '{{ $deger }}')" @class(['shrink-0 whitespace-nowrap rounded-lg px-3 py-2 text-sm font-medium transition', 'bg-brand text-white' => $durum === $deger, 'text-ink-muted hover:bg-canvas' => $durum !== $deger])>
                        {{ $etiket }} <span class="opacity-70">{{ $this->sayilar[$deger] }}</span>
                    </button>
                @endforeach
            </div>
        </div>

        <flux:card class="overflow-x-auto !p-0">
            <table class="w-full min-w-[56rem] text-sm">
                <thead class="border-b border-line bg-canvas text-xs font-semibold uppercase tracking-wide text-ink-subtle">
                    <tr>
                        <th class="px-5 py-3 text-start">Üniversite</th>
                        <th class="px-3 py-3 text-start">Durum</th>
                        <th class="px-3 py-3 text-start">Kapsam</th>
                        <th class="px-3 py-3 text-start">Cetvel</th>
                        <th class="px-3 py-3 text-center">Kaynak</th>
                        <th class="px-5 py-3 text-end">Kullanıcı</th>
                    </tr>
                </thead>
                <tbody data-sirali>
                    @forelse ($this->satirlar as $satir)
                        <tr wire:key="yonerge-{{ md5($satir['ad']) }}" class="border-b border-line last:border-0 hover:bg-canvas">
                            <td class="px-5 py-3">
                                <a href="{{ route('admin.yonerge', $satir['ad']) }}" wire:navigate class="block">
                                    <span class="block font-medium text-ink hover:text-brand">{{ $satir['ad'] }}</span>
                                    <span class="block text-xs text-ink-subtle">{{ collect([$satir['sehir'], $satir['tur'] ? ucfirst($satir['tur']) : null])->filter()->implode(' · ') ?: 'Künye yok' }}</span>
                                </a>
                            </td>
                            <td class="px-3 py-3">
                                <flux:badge :color="$durumRozeti[$satir['durum']]" size="sm">{{ Yonergeler::DURUMLAR[$satir['durum']] }}</flux:badge>
                            </td>
                            <td class="px-3 py-3">
                                @if ($satir['kapsam'] > 0)
                                    <div class="flex items-center gap-2">
                                        <div class="h-1.5 w-20 overflow-hidden rounded-full bg-line">
                                            <div class="h-full rounded-full bg-brand" style="width: {{ round($satir['kapsam'] / YonergeOzeti::TAM_KAPSAM * 100) }}%"></div>
                                        </div>
                                        <span class="tabular-nums text-ink-muted">{{ $satir['kapsam'] }}/{{ YonergeOzeti::TAM_KAPSAM }}</span>
                                    </div>
                                @else
                                    <span class="text-ink-subtle">—</span>
                                @endif
                            </td>
                            <td class="max-w-56 truncate px-3 py-3 text-xs text-ink-muted">{{ implode(', ', $satir['cetveller']) ?: '—' }}</td>
                            <td class="px-3 py-3 text-center">
                                @if ($satir['kaynak_pdf'])
                                    <a href="{{ route('admin.yonerge-kaynak', $satir['ad']) }}" target="_blank" class="text-brand" title="Kaynak PDF"><flux:icon name="document-text" class="inline size-5" /></a>
                                @else
                                    <span class="text-ink-subtle">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-end tabular-nums text-ink-muted">{{ $satir['kullanici'] ?: '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-12 text-center"><flux:text>Bu filtrede üniversite yok.</flux:text></td></tr>
                    @endforelse
                </tbody>
            </table>
        </flux:card>
    </div>
</div>
