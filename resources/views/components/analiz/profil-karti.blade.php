@props([
    'onayliSayisi',
    'doluluk',
])

{{-- Mevcut Profilim (05_yonerge_analizi.html: navy zeminli) --}}
<div class="rounded-xl bg-navy p-4">
    <div class="mb-3 text-2xs font-semibold uppercase tracking-wider text-white/40">Mevcut Profilim</div>
    <div class="flex flex-col gap-1.5">
        <div class="flex items-center justify-between gap-2">
            <span class="shrink-0 text-xs text-white/55">Bölüm</span>
            <span class="truncate text-xs font-semibold text-white">{{ auth()->user()->bolum ?? '—' }}</span>
        </div>
        <div class="flex items-center justify-between gap-2">
            <span class="shrink-0 text-xs text-white/55">Temel Alan</span>
            <span class="truncate text-xs font-semibold text-white">{{ auth()->user()->temel_alan?->label() ?? '—' }}</span>
        </div>
        <div class="flex items-center justify-between gap-2">
            <span class="shrink-0 text-xs text-white/55">Unvan</span>
            <span class="truncate text-xs font-semibold text-white">{{ auth()->user()->unvan ?? '—' }}</span>
        </div>
        <div class="flex items-center justify-between gap-2">
            <span class="shrink-0 text-xs text-white/55">Üniversite</span>
            <span class="truncate text-xs font-semibold text-white">{{ auth()->user()->universite ?? '—' }}</span>
        </div>
    </div>
    <div class="my-3 h-px bg-white/10"></div>
    {{-- Tek bir "toplam puan" yok: her yönerge kendi cetveliyle puanlıyor.
         Onun yerine değerlendirmenin kesinliğini belirleyen iki girdi
         gösteriliyor. --}}
    <div class="flex items-baseline justify-between">
        <span class="shrink-0 text-xs text-white/55">Onaylı Faaliyet</span>
        <span class="font-serif text-2xl font-bold text-gold">{{ $onayliSayisi }}</span>
    </div>
    <div class="mt-2 flex items-baseline justify-between">
        <span class="shrink-0 text-xs text-white/55">Akademik Profil</span>
        <span class="font-serif text-lg font-bold text-white">%{{ $doluluk }}</span>
    </div>
    <div class="mt-1.5 h-1 overflow-hidden rounded-full bg-white/10">
        <div class="baraj-cubuk h-full rounded-full bg-gold" style="width: {{ $doluluk }}%"></div>
    </div>
    @if ($doluluk < 100)
        <a href="{{ route('profile.edit') }}" wire:navigate
            class="mt-2 flex items-center gap-1 text-xs font-medium text-gold/80 transition hover:text-gold">
            <flux:icon name="pencil-square" class="size-3" />
            Eksik bilgileri tamamla
        </a>
    @endif
</div>
