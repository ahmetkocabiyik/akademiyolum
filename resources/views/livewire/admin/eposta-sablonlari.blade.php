<div>
    <x-topbar title="E-posta Şablonları" />

    <flux:text class="mb-4">
        Kayıt ve abonelik anında giden e-postalar. Düzenlemediğiniz şablon varsayılan metinle gider;
        kapattığınız şablon hiç gönderilmez.
    </flux:text>

    {{-- Bağlantı testi: e-posta gönderimi gerçekten çalışıyor mu? --}}
    <flux:card class="mb-6 flex flex-col gap-4">
        <div class="flex flex-wrap items-start justify-between gap-2">
            <div>
                <flux:heading size="lg">E-posta bağlantı testi</flux:heading>
                <flux:text class="!text-sm">Kuyruğa atmadan anında gönderir; gönderim başarısızsa hatanın kendisi burada görünür.</flux:text>
            </div>
            <div class="flex flex-wrap gap-1">
                <flux:badge :color="in_array($surucu, \App\Livewire\Admin\EpostaSablonlari::GONDERMEYEN_SURUCULER, true) ? 'amber' : 'green'" size="sm">Sürücü: {{ $surucu }}</flux:badge>
                <flux:badge color="zinc" size="sm">Gönderen: {{ $gonderen ?: '—' }}</flux:badge>
            </div>
        </div>

        <form wire:submit="baglantiTesti" class="flex flex-col gap-3 sm:flex-row sm:items-start">
            <flux:input wire:model="testAdresi" type="email" placeholder="ornek@alanadi.com" class="sm:flex-1" />
            <flux:button type="submit" variant="primary" icon="paper-airplane" class="shrink-0">Test e-postası gönder</flux:button>
        </form>

        @if ($testSonucu)
            <flux:callout :variant="$testSonucu['tur']" :icon="$testSonucu['tur'] === 'success' ? 'check-circle' : 'exclamation-triangle'">
                <flux:callout.text class="break-words">{{ $testSonucu['mesaj'] }}</flux:callout.text>
            </flux:callout>
        @endif
    </flux:card>

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
