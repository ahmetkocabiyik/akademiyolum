<?php

namespace App\Services\Scoring\Sart;

/**
 * Şart ağacı düğümleri için ortak kalıplar.
 *
 * Üniversite veri dosyaları (database/data/yonerge/{slug}.php) bunları çağırır
 * ve yalnızca kendi farkını yazar. Statik metot olmalarının sebebi: veri
 * dosyaları `extract()` ile kapalı kutu değişken üretmesin — hem statik analiz
 * hem editör bu çağrıları çözebilsin.
 *
 * Şema ve düğüm tipleri: database/data/sart-agaci-taslak.php
 *
 * @phpstan-type Dugum array<string, mixed>
 */
final class Kalip
{
    /** @var array{baslangic: string, son_yil: null} */
    public const DOKTORA_SONRASI = ['baslangic' => 'doktora', 'son_yil' => null];

    /** @var array{baslangic: string, son_yil: null} */
    public const DOCENTLIK_SONRASI = ['baslangic' => 'docentlik', 'son_yil' => null];

    /** @var array{baslangic: string, son_yil: null} */
    public const SON_ATAMA_SONRASI = ['baslangic' => 'son_atama', 'son_yil' => null];

    /**
     * Son N yıl penceresi; başlangıç verilirse ikisi birlikte uygulanır.
     *
     * @return array{baslangic: string|null, son_yil: int}
     */
    public static function sonYil(int $yil, ?string $baslangic = null): array
    {
        return ['baslangic' => $baslangic, 'son_yil' => $yil];
    }

    /**
     * Merkezi yabancı dil sınavı barajı.
     *
     * @return Dugum
     */
    public static function yds(int $enAz): array
    {
        return [
            'tip' => 'metrik',
            'aciklama' => "Merkezi yabancı dil sınavından en az {$enAz} puan",
            'metrik' => 'yds',
            'min' => $enAz,
        ];
    }

    /**
     * Toplam puan barajı. `rol` arayüzün bu düğümü metne bakmadan bulması için.
     *
     * Varsayılan olarak cetvelin tamamından toplanır ve aday "Tüm
     * faaliyetlerden toplam en az N puan" görür. Bir yönerge puanı birden çok
     * listede tanımlıyor ve barajı yalnızca bazılarından istiyorsa `$maddeler`
     * ile kapsam daraltılır; `$liste` o kapsamın adayın göreceği adıdır.
     *
     * `$liste` YALNIZCA KAPSAM DARALDIĞINDA VE DÜZ TÜRKÇE VERİLİR. Kapsam
     * cetvelin tamamıysa `$liste` geçmeyin: "EK-1 kalemlerinden", "Çizelge-1
     * kalemlerinden" gibi belge adları adaya hiçbir bilgi vermez, yalnızca
     * yönergenin kod diline geri döner. Doğru kullanım "Sanatsal etkinlik
     * kalemlerinden" gibi adayın ne sayıldığını anladığı bir addır.
     *
     * @param  array<string, mixed>|null  $donem
     * @param  list<string>  $maddeler
     * @return Dugum
     */
    public static function toplam(int $puan, ?array $donem = null, array $maddeler = ['*'], ?string $liste = null): array
    {
        $nereden = $liste === null ? 'Tüm faaliyetlerden' : "{$liste} kalemlerinden";

        return self::temizle([
            'tip' => 'puan',
            'rol' => 'toplam',
            'aciklama' => "{$nereden} toplam en az {$puan} puan",
            'maddeler' => $maddeler,
            'min_puan' => $puan,
            'donem' => $donem,
        ]);
    }

    /**
     * Belirli maddelerden asgari puan.
     *
     * @param  list<string>  $maddeler
     * @param  array<string, mixed>|null  $donem
     * @return Dugum
     */
    public static function puanDan(string $aciklama, array $maddeler, int $puan, ?array $donem = null, ?string $madde = null): array
    {
        return self::temizle([
            'tip' => 'puan',
            'aciklama' => $aciklama,
            'madde' => $madde,
            'maddeler' => $maddeler,
            'min_puan' => $puan,
            'donem' => $donem,
        ]);
    }

    /**
     * Oransal koşul ("toplam puanın en az yarısı şu maddelerden").
     *
     * @param  list<string>  $maddeler
     * @param  list<string>  $payda
     * @param  array<string, mixed>|null  $donem
     * @return Dugum
     */
    public static function oran(string $aciklama, array $maddeler, float $oran, array $payda = ['*'], ?array $donem = null, ?string $madde = null): array
    {
        return self::temizle([
            'tip' => 'puan',
            'aciklama' => $aciklama,
            'madde' => $madde,
            'maddeler' => $maddeler,
            'min_oran' => $oran,
            'oran_payda' => $payda,
            'donem' => $donem,
        ]);
    }

    /**
     * Adet koşulu.
     *
     * @param  list<string>  $maddeler
     * @param  'tek'|'ilk'|'baslica'|null  $yazar
     * @param  array<string, mixed>|null  $donem
     * @param  Dugum|null  $telafi
     * @return Dugum
     */
    public static function adet(
        string $aciklama,
        array $maddeler,
        int $sayi,
        ?string $yazar = null,
        ?array $donem = null,
        ?array $telafi = null,
        ?string $madde = null,
    ): array {
        return self::temizle([
            'tip' => 'adet',
            'aciklama' => $aciklama,
            'madde' => $madde,
            'maddeler' => $maddeler,
            'min_adet' => $sayi,
            'yazar' => $yazar,
            'donem' => $donem,
            'telafi' => $telafi,
        ]);
    }

    /**
     * İndeks ikamesi: "şu indeksten N makale şartı yerine daha üst bir indeksten
     * N makale de kabul edilir." Korpusta çok sayıda yönergenin dipnotu
     * (ör. Afyon: "TR Dizin şartı yerine SCIE/SSCI/AHCI veya ESCI/SCOPUS...").
     *
     * Bir `adet` düğümünün `telafi` dalı olarak kullanılır.
     *
     * @param  list<string>  $maddeler  İkame olarak kabul edilen madde kümesi
     * @param  'tek'|'ilk'|'baslica'|null  $yazar
     * @return Dugum
     */
    public static function indeksTelafisi(string $aciklama, array $maddeler, int $sayi, ?string $yazar = null): array
    {
        return self::adet($aciklama, $maddeler, $sayi, $yazar);
    }

    /**
     * Faaliyet satırı olmayan ölçüt (h-indeksi, proje yürütücülüğü, ders...).
     *
     * @param  array<string, mixed>|null  $donem
     * @return Dugum
     */
    public static function metrik(string $aciklama, string $metrik, int $min, ?array $donem = null): array
    {
        return self::temizle([
            'tip' => 'metrik',
            'aciklama' => $aciklama,
            'metrik' => $metrik,
            'min' => $min,
            'donem' => $donem,
        ]);
    }

    /**
     * Otomatik doğrulanamayan koşul — belge ile beyan edilir.
     *
     * @return Dugum
     */
    public static function beyan(string $aciklama, ?string $madde = null): array
    {
        return self::temizle(['tip' => 'beyan', 'aciklama' => $aciklama, 'madde' => $madde]);
    }

    /**
     * Koşul doğası gereği hesaplanabilir ama dayandığı puan cetveli henüz
     * projeye girilmedi.
     *
     * `beyan`dan ayrı tutulur: biri kalıcı bir gerçeklik (jüri kararı, belge),
     * diğeri bizim veri açığımız. Karıştırılırsa ne aday koşulun ileride
     * hesaplanacağını bilebilir ne de kapsam raporu gerçek beyan oranını
     * ölçebilir.
     *
     * @return Dugum
     */
    public static function hesaplanamiyor(string $aciklama, ?string $madde = null): array
    {
        return self::temizle([
            'tip' => 'beyan',
            'kaynak_eksik' => true,
            'aciklama' => $aciklama,
            'madde' => $madde,
        ]);
    }

    /**
     * @param  list<Dugum>  $cocuklar
     * @return Dugum
     */
    public static function ve(string $aciklama, array $cocuklar): array
    {
        return ['tip' => 've', 'aciklama' => $aciklama, 'cocuklar' => $cocuklar];
    }

    /**
     * @param  list<Dugum>  $cocuklar
     * @param  Dugum|null  $telafi
     * @return Dugum
     */
    public static function veya(string $aciklama, array $cocuklar, ?array $telafi = null): array
    {
        return self::temizle([
            'tip' => 'veya',
            'aciklama' => $aciklama,
            'cocuklar' => $cocuklar,
            'telafi' => $telafi,
        ]);
    }

    /**
     * @param  list<Dugum>  $cocuklar
     * @return Dugum
     */
    public static function kIle(string $aciklama, int $k, array $cocuklar): array
    {
        return ['tip' => 'k_ile', 'k' => $k, 'aciklama' => $aciklama, 'cocuklar' => $cocuklar];
    }

    /**
     * Null alanları düşürür — veri dosyalarında opsiyonel anahtarlar
     * görünmesin diye.
     *
     * @param  Dugum  $dugum
     * @return Dugum
     */
    private static function temizle(array $dugum): array
    {
        return array_filter($dugum, fn ($deger) => $deger !== null);
    }
}
