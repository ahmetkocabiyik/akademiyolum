<?php

/**
 * İSTANBUL YENİ YÜZYIL ÜNİVERSİTESİ — Öğretim Üyeliğine Atanma ve Yükseltilme
 * Yönergesi (Senato 15.11.2024 · 2024/07 ve 28.03.2025 · 2025/03;
 * YÖK Genel Kurulu onayı 30.04.2025)
 * Kaynak: pdf/17537101482.istanbulyeniyuzyiluniversitesi.pdf
 *
 * ── KORPUSTA ENDER: DOKTOR ÖĞRETİM ÜYELİĞİ TAMAMEN ADET KOŞULU ──
 * MADDE 8 dört alan grubu için puan barajı değil YAYIN SAYISI istiyor ve
 * sayıyı tablonun kategori aralıklarına bağlıyor. Puan barajı yalnızca
 * profesörlükte (75) ve yeniden atanmada (30) var — ikisi de düşük.
 *
 *   Dr. ilk atama  alana göre 1-2 yayın, puan barajı YOK
 *   Doçent         ÜAK doçentlik belgesi YETERLİ, başka koşul yok
 *   Profesör       doçentlik sonrası 2 + 2 yayın ve 75 puan,
 *                  VEYA ÜAK doçentlik şartlarını yeniden sağlamak
 *   Dr. yeniden    son üç yılda en az 1 faaliyet ve 30 puan
 *
 * ── DOÇENTLİK KAPISI KORPUSUN EN AÇIĞI ──
 * MADDE 9 tek cümle: "Doçent kadrosuna Atanma veya Yükseltilerek atanabilmek
 * için Üniversitelerarası Kurul (ÜAK) tarafından verilen doçentlik belgesi
 * yeterlidir." Ne puan ne yayın sayısı; eşik tek bir beyandan ibaret. Bu bir
 * veri eksiği değil, yönergenin kendi tercihi — aday notunda söylendi ki aday
 * eksik giriş sanmasın.
 *
 * ── PROFESÖRLÜKTE İKİ ALTERNATİF YOL ──
 * MADDE 10 üç koşulu sayıp sonunda "…veya atanacağı tarih itibariyle kendi
 * alanında doçent olduğu tarihten sonra doçent olduğu dönemin
 * Üniversitelerarası Kurul tarafından belirlenen doçentlik şartlarını yeniden
 * sağlamış olmak gerekir" diyor. "Veya" a-b-c bloğunun tamamına bağlanıyor,
 * tek başına (c)'ye değil: aday ya üç koşulu birlikte sağlayacak ya da ÜAK
 * doçentlik ölçütlerini doçentlik sonrası eserleriyle yeniden karşılayacak.
 * `Kalip::veya` iki dallı yazıldı.
 *
 * İkinci dal beyan olarak duruyor — ÜAK'ın alan başına değişen kendi cetveline
 * bağlı. Yönergenin o dala eklediği kolaylık da beyan metnine yazıldı:
 * "Lisansüstü Tezlerden Üretilmiş Yayın" koşulu yerine doçentlik sonrası
 * faaliyetlerden üretilmiş yayınlar kabul ediliyor.
 *
 * ── YENİDEN ATANMADA (a) BENDİNE DE ÜÇ YILLIK PENCERE UYGULANDI ──
 * MADDE 11 (a) "1.A1-40 veya 2.B1-31 kategorilerinden en az bir faaliyet
 * yapmış olmak" diyor ve dönem yazmıyor; (b) ise "son 3 yıl içinde en az 30
 * puan" diyor. (a) kariyerin tamamından okunursa herhangi bir faaliyeti olan
 * herkes onu zaten sağlar ve bent anlamsızlaşır. Maddenin tamamı yeniden
 * atanmayı düzenlediği ve (b) pencereyi açıkça verdiği için (a)'ya da aynı üç
 * yıllık pencere uygulandı; iki okumadan adayı daha hazır göstermeyeni bu.
 *
 * ── "KATEGORİLERİNİN BİRİNDE" ile "KATEGORİLERİNDE" AYRIMI KORUNDU ──
 * Sosyal-Hukuk paragrafı "1.A1-21, 1.A25-27 ve 1.A31 kategorilerinin BİRİNDE
 * en az iki yayın" diyor; Sanat paragrafı aynı üç aralık için "kategorilerinDE
 * en az iki yayın" diyor. Birincisi üç kümeden BİRİNDE iki yayın (dolayısıyla
 * `veya` ile üç ayrı sayı koşulu), ikincisi üçünün birleşiminde iki yayın.
 * Fark bir harf ama koşulu değiştiriyor; kaynaktaki ayrım olduğu gibi
 * korundu ve Sosyal-Hukuk dalı böylece Sanat dalından bir tık zor kaldı.
 *
 * ── ALAN KAPSAMI: DOKTOR ÖĞRETİM ÜYELİĞİ DÖRT GRUPTA ──
 * MADDE 8 yalnızca şu alanları sayıyor: Sağlık-Fen-Mühendislik, Sosyal-Beşeri-
 * İdari ve Hukuk, Sanat-Grafik Tasarımı-İç Mimarlık-Mimarlık, Spor Bilimleri.
 * İLAHİYAT, FİLOLOJİ, EĞİTİM BİLİMLERİ VE ZİRAAT ANILMIYOR; bu alanlara Dr.
 * Öğr. Üyesi eşiği yazılmadı. Doçentlik, profesörlük ve yeniden atanma
 * maddeleri alan ayrımı yapmadığı için on iki alanın hepsine yazıldı — yani
 * bu dört alanda üniversite doçentlikten itibaren kapsamda görünür.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 8'in Sağlık-Fen-Mühendislik (a) bendindeki "Doktora/Tıpta/Diş
 *       Hekimliğinde/Eczacılıkta Uzmanlık tezinden üretilmiş olabilir"
 *       parantezi ve Sosyal-Hukuk bendindeki "Doktora tezinden üretilmiş
 *       olabilir" ibaresi koşulu GENİŞLETİYOR, daraltmıyor; ayrı bir eşik
 *       gerektirmiyor, aday notunda anıldı.
 *   MADDE 5(2) ve 7(3) ön değerlendirme usulü; MADDE 6'nın ıslak imzalı
 *       beyanname yükümlülüğü belge şartı, adayın sağlayacağı bir ölçüt değil.
 *   Yabancı dil şartı yönergede geçmiyor; uydurulmadı.
 *   GEÇİCİ MADDE 1 eski başvuruların hangi usule tabi olduğunu düzenliyor.
 *
 * ── MOTORUN İZLEMEDİĞİ ÇAKIŞMA ──
 * Sağlık-Fen-Mühendislik dalında (a) bendi 1.A1-18 ve 1.A31'den iki yayın,
 * (b) bendi 1.A1-31'den bir yayın istiyor; ikinci küme birinciyi kapsıyor.
 * Yönerge büyük olasılıkla FARKLI eserler kastediyor ama motor koşulları
 * bağımsız değerlendiriyor, aynı yayın ikisini birden karşılıyor. Koşul bu
 * yüzden olduğundan KOLAY görünür; korpusun bilinen sınırlarından.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/yeni-yuzyil-2025.php
 */

use App\Enums\TemelAlan;
use App\Services\Scoring\Sart\Kalip;

$DOC = Kalip::DOCENTLIK_SONRASI;
$SON_UC_YIL = Kalip::sonYil(3);

/** Doçentlik, profesörlük ve yeniden atanma alan ayrımı yapmıyor. */
$tumAlanlar = array_column(TemelAlan::cases(), 'value');

$tezdenNotu = 'Bu yayınlar doktora ya da uzmanlık tezinizden üretilmiş olabilir; yönerge '
    .'bunu açıkça kabul ediyor.';

$sporNotu = 'Sportif kariyer bölümü (milli sporcu ve antrenör belgeleri) faaliyet kaydında '
    .'karşılık bulmadığı için puanlanamıyor; Spor Bilimleri adayıysanız puanınız olduğundan '
    .'düşük görünür.';

$dersNotu = 'Yönergede DERS VERMEK İÇİN PUAN SATIRI YOK; lisans, ön lisans ve lisansüstü '
    .'dersleriniz toplama girmiyor.';

/**
 * MADDE 8'in dört alan grubu tek farkla ayrılıyor: hangi kategori aralığından
 * kaç yayın istendiği. `$sart` çağıran tarafta kurulur.
 *
 * @param  list<string>  $alanlar
 * @param  array<string, mixed>  $sart
 * @return array<string, mixed>
 */
$dr = function (string $anahtar, array $alanlar, array $sart, string $notlar, string $adayNotu): array {
    return [
        'anahtar' => "yeni-yuzyil-dr-{$anahtar}",
        'aday_notu' => $adayNotu,
        'universite' => 'İstanbul Yeni Yüzyıl Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'cetvel' => 'yeni-yuzyil-2025',
        'notlar' => $notlar,
        'sart' => $sart,
    ];
};

return [
    // ── MADDE 8: Doktor Öğretim Üyesi, dört alan grubu ──
    $dr(
        'saglik-fen-muhendislik',
        ['saglik', 'fen', 'muhendislik'],
        Kalip::ve('Dr. Öğr. Üyesi kadrosuna atanma', [
            Kalip::adet(
                'Uluslararası indeksli ya da TR Dizin dergilerindeki makalelerinizden en az 2 yayın',
                ['1.A.1-18+31'], 2, madde: 'Madde 8/a',
            ),
            Kalip::adet(
                'Makale ve kitap kalemlerinizden en az 1 yayın',
                ['1.A.1-31'], 1, madde: 'Madde 8/b',
            ),
        ]),
        'Madde 8, Sağlık Bilimleri, Fen Bilimleri ve Mühendislik Bilimleri Temel Alanı: '
        .'"a. 1.A1-18 ve 1A.31 kategorilerinde en az iki yayın yapmış olmak … b. 1.A1-31 '
        .'kategorisinde en az bir yayın yapmış olmak." Puan barajı yok. İkinci küme '
        .'birinciyi kapsadığı için motor aynı yayınla ikisini birden karşılamış sayar.',
        'Puan barajı YOK; koşul tamamen yayın sayısı. Uluslararası indeksli ya da TR Dizin '
        .'dergilerinde iki makale, ayrıca makale veya kitap kalemlerinden bir yayın '
        .'isteniyor. '.$tezdenNotu.' Yönerge ikinci yayının farklı bir eser olmasını '
        .'kastediyor olabilir; burada ayrı ayrı değerlendirildiği için koşul olduğundan '
        .'kolay görünebilir. '.$dersNotu,
    ),
    $dr(
        'sosyal-hukuk',
        ['sosyal', 'hukuk'],
        Kalip::veya('Aşağıdaki kalem gruplarından birinde en az 2 yayın', [
            Kalip::adet(
                'Uluslararası indeksli dergilerdeki makale ve uluslararası kitaplarınızdan en az 2 yayın',
                ['1.A.1-21'], 2, madde: 'Madde 8/a',
            ),
            Kalip::adet(
                'Uluslararası yayınevi kitaplarındaki bölüm yazarlıklarınızdan en az 2 yayın',
                ['1.A.25-27'], 2, madde: 'Madde 8/a',
            ),
            Kalip::adet(
                'TR Dizin dergilerindeki makalelerinizden en az 2 yayın',
                ['1.A.31'], 2, madde: 'Madde 8/a',
            ),
        ]),
        'Madde 8, Sosyal, Beşeri, İdari Bilimler Temel Alanı ve Hukuk Bilim Alanı: '
        .'"1.A1-21, 1.A25-27 ve 1.A31 kategorilerinin BİRİNDE en az iki yayın yapmış olmak." '
        .'"Birinde" ibaresi üç kümeden birini seçtiriyor; Sanat paragrafındaki '
        .'"kategorilerinde" ifadesinden farklı, bu yüzden `veya` ile yazıldı.',
        'Puan barajı YOK; tek koşul yayın sayısı. Üç kalem grubundan HERHANGİ BİRİNDE iki '
        .'yayınınız olması yeterli — iki yayının aynı grupta olması gerekiyor, farklı '
        .'gruplardan birer yayın yetmiyor. '.$tezdenNotu.' '.$dersNotu,
    ),
    $dr(
        'sanat-mimarlik',
        ['guzel_sanatlar', 'mimarlik'],
        Kalip::ve('Dr. Öğr. Üyesi kadrosuna atanma', [
            Kalip::adet(
                'Makale ve kitap kalemlerinizden en az 2 yayın',
                ['1.A.1-21', '1.A.25-27', '1.A.31'], 2, madde: 'Madde 8/a',
            ),
            Kalip::adet(
                'Sanat eseri, mimari proje ve tasarım kalemlerinizden en az 1 eser',
                ['2.B.15-31'], 1, madde: 'Madde 8/b',
            ),
        ]),
        'Madde 8, Sanat, Grafik Tasarımı, İç Mimarlık ve Mimarlık Temel Alanı: '
        .'"a. 1.A1-21, 1.A25-27 ve 1.A31 kategorilerinde en az iki yayın yapmış olmak, '
        .'b. 2.B15-31 kategorisinde bir eseri olmak." Sosyal-Hukuk paragrafındaki '
        .'"birinde" ibaresi burada yok; üç aralığın birleşimi sayıldı.',
        'Puan barajı YOK. İki koşul var: makale ve kitap kalemlerinden toplam iki yayın '
        .'(üç grubun herhangi bir karışımı olabilir) ve sanat eseri, mimari proje ya da '
        .'tasarım kalemlerinden bir eser. Küratörlük, grafik tasarım ve sahne sanatları '
        .'performansları tabloda satırı olmadığı için sayılmıyor; ikinci koşul olduğundan '
        .'zor görünebilir. '.$dersNotu,
    ),
    $dr(
        'spor',
        ['spor'],
        Kalip::adet(
            'Makale ve kitap kalemlerinizden en az 2 yayın',
            ['1.A.1-27+31'], 2, madde: 'Madde 8/a',
        ),
        'Madde 8, Spor Bilimleri Temel Alanı: "1A1-27 ve A1.31 kategorilerinde en az iki '
        .'yayın yapmış olmak." Puan barajı yok.',
        'Puan barajı YOK; tek koşul makale ve kitap kalemlerinden iki yayın. '.$sporNotu
        .' '.$dersNotu,
    ),

    // ── MADDE 9: Doçent ──
    [
        'anahtar' => 'yeni-yuzyil-docent',
        'aday_notu' => 'Doçentlik kadrosu için ÜAK doçentlik belgesinden BAŞKA KOŞUL YOK. '
            .'Yönergenin ilgili maddesi tek cümle: "Üniversitelerarası Kurul tarafından '
            .'verilen doçentlik belgesi yeterlidir." Puan barajı, yayın sayısı ya da alan '
            .'ayrımı aranmıyor — korpusun en açık doçentlik kapısı. Bu bir veri eksiği '
            .'değil, yönergenin kendi tercihi.',
        'universite' => 'İstanbul Yeni Yüzyıl Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $tumAlanlar,
        'cetvel' => 'yeni-yuzyil-2025',
        'notlar' => 'Madde 9: "Doçent kadrosuna Atanma veya Yükseltilerek atanabilmek için '
            .'Üniversitelerarası Kurul (ÜAK) tarafından verilen doçentlik belgesi yeterlidir." '
            .'Ek koşul yok.',
        'sart' => Kalip::beyan(
            'Üniversitelerarası Kurul tarafından verilen doçentlik belgesine sahip olmak',
            'Madde 9',
        ),
    ],

    // ── MADDE 10: Profesör ──
    [
        'anahtar' => 'yeni-yuzyil-profesor',
        'aday_notu' => 'İki alternatif yol var. Birincisi üç koşulu birlikte sağlamak: '
            .'doçentliğinizden sonra Web of Science ya da Scopus çeyrekliğine giren '
            .'dergilerde iki yayın, makale ve kitap kalemlerinden iki yayın ve tablodan '
            .'75 puan. İkincisi, doçent olduğunuz dönemin ÜAK doçentlik şartlarını '
            .'doçentlik sonrası eserlerinizle yeniden sağlamak — bu yolda yönerge '
            .'"lisansüstü tezlerden üretilmiş yayın" koşulunun yerine doçentlik sonrası '
            .'faaliyetlerinizden üretilmiş yayınları kabul ediyor. İkinci yol ÜAK\'ın alan '
            .'başına değişen cetveline bağlı olduğu için burada beyan olarak duruyor. '
            .$dersNotu,
        'universite' => 'İstanbul Yeni Yüzyıl Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $tumAlanlar,
        'cetvel' => 'yeni-yuzyil-2025',
        'notlar' => 'Madde 10: "Doçentlik unvanını aldıktan sonra; a. 1A1-8 arası '
            .'kategorilerden en az 2 adet … yayın, b. 1A1-27 arası kategorilerden en az 2 '
            .'adet yayın, c. … en az 75 puan almış olmak, veya … doçentlik şartlarını '
            .'yeniden sağlamış olmak gerekir." Sondaki "veya" a-b-c bloğunun tamamına '
            .'bağlanıyor. Alan ayrımı yok.',
        'sart' => Kalip::veya('Profesör kadrosuna atanma', [
            Kalip::ve('Doçentlik sonrası yayın ve puan koşulları', [
                Kalip::adet(
                    'Doçentliğinizden sonra Web of Science ya da Scopus çeyrekliğine giren '
                    .'dergilerdeki makale ve derlemelerinizden en az 2 yayın',
                    ['1.A.1-8'], 2, donem: $DOC, madde: 'Madde 10/a',
                ),
                Kalip::adet(
                    'Doçentliğinizden sonra makale ve kitap kalemlerinizden en az 2 yayın',
                    ['1.A.1-27'], 2, donem: $DOC, madde: 'Madde 10/b',
                ),
                Kalip::toplam(75, $DOC),
            ]),
            Kalip::beyan(
                'Doçent olduğunuz dönemin Üniversitelerarası Kurul doçentlik şartlarını '
                .'doçentlik sonrası eserlerinizle yeniden sağlamış olmak (lisansüstü '
                .'tezlerden üretilmiş yayın koşulunun yerine doçentlik sonrası '
                .'faaliyetlerinizden üretilmiş yayınlar kabul edilir)',
                'Madde 10',
            ),
        ]),
    ],

    // ── MADDE 11: Doktor Öğretim Üyeliğine yeniden atanma ──
    [
        'anahtar' => 'yeni-yuzyil-dr-yeniden',
        'aday_notu' => 'İki koşul da SON ÜÇ YILDAKİ çalışmalarınıza bakıyor: yayın, atıf, '
            .'patent, proje, sanat ve tasarım kalemlerinden en az bir faaliyet ve tablodan '
            .'30 puan. Yönerge birinci koşulda dönem yazmıyor ama madde yeniden atanmayı '
            .'düzenliyor ve ikinci koşul pencereyi açıkça veriyor; kariyerin tamamından '
            .'okunsaydı herhangi bir faaliyeti olan herkes onu zaten sağlardı. '
            .'Dönem sabit üç yıllık pencere olduğu için bu eşik son atama tarihinizi '
            .'profilinize girmeseniz de hesaplanır. '.$dersNotu,
        'universite' => 'İstanbul Yeni Yüzyıl Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $tumAlanlar,
        'cetvel' => 'yeni-yuzyil-2025',
        'notlar' => 'Madde 11/1: "a. … 1. A1-40 veya 2. B 1-31 kategorilerinden en az bir '
            .'faaliyet yapmış olmak. b. Puanlama ölçütlerinde belirtilen faaliyetlerden son '
            .'3 yıl içinde en az 30 puan şartını sağlamış olmak." (a) bendinde dönem '
            .'yazmıyor; (b)\'nin penceresi ona da uygulandı (gerekçe dosya başlığında).',
        'sart' => Kalip::ve('Dr. Öğr. Üyeliğine yeniden atanma', [
            Kalip::adet(
                'Son üç yılda yayın, atıf, patent, proje, sanat ve tasarım kalemlerinizden '
                .'en az 1 faaliyet',
                ['1.A.1-40|2.B.1-31'], 1, donem: $SON_UC_YIL, madde: 'Madde 11/1-a',
            ),
            Kalip::toplam(30, $SON_UC_YIL),
        ]),
    ],
];
