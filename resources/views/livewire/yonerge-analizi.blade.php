<div>
    <x-topbar title="Yönerge Analizi" :pill="count($this->sonuclar) . ' üniversite'">
        <flux:button wire:click="$toggle('karsilastirma')" size="sm" :variant="$karsilastirma ? 'filled' : 'primary'" icon="table-cells">
            {{ $karsilastirma ? 'Kartlara Dön' : 'Üniversite Karşılaştır' }}
        </flux:button>
    </x-topbar>

    <div class="flex flex-col gap-4">

        <div class="grid gap-4 lg:grid-cols-[260px_1fr]">

            {{-- Sol panel: profil + filtreler --}}
            <div class="flex flex-col gap-4">
                {{-- Mevcut Profilim (05_yonerge_analizi.html: navy zeminli) --}}
                <div class="rounded-xl bg-navy p-4">
                    <div class="mb-3 text-[10px] font-semibold uppercase tracking-wider text-white/40">Mevcut Profilim</div>
                    <div class="flex flex-col gap-1.5">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-xs text-white/55">Bölüm</span>
                            <span class="truncate text-xs font-semibold text-white">{{ auth()->user()->bolum ?? '—' }}</span>
                        </div>
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-xs text-white/55">Temel Alan</span>
                            <span class="truncate text-xs font-semibold text-white">{{ auth()->user()->temel_alan?->label() ?? '—' }}</span>
                        </div>
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-xs text-white/55">Unvan</span>
                            <span class="truncate text-xs font-semibold text-white">{{ auth()->user()->unvan ?? '—' }}</span>
                        </div>
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-xs text-white/55">Üniversite</span>
                            <span class="truncate text-xs font-semibold text-white">{{ auth()->user()->universite ?? '—' }}</span>
                        </div>
                    </div>
                    <div class="my-3 h-px bg-white/10"></div>
                    {{-- Tek bir "toplam puan" yok: her yönerge kendi cetveliyle
                         puanlıyor. Onun yerine değerlendirmenin kesinliğini
                         belirleyen iki girdi gösteriliyor. --}}
                    <div class="flex items-baseline justify-between">
                        <span class="text-xs text-white/55">Onaylı Faaliyet</span>
                        <span class="font-serif text-2xl font-bold text-gold">{{ $this->faaliyetler->count() }}</span>
                    </div>
                    <div class="mt-2 flex items-baseline justify-between">
                        <span class="text-xs text-white/55">Akademik Profil</span>
                        <span class="font-serif text-lg font-bold text-white">%{{ $this->profilDoluluk }}</span>
                    </div>
                    <div class="mt-1.5 h-1 overflow-hidden rounded-full bg-white/10">
                        <div class="h-full rounded-full bg-gold" style="width: {{ $this->profilDoluluk }}%"></div>
                    </div>
                    @if ($this->profilDoluluk < 100)
                        <a href="{{ route('profile.edit') }}" wire:navigate
                            class="mt-2 flex items-center gap-1 text-[11px] font-medium text-gold/80 transition hover:text-gold">
                            <flux:icon name="pencil-square" class="size-3" />
                            Eksik bilgileri tamamla
                        </a>
                    @endif
                </div>

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

                    <flux:text class="text-[11px] text-ink-subtle">Analiz <strong>{{ $kadrolar[$hedefKadro] }}</strong> kadrosuna atama kriterlerine göredir.</flux:text>
                </flux:card>
            </div>

            {{-- Sağ panel: özet + sonuç listesi --}}
            <div class="flex flex-col gap-3">

                {{-- Özet bar: durum sayaçları + sıralama + görünüm --}}
                <div class="flex flex-wrap items-center justify-between gap-3 rounded-xl border border-line bg-surface px-4 py-2.5">
                    <div class="flex items-center gap-3">
                        @foreach ([['Toplam', $this->ozet['toplam'], 'var(--color-ink)'], ['Yetersiz', $this->ozet['yetersiz'], 'var(--color-cat-red)'], ['Yakın', $this->ozet['yakin'], 'var(--color-cat-amber)'], ['Eksik Bilgi', $this->ozet['eksik_bilgi'], 'var(--color-cat-amber)'], ['Yapılabilir', $this->ozet['uygun'], 'var(--color-cat-green)']] as $stat)
                            @if (! $loop->first)<div class="h-8 w-px bg-line"></div>@endif
                            <div class="text-center">
                                <div class="font-serif text-lg font-bold leading-none" style="color: {{ $stat[2] }}">{{ $stat[1] }}</div>
                                <div class="mt-1 text-[10px] leading-tight text-ink-subtle">{{ $stat[0] }}</div>
                            </div>
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

                {{-- Sonuç kartları --}}
                @php
                    // Motor üç değerli sonuç ürettiği için dört ekran durumu var.
                    // "Eksik Bilgi" olumsuz bir sonuç DEĞİL: kesin olumsuz yaprak
                    // yok, ama profil/tarih eksikliği yüzünden karara bağlanamıyor.
                    $renkler = ['uygun' => 'var(--color-cat-green)', 'yakin' => 'var(--color-cat-amber)', 'eksik_bilgi' => 'var(--color-cat-amber)', 'yetersiz' => 'var(--color-cat-red)'];
                    $badgeRenkler = ['uygun' => 'green', 'yakin' => 'amber', 'eksik_bilgi' => 'amber', 'yetersiz' => 'red'];
                    $badgeMetinleri = ['uygun' => 'Uygun', 'yakin' => 'Yakın', 'eksik_bilgi' => 'Eksik Bilgi', 'yetersiz' => 'Yetersiz'];
                @endphp

                @if (empty($this->sonuclar))
                    <flux:card class="py-12 text-center">
                        <flux:text>Seçili filtrelere uygun yönerge bulunamadı.</flux:text>
                    </flux:card>
                @elseif ($karsilastirma)
                    {{-- Karşılaştırma tablosu --}}
                    <flux:card class="overflow-x-auto !p-0">
                        <table class="w-full border-collapse text-sm">
                            <thead>
                                <tr class="border-b border-line text-left text-[10px] uppercase tracking-wide text-ink-subtle">
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
                                @foreach ($this->sonuclar as $s)
                                    @php
                                        $renk = $renkler[$s['durum']];
                                    @endphp
                                    <tr class="cursor-pointer border-b border-line transition-colors last:border-0 hover:bg-canvas"
                                        wire:key="krs-{{ $s['universite']->id }}"
                                        wire:click="detayAc({{ $s['universite']->id }})"
                                        x-on:click="$wire.detayAcik = true">
                                        <td class="px-4 py-2.5">
                                            <div class="flex items-center gap-1.5">
                                                <span class="font-medium text-ink">{{ $s['universite']->ad }}</span>
                                                <flux:icon name="check-badge" variant="solid" class="size-3.5 text-brand" title="Doğrulandı" />
                                            </div>
                                            <div class="text-[11px] text-ink-subtle">{{ $s['universite']->sehir }} · {{ $s['universite']->tur === 'vakif' ? 'Vakıf' : 'Devlet' }}</div>
                                        </td>
                                        <td class="px-4 py-2.5 text-ink-muted">{{ $kadrolar[$hedefKadro] }}</td>
                                        <td class="px-4 py-2.5 font-serif font-bold text-ink">{{ $s['baraj'] }}</td>
                                        <td class="px-4 py-2.5 font-serif font-bold text-ink">{{ $s['toplam'] }}</td>
                                        <td class="px-4 py-2.5 font-serif font-bold" style="color: {{ $renk }}">%{{ $s['oran'] }}</td>
                                        <td class="px-4 py-2.5 font-serif font-bold" style="color: {{ $renk }}">{{ $s['kalan'] === 0 ? '+'.($s['toplam'] - $s['baraj']) : '-'.$s['kalan'] }}</td>
                                        <td class="px-4 py-2.5"><flux:badge :color="$badgeRenkler[$s['durum']]" size="sm">{{ $badgeMetinleri[$s['durum']] }}</flux:badge></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </flux:card>
                @else
                    <div @class(['grid gap-3 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4' => $gorunum === 'grid', 'flex flex-col gap-2' => $gorunum === 'list'])>
                        @foreach ($this->sonuclar as $s)
                            @php
                                $uni = $s['universite'];
                                $renk = $renkler[$s['durum']];
                                $badgeRenk = $badgeRenkler[$s['durum']];
                                $badgeMetin = $badgeMetinleri[$s['durum']];
                                $bashkler = \Illuminate\Support\Str::of($uni->ad)->explode(' ')
                                    ->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->take(3)->implode('');
                            @endphp
                            {{-- $wire.detayAcik = true: panel sunucu yanıtını beklemeden kaymaya başlar. --}}
                            <flux:card class="cursor-pointer overflow-hidden !p-0 transition duration-200 hover:-translate-y-0.5 hover:border-brand/40 hover:shadow-lg active:translate-y-0"
                                wire:key="uni-{{ $uni->id }}"
                                wire:click="detayAc({{ $uni->id }})"
                                x-on:click="$wire.detayAcik = true"
                                role="button" tabindex="0"
                                x-on:keydown.enter.prevent="$wire.detayAcik = true; $wire.detayAc({{ $uni->id }})"
                                x-on:keydown.space.prevent="$wire.detayAcik = true; $wire.detayAc({{ $uni->id }})"
                                aria-label="{{ $uni->ad }} detayları">
                                <div class="h-1" style="background: {{ $renk }}"></div>
                                <div class="p-4">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex min-w-0 items-center gap-3">
                                            <div class="flex size-10 shrink-0 items-center justify-center rounded-lg border border-line bg-canvas text-[11px] font-bold text-ink-muted">{{ $bashkler }}</div>
                                            <div class="min-w-0">
                                                <div class="truncate text-sm font-semibold text-ink">{{ $uni->ad }}</div>
                                                <div class="mt-0.5 flex items-center gap-1 text-xs text-ink-subtle">
                                                    <flux:icon name="map-pin" class="size-3" />
                                                    {{ $uni->sehir }} · {{ $uni->tur === 'vakif' ? 'Vakıf' : 'Devlet' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex shrink-0 flex-col items-end gap-1">
                                            <flux:badge :color="$badgeRenk" size="sm">{{ $badgeMetin }}</flux:badge>
                                            <span class="inline-flex items-center gap-1 text-[10px] font-medium text-brand">
                                                <flux:icon name="check-badge" variant="solid" class="size-3" />Doğrulandı
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Puan karşılaması (eşleşme oranı) --}}
                                    <div class="mt-4">
                                        <div class="mb-1.5 flex items-center justify-between text-xs">
                                            <span class="text-ink-subtle">Puan karşılaması</span>
                                            <span class="font-semibold text-ink-muted">{{ $s['toplam'] }} / {{ $s['baraj'] }} pt · %{{ $s['puan_orani'] }}</span>
                                        </div>
                                        <div class="h-1.5 overflow-hidden rounded-full bg-line">
                                            <div class="h-full rounded-full" style="width: {{ $s['puan_orani'] }}%; background: {{ $renk }}"></div>
                                        </div>
                                    </div>

                                    {{-- Asgari koşullar: kartta yalnızca kökün doğrudan
                                         çocukları; tam ağaç detay panelinde. --}}
                                    <div class="mt-4 flex flex-col gap-1.5">
                                        @foreach ($s['sonuc']->cocuklar as $kosul)
                                            <div class="flex items-center justify-between gap-2 text-xs">
                                                <span class="flex min-w-0 items-center gap-1.5 text-ink-muted">
                                                    @if ($kosul->beyan)
                                                        <flux:icon name="information-circle" class="size-3.5 shrink-0 text-ink-subtle" />
                                                    @else
                                                        <flux:icon :name="$kosul->durum->ikon()" variant="solid" class="size-3.5 shrink-0" style="color: {{ $kosul->durum->renk() }}" />
                                                    @endif
                                                    <span class="truncate">{{ $kosul->aciklama }}</span>
                                                </span>
                                                <span class="shrink-0 font-semibold" style="color: {{ $kosul->beyan ? 'var(--color-ink-subtle)' : $kosul->durum->renk() }}">
                                                    @if ($kosul->beyan)
                                                        belge ile
                                                    @elseif ($kosul->gerekli !== null)
                                                        {{ $kosul->mevcut }} / {{ $kosul->gerekli }}
                                                    @else
                                                        {{ $kosul->durum->etiket() }}
                                                    @endif
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>

                                    @if ($s['belirsiz_sayisi'] > 0)
                                        <div class="mt-2 flex items-start gap-1 text-[11px] text-cat-amber">
                                            <flux:icon name="question-mark-circle" class="mt-px size-3 shrink-0" />
                                            <span>{{ $s['belirsiz_sayisi'] }} koşul eksik bilgi yüzünden değerlendirilemedi.</span>
                                        </div>
                                    @endif

                                    @if ($uni->yonerge_url)
                                        <a href="{{ $uni->yonerge_url }}" target="_blank" rel="noopener" x-on:click.stop
                                            class="mt-3 flex items-center justify-center gap-1.5 rounded-lg border border-line py-2 text-xs font-medium text-brand transition hover:border-brand hover:bg-brand-light">
                                            <flux:icon name="document-arrow-down" class="size-3.5" />
                                            Resmi Yönergeyi Aç
                                        </a>
                                    @endif

                                    <div class="mt-2 flex items-center justify-center gap-1 text-[11px] font-medium text-ink-subtle">
                                        <flux:icon name="arrows-pointing-out" class="size-3" />
                                        Detay için karta tıklayın
                                    </div>
                                </div>
                            </flux:card>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Üniversite detay modalı --}}
    <flux:modal wire:model.self="detayAcik" flyout position="right" data-detay-flyout class="w-full md:w-[34rem]">
        {{-- Panel tıklamayla anında açılır; detay sunucudan gelene kadar iskelet gösterilir. --}}
        <div wire:loading.flex wire:target="detayAc" class="flex-col gap-6">
            <div class="flex items-start gap-3 pr-8">
                <div class="size-12 shrink-0 animate-pulse rounded-xl bg-line"></div>
                <div class="flex-1 space-y-2 pt-1">
                    <div class="h-4 w-2/3 animate-pulse rounded bg-line"></div>
                    <div class="h-3 w-1/2 animate-pulse rounded bg-line"></div>
                </div>
            </div>
            <div class="h-16 animate-pulse rounded-xl bg-line"></div>
            <div class="space-y-2">
                <div class="h-3 w-1/3 animate-pulse rounded bg-line"></div>
                <div class="h-2 animate-pulse rounded-full bg-line"></div>
            </div>
            <div class="space-y-3">
                @foreach (range(1, 4) as $i)
                    <div class="space-y-1.5">
                        <div class="h-3 w-1/2 animate-pulse rounded bg-line"></div>
                        <div class="h-1 animate-pulse rounded-full bg-line"></div>
                    </div>
                @endforeach
            </div>
        </div>

        <div wire:loading.remove wire:target="detayAc">
        @if ($d = $this->detay)
            @php
                $uni = $d['universite'];
                $esik = $d['esik'];
                $renk = ['uygun' => 'var(--color-cat-green)', 'yakin' => 'var(--color-cat-amber)', 'eksik_bilgi' => 'var(--color-cat-amber)', 'yetersiz' => 'var(--color-cat-red)'][$d['durum']];
                $badgeRenk = ['uygun' => 'green', 'yakin' => 'amber', 'eksik_bilgi' => 'amber', 'yetersiz' => 'red'][$d['durum']];
                $badgeMetin = ['uygun' => 'Başvuru Yapılabilir', 'yakin' => 'Yakın Sınırda', 'eksik_bilgi' => 'Eksik Bilgi', 'yetersiz' => 'Puan Yetersiz'][$d['durum']];
                $bashkler = \Illuminate\Support\Str::of($uni->ad)->explode(' ')
                    ->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->take(3)->implode('');
                $eksikler = $d['sonuc']->eksikler();
                $belirsizler = $d['sonuc']->belirsizler();
            @endphp

            <div class="flex flex-col gap-6">

                {{-- Başlık --}}
                <div class="flex items-start gap-3 pr-8">
                    <div class="flex size-12 shrink-0 items-center justify-center rounded-xl border border-line bg-canvas text-sm font-bold text-ink-muted">{{ $bashkler }}</div>
                    <div class="min-w-0 flex-1">
                        <flux:heading size="lg" class="!leading-tight">{{ $uni->ad }}</flux:heading>
                        <div class="mt-1 flex flex-wrap items-center gap-x-2 gap-y-1 text-xs text-ink-subtle">
                            <span class="inline-flex items-center gap-1">
                                <flux:icon name="map-pin" class="size-3" />{{ $uni->sehir }}
                            </span>
                            <span>·</span>
                            <span>{{ $uni->tur === 'vakif' ? 'Vakıf' : 'Devlet' }}</span>
                            <span>·</span>
                            <span class="inline-flex items-center gap-1 font-medium text-brand">
                                <flux:icon name="check-badge" variant="solid" class="size-3" />Doğrulandı
                            </span>
                        </div>
                    </div>
                    <flux:badge :color="$badgeRenk" size="sm" class="shrink-0">{{ $badgeMetin }}</flux:badge>
                </div>

                {{-- Değerlendirme künyesi --}}
                <div class="grid grid-cols-2 gap-px overflow-hidden rounded-xl border border-line bg-line sm:grid-cols-4">
                    @foreach ([
                        ['Hedef Kadro', $kadrolar[$hedefKadro]],
                        ['Temel Alan', $this->alanEtiketi($esik['alan'])],
                        ['Puanım', $d['toplam'].' pt'],
                        ['Min. Baraj', $d['baraj'].' pt'],
                    ] as [$etiket, $deger])
                        <div class="bg-surface px-3 py-2.5">
                            <div class="text-[10px] uppercase tracking-wide text-ink-subtle">{{ $etiket }}</div>
                            <div class="mt-0.5 truncate text-sm font-semibold text-ink" title="{{ $deger }}">{{ $deger }}</div>
                        </div>
                    @endforeach
                </div>

                {{-- Genel durum --}}
                <div>
                    <div class="mb-1.5 flex items-baseline justify-between">
                        <flux:heading size="sm">Puan karşılaması</flux:heading>
                        <span class="font-serif text-lg font-bold" style="color: {{ $renk }}">%{{ $d['puan_orani'] }}</span>
                    </div>
                    <div class="h-2 overflow-hidden rounded-full bg-line">
                        <div class="h-full rounded-full transition-all" style="width: {{ $d['puan_orani'] }}%; background: {{ $renk }}"></div>
                    </div>
                    <div class="mt-2 text-xs text-ink-muted">
                        @if ($d['durum'] === 'uygun')
                            Bu yönergenin tüm asgari koşullarını karşılıyorsunuz; barajı <strong class="text-ink">{{ $d['toplam'] - $d['baraj'] }} puan</strong> aşıyorsunuz.
                        @elseif ($d['durum'] === 'eksik_bilgi')
                            Kesin olarak karşılanmayan bir koşul yok, ancak
                            <strong class="text-ink">{{ count($belirsizler) }} koşul</strong>
                            eksik bilgi yüzünden değerlendirilemedi.
                        @else
                            @if ($d['kalan'] > 0)
                                Barajı geçmek için <strong class="text-ink">{{ $d['kalan'] }} puan</strong> daha gerekiyor.
                            @endif
                            @if (count($eksikler) > 0)
                                {{ count($eksikler) }} koşul karşılanmıyor.
                            @endif
                        @endif
                    </div>

                    {{-- Belirsizliğin gerekçesi: motor tahmin yürütmüyor. --}}
                    @if (count($belirsizler) > 0)
                        <div class="mt-3 rounded-xl border border-cat-amber/30 bg-cat-amber/5 p-3">
                            <div class="mb-1.5 flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-wider text-cat-amber">
                                <flux:icon name="question-mark-circle" class="size-3.5" />Değerlendirilemeyen Koşullar
                            </div>
                            <flux:text class="!text-[11px] leading-relaxed">
                                Aşağıdaki koşullar <strong>sağlanmadığı için değil</strong>, veri eksik olduğu için
                                karara bağlanamadı. Faaliyet tarihlerini ve
                                <a href="{{ route('profile.edit') }}" wire:navigate class="font-medium text-brand underline">akademik profilinizi</a>
                                tamamladığınızda kesin sonuç görürsünüz.
                            </flux:text>
                        </div>
                    @endif
                </div>

                <flux:separator variant="subtle" />

                {{-- Asgari koşullar: yönergenin kendi şart ağacı, olduğu gibi --}}
                <div>
                    <flux:heading size="sm">Asgari Koşullar</flux:heading>
                    <flux:text class="!mt-0.5 !text-[11px] text-ink-subtle">Yönergenin kendi koşul yapısı; iç içe geçmiş koşullar ve telafi seçenekleri dâhil.</flux:text>

                    <div class="mt-3 flex flex-col gap-3">
                        @foreach ($d['sonuc']->cocuklar as $i => $kosul)
                            <div wire:key="kosul-{{ $i }}">
                                <x-sart-dugum :dugum="$kosul" />
                            </div>
                        @endforeach
                    </div>
                </div>

                <flux:separator variant="subtle" />

                {{-- Kategori dağılımı (bu yönergenin kendi cetveline göre) --}}
                <div>
                    <flux:heading size="sm">Puanımın Dağılımı</flux:heading>
                    <flux:text class="!mt-0.5 !text-[11px] text-ink-subtle">Faaliyetleriniz bu üniversitenin kendi cetveline göre yeniden puanlandı.</flux:text>

                    @php
                        $enYuksek = max(1, collect($d['dagilim'])->max('puan') ?? 1);
                    @endphp
                    <div class="mt-3 flex flex-col gap-2.5">
                        @foreach ($d['dagilim'] as $deger => $satir)
                            @php $kategori = \App\Enums\Kategori::tryFrom($deger); @endphp
                            @continue (! $kategori)
                            <div wire:key="kat-{{ $deger }}">
                                <div class="flex items-center justify-between gap-2 text-xs">
                                    <span class="flex min-w-0 items-center gap-1.5 text-ink-muted">
                                        <flux:icon :name="$kategori->ikon()" class="size-3.5 shrink-0" style="color: var(--color-{{ $kategori->renk() }})" />
                                        <span class="truncate">{{ $kategori->label() }}</span>
                                        <span class="shrink-0 text-ink-subtle">({{ $satir['adet'] }})</span>
                                    </span>
                                    <span class="shrink-0 font-semibold text-ink">{{ $satir['puan'] }} pt</span>
                                </div>
                                <div class="mt-1.5 h-1 overflow-hidden rounded-full bg-line">
                                    <div class="h-full rounded-full" style="width: {{ (int) round($satir['puan'] / $enYuksek * 100) }}%; background: var(--color-{{ $kategori->renk() }})"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-3 flex items-baseline justify-between rounded-lg bg-canvas px-3 py-2">
                        <span class="text-xs font-medium text-ink-muted">Toplam</span>
                        <span class="font-serif text-lg font-bold text-ink">{{ $d['toplam'] }} pt</span>
                    </div>
                </div>

                {{-- Yönerge notu --}}
                @if ($esik['notlar'])
                    <div class="rounded-xl border border-line bg-canvas p-3">
                        <div class="mb-1 flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-wider text-ink-subtle">
                            <flux:icon name="document-text" class="size-3.5" />Yönerge Notu
                        </div>
                        <flux:text class="!text-xs leading-relaxed">{{ $esik['notlar'] }}</flux:text>
                    </div>
                @endif

                {{-- Aksiyonlar --}}
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <flux:text class="!text-[11px] text-ink-subtle">
                        {{ $uni->ad }} · {{ $kadrolar[$hedefKadro] }} · cetvel: {{ $esik['cetvel'] }}
                    </flux:text>
                    <div class="flex items-center gap-2">
                        <flux:modal.close>
                            <flux:button variant="filled" size="sm">Kapat</flux:button>
                        </flux:modal.close>
                        @if ($uni->yonerge_url)
                            <flux:button :href="$uni->yonerge_url" target="_blank" rel="noopener" variant="primary" size="sm" icon="document-arrow-down">
                                Resmi Yönergeyi Aç
                            </flux:button>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        </div>
    </flux:modal>
</div>
