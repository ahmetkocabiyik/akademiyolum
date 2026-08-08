<?php

namespace App\Livewire;

use App\Enums\TemelAlan;
use App\Models\Faaliyet;
use App\Models\Universite;
use App\Services\Scoring\Sart\Durum;
use App\Services\Scoring\Sart\SartDegerlendirici;
use App\Services\Scoring\Sart\SartDeposu;
use App\Services\Scoring\Sart\SartSonucu;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Üniversite yönergelerini adayın dosyasına karşı karşılaştırır.
 *
 * Değerlendirme {@see SartDegerlendirici} ile şart
 * ağacı üzerinden yapılır. Motor üç değerli sonuç ürettiği için ekran da dört
 * durum gösterir: uygun · eksik bilgi · yakın · yetersiz. "Eksik bilgi",
 * koşulun sağlanmadığı anlamına GELMEZ — adayın profilinde ya da faaliyet
 * tarihlerinde eksik olduğu için karara bağlanamadığı anlamına gelir.
 *
 * @phpstan-import-type Esik from SartDeposu
 *
 * @phpstan-type SonucSatiri array{
 *     universite: Universite,
 *     esik: Esik,
 *     sonuc: SartSonucu,
 *     toplam: int,
 *     baraj: int,
 *     oran: int,
 *     puan_orani: int,
 *     kalan: int,
 *     yapilabilir: bool,
 *     durum: string,
 *     eksik_sayisi: int,
 *     belirsiz_sayisi: int,
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
     * Detay panelinde gösterilen üniversite. Panel kapanınca sıfırlanmaz: aksi
     * halde kapanış animasyonu sürerken içerik boşalıp göz kırpma etkisi yaratıyor.
     */
    public ?int $secilenUniversiteId = null;

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

    protected function depo(): SartDeposu
    {
        return app(SartDeposu::class);
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
     * Akademik profilin doluluk oranı — "eksik bilgi" sonuçlarının gerekçesi.
     */
    #[Computed]
    public function profilDoluluk(): int
    {
        return Auth::user()->profilDoluluk();
    }

    /**
     * Filtrelenmiş ve sıralanmış üniversite karşılaştırma sonuçları.
     *
     * Yalnızca doğrulanmış şart ağacı olan üniversiteler listelenir; eşiği
     * olmayan üniversite için tahmini baraj üretilmez.
     *
     * @return list<SonucSatiri>
     */
    #[Computed]
    public function sonuclar(): array
    {
        $depo = $this->depo();
        $kullanici = Auth::user();
        $temelAlan = ($kullanici->temel_alan ?? TemelAlan::Sosyal)->value;
        $faaliyetler = $this->faaliyetler();
        // Atıf/proje/tez sayaçları faaliyetlerden türediği için profil onlarla
        // birlikte çözülür.
        $profil = $kullanici->sartProfili($faaliyetler);

        $universiteler = Universite::query()
            ->whereIn('ad', $depo->universiteler())
            ->when($this->turFiltre !== '', fn ($q) => $q->where('tur', $this->turFiltre))
            ->when($this->arama !== '', fn ($q) => $q->where(
                fn ($w) => $w->where('ad', 'like', "%{$this->arama}%")
                    ->orWhere('sehir', 'like', "%{$this->arama}%")
            ))
            ->get();

        $sonuclar = $universiteler
            ->map(function (Universite $universite) use ($depo, $temelAlan, $faaliyetler, $profil): ?array {
                $esik = $depo->bul($universite->ad, $this->hedefKadro, $temelAlan);

                if ($esik === null) {
                    return null;
                }

                $sonuc = $depo->degerlendir($esik, $faaliyetler, $profil);
                $toplamDugum = $sonuc->rolile('toplam');

                // Her ağaçta 'toplam' rolünde bir puan düğümü var; puansız
                // yönergelerde (ör. Samsun) olmayabilir — o zaman baraj 0.
                $toplam = $toplamDugum === null ? 0 : (int) $toplamDugum->mevcut;
                $baraj = $toplamDugum === null ? 0 : (int) $toplamDugum->gerekli;
                $oran = $this->genelOran($sonuc);

                return [
                    'universite' => $universite,
                    'esik' => $esik,
                    'sonuc' => $sonuc,
                    'toplam' => $toplam,
                    'baraj' => $baraj,
                    'oran' => $oran,
                    'puan_orani' => $baraj > 0 ? (int) min(100, round($toplam / $baraj * 100)) : 100,
                    'kalan' => max(0, $baraj - $toplam),
                    'yapilabilir' => $sonuc->saglandi(),
                    'durum' => $this->durum($sonuc, $oran),
                    'eksik_sayisi' => count($sonuc->eksikler()),
                    'belirsiz_sayisi' => count($sonuc->belirsizler()),
                ];
            })
            ->filter();

        $sonuclar = match ($this->siralama) {
            'baraj_azalan' => $sonuclar->sortByDesc('baraj'),
            'oran' => $sonuclar->sortByDesc('oran'),
            'alfabetik' => $sonuclar->sortBy(fn (array $s) => $s['universite']->ad),
            default => $sonuclar->sortBy('baraj'),
        };

        return array_values($sonuclar->all());
    }

    /**
     * Ekranın dört durumu. `eksik_bilgi`, koşulun sağlanmadığı değil karara
     * bağlanamadığı anlamına gelir — kesin olumsuz bir yaprak yoktur.
     */
    private function durum(SartSonucu $sonuc, int $oran): string
    {
        return match ($sonuc->durum) {
            Durum::Saglandi => 'uygun',
            Durum::Belirsiz => 'eksik_bilgi',
            Durum::Saglanmadi => $oran >= 80 ? 'yakin' : 'yetersiz',
        };
    }

    /**
     * En zayıf ölçülebilir koşulun doluluk oranı (0-100). Beyan ve ölçülemeyen
     * düğümler hesaba katılmaz.
     */
    private function genelOran(SartSonucu $sonuc): int
    {
        $olculebilir = $sonuc->topla(
            fn (SartSonucu $d) => $d->cocuklar === [] && ! $d->beyan && $d->gerekli !== null,
        );

        if ($olculebilir === []) {
            return $sonuc->saglandi() ? 100 : 0;
        }

        return (int) min(array_map(fn (SartSonucu $d) => $d->oran(), $olculebilir));
    }

    /**
     * Kart tıklamasıyla detay modalını açar.
     */
    public function detayAc(int $universiteId): void
    {
        $this->secilenUniversiteId = $universiteId;
        $this->detayAcik = true;
    }

    /**
     * Seçili üniversitenin detayı: sonuç satırının üzerine o yönergenin KENDİ
     * cetveline göre kategori bazlı puan dağılımı eklenir.
     *
     * @return array<string, mixed>|null
     */
    #[Computed]
    public function detay(): ?array
    {
        if ($this->secilenUniversiteId === null) {
            return null;
        }

        $sonuc = collect($this->sonuclar())
            ->first(fn (array $s) => $s['universite']->id === $this->secilenUniversiteId);

        if ($sonuc === null) {
            return null;
        }

        $katalog = $this->depo()->katalog($sonuc['esik']['cetvel']);

        return $sonuc + [
            'dagilim' => $katalog?->kategoriDagilimi($this->faaliyetler()) ?? [],
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
     * Sonuçların durum dağılımı (summary bar için).
     *
     * @return array{toplam: int, uygun: int, eksik_bilgi: int, yakin: int, yetersiz: int}
     */
    #[Computed]
    public function ozet(): array
    {
        $sonuclar = collect($this->sonuclar());

        return [
            'toplam' => $sonuclar->count(),
            'uygun' => $sonuclar->where('durum', 'uygun')->count(),
            'eksik_bilgi' => $sonuclar->where('durum', 'eksik_bilgi')->count(),
            'yakin' => $sonuclar->where('durum', 'yakin')->count(),
            'yetersiz' => $sonuclar->where('durum', 'yetersiz')->count(),
        ];
    }

    public function render(): View
    {
        return view('livewire.yonerge-analizi');
    }
}
