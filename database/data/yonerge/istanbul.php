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
 * Madde 13-15 (Devlet Konservatuvarı'nın Müzik ve Sahne Sanatları, Müzikoloji
 * ve Türk Müziği bölümleri) GİRİLMEDİ: koşulları TABLO 2'ye (konservatuvara
 * özgü seksen satırlık müzik ve sahne tablosu) bağlı ve o tablo henüz
 * cetvele çevrilmedi. Bkz. GIRILEMEYEN-YONERGELER.md.
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

return $esikler;
