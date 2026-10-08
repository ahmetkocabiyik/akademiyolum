<div>
    @php
        use App\Enums\Kategori;
        use App\Livewire\YonergeAnalizi as Analiz;
        $esik = $this->esik;
        $sonuc = $this->sonuc;
        $onayliAdet = $this->onayli->count();
        // Yarım daire gauge yay uzunluğu (r=74 → π·74 ≈ 232.5)
        $gaugeUzunluk = 232.5;
        $gaugeOffset = $gaugeUzunluk * (1 - $this->yuzde / 100);
        // Renk ve etiket tek kaynaktan: haritalar burada kopyalanınca yönerge
        // ekranıyla panel sessizce ayrı sözcük/renk gösteriyordu.
        $durumRenk = Analiz::ROZET;
        $durumMetin = Analiz::ETIKET;
    @endphp

    <x-topbar title="Dashboard"
        :pill="$esik ? auth()->user()->universite . ' · ' . $this->kadroEtiketi() : 'Yönerge verisi yok'" />

    <div class="flex flex-col gap-4">

        {{-- Hızlı Ekle --}}
        <div class="flex flex-wrap items-center gap-2 rounded-xl border border-line bg-surface px-4 py-3">
            <span class="text-xs text-ink-subtle">Hızlı Ekle:</span>
            @foreach ([Kategori::Makale, Kategori::TezYayini, Kategori::ToplumsalKatki, Kategori::EgitimOgretim] as $k)
                <flux:button :href="route('faaliyetler.ekle', ['kategori' => $k->value])" wire:navigate variant="subtle">
                    <x-kategori-icon :kategori="$k" class="size-4" />
                    {{ $k->label() }}
                </flux:button>
            @endforeach
            <div class="ms-auto">
                <flux:button :href="route('faaliyetler.ekle')" wire:navigate variant="primary" icon="plus">
                    Faaliyet Ekle
                </flux:button>
            </div>
        </div>

        {{-- İstatistik kartları --}}
        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
            <x-dashboard.stat label="Toplam Puan" accent="brand">
                <span class="font-serif text-3xl font-bold text-ink" x-data="sayac">{{ $esik ? $this->toplam : '—' }}</span>
                <x-slot:meta>
                    @if ($this->baraj !== null)
                        <flux:badge color="blue" size="sm">{{ $this->toplam }} / {{ $this->baraj }}</flux:badge>
                        <span class="text-xs text-ink-subtle">kendi üniversiteniz</span>
                    @elseif ($esik)
                        <span class="text-xs text-ink-subtle">Bu yönerge puan kullanmıyor</span>
                    @else
                        <span class="text-xs text-ink-subtle">Üniversitenizin yönergesi girilmedi</span>
                    @endif
                </x-slot:meta>
            </x-dashboard.stat>

            <x-dashboard.stat label="Faaliyet Sayısı" accent="gold">
                <span class="font-serif text-3xl font-bold text-ink" x-data="sayac">{{ $this->faaliyetler->count() }}</span>
                <x-slot:meta>
                    <flux:badge color="green" size="sm">{{ $onayliAdet }} Onaylandı</flux:badge>
                </x-slot:meta>
            </x-dashboard.stat>

            <x-dashboard.stat label="Karşılanmayan Koşul" accent="red">
                <span class="font-serif text-3xl font-bold text-ink" x-data="sayac">{{ $sonuc ? count($sonuc->eksikler()) : '—' }}</span>
                <x-slot:meta>
                    @if ($sonuc)
                        <flux:badge :color="count($sonuc->eksikler()) === 0 ? 'green' : 'red'" size="sm">
                            {{ count($sonuc->belirsizler()) }} koşul belirsiz
                        </flux:badge>
                    @else
                        <span class="text-xs text-ink-subtle">Değerlendirme yapılamıyor</span>
                    @endif
                </x-slot:meta>
            </x-dashboard.stat>

            <x-dashboard.stat label="{{ $this->kadroEtiketi() }} Kriteri" accent="green">
                <span class="pt-1 text-lg font-bold text-ink">
                    {{ $this->durum ? $durumMetin[$this->durum] : '—' }}
                </span>
                <x-slot:meta>
                    @if ($this->durum)
                        <flux:badge :color="$durumRenk[$this->durum]" size="sm">
                            {{ $this->baraj !== null ? '%'.$this->yuzde.' baraj' : 'puansız yönerge' }}
                        </flux:badge>
                    @else
                        <span class="text-xs text-ink-subtle">Yönerge verisi bekleniyor</span>
                    @endif
                </x-slot:meta>
            </x-dashboard.stat>
        </div>

        {{-- Hedef + Bildirimler --}}
        <div class="grid gap-3 lg:grid-cols-[1fr_320px]">
            {{-- Hedef analizi --}}
            <flux:card class="flex flex-col">
                <div class="flex items-start justify-between">
                    <div>
                        <flux:heading size="lg">Hedef Analizi</flux:heading>
                        <flux:text size="sm">
                            @if ($this->baraj !== null)
                                {{ auth()->user()->universite }} · {{ $this->kadroEtiketi() }} · {{ $this->baraj }} puan barajı
                            @else
                                Üniversitenizin yönergesi girildiğinde burada barajınız görünecek
                            @endif
                        </flux:text>
                    </div>
                    <flux:badge color="green" size="sm">2026 Güncel</flux:badge>
                </div>

                <div class="my-4 flex justify-center">
                    <svg width="200" height="116" viewBox="0 0 180 105">
                        <defs>
                            <linearGradient id="gauge" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="0%" stop-color="#1a56db" />
                                <stop offset="100%" stop-color="#60a5fa" />
                            </linearGradient>
                        </defs>
                        <path d="M16 103 A74 74 0 0 1 164 103" fill="none" stroke="#e2e8f0" stroke-width="11" stroke-linecap="round" />
                        <path class="olcek-yay" d="M16 103 A74 74 0 0 1 164 103" fill="none" stroke="url(#gauge)" stroke-width="11" stroke-linecap="round"
                            stroke-dasharray="{{ $gaugeUzunluk }}"
                            style="stroke-dashoffset: {{ $gaugeOffset }}; --olcek-tam: {{ $gaugeUzunluk }}" />
                        <text x="90" y="90" text-anchor="middle" font-family="Georgia,serif" font-size="26" font-weight="700" fill="#0a1628"
                            x-data="sayac">{{ $esik ? $this->toplam : '—' }}</text>
                        <text x="90" y="104" text-anchor="middle" font-size="10" fill="#94a3b8">{{ $this->baraj !== null ? '/ '.$this->baraj.' baraj' : 'veri yok' }}</text>
                    </svg>
                </div>

                <div class="flex flex-col gap-2">
                    @if ($sonuc)
                        {{-- Her asgari koşul ayrı çubuk: motorun ürettiği ağacın kök çocukları --}}
                        @foreach ($sonuc->kosullar() as $sira => $kosul)
                            @continue ($kosul->gerekli === null || $kosul->beyan)
                            <x-dashboard.bar :label="$kosul->aciklama" :yuzde="$kosul->oran()"
                                :color="$kosul->durum->renk()" :sira="$sira" />
                        @endforeach
                    @else
                        <flux:text class="!text-xs text-ink-subtle">
                            Yönerge Analizi ekranından verisi girilmiş üniversiteleri karşılaştırabilirsiniz.
                        </flux:text>
                    @endif
                </div>

                <flux:button :href="route('juri-analizi')" wire:navigate variant="subtle" class="mt-4">
                    Eksik Puan Analizi → Jüri Masası
                </flux:button>
            </flux:card>

            {{-- Bildirimler --}}
            <flux:card>
                <div class="flex items-center justify-between">
                    <flux:heading size="lg">Dinamik Bildirimler</flux:heading>
                    @if (count($this->bildirimler))
                        <flux:badge color="red" size="sm">{{ count($this->bildirimler) }}</flux:badge>
                    @endif
                </div>

                <div class="mt-3 flex flex-col gap-1.5">
                    @forelse ($this->bildirimler as $b)
                        @php
                            $renk = ['danger' => 'cat-red', 'warn' => 'cat-amber', 'info' => 'brand'][$b['tip']];
                            $ikon = ['danger' => 'exclamation-triangle', 'warn' => 'exclamation-circle', 'info' => 'information-circle'][$b['tip']];
                        @endphp
                        <div class="flex items-start gap-3 rounded-lg p-2 hover:bg-canvas">
                            <div class="flex size-7 shrink-0 items-center justify-center rounded-lg"
                                style="background: color-mix(in srgb, var(--color-{{ $renk }}) 14%, white); color: var(--color-{{ $renk }})">
                                <flux:icon :name="$ikon" class="size-4" />
                            </div>
                            <div>
                                <div class="text-xs font-medium text-ink">{{ $b['baslik'] }}</div>
                                <div class="text-xs text-ink-subtle">{{ $b['aciklama'] }}</div>
                            </div>
                        </div>
                    @empty
                        <flux:text size="sm" class="py-4 text-center">Kritik eksik bulunmuyor 🎉</flux:text>
                    @endforelse
                </div>
            </flux:card>
        </div>

        {{-- Kategori dağılımı --}}
        <div>
            <div class="mb-2.5 flex items-center justify-between">
                <flux:heading size="lg">Kategori Puan Dağılımı</flux:heading>
            </div>
            @php $enYuksek = max(1, collect($this->dagilim)->max('puan') ?: 1); @endphp
            @if (count($this->dagilim))
                <div class="grid gap-2.5 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($this->dagilim as $satir)
                        @php $renk = $satir['kategori']->renk(); @endphp
                        <flux:card class="!p-3.5" wire:key="kat-{{ $satir['kategori']->value }}">
                            <div class="flex size-7 items-center justify-center rounded-lg"
                                style="background: color-mix(in srgb, var(--color-{{ $renk }}) 14%, white); color: var(--color-{{ $renk }})">
                                <x-kategori-icon :kategori="$satir['kategori']" class="size-3.5" />
                            </div>
                            <div class="mt-2 text-xs font-medium text-ink-muted">{{ $satir['kategori']->label() }}</div>
                            <div class="font-serif text-lg font-bold text-ink">
                                {{ $esik ? $satir['puan'].' pt' : $satir['adet'].' kayıt' }}
                            </div>
                            <div class="mt-1 flex items-center justify-between text-xs text-ink-subtle">
                                <span>{{ $satir['adet'] }} kayıt</span>
                                @if ($esik && $satir['puan'] === 0)
                                    <span class="text-cat-amber-text">cetvelde karşılığı yok</span>
                                @endif
                            </div>
                            <div class="mt-1.5 h-[3px] overflow-hidden rounded-full bg-line">
                                <div class="h-full rounded-full"
                                    style="width: {{ (int) round($satir['puan'] / $enYuksek * 100) }}%; background: var(--color-{{ $renk }})"></div>
                            </div>
                        </flux:card>
                    @endforeach
                </div>
            @else
                <flux:card class="py-8 text-center">
                    <flux:text>Henüz onaylı faaliyet yok.</flux:text>
                </flux:card>
            @endif
        </div>

        {{-- Faaliyet listesi --}}
        <flux:card>
            <div class="flex items-center justify-between">
                <div>
                    <flux:heading size="lg">Faaliyet Listesi</flux:heading>
                    <flux:text size="sm">Son eklenen faaliyetler</flux:text>
                </div>
                <flux:button :href="route('faaliyetler')" wire:navigate variant="ghost">Tümünü Yönet →</flux:button>
            </div>

            @if ($this->faaliyetler->isEmpty())
                <div class="flex flex-col items-center gap-2 py-10 text-center">
                    <flux:icon name="document-plus" class="size-8 text-ink-subtle" />
                    <flux:text>Henüz faaliyet eklenmemiş.</flux:text>
                    <flux:button :href="route('faaliyetler.ekle')" wire:navigate variant="primary" icon="plus">İlk faaliyeti ekle</flux:button>
                </div>
            @else
                <div class="mt-3 overflow-x-auto">
                    <table class="w-full border-collapse text-sm">
                        <thead>
                            <tr class="border-b border-line text-left text-2xs uppercase tracking-wide text-ink-subtle">
                                <th class="px-2 py-2 font-semibold">Başlık</th>
                                <th class="px-2 py-2 font-semibold">Kategori</th>
                                <th class="px-2 py-2 font-semibold">Kaynak</th>
                                <th class="px-2 py-2 font-semibold">Puan</th>
                                <th class="px-2 py-2 font-semibold">Durum</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->faaliyetler->take(8) as $f)
                                <tr class="border-b border-line last:border-0 hover:bg-canvas">
                                    <td class="max-w-[280px] truncate px-2 py-2.5 font-medium text-ink">
                                        {{ $f->baslik }}
                                        <div class="text-2xs text-ink-subtle">{{ $f->yazarlar }}</div>
                                    </td>
                                    <td class="px-2 py-2.5">
                                        <flux:badge size="sm">{{ $f->kategori->label() }}</flux:badge>
                                    </td>
                                    <td class="px-2 py-2.5 text-ink-muted">{{ $f->kaynak ?? '—' }}</td>
                                    <td class="px-2 py-2.5 font-serif font-bold text-brand">{{ $f->puan }}</td>
                                    <td class="px-2 py-2.5">
                                        <flux:badge :color="$f->durum === 'onaylandi' ? 'green' : 'amber'" size="sm">
                                            {{ $f->durum === 'onaylandi' ? 'Onaylandı' : 'Beklemede' }}
                                        </flux:badge>
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
