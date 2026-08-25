<?php

/**
 * ALANYA ÜNİVERSİTESİ — Öğretim Üyeliğine Atama ve Yükseltme Yönergesi
 * Kaynak: pdf/17537096222.alanyauniversitesi.pdf
 *
 * KORPUSUN EN SADE YÖNERGESİ: alan ayrımı yok, sayı koşulu yok, dönem kısıtı
 * yok. Madde 5-7 üç kadro için tek bir toplam puan söylüyor:
 *   Dr. Öğr. Üyesi   20 puan
 *   Doçent           50 puan
 *   Profesör         60 puan
 * Ölçüt yalnızca EK-1 tablosundan toplanan puan; başka hiçbir kapı yok.
 *
 * ALAN AYRIMI OLMADIĞI İÇİN ON İKİ TEMEL ALANIN HEPSİNE yazıldı. Yönergenin
 * anmadığı bir alan yok — "tüm başvurular" diyor.
 *
 * ── BARAJLARIN DÜŞÜKLÜĞÜ KASITLI ──
 * 20/50/60 korpusun en düşük değerleri. Bu bir veri hatası değil: Madde 9
 * "bu yönergenin ekinde belirtilen kriterler sadece bir ÖNKOŞUL niteliği
 * taşımakta olup, bilimsel değerlendirme jüri üyeleri tarafından yapılacaktır"
 * diyor. Yönerge kapıyı bilinçli olarak alçak tutup kararı jüriye bırakıyor.
 * Aday notunda söylendi ki aday "bu kadar kolay olamaz" diye şüphelenmesin.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Yeniden atanma yönergede hiç yok.
 *   Yabancı dil şartı yönergede geçmiyor; uydurulmadı.
 *   Madde 4'ün "jüri heyeti tarafından hazırlanan rapor esas alınır" hükmü
 *       değerlendirme süreci, adayın sağlayacağı bir koşul değil.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/alanya-2024.php
 */

use App\Enums\TemelAlan;
use App\Services\Scoring\Sart\Kalip;

$tumAlanlar = array_column(TemelAlan::cases(), 'value');

$onkosulNotu = 'Yönerge bu puanı bir ÖNKOŞUL sayıyor (Madde 9): barajı geçmek atanmaya yetmez, '
    .'asıl değerlendirmeyi jüri yapıyor. Barajın korpusun en düşükleri arasında olması bu '
    .'yüzden.';

return [
    [
        'anahtar' => 'alanya-dr',
        'aday_notu' => 'Tek koşul: EK-1 tablosundan 20 puan. Tek bir SSCI/SCI-E makale '
            .'(20 puan) tek başına yetiyor. '.$onkosulNotu,
        'universite' => 'Alanya Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $tumAlanlar,
        'cetvel' => 'alanya-2024',
        'notlar' => 'Madde 5: "Ek-1\'de yer alan Akademik Atama ve Yükseltme Ölçütleri '
            .'tablosundan toplam 20 puanı sağlaması gerekmektedir." Alan ayrımı, sayı koşulu '
            .'ve dönem kısıtı yok.',
        'sart' => Kalip::toplam(20),
    ],
    [
        'anahtar' => 'alanya-docent',
        'aday_notu' => 'Tek sayısal koşul EK-1 tablosundan 50 puan; yönerge dönem kısıtı '
            .'koymuyor, doktoradan önceki çalışmalarınız da sayılıyor. '.$onkosulNotu,
        'universite' => 'Alanya Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $tumAlanlar,
        'cetvel' => 'alanya-2024',
        'notlar' => 'Madde 6: tablodan toplam 50 puan. Dönem kısıtı belirtilmemiş.',
        'sart' => Kalip::ve('Doçent kadrosuna atanma', [
            Kalip::beyan('Üniversitelerarası Kurul\'dan doçentlik unvanını almış olmak', '2547 sayılı Kanun md. 24'),
            Kalip::toplam(50),
        ]),
    ],
    [
        'anahtar' => 'alanya-profesor',
        'aday_notu' => 'Tek sayısal koşul EK-1 tablosundan 60 puan — doçentlik barajının '
            .'yalnızca 10 puan üstünde. Yönerge doçentlik sonrası için ayrı bir pay istemiyor. '
            .$onkosulNotu,
        'universite' => 'Alanya Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $tumAlanlar,
        'cetvel' => 'alanya-2024',
        'notlar' => 'Madde 7: tablodan toplam 60 puan. Doçentlik sonrası pay şartı yok; '
            .'korpusta doçentlik ile profesörlük arasındaki farkın en dar olduğu örneklerden.',
        'sart' => Kalip::ve('Profesör kadrosuna atanma', [
            Kalip::beyan('Doçentlik unvanına sahip olmak ve 2547 sayılı Kanun\'un 26. maddesindeki koşulları sağlamak', '2547 sayılı Kanun md. 26'),
            Kalip::toplam(60),
        ]),
    ],
];
