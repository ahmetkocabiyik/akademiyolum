<?php

/**
 * YEDİTEPE ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma
 * Yönergesi
 * Kaynak: pdf/17537104532.yeditepeuniversitesi.pdf (11 sayfa; MADDE 11
 * uyarınca YÖK onayıyla yürürlüğe girer ve 1 Haziran 2024 tarihinden
 * itibaren başlatılan atama ve yükseltme işlemlerinde uygulanır.)
 *
 * ── KOŞULLAR AKADEMİK BİRİME GÖRE ──
 * MADDE 7(2), 8(2) ve 9(2) koşulları FAKÜLTE FAKÜLTE veriyor; aynı temel
 * alanda birden çok fakülte var (Sağlık Bilimleri temel alanında Diş
 * Hekimliği, Eczacılık, Sağlık Bilimleri ve Tıp fakülteleri ayrı ayrı).
 * Bu yüzden eşikler `birim` alanıyla ayrıştırıldı; profilinde birim
 * seçmeyen adaya, aynı temel alanda birden çok birim varsa eşik
 * gösterilemez.
 *
 * ── BÖLÜM DÜZEYİNDEKİ AYRIMLAR GİRİLMEDİ ──
 * Fen-Edebiyat Fakültesinde Çeviribilimi, Fizik, İngiliz Dili ve
 * Edebiyatı, Matematik, Psikoloji, Rus Dili ve Edebiyatı ile Türk Dili
 * ve Edebiyatı bölümlerine; Güzel Sanatlar Fakültesinde özel yetenek
 * sınavıyla ve merkezi yerleştirme puanıyla öğrenci alan programlara;
 * İletişim Fakültesinde Görsel İletişim Tasarımı bölümüne ayrı
 * koşullar veriliyor. Birim ayrımı FAKÜLTE düzeyinde tutuldu; bölüm ve
 * program düzeyindeki farklar aday notunda anlatılıyor. Fen-Edebiyat ve
 * Güzel Sanatlar için fakültenin genel kuralı uygulandı.
 *
 * ── PUAN YOK ──
 * Yönergenin puan cetveli yok; bütün koşullar sayı şartı. Cetvel dosyası
 * yalnız faaliyet türü kataloğu.
 *
 * ── PROFESÖRLÜKTE TELAFİLİ YAYIN SAYISI ──
 * MADDE 9(1)(b) ve (c), lisansüstü tez yönetmemiş ya da lisansüstü ders
 * vermemiş adaydan sırasıyla iki ve bir yayın FAZLA istiyor. Koşul dört
 * kombinasyonu açıkça yazan bir `veya` düğümüyle kuruldu: tez ve ders
 * varsa N, yalnız tez varsa N+1, yalnız ders varsa N+2, ikisi de yoksa
 * N+3 yayın.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 6: yabancı dil koşulu "Yükseköğretim Kurumlarında Yabancı Dil
 *       Öğretimi Yönetmeliği koşullarını sağlamak" biçiminde; sayısal
 *       bir puan vermediği için beyan olarak soruldu.
 *   MADDE 7(1)(c), 8(1)(b): deneme dersi ve öğrenci anketi.
 *   MADDE 8(1)(c): jüri önünde proje taslağı savunması.
 *   MADDE 5(4): eğiticilerin eğitimi belgesinin atama tarihinden
 *       itibaren iki yıl içinde tamamlanabilmesi.
 *   Profesörlükteki proje koşullarının "fon kuruluşuna başvurmuş ve
 *       projenin panele alınmış olması" telafisi — kayıt başvurusu
 *       reddedilmiş projeleri taşımıyor, beyan olarak soruldu.
 *   Hukuk profesörlüğünde "en fazla üç yazarlı makale" ve "en az ikisi
 *       tek yazarlı" koşullarının yazar sayısı kısmı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/yeditepe-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Yeditepe Üniversitesi';
$CETVEL = 'yeditepe-2024';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;

$WOS_AD = 'SCI, SCI-Expanded, SSCI, AHCI kapsamındaki ya da Q1, Q2, Q3 kategorisindeki dergilerde';
$Q1_AD = 'Q1 kategorisindeki dergilerde';
$Q1Q2_AD = 'Q1 veya Q2 kategorisindeki dergilerde';
$Q2Q3_AD = 'Q2 veya Q3 kategorisindeki dergilerde';

$dil = Kalip::beyan(
    'Yükseköğretim Kurumlarında Yabancı Dil Öğretimi ve Yabancı Dille Öğretim Yapılmasında '
    .'Uyulacak Esaslara İlişkin Yönetmelikteki yabancı dil koşullarını sağlamak',
    '6',
);
$egiticiEgitimi = Kalip::beyan(
    'Eğiticilerin eğitimi belgesine sahip olmak (bu eğitimi almamış öğretim üyelerinin atama '
    .'tarihinden itibaren iki yıl içinde tamamlaması gerekir)',
    '5-4',
);
$denemeDersi = Kalip::beyan(
    'İlgili alanda ve eğitim vereceğiniz dilde, öğrencilere ve öğretim elemanlarına açık olarak '
    .'yapılacak deneme dersinde jüri tarafından başarılı bulunmak',
    '7-1-c',
);

$esikler = [];

/**
 * @param  list<string>  $alanlar
 * @param  list<array<string, mixed>>  $ekKosullar
 * @return array<string, mixed>
 */
$drEsigi = function (string $anahtar, string $birim, array $alanlar, array $ekKosullar, string $notlar, string $ekNot = '') use ($UNIVERSITE, $CETVEL, $dil, $egiticiEgitimi, $denemeDersi): array {
    return [
        'anahtar' => "yeditepe-{$anahtar}-dr",
        'aday_notu' => "{$birim} bünyesindeki doktor öğretim üyesi kadrolarına atanma koşulları. "
            .'Doktora, sanatta yeterlik ya da tıpta/diş hekimliğinde/eczacılıkta uzmanlık '
            .'unvanına sahip olmanız, ilgili alanda ve eğitim vereceğiniz dilde bir deneme '
            .'dersinden başarılı olmanız ve eğiticilerin eğitimi belgesine sahip olmanız '
            .'gerekiyor. Editöre mektup, özet ve kitap kritiği türü yazılar yayın sayısına '
            .'katılmıyor.'.$ekNot,
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => $CETVEL,
        'notlar' => $notlar,
        'sart' => Kalip::ve("Doktor Öğretim Üyesi kadrosuna atanma — {$birim}", array_values([
            Kalip::beyan(
                'Doktora, sanatta yeterlik ya da tıpta, diş hekimliğinde veya eczacılıkta '
                .'uzmanlık unvanına sahip olmak',
                '7-1-a',
            ),
            $dil,
            $egiticiEgitimi,
            $denemeDersi,
            ...$ekKosullar,
        ])),
    ];
};

$wosBir = fn (string $md) => Kalip::adet(
    'SCI, SCI-Expanded, SSCI, AHCI kapsamındaki ya da Q1, Q2, Q3 kategorisindeki dergilerde en '
    .'az 1 yayınınızın olması',
    ['WOS'], 1, madde: $md,
);

$esikler[] = $drEsigi('bilgisayar', 'Bilgisayar ve Bilişim Bilimleri Fakültesi',
    ['fen', 'sosyal', 'muhendislik'],
    [Kalip::adet('Q1, Q2 veya Q3 kategorisindeki dergilerde en az 1 yayınınızın olması', ['Q1-Q3'], 1, madde: '7-2-a')],
    'MADDE 7(2)(a): Q1, Q2 veya Q3 kategorisinde en az 1 yayın.');

$disEczaKosul = [
    Kalip::adet(
        'Doktora tezinizi yayımlamış olmak (bu çalışmayı "tez yayını" olarak kaydedin)',
        ['TEZ-YAYINI'], 1, madde: '7-2-b-1',
    ),
    Kalip::adet(
        'Doktora çalışmanız haricinde SCI, SCI-Expanded, SSCI, AHCI kapsamındaki ya da Q1, Q2, '
        .'Q3 kategorisindeki dergilerde en az 1 yayınınızın olması',
        ['WOS'], 1, madde: '7-2-b-2',
    ),
    Kalip::adet(
        'Alanınızla ilgili ulusal ya da uluslararası en az bir kongrede sözlü sunum yapmış olmak',
        ['BILDIRI-SOZLU'], 1, madde: '7-2-b-3',
    ),
];

$esikler[] = $drEsigi('dis-hekimligi', 'Diş Hekimliği Fakültesi', ['saglik'], $disEczaKosul,
    'MADDE 7(2)(b): doktora tezinin yayımlanması, tez dışında WoS/Q1-Q3\'te 1 yayın, kongrede '
    .'sözlü sunum.');
$esikler[] = $drEsigi('eczacilik', 'Eczacılık Fakültesi', ['saglik'], $disEczaKosul,
    'MADDE 7(2)(c): doktora tezinin yayımlanması, tez dışında WoS/Q1-Q3\'te 1 yayın, kongrede '
    .'sözlü sunum.');

$esikler[] = $drEsigi('egitim', 'Eğitim Fakültesi', ['egitim'],
    [Kalip::veya('Yayın koşullarından biri', [
        $wosBir('7-2-ç'),
        Kalip::adet(
            'ERIC, British Education Index ya da ULAKBİM gibi alan indeksli dergilerde en az 1 '
            .'yayınınızın olması',
            ['ALAN-INDEKS', 'TR-DIZIN'], 1, madde: '7-2-ç',
        ),
    ])],
    'MADDE 7(2)(ç): WoS/Q1-Q3\'te 1 yayın veya alan indeksli (ERIC, BEI, ULAKBİM) dergide 1 yayın.');

$esikler[] = $drEsigi('fen-edebiyat', 'Fen-Edebiyat Fakültesi', ['fen', 'filoloji', 'sosyal'],
    [$wosBir('7-2-d')],
    'MADDE 7(2)(d): ayrı kriter belirtilmeyen bölümlerde WoS/Q1-Q3\'te 1 yayın.',
    ' Çeviribilimi, Fizik, İngiliz Dili ve Edebiyatı, Matematik, Psikoloji, Rus Dili ve '
    .'Edebiyatı ile Türk Dili ve Edebiyatı bölümlerinde yönerge ayrı ve çoğunlukla daha esnek '
    .'seçenekler tanıyor (uluslararası veri tabanında bir ve ulusal hakemli dergide bir yayın; '
    .'TR Dizinde iki yayın; alan indeksli dergilerde iki yayın gibi). Motor bölüm ayrımı '
    .'yapmadığı için fakültenin genel kuralı uygulanıyor; bu bölümlerden başvuruyorsanız koşul '
    .'burada göründüğünden esnektir.');

$esikler[] = $drEsigi('guzel-sanatlar', 'Güzel Sanatlar Fakültesi', ['guzel_sanatlar'],
    [
        Kalip::adet(
            'Alanınızla ilgili bir sempozyum ya da kongrede sözlü sunum yapmış olmak',
            ['BILDIRI-SOZLU'], 1, madde: '7-2-e-1',
        ),
        Kalip::veya('Program türüne göre yayın veya etkinlik koşulu', [
            Kalip::ve('Özel yetenek sınavıyla öğrenci alan programlar', [
                Kalip::adet(
                    'Kataloglanmış (basılı ya da dijital) en az bir kişisel etkinliğinizin olması',
                    ['SANAT-KISISEL'], 1, madde: '7-2-e-2-1',
                ),
                Kalip::veya('Yayın koşulu', [
                    Kalip::adet(
                        'Alan indeksli dergilerde uluslararası bir yayınınızın olması',
                        ['ALAN-INDEKS'], 1, madde: '7-2-e-2-2',
                    ),
                    Kalip::adet(
                        'Alan indeksli ulusal dergilerde iki yayınınızın olması',
                        ['TR-DIZIN'], 2, madde: '7-2-e-2-2',
                    ),
                ]),
            ]),
            Kalip::ve('Merkezi yerleştirme puanıyla öğrenci alan programlar', [
                $wosBir('7-2-e-3'),
            ]),
        ]),
    ],
    'MADDE 7(2)(e): sempozyumda sözlü sunum; özel yetenek programlarında kişisel etkinlik + alan '
    .'indeksli yayın, merkezi yerleştirme programlarında WoS/Q1-Q3\'te 1 yayın.');

$esikler[] = $drEsigi('hukuk', 'Hukuk Fakültesi', ['hukuk'],
    [Kalip::veya('Yayın koşullarından biri', [
        $wosBir('7-2-f'),
        Kalip::adet(
            'ULAKBİM tarafından taranan ulusal hakemli dergilerde en az iki tek yazarlı '
            .'yayınınızın olması',
            ['TR-DIZIN'], 2, 'tek', madde: '7-2-f',
        ),
    ])],
    'MADDE 7(2)(f): WoS/Q1-Q3\'te 1 yayın veya ULAKBİM\'de 2 tek yazarlı yayın.');

$esikler[] = $drEsigi('iibf', 'İktisadi ve İdari Bilimler Fakültesi', ['sosyal'],
    [$wosBir('7-2-g')], 'MADDE 7(2)(g): WoS/Q1-Q3\'te 1 yayın.');

$esikler[] = $drEsigi('iletisim', 'İletişim Fakültesi', ['sosyal'],
    [
        Kalip::veya('Yayın koşullarından biri', [
            $wosBir('7-2-ğ'),
            Kalip::adet(
                'Alan indeksli uluslararası dergilerde iki yayınınızın olması',
                ['ALAN-INDEKS'], 2, madde: '7-2-ğ',
            ),
        ]),
        Kalip::beyan(
            'Bir yükseköğretim kurumunda ilgili bilim alanında en az bir akademik dönem '
            .'eğitim-öğretim faaliyetinde bulunmuş olmak',
            '7-2-ğ-3',
        ),
    ],
    'MADDE 7(2)(ğ): WoS/Q1-Q3\'te 1 yayın veya alan indeksli uluslararası 2 yayın; bir akademik '
    .'dönem eğitim-öğretim faaliyeti.');

$esikler[] = $drEsigi('mimarlik', 'Mimarlık Fakültesi', ['mimarlik'],
    [Kalip::veya('Yayın koşullarından biri', [
        $wosBir('7-2-h'),
        Kalip::adet('TR Dizin kapsamındaki dergilerde iki yayınınızın olması', ['TR-DIZIN'], 2, madde: '7-2-h'),
    ])],
    'MADDE 7(2)(h): WoS/Q1-Q3\'te 1 yayın veya TR Dizinde 2 yayın.');

$esikler[] = $drEsigi('muhendislik', 'Mühendislik Fakültesi ve Meslek Yüksekokulu', ['muhendislik'],
    [
        Kalip::adet(
            'Doktora çalışmanız dışında SCI-Expanded kapsamındaki ya da Q1, Q2, Q3 '
            .'kategorisindeki dergilerde en az 1 yayınınızın olması',
            ['WOS'], 1, madde: '7-2-ı-1',
        ),
        Kalip::adet(
            'Doktora tezinizden üretilmiş, SCI-Expanded kapsamındaki ya da Q1, Q2 '
            .'kategorisindeki dergilerde en az 1 yayınınızın olması (bu çalışmayı "tez yayını" '
            .'olarak kaydedin)',
            ['TEZ-YAYINI-WOS'], 1, madde: '7-2-ı-2',
        ),
    ],
    'MADDE 7(2)(ı): tez dışında SCI-E/Q1-Q3\'te 1 yayın; tezden üretilmiş SCI-E/Q1-Q2\'de 1 yayın.');

$esikler[] = $drEsigi('saglik-bilimleri', 'Sağlık Bilimleri Fakültesi', ['saglik'],
    [$wosBir('7-2-i')], 'MADDE 7(2)(i): WoS/Q1-Q3\'te 1 yayın.');
$esikler[] = $drEsigi('tip', 'Tıp Fakültesi', ['saglik'],
    [$wosBir('7-2-j')], 'MADDE 7(2)(j): WoS/Q1-Q3\'te 1 yayın.');

// ══════════════════════════════════════════════════════════════════════════
// DOÇENT (MADDE 8)
// ══════════════════════════════════════════════════════════════════════════

/**
 * @param  list<string>  $alanlar
 * @param  list<array<string, mixed>>  $ekKosullar
 * @return array<string, mixed>
 */
$docentEsigi = function (string $anahtar, string $birim, array $alanlar, array $ekKosullar, string $notlar, string $ekNot = '') use ($UNIVERSITE, $CETVEL, $dil, $egiticiEgitimi): array {
    return [
        'anahtar' => "yeditepe-{$anahtar}-docentlik",
        'aday_notu' => "{$birim} bünyesindeki doçent kadrolarına atanma koşulları. ÜAK "
            .'tarafından verilen doçentlik unvanına sahip olmanız, beş kişilik jüri önünde '
            .'eğitim vereceğiniz dilde bir deneme dersinden başarılı olmanız ve TÜBİTAK, TÜSEB '
            .'gibi fon kuruluşlarına uygun formatta bir proje taslağı sunup jüri önünde '
            .'savunmanız gerekiyor. Editöre mektup, özet ve kitap kritiği türü yazılar yayın '
            .'sayısına katılmıyor.'.$ekNot,
        'universite' => $UNIVERSITE,
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => $CETVEL,
        'notlar' => $notlar,
        'sart' => Kalip::ve("Doçent kadrosuna atanma — {$birim}", array_values([
            Kalip::beyan('Üniversitelerarası Kurul tarafından verilen doçentlik unvanını almış olmak', '8-1-a'),
            $dil,
            $egiticiEgitimi,
            Kalip::beyan(
                'Beş kişilik jüri önünde, eğitim vereceğiniz dilde yapılacak deneme dersinden '
                .'başarılı olmak',
                '8-1-b',
            ),
            Kalip::beyan(
                'Ulusal ya da uluslararası fon sağlayan kuruluşlara uygun formatta bir proje ya '
                .'da özgün çalışma taslağı sunmak ve jüri önünde savunmak',
                '8-1-c',
            ),
            ...$ekKosullar,
        ])),
    ];
};

$q1VeyaQ2Q3 = fn (string $md) => Kalip::veya('Yayın koşullarından biri', [
    Kalip::adet('Q1 kategorisindeki dergilerde bir yayınınızın olması', ['Q1'], 1, madde: $md),
    Kalip::adet('Q2 veya Q3 kategorisindeki dergilerde en az iki yayınınızın olması', ['Q2-Q3'], 2, madde: $md),
]);

$esikler[] = $docentEsigi('bilgisayar', 'Bilgisayar ve Bilişim Bilimleri Fakültesi',
    ['fen', 'sosyal', 'muhendislik'], [$q1VeyaQ2Q3('8-2-a')],
    'MADDE 8(2)(a): Q1\'de 1 yayın veya Q2-Q3\'te 2 yayın.');

$esikler[] = $docentEsigi('dis-hekimligi', 'Diş Hekimliği Fakültesi', ['saglik'],
    [Kalip::metrik(
        'Doktora sonrası dönemde bir üniversitede ilgili bilim alanında en az dört akademik yıl '
        .'eğitim-öğretim faaliyetinde bulunmuş olmak',
        'ders_yariyil', 8, $DOKTORA,
    )],
    'MADDE 8(2)(b): doktora sonrası en az 4 akademik yıl eğitim-öğretim; `ders_yariyil` '
    .'metriğinde 8 yarıyıl olarak yazıldı.');

$esikler[] = $docentEsigi('eczacilik', 'Eczacılık Fakültesi', ['saglik'],
    [Kalip::adet(
        'Alanınızla ilgili uluslararası en az bir kongrede sözlü sunum yapmış olmak',
        ['BILDIRI-ULUSLARARASI'], 1, madde: '8-2-c',
    )],
    'MADDE 8(2)(c): uluslararası kongrede sözlü sunum.');

$esikler[] = $docentEsigi('egitim', 'Eğitim Fakültesi', ['egitim'],
    [
        Kalip::adet(
            'Lisansüstü tezlerinizden üretilmemiş olmak kaydıyla SCI, SCI-Expanded, SSCI ya da '
            .'AHCI kapsamındaki Q1, Q2 veya Q3 kategorisindeki dergilerde en az 1 yayınınızın olması',
            ['Q1-Q3'], 1, madde: '8-2-ç-1',
        ),
        Kalip::adet(
            'ERIC ya da British Education Index gibi uluslararası alan endekslerinde taranan '
            .'dergilerde en az 1 yayınınızın olması',
            ['ALAN-INDEKS'], 1, madde: '8-2-ç-2',
        ),
        Kalip::adet(
            'ULAKBİM tarafından taranan ulusal hakemli dergilerde en az 1 yayınınızın olması',
            ['TR-DIZIN'], 1, madde: '8-2-ç-3',
        ),
    ],
    'MADDE 8(2)(ç): Q1-Q3\'te 1 yayın (tezden üretilmemiş), alan endeksinde 1, ULAKBİM\'de 1.');

$esikler[] = $docentEsigi('fen-edebiyat', 'Fen-Edebiyat Fakültesi', ['fen', 'filoloji', 'sosyal'],
    [],
    'MADDE 8(2)(d): ayrı kriter belirtilmeyen bölümlerde MADDE 8(1)(ç) uygulanmaz; yayın şartı yok.',
    ' Fakültenin ayrı kriter belirtilmeyen bölümlerinde yönerge ek yayın şartı aramıyor. '
    .'Çeviribilimi, İngiliz Dili ve Edebiyatı, Psikoloji ile Türk Dili ve Edebiyatı '
    .'bölümlerinde ise ayrı ve daha ağır yayın koşulları var (Q1\'de bir yayın; Q2-Q4\'te iki '
    .'yayın; Q2-Q4\'te bir yayın ve diğer uluslararası indekslerde iki yayın; Psikolojide ayrıca '
    .'iki lisansüstü tez danışmanlığı; Türk Dili ve Edebiyatında doktora sonrası biri başlıca '
    .'eser olmak üzere üç yayın gibi). Motor bölüm ayrımı yapmadığı için bu koşullar burada '
    .'görünmüyor; bu bölümlerden başvuruyorsanız koşullar burada göründüğünden ağırdır.');

$esikler[] = $docentEsigi('guzel-sanatlar', 'Güzel Sanatlar Fakültesi', ['guzel_sanatlar'],
    [
        Kalip::adet(
            'Alanınızla ilgili bir sempozyum ya da kongrede sözlü sunum yapmış olmak',
            ['BILDIRI-SOZLU'], 1, madde: '8-2-e-1',
        ),
        Kalip::veya('Program türüne göre etkinlik veya yayın koşulu', [
            Kalip::adet(
                'Doktora ya da sanatta yeterlik sonrası dönemde kataloglanmış en az bir kişisel '
                .'etkinlik yapmış olmak',
                ['SANAT-KISISEL'], 1, donem: $DOKTORA, madde: '8-2-e-2',
            ),
            Kalip::adet(
                'SCI, SCI-Expanded, SSCI, AHCI kapsamındaki ya da Q1, Q2, Q3 kategorisindeki '
                .'dergilerde en az 1 yayınınızın olması',
                ['WOS'], 1, madde: '8-2-e-2',
            ),
            Kalip::adet(
                'SCI, SCI-Expanded, SSCI, AHCI kapsamındaki ya da Q1, Q2, Q3 kategorisindeki '
                .'dergilerde en az 2 yayınınızın olması',
                ['WOS'], 2, madde: '8-2-e-3',
            ),
        ]),
    ],
    'MADDE 8(2)(e): sempozyumda sözlü sunum; özel yetenek programlarında kişisel etkinlik veya '
    .'WoS/Q1-Q3\'te 1 yayın, merkezi yerleştirme programlarında WoS/Q1-Q3\'te 2 yayın.');

$esikler[] = $docentEsigi('iibf', 'İktisadi ve İdari Bilimler Fakültesi', ['sosyal'],
    [$q1VeyaQ2Q3('8-2-f')],
    'MADDE 8(2)(f): Q1\'de 1 yayın veya Q2-Q3\'te 2 yayın.');

$esikler[] = $docentEsigi('iletisim', 'İletişim Fakültesi', ['sosyal'],
    [
        Kalip::adet(
            'SCI, SCI-Expanded, SSCI, AHCI kapsamındaki ya da Q1, Q2, Q3 kategorisindeki '
            .'dergilerde en az 2 yayınınızın olması',
            ['WOS'], 2, madde: '8-2-g-1',
        ),
        Kalip::metrik(
            'Doktora sonrası dönemde bir üniversitede ilgili bilim alanında en az üç akademik yıl '
            .'eğitim-öğretim faaliyetinde bulunmuş olmak',
            'ders_yariyil', 6, $DOKTORA,
        ),
    ],
    'MADDE 8(2)(g): WoS/Q1-Q3\'te 2 yayın; doktora sonrası en az 3 akademik yıl eğitim-öğretim '
    .'(6 yarıyıl).');

$esikler[] = $docentEsigi('mimarlik', 'Mimarlık Fakültesi', ['mimarlik'],
    [$q1VeyaQ2Q3('8-2-ğ')],
    'MADDE 8(2)(ğ): Q1\'de 1 yayın veya Q2-Q3\'te 2 yayın.');

$docentEkYok = 'MADDE 8(2)\'de bu fakülte için ek koşul belirtilmemiş; yalnız MADDE 8(1) '
    .'koşulları uygulanır.';
$docentEkYokNot = ' Yönerge bu fakülte için MADDE 8(2)\'de ayrı bir yayın koşulu belirtmiyor; '
    .'yalnız doçentlik unvanı, deneme dersi ve proje savunması aranıyor.';

$esikler[] = $docentEsigi('hukuk', 'Hukuk Fakültesi', ['hukuk'], [], $docentEkYok, $docentEkYokNot);
$esikler[] = $docentEsigi('muhendislik', 'Mühendislik Fakültesi ve Meslek Yüksekokulu',
    ['muhendislik'], [], $docentEkYok, $docentEkYokNot);
$esikler[] = $docentEsigi('saglik-bilimleri', 'Sağlık Bilimleri Fakültesi', ['saglik'], [],
    $docentEkYok, $docentEkYokNot);
$esikler[] = $docentEsigi('tip', 'Tıp Fakültesi', ['saglik'], [], $docentEkYok, $docentEkYokNot);

// ══════════════════════════════════════════════════════════════════════════
// PROFESÖR (MADDE 9)
// ══════════════════════════════════════════════════════════════════════════

/**
 * MADDE 9(1)(a)-(b)-(c): temel yayın sayısı N; lisansüstü tez yönetmemiş
 * adaydan iki, lisansüstü ders vermemiş adaydan bir yayın FAZLA isteniyor.
 * Dört kombinasyon açıkça yazıldı.
 *
 * @param  list<string>  $grup
 * @return array<string, mixed>
 */
$yayinTezDers = function (int $n, array $grup, string $grupAdi): array {
    $yayin = fn (int $sayi) => Kalip::adet(
        "Doçent unvanınızı aldıktan sonra {$grupAdi} en az {$sayi} yayınınızın olması",
        array_values($grup), $sayi, donem: Kalip::DOCENTLIK_SONRASI, madde: '9-1-a',
    );
    $tez = Kalip::adet(
        'Kendi alanınızda en az bir lisansüstü tez yönetmiş ve tamamlamış olmak',
        ['TEZ-DANISMANLIK'], 1, madde: '9-1-b',
    );
    $ders = Kalip::adet(
        'Lisansüstü ders vermiş olmak ya da en az bir yıl süreyle tıpta uzmanlık öğrencisi '
        .'eğitimine katılmış olmak',
        ['LISANSUSTU-DERS'], 1, madde: '9-1-c',
    );

    return Kalip::veya('Yayın, tez danışmanlığı ve ders koşullarının birleşimi', [
        Kalip::ve('Tez ve ders koşulu sağlanıyor', [$tez, $ders, $yayin($n)]),
        Kalip::ve('Yalnız tez koşulu sağlanıyor', [$tez, $yayin($n + 1)]),
        Kalip::ve('Yalnız ders koşulu sağlanıyor', [$ders, $yayin($n + 2)]),
        $yayin($n + 3),
    ]);
};

/**
 * @param  list<string>  $alanlar
 * @param  list<array<string, mixed>>  $ekKosullar
 * @return array<string, mixed>
 */
$profEsigi = function (string $anahtar, string $birim, array $alanlar, array $kosullar, string $notlar, string $ekNot = '') use ($UNIVERSITE, $CETVEL, $dil, $egiticiEgitimi): array {
    return [
        'anahtar' => "yeditepe-{$anahtar}-profesorluk",
        'aday_notu' => "{$birim} bünyesindeki profesör kadrolarına yükseltilme koşulları. "
            .'Yayın koşullarının tamamı DOÇENT unvanınızı aldıktan sonraki çalışmalardan '
            .'sağlanmalı. Yönerge, lisansüstü tez yönetmemiş adaydan iki, lisansüstü ders '
            .'vermemiş adaydan bir yayın FAZLA istiyor; motor bu telafiyi hesaba katıyor. '
            .'Editöre mektup, özet ve kitap kritiği türü yazılar yayın sayısına '
            .'katılmıyor.'.$ekNot,
        'universite' => $UNIVERSITE,
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => $CETVEL,
        'notlar' => $notlar,
        'sart' => Kalip::ve("Profesörlüğe yükseltilme — {$birim}", array_values([
            $dil,
            $egiticiEgitimi,
            ...$kosullar,
        ])),
    ];
};

$projeKosulu = fn (string $md, int $arastirmaciSayisi) => Kalip::veya('Proje koşullarından biri', [
    Kalip::adet(
        'Doçent unvanınızı aldıktan sonra ulusal ya da uluslararası kurumlarca desteklenen en az '
        .'bir projede yürütücü olarak görev yapmış olmak',
        ['PROJE-YURUTUCU'], 1, donem: Kalip::DOCENTLIK_SONRASI, madde: $md,
    ),
    Kalip::adet(
        'Doçent unvanınızı aldıktan sonra ulusal ya da uluslararası kurumlarca desteklenen en az '
        ."{$arastirmaciSayisi} projede araştırmacı olarak görev yapmış olmak",
        ['PROJE-ARASTIRMACI'], $arastirmaciSayisi, donem: Kalip::DOCENTLIK_SONRASI, madde: $md,
    ),
    Kalip::beyan(
        'Ulusal ya da uluslararası fon kuruluşlarına yürütücü olarak proje başvurusu yapmış '
        .'olmak, projenin panele ya da dış danışman değerlendirmesine alınmış olması ve Proje '
        .'Önerisi Bilimsel Değerlendirme Raporunu başvuruda sunmak',
        $md,
    ),
]);

$esikler[] = $profEsigi('bilgisayar', 'Bilgisayar ve Bilişim Bilimleri Fakültesi',
    ['fen', 'sosyal', 'muhendislik'],
    [$yayinTezDers(1, ['Q1-Q2'], $Q1Q2_AD)],
    'MADDE 9(2)(a): 9(1)(a) doçentlik sonrası Q1-Q2\'de en az 1 yayın olarak uygulanır.');

$esikler[] = $profEsigi('dis-hekimligi', 'Diş Hekimliği Fakültesi', ['saglik'],
    [
        $yayinTezDers(3, ['WOS'], $WOS_AD),
        Kalip::adet('Bu yayınlardan en az birinin Q1 kategorisindeki bir dergide olması', ['Q1'], 1, donem: $DOCENTLIK, madde: '9-2-b-1'),
        $projeKosulu('9-2-b-2', 2),
    ],
    'MADDE 9(2)(b): üç yayından en az biri Q1; doçentlik sonrası proje koşulu.');

$esikler[] = $profEsigi('eczacilik', 'Eczacılık Fakültesi', ['saglik'],
    [
        $yayinTezDers(5, ['WOS'], $WOS_AD),
        Kalip::adet('Bu yayınlardan en az üçünün Q1 veya Q2 kategorisindeki dergilerde olması', ['Q1-Q2'], 3, donem: $DOCENTLIK, madde: '9-2-c-1'),
        $projeKosulu('9-2-c-2', 2),
    ],
    'MADDE 9(2)(c): toplam 5 yayın, en az 3\'ü Q1-Q2; doçentlik sonrası proje koşulu.');

$esikler[] = $profEsigi('egitim', 'Eğitim Fakültesi', ['egitim'],
    [
        $yayinTezDers(2, ['Q1-Q2'], $Q1Q2_AD),
        Kalip::adet('ULAKBİM tarafından taranan ulusal hakemli dergilerde en az 1 yayınınızın olması', ['TR-DIZIN'], 1, madde: '9-2-ç-2'),
    ],
    'MADDE 9(2)(ç): 9(1)(a) doçentlik sonrası Q1-Q2\'de 2 yayın olarak uygulanır; ULAKBİM\'de 1 yayın.');

$esikler[] = $profEsigi('fen-edebiyat', 'Fen-Edebiyat Fakültesi', ['fen', 'filoloji', 'sosyal'],
    [
        $yayinTezDers(3, ['WOS'], $WOS_AD),
        Kalip::adet('Bu yayınlardan en az birinin Q1 kategorisindeki bir dergide olması', ['Q1'], 1, donem: $DOCENTLIK, madde: '9-2-d'),
    ],
    'MADDE 9(2)(d): ayrı kriter belirtilmeyen bölümlerde üç yayından en az biri Q1.',
    ' Çeviribilimi, Felsefe, Fizik, İngiliz Dili ve Edebiyatı, Rus Dili ve Edebiyatı ile Türk '
    .'Dili ve Edebiyatı bölümlerinde yönerge ayrı yayın kombinasyonları tanımlıyor; motor bölüm '
    .'ayrımı yapmadığı için fakültenin genel kuralı uygulanıyor.');

$esikler[] = $profEsigi('guzel-sanatlar', 'Güzel Sanatlar Fakültesi', ['guzel_sanatlar'],
    [
        Kalip::veya('Yayın ya da sanatsal etkinlik koşulu', [
            $yayinTezDers(3, ['WOS'], $WOS_AD),
            Kalip::adet(
                'Özel yetenek sınavıyla öğrenci alan programlarda, doçent unvanınızı aldıktan '
                .'sonra kataloglanmış ya da gerçekleştirilmiş bir kişisel etkinlikte bulunmuş olmak',
                ['SANAT-KISISEL'], 1, donem: $DOCENTLIK, madde: '9-2-e-1',
            ),
            Kalip::adet(
                'Uluslararası jürili ya da seçici kurulu olan bir sergide eserinizin yer almış olması',
                ['SANAT-JURILI'], 1, donem: $DOCENTLIK, madde: '9-1-a',
            ),
        ]),
        Kalip::adet(
            'İlgili alanların lisans, yüksek lisans, doktora ya da sanatta yeterlik '
            .'programlarında kaynak olarak kullanılabilecek en az bir kitap yazmış olmak',
            ['KITAP-TEK'], 1, madde: '9-2-e-2',
        ),
    ],
    'MADDE 9(2)(e): özel yetenek programlarında kişisel etkinlik; uluslararası jürili sergide '
    .'eser; kaynak kitap yazarlığı.');

$esikler[] = $profEsigi('hukuk', 'Hukuk Fakültesi', ['hukuk'],
    [
        Kalip::beyan(
            'Doçent unvanınızı aldıktan sonra, lisansüstü tezlerinizden üretilmemiş, kendi '
            .'alanınızda ve akademik kriterlere uygun bilimsel monografik bir çalışma sunmuş olmak',
            '9-2-f-1',
        ),
        Kalip::adet(
            'Doçent unvanınızı aldıktan sonra uluslararası ya da ulusal endekslerce taranan '
            .'dergilerde en az 3 hakemli makale veya kitap bölümünüzün olması',
            ['HAKEMLI', 'KITAP'], 3, donem: $DOCENTLIK, madde: '9-2-f-2',
        ),
        Kalip::adet(
            'Bu çalışmalardan en az ikisinin tek yazarlı olması',
            ['HAKEMLI', 'KITAP'], 2, 'tek', $DOCENTLIK, madde: '9-2-f-2',
        ),
        Kalip::adet(
            'Kendi alanınızda en az bir lisansüstü tez yönetmiş ve tamamlamış olmak',
            ['TEZ-DANISMANLIK'], 1, madde: '9-1-b',
        ),
        Kalip::adet(
            'Lisansüstü ders vermiş olmak',
            ['LISANSUSTU-DERS'], 1, madde: '9-1-c',
        ),
    ],
    'MADDE 9(2)(f): 9(1)(a) monografik çalışma olarak uygulanır (beyan); doçentlik sonrası 3 '
    .'hakemli makale/kitap bölümü, en az 2\'si tek yazarlı.');

$esikler[] = $profEsigi('iibf', 'İktisadi ve İdari Bilimler Fakültesi', ['sosyal'],
    [
        Kalip::veya('Yayın koşullarından biri', [
            Kalip::ve('Q1 yayınlı seçenek', [
                $yayinTezDers(3, ['WOS'], $WOS_AD),
                Kalip::adet('Bu yayınlardan en az birinin Q1 kategorisindeki bir dergide olması', ['Q1'], 1, donem: $DOCENTLIK, madde: '9-2-ğ-1'),
            ]),
            $yayinTezDers(4, ['WOS'], $WOS_AD),
        ]),
        $projeKosulu('9-2-ğ-2', 1),
    ],
    'MADDE 9(2)(ğ): üç yayından en az biri Q1; sağlanamazsa dört yayın. Doçentlik sonrası proje '
    .'koşulu (yürütücü ya da araştırmacı).');

$esikler[] = $profEsigi('iletisim', 'İletişim Fakültesi', ['sosyal'],
    [$yayinTezDers(2, ['Q1-Q2'], $Q1Q2_AD)],
    'MADDE 9(2)(g): 9(1)(a) doçentlik sonrası Q1-Q2\'de 2 yayın olarak uygulanır.',
    ' Görsel İletişim Tasarımı bölümünde Q1-Q2\'de bir yayın ve kendi düzenlediğiniz iki kişisel '
    .'etkinlik de yeterli sayılıyor; motor bölüm ayrımı yapmadığı için bu seçenek burada '
    .'görünmüyor.');

$esikler[] = $profEsigi('mimarlik', 'Mimarlık Fakültesi', ['mimarlik'],
    [
        $yayinTezDers(3, ['WOS'], $WOS_AD),
        Kalip::adet('Bu yayınlardan en az birinin Q1 kategorisindeki bir dergide olması', ['Q1'], 1, donem: $DOCENTLIK, madde: '9-2-h-1'),
        $projeKosulu('9-2-h-2', 2),
    ],
    'MADDE 9(2)(h): üç yayından en az biri Q1; doçentlik sonrası proje koşulu.');

$esikler[] = $profEsigi('muhendislik', 'Mühendislik Fakültesi ve Meslek Yüksekokulu',
    ['muhendislik'],
    [$yayinTezDers(3, ['Q1-Q3'], 'SCI, SCI-Expanded, SSCI, AHCI kapsamındaki Q1, Q2 veya Q3 kategorisindeki dergilerde')],
    'MADDE 9(2)(ı): 9(1)(a) doçentlik sonrası WoS Q1-Q3\'te 3 yayın olarak uygulanır.');

$esikler[] = $profEsigi('saglik-bilimleri', 'Sağlık Bilimleri Fakültesi', ['saglik'],
    [$yayinTezDers(3, ['WOS'], $WOS_AD)],
    'MADDE 9(2)\'de bu fakülte için ek koşul yok; MADDE 9(1) genel koşulları uygulanır.');

$esikler[] = $profEsigi('tip', 'Tıp Fakültesi', ['saglik'],
    [$yayinTezDers(3, ['WOS'], $WOS_AD)],
    'MADDE 9(2)(i): 9(1)(b) sağlanamadığında 9(1)(a) kapsamında ilave bir yayın; genel telafi '
    .'kuralıyla aynı sonucu verdiği için ayrı yazılmadı.');

return $esikler;
