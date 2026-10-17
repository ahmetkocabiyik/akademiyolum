{{--
    Akademik profil eksikse HER sayfada (profil sayfası hariç; orada alanlar
    işaretli). Kapatılamaz: boş alan, adayın kendi yönergesindeki koşulu
    "belirsiz" bırakıyor, puan ve durum eksik hesaplanıyor.
    Hangi alanların gerektiği: App\Services\Scoring\Sart\ProfilGereksinimleri.
--}}
@php
    $kullanici = auth()->user();
    $eksikAlanlar = $kullanici?->hasCompletedOnboarding() && ! request()->routeIs('profile.edit')
        ? app(\App\Services\Scoring\Sart\ProfilGereksinimleri::class)->eksikler($kullanici)
        : [];
@endphp

@if ($eksikAlanlar !== [])
    {{-- Taklit şeridi gibi tam genişlik: sayfaların üst çubuğu (x-topbar) da
         main dolgusundan taşıyor; şerit kart olsaydı çubuk üstüne binerdi. --}}
    <div data-profil-eksik class="-mx-6 -mt-6 mb-6 flex flex-col gap-3 border-b border-cat-amber/40 bg-cat-amber-light px-6 py-3 text-sm sm:flex-row sm:items-center lg:-mx-8 lg:-mt-8 lg:mb-8 lg:px-8">
        <flux:icon name="exclamation-triangle" class="size-5 shrink-0 text-cat-amber-text max-sm:hidden" />
        <div class="min-w-0 flex-1">
            <div class="font-semibold text-ink">Akademik profiliniz eksik; hesaplamalar doğru yapılamıyor.</div>
            <div class="mt-0.5 text-ink-muted">
                Yönergenizdeki koşullar bu bilgilere bağlı:
                <span class="font-medium text-ink">{{ implode(', ', $eksikAlanlar) }}</span>.
                Girilmeyen bilgiye bağlı koşul “belirsiz” sayılır.
            </div>
        </div>
        <flux:button :href="route('profile.edit').'#akademik-profil'" variant="primary" size="sm" class="shrink-0">
            Profili tamamla
        </flux:button>
    </div>
@endif
