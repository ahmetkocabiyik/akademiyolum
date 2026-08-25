<?php

/**
 * İBN HALDUN ÜNİVERSİTESİ — Öğretim Üyeleri Yükseltilme ve Atanma Koşulları
 * Kaynak: pdf/17537098452.ibnhaldununiversitesi.pdf
 *
 * ÜÇ FAKÜLTE GRUBU:
 *   1) İTBF (İnsan ve Toplum Bilimleri), YBF (Yönetim Bilimleri),
 *      EBF (Eğitim Bilimleri), MEDİT (Medeniyetler İttifakı Enstitüsü)
 *   2) MTGF (Mimarlık, Tasarım ve Güzel Sanatlar), İF (İletişim)
 *   3) HF (Hukuk), İİF (İslami İlimler)
 *
 * GRUP 1 VE 2'NİN SAYILARI AYNI, FARK CETVELDE: ikisi de doçentlikte 75 puan
 * / 3 yayın / 150 toplam istiyor. Ayrım şu ki grup 2 bu barajları SANATSAL
 * faaliyetlerle de doldurabiliyor — yönerge onların koşulunu "(1.1) ve/veya
 * (2.1)" diye yazıyor ve puan tablosunda 2.x satırları yalnızca o sütunda
 * puanlı, ötekinde "GD (Geçerli Değil)". Bu yüzden iki ayrı cetvel var.
 *
 * ── İLETİŞİM FAKÜLTESİ `birim` İLE AYRILDI ──
 * İletişim de İTBF/YBF/MEDİT de `sosyal` temel alanına düşüyor ama farklı
 * gruplarda. Grup 1 varsayılan (birim boş), İletişim `birim` ile ayrıldı.
 * Birimini seçmeyen İletişim adayı grup 1 eşiğini görür: sanatsal
 * faaliyetleri sayılmaz, yani puanı DÜŞÜK çıkar — adayı fazla hazır
 * göstermeyen taraf.
 *
 * ── "YARDIMCI DOÇENTLİK" = DR. ÖĞRETİM ÜYESİ ──
 * B bölümü 2018 öncesi adlandırmayı kullanıyor. İki satır var ve ilginç
 * biçimde HUKUK/İSLAMİ İLİMLER DAHA YÜKSEK puan istiyor (40 ↔ 30) ama daha
 * geniş bir kümeden (uluslararası + ulusal yayın); diğer disiplinler 30 puanı
 * yalnızca ULUSLARARASI kalemlerden toplamak zorunda.
 *
 * ── TEZ KOŞULU BEYAN ──
 * "Tamamlanmış lisansüstü tez danışmanlığı sayısı 3 / 6" satırının dipnotu:
 * "Bölümde yeterli sayıda tez öğrencisi olmaması durumunda bu koşul
 * aranmayabilir." Muafiyetin bölüme bağlı olması koşulu adayın kendi
 * kaydından karara bağlanamaz hâle getiriyor; sayı düğümü girildi ama
 * muafiyet aday notunda anlatıldı.
 *
 * ── ÖĞRETİM DENEYİMİ ──
 * "Başvurudan önceki üniversite öğretim deneyimi 2 / 4 yarıyıl" profildeki
 * `ders_yariyil` ölçütüne bağlandı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   C bölümü (İngilizce seminer): "adaydan tümüyle İngilizce olarak bir
 *       seminer vermesi istenir ve başarılı bulunması gerekir" — jüri kararı,
 *       beyan olarak girildi. Sayısal bir dil barajı yönergede YOK; YÖK
 *       yönetmeliğine atıf yapıyor, uydurulmadı.
 *   Dipnot b: doktorasını yurt dışında tanınmış bir üniversiteden son iki yıl
 *       içinde almış adaylardan Dr. puan koşulu aranmıyor — muafiyet yolu.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/ibn-haldun-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;

$seminer = Kalip::beyan(
    'Tümüyle İngilizce bir seminer verip başarılı bulunmak (daha önce verdiyseniz tekrar '
    .'istenmiyor)',
    'C bölümü',
);

$tezNotu = 'Tez danışmanlığı koşulu, bölümünüzde yeterli sayıda tez öğrencisi yoksa '
    .'aranmayabiliyor (yönergenin dipnotu); burada her hâlükârda gösteriliyor.';

/**
 * Doçent ve profesörlükte tekrarlayan gövde.
 *
 * @param  list<string>  $alanlar
 * @return array<string, mixed>
 */
$esik = function (string $anahtar, string $ad, array $alanlar, ?string $birim, string $cetvel,
    string $kadro, int $ulusPuan, int $ulusPay, int $yayin, int $tez, int $yariyil,
    int $toplam, int $toplamPay, string $ulusKume, string $yayinKume, string $toplamKume) use ($DOKTORA, $DOCENTLIK, $seminer, $tezNotu): array {
    $donem = $kadro === 'docentlik' ? $DOKTORA : $DOCENTLIK;
    $donemAd = $kadro === 'docentlik' ? 'doktora' : 'doçentlik';
    $donemBas = $kadro === 'docentlik' ? 'Doktora' : 'Doçentlik';
    $kadroAd = $kadro === 'docentlik' ? 'Doçent' : 'Profesör';

    return [
        'anahtar' => $anahtar,
        'aday_notu' => "{$ad} grubunda {$kadroAd} kadrosu için dört ayrı kapı var: "
            ."uluslararası etkinliklerden {$ulusPuan} puan (en az {$ulusPay}'i {$donemAd} "
            ."sonrası), {$yayin} uluslararası yayın, {$tez} tamamlanmış tez danışmanlığı ve "
            ."toplam {$toplam} puan (en az {$toplamPay}'i {$donemAd} sonrası). ".$tezNotu,
        'universite' => 'İbn Haldun Üniversitesi',
        'kadro' => $kadro,
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => $cetvel,
        'notlar' => "A bölümü, {$ad} tablosu, {$kadroAd} sütunu: uluslararası {$ulusPuan} "
            ."({$ulusPay} {$donemAd} sonrası), yayın sayısı {$yayin}, tez {$tez}, öğretim "
            ."deneyimi {$yariyil} yarıyıl, toplam {$toplam} ({$toplamPay} {$donemAd} sonrası).",
        'sart' => Kalip::ve("{$kadroAd} kadrosuna atanma — {$ad}", [
            Kalip::beyan(
                $kadro === 'docentlik'
                    ? 'Üniversitelerarası Kurul\'dan doçentlik unvanını almış olmak'
                    : 'Doçentlik unvanına sahip olmak',
                'A bölümü',
            ),
            $seminer,
            Kalip::puanDan("Uluslararası etkinliklerinizden en az {$ulusPuan} puan", [$ulusKume], $ulusPuan, madde: 'A bölümü'),
            Kalip::puanDan("Bunun en az {$ulusPay} puanı {$donemAd} sonrası olmalı", [$ulusKume], $ulusPay, $donem, madde: 'A bölümü'),
            Kalip::adet("{$donemBas} sonrası en az {$yayin} uluslararası yayın", [$yayinKume], $yayin, donem: $donem, madde: 'A bölümü'),
            Kalip::adet("Tamamlanmış en az {$tez} lisansüstü tez danışmanlığı", ['TEZ'], $tez, madde: 'A bölümü'),
            Kalip::metrik("Başvurudan önce en az {$yariyil} yarıyıl üniversitede ders vermiş olmak", 'ders_yariyil', $yariyil),
            Kalip::toplam($toplam, maddeler: [$toplamKume]),
            Kalip::toplam($toplamPay, $donem, [$toplamKume]),
        ]),
    ];
};

return [
    // ══════════════════ DR. ÖĞRETİM ÜYESİ (B bölümü) ══════════════════
    [
        'anahtar' => 'ibn-haldun-dr',
        'aday_notu' => 'Tek koşul: uluslararası kalemlerden 30 puan. Tek bir Q1 makale '
            .'(35 puan) yetiyor. Yönerge dönem kısıtı koymuyor.',
        'universite' => 'İbn Haldun Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['sosyal', 'egitim'],
        'cetvel' => 'ibn-haldun-2024',
        'notlar' => 'B bölümü: "Hukuk ve İslami İlimler hariç tüm disiplinler — (1.1) ve/veya '
            .'(2.1) türü etkinliklerden 30 puan." Sanatsal kalemler bu grupta geçerli değil, '
            .'yalnızca 1.1 kümesi kaldı.',
        'sart' => Kalip::ve('Dr. Öğr. Üyeliğine atanma', [
            $seminer,
            Kalip::puanDan('Uluslararası etkinliklerinizden en az 30 puan', ['1.1'], 30, madde: 'B bölümü'),
        ]),
    ],
    [
        'anahtar' => 'ibn-haldun-dr-sanat',
        'aday_notu' => 'Mimarlık, Tasarım, Güzel Sanatlar ve İletişim adayları 30 puanı '
            .'sanatsal faaliyetlerden de toplayabiliyor.',
        'universite' => 'İbn Haldun Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['mimarlik', 'guzel_sanatlar'],
        'cetvel' => 'ibn-haldun-2024-sanat',
        'notlar' => 'B bölümü: "(1.1) ve/veya (2.1) türü etkinliklerden 30 puan." Bu grupta '
            .'sanatsal kalemler puanlı.',
        'sart' => Kalip::ve('Dr. Öğr. Üyeliğine atanma — Mimarlık, Tasarım ve Güzel Sanatlar', [
            $seminer,
            Kalip::puanDan('Uluslararası yayın ve sanat etkinliklerinizden en az 30 puan', ['1.1-2.1'], 30, madde: 'B bölümü'),
        ]),
    ],
    [
        'anahtar' => 'ibn-haldun-dr-iletisim',
        'aday_notu' => 'İletişim Fakültesi adayları 30 puanı sanatsal faaliyetlerden de '
            .'toplayabiliyor. Biriminizi seçmezseniz sanatsal kalemleriniz sayılmaz.',
        'universite' => 'İbn Haldun Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['sosyal'],
        'birim' => 'İletişim Fakültesi',
        'cetvel' => 'ibn-haldun-2024-sanat',
        'notlar' => 'B bölümü, İletişim Fakültesi MTGF ile aynı grupta. `sosyal` temel alanı '
            .'İTBF/YBF/MEDİT ile paylaştığı için birim ayrımı gerekti.',
        'sart' => Kalip::ve('Dr. Öğr. Üyeliğine atanma — İletişim Fakültesi', [
            $seminer,
            Kalip::puanDan('Uluslararası yayın ve sanat etkinliklerinizden en az 30 puan', ['1.1-2.1'], 30, madde: 'B bölümü'),
        ]),
    ],
    [
        'anahtar' => 'ibn-haldun-dr-hukuk',
        'aday_notu' => 'Hukuk ve İslami İlimlerde baraj daha yüksek (40 puan) ama kümesi daha '
            .'geniş: ulusal yayınlarınız da sayılıyor. Diğer disiplinlerde 30 puanın tamamı '
            .'uluslararası kalemlerden gelmek zorunda.',
        'universite' => 'İbn Haldun Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['hukuk', 'ilahiyat'],
        'cetvel' => 'ibn-haldun-2024',
        'notlar' => 'B bölümü: "Hukuk ve İslami İlimler — (1.1) ve/veya (1.2) türü '
            .'etkinliklerden 40 puan."',
        'sart' => Kalip::ve('Dr. Öğr. Üyeliğine atanma — Hukuk ve İslami İlimler', [
            $seminer,
            Kalip::puanDan('Uluslararası ve ulusal yayınlarınızdan en az 40 puan', ['TOPLAM-1'], 40, madde: 'B bölümü'),
        ]),
    ],

    // ══════════════════ DOÇENT ══════════════════
    $esik('ibn-haldun-docent', 'İnsan ve Toplum, Yönetim, Eğitim Bilimleri',
        ['sosyal', 'egitim'], null, 'ibn-haldun-2024',
        'docentlik', 75, 45, 3, 3, 2, 150, 75, '1.1', '1.1.1', 'TOPLAM-1'),
    $esik('ibn-haldun-docent-sanat', 'Mimarlık, Tasarım ve Güzel Sanatlar',
        ['mimarlik', 'guzel_sanatlar'], null, 'ibn-haldun-2024-sanat',
        'docentlik', 75, 45, 3, 3, 2, 150, 75, '1.1-2.1', '1.1.1-2.1.1', 'TOPLAM-1-2'),
    $esik('ibn-haldun-docent-iletisim', 'İletişim Fakültesi',
        ['sosyal'], 'İletişim Fakültesi', 'ibn-haldun-2024-sanat',
        'docentlik', 75, 45, 3, 3, 2, 150, 75, '1.1-2.1', '1.1.1-2.1.1', 'TOPLAM-1-2'),
    $esik('ibn-haldun-docent-hukuk', 'Hukuk ve İslami İlimler',
        ['hukuk', 'ilahiyat'], null, 'ibn-haldun-2024',
        'docentlik', 50, 25, 2, 3, 2, 150, 75, '1.1', '1.1.1', 'TOPLAM-1'),

    // ══════════════════ PROFESÖR ══════════════════
    $esik('ibn-haldun-profesor', 'İnsan ve Toplum, Yönetim, Eğitim Bilimleri',
        ['sosyal', 'egitim'], null, 'ibn-haldun-2024',
        'profesorluk', 120, 60, 4, 6, 4, 250, 125, '1.1', '1.1.1', 'TOPLAM-1'),
    $esik('ibn-haldun-profesor-sanat', 'Mimarlık, Tasarım ve Güzel Sanatlar',
        ['mimarlik', 'guzel_sanatlar'], null, 'ibn-haldun-2024-sanat',
        'profesorluk', 120, 60, 4, 6, 4, 250, 125, '1.1-2.1', '1.1.1-2.1.1', 'TOPLAM-1-2'),
    $esik('ibn-haldun-profesor-iletisim', 'İletişim Fakültesi',
        ['sosyal'], 'İletişim Fakültesi', 'ibn-haldun-2024-sanat',
        'profesorluk', 120, 60, 4, 6, 4, 250, 125, '1.1-2.1', '1.1.1-2.1.1', 'TOPLAM-1-2'),
    $esik('ibn-haldun-profesor-hukuk', 'Hukuk ve İslami İlimler',
        ['hukuk', 'ilahiyat'], null, 'ibn-haldun-2024',
        'profesorluk', 80, 40, 3, 6, 4, 250, 125, '1.1', '1.1.1', 'TOPLAM-1'),
];
