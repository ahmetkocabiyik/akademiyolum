<?php

/**
 * ERCİYES ÜNİVERSİTESİ — Akademik Yükseltme ve Atama Kriterleri Yönergesi
 * Kaynak: pdf/17536993342.erciyesuniverstesi.pdf
 *
 * YAPI SADE: tek ortak puanlama tablosu (Tablo 7) ve alan grubu başına asgari
 * puan tablosu (Tablo 1-6). Koşullar iki satırdan ibaret — bir yayın puanı
 * barajı ve bir toplam puan barajı.
 *
 * ALTI ALAN GRUBU ve iki farklı eşik deseni:
 *
 *   Sağlık ve Yaşam Bilimleri     1(a-d)'den 50/100/200 · toplam 75/350/650
 *   Fen ve Mühendislik            1(a-d)'den 50/100/200 · toplam 75/350/650
 *   Sosyal ve Beşerî Bilimler     1(a-f)+4(a,c)'den 40/75/150 · toplam 75/300/550
 *   İktisadi ve İdari Bilimler    aynı
 *   Mimarlık                      aynı
 *   Güzel Sanatlar                aynı
 *
 * Fen/Sağlık grubu yalnızca WoS çeyrekli dergileri sayarken, sosyal gruplar
 * ESCI ve TR Dizin'i de sayıyor ve kitap kalemlerini yayın puanına katıyor.
 *
 * DÖNEM KOŞULU: "Profesör kadrosuna atanabilmek için asgari yayın puanlarının
 * TAMAMI, toplam asgari puanın ise en az %50'si doçent unvanı alındıktan sonra
 * elde edilmiş olmalıdır." Doçentlikte aynı kural doktora sonrası için geçerli.
 * Bu yüzden yayın barajı dönem kapsamlı, toplam barajı iki düğüm.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/erciyes-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

/** Tablo 1-2 (Sağlık, Fen/Mühendislik) — yayın puanı yalnızca 1(a-d)'den. */
$fenSaglik = ['saglik', 'fen', 'muhendislik', 'ziraat'];

/** Tablo 3-6 — yayın puanına ESCI, TR Dizin ve kitap da giriyor. */
$sosyalGrup = ['sosyal', 'egitim', 'filoloji', 'hukuk', 'ilahiyat', 'spor'];

/**
 * Erciyes'in her kadroda tekrarlayan iki barajı.
 *
 * @param  list<string>  $yayinKumesi
 * @return list<array<string, mixed>>
 */
$barajlar = function (
    array $yayinKumesi,
    int $yayinPuani,
    int $toplam,
    ?array $donem = null,
    string $kume = '1(a-d)',
    string $kumeAdi = 'WoS Q1-Q4 dergilerindeki makalelerinizden',
): array {
    $dugumler = [
        Kalip::puanDan("{$kumeAdi} en az {$yayinPuani} puan",
            array_values($yayinKumesi), $yayinPuani, $donem, madde: "Tablo · {$kume}"),
        Kalip::toplam($toplam),
    ];

    // "Toplam asgari puanın en az %50'si" dönem kapsamlı ikinci baraj.
    if ($donem !== null) {
        $dugumler[] = Kalip::toplam((int) ceil($toplam / 2), $donem);
    }

    return $dugumler;
};

return [
    // ══════════ SAĞLIK ve YAŞAM / FEN ve MÜHENDİSLİK (Tablo 1-2) ══════════
    [
        'anahtar' => 'erciyes-dr-fen-saglik',
        'aday_notu' => 'Yayın puanı yalnızca WoS çeyrekli dergilerden (Q1-Q4) sayılıyor; ESCI ve TR Dizin makaleleri toplam puana girer ama yayın barajına girmez.',
        'universite' => 'Erciyes Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $fenSaglik,
        'cetvel' => 'erciyes-2024',
        'notlar' => 'Tablo 1 ve 2, Dr. Öğretim Üyesi (İlk Atama): 1(a-d) asgari 50, toplam asgari 75.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Sağlık / Fen / Mühendislik', [
            ...$barajlar(['1(a-d)'], 50, 75),
            Kalip::yds(65),
        ]),
    ],
    [
        'anahtar' => 'erciyes-docent-fen-saglik',
        'aday_notu' => 'Yayın puanının tamamı ve toplam puanın en az yarısı doktora unvanını aldığınız tarihten sonra elde edilmiş olmalı.',
        'universite' => 'Erciyes Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $fenSaglik,
        'cetvel' => 'erciyes-2024',
        'notlar' => 'Tablo 1 ve 2, Doçent: 1(a-d) asgari 100, toplam asgari 350. Asgari yayın puanının tamamı ve toplam asgari puanın %50\'si doktora/uzmanlık sonrası olmalı.',
        'sart' => Kalip::ve('Doçent — Sağlık / Fen / Mühendislik', [
            Kalip::beyan('Üniversitelerarası Kuruldan doçentlik unvanı almış olmak', 'Madde 3'),
            ...$barajlar(['1(a-d)'], 100, 350, Kalip::DOKTORA_SONRASI),
            Kalip::yds(65),
        ]),
    ],
    [
        'anahtar' => 'erciyes-profesor-fen-saglik',
        'aday_notu' => 'Yayın puanının tamamı ve toplam puanın en az yarısı doçent unvanını aldığınız tarihten sonra elde edilmiş olmalı.',
        'universite' => 'Erciyes Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $fenSaglik,
        'cetvel' => 'erciyes-2024',
        'notlar' => 'Tablo 1 ve 2, Profesör: 1(a-d) asgari 200, toplam asgari 650. Asgari yayın puanının tamamı ve toplam asgari puanın %50\'si doçentlik sonrası olmalı.',
        'sart' => Kalip::ve('Profesör — Sağlık / Fen / Mühendislik', [
            Kalip::beyan('Doçent unvanını aldıktan sonraki yayınlarından birini başlıca araştırma eseri olarak sunmak', 'Madde 3/iv'),
            Kalip::beyan('Doçentlik sonrası yasal sürenin en az yarısı kadar üniversitede veya araştırma kuruluşunda fiilen çalışmış olmak', 'Madde 3/v'),
            ...$barajlar(['1(a-d)'], 200, 650, Kalip::DOCENTLIK_SONRASI),
            Kalip::yds(65),
        ]),
    ],

    // ══════════ SOSYAL / İİBF / MİMARLIK / GÜZEL SANATLAR (Tablo 3-6) ══════════
    [
        'anahtar' => 'erciyes-dr-sosyal',
        'aday_notu' => 'Bu alanlarda yayın barajına ESCI ve TR Dizin makaleleri ile özgün kitap ve kitap bölümü de giriyor.',
        'universite' => 'Erciyes Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $sosyalGrup,
        'cetvel' => 'erciyes-2024',
        'notlar' => 'Tablo 3-6, Dr. Öğretim Üyesi (İlk Atama): 1(a-f), 4(a), 4(c) asgari 40, toplam asgari 75.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Sosyal / İİBF / Mimarlık / Güzel Sanatlar', [
            ...$barajlar(['1(a-d)', '1(e-g)', '4a', '4c'], 40, 75, kume: '1(a-f) ve kitap',
                kumeAdi: 'WoS, ESCI ve TR Dizin makaleleriniz ile özgün kitap ve kitap bölümlerinizden'),
            Kalip::yds(65),
        ]),
    ],
    [
        'anahtar' => 'erciyes-docent-sosyal',
        'aday_notu' => 'Yayın puanının tamamı ve toplam puanın en az yarısı doktora unvanını aldığınız tarihten sonra elde edilmiş olmalı.',
        'universite' => 'Erciyes Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $sosyalGrup,
        'cetvel' => 'erciyes-2024',
        'notlar' => 'Tablo 3-6, Doçent: 1(a-f), 4(a), 4(c) asgari 75, toplam asgari 300.',
        'sart' => Kalip::ve('Doçent — Sosyal / İİBF / Mimarlık / Güzel Sanatlar', [
            Kalip::beyan('Üniversitelerarası Kuruldan doçentlik unvanı almış olmak', 'Madde 3'),
            ...$barajlar(['1(a-d)', '1(e-g)', '4a', '4c'], 75, 300, Kalip::DOKTORA_SONRASI, '1(a-f) ve kitap',
                kumeAdi: 'WoS, ESCI ve TR Dizin makaleleriniz ile özgün kitap ve kitap bölümlerinizden'),
            Kalip::yds(65),
        ]),
    ],
    [
        'anahtar' => 'erciyes-profesor-sosyal',
        'aday_notu' => 'Yayın puanının tamamı ve toplam puanın en az yarısı doçent unvanını aldığınız tarihten sonra elde edilmiş olmalı.',
        'universite' => 'Erciyes Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $sosyalGrup,
        'cetvel' => 'erciyes-2024',
        'notlar' => 'Tablo 3-6, Profesör: 1(a-f), 4(a), 4(c) asgari 150, toplam asgari 550.',
        'sart' => Kalip::ve('Profesör — Sosyal / İİBF / Mimarlık / Güzel Sanatlar', [
            Kalip::beyan('Doçent unvanını aldıktan sonraki yayınlarından birini başlıca araştırma eseri olarak sunmak', 'Madde 3/iv'),
            Kalip::beyan('Doçentlik sonrası yasal sürenin en az yarısı kadar üniversitede veya araştırma kuruluşunda fiilen çalışmış olmak', 'Madde 3/v'),
            ...$barajlar(['1(a-d)', '1(e-g)', '4a', '4c'], 150, 550, Kalip::DOCENTLIK_SONRASI, '1(a-f) ve kitap',
                kumeAdi: 'WoS, ESCI ve TR Dizin makaleleriniz ile özgün kitap ve kitap bölümlerinizden'),
            Kalip::yds(65),
        ]),
    ],
];
