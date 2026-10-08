<?php

namespace App\Services\Scoring\Sart;

use App\Models\Faaliyet;
use Closure;

/**
 * Şart ağaçlarını ve madde cetvellerini veri dosyalarından okur, bir eşik için
 * hazır değerlendirici üretir.
 *
 * Veri dosyaları: database/data/yonerge/{slug}.php · database/data/cetvel/{anahtar}.php
 *
 * @phpstan-import-type Madde from MaddeKatalogu
 *
 * @phpstan-type Esik array{
 *     anahtar: string, universite: string, kadro: string, alan: string,
 *     birim: ?string, cetvel: string, notlar: string, aday_notu: ?string,
 *     durum: string, sart: array<string, mixed>,
 * }
 * @phpstan-type Cetvel array{
 *     maddeler: array<string, Madde>,
 *     gruplar?: array<string, list<string>>,
 *     grup_tavanlari?: array<string, int>,
 *     kapsam_notu?: string,
 *     yazar_katsayisi?: array{kademeler: array<int, float>, sonrasi_pay?: float},
 * }
 */
class SartDeposu
{
    /**
     * Kaynak PDF'i okunup elle doğrulanmış eşik. Yalnızca bu durumdaki kayıtlar
     * adaya gösterilir.
     */
    public const DOGRULANDI = 'dogrulandi';

    /**
     * Makineyle çıkarılmış, henüz kaynağına karşı okunmamış eşik. Adayın
     * göreceği hiçbir yolda dönmez — yanlış bir eşik, eksik eşikten kötüdür:
     * aday buna bakıp kariyer kararı veriyor.
     */
    public const TASLAK = 'taslak';

    /** Eşik kaydının opsiyonel alanları. @var array<string, mixed> */
    private const VARSAYILANLAR = ['birim' => null, 'aday_notu' => null, 'durum' => self::DOGRULANDI];

    /** @var list<Esik>|null */
    private ?array $esikler = null;

    /** @var array<string, MaddeKatalogu>|null */
    private ?array $cetveller = null;

    /**
     * Üniversite adı → yönergenin okunduğu PDF'in `pdf/` altındaki adı.
     * {@see esikler()} dosyaları okurken doldurur.
     *
     * @var array<string, string>|null
     */
    private ?array $kaynakPdfleri = null;

    /**
     * Veri doğrudan dizi olarak da verilebilir; testler üretim verisine bağlı
     * kalmadan kendi yönergesini tanımlayabilsin diye.
     *
     * @param  list<Esik>|null  $esikVerisi
     * @param  array<string, Cetvel>|null  $cetvelVerisi
     * @param  array<string, string>|null  $kaynakPdfVerisi  üniversite adı → PDF dosya adı
     * @param  (Closure(): list<string>)|null  $gizliKaynak  Panelden gizlenmiş üniversiteler;
     *                                                       verilmezse hiçbiri gizli sayılmaz
     */
    public function __construct(
        private readonly ?array $esikVerisi = null,
        private readonly ?array $cetvelVerisi = null,
        private readonly ?array $kaynakPdfVerisi = null,
        private readonly ?Closure $gizliKaynak = null,
    ) {}

    /** @var list<string>|null */
    private ?array $gizliler = null;

    /**
     * Panelden geçici olarak yayından kaldırılmış üniversiteler.
     *
     * Yönerge verisi kodda; gizleme veritabanındaki bir katman
     * (`gizli_yonergeler`). Kaynak dışarıdan veriliyor: kendi verisiyle
     * kurulan testlerdeki depo veritabanına dokunmasın.
     *
     * @return list<string>
     */
    public function gizliUniversiteler(): array
    {
        return $this->gizliler ??= $this->gizliKaynak !== null ? ($this->gizliKaynak)() : [];
    }

    public function gizliMi(string $universite): bool
    {
        return in_array($universite, $this->gizliUniversiteler(), true);
    }

    /** Panelde gizleme değişince aynı istekte de güncel liste okunsun. */
    public function gizlileriYenile(): void
    {
        $this->gizliler = null;
    }

    /**
     * Tüm eşikler. Üniversite başına bir dosya okunur
     * (database/data/yonerge/{slug}.php); `_` ile başlayanlar atlanır.
     *
     * Bir kaydın `alan`ı dizi olabilir — grup satırı, alan başına ayrı kayda
     * açılır. Böylece motor tarafında hiçbir gruplama/fallback mantığı kalmaz:
     * eşleşme daima tam (kadro + alan) eşleşmesidir.
     *
     * @return list<Esik>
     */
    public function esikler(): array
    {
        if ($this->esikler !== null) {
            return $this->esikler;
        }

        if ($this->esikVerisi !== null) {
            // Enjekte edilen veri de aynı şekle sahip olmalı; aksi hâlde
            // opsiyonel alanlar yalnızca üretim yolunda tanımlı olur.
            return $this->esikler = array_map(
                fn (array $esik): array => array_merge(self::VARSAYILANLAR, $esik),
                $this->esikVerisi,
            );
        }

        $esikler = [];
        $this->kaynakPdfleri = [];

        foreach ($this->dosyalar(database_path('data/yonerge')) as $dosya) {
            /** @var list<array<string, mixed>> $satirlar */
            $satirlar = self::dosyayiOku($dosya);
            $kaynakPdf = self::kaynakPdfAdi($dosya);

            foreach ($satirlar as $satir) {
                if ($kaynakPdf !== null) {
                    $this->kaynakPdfleri[(string) $satir['universite']] = $kaynakPdf;
                }

                foreach ((array) $satir['alan'] as $alan) {
                    /** @var Esik $kayit */
                    $kayit = array_merge(
                        self::VARSAYILANLAR,
                        $satir,
                        [
                            'alan' => $alan,
                            'anahtar' => "{$satir['anahtar']}-{$alan}",
                            // Puanlamayı ÜAK'a devreden yönergelerde cetvel alana
                            // göre değişir (ÜAK her temel alan için ayrı tablo
                            // yayımlıyor): 'cetvel' => 'uak-2025-{alan}'.
                            'cetvel' => str_replace('{alan}', $alan, (string) $satir['cetvel']),
                        ],
                    );
                    $esikler[] = $kayit;
                }
            }
        }

        return $this->esikler = $esikler;
    }

    /**
     * @return array<string, MaddeKatalogu>
     */
    public function cetveller(): array
    {
        if ($this->cetveller !== null) {
            return $this->cetveller;
        }

        if ($this->cetvelVerisi !== null) {
            $ham = $this->cetvelVerisi;
        } else {
            $ham = [];

            foreach ($this->dosyalar(database_path('data/cetvel')) as $dosya) {
                /** @var Cetvel|array{cetveller: array<string, Cetvel>} $icerik */
                $icerik = self::dosyayiOku($dosya);

                // Bir dosya normalde tek cetveldir ve adını dosyadan alır. Aynı
                // kaynağın alan başına ayrı tablo yayımladığı yerlerde (ÜAK'ın
                // 12 temel alan tablosu) tablolar ortak bir gövdeden türetilir;
                // o dosya `cetveller` anahtarıyla hepsini birden döndürür.
                if (isset($icerik['cetveller'])) {
                    $ham = array_merge($ham, $icerik['cetveller']);

                    continue;
                }

                $ham[basename($dosya, '.php')] = $icerik;
            }
        }

        $this->cetveller = [];

        foreach ($ham as $anahtar => $cetvel) {
            $this->cetveller[$anahtar] = new MaddeKatalogu(
                anahtar: $anahtar,
                maddeler: $cetvel['maddeler'],
                gruplar: $cetvel['gruplar'] ?? [],
                grupTavanlari: $cetvel['grup_tavanlari'] ?? [],
                kapsamNotu: $cetvel['kapsam_notu'] ?? null,
                yazarKatsayisi: $cetvel['yazar_katsayisi'] ?? null,
            );
        }

        return $this->cetveller;
    }

    public function katalog(string $anahtar): ?MaddeKatalogu
    {
        return $this->cetveller()[$anahtar] ?? null;
    }

    /**
     * Yönergenin çıkarıldığı kaynak belge (`pdf/` altındaki dosya adı).
     *
     * Kaynağın adı veri satırlarında değil, dosyanın başlık docblock'unda
     * duruyor ve tek doğru kopya orası: her yönerge dosyası TEK üniversiteyi
     * anlatıyor ve `Kaynak:` satırı yönerge girilirken elle yazılıyor. Ayrı
     * bir eşleme dosyası tutmak ikinci bir doğru üretir, sessizce kayar.
     */
    public function kaynakPdf(string $universite): ?string
    {
        if ($this->kaynakPdfVerisi !== null) {
            return $this->kaynakPdfVerisi[$universite] ?? null;
        }

        // Eşleme dosyalar okunurken doluyor; henüz okunmadıysa tetikler.
        $this->esikler();

        return $this->kaynakPdfleri[$universite] ?? null;
    }

    /**
     * Dosyanın başlık docblock'undaki `Kaynak: pdf/…` satırı.
     *
     * Uzun dosya adları docblock'ta bir alt satıra sarılıyor ("… Bilim ve
     * Teknoloji\n * Üniversitesi Kriter Değişikliği.pdf"), o yüzden satır
     * başlarındaki ` * ` süsü kaldırılıp metin düzleştirilerek aranır.
     */
    private static function kaynakPdfAdi(string $dosya): ?string
    {
        // Docblock dosyanın ilk satırlarında; tamamını okumaya gerek yok.
        // Kesme çok baytlı bir karakterin ortasına düşebildiği için desenler
        // `u` bayrağı ALMAZ: geçersiz UTF-8'de `preg_*` null döner ve eşleşme
        // sessizce kaybolur. Aranan yapı zaten saf ASCII, yakalanan ad ise
        // olduğu gibi geri veriliyor.
        $baslik = (string) file_get_contents($dosya, length: 4096);
        $duz = (string) preg_replace('/\R\s*\*\s?/', ' ', $baslik);

        return preg_match('#Kaynak: pdf/(.+?\.pdf)#', $duz, $eslesme) === 1
            ? $eslesme[1]
            : null;
    }

    /**
     * Veri dosyasını KENDİ değişken kapsamında okur.
     *
     * `require` çağrıldığı metodun kapsamında çalışır. Yönerge dosyaları eşik
     * listesini bir döngüyle üretebildiği için (Çukurova on iki temel alan için
     * otuz altı eşik türetiyor) dosyanın yerel değişkeni okuyucunun yerel
     * değişkeniyle aynı adı taşıyabilir; o zaman dosya, kendinden önce okunmuş
     * dosyaların birikmiş sonucunu sessizce ezer. Statik metot bu kapsamı
     * yalıtır — dosyanın hangi adları kullandığı okuyucuyu ilgilendirmez.
     *
     * @return array<mixed>
     */
    private static function dosyayiOku(string $dosya): array
    {
        return require $dosya;
    }

    /**
     * Klasördeki veri dosyaları. `_` ile başlayanlar ortak kalıp/yardımcıdır,
     * veri değildir.
     *
     * @return list<string>
     */
    private function dosyalar(string $klasor): array
    {
        $bulunan = glob($klasor.'/*.php') ?: [];

        return array_values(array_filter(
            $bulunan,
            fn (string $yol) => ! str_starts_with(basename($yol), '_'),
        ));
    }

    /**
     * Yalnızca doğrulanmış eşikler — adaya bir şey gösteren her yolun kaynağı.
     *
     * @return list<Esik>
     */
    public function dogrulanmisEsikler(): array
    {
        return array_values(array_filter(
            $this->esikler(),
            // Gizlenen yönerge adaya hiçbir yoldan görünmez: bütün sorgular
            // (bul, adaylar, esik, universiteler) buradan geçiyor.
            fn (array $esik) => $esik['durum'] === self::DOGRULANDI && ! $this->gizliMi($esik['universite']),
        ));
    }

    /**
     * Doğrulanmış eşik verisi olan üniversite adları.
     *
     * Yalnızca taslak eşiği olan üniversite listede görünmez; görünseydi aday
     * kartı açıp boş sonuç bulurdu.
     *
     * @return list<string>
     */
    public function universiteler(): array
    {
        return array_values(array_unique(array_column($this->dogrulanmisEsikler(), 'universite')));
    }

    /**
     * `referans` düğümlerinin hedefi. Taslak eşikler burada da dönmez: aksi
     * hâlde doğrulanmış bir eşik, taslak bir eşiğe atıf yaparak doğrulanmamış
     * veriyi sonuca taşırdı. Hedef bulunamazsa düğüm gerekçesiyle birlikte
     * belirsiz kalır ({@see SartDegerlendirici::referans()}).
     *
     * @return Esik|null
     */
    public function esik(string $anahtar): ?array
    {
        foreach ($this->dogrulanmisEsikler() as $esik) {
            if ($esik['anahtar'] === $anahtar) {
                return $esik;
            }
        }

        return null;
    }

    /**
     * Bir üniversitenin program bazlı eşiklerindeki birim adları.
     *
     * Boş dönerse yönerge programdan bağımsızdır ve kullanıcıya program
     * sorulmasına gerek yoktur.
     *
     * @return list<string>
     */
    public function birimler(string $universite): array
    {
        $birimler = [];

        foreach ($this->dogrulanmisEsikler() as $esik) {
            if ($esik['universite'] === $universite && $esik['birim'] !== null) {
                $birimler[$esik['birim']] = true;
            }
        }

        return array_keys($birimler);
    }

    /**
     * Üniversite + kadro + temel alan için TÜM aday eşikler, birim ayrımı
     * yapılmadan.
     *
     * `bul()` boş dönünce iki ayrı durum söz konusudur ve aday için anlamları
     * bambaşkadır: hiç aday yoksa o temel alan yönergede yok; birden çok aday
     * varsa alan kapsanıyor ama birim seçilmediği için seçim yapılamıyor.
     * Arayüz bu ikisini ayırabilsin diye adaylar ayrıca sorulabiliyor.
     *
     * @return list<Esik>
     */
    public function adaylar(string $universite, string $kadro, string $alan): array
    {
        return array_values(array_filter(
            $this->dogrulanmisEsikler(),
            fn (array $esik) => $esik['universite'] === $universite
                && $esik['kadro'] === $kadro
                && $esik['alan'] === $alan,
        ));
    }

    /**
     * Üniversite + kadro + temel alan için tam eşleşen eşik. Yoksa null döner
     * ve üniversite listede gösterilmez — tahmini eşik üretilmez.
     *
     * Programa özgü bir eşik (birim dolu) YALNIZCA o program seçiliyse eşleşir.
     * Eskiden `$birim === null` her şeyi eşleştiriyordu; Sabancı gibi aynı temel
     * alanda birden çok programı olan yönergelerde bu, dosyada önce gelen kaydı
     * döndürüp Endüstri Mühendisliği adayına Bilgisayar Bilimleri kriterlerini
     * gösterirdi.
     *
     * @return Esik|null
     */
    public function bul(string $universite, string $kadro, string $alan, ?string $birim = null): ?array
    {
        $adaylar = $this->adaylar($universite, $kadro, $alan);

        // Program yalnızca BELİRSİZLİK varsa gerekir: tek aday varsa program
        // bilinmese de o kullanılır. Birden fazla aday varsa (Sabancı gibi
        // program bazlı yönergeler) doğrusunu seçmek imkânsızdır — eskiden
        // dosyada önce gelen kayıt dönüyor, Endüstri Mühendisliği adayına
        // Bilgisayar Bilimleri kriterleri gösteriliyordu.
        if (count($adaylar) <= 1) {
            return $adaylar[0] ?? null;
        }

        foreach ($adaylar as $esik) {
            if ($esik['birim'] === $birim) {
                return $esik;
            }
        }

        return null;
    }

    /**
     * Bir eşiği adayın faaliyet ve profiline karşı değerlendirir.
     *
     * @param  Esik  $esik
     * @param  iterable<Faaliyet>  $faaliyetler
     * @param  list<string>  $beyanOnaylari  Adayın belgesiyle teyit ettiği beyan
     *                                       düğümlerinin anahtarları
     */
    public function degerlendir(
        array $esik,
        iterable $faaliyetler,
        Profil $profil,
        array $beyanOnaylari = [],
    ): SartSonucu {
        $katalog = $this->katalog($esik['cetvel']);

        if ($katalog === null) {
            throw new \RuntimeException("Cetvel bulunamadı: {$esik['cetvel']}");
        }

        // `referans` düğümü hedefi `{alan}` yer tutucusuyla yazabilir
        // (ör. profesörlük, aynı alanın doçentlik şartını yeniden çağırır).
        $degerlendirici = new SartDegerlendirici(
            $katalog,
            fn (string $anahtar): ?array => $this->esik(
                str_replace('{alan}', $esik['alan'], $anahtar),
            ),
            $beyanOnaylari,
        );

        return $degerlendirici->degerlendir($esik['sart'], $faaliyetler, $profil);
    }
}
