<?php

/**
 * ANKARA YILDIRIM BEYAZIT ÜNİVERSİTESİ — Akademik Yükseltilme ve Atanma
 * Kriterleri Yönergesi
 * Kaynak: pdf/1785505464273.Ankara Yıldırım Beyazıt Üniversitesi Kriteri
 * 16.07.2026 GK.pdf
 * Cetvel: cetvel/aybu-2026.php (iki varyant; farkları alanlara özgü
 * etkinlik tavanı)
 *
 * ── ÜÇ ALAN GRUBU ──
 * MADDE 16, 17 ve 18 zorunlu şartları üç gruba ayırıyor:
 *   (1) Sağlık, Mühendislik, Ziraat-Orman-Su Ürünleri, Fen ve Matematik
 *   (2) Sosyal-Beşeri-İdari, Spor, İlahiyat, Hukuk, Eğitim, Filoloji
 *   (3) Mimarlık-Planlama-Tasarım ve Güzel Sanatlar
 * On iki temel alanın hepsi kapsanıyor. Üçüncü grup `aybu-2026-sanat`
 * varyantına bağlı (alanlara özgü etkinlik tavanı 30 yerine 60).
 * Profesörlükte Hukuk, kitap koşulunun telafi yolundan yararlanamadığı
 * için ikinci gruptan ayrı bir eşik olarak yazıldı.
 *
 * ── YURT DIŞI DENEYİMİ VE GEÇİCİ MADDE 1 ──
 * MADDE 8 doçent ve profesör adaylarından en az altı ay yurt dışı eğitim,
 * araştırma ya da mesleki faaliyet istiyor; asgari puanın %50 fazlasını
 * makale, proje, atıf, kitap ve patent kalemlerinden alanlar bu şarttan
 * muaf. Geçici Madde 1 bu oranı 01.03.2026-01.09.2027 arasında %25 olarak
 * uyguluyor; bugün itibarıyla geçerli olan oran (%25) yazıldı: doçentlikte
 * 150, profesörlükte 200 puan.
 *
 * ── "PUANLARIN %75'İ" KOŞULLARI SABİT ALT SINIRA ÇEVRİLDİ ──
 * MADDE 11 doçentlikte kullanılan puanların en az %75'inin lisansüstü
 * eğitim sırasındaki çalışmalar dışından, MADDE 14 profesörlükte en az
 * %75'inin doçentlik başvurusu sonrasındaki çalışmalardan gelmesini
 * istiyor. Motor toplamın bir ORANINI değil sabit bir alt sınırı
 * kontrol edebiliyor; koşullar asgari puanın %75'i olarak yazıldı
 * (doçentlikte doktora sonrası 90, profesörlükte doçentlik sonrası 120
 * puan). Adayın topladığı puan asgarinin üstündeyse gerçek eşik daha
 * yüksek olur; koşul burada olduğundan HAFİF görünebilir.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 2-4 (başvuru dilekçesi, belge yükleme) ve Tablo 3'ün deneme
 *       dersi puanlama ilkeleri — süreç hükümleri; deneme dersinde
 *       başarılı olma koşulu beyan olarak yazıldı.
 *   MADDE 8'in "yüksek lisans ve/veya doktorasını yurt dışında
 *       tamamlayan öğretim üyeleri için yurt dışı deneyim şartı
 *       aranmaz" muafiyeti — beyan dalının içinde anlatıldı.
 *   Geçici Madde 2 ve 3 — süresi dolmuş ya da geçiş hükmü.
 *   MADDE 16'nın Mimarlık ve Güzel Sanatlar satırındaki "uluslararası
 *       nitelikte en az üç karma sergi" koşulunda serginin uluslararası
 *       olma kaydı: karma etkinlik satırı ulusal ve uluslararası
 *       etkinlikleri birlikte taşıyor, ayrım yapılamadı.
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Ankara Yıldırım Beyazıt Üniversitesi';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$DIL = Kalip::yds(65);
$DIL_NOT = Kalip::beyan(
    'Öğretim dili %100 yabancı dilde olan bölümlerde ilgili yabancı dilden en az 85 puan; Türk Musikisi Devlet Konservatuvarına yapılacak atamalarda en az 55 puan',
    'MADDE 7'
);
$DENEME = Kalip::beyan(
    'Öğretim üyeliğine ilk kez atanacak adaylar için beş öğretim üyesinden oluşan komisyon önünde verilen deneme dersinde 100 üzerinden en az 70 puan almak',
    'MADDE 5'
);
$UNVAN = Kalip::beyan(
    'ÜAK tarafından verilen ya da denkliği kabul edilen doçentlik unvanına sahip olmak',
    'MADDE 9'
);

$NOT_CETVEL = ' Ortak çalışmalarda puan Tablo 2\'nin yazar sayısı × isim sırası matrisine göre '
    .'hesaplanıyor (iki yazarlıda birinci isim %95; yedi ve daha fazla yazarlıda yedinci ve '
    .'sonraki isimler %40). Başlıkların çoğunda azami puan var: ödül 35, diğer etkinlikler 30, '
    .'atıf, eğitim-öğretim, tez ve editörlük 20\'şer, bilimsel toplantı 15 puan. Makalelere '
    .'verilen "iş birliğiyle üretilmişse %25 ek puan" kuralı, kayıt ortak yazarların kurumunu '
    .'taşımadığı için uygulanmıyor.';

/** MADDE 8: yurt dışı deneyimi ya da asgari puanın %25 fazlası. */
$yurtDisi = fn (int $esik): array => Kalip::veya('Yurt dışı deneyimi şartını sağlamak', [
    Kalip::beyan('Lisansüstü eğitiminiz sırasında ya da doktora sonrası en az altı ay yurt dışında eğitim, araştırma veya mesleki faaliyette bulunmuş olmak (yüksek lisans ve/veya doktorasını yurt dışında tamamlayanlar bu şarttan muaftır)', 'MADDE 8'),
    Kalip::puanDan(
        'Makale, proje, atıf, kitap ve patent kalemlerinden en az '.$esik.' puan almak (asgari puanın %25 fazlası)',
        ['MAKALE-PROJE-ATIF-KITAP-PATENT'], $esik, madde: 'MADDE 8 / Geçici Madde 1'
    ),
]);

$PROJE = fn (?array $donem = null): array => Kalip::adet(
    'Devam eden ya da tamamlanmış en az bir projede yürütücü veya araştırmacı olarak görev almak',
    ['PROJE'], 1, donem: $donem, madde: 'Zorunlu Şartlar'
);
$BILDIRI = Kalip::adet(
    'Uluslararası bilimsel toplantıda sunulan, tam metni ya da özeti yayımlanmış en az bir bildiri (poster hariç)',
    ['BILDIRI-TAM'], 1, madde: 'MADDE 16'
);
$A = fn (string $ad, string $grup, int $n, ?array $donem = null): array => Kalip::adet(
    $ad, [$grup], $n, donem: $donem, madde: 'Zorunlu Şartlar'
);

$esikler = [];

// ═══════ MADDE 10 ve 13: tez yönetimi koşulu ve telafi yolu ═══════
$tezKosulu = function (int $tez, int $wos, int $scopus, bool $grup1) use ($A): array {
    $telafi = $grup1
        ? $A('Bunun yerine WoS Q1, Q2 veya Q3 dergilerinde en az '.$wos.' makale yayımlamış olmak', 'WOS-Q1-Q3', $wos)
        : Kalip::veya('Tez yönetimi yerine ek yayın koşulunu sağlamak', [
            Kalip::adet('WoS Q1, Q2 veya Q3 dergilerinde en az '.$wos.' makale yayımlamış olmak', ['WOS-Q1-Q3'], $wos, madde: 'MADDE 10/13'),
            Kalip::adet('Scopus ya da TR Dizin dergilerinde en az '.$scopus.' makale yayımlamış olmak', ['SCOPUS-TR'], $scopus, madde: 'MADDE 10/13'),
        ]);

    return Kalip::veya('Tez yönetimi koşulunu ya da telafisini sağlamak', [
        Kalip::adet('Asıl ya da eş danışman olarak en az '.$tez.' yüksek lisans veya doktora/uzmanlık tezi yönetmiş olmak', ['TEZ'], $tez, madde: 'MADDE 10/13'),
        $telafi,
    ]);
};

/**
 * Bir alan grubunun dört kadrosunu üretir.
 *
 * @param  list<string>  $alanlar
 * @param  list<array<string, mixed>>  $drZorunlu
 * @param  list<array<string, mixed>>  $docZorunlu
 * @param  list<array<string, mixed>>  $profZorunlu
 */
$grup = function (string $kod, array $alanlar, string $ad, string $cetvel, bool $grup1,
    array $drZorunlu, array $docZorunlu, array $profZorunlu, array $yenidenYayin) use (&$esikler, $UNIVERSITE, $DIL, $DIL_NOT, $DENEME, $UNVAN, $DOKTORA, $DOCENTLIK,
    $SON_ATAMA, $NOT_CETVEL, $yurtDisi, $tezKosulu): void {
    $esikler[] = [
        'anahtar' => "aybu-{$kod}-dr",
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'cetvel' => $cetvel,
        'notlar' => $ad.' doktor öğretim üyeliği (MADDE 16): zorunlu şartlar ve Tablo 1\'den '
            .'toplam 80 puan.',
        'aday_notu' => $ad.' için doktor öğretim üyesi kadrosuna atanma. Yönerge ilk atamada '
            .'dönem sınırı koymuyor, bütün akademik geçmişiniz sayılıyor. Öğretim üyeliğine ilk '
            .'kez atanacak her aday deneme dersine alınıyor ve komisyondan 100 üzerinden en az '
            .'70 puan alması gerekiyor.'.$NOT_CETVEL,
        'sart' => Kalip::ve('Doktor öğretim üyesi kadrosuna atanma — '.$ad,
            array_values([$DIL, $DIL_NOT, $DENEME, ...$drZorunlu, Kalip::toplam(80)])),
    ];

    $esikler[] = [
        'anahtar' => "aybu-{$kod}-dr-yeniden",
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $alanlar,
        'cetvel' => $cetvel,
        'notlar' => $ad.' doktor öğretim üyeliğine yeniden atanma (MADDE 6): zorunlu şartlar '
            .'aranmıyor; bir önceki görev süresinden itibaren asgari puanın %50\'si (40 puan) '
            .'ve alan grubuna özgü yayın koşulu.',
        'aday_notu' => $ad.' için doktor öğretim üyesi kadrosuna YENİDEN ATANMA. MADDE 6 '
            .'uyarınca MADDE 16\'daki zorunlu şartları sağlama zorunluluğu YOK; bir önceki '
            .'görev süresinin başlamasından ya da uzatımından itibaren asgari puanın %50\'si '
            .'kadar puan (40) ve alan grubunuza özgü yayın koşulu aranıyor.'.$NOT_CETVEL,
        'sart' => Kalip::ve('Doktor öğretim üyesi kadrosuna yeniden atanma — '.$ad,
            array_values([$DIL, $DIL_NOT, ...$yenidenYayin, Kalip::toplam(40, $SON_ATAMA)])),
    ];

    $esikler[] = [
        'anahtar' => "aybu-{$kod}-docentlik",
        'universite' => $UNIVERSITE,
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'cetvel' => $cetvel,
        'notlar' => $ad.' doçentlik (MADDE 17): zorunlu şartlar, dört yarıyıl ders, tez '
            .'yönetimi, yurt dışı deneyimi ve Tablo 1\'den toplam 120 puan.',
        'aday_notu' => $ad.' için doçent kadrosuna atanma. Doçentlik unvanının yanı sıra en az '
            .'dört yarıyıl (iki yıl) ders vermiş olmanız, asıl ya da eş danışman olarak en az '
            .'bir tez yönetmiş olmanız (yoksa ek yayın koşulu) ve en az altı ay yurt dışı '
            .'deneyiminiz (yoksa 150 puanlık ek yayın koşulu) gerekiyor. MADDE 11 kullanılan '
            .'puanların en az %75\'inin lisansüstü eğitim sırasındaki çalışmalar dışından '
            .'gelmesini istiyor; bu koşul asgari puanın %75\'i olarak (doktora sonrası 90 puan) '
            .'yazıldı.'.$NOT_CETVEL,
        'sart' => Kalip::ve('Doçent kadrosuna atanma — '.$ad, array_values([
            $UNVAN, $DIL, $DIL_NOT,
            Kalip::metrik('Ön lisans, lisans ya da lisansüstü programlarından en az birinde asgari dört yarıyıl (iki yıl) ders vermiş olmak', 'ders_yariyil', 4),
            $tezKosulu(1, 1, 2, $grup1),
            $yurtDisi(150),
            ...$docZorunlu,
            Kalip::toplam(120),
            Kalip::toplam(90, $DOKTORA),
        ])),
    ];

    $esikler[] = [
        'anahtar' => "aybu-{$kod}-profesorluk",
        'universite' => $UNIVERSITE,
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'cetvel' => $cetvel,
        'notlar' => $ad.' profesörlük (MADDE 18): zorunlu şartlar, altı yarıyıl ders, iki tez '
            .'yönetimi, yurt dışı deneyimi ve Tablo 1\'den toplam 160 puan.',
        'aday_notu' => $ad.' için profesör kadrosuna atanma. En az altı yarıyıl (üç yıl) ders '
            .'vermiş olmanız, öğretim üyeliği süresi boyunca asıl ya da eş danışman olarak en '
            .'az iki tez yönetmiş olmanız (yoksa ek yayın koşulu) ve en az altı ay yurt dışı '
            .'deneyiminiz (yoksa 200 puanlık ek yayın koşulu) gerekiyor. MADDE 14 kullanılan '
            .'puanların en az %75\'inin doçentlik başvurusundan sonraki çalışmalardan gelmesini '
            .'istiyor; bu koşul asgari puanın %75\'i olarak (doçentlik sonrası 120 puan) '
            .'yazıldı.'.$NOT_CETVEL,
        'sart' => Kalip::ve('Profesör kadrosuna atanma — '.$ad, array_values([
            $UNVAN, $DIL, $DIL_NOT,
            Kalip::metrik('Ön lisans, lisans ya da lisansüstü programlarından en az birinde asgari altı yarıyıl (üç yıl) ders vermiş olmak', 'ders_yariyil', 6),
            $tezKosulu(2, 2, 4, $grup1),
            $yurtDisi(200),
            ...$profZorunlu,
            Kalip::toplam(160),
            Kalip::toplam(120, $DOCENTLIK),
        ])),
    ];
};

// ── GRUP 1: Sağlık, Mühendislik, Ziraat, Fen ──
$grup('g1', ['saglik', 'muhendislik', 'ziraat', 'fen'],
    'Sağlık, Mühendislik, Ziraat-Orman-Su Ürünleri ile Fen ve Matematik', 'aybu-2026', true,
    [
        Kalip::veya('Makale koşullarından en az birini sağlamak', [
            $A('WoS kapsamındaki Q1 veya Q2 dergilerinde en az bir makale yayımlamış olmak', 'WOS-Q1-Q2', 1),
            $A('WoS kapsamındaki Q3 dergilerinde en az üç makale yayımlamış olmak', 'WOS-Q3', 3),
        ]),
        $BILDIRI,
        $PROJE(),
    ],
    [
        Kalip::veya('Makale koşullarından en az birini sağlamak', [
            $A('WoS kapsamındaki Q1 veya Q2 dergilerinde en az iki makale yayımlamış olmak', 'WOS-Q1-Q2', 2),
            Kalip::ve('Q1-Q2\'de bir, Q3\'te iki makale olmak üzere toplam üç makale', [
                Kalip::adet('WoS kapsamındaki Q1 veya Q2 dergilerinde en az bir makale yayımlamış olmak', ['WOS-Q1-Q2'], 1, madde: 'MADDE 17'),
                Kalip::adet('WoS kapsamındaki Q3 dergilerinde en az iki makale yayımlamış olmak', ['WOS-Q3'], 2, madde: 'MADDE 17'),
            ]),
            $A('WoS kapsamındaki Q3 dergilerinde en az dört makale yayımlamış olmak', 'WOS-Q3', 4),
        ]),
        $PROJE(),
    ],
    [
        Kalip::veya('Makale koşullarından en az birini sağlamak', [
            $A('WoS kapsamındaki Q1 veya Q2 dergilerinde en az üç makale yayımlamış olmak', 'WOS-Q1-Q2', 3),
            Kalip::ve('Q1-Q2\'de iki, Q3\'te iki makale olmak üzere toplam dört makale', [
                Kalip::adet('WoS kapsamındaki Q1 veya Q2 dergilerinde en az iki makale yayımlamış olmak', ['WOS-Q1-Q2'], 2, madde: 'MADDE 18'),
                Kalip::adet('WoS kapsamındaki Q3 dergilerinde en az iki makale yayımlamış olmak', ['WOS-Q3'], 2, madde: 'MADDE 18'),
            ]),
            Kalip::ve('Q1-Q2\'de bir, Q3\'te dört makale olmak üzere toplam beş makale', [
                Kalip::adet('WoS kapsamındaki Q1 veya Q2 dergilerinde en az bir makale yayımlamış olmak', ['WOS-Q1-Q2'], 1, madde: 'MADDE 18'),
                Kalip::adet('WoS kapsamındaki Q3 dergilerinde en az dört makale yayımlamış olmak', ['WOS-Q3'], 4, madde: 'MADDE 18'),
            ]),
            $A('WoS kapsamındaki Q3 dergilerinde en az altı makale yayımlamış olmak', 'WOS-Q3', 6),
        ]),
        $PROJE(),
    ],
    [$A('SCIE veya SSCI kapsamındaki dergilerde en az bir yayın yapmış olmak', 'SCIE-SSCI', 1, Kalip::SON_ATAMA_SONRASI)]);

// ── GRUP 2 ve 3'ün ortak makale koşulları ──
$g23Dr = Kalip::veya('Makale koşullarından en az birini sağlamak', [
    $A('WoS kapsamındaki Q1, Q2 veya Q3 dergilerinde en az bir makale yayımlamış olmak', 'WOS-Q1-Q3', 1),
    $A('Scopus, SPORT Discus, ESCI, AHCI, ASCI ya da TR Dizin dergilerinde en az üç makale yayımlamış olmak', 'SCOPUS-TR', 3),
]);
$g23Doc = Kalip::veya('Makale koşullarından en az birini sağlamak', [
    $A('WoS kapsamındaki Q1, Q2 veya Q3 dergilerinde en az iki makale yayımlamış olmak', 'WOS-Q1-Q3', 2),
    Kalip::ve('WoS Q1-Q3\'te bir, Scopus-TR Dizin\'de iki makale olmak üzere toplam üç makale', [
        Kalip::adet('WoS kapsamındaki Q1, Q2 veya Q3 dergilerinde en az bir makale yayımlamış olmak', ['WOS-Q1-Q3'], 1, madde: 'MADDE 17'),
        Kalip::adet('Scopus, SPORT Discus, ESCI, AHCI, ASCI ya da TR Dizin dergilerinde en az iki makale yayımlamış olmak', ['SCOPUS-TR'], 2, madde: 'MADDE 17'),
    ]),
    $A('Scopus, SPORT Discus, ESCI, AHCI, ASCI ya da TR Dizin dergilerinde en az dört makale yayımlamış olmak', 'SCOPUS-TR', 4),
]);
$g23Prof = Kalip::veya('Makale koşullarından en az birini sağlamak', [
    $A('WoS kapsamındaki Q1, Q2 veya Q3 dergilerinde en az üç makale yayımlamış olmak', 'WOS-Q1-Q3', 3),
    Kalip::ve('WoS Q1-Q3\'te iki, Scopus-TR Dizin\'de iki makale olmak üzere toplam dört makale', [
        Kalip::adet('WoS kapsamındaki Q1, Q2 veya Q3 dergilerinde en az iki makale yayımlamış olmak', ['WOS-Q1-Q3'], 2, madde: 'MADDE 18'),
        Kalip::adet('Scopus, SPORT Discus, ESCI, AHCI, ASCI ya da TR Dizin dergilerinde en az iki makale yayımlamış olmak', ['SCOPUS-TR'], 2, madde: 'MADDE 18'),
    ]),
    Kalip::ve('WoS Q1-Q3\'te bir, Scopus-TR Dizin\'de beş makale olmak üzere toplam altı makale', [
        Kalip::adet('WoS kapsamındaki Q1, Q2 veya Q3 dergilerinde en az bir makale yayımlamış olmak', ['WOS-Q1-Q3'], 1, madde: 'MADDE 18'),
        Kalip::adet('Scopus, SPORT Discus, ESCI, AHCI, ASCI ya da TR Dizin dergilerinde en az beş makale yayımlamış olmak', ['SCOPUS-TR'], 5, madde: 'MADDE 18'),
    ]),
    $A('Scopus, SPORT Discus, ESCI, AHCI, ASCI ya da TR Dizin dergilerinde en az altı makale yayımlamış olmak', 'SCOPUS-TR', 6),
]);
$g23Yeniden = [Kalip::veya('Yeniden atanma yayın koşulunu sağlamak', [
    Kalip::adet('SCIE, SSCI ya da AHCI kapsamındaki dergilerde en az bir yayın yapmış olmak', ['SCIE-SSCI', 'M.a.ahci'], 1, donem: Kalip::SON_ATAMA_SONRASI, madde: 'MADDE 6'),
    Kalip::adet('Scopus, ESCI ya da TR Dizin dergilerinde en az iki yayın yapmış olmak', ['SCOPUS-TR'], 2, donem: Kalip::SON_ATAMA_SONRASI, madde: 'MADDE 6'),
])];

// ── GRUP 2: Sosyal, Spor, İlahiyat, Eğitim, Filoloji (Hukuk hariç) ──
$grup('g2', ['sosyal', 'spor', 'ilahiyat', 'egitim', 'filoloji'],
    'Sosyal-Beşeri-İdari Bilimler, Spor, İlahiyat, Eğitim ve Filoloji', 'aybu-2026', false,
    [$g23Dr, $BILDIRI, $PROJE()],
    [$g23Doc, $PROJE(),
        Kalip::adet('Alanında ulusal ya da uluslararası yayımlanmış en az bir kitap veya kitap bölümü (ders kitabı hariç)', ['KITAP'], 1, madde: 'MADDE 17'),
    ],
    [$g23Prof, $PROJE(),
        Kalip::veya('Kitap koşulunu ya da telafisini sağlamak', [
            Kalip::adet('Alanında ulusal ya da uluslararası yayımlanmış en az bir kitap (ders kitabı hariç)', ['KITAP'], 1, madde: 'MADDE 18'),
            Kalip::adet('Bu koşul karşılanmamışsa WoS Q1, Q2, Q3 ya da Scopus dergilerinde ilave bir makale yayımlamış olmak', ['WOS-Q1-Q3-SCOPUS'], 1, madde: 'MADDE 18'),
        ]),
    ],
    $g23Yeniden);

// ── HUKUK (profesörlükte kitap koşulunun telafi yolu yok) ──
$grup('hukuk', ['hukuk'], 'Hukuk', 'aybu-2026', false,
    [$g23Dr, $BILDIRI, $PROJE()],
    [$g23Doc, $PROJE(),
        Kalip::adet('Alanında ulusal ya da uluslararası yayımlanmış en az bir kitap veya kitap bölümü (ders kitabı hariç)', ['KITAP'], 1, madde: 'MADDE 17'),
    ],
    [$g23Prof, $PROJE(),
        Kalip::adet('Alanında ulusal ya da uluslararası yayımlanmış en az bir kitap (ders kitabı hariç). Hukuk Temel Alanında bu koşulun makale ile telafisi yok.', ['KITAP'], 1, madde: 'MADDE 18'),
    ],
    $g23Yeniden);

// ── GRUP 3: Mimarlık, Planlama ve Tasarım ile Güzel Sanatlar ──
$grup('g3', ['mimarlik', 'guzel_sanatlar'],
    'Mimarlık, Planlama ve Tasarım ile Güzel Sanatlar', 'aybu-2026-sanat', false,
    [$g23Dr, Kalip::kIle('Aşağıdaki öncülerden en az ikisini sağlamak', 2, [
        $BILDIRI,
        $PROJE(),
        $A('Uluslararası nitelikte en az üç karma sergi ya da sanatsal etkinliğe katılmak', 'AO.f', 3),
        $A('Alanlara özgü etkinlikler kaleminde en az üç etkinliğiniz bulunmak', 'ALANLARA-OZGU', 3),
    ])],
    [$g23Doc, $PROJE(),
        Kalip::veya('Sanatsal etkinlik koşulunu sağlamak', [
            Kalip::adet('Uluslararası nitelikte en az beş karma sergiye katılmak', ['AO.f'], 5, madde: 'MADDE 17'),
            Kalip::adet('Alanlara özgü etkinlikler kaleminde en az beş etkinliğiniz bulunmak', ['ALANLARA-OZGU'], 5, madde: 'MADDE 17'),
        ]),
    ],
    [$g23Prof, $PROJE(),
        Kalip::veya('Sanatsal etkinlik koşulunu sağlamak', [
            Kalip::adet('Uluslararası nitelikte en az altı karma sergiye katılmak', ['AO.f'], 6, madde: 'MADDE 18'),
            Kalip::adet('Alanlara özgü etkinlikler kaleminde en az altı etkinliğiniz bulunmak', ['ALANLARA-OZGU'], 6, madde: 'MADDE 18'),
        ]),
    ],
    $g23Yeniden);

return $esikler;
