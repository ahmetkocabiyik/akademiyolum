<div>
    <x-topbar title="Faaliyetler" :pill="$faaliyetler->count() . ' kayıt'">
        <flux:button :href="route('faaliyetler.ekle')" wire:navigate variant="primary" icon="plus">Faaliyet Ekle</flux:button>
    </x-topbar>

    <div class="flex flex-col gap-4">

        {{-- Araç çubuğu --}}
        <div class="flex flex-wrap items-center gap-2">
            <flux:input wire:model.live.debounce.300ms="arama" icon="magnifying-glass" placeholder="Başlıkta ara..." class="sm:max-w-xs" />
            <x-secim-listesi model="kategoriFiltre" canli class="sm:max-w-xs" placeholder="Tüm kategoriler"
                :secenekler="['' => 'Tüm kategoriler'] + $kategoriler" />
        </div>

        {{-- Liste --}}
        <flux:card class="max-sm:!p-4">
            @if ($faaliyetler->isEmpty())
                <div class="flex flex-col items-center gap-2 py-12 text-center">
                    <flux:icon name="document-plus" class="size-8 text-ink-subtle" />
                    <flux:text>Kayıt bulunamadı.</flux:text>
                    <flux:button :href="route('faaliyetler.ekle')" wire:navigate variant="primary" icon="plus">Faaliyet ekle</flux:button>
                </div>
            @else
                @php
                    $seciliAdet = count($secili);
                    $hepsiSecili = $faaliyetler->pluck('id')->diff(array_map('intval', $secili))->isEmpty();
                @endphp

                {{-- Toplu işlem çubuğu: yalnız en az bir kayıt işaretliyken. --}}
                @if ($seciliAdet > 0)
                    <div data-toplu-islem class="mb-3 flex flex-wrap items-center gap-2 rounded-lg border border-brand/25 bg-brand-light px-3 py-2">
                        <span class="text-sm font-medium text-ink">{{ $seciliAdet }} kayıt seçili</span>
                        <div class="ms-auto flex flex-wrap items-center gap-1.5">
                            <flux:button wire:click="topluDurum('onaylandi')" size="sm" icon="check-circle">Onayla</flux:button>
                            <flux:button wire:click="topluDurum('beklemede')" size="sm" icon="clock">Beklemeye al</flux:button>
                            <flux:button x-on:click="confirm('{{ $seciliAdet }} faaliyet silinsin mi?') && $wire.topluSil()" size="sm" variant="danger" icon="trash">Sil</flux:button>
                            <flux:button wire:click="$set('secili', [])" size="sm" variant="ghost">Seçimi kaldır</flux:button>
                        </div>
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-sm">
                        <thead>
                            <tr class="border-b border-line text-left text-2xs uppercase tracking-wide text-ink-subtle">
                                <th class="w-8 py-2 ps-0 pe-1 md:px-2">
                                    <input type="checkbox" wire:click="tumunuSecDegistir" @checked($hepsiSecili && $seciliAdet > 0)
                                        data-tumunu-sec aria-label="Görünen tüm faaliyetleri seç"
                                        class="size-4 cursor-pointer rounded accent-brand align-middle" />
                                </th>
                                <th class="px-2 py-2 font-semibold">Başlık</th>
                                <th class="px-2 py-2 font-semibold max-md:hidden">Kategori</th>
                                <th class="px-2 py-2 font-semibold max-md:hidden">Tür / Kaynak</th>
                                <th class="px-2 py-2 font-semibold max-md:hidden">Tarih</th>
                                <th class="px-1 py-2 font-semibold md:px-2">Puan</th>
                                <th class="px-2 py-2 font-semibold max-md:hidden">Durum</th>
                                <th class="py-2 ps-1 pe-0 text-right font-semibold md:px-2">İşlem</th>
                            </tr>
                        </thead>
                        <tbody data-sirali>
                            @foreach ($faaliyetler as $f)
                                {{--
                                    Satırın tamamı düzenlemeye götürür. Başlık gerçek bir <a>
                                    olduğu için klavye ve ekran okuyucu erişimi korunur; satır
                                    tıklaması yalnızca fare için o bağlantıyı tetikler. İşlem
                                    sütunundaki düğmeler ve seçim kutusu hariç tutulur, aksi hâlde silme
                                    isteği aynı anda düzenlemeye de giderdi.
                                --}}
                                <tr wire:key="faaliyet-{{ $f->id }}"
                                    @if (in_array($f->id, $vurgulanan, true)) data-vurgu @endif
                                    x-data
                                    x-on:click="$event.target.closest('a, button, input, label') || $refs.duzenle.click()"
                                    class="cursor-pointer border-b border-line last:border-0 hover:bg-canvas">
                                    <td class="w-8 py-2.5 ps-0 pe-1 align-top md:px-2 md:align-middle">
                                        <input type="checkbox" wire:model.live="secili" value="{{ $f->id }}"
                                            data-sec="{{ $f->id }}" aria-label="{{ $f->baslik }} — seç"
                                            class="size-4 cursor-pointer rounded accent-brand align-middle" />
                                    </td>
                                    <td class="px-2 py-2.5 font-medium text-ink md:max-w-[260px] md:truncate">
                                        <a href="{{ route('faaliyetler.duzenle', $f) }}" wire:navigate x-ref="duzenle"
                                            class="hover:text-brand max-md:line-clamp-2">{{ $f->baslik }}</a>
                                        <div class="truncate text-2xs text-ink-subtle">{{ $f->yazarlar }}</div>
                                        {{-- Dar ekranda gizlenen sütunların özeti: tablo yatay kaymasın. --}}
                                        <div class="mt-1.5 flex flex-wrap items-center gap-1.5 md:hidden">
                                            <flux:badge size="sm">{{ $f->kategori->label() }}</flux:badge>
                                            <flux:badge :color="$f->durum === 'onaylandi' ? 'green' : 'amber'" size="sm">
                                                {{ $f->durum === 'onaylandi' ? 'Onaylandı' : 'Beklemede' }}
                                            </flux:badge>
                                            @if ($f->tarih)
                                                <span class="text-2xs text-ink-subtle">{{ $f->tarih->format('d.m.Y') }}</span>
                                            @else
                                                <span class="text-2xs text-cat-amber-text">tarih girilmemiş</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-2 py-2.5 max-md:hidden"><flux:badge size="sm">{{ $f->kategori->label() }}</flux:badge></td>
                                    <td class="px-2 py-2.5 text-ink-muted max-md:hidden">
                                        {{ $f->tur }}
                                        @if ($f->kaynak)<div class="text-2xs text-ink-subtle">{{ $f->kaynak }}</div>@endif
                                    </td>
                                    {{-- Dönem koşulları bu tarihe bakıyor; boşsa aday görüp tamamlayabilsin. --}}
                                    <td class="px-2 py-2.5 text-ink-muted max-md:hidden">
                                        @if ($f->tarih)
                                            {{ $f->tarih->format('d.m.Y') }}
                                        @else
                                            <span class="text-xs text-cat-amber-text">girilmemiş</span>
                                        @endif
                                    </td>
                                    <td class="px-1 py-2.5 font-serif font-bold text-brand md:px-2" data-faaliyet-puani>{{ $puanlar[$f->id] ?? '—' }}</td>
                                    <td class="px-2 py-2.5 max-md:hidden">
                                        <flux:badge :color="$f->durum === 'onaylandi' ? 'green' : 'amber'" size="sm">
                                            {{ $f->durum === 'onaylandi' ? 'Onaylandı' : 'Beklemede' }}
                                        </flux:badge>
                                    </td>
                                    <td class="py-2.5 ps-1 pe-0 md:px-2">
                                        <div class="flex items-center justify-end gap-1 md:gap-1.5">
                                            {{-- Onay anahtarı: beklemedeki kayıt puana girmiyor. --}}
                                            @php $onayli = $f->durum === 'onaylandi'; @endphp
                                            <button type="button" wire:click="durumDegistir({{ $f->id }})"
                                                role="switch" aria-checked="{{ $onayli ? 'true' : 'false' }}"
                                                data-onay-anahtari="{{ $f->id }}"
                                                title="{{ $onayli ? 'Onaylı — beklemeye al' : 'Beklemede — onayla' }}"
                                                aria-label="{{ $onayli ? 'Onaylı; beklemeye al' : 'Beklemede; onayla' }}"
                                                class="inline-flex items-center rounded-full p-0.5 md:me-1 md:p-1">
                                                <span @class([
                                                    'relative h-5 w-9 shrink-0 rounded-full transition',
                                                    'bg-cat-green' => $onayli,
                                                    'bg-line-strong' => ! $onayli,
                                                ])>
                                                    <span @class([
                                                        'absolute top-0.5 size-4 rounded-full bg-white shadow-sm transition-all',
                                                        'start-[18px]' => $onayli,
                                                        'start-0.5' => ! $onayli,
                                                    ])></span>
                                                </span>
                                            </button>
                                            <a href="{{ route('faaliyetler.duzenle', $f) }}" wire:navigate class="act-btn" title="Düzenle" aria-label="Düzenle">
                                                <flux:icon name="pencil-square" />
                                            </a>
                                            <button type="button" x-on:click="confirm('Bu faaliyet silinsin mi?') && cikis($el.closest('tr')).then(() => $wire.sil({{ $f->id }}))" class="act-btn act-del" title="Sil" aria-label="Sil">
                                                <flux:icon name="trash" />
                                            </button>
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
