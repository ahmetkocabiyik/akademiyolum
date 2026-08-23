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
 * ALAN EŞLEMESİ YALNIZCA BÖLÜM BAŞLIKLARINDA ADI GEÇENLERLE SINIRLI TUTULDU.
 * Yönerge Gazi'deki gibi bir fakülte→grup tablosu vermiyor; eğitim, filoloji,
 * hukuk, ilahiyat, mimarlık, ziraat ve spor alanlarının hangi bölüme tabi
 * olduğu belgeden okunamıyor, bu yüzden eşik girilmedi.
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

return [
    // ══════════════ FEN, MÜHENDİSLİK ve SAĞLIK BİLİMLERİ ══════════════
    [
        'anahtar' => 'ankara-dr-fen-muh-saglik',
        'aday_notu' => 'İki katmanlı baraj var: dar makale kümesinden (1A-1E) en az 50, tüm makale kalemlerinden (1A-1G) en az 90 puan.',
        'universite' => 'Ankara Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['fen', 'muhendislik', 'saglik'],
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
        'alan' => ['fen', 'muhendislik', 'saglik'],
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
        'alan' => ['fen', 'muhendislik', 'saglik'],
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
        'alan' => ['sosyal'],
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
        'alan' => ['sosyal'],
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
        'alan' => ['sosyal'],
        'cetvel' => 'ankara-2023',
        'notlar' => 'SOSYAL BİLİMLER, Profesör. (1A-1G) faaliyetlerinden en az 370 puan, en az 210 puanı doçentlik unvanı sonrası.',
        'sart' => Kalip::ve('Profesör — Sosyal Bilimler', [
            Kalip::puanDan('WoS, Scopus, uluslararası indeksli ve TR-Dizin dergilerindeki makalelerinizden en az 370 puan', ['1A-1G'], 370, madde: 'Bölüm 1 · 1A-1G'),
            Kalip::puanDan('Bunun en az 210 puanı doçentlik sonrası olmalı', ['1A-1G'], 210, Kalip::DOCENTLIK_SONRASI),
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
