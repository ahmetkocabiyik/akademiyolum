@props([
    'kurumlar',
    'hedefKurum',
    'kadrolar',
    'hedefKadro',
    'sapka',
    'sertlik',
    'raporlar',
    'aktifRaporId',
    'bekleniyor',
])

{{--
    Sol panel: YZ'nin hangi şapkayla ve hangi yönergeye karşı okuyacağı.

    Şapka ve ton yalnızca ÜSLUBU değiştirir; puan ve karar motordan gelir ve
    dört şapkada da aynıdır. Panelin başındaki not bunu söylüyor, yoksa aday
    "sert jüri" seçince puanının düştüğünü sanırdı.
--}}
<flux:card class="flex flex-col gap-4 !p-5">

    <div>
        <flux:heading size="sm">Analiz Ayarları</flux:heading>
        <flux:text class="!mt-1 !text-xs">YZ'nin hangi şapkayla okuyacağını seçin.</flux:text>
    </div>

    <div class="flex items-start gap-2 rounded-xl border border-cat-purple/15 bg-cat-purple/5 p-3">
        <flux:icon name="information-circle" class="mt-px size-4 shrink-0 text-cat-purple" />
        <flux:text class="!text-xs !text-cat-purple leading-relaxed">
            Şapka ve ton yalnızca raporun <strong>üslubunu</strong> değiştirir.
            Puanlar ve karar Yönerge Analizi'ndeki aynı motordan gelir.
        </flux:text>
    </div>

    <x-secim-listesi model="hedefKadro" canli label="Hedef Kadro" :secenekler="$kadrolar" />

    @if ($kurumlar === [])
        <div class="rounded-xl border border-line bg-canvas p-3">
            <flux:text class="!text-xs">
                Bu kadro ve temel alan için yönergesi girilmiş kurum yok. Hedef kadroyu
                değiştirmeyi ya da profilinizdeki temel alanı kontrol etmeyi deneyin.
            </flux:text>
        </div>
    @else
        {{-- Düz bir <select> değil: liste 100+ kuruma çıkıyor ve aday kendi
             üniversitesini kaydırarak arıyordu. Odakta liste açılır, yazdıkça
             süzülür. --}}
        <x-combobox model="hedefKurum" :secenekler="$kurumlar"
            label="Hedef Kurum" placeholder="Kurum adı yazın ya da listeden seçin..."
            bos="Bu ada uyan, yönergesi girilmiş bir kurum yok." />
    @endif

    {{-- Jüri şapkası --}}
    <div>
        <flux:label class="!mb-1.5 block">Jüri Şapkası</flux:label>
        <div class="grid grid-cols-2 gap-2">
            @foreach (\App\Enums\JuriSapkasi::cases() as $secenek)
                @php $secili = $sapka === $secenek->value; @endphp
                <button type="button" wire:click="$set('sapka', '{{ $secenek->value }}')"
                    aria-pressed="{{ $secili ? 'true' : 'false' }}"
                    @class(['rounded-xl border p-3 text-center transition', 'border-line hover:border-cat-purple' => ! $secili])
                    @style([
                        'border-color: '.$secenek->renk().'; background: color-mix(in srgb, '.$secenek->renk().' 8%, transparent)' => $secili,
                    ])>
                    <span class="mx-auto flex size-8 items-center justify-center rounded-lg"
                        style="color: {{ $secenek->renk() }}; background: color-mix(in srgb, {{ $secenek->renk() }} 12%, transparent)">
                        <flux:icon :name="$secenek->ikon()" class="size-4" />
                    </span>
                    <span @class(['mt-2 block text-xs', 'font-semibold' => $secili, 'text-ink-muted' => ! $secili])
                        @style(['color: '.$secenek->renk() => $secili])>
                        {{ $secenek->etiket() }}
                    </span>
                </button>
            @endforeach
        </div>
    </div>

    {{-- Ton --}}
    <div>
        <flux:label class="!mb-1.5 block">Değerlendirme Sertliği</flux:label>
        <div class="flex gap-2">
            @foreach (\App\Enums\JuriSertligi::cases() as $secenek)
                @php $secili = $sertlik === $secenek->value; @endphp
                <button type="button" wire:click="$set('sertlik', '{{ $secenek->value }}')"
                    aria-pressed="{{ $secili ? 'true' : 'false' }}"
                    @class(['rounded-full border px-3 py-1.5 text-xs font-medium transition', 'border-line text-ink-muted hover:border-line-strong' => ! $secili])
                    @style([
                        'border-color: '.$secenek->renk().'; background: color-mix(in srgb, '.$secenek->renk().' 10%, transparent); color: '.$secenek->renk() => $secili,
                    ])>
                    {{ $secenek->etiket() }}
                </button>
            @endforeach
        </div>
    </div>

    <flux:button wire:click="analizBaslat" wire:loading.attr="disabled" :disabled="$bekleniyor || $kurumlar === []"
        icon="scale" variant="primary" class="w-full">
        Jüri Masasına Taşı
    </flux:button>

    {{-- Önceki raporlar: rapor üretimi pahalı, saklananlar tek tıkla açılır. --}}
    @if ($raporlar->isNotEmpty())
        <div>
            <div class="mb-2 flex items-center gap-2 text-xs font-semibold uppercase tracking-wide text-ink-subtle">
                Önceki Analizler
                <span class="h-px flex-1 bg-line"></span>
            </div>

            <div class="flex flex-col gap-1">
                @foreach ($raporlar as $gecmis)
                    <div @class([
                        'group flex items-center gap-2 rounded-xl border px-2.5 py-2 transition',
                        'border-brand bg-brand-light' => $gecmis->id === $aktifRaporId,
                        'border-transparent hover:border-line hover:bg-canvas' => $gecmis->id !== $aktifRaporId,
                    ]) wire:key="gecmis-{{ $gecmis->id }}">
                        <button type="button" wire:click="raporSec({{ $gecmis->id }})" class="min-w-0 flex-1 text-start">
                            <span class="block truncate text-xs font-medium text-ink-muted">{{ $gecmis->baslikMetni() }}</span>
                            <span class="mt-0.5 block text-2xs text-ink-subtle">{{ $gecmis->created_at?->diffForHumans() }}</span>
                        </button>
                        <flux:badge :color="$gecmis->karar->rozet()" size="sm" class="shrink-0">
                            {{ $gecmis->karar->etiket() }}
                        </flux:badge>
                        <flux:button wire:click="raporSil({{ $gecmis->id }})"
                            wire:confirm="Bu raporu silmek istediğinize emin misiniz?"
                            size="sm" variant="subtle" icon="trash" aria-label="Raporu sil"
                            class="shrink-0 opacity-0 transition group-hover:opacity-100" />
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</flux:card>
