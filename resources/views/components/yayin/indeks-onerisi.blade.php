@props(['oneri', 'slug' => null])

{{--
    Dergi indeksi önerisi.

    Bilerek İKİ KATMANLI: üstte tek tıkla uygulanabilen öneri, altta derginin
    HAM dizin listesi. Aday öneriye katılmazsa listeden kendi kararını verir;
    kutu ona "sistem bunu nereden çıkardı" sorusunu da cevaplıyor.

    DergiPark'ın kendi uyarısı da aktarılıyor — sayfasının başında yazılı:
    dizin güncelliğinden sorumlu değiller.
--}}
@php $o = $oneri; @endphp

<div class="rounded-xl border border-line bg-canvas p-3">
    <div class="mb-2 flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-wider text-ink-subtle">
        <flux:icon name="sparkles" class="size-3.5" />Dergi İndeksi
    </div>

    @if ($o['kaynak'])
        <div class="flex flex-wrap items-center gap-2">
            <flux:badge color="green" size="sm">{{ $o['kaynak'] }}</flux:badge>
            <flux:text class="!text-xs flex-1">{{ $o['gerekce'] }}</flux:text>
            <flux:button wire:click="oneriyiUygula" size="xs" variant="primary">Uygula</flux:button>
        </div>
    @elseif ($o['uyari'])
        <flux:text class="!text-xs flex items-start gap-1.5">
            <flux:icon name="exclamation-circle" class="mt-0.5 size-3.5 shrink-0 text-cat-amber-text" />
            <span>{{ $o['uyari'] }}</span>
        </flux:text>
    @elseif ($o['slug'] === null)
        <flux:text class="!text-xs text-ink-subtle">
            Bu dergi DergiPark'ta bulunamadı; kademeyi aşağıdan kendiniz seçin.
        </flux:text>
    @else
        <flux:text class="!text-xs text-ink-subtle">
            DergiPark bu dergiyi puana esas bir atıf dizininde (SCIE, ESCI, Scopus, TR Dizin)
            listelemiyor; kademeyi aşağıdan kendiniz seçin.
        </flux:text>
    @endif

    @if ($o['atif'] || $o['diger'])
        <div class="mt-3 flex flex-col gap-2 border-t border-line pt-2.5">
            @foreach ([['Atıf dizinleri', $o['atif'], true], ['Diğer dizinler', $o['diger'], false]] as [$baslik, $adlar, $vurgulu])
                @if ($adlar)
                    <div class="flex flex-wrap items-baseline gap-1.5">
                        <span class="text-[10px] uppercase tracking-wide text-ink-subtle">{{ $baslik }}:</span>
                        @foreach ($adlar as $ad)
                            <flux:badge size="sm" :color="$vurgulu ? 'blue' : 'zinc'">{{ $ad }}</flux:badge>
                        @endforeach
                    </div>
                @endif
            @endforeach

            <flux:text class="!text-[11px] text-ink-subtle">
                Kaynak:
                <a href="https://dergipark.org.tr/tr/pub/{{ $o['slug'] }}/indexes" target="_blank" rel="noopener"
                    class="underline hover:text-brand">DergiPark dizin sayfası</a>.
                DergiPark'ın kendi notu: “Her veri tabanından dergilerin dizin güncelliği kontrol edilmelidir.”
            </flux:text>
        </div>
    @endif
</div>
