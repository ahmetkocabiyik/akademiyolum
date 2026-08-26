<?php

/**
 * KTO KARATAY ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma
 * Kriterleri Yönergesi
 * Kaynak: pdf/17537102502.ktokaratayuniversitesi.pdf
 *
 * BELGEDE TARİH YOK: MADDE 11 yürürlüğü Senato kabulü ve YÖK onayına bağlıyor
 * ama tarih vermiyor. Cetvel dosyasının adındaki 2024 PDF'in oluşturma
 * tarihinden (17/05/2024).
 *
 * ── HER BARAJIN İKİ KATMANI VAR: TOPLAM VE DÖNEM PAYI ──
 * Yönerge her kadroda bir alt kapı (belirli maddelerden asgari puan) ve bir
 * toplam istiyor, sonra dipnotla İKİSİNİN DE bir yüzdesini döneme bağlıyor:
 *
 *   Profesör  alt kapı 100 · toplam 500, "belirtilen puanın en az %80'i
 *             doçentlikten sonra"          → 80 ve 400 doçentlik sonrası
 *   Doçent    alt kapı  80 · toplam 400, "en az %80'i doktoradan sonra"
 *                                          → 64 ve 320 doktora sonrası
 *   Dr. ilk   alt kapı  60 · toplam 200    (dipnot yok, aşağıya bak)
 *   Dr. yeni. A.1'den 1 adet · A-C'den 100 · toplam 250, "puanın TAMAMI ilk
 *             atamadan sonra"
 *
 * Yüzdeler sabit sayıya çevrilebildi (konvansiyon: "toplam biliniyorsa
 * yüzdeyi çevir"); dört ayrı puan düğümü olarak girildi.
 *
 * ── DR. ÖĞR. ÜYELİĞİNDE YILDIZ SAHİPSİZ ──
 * MADDE 9/c'de sayılar "60*" ve "200*" diye yıldızlı ama ALTINCI BÖLÜM'de
 * yıldızı tanımlayan dipnot YOK; dipnot yalnızca Madde 7 ve 8'in altında
 * duruyor. Kaynakta kalan bir kopyala-yapıştır izi. Tanımsız bir yıldıza
 * dönem uydurulmadı: ilk atamada puanlar kariyerin tamamından sayılıyor.
 * Aday notunda söylendi.
 *
 * ── ALAN GRUPLARI: İKİ KÜME, TEK FARK ALT KAPININ KAPSAMI ──
 * "Fen, Mühendislik ve Sağlık Bilimlerinde" alt kapı yalnızca Puanlama
 * Tablosunun A.1'inci maddesinden (SCI, SCI-Expanded, SSCI, AHCI dergileri);
 * "Sosyal, Eğitim ve Spor Bilimlerinde ve Güzel Sanatlarda" ise A.1-A.8
 * maddeleri arasından, yani A bölümünün tamamından besleniyor. Toplam
 * barajlar iki kümede de aynı.
 *
 * ANILMAYAN ALANLARA EŞİK YAZILMADI: Hukuk, İlahiyat, Filoloji, Mimarlık ve
 * Ziraat. Konvansiyonun bu duruma ayırdığı kural birebir bu: yönerge yalnızca
 * "Fen, Mühendislik, Sağlık / Sosyal, Eğitim, Spor, Güzel Sanatlar" diyorsa
 * anmadığı alanlara eşik yazmak, adaya yönergede bulunmayan bir baraj
 * göstermek olur.
 *
 * ── ATIF PUANI ALAN GRUBUNA GÖRE DEĞİŞİYOR ──
 * A.6 aynı atfı Fen/Mühendislik/Sağlık'ta 4 ve 2, ötekilerde 8 ve 4 puanla
 * veriyor. Cetvelin iki varyantı üretildi (`karatay-2024-fen` ve
 * `karatay-2024-sosyal`); eşikler kendi varyantına bağlandı.
 *
 * ── YENİDEN ATANMADA DÖNEM "İLK ATAMADAN SONRA" ──
 * Dipnot "belirtilen puanın tamamını İLK ATAMADAN sonra yaptığı
 * çalışmalardan almış olmak" diyor. Profilde ilk atama tarihi tutulmuyor,
 * yalnızca son atama var. Son atama sonrası okumak daha DAR bir pencere,
 * yani adayı daha hazır göstermeyen taraf; `SON_ATAMA_SONRASI` kullanıldı ve
 * aday notunda gerçek kapsamın daha geniş olduğu söylendi.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 5/b: öğretim üyesi temininde güçlük çekilen alanlarda Üniversite
 *       Yönetim Kurulu kararı ve rektör onayıyla bu koşulların
 *       aranmayabilmesi. Bir muafiyet yolu, adayın sağlayacağı koşul değil.
 *   MADDE 10/d: asgari puanı sağlayamayan Dr. Öğr. Üyesine bir defaya mahsus
 *       iki yıl ek süre verilebilmesi. Aday notunda anıldı.
 *   MADDE 5/g'nin "adayın kendi adının bulunduğu eserlere yaptığı atıflar
 *       değerlendirmeye alınmaz" ve "aynı eserde yapılan birden fazla atıf
 *       bir atıf sayılır" kayıtları: faaliyet kaydı ikisini de ayırt etmiyor,
 *       atıf puanı YÜKSEK çıkar (cetvel dosyasına bak).
 *   MADDE 5/f'nin belgeleme yükümlülüğü ve MADDE 6'nın kurul usulü.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/karatay-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$DR = Kalip::DOKTORA_SONRASI;
$DOC = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

/** Alt kapının beslendiği küme ve adaya gösterilecek adı, alan grubuna göre. */
$gruplar = [
    'fen' => [
        'alanlar' => ['fen', 'muhendislik', 'saglik'],
        'cetvel' => 'karatay-2024-fen',
        'kume' => 'A.1',
        'etiket' => 'SCI, SCI-Expanded, SSCI ya da AHCI dergilerindeki makalelerinizden',
    ],
    'sosyal' => [
        'alanlar' => ['sosyal', 'egitim', 'spor', 'guzel_sanatlar'],
        'cetvel' => 'karatay-2024-sosyal',
        'kume' => 'A.1-A.8',
        'etiket' => 'Makale, bildiri ve patent kalemlerinizden',
    ],
];

$onkosulNotu = 'Yönerge bu kriterleri bir ÖN KOŞUL sayıyor (Madde 5/e): sağlamak tek başına '
    .'atanmaya yetmiyor.';

$atifNotu = 'Atıf puanınız olduğundan yüksek çıkabilir: yönerge kendi yayınlarınıza '
    .'yaptığınız atıfları saymıyor ve aynı eserdeki birden çok atfı tek atıf sayıyor, '
    .'kaydınız ikisini de ayırt etmiyor.';

$muafiyetNotu = 'Öğretim üyesi temininde güçlük çekilen alanlarda bu koşullar Üniversite '
    .'Yönetim Kurulu kararı ve rektör onayıyla aranmayabiliyor (Madde 5/b); bu muafiyet '
    .'burada hesaplanamıyor.';

$esikler = [];

foreach ($gruplar as $ad => $g) {
    $altKapi = fn (int $puan, ?array $donem = null, ?string $ek = null): array => Kalip::puanDan(
        $g['etiket'].($ek ?? '')." en az {$puan} puan",
        [$g['kume']], $puan, $donem, madde: 'Puanlama Tablosu',
    );

    // ── Profesörlük (Madde 7) ──
    $esikler[] = [
        'anahtar' => "karatay-{$ad}-profesor",
        'aday_notu' => 'Dört sayısal kapı var ve hepsi aynı iki sayının parçası: alt kapıdan '
            .'100 puan (bunun 80\'i doçentliğinizden sonra) ve tablonun tamamından toplam '
            .'500 puan (bunun 400\'ü doçentliğinizden sonra). Yönerge yüzdeyi "belirtilen '
            .'puanın en az %80\'i" diye veriyor; burada sabit sayıya çevrildi. Ayrıca '
            .'doçentlik unvanınızdan sonra en az beş yıl ilgili bilim alanında çalışmış '
            .'olmanız ve yayınlarınızdan birini başlıca araştırma eseri olarak belirtmeniz '
            .'gerekiyor. '.$atifNotu.' '.$muafiyetNotu.' '.$onkosulNotu,
        'universite' => 'KTO Karatay Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $g['alanlar'],
        'cetvel' => $g['cetvel'],
        'notlar' => 'Madde 7/c: alt kapıdan en az 100 puan olması şartıyla toplam en az 500 '
            .'puan; dipnot "belirtilen puanın en az %80\'ini doçentlikten sonra yaptığı '
            .'çalışmalardan almış olmak" diyor (80 ve 400). Madde 7/a beş yıl doçentlik '
            .'kıdemi, 7/b başlıca araştırma eseri belirtme yükümlülüğü.',
        'sart' => Kalip::ve('Profesörlüğe yükseltilme ve atanma', [
            Kalip::beyan(
                'Doçentlik unvanını aldıktan sonra en az beş yıl açık bulunan profesörlük '
                .'kadrosuyla ilgili bilim alanında çalışmış olmak',
                'Madde 7/a',
            ),
            Kalip::beyan(
                'Yayınlarınızdan birini müracaat dosyasında başlıca araştırma eseri olarak '
                .'belirtmiş olmak',
                'Madde 7/b',
            ),
            $altKapi(100),
            $altKapi(80, $DOC, ' doçentlik unvanınızdan sonra'),
            Kalip::toplam(500),
            Kalip::toplam(400, $DOC),
        ]),
    ];

    // ── Doçentlik (Madde 8) ──
    $esikler[] = [
        'anahtar' => "karatay-{$ad}-docent",
        'aday_notu' => 'Alt kapıdan 80 puan (bunun 64\'ü doktoranızdan sonra) ve tablonun '
            .'tamamından toplam 400 puan (bunun 320\'si doktoranızdan sonra). Yönerge '
            .'yüzdeyi "belirtilen puanın en az %80\'i" diye veriyor; burada sabit sayıya '
            .'çevrildi. Ayrıca merkezi yabancı dil sınavından en az 65 puan isteniyor. '
            .$atifNotu.' '.$muafiyetNotu.' '.$onkosulNotu,
        'universite' => 'KTO Karatay Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $g['alanlar'],
        'cetvel' => $g['cetvel'],
        'notlar' => 'Madde 8/b: alt kapıdan en az 80 puan olması şartıyla toplam en az 400 '
            .'puan; dipnot "belirtilen puanın en az %80\'ini doktoradan sonra yaptığı '
            .'çalışmalardan almış olmak" diyor (64 ve 320). Madde 8/a merkezi yabancı dil '
            .'sınavından en az 65 puan istiyor.',
        'sart' => Kalip::ve('Doçentlik kadrosuna atanma', [
            Kalip::beyan(
                'Üniversitelerarası Kurul tarafından verilen doçentlik unvanına sahip olmak',
                '2547 sayılı Kanun md. 24',
            ),
            Kalip::yds(65),
            $altKapi(80),
            $altKapi(64, $DR, ' doktora unvanınızdan sonra'),
            Kalip::toplam(400),
            Kalip::toplam(320, $DR),
        ]),
    ];

    // ── Doktor Öğretim Üyeliğine ilk atama (Madde 9) ──
    $esikler[] = [
        'anahtar' => "karatay-{$ad}-dr",
        'aday_notu' => 'Alt kapıdan 60 puan ve tablonun tamamından toplam 200 puan; ayrıca '
            .'merkezi yabancı dil sınavından en az 60 puan. Yönergede bu iki sayı yıldızlı '
            .'ama yıldızı tanımlayan dipnot bu bölümde YOK (doçentlik ve profesörlük '
            .'bölümlerinde var); tanımsız bir yıldıza dönem uydurulmadı, puanlar kariyerinizin '
            .'tamamından sayılıyor. '.$atifNotu.' '.$muafiyetNotu.' '.$onkosulNotu,
        'universite' => 'KTO Karatay Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $g['alanlar'],
        'cetvel' => $g['cetvel'],
        'notlar' => 'Madde 9/c: alt kapıdan en az 60 puan olması şartıyla toplam en az 200 '
            .'puan. Sayılar yıldızlı ama ALTINCI BÖLÜM\'de yıldızı tanımlayan dipnot yok; '
            .'dönem uygulanmadı. Madde 9/b merkezi yabancı dil sınavından en az 60 puan, '
            .'9/a doktora, tıpta uzmanlık ya da sanatta yeterlik derecesi istiyor.',
        'sart' => Kalip::ve('Doktor Öğretim Üyeliğine ilk atanma', [
            Kalip::beyan(
                'Doktora, tıpta uzmanlık ya da sanatta yeterlik derecesi almış olmak',
                'Madde 9/a',
            ),
            Kalip::yds(60),
            $altKapi(60),
            Kalip::toplam(200),
        ]),
    ];

    // ── Doktor Öğretim Üyeliğine yeniden atanma (Madde 10) ──
    $esikler[] = [
        'anahtar' => "karatay-{$ad}-dr-yeniden",
        'aday_notu' => 'Yeniden atama dört yılda bir yapılıyor ve yabancı dil şartı '
            .'aranmıyor. Üç koşulun üçü de SON ATAMANIZDAN SONRAKİ çalışmalarınıza bakıyor: '
            .'alt kapıdan en az bir yayın, yayın-sanat-diğer bilimsel faaliyet kalemlerinden '
            .'100 puan ve tablonun tamamından toplam 250 puan. Yönerge dönemi "ilk atamadan '
            .'sonra" diye tanımlıyor; profilde ilk atama tarihi tutulmadığı için son atama '
            .'tarihiniz kullanıldı, yani gerçek kapsam burada gösterilenden GENİŞ olabilir. '
            .'Asgari puanı sağlayamazsanız rektör bir defaya mahsus iki yıl ek süre '
            .'verebiliyor (Madde 10/d). '.$atifNotu,
        'universite' => 'KTO Karatay Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $g['alanlar'],
        'cetvel' => $g['cetvel'],
        'notlar' => 'Madde 10/c: alt kapıdan en az bir adet olmak üzere, A-C kategorilerinden '
            .'en az 100 puan olması şartıyla toplam en az 250 puan; dipnot "belirtilen puanın '
            .'tamamını ilk atamadan sonra yaptığı çalışmalardan almış olmak" diyor. Profilde '
            .'ilk atama tarihi olmadığı için son atama sonrası okundu (daha dar pencere). '
            .'Madde 10/a yabancı dil şartını kaldırıyor.',
        'sart' => Kalip::ve('Doktor Öğretim Üyeliğine yeniden atanma', [
            Kalip::adet(
                $g['etiket'].' son atamanızdan sonra en az 1 yayın',
                [$g['kume']], 1, donem: $SON_ATAMA, madde: 'Madde 10/c',
            ),
            Kalip::puanDan(
                'Yayın, kitap ve diğer bilimsel faaliyet kalemlerinizden son atamanızdan '
                .'sonra en az 100 puan',
                ['A-C'], 100, $SON_ATAMA, madde: 'Madde 10/c',
            ),
            Kalip::toplam(250, $SON_ATAMA),
        ]),
    ];
}

return $esikler;
