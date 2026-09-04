<?php

/**
 * AKDENİZ ÜNİVERSİTESİ — şart ağaçları.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · şema: sart-agaci-taslak.php
 * `alan` dizi olabilir: SartDeposu alan başına ayrı kayda açar.
 */
use App\Services\Scoring\Sart\Kalip;

$temel = [
    /*
    ╔══════════════════════════════════════════════════════════════════════════╗
    ║  AKDENİZ ÜNİVERSİTESİ
    ╚══════════════════════════════════════════════════════════════════════════╝
    | Kaynak: pdf/17536928172.akdenizuniversitesi.pdf · Cetvel: akdeniz-2026
    | GRUP 1: Sağlık, Ziraat, Mühendislik, Fen · GRUP 2: Sosyal, Eğitim, Spor,
    | Mimarlık · GRUP 3: Hukuk, İlahiyat, Güzel Sanatlar · GRUP 5: diğerleri
    |
    | GRUP 4 (DEVLET KONSERVATUVARI) GİRİLMEDİ — üst simge dipnotu taraması
    | (04.09.2026) ortaya çıkardı. Kaynakta beş grup var; dördüncüsü "Klasik
    | Batı Müziği / Türk Müziği Yorumculuk, Bestecilik, Orkestra Şefliği,
    | Tiyatro, Bale ve Dans" alanları için ayrı bir tablo ve ayrı bir dipnot
    | taşıyor: "Bu puanın en az yarısı 11.4 DİSİPLİNE ÖZGÜ ETKİNLİK VE
    | FAALİYETLER'den karşılanmış olmalıdır." (GRUP 3'ün dipnotu ise
    | "%40'ı 1. Bölüm: Bilimsel Makaleler'den" diyor ve aşağıda uygulanıyor.)
    |
    | Birinci engel 04.09.2026'da kalktı: 11.4 artık cetvelde
    | (`akdeniz-2026-guzel-sanatlar-*` varyantları). GERİYE KALAN ENGEL BİRİM:
    | ayrım temel alana değil BİRİME bağlı (Antalya Devlet Konservatuvarı ↔
    | Güzel Sanatlar Fakültesi) ve ikisi de `guzel_sanatlar` alanına düşüyor.
    | Ayrı bir `birim` kaydı açmak, `bul()` aynı (üniversite, kadro, alan)
    | için iki aday bulunca YALNIZCA birimi birebir eşleşeni döndürdüğü için
    | birimini "Güzel Sanatlar Fakültesi" yazan adayı kapsam dışı bırakırdı —
    | bugün aldığı GRUP 3 cevabını da kaybederdi.
    |
    | İkinci engel de sürüyor: GRUP 4'ün dipnotu "bu puanın en az YARISI
    | 11.4'ten" diyor, ama 11.4'ün kendi tavanı 16/48/80 (bölüm başlığındaki
    | "%40" kuralının sabite çevrilmiş hâli). 50/150/250 puanlık bir baraj o
    | tavanın çok üstünde kalır; KONVANSIYONLAR "Sağlanamaz eşik yazma"
    | kuralının tarif ettiği durum.
    |
    | SONUÇ: konservatuvar adayı şu an GRUP 3'ün ölçütleriyle değerlendiriliyor
    | (aynı puan barajları, ama "toplamın %40'ı bilimsel makaleden" koşuluyla).
    | Kaynağın konservatuvara koyduğu koşul bu değil; disipline özgü
    | etkinlikleri olan bir aday kendini olduğundan ZOR durumda görür.
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

/*
 * 11. BÖLÜM CETVELE GİRİLDİ (04.09.2026) → EŞİKLER TEMEL ALANA AYRILDI.
 *
 * "Disipline özgü etkinlik ve faaliyetler" kaynakta altı FAKÜLTE tablosuna
 * bölünmüş ve "her temel bilim alanı kendi özel alanından puan alır" diyor.
 * Aynı sözlük etiketi tablodan tabloya farklı puan aldığı için cetvel
 * disipline göre varyantlandı (gerekçe cetvel dosyasının başlığında).
 *
 * Şart ağaçları değişmiyor; yalnızca eşiğin bağlandığı CETVEL değişiyor. Bu
 * yüzden bloklar elle çoğaltılmadı: birden çok alana bakan bir eşik, kendi
 * tablosu olan alanlar için ayrı kayda bölünüyor, geri kalan alanlar temel
 * cetvelde kalıyor.
 */
$disiplin = [
    'spor' => 'spor',                     // 11.1 Spor Bilimleri Fakültesi
    'mimarlik' => 'mimarlik',             // 11.2 Mimarlık Fakültesi
    'sosyal' => 'sosyal',                 // 11.3 Edebiyat + 11.4 İletişim
    'filoloji' => 'edebiyat',             // 11.3 Edebiyat Fakültesi
    'guzel_sanatlar' => 'guzel-sanatlar', // 11.4 Güzel Sanatlar + Konservatuvar
    'ilahiyat' => 'ilahiyat',             // 11.6 İlahiyat Fakültesi
];

$kadroEki = ['dr_ogr_uyesi' => 'dr', 'docentlik' => 'docent', 'profesorluk' => 'profesor'];

$esikler = [];

foreach ($temel as $esik) {
    $ayrilan = array_values(array_intersect(array_keys($disiplin), $esik['alan']));
    $kalan = array_values(array_diff($esik['alan'], $ayrilan));

    if ($kalan !== []) {
        $esikler[] = [...$esik, 'alan' => $kalan];
    }

    foreach ($disiplin as $alan => $ek) {
        if (! in_array($alan, $ayrilan, true)) {
            continue;
        }

        // Anahtara alan eklenmiyor: `SartDeposu::esikler()` zaten `alan`
        // dizisini kayda açarken anahtarın sonuna alanı ekliyor.
        $esikler[] = [...$esik,
            'alan' => [$alan],
            'cetvel' => "akdeniz-2026-{$ek}-{$kadroEki[$esik['kadro']]}",
            'notlar' => $esik['notlar'].' 11. Bölüm (Disipline Özgü Etkinlik ve Faaliyetler) bu '
                .'alanda geçerli; bölüm başlığı "Bu bölümden alınan puan diğer bölümlerden alınan '
                .'puanın %40\'ını geçemez" diyor ve cetvelde bu sınırın kadro başına sabit alt '
                .'sınırı uygulanıyor.',
        ];
    }
}

return $esikler;
