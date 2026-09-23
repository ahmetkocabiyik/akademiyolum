<?php

namespace App\Services\Yayin;

/**
 * Adayın yapıştırdığı adresi hangi okuyucunun karşılayacağını bulur.
 *
 * Adayın hangi yazılımı kullandığını bilmesi gerekmiyor: adresi yapıştırıyor,
 * sunucu adından sistem çıkıyor. Yeni bir sistem eklemek bu listeye bir satır.
 */
class ProfilOkuyuculari
{
    /** @var list<ProfilOkuyucu> */
    private array $okuyucular;

    public function __construct(AvesisProfili $avesis, ApbsProfili $apbs)
    {
        $this->okuyucular = [$avesis, $apbs];
    }

    /**
     * @return array{okuyucu: ProfilOkuyucu, adres: array{taban: string, kullanici: string}}|null
     */
    public function coz(string $girdi): ?array
    {
        foreach ($this->okuyucular as $okuyucu) {
            $adres = $okuyucu->adres($girdi);

            if ($adres !== null) {
                return ['okuyucu' => $okuyucu, 'adres' => $adres];
            }
        }

        return null;
    }

    /**
     * Hata iletisinde gösterilen örnek adresler.
     *
     * @return list<string>
     */
    public function ornekAdresler(): array
    {
        return array_map(fn (ProfilOkuyucu $okuyucu): string => $okuyucu->ornekAdres(), $this->okuyucular);
    }
}
