<?php

/**
 * KASTAMONU ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma
 * Esasları Yönergesi
 * Kaynak: pdf/1766060294628.kastamonu-kriter-18122025.pdf (52 sayfa;
 * Senato 18.12.2025)
 *
 * ── YAPI: TEK PUANLAMA CETVELİ + ON ALTI FAKÜLTE EKİ ──
 * MADDE 6-9 kadro şartlarını genel hatlarıyla veriyor ve ayrıntıyı
 * "Yönerge'nin Ekler bölümünde belirtilen özel şartlar"a bırakıyor.
 * Ek-1 ile Ek-16 arası her akademik birim için ayrı bir özel şart tablosu,
 * Ek-17 ise bütün birimlerin paylaştığı Puanlama Cetveli.
 *
 * On altı ekin ÖZEL ŞART METİNLERİ birbirinin aynısı çıktı; normalleştirip
 * karşılaştırınca yalnızca BEŞ farklı kural seti kaldı:
 *   FEN TİPİ  — Ek-1 (Diş Hekimliği), Ek-3 (Fen), Ek-9 (Mühendislik ve
 *       Mimarlık), Ek-10 (Orman), Ek-11 (Sağlık Bilimleri), Ek-13 (Tıp),
 *       Ek-15 (Veteriner). Aradaki fark yalnızca boşluk ve satır kayması.
 *   EĞİTİM    — Ek-2
 *   SANAT     — Ek-4 (Güzel Sanatlar ve Tasarım)
 *   SOSYAL    — Ek-5 (İİBF), Ek-6 (İlahiyat), Ek-8 (İnsan ve Toplum
 *       Bilimleri), Ek-14 (Turizm)
 *   İLETİŞİM  — Ek-7 (İletişim), Ek-12 (Spor Bilimleri). SOSYAL setinden
 *       tek farkı alt barajın 1-8 yerine 1-9'uncu maddelere bağlanması.
 * Ek-16 (enstitü, yüksekokul ve meslek yüksekokulları) "adayın bulunduğu
 * bilim alanı ile ilgili fakülte şartları geçerlidir" dediği için ayrı eşik
 * gerektirmiyor.
 *
 * ── `sosyal` ALANINDA İKİ EŞİK ──
 * İİBF, Turizm ve İnsan ve Toplum Bilimleri fakülteleri SOSYAL setine,
 * İletişim Fakültesi ise İLETİŞİM setine bağlı; ikisi de `sosyal` temel
 * alanına düşüyor. Ayrım `birim` ile kuruldu.
 *
 * ── 14'ÜNCÜ MADDE HESAPLANAMIYOR ──
 * Bütün kadro şartları "Puanlama Cetveli'nin 14'üncü maddesinden en az N
 * tanesini yapmış olmak" diyor. 14'üncü madde ("Diğer Faaliyetler")
 * yönergenin kendi tanımıyla "puanlamaya dâhil olmayan faaliyetler"; otuz
 * beş satırının çoğu (sabatik izin, disiplinler arası iş birliği, bilim
 * kurulu üyeliği, öğrenci danışmanlığı, ikinci yabancı dil puanı…)
 * faaliyet kaydından okunamıyor. Koşul `Kalip::hesaplanamiyor` ile
 * işaretlendi: aday bu maddeyi kendi kontrol etmeli.
 * Aynı maddenin muafiyeti de yazılamadı ("ticarileştirilmiş patenti
 * olanlar veya TÜBİTAK/AB projesinde koordinatörlük yapmış olanlar
 * muaftır").
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 6(a): doçentlik unvanından sonra en az beş yıl ilgili bilim
 *       alanında çalışmış olmak — `beyan`.
 *   MADDE 6(b): yayınlardan birini başlıca araştırma eseri olarak
 *       belirtmek — `beyan`.
 *   MADDE 6(c): ÜAK doçentlik temel alan başvuru şartlarını (lisansüstü
 *       tez yayını şartı hariç) bir kez daha sağlamak — ÜAK şartları
 *       döneme göre değiştiği için `beyan`.
 *   MADDE 7(a) ve 8(a): doçentlik unvanı ve doktora/uzmanlık diploması —
 *       `beyan`.
 *   MADDE 9(c): doçent unvanı almış olup doktor öğretim üyesi kadrosunda
 *       görev yapanların yeniden atanmasında özel şartların aranmaması —
 *       adayın unvanı ile kadrosu arasındaki bu fark profilde yok.
 *   MADDE 5(d): Tıp ve Diş Hekimliği fakültelerinde şartları sağlayan aday
 *       çıkmazsa yapılan istisnai atama — idari takdir.
 *   Yönerge hiçbir kadroda yabancı dil puanı istemiyor; `Kalip::yds`
 *       kullanılmadı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/kastamonu-2025.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Kastamonu Üniversitesi';
$CETVEL = 'kastamonu-2025';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$M14_NOTU = ' DİKKAT: yönerge her kadroda "Puanlama Cetveli\'nin 14\'üncü maddesinden en az N '
    .'tanesini yapmış olmak" şartını da koyuyor. O madde yönergenin kendi tanımıyla "puanlamaya '
    .'dâhil olmayan faaliyetler" listesi ve otuz beş satırının çoğu faaliyet kaydından '
    .'okunamıyor; bu şart burada hesaplanamıyor olarak işaretlendi, kendiniz kontrol edin.';

$profesorOn = [
    Kalip::beyan(
        'Doçentlik unvanını aldıktan sonra en az beş yıl, açık bulunan profesörlük kadrosuyla '
        .'ilgili bilim alanında çalışmış olmak',
        'MADDE 6(1)(a)',
    ),
    Kalip::beyan(
        'Doçentlik unvanını aldıktan sonra yaptığınız yayınlardan birini başvuru dosyanızda '
        .'başlıca araştırma eseri olarak belirtmiş olmak',
        'MADDE 6(1)(b)',
    ),
    Kalip::beyan(
        'ÜAK\'ın önerisi üzerine YÖK tarafından belirlenen yürürlükteki doçentlik temel alan '
        .'başvuru şartlarını (lisansüstü tez çalışmasından yayın şartı hariç) bir kez daha '
        .'sağlamış olmak',
        'MADDE 6(1)(c)',
    ),
];

$docentOn = [Kalip::beyan('Üniversitelerarası Kuruldan doçent unvanı almış olmak', 'MADDE 7(1)(a)')];

$drOn = [Kalip::beyan(
    'Doktora ya da tıpta, diş hekimliğinde, eczacılıkta, veteriner hekimlikte uzmanlık veya '
    .'sanatta yeterlik eğitimini tamamlamış olmak',
    'MADDE 8(1)(a)',
)];

/** "14'üncü maddeden en az N tanesini yapmış olmak" — puanlamaya dâhil olmayan liste. */
$m14 = fn (int $sayi): array => Kalip::hesaplanamiyor(
    "Puanlama Cetveli'nin 14'üncü maddesindeki (Diğer Faaliyetler) {$sayi} faaliyeti yapmış olmak "
    .'— bu madde puanlamaya dâhil değil ve satırlarının çoğu faaliyet kaydından okunamıyor',
    'Ek özel şartlar · 14. madde',
);

/** "7/… bentlerindeki projelerden birinde yürütücü/araştırmacı olmak veya ikisinde danışmanlık". */
$proje = fn (string $ya, string $d, ?array $donem, string $md): array => Kalip::veya(
    'Araştırma projesi koşulu', [
        Kalip::adet('Araştırma projelerinden birinde koordinatör, yürütücü ya da araştırmacı olmak', [$ya], 1, donem: $donem, madde: $md),
        Kalip::adet('Ya da bu projelerden ikisinde danışmanlık yapmak', [$d], 2, donem: $donem, madde: $md),
    ],
);

/** Dr. Öğretim Üyeliğine yeniden atanmanın bütün eklerde ortak olan üç koşulu. */
$drYenidenOrtak = fn (int $toplam) => [
    Kalip::adet(
        'Son atanma tarihinizden itibaren 1/a-b-c, 2/a ya da 3/a-b-c-g bentlerindeki dergilerde en az 2 makale',
        ['1abc-2a-3abcg'], 2, donem: Kalip::SON_ATAMA_SONRASI, madde: 'Ek özel şartlar · Dr. yeniden atama',
    ),
    Kalip::veya('Kitap ya da proje koşulu', [
        Kalip::adet('Kitap bölümündeki (4. madde) bentlerden birinde yayın yapmış olmak', ['4'], 1, donem: Kalip::SON_ATAMA_SONRASI, madde: 'Ek özel şartlar · Dr. yeniden atama'),
        Kalip::adet('Ya da araştırma projelerinden birinde koordinatör, yürütücü veya araştırmacı olmak', ['7-PY-YA'], 1, donem: Kalip::SON_ATAMA_SONRASI, madde: 'Ek özel şartlar · Dr. yeniden atama'),
        Kalip::adet('Ya da bu projelerden ikisinde danışmanlık yapmak', ['7-PY-D'], 2, donem: Kalip::SON_ATAMA_SONRASI, madde: 'Ek özel şartlar · Dr. yeniden atama'),
    ]),
    Kalip::toplam($toplam, Kalip::SON_ATAMA_SONRASI, ['1-13'], 'Puanlama Cetveli 1-13. maddeler'),
];

$esikler = [];

/**
 * Bir kural setinin dört kadrosunu üretir.
 *
 * @param  list<string>  $alanlar
 * @param  array<string, list<array<string, mixed>>>  $kosullar
 * @return list<array<string, mixed>>
 */
$setEsikleri = function (string $anahtar, array $alanlar, ?string $birim, string $setAdi,
    array $kosullar,
) use ($UNIVERSITE, $CETVEL, $profesorOn, $docentOn, $drOn, $M14_NOTU): array {
    $cerceve = [
        'profesorluk' => ['ad' => 'Profesör kadrosuna yükseltilme ve atanma', 'on' => $profesorOn,
            'not' => 'Doçentlik unvanınızı aldıktan sonraki çalışmalarınız sayılıyor. Puanlama '
                .'Cetvelinin 1-13\'üncü maddelerinden toplam en az 400 puan gerekiyor.'],
        'docentlik' => ['ad' => 'Doçent kadrosuna yükseltilme ve atanma', 'on' => $docentOn,
            'not' => 'Doktora ya da sanatta yeterlik unvanınızı aldıktan sonraki çalışmalarınız '
                .'sayılıyor. Puanlama Cetvelinin 1-13\'üncü maddelerinden toplam en az 300 puan '
                .'gerekiyor.'],
        'dr_ogr_uyesi' => ['ad' => 'İlk defa doktor öğretim üyeliği kadrosuna atanma', 'on' => $drOn,
            'not' => 'İlk atama üç yıl için yapılıyor.'],
        'dr_ogr_uyesi_yeniden' => ['ad' => 'Doktor öğretim üyeliği kadrosuna yeniden atanma', 'on' => [],
            'not' => 'Son atanma tarihinizden itibaren yaptığınız çalışmalar sayılıyor; yeniden '
                .'atama üç yıl için yapılıyor. Doçent unvanı almış olup doktor öğretim üyesi '
                .'kadrosunda görev yapanlarda yönerge bu şartları aramıyor.'],
    ];

    $uretilen = [];

    foreach ($cerceve as $kadro => $c) {
        $uretilen[] = [
            'anahtar' => "kastamonu-{$anahtar}-".str_replace('_', '-', $kadro),
            'aday_notu' => "{$setAdi} özel şartları uygulanıyor. {$c['not']}".$M14_NOTU,
            'universite' => $UNIVERSITE,
            'kadro' => $kadro,
            'alan' => $alanlar,
            'birim' => $birim,
            'cetvel' => $CETVEL,
            'notlar' => "{$setAdi} özel şartları (Yönerge Ekler bölümü) ve MADDE 6-9 genel şartları.",
            'sart' => Kalip::ve("{$c['ad']} — {$setAdi}", array_values(array_merge(
                $c['on'], $kosullar[$kadro],
            ))),
        ];
    }

    return $uretilen;
};

// ══════════════════════════════════════════════════════════════════════════
// FEN TİPİ — Ek-1, 3, 9, 10, 11, 13, 15
// ══════════════════════════════════════════════════════════════════════════

$esikler = array_merge($esikler, $setEsikleri(
    'fen', ['fen', 'muhendislik', 'mimarlik', 'ziraat', 'saglik'], null,
    'Diş Hekimliği, Fen, Mühendislik ve Mimarlık, Orman, Sağlık Bilimleri, Tıp ve Veteriner fakülteleri',
    [
        'profesorluk' => [
            Kalip::veya('Makale koşulu', [
                Kalip::ve('En az ikisi Q1-Q3 olmak üzere 3 makale', [
                    Kalip::adet('SCI-Expanded ve SSCI dergilerinde en az 3 makale', ['1a'], 3, donem: $DOCENTLIK, madde: 'Ek özel şartlar · Profesör'),
                    Kalip::adet('Bunlardan en az 2 tanesi Q1, Q2 veya Q3 kapsamında olmalı', ['1a-Q123'], 2, donem: $DOCENTLIK, madde: 'Ek özel şartlar · Profesör'),
                ]),
                Kalip::ve('Ya da en az biri Q1-Q3 olmak üzere 5 makale', [
                    Kalip::adet('SCI-Expanded ve SSCI dergilerinde en az 5 makale', ['1a'], 5, donem: $DOCENTLIK, madde: 'Ek özel şartlar · Profesör'),
                    Kalip::adet('Bunlardan en az 1 tanesi Q1, Q2 veya Q3 kapsamında olmalı', ['1a-Q123'], 1, donem: $DOCENTLIK, madde: 'Ek özel şartlar · Profesör'),
                ]),
            ]),
            Kalip::puanDan('Puanlama Cetvelinin 1-8. maddelerinden en az 250 puan', ['1-8'], 250, $DOCENTLIK, madde: 'Ek özel şartlar · Profesör'),
            $proje('7-P-YA', '7-P-D', $DOCENTLIK, 'Ek özel şartlar · Profesör'),
            $m14(7),
            Kalip::toplam(400, $DOCENTLIK, ['1-13'], 'Puanlama Cetveli 1-13. maddeler'),
        ],
        'docentlik' => [
            Kalip::puanDan('Puanlama Cetvelinin 1-8. maddelerinden en az 180 puan', ['1-8'], 180, $DOKTORA, madde: 'Ek özel şartlar · Doçent'),
            $proje('7-P-YA', '7-P-D', $DOKTORA, 'Ek özel şartlar · Doçent'),
            $m14(4),
            Kalip::toplam(300, $DOKTORA, ['1-13'], 'Puanlama Cetveli 1-13. maddeler'),
        ],
        'dr_ogr_uyesi' => [
            Kalip::adet('SCI-Expanded ve SSCI dergilerinde (tez yayınları dahil) en az 2 makale', ['1a-3a'], 2, madde: 'Ek özel şartlar · Dr. ilk atama'),
            Kalip::adet('1/b-c, 2/a veya 3/b-c-g bendindeki dergilerde en az 2 makale', ['1bc-2a-3bcg'], 2, madde: 'Ek özel şartlar · Dr. ilk atama'),
            Kalip::puanDan('Puanlama Cetvelinin 1-8. maddelerinden en az 125 puan', ['1-8'], 125, madde: 'Ek özel şartlar · Dr. ilk atama'),
            Kalip::adet('Araştırma projelerinden en az 1 tanesinde koordinatör, yürütücü ya da araştırmacı olmak', ['7-PH-YA'], 1, madde: 'Ek özel şartlar · Dr. ilk atama'),
            $m14(3),
            Kalip::toplam(150, null, ['1-13'], 'Puanlama Cetveli 1-13. maddeler'),
        ],
        'dr_ogr_uyesi_yeniden' => array_merge($drYenidenOrtak(120), [$m14(3)]),
    ],
));

// ══════════════════════════════════════════════════════════════════════════
// EĞİTİM — Ek-2
// ══════════════════════════════════════════════════════════════════════════

$egitimProfesorMakale = Kalip::veya('Makale koşulu', [
    Kalip::adet('SCI-Expanded ve SSCI dergilerinde en az 1 makale', ['1a'], 1, donem: $DOCENTLIK, madde: 'Ek-2 · Profesör'),
    Kalip::adet('Ya da 1/b-c bentlerindeki dergilerde en az 3 makale', ['1bc'], 3, donem: $DOCENTLIK, madde: 'Ek-2 · Profesör'),
    Kalip::adet('Ya da TR Dizin dergilerinde en az 5 makale', ['2a'], 5, donem: $DOCENTLIK, madde: 'Ek-2 · Profesör'),
    Kalip::ve('Ya da 1/b-c\'den 2 ve 2/a\'dan 3 olmak üzere toplam 5 makale', [
        Kalip::adet('1/b-c bentlerinde en az 2 makale', ['1bc'], 2, donem: $DOCENTLIK, madde: 'Ek-2 · Profesör'),
        Kalip::adet('TR Dizin dergilerinde en az 3 makale', ['2a'], 3, donem: $DOCENTLIK, madde: 'Ek-2 · Profesör'),
    ]),
]);

$drIlkMakaleSosyal = fn (string $md): array => Kalip::veya('Makale koşulu', [
    Kalip::adet('SCI-Expanded ve SSCI dergilerinde (tez yayınları dahil) en az 1 makale', ['1a-3a'], 1, madde: $md),
    Kalip::adet('Ya da 1/b-c bentlerindeki dergilerde en az 3 makale', ['1bc'], 3, madde: $md),
    Kalip::adet('Ya da 1/b-c, 2/a veya 3/b-c-g bentlerindeki dergilerde toplam en az 4 makale', ['1bc-2a-3bcg'], 4, madde: $md),
]);

$esikler = array_merge($esikler, $setEsikleri('egitim', ['egitim'], null, 'Eğitim Fakültesi', [
    'profesorluk' => [
        $egitimProfesorMakale,
        Kalip::puanDan('Puanlama Cetvelinin 1-8. maddelerinden en az 250 puan', ['1-8'], 250, $DOCENTLIK, madde: 'Ek-2 · Profesör'),
        $proje('7-P-YA', '7-P-D', $DOCENTLIK, 'Ek-2 · Profesör'),
        $m14(7),
        Kalip::toplam(400, $DOCENTLIK, ['1-13'], 'Puanlama Cetveli 1-13. maddeler'),
    ],
    'docentlik' => [
        Kalip::puanDan('Puanlama Cetvelinin 1-8. maddelerinden en az 180 puan', ['1-8'], 180, $DOKTORA, madde: 'Ek-2 · Doçent'),
        $proje('7-P-YA', '7-P-D', $DOKTORA, 'Ek-2 · Doçent'),
        $m14(4),
        Kalip::toplam(300, $DOKTORA, ['1-13'], 'Puanlama Cetveli 1-13. maddeler'),
    ],
    'dr_ogr_uyesi' => [
        $drIlkMakaleSosyal('Ek-2 · Dr. ilk atama'),
        Kalip::puanDan('Puanlama Cetvelinin 1-8. maddelerinden en az 100 puan', ['1-8'], 100, madde: 'Ek-2 · Dr. ilk atama'),
        Kalip::adet('Araştırma projelerinden en az 1 tanesinde koordinatör, yürütücü ya da araştırmacı olmak', ['7-PH-YA'], 1, madde: 'Ek-2 · Dr. ilk atama'),
        $m14(3),
        Kalip::toplam(125, null, ['1-13'], 'Puanlama Cetveli 1-13. maddeler'),
    ],
    'dr_ogr_uyesi_yeniden' => array_merge($drYenidenOrtak(120), [$m14(3)]),
]));

// ══════════════════════════════════════════════════════════════════════════
// SANAT — Ek-4 (Güzel Sanatlar ve Tasarım Fakültesi)
// ══════════════════════════════════════════════════════════════════════════

$esikler = array_merge($esikler, $setEsikleri('sanat', ['guzel_sanatlar'], null,
    'Güzel Sanatlar ve Tasarım Fakültesi', [
        'profesorluk' => [
            Kalip::veya('Makale koşulu', [
                Kalip::adet('SCI-Expanded ve SSCI dergilerinde en az 2 makale', ['1a'], 2, donem: $DOCENTLIK, madde: 'Ek-4 · Profesör'),
                Kalip::adet('Ya da 1/b-c-ç-d ve 2/a-b bentlerindeki dergilerde en az 5 makale', ['1bcçd-2ab'], 5, donem: $DOCENTLIK, madde: 'Ek-4 · Profesör'),
            ]),
            Kalip::adet('9. maddeden en az 2 sanat faaliyeti', ['9'], 2, donem: $DOCENTLIK, madde: 'Ek-4 · Profesör'),
            Kalip::puanDan('Puanlama Cetvelinin 1-9. maddelerinden en az 250 puan', ['1-9'], 250, $DOCENTLIK, madde: 'Ek-4 · Profesör'),
            $proje('7-P-YA', '7-P-D', $DOCENTLIK, 'Ek-4 · Profesör'),
            $m14(7),
            Kalip::toplam(400, $DOCENTLIK, ['1-13'], 'Puanlama Cetveli 1-13. maddeler'),
        ],
        'docentlik' => [
            Kalip::puanDan('Puanlama Cetvelinin 1-9. maddelerinden en az 180 puan', ['1-9'], 180, $DOKTORA, madde: 'Ek-4 · Doçent'),
            $proje('7-P-YA', '7-P-D', $DOKTORA, 'Ek-4 · Doçent'),
            $m14(4),
            Kalip::toplam(300, $DOKTORA, ['1-13'], 'Puanlama Cetveli 1-13. maddeler'),
        ],
        'dr_ogr_uyesi' => [
            Kalip::veya('Makale koşulu', [
                Kalip::adet('SCI-Expanded ve SSCI dergilerinde (tez yayınları dahil) en az 1 makale', ['1a-3a'], 1, madde: 'Ek-4 · Dr. ilk atama'),
                Kalip::ve('Ya da en az birinde tek yazar olduğunuz 3 makale', [
                    Kalip::adet('1/b-c-ç-d, 2/a-b veya 3/b-c-ç-g-ğ bentlerinde en az 3 makale', ['1bcçd-2ab-3bcçgğ'], 3, madde: 'Ek-4 · Dr. ilk atama'),
                    Kalip::adet('Bu makalelerden en az 1 tanesinde tek yazar olmalısınız', ['1bcçd-2ab-3bcçgğ'], 1, yazar: 'tek', madde: 'Ek-4 · Dr. ilk atama'),
                ]),
            ]),
            Kalip::adet('9. maddeden en az 1 sanat faaliyeti', ['9'], 1, madde: 'Ek-4 · Dr. ilk atama'),
            Kalip::puanDan('Puanlama Cetvelinin 1-9. maddelerinden en az 100 puan', ['1-9'], 100, madde: 'Ek-4 · Dr. ilk atama'),
            Kalip::adet('Araştırma projelerinden en az 1 tanesinde koordinatör, yürütücü ya da araştırmacı olmak', ['7-PH-YA'], 1, madde: 'Ek-4 · Dr. ilk atama'),
            $m14(3),
            Kalip::toplam(125, null, ['1-13'], 'Puanlama Cetveli 1-13. maddeler'),
        ],
        'dr_ogr_uyesi_yeniden' => [
            Kalip::adet(
                'Son atanma tarihinizden itibaren 1/a-b-c-ç, 2/a-b ya da 3/a-b-c-ç-g-ğ bentlerindeki dergilerde en az 1 makale',
                ['1abcç-2ab-3abcçgğ'], 1, donem: $SON_ATAMA, madde: 'Ek-4 · Dr. yeniden atama',
            ),
            Kalip::veya('Kitap ya da proje koşulu', [
                Kalip::adet('Kitap bölümündeki (4. madde) bentlerden birinde yayın yapmış olmak', ['4'], 1, donem: $SON_ATAMA, madde: 'Ek-4 · Dr. yeniden atama'),
                Kalip::adet('Ya da araştırma projelerinden birinde koordinatör, yürütücü veya araştırmacı olmak', ['7-PY-YA'], 1, donem: $SON_ATAMA, madde: 'Ek-4 · Dr. yeniden atama'),
                Kalip::adet('Ya da bu projelerden ikisinde danışmanlık yapmak', ['7-PY-D'], 2, donem: $SON_ATAMA, madde: 'Ek-4 · Dr. yeniden atama'),
            ]),
            Kalip::adet('Son atanma tarihinizden itibaren 9. maddeden en az 1 sanat faaliyeti', ['9'], 1, donem: $SON_ATAMA, madde: 'Ek-4 · Dr. yeniden atama'),
            $m14(3),
            Kalip::toplam(100, $SON_ATAMA, ['1-13'], 'Puanlama Cetveli 1-13. maddeler'),
        ],
    ]));

// ══════════════════════════════════════════════════════════════════════════
// SOSYAL (Ek-5, 6, 8, 14) ve İLETİŞİM (Ek-7, 12)
// ══════════════════════════════════════════════════════════════════════════

$sosyalProfesorMakale = fn (string $md): array => Kalip::veya('Makale koşulu', [
    Kalip::adet('SCI-Expanded ve SSCI dergilerinde en az 2 makale', ['1a'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: $md),
    Kalip::adet('Ya da 1/b-c bentlerindeki dergilerde en az 3 makale', ['1bc'], 3, donem: Kalip::DOCENTLIK_SONRASI, madde: $md),
    Kalip::adet('Ya da TR Dizin dergilerinde en az 5 makale', ['2a'], 5, donem: Kalip::DOCENTLIK_SONRASI, madde: $md),
    Kalip::ve('Ya da 1/a\'dan 1 ve 1/b-c\'den 2 olmak üzere toplam 3 makale', [
        Kalip::adet('SCI-Expanded ve SSCI dergilerinde en az 1 makale', ['1a'], 1, donem: Kalip::DOCENTLIK_SONRASI, madde: $md),
        Kalip::adet('1/b-c bentlerinde en az 2 makale', ['1bc'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: $md),
    ]),
    Kalip::ve('Ya da 1/a\'dan 1, 1/b-c\'den 1 ve 2/a\'dan 3 olmak üzere toplam 5 makale', [
        Kalip::adet('SCI-Expanded ve SSCI dergilerinde en az 1 makale', ['1a'], 1, donem: Kalip::DOCENTLIK_SONRASI, madde: $md),
        Kalip::adet('1/b-c bentlerinde en az 1 makale', ['1bc'], 1, donem: Kalip::DOCENTLIK_SONRASI, madde: $md),
        Kalip::adet('TR Dizin dergilerinde en az 3 makale', ['2a'], 3, donem: Kalip::DOCENTLIK_SONRASI, madde: $md),
    ]),
    Kalip::ve('Ya da 1/b-c\'den 2 ve 2/a\'dan 3 olmak üzere toplam 5 makale', [
        Kalip::adet('1/b-c bentlerinde en az 2 makale', ['1bc'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: $md),
        Kalip::adet('TR Dizin dergilerinde en az 3 makale', ['2a'], 3, donem: Kalip::DOCENTLIK_SONRASI, madde: $md),
    ]),
]);

/**
 * @param  list<string>  $alanlar
 * @return list<array<string, mixed>>
 */
$sosyalSeti = fn (string $anahtar, array $alanlar, ?string $birim, string $setAdi, string $altGrup, string $ekAdi): array => $setEsikleri($anahtar, $alanlar, $birim, $setAdi, [
    'profesorluk' => [
        $sosyalProfesorMakale("{$ekAdi} · Profesör"),
        Kalip::puanDan("Puanlama Cetvelinin {$altGrup}. maddelerinden en az 250 puan", [$altGrup], 250, $DOCENTLIK, madde: "{$ekAdi} · Profesör"),
        $proje('7-P-YA', '7-P-D', $DOCENTLIK, "{$ekAdi} · Profesör"),
        $m14(7),
        Kalip::toplam(400, $DOCENTLIK, ['1-13'], 'Puanlama Cetveli 1-13. maddeler'),
    ],
    'docentlik' => [
        Kalip::puanDan("Puanlama Cetvelinin {$altGrup}. maddelerinden en az 180 puan", [$altGrup], 180, $DOKTORA, madde: "{$ekAdi} · Doçent"),
        $proje('7-P-YA', '7-P-D', $DOKTORA, "{$ekAdi} · Doçent"),
        $m14(4),
        Kalip::toplam(300, $DOKTORA, ['1-13'], 'Puanlama Cetveli 1-13. maddeler'),
    ],
    'dr_ogr_uyesi' => [
        $drIlkMakaleSosyal("{$ekAdi} · Dr. ilk atama"),
        Kalip::puanDan("Puanlama Cetvelinin {$altGrup}. maddelerinden en az 100 puan", [$altGrup], 100, madde: "{$ekAdi} · Dr. ilk atama"),
        Kalip::adet('Araştırma projelerinden en az 1 tanesinde koordinatör, yürütücü ya da araştırmacı olmak', ['7-PH-YA'], 1, madde: "{$ekAdi} · Dr. ilk atama"),
        $m14(3),
        Kalip::toplam(125, null, ['1-13'], 'Puanlama Cetveli 1-13. maddeler'),
    ],
    'dr_ogr_uyesi_yeniden' => array_merge($drYenidenOrtak(120), [$m14(3)]),
]);

$esikler = array_merge($esikler, $sosyalSeti('sosyal', ['sosyal', 'ilahiyat', 'filoloji'],
    'İktisadi ve İdari Bilimler, İlahiyat, İnsan ve Toplum Bilimleri, Turizm fakülteleri',
    'İktisadi ve İdari Bilimler, İlahiyat, İnsan ve Toplum Bilimleri ve Turizm fakülteleri',
    '1-8', 'Ek-5/6/8/14'));

$esikler = array_merge($esikler, $sosyalSeti('iletisim', ['sosyal', 'spor'],
    'İletişim ve Spor Bilimleri fakülteleri',
    'İletişim Fakültesi ve Spor Bilimleri Fakültesi',
    '1-9', 'Ek-7/12'));

return $esikler;
