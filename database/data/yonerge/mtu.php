<?php

/**
 * MALATYA TURGUT ÖZAL ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve
 * Atanma Ölçütleri Yönergesi
 * Kaynak: pdf/17537003072.malatyaturgutozaluniverstesi.pdf
 * (15 sayfa; Senato 30.05.2025-2025/14-01, YÖK onay 30.04.2025)
 *
 * ── YAPI: DÖRT BİLİM ALANI GRUBU ──
 * Madde 5 on iki temel alanı dört gruba topluyor:
 *   Sağlık Bilimleri  → `saglik`
 *   Fen Bilimleri     → `fen`, `mimarlik`, `muhendislik`, `ziraat`
 *   Sosyal Bilimler   → `sosyal`, `egitim`, `filoloji`, `ilahiyat`,
 *                       `spor`, `hukuk`
 *   Güzel Sanatlar    → `guzel_sanatlar`
 * Güzel Sanatlar kendi içinde ikiye ayrılıyor: KURAMSAL alanlar (YKS ile
 * öğrenci alan) Sosyal Bilimler ölçütlerine tabi; UYGULAMALI alanlar
 * (özel yetenek sınavıyla öğrenci alan) kendi ölçütlerine. Ayrım temel
 * alan değil PROGRAM türü olduğu için `birim` alanıyla verildi; aday
 * hangi programa başvurduğunu seçtiğinde doğru eşik geliyor.
 *
 * ── İKİ GEÇİCİ MADDE BUGÜN İÇİN BELİRLEYİCİ ──
 * Geçici Madde 1: "Doktor Öğretim Üyeliğine yeniden atanma için bu
 *     yönerge hükümleri 01/07/2027 tarihinden itibaren uygulanır." Yani
 *     yeniden atanma eşiği bugün için değil, 2027 Temmuz sonrası için
 *     geçerli; eski yönerge (16.03.2021-2021/06-05) bu belgede yok.
 * Geçici Madde 2: "01/07/2027 tarihine kadar Profesör ve Doçent
 *     kadrosuna yapılacak atamalarda G veya İ kapsamındaki faaliyetler
 *     için zorunluluk aranmaz." Yani doçentlikte TEK koşul olan proje
 *     barajı ile profesörlükteki proje-patent barajı BUGÜN ARANMIYOR.
 * İkisi de ilgili eşiklerin aday notunda yazılı; barajlar 2027 sonrası
 * için hesaplanıyor.
 *
 * ── "EK PUAN" SEÇENEĞİ ──
 * Doçentlikte ve Sosyal/Güzel Sanatlar profesörlüğünde proje barajının
 * alternatifi "A1 ve/veya A2'den X EK puan". Doçentlikte başka bir A
 * barajı olmadığı için doğrudan A1-A2'den X puan; profesörlükte ise A
 * kapsamından zaten 200 puan istendiği için A1-A2'den 200+X puan olarak
 * yazıldı. "Ek" sözcüğünün başka okuması da mümkün; bu okuma daha
 * KATIDIR, yani koşul olduğundan zor görünebilir.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde 6(9): yabancı dille eğitim yapan birimlerde 85 puanlık dil
 *       şartı. Profil programın öğretim dilini tutmadığı için §0
 *       uyarınca genel şart (55) uygulandı, 85 aday notunda.
 *   Madde 6(7): Tıp Fakültesinde öğretim üyesi eksiği olan anabilim
 *       dallarında Üniversite Yönetim Kurulu kararıyla istisna.
 *   Madde 6(11): yağmacı/şaibeli dergilerin puanlanmaması.
 *   Madde 8(4): doçent unvanı almış doktor öğretim üyelerinin yeniden
 *       atanmada yalnız doçentlik belgesiyle başvurabilmesi — aday
 *       notunda.
 *   Madde 10(5)'in "lisansüstü tezlerinden üretilmemiş olması" koşulu:
 *       kayıt bir yayının tezden üretilip üretilmediğini taşımıyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/mtu-2025.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Malatya Turgut Özal Üniversitesi';
$CETVEL = 'mtu-2025';
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$FEN = ['fen', 'mimarlik', 'muhendislik', 'ziraat'];
$SOSYAL = ['sosyal', 'egitim', 'filoloji', 'ilahiyat', 'spor', 'hukuk'];
$GS_KURAMSAL = 'Güzel Sanatlar — kuramsal alanlar (YKS ile öğrenci alan)';
$GS_UYGULAMALI = 'Güzel Sanatlar — uygulamalı alanlar (özel yetenek sınavıyla öğrenci alan)';

$DIL_NOTU = ' Yabancı dil koşulu 55 puandan uygulanıyor; yabancı dil öğretimi yapan ya da '
    .'yabancı dille eğitim veren bir birime başvuruyorsanız aynı sınavdan en az 85 puan gerekir.';

$GECICI_2 = ' DİKKAT: yönergenin geçici hükmü uyarınca 01/07/2027 tarihine kadar yapılacak atamalarda '
    .'G (projeler) ve İ (fikri ve sınai mülkiyet) kapsamındaki faaliyetler için zorunluluk '
    .'ARANMIYOR; aşağıda bu baraj yine de hesaplanıyor, bugün başvuruyorsanız sağlamak zorunda '
    .'değilsiniz.';

$dil = Kalip::yds(55);

$doktora = Kalip::beyan('Doktora ya da tıpta uzmanlık unvanını almış olmak', '8');

$docentUnvani = Kalip::beyan(
    '2547 sayılı Kanunun 24. maddesi uyarınca doçentlik unvanını almış olmak', '9',
);

$besYil = Kalip::beyan(
    '2547 sayılı Kanunun 26. maddesindeki koşullar uyarınca doçentlik unvanını aldıktan sonra '
    .'gerekli süreyi tamamlamış olmak',
    '10',
);

$ders = Kalip::metrik(
    'Doçent unvanınızı aldıktan sonra ön lisans, lisans ya da lisansüstü düzeyde en az altı '
    .'yarıyıl (yıllık ders programı yürütülen birimlerde en az üç yıl) ders vermiş olmak',
    'ders_yariyil', 6,
);

/** Madde 10(5): doçentlik sonrası başlıca araştırma eseri. */
$baslicaEser = fn (bool $sosyal): array => Kalip::veya('Başlıca araştırma eseri koşulu', array_values(array_filter([
    Kalip::adet(
        'Doçent unvanınızı aldıktan sonra Web of Science veri tabanında taranan bir dergide tek '
        .'isimli, ilk isim ya da yazışmadan sorumlu isim olarak yayımlanmış araştırma makaleniz '
        .'olmak (başlıca araştırma eseri)',
        ['A1-A2'], 1, yazar: 'baslica', donem: $DOCENTLIK, madde: '10-5',
    ),
    $sosyal ? Kalip::adet(
        'Ya da doçent unvanınızı aldıktan sonra tek yazarlı, ders kitabı niteliğinde olmayan '
        .'bilimsel bir kitap yayımlamış olmak',
        ['C'], 1, yazar: 'tek', donem: $DOCENTLIK, madde: '10-5-d',
    ) : null,
    $sosyal ? Kalip::adet(
        'Ya da doçent unvanınızı aldıktan sonra TR Dizinde taranan bir dergide araştırma '
        .'makalesi yayımlamış olmak',
        ['A3'], 1, donem: $DOCENTLIK, madde: '10-5-d',
    ) : null,
])));

$esikler = [];

// ══════════════════════════════════════════════════════════════════════════
// DOKTOR ÖĞRETİM ÜYESİ — İLK ATANMA (Madde 8)
// ══════════════════════════════════════════════════════════════════════════

foreach ([
    ['fen', $FEN, null, 'Fen Bilimleri grubu (fen ve matematik, mimarlık-planlama-tasarım, mühendislik, ziraat-orman-su ürünleri)',
        ['A1-A2'], 'SCI, SCI-Expanded, SSCI, AHCI, ESCI ve Scopus dergilerindeki makalelerinizden', 80, 50, 150],
    ['saglik', ['saglik'], null, 'Sağlık Bilimleri temel alanı',
        ['A1-A2'], 'SCI, SCI-Expanded, SSCI, AHCI, ESCI ve Scopus dergilerindeki makalelerinizden', 50, 20, 100],
    ['sosyal', $SOSYAL, null, 'Sosyal Bilimler grubu (sosyal-beşerî-idari, eğitim, filoloji, ilahiyat, spor, hukuk)',
        ['A'], 'makalelerinizden', 80, 50, 150],
    ['gs-kuramsal', ['guzel_sanatlar'], $GS_KURAMSAL, 'Güzel Sanatlar kuramsal alanları',
        ['A'], 'makalelerinizden', 80, 50, 150],
] as [$anahtar, $alanlar, $birim, $alanAdi, $aGrup, $aAd, $aPuan, $bPuan, $acPuan]) {
    $esikler[] = [
        'anahtar' => "mtu-{$anahtar}-dr",
        'aday_notu' => "{$alanAdi} için {$aAd} en az {$aPuan} puan, bilimsel etkinliklerinizden "
            ."(düzenleme kurulu üyelikleri hariç) en az {$bPuan} puan, yayın, etkinlik ve proje "
            ."kalemlerinizden en az {$acPuan} puan ve toplamda en az 250 puan "
            .'isteniyor.'.$DIL_NOTU,
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => $CETVEL,
        'notlar' => "Madde 8(2) ({$alanAdi}): {$aAd} {$aPuan}; B (B1.4-B2.4 hariç) {$bPuan}; "
            ."A-C {$acPuan}; toplam 250.",
        'sart' => Kalip::ve("Doktor Öğretim Üyesi kadrosuna ilk atanma — {$alanAdi}", [
            $doktora,
            $dil,
            Kalip::puanDan(ucfirst($aAd)." en az {$aPuan} puan", $aGrup, $aPuan, madde: '8-2'),
            Kalip::puanDan(
                'B kapsamındaki bilimsel etkinliklerden (düzenleme kurulu üyelikleri hariç) en '
                ."az {$bPuan} puan",
                ['B-HARIC'], $bPuan, madde: '8-2',
            ),
            Kalip::puanDan("A-C kapsamındaki faaliyetlerden en az {$acPuan} puan", ['A-C'], $acPuan, madde: '8-2'),
            Kalip::toplam(250),
        ]),
    ];
}

$esikler[] = [
    'anahtar' => 'mtu-gs-uygulamali-dr',
    'aday_notu' => 'Güzel Sanatlar uygulamalı alanları için '
        .'yayınlarınızdan en az 20 puan, B kapsamındaki bilimsel etkinliklerden (düzenleme '
        .'kurulu üyelikleri hariç) en az 20 puan, A-C kapsamındaki faaliyetlerden en az 50 puan, '
        .'N1-N25 kapsamındaki sanat ve tasarım etkinliklerinden en az 80 puan ve toplamda en az '
        .'250 puan isteniyor.'.$DIL_NOTU,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['guzel_sanatlar'],
    'birim' => $GS_UYGULAMALI,
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 8(2)-e: A 20; B (B1.4-B2.4 hariç) 20; A-C 50; N1-N25 80; toplam 250.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna ilk atanma — Güzel Sanatlar uygulamalı alanları', [
        $doktora,
        $dil,
        Kalip::puanDan('Makalelerinizden en az 20 puan', ['A'], 20, madde: '8-2-e'),
        Kalip::puanDan(
            'B kapsamındaki bilimsel etkinliklerden (düzenleme kurulu üyelikleri hariç) en az 20 puan',
            ['B-HARIC'], 20, madde: '8-2-e',
        ),
        Kalip::puanDan('A-C kapsamındaki faaliyetlerden en az 50 puan', ['A-C'], 50, madde: '8-2-e'),
        Kalip::puanDan('N1-N25 kapsamındaki sanat ve tasarım etkinliklerinden en az 80 puan', ['N'], 80, madde: '8-2-e'),
        Kalip::toplam(250),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// DOKTOR ÖĞRETİM ÜYESİ — YENİDEN ATANMA (Madde 8-3)
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'mtu-dr-yeniden',
    'aday_notu' => 'Son atandığınız dönem içindeki faaliyetleriniz sayılıyor. A kapsamındaki '
        .'yayınlardan en az 100 puan, B kapsamındaki bilimsel etkinliklerden en az 30 puan ve '
        .'toplamda en az 200 puan isteniyor. Yayınlarınızdan biri SCI, SCI-Expanded, SSCI, '
        .'AHCI ya da ESCI kapsamındaki '
        .'(Q1 veya Q2) dergilerde yayımlanmışsa atamanız dört yıl olarak yapılıyor. Doçent '
        .'unvanı almış doktor öğretim üyeleri yeniden atanma için dosya hazırlamadan yalnız '
        .'doçentlik belgesiyle başvurabiliyor. DİKKAT: yönergenin geçici hükmü uyarınca bu koşullar '
        .'01/07/2027 tarihinden itibaren uygulanıyor; bugün başvuruyorsanız 16.03.2021 tarihli '
        .'eski yönerge geçerli (o yönerge bu belgede yok).',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => array_merge(['saglik'], $FEN, $SOSYAL, ['guzel_sanatlar']),
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 8(3): A 100; B 30; toplam 200 (son atama dönemi).',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna yeniden atanma', [
        Kalip::puanDan(
            'Son atama döneminizde A kapsamındaki yayınlarınızdan en az 100 puan',
            ['A'], 100, $SON_ATAMA, madde: '8-3',
        ),
        Kalip::puanDan(
            'Son atama döneminizde B kapsamındaki bilimsel etkinliklerden en az 30 puan',
            ['B'], 30, $SON_ATAMA, madde: '8-3',
        ),
        Kalip::toplam(200, $SON_ATAMA),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// DOÇENT (Madde 9)
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'mtu-fen-saglik-docentlik',
    'aday_notu' => 'Sağlık ve Fen Bilimleri gruplarında doçentlik için doçentlik unvanına ek '
        .'olarak yalnız bir koşul var: proje faaliyetlerinizden en az 80 '
        .'puan.'.$GECICI_2,
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => array_merge(['saglik'], $FEN),
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 9(1)-a: G kapsamından 80 puan. Geçici Madde 2: 01/07/2027\'ye kadar aranmıyor.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — Sağlık ve Fen Bilimleri', [
        $docentUnvani,
        Kalip::puanDan('Proje faaliyetlerinizden en az 80 puan', ['G'], 80, madde: '9-1-a'),
    ]),
];

$esikler[] = [
    'anahtar' => 'mtu-sosyal-docentlik',
    'aday_notu' => 'Sosyal Bilimler ve Güzel Sanatlar gruplarında doçentlik için doçentlik '
        .'unvanına ek olarak proje faaliyetlerinizden en az 40 puan ya da '
        .'A1 ve/veya A2 kapsamındaki yayınlardan 40 ek puan isteniyor.'.$GECICI_2,
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => array_merge($SOSYAL, ['guzel_sanatlar']),
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 9(1)-b: G\'den 40 puan ya da A1/A2\'den 40 ek puan. Geçici Madde 2.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — Sosyal Bilimler ve Güzel Sanatlar', [
        $docentUnvani,
        Kalip::veya('Proje ya da ek yayın koşulu', [
            Kalip::puanDan('Proje faaliyetlerinizden en az 40 puan', ['G'], 40, madde: '9-1-b'),
            Kalip::puanDan('Ya da A1 ve/veya A2 kapsamındaki yayınlarınızdan en az 40 ek puan', ['A1-A2'], 40, madde: '9-1-b'),
        ]),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// PROFESÖR (Madde 10)
// ══════════════════════════════════════════════════════════════════════════

/**
 * @param  list<string>  $alanlar
 * @param  list<string>  $gGrup  Puan grubu adı (tek elemanlı liste)
 * @return array<string, mixed>
 */
$profesorEsigi = function (
    string $anahtar,
    array $alanlar,
    ?string $birim,
    string $alanAdi,
    bool $ilkIsim,
    int $aPuan,
    int $acPuan,
    array $gGrup,
    string $gAd,
    int $gPuan,
    ?int $ekPuan,
    bool $sosyalEser,
) use ($UNIVERSITE, $CETVEL, $DOCENTLIK, $besYil, $ders, $baslicaEser, $GECICI_2): array {
    $kosullar = [
        $besYil,
        $ders,
        Kalip::puanDan("Doçentlik sonrası A kapsamındaki yayınlarınızdan en az {$aPuan} puan", ['A'], $aPuan, $DOCENTLIK, madde: '10-4'),
        Kalip::puanDan("Doçentlik sonrası A-C kapsamındaki faaliyetlerden en az {$acPuan} puan", ['A-C'], $acPuan, $DOCENTLIK, madde: '10-4'),
    ];

    if ($ilkIsim) {
        $kosullar[] = Kalip::adet(
            'Doçentlik sonrası A1 ve/veya A2 kapsamındaki yayınlardan en az ikisinde birinci '
            .'isim olmak',
            ['A1-A2'], 2, yazar: 'baslica', donem: $DOCENTLIK, madde: '10-4',
        );
    }

    if ($ekPuan === null) {
        $kosullar[] = Kalip::puanDan("Doçentlik sonrası {$gAd} en az {$gPuan} puan", array_values($gGrup), $gPuan, $DOCENTLIK, madde: '10-4');
    } else {
        $kosullar[] = Kalip::veya('Proje ya da ek yayın koşulu', [
            Kalip::puanDan("Doçentlik sonrası {$gAd} en az {$gPuan} puan", array_values($gGrup), $gPuan, $DOCENTLIK, madde: '10-4'),
            Kalip::puanDan(
                'Ya da doçentlik sonrası A1 ve/veya A2 kapsamındaki yayınlarınızdan en az '
                ."{$ekPuan} puan ({$gPuan} puanı ek olmak üzere)",
                ['A1-A2'], $ekPuan, $DOCENTLIK, madde: '10-4',
            ),
        ]);
    }

    $kosullar[] = $baslicaEser($sosyalEser);
    $kosullar[] = Kalip::toplam(1000, $DOCENTLIK);

    return [
        'anahtar' => "mtu-{$anahtar}-profesorluk",
        'aday_notu' => 'Doçent unvanınızı aldığınız dönemin son başvuru tarihinden sonraki '
            ."çalışmalarınız sayılıyor. {$alanAdi} için makalelerinizden en az "
            ."{$aPuan} puan, yayın, etkinlik ve proje kalemlerinizden en az {$acPuan} puan, "
            ."{$gAd} en az {$gPuan} puan"
            .($ekPuan === null ? '' : " (ya da dizinli dergilerdeki makalelerinizden {$gPuan} ek puan)")
            .' ve toplamda en az 1000 puan isteniyor. Ayrıca doçentlik sonrası en az altı '
            .'yarıyıl ders vermiş ve yayınlarınızdan birini başlıca araştırma eseri olarak '
            .'göstermiş olmalısınız.'
            .($ilkIsim ? ' Bu yayınlardan en az ikisinde dizinli dergilerde birinci isim olmanız gerekiyor.' : '')
            .$GECICI_2,
        'universite' => $UNIVERSITE,
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => $CETVEL,
        'notlar' => "Madde 10(4) ({$alanAdi}): A {$aPuan}; A-C {$acPuan}; {$gAd} {$gPuan}; "
            .'toplam 1000 (doçentlik sonrası); 6 yarıyıl ders; başlıca eser.',
        'sart' => Kalip::ve("Profesör kadrosuna yükseltilme ve atanma — {$alanAdi}", $kosullar),
    ];
};

$esikler[] = $profesorEsigi('fen', $FEN, null, 'Fen Bilimleri grubu', true, 200, 400, ['G-I'], 'G ya da İ kapsamındaki faaliyetlerden', 150, null, false);
$esikler[] = $profesorEsigi('saglik', ['saglik'], null, 'Sağlık Bilimleri temel alanı', true, 200, 400, ['G-I'], 'G ya da İ kapsamındaki faaliyetlerden', 80, null, false);
$esikler[] = $profesorEsigi('sosyal', $SOSYAL, null, 'Sosyal Bilimler grubu', false, 200, 400, ['G'], 'G kapsamındaki faaliyetlerden', 80, 280, true);
$esikler[] = $profesorEsigi('gs-kuramsal', ['guzel_sanatlar'], $GS_KURAMSAL, 'Güzel Sanatlar kuramsal alanları', false, 200, 400, ['G'], 'G kapsamındaki faaliyetlerden', 80, 280, true);

$esikler[] = [
    'anahtar' => 'mtu-gs-uygulamali-profesorluk',
    'aday_notu' => 'Doçent unvanınızı aldığınız dönemin son başvuru tarihinden sonraki '
        .'çalışmalarınız sayılıyor. Güzel Sanatlar uygulamalı alanları için makalelerinizden '
        .'en az 150 puan, yayın, etkinlik ve proje kalemlerinizden en az 300 puan, proje ve '
        .'patent kalemlerinizden en az 40 puan (ya da dizinli dergilerdeki makalelerinizden 40 '
        .'ek puan), sanat ve tasarım etkinliklerinizden en az 400 puan ve toplamda en az 1000 '
        .'puan isteniyor. Ayrıca doçentlik sonrası en az altı yarıyıl ders vermiş ve '
        .'yayınlarınızdan birini başlıca araştırma eseri olarak göstermiş olmalısınız.'.$GECICI_2,
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['guzel_sanatlar'],
    'birim' => $GS_UYGULAMALI,
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 10(4)-e: A 150; A-C 300; G-İ 40 (ya da A1/A2\'den 40 ek); N1-N25 400; '
        .'toplam 1000 (doçentlik sonrası).',
    'sart' => Kalip::ve('Profesör kadrosuna yükseltilme ve atanma — Güzel Sanatlar uygulamalı alanları', [
        $besYil,
        $ders,
        Kalip::puanDan('Doçentlik sonrası A kapsamındaki yayınlarınızdan en az 150 puan', ['A'], 150, $DOCENTLIK, madde: '10-4-e'),
        Kalip::puanDan('Doçentlik sonrası A-C kapsamındaki faaliyetlerden en az 300 puan', ['A-C'], 300, $DOCENTLIK, madde: '10-4-e'),
        Kalip::veya('Proje ya da ek yayın koşulu', [
            Kalip::puanDan('Doçentlik sonrası G ya da İ kapsamındaki faaliyetlerden en az 40 puan', ['G-I'], 40, $DOCENTLIK, madde: '10-4-e'),
            Kalip::puanDan('Ya da doçentlik sonrası A1 ve/veya A2 kapsamındaki yayınlarınızdan en az 190 puan (40 puanı ek olmak üzere)', ['A1-A2'], 190, $DOCENTLIK, madde: '10-4-e'),
        ]),
        Kalip::puanDan('Doçentlik sonrası N1-N25 kapsamındaki sanat ve tasarım etkinliklerinden en az 400 puan', ['N'], 400, $DOCENTLIK, madde: '10-4-e'),
        $baslicaEser(true),
        Kalip::toplam(1000, $DOCENTLIK),
    ]),
];

return $esikler;
