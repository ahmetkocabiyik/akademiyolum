<?php

/**
 * ANADOLU ÜNİVERSİTESİ — Öğretim Üyeliği Kadrolarına Yükseltme ve Atama
 * Ölçütleri
 * Kaynak: pdf/17536928752.anadoluuniversitesi.pdf (01/08/2023 yürürlük)
 *
 * TOPLAM BARAJ İKİ ALAN GRUBUNA GÖRE, ALT BARAJLAR DÖRT GRUBA GÖRE. Yönerge
 * toplam puanı ikiye ayırıyor ama alt barajlarda Hukuk'u ve Güzel Sanatlar'ı
 * kendi satırlarına çekiyor:
 *
 *   toplam            sosyal grubu 400/900/900 · fen grubu 600/1500/1500
 *   1-2. maddeler     sosyal 80/150/150 · fen 150/300/300 · güzel sanatlar 150
 *   1-3. maddeler     yalnızca Hukuk: 200/350/350
 *   28-40. maddeler   yalnızca Güzel Sanatlar: doçentlikte 150, profesörlükte 300
 *   41-45. maddeler   bütün alanlarda: 30 (yeniden atanma) / 45 / 60
 *
 * Yani Hukuk ve Güzel Sanatlar toplam barajda sosyal grupla aynı, alt barajda
 * ayrı. Bu yüzden dört ayrı eşik kümesi üretiliyor.
 *
 * FEN GRUBUNDA EK KOŞUL: Dr. Öğr. Üyesi ilk atamada eserlerden en az birinin
 * SCI, SCI-Expanded, SSCI veya AHCI dergisinde yayımlanmış olması gerekiyor.
 *
 * DÖNEM: doçentlikte doktora/uzmanlık/sanatta yeterlik sonrası, profesörlükte
 * doçent unvanı sonrası çalışmalar sayılıyor. Dr. Öğr. Üyesi ilk atamada
 * dönem kaydı yok; yeniden atanmada "bir önceki atama tarihinden sonraki
 * çalışmalar" deniyor ama motor bu kadroyu ayrı tanımadığı için ilk atama
 * koşulları girildi ve yeniden atanma barajı aday notunda anıldı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/anadolu-2023.php
 */

use App\Services\Scoring\Sart\Kalip;

/** Toplam barajda düşük eşiğe tabi alanlar (Hukuk ve Güzel Sanatlar dâhil). */
$sosyalToplam = ['egitim', 'filoloji', 'sosyal', 'mimarlik', 'ilahiyat', 'spor'];

/** Toplam barajda yüksek eşiğe tabi alanlar. */
$fenToplam = ['fen', 'muhendislik', 'ziraat', 'saglik'];

$D = Kalip::DOKTORA_SONRASI;
$P = Kalip::DOCENTLIK_SONRASI;

/**
 * Bir alan grubunun üç kadrosunu üretir.
 *
 * @param  list<string>  $alanlar
 * @param  array{int, int, int}  $toplam  Dr / Doçent / Profesör toplam barajı
 * @param  array{int, int, int}  $yayin  1-2 (Hukuk'ta 1-3) madde barajı
 * @param  list<string>  $yayinKume
 * @param  array{dr?: list<array<string, mixed>>, docent?: list<array<string, mixed>>, profesor?: list<array<string, mixed>>}  $ekKadro
 *                                                                                                                                       Kadroya özgü ek düğümler — yönergedeki ek koşulların çoğu tek kadroya ait
 * @return list<array<string, mixed>>
 */
$grup = function (
    string $anahtar,
    string $ad,
    array $alanlar,
    array $toplam,
    array $yayin,
    array $yayinKume,
    string $yayinAdi,
    array $ekKadro = [],
) use ($D, $P): array {
    $alanlar = array_values($alanlar);

    /** @return list<array<string, mixed>> */
    $ortak = function (int $t, int $y, ?array $donem, int $ogretim) use ($yayinKume, $yayinAdi): array {
        return [
            Kalip::toplam($t, $donem),
            Kalip::puanDan("{$yayinAdi} en az {$y} puan", array_values($yayinKume), $y, $donem,
                madde: 'Ölçütler II · 1-2. madde'),
            Kalip::puanDan("Verdiğiniz dersler ve tez danışmanlıklarınızdan en az {$ogretim} puan",
                ['41-45'], $ogretim, $donem, madde: 'Ölçütler II · 41-45. madde'),
        ];
    };

    return [
        [
            'anahtar' => "anadolu-dr-{$anahtar}",
            'aday_notu' => 'Bu koşullar İLK KEZ atanma içindir. Yeniden atanmada her dört yıllık dönem '
                .'için ders ve tez danışmanlığı barajı 30 puana iner ve yalnızca bir önceki atama '
                .'tarihinden sonraki çalışmalarınız sayılır.',
            'universite' => 'Anadolu Üniversitesi',
            'kadro' => 'dr_ogr_uyesi',
            'alan' => $alanlar,
            'cetvel' => 'anadolu-2023',
            'notlar' => "Bölüm A ({$ad}): toplam {$toplam[0]}, 1-2. maddelerden {$yayin[0]}.",
            'sart' => Kalip::ve("Dr. Öğr. Üyesi — {$ad}", [
                Kalip::beyan('Doktora, sanatta yeterlik veya tıpta uzmanlık derecesine sahip olmak', 'Bölüm A/1'),
                Kalip::yds(65),
                ...array_slice($ortak($toplam[0], $yayin[0], null, 30), 0, 2),
                ...array_values($ekKadro['dr'] ?? []),
            ]),
        ],
        [
            'anahtar' => "anadolu-docent-{$anahtar}",
            'aday_notu' => 'Bütün koşullar doktora, uzmanlık veya sanatta yeterlik sonrası '
                .'çalışmalarınızla sağlanmalı.',
            'universite' => 'Anadolu Üniversitesi',
            'kadro' => 'docentlik',
            'alan' => $alanlar,
            'cetvel' => 'anadolu-2023',
            'notlar' => "Bölüm C ({$ad}): toplam {$toplam[1]}, 1-2. maddelerden {$yayin[1]}, 41-45. maddelerden 45.",
            'sart' => Kalip::ve("Doçent — {$ad}", [
                Kalip::beyan('Doçentlik unvanını almış ve doçentlik sözlü sınavında başarılı olmak', 'Bölüm C/2'),
                ...$ortak($toplam[1], $yayin[1], $D, 45),
                ...array_values($ekKadro['docent'] ?? []),
            ]),
        ],
        [
            'anahtar' => "anadolu-profesor-{$anahtar}",
            'aday_notu' => 'Bütün koşullar doçent unvanınızı aldıktan sonraki çalışmalarınızla sağlanmalı.',
            'universite' => 'Anadolu Üniversitesi',
            'kadro' => 'profesorluk',
            'alan' => $alanlar,
            'cetvel' => 'anadolu-2023',
            'notlar' => "Bölüm D ({$ad}): toplam {$toplam[2]}, 1-2. maddelerden {$yayin[2]}, 41-45. maddelerden 60.",
            'sart' => Kalip::ve("Profesör — {$ad}", [
                Kalip::adet('Desteklenen bir araştırma projesini yürütücü olarak başarıyla tamamlamış olmak',
                    ['8', '10', '12', '15'], 1, donem: $P, madde: 'Bölüm D/1'),
                ...$ortak($toplam[2], $yayin[2], $P, 60),
                ...array_values($ekKadro['profesor'] ?? []),
                Kalip::beyan('Makale, kitap veya kitap bölümü çalışmalarınızdan birini başlıca eser olarak '
                    .'sunmak (doçentlik sonrası tek yazarlı veya birinci isimli)', 'Bölüm D/4'),
            ]),
        ],
    ];
};

return [
    // ══════════ SOSYAL GRUBU (Hukuk ve Güzel Sanatlar hariç) ══════════
    ...$grup('sosyal', 'Eğitim, Filoloji, Sosyal, Mimarlık, İlahiyat, Spor',
        $sosyalToplam, [400, 900, 900], [80, 150, 150], ['1-2'],
        'SCI-Expanded, SSCI, AHCI, ESCI veya Scopus dergilerindeki makalelerinizden'),

    // ══════════ FEN GRUBU ══════════
    ...$grup('fen', 'Fen, Mühendislik, Ziraat, Sağlık Bilimleri',
        $fenToplam, [600, 1500, 1500], [150, 300, 300], ['1-2'],
        'SCI-Expanded, SSCI, AHCI, ESCI veya Scopus dergilerindeki makalelerinizden',
        ekKadro: ['dr' => [Kalip::adet(
            'Eserlerinizden en az biri SCI, SCI-Expanded, SSCI veya AHCI dergisinde yayımlanmış olmalı',
            ['1'], 1, madde: 'Bölüm A/3-b')]]),

    // ══════════ HUKUK ══════════
    // Toplam baraj sosyal grupla aynı, alt baraj TR Dizin'i de kapsayan
    // 1-3. maddelerden ve daha yüksek.
    ...$grup('hukuk', 'Hukuk', ['hukuk'], [400, 900, 900], [200, 350, 350], ['1-3'],
        'SCI-Expanded, SSCI, AHCI, ESCI, Scopus, TR Dizin veya alan indeksli dergilerdeki makalelerinizden'),

    // ══════════ GÜZEL SANATLAR ══════════
    // 1-2. madde barajı sosyal grupla aynı değil (doçentlikte de 150) ve
    // ayrıca sanatsal etkinlik barajı var.
    ...$grup('guzel-sanatlar', 'Güzel Sanatlar', ['guzel_sanatlar'],
        [400, 900, 900], [80, 150, 150], ['1-2'],
        'SCI-Expanded, SSCI, AHCI, ESCI veya Scopus dergilerindeki makalelerinizden',
        ekKadro: [
            'docent' => [Kalip::puanDan('Sanatsal etkinlik ve ödüllerinizden en az 150 puan',
                ['28-40'], 150, $D, madde: 'Ölçütler II · 28-40. madde')],
            'profesor' => [Kalip::puanDan('Sanatsal etkinlik ve ödüllerinizden en az 300 puan',
                ['28-40'], 300, $P, madde: 'Ölçütler II · 28-40. madde')],
        ]),
];
