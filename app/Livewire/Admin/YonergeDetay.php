<?php

namespace App\Livewire\Admin;

use App\Enums\YoneticiIslemi;
use App\Models\GizliYonerge;
use App\Models\IslemKaydi;
use App\Models\Universite;
use App\Services\Scoring\Sart\SartDeposu;
use App\Services\Yonetim\YonergeOzeti;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Yönetim paneli — tek üniversitenin yönergesi: kadro × alan kapsamı,
 * künye ve geçici olarak yayından kaldırma.
 *
 * Puanlamaya dokunan hiçbir şey burada düzenlenmiyor (şart ağacı, cetvel);
 * yalnızca künye ve gizleme katmanı.
 *
 * @phpstan-import-type Satir from YonergeOzeti
 * @phpstan-import-type Hucre from YonergeOzeti
 *
 * @property-read Satir $satir
 * @property-read array<string, array<string, Hucre>> $matris
 */
#[Layout('layouts.admin')]
#[Title('Yönetim · Yönerge')]
class YonergeDetay extends Component
{
    public const TURLER = ['devlet' => 'Devlet', 'vakif' => 'Vakıf'];

    public string $universite = '';

    public string $sehir = '';

    public string $tur = 'devlet';

    public string $yonergeUrl = '';

    public string $gizlemeNedeni = '';

    public function mount(string $universite): void
    {
        abort_if(app(YonergeOzeti::class)->satir($universite) === null, 404);

        $this->universite = $universite;
        $kunye = Universite::query()->where('ad', $universite)->first();

        $this->sehir = (string) $kunye?->sehir;
        $this->tur = $kunye->tur ?? 'devlet';
        $this->yonergeUrl = (string) $kunye?->yonerge_url;
    }

    /**
     * @return Satir
     */
    #[Computed]
    public function satir(): array
    {
        return app(YonergeOzeti::class)->satir($this->universite) ?? abort(404);
    }

    /**
     * @return array<string, array<string, Hucre>>
     */
    #[Computed]
    public function matris(): array
    {
        return app(YonergeOzeti::class)->matris($this->universite);
    }

    /**
     * Künye: şehir, tür, resmi yönerge bağlantısı. Ad DEĞİŞTİRİLMİYOR: yönerge
     * dosyaları üniversiteyi adıyla tanıyor, ad değişirse eşleşme kopar.
     */
    public function kunyeKaydet(): void
    {
        $veri = $this->validate([
            'sehir' => ['nullable', 'string', 'max:60'],
            'tur' => ['required', 'in:'.implode(',', array_keys(self::TURLER))],
            'yonergeUrl' => ['nullable', 'url:http,https', 'max:500'],
        ], attributes: ['yonergeUrl' => 'yönerge bağlantısı', 'tur' => 'tür']);

        DB::transaction(function () use ($veri): void {
            Universite::query()->updateOrCreate(['ad' => $this->universite], [
                'sehir' => $veri['sehir'] ?: null,
                'tur' => $veri['tur'],
                'yonerge_url' => $veri['yonergeUrl'] ?: null,
            ]);

            IslemKaydi::yaz(YoneticiIslemi::UniversiteGuncelledi, Auth::user(), null, array_filter([
                'universite' => $this->universite,
                'sehir' => $veri['sehir'] ?: null,
                'tur' => $veri['tur'],
            ]));
        });

        unset($this->satir);
        Flux::toast(variant: 'success', text: 'Künye kaydedildi.');
    }

    /**
     * Yönergeyi geçici olarak yayından kaldırır: adaya hiçbir ekranda görünmez,
     * kullanıcılarına "incelemede" denir. Veri silinmez; yayına alınınca döner.
     */
    public function gizle(): void
    {
        $this->validate(['gizlemeNedeni' => ['required', 'string', 'max:300']], attributes: ['gizlemeNedeni' => 'neden']);

        DB::transaction(function (): void {
            GizliYonerge::query()->updateOrCreate(['universite' => $this->universite], [
                'neden' => trim($this->gizlemeNedeni),
                'gizleyen_id' => Auth::id(),
            ]);

            IslemKaydi::yaz(YoneticiIslemi::YonergeGizledi, Auth::user(), null, [
                'universite' => $this->universite,
                'neden' => trim($this->gizlemeNedeni),
            ]);
        });

        app(SartDeposu::class)->gizlileriYenile();
        $this->reset('gizlemeNedeni');
        unset($this->satir);

        Flux::toast(text: "{$this->universite} yönergesi yayından kaldırıldı.");
    }

    public function yayinaAl(): void
    {
        DB::transaction(function (): void {
            $silinen = GizliYonerge::query()->where('universite', $this->universite)->delete();

            if ($silinen > 0) {
                IslemKaydi::yaz(YoneticiIslemi::YonergeYayinaAldi, Auth::user(), null, ['universite' => $this->universite]);
            }
        });

        app(SartDeposu::class)->gizlileriYenile();
        unset($this->satir);

        Flux::toast(variant: 'success', text: "{$this->universite} yönergesi yeniden yayında.");
    }

    public function render(): View
    {
        return view('livewire.admin.yonerge-detay');
    }
}
