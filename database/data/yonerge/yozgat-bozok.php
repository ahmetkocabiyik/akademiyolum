<?php

use App\Services\Scoring\Sart\Kalip;

/**
 * YOZGAT BOZOK ÜNİVERSİTESİ — Akademik Yükseltilme ve Atanma Yönergesi
 * Kaynak: pdf/17639920441000.yozgat-bozok-kriter-24112025.pdf
 * Cetvel: cetvel/yozgat-bozok-2025.php (Ek-1 Puanlama Tablosu)
 *
 * ── ÜÇ ALAN GRUBU, İKİSİ GİRİLDİ ──
 * Yönerge her kadroyu üç alan grubuna bölüyor:
 *   (a) Fen (Fizik, Kimya, Biyoloji), Mühendislik, Sağlık, Ziraat
 *   (b) Matematik ve İstatistik
 *   (c) Eğitim, Spor, Sosyal, Filoloji, Hukuk, İlahiyat, Mimarlık, Güzel Sanatlar
 * Bizim temel alan listemizde Matematik ve İstatistik ayrı bir alan değil, Fen
 * temel alanının içinde. Bu yüzden (b) grubu ayrı girilemedi ve Fen alanı
 * (a) grubunun eşikleriyle değerlendiriliyor. (a) grubu (b)'den daha ağır
 * olduğu için — profesörlükte Tablo-A 125'e karşı 100, doçentlikte 125'e karşı
 * 115 — Matematik ve İstatistik adayları için sonuç OLDUĞUNDAN SIKI çıkar (§0).
 * Doktor öğretim üyesi kadrolarında iki grubun puan eşikleri zaten aynı,
 * yalnız ön şart maddeleri farklı.
 *
 * ── YABANCI DİL ──
 * MADDE 8: yabancı dil şartı yalnız eğitim dili tamamen yabancı dil olan
 * birimlerde (85) ve kısmen yabancı dil olan birimlerde geçerli; diğer
 * birimlerde yönergenin genel bir dil eşiği yok. Adayın birimi kayıtta
 * taşınmadığı için tek bir beyan koşulu yazıldı, sayısal eşik yazılmadı.
 *
 * ── EĞİTİCİLERİN EĞİTİMİ SERTİFİKASI ──
 * MADDE 13 ve 15'te doktor öğretim üyesi adayı iki yoldan birini seçebiliyor:
 * sertifikası varsa Tablo-A'dan 40 puan yetiyor, yoksa 55 puan gerekiyor.
 * Sertifika kayıtta taşınmadığı için iki yol da "veya" olarak yazıldı;
 * sertifika beyan koşulu olarak duruyor, yani o dal en iyi ihtimalle
 * BELİRSİZ döner ve 55 puanlık dal kesin sonucu verir.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 18 geçiş hükmü: 30.06.2026'ya kadar başvuranlar için daha hafif
 *       koşullar öngörüyordu; bu tarih geçtiği için girilmedi.
 *   MADDE 4-5 (jüri oluşturma, ilan süreci), MADDE 6-7 (başvuru evrakı),
 *       MADDE 16-17 (komisyon ve itiraz) — süreç hükümleri, adayın
 *       niteliğine ilişkin değil.
 *   Profesörlükte "kadroya başvurulan alanda" çalışma yapmış olma koşulu —
 *       kayıt çalışmanın alanını taşımıyor.
 *   MADDE 9'un doçentlik sonrası beş yıl ve başlıca araştırma eseri
 *       koşulları 2547 sayılı Kanundan geliyor; beyan olarak yazıldı.
 */
$UNIVERSITE = 'Yozgat Bozok Üniversitesi';
$CETVEL = 'yozgat-bozok-2025';

$SERTIFIKA = Kalip::beyan(
    'Eğiticilerin eğitimi sertifikasına sahip olmak',
    'MADDE 13/15'
);

$DIL = Kalip::beyan(
    'Başvurulan birimin yabancı dil yeterlilik koşulunu sağladığını belgelemek',
    'MADDE 8'
);

/** Tablo-A alt eşiği + genel toplam; sertifikalı ve sertifikasız iki yol. */
$puanYolu = function (int $tabloAServisli, int $tabloADuz, int $toplam, ?array $donem) use ($SERTIFIKA): array {
    return Kalip::veya('Puan eşiklerini sağlamak', [
        Kalip::ve('Eğiticilerin eğitimi sertifikasıyla', [
            $SERTIFIKA,
            Kalip::toplam($tabloAServisli, $donem, ['TABLO-A'], 'Tablo-A'),
            Kalip::toplam($toplam, $donem),
        ]),
        Kalip::ve('Sertifika olmadan', [
            Kalip::toplam($tabloADuz, $donem, ['TABLO-A'], 'Tablo-A'),
            Kalip::toplam($toplam, $donem),
        ]),
    ]);
};

$ALAN_A = ['fen', 'muhendislik', 'saglik', 'ziraat'];
$ALAN_C = ['egitim', 'spor', 'sosyal', 'filoloji', 'hukuk', 'ilahiyat', 'mimarlik', 'guzel_sanatlar'];

$D = Kalip::DOCENTLIK_SONRASI;
$SON3 = Kalip::sonYil(3);

$UNVAN_DOCENT = Kalip::beyan(
    'Üniversitelerarası Kurul tarafından verilen doçentlik unvanına sahip olmak',
    'MADDE 11'
);

$PROJE_ONSART = Kalip::adet(
    'Uluslararası kuruluşlar ya da TÜBİTAK, TÜBA, Bakanlık gibi kurumlarca desteklenen bir projede koordinatör, yürütücü, araştırmacı, danışman, bursiyer ya da doktora sonrası araştırmacı olarak görev almak',
    ['PROJE-ONSART'],
    1,
    madde: 'Ön şart'
);

$sartlar = [];

// ══════════════════ PROFESÖRLÜK (MADDE 9) ══════════════════
$profOnsartA = Kalip::veya('Ön şartlardan en az birini sağlamak', [
    Kalip::adet('SCI, SCI-Expanded ya da SSCI kapsamındaki Q1-Q2 dergilerde en az iki makale yayımlamış olmak', ['A1.1-A1.2'], 2, donem: $D, madde: 'MADDE 9/a-1'),
    Kalip::adet('SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergilerde en az dört makale yayımlamış olmak', ['A1'], 4, donem: $D, madde: 'MADDE 9/a-2'),
    Kalip::adet('Uluslararası kuruluşlar ya da TÜBİTAK, TÜBA, Bakanlık gibi kurumlarca desteklenen bir projede görev almış olmak', ['PROJE-ONSART'], 1, donem: $D, madde: 'MADDE 9/a-3'),
]);

$profOnsartC = Kalip::veya('Ön şartlardan en az birini sağlamak', [
    Kalip::adet('SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergilerde en az bir makale yayımlamış olmak', ['A1'], 1, donem: $D, madde: 'MADDE 9/c-1'),
    Kalip::ve('ESCI-Scopus, diğer uluslararası indeks ya da TR Dizin dergilerinde en az üç makale yayımlamış olmak (en az biri ESCI-Scopus)', [
        Kalip::adet('ESCI, SCOPUS ya da SPORTDiscus kapsamındaki dergilerde en az bir makale yayımlamış olmak', ['A2.1'], 1, donem: $D, madde: 'MADDE 9/c-2'),
        Kalip::adet('ESCI-Scopus, diğer uluslararası indeks ya da TR Dizin dergilerinde toplam en az üç makale yayımlamış olmak', ['A2.1-A2.2-A3.1'], 3, donem: $D, madde: 'MADDE 9/c-2'),
    ]),
    Kalip::ve('ESCI-Scopus, diğer uluslararası indeks ya da TR Dizin dergilerinde en az dört makale yayımlamış olmak (en az ikisi TR Dizin)', [
        Kalip::adet('TR Dizin kapsamındaki dergilerde en az iki makale yayımlamış olmak', ['A3.1'], 2, donem: $D, madde: 'MADDE 9/c-3'),
        Kalip::adet('ESCI-Scopus, diğer uluslararası indeks ya da TR Dizin dergilerinde toplam en az dört makale yayımlamış olmak', ['A2.1-A2.2-A3.1'], 4, donem: $D, madde: 'MADDE 9/c-3'),
    ]),
    Kalip::adet('Uluslararası kuruluşlar ya da TÜBİTAK, TÜBA, Bakanlık gibi kurumlarca desteklenen bir projede görev almış olmak', ['PROJE-ONSART'], 1, donem: $D, madde: 'MADDE 9/c-4'),
]);

foreach ([['a', $ALAN_A, $profOnsartA, 125], ['c', $ALAN_C, $profOnsartC, 100]] as [$grup, $alanlar, $onsart, $tabloA]) {
    $sartlar[] = [
        'anahtar' => 'yozgat-bozok-'.$grup.'-profesorluk',
        'universite' => $UNIVERSITE,
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => 'MADDE 9: doçentlik sonrası beş yıl ve başlıca araştırma eseri beyan; alan '
            .'grubuna göre ön şart maddeleri; Tablo-A alt eşiği '.$tabloA.' ve toplam 250 puan.',
        'aday_notu' => 'Profesörlük başvurusunda puanlar doçentlik unvanını aldıktan sonraki '
            .'çalışmalardan hesaplanıyor. Doçent unvanını aldıktan sonra en az beş yıl açıktan '
            .'atanmamak üzere çalışmış olmanız ve başlıca araştırma eserinizi belirtmeniz de '
            .'gerekiyor; bunlar 2547 sayılı Kanundan gelen koşullar olduğu için beyan olarak '
            .'duruyor. Matematik ve İstatistik alanlarında Tablo-A eşiği 125 değil 100; ayrı '
            .'alan olarak girilemediği için burada 125 uygulanıyor.',
        'sart' => Kalip::ve('Profesörlük koşulları', [
            Kalip::beyan('Doçentlik unvanını aldıktan sonra en az beş yılı açıktan atanmamak üzere çalışmış olmak', 'MADDE 9'),
            Kalip::beyan('Doçentlik sonrası çalışmalarınızdan birini başlıca araştırma eseri olarak göstermek', 'MADDE 9'),
            $DIL,
            $onsart,
            Kalip::toplam($tabloA, $D, ['TABLO-A'], 'Tablo-A'),
            Kalip::toplam(250, $D),
        ]),
    ];
}

// ══════════════════ DOÇENTLİK (MADDE 11) ══════════════════
$docOnsartA = Kalip::veya('Ön şartlardan en az birini sağlamak', [
    Kalip::adet('SCI, SCI-Expanded ya da SSCI kapsamındaki Q1-Q2 dergilerde en az bir makale yayımlamış olmak', ['A1.1-A1.2'], 1, madde: 'MADDE 11/a-2'),
    $PROJE_ONSART,
]);

$docOnsartC = Kalip::veya('Ön şartlardan en az birini sağlamak', [
    Kalip::adet('SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergilerde en az bir makale yayımlamış olmak', ['A1'], 1, madde: 'MADDE 11/c-2'),
    Kalip::adet('BKCI kapsamındaki bir yayınevinde kitap ya da kitap bölümü yazarlığı veya editörlüğü yapmış olmak', ['A4.1', 'A4.2', 'A4.3'], 1, madde: 'MADDE 11/c-2'),
    Kalip::adet('Alanında tanınırlığı olan bir yayınevinde tek yazarlı kitap yayımlamış olmak', ['A4.4'], 1, yazar: 'tek', madde: 'MADDE 11/c-2'),
    $PROJE_ONSART,
]);

foreach ([['a', $ALAN_A, $docOnsartA, 125], ['c', $ALAN_C, $docOnsartC, 100]] as [$grup, $alanlar, $onsart, $tabloA]) {
    $sartlar[] = [
        'anahtar' => 'yozgat-bozok-'.$grup.'-docentlik',
        'universite' => $UNIVERSITE,
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => 'MADDE 11: doçentlik unvanı, alan grubuna göre ön şart, Tablo-A alt eşiği '
            .$tabloA.' ve toplam 200 puan.',
        'aday_notu' => 'Doçent kadrosuna başvurabilmek için Üniversitelerarası Kurulun verdiği '
            .'doçentlik unvanına sahip olmanız gerekiyor. Puanlar için yönerge bir dönem sınırı '
            .'koymuyor, bütün akademik geçmişiniz sayılıyor. Matematik ve İstatistik alanlarında '
            .'Tablo-A eşiği 125 değil 115; ayrı alan olarak girilemediği için burada 125 '
            .'uygulanıyor.',
        'sart' => Kalip::ve('Doçentlik koşulları', [
            $UNVAN_DOCENT,
            $DIL,
            $onsart,
            Kalip::toplam($tabloA, null, ['TABLO-A'], 'Tablo-A'),
            Kalip::toplam(200),
        ]),
    ];
}

// ══════════════ DOKTOR ÖĞRETİM ÜYESİ — İLK ATAMA (MADDE 13) ══════════════
$drOnsartA = Kalip::veya('Ön şartlardan en az birini sağlamak', [
    Kalip::adet('SCI, SCI-Expanded ya da SSCI kapsamındaki Q1-Q2 dergilerde en az bir makale yayımlamış olmak', ['A1.1-A1.2'], 1, madde: 'MADDE 13/a-1'),
    Kalip::ve('Q3-Q4 ya da ESCI-Scopus dergilerinde en az iki makale yayımlamış olmak (en az biri Q3-Q4)', [
        Kalip::adet('SCI, SCI-Expanded ya da SSCI kapsamındaki Q3-Q4 dergilerde en az bir makale yayımlamış olmak', ['A1.3-A1.4'], 1, madde: 'MADDE 13/a-2'),
        Kalip::adet('Q3-Q4 ya da ESCI-Scopus dergilerinde toplam en az iki makale yayımlamış olmak', ['A1.3-A1.4-A2.1'], 2, madde: 'MADDE 13/a-2'),
    ]),
    Kalip::ve('Q3-Q4, ESCI-Scopus, diğer uluslararası indeks ya da ulusal hakemli dergilerde en az üç makale yayımlamış olmak (en az biri Q3-Q4)', [
        Kalip::adet('SCI, SCI-Expanded ya da SSCI kapsamındaki Q3-Q4 dergilerde en az bir makale yayımlamış olmak', ['A1.3-A1.4'], 1, madde: 'MADDE 13/a-3'),
        Kalip::adet('Q3-Q4, ESCI-Scopus, diğer uluslararası indeks ya da ulusal hakemli dergilerde toplam en az üç makale yayımlamış olmak', ['A1.3-A3'], 3, madde: 'MADDE 13/a-3'),
    ]),
    $PROJE_ONSART,
]);

$drOnsartC = Kalip::veya('Ön şartlardan en az birini sağlamak', [
    Kalip::adet('SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergilerde en az bir makale yayımlamış olmak', ['A1'], 1, madde: 'MADDE 13/c-1'),
    Kalip::ve('ESCI-Scopus, diğer uluslararası indeks ya da ulusal hakemli dergilerde en az iki makale yayımlamış olmak (en az biri ESCI-Scopus)', [
        Kalip::adet('ESCI, SCOPUS ya da SPORTDiscus kapsamındaki dergilerde en az bir makale yayımlamış olmak', ['A2.1'], 1, madde: 'MADDE 13/c-2'),
        Kalip::adet('ESCI-Scopus, diğer uluslararası indeks ya da ulusal hakemli dergilerde toplam en az iki makale yayımlamış olmak', ['A2-A3'], 2, madde: 'MADDE 13/c-2'),
    ]),
    Kalip::ve('Diğer uluslararası indeks ya da ulusal hakemli dergilerde en az üç makale yayımlamış olmak (en az biri TR Dizin)', [
        Kalip::adet('TR Dizin kapsamındaki dergilerde en az bir makale yayımlamış olmak', ['A3.1'], 1, madde: 'MADDE 13/c-3'),
        Kalip::adet('Diğer uluslararası indeks ya da ulusal hakemli dergilerde toplam en az üç makale yayımlamış olmak', ['A2.2-A3'], 3, madde: 'MADDE 13/c-3'),
    ]),
    $PROJE_ONSART,
]);

foreach ([['a', $ALAN_A, $drOnsartA], ['c', $ALAN_C, $drOnsartC]] as [$grup, $alanlar, $onsart]) {
    $sartlar[] = [
        'anahtar' => 'yozgat-bozok-'.$grup.'-dr',
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => 'MADDE 13: alan grubuna göre ön şart; sertifikalıysa Tablo-A 40, değilse 55; '
            .'her iki yolda toplam 60 puan.',
        'aday_notu' => 'Doktor öğretim üyesi ilk atamasında yönerge puanlar için bir dönem '
            .'sınırı koymuyor. Eğiticilerin eğitimi sertifikanız varsa Tablo-A eşiği 55 yerine '
            .'40 puan; sertifika kayıtta taşınmadığı için bu yol beyan olarak duruyor ve kesin '
            .'sonucu 55 puanlık yol veriyor. Matematik ve İstatistik alanlarında puan eşikleri '
            .'aynı, yalnız ön şart maddeleri farklı; ayrı alan olarak girilemedi.',
        'sart' => Kalip::ve('Doktor öğretim üyesi ilk atama koşulları', [
            $DIL,
            $onsart,
            $puanYolu(40, 55, 60, null),
        ]),
    ];
}

// ══════════ DOKTOR ÖĞRETİM ÜYESİ — YENİDEN ATANMA (MADDE 15) ══════════
$yenidenOnsartA = Kalip::veya('Ön şartlardan en az birini sağlamak', [
    Kalip::adet('SCI, SCI-Expanded ya da SSCI kapsamındaki Q1-Q2 dergilerde en az bir makale yayımlamış olmak', ['A1.1-A1.2'], 1, donem: $SON3, madde: 'MADDE 15/a-1'),
    Kalip::ve('Q3-Q4 ya da ESCI-Scopus dergilerinde en az iki makale yayımlamış olmak (en az biri Q3-Q4)', [
        Kalip::adet('SCI, SCI-Expanded ya da SSCI kapsamındaki Q3-Q4 dergilerde en az bir makale yayımlamış olmak', ['A1.3-A1.4'], 1, donem: $SON3, madde: 'MADDE 15/a-2'),
        Kalip::adet('Q3-Q4 ya da ESCI-Scopus dergilerinde toplam en az iki makale yayımlamış olmak', ['A1.3-A1.4-A2.1'], 2, donem: $SON3, madde: 'MADDE 15/a-2'),
    ]),
    Kalip::adet('Uluslararası kuruluşlar ya da TÜBİTAK, TÜBA, Bakanlık gibi kurumlarca desteklenen bir projede görev almış olmak', ['PROJE-ONSART'], 1, donem: $SON3, madde: 'MADDE 15/a-3'),
]);

$yenidenOnsartC = Kalip::veya('Ön şartlardan en az birini sağlamak', [
    Kalip::adet('SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergilerde en az bir makale yayımlamış olmak', ['A1'], 1, donem: $SON3, madde: 'MADDE 15/c-1'),
    Kalip::ve('ESCI-Scopus, diğer uluslararası indeks ya da ulusal hakemli dergilerde en az iki makale yayımlamış olmak (en az biri ESCI-Scopus)', [
        Kalip::adet('ESCI, SCOPUS ya da SPORTDiscus kapsamındaki dergilerde en az bir makale yayımlamış olmak', ['A2.1'], 1, donem: $SON3, madde: 'MADDE 15/c-2'),
        Kalip::adet('ESCI-Scopus, diğer uluslararası indeks ya da ulusal hakemli dergilerde toplam en az iki makale yayımlamış olmak', ['A2-A3'], 2, donem: $SON3, madde: 'MADDE 15/c-2'),
    ]),
    Kalip::adet('Diğer uluslararası indeks ya da ulusal hakemli dergilerde en az üç makale yayımlamış olmak', ['A2.2-A3'], 3, donem: $SON3, madde: 'MADDE 15/c-3'),
    Kalip::adet('Kitap yazarlığı ya da editörlüğü yapmış olmak', ['A4-KITAP'], 1, donem: $SON3, madde: 'MADDE 15/c-4'),
    Kalip::adet('Uluslararası kuruluşlar ya da TÜBİTAK, TÜBA, Bakanlık gibi kurumlarca desteklenen bir projede görev almış olmak', ['PROJE-ONSART'], 1, donem: $SON3, madde: 'MADDE 15/c-5'),
]);

foreach ([['a', $ALAN_A, $yenidenOnsartA], ['c', $ALAN_C, $yenidenOnsartC]] as [$grup, $alanlar, $onsart]) {
    $sartlar[] = [
        'anahtar' => 'yozgat-bozok-'.$grup.'-dr-yeniden',
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => 'MADDE 15: son üç yıl; alan grubuna göre ön şart; sertifikalıysa Tablo-A 40, '
            .'değilse 55; her iki yolda toplam 80 puan. MADDE 18 geçiş hükmü süresi doldu.',
        'aday_notu' => 'Yeniden atanmada yalnız son üç yıl içindeki çalışmalarınız sayılıyor. '
            .'Eğiticilerin eğitimi sertifikanız varsa Tablo-A eşiği 55 yerine 40 puan; sertifika '
            .'kayıtta taşınmadığı için bu yol beyan olarak duruyor ve kesin sonucu 55 puanlık '
            .'yol veriyor. Yönergenin 30.06.2026\'ya kadar geçerli olan geçiş hükmü süresi '
            .'dolduğu için uygulanmadı.',
        'sart' => Kalip::ve('Doktor öğretim üyesi yeniden atanma koşulları', [
            $DIL,
            $onsart,
            $puanYolu(40, 55, 80, $SON3),
        ]),
    ];
}

return $sartlar;
