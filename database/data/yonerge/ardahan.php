<?php

/**
 * ARDAHAN ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma
 * Kriterleri Yönergesi
 * Kaynak: pdf/1785845846194.ardahan-kriter-16072026.pdf (16.07.2026)
 * Cetvel: cetvel/ardahan-2026.php (EK: Faaliyet Puanlama Tablosu)
 *
 * ── ON TEMEL ALAN, ONU DA GİRİLDİ ──
 * Yönergenin üç tablosu (doktor öğretim üyesi ilk atama, yeniden atama ve
 * profesörlük) on temel alan sayıyor: Eğitim, Fen ve Matematik, Filoloji,
 * Güzel Sanatlar, İlahiyat, Mühendislik, Sosyal-Beşeri-İdari, Sağlık, Spor,
 * Ziraat-Orman-Su Ürünleri. Hukuk ile Mimarlık-Planlama-Tasarım yönergede
 * HİÇ geçmiyor; §0 uyarınca o iki alana eşik yazılmadı.
 *
 * ── DOÇENTLİKTE ÜNİVERSİTENİN EK KOŞULU YOK ──
 * MADDE 20 doçent kadrosu için yalnız "ÜAK tarafından verilen doçentlik
 * unvanına sahip olmak" diyor; ne asgari puan ne asgari faaliyet tablosu
 * var. Doçentlik eşiği bu yüzden unvan beyanı ile dil koşulundan ibaret.
 *
 * ── YENİDEN ATAMADA SÜRE ORANI ──
 * MADDE 19: dört yıldan kısa süreli atamalarda toplam asgari puanın bir
 * yıllıkta %25'i, iki yıllıkta %50'si, üç yıllıkta %75'i aranıyor. Kayıt
 * atama süresini taşımadığı için TAM (dört yıllık) değerler yazıldı; oran
 * aday notunda. Bu, kısa süreli atamalarda koşulu olduğundan ağır gösterir.
 *
 * ── DOKTORA TEZİNDEN ÜRETİLMİŞ YAYIN ──
 * Filoloji ve Spor Bilimlerinin doktor öğretim üyesi koşullarında
 * "doktora tezinden üretilmiş olmak kaydıyla 3.1, 3.2 veya 3.3
 * başlıklarından 1 yayın" isteniyor. Cetvelde tez yayını için ayrı satır
 * açılmadığı (yönergede de yok) ve kayıt yayının tezden üretildiğini
 * taşımadığı için sayı koşulu 3.1-3.3 kümesinden, "tezden üretilmiş olma"
 * ise beyandan kontrol ediliyor.
 *
 * ── GÜZEL SANATLARDA PLASTİK/GÖRSEL SANATLAR KOŞULU ──
 * Profesörlük tablosunun (d) satırındaki yıldızlı not "Plastik / Görsel
 * Sanatlar için 4.6.6.1 veya 4.10.6.1 maddesinden bir kişisel etkinlik"
 * istiyor. Profil adayın sanat dalını taşımadığı için bu koşul Güzel
 * Sanatlar temel alanının TAMAMINA uygulandı; müzik ya da sahne
 * sanatlarından başvuruyorsanız koşul burada olduğundan sıkı görünür (§0).
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 5 (657 sayılı Kanunun 48/A koşulları), MADDE 8 (ilan edilen
 *       unvandan üst bir unvana hak kazanmamış olmak), MADDE 25-26
 *       (ilan tarihi ve kanıtlayıcı belge), MADDE 28 (kriterleri
 *       sağlamanın atanma hakkı doğurmaması), MADDE 59-62 (komisyon ve
 *       değerlendirme süreci) — süreç hükümleri.
 *   MADDE 18 (mazeret, hastalık, doğum ve askerlik sürelerinin görev
 *       süresine eklenmesi) — süre hesabı, motorda karşılığı yok.
 *   MADDE 22'nin "kendi bilim alanında uluslararası düzeyde orijinal
 *       temel eserler vermiş olmak" ve "uygulama alanı bulunan dallarda
 *       uygulamaya yönelik çalışmalarda bulunmak" ölçütleri — beyan
 *       olarak yazıldı.
 *   MADDE 10'un "bilim alanının yabancı dil ile ilgili olması durumunda
 *       doçentlik başvurularında ikinci yabancı dil puanının en az 55
 *       olması" koşulu — profil adayın bilim dalını tutmuyor.
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Ardahan Üniversitesi';
$CETVEL = 'ardahan-2026';
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$DIL = Kalip::yds(55);
$DIL_NOT = Kalip::beyan(
    'Tamamen yabancı dilde eğitim veren bir programa ya da yabancı dil eğitimi veren bir bölüme başvuruyorsanız yabancı dil puanının en az 85 olması',
    'MADDE 10'
);
$DOKTORA = Kalip::beyan(
    'Doktora, tıpta, diş hekimliğinde, eczacılıkta ya da veteriner hekimlikte uzmanlık veya sanatta yeterlik unvanına sahip olmak',
    'MADDE 14'
);
$UNVAN = Kalip::beyan(
    'ÜAK tarafından verilen doçentlik unvanına sahip olmak',
    'MADDE 20-21'
);
$TEZDEN = Kalip::beyan(
    'Bu yayınlardan en az birinin doktora tezinizden üretilmiş olması',
    'Asgari faaliyetler tablosu'
);

$NOT_DIL = ' Yabancı dil koşulu 55 puandan uygulanıyor; tamamen yabancı dilde eğitim veren bir '
    .'programa ya da yabancı dil eğitimi veren bir bölüme başvuruyorsanız en az 85 puan '
    .'gerekiyor.';

$NOT_CETVEL = ' Puan hesabında atıflar en fazla 60, bilimsel toplantılar 40, hakemlikler 50, '
    .'tez danışmanlıkları 30, kurumsal katkı ve eğitime katkı ise 20\'şer puanla sınırlı. '
    .'Yazar payı, yönergenin yazar sayısı × sıra matrisine göre hesaplanıyor.';

$NOT_SURE = ' Bu puanlar DÖRT YILLIK atama için; bir yıllık atamalarda '
    .'toplam asgari puanın %25\'i, iki yıllıkta %50\'si, üç yıllıkta %75\'i yetiyor. Atama '
    .'süreniz kayıtta taşınmadığı için tam değerler uygulandı, kısa süreli atamalarda koşul '
    .'burada olduğundan ağır görünür.';

$esikler = [];

// ═══════════════ DOKTOR ÖĞRETİM ÜYESİ — İLK ATAMA (MADDE 15) ═══════════════
$drTablosu = [
    ['egitim', ['egitim'], 'Eğitim Bilimleri', [
        Kalip::puanDan('Uluslararası ve ulusal hakemli dergilerdeki makalelerinizden en az 25 puan almak', ['3.1-3.2'], 25, madde: 'MADDE 15/a'),
        Kalip::toplam(40),
    ]],
    ['fen', ['fen'], 'Fen Bilimleri ve Matematik', [
        Kalip::adet('SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergilerde en az iki makale yayımlamış olmak', ['3.1.1-3.1.4'], 2, madde: 'MADDE 15/b'),
        Kalip::puanDan('Makale ve kitap kalemlerinizden en az 40 puan almak', ['3.1-3.2-3.3'], 40, madde: 'MADDE 15/b'),
        Kalip::toplam(80),
    ]],
    ['filoloji', ['filoloji'], 'Filoloji', [
        Kalip::adet('Uluslararası ya da ulusal hakemli dergilerde en az iki makale yayımlamış olmak', ['3.1-3.2'], 2, madde: 'MADDE 15/c'),
        Kalip::adet('Makale ya da kitap türünden en az bir yayın yapmış olmak', ['3.1-3.2-3.3'], 1, madde: 'MADDE 15/c'),
        $TEZDEN,
        Kalip::toplam(40),
    ]],
    ['guzel-sanatlar', ['guzel_sanatlar'], 'Güzel Sanatlar', [
        Kalip::adet('Uluslararası ya da ulusal hakemli dergilerde en az bir makale yayımlamış olmak', ['3.1-3.2'], 1, madde: 'MADDE 15/d'),
        Kalip::puanDan('Kurumsal katkı ve sanatsal faaliyet kalemlerinden en az 100 puan almak', ['KURUMSAL-VE-SANATSAL'], 100, madde: 'MADDE 15/d'),
    ]],
    ['ilahiyat', ['ilahiyat'], 'İlahiyat', [
        Kalip::adet('Uluslararası ya da ulusal hakemli dergilerde en az iki makale yayımlamış olmak', ['3.1-3.2'], 2, madde: 'MADDE 15/e'),
        Kalip::toplam(40),
    ]],
    ['muhendislik', ['muhendislik'], 'Mühendislik', [
        Kalip::adet('Uluslararası ya da ulusal hakemli dergilerde en az iki makale yayımlamış olmak', ['3.1-3.2'], 2, madde: 'MADDE 15/f'),
        Kalip::toplam(80),
    ]],
    ['sosyal', ['sosyal'], 'Sosyal, Beşeri ve İdari Bilimler', [
        Kalip::puanDan('Uluslararası ve ulusal hakemli dergilerdeki makalelerinizden en az 25 puan almak', ['3.1-3.2'], 25, madde: 'MADDE 15/g'),
        Kalip::toplam(40),
    ]],
    ['saglik', ['saglik'], 'Sağlık Bilimleri', [
        Kalip::puanDan('Uluslararası ve ulusal hakemli dergilerdeki makalelerinizden en az 25 puan almak', ['3.1-3.2'], 25, madde: 'MADDE 15/h'),
        Kalip::toplam(80),
    ]],
    ['spor', ['spor'], 'Spor Bilimleri', [
        Kalip::puanDan('Uluslararası ve ulusal hakemli dergilerdeki makalelerinizden en az 20 puan almak', ['3.1-3.2'], 20, madde: 'MADDE 15/ı'),
        Kalip::adet('Makale ya da kitap türünden en az bir yayın yapmış olmak', ['3.1-3.2-3.3'], 1, madde: 'MADDE 15/ı'),
        $TEZDEN,
        Kalip::toplam(40),
    ]],
    ['ziraat', ['ziraat'], 'Ziraat, Orman ve Su Ürünleri', [
        Kalip::adet('Uluslararası ya da ulusal hakemli dergilerde en az iki makale yayımlamış olmak', ['3.1-3.2'], 2, madde: 'MADDE 15/i'),
        Kalip::toplam(40),
    ]],
];

foreach ($drTablosu as [$kod, $alanlar, $alanAdi, $kosullar]) {
    $esikler[] = [
        'anahtar' => "ardahan-{$kod}-dr",
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => $alanAdi.' doktor öğretim üyesi ilk atama (MADDE 15).',
        'aday_notu' => $alanAdi.' alanında doktor öğretim üyesi kadrosuna İLK ATANMA. Yönerge '
            .'ilk atamada dönem sınırı koymuyor, bütün akademik geçmişiniz sayılıyor.'
            .$NOT_DIL.$NOT_CETVEL,
        'sart' => Kalip::ve('Doktor öğretim üyesi kadrosuna ilk atanma — '.$alanAdi, [
            $DOKTORA,
            $DIL,
            $DIL_NOT,
            ...$kosullar,
        ]),
    ];
}

// ═══════════ DOKTOR ÖĞRETİM ÜYESİ — YENİDEN ATAMA (MADDE 16-19) ═══════════
$yenidenTablosu = [
    ['egitim', ['egitim'], 'Eğitim Bilimleri', [
        Kalip::puanDan('Uluslararası ve ulusal hakemli dergilerdeki makalelerinizden en az 40 puan almak', ['3.1-3.2'], 40, $SON_ATAMA, madde: 'MADDE 16/a'),
        Kalip::toplam(60, $SON_ATAMA),
    ]],
    ['fen', ['fen'], 'Fen Bilimleri ve Matematik', [
        Kalip::veya('Makale koşulunu sağlamak', [
            Kalip::adet('SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergilerde en az iki makale yayımlamış olmak', ['3.1.1-3.1.4'], 2, donem: $SON_ATAMA, madde: 'MADDE 16/b'),
            Kalip::puanDan('Makale ve kitap kalemlerinizden en az 40 puan almak', ['3.1-3.2-3.3'], 40, $SON_ATAMA, madde: 'MADDE 16/b'),
        ]),
        Kalip::adet('Ulusal Ar-Ge projelerinden en az birinde görev almak', ['3.7'], 1, donem: $SON_ATAMA, madde: 'MADDE 16/b'),
        Kalip::toplam(100, $SON_ATAMA),
    ]],
    ['filoloji', ['filoloji'], 'Filoloji', [
        Kalip::adet('Uluslararası ya da ulusal hakemli dergilerde en az iki makale yayımlamış olmak', ['3.1-3.2'], 2, donem: $SON_ATAMA, madde: 'MADDE 16/c'),
        Kalip::toplam(60, $SON_ATAMA),
    ]],
    ['guzel-sanatlar', ['guzel_sanatlar'], 'Güzel Sanatlar', [
        Kalip::puanDan('Uluslararası ve ulusal hakemli dergilerdeki makalelerinizden en az 55 puan almak', ['3.1-3.2'], 55, $SON_ATAMA, madde: 'MADDE 16/d'),
        Kalip::adet('Bu makalelerden en az birinin TR Dizin kapsamındaki bir dergide yayımlanmış olması', ['3.2.1'], 1, donem: $SON_ATAMA, madde: 'MADDE 16/d'),
        Kalip::puanDan('Kurumsal katkı ve sanatsal faaliyet kalemlerinden en az 140 puan almak', ['KURUMSAL-VE-SANATSAL'], 140, $SON_ATAMA, madde: 'MADDE 16/d'),
        Kalip::toplam(180, $SON_ATAMA),
    ]],
    ['ilahiyat', ['ilahiyat'], 'İlahiyat', [
        Kalip::adet('Uluslararası ya da ulusal hakemli dergilerde en az iki makale yayımlamış olmak', ['3.1-3.2'], 2, donem: $SON_ATAMA, madde: 'MADDE 16/e'),
        Kalip::toplam(60, $SON_ATAMA),
    ]],
    ['muhendislik', ['muhendislik'], 'Mühendislik', [
        Kalip::adet('Uluslararası ya da ulusal hakemli dergilerde en az iki makale yayımlamış olmak', ['3.1-3.2'], 2, donem: $SON_ATAMA, madde: 'MADDE 16/f'),
        Kalip::toplam(100, $SON_ATAMA),
    ]],
    ['sosyal', ['sosyal'], 'Sosyal, Beşeri ve İdari Bilimler', [
        Kalip::puanDan('Uluslararası ve ulusal hakemli dergilerdeki makalelerinizden en az 40 puan almak', ['3.1-3.2'], 40, $SON_ATAMA, madde: 'MADDE 16/g'),
        Kalip::toplam(60, $SON_ATAMA),
    ]],
    ['saglik', ['saglik'], 'Sağlık Bilimleri', [
        Kalip::puanDan('Makale, kitap, proje, bildiri, bilimsel tanınırlık, hakemlik ve ödül kalemlerinden en az 40 puan almak', ['SAGLIK-YENIDEN'], 40, $SON_ATAMA, madde: 'MADDE 16/h'),
        Kalip::toplam(100, $SON_ATAMA),
    ]],
    ['spor', ['spor'], 'Spor Bilimleri', [
        Kalip::adet('Uluslararası hakemli dergilerde en az iki makale yayımlamış olmak', ['3.1'], 2, donem: $SON_ATAMA, madde: 'MADDE 16/ı'),
        Kalip::adet('Ulusal hakemli dergilerde en az bir makale yayımlamış olmak', ['3.2'], 1, donem: $SON_ATAMA, madde: 'MADDE 16/ı'),
        Kalip::puanDan('Ulusal hakemli dergilerdeki makalelerden en az 20 puan almak', ['3.2'], 20, $SON_ATAMA, madde: 'MADDE 16/ı'),
        Kalip::toplam(60, $SON_ATAMA),
    ]],
    ['ziraat', ['ziraat'], 'Ziraat, Orman ve Su Ürünleri', [
        Kalip::adet('Uluslararası ya da ulusal hakemli dergilerde en az iki makale yayımlamış olmak', ['3.1-3.2'], 2, donem: $SON_ATAMA, madde: 'MADDE 16/i'),
        Kalip::toplam(60, $SON_ATAMA),
    ]],
];

foreach ($yenidenTablosu as [$kod, $alanlar, $alanAdi, $kosullar]) {
    $esikler[] = [
        'anahtar' => "ardahan-{$kod}-dr-yeniden",
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => $alanAdi.' doktor öğretim üyesi yeniden atama (MADDE 16). MADDE 17: yalnız '
            .'son atama tarihinden sonraki faaliyetler sayılır.',
        'aday_notu' => $alanAdi.' alanında doktor öğretim üyesi kadrosuna YENİDEN ATANMA. '
            .'Yalnız SON ATAMA TARİHİNDEN SONRAKİ faaliyetleriniz sayılıyor.'
            .$NOT_SURE.$NOT_DIL.$NOT_CETVEL,
        'sart' => Kalip::ve('Doktor öğretim üyesi kadrosuna yeniden atanma — '.$alanAdi, [
            $DOKTORA,
            $DIL,
            $DIL_NOT,
            ...$kosullar,
        ]),
    ];
}

// ═══════════════ DOÇENT (MADDE 20) ═══════════════
$TUM_ALANLAR = ['egitim', 'fen', 'filoloji', 'guzel_sanatlar', 'ilahiyat', 'muhendislik',
    'sosyal', 'saglik', 'spor', 'ziraat'];

$esikler[] = [
    'anahtar' => 'ardahan-docentlik',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => $TUM_ALANLAR,
    'cetvel' => $CETVEL,
    'notlar' => 'MADDE 20: doçent kadrosu için yalnız ÜAK doçentlik unvanı aranıyor; '
        .'üniversitenin ek puan barajı ya da asgari faaliyet tablosu yok.',
    'aday_notu' => 'Ardahan Üniversitesi doçent kadrosuna atanmada KENDİ EK KOŞULUNU KOYMUYOR. '
        .'Yalnız ÜAK tarafından verilen doçentlik unvanına sahip olmak (ya da yurt '
        .'dışından alınan unvanın 2547 sayılı Kanunun 27. maddesi uyarınca ÜAK tarafından '
        .'geçerli sayılmasını) arıyor. Yönergenin asgari faaliyet tabloları yalnız doktor '
        .'öğretim üyesi ve profesör kadroları için var.'.$NOT_DIL,
    'sart' => Kalip::ve('Doçent kadrosuna atanma', [
        $UNVAN,
        $DIL,
        $DIL_NOT,
    ]),
];

// ═══════════════ PROFESÖR (MADDE 21-24) ═══════════════
$MADDE22 = Kalip::beyan(
    'Doçentlik unvanını aldıktan sonra en az beş yıl açık bulunan profesörlük kadrosuyla ilgili bilim alanında çalışmış olmak, kendi bilim alanında uluslararası düzeyde orijinal temel eserler vermiş olmak ve uygulama alanı bulunan dallarda uygulamaya yönelik çalışmalarda bulunmak',
    'MADDE 22'
);
$PROJE_YURUTUCU = Kalip::adet(
    'Ulusal ya da uluslararası bir Ar-Ge projesinde yürütücü olmak',
    ['3.7-YURUTUCU'], 1, donem: $DOCENTLIK, madde: 'MADDE 24'
);
$KITAP = Kalip::adet(
    'BKCI kapsamındaki ya da ulusal bir yayınevi tarafından yayımlanan en az bir özgün bilimsel kitap yazarlığı',
    ['3.3.1-3.3.4-3.3.11'], 1, donem: $DOCENTLIK, madde: 'MADDE 24'
);

$profTablosu = [
    ['egitim', ['egitim'], 'Eğitim Bilimleri', [
        Kalip::adet('SCI, SCI-Expanded, SSCI, AHCI, ESCI ya da SCOPUS kapsamındaki dergilerde en az iki makale yayımlamış olmak', ['3.1.1-3.1.11'], 2, donem: $DOCENTLIK, madde: 'MADDE 24/a'),
        Kalip::puanDan('Uluslararası ve ulusal hakemli dergilerdeki makalelerinizden en az 100 puan almak', ['3.1-3.2'], 100, $DOCENTLIK, madde: 'MADDE 24/a'),
        $KITAP,
        $PROJE_YURUTUCU,
        Kalip::puanDan('Atıflardan en az 20 puan almak', ['3.10'], 20, $DOCENTLIK, madde: 'MADDE 24/a'),
        Kalip::toplam(200, $DOCENTLIK),
    ]],
    ['fen', ['fen'], 'Fen Bilimleri ve Matematik', [
        Kalip::adet('SCI, SCI-Expanded, SSCI ya da AHCI kapsamında Q1-Q3 grubundaki dergilerde en az beş makale yayımlamış olmak', ['3.1.1-3.1.3'], 5, donem: $DOCENTLIK, madde: 'MADDE 24/b'),
        Kalip::adet('Bu makalelerin en az ikisinde başlıca yazar olmak', ['3.1.1-3.1.3'], 2, yazar: 'baslica', donem: $DOCENTLIK, madde: 'MADDE 24/b'),
        $PROJE_YURUTUCU,
        Kalip::adet('Hakemli uluslararası bilimsel toplantıda en az bir bildiri sunmuş olmak', ['3.8.1-3.8.2'], 1, donem: $DOCENTLIK, madde: 'MADDE 24/b'),
        Kalip::toplam(200, $DOCENTLIK),
    ]],
    ['filoloji', ['filoloji'], 'Filoloji', [
        Kalip::adet('Uluslararası ya da ulusal hakemli dergilerde en az üç makale yayımlamış olmak', ['3.1-3.2'], 3, donem: $DOCENTLIK, madde: 'MADDE 24/c'),
        $KITAP,
        $PROJE_YURUTUCU,
        Kalip::toplam(200, $DOCENTLIK),
    ]],
    ['ilahiyat', ['ilahiyat'], 'İlahiyat', [
        Kalip::adet('Uluslararası ya da ulusal hakemli dergilerde en az üç makale yayımlamış olmak', ['3.1-3.2'], 3, donem: $DOCENTLIK, madde: 'MADDE 24/e'),
        $PROJE_YURUTUCU,
        $KITAP,
        Kalip::toplam(200, $DOCENTLIK),
    ]],
    ['muhendislik', ['muhendislik'], 'Mühendislik', [
        Kalip::adet('Uluslararası ya da ulusal hakemli dergilerde en az üç makale yayımlamış olmak', ['3.1-3.2'], 3, donem: $DOCENTLIK, madde: 'MADDE 24/f'),
        Kalip::adet('Bu makalelerin en az ikisinde başlıca yazar olmak', ['3.1-3.2'], 2, yazar: 'baslica', donem: $DOCENTLIK, madde: 'MADDE 24/f'),
        Kalip::adet('Tez danışmanlığı ve jüri üyelikleri başlığından en az iki faaliyet', ['3.4'], 2, donem: $DOCENTLIK, madde: 'MADDE 24/f'),
        $PROJE_YURUTUCU,
        Kalip::toplam(200, $DOCENTLIK),
    ]],
    ['sosyal', ['sosyal'], 'Sosyal, Beşeri ve İdari Bilimler', [
        Kalip::adet('SCI, SCI-Expanded, SSCI, AHCI, ESCI ya da SCOPUS kapsamındaki dergilerde en az iki makale yayımlamış olmak', ['3.1.1-3.1.11'], 2, donem: $DOCENTLIK, madde: 'MADDE 24/g'),
        Kalip::puanDan('Uluslararası ve ulusal hakemli dergilerdeki makalelerinizden en az 100 puan almak', ['3.1-3.2'], 100, $DOCENTLIK, madde: 'MADDE 24/g'),
        $KITAP,
        Kalip::puanDan('Atıflardan en az 20 puan almak', ['3.10'], 20, $DOCENTLIK, madde: 'MADDE 24/g'),
        $PROJE_YURUTUCU,
        Kalip::toplam(200, $DOCENTLIK),
    ]],
    ['saglik', ['saglik'], 'Sağlık Bilimleri', [
        Kalip::puanDan('Uluslararası ve ulusal hakemli dergilerdeki makalelerinizden en az 60 puan almak', ['3.1-3.2'], 60, $DOCENTLIK, madde: 'MADDE 24/h'),
        Kalip::adet('Bu makalelerin en az birinde başlıca yazar olmak', ['3.1-3.2'], 1, yazar: 'baslica', donem: $DOCENTLIK, madde: 'MADDE 24/h'),
        $PROJE_YURUTUCU,
        Kalip::puanDan('Kitap, tez danışmanlığı, proje, bildiri, bilimsel tanınırlık, hakemlik ve ödül kalemlerinden en az 80 puan almak', ['SAGLIK-PROF'], 80, $DOCENTLIK, madde: 'MADDE 24/h'),
        Kalip::toplam(200, $DOCENTLIK),
    ]],
    ['spor', ['spor'], 'Spor Bilimleri', [
        Kalip::adet('SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergilerde en az üç makale yayımlamış olmak', ['3.1.1-3.1.4'], 3, donem: $DOCENTLIK, madde: 'MADDE 24/ı'),
        Kalip::adet('Bu makalelerin en az birinde başlıca yazar olmak', ['3.1.1-3.1.4'], 1, yazar: 'baslica', donem: $DOCENTLIK, madde: 'MADDE 24/ı'),
        Kalip::adet('TR Dizin kapsamındaki dergilerde en az iki makale yayımlamış olmak', ['3.2.1'], 2, donem: $DOCENTLIK, madde: 'MADDE 24/ı'),
        Kalip::adet('Bu makalelerin en az birinde başlıca yazar olmak', ['3.2.1'], 1, yazar: 'baslica', donem: $DOCENTLIK, madde: 'MADDE 24/ı'),
        $PROJE_YURUTUCU,
        $KITAP,
        Kalip::puanDan('Atıflardan en az 10 puan almak', ['3.10'], 10, $DOCENTLIK, madde: 'MADDE 24/ı'),
        Kalip::toplam(200, $DOCENTLIK),
    ]],
    ['ziraat', ['ziraat'], 'Ziraat, Orman ve Su Ürünleri', [
        Kalip::adet('Uluslararası ya da ulusal hakemli dergilerde en az üç makale yayımlamış olmak', ['3.1-3.2'], 3, donem: $DOCENTLIK, madde: 'MADDE 24/i'),
        Kalip::adet('Bu makalelerin en az ikisinde başlıca yazar olmak', ['3.1-3.2'], 2, yazar: 'baslica', donem: $DOCENTLIK, madde: 'MADDE 24/i'),
        Kalip::adet('Tez danışmanlığı ve jüri üyelikleri başlığından en az iki faaliyet', ['3.4'], 2, donem: $DOCENTLIK, madde: 'MADDE 24/i'),
        $PROJE_YURUTUCU,
        Kalip::toplam(200, $DOCENTLIK),
    ]],
];

foreach ($profTablosu as [$kod, $alanlar, $alanAdi, $kosullar]) {
    $esikler[] = [
        'anahtar' => "ardahan-{$kod}-profesorluk",
        'universite' => $UNIVERSITE,
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => $alanAdi.' profesörlük (MADDE 24). Bütün koşullar doçentlik unvanı '
            .'alındıktan sonraki faaliyetlerden sağlanmalı.',
        'aday_notu' => $alanAdi.' alanında profesör kadrosuna atanma. Yönerge bütün asgari '
            .'faaliyetlerin ve puanların DOÇENT UNVANINI ALDIKTAN SONRAKİ çalışmalardan '
            .'sağlanmasını istiyor. Profesörlük temel eseri olarak makale ve kitap '
            .'yayınlarınızdan biri sunulabilir.'.$NOT_DIL.$NOT_CETVEL,
        'sart' => Kalip::ve('Profesör kadrosuna atanma — '.$alanAdi, [
            $UNVAN,
            $DIL,
            $DIL_NOT,
            $MADDE22,
            ...$kosullar,
        ]),
    ];
}

$esikler[] = [
    'anahtar' => 'ardahan-guzel-sanatlar-profesorluk',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['guzel_sanatlar'],
    'cetvel' => $CETVEL,
    'notlar' => 'Güzel Sanatlar profesörlük (MADDE 24/d). Toplam puan barajı yok; kurumsal '
        .'katkı ve sanatsal faaliyetlerden 200 puan aranıyor. Yıldızlı not Plastik ve Görsel '
        .'Sanatlar için kişisel etkinlik istiyor.',
    'aday_notu' => 'Güzel Sanatlar alanında profesör kadrosuna atanma. Bu alanda genel toplam '
        .'puan barajı yok; onun yerine kurumsal katkı ve sanatsal faaliyet kalemlerinden 200 '
        .'puan aranıyor. Yönergenin yıldızlı notu kişisel sergi ya da gösteri koşulunu yalnız '
        .'PLASTİK ve GÖRSEL SANATLAR için koyuyor; profil sanat dalınızı taşımadığı için koşul '
        .'bütün Güzel Sanatlar adaylarına uygulandı, müzik ya da sahne sanatlarından '
        .'başvuruyorsanız burada olduğundan sıkı görünür.'.$NOT_DIL.$NOT_CETVEL,
    'sart' => Kalip::ve('Profesör kadrosuna atanma — Güzel Sanatlar', [
        $UNVAN,
        $DIL,
        $DIL_NOT,
        $MADDE22,
        Kalip::adet('Uluslararası ya da ulusal hakemli dergilerde en az bir makale yayımlamış olmak', ['3.1-3.2'], 1, donem: $DOCENTLIK, madde: 'MADDE 24/d'),
        Kalip::adet('TR Dizin kapsamındaki bir dergide en az bir makale yayımlamış olmak', ['3.2.1'], 1, donem: $DOCENTLIK, madde: 'MADDE 24/d'),
        Kalip::adet('En az bir özgün bilimsel kitap, kitap bölümü ya da kitap editörlüğü', ['3.3'], 1, donem: $DOCENTLIK, madde: 'MADDE 24/d'),
        $PROJE_YURUTUCU,
        Kalip::puanDan('Kurumsal katkı ve sanatsal faaliyet kalemlerinden en az 200 puan almak', ['KURUMSAL-VE-SANATSAL'], 200, $DOCENTLIK, madde: 'MADDE 24/d'),
        Kalip::adet('Yurt içinde ya da yurt dışında özgün yapıt ve eserlerle en az bir kişisel sergi veya gösteri gerçekleştirmiş olmak', ['KISISEL-SERGI'], 1, donem: $DOCENTLIK, madde: 'MADDE 24/d'),
    ]),
];

return $esikler;
