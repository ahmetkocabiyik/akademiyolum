<?php

/**
 * SİVAS BİLİM VE TEKNOLOJİ ÜNİVERSİTESİ — Öğretim Üyesi Kadrolarına
 * Yükseltilme ve Atanma Yönergesi
 * Kaynak: pdf/17537008372.sivasbilimveteknolojiuniverstesi.pdf
 * (10 sayfa; YÖK onayıyla 24/03/2021'de yürürlüğe girdi.)
 *
 * ── TEK TABLO, ÜÇ FAKÜLTE ──
 * Ek-1'deki Tablo 1 "Mühendislik ve Doğa Bilimleri, Havacılık ve Uzay
 * Bilimleri ve Tarım Bilimleri ve Teknolojileri Fakültelerinin bölümleri
 * ve Meslek Yüksekokulu programları" için yazılmış. Eşikler bu üç
 * fakültenin karşılığı olan Fen Bilimleri ve Matematik, Mühendislik ile
 * Ziraat, Orman ve Su Ürünleri temel alanlarına bağlandı; yönergenin
 * başka temel alan için tablosu yok.
 *
 * ── YENİDEN ATANMA ──
 * Madde 7(1): her üç yıllık atanma döneminde Tablo 1'in asgari ek
 * koşulları sağlanarak tüm faaliyetlerden en az 200 puan alınması ve bu
 * puanların bir önceki atanma tarihinden sonraki çalışmalardan gelmesi
 * gerekiyor. Tablo 1'in doktor öğretim üyesi sütunundaki proje koşulu
 * (100 puan ve en az bir projede yürütücülük) dipnotta "Dr. Öğr.
 * Üyeliği'ne İLK ATAMADA aranmaz" dendiği için yalnız yeniden atanma
 * eşiğine yazıldı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde 6(1)(c): lisans ya da doktora öğrenimini %100 İngilizce yapan
 *       üniversitede tamamlayanlardan dil puanı aranmaması — profil
 *       öğrenim dilini tutmuyor, 70 puanlık dil şartı herkese uygulandı.
 *   Madde 6(1)(e): öğretim üyesi bulmakta güçlük çekilen alanlarda
 *       Üniversite Yönetim Kurulu kararıyla ek koşulsuz atama yapılması.
 *   Madde 5(2): asgari koşulları sağlamanın atanmayı garanti etmemesi.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/sbtu-2021.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Sivas Bilim ve Teknoloji Üniversitesi';
$ALANLAR = ['fen', 'muhendislik', 'ziraat'];
$CETVEL = 'sbtu-2021';
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;

$NOT_ALAN = 'Bu koşullar yönergenin puan tablosundan; tablo Mühendislik ve Doğa Bilimleri, '
    .'Havacılık ve Uzay Bilimleri ile Tarım Bilimleri ve Teknolojileri fakültelerinin bölümleri '
    .'ve Meslek Yüksekokulu programları için yazılmış.';
$NOT_DIL = ' Yabancı dil (İngilizce) puanının en az 70 olması gerekiyor; lisans ya da doktora '
    .'öğreniminizin tamamını %100 İngilizce eğitim veren bir üniversitede yaptıysanız bu şart '
    .'aranmıyor.';
$NOT_DERS = ' Verdiğiniz dersler puana HİÇ katılmıyor: yönerge ders saati başına puan veriyor, '
    .'kayıt ders başına tutuluyor. Bu bölümden en fazla 40 puan alınabiliyordu.';

$dil = Kalip::yds(70);

$esikler = [];

$esikler[] = [
    'anahtar' => 'sbtu-dr',
    'aday_notu' => 'Doktor öğretim üyesi kadrosuna İLK ATANMA koşulları. '.$NOT_ALAN
        .' Proje koşulu (100 puan ve en az bir projede yürütücülük) tablonun dipnotu uyarınca '
        .'ilk atamada aranmıyor.'.$NOT_DIL.$NOT_DERS,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => $ALANLAR,
    'cetvel' => $CETVEL,
    'notlar' => 'Ek-1 Tablo 1 Dr. Öğr. Üyesi sütunu: A1.1-A1.6\'dan en az 2 makale (en az 1\'i '
        .'A1.1), asgari toplam 200 puan. A4 proje koşulu ilk atamada aranmaz (dipnot).',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna ilk atanma', [
        $dil,
        Kalip::adet(
            'Uluslararası hakemli dergilerde en az 2 makale yayımlamış olmak',
            ['A1-A16'], 2, madde: 'Tablo 1/A1',
        ),
        Kalip::adet(
            'Bu makalelerden en az 1 tanesinin SCI-Expanded kapsamındaki bir dergide yayımlanmış olması',
            ['A1.1-SCI'], 1, madde: 'Tablo 1/A1',
        ),
        Kalip::toplam(200),
    ]),
];

$esikler[] = [
    'anahtar' => 'sbtu-dr-yeniden',
    'aday_notu' => 'Doktor öğretim üyesi kadrosunda GÖREV SÜRESİNİN UZATILMASI koşulları. '
        .$NOT_ALAN.' Atanma dönemleri üçer yıllık; puanların tamamı bir önceki atanma '
        .'tarihinizden sonraki çalışmalardan gelmeli.'.$NOT_DERS,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => $ALANLAR,
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 7(1) + Ek-1 Tablo 1 Dr. Öğr. Üyesi sütunu: A1.1-A1.6\'dan en az 2 makale '
        .'(en az 1\'i A1.1), A4\'ten en az 100 puan ve en az bir A4.1-A4.7 projesinde '
        .'yürütücülük, asgari toplam 200 puan; hepsi son atanmadan sonra.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosunda görev süresinin uzatılması', [
        Kalip::adet(
            'Son atanma tarihinizden sonra uluslararası hakemli dergilerde en az 2 makale '
            .'yayımlamış olmak',
            ['A1-A16'], 2, donem: $SON_ATAMA, madde: 'Tablo 1/A1',
        ),
        Kalip::adet(
            'Bu makalelerden en az 1 tanesinin SCI-Expanded kapsamındaki bir dergide yayımlanmış olması',
            ['A1.1-SCI'], 1, donem: $SON_ATAMA, madde: 'Tablo 1/A1',
        ),
        Kalip::puanDan(
            'Son atanma tarihinizden sonra araştırma projelerinden en az 100 puan almış olmak',
            ['A4'], 100, $SON_ATAMA, madde: 'Tablo 1/A4',
        ),
        Kalip::adet(
            'Tamamlanmış ya da devam eden en az bir uluslararası veya TÜBİTAK/kamu destekli '
            .'projede yürütücü olmak',
            ['A4-YURUTUCU'], 1, donem: $SON_ATAMA, madde: 'Tablo 1/A4',
        ),
        Kalip::toplam(200, $SON_ATAMA),
    ]),
];

$esikler[] = [
    'anahtar' => 'sbtu-docentlik',
    'aday_notu' => 'Doçent kadrosuna atanma koşulları. '.$NOT_ALAN
        .' Ayrıca doçentlik sözlü sınavından başarılı olmanız gerekiyor. Kongre '
        .'faaliyetlerinden en fazla 100 puan sayılıyor, atıflardan en fazla 100 puan '
        .'sayılıyor.'.$NOT_DIL.$NOT_DERS,
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => $ALANLAR,
    'cetvel' => $CETVEL,
    'notlar' => 'Ek-1 Tablo 1 Doçent sütunu: A1.1-A1.6\'dan en az 5 makale (en az 4\'ü A1.1), '
        .'A4\'ten 150 puan + bir projede yürütücülük, A1+A2\'den 250 puan, A3\'ten 50 puan, '
        .'A5\'ten 10 puan, B ve C gruplarından 40 puan, asgari toplam 500 puan.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma', [
        $dil,
        Kalip::beyan('Doçentlik sözlü sınavından başarılı olmak', '6-1-ç'),
        Kalip::adet(
            'Uluslararası hakemli dergilerde en az 5 makale yayımlamış olmak',
            ['A1-A16'], 5, madde: 'Tablo 1/A1',
        ),
        Kalip::adet(
            'Bu makalelerden en az 4 tanesinin SCI-Expanded kapsamındaki dergilerde yayımlanmış olması',
            ['A1.1-SCI'], 4, madde: 'Tablo 1/A1',
        ),
        Kalip::puanDan(
            'Araştırma projelerinden en az 150 puan almış olmak',
            ['A4'], 150, madde: 'Tablo 1/A4',
        ),
        Kalip::adet(
            'Tamamlanmış ya da devam eden en az bir uluslararası veya TÜBİTAK/kamu destekli '
            .'projede yürütücü olmak',
            ['A4-YURUTUCU'], 1, madde: 'Tablo 1/A4',
        ),
        Kalip::puanDan(
            'Makale ve kitap faaliyetlerinden en az 250 puan almış olmak',
            ['A1-A2'], 250, madde: 'Tablo 1/A1-A2',
        ),
        Kalip::puanDan(
            'Kongre faaliyetlerinden en az 50 puan almış olmak',
            ['A3'], 50, madde: 'Tablo 1/A3',
        ),
        Kalip::puanDan('Atıflardan en az 10 puan almış olmak', ['A5'], 10, madde: 'Tablo 1/A5'),
        Kalip::puanDan(
            'Eğitim etkinlikleri, patentler, mesleki etkinlikler, üyelik-hakemlik ve ödüllerden '
            .'en az 40 puan almış olmak',
            ['BC'], 40, madde: 'Tablo 1/B-C',
        ),
        Kalip::toplam(500),
    ]),
];

$esikler[] = [
    'anahtar' => 'sbtu-profesorluk',
    'aday_notu' => 'Profesör kadrosuna yükseltilerek atanma koşulları. '.$NOT_ALAN
        .' Sunacağınız Başlıca Araştırma Eserinin doçent unvanını aldıktan sonra yapılmış olması '
        .'gerekiyor. Kongre faaliyetlerinden en fazla 150 puan, atıflardan en fazla 100 puan '
        .'sayılıyor.'.$NOT_DIL.$NOT_DERS,
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => $ALANLAR,
    'cetvel' => 'sbtu-2021-prof',
    'notlar' => 'Ek-1 Tablo 1 Profesör sütunu: A1.1-A1.6\'dan en az 10 makale (en az 8\'i A1.1 '
        .'ve bunların en az 3\'ü doçentlik sonrası A1.1), A4\'ten 200 puan + bir projede '
        .'yürütücülük, A1+A2\'den 450 puan, A3\'ten 100 puan, A5\'ten 20 puan, B ve C '
        .'gruplarından 80 puan, asgari toplam 1000 puan.',
    'sart' => Kalip::ve('Profesör kadrosuna yükseltilerek atanma', [
        $dil,
        Kalip::beyan(
            'Başlıca Araştırma Eseri olarak sunacağınız eserin doçent unvanını aldıktan sonra '
            .'yapılmış olması',
            '6-1-d',
        ),
        Kalip::adet(
            'Uluslararası hakemli dergilerde en az 10 makale yayımlamış olmak',
            ['A1-A16'], 10, madde: 'Tablo 1/A1',
        ),
        Kalip::adet(
            'Bu makalelerden en az 8 tanesinin SCI-Expanded kapsamındaki dergilerde yayımlanmış olması',
            ['A1.1-SCI'], 8, madde: 'Tablo 1/A1',
        ),
        Kalip::adet(
            'Doçent unvanını aldıktan sonra SCI-Expanded kapsamındaki dergilerde en az 3 makale '
            .'yayımlamış olmak',
            ['A1.1-SCI'], 3, donem: $DOCENTLIK, madde: 'Tablo 1/A1',
        ),
        Kalip::puanDan(
            'Araştırma projelerinden en az 200 puan almış olmak',
            ['A4'], 200, madde: 'Tablo 1/A4',
        ),
        Kalip::adet(
            'Tamamlanmış ya da devam eden en az bir uluslararası veya TÜBİTAK/kamu destekli '
            .'projede yürütücü olmak',
            ['A4-YURUTUCU'], 1, madde: 'Tablo 1/A4',
        ),
        Kalip::puanDan(
            'Makale ve kitap faaliyetlerinden en az 450 puan almış olmak',
            ['A1-A2'], 450, madde: 'Tablo 1/A1-A2',
        ),
        Kalip::puanDan(
            'Kongre faaliyetlerinden en az 100 puan almış olmak',
            ['A3'], 100, madde: 'Tablo 1/A3',
        ),
        Kalip::puanDan('Atıflardan en az 20 puan almış olmak', ['A5'], 20, madde: 'Tablo 1/A5'),
        Kalip::puanDan(
            'Eğitim etkinlikleri, patentler, mesleki etkinlikler, üyelik-hakemlik ve ödüllerden '
            .'en az 80 puan almış olmak',
            ['BC'], 80, madde: 'Tablo 1/B-C',
        ),
        Kalip::toplam(1000),
    ]),
];

return $esikler;
