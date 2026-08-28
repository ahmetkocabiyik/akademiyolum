<?php

/**
 * ORDU ÜNİVERSİTESİ — Öğretim Üyeliği Kadrolarına Başvuru ve Atanma
 * Koşulları ve Uygulama Yönergesi
 * Kaynak: pdf/17537005692.orduuniverstesi.pdf (13 sayfa; Senato
 * 04.08.2017-2017/84 ve altı değişiklik kararı)
 *
 * ── YAPI: TEK TABLO, ALAN BAZLI YAYIN KOŞULU ──
 * Tek puan tablosu (EK-1). Bütün kadrolarda toplam puan barajı alandan
 * bağımsız (doktor öğretim üyeliğinde 100, doçentlikte 300,
 * profesörlükte 500); değişen tek şey hangi puan grubundan kaç yayın
 * istendiği. Madde 4 doktor öğretim üyeliğinde beş, madde 5 yeniden
 * atanmada dört koşul kümesi tanımlıyor.
 *
 * ── YENİDEN ATANMADA "ATAMA YILI BAŞINA DÖRTTE BİR" ──
 * Madde 5(a) her alan için 100 puan istiyor; madde 5(b) ise "asgari
 * toplam puanın her bir atama yılı başına en az dörtte birinin
 * sağlanması" diyor — yani bir yıllık atamada 25, dört yıllıkta 100
 * puan. Profil atama süresini tutmadığı için §0 uyarınca YÜKSEK olan
 * (100 puan, dört yıllık atama) uygulandı; kısa süreli atamalarda koşul
 * olduğundan katı görünür. Merdiven aday notunda.
 * Madde 5(b) ayrıca "en az bir yayın koşulu 3 yıl ve üzeri atamalarda
 * aranır" diyor; o koşul da yazıldı.
 *
 * ── YABANCI DİL ──
 * Doktor öğretim üyeliğinde yönerge YALNIZCA kısmen ya da tamamen
 * yabancı dille öğretim yapan bölümler için 80 puan istiyor; Türkçe
 * bölümler için sayısal bir dil şartı yok. Bu yüzden `Kalip::yds`
 * kullanılmadı, koşul aday notunda. Doçentlik ve profesörlükte Türkçe
 * bölümlerde 55, yabancı dille öğretim yapan bölümlerde 80 isteniyor;
 * §0 uyarınca 55 uygulandı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde 4(a) Sağlık Bilimleri a.3: bir programdaki öğretim üyesi
 *       sayısı YÖK'ün gerekli gördüğü sayının altındaysa yayın ve puan
 *       koşulunun uygulanmaması.
 *   Madde 4(c): 2547 sayılı Kanunun Ek 38. maddesi kapsamındaki %30
 *       kota ataması — ilk atanma koşullarının aynısı.
 *   Madde 7: askerlik, hamilelik ve hastalık nedeniyle üç ay ve üzeri
 *       görevden uzak kalanlarda puanın oranlanması.
 *   Madde 9(a): "doçent unvanını aldığı temel alan için ÜAK'ın
 *       belirlediği yayın koşullarını TEKRAR sağlamış olmak" —
 *       `hesaplanamiyor`.
 *   Madde 9(e): YÖK yönetmeliğindeki profesörlüğe atanma şartları —
 *       `beyan`.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/ordu-2017.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Ordu Üniversitesi';
$CETVEL = 'ordu-2017';
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$SOSYAL = ['egitim', 'filoloji', 'hukuk', 'ilahiyat', 'sosyal'];
$FEN = ['fen', 'mimarlik', 'muhendislik', 'ziraat'];

$DIL_DR = ' Kısmen ya da tamamen yabancı dille eğitim-öğretim yürütülen bölümlere '
    .'başvuruyorsanız merkezi bir yabancı dil sınavından en az 80 puan gerekiyor; Türkçe eğitim '
    .'yapan bölümler için yönerge doktor öğretim üyeliğinde sayısal bir dil şartı koymuyor.';
$DIL = ' Yabancı dil koşulu 55 puandan uygulanıyor; kısmen ya da tamamen yabancı dille '
    .'eğitim-öğretim yürütülen bölümlerde en az 80 puan gerekiyor.';

$YENIDEN_NOTU = ' Madde 5(b) "asgari toplam puanın her bir atama yılı başına en az dörtte '
    .'birinin sağlanmasını" istiyor: bir yıllık atamada 25, iki yıllıkta 50, üç yıllıkta 75, '
    .'dört yıllıkta 100 puan. Profil atama sürenizi tutmadığı için §0 uyarınca en yüksek olan '
    .'(100 puan) uygulanıyor; kısa süreli bir atamanız varsa koşul olduğundan katı görünür. '
    .'"En az bir yayın" koşulu yalnızca üç yıl ve üzeri atamalarda aranıyor.';

$doktora = Kalip::beyan('Doktora, sanatta yeterlik ya da tıpta uzmanlık unvanını almış olmak', '4');

$esikler = [];

// ══════════════════════════════════════════════════════════════════════════
// DOKTOR ÖĞRETİM ÜYESİ — İLK ATANMA (Madde 4)
// ══════════════════════════════════════════════════════════════════════════

/**
 * @param  list<string>  $alanlar
 * @param  list<array<string, mixed>>  $kosullar
 * @return array<string, mixed>
 */
$drEsigi = fn (string $anahtar, array $alanlar, string $alanAdi, array $kosullar, string $not): array => [
    'anahtar' => "ordu-{$anahtar}-dr",
    'aday_notu' => "{$alanAdi} için {$not} Ayrıca EK-1 akademik etkinlik puanlama tablosundan "
        .'toplam en az 100 puan gerekiyor.'.$DIL_DR,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => $alanlar,
    'cetvel' => $CETVEL,
    'notlar' => "Madde 4(a) ({$alanAdi}): alana özgü yayın koşulu; toplam 100 puan.",
    'sart' => Kalip::ve("Doktor Öğretim Üyesi kadrosuna ilk atanma — {$alanAdi}",
        array_values(array_merge([$doktora], $kosullar, [Kalip::toplam(100)]))),
];

$esikler[] = $drEsigi('sosyal', $SOSYAL,
    'Eğitim Bilimleri, Filoloji, Hukuk, İlahiyat ile Sosyal, Beşeri ve İdari Bilimler', [
        Kalip::adet('En az biri A.1 kapsamındaki dergilerde yayımlanmış tam metin makale olmak üzere A, B ve C puan gruplarından toplam iki bilimsel makaleniz olmak', ['ABC'], 2, madde: '4-a'),
        Kalip::adet('Bunlardan en az birinin A.1 kapsamındaki dergilerde yayımlanmış tam metin makale olması', ['A.1-TAM'], 1, madde: '4-a'),
    ],
    'en az biri A.1 kapsamındaki (uluslararası) dergilerde yayımlanmış tam metin makale olmak '
    .'üzere A, B ve C puan gruplarından toplam iki bilimsel makale isteniyor.');

$esikler[] = $drEsigi('fen', $FEN,
    'Fen Bilimleri ve Matematik, Mimarlık-Planlama-Tasarım, Mühendislik ile Ziraat, Orman ve Su Ürünleri', [
        Kalip::adet('En az biri A.1.1 kapsamındaki (SCI, SCI-Expanded, SSCI, AHCI) dergilerde yayımlanmış tam metin makale olmak üzere A puan grubundan toplam iki bilimsel makaleniz olmak', ['A'], 2, madde: '4-a'),
        Kalip::adet('Bunlardan en az birinin A.1.1 kapsamındaki dergilerde yayımlanmış tam metin makale olması', ['A.1.1-TAM'], 1, madde: '4-a'),
    ],
    'en az biri SCI, SCI-Expanded, SSCI ya da AHCI dergilerinde yayımlanmış tam metin makale '
    .'olmak üzere A puan grubundan toplam iki bilimsel makale isteniyor.');

$esikler[] = $drEsigi('saglik', ['saglik'], 'Sağlık Bilimleri', [
    Kalip::adet('A puan grubu kapsamındaki dergilerde en az bir yayın (tam metin makale, derleme, olgu sunumu, kısa rapor ya da editöre mektup) yayımlamış olmak', ['A'], 1, madde: '4-a'),
], 'A puan grubu kapsamındaki dergilerde en az bir yayın isteniyor. Bir programdaki öğretim '
    .'üyesi sayısı YÖK\'ün o programın açılması için gerekli gördüğü sayının altındaysa bu yayın '
    .'ve puan koşulu uygulanmıyor; motor bu istisnayı uygulayamıyor.');

$esikler[] = $drEsigi('guzel-sanatlar', ['guzel_sanatlar'], 'Güzel Sanatlar', [
    Kalip::puanDan('A, B, C, L ve M puanlama gruplarındaki akademik etkinliklerden en az 100 puan', ['ABCLM'], 100, madde: '4-a'),
], 'A, B, C, L ve M puanlama gruplarındaki akademik etkinliklerden en az 100 puan isteniyor '
    .'(ayrı bir yayın sayısı koşulu yok).');

$esikler[] = $drEsigi('spor', ['spor'], 'Spor Bilimleri', [
    Kalip::puanDan('A, B, C ve K puanlama gruplarındaki akademik etkinliklerden en az 100 puan', ['ABCK'], 100, madde: '4-a'),
], 'A, B, C ve K puanlama gruplarındaki akademik etkinliklerden en az 100 puan isteniyor '
    .'(ayrı bir yayın sayısı koşulu yok).');

// ══════════════════════════════════════════════════════════════════════════
// DOKTOR ÖĞRETİM ÜYESİ — YENİDEN ATANMA (Madde 5)
// ══════════════════════════════════════════════════════════════════════════

foreach ([
    ['sosyal', $SOSYAL, 'Eğitim Bilimleri, Filoloji, Hukuk, İlahiyat ile Sosyal, Beşeri ve İdari Bilimler', 'ABC', 'A, B ve C puan grubu'],
    ['fen', array_merge($FEN, ['saglik']), 'Fen Bilimleri ve Matematik, Mimarlık, Mühendislik, Sağlık Bilimleri ile Ziraat, Orman ve Su Ürünleri', 'A', 'A puan grubu'],
    ['guzel-sanatlar', ['guzel_sanatlar'], 'Güzel Sanatlar', 'ABCLM', 'A, B, C, L ve M puan grubu'],
    ['spor', ['spor'], 'Spor Bilimleri', 'ABCK', 'A, B, C ve K puan grubu'],
] as [$anahtar, $alanlar, $alanAdi, $grup, $grupAdi]) {
    $esikler[] = [
        'anahtar' => "ordu-{$anahtar}-dr-yeniden",
        'aday_notu' => 'Bir önceki atama tarihinizden itibaren yaptığınız faaliyetler sayılıyor. '
            ."{$alanAdi} için {$grupAdi} kapsamında en az bir yayın ya da akademik etkinlik ve "
            .'tüm puanlama gruplarından toplam en az 100 puan isteniyor.'.$YENIDEN_NOTU,
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => "Madde 5 ({$alanAdi}): {$grupAdi}'ndan 1 yayın; toplam 100 puan.",
        'sart' => Kalip::ve("Doktor Öğretim Üyesi kadrosuna yeniden atanma — {$alanAdi}", [
            Kalip::adet(
                "Son atamanızdan sonra {$grupAdi} kapsamında en az bir yayın ya da akademik "
                .'etkinlik yapmış olmak',
                [$grup], 1, donem: $SON_ATAMA, madde: '5-a',
            ),
            Kalip::toplam(100, $SON_ATAMA),
        ]),
    ];
}

// ══════════════════════════════════════════════════════════════════════════
// DOÇENT (Madde 8)
// ══════════════════════════════════════════════════════════════════════════

$TUM_ALANLAR = array_merge($SOSYAL, $FEN, ['saglik', 'guzel_sanatlar', 'spor']);

$esikler[] = [
    'anahtar' => 'ordu-docentlik',
    'aday_notu' => 'Üniversitelerarası Kurul tarafından verilen doçentlik unvanına sahip olmanız '
        .'ve EK-1 puanlama tablosunun A, B, C, G, I, K, L ve M puan gruplarındaki '
        .'faaliyetlerden en az 300 puan almanız gerekiyor.'.$DIL,
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => $TUM_ALANLAR,
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 8: doçentlik unvanı; A-B-C-G-I-K-L-M gruplarından 300 puan; dil 55.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma', [
        Kalip::beyan('Üniversitelerarası Kurul tarafından verilen doçentlik unvanına sahip olmak', '8'),
        Kalip::yds(55),
        Kalip::puanDan(
            'EK-1 puanlama tablosunun A, B, C, G, I, K, L ve M puan gruplarındaki faaliyetlerden '
            .'en az 300 puan',
            ['ABCGIKLM'], 300, madde: '8',
        ),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// PROFESÖR (Madde 9)
// ══════════════════════════════════════════════════════════════════════════

$profesorGovde = [
    Kalip::yds(55),
    Kalip::hesaplanamiyor(
        'Doçent unvanını aldıktan sonraki çalışma ve yayınlarınızla, unvanı aldığınız temel alan '
        .'için ÜAK\'ın belirlediği ve başarılı olduğunuz doçentlik başvuru dönemi için yürürlükte '
        .'olan yayın koşullarını TEKRAR sağlamış olmak (lisansüstü tezlerden üretilmiş yayın '
        .'koşulu hariç) — ÜAK\'ın kendi ölçütlerine bağlı olduğu için motor hesaplayamıyor',
        '9-a',
    ),
    Kalip::adet(
        'Başlıca eser olarak makale sunuyorsanız birinci isim olduğunuz, ulusal ya da '
        .'uluslararası hakemli bir dergide yayımlanmış makaleniz; kitap veya kitap bölümü '
        .'sunuyorsanız ISBN numarası alınmış basılı eseriniz olmak',
        ['BASLICA-ESER'], 1, yazar: 'ilk', madde: '9-c',
    ),
    Kalip::puanDan(
        'EK-1 puanlama tablosunun A, B, C, G, I, K, L ve M puan gruplarındaki faaliyetlerden '
        .'toplam en az 500 puan',
        ['ABCGIKLM'], 500, madde: '9-b',
    ),
    Kalip::puanDan(
        'Bu puanın en az 250\'sinin doçentlik sonrası bilimsel yayın ve araştırma '
        .'faaliyetlerinden alınmış olması',
        ['ABCGIKLM'], 250, $DOCENTLIK, madde: '9-b',
    ),
    Kalip::beyan(
        'Yükseköğretim Kurulunun Öğretim Üyeliğine Yükseltilme ve Atanma Yönetmeliğindeki '
        .'profesörlüğe atanma şartlarını sağlamış olmak',
        '9-e',
    ),
];

$esikler[] = [
    'anahtar' => 'ordu-profesorluk',
    'aday_notu' => 'EK-1 puanlama tablosunun A, B, C, G, I, K, L ve M puan gruplarındaki '
        .'faaliyetlerden toplam en az 500 puan isteniyor; bunun en az 250 puanı doçentlik sonrası '
        .'bilimsel yayın ve araştırma faaliyetlerinden gelmeli. Ayrıca doçent unvanınızı '
        .'aldığınız temel alan için ÜAK\'ın belirlediği yayın koşullarını yeniden sağlamanız '
        .'(motor bunu hesaplayamıyor) ve bir başlıca eser sunmanız gerekiyor.'.$DIL,
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => array_merge($SOSYAL, $FEN, ['guzel_sanatlar', 'spor']),
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 9: ÜAK yayın koşullarını yeniden sağlama; 500 puan (250\'si doçentlik '
        .'sonrası); başlıca eser; dil 55.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma', $profesorGovde),
];

$esikler[] = [
    'anahtar' => 'ordu-saglik-profesorluk',
    'aday_notu' => 'Sağlık Bilimleri temel alanında, genel koşullara ek olarak doçent unvanınızı '
        .'aldıktan sonra yurt içinde ya da yurt dışında kamuya ait bir yükseköğretim kurumunda, '
        .'araştırma merkezinde, enstitüde veya eğitim ve araştırma hastanesinde en az üç yıl '
        .'çalışmış ve eğitim-öğretim ile araştırma faaliyetlerinde yer almış olmanız gerekiyor. '
        .'EK-1\'in A, B, C, G, I, K, L ve M gruplarından toplam 500 puan (en az 250\'si '
        .'doçentlik sonrası) ve bir başlıca eser isteniyor.'.$DIL,
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['saglik'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 9 (Sağlık Bilimleri): genel koşullar + doçentlik sonrası 3 yıl çalışma.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma — Sağlık Bilimleri', array_merge(
        [Kalip::beyan(
            'Doçent unvanını aldıktan sonra yurt içinde ya da yurt dışında kamuya ait bir '
            .'yükseköğretim kurumunda, araştırma merkezinde, enstitüde veya eğitim ve araştırma '
            .'hastanesinde en az üç yıl çalışmış ve eğitim-öğretim ile araştırma faaliyetlerinde '
            .'yer almış olmak',
            '9-a',
        )],
        $profesorGovde,
    )),
];

return $esikler;
