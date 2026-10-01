<?php

namespace App\Livewire;

use App\Enums\Kadro;
use App\Enums\TemelAlan;
use App\Models\BeyanOnayi;
use App\Models\Faaliyet;
use App\Models\Universite;
use App\Services\Scoring\Sart\Durum;
use App\Services\Scoring\Sart\SartDegerlendirici;
use App\Services\Scoring\Sart\SartDeposu;
use App\Services\Scoring\Sart\SartSonucu;
use Collator;
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
 *     toplam: ?int,
 *     baraj: ?int,
 *     oran: int,
 *     puan_orani: int,
 *     kalan: int,
 *     yapilabilir: bool,
 *     durum: string,
 *     eksik_sayisi: int,
 *     belirsiz_sayisi: int,
 *     beyan_sayisi: int,
 *     cetvel_eksigi_sayisi: int,
 * }
 *
 * Livewire #[Computed] metotları özellik gibi okunur; @property-read satırları
 * bunu statik analize bildirir.
 *
 * @property-read Collection<int, Faaliyet> $faaliyetler
 * @property-read int $profilDoluluk
 * @property-read list<SonucSatiri> $sonuclar
 * @property-read list<SonucSatiri> $listelenen
 * @property-read array{birim: list<string>, alan_yok: list<string>} $kapsamDisi
 * @property-read array<string, list<string>> $birimSecenekleri
 * @property-read array<string, mixed>|null $detay
 * @property-read array{toplam: int, uygun: int, eksik_bilgi: int, yakin: int, yetersiz: int, alan_yok: int} $ozet
 */
#[Layout('layouts.app')]
#[Title('Yönerge Analizi')]
class YonergeAnalizi extends Component
{
    public string $arama = '';

    public string $turFiltre = '';

    public string $sehirFiltre = '';

    /**
     * Özet bardaki sayaçtan seçilen durum: `uygun` · `yakin` · `eksik_bilgi` ·
     * `yetersiz` · `alan_yok`, boşsa filtre yok.
     *
     * Diğer filtrelerden farklı olarak {@see sonuclar()} içine GİRMEZ, sonuna
     * eklenir: sayaçların kendisi tüm dağılımı göstermeye devam etmeli, yoksa
     * "Yetersiz"e tıklayan aday diğer sayaçları sıfırlanmış görürdü.
     */
    public string $durumFiltre = '';

    /**
     * Birim seçim kutusu açık mı.
     *
     * Kapalı başlıyor: kutu en fazla on dört seçici taşıyor ve ekranın tepesini
     * kaplıyordu. Başlık kapalıyken de görünür, yani aday bekleyen iş olduğunu
     * kutuyu açmadan biliyor.
     *
     * Alpine yerine sunucu tarafında tutuluyor: içindeki seçiciler
     * `wire:model.live`, yani her seçim yeni bir render tetikliyor; istemci
     * durumu o sırada kaybolursa kutu adayın yüzüne kapanırdı.
     */
    public bool $birimPaneliAcik = false;

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
     * Üniversite başına seçilen birim: `['Karadeniz Teknik Üniversitesi' => 'Tıp Fakültesi']`.
     *
     * Profildeki tek `birim` alanı bu iş için yetmiyor. Korpusta 181 farklı
     * birim adı var ve yalnız 25'i birden çok üniversitede ortak; adayın kendi
     * üniversitesinde seçtiği "Edebiyat Fakültesi" Yeditepe'nin on üç
     * biriminden hiçbiriyle eşleşmez. Bu yüzden seçim üniversite BAŞINA
     * tutuluyor ve profil alanı yalnız varsayılan olarak kullanılıyor.
     *
     * @var array<string, string>
     */
    public array $birimSecimleri = [];

    /**
     * DURUMUN EKRAN KARŞILIKLARI — tek kaynak.
     *
     * Kart, karşılaştırma tablosu ve detay paneli aynı dört durumu gösteriyor;
     * haritalar üç ayrı şablonda kopyalıydı ve biri değişince öbürleri sessizce
     * geride kalıyordu. Şablonlar artık `@use` ile buradan okuyor.
     *
     * "Kriter Onaylanmalı" olumsuz bir sonuç DEĞİL: kesin olumsuz yaprak yok, ama bir
     * şey adayın onayını bekliyor (belge kutusu, profil ya da tarih).
     *
     * @var array<string, string>
     */
    public const RENK = [
        'uygun' => 'var(--color-cat-green)',
        'yakin' => 'var(--color-cat-amber)',
        'eksik_bilgi' => 'var(--color-cat-purple)',
        'yetersiz' => 'var(--color-cat-red)',
    ];

    /** @var array<string, string> Flux rozet rengi. */
    public const ROZET = [
        'uygun' => 'green',
        'yakin' => 'amber',
        'eksik_bilgi' => 'purple',
        'yetersiz' => 'red',
    ];

    /** @var array<string, string> Kart ve tabloda: dar alana sığan kısa ad. */
    public const ETIKET = [
        'uygun' => 'Uygun',
        'yakin' => 'Yakın',
        'eksik_bilgi' => 'Kriter Onaylanmalı',
        'yetersiz' => 'Yetersiz',
    ];

    /** @var array<string, string> Detay panelinde: yer var, sebebi de söyler. */
    public const UZUN_ETIKET = [
        'uygun' => 'Uygun',
        'yakin' => 'Yakın Sınırda',
        'eksik_bilgi' => 'Kriter Onaylanmalı',
        'yetersiz' => 'Puan Yetersiz',
    ];

    /**
     * Hedef kadro etiketleri (seçici + başlık için); mount() içinde
     * {@see Kadro::etiketler()} ile dolar.
     *
     * @var array<string, string>
     */
    public array $kadrolar = [];

    /**
     * Varsayılan hedef kadro: kullanıcının bir üst kadrosu (yükselme hedefi).
     */
    public function mount(): void
    {
        $this->kadrolar = Kadro::etiketler();
        $this->hedefKadro = Kadro::hedef(Auth::user()->unvan)->value;
    }

    protected function depo(): SartDeposu
    {
        return app(SartDeposu::class);
    }

    /**
     * Bir üniversite için geçerli birim: ekrandan seçilen varsa o, yoksa
     * profildeki değer. Profil alanı adayın KENDİ üniversitesinin birimlerini
     * listeliyor; başka üniversitelerde ancak birim adı tesadüfen aynıysa
     * tutar, o yüzden ekran seçimi profili EZER.
     */
    protected function birimIcin(string $universiteAdi): ?string
    {
        $secim = $this->birimSecimleri[$universiteAdi] ?? '';

        return $secim !== '' ? $secim : (Auth::user()->birim ?: null);
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
     * Yönergesi girili olduğu hâlde adayın kadro + temel alan (ve varsa birim)
     * bileşimi için eşik ÜRETMEYEN üniversiteler, gerekçeye göre AYRILMIŞ.
     *
     * Bunlar listeden sessizce düşüyordu: aday Marmara'yı arayıp bulamayınca
     * "yönergesi hiç yok mu, yoksa benim alanım mı kapsanmıyor?" sorusuna
     * cevap bulamıyordu. Kart sayısı doğru ama tek başına yanıltıcı.
     *
     * İki gerekçe adaya bambaşka şey söylüyor, bu yüzden ayrı duruyorlar:
     *   `birim`    → alanı kapsanıyor ama yönerge BİRİME göre ölçüt koyuyor;
     *                birden çok aday eşik var, motor seçim yapmayı reddediyor.
     *                Aday profiline birimini girerse listede belirirler.
     *   `alan_yok` → o temel alan için hiç eşik tanımlanmamış. Yapılabilecek
     *                bir şey yok; aday yalnız bunu bilmek istiyor.
     *
     * @return array{birim: list<string>, alan_yok: list<string>}
     */
    #[Computed]
    public function kapsamDisi(): array
    {
        $depo = $this->depo();
        $kullanici = Auth::user();
        $temelAlan = ($kullanici->temel_alan ?? TemelAlan::Sosyal)->value;
        $ayrim = ['birim' => [], 'alan_yok' => []];
        $suzgec = $this->modelSuzgeci();

        foreach ($depo->universiteler() as $ad) {
            if ($suzgec !== null && ! in_array($ad, $suzgec, true)) {
                continue;
            }

            if ($depo->bul($ad, $this->hedefKadro, $temelAlan, $this->birimIcin($ad)) !== null) {
                continue;
            }

            $adayVar = $depo->adaylar($ad, $this->hedefKadro, $temelAlan) !== [];
            $ayrim[$adayVar ? 'birim' : 'alan_yok'][] = $ad;
        }

        return $ayrim;
    }

    /**
     * Birim bekleyen üniversiteler için seçenek listesi:
     * `['Karadeniz Teknik Üniversitesi' => ['Diş Hekimliği Fakültesi', ...]]`.
     *
     * `SartDeposu::adaylar()` tam bu iş için var: birim ayrımı yapmadan aday
     * eşikleri döndürüyor ki arayüz aralarından seçtirebilsin. Ekran bunu
     * kullanmayıp kartı listeden düşürüyordu.
     *
     * @return array<string, list<string>>
     */
    #[Computed]
    public function birimSecenekleri(): array
    {
        $depo = $this->depo();
        $temelAlan = (Auth::user()->temel_alan ?? TemelAlan::Sosyal)->value;
        $secenekler = [];

        foreach ($this->kapsamDisi['birim'] as $ad) {
            $birimler = [];
            foreach ($depo->adaylar($ad, $this->hedefKadro, $temelAlan) as $esik) {
                if ($esik['birim'] !== null) {
                    $birimler[$esik['birim']] = true;
                }
            }

            if ($birimler !== []) {
                $secenekler[$ad] = array_keys($birimler);

                // BAĞLANACAK ANAHTAR ÖNCEDEN AÇILIR. Anahtar yoksa
                // `wire:model` bağlanacak bir değer bulamıyor ve tarayıcı İLK
                // seçeneği görünür biçimde seçili gösteriyor; aday o seçeneği
                // tıklayınca `change` olayı tetiklenmediği için ekran hiç
                // güncellenmiyordu. Boş dize, görünümdeki boş seçenekle
                // eşleşerek başlangıç durumunu doğru gösterir.
                $this->birimSecimleri[$ad] ??= '';
            }
        }

        return $secenekler;
    }

    /**
     * Model tarafındaki filtrelerden (arama · tür · şehir) geçen üniversiteler.
     *
     * @return Collection<int, Universite>
     */
    #[Computed]
    public function suzulmusUniversiteler(): Collection
    {
        return Universite::query()
            ->whereIn('ad', $this->depo()->universiteler())
            ->when($this->turFiltre !== '', fn ($q) => $q->where('tur', $this->turFiltre))
            ->when($this->sehirFiltre !== '', fn ($q) => $q->where('sehir', $this->sehirFiltre))
            ->when($this->arama !== '', fn ($q) => $q->where(
                fn ($w) => $w->where('ad', 'like', "%{$this->arama}%")
                    ->orWhere('sehir', 'like', "%{$this->arama}%")
            ))
            ->get();
    }

    /**
     * Arama · tür · şehir filtrelerinden geçen üniversite adları; hiçbiri
     * seçili değilse `null` — "daraltma yok".
     *
     * `null` ayrımı gerekli, çünkü {@see kapsamDisi()} yönerge DEPOSUNU
     * geziyor, `universiteler` tablosunu değil. Depoda adı geçtiği hâlde
     * tabloda karşılığı olmayan kayıtlar var; filtre yokken listeyi tablodan
     * geçirmek onları sessizce düşürürdü.
     *
     * @return list<string>|null
     */
    protected function modelSuzgeci(): ?array
    {
        if ($this->arama === '' && $this->turFiltre === '' && $this->sehirFiltre === '') {
            return null;
        }

        /** @var list<string> */
        return $this->suzulmusUniversiteler()->pluck('ad')->all();
    }

    /**
     * Filtre seçeneği olarak şehirler: yalnız yönergesi girili üniversitelerin
     * şehirleri, Türkçe alfabe sırasında.
     *
     * @return list<string>
     */
    #[Computed]
    public function sehirler(): array
    {
        /** @var list<string> $sehirler */
        $sehirler = Universite::query()
            ->whereIn('ad', $this->depo()->universiteler())
            ->whereNotNull('sehir')
            ->distinct()
            ->pluck('sehir')
            ->all();

        // PHP'nin bayt sıralaması Ç/Ğ/İ/Ö/Ş/Ü ile başlayan şehirleri z'den
        // sonraya atıyor (Çanakkale, İzmir, Şanlıurfa listenin dibinde kalır).
        // `intl` composer.json'da zorunlu değil; yoksa düz sıralamaya düşer.
        if (class_exists(Collator::class)) {
            (new Collator('tr_TR'))->sort($sehirler);
        } else {
            sort($sehirler);
        }

        return $sehirler;
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

        $sonuclar = $this->suzulmusUniversiteler()
            ->map(function (Universite $universite) use ($depo, $temelAlan, $faaliyetler, $profil): ?array {
                $esik = $depo->bul(
                    $universite->ad,
                    $this->hedefKadro,
                    $temelAlan,
                    $this->birimIcin($universite->ad),
                );

                if ($esik === null) {
                    return null;
                }

                $sonuc = $depo->degerlendir($esik, $faaliyetler, $profil, $this->beyanOnaylari()[$esik['anahtar']] ?? []);
                $toplamDugum = $sonuc->rolile('toplam');

                // Puansız yönergeler (Sabancı, Samsun) şartlarını adetle yazıyor;
                // orada 'toplam' düğümü hiç yoktur. Bunu 0 ile temsil etmek
                // "0/0 pt" gibi bozuk bir değer üretiyordu — null "baraj yok"
                // demek, "baraj sıfır" demek değil.
                $toplam = $toplamDugum === null ? null : (int) $toplamDugum->mevcut;
                $baraj = $toplamDugum === null ? null : (int) $toplamDugum->gerekli;
                $oran = $this->genelOran($sonuc);

                return [
                    'universite' => $universite,
                    'esik' => $esik,
                    'sonuc' => $sonuc,
                    'toplam' => $toplam,
                    'baraj' => $baraj,
                    'oran' => $oran,
                    // Baraj yoksa ilerleme puandan değil koşul doluluğundan okunur.
                    'puan_orani' => $baraj === null || $baraj <= 0
                        ? $oran
                        : (int) min(100, round($toplam / $baraj * 100)),
                    'kalan' => $baraj === null ? 0 : max(0, $baraj - $toplam),
                    'yapilabilir' => $sonuc->saglandi(),
                    'durum' => $this->durum($sonuc, $oran),
                    'eksik_sayisi' => count($sonuc->eksikler()),
                    'belirsiz_sayisi' => count($sonuc->belirsizler()),
                    // Adayın YAPABİLECEĞİ iş: kutusunu işaretleyeceği koşullar.
                    // Cetveli girilmemiş düğümler buraya girmez — onlar bizim
                    // eksiğimiz, aday onaylayarak kapatamaz. Karıştırılınca kart
                    // "N koşul onayınızı bekliyor" diyor ama ekranda
                    // işaretlenecek kutu çıkmıyordu.
                    'beyan_sayisi' => count(array_filter(
                        $sonuc->beyanlar(),
                        fn (SartSonucu $b) => ! $b->kaynakEksik,
                    )),
                    'cetvel_eksigi_sayisi' => count($sonuc->hesaplanamayanlar()),
                ];
            })
            ->filter();

        $sonuclar = match ($this->siralama) {
            'baraj_azalan' => $sonuclar->sortByDesc(fn (array $s) => $s['baraj'] ?? -1),
            'oran' => $sonuclar->sortByDesc('oran'),
            'alfabetik' => $sonuclar->sortBy(fn (array $s) => $s['universite']->ad),
            default => $sonuclar->sortBy(fn (array $s) => $s['baraj'] ?? PHP_INT_MAX),
        };

        return array_values($sonuclar->all());
    }

    /**
     * Ekranda LİSTELENEN sonuçlar: {@see sonuclar()} üzerine özet bardan
     * seçilen durum filtresi.
     *
     * @return list<SonucSatiri>
     */
    #[Computed]
    public function listelenen(): array
    {
        if ($this->durumFiltre === '') {
            return $this->sonuclar();
        }

        // `alan_yok` bir SONUÇ durumu değil, sonucu hiç olmayanların adı:
        // hiçbir satır o değeri taşımadığı için liste kendiliğinden boşalır ve
        // ekran onları kapsam dışı bölümünden gösterir.
        return array_values(array_filter(
            $this->sonuclar(),
            fn (array $s) => $s['durum'] === $this->durumFiltre,
        ));
    }

    /**
     * Özet bardaki sayaca tıklanınca o duruma filtreler; aynı sayaca yeniden
     * tıklamak filtreyi kaldırır (tek tıkla geri dönüş).
     */
    public function durumSec(string $durum): void
    {
        $this->durumFiltre = $this->durumFiltre === $durum ? '' : $durum;
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
    /**
     * Eşiğin dayandığı cetvelin bilinen kapsam sınırı (varsa).
     *
     * @param  array<string, mixed>  $esik
     */
    public function kapsamNotu(array $esik): ?string
    {
        return app(SartDeposu::class)->katalog((string) $esik['cetvel'])?->kapsamNotu;
    }

    private function genelOran(SartSonucu $sonuc): int
    {
        // Ağacın kendi mantığıyla hesaplanır; eskiden tüm yaprakların minimumu
        // alınıyordu ve "beş yoldan biri" tipi VEYA koşullarında sağlanmayan
        // alternatifler oranı sıfıra çekiyordu.
        return $sonuc->oran();
    }

    /**
     * Kart tıklamasıyla detay modalını açar.
     */
    /**
     * Adayın işaretlediği beyan koşulları: `['esik-anahtari' => ['a1b2…']]`.
     *
     * @return array<string, list<string>>
     */
    #[Computed]
    public function beyanOnaylari(): array
    {
        $gruplu = [];

        foreach (BeyanOnayi::query()->where('user_id', Auth::id())->get() as $onay) {
            $gruplu[$onay->esik_anahtari][] = $onay->kosul_anahtari;
        }

        return $gruplu;
    }

    /**
     * "Bu belgem var" kutusunu açıp kapatır.
     *
     * İşaret koşulu SAĞLANMIŞ saydırdığı için sonucu değiştirir; bu yüzden
     * sonuçlara dayanan bütün computed'ler tazelenmeli.
     */
    public function beyanDegistir(string $esikAnahtari, string $kosulAnahtari): void
    {
        $kayit = BeyanOnayi::query()->where([
            'user_id' => Auth::id(),
            'esik_anahtari' => $esikAnahtari,
            'kosul_anahtari' => $kosulAnahtari,
        ])->first();

        if ($kayit !== null) {
            $kayit->delete();
        } else {
            BeyanOnayi::query()->create([
                'user_id' => Auth::id(),
                'esik_anahtari' => $esikAnahtari,
                'kosul_anahtari' => $kosulAnahtari,
            ]);
        }

        unset($this->beyanOnaylari, $this->sonuclar, $this->listelenen, $this->ozet, $this->detay);
    }

    public function detayAc(int $universiteId): void
    {
        $this->secilenUniversiteId = $universiteId;
        $this->detayAcik = true;
    }

    /**
     * Seçili üniversitenin detayı: sonuç satırının üzerine o yönergenin KENDİ
     * cetveline göre kategori bazlı puan dağılımı ve analizin çıkarıldığı
     * kaynak belgenin adı eklenir.
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
            'kaynak_pdf' => $this->depo()->kaynakPdf($sonuc['esik']['universite']),
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
     * @return array{toplam: int, uygun: int, eksik_bilgi: int, yakin: int, yetersiz: int, alan_yok: int}
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
            // Sonuç satırı olmayanlar; 'toplam'a dâhil DEĞİL.
            'alan_yok' => count($this->kapsamDisi()['alan_yok']),
        ];
    }

    public function render(): View
    {
        return view('livewire.yonerge-analizi');
    }
}
