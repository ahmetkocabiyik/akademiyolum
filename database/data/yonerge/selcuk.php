<?php

/**
 * SELÇUK ÜNİVERSİTESİ — Öğretim Üyeliği Kadrolarına Atanma ve Yükseltme
 * Kriterleri Yönergesi
 * Kaynak: pdf/17537007702.selcukuniverstesi.pdf (93 sayfa)
 *
 * İKİ KATMANLI: Tablo 2 bütün alanlarda AYNI toplam puan barajlarını veriyor,
 * her temel alan ise kendi "Temel Alan Özel Kriterleri" bloğunda bölüm bazlı
 * ALT barajlar koyuyor ("Makaleler bölümünden en az 55 puan", "Atıflar
 * bölümünden en az 15 puan"). Alt barajlar olmadan koşullar fazla gevşek
 * kalacağı için eşik ancak özel kriterleri okunmuş alanlar için üretiliyor.
 *
 * TABLO 2 — bütün temel alanlarda ortak:
 *   Dr. Öğr. Üyesi   ilk atanma 70 · yeniden atanma 35
 *   Doçent           doktoradan sonra 120 · toplam 140
 *   Profesör         doçentlik unvanı sonrası 140 · toplam 280
 *
 * ŞU AN YALNIZCA EĞİTİM BİLİMLERİ GİRİLİ. Cetvelin on iki alanı da hazır
 * (cetvel/selcuk-2024.php) ama özel kriter blokları alan başına ayrı ayrı
 * okunmayı gerektiriyor; okunmamış alan için eşik üretmek, o alandaki adaya
 * gerçekte sağlamadığı bir sonucu "sağlandı" göstermek olurdu.
 *
 * "YENİDEN ATANMA" ayrı bir kadro olarak modellenmiyor; motorun kadro listesi
 * ilk atamayı tanıyor, o yüzden Dr. Öğr. Üyesi eşiği ilk atanma koşullarını
 * taşıyor ve yeniden atanma barajı aday notunda anılıyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip
 */

use App\Services\Scoring\Sart\Kalip;

return [
    // ══════════ EĞİTİM BİLİMLERİ TEMEL ALANI ══════════
    [
        'anahtar' => 'selcuk-dr-egitim',
        'aday_notu' => 'Bu koşullar İLK KEZ ATANMA içindir. Yeniden atanmada (görev uzatma) '
            .'toplam baraj 35 puana iner ve yalnızca en son atanma tarihinden sonraki '
            .'çalışmalarınız sayılır.',
        'universite' => 'Selçuk Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['egitim'],
        'cetvel' => 'selcuk-2024-egitim',
        'notlar' => 'Tablo 2 ilk atanma 70 puan; Eğitim Bilimleri Özel Kriterleri I- İlk Kez Atanma.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Eğitim Bilimleri', [
            Kalip::toplam(70),
            Kalip::puanDan('Uluslararası Makale bölümü "a" bendinden (SCI-Expanded, SSCI, AHCI) en az 15 puan',
                ['1a'], 15, madde: 'Özel Kriterler I-a'),
            Kalip::puanDan('Makaleler bölümünden toplam en az 30 puan',
                ['1*', '2*'], 30, madde: 'Özel Kriterler I-a'),
            Kalip::beyan('Doktora tezinden üretilmiş olmak üzere Makaleler bölümü "a, b, c ve/veya d" '
                .'bendi kapsamında en az 5 puan almış olmak', 'Özel Kriterler I-b'),
            Kalip::puanDan('Bilimsel Toplantı Faaliyeti bölümü "a" bendinden en az 3 puan '
                .'(doktora yeterliliği sonrası, tam metin ve sözlü sunum)',
                ['7a'], 3, madde: 'Özel Kriterler I-c'),
            Kalip::puanDan('Bilimsel Araştırma Projesi bölümünden en az 4 puan',
                ['6*'], 4, madde: 'Özel Kriterler I-d'),
        ]),
    ],
    [
        'anahtar' => 'selcuk-docent-egitim',
        'aday_notu' => 'Bütün koşullar doktora unvanınızı aldıktan sonraki çalışmalarla sağlanmalı. '
            .'Aktüerya, İstatistik ve Matematik bölümlerinde makale barajı 55 yerine 40 puan ve '
            .'başlıca yazarlık iki eser yerine bir eser olarak uygulanıyor.',
        'universite' => 'Selçuk Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['egitim'],
        'cetvel' => 'selcuk-2024-egitim',
        'notlar' => 'Tablo 2 doktoradan sonra 120, toplam 140; Eğitim Bilimleri Özel Kriterleri B- Doçent.',
        'sart' => Kalip::ve('Doçent — Eğitim Bilimleri', [
            Kalip::beyan('Üniversitelerarası Kuruldan doçentlik unvanı almış olmak', 'Tablo 2'),
            Kalip::toplam(140),
            Kalip::toplam(120, Kalip::DOKTORA_SONRASI),
            Kalip::adet('Uluslararası Makale bölümü "a" bendi kapsamında başlıca yazar olduğunuz en az iki eser',
                ['1a'], 2, 'baslica', Kalip::DOKTORA_SONRASI, madde: 'Özel Kriterler B-a'),
            Kalip::puanDan('Makaleler bölümünden en az 55 puan',
                ['1*', '2*'], 55, Kalip::DOKTORA_SONRASI, madde: 'Özel Kriterler B-a'),
            Kalip::puanDan('Bilimsel Toplantı Faaliyeti bölümü "a" bendinden en az 5 puan '
                .'(başlıca yazar, tam metin ve sözlü sunum)',
                ['7a'], 5, Kalip::DOKTORA_SONRASI, madde: 'Özel Kriterler B-b'),
            Kalip::puanDan('Atıflar bölümünden en az 15 puan',
                ['4*'], 15, Kalip::DOKTORA_SONRASI, madde: 'Özel Kriterler B-c'),
            Kalip::puanDan('Bilimsel Araştırma Projesi bölümünden en az 8 puan',
                ['6*'], 8, Kalip::DOKTORA_SONRASI, madde: 'Özel Kriterler B-d'),
        ]),
    ],
    [
        'anahtar' => 'selcuk-profesor-egitim',
        'aday_notu' => 'Bütün koşullar doçentlik unvanınızı aldıktan sonraki çalışmalarla sağlanmalı. '
            .'Başvuru Şartları Tablosu puanlaması doçentlik öncesi ve sonrası için ayrı ayrı iki defa '
            .'kullanılabiliyor.',
        'universite' => 'Selçuk Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['egitim'],
        'cetvel' => 'selcuk-2024-egitim',
        'notlar' => 'Tablo 2 doçentlik sonrası 140, toplam 280; Eğitim Bilimleri Özel Kriterleri C- Profesör.',
        'sart' => Kalip::ve('Profesör — Eğitim Bilimleri', [
            Kalip::toplam(280),
            Kalip::toplam(140, Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('Uluslararası Makale bölümü "a ve/veya b" bendi kapsamında başlıca yazar olduğunuz iki eser',
                ['1a', '1b'], 2, 'baslica', Kalip::DOCENTLIK_SONRASI, madde: 'Özel Kriterler C-a'),
            Kalip::puanDan('Uluslararası Makale bölümünden en az 40 puan',
                ['1*'], 40, Kalip::DOCENTLIK_SONRASI, madde: 'Özel Kriterler C-a'),
            Kalip::adet('Ulusal Makale bölümü "a" bendi kapsamında başlıca yazar olduğunuz iki eser',
                ['2a'], 2, 'baslica', Kalip::DOCENTLIK_SONRASI, madde: 'Özel Kriterler C-b'),
            Kalip::puanDan('Ulusal Makale bölümünden en az 40 puan',
                ['2*'], 40, Kalip::DOCENTLIK_SONRASI, madde: 'Özel Kriterler C-b'),
            Kalip::adet('Bilimsel Toplantı Faaliyeti bölümünde başlıca yazar olduğunuz iki eser '
                .'(tam metin ve sözlü sunum)',
                ['7*'], 2, 'baslica', Kalip::DOCENTLIK_SONRASI, madde: 'Özel Kriterler C-c'),
            Kalip::puanDan('Bilimsel Toplantı Faaliyeti bölümünden en az 10 puan',
                ['7*'], 10, Kalip::DOCENTLIK_SONRASI, madde: 'Özel Kriterler C-c'),
            Kalip::puanDan('Atıflar bölümünden en az 20 puan',
                ['4*'], 20, Kalip::DOCENTLIK_SONRASI, madde: 'Özel Kriterler C-d'),
            Kalip::puanDan('Bilimsel Araştırma Projeleri kapsamında en az 8 puan '
                .'(en az bir projede yürütücülük koşuluyla)',
                ['6*'], 8, Kalip::DOCENTLIK_SONRASI, madde: 'Özel Kriterler C-e'),
            Kalip::adet('Bilimsel araştırma projelerinin en az birinde yürütücü olmak',
                ['6a'], 1, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Özel Kriterler C-e'),
        ]),
    ],
];
