<?php

namespace App\Livewire;

use App\Enums\TemelAlan;
use App\Models\Faaliyet;
use App\Models\Yonerge;
use App\Models\YonergeEsik;
use App\Services\Scoring\EsikDegerlendirici;
use App\Services\Scoring\EsikSonuc;
use App\Services\Scoring\KuralSetiCozucu;
use App\Services\Scoring\PuanHesaplayici;
use App\Services\Scoring\PuanRaporu;
use App\Services\Scoring\RaporSonucu;
use App\Services\Scoring\RuleSet;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * @phpstan-type SonucSatiri array{
 *     yonerge: Yonerge,
 *     esik: YonergeEsik,
 *     sonuc: EsikSonuc,
 *     dogrulandi: bool,
 *     toplam: int,
 *     baraj: int,
 *     oran: int,
 *     puan_orani: int,
 *     yapilabilir: bool,
 *     kalan: int,
 *     durum: string,
 * }
 */
#[Layout('layouts.app')]
#[Title('Yönerge Analizi')]
class YonergeAnalizi extends Component
{
    public string $arama = '';

    public string $turFiltre = '';

    public string $hedefKadro = 'dr_ogr_uyesi';

    public string $siralama = 'baraj_artan';

    public string $gorunum = 'grid';

    public bool $karsilastirma = false;

    /**
     * Detay panelinde gösterilen yönerge. Panel kapanınca sıfırlanmaz: aksi halde
     * kapanış animasyonu sürerken içerik boşalıp göz kırpma etkisi yaratıyor.
     */
    public ?int $secilenYonergeId = null;

    public bool $detayAcik = false;

    /**
     * Hedef kadro etiketleri (seçici + başlık için).
     *
     * @var array<string, string>
     */
    public array $kadrolar = [
        'dr_ogr_uyesi' => 'Dr. Öğr. Üyesi',
        'docentlik' => 'Doçent',
        'profesorluk' => 'Profesör',
    ];

    /**
     * Varsayılan hedef kadro: kullanıcının bir üst kadrosu (yükselme hedefi).
     */
    public function mount(): void
    {
        $this->hedefKadro = match (Auth::user()->unvan) {
            'Doç. Dr.', 'Prof. Dr.' => 'profesorluk',
            'Dr. Öğr. Üyesi' => 'docentlik',
            default => 'dr_ogr_uyesi', // Arş. Gör. / Öğr. Gör.
        };
    }

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
     * @return list<SonucSatiri>
     */
    #[Computed]
    public function sonuclar(): array
    {
        $yonergeler = Yonerge::query()
            ->with(['universite', 'kurallar', 'esikler'])
            ->whereNotNull('universite_id')
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

        $temelAlan = Auth::user()->temel_alan ?? TemelAlan::Sosyal;

        // Yalnızca seçili kadro + temel alan için doğrulanmış eşiği olan üniversiteler.
        // Eşleşme tam (kadro + alan): yönerge bir eşiği birden çok alan için ortak
        // tanımlıyorsa esikler.php o grubu zaten alan başına ayrı satıra açıyor.
        $sonuclar = $yonergeler
            ->map(function (Yonerge $yonerge) use ($temelAlan): ?array {
                $esik = $this->esikBul($yonerge, $temelAlan);

                if ($esik === null) {
                    return null;
                }

                $ruleSet = RuleSet::fromYonerge($yonerge);
                $sonuc = (new EsikDegerlendirici($ruleSet))->degerlendir(
                    $this->yenidenPuanli($ruleSet),
                    $esik,
                );

                return [
                    'yonerge' => $yonerge,
                    'esik' => $esik,
                    'sonuc' => $sonuc,
                    'dogrulandi' => true,
                    // görünüm kolaylığı için:
                    'toplam' => $sonuc->toplam,
                    'baraj' => $esik->min_toplam,
                    'oran' => $sonuc->oran,
                    'puan_orani' => $esik->min_toplam > 0
                        ? (int) min(100, round($sonuc->toplam / $esik->min_toplam * 100))
                        : 100,
                    'yapilabilir' => $sonuc->uygun,
                    'kalan' => max(0, $esik->min_toplam - $sonuc->toplam),
                    'durum' => $sonuc->durum,
                ];
            })
            ->filter();

        $sonuclar = match ($this->siralama) {
            'baraj_azalan' => $sonuclar->sortByDesc('baraj'),
            'oran' => $sonuclar->sortByDesc('oran'),
            'alfabetik' => $sonuclar->sortBy(fn ($s) => $s['yonerge']->universite->ad),
            default => $sonuclar->sortBy('baraj'),
        };

        return array_values($sonuclar->all());
    }

    /**
     * Kart tıklamasıyla detay modalını açar.
     */
    public function detayAc(int $yonergeId): void
    {
        $this->secilenYonergeId = $yonergeId;
        $this->detayAcik = true;
    }

    /**
     * Seçili yönergenin detayı: sonuç satırının (SonucSatiri) üzerine o yönergenin
     * kural setine göre kategori bazlı puan dağılımı (`rapor`: RaporSonucu) eklenir.
     * Modal kapalıysa veya yönerge filtre dışında kaldıysa null.
     *
     * @return array<string, mixed>|null
     */
    #[Computed]
    public function detay(): ?array
    {
        if ($this->secilenYonergeId === null) {
            return null;
        }

        $sonuc = collect($this->sonuclar)
            ->first(fn (array $s) => $s['yonerge']->id === $this->secilenYonergeId);

        if ($sonuc === null) {
            return null;
        }

        $ruleSet = RuleSet::fromYonerge($sonuc['yonerge']);

        return $sonuc + [
            'rapor' => (new PuanRaporu($ruleSet))->olustur($this->yenidenPuanli($ruleSet)),
        ];
    }

    /**
     * Eşik alanının okunabilir adı (ör. "sosyal" → "Sosyal, Beşeri ve İdari Bilimler").
     */
    public function alanEtiketi(string $alan): string
    {
        return TemelAlan::tryFrom($alan)?->label() ?? ucfirst($alan);
    }

    /**
     * Yönergenin seçili kadro + temel alan için doğrulanmış eşiği. Yoksa null
     * döner ve üniversite listeye girmez — tahmini eşik gösterilmez.
     */
    private function esikBul(Yonerge $yonerge, TemelAlan $alan): ?YonergeEsik
    {
        return $yonerge->esikler->first(
            fn (YonergeEsik $esik) => $esik->kadro === $this->hedefKadro && $esik->alan === $alan->value
        );
    }

    /**
     * Kullanıcının faaliyetlerini verilen kural setine göre yeniden puanlanmış kopyalar.
     *
     * @return Collection<int, Faaliyet>
     */
    private function yenidenPuanli(RuleSet $ruleSet): Collection
    {
        $hesaplayici = new PuanHesaplayici($ruleSet);

        return $this->faaliyetler->map(function (Faaliyet $faaliyet) use ($hesaplayici): Faaliyet {
            $kopya = clone $faaliyet;
            $kopya->puan = $hesaplayici->hesapla($faaliyet);

            return $kopya;
        });
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

    public function render()
    {
        return view('livewire.yonerge-analizi');
    }
}
