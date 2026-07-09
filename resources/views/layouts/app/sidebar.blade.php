<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-canvas">
        <flux:sidebar sticky collapsible="mobile" class="sidebar-dark border-e border-white/10 bg-navy [&_[data-flux-sidebar-brand]]:text-white">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Ana Menü')" class="grid">
                    <flux:sidebar.item icon="squares-2x2" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="document-text" :href="route('yayinlar')" :current="request()->routeIs('yayinlar')" wire:navigate>
                        {{ __('Yayınlar') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="heart" :href="route('toplumsal-katki')" :current="request()->routeIs('toplumsal-katki')" wire:navigate>
                        {{ __('Toplumsal Katkı') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group :heading="__('Analiz')" class="grid">
                    <flux:sidebar.item icon="document-magnifying-glass" :href="route('yonerge-analizi')" :current="request()->routeIs('yonerge-analizi')" wire:navigate>
                        {{ __('Yönerge Analizi') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="sparkles" :href="route('yz-danisman')" :current="request()->routeIs('yz-danisman')" wire:navigate>
                        {{ __('YZ Danışman') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="scale" :href="route('juri-analizi')" :current="request()->routeIs('juri-analizi')" wire:navigate>
                        {{ __('YZ Jüri Analizi') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group :heading="__('Çıktılar')" class="grid">
                    <flux:sidebar.item icon="identification" :href="route('cv-olusturucu')" :current="request()->routeIs('cv-olusturucu')" wire:navigate>
                        {{ __('CV Oluşturucu') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="arrow-down-tray" :href="route('cikti-yonetimi')" :current="request()->routeIs('cikti-yonetimi')" wire:navigate>
                        {{ __('Çıktı Yönetimi') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    circle
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu class="app-user-menu">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    circle
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
