<?php

use App\Services\Scoring\Sart\Kalip;

/**
 * KARAMANOĞLU MEHMETBEY ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve
 * Atanma Yönergesi
 * Kaynak: pdf/17536999512.karamanoglumehmetbeyuniverstesi.pdf (15 sayfa)
 *
 * Cetvel: cetvel/karamanoglu-2024.php
 *
 * KAYNAK PDF TARANMIŞ; 300 dpi görüntüden `tesseract -l tur` ile okundu.
 * OCR "%" işaretini "90", "96", "©0" ve "“" olarak okumuş; koşullardaki
 * bütün yüzdeler bu düzeltmeyle alındı. 05.09.2026'da fen grubunun üç
 * barajı 200 dpi SAYFA GÖRÜNTÜSÜNDEN birebir doğrulandı (MADDE 6.(3)/b/3
 * "toplam 150 puan", 8.(3)/a "en az 300 puan", 9.(3)/a "en az 350 puan";
 * üçünde de oran %50). Fen grubunun profesörlük İLAVESİ 150, öteki üç
 * grupta 100 — bu da görüntüden doğrulandı (satır 392/417/442/467).
 *
 * ── "İLAVETEN … PUAN DAHA" İKİ DÜĞÜM İSTER ──
 * MADDE 8 ve 9'un alternatif bendi "(a) bendinde belirtilen PUANA İLAVETEN
 * A, B, C, F, H ve İ türü aktivitelerden olmak üzere en az 100 puan DAHA
 * almış olmak" diyor. Ek puan hem TOPLAMI hem TÜR KÜMESİNİ yükseltiyor:
 * doçentlikte toplam 400 ve türlerden 250, profesörlükte 500 ve 325. İlk
 * yazımda tek düğüme sığdırılıp "tür kümesinden 400/500" diye yazılmıştı;
 * kaynağın istemediği kadar sıkıydı ve yalnız bu yoldan gidebilen adayı
 * haksız yere eliyordu.
 *
 * ── EŞİKLERİN YAPISI ──
 * Dört alan grubu, her birinin kendi puan barajı ve kendi TÜR KÜMESİ var
 * (koşullar tabloya harfle atıf yapıyor: "A, C, F, H ve İ türü
 * aktivitelerden en az %50"):
 *   Tıp, Diş, Sağlık, Spor        Dr 125 · Doçent 200 · Profesör 350
 *   Fen, Mühendislik, Ziraat      Dr 150 · Doçent 300 · Profesör 350
 *   Güzel Sanatlar, Mimarlık      Dr 125 · Doçent 200 · Profesör 350
 *   Sosyal, Eğitim, Hukuk, ...    Dr 125 · Doçent 200 · Profesör 350
 * Yüzde payları `Kalip::oran` ile yazıldı.
 *
 * ── YORUM KARARLARI (§0) ──
 *   h-İNDEKSİ ALTERNATİFLERİ `beyan` OLARAK YAZILDI. Dört alan grubunun
 *       her kadrosunda "WoS h-indeksi en az N" bir alternatif dal; profil
 *       h-indeksini tutmadığı için dal beyan olarak duruyor ve `veya`
 *       bloğu bu yüzden kesin ret vermiyor, belirsiz kalıyor.
 *   "YURT DIŞINDA EN AZ ÜÇ AY ARAŞTIRMA" ve "en az dokuz ay süreli
 *       proje" nitelikleri kayıtta yok. Yurt dışı deneyimi `beyan`
 *       olarak, proje koşulu ise süre kısıtı olmadan `adet` olarak
 *       yazıldı; proje dalı bu yüzden olduğundan KOLAY görünüyor.
 *   MADDE 7'nin yeniden atama koşulu ATAMA SÜRESİNE bağlı (dört yıllık
 *       atamada 150 puanın %100'ü, üç yılda %75, iki yılda %50, bir yılda
 *       %25). Atama süresi profilde tutulmadığı için §0 uyarınca EN
 *       YÜKSEK basamak (dört yıl, 150 puan) yazıldı.
 *   Profesörlükte çeyrekliğe bağlı makale koşulu ("Q1'de 1 ya da Q2'de 2
 *       ya da Q3'te 3 makale") `veya` ile üç dal olarak girildi.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 5'in başvuru, dosya ve ön değerlendirme komisyonu usulleri.
 *   MADDE 5/ğ'nin yabancı dilde eğitim yapan programlara ilişkin ek
 *       yönetmelik atfı.
 *   MADDE 10 ve sonrası (puanlama usulü, geçici maddeler).
 *   GEÇİCİ MADDE 1-3'ün profesörlük ve Tıp-Diş Hekimliği geçiş hükümleri.
 */
$SAGLIK = ['saglik', 'spor'];
$FEN = ['fen', 'muhendislik', 'ziraat'];
$SANAT = ['guzel_sanatlar', 'mimarlik'];
$SOSYAL = ['sosyal', 'egitim', 'hukuk', 'ilahiyat', 'filoloji'];

$PUAN_NOTU = 'Yönerge çok yazarlı eserlerde puanı bölmüyor; puanlar yazar sayısından bağımsız. '
    .'h-indeksi koşulları profil ölçütü olduğu için beyan olarak duruyor, "yurt dışında en az üç '
    .'ay araştırma" niteliği de kayıtta yok. Proje koşulunun "en az dokuz ay süreli" kısıtı '
    .'uygulanamadığı için o dal olduğundan kolay görünüyor.';

$YURTDISI = fn (string $madde): array => Kalip::beyan(
    'Alanınızda ya da yakından ilgili bir alanda en az üç ay süreli akademik amaçlı yurt dışı deneyimi',
    $madde,
);

$PROJE = fn (string $madde): array => Kalip::adet(
    'TÜBİTAK, AB ya da dış destekli bir araştırma projesinde yürütücü veya araştırmacı olmak',
    ['PROJE-9AY'],
    1,
    madde: $madde,
);

$H_INDEKS = fn (int $n, string $madde): array => Kalip::beyan(
    "Web of Science verilerine göre h-indeksinizin en az {$n} olması",
    $madde,
);

$esikler = [];

/** @var list<array<string, mixed>> $gruplar */
$gruplar = [
    [
        'anahtar' => 'kmu-saglik', 'ad' => 'Tıp, Diş Hekimliği, Sağlık ve Spor Bilimleri',
        'alan' => $SAGLIK, 'madde' => 'MADDE 6/2', 'tur' => 'ACFHI', 'turAd' => 'A, C, F, H ve İ',
        'docentTur' => 'ABCFHI', 'docentTurAd' => 'A, B, C, F, H ve İ',
        'drPuan' => 125, 'docentPuan' => 200, 'profPuan' => 350,
        'drMakale' => 2, 'hDr' => 5, 'hDocent' => 10, 'hProf' => 15,
    ],
    [
        'anahtar' => 'kmu-fen', 'ad' => 'Fen, Mühendislik ve Ziraat',
        'alan' => $FEN, 'madde' => 'MADDE 6/3', 'tur' => 'ACFHI', 'turAd' => 'A, C, F, H ve İ',
        'docentTur' => 'ABCFHI', 'docentTurAd' => 'A, B, C, F, H ve İ',
        'drPuan' => 150, 'docentPuan' => 300, 'profPuan' => 350,
        'drMakale' => 3, 'hDr' => 5, 'hDocent' => 10, 'hProf' => 15,
    ],
];

foreach ($gruplar as $g) {
    $ortak = [
        'universite' => 'Karamanoğlu Mehmetbey Üniversitesi',
        'alan' => $g['alan'],
        'birim' => null,
        'cetvel' => 'karamanoglu-2024',
    ];

    $esikler[] = $ortak + [
        'anahtar' => "{$g['anahtar']}-dr",
        'kadro' => 'dr_ogr_uyesi',
        'notlar' => "{$g['madde']}: SCI, SCI-Expanded ya da SSCI kapsamında en az 1 tanesi olmak "
            ."üzere hakemli dergilerde en az {$g['drMakale']} araştırma makalesi; ayrıca yurt dışı "
            ."deneyimi, dokuz aylık proje, {$g['turAd']} türlerinden %50'si olmak üzere "
            ."{$g['drPuan']} puan ya da h-indeksi koşullarından en az biri. Yabancı dil 60.",
        'aday_notu' => 'Makale koşulu zorunlu; ikinci koşul dört alternatiften biriyle sağlanıyor. '
            .'Puan alternatifinde toplamın en az yarısının makale, kitap, atıf, proje ve '
            .'ödül-patent türlerinden gelmesi gerekiyor. '.$PUAN_NOTU,
        'sart' => Kalip::ve("Doktor öğretim üyesi koşulları — {$g['ad']}", [
            Kalip::yds(60),
            Kalip::beyan('Doktora, uzmanlık ya da sanatta yeterlik unvanı almış olmak', 'MADDE 6/1-a'),
            Kalip::adet("Hakemli dergilerde en az {$g['drMakale']} araştırma makalesi", ['HAKEMLI-MAKALE'], $g['drMakale'], madde: $g['madde']),
            Kalip::adet('Bunlardan en az 1\'i SCI, SCI-Expanded ya da SSCI kapsamında olmalı', ['WOS'], 1, madde: $g['madde']),
            Kalip::veya('Dört alternatiften en az biri', [
                $YURTDISI($g['madde']),
                $PROJE($g['madde']),
                Kalip::ve('Puan alternatifi', [
                    Kalip::toplam($g['drPuan'], maddeler: ['TUM'], liste: 'Akademik Etkinlikler Listesi'),
                    Kalip::puanDan("{$g['turAd']} türü etkinliklerden en az ".intdiv($g['drPuan'], 2).' puan', [$g['tur']], intdiv($g['drPuan'], 2), madde: $g['madde']),
                ]),
                $H_INDEKS($g['hDr'], $g['madde']),
            ]),
        ]),
    ];

    $esikler[] = $ortak + [
        'anahtar' => "{$g['anahtar']}-docent",
        'kadro' => 'docentlik',
        'notlar' => "MADDE 8: {$g['docentTurAd']} türlerinden en az %50'si olmak üzere en az "
            ."{$g['docentPuan']} puan; ayrıca yurt dışı deneyimi, dokuz aylık proje, aynı "
            .'türlerden 100 puan daha ya da h-indeksi koşullarından en az biri. Yabancı dil 65.',
        'aday_notu' => "Doçentlikte {$g['docentPuan']} puanın en az yarısı makale, bildiri, "
            .'kitap, atıf, proje ve ödül-patent türlerinden gelmeli. İkinci koşulun dört '
            .'alternatifinden biri yeterli. '.$PUAN_NOTU,
        'sart' => Kalip::ve("Doçent kadrosuna atanma koşulları — {$g['ad']}", [
            Kalip::yds(65),
            Kalip::beyan('Doçentlik unvanını almış olmak', 'MADDE 8/1-a'),
            Kalip::toplam($g['docentPuan'], maddeler: ['TUM'], liste: 'Akademik Etkinlikler Listesi'),
            Kalip::puanDan("{$g['docentTurAd']} türü etkinliklerden en az ".intdiv($g['docentPuan'], 2).' puan', [$g['docentTur']], intdiv($g['docentPuan'], 2), madde: 'MADDE 8'),
            Kalip::veya('Dört alternatiften en az biri', [
                $YURTDISI('MADDE 8'),
                $PROJE('MADDE 8'),
                // "(a) bendinde belirtilen PUANA İLAVETEN … türü aktivitelerden
                // olmak üzere en az 100 puan DAHA almış olmak": ek 100 puan
                // hem TOPLAMI hem TÜR KÜMESİNİ yükseltiyor. Tek düğüme
                // sığmıyor — ilk yazımda "tür kümesinden toplam+100" diye
                // yazılmıştı ve kaynağın istemediği kadar sıkıydı.
                Kalip::ve('İlave 100 puan koşulu', [
                    Kalip::toplam($g['docentPuan'] + 100, maddeler: ['TUM'], liste: 'Akademik Etkinlikler Listesi'),
                    Kalip::puanDan(
                        "{$g['docentTurAd']} türü etkinliklerden en az ".(intdiv($g['docentPuan'], 2) + 100).' puan',
                        [$g['docentTur']], intdiv($g['docentPuan'], 2) + 100, madde: 'MADDE 8',
                    ),
                ]),
                $H_INDEKS($g['hDocent'], 'MADDE 8'),
            ]),
        ]),
    ];
}

// ══════════════ GÜZEL SANATLAR VE MİMARLIK ══════════════
$sanatOrtak = [
    'universite' => 'Karamanoğlu Mehmetbey Üniversitesi',
    'alan' => $SANAT,
    'birim' => null,
    'cetvel' => 'karamanoglu-2024',
];

$esikler[] = $sanatOrtak + [
    'anahtar' => 'kmu-sanat-dr',
    'kadro' => 'dr_ogr_uyesi',
    'notlar' => 'MADDE 6/4: beş alternatiften en az biri — 1 WoS makalesi, 2 uluslararası indeksli '
        .'makale, 4 hakemli makale, A, C, F, H, İ ve L türlerinden %50\'si olmak üzere 125 puan, '
        .'ya da h-indeksi en az 3. Yabancı dil 60.',
    'aday_notu' => 'Güzel Sanatlar ve Mimarlıkta makale koşulu zorunlu değil: beş alternatiften '
        .'biri yeterli ve bunlardan biri de sanat etkinliklerini içeren puan yolu. '.$PUAN_NOTU,
    'sart' => Kalip::ve('Doktor öğretim üyesi koşulları — Güzel Sanatlar ve Mimarlık', [
        Kalip::yds(60),
        Kalip::beyan('Doktora, uzmanlık ya da sanatta yeterlik unvanı almış olmak', 'MADDE 6/1-a'),
        Kalip::veya('Beş alternatiften en az biri', [
            Kalip::adet('AHCI, SSCI, SCI ya da SCI-Expanded kapsamında en az 1 araştırma makalesi', ['WOS'], 1, madde: 'MADDE 6/4-a'),
            Kalip::adet('Uluslararası indekslerde taranan dergilerde en az 2 araştırma makalesi', ['ALAN-INDEKSI'], 2, madde: 'MADDE 6/4-b'),
            Kalip::adet('Hakemli dergilerde en az 4 araştırma makalesi', ['HAKEMLI-MAKALE'], 4, madde: 'MADDE 6/4-c'),
            Kalip::ve('Puan alternatifi', [
                Kalip::toplam(125, maddeler: ['TUM'], liste: 'Akademik Etkinlikler Listesi'),
                Kalip::puanDan('A, C, F, H, İ ve L türü etkinliklerden en az 62 puan', ['ACFHIL'], 62, madde: 'MADDE 6/4-ç'),
            ]),
            $H_INDEKS(3, 'MADDE 6/4-d'),
        ]),
    ]),
];

$esikler[] = $sanatOrtak + [
    'anahtar' => 'kmu-sanat-docent',
    'kadro' => 'docentlik',
    'notlar' => 'MADDE 8/4: A, B, C, F, H, İ ve L türlerinden %50\'si olmak üzere en az 200 puan; '
        .'ayrıca yurt dışı deneyimi, dokuz aylık proje, aynı türlerden 100 puan daha ya da '
        .'h-indeksi en az 5. Yabancı dil 65.',
    'aday_notu' => 'Sanat ve tasarım etkinlikleri (L türü) hem 200 puanlık toplama hem de '
        .'yarısının gelmesi gereken türler kümesine dâhil. '.$PUAN_NOTU,
    'sart' => Kalip::ve('Doçent kadrosuna atanma koşulları — Güzel Sanatlar ve Mimarlık', [
        Kalip::yds(65),
        Kalip::beyan('Doçentlik unvanını almış olmak', 'MADDE 8/1-a'),
        Kalip::toplam(200, maddeler: ['TUM'], liste: 'Akademik Etkinlikler Listesi'),
        Kalip::puanDan('A, B, C, F, H, İ ve L türü etkinliklerden en az 100 puan', ['ABCFHIL'], 100, madde: 'MADDE 8/4-a'),
        Kalip::veya('Dört alternatiften en az biri', [
            $YURTDISI('MADDE 8/4-b'),
            $PROJE('MADDE 8/4-b'),
            Kalip::toplam(300, maddeler: ['ABCFHIL'], liste: 'A, B, C, F, H, İ ve L türü etkinlikler'),
            $H_INDEKS(5, 'MADDE 8/4-b'),
        ]),
    ]),
];

// ══════════════ SOSYAL, BEŞERİ VE İDARİ BİLİMLER İLE EĞİTİM ══════════════
$sosyalOrtak = [
    'universite' => 'Karamanoğlu Mehmetbey Üniversitesi',
    'alan' => $SOSYAL,
    'birim' => null,
    'cetvel' => 'karamanoglu-2024',
];

$esikler[] = $sosyalOrtak + [
    'anahtar' => 'kmu-sosyal-dr',
    'kadro' => 'dr_ogr_uyesi',
    'notlar' => 'MADDE 6/5: beş alternatiften en az biri — 1 WoS makalesi; en az 1\'i ESCI ya da '
        .'Scopus\'ta olmak üzere 2 makale; üç ay yurt dışı araştırma ile birlikte A, B, C, F, G, H '
        .'ve İ türlerinden %50\'si olmak üzere 125 puan; diğer uluslararası indekslerde 2 makale '
        .'ile birlikte A, C, F, H ve İ türlerinden %50\'si olmak üzere 125 puan; ya da h-indeksi '
        .'en az 3. Yabancı dil 60.',
    'aday_notu' => 'Beş alternatiften biri yeterli. İki alternatif puan barajını başka bir '
        .'koşulla birlikte istiyor: biri yurt dışı deneyimiyle, öteki iki uluslararası indeksli '
        .'makaleyle. '.$PUAN_NOTU,
    'sart' => Kalip::ve('Doktor öğretim üyesi koşulları — Sosyal, Beşeri ve İdari Bilimler', [
        Kalip::yds(60),
        Kalip::beyan('Doktora, uzmanlık ya da sanatta yeterlik unvanı almış olmak', 'MADDE 6/1-a'),
        Kalip::veya('Beş alternatiften en az biri', [
            Kalip::adet('AHCI, SSCI, SCI ya da SCI-Expanded kapsamında en az 1 araştırma makalesi', ['WOS'], 1, madde: 'MADDE 6/5-a'),
            Kalip::ve('En az 1\'i ESCI ya da Scopus\'ta olmak üzere 2 makale', [
                Kalip::adet('Hakemli dergilerde en az 2 makale', ['HAKEMLI-MAKALE'], 2, madde: 'MADDE 6/5-b'),
                Kalip::adet('Bunlardan en az 1\'i ESCI ya da Scopus kapsamında olmalı', ['ALAN-INDEKSI'], 1, madde: 'MADDE 6/5-b'),
            ]),
            Kalip::ve('Yurt dışı deneyimi ile birlikte puan barajı', [
                $YURTDISI('MADDE 6/5-c'),
                Kalip::toplam(125, maddeler: ['TUM'], liste: 'Akademik Etkinlikler Listesi'),
                Kalip::puanDan('A, B, C, F, G, H ve İ türü etkinliklerden en az 62 puan', ['ABCFGHI'], 62, madde: 'MADDE 6/5-c'),
            ]),
            Kalip::ve('İki uluslararası indeksli makale ile birlikte puan barajı', [
                Kalip::adet('Diğer uluslararası indekslerde taranan dergilerde en az 2 makale', ['ALAN-INDEKSI'], 2, madde: 'MADDE 6/5-ç'),
                Kalip::toplam(125, maddeler: ['TUM'], liste: 'Akademik Etkinlikler Listesi'),
                Kalip::puanDan('A, C, F, H ve İ türü etkinliklerden en az 62 puan', ['ACFHI'], 62, madde: 'MADDE 6/5-ç'),
            ]),
            $H_INDEKS(3, 'MADDE 6/5-d'),
        ]),
    ]),
];

$esikler[] = $sosyalOrtak + [
    'anahtar' => 'kmu-sosyal-docent',
    'kadro' => 'docentlik',
    'notlar' => 'MADDE 8/5: A, B, C, F, H ve İ türlerinden %50\'si olmak üzere en az 200 puan; '
        .'ayrıca yurt dışı deneyimi, dokuz aylık proje, aynı türlerden 100 puan daha ya da '
        .'h-indeksi en az 5. Yabancı dil 65.',
    'aday_notu' => 'Doçentlikte 200 puanın en az yarısı makale, bildiri, kitap, atıf, proje ve '
        .'ödül-patent türlerinden gelmeli. '.$PUAN_NOTU,
    'sart' => Kalip::ve('Doçent kadrosuna atanma koşulları — Sosyal, Beşeri ve İdari Bilimler', [
        Kalip::yds(65),
        Kalip::beyan('Doçentlik unvanını almış olmak', 'MADDE 8/1-a'),
        Kalip::toplam(200, maddeler: ['TUM'], liste: 'Akademik Etkinlikler Listesi'),
        Kalip::puanDan('A, B, C, F, H ve İ türü etkinliklerden en az 100 puan', ['ABCFHI'], 100, madde: 'MADDE 8/5-a'),
        Kalip::veya('Dört alternatiften en az biri', [
            $YURTDISI('MADDE 8/5-b'),
            $PROJE('MADDE 8/5-b'),
            Kalip::toplam(300, maddeler: ['ABCFHI'], liste: 'A, B, C, F, H ve İ türü etkinlikler'),
            $H_INDEKS(5, 'MADDE 8/5-b'),
        ]),
    ]),
];

// ══════════════ PROFESÖRLÜK (dört alan grubu) ══════════════
$profesorler = [
    ['anahtar' => 'kmu-saglik', 'ad' => 'Tıp, Diş Hekimliği, Sağlık ve Spor Bilimleri', 'alan' => $SAGLIK,
        'madde' => 'MADDE 9/2', 'tur' => 'ABCFHI', 'turAd' => 'A, B, C, F, H ve İ', 'ilave' => 100, 'h' => 15,
        'ceyreklik' => true, 'ceyreklikZorunlu' => false],
    ['anahtar' => 'kmu-fen', 'ad' => 'Fen, Mühendislik ve Ziraat', 'alan' => $FEN,
        'madde' => 'MADDE 9/3', 'tur' => 'ABCFHI', 'turAd' => 'A, B, C, F, H ve İ', 'ilave' => 150, 'h' => 15,
        'ceyreklik' => true, 'ceyreklikZorunlu' => true],
    ['anahtar' => 'kmu-sanat', 'ad' => 'Güzel Sanatlar ve Mimarlık', 'alan' => $SANAT,
        'madde' => 'MADDE 9/4', 'tur' => 'ABCFHIL', 'turAd' => 'A, B, C, F, H, İ ve L', 'ilave' => 100, 'h' => 7,
        'ceyreklik' => false, 'ceyreklikZorunlu' => false],
    ['anahtar' => 'kmu-sosyal', 'ad' => 'Sosyal, Beşeri ve İdari Bilimler', 'alan' => $SOSYAL,
        'madde' => 'MADDE 9/5', 'tur' => 'ABCFHIL', 'turAd' => 'A, B, C, F, H, İ ve L', 'ilave' => 100, 'h' => 7,
        'ceyreklik' => false, 'ceyreklikZorunlu' => false],
];

$ceyreklikDali = fn (string $madde): array => Kalip::veya('Doçentlik sonrası çeyrekliğe bağlı makale koşulu', [
    Kalip::adet('Q1 dilimli dergide en az 1 makale', ['Q1'], 1, donem: Kalip::DOCENTLIK_SONRASI, madde: $madde),
    Kalip::adet('Q2 dilimli dergide en az 2 makale', ['Q2'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: $madde),
    Kalip::adet('Q3 dilimli dergide en az 3 makale', ['Q3'], 3, donem: Kalip::DOCENTLIK_SONRASI, madde: $madde),
]);

foreach ($profesorler as $p) {
    $alternatifler = [
        $YURTDISI($p['madde']),
        $PROJE($p['madde']),
        Kalip::ve("İlave {$p['ilave']} puan koşulu", [
            Kalip::toplam(350 + $p['ilave'], donem: Kalip::DOCENTLIK_SONRASI, maddeler: ['TUM'],
                liste: 'Akademik Etkinlikler Listesi'),
            Kalip::puanDan(
                "{$p['turAd']} türü etkinliklerden en az ".(175 + $p['ilave']).' puan',
                [$p['tur']], 175 + $p['ilave'], Kalip::DOCENTLIK_SONRASI, madde: $p['madde'],
            ),
        ]),
        $H_INDEKS($p['h'], $p['madde']),
    ];

    if ($p['ceyreklik'] && ! $p['ceyreklikZorunlu']) {
        $alternatifler[] = Kalip::veya('Doçentlik sonrası Q1-Q2\'de 1 ya da Q3\'te 2 makale', [
            Kalip::adet('Q1 ya da Q2 dilimli dergide en az 1 makale', ['Q1', 'Q2'], 1, donem: Kalip::DOCENTLIK_SONRASI, madde: $p['madde']),
            Kalip::adet('Q3 dilimli dergide en az 2 makale', ['Q3'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: $p['madde']),
        ]);
    }

    $kosullar = [
        Kalip::yds(65),
        Kalip::beyan('Doçent unvanını aldıktan sonraki yayınlarınızdan birini başlıca araştırma eseri olarak sunmak', 'MADDE 9/1-b'),
        Kalip::beyan('Doçent unvanını aldıktan sonra en az iki yıl üniversitede ya da alanıyla ilgili bir araştırma kuruluşunda fiilen çalışmış olmak', 'MADDE 9/1-c'),
        Kalip::toplam(350, donem: Kalip::DOCENTLIK_SONRASI, maddeler: ['TUM'], liste: 'Akademik Etkinlikler Listesi'),
        Kalip::puanDan("{$p['turAd']} türü etkinliklerden en az 175 puan", [$p['tur']], 175, Kalip::DOCENTLIK_SONRASI, madde: $p['madde']),
    ];

    if ($p['ceyreklikZorunlu']) {
        $kosullar[] = $ceyreklikDali($p['madde']);
    }

    if ($p['anahtar'] === 'kmu-sanat') {
        $alternatifler[] = Kalip::adet('Tek yazarlı ulusal ya da uluslararası nitelikte bir bilimsel kitap yayımlamış olmak', ['KITAP'], 1, yazar: 'tek', madde: 'MADDE 9/4-b');
        $alternatifler[] = Kalip::adet('Ulusal ya da uluslararası nitelikte en az 3 kişisel sergi düzenlemiş olmak', ['KISISEL-SERGI'], 3, madde: 'MADDE 9/4-b');
    }

    if ($p['anahtar'] === 'kmu-sosyal') {
        $kosullar[] = Kalip::adet('Başlıca yazar olarak uluslararası alan indeksinde taranan hakemli dergide özgün bir araştırma makalesi ya da bir kitabı başlıca eser olarak yayımlamış olmak', ['ALAN-INDEKSI', 'KITAP'], 1, yazar: 'baslica', madde: 'MADDE 9/5-b');
    }

    $kosullar[] = Kalip::veya('Doçentlik sonrası alternatiflerden en az biri', $alternatifler);

    $esikler[] = [
        'anahtar' => "{$p['anahtar']}-profesor",
        'universite' => 'Karamanoğlu Mehmetbey Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $p['alan'],
        'birim' => null,
        'cetvel' => 'karamanoglu-2024',
        'notlar' => "{$p['madde']}: doçentlik sonrası {$p['turAd']} türlerinden %50'si olmak üzere "
            .'en az 350 puan; başlıca araştırma eseri; doçentlik sonrası en az iki yıl fiilen '
            .'çalışmış olmak; ayrıca alternatif koşullardan en az biri. Yabancı dil 65.',
        'aday_notu' => 'Profesörlükte 350 puanın tamamı doçentlik sonrasına ait olmalı ve en az '
            .'yarısı belirli etkinlik türlerinden gelmeli. '
            .($p['ceyreklikZorunlu']
                ? 'Fen, Mühendislik ve Ziraatte çeyrekliğe bağlı makale koşulu ZORUNLU: Q1\'de 1, '
                    .'Q2\'de 2 ya da Q3\'te 3 makale. '
                : '')
            .$PUAN_NOTU,
        'sart' => Kalip::ve("Profesör kadrosuna atanma — {$p['ad']}", $kosullar),
    ];
}

// ══════════════ DOKTOR ÖĞRETİM ÜYESİ YENİDEN ATAMA (MADDE 7) ══════════════
foreach ([$SAGLIK, $FEN, $SANAT, $SOSYAL] as $i => $alan) {
    $adlar = ['Tıp, Diş Hekimliği, Sağlık ve Spor Bilimleri', 'Fen, Mühendislik ve Ziraat',
        'Güzel Sanatlar ve Mimarlık', 'Sosyal, Beşeri ve İdari Bilimler'];
    $anahtarlar = ['kmu-saglik', 'kmu-fen', 'kmu-sanat', 'kmu-sosyal'];

    $esikler[] = [
        'anahtar' => "{$anahtarlar[$i]}-dr-yeniden",
        'universite' => 'Karamanoğlu Mehmetbey Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $alan,
        'birim' => null,
        'cetvel' => 'karamanoglu-2024',
        'notlar' => 'MADDE 7: son atama tarihinden itibaren A, B, C, D, F, G, H, İ ve L '
            .'türlerinden %50\'si olmak üzere 150 puanın atama süresine göre bir oranı — dört '
            .'yıllık atamada %100, üç yılda %75, iki yılda %50, bir yılda %25.',
        'aday_notu' => 'Aranan puan ATAMA SÜRENİZE bağlı; süre profilde tutulmadığı için araç en '
            .'yüksek basamağı (dört yıllık atama, 150 puan) arıyor. Daha kısa süreli bir '
            .'atamaysanız gerçekte istenen puan daha düşük. '.$PUAN_NOTU,
        'sart' => Kalip::ve("Doktor öğretim üyeliğine yeniden atanma — {$adlar[$i]}", [
            Kalip::yds(60),
            Kalip::toplam(150, maddeler: ['TUM'], liste: 'Akademik Etkinlikler Listesi'),
            Kalip::puanDan('A, B, C, D, F, G, H, İ ve L türü etkinliklerden en az 75 puan', ['ABCDFGHIL'], 75, madde: 'MADDE 7'),
        ]),
    ];
}

return $esikler;
