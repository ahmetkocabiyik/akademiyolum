{{--
    Bir şart ağacı düğümünü özyinelemeli çizer.

    @param \App\Services\Scoring\Sart\SartSonucu $dugum
    @param int $derinlik  İç içe geçme seviyesi (girinti için)
    @param ?string $esikAnahtari  Verilirse beyan koşulları işaretlenebilir
                                  kutuya döner. Dashboard gibi salt okunur
                                  yerlerde null geçilir.
--}}
@props(['dugum', 'derinlik' => 0, 'esikAnahtari' => null])

@php
    $renk = $dugum->durum->renk();
    $birlestirici = $dugum->cocuklar !== [];
    $olculur = $dugum->gerekli !== null && ! $dugum->beyan;

    // Telafi devreye girdiyse düğümün sayacı ("0 / 1") karşılanmayan ANA yolu
    // anlatır; onu sonucun yeşiliyle boyamak "0/1 ama yeşil" çelişkisi üretiyor.
    $telafiIle = $dugum->telafiIleSaglandi();

    // Değer hiç girilmemişse mevcut null'dır; sayaçta "/1" diye boşluk bırakmak
    // yerine 0 gösterilir. Belirsizlik yine de renkten okunuyor.
    $mevcut = $dugum->mevcut ?? 0;

    // Sayaç zaten açığı gösteriyorsa gerekçe satırı tekrar olur. Yalnızca
    // sayacın anlatamadığı belirsizlikler yazılır (dönem kapsamı, öğretim dili,
    // eksik yazarlık rolü gibi).
    // `kaynak_eksik` beyanları işaretlenebilir DEĞİL: onlar adayın belgesiyle
    // değil bizim eksiğimizle ilgili (cetvel henüz girilmedi). İşaretlenseydi
    // aday kendi lehine bizim boşluğumuzu kapatmış olurdu.
    $beyanKutusu = $dugum->beyan && ! $dugum->kaynakEksik && $esikAnahtari !== null;

    $gerekceGoster = $dugum->belirsizlikNedeni
        && ! $dugum->beyan
        && ! ($olculur && $dugum->mevcut === null);
@endphp

<div @class(['flex flex-col gap-1.5', 'border-l border-line pl-3' => $derinlik > 0])>
    <div class="flex items-start justify-between gap-2 text-xs">
        <span class="flex min-w-0 items-start gap-1.5 text-ink-muted">
            @if ($beyanKutusu)
                {{-- Motor bu koşulu göremez; belge adayın elinde. İşaret koşulu
                     SAĞLANMIŞ saydırıyor, o yüzden gerçek bir onay kutusu. --}}
                <input type="checkbox"
                    @checked($dugum->beyanOnaylandi)
                    wire:click="beyanDegistir('{{ $esikAnahtari }}', '{{ $dugum->beyanAnahtari() }}')"
                    wire:loading.attr="disabled"
                    aria-label="{{ $dugum->aciklama }} — belgem var"
                    class="mt-px size-4 shrink-0 cursor-pointer rounded border-line text-brand focus:ring-brand" />
            @elseif ($dugum->beyan)
                <flux:icon name="information-circle" class="mt-px size-4 shrink-0 text-ink-subtle" />
            @else
                <flux:icon :name="$dugum->durum->ikon()" variant="solid" class="mt-px size-4 shrink-0" style="color: {{ $renk }}" />
            @endif
            <span @class(['min-w-0', 'font-semibold text-ink' => $birlestirici])>{{ $dugum->aciklama }}</span>
        </span>

        <span class="shrink-0 font-semibold" style="color: {{ ($dugum->beyan && ! $dugum->beyanOnaylandi) || $telafiIle ? 'var(--color-ink-subtle)' : $renk }}">
            @if ($dugum->kaynakEksik)
                hesaplanamıyor
            @elseif ($dugum->beyanOnaylandi)
                beyan edildi
            @elseif ($dugum->beyan)
                onay gerek
            @elseif ($telafiIle)
                {{ $mevcut }} / {{ $dugum->gerekli }} <span class="font-normal">· telafi ile</span>
            @elseif ($olculur)
                {{ $mevcut }} / {{ $dugum->gerekli }}
            @else
                {{ $dugum->durum->etiket() }}
            @endif
        </span>
    </div>

    @if ($olculur && ! $birlestirici)
        <div class="h-1 overflow-hidden rounded-full bg-line">
            <div class="h-full rounded-full" style="width: {{ $dugum->oran() }}%; background: {{ $renk }}"></div>
        </div>
    @endif

    {{--
        Koşulun kapsamı: hangi dergi/çalışma türleri sayılıyor (cetvelden
        türetilir) ve yönergenin kendi madde atfı. Aday madde kodunu bilmek
        zorunda değil; kod yalnızca izlenebilirlik için soluk gösterilir.
    --}}
    @if ($dugum->kapsam !== [] || $dugum->madde)
        <div class="flex flex-wrap items-center gap-1 pl-[22px] text-[10px] leading-tight">
            @foreach ($dugum->kapsam as $etiket)
                <span class="rounded bg-line px-1.5 py-0.5 text-ink-muted">{{ $etiket }}</span>
            @endforeach

            @if ($dugum->madde)
                <span class="text-ink-subtle">{{ $dugum->madde }}</span>
            @endif
        </div>
    @endif

    {{-- Sayacı yükselten eşdeğerlikler; aksi hâlde rakam sebepsiz artmış görünür. --}}
    @foreach ($dugum->donusumler as $donusum)
        <div class="flex items-center gap-1 text-[11px] text-ink-subtle">
            <flux:icon name="arrows-right-left" class="size-3 shrink-0" />
            {{ $donusum }}
        </div>
    @endforeach

    {{-- Belirsizlik, koşulun sağlanmadığı anlamına gelmez: veri eksik. --}}
    @if ($gerekceGoster)
        <div class="text-[11px] text-cat-amber-text">{{ $dugum->belirsizlikNedeni }}</div>
    @endif

    @if ($dugum->kaynakEksik)
        <div class="text-[11px] text-ink-subtle">
            Bu üniversite puanlamayı kendi cetveline değil harici bir ölçeğe dayandırıyor; o ölçek
            henüz sisteme eklenmediği için koşulu sizin değerlendirmeniz gerekiyor.
        </div>
    @elseif ($dugum->beyanOnaylandi)
        <div class="text-[11px] text-ink-subtle">Belgeniz olduğunu beyan ettiniz; koşul sağlanmış sayılıyor.</div>
    @elseif ($beyanKutusu)
        <div class="text-[11px] text-ink-subtle">Bu koşul otomatik doğrulanamaz. Belgeniz varsa kutuyu işaretleyin.</div>
    @elseif ($dugum->beyan)
        <div class="text-[11px] text-ink-subtle">Bu koşul otomatik doğrulanamaz, belgeyle teyit edilir.</div>
    @endif

    @foreach ($dugum->cocuklar as $i => $cocuk)
        <x-sart-dugum :dugum="$cocuk" :derinlik="$derinlik + 1" :esik-anahtari="$esikAnahtari" :wire:key="'dugum-'.$derinlik.'-'.$i" />
    @endforeach

    {{-- Telafi dalı: ana koşul sağlanmadığında yönergenin sunduğu alternatif. --}}
    @if ($dugum->telafi)
        <div class="rounded-lg border border-line bg-canvas p-2">
            <div class="mb-1 flex items-center gap-1 text-[10px] font-semibold uppercase tracking-wider text-ink-subtle">
                <flux:icon name="arrow-path-rounded-square" class="size-3" />
                {{ $dugum->telafiIleSaglandi() ? 'Telafi ile sağlandı' : 'Yönergenin sunduğu telafi' }}
            </div>
            <x-sart-dugum :dugum="$dugum->telafi" :derinlik="0" :esik-anahtari="$esikAnahtari" />
        </div>
    @endif
</div>
