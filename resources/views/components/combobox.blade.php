@props([
    'model',
    /** list<string>|Collection<int, string> — çağıran ekranlar ikisini de veriyor. */
    'secenekler',
    'label' => null,
    'placeholder' => 'Yazarak arayın...',
    'description' => null,
    'sinir' => 50,
    'bos' => null,
    /** Değer yalnızca listeden seçilerek değişir ve hemen sunucuya gider (filtreler için). */
    'secimZorunlu' => false,
    /** Seçim zorunluyken boş değerin etiketi, listenin başında seçenek olarak ("Tüm şehirler"). */
    'tumuEtiketi' => null,
    /** Serbest metin kutusunda seçim yapılınca ya da kutu kapanınca değeri sunucuya gönderir (bağlı listeler için). */
    'gonder' => false,
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

    `secimZorunlu` FİLTRELER için: yazılan metin yalnızca listeyi süzer,
    değer ancak listeden seçilince değişir ve hemen sunucuya gider. Serbest
    metin bir filtre olsaydı "Ank" yazan aday hiç sonuç görmezdi. Kutu
    kapanınca yazı seçili değere döner.

    `gonder` BAĞLI LİSTELER için (üniversite → fakülte → bölüm): değer her
    tuşta değil, seçim yapılınca ya da kutudan çıkılınca bir kez gönderilir;
    sunucu alttaki listeyi yeniden çizer. Bağlı kutu `wire:key`'ini listeye
    göre değiştirmeli, yoksa Alpine eski listeyi tutar.
--}}
<div
    x-data="{
        @if ($secimZorunlu)
            secili: @entangle($model).live,
            sorgu: '',
        @else
            sorgu: @entangle($model),
        @endif
        zorunlu: @js((bool) $secimZorunlu),
        gonder: @js((bool) $gonder),
        gonderilen: null,
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
        init() {
            this.gonderilen = this.sorgu;
            if (! this.zorunlu) return;
            this.sorgu = this.secili || '';
            // Değer dışarıdan değişirse (sıfırlama gibi) yazı da izlesin.
            this.$watch('secili', v => { if (! this.acik) this.sorgu = v || ''; });
        },
        sec(s) {
            if (this.zorunlu) this.secili = s;
            this.sorgu = s; this.acik = false; this.yazildi = false; this.vurgu = -1;
            this.gonderGerekirse();
        },
        kapat() {
            this.acik = false; this.yazildi = false; this.vurgu = -1;
            if (this.zorunlu) this.sorgu = this.secili || '';
            this.gonderGerekirse();
        },
        gonderGerekirse() {
            if (! this.gonder || this.zorunlu || this.sorgu === this.gonderilen) return;
            this.gonderilen = this.sorgu;
            this.$wire.$commit();
        },
        asagi() { this.acik = true; if (this.vurgu < this.sonuclar.length - 1) this.vurgu++; },
        yukari() { if (this.vurgu > 0) this.vurgu--; },
        enter() { if (this.acik && this.vurgu >= 0 && this.sonuclar[this.vurgu]) { this.sec(this.sonuclar[this.vurgu]); } else { this.kapat(); } },
    }"
    @click.outside="kapat()"
    x-on:keydown.escape="kapat()"
    {{ $attributes->class('relative') }}
>
    <flux:input
        :label="$label"
        :placeholder="$placeholder"
        :description="$description"
        x-model="sorgu"
        {{-- Seçim zorunluyken yazı seçili gelir: aday yazmaya başlayınca eski
             değer silinir, aramaya baştan başlar. (Koşul Alpine'de; bileşen
             etiketinin içinde Blade @if derlenmiyor.) --}}
        x-on:focus="acik = true; if (zorunlu) $event.target.select()"
        x-on:input="acik = true; yazildi = true; vurgu = -1"
        x-on:keydown.arrow-down.prevent="asagi()"
        x-on:keydown.arrow-up.prevent="yukari()"
        x-on:keydown.enter.prevent="enter()"
        x-on:keydown.tab="kapat()"
        autocomplete="off"
    />

    <div x-show="acik && (sonuclar.length || (@js($tumuEtiketi !== null) && ! yazildi))" x-transition.opacity x-cloak
        class="absolute z-20 mt-1 max-h-64 w-full overflow-auto rounded-lg border border-line bg-surface py-1 shadow-lg">
        @if ($tumuEtiketi !== null)
            {{-- Filtreyi kaldırma yolu: aday yazmaya başlamadıysa listenin başında. --}}
            <button type="button" x-show="! yazildi" @click="sec('')"
                class="block w-full truncate border-b border-line px-3 py-2 text-start text-sm"
                :class="! secili ? 'bg-canvas font-medium text-ink' : 'text-ink-muted hover:bg-canvas'">{{ $tumuEtiketi }}</button>
        @endif
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
