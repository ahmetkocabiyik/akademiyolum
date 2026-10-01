<?php

namespace App\Livewire;

use App\Enums\JuriSapkasi;
use App\Enums\JuriSertligi;
use App\Enums\Kadro;
use App\Enums\TemelAlan;
use App\Models\JuriRaporu;
use App\Services\AI\JuriDosyasi;
use App\Services\AI\JuriRaporcu;
use App\Services\AI\SaglayiciException;
use App\Services\Scoring\Sart\SartDeposu;
use Collator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use RuntimeException;

/**
 * YZ Jüri Analizi — adayın dosyasını jüri gözüyle okuyan rapor ekranı.
 *
 * Yönerge Analizi "koşul sağlandı mı" sorusunu cevaplıyor; bu ekran aynı
 * motorun sonucunu alıp "jüri bu dosyaya ne der" sorusuna geçiyor. Ölçüm ve
 * karar motordan gelir ({@see JuriDosyasi}), metin YZ'den —
 * bu yüzden iki ekran asla çelişmez.
 *
 * Rapor üretimi İKİ ADIMDA yapılıyor: `analizBaslat()` yalnızca bekleme
 * durumunu açıp olayı yayınlıyor, raporu {@see raporUret()} yazıyor. Tek
 * istekte yapılsaydı aday 10-30 saniye boyunca donmuş bir ekrana bakardı;
 * şimdi arada "jüri masası" göstergesi çiziliyor.
 *
 * @property-read list<string> $kurumlar
 * @property-read Collection<int, JuriRaporu> $raporlar
 * @property-read JuriRaporu|null $rapor
 */
#[Layout('layouts.app')]
#[Title('YZ Jüri Analizi')]
class JuriAnalizi extends Component
{
    public string $hedefKurum = '';

    public string $hedefKadro = 'docentlik';

    public string $sapka = JuriSapkasi::UakUzmani->value;

    public string $sertlik = JuriSertligi::Gercekci->value;

    public ?int $aktifRaporId = null;

    public bool $bekleniyor = false;

    public ?string $hata = null;

    /**
     * Hedef kadro etiketleri; mount() içinde {@see Kadro::etiketler()} ile dolar.
     *
     * @var array<string, string>
     */
    public array $kadrolar = [];

    public function mount(): void
    {
        $kullanici = Auth::user();

        $this->kadrolar = Kadro::etiketler();
        $this->hedefKadro = Kadro::hedef($kullanici->unvan)->value;

        $this->aktifRaporId = $kullanici->juriRaporlari()->latest('id')->value('id');
        $this->hedefKurum = $this->varsayilanKurum();
    }

    /**
     * Jüri masasına konabilecek kurumlar: adayın kadro + temel alan bileşimi
     * için DOĞRULANMIŞ eşiği olanlar.
     *
     * Eşiği olmayan kurum listelenmiyor — jüri raporu tahmini bir barajın
     * üzerine yazılamaz. Ekranda ÜAK'ın kendi asgari şartları da ayrı bir
     * seçenek olarak görünmüyor; projede ÜAK bir cetvel (madde puanları), ayrı
     * bir eşik değil.
     *
     * @return list<string>
     */
    #[Computed]
    public function kurumlar(): array
    {
        $depo = app(SartDeposu::class);
        $alan = ($this->temelAlan())->value;
        $birim = Auth::user()->birim ?: null;

        $kurumlar = array_values(array_filter(
            $depo->universiteler(),
            fn (string $ad) => $depo->bul($ad, $this->hedefKadro, $alan, $birim) !== null,
        ));

        if (class_exists(Collator::class)) {
            (new Collator('tr_TR'))->sort($kurumlar);
        } else {
            sort($kurumlar);
        }

        return $kurumlar;
    }

    /**
     * Adayın önceki raporları, en yenisi en üstte.
     *
     * @return Collection<int, JuriRaporu>
     */
    #[Computed]
    public function raporlar(): Collection
    {
        return Auth::user()->juriRaporlari()->latest('id')->get();
    }

    #[Computed]
    public function rapor(): ?JuriRaporu
    {
        if ($this->aktifRaporId === null) {
            return null;
        }

        return Auth::user()->juriRaporlari()->find($this->aktifRaporId);
    }

    /**
     * Kadro değişince kurum listesi de değişir: eski seçim artık eşiksiz
     * kalabilir ve rapor üretimi hata verirdi.
     */
    public function updatedHedefKadro(): void
    {
        unset($this->kurumlar);
        $this->hedefKurum = $this->varsayilanKurum();
    }

    public function analizBaslat(): void
    {
        $this->hata = null;

        if ($this->hedefKurum === '' || ! in_array($this->hedefKurum, $this->kurumlar, true)) {
            $this->hata = 'Seçtiğiniz kadro için yönergesi girilmiş bir kurum seçin.';

            return;
        }

        $this->bekleniyor = true;
        $this->dispatch('juri-raporu-uret');
    }

    /**
     * Raporu üretir. Sağlayıcı hatası adaya gösterilir, yarım rapor kaydedilmez.
     */
    #[On('juri-raporu-uret')]
    public function raporUret(JuriRaporcu $raporcu): void
    {
        try {
            $rapor = $raporcu->uret(
                Auth::user(),
                $this->hedefKurum,
                $this->hedefKadro,
                JuriSapkasi::from($this->sapka),
                JuriSertligi::from($this->sertlik),
                Auth::user()->birim ?: null,
            );
        } catch (SaglayiciException $e) {
            $this->bekleniyor = false;
            $this->hata = $e->getMessage();

            return;
        } catch (RuntimeException) {
            $this->bekleniyor = false;
            $this->hata = 'Bu kurum ve kadro için yönerge verisi bulunamadı.';

            return;
        }

        $this->aktifRaporId = $rapor->id;
        $this->bekleniyor = false;
        unset($this->raporlar, $this->rapor);
    }

    public function raporSec(int $raporId): void
    {
        $rapor = Auth::user()->juriRaporlari()->find($raporId);

        if ($rapor === null) {
            return;
        }

        $this->aktifRaporId = $rapor->id;
        $this->hata = null;
        $this->bekleniyor = false;
        unset($this->rapor);
    }

    public function raporSil(int $raporId): void
    {
        $rapor = Auth::user()->juriRaporlari()->find($raporId);

        if ($rapor === null) {
            return;
        }

        $rapor->delete();

        if ($this->aktifRaporId === $raporId) {
            $this->aktifRaporId = Auth::user()->juriRaporlari()->latest('id')->value('id');
        }

        unset($this->raporlar, $this->rapor);
    }

    /**
     * Varsayılan kurum: adayın kendi üniversitesi eşik üretiyorsa o, yoksa boş.
     *
     * Liste alfabetik olduğu için "ilk kurumu seç" demek adaya bambaşka bir
     * üniversitenin raporunu ürettirirdi.
     */
    private function varsayilanKurum(): string
    {
        $kurumlar = $this->kurumlar;
        $kendi = Auth::user()->universite;

        return $kendi !== null && in_array($kendi, $kurumlar, true) ? $kendi : '';
    }

    private function temelAlan(): TemelAlan
    {
        return Auth::user()->temel_alan ?? TemelAlan::Sosyal;
    }

    public function render(): View
    {
        return view('livewire.juri-analizi');
    }
}
