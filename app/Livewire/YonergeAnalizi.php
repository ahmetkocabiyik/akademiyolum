<?php

namespace App\Livewire;

use App\Models\Faaliyet;
use App\Models\Yonerge;
use App\Services\Scoring\KuralSetiCozucu;
use App\Services\Scoring\PuanHesaplayici;
use App\Services\Scoring\PuanRaporu;
use App\Services\Scoring\RuleSet;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Yönerge Analizi')]
class YonergeAnalizi extends Component
{
    public string $arama = '';

    public string $turFiltre = '';

    public string $kadroFiltre = '';

    public string $siralama = 'baraj_artan';

    public string $gorunum = 'grid';

    public bool $karsilastirma = false;

    /**
     * Kullanıcının onaylı faaliyetleri.
     *
     * @return Collection<int, Faaliyet>
     */
    #[Computed]
    public function faaliyetler(): Collection
    {
        return Auth::user()->faaliyetler()->where('durum', 'onaylandi')->get();
    }

    /**
     * Kullanıcının kendi yönergesine göre toplam puanı.
     */
    #[Computed]
    public function profilToplam(): int
    {
        $ruleSet = (new KuralSetiCozucu)->kullaniciIcin(Auth::user());

        return (new PuanRaporu($ruleSet))->olustur($this->faaliyetler)->toplamPuan;
    }

    /**
     * Filtrelenmiş ve sıralanmış üniversite karşılaştırma sonuçları.
     *
     * @return list<array{yonerge: Yonerge, toplam: int, baraj: int, oran: int, yapilabilir: bool, kalan: int}>
     */
    #[Computed]
    public function sonuclar(): array
    {
        $yonergeler = Yonerge::query()
            ->with(['universite', 'kurallar'])
            ->whereNotNull('universite_id')
            ->when($this->kadroFiltre !== '', fn ($q) => $q->where('kadro', $this->kadroFiltre))
            ->when($this->turFiltre !== '', fn ($q) => $q->whereHas(
                'universite',
                fn ($u) => $u->where('tur', $this->turFiltre)
            ))
            ->when($this->arama !== '', fn ($q) => $q->whereHas(
                'universite',
                fn ($u) => $u->where('ad', 'like', "%{$this->arama}%")
                    ->orWhere('sehir', 'like', "%{$this->arama}%")
            ))
            ->get();

        $sonuclar = $yonergeler->map(function (Yonerge $yonerge): array {
            $toplam = $this->yonergeyeGorePuan($yonerge);
            $baraj = $yonerge->universite_hedef;
            $oran = $baraj > 0 ? (int) min(100, round($toplam / $baraj * 100)) : 0;
            $yapilabilir = $toplam >= $baraj;

            // Üç kademeli durum: uygun / yakın (>=%80) / yetersiz.
            $durum = $yapilabilir ? 'uygun' : ($oran >= 80 ? 'yakin' : 'yetersiz');

            return [
                'yonerge' => $yonerge,
                'toplam' => $toplam,
                'baraj' => $baraj,
                'oran' => $oran,
                'yapilabilir' => $yapilabilir,
                'kalan' => max(0, $baraj - $toplam),
                'durum' => $durum,
            ];
        });

        $sonuclar = match ($this->siralama) {
            'baraj_azalan' => $sonuclar->sortByDesc('baraj'),
            'oran' => $sonuclar->sortByDesc('oran'),
            'alfabetik' => $sonuclar->sortBy(fn ($s) => $s['yonerge']->universite->ad),
            default => $sonuclar->sortBy('baraj'),
        };

        return $sonuclar->values()->all();
    }

    /**
     * Sonuçların durum dağılımı (summary bar için).
     *
     * @return array{toplam: int, uygun: int, yakin: int, yetersiz: int}
     */
    #[Computed]
    public function ozet(): array
    {
        $sonuclar = collect($this->sonuclar);

        return [
            'toplam' => $sonuclar->count(),
            'uygun' => $sonuclar->where('durum', 'uygun')->count(),
            'yakin' => $sonuclar->where('durum', 'yakin')->count(),
            'yetersiz' => $sonuclar->where('durum', 'yetersiz')->count(),
        ];
    }

    /**
     * Kullanıcının faaliyetlerini verilen yönergenin kurallarına göre yeniden puanlar.
     */
    private function yonergeyeGorePuan(Yonerge $yonerge): int
    {
        $ruleSet = RuleSet::fromYonerge($yonerge);
        $hesaplayici = new PuanHesaplayici($ruleSet);

        $yenidenPuanli = $this->faaliyetler->map(function (Faaliyet $faaliyet) use ($hesaplayici): Faaliyet {
            $kopya = clone $faaliyet;
            $kopya->puan = $hesaplayici->hesapla($faaliyet);

            return $kopya;
        });

        return (new PuanRaporu($ruleSet))->olustur($yenidenPuanli)->toplamPuan;
    }

    public function render()
    {
        return view('livewire.yonerge-analizi');
    }
}
