<?php

/**
 * ACIBADEM MEHMET ALİ AYDINLAR ÜNİVERSİTESİ — Öğretim Üyeliğine Atanma ve
 * Yükseltilme Kriterleri
 * Kaynak: pdf/17634002431.Acıbadem Mehmet Ali Aydınlar Üniversitesi Kriter.pdf
 * (YÖK Başkanlığının 27.02.2025 tarih 8352 sayılı yazısıyla yürürlükte.)
 * Cetvel: cetvel/acibadem-2025.php (altı varyant; aralarındaki tek fark
 * atıf tavanı)
 *
 * ── DÖRT TEMEL ALAN GRUBU, DÖRDÜ DE GİRİLDİ ──
 * Yönerge dört alan grubu tanıyor: Sağlık Bilimleri; Sosyal, Beşeri ve İdari
 * Bilimler; Mühendislik ile Fen Bilimleri ve Matematik; Eğitim Bilimleri ile
 * Spor Bilimleri. Bunların dışındaki temel alanlar (Filoloji, Hukuk,
 * İlahiyat, Mimarlık-Planlama-Tasarım, Güzel Sanatlar, Ziraat) yönergede HİÇ
 * geçmiyor; §0 uyarınca o alanlara eşik YAZILMADI — yarısı uydurma bir baraj
 * göstermektense hiç göstermemek doğru.
 *
 * ── ATIF TAVANI KADROYA GÖRE DEĞİŞİYOR ──
 * "Atıflardan alınan puan EK-1'den alınması gereken toplam puanın %20'sini
 * geçemez." Tavan cetvel başına tanımlanabildiği için cetvelin altı varyantı
 * üretildi (6, 12, 13, 16, 18, 24) ve her eşik kendi toplamına karşılık gelen
 * varyanta bağlandı. Yeniden atanmada toplam puan barajı olmadığı için en
 * düşük tavanlı varyant kullanıldı.
 *
 * ── "EK OLARAK" SAYILARI TOPLAMA ÇEVRİLDİ ──
 * Yönerge çoğu maddede "(a)'ya EK OLARAK şu kategorilerde en az iki yayın"
 * diyor. Motor "(a)'da sayılanların DIŞINDA" diye bir kısıt kuramıyor; bu
 * yüzden ek sayı, (a)'nın istediği sayıyla TOPLANARAK tek bir koşula
 * çevrildi (ör. Sağlıkta doçentlik: 1A'da başlıca yazar 3 yayın + 1A-D'de 2
 * ek yayın → 1A-D'de toplam 5 yayın). (a)'nın kümesi ek maddenin kümesinin
 * alt kümesi olduğu için bu okuma yönergeye sadık; alt küme olmadığı tek yer
 * Sosyal alanın kitap seçenekleri ve orada koşul biraz SIKI çıkıyor.
 *
 * ── YABANCI DİL ──
 * İngilizce eğitim yapan programlarda 85, Türkçe eğitim yapan programlarda
 * 65 puan aranıyor. Adayın başvuracağı programın dili kayıtta taşınmadığı
 * için 65 uygulandı ve 85 aday notuna yazıldı (Şırnak'ta aynı yol izlendi).
 * Anadil, yurt dışında tamamlanan öğrenim ve yurt dışında öğretim
 * elemanlığı muafiyetleri ile İngilizce deneme sunumu beyan koşulu.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Yeniden atanmanın Birim Başkanı önerisi, Dekan/Müdür uygun görüşü,
 *       Periyodik Akademisyen Performans Değerlendirmesi ve Mütevelli
 *       Heyeti onayı — süreç hükümleri.
 *   Profesörlükte Sosyal alanın (a) maddesindeki "ilk ya da İKİNCİ yazar"
 *       seçeneği: motorun sıra seçenekleri arasında "ilk ya da ikinci"
 *       yoktur, §0 uyarınca yalnız ilk yazarlık arandı — koşul burada
 *       olduğundan SIKI görünür.
 *   Yayınların adayın başvurduğu temel alanla ilgili olması koşulu.
 *   "Bir çalışma birden fazla kategoride yer alıyorsa en yüksek puan aldığı
 *       kategoriden değerlendirilir" — motorun zaten yaptığı şey.
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Acıbadem Mehmet Ali Aydınlar Üniversitesi';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON3 = Kalip::sonYil(3);

$SAGLIK = ['saglik'];
$SOSYAL = ['sosyal'];
$MUHFEN = ['muhendislik', 'fen'];
$EGITIM = ['egitim', 'spor'];

$NOT_DIL = ' Yabancı dil koşulu Türkçe eğitim yapan programlar için geçerli olan 65 puandan '
    .'uygulanıyor; İNGİLİZCE eğitim yapan bir programa başvuruyorsanız en az 85 puan '
    .'gerekiyor. Öğretim dilinin anadiliniz olması, lisans ya da doktoranızı o dilin anadil '
    .'olduğu ülkede tamamlamanız veya orada en az bir yıl öğretim elemanı olarak ders '
    .'vermeniz de dil koşulunun yerine geçiyor.';

$NOT_ATIF = ' Atıflardan alabileceğiniz puan, bu kadro için gereken toplam puanın %20\'siyle '
    .'sınırlı. Atıf satırlarının yarım puanlıları aşağı yuvarlanınca sıfırlandığı için '
    .'pratikte yalnız BKCI, SCOPUS ya da SENSE kapsamındaki kitaplarda yapılan atıflar puan '
    .'getiriyor.';

$DIL = Kalip::yds(65);
$SUNUM = Kalip::beyan(
    'İngilizce eğitim yapan programlarda İngilizce deneme sunumunda başarılı olmak',
    'EK OLARAK, TÜM TEMEL ALANLARDA'
);
$UNVAN = Kalip::beyan(
    'Üniversitelerarası Kurul tarafından verilen doçentlik unvanına sahip olmak',
    '2547 s.K. m.24'
);

/** Yeniden atanmada aranan proje ya da ek yayın koşulu (b ve c maddeleri). */
$yenidenProjeYaDaYayin = Kalip::veya('Proje ya da ek yayın koşulunu sağlamak', [
    Kalip::adet(
        'Kurum içi ya da kurum dışı fonlarla desteklenen bir araştırma projesinde yürütücü veya saha koordinatörü olmak',
        ['PROJE-YURUTUCU'], 1, donem: $SON3, madde: 'Yeniden atanma/b'
    ),
    Kalip::adet(
        'Kurum içi ya da kurum dışı fonlarla desteklenen iki araştırma projesinde araştırmacı olmak',
        ['PROJE-ARASTIRMACI'], 2, donem: $SON3, madde: 'Yeniden atanma/b'
    ),
    Kalip::adet(
        '1A-B, 2A-B ya da 3A-B kategorilerinde başlıca yazar olarak bir yayın daha yapmış olmak',
        ['1A-B-2A-B-3A-B'], 2, yazar: 'baslica', donem: $SON3, madde: 'Yeniden atanma/c'
    ),
]);

$esikler = [];

// ═══════════════ DOKTOR ÖĞRETİM ÜYESİ — İLK ATANMA ═══════════════
$esikler[] = [
    'anahtar' => 'acibadem-saglik-dr',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => $SAGLIK,
    'cetvel' => 'acibadem-2025-atif6',
    'notlar' => 'Sağlık Bilimleri Temel Alanı, doktor öğretim üyesi ilk atanma: 1A\'da ilk yazar '
        .'bir yayın, 1A-D\'de toplam üç yayın, 1A-D + 2A-B\'den 15 puan, toplam 30 puan.',
    'aday_notu' => 'Sağlık Bilimleri alanında doktor öğretim üyesi kadrosuna İLK ATANMA. '
        .'İlk yazar olarak istenen yayın doktora, tıpta uzmanlık ya da eczacılıkta uzmanlık '
        .'tezinizden üretilmiş olabilir. "Ek olarak iki yayın" koşulu, (a) maddesindeki yayınla '
        .'birlikte 1A-D kategorilerinde toplam üç yayın olarak hesaplanıyor.'.$NOT_DIL.$NOT_ATIF,
    'sart' => Kalip::ve('Doktor öğretim üyesi kadrosuna ilk atanma — Sağlık Bilimleri', [
        $DIL,
        $SUNUM,
        Kalip::adet('SCI-Expanded, SSCI ya da AHCI kapsamındaki dergilerde ilk yazar olarak en az bir özgün araştırma makalesi yayımlamış olmak', ['1A'], 1, yazar: 'ilk', madde: 'a'),
        Kalip::adet('1A-D kategorilerinde (özgün makale, derleme, kısa makale, vaka raporu) toplam en az üç yayın yapmış olmak', ['1A-D'], 3, madde: 'b'),
        Kalip::puanDan('1A-D ve 2A-B kategorilerindeki faaliyetlerden en az 15 puan almak', ['1A-D-2A-B'], 15, madde: 'c'),
        Kalip::toplam(30),
    ]),
];

$esikler[] = [
    'anahtar' => 'acibadem-sosyal-dr',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => $SOSYAL,
    'cetvel' => 'acibadem-2025-atif6',
    'notlar' => 'Sosyal, Beşeri ve İdari Bilimler Temel Alanı, doktor öğretim üyesi ilk atanma: '
        .'1A, 2A, 3A, 4A.1, 4A.3, 4B.1, 4B.3\'te ilk yazar bir yayın; 3A-B ve 3D-G\'de iki '
        .'yayın (biri tek ya da başlıca yazar) ya da 1A-2A\'da ek bir yayın; toplam 30 puan.',
    'aday_notu' => 'Sosyal, Beşeri ve İdari Bilimler alanında doktor öğretim üyesi kadrosuna '
        .'İLK ATANMA. İlk yazar olarak istenen yayın doktora tezinizden üretilmiş olabilir. '
        .'İkinci koşulu ya TR Dizin dergilerinde iki yayınla (en az birinde tek ya da başlıca '
        .'yazar olarak) ya da 1A-2A kategorilerinde ek bir yayınla karşılayabilirsiniz.'
        .$NOT_DIL.$NOT_ATIF,
    'sart' => Kalip::ve('Doktor öğretim üyesi kadrosuna ilk atanma — Sosyal Bilimler', [
        $DIL,
        $SUNUM,
        Kalip::adet('1A, 2A, 3A kategorilerinde ya da kitap veya kitap bölümü yazarlığında ilk yazar olarak en az bir yayın yapmış olmak', ['SOSYAL-A'], 1, yazar: 'ilk', madde: 'a'),
        Kalip::veya('İkinci yayın koşulunu sağlamak', [
            Kalip::ve('TR Dizin dergilerinde iki yayın (en az birinde tek ya da başlıca yazar)', [
                Kalip::adet('3A-B ve 3D-G kategorilerinde en az iki yayın yapmış olmak', ['3A-B-3D-G'], 2, madde: 'b'),
                Kalip::adet('3A-B ve 3D-G kategorilerindeki yayınlarınızın en az birinde tek ya da başlıca yazar olmak', ['3A-B-3D-G'], 1, yazar: 'baslica', madde: 'b'),
            ]),
            Kalip::adet('1A ve 2A kategorilerinde toplam en az iki yayın yapmış olmak', ['1A-2A'], 2, madde: 'b'),
        ]),
        Kalip::toplam(30),
    ]),
];

$esikler[] = [
    'anahtar' => 'acibadem-muhfen-dr',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => $MUHFEN,
    'cetvel' => 'acibadem-2025-atif13',
    'notlar' => 'Mühendislik ile Fen Bilimleri ve Matematik Temel Alanları, doktor öğretim üyesi '
        .'ilk atanma: 1A\'da ilk yazar bir yayın, 1A-C\'de toplam iki yayın, 1A-C\'den 45 puan, '
        .'toplam 65 puan.',
    'aday_notu' => 'Mühendislik ile Fen Bilimleri ve Matematik alanlarında doktor öğretim üyesi '
        .'kadrosuna İLK ATANMA. İlk yazar olarak istenen yayın doktora tezinizden üretilmiş '
        .'olabilir. Bu alanda puan barajı diğer alanlardan yüksek: yalnız 1A-C kategorilerinden '
        .'45 puan gerekiyor, yani Q1 dergide tek bir makale (60 puan) bu koşulu tek başına '
        .'karşılıyor.'.$NOT_DIL.$NOT_ATIF,
    'sart' => Kalip::ve('Doktor öğretim üyesi kadrosuna ilk atanma — Mühendislik, Fen ve Matematik', [
        $DIL,
        $SUNUM,
        Kalip::adet('SCI-Expanded, SSCI ya da AHCI kapsamındaki dergilerde ilk yazar olarak en az bir özgün araştırma makalesi yayımlamış olmak', ['1A'], 1, yazar: 'ilk', madde: 'a'),
        Kalip::adet('1A-C kategorilerinde toplam en az iki yayın yapmış olmak', ['1A-C'], 2, madde: 'b'),
        Kalip::puanDan('1A-C kategorilerindeki faaliyetlerden en az 45 puan almak', ['1A-C'], 45, madde: 'c'),
        Kalip::toplam(65),
    ]),
];

$esikler[] = [
    'anahtar' => 'acibadem-egitim-dr',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => $EGITIM,
    'cetvel' => 'acibadem-2025-atif6',
    'notlar' => 'Eğitim Bilimleri ve Spor Bilimleri Temel Alanları, doktor öğretim üyesi ilk '
        .'atanma: 1A, 2A, 3A\'da ilk yazar bir yayın; 1A-E, 2A-G, 3A-G\'de toplam üç yayın; '
        .'toplam 30 puan.',
    'aday_notu' => 'Eğitim Bilimleri ve Spor Bilimleri alanlarında doktor öğretim üyesi '
        .'kadrosuna İLK ATANMA. İlk yazar olarak istenen yayın doktora tezinizden üretilmiş '
        .'olabilir. "Ek olarak iki yayın" koşulu, (a) maddesindeki yayınla birlikte toplam üç '
        .'yayın olarak hesaplanıyor.'.$NOT_DIL.$NOT_ATIF,
    'sart' => Kalip::ve('Doktor öğretim üyesi kadrosuna ilk atanma — Eğitim ve Spor Bilimleri', [
        $DIL,
        $SUNUM,
        Kalip::adet('1A, 2A ya da 3A kategorilerinde ilk yazar olarak en az bir özgün araştırma makalesi yayımlamış olmak', ['1A-2A-3A'], 1, yazar: 'ilk', madde: 'a'),
        Kalip::adet('1A-E, 2A-G ve 3A-G kategorilerinde toplam en az üç yayın yapmış olmak', ['YAYIN-HEPSI'], 3, madde: 'b'),
        Kalip::toplam(30),
    ]),
];

// ═══════════════ DOKTOR ÖĞRETİM ÜYESİ — YENİDEN ATANMA ═══════════════
$yenidenA = [
    'saglik' => Kalip::adet('SCI-Expanded, SSCI ya da AHCI kapsamındaki dergilerde ilk yazar olarak en az bir özgün araştırma makalesi yayımlamış olmak', ['1A'], 1, yazar: 'ilk', donem: $SON3, madde: 'a'),
    'sosyal' => Kalip::adet('1A, 2A, 3A kategorilerinde ya da kitap veya kitap bölümü yazarlığında ilk yazar olarak en az bir yayın yapmış olmak', ['SOSYAL-A'], 1, yazar: 'ilk', donem: $SON3, madde: 'a'),
    'muhfen' => Kalip::adet('SCI-Expanded, SSCI ya da AHCI kapsamındaki dergilerde ilk yazar olarak en az bir özgün araştırma makalesi yayımlamış olmak', ['1A'], 1, yazar: 'ilk', donem: $SON3, madde: 'a'),
    'egitim' => Kalip::adet('1A, 2A ya da 3A kategorilerinde ilk yazar olarak en az bir özgün araştırma makalesi yayımlamış olmak', ['1A-2A-3A'], 1, yazar: 'ilk', donem: $SON3, madde: 'a'),
];

$yenidenAlanlar = [
    'saglik' => [$SAGLIK, 'Sağlık Bilimleri'],
    'sosyal' => [$SOSYAL, 'Sosyal, Beşeri ve İdari Bilimler'],
    'muhfen' => [$MUHFEN, 'Mühendislik ile Fen Bilimleri ve Matematik'],
    'egitim' => [$EGITIM, 'Eğitim Bilimleri ve Spor Bilimleri'],
];

foreach ($yenidenAlanlar as $kod => [$alanlar, $alanAdi]) {
    $esikler[] = [
        'anahtar' => "acibadem-{$kod}-dr-yeniden",
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $alanlar,
        'cetvel' => 'acibadem-2025-atif6',
        'notlar' => $alanAdi.' Temel Alanı, doktor öğretim üyesi yeniden atanma: son üç yılda '
            .'ilk atanma kriterlerinin (a) maddesini tekrar karşılamak ve proje koşulunu ya da '
            .'ek yayın koşulunu sağlamak. Toplam puan barajı yok.',
        'aday_notu' => $alanAdi.' alanında doktor öğretim üyesi kadrosuna YENİDEN ATANMA. '
            .'Atamalar üç yıllık; yalnız SON ÜÇ YILDAKİ çalışmalarınız sayılıyor. Yönerge '
            .'ayrıca Birim Başkanının önerisini, Dekan ya da Müdürün uygun görüşünü, Periyodik '
            .'Akademisyen Performans Değerlendirme sürecinden olumlu değerlendirme almanızı ve '
            .'Mütevelli Heyeti onayını arıyor; bunlar burada değerlendirilmiyor. "(c) bir yayın '
            .'daha" koşulu, (a) maddesindeki yayınla birlikte toplam iki yayın olarak '
            .'hesaplanıyor.'.$NOT_DIL,
        'sart' => Kalip::ve('Doktor öğretim üyesi kadrosuna yeniden atanma — '.$alanAdi, [
            $DIL,
            $yenidenA[$kod],
            $yenidenProjeYaDaYayin,
        ]),
    ];
}

// ═══════════════ DOÇENT ═══════════════
$esikler[] = [
    'anahtar' => 'acibadem-saglik-docentlik',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => $SAGLIK,
    'cetvel' => 'acibadem-2025-atif16',
    'notlar' => 'Sağlık Bilimleri Temel Alanı, doçentlik: 1A\'da başlıca yazar üç yayın (en az '
        .'ikisi doktora/uzmanlık sonrası), 1A-D\'de toplam beş yayın, doktora sonrası 1A-D + '
        .'2A-B\'den 40 puan, doktora sonrası toplam 80 puan.',
    'aday_notu' => 'Sağlık Bilimleri alanında doçent kadrosuna yükseltilme ve atanma. Puanlar '
        .'doktora, tıpta uzmanlık ya da eczacılıkta uzmanlık derecenizi aldıktan SONRAKİ '
        .'çalışmalarınızdan hesaplanıyor. "Ek olarak iki yayın" koşulu, (a) maddesindeki üç '
        .'yayınla birlikte 1A-D kategorilerinde toplam beş yayın olarak hesaplanıyor.'
        .$NOT_DIL.$NOT_ATIF,
    'sart' => Kalip::ve('Doçent kadrosuna yükseltilme ve atanma — Sağlık Bilimleri', [
        $UNVAN,
        $DIL,
        $SUNUM,
        Kalip::adet('SCI-Expanded, SSCI ya da AHCI kapsamındaki dergilerde başlıca yazar olarak en az üç özgün araştırma makalesi yayımlamış olmak', ['1A'], 3, yazar: 'baslica', madde: 'a'),
        Kalip::adet('Bu makalelerin en az ikisini doktora, tıpta uzmanlık ya da eczacılıkta uzmanlık derecenizi aldıktan sonra yayımlamış olmak', ['1A'], 2, yazar: 'baslica', donem: $DOKTORA, madde: 'a'),
        Kalip::adet('1A-D kategorilerinde toplam en az beş yayın yapmış olmak', ['1A-D'], 5, madde: 'b'),
        Kalip::puanDan('Doktora ya da uzmanlık derecenizden sonra 1A-D ve 2A-B kategorilerindeki faaliyetlerden en az 40 puan almak', ['1A-D-2A-B'], 40, $DOKTORA, madde: 'c'),
        Kalip::toplam(80, $DOKTORA),
    ]),
];

$esikler[] = [
    'anahtar' => 'acibadem-sosyal-docentlik',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => $SOSYAL,
    'cetvel' => 'acibadem-2025-atif12',
    'notlar' => 'Sosyal, Beşeri ve İdari Bilimler Temel Alanı, doçentlik: doktora sonrası 1A-B '
        .'ve 2A-B\'de ilk yazar bir yayın; 3A-B ile kitap kategorilerinde üç yayın (biri tek ya '
        .'da başlıca yazar) ya da 1A-2A\'da ek yayın; 4A-B\'den 20 puan; toplam 60 puan; '
        .'doktora sonrası dört yarıyıl ders.',
    'aday_notu' => 'Sosyal, Beşeri ve İdari Bilimler alanında doçent kadrosuna yükseltilme ve '
        .'atanma. Yayın koşulları doktora derecenizi aldıktan SONRAKİ çalışmalarınızdan '
        .'hesaplanıyor; puan barajlarında dönem sınırı yok. Kitap ve kitap bölümü '
        .'kategorilerinden (4A-B) en az 20 puan gerekiyor, yani bu alanda kitap yazmadan '
        .'doçent olmak zor. Ayrıca doktora sonrası en az dört yarıyıl ders vermiş olmanız '
        .'gerekiyor.'.$NOT_DIL.$NOT_ATIF,
    'sart' => Kalip::ve('Doçent kadrosuna yükseltilme ve atanma — Sosyal Bilimler', [
        $UNVAN,
        $DIL,
        $SUNUM,
        Kalip::adet('Doktora derecenizi aldıktan sonra 1A-B ve 2A-B kategorilerinde ilk yazar olarak en az bir yayın yapmış olmak', ['1A-B-2A-B-3A-B'], 1, yazar: 'ilk', donem: $DOKTORA, madde: 'a'),
        Kalip::veya('Ek yayın koşulunu sağlamak', [
            Kalip::ve('TR Dizin dergileri ve kitap kategorilerinde üç yayın (en az birinde tek ya da başlıca yazar)', [
                Kalip::adet('Doktora derecenizi aldıktan sonra 3A-B ve kitap kategorilerinde toplam en az üç yayın yapmış olmak', ['SOSYAL-DOC-B'], 3, donem: $DOKTORA, madde: 'b'),
                Kalip::adet('Bu yayınlarınızın en az birinde tek ya da başlıca yazar olmak', ['SOSYAL-DOC-B'], 1, yazar: 'baslica', donem: $DOKTORA, madde: 'b'),
            ]),
            Kalip::adet('Doktora derecenizi aldıktan sonra 1A ve 2A kategorilerinde toplam en az iki yayın yapmış olmak', ['1A-2A'], 2, donem: $DOKTORA, madde: 'b'),
        ]),
        Kalip::puanDan('Kitap ve kitap bölümü kategorilerinden (4A-B) en az 20 puan almak', ['4A-B'], 20, madde: 'c'),
        Kalip::toplam(60),
        Kalip::metrik('Doktora derecenizi aldıktan sonra alanınızda en az dört yarıyıl ders vermiş olmak', 'ders_yariyil', 4, $DOKTORA),
    ]),
];

$esikler[] = [
    'anahtar' => 'acibadem-muhfen-docentlik',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => $MUHFEN,
    'cetvel' => 'acibadem-2025-atif18',
    'notlar' => 'Mühendislik ile Fen Bilimleri ve Matematik Temel Alanları, doçentlik: doktora '
        .'sonrası 1A-B\'de başlıca yazar iki yayın, 1A-C\'de toplam beş yayın, doktora sonrası '
        .'1A-E\'den 60 puan, doktora sonrası toplam 90 puan.',
    'aday_notu' => 'Mühendislik ile Fen Bilimleri ve Matematik alanlarında doçent kadrosuna '
        .'yükseltilme ve atanma. Bu alanın puan barajları yönergenin en yükseği: doktora '
        .'sonrası yalnız 1A-E kategorilerinden 60, toplamda 90 puan gerekiyor. "Ek olarak üç '
        .'yayın" koşulu, (a) maddesindeki iki yayınla birlikte 1A-C kategorilerinde toplam beş '
        .'yayın olarak hesaplanıyor.'.$NOT_DIL.$NOT_ATIF,
    'sart' => Kalip::ve('Doçent kadrosuna yükseltilme ve atanma — Mühendislik, Fen ve Matematik', [
        $UNVAN,
        $DIL,
        $SUNUM,
        Kalip::adet('Doktora derecenizi aldıktan sonra 1A-B kategorilerinde başlıca yazar olarak en az iki yayın yapmış olmak', ['1A-B'], 2, yazar: 'baslica', donem: $DOKTORA, madde: 'a'),
        Kalip::adet('1A-C kategorilerinde toplam en az beş yayın yapmış olmak', ['1A-C'], 5, madde: 'b'),
        Kalip::puanDan('Doktora ya da tıpta uzmanlık derecenizden sonra 1A-E kategorilerindeki faaliyetlerden en az 60 puan almak', ['1A-D'], 60, $DOKTORA, madde: 'c'),
        Kalip::toplam(90, $DOKTORA),
    ]),
];

$esikler[] = [
    'anahtar' => 'acibadem-egitim-docentlik',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => $EGITIM,
    'cetvel' => 'acibadem-2025-atif12',
    'notlar' => 'Eğitim Bilimleri ve Spor Bilimleri Temel Alanları, doçentlik: doktora sonrası '
        .'1A, 2A, 3A\'da başlıca yazar iki yayın; 1A-E, 2A-G, 3A-G\'de toplam beş yayın; '
        .'toplam 60 puan.',
    'aday_notu' => 'Eğitim Bilimleri ve Spor Bilimleri alanlarında doçent kadrosuna yükseltilme '
        .'ve atanma. Başlıca yazarlık koşulu doktora derecenizi aldıktan SONRAKİ çalışmalarınız '
        .'için; toplam yayın sayısı ve puan barajında dönem sınırı yok. "Ek olarak üç yayın" '
        .'koşulu, (a) maddesindeki iki yayınla birlikte toplam beş yayın olarak '
        .'hesaplanıyor.'.$NOT_DIL.$NOT_ATIF,
    'sart' => Kalip::ve('Doçent kadrosuna yükseltilme ve atanma — Eğitim ve Spor Bilimleri', [
        $UNVAN,
        $DIL,
        $SUNUM,
        Kalip::adet('Doktora derecenizi aldıktan sonra 1A, 2A ya da 3A kategorilerinde başlıca yazar olarak en az iki yayın yapmış olmak', ['1A-2A-3A'], 2, yazar: 'baslica', donem: $DOKTORA, madde: 'a'),
        Kalip::adet('1A-E, 2A-G ve 3A-G kategorilerinde toplam en az beş yayın yapmış olmak', ['YAYIN-HEPSI'], 5, madde: 'b'),
        Kalip::toplam(60),
    ]),
];

// ═══════════════ PROFESÖR ═══════════════
$esikler[] = [
    'anahtar' => 'acibadem-saglik-profesorluk',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => $SAGLIK,
    'cetvel' => 'acibadem-2025-atif24',
    'notlar' => 'Sağlık Bilimleri Temel Alanı, profesörlük: 1A-B\'de başlıca yazar beş yayın '
        .'(en az ikisi doçentlik sonrası), doçentlik sonrası 1A-D\'de toplam dört yayın, '
        .'bunların en az biri Q1 ya da en az ikisi Q2, doçentlik sonrası 1A-D + 2A-B\'den 60 '
        .'puan, doçentlik sonrası toplam 120 puan.',
    'aday_notu' => 'Sağlık Bilimleri alanında profesör kadrosuna yükseltilme ve atanma. '
        .'Yönergenin en ağır eşikleri burada: doçentlik sonrası yalnız 1A-D + 2A-B\'den 60, '
        .'toplamda 120 puan. Doçentlik sonrası yayınlarınızın en az birinin Q1 ya da en az '
        .'ikisinin Q2 dergilerde olması ayrıca aranıyor. "Ek olarak iki yayın" koşulu, (a) '
        .'maddesinin doçentlik sonrası iki yayınıyla birlikte doçentlik sonrası 1A-D\'de toplam '
        .'dört yayın olarak hesaplanıyor.'.$NOT_DIL.$NOT_ATIF,
    'sart' => Kalip::ve('Profesör kadrosuna yükseltilme ve atanma — Sağlık Bilimleri', [
        $DIL,
        $SUNUM,
        Kalip::adet('1A-B kategorilerinde başlıca yazar olarak en az beş yayın yapmış olmak', ['1A-B'], 5, yazar: 'baslica', madde: 'a'),
        Kalip::adet('Bu yayınların en az ikisini doçent unvanını aldıktan sonra yapmış olmak', ['1A-B'], 2, yazar: 'baslica', donem: $DOCENTLIK, madde: 'a'),
        Kalip::adet('Doçent unvanını aldıktan sonra 1A-D kategorilerinde toplam en az dört yayın yapmış olmak', ['1A-D'], 4, donem: $DOCENTLIK, madde: 'b'),
        Kalip::veya('Doçentlik sonrası yayınların çeyreklik koşulunu sağlamak', [
            Kalip::adet('Doçent unvanını aldıktan sonra Q1 kategorisindeki bir dergide yayın yapmış olmak', ['1A-D-Q1'], 1, donem: $DOCENTLIK, madde: 'b'),
            Kalip::adet('Doçent unvanını aldıktan sonra Q2 kategorisindeki dergilerde en az iki yayın yapmış olmak', ['1A-D-Q2'], 2, donem: $DOCENTLIK, madde: 'b'),
        ]),
        Kalip::puanDan('Doçent unvanını aldıktan sonra 1A-D ve 2A-B kategorilerindeki faaliyetlerden en az 60 puan almak', ['1A-D-2A-B'], 60, $DOCENTLIK, madde: 'c'),
        Kalip::toplam(120, $DOCENTLIK),
    ]),
];

$esikler[] = [
    'anahtar' => 'acibadem-sosyal-profesorluk',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => $SOSYAL,
    'cetvel' => 'acibadem-2025-atif12',
    'notlar' => 'Sosyal, Beşeri ve İdari Bilimler Temel Alanı, profesörlük: doçentlik sonrası '
        .'1A-2A\'da ilk yazar bir yayın; doçentlik sonrası 1A-B, 2A-B, 3A-B ve kitap '
        .'kategorilerinde üç yayın (biri tek ya da başlıca yazar); 4A-B\'den 30 puan; '
        .'doçentlik sonrası 60 puan; doçentlik sonrası on yarıyıl ders.',
    'aday_notu' => 'Sosyal, Beşeri ve İdari Bilimler alanında profesör kadrosuna yükseltilme ve '
        .'atanma. Yönerge (a) maddesinde "ilk ya da ikinci yazar" diyor; motorun yazar sırası '
        .'seçenekleri arasında bu ikili seçenek olmadığı için yalnız İLK yazarlık arandı, '
        .'koşul burada olduğundan sıkı görünüyor — ikinci yazar olduğunuz bir yayınla da '
        .'karşılanabilir. Kitap ve kitap bölümü kategorilerinden 30 puan ve doçentlik sonrası '
        .'en az on yarıyıl ders vermiş olmak ayrıca aranıyor.'.$NOT_DIL.$NOT_ATIF,
    'sart' => Kalip::ve('Profesör kadrosuna yükseltilme ve atanma — Sosyal Bilimler', [
        $DIL,
        $SUNUM,
        Kalip::adet('Doçent unvanını aldıktan sonra 1A ya da 2A kategorilerinde ilk yazar olarak en az bir yayın yapmış olmak', ['1A-2A'], 1, yazar: 'ilk', donem: $DOCENTLIK, madde: 'a'),
        Kalip::adet('Doçent unvanını aldıktan sonra 1A-B, 2A-B, 3A-B ve kitap kategorilerinde toplam en az üç yayın yapmış olmak', ['SOSYAL-PROF-B'], 3, donem: $DOCENTLIK, madde: 'b'),
        Kalip::adet('Bu yayınlarınızın en az birinde tek ya da başlıca yazar olmak', ['SOSYAL-PROF-B'], 1, yazar: 'baslica', donem: $DOCENTLIK, madde: 'b'),
        Kalip::puanDan('Kitap ve kitap bölümü kategorilerinden (4A-B) en az 30 puan almak', ['4A-B'], 30, madde: 'c'),
        Kalip::toplam(60, $DOCENTLIK),
        Kalip::metrik('Doçent unvanını aldıktan sonra alanınızda en az on yarıyıl ders vermiş olmak', 'ders_yariyil', 10, $DOCENTLIK),
    ]),
];

$esikler[] = [
    'anahtar' => 'acibadem-muhfen-profesorluk',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => $MUHFEN,
    'cetvel' => 'acibadem-2025-atif16',
    'notlar' => 'Mühendislik ile Fen Bilimleri ve Matematik Temel Alanları, profesörlük: '
        .'doçentlik sonrası 1A-B\'de üç yayın (en az birinde başlıca yazar), doçentlik sonrası '
        .'1A-C\'den 40 puan, doçentlik sonrası toplam 80 puan.',
    'aday_notu' => 'Mühendislik ile Fen Bilimleri ve Matematik alanlarında profesör kadrosuna '
        .'yükseltilme ve atanma. Bütün koşullar doçent unvanını aldıktan SONRAKİ '
        .'çalışmalarınızdan hesaplanıyor.'.$NOT_DIL.$NOT_ATIF,
    'sart' => Kalip::ve('Profesör kadrosuna yükseltilme ve atanma — Mühendislik, Fen ve Matematik', [
        $DIL,
        $SUNUM,
        Kalip::adet('Doçent unvanını aldıktan sonra 1A-B kategorilerinde en az üç yayın yapmış olmak', ['1A-B'], 3, donem: $DOCENTLIK, madde: 'a'),
        Kalip::adet('Bu yayınlarınızın en az birinde başlıca yazar olmak', ['1A-B'], 1, yazar: 'baslica', donem: $DOCENTLIK, madde: 'a'),
        Kalip::puanDan('Doçent unvanını aldıktan sonra 1A-C kategorilerindeki faaliyetlerden en az 40 puan almak', ['1A-C'], 40, $DOCENTLIK, madde: 'b'),
        Kalip::toplam(80, $DOCENTLIK),
    ]),
];

$esikler[] = [
    'anahtar' => 'acibadem-egitim-profesorluk',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => $EGITIM,
    'cetvel' => 'acibadem-2025-atif12',
    'notlar' => 'Eğitim Bilimleri ve Spor Bilimleri Temel Alanları, profesörlük: doçentlik '
        .'sonrası 1A, 2A, 3A\'da başlıca yazar iki yayın; 1A-E, 2A-G, 3A-G\'de toplam beş '
        .'yayın (en az üçü doçentlik sonrası); doçentlik sonrası toplam 60 puan.',
    'aday_notu' => 'Eğitim Bilimleri ve Spor Bilimleri alanlarında profesör kadrosuna '
        .'yükseltilme ve atanma. Toplam beş yayının en az üçünün doçentlik sonrası olması '
        .'gerekiyor; puan barajı da doçentlik sonrası çalışmalardan hesaplanıyor.'
        .$NOT_DIL.$NOT_ATIF,
    'sart' => Kalip::ve('Profesör kadrosuna yükseltilme ve atanma — Eğitim ve Spor Bilimleri', [
        $DIL,
        $SUNUM,
        Kalip::adet('Doçent unvanını aldıktan sonra 1A, 2A ya da 3A kategorilerinde başlıca yazar olarak en az iki yayın yapmış olmak', ['1A-2A-3A'], 2, yazar: 'baslica', donem: $DOCENTLIK, madde: 'a'),
        Kalip::adet('1A-E, 2A-G ve 3A-G kategorilerinde toplam en az beş yayın yapmış olmak', ['YAYIN-HEPSI'], 5, madde: 'b'),
        Kalip::adet('Bu yayınların en az üçünü doçent unvanını aldıktan sonra yapmış olmak', ['YAYIN-HEPSI'], 3, donem: $DOCENTLIK, madde: 'b'),
        Kalip::toplam(60, $DOCENTLIK),
    ]),
];

return $esikler;
