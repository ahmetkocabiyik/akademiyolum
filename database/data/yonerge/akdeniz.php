<?php

/**
 * AKDENİZ ÜNİVERSİTESİ — şart ağaçları.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · şema: sart-agaci-taslak.php
 * `alan` dizi olabilir: SartDeposu alan başına ayrı kayda açar.
 */
use App\Services\Scoring\Sart\Kalip;

return [
    /*
    ╔══════════════════════════════════════════════════════════════════════════╗
    ║  AKDENİZ ÜNİVERSİTESİ
    ╚══════════════════════════════════════════════════════════════════════════╝
    | Kaynak: pdf/17536928172.akdenizuniversitesi.pdf · Cetvel: akdeniz-2026
    | GRUP 1: Sağlık, Ziraat, Mühendislik, Fen · GRUP 2: Sosyal, Eğitim, Spor,
    | Mimarlık · GRUP 3: Hukuk, İlahiyat, Güzel Sanatlar · GRUP 5: diğerleri
    | (Akdeniz'de Filoloji). Tüm kadrolarda YDS en az 70.
    */

    // ── Dr. Öğr. Üyesi ──
    [
        'anahtar' => 'akdeniz-dr-grup1',
        'aday_notu' => 'Toplam puanın belirli bir oranının makalelerden gelmesi şart; kitap ve bildiriyle barajı doldurmak tek başına yetmiyor.',
        'universite' => 'Akdeniz Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['fen', 'muhendislik', 'saglik', 'ziraat'],
        'cetvel' => 'akdeniz-2026',
        'notlar' => 'Grup 1 (Sağlık/Ziraat/Mühendislik/Fen): en az 3 yayın ve toplamda en az 100 puan. '
            .'Dipnot 3: "Bu puanın en az yarısı 1. Bölüm: Bilimsel Makaleler\'den karşılanmış olmalıdır." '
            .'Tabloda ayrıca: "Son beş yılda üretilen yayınlar değerlendirmeye alınır." · "Aday en az iki '
            .'bilimsel makalesinde başlıca yazar olmalıdır." · "Aday ... yayınlardan birini lisansüstü '
            .'tezinden üretmek zorundadır ... karşılanamaması durumunda asgari yayın sayısına bir yayın '
            .'eklenir." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Grup 1 — Dr. Öğr. Üyesi', 'cocuklar' => [
            Kalip::toplam(100),
            Kalip::adet('Son beş yılda en az 3 yayın', ['YAYIN'], 3, donem: Kalip::sonYil(5)),
            Kalip::adet('En az 2 makalede başlıca yazar', ['BOLUM_1_MAKALE'], 2, 'baslica'),
            ['tip' => 'puan', 'aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden',
                'maddeler' => ['BOLUM_1_MAKALE'], 'min_oran' => 0.5, 'oran_payda' => ['*']],
            Kalip::beyan('Yayınlardan biri lisansüstü tezden üretilmiş olmalı; sağlanamazsa asgari yayın sayısına bir yayın eklenir'),
            Kalip::yds(70),
        ]],
    ],
    [
        'anahtar' => 'akdeniz-dr-grup2',
        'aday_notu' => 'Toplam puanın belirli bir oranının makalelerden gelmesi şart; kitap ve bildiriyle barajı doldurmak tek başına yetmiyor.',
        'universite' => 'Akdeniz Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['sosyal', 'egitim', 'spor', 'mimarlik'],
        'cetvel' => 'akdeniz-2026',
        'notlar' => 'Grup 2: en az 2 yayın ve toplamda en az 100 puan; Tablo dipnotu: "Bu puanın en az '
            .'yarısı 1. Bölüm: Bilimsel Makaleler\'den karşılanmış olmalıdır." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Grup 2 — Dr. Öğr. Üyesi', 'cocuklar' => [
            Kalip::toplam(100),
            Kalip::adet('En az 2 yayın', ['YAYIN'], 2),
            Kalip::adet('En az 1 makalede başlıca yazar', ['BOLUM_1_MAKALE'], 1, 'baslica'),
            ['tip' => 'puan', 'aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden',
                'maddeler' => ['BOLUM_1_MAKALE'], 'min_oran' => 0.5, 'oran_payda' => ['*']],
            Kalip::beyan('Yayınlardan biri lisansüstü tezden üretilmiş olmalı'),
            Kalip::yds(70),
        ]],
    ],
    [
        'anahtar' => 'akdeniz-dr-grup3',
        'aday_notu' => 'Toplam puanın belirli bir oranının makalelerden gelmesi şart; kitap ve bildiriyle barajı doldurmak tek başına yetmiyor.',
        'universite' => 'Akdeniz Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['hukuk', 'ilahiyat'],
        'cetvel' => 'akdeniz-2026',
        'notlar' => 'Grup 3 (Hukuk/İlahiyat): en az 2 yayın ve toplamda en az 100 puan. Tablo dipnotu: '
            .'"Hukuk ve İlahiyat Temel Alanı için bu puanın en az yarısı 1. Bölüm: Bilimsel '
            .'Makaleler\'den karşılanmış olmalıdır." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Grup 3 — Dr. Öğr. Üyesi', 'cocuklar' => [
            Kalip::toplam(100),
            Kalip::adet('En az 2 yayın', ['YAYIN'], 2),
            Kalip::adet('En az 1 makalede başlıca yazar', ['BOLUM_1_MAKALE'], 1, 'baslica'),
            ['tip' => 'puan', 'aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden',
                'maddeler' => ['BOLUM_1_MAKALE'], 'min_oran' => 0.5, 'oran_payda' => ['*']],
            Kalip::beyan('Yayınlardan biri lisansüstü tezden üretilmiş olmalı'),
            Kalip::yds(70),
        ]],
    ],
    [
        // Güzel Sanatlar eski şemada Grup 3 ile aynı satırdaydı; oran farkı
        // (%40 ↔ %50) taşınamadığı için notlarda kalıyordu. Artık ayrı kayıt.
        'anahtar' => 'akdeniz-dr-grup3-gs',
        'aday_notu' => 'Toplam puanın belirli bir oranının makalelerden gelmesi şart; kitap ve bildiriyle barajı doldurmak tek başına yetmiyor.',
        'universite' => 'Akdeniz Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'akdeniz-2026',
        'notlar' => 'Grup 3 (Güzel Sanatlar): en az 2 yayın ve toplamda en az 100 puan. Tablo dipnotu: '
            .'"Güzel Sanatlar Temel Alanı için bu puanın en az %40\'ı 1. Bölüm: Bilimsel '
            .'Makaleler\'den karşılanmış olmalıdır." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Grup 3 (Güzel Sanatlar) — Dr. Öğr. Üyesi', 'cocuklar' => [
            Kalip::toplam(100),
            Kalip::adet('En az 2 yayın', ['YAYIN'], 2),
            Kalip::adet('En az 1 makalede başlıca yazar', ['BOLUM_1_MAKALE'], 1, 'baslica'),
            ['tip' => 'puan', 'aciklama' => 'Toplam puanın en az %40\'ı bilimsel makalelerden',
                'maddeler' => ['BOLUM_1_MAKALE'], 'min_oran' => 0.4, 'oran_payda' => ['*']],
            Kalip::beyan('Yayınlardan biri lisansüstü tezden üretilmiş olmalı'),
            Kalip::yds(70),
        ]],
    ],
    [
        'anahtar' => 'akdeniz-dr-grup5',
        'aday_notu' => 'Toplam puanın belirli bir oranının makalelerden gelmesi şart; kitap ve bildiriyle barajı doldurmak tek başına yetmiyor.',
        'universite' => 'Akdeniz Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['filoloji'],
        'cetvel' => 'akdeniz-2026',
        'notlar' => 'Grup 5 (Diğer Temel Alanlar): en az 2 yayın ve toplamda en az 100 puan; Tablo '
            .'dipnotu: "Bu puanın en az yarısı 1. Bölüm: Bilimsel Makaleler\'den karşılanmış '
            .'olmalıdır." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Grup 5 — Dr. Öğr. Üyesi', 'cocuklar' => [
            Kalip::toplam(100),
            Kalip::adet('En az 2 yayın', ['YAYIN'], 2),
            Kalip::adet('En az 1 makalede başlıca yazar', ['BOLUM_1_MAKALE'], 1, 'baslica'),
            ['tip' => 'puan', 'aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden',
                'maddeler' => ['BOLUM_1_MAKALE'], 'min_oran' => 0.5, 'oran_payda' => ['*']],
            Kalip::beyan('Yayınlardan biri lisansüstü tezden üretilmiş olmalı'),
            Kalip::yds(70),
        ]],
    ],

    // ── Doçent ── (üniversite kadro barajı; ÜAK doçent unvanının üstüne ek şart)
    [
        'anahtar' => 'akdeniz-docent-grup1',
        'aday_notu' => 'Toplam puanın belirli bir oranının makalelerden gelmesi şart; kitap ve bildiriyle barajı doldurmak tek başına yetmiyor.',
        'universite' => 'Akdeniz Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['fen', 'muhendislik', 'saglik', 'ziraat'],
        'cetvel' => 'akdeniz-2026',
        'notlar' => 'Grup 1: toplamda en az 300 puan; Tablo dipnotu: "Bu puanın en az yarısı 1. Bölüm: '
            .'Bilimsel Makaleler\'den karşılanmış olmalıdır." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Grup 1 — Doçent', 'cocuklar' => [
            Kalip::toplam(300),
            Kalip::adet('Doktora/tıpta uzmanlık sonrası en az 2 makalede başlıca yazar', ['BOLUM_1_MAKALE'], 2, 'baslica', Kalip::DOKTORA_SONRASI),
            ['tip' => 'metrik', 'aciklama' => 'BAP/dış kaynaklı projede en az 1 yürütücülük',
                'metrik' => 'proje_yurutuculuk', 'min' => 1],
            ['tip' => 'puan', 'aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden',
                'maddeler' => ['BOLUM_1_MAKALE'], 'min_oran' => 0.5, 'oran_payda' => ['*']],
            Kalip::adet('Yayınların en az 4\'ü doktora sonrası ve son 7 yılda', ['YAYIN'], 4, null,
                ['baslangic' => 'doktora', 'son_yil' => 7]),
            Kalip::yds(70),
        ]],
    ],
    [
        'anahtar' => 'akdeniz-docent-grup2',
        'aday_notu' => 'Toplam puanın belirli bir oranının makalelerden gelmesi şart; kitap ve bildiriyle barajı doldurmak tek başına yetmiyor.',
        'universite' => 'Akdeniz Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['sosyal', 'egitim', 'spor', 'mimarlik'],
        'cetvel' => 'akdeniz-2026',
        'notlar' => 'Grup 2: toplamda en az 300 puan; Tablo dipnotu: "Bu puanın en az yarısı 1. Bölüm: '
            .'Bilimsel Makaleler\'den karşılanmış olmalıdır." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Grup 2 — Doçent', 'cocuklar' => [
            Kalip::toplam(300),
            Kalip::adet('Doktora/sanatta yeterlik sonrası en az 1 makalede başlıca yazar', ['BOLUM_1_MAKALE'], 1, 'baslica', Kalip::DOKTORA_SONRASI),
            ['tip' => 'metrik', 'aciklama' => 'BAP/dış kaynaklı projede en az 1 yürütücülük',
                'metrik' => 'proje_yurutuculuk', 'min' => 1],
            ['tip' => 'puan', 'aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden',
                'maddeler' => ['BOLUM_1_MAKALE'], 'min_oran' => 0.5, 'oran_payda' => ['*']],
            Kalip::adet('Yayınların en az 2\'si doktora sonrası ve son 7 yılda', ['YAYIN'], 2, null,
                ['baslangic' => 'doktora', 'son_yil' => 7]),
            Kalip::yds(70),
        ]],
    ],
    [
        'anahtar' => 'akdeniz-docent-grup3',
        'aday_notu' => 'Toplam puanın belirli bir oranının makalelerden gelmesi şart; kitap ve bildiriyle barajı doldurmak tek başına yetmiyor.',
        'universite' => 'Akdeniz Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['hukuk', 'ilahiyat'],
        'cetvel' => 'akdeniz-2026',
        'notlar' => 'Grup 3 (Hukuk/İlahiyat): toplamda en az 300 puan. Tablo dipnotu: "Hukuk ve İlahiyat '
            .'Temel Alanı için bu puanın en az yarısı 1. Bölüm: Bilimsel Makaleler\'den '
            .'karşılanmış olmalıdır." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Grup 3 — Doçent', 'cocuklar' => [
            Kalip::toplam(300),
            Kalip::adet('Doktora/sanatta yeterlik sonrası en az 2 makalede başlıca yazar', ['BOLUM_1_MAKALE'], 2, 'baslica', Kalip::DOKTORA_SONRASI),
            ['tip' => 'puan', 'aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden',
                'maddeler' => ['BOLUM_1_MAKALE'], 'min_oran' => 0.5, 'oran_payda' => ['*']],
            Kalip::adet('Yayınların en az 4\'ü doktora sonrası ve son 7 yılda', ['YAYIN'], 4, null,
                ['baslangic' => 'doktora', 'son_yil' => 7]),
            Kalip::yds(70),
        ]],
    ],
    [
        'anahtar' => 'akdeniz-docent-grup3-gs',
        'aday_notu' => 'Toplam puanın belirli bir oranının makalelerden gelmesi şart; kitap ve bildiriyle barajı doldurmak tek başına yetmiyor.',
        'universite' => 'Akdeniz Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'akdeniz-2026',
        'notlar' => 'Grup 3 (Güzel Sanatlar): toplamda en az 300 puan. Tablo dipnotu: "Güzel Sanatlar '
            .'Temel Alanı için bu puanın en az %40\'ı 1. Bölüm: Bilimsel Makaleler\'den '
            .'karşılanmış olmalıdır." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Grup 3 (Güzel Sanatlar) — Doçent', 'cocuklar' => [
            Kalip::toplam(300),
            Kalip::adet('Sanatta yeterlik sonrası en az 2 makalede başlıca yazar', ['BOLUM_1_MAKALE'], 2, 'baslica', Kalip::DOKTORA_SONRASI),
            ['tip' => 'puan', 'aciklama' => 'Toplam puanın en az %40\'ı bilimsel makalelerden',
                'maddeler' => ['BOLUM_1_MAKALE'], 'min_oran' => 0.4, 'oran_payda' => ['*']],
            Kalip::adet('Yayınların en az 4\'ü sanatta yeterlik sonrası ve son 7 yılda', ['YAYIN'], 4, null,
                ['baslangic' => 'doktora', 'son_yil' => 7]),
            Kalip::yds(70),
        ]],
    ],
    [
        'anahtar' => 'akdeniz-docent-grup5',
        'aday_notu' => 'Toplam puanın belirli bir oranının makalelerden gelmesi şart; kitap ve bildiriyle barajı doldurmak tek başına yetmiyor.',
        'universite' => 'Akdeniz Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['filoloji'],
        'cetvel' => 'akdeniz-2026',
        'notlar' => 'Grup 5: toplamda en az 300 puan; Tablo dipnotu: "Bu puanın en az yarısı 1. Bölüm: '
            .'Bilimsel Makaleler\'den karşılanmış olmalıdır." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Grup 5 — Doçent', 'cocuklar' => [
            Kalip::toplam(300),
            Kalip::adet('Doktora sonrası en az 2 makalede başlıca yazar', ['BOLUM_1_MAKALE'], 2, 'baslica', Kalip::DOKTORA_SONRASI),
            ['tip' => 'puan', 'aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden',
                'maddeler' => ['BOLUM_1_MAKALE'], 'min_oran' => 0.5, 'oran_payda' => ['*']],
            Kalip::adet('Yayınların en az 4\'ü doktora sonrası ve son 7 yılda', ['YAYIN'], 4, null,
                ['baslangic' => 'doktora', 'son_yil' => 7]),
            Kalip::yds(70),
        ]],
    ],

    // ── Profesör ──
    [
        'anahtar' => 'akdeniz-profesor-grup1',
        'aday_notu' => 'Toplam puanın belirli bir oranının makalelerden gelmesi şart; kitap ve bildiriyle barajı doldurmak tek başına yetmiyor.',
        'universite' => 'Akdeniz Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['fen', 'muhendislik', 'saglik', 'ziraat'],
        'cetvel' => 'akdeniz-2026',
        'notlar' => 'Grup 1: toplamda en az 500 puan; Tablo dipnotu: "Bu puanın en az yarısı 1. Bölüm: '
            .'Bilimsel Makaleler\'den karşılanmış olmalıdır." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Grup 1 — Profesör', 'cocuklar' => [
            Kalip::toplam(500),
            Kalip::adet('Doçentlik sonrası en az 2 makalede başlıca yazar', ['BOLUM_1_MAKALE'], 2, 'baslica', Kalip::DOCENTLIK_SONRASI),
            ['tip' => 'metrik', 'aciklama' => 'BAP/dış kaynaklı projede en az 2 yürütücülük',
                'metrik' => 'proje_yurutuculuk', 'min' => 2],
            ['tip' => 'puan', 'aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden',
                'maddeler' => ['BOLUM_1_MAKALE'], 'min_oran' => 0.5, 'oran_payda' => ['*']],
            Kalip::adet('Yayınların en az 4\'ü doçentlik sonrası ve son 7 yılda', ['YAYIN'], 4, null,
                ['baslangic' => 'docentlik', 'son_yil' => 7]),
            Kalip::yds(70),
        ]],
    ],
    [
        'anahtar' => 'akdeniz-profesor-grup2',
        'aday_notu' => 'Toplam puanın belirli bir oranının makalelerden gelmesi şart; kitap ve bildiriyle barajı doldurmak tek başına yetmiyor.',
        'universite' => 'Akdeniz Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['sosyal', 'egitim', 'spor', 'mimarlik'],
        'cetvel' => 'akdeniz-2026',
        'notlar' => 'Grup 2: toplamda en az 500 puan; Tablo dipnotu: "Bu puanın en az yarısı 1. Bölüm: '
            .'Bilimsel Makaleler\'den karşılanmış olmalıdır." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Grup 2 — Profesör', 'cocuklar' => [
            Kalip::toplam(500),
            Kalip::adet('Doçentlik sonrası en az 2 makalede başlıca yazar', ['BOLUM_1_MAKALE'], 2, 'baslica', Kalip::DOCENTLIK_SONRASI),
            ['tip' => 'metrik', 'aciklama' => 'BAP/dış kaynaklı projede en az 2 yürütücülük',
                'metrik' => 'proje_yurutuculuk', 'min' => 2],
            ['tip' => 'puan', 'aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden',
                'maddeler' => ['BOLUM_1_MAKALE'], 'min_oran' => 0.5, 'oran_payda' => ['*']],
            Kalip::adet('Yayınların en az 2\'si doçentlik sonrası ve son 7 yılda', ['YAYIN'], 2, null,
                ['baslangic' => 'docentlik', 'son_yil' => 7]),
            Kalip::yds(70),
        ]],
    ],
    [
        'anahtar' => 'akdeniz-profesor-grup3',
        'aday_notu' => 'Toplam puanın belirli bir oranının makalelerden gelmesi şart; kitap ve bildiriyle barajı doldurmak tek başına yetmiyor.',
        'universite' => 'Akdeniz Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['hukuk', 'ilahiyat'],
        'cetvel' => 'akdeniz-2026',
        'notlar' => 'Grup 3 (Hukuk/İlahiyat): toplamda en az 500 puan. Tablo dipnotu: "Hukuk ve İlahiyat '
            .'Temel Alanı için bu puanın en az yarısı 1. Bölüm: Bilimsel Makaleler\'den '
            .'karşılanmış olmalıdır." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Grup 3 — Profesör', 'cocuklar' => [
            Kalip::toplam(500),
            Kalip::adet('Doçentlik sonrası en az 2 makalede başlıca yazar', ['BOLUM_1_MAKALE'], 2, 'baslica', Kalip::DOCENTLIK_SONRASI),
            ['tip' => 'puan', 'aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden',
                'maddeler' => ['BOLUM_1_MAKALE'], 'min_oran' => 0.5, 'oran_payda' => ['*']],
            Kalip::adet('Yayınların en az 4\'ü doçentlik sonrası ve son 7 yılda', ['YAYIN'], 4, null,
                ['baslangic' => 'docentlik', 'son_yil' => 7]),
            Kalip::yds(70),
        ]],
    ],
    [
        'anahtar' => 'akdeniz-profesor-grup3-gs',
        'aday_notu' => 'Toplam puanın belirli bir oranının makalelerden gelmesi şart; kitap ve bildiriyle barajı doldurmak tek başına yetmiyor.',
        'universite' => 'Akdeniz Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'akdeniz-2026',
        'notlar' => 'Grup 3 (Güzel Sanatlar): toplamda en az 500 puan. Tablo dipnotu: "Güzel Sanatlar '
            .'Temel Alanı için bu puanın en az %40\'ı 1. Bölüm: Bilimsel Makaleler\'den '
            .'karşılanmış olmalıdır." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Grup 3 (Güzel Sanatlar) — Profesör', 'cocuklar' => [
            Kalip::toplam(500),
            Kalip::adet('Doçentlik sonrası en az 2 makalede başlıca yazar', ['BOLUM_1_MAKALE'], 2, 'baslica', Kalip::DOCENTLIK_SONRASI),
            ['tip' => 'puan', 'aciklama' => 'Toplam puanın en az %40\'ı bilimsel makalelerden',
                'maddeler' => ['BOLUM_1_MAKALE'], 'min_oran' => 0.4, 'oran_payda' => ['*']],
            Kalip::adet('Yayınların en az 4\'ü doçentlik sonrası ve son 7 yılda', ['YAYIN'], 4, null,
                ['baslangic' => 'docentlik', 'son_yil' => 7]),
            Kalip::yds(70),
        ]],
    ],
    [
        'anahtar' => 'akdeniz-profesor-grup5',
        'aday_notu' => 'Toplam puanın belirli bir oranının makalelerden gelmesi şart; kitap ve bildiriyle barajı doldurmak tek başına yetmiyor.',
        'universite' => 'Akdeniz Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['filoloji'],
        'cetvel' => 'akdeniz-2026',
        'notlar' => 'Grup 5: toplamda en az 500 puan; Tablo dipnotu: "Bu puanın en az yarısı 1. Bölüm: '
            .'Bilimsel Makaleler\'den karşılanmış olmalıdır." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Grup 5 — Profesör', 'cocuklar' => [
            Kalip::toplam(500),
            Kalip::adet('Doçentlik sonrası en az 2 makalede başlıca yazar', ['BOLUM_1_MAKALE'], 2, 'baslica', Kalip::DOCENTLIK_SONRASI),
            ['tip' => 'puan', 'aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden',
                'maddeler' => ['BOLUM_1_MAKALE'], 'min_oran' => 0.5, 'oran_payda' => ['*']],
            Kalip::adet('Yayınların en az 4\'ü doçentlik sonrası ve son 7 yılda', ['YAYIN'], 4, null,
                ['baslangic' => 'docentlik', 'son_yil' => 7]),
            Kalip::yds(70),
        ]],
    ],
];
