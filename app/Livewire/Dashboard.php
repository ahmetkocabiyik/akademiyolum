<?php

namespace App\Livewire;

use App\Enums\Kadro;
use App\Enums\Kategori;
use App\Enums\TemelAlan;
use App\Models\BeyanOnayi;
use App\Models\Faaliyet;
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
 * Adayın kendi üniversitesindeki durumu.
 *
 * Puanlama {@see SartDegerlendirici} ile, Yönerge
 * Analizi ekranıyla AYNI motordan gelir — iki ekran aynı sayıyı gösterir.
 *
 * Kullanıcının üniversitesinin yönergesi henüz girilmemişse puan gösterilmez:
 * tahmini baraj üretmek yerine "veri yok" denir.
 *
 * Livewire #[Computed] metotları özellik gibi okunur ($this->faaliyetler);
 * aşağıdaki @property-read satırları bunu statik analize bildirir.
 *
 * @phpstan-import-type Esik from SartDeposu
 *
 * @property-read Collection<int, Faaliyet> $faaliyetler
 * @property-read Collection<int, Faaliyet> $onayli
 * @property-read string $hedefKadro
 * @property-read Esik|null $esik
 * @property-read SartSonucu|null $sonuc
 * @property-read list<array{kategori: Kategori, puan: int, adet: int}> $dagilim
 * @property-read int $toplam
 * @property-read int|null $baraj
 * @property-read int $yuzde
 * @property-read string|null $durum
 * @property-read list<array{tip: string, baslik: string, aciklama: string}> $bildirimler
 */
#[Layout('layouts.app')]
#[Title('Dashboard')]
class Dashboard extends Component
{
    /**
     * Kullanıcının faaliyetleri (en yeni önce).
     *
     * @return Collection<int, Faaliyet>
     */
    #[Computed]
    public function faaliyetler(): Collection
    {
        return Auth::user()->faaliyetler()->latest()->get();
    }

    /**
     * @return Collection<int, Faaliyet>
     */
    #[Computed]
    public function onayli(): Collection
    {
        return $this->faaliyetler->where('durum', 'onaylandi');
    }

    /**
     * Hedef kadro: kullanıcının bir üst kadrosu.
     */
    #[Computed]
    public function hedefKadro(): string
    {
        return Kadro::hedef(Auth::user()->unvan)->value;
    }

    /**
     * Kullanıcının KENDİ üniversitesinin eşiği. Yönergesi girilmemişse null.
     *
     * @return Esik|null
     */
    #[Computed]
    public function esik(): ?array
    {
        $user = Auth::user();

        if ($user->universite === null) {
            return null;
        }

        return app(SartDeposu::class)->bul(
            $user->universite,
            $this->hedefKadro,
            ($user->temel_alan ?? TemelAlan::Sosyal)->value,
            $user->birim,
        );
    }

    #[Computed]
    public function sonuc(): ?SartSonucu
    {
        $esik = $this->esik;

        if ($esik === null) {
            return null;
        }

        $user = Auth::user();

        return app(SartDeposu::class)->degerlendir(
            $esik,
            $this->onayli,
            $user->sartProfili($this->onayli),
            // Yönerge Analizi'nde işaretlenen "belgem var" beyanları burada da
            // geçerli; iki ekran aynı eşik için farklı durum gösteremez.
            $this->beyanOnaylari($esik['anahtar']),
        );
    }

    /**
     * Adayın Yönerge Analizi'nde işaretlediği "belgem var" beyanları.
     *
     * @return list<string>
     */
    private function beyanOnaylari(string $esikAnahtari): array
    {
        $anahtarlar = [];

        $onaylar = BeyanOnayi::query()
            ->where('user_id', Auth::id())
            ->where('esik_anahtari', $esikAnahtari)
            ->get();

        foreach ($onaylar as $onay) {
            $anahtarlar[] = $onay->kosul_anahtari;
        }

        return $anahtarlar;
    }

    /**
     * Faaliyetlerin kendi üniversitesinin cetveline göre kategori dağılımı.
     * Yönerge girilmemişse yalnızca adetler döner (puan 0).
     *
     * @return list<array{kategori: Kategori, puan: int, adet: int}>
     */
    #[Computed]
    public function dagilim(): array
    {
        $esik = $this->esik;
        $katalog = $esik !== null ? app(SartDeposu::class)->katalog($esik['cetvel']) : null;

        $ham = $katalog?->kategoriDagilimi($this->onayli) ?? [];
        $satirlar = [];

        foreach ($this->onayli->groupBy(fn (Faaliyet $f) => $f->kategori->value) as $deger => $grup) {
            $kategori = Kategori::tryFrom((string) $deger);

            if ($kategori === null) {
                continue;
            }

            $satirlar[] = [
                'kategori' => $kategori,
                'puan' => $ham[$deger]['puan'] ?? 0,
                'adet' => $grup->count(),
            ];
        }

        usort($satirlar, fn (array $a, array $b) => $b['puan'] <=> $a['puan'] ?: $b['adet'] <=> $a['adet']);

        return $satirlar;
    }

    #[Computed]
    public function toplam(): int
    {
        return array_sum(array_column($this->dagilim, 'puan'));
    }

    /**
     * Kendi üniversitesinin toplam puan barajı. Yönerge yoksa ya da yönerge
     * puan kullanmıyorsa (ör. Samsun) null.
     */
    #[Computed]
    public function baraj(): ?int
    {
        return $this->sonuc?->rolile('toplam')?->gerekli;
    }

    #[Computed]
    public function yuzde(): int
    {
        $baraj = $this->baraj;

        if ($baraj === null || $baraj <= 0) {
            return 0;
        }

        return (int) min(100, round($this->toplam / $baraj * 100));
    }

    /**
     * Ekran durumu — Yönerge Analizi ile aynı sözlük.
     */
    #[Computed]
    public function durum(): ?string
    {
        return match ($this->sonuc?->durum) {
            Durum::Saglandi => 'uygun',
            Durum::Belirsiz => 'eksik_bilgi',
            Durum::Saglanmadi => $this->yuzde >= 80 ? 'yakin' : 'yetersiz',
            default => null,
        };
    }

    /**
     * Bildirimler artık sabit metin değil, adayın KENDİ eşik sonucundan türer.
     *
     * @return list<array{tip: string, baslik: string, aciklama: string}>
     */
    #[Computed]
    public function bildirimler(): array
    {
        $user = Auth::user();
        $sonuc = $this->sonuc;

        if ($sonuc === null) {
            // Gizlenen yönerge "girilmedi" değil: veri var, yönetici geçici
            // olarak yayından kaldırdı (Yönetim → Yönergeler).
            $gizli = $user->universite !== null && app(SartDeposu::class)->gizliMi($user->universite);

            return [[
                'tip' => 'info',
                'baslik' => match (true) {
                    $user->universite === null => 'Üniversitenizi seçin',
                    $gizli => $user->universite.' yönergesi geçici olarak incelemede',
                    default => $user->universite.' yönergesi henüz girilmedi',
                },
                'aciklama' => $gizli
                    ? 'Kriterler yeniden doğrulanıyor; kısa süre içinde tekrar görünecek. Bu sırada diğer üniversiteleri Yönerge Analizi\'nden karşılaştırabilirsiniz.'
                    : 'Yönerge Analizi ekranından verisi girilmiş üniversiteleri karşılaştırabilirsiniz.',
            ]];
        }

        $bildirimler = [];

        // Kesin karşılanmayan koşullar — en fazla üç tanesi.
        foreach (array_slice($sonuc->eksikler(), 0, 3) as $eksik) {
            $bildirimler[] = [
                'tip' => 'danger',
                'baslik' => $eksik->aciklama,
                'aciklama' => $eksik->gerekli !== null
                    ? "Mevcut {$eksik->mevcut} / gereken {$eksik->gerekli}"
                    : 'Koşul karşılanmıyor',
            ];
        }

        $belirsiz = count($sonuc->belirsizler());

        if ($belirsiz > 0) {
            $bildirimler[] = [
                'tip' => 'warn',
                'baslik' => "{$belirsiz} koşul değerlendirilemedi",
                'aciklama' => 'Faaliyet tarihlerini ve akademik profilinizi tamamlayın.',
            ];
        }

        // Beyan koşulunda eksik veri yok; aday belge hazırlayacak.
        $beyan = count($sonuc->beyanlar());

        if ($beyan > 0) {
            $bildirimler[] = [
                'tip' => 'info',
                'baslik' => "{$beyan} koşul belge ile teyit edilecek",
                'aciklama' => 'Bu koşullar otomatik doğrulanamaz; başvuru dosyanıza belge ekleyin.',
            ];
        }

        if ($sonuc->saglandi()) {
            $bildirimler[] = [
                'tip' => 'info',
                'baslik' => 'Tüm asgari koşulları karşılıyorsunuz',
                'aciklama' => $user->universite.' · '.$this->kadroEtiketi(),
            ];
        } elseif ($this->baraj !== null && $this->toplam < $this->baraj) {
            $bildirimler[] = [
                'tip' => 'info',
                'baslik' => 'Barajı geçmek için '.($this->baraj - $this->toplam).' puan kaldı',
                'aciklama' => "Mevcut: {$this->toplam} / {$this->baraj}",
            ];
        }

        return $bildirimler;
    }

    public function kadroEtiketi(): string
    {
        return Kadro::etiketi($this->hedefKadro);
    }

    public function render(): View
    {
        return view('livewire.dashboard');
    }
}
