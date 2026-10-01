@props([
    'sekme',
    'egitimler',
    'deneyimler',
    'beceriler',
    'diller',
    'faaliyetler',
    'haricFaaliyetler',
])

@use('App\Models\CvProfili')

{{--
    SOL PANEL — CV'nin içeriği.

    Künye alanları `.blur` ile bağlı, listeler ise eylemlerle değişiyor; her
    ikisi de anında kaydediliyor (bkz. CvOlusturucu::updated). Panel dört
    sekmeye bölündü çünkü tek kolonda alt alta dizilince aday yayın listesine
    inmek için beş ekran kaydırıyordu.
--}}
<flux:card {{ $attributes->class('flex min-h-0 flex-col !p-0') }}>

    <div class="flex shrink-0 border-b border-line">
        @foreach ([
            'kisisel' => 'Kişisel',
            'egitim' => 'Eğitim',
            'faaliyet' => 'Faaliyetler',
            'beceri' => 'Beceri',
        ] as $deger => $etiket)
            <button type="button" wire:click="$set('sekme', '{{ $deger }}')"
                aria-pressed="{{ $sekme === $deger ? 'true' : 'false' }}"
                @class([
                    'flex-1 border-b-2 px-2 py-2.5 text-xs font-medium transition',
                    'border-brand text-brand' => $sekme === $deger,
                    'border-transparent text-ink-subtle hover:text-ink' => $sekme !== $deger,
                ])>{{ $etiket }}</button>
        @endforeach
    </div>

    <div class="min-h-0 flex-1 overflow-y-auto p-4">

        {{-- KİŞİSEL --}}
        @if ($sekme === 'kisisel')
            <div class="flex flex-col gap-3">
                <flux:input wire:model.blur="ad" label="Ad Soyad" size="sm" />
                <flux:input wire:model.blur="unvan" label="Unvan" size="sm" />
                <flux:input wire:model.blur="kurum" label="Kurum" size="sm" />
                <flux:input wire:model.blur="bolum" label="Bölüm / Anabilim Dalı" size="sm" />

                <flux:separator variant="subtle" text="İletişim" />

                <flux:input wire:model.blur="eposta" label="E-posta" size="sm" />
                <div class="grid grid-cols-2 gap-2">
                    <flux:input wire:model.blur="telefon" label="Telefon" size="sm" />
                    <flux:input wire:model.blur="sehir" label="Şehir" size="sm" />
                </div>
                <flux:input wire:model.blur="web" label="ORCID / Web" size="sm" />

                <flux:separator variant="subtle" text="Özet" />

                <flux:textarea wire:model.blur="ozet" label="Kısa biyografi" rows="5" size="sm"
                    placeholder="Araştırma alanlarınızı iki üç cümleyle anlatın." />
            </div>
        @endif

        {{-- EĞİTİM + DENEYİM --}}
        @if ($sekme === 'egitim')
            <div class="flex flex-col gap-5">
                <div>
                    <div class="mb-2 flex items-center justify-between">
                        <flux:heading size="sm">Eğitim</flux:heading>
                        <flux:button wire:click="egitimEkle" size="xs" variant="subtle" icon="plus">Ekle</flux:button>
                    </div>

                    @forelse ($egitimler as $sira => $egitim)
                        <div class="mb-2 rounded-xl border border-line p-3" wire:key="egitim-{{ $sira }}">
                            <div class="mb-2 flex items-center justify-between">
                                <span class="text-[11px] font-medium text-ink-subtle">#{{ $sira + 1 }}</span>
                                <flux:button wire:click="egitimSil({{ $sira }})" size="xs" variant="subtle"
                                    icon="x-mark" aria-label="Eğitim satırını sil" />
                            </div>
                            <div class="flex flex-col gap-2">
                                <flux:input wire:model.blur="egitimler.{{ $sira }}.derece" placeholder="Derece (Doktora)" size="sm" />
                                <flux:input wire:model.blur="egitimler.{{ $sira }}.universite" placeholder="Üniversite" size="sm" />
                                <flux:input wire:model.blur="egitimler.{{ $sira }}.bolum" placeholder="Bölüm" size="sm" />
                                <div class="grid grid-cols-2 gap-2">
                                    <flux:input wire:model.blur="egitimler.{{ $sira }}.baslangic" placeholder="Başlangıç" size="sm" />
                                    <flux:input wire:model.blur="egitimler.{{ $sira }}.bitis" placeholder="Bitiş" size="sm" />
                                </div>
                            </div>
                        </div>
                    @empty
                        <flux:text class="!text-xs">Henüz eğitim satırı yok.</flux:text>
                    @endforelse
                </div>

                <div>
                    <div class="mb-2 flex items-center justify-between">
                        <flux:heading size="sm">Deneyim</flux:heading>
                        <flux:button wire:click="deneyimEkle" size="xs" variant="subtle" icon="plus">Ekle</flux:button>
                    </div>

                    @forelse ($deneyimler as $sira => $deneyim)
                        <div class="mb-2 rounded-xl border border-line p-3" wire:key="deneyim-{{ $sira }}">
                            <div class="mb-2 flex items-center justify-between">
                                <span class="text-[11px] font-medium text-ink-subtle">#{{ $sira + 1 }}</span>
                                <flux:button wire:click="deneyimSil({{ $sira }})" size="xs" variant="subtle"
                                    icon="x-mark" aria-label="Deneyim satırını sil" />
                            </div>
                            <div class="flex flex-col gap-2">
                                <flux:input wire:model.blur="deneyimler.{{ $sira }}.pozisyon" placeholder="Pozisyon" size="sm" />
                                <flux:input wire:model.blur="deneyimler.{{ $sira }}.kurum" placeholder="Kurum" size="sm" />
                                <div class="grid grid-cols-2 gap-2">
                                    <flux:input wire:model.blur="deneyimler.{{ $sira }}.baslangic" placeholder="Başlangıç" size="sm" />
                                    <flux:input wire:model.blur="deneyimler.{{ $sira }}.bitis" placeholder="Bitiş (boşsa devam)" size="sm" />
                                </div>
                            </div>
                        </div>
                    @empty
                        <flux:text class="!text-xs">Henüz deneyim satırı yok.</flux:text>
                    @endforelse
                </div>
            </div>
        @endif

        {{-- FAALİYETLER --}}
        @if ($sekme === 'faaliyet')
            <div class="flex flex-col gap-3">
                <div class="flex items-start gap-2 rounded-xl border border-cat-green/20 bg-cat-green-light p-3">
                    <flux:icon name="check-circle" class="mt-px size-4 shrink-0 text-cat-green" />
                    <flux:text class="!text-[11px] leading-relaxed">
                        <strong>{{ $faaliyetler->count() }} onaylı kayıt</strong> faaliyetlerinizden otomatik geldi.
                        Çıkardığınız kayıt yalnızca CV'den düşer — faaliyet listenizden ve puanınızdan silinmez.
                    </flux:text>
                </div>

                @forelse ($faaliyetler as $faaliyet)
                    @php $haric = in_array($faaliyet->id, $haricFaaliyetler, true); @endphp
                    <div @class([
                        'flex items-start gap-2 rounded-xl border p-3 transition',
                        'border-line' => ! $haric,
                        'border-dashed border-line-strong opacity-60' => $haric,
                    ]) wire:key="faaliyet-{{ $faaliyet->id }}">
                        <div class="min-w-0 flex-1">
                            <div class="text-xs font-medium text-ink">{{ $faaliyet->baslik }}</div>
                            <div class="mt-0.5 text-[11px] text-ink-subtle">
                                {{ collect([
                                    $faaliyet->kategori->label(),
                                    $faaliyet->kaynak,
                                    $faaliyet->tarih?->format('Y'),
                                    $faaliyet->puan.' pt',
                                ])->filter()->implode(' · ') }}
                            </div>
                        </div>
                        <flux:button wire:click="faaliyetDegistir({{ $faaliyet->id }})" size="xs" variant="subtle"
                            :icon="$haric ? 'plus' : 'x-mark'"
                            :aria-label="$haric ? 'CV\'ye geri ekle' : 'CV\'den çıkar'" />
                    </div>
                @empty
                    <flux:text class="!text-xs">
                        Onaylı faaliyetiniz yok. Faaliyetler bölümünden ekledikleriniz onaylandığında burada belirir.
                    </flux:text>
                @endforelse
            </div>
        @endif

        {{-- BECERİ + DİL --}}
        @if ($sekme === 'beceri')
            <div class="flex flex-col gap-5">
                <div>
                    <flux:heading size="sm" class="!mb-2">Uzmanlık Alanları</flux:heading>

                    @if ($beceriler !== [])
                        <div class="mb-2 flex flex-wrap gap-1.5">
                            @foreach ($beceriler as $sira => $beceri)
                                <span class="inline-flex items-center gap-1 rounded-full border border-line bg-canvas px-2.5 py-1 text-[11px] text-ink-muted"
                                    wire:key="beceri-{{ $sira }}">
                                    {{ $beceri }}
                                    <button type="button" wire:click="beceriSil({{ $sira }})"
                                        class="text-ink-subtle transition hover:text-cat-red"
                                        aria-label="{{ $beceri }} becerisini sil">
                                        <flux:icon name="x-mark" class="size-3" />
                                    </button>
                                </span>
                            @endforeach
                        </div>
                    @endif

                    <div class="flex gap-2">
                        <flux:input wire:model="yeniBeceri" wire:keydown.enter="beceriEkle"
                            placeholder="Beceri ekle..." size="sm" class="flex-1" />
                        <flux:button wire:click="beceriEkle" size="sm" variant="subtle">Ekle</flux:button>
                    </div>
                </div>

                <div>
                    <flux:heading size="sm" class="!mb-2">Diller</flux:heading>

                    @foreach ($diller as $sira => $dil)
                        <div class="mb-2 flex items-center gap-2" wire:key="dil-{{ $sira }}">
                            <span class="w-20 shrink-0 truncate text-xs text-ink">{{ $dil['ad'] }}</span>

                            {{-- Seviye noktaları: 1-5. Serbest metin yerine nokta,
                                 çünkü CV'deki çubuk da bu sayıdan çiziliyor. --}}
                            <div class="flex gap-1">
                                @for ($seviye = 1; $seviye <= 5; $seviye++)
                                    <button type="button" wire:click="dilSeviye({{ $sira }}, {{ $seviye }})"
                                        aria-label="{{ $dil['ad'] }} seviyesi {{ $seviye }}"
                                        @class([
                                            'size-3.5 rounded-full border transition',
                                            'border-brand bg-brand' => $seviye <= $dil['seviye'],
                                            'border-line-strong' => $seviye > $dil['seviye'],
                                        ])></button>
                                @endfor
                            </div>

                            <span class="flex-1 truncate text-[10px] text-ink-subtle">
                                {{ CvProfili::DIL_SEVIYELERI[$dil['seviye']] ?? '' }}
                            </span>

                            <flux:button wire:click="dilSil({{ $sira }})" size="xs" variant="subtle"
                                icon="x-mark" aria-label="{{ $dil['ad'] }} dilini sil" />
                        </div>
                    @endforeach

                    <div class="mt-2 flex gap-2">
                        <flux:input wire:model="yeniDil" wire:keydown.enter="dilEkle"
                            placeholder="Dil ekle..." size="sm" class="flex-1" />
                        <flux:button wire:click="dilEkle" size="sm" variant="subtle">Ekle</flux:button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</flux:card>
