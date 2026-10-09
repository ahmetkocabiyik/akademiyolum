{{--
    YÖNERGE ANALİZİ — ekranın iskeleti.

    Parçalar `components/analiz/` altında; bu dosya yalnızca düzeni ve hangi
    parçanın ne zaman çizildiğini anlatır. Durumun ekran karşılıkları (renk,
    rozet, etiket) `App\Livewire\YonergeAnalizi` sınıfındaki sabitlerde — üç
    şablonda kopyalıydı.

    data-kart-listesi: kart geçişlerinin (resources/js/app.js) bu bileşeni
    tanıdığı işaret. Kökte duruyor, kartların kendisinde değil — filtre hiç
    sonuç vermediğinde liste kabı da çizilmiyor, oysa filtre kalkınca gelen
    kartların belirmesi gerekiyor.
--}}
<div data-kart-listesi>
    <x-topbar title="Yönerge Analizi" :pill="count($this->listelenen) . ' üniversite'">
        <flux:button wire:click="$toggle('karsilastirma')" :variant="$karsilastirma ? 'filled' : 'primary'" icon="table-cells">
            @if ($karsilastirma)
                Kartlara Dön
            @else
                {{-- Dar ekranda tam etiket sayfa başlığını "Yönerge An…" diye kesiyordu. --}}
                <span class="sm:hidden">Karşılaştır</span>
                <span class="max-sm:hidden">Üniversite Karşılaştır</span>
            @endif
        </flux:button>
    </x-topbar>

    <div class="flex flex-col gap-4">

        <div class="grid grid-cols-1 gap-4 lg:grid-cols-[260px_minmax(0,1fr)]">

            {{-- Sol panel: profil + filtreler --}}
            <div class="flex flex-col gap-4">
                <x-analiz.profil-karti
                    :onayli-sayisi="$this->faaliyetler->count()"
                    :doluluk="$this->profilDoluluk" />

                <x-analiz.filtreler
                    :kadrolar="$kadrolar"
                    :hedef-kadro="$hedefKadro"
                    :sehirler="$this->sehirler" />
            </div>

            {{-- Sağ panel: özet + sonuç listesi --}}
            <div class="flex flex-col gap-3">

                <x-analiz.ozet-bar
                    :ozet="$this->ozet"
                    :durum-filtre="$durumFiltre"
                    :gorunum="$gorunum"
                    :karsilastirma="$karsilastirma" />

                @if ($this->birimSecenekleri !== [])
                    <x-analiz.birim-secimi
                        :secenekler="$this->birimSecenekleri"
                        :acik="$birimPaneliAcik" />
                @endif

                {{-- "Ölçüt Yok" bir sonuç durumu değil, sonucu HİÇ OLMAYANLARIN
                     adı: o üniversitelerin kartı aşağıdaki kapsam dışı
                     bölümünde. Sayaç seçiliyken sonuç listesi tamamen atlanır,
                     yoksa aday "yönerge bulunamadı" kartıyla karşılaşırdı. --}}
                @if ($durumFiltre === 'alan_yok')
                    {{-- Kapsam dışı bölümü aşağıda; burada gösterilecek sonuç yok. --}}
                @elseif (empty($this->listelenen))
                    <flux:card class="py-12 text-center">
                        <flux:text>Seçili filtrelere uygun yönerge bulunamadı.</flux:text>
                        {{-- Durum filtresi sayaçtan tek tıkla açılıyor; kapatma
                             yolu da elin altında olmalı, yoksa boş ekranda kalan
                             aday nereye tıklayacağını bilmiyor. --}}
                        @if ($durumFiltre !== '')
                            <flux:button wire:click="$set('durumFiltre', '')" variant="ghost" class="mt-3">
                                Durum filtresini kaldır
                            </flux:button>
                        @endif
                    </flux:card>
                @elseif ($karsilastirma)
                    <x-analiz.karsilastirma-tablosu
                        :satirlar="$this->listelenen"
                        :kadro-etiketi="$kadrolar[$hedefKadro]" />
                @else
                    {{-- Masaüstünde (≥1400px) üç sütun. Eşikler rem cinsinden
                         (87.5rem = 1400px, 125rem = 2000px): Tailwind piksel
                         yazılan min-[…] varyantını rem tabanlı md'den ÖNCE basıyor,
                         md:grid-cols-2 onu eziyor ve eşik hiç devreye girmiyordu. --}}
                    <div data-sirali @class(['grid gap-3 md:grid-cols-2 min-[87.5rem]:grid-cols-3 min-[125rem]:grid-cols-4' => $gorunum === 'grid', 'flex flex-col gap-2' => $gorunum === 'list'])>
                        @foreach ($this->listelenen as $s)
                            <x-analiz.universite-karti :satir="$s" :gorunum="$gorunum" />
                        @endforeach
                    </div>
                @endif

                @if ($this->kapsamDisi['alan_yok'] !== [] && in_array($durumFiltre, ['', 'alan_yok'], true))
                    <x-analiz.kapsam-disi :adlar="$this->kapsamDisi['alan_yok']" />
                @endif
            </div>
        </div>
    </div>

    {{-- Üniversite detay modalı --}}
    <flux:modal wire:model.self="detayAcik" flyout position="right" data-detay-flyout class="w-full md:w-[34rem]">
        <div wire:loading.flex wire:target="detayAc" class="flex-col gap-6">
            <x-analiz.detay-iskeleti />
        </div>

        <div wire:loading.remove wire:target="detayAc">
            @if ($d = $this->detay)
                <x-analiz.detay
                    :detay="$d"
                    :kadro-etiketi="$kadrolar[$hedefKadro]"
                    :alan-etiketi="$this->alanEtiketi($d['esik']['alan'])"
                    :kapsam-notu="$this->kapsamNotu($d['esik'])" />
            @endif
        </div>
    </flux:modal>
</div>
