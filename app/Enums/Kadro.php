<?php

namespace App\Enums;

use App\Services\Scoring\Sart\SartDeposu;

/**
 * Yönergelerin eşik tanımladığı üç kadro.
 *
 * Değerler yönerge veri dosyalarındaki `kadro` alanıyla birebir aynı; eşik
 * arama ({@see SartDeposu::bul()}) bu dizgilerle
 * yapılıyor.
 *
 * Hem etiket haritası hem "adayın bir üst kadrosu" eşlemesi dört ayrı ekranda
 * kopyalıydı. Biri değişince (ör. yeni bir unvan) öbürleri sessizce geride
 * kalıyor ve aynı aday Dashboard'da doçentliğe, Yönerge Analizi'nde Dr. Öğr.
 * Üyeliğine göre ölçülüyordu.
 */
enum Kadro: string
{
    case DrOgrUyesi = 'dr_ogr_uyesi';
    case Docentlik = 'docentlik';
    case Profesorluk = 'profesorluk';

    public function etiket(): string
    {
        return match ($this) {
            self::DrOgrUyesi => 'Dr. Öğr. Üyesi',
            self::Docentlik => 'Doçent',
            self::Profesorluk => 'Profesör',
        };
    }

    /**
     * Seçici listeleri için `deger => etiket` haritası.
     *
     * @return array<string, string>
     */
    public static function etiketler(): array
    {
        $etiketler = [];

        foreach (self::cases() as $kadro) {
            $etiketler[$kadro->value] = $kadro->etiket();
        }

        return $etiketler;
    }

    /**
     * Adayın unvanına göre HEDEF kadro: bir üst basamak.
     *
     * Arş. Gör. ve Öğr. Gör. için hedef Dr. Öğr. Üyeliği; profesör için daha
     * üst kadro olmadığından profesörlük şartları gösterilir (aday kadro
     * değiştirmek ya da başka kurumda aynı kadroya başvurmak isteyebilir).
     */
    public static function hedef(?string $unvan): self
    {
        return match ($unvan) {
            'Doç. Dr.', 'Prof. Dr.' => self::Profesorluk,
            'Dr. Öğr. Üyesi' => self::Docentlik,
            default => self::DrOgrUyesi,
        };
    }

    /**
     * Etiketten değere: kaydedilmiş bir kadro dizgisini ekranda yazıya çevirir.
     */
    public static function etiketi(string $deger): string
    {
        return (self::tryFrom($deger) ?? self::DrOgrUyesi)->etiket();
    }
}
