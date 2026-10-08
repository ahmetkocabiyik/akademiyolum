@use('App\Livewire\YonergeAnalizi', 'Analiz')
@use('Illuminate\Support\Str')

@props([
    'satir',
    'gorunum',
])

@php
    $s = $satir;
    $uni = $s['universite'];
    $renk = Analiz::RENK[$s['durum']];
    $bashkler = Str::of($uni->ad)->explode(' ')
        ->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->take(3)->implode('');

    // Asgari koşullar: kartta en fazla 6 tanesi; kalanı ve tam ağaç detay
    // panelinde. Kart sabit yükseklikte olduğu için kaydırmak yerine kesip
    // sayısını söylemek daha okunur.
    $tumKosullar = $s['sonuc']->kosullar();
    $gosterilen = $gorunum === 'grid' ? array_slice($tumKosullar, 0, 6) : $tumKosullar;
    $gizliSayi = count($tumKosullar) - count($gosterilen);
@endphp

{{-- $wire.detayAcik = true: panel sunucu yanıtını beklemeden kaymaya başlar. --}}
{{-- data-kart: filtre/sıralama sonrası kartın yeni yerine KAYARAK gitmesini
     sağlayan FLIP kancası (resources/js/app.js). Değeri kartın kimliği; morph
     öncesi ölçülen konumlarla morph sonrasını bu anahtar eşliyor. --}}
{{-- Sabit yükseklik: 6 koşullu bir kartın (Mersin) doğal boyu, büyütülmüş
     yazı ölçeğiyle (sm = 15px). Sabit kısımlar ~190px, kalan ~146px tam 6
     satırlık liste demek. Uyarı satırı ya da
     yönerge düğmesi olan kartlarda liste payı azalır ve kendi içinde kayar —
     kart boyu değişmez, içerik de kırpılmaz. --}}
<flux:card @class([
    'flex cursor-pointer flex-col overflow-hidden !p-0 transition duration-200 hover:-translate-y-0.5 hover:border-brand/40 active:translate-y-0',
    'h-[22.5rem]' => $gorunum === 'grid',
])
    wire:key="uni-{{ $uni->id }}"
    data-kart="{{ $uni->id }}"
    wire:click="detayAc({{ $uni->id }})"
    x-on:click="$wire.detayAcik = true"
    role="button" tabindex="0"
    x-on:keydown.enter.prevent="$wire.detayAcik = true; $wire.detayAc({{ $uni->id }})"
    x-on:keydown.space.prevent="$wire.detayAcik = true; $wire.detayAc({{ $uni->id }})"
    aria-label="{{ $uni->ad }} detayları">
    <div class="h-1 shrink-0" style="background: {{ $renk }}"></div>
    <div class="flex flex-1 flex-col p-4">
        <div class="flex items-start justify-between gap-3">
            <div class="flex min-w-0 items-center gap-3">
                <div class="flex size-10 shrink-0 items-center justify-center rounded-lg border border-line bg-canvas text-xs font-bold text-ink-muted">{{ $bashkler }}</div>
                <div class="min-w-0">
                    <div class="truncate text-sm font-semibold text-ink">{{ $uni->ad }}</div>
                    <div class="mt-0.5 flex items-center gap-1 text-xs text-ink-subtle">
                        <flux:icon name="map-pin" class="size-3" />
                        {{ $uni->sehir }} · {{ $uni->tur === 'vakif' ? 'Vakıf' : 'Devlet' }}
                    </div>
                </div>
            </div>
            <div class="flex shrink-0 flex-col items-end gap-1">
                <flux:badge :color="Analiz::ROZET[$s['durum']]" size="sm">{{ Analiz::ETIKET[$s['durum']] }}</flux:badge>
                <span class="inline-flex items-center gap-1 text-2xs font-medium text-brand">
                    <flux:icon name="check-badge" variant="solid" class="size-3" />Doğrulandı
                </span>
            </div>
        </div>

        {{-- Puansız yönergede "0 / 0 pt" bozuk görünüyordu: orada baraj yok,
             ilerleme koşul doluluğundan okunur. --}}
        <div class="mt-4">
            <div class="mb-1.5 flex items-center justify-between text-xs">
                <span class="text-ink-subtle">{{ $s['baraj'] === null ? 'Koşul karşılaması' : 'Puan karşılaması' }}</span>
                <span class="font-semibold text-ink-muted">
                    @if ($s['baraj'] === null)
                        Puan barajı yok · %{{ $s['puan_orani'] }}
                    @else
                        {{ $s['toplam'] }} / {{ $s['baraj'] }} pt · %{{ $s['puan_orani'] }}
                    @endif
                </span>
            </div>
            <div class="h-1.5 overflow-hidden rounded-full bg-line">
                <div class="baraj-cubuk h-full rounded-full" style="width: {{ $s['puan_orani'] }}%; background: {{ $renk }}"></div>
            </div>
        </div>

        <div @class(['mt-4 flex flex-col gap-1.5', 'flex-1' => $gorunum === 'grid'])>
            @foreach ($gosterilen as $kosul)
                <div class="flex items-center justify-between gap-2 text-xs">
                    <span class="flex min-w-0 items-center gap-1.5 text-ink-muted">
                        @if ($kosul->beyan && ! $kosul->beyanOnaylandi)
                            <flux:icon name="information-circle" class="size-3.5 shrink-0 text-ink-subtle" />
                        @else
                            <flux:icon :name="$kosul->durum->ikon()" variant="solid" class="size-3.5 shrink-0" style="color: {{ $kosul->durum->renk() }}" />
                        @endif
                        <span class="truncate" title="{{ $kosul->aciklama }}">{{ $kosul->aciklama }}</span>
                    </span>
                    {{-- Telafi ile geçilen koşulda sayaç ana yolu anlatır, sonucun rengiyle boyanmaz. --}}
                    <span class="shrink-0 font-semibold" style="color: {{ ($kosul->beyan && ! $kosul->beyanOnaylandi) || $kosul->telafiIleSaglandi() ? 'var(--color-ink-subtle)' : $kosul->durum->renk() }}">
                        @if ($kosul->kaynakEksik)
                            siz değerlendirin
                        @elseif ($kosul->beyanOnaylandi)
                            Kriter Onaylandı
                        @elseif ($kosul->beyan)
                            Kriter Onaylanmalı
                        @elseif ($kosul->telafiIleSaglandi())
                            telafi ile
                        @elseif ($kosul->gerekli !== null)
                            {{ $kosul->mevcut ?? 0 }} / {{ $kosul->gerekli }}
                        @else
                            {{ $kosul->durum->etiket() }}
                        @endif
                    </span>
                </div>
            @endforeach

            @if ($gizliSayi > 0)
                <div class="pt-0.5 text-xs font-medium text-ink-subtle">
                    +{{ $gizliSayi }} koşul daha
                </div>
            @endif
        </div>

        {{-- Üç satır, adayın yapacağı üç ayrı iş: veri girmek · kutu
             işaretlemek · kendi değerlendirmesini yapmak. Tek satırda
             toplanırsa aday nereye gideceğini bilmiyor. --}}
        @if ($s['belirsiz_sayisi'] > 0)
            <div class="mt-2 flex items-start gap-1 text-xs text-cat-purple">
                <flux:icon name="question-mark-circle" class="mt-px size-3 shrink-0" />
                <span>{{ $s['belirsiz_sayisi'] }} koşul için eksik bilgilerinizi tamamlamalısınız.</span>
            </div>
        @endif

        @if ($s['beyan_sayisi'] > 0)
            <div class="mt-2 flex items-start gap-1 text-xs text-ink-subtle">
                <flux:icon name="information-circle" class="mt-px size-3 shrink-0" />
                <span>{{ $s['beyan_sayisi'] }} koşul onayınızı bekliyor.</span>
            </div>
        @endif

        {{-- Cetvel eksikliği adayın yapabileceği bir şey DEĞİL; üstteki satırla
             karıştırılırsa aday olmayan bir kutuyu arar. --}}
        @if ($s['cetvel_eksigi_sayisi'] > 0)
            <div class="mt-2 flex items-start gap-1 text-xs text-ink-subtle">
                <flux:icon name="exclamation-circle" class="mt-px size-3 shrink-0 text-cat-amber-text" />
                <span>{{ $s['cetvel_eksigi_sayisi'] }} koşulu kendiniz değerlendirmelisiniz.</span>
            </div>
        @endif

        {{-- mt-auto: kartların içeriği farklı uzunlukta olduğu için ipucu
             satırı hepsinde kartın dibine hizalanır. --}}
        <div class="mt-auto flex items-center justify-center gap-1 pt-2 text-xs font-medium text-ink-subtle">
            <flux:icon name="arrows-pointing-out" class="size-3" />
            Detay için karta tıklayın
        </div>
    </div>
</flux:card>
