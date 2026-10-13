@props([
    'secenekler',
    'acik',
])

{{-- Kart sayısı tek başına yanıltıcı: aday, listede olmayan bir üniversitenin
     yönergesinin hiç girilmediğini mi yoksa kendi alanının kapsanmadığını mı
     bilemiyor. Bu kutu YALNIZCA adayın düzeltebileceği durumu anlatır: alan
     kapsanıyor ama yönerge birime göre ölçüt koyuyor. Kapsanmayan alanlar
     sonuçların altında kart olarak duruyor.

     Seçim ÜNİVERSİTE BAŞINA yapılır. Profildeki tek birim alanı yalnız adayın
     kendi üniversitesinin birimlerini listeliyor; korpustaki 181 birim adının
     yalnız 25'i birden çok üniversitede ortak olduğu için o alan başka
     üniversitelerde çoğunlukla tutmuyor. --}}
{{-- Açılıp kapanma Alpine'da, açık/kapalı bilgisi sunucuda.

     `$wire.entangle` ikisini bağlıyor: tıklama anında animasyon başlıyor
     (sunucu yanıtı beklenmiyor) ama durum yine `birimPaneliAcik`'te duruyor —
     seçiciler `wire:model.live`, her seçim yeni render tetikliyor ve durum
     yalnız istemcide olsaydı kutu adayın yüzüne kapanabilirdi.

     Panel bu yüzden KAPALIYKEN DE çiziliyor: `x-collapse` kapanışı da
     canlandırıyor, canlandıracak bir eleman olması gerek. İlk çizimde
     `display:none` sunucudan geliyor ki Alpine kurulana kadar kutu açık
     görünmesin. --}}
<flux:callout icon="information-circle" variant="secondary" class="mb-4"
    x-data="{ acik: $wire.entangle('birimPaneliAcik') }">
    {{-- Başlık kapalıyken de duruyor: aday bekleyen iş olduğunu kutuyu
         açmadan görüyor, açmak onun kararı. --}}
    <flux:callout.heading>
        <button type="button" x-on:click="acik = ! acik"
            aria-expanded="{{ $acik ? 'true' : 'false' }}"
            x-bind:aria-expanded="acik"
            class="flex w-full items-center justify-between gap-2 text-left">
            <span>{{ count($secenekler) }} üniversite birim seçilmesini bekliyor</span>
            <flux:icon name="chevron-down" class="size-4 shrink-0 transition-transform duration-200"
                x-bind:class="acik && 'rotate-180'" />
        </button>
    </flux:callout.heading>

    <div x-show="acik" x-collapse @if (! $acik) style="display: none" @endif>
        <flux:callout.text class="mb-3">
            Bu üniversiteler temel alanınıza ölçüt koyuyor ama ölçüt BİRİME göre
            değişiyor. Biriminizi seçin, karşılaştırmaya katılsınlar.
        </flux:callout.text>

        <div class="grid gap-3 sm:grid-cols-2">
            @foreach ($secenekler as $universiteAdi => $birimler)
                {{-- Boş seçenek ŞART: aday seçimi geri alabilmeli. --}}
                <x-secim-listesi model="birimSecimleri.{{ $universiteAdi }}" canli
                    :label="$universiteAdi" placeholder="Birim seçin..."
                    :secenekler="['' => 'Birim seçilmedi'] + collect($birimler)->mapWithKeys(fn ($b) => [$b => $b])->all()" />
            @endforeach
        </div>
    </div>
</flux:callout>
