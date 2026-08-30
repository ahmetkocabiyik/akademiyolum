<?php

/**
 * İNÖNÜ ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Yönergesi (2026)
 * Kaynak: pdf/178160788251.inonu-kriter-15042026.pdf
 * Yürürlük: Madde 20 — YÖK onayı üzerine 1/6/2026
 *
 * ON BİR ALAN SÜTUNU, DÖRT KADRO TABLOSU. Yönerge alanları Madde 4(a)'da
 * fakülte fakülte tanımlıyor; eşlemeler oradan:
 *   Tıp ve Diş Hekimliği          → sağlık (birim ayrımı ile)
 *   Sağlık bilimleri              → sağlık bilimleri, hemşirelik, eczacılık
 *                                   fakülteleri ve sağlık hizmetleri MYO
 *   Fen Bilimleri ve Matematik    → fen-edebiyat fakültesinin fen ve
 *                                   matematik alanları
 *   Mühendislik · Spor · Eğitim   → doğrudan
 *   Mimarlık, Planlama, Tasarım   → güzel sanatlar ve tasarım fakültesinin
 *                                   peyzaj mimarlığı bölümü
 *   Sosyal, Beşerî ve İdari       → İİBF, iletişim, fen-edebiyatın sosyal
 *                                   alanları, İLAHİYAT FAKÜLTESİ ve gastronomi
 *   Hukuk · Filoloji              → doğrudan
 *   Güzel sanatlar                → eğitim fakültesi güzel sanatlar eğitimi,
 *                                   devlet konservatuvarı, plastik sanatlar,
 *                                   müzikoloji, müzik teknolojisi
 *
 * İLAHİYAT SOSYAL SÜTUNUNDA: yönerge ilahiyat fakültesini "sosyal, beşerî ve
 * idari bilimler" alanının içinde sayıyor, bu yüzden ilahiyat temel alanı da
 * o eşiğe bağlandı. Kendi başına bir sütunu yok.
 *
 * SAĞLIK İKİYE AYRILDI: "Tıp ve Diş Hekimliği" ile "Sağlık bilimleri" ayrı
 * sütunlar ve farklı barajlar taşıyor (Dr. toplam 500'e karşı 700, profesör
 * 2500'e karşı 3000). İkisi de `saglik` temel alanına düştüğü için `birim`
 * alanıyla ayrıldı; aday birimini seçmeden doğru eşik bulunamaz.
 *
 * ZİRAAT KAPSAM DIŞI: Madde 4(a) on bir alanı tek tek sayıyor, ziraat, orman
 * ve su ürünleri bunların arasında yok.
 *
 * ── "L1-L18 PUANI" KOŞULU HİÇ YAZILMADI ──
 * Tablo 3, 4 ve 5'in üçünde de bir "L1-L18 Puanı" satırı var (30-90 puan).
 * L bölümü girişimcilik, teknopark, teknoloji transfer ofisi ve iş dünyası
 * iş birliği faaliyetleri; on sekiz satırın yalnızca biri kaynak sözlüğünde
 * karşılık buluyor. Yarısı eksik bir baraj, adaya asla sağlayamayacağı bir
 * hedef gösterirdi. Koşul aday notunda anlatılıyor.
 *
 * ── HESAPLANAMAYAN ÖLÇÜTLER (beyan olarak girildi) ──
 *   FWCI/CNCI indeksi — profil bu değeri tutmuyor.
 *   "Uluslararası iş birliğiyle yayımlanmış özgün makale" ve
 *   "üniversite-üniversite iş birliğiyle yapılan makale" — faaliyet kaydı
 *   yayının iş birliğiyle üretilip üretilmediğini tutmuyor.
 * Üçü de doçent ve profesörlükteki "ek olarak aşağıdaki şartlardan biri
 * sağlanmalıdır" bloğunun alternatifleri; blok `veya` olduğu için beyan dalı
 * sonucu belirsiz yapar, kesin ret vermez.
 *
 * ── "%50'SİNDE BAŞLICA YAZAR" ──
 * Sayı koşullarının çoğu iki parçalı: toplam adet + bunların yarısında
 * başlıca yazarlık. İki ayrı `adet` düğümüyle kuruldu; yarım sayılar YUKARI
 * yuvarlandı (6 makalenin %50'si 3, 2 makalenin %50'si 1).
 * Madde 4(b) başlıca yazarı birinci isim olarak tanımlıyor.
 *
 * DÖNEMLER: Dr. ilk atama ve doçentlikte yönerge dönem belirtmiyor, kısıt
 * yazılmadı. Yeniden atamada "son atandığı dönem içerisinde" (Madde 14/2),
 * profesörlükte "doçentlik ünvanını aldıktan sonra" (Madde 16/2).
 *
 * MADDE 17 (asgari koşulların aranmayacağı haller) girilmedi: Tıp, Diş
 * Hekimliği ve Hukuk fakültelerinde şartları sağlayan aday çıkmazsa Yönetim
 * Kurulu kararıyla asgari koşullar aranmadan atama yapılabiliyor. Bu bir
 * muafiyet yolu, adayın sağlayabileceği bir koşul değil.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/inonu-2026.php
 */

use App\Services\Scoring\Sart\Kalip;

$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;

/** Madde 6 — YDS/YÖKDİL 65; yabancı dille öğretim yapan birimlerde 85. */
$dil = [
    'tip' => 'metrik',
    'aciklama' => 'Yabancı dil sınavı (YDS/YÖKDİL) asgari puanı',
    'madde' => 'Madde 6',
    'metrik' => 'yds',
    'kademeler' => [
        'turkce' => 65,
        'yabanci_dil_30' => 85,
        'yabanci_dil_100' => 85,
        'yabanci_dil_egitimi' => 65,
    ],
];

$lNotu = 'Yönerge bu kadroda ayrıca girişimcilik, teknopark ve teknoloji transfer '
    .'faaliyetlerinden (L1-L18) puan istiyor. O bölümün kalemleri sisteme girilemediği için '
    .'baraj burada gösterilmiyor; gerçek başvuruda aranacak.';

/**
 * "Ek olarak aşağıdaki şartlardan biri sağlanmalıdır" bloğu.
 *
 * @param  array<string, mixed>|null  $donem
 * @return array<string, mixed>
 */
$ekSart = function (int $hIndeks, int $yurtdisiAy, int $isbirlikliMakale,
    int $ekScie, int $ekEsci, string $madde, ?array $donem): array {
    $dallar = [
        Kalip::metrik("WoS ya da Scopus h-indeksiniz en az {$hIndeks} olmalı", 'h_indeksi', $hIndeks),
        Kalip::beyan('Ya da Scopus alan ağırlıklı atıf etkisi (FWCI/CNCI) değeriniz en az 1 olmalı', $madde),
        Kalip::adet('Ya da dış kaynaklı bir projede yürütücülük yapmış olmalısınız', ['K1-K10-YURUTUCU'], 1, donem: $donem, madde: $madde),
        Kalip::adet('Ya da en az 1 patentiniz olmalı', ['M1-M5'], 1, donem: $donem, madde: $madde),
        Kalip::metrik("Ya da en az {$yurtdisiAy} ay yurt dışı araştırma deneyiminiz olmalı", 'yurtdisi_ay', $yurtdisiAy),
        Kalip::beyan("Ya da uluslararası iş birliğiyle yayımlanmış en az {$isbirlikliMakale} özgün makaleniz olmalı", $madde),
    ];

    if ($ekScie > 0) {
        $dallar[] = Kalip::beyan(
            "Ya da üniversite-üniversite iş birliğiyle yayımlanmış en az {$ekScie} SCI-E, SSCI veya AHCI makaleniz "
            ."ve {$ekEsci} ESCI, Scopus veya SPORTDiscus makaleniz olmalı",
            $madde,
        );
    }

    return Kalip::veya('Ek koşullardan en az biri sağlanmalı', $dallar) + ['madde' => $madde];
};

/**
 * Alan sütunları. Sayılar Tablo 2-5'ten birebir; 0 = o sütunda satır boş.
 *
 * dr    [Q1-Q3, SCI-E, ESCI, TR Dizin, A puanı, toplam]
 * dry   [Q1-Q3, SCI-E, ESCI, TR Dizin, K1-K14 puanı, toplam]
 * doc   [Q1-Q3, SCI-E/kitap, ESCI, TR Dizin, K1-K12, A puanı, toplam,
 *        h-indeks, ek SCI-E, ek ESCI, uluslararası iş birlikli makale]
 * prof  [başlıca Q1-Q3, başlıca SCI-E/kitap, başlıca ESCI, Q1-Q3, SCI-E,
 *        ESCI, TR Dizin, K1-K12, K1-K14, A puanı, toplam, h-indeks,
 *        üniversite iş birlikli SCI-E, ek ESCI, uluslararası iş birlikli]
 */
$sutunlar = [
    ['anahtar' => 'inonu-tip', 'ad' => 'Tıp ve Diş Hekimliği', 'alanlar' => ['saglik'],
        'birim' => 'Tıp ve Diş Hekimliği Fakülteleri',
        'dr' => [0, 2, 1, 1, 250, 500],
        'dry' => [3, 0, 0, 1, 40, 600],
        'doc' => [6, 0, 0, 4, 50, 600, 2000, 7, 0, 0, 3],
        'prof' => [1, 0, 0, 4, 0, 2, 1, 0, 50, 600, 2500, 10, 0, 0, 3]],
    ['anahtar' => 'inonu-saglik', 'ad' => 'Sağlık Bilimleri', 'alanlar' => ['saglik'],
        'birim' => 'Sağlık Bilimleri, Hemşirelik ve Eczacılık Fakülteleri',
        'dr' => [1, 1, 2, 2, 350, 700],
        'dry' => [3, 0, 0, 1, 40, 800],
        'doc' => [6, 0, 0, 4, 50, 800, 2500, 7, 0, 0, 3],
        'prof' => [1, 0, 0, 4, 0, 2, 1, 50, 0, 800, 3000, 10, 0, 0, 3]],
    ['anahtar' => 'inonu-fen', 'ad' => 'Fen Bilimleri ve Matematik', 'alanlar' => ['fen'],
        'birim' => null,
        'dr' => [4, 0, 3, 2, 500, 1000],
        'dry' => [3, 0, 0, 1, 50, 1200],
        'doc' => [6, 0, 0, 4, 60, 1000, 2500, 7, 0, 0, 5],
        'prof' => [1, 0, 0, 6, 0, 2, 1, 60, 0, 1000, 3000, 10, 0, 0, 5]],
    ['anahtar' => 'inonu-muhendislik', 'ad' => 'Mühendislik', 'alanlar' => ['muhendislik'],
        'birim' => null,
        'dr' => [3, 0, 2, 2, 400, 800],
        'dry' => [3, 0, 0, 1, 40, 1000],
        'doc' => [6, 0, 0, 4, 50, 800, 2500, 7, 0, 0, 4],
        'prof' => [1, 0, 0, 6, 0, 2, 1, 50, 0, 800, 3000, 10, 0, 0, 4]],
    ['anahtar' => 'inonu-spor', 'ad' => 'Spor Bilimleri', 'alanlar' => ['spor'],
        'birim' => null,
        'dr' => [1, 0, 3, 2, 350, 700],
        'dry' => [1, 0, 0, 2, 40, 900],
        'doc' => [4, 0, 2, 4, 50, 700, 2000, 6, 0, 0, 3],
        'prof' => [1, 0, 0, 4, 0, 2, 2, 0, 50, 700, 2500, 8, 0, 0, 3]],
    ['anahtar' => 'inonu-egitim', 'ad' => 'Eğitim Bilimleri', 'alanlar' => ['egitim'],
        'birim' => null,
        'dr' => [0, 1, 3, 5, 300, 600],
        'dry' => [0, 1, 0, 3, 40, 800],
        'doc' => [2, 0, 4, 4, 50, 600, 2000, 3, 1, 3, 2],
        'prof' => [1, 0, 0, 2, 0, 2, 4, 0, 50, 600, 2000, 4, 1, 3, 2]],
    ['anahtar' => 'inonu-mimarlik', 'ad' => 'Mimarlık, Planlama ve Tasarım', 'alanlar' => ['mimarlik'],
        'birim' => null,
        'dr' => [0, 1, 3, 5, 300, 600],
        'dry' => [0, 1, 0, 3, 40, 800],
        'doc' => [2, 0, 2, 4, 50, 600, 2000, 3, 1, 2, 2],
        'prof' => [1, 0, 0, 2, 0, 1, 3, 0, 50, 600, 2000, 4, 1, 2, 2]],
    ['anahtar' => 'inonu-sosyal', 'ad' => 'Sosyal, Beşerî ve İdari Bilimler', 'alanlar' => ['sosyal', 'ilahiyat'],
        'birim' => null,
        'dr' => [0, 1, 2, 5, 300, 600],
        'dry' => [0, 1, 0, 3, 40, 700],
        'doc' => [0, 1, 2, 6, 50, 500, 2000, 3, 1, 2, 2],
        'prof' => [0, 1, 0, 0, 1, 2, 4, 0, 50, 500, 2000, 4, 1, 2, 2]],
    ['anahtar' => 'inonu-hukuk', 'ad' => 'Hukuk', 'alanlar' => ['hukuk'],
        'birim' => null,
        'dr' => [0, 0, 1, 4, 200, 400],
        'dry' => [0, 0, 1, 4, 30, 500],
        'doc' => [0, 0, 0, 8, 40, 400, 1500, 3, 1, 2, 1],
        'prof' => [0, 1, 0, 0, 0, 3, 4, 0, 40, 400, 1500, 4, 1, 2, 1]],
    ['anahtar' => 'inonu-filoloji', 'ad' => 'Filoloji', 'alanlar' => ['filoloji'],
        'birim' => null,
        'dr' => [0, 1, 3, 5, 300, 600],
        'dry' => [0, 1, 0, 3, 40, 700],
        'doc' => [0, 0, 2, 8, 50, 600, 2000, 3, 1, 2, 1],
        'prof' => [0, 1, 0, 0, 1, 3, 4, 0, 50, 600, 2000, 4, 1, 2, 1]],
    ['anahtar' => 'inonu-guzel-sanatlar', 'ad' => 'Güzel Sanatlar', 'alanlar' => ['guzel_sanatlar'],
        'birim' => null,
        'dr' => [0, 0, 3, 5, 300, 600],
        'dry' => [0, 0, 1, 3, 40, 800],
        'doc' => [0, 0, 4, 6, 50, 500, 2000, 3, 1, 2, 1],
        'prof' => [0, 0, 1, 0, 0, 3, 6, 0, 50, 500, 2000, 4, 1, 2, 1]],
];

/** "%50'sinde başlıca yazar" — yarım sayı yukarı yuvarlanır. */
$yari = fn (int $n): int => (int) ceil($n / 2);

$esikler = [];

foreach ($sutunlar as $s) {
    $ortak = [
        'universite' => 'İnönü Üniversitesi',
        'alan' => $s['alanlar'],
        'birim' => $s['birim'],
        'cetvel' => 'inonu-2026',
    ];

    // ══════════════ Tablo 2 — DR. ÖĞRETİM ÜYESİ (ilk atama) ══════════════
    [$q1q3, $scie, $esci, $tr, $aPuan, $toplam] = $s['dr'];
    $kosullar = [$dil, Kalip::toplam($toplam)];

    if ($q1q3 > 0) {
        $kosullar[] = Kalip::adet("SCI-E, SSCI veya AHCI kapsamındaki Q1-Q3 dergilerde en az {$q1q3} özgün makale", ['Q1-Q3'], $q1q3, madde: 'Tablo 2');
    }
    if ($scie > 0) {
        $kosullar[] = Kalip::adet("SCI-E, SSCI veya AHCI kapsamındaki dergilerde en az {$scie} özgün makale", ['SCI-E'], $scie, madde: 'Tablo 2');
    }
    if ($esci > 0) {
        $kosullar[] = Kalip::adet("ESCI, Scopus veya SPORTDiscus kapsamındaki dergilerde en az {$esci} özgün makale", ['ESCI'], $esci, madde: 'Tablo 2');
    }
    $kosullar[] = Kalip::adet("TR Dizin kapsamındaki dergilerde en az {$tr} özgün makale", ['TR-DIZIN'], $tr, madde: 'Tablo 2');
    $kosullar[] = Kalip::puanDan("Makalelerinizden en az {$aPuan} puan", ['A'], $aPuan, madde: 'Tablo 2');

    $esikler[] = $ortak + [
        'anahtar' => "{$s['anahtar']}-dr",
        'kadro' => 'dr_ogr_uyesi',
        'aday_notu' => "{$s['ad']} sütununda ilk atanma barajı {$toplam} puan; bunun {$aPuan} puanı "
            .'makalelerden gelmeli. Yayın sayısı ayrıca dergi kademesine göre aranıyor.',
        'notlar' => "Madde 13 + Tablo 2, {$s['ad']} sütunu. Toplam {$toplam} puan, A puanı {$aPuan}.",
        'sart' => Kalip::ve("Dr. Öğr. Üyeliğine ilk atanma — {$s['ad']}", $kosullar),
    ];

    // ══════════════ Tablo 3 — DR. ÖĞRETİM ÜYESİ (yeniden atama) ══════════════
    [$q1q3, $scie, $esci, $tr, $projeK14, $toplam] = $s['dry'];
    $kosullar = [Kalip::toplam($toplam, $SON_ATAMA)];

    if ($q1q3 > 0) {
        $kosullar[] = Kalip::adet("SCI-E, SSCI veya AHCI kapsamındaki Q1-Q3 dergilerde en az {$q1q3} özgün makale", ['Q1-Q3'], $q1q3, donem: $SON_ATAMA, madde: 'Tablo 3');
        $kosullar[] = Kalip::adet('Bunların en az 1\'inde başlıca yazar olmalısınız', ['Q1-Q3'], 1, 'baslica', $SON_ATAMA, madde: 'Tablo 3');
    }
    if ($scie > 0) {
        $kosullar[] = Kalip::adet("SCI-E, SSCI veya AHCI kapsamındaki dergilerde başlıca yazar olduğunuz en az {$scie} özgün makale", ['SCI-E'], $scie, 'baslica', $SON_ATAMA, madde: 'Tablo 3');
    }
    if ($esci > 0) {
        $kosullar[] = Kalip::adet("ESCI, Scopus veya SPORTDiscus kapsamındaki dergilerde başlıca yazar olduğunuz en az {$esci} özgün makale", ['ESCI'], $esci, 'baslica', $SON_ATAMA, madde: 'Tablo 3');
    }
    $kosullar[] = Kalip::adet("TR Dizin kapsamındaki dergilerde en az {$tr} özgün makale", ['TR-DIZIN'], $tr, donem: $SON_ATAMA, madde: 'Tablo 3');
    $kosullar[] = Kalip::puanDan("Proje kalemlerinizden en az {$projeK14} puan", ['K1-K14'], $projeK14, $SON_ATAMA, madde: 'Tablo 3');

    $esikler[] = $ortak + [
        'anahtar' => "{$s['anahtar']}-dr-yeniden",
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'aday_notu' => 'Yeniden atanmada yalnızca son atandığınız dönemde ürettiğiniz çalışmalar '
            .'sayılıyor; atama dört yıllık. '.$lNotu,
        'notlar' => "Madde 14 + Tablo 3, {$s['ad']} sütunu. Toplam {$toplam} puan (son atama sonrası), "
            ."K1-K14 proje puanı {$projeK14}. L1-L18 satırı girilemedi.",
        'sart' => Kalip::ve("Dr. Öğr. Üyeliğine yeniden atanma — {$s['ad']}", $kosullar),
    ];

    // ══════════════ Tablo 4 — DOÇENT ══════════════
    [$q1q3, $scieKitap, $esci, $tr, $projeK12, $aPuan, $toplam, $h, $ekScie, $ekEsci, $ulusIsb] = $s['doc'];
    $kosullar = [$dil, Kalip::toplam($toplam)];

    if ($q1q3 > 0) {
        $kosullar[] = Kalip::adet("SCI-E, SSCI veya AHCI kapsamındaki Q1-Q3 dergilerde en az {$q1q3} özgün makale", ['Q1-Q3'], $q1q3, madde: 'Tablo 4');
        $kosullar[] = Kalip::veya(
            'Bu makalelerin yarısında başlıca yazarlık ya da üniversite-üniversite iş birliği',
            [
                Kalip::adet("Bunların en az {$yari($q1q3)}'inde başlıca yazar olmalısınız", ['Q1-Q3'], $yari($q1q3), 'baslica', madde: 'Tablo 4'),
                Kalip::beyan('Ya da bu makaleler üniversite-üniversite iş birliğiyle yapılmış olmalı', 'Tablo 4'),
            ],
        ) + ['madde' => 'Tablo 4'];
    }
    if ($scieKitap > 0) {
        $kosullar[] = Kalip::veya("Başlıca yazar olduğunuz {$scieKitap} SCI-E, SSCI veya AHCI makalesi ya da tek yazarlı 1 kitap", [
            Kalip::adet("SCI-E, SSCI veya AHCI kapsamındaki dergilerde başlıca yazar olduğunuz en az {$scieKitap} özgün makale", ['SCI-E'], $scieKitap, 'baslica', madde: 'Tablo 4'),
            Kalip::adet('Ya da uluslararası indeksli yayınevinde tek yazarlı en az 1 kitap', ['BKCI-KITAP'], 1, 'tek', madde: 'Tablo 4'),
        ]) + ['madde' => 'Tablo 4'];
    }
    if ($esci > 0) {
        $kosullar[] = Kalip::adet("ESCI, Scopus veya SPORTDiscus kapsamındaki dergilerde en az {$esci} özgün makale", ['ESCI'], $esci, madde: 'Tablo 4');
        $kosullar[] = Kalip::adet("Bunların en az {$yari($esci)}'inde başlıca yazar olmalısınız", ['ESCI'], $yari($esci), 'baslica', madde: 'Tablo 4');
    }
    $kosullar[] = Kalip::adet("TR Dizin kapsamındaki dergilerde en az {$tr} özgün makale", ['TR-DIZIN'], $tr, madde: 'Tablo 4');
    $kosullar[] = Kalip::adet("Bunların en az {$yari($tr)}'inde başlıca yazar olmalısınız", ['TR-DIZIN'], $yari($tr), 'baslica', madde: 'Tablo 4');
    $kosullar[] = Kalip::puanDan("Proje kalemlerinizden en az {$projeK12} puan", ['K1-K12'], $projeK12, madde: 'Tablo 4');
    $kosullar[] = Kalip::puanDan("Makalelerinizden en az {$aPuan} puan", ['A'], $aPuan, madde: 'Tablo 4');
    $kosullar[] = $ekSart($h, 3, $ulusIsb, $ekScie, $ekEsci, 'Tablo 4', null);

    $esikler[] = $ortak + [
        'anahtar' => "{$s['anahtar']}-docent",
        'kadro' => 'docentlik',
        'aday_notu' => "{$s['ad']} sütununda doçentlik barajı {$toplam} puan. Zorunlu şartların "
            .'üstüne bir de "ek koşullardan biri" bloğu var: h-indeksi, FWCI, dış kaynaklı proje '
            .'yürütücülüğü, patent, yurt dışı deneyim ya da iş birlikli yayın. '.$lNotu,
        'notlar' => "Madde 15 + Tablo 4, {$s['ad']} sütunu. Toplam {$toplam}, A puanı {$aPuan}, "
            ."K1-K12 proje puanı {$projeK12}, h-indeksi {$h}. L1-L18 satırı girilemedi.",
        'sart' => Kalip::ve("Doçent kadrosuna atanma — {$s['ad']}", $kosullar),
    ];

    // ══════════════ Tablo 5 — PROFESÖR ══════════════
    [$baQ1Q3, $baScieKitap, $baEsci, $q1q3, $scie, $esci, $tr,
        $projeK12, $projeK14, $aPuan, $toplam, $h, $uniIsb, $ekEsci, $ulusIsb] = $s['prof'];

    $kosullar = [
        Kalip::beyan('Doçentlik unvanını aldıktan sonra en az beş yıl, başvurduğunuz bilim alanında çalışmış olmak', 'Madde 16/1'),
        $dil,
        Kalip::toplam($toplam, $DOCENTLIK),
    ];

    if ($baQ1Q3 > 0) {
        $kosullar[] = Kalip::adet('Başlıca araştırma eseri: Q1-Q3 dergide başlıca yazar olduğunuz en az 1 özgün makale', ['Q1-Q3'], $baQ1Q3, 'baslica', $DOCENTLIK, madde: 'Tablo 5');
    }
    if ($baScieKitap > 0) {
        $kosullar[] = Kalip::veya('Başlıca araştırma eseri: SCI-E, SSCI veya AHCI makalesi ya da tek yazarlı kitap', [
            Kalip::adet('SCI-E, SSCI veya AHCI dergide başlıca yazar olduğunuz en az 1 özgün makale', ['SCI-E'], 1, 'baslica', $DOCENTLIK, madde: 'Tablo 5'),
            Kalip::adet('Ya da uluslararası indeksli yayınevinde tek yazarlı en az 1 kitap', ['BKCI-KITAP'], 1, 'tek', $DOCENTLIK, madde: 'Tablo 5'),
        ]) + ['madde' => 'Tablo 5'];
    }
    if ($baEsci > 0) {
        $kosullar[] = Kalip::adet('Başlıca araştırma eseri: ESCI veya Scopus dergide başlıca yazar olduğunuz en az 1 özgün makale', ['ESCI'], $baEsci, 'baslica', $DOCENTLIK, madde: 'Tablo 5');
    }
    if ($q1q3 > 0) {
        $kosullar[] = Kalip::adet("SCI-E, SSCI veya AHCI kapsamındaki Q1-Q3 dergilerde en az {$q1q3} özgün makale", ['Q1-Q3'], $q1q3, donem: $DOCENTLIK, madde: 'Tablo 5');
        $kosullar[] = Kalip::adet("Bunların en az {$yari($q1q3)}'inde başlıca yazar olmalısınız", ['Q1-Q3'], $yari($q1q3), 'baslica', $DOCENTLIK, madde: 'Tablo 5');
    }
    if ($scie > 0) {
        $kosullar[] = Kalip::adet("SCI-E, SSCI veya AHCI kapsamındaki dergilerde başlıca yazar olduğunuz en az {$scie} özgün makale", ['SCI-E'], $scie, 'baslica', $DOCENTLIK, madde: 'Tablo 5');
    }
    $kosullar[] = Kalip::adet("ESCI, Scopus veya SPORTDiscus kapsamındaki dergilerde en az {$esci} özgün makale", ['ESCI'], $esci, donem: $DOCENTLIK, madde: 'Tablo 5');
    $kosullar[] = Kalip::adet("TR Dizin kapsamındaki dergilerde en az {$tr} özgün makale", ['TR-DIZIN'], $tr, donem: $DOCENTLIK, madde: 'Tablo 5');

    $projePuan = $projeK12 > 0 ? $projeK12 : $projeK14;
    $projeKume = $projeK12 > 0 ? 'K1-K12' : 'K1-K14';
    $kosullar[] = Kalip::puanDan("Proje kalemlerinizden en az {$projePuan} puan", [$projeKume], $projePuan, $DOCENTLIK, madde: 'Tablo 5');
    $kosullar[] = Kalip::puanDan("Makalelerinizden en az {$aPuan} puan", ['A'], $aPuan, $DOCENTLIK, madde: 'Tablo 5');
    $kosullar[] = $ekSart($h, 6, $ulusIsb, $uniIsb, $ekEsci, 'Tablo 5', $DOCENTLIK);

    $esikler[] = $ortak + [
        'anahtar' => "{$s['anahtar']}-profesor",
        'kadro' => 'profesorluk',
        'aday_notu' => 'Bütün çalışmalarınızın doçentlik unvanından SONRA üretilmiş olması gerekiyor '
            .'. Ayrıca bir "başlıca araştırma eseri" şartı var: belirli bir dergi '
            .'kademesinde başlıca yazar olduğunuz bir yayın. '.$lNotu,
        'notlar' => "Madde 16 + Tablo 5, {$s['ad']} sütunu. Toplam {$toplam} (doçentlik sonrası), "
            ."A puanı {$aPuan}, proje puanı {$projePuan} ({$projeKume}), h-indeksi {$h}. "
            .'L1-L18 satırı girilemedi.',
        'sart' => Kalip::ve("Profesör kadrosuna atanma — {$s['ad']}", $kosullar),
    ];
}

return $esikler;
