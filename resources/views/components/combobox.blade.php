@props([
    'model',
    /** list<string>|Collection<int, string> — çağıran ekranlar ikisini de veriyor. */
    'secenekler',
    'label' => null,
    'placeholder' => 'Yazarak arayın...',
    'description' => null,
    'sinir' => 50,
    'bos' => null,
])

{{--
    YAZILABİLİR SEÇİM KUTUSU — hem liste açılır hem yazarak aranır.

    İki yüzlü olmasının sebebi listelerin uzunluğu: üniversite listesi 175
    satır, düz bir <select> içinde aday aradığını kaydırarak bulamıyor. Odağa
    gelince tüm liste (ilk {{ $sinir }} satır) açılıyor, yazdıkça süzülüyor.

    Filtre İSTEMCİDE: her tuşta sunucuya gitmek 175 satırlık bir liste için
    gereksiz tur, üstelik yazarken liste gecikmeli güncelleniyordu.
    Karşılaştırma Türkçe harf katlamasıyla ('tr' locale) yapılıyor — PHP
    tarafındaki mb_strtolower ile aynı davranış, yoksa "İSTANBUL" yazan aday
    "İstanbul"u bulamıyordu.

    Süzme yalnızca ADAY YAZDIKTAN sonra başlıyor (`yazildi`): kutuda seçili bir
    değer varken metin zaten tam bir seçeneğe eşit olduğundan filtre listeyi tek
    satıra indiriyor ve odaklanan aday "liste açılmıyor" sanıyordu. Seçim
    yapıldığında bayrak sıfırlanır, kutu yeniden tam listeyi açar.

    Serbest metne izin var: kutu değeri doğrulamıyor, yalnızca bulmayı
    kolaylaştırıyor. Değerin geçerliliğini kullanan ekran söylüyor (jüri
    analizinde "yönergesi girilmiş bir kurum seçin" uyarısı gibi).
--}}
<div
    x-data="{
        sorgu: @entangle($model),
        acik: false,
        yazildi: false,
        vurgu: -1,
        tumu: @js(collect($secenekler)->values()->all()),
        get sonuclar() {
            const q = this.yazildi ? (this.sorgu || '').toLocaleLowerCase('tr') : '';
            let liste = q ? this.tumu.filter(s => s.toLocaleLowerCase('tr').includes(q)) : this.tumu;
            // Seçili değer listenin başına alınır: liste ilk {{ (int) $sinir }}
            // satırla sınırlı, alfabenin sonundaki bir seçim açılan listede hiç
            // görünmüyordu.
            if (! q && this.sorgu && liste.includes(this.sorgu)) {
                liste = [this.sorgu, ...liste.filter(s => s !== this.sorgu)];
            }
            return liste.slice(0, {{ (int) $sinir }});
        },
        sec(s) { this.sorgu = s; this.acik = false; this.yazildi = false; this.vurgu = -1; },
        asagi() { this.acik = true; if (this.vurgu < this.sonuclar.length - 1) this.vurgu++; },
        yukari() { if (this.vurgu > 0) this.vurgu--; },
        enter() { if (this.acik && this.vurgu >= 0 && this.sonuclar[this.vurgu]) { this.sec(this.sonuclar[this.vurgu]); } else { this.acik = false; } },
    }"
    @click.outside="acik = false"
    x-on:keydown.escape="acik = false"
    {{ $attributes->class('relative') }}
>
    <flux:input
        :label="$label"
        :placeholder="$placeholder"
        :description="$description"
        x-model="sorgu"
        x-on:focus="acik = true"
        x-on:input="acik = true; yazildi = true; vurgu = -1"
        x-on:keydown.arrow-down.prevent="asagi()"
        x-on:keydown.arrow-up.prevent="yukari()"
        x-on:keydown.enter.prevent="enter()"
        autocomplete="off"
    />

    <div x-show="acik && sonuclar.length" x-transition.opacity x-cloak
        class="absolute z-20 mt-1 max-h-64 w-full overflow-auto rounded-lg border border-line bg-surface py-1 shadow-lg">
        <template x-for="(s, idx) in sonuclar" :key="s">
            <button type="button" @click="sec(s)" @mouseenter="vurgu = idx"
                class="block w-full truncate px-3 py-2 text-start text-sm"
                {{-- Seçili satır işaretli: tam liste açıldığında aday hangisinde
                     olduğunu göremiyordu. --}}
                :class="vurgu === idx ? 'bg-brand-light text-brand' : (s === sorgu ? 'bg-canvas font-medium text-ink' : 'text-ink')"
                x-text="s"></button>
        </template>
    </div>

    {{-- Yazılan metin hiçbir satırı tutmuyorsa kutu sessizce boş bir liste
         gösteriyordu; aday yazdığının bulunamadığını değil, listenin kapandığını
         görüyordu. --}}
    @if ($bos !== null)
        <div x-show="acik && yazildi && sorgu && ! sonuclar.length" x-cloak
            class="absolute z-20 mt-1 w-full rounded-lg border border-line bg-surface px-3 py-2 text-xs text-ink-subtle shadow-lg">
            {{ $bos }}
        </div>
    @endif
</div>
