<?php

/**
 * DOKUZ EYLÜL ÜNİVERSİTESİ — Öğretim Üyeliği Kadrolarına Yükseltme ve Atama
 * İlkeleri ve Uygulama Esasları
 * Kaynak: pdf/17536992732.dokuzeyluluniverstesi.pdf
 *
 * KORPUSTA İKİ AYRI TOPLAM BARAJI OLAN İLK YÖNERGE (Madde 1.10.1/d). Her
 * kadroda hem "zorunlu puan maddeleri"nden hem tablonun tamamından ayrı bir
 * baraj isteniyor:
 *   Dr. Öğr. Üyesi   zorunludan 50   · genel toplam 80
 *   Doçent           zorunludan 120  · genel toplam 200
 *   Profesör         zorunludan 200  · genel toplam 400
 * Doçentlikte zorunlu puanın 50'si doktora sonrası, profesörlükte 70'i
 * doçentlik sonrası üretilmiş olmalı — bunlar da ayrı düğüm.
 *
 * ZORUNLU PUAN KÜMESİ ALANA GÖRE DEĞİŞİYOR (Madde 1.10.1/c). Üç küme cetvelde
 * tanımlı: ZORUNLU-FEN (fen, mühendislik, tıp, sağlık), ZORUNLU-SOSYAL
 * (sosyal, eğitim, filoloji, ilahiyat, hukuk, spor), ZORUNLU-MIMARLIK.
 *
 * ── GÜZEL SANATLAR VE KONSERVATUVAR GİRİLMEDİ ──
 * Madde 2.11 (yedi alt alan) ve 2.12 (beş alt alan) koşulları Puanlandırma
 * Formunun D bölümüne (24-41 arası, film, animasyon, müzik teknolojisi, TV,
 * reklam blokları) dayanıyor ve o bölümün kalemleri kaynak sözlüğünde
 * karşılıksız. Zorunlu puan kümesi de o maddeleri içeriyor; eksik kümeyle
 * baraj yazmak adaya sağlayamayacağı bir hedef gösterirdi.
 * Ziraat, orman ve su ürünleri alanları yönergede hiç anılmıyor.
 *
 * ── HEMŞİRELİK AYRI BİRİM ──
 * Madde 2.1 sağlık koşullarını verirken hemşirelik için ayrı ve DAHA DÜŞÜK
 * sayılar tanımlıyor (Dr. üç yerine iki SCI makale + bir alan endeksli
 * makale; doçentlikte yedi yerine beş SCI + üç hakemli). `birim` ile ayrıldı;
 * birim seçilmezse genel sağlık eşiği (yüksek sayılar) uygulanır.
 *
 * ── "B BÖLÜMÜNDEN 15 PUANLIK ETKİNLİK" TELAFİSİ ──
 * Alanların çoğu bir makale koşulunu "hakemli dergilerdeki BİR MAKALE yerine
 * Puanlandırma Formundaki B. Girişimcilik-Yenilikçilik bölümünden 15 puanlık
 * etkinlik gösterilebilir" diye esnetiyor.
 *
 * Telafi dalı BİLEŞİK kuruldu: bir eksik makale VE B bölümünden 15 puan.
 * Yalnızca 15 puanı aramak koşulu olduğundan kolay gösterirdi — yönerge
 * makalelerin tamamının değil, yalnızca BİRİNİN yerine geçmesine izin
 * veriyor. Telafi her alanda o alanın MAKALE SAYISI düğümüne bağlanıyor
 * (`telafiHedefi`), yazarlık ya da kitap koşuluna değil.
 *
 * Mühendisliğin ek yayın koşulunda yönerge "her bir yayına eşdeğer 15 puan"
 * diyor, yani iki yayının ikisi birden 30 puanla değiştirilebilir. Motor tek
 * kademe telafi tanıdığı için yalnızca "1 yayın + 15 puan" okuması girildi;
 * koşul bu alanda olduğundan ZOR görünür.
 *
 * ── PROFESÖRLÜK: KOŞULU BİR KEZ DAHA TEKRARLAMAK ──
 * Madde 1.14.3 profesörlüğü kendi sayıları yerine "doçent kadrosuna atamada
 * aranılan asgari YAYIN koşullarını doçentlik sonrası çalışmalarıyla bir kez
 * daha tekrarlamış olmak" diye tanımlıyor.
 *
 * `referans` düğümü BİLEREK KULLANILMADI. O düğüm hedef eşiğin TAMAMINI
 * çeker; doçentliğin puan barajları (zorunludan 120, toplam 200) da
 * profesörlüğe taşınır ve aday yönergede yazmayan bir baraj görürdü —
 * profesörlüğün kendi barajları zaten ayrı (200/400). Bunun yerine alanın
 * koşul kapanışı ikinci kez, doçentlik dönemiyle çağrıldı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   1.12.2 / 1.13.2  "yurt dışında en az 3 ay araştırma yapmış olmak VEYA
 *       asgari koşullara ilaveten bir makale" — yurt dışı süresi profilde
 *       tutuluyor ama "kendi Fakülte Yönetim Kurulu'nun onay verdiği kurum"
 *       niteliği kayıtta yok; beyan olarak girildi.
 *   2.4-2.7'nin "yabancı dilde eğitim yapan birimlere başvuruda makalelerden
 *       biri yabancı dilde olmalı" koşulu — yayın dili kayıtta yok.
 *   2.7 Filoloji'nin "makalelerden en az üçü kendi eğitim dilinde" koşulu.
 *   2.8 / 2.9'un "en fazla iki adedi armağanlarda yayımlanan makale olabilir"
 *       üst sınırı — motorda "en fazla" düğümü yok.
 *   2.10 Mimarlık doçentliğinin (d) dalı ("koşulları yerine getirmeyenlerden
 *       üçüncü bir yazılı eser istenir") — a, b, c dalları girildi.
 *   1.14.3'ün "2011 öncesi doçent unvanı alanlar ÜAK 2011 kriterlerini
 *       tekrarlar" istisnası ve 1.14.5'in aynı gruba tanıdığı muafiyet.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/dokuz-eylul-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;

/** Madde 1.12.1 / 1.13.1 / 1.14.2 — üç kadroda da YDS/YÖKDİL 65. */
$dil = Kalip::yds(65) + ['madde' => 'Madde 1.12.1'];

/** Madde 1.12.2 / 1.13.2 — Dr. ve doçentlikte aranan yurt dışı deneyimi. */
$yurtDisi = Kalip::beyan(
    'Lisans sonrası kendi bilim alanınızda yurt dışında toplam en az 3 ay araştırma yapmış '
    .'olmak (ya da asgari koşullara ilaveten bir makale yayımlamış olmak)',
    'Madde 1.12.2',
);

/**
 * "Hakemli dergilerdeki BİR MAKALE yerine Puanlandırma Formundaki B.
 * Girişimcilik-Yenilikçilik bölümünden 15 puanlık etkinlik gösterilebilir."
 *
 * Telafi tam bir alternatif dal: makale sayısı bir eksik OLACAK ve ayrıca B
 * bölümünden 15 puan gelecek. Yalnızca 15 puanı aramak, koşulu olduğundan
 * kolay gösterirdi — yönerge makalelerin tamamının değil, birinin yerine
 * geçmesine izin veriyor.
 *
 * @param  array<string, mixed>  $adetKosulu  Telafi edilecek makale sayısı düğümü
 * @return array<string, mixed>
 */
$bTelafisi = function (array $adetKosulu, string $madde): array {
    $eksik = max(1, ((int) $adetKosulu['min_adet']) - 1);

    return $adetKosulu + [
        'telafi' => Kalip::ve(
            "Ya da {$eksik} makale ve girişimcilik kalemlerinizden 15 puan",
            [
                array_replace($adetKosulu, [
                    'aciklama' => "En az {$eksik} makale",
                    'min_adet' => $eksik,
                    'telafi' => null,
                ]),
                Kalip::puanDan(
                    'Ve girişimcilik, yenilikçilik kalemlerinizden en az 15 puan',
                    ['B-GIRISIMCILIK'],
                    15,
                    madde: $madde,
                ),
            ],
        ),
    ];
};

/**
 * Kadro puan barajları (Madde 1.10.1/d). Her kadroda iki toplam: alanın
 * zorunlu puan kümesinden bir baraj, tablonun tamamından ayrı bir baraj.
 *
 * @return list<array<string, mixed>>
 */
$puanBarajlari = function (string $kadro, string $zorunluKume) use ($DOKTORA, $DOCENTLIK): array {
    return match ($kadro) {
        'dr_ogr_uyesi' => [
            Kalip::puanDan('Alanınızın zorunlu puan kalemlerinden en az 50 puan', [$zorunluKume], 50, madde: 'Madde 1.10.1/d'),
            Kalip::toplam(80),
        ],
        'docentlik' => [
            Kalip::puanDan('Alanınızın zorunlu puan kalemlerinden en az 120 puan', [$zorunluKume], 120, madde: 'Madde 1.10.1/d'),
            Kalip::puanDan('Bunun en az 50 puanı doktora sonrası çalışmalarınızdan olmalı', [$zorunluKume], 50, $DOKTORA, madde: 'Madde 1.10.1/d'),
            Kalip::toplam(200),
        ],
        default => [
            Kalip::puanDan('Alanınızın zorunlu puan kalemlerinden en az 200 puan', [$zorunluKume], 200, madde: 'Madde 1.10.1/d'),
            Kalip::puanDan('Bunun en az 70 puanı doçentlik sonrası çalışmalarınızdan olmalı', [$zorunluKume], 70, $DOCENTLIK, madde: 'Madde 1.10.1/d'),
            Kalip::toplam(400),
        ],
    };
};

/**
 * Alan blokları (Madde 2.1-2.10).
 *
 * drKosullar / docentKosullar  o alanın kendi yayın koşulları
 */
$alanlar = [
    // ══════════ 2.1 TIP VE SAĞLIK ══════════
    [
        'anahtar' => 'deu-saglik', 'ad' => 'Tıp ve Sağlık', 'alanlar' => ['saglik'],
        'birim' => null, 'zorunlu' => 'ZORUNLU-FEN', 'madde' => 'Madde 2.1',
        'dr' => fn (string $m): array => [
            Kalip::adet('SCI, SCI-Expanded veya SSCI dergilerinde en az 3 araştırma makalesi', ['SCI'], 3, madde: $m),
            Kalip::adet('Bunların en az 1\'inde tek yazar veya birinci isim olmalısınız', ['SCI'], 1, 'ilk', madde: $m),
            Kalip::adet('En az 1\'i lisansüstü tezinizden üretilmemiş olmalı', ['1.a'], 1, madde: $m),
        ],
        'docent' => fn (string $m, array $d, string $dad): array => [
            Kalip::adet("{$dad}, SCI, SCI-Expanded, SSCI veya AHCI dergilerinde en az 7 araştırma makalesi", ['SCI'], 7, donem: $d, madde: $m),
            Kalip::adet('Bunların en az 2\'sinde başlıca yazar olmalı ve tezinizden üretilmemiş olmalı', ['1.a'], 2, 'baslica', $d, madde: $m),
        ],
    ],
    [
        'anahtar' => 'deu-hemsirelik', 'ad' => 'Hemşirelik', 'alanlar' => ['saglik'],
        'birim' => 'Hemşirelik', 'zorunlu' => 'ZORUNLU-FEN', 'madde' => 'Madde 2.1',
        'dr' => fn (string $m): array => [
            Kalip::adet('SCI, SCI-Expanded veya SSCI dergilerinde en az 2 araştırma makalesi', ['SCI'], 2, madde: $m),
            Kalip::adet('Bunların en az 1\'inde tek yazar veya birinci isim olmalısınız', ['SCI'], 1, 'ilk', madde: $m),
            Kalip::adet('Ayrıca alan endeksli veya ULAKBİM dergilerinde en az 1 araştırma makalesi', ['SCI-ALAN'], 1, madde: $m),
        ],
        'docent' => fn (string $m, array $d, string $dad): array => [
            Kalip::adet("{$dad}, SCI, SCI-Expanded veya SSCI dergilerinde en az 5 araştırma makalesi", ['SCI'], 5, donem: $d, madde: $m),
            Kalip::adet('Bunların en az 2\'si tezinizden üretilmemiş, en az 1\'inde başlıca yazar olmalısınız', ['1.a'], 1, 'baslica', $d, madde: $m),
            Kalip::adet('Ayrıca hakemli dergilerde en az 3 makale', ['HAKEMLI-MAKALE'], 3, donem: $d, madde: $m),
        ],
        'telafiHedefi' => 2,
    ],
    // ══════════ 2.2 MÜHENDİSLİK ══════════
    [
        'anahtar' => 'deu-muhendislik', 'ad' => 'Mühendislik', 'alanlar' => ['muhendislik'],
        'birim' => null, 'zorunlu' => 'ZORUNLU-FEN', 'madde' => 'Madde 2.2',
        'dr' => fn (string $m): array => [
            Kalip::adet('SCI, SCI-Expanded veya SSCI dergilerinde en az 3 araştırma makalesi', ['SCI'], 3, madde: $m),
            Kalip::adet('Bunların en az 1\'inde tek yazar veya birinci isim olmalısınız', ['SCI'], 1, 'ilk', madde: $m),
            Kalip::adet('En az 1\'i lisansüstü tezinizden üretilmemiş olmalı', ['1.a'], 1, madde: $m),
        ],
        'docent' => fn (string $m, array $d, string $dad): array => [
            Kalip::adet("{$dad}, SCI, SCI-Expanded veya SSCI dergilerinde en az 5 araştırma makalesi", ['SCI'], 5, donem: $d, madde: $m),
            Kalip::adet('Bunların en az 2\'si tezinizden üretilmemiş, en az 1\'inde başlıca yazar olmalısınız', ['1.a'], 1, 'baslica', $d, madde: $m),
        ],
        'docentTelafili' => fn (string $m, array $d, string $dad): array => Kalip::adet(
            'Ayrıca hakemli dergilerde makale, kitap bölümü veya kitap olarak en az 2 yayın',
            ['MAKALE-KITAP-BOLUM'], 2, donem: $d, madde: $m,
        ),
    ],
    // ══════════ 2.3.1 FİZİK, KİMYA, BİYOLOJİ ══════════
    [
        'anahtar' => 'deu-fen', 'ad' => 'Fen Bilimleri', 'alanlar' => ['fen'],
        'birim' => null, 'zorunlu' => 'ZORUNLU-FEN', 'madde' => 'Madde 2.3.1',
        'dr' => fn (string $m): array => [
            Kalip::adet('SCI, SCI-Expanded veya SSCI dergilerinde en az 3 araştırma makalesi', ['SCI'], 3, madde: $m),
            Kalip::adet('Bunların en az 1\'inde başlıca yazar veya birinci isim olmalısınız', ['SCI'], 1, 'ilk', madde: $m),
            Kalip::adet('En az 1\'i lisansüstü tezinizden üretilmemiş olmalı', ['1.a'], 1, madde: $m),
        ],
        'docent' => fn (string $m, array $d, string $dad): array => [
            Kalip::adet("{$dad}, SCI, SCI-Expanded veya SSCI dergilerinde en az 8 araştırma makalesi", ['SCI'], 8, donem: $d, madde: $m),
            Kalip::adet('Bunların en az 4\'ü tezinizden üretilmemiş olmalı', ['1.a'], 4, donem: $d, madde: $m),
            Kalip::adet('En az 2\'sinde başlıca yazar veya birinci isim olmalısınız', ['SCI'], 2, 'ilk', $d, madde: $m),
        ],
    ],
    // ══════════ 2.3.2 MATEMATİK, İSTATİSTİK ══════════
    [
        'anahtar' => 'deu-matematik', 'ad' => 'Matematik ve İstatistik', 'alanlar' => ['fen'],
        'birim' => 'Matematik ve İstatistik', 'zorunlu' => 'ZORUNLU-FEN', 'madde' => 'Madde 2.3.2',
        'dr' => fn (string $m): array => [
            Kalip::adet('Hakemli dergilerde en az 2 araştırma makalesi', ['HAKEMLI-MAKALE'], 2, madde: $m),
            Kalip::adet('Bunların en az 1\'i SCI, SCI-Expanded veya SSCI dergilerinde olmalı', ['SCI'], 1, madde: $m),
            Kalip::adet('En az 1\'inde başlıca yazar veya birinci isim olmalısınız', ['HAKEMLI-MAKALE'], 1, 'ilk', madde: $m),
            Kalip::adet('En az 1\'i lisansüstü tezinizden üretilmemiş olmalı', ['1.a', '1.b', '1.c', '1.d', '1.e'], 1, madde: $m),
        ],
        'docent' => fn (string $m, array $d, string $dad): array => [
            Kalip::adet("{$dad}, hakemli dergilerde en az 4 araştırma makalesi", ['HAKEMLI-MAKALE'], 4, donem: $d, madde: $m),
            Kalip::adet('Bunların en az 2\'si SCI, SCI-Expanded veya SSCI dergilerinde olmalı', ['SCI'], 2, donem: $d, madde: $m),
            Kalip::adet('En az 1\'inde başlıca yazar veya birinci isim olmalısınız', ['HAKEMLI-MAKALE'], 1, 'ilk', $d, madde: $m),
        ],
        'telafiHedefi' => 0,
    ],
    // ══════════ 2.4 SOSYAL, BEŞERİ VE İDARİ BİLİMLER ══════════
    [
        'anahtar' => 'deu-sosyal', 'ad' => 'Sosyal, Beşeri ve İdari Bilimler', 'alanlar' => ['sosyal'],
        'birim' => null, 'zorunlu' => 'ZORUNLU-SOSYAL', 'madde' => 'Madde 2.4',
        'dr' => fn (string $m): array => [
            Kalip::adet('Hakemli dergilerde en az 2 araştırma makalesi', ['HAKEMLI-MAKALE'], 2, madde: $m),
            Kalip::adet('Bunların en az 1\'i SCI, SCI-Expanded, SSCI, AHCI veya alan endeksli dergide olmalı', ['SCI-ALAN'], 1, madde: $m),
            Kalip::adet('En az 1\'inde tek yazar veya birinci isim olmalısınız', ['HAKEMLI-MAKALE'], 1, 'ilk', madde: $m),
        ],
        'docent' => fn (string $m, array $d, string $dad): array => [
            Kalip::adet("{$dad}, hakemli dergilerde en az 5 araştırma makalesi", ['HAKEMLI-MAKALE'], 5, donem: $d, madde: $m),
            Kalip::adet('Bunların en az 2\'si SCI, SCI-Expanded, SSCI veya alan endeksli dergide olmalı', ['SCI-ALAN'], 2, donem: $d, madde: $m),
            Kalip::adet('En az 1\'inde tek yazar veya birinci isim olmalısınız', ['HAKEMLI-MAKALE'], 1, 'ilk', $d, madde: $m),
        ],
        'telafiHedefi' => 0,
    ],
    // ══════════ 2.5 EĞİTİM BİLİMLERİ ══════════
    [
        'anahtar' => 'deu-egitim', 'ad' => 'Eğitim Bilimleri', 'alanlar' => ['egitim'],
        'birim' => null, 'zorunlu' => 'ZORUNLU-SOSYAL', 'madde' => 'Madde 2.5',
        'dr' => fn (string $m): array => [
            Kalip::adet('Hakemli dergilerde en az 2 araştırma makalesi', ['HAKEMLI-MAKALE'], 2, madde: $m),
            Kalip::adet('Bunların en az 1\'i SCI, SCI-Expanded, SSCI, AHCI veya alan endeksli dergide olmalı', ['SCI-ALAN'], 1, madde: $m),
            Kalip::adet('En az 1\'inde tek yazar veya birinci isim olmalısınız', ['HAKEMLI-MAKALE'], 1, 'ilk', madde: $m),
        ],
        'docent' => fn (string $m, array $d, string $dad): array => [
            Kalip::adet("{$dad}, hakemli dergilerde en az 5 araştırma makalesi", ['HAKEMLI-MAKALE'], 5, donem: $d, madde: $m),
            Kalip::adet('Bunların en az 2\'si SCI, SCI-Expanded, SSCI veya alan endeksli dergide olmalı', ['SCI-ALAN'], 2, donem: $d, madde: $m),
            Kalip::adet('En az 1\'inde tek yazar veya birinci isim olmalısınız', ['HAKEMLI-MAKALE'], 1, 'ilk', $d, madde: $m),
        ],
        'telafiHedefi' => 0,
    ],
    // ══════════ 2.6 SPOR BİLİMLERİ ══════════
    [
        'anahtar' => 'deu-spor', 'ad' => 'Spor Bilimleri', 'alanlar' => ['spor'],
        'birim' => null, 'zorunlu' => 'ZORUNLU-SOSYAL', 'madde' => 'Madde 2.6',
        'dr' => fn (string $m): array => [
            Kalip::adet('Hakemli dergilerde en az 2 araştırma makalesi', ['HAKEMLI-MAKALE'], 2, madde: $m),
            Kalip::adet('Bunların en az 1\'i SSCI, SCI-Expanded, AHCI veya alan endeksli dergide olmalı', ['SCI-ALAN'], 1, madde: $m),
            Kalip::adet('En az 1\'inde tek yazar veya birinci isim olmalısınız', ['HAKEMLI-MAKALE'], 1, 'ilk', madde: $m),
        ],
        'docent' => fn (string $m, array $d, string $dad): array => [
            Kalip::adet("{$dad}, hakemli dergilerde en az 3 araştırma makalesi", ['HAKEMLI-MAKALE'], 3, donem: $d, madde: $m),
            Kalip::adet('Bunların en az 2\'si SSCI, SCI-Expanded veya alan endeksli dergide olmalı', ['SCI-ALAN'], 2, donem: $d, madde: $m),
            Kalip::adet('En az 1\'inde başlıca yazar olmalısınız', ['HAKEMLI-MAKALE'], 1, 'baslica', $d, madde: $m),
        ],
        'telafiHedefi' => 0,
    ],
    // ══════════ 2.7 FİLOLOJİ ══════════
    [
        'anahtar' => 'deu-filoloji', 'ad' => 'Filoloji', 'alanlar' => ['filoloji'],
        'birim' => null, 'zorunlu' => 'ZORUNLU-SOSYAL', 'madde' => 'Madde 2.7',
        'dr' => fn (string $m): array => [
            Kalip::adet('Hakemli dergilerde en az 2 özgün makale', ['HAKEMLI-MAKALE'], 2, madde: $m),
            Kalip::adet('Bunların en az 1\'i SCI, SCI-Expanded, SSCI, AHCI veya alan endeksli dergide olmalı', ['SCI-ALAN'], 1, madde: $m),
            Kalip::adet('En az 1\'inde tek yazar veya birinci isim olmalısınız', ['HAKEMLI-MAKALE'], 1, 'ilk', madde: $m),
        ],
        'docent' => fn (string $m, array $d, string $dad): array => [
            Kalip::adet('Hakemli dergilerde en az 5 özgün makale', ['HAKEMLI-MAKALE'], 5, donem: $d, madde: $m),
            Kalip::adet('Bunların en az 2\'si SSCI, AHCI veya alan endeksli dergide olmalı', ['SCI-ALAN'], 2, donem: $d, madde: $m),
            Kalip::adet('Ayrıca özgün bir bilimsel kitap yayımlamış olmalısınız', ['KITAP'], 1, donem: $d, madde: $m),
        ],
        'telafiHedefi' => 0,
    ],
    // ══════════ 2.8 İLAHİYAT ══════════
    [
        'anahtar' => 'deu-ilahiyat', 'ad' => 'İlahiyat', 'alanlar' => ['ilahiyat'],
        'birim' => null, 'zorunlu' => 'ZORUNLU-SOSYAL', 'madde' => 'Madde 2.8',
        'dr' => fn (string $m): array => [
            Kalip::veya('En az 2 tek yazarlı makale, kitap bölümü ya da özgün bir bilimsel kitap', [
                Kalip::adet('Uluslararası veya ULAKBİM dergilerinde en az 2 tek yazarlı özgün makale', ['SCI-ALAN', '1.c'], 2, 'tek', madde: $m),
                Kalip::adet('Ya da en az 2 kitap bölümü', ['5.b', '5.d'], 2, madde: $m),
                Kalip::adet('Ya da lisansüstü tezinizden üretilmemiş özgün bir bilimsel kitap', ['KITAP'], 1, madde: $m),
            ]) + ['madde' => $m],
        ],
        'docent' => fn (string $m, array $d, string $dad): array => [
            Kalip::adet("{$dad}, lisansüstü tezinizden üretilmemiş özgün bir bilimsel kitap", ['KITAP'], 1, donem: $d, madde: $m),
            Kalip::adet('Uluslararası veya ULAKBİM dergilerinde en az 5 özgün makale', ['SCI-ALAN', '1.c'], 5, donem: $d, madde: $m),
        ],
        'telafiHedefi' => 1,
    ],
    // ══════════ 2.9 HUKUK ══════════
    [
        'anahtar' => 'deu-hukuk', 'ad' => 'Hukuk', 'alanlar' => ['hukuk'],
        'birim' => null, 'zorunlu' => 'ZORUNLU-SOSYAL', 'madde' => 'Madde 2.9',
        'dr' => fn (string $m): array => [
            Kalip::veya('En az 2 tek yazarlı makale, kitap bölümü ya da özgün bir bilimsel kitap', [
                Kalip::adet('Uluslararası veya ULAKBİM dergilerinde en az 2 tek yazarlı özgün makale', ['SCI-ALAN', '1.c'], 2, 'tek', madde: $m),
                Kalip::adet('Ya da en az 2 kitap bölümü', ['5.b', '5.d'], 2, madde: $m),
                Kalip::adet('Ya da lisansüstü tezinizden üretilmemiş özgün bir bilimsel kitap', ['KITAP'], 1, madde: $m),
            ]) + ['madde' => $m],
        ],
        'docent' => fn (string $m, array $d, string $dad): array => [
            Kalip::adet("{$dad}, lisansüstü tezinizden üretilmemiş özgün bir bilimsel kitap", ['KITAP'], 1, donem: $d, madde: $m),
            Kalip::adet('Uluslararası veya ULAKBİM dergilerinde en az 5 özgün makale', ['SCI-ALAN', '1.c'], 5, donem: $d, madde: $m),
        ],
        'telafiHedefi' => 1,
    ],
    // ══════════ 2.10 MİMARLIK ══════════
    [
        'anahtar' => 'deu-mimarlik', 'ad' => 'Mimarlık', 'alanlar' => ['mimarlik'],
        'birim' => null, 'zorunlu' => 'ZORUNLU-MIMARLIK', 'madde' => 'Madde 2.10',
        'dr' => fn (string $m): array => [
            Kalip::adet('SCI, SCI-Expanded, SSCI, AHCI veya alan endeksli dergilerde en az 2 araştırma makalesi', ['SCI-ALAN'], 2, madde: $m),
            Kalip::adet('Bunların en az 1\'inde tek yazar veya birinci isim olmalısınız', ['SCI-ALAN'], 1, 'ilk', madde: $m),
            Kalip::adet('En az 1\'i lisansüstü tezinizden üretilmemiş olmalı', ['1.a', '1.b'], 1, madde: $m),
        ],
        'docent' => fn (string $m, array $d, string $dad): array => [
            Kalip::adet('SCI, SCI-Expanded, SSCI, AHCI veya alan endeksli dergilerde en az 2 özgün makale', ['SCI-ALAN'], 2, donem: $d, madde: $m),
            Kalip::adet('Bunların en az 1\'inde birinci isim olmalısınız', ['SCI-ALAN'], 1, 'ilk', $d, madde: $m),
            Kalip::adet('En az 1\'i lisansüstü tezinizden üretilmemiş olmalı', ['1.a', '1.b'], 1, donem: $d, madde: $m),
            Kalip::veya('Yarışma ödülü, uygulama projesi ya da yazılım/patent koşullarından en az biri', [
                Kalip::adet('Planlama, mimarlık veya tasarım yarışmasında derece ya da mansiyon', ['MIMARLIK-EK'], 1, donem: $d, madde: $m),
                Kalip::adet('Ya da ürettiğiniz bir uygulama projesi hakkında yazılmış makale, kitap bölümü veya kitap', ['MAKALE-KITAP-BOLUM'], 3, donem: $d, madde: $m),
            ]) + ['madde' => $m],
        ],
        'telafiHedefi' => 0,
    ],
];

$esikler = [];

foreach ($alanlar as $a) {
    $madde = $a['madde'];
    $ortak = [
        'universite' => 'Dokuz Eylül Üniversitesi',
        'alan' => $a['alanlar'],
        'birim' => $a['birim'],
        'cetvel' => 'dokuz-eylul-2024',
    ];

    // ══════════════ DR. ÖĞRETİM ÜYESİ ══════════════
    $esikler[] = $ortak + [
        'anahtar' => "{$a['anahtar']}-dr",
        'kadro' => 'dr_ogr_uyesi',
        'aday_notu' => 'Yönerge iki ayrı puan barajı istiyor: alanınızın zorunlu puan '
            .'kalemlerinden 50, tablonun tamamından 80. Zorunlu kalemler alana göre değişiyor; '
            .'sizin alanınızda makale, kitap ve girişimcilik kalemleri sayılıyor.',
        'notlar' => "{$madde} + Madde 1.12 + Madde 1.10.1/d. Zorunlu puan 50, genel toplam 80, "
            .'yabancı dil 65.',
        'sart' => Kalip::ve("Dr. Öğr. Üyeliğine atanma — {$a['ad']}", [
            $dil,
            $yurtDisi,
            ...$a['dr']($madde),
            ...$puanBarajlari('dr_ogr_uyesi', $a['zorunlu']),
        ]),
    ];

    // ══════════════ DOÇENT ══════════════
    $docentKosullar = $a['docent']($madde, $DOKTORA, 'Doktora sonrası');

    // "Bir makale yerine B bölümünden 15 puanlık etkinlik gösterilebilir."
    // Telafi, alanın MAKALE SAYISI düğümüne bağlanır (`telafiHedefi`).
    $hedef = $a['telafiHedefi'] ?? null;

    if ($hedef !== null && isset($docentKosullar[$hedef])) {
        $docentKosullar[$hedef] = $bTelafisi($docentKosullar[$hedef], $madde);
    }

    if (isset($a['docentTelafili'])) {
        $docentKosullar[] = $bTelafisi($a['docentTelafili']($madde, $DOKTORA, 'Doktora sonrası'), $madde);
    }

    $esikler[] = $ortak + [
        'anahtar' => "{$a['anahtar']}-docent",
        'kadro' => 'docentlik',
        'aday_notu' => 'Doçentlikte zorunlu puan barajı 120 ve bunun en az 50\'si doktora '
            .'sonrası üretilmiş olmalı; genel toplam barajı 200. Bazı makale koşulları '
            .'girişimcilik ve yenilikçilik kalemlerinden 15 puanla telafi edilebiliyor.',
        'notlar' => "{$madde} + Madde 1.13 + Madde 1.10.1/d. Zorunlu puan 120 (50'si doktora "
            .'sonrası), genel toplam 200, yabancı dil 65.',
        'sart' => Kalip::ve("Doçent kadrosuna atanma — {$a['ad']}", [
            Kalip::beyan('Doçent unvanını almış olmak', 'Madde 1.13'),
            $dil,
            $yurtDisi,
            ...$docentKosullar,
            ...$puanBarajlari('docentlik', $a['zorunlu']),
        ]),
    ];

    // ══════════════ PROFESÖR ══════════════
    // Madde 1.14.3: doçentliğin asgari YAYIN koşullarını doçentlik sonrası
    // çalışmalarla bir kez daha tekrarlamak.
    //
    // `referans` düğümü KULLANILMADI: hedef eşiğin tamamını çekiyor, yani
    // doçentliğin puan barajlarını (120/200) da profesörlüğe taşırdı. Yönerge
    // yalnızca yayın koşullarını tekrarlatıyor; profesörlüğün kendi puan
    // barajları ayrı (200/400). Bunun yerine aynı koşul kapanışı doçentlik
    // dönemiyle ikinci kez çağrıldı.
    $profesorKosullar = $a['docent']($madde, $DOCENTLIK, 'Doçentlik sonrası');

    if ($hedef !== null && isset($profesorKosullar[$hedef])) {
        $profesorKosullar[$hedef] = $bTelafisi($profesorKosullar[$hedef], $madde);
    }

    if (isset($a['docentTelafili'])) {
        $profesorKosullar[] = $bTelafisi($a['docentTelafili']($madde, $DOCENTLIK, 'Doçentlik sonrası'), $madde);
    }

    $esikler[] = $ortak + [
        'anahtar' => "{$a['anahtar']}-profesor",
        'kadro' => 'profesorluk',
        'aday_notu' => 'Profesörlüğün kendi yayın sayıları yok: doçent kadrosunun bütün yayın '
            .'koşullarını doçentlik unvanınızdan SONRAKİ çalışmalarınızla bir kez daha '
            .'sağlamanız isteniyor (Madde 1.14.3). Puan barajları ayrı: 200 zorunlu '
            .'(70\'i doçentlik sonrası) ve 400 genel toplam.',
        'notlar' => "{$madde} + Madde 1.14 + Madde 1.10.1/d. Madde 1.14.3 doçentliğin yayın "
            .'koşullarını doçentlik sonrası dönemde tekrarlatıyor. Zorunlu puan 200 '
            .'(70\'i doçentlik sonrası), genel toplam 400.',
        'sart' => Kalip::ve("Profesör kadrosuna atanma — {$a['ad']}", [
            Kalip::beyan('Doçentlik unvanını aldığınız tarihten en az 5 yıl geçmiş olmalı', 'Madde 1.14.1'),
            $dil,
            Kalip::beyan(
                'Doçentlik sonrası ürettiğiniz özgün bir makale, bilimsel kitap ya da sanat '
                .'eserini Başlıca Araştırma Eseri olarak göstermek',
                'Madde 1.14.6',
            ),
            ...$profesorKosullar,
            ...$puanBarajlari('profesorluk', $a['zorunlu']),
        ]),
    ];
}

return $esikler;
