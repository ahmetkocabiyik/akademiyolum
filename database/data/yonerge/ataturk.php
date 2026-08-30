<?php

/**
 * ATATÜRK ÜNİVERSİTESİ — şart ağaçları.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · şema: sart-agaci-taslak.php
 * `alan` dizi olabilir: SartDeposu alan başına ayrı kayda açar.
 */
use App\Services\Scoring\Sart\Kalip;

return [
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
        'aday_notu' => 'ÜAK doçentlik başvurusunda asgari şartı sağlamak için kullandığınız makaleler, havuz puanına ikinci kez sayılmıyor.',
        'universite' => 'Atatürk Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['fen', 'muhendislik', 'saglik', 'ziraat'],
        'cetvel' => 'ataturk-2026',
        'notlar' => 'A grubu: 0 ve 2. bölgelerden toplam en az 100 puan; makalelerden en az 40 puan. '
            .'Tablo dipnotu: "En az 18 puanın SCIE, SSCI veya AHCI kapsamındaki dergilerde yapılan '
            .'tam metin makalelerden alınması gerekir." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Dr. Öğr. Üyesi kadrosuna atanma', 'cocuklar' => [
            Kalip::toplam(100),
            Kalip::puanDan('Makalelerden en az 40 puan', ['MAKALE'], 40),
            Kalip::puanDan('Bunun en az 18 puanı SCIE/SSCI/AHCI dergilerden', ['INDEKS_SCIE_SSCI_AHCI'], 18),
            Kalip::yds(70),
        ]],
    ],
    [
        'anahtar' => 'ataturk-dr-a-mimarlik',
        'aday_notu' => 'ÜAK doçentlik başvurusunda asgari şartı sağlamak için kullandığınız makaleler, havuz puanına ikinci kez sayılmıyor.',
        'universite' => 'Atatürk Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['mimarlik'],
        'cetvel' => 'ataturk-2026',
        'notlar' => 'A grubu (Mimarlık/Matematik/İstatistik): indeks alt sınırı düşük — Tablo dipnotu: '
            .'"İç Mimarlık, Mimarlık, Şehir ve Bölge Planlama, Matematik ve İstatistik bölümleri için '
            .'en az 9 puanın SCIE, SSCI veya AHCI kapsamındaki dergilerde yapılan yayınlardan '
            .'alınması gerekir." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Dr. Öğr. Üyesi kadrosuna atanma (Mimarlık)', 'cocuklar' => [
            Kalip::toplam(100),
            Kalip::puanDan('Makalelerden en az 40 puan', ['MAKALE'], 40),
            Kalip::puanDan('Bunun en az 9 puanı SCIE/SSCI/AHCI dergilerden', ['INDEKS_SCIE_SSCI_AHCI'], 9),
            Kalip::yds(70),
        ]],
    ],
    [
        'anahtar' => 'ataturk-dr-b',
        'aday_notu' => 'ÜAK doçentlik başvurusunda asgari şartı sağlamak için kullandığınız makaleler, havuz puanına ikinci kez sayılmıyor.',
        'universite' => 'Atatürk Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['sosyal', 'egitim', 'filoloji', 'guzel_sanatlar', 'ilahiyat', 'spor'],
        'cetvel' => 'ataturk-2026',
        'notlar' => 'B grubu: 0 ve 2. bölgelerden toplam en az 100 puan; makalelerden en az 30 puan. '
            .'Tablo dipnotu: "En az 12 puanın SCIE, SSCI, AHCI, ESCI veya SCOPUS kapsamındaki '
            .'dergilerde yapılan yayınlardan alınması gerekir." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Dr. Öğr. Üyesi kadrosuna atanma', 'cocuklar' => [
            Kalip::toplam(100),
            Kalip::puanDan('Makalelerden en az 30 puan', ['MAKALE'], 30),
            Kalip::puanDan('Bunun en az 12 puanı SCIE/SSCI/AHCI/ESCI/Scopus dergilerden', ['INDEKS_GENIS'], 12),
            Kalip::yds(70),
        ]],
    ],
    [
        'anahtar' => 'ataturk-dr-b-hukuk',
        'aday_notu' => 'ÜAK doçentlik başvurusunda asgari şartı sağlamak için kullandığınız makaleler, havuz puanına ikinci kez sayılmıyor.',
        'universite' => 'Atatürk Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['hukuk'],
        'cetvel' => 'ataturk-2026',
        'notlar' => 'B grubu (Hukuk): Tablo dipnotu: "Hukuk temel alanı için en az 5 puanın SCIE, SSCI, '
            .'AHCI, ESCI veya SCOPUS kapsamındaki dergilerde yapılan yayınlardan alınması gerekir." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Dr. Öğr. Üyesi kadrosuna atanma (Hukuk)', 'cocuklar' => [
            Kalip::toplam(100),
            Kalip::puanDan('Makalelerden en az 30 puan', ['MAKALE'], 30),
            Kalip::puanDan('Bunun en az 5 puanı SCIE/SSCI/AHCI/ESCI/Scopus dergilerden', ['INDEKS_GENIS'], 5),
            Kalip::yds(70),
        ]],
    ],

    // ── Doçent ──
    [
        'anahtar' => 'ataturk-docent-a',
        'aday_notu' => 'ÜAK doçentlik başvurusunda asgari şartı sağlamak için kullandığınız makaleler, havuz puanına ikinci kez sayılmıyor.',
        'universite' => 'Atatürk Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['fen', 'mimarlik', 'muhendislik', 'saglik', 'ziraat'],
        'cetvel' => 'ataturk-2026',
        'notlar' => 'A grubu: ÜAK doçent unvanı + doçentlik havuz puanından toplam en az 100 puan. YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Doçent kadrosuna atanma', 'cocuklar' => [
            Kalip::toplam(100),
            Kalip::adet('SCIE/SSCI veya AHCI dergilerinde en az 2 tam metin makale', ['INDEKS_SCIE_SSCI_AHCI'], 2),
            Kalip::ve('AR-GE projesi koşulu', [
                Kalip::adet('En az 1 AR-GE projesinde yürütücü olmak', ['AR-GE-YURUTUCU'], 1, madde: 'Gösterge 02.03 / 02.04'),
                // Yönerge md. 5: 30 puanın tamamı yürütücülükten gelebilir ya da
                // en az bir yürütücülük şartıyla kalanı Q1/Q2 yayınlardan tamamlanır.
                Kalip::puanDan('Yürütücü olduğunuz projelerden en az 30 puan', ['AR-GE-YURUTUCU'], 30, madde: 'Gösterge 02.03 / 02.04')
                    + ['telafi' => Kalip::puanDan('Yetmezse: Q1/Q2 dergilerdeki yayınlarla birlikte 30 puan', ['AR-GE-YURUTUCU', 'Q1-Q2'], 30, madde: 'Gösterge 02.01.01-02')],
            ]),
            Kalip::beyan('ÜAK doçentlik başvurunuzda asgari şartı sağlamak için kullandığınız makaleler '
                .'havuz puanına ikinci kez sayılmaz.'),
            Kalip::yds(70),
        ]],
    ],
    [
        'anahtar' => 'ataturk-docent-b',
        'aday_notu' => 'ÜAK doçentlik başvurusunda asgari şartı sağlamak için kullandığınız makaleler, havuz puanına ikinci kez sayılmıyor.',
        'universite' => 'Atatürk Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['sosyal', 'egitim', 'filoloji', 'guzel_sanatlar', 'hukuk', 'ilahiyat', 'spor'],
        'cetvel' => 'ataturk-2026',
        'notlar' => 'B grubu: ÜAK doçent unvanı + doçentlik havuz puanından toplam en az 80 puan. YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Doçent kadrosuna atanma', 'cocuklar' => [
            Kalip::toplam(80),
            Kalip::adet('SCIE/SSCI/AHCI/ESCI/Scopus kapsamında en az 1 tam metin makale', ['INDEKS_GENIS'], 1),
            Kalip::ve('AR-GE projesi koşulu', [
                Kalip::adet('En az 1 ulusal veya uluslararası AR-GE projesinde görev almış olmak', ['AR-GE'], 1, madde: 'Gösterge 02.03 / 02.04'),
                Kalip::puanDan('AR-GE projelerinden en az 20 puan', ['AR-GE'], 20, madde: 'Gösterge 02.03 / 02.04'),
            ]),
            Kalip::beyan('ÜAK doçentlik başvurunuzda asgari şartı sağlamak için kullandığınız makaleler '
                .'havuz puanına ikinci kez sayılmaz.'),
            Kalip::yds(70),
        ]],
    ],

    // ── Profesör ──
    [
        'anahtar' => 'ataturk-profesor-a',
        'aday_notu' => 'ÜAK doçentlik başvurusunda asgari şartı sağlamak için kullandığınız makaleler, havuz puanına ikinci kez sayılmıyor.',
        'universite' => 'Atatürk Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['fen', 'muhendislik', 'saglik', 'ziraat'],
        'cetvel' => 'ataturk-2026',
        'notlar' => 'A grubu: ÜAK doçentlik belgesi + tüm bölgelerden toplam en az 250 puan; makalelerden '
            .'en az 60 puan. Tablo dipnotu: "En az 30 puanın SCIE, SSCI veya AHCI kapsamındaki '
            .'dergilerde yapılan tam metin makalelerden alınması gerekir." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Profesör kadrosuna atanma', 'cocuklar' => [
            Kalip::toplam(250),
            Kalip::puanDan('Makalelerden en az 60 puan', ['MAKALE'], 60),
            Kalip::puanDan('Bunun en az 30 puanı SCIE/SSCI/AHCI dergilerden', ['INDEKS_SCIE_SSCI_AHCI'], 30),
            Kalip::ve('AR-GE projesi koşulu', [
                Kalip::adet('En az 1 ulusal veya uluslararası AR-GE projesinde görev almış olmak', ['AR-GE'], 1, madde: 'Gösterge 02.03 / 02.04'),
                Kalip::puanDan('AR-GE projelerinden en az 40 puan', ['AR-GE'], 40, madde: 'Gösterge 02.03 / 02.04'),
            ]),
            Kalip::puanDan('Ödül ve çarpan katkı kaleminden en az 30 puan', ['7. BÖLGE'], 30, madde: '7. Bölge — Çarpan Katkı'),
            Kalip::yds(70),
        ]],
    ],
    [
        'anahtar' => 'ataturk-profesor-a-mimarlik',
        'aday_notu' => 'ÜAK doçentlik başvurusunda asgari şartı sağlamak için kullandığınız makaleler, havuz puanına ikinci kez sayılmıyor.',
        'universite' => 'Atatürk Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['mimarlik'],
        'cetvel' => 'ataturk-2026',
        'notlar' => 'A grubu (Mimarlık): Tablo dipnotu: "İç Mimarlık, Mimarlık, Şehir ve Bölge Planlama, '
            .'Matematik ve İstatistik bölümleri için en az 20 puanın SCIE, SSCI veya AHCI kapsamındaki '
            .'dergilerde yapılan yayınlardan alınması gereklidir." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Profesör kadrosuna atanma (Mimarlık)', 'cocuklar' => [
            Kalip::toplam(250),
            Kalip::puanDan('Makalelerden en az 60 puan', ['MAKALE'], 60),
            Kalip::puanDan('Bunun en az 20 puanı SCIE/SSCI/AHCI dergilerden', ['INDEKS_SCIE_SSCI_AHCI'], 20),
            Kalip::ve('AR-GE projesi koşulu', [
                Kalip::adet('En az 1 ulusal veya uluslararası AR-GE projesinde görev almış olmak', ['AR-GE'], 1, madde: 'Gösterge 02.03 / 02.04'),
                Kalip::puanDan('AR-GE projelerinden en az 40 puan', ['AR-GE'], 40, madde: 'Gösterge 02.03 / 02.04'),
            ]),
            Kalip::puanDan('Ödül ve çarpan katkı kaleminden en az 30 puan', ['7. BÖLGE'], 30, madde: '7. Bölge — Çarpan Katkı'),
            Kalip::yds(70),
        ]],
    ],
    [
        'anahtar' => 'ataturk-profesor-b',
        'aday_notu' => 'ÜAK doçentlik başvurusunda asgari şartı sağlamak için kullandığınız makaleler, havuz puanına ikinci kez sayılmıyor.',
        'universite' => 'Atatürk Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['sosyal', 'egitim', 'filoloji', 'guzel_sanatlar', 'hukuk', 'ilahiyat', 'spor'],
        'cetvel' => 'ataturk-2026',
        'notlar' => 'B grubu: ÜAK doçentlik belgesi + tüm bölgelerden toplam en az 200 puan; makalelerden '
            .'en az 30 puan. Tablo dipnotu: "En az 20 puanın SCIE, SSCI, AHCI, ESCI veya SCOPUS '
            .'kapsamındaki dergilerde yapılan yayınlardan alınması gerekir." YDS en az 70.',
        'sart' => ['tip' => 've', 'aciklama' => 'Profesör kadrosuna atanma', 'cocuklar' => [
            Kalip::toplam(200),
            Kalip::puanDan('Makalelerden en az 30 puan', ['MAKALE'], 30),
            Kalip::puanDan('Bunun en az 20 puanı SCIE/SSCI/AHCI/ESCI/Scopus dergilerden', ['INDEKS_GENIS'], 20),
            Kalip::ve('AR-GE projesi koşulu', [
                Kalip::adet('En az 1 ulusal veya uluslararası AR-GE projesinde görev almış olmak', ['AR-GE'], 1, madde: 'Gösterge 02.03 / 02.04'),
                Kalip::puanDan('AR-GE projelerinden en az 20 puan', ['AR-GE'], 20, madde: 'Gösterge 02.03 / 02.04'),
            ]),
            Kalip::puanDan('ÜAK alan endeksi dergilerinden en az 20 puan', ['ALAN-ENDEKS'], 20, madde: 'Gösterge 02.01.06'),
            Kalip::puanDan('Ödül ve çarpan katkı kaleminden en az 20 puan', ['7. BÖLGE'], 20, madde: '7. Bölge — Çarpan Katkı'),
            Kalip::yds(70),
        ]],
    ],
];
