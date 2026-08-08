<?php

/*
|--------------------------------------------------------------------------
| DOĞRULANMIŞ YÖNERGE EŞİKLERİ — şart ağacı biçiminde
|--------------------------------------------------------------------------
|
| `esikler.php`'nin halefi. Şema ve düğüm tipleri: `sart-agaci-taslak.php`.
| Motor: App\Services\Scoring\Sart\SartDegerlendirici.
|
| Eski düz şema (min_toplam + yayin_min + index_min + yds_min + kosullar[])
| bu üç üniversitenin koşullarının bir kısmını taşıyamıyordu ve taşıyamadığı
| her koşul `'bilgi' => true` diye değerlendirme dışı bırakılıyordu. Taşımada
| aşağıdakiler artık GERÇEKTEN HESAPLANIYOR:
|
|   · Akdeniz "toplam puanın en az yarısı 1. Bölüm: Bilimsel Makaleler'den"
|     → min_oran 0.5 (Güzel Sanatlar'da 0.40; eski şemada tek satırdı, ayrıldı)
|   · Akdeniz "yayınların en az 4'ü doktora sonrası ve son 7 yılda"
|     → donem: {baslangic: doktora, son_yil: 7}
|   · Afyon "TR Dizin koşulu yerine SCIE/SSCI/AHCI veya ESCI/Scopus da kabul"
|     → ilgili düğümün `telafi` dalı
|   · Atatürk "makale puanının en az 12 (Hukuk'ta 5) puanı SCIE/SSCI/AHCI/
|     ESCI/SCOPUS kapsamında olmalı" → puan yaprağı
|
| Otomatik doğrulanamayanlar `beyan` düğümü olarak duruyor (proje/sanat/atıf
| maddeleri henüz cetvellerde tanımlı değil — bkz. cetveller-agac.php).
|
| GRUP SATIRI: 'alan' dizi olabilir; dosya sonunda alan başına ayrı kayda
| açılır, böylece motor tarafında hiçbir gruplama/fallback mantığı kalmaz.
|
*/

// ── Ortak düğüm kalıpları ────────────────────────────────────────────────────

/** Merkezi yabancı dil sınavı barajı. */
$yds = fn (int $en_az): array => [
    'tip' => 'metrik',
    'aciklama' => "Merkezi yabancı dil sınavından en az {$en_az} puan",
    'metrik' => 'yds',
    'min' => $en_az,
];

/** Toplam puan barajı. `rol` arayüzün bu düğümü metne bakmadan bulması için. */
$toplam = fn (int $puan, ?array $donem = null): array => array_filter([
    'tip' => 'puan',
    'rol' => 'toplam',
    'aciklama' => "Tüm faaliyetlerden toplam en az {$puan} puan",
    'maddeler' => ['*'],
    'min_puan' => $puan,
    'donem' => $donem,
], fn ($v) => $v !== null);

/** Belirli maddelerden asgari puan. */
$puanDan = fn (string $aciklama, array $maddeler, int $puan, ?array $donem = null): array => array_filter([
    'tip' => 'puan',
    'aciklama' => $aciklama,
    'maddeler' => $maddeler,
    'min_puan' => $puan,
    'donem' => $donem,
], fn ($v) => $v !== null);

/** Adet koşulu. */
$adet = fn (string $aciklama, array $maddeler, int $sayi, ?string $yazar = null, ?array $donem = null, ?array $telafi = null): array => array_filter([
    'tip' => 'adet',
    'aciklama' => $aciklama,
    'maddeler' => $maddeler,
    'min_adet' => $sayi,
    'yazar' => $yazar,
    'donem' => $donem,
    'telafi' => $telafi,
], fn ($v) => $v !== null);

$beyan = fn (string $aciklama): array => ['tip' => 'beyan', 'aciklama' => $aciklama];

// Afyon'un her tabloda tekrarlayan dipnotu: "TR Dizin şartı yerine SCIE/SSCI/
// AHCI veya ESCI/SCOPUS kapsamındaki dergilerde yayımlanmış makaleler de kabul
// edilir." — TR Dizin düğümünün telafi dalı olarak modellendi.
$trTelafi = fn (int $sayi, ?string $yazar = null): array => array_filter([
    'tip' => 'adet',
    'aciklama' => "TR Dizin yerine SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az {$sayi} makale",
    'maddeler' => ['ULUSLARARASI_VE_ESCI'],
    'min_adet' => $sayi,
    'yazar' => $yazar,
], fn ($v) => $v !== null);

$doktoraSonrasi = ['baslangic' => 'doktora', 'son_yil' => null];
$docentlikSonrasi = ['baslangic' => 'docentlik', 'son_yil' => null];

$satirlar = [

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
        'universite' => 'Akdeniz Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['fen', 'muhendislik', 'saglik', 'ziraat'],
        'cetvel' => 'akdeniz-2026',
        'notlar' => 'Grup 1 (Sağlık/Ziraat/Mühendislik/Fen): en az 3 yayın ve toplamda en az 100 puan. YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Grup 1 — Dr. Öğr. Üyesi', 'cocuklar' => [
            $toplam(100),
            $adet('En az 3 yayın', ['YAYIN'], 3),
            $yds(70),
        ]],
    ],
    [
        'anahtar' => 'akdeniz-dr-grup2',
        'universite' => 'Akdeniz Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['sosyal', 'egitim', 'spor', 'mimarlik'],
        'cetvel' => 'akdeniz-2026',
        'notlar' => 'Grup 2: en az 2 yayın ve toplamda en az 100 puan; Tablo dipnotu: "Bu puanın en az '
            .'yarısı 1. Bölüm: Bilimsel Makaleler\'den karşılanmış olmalıdır." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Grup 2 — Dr. Öğr. Üyesi', 'cocuklar' => [
            $toplam(100),
            $adet('En az 2 yayın', ['YAYIN'], 2),
            $adet('En az 1 makalede başlıca yazar', ['BOLUM_1_MAKALE'], 1, 'baslica'),
            ['tip' => 'puan', 'aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden',
                'maddeler' => ['BOLUM_1_MAKALE'], 'min_oran' => 0.5, 'oran_payda' => ['*']],
            $beyan('Yayınlardan biri lisansüstü tezden üretilmiş olmalı'),
            $yds(70),
        ]],
    ],
    [
        'anahtar' => 'akdeniz-dr-grup3',
        'universite' => 'Akdeniz Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['hukuk', 'ilahiyat'],
        'cetvel' => 'akdeniz-2026',
        'notlar' => 'Grup 3 (Hukuk/İlahiyat): en az 2 yayın ve toplamda en az 100 puan. Tablo dipnotu: '
            .'"Hukuk ve İlahiyat Temel Alanı için bu puanın en az yarısı 1. Bölüm: Bilimsel '
            .'Makaleler\'den karşılanmış olmalıdır." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Grup 3 — Dr. Öğr. Üyesi', 'cocuklar' => [
            $toplam(100),
            $adet('En az 2 yayın', ['YAYIN'], 2),
            $adet('En az 1 makalede başlıca yazar', ['BOLUM_1_MAKALE'], 1, 'baslica'),
            ['tip' => 'puan', 'aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden',
                'maddeler' => ['BOLUM_1_MAKALE'], 'min_oran' => 0.5, 'oran_payda' => ['*']],
            $beyan('Yayınlardan biri lisansüstü tezden üretilmiş olmalı'),
            $yds(70),
        ]],
    ],
    [
        // Güzel Sanatlar eski şemada Grup 3 ile aynı satırdaydı; oran farkı
        // (%40 ↔ %50) taşınamadığı için notlarda kalıyordu. Artık ayrı kayıt.
        'anahtar' => 'akdeniz-dr-grup3-gs',
        'universite' => 'Akdeniz Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'akdeniz-2026',
        'notlar' => 'Grup 3 (Güzel Sanatlar): en az 2 yayın ve toplamda en az 100 puan. Tablo dipnotu: '
            .'"Güzel Sanatlar Temel Alanı için bu puanın en az %40\'ı 1. Bölüm: Bilimsel '
            .'Makaleler\'den karşılanmış olmalıdır." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Grup 3 (Güzel Sanatlar) — Dr. Öğr. Üyesi', 'cocuklar' => [
            $toplam(100),
            $adet('En az 2 yayın', ['YAYIN'], 2),
            $adet('En az 1 makalede başlıca yazar', ['BOLUM_1_MAKALE'], 1, 'baslica'),
            ['tip' => 'puan', 'aciklama' => 'Toplam puanın en az %40\'ı bilimsel makalelerden',
                'maddeler' => ['BOLUM_1_MAKALE'], 'min_oran' => 0.4, 'oran_payda' => ['*']],
            $beyan('Yayınlardan biri lisansüstü tezden üretilmiş olmalı'),
            $yds(70),
        ]],
    ],
    [
        'anahtar' => 'akdeniz-dr-grup5',
        'universite' => 'Akdeniz Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['filoloji'],
        'cetvel' => 'akdeniz-2026',
        'notlar' => 'Grup 5 (Diğer Temel Alanlar): en az 2 yayın ve toplamda en az 100 puan; Tablo '
            .'dipnotu: "Bu puanın en az yarısı 1. Bölüm: Bilimsel Makaleler\'den karşılanmış '
            .'olmalıdır." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Grup 5 — Dr. Öğr. Üyesi', 'cocuklar' => [
            $toplam(100),
            $adet('En az 2 yayın', ['YAYIN'], 2),
            $adet('En az 1 makalede başlıca yazar', ['BOLUM_1_MAKALE'], 1, 'baslica'),
            ['tip' => 'puan', 'aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden',
                'maddeler' => ['BOLUM_1_MAKALE'], 'min_oran' => 0.5, 'oran_payda' => ['*']],
            $beyan('Yayınlardan biri lisansüstü tezden üretilmiş olmalı'),
            $yds(70),
        ]],
    ],

    // ── Doçent ── (üniversite kadro barajı; ÜAK doçent unvanının üstüne ek şart)
    [
        'anahtar' => 'akdeniz-docent-grup1',
        'universite' => 'Akdeniz Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['fen', 'muhendislik', 'saglik', 'ziraat'],
        'cetvel' => 'akdeniz-2026',
        'notlar' => 'Grup 1: toplamda en az 300 puan; Tablo dipnotu: "Bu puanın en az yarısı 1. Bölüm: '
            .'Bilimsel Makaleler\'den karşılanmış olmalıdır." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Grup 1 — Doçent', 'cocuklar' => [
            $toplam(300),
            $adet('Doçentlik sonrası en az 2 makalede başlıca yazar', ['BOLUM_1_MAKALE'], 2, 'baslica', $docentlikSonrasi),
            ['tip' => 'metrik', 'aciklama' => 'BAP/dış kaynaklı projede en az 1 yürütücülük',
                'metrik' => 'proje_yurutuculuk', 'min' => 1],
            ['tip' => 'puan', 'aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden',
                'maddeler' => ['BOLUM_1_MAKALE'], 'min_oran' => 0.5, 'oran_payda' => ['*']],
            $adet('Yayınların en az 4\'ü doktora sonrası ve son 7 yılda', ['YAYIN'], 4, null,
                ['baslangic' => 'doktora', 'son_yil' => 7]),
            $yds(70),
        ]],
    ],
    [
        'anahtar' => 'akdeniz-docent-grup2',
        'universite' => 'Akdeniz Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['sosyal', 'egitim', 'spor', 'mimarlik'],
        'cetvel' => 'akdeniz-2026',
        'notlar' => 'Grup 2: toplamda en az 300 puan; Tablo dipnotu: "Bu puanın en az yarısı 1. Bölüm: '
            .'Bilimsel Makaleler\'den karşılanmış olmalıdır." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Grup 2 — Doçent', 'cocuklar' => [
            $toplam(300),
            $adet('Doçentlik sonrası en az 2 makalede başlıca yazar', ['BOLUM_1_MAKALE'], 2, 'baslica', $docentlikSonrasi),
            ['tip' => 'metrik', 'aciklama' => 'BAP/dış kaynaklı projede en az 1 yürütücülük',
                'metrik' => 'proje_yurutuculuk', 'min' => 1],
            ['tip' => 'puan', 'aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden',
                'maddeler' => ['BOLUM_1_MAKALE'], 'min_oran' => 0.5, 'oran_payda' => ['*']],
            $adet('Yayınların en az 2\'si doktora sonrası ve son 7 yılda', ['YAYIN'], 2, null,
                ['baslangic' => 'doktora', 'son_yil' => 7]),
            $yds(70),
        ]],
    ],
    [
        'anahtar' => 'akdeniz-docent-grup3',
        'universite' => 'Akdeniz Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['hukuk', 'ilahiyat'],
        'cetvel' => 'akdeniz-2026',
        'notlar' => 'Grup 3 (Hukuk/İlahiyat): toplamda en az 300 puan. Tablo dipnotu: "Hukuk ve İlahiyat '
            .'Temel Alanı için bu puanın en az yarısı 1. Bölüm: Bilimsel Makaleler\'den '
            .'karşılanmış olmalıdır." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Grup 3 — Doçent', 'cocuklar' => [
            $toplam(300),
            $adet('Doktora/sanatta yeterlik sonrası en az 2 makalede başlıca yazar', ['BOLUM_1_MAKALE'], 2, 'baslica', $doktoraSonrasi),
            ['tip' => 'puan', 'aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden',
                'maddeler' => ['BOLUM_1_MAKALE'], 'min_oran' => 0.5, 'oran_payda' => ['*']],
            $adet('Yayınların en az 4\'ü doktora sonrası ve son 7 yılda', ['YAYIN'], 4, null,
                ['baslangic' => 'doktora', 'son_yil' => 7]),
            $yds(70),
        ]],
    ],
    [
        'anahtar' => 'akdeniz-docent-grup3-gs',
        'universite' => 'Akdeniz Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'akdeniz-2026',
        'notlar' => 'Grup 3 (Güzel Sanatlar): toplamda en az 300 puan. Tablo dipnotu: "Güzel Sanatlar '
            .'Temel Alanı için bu puanın en az %40\'ı 1. Bölüm: Bilimsel Makaleler\'den '
            .'karşılanmış olmalıdır." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Grup 3 (Güzel Sanatlar) — Doçent', 'cocuklar' => [
            $toplam(300),
            $adet('Sanatta yeterlik sonrası en az 2 makalede başlıca yazar', ['BOLUM_1_MAKALE'], 2, 'baslica', $doktoraSonrasi),
            ['tip' => 'puan', 'aciklama' => 'Toplam puanın en az %40\'ı bilimsel makalelerden',
                'maddeler' => ['BOLUM_1_MAKALE'], 'min_oran' => 0.4, 'oran_payda' => ['*']],
            $adet('Yayınların en az 4\'ü sanatta yeterlik sonrası ve son 7 yılda', ['YAYIN'], 4, null,
                ['baslangic' => 'doktora', 'son_yil' => 7]),
            $yds(70),
        ]],
    ],
    [
        'anahtar' => 'akdeniz-docent-grup5',
        'universite' => 'Akdeniz Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['filoloji'],
        'cetvel' => 'akdeniz-2026',
        'notlar' => 'Grup 5: toplamda en az 300 puan; Tablo dipnotu: "Bu puanın en az yarısı 1. Bölüm: '
            .'Bilimsel Makaleler\'den karşılanmış olmalıdır." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Grup 5 — Doçent', 'cocuklar' => [
            $toplam(300),
            $adet('Doktora sonrası en az 2 makalede başlıca yazar', ['BOLUM_1_MAKALE'], 2, 'baslica', $doktoraSonrasi),
            ['tip' => 'puan', 'aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden',
                'maddeler' => ['BOLUM_1_MAKALE'], 'min_oran' => 0.5, 'oran_payda' => ['*']],
            $adet('Yayınların en az 4\'ü doktora sonrası ve son 7 yılda', ['YAYIN'], 4, null,
                ['baslangic' => 'doktora', 'son_yil' => 7]),
            $yds(70),
        ]],
    ],

    // ── Profesör ──
    [
        'anahtar' => 'akdeniz-profesor-grup1',
        'universite' => 'Akdeniz Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['fen', 'muhendislik', 'saglik', 'ziraat'],
        'cetvel' => 'akdeniz-2026',
        'notlar' => 'Grup 1: toplamda en az 500 puan; Tablo dipnotu: "Bu puanın en az yarısı 1. Bölüm: '
            .'Bilimsel Makaleler\'den karşılanmış olmalıdır." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Grup 1 — Profesör', 'cocuklar' => [
            $toplam(500),
            $adet('Doçentlik sonrası en az 2 makalede başlıca yazar', ['BOLUM_1_MAKALE'], 2, 'baslica', $docentlikSonrasi),
            ['tip' => 'metrik', 'aciklama' => 'BAP/dış kaynaklı projede en az 2 yürütücülük',
                'metrik' => 'proje_yurutuculuk', 'min' => 2],
            ['tip' => 'puan', 'aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden',
                'maddeler' => ['BOLUM_1_MAKALE'], 'min_oran' => 0.5, 'oran_payda' => ['*']],
            $adet('Yayınların en az 4\'ü doçentlik sonrası ve son 7 yılda', ['YAYIN'], 4, null,
                ['baslangic' => 'docentlik', 'son_yil' => 7]),
            $yds(70),
        ]],
    ],
    [
        'anahtar' => 'akdeniz-profesor-grup2',
        'universite' => 'Akdeniz Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['sosyal', 'egitim', 'spor', 'mimarlik'],
        'cetvel' => 'akdeniz-2026',
        'notlar' => 'Grup 2: toplamda en az 500 puan; Tablo dipnotu: "Bu puanın en az yarısı 1. Bölüm: '
            .'Bilimsel Makaleler\'den karşılanmış olmalıdır." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Grup 2 — Profesör', 'cocuklar' => [
            $toplam(500),
            $adet('Doçentlik sonrası en az 2 makalede başlıca yazar', ['BOLUM_1_MAKALE'], 2, 'baslica', $docentlikSonrasi),
            ['tip' => 'metrik', 'aciklama' => 'BAP/dış kaynaklı projede en az 2 yürütücülük',
                'metrik' => 'proje_yurutuculuk', 'min' => 2],
            ['tip' => 'puan', 'aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden',
                'maddeler' => ['BOLUM_1_MAKALE'], 'min_oran' => 0.5, 'oran_payda' => ['*']],
            $adet('Yayınların en az 2\'si doçentlik sonrası ve son 7 yılda', ['YAYIN'], 2, null,
                ['baslangic' => 'docentlik', 'son_yil' => 7]),
            $yds(70),
        ]],
    ],
    [
        'anahtar' => 'akdeniz-profesor-grup3',
        'universite' => 'Akdeniz Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['hukuk', 'ilahiyat'],
        'cetvel' => 'akdeniz-2026',
        'notlar' => 'Grup 3 (Hukuk/İlahiyat): toplamda en az 500 puan. Tablo dipnotu: "Hukuk ve İlahiyat '
            .'Temel Alanı için bu puanın en az yarısı 1. Bölüm: Bilimsel Makaleler\'den '
            .'karşılanmış olmalıdır." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Grup 3 — Profesör', 'cocuklar' => [
            $toplam(500),
            $adet('Doçentlik sonrası en az 2 makalede başlıca yazar', ['BOLUM_1_MAKALE'], 2, 'baslica', $docentlikSonrasi),
            ['tip' => 'puan', 'aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden',
                'maddeler' => ['BOLUM_1_MAKALE'], 'min_oran' => 0.5, 'oran_payda' => ['*']],
            $adet('Yayınların en az 4\'ü doçentlik sonrası ve son 7 yılda', ['YAYIN'], 4, null,
                ['baslangic' => 'docentlik', 'son_yil' => 7]),
            $yds(70),
        ]],
    ],
    [
        'anahtar' => 'akdeniz-profesor-grup3-gs',
        'universite' => 'Akdeniz Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'akdeniz-2026',
        'notlar' => 'Grup 3 (Güzel Sanatlar): toplamda en az 500 puan. Tablo dipnotu: "Güzel Sanatlar '
            .'Temel Alanı için bu puanın en az %40\'ı 1. Bölüm: Bilimsel Makaleler\'den '
            .'karşılanmış olmalıdır." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Grup 3 (Güzel Sanatlar) — Profesör', 'cocuklar' => [
            $toplam(500),
            $adet('Doçentlik sonrası en az 2 makalede başlıca yazar', ['BOLUM_1_MAKALE'], 2, 'baslica', $docentlikSonrasi),
            ['tip' => 'puan', 'aciklama' => 'Toplam puanın en az %40\'ı bilimsel makalelerden',
                'maddeler' => ['BOLUM_1_MAKALE'], 'min_oran' => 0.4, 'oran_payda' => ['*']],
            $adet('Yayınların en az 4\'ü doçentlik sonrası ve son 7 yılda', ['YAYIN'], 4, null,
                ['baslangic' => 'docentlik', 'son_yil' => 7]),
            $yds(70),
        ]],
    ],
    [
        'anahtar' => 'akdeniz-profesor-grup5',
        'universite' => 'Akdeniz Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['filoloji'],
        'cetvel' => 'akdeniz-2026',
        'notlar' => 'Grup 5: toplamda en az 500 puan; Tablo dipnotu: "Bu puanın en az yarısı 1. Bölüm: '
            .'Bilimsel Makaleler\'den karşılanmış olmalıdır." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Grup 5 — Profesör', 'cocuklar' => [
            $toplam(500),
            $adet('Doçentlik sonrası en az 2 makalede başlıca yazar', ['BOLUM_1_MAKALE'], 2, 'baslica', $docentlikSonrasi),
            ['tip' => 'puan', 'aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden',
                'maddeler' => ['BOLUM_1_MAKALE'], 'min_oran' => 0.5, 'oran_payda' => ['*']],
            $adet('Yayınların en az 4\'ü doçentlik sonrası ve son 7 yılda', ['YAYIN'], 4, null,
                ['baslangic' => 'docentlik', 'son_yil' => 7]),
            $yds(70),
        ]],
    ],

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
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['egitim', 'spor'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 1 (Eğitim/Spor): Asgari Başvuru Puanı 180. Madde 7/1-ç ise şunu istiyor: '
            .'"...Ek-1\'de yer alan tablodaki maddelerden toplamda en az 200 puan almış olmak."',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 1 — Eğitim/Spor Bilimleri', 'cocuklar' => [
            $toplam(180),
            $adet('SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 1 makale', ['ULUSLARARASI_VE_ESCI'], 1),
            $adet('TR Dizin kapsamında en az 2 makale', ['1.3'], 2, null, null, $trTelafi(2)),
        ]],
    ],
    [
        'anahtar' => 'afyon-dr-saglik',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['saglik'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 1 (Sağlık Bilimleri): Asgari Başvuru Puanı 180. Madde 7/1-ç toplamda en az 200 puan istiyor.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 1 — Sağlık Bilimleri', 'cocuklar' => [
            $toplam(180),
            $adet('SCIE/SSCI/AHCI kapsamında en az 2 makale', ['ULUSLARARASI'], 2),
            $adet('TR Dizin kapsamında en az 1 makale', ['1.3'], 1, null, null, $trTelafi(1)),
        ]],
    ],
    [
        'anahtar' => 'afyon-dr-fen',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['fen', 'muhendislik', 'ziraat'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 1 (Fen/Mühendislik/Ziraat): Asgari Başvuru Puanı 180. Madde 7/1-ç toplamda en az 200 puan istiyor.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 1 — Fen/Mühendislik/Ziraat', 'cocuklar' => [
            $toplam(180),
            $adet('SCIE/SSCI/AHCI kapsamında en az 2 makale', ['ULUSLARARASI'], 2),
            $adet('TR Dizin kapsamında en az 1 makale', ['1.3'], 1, null, null, $trTelafi(1)),
        ]],
    ],
    [
        'anahtar' => 'afyon-dr-mimarlik',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['mimarlik'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 1 (Mimarlık/Matematik/İstatistik): Asgari Başvuru Puanı 180. Projede tek `fen` '
            .'alanı olduğu için Afyon\'un Matematik/İstatistik grubu bu satıra değil Fen satırına bağlı.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 1 — Mimarlık, Planlama ve Tasarım', 'cocuklar' => [
            $toplam(180),
            $adet('SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 2 makale', ['ULUSLARARASI_VE_ESCI'], 2),
            $adet('Bunlardan en az 1 tanesi SCIE/SSCI/AHCI kapsamında', ['ULUSLARARASI'], 1),
            $adet('TR Dizin kapsamında en az 1 makale', ['1.3'], 1, null, null, $trTelafi(1)),
        ]],
    ],
    [
        'anahtar' => 'afyon-dr-sosyal',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['sosyal'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 1 (Sosyal, Beşeri ve İdari Bilimler): Asgari Başvuru Puanı 180.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 1 — Sosyal, Beşeri ve İdari Bilimler', 'cocuklar' => [
            $toplam(180),
            $adet('SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 1 makale', ['ULUSLARARASI_VE_ESCI'], 1),
            $adet('TR Dizin kapsamında en az 2 makale', ['1.3'], 2, null, null, $trTelafi(2)),
        ]],
    ],
    [
        'anahtar' => 'afyon-dr-filoloji-ilahiyat',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['filoloji', 'ilahiyat'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 1 (Filoloji/İlahiyat): Asgari Başvuru Puanı 180.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 1 — Filoloji/İlahiyat', 'cocuklar' => [
            $toplam(180),
            $adet('SCIE/SSCI/AHCI, ESCI/Scopus veya TR Dizin kapsamında en az 4 makale', ['ULUSLARARASI_VE_ESCI', '1.3'], 4),
        ]],
    ],
    [
        'anahtar' => 'afyon-dr-hukuk',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['hukuk'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 1 (Hukuk): üç seçenekten biri + Asgari Başvuru Puanı 180. Üçüncü seçenek iki '
            .'koşulu "ve" ile bağlıyor: "1.3. maddesinden yayımlanmış en az 2 makalesi olmak ve 3.1 '
            .'veya 3.2 maddelerinden yayımlanmış tek yazarlı özgün bilimsel en az 1 kitabı olmak."',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 1 — Hukuk', 'cocuklar' => [
            $toplam(180),
            ['tip' => 'veya', 'aciklama' => 'Üç seçenekten biri', 'cocuklar' => [
                $adet('SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 2 makale', ['ULUSLARARASI_VE_ESCI'], 2),
                $adet('TR Dizin kapsamında en az 4 makale', ['1.3'], 4),
                ['tip' => 've', 'aciklama' => 'TR Dizin\'den 2 makale ve tek yazarlı 1 kitap', 'cocuklar' => [
                    $adet('TR Dizin kapsamında en az 2 makale', ['1.3'], 2),
                    $adet('Tek yazarlı en az 1 kitap', ['KITAP'], 1, 'tek'),
                ]],
            ]],
        ]],
    ],
    [
        'anahtar' => 'afyon-dr-guzel-sanatlar',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 1 (Güzel Sanatlar): Asgari Başvuru Puanı 180. 9.x sanatsal etkinlik maddeleri '
            .'cetvele henüz girilmedi; o koşul beyan olarak duruyor.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 1 — Güzel Sanatlar', 'cocuklar' => [
            $toplam(180),
            $adet('SCIE/SSCI/AHCI, ESCI/Scopus veya TR Dizin kapsamında en az 3 makale', ['ULUSLARARASI_VE_ESCI', '1.3'], 3),
            $beyan('Sanatsal etkinliklerden (sergi, gösterim, tasarım) en az 60 puan'),
        ]],
    ],

    // ── Doçent (Tablo 2, doktora sonrası) ──
    [
        'anahtar' => 'afyon-docent-egitim-spor',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['egitim', 'spor'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 2 (Eğitim/Spor): Asgari Başvuru Puanı 500, doktora sonrası. Madde 8/1-ç ise '
            .'"güzel sanatlar alanı için en az 450, diğer alanlar için en az 600 puan" istiyor.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 2 — Eğitim/Spor Bilimleri', 'cocuklar' => [
            $toplam(500, $doktoraSonrasi),
            $adet('SCIE/SSCI/AHCI kapsamında en az 2 makale', ['ULUSLARARASI'], 2, null, $doktoraSonrasi),
            $adet('Bunların en az 1\'inde Q1-Q3 kapsamında başlıca yazar', ['Q1_Q3'], 1, 'baslica', $doktoraSonrasi),
            $adet('TR Dizin kapsamında en az 4 makale', ['1.3'], 4, null, $doktoraSonrasi, $trTelafi(4)),
            $adet('Bunların en az 2\'sinde başlıca yazar', ['1.3'], 2, 'baslica', $doktoraSonrasi, $trTelafi(2, 'baslica')),
        ]],
    ],
    [
        'anahtar' => 'afyon-docent-saglik',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['saglik'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 2 (Sağlık Bilimleri): Asgari Başvuru Puanı 500, doktora sonrası. Madde 8/1-ç 600 puan istiyor.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 2 — Sağlık Bilimleri', 'cocuklar' => [
            $toplam(500, $doktoraSonrasi),
            $adet('SCIE/SSCI Q1-Q3 kapsamında en az 4 makale', ['Q1_Q3'], 4, null, $doktoraSonrasi),
            $adet('Bunların en az 3\'ünde başlıca yazar', ['Q1_Q3'], 3, 'baslica', $doktoraSonrasi),
            $adet('TR Dizin kapsamında başlıca yazar olduğu en az 2 makale', ['1.3'], 2, 'baslica', $doktoraSonrasi, $trTelafi(2, 'baslica')),
        ]],
    ],
    [
        'anahtar' => 'afyon-docent-fen',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['fen', 'muhendislik', 'ziraat'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 2 (Fen/Mühendislik/Ziraat): Asgari Başvuru Puanı 500, doktora sonrası. Madde 8/1-ç 600 puan istiyor.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 2 — Fen/Mühendislik/Ziraat', 'cocuklar' => [
            $toplam(500, $doktoraSonrasi),
            $adet('SCIE/SSCI Q1-Q3 kapsamında en az 4 makale', ['Q1_Q3'], 4, null, $doktoraSonrasi),
            $adet('Bunların en az 2\'sinde başlıca yazar', ['Q1_Q3'], 2, 'baslica', $doktoraSonrasi),
            $adet('TR Dizin kapsamında başlıca yazar olduğu en az 2 makale', ['1.3'], 2, 'baslica', $doktoraSonrasi, $trTelafi(2, 'baslica')),
        ]],
    ],
    [
        'anahtar' => 'afyon-docent-mimarlik',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['mimarlik'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 2 (Mimarlık/Matematik/İstatistik): Asgari Başvuru Puanı 500, doktora sonrası.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 2 — Mimarlık, Planlama ve Tasarım', 'cocuklar' => [
            $toplam(500, $doktoraSonrasi),
            $adet('SCIE/SSCI Q1-Q3 kapsamında en az 4 makale', ['Q1_Q3'], 4, null, $doktoraSonrasi),
            $adet('Bunların en az 1\'inde başlıca yazar', ['Q1_Q3'], 1, 'baslica', $doktoraSonrasi),
            $adet('TR Dizin kapsamında başlıca yazar olduğu en az 2 makale', ['1.3'], 2, 'baslica', $doktoraSonrasi, $trTelafi(2, 'baslica')),
        ]],
    ],
    [
        'anahtar' => 'afyon-docent-sosyal',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['sosyal'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 2 (Sosyal, Beşeri ve İdari Bilimler): Asgari Başvuru Puanı 500, doktora sonrası.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 2 — Sosyal, Beşeri ve İdari Bilimler', 'cocuklar' => [
            $toplam(500, $doktoraSonrasi),
            $adet('SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında başlıca yazar olduğu en az 1 makale', ['ULUSLARARASI_VE_ESCI'], 1, 'baslica', $doktoraSonrasi),
            $adet('TR Dizin kapsamında en az 5 makale', ['1.3'], 5, null, $doktoraSonrasi, $trTelafi(5)),
            $adet('Bunların en az 3\'ü tek yazarlı', ['1.3'], 3, 'tek', $doktoraSonrasi, $trTelafi(3, 'tek')),
            ['tip' => 'veya', 'aciklama' => 'En az 1 kitap veya en az 2 kitap bölümü', 'cocuklar' => [
                $adet('En az 1 kitap', ['KITAP'], 1, null, $doktoraSonrasi),
                $adet('En az 2 kitap bölümü', ['KITAP_BOLUM'], 2, null, $doktoraSonrasi),
            ]],
        ]],
    ],
    [
        'anahtar' => 'afyon-docent-ilahiyat',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['ilahiyat'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 2 (İlahiyat): Asgari Başvuru Puanı 500, doktora sonrası.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 2 — İlahiyat', 'cocuklar' => [
            $toplam(500, $doktoraSonrasi),
            $adet('SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında başlıca yazar olduğu en az 1 makale', ['ULUSLARARASI_VE_ESCI'], 1, 'baslica', $doktoraSonrasi),
            $adet('TR Dizin kapsamında en az 5 makale', ['1.3'], 5, null, $doktoraSonrasi, $trTelafi(5)),
            $adet('Bunların en az 3\'ü tek yazarlı', ['1.3'], 3, 'tek', $doktoraSonrasi, $trTelafi(3, 'tek')),
            $adet('Tek yazarlı en az 1 kitap', ['KITAP'], 1, 'tek', $doktoraSonrasi),
        ]],
    ],
    [
        'anahtar' => 'afyon-docent-filoloji',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['filoloji'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 2 (Filoloji): Asgari Başvuru Puanı 500, doktora sonrası.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 2 — Filoloji', 'cocuklar' => [
            $toplam(500, $doktoraSonrasi),
            $adet('SCIE/SSCI/AHCI, ESCI/Scopus veya TR Dizin kapsamında en az 6 makale', ['ULUSLARARASI_VE_ESCI', '1.3'], 6, null, $doktoraSonrasi),
            $adet('Bunların en az 3\'ü tek yazarlı', ['ULUSLARARASI_VE_ESCI', '1.3'], 3, 'tek', $doktoraSonrasi),
            $adet('Tek yazarlı en az 1 kitap', ['KITAP'], 1, 'tek', $doktoraSonrasi),
        ]],
    ],
    [
        'anahtar' => 'afyon-docent-hukuk',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['hukuk'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 2 (Hukuk): Asgari Başvuru Puanı 500, doktora sonrası.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 2 — Hukuk', 'cocuklar' => [
            $toplam(500, $doktoraSonrasi),
            $adet('SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 1 makale', ['ULUSLARARASI_VE_ESCI'], 1, null, $doktoraSonrasi),
            $adet('TR Dizin kapsamında en az 6 makale', ['1.3'], 6, null, $doktoraSonrasi, $trTelafi(6)),
            $adet('Bunların en az 4\'ü tek yazarlı', ['1.3'], 4, 'tek', $doktoraSonrasi, $trTelafi(4, 'tek')),
            $adet('Tek yazarlı en az 1 kitap', ['KITAP'], 1, 'tek', $doktoraSonrasi),
        ]],
    ],
    [
        'anahtar' => 'afyon-docent-guzel-sanatlar',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 2 (Güzel Sanatlar): Asgari Başvuru Puanı 350, doktora sonrası. Madde 8/1-ç '
            .'güzel sanatlar için 450 puan istiyor.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 2 — Güzel Sanatlar', 'cocuklar' => [
            $toplam(350, $doktoraSonrasi),
            $beyan('Sanatsal etkinliklerden en az 100 puan (ÜAK özel koşullarına uygun)'),
            $adet('SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında başlıca yazar olduğu en az 1 makale', ['ULUSLARARASI_VE_ESCI'], 1, 'baslica', $doktoraSonrasi),
            $adet('TR Dizin kapsamında en az 2 makale', ['1.3'], 2, null, $doktoraSonrasi, $trTelafi(2)),
            $adet('Bunların en az 1\'i tek yazarlı', ['1.3'], 1, 'tek', $doktoraSonrasi, $trTelafi(1, 'tek')),
        ]],
    ],

    // ── Profesör (Tablo 3, doçentlik sonrası + Tablo 4 ek faaliyet) ──
    [
        'anahtar' => 'afyon-profesor-egitim-spor',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['egitim', 'spor'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 3 (Eğitim/Spor): Asgari Başvuru Puanı 600, doçentlik sonrası + Tablo 4 ek '
            .'faaliyet. Madde 9/1-g "güzel sanatlar için en az 550, diğer alanlar için en az 700 puan" istiyor.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 3 — Eğitim/Spor Bilimleri', 'cocuklar' => [
            $toplam(600, $docentlikSonrasi),
            $adet('SCIE/SSCI/AHCI kapsamında en az 2 makale', ['ULUSLARARASI'], 2, null, $docentlikSonrasi),
            $adet('Bunların en az 1\'inde Q1-Q3 kapsamında başlıca yazar', ['Q1_Q3'], 1, 'baslica', $docentlikSonrasi),
            $adet('SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında başlıca yazar olduğu en az 1 makale', ['ULUSLARARASI_VE_ESCI'], 1, 'baslica', $docentlikSonrasi),
            $adet('TR Dizin kapsamında en az 3 makale', ['1.3'], 3, null, $docentlikSonrasi, $trTelafi(3)),
            $adet('Bunların en az 2\'sinde başlıca yazar', ['1.3'], 2, 'baslica', $docentlikSonrasi, $trTelafi(2, 'baslica')),
            $beyan('Tablo 4: proje/patent/yurt dışı araştırma vb. en az 1 ek faaliyet'),
        ]],
    ],
    [
        'anahtar' => 'afyon-profesor-fen',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['saglik', 'fen', 'muhendislik', 'ziraat', 'mimarlik'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 3 (Sağlık/Fen/Mühendislik/Ziraat/Mimarlık): Asgari Başvuru Puanı 600, doçentlik '
            .'sonrası + Tablo 4 ek faaliyet. Madde 9/1-g 700 puan istiyor.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 3 — Sağlık/Fen/Mühendislik/Ziraat/Mimarlık', 'cocuklar' => [
            $toplam(600, $docentlikSonrasi),
            $adet('SCIE/SSCI Q1-Q3 kapsamında en az 5 makale', ['Q1_Q3'], 5, null, $docentlikSonrasi),
            $adet('Bunların en az 3\'ünde başlıca yazar', ['Q1_Q3'], 3, 'baslica', $docentlikSonrasi),
            $adet('TR Dizin kapsamında başlıca yazar olduğu en az 2 makale', ['1.3'], 2, 'baslica', $docentlikSonrasi, $trTelafi(2, 'baslica')),
            $beyan('Tablo 4: proje/patent/yurt dışı araştırma vb. en az 1 ek faaliyet'),
        ]],
    ],
    [
        'anahtar' => 'afyon-profesor-sosyal-ilahiyat',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['sosyal', 'ilahiyat'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 3 (Sosyal, Beşeri ve İdari Bilimler / İlahiyat): Asgari Başvuru Puanı 600, '
            .'doçentlik sonrası + Tablo 4 ek faaliyet.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 3 — Sosyal/İlahiyat', 'cocuklar' => [
            $toplam(600, $docentlikSonrasi),
            $adet('SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 2 makale', ['ULUSLARARASI_VE_ESCI'], 2, null, $docentlikSonrasi),
            $adet('Bunların en az 1\'inde başlıca yazar', ['ULUSLARARASI_VE_ESCI'], 1, 'baslica', $docentlikSonrasi),
            $adet('TR Dizin kapsamında en az 5 makale', ['1.3'], 5, null, $docentlikSonrasi, $trTelafi(5)),
            $adet('Bunların en az 3\'ü tek yazarlı', ['1.3'], 3, 'tek', $docentlikSonrasi, $trTelafi(3, 'tek')),
            $beyan('Tablo 4: proje/patent/yurt dışı araştırma vb. en az 1 ek faaliyet'),
        ]],
    ],
    [
        'anahtar' => 'afyon-profesor-filoloji',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['filoloji'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 3 (Filoloji): Asgari Başvuru Puanı 600, doçentlik sonrası + Tablo 4 ek faaliyet.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 3 — Filoloji', 'cocuklar' => [
            $toplam(600, $docentlikSonrasi),
            $adet('SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında başlıca yazar olduğu en az 1 makale', ['ULUSLARARASI_VE_ESCI'], 1, 'baslica', $docentlikSonrasi),
            $adet('TR Dizin kapsamında en az 6 makale', ['1.3'], 6, null, $docentlikSonrasi, $trTelafi(6)),
            $adet('Bunların en az 3\'ü tek yazarlı', ['1.3'], 3, 'tek', $docentlikSonrasi, $trTelafi(3, 'tek')),
            $beyan('Tablo 4: proje/patent/yurt dışı araştırma vb. en az 1 ek faaliyet'),
        ]],
    ],
    [
        'anahtar' => 'afyon-profesor-hukuk',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['hukuk'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 3 (Hukuk): Asgari Başvuru Puanı 600, doçentlik sonrası + Tablo 4 ek faaliyet.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 3 — Hukuk', 'cocuklar' => [
            $toplam(600, $docentlikSonrasi),
            $adet('SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında başlıca yazar olduğu en az 1 makale', ['ULUSLARARASI_VE_ESCI'], 1, 'baslica', $docentlikSonrasi),
            $adet('TR Dizin kapsamında en az 6 makale', ['1.3'], 6, null, $docentlikSonrasi, $trTelafi(6)),
            $adet('Bunların en az 4\'ü tek yazarlı', ['1.3'], 4, 'tek', $docentlikSonrasi, $trTelafi(4, 'tek')),
            $beyan('Tablo 4: proje/patent/yurt dışı araştırma vb. en az 1 ek faaliyet'),
        ]],
    ],
    [
        'anahtar' => 'afyon-profesor-guzel-sanatlar',
        'universite' => 'Afyon Kocatepe Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'afyon-2026',
        'notlar' => 'Tablo 3 (Güzel Sanatlar): Asgari Başvuru Puanı 450, doçentlik sonrası + Tablo 4 ek faaliyet.',
        'sart' => ['tip' => 've', 'aciklama' => 'Tablo 3 — Güzel Sanatlar', 'cocuklar' => [
            $toplam(450, $docentlikSonrasi),
            $beyan('Sanatsal etkinliklerden en az 100 puan (ÜAK özel koşullarına uygun)'),
            $adet('SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında başlıca yazar olduğu en az 1 makale', ['ULUSLARARASI_VE_ESCI'], 1, 'baslica', $docentlikSonrasi),
            $adet('TR Dizin kapsamında en az 4 makale', ['1.3'], 4, null, $docentlikSonrasi, $trTelafi(4)),
            $adet('Bunların en az 1\'i tek yazarlı', ['1.3'], 1, 'tek', $docentlikSonrasi, $trTelafi(1, 'tek')),
            $beyan('Tablo 4: metot/albüm çalışması vb. en az 1 ek faaliyet'),
        ]],
    ],

    /*
    ╔══════════════════════════════════════════════════════════════════════════╗
    ║  ATATÜRK ÜNİVERSİTESİ
    ╚══════════════════════════════════════════════════════════════════════════╝
    | Kaynak: pdf/17536930072.ataturkuniversitesi.pdf · Cetvel: ataturk-2026
    | A grubu: Fen · Mimarlık · Mühendislik · Sağlık · Ziraat
    | B grubu: Eğitim · Filoloji · Güzel Sanatlar · Hukuk · İlahiyat · Sosyal · Spor
    | MADDE 6: tüm kadrolarda merkezi yabancı dil sınavından en az 70.
    | Proje/atıf blokları cetvele girilmediği için AR-GE koşulları beyan.
    */

    // ── Dr. Öğr. Üyesi ──
    [
        'anahtar' => 'ataturk-dr-a',
        'universite' => 'Atatürk Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['fen', 'muhendislik', 'saglik', 'ziraat'],
        'cetvel' => 'ataturk-2026',
        'notlar' => 'A grubu: 0 ve 2. bölgelerden toplam en az 100 puan; makalelerden en az 40 puan. '
            .'Tablo dipnotu: "En az 18 puanın SCIE, SSCI veya AHCI kapsamındaki dergilerde yapılan '
            .'tam metin makalelerden alınması gerekir." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'A grubu — Dr. Öğr. Üyesi', 'cocuklar' => [
            $toplam(100),
            $puanDan('Makalelerden en az 40 puan', ['MAKALE'], 40),
            $puanDan('Bunun en az 18 puanı SCIE/SSCI/AHCI dergilerden', ['INDEKS_SCIE_SSCI_AHCI'], 18),
            $yds(70),
        ]],
    ],
    [
        'anahtar' => 'ataturk-dr-a-mimarlik',
        'universite' => 'Atatürk Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['mimarlik'],
        'cetvel' => 'ataturk-2026',
        'notlar' => 'A grubu (Mimarlık/Matematik/İstatistik): indeks alt sınırı düşük — Tablo dipnotu: '
            .'"İç Mimarlık, Mimarlık, Şehir ve Bölge Planlama, Matematik ve İstatistik bölümleri için '
            .'en az 9 puanın SCIE, SSCI veya AHCI kapsamındaki dergilerde yapılan yayınlardan '
            .'alınması gerekir." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'A grubu (Mimarlık) — Dr. Öğr. Üyesi', 'cocuklar' => [
            $toplam(100),
            $puanDan('Makalelerden en az 40 puan', ['MAKALE'], 40),
            $puanDan('Bunun en az 9 puanı SCIE/SSCI/AHCI dergilerden', ['INDEKS_SCIE_SSCI_AHCI'], 9),
            $yds(70),
        ]],
    ],
    [
        'anahtar' => 'ataturk-dr-b',
        'universite' => 'Atatürk Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['sosyal', 'egitim', 'filoloji', 'guzel_sanatlar', 'ilahiyat', 'spor'],
        'cetvel' => 'ataturk-2026',
        'notlar' => 'B grubu: 0 ve 2. bölgelerden toplam en az 100 puan; makalelerden en az 30 puan. '
            .'Tablo dipnotu: "En az 12 puanın SCIE, SSCI, AHCI, ESCI veya SCOPUS kapsamındaki '
            .'dergilerde yapılan yayınlardan alınması gerekir." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'B grubu — Dr. Öğr. Üyesi', 'cocuklar' => [
            $toplam(100),
            $puanDan('Makalelerden en az 30 puan', ['MAKALE'], 30),
            $puanDan('Bunun en az 12 puanı SCIE/SSCI/AHCI/ESCI/Scopus dergilerden', ['INDEKS_GENIS'], 12),
            $yds(70),
        ]],
    ],
    [
        'anahtar' => 'ataturk-dr-b-hukuk',
        'universite' => 'Atatürk Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['hukuk'],
        'cetvel' => 'ataturk-2026',
        'notlar' => 'B grubu (Hukuk): Tablo dipnotu: "Hukuk temel alanı için en az 5 puanın SCIE, SSCI, '
            .'AHCI, ESCI veya SCOPUS kapsamındaki dergilerde yapılan yayınlardan alınması gerekir." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'B grubu (Hukuk) — Dr. Öğr. Üyesi', 'cocuklar' => [
            $toplam(100),
            $puanDan('Makalelerden en az 30 puan', ['MAKALE'], 30),
            $puanDan('Bunun en az 5 puanı SCIE/SSCI/AHCI/ESCI/Scopus dergilerden', ['INDEKS_GENIS'], 5),
            $yds(70),
        ]],
    ],

    // ── Doçent ──
    [
        'anahtar' => 'ataturk-docent-a',
        'universite' => 'Atatürk Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['fen', 'mimarlik', 'muhendislik', 'saglik', 'ziraat'],
        'cetvel' => 'ataturk-2026',
        'notlar' => 'A grubu: ÜAK doçent unvanı + doçentlik havuz puanından toplam en az 100 puan. YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'A grubu — Doçent', 'cocuklar' => [
            $toplam(100),
            $adet('SCIE/SSCI/AHCI kapsamında en az 2 tam metin makale', ['INDEKS_SCIE_SSCI_AHCI'], 2),
            $beyan('AR-GE projelerinden en az 30 puan: "Aday, bu puanın tamamını ya yürütücüsü olduğu '
                .'ulusal/uluslararası AR-GE projelerinden sağlamak ya da en az bir yürütücü olduğu AR-GE '
                .'projesi olmak şartıyla, kalan puanı Q1 veya Q2 kategorisindeki dergilerde yapmış olduğu '
                .'yayınlardan alması gerekir."'),
            $beyan('"Doçentlik havuz puanından alınması gereken puanlara, ÜAK doçentlik başvuru asgari '
                .'şartlarını sağlamak için kullanılan makaleler dahil edilmez."'),
            $yds(70),
        ]],
    ],
    [
        'anahtar' => 'ataturk-docent-b',
        'universite' => 'Atatürk Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['sosyal', 'egitim', 'filoloji', 'guzel_sanatlar', 'hukuk', 'ilahiyat', 'spor'],
        'cetvel' => 'ataturk-2026',
        'notlar' => 'B grubu: ÜAK doçent unvanı + doçentlik havuz puanından toplam en az 80 puan. YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'B grubu — Doçent', 'cocuklar' => [
            $toplam(80),
            $adet('SCIE/SSCI/AHCI/ESCI/Scopus kapsamında en az 1 tam metin makale', ['INDEKS_GENIS'], 1),
            $beyan('AR-GE projelerinden en az 20 puan (yürütücülük şartıyla)'),
            $beyan('"Doçentlik havuz puanından alınması gereken puanlara, ÜAK doçentlik başvuru asgari '
                .'şartlarını sağlamak için kullanılan makaleler dahil edilmez."'),
            $yds(70),
        ]],
    ],

    // ── Profesör ──
    [
        'anahtar' => 'ataturk-profesor-a',
        'universite' => 'Atatürk Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['fen', 'muhendislik', 'saglik', 'ziraat'],
        'cetvel' => 'ataturk-2026',
        'notlar' => 'A grubu: ÜAK doçentlik belgesi + tüm bölgelerden toplam en az 250 puan; makalelerden '
            .'en az 60 puan. Tablo dipnotu: "En az 30 puanın SCIE, SSCI veya AHCI kapsamındaki '
            .'dergilerde yapılan tam metin makalelerden alınması gerekir." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'A grubu — Profesör', 'cocuklar' => [
            $toplam(250),
            $puanDan('Makalelerden en az 60 puan', ['MAKALE'], 60),
            $puanDan('Bunun en az 30 puanı SCIE/SSCI/AHCI dergilerden', ['INDEKS_SCIE_SSCI_AHCI'], 30),
            $beyan('AR-GE projelerinden en az 40 puan (yürütücülük şartıyla)'),
            $beyan('7. bölgeden en az 30 puan alınmalı'),
            $yds(70),
        ]],
    ],
    [
        'anahtar' => 'ataturk-profesor-a-mimarlik',
        'universite' => 'Atatürk Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['mimarlik'],
        'cetvel' => 'ataturk-2026',
        'notlar' => 'A grubu (Mimarlık): Tablo dipnotu: "İç Mimarlık, Mimarlık, Şehir ve Bölge Planlama, '
            .'Matematik ve İstatistik bölümleri için en az 20 puanın SCIE, SSCI veya AHCI kapsamındaki '
            .'dergilerde yapılan yayınlardan alınması gereklidir." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'A grubu (Mimarlık) — Profesör', 'cocuklar' => [
            $toplam(250),
            $puanDan('Makalelerden en az 60 puan', ['MAKALE'], 60),
            $puanDan('Bunun en az 20 puanı SCIE/SSCI/AHCI dergilerden', ['INDEKS_SCIE_SSCI_AHCI'], 20),
            $beyan('AR-GE projelerinden en az 40 puan (yürütücülük şartıyla)'),
            $beyan('7. bölgeden en az 30 puan alınmalı'),
            $yds(70),
        ]],
    ],
    [
        'anahtar' => 'ataturk-profesor-b',
        'universite' => 'Atatürk Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['sosyal', 'egitim', 'filoloji', 'guzel_sanatlar', 'hukuk', 'ilahiyat', 'spor'],
        'cetvel' => 'ataturk-2026',
        'notlar' => 'B grubu: ÜAK doçentlik belgesi + tüm bölgelerden toplam en az 200 puan; makalelerden '
            .'en az 30 puan. Tablo dipnotu: "En az 20 puanın SCIE, SSCI, AHCI, ESCI veya SCOPUS '
            .'kapsamındaki dergilerde yapılan yayınlardan alınması gerekir." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'B grubu — Profesör', 'cocuklar' => [
            $toplam(200),
            $puanDan('Makalelerden en az 30 puan', ['MAKALE'], 30),
            $puanDan('Bunun en az 20 puanı SCIE/SSCI/AHCI/ESCI/Scopus dergilerden', ['INDEKS_GENIS'], 20),
            $beyan('AR-GE projelerinden en az 20 puan (yürütücülük şartıyla)'),
            $beyan('Diğer çalışmalardan en az 20 puan (ÜAK alan endeksi dergileri)'),
            $beyan('7. bölgeden en az 20 puan alınmalı'),
            $yds(70),
        ]],
    ],
];

// Grup satırlarını (alan dizisi olanlar) alan başına ayrı kayda açar; motor
// tarafında hiçbir gruplama/fallback mantığı kalmaz — eşleşme daima tam
// (kadro + alan) eşleşmesidir.
$esikler = [];

foreach ($satirlar as $satir) {
    foreach ((array) $satir['alan'] as $alan) {
        $esikler[] = array_merge(
            ['birim' => null],
            $satir,
            ['alan' => $alan, 'anahtar' => "{$satir['anahtar']}-{$alan}"],
        );
    }
}

return $esikler;
