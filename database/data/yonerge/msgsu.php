<?php

/**
 * MİMAR SİNAN GÜZEL SANATLAR ÜNİVERSİTESİ — Akademik Yükseltilme, İlk
 * Atanma ve Yeniden Atanma Ölçütleri Yönergesi
 * Kaynak: pdf/17537004062.mimarsinanguzelsanatlaruniverstesi.pdf
 * (59 sayfa)
 *
 * ── YAPI: EK 3 KOŞULLARI BİLİM ALANI BAZINDA ──
 * Tek puan tablosu (EK 1) var; koşullar EK 3'te FAKÜLTE ve BİLİM ALANI
 * kırılımında veriliyor. Toplam puanlar bütün alanlarda aynı (Dr. ilk
 * 100, yeniden 50, doçent 200, profesör 300); değişen tek şey EK
 * KOŞULLARIN hangi bölümden ne kadar puan istediği. Metinden dokuz ayrı
 * kural seti çıkıyor:
 *   A  Fizik                    1.2.1 odaklı
 *   B  İstatistik               1.1 ve/veya 1.2 odaklı, düşük barajlı
 *   C  Matematik                1.2 odaklı, başlıca yazar koşullu
 *   D  Sosyal-beşerî alanlar ve laboratuvar bilimleri
 *                              1.1/1.2 odaklı, TEK YAZARLI eser koşullu
 *   E  Güzel Sanatlar           1. ve 2. kısım birlikte, 2. ağırlıklı
 *   E2 Rektörlük birimleri      E'nin daha düşük barajlı biçimi
 *   F  Mimarlık ve tasarım      1.2 odaklı
 *   G  Tekstil                  1.1/1.2 odaklı
 *   H  Devlet Konservatuvarı    1. ve/veya 2. kısım
 * Aynı temel alanda birden çok kural seti bulunduğu için (örneğin `fen`
 * altında Fizik, İstatistik, Matematik ve Kimya) eşikler `birim` alanıyla
 * ayrıldı; aday hangi bilim alanına başvurduğunu seçtiğinde doğru eşik
 * geliyor.
 *
 * ── "SON BİR YIL" VE "SON ATANMADAN SONRA" BİRLİKTE ──
 * Yeniden atanma sütununun başlığı "Yeniden Atanma (Son bir yıl)", ek
 * koşul ise "son atanmadan sonra" diyor. İkisi de yazıldı: toplam 50 puan
 * SON BİR YIL penceresinde, ek koşulun puanı SON ATAMADAN SONRA.
 *
 * ── YABANCI DİL ──
 * Madde 16: doktor öğretim üyesi 60, doçent 65, profesör 70 puan.
 * Geçici Madde 1 bu hükmü 1/1/2024'ten itibaren ilan edilen kadrolara
 * bağlıyor; bugün için yürürlükte.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde 13: daha önce hiç ders vermemiş adaylardan istenen DENEME
 *       DERSİ — süreç kuralı.
 *   Konservatuvar Müzik bilim/sanat alanının "İDK Ek Açıklama" tablosu
 *       (Piyano/Yaylı/Üflemeli, Arp-Gitar, Opera ve Tiyatro programları
 *       için ayrı ayrı tanımlanmış 2.8.1/2.8.4 puanları, başrol ve
 *       konser sayıları): çalgı programı profilde tutulmuyor,
 *       `hesaplanamiyor`.
 *   Madde 14(3): koşulları sağlayamayanlara bir defaya mahsus bir yıllık
 *       yeniden atama; madde 14(4): mücbir sebep ve ücretsiz izin
 *       durumunda ek süre.
 *   Madde 11(9) ve 14(5): etik soruşturma sürerken değerlendirmenin
 *       askıya alınması.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/msgsu-2023.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Mimar Sinan Güzel Sanatlar Üniversitesi';
$CETVEL = 'msgsu-2023';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;
$SON_YIL = Kalip::sonYil(1);

$doktora = Kalip::beyan('Doktora ya da sanatta yeterlik unvanı almış olmak', '7');
$docentUnvani = Kalip::beyan('Doçentlik unvanını almış olmak', '7');
$besYil = Kalip::beyan(
    '2547 sayılı Kanunun 26. maddesi uyarınca doçentlik unvanını aldıktan sonra gerekli süreyi '
    .'tamamlamış olmak',
    '7',
);

/**
 * Bir kural setinin dört kadrosunu üretir.
 *
 * @param  list<string>  $alanlar
 * @param  array{dr: list<array<string, mixed>>, yeniden: list<array<string, mixed>>, docent: list<array<string, mixed>>, profesor: list<array<string, mixed>>, notlar: array<string, string>}  $set
 * @return list<array<string, mixed>>
 */
$esikleriUret = function (
    string $anahtar,
    array $alanlar,
    ?string $birim,
    string $ad,
    array $set,
) use ($UNIVERSITE, $CETVEL, $SON_YIL, $doktora, $docentUnvani, $besYil): array {
    $ortak = [
        'universite' => $UNIVERSITE,
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => $CETVEL,
    ];

    $notu = fn (string $kadro): string => "{$ad} — {$kadro}. Yönergenin bütün "
        .'birimlerinde toplam puan aynı: doktor öğretim üyeliğine ilk atanmada 100, yeniden '
        .'atanmada son bir yıl için 50, doçentlikte 200, profesörlükte 300 puan. Değişen tek '
        .'şey ek koşulların hangi bölümden ne kadar puan istediği.';

    return [
        array_merge($ortak, [
            'anahtar' => "msgsu-{$anahtar}-dr",
            'kadro' => 'dr_ogr_uyesi',
            'aday_notu' => $notu('ilk atanma').' '.$set['notlar']['dr'],
            'notlar' => "EK 3 ({$ad}): Dr. Öğretim Üyesi ilk atanma; toplam 100 puan.",
            'sart' => Kalip::ve("Doktor Öğretim Üyesi kadrosuna ilk atanma — {$ad}", array_values(array_merge(
                [$doktora, Kalip::yds(60)],
                $set['dr'],
                [Kalip::toplam(100)],
            ))),
        ]),
        array_merge($ortak, [
            'anahtar' => "msgsu-{$anahtar}-dr-yeniden",
            'kadro' => 'dr_ogr_uyesi_yeniden',
            'aday_notu' => $notu('yeniden atanma').' '.$set['notlar']['yeniden']
                .' Koşulları sağlayamazsanız her akademik kadro düzeyi için bir defaya mahsus '
                .'bir yıllık yeniden atama yapılabiliyor.',
            'notlar' => "EK 3 ({$ad}): Dr. Öğretim Üyesi yeniden atanma; son bir yılda toplam 50 puan.",
            'sart' => Kalip::ve("Doktor Öğretim Üyesi kadrosuna yeniden atanma — {$ad}", array_values(array_merge(
                $set['yeniden'],
                [Kalip::toplam(50, $SON_YIL)],
            ))),
        ]),
        array_merge($ortak, [
            'anahtar' => "msgsu-{$anahtar}-docentlik",
            'kadro' => 'docentlik',
            'aday_notu' => $notu('doçentlik').' '.$set['notlar']['docent'],
            'notlar' => "EK 3 ({$ad}): Doçent; toplam 200 puan.",
            'sart' => Kalip::ve("Doçent kadrosuna atanma — {$ad}", array_values(array_merge(
                [$docentUnvani, Kalip::yds(65)],
                $set['docent'],
                [Kalip::toplam(200)],
            ))),
        ]),
        array_merge($ortak, [
            'anahtar' => "msgsu-{$anahtar}-profesorluk",
            'kadro' => 'profesorluk',
            'aday_notu' => $notu('profesörlük').' '.$set['notlar']['profesor'],
            'notlar' => "EK 3 ({$ad}): Profesör; toplam 300 puan.",
            'sart' => Kalip::ve("Profesör kadrosuna yükseltilme ve atanma — {$ad}", array_values(array_merge(
                [$besYil, Kalip::yds(70)],
                $set['profesor'],
                [Kalip::toplam(300)],
            ))),
        ]),
    ];
};

/** Yeniden atanmanın yaygın ek koşulu: 1. veya 6.1 kısmından 20 puan. */
$yeniden1ve61 = [Kalip::puanDan(
    'Son atanmanızdan sonra bilimsel ve sanatsal yayınlarınızdan ya da araştırma projelerinizden en az 20 puan',
    ['1', '6.1'], 20, $SON_ATAMA, madde: 'EK 3',
)];

/** Mimarlık ve tekstil alanlarının yeniden atanma koşulu: 1., 6.1 veya 5. kısım. */
$yeniden1615 = [Kalip::puanDan(
    'Son atanmanızdan sonra bilimsel ve sanatsal yayınlarınız, araştırma projeleriniz '
    .'ya da aldığınız ödüllerden en az 20 puan',
    ['1', '6.1', '5'], 20, $SON_ATAMA, madde: 'EK 3',
)];

$setler = [
    'A' => [
        'dr' => [Kalip::puanDan('SCI, SCI-Expanded, SSCI ya da AHCI dergilerindeki makalelerinizden en az 30 puan', ['1.2.1'], 30, madde: 'EK 3')],
        'yeniden' => $yeniden1ve61,
        'docent' => [
            Kalip::puanDan('Doktora unvanınızı aldıktan sonra SCI, SCI-Expanded, SSCI ya da AHCI dergilerindeki makalelerinizden en az 60 puan', ['1.2.1'], 60, $DOKTORA, madde: 'EK 3'),
            Kalip::puanDan('SCI, SCI-Expanded, SSCI ya da AHCI makalelerinizden toplam en az 100 puan', ['1.2.1'], 100, madde: 'EK 3'),
        ],
        'profesor' => [
            Kalip::puanDan('Doçentlik unvanınızı aldıktan sonra SCI, SCI-Expanded, SSCI ya da AHCI makalelerinizden en az 60 puan', ['1.2.1'], 60, $DOCENTLIK, madde: 'EK 3'),
            Kalip::puanDan('Bilimsel ve sanatsal yayınlarınızdan toplam en az 200 puan', ['1'], 200, madde: 'EK 3'),
        ],
        'notlar' => [
            'dr' => 'Ek koşul: SCI, SCI-Expanded, SSCI ya da AHCI dergilerindeki makalelerinizden en az 30 puan.',
            'yeniden' => 'Ek koşul: son atanmanızdan sonra yayınlarınızdan ya da araştırma projelerinizden en az 20 puan.',
            'docent' => 'Ek koşul: SCI, SCI-Expanded, SSCI ya da AHCI makalelerinizden, en az 60 puanı doktora sonrası olmak üzere, toplam en az 100 puan.',
            'profesor' => 'Ek koşul: SCI, SCI-Expanded, SSCI ya da AHCI makalelerinizden en az 60 puanı doçentlik sonrası olmak üzere, yayınlarınızdan toplam en az 200 puan.',
        ],
    ],
    'B' => [
        'dr' => [Kalip::puanDan('Kitap ve makale kalemlerinizden en az 20 puan', ['1.1', '1.2'], 20, madde: 'EK 3')],
        'yeniden' => $yeniden1ve61,
        'docent' => [
            Kalip::puanDan('Doktora unvanınızı aldıktan sonra kitap ve makale kalemlerinizden en az 30 puan', ['1.1', '1.2'], 30, $DOKTORA, madde: 'EK 3'),
            Kalip::puanDan('Kitap ve makale kalemlerinizden toplam en az 50 puan', ['1.1', '1.2'], 50, madde: 'EK 3'),
        ],
        'profesor' => [
            Kalip::puanDan('Doçentlik unvanınızı aldıktan sonra kitap ve makale kalemlerinizden en az 50 puan', ['1.1', '1.2'], 50, $DOCENTLIK, madde: 'EK 3'),
            Kalip::puanDan('yayınlarınızdan toplam en az 100 puan', ['1'], 100, madde: 'EK 3'),
        ],
        'notlar' => [
            'dr' => 'Ek koşul: kitap ve makale kalemlerinizden en az 20 puan.',
            'yeniden' => 'Ek koşul: son atanmanızdan sonra yayınlarınızdan ya da araştırma projelerinizden en az 20 puan.',
            'docent' => 'Ek koşul: kitap ve makale kalemlerinizden, en az 30 puanı doktora sonrası olmak üzere, toplam en az 50 puan.',
            'profesor' => 'Ek koşul: kitap ve makale kalemlerinizden en az 50 puanı doçentlik sonrası olmak üzere yayınlarınızdan toplam en az 100 puan.',
        ],
    ],
    'C' => [
        'dr' => [Kalip::puanDan('makale kalemlerinizden en az 20 puan', ['1.2'], 20, madde: 'EK 3')],
        'yeniden' => $yeniden1ve61,
        'docent' => [
            Kalip::puanDan('Doktora unvanınızı aldıktan sonra makale kalemlerinizden en az 50 puan', ['1.2'], 50, $DOKTORA, madde: 'EK 3'),
            Kalip::puanDan('makale kalemlerinizden toplam en az 70 puan', ['1.2'], 70, madde: 'EK 3'),
            Kalip::adet('Bu bölümlerdeki yayınlardan en az birinin başlıca yazarı olmak', ['1.2'], 1, yazar: 'baslica', madde: 'EK 3'),
        ],
        'profesor' => [
            Kalip::puanDan('Doçentlik unvanınızı aldıktan sonra makale kalemlerinizden en az 50 puan', ['1.2'], 50, $DOCENTLIK, madde: 'EK 3'),
            Kalip::puanDan('yayınlarınızdan toplam en az 120 puan', ['1'], 120, madde: 'EK 3'),
        ],
        'notlar' => [
            'dr' => 'Ek koşul: makale kalemlerinizden en az 20 puan.',
            'yeniden' => 'Ek koşul: son atanmanızdan sonra yayınlarınızdan ya da araştırma projelerinizden en az 20 puan.',
            'docent' => 'Ek koşul: makale kalemlerinizden en az 50 puanı doktora sonrası olmak üzere toplam en az 70 puan ve bu yayınlardan en az birinin başlıca yazarı olmak.',
            'profesor' => 'Ek koşul: makale kalemlerinizden en az 50 puanı doçentlik sonrası olmak üzere yayınlarınızdan toplam en az 120 puan.',
        ],
    ],
    'D' => [
        'dr' => [
            Kalip::puanDan('Kitap ve makale kalemlerinizden en az 30 puan', ['1.1', '1.2'], 30, madde: 'EK 3'),
            Kalip::adet('Bu bölümlerdeki yayınlardan en az birinin tek başına yapılmış olması', ['1.1', '1.2'], 1, yazar: 'tek', madde: 'EK 3'),
        ],
        'yeniden' => $yeniden1ve61,
        'docent' => [
            Kalip::puanDan('Doktora unvanınızı aldıktan sonra kitap ve makale kalemlerinizden en az 40 puan', ['1.1', '1.2'], 40, $DOKTORA, madde: 'EK 3'),
            Kalip::puanDan('Kitap ve makale kalemlerinizden toplam en az 50 puan', ['1.1', '1.2'], 50, madde: 'EK 3'),
            Kalip::adet('Bu bölümlerdeki yayınlardan en az birinin tek başına yapılmış olması', ['1.1', '1.2'], 1, yazar: 'tek', madde: 'EK 3'),
        ],
        'profesor' => [
            Kalip::puanDan('Doçentlik unvanınızı aldıktan sonra kitap ve makale kalemlerinizden en az 60 puan', ['1.1', '1.2'], 60, $DOCENTLIK, madde: 'EK 3'),
            Kalip::puanDan('kitap ve makale kalemlerinizden toplam en az 100 puan', ['1.1', '1.2'], 100, madde: 'EK 3'),
            Kalip::adet('Bu bölümlerdeki yayınlardan en az birinin tek başına yapılmış olması', ['1.1', '1.2'], 1, yazar: 'tek', madde: 'EK 3'),
        ],
        'notlar' => [
            'dr' => 'Ek koşul: kitap ve makale kalemlerinizden en az 30 puan ve bu yayınlardan en az birinin TEK BAŞINA yapılmış olması.',
            'yeniden' => 'Ek koşul: son atanmanızdan sonra yayınlarınızdan ya da araştırma projelerinizden en az 20 puan.',
            'docent' => 'Ek koşul: kitap ve makale kalemlerinizden en az 40 puanı doktora sonrası olmak üzere toplam en az 50 puan ve en az bir tek yazarlı yayın.',
            'profesor' => 'Ek koşul: kitap ve makale kalemlerinizden en az 60 puanı doçentlik sonrası olmak üzere toplam en az 100 puan ve en az bir tek yazarlı yayın.',
        ],
    ],
    'E' => [
        'dr' => [
            Kalip::puanDan('1. kısımdan (bilimsel ve sanatsal yayınlar) en az 25 puan', ['1'], 25, madde: 'EK 3'),
            Kalip::puanDan('2. kısımdan (sanat ve tasarım etkinlikleri) en az 50 puan', ['2'], 50, madde: 'EK 3'),
        ],
        'yeniden' => [Kalip::puanDan('Son atanmanızdan sonra 1. kısımdan en az 15 puan', ['1'], 15, $SON_ATAMA, madde: 'EK 3')],
        'docent' => [
            Kalip::puanDan('Sanatta yeterlik ya da doktora unvanınızı aldıktan sonra 2. kısımdan en az 60 puan', ['2'], 60, $DOKTORA, madde: 'EK 3'),
            Kalip::puanDan('1. ve/veya 2. kısımdan toplam en az 110 puan', ['1', '2'], 110, madde: 'EK 3'),
        ],
        'profesor' => [
            Kalip::puanDan('Doçentlik unvanınızı aldıktan sonra 2. kısımdan en az 60 puan', ['2'], 60, $DOCENTLIK, madde: 'EK 3'),
            Kalip::puanDan('1. ve/veya 2. kısımdan toplam en az 170 puan', ['1', '2'], 170, madde: 'EK 3'),
        ],
        'notlar' => [
            'dr' => 'Ek koşul: 1. kısımdan en az 25 ve 2. kısımdan en az 50 puan.',
            'yeniden' => 'Ek koşul: son atanmanızdan sonra 1. kısımdan en az 15 puan.',
            'docent' => 'Ek koşul: 2. kısımdan en az 60 puanı sanatta yeterlik/doktora sonrası olmak üzere 1. ve/veya 2. kısımdan toplam en az 110 puan.',
            'profesor' => 'Ek koşul: 2. kısımdan en az 60 puanı doçentlik sonrası olmak üzere 1. ve/veya 2. kısımdan toplam en az 170 puan.',
        ],
    ],
    'E2' => [
        'dr' => [
            Kalip::puanDan('1. kısımdan en az 10 puan', ['1'], 10, madde: 'EK 3'),
            Kalip::puanDan('2. kısımdan en az 40 puan', ['2'], 40, madde: 'EK 3'),
        ],
        'yeniden' => [Kalip::puanDan('Son atanmanızdan sonra 1. kısımdan en az 10 puan', ['1'], 10, $SON_ATAMA, madde: 'EK 3')],
        'docent' => [
            Kalip::puanDan('Doktora ya da sanatta yeterlik unvanınızı aldıktan sonra 1. ve/veya 2. kısımdan en az 60 puan', ['1', '2'], 60, $DOKTORA, madde: 'EK 3'),
            Kalip::puanDan('2. kısımdan toplam en az 110 puan', ['2'], 110, madde: 'EK 3'),
        ],
        'profesor' => [
            Kalip::puanDan('Doçentlik unvanınızı aldıktan sonra 1. kısımdan en az 60 puan', ['1'], 60, $DOCENTLIK, madde: 'EK 3'),
            Kalip::puanDan('1. ve/veya 2. kısımdan toplam en az 170 puan', ['1', '2'], 170, madde: 'EK 3'),
        ],
        'notlar' => [
            'dr' => 'Ek koşul: 1. kısımdan en az 10 ve 2. kısımdan en az 40 puan.',
            'yeniden' => 'Ek koşul: son atanmanızdan sonra 1. kısımdan en az 10 puan.',
            'docent' => 'Ek koşul: 1. ve/veya 2. kısımdan en az 60 puanı doktora/sanatta yeterlik sonrası olmak üzere 2. kısımdan toplam en az 110 puan.',
            'profesor' => 'Ek koşul: 1. kısımdan en az 60 puanı doçentlik sonrası olmak üzere 1. ve/veya 2. kısımdan toplam en az 170 puan.',
        ],
    ],
    'F' => [
        'dr' => [Kalip::puanDan('makale kalemlerinizden en az 30 puan', ['1.2'], 30, madde: 'EK 3')],
        'yeniden' => $yeniden1615,
        'docent' => [
            Kalip::puanDan('Doktora unvanınızı aldıktan sonra makale kalemlerinizden en az 30 puan', ['1.2'], 30, $DOKTORA, madde: 'EK 3'),
            Kalip::puanDan('makale kalemlerinizden toplam en az 60 puan', ['1.2'], 60, madde: 'EK 3'),
        ],
        'profesor' => [
            Kalip::puanDan('Doçentlik unvanınızı aldıktan sonra makale kalemlerinizden en az 30 puan', ['1.2'], 30, $DOCENTLIK, madde: 'EK 3'),
            Kalip::puanDan('Doçentlik unvanınızı aldıktan sonra kitap ve makale kalemlerinizden en az 60 puan', ['1.1', '1.2'], 60, $DOCENTLIK, madde: 'EK 3'),
            Kalip::puanDan('kitap ve makale kalemlerinizden toplam en az 100 puan', ['1.1', '1.2'], 100, madde: 'EK 3'),
        ],
        'notlar' => [
            'dr' => 'Ek koşul: makale kalemlerinizden en az 30 puan.',
            'yeniden' => 'Ek koşul: son atanmanızdan sonra yayınlarınız, araştırma projeleriniz ya da ödüllerinizden en az 20 puan.',
            'docent' => 'Ek koşul: makale kalemlerinizden en az 30 puanı doktora sonrası olmak üzere toplam en az 60 puan.',
            'profesor' => 'Ek koşul: kitap ve makale kalemlerinizden en az 60 puanı doçentlik sonrası olmak üzere toplam en az 100 puan.',
        ],
    ],
    'G' => [
        'dr' => [Kalip::puanDan('kitap ve makale kalemlerinizden en az 30 puan', ['1.1', '1.2'], 30, madde: 'EK 3')],
        'yeniden' => $yeniden1615,
        'docent' => [
            Kalip::puanDan('Doktora unvanınızı aldıktan sonra kitap ve makale kalemlerinizden en az 30 puan', ['1.1', '1.2'], 30, $DOKTORA, madde: 'EK 3'),
            Kalip::puanDan('kitap ve makale kalemlerinizden toplam en az 60 puan', ['1.1', '1.2'], 60, madde: 'EK 3'),
        ],
        'profesor' => [
            Kalip::puanDan('Doçentlik unvanınızı aldıktan sonra kitap ve makale kalemlerinizden en az 60 puan', ['1.1', '1.2'], 60, $DOCENTLIK, madde: 'EK 3'),
            Kalip::puanDan('kitap ve makale kalemlerinizden toplam en az 100 puan', ['1.1', '1.2'], 100, madde: 'EK 3'),
        ],
        'notlar' => [
            'dr' => 'Ek koşul: kitap ve makale kalemlerinizden en az 30 puan.',
            'yeniden' => 'Ek koşul: son atanmanızdan sonra yayınlarınız, araştırma projeleriniz ya da ödüllerinizden en az 20 puan.',
            'docent' => 'Ek koşul: kitap ve makale kalemlerinizden en az 30 puanı doktora sonrası olmak üzere toplam en az 60 puan.',
            'profesor' => 'Ek koşul: kitap ve makale kalemlerinizden en az 60 puanı doçentlik sonrası olmak üzere toplam en az 100 puan.',
        ],
    ],
    'H' => [
        'dr' => [
            Kalip::puanDan('1. ve/veya 2. kısımlardan en az 30 puan (Müzikoloji alanında 1. kısımdan en az 50 puan)', ['1', '2'], 30, madde: 'EK 3'),
            Kalip::hesaplanamiyor(
                'Müzik bilim/sanat alanında İDK Ek Açıklama tablosunun program bazlı koşulları '
                .'(Piyano, yaylı, üflemeli ve vurmalı çalgılarda doktora sonrası farklı '
                .'programlarla solo resital ve konser kalemlerinden 40 puan; arp ve gitarda 20 puan; '
                .'operada iki başrol ya da iki solist konser; tiyatroda sahne etkinliklerinden 120 '
                .'puan) — çalgı programı profilde tutulmadığı için hesaplanamıyor',
                'EK 3 İDK',
            ),
        ],
        'yeniden' => [],
        'docent' => [
            Kalip::puanDan('Sanatta yeterlik unvanınızı aldıktan sonra 1. ve/veya 2. kısımlardan en az 30 puan', ['1', '2'], 30, $DOKTORA, madde: 'EK 3'),
            Kalip::puanDan('1. ve/veya 2. kısımlardan toplam en az 60 puan (Müzikoloji alanında 1. kısımdan en az 50 puan)', ['1', '2'], 60, madde: 'EK 3'),
        ],
        'profesor' => [
            Kalip::puanDan('Doçentlik unvanınızı aldıktan sonra 1. ve/veya 2. kısımlardan en az 50 puan', ['1', '2'], 50, $DOCENTLIK, madde: 'EK 3'),
            Kalip::puanDan('1. ve/veya 2. kısımlardan toplam en az 100 puan (Müzikoloji alanında 1. kısımdan en az 100 puan)', ['1', '2'], 100, madde: 'EK 3'),
        ],
        'notlar' => [
            'dr' => 'Ek koşul: 1. ve/veya 2. kısımlardan en az 30 puan. Müzikoloji alanında 1. kısımdan en az 50 puan; müzik bilim/sanat alanında ayrıca İDK Ek Açıklama tablosunun program bazlı koşulları geçerli (motor bunları hesaplayamıyor).',
            'yeniden' => 'Müzikoloji alanında ek koşul: 1. kısımdan en az 15 puan (motor bu alan ayrımını yapamadığı için yalnız toplam puan uygulanıyor).',
            'docent' => 'Ek koşul: 1. ve/veya 2. kısımlardan en az 30 puanı sanatta yeterlik sonrası olmak üzere toplam en az 60 puan.',
            'profesor' => 'Ek koşul: 1. ve/veya 2. kısımlardan en az 50 puanı doçentlik sonrası olmak üzere toplam en az 100 puan.',
        ],
    ],
];

$esikler = [];

foreach ([
    ['fizik', 'A', ['fen'], 'Fizik — Fen-Edebiyat Fakültesi ve Kültür Varlıklarını Koruma ve Onarımı Yüksekokulu'],
    ['istatistik', 'B', ['fen'], 'İstatistik — Fen-Edebiyat Fakültesi'],
    ['matematik', 'C', ['fen'], 'Matematik — Fen-Edebiyat Fakültesi'],
    ['kimya', 'D', ['fen'], 'Kimya ve Yer Bilimleri — Kültür Varlıklarını Koruma ve Onarımı Yüksekokulu'],
    ['muh-kvko', 'D', ['muhendislik'], 'Malzeme-Metalurji, Kimya ve Yer Bilimleri Mühendisliği — Kültür Varlıklarını Koruma ve Onarımı Yüksekokulu'],
    ['tekstil', 'G', ['muhendislik'], 'Tekstil Bilimleri ve Mühendisliği — Meslek Yüksekokulu'],
    ['orman', 'D', ['ziraat'], null],
    ['sosyal-fef', 'D', ['sosyal'], 'Fen-Edebiyat Fakültesi ve Kültür Varlıklarını Koruma ve Onarımı Yüksekokulu bilim alanları'],
    ['sosyal-myo', 'E', ['sosyal'], 'Sanat Tarihi ve Genel Türk Tarihi — Meslek Yüksekokulu'],
    ['egitim', 'D', ['egitim'], null],
    ['filoloji', 'D', ['filoloji'], null],
    ['mimarlik', 'F', ['mimarlik'], null],
    ['gsf', 'E', ['guzel_sanatlar'], 'Güzel Sanatlar Fakültesi ve Kültür Varlıklarını Koruma ve Onarımı Yüksekokulu'],
    ['gs-rektorluk', 'E2', ['guzel_sanatlar'], 'Rektörlük birimleri'],
    ['gs-myo', 'D', ['guzel_sanatlar'], 'Meslek Yüksekokulu'],
    ['konservatuvar', 'H', ['guzel_sanatlar'], 'İstanbul Devlet Konservatuvarı'],
] as [$anahtar, $set, $alanlar, $birim]) {
    $ad = $birim ?? 'Orman Endüstri Mühendisliği — Kültür Varlıklarını Koruma ve Onarımı Yüksekokulu';

    if ($anahtar === 'egitim') {
        $ad = 'Eğitim Bilimleri ile Rehberlik ve Psikolojik Danışmanlık — Fen-Edebiyat Fakültesi';
    } elseif ($anahtar === 'filoloji') {
        $ad = 'Dünya Dilleri ve Edebiyatları ile Türk Dili ve Edebiyatı — Fen-Edebiyat Fakültesi';
    } elseif ($anahtar === 'mimarlik') {
        $ad = 'Mimarlık, İç Mimarlık, Endüstri Ürünleri Tasarımı ile Şehir ve Bölge Planlama';
    }

    foreach ($esikleriUret($anahtar, $alanlar, $birim, $ad, $setler[$set]) as $esik) {
        $esikler[] = $esik;
    }
}

return $esikler;
