<?php

/**
 * TRABZON ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Yönergesi
 * Kaynak: pdf/17537009582.trabzonuniverstesi.pdf (Madde 1-8 + Tablo 1-3)
 *
 * KORPUSTA TELAFİYİ ÇARPANLA KURAN İLK YÖNERGE. Doçent ve profesörlükte
 * öngörülen puan üçe bölünüyor:
 *   %30  yayın kalemlerinden (Tablo 2'nin 1.1.1 - 1.3.4.1 aralığı)
 *   %30  ödül, proje ve patent kalemlerinden (2.1.1 - 2.4.4 aralığı)
 *   %40  serbest, tablonun tamamından
 * İkinci %30'u toplayamayan aday, "her eksik puanın İKİ KATI FAZLA puanı"
 * yayın kalemlerinden sağlamak zorunda. "Fazla" kelimesi önemli: telafiye
 * giren aday yayınlardan istenen ilk %30'dan muaf olmuyor, açığın iki katını
 * onun ÜSTÜNE ekliyor. Motorun `telafi_carpani` alanı bu yüzden `min_puan`ı
 * taban kabul ediyor (gereken = taban + eksik × 2).
 *
 * EŞİK FAKÜLTEYE BAĞLI, TEMEL ALANA DEĞİL. Tablo 1 üniversitenin bütün
 * birimlerini tek tek sayıyor ve hepsinde "tüm bölümler" diyor:
 *   Dr. Öğr. Üyesi   her birimde 10
 *   Doçent           40 · Güzel Sanatlar ve Hukuk Fakültelerinde 28
 *   Profesör         60 · Güzel Sanatlar ve Hukuk Fakültelerinde 42
 * Tablo bütün fakülteleri, yüksekokulları ve "Meslek Yüksekokulları / tüm
 * programlar" satırını kapsadığı için eşik ON İKİ TEMEL ALANIN HEPSİNE
 * yazıldı; yönerge alan grubu değil birim sayıyor ve saydığı birimlerin
 * dışında kadro yok.
 *
 * GÜZEL SANATLAR İKİYE AYRILDI: Güzel Sanatlar Fakültesi 28/42, Devlet
 * Konservatuvarı 40/60 alıyor. İkisi de `guzel_sanatlar` temel alanına
 * düştüğü için `birim` alanıyla ayrıldı; aday birimini seçmeden doğru eşik
 * bulunamaz.
 *
 * YÜZDELER SABİT PUANA ÇEVRİLDİ. "Öngörülen puan" Tablo 1'in kendisi olduğu
 * için oranlar hesaplanabiliyor. Kesirli değerler YUKARI yuvarlandı — baraj
 * söz konusu olduğunda yukarı yuvarlamak adayı hazır olmadığı bir başvuruya
 * sokmayan taraf:
 *   40 × %30 = 12      ·  60 × %30 = 18
 *   28 × %30 = 8,4 → 9 ·  42 × %30 = 12,6 → 13
 *   10 × 2/3 = 6,67 → 7  (Dr. Öğr. Üyeliğindeki makale koşulu)
 *
 * DR. ÖĞR. ÜYELİĞİNDE DÖNEM YOK: Madde 3 puanın hangi tarihten sonra
 * üretileceğini söylemiyor, bu yüzden dönem kısıtı yazılmadı. Doçentlikte
 * "doktor unvanını aldıktan sonra" (Madde 4.2), profesörlükte "doçentlik
 * başvurusunu yaptıktan sonra" (Madde 5.2) açıkça yazılı; ikincisi doçentlik
 * BAŞVURU tarihine bağlı, motor doçentlik unvanı tarihini tuttuğu için
 * doçentlik sonrası dönem kullanıldı.
 *
 * MESLEK YÜKSEKOKULU İSTİSNASI (Madde 3.3): "doktora yapılan alana
 * bakılmaksızın standart olarak 10 puan" — Tablo 1'in MYO satırıyla aynı
 * değer olduğu için ayrı eşik gerekmedi.
 *
 * YABANCI DİL yalnızca Dr. Öğr. Üyeliğinde aranıyor (Madde 3.2); doçent ve
 * profesörlük maddelerinde dil koşulu YOK, o yüzden yazılmadı. "Yabancı dille
 * ilgili bölümler için 85" ifadesi birimin öğretim diline bağlandı; %100
 * yabancı dilde öğretim yapan birimler de yüksek eşiğe konuldu (belirsizlikte
 * yüksek baraj, adayı fazla hazır göstermeyen taraf).
 *
 * GİRİLMEYENLER:
 *   Madde 6 (görevden ayrılma) 2547'ye atıf yapıyor, kendi ölçütü yok.
 *   Yeniden atanma koşulu yönergede hiç yok.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/trabzon-2025.php
 */

use App\Services\Scoring\Sart\Kalip;

$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;

$YAYIN = '1.1.1-1.3.4.1';
$ODUL_PROJE_PATENT = '2.1.1-2.4.4';

$tumAlanlar = ['fen', 'muhendislik', 'saglik', 'sosyal', 'egitim', 'ilahiyat',
    'hukuk', 'filoloji', 'guzel_sanatlar', 'mimarlik', 'ziraat', 'spor'];

/** Güzel Sanatlar ve Hukuk dışındaki bütün birimler aynı barajı paylaşıyor. */
$genelAlanlar = array_values(array_diff($tumAlanlar, ['hukuk', 'guzel_sanatlar']));

$GSF = 'Güzel Sanatlar Fakültesi';
$KONSERVATUVAR = 'Devlet Konservatuvarı';

$dagilimNotu = 'Puanınızın %30\'u yayınlardan, %30\'u ödül-proje-patent kalemlerinden '
    .'gelmeli; kalan %40 serbest. İkinci %30\'u toplayamazsanız yönerge eksik kalan her '
    .'puanın iki katını fazladan yayınlardan istiyor.';

/**
 * Doçent ve profesörlükte tekrarlayan üçlü dağılım.
 *
 * @param  array<string, mixed>  $donem
 * @return list<array<string, mixed>>
 */
$dagilim = function (int $toplam, string $madde, array $donem) use ($YAYIN, $ODUL_PROJE_PATENT): array {
    $pay = (int) ceil($toplam * 0.30);

    return [
        Kalip::puanDan(
            "Makale, bildiri ve kitap kalemlerinizden en az {$pay} puan",
            [$YAYIN],
            $pay,
            $donem,
            madde: $madde,
        ),
        Kalip::puanDan(
            "Ödül, proje ve patent kalemlerinizden en az {$pay} puan",
            [$ODUL_PROJE_PATENT],
            $pay,
            $donem,
            madde: $madde,
        ) + [
            // "…toplayamaması durumunda aday, her eksik puanın iki katı fazla
            // puanı 1.1.1 - 1.3.4.1 arası kodlu faaliyetlerden sağlamalıdır."
            // Taban ($pay) duruyor, açığın iki katı üstüne biniyor.
            'telafi' => [
                'tip' => 'puan',
                'aciklama' => 'Ödül, proje ve patentiniz yetmiyorsa: eksik kalan her puanın '
                    .'iki katını fazladan makale, bildiri ve kitap kalemlerinizden sağlamalısınız',
                'madde' => $madde,
                'maddeler' => [$YAYIN],
                'min_puan' => $pay,
                'telafi_carpani' => 2,
                'donem' => $donem,
            ],
        ],
    ];
};

/**
 * Bir kadro eşiği. `$birim` yalnızca Güzel Sanatlar'ın iki biriminde dolu.
 *
 * @param  list<string>  $alanlar
 * @return array<string, mixed>
 */
$esik = function (string $anahtar, string $baslik, array $alanlar, ?string $birim, string $kadro,
    int $toplam, string $madde, string $notlar, string $adayNotu) use ($dagilim, $DOKTORA, $DOCENTLIK): array {
    $donem = $kadro === 'docentlik' ? $DOKTORA : $DOCENTLIK;

    return [
        'anahtar' => $anahtar,
        'aday_notu' => $adayNotu,
        'universite' => 'Trabzon Üniversitesi',
        'kadro' => $kadro,
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => 'trabzon-2025',
        'notlar' => $notlar,
        'sart' => Kalip::ve($baslik, [
            Kalip::beyan(
                $kadro === 'docentlik'
                    ? 'Doçentlik unvanına sahip olmak ve Üniversitelerarası Kurul jürisinin sözlü sınavında başarılı olmak'
                    : 'Doçentlik unvanına sahip olmak, sözlü sınavda başarılı olmak ve unvanı aldığınız dönemin YÖK doçentlik asgari koşullarını yeniden sağlamış olmak',
                $kadro === 'docentlik' ? 'Madde 4.1' : 'Madde 5.1',
            ),
            Kalip::toplam($toplam, $donem),
            ...$dagilim($toplam, 'Tablo 1 açıklaması', $donem),
        ]),
    ];
};

/** Madde 3.2 — YÖKDİL/YDS 65; yabancı dille ilgili bölümlerde 85. */
$dil = [
    'tip' => 'metrik',
    'aciklama' => 'Yabancı dil sınavı (YDS/YÖKDİL) asgari puanı',
    'madde' => 'Madde 3.2',
    'metrik' => 'yds',
    'kademeler' => [
        'turkce' => 65,
        'yabanci_dil_30' => 65,
        'yabanci_dil_100' => 85,
        'yabanci_dil_egitimi' => 85,
    ],
];

return [
    // ══════════════════ DR. ÖĞRETİM ÜYESİ ══════════════════
    // Tablo 1'in Dr. sütunu bütün birimlerde 10; alan ayrımı yok.
    [
        'anahtar' => 'trabzon-dr',
        'aday_notu' => 'Baraj korpusun en düşüğü (10 puan) ama tamamı serbest değil: '
            .'en az 7 puanı makalelerden gelmeli. Tek bir uluslararası indeksli makale '
            .'(8 puan) iki koşulu birden karşılıyor.',
        'universite' => 'Trabzon Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $tumAlanlar,
        'cetvel' => 'trabzon-2025',
        'notlar' => 'Madde 3 + Tablo 1. Bütün fakülte, yüksekokul ve meslek yüksekokullarında '
            .'Tablo 2\'den 10 puan; "öngörülen puanın en az 2/3\'ü makalelerden alınmalıdır" '
            .'(10 × 2/3 = 6,67, yukarı yuvarlanarak 7). Madde 3.3: MYO atamalarında doktora '
            .'alanına bakılmaksızın aynı 10 puan aranıyor, ayrı eşik gerekmedi.',
        'sart' => Kalip::ve('Dr. Öğr. Üyeliğine ilk atanma koşulları', [
            Kalip::toplam(10),
            Kalip::puanDan('Makalelerinizden en az 7 puan', ['MAKALELER'], 7, madde: 'Madde 3.1'),
            $dil,
        ]),
    ],

    // ══════════════════ DOÇENT ══════════════════
    $esik(
        'trabzon-docent',
        'Doçent kadrosuna atanma koşulları',
        $genelAlanlar,
        null,
        'docentlik',
        40,
        'Madde 4.2',
        'Madde 4 + Tablo 1. Güzel Sanatlar ve Hukuk dışındaki bütün birimlerde doktor '
            .'unvanından sonraki dönemde Tablo 2\'den 40 puan; bunun 12\'si yayın, 12\'si '
            .'ödül-proje-patent kalemlerinden.',
        $dagilimNotu,
    ),
    $esik(
        'trabzon-docent-hukuk',
        'Doçent kadrosuna atanma koşulları — Hukuk Fakültesi',
        ['hukuk'],
        null,
        'docentlik',
        28,
        'Madde 4.2',
        'Madde 4 + Tablo 1. Hukuk Fakültesi\'nde doçentlik barajı 40 değil 28; '
            .'%30\'luk paylar 8,4 ederken yukarı yuvarlanarak 9 alındı.',
        'Hukuk Fakültesi barajı diğer birimlerden düşük (28). '.$dagilimNotu,
    ),
    $esik(
        'trabzon-docent-gsf',
        'Doçent kadrosuna atanma koşulları — Güzel Sanatlar Fakültesi',
        ['guzel_sanatlar'],
        $GSF,
        'docentlik',
        28,
        'Madde 4.2',
        'Madde 4 + Tablo 1. Güzel Sanatlar Fakültesi 28 puan alıyor, Devlet Konservatuvarı '
            .'40; ikisi de guzel_sanatlar temel alanına düştüğü için birim ayrımı zorunlu.',
        'Güzel Sanatlar Fakültesi barajı Devlet Konservatuvarı\'ndan düşük (28\'e karşı 40). '
            .$dagilimNotu,
    ),
    $esik(
        'trabzon-docent-konservatuvar',
        'Doçent kadrosuna atanma koşulları — Devlet Konservatuvarı',
        ['guzel_sanatlar'],
        $KONSERVATUVAR,
        'docentlik',
        40,
        'Madde 4.2',
        'Madde 4 + Tablo 1. Devlet Konservatuvarı Güzel Sanatlar Fakültesi\'nden farklı '
            .'olarak genel barajı (40) alıyor.',
        'Devlet Konservatuvarı barajı Güzel Sanatlar Fakültesi\'nden yüksek (40\'a karşı 28). '
            .$dagilimNotu,
    ),

    // ══════════════════ PROFESÖR ══════════════════
    $esik(
        'trabzon-profesor',
        'Profesör kadrosuna atanma koşulları',
        $genelAlanlar,
        null,
        'profesorluk',
        60,
        'Madde 5.2',
        'Madde 5 + Tablo 1. Güzel Sanatlar ve Hukuk dışındaki bütün birimlerde doçentlik '
            .'başvurusundan sonraki dönemde Tablo 2\'den 60 puan; 18\'i yayın, 18\'i '
            .'ödül-proje-patent kalemlerinden. Madde 5.2: "Belirtilen bilimsel faaliyetlerin '
            .'doçentlik başvurusunda kullanılmadığı, başvuru sonrası üretildiği '
            .'belgelenmelidir. Bu belgelemede yayının basım tarihi esas alınır."',
        $dagilimNotu,
    ),
    $esik(
        'trabzon-profesor-hukuk',
        'Profesör kadrosuna atanma koşulları — Hukuk Fakültesi',
        ['hukuk'],
        null,
        'profesorluk',
        42,
        'Madde 5.2',
        'Madde 5 + Tablo 1. Hukuk Fakültesi\'nde profesörlük barajı 60 değil 42; '
            .'%30\'luk paylar 12,6 ederken yukarı yuvarlanarak 13 alındı.',
        'Hukuk Fakültesi barajı diğer birimlerden düşük (42). '.$dagilimNotu,
    ),
    $esik(
        'trabzon-profesor-gsf',
        'Profesör kadrosuna atanma koşulları — Güzel Sanatlar Fakültesi',
        ['guzel_sanatlar'],
        $GSF,
        'profesorluk',
        42,
        'Madde 5.2',
        'Madde 5 + Tablo 1. Güzel Sanatlar Fakültesi 42, Devlet Konservatuvarı 60 puan.',
        'Güzel Sanatlar Fakültesi barajı Devlet Konservatuvarı\'ndan düşük (42\'ye karşı 60). '
            .$dagilimNotu,
    ),
    $esik(
        'trabzon-profesor-konservatuvar',
        'Profesör kadrosuna atanma koşulları — Devlet Konservatuvarı',
        ['guzel_sanatlar'],
        $KONSERVATUVAR,
        'profesorluk',
        60,
        'Madde 5.2',
        'Madde 5 + Tablo 1. Devlet Konservatuvarı genel barajı (60) alıyor.',
        'Devlet Konservatuvarı barajı Güzel Sanatlar Fakültesi\'nden yüksek (60\'a karşı 42). '
            .$dagilimNotu,
    ),
];
