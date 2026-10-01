@props(['sablon', 'renk', 'yaziTipi', 'bolumler'])

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
                    <span class="mt-0.5 block text-[10px] leading-tight text-ink-subtle">{{ $secenek->aciklama() }}</span>
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
        {{-- Sade şablon rengi yok sayar; aday renge basıp hiçbir şey olmayınca
             arızalı sanıyordu. --}}
        @if ($sablon === CvSablonu::Sade->value)
            <flux:text class="!mt-1.5 !text-[11px]">Sade şablon tek renkle basar; renk seçimi diğer şablonlarda geçerli.</flux:text>
        @endif
    </div>

    {{-- Yazı tipi --}}
    <div>
        <flux:label class="!mb-1.5 block">Yazı Tipi</flux:label>
        <div class="flex flex-col gap-1.5">
            @foreach (CvYaziTipi::cases() as $secenek)
                @php $secili = $yaziTipi === $secenek->value; @endphp
                <button type="button" wire:click="yaziTipiSec('{{ $secenek->value }}')"
                    aria-pressed="{{ $secili ? 'true' : 'false' }}"
                    @class([
                        'flex items-baseline justify-between rounded-xl border px-3 py-2 transition',
                        'border-brand bg-brand-light' => $secili,
                        'border-line hover:border-line-strong' => ! $secili,
                    ])>
                    <span class="text-xs" style="font-family: {{ $secenek->yigin() }}">{{ $secenek->etiket() }}</span>
                    <span class="text-[10px] text-ink-subtle">{{ $secenek->aciklama() }}</span>
                </button>
            @endforeach
        </div>
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
        <flux:button x-on:click="window.print()" icon="arrow-down-tray" class="w-full !bg-navy !text-white">
            PDF Olarak İndir
        </flux:button>
        <flux:button wire:click="jsonIndir" icon="code-bracket" variant="subtle" class="w-full">
            JSON Olarak Dışa Aktar
        </flux:button>
        <flux:text class="!text-[11px] leading-relaxed">
            PDF, tarayıcının yazdırma penceresinden alınır: açılan pencerede
            hedef olarak <strong>“PDF olarak kaydet”</strong> seçin.
        </flux:text>
    </div>
</flux:card>
