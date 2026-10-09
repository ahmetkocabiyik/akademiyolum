@use('App\Enums\Plan')
@use('App\Models\Paket')

@php
    $aktif = $this->aktif;
    $bekleyen = $this->bekleyen;
    $secili = $this->paketler->get($paket);
    $durumRozeti = ['aktif' => ['Aktif', 'green'], 'baslamadi' => ['Başlayacak', 'blue'], 'bitti' => ['Bitti', 'zinc'], 'iptal' => ['İptal', 'red']];
@endphp

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout aktif="abonelik" heading="Abonelik" subheading="Paketiniz, yükseltme talepleriniz ve abonelik geçmişiniz">
        <div class="flex flex-col gap-6">

            {{-- MEVCUT PLAN --}}
            <flux:card>
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <flux:text class="!text-xs uppercase tracking-wide">Mevcut paketiniz</flux:text>
                        <div class="mt-1 flex items-center gap-2">
                            <span class="text-xl font-semibold text-ink">{{ ($aktif?->plan ?? Plan::Ucretsiz)->etiket() }}</span>
                            <flux:badge :color="($aktif?->plan ?? Plan::Ucretsiz)->rozet()" size="sm">{{ $aktif ? 'Aktif' : 'Ücretsiz plan' }}</flux:badge>
                        </div>
                        @if ($aktif)
                            <flux:text class="mt-1">
                                {{ $aktif->baslangic->translatedFormat('j F Y') }} – {{ $aktif->bitis?->translatedFormat('j F Y') ?? 'süresiz' }}
                                @if ($aktif->kalanGun() !== null)
                                    · <span @class(['font-medium', 'text-cat-amber-text' => $aktif->kalanGun() <= \App\Enums\EpostaTuru::HATIRLATMA_GUN])>
                                        {{ $aktif->kalanGun() === 0 ? 'bugün bitiyor' : $aktif->kalanGun().' gün kaldı' }}
                                    </span>
                                @endif
                            </flux:text>
                        @else
                            <flux:text class="mt-1">Ücretli bir paket seçerek tüm özellikleri açabilirsiniz.</flux:text>
                        @endif
                    </div>
                    @if ($aktif && ($ozellikler = app(\App\Services\Abonelik\PaketKatalogu::class)->bilgi($aktif->plan)->ozellikler) !== [])
                        <ul class="grid gap-1 text-sm text-ink-muted sm:grid-cols-2 sm:gap-x-6">
                            @foreach ($ozellikler as $ozellik)
                                <li class="flex items-center gap-1.5"><flux:icon name="check" class="size-4 text-cat-green" />{{ $ozellik }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </flux:card>

            {{-- BEKLEYEN TALEP ya da YENİ TALEP --}}
            @if ($bekleyen)
                <div class="flex flex-wrap items-start gap-3 rounded-xl border border-brand/25 bg-brand-light p-4 text-sm">
                    <flux:icon name="clock" class="mt-0.5 size-5 shrink-0 text-brand" />
                    <div class="min-w-0 flex-1">
                        <div class="font-semibold text-ink">{{ $bekleyen->plan->etiket() }} ({{ mb_strtolower($bekleyen->donemEtiketi()) }}) talebiniz inceleniyor</div>
                        <div class="mt-0.5 text-ink-muted">
                            {{ $bekleyen->created_at?->translatedFormat('j F Y') }} tarihinde alındı ·
                            {{ Paket::fiyatMetni(app(\App\Services\Abonelik\PaketKatalogu::class)->onerilenTutar($bekleyen->plan, $bekleyen->ay())) }}.
                            Ödeme bilgilerini {{ auth()->user()->email }} adresine göndereceğiz; ödeme alındığında paketiniz tanımlanır.
                        </div>
                    </div>
                    {{-- Dar ekranda alta iner; yanında kalınca metni tek sözcüklük sütuna sıkıştırıyordu. --}}
                    <div class="w-full ps-8 sm:w-auto sm:ps-0">
                        <flux:button size="sm" variant="ghost" wire:click="geriCek" wire:confirm="Paket talebiniz geri çekilsin mi?">Talebi geri çek</flux:button>
                    </div>
                </div>
            @elseif ($this->paketler->isNotEmpty())
                <flux:card>
                    <flux:heading>{{ $aktif ? 'Paketi yenile ya da değiştir' : 'Paketinizi yükseltin' }}</flux:heading>
                    <flux:text class="mt-1">Seçiminiz bize talep olarak iletilir; ödeme bilgilerini e-postayla göndeririz.</flux:text>

                    <form wire:submit="talepEt" class="mt-4 flex max-w-xl flex-col gap-4">
                        <x-paket-secimi :paketler="$this->paketler" :secili="$paket" />

                        @if ($secili?->yillik_fiyat_kurus !== null)
                            <flux:radio.group wire:model.live="donem" label="Ödeme dönemi" variant="segmented">
                                <flux:radio value="aylik" label="Aylık · {{ Paket::fiyatMetni($secili->aylik_fiyat_kurus) }}" />
                                <flux:radio value="yillik" label="Yıllık · {{ Paket::fiyatMetni($secili->yillik_fiyat_kurus) }}{{ $secili->yillikIndirim() ? ' (%'.$secili->yillikIndirim().' indirim)' : '' }}" />
                            </flux:radio.group>
                        @endif

                        <flux:error name="paket" />
                        <flux:error name="donem" />

                        <div>
                            <flux:button type="submit" variant="primary" icon="paper-airplane">
                                {{ $aktif && $secili && $aktif->plan === $secili->plan ? 'Yenileme talep et' : 'Talep et' }}
                            </flux:button>
                        </div>
                    </form>
                </flux:card>
            @endif

            {{-- GEÇMİŞ --}}
            <div>
                <flux:heading>Abonelik geçmişi</flux:heading>
                @if ($this->gecmis->isEmpty())
                    <flux:text class="mt-2">Henüz bir aboneliğiniz olmadı.</flux:text>
                @else
                    <flux:card class="mt-3 overflow-x-auto !p-0">
                        <table class="w-full min-w-[32rem] text-sm">
                            <thead class="border-b border-line bg-canvas text-xs font-semibold uppercase tracking-wide text-ink-subtle">
                                <tr>
                                    <th class="px-5 py-3 text-start">Paket</th>
                                    <th class="px-3 py-3 text-start">Dönem</th>
                                    <th class="px-3 py-3 text-end">Tutar</th>
                                    <th class="px-5 py-3 text-start">Durum</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->gecmis as $kayit)
                                    @php [$etiket, $renk] = $durumRozeti[$kayit->durum()]; @endphp
                                    <tr wire:key="abonelik-{{ $kayit->id }}" class="border-b border-line last:border-0">
                                        <td class="px-5 py-3 font-medium text-ink">{{ $kayit->plan->etiket() }}</td>
                                        <td class="px-3 py-3 text-ink-muted">{{ $kayit->baslangic->format('d.m.Y') }} – {{ $kayit->bitis?->format('d.m.Y') ?? 'süresiz' }}</td>
                                        <td class="px-3 py-3 text-end tabular-nums text-ink-muted">{{ $kayit->tutarMetni() ?? '—' }}</td>
                                        <td class="px-5 py-3"><flux:badge :color="$renk" size="sm">{{ $etiket }}</flux:badge></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </flux:card>
                @endif
            </div>
        </div>
    </x-settings.layout>
</section>
