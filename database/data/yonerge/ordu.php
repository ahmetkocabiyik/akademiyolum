<?php

/**
 * ORDU ÜNİVERSİTESİ — Öğretim Üyeliği Kadrolarına Başvuru ve Atanma
 * Koşulları ve Uygulama Yönergesi
 * Kaynak: pdf/1785505490169.ODÜ Atanma Yönergesi.pdf (31 sayfa;
 *         Senato 03.04.2024 ve 2024-58)
 *
 * 2017 SÜRÜMÜNÜN YERİNE GEÇTİ. Yeni yönergenin MADDE 14'ü eskisini açıkça
 * yürürlükten kaldırıyor: "Bu yönergenin yürürlüğe girmesiyle halen
 * yürürlükte olan Ordu Üniversitesi Öğretim Üyeliği Kadrolarına Başvuru ve
 * Atama Koşulları ve Uygulama Yönergesi yürürlükten kalkar." Eski cetvel
 * `ordu-2017.php` cetveli silindi; geçmişi git'te duruyor.
 *
 * ── YAPI: ON BİR ALAN TABLOSU × DÖRT KADRO ──
 * 2017 sürümü tek tablo ve alandan bağımsız toplam baraj kullanıyordu.
 * 2024 sürümü her temel alana ayrı bir tablo veriyor (TABLO-3 … TABLO-13) ve
 * her tabloda dört kadro sütunu var: Profesör, Doçent, Dr. Öğr. Üyesi (ilk
 * atanma) ve Dr. Öğr. Üyesi (yeniden atanma).
 *
 * TOPLAM ASGARİ PUAN ON BİR TABLODA DA AYNI: profesörlük 500, doçentlik 400,
 * dr. öğr. üyeliği 100 (ilk ve yeniden atanmada). Alan farkı KATEGORİ ALT
 * BARAJLARINDA: hangi makale bendinden ne kadar puan geleceği tablodan
 * tabloya değişiyor ve fark büyük — Filoloji ile İlahiyat profesörlükte
 * yalnız TR Dizin makalelerinden (A.6) 120 puan isterken Mimarlık aynı
 * kadroda makale bentleri arasında hiç ayrım yapmıyor.
 *
 * "ZORUNLU ALANLARDA ASGARİ PUAN" SATIRI ALT BARAJLARIN TOPLAMI, ayrı bir
 * koşul değil: örneğin Eğitim profesörlüğünde 295 = makale 180 + bildiri 15
 * + kitap 60 + atıf 20 + öğretim 20. Bu yüzden düğüm olarak yazılmadı;
 * alt barajların her biri kendi düğümünde duruyor. Sayı aday notunda.
 *
 * ── M. PROJELER: PUAN DEĞİL, BAŞVURU ŞARTI ──
 * "Son üç yıl içinde yürütücü olarak en az bir TÜBİTAK proje (Bilim Şenliği
 * hariç) BAŞVURUSU olma şartı aranmaktadır." Proje kabul edilmiş olması
 * gerekmiyor, başvurmuş olmak yeterli; başvuru kaydı tutulmadığı için koşul
 * `beyan` olarak duruyor. Dipnot (1) telafisini de veriyor: sağlayamayan
 * aday toplam asgari puanın %10'unu (profesörlükte 50, doçentlikte 40,
 * dr. öğr. üyeliğinde 10) A ve B kategorilerinden İLAVE olarak sağlar.
 * Telafi ayrı bir düğüm olarak değil, beyanın metninde anlatılıyor.
 *
 * ── TAVANLAR DA ALT BARAJLAR DA GİRİLDİ ──
 * Her kategori satırı hem "en az" hem "en fazla değerlendirmeye alınır"
 * diyor. Alt barajlar eşiğin düğümlerinde; tavanlar cetvelin
 * `grup_tavanlari`'nda. Tavan KADROYA göre değiştiği ve kitapta TABLOYA da
 * bağlı olduğu için cetvel varyantlarla üretiliyor (ordu-2024-profesorluk,
 * ordu-2024-docentlik-c120 …) — KONVANSIYONLAR "Tavan FAKÜLTE × KADRO ise
 * cetveli çarpanla üret".
 *
 * İlk girişte tavanlar atlanmıştı ve aday notu "uygulanmadı, puanınız
 * gerçeğinden yüksek görünebilir" diyordu. Bu §0'a AYKIRIYDI: eksik saymak
 * serbest, fazla saymak değil. Tavansız bir toplam adayı barajın üstünde
 * gösterebilirdi.
 *
 * ── TEK YAZARLI YAYIN DİPNOTLARI 01.09.2026'DA GİRİLDİ ──
 * Dipnot (3) ve (4) beş tabloda tek yazarlı ya da birinci isimli yayın
 * istiyor. Daha önce "hangi bende bağlandığı metinden net okunamıyor" diye
 * bırakılmıştı; bağlanma ÜST SİMGEDEN okunuyor ve metin katmanında duruyor:
 * profesör sütununun makale hücresinde "en az 120 puan⁴", doçent sütununda
 * "en az 100 puan³". Beş tabloda da aynı desen — (3) doçentliğe, (4)
 * profesörlüğe bağlı. Bkz. $TEK_YAZAR.
 *
 * Dipnotların "farklı dergilerde yayımlanmış" kaydı ve yanlarındaki puan
 * eşikleri girilmedi; ikisi de aday notunda anılıyor. TABLO-8'in (3) ve (4)
 * dipnotları da girilmedi: onlar koşul EKLEMİYOR, N kategorilerini
 * sağlayamayana telafi yolu açıyor
 *
 * ── HUKUK KAPSAM DIŞI ──
 * Yönergenin on bir tablosu arasında hukuk temel alanı yok; Ordu
 * Üniversitesi'nde Hukuk Fakültesi de bulunmuyor.
 *
 * ── GÜZEL SANATLARIN ÖZEL ŞARTLARI ──
 * TABLO-13 "Genel Başvuru Şartları"; TABLO-14'ten sonrası müzik ve sahne
 * sanatları alt dallarına (kompozisyon, yorumculuk, müzikoloji, tiyatro
 * kuramı, oyunculuk-reji …) ÖZEL başvuru şartları veriyor. Bunlar alt dala
 * bağlı ve profilde alt dal tutulmadığı için girilmedi; TABLO-13'ün genel
 * şartları yazıldı ve dipnot (6) uyarınca toplam asgari puanın özel şartları
 * da kapsadığı aday notunda söyleniyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: ordu-2024
 */

use App\Services\Scoring\Sart\Kalip;

$UNI = 'Ordu Üniversitesi';
$CETVEL = 'ordu-2024';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

/**
 * Makale bent aralıklarının adaya gösterilecek adları.
 *
 * @var array<string, string>
 */
$MAKALE_ADI = [
    'A.1-A.4' => 'SCI, SSCI, SCI-Expanded ve AHCI dergilerindeki',
    'A.1-A.5' => 'SCI-SSCI-AHCI, ESCI ve Scopus dergilerindeki',
    'A.1-A.6' => 'SCI-SSCI-AHCI, ESCI, Scopus ve TR Dizin dergilerindeki',
    'A.1-A.7' => 'SCI-SSCI-AHCI, ESCI, Scopus, TR Dizin ve diğer uluslararası dergilerdeki',
    'A.1-A.8' => 'bütün hakemli dergilerdeki',
    'A.5-A.6' => 'ESCI, Scopus, alan indeksli ve TR Dizin dergilerindeki',
    'A.6' => 'TR Dizin dergilerindeki',
    'A' => 'bütün',
];

/**
 * Kategori alt barajları on bir tabloda büyük ölçüde aynı; değişen yalnız
 * makale (A) ve kitap (C) satırları.
 *
 * @param  array<string, mixed>|null  $donem
 * @return list<array<string, mixed>>
 */
$ortakKosullar = function (string $kadro, ?array $donem, string $madde): array {
    $dugumler = [
        Kalip::puanDan('Ulusal ve uluslararası bildirilerinizden en az 15 puan', ['B'], 15, $donem, madde: $madde),
    ];

    // Atıf ve öğretim satırları dr. öğr. üyeliğinin İLK atamasında yok.
    if ($kadro !== 'dr_ogr_uyesi') {
        if ($kadro !== 'dr_ogr_uyesi_yeniden') {
            $dugumler[] = Kalip::puanDan(
                'Atıflarınızdan en az '.($kadro === 'profesorluk' ? 20 : 10).' puan',
                ['E'], $kadro === 'profesorluk' ? 20 : 10, $donem, madde: $madde,
            );
        }

        $dugumler[] = Kalip::puanDan('Öğretim faaliyetlerinizden en az 20 puan', ['L'], 20, $donem, madde: $madde);
        $dugumler[] = Kalip::beyan(
            'Son üç yıl içinde yürütücü olarak en az bir TÜBİTAK projesine (Bilim Şenliği hariç) '
            .'BAŞVURMUŞ olmak — projenin kabul edilmiş olması gerekmiyor. Sağlayamıyorsanız '
            .'toplam asgari puanın %10\'unu makale ve bildiri kalemlerinizden İLAVE olarak '
            .'toplamanız gerekiyor',
            $madde,
        );
    }

    return $dugumler;
};

/**
 * On bir alan tablosu. Her satır: temel alan, tablo adı ve dört kadronun
 * makale/kitap koşulları. Makale koşulu `[[grup, puan], …]` biçiminde;
 * son eleman her zaman toplam makale barajı.
 *
 * @var array<string, array{tablo: string, ad: string, kosul: array<string, array{makale: list<array{0: string, 1: int}>, kitap?: int, kitapAdet?: int}>}>
 */
$TABLOLAR = [
    'spor' => ['tablo' => 'TABLO-3', 'ad' => 'Spor Bilimleri', 'kosul' => [
        'profesorluk' => ['makale' => [['A.1-A.5', 100], ['A.6', 80], ['A', 180]]],
        'docentlik' => ['makale' => [['A.1-A.4', 50], ['A.6', 60], ['A', 110]], 'kitap' => 50],
        'dr_ogr_uyesi' => ['makale' => [['A.1-A.7', 80]]],
        'dr_ogr_uyesi_yeniden' => ['makale' => [['A.1-A.7', 60]]],
    ]],
    'egitim' => ['tablo' => 'TABLO-4', 'ad' => 'Eğitim Bilimleri', 'kosul' => [
        'profesorluk' => ['makale' => [['A.1-A.5', 75], ['A', 180]], 'kitap' => 60],
        'docentlik' => ['makale' => [['A.1-A.4', 60], ['A', 120]], 'kitap' => 30],
        'dr_ogr_uyesi' => ['makale' => [['A', 60]]],
        'dr_ogr_uyesi_yeniden' => ['makale' => [['A', 60]]],
    ]],
    'fen' => ['tablo' => 'TABLO-5', 'ad' => 'Fen Bilimleri ve Matematik', 'kosul' => [
        'profesorluk' => ['makale' => [['A.1-A.4', 120], ['A.1-A.6', 180]]],
        'docentlik' => ['makale' => [['A.1-A.4', 70], ['A.1-A.6', 120]]],
        'dr_ogr_uyesi' => ['makale' => [['A', 60]], 'birinciMakale' => true],
        'dr_ogr_uyesi_yeniden' => ['makale' => [['A', 60]]],
    ]],
    'filoloji' => ['tablo' => 'TABLO-6', 'ad' => 'Filoloji', 'kosul' => [
        'profesorluk' => ['makale' => [['A.6', 120], ['A', 180]], 'kitap' => 90],
        'docentlik' => ['makale' => [['A.6', 100], ['A', 120]], 'kitap' => 60],
        'dr_ogr_uyesi' => ['makale' => [['A', 60]]],
        'dr_ogr_uyesi_yeniden' => ['makale' => [['A', 60]]],
    ]],
    'ilahiyat' => ['tablo' => 'TABLO-7', 'ad' => 'İlahiyat', 'kosul' => [
        'profesorluk' => ['makale' => [['A.6', 120], ['A', 180]], 'kitap' => 90],
        'docentlik' => ['makale' => [['A.6', 100], ['A', 120]], 'kitap' => 60],
        'dr_ogr_uyesi' => ['makale' => [['A', 60]]],
        'dr_ogr_uyesi_yeniden' => ['makale' => [['A', 60]]],
    ]],
    'mimarlik' => ['tablo' => 'TABLO-8', 'ad' => 'Mimarlık, Planlama ve Tasarım', 'kosul' => [
        'profesorluk' => ['makale' => [['A.1-A.6', 160]]],
        'docentlik' => ['makale' => [['A.1-A.5', 60], ['A.6', 40], ['A', 100]]],
        'dr_ogr_uyesi' => ['makale' => [['A', 60]]],
        'dr_ogr_uyesi_yeniden' => ['makale' => [['A', 60]]],
    ]],
    'muhendislik' => ['tablo' => 'TABLO-9', 'ad' => 'Mühendislik', 'kosul' => [
        'profesorluk' => ['makale' => [['A.1-A.4', 120], ['A.6', 40], ['A', 160]]],
        'docentlik' => ['makale' => [['A.1-A.4', 60], ['A.6', 40], ['A', 100]]],
        'dr_ogr_uyesi' => ['makale' => [['A', 60]]],
        'dr_ogr_uyesi_yeniden' => ['makale' => [['A', 60]]],
    ]],
    'saglik' => ['tablo' => 'TABLO-10', 'ad' => 'Sağlık Bilimleri', 'kosul' => [
        'profesorluk' => ['makale' => [['A.1-A.4', 70], ['A.5-A.6', 90], ['A', 160]]],
        'docentlik' => ['makale' => [['A.1-A.4', 50], ['A.5-A.6', 60], ['A', 110]]],
        'dr_ogr_uyesi' => ['makale' => [['A', 60]], 'birinciMakale' => true],
        'dr_ogr_uyesi_yeniden' => ['makale' => [['A', 60]]],
    ]],
    'sosyal' => ['tablo' => 'TABLO-11', 'ad' => 'Sosyal, Beşeri ve İdari Bilimler', 'kosul' => [
        'profesorluk' => ['makale' => [['A.1-A.5', 100], ['A.6', 80], ['A', 180]], 'kitap' => 60],
        'docentlik' => ['makale' => [['A.1-A.5', 50], ['A.6', 90], ['A', 140]], 'kitap' => 30],
        'dr_ogr_uyesi' => ['makale' => [['A', 60]]],
        'dr_ogr_uyesi_yeniden' => ['makale' => [['A', 60]]],
    ]],
    'ziraat' => ['tablo' => 'TABLO-12', 'ad' => 'Ziraat, Orman ve Su Ürünleri', 'kosul' => [
        'profesorluk' => ['makale' => [['A.1-A.4', 120], ['A.6', 40], ['A', 160]]],
        'docentlik' => ['makale' => [['A.1-A.4', 60], ['A.6', 60], ['A', 120]]],
        'dr_ogr_uyesi' => ['makale' => [['A', 60]], 'birinciMakale' => true],
        'dr_ogr_uyesi_yeniden' => ['makale' => [['A', 60]]],
    ]],
    'guzel_sanatlar' => ['tablo' => 'TABLO-13', 'ad' => 'Güzel Sanatlar', 'kosul' => [
        'profesorluk' => ['makale' => [['A.1-A.5', 80], ['A.6', 40], ['A', 120]], 'kitapAdet' => 2],
        'docentlik' => ['makale' => [['A.1-A.5', 40], ['A.6', 30], ['A', 70]], 'kitapAdet' => 1],
        'dr_ogr_uyesi' => ['makale' => [['A', 40]]],
        'dr_ogr_uyesi_yeniden' => ['makale' => [['A', 40]]],
    ]],
];

/** Kadro adları ve toplam barajları. */
$KADROLAR = [
    'profesorluk' => ['ad' => 'Profesör', 'toplam' => 500],
    'docentlik' => ['ad' => 'Doçent', 'toplam' => 400],
    'dr_ogr_uyesi' => ['ad' => 'Dr. Öğr. Üyesi', 'toplam' => 100],
    'dr_ogr_uyesi_yeniden' => ['ad' => 'Dr. Öğr. Üyesi (yeniden atanma)', 'toplam' => 100],
];

/**
 * Kitap tavanı tablodan tabloya değişiyor; beş tabloda kitap satırı hiç yok.
 * Cetvel varyantı bu tavana göre seçiliyor (bkz. cetvel/ordu-2024.php).
 *
 * @var array<string, array<string, int>>
 */
$KITAP_TAVANI = [
    'spor' => ['profesorluk' => 75, 'docentlik' => 75],
    'egitim' => ['profesorluk' => 120, 'docentlik' => 60],
    'filoloji' => ['profesorluk' => 180, 'docentlik' => 120],
    'ilahiyat' => ['profesorluk' => 180, 'docentlik' => 120],
    'sosyal' => ['profesorluk' => 120, 'docentlik' => 60],
    'guzel_sanatlar' => ['profesorluk' => 180, 'docentlik' => 120],
];

/** Kadro anahtarının cetvel varyantındaki karşılığı. */
$CETVEL_KADRO = [
    'profesorluk' => 'profesorluk',
    'docentlik' => 'docentlik',
    'dr_ogr_uyesi' => 'dr',
    'dr_ogr_uyesi_yeniden' => 'dr-yeniden',
];

/** Her tablonun "ZORUNLU ALANLARDA ASGARİ PUAN" satırı — aday notunda anılıyor. */
/**
 * TABLO DİPNOTLARINDAKİ TEK YAZAR / BİRİNCİ İSİM KOŞULU.
 *
 * Beş tablo, doçentlik ve profesörlük sütunundaki makale hücresine üst simge
 * bir dipnot numarası koyuyor (doçentlikte (3), profesörlükte (4)) ve o
 * dipnot ayrıca tek yazarlı ya da birinci isimli yayın istiyor. Bağlanma
 * ÜST SİMGEDEN okunuyor: TABLO-6'nın profesör sütununda "A.6 kategorisinde
 * en az 120 puan⁴", doçent sütununda "en az 100 puan³" yazıyor.
 *
 * SAYILAR HER İKİ KOLUN ORTAK TABANI. Dipnotlar iki yollu: A.6 puan şartını
 * sağlayan aday birinci cümledeki sayıyı, sağlayamayan ikinci cümledeki
 * (telafi) sayıyı tutturmak zorunda. Filoloji, İlahiyat ve Güzel Sanatlar'da
 * iki kol aynı sayıyı istiyor; Sosyal'de birinci kol üç, telafi kolu bir tek
 * yazarlı yayın istiyor ve buraya İKİSİNİN DÜŞÜĞÜ yazıldı — yüksek olanı
 * yazmak, telafi yolundan giden adayı haksız yere eler.
 *
 * "Farklı dergilerde yayımlanmış" kaydı ile dipnotların puan şartları
 * girilmedi; ikisi de aday notunda anılıyor.
 *
 * @var array<string, array<string, array{0: int, 1: 'tek'|'ilk'}>>
 */
$TEK_YAZAR = [
    // TABLO-5 dipnotu tek yazar değil BİRİNCİ İSİM istiyor ve doçentlikte
    // profesörlükten fazlasını arıyor; kaynaktaki hâliyle girildi.
    'fen' => ['docentlik' => [2, 'ilk'], 'profesorluk' => [1, 'ilk']],
    'filoloji' => ['docentlik' => [1, 'tek'], 'profesorluk' => [2, 'tek']],
    'ilahiyat' => ['docentlik' => [1, 'tek'], 'profesorluk' => [2, 'tek']],
    'sosyal' => ['docentlik' => [1, 'tek'], 'profesorluk' => [1, 'tek']],
    'guzel_sanatlar' => ['docentlik' => [1, 'tek'], 'profesorluk' => [2, 'tek']],
];

$ZORUNLU = [
    'spor' => [235, 205, 95, 95], 'egitim' => [295, 195, 75, 95],
    'fen' => [235, 165, 75, 95], 'filoloji' => [325, 225, 75, 95],
    'ilahiyat' => [325, 225, 75, 95], 'mimarlik' => [265, 170, 75, 95],
    'muhendislik' => [215, 145, 75, 95], 'saglik' => [215, 155, 75, 95],
    'sosyal' => [295, 215, 75, 95], 'ziraat' => [215, 165, 75, 95],
    'guzel_sanatlar' => [175, 115, 55, 75],
];

$TAVAN_NOTU = ' Yönerge her kategoriye bir de TAVAN koyuyor (atıflardan profesörlükte en '
    .'fazla 200, doçentlikte 150; bildirilerden 40/30; öğretim faaliyetlerinden 80/40; kitap '
    .'tavanı alana göre 60 ile 180 arasında). Bu tavanlar UYGULANIYOR, yani bir kategoriden '
    .'tavanın üstünde topladığınız puan toplama girmiyor.';

$TEK_YAZAR_NOTU = ' Tablonuzun dipnotu ayrıca tek yazarlı (Fen\'de birinci isimli) yayın '
    .'istiyorsa yukarıda ayrı bir satır olarak görürsünüz. DİKKAT: dipnot bu yayınların '
    .'"FARKLI DERGİLERDE" yayımlanmış olmasını ve yanında bir puan eşiğini de arıyor; ikisi de '
    .'burada hesaplanamıyor, kendiniz kontrol edin. Sosyal, Beşeri ve İdari Bilimler\'de dipnot '
    .'iki yollu: TR Dizin puan şartını tutturan adaydan üç, tutturamayandan bir tek yazarlı '
    .'yayın istiyor. Haksız yere elememek için düşük olan yazıldı; koşulunuz daha ağır olabilir.';

$DIL_NOTU = ' Yabancı dil koşulu: Türkçe eğitim yapan bölümlerde merkezi sınavdan en az 55, '
    .'tamamen yabancı dille eğitim yapan bölümlerde en az 85 puan. Bölümün eğitim dili burada '
    .'tutulmadığı için 55 uygulandı.';

$esikler = [];

foreach ($TABLOLAR as $alan => $t) {
    foreach ($KADROLAR as $kadro => $k) {
        $kosul = $t['kosul'][$kadro];
        $madde = "{$t['tablo']} · {$k['ad']}";
        $sira = array_search($kadro, array_keys($KADROLAR), true);

        // Profesörlükte bütün koşullar doçentlik SONRASI dönemi ölçüyor
        // (dipnot 2); yeniden atanmada son atama sonrası.
        $donem = match ($kadro) {
            'profesorluk' => $DOCENTLIK,
            'dr_ogr_uyesi_yeniden' => $SON_ATAMA,
            default => null,
        };

        $cocuklar = [];

        if ($kadro === 'docentlik') {
            $cocuklar[] = Kalip::beyan('Üniversitelerarası Kurul tarafından verilen doçentlik '
                .'unvanına sahip olmak', 'Madde 6');
        }

        if ($kadro === 'profesorluk') {
            $cocuklar[] = Kalip::beyan('Doçentlik unvanını aldıktan sonra, doçentliğe hak '
                .'kazandığınız dönemde yürürlükte olan ÜAK yayın koşullarını yeniden '
                .'sağlamış olmak', 'Madde 7/a');
            $cocuklar[] = Kalip::beyan('Başlıca eser olarak, birinci isim olduğunuz hakemli '
                .'dergi makalesi ya da ISBN\'li basılı kitap veya kitap bölümü göstermek',
                'Madde 7/b');
        }

        if (($kosul['birinciMakale'] ?? false) === true) {
            $cocuklar[] = Kalip::adet('SCI, SSCI, SCI-Expanded ya da AHCI dergilerinde en az '
                .'1 yayın', ['A.1-A.4'], 1, donem: $donem, madde: $madde);
        }

        foreach ($kosul['makale'] as [$grup, $puan]) {
            $ad = $MAKALE_ADI[$grup];
            $cocuklar[] = Kalip::puanDan(
                $grup === 'A'
                    ? "Bütün makale kalemlerinizden en az {$puan} puan"
                    : "{$ad} makalelerinizden en az {$puan} puan",
                [$grup], $puan, $donem, madde: $madde,
            );
        }

        if (isset($kosul['kitap'])) {
            $cocuklar[] = Kalip::puanDan(
                "Kitap ve kitap bölümü kalemlerinizden en az {$kosul['kitap']} puan",
                ['C'], $kosul['kitap'], $donem, madde: $madde,
            );
        }

        if (isset($TEK_YAZAR[$alan][$kadro])) {
            [$sayi, $rol] = $TEK_YAZAR[$alan][$kadro];
            $cocuklar[] = Kalip::adet(
                $rol === 'tek'
                    ? "Bu yayınlardan en az {$sayi} tanesinde tek yazar olmalısınız"
                    : "Bu yayınlardan en az {$sayi} tanesinde birinci isim ya da sorumlu yazar olmalısınız",
                ['A.1-A.8'], $sayi, $rol, $donem,
                madde: $madde.' · dipnot '.($kadro === 'profesorluk' ? '(4)' : '(3)'),
            );
        }

        if (isset($kosul['kitapAdet'])) {
            $cocuklar[] = Kalip::adet(
                "Alanınızla ilgili en az {$kosul['kitapAdet']} kitap ya da kitap bölümü",
                ['C'], $kosul['kitapAdet'],
                donem: $kadro === 'profesorluk' ? $DOCENTLIK : $DOKTORA, madde: $madde,
            );
        }

        $cocuklar = [...$cocuklar, ...$ortakKosullar($kadro, $donem, $madde)];
        $cocuklar[] = Kalip::toplam($k['toplam'], $donem);
        $cocuklar[] = Kalip::yds(55);

        $donemNotu = match ($kadro) {
            'profesorluk' => 'Bütün koşullar DOÇENTLİK unvanınızı aldıktan sonraki '
                .'çalışmalarınızla sağlanmalı. ',
            'dr_ogr_uyesi_yeniden' => 'Bütün koşullar BİR ÖNCEKİ ATANMA tarihinizden sonraki '
                .'çalışmalarınızla sağlanmalı; atama üç yıllık. Koşulları sağlayamazsanız '
                .'yönerge bir defaya mahsus olmak üzere yarısıyla yeniden atanmaya izin '
                .'veriyor. ',
            default => '',
        };

        $esikler[] = [
            'anahtar' => "ordu-{$kadro}-{$alan}",
            'aday_notu' => $donemNotu."{$t['ad']} alanında toplam asgari puan {$k['toplam']}; "
                ."bunun {$ZORUNLU[$alan][$sira]} puanı yukarıdaki kategori alt barajlarından "
                .'gelmek zorunda. Alt barajların her biri ayrı ayrı sağlanmalı, toplamı '
                .'yetmiyor.'.$TAVAN_NOTU.$TEK_YAZAR_NOTU.$DIL_NOTU,
            'universite' => $UNI,
            'kadro' => $kadro,
            'alan' => [$alan],
            'cetvel' => $CETVEL.'-'.$CETVEL_KADRO[$kadro]
            .(isset($KITAP_TAVANI[$alan][$kadro]) ? '-c'.$KITAP_TAVANI[$alan][$kadro] : ''),
            'notlar' => "{$t['tablo']} ({$t['ad']}) — {$k['ad']} sütunu. ZORUNLU ALANLARDA "
                ."ASGARİ PUAN {$ZORUNLU[$alan][$sira]}, TOPLAM ASGARİ PUAN {$k['toplam']}. "
                .'Dipnot (1): M kategorisini sağlayamayan toplam asgari puanın %10\'unu A ve B '
                .'kategorilerinden ilave sağlar. Dipnot (2): profesörlük sütunundaki koşullar '
                .'doçentlik unvanından sonraki dönemi kapsar.',
            'sart' => Kalip::ve("{$k['ad']} kadrosuna atanma — {$t['ad']}", $cocuklar),
        ];
    }
}

return $esikler;
