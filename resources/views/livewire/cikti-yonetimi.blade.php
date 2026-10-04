{{--
    ÇIKTI YÖNETİMİ — iki bölme: rapor ayarları · canlı önizleme.

    Önizleme yazdırılan sayfanın KENDİSİ (bkz. components/rapor/sayfa); PDF
    tarayıcının bu düğümü yazdırmasıyla üretiliyor. Ölçekleme CV Oluşturucu'yla
    aynı: sayfa gerçek A4 genişliğinde çizilip sütuna sığdırılıyor.
--}}
<div>
    <x-topbar class="yazdirma-gizle" title="Çıktı Yönetimi" :pill="$this->rapor['ozet']['faaliyet'].' onaylı faaliyet'">
        <flux:modal.trigger name="rapor-indir">
            <flux:button size="sm" variant="primary" icon="arrow-down-tray">Dosyayı İndir</flux:button>
        </flux:modal.trigger>
    </x-topbar>

    <div class="grid gap-4 xl:grid-cols-[340px_1fr] 2xl:grid-cols-[380px_1fr]">

        <x-rapor.ayar-paneli
            :sablon="$sablon"
            :aralik="$aralik"
            :hedef-kadro="$hedefKadro"
            :hedef-kurum="$hedefKurum"
            :kurumlar="$this->kurumlar"
            :bolumler="$bolumler"
            :juri-var="$this->rapor['juri'] !== null"
            class="yazdirma-gizle xl:max-h-[calc(100dvh-9rem)] xl:sticky xl:top-4" />

        <div class="cv-olcek-kap min-w-0 rounded-xl bg-canvas p-4"
            x-data="{
                olcek: 1,
                yukseklik: 0,
                hesapla() {
                    const kap = $refs.kap?.clientWidth ?? 0;
                    const sayfa = $refs.sayfa?.offsetWidth ?? 1;
                    this.olcek = Math.min(1, kap / sayfa);
                    this.yukseklik = ($refs.sayfa?.offsetHeight ?? 0) * this.olcek;
                },
            }"
            x-init="$nextTick(() => { hesapla(); new ResizeObserver(() => hesapla()).observe($refs.kap); new ResizeObserver(() => hesapla()).observe($refs.sayfa); })">
            <div x-ref="kap" class="overflow-hidden" :style="`height: ${yukseklik}px`">
                <div x-ref="sayfa" class="cv-olcek mx-auto w-fit" :style="`transform: scale(${olcek}); --cv-olcek: ${olcek}`">
                    <x-rapor.sayfa
                        :rapor="$this->rapor"
                        :sablon="$sablon"
                        :baslik="$baslik"
                        :bolumler="$bolumler"
                        :aralik="$aralik" />
                </div>
            </div>
        </div>
    </div>

    {{-- İndirme. PDF tarayıcının yazdırma penceresinden alınıyor (CV'yle aynı
         yol); Excel, rapordaki faaliyet listesinin CSV'si. --}}
    <flux:modal name="rapor-indir" class="w-full max-w-md">
        <div class="flex flex-col gap-5">
            <div>
                <flux:heading size="lg">Dosyayı İndir</flux:heading>
                <flux:text class="mt-1">Raporu PDF olarak kaydedin ya da faaliyet listesini Excel'de açın.</flux:text>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <button type="button" x-on:click="$flux.modal('rapor-indir').close(); $nextTick(() => window.print())"
                    class="flex flex-col items-center gap-2 rounded-xl border border-line p-4 text-center transition hover:border-brand hover:bg-brand-light">
                    <span class="flex size-10 items-center justify-center rounded-lg bg-cat-red-light text-cat-red">
                        <flux:icon name="document-text" />
                    </span>
                    <span class="text-sm font-semibold text-ink">PDF</span>
                    <span class="text-[11px] leading-tight text-ink-subtle">Ekrandaki rapor, A4</span>
                </button>

                <button type="button" wire:click="excelIndir" x-on:click="$flux.modal('rapor-indir').close()"
                    class="flex flex-col items-center gap-2 rounded-xl border border-line p-4 text-center transition hover:border-brand hover:bg-brand-light">
                    <span class="flex size-10 items-center justify-center rounded-lg bg-cat-green-light text-cat-green">
                        <flux:icon name="table-cells" />
                    </span>
                    <span class="text-sm font-semibold text-ink">Excel</span>
                    <span class="text-[11px] leading-tight text-ink-subtle">Faaliyet listesi (CSV)</span>
                </button>
            </div>

            <flux:text class="!text-[11px] leading-relaxed">
                PDF için açılan yazdırma penceresinde hedef olarak <strong>“PDF olarak kaydet”</strong> seçin.
            </flux:text>
        </div>
    </flux:modal>
</div>
