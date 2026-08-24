<?php

namespace App\Services\Scoring\Sart;

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
 *     haric?: list<string>,
 *     taban?: float,
 * }
 */
readonly class MaddeKatalogu
{
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

        return $enIyi;
    }

    /**
     * Kodun kendi puanı (cetvel değeri).
     */
    public function maddePuani(string $kod): int
    {
        return $this->maddeler[$kod]['puan'] ?? 0;
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

        if (isset($madde['kaynaklar']) && ! in_array($faaliyet->kaynak, $madde['kaynaklar'], true)) {
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
