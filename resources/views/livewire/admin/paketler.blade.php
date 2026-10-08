@use('App\Enums\Plan')
@use('App\Models\Paket')

<div>
    <x-topbar title="Paketler">
        <flux:button :href="url('/').'#pricing'" target="_blank" variant="ghost" icon="arrow-top-right-on-square">Tanıtım sayfasında gör</flux:button>
    </x-topbar>

    <flux:text class="mb-4">
        Burada yapılan değişiklik tanıtım sayfasındaki fiyat kartlarına ve abonelik atarken önerilen tutara yansır.
        Mevcut abonelikler etkilenmez; her abonelik ödenen tutarı kendisi tutar.
    </flux:text>

    <div class="grid gap-6 xl:grid-cols-3">
        @foreach ($planlar as $plan)
            @php
                $form = $paketler[$plan->value];
                $ucretsiz = $plan === Plan::Ucretsiz;
                $aylik = is_numeric($form['aylik']) ? (int) round((float) $form['aylik'] * 100) : 0;
                $yillik = is_numeric($form['yillik']) ? (int) round((float) $form['yillik'] * 100) : null;
                $indirim = $yillik !== null && $aylik > 0 && $yillik < $aylik * 12 ? (int) round(100 - $yillik / ($aylik * 12) * 100) : null;
            @endphp

            <flux:card wire:key="paket-{{ $plan->value }}" class="flex flex-col gap-4">
                <div class="flex items-center justify-between gap-2">
                    <flux:heading size="lg">{{ $form['ad'] ?: '—' }}</flux:heading>
                    <div class="flex gap-1">
                        @if ($form['one_cikan'])<flux:badge color="blue" size="sm">En Popüler</flux:badge>@endif
                        <flux:badge :color="$form['satista'] ? 'green' : 'zinc'" size="sm">{{ $form['satista'] ? 'Satışta' : 'Satışta değil' }}</flux:badge>
                    </div>
                </div>

                <form wire:submit="kaydet('{{ $plan->value }}')" class="flex flex-col gap-4">
                    <flux:input wire:model.live.debounce.400ms="paketler.{{ $plan->value }}.ad" label="Paket adı" />
                    <flux:input wire:model="paketler.{{ $plan->value }}.aciklama" label="Kısa açıklama" placeholder="Ör. Aktif kariyer yönetimi için." />

                    @if ($ucretsiz)
                        <flux:text class="!text-sm">Ücretsiz paketin fiyatı her zaman ₺0; aboneliği olmayan kullanıcı bu paketi kullanır.</flux:text>
                    @else
                        <div class="grid grid-cols-2 gap-3">
                            <flux:input wire:model.live.debounce.400ms="paketler.{{ $plan->value }}.aylik" type="number" step="0.01" min="0" label="Aylık fiyat (₺)" />
                            <flux:input wire:model.live.debounce.400ms="paketler.{{ $plan->value }}.yillik" type="number" step="0.01" min="0" label="Yıllık fiyat (₺)" placeholder="İsteğe bağlı" />
                        </div>
                        <flux:text class="-mt-2 !text-xs">
                            @if ($yillik !== null)
                                12 ay × aylık = {{ Paket::fiyatMetni($aylik * 12) }}.
                                {{ $indirim !== null ? "Yıllıkta %{$indirim} indirim." : 'Yıllık fiyat indirimsiz.' }}
                            @else
                                Yıllık fiyat boşsa 12 aylık abonelikte {{ Paket::fiyatMetni($aylik * 12) }} (12 × aylık) önerilir.
                            @endif
                        </flux:text>
                    @endif

                    <flux:textarea wire:model="paketler.{{ $plan->value }}.ozellikler" label="Özellikler" rows="6"
                        description:trailing="Her satır bir madde; tanıtım sayfasında ✓ ile listelenir." />

                    <flux:input wire:model="paketler.{{ $plan->value }}.buton_metni" label="Buton metni" />

                    <div class="flex flex-col gap-3 rounded-lg border border-line p-3">
                        <flux:switch wire:model.live="paketler.{{ $plan->value }}.satista" label="Satışta"
                            description="Kapalıyken tanıtım sayfasında görünmez; mevcut aboneler etkilenmez." />
                        <flux:switch wire:model.live="paketler.{{ $plan->value }}.one_cikan" label="En Popüler rozeti" />
                    </div>

                    <flux:button type="submit" variant="primary" icon="check">Kaydet</flux:button>
                </form>
            </flux:card>
        @endforeach
    </div>
</div>
