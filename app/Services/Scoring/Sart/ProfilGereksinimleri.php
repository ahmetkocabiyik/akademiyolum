<?php

namespace App\Services\Scoring\Sart;

use App\Enums\Kadro;
use App\Enums\TemelAlan;
use App\Livewire\Settings\Profile;
use App\Models\User;

/**
 * Hesaplamanın doğru yapılabilmesi için adayın doldurması GEREKEN akademik
 * profil alanları ve bunlardan hangilerinin boş olduğu.
 *
 * Herkese aynı liste sorulmuyor: doktora öğrencisinin doktora tarihi,
 * Dr. Öğr. Üyesinin doçentlik tarihi yok; zorlamak adayı uydurma tarih
 * girmeye iterdi. Gereken alanlar iki kaynaktan birleşir:
 *
 *  1. Adayın KENDİ eşiğinin (üniversite × hedef kadro × alan) şart ağacının
 *     okuduğu profil değerleri — dönem başlangıçları ("doktora sonrası")
 *     ve sayaçlar (yabancı dil, h-indeksi, yurt dışı süre). Boşsa o koşul
 *     "belirsiz" kalıyor, yani hesap eksik.
 *  2. Unvanın kesin gerektirdiği tarihler: Dr. Öğr. Üyesinin doktorası ve
 *     son ataması, doçentin doçentlik tarihi var. Yönergesi girilmemiş
 *     üniversitede de Yönerge Analizi başka kurumları bunlarla hesaplıyor.
 */
class ProfilGereksinimleri
{
    /** Şart ağacındaki dönem başlangıcı → kullanıcı sütunu. */
    private const DONEM_ALANLARI = [
        'doktora' => 'doktora_tarihi',
        'docentlik' => 'docentlik_tarihi',
        'son_atama' => 'son_atama_tarihi',
        'lisans' => 'lisans_tarihi',
    ];

    /** Profilden okunan sayaç → kullanıcı sütunu. Diğer sayaçlar faaliyetlerden türetiliyor. */
    private const METRIK_ALANLARI = [
        'yds' => 'yds_puani',
        'h_indeksi' => 'h_indeksi',
        'yurtdisi_ay' => 'yurtdisi_ay',
    ];

    public function __construct(private SartDeposu $depo) {}

    /**
     * Gereken ama boş alanlar, profil formundaki sırayla: sütun → etiket.
     *
     * @return array<string, string>
     */
    public function eksikler(User $user): array
    {
        return array_filter(
            $this->gerekenler($user),
            fn (string $etiket, string $alan): bool => $user->{$alan} === null || $user->{$alan} === '',
            ARRAY_FILTER_USE_BOTH,
        );
    }

    /**
     * @return array<string, string>
     */
    public function gerekenler(User $user): array
    {
        $alanlar = [...$this->unvanGerektirdikleri($user->unvan), ...$this->esikGerektirdikleri($user)];

        $etiketler = ['program_dili' => 'Biriminizin öğretim dili']
            + array_map(fn (array $tanim): string => $tanim[0], Profile::akademikAlanlar());

        return array_intersect_key($etiketler, array_flip($alanlar));
    }

    /**
     * @return list<string>
     */
    private function unvanGerektirdikleri(?string $unvan): array
    {
        return match ($unvan) {
            'Doç. Dr.', 'Prof. Dr.' => ['doktora_tarihi', 'docentlik_tarihi', 'son_atama_tarihi'],
            'Dr. Öğr. Üyesi' => ['doktora_tarihi', 'son_atama_tarihi'],
            default => [],
        };
    }

    /**
     * @return list<string>
     */
    private function esikGerektirdikleri(User $user): array
    {
        if ($user->universite === null) {
            return [];
        }

        $esik = $this->depo->bul(
            $user->universite,
            Kadro::hedef($user->unvan)->value,
            ($user->temel_alan ?? TemelAlan::Sosyal)->value,
            $user->birim,
        );

        if ($esik === null) {
            return [];
        }

        $alanlar = [];
        self::topla($esik['sart'], $alanlar);

        return array_values(array_unique($alanlar));
    }

    /**
     * Şart ağacını gezip profilden okunan değerleri toplar. Düğüm tiplerine
     * tek tek bakmak yerine anahtarlara bakılıyor: dönem her koşul tipinin
     * içinde olabiliyor ve yeni bir tip eklenince burası unutulmamalı.
     *
     * @param  array<mixed>  $dugum
     * @param  list<string>  $alanlar
     */
    private static function topla(array $dugum, array &$alanlar): void
    {
        if (is_string($dugum['baslangic'] ?? null) && isset(self::DONEM_ALANLARI[$dugum['baslangic']])) {
            $alanlar[] = self::DONEM_ALANLARI[$dugum['baslangic']];
        }

        if (is_string($dugum['metrik'] ?? null)) {
            if (isset(self::METRIK_ALANLARI[$dugum['metrik']])) {
                $alanlar[] = self::METRIK_ALANLARI[$dugum['metrik']];
            }

            // Yabancı dil barajı birimin öğretim diline göre kademeli.
            if (isset($dugum['kademeler'])) {
                $alanlar[] = 'program_dili';
            }
        }

        foreach ($dugum as $alt) {
            if (is_array($alt)) {
                self::topla($alt, $alanlar);
            }
        }
    }
}
