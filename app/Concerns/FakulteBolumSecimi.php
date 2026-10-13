<?php

namespace App\Concerns;

use App\Enums\TemelAlan;
use App\Services\Kurum\BirimKatalogu;
use App\Services\Scoring\Sart\SartDeposu;

/**
 * Kurulum ve profil ekranlarının ortak temel alan, fakülte ve bölüm seçimi.
 *
 * Seçenekler üniversiteye göre gelir (bkz. BirimKatalogu) ama kutular serbest
 * metne izin verir: atlas yalnızca öğrenci alan birimleri listeliyor,
 * enstitüde ya da yeni açılmış bir fakültede çalışan kendisi yazabilmeli.
 *
 * Kaskad: üst seçim (üniversite, temel alan, fakülte) değişince alt seçim
 * ESKİ listeden seçilmişse ve yeni listede yoksa sıfırlanır. Elle yazılmış
 * değer (eski listede de olmayan) korunur; yoksa kendi yazdığı fakülteyi
 * kaydetmeye çalışan aday onu her seferinde silinmiş bulurdu.
 *
 * Kullanan bileşende `universite`, `temelAlan`, `fakulte`, `bolum` public
 * string özellikleri tanımlı olmalı.
 */
trait FakulteBolumSecimi
{
    private const KASKAD_ALANLARI = ['universite', 'temelAlan', 'fakulte'];

    /** @var list<string>|null Güncellemeden önceki fakülte seçenekleri. */
    private ?array $oncekiFakulteler = null;

    /** @var list<string>|null Güncellemeden önceki bölüm seçenekleri. */
    private ?array $oncekiBolumler = null;

    /**
     * @return list<string>
     */
    public function fakulteSecenekleri(): array
    {
        return app(BirimKatalogu::class)->fakulteler($this->universite, TemelAlan::tryFrom($this->temelAlan) ?? TemelAlan::Sosyal);
    }

    /**
     * Temel alanlar, üniversitenin yönergesine göre iki grupta: ölçüt
     * tanımlananlar ve tanımlanmayanlar. Yönerge yoksa hepsi ilk grupta.
     *
     * Tanımlanmayanlar gizlenmez: temel alan kişinin kendi disiplini ve
     * yönerge verisinde eksik kalmış bir alan da olabilir; listede bulamayan
     * aday yanlış alanı seçerdi.
     *
     * @return array{tanimli: array<string, string>, tanimsiz: array<string, string>}
     */
    public function temelAlanGruplari(): array
    {
        $tumu = TemelAlan::secenekler();
        $alanlar = app(SartDeposu::class)->alanlar($this->universite);

        if ($alanlar === []) {
            return ['tanimli' => $tumu, 'tanimsiz' => []];
        }

        $tanimli = array_intersect_key($tumu, array_flip($alanlar));

        return ['tanimli' => $tanimli, 'tanimsiz' => array_diff_key($tumu, $tanimli)];
    }

    /** Seçili temel alan, üniversitenin yönergesinin ölçüt tanımlamadığı bir alan mı? */
    public function temelAlanTanimsiz(): bool
    {
        return array_key_exists($this->temelAlan, $this->temelAlanGruplari()['tanimsiz']);
    }

    /**
     * @return list<string>
     */
    public function bolumSecenekleri(): array
    {
        return app(BirimKatalogu::class)->bolumler($this->universite, $this->fakulte);
    }

    public function updatingFakulteBolumSecimi(string $alan): void
    {
        if (in_array($alan, self::KASKAD_ALANLARI, true)) {
            $this->oncekiFakulteler = $this->fakulteSecenekleri();
            $this->oncekiBolumler = $this->bolumSecenekleri();
        }
    }

    public function updatedFakulteBolumSecimi(string $alan): void
    {
        if (! in_array($alan, self::KASKAD_ALANLARI, true) || $this->oncekiFakulteler === null) {
            return;
        }

        if ($alan !== 'fakulte' && self::listedenDustu($this->fakulte, $this->oncekiFakulteler, $this->fakulteSecenekleri())) {
            $this->fakulte = '';
        }

        if (self::listedenDustu($this->bolum, $this->oncekiBolumler ?? [], $this->bolumSecenekleri())) {
            $this->bolum = '';
        }

        $this->oncekiFakulteler = $this->oncekiBolumler = null;
    }

    /**
     * @param  list<string>  $onceki
     * @param  list<string>  $yeni
     */
    private static function listedenDustu(string $deger, array $onceki, array $yeni): bool
    {
        return $deger !== '' && in_array($deger, $onceki, true) && ! in_array($deger, $yeni, true);
    }
}
