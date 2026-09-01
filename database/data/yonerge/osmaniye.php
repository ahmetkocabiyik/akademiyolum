<?php

/**
 * OSMANİYE KORKUT ATA ÜNİVERSİTESİ — Öğretim Üyeliğine Akademik Yükseltme ve
 * Atama Yönergesi (Madde 5-8)
 * Kaynak: pdf/17537006032.osmaniyekorkutatauniverstesi.pdf
 *
 * DR. ÖĞR. ÜYELİĞİNDE PUAN BARAJI YOK, ÇALIŞMA SAYISI VAR (Tablo 1) — korpusta
 * ender. On iki temel alanın her biri kendi sayım kuralını taşıyor ve kuralların
 * çoğu "şu maddeden 1 çalışma VEYA şu maddelerden 2 çalışma" biçiminde
 * alternatifli. Puan barajı yalnızca yeniden atamada (100) ve üst kadrolarda
 * devreye giriyor.
 *
 * PROFESÖRLÜKTE İKİ KATMAN + ALANA ÖZEL ŞART (Tablo 3): toplam 500 puan, bunun
 * 300'ü doçentlik başvuru döneminden sonra; ayrıca o 300 puanın içinde alanın
 * kendi özel şartı sağlanmalı. Alanlar bu şartta üç kalıba ayrılıyor:
 *   Fen, Mühendislik, Sağlık, Ziraat  1.1.1/6/11.4/11.5'ten 180 (120'si 1.1.1'den)
 *                                     — makale, proje ve patenti aynı kefeye koyuyor
 *   Güzel Sanatlar, Mimarlık          8, 10, 11 (ya da 6, 8, 11) maddelerinden 200
 *   Diğerleri                         makale ve kitap kalemlerinden ayrı ayrı
 *
 * FEN GRUBUNUN ŞARTI DİKKAT ÇEKİCİ: 1.1.1 (SCI makale), 6 (proje) ve 11.4/11.5
 * (patent) tek bir küme sayılıyor. Yani bir uluslararası patent (150) tek başına
 * 180 puanlık şartın büyük kısmını karşılıyor — ama en az 120'sinin SCI
 * makalesinden gelmesi zorunlu olduğu için patent tek başına yetmiyor.
 *
 * DOÇENTLİKTE ALAN AYRIMI YALNIZCA DÖRT ALANDA: Filoloji, Hukuk, Sosyal ve Spor
 * için 300 puana ek olarak 1.1.1'den 1 ya da 1.1.2'den 2 çalışma isteniyor.
 * Diğer sekiz alanda yalnızca puan barajı var.
 *
 * YENİDEN ATANMA GİRİLMEDİ: koşul "son atama döneminden sonraki çalışmalarla
 * en az 100 puan" biçiminde; atama tarihi profilde tutulmuyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/osmaniye-2023.php
 */

use App\Services\Scoring\Sart\Kalip;

$DOC = Kalip::DOCENTLIK_SONRASI;

$fenGrubu = ['fen', 'muhendislik', 'saglik', 'ziraat'];
$sosyalGrubu = ['sosyal', 'hukuk'];
$tumAlanlar = ['fen', 'muhendislik', 'mimarlik', 'saglik', 'spor', 'hukuk', 'ilahiyat',
    'filoloji', 'sosyal', 'egitim', 'guzel_sanatlar', 'ziraat'];

$yenidenAtamaNotu = 'Yeniden atanmada son atama döneminden sonraki çalışmalarınızla en az 100 '
    .'puan ve alana özgü şartlar isteniyor. Atama tarihi burada tutulmadığı için '
    .'yeniden atanma eşiği girilmedi.';

$drNotu = 'Osmaniye Korkut Ata ilk atamada PUAN BARAJI KOYMUYOR; yalnızca belirli maddelerden '
    .'ÇALIŞMA SAYISI arıyor. '.$yenidenAtamaNotu;

/**
 * Dr. Öğr. Üyeliği ilk atama eşiği (Tablo 1) — hepsi sayı koşulu.
 *
 * @param  list<string>  $alanlar
 * @param  list<array<string, mixed>>  $kosullar
 * @return array<string, mixed>
 */
$dr = function (string $anahtar, string $ad, array $alanlar, array $kosullar, string $notlar) use ($drNotu): array {
    return [
        'anahtar' => "osmaniye-dr-{$anahtar}",
        'aday_notu' => $drNotu,
        'universite' => 'Osmaniye Korkut Ata Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => array_values($alanlar),
        'cetvel' => 'osmaniye-2023',
        'notlar' => "Tablo 1 ({$ad}): {$notlar}",
        'sart' => Kalip::ve("Dr. Öğr. Üyesi — {$ad}", array_values($kosullar)),
    ];
};

/**
 * Profesörlük eşiği (Madde 8 + Tablo 3): toplam 500, doçentlik sonrası 300,
 * ayrıca alanın özel şartı.
 *
 * @param  list<string>  $alanlar
 * @param  list<array<string, mixed>>  $ozel
 * @return array<string, mixed>
 */
$profesor = function (string $anahtar, string $ad, array $alanlar, array $ozel, string $notlar) use ($DOC): array {
    return [
        'anahtar' => "osmaniye-profesor-{$anahtar}",
        'aday_notu' => 'Toplam 500 puanın 300\'ü doçentlik unvanınıza esas başvuru döneminden '
            .'SONRA elde edilmiş olmalı; alan özel şartı da o 300 puanın içinde sağlanmalı.',
        'universite' => 'Osmaniye Korkut Ata Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => array_values($alanlar),
        'cetvel' => 'osmaniye-2023',
        'notlar' => "Madde 8/b: toplam 500 puan, 300'ü doçentlik sonrası. Tablo 3 ({$ad}): {$notlar}",
        'sart' => Kalip::ve("Profesör — {$ad}", [
            Kalip::yds(65),
            Kalip::toplam(500),
            Kalip::toplam(300, $DOC),
            ...array_values($ozel),
        ]),
    ];
};

/**
 * Doçentlik eşiği (Madde 7): 300 puan; dört alanda ek yayın şartı.
 *
 * @param  list<string>  $alanlar
 * @param  list<array<string, mixed>>  $ek
 * @return array<string, mixed>
 */
$docent = function (string $anahtar, string $ad, array $alanlar, array $ek = []): array {
    return [
        'anahtar' => "osmaniye-docent-{$anahtar}",
        'aday_notu' => $ek === []
            ? 'Bu alanda doçentlik için yalnızca puan barajı ve yabancı dil şartı var; ek yayın '
                .'koşulu aranmıyor.'
            : 'Puan barajına ek olarak bir yayın koşulu da var.',
        'universite' => 'Osmaniye Korkut Ata Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => array_values($alanlar),
        'cetvel' => 'osmaniye-2023',
        'notlar' => 'Madde 7/c: Ek-1 tablosundan en az 300 puan; Madde 7/b: yabancı dil '
            .'sınavından en az 65.',
        'sart' => Kalip::ve("Doçent — {$ad}", [
            Kalip::yds(65),
            Kalip::toplam(300),
            Kalip::beyan('Üniversitelerarası Kurul tarafından verilen doçentlik belgesine sahip '
                .'olmak', 'Madde 7/a'),
            ...array_values($ek),
        ]),
    ];
};

/** Filoloji, Hukuk, Sosyal ve Spor'da doçentlik için aranan ek yayın koşulu. */
$docentEkYayin = Kalip::veya('Yayın koşulu', [
    Kalip::adet('SCI, SCI-Expanded, SSCI veya AHCI dergide en az 1 çalışma', ['1.1.1'], 1,
        madde: 'Madde 7/d'),
    Kalip::adet('ÜAK alan indeksli dergide en az 2 çalışma', ['1.1.2'], 2, madde: 'Madde 7/d'),
]);

return [
    // ══════════ DR. ÖĞRETİM ÜYESİ (ilk atama, Tablo 1) ══════════
    $dr('fen', 'Fen Bilimleri, Mühendislik, Sağlık Bilimleri ve Ziraat', $fenGrubu, [
        Kalip::adet('Makale kalemlerinizden toplam 3 çalışma',
            ['1.1.1/1.1.2/1.1.3/1.2.1'], 3, madde: 'Tablo 1'),
        Kalip::adet('Bunlardan en az 1\'i SCI, SCI-Expanded, SSCI veya AHCI dergide',
            ['1.1.1'], 1, madde: 'Tablo 1'),
    ], '1.1.1/1.1.2/1.1.3/1.2.1 maddelerinden en az biri 1.1.1\'den olmak üzere 3 çalışma.'),

    $dr('egitim', 'Eğitim Bilimleri', ['egitim'], [
        Kalip::veya('Aşağıdaki seçeneklerden birini sağlamak', [
            Kalip::adet('SCI, SCI-Expanded, SSCI veya AHCI dergide 1 çalışma', ['1.1.1'], 1,
                madde: 'Tablo 1'),
            Kalip::ve('Alan indeksli, kısa yayın veya TR Dizin kalemlerinden 2 çalışma', [
                Kalip::adet('Alan indeksli, kısa yayın veya TR Dizin kalemlerinden 2 çalışma',
                    ['1.1.2/1.1.3/1.2.1'], 2, madde: 'Tablo 1'),
                Kalip::adet('Bunlardan en az 1\'i ÜAK alan indeksli dergide', ['1.1.2'], 1,
                    madde: 'Tablo 1'),
            ]),
            Kalip::adet('TR Dizin dergide 3 çalışma', ['1.2.1'], 3, madde: 'Tablo 1'),
        ]),
    ], '1.1.1\'den 1 ya da 1.1.2/1.1.3/1.2.1\'den 2 ya da 1.2.1\'den 3 çalışma.'),

    $dr('filoloji', 'Filoloji', ['filoloji'], [
        Kalip::veya('Aşağıdaki seçeneklerden birini sağlamak', [
            Kalip::adet('SCI veya alan indeksli dergide 1 çalışma', ['1.1.1/1.1.2'], 1,
                madde: 'Tablo 1'),
            Kalip::ve('TR Dizin, kitap ve bildiri kalemlerinden 4 çalışma', [
                Kalip::adet('TR Dizin, kitap ve bildiri kalemlerinden 4 çalışma',
                    ['1.2.1/2.1.1/2.1.3/2.2.1/4.1.1'], 4, madde: 'Tablo 1'),
                Kalip::adet('Bunlardan en az 3\'ü TR Dizin dergide', ['1.2.1'], 3,
                    madde: 'Tablo 1'),
            ]),
        ]),
    ], '1.1.1/1.1.2\'den 1 ya da 1.2.1/2.1.1/2.1.3/2.2.1/4.1.1\'den 4 çalışma.'),

    $dr('guzel-sanatlar', 'Güzel Sanatlar', ['guzel_sanatlar'], [
        Kalip::adet('Makale kalemlerinizden 2 çalışma', ['1'], 2, madde: 'Tablo 1'),
        Kalip::adet('Bildiri kalemlerinizden 2 çalışma', ['4'], 2, madde: 'Tablo 1'),
        Kalip::adet('Sanatsal etkinlik kalemlerinizden 5 çalışma', ['10'], 5, madde: 'Tablo 1'),
    ], '1. maddeden 2, 4. maddeden 2 ve 10. maddeden 5 çalışma.'),

    $dr('sosyal', 'Hukuk ile Sosyal, Beşeri ve İdari Bilimler', $sosyalGrubu, [
        Kalip::veya('Aşağıdaki seçeneklerden birini sağlamak', [
            Kalip::adet('SCI, SCI-Expanded, SSCI veya AHCI dergide 1 çalışma', ['1.1.1'], 1,
                madde: 'Tablo 1'),
            Kalip::adet('ÜAK alan indeksli dergide 2 çalışma', ['1.1.2'], 2, madde: 'Tablo 1'),
            Kalip::ve('TR Dizin ve bildiri kalemlerinden 4 çalışma', [
                Kalip::adet('TR Dizin ve bildiri kalemlerinden 4 çalışma', ['1.2.1/4.1.1'], 4,
                    madde: 'Tablo 1'),
                Kalip::adet('Bunlardan en az 2\'si TR Dizin dergide', ['1.2.1'], 2,
                    madde: 'Tablo 1'),
            ]),
        ]),
    ], '1.1.1\'den 1 ya da 1.1.2\'den 2 ya da 1.2.1/4.1.1\'den 4 çalışma.'),

    $dr('ilahiyat', 'İlahiyat', ['ilahiyat'], [
        Kalip::veya('Aşağıdaki seçeneklerden birini sağlamak', [
            Kalip::adet('Alan indeksli veya TR Dizin dergide 3 çalışma', ['1.1.2/1.2.1'], 3,
                madde: 'Tablo 1'),
            Kalip::adet('Uluslararası veya ulusal yayınevinde 1 bilimsel kitap',
                ['2.1.1/2.2.1'], 1, madde: 'Tablo 1'),
            Kalip::adet('Kitap bölümü kalemlerinden 2 çalışma', ['2.1.3/2.2.3'], 2,
                madde: 'Tablo 1'),
        ]),
    ], '1.1.2/1.2.1\'den 3 ya da 2.1.1/2.2.1\'den 1 ya da 2.1.3/2.2.3\'ten 2 çalışma.'),

    $dr('mimarlik', 'Mimarlık, Planlama ve Tasarım', ['mimarlik'], [
        Kalip::veya('Uluslararası yayın koşulu', [
            Kalip::adet('SCI, SCI-Expanded, SSCI veya AHCI dergide 1 çalışma', ['1.1.1'], 1,
                madde: 'Tablo 1'),
            Kalip::adet('Alan indeksli veya diğer uluslararası dergilerde 2 çalışma',
                ['1.1.2/1.1.3/1.1.4'], 2, madde: 'Tablo 1'),
        ]),
        Kalip::adet('Ayrıca ulusal hakemli dergilerde en az 1 çalışma', ['1.2.1/1.2.2'], 1,
            madde: 'Tablo 1'),
    ], '1.1.1\'den 1 ya da 1.1.2/1.1.3/1.1.4\'ten 2 çalışma, ek olarak 1.2.1/1.2.2\'den 1.'),

    $dr('spor', 'Spor Bilimleri', ['spor'], [
        Kalip::adet('SCI veya alan indeksli dergilerde 2 çalışma', ['1.1.1/1.1.2'], 2,
            madde: 'Tablo 1'),
        Kalip::adet('Ulusal hakemli dergilerde 3 çalışma', ['1.2.1/1.2.2'], 3, madde: 'Tablo 1'),
        Kalip::adet('Bunlardan en az 1\'i TR Dizin dergide', ['1.2.1'], 1, madde: 'Tablo 1'),
    ], '1.1.1/1.1.2\'den 2 çalışma ve 1.2.1/1.2.2\'den en az 1\'i 1.2.1\'den olmak üzere 3 çalışma.'),

    // ══════════ DOÇENT (Madde 7) ══════════
    $docent('genel', 'Eğitim, Fen, Güzel Sanatlar, İlahiyat, Mimarlık, Mühendislik, Sağlık ve Ziraat',
        ['egitim', 'fen', 'guzel_sanatlar', 'ilahiyat', 'mimarlik', 'muhendislik', 'saglik', 'ziraat']),

    $docent('sosyal', 'Filoloji, Hukuk, Sosyal Bilimler ve Spor Bilimleri',
        ['filoloji', 'hukuk', 'sosyal', 'spor'], [$docentEkYayin]),

    // ══════════ PROFESÖR (Madde 8 + Tablo 3) ══════════
    $profesor('fen', 'Fen Bilimleri, Mühendislik, Sağlık Bilimleri ve Ziraat', $fenGrubu, [
        Kalip::puanDan('SCI makale, proje ve patent kalemlerinizden en az 180 puan',
            ['1.1.1/6/11.4/11.5'], 180, $DOC, madde: 'Tablo 3'),
        Kalip::puanDan('Bunun en az 120 puanı SCI, SCI-Expanded, SSCI veya AHCI makalelerinizden',
            ['1.1.1'], 120, $DOC, madde: 'Tablo 3'),
    ], '1.1.1/6/11.4/11.5 maddelerinden en az 120\'si 1.1.1\'den olmak üzere 180 puan.'),

    $profesor('egitim', 'Eğitim Bilimleri', ['egitim'], [
        Kalip::puanDan('Uluslararası makale kalemlerinizden en az 120 puan',
            ['1.1 (1.1.4 hariç)'], 120, $DOC, madde: 'Tablo 3'),
        Kalip::puanDan('TR Dizin makalelerinizden en az 30 puan', ['1.2.1'], 30, $DOC,
            madde: 'Tablo 3'),
    ], '1.1 maddesinden (1.1.4 hariç) 120 ve 1.2.1 maddesinden 30 puan.'),

    $profesor('filoloji', 'Filoloji', ['filoloji'], [
        Kalip::puanDan('Makale kalemlerinizden en az 80 puan',
            ['1.1/1.2 (1.1.4 ve 1.2.4 hariç)'], 80, $DOC, madde: 'Tablo 3'),
        Kalip::puanDan('Bilimsel kitap kalemlerinizden en az 30 puan', ['2.1.1/2.2.1'], 30, $DOC,
            madde: 'Tablo 3'),
        Kalip::puanDan('Uluslararası tam metin bildirilerinizden en az 30 puan', ['4.1.1'], 30,
            $DOC, madde: 'Tablo 3'),
    ], '1.1/1.2 (1.1.4 ve 1.2.4 hariç) 80, 2.1.1/2.2.1\'den 30 ve 4.1.1\'den 30 puan.'),

    $profesor('guzel-sanatlar', 'Güzel Sanatlar', ['guzel_sanatlar'], [
        Kalip::puanDan('Eğitim etkinlikleri, sanatsal etkinlikler ile ödül ve patent '
            .'kalemlerinizden en az 200 puan', ['8', '10', '11'], 200, $DOC, madde: 'Tablo 3'),
    ], '8., 10. ve 11. maddelerden 200 puan.'),

    $profesor('sosyal', 'Hukuk ile Sosyal, Beşeri ve İdari Bilimler', $sosyalGrubu, [
        Kalip::puanDan('Uluslararası makale kalemlerinizden en az 60 puan',
            ['1.1 (1.1.4 hariç)'], 60, $DOC, madde: 'Tablo 3'),
        Kalip::puanDan('TR Dizin makalelerinizden en az 40 puan', ['1.2.1'], 40, $DOC,
            madde: 'Tablo 3'),
        Kalip::puanDan('Uluslararası kitap kalemlerinizden en az 50 puan', ['2.1'], 50, $DOC,
            madde: 'Tablo 3'),
    ], '1.1 (1.1.4 hariç) 60, 1.2.1\'den 40 ve 2.1\'den 50 puan.'),

    $profesor('ilahiyat', 'İlahiyat', ['ilahiyat'], [
        Kalip::puanDan('Makale ve kitap kalemlerinizden en az 120 puan',
            ['1/2 (2.2.4 hariç)'], 120, $DOC, madde: 'Tablo 3'),
        Kalip::puanDan('Bunun en az 70 puanı makale kalemlerinizden', ['1'], 70, $DOC,
            madde: 'Tablo 3'),
    ], '1./2. (2.2.4 hariç) maddelerden en az 70\'i 1. maddeden olmak üzere 120 puan.'),

    $profesor('mimarlik', 'Mimarlık, Planlama ve Tasarım', ['mimarlik'], [
        Kalip::puanDan('Proje, eğitim etkinlikleri ile ödül ve patent kalemlerinizden en az '
            .'200 puan', ['6', '8', '11'], 200, $DOC, madde: 'Tablo 3'),
    ], '6., 8. ve 11. maddelerden 200 puan.'),

    $profesor('spor', 'Spor Bilimleri', ['spor'], [
        Kalip::puanDan('Uluslararası makale kalemlerinizden en az 100 puan',
            ['1.1 (1.1.4 hariç)'], 100, $DOC, madde: 'Tablo 3'),
        Kalip::puanDan('TR Dizin makalelerinizden en az 30 puan', ['1.2.1'], 30, $DOC,
            madde: 'Tablo 3'),
    ], '1.1 (1.1.4 hariç) 100 ve 1.2.1\'den 30 puan.'),
];
