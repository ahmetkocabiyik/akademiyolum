@props([
    /** Bağlanan Livewire özelliği; `eylem` verilirse boş bırakılabilir. */
    'model' => null,
    /** Seçim hemen sunucuya gitsin mi (wire:model.live karşılığı). */
    'canli' => false,
    /** array<string, string> — değer → etiket. Gruplar gerekmiyorsa bu. */
    'secenekler' => null,
    /** list<array{baslik: string|null, secenekler: array<string, string>}> — başlıklı gruplar. */
    'gruplar' => null,
    /** Model yerine seçilince çağrılan bileşen metodu; seçilen değer argüman olarak gider. */
    'eylem' => null,
    /** `eylem` kullanılırken seçili değer. */
    'deger' => null,
    /** array<string, string> — seçenek değeri → satırın inline stili (ör. yazı tipi önizlemesi). */
    'stiller' => [],
    'label' => null,
    'description' => null,
    'descriptionTrailing' => null,
    'placeholder' => 'Seçin...',
])

{{--
    SEÇİM LİSTESİ — tarayıcının yerel <select>'i yerine kullanılan açılır liste.

    Görünüm components/combobox ile aynı (kutu, açılan panel, vurgu): yerel
    <select>'in açılan menüsü işletim sistemine göre çiziliyor, combobox'ların
    yanında yabancı duruyordu. Combobox'tan farkı: değer etiketten ayrı
    (`fen` → "Fen Bilimleri ve Matematik"), serbest metin yok, seçenekler
    başlıklı gruplara ayrılabiliyor.

    Değerler metin olarak karşılaştırılır: PHP sayısal dizi anahtarlarını
    int'e çeviriyor ('12' → 12), Livewire özelliği de int dönebiliyor.

    wire:key seçenek listesine bağlı: sunucu listeyi değiştirince (üniversite
    değişti, "listede yok" açıldı) kutu baştan kurulur. Aynı kalsaydı Alpine
    ilk çizimdeki listeyi tutardı.
--}}
@php
    $gruplar = collect($gruplar ?? [['baslik' => null, 'secenekler' => $secenekler ?? []]])
        ->map(fn (array $g): array => [
            'baslik' => $g['baslik'] ?? null,
            'secenekler' => collect($g['secenekler'])
                ->map(fn (string $etiket, string|int $deger): array => ['deger' => (string) $deger, 'etiket' => $etiket, 'stil' => $stiller[$deger] ?? null])
                ->values()->all(),
        ])
        ->filter(fn (array $g): bool => $g['secenekler'] !== [])
        ->values()->all();

    $duz = collect($gruplar)->flatMap(fn (array $g): array => $g['secenekler']);
    $degerler = $duz->pluck('deger')->all();
    $etiketler = $duz->pluck('etiket', 'deger')->all();
    // İlk çizimde kutu boş görünmesin (Alpine yüklenmeden önce de etiket yazsın).
    $baslangic = $model !== null ? data_get(\Livewire\Livewire::current(), $model) : $deger;

    $anahtar = 'secim-'.md5($model.'|'.$eylem.'|'.json_encode($gruplar));
@endphp

<div
    x-data="{
        @if ($model !== null)
            secili: @if ($canli) @entangle($model).live @else @entangle($model) @endif,
        @else
            secili: @js((string) $deger),
        @endif
        eylem: @js($eylem),
        acik: false,
        vurgu: -1,
        degerler: @js($degerler),
        etiketler: @js($etiketler),
        esit(d) { return d === String(this.secili ?? ''); },
        get etiket() { return this.etiketler[String(this.secili ?? '')] ?? ''; },
        ac() { this.acik = true; this.vurgu = this.degerler.findIndex(d => this.esit(d)); this.goster(); },
        sec(d) {
            this.secili = d;
            if (this.eylem) $wire.call(this.eylem, d);
            this.kapat();
        },
        kapat() { this.acik = false; this.vurgu = -1; },
        asagi() { if (! this.acik) return this.ac(); if (this.vurgu < this.degerler.length - 1) this.vurgu++; this.goster(); },
        yukari() { if (this.vurgu > 0) this.vurgu--; this.goster(); },
        // Panel kaydırılabiliyor; klavyeyle inilen satır görünür kalsın.
        goster() { this.$nextTick(() => this.$el.querySelector('[data-secim-vurgu]')?.scrollIntoView({ block: 'nearest' })); },
        enter() { if (this.acik && this.degerler[this.vurgu] !== undefined) { this.sec(this.degerler[this.vurgu]); } else { this.ac(); } },
    }"
    @click.outside="kapat()"
    x-on:keydown.escape="kapat()"
    data-secim="{{ $model ?? $eylem }}"
    {{-- Simgeler tıklamayı yutmasın: kutunun sağındaki ok input'un üstünde
         ayrı bir katman, üstüne tıklayınca liste açılmıyordu. --}}
    {{ $attributes->merge(['wire:key' => $anahtar])->class('relative [&_input~div]:pointer-events-none [&_svg]:pointer-events-none') }}
>
    <flux:input
        :label="$label"
        :description="$description"
        :description:trailing="$descriptionTrailing"
        :placeholder="$placeholder"
        icon:trailing="chevron-up-down"
        readonly
        {{-- Yazılamayan kutu: yazı imleci (I) ve yanıp sönen imleç çıkmasın.
             `class` Flux'ın sarmalayıcısına gidiyor; input'a `class:input` ile. --}}
        class:input="cursor-pointer caret-transparent select-none"
        :value="$etiketler[(string) $baslangic] ?? ''"
        x-bind:value="etiket"
        x-on:click="acik ? kapat() : ac()"
        x-on:keydown.arrow-down.prevent="asagi()"
        x-on:keydown.arrow-up.prevent="yukari()"
        x-on:keydown.enter.prevent="enter()"
        x-on:keydown.space.prevent="enter()"
        x-on:keydown.tab="kapat()"
        role="combobox"
        x-bind:aria-expanded="acik"
    />

    {{-- Seçenekler sunucuda çiziliyor (Alpine şablonu değil): metinleri
         sayfada aranabiliyor ve testler gerçek HTML'e bakabiliyor. --}}
    <div x-show="acik" x-transition.opacity x-cloak role="listbox"
        class="absolute z-30 mt-1 max-h-72 w-full min-w-48 overflow-auto rounded-lg border border-line bg-surface py-1 shadow-lg">
        @php $sira = 0; @endphp
        @foreach ($gruplar as $gi => $grup)
            <div @class(['mt-1 border-t border-line pt-1' => $gi > 0])>
                @if ($grup['baslik'])
                    <div class="px-3 pt-1.5 pb-1 text-xs font-medium text-ink-subtle">{{ $grup['baslik'] }}</div>
                @endif
                @foreach ($grup['secenekler'] as $secenek)
                    <button type="button" role="option" data-deger="{{ $secenek['deger'] }}"
                        x-on:click="sec(@js($secenek['deger']))" x-on:mouseenter="vurgu = {{ $sira }}"
                        x-bind:aria-selected="esit(@js($secenek['deger']))"
                        x-bind:data-secim-vurgu="vurgu === {{ $sira }}"
                        class="flex w-full items-center justify-between gap-2 px-3 py-2 text-start text-sm"
                        x-bind:class="vurgu === {{ $sira }} ? 'bg-brand-light text-brand' : (esit(@js($secenek['deger'])) ? 'bg-canvas font-medium text-ink' : 'text-ink')">
                        <span class="truncate" @if ($secenek['stil']) style="{{ $secenek['stil'] }}" @endif>{{ $secenek['etiket'] }}</span>
                        <flux:icon.check variant="micro" class="shrink-0" x-show="esit(@js($secenek['deger']))" x-cloak />
                    </button>
                    @php $sira++; @endphp
                @endforeach
            </div>
        @endforeach
    </div>
</div>
