<?php

/**
 * PAMUKKALE ÜNİVERSİTESİ — Akademik Değerlendirme Yönergesi
 * Kaynak: pdf/17537006202.pamukkaleuniverstesi.pdf (17 sayfa;
 * YÖK Genel Kurulu 28.09.2023)
 *
 * ── YAPI: KOŞULLAR FAKÜLTE VE TEMEL ALAN KARIŞIMI ──
 * Tek puan tablosu; madde 7 koşulları FAKÜLTE ve TEMEL ALAN karışımı bir
 * kırılımla veriyor. Sekiz kural seti çıkıyor:
 *   1 Sağlık Bilimleri                          → `saglik`
 *   2 Mühendislik ve Fen                        → `muhendislik`, `fen`
 *   3 Matematik ve İstatistik                   → `fen` (birim)
 *   4 Eğitim, İletişim, Fen-Edebiyat ve İİBF'nin sosyal-beşerî alanları
 *     ile Eğitim Bilimleri temel alanı          → `sosyal`, `egitim`
 *   5 Eğitim Fakültesinin Güzel Sanatlar ve Güzel Sanatlar Eğitimi
 *                                               → `guzel_sanatlar` (birim)
 *   6 Filoloji, yabancı dil eğitimi, Uygulamalı Bilimler YO, Yabancı
 *     Diller YO, Spor Bilimleri ve Turizm       → `filoloji`, `spor`
 *   7 Hukuk, İlahiyat, Mimarlık                 → `hukuk`, `ilahiyat`,
 *                                                  `mimarlik`
 *   8 Müzik ve Sahne Sanatları                  → `guzel_sanatlar` (birim)
 * `fen` ve `guzel_sanatlar` altında ikişer kural seti bulunduğu için o
 * iki alanın eşikleri `birim` ile ayrıldı.
 *
 * ── EŞİK YAZILMAYAN ALAN ──
 * Yönerge Ziraat, Orman ve Su Ürünleri temel alanını anmıyor;
 * üniversitede o alanda fakülte de yok. `ziraat` için eşik yazılmadı.
 *
 * ── PROFESÖRLÜKTE PUAN BARAJI YOK ──
 * Madde 7 profesörlük için yalnız iki şey istiyor: doçentlikten sonra
 * beş yıl çalışmış olmak ve doçentliğe başvurduğu dönemdeki ÜAK
 * Doçentlik Sınavı Başvuru Koşullarını (lisansüstü tezlerden yayın
 * üretme şartı hariç) doçentlik sonrası BİR KEZ DAHA yerine getirmiş
 * olmak. İkincisi ÜAK'ın kendi ölçütlerine bağlı olduğu için
 * `hesaplanamiyor`; bu yüzden profesörlük eşiği tek satır ve bütün
 * alanlarda aynı.
 *
 * ── DOKTOR ÖĞRETİM ÜYESİ SÜRE UZATMA DÖRT YILLIK ──
 * Madde 7: "Doktor Öğretim Üyesi görev süresi 4'er yıllık süreler
 * şeklinde uzatılır"; barajlar da dört yıllık dönem için tanımlı. Dönem
 * `SON_ATAMA_SONRASI`.
 *
 * ── "İLK 3 İSİM ARASINDA OLMAK" ──
 * Sağlık, mühendislik ve fen alanlarının süre uzatmasında A.1-A.4
 * kapsamındaki bir yayında "adayın isminin ilk 3 isim arasında olması"
 * isteniyor. Motorun yazar rolleri ilk üç ismi ayrı ayrı taşımadığı için
 * koşul "tek, ilk ya da sorumlu yazar" dalıyla uygulandı; ikinci ya da
 * üçüncü isim olduğunuz yayınlar sayılmıyor ve koşul OLDUĞUNDAN ZOR
 * görünür.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   "Önceki uzatmalarda kullanılan yayınlar tekrar kullanılamaz" —
 *       geçmiş başvuru dosyası profilde yok.
 *   "Tezden üretilmemiş olmak kaydıyla en az bir adet yayın" — kayıt bir
 *       yayının tezden üretilip üretilmediğini taşımıyor; `beyan`.
 *   Sağlık Bilimlerinde "Tıp Fakültesi için her uzatma döneminde D.4
 *       maddeden en az 40 puan" — koşul FAKÜLTEYE bağlı; aday notunda.
 *   Doktor öğretim üyeliğinde "makaleler için yayın şartı yoktur, kabul
 *       yazısı yeterlidir" istisnası.
 *   Yönerge hiçbir kadroda sayısal yabancı dil puanı istemiyor;
 *       `Kalip::yds` kullanılmadı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/pau-2023.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Pamukkale Üniversitesi';
$CETVEL = 'pau-2023';
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$MAT_IST = 'Matematik ve İstatistik alanları';
$MUH_FEN = 'Mühendislik ve Fen alanları';
$GS_EGITIM = 'Eğitim Fakültesinin Güzel Sanatlar ve Güzel Sanatlar Eğitimi temel alanı';
$MUZIK = 'Müzik ve Sahne Sanatları temel alanları';

$doktora = Kalip::beyan('Doktora, sanatta yeterlik ya da tıpta uzmanlık unvanını almış olmak', '7');
$tezdenUretilmemis = Kalip::beyan(
    'Lisansüstü tezinizden üretilmemiş olmak kaydıyla en az bir yayın yapmış olmak', '7',
);

$esikler = [];

// ══════════════════════════════════════════════════════════════════════════
// DOKTOR ÖĞRETİM ÜYESİ — İLK ATANMA VE SÜRE UZATMA (Madde 7)
// ══════════════════════════════════════════════════════════════════════════

/**
 * @param  list<string>  $alanlar
 * @param  list<array<string, mixed>>  $drKosullar
 * @param  list<array<string, mixed>>  $uzatmaKosullar
 * @return list<array<string, mixed>>
 */
$drEsikleri = function (
    string $anahtar,
    array $alanlar,
    ?string $birim,
    string $alanAdi,
    array $drKosullar,
    string $drNotu,
    array $uzatmaKosullar,
    string $uzatmaNotu,
    int $uzatmaToplam,
) use ($UNIVERSITE, $CETVEL, $SON_ATAMA, $doktora): array {
    return [
        [
            'anahtar' => "pau-{$anahtar}-dr",
            'aday_notu' => "{$alanAdi} için doktor öğretim üyesi kadrosuna atanmada {$drNotu} "
                .'Yönerge bu kadroda ayrıca bir toplam puan barajı ve sayısal yabancı dil şartı '
                .'koymuyor; makaleler için yayın şartı da yok, kabul yazısı yeterli.',
            'universite' => $UNIVERSITE,
            'kadro' => 'dr_ogr_uyesi',
            'alan' => $alanlar,
            'birim' => $birim,
            'cetvel' => $CETVEL,
            'notlar' => "Madde 7 ({$alanAdi}): doktor öğretim üyesi değerlendirmesi.",
            'sart' => Kalip::ve("Doktor Öğretim Üyesi kadrosuna atanma — {$alanAdi}",
                array_values(array_merge([$doktora], $drKosullar))),
        ],
        [
            'anahtar' => "pau-{$anahtar}-dr-yeniden",
            'aday_notu' => 'Doktor öğretim üyesi görev süresi dörder yıllık dönemler hâlinde '
                ."uzatılıyor; son atamanızdan sonraki faaliyetler sayılıyor. {$alanAdi} için "
                ."{$uzatmaNotu} Ayrıca dört yıllık görev süresi içinde toplam en az "
                ."{$uzatmaToplam} puan gerekiyor. Önceki uzatmalarda kullandığınız yayınlar "
                .'tekrar kullanılamıyor; motor bunu denetleyemiyor.',
            'universite' => $UNIVERSITE,
            'kadro' => 'dr_ogr_uyesi_yeniden',
            'alan' => $alanlar,
            'birim' => $birim,
            'cetvel' => $CETVEL,
            'notlar' => "Madde 7 ({$alanAdi}): süre uzatma; toplam {$uzatmaToplam} puan.",
            'sart' => Kalip::ve("Doktor Öğretim Üyesi görev süresi uzatma — {$alanAdi}",
                array_values(array_merge($uzatmaKosullar, [Kalip::toplam($uzatmaToplam, $SON_ATAMA)]))),
        ],
    ];
};

$a1Yayin = Kalip::adet(
    'A.1 maddesi kapsamında (SCI, SCI-Expanded, SSCI, AHCI, ESCI dergileri ile uluslararası '
    .'kitap ve kitap bölümü) en az bir araştırma yayınınız olmak (isim sırasına bakılmaz)',
    ['A.1'], 1, madde: '7',
);

$ilkUcIsim = Kalip::adet(
    'Görev uzatma süresi içinde A.1-A.4 maddeleri kapsamında, adınızın ilk üç isim arasında '
    .'olduğu bir yayınınız olmak',
    ['A.1-A.4'], 1, yazar: 'baslica', donem: $SON_ATAMA, madde: '7',
);

foreach ($drEsikleri('saglik', ['saglik'], null, 'Sağlık Bilimleri alanları',
    [$a1Yayin],
    'A.1 maddesi kapsamında en az bir araştırma yayını isteniyor (isim sırasına bakılmaz).',
    [$ilkUcIsim],
    'A.1-A.4 kapsamında adınızın ilk üç isim arasında olduğu bir yayın isteniyor. Tıp '
    .'Fakültesi kadrolarında ayrıca her uzatma döneminde D.4 maddesinden (ders verme) en az 40 '
    .'puan gerekiyor; koşul fakülteye bağlı olduğu için motor onu uygulamıyor.',
    80) as $e) {
    $esikler[] = $e;
}

foreach ($drEsikleri('muh-fen', ['muhendislik', 'fen'], $MUH_FEN, $MUH_FEN,
    [$a1Yayin],
    'A.1 maddesi kapsamında en az bir araştırma yayını isteniyor (isim sırasına bakılmaz).',
    [
        $ilkUcIsim,
        Kalip::puanDan('A.1-A.10 kapsamındaki yayınlardan en az 40 puan', ['A.1-A.10'], 40, $SON_ATAMA, madde: '7'),
    ],
    'A.1-A.10 kapsamındaki yayınlardan en az 40 puan ve A.1-A.4 kapsamında adınızın ilk üç isim '
    .'arasında olduğu bir yayın isteniyor.',
    80) as $e) {
    $esikler[] = $e;
}

foreach ($drEsikleri('mat-ist', ['fen'], $MAT_IST, $MAT_IST,
    [$a1Yayin],
    'A.1 maddesi kapsamında en az bir araştırma yayını isteniyor (isim sırasına bakılmaz).',
    [Kalip::puanDan('A.1-A.10 kapsamındaki yayınlardan en az 30 puan', ['A.1-A.10'], 30, $SON_ATAMA, madde: '7')],
    'A.1-A.10 kapsamındaki yayınlardan en az 30 puan isteniyor.',
    80) as $e) {
    $esikler[] = $e;
}

foreach ($drEsikleri('sosyal', ['sosyal', 'egitim'], null,
    'Eğitim, İletişim, Fen-Edebiyat ve İktisadi ve İdari Bilimler Fakültelerinin sosyal ve beşerî bilimler alanları ile Eğitim Bilimleri temel alanı',
    [
        $tezdenUretilmemis,
        Kalip::puanDan('A.1-A.13 maddeleri kapsamında en az 50 puan', ['A.1-A.13'], 50, madde: '7'),
    ],
    'tezinizden üretilmemiş en az bir yayın ve A.1-A.13 maddeleri kapsamında en az 50 puan isteniyor.',
    [Kalip::puanDan('A.1-A.13 maddeleri kapsamında en az 30 puan', ['A.1-A.13'], 30, $SON_ATAMA, madde: '7')],
    'A.1-A.13 maddeleri kapsamında en az 30 puan isteniyor.',
    80) as $e) {
    $esikler[] = $e;
}

foreach ($drEsikleri('gs-egitim', ['guzel_sanatlar'], $GS_EGITIM, $GS_EGITIM,
    [
        $tezdenUretilmemis,
        Kalip::puanDan('A.1-A.15 maddeleri kapsamında en az 50 puan', ['A.1-A.15'], 50, madde: '7'),
    ],
    'tezinizden üretilmemiş en az bir yayın ve A.1-A.15 maddeleri kapsamında en az 50 puan isteniyor.',
    [Kalip::puanDan('A.1-A.12 maddeleri kapsamında en az 30 puan', ['A.1-A.12'], 30, $SON_ATAMA, madde: '7')],
    'A.1-A.12 maddeleri kapsamında en az 30 puan isteniyor.',
    80) as $e) {
    $esikler[] = $e;
}

foreach ($drEsikleri('filoloji-spor', ['filoloji', 'spor'], null,
    'Filoloji temel alanı, yabancı dil eğitimi, Uygulamalı Bilimler ve Yabancı Diller Yüksekokulları ile Spor Bilimleri ve Turizm Fakülteleri',
    [
        $tezdenUretilmemis,
        Kalip::puanDan('A.1-A.16 maddeleri kapsamında en az 50 puan', ['A.1-A.16'], 50, madde: '7'),
    ],
    'tezinizden üretilmemiş en az bir yayın ve A.1-A.16 maddeleri kapsamında en az 50 puan isteniyor.',
    [Kalip::puanDan('A.1-A.16 maddeleri kapsamında en az 30 puan', ['A.1-A.16'], 30, $SON_ATAMA, madde: '7')],
    'A.1-A.16 maddeleri kapsamında en az 30 puan isteniyor.',
    80) as $e) {
    $esikler[] = $e;
}

foreach ($drEsikleri('hukuk', ['hukuk', 'ilahiyat', 'mimarlik'], null,
    'Hukuk, İlahiyat ve Mimarlık temel alanları',
    [
        $tezdenUretilmemis,
        Kalip::puanDan('A.1-A.15 maddeleri kapsamında en az 50 puan', ['A.1-A.15'], 50, madde: '7'),
    ],
    'tezinizden üretilmemiş en az bir yayın ve A.1-A.15 maddeleri kapsamında en az 50 puan isteniyor.',
    [Kalip::adet('Son atamanızdan sonra en az bir yayın yapmış olmak', ['YAYIN'], 1, donem: $SON_ATAMA, madde: '7')],
    'en az bir yayın isteniyor.',
    80) as $e) {
    $esikler[] = $e;
}

foreach ($drEsikleri('muzik', ['guzel_sanatlar'], $MUZIK, $MUZIK,
    [Kalip::veya('Yayın ya da sanatsal etkinlik koşulu', [
        Kalip::puanDan('A.1-A.13 maddeleri kapsamında en az 60 puan', ['A.1-A.13'], 60, madde: '7'),
        Kalip::puanDan('Ya da A.17 (Müzik ve Sahne Sanatları) veya A.18 (Türk Müziği) maddelerinden en az 60 puan', ['A.17-A.18'], 60, madde: '7'),
    ])],
    'A.1-A.13 maddeleri kapsamında ya da A.17 (Müzik ve Sahne Sanatları) veya A.18 (Türk '
    .'Müziği) maddelerinden en az 60 puan isteniyor.',
    [
        Kalip::puanDan('A.1-A.13 maddeleri kapsamında en az 30 puan', ['A.1-A.13'], 30, $SON_ATAMA, madde: '7'),
        Kalip::puanDan('A.17 ya da A.18 maddelerinden en az 60 puan', ['A.17-A.18'], 60, $SON_ATAMA, madde: '7'),
    ],
    'A.1-A.13 maddeleri kapsamında en az 30 puan ve A.17 ya da A.18 maddelerinden en az 60 puan '
    .'isteniyor.',
    100) as $e) {
    $esikler[] = $e;
}

// ══════════════════════════════════════════════════════════════════════════
// DOÇENT (Madde 7)
// ══════════════════════════════════════════════════════════════════════════

$uakDocentlik = Kalip::beyan(
    'Üniversitelerarası Kurul tarafından kabul edilmiş doçentlik sınavı başvuru koşullarında '
    .'kendi alanınız için öngörülen yayın koşulunu yerine getirmiş olmak',
    '7',
);

foreach ([
    ['saglik', ['saglik'], null, 'Sağlık Bilimleri alanları', 250],
    ['muh-fen', ['muhendislik', 'fen'], $MUH_FEN, $MUH_FEN, 250],
    ['mat-ist', ['fen'], $MAT_IST, $MAT_IST, 250],
    ['sosyal', ['sosyal', 'egitim'], null, 'Eğitim, İletişim, Fen-Edebiyat ve İİBF\'nin sosyal ve beşerî bilimler alanları ile Eğitim Bilimleri temel alanı', 200],
    ['gs-egitim', ['guzel_sanatlar'], $GS_EGITIM, $GS_EGITIM, 200],
    ['filoloji-spor', ['filoloji', 'spor'], null, 'Filoloji, yabancı dil eğitimi, Uygulamalı Bilimler ve Yabancı Diller Yüksekokulları ile Spor Bilimleri ve Turizm Fakülteleri', 200],
] as [$anahtar, $alanlar, $birim, $alanAdi, $toplam]) {
    $esikler[] = [
        'anahtar' => "pau-{$anahtar}-docentlik",
        'aday_notu' => "{$alanAdi} için doçentlik kadrosuna atanmada ÜAK doçentlik sınavı "
            .'başvuru koşullarındaki yayın koşulunu yerine getirmiş olmanız ve puanlama '
            ."ilkelerinden toplam en az {$toplam} puan almanız gerekiyor.",
        'universite' => $UNIVERSITE,
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => $CETVEL,
        'notlar' => "Madde 7 ({$alanAdi}): ÜAK doçentlik yayın koşulu; toplam {$toplam} puan.",
        'sart' => Kalip::ve("Doçent kadrosuna atanma — {$alanAdi}", [
            $uakDocentlik,
            Kalip::toplam($toplam),
        ]),
    ];
}

$esikler[] = [
    'anahtar' => 'pau-hukuk-docentlik',
    'aday_notu' => 'Hukuk, İlahiyat ve Mimarlık temel alanlarında doçentlik kadrosuna atanmada '
        .'Üniversitelerarası Kurul tarafından uygulanmakta olan doçentlik şartlarının yerine '
        .'getirilmesi yeterli; yönerge ayrıca bir puan barajı koymuyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['hukuk', 'ilahiyat', 'mimarlik'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 7 (Hukuk, İlahiyat, Mimarlık): ÜAK doçentlik şartları yeterli, ek puan yok.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — Hukuk, İlahiyat ve Mimarlık', [$uakDocentlik]),
];

$esikler[] = [
    'anahtar' => 'pau-muzik-docentlik',
    'aday_notu' => 'Müzik ve Sahne Sanatları temel alanlarında doçentlik kadrosuna atanmada '
        .'A.1-A.13 maddeleri kapsamında en az 30 puan, A.17 (Müzik ve Sahne Sanatları) ya da '
        .'A.18 (Türk Müziği) maddesinden en az 75 puan ve toplam en az 150 puan isteniyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['guzel_sanatlar'],
    'birim' => $MUZIK,
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 7 (Müzik ve Sahne Sanatları): A.1-13\'ten 30, A.17/A.18\'den 75; toplam 150.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — Müzik ve Sahne Sanatları', [
        $uakDocentlik,
        Kalip::puanDan('A.1-A.13 maddeleri kapsamında en az 30 puan', ['A.1-A.13'], 30, madde: '7'),
        Kalip::puanDan('A.17 ya da A.18 maddesinden en az 75 puan', ['A.17-A.18'], 75, madde: '7'),
        Kalip::toplam(150),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// PROFESÖR (Madde 7)
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'pau-profesorluk',
    'aday_notu' => 'Profesörlük için yönerge kendi puan tablosundan bir baraj İSTEMİYOR. '
        .'Doçentlik unvanınızı aldıktan sonra en az beş yıl açık bulunan profesörlük kadrosuyla '
        .'ilgili bilim alanında çalışmış olmanız ve doçentliğe başvurduğunuz dönemdeki ÜAK '
        .'Doçentlik Sınavı Başvuru Koşullarını (lisansüstü tezlerinizden yayın üretme şartı '
        .'hariç) doçentlik sonrası BİR KEZ DAHA yerine getirmiş olmanız gerekiyor. İkinci koşul '
        .'ÜAK\'ın kendi ölçütlerine bağlı olduğu için motor onu hesaplayamıyor. Kendi bilim '
        .'alanınız dışında ilan edilen bir kadroya başvuruyorsanız, başvurduğunuz alanın '
        .'koşulları geçerli oluyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['saglik', 'muhendislik', 'fen', 'sosyal', 'egitim', 'guzel_sanatlar',
        'filoloji', 'spor', 'hukuk', 'ilahiyat', 'mimarlik'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 7: doçentlikten sonra 5 yıl; ÜAK doçentlik başvuru koşullarını yeniden '
        .'sağlama. Puan barajı yok.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma', [
        Kalip::beyan(
            'Doçentlik unvanını aldıktan sonra en az beş yıl süreyle, açık bulunan profesörlük '
            .'kadrosuyla ilgili bilim alanında çalışmış olmak',
            '7',
        ),
        Kalip::hesaplanamiyor(
            'Doçentliğe başvurduğunuz dönemdeki ÜAK Doçentlik Sınavı Başvuru Koşullarını '
            .'(lisansüstü tezlerinizden yayın üretme şartı hariç) doçentlik sonrası bir kez daha '
            .'yerine getirmiş olmak — ÜAK\'ın kendi ölçütlerine bağlı olduğu için motor '
            .'hesaplayamıyor',
            '7',
        ),
    ]),
];

return $esikler;
