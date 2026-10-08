{{--
    Rapor üretilirken çizilen ara durum.

    Adımlar GERÇEK ilerlemeyi göstermiyor — tek bir sağlayıcı çağrısı var ve
    arada haber gelmiyor. Listeyi yine de gösteriyoruz: aday 10-30 saniye
    boyunca neyin sürdüğünü bilmeli, ama "tamamlandı" işareti basmıyoruz ki
    olmayan bir ilerleme uydurmayalım.
--}}
<flux:card class="flex flex-col items-center justify-center gap-5 py-20 text-center">
    <div class="size-12 animate-spin rounded-full border-[3px] border-line" style="border-top-color: var(--color-cat-purple)"></div>

    <div>
        <flux:heading size="lg">Dosya jüri masasına taşınıyor</flux:heading>
        <flux:text class="!mt-1">YZ jüri şapkasını takıyor ve dosyanızı inceliyor.</flux:text>
    </div>

    <ul class="flex flex-col gap-2 text-start text-sm text-ink-muted">
        @foreach ([
            'Profil ve faaliyet listesi okunuyor',
            'Yönerge koşulları motora veriliyor',
            'Puanlar ve karar ölçülüyor',
            'Niteliksel değerlendirme yazılıyor',
            'On maddelik rapor derleniyor',
        ] as $adim)
            <li class="flex items-center gap-2.5">
                <span class="size-1.5 animate-pulse rounded-full bg-cat-purple [animation-delay:{{ $loop->index * 150 }}ms]"></span>
                {{ $adim }}
            </li>
        @endforeach
    </ul>
</flux:card>
