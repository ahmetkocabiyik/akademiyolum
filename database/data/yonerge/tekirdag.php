<?php

/**
 * TEKİRDAĞ NAMIK KEMAL ÜNİVERSİTESİ — Öğretim Üyeliği Kadrolarına Başvuru İçin
 * Gerekli Koşullar ve Uygulama Esasları Yönergesi (2024)
 * Kaynak: pdf/17537009192.tekirdagnamikkemaluniverstesi.pdf (19 sayfa)
 *
 * İKİ SÜTUNLU BARAJ: "PUAN-1" ve "PUAN-2". EK-1 her kadro için toplamı ikiye
 * bölüyor — PUAN-1 yalnız MAKALE bölümünden (EK-2'nin (1).1-6. maddeleri),
 * PUAN-2 cetvelin tamamından:
 *
 *   Dr. Öğr. Üyesi (ilk atama)  toplam  80 = PUAN-1  30 + PUAN-2  50
 *   Doçent                      toplam 325 = PUAN-1  25 + PUAN-2 300
 *   Profesör                    toplam 550 = PUAN-1  50 + PUAN-2 500
 *
 * EK-1'in (a) dipnotu "hesaplamada PUAN-1 esastır; buradaki fazlalık PUAN-2'ye
 * aktarılır ancak PUAN-2'deki fazlalık PUAN-1'e aktarılmaz" diyor. Bu, iki
 * sütunu ŞU İKİ KOŞULA indirger: cetvelin tamamından toplam (30+50=80 gibi) ve
 * makale kalemlerinden PUAN-1 kadar. İkisi de böyle yazıldı.
 *
 * DİPNOT (b) BİR TELAFİ DALI: "Birinci isim, sorumlu yazar veya senyör yazar
 * olunan bir (1) adet Q1, Q2, Q3 yayın ile PUAN-1 tamamen karşılanmış olur."
 * Dr. Öğr. Üyeliğinde ve doçentlikte bu zaten kendiliğinden oluyor (bir Q3
 * makalesi 31 puan, baraj 30 ve 25). PROFESÖRLÜKTE FARK YARATIYOR: baraj 50,
 * bir Q2 makalesi 37 puan — dipnot olmasa yetmezdi. Profesörlük eşiğine
 * `Kalip::veya` ile ikinci kol olarak yazıldı. "Senyör yazar" (alanında en az
 * on uluslararası yayını olan son isim) kayıtta yok; koşul yalnız birinci
 * isim ve sorumlu yazar üzerinden değerlendiriliyor, yani ADAY OLDUĞUNDAN
 * DAHA HAZIRLIKSIZ görünebilir.
 *
 * DİPNOT (e) — ALAN-1'E ÖZGÜ EK KOŞUL: "ALAN-1'e dâhil adayın PUAN-1
 * kapsamındaki yayınlarından en az 1 (bir)'i EK-2'nin (1).1'i kapsamında
 * olmalıdır", yani SCI, SCI-Expanded, SSCI veya AHCI araştırma makalesi.
 * ALAN-1 yönergenin kendi tanımı (Madde 4/b): Sağlık, Tıp, Diş Hekimliği,
 * Eczacılık, Veteriner, Ziraat, Mühendislik, Bilgisayar Bilimleri, Fen
 * Bilimleri, Matematik, İstatistik. Kalan alanların hepsi ALAN-2 (Madde 4/c).
 *
 * DİPNOT (i) — GÜZEL SANATLARDA PUAN-1'İN YARISI: doçentlikte 25 yerine 13,
 * profesörlükte 50 yerine 25. Kesirli baraj §0 gereği YUKARI yuvarlandı
 * (25 × %50 = 12,5 → 13).
 *
 * DİPNOT (g) — PROFESÖRLÜKTE PUANIN YARISI DOÇENTLİK SONRASI: 550 puanın en az
 * 275'i doçentlik başvurusu sonrası yayın ve faaliyetlerden olmalı. Bu yüzden
 * profesörlük eşiğinde İKİ toplam barajı var; ikisi de `Kalip::toplam` ile
 * yazıldı ve dönem metne ekleniyor.
 *
 * YABANCI DİL BÖLÜME GÖRE İKİYE AYRILIYOR (Madde 9/1-b, 10/2, 11/4): çalışma
 * alanı bir yabancı dil olan bölümlerde ilgili dilden 85, diğerlerinde
 * Dr. Öğr. Üyeliğinde 60, doçentlik ve profesörlükte 65. Ayrım `birim` ile
 * yalnız filolojide kuruldu; "ikinci yabancı dilden 60/65" koşulu tek bir dil
 * puanı tutulduğu için yazılamadı.
 *
 * DR. ÖĞR. ÜYESİ YENİDEN ATANMA GİRİLMEDİ (Madde 9/2): EK-1 yeniden atamayı
 * üç, iki ve bir yıllık üç ayrı sütunla veriyor (80 / 60 / 40 puan) ve süre
 * son atanma tarihine bağlı; o tarih profilde yok.
 *
 * ÖRNEK DERS BEYAN (Madde 9/1-d): "Tekirdağ Namık Kemal Üniversitesi Örnek
 * Ders Anlatımı Usul ve Esasları" doğrultusunda anlatılan dersten jüri
 * "Başarılı" raporu istiyor.
 *
 * DERS VERME KOŞULU BEYAN (Madde 10/3 ve 11/7): doçentlik ve profesörlükte
 * "dönemlik programlarda 4 farklı yarıyıl ya da yıllık programlarda 2 farklı
 * yıl ders vermiş olmak". Cetvelin 17.4 satırı DERS BAŞINA puan veriyor, yarıyıl
 * başına değil; ders sayısını yarıyıl sayısı saymak bir dönemde dört ders veren
 * adayı koşulu sağlamış gösterirdi (§0'ın ters yönü). Beyan olarak duruyor.
 *
 * SÖZLÜ SINAVSIZ DOÇENTLERİN %20 FAZLASI GİRİLMEDİ (Madde 11/1-b): doçentlik
 * unvanını sözlü sınavsız alan aday ya sözlü sınavı vermeli ya da örnek ders
 * anlatıp barajları "her puan türünde en az %20 fazlasıyla" sağlamalı. Hangi
 * kolun geçerli olduğu adayın sözlü sınav durumuna bağlı; §0 gereği DÜŞÜK
 * baraj yazıldı ve aday notunda uyarıldı — çünkü yüksek barajı yazmak sözlü
 * sınavı vermiş adaya olmayan bir şart gösterirdi.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: tekirdag-2024
 */

use App\Services\Scoring\Sart\Kalip;

$UNI = 'Tekirdağ Namık Kemal Üniversitesi';
$CETVEL = 'tekirdag-2024';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;

/** Madde 4/b — ALAN-1. */
$alan1 = ['fen', 'muhendislik', 'saglik', 'ziraat'];
/** Madde 4/c — ALAN-2; filoloji ve güzel sanatlar ayrı eşik taşıdığı için burada yok. */
$alan2 = ['sosyal', 'egitim', 'ilahiyat', 'hukuk', 'spor', 'mimarlik'];

$ikiSutun = 'Tekirdağ barajı İKİ SÜTUNA bölüyor: PUAN-1 yalnız makale kalemlerinden, PUAN-2 '
    .'cetvelin tamamından. PUAN-1\'deki fazlalık PUAN-2\'ye aktarılıyor ama tersi olmuyor, '
    .'bu yüzden burada iki koşul görüyorsunuz: cetvelin tamamından toplam puan ve makale '
    .'kalemlerinden PUAN-1 kadar puan.';

$senyorNotu = 'Yönerge "senyör yazar"ı (alanınızda en az on uluslararası yayını olan son isim) '
    .'birinci isimle aynı sayıyor; kayıtta böyle bir rol olmadığı için koşul yalnız birinci '
    .'isim ve sorumlu yazar üzerinden değerlendiriliyor. Senyör yazar olduğunuz yayınlar bu '
    .'koşulda sayılmıyor.';

$sozluSinav = 'Doçentlik unvanını SÖZLÜ SINAVSIZ aldıysanız yönerge iki kol sunuyor: ya ÜAK '
    .'sözlü sınavında başarılı olduğunuzu belgeleyeceksiniz ya da örnek ders anlatıp buradaki '
    .'bütün barajları %20 fazlasıyla sağlayacaksınız (Madde 11/1-b). Burada DÜŞÜK baraj '
    .'gösteriliyor; sözlü sınavsız doçentseniz gerçek barajınız %20 daha yüksek.';

$yenidenAtanma = 'Doktor öğretim üyeliğine YENİDEN ATANMA eşiği girilmedi: EK-1 yeniden '
    .'atamayı üç, iki ve bir yıllık üç ayrı sütunla veriyor (80 / 60 / 40 puan) ve hangisinin '
    .'geçerli olduğu son atanma tarihinize bağlı.';

$dersBeyani = Kalip::beyan('Doktora, uzmanlık ya da sanatta yeterlik sonrasında dönemlik '
    .'programlarda 4 farklı yarıyıl veya yıllık programlarda 2 farklı yıl ön lisans, lisans '
    .'ya da lisansüstü düzeyde ders vermiş olmak', 'Madde 10/3');

$docentlikUnvani = Kalip::beyan('İlgili alanda Üniversitelerarası Kurul tarafından verilen '
    .'doçent unvanına sahip olmak; unvanı sözlü sınavsız aldıysanız ÜAK sözlü sınavında '
    .'başarılı olduğunuzu belgelemek', 'Madde 10/1');

/**
 * Bir kadronun bir alan kümesi için eşiğini üretir.
 *
 * @param  list<string>  $alanlar
 * @param  list<array<string, mixed>>  $ek
 * @return array<string, mixed>
 */
$esik = function (string $anahtar, string $kadro, string $kadroAd, array $alanlar,
    int $toplam, ?array $toplamDonem, int $puan1, int $yds, string $notlar, string $adayNotu,
    array $ek = [], ?string $birim = null) use ($UNI, $CETVEL): array {
    $kayit = [
        'anahtar' => "tekirdag-{$anahtar}",
        'aday_notu' => $adayNotu,
        'universite' => $UNI,
        'kadro' => $kadro,
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => $notlar,
        'sart' => Kalip::ve($kadroAd, array_values([
            Kalip::toplam($toplam, $toplamDonem),
            ...$ek,
            Kalip::yds($yds),
        ])),
    ];

    if ($birim !== null) {
        $kayit['birim'] = $birim;
    }

    return $kayit;
};

$puan1Kosulu = fn (int $puan, string $madde) => Kalip::puanDan(
    "Makale kalemlerinizden en az {$puan} puan", ['PUAN1'], $puan, madde: $madde);

$sciKosulu = Kalip::adet('Bu makalelerden en az 1\'i SCI, SCI-Expanded, SSCI ya da AHCI '
    .'kapsamındaki bir dergide yayımlanmış araştırma makalesi olmalı',
    ['SCI-MAKALE'], 1, madde: 'EK-1 dipnot (e)');

$drBeyanlari = [
    Kalip::beyan('İlan edilen alanda doktora yapmış olmak; tıp, diş hekimliği ya da eczacılıkta '
        .'uzman unvanı almış olmak veya belirli sanat dallarının birinde yeterlik kazanmış olmak',
        'Madde 9/1-a'),
    Kalip::beyan('"Tekirdağ Namık Kemal Üniversitesi Örnek Ders Anlatımı Usul ve Esasları" '
        .'doğrultusunda örnek ders anlatmak ve jüriden "Başarılı" raporu almak', 'Madde 9/1-d'),
];

$profBeyanlari = [
    Kalip::beyan('Doçent unvanını almaya esas olan doçentlik başvuru dönemindeki kriterleri '
        .'(lisansüstü tezlerden üretilmiş yayın şartı hariç) doçentlik başvurusu sonrası '
        .'çalışmalarınızla yeniden sağlamış olmak', 'Madde 11/2'),
    Kalip::beyan('Doçent unvanını aldıktan sonra yaptığınız özgün yayınlardan birini "Başlıca '
        .'Araştırma Eseri" olarak sunmak ve o çalışmada başlıca yazar olmak', 'Madde 11/5'),
    Kalip::beyan('Doçent unvanını aldıktan sonra en az 2,5 yıl yükseköğretim kurumlarında ya da '
        .'alanınızla ilgili bir bilimsel araştırma kuruluşunda çalışmış olmak', 'Madde 11/6'),
    Kalip::beyan('Doçent unvanını aldıktan sonra dönemlik programlarda 4 farklı yarıyıl veya '
        .'yıllık programlarda 2 farklı yıl ders vermiş olmak', 'Madde 11/7'),
];

/** Profesörlükte dipnot (b) telafi dalıyla birlikte PUAN-1 koşulu. */
$profPuan1 = fn (int $puan) => Kalip::veya('Makale koşulu', [
    Kalip::puanDan("Makale kalemlerinizden en az {$puan} puan", ['PUAN1'], $puan,
        madde: 'EK-1 PUAN-1'),
    Kalip::adet('Birinci isim ya da sorumlu yazar olduğunuz en az 1 adet Q1, Q2 veya Q3 '
        .'dilimli dergi makalesi', ['Q1-Q3'], 1, yazar: 'baslica', madde: 'EK-1 dipnot (b)'),
]);

$drNotu = $ikiSutun.' '.$yenidenAtanma;
$docNotu = $ikiSutun;
$profNotu = $ikiSutun.' '.$senyorNotu.' '.$sozluSinav;

$esikler = [
    // ══════════ DOKTOR ÖĞRETİM ÜYESİ — İLK ATAMA (Madde 9/1) ══════════
    $esik('dr-alan1', 'dr_ogr_uyesi', 'Dr. Öğr. Üyesi', $alan1, 80, null, 30, 60,
        'EK-1: asgari toplam 80 puan (PUAN-1 30 + PUAN-2 50). ALAN-1 olduğu için PUAN-1 '
        .'yayınlarından en az biri SCI, SCI-Expanded, SSCI ya da AHCI araştırma makalesi '
        .'olmalı (dipnot e).',
        'Alanınız yönergenin ALAN-1 tanımına giriyor; bu yüzden makale puanınızın en az bir '
        .'kısmı SCI, SCI-Expanded, SSCI ya da AHCI dergisinden gelmek zorunda. '.$drNotu,
        [$puan1Kosulu(30, 'EK-1 PUAN-1'), $sciKosulu, ...$drBeyanlari]),
    $esik('dr-alan2', 'dr_ogr_uyesi', 'Dr. Öğr. Üyesi', $alan2, 80, null, 30, 60,
        'EK-1: asgari toplam 80 puan (PUAN-1 30 + PUAN-2 50).', $drNotu,
        [$puan1Kosulu(30, 'EK-1 PUAN-1'), ...$drBeyanlari]),
    $esik('dr-guzel-sanatlar', 'dr_ogr_uyesi', 'Dr. Öğr. Üyesi', ['guzel_sanatlar'], 80, null, 30, 60,
        'EK-1: asgari toplam 80 puan (PUAN-1 30 + PUAN-2 50). Güzel Sanatlarda PUAN-1 indirimi '
        .'yalnız doçentlik ve profesörlükte var, Dr. Öğr. Üyeliğinde yok.', $drNotu,
        [$puan1Kosulu(30, 'EK-1 PUAN-1'), ...$drBeyanlari]),
    $esik('dr-filoloji', 'dr_ogr_uyesi', 'Dr. Öğr. Üyesi', ['filoloji'], 80, null, 30, 60,
        'EK-1: asgari toplam 80 puan (PUAN-1 30 + PUAN-2 50). Yabancı dil barajı 60.', $drNotu,
        [$puan1Kosulu(30, 'EK-1 PUAN-1'), ...$drBeyanlari], 'Diğer bölümler'),
    $esik('dr-filoloji-dil', 'dr_ogr_uyesi', 'Dr. Öğr. Üyesi', ['filoloji'], 80, null, 30, 85,
        'EK-1: asgari toplam 80 puan. Çalışma alanı yabancı dil olan bölümlerde yabancı dil '
        .'barajı 60 değil 85 (Madde 9/1-b).',
        'Bu bölümde yabancı dil barajı 85; ayrıca çalışma alanınız dışındaki ikinci yabancı '
        .'dilden de en az 60 isteniyor, tek dil puanı tutulduğu için o koşul burada '
        .'değerlendirilemiyor. '.$drNotu,
        [$puan1Kosulu(30, 'EK-1 PUAN-1'), ...$drBeyanlari],
        'Çalışma alanı yabancı dil olan bölümler'),

    // ══════════ DOÇENT (Madde 10) ══════════
    $esik('docentlik', 'docentlik', 'Doçent', [...$alan1, ...$alan2], 325, $DOKTORA, 25, 65,
        'EK-1: doktora sonrası asgari toplam 325 puan (PUAN-1 25 + PUAN-2 300). Dipnot (h): '
        .'bu puan ÜAK doçentlik asgari puanına İLAVEDİR.',
        'Buradaki 325 puan, ÜAK\'ın doçentlik için istediği asgari puana EK olarak isteniyor '
        .'(EK-1 dipnot h). '.$docNotu,
        [$puan1Kosulu(25, 'EK-1 PUAN-1'), $docentlikUnvani, $dersBeyani]),
    $esik('docentlik-guzel-sanatlar', 'docentlik', 'Doçent', ['guzel_sanatlar'], 325, $DOKTORA, 13, 65,
        'EK-1 dipnot (i): Güzel Sanatlar temel alanında PUAN-1\'in %50\'si yeterli — 25 yerine '
        .'13 (12,5 yukarı yuvarlandı). Toplam baraj değişmiyor.',
        'Güzel Sanatlar temel alanında makale barajı yarıya iniyor (25 yerine 13); toplam 325 '
        .'puan barajı aynı kalıyor. '.$docNotu,
        [$puan1Kosulu(13, 'EK-1 dipnot (i)'), $docentlikUnvani, $dersBeyani]),
    $esik('docentlik-filoloji', 'docentlik', 'Doçent', ['filoloji'], 325, $DOKTORA, 25, 65,
        'EK-1: doktora sonrası asgari toplam 325 puan. Yabancı dil barajı 65.', $docNotu,
        [$puan1Kosulu(25, 'EK-1 PUAN-1'), $docentlikUnvani, $dersBeyani], 'Diğer bölümler'),
    $esik('docentlik-filoloji-dil', 'docentlik', 'Doçent', ['filoloji'], 325, $DOKTORA, 25, 85,
        'EK-1: doktora sonrası asgari toplam 325 puan. Çalışma alanı yabancı dil olan '
        .'bölümlerde yabancı dil barajı 85 (Madde 10/2).',
        'Bu bölümde yabancı dil barajı 85. '.$docNotu,
        [$puan1Kosulu(25, 'EK-1 PUAN-1'), $docentlikUnvani, $dersBeyani],
        'Çalışma alanı yabancı dil olan bölümler'),

    // ══════════ PROFESÖR (Madde 11) ══════════
    $esik('profesorluk', 'profesorluk', 'Profesör', [...$alan1, ...$alan2], 550, null, 50, 65,
        'EK-1: asgari toplam 550 puan (PUAN-1 50 + PUAN-2 500); dipnot (g) uyarınca puanın en '
        .'az yarısı doçentlik başvurusu sonrasından. Dipnot (b) PUAN-1\'e telafi dalı veriyor.',
        $profNotu,
        [Kalip::toplam(275, $DOCENTLIK), $profPuan1(50), ...$profBeyanlari]),
    $esik('profesorluk-guzel-sanatlar', 'profesorluk', 'Profesör', ['guzel_sanatlar'], 550, null, 25, 65,
        'EK-1 dipnot (i): Güzel Sanatlar temel alanında PUAN-1\'in %50\'si yeterli — 50 yerine '
        .'25. Toplam baraj değişmiyor.',
        'Güzel Sanatlar temel alanında makale barajı yarıya iniyor (50 yerine 25). '.$profNotu,
        [Kalip::toplam(275, $DOCENTLIK), $profPuan1(25), ...$profBeyanlari]),
    $esik('profesorluk-filoloji', 'profesorluk', 'Profesör', ['filoloji'], 550, null, 50, 65,
        'EK-1: asgari toplam 550 puan. Yabancı dil barajı 65.', $profNotu,
        [Kalip::toplam(275, $DOCENTLIK), $profPuan1(50), ...$profBeyanlari], 'Diğer bölümler'),
    $esik('profesorluk-filoloji-dil', 'profesorluk', 'Profesör', ['filoloji'], 550, null, 50, 85,
        'EK-1: asgari toplam 550 puan. Çalışma alanı yabancı dil olan bölümlerde yabancı dil '
        .'barajı 85 (Madde 11/4).',
        'Bu bölümde yabancı dil barajı 85. '.$profNotu,
        [Kalip::toplam(275, $DOCENTLIK), $profPuan1(50), ...$profBeyanlari],
        'Çalışma alanı yabancı dil olan bölümler'),
];

return $esikler;
