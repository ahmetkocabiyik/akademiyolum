<?php

/**
 * SİVAS CUMHURİYET ÜNİVERSİTESİ — Öğretim Üyeliği Kadrolarına Başvurma,
 * Yükseltilme ve Atanma Yönergesi
 * Kaynak: pdf/17537008552.sivascumhuriyetuniverstesi.pdf (32 sayfa;
 * 10.12.2021 tarihli metin, YÖK onayıyla yürürlüğe girer.)
 *
 * ── İKİ ALAN GRUBU ──
 * MADDE 16 ve 17 temel alanları iki gruba ayırıyor:
 *   (a) Fen Bilimleri ve Matematik, Mühendislik, Ziraat-Orman-Su
 *       Ürünleri ve Sağlık Bilimleri,
 *   (b) Eğitim, Spor, Filoloji, Güzel Sanatlar, Hukuk, İlahiyat,
 *       Mimarlık-Planlama-Tasarım ile Sosyal, Beşerî ve İdari Bilimler.
 * Doçentlik (MADDE 14) ve profesörlük (MADDE 12) koşullarının yalnız
 * yayın türü şıkkı bu ayrımı kullanıyor; toplam puanlar ortak.
 *
 * ── BÖLÜM TAVANLARI KADRONUN ASGARİ PUANINA BAĞLI ──
 * EK-1'in yüzde tavanları ("bu bölümden toplam puanın en fazla %25'i")
 * kadronun asgari puanına bağlı. Her eşik kendi cetvel varyantına
 * bağlandı: ilk atama, sekiz temel alanda yeniden atanma ve profesörlük
 * 50 puanlık varyanta; Fen, Mühendislik, Ziraat ve Sağlık'ta yeniden
 * atanma 60 puanlık varyanta; doçentlik 300 puanlık varyanta.
 *
 * ── "EN AZ 50 PUAN DAHA" ──
 * MADDE 12(c)(5) ve 14(b)(5) belirli bir yayın türüne ek olarak "en az
 * 50 puan daha" istiyor. Motorda "şu kadar puan DAHA" düğümü yok;
 * koşul toplam puana eklenerek yazıldı (doçentlikte 300 + 50 = 350,
 * profesörlükte 50 + 50 = 100). Aritmetik `notlar` alanında.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 12(b)'nin "A8 kapsamında en az 2 özgün araştırma makalesi"
 *       seçeneği — A8 (Üniversiteye bağlı hakemli dergiler) cetvele
 *       girmedi; aynı bendin A1, A3 veya A4 seçeneği girildi.
 *   MADDE 12(c) ve 14(b) "(1, 2, 3, 4, 5, 6) şartlarından en az biri"
 *       diyor ama beş şık sayılmış; kaynak metin düzeltilmedi, beş şık
 *       girildi.
 *   MADDE 13(b): doçentlikte yabancı dil puanı olarak "başvuru
 *       yapılan dönemde ÜAK'ın doçentlik için belirlediği asgari puan"
 *       isteniyor; ÜAK'ın süregelen 55 puanı uygulandı.
 *   MADDE 18(1): yeni kurulan birimlerde Senatonun asgari koşulların
 *       dışına çıkabilmesi.
 *   MADDE 18(3): süresinin yarıdan fazlasını dekanlık, müdürlük ya da
 *       başhekimlik gibi idari görevlerde geçirenler için projelerde
 *       araştırmacı veya danışman olmanın yeterli sayılması.
 *   MADDE 18(4): askerlik, sağlık ve doğum izni gibi nedenlerle üç aydan
 *       uzun süre görevde bulunulamamasının dikkate alınması.
 *   MADDE 20: doktor öğretim üyeliğine ilk atamada ve profesörlükte bir
 *       yıl, yeniden atanmada iki yıl süreyle 29.11.2018 tarihli eski
 *       yönergenin uygulanması.
 *   MADDE 11(b)-(c) ve 12(a) beyan ya da hesaplanamıyor olarak yazıldı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/scu-2021.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Sivas Cumhuriyet Üniversitesi';
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;

$GRUP1 = ['fen', 'muhendislik', 'ziraat', 'saglik'];
$GRUP2 = ['egitim', 'spor', 'filoloji', 'guzel_sanatlar', 'hukuk', 'ilahiyat', 'mimarlik', 'sosyal'];
$TUM = [...$GRUP1, ...$GRUP2];

$GRUP1_AD = 'Fen Bilimleri ve Matematik, Mühendislik, Ziraat-Orman-Su Ürünleri ve Sağlık Bilimleri';
$GRUP2_AD = 'Eğitim, Spor, Filoloji, Güzel Sanatlar, Hukuk, İlahiyat, Mimarlık-Planlama-Tasarım '
    .'ile Sosyal, Beşerî ve İdari Bilimler';

$NOT_TAVAN = ' EK-1\'in bölüm tavanları kadronun asgari puanının yüzdesi olarak hesaplanıyor '
    .'(bildiri, kitap, atıf, editörlük ve sanatsal etkinliklerde %25, patentte %40, projede %30, '
    .'tez danışmanlığı ve derste %15, ödülde %20, idari görevde %15).';
$NOT_ESKI = ' Yönergenin 20. maddesi uyarınca doktor öğretim üyeliğine ilk atamalarda ve '
    .'profesörlük atamalarında bir yıl, doktor öğretim üyeliğine yeniden atanmada iki yıl '
    .'süreyle 29.11.2018 tarihli eski yönerge uygulanıyor.';
$NOT_KAZI = ' Kazı ve yüzey araştırması faaliyetleri (EK-1 K bölümü) ile Üniversiteye bağlı '
    .'dergilerdeki makaleler puana katılmıyor; bu kalemleri olan adayın gerçek puanı daha '
    .'yüksektir.';

/** MADDE 12(c) ve 14(b) ortak şıkları. */
$kitapSarti = Kalip::veya('Kitap koşulu', [
    Kalip::adet(
        'Alanınızda tek yazarlı ulusal ya da uluslararası bilimsel nitelikte bir kitap yayımlamış olmak',
        ['C-KITAP'], 1, 'tek', madde: '14-b-1',
    ),
    Kalip::adet(
        'Alanınızda ulusal ya da uluslararası bilimsel nitelikte bir kitapta editörlük yapmış olmak',
        ['C-EDITOR'], 1, madde: '14-b-1',
    ),
    Kalip::adet(
        'Alanınızda en az iki kitap bölümü yayımlamış olmak',
        ['C-BOLUM'], 2, madde: '14-b-1',
    ),
]);

$projeSarti = Kalip::veya('Proje koşulu', [
    Kalip::adet(
        'TÜBİTAK, TÜBA, AB, SANTEZ, TAGEM, KOSGEB gibi kurumlarca onaylanmış en az bir araştırma '
        .'projesinde yürütücü olmak',
        ['G-YURUTUCU'], 1, madde: '14-b-2',
    ),
    Kalip::adet(
        'TÜBİTAK, TÜBA, AB, SANTEZ, TAGEM, KOSGEB gibi kurumlarca onaylanmış en az iki araştırma '
        .'projesinde araştırmacı olmak',
        ['G-ARASTIRMACI'], 2, madde: '14-b-2',
    ),
]);

$tezSarti = Kalip::veya('Tez danışmanlığı koşulu', [
    Kalip::adet(
        'En az bir doktora, uzmanlık ya da sanatta yeterlik tezi tamamlatmış olmak',
        ['I-DOKTORA'], 1, madde: '14-b-3',
    ),
    Kalip::adet(
        'En az iki yüksek lisans tezi tamamlatmış olmak',
        ['I-YUKSEKLISANS'], 2, madde: '14-b-3',
    ),
]);

$patentSarti = Kalip::adet(
    'Uluslararası ya da ulusal tescillenmiş patent almış olmak',
    ['F-PATENT'], 1, madde: '14-b-4',
);

$esikler = [];

// ══════════════════════════════════════════════════════════════════════════
// DOKTOR ÖĞRETİM ÜYELİĞİNE İLK ATAMA (MADDE 15-16)
// ══════════════════════════════════════════════════════════════════════════

$drOrtak = [
    Kalip::beyan('Doktora, uzmanlık ya da sanatta yeterlik unvanını almış olmak', '15-1-a'),
    Kalip::yds(55),
    Kalip::adet(
        'Hazırladığınız lisansüstü tezin konusuyla ilgili en az bir makale yayımlamış olmak '
        .'(bu çalışmayı "tez yayını" olarak kaydedin)',
        ['TEZ-YAYINI'], 1, madde: '16-1-a-1',
    ),
];

$esikler[] = [
    'anahtar' => 'scu-grup1-dr',
    'aday_notu' => "{$GRUP1_AD} temel alanlarında doktor öğretim üyeliğine İLK ATANMA koşulları. "
        .'Yabancı dil sınavından en az 55 puan gerekiyor.'.$NOT_TAVAN.$NOT_KAZI.$NOT_ESKI,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => $GRUP1,
    'cetvel' => 'scu-2021-50',
    'notlar' => 'MADDE 15 ve 16(1)(a): tez konusuyla ilgili 1 makale; en az 1\'i A1 kapsamında '
        .'olmak üzere 2 makale; EK-1\'den toplam 50 puan.',
    'sart' => Kalip::ve('Doktor Öğretim Üyeliğine ilk atanma — Fen, Mühendislik, Ziraat, Sağlık', [
        ...$drOrtak,
        Kalip::adet('En az 2 makale yayımlamış olmak', ['MAKALE'], 2, madde: '16-1-a-2'),
        Kalip::adet(
            'Bu makalelerden en az 1 tanesinin SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki '
            .'bir dergide yayımlanmış olması',
            ['A1'], 1, madde: '16-1-a-2',
        ),
        Kalip::toplam(50),
    ]),
];

$esikler[] = [
    'anahtar' => 'scu-grup2-dr',
    'aday_notu' => "{$GRUP2_AD} temel alanlarında doktor öğretim üyeliğine İLK ATANMA koşulları. "
        .'Yabancı dil sınavından en az 55 puan gerekiyor.'.$NOT_TAVAN.$NOT_KAZI.$NOT_ESKI,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => $GRUP2,
    'cetvel' => 'scu-2021-50',
    'notlar' => 'MADDE 15 ve 16(1)(b): tez konusuyla ilgili 1 makale; A1 veya A3\'te 1 makale '
        .'ya da A4-A5\'te 2 makale; EK-1\'den toplam 50 puan.',
    'sart' => Kalip::ve('Doktor Öğretim Üyeliğine ilk atanma — Sosyal, Eğitim, Hukuk ve diğerleri', [
        ...$drOrtak,
        Kalip::veya('Yayın koşullarından biri', [
            Kalip::adet(
                'SCI, SCI-Expanded, SSCI, AHCI ya da ESCI kapsamındaki dergilerde en az 1 makale '
                .'yayımlamış olmak',
                ['A1-A3'], 1, madde: '16-1-b-2',
            ),
            Kalip::adet(
                'TR Dizin kapsamındaki dergilerde en az 2 makale yayımlamış olmak',
                ['A4-A5'], 2, madde: '16-1-b-2',
            ),
        ]),
        Kalip::toplam(50),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// DOKTOR ÖĞRETİM ÜYELİĞİNE YENİDEN ATANMA (MADDE 9, 17)
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'scu-grup1-dr-yeniden',
    'aday_notu' => "{$GRUP1_AD} temel alanlarında doktor öğretim üyeliğine YENİDEN ATANMA "
        .'koşulları. Atamalar en çok üç yıl süreyle yapılıyor. Yönerge yeniden atanmada '
        .'faaliyetleri son atanma tarihiyle sınırlamıyor; bütün akademik geçmişiniz sayılıyor.'
        .$NOT_TAVAN.$NOT_KAZI.$NOT_ESKI,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => $GRUP1,
    'cetvel' => 'scu-2021-60',
    'notlar' => 'MADDE 17(1)(a): en az 1\'i A1 veya A3 kapsamında olmak üzere toplam 3 araştırma '
        .'makalesi; EK-1\'den toplam 60 puan.',
    'sart' => Kalip::ve('Doktor Öğretim Üyeliğine yeniden atanma — Fen, Mühendislik, Ziraat, Sağlık', [
        Kalip::adet('En az 3 araştırma makalesi yayımlamış olmak', ['MAKALE'], 3, madde: '17-1-a'),
        Kalip::adet(
            'Bu makalelerden en az 1 tanesinin SCI, SCI-Expanded, SSCI, AHCI ya da ESCI '
            .'kapsamındaki bir dergide yayımlanmış olması',
            ['A1-A3'], 1, madde: '17-1-a',
        ),
        Kalip::toplam(60),
    ]),
];

$esikler[] = [
    'anahtar' => 'scu-grup2-dr-yeniden',
    'aday_notu' => "{$GRUP2_AD} temel alanlarında doktor öğretim üyeliğine YENİDEN ATANMA "
        .'koşulları. Atamalar en çok üç yıl süreyle yapılıyor. Yönerge yeniden atanmada '
        .'faaliyetleri son atanma tarihiyle sınırlamıyor; bütün akademik geçmişiniz sayılıyor.'
        .$NOT_TAVAN.$NOT_KAZI.$NOT_ESKI,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => $GRUP2,
    'cetvel' => 'scu-2021-50',
    'notlar' => 'MADDE 17(1)(b): A1 veya A3\'te en az 1 ya da A4-A5\'te en az 3 makale; '
        .'EK-1\'den toplam 50 puan.',
    'sart' => Kalip::ve('Doktor Öğretim Üyeliğine yeniden atanma — Sosyal, Eğitim, Hukuk ve diğerleri', [
        Kalip::veya('Yayın koşullarından biri', [
            Kalip::adet(
                'SCI, SCI-Expanded, SSCI, AHCI ya da ESCI kapsamındaki dergilerde en az 1 makale '
                .'yayımlamış olmak',
                ['A1-A3'], 1, madde: '17-1-b',
            ),
            Kalip::adet(
                'TR Dizin kapsamındaki dergilerde en az 3 makale yayımlamış olmak',
                ['A4-A5'], 3, madde: '17-1-b',
            ),
        ]),
        Kalip::toplam(50),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// DOÇENTLİK (MADDE 13-14)
// ══════════════════════════════════════════════════════════════════════════

/**
 * @param  list<string>  $alanlar
 * @return array<string, mixed>
 */
$docentlik = function (string $anahtar, array $alanlar, string $alanAdi, string $makaleGrubu, string $makaleEtiketi) use ($UNIVERSITE, $kitapSarti, $projeSarti, $tezSarti, $patentSarti, $NOT_TAVAN, $NOT_KAZI): array {
    return [
        'anahtar' => "scu-{$anahtar}-docentlik",
        'aday_notu' => "{$alanAdi} temel alanlarında doçent kadrosuna atanma koşulları. Doçent "
            .'unvanını almış olmak ve başvuru döneminde ÜAK\'ın doçentlik için belirlediği '
            .'yabancı dil puanını (55) sağlamak gerekiyor. EK-1\'den toplam 300 puan almanın yanı '
            .'sıra beş koşuldan en az birini sağlamalısınız; sonuncusu 50 puan daha istediği için '
            .'toplam 350 puan olarak yazıldı.'.$NOT_TAVAN.$NOT_KAZI,
        'universite' => $UNIVERSITE,
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'cetvel' => 'scu-2021-300',
        'notlar' => 'MADDE 13 ve 14: doçentlik unvanı, ÜAK dil puanı (55), EK-1\'den 300 puan; '
            .'14(b)\'nin beş şıkkından biri. 14(b)(5) "50 puan daha" olduğu için 300 + 50 = 350 '
            .'toplam puana çevrildi.',
        'sart' => Kalip::ve("Doçent kadrosuna atanma — {$alanAdi}", [
            Kalip::beyan('Doçent unvanını almış olmak', '13-1-a'),
            Kalip::yds(55),
            Kalip::toplam(300),
            Kalip::veya('Ek koşullardan en az biri', [
                $kitapSarti,
                $projeSarti,
                $tezSarti,
                $patentSarti,
                Kalip::ve('Ek yayın ve puan koşulu', [
                    Kalip::adet(
                        "En az bir tanesi {$makaleEtiketi} yayımlanmış özgün makale olmak üzere "
                        .'ek çalışmalar yapmış olmak',
                        [$makaleGrubu], 1, madde: '14-b-5',
                    ),
                    Kalip::toplam(350),
                ]),
            ]),
        ]),
    ];
};

$esikler[] = $docentlik('grup1', $GRUP1, $GRUP1_AD, 'A1',
    'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki bir dergide');
$esikler[] = $docentlik('grup2', $GRUP2, $GRUP2_AD, 'A1-A4',
    'SCI, SCI-Expanded, SSCI, AHCI, ESCI ya da TR Dizin kapsamındaki bir dergide');

// ══════════════════════════════════════════════════════════════════════════
// PROFESÖRLÜK (MADDE 11-12)
// ══════════════════════════════════════════════════════════════════════════

/**
 * @param  list<string>  $alanlar
 * @return array<string, mixed>
 */
$profesorluk = function (string $anahtar, array $alanlar, string $alanAdi, string $makaleGrubu, string $makaleEtiketi) use ($UNIVERSITE, $DOCENTLIK, $kitapSarti, $projeSarti, $tezSarti, $patentSarti, $NOT_TAVAN, $NOT_KAZI): array {
    return [
        'anahtar' => "scu-{$anahtar}-profesorluk",
        'aday_notu' => "{$alanAdi} temel alanlarında profesör kadrosuna yükseltilerek atanma "
            .'koşulları. Puan ve sayı koşullarının tamamı DOÇENT unvanınızı aldıktan sonraki '
            .'çalışmalardan sağlanmalı ve bu çalışmalar doçentlik başvuru dosyanızda '
            .'kullanılmamış olmalı. Ayrıca 2018-Ekim döneminde ÜAK tarafından belirlenmiş '
            .'doçentlik müracaat ölçütlerini 100 puanla yeniden sağlamış olmanız gerekiyor; bu '
            .'koşul ÜAK\'ın kendi puanlama sistemine bağlı olduğu için motor hesaplayamıyor. Beş '
            .'ek koşuldan en az birini de sağlamalısınız; sonuncusu 50 puan daha istediği için '
            .'toplam 100 puan olarak yazıldı.'.$NOT_TAVAN.$NOT_KAZI,
        'universite' => $UNIVERSITE,
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'cetvel' => 'scu-2021-50',
        'notlar' => 'MADDE 11 ve 12: 12(a) ÜAK ölçütleri hesaplanamıyor; 12(b) A1, A3 veya '
            .'A4\'te 2 özgün araştırma makalesi + 50 puan; 12(c)\'nin beş şıkkından biri, '
            .'12(c)(5) "50 puan daha" olduğu için 50 + 50 = 100 toplam puana çevrildi.',
        'sart' => Kalip::ve("Profesör kadrosuna yükseltilerek atanma — {$alanAdi}", [
            Kalip::beyan(
                'Doçent unvanını aldıktan sonra profesörlüğe atanmak için gerekli yasal sürenin '
                .'en az yarısı kadar süreyle üniversitelerde ya da alanınızla ilgili bir '
                .'kuruluşta fiilen çalışmış olmak',
                '11-1-b',
            ),
            Kalip::beyan(
                'Doçent unvanını aldıktan sonra yaptığınız özgün yayınlardan birini başvuru '
                .'dosyanızda "Başlıca Araştırma Eseri" olarak belirtmek',
                '11-1-c',
            ),
            Kalip::hesaplanamiyor(
                'Doçentlik başvurusundan sonra, 2018-Ekim döneminde ÜAK tarafından belirlenmiş '
                .'doçentlik müracaat ölçütlerini (lisansüstü tezlerden üretilmiş yayın şartı '
                .'hariç) 100 puanla yeniden sağlamış olmak',
                '12-1-a',
            ),
            Kalip::adet(
                'Doçentlik başvurunuzdan sonra SCI, SCI-Expanded, SSCI, AHCI, ESCI ya da TR Dizin '
                .'kapsamındaki dergilerde en az 2 özgün araştırma makalesi yayımlamış olmak',
                ['A1-A3-A4'], 2, donem: $DOCENTLIK, madde: '12-1-b',
            ),
            Kalip::toplam(50, $DOCENTLIK),
            Kalip::veya('Ek koşullardan en az biri', [
                $kitapSarti,
                $projeSarti,
                $tezSarti,
                $patentSarti,
                Kalip::ve('Ek yayın ve puan koşulu', [
                    Kalip::adet(
                        "En az bir tanesi {$makaleEtiketi} yayımlanmış özgün makale olmak üzere "
                        .'ek çalışmalar yapmış olmak',
                        [$makaleGrubu], 1, donem: $DOCENTLIK, madde: '12-1-c-5',
                    ),
                    Kalip::toplam(100, $DOCENTLIK),
                ]),
            ]),
        ]),
    ];
};

$esikler[] = $profesorluk('grup1', $GRUP1, $GRUP1_AD, 'A1-A3',
    'SCI, SCI-Expanded, SSCI, AHCI ya da ESCI kapsamındaki bir dergide');
$esikler[] = $profesorluk('grup2', $GRUP2, $GRUP2_AD, 'A1-A3-A4',
    'SCI, SCI-Expanded, SSCI, AHCI, ESCI ya da TR Dizin kapsamındaki bir dergide');

return $esikler;
