<?php

namespace App\Livewire;

use App\Enums\Kadro;
use App\Services\Cikti\RaporDerleyici;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Çıktı Yönetimi — akademik faaliyet raporu.
 *
 * Ekran CV Oluşturucu'nun düzenini izliyor: solda ayarlar, sağda yazdırılan
 * sayfanın KENDİSİ. PDF ayrı bir şablondan değil, tarayıcının bu düğümü
 * yazdırmasından çıkıyor; ekranda görülenle çıktı ayrışamaz.
 *
 * Rapordaki sayıların hepsi {@see RaporDerleyici}'den, yani Yönerge Analizi ile
 * aynı motordan geliyor. Bileşen yalnızca ayarları tutuyor.
 *
 * @phpstan-import-type Rapor from RaporDerleyici
 *
 * @property-read list<string> $kurumlar
 * @property-read Rapor $rapor
 */
#[Layout('layouts.app')]
#[Title('Çıktı Yönetimi')]
class CiktiYonetimi extends Component
{
    /** Rapor şablonları; CV Oluşturucu'yla aynı iki görünüm. */
    public const SABLONLAR = [
        'minimal' => ['etiket' => 'Minimal', 'aciklama' => 'Beyaz başlık, ince çizgiler'],
        'prestijli' => ['etiket' => 'Kurumsal', 'aciklama' => 'Koyu başlık, altın vurgu'],
    ];

    /** Açılıp kapatılabilen rapor bölümleri. */
    public const BOLUMLER = [
        'ozet' => ['etiket' => 'Özet & Puan Tablosu', 'aciklama' => 'Toplam puan ve kategori dağılımı'],
        'faaliyetler' => ['etiket' => 'Yayın ve Faaliyet Listesi', 'aciklama' => 'Makale, kitap, bildiri, proje…'],
        'hedef' => ['etiket' => 'Hedef Analizi', 'aciklama' => 'Koşullar ve başvurulabilir üniversiteler'],
        'tez' => ['etiket' => 'Tez Danışmanlığı', 'aciklama' => 'Danışmanlığı yapılan tezler'],
        'katki' => ['etiket' => 'Toplumsal Katkı', 'aciklama' => 'Panel, proje ve etkinlikler'],
        'juri' => ['etiket' => 'YZ Jüri Özeti', 'aciklama' => 'Son jüri raporunun özeti ve planı'],
    ];

    public string $sablon = 'minimal';

    #[Validate('required|string|max:120')]
    public string $baslik = '';

    public string $aralik = 'tum';

    public string $hedefKadro = '';

    public string $hedefKurum = '';

    /** @var array<string, bool> */
    public array $bolumler = [
        'ozet' => true,
        'faaliyetler' => true,
        'hedef' => true,
        'tez' => false,
        'katki' => false,
        'juri' => true,
    ];

    public function mount(): void
    {
        $kullanici = Auth::user();

        $this->baslik = 'Akademik Faaliyet Raporu — '.now()->year;
        $this->hedefKadro = Kadro::hedef($kullanici->unvan)->value;
        $this->hedefKurum = $this->varsayilanKurum();
    }

    /**
     * Hedef seçilebilecek kurumlar: adayın kadro + alan bileşimi için eşiği
     * doğrulanmış olanlar.
     *
     * @return list<string>
     */
    #[Computed]
    public function kurumlar(): array
    {
        return app(RaporDerleyici::class)->kurumlar(Auth::user(), $this->hedefKadro);
    }

    /**
     * @return Rapor
     */
    #[Computed]
    public function rapor(): array
    {
        return app(RaporDerleyici::class)->derle(Auth::user(), $this->hedefKurum, $this->hedefKadro, $this->aralik);
    }

    public function sablonSec(string $sablon): void
    {
        if (array_key_exists($sablon, self::SABLONLAR)) {
            $this->sablon = $sablon;
        }
    }

    public function bolumDegistir(string $bolum): void
    {
        if (array_key_exists($bolum, self::BOLUMLER)) {
            $this->bolumler[$bolum] = ! ($this->bolumler[$bolum] ?? false);
        }
    }

    /**
     * Kadro değişince kurum listesi de değişir; eski seçim eşiksiz kalabilir.
     */
    public function updatedHedefKadro(): void
    {
        if (Kadro::tryFrom($this->hedefKadro) === null) {
            $this->hedefKadro = Kadro::hedef(Auth::user()->unvan)->value;
        }

        unset($this->kurumlar);
        $this->hedefKurum = $this->varsayilanKurum();
    }

    /**
     * Listede olmayan kurum yazılmaz: eşiksiz bir kurumun raporu tahmini bir
     * baraj basardı.
     */
    public function updatedHedefKurum(): void
    {
        if ($this->hedefKurum !== '' && ! in_array($this->hedefKurum, $this->kurumlar, true)) {
            $this->hedefKurum = '';
        }
    }

    public function updatedAralik(): void
    {
        if (! array_key_exists($this->aralik, RaporDerleyici::ARALIKLAR)) {
            $this->aralik = 'tum';
        }
    }

    public function updatedBaslik(): void
    {
        $this->validateOnly('baslik');
    }

    /**
     * Rapordaki faaliyet listesi Excel'in açtığı CSV olarak. Ayraç noktalı
     * virgül ve dosya BOM'la başlıyor: Türkçe Excel virgülü ondalık sayıyor,
     * BOM olmadan da Türkçe harfleri bozuk açıyor.
     */
    public function excelIndir(): StreamedResponse
    {
        $satirlar = app(RaporDerleyici::class)->faaliyetSatirlari(Auth::user(), $this->hedefKurum, $this->hedefKadro, $this->aralik);
        $puanBasligi = $this->hedefKurum !== '' ? 'Puan ('.$this->hedefKurum.')' : 'Puan';

        return response()->streamDownload(function () use ($satirlar, $puanBasligi): void {
            $cikti = fopen('php://output', 'w');

            if ($cikti === false) {
                return;
            }

            fwrite($cikti, "\xEF\xBB\xBF");
            fputcsv($cikti, ['Kategori', 'Başlık', 'Tür', 'Yazarlar', 'Kaynak / Kademe', 'Yıl', $puanBasligi], ';', '"', '');

            foreach ($satirlar as $satir) {
                fputcsv($cikti, [
                    $satir['kategori'], $satir['baslik'], $satir['tur'], $satir['yazarlar'],
                    $satir['kaynak'], $satir['yil'], $satir['puan'] ?? '',
                ], ';', '"', '');
            }

            fclose($cikti);
        }, 'akademik-faaliyetler-'.now()->format('Y-m-d').'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /**
     * Varsayılan hedef: adayın kendi üniversitesi eşik üretiyorsa o, yoksa
     * hedefsiz. Alfabetik ilk kurumu seçmek adaya bambaşka bir üniversitenin
     * raporunu bastırırdı.
     */
    private function varsayilanKurum(): string
    {
        $kendi = Auth::user()->universite;

        return $kendi !== null && in_array($kendi, $this->kurumlar, true) ? $kendi : '';
    }

    public function render(): View
    {
        return view('livewire.cikti-yonetimi');
    }
}
