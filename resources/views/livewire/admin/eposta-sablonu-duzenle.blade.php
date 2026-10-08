<div>
    <x-topbar :title="$tur->etiket()">
        <flux:button :href="route('admin.eposta-sablonlari')" wire:navigate variant="ghost" icon="arrow-left">Şablonlar</flux:button>
    </x-topbar>

    <div class="grid gap-6 xl:grid-cols-2">
        {{-- DÜZENLEYİCİ --}}
        <div class="flex min-w-0 flex-col gap-4">
            <flux:card class="flex flex-col gap-4">
                <div>
                    <flux:text>{{ $tur->aciklama() }}</flux:text>
                    <flux:badge :color="$ozel ? 'blue' : 'zinc'" size="sm" class="mt-2">{{ $ozel ? 'Panelde düzenlendi' : 'Varsayılan metin' }}</flux:badge>
                </div>

                @if ($tur->kapatilabilir())
                    <flux:switch wire:model="aktif" label="Bu e-posta gönderilsin" description="Kapalıyken bu durumda hiç e-posta gitmez." />
                @endif

                <flux:input wire:model.live.debounce.400ms="konu" label="Konu" />

                <flux:textarea wire:model.live.debounce.400ms="govde" label="İçerik" rows="16" class="font-mono !text-sm"
                    description:trailing="Markdown: **kalın**, - madde, [bağlantı metni](adres). HTML yazılamaz." />

                @if ($this->bilinmeyenler !== [])
                    <div class="rounded-lg border border-cat-amber/40 bg-cat-amber-light px-3 py-2 text-sm text-cat-amber-text">
                        Bu şablonda tanımlı olmayan değişken:
                        @foreach ($this->bilinmeyenler as $ad)<code class="mx-0.5 font-semibold">{{ '{'.$ad.'}' }}</code>@endforeach
                        — mailde olduğu gibi görünür.
                    </div>
                @endif

                <div class="flex flex-wrap items-center gap-2">
                    <flux:button wire:click="kaydet" variant="primary" icon="check">Kaydet</flux:button>
                    <flux:button wire:click="testGonder" icon="paper-airplane">Kendime test gönder</flux:button>
                    @if ($ozel)
                        <flux:button wire:click="varsayilanaDon" wire:confirm="Panelde yaptığınız değişiklikler silinip varsayılan metne dönülsün mü?"
                            variant="ghost" icon="arrow-uturn-left" class="ms-auto">Varsayılana dön</flux:button>
                    @endif
                </div>
            </flux:card>

            <flux:card>
                <flux:heading size="sm">Kullanılabilen değişkenler</flux:heading>
                <flux:text class="!mt-0.5 !text-xs">Konuya ya da içeriğe yazın; gönderirken gerçek değerle değişir.</flux:text>
                <dl class="mt-3 grid gap-x-4 gap-y-2 text-sm sm:grid-cols-2">
                    @foreach ($tur->degiskenler() as $ad => $aciklama)
                        <div class="min-w-0">
                            <dt><code class="rounded bg-canvas px-1.5 py-0.5 text-xs font-semibold text-brand">{{ '{'.$ad.'}' }}</code></dt>
                            <dd class="mt-0.5 text-xs text-ink-subtle">{{ $aciklama }}</dd>
                        </div>
                    @endforeach
                </dl>
            </flux:card>
        </div>

        {{-- ÖNİZLEME: gerçek mail iskeleti, örnek değerlerle. iframe — mailin
             satır içi stilleri panel stilleriyle karışmasın. --}}
        <div class="min-w-0">
            <flux:card class="!p-0 xl:sticky xl:top-4">
                <div class="border-b border-line px-5 py-3">
                    <flux:heading size="sm">Önizleme</flux:heading>
                    <flux:text class="!mt-0.5 !text-xs">Örnek değerlerle · Konu: <strong class="text-ink">{{ app(\App\Services\Eposta\EpostaGonderici::class)->olustur($konu, '', $tur->ornekDegerler())->konu }}</strong></flux:text>
                </div>
                <iframe srcdoc="{{ $this->onizleme }}" title="E-posta önizlemesi" class="h-[640px] w-full rounded-b-xl" sandbox></iframe>
            </flux:card>
        </div>
    </div>
</div>
