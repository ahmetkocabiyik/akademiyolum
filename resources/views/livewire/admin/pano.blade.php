<div>
    <x-topbar title="Genel Bakış" />

    <div class="flex flex-col gap-6">
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ([
                ['Toplam kullanıcı', $this->sayilar['kullanici'], 'users', 'var(--color-brand)', route('admin.kullanicilar')],
                ['Son 30 günde kayıt', $this->sayilar['yeni'], 'user-plus', 'var(--color-cat-green)', route('admin.kullanicilar', ['siralama' => 'yeni'])],
                ['Aktif ücretli abone', $this->sayilar['abone'], 'credit-card', 'var(--color-gold)', route('admin.abonelikler')],
                ['Askıdaki hesap', $this->sayilar['askida'], 'no-symbol', 'var(--color-cat-red)', route('admin.kullanicilar', ['durum' => 'askida'])],
            ] as [$etiket, $sayi, $ikon, $renk, $adres])
                <a href="{{ $adres }}" wire:navigate class="rounded-xl border border-line bg-surface p-5 transition hover:border-brand/40">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-ink-muted">{{ $etiket }}</span>
                        <flux:icon :name="$ikon" class="size-5" style="color: {{ $renk }}" />
                    </div>
                    <div class="mt-2 font-serif text-3xl font-bold text-ink">{{ $sayi }}</div>
                </a>
            @endforeach
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <flux:card class="!p-0">
                <div class="flex items-center justify-between border-b border-line px-5 py-4">
                    <flux:heading>Süresi yaklaşan abonelikler</flux:heading>
                    <flux:text class="!text-xs">{{ \App\Livewire\Admin\Pano::YAKLASAN_GUN }} gün içinde</flux:text>
                </div>
                @forelse ($this->bitecekler as $abonelik)
                    <a href="{{ route('admin.kullanici', $abonelik->user) }}" wire:navigate
                        class="flex items-center justify-between gap-3 border-b border-line px-5 py-3 last:border-0 hover:bg-canvas">
                        <div class="min-w-0">
                            <div class="truncate text-sm font-medium text-ink">{{ $abonelik->user->name }}</div>
                            <div class="truncate text-xs text-ink-subtle">{{ $abonelik->user->email }}</div>
                        </div>
                        <div class="shrink-0 text-end">
                            <flux:badge :color="$abonelik->plan->rozet()" size="sm">{{ $abonelik->plan->etiket() }}</flux:badge>
                            <div class="mt-1 text-xs text-ink-muted">
                                {{ $abonelik->bitis->translatedFormat('j F Y') }} ·
                                {{ $abonelik->kalanGun() === 0 ? 'bugün bitiyor' : $abonelik->kalanGun().' gün' }}
                            </div>
                        </div>
                    </a>
                @empty
                    <flux:text class="px-5 py-8 text-center">Önümüzdeki {{ \App\Livewire\Admin\Pano::YAKLASAN_GUN }} günde biten abonelik yok.</flux:text>
                @endforelse
            </flux:card>

            <flux:card class="!p-0">
                <div class="flex items-center justify-between border-b border-line px-5 py-4">
                    <flux:heading>Son kayıt olanlar</flux:heading>
                    <flux:link :href="route('admin.kullanicilar')" wire:navigate class="text-sm">Tümü</flux:link>
                </div>
                @foreach ($this->sonKayitlar as $kullanici)
                    <a href="{{ route('admin.kullanici', $kullanici) }}" wire:navigate
                        class="flex items-center justify-between gap-3 border-b border-line px-5 py-3 last:border-0 hover:bg-canvas">
                        <div class="min-w-0">
                            <div class="truncate text-sm font-medium text-ink">{{ $kullanici->name }}</div>
                            <div class="truncate text-xs text-ink-subtle">{{ $kullanici->universite ?? $kullanici->email }}</div>
                        </div>
                        <span class="shrink-0 text-xs text-ink-muted">{{ $kullanici->created_at?->diffForHumans() }}</span>
                    </a>
                @endforeach
            </flux:card>
        </div>
    </div>
</div>
