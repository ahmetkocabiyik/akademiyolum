<?php

/**
 * KAFKAS ÜNİVERSİTESİ — Akademik Yükseltme ve Atama Yönergesi
 * Kaynak: pdf/1767879369889.kafkas-kriter-08012026.pdf (69 sayfa; Senato
 * 08.12.2025 tarih ve 13/20 sayılı kararı)
 *
 * ── YAPI: ORTAK ÖLÇÜTLER + ON TEMEL ALAN ÖZEL ÖLÇÜTLERİ ──
 * Madde 6 bütün kadrolara ortak koşulları (dil, asgari puan, disiplinlerarası
 * bölüm kuralı) veriyor; "Temel Alanlara Göre Özel Ölçütler" bölümü ise on
 * temel alanın her biri için Dr. Öğretim Üyesi (ilk atanma ve yeniden
 * atanma), doçentlik ve profesörlük ölçütlerini ayrı ayrı sıralıyor.
 * Alan eşlemesi: `egitim`, `fen`, `filoloji`, `guzel_sanatlar`, `ilahiyat`,
 * `mimarlik`, `muhendislik`, `saglik`, `sosyal`, `spor`.
 * Yönerge hukuk ve ziraat temel alanlarını ANMIYOR; o iki alan kapsam dışı.
 *
 * ── TABLO 2: ASGARİ PUANLAR ──
 *   Dr. Öğretim Üyesi atanma 60 · yeniden atanma 50
 *   Doçent: doktora sonrası 120, toplam 200
 *   Profesör: doçentlik unvanı sonrası 140, toplam 280
 * Alan özel ölçütlerindeki alt barajlar (makale, atıf, bilimsel toplantı,
 * proje) bunun ÜSTÜNE geliyor.
 *
 * ── EĞİTİM-ÖĞRETİM KOŞULLARI YARIYIL SAYISINA ÇEVRİLDİ ──
 * Tabloların eğitim-öğretim bölümü puanı esere değil BLOĞA veriyor:
 * "Dönemlik programlarda dört farklı yarıyılda ders vermiş olmak — 3 puan".
 * 3 puan dört yarıyıla bölünemediği için cetvelde bu bölümün satırı yok
 * (bkz. cetvel başlığı). Alan ölçütlerinin "Eğitim-Öğretim Faaliyeti
 * kapsamında en az 2/4 puan" koşulları bu yüzden `Kalip::metrik` ile
 * yarıyıl sayısına çevrildi: 2 puan → 4 yarıyıl (bir blok), 4 puan → 8
 * yarıyıl (iki blok).
 *
 * ── "ADAYIN DOKTORA TEZİNDEN OLMAK KOŞULU İLE" ──
 * Kafkas'ın hiçbir tablosunda ayrı bir "lisansüstü tezlerden üretilmiş
 * yayın" bölümü yok; koşul yayının TEZDEN ÜRETİLMİŞ olmasını istiyor.
 * Cetvelde bunun için `tez_yayini` ayna satırları açıldı ve koşullar `TZ`
 * (bütün ayna satırlar) ile `TZ-M` (yalnızca makale aynaları) gruplarına
 * bağlandı. Yüksek lisans tezi ile doktora tezi kayıtta ayrılamadığı için
 * "Yüksek Lisans tezinden 1 puan" ve "Doktora tezinden 5 puan" koşulları
 * aynı kümeye düşüyor; ikisi de yazıldı, düşük olanı fiilen yüksek olanın
 * içinde kalıyor.
 *
 * ── DİL ŞARTI ──
 * Tablo 1 üç ayrı eşik veriyor: %100 Türkçe eğitim veren bölümlerde 60,
 * %30 veya %100 yabancı dilde eğitim veren bölümlerde ve bilim alanı
 * yabancı dille ilgili olan alanlarda 85 + yabancı dilde ders sunuşu.
 * Birimin eğitim dili profilde tutulmadığı için genel hâl olan 60 yazıldı;
 * yabancı dille eğitim veren bölüme başvuracak aday için eşik olduğundan
 * KOLAY görünür, aday notunda uyarıldı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde 6(1)(c), 6(3)(c) ve 6(4)(c): disiplinlerarası bölümlerde adayın
 *       doktora/doçentlik temel alanının koşullarının uygulanması — zaten
 *       alan seçimiyle çözülüyor.
 *   Madde 6(3)(f) doçentlikte "en az üç yıl öğretim elemanı olarak fiilen
 *       çalışmış olmak" ve Madde 6(4)(a) profesörlükte "yasal sürenin en az
 *       yarısı kadar çalışmış olmak" — `beyan`.
 *   Profesörlük ölçütlerindeki "en az bir doktora tezine danışmanlık
 *       YAPIYOR olmak" — devam eden danışmanlık kayıtta yok; yalnızca
 *       tamamlanmış tezler sayılıyor, koşul olduğundan ZOR görünür.
 *   Madde 7-9 (ön değerlendirme komisyonu, jüri, yeniden atanma
 *       sağlanamazsa uygulanacak süreç) — süreç kuralları.
 *   Madde 6(7): yağmacı/şaibeli dergi, DOI doğrulama ve Q değeri belirleme
 *       kuralları — belge kuralları.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/kafkas-2025.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Kafkas Üniversitesi';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$DIL_NOTU = ' DİKKAT: dil eşiği burada %100 Türkçe eğitim veren bölümler için geçerli olan 60 '
    .'puan üzerinden uygulanıyor; %30 veya %100 yabancı dilde eğitim veren bölümlerde ve bilim '
    .'alanı yabancı dille ilgili alanlarda yönerge 85 puan ve yabancı dilde ders sunuşu istiyor.';

$EO_NOTU = ' Eğitim-öğretim koşulu yönergede puanla veriliyor ("en az 2/4 puan") ama puan ders '
    .'başına değil "dört farklı yarıyılda ders vermiş olmak" bloğuna verildiği için burada '
    .'yarıyıl sayısına çevrildi.';

$dil = Kalip::yds(60);

$docentUnvani = Kalip::beyan('Üniversitelerarası Kurul tarafından verilen doçentlik unvanına sahip olmak', 'Madde 6(3)(a)');
$docentKidem = Kalip::beyan(
    'Doçent kadrosuna atanabilmek için en az üç yıl üniversitelerde öğretim elemanı ya da '
    .'bilimsel bir araştırma kuruluşunda doçentlik temel alanıyla ilgili fiilen çalışmış olmak',
    'Madde 6(3)(f)',
);
$profesorKidem = Kalip::beyan(
    'Doçentlik unvanını aldıktan sonra gerekli yasal sürenin en az yarısı kadar üniversitelerde '
    .'öğretim elemanı ya da bilimsel bir araştırma kuruluşunda doçentlik temel alanıyla ilgili '
    .'fiilen çalışmış olmak',
    'Madde 6(4)(a)',
);
$baslicaEser = Kalip::beyan('Başvurunuzda yayınlarınızdan birini başlıca araştırma eseri olarak göstermek', 'Profesörlük özel ölçütleri');

/** Eğitim-öğretim barajının yarıyıl karşılığı. */
$ders = fn (int $puan): array => Kalip::metrik(
    "Eğitim öğretim faaliyeti koşulu: en az {$puan} puan (dört farklı yarıyılda ders vermiş olmak "
    .($puan >= 4 ? 'iki bloğu, yani en az 8 yarıyıl' : 'bir bloğu, yani en az 4 yarıyıl').')',
    'ders_yariyil', $puan >= 4 ? 8 : 4,
);

/**
 * Profesörlük ölçütlerinin "aşağıdaki şartlardan en az birini yerine
 * getirmiş olmak" bloğu.
 */
$profSart = fn (int $projePuani, string $makaleGrubu, int $makaleSayisi): array => Kalip::veya(
    'Aşağıdaki şartlardan en az birini sağlamalısınız', [
        Kalip::veya('Lisansüstü tez danışmanlığı', [
            Kalip::adet('En az 1 doktora tezinde asıl danışmanlık', ['TD-a'], 1),
            Kalip::adet('Ya da en az 2 doktora tezinde eş danışmanlık', ['TD-a-es'], 2),
            Kalip::adet('Ya da en az 3 yüksek lisans tezinde danışmanlık', ['TD-b', 'TD-b-es'], 3),
        ]),
        Kalip::ve('Doçentlik sonrası proje yürütücülüğü', [
            Kalip::metrik('Doçentlik unvanından sonra en az bir projede yürütücülük yapmak', 'proje_yurutuculuk', 1, Kalip::DOCENTLIK_SONRASI),
            Kalip::puanDan("Bilimsel araştırma projesi kalemlerinizden en az {$projePuani} puan", ['BAP'], $projePuani, Kalip::DOCENTLIK_SONRASI),
        ]),
        Kalip::adet(
            "Ya da makale kalemlerinizden {$makaleSayisi} eserde başlıca yazar olmak",
            [$makaleGrubu], $makaleSayisi, yazar: 'baslica',
        ),
    ],
);

/**
 * Bir alanın dört kadrosunu üretir.
 *
 * @param  array<string, list<array<string, mixed>>>  $kosullar  kadro → düğümler
 * @return list<array<string, mixed>>
 */
$alanEsikleri = function (string $alan, string $alanAdi, array $kosullar) use (
    $UNIVERSITE, $DOKTORA, $DOCENTLIK, $SON_ATAMA, $dil, $docentUnvani, $docentKidem,
    $profesorKidem, $DIL_NOTU, $EO_NOTU,
): array {
    $cerceve = [
        'dr_ogr_uyesi' => [
            'ad' => 'Doktor Öğretim Üyesi kadrosuna atanma',
            'on' => [$dil],
            'son' => [Kalip::toplam(60)],
            'not' => 'Tablo 2 uyarınca toplam en az 60 puan gerekiyor.',
        ],
        'dr_ogr_uyesi_yeniden' => [
            'ad' => 'Doktor Öğretim Üyeliğine yeniden atanma',
            'on' => [],
            'son' => [Kalip::toplam(50, $SON_ATAMA)],
            'not' => 'Bir önceki atama tarihinizden itibaren yaptığınız çalışmalar sayılıyor; '
                .'Tablo 2 uyarınca toplam en az 50 puan gerekiyor. Asgari puanı tamamlayanlar '
                .'dört yıl süreyle yeniden atanır.',
        ],
        'docentlik' => [
            'ad' => 'Doçent kadrosuna atanma',
            'on' => [$dil, $docentUnvani, $docentKidem],
            'son' => [
                Kalip::toplam(120, $DOKTORA, ['*'], 'Başvuru Şartları Tablosunun tamamı (doktora sonrası)'),
                Kalip::toplam(200),
            ],
            'not' => 'Tablo 2 uyarınca toplam en az 200 puan ve bunun en az 120 puanının doktora '
                .'unvanınızı aldıktan sonraki çalışmalardan gelmesi gerekiyor.',
        ],
        'profesorluk' => [
            'ad' => 'Profesör kadrosuna atanma',
            'on' => [$dil, $profesorKidem],
            'son' => [
                Kalip::toplam(140, $DOCENTLIK, ['*'], 'Başvuru Şartları Tablosunun tamamı (doçentlik sonrası)'),
                Kalip::toplam(280),
            ],
            'not' => 'Doçentlik unvanınızı aldıktan sonraki çalışmalarınız sayılıyor. Tablo 2 '
                .'uyarınca toplam en az 280 puan ve bunun en az 140 puanının doçentlik sonrası '
                .'çalışmalardan gelmesi gerekiyor.',
        ],
    ];

    $uretilen = [];

    foreach ($cerceve as $kadro => $c) {
        $uretilen[] = [
            'anahtar' => "kafkas-{$alan}-".str_replace('_', '-', $kadro),
            'aday_notu' => "{$alanAdi} özel ölçütleri uygulanıyor. {$c['not']}".$DIL_NOTU.$EO_NOTU,
            'universite' => $UNIVERSITE,
            'kadro' => $kadro,
            'alan' => [$alan],
            'cetvel' => "kafkas-2025-{$alan}",
            'notlar' => "{$alanAdi} özel ölçütleri (Temel Alanlara Göre Özel Ölçütler) ve Madde 6 "
                .'ortak ölçütleri; asgari puanlar Tablo 2.',
            'sart' => Kalip::ve("{$c['ad']} — {$alanAdi}", array_values(array_merge(
                $c['on'], $kosullar[$kadro], $c['son'],
            ))),
        ];
    }

    return $uretilen;
};

// ── Kısayollar: bütün alan ölçütleri aynı beş kalıptan kuruluyor ──

/** Makale bölümünden puan barajı. */
$mP = fn (string $grup, int $puan, ?array $donem, string $md, string $ad = 'Makale'): array => Kalip::puanDan(
    "{$ad} kalemlerinizden en az {$puan} puan", [$grup], $puan, $donem, madde: $md,
);

/** Makale bölümünde başlıca yazarlık. */
$mB = fn (string $grup, int $sayi, ?array $donem, string $md, string $ad = 'makale'): array => Kalip::adet(
    "Bu {$ad}lerden en az {$sayi} tanesinde başlıca yazar olmalısınız", [$grup], $sayi,
    yazar: 'baslica', donem: $donem, madde: $md,
);

/** Bilimsel toplantı bölümünden puan barajı. */
$btP = fn (int $puan, ?array $donem, string $md): array => Kalip::puanDan(
    "Bilimsel toplantı kalemlerinizden en az {$puan} puan (tam metni yayımlanmış sözlü bildiri)",
    ['BT'], $puan, $donem, madde: $md,
);

/** Bilimsel toplantı bölümünde başlıca yazarlık. */
$btB = fn (int $sayi, ?array $donem, string $md): array => Kalip::adet(
    "Bu bildirilerden en az {$sayi} tanesinde başlıca yazar olmalısınız", ['BT'], $sayi,
    yazar: 'baslica', donem: $donem, madde: $md,
);

/**
 * Atıf bölümünden puan barajı.
 *
 * @param  list<string>  $grup
 */
$atP = fn (int $puan, ?array $donem, string $md, array $grup = ['AT']): array => Kalip::puanDan(
    "Atıf kalemlerinizden en az {$puan} puan", array_values($grup), $puan, $donem, madde: $md,
);

/** "Projeden en az N puan almış olmak VEYA makalelerde M kez başlıca yazar olmak". */
$bapVeyaMakale = fn (int $puan, int $sayi, ?array $donem, string $md): array => Kalip::veya(
    'Proje ya da ek başlıca yazarlık koşulu', [
        Kalip::puanDan("Bilimsel araştırma projesi kalemlerinizden en az {$puan} puan", ['BAP'], $puan, $donem, madde: $md),
        Kalip::adet("Ya da makalelerinizden en az {$sayi} tanesinde başlıca yazar olmak", ['M-abc'], $sayi, yazar: 'baslica', donem: $donem, madde: $md),
    ],
);

/** "Adayın doktora tezinden olmak koşulu ile ... en az N puan". */
$tezP = fn (int $puan, string $grup, ?array $donem, string $md): array => Kalip::puanDan(
    "Lisansüstü tezinizden üretilmiş yayınlarınızdan en az {$puan} puan", [$grup], $puan, $donem, madde: $md,
);

$esikler = [];

// ══════════════════════════════════════════════════════════════════════════
// 1) EĞİTİM BİLİMLERİ
// ══════════════════════════════════════════════════════════════════════════

$esikler = array_merge($esikler, $alanEsikleri('egitim', 'Eğitim Bilimleri Temel Alanı', [
    'dr_ogr_uyesi' => [
        $mP('UM-ab', 20, null, 'Eğitim 1-A-1-a', 'Uluslararası makale'),
        $mB('UM-ab', 1, null, 'Eğitim 1-A-1-a'),
        $mP('NM-a', 20, null, 'Eğitim 1-A-1-b', 'TR Dizin makale'),
        $mB('NM-a', 1, null, 'Eğitim 1-A-1-b'),
        $tezP(5, 'TZ-M', null, 'Eğitim 1-A-1-c'),
        $btP(3, null, 'Eğitim 1-A-1-d'),
    ],
    'dr_ogr_uyesi_yeniden' => [
        $mP('UM-ab', 30, $SON_ATAMA, 'Eğitim 1-A-2-a', 'Uluslararası makale'),
        $mB('UM-ab', 1, $SON_ATAMA, 'Eğitim 1-A-2-a'),
        $btP(3, $SON_ATAMA, 'Eğitim 1-A-2-b'),
        $atP(2, $SON_ATAMA, 'Eğitim 1-A-2-c'),
    ],
    'docentlik' => [
        $mP('UM', 40, $DOKTORA, 'Eğitim 1-B-a', 'Uluslararası makale'),
        $mB('UM-ab', 1, $DOKTORA, 'Eğitim 1-B-a'),
        $mP('NM', 40, $DOKTORA, 'Eğitim 1-B-b', 'Ulusal makale'),
        $mB('NM-a', 2, $DOKTORA, 'Eğitim 1-B-b'),
        $btP(10, $DOKTORA, 'Eğitim 1-B-c'),
        $btB(2, $DOKTORA, 'Eğitim 1-B-c'),
        $atP(5, $DOKTORA, 'Eğitim 1-B-d'),
        Kalip::veya('Proje ya da ek başlıca yazarlık koşulu', [
            Kalip::puanDan('Bilimsel araştırma projesi kalemlerinizden en az 4 puan', ['BAP'], 4, $DOKTORA, madde: 'Eğitim 1-B-e'),
            Kalip::adet('Ya da uluslararası makalelerinizden en az 2 tanesinde başlıca yazar olmak', ['UM-ab'], 2, yazar: 'baslica', donem: $DOKTORA, madde: 'Eğitim 1-B-e'),
        ]),
        $ders(2),
    ],
    'profesorluk' => [
        $mP('UM', 50, $DOCENTLIK, 'Eğitim 1-C-a', 'Uluslararası makale'),
        $mB('UM-ab', 2, $DOCENTLIK, 'Eğitim 1-C-a'),
        $baslicaEser,
        Kalip::veya('Ulusal makale koşulu', [
            Kalip::ve('Ulusal makale bölümünden 40 puan ve iki başlıca yazarlık', [
                Kalip::puanDan('Ulusal makale kalemlerinizden en az 40 puan', ['NM'], 40, $DOCENTLIK, madde: 'Eğitim 1-C-b'),
                Kalip::adet('Bu makalelerden en az 2 tanesinde başlıca yazar olmalısınız', ['NM-a'], 2, yazar: 'baslica', donem: $DOCENTLIK, madde: 'Eğitim 1-C-b'),
            ]),
            Kalip::ve('Ya da uluslararası makale şartlarının yarısı', [
                Kalip::puanDan('Uluslararası makale kalemlerinizden en az 25 puan', ['UM'], 25, $DOCENTLIK, madde: 'Eğitim 1-C-b'),
                Kalip::adet('Bu makalelerden en az 1 tanesinde başlıca yazar olmalısınız', ['UM-ab'], 1, yazar: 'baslica', donem: $DOCENTLIK, madde: 'Eğitim 1-C-b'),
            ]),
        ]),
        $btP(10, $DOCENTLIK, 'Eğitim 1-C-c'),
        $btB(2, $DOCENTLIK, 'Eğitim 1-C-c'),
        $atP(10, $DOCENTLIK, 'Eğitim 1-C-d'),
        $ders(4),
        $profSart(8, 'UM-ab', 1),
    ],
]));

// ══════════════════════════════════════════════════════════════════════════
// 2) FEN BİLİMLERİ VE MATEMATİK
// ══════════════════════════════════════════════════════════════════════════

$esikler = array_merge($esikler, $alanEsikleri('fen', 'Fen Bilimleri ve Matematik Temel Alanı', [
    'dr_ogr_uyesi' => [
        $mP('M', 30, null, 'Fen 2-A-1-a'),
        $mB('M-ab', 1, null, 'Fen 2-A-1-a'),
        $tezP(5, 'TZ-M', null, 'Fen 2-A-1-b'),
        $btP(3, null, 'Fen 2-A-1-c'),
    ],
    'dr_ogr_uyesi_yeniden' => [
        $mP('M', 40, $SON_ATAMA, 'Fen 2-A-2-a'),
        $mB('M-ab', 2, $SON_ATAMA, 'Fen 2-A-2-a'),
        $btP(3, $SON_ATAMA, 'Fen 2-A-2-b'),
        $bapVeyaMakale(4, 1, $SON_ATAMA, 'Fen 2-A-2-c'),
    ],
    'docentlik' => [
        $mP('M', 55, $DOKTORA, 'Fen 2-B-a'),
        $mB('M-a', 2, $DOKTORA, 'Fen 2-B-a'),
        $btP(5, $DOKTORA, 'Fen 2-B-b'),
        $btB(1, $DOKTORA, 'Fen 2-B-b'),
        $atP(5, $DOKTORA, 'Fen 2-B-c'),
        $bapVeyaMakale(8, 2, $DOKTORA, 'Fen 2-B-d'),
        $ders(2),
    ],
    'profesorluk' => [
        $mP('M', 70, $DOCENTLIK, 'Fen 2-C-a'),
        $mB('M-a', 2, $DOCENTLIK, 'Fen 2-C-a'),
        $baslicaEser,
        $btP(5, $DOCENTLIK, 'Fen 2-C-b'),
        $btB(1, $DOCENTLIK, 'Fen 2-C-b'),
        $atP(10, $DOCENTLIK, 'Fen 2-C-c', ['AT-a']),
        $profSart(8, 'M-ab', 1),
        $ders(4),
    ],
]));

// ══════════════════════════════════════════════════════════════════════════
// 3) FİLOLOJİ
// ══════════════════════════════════════════════════════════════════════════

$esikler = array_merge($esikler, $alanEsikleri('filoloji', 'Filoloji Temel Alanı', [
    'dr_ogr_uyesi' => [
        $mP('M', 40, null, 'Filoloji 3-A-1-a'),
        $mB('M', 1, null, 'Filoloji 3-A-1-a'),
        $btP(5, null, 'Filoloji 3-A-1-b'),
    ],
    'dr_ogr_uyesi_yeniden' => [
        $mP('M', 40, $SON_ATAMA, 'Filoloji 3-A-2-a'),
        $mB('M-abc', 1, $SON_ATAMA, 'Filoloji 3-A-2-a'),
        $atP(2, $SON_ATAMA, 'Filoloji 3-A-2-b'),
        $btP(3, $SON_ATAMA, 'Filoloji 3-A-2-c'),
    ],
    'docentlik' => [
        $mP('M', 60, $DOKTORA, 'Filoloji 3-B-a'),
        $mB('M-abc', 3, $DOKTORA, 'Filoloji 3-B-a'),
        $btP(5, $DOKTORA, 'Filoloji 3-B-b'),
        $btB(1, $DOKTORA, 'Filoloji 3-B-b'),
        $atP(5, $DOKTORA, 'Filoloji 3-B-c'),
        $bapVeyaMakale(4, 2, $DOKTORA, 'Filoloji 3-B-d'),
        $ders(2),
    ],
    'profesorluk' => [
        $mP('M', 60, $DOCENTLIK, 'Filoloji 3-C-a'),
        $mB('M-ab', 1, $DOCENTLIK, 'Filoloji 3-C-a'),
        $baslicaEser,
        Kalip::adet('Tek yazarlı en az 1 kitabınız ya da kitap bölümünüz olmalı', ['K-a', 'K-b', 'K-c', 'K-d'], 1, yazar: 'tek', donem: $DOCENTLIK, madde: 'Filoloji 3-C-b'),
        $btP(5, $DOCENTLIK, 'Filoloji 3-C-c'),
        $btB(1, $DOCENTLIK, 'Filoloji 3-C-c'),
        $atP(10, $DOCENTLIK, 'Filoloji 3-C-d'),
        $profSart(4, 'M-ab', 1),
        $ders(4),
    ],
]));

// ══════════════════════════════════════════════════════════════════════════
// 4) GÜZEL SANATLAR
// ══════════════════════════════════════════════════════════════════════════

$seP = fn (int $puan, ?array $donem, string $md): array => Kalip::puanDan(
    "Sanatsal etkinlik kalemlerinizden en az {$puan} puan", ['SE'], $puan, $donem, madde: $md,
);

$esikler = array_merge($esikler, $alanEsikleri('guzel_sanatlar', 'Güzel Sanatlar Temel Alanı', [
    'dr_ogr_uyesi' => [
        $tezP(5, 'TZ-M', null, 'Güzel Sanatlar 4-A-1-a ve 4-A-1-b'),
        $mP('M', 15, null, 'Güzel Sanatlar 4-A-1-c'),
        $mB('M-abc', 1, null, 'Güzel Sanatlar 4-A-1-c'),
        $btP(4, null, 'Güzel Sanatlar 4-A-1-d'),
        $seP(35, null, 'Güzel Sanatlar 4-A-1-e'),
    ],
    'dr_ogr_uyesi_yeniden' => [
        $mP('M', 20, $SON_ATAMA, 'Güzel Sanatlar 4-A-2-a'),
        $mB('M-abc', 1, $SON_ATAMA, 'Güzel Sanatlar 4-A-2-a'),
        $btP(5, $SON_ATAMA, 'Güzel Sanatlar 4-A-2-b'),
        $seP(25, $SON_ATAMA, 'Güzel Sanatlar 4-A-2-c'),
    ],
    'docentlik' => [
        $mP('M', 30, $DOKTORA, 'Güzel Sanatlar 4-B-a'),
        $mB('M-abc', 2, $DOKTORA, 'Güzel Sanatlar 4-B-a'),
        $btP(10, $DOKTORA, 'Güzel Sanatlar 4-B-b'),
        $btB(1, $DOKTORA, 'Güzel Sanatlar 4-B-b'),
        $seP(50, $DOKTORA, 'Güzel Sanatlar 4-B-c'),
        $atP(5, $DOKTORA, 'Güzel Sanatlar 4-B-d'),
        $ders(2),
    ],
    'profesorluk' => [
        $mP('M', 40, $DOCENTLIK, 'Güzel Sanatlar 4-C-a'),
        $mB('M-abc', 2, $DOCENTLIK, 'Güzel Sanatlar 4-C-a'),
        $baslicaEser,
        $seP(50, $DOCENTLIK, 'Güzel Sanatlar 4-C-b'),
        Kalip::adet('Sanatsal etkinliklerinizden en az 2 tanesi kişisel etkinlik olmalı', ['SE-KISISEL'], 2, donem: $DOCENTLIK, madde: 'Güzel Sanatlar 4-C-b'),
        $btP(10, $DOCENTLIK, 'Güzel Sanatlar 4-C-c'),
        $btB(1, $DOCENTLIK, 'Güzel Sanatlar 4-C-c'),
        $atP(10, $DOCENTLIK, 'Güzel Sanatlar 4-C-d'),
        $ders(4),
    ],
]));

// ══════════════════════════════════════════════════════════════════════════
// 5) İLAHİYAT
// ══════════════════════════════════════════════════════════════════════════

$ilahiyatKitap = fn (?array $donem, string $md): array => Kalip::ve(
    'Tek yazarlı kitap koşulu', [
        Kalip::adet('Tek yazarlı en az 1 kitabınız olmalı', ['K-a', 'K-c'], 1, yazar: 'tek', donem: $donem, madde: $md),
        Kalip::puanDan('Kitap kalemlerinizden en az 20 puan', ['K-a', 'K-c'], 20, $donem, madde: $md),
    ],
);

$esikler = array_merge($esikler, $alanEsikleri('ilahiyat', 'İlahiyat Temel Alanı', [
    'dr_ogr_uyesi' => [
        $mP('M', 30, null, 'İlahiyat 5-A-1-a'),
        $mB('M-abc', 1, null, 'İlahiyat 5-A-1-a'),
        $tezP(5, 'TZ', null, 'İlahiyat 5-A-1-b'),
        $btP(3, null, 'İlahiyat 5-A-1-c'),
        $btB(1, null, 'İlahiyat 5-A-1-c'),
    ],
    'dr_ogr_uyesi_yeniden' => [
        $mP('M', 40, $SON_ATAMA, 'İlahiyat 5-A-2-a'),
        $mB('M-abc', 2, $SON_ATAMA, 'İlahiyat 5-A-2-a'),
        $btP(6, $SON_ATAMA, 'İlahiyat 5-A-2-b'),
        $btB(1, $SON_ATAMA, 'İlahiyat 5-A-2-b'),
    ],
    'docentlik' => [
        $mP('M', 60, $DOKTORA, 'İlahiyat 5-B-a'),
        $mB('M-ab', 1, $DOKTORA, 'İlahiyat 5-B-a'),
        $ilahiyatKitap($DOKTORA, 'İlahiyat 5-B-b'),
        $atP(5, $DOKTORA, 'İlahiyat 5-B-c'),
        $btP(6, $DOKTORA, 'İlahiyat 5-B-d'),
        $btB(1, $DOKTORA, 'İlahiyat 5-B-d'),
        $ders(2),
    ],
    'profesorluk' => [
        $mP('M', 70, $DOCENTLIK, 'İlahiyat 5-C-a'),
        $mB('M-ab', 1, $DOCENTLIK, 'İlahiyat 5-C-a'),
        $baslicaEser,
        $ilahiyatKitap($DOCENTLIK, 'İlahiyat 5-C-b'),
        $atP(10, $DOCENTLIK, 'İlahiyat 5-C-c'),
        $btP(6, $DOCENTLIK, 'İlahiyat 5-C-d'),
        $btB(1, $DOCENTLIK, 'İlahiyat 5-C-d'),
        $ders(4),
    ],
]));

// ══════════════════════════════════════════════════════════════════════════
// 6) MİMARLIK VE TASARIM
// ══════════════════════════════════════════════════════════════════════════

$esikler = array_merge($esikler, $alanEsikleri('mimarlik', 'Mimarlık ve Tasarım Temel Alanı', [
    'dr_ogr_uyesi' => [
        $tezP(5, 'TZ-M', null, 'Mimarlık 6-A-1-a ve 6-A-1-b'),
        $mP('M', 30, null, 'Mimarlık 6-A-1-c'),
        $mB('M-abc', 1, null, 'Mimarlık 6-A-1-c'),
        $btP(5, null, 'Mimarlık 6-A-1-d'),
    ],
    'dr_ogr_uyesi_yeniden' => [
        $mP('M', 35, $SON_ATAMA, 'Mimarlık 6-A-2-a'),
        $mB('M-abc', 1, $SON_ATAMA, 'Mimarlık 6-A-2-a'),
        $btP(5, $SON_ATAMA, 'Mimarlık 6-A-2-b'),
        $bapVeyaMakale(4, 1, $SON_ATAMA, 'Mimarlık 6-A-2-c'),
    ],
    'docentlik' => [
        $mP('M', 45, $DOKTORA, 'Mimarlık 6-B-a'),
        $mB('M-ab', 2, $DOKTORA, 'Mimarlık 6-B-a'),
        $btP(6, $DOKTORA, 'Mimarlık 6-B-b'),
        $btB(2, $DOKTORA, 'Mimarlık 6-B-b'),
        $atP(15, $DOKTORA, 'Mimarlık 6-B-c'),
        $bapVeyaMakale(4, 2, $DOKTORA, 'Mimarlık 6-B-d'),
        $ders(4),
    ],
    'profesorluk' => [
        $mP('M', 55, $DOCENTLIK, 'Mimarlık 6-C-a'),
        $mB('M-ab', 2, $DOCENTLIK, 'Mimarlık 6-C-a'),
        $baslicaEser,
        $btP(8, $DOCENTLIK, 'Mimarlık 6-C-b'),
        $btB(2, $DOCENTLIK, 'Mimarlık 6-C-b'),
        $atP(20, $DOCENTLIK, 'Mimarlık 6-C-c'),
        $profSart(8, 'M-ab', 1),
    ],
]));

// ══════════════════════════════════════════════════════════════════════════
// 7) MÜHENDİSLİK
// ══════════════════════════════════════════════════════════════════════════

// "Patent/Faydalı Model a ve/veya b bendi kapsamında alınan her bir patent,
// Makaleler a bendinde bir eserde başlıca yazar olmak koşuluna eşdeğerdir."
$muhBaslica = fn (int $sayi, ?array $donem, string $md): array => Kalip::adet(
    "Bu makalelerden en az {$sayi} tanesinde başlıca yazar olmalısınız",
    ['M-a'], $sayi, yazar: 'baslica', donem: $donem,
    telafi: Kalip::adet(
        "Ya da tescil edilmiş {$sayi} patentiniz olmalı (her patent bir başlıca yazarlığa eşdeğer)",
        ['PT-a', 'PT-b'], $sayi, donem: $donem,
    ),
    madde: $md,
);

$esikler = array_merge($esikler, $alanEsikleri('muhendislik', 'Mühendislik Temel Alanı', [
    'dr_ogr_uyesi' => [
        $tezP(5, 'TZ-M', null, 'Mühendislik 7-A-1-a'),
        $btP(3, null, 'Mühendislik 7-A-1-b'),
        $mP('M', 30, null, 'Mühendislik 7-A-1-c'),
        $mB('M-ab', 1, null, 'Mühendislik 7-A-1-c'),
    ],
    'dr_ogr_uyesi_yeniden' => [
        $mP('M', 40, $SON_ATAMA, 'Mühendislik 7-A-2-a'),
        $mB('M-ab', 1, $SON_ATAMA, 'Mühendislik 7-A-2-a'),
        $btP(3, $SON_ATAMA, 'Mühendislik 7-A-2-b'),
        $bapVeyaMakale(4, 1, $SON_ATAMA, 'Mühendislik 7-A-2-c'),
    ],
    'docentlik' => [
        $mP('M', 55, $DOKTORA, 'Mühendislik 7-B-a'),
        $muhBaslica(2, $DOKTORA, 'Mühendislik 7-B-a'),
        $btP(5, $DOKTORA, 'Mühendislik 7-B-b'),
        $atP(5, $DOKTORA, 'Mühendislik 7-B-c'),
        $bapVeyaMakale(8, 2, $DOKTORA, 'Mühendislik 7-B-d'),
        $ders(2),
    ],
    'profesorluk' => [
        $mP('M', 70, $DOCENTLIK, 'Mühendislik 7-C-a'),
        $muhBaslica(2, $DOCENTLIK, 'Mühendislik 7-C-a'),
        $baslicaEser,
        $btP(5, $DOCENTLIK, 'Mühendislik 7-C-b'),
        $atP(10, $DOCENTLIK, 'Mühendislik 7-C-c', ['AT-a']),
        $profSart(8, 'M-ab', 2),
        $ders(4),
    ],
]));

// ══════════════════════════════════════════════════════════════════════════
// 8) SAĞLIK BİLİMLERİ
// ══════════════════════════════════════════════════════════════════════════

$esikler = array_merge($esikler, $alanEsikleri('saglik', 'Sağlık Bilimleri Temel Alanı', [
    'dr_ogr_uyesi' => [
        $tezP(5, 'TZ-M', null, 'Sağlık 8-A-1-a'),
        $mP('M', 30, null, 'Sağlık 8-A-1-b'),
        $mB('M-ab', 1, null, 'Sağlık 8-A-1-b'),
        $btP(3, null, 'Sağlık 8-A-1-c'),
    ],
    'dr_ogr_uyesi_yeniden' => [
        $mP('M', 40, $SON_ATAMA, 'Sağlık 8-A-2-a'),
        $mB('M-ab', 1, $SON_ATAMA, 'Sağlık 8-A-2-a'),
        $btP(3, $SON_ATAMA, 'Sağlık 8-A-2-b'),
        $bapVeyaMakale(4, 1, $SON_ATAMA, 'Sağlık 8-A-2-c'),
    ],
    'docentlik' => [
        $mP('M', 55, $DOKTORA, 'Sağlık 8-B-a'),
        $mB('M-a', 3, $DOKTORA, 'Sağlık 8-B-a'),
        $btP(5, $DOKTORA, 'Sağlık 8-B-b'),
        $btB(1, $DOKTORA, 'Sağlık 8-B-b'),
        $atP(5, $DOKTORA, 'Sağlık 8-B-c'),
        $bapVeyaMakale(4, 2, $DOKTORA, 'Sağlık 8-B-d'),
        $ders(2),
    ],
    'profesorluk' => [
        $mP('M', 70, $DOCENTLIK, 'Sağlık 8-C-a'),
        $mB('M-a', 2, $DOCENTLIK, 'Sağlık 8-C-a'),
        $baslicaEser,
        $btP(5, $DOCENTLIK, 'Sağlık 8-C-b'),
        $atP(10, $DOCENTLIK, 'Sağlık 8-C-c', ['AT-a']),
        $profSart(8, 'M-ab', 2),
        $ders(4),
    ],
]));

// ══════════════════════════════════════════════════════════════════════════
// 9) SOSYAL, BEŞERİ VE İDARİ BİLİMLER
// ══════════════════════════════════════════════════════════════════════════

$esikler = array_merge($esikler, $alanEsikleri('sosyal', 'Sosyal, Beşeri ve İdari Bilimler Temel Alanı', [
    'dr_ogr_uyesi' => [
        $tezP(1, 'TZ', null, 'Sosyal 9-A-1-a'),
        $mP('M', 30, null, 'Sosyal 9-A-1-b'),
        $mB('M-abc', 1, null, 'Sosyal 9-A-1-b'),
        $btP(5, null, 'Sosyal 9-A-1-c'),
        $btB(1, null, 'Sosyal 9-A-1-c'),
    ],
    'dr_ogr_uyesi_yeniden' => [
        $mP('M', 35, $SON_ATAMA, 'Sosyal 9-A-2-a'),
        $mB('M-abc', 1, $SON_ATAMA, 'Sosyal 9-A-2-a'),
        $btP(5, $SON_ATAMA, 'Sosyal 9-A-2-b'),
        $bapVeyaMakale(4, 1, $SON_ATAMA, 'Sosyal 9-A-2-c'),
        $atP(2, $SON_ATAMA, 'Sosyal 9-A-2-d'),
    ],
    'docentlik' => [
        $mP('M', 50, $DOKTORA, 'Sosyal 9-B-a'),
        $mB('M-ab', 1, $DOKTORA, 'Sosyal 9-B-a'),
        $btP(6, $DOKTORA, 'Sosyal 9-B-b'),
        $btB(1, $DOKTORA, 'Sosyal 9-B-b'),
        $atP(5, $DOKTORA, 'Sosyal 9-B-c'),
        $bapVeyaMakale(8, 2, $DOKTORA, 'Sosyal 9-B-d'),
        $ders(2),
    ],
    'profesorluk' => [
        $mP('M', 60, $DOCENTLIK, 'Sosyal 9-C-a'),
        $mB('M-ab', 1, $DOCENTLIK, 'Sosyal 9-C-a'),
        $baslicaEser,
        $btP(8, $DOCENTLIK, 'Sosyal 9-C-b'),
        $btB(1, $DOCENTLIK, 'Sosyal 9-C-b'),
        $atP(10, $DOCENTLIK, 'Sosyal 9-C-c'),
        $profSart(8, 'M-ab', 2),
        $ders(4),
    ],
]));

// ══════════════════════════════════════════════════════════════════════════
// 10) SPOR BİLİMLERİ
// ══════════════════════════════════════════════════════════════════════════

$esikler = array_merge($esikler, $alanEsikleri('spor', 'Spor Bilimleri Temel Alanı', [
    'dr_ogr_uyesi' => [
        $tezP(5, 'TZ-M', null, 'Spor 10-A-1-a ve 10-A-1-b'),
        $mP('M', 30, null, 'Spor 10-A-1-c'),
        $mB('M-ab', 1, null, 'Spor 10-A-1-c'),
        $btP(3, null, 'Spor 10-A-1-d'),
    ],
    'dr_ogr_uyesi_yeniden' => [
        $mP('M', 40, $SON_ATAMA, 'Spor 10-A-2-a'),
        $mB('M-ab', 1, $SON_ATAMA, 'Spor 10-A-2-a'),
        $btP(3, $SON_ATAMA, 'Spor 10-A-2-b'),
        $bapVeyaMakale(4, 1, $SON_ATAMA, 'Spor 10-A-2-c'),
    ],
    'docentlik' => [
        $mP('M', 55, $DOKTORA, 'Spor 10-B-a'),
        $mB('M-ab', 2, $DOKTORA, 'Spor 10-B-a'),
        $btP(6, $DOKTORA, 'Spor 10-B-b'),
        $btB(1, $DOKTORA, 'Spor 10-B-b'),
        $atP(5, $DOKTORA, 'Spor 10-B-c'),
        $bapVeyaMakale(4, 2, $DOKTORA, 'Spor 10-B-d'),
        $ders(2),
    ],
    'profesorluk' => [
        $mP('M', 70, $DOCENTLIK, 'Spor 10-C-a'),
        $mB('M-ab', 2, $DOCENTLIK, 'Spor 10-C-a'),
        $baslicaEser,
        $btP(8, $DOCENTLIK, 'Spor 10-C-b'),
        $atP(10, $DOCENTLIK, 'Spor 10-C-c', ['AT-a']),
        $profSart(8, 'M-ab', 2),
        $ders(4),
    ],
]));

return $esikler;
