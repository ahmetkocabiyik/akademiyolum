<?php

/**
 * ANKARA BİLİM ÜNİVERSİTESİ — Akademik Yükseltilme ve Atanma Kriterleri Yönergesi
 * Kaynak: pdf/17537096492.ankarabilimuniversitesi.pdf (15 sayfa, 08/03/2023)
 *
 * Yönerge yürürlüğü Madde 39 ile YÖK'ün uygun bulduğu tarihe bağlıyor, tarih
 * vermiyor; dosya adındaki 2023 PDF'in oluşturma tarihi.
 *
 * ── YAPI: TEMEL KRİTER + ÖZEL KRİTER, DÖRT BİÇİM ALANI ──
 * Madde 11'in tablosu üniversiteyi dört "Biçim Alanı"na bölüyor: Mühendislik,
 * Sosyal ve Beşeri Bilimler, Güzel Sanatlar, Hukuk. Her kadroda iki kapı var:
 *
 *   1. TEMEL KRİTERLER — alana göre DEĞİŞİYOR (Madde 12-14 mühendislik,
 *      19-23 hukuk, 26-30 sosyal, 34-36 güzel sanatlar). Yayın sayısı ve
 *      hangi indeks kabul edildiği alan alan farklı.
 *   2. ÖZEL KRİTERLER (EK1 puan tablosu) — DÖRT ALANDA DA BİREBİR AYNI.
 *      "Madde 37" başlığı dört bölümün her birinde tekrar ediyor ve üçü de
 *      aynı puanları veriyor: Dr. 20, doçent 30, profesör 50.
 *
 * Yani ayrım cetvelde değil, temel kriterlerde. Tek cetvel + dört koşul
 * kümesi yazıldı (KONVANSIYONLAR "Alan başına ayrı tablo ≠ alan başına ayrı
 * cetvel" notunun aynısı).
 *
 * ── İNDEKS TANIMLARI YÖNERGENİN KENDİ SÖZLÜĞÜNDEN ──
 * Madde 3 üç ayrı indeks tanımı yapıyor ve temel kriterler bunları AYIRARAK
 * kullanıyor:
 *   3/n Uluslararası İndeks : SCI, SSCI, SCI-Expanded, AHCI (yalnızca bu dört)
 *   3/a Alan İndeksi        : WOS, SCOPUS ve ÜAK'ın belirlediği diğerleri
 *   3/m Ulusal İndeks       : TÜBİTAK-ULAKBİM TR Dizin
 * Mühendislik profesörlüğü YALNIZCA 3/n'i kabul ediyor; doktor öğretim
 * üyeliği üçünü birden sayıyor. Cetveldeki 1.2.1 satırı bu yüzden alt
 * kodlara bölündü (gerekçe cetvel dosyasında).
 *
 * ── PROFESÖRLÜKTE EŞDEĞER ÇALIŞMA (MÜHENDİSLİK, MADDE 12/3) ──
 * Beş makalenin en çok İKİSİ başka çalışmayla tamamlanabiliyor: bir makale
 * yerine özgün kitap, bir makale yerine tescilli patent ya da endüstriyel
 * tasarım, bir makale yerine doçentlik sonrası yürütücü olarak tamamlanmış
 * İKİ proje. Madde açıkça "tamamlaması durumunda dahi en az üç özgün
 * uluslararası indekste taranan makalesinin de olması gerekir" diyor.
 *
 * Üç ayrı `veya` dalı yazıldı (5 makale · 4 makale + 1 eşdeğer · 3 makale +
 * 2 FARKLI TÜRDE eşdeğer). İki eşdeğerin farklı türden olması gerekiyor
 * çünkü kitap ve patent bentleri "makalelerden BİRİNİN yerine" diyor —
 * tek türden iki ikame yönergede yok. Motor "en fazla N" düğümü tanımadığı
 * için bu ayrım dalların içine, üç ikili kombinasyon olarak yazıldı.
 *
 * ── SOSYAL PROFESÖRLÜKTE KİTAP İKAMESİ SINIRLI (MADDE 26/3) ──
 * "Bu yayınlardan biri yerine ulusal/uluslararası kitap olabilir" ama parantez
 * içi "kitap, sorumlu yazar veya ilk isimli özgün makale ve uluslararası
 * indeks tarafından taranan makale yerine kullanılamaz" diyor. Kitap dalı bu
 * yüzden yalnızca üçüncü makalenin yerine geçiyor; uluslararası indeks ve
 * ilk/sorumlu yazar koşulları ayrı düğüm olarak duruyor ve ikame edilemiyor.
 *
 * ── YABANCI DİL: BİRİME BAĞLI, YİNE DE YAZILDI (MADDE 6) ──
 * "Türkçe eğitim-öğretim yapılan bölüm ve programlarda doçentlik kadrosuna
 * atanabilmek için … en az 60 puan." İngilizce programlarda YÖK'ün kendi
 * yönetmeliği geçerli ve o daha yüksek bir eşik istiyor. Koşul iki durumda da
 * var, yalnızca eşik değişiyor; düşük olan (60) yazıldı. Bu, İngilizce
 * programa başvuran adayı OLDUĞUNDAN HAZIR göstermez çünkü YÖK eşiği zaten
 * daha yüksek — aday notunda söylendi.
 *
 * ── YENİDEN ATANMA GİRİLDİ (MADDE 11/11) ──
 * Korpusta yeniden atanma koşulları çoğunlukla "her yıl için N puan" ya da
 * atama dönemi uzunluğu istediği için girilemiyor. Ankara Bilim'inki
 * hesaplanabilir: "temel kriterlerin 2. maddesi" (iki özgün tam makale) ile
 * "özel kriterlerin 6.1.1 ila 6.1.8'inci maddeleri kapsamında puan almış
 * olmak" şartlarının SON ATAMA TARİHİNDEN SONRASI için yeniden sağlanması.
 * İkisi de `SON_ATAMA_SONRASI` dönemiyle yazıldı; 6.1.1-6.1.8 kümesi
 * cetvelde `PROJE-6.1` grubu.
 *
 * "Puan almış olmak" en az 1 puan diye okundu — bölümün en düşük satırı
 * zaten 6 puan, yani pratikte "bir proje" demek.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde 11/12: özel kriter sağlanamazsa "başvuru ve değerlendirme süreci
 *       devam eden bir projede bulunmak" Üniversite Yönetim Kurulu KARARI İLE
 *       yeterli sayılabilir. Takdire bağlı ("sayılabilir") ve proje önerisi
 *       kayıtta tutulmuyor; koşulu kolaylaştıran bir dal yazılmadı, aday
 *       notunda anlatıldı.
 *   Madde 11/13-14: öğretim üyesi eksikliği olan programlarda ek süre ve
 *       norm kadro istisnası — üniversitenin takdiri.
 *   Hukuk profesörlüğündeki "hakemli armağan bir özgün tam makale yerine
 *       geçebilir" bendi: armağan yazısının cetvelde satırı yok, kaynak
 *       sözlüğünde de karşılığı yok. İkame dalı yazılmadı; koşul o alanda
 *       OLDUĞUNDAN ZOR görünür.
 *   Doçentlik sözlü sınavı, doçentlik unvanının alındığı alandan başvurma,
 *       yurt dışı denklik ve uzmanlık eşdeğerliği: beyan.
 *   Madde 8/3'ün sunum değerlendirmesi ve Madde 9'un jüri raporu
 *       değerlendirme süreci; adayın sağlayacağı sayısal bir koşul değil.
 *
 * ── YÖNERGENİN ANMADIĞI ALANLAR ──
 * Madde 11'in tablosu yalnızca dört biçim alanı sayıyor. Fen, sağlık, eğitim,
 * ilahiyat, filoloji, mimarlık, ziraat ve spor için eşik YAZILMADI; bir gruba
 * katmak adaya yönergede olmayan bir baraj göstermek olurdu. Mimarlık özellik
 * arz ediyor: EK1'in 6.2 bölümü mimari proje kalemlerini puanlıyor ama Madde
 * 11 mimarlığı ayrı bir biçim alanı olarak saymıyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/ankara-bilim-2023.php
 */

use App\Services\Scoring\Sart\Kalip;

$CETVEL = 'ankara-bilim-2023';
$UNIVERSITE = 'Ankara Bilim Üniversitesi';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

/**
 * Madde 37 — dört biçim alanında da birebir aynı olan EK1 puan koşulları.
 *
 * @return array<string, mixed>
 */
$ozelKriterler = function (string $kadro) use ($DOKTORA, $DOCENTLIK): array {
    return match ($kadro) {
        'dr_ogr_uyesi' => Kalip::ve('EK1 özel kriterleri', [
            Kalip::puanDan(
                'Kitap ve makale kalemlerinizden en az 8 puan',
                ['KITAP-MAKALE'], 8, madde: 'Madde 37',
            ),
            Kalip::toplam(20),
        ]),
        'docentlik' => Kalip::ve('EK1 özel kriterleri', [
            Kalip::puanDan(
                'Kitap ve makale kalemlerinizden doktora unvanınızdan sonra en az 10 puan',
                ['KITAP-MAKALE'], 10, $DOKTORA, madde: 'Madde 37',
            ),
            Kalip::puanDan(
                'Makale kalemlerinizden en az 15 puan',
                ['MAKALE'], 15, madde: 'Madde 37',
            ),
            Kalip::toplam(30),
        ]),
        default => Kalip::ve('EK1 özel kriterleri', [
            Kalip::puanDan(
                'Kitap ve makale kalemlerinizden doçentlik unvanınızdan sonra en az 10 puan',
                ['KITAP-MAKALE'], 10, $DOCENTLIK, madde: 'Madde 37',
            ),
            Kalip::puanDan(
                'Makale kalemlerinizden en az 35 puan',
                ['MAKALE'], 35, madde: 'Madde 37',
            ),
            Kalip::toplam(50),
        ]),
    };
};

/** Profesörlükte dört alanda da tekrar eden kıdem ve alan beyanları. */
$profesorBeyanlari = fn (string $madde): array => [
    Kalip::beyan(
        'Doçent unvanını aldıktan sonra alanınızda en az beş yıl çalışmış olmak; bu sürenin '
        .'en az üç yılında yükseköğretim kurumunda tam zamanlı görev yapmış ve en az iki yıl '
        .'ders vermiş olmak',
        $madde,
    ),
    Kalip::beyan('Doçentlik unvanınızı aldığınız bilim alanından başvurmak', $madde),
];

/** Doçentlikte dört alanda da tekrar eden beyanlar ve yabancı dil şartı. */
$docentBeyanlari = fn (string $madde): array => [
    Kalip::beyan('Kadronun ilan edildiği alanda doçentlik unvanına sahip olmak ve doçentlik sözlü sınavında başarılı olmak', $madde),
    Kalip::beyan('Alanınızla ilgili olarak yükseköğretim kurumunda en az bir yıl tam zamanlı ders vermiş olmak', $madde),
    Kalip::yds(60),
];

/**
 * Mühendislik profesörlüğünün eşdeğer çalışma dalları (Madde 12/3).
 *
 * @return array<string, mixed>
 */
$muhendislikYayinKosulu = function () use ($DOCENTLIK): array {
    $makale = fn (int $sayi): array => Kalip::adet(
        "SCI, SCI-Expanded, SSCI veya AHCI dergilerinde en az {$sayi} özgün tam araştırma makalesi",
        ['ULUSLARARASI-INDEKS'], $sayi, madde: 'Madde 12/3',
    );

    $kitap = Kalip::adet(
        'Bir makalenin yerine özgün kitap',
        ['OZGUN-KITAP'], 1, madde: 'Madde 12/3',
    );

    $patent = Kalip::adet(
        'Bir makalenin yerine tescilli patent veya endüstriyel tasarım',
        ['PATENT-TASARIM'], 1, madde: 'Madde 12/3',
    );

    $proje = Kalip::adet(
        'Bir makalenin yerine doçentlik unvanınızdan sonra yürütücü olarak tamamladığınız iki proje',
        ['PROJE-YURUTUCU'], 2, donem: $DOCENTLIK, madde: 'Madde 12/3',
    );

    return Kalip::veya('Uluslararası indeksli makale koşulu', [
        $makale(5),
        Kalip::ve('Dört makale ve bir eşdeğer çalışma', [
            $makale(4),
            Kalip::veya('Bir makalenin yerine geçen çalışma', [$kitap, $patent, $proje]),
        ]),
        Kalip::ve('Üç makale ve iki farklı türde eşdeğer çalışma', [
            $makale(3),
            Kalip::veya('İki makalenin yerine geçen iki farklı türde çalışma', [
                Kalip::ve('Özgün kitap ve patent', [$kitap, $patent]),
                Kalip::ve('Özgün kitap ve iki proje', [$kitap, $proje]),
                Kalip::ve('Patent ve iki proje', [$patent, $proje]),
            ]),
        ]),
    ]);
};

$esikler = [];

// ══════════════════════════════════════════════════════════════════════════
// MÜHENDİSLİK (Madde 12-14)
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'ankara-bilim-muhendislik-dr',
    'aday_notu' => 'İki kapı var: temel kriter olarak ulusal, uluslararası ya da alan '
        .'indeksinde taranan dergilerde iki özgün tam araştırma makalesi; özel kriter olarak '
        .'EK1 tablosundan toplam 20 puan (bunun en az 8 puanı kitap ve makale kalemlerinden). '
        .'Derleme, kısa makale ve editöre mektup puana giriyor ama "özgün tam araştırma '
        .'makalesi" sayısına girmiyor; faaliyetlerinizde makale türünü doğru seçin. '
        .'Doktor öğretim üyeliği en çok iki yıllık atanıyor (Madde 11/11).',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['muhendislik'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 14/1: doktora derecesi ve "ulusal, uluslararası veya alan indeksi '
        .'tarafından taranan dergilerde olmak koşuluyla, en az iki özgün tam araştırma '
        .'makalesi". Madde 37: EK1\'den toplam 20 puan, 1.1 ve/veya 1.2 kısmından en az 8.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma', [
        Kalip::beyan('İlgili alanda doktora derecesine sahip olmak', 'Madde 14/1'),
        Kalip::adet(
            'Ulusal, uluslararası veya alan indeksinde taranan dergilerde en az 2 özgün tam araştırma makalesi',
            ['DR-DERGI'], 2, madde: 'Madde 14/2',
        ),
        $ozelKriterler('dr_ogr_uyesi'),
    ]),
];

$esikler[] = [
    'anahtar' => 'ankara-bilim-muhendislik-dr-yeniden',
    'aday_notu' => 'Yeniden atanmada iki koşul SON ATAMANIZDAN SONRAKİ çalışmalarınıza '
        .'bakıyor: iki özgün tam araştırma makalesi ve araştırma projesi kalemlerinden puan '
        .'almış olmak. İlk atamanın toplam puan barajı yeniden atanmada aranmıyor. '
        .'Proje koşulunu sağlayamazsanız Madde 11/12 "başvuru ve değerlendirme süreci devam '
        .'eden ulusal/uluslararası bir projede bulunmayı" Üniversite Yönetim Kurulu kararıyla '
        .'yeterli sayabiliyor; takdire bağlı olduğu için koşula yazılmadı. Doçentlik unvanını '
        .'kazandıysanız unvandan sonraki ilk atamada yeniden atanma kriterleri aranmıyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => ['muhendislik'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 11/11: "temel kriterlerin 2. Maddesi" ile "Ek 1\'de yer alan özel '
        .'kriterlerin 6.1.1 ila 6.1.8\'inci Maddeleri kapsamında puan almış olmak" şartlarının '
        .'son atama tarihinden sonrası için yeniden sağlanması. "Puan almış olmak" en az '
        .'1 puan diye okundu; bölümün en düşük satırı 6 puan.',
    'sart' => Kalip::ve('Doktor Öğretim Üyeliğine yeniden atanma', [
        Kalip::adet(
            'Son atamanızdan sonra ulusal, uluslararası veya alan indeksinde taranan dergilerde en az 2 özgün tam araştırma makalesi',
            ['DR-DERGI'], 2, donem: $SON_ATAMA, madde: 'Madde 11/11',
        ),
        Kalip::puanDan(
            'Araştırma projesi kalemlerinizden son atamanızdan sonra puan almış olmak',
            ['PROJE-6.1'], 1, $SON_ATAMA, madde: 'Madde 11/11',
        ),
    ]),
];

$esikler[] = [
    'anahtar' => 'ankara-bilim-muhendislik-docent',
    'aday_notu' => 'Temel kriter yalnızca uluslararası indeksi (SCI, SCI-Expanded, SSCI, '
        .'AHCI) kabul ediyor; alan indeksi ya da TR Dizin makaleleri bu iki makalelik sayıya '
        .'girmiyor, ama puan tablosunda tam puan alıyor. Özel kriter EK1\'den toplam 30 puan; '
        .'bunun en az 15\'i makale kalemlerinden ve en az 10\'u doktora unvanınızdan sonra '
        .'olmalı. Türkçe programlarda yabancı dil sınavından 60 puan isteniyor; İngilizce '
        .'programlarda YÖK mevzuatının (daha yüksek) eşiği geçerli.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['muhendislik'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 13/1: doçentlik unvanı ve sözlü sınav, en az bir yıl tam zamanlı ders, '
        .'"uluslararası indeks tarafından taranan dergilerde en az iki özgün tam araştırma '
        .'makalesi". Uluslararası indeks Madde 3/n\'de yalnızca SCI, SSCI, SCI-Expanded ve '
        .'AHCI diye tanımlı. Madde 6: Türkçe programlarda yabancı dil 60.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma', [
        ...$docentBeyanlari('Madde 13/1'),
        Kalip::adet(
            'SCI, SCI-Expanded, SSCI veya AHCI dergilerinde en az 2 özgün tam araştırma makalesi',
            ['ULUSLARARASI-INDEKS'], 2, madde: 'Madde 13/3',
        ),
        $ozelKriterler('docentlik'),
    ]),
];

$esikler[] = [
    'anahtar' => 'ankara-bilim-muhendislik-profesor',
    'aday_notu' => 'Korpusun en ayrıntılı eşdeğerlik kuralı burada: beş makalenin en çok '
        .'ikisi başka çalışmayla tamamlanabiliyor — biri özgün kitapla, biri tescilli patent '
        .'ya da endüstriyel tasarımla, biri doçentlik sonrası yürütücü olarak tamamladığınız '
        .'İKİ projeyle. İki ikame kullanacaksanız ikisi farklı türden olmalı ve elinizde her '
        .'hâlde en az üç uluslararası indeksli makale bulunmalı. Ayrıca beş makalenin en az '
        .'üçü doçentlik sonrası olmalı ve en az birinde ilk ya da sorumlu yazar olmalısınız. '
        .'Özel kriter EK1\'den toplam 50 puan; en az 35\'i makale kalemlerinden, en az 10\'u '
        .'doçentlik unvanınızdan sonra.',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['muhendislik'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 12/1: beş yıl kıdem, kendi doçentlik alanından başvuru, "en az üçü '
        .'doçent unvanını aldıktan sonra olmak üzere, uluslararası indeks tarafından taranan '
        .'dergilerde, en az birinde ilk yazar veya sorumlu yazar olmak koşuluyla, en az beş '
        .'özgün tam araştırma makalesi". Eşdeğerlik dalları Madde 12/3\'ün devamından; '
        .'"en az üç özgün uluslararası indekste taranan makale" alt sınırı korundu.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma', [
        ...$profesorBeyanlari('Madde 12/1'),
        $muhendislikYayinKosulu(),
        Kalip::adet(
            'Bu makalelerin en az 3\'ü doçentlik unvanınızdan sonra yayımlanmış olmalı',
            ['ULUSLARARASI-INDEKS'], 3, donem: $DOCENTLIK, madde: 'Madde 12/3',
        ),
        Kalip::adet(
            'Bu makalelerin en az birinde ilk yazar veya sorumlu yazar olmalısınız',
            ['ULUSLARARASI-INDEKS'], 1, yazar: 'baslica', madde: 'Madde 12/3',
        ),
        $ozelKriterler('profesorluk'),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// HUKUK (Madde 19-23)
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'ankara-bilim-hukuk-dr',
    'aday_notu' => 'Hukuk alanının doktor öğretim üyeliği diğer alanlardan bir noktada '
        .'ayrılıyor: iki makalenin BİRİNDE ilk isim olmanız isteniyor. Dergi kümesi de daha '
        .'geniş — uluslararası alan indeksleri ve ulusal hakemli dergilerin tamamı sayılıyor. '
        .'Özel kriter EK1\'den toplam 20 puan, en az 8\'i kitap ve makale kalemlerinden.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['hukuk'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 23/1: doktora unvanı ve "uluslararası alan indekslerinde taranan '
        .'dergilerde veya ulusal hakemli dergilerin birinde ilk isim olmak koşuluyla en az '
        .'iki özgün tam makale (hakemli armağan bir özgün tam makale yerine geçebilir, '
        .'editöre mektup, özet, kitap kritiği hariç)". Armağan yazısının cetvelde satırı yok; '
        .'ikame dalı yazılmadı.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma', [
        Kalip::beyan('İlgili alanda doktora unvanına sahip olmak', 'Madde 23/1'),
        Kalip::adet(
            'Uluslararası alan indekslerinde veya ulusal hakemli dergilerde en az 2 özgün tam makale',
            ['HUKUK-DR-DERGI'], 2, madde: 'Madde 23/2',
        ),
        Kalip::adet(
            'Bu makalelerin en az birinde ilk isim olmalısınız',
            ['HUKUK-DR-DERGI'], 1, yazar: 'ilk', madde: 'Madde 23/2',
        ),
        $ozelKriterler('dr_ogr_uyesi'),
    ]),
];

$esikler[] = [
    'anahtar' => 'ankara-bilim-hukuk-dr-yeniden',
    'aday_notu' => 'Yeniden atanmada iki koşul SON ATAMANIZDAN SONRAKİ çalışmalarınıza '
        .'bakıyor: iki özgün tam makale (birinde ilk isim) ve araştırma projesi kalemlerinden '
        .'puan almış olmak. İlk atamanın toplam puan barajı aranmıyor. Proje koşulunu '
        .'sağlayamazsanız Madde 11/12 devam eden bir proje başvurusunu Üniversite Yönetim '
        .'Kurulu kararıyla yeterli sayabiliyor; takdire bağlı olduğu için koşula yazılmadı.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => ['hukuk'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 11/11, Madde 23/2 ile birlikte okundu.',
    'sart' => Kalip::ve('Doktor Öğretim Üyeliğine yeniden atanma', [
        Kalip::adet(
            'Son atamanızdan sonra uluslararası alan indekslerinde veya ulusal hakemli dergilerde en az 2 özgün tam makale',
            ['HUKUK-DR-DERGI'], 2, donem: $SON_ATAMA, madde: 'Madde 11/11',
        ),
        Kalip::adet(
            'Bu makalelerin en az birinde ilk isim olmalısınız',
            ['HUKUK-DR-DERGI'], 1, yazar: 'ilk', donem: $SON_ATAMA, madde: 'Madde 11/11',
        ),
        Kalip::puanDan(
            'Araştırma projesi kalemlerinizden son atamanızdan sonra puan almış olmak',
            ['PROJE-6.1'], 1, $SON_ATAMA, madde: 'Madde 11/11',
        ),
    ]),
];

$esikler[] = [
    'anahtar' => 'ankara-bilim-hukuk-docent',
    'aday_notu' => 'Doçentlikte dergi kümesi mühendislikten geniş: ulusal indeks (TR Dizin) '
        .'makaleleri de sayılıyor. Özel kriter EK1\'den toplam 30 puan; en az 15\'i makale '
        .'kalemlerinden, en az 10\'u doktora unvanınızdan sonra. Türkçe programlarda yabancı '
        .'dil sınavından 60 puan isteniyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['hukuk'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 21/1: "Ulusal ya da Uluslararası indeks tarafından taranan dergilerde, '
        .'en az iki özgün tam araştırma makalesi".',
    'sart' => Kalip::ve('Doçent kadrosuna atanma', [
        ...$docentBeyanlari('Madde 21/1'),
        Kalip::adet(
            'Ulusal veya uluslararası indekste taranan dergilerde en az 2 özgün tam araştırma makalesi',
            ['ULUSAL-VEYA-ULUSLARARASI-INDEKS'], 2, madde: 'Madde 21/3',
        ),
        $ozelKriterler('docentlik'),
    ]),
];

$esikler[] = [
    'anahtar' => 'ankara-bilim-hukuk-profesor',
    'aday_notu' => 'Hukukta profesörlük korpusta ender bir koşul taşıyor: üç makalenin '
        .'yanında EN AZ BİR KİTAP zorunlu (ders notu sayılmıyor) ve birden fazla kitap '
        .'yayımlamış olmak makale şartını ortadan kaldırmıyor. Makalelerin en az birinde ilk '
        .'isim olmalısınız ve üçü de doçentlik unvanınızdan sonra olmalı. Yönergenin '
        .'"hakemli armağan bir özgün tam makale yerine geçebilir" istisnası girilemedi '
        .'(armağan yazısının puan satırı yok), yani koşul burada olduğundan biraz ZOR '
        .'görünür. Özel kriter EK1\'den toplam 50 puan.',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['hukuk'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 19/1: "Doçent unvanı aldıktan sonra ulusal / uluslararası indekslerde '
        .'taranan dergilerde, en az birinde ilk isim olmak koşuluyla, en az üç özgün tam '
        .'araştırma makalesi ve en az bir kitap (ders notu hariç) yayımlamış olmak. Birden '
        .'fazla kitap yayımlanmış olması durumunda, yine de en az bir özgün tam makale '
        .'yayımlamış olmak koşulu aranır."',
    'sart' => Kalip::ve('Profesör kadrosuna atanma', [
        ...$profesorBeyanlari('Madde 19/1'),
        Kalip::adet(
            'Doçentlik unvanınızdan sonra ulusal veya uluslararası indekste taranan dergilerde en az 3 özgün tam araştırma makalesi',
            ['ULUSAL-VEYA-ULUSLARARASI-INDEKS'], 3, donem: $DOCENTLIK, madde: 'Madde 19/3',
        ),
        Kalip::adet(
            'Bu makalelerin en az birinde ilk isim olmalısınız',
            ['ULUSAL-VEYA-ULUSLARARASI-INDEKS'], 1, yazar: 'ilk', donem: $DOCENTLIK, madde: 'Madde 19/3',
        ),
        Kalip::adet(
            'Doçentlik unvanınızdan sonra en az 1 kitap (ders notu sayılmaz)',
            ['KITAP'], 1, donem: $DOCENTLIK, madde: 'Madde 19/3',
        ),
        $ozelKriterler('profesorluk'),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// SOSYAL VE BEŞERİ BİLİMLER (Madde 26-30)
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'ankara-bilim-sosyal-dr',
    'aday_notu' => 'Temel kriter iki özgün tam makale; ulusal, uluslararası ya da alan '
        .'indeksinde taranan dergiler sayılıyor ve yazar sırası aranmıyor. Özel kriter '
        .'EK1\'den toplam 20 puan, en az 8\'i kitap ve makale kalemlerinden.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['sosyal'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 30/1: doktora unvanı ve "Ulusal, Uluslararası veya alan indeksinde '
        .'taranan dergilerin birinde olmak koşuluyla en az iki özgün tam makale".',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma', [
        Kalip::beyan('İlgili alanda doktora derecesine sahip olmak', 'Madde 30/1'),
        Kalip::adet(
            'Ulusal, uluslararası veya alan indeksinde taranan dergilerde en az 2 özgün tam makale',
            ['DR-DERGI'], 2, madde: 'Madde 30/2',
        ),
        $ozelKriterler('dr_ogr_uyesi'),
    ]),
];

$esikler[] = [
    'anahtar' => 'ankara-bilim-sosyal-dr-yeniden',
    'aday_notu' => 'Yeniden atanmada iki koşul SON ATAMANIZDAN SONRAKİ çalışmalarınıza '
        .'bakıyor: iki özgün tam makale ve araştırma projesi kalemlerinden puan almış olmak. '
        .'İlk atamanın toplam puan barajı aranmıyor. Proje koşulunu sağlayamazsanız Madde '
        .'11/12 devam eden bir proje başvurusunu Üniversite Yönetim Kurulu kararıyla yeterli '
        .'sayabiliyor; takdire bağlı olduğu için koşula yazılmadı.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => ['sosyal'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 11/11, Madde 30/2 ile birlikte okundu.',
    'sart' => Kalip::ve('Doktor Öğretim Üyeliğine yeniden atanma', [
        Kalip::adet(
            'Son atamanızdan sonra ulusal, uluslararası veya alan indeksinde taranan dergilerde en az 2 özgün tam makale',
            ['DR-DERGI'], 2, donem: $SON_ATAMA, madde: 'Madde 11/11',
        ),
        Kalip::puanDan(
            'Araştırma projesi kalemlerinizden son atamanızdan sonra puan almış olmak',
            ['PROJE-6.1'], 1, $SON_ATAMA, madde: 'Madde 11/11',
        ),
    ]),
];

$esikler[] = [
    'anahtar' => 'ankara-bilim-sosyal-docent',
    'aday_notu' => 'Doçentlikte ulusal indeks (TR Dizin) makaleleri de sayılıyor. Özel '
        .'kriter EK1\'den toplam 30 puan; en az 15\'i makale kalemlerinden, en az 10\'u '
        .'doktora unvanınızdan sonra. Türkçe programlarda yabancı dil sınavından 60 puan '
        .'isteniyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['sosyal'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 28/1: "Ulusal ya da Uluslararası indeks tarafından taranan dergilerde, '
        .'en az iki özgün tam araştırma makalesi".',
    'sart' => Kalip::ve('Doçent kadrosuna atanma', [
        ...$docentBeyanlari('Madde 28/1'),
        Kalip::adet(
            'Ulusal veya uluslararası indekste taranan dergilerde en az 2 özgün tam araştırma makalesi',
            ['ULUSAL-VEYA-ULUSLARARASI-INDEKS'], 2, madde: 'Madde 28/3',
        ),
        $ozelKriterler('docentlik'),
    ]),
];

$esikler[] = [
    'anahtar' => 'ankara-bilim-sosyal-profesor',
    'aday_notu' => 'Üç makalenin en az biri SCI, SCI-Expanded, SSCI ya da AHCI dergisinde, '
        .'en az birinde ilk isim veya sorumlu yazar olmalısınız; üçü de doçentlik unvanınızdan '
        .'sonra sayılıyor. Üç yayından BİRİ yerine ulusal ya da uluslararası kitap '
        .'kullanabilirsiniz, ama kitap ne uluslararası indeksli makalenin ne de ilk '
        .'isim/sorumlu yazar koşulunun yerine geçiyor. Özel kriter EK1\'den toplam 50 puan.',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['sosyal'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 26/1: "en az biri uluslararası indeks\'de olmak üzere ulusal / '
        .'uluslararası indekslerde taranan dergilerde, asgari üç özgün tam araştırma makalesi. '
        .'Araştırma makalelerinin en az birinde ilk isim veya sorumlu yazar olmak zorunludur. '
        .'Bu yayınlardan biri yerine ulusal/uluslararası kitap olabilir. (Ders notu hariç '
        .'ancak ulusal/uluslararası kitap, sorumlu yazar veya ilk isimli özgün makale ve '
        .'uluslararası indeks tarafından taranan makale yerine kullanılamaz.)"',
    'sart' => Kalip::ve('Profesör kadrosuna atanma', [
        ...$profesorBeyanlari('Madde 26/1'),
        Kalip::veya('Doçentlik unvanınızdan sonra üç yayın', [
            Kalip::adet(
                'Ulusal veya uluslararası indekste taranan dergilerde en az 3 özgün tam araştırma makalesi',
                ['ULUSAL-VEYA-ULUSLARARASI-INDEKS'], 3, donem: $DOCENTLIK, madde: 'Madde 26/3',
            ),
            Kalip::ve('İki makale ve bir kitap', [
                Kalip::adet(
                    'Ulusal veya uluslararası indekste taranan dergilerde en az 2 özgün tam araştırma makalesi',
                    ['ULUSAL-VEYA-ULUSLARARASI-INDEKS'], 2, donem: $DOCENTLIK, madde: 'Madde 26/3',
                ),
                Kalip::adet(
                    'Üçüncü yayının yerine ulusal veya uluslararası kitap',
                    ['KITAP'], 1, donem: $DOCENTLIK, madde: 'Madde 26/3',
                ),
            ]),
        ]),
        Kalip::adet(
            'Bu makalelerin en az biri SCI, SCI-Expanded, SSCI veya AHCI dergisinde olmalı',
            ['ULUSLARARASI-INDEKS'], 1, donem: $DOCENTLIK, madde: 'Madde 26/3',
        ),
        Kalip::adet(
            'Bu makalelerin en az birinde ilk isim veya sorumlu yazar olmalısınız',
            ['ULUSAL-VEYA-ULUSLARARASI-INDEKS'], 1, yazar: 'baslica', donem: $DOCENTLIK, madde: 'Madde 26/3',
        ),
        $ozelKriterler('profesorluk'),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// GÜZEL SANATLAR (Madde 33-36)
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'ankara-bilim-guzel-sanatlar-dr',
    'aday_notu' => 'Güzel sanatlar alanında da temel kriter iki özgün tam makale; sanat '
        .'etkinliği yayının yerine geçmiyor. Sanat ve tasarım etkinlikleriniz yalnızca EK1 '
        .'puanına giriyor (özel kriter toplam 20 puan, en az 8\'i kitap ve makale '
        .'kalemlerinden — yani sergileriniz o 8 puanlık alt kapıya da girmiyor).',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['guzel_sanatlar'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 36/1: doktora unvanı ve "Uluslararası/ulusal veya alan indeksinde '
        .'taranan dergilerde en az iki özgün tam makale (Editöre mektup, özet, kitap kritiği '
        .'hariç)". Yönerge güzel sanatlar için sanatsal etkinlik ikamesi tanımıyor.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma', [
        Kalip::beyan('İlgili alanda doktora veya sanatta yeterlik derecesine sahip olmak', 'Madde 36/1'),
        Kalip::adet(
            'Ulusal, uluslararası veya alan indeksinde taranan dergilerde en az 2 özgün tam makale',
            ['DR-DERGI'], 2, madde: 'Madde 36/2',
        ),
        $ozelKriterler('dr_ogr_uyesi'),
    ]),
];

$esikler[] = [
    'anahtar' => 'ankara-bilim-guzel-sanatlar-dr-yeniden',
    'aday_notu' => 'Yeniden atanmada iki koşul SON ATAMANIZDAN SONRAKİ çalışmalarınıza '
        .'bakıyor: iki özgün tam makale ve araştırma projesi kalemlerinden puan almış olmak. '
        .'İlk atamanın toplam puan barajı aranmıyor. Proje koşulunu sağlayamazsanız Madde '
        .'11/12 devam eden bir proje başvurusunu Üniversite Yönetim Kurulu kararıyla yeterli '
        .'sayabiliyor; takdire bağlı olduğu için koşula yazılmadı.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => ['guzel_sanatlar'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 11/11, Madde 36/2 ile birlikte okundu.',
    'sart' => Kalip::ve('Doktor Öğretim Üyeliğine yeniden atanma', [
        Kalip::adet(
            'Son atamanızdan sonra ulusal, uluslararası veya alan indeksinde taranan dergilerde en az 2 özgün tam makale',
            ['DR-DERGI'], 2, donem: $SON_ATAMA, madde: 'Madde 11/11',
        ),
        Kalip::puanDan(
            'Araştırma projesi kalemlerinizden son atamanızdan sonra puan almış olmak',
            ['PROJE-6.1'], 1, $SON_ATAMA, madde: 'Madde 11/11',
        ),
    ]),
];

$esikler[] = [
    'anahtar' => 'ankara-bilim-guzel-sanatlar-docent',
    'aday_notu' => 'Doçentlikte ulusal indeks (TR Dizin) makaleleri de sayılıyor; sanatsal '
        .'etkinlik yine yayının yerine geçmiyor. Özel kriter EK1\'den toplam 30 puan; en az '
        .'15\'i makale kalemlerinden, en az 10\'u doktora unvanınızdan sonra. Türkçe '
        .'programlarda yabancı dil sınavından 60 puan isteniyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['guzel_sanatlar'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 35/1: "Ulusal ya da Uluslararası indeks tarafından taranan dergilerde, '
        .'en az iki özgün tam araştırma makalesi".',
    'sart' => Kalip::ve('Doçent kadrosuna atanma', [
        ...$docentBeyanlari('Madde 35/1'),
        Kalip::adet(
            'Ulusal veya uluslararası indekste taranan dergilerde en az 2 özgün tam araştırma makalesi',
            ['ULUSAL-VEYA-ULUSLARARASI-INDEKS'], 2, madde: 'Madde 35/3',
        ),
        $ozelKriterler('docentlik'),
    ]),
];

$esikler[] = [
    'anahtar' => 'ankara-bilim-guzel-sanatlar-profesor',
    'aday_notu' => 'Üç makalenin en az biri SCI, SCI-Expanded, SSCI ya da AHCI dergisinde '
        .'olmalı; üçü de doçentlik unvanınızdan sonra sayılıyor. Sosyal alandan farkı: burada '
        .'ne kitap ikamesi ne de ilk isim koşulu var. Sanat ve tasarım etkinlikleriniz temel '
        .'kritere girmiyor, yalnızca EK1 puanına katkı veriyor (toplam 50 puan; en az 35\'i '
        .'makale kalemlerinden, en az 10\'u doçentlik unvanınızdan sonra). Yayın ağırlıklı bu '
        .'yapı güzel sanatlar adayı için korpustaki zor eşiklerden.',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['guzel_sanatlar'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 34/1: "Doçent unvanı aldıktan sonra en az biri SCI, SCI-Expanded, '
        .'SSCI veya AHCI\'de olmak üzere ulusal / uluslararası indekslerde taranan dergilerde, '
        .'asgari üç özgün tam araştırma makalesi yayımlamış olmak." İlk isim koşulu ve kitap '
        .'ikamesi bu maddede YOK; sosyal bilimlerdeki kural buraya taşınmadı.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma', [
        ...$profesorBeyanlari('Madde 34/1'),
        Kalip::adet(
            'Doçentlik unvanınızdan sonra ulusal veya uluslararası indekste taranan dergilerde en az 3 özgün tam araştırma makalesi',
            ['ULUSAL-VEYA-ULUSLARARASI-INDEKS'], 3, donem: $DOCENTLIK, madde: 'Madde 34/3',
        ),
        Kalip::adet(
            'Bu makalelerin en az biri SCI, SCI-Expanded, SSCI veya AHCI dergisinde olmalı',
            ['ULUSLARARASI-INDEKS'], 1, donem: $DOCENTLIK, madde: 'Madde 34/3',
        ),
        $ozelKriterler('profesorluk'),
    ]),
];

return $esikler;
