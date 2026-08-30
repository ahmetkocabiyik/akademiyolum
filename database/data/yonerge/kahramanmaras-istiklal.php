<?php

/**
 * KAHRAMANMARAŞ İSTİKLAL ÜNİVERSİTESİ — Akademik Yükseltilme ve Atanma
 * Yönergesi (Madde 10-12)
 * Kaynak: pdf/17536998712.kahramanmarasistiklaluniverstesi.pdf
 *
 * TEMEL ALAN AYRIMI YOK. Üç kadroda da tek bir puan barajı var ve barajlar
 * korpusun düşük ucunda:
 *   Dr. Öğr. Üyesi   A1'den 3 makale + EK-1'den  60 puan
 *   Doçent           EK-1'den 100 puan
 *   Profesör         EK-1'den 100 puan + doçentlik sonrası 1 birinci yazarlı yayın
 *
 * DOÇENT VE PROFESÖR AYNI PUANI İSTİYOR (100). Fark yalnızca profesörlükteki
 * birinci yazarlık koşulu ve daha yüksek dil barajı (65'e karşı 55). Korpusta
 * iki kadronun puan barajının eşit olduğu ender örneklerden biri.
 *
 * DR. ÖĞR. ÜYELİĞİNDE SAYIm VE PUAN BİRLİKTE: "A1 kapsamında en az 3 adet
 * makale olmak koşuluyla EK-1'deki listeden en az 60 puan". A1 makale
 * bölümünün tamamı, yani ulusal hakemli dergi makalesi de sayılıyor.
 *
 * YABANCI DİL BARAJI ÜÇ KATMANLI VE BİRİME BAĞLI (Madde 10/c-ç, 11/c-d, 12/b):
 *   genel                                55 (profesörlükte 65)
 *   çalışma alanı yabancı dil olanlar    85
 *   eğitim dili %100 yabancı dil olanlar 85
 * Birim bilgisi olmadan hangisinin geçerli olduğu seçilemediği için DÜŞÜK olan
 * genel eşik yazıldı; yüksek olanı yazmak Türkçe eğitim veren birime başvuran
 * adaya yönergede olmayan bir baraj gösterirdi. İkinci yabancı dil koşulu
 * (Dilbilim ve Karşılaştırmalı Edebiyat hariç doçent ve profesör adaylarında
 * 55) beyan olarak duruyor.
 *
 * YENİDEN ATANMA GİRİLMEDİ (Madde 10/f): koşul "A1'den en az 20 puan almak
 * şartıyla EK-1'den en az 60 puan" biçiminde ve üç yıllık atama dönemine bağlı;
 * atama tarihi profilde tutulmuyor. Koşulu sağlayamayan adaya bir defaya mahsus
 * 1 yıl daha verilebiliyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/kahramanmaras-istiklal-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$DOC = Kalip::DOCENTLIK_SONRASI;

$tumAlanlar = ['fen', 'muhendislik', 'mimarlik', 'saglik', 'spor', 'hukuk', 'ilahiyat',
    'filoloji', 'sosyal', 'egitim', 'guzel_sanatlar', 'ziraat'];

$dilNotu = 'Yabancı dil barajı birime göre yükseliyor: çalışma alanı yabancı dil olan bölümlerde '
    .'ve eğitim dili %100 yabancı dil olan bölümlerde 85 isteniyor. Birim bilgisi olmadan '
    .'seçilemediği için burada genel eşik gösteriliyor.';

$yenidenAtamaNotu = 'Yeniden atanmada A1 (makale) kalemlerinden en az 20 puan almak şartıyla '
    .'tüm faaliyetlerinizden en az 60 puan isteniyor; üç yıllık atama dönemine bağlı olduğu ve atama tarihi '
    .'burada tutulmadığı için yeniden atanma eşiği girilmedi. Koşulu sağlayamayan adaya bir '
    .'defaya mahsus 1 yıl daha verilebiliyor.';

$ikinciDilBeyani = Kalip::beyan('Dilbilim ve Karşılaştırmalı Edebiyat bilim alanları hariç '
    .'olmak üzere ikinci bir yabancı dilden en az 55 puan almış olmak', 'Madde 11/c');

return [
    // ══════════ DR. ÖĞRETİM ÜYESİ (Madde 10) ══════════
    [
        'anahtar' => 'kmis-dr',
        'aday_notu' => 'Koşul hem SAYI hem PUAN istiyor: makale kalemlerinden en az 3 çalışma '
            .'VE tablonun tamamından 60 puan. Makale sayısına ulusal hakemli dergi makaleleriniz '
            .'de dâhil. '.$dilNotu.' '.$yenidenAtamaNotu,
        'universite' => 'Kahramanmaraş İstiklal Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $tumAlanlar,
        'cetvel' => 'kahramanmaras-istiklal-2024',
        'notlar' => 'Madde 10/d: A1 kapsamında en az 3 makale olmak koşuluyla EK-1\'den en az '
            .'60 puan; Madde 10/c: yabancı dil sınavından en az 55.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Kahramanmaraş İstiklal Üniversitesi', [
            Kalip::yds(55),
            Kalip::toplam(60),
            Kalip::adet('Makale kalemlerinizden en az 3 çalışma', ['A1'], 3, madde: 'Madde 10/d'),
            Kalip::beyan('Doktora, tıpta, diş hekimliğinde, eczacılıkta veya veterinerlikte '
                .'uzmanlık ya da sanatta yeterlik unvanını ilgili alanda almış olmak',
                'Madde 10/b'),
        ]),
    ],

    // ══════════ DOÇENT (Madde 11) ══════════
    [
        'anahtar' => 'kmis-docent',
        'aday_notu' => 'Doçentlik ve profesörlük AYNI PUANI istiyor (100); fark yalnızca '
            .'profesörlükteki birinci yazarlık koşulu ve daha yüksek dil barajı. '.$dilNotu,
        'universite' => 'Kahramanmaraş İstiklal Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $tumAlanlar,
        'cetvel' => 'kahramanmaras-istiklal-2024',
        'notlar' => 'Madde 11/e: EK-1\'de yer alan bilimsel yayın ve faaliyetlerden 100 puan; '
            .'Madde 11/c: yabancı dil sınavından en az 55.',
        'sart' => Kalip::ve('Doçent — Kahramanmaraş İstiklal Üniversitesi', [
            Kalip::yds(55),
            Kalip::toplam(100),
            $ikinciDilBeyani,
            Kalip::beyan('Başvuruda bulunulan ilgili bilim alanında doçent unvanına sahip olmak',
                'Madde 11/b'),
        ]),
    ],

    // ══════════ PROFESÖR (Madde 12) ══════════
    [
        'anahtar' => 'kmis-profesor',
        'aday_notu' => 'Puan barajı doçentlikle aynı (100), ama doçentlik unvanınızı aldıktan '
            .'sonra en az bir yayında BİRİNCİ YAZAR olmanız gerekiyor ve dil barajı 65\'e '
            .'çıkıyor. '.$dilNotu,
        'universite' => 'Kahramanmaraş İstiklal Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $tumAlanlar,
        'cetvel' => 'kahramanmaras-istiklal-2024',
        'notlar' => 'Madde 12/c: doçentlik sonrası en az 1 yayında birinci yazar olmak şartıyla '
            .'EK-1\'den 100 puan; Madde 12/b: yabancı dil sınavından en az 65.',
        'sart' => Kalip::ve('Profesör — Kahramanmaraş İstiklal Üniversitesi', [
            Kalip::yds(65),
            Kalip::toplam(100),
            Kalip::adet('Doçentliğinizden sonra birinci yazar olduğunuz en az 1 yayın',
                ['YAYIN'], 1, 'ilk', $DOC, madde: 'Madde 12/c'),
            $ikinciDilBeyani,
        ]),
    ],
];
