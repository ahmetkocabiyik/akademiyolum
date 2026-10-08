<?php

namespace App\Livewire\Admin;

use App\Services\Yonetim\YonergeOzeti;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

/**
 * Yönetim paneli — üniversite yönergelerinin durumu (salt okunur liste).
 *
 * Yönerge verisi kodda; buradan yalnızca görülüyor. Künye ve gizleme
 * üniversitenin detay sayfasında.
 *
 * @phpstan-import-type Satir from YonergeOzeti
 *
 * @property-read list<Satir> $tumu
 * @property-read list<Satir> $satirlar
 * @property-read array<string, int> $sayilar
 */
#[Layout('layouts.admin')]
#[Title('Yönetim · Yönergeler')]
class Yonergeler extends Component
{
    public const DURUMLAR = [
        'dogrulandi' => 'Doğrulandı',
        'taslak' => 'Yalnız taslak',
        'gizli' => 'Gizli',
        'yok' => 'Yönerge yok',
    ];

    #[Url(except: '')]
    public string $arama = '';

    #[Url(except: '')]
    public string $durum = '';

    /**
     * @return list<Satir>
     */
    #[Computed]
    public function tumu(): array
    {
        return app(YonergeOzeti::class)->satirlar();
    }

    /**
     * @return list<Satir>
     */
    #[Computed]
    public function satirlar(): array
    {
        $arama = mb_strtolower(trim($this->arama), 'UTF-8');

        return array_values(array_filter($this->tumu, fn (array $s) => ($this->durum === '' || $s['durum'] === $this->durum)
            && ($arama === '' || str_contains(mb_strtolower($s['ad'].' '.$s['sehir'], 'UTF-8'), $arama))));
    }

    /**
     * Durum sayaçları (filtreden bağımsız, hep tüm dağılım).
     *
     * @return array<string, int>
     */
    #[Computed]
    public function sayilar(): array
    {
        $sayilar = array_fill_keys(array_keys(self::DURUMLAR), 0);

        foreach ($this->tumu as $satir) {
            $sayilar[$satir['durum']]++;
        }

        return $sayilar;
    }

    public function render(): View
    {
        return view('livewire.admin.yonergeler');
    }
}
