<?php

/**
 * LOKMAN HEKİM ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma
 * Kriterleri Yönergesi
 * Kaynak: pdf/17634002431.Lokman Hekim Üniversitesi Kriter.pdf
 * (23 sayfa; YÖK Genel Kurulu 01.06.2022, değişiklik 21.11.2024)
 *
 * ── YAPI: KOŞULLAR FAKÜLTEYE GÖRE ──
 * Vakıf üniversitesi; Tıp, Diş Hekimliği, Eczacılık, Sağlık Bilimleri ve
 * Spor Bilimleri Fakülteleri ile Sağlık Hizmetleri MYO ve Enstitüden
 * oluşuyor. Bu yüzden yalnız iki temel alan kapsanıyor: `saglik` ve
 * `spor`. Yönerge koşulları TEMEL ALANA değil FAKÜLTEYE bağlıyor:
 *   Tıp, Diş Hekimliği, Eczacılık, Sağlık Bilimleri → `saglik`
 *   Spor Bilimleri Fakültesi ile Meslek Yüksekokulu → `spor`
 * Ayrım yalnız doktor öğretim üyeliğine İLK atanmada; yeniden atanma,
 * doçentlik ve profesörlük koşulları bütün birimlerde aynı.
 *
 * ── SEÇENEKLİ KOŞULLAR ──
 * Doçentlikte beş şarttan en az ikisi (madde 16-1-b), profesörlükte beş
 * şarttan en az ikisi (madde 21-1-d) isteniyor; `Kalip::kIle` ile.
 * Profesörlükteki beşinci şık ("c bendindeki puana EK olarak 500 puan
 * daha") toplam 1000 puan demek — o biçimde yazıldı.
 *
 * ── "SON BEŞ YIL" VE "ATAMADAN SONRAKİ DÖRT YIL" ──
 * Dr. ilk atanmada yayın koşulu "son beş yılda" (`Kalip::sonYil(5)`).
 * Yeniden atanmada "atamadan sonraki dört yıl içerisinde" deniyor;
 * atama süresi bir ile dört yıl arasında değiştiği için `SON_ATAMA_SONRASI`
 * kullanıldı — dört yıllık pencere ile son atama penceresi çakışıyor.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   "Doktora/uzmanlık çalışmasının bir parçası olmamak" koşulu (madde
 *       11-2): kayıt bir yayının tezden üretilip üretilmediğini
 *       taşımıyor; yeniden atanmada koşul OLDUĞUNDAN KOLAY görünür.
 *   Madde 11(2)-a'nın "Senato tarafından kabul edilen kurumların
 *       desteklediği ve ilgili kurum tarafından kabul edilmiş proje"
 *       koşulundaki kurum listesi yönergede yok; bütün destekli
 *       projeler sayıldı.
 *   Madde 21(1)-a: doçentlikten sonraki yasal sürenin en az iki yılını
 *       üniversitede ya da araştırma kuruluşunda geçirmek — `beyan`.
 *   Madde 20(1): doçentlikten sonra en az beş yıl çalışmış olmak —
 *       `beyan`.
 *   Madde 24(6): "asgari puanların tamamı aynı maddeden olamaz".
 *   Madde 25 istisnaları: WoS etki faktörü 5 ve üzeri dergide başlıca
 *       yazarlık, h-indeksi (doktor 5, doçent 10, profesör 15) ve Tıp
 *       Fakültesi öğretim üyesi eksiği istisnası — bunlar koşulları
 *       AŞMA yolları, eşiğe yazılmadı.
 *   Madde 24(3): lisans öğrencilerine yönelik projelerin proje şartı
 *       olan maddelerde sayılmaması.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/lokman-hekim-2022.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Lokman Hekim Üniversitesi';
$CETVEL = 'lokman-hekim-2022';
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;
$SON_5_YIL = Kalip::sonYil(5);

$dil = Kalip::yds(65);

$doktora = Kalip::beyan(
    'Doktora yapmış ya da tıpta, diş hekimliğinde veya eczacılıkta uzmanlık eğitimini '
    .'tamamlamış olmak',
    '10',
);

$docentUnvani = Kalip::beyan(
    '2547 sayılı Kanunun 24. maddesindeki esaslara göre doçentlik unvanını almış olmak ya da '
    .'yurt dışında alınan doçentlik unvanının ÜAK tarafından Türkiye\'de geçerli sayılmış olması',
    '15',
);

$besYil = Kalip::beyan(
    'Doçentlik unvanını aldıktan sonra en az beş yıl süreyle açık bulunan profesörlük kadrosuyla '
    .'ilgili bilim alanında çalışmış olmak',
    '20',
);

$ikiYil = Kalip::beyan(
    'Doçent unvanını aldıktan sonra profesörlüğe atanmak için gerekli yasal sürenin en az iki '
    .'yılını üniversitelerde ya da alanınızla ilgili bilimsel bir araştırma kuruluşunda fiilen '
    .'çalışarak geçirmek',
    '21-a',
);

/** 16(1)-b-2 ve 21(1)-d-1: bir projede yürütücü ya da iki projede araştırmacı olmak. */
$projeSarti = fn (?array $donem, string $md): array => Kalip::veya('Araştırma projesi koşulu', [
    Kalip::adet('En az bir araştırma projesinde yürütücü olmak', ['PROJE-Y'], 1, donem: $donem, madde: $md),
    Kalip::adet('Ya da iki araştırma projesinde araştırmacı olmak', ['PROJE-A'], 2, donem: $donem, madde: $md),
]);

/** 16(1)-b-3 ve 21(1)-d-4: tek yazarlı ya da editör kitap veya BKCI kitap bölümü. */
$kitapSarti = fn (?array $donem, string $md): array => Kalip::adet(
    'Atanacağınız temel alanda tek yazarlı ya da editör olarak ulusal veya uluslararası '
    .'nitelikte bilimsel bir kitap yazmış olmak ya da Web of Science Book Citation Index\'te '
    .'tanımlanan kitaplarda bölüm yazarlığı yapmış olmak',
    ['KITAP'], 1, donem: $donem, madde: $md,
);

/** 16(1)-b-1 ve 21(1)-d-3: üç ay akademik amaçlı yurt dışı deneyimi. */
$yurtdisiSarti = Kalip::metrik(
    'Atanacağınız temel alanda ya da yakından ilgili bir alanda toplam üç ay süreli, akademik '
    .'amaçlı yurt dışı deneyiminiz olmak',
    'yurtdisi_ay', 3,
);

$esikler = [];

// ══════════════════════════════════════════════════════════════════════════
// DOKTOR ÖĞRETİM ÜYESİ — İLK ATANMA (Madde 11-1)
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'lokman-hekim-saglik-dr',
    'aday_notu' => 'Tıp, Diş Hekimliği, Eczacılık ve Sağlık Bilimleri Fakülteleri için üç '
        .'koşulun TAMAMI isteniyor: son beş yılda biri özgün araştırma olmak üzere en az iki '
        .'makale (özgün araştırma, derleme ya da vaka serisi/raporu); bu makalelerden en az '
        .'birinin SCI Expanded, SSCI, AHCI, ESCI, ULAKBİM ulusal hakemli ya da uluslararası '
        .'hakemli bir dergide yayımlanmış olması; ve bu yayınlardan en az birinde başlıca yazar '
        .'olmanız. Ayrıca merkezi yabancı dil sınavlarından en az 65 puan gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['saglik'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 11(1)-a: son 5 yılda 2 makale (biri özgün araştırma); biri nitelikli '
        .'dergide; birinde başlıca yazar. Madde 11(1): yabancı dil 65.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna ilk atanma — sağlık fakülteleri', [
        $doktora,
        $dil,
        Kalip::adet(
            'Bilim alanınızla ilgili son beş yılda en az 2 makale (özgün araştırma, derleme ya '
            .'da vaka serisi/raporu) yayımlamış olmak',
            ['MAKALE'], 2, donem: $SON_5_YIL, madde: '11-1-a-1',
        ),
        Kalip::adet(
            'Bu makalelerden en az birinin özgün araştırma olması',
            ['OZGUN'], 1, donem: $SON_5_YIL, madde: '11-1-a-1',
        ),
        Kalip::adet(
            'Makalelerden en az birinin SCI Expanded, SSCI, AHCI, ESCI, ULAKBİM ulusal hakemli '
            .'ya da uluslararası hakemli bir dergide yayımlanmış olması',
            ['NITELIKLI'], 1, donem: $SON_5_YIL, madde: '11-1-a-2',
        ),
        Kalip::adet(
            'Bu yayınlardan en az birinde başlıca yazar olmak',
            ['MAKALE'], 1, yazar: 'baslica', donem: $SON_5_YIL, madde: '11-1-a-3',
        ),
    ]),
];

$esikler[] = [
    'anahtar' => 'lokman-hekim-spor-dr',
    'aday_notu' => 'Spor Bilimleri Fakültesi ile Meslek Yüksekokulu için üç koşuldan EN AZ BİRİ '
        .'yeterli: son beş yılda SCI Expanded, SSCI, AHCI ya da ESCI kapsamındaki bir dergide en '
        .'az bir özgün araştırma makalesi; ya da ULAKBİM ulusal hakemli dergilerde en az iki '
        .'özgün araştırma makalesi (en az birinde birinci isim); ya da uluslararası hakemli '
        .'dergilerde en az iki özgün araştırma makalesi. Ayrıca merkezi yabancı dil '
        .'sınavlarından en az 65 puan gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['spor'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 11(1)-b: üç seçenekten biri. Madde 11(1): yabancı dil 65.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna ilk atanma — Spor Bilimleri ve MYO', [
        $doktora,
        $dil,
        Kalip::veya('Üç yayın koşulundan en az biri', [
            Kalip::adet(
                'Son beş yılda SCI Expanded, SSCI, AHCI ya da ESCI kapsamındaki dergide en az '
                .'bir özgün araştırma makalesi yayımlamış olmak',
                ['SCI-ESCI'], 1, donem: $SON_5_YIL, madde: '11-1-b-1',
            ),
            Kalip::adet(
                'Ya da ULAKBİM tarafından taranan ulusal hakemli dergilerde en az iki özgün '
                .'araştırma makalesi yayımlamış ve en az birinde birinci isim olmak',
                ['ULAKBIM'], 2, yazar: 'baslica', madde: '11-1-b-2',
            ),
            Kalip::adet(
                'Ya da uluslararası hakemli dergilerde en az iki özgün araştırma makalesi '
                .'yayımlamış olmak',
                ['ULUSLARARASI-HAKEMLI'], 2, madde: '11-1-b-3',
            ),
        ]),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// DOKTOR ÖĞRETİM ÜYESİ — YENİDEN ATANMA (Madde 11-2)
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'lokman-hekim-dr-yeniden',
    'aday_notu' => 'Son atamanızdan sonraki dört yıl içindeki çalışmalarınız sayılıyor. SSCI, '
        .'SCI Expanded, ESCI, AHCI, Scopus, diğer uluslararası hakemli ya da TR Dizin '
        .'dergilerinde, en az birinde birinci isim olmak koşuluyla en az üç özgün makale '
        .'isteniyor. Ayrıca üç koşuldan en az birini sağlamalısınız: desteklenen bir projede '
        .'yürütücü veya yardımcı araştırmacı olmak; en az biri SSCI/SCI Expanded/ESCI/AHCI/Scopus '
        .'olmak üzere iki özgün makale daha; ya da Tablo 1 ve Tablo 2\'den toplam 100 puan. '
        .'Yayınların doktora ya da uzmanlık çalışmanızın bir parçası olmaması gerekiyor; kayıt '
        .'bunu ayırt edemediği için koşul olduğundan kolay görünebilir.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => ['saglik', 'spor'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 11(2)-a-1: 3 özgün makale (birinde birinci isim) + üç koşuldan biri.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna yeniden atanma', [
        Kalip::adet(
            'Son atamanızdan sonra SSCI, SCI Expanded, ESCI, AHCI, Scopus, diğer uluslararası '
            .'hakemli ya da TR Dizin dergilerinde en az üç özgün makale yayımlamış olmak',
            ['YENIDEN'], 3, donem: $SON_ATAMA, madde: '11-2-a-1',
        ),
        Kalip::adet(
            'Bu makalelerin en az birinde birinci isim olmak',
            ['YENIDEN'], 1, yazar: 'baslica', donem: $SON_ATAMA, madde: '11-2-a-1',
        ),
        Kalip::veya('Üç ek koşuldan en az biri', [
            Kalip::adet(
                'Senato tarafından kabul edilen kurumların desteklediği en az bir projede '
                .'yürütücü ya da yardımcı araştırmacı olmak',
                ['PROJE-Y', 'PROJE-A'], 1, donem: $SON_ATAMA, madde: '11-2-a-a',
            ),
            Kalip::adet(
                'Ya da en az biri SSCI, SCI Expanded, ESCI, AHCI veya Scopus kapsamında olmak '
                .'kaydıyla en az iki özgün makale daha yayımlamış olmak',
                ['SCI-ESCI'], 2, donem: $SON_ATAMA, madde: '11-2-a-b',
            ),
            Kalip::toplam(100, $SON_ATAMA),
        ]),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// DOÇENT (Madde 16)
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'lokman-hekim-docentlik',
    'aday_notu' => 'Doçentlik unvanına ek olarak beş koşuldan EN AZ İKİSİNİ sağlamanız '
        .'gerekiyor: üç ay akademik amaçlı yurt dışı deneyimi; bir projede yürütücü ya da iki '
        .'projede araştırmacı olmak; tek yazarlı veya editör olarak bilimsel kitap ya da BKCI '
        .'kitap bölümü; Tablo 1 ve Tablo 2\'den toplam 500 puan; en az üçünde birinci isim ve en '
        .'az ikisi SSCI/SCI Expanded/ESCI/AHCI kapsamında olmak üzere beş özgün makale.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['saglik', 'spor'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 16(1)-b: beş koşuldan en az ikisi.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma', [
        $docentUnvani,
        Kalip::kIle('Beş koşuldan en az ikisini sağlamak', 2, [
            $yurtdisiSarti,
            $projeSarti(null, '16-1-b-2'),
            $kitapSarti(null, '16-1-b-3'),
            Kalip::toplam(500, liste: 'Tablo 1 ve Tablo 2'),
            Kalip::ve('Beş özgün makale koşulu', [
                Kalip::adet(
                    'Atanacağınız temel alanda en az beş özgün makale yayımlamış olmak',
                    ['YENIDEN'], 5, madde: '16-1-b-5',
                ),
                Kalip::adet(
                    'Bu makalelerin en az üçünde birinci isim olmak',
                    ['YENIDEN'], 3, yazar: 'baslica', madde: '16-1-b-5',
                ),
                Kalip::adet(
                    'Bu makalelerin en az ikisinin SSCI, SCI Expanded, ESCI ya da AHCI '
                    .'kapsamındaki dergilerde olması',
                    ['SCI-ESCI'], 2, madde: '16-1-b-5',
                ),
            ]),
        ]),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// PROFESÖR (Madde 21)
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'lokman-hekim-profesorluk',
    'aday_notu' => 'Doçentlik unvanınızı aldıktan sonraki çalışmalarınız sayılıyor. SCI '
        .'Expanded, SSCI, AHCI ya da ESCI kapsamındaki dergilerde en az üç özgün araştırma '
        .'makalesi, Tablo 1 ve Tablo 2\'den toplam en az 500 puan ve en az dört yarıyıl ders '
        .'vermiş olmanız isteniyor. Bunlara ek olarak beş koşuldan EN AZ İKİSİNİ sağlamalısınız: '
        .'bir projede yürütücü ya da iki projede araştırmacı olmak; en az bir yüksek lisans, '
        .'doktora veya uzmanlık tezi yönetmiş olmak; üç ay akademik amaçlı yurt dışı deneyimi; '
        .'tek yazarlı veya editör olarak bilimsel kitap ya da BKCI kitap bölümü; Tablo 1 ve '
        .'Tablo 2\'den 500 puan DAHA (yani toplam 1000 puan).',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['saglik', 'spor'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 21(1): doçentlik sonrası 3 SCI/ESCI özgün makale; 500 puan; 4 yarıyıl '
        .'ders; beş koşuldan en az ikisi.',
    'sart' => Kalip::ve('Profesör kadrosuna yükseltilme ve atanma', [
        $besYil,
        $ikiYil,
        Kalip::adet(
            'Doçentlik unvanınızı aldıktan sonra SCI Expanded, SSCI, AHCI ya da ESCI '
            .'kapsamındaki dergilerde en az üç özgün araştırma makalesi yayımlamış olmak',
            ['SCI-ESCI'], 3, donem: $DOCENTLIK, madde: '21-1-b',
        ),
        Kalip::toplam(500, $DOCENTLIK, liste: 'Tablo 1 ve Tablo 2'),
        Kalip::metrik(
            'Başvurduğunuz alanda ön lisans, lisans ya da lisansüstü programlardan en az birinde '
            .'toplam dört yarıyıl ders vermiş ya da veriyor olmak',
            'ders_yariyil', 4,
        ),
        Kalip::kIle('Doçentlik sonrası beş koşuldan en az ikisini sağlamak', 2, [
            $projeSarti($DOCENTLIK, '21-1-d-1'),
            Kalip::adet(
                'Doçentlik unvanınızı aldıktan sonra en az bir yüksek lisans, doktora ya da '
                .'uzmanlık tezi yönetmiş olmak',
                ['TEZ'], 1, donem: $DOCENTLIK, madde: '21-1-d-2',
            ),
            $yurtdisiSarti,
            $kitapSarti($DOCENTLIK, '21-1-d-4'),
            Kalip::toplam(1000, $DOCENTLIK, liste: 'Tablo 1 ve Tablo 2'),
        ]),
    ]),
];

return $esikler;
