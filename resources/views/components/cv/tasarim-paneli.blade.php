@props(['sablon', 'renk', 'cizgiRenk', 'yaziTipi', 'bolumler'])

@use('App\Enums\CvBolumu')
@use('App\Enums\CvSablonu')
@use('App\Enums\CvYaziTipi')
@use('App\Models\CvProfili')

{{-- SAĞ PANEL — sunum ayarları. Hiçbiri içeriği değiştirmez; bölüm anahtarı
     bile kapattığı bölümü SİLMEZ, yalnızca çıktıdan gizler. --}}
<flux:card {{ $attributes->class('flex min-h-0 flex-col gap-5 overflow-y-auto !p-5') }}>

    <div>
        <flux:heading size="sm">Tasarım</flux:heading>
        <flux:text class="!mt-1 !text-xs">Şablon, renk ve bölüm seçimi</flux:text>
    </div>

    {{-- Şablon --}}
    <div>
        <flux:label class="!mb-1.5 block">Şablon</flux:label>
        <div class="grid grid-cols-2 gap-2">
            @foreach (CvSablonu::cases() as $secenek)
                @php $secili = $sablon === $secenek->value; @endphp
                <button type="button" wire:click="sablonSec('{{ $secenek->value }}')"
                    aria-pressed="{{ $secili ? 'true' : 'false' }}"
                    @class([
                        'rounded-xl border p-2.5 text-start transition',
                        'border-brand bg-brand-light' => $secili,
                        'border-line hover:border-line-strong' => ! $secili,
                    ])>
                    <span @class(['block text-xs', 'font-semibold text-brand' => $secili, 'text-ink' => ! $secili])>
                        {{ $secenek->etiket() }}
                    </span>
                    <span class="mt-0.5 block text-2xs leading-tight text-ink-subtle">{{ $secenek->aciklama() }}</span>
                </button>
            @endforeach
        </div>
    </div>

    {{-- Renk --}}
    <div>
        <flux:label class="!mb-1.5 block">Renk</flux:label>
        <div class="flex flex-wrap gap-2">
            @foreach (CvProfili::RENKLER as $secenek)
                <button type="button" wire:click="renkSec('{{ $secenek }}')"
                    aria-pressed="{{ $renk === $secenek ? 'true' : 'false' }}"
                    aria-label="Renk {{ $secenek }}"
                    class="size-7 rounded-full transition"
                    @style([
                        'background: '.$secenek,
                        'box-shadow: 0 0 0 2px var(--color-surface), 0 0 0 4px '.$secenek => $renk === $secenek,
                    ])></button>
            @endforeach
        </div>
    </div>

    {{-- Çizgi rengi: bölüm başlıklarının alt çizgisi. --}}
    <div>
        <flux:label class="!mb-1.5 block">Çizgi Rengi</flux:label>
        <div class="flex flex-wrap gap-2">
            @foreach (CvProfili::CIZGI_RENKLERI as $secenek)
                <button type="button" wire:click="cizgiRenkSec('{{ $secenek }}')"
                    aria-pressed="{{ $cizgiRenk === $secenek ? 'true' : 'false' }}"
                    aria-label="Çizgi rengi {{ $secenek }}"
                    class="size-7 rounded-full border border-line transition"
                    @style([
                        'background: '.$secenek,
                        'box-shadow: 0 0 0 2px var(--color-surface), 0 0 0 4px '.$secenek => $cizgiRenk === $secenek,
                    ])></button>
            @endforeach
        </div>
    </div>

    {{-- Yazı tipi. Seçim wire:model'e değil yaziTipiSec'e gidiyor: değer
         enum'dan geçmeden yazılsaydı uydurma bir değer önizlemeyi çökertirdi. --}}
    <div>
        <x-secim-listesi eylem="yaziTipiSec" :deger="$yaziTipi" label="Yazı Tipi"
            :description-trailing="CvYaziTipi::from($yaziTipi)->aciklama()"
            :secenekler="collect(CvYaziTipi::cases())->mapWithKeys(fn ($y) => [$y->value => $y->etiket()])->all()"
            :stiller="collect(CvYaziTipi::cases())->mapWithKeys(fn ($y) => [$y->value => 'font-family: '.$y->yigin()])->all()" />
    </div>

    {{-- Bölümler --}}
    <div>
        <flux:label class="!mb-1.5 block">Gösterilen Bölümler</flux:label>
        <div class="flex flex-col">
            @foreach (CvBolumu::cases() as $bolum)
                @php $acik = (bool) ($bolumler[$bolum->value] ?? true); @endphp
                <button type="button" wire:click="bolumDegistir('{{ $bolum->value }}')"
                    role="switch" aria-checked="{{ $acik ? 'true' : 'false' }}"
                    class="flex items-center justify-between border-b border-line py-2 last:border-0">
                    <span class="text-xs text-ink-muted">{{ $bolum->etiket() }}</span>
                    <span @class([
                        'relative h-5 w-9 shrink-0 rounded-full transition',
                        'bg-brand' => $acik,
                        'bg-line-strong' => ! $acik,
                    ])>
                        <span @class([
                            'absolute top-0.5 size-4 rounded-full bg-white transition-all',
                            'start-[18px]' => $acik,
                            'start-0.5' => ! $acik,
                        ])></span>
                    </span>
                </button>
            @endforeach
        </div>
    </div>

    <flux:separator variant="subtle" />

    <div class="flex flex-col gap-2">
        {{-- PDF tarayıcının yazdırma penceresinden alınıyor: ayrı bir PDF
             şablonu tutulsaydı ekranda görülenle çıktı zamanla ayrışırdı. --}}
        <flux:button x-on:click="window.print()" icon="arrow-down-tray" variant="primary" class="w-full">
            PDF Olarak İndir
        </flux:button>
        <flux:button wire:click="jsonIndir" icon="code-bracket" variant="subtle" class="w-full">
            JSON Olarak Dışa Aktar
        </flux:button>
        <flux:text class="!text-xs leading-relaxed">
            PDF, tarayıcının yazdırma penceresinden alınır: açılan pencerede
            hedef olarak <strong>“PDF olarak kaydet”</strong> seçin.
        </flux:text>
    </div>
</flux:card>
