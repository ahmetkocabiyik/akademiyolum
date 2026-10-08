{{--
    CV OLUŞTURUCU — üç bölme: içerik · canlı önizleme · tasarım.

    Ortadaki önizleme yazdırılan sayfanın KENDİSİ (bkz. components/cv/onizleme);
    PDF ayrı bir şablondan değil bu düğümden üretiliyor.
--}}
<div>
    {{-- CV'ye özel web fontları; uygulamanın geri kalanı bunlara ihtiyaç duymuyor. --}}
    <link rel="stylesheet" href="{{ \App\Enums\CvYaziTipi::webFontlari() }}">

    <x-topbar class="yazdirma-gizle" title="CV Oluşturucu" :pill="$this->secilenler->count().' faaliyet CV\'de'">
        <flux:button x-on:click="window.print()" variant="primary" icon="arrow-down-tray">
            PDF İndir
        </flux:button>
    </x-topbar>

    <div class="grid gap-4 xl:grid-cols-[320px_1fr_280px] 2xl:grid-cols-[360px_1fr_340px]">

        <x-cv.form-paneli
            :sekme="$sekme"
            :egitimler="$egitimler"
            :deneyimler="$deneyimler"
            :beceriler="$beceriler"
            :diller="$diller"
            :faaliyetler="$this->faaliyetler"
            :haric-faaliyetler="$haricFaaliyetler"
            :foto="$this->fotoAdresi()"
            :unvan="$unvan"
            class="yazdirma-gizle xl:max-h-[calc(100dvh-9rem)] xl:sticky xl:top-4" />

        {{-- Önizleme sütuna SIĞDIRILIYOR: sayfa gerçek A4 genişliğinde (210mm)
             çizilip ölçekleniyor. Doğrudan dar çizilseydi ekrandaki satır
             sonları çıktıdakinden başka olur, aday sayfanın nerede bittiğini
             göremezdi. Yazdırırken ölçek kalkar (app.css, @media print). --}}
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
                    <x-cv.onizleme :cv="$this->onizleme()" />
                </div>
            </div>
        </div>

        <x-cv.tasarim-paneli
            :sablon="$sablon"
            :renk="$renk"
            :cizgi-renk="$cizgiRenk"
            :yazi-tipi="$yaziTipi"
            :bolumler="$bolumler"
            class="yazdirma-gizle xl:max-h-[calc(100dvh-9rem)] xl:sticky xl:top-4" />
    </div>
</div>
