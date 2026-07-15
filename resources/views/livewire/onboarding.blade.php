<div class="flex w-full flex-col gap-6">
    {{-- Stepper --}}
    <div class="flex items-center justify-center gap-2">
        @foreach (['Profil', 'Kurum & Alan'] as $i => $label)
            @php($n = $i + 1)
            <div class="flex items-center gap-2">
                <div @class([
                    'flex size-7 items-center justify-center rounded-full text-xs font-semibold transition',
                    'bg-brand text-white' => $step >= $n,
                    'bg-zinc-200 text-zinc-500' => $step < $n,
                ])>
                    @if ($step > $n)
                        <flux:icon name="check" class="size-4" />
                    @else
                        {{ $n }}
                    @endif
                </div>
                <span @class([
                    'hidden text-sm sm:block',
                    'font-medium text-zinc-900' => $step === $n,
                    'text-zinc-400' => $step !== $n,
                ])>{{ $label }}</span>
                @unless ($loop->last)
                    <div class="h-px w-6 bg-zinc-200 sm:w-10"></div>
                @endunless
            </div>
        @endforeach
    </div>

    {{-- Step 1: Profil --}}
    @if ($step === 1)
        <div class="flex flex-col gap-5">
            <div class="text-center">
                <flux:heading size="lg">Hoş geldiniz 👋</flux:heading>
                <flux:text class="mt-1">Kariyer analiziniz için birkaç bilgiye ihtiyacımız var.</flux:text>
            </div>

            <flux:input wire:model="name" label="Ad Soyad" placeholder="Örn. Ahmet Kocabıyık" />

            <flux:select wire:model="unvan" label="Akademik Unvan" placeholder="Unvan seçin">
                @foreach ($unvanlar as $u)
                    <flux:select.option :value="$u">{{ $u }}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:button variant="primary" wire:click="next" class="w-full">Devam Et</flux:button>
        </div>
    @endif

    {{-- Step 2: Kurum & Alan --}}
    @if ($step === 2)
        <div class="flex flex-col gap-5">
            <div class="text-center">
                <flux:heading size="lg">Kurum ve Alanınız</flux:heading>
                <flux:text class="mt-1">Yönerge eşleştirmesi bu bilgilere göre yapılır.</flux:text>
            </div>

            {{-- Üniversite: yazılabilir combobox (client-side filtre) --}}
            <div
                x-data="{
                    sorgu: @entangle('universite'),
                    acik: false,
                    vurgu: -1,
                    tumu: @js($universiteler),
                    get sonuclar() {
                        const q = (this.sorgu || '').toLocaleLowerCase('tr');
                        const liste = q ? this.tumu.filter(u => u.toLocaleLowerCase('tr').includes(q)) : this.tumu;
                        return liste.slice(0, 8);
                    },
                    sec(u) { this.sorgu = u; this.acik = false; this.vurgu = -1; },
                    asagi() { this.acik = true; if (this.vurgu < this.sonuclar.length - 1) this.vurgu++; },
                    yukari() { if (this.vurgu > 0) this.vurgu--; },
                    enter() { if (this.acik && this.vurgu >= 0 && this.sonuclar[this.vurgu]) { this.sec(this.sonuclar[this.vurgu]); } else { this.acik = false; } },
                }"
                @click.outside="acik = false"
                x-on:keydown.escape="acik = false"
                class="relative"
            >
                <flux:input
                    label="Üniversite"
                    placeholder="Üniversite adı yazın..."
                    x-model="sorgu"
                    x-on:focus="acik = true"
                    x-on:input="acik = true; vurgu = -1"
                    x-on:keydown.arrow-down.prevent="asagi()"
                    x-on:keydown.arrow-up.prevent="yukari()"
                    x-on:keydown.enter.prevent="enter()"
                    autocomplete="off"
                />

                <div x-show="acik && sonuclar.length" x-transition.opacity x-cloak
                    class="absolute z-20 mt-1 max-h-64 w-full overflow-auto rounded-lg border border-line bg-surface py-1 shadow-lg">
                    <template x-for="(u, idx) in sonuclar" :key="u">
                        <button type="button" @click="sec(u)" @mouseenter="vurgu = idx"
                            class="block w-full truncate px-3 py-2 text-start text-sm"
                            :class="vurgu === idx ? 'bg-brand-light text-brand' : 'text-ink'"
                            x-text="u"></button>
                    </template>
                </div>
            </div>

            <flux:select wire:model.live="temelAlan" label="Temel Alan (yönerge grubu)">
                @foreach ($temelAlanlar as $deger => $etiket)
                    <flux:select.option :value="$deger">{{ $etiket }}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:select wire:model.live="fakulte" label="Fakülte" placeholder="Fakülte seçin...">
                <flux:select.option value="">Seçiniz (opsiyonel)</flux:select.option>
                @foreach (\App\Enums\TemelAlan::from($temelAlan)->fakulteler() as $f)
                    <flux:select.option :value="$f">{{ $f }}</flux:select.option>
                @endforeach
            </flux:select>

            @if ($fakulte && count($bolumler[$fakulte] ?? []))
                <flux:select wire:model.live="bolum" label="Bölüm" placeholder="Bölüm seçin...">
                    <flux:select.option value="">Seçiniz (opsiyonel)</flux:select.option>
                    @foreach ($bolumler[$fakulte] as $b)
                        <flux:select.option :value="$b">{{ $b }}</flux:select.option>
                    @endforeach
                </flux:select>
            @endif

            <flux:input wire:model="orcid" label="ORCID (opsiyonel)" placeholder="0000-0000-0000-0000" />

            <div class="flex gap-3">
                <flux:button wire:click="back" class="flex-1">Geri</flux:button>
                <flux:button variant="primary" wire:click="submit" class="flex-1">Kurulumu Tamamla</flux:button>
            </div>
        </div>
    @endif

    {{-- Alt bilgi: ana sayfa / çıkış --}}
    <div class="flex items-center justify-center gap-3 text-xs text-zinc-400">
        <a href="{{ route('home') }}" wire:navigate class="transition hover:text-zinc-600">← Ana sayfa</a>
        <span class="text-zinc-300">·</span>
        <button type="button" wire:click="cikis" class="transition hover:text-zinc-600">Çıkış yap</button>
    </div>
</div>
