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

            {{-- Üniversite: yazılabilir seçim kutusu (bkz. components/combobox). --}}
            <x-combobox model="universite" :secenekler="$universiteler"
                label="Üniversite" placeholder="Üniversite adı yazın..." />

            {{-- Program bazlı yönergelerde (ör. Sabancı) aynı temel alanda birden
                 çok kriter bloğu var; doğru olanı ancak program seçilirse bulunur.
                 Seçenekler yönerge verisinden gelir, o yüzden yalnızca gerçekten
                 programa göre yazılmış yönergesi olan üniversitelerde çıkar. --}}
            @if ($birimler)
                <flux:select wire:model="birim" label="Program" placeholder="Program seçin..."
                    description="{{ auth()->user()->universite }} yönergesi kriterleri programa göre belirliyor. Başka üniversitelerin programı Yönerge Analizi ekranında ayrıca sorulur; birim adları üniversiteden üniversiteye değiştiği için buradaki seçim onlara taşınmaz.">
                    <flux:select.option value="">Belirtilmemiş</flux:select.option>
                    @foreach ($birimler as $b)
                        <flux:select.option :value="$b">{{ $b }}</flux:select.option>
                    @endforeach
                </flux:select>
            @endif

            {{-- Yalnızca kimlik bilgisi değil: Yönerge Analizi varsayılan hedef
                 kadroyu bundan türetiyor (Dr. Öğr. Üyesi → doçentlik gibi). --}}
            <flux:select wire:model="unvan" label="Akademik Unvan" placeholder="Unvan seçin..."
                description="Yönerge analizinde varsayılan hedef kadronuz buna göre belirlenir.">
                <flux:select.option value="">Belirtilmemiş</flux:select.option>
                @foreach ($unvanlar as $u)
                    <flux:select.option :value="$u">{{ $u }}</flux:select.option>
                @endforeach
            </flux:select>

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

            <flux:separator variant="subtle" />

            {{-- Akademik profil: yönerge analizindeki dönem ve sayaç koşullarının
                 girdisi. Boş bırakılan alan koşulu "sağlanmadı" yapmaz; o koşul
                 "belirsiz" olarak işaretlenir. --}}
            <div>
                <flux:heading size="sm">Akademik Profil</flux:heading>
                <flux:text class="!mt-1 !text-xs">
                    Yönerge analizi bu değerleri kullanır. Boş bıraktığınız her alan, ona bağlı koşulu
                    <strong>belirsiz</strong> bırakır ve üniversite <strong>“Kriter Onaylanmalı”</strong> olarak
                    işaretlenir — koşul sağlanmamış sayılmaz, değerlendirilemez.
                </flux:text>
                <div class="mt-3 flex items-start gap-2 rounded-xl border border-line bg-canvas p-3">
                    <flux:icon name="information-circle" class="mt-px size-4 shrink-0 text-ink-subtle" />
                    <flux:text class="!text-xs leading-relaxed">
                        <strong>Atıf, proje ve tez danışmanlığı sayıları burada girilmez.</strong>
                        Bunlar <a href="{{ route('faaliyetler') }}" wire:navigate class="font-medium text-brand underline">Faaliyetler</a>
                        bölümüne eklediğiniz kayıtlardan sayılır — projeyi eklerken fon kaynağını ve
                        rolünüzü (yürütücü / araştırmacı / danışman) seçmeniz yeterli.
                    </flux:text>
                </div>
            </div>

            <flux:select wire:model="akademik.program_dili" label="Biriminizin öğretim dili"
                description="Yabancı dil barajı buna göre değişir (ör. Türkçe 65, %100 yabancı dilde 85).">
                <flux:select.option value="">Seçiniz</flux:select.option>
                @foreach ($programDilleri as $deger => $etiket)
                    <flux:select.option :value="$deger">{{ $etiket }}</flux:select.option>
                @endforeach
            </flux:select>

            <div class="grid gap-4 sm:grid-cols-2">
                @foreach ($akademikAlanlar as $alan => [$etiket, $tip, $ipucu])
                    <flux:input
                        wire:key="akademik-{{ $alan }}"
                        wire:model="akademik.{{ $alan }}"
                        :type="$tip"
                        :label="$etiket"
                        :description="$ipucu ?: null"
                        :min="$tip === 'number' ? 0 : null"
                        placeholder="—" />
                @endforeach
            </div>

            <div class="flex items-center gap-4">
                <flux:button variant="primary" type="submit">{{ __('Save') }}</flux:button>
            </div>
        </form>

        @if ($this->showDeleteUser)
            <livewire:settings.delete-user-form />
        @endif
    </x-settings.layout>
</section>
