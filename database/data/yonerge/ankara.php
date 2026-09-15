<?php

/**
 * ANKARA ÜNİVERSİTESİ — Öğretim Üyeliği Kadrolarına Atama ve Yükseltme
 * Asgari Koşulları
 * Kaynak: pdf/17536929322.ankarauniversitesi.pdf (01.01.2023, KALICI)
 *
 * Yönerge koşulları KADRO SÜTUNLU BİR MATRİSTE veriyor; her alan bölümü için
 * Profesör / Doçent / Dr. Öğr. Üyesi / Dr. Öğr. Üyesi (Yeniden Atama)
 * sütunları yan yana duruyor. Yeniden atama kadrosu motorun kadro
 * sözlüğünde olmadığı için girilmedi.
 *
 * ÜÇ ALAN BÖLÜMÜ ve eşikleri:
 *
 *   FEN, MÜHENDİSLİK ve SAĞLIK   iki katmanlı baraj: önce dar makale kümesinden
 *                                zorunlu puan, sonra geniş kümeden toplam
 *   SOSYAL BİLİMLER              tek baraj, geniş küme (1A-1G)
 *   GÜZEL SANATLAR               tek baraj; makale + kitap + sanatsal etkinlik
 *
 * FEN bölümündeki iki katmanlılık ayırt edici: doçentlikte (1A-1B)'den en az
 * 190 VE (1A-1G)'den en az 230 isteniyor. İkisi ayrı düğüm.
 *
 * ALAN EŞLEMESİ ÜÇ BÖLÜMÜN ZORUNLU SONUCU. Yönerge Gazi'deki gibi bir
 * fakülte→grup tablosu vermiyor ama BÖLÜM SAYISI ÜÇ: on iki temel alanın her
 * biri bunlardan birine düşmek zorunda. Eğitim, filoloji, hukuk, ilahiyat ve
 * spor Sosyal Bilimler'e, ziraat Fen-Mühendislik-Sağlık'a bağlandı — Siirt
 * dosyasındaki fen-sosyal ayrımıyla aynı akıl yürütme. Belge bu okumayı iki
 * yerden doğruluyor:
 *
 *   IV/b, "Sosyal Bilimler alanından başvuru yapabilecek bölümler" listesinde
 *       SPOR BİLİMLERİ FAKÜLTESİ sayılıyor.
 *   I/ı, "HUKUK TEMEL ALANI için" ayrı bir monografi koşulu getiriyor; yani
 *       hukuk adayı başvurabiliyor ve Güzel Sanatlar ya da Fen bölümüne ait
 *       olamayacağına göre Sosyal Bilimler ölçütlerine tabi.
 *
 * MİMARLIK GİRİLMEDİ: Ankara Üniversitesi'nde mimarlık fakültesi yok, yönerge
 * de bu alandan hiç söz etmiyor. Eşik uydurmak yerine kapsam dışı bırakıldı.
 *
 * HUKUKUN EK KOŞULU (md. I/ı): tek yazarlı monografik bir çalışma; telafisi
 * Q1-Q2 dergilerde iki tek yazarlı özgün makale. Profesörlükte bu çalışmanın
 * doçentlik sonrası olması isteniyor. Monografi kaydı kitap kaleminden
 * ayrılamadığı için koşul telafi dalıyla birlikte yazıldı.
 *
 * SANATSAL ETKİNLİK bölümü girildi; Güzel Sanatlar barajı makale, kitap ve
 * sanatsal etkinlik puanlarının toplamından hesaplanıyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/ankara-2023.php
 */

use App\Services\Scoring\Sart\Kalip;

/**
 * "Lisans öğrenimini tamamladıktan sonra kesintisiz en az 3 ay yurtdışında
 * başvuru alanında eğitim ve araştırma" — Dr. Öğr. Üyesi koşulu.
 *
 * @return array<string, mixed>
 */
$yurtDisi = fn (): array => Kalip::metrik(
    'Lisans sonrası kesintisiz en az 3 ay yurt dışında eğitim/araştırma', 'yurtdisi_ay', 3,
);

/**
 * Profesör ve doçentte tekrarlayan başlıca yazarlık koşulu ve telafisi.
 *
 * Yönerge: "(1A-1B) makalelerinde adayın başlıca yazar olduğu en az 3 yayını
 * olmalıdır. (a) maddesindeki koşul sağlanamıyorsa; ikisinde başlıca yazar,
 * diğer ikisinde de sorumlu yazar olduğu en az dört ayrı makalesi olmalıdır."
 *
 * Motor "sorumlu yazar" rolünü ayrı tutmuyor; telafi dalı dört makalenin
 * ikisinde başlıca yazarlık olarak kuruldu — yönergeden DAR bir okuma, yani
 * adayı haksız yere geçirmez.
 *
 * @param  array<string, mixed>|null  $donem
 * @return array<string, mixed>
 */
$baslicaYazar = fn (?array $donem = null): array => Kalip::adet(
    'WoS dergilerde başlıca yazar olduğunuz en az 3 yayın', ['1A-1B'], 3, 'baslica', donem: $donem,
) + ['telafi' => Kalip::adet(
    'Ya da: en az 4 makale, ikisinde başlıca yazar', ['1A-1B'], 2, 'baslica', donem: $donem,
)];

/** Üç bölümün temel alan karşılıkları (bkz. dosya başı). */
$FEN = ['fen', 'muhendislik', 'saglik', 'ziraat'];
$SOSYAL = ['sosyal', 'egitim', 'filoloji', 'ilahiyat', 'spor'];

$SOSYAL_NOTU = ' Yönerge üç alan bölümü tanıyor: Fen-Mühendislik-Sağlık, Sosyal Bilimler ve '
    .'Güzel Sanatlar. Eğitim, filoloji, hukuk, ilahiyat ve spor bilimleri bu üçlü içinde '
    .'Sosyal Bilimler ölçütlerine tabi; yönerge spor bilimleri fakültesini bu kapsamda '
    .'açıkça sayıyor ve hukuk temel alanına ayrı bir ek koşul getiriyor.';

/**
 * Md. I/ı: Hukuk temel alanının monografi koşulu ve Q1-Q2 telafisi.
 *
 * Profesörlükte çalışmanın doçentlik unvanından sonra yayımlanmış olması
 * isteniyor; doçentlik ve dr. öğr. üyeliğinde dönem kısıtı yok.
 *
 * @param  array<string, mixed>|null  $donem
 * @return array<string, mixed>
 */
$hukukMonografi = fn (?array $donem = null): array => Kalip::adet(
    'Başvurduğunuz alanla ilgili tek yazarlı monografik bir çalışma', ['MONOGRAFI'], 1,
    'tek', donem: $donem, madde: 'Madde I/ı',
) + ['telafi' => Kalip::adet(
    'Ya da: Q1 veya Q2 dergilerde iki tek yazarlı özgün makale', ['1A-Q1-Q2'], 2,
    'tek', donem: $donem, madde: 'Madde I/ı',
)];

return [
    // ══════════════ FEN, MÜHENDİSLİK ve SAĞLIK BİLİMLERİ ══════════════
    [
        'anahtar' => 'ankara-dr-fen-muh-saglik',
        'aday_notu' => 'İki katmanlı baraj var: WoS ve Scopus dergilerindeki makalelerinizden en '
            .'az 50, tüm makale kalemlerinizden en az 90 puan.',
        'universite' => 'Ankara Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $FEN,
        'cetvel' => 'ankara-2023',
        'notlar' => 'FEN/MÜH/SAĞLIK, Dr. Öğr. Üyesi. Zorunlu puan (1A-1E) en az 50; bölümden toplam (1A-1G) en az 90. Ek koşul a) (1A-1B) makalelerinden en az 2, biri son iki yılda.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Fen / Mühendislik / Sağlık', [
            Kalip::adet('WoS dergilerde en az 2 makale', ['1A-1B'], 2, madde: 'Bölüm 1 · 1A-1B'),
            Kalip::beyan('Bu makalelerden en az biri son iki yılda yayımlanmış olmalı', 'Ek koşul a'),
            Kalip::puanDan('WoS ve Scopus dergilerindeki makalelerinizden en az 50 puan', ['1A-1E'], 50, madde: 'Bölüm 1 · 1A-1E'),
            Kalip::puanDan('WoS, Scopus, uluslararası indeksli ve TR-Dizin dergilerindeki makalelerinizden en az 90 puan', ['1A-1G'], 90, madde: 'Bölüm 1 · 1A-1G'),
            $yurtDisi(),
        ]),
    ],
    [
        'anahtar' => 'ankara-docent-fen-muh-saglik',
        'aday_notu' => 'Başlıca yazarlık koşulu telafili: üç yayında başlıca yazar olamıyorsanız, dördünün ikisinde başlıca yazar olmak yeterli.',
        'universite' => 'Ankara Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $FEN,
        'cetvel' => 'ankara-2023',
        'notlar' => 'FEN/MÜH/SAĞLIK, Doçent. Zorunlu puan (1A-1B) en az 190; bölümden toplam (1A-1G) en az 230. Ek koşul a) başlıca yazar olduğu en az 3 yayın.',
        'sart' => Kalip::ve('Doçent — Fen / Mühendislik / Sağlık', [
            $baslicaYazar(),
            Kalip::puanDan('WoS Q1-Q4 dergilerindeki makalelerinizden en az 190 puan', ['1A-1B'], 190, madde: 'Bölüm 1 · 1A-1B'),
            Kalip::puanDan('WoS, Scopus, uluslararası indeksli ve TR-Dizin dergilerindeki makalelerinizden en az 230 puan', ['1A-1G'], 230, madde: 'Bölüm 1 · 1A-1G'),
        ]),
    ],
    [
        'anahtar' => 'ankara-profesor-fen-muh-saglik',
        'aday_notu' => 'Zorunlu 300 puanın en az 190\'ı doçentlik unvanından sonra kazanılmış olmalı.',
        'universite' => 'Ankara Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $FEN,
        'cetvel' => 'ankara-2023',
        'notlar' => 'FEN/MÜH/SAĞLIK, Profesör. Zorunlu puan (1A-1C) en az 300, en az 190 puanı doçentlik unvanı sonrası (1A-1B). Bölümden toplam (1A-1G) en az 450.',
        'sart' => Kalip::ve('Profesör — Fen / Mühendislik / Sağlık', [
            $baslicaYazar(Kalip::DOCENTLIK_SONRASI),
            Kalip::puanDan('WoS Q1-Q4 dergilerindeki makalelerinizden en az 300 puan', ['1A-1C'], 300, madde: 'Bölüm 1 · 1A-1C'),
            Kalip::puanDan('Bunun en az 190 puanı doçentlik sonrası olmalı', ['1A-1B'], 190, Kalip::DOCENTLIK_SONRASI),
            Kalip::puanDan('WoS, Scopus, uluslararası indeksli ve TR-Dizin dergilerindeki makalelerinizden en az 450 puan', ['1A-1G'], 450, madde: 'Bölüm 1 · 1A-1G'),
        ]),
    ],

    // ══════════════════════ SOSYAL BİLİMLER ══════════════════════
    [
        'anahtar' => 'ankara-dr-sosyal',
        'aday_notu' => 'Sosyal Bilimlerde tek baraj var ve tüm makale kalemleri sayılıyor.',
        'universite' => 'Ankara Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $SOSYAL,
        'cetvel' => 'ankara-2023',
        'notlar' => 'SOSYAL BİLİMLER, Dr. Öğr. Üyesi. (1A-1G) faaliyetlerinden en az 100 puan.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Sosyal Bilimler', [
            Kalip::puanDan('WoS, Scopus, uluslararası indeksli ve TR-Dizin dergilerindeki makalelerinizden en az 100 puan', ['1A-1G'], 100, madde: 'Bölüm 1 · 1A-1G'),
            $yurtDisi(),
        ]),
    ],
    [
        'anahtar' => 'ankara-docent-sosyal',
        'universite' => 'Ankara Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $SOSYAL,
        'cetvel' => 'ankara-2023',
        'notlar' => 'SOSYAL BİLİMLER, Doçent. (1A-1G) faaliyetlerinden en az 250 puan.',
        'sart' => Kalip::ve('Doçent — Sosyal Bilimler', [
            Kalip::puanDan('WoS, Scopus, uluslararası indeksli ve TR-Dizin dergilerindeki makalelerinizden en az 250 puan', ['1A-1G'], 250, madde: 'Bölüm 1 · 1A-1G'),
        ]),
    ],
    [
        'anahtar' => 'ankara-profesor-sosyal',
        'aday_notu' => 'Zorunlu 370 puanın en az 210\'u doçentlik unvanından sonra kazanılmış olmalı.',
        'universite' => 'Ankara Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $SOSYAL,
        'cetvel' => 'ankara-2023',
        'notlar' => 'SOSYAL BİLİMLER, Profesör. (1A-1G) faaliyetlerinden en az 370 puan, en az 210 puanı doçentlik unvanı sonrası.',
        'sart' => Kalip::ve('Profesör — Sosyal Bilimler', [
            Kalip::puanDan('WoS, Scopus, uluslararası indeksli ve TR-Dizin dergilerindeki makalelerinizden en az 370 puan', ['1A-1G'], 370, madde: 'Bölüm 1 · 1A-1G'),
            Kalip::puanDan('Bunun en az 210 puanı doçentlik sonrası olmalı', ['1A-1G'], 210, Kalip::DOCENTLIK_SONRASI),
        ]),
    ],

    // ══════════════════════ HUKUK ══════════════════════
    // Sosyal Bilimler barajlarının aynısı + md. I/ı'nın monografi koşulu.
    [
        'anahtar' => 'ankara-dr-hukuk',
        'aday_notu' => 'Hukukta Sosyal Bilimler barajı geçerli ama yönerge BİR EK KOŞUL daha '
            .'koyuyor: alanınızla ilgili tek yazarlı monografik bir çalışma. Bunun yerine Q1 ya '
            .'da Q2 dergilerde iki tek yazarlı özgün makale de kabul ediliyor. Monografi olarak yalnız kitap '
            .'YAZARLIĞI sayılıyor; kitap bölümü ve çeviri bu koşulu karşılamıyor.'.$SOSYAL_NOTU,
        'universite' => 'Ankara Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['hukuk'],
        'cetvel' => 'ankara-2023',
        'notlar' => 'SOSYAL BİLİMLER, Dr. Öğr. Üyesi. (1A-1G) faaliyetlerinden en az 100 puan. '
            .'MADDE I/ı: hukuk temel alanı için tek yazarlı monografik çalışma; telafisi Q1-Q2 '
            .'dergilerde iki tek yazarlı özgün makale.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Hukuk', [
            Kalip::puanDan('WoS, Scopus, uluslararası indeksli ve TR-Dizin dergilerindeki makalelerinizden en az 100 puan', ['1A-1G'], 100, madde: 'Bölüm 1 · 1A-1G'),
            $hukukMonografi(),
            $yurtDisi(),
        ]),
    ],
    [
        'anahtar' => 'ankara-docent-hukuk',
        'aday_notu' => 'Hukukta Sosyal Bilimler barajı geçerli ama yönerge BİR EK KOŞUL daha '
            .'koyuyor: alanınızla ilgili tek yazarlı monografik bir çalışma. Bunun yerine Q1 ya '
            .'da Q2 dergilerde iki tek yazarlı özgün makale de kabul ediliyor.'.$SOSYAL_NOTU,
        'universite' => 'Ankara Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['hukuk'],
        'cetvel' => 'ankara-2023',
        'notlar' => 'SOSYAL BİLİMLER, Doçent. (1A-1G) faaliyetlerinden en az 250 puan. '
            .'MADDE I/ı: tek yazarlı monografik çalışma; telafisi Q1-Q2 dergilerde iki tek '
            .'yazarlı özgün makale.',
        'sart' => Kalip::ve('Doçent — Hukuk', [
            Kalip::puanDan('WoS, Scopus, uluslararası indeksli ve TR-Dizin dergilerindeki makalelerinizden en az 250 puan', ['1A-1G'], 250, madde: 'Bölüm 1 · 1A-1G'),
            $hukukMonografi(),
        ]),
    ],
    [
        'anahtar' => 'ankara-profesor-hukuk',
        'aday_notu' => 'Zorunlu 370 puanın en az 210\'u doçentlik unvanından sonra kazanılmış '
            .'olmalı. Hukukta bir EK KOŞUL daha var: alanınızla ilgili tek yazarlı monografik '
            .'bir çalışma ya da Q1-Q2 dergilerde iki tek yazarlı özgün makale. Profesörlükte '
            .'bu çalışmanın DOÇENTLİK SONRASI yayımlanmış olması gerekiyor.'.$SOSYAL_NOTU,
        'universite' => 'Ankara Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['hukuk'],
        'cetvel' => 'ankara-2023',
        'notlar' => 'SOSYAL BİLİMLER, Profesör. (1A-1G) faaliyetlerinden en az 370 puan, en az '
            .'210 puanı doçentlik unvanı sonrası. MADDE I/ı: monografi ya da Q1-Q2 telafisi, '
            .'doçentlik unvanından sonra yayımlanmış olmalı.',
        'sart' => Kalip::ve('Profesör — Hukuk', [
            Kalip::puanDan('WoS, Scopus, uluslararası indeksli ve TR-Dizin dergilerindeki makalelerinizden en az 370 puan', ['1A-1G'], 370, madde: 'Bölüm 1 · 1A-1G'),
            Kalip::puanDan('Bunun en az 210 puanı doçentlik sonrası olmalı', ['1A-1G'], 210, Kalip::DOCENTLIK_SONRASI),
            $hukukMonografi(Kalip::DOCENTLIK_SONRASI),
        ]),
    ],

    // ══════════════════════ GÜZEL SANATLAR ══════════════════════
    // Baraj üç bölümün toplamından: makale + kitap + sanatsal etkinlik.
    [
        'anahtar' => 'ankara-dr-guzel-sanatlar',
        'aday_notu' => 'Baraj makale, kitap ve sanatsal etkinlik puanlarının toplamından hesaplanıyor.',
        'universite' => 'Ankara Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'ankara-2023',
        'notlar' => 'GÜZEL SANATLAR, Dr. Öğr. Üyesi. 1. Makaleler, 2. Kitap/Kitap Bölümü, 3. Sanatsal Etkinlik bölümlerinden toplam en az 90 puan.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Güzel Sanatlar', [
            Kalip::puanDan('Makale, kitap ve sanatsal etkinlik kalemlerinden en az 90 puan', ['1A-1G', 'KITAP', 'SANATSAL'], 90),
            $yurtDisi(),
        ]),
    ],
    [
        'anahtar' => 'ankara-docent-guzel-sanatlar',
        'universite' => 'Ankara Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'ankara-2023',
        'notlar' => 'GÜZEL SANATLAR, Doçent. Makaleler, Kitap/Kitap Bölümü ve Sanatsal Etkinlik bölümlerinden toplam en az 200 puan.',
        'sart' => Kalip::ve('Doçent — Güzel Sanatlar', [
            Kalip::puanDan('Makale, kitap ve sanatsal etkinlik kalemlerinden en az 200 puan', ['1A-1G', 'KITAP', 'SANATSAL'], 200),
        ]),
    ],
    [
        'anahtar' => 'ankara-profesor-guzel-sanatlar',
        'aday_notu' => 'Zorunlu 350 puanın en az 150\'si doçentlik unvanından sonra kazanılmış olmalı.',
        'universite' => 'Ankara Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'ankara-2023',
        'notlar' => 'GÜZEL SANATLAR, Profesör. Toplam en az 350 puan, en az 150 puanı doçentlik unvanı sonrası.',
        'sart' => Kalip::ve('Profesör — Güzel Sanatlar', [
            Kalip::puanDan('Makale, kitap ve sanatsal etkinlik kalemlerinden en az 350 puan', ['1A-1G', 'KITAP', 'SANATSAL'], 350),
            Kalip::puanDan('Bunun en az 150 puanı doçentlik sonrası olmalı', ['1A-1G', 'KITAP', 'SANATSAL'], 150, Kalip::DOCENTLIK_SONRASI),
        ]),
    ],
];
