<div class="relative">

    {{-- Kapatma sayfa düzeyinde: kartın içinde değil, içerik alanının sağ üst
         köşesinde durur ve üç sekmenin hepsinde geçerlidir. --}}
    <a href="{{ route('faaliyetler') }}" wire:navigate aria-label="Kapat" title="Kapat"
        class="absolute right-0 top-0 z-10 flex size-9 items-center justify-center rounded-lg text-ink transition hover:text-cat-red">
        <flux:icon name="x-mark" variant="solid" class="size-6" />
    </a>

    <div class="mx-auto flex max-w-3xl flex-col gap-5">

        {{-- Sekme navigasyonu — yalnız YENİ kayıtta. Düzenlerken sekme
             değiştirmek formdaki değişikliği sessizce çöpe atıyordu. --}}
        @unless ($faaliyet)
        {{-- Telefonda tam genişlikte üç eşit sütun ve kapatma düğmesinin
             altında; geniş ekranda ortalanmış hap. --}}
        <div class="mt-11 grid w-full grid-cols-3 gap-1 rounded-2xl border border-line bg-surface p-1 sm:mx-auto sm:mt-0 sm:flex sm:w-auto sm:gap-0 sm:rounded-full">
            @foreach (['manuel' => ['Manuel Ekle', 'Manuel'], 'yayin' => ['Yayınlarımı Bul', 'Yayın Bul'], 'avesis' => ['Kurum Profilimden Çek', 'Kurum Profili']] as $anahtar => [$etiket, $kisaEtiket])
                <button type="button" wire:click="$set('sekme', '{{ $anahtar }}')" @class([
                    'rounded-xl px-2 py-2 text-center text-[13px] leading-tight font-medium transition sm:rounded-full sm:px-5 sm:text-sm sm:leading-normal',
                    'bg-navy text-white' => $sekme === $anahtar,
                    'text-ink-muted hover:text-ink' => $sekme !== $anahtar,
                ])><span class="sm:hidden">{{ $kisaEtiket }}</span><span class="hidden sm:inline">{{ $etiket }}</span></button>
            @endforeach
        </div>
        @endunless

        {{-- MANUEL --}}
        @if ($sekme === 'manuel')
            <form wire:submit="kaydet" class="flex flex-col gap-5">
                <flux:card class="overflow-hidden !p-0">
                    {{-- Başlık (03_yayin_ekleme.html modal-header stili) --}}
                    <div class="border-b border-line px-6 py-5">
                        <flux:heading size="lg">{{ $faaliyet ? 'Faaliyeti Düzenle' : 'Faaliyet Ekle' }}</flux:heading>
                        <flux:text class="mt-1">Bilgileri doldurun, puan otomatik hesaplanır</flux:text>
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
                                    {{-- Renk tek kaynaktan: Kategori::renk(). Dashboard'daki
                                         "Kategori Puan Dağılımı" da aynı token'ı kullanıyor. --}}
                                    <span class="flex size-8 items-center justify-center rounded-lg"
                                        style="background: color-mix(in srgb, var(--color-{{ $k->renk() }}) 14%, white); color: var(--color-{{ $k->renk() }})">
                                        <x-kategori-icon :kategori="$k" class="size-4" />
                                    </span>
                                    <span @class(['text-xs font-medium', 'text-brand' => $secili, 'text-ink-muted' => ! $secili])>{{ $k->label() }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Canlı puan önizleme: kullanıcının KENDİ üniversitesinin
                         cetveline göre. Cetvel yoksa puan gösterilmez. --}}
                    @php $onizleme = $this->tahminiPuan(); @endphp
                    <div class="flex items-center justify-between rounded-xl bg-navy px-5 py-4">
                        <div>
                            <div class="text-2xs font-semibold uppercase tracking-wide text-white/40">
                                {{ $onizleme === null ? 'Puan Önizlemesi' : auth()->user()->universite.' cetveline göre' }}
                            </div>
                            <div class="flex items-baseline gap-2">
                                @if ($onizleme === null)
                                    <span class="text-sm text-white/60">Üniversitenizin yönergesi henüz girilmedi</span>
                                @else
                                    <span class="font-serif text-3xl font-bold text-gold">{{ $onizleme }}</span>
                                    <span class="text-sm text-white/50">pt</span>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-medium text-white">{{ \App\Enums\Kategori::from($kategori)->label() }}</div>
                            <div class="mt-1 text-xs text-white/50">{{ $kaynak ?: 'Dizin seçilmedi' }}</div>
                        </div>
                    </div>

                    <flux:input wire:model="baslik" label="Başlık" badge="Zorunlu" placeholder="Faaliyetin tam başlığını girin..." />

                    @php
                        $kat = \App\Enums\Kategori::from($kategori);
                        $roller = $this->rolSecenekleri();
                        $yayinTurleri = $this->yayinTuruSecenekleri();
                        // Yazar listesi yalnızca yayın türlerinde anlamlı; proje,
                        // tez danışmanlığı, atıf gibi kategorilerde gösterilmez.
                        // Kategorinin TAM rol listesine bakılıyor: $roller girilen
                        // yazar sayısına göre süzülüyor ve iki yazar girilince
                        // 'tek' düşüyor — süzülmüş listeye bakmak yazar alanını
                        // kullanıcının gözü önünde yok ederdi.
                        $yazarliMi = isset($kat->roller()['tek']);
                    @endphp

                    {{--
                        Yayın türü: yönergeler aynı dergideki özgün makale ile
                        derlemeyi farklı puanlıyor (Ege Q1: 75 ↔ 60). Yalnızca
                        makale ve tezden üretilmiş yayında sorulur.
                    --}}
                    @if ($yayinTurleri !== [])
                        <x-secim-listesi model="yayinTuru" canli label="Yayın Türü" :secenekler="$yayinTurleri" />
                    @endif

                    {{-- Yazarlar (03_yayin_ekleme.html: çoklu yazar listesi) --}}
                    <div @class(['hidden' => ! $yazarliMi])>
                        <flux:text class="mb-2 text-sm font-medium text-ink-muted">Yazarlar</flux:text>
                        <div class="flex flex-col gap-2">
                            @foreach ($yazarlar as $i => $yazar)
                                <div class="flex items-center gap-2" wire:key="yazar-{{ $i }}">
                                    <div class="flex size-6 shrink-0 items-center justify-center rounded-full bg-brand-light text-2xs font-semibold text-brand">{{ $i + 1 }}</div>
                                    {{-- .live.blur: rol seçenekleri sunucuda yazar SAYISINDAN hesaplanıyor.
                                         Düz wire:model (Livewire 4) adı başka bir istek gidene
                                         kadar tarayıcıda tuttuğu için rol listesi eski sayıyla
                                         çiziliyordu: bazen tüm roller, bazen yalnız "Tek yazar". --}}
                                    <flux:input wire:model.live.blur="yazarlar.{{ $i }}" placeholder="Yazar adı..." class="flex-1" />
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

                    {{-- Rol: yayında yazarlık, projede görev, tezde danışmanlık --}}
                    @if (count($roller))
                        <x-secim-listesi model="rol"
                            :label="$yazarliMi ? 'Yazarlık rolünüz' : 'Bu faaliyetteki rolünüz'"
                            :description="$yazarliMi
                                ? 'Yönerge alt-koşullarında başlıca/tek yazarlık ayrıca değerlendirilir.'
                                : 'Yönergeler proje ve tez danışmanlığı koşullarını role göre ayırıyor.'"
                            :secenekler="['' => 'Seçiniz'] + $roller" />
                    @endif

                    {{-- İndeks önerisi: yalnız DÜZENLEMEDE ve kademe boşken.
                         İçe aktarılan kayıt kaynaksız iniyor, adayın
                         dolduracağı tek alan bu. --}}
                    @if ($faaliyet && $kaynak === '' && count($this->kaynakSecenekleri()))
                        <div wire:init="kaynakOner">
                            <div wire:loading wire:target="kaynakOner" class="flex items-center gap-2 rounded-xl border border-line bg-canvas p-3">
                                <flux:icon name="arrow-path" class="size-4 animate-spin text-ink-subtle" />
                                <flux:text class="!text-xs">Derginin indeks bilgisi aranıyor…</flux:text>
                            </div>

                            @if ($oneri)
                                <x-yayin.indeks-onerisi :oneri="$oneri" />
                            @endif
                        </div>
                    @endif

                    {{-- Alt tür chip'leri --}}
                    @if (count($this->kaynakSecenekleri()))
                        <div>
                            <flux:text class="mb-2 text-sm font-medium text-ink-muted">
                                {{ in_array($kat, \App\Enums\Kategori::yayinlar(), true) ? 'Dizin / Endeks' : 'Alt Tür' }}
                            </flux:text>
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
                                ])>Belirtilmemiş</button>
                            </div>
                            <flux:text class="mt-2 text-xs text-ink-subtle">Seçilen alt türe göre puan otomatik güncellenir</flux:text>
                        </div>
                    @endif

    @php($tezIliskisi = $this->tezIliskisiSorulur())

                    <div @class(['grid gap-4', 'sm:grid-cols-2' => $tezIliskisi])>
                        {{-- Tam tarih: dönem koşulları ("doçentlik sonrası", "son 5 yıl")
                             profildeki dönüm tarihleriyle kıyaslanıyor. --}}
                        <flux:input wire:model="tarih" type="date" label="Faaliyet Tarihi" max="{{ now()->format('Y-m-d') }}" />

                        {{-- Yalnızca yayın türlerinde sorulur: bir makale tezden
                             üretilmiş olabilir, bir tez danışmanlığı olamaz —
                             orada tezin düzeyi zaten alt tür alanında seçiliyor.

                             Düzey ayrı soruluyor çünkü yönergeler farklı şey
                             istiyor: Sabancı "doktora tezinden üretilmemiş",
                             ÜAK "lisansüstü tezlerden üretilmiş". Yüksek lisans
                             tezinden üretilen yayın birincisine sayılır. --}}
                        @if ($tezIliskisi)
                            <x-secim-listesi model="donem" label="Tez İlişkisi" placeholder="Belirtilmemiş"
                                :secenekler="['' => 'Belirtilmemiş'] + \App\Models\Faaliyet::tezIliskileri() + ($donem === 'tezden' ? ['tezden' => 'Tezden üretilmiş (düzey belirtilmemiş)'] : [])" />
                        @endif
                    </div>

                    <flux:input wire:model="doi" label="DOI Numarası" placeholder="10.xxxx/xxxxx" />

                        <flux:textarea wire:model="aciklama" label="Kısa Açıklama" placeholder="Faaliyet hakkında kısa bir not ekleyin..." rows="3" />

                    {{-- Yalnız düzenlemede: yeni kayıt onaylı başlıyor, içe
                         aktarılan kayıt beklemede iniyor ve aday onu burada onaylıyor. --}}
                    @if ($faaliyet)
                        <x-secim-listesi model="durum" label="Durum"
                            description="Beklemedeki faaliyetler puanlamaya, yönerge analizine ve CV'ye katılmaz."
                            :secenekler="\App\Models\Faaliyet::durumlar()" />
                    @endif
                    </div>
                </flux:card>

                <div class="flex items-center justify-end gap-3">
                    <flux:button :href="route('faaliyetler')" wire:navigate variant="filled">İptal</flux:button>
                    <flux:button type="submit" variant="primary" icon="check">{{ $faaliyet ? 'Güncelle' : 'Faaliyeti Kaydet' }}</flux:button>
                </div>
            </form>
        @endif

        {{-- YAYINLARIMI BUL --}}
        @if ($sekme === 'yayin' && ! $faaliyet)
            <div class="flex flex-col gap-4">

                <flux:card class="overflow-hidden !p-0">
                    <div class="border-b border-line px-6 py-5">
                        <flux:heading size="lg">Yayınlarımı Bul</flux:heading>
                        <flux:text class="mt-1">
                            DOI'si olan yayınlarınız künye veritabanından (Crossref) gelir —
                            DergiPark dergileri dâhil. Bulunanları seçip listenize eklersiniz.
                        </flux:text>
                    </div>

                    <form wire:submit="yayinAra" class="flex flex-col gap-4 px-6 py-5">
                        <div class="grid gap-4 sm:grid-cols-2">
                            <flux:input wire:model="aramaAdi" label="Ad Soyad"
                                placeholder="Künyelerde geçtiği hâliyle" />
                            <flux:input wire:model="aramaOrcid" label="ORCID (varsa)"
                                placeholder="0000-0000-0000-0000" />
                        </div>

                        {{-- İki sorgunun iki ayrı zayıflığı var; aday hangisinin
                             ne verdiğini bilirse sonucu doğru okur. --}}
                        <flux:text class="!text-xs text-ink-subtle">
                            ORCID girerseniz o yayınlar <strong>kesin</strong> sizindir ama yayıncı
                            ORCID'inizi göndermediyse bazıları eksik kalır. Ad araması geniştir,
                            aynı adı taşıyan başka yazarların yayınları da gelebilir — işaretlemeden
                            önce kontrol edin.
                        </flux:text>

                        <div>
                            <flux:button type="submit" variant="primary" icon="magnifying-glass">
                                <span wire:loading.remove wire:target="yayinAra">Ara</span>
                                <span wire:loading wire:target="yayinAra">Aranıyor…</span>
                            </flux:button>
                        </div>
                    </form>
                </flux:card>

                <x-iskelet-liste wire:loading.flex wire:target="yayinAra" class="hidden" />

                @if ($aramaHatasi)
                    <flux:callout variant="danger" icon="exclamation-triangle" heading="{{ $aramaHatasi }}" />
                @elseif ($arandi && $bulunanlar === [])
                    <flux:card class="flex flex-col items-center gap-2 py-12 text-center">
                        <flux:icon name="magnifying-glass" class="size-8 text-ink-subtle" />
                        <flux:heading size="lg">Yayın bulunamadı</flux:heading>
                        <flux:text class="max-w-md">
                            Adı künyelerde geçtiği gibi yazmayı deneyin. DOI'si olmayan yayınlar bu
                            aramada görünmez; onları <strong>Manuel Ekle</strong> sekmesinden girebilirsiniz.
                        </flux:text>
                    </flux:card>
                @elseif ($bulunanlar !== [])
                    <flux:card class="overflow-hidden !p-0">
                        <div class="flex items-center justify-between gap-3 border-b border-line px-4 py-3">
                            <flux:text class="!text-xs">
                                <strong class="text-ink">{{ count($bulunanlar) }} yayın</strong> bulundu
                            </flux:text>
                            <flux:button wire:click="tumunuSec" size="sm" variant="ghost">Tümünü seç</flux:button>
                        </div>

                        <div class="flex max-h-[28rem] flex-col divide-y divide-line overflow-y-auto">
                            @foreach ($bulunanlar as $y)
                                <x-yayin.sonuc-satiri :yayin="$y" wire:key="doi-{{ $y['doi'] }}" />
                            @endforeach
                        </div>
                    </flux:card>

                    {{-- İndeks uyarısı EKLEME DÜĞMESİNİN YANINDA: künyede dergi
                         indeksi yok, puanı belirleyen alan da o. Kayıtlar
                         "beklemede" iniyor ve kademe seçilene kadar hiçbir
                         yönergeye girmiyor. --}}
                    <flux:card class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <flux:text class="!text-xs">
                            Seçilenler <strong class="text-ink">beklemede</strong> eklenir. Dergi indeksi
                            (SCIE, Q2, TR Dizin…) künyede gelmediği için <strong class="text-ink">puanı
                            belirleyen kademeyi siz seçersiniz</strong>; o zamana kadar yönerge analizine girmezler.
                        </flux:text>
                        <flux:button wire:click="yayinlariEkle" variant="primary" icon="plus" class="shrink-0">
                            {{ count($secilenler) }} yayını ekle
                        </flux:button>
                    </flux:card>
                @endif

                <flux:separator variant="subtle" text="ya da" />

                {{-- DOI'Sİ OLMAYAN ESKİ YAYINLAR --}}
                <flux:card class="overflow-hidden !p-0">
                    <div class="border-b border-line px-6 py-5">
                        <flux:heading size="lg">DOI'si olmayan eski makaleler</flux:heading>
                        {{-- Adayın "neden bazı yayınlarım çıkmadı" sorusunun
                             cevabı burada yazılı; yoksa üstteki aramayı bozuk
                             sanıyor.

                             BAŞLIK "makaleler" DİYOR, "yayınlar" DEĞİL: DergiPark
                             bir dergi platformu, kitap ve tez orada yok. Başlık
                             geniş kalınca aday DOI'siz kitabını da burada arayıp
                             yayınevinin adını yazıyordu. --}}
                        <flux:text class="mt-1">
                            Dergiler DOI'ye sonradan geçti ve geriye dönük vermediler — bu yüzden
                            yukarıdaki arama <strong>2014–2019 öncesi</strong> makalelerin çoğunu göremez.
                            Derginizi verin, arşivini soyadınıza göre tarayalım.
                        </flux:text>
                        <flux:text class="mt-2 !text-xs text-ink-subtle">
                            Yalnız <strong>dergi makaleleri</strong> için. Kitap, bildiri ve tezler DergiPark
                            arşivinde yok; onları <strong>Manuel Ekle</strong> sekmesinden ya da
                            <strong>Kurum Profilimden Çek</strong> ile girebilirsiniz.
                        </flux:text>
                    </div>

                    <form wire:submit="arsivTara" class="flex flex-col gap-4 px-6 py-5">
                        <flux:input wire:model="arsivDergi" label="Makalenizin yayımlandığı DergiPark dergisi"
                            placeholder="dergipark.org.tr/tr/pub/politeknik  ·  politeknik" />

                        <div class="grid gap-4 sm:grid-cols-2">
                            <flux:input wire:model="arsivYilBas" type="number" label="Yıl (başlangıç)" placeholder="2002" />
                            <flux:input wire:model="arsivYilSon" type="number" label="Yıl (bitiş)" placeholder="2017" />
                        </div>

                        <flux:text class="!text-xs text-ink-subtle">
                            Yıl aralığı boş bırakılırsa arşivin tamamı taranır; sayılar öbek öbek açılır.
                        </flux:text>

                        <div>
                            <flux:button type="submit" variant="primary" icon="archive-box">
                                <span wire:loading.remove wire:target="arsivTara">Arşivi tara</span>
                                <span wire:loading wire:target="arsivTara">Taranıyor…</span>
                            </flux:button>
                        </div>
                    </form>
                </flux:card>

                <x-iskelet-liste wire:loading.flex wire:target="arsivTara" class="hidden" />

                @if ($arsivHatasi)
                    <flux:callout variant="danger" icon="exclamation-triangle" heading="{{ $arsivHatasi }}" />
                @elseif ($arsivArandi && $arsivKisaltma)
                    <flux:card class="overflow-hidden !p-0">
                        <div class="flex flex-wrap items-center justify-between gap-2 border-b border-line px-4 py-3">
                            <flux:text class="!text-xs">
                                <strong class="text-ink">{{ $arsivAdi }}</strong> ·
                                {{ $arsivTaranan }} sayı tarandı ·
                                <strong class="text-ink">{{ count($arsivBulunanlar) }} yayın</strong> soyadınızla eşleşti
                            </flux:text>

                            @if ($arsivKalan)
                                <flux:button wire:click="arsivDevam" size="sm" variant="filled">
                                    <span wire:loading.remove wire:target="arsivDevam">{{ count($arsivKalan) }} sayı daha var — devam et</span>
                                    <span wire:loading wire:target="arsivDevam">Taranıyor…</span>
                                </flux:button>
                            @endif
                        </div>

                        @if ($arsivBulunanlar)
                            <div class="flex max-h-[28rem] flex-col divide-y divide-line overflow-y-auto">
                                @foreach ($arsivBulunanlar as $y)
                                    <x-yayin.arsiv-satiri :yayin="$y" wire:key="ars-{{ $y['anahtar'] }}" />
                                @endforeach
                            </div>
                        @else
                            <div class="px-4 py-8 text-center">
                                <flux:text class="!text-xs">
                                    Taranan sayılarda soyadınıza rastlanmadı.
                                    @if ($arsivKalan) Kalan sayılar için “devam et” deyin. @endif
                                </flux:text>
                            </div>
                        @endif
                    </flux:card>

                    @if ($arsivBulunanlar)
                        <flux:card class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <flux:text class="!text-xs">
                                Seçilenler <strong class="text-ink">beklemede</strong> eklenir; tarihleri sayının
                                yayım tarihinden gelir. Kademeyi yine siz seçersiniz.
                            </flux:text>
                            <flux:button wire:click="arsivdenEkle" variant="primary" icon="plus" class="shrink-0">
                                {{ count($arsivSecilenler) }} yayını ekle
                            </flux:button>
                        </flux:card>
                    @endif
                @endif
            </div>
        @endif

        {{-- AVESİS --}}
        @if ($sekme === 'avesis' && ! $faaliyet)
            <div class="flex flex-col gap-4">

                <flux:card class="overflow-hidden !p-0">
                    <div class="border-b border-line px-6 py-5">
                        <flux:heading size="lg">Kurum Profilimden Çek</flux:heading>
                        {{-- Kurumsal profilin diğer iki yoldan farkı: yayın
                             dışına çıkabiliyor ve dergi indeksini de
                             taşıyor. --}}
                        <flux:text class="mt-1">
                            Üniversitenizin akademik künye sistemi (<strong>AVESİS</strong> ya da Mersin'de
                            <strong>APBS</strong>) sizin tuttuğunuz künye: yayınların yanında
                            <strong>projeleri</strong> de veriyor ve derginin indeksini (ESCI, TR Dizin…)
                            yazdığı için <strong>kademe çoğu kayıtta hazır gelir</strong>.
                        </flux:text>
                    </div>

                    <form wire:submit="avesisGetir" class="flex flex-col gap-4 px-6 py-5">
                        <flux:input wire:model="avesisAdres" label="Kurumsal profil adresiniz"
                            placeholder="https://avesis.ktu.edu.tr/kullaniciadi" />

                        <flux:text class="!text-xs text-ink-subtle">
                            Her üniversitede ayrı kurulu — kendi üniversitenizin adresini verin
                            (<span class="font-mono">avesis.…edu.tr/kullaniciadi</span> ya da
                            <span class="font-mono">apbs.mersin.edu.tr/profiles/000000</span>).
                            Adres profilinize kaydedilir, bir daha yazmanız gerekmez.
                        </flux:text>

                        <div>
                            <flux:button type="submit" variant="primary" icon="arrow-down-tray">
                                <span wire:loading.remove wire:target="avesisGetir">Profili oku</span>
                                <span wire:loading wire:target="avesisGetir">Okunuyor…</span>
                            </flux:button>
                        </div>
                    </form>
                </flux:card>

                <x-iskelet-liste wire:loading.flex wire:target="avesisGetir" class="hidden" />

                @if ($avesisHatasi)
                    <flux:callout variant="danger" icon="exclamation-triangle" heading="{{ $avesisHatasi }}" />
                @elseif ($avesisBulunanlar !== [])
                    <flux:card class="overflow-hidden !p-0">
                        <div class="flex items-center justify-between gap-3 border-b border-line px-4 py-3">
                            <flux:text class="!text-xs">
                                <strong class="text-ink">{{ count($avesisBulunanlar) }} kayıt</strong> okundu
                                {{-- Atlananı söylemek şart: aday "eksik geldi"
                                     sanıp elle aramaya kalkmasın. --}}
                                @if ($avesisAtlanan)
                                    · <span class="text-ink-subtle">{{ $avesisAtlanan }} kayıt eşlenemedi (sözlükte karşılığı yok)</span>
                                @endif
                                {{-- Liste eksikse aday bunu bilmeli: gördüğü
                                     kadarını profilinin tamamı sanmasın. --}}
                                @if ($avesisEksikBolum)
                                    · <span class="text-cat-amber-text">{{ $avesisEksikBolum }} bölüm okunamadı, listeniz eksik olabilir — birazdan yeniden deneyin</span>
                                @endif
                            </flux:text>
                            <flux:button wire:click="avesisTumunuSec" size="sm" variant="ghost">Tümünü seç</flux:button>
                        </div>

                        <div class="flex max-h-[32rem] flex-col divide-y divide-line overflow-y-auto">
                            @foreach ($avesisBulunanlar as $k)
                                <x-yayin.avesis-satiri :kayit="$k" wire:key="av-{{ $k['id'] }}" />
                            @endforeach
                        </div>
                    </flux:card>

                    <flux:card class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <flux:text class="!text-xs">
                            Kademesi okunabilen kayıtlar <strong class="text-ink">dolu</strong> gelir;
                            çeyrekliği (Q1–Q4) {{ $avesisSistemAdi }} yazmıyorsa o kayıtlar boş kalır.
                            Hepsi <strong class="text-ink">beklemede</strong> iner, onay sizde.
                        </flux:text>
                        <flux:button wire:click="avesistenEkle" variant="primary" icon="plus" class="shrink-0">
                            {{ count($avesisSecilenler) }} kaydı ekle
                        </flux:button>
                    </flux:card>
                @endif
            </div>
        @endif
    </div>
</div>
