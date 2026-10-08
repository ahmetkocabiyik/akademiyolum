@use('App\Enums\Plan')
@use('App\Livewire\Admin\Abonelikler')

@php
    $durumRozeti = ['aktif' => ['Aktif', 'green'], 'baslamadi' => ['Başlamadı', 'blue'], 'bitti' => ['Bitti', 'zinc'], 'iptal' => ['İptal', 'red']];
@endphp

<div>
    <x-topbar title="Abonelikler" :pill="$this->abonelikler->total().' kayıt'" />

    <div class="flex flex-col gap-4">
        <div class="flex flex-wrap items-end gap-3 rounded-xl border border-line bg-surface p-4">
            <div class="flex flex-wrap gap-1.5">
                @foreach (Abonelikler::DURUMLAR as $deger => $etiket)
                    <button type="button" wire:click="$set('durum', '{{ $deger }}')"
                        @class([
                            'rounded-lg px-3 py-2 text-sm font-medium transition',
                            'bg-brand text-white' => $durum === $deger,
                            'text-ink-muted hover:bg-canvas' => $durum !== $deger,
                        ])>{{ $etiket }}</button>
                @endforeach
            </div>
            <flux:select wire:model.live="plan" class="ms-auto w-48">
                <flux:select.option value="">Tüm planlar</flux:select.option>
                @foreach (Plan::ucretliler() as $secenek)
                    <flux:select.option :value="$secenek->value">{{ $secenek->etiket() }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>

        <flux:card class="overflow-x-auto !p-0">
            <table class="w-full min-w-[52rem] text-sm">
                <thead class="border-b border-line bg-canvas text-xs font-semibold uppercase tracking-wide text-ink-subtle">
                    <tr>
                        <th class="px-5 py-3 text-start">Kullanıcı</th>
                        <th class="px-3 py-3 text-start">Plan</th>
                        <th class="px-3 py-3 text-start">Dönem</th>
                        <th class="px-3 py-3 text-end">Tutar</th>
                        <th class="px-3 py-3 text-start">Durum</th>
                        <th class="px-5 py-3 text-start">Ekleyen</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($this->abonelikler as $abonelik)
                        @php [$durumEtiketi, $durumRengi] = $durumRozeti[$abonelik->durum()]; @endphp
                        <tr wire:key="abonelik-{{ $abonelik->id }}" class="border-b border-line last:border-0 hover:bg-canvas">
                            <td class="px-5 py-3">
                                <a href="{{ route('admin.kullanici', $abonelik->user) }}" wire:navigate>
                                    <span class="block font-medium text-ink hover:text-brand">{{ $abonelik->user->name }}</span>
                                    <span class="block text-xs text-ink-subtle">{{ $abonelik->user->email }}</span>
                                </a>
                            </td>
                            <td class="px-3 py-3"><flux:badge :color="$abonelik->plan->rozet()" size="sm">{{ $abonelik->plan->etiket() }}</flux:badge></td>
                            <td class="px-3 py-3 text-ink-muted">
                                {{ $abonelik->baslangic->format('d.m.Y') }} – {{ $abonelik->bitis?->format('d.m.Y') ?? 'süresiz' }}
                                @if ($abonelik->kalanGun() !== null)
                                    <div class="text-xs {{ $abonelik->kalanGun() <= \App\Livewire\Admin\Pano::YAKLASAN_GUN ? 'font-medium text-cat-amber-text' : 'text-ink-subtle' }}">
                                        {{ $abonelik->kalanGun() === 0 ? 'bugün bitiyor' : $abonelik->kalanGun().' gün kaldı' }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-3 py-3 text-end tabular-nums text-ink-muted">{{ $abonelik->tutarMetni() ?? '—' }}</td>
                            <td class="px-3 py-3"><flux:badge :color="$durumRengi" size="sm">{{ $durumEtiketi }}</flux:badge></td>
                            <td class="px-5 py-3 text-xs text-ink-subtle">{{ $abonelik->olusturan?->name ?? '—' }}<br>{{ $abonelik->created_at?->format('d.m.Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-12 text-center"><flux:text>Bu filtrede abonelik yok.</flux:text></td></tr>
                    @endforelse
                </tbody>
            </table>
        </flux:card>

        {{ $this->abonelikler->links() }}
    </div>
</div>
