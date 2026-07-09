<div>
    <div class="flex flex-col gap-4">

        <div>
            <flux:heading size="xl">Yönerge Analizi</flux:heading>
            <flux:text class="mt-1">Profilinizi üniversitelerin atama kriterleriyle karşılaştırın</flux:text>
        </div>

        <div class="grid gap-4 lg:grid-cols-[260px_1fr]">

            {{-- Sol panel: profil + filtreler --}}
            <div class="flex flex-col gap-4">
                <flux:card>
                    <flux:heading size="sm">Mevcut Profilim</flux:heading>
                    <div class="mt-3 flex flex-col gap-2 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-ink-subtle">Toplam Puanım</span>
                            <span class="font-serif text-lg font-bold text-brand">{{ $this->profilToplam }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-ink-subtle">Alan</span>
                            <span class="text-ink-muted">{{ auth()->user()->alan ?? '—' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-ink-subtle">Unvan</span>
                            <span class="text-ink-muted">{{ auth()->user()->unvan ?? '—' }}</span>
                        </div>
                    </div>
                </flux:card>

                <flux:card class="flex flex-col gap-4">
                    <flux:heading size="sm">Filtreler</flux:heading>

                    <flux:select wire:model.live="turFiltre" label="Üniversite Türü" size="sm">
                        <flux:select.option value="">Tümü</flux:select.option>
                        <flux:select.option value="devlet">Devlet</flux:select.option>
                        <flux:select.option value="vakif">Vakıf</flux:select.option>
                    </flux:select>

                    <flux:select wire:model.live="kadroFiltre" label="Kadro" size="sm">
                        <flux:select.option value="">Tümü</flux:select.option>
                        <flux:select.option value="docentlik">Doçentlik</flux:select.option>
                        <flux:select.option value="dr_ogr_uyesi">Dr. Öğr. Üyesi</flux:select.option>
                    </flux:select>

                    <flux:select wire:model.live="siralama" label="Sıralama" size="sm">
                        <flux:select.option value="baraj_artan">Puan Barajı (Artan)</flux:select.option>
                        <flux:select.option value="baraj_azalan">Puan Barajı (Azalan)</flux:select.option>
                        <flux:select.option value="oran">Eşleşme Oranı</flux:select.option>
                        <flux:select.option value="alfabetik">Alfabetik</flux:select.option>
                    </flux:select>
                </flux:card>
            </div>

            {{-- Sağ panel: sonuç listesi --}}
            <div class="flex flex-col gap-3">
                @forelse ($this->sonuclar as $s)
                    <flux:card>
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="flex items-center gap-2">
                                    <flux:heading size="sm">{{ $s['yonerge']->universite->ad }}</flux:heading>
                                    <flux:badge size="sm" :color="$s['yonerge']->universite->tur === 'vakif' ? 'purple' : 'zinc'">
                                        {{ $s['yonerge']->universite->tur === 'vakif' ? 'Vakıf' : 'Devlet' }}
                                    </flux:badge>
                                </div>
                                <flux:text size="sm" class="mt-0.5">
                                    {{ $s['yonerge']->universite->sehir }} ·
                                    {{ $s['yonerge']->kadro === 'docentlik' ? 'Doçentlik' : 'Dr. Öğr. Üyesi' }}
                                </flux:text>
                            </div>

                            @if ($s['yapilabilir'])
                                <flux:badge color="green" icon="check-circle">Yapılabilir</flux:badge>
                            @else
                                <flux:badge color="amber" icon="exclamation-circle">{{ $s['kalan'] }} puan eksik</flux:badge>
                            @endif
                        </div>

                        <div class="mt-4 grid grid-cols-3 gap-4">
                            <div>
                                <div class="text-[10px] uppercase tracking-wide text-ink-subtle">Puanım</div>
                                <div class="font-serif text-xl font-bold text-ink">{{ $s['toplam'] }}</div>
                            </div>
                            <div>
                                <div class="text-[10px] uppercase tracking-wide text-ink-subtle">Min. Baraj</div>
                                <div class="font-serif text-xl font-bold text-ink">{{ $s['baraj'] }}</div>
                            </div>
                            <div>
                                <div class="text-[10px] uppercase tracking-wide text-ink-subtle">Eşleşme</div>
                                <div class="font-serif text-xl font-bold" style="color: {{ $s['yapilabilir'] ? 'var(--color-cat-green)' : 'var(--color-gold)' }}">%{{ $s['oran'] }}</div>
                            </div>
                        </div>

                        <div class="mt-3 h-1.5 overflow-hidden rounded-full bg-line">
                            <div class="h-full rounded-full"
                                style="width: {{ $s['oran'] }}%; background: {{ $s['yapilabilir'] ? 'var(--color-cat-green)' : 'var(--color-gold)' }}"></div>
                        </div>
                    </flux:card>
                @empty
                    <flux:card class="py-12 text-center">
                        <flux:text>Seçili filtrelere uygun yönerge bulunamadı.</flux:text>
                    </flux:card>
                @endforelse
            </div>
        </div>
    </div>
</div>
