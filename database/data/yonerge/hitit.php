<?php

use App\Services\Scoring\Sart\Kalip;

/**
 * HİTİT ÜNİVERSİTESİ — Öğretim Üyeliği Kadrolarına Yükseltilme ve Atanma
 * Yönergesi
 * Kaynak: pdf/1785851759631.hitit-kriter.pdf
 *
 * Cetvel: cetvel/hitit-2026.php
 *
 * ── EŞİKLERİN YAPISI ──
 * Yönerge her kadroda üç ayrı koşul kuruyor: (1) belirli makale
 * kategorilerinden asgari sayı ve puan, (2) proje faaliyeti, (3) toplam
 * puan ile bu toplamın "çekirdek" kategorilerden (A.1-7, B.1-4, B.7-8, N)
 * gelmesi gereken payı. Makale ve proje kategorileri temel alana göre
 * değişiyor (Tablo-2, Tablo-3, Tablo-4, Tablo-5, Tablo-6).
 *
 * ── YORUM KARARLARI (§0) ──
 *   Tablolar "Fen Bilimleri (Matematik hariç)" ile "Matematik"i ayrı
 *       gruplara koyuyor; araçtaki temel alan listesi ikisini tek başlıkta
 *       (Fen Bilimleri ve Matematik) topluyor. §0 gereği daha DAR olan
 *       kategori kümesi (A.1-3) seçildi; matematikçi adayın TR Dizin
 *       makalesi zorunlu makale koşulunu karşılamıyor görünür.
 *   Sağlık Bilimlerinde proje koşulu Temel Tıp için G.1-10, Klinik Tıp
 *       için G.1-12; ayrım profilde yok, daha dar olan G.1-10 seçildi.
 *   Madde 9/c ve 12/c "doktora/doçentlik sonrası VE son dört-beş yılda"
 *       diyor; motor iki dönem kısıtını birden uygulayamıyor, daha dar
 *       olan pencere (son dört ya da beş yıl) seçildi.
 *   Madde 9/ç ile 12/ç'nin proje koşulundan MUAFİYET yolu (son üç yılda
 *       K.6-9 faaliyeti ya da A.1/A.3'ün Q1-AHCI diliminde bir, Q2
 *       diliminde iki makale) yazıldı. Bu muafiyet belgeye ya da kurul
 *       kararına değil, doğrudan yayın ve patent sayısına bağlı olduğu
 *       için araç bunu birebir hesaplayabiliyor; §0'ın "belgeye bağlı
 *       gevşetici yolları yazma" kuralı burada işlemiyor. Muafiyetin Scopus
 *       Q1 dilimi kolu uygulanamadı: cetvelde Scopus çeyreği ESCI'den
 *       ayrılamıyor, bu yüzden yalnız SCIE-SSCI Q1 ile AHCI sayılıyor.
 *   Madde 5/1-d'nin Tıp ve Diş Hekimliği fakültelerinde puan şartını
 *       kaldırabilen istisnası yazılmadı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde 5/2'nin yeniden atama koşulları HESAPLANAMIYOR olarak duruyor:
 *       "önceki atanma tarihinden bu yana elde edilen puanın YIL BAZINDA en
 *       az 10 olması", "en az iki farklı ana kategoriden alınması" ve
 *       "toplam puanın en az yarısının A.1-5, B.1-4 veya B.7-8'den gelmesi"
 *       koşullarının üçü de motorun ifade edemediği kurallar (yıl
 *       ortalaması, kategori çeşitliliği ve oransal pay).
 *   Madde 9/b ile 12/b'nin başlıca araştırma eseri niteliği (Tablo-8) beyan
 *       olarak eklendi; eserin birinci yazarlık ve tez kökeni koşulları
 *       kayıtta ayrışmıyor.
 *   Madde 6, 7, 10, 11, 13 ve 14'ün başvuru, ön değerlendirme ve jüri
 *       usulleri.
 */

/**
 * Temel alan grupları: doktor öğretim üyeliğinde (Tablo-2) ve
 * doçentlik-profesörlükte (Tablo-3, Tablo-5) makale kategorileri ile
 * proje kategorileri (Tablo-4, Tablo-6).
 *
 * @var list<array{ad: string, anahtar: string, alan: list<string>, dr: string, dp: string, proje: string, sanat: bool}>
 */
$gruplar = [
    ['ad' => 'Fen Bilimleri, Mimarlık, Mühendislik ve Ziraat', 'anahtar' => 'fen',
        'alan' => ['fen', 'muhendislik', 'mimarlik', 'ziraat'],
        'dr' => 'A1-3', 'dp' => 'A1-3', 'proje' => 'G1-10', 'sanat' => false],
    ['ad' => 'Sağlık Bilimleri', 'anahtar' => 'saglik', 'alan' => ['saglik'],
        'dr' => 'A1-4', 'dp' => 'A1-3', 'proje' => 'G1-10', 'sanat' => false],
    ['ad' => 'Spor Bilimleri', 'anahtar' => 'spor', 'alan' => ['spor'],
        'dr' => 'A1-4', 'dp' => 'A1-4', 'proje' => 'G1-12', 'sanat' => false],
    ['ad' => 'Eğitim, Filoloji, Hukuk, İlahiyat ve Sosyal Bilimler', 'anahtar' => 'sosyal',
        'alan' => ['egitim', 'filoloji', 'hukuk', 'ilahiyat', 'sosyal'],
        'dr' => 'A1-5', 'dp' => 'A1-5', 'proje' => 'G1-12', 'sanat' => false],
    ['ad' => 'Güzel Sanatlar', 'anahtar' => 'guzel-sanatlar', 'alan' => ['guzel_sanatlar'],
        'dr' => 'A1-5', 'dp' => 'A1-5', 'proje' => 'G1-12', 'sanat' => true],
];

$KATEGORI_ADI = [
    'A1-3' => 'SCIE-SSCI, AHCI ve SCOPUS (A.1-3)',
    'A1-4' => 'SCIE-SSCI, AHCI, SCOPUS ve ESCI (A.1-4)',
    'A1-5' => 'SCIE-SSCI, AHCI, SCOPUS, ESCI ve TR Dizin (A.1-5)',
];

$CEKIRDEK_NOTU = 'Yönergenin "çekirdek" kategorileri A.1-7 (makaleler), B.1-4 ve B.7-8 '
    .'(kitaplar ve kitap bölümleri) ile N (üniversitenin kapasitesine katkı). Bildiri, atıf, '
    .'editörlük, hakemlik, proje, sanatsal etkinlik, tez danışmanlığı ve ödül puanlarınız '
    .'genel toplama giriyor ama bu alt baraja SAYILMIYOR.';

$SANAT_NOTU = 'Güzel Sanatlar alanından başvuruyorsanız ek olarak Tablo-7\'nin H bölümünde '
    .'(sanatsal, mimari, tasarım ve uygulamaya yönelik etkinlikler) en az üç etkinliğiniz '
    .'olmalı.';

/** Madde 9/ç ve 12/ç: proje koşulu ve ona bağlı muafiyet yolları. */
$projeKosulu = fn (string $projeGrubu, int $yil, string $madde): array => Kalip::veya('Proje koşulu', [
    Kalip::adet('İlgili proje kategorilerinden en az 1 kabul edilmiş ya da sonuçlanmış proje', [$projeGrubu], 1, donem: Kalip::sonYil($yil), madde: $madde),
    Kalip::adet('Son üç yılda K.6-9 kategorilerinde (patent, çeşit tescili, endüstriyel tasarım, faydalı model) en az 1 faaliyet', ['K6-9'], 1, donem: Kalip::sonYil(3), madde: $madde),
    Kalip::adet('Son üç yılda SCIE-SSCI Q1 diliminde ya da AHCI kapsamında en az 1 makale', ['Q1-AHCI'], 1, donem: Kalip::sonYil(3), madde: $madde),
    Kalip::adet('Son üç yılda SCIE-SSCI Q2 diliminde en az 2 makale', ['Q2'], 2, donem: Kalip::sonYil(3), madde: $madde),
]);

$esikler = [];

foreach ($gruplar as $g) {
    $ortak = ['universite' => 'Hitit Üniversitesi', 'alan' => $g['alan'], 'cetvel' => 'hitit-2026'];

    // ══ DOKTOR ÖĞRETİM ÜYELİĞİNE İLK ATANMA (MADDE 5/1) ══
    $drCocuklar = [
        Kalip::beyan('Doktora ya da tıpta, diş hekimliğinde, eczacılıkta veya veteriner hekimlikte uzmanlık veya sanatta yeterlik eğitimini tamamlamış olmak', 'MADDE 5/1-a'),
        Kalip::adet('Bilim alanınızla ilgili, Tablo-2\'de belirtilen kategorilerde yayımlanmış en az 3 makale', [$g['dr']], 3, madde: 'MADDE 5/1-b'),
        Kalip::toplam(24, maddeler: [$g['dr']], liste: 'MADDE 5/1-b'),
        Kalip::toplam(40, maddeler: ['TOPLAM-DR'], liste: 'MADDE 5/1-c'),
        Kalip::toplam(35, maddeler: ['CEKIRDEK'], liste: 'MADDE 5/1-c'),
    ];

    if ($g['sanat']) {
        $drCocuklar[] = Kalip::adet('Tablo-7\'nin H kategorisinde (sanatsal, mimari, tasarım ve uygulamaya yönelik etkinlikler) en az 3 etkinlik', ['H'], 3, madde: 'MADDE 5/1-ç');
    }

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'hitit-'.$g['anahtar'].'-dr',
        'kadro' => 'dr_ogr_uyesi',
        'notlar' => 'MADDE 5/1: '.$KATEGORI_ADI[$g['dr']].' kategorilerinde en az 3 makale ve bu '
            .'kategorilerden 24 puan; Tablo-7\'den toplam 40 puan ve bunun en az 35 puanı '
            .'A.1-7, B.1-4, B.7-8 ve N kategorilerinden.'
            .($g['sanat'] ? ' MADDE 5/1-ç: H kategorisinde en az 3 etkinlik.' : ''),
        'aday_notu' => $g['ad'].' alanında doktor öğretim üyeliği için zorunlu makale koşulu '
            .$KATEGORI_ADI[$g['dr']].' kategorilerinde en az üç makale ve bu kategorilerden 24 '
            .'puan. Ayrıca Tablo-7\'nin tamamından 40 puan gerekiyor ve bunun 35\'i çekirdek '
            .'kategorilerden gelmeli; yani bildiri, atıf ve hakemlik puanlarınızla '
            .'kapatabileceğiniz pay yalnızca 5 puan. '.$CEKIRDEK_NOTU
            .($g['sanat'] ? ' '.$SANAT_NOTU : '')
            .' Eğitime katkı (J) bölümü yalnızca doktor öğretim üyeliği başvurularında '
            .'sayılıyor ve en fazla 5 puan getiriyor.',
        'sart' => Kalip::ve('Doktor öğretim üyeliğine ilk atanma koşulları', $drCocuklar),
    ]);

    // ══ DOKTOR ÖĞRETİM ÜYELİĞİNE YENİDEN ATANMA (MADDE 5/2) ══
    $yenidenCocuklar = [
        Kalip::hesaplanamiyor('Önceki atanma tarihinden yeniden atanma başvurusuna kadar Tablo-7\'de en az iki farklı ana kategoriden elde edilen puanın yıl bazında en az 10 olması', 'MADDE 5/2-a'),
        Kalip::hesaplanamiyor('Bu toplam puanın en az yarısının A.1-5, B.1-4 veya B.7-8 kategorilerinden elde edilmiş olması', 'MADDE 5/2-a'),
    ];

    if ($g['sanat']) {
        $yenidenCocuklar[] = Kalip::hesaplanamiyor('Tablo-7\'nin H kategorisinde her yıl için en az bir etkinliğin bulunması', 'MADDE 5/2-c');
    }

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'hitit-'.$g['anahtar'].'-dr-yeniden',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'notlar' => 'MADDE 5/2: yıl bazında en az 10 puan, en az iki farklı ana kategori ve '
            .'toplamın yarısının A.1-5, B.1-4 veya B.7-8\'den gelmesi. Üç koşul da motorun '
            .'ifade edemediği türden (yıl ortalaması, kategori çeşitliliği, oransal pay).',
        'aday_notu' => 'Hitit\'te yeniden atanma koşulları araç tarafından HESAPLANAMIYOR. '
            .'Yönerge, önceki atanma tarihinizden bu yana topladığınız puanın YIL BAŞINA en az '
            .'10 olmasını, bu puanın en az iki farklı ana kategoriden gelmesini ve toplamın en '
            .'az yarısının A.1-5 (makaleler), B.1-4 ya da B.7-8 (kitaplar) kategorilerinden '
            .'sağlanmasını istiyor. Araç iki atama arasındaki yıl sayısını bilmiyor, kategori '
            .'çeşitliliğini ve oransal payı da hesaplayamıyor. Kendi hesabınızı Tablo-7\'yi '
            .'doldurarak yapmanız gerekiyor.'
            .($g['sanat'] ? ' Güzel Sanatlar alanında ayrıca her yıl için en az bir H kategorisi etkinliği aranıyor.' : ''),
        'sart' => Kalip::ve('Yeniden atanma koşulları', $yenidenCocuklar),
    ]);

    // ══ DOÇENTLİK (MADDE 9) ══
    $docCocuklar = [
        Kalip::beyan('Üniversitelerarası Kurul Başkanlığı tarafından verilen doçentlik belgesini almış olmak', 'MADDE 9/1-a'),
        Kalip::beyan('Doktora sonrası yayınlarınızdan birini, Tablo-8\'deki bilim alanı tanımına uygun nitelikte "Başlıca Araştırma Eseri" olarak göstermek', 'MADDE 9/1-b'),
        Kalip::adet('Son dört yılda, lisansüstü tezlerinizden üretilmemiş, Tablo-3\'te belirtilen kategorilerde en az 3 makale', [$g['dp']], 3, donem: Kalip::sonYil(4), madde: 'MADDE 9/1-c'),
        Kalip::toplam(24, donem: Kalip::sonYil(4), maddeler: [$g['dp']], liste: 'MADDE 9/1-c'),
        $projeKosulu($g['proje'], 4, 'MADDE 9/1-ç'),
        Kalip::toplam(120, maddeler: ['TOPLAM'], liste: 'MADDE 9/1-d'),
        Kalip::toplam(70, donem: Kalip::DOKTORA_SONRASI, maddeler: ['CEKIRDEK'], liste: 'MADDE 9/1-d'),
    ];

    if ($g['sanat']) {
        $docCocuklar[] = Kalip::adet('Tablo-7\'nin H kategorisinde en az 3 etkinlik', ['H'], 3, madde: 'MADDE 9/1-e');
    }

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'hitit-'.$g['anahtar'].'-docentlik',
        'kadro' => 'docentlik',
        'notlar' => 'MADDE 9: ÜAK doçentlik belgesi, başlıca araştırma eseri, son dört yılda '
            .$KATEGORI_ADI[$g['dp']].' kategorilerinde 3 makale ve 24 puan, son dört yılda bir '
            .'proje faaliyeti (muafiyet yollarıyla), toplam 120 puan ve doktora sonrası '
            .'çekirdek kategorilerden 70 puan.'
            .($g['sanat'] ? ' MADDE 9/1-e: H kategorisinde en az 3 etkinlik.' : ''),
        'aday_notu' => 'Doçentlikte makale koşulunun penceresi dar: SON DÖRT YILDA '
            .$KATEGORI_ADI[$g['dp']].' kategorilerinde en az üç makale ve bu kategorilerden 24 '
            .'puan. Proje koşulunu ya son dört yılda bir kabul edilmiş projeyle ya da üç '
            .'muafiyet yolundan biriyle sağlayabilirsiniz: son üç yılda bir patent (K.6-9), bir '
            .'Q1 ya da AHCI makalesi, veya iki Q2 makalesi. Toplam 120 puanın en az 70\'i '
            .'DOKTORA SONRASI çekirdek kategorilerden gelmeli. '.$CEKIRDEK_NOTU
            .($g['sanat'] ? ' '.$SANAT_NOTU : ''),
        'sart' => Kalip::ve('Doçentlik koşulları', $docCocuklar),
    ]);

    // ══ PROFESÖRLÜK (MADDE 12) ══
    $profCocuklar = [
        Kalip::beyan('Doçent unvanını aldıktan sonra en az beş yıl süreyle kendi bilim alanında ulusal ya da uluslararası düzeyde yayın ve faaliyette bulunmuş olmak', 'MADDE 12/1-a'),
        Kalip::beyan('Doçentlik sonrası yayınlarınızdan birini, Tablo-8\'deki bilim alanı tanımına uygun nitelikte "Başlıca Araştırma Eseri" olarak göstermek', 'MADDE 12/1-b'),
        Kalip::adet('Son beş yılda, lisansüstü tezlerinizden üretilmemiş, Tablo-5\'te belirtilen kategorilerde en az 4 makale', [$g['dp']], 4, donem: Kalip::sonYil(5), madde: 'MADDE 12/1-c'),
        Kalip::toplam(30, donem: Kalip::sonYil(5), maddeler: [$g['dp']], liste: 'MADDE 12/1-c'),
        $projeKosulu($g['proje'], 5, 'MADDE 12/1-ç'),
        Kalip::toplam(200, maddeler: ['TOPLAM'], liste: 'MADDE 12/1-d'),
        Kalip::toplam(80, donem: Kalip::DOCENTLIK_SONRASI, maddeler: ['TOPLAM'], liste: 'MADDE 12/1-d'),
        Kalip::toplam(50, donem: Kalip::DOCENTLIK_SONRASI, maddeler: ['CEKIRDEK'], liste: 'MADDE 12/1-d'),
    ];

    if ($g['sanat']) {
        $profCocuklar[] = Kalip::adet('Doçent unvanını aldıktan sonra Tablo-7\'nin H kategorisinde en az 3 etkinlik', ['H'], 3, donem: Kalip::DOCENTLIK_SONRASI, madde: 'MADDE 12/1-e');
    }

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'hitit-'.$g['anahtar'].'-profesorluk',
        'kadro' => 'profesorluk',
        'notlar' => 'MADDE 12: doçentlik sonrası beş yıl, başlıca araştırma eseri, son beş yılda '
            .$KATEGORI_ADI[$g['dp']].' kategorilerinde 4 makale ve 30 puan, son beş yılda bir '
            .'proje faaliyeti (muafiyet yollarıyla), toplam 200 puan; bunun 80\'i doçentlik '
            .'sonrası ve 50\'si doçentlik sonrası çekirdek kategorilerden.'
            .($g['sanat'] ? ' MADDE 12/1-e: doçentlik sonrası H kategorisinde en az 3 etkinlik.' : ''),
        'aday_notu' => 'Profesörlükte üç katmanlı bir puan yapısı var: Tablo-7\'den toplam 200 '
            .'puan, bunun en az 80\'i doçent unvanını aldıktan sonra ve o 80\'in en az 50\'si '
            .'çekirdek kategorilerden. Makale koşulu SON BEŞ YILA bakıyor: '
            .$KATEGORI_ADI[$g['dp']].' kategorilerinde en az dört makale ve 30 puan. Proje '
            .'koşulunda doçentlikteki muafiyet yolları burada da geçerli. '.$CEKIRDEK_NOTU
            .($g['sanat'] ? ' '.$SANAT_NOTU.' Profesörlükte bu etkinliklerin doçentlik sonrasında yapılmış olması gerekiyor.' : ''),
        'sart' => Kalip::ve('Profesörlük koşulları', $profCocuklar),
    ]);
}

return $esikler;
