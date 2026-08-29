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
 * ZORUNLU PUAN KÜMESİ ALANA GÖRE DEĞİŞİYOR (Madde 1.10.1/c). Altı küme cetvelde
 * tanımlı: ZORUNLU-FEN (fen, mühendislik, tıp, sağlık), ZORUNLU-SOSYAL
 * (sosyal, eğitim, filoloji, ilahiyat, hukuk, spor), ZORUNLU-MIMARLIK,
 * ZORUNLU-GS-KURAMSAL, ZORUNLU-GS-UYGULAMALI, ZORUNLU-KONSERVATUVAR.
 * Küme değişiyor ama BARAJLAR DEĞİŞMİYOR: kadro puan çizelgelerinin altı
 * sütununda da aynı sayılar var (50/80, 120/200, 200/400).
 *
 * ── GÜZEL SANATLAR VE KONSERVATUVAR GİRİLDİ ──
 * Madde 2.11 (yedi alt alan) ve 2.12 (beş alt alan) uzun süre bekledi: koşullar
 * Puanlandırma Formunun D bölümüne dayanıyordu ve o bölümün kalemleri kaynak
 * sözlüğünde karşılıksızdı. Sözlüğe 19 etiket eklenip D bölümü tamamlanınca
 * on iki alanın üçü de girildi (36 yeni eşik).
 *
 * ON İKİ ALT ALANIN HEPSİ AYNI TEMEL ALANA (guzel_sanatlar) DÜŞÜYOR, ayrım
 * yalnızca `birim` ile kuruluyor. Program seçilmeden `bul()` null döner ve
 * üniversite o alanda kapsam dışı görünür — Bingöl ve Trabzon'daki davranışın
 * aynısı. Programı seçmeyen adaya on iki koşul kümesinden birini rastgele
 * göstermek, yanlış bir barajı "Doğrulandı" rozetiyle sunmak olurdu.
 *
 * "BİR KİTAP VEYA … BİR MAKALE VEYA … EN AZ İKİ MAKALE" ZİNCİRİ İKİ TÜRLÜ
 * OKUNUYOR. 2.11.1 ve 2.11.3'ün cümlesi hem "tek uluslararası makale yeter"
 * hem "en az iki makale gerekir" diye okunabiliyor; §0 uyarınca SIKI okuma
 * girildi (2.11.1'de iki makale + biri alan endeksli). 2.11.4-2.11.7'nin
 * cümlesi ise şıkları açıkça "veya" ile ayırdığı için `Kalip::veya` oldu.
 *
 * SAYIYA ÇEVRİLEMEYEN SANAT KOŞULLARI BEYAN OLARAK GİRİLDİ: konservatuvarın
 * "2 saatlik görüntülü kayıt", "45 dakikası konser kaydı", oyunculuğun "değişik
 * türlerde önemli roller" ve dans alanının "esas meslek derslerini üç yıl
 * vermiş olmak" koşulları. Kayıt ne süre ne de rol önemi tutuyor; DEÜ'nün puan
 * tablosunda da oyunculuk rolünün satırı yok.
 *
 * GİRİLMEYEN ALAN KOŞULLARI: 2.12.1 profesörlüğünün "2 numaralı koşullara uygun
 * iki saatlik kayıt" ek maddesi (doçentlik beyanı zaten tekrarlanıyor) ve
 * 2.12.5'in yalnız profesörlükte geçerli olan "1 numaralı koşulun DIŞINDA
 * doçentlik kriterlerini tekrarlamak" istisnası — motor tekrar kapanışından bir
 * düğüm çıkaramıyor, bütün koşullar tekrarlatıldı, koşul olduğundan ZOR görünür.
 *
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

    // ══════════ 2.11.1 GÖRÜNTÜ, CANLANDIRMA, PLASTİK VE GELENEKSEL TÜRK SANATLARI ══════════
    [
        'anahtar' => 'deu-gs-goruntu', 'ad' => 'Görüntü, Canlandırma, Plastik ve Geleneksel Türk Sanatları',
        'alanlar' => ['guzel_sanatlar'], 'birim' => 'Güzel Sanatlar — Görüntü, Canlandırma ve Plastik Sanatlar',
        'zorunlu' => 'ZORUNLU-GS-UYGULAMALI', 'madde' => 'Madde 2.11.1',
        'dr' => fn (string $m): array => [
            Kalip::adet('Hakemli dergilerde en az 2 araştırma veya derleme makale', ['HAKEMLI-MAKALE'], 2, madde: $m),
            Kalip::adet('Bunların en az 1\'i SCI, SCI-Expanded, SSCI, AHCI veya alan endeksli dergide olmalı', ['SCI-ALAN'], 1, madde: $m),
            Kalip::adet('En az 1\'inde tek yazar veya birinci isim olmalısınız', ['HAKEMLI-MAKALE'], 1, 'ilk', madde: $m),
            Kalip::adet('Özgün eserlerinizle en az 1 kişisel etkinlikte bulunmalısınız', ['KISISEL-ETKINLIK'], 1, madde: $m),
            Kalip::kIle('Ayrıca aşağıdakilerden en az 1\'i', 1, [
                Kalip::adet('En az 1 karma veya ortak etkinliğe katılmak', ['KARMA-ETKINLIK'], 1, madde: $m),
                Kalip::adet('Sempozyum, festival, workshop veya bienale eserinizle katılmak', ['SANAT-ETKINLIGI'], 1, madde: $m),
                Kalip::adet('Bilimsel veya sanatsal bir toplantıya bildiri ile katılmak', ['BILDIRI'], 1, madde: $m),
            ]),
        ],
        'docent' => fn (string $m, array $d, string $dad): array => [
            Kalip::adet("{$dad}, hakemli dergilerde en az 3 araştırma veya derleme makale", ['HAKEMLI-MAKALE'], 3, donem: $d, madde: $m),
            Kalip::adet('Bunların en az 2\'si SCI, SCI-Expanded, SSCI, AHCI veya alan endeksli dergide olmalı', ['SCI-ALAN'], 2, donem: $d, madde: $m),
            Kalip::adet('Özgün eserlerinizle en az 3 kişisel etkinlikte bulunmalısınız', ['KISISEL-ETKINLIK'], 3, donem: $d, madde: $m),
            Kalip::kIle('Ayrıca aşağıdakilerden en az 2\'si', 2, [
                Kalip::adet('En az 3 karma veya ortak etkinliğe katılmak', ['KARMA-ETKINLIK'], 3, donem: $d, madde: $m),
                Kalip::adet('Sempozyum, festival, workshop veya bienale eserinizle katılmak', ['SANAT-ETKINLIGI'], 1, donem: $d, madde: $m),
                Kalip::adet('Bilimsel veya sanatsal bir toplantıya bildiri ile katılmak', ['BILDIRI'], 1, donem: $d, madde: $m),
            ]),
        ],
        'telafiHedefi' => 0,
    ],

    // ══════════ 2.11.2 MÜZİKOLOJİ ══════════
    [
        'anahtar' => 'deu-gs-muzikoloji', 'ad' => 'Müzikoloji',
        'alanlar' => ['guzel_sanatlar'], 'birim' => 'Güzel Sanatlar — Müzikoloji',
        'zorunlu' => 'ZORUNLU-GS-KURAMSAL', 'madde' => 'Madde 2.11.2',
        'dr' => fn (string $m): array => [
            Kalip::veya('Alanınızla ilgili bir kitap ya da kitap bölümü, ya da en az 2 makale', [
                Kalip::adet('Alanınızla ilgili bir kitap veya kitap içi bölüm', ['KITAP-VEYA-BOLUM'], 1, madde: $m),
                Kalip::ve('Ya da en az 2 araştırma veya derleme makale', [
                    Kalip::adet('Hakemli dergilerde en az 2 makale', ['HAKEMLI-MAKALE'], 2, madde: $m),
                    Kalip::adet('En az 1\'i SCI, SCI-Expanded, SSCI, AHCI veya alan endeksli dergide olmalı', ['SCI-ALAN'], 1, madde: $m),
                ]),
            ]) + ['madde' => $m],
            Kalip::adet('Makalelerinizin en az 1\'inde tek yazar veya birinci isim olmalısınız', ['HAKEMLI-MAKALE'], 1, 'ilk', madde: $m),
            Kalip::adet('Bilimsel veya sanatsal en az 1 toplantıya bildiri ile katılmalısınız', ['BILDIRI'], 1, madde: $m),
        ],
        'docent' => fn (string $m, array $d, string $dad): array => [
            Kalip::adet("{$dad}, hakemli dergilerde en az 3 araştırma veya derleme makale", ['HAKEMLI-MAKALE'], 3, donem: $d, madde: $m),
            Kalip::adet('Bunların en az 1\'i SCI, SCI-Expanded, SSCI, AHCI veya alan endeksli dergide olmalı', ['SCI-ALAN'], 1, donem: $d, madde: $m),
            Kalip::adet('En az 1\'inde tek yazar veya birinci isim olmalısınız', ['HAKEMLI-MAKALE'], 1, 'ilk', $d, madde: $m),
            Kalip::adet('Bilimsel veya sanatsal en az 2 toplantıya bildiri ile katılmalısınız', ['BILDIRI'], 2, donem: $d, madde: $m),
        ],
        'telafiHedefi' => 0,
    ],

    // ══════════ 2.11.3 MÜZİK TEKNOLOJİLERİ ══════════
    [
        'anahtar' => 'deu-gs-muzik-teknoloji', 'ad' => 'Müzik Teknolojileri',
        'alanlar' => ['guzel_sanatlar'], 'birim' => 'Güzel Sanatlar — Müzik Teknolojileri',
        'zorunlu' => 'ZORUNLU-GS-UYGULAMALI', 'madde' => 'Madde 2.11.3',
        'dr' => fn (string $m): array => [
            Kalip::adet('Alanınızda en az 1 uygulamalı yapım gerçekleştirmelisiniz', ['MUZIK-TEKNOLOJISI'], 1, madde: $m),
            Kalip::beyan('Yapımın tarihsel gelişimi, geleneksel özellikleri ya da yenilikçi katkıları hakkında rapor sunmak', $m),
            Kalip::veya('Alanınızla ilgili bir kitap ya da kitap bölümü, ya da en az 1 makale', [
                Kalip::adet('Alanınızla ilgili bir kitap veya kitap içi bölüm', ['KITAP-VEYA-BOLUM'], 1, madde: $m),
                Kalip::adet('Ya da SCI, SCI-Expanded, SSCI, AHCI veya alan endeksli dergide en az 1 makale', ['SCI-ALAN'], 1, madde: $m),
            ]) + ['madde' => $m],
            Kalip::adet('Bilimsel veya sanatsal en az 1 toplantıya bildiri ile katılmalısınız', ['BILDIRI'], 1, madde: $m),
        ],
        'docent' => fn (string $m, array $d, string $dad): array => [
            Kalip::adet("{$dad}, alanınızda en az 2 uygulamalı yapım", ['MUZIK-TEKNOLOJISI'], 2, donem: $d, madde: $m),
            Kalip::adet('Hakemli dergilerde en az 3 araştırma veya derleme makale', ['HAKEMLI-MAKALE'], 3, donem: $d, madde: $m),
            Kalip::adet('Bunların en az 2\'si SCI, SCI-Expanded, SSCI, AHCI veya alan endeksli dergide olmalı', ['SCI-ALAN'], 2, donem: $d, madde: $m),
            Kalip::adet('Bilimsel veya sanatsal en az 2 toplantıya bildiri ile katılmalısınız', ['BILDIRI'], 2, donem: $d, madde: $m),
        ],
        'telafiHedefi' => 1,
    ],

    // ══════════ 2.11.4 TİYATRO KURAMI ══════════
    [
        'anahtar' => 'deu-gs-tiyatro-kuram', 'ad' => 'Tiyatro Kuramı',
        'alanlar' => ['guzel_sanatlar'], 'birim' => 'Güzel Sanatlar — Tiyatro Kuramı',
        'zorunlu' => 'ZORUNLU-GS-KURAMSAL', 'madde' => 'Madde 2.11.4',
        'dr' => fn (string $m): array => [
            Kalip::veya('Lisansüstü tezinizden üretilmemiş özgün bilimsel bir eser', [
                Kalip::adet('Bir kitap', ['KITAP'], 1, madde: $m),
                Kalip::adet('Ya da SCI, SCI-Expanded, SSCI, AHCI veya alan endeksli dergide en az 1 makale', ['SCI-ALAN'], 1, madde: $m),
                Kalip::adet('Ya da ULAKBİM listesindeki dergilerde en az 3 araştırma veya derleme makale', ['1.c'], 3, madde: $m),
            ]) + ['madde' => $m],
            Kalip::adet('Makalelerinizin en az 1\'inde tek yazar veya birinci isim olmalısınız', ['HAKEMLI-MAKALE'], 1, 'ilk', madde: $m),
            Kalip::kIle('Ayrıca aşağıdakilerden en az 1\'i', 1, [
                Kalip::adet('Bir oyun veya gösteri çalışmasında yorum, tasarım, araştırma ya da yazım görevi almak', ['TIYATRO-UYGULAMA'], 1, madde: $m),
                Kalip::adet('Bilimsel veya sanatsal bir toplantıya bildiri ile katılmak', ['BILDIRI'], 1, madde: $m),
            ]),
        ],
        'docent' => fn (string $m, array $d, string $dad): array => [
            Kalip::veya("{$dad}, lisansüstü tezinizden üretilmemiş özgün bilimsel bir eser", [
                Kalip::adet('Bir kitap', ['KITAP'], 1, donem: $d, madde: $m),
                Kalip::adet('Ya da SCI, SCI-Expanded, SSCI, AHCI veya alan endeksli dergide en az 1 makale', ['SCI-ALAN'], 1, donem: $d, madde: $m),
                Kalip::adet('Ya da ULAKBİM listesindeki dergilerde en az 3 araştırma veya derleme makale', ['1.c'], 3, donem: $d, madde: $m),
            ]) + ['madde' => $m],
            Kalip::adet('Bir oyun veya gösteri çalışmasında yorum, tasarım, araştırma ya da yazım görevi almalısınız', ['TIYATRO-UYGULAMA'], 1, donem: $d, madde: $m),
            Kalip::adet('Bilimsel veya sanatsal bir toplantıya bildiri ile katılmalısınız', ['BILDIRI'], 1, donem: $d, madde: $m),
        ],
    ],

    // ══════════ 2.11.5 OYUNCULUK – REJİ – UYGULAMA ══════════
    [
        'anahtar' => 'deu-gs-oyunculuk', 'ad' => 'Oyunculuk, Reji ve Uygulama',
        'alanlar' => ['guzel_sanatlar'], 'birim' => 'Güzel Sanatlar — Oyunculuk, Reji ve Uygulama',
        'zorunlu' => 'ZORUNLU-GS-UYGULAMALI', 'madde' => 'Madde 2.11.5',
        'dr' => fn (string $m): array => [
            Kalip::veya('Lisansüstü tezinizden üretilmemiş özgün bir eser', [
                Kalip::adet('Bir kitap', ['KITAP'], 1, madde: $m),
                Kalip::adet('Ya da SCI, SCI-Expanded, SSCI, AHCI veya alan endeksli dergide en az 1 makale', ['SCI-ALAN'], 1, madde: $m),
                Kalip::adet('Ya da ULAKBİM listesindeki dergilerde en az 3 araştırma veya derleme makale', ['1.c'], 3, madde: $m),
            ]) + ['madde' => $m],
            Kalip::adet('Makalelerinizin en az 1\'inde tek yazar veya birinci isim olmalısınız', ['HAKEMLI-MAKALE'], 1, 'ilk', madde: $m),
            Kalip::kIle('Ayrıca oyunculuk, reji ya da uygulama dallarından biri', 1, [
                Kalip::beyan('Oyunculuk dalı: değişik türlerde en az 2 önemli rolü oynamak ve görüntü kayıtlarıyla belgelemek', $m),
                Kalip::adet('Reji dalı: saygın tiyatrolarda en az 2 oyun sahnelemek', ['33.a.2'], 2, madde: $m),
                Kalip::adet('Uygulama dalı: izleyici karşısına çıkmış en az 4 uygulama çalışması', ['33.c.1'], 4, madde: $m),
            ]),
        ],
        'docent' => fn (string $m, array $d, string $dad): array => [
            Kalip::veya("{$dad}, lisansüstü tezinizden üretilmemiş özgün bir eser", [
                Kalip::adet('Bir kitap', ['KITAP'], 1, donem: $d, madde: $m),
                Kalip::adet('Ya da SCI, SCI-Expanded, SSCI, AHCI veya alan endeksli dergide en az 1 makale', ['SCI-ALAN'], 1, donem: $d, madde: $m),
                Kalip::adet('Ya da ULAKBİM listesindeki dergilerde en az 3 araştırma veya derleme makale', ['1.c'], 3, donem: $d, madde: $m),
            ]) + ['madde' => $m],
            Kalip::veya('Oyunculuk, reji ya da uygulama dallarından en az 5 çalışma', [
                Kalip::beyan('Oyunculuk dalı: değişik türlerde en az 5 önemli rolü oynamak', $m),
                Kalip::adet('Ya da reji ve uygulama çalışmalarınızdan en az 5 çalışma', ['TIYATRO-UYGULAMA'], 5, donem: $d, madde: $m),
            ]) + ['madde' => $m],
        ],
    ],

    // ══════════ 2.11.6 YORUM – DRAMATİK YAZARLIK ══════════
    [
        'anahtar' => 'deu-gs-dramatik-yazarlik', 'ad' => 'Yorum ve Dramatik Yazarlık',
        'alanlar' => ['guzel_sanatlar'], 'birim' => 'Güzel Sanatlar — Yorum ve Dramatik Yazarlık',
        'zorunlu' => 'ZORUNLU-GS-UYGULAMALI', 'madde' => 'Madde 2.11.6',
        'dr' => fn (string $m): array => [
            Kalip::veya('Lisansüstü tezinizden üretilmemiş özgün bir eser', [
                Kalip::adet('Bir kitap', ['KITAP'], 1, madde: $m),
                Kalip::adet('Ya da SCI, SCI-Expanded, SSCI, AHCI veya alan endeksli dergide en az 1 makale', ['SCI-ALAN'], 1, madde: $m),
                Kalip::adet('Ya da ULAKBİM listesindeki dergilerde en az 3 araştırma makalesi', ['1.c'], 3, madde: $m),
            ]) + ['madde' => $m],
            Kalip::adet('Makalelerinizin en az 1\'inde tek yazar veya birinci isim olmalısınız', ['HAKEMLI-MAKALE'], 1, 'ilk', madde: $m),
            Kalip::kIle('Ayrıca aşağıdakilerden en az 2\'si', 2, [
                Kalip::adet('Sahne, TV, radyo veya sinema için en az 2 dramatik metin yazmak', ['DRAMATIK-METIN'], 2, madde: $m),
                Kalip::adet('Bir oyun, film ya da gösteride yazarlık, metin yazarlığı veya dramaturg görevi', ['TIYATRO-UYGULAMA'], 1, madde: $m),
                Kalip::beyan('Oyun metni ve senaryo incelemeleri, eleştiri ve tanıtım yazıları yazmak', $m),
            ]),
        ],
        'docent' => fn (string $m, array $d, string $dad): array => [
            Kalip::veya("{$dad}, lisansüstü tezinizden üretilmemiş özgün bir eser", [
                Kalip::adet('Bir kitap', ['KITAP'], 1, donem: $d, madde: $m),
                Kalip::adet('Ya da SCI, SCI-Expanded, SSCI, AHCI veya alan endeksli dergide en az 1 makale', ['SCI-ALAN'], 1, donem: $d, madde: $m),
                Kalip::adet('Ya da ULAKBİM listesindeki dergilerde en az 3 araştırma makalesi', ['1.c'], 3, donem: $d, madde: $m),
            ]) + ['madde' => $m],
            Kalip::adet('Sahne, TV, radyo veya sinema için en az 2 dramatik metin yazmalısınız', ['DRAMATIK-METIN'], 2, donem: $d, madde: $m),
            Kalip::adet('Bir oyun, film ya da gösteride yazarlık, metin yazarlığı veya dramaturg görevi almalısınız', ['TIYATRO-UYGULAMA'], 1, donem: $d, madde: $m),
            Kalip::beyan('Oyun metni ve senaryo incelemeleri, eleştiri ve tanıtım yazıları yazmış olmak', $m),
        ],
    ],

    // ══════════ 2.11.7 SAHNE TASARIMI ══════════
    [
        'anahtar' => 'deu-gs-sahne-tasarimi', 'ad' => 'Sahne Tasarımı',
        'alanlar' => ['guzel_sanatlar'], 'birim' => 'Güzel Sanatlar — Sahne Tasarımı',
        'zorunlu' => 'ZORUNLU-GS-UYGULAMALI', 'madde' => 'Madde 2.11.7',
        'dr' => fn (string $m): array => [
            Kalip::veya('Lisansüstü tezinizden üretilmemiş özgün bir eser', [
                Kalip::adet('Bir kitap', ['KITAP'], 1, madde: $m),
                Kalip::adet('Ya da SCI, SCI-Expanded, SSCI, AHCI veya alan endeksli dergide en az 1 makale', ['SCI-ALAN'], 1, madde: $m),
                Kalip::adet('Ya da ULAKBİM listesindeki dergilerde en az 3 araştırma veya derleme makale', ['1.c'], 3, madde: $m),
            ]) + ['madde' => $m],
            Kalip::kIle('Ayrıca aşağıdakilerden en az 1\'i', 1, [
                Kalip::adet('Sahne, TV, sinema, kukla, makyaj ya da ışık alanında sahnelenmiş bir tasarım', ['SAHNE-TASARIMI'], 1, madde: $m),
                Kalip::adet('Özgün eserlerinizle en az 1 kişisel etkinlik', ['KISISEL-ETKINLIK'], 1, madde: $m),
                Kalip::adet('Özgün eserlerinizle en az 2 karma veya ortak etkinlik', ['KARMA-ETKINLIK'], 2, madde: $m),
            ]),
        ],
        'docent' => fn (string $m, array $d, string $dad): array => [
            Kalip::veya("{$dad}, lisansüstü tezinizden üretilmemiş özgün bir eser", [
                Kalip::adet('Bir kitap', ['KITAP'], 1, donem: $d, madde: $m),
                Kalip::adet('Ya da SCI, SCI-Expanded, SSCI, AHCI veya alan endeksli dergide en az 1 makale', ['SCI-ALAN'], 1, donem: $d, madde: $m),
                Kalip::adet('Ya da ULAKBİM listesindeki dergilerde en az 3 araştırma veya derleme makale', ['1.c'], 3, donem: $d, madde: $m),
            ]) + ['madde' => $m],
            Kalip::adet('Sahne, TV, sinema, kukla, makyaj ya da ışık alanında en az 2 sahnelenmiş tasarım', ['SAHNE-TASARIMI'], 2, donem: $d, madde: $m),
            Kalip::kIle('Ayrıca aşağıdakilerden en az 1\'i', 1, [
                Kalip::adet('Özgün eserlerinizle en az 1 kişisel etkinlik', ['KISISEL-ETKINLIK'], 1, donem: $d, madde: $m),
                Kalip::adet('Özgün eserlerinizle en az 2 karma veya ortak etkinlik', ['KARMA-ETKINLIK'], 2, donem: $d, madde: $m),
                Kalip::adet('Bilimsel veya sanatsal bir toplantıya bildiri ile katılmak', ['BILDIRI'], 1, donem: $d, madde: $m),
            ]),
        ],
    ],

    // ══════════ 2.12.1 KONSERVATUVAR — KOMPOZİSYON ══════════
    [
        'anahtar' => 'deu-kons-kompozisyon', 'ad' => 'Konservatuvar — Kompozisyon',
        'alanlar' => ['guzel_sanatlar'], 'birim' => 'Konservatuvar — Kompozisyon',
        'zorunlu' => 'ZORUNLU-KONSERVATUVAR', 'madde' => 'Madde 2.12.1',
        'dr' => fn (string $m): array => [
            Kalip::adet('En az 3 farklı yaratı formunda, toplam en az 4 özgün eser', ['KOMPOZISYON'], 4, madde: $m),
            Kalip::beyan('45 dakikalık bölümü konser kaydı olmak üzere 1 saatlik ses kaydı sunmak', $m),
            Kalip::adet('Hakemli dergilerde en az 1 araştırma veya derleme makale', ['HAKEMLI-MAKALE'], 1, madde: $m),
        ],
        'docent' => fn (string $m, array $d, string $dad): array => [
            Kalip::adet("{$dad}, en az 3 farklı yaratı formunda, toplam en az 10 özgün eser", ['KOMPOZISYON'], 10, donem: $d, madde: $m),
            Kalip::beyan('3 saatlik canlı, stüdyo veya MIDI kaydı ile eserlere ait yazılı materyali sunmak', $m),
            Kalip::adet('Hakemli dergilerde en az 1 araştırma veya derleme makale', ['HAKEMLI-MAKALE'], 1, donem: $d, madde: $m),
        ],
    ],

    // ══════════ 2.12.2 KONSERVATUVAR — YORUMCULUK ══════════
    [
        'anahtar' => 'deu-kons-yorumculuk', 'ad' => 'Konservatuvar — Yorumculuk',
        'alanlar' => ['guzel_sanatlar'], 'birim' => 'Konservatuvar — Yorumculuk',
        'zorunlu' => 'ZORUNLU-KONSERVATUVAR', 'madde' => 'Madde 2.12.2',
        'dr' => fn (string $m): array => [
            Kalip::beyan('Solo ve/veya orkestra eşlikli en az 2 saatlik görüntülü müzik kaydı sunmak '
                .'(en az 1 saati konser kaydı; şeflik dalında en az 3 saatlik senfonik müzik kaydı)', $m),
            Kalip::adet('Hakemli dergilerde en az 1 araştırma veya derleme makale', ['HAKEMLI-MAKALE'], 1, madde: $m),
        ],
        'docent' => fn (string $m, array $d, string $dad): array => [
            Kalip::beyan("{$dad}, solo ve/veya orkestra eşlikli en az 2 saatlik görüntülü müzik kaydı sunmak", $m),
            Kalip::adet('Hakemli dergilerde en az 1 araştırma veya derleme makale', ['HAKEMLI-MAKALE'], 1, donem: $d, madde: $m),
        ],
    ],

    // ══════════ 2.12.3 KONSERVATUVAR — OPERA ŞARKICILIĞI ══════════
    [
        'anahtar' => 'deu-kons-opera-sarki', 'ad' => 'Konservatuvar — Opera Şarkıcılığı',
        'alanlar' => ['guzel_sanatlar'], 'birim' => 'Konservatuvar — Opera Şarkıcılığı',
        'zorunlu' => 'ZORUNLU-KONSERVATUVAR', 'madde' => 'Madde 2.12.3',
        'dr' => fn (string $m): array => [
            Kalip::beyan('En az 2 saatlik konser kaydı sunmak (en az 1 saati görsel kayıt)', $m),
            Kalip::adet('Radyo, TV ya da seçkin kurumlarda en az 4 sahne etkinliği', ['39.*'], 4, madde: $m),
            Kalip::adet('Hakemli dergilerde en az 1 araştırma veya derleme makale', ['HAKEMLI-MAKALE'], 1, madde: $m),
        ],
        'docent' => fn (string $m, array $d, string $dad): array => [
            Kalip::beyan("{$dad}, en az 2 saatlik konser kaydı sunmak (en az 1 saati görsel kayıt)", $m),
            Kalip::adet('Radyo, TV ya da seçkin kurumlarda en az 4 sahne etkinliği', ['39.*'], 4, donem: $d, madde: $m),
            Kalip::adet('Hakemli dergilerde en az 1 araştırma veya derleme makale', ['HAKEMLI-MAKALE'], 1, donem: $d, madde: $m),
        ],
    ],

    // ══════════ 2.12.4 KONSERVATUVAR — OPERA REJİSÖRLÜĞÜ ══════════
    [
        'anahtar' => 'deu-kons-opera-reji', 'ad' => 'Konservatuvar — Opera Rejisörlüğü',
        'alanlar' => ['guzel_sanatlar'], 'birim' => 'Konservatuvar — Opera Rejisörlüğü',
        'zorunlu' => 'ZORUNLU-KONSERVATUVAR', 'madde' => 'Madde 2.12.4',
        'dr' => fn (string $m): array => [
            Kalip::beyan('En az 2 saatlik görsel ve/veya işitsel canlı ya da stüdyo kaydı sunmak', $m),
            Kalip::adet('En az 2 sahne eseri hazırlamış olmalısınız', ['OPERA-REJI'], 2, madde: $m),
            Kalip::adet('Hakemli dergilerde en az 1 araştırma veya derleme makale', ['HAKEMLI-MAKALE'], 1, madde: $m),
        ],
        'docent' => fn (string $m, array $d, string $dad): array => [
            Kalip::beyan("{$dad}, en az 2 saatlik görsel ve/veya işitsel canlı ya da stüdyo kaydı sunmak", $m),
            Kalip::adet('Radyo, TV ya da seçkin kurumlarda en az 4 sahne etkinliği', ['OPERA-REJI'], 4, donem: $d, madde: $m),
            Kalip::adet('Hakemli dergilerde en az 1 araştırma veya derleme makale', ['HAKEMLI-MAKALE'], 1, donem: $d, madde: $m),
        ],
    ],

    // ══════════ 2.12.5 KONSERVATUVAR — DANS VE KOREOGRAFİ ══════════
    [
        'anahtar' => 'deu-kons-dans', 'ad' => 'Konservatuvar — Dans ve Koreografi',
        'alanlar' => ['guzel_sanatlar'], 'birim' => 'Konservatuvar — Dans ve Koreografi',
        'zorunlu' => 'ZORUNLU-KONSERVATUVAR', 'madde' => 'Madde 2.12.5',
        'dr' => fn (string $m): array => [
            Kalip::adet('Solist olarak en az 1 eserde rol almış olmalısınız', ['DANS-SOLIST'], 1, madde: $m),
            Kalip::veya('Alanınızda ödül ya da sonuçlandırılmış tez danışmanlığı', [
                Kalip::adet('Yarışma, festival veya bienalden ödül almış olmak', ['18.b.1'], 1, madde: $m),
                Kalip::adet('Ya da yürütücüsü olduğunuz sonuçlandırılmış bir lisansüstü tez danışmanlığı', ['19.a', '19.d'], 1, madde: $m),
            ]) + ['madde' => $m],
            Kalip::adet('Koreografisini yaptığınız en az 1 eseri sahnelemiş olmalısınız', ['DANS-KOREOGRAFI'], 1, madde: $m),
            Kalip::adet('Hakemli dergilerde en az 1 araştırma veya derleme makale', ['HAKEMLI-MAKALE'], 1, madde: $m),
        ],
        'docent' => fn (string $m, array $d, string $dad): array => [
            Kalip::adet("{$dad}, solist olarak en az 2 eserde rol almak ya da 2 eserden bölüm sahnelemek", ['DANS-SOLIST'], 2, donem: $d, madde: $m),
            Kalip::veya('Alanınızda ödül ya da sonuçlandırılmış tez danışmanlığı', [
                Kalip::adet('Yarışma, festival veya bienalden ödül almış olmak', ['18.b.1'], 1, donem: $d, madde: $m),
                Kalip::adet('Ya da yürütücüsü olduğunuz sonuçlandırılmış bir lisansüstü tez danışmanlığı', ['19.a', '19.d'], 1, donem: $d, madde: $m),
            ]) + ['madde' => $m],
            Kalip::adet('Koreografisini yaptığınız en az 1 eseri sahnelemiş olmalısınız', ['DANS-KOREOGRAFI'], 1, donem: $d, madde: $m),
            Kalip::adet('Bale repertuarından en az 2 eser sahnelemiş olmalısınız', ['DANS-SAHNELEME'], 2, donem: $d, madde: $m),
            Kalip::adet('Hakemli dergilerde en az 1 araştırma veya derleme makale', ['HAKEMLI-MAKALE'], 1, donem: $d, madde: $m),
            Kalip::beyan('Konservatuvar lisans ya da hazırlık birimlerinde esas meslek derslerinden en az '
                .'ikisini üç yıl vermiş olmak', $m),
            Kalip::adet('Alanınızdaki yarışma, sempozyum, festival veya workshop etkinliklerine katılmış olmalısınız', ['SANAT-ETKINLIGI'], 1, donem: $d, madde: $m),
        ],
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
