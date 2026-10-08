@props(['aktif' => null, 'heading' => null, 'subheading' => null])

<div class="flex items-start max-md:flex-col">
    <div class="me-10 w-full pb-4 md:w-[220px]">
        <flux:navlist aria-label="{{ __('Settings') }}">
            {{-- Seçili öğe sayfanın verdiği `aktif` ile işaretleniyor: Flux'un
                 kendi tespiti tutmuyordu, rota adına bakmak da Livewire
                 güncellemesinde (istek livewire/update'ten gelir) işareti
                 kaybederdi. --}}
            <flux:navlist.item :href="route('profile.edit')" :current="$aktif === 'profil'" wire:navigate>{{ __('Profile') }}</flux:navlist.item>
            <flux:navlist.item :href="route('security.edit')" :current="$aktif === 'guvenlik'" wire:navigate>{{ __('Security') }}</flux:navlist.item>
        </flux:navlist>
    </div>

    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
        <flux:heading>{{ $heading ?? '' }}</flux:heading>
        <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>

        {{-- Tam genişlik. Başlangıç kitindeki max-w-lg (512px) kısa bir
             ad/e-posta formu içindi; akademik profil formu o dar sütunda
             ekranın üçte birine sıkışıyordu. Kısa formlar (şifre) kendi
             genişliğini sınırlıyor. --}}
        <div class="mt-5 w-full">
            {{ $slot }}
        </div>
    </div>
</div>
