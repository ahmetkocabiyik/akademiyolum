<?php

/**
 * İZMİR DEMOKRASİ ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma
 * Kriterleri
 * Kaynak: pdf/17666694591.İzmir Demokrasi Üniversitesi Kriter.pdf
 *
 * PUANSIZ YÖNERGE, ALAN AYRIMI YOK. Koşulların tamamı adet tabanlı ve on iki
 * temel alanın hepsi için aynı; yönerge yalnızca Tıp ve Diş Hekimliği
 * fakültelerine bir MUAFİYET yolu açıyor (Madde 5/2), farklı bir eşik değil.
 *
 * ── KORPUSTA "EKSİK SAYI KADAR YAYIN" TELAFİSİNİN İLK ÖRNEĞİ ──
 * Tez ve proje koşullarının ikisi de aynı kalıpla esnetiliyor:
 *   "Başvurulan alanda, koşullar sebebiyle tez yönetmek mümkün değilse,
 *    birinci yazar olmak koşulu ile asgari TR Dizinde taranan dergilerde
 *    N adet daha yayın yapılması gerekmektedir."
 * Profesörlükte proje telafisi ayrıca "eksik proje sayısı kadar" diyor, yani
 * miktar açığa bağlı. Motorun `telafi_carpani` alanı bunu birebir karşılıyor
 * (Trabzon'da eklenmişti) ama YALNIZCA `puan` düğümünde işliyor, `adet`
 * düğümünde değil; bu yüzden telafiler SABİT sayıyla girildi (tam açık:
 * 2 proje eksikse 2 yayın). Bir projesi olan aday için koşul olduğundan ZOR
 * görünür — güvenli yön.
 *
 * ── İKİ TELAFİ AYNI YAYINI SAYABİLİYOR ──
 * Motor koşulları birbirinden bağımsız değerlendiriyor; bir kaynak eserin
 * başka bir koşulda kullanılıp kullanılmadığını izlemiyor (`donusumler`
 * dışında kota takibi yok). Tek bir TR Dizin yayını olan aday burada hem tez
 * hem proje telafisini karşılamış görünür, oysa yönerge ikisinde de "N adet
 * DAHA yayın" diyor. Bu, koşulu olduğundan KOLAY gösteren tek sapma; aday
 * notunda açıkça söylendi ve GIRILEMEYEN-YONERGELER.md'ye yazıldı.
 *
 * ── "BİRİNCİ VEYA İKİNCİ YAZAR" ──
 * Dr. Öğr. Üyeliği koşulları "birinci veya ikinci yazar" diyor; motorun yazar
 * süzgecinde böyle bir kademe yok, `ilk` ile girildi. İkinci yazar olduğunuz
 * yayınlar sayılmaz, koşul olduğundan zor görünür. Bkz. cetvelin başlığı.
 *
 * ── YABANCI DİL BÖLÜMÜN ÖĞRETİM DİLİNE BAĞLI ──
 * Türkçe eğitim veren bölümlerde 65, İngilizce eğitim veren bölümlerde 85.
 * Üç kadroda da aynı. Profildeki `programDili` alanına bağlandı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde 4 (askerlik, hamilelik, hastalık nedeniyle görev süresi uzatımı):
 *       süre uzatımı, adayın sağlayacağı bir koşul değil.
 *   Madde 5/2 (Tıp ve Diş Hekimliği'nde şartları sağlayan aday çıkmazsa
 *       koşulsuz atama): muafiyet yolu.
 *   Profesörlükteki "lisansüstü tezlerden üretilmiş yayın koşulu hariç"
 *       istisnası: ÜAK koşulu zaten beyan olarak duruyor, istisnası da
 *       beyanın içinde anlatıldı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip
 * cetvel: cetvel/izmir-demokrasi-turler.php
 */

use App\Enums\TemelAlan;
use App\Services\Scoring\Sart\Kalip;

$SON_UC_YIL = Kalip::sonYil(3);

$tumAlanlar = array_column(TemelAlan::cases(), 'value');

/** Üç kadroda da aynı: Türkçe bölümlerde 65, İngilizce bölümlerde 85. */
$dil = [
    'tip' => 'metrik',
    'aciklama' => 'Yabancı dil sınavı (YÖKDİL, YDS veya eşdeğeri) asgari puanı',
    'madde' => 'Madde 1/b',
    'metrik' => 'yds',
    'kademeler' => [
        'turkce' => 65,
        'yabanci_dil_30' => 85,
        'yabanci_dil_100' => 85,
        'yabanci_dil_egitimi' => 85,
    ],
];

$telafiNotu = 'Tez ve proje koşullarının ikisi de TR Dizin yayınıyla telafi edilebiliyor: '
    .'yönerge "koşullar sebebiyle tez yönetmek mümkün değilse" ya da proje şartı yerine '
    .'getirilememişse birinci yazar olduğunuz TR Dizin yayınlarını kabul ediyor. '
    .'DİKKAT: burada iki telafi BİRBİRİNDEN BAĞIMSIZ hesaplanıyor, yani aynı yayın hem tez '
    .'hem proje açığını kapatıyor gibi görünebilir. Yönerge her iki koşulda da "N adet DAHA '
    .'yayın" diyor; ikisini birden telafi edecekseniz gerçek başvuruda yayınların ayrı ayrı '
    .'olması beklenir. Ayrıca profesörlükte proje telafisi "eksik proje sayısı kadar" yayın '
    .'istiyor; burada tam açık kadar yayın arandığı için bir projesi olan aday koşulu '
    .'olduğundan zor görür.';

/**
 * "N tez yönet; mümkün değilse birinci yazar olarak N TR Dizin yayını."
 *
 * @return array<string, mixed>
 */
$tezKosulu = fn (int $sayi, string $madde): array => Kalip::adet(
    "Birinci veya tek danışman olarak en az {$sayi} lisansüstü tez yönetmiş ya da yönetiyor olmak",
    ['TEZ'],
    $sayi,
    madde: $madde,
    telafi: Kalip::adet(
        "Tez yönetmek mümkün değilse: birinci yazar olduğunuz en az {$sayi} TR Dizin yayını",
        ['TR'],
        $sayi,
        'ilk',
        madde: $madde,
    ),
);

/**
 * "N proje yürüt; eksikse eksik sayı kadar birinci yazar TR Dizin yayını."
 *
 * @return array<string, mixed>
 */
$projeKosulu = fn (int $sayi, string $madde): array => Kalip::adet(
    "Yürütücü veya araştırmacı olarak en az {$sayi} bilimsel araştırma projesi",
    ['PROJE'],
    $sayi,
    madde: $madde,
    telafi: Kalip::adet(
        "Proje şartı sağlanamıyorsa: birinci yazar olduğunuz en az {$sayi} TR Dizin yayını",
        ['TR'],
        $sayi,
        'ilk',
        madde: $madde,
    ),
);

return [
    // ══════════════════ DR. ÖĞRETİM ÜYESİ (ilk atanma) ══════════════════
    [
        'anahtar' => 'izmir-demokrasi-dr',
        'aday_notu' => 'İki yol var: ya kitap veya uluslararası indeksli bir dergide birinci '
            .'yazar olduğunuz 1 makale, ya da TR Dizinde birinci yazar olduğunuz 2 makale '
            .'(eksik sayı kadarı kitap bölümüyle de tamamlanabiliyor). Yönergenin "birinci '
            .'veya ikinci yazar" izni burada uygulanamıyor; ikinci yazar olduğunuz yayınlar '
            .'sayılmaz.',
        'universite' => 'İzmir Demokrasi Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $tumAlanlar,
        'cetvel' => 'izmir-demokrasi-turler',
        'notlar' => 'Madde 3/1-b. b.2: "lisansüstü tezlerden üretilmemek koşuluyla kendi alanında '
            .'özgün bir konuda kitap veya SSCI, SCI / SCI-E / AHCI / ESCI … dergilerde birinci '
            .'veya ikinci yazar olmak üzere en az 1 adet makale" VEYA b.3: "TR Dizinde birinci '
            .'yazar olarak en az 2 adet makale veya eksik sayı kadar kitap içi bölüm".',
        'sart' => Kalip::ve('Dr. Öğr. Üyeliğine ilk atanma', [
            $dil,
            Kalip::veya('Uluslararası yayın ya da TR Dizin yayınları', [
                Kalip::adet('Kitap ya da uluslararası indeksli dergide birinci yazar olduğunuz en az 1 makale', ['KITAP-VEYA-ULUSLARARASI'], 1, 'ilk', madde: 'Madde 3/1-b.2'),
                Kalip::adet('Ya da TR Dizinde birinci yazar olduğunuz en az 2 makale veya kitap bölümü', ['TR-VEYA-BOLUM'], 2, 'ilk', madde: 'Madde 3/1-b.3'),
            ]) + ['madde' => 'Madde 3/1-b'],
        ]),
    ],

    // ══════════════════ DR. ÖĞRETİM ÜYESİ (yeniden atanma) ══════════════════
    [
        'anahtar' => 'izmir-demokrasi-dr-yeniden',
        'aday_notu' => 'Yeniden atanmada yalnızca bu kadroda kesintisiz geçirdiğiniz son üç '
            .'yılın çalışmaları sayılıyor. Atanma süresi üç yıl (Madde 5/1).',
        'universite' => 'İzmir Demokrasi Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $tumAlanlar,
        'cetvel' => 'izmir-demokrasi-turler',
        'notlar' => 'Madde 3/1-c: "Bu kadroda kesintisiz geçirilen son 3 yıl içerisinde" c.1 '
            .'kitap veya uluslararası indeksli dergilerde en az 2 makale VEYA c.2 TR Dizinde '
            .'birinci veya ikinci yazar olarak en az 3 makale ya da eksik sayı kadar kitap '
            .'bölümü.',
        'sart' => Kalip::veya('Son üç yılda uluslararası ya da TR Dizin yayınları', [
            Kalip::adet('Kitap ya da uluslararası indeksli dergilerde en az 2 makale', ['KITAP-VEYA-ULUSLARARASI'], 2, donem: $SON_UC_YIL, madde: 'Madde 3/1-c.1'),
            Kalip::adet('Ya da TR Dizinde birinci yazar olduğunuz en az 3 makale veya kitap bölümü', ['TR-VEYA-BOLUM'], 3, 'ilk', $SON_UC_YIL, madde: 'Madde 3/1-c.2'),
        ]) + ['madde' => 'Madde 3/1-c'],
    ],

    // ══════════════════ DOÇENT ══════════════════
    [
        'anahtar' => 'izmir-demokrasi-docent',
        'aday_notu' => 'Doçentlikte üç kapı var: ÜAK doçentlik unvanı, bir tez danışmanlığı ve '
            .'bir araştırma projesi. '.$telafiNotu,
        'universite' => 'İzmir Demokrasi Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $tumAlanlar,
        'cetvel' => 'izmir-demokrasi-turler',
        'notlar' => 'Madde 2/1: a) ÜAK doçent unvanı, b) dil, c) en az 1 tez (telafi: 1 TR '
            .'Dizin yayını), ç) en az 1 proje (telafi: 1 TR Dizin yayını).',
        'sart' => Kalip::ve('Doçent kadrosuna atanma', [
            Kalip::beyan('Üniversitelerarası Kurul\'dan başvurduğunuz alanda doçent unvanını almış olmak', 'Madde 2/1-a'),
            $dil,
            $tezKosulu(1, 'Madde 2/1-c'),
            $projeKosulu(1, 'Madde 2/1-ç'),
        ]),
    ],

    // ══════════════════ PROFESÖR ══════════════════
    [
        'anahtar' => 'izmir-demokrasi-profesor',
        'aday_notu' => 'Profesörlükte tez ve proje sayıları ikiye çıkıyor. Ayrıca ÜAK\'ın '
            .'doçentlik asgari koşullarını doçentlik unvanınızdan SONRAKİ çalışmalarınızla bir '
            .'kez daha sağlamanız isteniyor (lisansüstü tez yayını koşulu hariç); o koşul '
            .'ÜAK\'ın kendi tablosuna baktığı için burada beyan olarak duruyor. '.$telafiNotu,
        'universite' => 'İzmir Demokrasi Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $tumAlanlar,
        'cetvel' => 'izmir-demokrasi-turler',
        'notlar' => 'Madde 1/1: a) 2547 md. 26 + ÜAK doçentlik asgari koşullarının doçentlik '
            .'sonrası yeniden sağlanması, b) dil, c) en az 2 tez (telafi: 2 TR Dizin yayını), '
            .'ç) en az 2 proje (telafi: eksik proje sayısı kadar TR Dizin yayını).',
        'sart' => Kalip::ve('Profesör kadrosuna atanma', [
            Kalip::beyan(
                'Üniversitelerarası Kurul\'un başvurduğunuz alan için belirlediği doçentlik asgari '
                .'koşullarını (lisansüstü tezlerden üretilmiş yayın koşulu hariç) doçentlik '
                .'unvanınızdan sonraki çalışmalarınızla yeniden sağlamış olmak',
                'Madde 1/1-a',
            ),
            $dil,
            $tezKosulu(2, 'Madde 1/1-c'),
            $projeKosulu(2, 'Madde 1/1-ç'),
        ]),
    ],
];
