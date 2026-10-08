@use('App\Enums\Plan')
@use('App\Livewire\Admin\KullaniciDetay')

@php
    $aktif = $user->aktifAbonelik();
    $korumali = $this->korumali();
    $durumRozeti = [
        'aktif' => ['Aktif', 'green'],
        'baslamadi' => ['Başlamadı', 'blue'],
        'bitti' => ['Bitti', 'zinc'],
        'iptal' => ['İptal', 'red'],
    ];
@endphp

<div>
    <x-topbar :title="$user->name">
        <flux:button :href="route('admin.kullanicilar')" wire:navigate variant="ghost" icon="arrow-left">Kullanıcılar</flux:button>
    </x-topbar>

    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_24rem]">
        <div class="flex min-w-0 flex-col gap-6">

            {{-- KİMLİK --}}
            <flux:card>
                <div class="flex flex-wrap items-start gap-4">
                    <div class="flex size-16 shrink-0 items-center justify-center overflow-hidden rounded-full border border-line bg-canvas text-lg font-semibold text-ink-subtle">
                        {{ $user->initials() }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <flux:heading size="lg">{{ $user->name }}</flux:heading>
                            @if ($user->askidaMi())
                                <flux:badge color="red" size="sm">Askıda</flux:badge>
                            @endif
                            @if ($user->super_admin)
                                <flux:badge color="purple" size="sm">Süper admin</flux:badge>
                            @endif
                            <flux:badge :color="($aktif?->plan ?? Plan::Ucretsiz)->rozet()" size="sm">{{ ($aktif?->plan ?? Plan::Ucretsiz)->etiket() }}</flux:badge>
                        </div>
                        <flux:text class="mt-1">{{ $user->email }}</flux:text>
                    </div>
                </div>

                <dl class="mt-5 grid gap-x-6 gap-y-3 text-sm sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ([
                        'Unvan' => $user->unvan,
                        'Üniversite' => $user->universite,
                        'Temel alan' => $user->temel_alan?->label(),
                        'Bölüm' => $user->bolum,
                        'Kayıt' => $user->created_at?->translatedFormat('j F Y'),
                        'Son giriş' => $user->son_giris_at?->translatedFormat('j F Y H:i'),
                        'E-posta doğrulama' => $user->email_verified_at ? 'Doğrulandı' : 'Doğrulanmadı',
                        'Onboarding' => $user->onboarded_at ? 'Tamamlandı' : 'Tamamlanmadı',
                        'Askıya alınma' => $user->askiya_alindi_at?->translatedFormat('j F Y H:i'),
                    ] as $etiket => $deger)
                        <div class="min-w-0">
                            <dt class="text-xs text-ink-subtle">{{ $etiket }}</dt>
                            <dd class="truncate text-ink">{{ $deger ?? '—' }}</dd>
                        </div>
                    @endforeach
                </dl>

                <div class="mt-5 grid gap-3 border-t border-line pt-4 sm:grid-cols-4">
                    @foreach ($this->sayilar as $etiket => $sayi)
                        <div>
                            <div class="font-serif text-2xl font-bold text-ink">{{ $sayi }}</div>
                            <div class="text-xs text-ink-subtle">{{ $etiket }}</div>
                        </div>
                    @endforeach
                </div>
            </flux:card>

            {{-- ABONELİK GEÇMİŞİ --}}
            <flux:card class="!p-0">
                <div class="border-b border-line px-5 py-4">
                    <flux:heading>Abonelik geçmişi</flux:heading>
                    <flux:text class="!mt-0.5 !text-xs">Aboneliği olmayan kullanıcı ücretsiz plandadır.</flux:text>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[40rem] text-sm">
                        <thead class="border-b border-line bg-canvas text-xs font-semibold uppercase tracking-wide text-ink-subtle">
                            <tr>
                                <th class="px-5 py-2.5 text-start">Plan</th>
                                <th class="px-3 py-2.5 text-start">Dönem</th>
                                <th class="px-3 py-2.5 text-end">Tutar</th>
                                <th class="px-3 py-2.5 text-start">Durum</th>
                                <th class="px-5 py-2.5 text-end"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($this->abonelikler as $abonelik)
                                @php [$durumEtiketi, $durumRengi] = $durumRozeti[$abonelik->durum()]; @endphp
                                <tr wire:key="abonelik-{{ $abonelik->id }}" class="border-b border-line align-top last:border-0">
                                    <td class="px-5 py-3">
                                        <flux:badge :color="$abonelik->plan->rozet()" size="sm">{{ $abonelik->plan->etiket() }}</flux:badge>
                                        @if ($abonelik->not)
                                            <div class="mt-1 max-w-xs text-xs text-ink-subtle">{{ $abonelik->not }}</div>
                                        @endif
                                    </td>
                                    <td class="px-3 py-3 text-ink-muted">
                                        {{ $abonelik->baslangic->format('d.m.Y') }} – {{ $abonelik->bitis?->format('d.m.Y') ?? 'süresiz' }}
                                        <div class="text-xs text-ink-subtle">{{ $abonelik->olusturan?->name ?? 'Silinmiş yönetici' }} ekledi</div>
                                    </td>
                                    <td class="px-3 py-3 text-end tabular-nums text-ink-muted">{{ $abonelik->tutarMetni() ?? '—' }}</td>
                                    <td class="px-3 py-3"><flux:badge :color="$durumRengi" size="sm">{{ $durumEtiketi }}</flux:badge></td>
                                    <td class="px-5 py-3 text-end">
                                        @if (in_array($abonelik->durum(), ['aktif', 'baslamadi'], true))
                                            <flux:button wire:click="abonelikIptal({{ $abonelik->id }})"
                                                wire:confirm="Bu abonelik iptal edilsin mi? Kullanıcı (başka aktif aboneliği yoksa) ücretsiz plana düşer."
                                                size="sm" variant="ghost">İptal et</flux:button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-5 py-8 text-center"><flux:text>Henüz abonelik yok.</flux:text></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </flux:card>

            {{-- SON İŞLEMLER --}}
            <flux:card class="!p-0">
                <div class="flex items-center justify-between border-b border-line px-5 py-4">
                    <flux:heading>Bu kullanıcıdaki yönetici işlemleri</flux:heading>
                    <flux:link :href="route('admin.islemler', ['arama' => $user->email])" wire:navigate class="text-sm">Tümü</flux:link>
                </div>
                @forelse ($this->islemler as $kayit)
                    <div class="flex items-center justify-between gap-3 border-b border-line px-5 py-3 text-sm last:border-0">
                        <div class="min-w-0">
                            <flux:badge :color="$kayit->islem->rozet()" size="sm">{{ $kayit->islem->etiket() }}</flux:badge>
                            @if ($kayit->detay['neden'] ?? null)
                                <span class="ms-2 text-xs text-ink-muted">“{{ $kayit->detay['neden'] }}”</span>
                            @endif
                        </div>
                        <div class="shrink-0 text-end text-xs text-ink-subtle">
                            {{ $kayit->yonetici_eposta ?? 'Komut satırı' }}<br>{{ $kayit->created_at->translatedFormat('j M Y H:i') }}
                        </div>
                    </div>
                @empty
                    <flux:text class="px-5 py-8 text-center">Bu kullanıcıda henüz yönetici işlemi yok.</flux:text>
                @endforelse
            </flux:card>
        </div>

        {{-- SAĞ SÜTUN: işlemler --}}
        <div class="flex flex-col gap-6">

            {{-- PLAN ATA / UZAT --}}
            <flux:card>
                <flux:heading>Plan ata / uzat</flux:heading>
                <flux:text class="!mt-0.5 !text-xs">
                    Havale, kurum anlaşması ya da deneme için. Aktif abonelik varsa başlangıç bitişinin ertesi günü önerilir.
                </flux:text>

                <form wire:submit="abonelikEkle" class="mt-4 flex flex-col gap-4">
                    <flux:select wire:model.live="plan" label="Plan">
                        @foreach (Plan::ucretliler() as $secenek)
                            @php $paket = app(\App\Services\Abonelik\PaketKatalogu::class)->bilgi($secenek); @endphp
                            <flux:select.option :value="$secenek->value">{{ $paket->ad }} · {{ \App\Models\Paket::fiyatMetni($paket->aylik_fiyat_kurus) }}/ay{{ $paket->satista ? '' : ' (satışta değil)' }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <div class="grid grid-cols-2 gap-3">
                        <flux:input wire:model="baslangic" type="date" label="Başlangıç" />
                        <flux:select wire:model.live="sure" label="Süre">
                            @foreach (KullaniciDetay::SURELER as $deger => $etiket)
                                <flux:select.option :value="$deger">{{ $etiket }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </div>

                    @if ($sure === 'ozel')
                        <flux:input wire:model="bitis" type="date" label="Bitiş" />
                    @endif

                    <flux:input wire:model="tutar" type="number" step="0.01" min="0" label="Alınan tutar (₺)"
                        description:trailing="Liste fiyatı önerildi; indirim ya da ücretsiz deneme için değiştirin, boş bırakılabilir." />

                    <flux:textarea wire:model="not" label="Not (isteğe bağlı)" rows="2" placeholder="Ör. havale 08.10, dekont no…" />

                    <flux:button type="submit" variant="primary" icon="plus">Aboneliği ekle</flux:button>
                </form>
            </flux:card>

            {{-- HESAP İŞLEMLERİ --}}
            <flux:card>
                <flux:heading>Hesap işlemleri</flux:heading>

                @if ($korumali)
                    <flux:text class="mt-2 !text-sm">
                        {{ $user->is(auth()->user()) ? 'Bu sizin hesabınız.' : 'Süper admin hesabı.' }}
                        Panelden askıya alınamaz, silinemez ve taklit edilemez.
                        @unless ($user->is(auth()->user()))
                            Önce sunucuda <code class="text-xs">php artisan admin:yap {{ $user->email }} --geri-al</code> ile yetkisi alınmalı.
                        @endunless
                    </flux:text>
                @else
                    <div class="mt-4 flex flex-col gap-5">
                        {{-- Kullanıcı olarak gör --}}
                        <div>
                            <form method="POST" action="{{ route('admin.taklit.baslat', $user) }}">
                                @csrf
                                <flux:button type="submit" icon="eye" class="w-full" :disabled="$user->askidaMi()">Kullanıcı olarak gör</flux:button>
                            </form>
                            <flux:text class="mt-1.5 !text-xs">
                                Destek için onun ekranını görürsünüz; giriş ve çıkış işlem kaydına yazılır.
                                @if ($user->askidaMi()) Askıdaki hesap taklit edilemez. @endif
                            </flux:text>
                        </div>

                        {{-- Askıya al / kaldır --}}
                        <div class="border-t border-line pt-4">
                            @if ($user->askidaMi())
                                <flux:button wire:click="askidanCikar" icon="check-circle" class="w-full">Askıyı kaldır</flux:button>
                            @else
                                <flux:input wire:model="askiNedeni" label="Askıya alma nedeni (isteğe bağlı)" placeholder="İşlem kaydına yazılır" />
                                <flux:button wire:click="askiyaAl" wire:confirm="Hesap askıya alınsın mı? Kullanıcının açık oturumu kapanır ve giriş yapamaz."
                                    icon="no-symbol" class="mt-2 w-full">Askıya al</flux:button>
                            @endif
                        </div>

                        {{-- Sil --}}
                        <div class="border-t border-line pt-4">
                            <flux:modal.trigger name="kullanici-sil">
                                <flux:button variant="danger" icon="trash" class="w-full">Kullanıcıyı sil</flux:button>
                            </flux:modal.trigger>
                        </div>
                    </div>
                @endif
            </flux:card>
        </div>
    </div>

    @unless ($korumali)
        <flux:modal name="kullanici-sil" class="w-full max-w-md">
            <form wire:submit="sil" class="flex flex-col gap-4">
                <div>
                    <flux:heading size="lg">Kullanıcı silinsin mi?</flux:heading>
                    <flux:text class="mt-2">
                        <strong>{{ $user->name }}</strong> ve tüm verisi (faaliyetler, CV, abonelik geçmişi, fotoğraflar)
                        <strong>kalıcı olarak</strong> silinir. Geri alınamaz; işlem kaydında e-postası kalır.
                    </flux:text>
                </div>
                <flux:input wire:model="silmeOnayi" :label="'Onay için e-postayı yazın: '.$user->email" autocomplete="off" />
                <div class="flex justify-end gap-2">
                    <flux:modal.close><flux:button variant="ghost">Vazgeç</flux:button></flux:modal.close>
                    <flux:button type="submit" variant="danger">Kalıcı olarak sil</flux:button>
                </div>
            </form>
        </flux:modal>
    @endunless
</div>
