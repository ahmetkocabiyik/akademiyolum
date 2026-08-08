<?php

namespace App\Services\Scoring\Sart;

use App\Models\Faaliyet;

/**
 * Şart ağaçlarını ve madde cetvellerini veri dosyalarından okur, bir eşik için
 * hazır değerlendirici üretir.
 *
 * Veri dosyaları: database/data/esikler-agac.php · database/data/cetveller-agac.php
 *
 * @phpstan-import-type Madde from MaddeKatalogu
 *
 * @phpstan-type Esik array{
 *     anahtar: string, universite: string, kadro: string, alan: string,
 *     birim: ?string, cetvel: string, notlar: string, sart: array<string, mixed>,
 * }
 * @phpstan-type Cetvel array{
 *     maddeler: array<string, Madde>,
 *     gruplar?: array<string, list<string>>,
 *     grup_tavanlari?: array<string, int>,
 * }
 */
class SartDeposu
{
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
     * @return list<Esik>
     */
    public function esikler(): array
    {
        /** @var list<Esik> */
        return $this->esikler ??= $this->esikVerisi ?? require database_path('data/esikler-agac.php');
    }

    /**
     * @return array<string, MaddeKatalogu>
     */
    public function cetveller(): array
    {
        if ($this->cetveller !== null) {
            return $this->cetveller;
        }

        /** @var array<string, Cetvel> $ham */
        $ham = $this->cetvelVerisi ?? require database_path('data/cetveller-agac.php');

        $this->cetveller = [];

        foreach ($ham as $anahtar => $cetvel) {
            $this->cetveller[$anahtar] = new MaddeKatalogu(
                anahtar: $anahtar,
                maddeler: $cetvel['maddeler'],
                gruplar: $cetvel['gruplar'] ?? [],
                grupTavanlari: $cetvel['grup_tavanlari'] ?? [],
            );
        }

        return $this->cetveller;
    }

    public function katalog(string $anahtar): ?MaddeKatalogu
    {
        return $this->cetveller()[$anahtar] ?? null;
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
     * Üniversite + kadro + temel alan için tam eşleşen eşik. Yoksa null döner
     * ve üniversite listede gösterilmez — tahmini eşik üretilmez.
     *
     * @return Esik|null
     */
    public function bul(string $universite, string $kadro, string $alan, ?string $birim = null): ?array
    {
        foreach ($this->esikler() as $esik) {
            if ($esik['universite'] === $universite
                && $esik['kadro'] === $kadro
                && $esik['alan'] === $alan
                && ($birim === null || $esik['birim'] === null || $esik['birim'] === $birim)
            ) {
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

        $degerlendirici = new SartDegerlendirici(
            $katalog,
            fn (string $anahtar): ?array => $this->esik($anahtar),
        );

        return $degerlendirici->degerlendir($esik['sart'], $faaliyetler, $profil);
    }
}
