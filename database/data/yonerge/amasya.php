<?php

/**
 * AMASYA ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Yönergesi
 * Kaynak: pdf/17536928612.amasyauniversitesi.pdf
 *
 * KORPUSTAKİ EN SADE YAPILARDAN BİRİ: koşullar iki satırdan ibaret — bir alt
 * baraj ("en az N puanı A1-A16 kategorilerinden") ve bir toplam baraj
 * ("Çizelge-1'de yer alan kategorilerden minimum M puan").
 *
 * DR. ÖĞR. ÜYELİĞİNDE ALAN AYRIMI YOK (Madde 6): bütün temel alanlarda
 * A1-A16'dan 20, toplamda 40 puan. Yeniden atanmada da aynı sayılar geçerli.
 *
 * DOÇENTLİKTE PUAN BARAJI YOK (Madde 8): yönerge yalnızca ÜAK doçentlik
 * unvanını ve yurt dışı belgede ÜAK denkliğini şart koşuyor. Bu kasıtlı;
 * olmayan bir baraj uydurmak adaya aranmayan bir koşulu gösterirdi.
 *
 * PROFESÖRLÜKTE BEŞ ALAN GRUBU (Madde 9):
 *   Mühendislik, Mimarlık, Fen   A1'den başlıca yazar 1 makale · A1-A16 150 · toplam 300
 *   Sağlık, Spor                 A1-A16 100 · toplam 200
 *   Hukuk, İlahiyat, Filoloji,
 *   Sosyal                       A1-A16 125 · toplam 250
 *   Eğitim Bilimleri             TEK YAZARLI 1 makale · A1-A16 125 · toplam 250
 *   Güzel Sanatlar               A1-A16 ve K1-K9'dan 125 · toplam 250
 *
 * Eğitim'in "tek yazarlı en az bir özgün makale" koşulu diğer alanlardaki
 * "başlıca yazar" koşulundan farklı: `yazar` filtresi 'tek' olarak girildi.
 *
 * K1-K9 (sanatsal etkinlikler) cetvele girmedi; Güzel Sanatlar'ın alt barajı
 * bu yüzden yalnızca A1-A16'yı sayıyor, yani olduğundan zor görünür.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/amasya-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$P = Kalip::DOCENTLIK_SONRASI;

/** Dr. Öğr. Üyeliği ve doçentlik bütün alanlarda aynı; alan listesi tek yerde. */
$tumAlanlar = ['fen', 'muhendislik', 'mimarlik', 'saglik', 'spor', 'hukuk', 'ilahiyat',
    'filoloji', 'sosyal', 'egitim', 'guzel_sanatlar', 'ziraat'];

/**
 * Profesörlükte her alan grubunun aynı iki barajı.
 *
 * @param  list<string>  $alanlar
 * @param  list<array<string, mixed>>  $ek
 * @return array<string, mixed>
 */
$profesor = function (string $anahtar, string $ad, array $alanlar, int $alt, int $toplam, array $ek = []) use ($P): array {
    return [
        'anahtar' => "amasya-profesor-{$anahtar}",
        'aday_notu' => 'Bütün koşullar doçentlik unvanınızı aldığınız tarihten sonraki '
            .'çalışmalarınızla sağlanmalı.',
        'universite' => 'Amasya Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => array_values($alanlar),
        'cetvel' => 'amasya-2024',
        'notlar' => "Madde 9 ({$ad}): A1-A16 kategorilerinden en az {$alt}, Çizelge-1'den toplam en az {$toplam} puan.",
        'sart' => Kalip::ve("Profesör — {$ad}", [
            Kalip::toplam($toplam, $P),
            Kalip::puanDan("Makale kalemlerinizden en az {$alt} puan", ['A1-A16'], $alt, $P, madde: 'Madde 9'),
            ...array_values($ek),
        ]),
    ];
};

return [
    // ══════════ DR. ÖĞRETİM ÜYESİ (alan ayrımı yok) ══════════
    [
        'anahtar' => 'amasya-dr',
        'aday_notu' => 'Yeniden atanmada da aynı sayılar geçerli, ancak yalnızca son atama '
            .'tarihinden sonraki faaliyetleriniz sayılır.',
        'universite' => 'Amasya Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $tumAlanlar,
        'cetvel' => 'amasya-2024',
        'notlar' => 'Madde 6/1: A1-A16 kategorilerinden en az 20, Çizelge-1\'den toplam en az 40 puan.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Amasya Üniversitesi', [
            Kalip::toplam(40),
            Kalip::puanDan('Makale kalemlerinizden en az 20 puan', ['A1-A16'], 20, madde: 'Madde 6/1'),
        ]),
    ],

    // ══════════ DOÇENT (puan barajı yok) ══════════
    [
        'anahtar' => 'amasya-docent',
        'aday_notu' => 'Amasya yönergesi doçentlik için puan barajı koymuyor; Madde 8 yalnızca '
            .'ÜAK doçentlik unvanını şart koşuyor. Burada baraj görmüyorsunuz — eksik veri '
            .'değil, yönergede öyle.',
        'universite' => 'Amasya Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $tumAlanlar,
        'cetvel' => 'amasya-2024',
        'notlar' => 'Madde 8: ÜAK doçentlik unvanı; yurt dışı belgede ÜAK denkliği.',
        'sart' => Kalip::ve('Doçent — Amasya Üniversitesi', [
            Kalip::beyan('Üniversitelerarası Kuruldan doçentlik unvanını almış olmak; yurt dışından '
                .'doçentlik belgesi alanların ÜAK\'tan denklik almış olması', 'Madde 8'),
        ]),
    ],

    // ══════════ PROFESÖR — BEŞ ALAN GRUBU ══════════
    $profesor('fen', 'Mühendislik, Mimarlık, Fen Bilimleri ve Matematik',
        ['muhendislik', 'mimarlik', 'fen', 'ziraat'], 150, 300, [
            Kalip::adet('SCI, SCI-Expanded, SSCI veya AHCI dergide başlıca yazar olduğunuz en az 1 özgün makale',
                ['A1'], 1, 'baslica', $P, madde: 'Madde 9/a-1'),
        ]),

    $profesor('saglik', 'Sağlık Bilimleri ve Spor Bilimleri', ['saglik', 'spor'], 100, 200),

    $profesor('sosyal', 'Hukuk, İlahiyat, Filoloji, Sosyal ve Beşeri Bilimler',
        ['hukuk', 'ilahiyat', 'filoloji', 'sosyal'], 125, 250),

    $profesor('egitim', 'Eğitim Bilimleri', ['egitim'], 125, 250, [
        Kalip::adet('SCI, SCI-Expanded, SSCI, AHCI veya eğitim alan indeksli dergide TEK YAZARLI '
            .'en az 1 özgün makale', ['A1', 'A3'], 1, 'tek', $P, madde: 'Madde 9/ç-1'),
    ]),

    $profesor('guzel-sanatlar', 'Güzel Sanatlar', ['guzel_sanatlar'], 125, 250),
];
