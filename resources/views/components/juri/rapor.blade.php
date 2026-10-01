@props(['rapor'])

{{--
    JÜRİ RAPORU — üç katman: karar başlığı · ölçüm çubukları · on adım.

    Başlıktaki karar ve çubuklardaki sayılar YZ'den DEĞİL şart ağacı motorundan
    geliyor ve rapor yazıldığı anda satıra donmuş durumda; aday sonradan yayın
    eklese bile eski rapor kendi sayılarıyla okunur. Metin katmanı YZ'nin.

    Prototipteki (html/06_juri_analizi.html) koyu lacivert bloklar burada
    KULLANILMIYOR: uygulamanın geri kalanı açık yüzey üzerine kurulu, iki koyu
    slab sayfanın ortasına yabancı iki delik açıyordu ve lacivert üzerindeki boş
    ölçüm çubukları okunmuyordu. Karar rengini yüzey değil ŞERİT ve rozet
    taşıyor — Yönerge Analizi'ndeki baraj çubuğuyla aynı dil.
--}}
@php
    $karar = $rapor->karar;
    $olcumRengi = fn (int $oran) => match (true) {
        $oran >= 100 => 'var(--color-cat-green)',
        $oran >= 80 => 'var(--color-cat-amber)',
        default => 'var(--color-cat-red)',
    };
@endphp

<div class="flex flex-col gap-4">

    {{-- Karar başlığı --}}
    {{-- Karar rengi kartın SOL ŞERİDİNDE: adım kartları ve son söz kartı da aynı
         şeridi kullanıyor, üstten kuşak atmak sayfada ikinci bir vurgu dili
         açıyordu. --}}
    <flux:card class="overflow-hidden !p-0" style="border-inline-start: 3px solid {{ $karar->renk() }}">
        <div class="flex flex-wrap items-start justify-between gap-4 px-5 py-4">
            <div class="min-w-0">
                <span class="inline-flex items-center gap-1.5 rounded-full border border-line bg-canvas px-2.5 py-1 text-[11px] font-medium text-ink-muted">
                    <flux:icon :name="$rapor->sapka->ikon()" class="size-3" style="color: {{ $rapor->sapka->renk() }}" />
                    {{ $rapor->sapka->etiket() }} · {{ $rapor->sertlik->etiket() }} ton
                </span>

                <flux:heading size="xl" class="!mt-2 font-serif">
                    {{ $rapor->kadroEtiketi() }} Dosya Değerlendirmesi
                </flux:heading>

                <div class="mt-1 text-xs text-ink-subtle">
                    {{ $rapor->user->name }} · {{ $rapor->universite }}
                    @if ($rapor->birim) · {{ $rapor->birim }} @endif
                    · {{ $rapor->created_at?->translatedFormat('j F Y, H:i') }}
                </div>
            </div>

            <div class="shrink-0 text-end">
                <div class="inline-flex items-center gap-2 rounded-lg px-3.5 py-2 text-sm font-bold tracking-wide"
                    style="color: {{ $karar->renk() }}; background: color-mix(in srgb, {{ $karar->renk() }} 10%, transparent); border: 1px solid color-mix(in srgb, {{ $karar->renk() }} 30%, transparent)">
                    <flux:icon :name="$karar->ikon()" class="size-4" />
                    {{ $karar->etiket() }}
                </div>
                <div class="mt-1.5 max-w-[17rem] text-[11px] leading-snug text-ink-subtle">
                    {{ $karar->aciklama() }}
                </div>
            </div>
        </div>

        {{-- Ölçümler. Etiket çubuğun ÜSTÜNDE, tam satır: yan yana dizilince
             koşul metni üç kelimede kırpılıyor ve aday neyin ölçüldüğünü
             okuyamıyordu. Yönergede sayısal koşul yoksa bölüm hiç çizilmez. --}}
        @if ($rapor->olcumler !== [])
            <div class="flex flex-col gap-3 border-t border-line bg-canvas px-5 py-4">
                @foreach ($rapor->olcumler as $olcum)
                    @php $renk = $olcumRengi($olcum['oran']); @endphp
                    <div>
                        <div class="mb-1.5 flex items-baseline justify-between gap-3">
                            <span class="min-w-0 text-xs text-ink-muted">{{ $olcum['etiket'] }}</span>
                            <span class="shrink-0 text-xs font-semibold tabular-nums" style="color: {{ $renk }}">
                                {{ $olcum['mevcut'] }} / {{ $olcum['gerekli'] }}
                            </span>
                        </div>
                        <div class="h-2 overflow-hidden rounded-full bg-line">
                            <div class="baraj-cubuk h-full rounded-full"
                                style="width: {{ max(2, min(100, $olcum['oran'])) }}%; background: {{ $renk }}"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </flux:card>

    {{-- On adım --}}
    <div class="flex flex-col gap-3">
        @foreach ($rapor->adimSatirlari() as $sira => $satir)
            <x-juri.adim-karti
                :sira="$sira + 1"
                :adim="$satir['adim']"
                :agirlik="$satir['agirlik']"
                :icerik="$satir['icerik']"
                :etiket="$satir['adim'] === \App\Enums\JuriAdimi::Karar ? $karar->etiket() : null"
                :acik="$sira === 0"
                wire:key="adim-{{ $rapor->id }}-{{ $satir['adim']->value }}" />
        @endforeach
    </div>

    {{-- Son söz --}}
    @if ($rapor->ozet !== '')
        <flux:card class="flex flex-wrap items-start gap-4 !p-5"
            style="border-inline-start: 3px solid {{ $karar->renk() }}">
            <div class="flex size-10 shrink-0 items-center justify-center rounded-full"
                style="color: {{ $karar->renk() }}; background: color-mix(in srgb, {{ $karar->renk() }} 10%, transparent)">
                <flux:icon :name="$karar->ikon()" class="size-5" />
            </div>
            <div class="min-w-0 flex-1">
                <flux:heading size="lg">{{ $karar->etiket() }}</flux:heading>
                <flux:text class="!mt-1 leading-relaxed">{{ $rapor->ozet }}</flux:text>
                <div class="mt-4 flex flex-wrap gap-2">
                    <flux:button :href="route('yz-danisman')" wire:navigate size="sm" variant="primary" icon="sparkles">
                        YZ Danışmana Sor
                    </flux:button>
                    <flux:button :href="route('yonerge-analizi')" wire:navigate size="sm" variant="subtle"
                        icon="document-magnifying-glass">
                        Koşulları Tek Tek Gör
                    </flux:button>
                </div>
            </div>
        </flux:card>
    @endif
</div>
