<?php

/**
 * AYDIN ADNAN MENDERES ÜNİVERSİTESİ — Öğretim Üyeliği Kadrolarına
 * Yükseltilme ve Atanmalarda Aranan Değerlendirme Ölçütleri ve Puanlama
 * Yönergesi
 * Kaynak: pdf/17634002431.Aydın Adnan Menderes Üniversitesi.pdf
 * Cetvel: cetvel/adu-2024.php (Ek.1 Akademik Değerlendirme Puan Tablosu)
 *
 * ── EŞİKLER FAKÜLTEYE GÖRE, TEMEL ALANA GÖRE DEĞİL ──
 * Ek 3'ün on iki alt tablosu temel alan yerine FAKÜLTE sayıyor. İki temel
 * alanda birden fazla tablo çakışıyor ve `birim` ayrımı gerekti:
 *   Sağlık Bilimleri → "Tıp, Sağlık Bilimleri ve Hemşirelik Fakülteleri"
 *       (Ek 3a1), "Veteriner Fakültesi" (Ek 3a2) ve "Diş Hekimliği
 *       Fakültesi" (Ek 3k).
 *   Fen Bilimleri → "Fen-Edebiyat Fakültesi Fizik, Kimya ve Biyoloji
 *       Bölümleri" (Ek 3c) ve "Fen-Edebiyat Fakültesi Matematik Bölümü"
 *       (Ek 3d).
 * Öbür tablolar tek temel alana düştüğü için birim ayrımı gerekmedi:
 * Ek 3b Ziraat, Ek 3e Mühendislik ile Mimarlık, Ek 3f Eğitim, Ek 3g Güzel
 * Sanatlar, Ek 3h Sosyal ile İlahiyat (İslami İlimler Fakültesi bu tabloda
 * sayılıyor), Ek 3i Filoloji, Ek 3j Spor. HUKUK temel alanı yönergenin
 * hiçbir tablosunda geçmiyor; §0 uyarınca eşik yazılmadı.
 *
 * ── C2 (DERS VERME) KOŞULLARI HESAPLANAMIYOR ──
 * Ek 3'ün birçok satırı "C2'den 20/30/40/50/60 puan" istiyor. C2 puanlarını
 * DERS SAATİ başına veriyor (0,25 ve 0,5 puan/saat), faaliyet kaydı ise
 * ders saatini taşımıyor; bu koşullar `hesaplanamiyor` olarak duruyor.
 * "C1-C2'den 60 puan" biçimindeki birleşik koşullarda ise C1'den 60 puan
 * arandı: C2 sayılamadığı için tek başına C1'e yüklenmesi koşulu
 * OLDUĞUNDAN SIKI yapıyor (§0), ama sağlanabilir bir hedef (üç doktora tez
 * yöneticiliği 60 puan eder).
 *
 * ── PROFESÖRLÜKTE ÜAK SEÇENEĞİ ──
 * Bütün profesörlük satırları "yürürlükteki doçentlik temel alan
 * koşullarını bir kez daha tekrarlamak VEYA A tablosundan şu kadar puan"
 * diyor. Birinci seçenek ÜAK'ın kendi tablolarına dayandığı ve bu motorda
 * hesaplanmadığı için `hesaplanamiyor` olarak, ikinci seçenek puan koşulu
 * olarak yazıldı.
 *
 * ── DOÇENTLİKTE ZAMAN PENCERESİ ──
 * Madde 5(8): doçent kadrosuna başvuran adayın öngörülen puanı "doçentlik
 * başvurusu yaptığı tarih ile kadroya başvurduğu tarih arasında" sağlaması
 * gerekiyor. Motor doçentlik BAŞVURU tarihini değil doçentlik unvanının
 * alındığı tarihi tutuyor; pencere DOÇENTLİK SONRASI olarak yazıldı. Unvan
 * tarihi başvuru tarihinden sonra olduğu için pencere DARALIYOR, yani
 * koşul burada olduğundan sıkı görünür.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde 5(11): "Ek 3'te C1 ve C2'den öngörülen puanlar, programı olmayan
 *       birimlerde aranmaz" muafiyeti — koşulu hafifletir (§0).
 *   Madde 5(9): 2026 Mart döneminden itibaren doçentlik sözlü sınavı —
 *       beyan olarak yazıldı.
 *   Madde 5(14): doktor öğretim üyesi ve doçent adayları için deneme dersi
 *       ve EK-4 değerlendirme formundan 60 puan — beyan.
 *   Madde 5(13): 50/d araştırma görevlilerinin doktor öğretim üyeliği
 *       puanını sağlaması — bu motorda araştırma görevlisi kadrosu yok.
 *   Madde 5(10)'un "atıflarda doçentlik öncesi çalışmalara yapılan atıflar
 *       da dikkate alınır" istisnası: motor dönem kısıtını kategori bazında
 *       gevşetemiyor, profesörlük toplamına doçentlik sonrası kısıtı
 *       bütünüyle uygulandı — koşul olduğundan SIKI görünür.
 *   Ziraat doktor öğretim üyeliğindeki "lisansüstü tezlerinden üretilen
 *       yayınlar hariç" kaydı — kayıt yayının tezden üretildiğini
 *       taşımıyor; bütün yayınlar sayılıyor, koşul HAFİF görünür.
 *   Madde 5(1)-(4): senato yorumu, mükerrer bildiri, indeks belgeleme ve
 *       kabul mektubu hükümleri.
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Aydın Adnan Menderes Üniversitesi';
$CETVEL = 'adu-2024';
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$DENEME_DERSI = Kalip::beyan(
    'Üç profesörden oluşan komisyon huzurunda verilen deneme dersinde, yönergenin değerlendirme formundan 100 üzerinden en az 60 puan almak',
    'Madde 5(14)'
);
$UNVAN = Kalip::beyan(
    'Üniversitelerarası Kurul tarafından verilen doçentlik unvanına sahip olmak',
    'Madde 5(7)'
);
$SOZLU_SINAV = Kalip::beyan(
    '2026 yılı Mart döneminden itibaren doçentlik belgesini alan adaylar için ÜAK jürisinin uygulayacağı sözlü sınavda başarılı olmak',
    'Madde 5(9)'
);
$BASLICA_ESER = Kalip::beyan(
    '2547 sayılı Kanundaki "başlıca araştırma eseri" tanımına uygun, ilk isim yazarlı ya da sorumlu yazarlı bir yayın sunmak',
    'Madde 5(12)'
);

$NOT_C2 = ' Yönergenin "eğitim-öğretim kaleminden şu kadar puan" koşulları HESAPLANAMIYOR '
    .'olarak işaretli: ders puanları ders SAATİ başına veriliyor (0,25 puan/saat), faaliyet '
    .'kaydı ise ders '
    .'saatini taşımıyor. Bu koşulu kendiniz kontrol etmelisiniz; ders kayıtlarınız toplam '
    .'puanınıza da katkı vermiyor.';

$NOT_CETVEL = ' Puanlar yazar sırasına göre bölünüyor: birinci isim tam puan, ikinci %80, '
    .'üçüncü %60, dördüncü ve sonrası %50; atıflarda yazar sayısı dikkate alınmıyor. '
    .'Projelerde ve tez yöneticiliğinde "devam eden" değerleri girildi, çünkü kayıt tamamlanma '
    .'durumunu taşımıyor. Makale puanlarındaki "etki faktörü 1\'den büyükse puan etki '
    .'faktörüyle çarpılır" kuralı da uygulanamıyor.';

/** Profesörlükte ÜAK seçeneği ile A tablosu puan seçeneğinin "veya"sı. */
$profYayin = function (string $aciklama, string $grup, int $puan) use ($DOCENTLIK): array {
    return Kalip::veya('Yayın koşullarından birini sağlamak', [
        Kalip::hesaplanamiyor('Yürürlükteki doçentlik temel alan koşullarını bir kez daha tekrarlamak', 'Ek 3'),
        Kalip::puanDan($aciklama, [$grup], $puan, $DOCENTLIK, madde: 'Ek 3'),
    ]);
};

$esikler = [];

/**
 * @param  list<string>  $alanlar
 * @param  list<array<string, mixed>>  $drKosul
 * @param  list<array<string, mixed>>  $yenidenKosul
 * @param  list<array<string, mixed>>  $profKosul
 */
$tablo = function (string $kod, array $alanlar, ?string $birim, string $ad,
    array $drKosul, int $drToplam,
    array $yenidenKosul, int $yenidenToplam,
    array $profKosul, int $profToplam) use (&$esikler, $UNIVERSITE, $CETVEL, $DOCENTLIK,
    $SON_ATAMA, $DENEME_DERSI, $BASLICA_ESER, $NOT_C2, $NOT_CETVEL): void {
    $esikler[] = [
        'anahtar' => "adu-{$kod}-dr",
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => $CETVEL,
        'notlar' => $ad.' doktor öğretim üyesi ilk atama: toplam '.$drToplam.' puan.',
        'aday_notu' => $ad.' için doktor öğretim üyesi kadrosuna İLK ATANMA. Yönerge ilk '
            .'atamada dönem sınırı koymuyor, bütün akademik geçmişiniz sayılıyor. Ayrıca üç '
            .'profesörden oluşan komisyon huzurunda deneme dersi vermeniz ve değerlendirme '
            .'formundan '
            .'en az 60 puan almanız gerekiyor.'.$NOT_C2.$NOT_CETVEL,
        'sart' => Kalip::ve('Doktor öğretim üyesi kadrosuna ilk atanma — '.$ad, array_values([
            $DENEME_DERSI,
            ...$drKosul,
            Kalip::toplam($drToplam),
        ])),
    ];

    $esikler[] = [
        'anahtar' => "adu-{$kod}-dr-yeniden",
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => $CETVEL,
        'notlar' => $ad.' doktor öğretim üyesi yeniden atama: toplam '.$yenidenToplam.' puan, '
            .'son atamadan sonraki çalışmalardan.',
        'aday_notu' => $ad.' için doktor öğretim üyesi kadrosuna YENİDEN ATANMA. Yalnız SON ATAMADAN '
            .'SONRAKİ çalışmalarınız sayılıyor; yeniden atanma süresi en çok dört yıl.'.$NOT_C2.$NOT_CETVEL,
        'sart' => Kalip::ve('Doktor öğretim üyesi kadrosuna yeniden atanma — '.$ad, array_values([
            ...$yenidenKosul,
            Kalip::toplam($yenidenToplam, $SON_ATAMA),
        ])),
    ];

    $esikler[] = [
        'anahtar' => "adu-{$kod}-profesorluk",
        'universite' => $UNIVERSITE,
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => $CETVEL,
        'notlar' => $ad.' profesörlük: toplam '.$profToplam.' puan, doçentlik başvurusu '
            .'sonrası çalışmalardan.',
        'aday_notu' => $ad.' için profesör kadrosuna atanma. Puanlar '
            .'DOÇENTLİK BAŞVURUSU SONRASI çalışmaları kapsıyor; motor doçentlik unvanının '
            .'alındığı tarihi tuttuğu için pencere biraz daralıyor ve koşul olduğundan sıkı '
            .'görünüyor. Yayın koşulunu ya yürürlükteki doçentlik temel alan koşullarını bir '
            .'kez daha sağlayarak ya da makale kalemlerinizden öngörülen puanı alarak '
            .'karşılayabilirsiniz; birinci yol ÜAK\'ın kendi tablosuna dayandığı için '
            .'hesaplanamıyor olarak işaretli.'.$NOT_C2.$NOT_CETVEL,
        'sart' => Kalip::ve('Profesör kadrosuna atanma — '.$ad, array_values([
            $BASLICA_ESER,
            ...$profKosul,
            Kalip::toplam($profToplam, $DOCENTLIK),
        ])),
    ];
};

$C2 = fn (int $puan): array => Kalip::hesaplanamiyor(
    'Ders verme etkinliklerinden (C2) en az '.$puan.' puan almak', 'Ek 3'
);
$C1 = fn (int $puan): array => Kalip::puanDan(
    'Tez yöneticiliğinden (C1) en az '.$puan.' puan almak', ['C1'], $puan, madde: 'Ek 3'
);
$B = fn (int $puan): array => Kalip::puanDan(
    'Araştırma projelerinden (B) en az '.$puan.' puan almak', ['B'], $puan, Kalip::DOCENTLIK_SONRASI, madde: 'Ek 3'
);
$F3 = fn (int $puan): array => Kalip::hesaplanamiyor(
    'Sportif etkinliklerden (F3) en az '.$puan.' puan almak', 'Ek 3'
);
/** Ek 3'ün A tablosuna dayanan puan koşulu. */
$A = function (string $ad, string $grup, int $puan, ?array $donem = null): array {
    return Kalip::puanDan($ad.' en az '.$puan.' puan almak', [$grup], $puan, $donem, madde: 'Ek 3');
};

// ── Ek 3a1: Tıp, Sağlık Bilimleri ve Hemşirelik Fakülteleri ──
$tablo('saglik-tip', ['saglik'], 'Tıp, Sağlık Bilimleri ve Hemşirelik Fakülteleri',
    'Tıp, Sağlık Bilimleri ve Hemşirelik Fakülteleri',
    [$A('Makale ve bildirilerden', 'A1-A2', 75)], 125,
    [$A('Makale ve bildirilerden', 'A1-A2', 50, $SON_ATAMA), $C2(20)], 100,
    [$profYayin('Makalelerden', 'A1.1-A1.4', 200), $B(10), $C2(60)], 400);

// ── Ek 3a2: Veteriner Fakültesi ──
$tablo('saglik-veteriner', ['saglik'], 'Veteriner Fakültesi', 'Veteriner Fakültesi',
    [$A('Makale ve bildirilerden', 'A1-A2', 75)], 125,
    [$A('Makale ve bildirilerden', 'A1-A2', 50, $SON_ATAMA), $C2(20)], 125,
    [$profYayin('Makalelerden', 'A1.1-A1.4', 200),
        Kalip::puanDan('Bu 200 puanın en az 75\'ini SCI-Expanded, SSCI ya da A&HCI dergilerindeki makalelerden almak', ['A1.1'], 75, $DOCENTLIK, madde: 'Ek 3a2'),
        $B(20), $C2(40)], 400);

// ── Ek 3k: Diş Hekimliği Fakültesi ──
$tablo('saglik-dis', ['saglik'], 'Diş Hekimliği Fakültesi', 'Diş Hekimliği Fakültesi',
    [$A('SCI-Expanded, SSCI, A&HCI ve diğer indekslerdeki makalelerden', 'A1.1-A1.2', 120)], 200,
    [$A('Makale ve bildirilerden', 'A1-A2', 50, $SON_ATAMA), $C2(20)], 100,
    [$profYayin('Makalelerden', 'A1.1-A1.4', 200), $B(10), $C2(60)], 400);

// ── Ek 3b: Ziraat Fakültesi ──
$tablo('ziraat', ['ziraat'], null, 'Ziraat Fakültesi',
    [$A('Makale ve bildirilerden', 'A1-A2', 75)], 125,
    [$A('Makale ve bildirilerden', 'A1-A2', 50, $SON_ATAMA), $C2(50)], 125,
    [$profYayin('Makalelerden', 'A1.1-A1.4', 200),
        Kalip::adet('SCI-Expanded, SSCI ya da A&HCI dergilerinde ilk isim yazarı olduğunuz en az bir makale', ['A1.1'], 1, yazar: 'ilk', donem: $DOCENTLIK, madde: 'Ek 3b'),
        $B(20), $C1(20), $C2(60)], 400);

// ── Ek 3c: Fen Bilimleri (Fizik, Kimya, Biyoloji) ──
$tablo('fen', ['fen'], 'Fen-Edebiyat Fakültesi Fizik, Kimya ve Biyoloji Bölümleri',
    'Fen-Edebiyat Fakültesi Fizik, Kimya ve Biyoloji Bölümleri',
    [$A('SCI-Expanded, SSCI, A&HCI ve diğer indekslerdeki makalelerden', 'A1.1-A1.2', 75)], 200,
    [$A('Makale ve bildirilerden', 'A1-A2', 75, $SON_ATAMA), $C2(30)], 200,
    [$profYayin('Makalelerden', 'A1.1-A1.4', 200),
        Kalip::puanDan('Bu 200 puanın en az 75\'ini SCI-Expanded, SSCI ya da A&HCI dergilerindeki makalelerden almak', ['A1.1'], 75, $DOCENTLIK, madde: 'Ek 3c'),
        $B(20), $C1(20), $C2(60)], 600);

// ── Ek 3d: Matematik ve İstatistik ──
$tablo('matematik', ['fen'], 'Fen-Edebiyat Fakültesi Matematik Bölümü',
    'Fen-Edebiyat Fakültesi Matematik Bölümü',
    [$A('Makale ve bildirilerden', 'A1-A2', 50)], 75,
    [$A('Makale ve bildirilerden', 'A1-A2', 30, $SON_ATAMA), $C2(30)], 100,
    [$profYayin('Makalelerden', 'A1.1-A1.4', 150), $C1(20), $C2(60)], 350);

// ── Ek 3e: Mühendislik, Söke Mimarlık ve Tasarım, Kuşadası Denizcilik ──
$tablo('muhendislik', ['muhendislik', 'mimarlik'], null,
    'Mühendislik, Söke Mimarlık ve Tasarım ve Kuşadası Denizcilik Fakülteleri',
    [$A('Makale ve bildirilerden', 'A1-A2', 75)], 125,
    [$A('Makale ve bildirilerden', 'A1-A2', 50, $SON_ATAMA), $C2(50)], 125,
    [$profYayin('Makalelerden', 'A1.1-A1.4', 200),
        Kalip::puanDan('Bu 200 puanın en az 75\'ini SCI-Expanded, SSCI ya da A&HCI dergilerindeki makalelerden almak', ['A1.1'], 75, $DOCENTLIK, madde: 'Ek 3e'),
        $B(20), $C1(20), $C2(60)], 400);

// ── Ek 3f: Eğitim Fakültesi ──
$tablo('egitim', ['egitim'], null, 'Eğitim Bilimleri ve Öğretmen Yetiştirme',
    [$A('Makale ve bildirilerden', 'A1-A2', 75)], 125,
    [$A('Makale ve bildirilerden', 'A1-A2', 50, $SON_ATAMA)], 125,
    [$profYayin('Makalelerden', 'A1.1-A1.4', 200), $B(20), $C1(20), $C2(60)], 400);

// ── Ek 3g: Güzel Sanatlar ──
$tablo('guzel-sanatlar', ['guzel_sanatlar'], null,
    'Güzel Sanatlar ve Güzel Sanatlar Eğitimi',
    [$A('Makalelerden', 'A1', 50),
        $A('Sergi ve müzik etkinliklerinden', 'F1-F2', 45)], 125,
    [$A('Makalelerden', 'A1', 30, $SON_ATAMA), $C2(20),
        $A('Sergi ve müzik etkinliklerinden', 'F1-F2', 45, $SON_ATAMA)], 125,
    [$profYayin('Makalelerden', 'A1', 120), $C1(60),
        $A('Sergi ve müzik etkinliklerinden', 'F1-F2', 120, $DOCENTLIK)], 400);

// ── Ek 3h: Sosyal, Beşeri, İktisadi ve İdari Bilimler ──
$tablo('sosyal', ['sosyal', 'ilahiyat'], null,
    'Sosyal, Beşeri, İktisadi ve İdari Bilimler',
    [$A('Makale, bildiri ve kitaplardan', 'A1-A3', 50)], 75,
    [$A('Makale, bildiri ve kitaplardan', 'A1-A3', 30, $SON_ATAMA), $C1(30)], 75,
    [$profYayin('Makale, bildiri, kitap ve çevirilerden', 'A1-A4', 300),
        $C1(20), $C2(60)], 450);

// ── Ek 3i: Filoloji ──
$tablo('filoloji', ['filoloji'], null, 'Filoloji',
    [$A('Makale, bildiri, kitap ve çevirilerden', 'A1-A4', 50)], 75,
    [$A('Makale, bildiri, kitap ve çevirilerden', 'A1-A4', 40, $SON_ATAMA)], 75,
    [$profYayin('Makale, bildiri, kitap ve çevirilerden', 'A1-A4', 250), $C1(60)], 250);

// ── Ek 3j: Spor Bilimleri ──
$tablo('spor', ['spor'], null, 'Spor Bilimleri',
    [$A('Makalelerden', 'A1', 50), $F3(30)], 100,
    [$A('Makalelerden', 'A1', 30, $SON_ATAMA), $C2(30), $F3(30)], 100,
    [$profYayin('Makalelerden', 'A1', 200), $C1(60), $F3(120)], 400);

// ═══════════════ DOÇENT (bütün alanlarda aynı) ═══════════════
$esikler[] = [
    'anahtar' => 'adu-docentlik',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['saglik', 'ziraat', 'fen', 'muhendislik', 'mimarlik', 'egitim',
        'guzel_sanatlar', 'sosyal', 'ilahiyat', 'filoloji', 'spor'],
    'cetvel' => $CETVEL,
    'notlar' => 'Ek 3\'ün bütün alt tabloları doçentlik için aynı koşulu veriyor: doçentlik '
        .'unvanı ve doçentlik başvurusu ile kadro başvurusu arasında A1-A5\'ten en az 50 puan. '
        .'Madde 5(7): dil koşulu 55 puan.',
    'aday_notu' => 'Doçent kadrosuna atanma. Yönergenin on iki alt tablosu doçentlik için aynı '
        .'koşulu koyuyor, bu yüzden alan ayrımı yok: doçentlik unvanına sahip olmak ve '
        .'doçentlik başvurunuzla kadro başvurunuz arasında makale kalemlerinizden en az 50 puan '
        .'almış olmak. Motor doçentlik BAŞVURU tarihini değil unvanın alındığı tarihi tuttuğu '
        .'için pencere biraz daralıyor; koşul olduğundan sıkı görünüyor. Ayrıca deneme dersi '
        .'vermeniz ve 2026 Mart döneminden sonra doçentlik belgesi aldıysanız ÜAK jürisinin '
        .'sözlü sınavında başarılı olmanız gerekiyor.'.$NOT_CETVEL,
    'sart' => Kalip::ve('Doçent kadrosuna atanma', [
        $UNVAN,
        Kalip::yds(55),
        $SOZLU_SINAV,
        $DENEME_DERSI,
        Kalip::puanDan('Doçentlik başvurunuz ile kadro başvurunuz arasında makale kalemlerinizden en az 50 puan almak', ['A1-A5'], 50, $DOCENTLIK, madde: 'Ek 3'),
    ]),
];

return $esikler;
