<div>
    <div class="mx-auto flex max-w-3xl flex-col gap-5">

        {{-- Sekme navigasyonu --}}
        <div class="mx-auto flex rounded-full border border-line bg-surface p-1">
            @foreach (['manuel' => 'Manuel Ekle', 'avesis' => "AVESİS'ten Çek", 'scholar' => "Scholar'dan Ara"] as $anahtar => $etiket)
                <button type="button" wire:click="$set('sekme', '{{ $anahtar }}')" @class([
                    'rounded-full px-5 py-2 text-sm font-medium transition',
                    'bg-navy text-white' => $sekme === $anahtar,
                    'text-ink-muted hover:text-ink' => $sekme !== $anahtar,
                ])>{{ $etiket }}</button>
            @endforeach
        </div>

        {{-- MANUEL --}}
        @if ($sekme === 'manuel')
            <form wire:submit="kaydet" class="flex flex-col gap-5">
                <flux:card class="overflow-hidden !p-0">
                    {{-- Başlık (03_yayin_ekleme.html modal-header stili) --}}
                    <div class="flex items-start justify-between gap-4 border-b border-line px-6 py-5">
                        <div>
                            <flux:heading size="lg">{{ $faaliyet ? 'Yayını Düzenle' : 'Yayın Ekle' }}</flux:heading>
                            <flux:text class="mt-1">Bilgileri doldurun, puan otomatik hesaplanır</flux:text>
                        </div>
                        <a href="{{ route('yayinlar') }}" wire:navigate aria-label="Kapat"
                            class="flex size-9 shrink-0 items-center justify-center rounded-lg border border-line text-ink-subtle transition hover:border-cat-red hover:bg-cat-red-light hover:text-cat-red">
                            <flux:icon name="x-mark" variant="solid" class="size-5" />
                        </a>
                    </div>

                    {{-- Gövde --}}
                    <div class="flex flex-col gap-5 p-6">
                        {{-- Kategori type grid --}}
                        <div>
                            <flux:text class="mb-2 text-sm font-medium text-ink-muted">Kategori</flux:text>
                        <div class="grid grid-cols-2 gap-2 sm:grid-cols-4">
                            @foreach ($kategoriler as $k)
                                @php $secili = $kategori === $k->value; @endphp
                                <button type="button" wire:click="$set('kategori', '{{ $k->value }}')" @class([
                                    'flex flex-col items-center gap-2 rounded-xl border p-3 text-center transition',
                                    'border-brand bg-brand-light' => $secili,
                                    'border-line hover:border-brand hover:bg-brand-light/40' => ! $secili,
                                ])>
                                    <span class="flex size-8 items-center justify-center rounded-lg kat-{{ $k->value }}">
                                        <x-kategori-icon :kategori="$k" class="size-4" />
                                    </span>
                                    <span @class(['text-xs font-medium', 'text-brand' => $secili, 'text-ink-muted' => ! $secili])>{{ $k->label() }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Canlı puan önizleme --}}
                    <div class="flex items-center justify-between rounded-xl bg-navy px-5 py-4">
                        <div>
                            <div class="text-[10px] font-semibold uppercase tracking-wide text-white/40">Tahmini Puan</div>
                            <div class="flex items-baseline gap-2">
                                <span class="font-serif text-3xl font-bold text-gold">{{ $this->tahminiPuan() }}</span>
                                <span class="text-sm text-white/50">pt</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-medium text-white">{{ \App\Enums\Kategori::from($kategori)->label() }}</div>
                            <div class="mt-1 text-[11px] text-white/50">{{ $kaynak ?: 'Dizin seçilmedi' }}</div>
                        </div>
                    </div>

                    <flux:input wire:model="baslik" label="Yayın Başlığı" badge="Zorunlu" placeholder="Yayının tam başlığını girin..." />

                    {{-- Yazarlar (03_yayin_ekleme.html: çoklu yazar listesi) --}}
                    <div>
                        <flux:text class="mb-2 text-sm font-medium text-ink-muted">Yazarlar</flux:text>
                        <div class="flex flex-col gap-2">
                            @foreach ($yazarlar as $i => $yazar)
                                <div class="flex items-center gap-2" wire:key="yazar-{{ $i }}">
                                    <div class="flex size-6 shrink-0 items-center justify-center rounded-full bg-brand-light text-[10px] font-semibold text-brand">{{ $i + 1 }}</div>
                                    <flux:input wire:model="yazarlar.{{ $i }}" placeholder="Yazar adı..." class="flex-1" />
                                    @if (count($yazarlar) > 1)
                                        <button type="button" wire:click="yazarSil({{ $i }})" aria-label="Yazarı sil"
                                            class="flex size-9 shrink-0 items-center justify-center rounded-lg border border-line text-ink-subtle transition hover:border-cat-red hover:bg-cat-red-light hover:text-cat-red">
                                            <flux:icon name="x-mark" class="size-4" />
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <button type="button" wire:click="yazarEkle"
                            class="mt-2 inline-flex items-center gap-1.5 rounded-lg border border-dashed border-line-strong px-3 py-1.5 text-xs font-medium text-ink-subtle transition hover:border-brand hover:text-brand">
                            <flux:icon name="plus" class="size-3.5" />
                            Yazar Ekle
                        </button>
                    </div>

                    {{-- Dizin chip'leri --}}
                    @if (count($this->kaynakSecenekleri()))
                        <div>
                            <flux:text class="mb-2 text-sm font-medium text-ink-muted">Dizin / Endeks</flux:text>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($this->kaynakSecenekleri() as $secenek)
                                    <button type="button" wire:click="$set('kaynak', '{{ $secenek }}')" @class([
                                        'rounded-lg border px-3.5 py-1.5 text-xs font-medium transition',
                                        'border-brand bg-brand-light text-brand' => $kaynak === $secenek,
                                        'border-line text-ink-muted hover:border-brand hover:text-brand' => $kaynak !== $secenek,
                                    ])>{{ $secenek }}</button>
                                @endforeach
                                <button type="button" wire:click="$set('kaynak', '')" @class([
                                    'rounded-lg border px-3.5 py-1.5 text-xs font-medium transition',
                                    'border-brand bg-brand-light text-brand' => $kaynak === '',
                                    'border-line text-ink-muted hover:border-brand hover:text-brand' => $kaynak !== '',
                                ])>Dizin Yok</button>
                            </div>
                            <flux:text class="mt-2 text-xs text-ink-subtle">Seçilen dizine göre puan otomatik güncellenir</flux:text>
                        </div>
                    @endif

                    <div class="grid gap-4 sm:grid-cols-2">
                        <flux:input wire:model="yil" label="Yayın Yılı" placeholder="2026" inputmode="numeric" maxlength="4" />
                        <flux:select wire:model="donem" label="Dönem" placeholder="Belirtilmemiş">
                            <flux:select.option value="">Belirtilmemiş</flux:select.option>
                            <flux:select.option value="tez_disi">Tez Dışı Bağımsız</flux:select.option>
                            <flux:select.option value="tezden">Tezden Üretilmiş</flux:select.option>
                        </flux:select>
                    </div>

                    <flux:input wire:model="doi" label="DOI Numarası" placeholder="10.xxxx/xxxxx" />

                        <flux:textarea wire:model="aciklama" label="Kısa Açıklama" placeholder="Yayın hakkında kısa bir not ekleyin..." rows="3" />
                    </div>
                </flux:card>

                <div class="flex items-center justify-end gap-3">
                    <flux:button :href="route('yayinlar')" wire:navigate variant="filled">İptal</flux:button>
                    <flux:button type="submit" variant="primary" icon="check">{{ $faaliyet ? 'Güncelle' : 'Yayını Kaydet' }}</flux:button>
                </div>
            </form>
        @endif

        {{-- AVESİS / SCHOLAR — ertelendi --}}
        @if ($sekme === 'avesis' || $sekme === 'scholar')
            <flux:card class="flex flex-col items-center gap-3 py-16 text-center">
                <div class="flex size-12 items-center justify-center rounded-xl bg-brand-light text-brand">
                    <flux:icon :name="$sekme === 'avesis' ? 'arrow-down-tray' : 'magnifying-glass'" class="size-6" />
                </div>
                <flux:heading size="lg">{{ $sekme === 'avesis' ? "AVESİS'ten İçe Aktar" : "Google Scholar'dan Ara" }}</flux:heading>
                <flux:text class="max-w-md">
                    Otomatik içe aktarma entegrasyonu <strong>Faz 4</strong> kapsamında gelecek.
                    Şimdilik yayınlarınızı <strong>Manuel Ekle</strong> sekmesinden ekleyebilirsiniz.
                </flux:text>
                <flux:badge color="amber" size="sm">Yakında</flux:badge>
            </flux:card>
        @endif
    </div>
</div>
