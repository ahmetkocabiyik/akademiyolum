<?php

namespace App\Livewire\Admin;

use App\Enums\YoneticiIslemi;
use App\Enums\YzOzelligi;
use App\Enums\YzSaglayiciTuru;
use App\Models\IslemKaydi;
use App\Models\YzAyari;
use App\Services\AI\YzAyarlari as YzAyarDeposu;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Yönetim paneli — YZ Danışman ve YZ Jüri Analizi'nin sağlayıcısı (Claude,
 * OpenAI) ve modeli. Her özellik ayrı kaydedilir; değişiklik bir sonraki
 * YZ çağrısında geçerli olur. Anahtarlar .env'de kalır: anahtarı olmayan
 * sağlayıcı seçilemez.
 */
#[Layout('layouts.admin')]
#[Title('Yönetim · YZ Ayarları')]
class YzAyarlari extends Component
{
    /**
     * Form durumu, özellik değerine göre.
     *
     * @var array<string, array{saglayici: string, model: string}>
     */
    public array $ayarlar = [];

    public function mount(YzAyarDeposu $depo): void
    {
        foreach (YzOzelligi::cases() as $ozellik) {
            $kayit = $depo->kayit($ozellik);

            $this->ayarlar[$ozellik->value] = [
                'saglayici' => $depo->secim($ozellik)['saglayici']->value,
                'model' => (string) $kayit?->model,
            ];
        }
    }

    public function kaydet(string $deger, YzAyarDeposu $depo): void
    {
        $ozellik = YzOzelligi::tryFrom($deger) ?? abort(404);
        $onek = "ayarlar.{$deger}";

        $this->validate([
            "{$onek}.saglayici" => ['required', Rule::in(array_map(fn (YzSaglayiciTuru $t) => $t->value, YzSaglayiciTuru::secilebilenler()))],
            "{$onek}.model" => ['nullable', 'string', 'max:100', 'regex:/^[A-Za-z0-9._:\-\/\[\]]+$/'],
        ], attributes: [
            "{$onek}.saglayici" => 'sağlayıcı',
            "{$onek}.model" => 'model',
        ]);

        $tur = YzSaglayiciTuru::from($this->ayarlar[$deger]['saglayici']);

        if (! $tur->anahtarVar()) {
            $this->addError("{$onek}.saglayici", "{$tur->etiket()} için API anahtarı .env'de tanımlı değil.");

            return;
        }

        $model = $tur === YzSaglayiciTuru::Stub ? null : (trim($this->ayarlar[$deger]['model']) ?: null);
        $once = $depo->secim($ozellik);

        DB::transaction(function () use ($ozellik, $tur, $model, $once, $depo): void {
            YzAyari::query()->updateOrCreate(
                ['ozellik' => $ozellik->value],
                ['saglayici' => $tur->value, 'model' => $model, 'guncelleyen_id' => Auth::id()],
            );

            $sonra = $depo->secim($ozellik);

            IslemKaydi::yaz(YoneticiIslemi::YzAyariGuncelledi, Auth::user(), null, [
                'ozellik' => $ozellik->etiket(),
                'saglayici' => $once['saglayici']->etiket().' → '.$sonra['saglayici']->etiket(),
                'model' => ($once['model'] ?? '—').' → '.($sonra['model'] ?? '—'),
            ]);
        });

        $this->ayarlar[$deger]['model'] = (string) $model;

        Flux::toast(variant: 'success', text: "{$ozellik->etiket()} artık {$tur->etiket()} kullanıyor.");
    }

    public function render(YzAyarDeposu $depo): View
    {
        return view('livewire.admin.yz-ayarlari', [
            'ozellikler' => YzOzelligi::cases(),
            'saglayicilar' => YzSaglayiciTuru::secilebilenler(),
            'kayitlar' => collect(YzOzelligi::cases())->mapWithKeys(fn (YzOzelligi $o) => [$o->value => $depo->kayit($o)]),
        ]);
    }
}
