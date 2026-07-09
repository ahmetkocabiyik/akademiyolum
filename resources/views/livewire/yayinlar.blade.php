<div>
    <div class="flex flex-col gap-4">

        {{-- Başlık --}}
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">Yayınlar</flux:heading>
                <flux:text class="mt-1">Yayın ve faaliyet kayıtlarınız, otomatik puanlama ile</flux:text>
            </div>
            <flux:button :href="route('yayinlar.ekle')" wire:navigate variant="primary" icon="plus">Yayın Ekle</flux:button>
        </div>

        {{-- Araç çubuğu --}}
        <div class="flex flex-wrap items-center gap-2">
            <flux:input wire:model.live.debounce.300ms="arama" icon="magnifying-glass" placeholder="Başlıkta ara..." class="max-w-xs" />
            <flux:select wire:model.live="kategoriFiltre" placeholder="Tüm kategoriler" class="max-w-xs">
                <flux:select.option value="">Tüm kategoriler</flux:select.option>
                @foreach ($kategoriler as $deger => $etiket)
                    <flux:select.option :value="$deger">{{ $etiket }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>

        {{-- Liste --}}
        <flux:card>
            @if ($faaliyetler->isEmpty())
                <div class="flex flex-col items-center gap-2 py-12 text-center">
                    <flux:icon name="document-plus" class="size-8 text-ink-subtle" />
                    <flux:text>Kayıt bulunamadı.</flux:text>
                    <flux:button :href="route('yayinlar.ekle')" wire:navigate size="sm" variant="primary" icon="plus">Faaliyet ekle</flux:button>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-sm">
                        <thead>
                            <tr class="border-b border-line text-left text-[10px] uppercase tracking-wide text-ink-subtle">
                                <th class="px-2 py-2 font-semibold">Başlık</th>
                                <th class="px-2 py-2 font-semibold">Kategori</th>
                                <th class="px-2 py-2 font-semibold">Tür / Kaynak</th>
                                <th class="px-2 py-2 font-semibold">Puan</th>
                                <th class="px-2 py-2 font-semibold">Durum</th>
                                <th class="px-2 py-2 text-right font-semibold">İşlem</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($faaliyetler as $f)
                                <tr wire:key="faaliyet-{{ $f->id }}" class="border-b border-line last:border-0 hover:bg-canvas">
                                    <td class="max-w-[260px] truncate px-2 py-2.5 font-medium text-ink">
                                        {{ $f->baslik }}
                                        <div class="text-[10px] text-ink-subtle">{{ $f->yazarlar }}</div>
                                    </td>
                                    <td class="px-2 py-2.5"><flux:badge size="sm">{{ $f->kategori->label() }}</flux:badge></td>
                                    <td class="px-2 py-2.5 text-ink-muted">
                                        {{ $f->tur }}
                                        @if ($f->kaynak)<div class="text-[10px] text-ink-subtle">{{ $f->kaynak }}</div>@endif
                                    </td>
                                    <td class="px-2 py-2.5 font-serif font-bold text-brand">{{ $f->puan }}</td>
                                    <td class="px-2 py-2.5">
                                        <flux:badge :color="$f->durum === 'onaylandi' ? 'green' : 'amber'" size="sm">
                                            {{ $f->durum === 'onaylandi' ? 'Onaylandı' : 'Beklemede' }}
                                        </flux:badge>
                                    </td>
                                    <td class="px-2 py-2.5">
                                        <div class="flex justify-end gap-1">
                                            <flux:button :href="route('yayinlar.duzenle', $f)" wire:navigate size="xs" variant="ghost" icon="pencil-square" inset />
                                            <flux:button wire:click="sil({{ $f->id }})" wire:confirm="Bu faaliyet silinsin mi?" size="xs" variant="ghost" icon="trash" inset />
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </flux:card>
    </div>
</div>
