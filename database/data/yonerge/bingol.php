<?php

/**
 * BİNGÖL ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Yönergesi
 * Kaynak: pdf/17536931942.bingoluniverstesi.pdf (Madde 9-15)
 *
 * DOÇENTLİKTE PUAN BARAJI YOK (Madde 11): yönerge yalnızca ÜAK doçentlik
 * unvanını, doçentlik sözlü sınavında başarıyı ve 65 yabancı dil puanını şart
 * koşuyor. Bu kasıtlı; olmayan bir baraj uydurmak adaya aranmayan bir koşul
 * gösterirdi.
 *
 * DR. VE PROFESÖRLÜKTE AYNI YAPI, FARKLI SAYILAR: toplam puanın bir kısmı
 * "zorunlu maddeler"den gelmeli.
 *   Dr. Öğr. Üyesi   zorunludan 100 · toplam 150
 *   Profesör         zorunludan 250 · toplam 500, HER İKİSİNİN DE YARISI
 *                    doçentlik sonrası
 *
 * ZORUNLU MADDE KÜMESİ ALANA GÖRE DEĞİŞİYOR:
 *   Fen, Müh.-Mimarlık, Sağlık,
 *   Sosyal, Güzel Sanatlar (Kuramsal)  1, 2, 6, 10, 11, 12, 13, 52
 *   Güzel Sanatlar (Uygulamalı)        25, 29, 30, 31, 42, 43, 44
 *   Müzik (Sanatçılık)                 43, 44, 45, 46
 *   Müzik (Kompozisyon)                29
 * Güzel Sanatlar ve Müzik'in alt alanları temel alan kodundan ayrılamadığı için
 * `birim` alanıyla girildi; aday hangi alt alanda olduğunu seçmeden doğru eşiği
 * bulamıyor.
 *
 * PROFESÖRLÜKTE ALANA GÖRE EK YAYIN ŞARTI (Madde 13):
 *   Fen, Müh.-Mimarlık, Sağlık   1.a'dan (SSCI/SCI-Exp/AHCI) puan almak zorunlu
 *   Sosyal                       1.a'dan en az 1 VEYA 1.c'den en az 2 eser
 *
 * LİSANSÜSTÜ TEZ YÖNETİMİ TELAFİLİ (Madde 14): aday tez yönetiminden en az 16
 * puan almalı; yönetmemişse zorunlu maddelerden 250 yerine 270 puan istiyor.
 * Bu bir "ya-ya da" yapısı, `veya` düğümüyle girildi.
 *
 * YENİDEN ATANMA GİRİLMEDİ (Madde 10): koşul "her bir yıl için 30 puanlık
 * bilimsel çalışma" biçiminde; atanma dönemi uzunluğu profilde tutulmuyor.
 *
 * 52 NUMARALI MADDE (ihtisaslaşma programı görevleri) CETVELE GİRMEDİ; fen ve
 * sosyal alanların zorunlu kümesi bu yüzden olduğundan dar, baraj olduğundan
 * zor görünür.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/bingol-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$DOC = Kalip::DOCENTLIK_SONRASI;

$bilimselAlanlar = ['fen', 'muhendislik', 'mimarlik', 'saglik', 'sosyal', 'egitim',
    'hukuk', 'ilahiyat', 'filoloji', 'spor', 'ziraat'];
$fenGrubu = ['fen', 'muhendislik', 'mimarlik', 'saglik', 'ziraat'];
$sosyalGrubu = ['sosyal', 'egitim', 'hukuk', 'ilahiyat', 'filoloji', 'spor'];

$gsKuramsal = 'Güzel Sanatlar — Kuramsal Alanlar';
$gsUygulamali = 'Güzel Sanatlar — Uygulamalı Alanlar';
$muzikSanatcilik = 'Müzik — Sanatçılık Alanı';
$muzikKompozisyon = 'Müzik — Kompozisyon Alanı';

$yenidenAtamaNotu = 'Yeniden atanmada yönerge yıl başına puan istiyor: en az biri '
    .'makale ya da kitap kalemlerinden olmak üzere her yıl için 30 puan. Atanma dönemi '
    .'uzunluğu burada tutulmadığı için yeniden atanma eşiği girilmedi.';

$ihtisasNotu = 'Üniversitenin ihtisaslaşma kalemi (52 — Tarım ve Havza Bazlı Kalkınma '
    .'programındaki koordinatörlük ve proje görevleri) cetvele girilemedi; zorunlu maddeler '
    .'barajınız bu yüzden olduğundan zor görünür.';

/**
 * Dr. Öğr. Üyeliği eşiği: zorunlu kümeden 100, toplam 150.
 *
 * @param  list<string>  $alanlar
 * @return array<string, mixed>
 */
$dr = function (string $anahtar, string $ad, array $alanlar, ?string $birim, string $kume,
    string $kumeAd, string $madde, string $notu): array {
    return [
        'anahtar' => "bingol-dr-{$anahtar}",
        'aday_notu' => $notu,
        'universite' => 'Bingöl Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => array_values($alanlar),
        'birim' => $birim,
        'cetvel' => 'bingol-2024',
        'notlar' => "Madde 9/{$madde} ({$ad}): zorunlu maddelerden en az 100, toplam 150 puan.",
        'sart' => Kalip::ve("Dr. Öğr. Üyesi — {$ad}", [
            Kalip::toplam(150),
            Kalip::puanDan("{$kumeAd} en az 100 puan", [$kume], 100, madde: "Madde 9/{$madde}"),
        ]),
    ];
};

/**
 * Profesörlük eşiği: zorunlu kümeden 250, toplam 500, ikisinin de yarısı
 * doçentlik sonrası. Tez yönetimi telafisi Madde 14'ten.
 *
 * @param  list<string>  $alanlar
 * @param  list<array<string, mixed>>  $ek
 * @return array<string, mixed>
 */
$profesor = function (string $anahtar, string $ad, array $alanlar, ?string $birim, string $kume,
    string $kumeAd, string $madde, string $notu, array $ek = []) use ($DOC): array {
    return [
        'anahtar' => "bingol-profesor-{$anahtar}",
        'aday_notu' => $notu,
        'universite' => 'Bingöl Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => array_values($alanlar),
        'birim' => $birim,
        'cetvel' => 'bingol-2024',
        'notlar' => "Madde 13/{$madde} ({$ad}): zorunlu maddelerden en az 250, toplam 500 puan; "
            .'her ikisinin de yarısı doçentlik sonrası. Madde 14: tez yönetiminden en az 16 puan '
            .'ya da zorunlu maddelerden 270 puan.',
        'sart' => Kalip::ve("Profesör — {$ad}", [
            Kalip::yds(65),
            Kalip::toplam(500),
            Kalip::toplam(250, $DOC),
            Kalip::puanDan("{$kumeAd} en az 250 puan", [$kume], 250, madde: "Madde 13/{$madde}"),
            Kalip::puanDan("Doçentliğinizden sonra {$kumeAd} en az 125 puan", [$kume], 125, $DOC,
                madde: "Madde 13/{$madde}"),
            Kalip::veya('Lisansüstü tez yönetimi koşulu', [
                Kalip::puanDan('Lisansüstü tez yönetiminizden en az 16 puan',
                    ['TEZ_YONETIMI'], 16, madde: 'Madde 14'),
                Kalip::puanDan("Tez yönetmediyseniz {$kumeAd} 250 yerine en az 270 puan",
                    [$kume], 270, madde: 'Madde 14'),
            ]),
            ...array_values($ek),
        ]),
    ];
};

return [
    // ══════════ DR. ÖĞRETİM ÜYESİ (Madde 9) ══════════
    $dr('bilimsel', 'Fen, Mühendislik-Mimarlık, Sağlık ve Sosyal Bilimler', $bilimselAlanlar,
        null, 'ZORUNLU', 'Makale, tebliğ ve kitap kalemlerinizden', 'a',
        $yenidenAtamaNotu.' '.$ihtisasNotu),

    $dr('gs-kuramsal', $gsKuramsal, ['guzel_sanatlar'], $gsKuramsal, 'ZORUNLU',
        'Makale, tebliğ ve kitap kalemlerinizden', 'b-1',
        'Güzel Sanatların KURAMSAL alanlarında bilimsel alanlarla aynı zorunlu maddeler '
        .'geçerli. '.$yenidenAtamaNotu),

    $dr('gs-uygulamali', $gsUygulamali, ['guzel_sanatlar'], $gsUygulamali, 'GS_UYGULAMALI',
        'Sergi, kompozisyon, film ve sanatsal etkinlik kalemlerinizden', 'b-2',
        'Güzel Sanatların UYGULAMALI alanlarında zorunlu maddeler sanatsal etkinliklerden '
        .'oluşuyor; makale ve kitap yalnızca genel toplama sayılıyor. Kostüm tasarımı (42) '
        .'kalemi girilemedi. '.$yenidenAtamaNotu),

    $dr('muzik-sanatcilik', $muzikSanatcilik, ['guzel_sanatlar'], $muzikSanatcilik,
        'MUZIK_SANATCILIK', 'Dinleti, konser ve yönettiğiniz sanatsal faaliyetlerden', 'c-1',
        'Müzik sanatçılık alanında zorunlu maddeler yalnızca sanatsal etkinlikler; makale ve '
        .'kitap genel toplama sayılıyor. '.$yenidenAtamaNotu),

    $dr('muzik-kompozisyon', $muzikKompozisyon, ['guzel_sanatlar'], $muzikKompozisyon,
        'KOMPOZISYON', 'Müzik kompozisyonlarınızdan', 'c-2',
        'Müzik kompozisyon alanında zorunlu maddeler TEK bir kalemden (29) oluşuyor: '
        .'bestelediğiniz yapıtlar. '.$yenidenAtamaNotu),

    // ══════════ DOÇENT (Madde 11 — puan barajı yok) ══════════
    [
        'anahtar' => 'bingol-docent',
        'aday_notu' => 'Bingöl yönergesi doçentlik için puan barajı koymuyor; yalnızca '
            .'ÜAK doçentlik unvanını, doçentlik sözlü sınavında başarıyı ve yabancı dil puanını '
            .'şart koşuyor. Burada baraj görmüyorsunuz — eksik veri değil, yönergede öyle.',
        'universite' => 'Bingöl Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => [...$bilimselAlanlar, 'guzel_sanatlar'],
        'cetvel' => 'bingol-2024',
        'notlar' => 'Madde 11: doçent unvanı, ÜAK doçentlik sözlü sınavında başarı ve yabancı '
            .'dil sınavından en az 65 puan.',
        'sart' => Kalip::ve('Doçent — Bingöl Üniversitesi', [
            Kalip::yds(65),
            Kalip::beyan('Doçent unvanını almış olmak ve Üniversitelerarası Kurul tarafından '
                .'oluşturulan jürinin yaptığı doçentlik sözlü sınavında başarılı olmak',
                'Madde 11/a-b'),
        ]),
    ],

    // ══════════ PROFESÖR (Madde 12-15) ══════════
    $profesor('fen', 'Fen, Mühendislik-Mimarlık ve Sağlık Bilimleri', $fenGrubu, null,
        'ZORUNLU', 'Makale, tebliğ ve kitap kalemlerinizden', 'a',
        'SSCI, SCI-Expanded veya AHCI dergilerdeki makalelerinizden puan almanız ZORUNLU '
        .'; diğer kalemler tek başına yetmiyor. '.$ihtisasNotu, [
            Kalip::adet('SSCI, SCI-Expanded veya AHCI dergide en az 1 makale',
                ['1.a'], 1, madde: 'Madde 13/a'),
        ]),

    $profesor('sosyal', 'Sosyal Bilimler', $sosyalGrubu, null,
        'ZORUNLU', 'Makale, tebliğ ve kitap kalemlerinizden', 'b',
        'Yayın şartının iki alternatifi var: SSCI/SCI-Expanded/AHCI dergide 1 makale ya da alan '
        .'indeksli dergilerde 2 eser. '.$ihtisasNotu, [
            Kalip::veya('Zorunlu yayın koşulu', [
                Kalip::adet('SSCI, SCI-Expanded veya AHCI dergide en az 1 makale',
                    ['1.a'], 1, madde: 'Madde 13/b'),
                Kalip::adet('Alan indeksli dergilerde en az 2 eser',
                    ['1.c'], 2, madde: 'Madde 13/b'),
            ]),
        ]),

    $profesor('gs-kuramsal', $gsKuramsal, ['guzel_sanatlar'], $gsKuramsal,
        'ZORUNLU', 'Makale, tebliğ ve kitap kalemlerinizden', 'c-1',
        'Güzel Sanatların KURAMSAL alanlarında Sosyal Bilimlerle aynı esaslar geçerli.'),

    $profesor('gs-uygulamali', $gsUygulamali, ['guzel_sanatlar'], $gsUygulamali,
        'GS_UYGULAMALI', 'Sergi, kompozisyon, film ve sanatsal etkinlik kalemlerinizden', 'c-2',
        'Güzel Sanatların UYGULAMALI alanlarında zorunlu maddeler sanatsal etkinliklerden '
        .'oluşuyor. Kostüm tasarımı (42) kalemi girilemedi.'),

    $profesor('muzik-sanatcilik', $muzikSanatcilik, ['guzel_sanatlar'], $muzikSanatcilik,
        'MUZIK_SANATCILIK', 'Dinleti, konser ve yönettiğiniz sanatsal faaliyetlerden', 'd-1',
        'Müzik sanatçılık alanında zorunlu maddeler yalnızca sanatsal etkinlikler.'),

    $profesor('muzik-kompozisyon', $muzikKompozisyon, ['guzel_sanatlar'], $muzikKompozisyon,
        'KOMPOZISYON', 'Müzik kompozisyonlarınızdan', 'd-2',
        'Müzik kompozisyon alanında zorunlu maddeler TEK bir kalemden (29) oluşuyor.'),
];
