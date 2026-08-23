<?php

/**
 * GAZİANTEP İSLAM BİLİM VE TEKNOLOJİ ÜNİVERSİTESİ — Öğretim Üyeliğine
 * Yükseltilme ve Atanma Kriterleri Yönergesi
 * Kaynak: pdf/17536994372.gaziantepislambilimveteknolojiuniverstesi.pdf
 *
 * Gaziantep Üniversitesi'nden AYRI bir üniversite; yönergesi de bağımsız.
 *
 * BEŞ TEMEL ALAN, ORTAK PUAN TABLOSU:
 *   Madde 11  Fen Bilimleri, Matematik ve Mühendislik
 *   Madde 12  Sağlık Bilimleri
 *   Madde 13  Eğitim, Sosyal ve Beşeri Bilimler
 *   Madde 14  Spor Bilimleri
 *   Madde 15  Mimarlık, Güzel Sanatlar ve Konservatuvar
 *
 * FEN/SAĞLIK ile DİĞERLERİ ARASINDAKİ FARK, kümenin darlığında: Madde 11 ve 12
 * "1.a veya 1.b maddelerinden" (yalnızca WoS ve ESCI) derken, Madde 13, 14 ve
 * 15 "1 numaralı maddeden" diyor, yani TR Dizin ve ulusal hakemli dergileri de
 * sayıyor. Barajlar da kademeli olarak düşüyor: genel toplam fen/sağlıkta 60,
 * eğitim/sosyalde 40, spor ve güzel sanatlarda 30.
 *
 * DÖNEM: profesörlükte "doçent eser aşamasını geçtikten sonra" — doçentlik
 * sonrası. Doçentlikte dönem kaydı yok; koşullar doçentlik başvurusunun asgari
 * şartlarına EK olarak aranıyor. Profesörlükte ayrıca doçentlik ÖNCESİ dâhil
 * genel toplam barajı var, o yüzden iki ayrı toplam düğümü.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/gibtu-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$P = Kalip::DOCENTLIK_SONRASI;

/**
 * Bir temel alanın üç kadrosunu üretir.
 *
 * @param  list<string>  $alanlar
 * @param  list<string>  $makaleKume  "1.a veya 1.b" ya da "1 numaralı madde"
 * @param  array{int, int, int}  $drBaraj  makale · 4-5-6 · genel toplam
 * @param  array{int, int, int}  $docBaraj
 * @param  array{int, int, int, int}  $profBaraj  makale · 4-5-6 · doçentlik sonrası · genel
 * @return list<array<string, mixed>>
 */
$alan = function (
    string $anahtar,
    string $ad,
    string $madde,
    array $alanlar,
    array $makaleKume,
    string $kumeAdi,
    array $drBaraj,
    array $docBaraj,
    array $profBaraj,
) use ($P): array {
    $alanlar = array_values($alanlar);
    $makaleKume = array_values($makaleKume);

    return [
        [
            'anahtar' => "gibtu-dr-{$anahtar}",
            'aday_notu' => 'Ayrıca ULAKBİM\'de dizinlenen ulusal veya uluslararası hakemli dergi '
                .'ya da kitaplarda en az bir yayın koşulu var.',
            'universite' => 'Gaziantep İslam Bilim ve Teknoloji Üniversitesi',
            'kadro' => 'dr_ogr_uyesi',
            'alan' => $alanlar,
            'cetvel' => 'gibtu-2024',
            'notlar' => "{$madde}/A: {$kumeAdi} en az {$drBaraj[0]}; 4-5-6 numaralı maddelerden en az {$drBaraj[1]}; genel toplam {$drBaraj[2]}.",
            'sart' => Kalip::ve("Dr. Öğr. Üyesi — {$ad}", [
                Kalip::toplam($drBaraj[2]),
                Kalip::puanDan("{$kumeAdi} en az {$drBaraj[0]} puan", $makaleKume, $drBaraj[0], madde: "{$madde}/A.1"),
                // Spor ve güzel sanatlarda Dr. Öğr. Üyeliği için 4-5-6
                // barajı yok; sıfır eşikli bir düğüm koşul değil, gürültüdür.
                ...($drBaraj[1] > 0 ? [Kalip::puanDan(
                    "Kitap, çeviri ve bildirilerinizden en az {$drBaraj[1]} puan",
                    ['4-5-6'], $drBaraj[1], madde: "{$madde}/A.1")] : []),
                Kalip::adet('ULAKBİM\'de dizinlenen dergi veya kitaplarda en az 1 yayın',
                    ['1.d', '1.f', '4.c', '4.d'], 1, madde: "{$madde}/A.2"),
            ]),
        ],
        [
            'anahtar' => "gibtu-docent-{$anahtar}",
            'aday_notu' => 'Bu koşullar doçentlik başvurusunun asgari şartlarına EK olarak aranıyor.',
            'universite' => 'Gaziantep İslam Bilim ve Teknoloji Üniversitesi',
            'kadro' => 'docentlik',
            'alan' => $alanlar,
            'cetvel' => 'gibtu-2024',
            'notlar' => "{$madde}/B: {$kumeAdi} en az {$docBaraj[0]}; 4-5-6 numaralı maddelerden en az {$docBaraj[1]}; genel toplam {$docBaraj[2]}.",
            'sart' => Kalip::ve("Doçent — {$ad}", [
                Kalip::beyan('Doçentlik eser aşamasında başarılı bulunmuş olmak', "{$madde}/B.1"),
                Kalip::toplam($docBaraj[2]),
                Kalip::adet("{$kumeAdi} başlıca yazar olduğunuz en az 1 makale",
                    $makaleKume, 1, 'baslica', madde: "{$madde}/B.2"),
                Kalip::puanDan("{$kumeAdi} en az {$docBaraj[0]} puan", $makaleKume, $docBaraj[0], madde: "{$madde}/B.3"),
                Kalip::puanDan("Kitap, çeviri ve bildirilerinizden en az {$docBaraj[1]} puan",
                    ['4-5-6'], $docBaraj[1], madde: "{$madde}/B.3"),
            ]),
        ],
        [
            'anahtar' => "gibtu-profesor-{$anahtar}",
            'aday_notu' => 'Doçentlik eser aşaması sonrası koşullara ek olarak, doçentlik ÖNCESİ '
                .'çalışmalarınız dâhil genel toplam barajı da sağlanmalı.',
            'universite' => 'Gaziantep İslam Bilim ve Teknoloji Üniversitesi',
            'kadro' => 'profesorluk',
            'alan' => $alanlar,
            'cetvel' => 'gibtu-2024',
            'notlar' => "{$madde}/C: doçentlik sonrası {$kumeAdi} en az {$profBaraj[0]}; 4-5-6'dan {$profBaraj[1]}; doçentlik sonrası toplam {$profBaraj[2]}; genel toplam {$profBaraj[3]}.",
            'sart' => Kalip::ve("Profesör — {$ad}", [
                Kalip::toplam($profBaraj[3]),
                Kalip::toplam($profBaraj[2], $P),
                Kalip::puanDan("{$kumeAdi} en az {$profBaraj[0]} puan", $makaleKume, $profBaraj[0], $P, madde: "{$madde}/C.1"),
                Kalip::puanDan("Kitap, çeviri ve bildirilerinizden en az {$profBaraj[1]} puan",
                    ['4-5-6'], $profBaraj[1], $P, madde: "{$madde}/C.1"),
                Kalip::adet("{$kumeAdi} başlıca yazar olduğunuz en az 1 makale",
                    $makaleKume, 1, 'baslica', $P, madde: "{$madde}/C.2"),
            ]),
        ],
    ];
};

/** Fen ve sağlık alanlarında baraj yalnızca WoS ve ESCI dergilerinden. */
$dar = ['1.a-1.b'];
$darAdi = 'SCI, SSCI, AHCI veya E-SCI dergilerindeki makalelerinizden';

/** Diğer alanlarda 1 numaralı maddenin tamamı sayılıyor. */
$genis = ['1'];
$genisAdi = 'Tüm hakemli dergilerdeki araştırma makalelerinizden';

return [
    ...$alan('fen', 'Fen Bilimleri, Matematik ve Mühendislik', 'Madde 11',
        ['fen', 'muhendislik', 'ziraat'], $dar, $darAdi, [20, 10, 60], [40, 20, 120], [40, 20, 100, 200]),

    ...$alan('saglik', 'Sağlık Bilimleri', 'Madde 12',
        ['saglik'], $dar, $darAdi, [20, 10, 60], [40, 20, 120], [40, 20, 100, 200]),

    ...$alan('sosyal', 'Eğitim, Sosyal ve Beşeri Bilimler', 'Madde 13',
        ['sosyal', 'egitim', 'filoloji', 'hukuk', 'ilahiyat'], $genis, $genisAdi,
        [20, 10, 40], [40, 20, 100], [40, 20, 100, 180]),

    ...$alan('spor', 'Spor Bilimleri', 'Madde 14',
        ['spor'], $genis, $genisAdi, [15, 0, 30], [40, 20, 100], [40, 20, 100, 180]),

    ...$alan('guzel-sanatlar', 'Mimarlık, Güzel Sanatlar ve Konservatuvar', 'Madde 15',
        ['mimarlik', 'guzel_sanatlar'], $genis, $genisAdi,
        [15, 0, 30], [40, 20, 100], [40, 20, 100, 180]),
];
