<?php

namespace App\Services\Scoring\Sart;

use App\Models\Faaliyet;

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
 *     sart: array<string, mixed>,
 * }
 * @phpstan-type Cetvel array{
 *     maddeler: array<string, Madde>,
 *     gruplar?: array<string, list<string>>,
 *     grup_tavanlari?: array<string, int>,
 *     kapsam_notu?: string,
 * }
 */
class SartDeposu
{
    /** Eşik kaydının opsiyonel alanları. @var array<string, mixed> */
    private const VARSAYILANLAR = ['birim' => null, 'aday_notu' => null, 'durum' => 'dogrulandi'];

    /** @var list<Esik>|null */
    private ?array $esikler = null;

    /** @var array<string, MaddeKatalogu>|null */
    private ?array $cetveller = null;

    /**
     * Veri doğrudan dizi olarak da verilebilir; testler üretim verisine bağlı
     * kalmadan kendi yönergesini tanımlayabilsin diye.
     *
     * @param  list<Esik>|null  $esikVerisi
     * @param  array<string, Cetvel>|null  $cetvelVerisi
     */
    public function __construct(
        private readonly ?array $esikVerisi = null,
        private readonly ?array $cetvelVerisi = null,
    ) {}

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

        foreach ($this->dosyalar(database_path('data/yonerge')) as $dosya) {
            /** @var list<array<string, mixed>> $satirlar */
            $satirlar = require $dosya;

            foreach ($satirlar as $satir) {
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
                $icerik = require $dosya;

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
            );
        }

        return $this->cetveller;
    }

    public function katalog(string $anahtar): ?MaddeKatalogu
    {
        return $this->cetveller()[$anahtar] ?? null;
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
     * Doğrulanmış eşik verisi olan üniversite adları.
     *
     * @return list<string>
     */
    public function universiteler(): array
    {
        return array_values(array_unique(array_column($this->esikler(), 'universite')));
    }

    /**
     * @return Esik|null
     */
    public function esik(string $anahtar): ?array
    {
        foreach ($this->esikler() as $esik) {
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

        foreach ($this->esikler() as $esik) {
            if ($esik['universite'] === $universite && $esik['birim'] !== null) {
                $birimler[$esik['birim']] = true;
            }
        }

        return array_keys($birimler);
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
        $adaylar = array_values(array_filter(
            $this->esikler(),
            fn (array $esik) => $esik['universite'] === $universite
                && $esik['kadro'] === $kadro
                && $esik['alan'] === $alan,
        ));

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
     */
    public function degerlendir(array $esik, iterable $faaliyetler, Profil $profil): SartSonucu
    {
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
        );

        return $degerlendirici->degerlendir($esik['sart'], $faaliyetler, $profil);
    }
}
