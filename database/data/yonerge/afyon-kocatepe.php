<?php

/**
 * AFYON KOCATEPE ÜNİVERSİTESİ — şart ağaçları.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · şema: sart-agaci-taslak.php
 * `alan` dizi olabilir: SartDeposu alan başına ayrı kayda açar.
 */
use App\Services\Scoring\Sart\Kalip;

return [
    /*
    ╔══════════════════════════════════════════════════════════════════════════╗
    ║  AFYON KOCATEPE ÜNİVERSİTESİ
    ╚══════════════════════════════════════════════════════════════════════════╝
    | Kaynak: pdf/17536927832.afyonkocatepeuniversitesi.pdf · Cetvel: afyon-2026
    | Tablo 1/2/3 asgari başvuru puanı alındı; madde metnindeki farklı toplam
    | (200/600/700) notlarda tutuluyor — yönerge iki değer veriyor.
    | YDS koşulu yok (yalnız yabancı dille öğretim yapan programlar için).
    */

    // ── Dr. Öğr. Üyesi (Tablo 1, asgari 180) ──
    [
        'anahtar' => 'afyon-dr-egitim-spor',
        'aday_notu' => 'Makale sayıları indeks düzeyine göre ayrı ayrı aranıyor. Yönerge, TR Dizin şartı yerine daha üst indeksten yayın kabul ediyor.',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['egitim', 'spor'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 1 (Eğitim/Spor): Asgari Başvuru Puanı 180. Madde 7/1-ç ise şunu istiyor: '
            .'"...Ek-1\'de yer alan tablodaki maddelerden toplamda en az 200 puan almış olmak."',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 1 — Eğitim/Spor Bilimleri', 'cocuklar' => [
            Kalip::toplam(180),
            Kalip::adet('SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 1 makale', ['ULUSLARARASI_VE_ESCI'], 1),
            Kalip::adet('TR Dizin kapsamında en az 2 makale', ['1.3'], 2, null, null, Kalip::indeksTelafisi('TR Dizin yerine SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 2 makale', ['ULUSLARARASI_VE_ESCI'], 2)),
        ]],
    ],
    [
        'anahtar' => 'afyon-dr-saglik',
        'aday_notu' => 'Makale sayıları indeks düzeyine göre ayrı ayrı aranıyor. Yönerge, TR Dizin şartı yerine daha üst indeksten yayın kabul ediyor.',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['saglik'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 1 (Sağlık Bilimleri): Asgari Başvuru Puanı 180. Madde 7/1-ç toplamda en az 200 puan istiyor.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 1 — Sağlık Bilimleri', 'cocuklar' => [
            Kalip::toplam(180),
            Kalip::adet('SCIE/SSCI/AHCI kapsamında en az 2 makale', ['ULUSLARARASI'], 2),
            Kalip::adet('TR Dizin kapsamında en az 1 makale', ['1.3'], 1, null, null, Kalip::indeksTelafisi('TR Dizin yerine SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 1 makale', ['ULUSLARARASI_VE_ESCI'], 1)),
        ]],
    ],
    [
        'anahtar' => 'afyon-dr-fen',
        'aday_notu' => 'Makale sayıları indeks düzeyine göre ayrı ayrı aranıyor. Yönerge, TR Dizin şartı yerine daha üst indeksten yayın kabul ediyor.',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['fen', 'muhendislik', 'ziraat'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 1 (Fen/Mühendislik/Ziraat): Asgari Başvuru Puanı 180. Madde 7/1-ç toplamda en az 200 puan istiyor.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 1 — Fen/Mühendislik/Ziraat', 'cocuklar' => [
            Kalip::toplam(180),
            Kalip::adet('SCIE/SSCI/AHCI kapsamında en az 2 makale', ['ULUSLARARASI'], 2),
            Kalip::adet('TR Dizin kapsamında en az 1 makale', ['1.3'], 1, null, null, Kalip::indeksTelafisi('TR Dizin yerine SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 1 makale', ['ULUSLARARASI_VE_ESCI'], 1)),
        ]],
    ],
    [
        'anahtar' => 'afyon-dr-mimarlik',
        'aday_notu' => 'Makale sayıları indeks düzeyine göre ayrı ayrı aranıyor. Yönerge, TR Dizin şartı yerine daha üst indeksten yayın kabul ediyor.',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['mimarlik'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 1 (Mimarlık/Matematik/İstatistik): Asgari Başvuru Puanı 180. Projede tek `fen` '
            .'alanı olduğu için Afyon\'un Matematik/İstatistik grubu bu satıra değil Fen satırına bağlı.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 1 — Mimarlık, Planlama ve Tasarım', 'cocuklar' => [
            Kalip::toplam(180),
            Kalip::adet('SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 2 makale', ['ULUSLARARASI_VE_ESCI'], 2),
            Kalip::adet('Bunlardan en az 1 tanesi SCIE/SSCI/AHCI kapsamında', ['ULUSLARARASI'], 1),
            Kalip::adet('TR Dizin kapsamında en az 1 makale', ['1.3'], 1, null, null, Kalip::indeksTelafisi('TR Dizin yerine SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 1 makale', ['ULUSLARARASI_VE_ESCI'], 1)),
        ]],
    ],
    [
        'anahtar' => 'afyon-dr-sosyal',
        'aday_notu' => 'Makale sayıları indeks düzeyine göre ayrı ayrı aranıyor. Yönerge, TR Dizin şartı yerine daha üst indeksten yayın kabul ediyor.',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['sosyal'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 1 (Sosyal, Beşeri ve İdari Bilimler): Asgari Başvuru Puanı 180.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 1 — Sosyal, Beşeri ve İdari Bilimler', 'cocuklar' => [
            Kalip::toplam(180),
            Kalip::adet('SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 1 makale', ['ULUSLARARASI_VE_ESCI'], 1),
            Kalip::adet('TR Dizin kapsamında en az 2 makale', ['1.3'], 2, null, null, Kalip::indeksTelafisi('TR Dizin yerine SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 2 makale', ['ULUSLARARASI_VE_ESCI'], 2)),
        ]],
    ],
    [
        'anahtar' => 'afyon-dr-filoloji-ilahiyat',
        'aday_notu' => 'Makale sayıları indeks düzeyine göre ayrı ayrı aranıyor. Yönerge, TR Dizin şartı yerine daha üst indeksten yayın kabul ediyor.',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['filoloji', 'ilahiyat'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 1 (Filoloji/İlahiyat): Asgari Başvuru Puanı 180.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 1 — Filoloji/İlahiyat', 'cocuklar' => [
            Kalip::toplam(180),
            Kalip::adet('SCIE/SSCI/AHCI, ESCI/Scopus veya TR Dizin kapsamında en az 4 makale', ['ULUSLARARASI_VE_ESCI', '1.3'], 4),
        ]],
    ],
    [
        'anahtar' => 'afyon-dr-hukuk',
        'aday_notu' => 'Makale sayıları indeks düzeyine göre ayrı ayrı aranıyor. Yönerge, TR Dizin şartı yerine daha üst indeksten yayın kabul ediyor.',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['hukuk'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 1 (Hukuk): üç seçenekten biri + Asgari Başvuru Puanı 180. Üçüncü seçenek iki '
            .'koşulu "ve" ile bağlıyor: "1.3. maddesinden yayımlanmış en az 2 makalesi olmak ve 3.1 '
            .'veya 3.2 maddelerinden yayımlanmış tek yazarlı özgün bilimsel en az 1 kitabı olmak."',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 1 — Hukuk', 'cocuklar' => [
            Kalip::toplam(180),
            ['tip' => 'veya', 'aciklama' => 'Üç seçenekten biri', 'cocuklar' => [
                Kalip::adet('SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 2 makale', ['ULUSLARARASI_VE_ESCI'], 2),
                Kalip::adet('TR Dizin kapsamında en az 4 makale', ['1.3'], 4),
                ['tip' => 've', 'aciklama' => 'TR Dizin\'den 2 makale ve tek yazarlı 1 kitap', 'cocuklar' => [
                    Kalip::adet('TR Dizin kapsamında en az 2 makale', ['1.3'], 2),
                    Kalip::adet('Tek yazarlı en az 1 kitap', ['KITAP'], 1, 'tek'),
                ]],
            ]],
        ]],
    ],
    [
        'anahtar' => 'afyon-dr-guzel-sanatlar',
        'aday_notu' => 'Makale sayıları indeks düzeyine göre ayrı ayrı aranıyor. Yönerge, TR Dizin şartı yerine daha üst indeksten yayın kabul ediyor.',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 1 (Güzel Sanatlar): Asgari Başvuru Puanı 180. 9.x sanatsal etkinlik maddeleri '
            .'cetvele henüz girilmedi; o koşul beyan olarak duruyor.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 1 — Güzel Sanatlar', 'cocuklar' => [
            Kalip::toplam(180),
            Kalip::adet('SCIE/SSCI/AHCI, ESCI/Scopus veya TR Dizin kapsamında en az 3 makale', ['ULUSLARARASI_VE_ESCI', '1.3'], 3),
            Kalip::beyan('Sanatsal etkinliklerden (sergi, gösterim, tasarım) en az 60 puan'),
        ]],
    ],

    // ── Doçent (Tablo 2, doktora sonrası) ──
    [
        'anahtar' => 'afyon-docent-egitim-spor',
        'aday_notu' => 'Makale sayıları indeks düzeyine göre ayrı ayrı aranıyor. Yönerge, TR Dizin şartı yerine daha üst indeksten yayın kabul ediyor.',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['egitim', 'spor'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 2 (Eğitim/Spor): Asgari Başvuru Puanı 500, doktora sonrası. Madde 8/1-ç ise '
            .'"güzel sanatlar alanı için en az 450, diğer alanlar için en az 600 puan" istiyor.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 2 — Eğitim/Spor Bilimleri', 'cocuklar' => [
            Kalip::toplam(500, Kalip::DOKTORA_SONRASI),
            Kalip::adet('SCIE/SSCI/AHCI kapsamında en az 2 makale', ['ULUSLARARASI'], 2, null, Kalip::DOKTORA_SONRASI),
            Kalip::adet('Bunların en az 1\'inde Q1-Q3 kapsamında başlıca yazar', ['Q1_Q3'], 1, 'baslica', Kalip::DOKTORA_SONRASI),
            Kalip::adet('TR Dizin kapsamında en az 4 makale', ['1.3'], 4, null, Kalip::DOKTORA_SONRASI, Kalip::indeksTelafisi('TR Dizin yerine SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 4 makale', ['ULUSLARARASI_VE_ESCI'], 4)),
            Kalip::adet('Bunların en az 2\'sinde başlıca yazar', ['1.3'], 2, 'baslica', Kalip::DOKTORA_SONRASI, Kalip::indeksTelafisi('TR Dizin yerine SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 2 makale', ['ULUSLARARASI_VE_ESCI'], 2, 'baslica')),
        ]],
    ],
    [
        'anahtar' => 'afyon-docent-saglik',
        'aday_notu' => 'Makale sayıları indeks düzeyine göre ayrı ayrı aranıyor. Yönerge, TR Dizin şartı yerine daha üst indeksten yayın kabul ediyor.',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['saglik'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 2 (Sağlık Bilimleri): Asgari Başvuru Puanı 500, doktora sonrası. Madde 8/1-ç 600 puan istiyor.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 2 — Sağlık Bilimleri', 'cocuklar' => [
            Kalip::toplam(500, Kalip::DOKTORA_SONRASI),
            Kalip::adet('SCIE/SSCI Q1-Q3 kapsamında en az 4 makale', ['Q1_Q3'], 4, null, Kalip::DOKTORA_SONRASI),
            Kalip::adet('Bunların en az 3\'ünde başlıca yazar', ['Q1_Q3'], 3, 'baslica', Kalip::DOKTORA_SONRASI),
            Kalip::adet('TR Dizin kapsamında başlıca yazar olduğu en az 2 makale', ['1.3'], 2, 'baslica', Kalip::DOKTORA_SONRASI, Kalip::indeksTelafisi('TR Dizin yerine SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 2 makale', ['ULUSLARARASI_VE_ESCI'], 2, 'baslica')),
        ]],
    ],
    [
        'anahtar' => 'afyon-docent-fen',
        'aday_notu' => 'Makale sayıları indeks düzeyine göre ayrı ayrı aranıyor. Yönerge, TR Dizin şartı yerine daha üst indeksten yayın kabul ediyor.',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['fen', 'muhendislik', 'ziraat'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 2 (Fen/Mühendislik/Ziraat): Asgari Başvuru Puanı 500, doktora sonrası. Madde 8/1-ç 600 puan istiyor.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 2 — Fen/Mühendislik/Ziraat', 'cocuklar' => [
            Kalip::toplam(500, Kalip::DOKTORA_SONRASI),
            Kalip::adet('SCIE/SSCI Q1-Q3 kapsamında en az 4 makale', ['Q1_Q3'], 4, null, Kalip::DOKTORA_SONRASI),
            Kalip::adet('Bunların en az 2\'sinde başlıca yazar', ['Q1_Q3'], 2, 'baslica', Kalip::DOKTORA_SONRASI),
            Kalip::adet('TR Dizin kapsamında başlıca yazar olduğu en az 2 makale', ['1.3'], 2, 'baslica', Kalip::DOKTORA_SONRASI, Kalip::indeksTelafisi('TR Dizin yerine SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 2 makale', ['ULUSLARARASI_VE_ESCI'], 2, 'baslica')),
        ]],
    ],
    [
        'anahtar' => 'afyon-docent-mimarlik',
        'aday_notu' => 'Makale sayıları indeks düzeyine göre ayrı ayrı aranıyor. Yönerge, TR Dizin şartı yerine daha üst indeksten yayın kabul ediyor.',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['mimarlik'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 2 (Mimarlık/Matematik/İstatistik): Asgari Başvuru Puanı 500, doktora sonrası.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 2 — Mimarlık, Planlama ve Tasarım', 'cocuklar' => [
            Kalip::toplam(500, Kalip::DOKTORA_SONRASI),
            Kalip::adet('SCIE/SSCI Q1-Q3 kapsamında en az 4 makale', ['Q1_Q3'], 4, null, Kalip::DOKTORA_SONRASI),
            Kalip::adet('Bunların en az 1\'inde başlıca yazar', ['Q1_Q3'], 1, 'baslica', Kalip::DOKTORA_SONRASI),
            Kalip::adet('TR Dizin kapsamında başlıca yazar olduğu en az 2 makale', ['1.3'], 2, 'baslica', Kalip::DOKTORA_SONRASI, Kalip::indeksTelafisi('TR Dizin yerine SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 2 makale', ['ULUSLARARASI_VE_ESCI'], 2, 'baslica')),
        ]],
    ],
    [
        'anahtar' => 'afyon-docent-sosyal',
        'aday_notu' => 'Makale sayıları indeks düzeyine göre ayrı ayrı aranıyor. Yönerge, TR Dizin şartı yerine daha üst indeksten yayın kabul ediyor.',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['sosyal'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 2 (Sosyal, Beşeri ve İdari Bilimler): Asgari Başvuru Puanı 500, doktora sonrası.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 2 — Sosyal, Beşeri ve İdari Bilimler', 'cocuklar' => [
            Kalip::toplam(500, Kalip::DOKTORA_SONRASI),
            Kalip::adet('SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında başlıca yazar olduğu en az 1 makale', ['ULUSLARARASI_VE_ESCI'], 1, 'baslica', Kalip::DOKTORA_SONRASI),
            Kalip::adet('TR Dizin kapsamında en az 5 makale', ['1.3'], 5, null, Kalip::DOKTORA_SONRASI, Kalip::indeksTelafisi('TR Dizin yerine SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 5 makale', ['ULUSLARARASI_VE_ESCI'], 5)),
            Kalip::adet('Bunların en az 3\'ü tek yazarlı', ['1.3'], 3, 'tek', Kalip::DOKTORA_SONRASI, Kalip::indeksTelafisi('TR Dizin yerine SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 3 makale', ['ULUSLARARASI_VE_ESCI'], 3, 'tek')),
            ['tip' => 'veya', 'aciklama' => 'En az 1 kitap veya en az 2 kitap bölümü', 'cocuklar' => [
                Kalip::adet('En az 1 kitap', ['KITAP'], 1, null, Kalip::DOKTORA_SONRASI),
                Kalip::adet('En az 2 kitap bölümü', ['KITAP_BOLUM'], 2, null, Kalip::DOKTORA_SONRASI),
            ]],
        ]],
    ],
    [
        'anahtar' => 'afyon-docent-ilahiyat',
        'aday_notu' => 'Makale sayıları indeks düzeyine göre ayrı ayrı aranıyor. Yönerge, TR Dizin şartı yerine daha üst indeksten yayın kabul ediyor.',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['ilahiyat'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 2 (İlahiyat): Asgari Başvuru Puanı 500, doktora sonrası.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 2 — İlahiyat', 'cocuklar' => [
            Kalip::toplam(500, Kalip::DOKTORA_SONRASI),
            Kalip::adet('SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında başlıca yazar olduğu en az 1 makale', ['ULUSLARARASI_VE_ESCI'], 1, 'baslica', Kalip::DOKTORA_SONRASI),
            Kalip::adet('TR Dizin kapsamında en az 5 makale', ['1.3'], 5, null, Kalip::DOKTORA_SONRASI, Kalip::indeksTelafisi('TR Dizin yerine SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 5 makale', ['ULUSLARARASI_VE_ESCI'], 5)),
            Kalip::adet('Bunların en az 3\'ü tek yazarlı', ['1.3'], 3, 'tek', Kalip::DOKTORA_SONRASI, Kalip::indeksTelafisi('TR Dizin yerine SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 3 makale', ['ULUSLARARASI_VE_ESCI'], 3, 'tek')),
            Kalip::adet('Tek yazarlı en az 1 kitap', ['KITAP'], 1, 'tek', Kalip::DOKTORA_SONRASI),
        ]],
    ],
    [
        'anahtar' => 'afyon-docent-filoloji',
        'aday_notu' => 'Makale sayıları indeks düzeyine göre ayrı ayrı aranıyor. Yönerge, TR Dizin şartı yerine daha üst indeksten yayın kabul ediyor.',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['filoloji'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 2 (Filoloji): Asgari Başvuru Puanı 500, doktora sonrası.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 2 — Filoloji', 'cocuklar' => [
            Kalip::toplam(500, Kalip::DOKTORA_SONRASI),
            Kalip::adet('SCIE/SSCI/AHCI, ESCI/Scopus veya TR Dizin kapsamında en az 6 makale', ['ULUSLARARASI_VE_ESCI', '1.3'], 6, null, Kalip::DOKTORA_SONRASI),
            Kalip::adet('Bunların en az 3\'ü tek yazarlı', ['ULUSLARARASI_VE_ESCI', '1.3'], 3, 'tek', Kalip::DOKTORA_SONRASI),
            Kalip::adet('Tek yazarlı en az 1 kitap', ['KITAP'], 1, 'tek', Kalip::DOKTORA_SONRASI),
        ]],
    ],
    [
        'anahtar' => 'afyon-docent-hukuk',
        'aday_notu' => 'Makale sayıları indeks düzeyine göre ayrı ayrı aranıyor. Yönerge, TR Dizin şartı yerine daha üst indeksten yayın kabul ediyor.',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['hukuk'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 2 (Hukuk): Asgari Başvuru Puanı 500, doktora sonrası.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 2 — Hukuk', 'cocuklar' => [
            Kalip::toplam(500, Kalip::DOKTORA_SONRASI),
            Kalip::adet('SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 1 makale', ['ULUSLARARASI_VE_ESCI'], 1, null, Kalip::DOKTORA_SONRASI),
            Kalip::adet('TR Dizin kapsamında en az 6 makale', ['1.3'], 6, null, Kalip::DOKTORA_SONRASI, Kalip::indeksTelafisi('TR Dizin yerine SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 6 makale', ['ULUSLARARASI_VE_ESCI'], 6)),
            Kalip::adet('Bunların en az 4\'ü tek yazarlı', ['1.3'], 4, 'tek', Kalip::DOKTORA_SONRASI, Kalip::indeksTelafisi('TR Dizin yerine SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 4 makale', ['ULUSLARARASI_VE_ESCI'], 4, 'tek')),
            Kalip::adet('Tek yazarlı en az 1 kitap', ['KITAP'], 1, 'tek', Kalip::DOKTORA_SONRASI),
        ]],
    ],
    [
        'anahtar' => 'afyon-docent-guzel-sanatlar',
        'aday_notu' => 'Makale sayıları indeks düzeyine göre ayrı ayrı aranıyor. Yönerge, TR Dizin şartı yerine daha üst indeksten yayın kabul ediyor.',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 2 (Güzel Sanatlar): Asgari Başvuru Puanı 350, doktora sonrası. Madde 8/1-ç '
            .'güzel sanatlar için 450 puan istiyor.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 2 — Güzel Sanatlar', 'cocuklar' => [
            Kalip::toplam(350, Kalip::DOKTORA_SONRASI),
            Kalip::beyan('Sanatsal etkinliklerden en az 100 puan (ÜAK özel koşullarına uygun)'),
            Kalip::adet('SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında başlıca yazar olduğu en az 1 makale', ['ULUSLARARASI_VE_ESCI'], 1, 'baslica', Kalip::DOKTORA_SONRASI),
            Kalip::adet('TR Dizin kapsamında en az 2 makale', ['1.3'], 2, null, Kalip::DOKTORA_SONRASI, Kalip::indeksTelafisi('TR Dizin yerine SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 2 makale', ['ULUSLARARASI_VE_ESCI'], 2)),
            Kalip::adet('Bunların en az 1\'i tek yazarlı', ['1.3'], 1, 'tek', Kalip::DOKTORA_SONRASI, Kalip::indeksTelafisi('TR Dizin yerine SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 1 makale', ['ULUSLARARASI_VE_ESCI'], 1, 'tek')),
        ]],
    ],

    // ── Profesör (Tablo 3, doçentlik sonrası + Tablo 4 ek faaliyet) ──
    [
        'anahtar' => 'afyon-profesor-egitim-spor',
        'aday_notu' => 'Makale sayıları indeks düzeyine göre ayrı ayrı aranıyor. Yönerge, TR Dizin şartı yerine daha üst indeksten yayın kabul ediyor.',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['egitim', 'spor'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 3 (Eğitim/Spor): Asgari Başvuru Puanı 600, doçentlik sonrası + Tablo 4 ek '
            .'faaliyet. Madde 9/1-g "güzel sanatlar için en az 550, diğer alanlar için en az 700 puan" istiyor.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 3 — Eğitim/Spor Bilimleri', 'cocuklar' => [
            Kalip::toplam(600, Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('SCIE/SSCI/AHCI kapsamında en az 2 makale', ['ULUSLARARASI'], 2, null, Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('Bunların en az 1\'inde Q1-Q3 kapsamında başlıca yazar', ['Q1_Q3'], 1, 'baslica', Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında başlıca yazar olduğu en az 1 makale', ['ULUSLARARASI_VE_ESCI'], 1, 'baslica', Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('TR Dizin kapsamında en az 3 makale', ['1.3'], 3, null, Kalip::DOCENTLIK_SONRASI, Kalip::indeksTelafisi('TR Dizin yerine SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 3 makale', ['ULUSLARARASI_VE_ESCI'], 3)),
            Kalip::adet('Bunların en az 2\'sinde başlıca yazar', ['1.3'], 2, 'baslica', Kalip::DOCENTLIK_SONRASI, Kalip::indeksTelafisi('TR Dizin yerine SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 2 makale', ['ULUSLARARASI_VE_ESCI'], 2, 'baslica')),
            Kalip::beyan('Tablo 4: proje/patent/yurt dışı araştırma vb. en az 1 ek faaliyet'),
        ]],
    ],
    [
        'anahtar' => 'afyon-profesor-fen',
        'aday_notu' => 'Makale sayıları indeks düzeyine göre ayrı ayrı aranıyor. Yönerge, TR Dizin şartı yerine daha üst indeksten yayın kabul ediyor.',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['saglik', 'fen', 'muhendislik', 'ziraat', 'mimarlik'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 3 (Sağlık/Fen/Mühendislik/Ziraat/Mimarlık): Asgari Başvuru Puanı 600, doçentlik '
            .'sonrası + Tablo 4 ek faaliyet. Madde 9/1-g 700 puan istiyor.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 3 — Sağlık/Fen/Mühendislik/Ziraat/Mimarlık', 'cocuklar' => [
            Kalip::toplam(600, Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('SCIE/SSCI Q1-Q3 kapsamında en az 5 makale', ['Q1_Q3'], 5, null, Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('Bunların en az 3\'ünde başlıca yazar', ['Q1_Q3'], 3, 'baslica', Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('TR Dizin kapsamında başlıca yazar olduğu en az 2 makale', ['1.3'], 2, 'baslica', Kalip::DOCENTLIK_SONRASI, Kalip::indeksTelafisi('TR Dizin yerine SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 2 makale', ['ULUSLARARASI_VE_ESCI'], 2, 'baslica')),
            Kalip::beyan('Tablo 4: proje/patent/yurt dışı araştırma vb. en az 1 ek faaliyet'),
        ]],
    ],
    [
        'anahtar' => 'afyon-profesor-sosyal-ilahiyat',
        'aday_notu' => 'Makale sayıları indeks düzeyine göre ayrı ayrı aranıyor. Yönerge, TR Dizin şartı yerine daha üst indeksten yayın kabul ediyor.',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['sosyal', 'ilahiyat'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 3 (Sosyal, Beşeri ve İdari Bilimler / İlahiyat): Asgari Başvuru Puanı 600, '
            .'doçentlik sonrası + Tablo 4 ek faaliyet.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 3 — Sosyal/İlahiyat', 'cocuklar' => [
            Kalip::toplam(600, Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 2 makale', ['ULUSLARARASI_VE_ESCI'], 2, null, Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('Bunların en az 1\'inde başlıca yazar', ['ULUSLARARASI_VE_ESCI'], 1, 'baslica', Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('TR Dizin kapsamında en az 5 makale', ['1.3'], 5, null, Kalip::DOCENTLIK_SONRASI, Kalip::indeksTelafisi('TR Dizin yerine SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 5 makale', ['ULUSLARARASI_VE_ESCI'], 5)),
            Kalip::adet('Bunların en az 3\'ü tek yazarlı', ['1.3'], 3, 'tek', Kalip::DOCENTLIK_SONRASI, Kalip::indeksTelafisi('TR Dizin yerine SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 3 makale', ['ULUSLARARASI_VE_ESCI'], 3, 'tek')),
            Kalip::beyan('Tablo 4: proje/patent/yurt dışı araştırma vb. en az 1 ek faaliyet'),
        ]],
    ],
    [
        'anahtar' => 'afyon-profesor-filoloji',
        'aday_notu' => 'Makale sayıları indeks düzeyine göre ayrı ayrı aranıyor. Yönerge, TR Dizin şartı yerine daha üst indeksten yayın kabul ediyor.',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['filoloji'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 3 (Filoloji): Asgari Başvuru Puanı 600, doçentlik sonrası + Tablo 4 ek faaliyet.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 3 — Filoloji', 'cocuklar' => [
            Kalip::toplam(600, Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında başlıca yazar olduğu en az 1 makale', ['ULUSLARARASI_VE_ESCI'], 1, 'baslica', Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('TR Dizin kapsamında en az 6 makale', ['1.3'], 6, null, Kalip::DOCENTLIK_SONRASI, Kalip::indeksTelafisi('TR Dizin yerine SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 6 makale', ['ULUSLARARASI_VE_ESCI'], 6)),
            Kalip::adet('Bunların en az 3\'ü tek yazarlı', ['1.3'], 3, 'tek', Kalip::DOCENTLIK_SONRASI, Kalip::indeksTelafisi('TR Dizin yerine SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 3 makale', ['ULUSLARARASI_VE_ESCI'], 3, 'tek')),
            Kalip::beyan('Tablo 4: proje/patent/yurt dışı araştırma vb. en az 1 ek faaliyet'),
        ]],
    ],
    [
        'anahtar' => 'afyon-profesor-hukuk',
        'aday_notu' => 'Makale sayıları indeks düzeyine göre ayrı ayrı aranıyor. Yönerge, TR Dizin şartı yerine daha üst indeksten yayın kabul ediyor.',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['hukuk'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 3 (Hukuk): Asgari Başvuru Puanı 600, doçentlik sonrası + Tablo 4 ek faaliyet.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 3 — Hukuk', 'cocuklar' => [
            Kalip::toplam(600, Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında başlıca yazar olduğu en az 1 makale', ['ULUSLARARASI_VE_ESCI'], 1, 'baslica', Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('TR Dizin kapsamında en az 6 makale', ['1.3'], 6, null, Kalip::DOCENTLIK_SONRASI, Kalip::indeksTelafisi('TR Dizin yerine SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 6 makale', ['ULUSLARARASI_VE_ESCI'], 6)),
            Kalip::adet('Bunların en az 4\'ü tek yazarlı', ['1.3'], 4, 'tek', Kalip::DOCENTLIK_SONRASI, Kalip::indeksTelafisi('TR Dizin yerine SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 4 makale', ['ULUSLARARASI_VE_ESCI'], 4, 'tek')),
            Kalip::beyan('Tablo 4: proje/patent/yurt dışı araştırma vb. en az 1 ek faaliyet'),
        ]],
    ],
    [
        'anahtar' => 'afyon-profesor-guzel-sanatlar',
        'aday_notu' => 'Makale sayıları indeks düzeyine göre ayrı ayrı aranıyor. Yönerge, TR Dizin şartı yerine daha üst indeksten yayın kabul ediyor.',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 3 (Güzel Sanatlar): Asgari Başvuru Puanı 450, doçentlik sonrası + Tablo 4 ek faaliyet.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 3 — Güzel Sanatlar', 'cocuklar' => [
            Kalip::toplam(450, Kalip::DOCENTLIK_SONRASI),
            Kalip::beyan('Sanatsal etkinliklerden en az 100 puan (ÜAK özel koşullarına uygun)'),
            Kalip::adet('SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında başlıca yazar olduğu en az 1 makale', ['ULUSLARARASI_VE_ESCI'], 1, 'baslica', Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('TR Dizin kapsamında en az 4 makale', ['1.3'], 4, null, Kalip::DOCENTLIK_SONRASI, Kalip::indeksTelafisi('TR Dizin yerine SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 4 makale', ['ULUSLARARASI_VE_ESCI'], 4)),
            Kalip::adet('Bunların en az 1\'i tek yazarlı', ['1.3'], 1, 'tek', Kalip::DOCENTLIK_SONRASI, Kalip::indeksTelafisi('TR Dizin yerine SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 1 makale', ['ULUSLARARASI_VE_ESCI'], 1, 'tek')),
            Kalip::beyan('Tablo 4: metot/albüm çalışması vb. en az 1 ek faaliyet'),
        ]],
    ],
];
