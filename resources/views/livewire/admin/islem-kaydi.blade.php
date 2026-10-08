@use('App\Enums\YoneticiIslemi')

<div>
    <x-topbar title="İşlem Kaydı" :pill="$this->kayitlar->total().' kayıt'" />

    <div class="flex flex-col gap-4">
        <div class="grid gap-3 rounded-xl border border-line bg-surface p-4 md:grid-cols-[minmax(0,1fr)_16rem]">
            <flux:input wire:model.live.debounce.300ms="arama" icon="magnifying-glass" placeholder="Yönetici ya da kullanıcı e-postası..." clearable />
            <flux:select wire:model.live="islem">
                <flux:select.option value="">Tüm işlemler</flux:select.option>
                @foreach (YoneticiIslemi::cases() as $secenek)
                    <flux:select.option :value="$secenek->value">{{ $secenek->etiket() }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>

        <flux:card class="overflow-x-auto !p-0">
            <table class="w-full min-w-[52rem] text-sm">
                <thead class="border-b border-line bg-canvas text-xs font-semibold uppercase tracking-wide text-ink-subtle">
                    <tr>
                        <th class="px-5 py-3 text-start">Zaman</th>
                        <th class="px-3 py-3 text-start">İşlem</th>
                        <th class="px-3 py-3 text-start">Yönetici</th>
                        <th class="px-3 py-3 text-start">Kullanıcı</th>
                        <th class="px-5 py-3 text-start">Ayrıntı</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($this->kayitlar as $kayit)
                        <tr wire:key="kayit-{{ $kayit->id }}" class="border-b border-line align-top last:border-0">
                            <td class="whitespace-nowrap px-5 py-3 text-ink-muted">{{ $kayit->created_at->format('d.m.Y H:i') }}</td>
                            <td class="px-3 py-3"><flux:badge :color="$kayit->islem->rozet()" size="sm">{{ $kayit->islem->etiket() }}</flux:badge></td>
                            <td class="px-3 py-3 text-ink-muted">{{ $kayit->yonetici_eposta ?? 'Komut satırı' }}</td>
                            <td class="px-3 py-3">
                                @if ($kayit->hedef_user_id)
                                    <a href="{{ route('admin.kullanici', $kayit->hedef_user_id) }}" wire:navigate class="text-ink hover:text-brand">{{ $kayit->hedef_eposta }}</a>
                                @else
                                    {{-- Kullanıcı silinmiş: e-posta anlık görüntüden. --}}
                                    <span class="text-ink-subtle">{{ $kayit->hedef_eposta ?? '—' }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-xs text-ink-subtle">
                                @foreach ($kayit->detay ?? [] as $anahtar => $deger)
                                    @if ($deger !== null)
                                        <span class="me-2 whitespace-nowrap">{{ str_replace('_', ' ', $anahtar) }}: <span class="text-ink-muted">{{ is_scalar($deger) ? $deger : json_encode($deger) }}</span></span>
                                    @endif
                                @endforeach
                                @if ($kayit->ip)<span class="whitespace-nowrap">IP {{ $kayit->ip }}</span>@endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-12 text-center"><flux:text>Kayıt yok.</flux:text></td></tr>
                    @endforelse
                </tbody>
            </table>
        </flux:card>

        {{ $this->kayitlar->links() }}
    </div>
</div>
