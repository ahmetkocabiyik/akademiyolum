@use('App\Enums\Kadro')
@use('App\Enums\TemelAlan')
@use('App\Livewire\Admin\YonergeDetay')
@use('App\Livewire\Admin\Yonergeler')
@use('App\Services\Yonetim\YonergeOzeti')

@php
    $satir = $this->satir;
    $durumRozeti = ['dogrulandi' => 'green', 'taslak' => 'amber', 'gizli' => 'red', 'yok' => 'zinc'];
@endphp

<div>
    <x-topbar :title="$universite">
        <flux:button :href="route('admin.yonergeler')" wire:navigate variant="ghost" icon="arrow-left">Yönergeler</flux:button>
    </x-topbar>

    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_24rem]">
        <div class="flex min-w-0 flex-col gap-6">

            @if ($satir['gizli'])
                <div class="flex items-start gap-3 rounded-xl border border-cat-red/30 bg-cat-red-light p-4 text-sm">
                    <flux:icon name="eye-slash" class="mt-0.5 size-5 shrink-0 text-cat-red" />
                    <div>
                        <div class="font-semibold text-cat-red">Bu yönerge yayından kaldırıldı</div>
                        <div class="mt-0.5 text-ink-muted">
                            “{{ $satir['gizli']->neden }}” — {{ $satir['gizli']->gizleyen?->name ?? 'Silinmiş yönetici' }}, {{ $satir['gizli']->created_at?->translatedFormat('j F Y H:i') }}.
                            Adaylar bu üniversiteyi hiçbir ekranda görmüyor; {{ $satir['kullanici'] }} kayıtlı kullanıcısına “incelemede” deniyor.
                        </div>
                    </div>
                </div>
            @endif

            {{-- ÖZET --}}
            <flux:card>
                <div class="flex flex-wrap items-center gap-2">
                    <flux:badge :color="$durumRozeti[$satir['durum']]">{{ Yonergeler::DURUMLAR[$satir['durum']] }}</flux:badge>
                    <flux:text>Kapsam <strong class="text-ink">{{ $satir['kapsam'] }}/{{ YonergeOzeti::TAM_KAPSAM }}</strong> kadro × alan</flux:text>
                    <flux:text>· {{ $satir['kullanici'] }} kayıtlı kullanıcı</flux:text>
                </div>
                <dl class="mt-4 grid gap-x-6 gap-y-3 text-sm sm:grid-cols-2">
                    <div>
                        <dt class="text-xs text-ink-subtle">Cetvel</dt>
                        <dd class="text-ink">{{ implode(', ', $satir['cetveller']) ?: '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-ink-subtle">Kaynak PDF</dt>
                        <dd>
                            @if ($satir['kaynak_pdf'])
                                <flux:link :href="route('admin.yonerge-kaynak', $universite)" target="_blank">Yönerge PDF'ini aç</flux:link>
                            @else
                                <span class="text-ink-subtle">Projede yok</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </flux:card>

            {{-- KADRO × ALAN MATRİSİ --}}
            <flux:card class="overflow-x-auto !p-0">
                <div class="border-b border-line px-5 py-4">
                    <flux:heading>Kadro × temel alan</flux:heading>
                    <flux:text class="!mt-0.5 !text-xs">
                        <span class="text-cat-green">✓</span> doğrulandı ·
                        <span class="text-cat-amber-text">T</span> yalnız taslak (adaya gösterilmez) ·
                        — girilmedi · rakam: birime göre ayrılan program sayısı
                    </flux:text>
                </div>
                <table class="w-full min-w-[40rem] text-sm">
                    <thead class="border-b border-line bg-canvas text-xs font-semibold uppercase tracking-wide text-ink-subtle">
                        <tr>
                            <th class="px-5 py-2.5 text-start">Temel alan</th>
                            @foreach (Kadro::cases() as $kadro)
                                <th class="px-3 py-2.5 text-center">{{ $kadro->etiket() }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (TemelAlan::cases() as $alan)
                            <tr class="border-b border-line last:border-0">
                                <td class="px-5 py-2.5 text-ink">{{ $alan->label() }}</td>
                                @foreach (Kadro::cases() as $kadro)
                                    @php $hucre = $this->matris[$kadro->value][$alan->value]; @endphp
                                    <td class="px-3 py-2.5 text-center" title="{{ $hucre['cetvel'] }}{{ $hucre['birimler'] ? ' · '.implode(', ', $hucre['birimler']) : '' }}">
                                        @if ($hucre['durum'] === 'dogrulandi')
                                            <span class="font-semibold text-cat-green">✓{{ count($hucre['birimler']) > 1 ? ' '.count($hucre['birimler']) : '' }}</span>
                                        @elseif ($hucre['durum'] === 'taslak')
                                            <span class="font-semibold text-cat-amber-text">T</span>
                                        @else
                                            <span class="text-ink-subtle">—</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </flux:card>
        </div>

        {{-- SAĞ: künye ve yayın --}}
        <div class="flex flex-col gap-6">
            <flux:card>
                <flux:heading>Yayın durumu</flux:heading>
                @if ($satir['gizli'])
                    <flux:text class="mt-1 !text-sm">Yayına alınınca yönerge adaylara yeniden görünür.</flux:text>
                    <flux:button wire:click="yayinaAl" variant="primary" icon="eye" class="mt-4 w-full">Yeniden yayına al</flux:button>
                @elseif ($satir['durum'] === 'dogrulandi')
                    <flux:text class="mt-1 !text-sm">
                        Bir kullanıcı yanlış sonuç bildirdiyse, düzeltme yayına alınana kadar yönergeyi geçici olarak kaldırın.
                        Veri silinmez.
                    </flux:text>
                    <form wire:submit="gizle" class="mt-4 flex flex-col gap-3">
                        <flux:input wire:model="gizlemeNedeni" label="Neden" placeholder="Ör. Doçent baraj puanı yanlış, kontrol ediliyor" />
                        <flux:button type="submit" icon="eye-slash" wire:confirm="Yönerge yayından kaldırılsın mı? Adaylar bu üniversiteyi hiçbir ekranda görmeyecek.">Yayından kaldır</flux:button>
                    </form>
                @else
                    <flux:text class="mt-1 !text-sm">Doğrulanmış yönergesi olmadığı için adaylara zaten görünmüyor.</flux:text>
                @endif
            </flux:card>

            <flux:card>
                <flux:heading>Künye</flux:heading>
                <flux:text class="mt-1 !text-xs">Ad değiştirilemez: yönerge dosyaları üniversiteyi adıyla tanıyor.</flux:text>
                <form wire:submit="kunyeKaydet" class="mt-4 flex flex-col gap-4">
                    <flux:input wire:model="sehir" label="Şehir" />
                    <flux:select wire:model="tur" label="Tür">
                        @foreach (YonergeDetay::TURLER as $deger => $etiket)
                            <flux:select.option :value="$deger">{{ $etiket }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:input wire:model="yonergeUrl" type="url" label="Resmi yönerge bağlantısı" placeholder="https://" />
                    <flux:button type="submit" variant="primary" icon="check">Künyeyi kaydet</flux:button>
                </form>
            </flux:card>
        </div>
    </div>
</div>
