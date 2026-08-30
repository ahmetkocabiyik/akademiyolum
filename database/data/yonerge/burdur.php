<?php

/**
 * BURDUR MEHMET AKİF ERSOY ÜNİVERSİTESİ — Öğretim Üyeliği Kadrolarına Başvuru
 * Koşulları ve Uygulama İlkeleri Hakkında Yönerge
 * Kaynak: pdf/17536991522.burdurmehmetakifersoyuniverstesi.pdf (13 sayfa;
 *         09/02/2016 tarih, 273 sayılı Senato toplantısının 13 no'lu kararı;
 *         25/02/2009 tarihli yönergeyi yürürlükten kaldırıyor, MADDE 6)
 *
 * DOSYA UZUN SÜRE YANLIŞ TEŞHİSLE BEKLEDİ: "yönerge değil, YÖK'e gönderilen
 * üst yazı" diye kayıtlıydı. Doğrusu, ilk iki sayfa Senato kararı ve imza
 * sayfası; yönergenin tamamı 3-13. sayfalarda. PDF taranmış ve metin katmanı
 * yok ama tarama temiz; sayfalar görüntü olarak okundu.
 *
 * TEK BARAJ SATIRI, ON İKİ TEMEL ALAN. Taban puan tablosunun tek satırı
 * "Sağlık Bilimleri, Fen Bilimleri, Sosyal Bilimler" diyor; MADDE 2 ise
 * yönergenin güzel sanatlar bölümlerini (tasarım, görüntü, müzik ve sahne
 * sanatları) da kapsadığını açıkça söylüyor ve çizelgenin 24. maddesi
 * bütünüyle sanatsal etkinliklere ayrılmış. Alan ayrımı olmadığı için on iki
 * temel alanın hepsi aynı barajlara bağlandı — korpusta ender.
 *
 * BARAJ İKİ KATMANLI: toplam puanın yanında "1 inci – 24 üncü maddelerden
 * alınması gereken puan" diye ikinci bir eşik var. 1-24 = makale, bildiri,
 * kitap, çeviri, editörlük, atıf ve sanatsal etkinlikler; 25 ve sonrası
 * (ders, tez, proje, ödül, idari görev, toplumsal katkı, sportif faaliyet)
 * yalnız toplama giriyor.
 *
 *   Profesörlük        toplam 340 · 1-24'ten 200 · doçentlik sonrası 1-24'ten 100
 *   Doçentlik          toplam 170 · 1-24'ten 100
 *   Dr. Öğr. Üyesi     toplam 100 · 1-24'ten  60
 *
 * PROFESÖRLÜĞÜN DÖRDÜNCÜ KATMANI 1(a) MADDESİYLE ÖRTÜŞÜYOR: "Doçentlik
 * unvanını aldıktan sonra doçentlik kadro başvurusu için gerekli puanı en az
 * bir kez daha sağlamış olmak" ile tablonun ⁴ dipnotu ("doçent unvanını
 * aldıktan sonraki dönemde 1-24. maddelerden 100 puan") aynı şeyi söylüyor.
 * İkisi de yazıldı: doçentlik sonrası toplam 170 ve doçentlik sonrası
 * 1-24'ten 100.
 *
 * KADRO ADLARI 2016'NIN ADLARI. Yönerge "Yardımcı Doçentlik" diyor; 2018'deki
 * unvan değişikliğinden sonra bu kadro Doktor Öğretim Üyeliği oldu ve öyle
 * eşlendi.
 *
 * YABANCI DİL YALNIZ DR. ÖĞR. ÜYELİĞİNDE: YDS'den en az 60, yabancı dil
 * kadroları için 80. Kadro ayrımı profilde olmadığı için 60 yazıldı ve 80
 * aday notunda uyarı olarak duruyor. Doçentlik ve profesörlükte yönerge dil
 * koşulu koymuyor.
 *
 * YENİDEN ATANMA GİRİLMEDİ: "Yardımcı Doçentliğe yeniden atanmalarda bir
 * önceki atanma döneminden sonra 1-24. maddeler arasından en az 50 puan"
 * (her atama üç yıllık, MADDE 5/3); önceki atama tarihi profilde yok.
 * MADDE 5/6'nın askerlik ve sağlık nedeniyle oranlama kuralı da aynı sebeple.
 *
 * MESLEK YÜKSEKOKULU İSTİSNASI (MADDE 5/5): "Önlisans eğitimi verilen Meslek
 * Yüksekokullarına alınacak öğretim üyeleri atamalarında bu değerlendirme
 * kriterleri uygulanmaz." Eşik yazıldı ama aday notunda söyleniyor; MYO
 * kadrosuna başvuran aday bu barajlara tabi değil.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: burdur-2016
 */

use App\Services\Scoring\Sart\Kalip;

$UNI = 'Burdur Mehmet Akif Ersoy Üniversitesi';
$CETVEL = 'burdur-2016';
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;

$tumAlanlar = ['fen', 'muhendislik', 'saglik', 'sosyal', 'egitim', 'hukuk', 'ilahiyat',
    'filoloji', 'guzel_sanatlar', 'mimarlik', 'spor', 'ziraat'];

$ikiKatman = 'Burdur MAKÜ\'nün barajı İKİ KATMANLI: toplam puanın yanında yayın ve etkinlik '
    .'kalemleri için ayrı bir eşik var. Bu ikinci küme makale, bildiri, kitap, çeviri, editörlük, atıf ve '
    .'sanatsal etkinliklerden oluşuyor; ders, tez, proje, ödül, idari görev, toplumsal katkı ve '
    .'sportif faaliyetler yalnız toplam puana giriyor.';

$myoNotu = 'Önlisans eğitimi verilen Meslek Yüksekokullarına yapılacak öğretim üyesi '
    .'atamalarında bu değerlendirme kriterleri UYGULANMIYOR.';

$tekAlanNotu = 'Yönergenin taban puan tablosu alan ayrımı yapmıyor: tek satırda "Sağlık '
    .'Bilimleri, Fen Bilimleri, Sosyal Bilimler" diyor ve yönerge güzel sanatlar bölümlerini de '
    .'kapsama alıyor. Bütün temel alanlar aynı barajlara tabi.';

$yenidenAtanma = 'Doktor öğretim üyeliğine yeniden atanma eşiği girilmedi: koşul "bir önceki '
    .'atanma döneminden sonra makale, bildiri, kitap, atıf ve sanatsal etkinlik '
    .'kalemlerinden en az 50 puan" biçiminde ve her atama üç '
    .'yıllık; önceki atama tarihi burada tutulmuyor.';

$dilNotu = 'Yabancı dil barajı YDS\'den 60; YABANCI DİL KADROLARI için 80. Kadro ayrımı burada '
    .'kurulamadığı için 60 gösteriliyor.';

return [
    // ══════════════ DOKTOR ÖĞRETİM ÜYESİ (2016 metninde "Yardımcı Doçentlik") ══════════════
    [
        'anahtar' => 'burdur-dr',
        'aday_notu' => $ikiKatman.' '.$tekAlanNotu.' '.$dilNotu.' '.$yenidenAtanma.' '.$myoNotu,
        'universite' => $UNI,
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $tumAlanlar,
        'cetvel' => $CETVEL,
        'notlar' => 'Taban puan tablosu: toplam 100 puan, bunun 60\'ı 1-24. maddelerden. '
            .'Yabancı dil YDS 60 (yabancı dil kadrolarında 80). Yönergenin kendi adlandırması '
            .'"Yardımcı Doçentlik"; 2018 sonrası Doktor Öğretim Üyeliği.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi', [
            Kalip::toplam(100),
            Kalip::puanDan('Makale, bildiri, kitap, editörlük, atıf ve sanatsal etkinlik '
                .'kalemlerinizden en az 60 puan', ['M1-24'], 60, madde: 'Atama Koşulları 3/a'),
            Kalip::yds(60),
        ]),
    ],

    // ══════════════════════════════ DOÇENT ══════════════════════════════
    [
        'anahtar' => 'burdur-docentlik',
        'aday_notu' => $ikiKatman.' '.$tekAlanNotu.' Doçentlik ve profesörlükte yönerge yabancı '
            .'dil koşulu koymuyor. '.$myoNotu,
        'universite' => $UNI,
        'kadro' => 'docentlik',
        'alan' => $tumAlanlar,
        'cetvel' => $CETVEL,
        'notlar' => 'Taban puan tablosu: toplam 170 puan, bunun 100\'ü 1-24. maddelerden. '
            .'Ayrıca ÜAK doçentlik belgesi.',
        'sart' => Kalip::ve('Doçent', [
            Kalip::toplam(170),
            Kalip::puanDan('Makale, bildiri, kitap, editörlük, atıf ve sanatsal etkinlik '
                .'kalemlerinizden en az 100 puan', ['M1-24'], 100, madde: 'Atama Koşulları 2/a'),
            Kalip::beyan('Üniversitelerarası Kurul tarafından verilen doçentlik belgesine sahip '
                .'olmak', 'Atama Koşulları 2/b'),
        ]),
    ],

    // ══════════════════════════════ PROFESÖR ══════════════════════════════
    [
        'anahtar' => 'burdur-profesorluk',
        'aday_notu' => $ikiKatman.' Profesörlükte üçüncü bir katman daha var: doçentlik '
            .'kadrosu için gereken puanı doçentlik unvanınızı aldıktan SONRA bir kez daha '
            .'sağlamış olmanız isteniyor (Atama Koşulları 1/a). '.$tekAlanNotu.' '.$myoNotu,
        'universite' => $UNI,
        'kadro' => 'profesorluk',
        'alan' => $tumAlanlar,
        'cetvel' => $CETVEL,
        'notlar' => 'Taban puan tablosu: toplam 340 puan, bunun 200\'ü 1-24. maddelerden; '
            .'doçentlik sonrası dönemde 1-24. maddelerden 100 puan. Atama Koşulları 1/a ayrıca '
            .'doçentlik kadro başvurusu puanının (toplam 170) doçentlik sonrası yeniden '
            .'sağlanmasını istiyor.',
        'sart' => Kalip::ve('Profesör', [
            Kalip::toplam(340),
            Kalip::puanDan('Makale, bildiri, kitap, editörlük, atıf ve sanatsal etkinlik '
                .'kalemlerinizden en az 200 puan', ['M1-24'], 200, madde: 'Taban puan tablosu'),
            Kalip::toplam(170, $DOCENTLIK),
            Kalip::puanDan('Doçentliğinizden sonra makale, bildiri, kitap, editörlük, atıf ve '
                .'sanatsal etkinlik kalemlerinizden en az 100 puan', ['M1-24'], 100, $DOCENTLIK,
                madde: 'Taban puan tablosu dipnot 4'),
        ]),
    ],
];
