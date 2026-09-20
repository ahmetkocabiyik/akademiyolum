{{--
    YÖNERGE ANALİZİ — ekranın iskeleti.

    Parçalar `components/analiz/` altında; bu dosya yalnızca düzeni ve hangi
    parçanın ne zaman çizildiğini anlatır. Durumun ekran karşılıkları (renk,
    rozet, etiket) `App\Livewire\YonergeAnalizi` sınıfındaki sabitlerde — üç
    şablonda kopyalıydı.
--}}
<div>
    <x-topbar title="Yönerge Analizi" :pill="count($this->listelenen) . ' üniversite'">
        <flux:button wire:click="$toggle('karsilastirma')" size="sm" :variant="$karsilastirma ? 'filled' : 'primary'" icon="table-cells">
            {{ $karsilastirma ? 'Kartlara Dön' : 'Üniversite Karşılaştır' }}
        </flux:button>
    </x-topbar>

    <div class="flex flex-col gap-4">

        <div class="grid gap-4 lg:grid-cols-[260px_1fr]">

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
                            <flux:button wire:click="$set('durumFiltre', '')" size="sm" variant="ghost" class="mt-3">
                                Durum filtresini kaldır
                            </flux:button>
                        @endif
                    </flux:card>
                @elseif ($karsilastirma)
                    <x-analiz.karsilastirma-tablosu
                        :satirlar="$this->listelenen"
                        :kadro-etiketi="$kadrolar[$hedefKadro]" />
                @else
                    <div @class(['grid gap-3 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4' => $gorunum === 'grid', 'flex flex-col gap-2' => $gorunum === 'list'])>
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
