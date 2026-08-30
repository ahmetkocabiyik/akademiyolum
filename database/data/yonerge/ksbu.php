<?php

/**
 * KÜTAHYA SAĞLIK BİLİMLERİ ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme
 * ve Atanma Yönergesi (İlkeler ve Kriterler)
 * Kaynak: pdf/17634002431.Kütahya Sağlık Bilimleri Üniversitesi Kriter.pdf
 * (24 sayfa; Senato 07.09.2023-19/01, ek: Senato 27.09.2024-09/04 ve
 * YÖK Genel Kurulu 24.10.2024)
 *
 * ── UYARI: BU KOŞULLAR 01.01.2027'DE YÜRÜRLÜĞE GİRİYOR ──
 * Madde 14(3): "Doktor öğretim üyesi kadrosuna yeniden atanmalar ile
 * Profesörlük kadrosuna yükseltilmede 01.01.2027 tarihine kadar
 * 2018 tarihli yönergenin uygulanmasına devam edilir." Yani bu iki
 * kadronun eşiği bugün için DEĞİL, 2027 başından sonrası için geçerli.
 * Eski yönerge (22.11.2018-2018/10/6) bu PDF'te yok; korpusta da yok.
 * İki kadronun aday notu bunu açıkça söylüyor. Doktor öğretim üyeliğine
 * İLK atanma ve doçentlik koşulları bugün de geçerli.
 *
 * ── YAPI ──
 * Tek puanlama tablosu (EK-1); koşullar yalnız PROFESÖRLÜKTE temel alana
 * göre ayrılıyor:
 *   Sağlık Bilimleri · Mühendislik ve Fen Bilimleri → toplam 600 puan,
 *       doçentlik sonrası A ve F'den 150 puan, A1'de başlıca yazar
 *   Sosyal Bilimler → toplam 500 puan, doçentlik sonrası A ve F'den
 *       100 puan, A'da başlıca yazar
 *   Mesleki ve Teknik Eğitim → toplam 400 puan, doçentlik sonrası A ve
 *       F'den 100 puan (bu doçentlik temel alanının profildeki temel
 *       alan listesinde karşılığı yok, EŞİK YAZILMADI)
 * Doktor öğretim üyeliği ve doçentlik alandan bağımsız.
 *
 * ── EŞİK YAZILMAYAN ALANLAR ──
 * Yönerge yalnız Sağlık Bilimleri, Mühendislik ve Fen Bilimleri, Sosyal
 * Bilimler ve Mesleki-Teknik Eğitim temel alanlarını anıyor. Eğitim
 * Bilimleri, hukuk, ilahiyat, filoloji, spor, ziraat, mimarlık ve güzel
 * sanatlar için eşik yazılmadı; Mesleki ve Teknik Eğitim ise profilin
 * temel alan listesinde bulunmuyor.
 *
 * ── SEÇENEKLİ KOŞULLARDA GİRİLEMEYEN ŞIKLAR ──
 * Madde 9(1)-e sekiz şıktan en az birini, madde 11(1)-f on şıktan en az
 * ikisini istiyor. Kayıttan okunamayan şıklar bu listelerden ÇIKARILDI —
 * yani koşul olduğundan ZOR görünür:
 *   "Proje YÖNETİCİSİ olarak başvuruda bulunmuş ve PANELDE bilimsel
 *       değerlendirmeye alınmış olmak" (9.e.3 ve 11.f.3): kayıt
 *       reddedilmiş bir başvuruyu tutmuyor.
 *   "Patent/faydalı buluş BAŞVURUSUNDA bulunmuş olmak" (9.e.2 ve
 *       11.f.2): kayıt yalnız alınmış patenti taşıyor; alınmış patent
 *       başvuruyu da kapsadığı için bu şık alınmış patentle karşılandı.
 *   "Teknoloji Geliştirme Bölgelerinde şirket sahibi, ortak ya da
 *       danışman olmak" (11.f.9): sözlükte karşılık yok.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde 12(3): Tıp ve Diş Hekimliği Fakültelerinde öğretim üyesi
 *       eksiği olan anabilim dallarında Üniversite Yönetim Kurulu
 *       kararıyla istisna.
 *   Madde 9(2): askerlik, sağlık, doğum izni gibi nedenlerle görev
 *       başında bulunulmayan sürelerin oranlanması.
 *   EK-1 Genel İlke 3: eserlerin kurum akademik veri yönetim sistemine
 *       yüklenmiş ve kurum adının doğru yazılmış olması.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/ksbu-2023.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Kütahya Sağlık Bilimleri Üniversitesi';
$CETVEL = 'ksbu-2023';
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;
$SON_3_YIL = Kalip::sonYil(3);

$ALANLAR = ['saglik', 'fen', 'muhendislik', 'sosyal'];

$ESKI_YONERGE_UYARISI = ' DİKKAT: yönergenin 14(3) maddesi bu kadro için 01.01.2027 tarihine '
    .'kadar 22.11.2018 tarihli ESKİ yönergenin uygulanmasını söylüyor. Aşağıdaki koşullar '
    .'01.01.2027\'den sonraki başvurular için geçerli; bugün başvuruyorsanız eski yönergenin '
    .'koşullarına bakmanız gerekir (eski yönerge bu belgede yok).';

$dil = Kalip::yds(55);

$doktora = Kalip::beyan('Doktora ya da tıpta/dişte uzmanlık unvanını almış olmak', '8');

$docentUnvani = Kalip::beyan(
    '2547 sayılı Kanunun 24. maddesi uyarınca doçentlik unvanını almış olmak', '10',
);

$besYil = Kalip::beyan(
    'Doçentlik unvanını aldıktan sonra 2547 sayılı Kanunun 26. maddesindeki süre koşulunu '
    .'sağlamış olmak',
    '11',
);

$esikler = [];

// ══════════════════════════════════════════════════════════════════════════
// DOKTOR ÖĞRETİM ÜYESİ — İLK ATANMA (Madde 8)
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'ksbu-dr-ilk',
    'aday_notu' => 'Doktor Öğretim Üyesi kadrosuna ilk atanma üç yıl için yapılıyor. Puan çizelgesinin '
        .'makale, bildiri, kitap, proje, patent, Erasmus, ödül ve tez yönetimi kategorilerinden '
        .'toplam en az 50 puan ve Üniversitelerarası Kurulun doçentlik başvurusunda kabul ettiği '
        .'yabancı dil sınavlarının birinden dil koşulu isteniyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => $ALANLAR,
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 8: yabancı dil koşulu; EK-1\'den toplam 50 puan.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna ilk atanma', [
        $doktora,
        $dil,
        Kalip::toplam(50),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// DOKTOR ÖĞRETİM ÜYESİ — YENİDEN ATANMA (Madde 9)
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'ksbu-dr-yeniden',
    'aday_notu' => 'İlk atanma tarihinizden (mükerrer atamada son atanma tarihinizden) sonraki '
        .'faaliyetleriniz sayılıyor. 50 puanı uluslararası ve ulusal '
        .'makaleler) kategorilerinden olmak üzere toplam en az 100 puan; ayrıca son üç yıl '
        .'içinde sekiz koşuldan en az birini sağlamış olmanız isteniyor. Doçentlik unvanı almış '
        .'doktor öğretim üyelerinde yeniden atanma için asgari koşul aranmıyor. Koşulları '
        .'sağlayamazsanız bir defaya mahsus iki yıllık yeniden atama yapılıyor.'
        .' Sekiz koşuldan üçü kayıttan okunamadığı için listeye alınmadı (proje başvurusunun '
        .'panelde değerlendirilmiş olması ve patent BAŞVURUSU); bu yüzden koşul olduğundan zor '
        .'görünebilir.'.$ESKI_YONERGE_UYARISI,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => $ALANLAR,
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 9: A+F\'den 50 puan, toplam 100 puan; son 3 yılda sekiz koşuldan biri.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna yeniden atanma', [
        Kalip::puanDan(
            'Son atamanızdan sonra A (uluslararası makaleler) ve F (ulusal makaleler) '
            .'kategorilerinden en az 50 puan',
            ['A-F'], 50, $SON_ATAMA, madde: '9-d',
        ),
        Kalip::toplam(100, $SON_ATAMA),
        Kalip::veya('Son üç yıl içinde sağlanması gereken sekiz koşuldan en az biri', [
            Kalip::adet(
                'Başarıyla tamamlanmış en az bir doktora, tıpta uzmanlık, dişte uzmanlık ya da '
                .'yüksek lisans tezinde danışmanlık veya eş danışmanlık yapmış olmak',
                ['TEZ'], 1, donem: $SON_3_YIL, madde: '9-e-1',
            ),
            Kalip::adet(
                'Ya da alanınızda ulusal veya uluslararası patent ya da faydalı model almış olmak',
                ['PATENT'], 1, donem: $SON_3_YIL, madde: '9-e-2',
            ),
            Kalip::adet(
                'Ya da TÜBİTAK, TÜSEB, AB veya eşdeğer kurumlarca desteklenen, devam eden ya da '
                .'tamamlanmış en az bir projede yürütücü veya araştırmacı olarak görev almak',
                ['PROJE-DIS'], 1, donem: $SON_3_YIL, madde: '9-e-4',
            ),
            Kalip::adet(
                'Ya da yükseköğretim kurumlarınca desteklenmiş ve başarıyla tamamlanmış en az '
                .'bir projede yürütücü olmak',
                ['PROJE-BAP-Y'], 1, donem: $SON_3_YIL, madde: '9-e-5',
            ),
            Kalip::adet(
                'Ya da yükseköğretim kurumlarınca desteklenmiş ve başarıyla tamamlanmış iki '
                .'projede araştırmacı olmak',
                ['PROJE-BAP'], 2, donem: $SON_3_YIL, madde: '9-e-5',
            ),
            Kalip::adet(
                'Ya da A veya F kategorisinden en az bir eserde başlıca yazar olmak',
                ['A-F'], 1, yazar: 'baslica', donem: $SON_3_YIL, madde: '9-e-6',
            ),
            Kalip::adet(
                'Ya da basım tarihi itibarıyla Q1 veya Q2 kategorisinde yer alan en az bir '
                .'makalede yazar olmak',
                ['A1-Q12'], 1, donem: $SON_3_YIL, madde: '9-e-7',
            ),
            Kalip::adet(
                'Ya da TÜBA, TÜSEB, TÜBİTAK veya eşdeğer kurumlarca verilmiş bir bilim ödülü '
                .'almış olmak',
                ['ODUL'], 1, donem: $SON_3_YIL, madde: '9-e-8',
            ),
        ]),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// DOÇENT (Madde 10)
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'ksbu-docentlik',
    'aday_notu' => 'Yönerge doçent kadrosuna atanmada ek bir koşul aramıyor: 2547 sayılı '
        .'Kanunun 24. maddesi uyarınca doçentlik unvanını almış olmanız yeterli. Puan '
        .'tablosundan bir baraj istenmiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => $ALANLAR,
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 10: doçentlik unvanı dışında ek koşul yok.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma', [$docentUnvani]),
];

// ══════════════════════════════════════════════════════════════════════════
// PROFESÖR (Madde 11)
// ══════════════════════════════════════════════════════════════════════════

/** 11(1)-f: on koşuldan en az ikisini sağlamak. */
$profesorSecenekler = [
    Kalip::veya('Doçentlik sonrası tez yönetimi', [
        Kalip::adet(
            'Doçentlik unvanınızı aldıktan sonra danışmanlığınızda en az bir doktora, tıpta '
            .'uzmanlık ya da dişte uzmanlık tezi tamamlatmış olmak',
            ['TEZ-DOKTORA'], 1, donem: $DOCENTLIK, madde: '11-f-1',
        ),
        Kalip::adet(
            'Ya da doçentlik unvanınızı aldıktan sonra iki yüksek lisans tezi tamamlatmış olmak',
            ['TEZ-YL'], 2, donem: $DOCENTLIK, madde: '11-f-1',
        ),
    ]),
    Kalip::adet(
        'Alanınızda ulusal ya da uluslararası patent veya faydalı model almış olmak',
        ['PATENT'], 1, madde: '11-f-2',
    ),
    Kalip::veya('TÜBİTAK, TÜSEB, AB ya da eşdeğer kurum projesinde görev', [
        Kalip::adet(
            'TÜBİTAK, TÜSEB, AB veya eşdeğer kurumlarca desteklenen, devam eden ya da '
            .'tamamlanmış en az bir projede yürütücü olmak',
            ['PROJE-DIS-Y'], 1, madde: '11-f-4',
        ),
        Kalip::adet(
            'Ya da bu projelerden ikisinde araştırmacı olarak görev almak',
            ['PROJE-DIS-A'], 2, madde: '11-f-4',
        ),
    ]),
    Kalip::adet(
        'Yükseköğretim kurumlarınca desteklenmiş ve başarıyla tamamlanmış, en az biri proje '
        .'yürütücüsü olmak üzere iki projede görev almak',
        ['PROJE-BAP'], 2, madde: '11-f-5',
    ),
    Kalip::adet(
        'Basım tarihi itibarıyla Q1 veya Q2 kategorisinde yer alan en az bir makalede yazar olmak',
        ['A1-Q12'], 1, madde: '11-f-6',
    ),
    Kalip::metrik(
        'İlgili bilim alanınızda yurt dışındaki bir yükseköğretim ya da araştırma kurumunda en '
        .'az üç ay süreyle çalışmış veya araştırmalarda bulunmuş olmak',
        'yurtdisi_ay', 3,
    ),
    Kalip::puanDan(
        'Bilimsel çalışmalarınıza Web of Science ya da Scopus\'ta yapılan atıflardan en az '
        .'100 puan almış olmak',
        ['ATIF-WOS'], 100, $DOCENTLIK, madde: '11-f-8',
    ),
    Kalip::adet(
        'YÖK, TÜBA, TÜSEB, TÜBİTAK veya eşdeğer kurumlarca verilmiş bir bilim ödülü almış olmak',
        ['ODUL'], 1, madde: '11-f-10',
    ),
];

foreach ([
    ['saglik-muh', ['saglik', 'fen', 'muhendislik'],
        'Sağlık Bilimleri ile Mühendislik ve Fen Bilimleri temel alanları', 600, 150,
        ['A1'], 'A1 kategorisinde (SCI-Expanded, SSCI ya da AHCI dergilerinde)', '11-b-1'],
    ['sosyal', ['sosyal'], 'Sosyal Bilimler temel alanı', 500, 100,
        ['A'], 'A kategorisinde (uluslararası makalelerde)', '11-b-3'],
] as [$anahtar, $alanlar, $alanAdi, $toplam, $afPuan, $baslicaGrup, $baslicaAd, $md]) {
    $esikler[] = [
        'anahtar' => "ksbu-{$anahtar}-profesorluk",
        'aday_notu' => "{$alanAdi} için tüm faaliyetlerinizden toplam en az {$toplam} puan isteniyor; bunun "
            .'en az 200 puanı doçentlik unvanınızı aldıktan sonraki eserlerden gelmeli. Ayrıca '
            ."doçentlik sonrası A ve F kategorilerinden en az {$afPuan} puan almanız ve "
            .mb_strtolower(mb_substr($baslicaAd, 0, 1)).mb_substr($baslicaAd, 1)
            .' en az bir eserde başlıca yazar olmanız gerekiyor. Bunlara ek olarak on koşuldan '
            .'en az ikisini sağlamalısınız. Bu on koşuldan ikisi kayıttan okunamadığı için '
            .'listeye alınmadı (proje başvurusunun panelde değerlendirilmiş olması ve '
            .'teknopark şirketi ortaklığı); koşul olduğundan zor görünebilir.'
            .$ESKI_YONERGE_UYARISI,
        'universite' => $UNIVERSITE,
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => "Madde 11 ({$alanAdi}): toplam {$toplam} puan; doçentlik sonrası 200 puan; "
            ."doçentlik sonrası A+F'den {$afPuan} puan; başlıca yazarlık; on koşuldan iki tanesi.",
        'sart' => Kalip::ve("Profesör kadrosuna yükseltilme ve atanma — {$alanAdi}", [
            $besYil,
            Kalip::toplam($toplam),
            Kalip::toplam(200, $DOCENTLIK),
            Kalip::puanDan(
                "Doçentlik unvanınızı aldıktan sonra A ve F kategorilerinden en az {$afPuan} puan",
                ['A-F'], $afPuan, $DOCENTLIK, madde: '11-c',
            ),
            Kalip::adet(
                "Doçentlik unvanınızı aldıktan sonra {$baslicaAd} en az bir eserde başlıca yazar olmak",
                $baslicaGrup, 1, yazar: 'baslica', donem: $DOCENTLIK, madde: $md,
            ),
            Kalip::kIle('On koşuldan en az ikisini sağlamak', 2, $profesorSecenekler),
        ]),
    ];
}

return $esikler;
