<?php

/**
 * ADIYAMAN ÜNİVERSİTESİ — Akademik Yükseltilme ve Atanma İlkeleri Yönergesi
 * Kaynak: pdf/17536926992.adiyamanuniversitesi.pdf (Senato 30/04/2024)
 *
 * BEŞ BİLİM ALANI (Madde 14) ama eşik tabloları DÖRT satır:
 *   Sağlık · Mühendislik · Fen (Matematik dâhil)  → tek satırda birleşiyor
 *   Sosyal Bilimler
 *   Güzel Sanatlar / kuramsal alanlar
 *   Güzel Sanatlar / uygulamalı alanlar
 *
 * Kuramsal ve uygulamalı güzel sanatlar ayrımı faaliyet kaydından
 * türetilemiyor (adayın bölümüne bağlı, faaliyetine değil). UYGULAMALI satır
 * girildi: A-D barajı 50, üstüne N1-N16'dan 200 puan. Kuramsal alandaki aday
 * için A-D barajı 200 ve sanat barajı yok — bu fark aday notunda anıldı.
 *
 * DR. ÖĞR. ÜYESİ MAKALE KOŞULU ALANA GÖRE DEĞİŞİYOR (Madde 19):
 *   Fen/Müh/Matematik/Sağlık  SCI veya SCI-E'de en az 1 olmak üzere 3 makale
 *   Sosyal                    SSCI/AHCI'de 1 makale YA DA hakemli dergilerde 3
 *   Mimarlık/Güzel Sanatlar   SCI/SSCI/SCI-E/AHCI'de 1 makale YA DA hakemli
 *                             dergilerde 2 makale
 *
 * DOÇENTLİK İÇİN AYRI PUAN TABLOSU YOK. Madde 21 yalnızca ÜAK doçentlik
 * unvanını şart koşuyor; yönergenin kendi asgari puan tabloları (Tablo 3 ve 4)
 * doktor öğretim üyeliği ve profesörlük için. Doçent eşiği bu yüzden yalnızca
 * unvan beyanından oluşuyor — yönergede olmayan bir baraj uydurmak, adaya
 * gerçekte aranmayan bir koşulu aranıyormuş gibi gösterirdi.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/adiyaman-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$P = Kalip::DOCENTLIK_SONRASI;

/**
 * Bir alan grubunun üç kadrosunu üretir.
 *
 * @param  list<string>  $alanlar
 * @param  array{int, int}  $dr  A-D barajı · asgari toplam
 * @param  array{int, int}  $prof
 * @param  list<array<string, mixed>>  $drMakale
 * @param  list<array<string, mixed>>  $ek  Her kadroda geçerli ek düğümler
 * @return list<array<string, mixed>>
 */
$alan = function (
    string $anahtar,
    string $ad,
    array $alanlar,
    array $dr,
    array $prof,
    array $drMakale,
    array $ek = [],
    ?string $adayNotu = null,
) use ($P): array {
    $alanlar = array_values($alanlar);

    // B, D ve F bölümlerinin tavanı "asgari toplam puanlamanın yüzdesi" ve
    // taban kadro × alan grubuna göre değişiyor; cetvel bu yüzden
    // varyantlanıyor. Doçentlikte toplam puan barajı yok, taban da yok.
    $cetvel = fn (string $kadro): string => "adiyaman-2024-{$anahtar}-{$kadro}";
    $ek = array_values($ek);

    return [
        [
            'anahtar' => "adiyaman-dr-{$anahtar}",
            'aday_notu' => $adayNotu ?? 'Yeniden atanmada süre, son dönemde yaptığınız yayının '
                .'çeyrekliğine göre değişiyor: Q1-Q2 dergide bir yayın 4 yıl, Q3-Q4 dergide bir '
                .'yayın 3 yıl, diğer hakemli dergilerde iki makale 2 yıl.',
            'universite' => 'Adıyaman Üniversitesi',
            'kadro' => 'dr_ogr_uyesi',
            'alan' => $alanlar,
            'cetvel' => $cetvel('dr'),
            'notlar' => "Madde 19 ve Tablo 3 ({$ad}): A-D arası faaliyetlerden en az {$dr[0]}, asgari toplam {$dr[1]} puan.",
            'sart' => Kalip::ve("Dr. Öğr. Üyesi — {$ad}", [
                Kalip::yds(65),
                Kalip::toplam($dr[1]),
                Kalip::puanDan("Makale, bildiri, kitap ve atıflarınızdan en az {$dr[0]} puan",
                    ['A-D'], $dr[0], madde: 'Tablo 3 · A-D'),
                ...array_values($drMakale),
                ...$ek,
            ]),
        ],
        [
            'anahtar' => "adiyaman-docent-{$anahtar}",
            'aday_notu' => 'Adıyaman yönergesi doçentlik için kendi puan tablosunu uygulamıyor; '
                .'Yönerge yalnızca ÜAK doçentlik unvanını şart koşuyor. Bu yüzden burada puan '
                .'barajı görmüyorsunuz — eksik veri değil, yönergede öyle.',
            'universite' => 'Adıyaman Üniversitesi',
            'kadro' => 'docentlik',
            'alan' => $alanlar,
            'cetvel' => 'adiyaman-2024',
            'notlar' => "Madde 21 ({$ad}): yalnızca ÜAK doçentlik unvanı veya yurt dışı eşdeğerliği.",
            'sart' => Kalip::ve("Doçent — {$ad}", [
                Kalip::beyan('2547 sayılı Kanunun 24. maddesi uyarınca doçentlik unvanını almış olmak '
                    .'veya yurt dışında alınan unvanın Üniversitelerarası Kurulca Türkiye\'de geçerli '
                    .'sayılmış olması', 'Madde 21'),
            ]),
        ],
        [
            'anahtar' => "adiyaman-profesor-{$anahtar}",
            'aday_notu' => 'Ön koşul iki seçenekli: doçentlik sonrası dizinli bir dergide bir makale '
                .'ya da tek yazarlı veya lisansüstü öğrencinizle birlikte yazılmış, tezinizden '
                .'üretilmemiş bir kitap.',
            'universite' => 'Adıyaman Üniversitesi',
            'kadro' => 'profesorluk',
            'alan' => $alanlar,
            'cetvel' => $cetvel('prof'),
            'notlar' => "Madde 22 ve Tablo 4 ({$ad}): A-D arası faaliyetlerden en az {$prof[0]}, asgari toplam {$prof[1]} puan.",
            'sart' => Kalip::ve("Profesör — {$ad}", [
                Kalip::toplam($prof[1]),
                Kalip::puanDan("Makale, bildiri, kitap ve atıflarınızdan en az {$prof[0]} puan",
                    ['A-D'], $prof[0], madde: 'Tablo 4 · A-D'),
                Kalip::veya('Ön koşul (iki seçenekten biri)', [
                    Kalip::adet('Doçentlik sonrası SCI, SSCI veya AHCI dergide en az 1 makale',
                        ['A.1'], 1, donem: $P, madde: 'Madde 22/a'),
                    Kalip::beyan('Ya da doçentlik sonrası, tek yazarlı veya lisansüstü öğrencinizle '
                        .'birlikte yazılmış, kendi tezinizden üretilmemiş yayımlanmış kitap', 'Madde 22/a'),
                ]),
                ...$ek,
            ]),
        ],
    ];
};

return [
    // ══════════ SAĞLIK, FEN, MATEMATİK VE MÜHENDİSLİK ══════════
    ...$alan('fen', 'Sağlık, Fen, Matematik ve Mühendislik Bilimleri',
        ['saglik', 'fen', 'muhendislik', 'ziraat'], [300, 400], [400, 900],
        [
            Kalip::adet('SCI veya SCI-E dergilerinde en az 1 makale', ['A.1'], 1, madde: 'Madde 19/a'),
            Kalip::adet('Toplam en az 3 makale', ['MAKALE'], 3, madde: 'Madde 19/a'),
        ]),

    // ══════════ SOSYAL BİLİMLER ══════════
    ...$alan('sosyal', 'Sosyal Bilimler',
        ['sosyal', 'egitim', 'filoloji', 'hukuk', 'ilahiyat', 'spor'], [200, 300], [300, 700],
        [Kalip::veya('Makale koşulu (iki seçenekten biri)', [
            Kalip::adet('SSCI veya AHCI dergilerinde en az 1 makale', ['A.1'], 1, madde: 'Madde 19/b'),
            Kalip::adet('Ya da ulusal/uluslararası hakemli dergilerde en az 3 makale',
                ['MAKALE'], 3, madde: 'Madde 19/b'),
        ])]),

    // ══════════ MİMARLIK VE GÜZEL SANATLAR (uygulamalı alanlar) ══════════
    ...$alan('guzel-sanatlar', 'Mimarlık ve Güzel Sanatlar Bilimleri',
        ['mimarlik', 'guzel_sanatlar'], [50, 300], [200, 900],
        [Kalip::veya('Makale koşulu (iki seçenekten biri)', [
            Kalip::adet('SCI, SSCI, SCI-E veya AHCI dergilerinde en az 1 makale',
                ['A.1'], 1, madde: 'Madde 19/c'),
            Kalip::adet('Ya da ulusal/uluslararası hakemli dergilerde en az 2 makale',
                ['MAKALE'], 2, madde: 'Madde 19/c'),
        ])],
        [Kalip::puanDan('Sanat ve tasarım etkinliklerinizden en az 200 puan',
            ['N1-N16'], 200, madde: 'Tablo 3 · N1-N16')],
        'Bu eşik UYGULAMALI alanlar içindir. Kuramsal alanlarda A-D barajı 50 yerine 200, '
            .'sanat etkinliği barajı ise aranmıyor; bölümünüz kuramsal ise sanat barajını '
            .'dikkate almayın.'),
];
