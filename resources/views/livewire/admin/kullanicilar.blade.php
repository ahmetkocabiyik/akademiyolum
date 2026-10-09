@use('App\Enums\Plan')
@use('App\Livewire\Admin\Kullanicilar')

<div>
    <x-topbar title="Kullanıcılar" :pill="$this->kullanicilar->total().' kullanıcı'" />

    <div class="flex flex-col gap-4">
        <div class="grid gap-3 rounded-xl border border-line bg-surface p-4 md:grid-cols-[minmax(0,1fr)_12rem_12rem_12rem]">
            <flux:input wire:model.live.debounce.300ms="arama" icon="magnifying-glass" placeholder="Ad, e-posta ya da üniversite..." clearable />

            <flux:select wire:model.live="plan">
                <flux:select.option value="">Tüm planlar</flux:select.option>
                @foreach (Plan::cases() as $secenek)
                    <flux:select.option :value="$secenek->value">{{ $secenek->etiket() }}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:select wire:model.live="durum">
                @foreach (Kullanicilar::DURUMLAR as $deger => $etiket)
                    <flux:select.option :value="$deger">{{ $etiket }}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:select wire:model.live="siralama">
                @foreach (Kullanicilar::SIRALAMALAR as $deger => $etiket)
                    <flux:select.option :value="$deger">{{ $etiket }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>

        <flux:card class="overflow-x-auto !p-0">
            <table class="w-full min-w-[56rem] text-sm">
                <thead class="border-b border-line bg-canvas text-start text-xs font-semibold uppercase tracking-wide text-ink-subtle">
                    <tr>
                        <th class="px-5 py-3 text-start">Kullanıcı</th>
                        <th class="px-3 py-3 text-start">Üniversite</th>
                        <th class="px-3 py-3 text-start">Plan</th>
                        <th class="px-3 py-3 text-end">Faaliyet</th>
                        <th class="px-3 py-3 text-start">Kayıt</th>
                        <th class="px-3 py-3 text-start">Son giriş</th>
                        <th class="px-5 py-3 text-start">Durum</th>
                    </tr>
                </thead>
                <tbody data-sirali>
                    @forelse ($this->kullanicilar as $kullanici)
                        @php $abonelik = $kullanici->abonelikler->first(); @endphp
                        <tr wire:key="kullanici-{{ $kullanici->id }}" class="border-b border-line last:border-0 hover:bg-canvas">
                            <td class="px-5 py-3">
                                <a href="{{ route('admin.kullanici', $kullanici) }}" wire:navigate class="block">
                                    <span class="block font-medium text-ink hover:text-brand">{{ $kullanici->name }}</span>
                                    <span class="block text-xs text-ink-subtle">{{ $kullanici->email }}</span>
                                </a>
                            </td>
                            <td class="max-w-56 truncate px-3 py-3 text-ink-muted">{{ $kullanici->universite ?? '—' }}</td>
                            <td class="px-3 py-3">
                                @if ($abonelik)
                                    <flux:badge :color="$abonelik->plan->rozet()" size="sm">{{ $abonelik->plan->etiket() }}</flux:badge>
                                    <div class="mt-0.5 text-xs text-ink-subtle">{{ $abonelik->bitis ? $abonelik->bitis->format('d.m.Y').'’e kadar' : 'Süresiz' }}</div>
                                @else
                                    <span class="text-ink-subtle">Ücretsiz</span>
                                @endif
                            </td>
                            <td class="px-3 py-3 text-end tabular-nums text-ink-muted">{{ $kullanici->faaliyetler_count }}</td>
                            <td class="px-3 py-3 text-ink-muted">{{ $kullanici->created_at?->format('d.m.Y') }}</td>
                            <td class="px-3 py-3 text-ink-muted">{{ $kullanici->son_giris_at?->diffForHumans() ?? '—' }}</td>
                            <td class="px-5 py-3">
                                <div class="flex flex-wrap gap-1">
                                    @if ($kullanici->askidaMi())
                                        <flux:badge color="red" size="sm">Askıda</flux:badge>
                                    @else
                                        <flux:badge color="green" size="sm">Aktif</flux:badge>
                                    @endif
                                    @if ($kullanici->super_admin)
                                        <flux:badge color="purple" size="sm">Admin</flux:badge>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center">
                                <flux:text>Bu filtrelere uyan kullanıcı yok.</flux:text>
                                <flux:button wire:click="filtreleriTemizle" variant="ghost" class="mt-2">Filtreleri temizle</flux:button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </flux:card>

        {{ $this->kullanicilar->links() }}
    </div>
</div>
