@props(['sablon', 'aralik', 'hedefKadro', 'hedefKurum', 'kurumlar', 'bolumler', 'juriVar'])

@use('App\Enums\Kadro')
@use('App\Livewire\CiktiYonetimi')
@use('App\Services\Cikti\RaporDerleyici')

{{-- SOL PANEL — raporun ayarları. Hiçbiri veriyi değiştirmez; bölüm anahtarı
     kapattığı bölümü yalnızca çıktıdan çıkarır. --}}
<flux:card {{ $attributes->class('flex min-h-0 flex-col gap-6 overflow-y-auto !p-5') }}>

    {{-- Şablon --}}
    <div>
        <flux:heading size="sm">Rapor Şablonu</flux:heading>
        <flux:text class="!mt-0.5 !text-xs">Başvuru amacınıza uygun görünümü seçin</flux:text>

        <div class="mt-3 grid grid-cols-2 gap-2">
            @foreach (CiktiYonetimi::SABLONLAR as $deger => $secenek)
                @php $secili = $sablon === $deger; @endphp
                <button type="button" wire:click="sablonSec('{{ $deger }}')"
                    aria-pressed="{{ $secili ? 'true' : 'false' }}"
                    @class([
                        'overflow-hidden rounded-xl border text-start transition',
                        'border-brand ring-2 ring-brand/20' => $secili,
                        'border-line hover:border-line-strong' => ! $secili,
                    ])>
                    {{-- Küçük sayfa taslağı: başlık bandı + birkaç satır --}}
                    <span @class([
                        'flex h-16 flex-col justify-center gap-1.5 px-3',
                        'bg-navy' => $deger === 'prestijli',
                        'border-b border-line bg-white' => $deger === 'minimal',
                    ])>
                        <span @class(['block h-1.5 w-3/5 rounded-full', 'bg-gold/80' => $deger === 'prestijli', 'bg-ink/70' => $deger === 'minimal'])></span>
                        <span @class(['block h-1 w-4/5 rounded-full', 'bg-white/25' => $deger === 'prestijli', 'bg-line-strong' => $deger === 'minimal'])></span>
                        <span @class(['block h-1 w-2/3 rounded-full', 'bg-white/15' => $deger === 'prestijli', 'bg-line' => $deger === 'minimal'])></span>
                    </span>
                    <span class="block px-3 py-2">
                        <span @class(['block text-xs', 'font-semibold text-brand' => $secili, 'text-ink' => ! $secili])>{{ $secenek['etiket'] }}</span>
                        <span class="mt-0.5 block text-[10px] leading-tight text-ink-subtle">{{ $secenek['aciklama'] }}</span>
                    </span>
                </button>
            @endforeach
        </div>
    </div>

    {{-- Rapor bilgileri --}}
    <div class="flex flex-col gap-3">
        <flux:heading size="sm">Rapor Bilgileri</flux:heading>

        <flux:input wire:model.live.debounce.400ms="baslik" label="Rapor Başlığı" size="sm" />

        <div>
            <flux:select wire:model.live="aralik" label="Tarih Aralığı" size="sm">
                @foreach (RaporDerleyici::ARALIKLAR as $deger => $etiket)
                    <flux:select.option :value="$deger">{{ $etiket }}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:text class="!mt-1 !text-[11px]">Yalnızca listeleri daraltır; puan ve hedef analizi tüm onaylı faaliyetlerle hesaplanır.</flux:text>
        </div>

        <flux:select wire:model.live="hedefKadro" label="Hedef Kadro" size="sm">
            @foreach (Kadro::etiketler() as $deger => $etiket)
                <flux:select.option :value="$deger">{{ $etiket }}</flux:select.option>
            @endforeach
        </flux:select>

        <flux:select wire:model.live="hedefKurum" label="Hedef Kurum" size="sm">
            <flux:select.option value="">Hedef yok</flux:select.option>
            @foreach ($kurumlar as $kurum)
                <flux:select.option :value="$kurum">{{ $kurum }}</flux:select.option>
            @endforeach
        </flux:select>

        @if ($hedefKurum === '')
            <flux:text class="!text-[11px]">Hedef kurum seçilmeden puan ve koşullar basılmaz; yalnızca faaliyetler ve başvurulabilir üniversiteler listelenir.</flux:text>
        @endif
    </div>

    {{-- İçerik seçimi --}}
    <div>
        <flux:heading size="sm">İçerik Seçimi</flux:heading>

        <div class="mt-2 flex flex-col">
            @foreach (CiktiYonetimi::BOLUMLER as $bolum => $secenek)
                @php $acik = (bool) ($bolumler[$bolum] ?? false); @endphp
                <button type="button" wire:click="bolumDegistir('{{ $bolum }}')"
                    role="switch" aria-checked="{{ $acik ? 'true' : 'false' }}"
                    class="flex items-center justify-between gap-3 border-b border-line py-2.5 text-start last:border-0">
                    <span class="min-w-0">
                        <span class="block text-xs font-medium text-ink">{{ $secenek['etiket'] }}</span>
                        <span class="block text-[11px] text-ink-subtle">
                            {{-- Jüri özeti YZ'ye yeniden yazdırılmıyor; rapor yoksa adaya nereden üreteceği söyleniyor. --}}
                            @if ($bolum === 'juri' && ! $juriVar)
                                Bu hedef için jüri raporu yok; YZ Jüri Analizi'nden üretin.
                            @else
                                {{ $secenek['aciklama'] }}
                            @endif
                        </span>
                    </span>
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
</flux:card>
