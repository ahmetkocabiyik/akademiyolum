<?php

/**
 * TOROS ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Ölçütleri
 * Kaynak: pdf/17537103872.torosuniversitesi.pdf
 *
 * ÜÇ FAKÜLTE GRUBU, YÖNERGENİN KENDİ ADLANDIRMASI:
 *   Mühendislik ve Sağlık Bilimleri
 *   Sosyal Bilimler
 *   Güzel Sanatlar, Tasarım ve Mimarlık
 *
 * BAŞKA ALAN İÇİN EŞİK YAZILMADI. Yönerge yalnızca bu üç fakülte grubunu
 * sayıyor; fen, eğitim, hukuk, ilahiyat, filoloji, spor ve ziraattan hiç söz
 * etmiyor. Madde 4/a-4 meslek yüksekokulu adaylarını "başvurduğu alan göz
 * önünde bulundurularak" bu üç gruptan birine yönlendiriyor, yani yeni bir
 * temel alan açmıyor.
 *
 * "YARDIMCI DOÇENT" = DR. ÖĞRETİM ÜYESİ. Yönerge 2018 öncesi adlandırmayı
 * kullanıyor; kadro `dr_ogr_uyesi` olarak girildi.
 *
 * PUAN BARAJLARI:
 *                              Dr.   Doçent   Profesör
 *   Mühendislik, Sağlık        30      120      180
 *   Sosyal                     25      120      150
 *   Güzel Sanatlar, Mimarlık   30      100      150
 * Profesörlükte üç grupta da toplamın en az 50 puanı doçentlik sonrası
 * çalışmalardan gelmeli.
 *
 * DOÇENTLİK ALAN GRUPLARI DR.'DAN FARKLI TOPLANIYOR: Madde 5/a mühendislik,
 * SOSYAL ve sağlığı tek satırda (120) topluyor, Madde 5/b güzel sanatlar,
 * tasarım ve mimarlığı ayırıyor (100). Dr. ve profesörlükte sosyal ayrı
 * satırda. Bu yüzden alan grupları kadro başına ayrı tanımlandı.
 *
 * ── DOÇENTLİKTE ÜAK KOŞULU BEYAN ──
 * Madde 5 doçentlik için "Üniversitelerarası Kurulca yürürlüğe konulan
 * Doçentlik Sınav Yönetmeliği ve Doçentliğe Yükseltilme Başvuru Koşulları
 * çerçevesinde kendi temel alanına ve alan koduna ilişkin asgari koşulları
 * yerine getirmiş olmak" diyor. Bu, ÜAK'ın kendi tablosuna bakan bir koşul;
 * Toros'un cetvelinden hesaplanamaz, beyan olarak girildi.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde 9 (yeniden atanma) 2547'ye atıf yapıyor, kendi ölçütü yok.
 *   Yabancı dil şartı yönergede sayı olarak geçmiyor; uydurulmadı.
 *   Madde 4/a-3'ün "Döner Sermaye aracılığıyla bir uygulama projesi yaparak
 *       yayımlamış olmak" dalı: kayıt uygulama projesinin döner sermaye
 *       üzerinden yapılıp yapılmadığını tutmuyor, beyan olarak girildi.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/toros-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;

$muhSaglik = ['muhendislik', 'saglik'];
$sosyal = ['sosyal'];
$gsMimarlik = ['guzel_sanatlar', 'mimarlik'];

$uakKosulu = Kalip::beyan(
    'Üniversitelerarası Kurul\'un doçentlik başvuru koşullarını kendi temel alanınızda '
    .'sağlamış olmak',
    'Madde 5',
);

return [
    // ══════════════════ DR. ÖĞRETİM ÜYESİ ══════════════════
    [
        'anahtar' => 'toros-dr-muh-saglik',
        'aday_notu' => 'İki makalenin en az biri uluslararası indeksli dergide olmalı. '
            .'Tek bir SCI makale (20 puan) ile ULAKBİM makalesi (8 puan) 30 puanlık barajı '
            .'birlikte geçiyor.',
        'universite' => 'Toros Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $muhSaglik,
        'cetvel' => 'toros-2024',
        'notlar' => 'Madde 4/a-1: "en az bir tanesi uluslararası alan indekslerince taranan '
            .'dergilerde yayınlanmış araştırma makalesi olmak üzere toplam iki adet araştırma '
            .'makalesi ve ekte yer alan tablodan en az toplam 30 puan."',
        'sart' => Kalip::ve('Dr. Öğr. Üyeliğine atanma — Mühendislik ve Sağlık Bilimleri', [
            Kalip::adet('En az 2 araştırma makalesi', ['ARASTIRMA-MAKALESI'], 2, madde: 'Madde 4/a-1'),
            Kalip::adet('Bunların en az 1\'i uluslararası indeksli dergide olmalı', ['ULUSLARARASI-INDEKS'], 1, madde: 'Madde 4/a-1'),
            Kalip::toplam(30),
        ]),
    ],
    [
        'anahtar' => 'toros-dr-sosyal',
        'aday_notu' => 'Sosyal bilimlerde ikinci yayın makale olmak zorunda değil: kitap ya da '
            .'kitap bölümü de sayılıyor. Baraj da bir tık düşük (25 puan).',
        'universite' => 'Toros Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $sosyal,
        'cetvel' => 'toros-2024',
        'notlar' => 'Madde 4/a-2: "en az bir tane araştırma makalesi olmak üzere toplam iki adet '
            .'makale veya kitap veya kitap içerisinde bölüm/makale ve ekte yer alan tablodan en '
            .'az toplam 25 puan."',
        'sart' => Kalip::ve('Dr. Öğr. Üyeliğine atanma — Sosyal Bilimler', [
            Kalip::adet('En az 1 araştırma makalesi', ['ARASTIRMA-MAKALESI'], 1, madde: 'Madde 4/a-2'),
            Kalip::adet('Makale, kitap veya kitap bölümü olarak toplam en az 2 yayın', ['MAKALE-KITAP'], 2, madde: 'Madde 4/a-2'),
            Kalip::toplam(25),
        ]),
    ],
    [
        'anahtar' => 'toros-dr-gs-mimarlik',
        'aday_notu' => 'Bu grupta makale zorunlu değil: bir yarışmada jüri üyeliği ya da derece, '
            .'veya döner sermaye üzerinden yapılmış bir uygulama projesi de yayın koşulunu '
            .'karşılıyor. Puan barajı yine 30.',
        'universite' => 'Toros Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $gsMimarlik,
        'cetvel' => 'toros-2024',
        'notlar' => 'Madde 4/a-3: araştırma makalesi VEYA yarışmada jüri üyeliği / derece / '
            .'mansiyon VEYA döner sermaye aracılığıyla yapılmış uygulama projesi; ayrıca '
            .'tablodan en az toplam 30 puan.',
        'sart' => Kalip::ve('Dr. Öğr. Üyeliğine atanma — Güzel Sanatlar, Tasarım ve Mimarlık', [
            Kalip::veya('Araştırma makalesi, yarışma derecesi ya da uygulama projesi', [
                Kalip::adet('En az 1 araştırma makalesi', ['ARASTIRMA-MAKALESI'], 1, madde: 'Madde 4/a-3'),
                Kalip::adet('Ya da bir yarışmada jüri üyeliği, derece veya mansiyon', ['MIMARLIK-ALTERNATIF'], 1, madde: 'Madde 4/a-3'),
                Kalip::beyan('Ya da döner sermaye veya üniversiteye bağlı kuruluşlar aracılığıyla yapılmış bir uygulama projesini yayımlamış olmak', 'Madde 4/a-3'),
            ]) + ['madde' => 'Madde 4/a-3'],
            Kalip::toplam(30),
        ]),
    ],

    // ══════════════════ DOÇENT ══════════════════
    // Madde 5/a mühendislik, SOSYAL ve sağlığı tek grupta topluyor.
    [
        'anahtar' => 'toros-docent-muh-sos-saglik',
        'aday_notu' => 'Doçentlikte Toros kendi barajının yanında ÜAK doçentlik koşullarını da '
            .'arıyor; o koşullar ÜAK\'ın kendi tablosuna baktığı için burada beyan olarak '
            .'duruyor.',
        'universite' => 'Toros Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['muhendislik', 'saglik', 'sosyal'],
        'cetvel' => 'toros-2024',
        'notlar' => 'Madde 5/a: "Mühendislik, sosyal ve sağlık bilimleri alanında … ÜAK asgari '
            .'koşullarını yerine getirmiş olmanın yanında ekte yer alan tablodan en az toplam '
            .'120 puan." Dr. ve profesörlükte sosyal ayrı satırda, doçentlikte aynı grupta.',
        'sart' => Kalip::ve('Doçent kadrosuna atanma — Mühendislik, Sosyal ve Sağlık Bilimleri', [
            $uakKosulu,
            Kalip::toplam(120),
        ]),
    ],
    [
        'anahtar' => 'toros-docent-gs-mimarlik',
        'aday_notu' => 'Güzel Sanatlar, Tasarım ve Mimarlık grubunda doçentlik barajı diğer '
            .'alanlardan düşük (100). ÜAK doçentlik koşulu burada da aranıyor.',
        'universite' => 'Toros Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $gsMimarlik,
        'cetvel' => 'toros-2024',
        'notlar' => 'Madde 5/b: ÜAK asgari koşulları + tablodan en az toplam 100 puan.',
        'sart' => Kalip::ve('Doçent kadrosuna atanma — Güzel Sanatlar, Tasarım ve Mimarlık', [
            $uakKosulu,
            Kalip::toplam(100),
        ]),
    ],

    // ══════════════════ PROFESÖR ══════════════════
    [
        'anahtar' => 'toros-profesor-muh-saglik',
        'aday_notu' => 'Profesörlükte iki baraj birlikte: toplam 180 puan ve bunun en az 50\'si '
            .'doçentlik sonrası çalışmalardan.',
        'universite' => 'Toros Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $muhSaglik,
        'cetvel' => 'toros-2024',
        'notlar' => 'Madde 6/a: "en az 50 puanı doçentlik sonrası çalışmalardan olmak üzere … '
            .'en az toplam 180 puan."',
        'sart' => Kalip::ve('Profesör kadrosuna atanma — Mühendislik ve Sağlık Bilimleri', [
            Kalip::toplam(180),
            Kalip::toplam(50, $DOCENTLIK),
        ]),
    ],
    [
        'anahtar' => 'toros-profesor-sosyal',
        'aday_notu' => 'Sosyal bilimlerde profesörlük barajı 150; doçentlik sonrası payı diğer '
            .'alanlarla aynı (50 puan).',
        'universite' => 'Toros Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $sosyal,
        'cetvel' => 'toros-2024',
        'notlar' => 'Madde 6/b: en az 50 puanı doçentlik sonrası olmak üzere toplam 150 puan.',
        'sart' => Kalip::ve('Profesör kadrosuna atanma — Sosyal Bilimler', [
            Kalip::toplam(150),
            Kalip::toplam(50, $DOCENTLIK),
        ]),
    ],
    [
        'anahtar' => 'toros-profesor-gs-mimarlik',
        'aday_notu' => 'Güzel Sanatlar, Tasarım ve Mimarlıkta profesörlük barajı 150; doçentlik '
            .'sonrası payı 50 puan.',
        'universite' => 'Toros Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $gsMimarlik,
        'cetvel' => 'toros-2024',
        'notlar' => 'Madde 6/c: en az 50 puanı doçentlik sonrası olmak üzere toplam 150 puan.',
        'sart' => Kalip::ve('Profesör kadrosuna atanma — Güzel Sanatlar, Tasarım ve Mimarlık', [
            Kalip::toplam(150),
            Kalip::toplam(50, $DOCENTLIK),
        ]),
    ],
];
