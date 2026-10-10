@use('App\Enums\YzSaglayiciTuru')

<div>
    <x-topbar title="YZ Ayarları" />

    <flux:text class="mb-4">
        YZ Danışman ve YZ Jüri Analizi'nin hangi sağlayıcıyla çalışacağını seçin. Değişiklik bir sonraki
        YZ çağrısında geçerli olur. API anahtarları .env dosyasında tutulur; anahtarı tanımlı olmayan sağlayıcı seçilemez.
    </flux:text>

    <div class="grid gap-6 xl:grid-cols-2">
        @foreach ($ozellikler as $ozellik)
            @php
                $form = $ayarlar[$ozellik->value];
                $secili = YzSaglayiciTuru::tryFrom($form['saglayici']);
                $kayit = $kayitlar->get($ozellik->value);
            @endphp

            <flux:card wire:key="yz-{{ $ozellik->value }}" class="flex flex-col gap-4">
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <flux:heading size="lg">{{ $ozellik->etiket() }}</flux:heading>
                        <flux:text class="!text-sm">{{ $ozellik->aciklama() }}</flux:text>
                    </div>
                    <flux:badge :color="$kayit ? 'blue' : 'zinc'" size="sm">{{ $kayit ? 'Panelden seçildi' : '.env varsayılanı' }}</flux:badge>
                </div>

                <form wire:submit="kaydet('{{ $ozellik->value }}')" class="flex flex-col gap-4">
                    <flux:radio.group wire:model.live="ayarlar.{{ $ozellik->value }}.saglayici" label="Sağlayıcı" variant="cards" class="flex-col sm:flex-row">
                        @foreach ($saglayicilar as $saglayici)
                            <flux:radio :value="$saglayici->value" :label="$saglayici->etiket()" :disabled="! $saglayici->anahtarVar()"
                                :description="$saglayici->anahtarVar() ? ($saglayici->varsayilanModel() ? 'Varsayılan: '.$saglayici->varsayilanModel() : 'Anahtarsız, uydurma yanıt') : 'Anahtar tanımlı değil'" />
                        @endforeach
                    </flux:radio.group>

                    @if ($secili && $secili !== YzSaglayiciTuru::Stub)
                        <flux:input wire:model="ayarlar.{{ $ozellik->value }}.model" label="Model"
                            :placeholder="$secili->varsayilanModel()"
                            description:trailing="Boş bırakılırsa .env'deki varsayılan model kullanılır." />
                    @endif

                    @if ($kayit)
                        <flux:text class="!text-xs">{{ $kayit->guncelleyen?->name ?? 'Silinmiş yönetici' }} · {{ $kayit->updated_at?->diffForHumans() }}</flux:text>
                    @endif

                    <flux:button type="submit" variant="primary" icon="check">Kaydet</flux:button>
                </form>
            </flux:card>
        @endforeach
    </div>
</div>
