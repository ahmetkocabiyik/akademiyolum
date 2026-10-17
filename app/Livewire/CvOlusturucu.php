<?php

namespace App\Livewire;

use App\Enums\CvBolumu;
use App\Enums\CvSablonu;
use App\Enums\CvYaziTipi;
use App\Models\CvProfili;
use App\Models\Faaliyet;
use App\Models\User;
use App\Rules\GecerliOrcid;
use App\Services\Cv\CvDuzeni;
use Flux\Flux;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\In;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
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
 * @property-read array<int, int>|null $puanlar
 */
#[Layout('layouts.app')]
#[Title('CV Oluşturucu')]
class CvOlusturucu extends Component
{
    use WithFileUploads;

    /** Yeni eklenen satırların iskeleti; anahtar kümesi şablonun beklediğiyle aynı. */
    private const BOS_EGITIM = ['derece' => '', 'universite' => '', 'bolum' => '', 'baslangic' => '', 'bitis' => '', 'tez_adi' => '', 'danisman' => ''];

    private const BOS_DENEYIM = ['pozisyon' => '', 'kurum' => '', 'baslangic' => '', 'bitis' => ''];

    /** EK-4A madde 5: Doçent, Profesör… Hangi kurum (ÜAK, üniversite), hangi alanda, hangi yıl. */
    private const BOS_UNVAN = ['unvan' => '', 'kurum' => '', 'alan' => '', 'yil' => ''];

    /** EK-4A madde 10: bilimsel kuruluş üyelikleri. */
    private const BOS_UYELIK = ['kurulus' => '', 'gorev' => '', 'yil' => ''];

    /** Form panelindeki etkin sekme. */
    public string $sekme = 'kisisel';

    #[Validate('nullable|string|max:120')]
    public string $ad = '';

    /** Y-m-d; EK-4A özgeçmişi soruyor, tasarımlı şablonlarda basılmıyor. */
    #[Validate('nullable|date|before:today|after:1900-01-01')]
    public string $dogumTarihi = '';

    /** Onboarding ve profille aynı kapalı liste ({@see User::UNVANLAR}). */
    #[Validate(['nullable', new In(User::UNVANLAR)])]
    public string $unvan = '';

    #[Validate('nullable|string|max:160')]
    public string $kurum = '';

    #[Validate('nullable|string|max:160')]
    public string $bolum = '';

    #[Validate('nullable|string|max:160')]
    public string $eposta = '';

    /** Formdaki maskeyle aynı biçim: 0xxx xxx xx xx (cep: 05xx xxx xx xx). */
    #[Validate('nullable|string|regex:/^0\d{3} \d{3} \d{2} \d{2}$/', message: ['regex' => 'Telefonu 05xx xxx xx xx biçiminde girin.'])]
    public string $telefon = '';

    /** Adres. Adı `sehir` kaldı: sütun adı, alan önce yalnızca şehir soruyordu. */
    #[Validate('nullable|string|max:200')]
    public string $sehir = '';

    /** ORCID kimliği; biçimi ve kontrol hanesi sınanır. */
    #[Validate(['nullable', 'string', new GecerliOrcid])]
    public string $orcid = '';

    #[Validate('nullable|string|max:1500')]
    public string $ozet = '';

    /**
     * Seçilen fotoğrafın geçici yüklemesi. Seçildiği an kalıcı diske
     * yazılıp boşaltılıyor ({@see updatedYeniFoto()}); CV'nin fotoğrafı
     * profildeki `foto` sütunu.
     */
    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:10240')]
    public ?TemporaryUploadedFile $yeniFoto = null;

    /** @var list<array{derece: string, universite: string, bolum: string, baslangic: string, bitis: string}> */
    public array $egitimler = [];

    /** @var list<array{pozisyon: string, kurum: string, baslangic: string, bitis: string}> */
    public array $deneyimler = [];

    /** @var list<array{unvan: string, kurum: string, alan: string, yil: string}> */
    public array $akademikUnvanlar = [];

    /** @var list<array{kurulus: string, gorev: string, yil: string}> */
    public array $uyelikler = [];

    /** @var list<string> */
    public array $beceriler = [];

    /** @var list<array{ad: string, seviye: int}> */
    public array $diller = [];

    /** @var list<int> */
    public array $haricFaaliyetler = [];

    public string $sablon = 'minimal';

    public string $renk = '#0a1628';

    public string $cizgiRenk = CvProfili::VARSAYILAN_CIZGI_RENGI;

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
        $this->dogumTarihi = $profil->dogum_tarihi?->toDateString() ?? '';
        $this->unvan = (string) $profil->unvan;
        $this->kurum = (string) $profil->kurum;
        $this->bolum = (string) $profil->bolum;
        $this->eposta = (string) $profil->eposta;
        $this->telefon = (string) $profil->telefon;
        $this->sehir = (string) $profil->sehir;
        $this->orcid = (string) $profil->orcid;
        $this->ozet = (string) $profil->ozet;
        // JSON sütunları ham geliyor: eksik anahtarlı ya da bozuk bir satır
        // şablonda "undefined index" değil, SESSİZ bir boş alan üretirdi.
        // Satırlar burada tek tek şekline sokuluyor.
        $this->egitimler = $this->egitimSatirlari($profil->egitimler);
        $this->deneyimler = $this->deneyimSatirlari($profil->deneyimler);
        $this->akademikUnvanlar = self::satirlar($profil->akademik_unvanlar ?? [], self::BOS_UNVAN);
        $this->uyelikler = self::satirlar($profil->uyelikler ?? [], self::BOS_UYELIK);
        $this->beceriler = $this->metinListesi($profil->beceriler);
        $this->diller = $this->dilSatirlari($profil->diller);
        $this->haricFaaliyetler = $this->sayiListesi($profil->haric_faaliyetler);
        $this->sablon = $profil->sablon->value;
        $this->renk = $profil->renk;
        $this->cizgiRenk = $profil->cizgi_renk ?? CvProfili::VARSAYILAN_CIZGI_RENGI;
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
     * Faaliyetlerin kendi üniversitesinin cetvelindeki puanı. Puan
     * saklanmadığı için sütun 0 kalıyordu; yönerge yoksa null.
     *
     * @return array<int, int>|null
     */
    #[Computed]
    public function puanlar(): ?array
    {
        return Auth::user()->puanCetveli()?->faaliyetPuanlari($this->faaliyetler);
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
     * Her alan değişiminde kaydediyoruz; ayrı bir "Kaydet" adımı yok.
     */
    public function updated(string $alan): void
    {
        if (in_array($alan, ['sekme', 'yeniBeceri', 'yeniDil', 'yeniFoto'], true)) {
            return;
        }

        $this->kaydet();

        // Üst bardaki "Kaydedildi" işareti bir an görünsün.
        $this->dispatch('cv-kaydedildi');
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

    /**
     * Fotoğraf seçilir seçilmez saklanıyor; ayrı bir "yükle" adımı yok,
     * formun geri kalanı gibi. Eski dosya silinir, diskte artık kalmaz.
     */
    public function updatedYeniFoto(): void
    {
        $this->validateOnly('yeniFoto');

        if ($this->yeniFoto === null) {
            return;
        }

        $eski = $this->profil->foto;
        $yol = $this->yeniFoto->store('cv-fotolar', 'local');

        $this->profil->update(['foto' => $yol]);
        $this->yeniFoto = null;

        if ($eski !== null) {
            Storage::disk('local')->delete($eski);
        }
    }

    public function fotoKaldir(): void
    {
        if ($this->profil->foto !== null) {
            Storage::disk('local')->delete($this->profil->foto);
        }

        $this->profil->update(['foto' => null]);
    }

    /**
     * Fotoğrafın adresi. Dosya adı her yüklemede değiştiği için sorgu
     * parametresi önbelleği kırıyor; rota yanıtı uzun süre önbelleklenebiliyor.
     */
    public function fotoAdresi(): ?string
    {
        $yol = $this->profil->foto;

        return $yol === null ? null : route('cv-olusturucu.foto', ['v' => basename($yol)]);
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

    public function unvanEkle(): void
    {
        $this->akademikUnvanlar[] = self::BOS_UNVAN;
        $this->kaydet();
    }

    public function unvanSil(int $sira): void
    {
        $this->akademikUnvanlar = self::satirlar($this->disinda($this->akademikUnvanlar, $sira), self::BOS_UNVAN);
        $this->kaydet();
    }

    public function uyelikEkle(): void
    {
        $this->uyelikler[] = self::BOS_UYELIK;
        $this->kaydet();
    }

    public function uyelikSil(int $sira): void
    {
        $this->uyelikler = self::satirlar($this->disinda($this->uyelikler, $sira), self::BOS_UYELIK);
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

        unset($this->secilenler);
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

    public function cizgiRenkSec(string $renk): void
    {
        if (in_array($renk, CvProfili::CIZGI_RENKLERI, true)) {
            $this->cizgiRenk = $renk;
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
                'dogum_tarihi' => $this->dogumTarihi ?: null,
                'unvan' => $this->unvan,
                'kurum' => $this->kurum,
                'bolum' => $this->bolum,
                'eposta' => $this->eposta,
                'telefon' => $this->telefon,
                'adres' => $this->sehir,
                'orcid' => $this->orcid,
                'ozet' => $this->ozet,
            ],
            'egitimler' => $this->egitimler,
            'deneyimler' => $this->deneyimler,
            'akademik_unvanlar' => $this->akademikUnvanlar,
            'uyelikler' => $this->uyelikler,
            'beceriler' => $this->beceriler,
            'diller' => $this->diller,
            'faaliyetler' => $this->secilenler->map(fn (Faaliyet $f) => [
                'baslik' => $f->baslik,
                'kategori' => $f->kategori->label(),
                'tur' => $f->tur,
                'yazarlar' => $f->yazarlar,
                'kaynak' => $f->kaynak,
                'tarih' => $f->tarih?->toDateString(),
                'puan' => $this->puanlar[$f->id] ?? null,
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
     * @return list<array{derece: string, universite: string, bolum: string, baslangic: string, bitis: string, tez_adi: string, danisman: string}>
     */
    private function egitimSatirlari(iterable $ham): array
    {
        return self::satirlar($ham, self::BOS_EGITIM);
    }

    /**
     * JSON listesini verilen iskeletin anahtarlarına göre şekline sokar:
     * eksik anahtar boş metin olur, fazlası atılır, dizi olmayan satır düşer.
     * Eski kayıtlardaki satırlar (ör. tez adı eklenmeden önceki eğitim
     * satırları) böylece yeni anahtarlarla açılıyor.
     *
     * @template T of array<string, string>
     *
     * @param  iterable<mixed>  $ham
     * @param  T  $iskelet
     * @return list<T>
     */
    private static function satirlar(iterable $ham, array $iskelet): array
    {
        $satirlar = [];

        foreach ($ham as $satir) {
            if (! is_array($satir)) {
                continue;
            }

            $satirlar[] = array_map(
                fn (string $anahtar): string => (string) ($satir[$anahtar] ?? ''),
                array_combine(array_keys($iskelet), array_keys($iskelet)),
            );
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
            ...$this->gecerliKunye(),
            'dogum_tarihi' => $this->gecerliDogumTarihi(),
            'egitimler' => $this->egitimler,
            'deneyimler' => $this->deneyimler,
            'akademik_unvanlar' => $this->akademikUnvanlar,
            'uyelikler' => $this->uyelikler,
            'beceriler' => $this->beceriler,
            'diller' => $this->diller,
            'haric_faaliyetler' => $this->haricFaaliyetler,
            'sablon' => $this->sablon,
            'renk' => $this->renk,
            'cizgi_renk' => $this->cizgiRenk,
            'yazi_tipi' => $this->yaziTipi,
            'bolumler' => $this->bolumler,
        ]);
    }

    /**
     * Geçersiz doğum tarihi yazılmaz, kayıtlı değer korunur ({@see gecerliKunye()} ile aynı kural).
     */
    private function gecerliDogumTarihi(): ?string
    {
        if ($this->dogumTarihi === '') {
            return null;
        }

        $gecersiz = Validator::make(['dogumTarihi' => $this->dogumTarihi], ['dogumTarihi' => $this->getRules()['dogumTarihi']])->fails();

        return $gecersiz ? $this->profil->dogum_tarihi?->toDateString() : $this->dogumTarihi;
    }

    /**
     * Künye alanlarının yazılacak değerleri. Kuralına uymayan alan için
     * KAYITLI değer korunur: `#[Validate]` hatayı gösteriyor ama otomatik
     * kaydı durdurmuyordu, yarım bir telefon ya da sınırı aşan bir adres
     * veritabanına yazılıyordu. Aday yazdığını formda hatasıyla görmeye devam
     * eder; düzelttiğinde kaydedilir.
     *
     * @return array<string, string|null>
     */
    private function gecerliKunye(): array
    {
        $alanlar = ['ad', 'unvan', 'kurum', 'bolum', 'eposta', 'telefon', 'sehir', 'orcid', 'ozet'];
        $degerler = [];

        foreach ($alanlar as $alan) {
            $degerler[$alan] = $this->{$alan};
        }

        $gecersiz = Validator::make($degerler, array_intersect_key($this->getRules(), $degerler))
            ->errors()
            ->keys();

        foreach ($alanlar as $alan) {
            $degerler[$alan] = in_array($alan, $gecersiz, true)
                ? $this->profil->{$alan}
                : ($degerler[$alan] ?: null);
        }

        // ORCID kontrol hanesi büyük X yazılır; maske küçüğünü de kabul ediyor.
        if (! in_array('orcid', $gecersiz, true) && $degerler['orcid'] !== null) {
            $degerler['orcid'] = GecerliOrcid::kimlik($degerler['orcid']);
        }

        return $degerler;
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
            'dogumTarihi' => $this->dogumTarihi,
            'unvan' => $this->unvan,
            'kurum' => $this->kurum,
            'bolum' => $this->bolum,
            'eposta' => $this->eposta,
            'telefon' => $this->telefon,
            'sehir' => $this->sehir,
            'orcid' => $this->orcid,
            'ozet' => $this->ozet,
            'egitimler' => $this->egitimler,
            'deneyimler' => $this->deneyimler,
            'akademikUnvanlar' => $this->akademikUnvanlar,
            'uyelikler' => $this->uyelikler,
            'beceriler' => $this->beceriler,
            'diller' => $this->diller,
            // Tasarımlı şablonların YÖKSİS bölümleri ve resmî EK-4A düzeni.
            'yoksis' => app(CvDuzeni::class)->yoksis($this->secilenler),
            'ek4a' => app(CvDuzeni::class)->ek4a($this->secilenler, now()),
            'sablon' => CvSablonu::from($this->sablon),
            'renk' => $this->renk,
            'cizgiRenk' => $this->cizgiRenk,
            'yaziTipi' => CvYaziTipi::from($this->yaziTipi),
            'bolumler' => $this->bolumler,
            'basHarfler' => Auth::user()->initials(),
            'foto' => $this->fotoAdresi(),
        ];
    }

    public function render(): View
    {
        return view('livewire.cv-olusturucu');
    }
}
