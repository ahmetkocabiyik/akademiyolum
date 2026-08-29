<?php

/**
 * İSTANBUL ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Kriterleri
 * Kaynak: pdf/1784016632886.istanbul-universitesi-kriter.pdf
 * Yürürlük: Madde 17 — 01.06.2026
 *
 * DÖRT KADRO SÜTUNU, YEDİ ALAN BLOĞU (Madde 9-15). Bu dosya dördünü giriyor:
 *   Madde 9   Sağlık Bilimleri
 *   Madde 10  Fen ve Mühendislik Bilimleri
 *   Madde 11  Sosyal Bilimler
 *   Madde 12  Mimarlık, Planlama ve Tasarım
 *   Madde 13  Devlet Konservatuvarı — Müzik ve Sahne Sanatları Bölümleri
 *   Madde 14  Devlet Konservatuvarı — Müzikoloji Bölümü
 *   Madde 15  Devlet Konservatuvarı — Türk Müziği Bölümü
 * Son üçü `guzel_sanatlar` temel alanını paylaştığı için `birim` ile ayrıldı
 * ve `istanbul-2026-konservatuvar` cetvelini (Tablo 1 + Tablo 2) kullanıyor.
 *
 * ── KONSERVATUVARIN DÖRT SÜTUNU ──
 * Bu üç maddede kadro sütunları ötekilerden farklı çalışıyor:
 *   Dr. Öğr. Üyesi (İlk Atama)  YALNIZ bir yayın koşulu; puan barajı YOK.
 *   Dr. Öğr. Üyesi (Yeniden)    son üç yılda 60 puan (görev süresi uzatımı)
 *                               ve ayrıca Tablo 1'den 10-30, Tablo 2'den
 *                               10-30, toplam 200 puan.
 *   Doçent                      Tablo 1 ve Tablo 2'den ayrı paylar + son dört
 *                               yıl payı + toplam 300.
 *   Profesör                    başlıca eser + tez + ayrı paylar + doçentlik
 *                               sonrası pay + toplam 500.
 * Ham metin sütunları sayfa kırığında karıştırıyor; okuma üç maddede de
 * 200/300/500 merdivenini verecek biçimde çözüldü (Madde 15'in sütun
 * başlıkları ayrı satırlarda göründüğü için orayla doğrulandı).
 *
 * MATEMATİK ALANI AYRI BİRİM: Fen ve Mühendislik bloğu makale sayılarını
 * "(Matematik alanı için en az N)" diye ayrıca veriyor. Matematik `fen` temel
 * alanına düştüğü için `birim` alanıyla ayrıldı; birim seçilmezse genel fen
 * eşiği (daha yüksek sayılar) uygulanır — adayı fazla hazır göstermeyen taraf.
 *
 * ── "Q1-Q3 VARSA SAYI DÜŞER" KURALI ──
 * Bütün alanlarda makale koşulu iki değerli: "en az (8) makale; bunlardan en
 * az biri Q1-Q3 ise (7) yeterlidir". `veya` ile kuruldu: ya yüksek sayı, ya
 * düşük sayı + bir Q1-Q3 makale.
 *
 * ── PROJE KOŞULU ──
 * Her alanda "aşağıdaki koşullardan en az biri" biçiminde ve dallardan biri
 * hep aynı: Tablo 1'in fikrî ve sınai mülkiyet kalemlerinden (p-v) en az
 * birine sahip olmak. Dr. ilk atamada üçüncü bir dal var (yurt dışı doktora
 * bursu ya da dünya sıralamasında ilk 500'e giren üniversiteden doktora);
 * ikisi de faaliyet kaydından hesaplanamadığı için BEYAN olarak girildi.
 * "Proje süresi en az 12 ay, en az 6 ay görev" nitelikleri de kayıtta yok;
 * proje koşulu bu yüzden olduğundan KOLAY görünebilir.
 *
 * ── YABANCI DİL ÜÇ KADEMELİ (Madde 8-b, d, g, h) ──
 * Dr. Öğr. Üyesi 75 · doçent 80 · profesör 85. Öğretim dili %100 veya %30
 * yabancı dil olan birimlerde üç kadroda da 85. Doçentlik bilim alanı bir
 * yabancı dille ilgiliyse başka bir dilden 70 — bu istisna girilmedi, adayın
 * bilim alanının dili profilde tutulmuyor ve yüksek eşik güvenli taraf.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde 8-c  2016 ve öncesinde doktorasını tamamlayanlardan tez yayını
 *       aranmaması — muafiyet, atama yılına bağlı.
 *   Madde 8-e  profesörlük başlıca eserinin dergisinin etki faktörü şartı
 *       (sağlıkta ≥1, diğerlerinde ≥0,5) — kayıt etki faktörünü tutmuyor.
 *   Madde 8-f  tez koşulunun "son beş yılda ilgili birimde tez yapılmadığı
 *       belgelenirse aranmaz" istisnası.
 *   Madde 8-ı  Dr. kadrosuna atanmadan doçentliğe başvuranlardan ek proje
 *       koşulu — adayın geçmiş kadro geçmişi profilde yok.
 *   Mimarlık Profesör 4 / Doçent 3'ün "kuramsal alanlarda başvuranlardan bu
 *       koşullar aranmaz, yerine bir ilave makale istenir" istisnası; ilave
 *       makale dalı `veya` olarak girildi, kuramsal alan muafiyeti girilmedi.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/istanbul-2026.php
 */

use App\Services\Scoring\Sart\Kalip;

$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_UC_YIL = Kalip::sonYil(3);

/** Madde 8-b/d/g/h — kadroya göre 75/80/85; yabancı dilde öğretimde hep 85. */
$dil = fn (int $genel): array => [
    'tip' => 'metrik',
    'aciklama' => 'Yabancı dil sınavı (YDS/YÖKDİL) asgari puanı',
    'madde' => 'Madde 8',
    'metrik' => 'yds',
    'kademeler' => [
        'turkce' => $genel,
        'yabanci_dil_30' => 85,
        'yabanci_dil_100' => 85,
        'yabanci_dil_egitimi' => $genel,
    ],
];

/**
 * "En az N makale; bunlardan biri Q1-Q3 ise N-1 yeterli" kalıbı.
 *
 * @param  array<string, mixed>|null  $donem
 * @return array<string, mixed>
 */
$makaleKosulu = function (string $ad, string $kume, int $cok, int $az, string $ceyreklikKume,
    ?array $donem, string $madde): array {
    return Kalip::veya("{$ad}: en az {$cok} makale (biri üst çeyreklikteyse {$az} yeterli)", [
        Kalip::adet("{$ad} en az {$cok} özgün araştırma makalesi", [$kume], $cok, donem: $donem, madde: $madde),
        Kalip::ve("Ya da en az {$az} makale ve bunlardan biri üst çeyreklikte", [
            Kalip::adet("{$ad} en az {$az} özgün araştırma makalesi", [$kume], $az, donem: $donem, madde: $madde),
            Kalip::adet('Bunlardan en az 1\'i üst çeyreklikteki dergide yayımlanmış olmalı', [$ceyreklikKume], 1, donem: $donem, madde: $madde),
        ]),
    ]) + ['madde' => $madde];
};

/**
 * Proje koşulu: yönergenin saydığı dallardan en az biri.
 *
 * @param  array<string, mixed>|null  $donem
 * @return array<string, mixed>
 */
$projeKosulu = function (?array $donem, string $madde, bool $bursDali = false, ?array $ekMakale = null): array {
    $dallar = [
        Kalip::adet('Üniversite BAP birimleri dışında en az 1 dış kaynaklı projede görev almak', ['DIS-KAYNAKLI-PROJE'], 1, donem: $donem, madde: $madde),
        Kalip::adet('Ya da en az 1 patent, faydalı model veya endüstriyel tasarım belgesine sahip olmak', ['FSMH'], 1, donem: $donem, madde: $madde),
    ];

    if ($bursDali) {
        $dallar[] = Kalip::beyan(
            'Ya da en az 6 ay süreli yurt dışı doktora sırası/sonrası araştırma bursu tamamlamış '
            .'olmak ya da dünya sıralamasında ilk 500\'e giren bir üniversiteden doktora almış olmak',
            $madde,
        );
    }

    if ($ekMakale !== null) {
        $dallar[] = $ekMakale;
    }

    return Kalip::veya('Proje koşullarından en az biri sağlanmalı', $dallar) + ['madde' => $madde];
};

/**
 * Alan blokları. Sayılar Madde 9-12'den birebir.
 *
 * dr/docent/profesor  [çok, az] — "en az çok makale; biri üst çeyreklikteyse az"
 * profTez             [grup, sayı, adayın göreceği ad]
 * yeniden             [son üç yıldaki makale sayısı, küme, üst indeks sayısı, üst küme]
 */
$alanlar = [
    // ══════════ Madde 9 — SAĞLIK BİLİMLERİ ══════════
    [
        'anahtar' => 'istanbul-saglik', 'ad' => 'Sağlık Bilimleri', 'alanlar' => ['saglik'],
        'birim' => null, 'cetvel' => 'istanbul-2026', 'madde' => 'Madde 9',
        'kume' => 'SCIE', 'kumeAd' => 'SCIE kapsamındaki dergilerde', 'ceyreklik' => 'Q1-Q3',
        'dr' => [4, 3], 'docent' => [6, 5], 'profesor' => [8, 7],
        'profTez' => ['TEZ', 1, 'en az 1 lisansüstü tez'],
        'yeniden' => [3, 'WOS-SCOPUS-TRDIZIN', 1, 'SCIE'],
    ],
    // ══════════ Madde 10 — FEN VE MÜHENDİSLİK ══════════
    [
        'anahtar' => 'istanbul-fen', 'ad' => 'Fen ve Mühendislik Bilimleri',
        'alanlar' => ['fen', 'muhendislik'], 'birim' => null,
        'cetvel' => 'istanbul-2026', 'madde' => 'Madde 10',
        'kume' => 'SCIE', 'kumeAd' => 'SCIE kapsamındaki dergilerde', 'ceyreklik' => 'Q1-Q2',
        'dr' => [4, 3], 'docent' => [6, 5], 'profesor' => [8, 7],
        'profTez' => ['DOKTORA-TEZI', 1, 'en az 1 doktora tezi'],
        'yeniden' => [2, 'WOS-SCOPUS-TRDIZIN', 1, 'WOS-SCOPUS'],
    ],
    [
        'anahtar' => 'istanbul-matematik', 'ad' => 'Matematik', 'alanlar' => ['fen'],
        'birim' => 'Matematik Bölümü', 'cetvel' => 'istanbul-2026', 'madde' => 'Madde 10',
        'kume' => 'SCIE', 'kumeAd' => 'SCIE kapsamındaki dergilerde', 'ceyreklik' => 'Q1-Q3',
        'dr' => [3, 2], 'docent' => [5, 4], 'profesor' => [7, 6],
        'profTez' => ['DOKTORA-TEZI', 1, 'en az 1 doktora tezi'],
        'yeniden' => [2, 'WOS-SCOPUS-TRDIZIN', 1, 'WOS-SCOPUS'],
    ],
    // ══════════ Madde 11 — SOSYAL BİLİMLER ══════════
    [
        'anahtar' => 'istanbul-sosyal', 'ad' => 'Sosyal Bilimler',
        'alanlar' => ['sosyal', 'egitim', 'ilahiyat', 'hukuk', 'filoloji', 'spor'],
        'birim' => null, 'cetvel' => 'istanbul-2026', 'madde' => 'Madde 11',
        'kume' => 'MAKALE-VEYA-KITAP', 'kumeAd' => 'WoS, Scopus veya TR Dizin dergilerinde',
        'ceyreklik' => 'Q1-Q3',
        'dr' => [3, 3], 'docent' => [4, 4], 'profesor' => [6, 6],
        'profTez' => ['DOKTORA-TEZI', 1, 'en az 1 doktora tezi'],
        'yeniden' => [2, 'WOS-SCOPUS-TRDIZIN', 1, 'WOS-SCOPUS'],
    ],
    // ══════════ Madde 12 — MİMARLIK, PLANLAMA VE TASARIM ══════════
    [
        'anahtar' => 'istanbul-mimarlik', 'ad' => 'Mimarlık, Planlama ve Tasarım',
        'alanlar' => ['mimarlik'], 'birim' => null,
        'cetvel' => 'istanbul-2026-mimarlik', 'madde' => 'Madde 12',
        'kume' => 'MIMARLIK-MAKALE', 'kumeAd' => 'WoS, Scopus veya uluslararası alan indeksli dergilerde',
        'ceyreklik' => 'Q1-Q3',
        'dr' => [3, 2], 'docent' => [5, 4], 'profesor' => [7, 6],
        'profTez' => ['TEZ', 2, 'en az 2 lisansüstü tez'],
        'yeniden' => [2, 'WOS-SCOPUS-TRDIZIN', 1, 'WOS-SCOPUS'],
    ],
];

$esikler = [];

foreach ($alanlar as $a) {
    $madde = $a['madde'];
    $ortak = [
        'universite' => 'İstanbul Üniversitesi',
        'alan' => $a['alanlar'],
        'birim' => $a['birim'],
        'cetvel' => $a['cetvel'],
    ];
    $mimarlik = $a['anahtar'] === 'istanbul-mimarlik';

    // ══════════════ DR. ÖĞRETİM ÜYESİ (ilk atama) ══════════════
    [$cok, $az] = $a['dr'];
    $kosullar = [
        $dil(75),
        Kalip::adet('Doktora tezinizden üretilmiş en az 1 yayınınız olmalı', ['DOKTORA-TEZINDEN'], 1, madde: "{$madde} — Makale"),
        $makaleKosulu($a['kumeAd'], $a['kume'], $cok, $az, $a['ceyreklik'], null, "{$madde} — Makale"),
        $projeKosulu(null, "{$madde} — Proje", bursDali: true),
        Kalip::toplam(400),
    ];

    if ($mimarlik) {
        $kosullar[] = Kalip::veya('Mesleki çalışma ya da ilave yayın', [
            Kalip::adet('Yarışma ödülü, jüri üyeliği, mesleki uygulama veya fikrî mülkiyet belgesinden en az 1', ['MESLEKI-CALISMA'], 1, madde: "{$madde} — Mesleki Proje"),
            Kalip::adet('Ya da makale koşullarına ek 1 makale veya kitap', ['MAKALE-VEYA-KITAP'], $cok + 1, madde: "{$madde} — Mesleki Proje"),
        ]) + ['madde' => "{$madde} — Mesleki Proje"];
    }

    $esikler[] = $ortak + [
        'anahtar' => "{$a['anahtar']}-dr",
        'kadro' => 'dr_ogr_uyesi',
        'aday_notu' => "{$a['ad']} alanında ilk atanmada toplam 400 puan, {$cok} makale (biri üst "
            .'çeyreklikteyse '.$az.') ve doktora tezinden üretilmiş en az 1 yayın aranıyor. '
            .'Proje koşulu patent ya da yurt dışı doktora bursuyla da karşılanabiliyor.',
        'notlar' => "{$madde} + Tablo 1. Dr. Öğr. Üyesi (İlk Atama) sütunu: {$cok}/{$az} makale, "
            .'toplam 400 puan, yabancı dil 75.',
        'sart' => Kalip::ve("Dr. Öğr. Üyeliğine ilk atanma — {$a['ad']}", $kosullar),
    ];

    // ══════════════ DR. ÖĞRETİM ÜYESİ (yeniden atama) ══════════════
    [$yeniAdet, $yeniKume, $ustAdet, $ustKume] = $a['yeniden'];
    $esikler[] = $ortak + [
        'anahtar' => "{$a['anahtar']}-dr-yeniden",
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'aday_notu' => 'Görev süresi uzatmada yalnızca son üç yılda ürettiğiniz çalışmalar '
            ."sayılıyor: {$yeniAdet} makale ve Tablo 1'den 80 puan. Puan hesabında eğitim-öğretim, "
            .'idari görev ve h-indeksi kalemleri sayılmıyor.',
        'notlar' => "{$madde} + Tablo 1. Dr. Öğr. Üyesi (Yeniden Atama) sütunu: son 3 yılda "
            ."{$yeniAdet} makale, Tablo 1'den 80 puan (Tablo 1 Madde 8, 10 ve 11 hariç).",
        'sart' => Kalip::ve("Dr. Öğr. Üyeliğine yeniden atanma — {$a['ad']}", [
            Kalip::adet("Son üç yılda en az {$yeniAdet} özgün araştırma makalesi", [$yeniKume], $yeniAdet, donem: $SON_UC_YIL, madde: $madde),
            Kalip::adet("Bunların en az {$ustAdet}'i üst indeksli dergide olmalı", [$ustKume], $ustAdet, donem: $SON_UC_YIL, madde: $madde),
            Kalip::puanDan('Son üç yıldaki faaliyetlerinizden en az 80 puan', ['TABLO1-YENIDEN'], 80, $SON_UC_YIL, madde: $madde),
        ]),
    ];

    // ══════════════ DOÇENT ══════════════
    [$cok, $az] = $a['docent'];
    $kosullar = [
        Kalip::beyan('Doçent unvanını kazanmış olmak', 'Madde 8-ç'),
        $dil(80),
        $makaleKosulu($a['kumeAd'], $a['kume'], $cok, $az, $a['ceyreklik'], $DOKTORA, "{$madde} — Makale"),
        $projeKosulu($DOKTORA, "{$madde} — Proje"),
        Kalip::toplam(600),
    ];

    if ($mimarlik) {
        $kosullar[] = Kalip::veya('Mesleki çalışma ya da ilave yayın', [
            Kalip::adet('Yarışma ödülü, jüri üyeliği, mesleki uygulama veya fikrî mülkiyet belgesinden en az 1', ['MESLEKI-CALISMA'], 1, madde: "{$madde} — Mesleki Proje"),
            Kalip::adet('Ya da makale koşullarına ek 1 makale veya kitap', ['MAKALE-VEYA-KITAP'], $cok + 1, donem: $DOKTORA, madde: "{$madde} — Mesleki Proje"),
        ]) + ['madde' => "{$madde} — Mesleki Proje"];

        $kosullar[] = Kalip::adet('Eğitim-öğretim faaliyetlerinden en az 1', ['T4-EGITIM'], 1, madde: "{$madde} — Eğitim Öğretim");
    }

    $esikler[] = $ortak + [
        'anahtar' => "{$a['anahtar']}-docent",
        'kadro' => 'docentlik',
        'aday_notu' => "{$a['ad']} alanında doçentlikte toplam 600 puan ve doktora sonrası "
            ."üretilmiş {$cok} makale (biri üst çeyreklikteyse {$az}) aranıyor.",
        'notlar' => "{$madde} + Tablo 1. Doçent sütunu: {$cok}/{$az} makale (doktora sonrası), "
            .'toplam 600 puan, yabancı dil 80.',
        'sart' => Kalip::ve("Doçent kadrosuna atanma — {$a['ad']}", $kosullar),
    ];

    // ══════════════ PROFESÖR ══════════════
    [$cok, $az] = $a['profesor'];
    [$tezKume, $tezSayi, $tezAd] = $a['profTez'];
    $kosullar = [
        Kalip::beyan('Doçentlik unvanını aldıktan sonra en az beş yıl geçmiş olmak ve başlıca araştırma eserinizin derginin etki faktörü koşulunu sağlaması', 'Madde 8-e'),
        $dil(85),
        Kalip::adet('Başlıca araştırma eseri: doçentlik sonrası, sorumlu yazar olduğunuz en az 1 makale', ['SCIE'], 1, 'baslica', $DOCENTLIK, madde: "{$madde} — Başlıca Eser"),
        $makaleKosulu($a['kumeAd'], $a['kume'], $cok, $az, $a['ceyreklik'], $DOCENTLIK, "{$madde} — Makale"),
        $projeKosulu($DOCENTLIK, "{$madde} — Proje"),
        Kalip::adet("Danışmanlığınızda tamamlanmış {$tezAd}", [$tezKume], $tezSayi, madde: "{$madde} — Tez"),
        Kalip::toplam(800),
    ];

    if ($mimarlik) {
        $kosullar[] = Kalip::veya('En az 2 mesleki çalışma ya da ilave yayın', [
            Kalip::adet('Yarışma ödülü, jüri üyeliği, mesleki uygulama veya fikrî mülkiyet belgesinden en az 2', ['MESLEKI-CALISMA'], 2, madde: "{$madde} — Mesleki Proje"),
            Kalip::adet('Ya da makale koşullarına ek 1 makale veya kitap', ['MAKALE-VEYA-KITAP'], $cok + 1, donem: $DOCENTLIK, madde: "{$madde} — Mesleki Proje"),
        ]) + ['madde' => "{$madde} — Mesleki Proje"];
    }

    $esikler[] = $ortak + [
        'anahtar' => "{$a['anahtar']}-profesor",
        'kadro' => 'profesorluk',
        'aday_notu' => "{$a['ad']} alanında profesörlükte toplam 800 puan, doçentlik sonrası "
            ."{$cok} makale (biri üst çeyreklikteyse {$az}) ve sorumlu yazar olduğunuz bir "
            .'başlıca araştırma eseri aranıyor. Başlıca eserin dergisinin etki faktörü koşulu '
            .'kayıttan doğrulanamıyor, beyan olarak duruyor.',
        'notlar' => "{$madde} + Tablo 1. Profesör sütunu: başlıca eser + {$cok}/{$az} makale "
            ."(doçentlik sonrası), {$tezAd}, toplam 800 puan, yabancı dil 85.",
        'sart' => Kalip::ve("Profesör kadrosuna atanma — {$a['ad']}", $kosullar),
    ];
}

// ══════════════════════════════════════════════════════════════════════
// MADDE 13-15 — DEVLET KONSERVATUVARI
// ══════════════════════════════════════════════════════════════════════
$SON_DORT_YIL = Kalip::sonYil(4);

$KONSERVATUVAR_NOTU = 'Tablo 2\'nin uluslararası ve ulusal satırları kayıtta ayrı etiketi '
    .'olmayan kalemlerde (orkestra ve koro üyeliği, audio yayın, radyo-televizyon katılımı, '
    .'yarışma derecesi) tek satıra düştü ve ulusal değerden sayılıyor; 2. maddenin çeviri '
    .'bentleri ile 4 ve 6. maddelerin karma dinleti ve oda müziği organizasyonu bentleri '
    .'kayıtta karşılıksız olduğu için girilmedi. Tablo 1\'in formüllü kalemleri (makalede '
    .'etki faktörü, h-indeksi) burada da eksik, yani toplam puanınız gerçeğinden düşük '
    .'olabilir, yüksek olamaz.';

/** @var list<array<string, mixed>> $konservatuvar */
$konservatuvar = [
    [
        'anahtar' => 'istanbul-konservatuvar-muzik-sahne',
        'ad' => 'Devlet Konservatuvarı Müzik ve Sahne Sanatları',
        'birim' => 'Devlet Konservatuvarı — Müzik ve Sahne Sanatları Bölümleri',
        'madde' => 'Madde 13',
        'prof' => [30, 100, 70],
        'docent' => [20, 80, 40],
        'yeniden' => [10, 30],
        'drYayin' => 'Doktora ya da sanatta yeterlik tezinizin kitap olarak veya Yükseköğretim Kurulu ya da İstanbul Üniversitesi\'nin sağlayacağı elektronik ortamda yayımlanmış olması',
        'baslicaEser' => 'Doçent unvanını aldıktan sonra yaptığınız yapıt ya da etkinliklerden (yayımlanmış kitap, CD, etüt, özgün libretto; sahnelenmiş tiyatro eseri, özgün koreografi, opera veya müzikal tiyatro librettosu) en az birini başlıca araştırma eseri olarak sunmak',
    ],
    [
        'anahtar' => 'istanbul-konservatuvar-muzikoloji',
        'ad' => 'Devlet Konservatuvarı Müzikoloji',
        'birim' => 'Devlet Konservatuvarı — Müzikoloji Bölümü',
        'madde' => 'Madde 14',
        'prof' => [100, 30, 150],
        'docent' => [60, 20, 150],
        'yeniden' => [30, 10],
        'drYayin' => 'Doktora tezinizin ulusal ya da uluslararası bir yayınevinde ISBN numarasıyla kitap olarak yayımlanması veya tezinizden üretilmiş bir makalenin ulusal ya da uluslararası hakemli bir dergide yayımlanmış olması',
        'baslicaEser' => 'Doçent unvanını aldıktan sonra yaptığınız çalışmalardan (tek ya da çift yazarlı kitap, kitap bölümü veya alan indekslerinde taranan dergide makale) en az birini başlıca araştırma eseri olarak sunmak',
    ],
    [
        'anahtar' => 'istanbul-konservatuvar-turk-muzigi',
        'ad' => 'Devlet Konservatuvarı Türk Müziği',
        'birim' => 'Devlet Konservatuvarı — Türk Müziği Bölümü',
        'madde' => 'Madde 15',
        'prof' => [30, 100, 70],
        'docent' => [20, 80, 40],
        'yeniden' => [10, 30],
        'drYayin' => 'Doktora ya da sanatta yeterlik tezinizin kitap olarak veya elektronik ortamda yayımlanması, ya da tezinizden üretilmiş 2 ulusal/uluslararası makalenizin yayımlanmış olması',
        'baslicaEser' => 'Doçent unvanını aldıktan sonra yaptığınız yapıt ya da etkinliklerden (yayımlanmış kitap, yayımlanmış albüm, gerçekleştirilmiş solo konser) en az birini başlıca araştırma eseri olarak sunmak; albümün en az 30 dakikalık ses, solo konserin en az 30 dakikalık video kaydı olmalı',
    ],
];

foreach ($konservatuvar as $k) {
    $madde = $k['madde'];
    $ortak = [
        'universite' => 'İstanbul Üniversitesi',
        'alan' => ['guzel_sanatlar'],
        'birim' => $k['birim'],
        'cetvel' => 'istanbul-2026-konservatuvar',
    ];
    [$pT1, $pT2, $pDocentSonrasi] = $k['prof'];
    [$dT1, $dT2, $dSonDort] = $k['docent'];
    [$yT1, $yT2] = $k['yeniden'];

    $esikler[] = $ortak + [
        'anahtar' => "{$k['anahtar']}-dr",
        'kadro' => 'dr_ogr_uyesi',
        'notlar' => "{$madde}. Dr. Öğr. Üyesi (İlk Atama) sütunu yalnız bir yayın koşulu "
            .'taşıyor; puan barajı yok. Yabancı dil 75.',
        'aday_notu' => 'Konservatuvarda ilk atamada puan barajı YOK: tek sayısal olmayan koşul '
            .'tezinizin yayımlanmış olması. '.$KONSERVATUVAR_NOTU,
        'sart' => Kalip::ve("Dr. Öğr. Üyeliğine ilk atanma — {$k['ad']}", [
            $dil(75),
            Kalip::beyan($k['drYayin'], "{$madde} — Yayın"),
        ]),
    ];

    $esikler[] = $ortak + [
        'anahtar' => "{$k['anahtar']}-dr-yeniden",
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'notlar' => "{$madde}. Yeniden atama: son üç yılda Tablo 1 ve 2'den toplam 60 puan "
            ."(görev süresi 3 yıl uzatılır); ayrıca Tablo 1'den {$yT1}, Tablo 2'den {$yT2}, "
            .'toplamda 200 puan.',
        'aday_notu' => 'Görev süresi uzatımı iki katmanlı: son üç yılda 60 puan üretmiş olmanız '
            .'ve kariyeriniz boyunca toplam 200 puana ulaşmış olmanız isteniyor. '.$KONSERVATUVAR_NOTU,
        'sart' => Kalip::ve("Dr. Öğr. Üyeliğine yeniden atanma — {$k['ad']}", [
            $dil(75),
            Kalip::toplam(60, donem: $SON_UC_YIL, liste: "{$madde} — son üç yıl"),
            Kalip::toplam($yT1, maddeler: ['TABLO-1'], liste: 'Tablo 1'),
            Kalip::toplam($yT2, maddeler: ['TABLO-2'], liste: 'Tablo 2'),
            Kalip::toplam(200),
        ]),
    ];

    $esikler[] = $ortak + [
        'anahtar' => "{$k['anahtar']}-docent",
        'kadro' => 'docentlik',
        'notlar' => "{$madde}. Doçent: Tablo 1'den {$dT1}, Tablo 2'den {$dT2}, ikisinden aldığı "
            ."puanların en az {$dSonDort}'ı son dört yılda, toplamda 300 puan. Yabancı dil 80.",
        'aday_notu' => "Doçentlikte 300 puanın en az {$dSonDort}'ı başvuru tarihinden geriye "
            .'dönük son dört yılda üretilmiş olmalı; ayrıca Tablo 1 ve Tablo 2 için ayrı ayrı '
            .'alt paylar var. '.$KONSERVATUVAR_NOTU,
        'sart' => Kalip::ve("Doçent kadrosuna atanma — {$k['ad']}", [
            $dil(80),
            Kalip::beyan('Doçent unvanını kazanmış olmak', 'Madde 8-ç'),
            Kalip::toplam($dT1, maddeler: ['TABLO-1'], liste: 'Tablo 1'),
            Kalip::toplam($dT2, maddeler: ['TABLO-2'], liste: 'Tablo 2'),
            Kalip::toplam($dSonDort, donem: $SON_DORT_YIL, liste: "{$madde} — son dört yıl"),
            Kalip::toplam(300),
        ]),
    ];

    $esikler[] = $ortak + [
        'anahtar' => "{$k['anahtar']}-profesor",
        'kadro' => 'profesorluk',
        'notlar' => "{$madde}. Profesör: başlıca araştırma eseri, en az 1 lisansüstü ya da "
            ."sanatta yeterlik tezi yönetmiş olmak, Tablo 1'den {$pT1}, Tablo 2'den {$pT2}, "
            ."ikisinden aldığı puanların en az {$pDocentSonrasi}'ı doçentlik sonrası, toplamda "
            .'500 puan. Yabancı dil 85.',
        'aday_notu' => "Profesörlükte 500 puanın en az {$pDocentSonrasi}'ı doçent unvanını "
            .'aldıktan sonraki döneme ait olmalı. Tez koşulu Madde 8-f\'ye bağlı; "son beş yılda '
            .'ilgili birimde tez yapılmadığı belgelenirse aranmaz" istisnası girilmedi. '
            .$KONSERVATUVAR_NOTU,
        'sart' => Kalip::ve("Profesör kadrosuna atanma — {$k['ad']}", [
            $dil(85),
            Kalip::beyan($k['baslicaEser'], "{$madde} — Başlıca araştırma eseri"),
            Kalip::adet('En az 1 lisansüstü ya da sanatta yeterlik tezi yönetmiş olmak', ['TEZ'], 1, madde: "{$madde} — Tez"),
            Kalip::toplam($pT1, maddeler: ['TABLO-1'], liste: 'Tablo 1'),
            Kalip::toplam($pT2, maddeler: ['TABLO-2'], liste: 'Tablo 2'),
            Kalip::toplam($pDocentSonrasi, donem: $DOCENTLIK, liste: "{$madde} — doçentlik sonrası"),
            Kalip::toplam(500),
        ]),
    ];
}

return $esikler;
