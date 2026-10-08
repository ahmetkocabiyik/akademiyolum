@props([
    'adayNotu',
    'kapsamNotu',
    'hesaplanamayan',
    'beyanlar',
])

{{--
    Bu yönerge hakkında bilinmesi gerekenler.

    `$esik['notlar']` BİLİNÇLİ OLARAK gösterilmiyor: o alan bizim denetim izimiz
    — yönergeden birebir alıntılar ve madde kodları içeriyor (2.a-ç/h,ı,
    Tablo-1 [C] gibi). Adaya gösterilecek metin elle yazılan `aday_notu`, kapsam
    sınırları ise motordan türetiliyor; böylece uyarılar veriyle birlikte güncel
    kalıyor.
--}}
<div class="rounded-xl border border-line bg-canvas p-3">
    <div class="mb-2 flex items-center gap-1.5 text-2xs font-semibold uppercase tracking-wider text-ink-subtle">
        <flux:icon name="light-bulb" class="size-3.5" />Bu Yönerge Hakkında
    </div>

    <div class="flex flex-col gap-2 text-xs leading-relaxed text-ink-muted">
        @if ($adayNotu)
            <p>{{ $adayNotu }}</p>
        @endif

        @if ($beyanlar)
            <p class="flex items-start gap-1.5">
                <flux:icon name="information-circle" class="mt-0.5 size-3.5 shrink-0 text-ink-subtle" />
                <span><strong class="text-ink">{{ count($beyanlar) }} koşul</strong> otomatik doğrulanamıyor;
                başvuru dosyanıza belge eklemeniz gerekecek.</span>
            </p>
        @endif

        @if ($hesaplanamayan)
            <p class="flex items-start gap-1.5">
                <flux:icon name="exclamation-circle" class="mt-0.5 size-3.5 shrink-0 text-cat-amber-text" />
                <span><strong class="text-ink">{{ count($hesaplanamayan) }} koşulun</strong> dayandığı puan cetveli
                henüz sisteme eklenmedi; o koşulları kendiniz değerlendirmelisiniz.</span>
            </p>
        @endif

        @if ($kapsamNotu)
            <p class="flex items-start gap-1.5">
                <flux:icon name="calculator" class="mt-0.5 size-3.5 shrink-0 text-ink-subtle" />
                <span>{{ $kapsamNotu }}</span>
            </p>
        @endif
    </div>
</div>
