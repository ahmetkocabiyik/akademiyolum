<?php

namespace App\Livewire;

use App\Enums\CvBolumu;
use App\Enums\CvSablonu;
use App\Enums\CvYaziTipi;
use App\Models\CvProfili;
use App\Models\Faaliyet;
use Flux\Flux;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * CV OLUŞTURUCU — faaliyet kayıtlarından beslenen, canlı önizlemeli CV.
 *
 * İKİ VERİ KAYNAĞI, İKİ DAVRANIŞ:
 *   - Yayın ve faaliyetler {@see Faaliyet} kayıtlarından CANLI okunuyor,
 *     kopyalanmıyor. Aday yayınını düzeltince CV de düzelir; CV'ye özel olan
 *     tek şey hangi kaydın dışarıda bırakıldığı.
 *   - Künye ve listeler (eğitim, deneyim, beceri, dil) CV'nin kendi malı.
 *     İlk açılışta akademik profilden doldurulur, sonra bağımsızdır: CV'de
 *     yazan unvanı değiştirmek yönerge analizinin kadro hesabını bozmamalı.
 *
 * Her değişiklik anında kaydediliyor ({@see updated()}), çünkü aday önizlemeye
 * bakarken formu bırakıp sekme değiştiriyor ve kaydedilmemiş alanları geri
 * döndüğünde kaybediyordu. Paneldeki "Kaydet" düğmesi ({@see kaydetVeBildir()})
 * bunun yerine geçmiyor: otomatik kaydı görünür kılıp adaya teyit veriyor.
 *
 * @property-read CvProfili $profil
 * @property-read Collection<int, Faaliyet> $faaliyetler
 * @property-read Collection<int, Faaliyet> $secilenler
 * @property-read array<string, Collection<int, Faaliyet>> $gruplu
 */
#[Layout('layouts.app')]
#[Title('CV Oluşturucu')]
class CvOlusturucu extends Component
{
    /** Yeni eklenen satırların iskeleti; anahtar kümesi şablonun beklediğiyle aynı. */
    private const BOS_EGITIM = ['derece' => '', 'universite' => '', 'bolum' => '', 'baslangic' => '', 'bitis' => ''];

    private const BOS_DENEYIM = ['pozisyon' => '', 'kurum' => '', 'baslangic' => '', 'bitis' => ''];

    /** Form panelindeki etkin sekme. */
    public string $sekme = 'kisisel';

    #[Validate('nullable|string|max:120')]
    public string $ad = '';

    #[Validate('nullable|string|max:60')]
    public string $unvan = '';

    #[Validate('nullable|string|max:160')]
    public string $kurum = '';

    #[Validate('nullable|string|max:160')]
    public string $bolum = '';

    #[Validate('nullable|string|max:160')]
    public string $eposta = '';

    #[Validate('nullable|string|max:40')]
    public string $telefon = '';

    #[Validate('nullable|string|max:80')]
    public string $sehir = '';

    #[Validate('nullable|string|max:200')]
    public string $web = '';

    #[Validate('nullable|string|max:1500')]
    public string $ozet = '';

    /** @var list<array{derece: string, universite: string, bolum: string, baslangic: string, bitis: string}> */
    public array $egitimler = [];

    /** @var list<array{pozisyon: string, kurum: string, baslangic: string, bitis: string}> */
    public array $deneyimler = [];

    /** @var list<string> */
    public array $beceriler = [];

    /** @var list<array{ad: string, seviye: int}> */
    public array $diller = [];

    /** @var list<int> */
    public array $haricFaaliyetler = [];

    public string $sablon = 'resmi';

    public string $renk = '#0a1628';

    public string $yaziTipi = 'sans';

    /** @var array<string, bool> */
    public array $bolumler = [];

    /** Yeni beceri / dil kutuları (listeye eklenince boşalır). */
    public string $yeniBeceri = '';

    public string $yeniDil = '';

    public function mount(): void
    {
        $profil = CvProfili::kullaniciIcin(Auth::user());

        $this->ad = (string) $profil->ad;
        $this->unvan = (string) $profil->unvan;
        $this->kurum = (string) $profil->kurum;
        $this->bolum = (string) $profil->bolum;
        $this->eposta = (string) $profil->eposta;
        $this->telefon = (string) $profil->telefon;
        $this->sehir = (string) $profil->sehir;
        $this->web = (string) $profil->web;
        $this->ozet = (string) $profil->ozet;
        // JSON sütunları ham geliyor: eksik anahtarlı ya da bozuk bir satır
        // şablonda "undefined index" değil, SESSİZ bir boş alan üretirdi.
        // Satırlar burada tek tek şekline sokuluyor.
        $this->egitimler = $this->egitimSatirlari($profil->egitimler);
        $this->deneyimler = $this->deneyimSatirlari($profil->deneyimler);
        $this->beceriler = $this->metinListesi($profil->beceriler);
        $this->diller = $this->dilSatirlari($profil->diller);
        $this->haricFaaliyetler = $this->sayiListesi($profil->haric_faaliyetler);
        $this->sablon = $profil->sablon->value;
        $this->renk = $profil->renk;
        $this->yaziTipi = $profil->yazi_tipi->value;
        $this->bolumler = $profil->bolumler + CvBolumu::varsayilan();
    }

    #[Computed]
    public function profil(): CvProfili
    {
        return CvProfili::kullaniciIcin(Auth::user());
    }

    /**
     * Adayın onaylı faaliyetleri — CV'nin yayın bölümünün kaynağı.
     *
     * Beklemedeki kayıtlar girmiyor: aday henüz kademesini onaylamadığı bir
     * yayını CV'sine basıp jüriye yanlış indeks bildirebilirdi.
     *
     * @return Collection<int, Faaliyet>
     */
    #[Computed]
    public function faaliyetler(): Collection
    {
        return Auth::user()->faaliyetler()
            ->onaylanmis()
            ->orderByDesc('tarih')
            ->get();
    }

    /**
     * CV'ye GİRECEK faaliyetler.
     *
     * @return Collection<int, Faaliyet>
     */
    #[Computed]
    public function secilenler(): Collection
    {
        return $this->faaliyetler->reject(
            fn (Faaliyet $f) => in_array($f->id, $this->haricFaaliyetler, true),
        );
    }

    /**
     * CV'deki faaliyetler, kategorisine göre gruplu.
     *
     * Düz bir liste jüriye "yayın" diye ders ve ödül de gösteriyordu; CV'de
     * akademik âdet başlıklara ayırmak.
     *
     * @return array<string, Collection<int, Faaliyet>>
     */
    #[Computed]
    public function gruplu(): array
    {
        return $this->secilenler
            ->groupBy(fn (Faaliyet $f) => $f->kategori->label())
            ->all();
    }

    /**
     * Her alan değişiminde kaydediyoruz; ayrı bir "Kaydet" adımı yok.
     */
    public function updated(string $alan): void
    {
        if (in_array($alan, ['sekme', 'yeniBeceri', 'yeniDil'], true)) {
            return;
        }

        $this->kaydet();
    }

    /**
     * Paneldeki "Kaydet" düğmesi. Odaktaki alan düğmeye basılırken `.blur`
     * ile zaten gönderiliyor; burada yalnız son hâli yazıp teyit veriyoruz.
     */
    public function kaydetVeBildir(): void
    {
        $this->kaydet();

        Flux::toast(variant: 'success', text: 'CV kaydedildi.');
    }

    public function egitimEkle(): void
    {
        $this->egitimler[] = self::BOS_EGITIM;
        $this->kaydet();
    }

    public function egitimSil(int $sira): void
    {
        $this->egitimler = $this->egitimSatirlari($this->disinda($this->egitimler, $sira));
        $this->kaydet();
    }

    public function deneyimEkle(): void
    {
        $this->deneyimler[] = self::BOS_DENEYIM;
        $this->kaydet();
    }

    public function deneyimSil(int $sira): void
    {
        $this->deneyimler = $this->deneyimSatirlari($this->disinda($this->deneyimler, $sira));
        $this->kaydet();
    }

    public function beceriEkle(): void
    {
        $beceri = trim($this->yeniBeceri);

        // Aynı beceri iki kez eklenince CV'de yan yana iki özdeş rozet çıkıyordu.
        if ($beceri === '' || in_array($beceri, $this->beceriler, true)) {
            $this->yeniBeceri = '';

            return;
        }

        $this->beceriler[] = $beceri;
        $this->yeniBeceri = '';
        $this->kaydet();
    }

    public function beceriSil(int $sira): void
    {
        $this->beceriler = $this->metinListesi($this->disinda($this->beceriler, $sira));
        $this->kaydet();
    }

    public function dilEkle(): void
    {
        $dil = trim($this->yeniDil);

        if ($dil === '' || collect($this->diller)->contains('ad', $dil)) {
            $this->yeniDil = '';

            return;
        }

        $this->diller[] = ['ad' => $dil, 'seviye' => 3];
        $this->yeniDil = '';
        $this->kaydet();
    }

    public function dilSeviye(int $sira, int $seviye): void
    {
        if (! isset($this->diller[$sira])) {
            return;
        }

        $this->diller[$sira]['seviye'] = max(1, min(5, $seviye));
        $this->kaydet();
    }

    public function dilSil(int $sira): void
    {
        $this->diller = $this->dilSatirlari($this->disinda($this->diller, $sira));
        $this->kaydet();
    }

    /**
     * Faaliyeti CV'den çıkarır / geri alır.
     *
     * Faaliyetin KENDİSİ silinmiyor: CV'den çıkarmak yayını sistemden silmek
     * değil. Eskiden tek bir çöp kutusu ikonu vardı ve aday puanını da
     * sileceğini düşünüp dokunmuyordu.
     */
    public function faaliyetDegistir(int $faaliyetId): void
    {
        if (in_array($faaliyetId, $this->haricFaaliyetler, true)) {
            $this->haricFaaliyetler = $this->sayiListesi(array_diff($this->haricFaaliyetler, [$faaliyetId]));
        } else {
            $this->haricFaaliyetler[] = $faaliyetId;
        }

        unset($this->secilenler, $this->gruplu);
        $this->kaydet();
    }

    public function sablonSec(string $sablon): void
    {
        if (CvSablonu::tryFrom($sablon) !== null) {
            $this->sablon = $sablon;
            $this->kaydet();
        }
    }

    public function renkSec(string $renk): void
    {
        if (in_array($renk, CvProfili::RENKLER, true)) {
            $this->renk = $renk;
            $this->kaydet();
        }
    }

    public function yaziTipiSec(string $yaziTipi): void
    {
        if (CvYaziTipi::tryFrom($yaziTipi) !== null) {
            $this->yaziTipi = $yaziTipi;
            $this->kaydet();
        }
    }

    public function bolumDegistir(string $bolum): void
    {
        if (CvBolumu::tryFrom($bolum) === null) {
            return;
        }

        $this->bolumler[$bolum] = ! ($this->bolumler[$bolum] ?? true);
        $this->kaydet();
    }

    /**
     * CV verisini JSON olarak indirir.
     *
     * Dışa aktarım, adayın verisinin bu uygulamada mahsur kalmadığının ispatı:
     * künye, listeler ve CV'ye giren faaliyetler okunabilir biçimde iner.
     */
    public function jsonIndir(): StreamedResponse
    {
        $veri = [
            'kunye' => [
                'ad' => $this->ad,
                'unvan' => $this->unvan,
                'kurum' => $this->kurum,
                'bolum' => $this->bolum,
                'eposta' => $this->eposta,
                'telefon' => $this->telefon,
                'sehir' => $this->sehir,
                'web' => $this->web,
                'ozet' => $this->ozet,
            ],
            'egitimler' => $this->egitimler,
            'deneyimler' => $this->deneyimler,
            'beceriler' => $this->beceriler,
            'diller' => $this->diller,
            'faaliyetler' => $this->secilenler->map(fn (Faaliyet $f) => [
                'baslik' => $f->baslik,
                'kategori' => $f->kategori->label(),
                'tur' => $f->tur,
                'yazarlar' => $f->yazarlar,
                'kaynak' => $f->kaynak,
                'tarih' => $f->tarih?->toDateString(),
                'puan' => $f->puan,
            ])->values()->all(),
        ];

        $json = (string) json_encode($veri, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        return response()->streamDownload(
            fn () => print ($json),
            'akademiyolum-cv.json',
            ['Content-Type' => 'application/json'],
        );
    }

    /**
     * Listeden bir satırı çıkarır.
     *
     * `unset()` ile silip yeniden indekslemek yerine filtre: unset edilmiş
     * dizi artık liste değil, ve ara durumu özelliğe yazmak hem statik analizi
     * hem Livewire'ın dizi anahtarlarını karıştırıyordu.
     *
     * @param  array<int, mixed>  $liste
     * @return list<mixed>
     */
    private function disinda(array $liste, int $sira): array
    {
        return array_values(array_filter(
            $liste,
            fn (int $anahtar): bool => $anahtar !== $sira,
            ARRAY_FILTER_USE_KEY,
        ));
    }

    /**
     * @param  iterable<mixed>  $ham
     * @return list<array{derece: string, universite: string, bolum: string, baslangic: string, bitis: string}>
     */
    private function egitimSatirlari(iterable $ham): array
    {
        $satirlar = [];

        foreach ($ham as $satir) {
            if (! is_array($satir)) {
                continue;
            }

            $satirlar[] = [
                'derece' => (string) ($satir['derece'] ?? ''),
                'universite' => (string) ($satir['universite'] ?? ''),
                'bolum' => (string) ($satir['bolum'] ?? ''),
                'baslangic' => (string) ($satir['baslangic'] ?? ''),
                'bitis' => (string) ($satir['bitis'] ?? ''),
            ];
        }

        return $satirlar;
    }

    /**
     * @param  iterable<mixed>  $ham
     * @return list<array{pozisyon: string, kurum: string, baslangic: string, bitis: string}>
     */
    private function deneyimSatirlari(iterable $ham): array
    {
        $satirlar = [];

        foreach ($ham as $satir) {
            if (! is_array($satir)) {
                continue;
            }

            $satirlar[] = [
                'pozisyon' => (string) ($satir['pozisyon'] ?? ''),
                'kurum' => (string) ($satir['kurum'] ?? ''),
                'baslangic' => (string) ($satir['baslangic'] ?? ''),
                'bitis' => (string) ($satir['bitis'] ?? ''),
            ];
        }

        return $satirlar;
    }

    /**
     * Dil satırları; seviye 1-5 aralığına KISILIYOR. Değer hem ekrandan hem
     * JSON sütunundan geliyor ve önizlemedeki çubuk genişliği ondan hesaplanıyor
     * — aralık dışı bir sayı çubuğu sayfanın dışına taşırırdı.
     *
     * @param  iterable<mixed>  $ham
     * @return list<array{ad: string, seviye: int}>
     */
    private function dilSatirlari(iterable $ham): array
    {
        $satirlar = [];

        foreach ($ham as $satir) {
            if (! is_array($satir) || blank($satir['ad'] ?? null)) {
                continue;
            }

            $satirlar[] = [
                'ad' => (string) $satir['ad'],
                'seviye' => max(1, min(5, (int) ($satir['seviye'] ?? 3))),
            ];
        }

        return $satirlar;
    }

    /**
     * @param  iterable<mixed>  $ham
     * @return list<string>
     */
    private function metinListesi(iterable $ham): array
    {
        $liste = [];

        foreach ($ham as $deger) {
            if (is_string($deger) && trim($deger) !== '') {
                $liste[] = trim($deger);
            }
        }

        return $liste;
    }

    /**
     * @param  iterable<mixed>  $ham
     * @return list<int>
     */
    private function sayiListesi(iterable $ham): array
    {
        $liste = [];

        foreach ($ham as $deger) {
            if (is_numeric($deger)) {
                $liste[] = (int) $deger;
            }
        }

        return $liste;
    }

    /**
     * Ekrandaki değerleri CV satırına yazar.
     */
    private function kaydet(): void
    {
        $this->profil->update([
            'ad' => $this->ad ?: null,
            'unvan' => $this->unvan ?: null,
            'kurum' => $this->kurum ?: null,
            'bolum' => $this->bolum ?: null,
            'eposta' => $this->eposta ?: null,
            'telefon' => $this->telefon ?: null,
            'sehir' => $this->sehir ?: null,
            'web' => $this->web ?: null,
            'ozet' => $this->ozet ?: null,
            'egitimler' => $this->egitimler,
            'deneyimler' => $this->deneyimler,
            'beceriler' => $this->beceriler,
            'diller' => $this->diller,
            'haric_faaliyetler' => $this->haricFaaliyetler,
            'sablon' => $this->sablon,
            'renk' => $this->renk,
            'yazi_tipi' => $this->yaziTipi,
            'bolumler' => $this->bolumler,
        ]);
    }

    /**
     * Önizlemenin ihtiyaç duyduğu, ekrandaki (henüz kaydedilmemiş) değerlerden
     * kurulmuş görünüm verisi.
     *
     * @return array<string, mixed>
     */
    public function onizleme(): array
    {
        return [
            'ad' => $this->ad,
            'unvan' => $this->unvan,
            'kurum' => $this->kurum,
            'bolum' => $this->bolum,
            'eposta' => $this->eposta,
            'telefon' => $this->telefon,
            'sehir' => $this->sehir,
            'web' => $this->web,
            'ozet' => $this->ozet,
            'egitimler' => $this->egitimler,
            'deneyimler' => $this->deneyimler,
            'beceriler' => $this->beceriler,
            'diller' => $this->diller,
            'gruplu' => $this->gruplu,
            'sablon' => CvSablonu::from($this->sablon),
            'renk' => $this->renk,
            'yaziTipi' => CvYaziTipi::from($this->yaziTipi),
            'bolumler' => $this->bolumler,
            'basHarfler' => Auth::user()->initials(),
        ];
    }

    public function render(): View
    {
        return view('livewire.cv-olusturucu');
    }
}
