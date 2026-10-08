{{--
    YZ JÜRİ ANALİZİ — ekranın iskeleti.

    Parçalar `components/juri/` altında. Sağ taraf dört durumdan birini çizer:
    bekleme · hata · rapor · boş. Rapor üretimi iki istekte yapıldığı için
    (bkz. App\Livewire\JuriAnalizi) bekleme durumu gerçekten görünür.
--}}
<div>
    {{-- Pill'e KARAR yazılmıyor: topbar rozeti her zaman yeşil çiziliyor ve
         "BAŞVURAMAZ" yeşil bir rozetin içinde adaya tersini söylüyordu. Karar
         raporun kendi başlığında, kendi renginde duruyor. --}}
    <x-topbar title="YZ Jüri Analizi"
        :pill="$this->rapor ? $this->rapor->universite.' · '.$this->rapor->kadroEtiketi() : null">
        @if ($this->rapor)
            <flux:button wire:click="analizBaslat" :disabled="$bekleniyor" variant="primary" icon="arrow-path">
                Yeni Analiz
            </flux:button>
        @endif
    </x-topbar>

    <div class="grid gap-4 lg:grid-cols-[300px_1fr]">

        <x-juri.ayar-paneli
            :kurumlar="$this->kurumlar"
            :hedef-kurum="$hedefKurum"
            :kadrolar="$kadrolar"
            :hedef-kadro="$hedefKadro"
            :sapka="$sapka"
            :sertlik="$sertlik"
            :raporlar="$this->raporlar"
            :aktif-rapor-id="$aktifRaporId"
            :bekleniyor="$bekleniyor" />

        <div class="min-w-0">
            @if ($hata)
                <div class="mb-3 flex items-start gap-2 rounded-xl border px-3.5 py-2.5 text-sm"
                    style="border-color: color-mix(in srgb, var(--color-cat-red) 35%, transparent); background: var(--color-cat-red-light); color: var(--color-cat-red);">
                    <flux:icon name="exclamation-circle" class="mt-px size-4 shrink-0" />
                    <span>{{ $hata }}</span>
                </div>
            @endif

            @if ($bekleniyor)
                <x-juri.bekleme />
            @elseif ($this->rapor)
                <x-juri.rapor :rapor="$this->rapor" />
            @else
                <x-juri.bos-durum :kurum-var="$this->kurumlar !== []" />
            @endif
        </div>
    </div>
</div>
