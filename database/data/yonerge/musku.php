<?php

/**
 * MUĞLA SITKI KOÇMAN ÜNİVERSİTESİ — Öğretim Üyeliği Kadrolarına
 * Başvurma, Atama ve Yükseltilme Yönergesi
 * Kaynak: pdf/17537004412.muglasitkikocmanuniverstesi.pdf
 * (24 sayfa; yürürlük 01.01.2013, değişiklikler 15.01.2014-488/15 ve
 * 15.04.2015-506/1 Senato kararları)
 *
 * ── YAPI: DÖRT ALAN GRUBU, DÖRT MADDE ──
 * Koşullar madde 6-9'da alan grubu başına ayrı yazılmış; EK-1'in puan
 * sütunu da aynı dört gruba bölünmüş:
 *   MADDE 6 · Temel bilimler, mühendislik, su ürünleri ve teknoloji
 *       → `fen`, `muhendislik`, `ziraat` · cetvel `musku-2013-fen`
 *   MADDE 7 · Güzel sanatlar fakültesi ve güzel sanatlar eğitimi
 *       → `guzel_sanatlar` · cetvel `musku-2013-gsf`
 *   MADDE 8 · Tıp ve sağlık bilimleri
 *       → `saglik` · cetvel `musku-2013-saglik`
 *   MADDE 9 · Sosyal bilimler, eğitim bilimleri ve öğretmen yetiştirme
 *       → `sosyal`, `egitim`, `filoloji`, `spor` · `musku-2013-sosyal`
 *
 * ── EŞİK YAZILMAYAN ALANLAR ──
 * Yönerge hukuk, ilahiyat ve mimarlık temel alanlarını anmıyor;
 * üniversitede bu alanlarda fakülte de yok. Bu üç alan için eşik
 * yazılmadı.
 *
 * ── PROFESÖRLÜKTE BÖLÜM BAZLI MAKALE KOŞULU ──
 * Madde 6(3)-c fen grubunu ikiye ayırıyor: Biyoloji, Fizik, Kimya, Su
 * Ürünleri, Mühendislik ve Teknoloji Fakültesi için A-1 dergilerinde en
 * az İKİ makale; Matematik ve İstatistik bölümleri için en az BİR
 * makale. Ayrım temel alan değil BÖLÜM olduğu için `fen` altında iki
 * profesörlük eşiği `birim` ile ayrıldı.
 *
 * ── "YARDIMCI DOÇENTLİK" = DOKTOR ÖĞRETİM ÜYELİĞİ ──
 * Yönerge 2013 tarihli ve 7100 sayılı Kanun öncesi terimi kullanıyor;
 * eşikler `dr_ogr_uyesi` ve `dr_ogr_uyesi_yeniden` kadrolarına yazıldı.
 *
 * ── DOÇENTLİKTE İLAVE KOŞUL YOK ──
 * Dört maddenin de ikinci fıkrası "Doçentlik belgesine sahip olmak"
 * dışında bir koşul aramıyor.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde 6(1)-a ve 8(1)-a'nın "ulusal/uluslararası hakemli dergilerde
 *       2 makale" alternatifi A-1, A-3 ve A-5 satırlarından sayıldı.
 *   Madde 9(1)-a'nın "bu puanın en az biri doktora tezinden üretilmiş
 *       olmak" koşulu: kayıt bir yayının tezden üretilip üretilmediğini
 *       taşımıyor; `beyan`.
 *   Madde 6(3)-d: yabancı dille eğitim yapan birimlerde EK-2 esaslarına
 *       göre deneme dersi — süreç kuralı.
 *   Yönerge hiçbir kadroda sayısal yabancı dil puanı istemiyor;
 *       `Kalip::yds` kullanılmadı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/musku-2013.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Muğla Sıtkı Koçman Üniversitesi';
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_3_YIL = Kalip::sonYil(3);

$doktora = Kalip::beyan('Doktora ya da tıpta uzmanlık unvanını almış olmak', '6');
$docentUnvani = Kalip::beyan('Doçentlik belgesine sahip olmak', '6-2-a');
$ucYil = Kalip::beyan(
    'Doçent unvanını aldıktan sonra yurt içinde ya da yurt dışında herhangi bir yükseköğretim '
    .'kurumunda, araştırma merkezinde, enstitüde veya eğitim ve araştırma hastanesinde en az üç '
    .'yıl süreyle çalışmış olmak',
    '6-3-a',
);

/** Madde 6(1)-a ve 8(1)-a: SCI makalesi ya da iki hakemli makale. */
$drYayin = Kalip::veya('İlk atanma yayın koşulu', [
    Kalip::adet(
        'SCI, SCI-Expanded, SSCI ya da AHCI\'ye giren dergilerde en az 1 makale yayımlamış olmak',
        ['MAKALE-SCI'], 1, madde: '6-1-a',
    ),
    Kalip::adet(
        'Ya da ulusal veya uluslararası hakemli dergilerde en az 2 makale yayımlamış olmak',
        ['MAKALE-HAKEMLI'], 2, madde: '6-1-a',
    ),
]);

$esikler = [];

// ══════════════════════════════════════════════════════════════════════════
// MADDE 6 — TEMEL BİLİMLER, MÜHENDİSLİK, SU ÜRÜNLERİ VE TEKNOLOJİ
// ══════════════════════════════════════════════════════════════════════════

$FEN = ['fen', 'muhendislik', 'ziraat'];

$esikler[] = [
    'anahtar' => 'musku-fen-dr',
    'aday_notu' => 'Temel bilimler, mühendislik, su ürünleri ve teknoloji alanlarında ilk '
        .'atanma için SCI, SCI-Expanded, SSCI ya da AHCI dergilerinde en az 1 makale veya ulusal '
        .'ya da uluslararası hakemli dergilerde 2 makale yayımlamış olmanız ve EK-1\'den toplam '
        .'250 puan almanız gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => $FEN,
    'cetvel' => 'musku-2013-fen',
    'notlar' => 'Madde 6(1)-a: 1 SCI makalesi ya da 2 hakemli makale; EK-1\'den 250 puan.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna ilk atanma — temel bilimler, mühendislik, su ürünleri ve teknoloji', [
        $doktora, $drYayin, Kalip::toplam(250),
    ]),
];

$esikler[] = [
    'anahtar' => 'musku-fen-dr-yeniden',
    'aday_notu' => 'Son üç yıldaki çalışmalarınız sayılıyor. En az biri EK-1\'in A kapsamındaki '
        .'akademik etkinliklerinden (makaleler) olmak üzere en az 125 puan isteniyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => $FEN,
    'cetvel' => 'musku-2013-fen',
    'notlar' => 'Madde 6(1)-b: son 3 yılda 125 puan, en az biri A kapsamından.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna yeniden atanma — temel bilimler, mühendislik, su ürünleri ve teknoloji', [
        Kalip::adet('Son üç yılda EK-1\'in A kapsamında (makaleler) en az bir akademik etkinlik', ['A'], 1, donem: $SON_3_YIL, madde: '6-1-b'),
        Kalip::toplam(125, $SON_3_YIL),
    ]),
];

$esikler[] = [
    'anahtar' => 'musku-fen-docentlik',
    'aday_notu' => 'Yönerge doçent kadrosuna atanmada doçentlik belgesi dışında bir koşul '
        .'aramıyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => $FEN,
    'cetvel' => 'musku-2013-fen',
    'notlar' => 'Madde 6(2)-a: doçentlik belgesi dışında koşul yok.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — temel bilimler, mühendislik, su ürünleri ve teknoloji', [$docentUnvani]),
];

foreach ([
    ['fen-bfk', ['fen'], 'Biyoloji, Fizik ve Kimya Bölümleri', 2],
    ['fen-mat', ['fen'], 'Matematik ve İstatistik Bölümleri', 1],
    ['muh', ['muhendislik', 'ziraat'], null, 2],
] as [$anahtar, $alanlar, $birim, $makale]) {
    $ad = $birim ?? 'Mühendislik, Su Ürünleri ve Teknoloji Fakültesi';

    $esikler[] = [
        'anahtar' => "musku-{$anahtar}-profesorluk",
        'aday_notu' => "{$ad} için doçent unvanınızı aldıktan sonra bir yükseköğretim kurumunda "
            .'ya da araştırma merkezinde en az üç yıl çalışmış olmanız, EK-1\'den toplam 1000 '
            .'puan almanız (en az yarısı doçentlik sonrası) ve doçentlik sonrası A-1 '
            ."kapsamındaki dergilerde en az {$makale} makale yayımlamış olmanız gerekiyor.",
        'universite' => $UNIVERSITE,
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => 'musku-2013-fen',
        'notlar' => "Madde 6(3) ({$ad}): 3 yıl çalışma; 1000 puan, yarısı doçentlik sonrası; "
            ."A-1'den {$makale} makale.",
        'sart' => Kalip::ve("Profesör kadrosuna atanma — {$ad}", [
            $ucYil,
            Kalip::adet(
                "Doçentlik unvanınızı aldıktan sonra A-1 kapsamındaki dergilerde en az {$makale} makale",
                ['MAKALE-SCI'], $makale, donem: $DOCENTLIK, madde: '6-3-c',
            ),
            Kalip::toplam(500, $DOCENTLIK),
            Kalip::toplam(1000),
        ]),
    ];
}

// ══════════════════════════════════════════════════════════════════════════
// MADDE 7 — GÜZEL SANATLAR
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'musku-gsf-dr',
    'aday_notu' => 'Güzel sanatlar alanında ilk atanma için 250 puanı EK-3\'teki sanatsal '
        .'etkinlikler tablosundan olmak üzere toplam 300 puan isteniyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['guzel_sanatlar'],
    'cetvel' => 'musku-2013-gsf',
    'notlar' => 'Madde 7(1)-a: EK-3\'ten 250 puan, toplam 300 puan.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna ilk atanma — güzel sanatlar', [
        $doktora,
        Kalip::puanDan('EK-3 sanatsal etkinlikler tablosundan en az 250 puan', ['EK3'], 250, madde: '7-1-a'),
        Kalip::toplam(300),
    ]),
];

$esikler[] = [
    'anahtar' => 'musku-gsf-dr-yeniden',
    'aday_notu' => 'Son üç yıldaki çalışmalarınız sayılıyor. EK-1 ve EK-3\'teki etkinliklerden '
        .'en az 150 puan isteniyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => ['guzel_sanatlar'],
    'cetvel' => 'musku-2013-gsf',
    'notlar' => 'Madde 7(1)-b: son 3 yılda EK-1 ve EK-3\'ten 150 puan.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna yeniden atanma — güzel sanatlar', [
        Kalip::toplam(150, $SON_3_YIL),
    ]),
];

$esikler[] = [
    'anahtar' => 'musku-gsf-docentlik',
    'aday_notu' => 'Yönerge doçent kadrosuna atanmada doçentlik belgesi dışında bir koşul '
        .'aramıyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['guzel_sanatlar'],
    'cetvel' => 'musku-2013-gsf',
    'notlar' => 'Madde 7(2)-a: doçentlik belgesi dışında koşul yok.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — güzel sanatlar', [$docentUnvani]),
];

$esikler[] = [
    'anahtar' => 'musku-gsf-profesorluk',
    'aday_notu' => 'EK-1 ve EK-3\'teki etkinliklerden toplam 1000 puan isteniyor; bunun en az '
        .'500 puanı doçentlik unvanınızı aldıktan sonra gelmeli.',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['guzel_sanatlar'],
    'cetvel' => 'musku-2013-gsf',
    'notlar' => 'Madde 7(3)-a: 1000 puan, 500\'ü doçentlik sonrası.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma — güzel sanatlar', [
        Kalip::toplam(500, $DOCENTLIK),
        Kalip::toplam(1000),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// MADDE 8 — TIP VE SAĞLIK BİLİMLERİ
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'musku-saglik-dr',
    'aday_notu' => 'Tıp ve sağlık bilimlerinde ilk atanma için SCI, SCI-Expanded, SSCI ya da '
        .'AHCI dergilerinde en az 1 makale veya ulusal ya da uluslararası hakemli dergilerde 2 '
        .'makale yayımlamış olmanız ve EK-1\'den toplam 150 puan almanız gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['saglik'],
    'cetvel' => 'musku-2013-saglik',
    'notlar' => 'Madde 8(1)-a: 1 SCI makalesi ya da 2 hakemli makale; EK-1\'den 150 puan.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna ilk atanma — tıp ve sağlık bilimleri', [
        $doktora, $drYayin, Kalip::toplam(150),
    ]),
];

$esikler[] = [
    'anahtar' => 'musku-saglik-dr-yeniden',
    'aday_notu' => 'Son üç yıldaki çalışmalarınız sayılıyor. EK-1\'in A (makaleler), B '
        .'(bildiriler) ve C (kitaplar) kapsamındaki akademik etkinliklerinden en az 125 puan '
        .'isteniyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => ['saglik'],
    'cetvel' => 'musku-2013-saglik',
    'notlar' => 'Madde 8(1)-b: son 3 yılda A, B, C kapsamından 125 puan.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna yeniden atanma — tıp ve sağlık bilimleri', [
        Kalip::puanDan('Son üç yılda A, B ve C kapsamındaki akademik etkinliklerden en az 125 puan', ['ABC'], 125, $SON_3_YIL, madde: '8-1-b'),
    ]),
];

$esikler[] = [
    'anahtar' => 'musku-saglik-docentlik',
    'aday_notu' => 'Yönerge doçent kadrosuna atanmada doçentlik belgesi dışında bir koşul '
        .'aramıyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['saglik'],
    'cetvel' => 'musku-2013-saglik',
    'notlar' => 'Madde 8(2)-a: doçentlik belgesi dışında koşul yok.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — tıp ve sağlık bilimleri', [$docentUnvani]),
];

$esikler[] = [
    'anahtar' => 'musku-saglik-profesorluk',
    'aday_notu' => 'EK-1\'den toplam 1000 puan isteniyor; bunun en az 500 puanı doçentlik '
        .'unvanınızı aldıktan sonra gelmeli. Ayrıca doçent unvanınızı aldıktan sonra bir '
        .'yükseköğretim kurumunda, araştırma merkezinde ya da eğitim ve araştırma hastanesinde '
        .'en az üç yıl çalışmış olmalısınız.',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['saglik'],
    'cetvel' => 'musku-2013-saglik',
    'notlar' => 'Madde 8(3): 1000 puan, 500\'ü doçentlik sonrası; 3 yıl çalışma.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma — tıp ve sağlık bilimleri', [
        $ucYil,
        Kalip::toplam(500, $DOCENTLIK),
        Kalip::toplam(1000),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// MADDE 9 — SOSYAL BİLİMLER, EĞİTİM BİLİMLERİ VE ÖĞRETMEN YETİŞTİRME
// ══════════════════════════════════════════════════════════════════════════

$SOSYAL = ['sosyal', 'egitim', 'filoloji', 'spor'];

$esikler[] = [
    'anahtar' => 'musku-sosyal-dr',
    'aday_notu' => 'Sosyal bilimler, eğitim bilimleri ve öğretmen yetiştirme alanlarında ilk '
        .'atanma için EK-1\'in A (makaleler), B (bildiriler) ve C (kitaplar) grubu akademik '
        .'etkinliklerinden toplam 250 puan isteniyor; bu etkinliklerden en az birinin doktora '
        .'tezinizden üretilmiş olması gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => $SOSYAL,
    'cetvel' => 'musku-2013-sosyal',
    'notlar' => 'Madde 9(1)-a: A, B, C grubundan 250 puan; en az biri doktora tezinden.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna ilk atanma — sosyal ve eğitim bilimleri', [
        $doktora,
        Kalip::puanDan('EK-1\'in A, B ve C grubu akademik etkinliklerinden toplam en az 250 puan', ['ABC'], 250, madde: '9-1-a'),
        Kalip::beyan('Bu etkinliklerden en az birinin doktora tezinizden üretilmiş olması', '9-1-a'),
    ]),
];

$esikler[] = [
    'anahtar' => 'musku-sosyal-dr-yeniden',
    'aday_notu' => 'Son üç yıldaki çalışmalarınız sayılıyor. 125 puanı EK-1\'in A, B ve C '
        .'grubuna ait akademik etkinliklerden olmak üzere toplam 150 puan isteniyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => $SOSYAL,
    'cetvel' => 'musku-2013-sosyal',
    'notlar' => 'Madde 9(1)-b: A, B, C grubundan 125 puan, toplam 150 puan.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna yeniden atanma — sosyal ve eğitim bilimleri', [
        Kalip::puanDan('Son üç yılda A, B ve C grubu akademik etkinliklerden en az 125 puan', ['ABC'], 125, $SON_3_YIL, madde: '9-1-b'),
        Kalip::toplam(150, $SON_3_YIL),
    ]),
];

$esikler[] = [
    'anahtar' => 'musku-sosyal-docentlik',
    'aday_notu' => 'Yönerge doçent kadrosuna atanmada doçentlik belgesi dışında bir koşul '
        .'aramıyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => $SOSYAL,
    'cetvel' => 'musku-2013-sosyal',
    'notlar' => 'Madde 9(2)-a: doçentlik belgesi dışında koşul yok.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — sosyal ve eğitim bilimleri', [$docentUnvani]),
];

$esikler[] = [
    'anahtar' => 'musku-sosyal-profesorluk',
    'aday_notu' => 'EK-1\'den toplam 1000 puan isteniyor; bunun en az 500 puanı doçentlik '
        .'unvanınızı aldıktan sonra ve A, B, C grubu akademik etkinliklerden gelmeli.',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => $SOSYAL,
    'cetvel' => 'musku-2013-sosyal',
    'notlar' => 'Madde 9(3)-a: 1000 puan, 500\'ü doçentlik sonrası A, B, C grubundan.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma — sosyal ve eğitim bilimleri', [
        Kalip::puanDan('Doçentlik unvanınızı aldıktan sonra A, B ve C grubu akademik etkinliklerden en az 500 puan', ['ABC'], 500, $DOCENTLIK, madde: '9-3-a'),
        Kalip::toplam(1000),
    ]),
];

return $esikler;
