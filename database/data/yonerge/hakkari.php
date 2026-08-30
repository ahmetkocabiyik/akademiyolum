<?php

/**
 * HAKKARİ ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Yönergesi
 * Kaynak: pdf/17536997352.hakkariuniverstesi.pdf (Madde 6-9)
 *
 * KORPUSTAKİ EN SADE YÖNERGE: temel alan ayrımı yok, alt baraj yok, dönem
 * kırılımı yalnızca profesörlükte var. Koşullar tek cümleyle yazılmış:
 *   Dr. Öğr. Üyesi   EK-1'den toplam en az 30 puan
 *   Doçent           puan koşulu YOK (yalnızca 2547 sayılı Kanun şartları)
 *   Profesör         doçentlik sonrası EK-1'den toplam 150 puan
 *
 * BARAJLAR KORPUSUN EN DÜŞÜKLERİ. Dr. Öğr. Üyeliği için istenen 30 puan, tek
 * bir SCI makalesinin (40) altında; profesörlük için istenen 150 puan ise
 * korpustaki diğer profesörlük barajlarının çoğunun onda biri. Bu, yönergenin
 * kendi tercihi — Madde 6 puan şartının bazı kadrolarda hiç aranmayabileceğini
 * de açıkça söylüyor.
 *
 * PUAN ŞARTININ HİÇ ARANMAMASI (Madde 6): bir bölüme öğrenci alımı için gerekli
 * asgari öğretim üyesi sayısına ulaşılıncaya kadar ya da öğretim üyesi
 * temininde güçlük çekilen kadrolarda, Yönetim Kurulu kararı ve Rektörün uygun
 * görmesiyle puan şartı aranmıyor. Bu bir muafiyet olduğu için eşiğe düğüm
 * olarak girmedi; aday notunda anıldı.
 *
 * YENİDEN ATANMA GİRİLDİ: Dr. Öğr. Üyeliğinde yeniden atanma koşulu ilk atamayla
 * aynı sayıyı (30 puan) istiyor, farkı yalnızca "son atama tarihinden itibaren"
 * penceresi. Ayrı eşik açmak yerine aday notunda anlatıldı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/hakkari-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$DOC = Kalip::DOCENTLIK_SONRASI;

/** Hakkari alan ayrımı yapmıyor; cetveldeki bütün temel alanlar. */
$tumAlanlar = ['fen', 'muhendislik', 'mimarlik', 'saglik', 'spor', 'hukuk', 'ilahiyat',
    'filoloji', 'sosyal', 'egitim', 'guzel_sanatlar', 'ziraat'];

$muafiyetNotu = 'Hakkari yönergesi Madde 6\'da iki muafiyet tanıyor: bir bölüme öğrenci alımı '
    .'için gerekli asgari öğretim üyesi sayısına ulaşılıncaya kadar ve öğretim üyesi temininde '
    .'güçlük çekilen kadrolarda, Yönetim Kurulu kararı ve Rektörün uygun görmesiyle puan şartı '
    .'hiç aranmıyor.';

return [
    // ══════════ DR. ÖĞRETİM ÜYESİ (Madde 7) ══════════
    [
        'anahtar' => 'hakkari-dr',
        'aday_notu' => 'Yeniden atanmada da aynı sayı geçerli (30 puan), farkı yalnızca son '
            .'atama tarihinizden sonraki çalışmaların sayılması. '.$muafiyetNotu,
        'universite' => 'Hakkari Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $tumAlanlar,
        'cetvel' => 'hakkari-2024',
        'notlar' => 'Madde 7/1-ç: EK-1 puanlama tablosundaki faaliyetlerden toplam en az 30 puan.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Hakkari Üniversitesi', [
            Kalip::toplam(30),
            Kalip::beyan('2547 sayılı Kanunun 23\'üncü maddesi ile Öğretim Üyeliğine Yükseltilme '
                .'ve Atanma Yönetmeliğinin 3, 4 ve 6\'ncı maddelerindeki şartları taşımak',
                'Madde 7/1-a'),
        ]),
    ],

    // ══════════ DOÇENT (Madde 8 — puan koşulu yok) ══════════
    [
        'anahtar' => 'hakkari-docent',
        'aday_notu' => 'Hakkari yönergesi doçentlik için puan koşulu koymuyor; yalnızca '
            .'2547 sayılı Kanun ve ilgili yönetmelik hükümlerindeki şartları arıyor. Burada '
            .'baraj görmüyorsunuz — eksik veri değil, yönergede öyle.',
        'universite' => 'Hakkari Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $tumAlanlar,
        'cetvel' => 'hakkari-2024',
        'notlar' => 'Madde 8: 2547 sayılı Kanun ve ilgili yönetmelik hükümlerindeki şartlara '
            .'sahip olmak.',
        'sart' => Kalip::ve('Doçent — Hakkari Üniversitesi', [
            Kalip::beyan('2547 sayılı Kanun ve ilgili yönetmelik hükümlerindeki şartlara sahip '
                .'olmak', 'Madde 8'),
        ]),
    ],

    // ══════════ PROFESÖR (Madde 9) ══════════
    [
        'anahtar' => 'hakkari-profesor',
        'aday_notu' => 'Puanın tamamı doçentlik unvanınızı aldıktan sonraki çalışmalarınızdan '
            .'gelmeli. '.$muafiyetNotu,
        'universite' => 'Hakkari Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $tumAlanlar,
        'cetvel' => 'hakkari-2024',
        'notlar' => 'Madde 9/b: doçentlik sonrası EK-1 puanlama tablosundaki faaliyetlerden '
            .'toplam 150 puan.',
        'sart' => Kalip::ve('Profesör — Hakkari Üniversitesi', [
            Kalip::toplam(150, $DOC),
            Kalip::beyan('Doçentlik unvanını aldıktan sonra en az beş yıl açık bulunan '
                .'profesörlük kadrosuyla ilgili bilim alanında çalışmış olmak', 'Madde 9/a'),
        ]),
    ],
];
