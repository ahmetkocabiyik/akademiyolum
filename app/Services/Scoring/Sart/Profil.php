<?php

namespace App\Services\Scoring\Sart;

use Carbon\CarbonInterface;

/**
 * Adayın faaliyet satırı OLMAYAN ölçütleri: dönem referans tarihleri, sınav ve
 * sayaç değerleri. Korpustaki yönergelerin %78'i en az bir tanesini arıyor
 * (h-indeksi, proje yürütücülüğü, tez danışmanlığı, ders yarıyılı, yurt dışı süre).
 *
 * Tüm alanlar nullable: bilinmeyen bir değer koşulu "sağlanmadı" yapmaz,
 * {@see Durum::Belirsiz} yapar.
 */
readonly class Profil
{
    public function __construct(
        public ?CarbonInterface $doktoraTarihi = null,
        public ?CarbonInterface $docentlikTarihi = null,
        public ?CarbonInterface $sonAtamaTarihi = null,
        public ?CarbonInterface $lisansTarihi = null,
        /** Birimin öğretim dili: turkce | yabanci_dil_30 | yabanci_dil_100 | yabanci_dil_egitimi */
        public ?string $programDili = null,
        public ?int $yds = null,
        public ?int $hIndeksi = null,
        public ?int $atifSayisi = null,
        public ?int $dersYariyil = null,
        public ?int $yurtdisiAy = null,
        public ?int $tezDanismanlik = null,
        public ?int $tezEsDanismanlik = null,
        public ?int $doktoraTezDanismanlik = null,
        public ?int $projeYurutuculuk = null,
        public ?int $projeArastirmaci = null,
        public ?int $projeDanisman = null,
    ) {}

    /**
     * Bir dönem başlangıcının referans tarihi. Bilinmiyorsa null.
     */
    public function referansTarih(?string $baslangic): ?CarbonInterface
    {
        return match ($baslangic) {
            'doktora' => $this->doktoraTarihi,
            'docentlik' => $this->docentlikTarihi,
            'son_atama' => $this->sonAtamaTarihi,
            'lisans' => $this->lisansTarihi,
            default => null,
        };
    }

    /**
     * Sayaç türü bir ölçütün değeri. Tanınmayan ad için null döner.
     */
    public function metrik(string $ad): ?int
    {
        return match ($ad) {
            'yds' => $this->yds,
            'h_indeksi' => $this->hIndeksi,
            'atif_sayisi' => $this->atifSayisi,
            'ders_yariyil' => $this->dersYariyil,
            'yurtdisi_ay' => $this->yurtdisiAy,
            'tez_danismanlik' => $this->tezDanismanlik,
            'tez_es_danismanlik' => $this->tezEsDanismanlik,
            'doktora_tez_danismanlik' => $this->doktoraTezDanismanlik,
            'proje_yurutuculuk' => $this->projeYurutuculuk,
            'proje_arastirmaci' => $this->projeArastirmaci,
            'proje_danisman' => $this->projeDanisman,
            default => null,
        };
    }

    /**
     * Ölçüt girilmemişse adaya ne söyleneceği.
     *
     * Ölçütlerin çoğu faaliyet satırlarından TÜRETİLİR; onlar için "profilinizi
     * doldurun" demek yanlış yönlendirmedir — aday Faaliyetler bölümüne kayıt
     * eklemelidir. Yalnızca tek skaler olan ölçütler profilden okunur.
     */
    public function eksikNedeni(string $ad): string
    {
        $faaliyetten = [
            'atif_sayisi' => 'atıf',
            'ders_yariyil' => 'ders (Eğitim-Öğretim)',
            'tez_danismanlik' => 'tez danışmanlığı',
            'tez_es_danismanlik' => 'eş danışmanlık',
            'doktora_tez_danismanlik' => 'doktora/yeterlik tezi danışmanlığı',
            'proje_yurutuculuk' => 'proje',
            'proje_arastirmaci' => 'proje',
            'proje_danisman' => 'proje',
        ];

        if (isset($faaliyetten[$ad])) {
            return "Faaliyetler bölümüne henüz {$faaliyetten[$ad]} kaydı eklenmemiş";
        }

        return match ($ad) {
            'yds' => 'Profilinizde yabancı dil sınavı puanı girilmemiş',
            'h_indeksi' => 'Profilinizde h-indeksi girilmemiş',
            'yurtdisi_ay' => 'Profilinizde yurt dışı araştırma süresi girilmemiş',
            default => "Profilinizde \"{$ad}\" değeri girilmemiş",
        };
    }

    /**
     * Dönem başlangıcının profildeki karşılığı girilmemişse gerekçe.
     *
     * "Doçentlik sonrası" gibi bir koşul iki ayrı veriye dayanır: faaliyetin
     * tarihi ve adayın doçentlik tarihi. İkincisi eksikse faaliyet tarihlerini
     * tamamlamak koşulu çözmez — bu yüzden ayrı söylenir.
     */
    public function donemReferansEksik(?string $baslangic): ?string
    {
        if ($baslangic === null || $this->referansTarih($baslangic) !== null) {
            return null;
        }

        $etiket = match ($baslangic) {
            'doktora' => 'doktora',
            'docentlik' => 'doçentlik',
            'son_atama' => 'son atama',
            'lisans' => 'lisans',
            default => $baslangic,
        };

        return "Profilinizde {$etiket} tarihi girilmemiş";
    }

    public function metrikTanimli(string $ad): bool
    {
        return in_array($ad, [
            'yds', 'h_indeksi', 'atif_sayisi', 'ders_yariyil', 'yurtdisi_ay',
            'tez_danismanlik', 'tez_es_danismanlik', 'doktora_tez_danismanlik',
            'proje_yurutuculuk', 'proje_arastirmaci', 'proje_danisman',
        ], true);
    }
}
