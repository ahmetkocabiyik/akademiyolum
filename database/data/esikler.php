<?php

/*
|--------------------------------------------------------------------------
| Doğrulanmış Yönerge Eşikleri (üniversite atama kriterleri)
|--------------------------------------------------------------------------
|
| PDF'lerden elle çıkarılmış gerçek asgari koşullar; kadro ve temel alana göre.
| [üniversite_ad, kadro, alan, min_toplam, yayin_min, index_min, yds_min, notlar].
| kadro: dr_ogr_uyesi | docentlik | profesorluk. Kaynak = pdf → "Doğrulandı" rozeti.
| 9. eleman (opsiyonel): yapısal alt-koşullar (adet/yazarlık/veya/bilgi).
|
*/

// Tüm makale indeksleri (başlıca yazar makale koşulları için).
$makaleTum = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI', 'ESCI / Scopus', 'TR Dizin', 'Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'];

return [

    // ══════════════════════ Dr. Öğr. Üyesi ══════════════════════

    // ── Sosyal / Beşeri ──
    [
        'Şırnak Üniversitesi', 'dr_ogr_uyesi', 'sosyal', 100, 40, null, 55,
        'Sosyal/Beşeri: makalelerden en az 40 puan koşuluyla toplamda en az 100 puan (Madde 6.2.1).',
    ],
    [
        'Malatya Turgut Özal Üniversitesi', 'dr_ogr_uyesi', 'sosyal', 100, 50, null, 55,
        'Sosyal: A1/A2 yayınlardan en az 50; A-C faaliyetlerinden toplamda en az 100 puan.',
    ],
    [
        'Gaziantep İslam Bilim ve Teknoloji Üniversitesi', 'dr_ogr_uyesi', 'sosyal', 60, 20, null, 55,
        'Makale (1.a/1.b) en az 20; 4-6. maddelerden en az 10; genel toplamda en az 60 puan.',
    ],
    [
        'Eskişehir Osmangazi Üniversitesi', 'dr_ogr_uyesi', 'sosyal', 60, 40, null, 55,
        'İlk atanma: 1,2,9,16. maddelerden en az 40 puan koşuluyla toplamda en az 60 puan.',
    ],
    [
        'Nevşehir Hacı Bektaş Veli Üniversitesi', 'dr_ogr_uyesi', 'sosyal', 100, null, null, 55,
        'Ek-1 puanlama tablosundan toplamda en az 100 puan.',
    ],
    [
        'Gümüşhane Üniversitesi', 'dr_ogr_uyesi', 'sosyal', 70, null, null, 60,
        'Asgari Şart tablosuna göre toplamda ~70 puan; YDS en az 60 (Madde 10).',
    ],
    [
        'Trabzon Üniversitesi', 'dr_ogr_uyesi', 'sosyal', 60, 40, null, 65,
        'Tablo 1 alan puanı (temsili 60); öngörülen puanın en az 2/3\'ü makalelerden. YDS en az 70.',
    ],

    // ── Fen ──
    [
        'Malatya Turgut Özal Üniversitesi', 'dr_ogr_uyesi', 'fen', 150, 80, null, 55,
        'Fen/Sağlık: A1/A2 yayınlardan en az 80; A-C faaliyetlerinden toplamda en az 150 puan.',
    ],
    [
        'Konya Teknik Üniversitesi', 'dr_ogr_uyesi', 'fen', 190, 60, null, 65,
        'Madde 8 (Fen/Mühendislik/Sağlık): yayınlardan en az 60; toplamda en az 190 puan. YDS en az 65.',
    ],
    [
        'Afyon Kocatepe Üniversitesi', 'dr_ogr_uyesi', 'fen', 200, null, null, null,
        'Fen/Mühendislik/Ziraat: 1.1\'den 2 + 1.3\'ten 1 makale; toplamda en az 200 puan.',
    ],
    [
        'Akdeniz Üniversitesi', 'dr_ogr_uyesi', 'fen', 100, null, null, 70,
        'Grup 1: en az 3 yayın ve toplamda en az 100 puan. YDS en az 70.',
    ],
    [
        'Atatürk Üniversitesi', 'dr_ogr_uyesi', 'fen', 100, null, 18, 70,
        'Fen/Mühendislik grubu: toplam 100 puan; en az 18 puan SCIE/SSCI/AHCI. YDS en az 70.',
    ],

    // ── Mühendislik (çoğu yönergede Fen ile aynı grupta) ──
    [
        'Konya Teknik Üniversitesi', 'dr_ogr_uyesi', 'muhendislik', 190, 60, null, 65,
        'Madde 8: A-1/A-2 yayınlardan en az 60; (A-G)+(K+L+M) 130; toplamda en az 190 puan. YDS en az 65.',
    ],
    [
        'Afyon Kocatepe Üniversitesi', 'dr_ogr_uyesi', 'muhendislik', 200, null, null, null,
        '1.1 maddesinden en az 2 + 1.3 maddesinden en az 1 makale; Ek-1 tablosundan toplamda en az 200 puan.',
    ],
    [
        'Akdeniz Üniversitesi', 'dr_ogr_uyesi', 'muhendislik', 100, null, null, 70,
        'Grup 1 (Sağlık/Ziraat/Mühendislik/Fen): en az 3 yayın ve toplamda en az 100 puan. YDS en az 70.',
    ],
    [
        'Atatürk Üniversitesi', 'dr_ogr_uyesi', 'muhendislik', 100, null, 18, 70,
        '0 ve 2. bölgelerden toplam 100 puan; en az 18 puan SCIE/SSCI/AHCI dergilerinden. YDS en az 70.',
    ],

    // ── Güzel Sanatlar ──
    [
        'Şırnak Üniversitesi', 'dr_ogr_uyesi', 'guzel_sanatlar', 50, null, null, 55,
        'Güzel Sanatlar: puanlama listesindeki ilgili maddelerden toplamda en az 50 puan.',
    ],

    // ══════════════════════ Doçent ══════════════════════
    // Not: Üniversite doçent KADROSU barajı — ÜAK doçent unvanının (asgari 100) üstüne ek şarttır.

    [
        'Konya Teknik Üniversitesi', 'docentlik', 'muhendislik', 500, 80, null, 65,
        'Madde 10: A türü yayınlardan en az 80; (A-G)+(K+L+M) 370; toplamda en az 500 puan. YDS en az 65.',
    ],
    [
        'Konya Teknik Üniversitesi', 'docentlik', 'fen', 500, 80, null, 65,
        'Fen/Mühendislik/Sağlık: A türü yayınlardan en az 80; toplamda en az 500 puan.',
    ],
    [
        'Afyon Kocatepe Üniversitesi', 'docentlik', 'muhendislik', 500, null, null, null,
        'Doçentlik unvanı sonrası çalışmalarla Ek-1 tablosundan toplamda en az 500 puan.',
    ],
    [
        'Afyon Kocatepe Üniversitesi', 'docentlik', 'fen', 500, null, null, null,
        'Fen/Mühendislik: doçentlik sonrası toplamda en az 500 puan.',
    ],
    [
        'Afyon Kocatepe Üniversitesi', 'docentlik', 'sosyal', 500, null, null, null,
        'Sosyal/Beşeri: doçentlik sonrası toplamda en az 500 puan + alt koşullar.',
        [
            [
                'aciklama' => 'Uluslararası (SCIE/SSCI/AHCI/ESCI) makaleden başlıca yazar en az 1',
                'kategori' => 'makale',
                'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI', 'ESCI / Scopus'],
                'yazar' => 'baslica',
                'min_adet' => 1,
            ],
            [
                'aciklama' => 'Ulusal (TR Dizin) makaleden en az 5',
                'kategori' => 'makale',
                'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'],
                'min_adet' => 5,
            ],
            [
                'aciklama' => 'Bu ulusal makalelerin en az 3\'ü tek yazar',
                'kategori' => 'makale',
                'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'],
                'yazar' => 'tek',
                'min_adet' => 3,
            ],
            [
                'aciklama' => 'En az 1 kitap veya en az 2 kitap bölümü',
                'veya' => [
                    ['kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'min_adet' => 1],
                    ['kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'BKCI / Scopus Kitap Bölümü'], 'min_adet' => 2],
                ],
            ],
        ],
    ],
    [
        'Akdeniz Üniversitesi', 'docentlik', 'muhendislik', 300, null, null, 70,
        'Grup 1: en az puan 300; puanın en az yarısı makalelerden. YDS en az 70.',
        [
            ['aciklama' => 'Doçentlik sonrası en az 2 makalede başlıca yazar', 'kategori' => 'makale', 'kaynaklar' => $makaleTum, 'yazar' => 'baslica', 'min_adet' => 2],
            ['aciklama' => 'BAP/dış kaynaklı projede yürütücülük (doçentlik ≥1, profesörlük ≥2)', 'bilgi' => true],
            ['aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden', 'bilgi' => true],
            ['aciklama' => 'Yayınların en az 4\'ü doktora sonrası ve son 7 yılda', 'bilgi' => true],
        ],
    ],
    [
        'Akdeniz Üniversitesi', 'docentlik', 'fen', 300, null, null, 70,
        'Grup 1: toplamda en az 300 puan; puanın en az yarısı makalelerden. YDS en az 70.',
        [
            ['aciklama' => 'Doçentlik sonrası en az 2 makalede başlıca yazar', 'kategori' => 'makale', 'kaynaklar' => $makaleTum, 'yazar' => 'baslica', 'min_adet' => 2],
            ['aciklama' => 'BAP/dış kaynaklı projede yürütücülük (doçentlik ≥1, profesörlük ≥2)', 'bilgi' => true],
            ['aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden', 'bilgi' => true],
            ['aciklama' => 'Yayınların en az 4\'ü doktora sonrası ve son 7 yılda', 'bilgi' => true],
        ],
    ],
    [
        'Akdeniz Üniversitesi', 'docentlik', 'sosyal', 300, null, null, 70,
        'Grup 2 (Sosyal/Eğitim/Mimarlık): toplamda en az 300 puan; puanın en az yarısı makalelerden. YDS en az 70.',
        [
            ['aciklama' => 'Doçentlik sonrası en az 2 makalede başlıca yazar', 'kategori' => 'makale', 'kaynaklar' => $makaleTum, 'yazar' => 'baslica', 'min_adet' => 2],
            ['aciklama' => 'BAP/dış kaynaklı projede yürütücülük (doçentlik ≥1, profesörlük ≥2)', 'bilgi' => true],
            ['aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden', 'bilgi' => true],
            ['aciklama' => 'Yayınların en az 2\'si doktora sonrası ve son 7 yılda', 'bilgi' => true],
        ],
    ],

    // ══════════════════════ Profesör ══════════════════════

    [
        'Konya Teknik Üniversitesi', 'profesorluk', 'muhendislik', 650, null, null, 65,
        'Madde 11: doçentlik sonrası (A-G)+(K+L+M) en az 200; toplamda en az 650 puan. YDS en az 65.',
    ],
    [
        'Konya Teknik Üniversitesi', 'profesorluk', 'fen', 650, null, null, 65,
        'Fen/Mühendislik: doçentlik sonrası toplamda en az 650 puan.',
    ],
    [
        'Akdeniz Üniversitesi', 'profesorluk', 'muhendislik', 500, null, null, 70,
        'Grup 1: en az puan 500; puanın en az yarısı makalelerden. YDS en az 70.',
        [
            ['aciklama' => 'Doçentlik sonrası en az 2 makalede başlıca yazar', 'kategori' => 'makale', 'kaynaklar' => $makaleTum, 'yazar' => 'baslica', 'min_adet' => 2],
            ['aciklama' => 'BAP/dış kaynaklı projede yürütücülük (doçentlik ≥1, profesörlük ≥2)', 'bilgi' => true],
            ['aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden', 'bilgi' => true],
            ['aciklama' => 'Yayınların en az 4\'ü doçentlik sonrası ve son 7 yılda', 'bilgi' => true],
        ],
    ],
    [
        'Akdeniz Üniversitesi', 'profesorluk', 'fen', 500, null, null, 70,
        'Grup 1: toplamda en az 500 puan; puanın en az yarısı makalelerden. YDS en az 70.',
        [
            ['aciklama' => 'Doçentlik sonrası en az 2 makalede başlıca yazar', 'kategori' => 'makale', 'kaynaklar' => $makaleTum, 'yazar' => 'baslica', 'min_adet' => 2],
            ['aciklama' => 'BAP/dış kaynaklı projede yürütücülük (doçentlik ≥1, profesörlük ≥2)', 'bilgi' => true],
            ['aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden', 'bilgi' => true],
            ['aciklama' => 'Yayınların en az 4\'ü doçentlik sonrası ve son 7 yılda', 'bilgi' => true],
        ],
    ],
    [
        'Akdeniz Üniversitesi', 'profesorluk', 'sosyal', 500, null, null, 70,
        'Grup 2: toplamda en az 500 puan; puanın en az yarısı makalelerden. YDS en az 70.',
        [
            ['aciklama' => 'Doçentlik sonrası en az 2 makalede başlıca yazar', 'kategori' => 'makale', 'kaynaklar' => $makaleTum, 'yazar' => 'baslica', 'min_adet' => 2],
            ['aciklama' => 'BAP/dış kaynaklı projede yürütücülük (doçentlik ≥1, profesörlük ≥2)', 'bilgi' => true],
            ['aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden', 'bilgi' => true],
            ['aciklama' => 'Yayınların en az 2\'si doçentlik sonrası ve son 7 yılda', 'bilgi' => true],
        ],
    ],
];
