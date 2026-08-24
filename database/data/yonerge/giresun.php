<?php

/**
 * GİRESUN ÜNİVERSİTESİ — Öğretim Üyeliği Kadrolarına Yükseltilme ve Atanma
 * Yönergesi (2019; Yükseköğretim Genel Kurulunun 30.01.2025 kararıyla
 * değiştirilmiş hâliyle)
 * Kaynak: pdf/17536996152.giresununiverstesi.pdf
 *
 * TEMEL ALAN AYRIMI YOK. Giresun bütün alanlardan aynı puanı istiyor; alan
 * yalnızca "profesörlük başlıca eseri"nin tanımında ayrışıyor (Güzel Sanatlar
 * adayları makale/kitap yerine sanatsal etkinlik veya ödül gösterebiliyor).
 *
 * ÜÇ KADRONUN ALT BARAJ KÜMESİ FARKLI — yönergenin sessiz ayrıntısı:
 *   Profesör  "A, B, C, D, E, F, G, H ve K"      → editörlük SAYILMIYOR
 *   Doçent    "A, B, C, D, E, F, G, H, I ve K"   → uluslararası editörlük sayılıyor
 *   Dr.       "A, B, C, D, E, F, G, H, I ve K"
 * Aynı adayın uluslararası dergi editörlüğü doçentlikte alt baraja girerken
 * profesörlükte girmiyor; iki eşik ayrı gruplar üzerinden hesaplanıyor.
 *
 * PROFESÖRLÜKTE ÜÇ KATMANLI PUAN: toplam 350 (bilimsel + eğitim-öğretim),
 * bunun en az 250'si bilimsel araştırma ve yayından, ayrıca doçentlik sonrası
 * bilimsel araştırma ve yayından en az 200. Üçüncü katman doçentlik tarihine
 * bağlı bir pencere açıyor.
 *
 * DOÇENTLİKTE PENCERE DOKTORA SONRASI: 250 puanın en az 150'si doktora veya
 * tıpta uzmanlık unvanından SONRAKİ çalışmalardan gelmeli.
 *
 * PROFESÖRLÜK BAŞLICA ESERİ BEYAN: yönerge "A.1 veya A.2 sınıflı, adayın
 * birinci veya sorumlu yazar olduğu bir makale ya da yürütücülüğünü üstlendiği
 * bir araştırmadan üretilmiş makale ya da C.1 veya F.1 sınıflı bir kitap"
 * diyor. "Yürütücülüğünü üstlendiği araştırmadan üretilmiş" niteliği faaliyet
 * kaydından türetilemediği için koşul, sağlanabilir olan yazarlık kısmıyla
 * düğüm hâlinde, geri kalanıyla aday notunda duruyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/giresun-2019.php
 */

use App\Services\Scoring\Sart\Kalip;

$DR = Kalip::DOKTORA_SONRASI;
$DOC = Kalip::DOCENTLIK_SONRASI;

/** Giresun alan ayrımı yapmıyor; cetveldeki bütün temel alanlar. */
$tumAlanlar = ['fen', 'muhendislik', 'mimarlik', 'saglik', 'spor', 'hukuk', 'ilahiyat',
    'filoloji', 'sosyal', 'egitim', 'guzel_sanatlar', 'ziraat'];

return [
    // ══════════ DR. ÖĞRETİM ÜYESİ (Madde 12/3) ══════════
    [
        'anahtar' => 'giresun-dr',
        'aday_notu' => 'Giresun Dr. Öğr. Üyeliğinde temel alan ayrımı yapmıyor ve toplam puan '
            .'değil yalnızca bilimsel araştırma-yayın barajı arıyor. Eğitim-öğretim '
            .'faaliyetleriniz (L bölümü) bu baraja SAYILMAZ.',
        'universite' => 'Giresun Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $tumAlanlar,
        'cetvel' => 'giresun-2019',
        'notlar' => 'Madde 12/3-b: EK-1\'in A, B, C, D, E, F, G, H, I ve K bölümlerinden en az '
            .'80 puan; Madde 12/3-a: en az 1 makale veya kitap olarak yayımlanmış tez.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Giresun Üniversitesi', [
            Kalip::puanDan('Makale, bildiri, kitap, atıf, editörlük ve proje kalemlerinizden en az 80 puan',
                ['A-K (doçent)'], 80, madde: 'Madde 12/3-b'),
            Kalip::adet('Ulusal veya uluslararası hakemli dergide en az 1 makale ya da kitap '
                .'olarak yayımlanmış tez', ['MAKALE', 'C.1', 'F.1'], 1, madde: 'Madde 12/3-a'),
        ]),
    ],

    // ══════════ DOÇENT (Madde 12/2) ══════════
    [
        'anahtar' => 'giresun-docent',
        'aday_notu' => 'Toplam 250 puanın en az 150\'si DOKTORA veya tıpta uzmanlık unvanınızı '
            .'aldıktan sonraki bilimsel araştırma ve yayınlarınızdan gelmeli. Tıp Fakültesinde '
            .'yan dal uzmanlığı veya uzmanlık sonrası doktora çalışmaları da uzmanlık sonrası '
            .'sayılıyor.',
        'universite' => 'Giresun Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $tumAlanlar,
        'cetvel' => 'giresun-2019',
        'notlar' => 'Madde 12/2-b: bilimsel araştırma, yayın ve eğitim-öğretimden toplam 250 '
            .'puan; bunun en az 150\'si doktora sonrası A-H, I ve K bölümlerinden. Madde 12/2-c: '
            .'merkezî yabancı dil sınavından en az 55.',
        'sart' => Kalip::ve('Doçent — Giresun Üniversitesi', [
            Kalip::yds(55),
            Kalip::toplam(250, maddeler: ['A-L'], liste: 'Bilimsel araştırma, yayın ve eğitim-öğretim'),
            Kalip::puanDan('Doktoranızdan sonraki makale, bildiri, kitap, atıf, editörlük ve '
                .'proje kalemlerinizden en az 150 puan', ['A-K (doçent)'], 150, $DR, madde: 'Madde 12/2-b'),
            Kalip::beyan('Üniversitelerarası Kurul Başkanlığı tarafından verilen, başvurduğunuz '
                .'alanla ilgili doçentlik unvanını almış olmak', 'Madde 12/2-a'),
        ]),
    ],

    // ══════════ PROFESÖR (Madde 12/1) ══════════
    [
        'anahtar' => 'giresun-profesor',
        'aday_notu' => 'Üç katmanlı bir puan yapısı var: genel toplam 350, bunun 250\'si '
            .'bilimsel araştırma ve yayından, ayrıca doçentlik sonrası bilimsel araştırma ve '
            .'yayından 200. DİKKAT: dergi editörlüğünüz (I ve J bölümleri) profesörlük alt '
            .'barajına SAYILMIYOR — doçentlikte sayılıyordu. Başlıca araştırma eseri olarak '
            .'gösterdiğiniz çalışmada birinci veya sorumlu yazar olmanız gerekiyor; '
            .'yürütücülüğünü üstlendiğiniz bir araştırmadan üretilmiş makale de kabul ediliyor, '
            .'ama bu nitelik burada hesaplanamıyor.',
        'universite' => 'Giresun Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $tumAlanlar,
        'cetvel' => 'giresun-2019',
        'notlar' => 'Madde 12/1-c: bilimsel araştırma, yayın ve eğitim-öğretimden toplam 350 '
            .'puan; en az 250\'si A, B, C, D, E, F, G, H ve K bölümlerinden; doçentlik sonrası '
            .'aynı bölümlerden en az 200.',
        'sart' => Kalip::ve('Profesör — Giresun Üniversitesi', [
            Kalip::toplam(350, maddeler: ['A-L'], liste: 'Bilimsel araştırma, yayın ve eğitim-öğretim'),
            Kalip::puanDan('Makale, bildiri, kitap, atıf ve proje kalemlerinizden en az 250 puan',
                ['A-K (profesör)'], 250, madde: 'Madde 12/1-c'),
            Kalip::puanDan('Doçentliğinizden sonraki makale, bildiri, kitap, atıf ve proje '
                .'kalemlerinizden en az 200 puan', ['A-K (profesör)'], 200, $DOC, madde: 'Madde 12/1-c'),
            Kalip::adet('Doçentliğinizden sonra birinci veya sorumlu yazar olduğunuz, başlıca '
                .'araştırma eseri olarak sunacağınız en az 1 makale ya da kitap',
                ['BASLICA_ESER'], 1, 'baslica', $DOC, madde: 'Madde 4/ç'),
            Kalip::beyan('Doçentlik unvanını aldıktan sonra açık bulunan profesörlük kadrosuyla '
                .'ilgili bilim alanında çalışmış olmak', 'Madde 12/1-a'),
        ]),
    ],
];
