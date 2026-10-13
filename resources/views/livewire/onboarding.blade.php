<div class="flex w-full flex-col gap-6">
    {{-- Stepper --}}
    <div class="flex items-center justify-center gap-2">
        @foreach (['Profil', 'Kurum & Alan', 'Paket'] as $i => $label)
            @php($n = $i + 1)
            <div class="flex items-center gap-2">
                <div @class([
                    'flex size-7 items-center justify-center rounded-full text-xs font-semibold transition',
                    'bg-brand text-white' => $step >= $n,
                    'bg-zinc-200 text-zinc-500' => $step < $n,
                ])>
                    @if ($step > $n)
                        <flux:icon name="check" class="size-4" />
                    @else
                        {{ $n }}
                    @endif
                </div>
                <span @class([
                    'hidden text-sm sm:block',
                    'font-medium text-zinc-900' => $step === $n,
                    'text-zinc-400' => $step !== $n,
                ])>{{ $label }}</span>
                @unless ($loop->last)
                    {{-- Bağlantı çizgisi adım geçildikçe soldan dolar. --}}
                    <div class="relative h-px w-6 overflow-hidden bg-zinc-200 sm:w-10">
                        <div class="absolute inset-y-0 start-0 bg-brand transition-[width] duration-[var(--dur-yavas)] ease-[var(--ease-cikis)]"
                            style="width: {{ $step > $n ? '100%' : '0' }}"></div>
                    </div>
                @endunless
            </div>
        @endforeach
    </div>

    {{-- Step 1: Profil --}}
    @if ($step === 1)
        <div class="flex flex-col gap-5" wire:key="adim-1" data-adim="{{ $yon }}">
            <div class="text-center">
                <flux:heading size="lg">Hoş geldiniz 👋</flux:heading>
                <flux:text class="mt-1">Kariyer analiziniz için birkaç bilgiye ihtiyacımız var.</flux:text>
            </div>

            <flux:input wire:model="name" label="Ad Soyad" placeholder="Örn. Ahmet Kocabıyık" />

            <x-secim-listesi model="unvan" label="Akademik Unvan" placeholder="Unvan seçin" :secenekler="array_combine($unvanlar, $unvanlar)" />

            <flux:button variant="primary" wire:click="next" class="w-full">Devam Et</flux:button>
        </div>
    @endif

    {{-- Step 2: Kurum & Alan --}}
    @if ($step === 2)
        <div class="flex flex-col gap-5" wire:key="adim-2" data-adim="{{ $yon }}">
            <div class="text-center">
                <flux:heading size="lg">Kurum ve Alanınız</flux:heading>
                <flux:text class="mt-1">Yönerge eşleştirmesi bu bilgilere göre yapılır.</flux:text>
            </div>

            {{-- Üniversite: yazılabilir seçim kutusu (bkz. components/combobox).
                 Seçilince sunucuya gider; fakülte listesi ona göre gelir. --}}
            <x-combobox model="universite" :secenekler="$universiteler" gonder
                label="Üniversite" placeholder="Üniversite adı yazın..." />

            @include('partials.temel-alan-secimi')

            @include('partials.fakulte-bolum-secimi')

            <flux:input wire:model="orcid" label="ORCID (opsiyonel)" placeholder="0000-0000-0000-0000" />

            <div class="flex gap-3">
                <flux:button wire:click="back" class="flex-1">Geri</flux:button>
                <flux:button variant="primary" wire:click="next" class="flex-1">Devam Et</flux:button>
            </div>
        </div>
    @endif

    {{-- Step 3: Paket. Online ödeme yok: ücretli seçim yöneticiye talep
         olarak düşer, kullanıcı bu sırada ücretsiz planda devam eder. --}}
    @if ($step === 3)
        @php($secili = $this->paketler->get($paket))
        <div class="flex flex-col gap-5" wire:key="adim-3" data-adim="{{ $yon }}">
            <div class="text-center">
                <flux:heading size="lg">Paketinizi Seçin</flux:heading>
                <flux:text class="mt-1">Ücretsiz başlayabilir, dilediğiniz zaman yükseltebilirsiniz.</flux:text>
            </div>

            <x-paket-secimi :paketler="$this->paketler" :secili="$paket" />

            @if ($secili && $secili->aylik_fiyat_kurus > 0)
                @if ($secili->yillik_fiyat_kurus !== null)
                    <flux:radio.group wire:model.live="donem" label="Ödeme dönemi" variant="segmented">
                        <flux:radio value="aylik" label="Aylık · {{ \App\Models\Paket::fiyatMetni($secili->aylik_fiyat_kurus) }}" />
                        <flux:radio value="yillik" label="Yıllık · {{ \App\Models\Paket::fiyatMetni($secili->yillik_fiyat_kurus) }}{{ $secili->yillikIndirim() ? ' (%'.$secili->yillikIndirim().' indirim)' : '' }}" />
                    </flux:radio.group>
                @endif

                <div class="flex items-start gap-2.5 rounded-lg bg-canvas p-3 text-sm text-ink-muted">
                    <flux:icon name="information-circle" class="mt-0.5 size-5 shrink-0 text-brand" />
                    <span>
                        Talebiniz bize iletilir; ödeme bilgilerini e-postayla göndeririz. Ödeme alındığında
                        <strong class="text-ink">{{ $secili->ad }}</strong> paketiniz tanımlanır. Bu sırada uygulamayı ücretsiz kullanmaya devam edersiniz.
                    </span>
                </div>
            @endif

            <flux:error name="paket" />
            <flux:error name="donem" />

            <div class="flex gap-3">
                <flux:button wire:click="back" class="flex-1">Geri</flux:button>
                <flux:button variant="primary" wire:click="submit" class="flex-1">
                    {{ $secili && $secili->aylik_fiyat_kurus > 0 ? 'Talep Et ve Tamamla' : 'Kurulumu Tamamla' }}
                </flux:button>
            </div>
        </div>
    @endif

    {{-- Alt bilgi: ana sayfa / çıkış --}}
    <div class="flex items-center justify-center gap-3 text-xs text-zinc-400">
        <a href="{{ route('home') }}" wire:navigate class="transition hover:text-zinc-600">← Ana sayfa</a>
        <span class="text-zinc-300">·</span>
        <button type="button" wire:click="cikis" class="transition hover:text-zinc-600">Çıkış yap</button>
    </div>
</div>
