<?php

namespace App\Services\Scoring\Sart;

use App\Enums\Kategori;
use App\Models\Faaliyet;

/**
 * Bir yönergenin KENDİ puan cetveli: madde kodu → (kategori, kaynaklar, puan, tavan).
 *
 * Şart ağacı `kaynak` etiketlerine değil madde koduna bağlanır, çünkü yönergeler
 * alt-koşullarını kendi kod uzaylarıyla yazıyor ("1. Bölüm'den en az yarısı",
 * "A1-A3 kategorilerinden 70P", "1.1.1-1.3.4.1 arası kodlu faaliyetlerden %30").
 *
 * @phpstan-type Madde array{
 *     baslik: string,
 *     kategori?: string,
 *     kaynaklar?: list<string>,
 *     roller?: list<string>,
 *     turler?: list<string>,
 *     puan?: int,
 *     tavan?: int,
 * }
 * @phpstan-type YazarKademe array{
 *     kademeler?: array<int, float>,
 *     sonrasi?: float,
 *     sonrasi_pay?: float,
 *     bol?: array{pay: float, eksi?: int, ek?: float},
 * }
 * @phpstan-type YazarKatsayisi array{
 *     kademeler?: array<int, float>,
 *     sonrasi?: float,
 *     sonrasi_pay?: float,
 *     bol?: array{pay: float, eksi?: int, ek?: float},
 *     roller?: array<string, YazarKademe>,
 *     kategoriler?: array<string, array{roller?: array<string, YazarKademe>}&YazarKademe>,
 *     haric?: list<string>,
 *     taban?: float,
 * }
 */
readonly class MaddeKatalogu
{
    /**
     * `tez_yayini` kaynak etiketinin normal kalemlerdeki karşılıkları.
     *
     * Tez yayını sözlüğü indeksleri KABA tutuyor (çeyrek yok, "SCIE/SSCI/AHCI"
     * tek etiket); makale sözlüğü ise çeyreğe göre ayrılmış. Bu yüzden bir
     * etiket birden çok karşılığa açılıyor ve aralarından en düşük puanlı
     * satır seçiliyor.
     *
     * @var array<string, list<array{0: Kategori, 1: string}>>
     */
    private const TEZ_KARSILIKLARI = [
        'SCIE/SSCI/AHCI' => [
            [Kategori::Makale, 'SCIE/SSCI (Q1)'], [Kategori::Makale, 'SCIE/SSCI (Q2)'],
            [Kategori::Makale, 'SCIE/SSCI (Q3)'], [Kategori::Makale, 'SCIE/SSCI (Q4)'],
            [Kategori::Makale, 'AHCI'],
        ],
        'ESCI / Scopus' => [[Kategori::Makale, 'ESCI / Scopus']],
        // Sözlük bu etiketleri sonradan BÖLDÜ (ESCI ↔ Scopus, Scopus
        // çeyrekliği, kitabın uluslararası/ulusal ayrımı, "diğer"in iki
        // kolu). Aday artık kapsamlı etiketi seçiyor; karşılık tablosu eski
        // GENEL adlarda kalınca kayıt hiçbir satıra düşmüyor ve SIFIR
        // alıyordu. Karşılık kendi adına bağlanıyor: satır eşleşmesi zaten
        // genel etiket zincirini yürüdüğü için gerekirse kendiliğinden
        // genişliyor, ama cetvelde KAPSAMLI satır varsa ona da düşebiliyor.
        'ESCI' => [[Kategori::Makale, 'ESCI']],
        'Scopus (İlk %10)' => [[Kategori::Makale, 'Scopus (İlk %10)']],
        'Scopus (Q1)' => [[Kategori::Makale, 'Scopus (Q1)']],
        'Scopus (Q2)' => [[Kategori::Makale, 'Scopus (Q2)']],
        'Scopus (Q3)' => [[Kategori::Makale, 'Scopus (Q3)']],
        'Scopus (Q4)' => [[Kategori::Makale, 'Scopus (Q4)']],
        'TR Dizin' => [[Kategori::Makale, 'TR Dizin']],
        'BKCI / Scopus Kitap' => [[Kategori::Kitap, 'BKCI / Scopus Kitap']],
        'BKCI / Scopus Kitap Bölümü' => [[Kategori::Kitap, 'BKCI / Scopus Kitap Bölümü']],
        'Uluslararası/Ulusal Kitap' => [[Kategori::Kitap, 'Uluslararası/Ulusal Kitap']],
        'Uluslararası Kitap' => [[Kategori::Kitap, 'Uluslararası Kitap']],
        'Ulusal Kitap' => [[Kategori::Kitap, 'Ulusal Kitap']],
        'Kitap Bölümü' => [[Kategori::Kitap, 'Kitap Bölümü']],
        'Uluslararası Kitap Bölümü' => [[Kategori::Kitap, 'Uluslararası Kitap Bölümü']],
        'Ulusal Kitap Bölümü' => [[Kategori::Kitap, 'Ulusal Kitap Bölümü']],
        'CPCI Bildiri' => [
            [Kategori::Bildiri, 'Uluslararası Tam Metin (CPCI)'],
            [Kategori::Bildiri, 'Uluslararası Tam Metin'],
        ],
        'Diğer' => [
            [Kategori::Makale, 'Diğer Ulusal Hakemli'],
            [Kategori::Makale, 'Diğer Uluslararası İndeks'],
        ],
        'Diğer (Uluslararası)' => [[Kategori::Makale, 'Diğer Uluslararası İndeks']],
        'Diğer (Ulusal)' => [[Kategori::Makale, 'Diğer Ulusal Hakemli']],
    ];

    /**
     * Tez yayını etiketinin normal kalemlerde bir karşılığı var mı?
     *
     * Sözlük bölündükçe adaya sorulan etiketler ile karşılık tablosunun
     * anahtarları birbirinden kayabiliyor; kayan etiket hiçbir satıra
     * düşmediği için kayıt SESSİZCE sıfır alıyor. Korpus testi bu ikisini
     * karşılaştırıyor.
     */
    public static function tezKarsiligiVar(string $kaynak): bool
    {
        return isset(self::TEZ_KARSILIKLARI[$kaynak]);
    }

    /**
     * Sonradan eklenmiş DAR sanat etiketlerinin eski GENEL karşılıkları.
     *
     * Kaynak sözlüğü büyüdükçe yeni ve daha özel etiketler giriyor (Dokuz
     * Eylül'ün D bölümü için eklenen "TV Programı (Ulusal)" gibi). Daha önce
     * girilmiş cetveller bu etiketleri tanımıyor — satırları genel etikete
     * yazılmış. Karşılık aranmazsa aday, kaydını DAHA DOĞRU etiketlediği için
     * sıfır alır.
     *
     * KÜRATÖRLÜK VE KOORDİNATÖRLÜK BİLEREK DIŞARIDA: sergi küratörlüğü
     * düzenlemek, karma sergiye eserle katılmaktan başka bir iş. Genel
     * etikete bağlamak hak edilmeyen puan verirdi.
     *
     * @var array<string, list<array{0: Kategori, 1: string}>>
     */
    private const SANAT_KARSILIKLARI = [
        'Uzun Metrajlı Film / Belgesel (Uluslararası)' => [[Kategori::SanatselEtkinlik, 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)']],
        'Uzun Metrajlı Film / Belgesel (Ulusal)' => [[Kategori::SanatselEtkinlik, 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)']],
        'TV Filmi / Dizisi (Uluslararası)' => [[Kategori::SanatselEtkinlik, 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)']],
        'TV Filmi / Dizisi (Ulusal)' => [[Kategori::SanatselEtkinlik, 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)']],
        'TV Programı (Uluslararası)' => [[Kategori::SanatselEtkinlik, 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)']],
        'TV Programı (Ulusal)' => [[Kategori::SanatselEtkinlik, 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)']],
        'Reklam / Tanıtım Filmi (Uluslararası)' => [[Kategori::SanatselEtkinlik, 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)']],
        'Reklam / Tanıtım Filmi (Ulusal)' => [[Kategori::SanatselEtkinlik, 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)']],
        'Animasyon / Canlandırma Yapımı' => [[Kategori::SanatselEtkinlik, 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)']],
        'Uygulanmış Tasarım / Koleksiyon' => [[Kategori::SanatselEtkinlik, 'Özgün Eser / Beste / Tasarım']],
        'Müzik Teknolojisi Uygulaması' => [[Kategori::SanatselEtkinlik, 'Özgün Eser / Beste / Tasarım']],
        'Kamusal Alanda Uygulanmış Yapıt (Yurt Dışı)' => [[Kategori::SanatselEtkinlik, 'Kişisel Etkinlik (Uluslararası)']],
        'Kamusal Alanda Uygulanmış Yapıt (Yurt İçi)' => [[Kategori::SanatselEtkinlik, 'Kişisel Etkinlik (Ulusal)']],
        'Grup Etkinliği (Uluslararası)' => [[Kategori::SanatselEtkinlik, 'Karma/Jürili Etkinlik (Uluslararası)']],
        'Grup Etkinliği (Ulusal)' => [[Kategori::SanatselEtkinlik, 'Karma/Jürili Etkinlik (Ulusal)']],
    ];

    /**
     * Yeni ve DAR `egitim_ogretim` etiketlerinin eski GENEL karşılıkları.
     *
     * `Akreditasyon Kurulu Görevi`, korpusun 04.09.2026'ya kadar tek etikette
     * topladığı iki ayrı kalemden ağır olanı (YÖKAK kurumsal akreditasyon
     * kurulunda görev) için açıldı. Korpustaki cetvellerin tamamı hâlâ genel
     * `Akreditasyon Faaliyeti` satırını taşıyor; karşılık aranmazsa kaydını
     * DAHA DOĞRU etiketleyen aday sıfır alırdı.
     *
     * @var array<string, list<array{0: Kategori, 1: string}>>
     */
    private const EGITIM_KARSILIKLARI = [
        'Akreditasyon Kurulu Görevi' => [[Kategori::EgitimOgretim, 'Akreditasyon Faaliyeti']],
    ];

    /**
     * @param  array<string, Madde>  $maddeler  Kod → madde tanımı (sıralı)
     * @param  array<string, list<string>>  $gruplar  Takma ad → kod deseni listesi
     * @param  array<string, int>  $grupTavanlari  Grup adı → o gruptan alınabilecek azami puan
     * @param  string|null  $kapsamNotu  Cetvelin bilinen sınırı (adaya gösterilir)
     * @param  YazarKatsayisi|null  $yazarKatsayisi  Yazar sayısına göre puan çarpanı
     */
    public function __construct(
        public string $anahtar,
        public array $maddeler,
        public array $gruplar = [],
        public array $grupTavanlari = [],
        public ?string $kapsamNotu = null,
        public ?array $yazarKatsayisi = null,
    ) {}

    /**
     * Faaliyetin yazar sayısına göre puan çarpanı.
     *
     * Yönergelerin bir kısmı ortak yazarlı eserlerde puanı bölüyor (Anadolu:
     * iki yazarlıda 0,8; üç yazarlıda 0,6; dört ve üzeri için 2,0/yazar sayısı).
     * Cetvel böyle bir kural bildirmiyorsa çarpan yok.
     *
     * YAZAR LİSTESİ BOŞSA ÇARPAN UYGULANMAZ. Aday yazarları girmemişse kaç
     * kişi olduğunu bilmiyoruz; varsayılan bir sayı uydurmak, girilmiş veriymiş
     * gibi davranmak olurdu. Bu durumda puan tam gösterilir ve gerçek puandan
     * YÜKSEK olabilir — cetvelin kapsam notu bunu söylemek zorunda.
     */
    public function yazarCarpani(Faaliyet $faaliyet): float
    {
        if ($this->yazarKatsayisi === null) {
            return 1.0;
        }

        if (in_array($faaliyet->kategori->value, $this->yazarKatsayisi['haric'] ?? [], true)) {
            return 1.0;
        }

        $sayi = $this->yazarSayisi($faaliyet);

        if ($sayi === null) {
            return 1.0;
        }

        // Üst sınır 1.0: çarpan puanı ASLA artırmamalı. Formül tabanlı
        // kurallarda tutarsız veri bunu delebiliyor (Ağrı'nın "1/n + 0,30"
        // formülü, tek yazarlı bir esere "2. isim" denirse 1,20 üretir).
        // Formun sıra seçenekleri artık böyle bir seçime izin vermiyor ama
        // eski kayıtlar taşıyabilir; sınır motorda duruyor.
        return min(1.0, max(
            $this->yazarKatsayisi['taban'] ?? 0.0,
            $this->kademeCarpani($this->rolTablosu($faaliyet), $sayi),
        ));
    }

    /**
     * Faaliyetin rolüne karşılık gelen kademe tablosu.
     *
     * Rol bilinmiyorsa ORTAK YAZAR varsayılır: sıra belirtilmemiş bir yazarın
     * kaçıncı olduğunu bilmiyoruz ve ortak yazar çarpanı daima en düşüğüdür,
     * yani aday puanını fazla görmez.
     *
     * @return YazarKademe
     */
    private function rolTablosu(Faaliyet $faaliyet): array
    {
        // Yönergelerin bir kısmı yazar payını KATEGORİYE göre başka türlü
        // hesaplıyor: makalede isim sırasına bağlı bir kademe tablosu,
        // kitap ve projede düz "puan / yazar sayısı". `kategoriler` bu ikinci
        // kuralı taşıyor ve varsa genel tabloyu geçersiz kılıyor.
        //
        // Böyle bir kural varken kategoriyi `haric`e yazmak FAZLA SAYMAK
        // olur (§0): çok yazarlı kitap tam puan alır. Kategori kuralını
        // yazamıyorsan `haric` yerine en sıkı kademeyi kullan.
        $kategori = $this->yazarKatsayisi['kategoriler'][$faaliyet->kategori->value] ?? null;

        if ($kategori !== null) {
            $kategoriRolleri = $kategori['roller'] ?? [];

            if ($kategoriRolleri === []) {
                return $kategori;
            }

            $rol = $faaliyet->rol ?? 'ortak';

            return $kategoriRolleri[$rol] ?? $kategoriRolleri['ortak'] ?? [];
        }

        $roller = $this->yazarKatsayisi['roller'] ?? [];

        if ($roller === []) {
            return $this->yazarKatsayisi;
        }

        $rol = $faaliyet->rol ?? 'ortak';

        return $roller[$rol] ?? $roller['ortak'] ?? [];
    }

    /**
     * Kademe tablosundan yazar sayısına düşen çarpan.
     *
     * @param  YazarKademe  $tablo
     */
    private function kademeCarpani(array $tablo, int $sayi): float
    {
        $kademeler = $tablo['kademeler'] ?? [];

        if (isset($kademeler[$sayi])) {
            return $kademeler[$sayi];
        }

        // Kademelerin bittiği yerden sonrası: sabit çarpan, "pay / yazar
        // sayısı" ya da "pay / (yazar sayısı - eksi)" biçiminde olabiliyor.
        if (isset($tablo['sonrasi'])) {
            return $tablo['sonrasi'];
        }

        if (isset($tablo['bol'])) {
            $bolen = $sayi - ($tablo['bol']['eksi'] ?? 0);

            if ($bolen <= 0) {
                return 1.0;
            }

            // Bazı yönergeler payı bölmekle kalmayıp sabit bir pay ekliyor
            // (Ağrı: "Puan / Yazar Sayısı + Puan × 0,30" — birinci isme
            // bölünmüş payın üstüne %30 ilave veriliyor).
            return $tablo['bol']['pay'] / $bolen + ($tablo['bol']['ek'] ?? 0.0);
        }

        if (isset($tablo['sonrasi_pay'])) {
            return $tablo['sonrasi_pay'] / $sayi;
        }

        return $kademeler === [] ? 1.0 : (float) end($kademeler);
    }

    /**
     * Faaliyetin yazar sayısı; liste boşsa null.
     */
    private function yazarSayisi(Faaliyet $faaliyet): ?int
    {
        $ham = trim((string) $faaliyet->yazarlar);

        if ($ham === '') {
            return null;
        }

        $adlar = array_filter(array_map('trim', explode(',', $ham)), fn (string $a) => $a !== '');

        return $adlar === [] ? null : count($adlar);
    }

    /**
     * Madde puanına yazar çarpanını uygular.
     *
     * Aşağı yuvarlanır: yönergeler küsuratı tanımlamıyor, aşağı yuvarlamak
     * adayın puanını fazla göstermemeyi garanti eder.
     */
    private function carpanliPuan(Faaliyet $faaliyet, int $hamPuan): int
    {
        $carpan = $this->yazarCarpani($faaliyet);

        return $carpan === 1.0 ? $hamPuan : (int) floor($hamPuan * $carpan);
    }

    /**
     * Desen listesini somut madde kodlarına çözer.
     *
     * Desteklenen desenler:
     *   '*'            → tüm maddeler
     *   'GRUP_ADI'     → $gruplar'daki takma ad (özyinelemeli çözülür)
     *   '1.1*'         → önek eşleşmesi
     *   '1.1.1..1.3.4' → cetveldeki sıraya göre aralık (iki uç dâhil)
     *   '1.2'          → tam kod
     *
     * @param  list<string>  $desenler
     * @return list<string>
     */
    public function coz(array $desenler): array
    {
        return $this->cozInternal($desenler, []);
    }

    /**
     * @param  list<string>  $desenler
     * @param  list<string>  $acilanGruplar  Özyineleme yolu — döngü koruması
     * @return list<string>
     */
    private function cozInternal(array $desenler, array $acilanGruplar): array
    {
        $kodlar = array_keys($this->maddeler);
        $sonuc = [];

        foreach ($desenler as $desen) {
            if ($desen === '*') {
                return $kodlar;
            }

            // Bir ad hem grup hem madde olabilir (ör. 'A3' => ['A3']). Grubu
            // yalnızca bu yolda daha önce açılmadıysa aç; aksi hâlde madde
            // olarak ele al. Aksi takdirde veri dosyasındaki kendine referans
            // motoru sonsuz özyinelemeye sokuyor.
            if (isset($this->gruplar[$desen]) && ! in_array($desen, $acilanGruplar, true)) {
                $sonuc = array_merge($sonuc, $this->cozInternal(
                    $this->gruplar[$desen],
                    [...$acilanGruplar, $desen],
                ));

                continue;
            }

            if (str_contains($desen, '..')) {
                [$bas, $son] = explode('..', $desen, 2);
                $i = array_search($bas, $kodlar, true);
                $j = array_search($son, $kodlar, true);

                if ($i !== false && $j !== false) {
                    $sonuc = array_merge($sonuc, array_slice($kodlar, min($i, $j), abs($j - $i) + 1));
                }

                continue;
            }

            if (str_ends_with($desen, '*')) {
                $onek = rtrim($desen, '*');
                $sonuc = array_merge($sonuc, array_values(array_filter(
                    $kodlar,
                    fn (string $kod) => str_starts_with($kod, $onek),
                )));

                continue;
            }

            if (isset($this->maddeler[$desen])) {
                $sonuc[] = $desen;
            }
        }

        return array_values(array_unique($sonuc));
    }

    /**
     * Sözlükte KAPSAM TAŞIMAYAN etiketlerin kapsamlı karşılıkları.
     *
     * Kaynaklar kitabı, çeviriyi, editörlüğü ve daveti kimi yerde uluslararası
     * ile ulusal diye ayırıyor, kimi yerde ayırmıyor. Sözlük ikisini de
     * taşısın diye kapsamlı etiketler EKLENDİ, genel olanlar KALDI: ayrım
     * yapmayan kaynağın satırı genel etiketi listeler ve her iki kaydı da
     * karşılar; ayıran kaynağın satırı yalnız kapsamlı olanı listeler.
     *
     * Aday kaydını kapsamlı etiketle giriyor; genel etiket cetvel tarafında
     * yaşamayı sürdürüyor. Bu tablo ikisini birbirine bağlıyor — böylece
     * korpustaki üç bin küsur satırı yeniden yazmak gerekmedi.
     *
     * @var array<string, string>
     */
    private const GENEL_ETIKET = [
        'Uluslararası Kitap' => 'Uluslararası/Ulusal Kitap',
        'Ulusal Kitap' => 'Uluslararası/Ulusal Kitap',
        'Uluslararası Kitap Bölümü' => 'Kitap Bölümü',
        'Ulusal Kitap Bölümü' => 'Kitap Bölümü',
        'Uluslararası Çeviri Kitap' => 'Çeviri Kitap',
        'Ulusal Çeviri Kitap' => 'Çeviri Kitap',
        'Uluslararası Çeviri Kitap Bölümü' => 'Çeviri Kitap Bölümü',
        'Ulusal Çeviri Kitap Bölümü' => 'Çeviri Kitap Bölümü',
        'Uluslararası Kitap Editörlüğü' => 'Kitap Editörlüğü',
        'Ulusal Kitap Editörlüğü' => 'Kitap Editörlüğü',
        'Davetli Konuşmacı (Uluslararası)' => 'Davetli Konuşmacı',
        'Davetli Konuşmacı (Ulusal)' => 'Davetli Konuşmacı',
        'Uluslararası Ders / Metot Kitabı' => 'Ders / Metot Kitabı',
        'Ulusal Ders / Metot Kitabı' => 'Ders / Metot Kitabı',
        'Diğer Hakemli Dergi (Uluslararası)' => 'Diğer Hakemli Dergi',
        'Diğer Hakemli Dergi (Ulusal)' => 'Diğer Hakemli Dergi',
        'Patent (Uluslararası)' => 'Patent',
        'Patent (Ulusal)' => 'Patent',
        'Diğer (Uluslararası)' => 'Diğer',
        'Diğer (Ulusal)' => 'Diğer',
        'SCIE/SSCI/AHCI' => 'WoS / Scopus',
        'ESCI / Scopus' => 'WoS / Scopus',
        'ESCI' => 'ESCI / Scopus',
        'Scopus' => 'ESCI / Scopus',
        'ESCI Dergi' => 'ESCI / Scopus Dergi',
        'Scopus Dergi' => 'ESCI / Scopus Dergi',
        'Scopus Dergi (Q1)' => 'Scopus Dergi',
        'Scopus Dergi (Q2)' => 'Scopus Dergi',
        'Scopus Dergi (Q3)' => 'Scopus Dergi',
        'Scopus Dergi (Q4)' => 'Scopus Dergi',
        'Scopus (Q1)' => 'Scopus',
        'Scopus (Q2)' => 'Scopus',
        'Scopus (Q3)' => 'Scopus',
        'Scopus (Q4)' => 'Scopus',
        // Dilim ekseni: ilk %5 ⊂ ilk %10 ⊂ Q1. Zincir üç kademeli, eşleştirici
        // sonuna kadar yürüyor.
        'SCIE/SSCI (İlk %1)' => 'SCIE/SSCI (İlk %5)',
        'SCIE/SSCI (İlk %5)' => 'SCIE/SSCI (İlk %10)',
        'SCIE/SSCI (İlk %10)' => 'SCIE/SSCI (Q1)',
        'Scopus (İlk %10)' => 'Scopus (Q1)',
    ];

    /**
     * Faaliyetin etiketi satırın listesini karşılıyor mu?
     *
     * Kapsamlı bir kayıt, satır GENEL etiketi listeliyorsa da sayılır — ayrım
     * yapmayan kaynak iki kaydı da kabul ediyor demektir. Tersi geçerli
     * DEĞİL: satır kapsamlı etiketi listeliyorsa öteki kapsamdaki kayıt
     * sayılmaz; ayrımı isteyen kaynak zaten odur.
     *
     * @param  list<string>  $kaynaklar
     */
    private static function kaynakEsler(?string $kaynak, array $kaynaklar): bool
    {
        // Zincir İKİ KADEMELİ olabiliyor: 'ESCI' → 'ESCI / Scopus' →
        // 'WoS / Scopus'. Tek adım atmak, ayrım yapmayan atıf satırlarını
        // (korpusta dört yüzden fazla) kapsamlı kayda kapatıyordu — aday
        // puanını sessizce kaybediyordu.
        $gorulen = [];

        while ($kaynak !== null && ! isset($gorulen[$kaynak])) {
            if (in_array($kaynak, $kaynaklar, true)) {
                return true;
            }

            $gorulen[$kaynak] = true;
            $kaynak = self::GENEL_ETIKET[$kaynak] ?? null;
        }

        return false;
    }

    /**
     * Faaliyet verilen kodlardan herhangi birine giriyor mu?
     *
     * @param  list<string>  $kodlar
     */
    public function eslesir(Faaliyet $faaliyet, array $kodlar): bool
    {
        foreach ($kodlar as $kod) {
            if ($this->maddeyeUyar($faaliyet, $kod)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Faaliyetin verilen kodlar içindeki puanı.
     *
     * Yönergelerin ortak kuralı uygulanır: "Adayın herhangi bir yayını birden
     * fazla puan grubuna giriyorsa hesaplamada sadece en yüksek olan puan
     * dikkate alınır." Bu yüzden Faaliyet->puan alanına hiç bakılmaz; puan
     * daima cetvelden türetilir.
     *
     * @param  list<string>  $kodlar
     */
    public function puan(Faaliyet $faaliyet, array $kodlar): int
    {
        $enYuksek = 0;

        foreach ($kodlar as $kod) {
            if ($this->maddeyeUyar($faaliyet, $kod)) {
                $enYuksek = max($enYuksek, $this->maddeler[$kod]['puan'] ?? 0);
            }
        }

        return $this->carpanliPuan($faaliyet, $enYuksek);
    }

    /**
     * Verilen kodların kapsadığı kaynak etiketleri — "bu koşula hangi dergiler
     * / hangi tür çalışmalar sayılıyor?" sorusunun cevabı.
     *
     * Arayüz bunu koşulun altında rozet olarak gösterir; böylece kullanıcı
     * yönergenin madde kodunu bilmek zorunda kalmaz.
     *
     * @param  list<string>  $kodlar
     * @return list<string>
     */
    public function kapsam(array $kodlar): array
    {
        $etiketler = [];

        foreach ($kodlar as $kod) {
            foreach ($this->maddeler[$kod]['kaynaklar'] ?? [] as $kaynak) {
                $etiketler[$kaynak] = true;
            }
        }

        return array_keys($etiketler);
    }

    /**
     * Faaliyetlerin verilen kodlar içindeki TOPLAM puanı, grup tavanları
     * uygulanarak.
     *
     * Yönergelerin neredeyse tamamı bölüm bazlı tavan koyuyor ("Bu maddeden en
     * fazla 30 puan alınabilir"). Tavan uygulanmazsa tek bir kategoriden gelen
     * yüzlerce puan barajı sahte biçimde aşar.
     *
     * Tavan dolarken yüksek puanlı faaliyetler önceliklidir: aday dosyasını
     * böyle sunar ve yönergeler de azami puanı kastetmektedir.
     *
     * @param  iterable<Faaliyet>  $faaliyetler
     * @param  list<string>  $kodlar
     */
    public function topla(iterable $faaliyetler, array $kodlar): int
    {
        $katkilar = [];

        foreach ($faaliyetler as $faaliyet) {
            $kod = $this->enIyiKod($faaliyet, $kodlar);

            if ($kod !== null) {
                $katkilar[] = [$kod, $this->carpanliPuan($faaliyet, $this->maddeler[$kod]['puan'] ?? 0)];
            }
        }

        if ($this->grupTavanlari === []) {
            return array_sum(array_column($katkilar, 1));
        }

        /** @var array<string, list<string>> $uyeler */
        $uyeler = [];
        $kalan = [];

        foreach ($this->grupTavanlari as $grup => $tavan) {
            $uyeler[$grup] = $this->coz([$grup]);
            $kalan[$grup] = $tavan;
        }

        usort($katkilar, fn (array $a, array $b) => $b[1] <=> $a[1]);

        $toplam = 0;

        foreach ($katkilar as [$kod, $puan]) {
            $izin = $puan;

            foreach ($uyeler as $grup => $grupKodlari) {
                if (in_array($kod, $grupKodlari, true)) {
                    $izin = min($izin, $kalan[$grup]);
                }
            }

            foreach ($uyeler as $grup => $grupKodlari) {
                if (in_array($kod, $grupKodlari, true)) {
                    $kalan[$grup] -= $izin;
                }
            }

            $toplam += $izin;
        }

        return $toplam;
    }

    /**
     * Faaliyetin verilen kodlar içinde en yüksek puanı veren kodu.
     *
     * @param  list<string>  $kodlar
     */
    private function enIyiKod(Faaliyet $faaliyet, array $kodlar): ?string
    {
        $enIyi = null;
        $enYuksek = -1;

        foreach ($kodlar as $kod) {
            if (! $this->maddeyeUyar($faaliyet, $kod)) {
                continue;
            }

            $puan = $this->maddeler[$kod]['puan'] ?? 0;

            if ($puan > $enYuksek) {
                $enYuksek = $puan;
                $enIyi = $kod;
            }
        }

        return $enIyi ?? $this->esdegerKod($faaliyet, $kodlar);
    }

    /**
     * Kaydın, doğrudan karşılığı bulunmayan cetveldeki EŞDEĞER satırı.
     *
     * Aday yayınını "Tezden Üretilmiş Yayın" olarak kaydettiğinde kayıt
     * `tez_yayini` kategorisine düşüyor ve daha kaba bir indeks etiketi
     * taşıyor (`SCIE/SSCI/AHCI`, çeyrek yok). Yönergelerin çoğu tezden
     * üretilmiş yayına AYRI bir satır vermiyor — o yayın normal makale gibi
     * puanlanıyor. Karşılık aranmazsa aday doğru etiketlediği için SIFIR
     * alırdı; hassas davranan aday cezalandırılmış olurdu.
     *
     * İKİ GÜVENLİK KURALI:
     *   1. Yalnız cetvelde HİÇ `tez_yayini` satırı yoksa devreye girer.
     *      Satır varsa yönerge o yayını bilerek başka türlü puanlıyordur
     *      (Marmara Eğitim yarım puan veriyor) ve ona dokunulmaz.
     *   2. Kaba etiket birden çok satıra uyduğunda EN DÜŞÜK puanlı seçilir:
     *      `SCIE/SSCI/AHCI` çeyrek taşımıyor, Q1 saymak fazla saymak olurdu
     *      (§0).
     *
     * @param  list<string>  $kodlar
     */
    private function esdegerKod(Faaliyet $faaliyet, array $kodlar): ?string
    {
        $adaylar = match (true) {
            // Tez yayını: cetvelde HİÇ tez satırı yoksa normal kaleme düşer.
            // Satır varsa yönerge o yayını bilerek başka türlü puanlıyordur.
            $faaliyet->kategori === Kategori::TezYayini && ! $this->tezSatiriVar() => self::TEZ_KARSILIKLARI[$faaliyet->kaynak] ?? [],
            // Sanat etiketleri AYNI kategori içinde daraldığı için ek koruma
            // gerekmiyor: genel satır zaten yönergenin o kalem için yazdığı
            // satırdır.
            $faaliyet->kategori === Kategori::SanatselEtkinlik => self::SANAT_KARSILIKLARI[$faaliyet->kaynak] ?? [],
            // Akreditasyon etiketleri de aynı kategori içinde daraldı.
            $faaliyet->kategori === Kategori::EgitimOgretim => self::EGITIM_KARSILIKLARI[$faaliyet->kaynak] ?? [],
            default => [],
        };

        $enIyi = null;
        $enDusuk = PHP_INT_MAX;

        foreach ($adaylar as [$kategori, $kaynak]) {
            $benzer = clone $faaliyet;
            $benzer->kategori = $kategori;
            $benzer->kaynak = $kaynak;

            foreach ($kodlar as $kod) {
                if (! $this->maddeyeUyar($benzer, $kod)) {
                    continue;
                }

                $puan = $this->maddeler[$kod]['puan'] ?? 0;

                if ($puan < $enDusuk) {
                    $enDusuk = $puan;
                    $enIyi = $kod;
                }
            }
        }

        return $enIyi;
    }

    /**
     * Cetvel tezden üretilmiş yayına ayrı satır veriyor mu?
     */
    private function tezSatiriVar(): bool
    {
        foreach ($this->maddeler as $madde) {
            if (($madde['kategori'] ?? null) === Kategori::TezYayini->value) {
                return true;
            }
        }

        return false;
    }

    /**
     * Kodun kendi puanı (cetvel değeri).
     */
    public function maddePuani(string $kod): int
    {
        return $this->maddeler[$kod]['puan'] ?? 0;
    }

    /**
     * Her faaliyetin bu cetveldeki puanı, faaliyet kimliğine göre. Listeler
     * bunu gösterir; kategori dağılımıyla aynı hesap.
     *
     * @param  iterable<Faaliyet>  $faaliyetler
     * @return array<int, int>
     */
    public function faaliyetPuanlari(iterable $faaliyetler): array
    {
        $kodlar = array_keys($this->maddeler);
        $puanlar = [];

        foreach ($faaliyetler as $faaliyet) {
            $puanlar[$faaliyet->id] = $this->puan($faaliyet, $kodlar);
        }

        return $puanlar;
    }

    /**
     * Faaliyetlerin bu cetvele göre kategori bazlı puan ve adet dağılımı.
     * Analiz ekranındaki dağılım grafiği bunu kullanır.
     *
     * @param  iterable<Faaliyet>  $faaliyetler
     * @return array<string, array{puan: int, adet: int}>
     */
    public function kategoriDagilimi(iterable $faaliyetler): array
    {
        $kodlar = array_keys($this->maddeler);
        $dagilim = [];

        foreach ($faaliyetler as $faaliyet) {
            $anahtar = $faaliyet->kategori->value;
            $dagilim[$anahtar] ??= ['puan' => 0, 'adet' => 0];
            $dagilim[$anahtar]['puan'] += $this->puan($faaliyet, $kodlar);
            $dagilim[$anahtar]['adet']++;
        }

        return $dagilim;
    }

    private function maddeyeUyar(Faaliyet $faaliyet, string $kod): bool
    {
        $madde = $this->maddeler[$kod] ?? null;

        if ($madde === null) {
            return false;
        }

        if (isset($madde['kategori']) && $faaliyet->kategori->value !== $madde['kategori']) {
            return false;
        }

        if (isset($madde['kaynaklar']) && ! self::kaynakEsler($faaliyet->kaynak, $madde['kaynaklar'])) {
            return false;
        }

        // Yönergeler proje ve tez danışmanlığı puanını role göre ayırıyor
        // (Akdeniz 6.1 yürütücü 200 ↔ 6.2 araştırıcı 50).
        if (isset($madde['roller']) && ! in_array($faaliyet->rol, $madde['roller'], true)) {
            return false;
        }

        // Aynı dergideki iki çalışma türüne göre farklı puanlanıyor: Ege 1(a)
        // Q1 özgün makale 75, 1(b) Q1 derleme 60, 1(c) editöre mektup 25.
        //
        // Türü GİRİLMEMİŞ kayıt özgün araştırma makalesi sayılır. Bunun
        // alternatifi hiçbir maddeye uymayıp sessizce 0 puan almaktı; form da
        // aynı varsayılanı sunuyor, dolayısıyla türü farklı olan çalışmayı
        // işaretlemek adayın elinde.
        if (isset($madde['turler'])) {
            $tur = $faaliyet->yayin_turu ?? 'ozgun_makale';

            if (! in_array($tur, $madde['turler'], true)) {
                return false;
            }
        }

        return true;
    }
}
