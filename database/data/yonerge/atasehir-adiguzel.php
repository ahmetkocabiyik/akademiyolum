<?php

/**
 * ATAŞEHİR ADIGÜZEL MESLEK YÜKSEKOKULU — Akademik Yükseltilme ve Atanma
 * Kriterleri Yönergesi
 * Kaynak: pdf/17537096622.atasehiradiguzelmeslekyuksekokulu.pdf
 * Cetvel: cetvel/atasehir-adiguzel-2018.php
 *
 * ── TEMEL ALAN AYRIMI YOK ──
 * Yönerge bütün bilim alanlarına aynı puan barajlarını uyguluyor; eşikler
 * on iki temel alanın hepsine yazıldı.
 *
 * ── YENİDEN ATAMADA "HER YIL İÇİN 70 PUAN" ──
 * MADDE 3(1)/b yeniden atanma için "Akademik Etkinlik Değerlendirmesinden
 * HER YIL İÇİN toplam en az 70 puan" istiyor. Kayıt atama süresini
 * taşımadığı için eşiğe BİR YILLIK değer (70) yazıldı ve çarpma kuralı
 * aday notuna kondu. İki yıllık bir görev süresi için gerçek baraj 140,
 * üç yıllık için 210; koşul burada olduğundan HAFİF görünür.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 6(3): "öğretim üyesi istihdamında güçlük çekilen programlarda
 *       koşulların bir kısmı aranmayabilir" muafiyeti — koşulu
 *       hafifletir, §0 uyarınca girilmedi.
 *   MADDE 6(2): kriterleri sağlamanın yeterlilik anlamına gelmemesi;
 *       MADDE 6(4)-(5): komisyon incelemesi ve jüri değerlendirmesi —
 *       süreç hükümleri.
 *   MADDE 6(6): yalnız adayın alanıyla ilgili etkinliklerin sayılması —
 *       kayıt çalışmanın alanını taşımıyor.
 *   MADDE 6(7)'nin profesörlük başlıca eseri için saydığı beş seçenek —
 *       beyan koşulu olarak tek maddede toplandı.
 *   Yeniden atanmada "Öğretim Elemanı Değerlendirme Anketi sonuçlarına
 *       göre başarılı olmak" — beyan.
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Ataşehir Adıgüzel Meslek Yüksekokulu';
$CETVEL = 'atasehir-adiguzel-2018';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$TUM_ALANLAR = ['fen', 'saglik', 'muhendislik', 'sosyal', 'egitim', 'spor', 'filoloji',
    'hukuk', 'ilahiyat', 'mimarlik', 'guzel_sanatlar', 'ziraat'];

$NOT_ORTAK = ' Yönerge bütün temel alanlara aynı barajları uyguluyor; alan ayrımı yok. '
    .'Tabloda tez izleme ve jüri üyeliği, idari görev ve topluma katkı satırı bulunmadığı için '
    .'bu kayıtlarınız toplam puanınıza katkı vermiyor. Ortak çalışmalarda puan yönergenin '
    .'yazar sayısı × sıra matrisine göre bölünüyor; sorumlu yazar birinci isim sayılıyor.';

return [
    [
        'anahtar' => 'atasehir-adiguzel-dr',
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $TUM_ALANLAR,
        'cetvel' => $CETVEL,
        'notlar' => 'MADDE 3(1)/a: ulusal ya da uluslararası hakemli bir dergide en az bir '
            .'bilimsel makale ve Akademik Etkinlik Değerlendirmesinden en az 150 puan.',
        'aday_notu' => 'Doktor öğretim üyesi kadrosuna İLK ATANMA. İki koşul var: ulusal ya da '
            .'uluslararası hakemli bir dergide bilimsel makale niteliğinde en az bir yayınınız '
            .'olması ve Akademik Etkinlik Değerlendirme Tablosundan en az 150 puan almanız. '
            .'Yönerge ilk atamada dönem sınırı koymuyor, bütün akademik geçmişiniz sayılıyor.'
            .$NOT_ORTAK,
        'sart' => Kalip::ve('Doktor öğretim üyesi kadrosuna ilk atanma', [
            Kalip::adet('Ulusal ya da uluslararası hakemli bir dergide bilimsel makale niteliğinde en az bir yayın yapmış olmak', ['HAKEMLI-MAKALE'], 1, madde: 'MADDE 3/a'),
            Kalip::toplam(150),
        ]),
    ],
    [
        'anahtar' => 'atasehir-adiguzel-dr-yeniden',
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $TUM_ALANLAR,
        'cetvel' => $CETVEL,
        'notlar' => 'MADDE 3(1)/b: tamamlanan atanma dönemi içinde her yıl için en az 70 puan '
            .'ve Öğretim Elemanı Değerlendirme Anketinde başarılı olmak. Eşiğe bir yıllık '
            .'değer yazıldı.',
        'aday_notu' => 'Doktor öğretim üyesi kadrosuna YENİDEN ATANMA. Yalnız tamamlanan atanma '
            .'dönemi içindeki etkinlikleriniz sayılıyor. Yönerge "HER YIL İÇİN en az 70 puan" '
            .'diyor; görev süreniz kayıtta taşınmadığı için eşiğe bir yıllık değer yazıldı. '
            .'Görev süreniz iki yılsa gerçek baraj 140, üç yılsa 210 puan; koşul burada '
            .'olduğundan hafif görünüyor, kendi sürenizle çarpmalısınız.'.$NOT_ORTAK,
        'sart' => Kalip::ve('Doktor öğretim üyesi kadrosuna yeniden atanma', [
            Kalip::toplam(70, $SON_ATAMA),
            Kalip::beyan('Öğretim Elemanı Değerlendirme Anketi sonuçlarına göre başarılı olmak', 'MADDE 3/b'),
        ]),
    ],
    [
        'anahtar' => 'atasehir-adiguzel-docentlik',
        'universite' => $UNIVERSITE,
        'kadro' => 'docentlik',
        'alan' => $TUM_ALANLAR,
        'cetvel' => $CETVEL,
        'notlar' => 'MADDE 4: doktora sonrası 1-12 numaralı maddelerden en az 250 puan ve '
            .'toplam en az 500 puan.',
        'aday_notu' => 'Doçent kadrosuna atanma. İki baraj var: doktora derecenizi aldıktan '
            .'SONRA makale, sanat etkinliği, kongre sunumu, kitap yazarlığı ve çeviri '
            .'kalemlerinizden en az 250 puan ve bütün etkinliklerden '
            .'toplam en az 500 puan. Toplam puan barajında dönem sınırı yok.'.$NOT_ORTAK,
        'sart' => Kalip::ve('Doçent kadrosuna atanma', [
            Kalip::beyan('Üniversitelerarası Kurul tarafından verilen doçentlik unvanına sahip olmak', '2547 s.K. m.24'),
            Kalip::puanDan('Doktora derecenizi aldıktan sonra makale, sanat etkinliği, bildiri ve proje kalemlerinizden en az 250 puan almak', ['1-12'], 250, $DOKTORA, madde: 'MADDE 4/a'),
            Kalip::toplam(500),
        ]),
    ],
    [
        'anahtar' => 'atasehir-adiguzel-profesorluk',
        'universite' => $UNIVERSITE,
        'kadro' => 'profesorluk',
        'alan' => $TUM_ALANLAR,
        'cetvel' => $CETVEL,
        'notlar' => 'MADDE 5: profesörlük başlıca eseri, doçentlik sonrası 1-12 numaralı '
            .'maddelerden en az 350 puan ve toplam en az 700 puan.',
        'aday_notu' => 'Profesör kadrosuna atanma. Doçent unvanını aldıktan SONRA makale, '
            .'sanat etkinliği, kongre sunumu, kitap yazarlığı ve çeviri kalemlerinizden en az '
            .'350 puan ve bütün etkinliklerden toplam en az 700 '
            .'puan gerekiyor. Ayrıca profesörlük başlıca eseri göstermelisiniz; yönerge bunu '
            .'beş yoldan biriyle karşılamaya izin veriyor: uluslararası indeksli bir dergide tek '
            .'yazarlı ya da ilk isim olduğunuz makale, danışmanlığını yaptığınız lisansüstü '
            .'öğrencilerle birlikte yayımlanmış makale, yürütücüsü olduğunuz projeden üretilmiş '
            .'makale, kendi isminizle basılmış özgün bir kitap ya da sanat etkinliklerinden '
            .'birine katılmak.'.$NOT_ORTAK,
        'sart' => Kalip::ve('Profesör kadrosuna atanma', [
            Kalip::beyan('Üniversitelerarası Kurul tarafından verilen doçentlik unvanına sahip olmak', '2547 s.K. m.26'),
            Kalip::beyan('Doçent unvanını aldıktan sonra ilgili bilim alanında uygulamaya yönelik bir çalışma ya da uluslararası düzeyde araştırmaya dayalı özgün bir eseri profesörlük başlıca eseri olarak göstermek', 'MADDE 5/a'),
            Kalip::puanDan('Doçent unvanını aldıktan sonra makale, sanat etkinliği, bildiri ve proje kalemlerinizden en az 350 puan almak', ['1-12'], 350, $DOCENTLIK, madde: 'MADDE 5/b'),
            Kalip::toplam(700),
        ]),
    ],
];
