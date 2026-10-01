@use('App\Livewire\YonergeAnalizi', 'Analiz')
@use('Illuminate\Support\Str')

@props([
    'detay',
    'kadroEtiketi',
    'alanEtiketi',
    'kapsamNotu',
])

@php
    $d = $detay;
    $uni = $d['universite'];
    $esik = $d['esik'];
    $renk = Analiz::RENK[$d['durum']];
    $bashkler = Str::of($uni->ad)->explode(' ')
        ->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->take(3)->implode('');
    $eksikler = $d['sonuc']->eksikler();
    $belirsizler = $d['sonuc']->belirsizler();
    $hesaplanamayan = $d['sonuc']->hesaplanamayanlar();
    $beyanlar = array_filter($d['sonuc']->beyanlar(), fn ($b) => ! $b->kaynakEksik);
@endphp

<div class="flex flex-col gap-6">

    {{-- Başlık --}}
    <div class="flex items-start gap-3 pr-8">
        <div class="flex size-12 shrink-0 items-center justify-center rounded-xl border border-line bg-canvas text-sm font-bold text-ink-muted">{{ $bashkler }}</div>
        <div class="min-w-0 flex-1">
            <flux:heading size="lg" class="!leading-tight">{{ $uni->ad }}</flux:heading>
            <div class="mt-1 flex flex-wrap items-center gap-x-2 gap-y-1 text-xs text-ink-subtle">
                <span class="inline-flex items-center gap-1">
                    <flux:icon name="map-pin" class="size-3" />{{ $uni->sehir }}
                </span>
                <span>·</span>
                <span>{{ $uni->tur === 'vakif' ? 'Vakıf' : 'Devlet' }}</span>
                <span>·</span>
                <span class="inline-flex items-center gap-1 font-medium text-brand">
                    <flux:icon name="check-badge" variant="solid" class="size-3" />Doğrulandı
                </span>
            </div>
        </div>
        <flux:badge :color="Analiz::ROZET[$d['durum']]" size="sm" class="shrink-0">{{ Analiz::UZUN_ETIKET[$d['durum']] }}</flux:badge>
    </div>

    {{-- Değerlendirme künyesi --}}
    <div class="grid grid-cols-2 gap-px overflow-hidden rounded-xl border border-line bg-line sm:grid-cols-4">
        @foreach ([
            ['Hedef Kadro', $kadroEtiketi],
            ['Temel Alan', $alanEtiketi],
            ['Puanım', $d['toplam'] === null ? '—' : $d['toplam'].' pt'],
            ['Min. Baraj', $d['baraj'] === null ? 'Baraj yok' : $d['baraj'].' pt'],
        ] as [$etiket, $deger])
            <div class="bg-surface px-3 py-2.5">
                <div class="text-[10px] uppercase tracking-wide text-ink-subtle">{{ $etiket }}</div>
                <div class="mt-0.5 truncate text-sm font-semibold text-ink" title="{{ $deger }}">{{ $deger }}</div>
            </div>
        @endforeach
    </div>

    {{-- Genel durum --}}
    <div>
        <div class="mb-1.5 flex items-baseline justify-between">
            <flux:heading size="sm">Puan karşılaması</flux:heading>
            <span class="font-serif text-lg font-bold" style="color: {{ $renk }}">%{{ $d['puan_orani'] }}</span>
        </div>
        <div class="h-2 overflow-hidden rounded-full bg-line">
            <div class="baraj-cubuk h-full rounded-full transition-all" style="width: {{ $d['puan_orani'] }}%; background: {{ $renk }}"></div>
        </div>
        <div class="mt-2 text-xs text-ink-muted">
            @if ($d['durum'] === 'uygun')
                Bu yönergenin tüm asgari koşullarını karşılıyorsunuz@if ($d['baraj'] !== null); barajı <strong class="text-ink">{{ $d['toplam'] - $d['baraj'] }} puan</strong> aşıyorsunuz@endif.
            @elseif ($d['durum'] === 'eksik_bilgi')
                Kesin olarak karşılanmayan bir koşul yok.
                @if (count($belirsizler) > 0)
                    <strong class="text-ink">{{ count($belirsizler) }} koşul</strong>
                    için eksik bilgilerinizi tamamlamalısınız; gerekçeleri aşağıda koşul
                    başına yazılı.
                @endif
                @if ($d['beyan_sayisi'] > 0)
                    <strong class="text-ink">{{ $d['beyan_sayisi'] }} koşul</strong>
                    onayınızı bekliyor; belgeniz varsa aşağıdan işaretleyin.
                @endif
                @if ($d['cetvel_eksigi_sayisi'] > 0)
                    <strong class="text-ink">{{ $d['cetvel_eksigi_sayisi'] }} koşulu</strong>
                    kendiniz değerlendirmelisiniz.
                @endif
            @else
                @if ($d['kalan'] > 0)
                    Barajı geçmek için <strong class="text-ink">{{ $d['kalan'] }} puan</strong> daha gerekiyor.
                @endif
                @if (count($eksikler) > 0)
                    {{ count($eksikler) }} koşul karşılanmıyor.
                @endif
            @endif
        </div>

        {{-- Belirsizliğin gerekçesi: motor tahmin yürütmüyor. --}}
        @if (count($belirsizler) > 0)
            <div class="mt-3 rounded-xl border border-cat-purple/30 bg-cat-purple/5 p-3">
                <div class="mb-1.5 flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-wider text-cat-purple">
                    <flux:icon name="question-mark-circle" class="size-3.5" />Değerlendirilemeyen Koşullar
                </div>
                <flux:text class="!text-[11px] leading-relaxed">
                    Aşağıdaki koşullar <strong>sağlanmadığı için değil</strong>, veri eksik olduğu için
                    karara bağlanamadı. Faaliyet tarihlerini ve
                    <a href="{{ route('profile.edit') }}" wire:navigate class="font-medium text-brand underline">akademik profilinizi</a>
                    tamamladığınızda kesin sonuç görürsünüz.
                </flux:text>
            </div>
        @endif
    </div>

    <flux:separator variant="subtle" />

    {{-- Asgari koşullar: yönergenin kendi şart ağacı, olduğu gibi --}}
    <div>
        <flux:heading size="sm">Asgari Koşullar</flux:heading>
        <flux:text class="!mt-0.5 !text-[11px] text-ink-subtle">Yönergenin kendi koşul yapısı; iç içe geçmiş koşullar ve telafi seçenekleri dâhil.</flux:text>

        <div class="mt-3 flex flex-col gap-3">
            @foreach ($d['sonuc']->kosullar() as $i => $kosul)
                <div wire:key="kosul-{{ $i }}">
                    <x-sart-dugum :dugum="$kosul" :esik-anahtari="$esik['anahtar']" />
                </div>
            @endforeach
        </div>
    </div>

    <flux:separator variant="subtle" />

    <x-analiz.dagilim :dagilim="$d['dagilim']" :toplam="$d['toplam']" />

    {{-- Kaynak belge: analiz bu yönergeden çıkarıldı, ayrıntı için adayın
         orijinaline bakabilmesi gerekir.

         Bağlantı bizim okuduğumuz KOPYAYA gider ($d['kaynak_pdf'], `pdf/`
         altında). YÖK'ün sayfasındaki dosya güncellenmiş olabilir; aday
         cetveldeki bir satırı sorgularken tam olarak hangi metinden
         çıkarıldığını görmeli. Üniversitenin ayrıca resmi bir bağlantısı varsa
         o da altına eklenir. --}}
    @if ($d['kaynak_pdf'])
        {{-- Rota anahtarı EŞİĞİN üniversite adı, kartınki değil: eşleme de o
             adla kuruluyor ({@see SartDeposu::kaynakPdf}). --}}
        <x-analiz.kaynak-baglantisi
            :url="route('yonerge-analizi.kaynak', $esik['universite'])"
            baslik="Analizin dayandığı yönerge (PDF)"
            :alt-baslik="$d['kaynak_pdf']" />
    @endif

    @if ($uni->yonerge_url)
        <x-analiz.kaynak-baglantisi
            :url="$uni->yonerge_url"
            baslik="Resmi yönerge sayfası"
            :alt-baslik="$uni->ad.' · atama ve yükseltme kriterleri'" />
    @endif

    @if ($esik['aday_notu'] || $kapsamNotu || $hesaplanamayan || $beyanlar)
        <x-analiz.yonerge-notu
            :aday-notu="$esik['aday_notu']"
            :kapsam-notu="$kapsamNotu"
            :hesaplanamayan="$hesaplanamayan"
            :beyanlar="$beyanlar" />
    @endif

    {{-- Aksiyonlar --}}
    <div class="flex flex-wrap items-center justify-between gap-2">
        <flux:text class="!text-[11px] text-ink-subtle">
            {{ $uni->ad }} · {{ $kadroEtiketi }} · cetvel: {{ $esik['cetvel'] }}
        </flux:text>
        <flux:modal.close>
            <flux:button variant="filled" size="sm">Kapat</flux:button>
        </flux:modal.close>
    </div>
</div>
