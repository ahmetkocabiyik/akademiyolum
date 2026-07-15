<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Profile settings') }}</flux:heading>

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                @if ($this->hasUnverifiedEmail)
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>

                    </div>
                @endif
            </div>

            <flux:separator variant="subtle" />

            <flux:heading size="sm">Akademik Bilgiler</flux:heading>

            {{-- Üniversite: yazılabilir combobox (client-side filtre) --}}
            <div
                x-data="{
                    sorgu: @entangle('universite'),
                    acik: false,
                    vurgu: -1,
                    tumu: @js($universiteler),
                    get sonuclar() {
                        const q = (this.sorgu || '').toLocaleLowerCase('tr');
                        const liste = q ? this.tumu.filter(u => u.toLocaleLowerCase('tr').includes(q)) : this.tumu;
                        return liste.slice(0, 8);
                    },
                    sec(u) { this.sorgu = u; this.acik = false; this.vurgu = -1; },
                    asagi() { this.acik = true; if (this.vurgu < this.sonuclar.length - 1) this.vurgu++; },
                    yukari() { if (this.vurgu > 0) this.vurgu--; },
                    enter() { if (this.acik && this.vurgu >= 0 && this.sonuclar[this.vurgu]) { this.sec(this.sonuclar[this.vurgu]); } else { this.acik = false; } },
                }"
                @click.outside="acik = false"
                x-on:keydown.escape="acik = false"
                class="relative"
            >
                <flux:input
                    label="Üniversite"
                    placeholder="Üniversite adı yazın..."
                    x-model="sorgu"
                    x-on:focus="acik = true"
                    x-on:input="acik = true; vurgu = -1"
                    x-on:keydown.arrow-down.prevent="asagi()"
                    x-on:keydown.arrow-up.prevent="yukari()"
                    x-on:keydown.enter.prevent="enter()"
                    autocomplete="off"
                />

                <div x-show="acik && sonuclar.length" x-transition.opacity x-cloak
                    class="absolute z-20 mt-1 max-h-64 w-full overflow-auto rounded-lg border border-line bg-surface py-1 shadow-lg">
                    <template x-for="(u, idx) in sonuclar" :key="u">
                        <button type="button" @click="sec(u)" @mouseenter="vurgu = idx"
                            class="block w-full truncate px-3 py-2 text-start text-sm"
                            :class="vurgu === idx ? 'bg-brand-light text-brand' : 'text-ink'"
                            x-text="u"></button>
                    </template>
                </div>
            </div>

            <flux:select wire:model.live="temelAlan" label="Temel Alan (yönerge grubu)"
                description="Yönerge analizi buna göre yapılır. Fakülte seçenekleri de buna göre gelir.">
                @foreach ($temelAlanlar as $deger => $etiket)
                    <flux:select.option :value="$deger">{{ $etiket }}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:select wire:model.live="fakulte" label="Fakülte (opsiyonel)" placeholder="Fakülte seçin...">
                <flux:select.option value="">Seçiniz (opsiyonel)</flux:select.option>
                @foreach (\App\Enums\TemelAlan::from($temelAlan)->fakulteler() as $f)
                    <flux:select.option :value="$f">{{ $f }}</flux:select.option>
                @endforeach
            </flux:select>

            @if ($fakulte && count($bolumler[$fakulte] ?? []))
                <flux:select wire:model.live="bolum" label="Bölüm (opsiyonel)" placeholder="Bölüm seçin...">
                    <flux:select.option value="">Seçiniz (opsiyonel)</flux:select.option>
                    @foreach ($bolumler[$fakulte] as $b)
                        <flux:select.option :value="$b">{{ $b }}</flux:select.option>
                    @endforeach
                </flux:select>
            @endif

            <div class="flex items-center gap-4">
                <flux:button variant="primary" type="submit">{{ __('Save') }}</flux:button>
            </div>
        </form>

        @if ($this->showDeleteUser)
            <livewire:settings.delete-user-form />
        @endif
    </x-settings.layout>
</section>
