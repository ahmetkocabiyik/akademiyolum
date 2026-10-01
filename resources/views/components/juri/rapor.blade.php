@props(['rapor'])

{{--
    JÜRİ RAPORU — üç katman: karar başlığı · ölçüm çubukları · on adım.

    Başlıktaki karar ve çubuklardaki sayılar YZ'den DEĞİL şart ağacı motorundan
    geliyor ve rapor yazıldığı anda satıra donmuş durumda; aday sonradan yayın
    eklese bile eski rapor kendi sayılarıyla okunur. Metin katmanı YZ'nin.
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
    <div class="overflow-hidden rounded-xl bg-navy">
        <div class="flex flex-wrap items-start justify-between gap-4 px-6 py-5">
            <div class="min-w-0">
                <span class="inline-flex items-center gap-1.5 rounded-full border border-gold/25 bg-gold/15 px-3 py-1 text-[11px] font-semibold tracking-wide text-gold">
                    <flux:icon :name="$rapor->sapka->ikon()" class="size-3" />
                    YZ Jüri Üyesi — {{ $rapor->sapka->etiket() }}
                </span>
                <h2 class="mt-2.5 font-serif text-xl font-bold text-white">
                    {{ $rapor->kadroEtiketi() }} Dosya Değerlendirmesi
                </h2>
                <div class="mt-1 text-xs text-white/45">
                    {{ $rapor->user->name }} · {{ $rapor->universite }}
                    @if ($rapor->birim) · {{ $rapor->birim }} @endif
                    · {{ $rapor->sertlik->etiket() }} ton
                    · {{ $rapor->created_at?->translatedFormat('j F Y, H:i') }}
                </div>
            </div>

            <div class="shrink-0 text-end">
                <div class="inline-flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-bold tracking-wide"
                    style="color: {{ $karar->renk() }}; background: color-mix(in srgb, {{ $karar->renk() }} 18%, transparent); border: 1.5px solid color-mix(in srgb, {{ $karar->renk() }} 40%, transparent)">
                    <flux:icon :name="$karar->ikon()" class="size-4" />
                    {{ $karar->etiket() }}
                </div>
                <div class="mt-1.5 max-w-[16rem] text-[11px] leading-snug text-white/45">
                    {{ $karar->aciklama() }}
                </div>
            </div>
        </div>

        {{-- Ölçüm çubukları: yönerge koşullarını sayıyla ifade etmiyorsa hiç çizilmez. --}}
        @if ($rapor->olcumler !== [])
            <div class="border-t border-white/10 bg-navy-soft px-6 py-3">
                @foreach ($rapor->olcumler as $olcum)
                    <div class="flex items-center gap-4 py-1.5">
                        <div class="w-48 shrink-0 truncate text-[11px] font-medium text-white/45" title="{{ $olcum['etiket'] }}">
                            {{ $olcum['etiket'] }}
                        </div>
                        <div class="h-2 flex-1 overflow-hidden rounded-full bg-white/10">
                            <div class="h-full rounded-full transition-all"
                                style="width: {{ min(100, $olcum['oran']) }}%; background: {{ $olcumRengi($olcum['oran']) }}"></div>
                        </div>
                        <div class="w-24 shrink-0 text-end text-xs font-semibold" style="color: {{ $olcumRengi($olcum['oran']) }}">
                            {{ $olcum['mevcut'] }} / {{ $olcum['gerekli'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

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
        <div class="flex flex-wrap items-start gap-5 rounded-xl bg-navy px-6 py-5">
            <div class="flex size-12 shrink-0 items-center justify-center rounded-full"
                style="background: color-mix(in srgb, {{ $karar->renk() }} 18%, transparent); border: 2px solid color-mix(in srgb, {{ $karar->renk() }} 40%, transparent)">
                <flux:icon :name="$karar->ikon()" class="size-6" style="color: {{ $karar->renk() }}" />
            </div>
            <div class="min-w-0 flex-1">
                <div class="font-serif text-lg font-bold text-white">{{ $karar->etiket() }}</div>
                <p class="mt-1.5 text-[13px] leading-relaxed text-white/55">{{ $rapor->ozet }}</p>
                <div class="mt-4 flex flex-wrap gap-2">
                    <flux:button :href="route('yz-danisman')" wire:navigate size="sm" icon="sparkles" class="!bg-gold !text-navy">
                        YZ Danışmana Sor
                    </flux:button>
                    <flux:button :href="route('yonerge-analizi')" wire:navigate size="sm" variant="subtle"
                        icon="document-magnifying-glass" class="!border-white/15 !bg-white/10 !text-white/70">
                        Koşulları Tek Tek Gör
                    </flux:button>
                </div>
            </div>
        </div>
    @endif
</div>
