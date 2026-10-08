{{--
    Kullanıcı avatarı — profil fotoğrafı ya da baş harfler.

    Kenar çubuğu Livewire bileşeni değil; fotoğraf profil ayarlarında
    yüklenince `profil-foto-guncellendi` olayıyla güncelleniyor, sayfa
    yenilenmeden. İlk çizim sunucudan doğru hâliyle geliyor (x-show + inline
    display), Alpine yüklenene kadar yanlış hâl yanıp sönmüyor.
--}}
@php
    $kullanici = auth()->user();
    $adres = $kullanici->profilFotoAdresi();
@endphp

<span x-data="{ adres: @js($adres) }"
    x-on:profil-foto-guncellendi.window="adres = $event.detail.adres"
    {{ $attributes->class('flex size-full items-center justify-center') }}>
    <img x-show="adres" :src="adres" @if ($adres) src="{{ $adres }}" @else style="display: none" @endif
        alt="" class="size-full rounded-full object-cover">
    <span x-show="! adres" @if ($adres) style="display: none" @endif>{{ $kullanici->initials() }}</span>
</span>
