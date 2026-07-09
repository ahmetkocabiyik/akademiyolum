<div class="flex w-full flex-col gap-6">
    {{-- Stepper --}}
    <div class="flex items-center justify-center gap-2">
        @foreach (['Profil', 'Kurum & Alan', 'Yönerge'] as $i => $label)
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

            <flux:input wire:model="universite" label="Üniversite" placeholder="Örn. Mersin Üniversitesi" />
            <flux:input wire:model="fakulte" label="Fakülte" placeholder="Örn. İlahiyat Fakültesi" />
            <flux:input wire:model="bolum" label="Bölüm / Anabilim Dalı (opsiyonel)" placeholder="Örn. Temel İslam Bilimleri" />
            <flux:input wire:model="alan" label="Akademik Alan" placeholder="Örn. Tasavvuf, Kelam, Hadis" />

            <div class="flex gap-3">
                <flux:button wire:click="back" class="flex-1">Geri</flux:button>
                <flux:button variant="primary" wire:click="next" class="flex-1">Devam Et</flux:button>
            </div>
        </div>
    @endif

    {{-- Step 3: Yönerge --}}
    @if ($step === 3)
        <div class="flex flex-col gap-5">
            <div class="text-center">
                <flux:heading size="lg">Hedef Yönerge</flux:heading>
                <flux:text class="mt-1">Puanlamanız bu yönergeye göre hesaplanır. Sonradan değiştirebilirsiniz.</flux:text>
            </div>

            <flux:select wire:model="yonergeId" label="Yönerge" placeholder="Yönerge seçin">
                @foreach ($this->yonergeler as $y)
                    <flux:select.option :value="$y->id">{{ $y->ad }}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:input wire:model="orcid" label="ORCID (opsiyonel)" placeholder="0000-0000-0000-0000" />

            <div class="flex gap-3">
                <flux:button wire:click="back" class="flex-1">Geri</flux:button>
                <flux:button variant="primary" wire:click="submit" class="flex-1">Kurulumu Tamamla</flux:button>
            </div>
        </div>
    @endif
</div>
