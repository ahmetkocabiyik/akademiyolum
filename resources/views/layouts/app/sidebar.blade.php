<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-canvas">
        <flux:sidebar sticky collapsible="mobile" class="sidebar-dark border-e border-white/10 bg-navy !gap-0 !p-0">
            <flux:sidebar.header class="border-b border-white/[0.07] px-5 pt-[18px] pb-4">
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <nav class="sb-nav">
                <div class="sb-sect">{{ __('Ana Menü') }}</div>
                <a href="{{ route('dashboard') }}" wire:navigate @class(['sb-link', 'active' => request()->routeIs('dashboard')])>
                    <flux:icon name="squares-2x2" />
                    <span>{{ __('Dashboard') }}</span>
                </a>
                <a href="{{ route('faaliyetler') }}" wire:navigate @class(['sb-link', 'active' => request()->routeIs('faaliyetler*')])>
                    <flux:icon name="clipboard-document-list" />
                    <span>{{ __('Faaliyetler') }}</span>
                </a>

                <div class="sb-sect">{{ __('Analiz') }}</div>
                <a href="{{ route('yonerge-analizi') }}" wire:navigate @class(['sb-link', 'active' => request()->routeIs('yonerge-analizi')])>
                    <flux:icon name="document-magnifying-glass" />
                    <span>{{ __('Yönerge Analizi') }}</span>
                </a>
                <a href="{{ route('yz-danisman') }}" wire:navigate @class(['sb-link', 'active' => request()->routeIs('yz-danisman')])>
                    <flux:icon name="sparkles" />
                    <span>{{ __('YZ Danışman') }}</span>
                </a>
                <a href="{{ route('juri-analizi') }}" wire:navigate @class(['sb-link', 'active' => request()->routeIs('juri-analizi')])>
                    <flux:icon name="scale" />
                    <span>{{ __('YZ Jüri Analizi') }}</span>
                </a>

                <div class="sb-sect">{{ __('Çıktılar') }}</div>
                <a href="{{ route('cv-olusturucu') }}" wire:navigate @class(['sb-link', 'active' => request()->routeIs('cv-olusturucu')])>
                    <flux:icon name="identification" />
                    <span>{{ __('CV Oluşturucu') }}</span>
                </a>
                <a href="{{ route('cikti-yonetimi') }}" wire:navigate @class(['sb-link', 'active' => request()->routeIs('cikti-yonetimi')])>
                    <flux:icon name="arrow-down-tray" />
                    <span>{{ __('Çıktı Yönetimi') }}</span>
                </a>
            </nav>

            <flux:dropdown position="top" align="start">
                <button type="button" class="sb-user" data-test="sidebar-menu-button">
                    <div class="sb-avatar"><x-kullanici-avatari /></div>
                    <div class="min-w-0 flex-1">
                        <div class="sb-name truncate">{{ auth()->user()->name }}</div>
                        <div class="sb-uni truncate">{{ auth()->user()->universite ?? auth()->user()->email }}</div>
                    </div>
                    <flux:icon name="chevron-up-down" class="size-4 shrink-0 text-white/40" />
                </button>

                <flux:menu class="app-user-menu">
                    <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                        {{ __('Settings') }}
                    </flux:menu.item>

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
        </flux:sidebar>

        <!-- Mobile Header -->
        <flux:header class="sidebar-dark border-b border-white/10 bg-navy lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <x-app-logo :sidebar="true" :href="route('dashboard')" wire:navigate class="ms-1" />

            <flux:spacer />

            <flux:dropdown position="bottom" align="end">
                <button type="button" class="sb-avatar !size-9" data-test="mobile-menu-button"><x-kullanici-avatari /></button>

                <flux:menu class="app-user-menu">
                    <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                        <flux:avatar circle :name="auth()->user()->name" :initials="auth()->user()->initials()" :src="auth()->user()->profilFotoAdresi()" />
                        <div class="grid flex-1 text-start text-sm leading-tight">
                            <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                            <flux:text class="truncate">{{ auth()->user()->universite ?? auth()->user()->email }}</flux:text>
                        </div>
                    </div>

                    <flux:menu.separator />

                    <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                        {{ __('Settings') }}
                    </flux:menu.item>

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
