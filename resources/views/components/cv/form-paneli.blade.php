@props([
    'sekme',
    'egitimler',
    'deneyimler',
    'beceriler',
    'diller',
    'faaliyetler',
    'haricFaaliyetler',
    'foto',
    'unvan',
])

@use('App\Models\CvProfili')

{{--
    SOL PANEL — CV'nin içeriği.

    Künye alanları `.live.blur` ile bağlı (Livewire 4.1+'da yalnız `.blur`
    sunucuya istek GÖNDERMİYOR, değer bir sonraki eyleme kadar tarayıcıda
    bekliyordu), listeler ise eylemlerle değişiyor; her
    ikisi de anında kaydediliyor (bkz. CvOlusturucu::updated). Alttaki Kaydet
    düğmesi bunu teyit ediyor. Panel dört
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
                    'flex-1 border-b-2 px-3 py-3.5 text-sm font-medium transition',
                    'border-brand text-brand' => $sekme === $deger,
                    'border-transparent text-ink-subtle hover:text-ink' => $sekme !== $deger,
                ])>{{ $etiket }}</button>
        @endforeach
    </div>

    <div class="min-h-0 flex-1 overflow-y-auto p-4">

        {{-- KİŞİSEL --}}
        @if ($sekme === 'kisisel')
            <div class="flex flex-col gap-3">
                {{-- Fotoğraf seçilir seçilmez saklanıyor (CvOlusturucu::updatedYeniFoto);
                     yoksa CV'de baş harfler duruyor. --}}
                <div class="flex items-center gap-3">
                    @if ($foto)
                        <img src="{{ $foto }}" alt="CV fotoğrafı" class="size-14 shrink-0 rounded-full object-cover">
                    @else
                        <div class="flex size-14 shrink-0 items-center justify-center rounded-full bg-canvas text-ink-subtle">
                            <flux:icon.user class="size-6" />
                        </div>
                    @endif

                    <div class="flex min-w-0 flex-col gap-1">
                        <div class="flex items-center gap-2">
                            <label class="cursor-pointer">
                                <input type="file" wire:model="yeniFoto" accept="image/jpeg,image/png,image/webp" class="sr-only">
                                <span class="inline-flex items-center rounded-md border border-line px-2.5 py-1 text-xs font-medium text-ink transition hover:bg-canvas">
                                    {{ $foto ? 'Fotoğrafı değiştir' : 'Fotoğraf yükle' }}
                                </span>
                            </label>
                            @if ($foto)
                                <flux:button wire:click="fotoKaldir" size="sm" variant="ghost">Kaldır</flux:button>
                            @endif
                        </div>
                        <span wire:loading wire:target="yeniFoto" class="text-xs text-ink-subtle">Yükleniyor…</span>
                        <span wire:loading.remove wire:target="yeniFoto" class="text-xs text-ink-subtle">JPG, PNG veya WebP · en fazla 10 MB</span>
                        @error('yeniFoto') <span class="text-xs text-cat-red">{{ $message }}</span> @enderror
                    </div>
                </div>

                <flux:input wire:model.live.blur="ad" label="Ad Soyad" />
                {{-- Unvan kapalı listeden. Listede olmayan eski bir değer (elle
                     yazıldığı dönemden) seçenek olarak kalıyor: yoksa tarayıcı ilk
                     seçeneği seçili gösterir, aday unvanını değişmiş sanırdı. --}}
                {{-- Listede olmayan kayıtlı unvan (eski veri) da seçenek olarak kalır. --}}
                <x-secim-listesi model="unvan" canli label="Unvan"
                    :secenekler="['' => 'Belirtilmemiş'] + array_combine(\App\Models\User::UNVANLAR, \App\Models\User::UNVANLAR) + ($unvan !== '' ? [$unvan => $unvan] : [])" />
                <flux:input wire:model.live.blur="kurum" label="Kurum" />
                <flux:input wire:model.live.blur="bolum" label="Bölüm / Anabilim Dalı" />

                <flux:separator variant="subtle" text="İletişim" />

                <flux:input wire:model.live.blur="eposta" label="E-posta" />
                {{-- Maske "0" ile başlıyor, "05" ile değil: ofis numarası (0324 …)
                     da girilebilsin ve kayıtlı sabit hat numarası maskeye
                     zorlanırken bozulmasın. Cep numarası yine 05xx biçiminde çıkar. --}}
                <flux:input wire:model.live.blur="telefon" label="Telefon" mask="0999 999 99 99"
                    placeholder="05xx xxx xx xx" inputmode="tel" />
                {{-- Alan adı `sehir` kaldı (veritabanı sütunu); ekranda adres soruluyor. --}}
                <flux:input wire:model.live.blur="sehir" label="Adres" placeholder="Örn. Mersin Üniversitesi Çiftlikköy Kampüsü, Yenişehir / Mersin" />
                {{-- Son hane rakam ya da X olabildiği için `*`; doğrusunu sunucu
                     (kontrol hanesiyle) sınar. Yapıştırılan orcid.org adresinden
                     maske kimliğin rakamlarını süzüyor. --}}
                <flux:input wire:model.live.blur="orcid" label="ORCID"
                    mask="9999-9999-9999-999*" placeholder="0000-0000-0000-0000" />

                <flux:separator variant="subtle" text="Özet" />

                <flux:textarea wire:model.live.blur="ozet" label="Kısa biyografi" rows="5"
                    placeholder="Araştırma alanlarınızı iki üç cümleyle anlatın." />
            </div>
        @endif

        {{-- EĞİTİM + DENEYİM --}}
        @if ($sekme === 'egitim')
            <div class="flex flex-col gap-5">
                <div>
                    <div class="mb-2 flex items-center justify-between">
                        <flux:heading size="sm">Eğitim</flux:heading>
                        <flux:button wire:click="egitimEkle" size="sm" variant="subtle" icon="plus">Ekle</flux:button>
                    </div>

                    @forelse ($egitimler as $sira => $egitim)
                        <div class="mb-2 rounded-xl border border-line p-3" wire:key="egitim-{{ $sira }}">
                            <div class="mb-2 flex items-center justify-between">
                                <span class="text-xs font-medium text-ink-subtle">#{{ $sira + 1 }}</span>
                                <flux:button wire:click="egitimSil({{ $sira }})" size="sm" variant="subtle"
                                    icon="x-mark" aria-label="Eğitim satırını sil" />
                            </div>
                            <div class="flex flex-col gap-2">
                                <flux:input wire:model.live.blur="egitimler.{{ $sira }}.derece" placeholder="Derece (Doktora)" />
                                <flux:input wire:model.live.blur="egitimler.{{ $sira }}.universite" placeholder="Üniversite" />
                                <flux:input wire:model.live.blur="egitimler.{{ $sira }}.bolum" placeholder="Bölüm" />
                                <div class="grid grid-cols-2 gap-2">
                                    <flux:input wire:model.live.blur="egitimler.{{ $sira }}.baslangic" placeholder="Başlangıç" />
                                    <flux:input wire:model.live.blur="egitimler.{{ $sira }}.bitis" placeholder="Bitiş" />
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
                        <flux:button wire:click="deneyimEkle" size="sm" variant="subtle" icon="plus">Ekle</flux:button>
                    </div>

                    @forelse ($deneyimler as $sira => $deneyim)
                        <div class="mb-2 rounded-xl border border-line p-3" wire:key="deneyim-{{ $sira }}">
                            <div class="mb-2 flex items-center justify-between">
                                <span class="text-xs font-medium text-ink-subtle">#{{ $sira + 1 }}</span>
                                <flux:button wire:click="deneyimSil({{ $sira }})" size="sm" variant="subtle"
                                    icon="x-mark" aria-label="Deneyim satırını sil" />
                            </div>
                            <div class="flex flex-col gap-2">
                                <flux:input wire:model.live.blur="deneyimler.{{ $sira }}.pozisyon" placeholder="Pozisyon" />
                                <flux:input wire:model.live.blur="deneyimler.{{ $sira }}.kurum" placeholder="Kurum" />
                                <div class="grid grid-cols-2 gap-2">
                                    <flux:input wire:model.live.blur="deneyimler.{{ $sira }}.baslangic" placeholder="Başlangıç" />
                                    <flux:input wire:model.live.blur="deneyimler.{{ $sira }}.bitis" placeholder="Bitiş (boşsa devam)" />
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
                    <flux:text class="!text-xs leading-relaxed">
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
                            <div class="mt-0.5 text-xs text-ink-subtle">
                                {{ collect([
                                    $faaliyet->kategori->label(),
                                    $faaliyet->kaynak,
                                    $faaliyet->tarih?->format('Y'),
                                    $faaliyet->puan.' pt',
                                ])->filter()->implode(' · ') }}
                            </div>
                        </div>
                        <flux:button wire:click="faaliyetDegistir({{ $faaliyet->id }})" size="sm" variant="subtle"
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
                                <span class="inline-flex items-center gap-1 rounded-full border border-line bg-canvas px-2.5 py-1 text-xs text-ink-muted"
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
                            placeholder="Beceri ekle..." class="flex-1" />
                        <flux:button wire:click="beceriEkle" variant="subtle">Ekle</flux:button>
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

                            <span class="flex-1 truncate text-2xs text-ink-subtle">
                                {{ CvProfili::DIL_SEVIYELERI[$dil['seviye']] ?? '' }}
                            </span>

                            <flux:button wire:click="dilSil({{ $sira }})" size="sm" variant="subtle"
                                icon="x-mark" aria-label="{{ $dil['ad'] }} dilini sil" />
                        </div>
                    @endforeach

                    <div class="mt-2 flex gap-2">
                        <flux:input wire:model="yeniDil" wire:keydown.enter="dilEkle"
                            placeholder="Dil ekle..." class="flex-1" />
                        <flux:button wire:click="dilEkle" variant="subtle">Ekle</flux:button>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Kayıt zaten otomatik; düğme bunu görünür kılıyor. Aday Kaydet
         düğmesi aramış, bulamayınca değişikliklerinin saklanmadığını sanmıştı. --}}
    <div class="flex shrink-0 justify-end border-t border-line px-4 py-3">
        <flux:button wire:click="kaydetVeBildir" variant="primary" icon="check">Kaydet</flux:button>
    </div>
</flux:card>
