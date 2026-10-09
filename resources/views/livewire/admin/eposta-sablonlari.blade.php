<div>
    <x-topbar title="E-posta Şablonları" />

    <flux:text class="mb-4">
        Kayıt ve abonelik anında giden e-postalar. Düzenlemediğiniz şablon varsayılan metinle gider;
        kapattığınız şablon hiç gönderilmez.
    </flux:text>

    @foreach (collect($turler)->groupBy(fn ($tur) => $tur->grup()) as $grup => $gruptakiler)
    <flux:heading size="sm" class="mb-3 mt-6 first-of-type:mt-0">{{ $grup }}</flux:heading>
    <div class="grid gap-4 md:grid-cols-2 2xl:grid-cols-3">
        @foreach ($gruptakiler as $tur)
            @php $kayit = $this->kayitlar->get($tur->value); @endphp
            <a href="{{ route('admin.eposta-sablonu', $tur) }}" wire:navigate wire:key="sablon-{{ $tur->value }}"
                class="kart-tikla flex flex-col gap-2 rounded-xl border border-line bg-surface p-5 hover:border-brand/40">
                <div class="flex items-start justify-between gap-3">
                    <span class="font-semibold text-ink">{{ $tur->etiket() }}</span>
                    <span class="flex shrink-0 gap-1">
                        @if (! $tur->kapatilabilir())
                            <flux:badge color="purple" size="sm">Her zaman açık</flux:badge>
                        @elseif ($kayit && ! $kayit->aktif)
                            <flux:badge color="red" size="sm">Kapalı</flux:badge>
                        @else
                            <flux:badge color="green" size="sm">Açık</flux:badge>
                        @endif
                        <flux:badge :color="$kayit ? 'blue' : 'zinc'" size="sm">{{ $kayit ? 'Düzenlendi' : 'Varsayılan' }}</flux:badge>
                    </span>
                </div>
                <span class="text-sm text-ink-muted">{{ $tur->aciklama() }}</span>
                <span class="truncate text-xs text-ink-subtle">Konu: {{ $kayit?->konu ?? $tur->varsayilanKonu() }}</span>
                @if ($kayit)
                    <span class="text-xs text-ink-subtle">{{ $kayit->guncelleyen?->name ?? 'Silinmiş yönetici' }} · {{ $kayit->updated_at?->diffForHumans() }}</span>
                @endif
            </a>
        @endforeach
    </div>
    @endforeach
</div>
