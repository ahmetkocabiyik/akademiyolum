<?php

/**
 * ANKARA MÜZİK VE GÜZEL SANATLAR ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme
 * ve Atanma Yönergesi
 * Kaynak: pdf/17536929002.ankaramuzikveguzelsanatlaruniversitesi.pdf
 * (26 sayfa, YÖK 03.10.2022/71759 sayılı yazısına dayanılarak hazırlandı;
 * MADDE 15 uyarınca 01.01.2026'dan itibaren yürürlükte)
 *
 * ── YAPI: TEK PUAN CETVELİ, ON BİLİM/SANAT ALANI ──
 * MADDE 6'nın puan tablosu üniversite geneli ortak. MADDE 7-10 (Dr. Öğr.
 * Üyesi ilk atanma / yeniden atanma / doçent / profesör) her kadro için AYNI
 * on satırlık alan tablosunu tekrarlıyor; satırlar yalnızca puan barajıyla ve
 * alanın kendi alt şartıyla ayrışıyor. Toplam puan barajı kadroya bağlı ve
 * alandan bağımsız: 250 / 300 / 600 / 800.
 *
 * ── YENİDEN ATANMA BARAJI İLK ATANMADAN YÜKSEK ──
 * Dr. Öğr. Üyesi ilk atanma 250 puan isterken yeniden atanma 300 istiyor ve
 * MADDE 8 bunu "bir önceki atanmadan sonra yeniden sağlanması" koşuluna
 * bağlıyor — yani üç yılda 300 puan. Korpustaki alışılmış yönde değil ama
 * kaynak böyle; olduğu gibi girildi.
 *
 * ── ALAN → temel alan EŞLEMESİ VE `birim` ZORUNLULUĞU ──
 * Yönergenin on satırı üç temel alana düşüyor ve çoğu aynı temel alanda
 * buluşuyor; motor `bul()` içinde birden fazla aday görünce `birim` ile
 * ayırıyor:
 *
 *   egitim         → Güzel Sanatlar Eğitimi — Müzik Eğitimi
 *                    Güzel Sanatlar Eğitimi — Görsel Sanatlar/Resim/Resim-İş
 *                    Eğitim Bilimleri
 *   guzel_sanatlar → Müzikoloji ve Müzik Teorileri
 *                    Müzik ve Çalgı Teknolojileri
 *                    Yorumculuk, Çalgı Eğitimi ve Ses Eğitimi
 *                    Bestecilik
 *                    Orkestra ve Koro Şefliği
 *                    Sahne Sanatları
 *                    Geleneksel Türk Sanatları, Plastik Sanatlar, Tasarım,
 *                    Radyo-TV ve Sinema
 *   diğer hepsi    → "Diğer Bilim Alanları" satırı (birim yok)
 *
 * "Güzel Sanatlar Eğitimi" ÜAK'ta Eğitim Bilimleri temel alanının alt
 * alanıdır; bu yüzden `egitim`e bağlandı ve orada "Eğitim Bilimleri"
 * satırıyla yan yana durduğu için üçü de `birim` taşıyor.
 *
 * "Diğer Bilim Alanları" satırının kendi dipnotu, "atama kriterlerinde
 * bulunmayan bilim alanları bu koşullara tabidir" diyor; yönergenin anmadığı
 * alanları kapsam dışı bırakma kuralı (KONVANSIYONLAR) burada geçerli değil,
 * çünkü yönerge onları AÇIKÇA bir satıra bağlıyor.
 *
 * ── MAKALE ŞARTI İKİ DALLI ──
 * Sanat alanlarının hepsinde şart "SCI/SCIE/SSCI/AHCI'de en az N VEYA
 * ESCI/Scopus/TR Dizin/uluslararası diğer indeksli dergilerde en az M özgün
 * makale". İki dal `Kalip::veya` ile kuruldu. İkinci dalın kapsamı
 * DARALTILARAK okundu: "ESCI, Scopus, TR Dizin, Uluslararası Diğer indeksli,
 * hakemli dergilerde" ifadesindeki son "hakemli dergiler" ulusal hakemli
 * dergileri de kapsıyor olabilir, ama dar okuma adayı daha zor gösterdiği
 * için ulusal indeksli satır (A1.6) kümeye alınmadı.
 *
 * Eğitim Bilimleri ile Diğer Bilim Alanları'nda ikinci dal YOK: şart yalnızca
 * "A1.1 veya A1.2 kategorisinden en az N özgün makale". Bu iki satır
 * sanat alanlarından belirgin biçimde zor.
 *
 * "Özgün makale" A1 (araştırma makalesi) olarak okundu; derleme A2'de ayrı
 * puanlanıyor. Yalnızca BAŞLICA YAZAR dipnotu her iki türü de sayıyor ("en az
 * bir araştırma makalesi VEYA derleme makalede başlıca yazar olunmalıdır"),
 * o düğüm A1+A2 üstünde kuruldu.
 *
 * ── DOÇENTLİKTE YEDİ YILLIK PENCERE: KESİŞİM ALINDI ──
 * MADDE 9 dipnotu "yayınlar, doktora/sanatta yeterlik unvanı alınmasından
 * sonraki YEDİ YILA ait olmalıdır" diyor. Bu cümle iki türlü okunabiliyor:
 * (a) doktoradan sonraki 0-7. yıllar, (b) başvuru tarihinden geriye 7 yıl.
 * Motorun `sonYil($yil, $baslangic)` düğümü ikisini BİRLİKTE uyguluyor, yani
 * iki okumanın KESİŞİMİNİ alıyor — hangi okuma doğruysa ondan dar, dolayısıyla
 * adayı olduğundan hazır göstermeyen taraf. `Kalip::sonYil(7, 'doktora')`
 * bu yüzden seçildi; aday notunda da iki tarihin birlikte arandığı yazıyor.
 *
 * ── "TEK YAZAR" YOK, "BAŞLICA YAZAR" VAR ──
 * Yönerge hiçbir yerde tek yazarlılık istemiyor; dört kadronun dördünde de
 * dipnot "en az bir makalede başlıca yazar" diyor ve PUANLAMA b bendi
 * "sorumlu yazarın ismi birinci isim olarak alınır" dediği için `baslica`
 * rolü `ilk` ile aynı çarpanı alıyor (bkz. cetvel).
 *
 * ── KAYNAKTAKİ TUTARSIZLIKLAR: OLDUĞU GİBİ GİRİLDİ ──
 *   Yorumculuk/Çalgı Eğitimi/Ses Eğitimi satırında doçentlik "J1.3 ve J1.5
 *       kategorilerine ait ... en az 2'ŞER etkinlik" derken profesörlük aynı
 *       cümleyi "en az 2 (iki) etkinlik" diye yazıyor. Bir ek farkı iki
 *       koşulu ayırıyor (KONVANSIYONLAR'daki İstanbul Yeni Yüzyıl deseni);
 *       ikisi de yazıldığı gibi girildi, yani bu alt şartta profesörlük
 *       doçentlikten HAFİF kalıyor.
 *   Orkestra ve Koro Şefliği'nde doçentlik 4 etkinlik isterken profesörlük 2
 *       istiyor. Aynı sebeple olduğu gibi girildi.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Müzik Eğitimi ile Görsel Sanatlar'ın YENİDEN ATANMA satırındaki "en çok
 *       30 puanı K3, K4, K5, K6" sınırı — bu, koşula özel bir atıf tavanı;
 *       motorun `grup_tavanlari` alanı cetvelin tamamına uygulanıyor, tek bir
 *       koşulun içine sığmıyor. Yazılmadı, aday notunda uyarıldı.
 *   MADDE 5/6 ("her eser aynı kategoride sadece bir kez"), 5/7 ("her faaliyet
 *       bir defa puanlandırılır"), 5/8 ("uluslararası katılımlı ulusal
 *       toplantılar uluslararası sayılmaz") — kayıt disiplini kuralları,
 *       eşiğe çevrilecek sayısal ölçüt taşımıyorlar.
 *   MADDE 11-13 (başvuru evrakı, ön değerlendirme komisyonu, jüri) — idari.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/ankara-mgu-2026.php
 */

use App\Services\Scoring\Sart\Kalip;

$CETVEL = 'ankara-mgu-2026';
$UNIVERSITE = 'Ankara Müzik ve Güzel Sanatlar Üniversitesi';

/** MADDE 9 dipnotu: doktora sonrası VE son yedi yıl — iki okumanın kesişimi. */
$DOKTORA_7YIL = Kalip::sonYil(7, 'doktora');
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

/**
 * Kadro başına değişmeyen çerçeve: toplam baraj, dönem, madde numarası,
 * yabancı dil şartının aranıp aranmadığı ve unvan beyanı.
 *
 * @var array<string, array{toplam: int, donem: array<string, mixed>|null, madde: string, yds: bool, unvan: ?string, ad: string}>
 */
$KADROLAR = [
    'dr_ogr_uyesi' => [
        'toplam' => 250, 'donem' => null, 'madde' => 'Madde 7', 'yds' => true,
        'unvan' => 'Başvurduğunuz bilim alanıyla ilgili bir doktora veya sanatta yeterlik derecesine sahip olmak',
        'ad' => 'Doktor Öğretim Üyesi kadrosuna ilk atanma',
    ],
    'dr_ogr_uyesi_yeniden' => [
        'toplam' => 300, 'donem' => $SON_ATAMA, 'madde' => 'Madde 8', 'yds' => false,
        'unvan' => null,
        'ad' => 'Doktor Öğretim Üyeliğine yeniden atanma',
    ],
    'docentlik' => [
        'toplam' => 600, 'donem' => $DOKTORA_7YIL, 'madde' => 'Madde 9', 'yds' => true,
        'unvan' => 'Doçentlik unvanına sahip olmak',
        'ad' => 'Doçent kadrosuna atanma',
    ],
    'profesorluk' => [
        'toplam' => 800, 'donem' => $DOCENTLIK, 'madde' => 'Madde 10', 'yds' => true,
        'unvan' => 'Doçentlik unvanına sahip olmak',
        'ad' => 'Profesör kadrosuna atanma',
    ],
];

/**
 * Makale adet şartı. Sanat alanlarında iki dallı ("üst indeksten $ust VEYA
 * alt indeksten $alt"), bilim alanlarında tek dallı ($alt null).
 *
 * @return array<string, mixed>
 */
$makaleSarti = function (int $ust, ?int $alt, ?array $donem, string $madde): array {
    $ustDal = Kalip::adet(
        "SCI, SCIE, SSCI veya AHCI kapsamındaki dergilerde en az {$ust} özgün araştırma makaleniz olmalı",
        ['A1.1-A1.2'], $ust, donem: $donem, madde: $madde,
    );

    if ($alt === null) {
        return $ustDal;
    }

    return Kalip::veya('Makale sayısı şartı', [
        $ustDal,
        Kalip::adet(
            "ESCI, Scopus, TR Dizin veya uluslararası diğer indeksli dergilerde en az {$alt} özgün araştırma makaleniz olmalı",
            ['A1.3-A1.4'], $alt, donem: $donem, madde: $madde,
        ),
    ]);
};

/**
 * Bir bilim/sanat alanının dört kadrosunu birden üretir.
 *
 * $alanaOzel, kadro anahtarı → o kadroda eklenecek alt şart listesi.
 *
 * @param  list<string>  $alanlar
 * @param  array<string, list<array<string, mixed>>>  $alanaOzel
 * @param  array<string, int|null>  $ustAdet  kadro → üst indeks makale sayısı
 * @param  array<string, int|null>  $altAdet  kadro → alt indeks makale sayısı
 * @return list<array<string, mixed>>
 */
$alanEsikleri = function (
    string $anahtarOn, string $ad, array $alanlar, ?string $birim,
    array $ustAdet, array $altAdet, array $alanaOzel, array $notlar, array $adayNotlari,
) use ($KADROLAR, $UNIVERSITE, $CETVEL, $makaleSarti): array {
    $uretilen = [];

    foreach ($KADROLAR as $kadro => $c) {
        $cocuklar = [];

        if ($c['yds']) {
            $cocuklar[] = Kalip::yds(65);
        }

        if ($c['unvan'] !== null) {
            $cocuklar[] = Kalip::beyan($c['unvan'], $c['madde']);
        }

        $cocuklar[] = $makaleSarti($ustAdet[$kadro], $altAdet[$kadro], $c['donem'], $c['madde']);
        $cocuklar[] = Kalip::adet(
            'Araştırma veya derleme makalelerinizden en az birinde başlıca yazar olmalısınız',
            ['A1-A2'], 1, yazar: 'baslica', donem: $c['donem'], madde: $c['madde'],
        );

        foreach ($alanaOzel[$kadro] as $ek) {
            $cocuklar[] = $ek;
        }

        $cocuklar[] = Kalip::toplam($c['toplam'], $c['donem']);

        $uretilen[] = [
            'anahtar' => "ankara-mgu-{$anahtarOn}-".str_replace('_', '-', $kadro),
            'aday_notu' => $adayNotlari[$kadro],
            'universite' => $UNIVERSITE,
            'kadro' => $kadro,
            'alan' => $alanlar,
            'birim' => $birim,
            'cetvel' => $CETVEL,
            'notlar' => $notlar[$kadro],
            'sart' => Kalip::ve("{$c['ad']} — {$ad}", $cocuklar),
        ];
    }

    return $uretilen;
};

// Sanat alanlarının dört kadrodaki makale sayıları. Üst indeks (SCI/SCIE/
// SSCI/AHCI) dalı Dr. satırlarında hep 1, doçent ve profesörde alana göre
// 1 ya da 2; alt indeks (ESCI/Scopus/TR Dizin/uluslararası diğer) dalı
// Dr. satırlarında hep 2, doçent ve profesörde 3 ya da 4.
$sanatUst = fn (int $ustUst): array => ['dr_ogr_uyesi' => 1, 'dr_ogr_uyesi_yeniden' => 1, 'docentlik' => $ustUst, 'profesorluk' => $ustUst];
$sanatAlt = fn (int $altUst): array => ['dr_ogr_uyesi' => 2, 'dr_ogr_uyesi_yeniden' => 2, 'docentlik' => $altUst, 'profesorluk' => $altUst];

/** Bilim alanlarının makale sayıları: yalnızca üst indeksten 1 · 1 · 2 · 2. */
$bilimUst = ['dr_ogr_uyesi' => 1, 'dr_ogr_uyesi_yeniden' => 1, 'docentlik' => 2, 'profesorluk' => 2];
$bilimAlt = ['dr_ogr_uyesi' => null, 'dr_ogr_uyesi_yeniden' => null, 'docentlik' => null, 'profesorluk' => null];

/** Kadro başına alt puan barajı; sanat alanlarında 80/100/200/200. */
$sanatBaraj = ['dr_ogr_uyesi' => 80, 'dr_ogr_uyesi_yeniden' => 100, 'docentlik' => 200, 'profesorluk' => 200];

/** Eğitim Bilimleri ve Diğer Bilim Alanları'nda 80/150/250/250. */
$bilimBaraj = ['dr_ogr_uyesi' => 80, 'dr_ogr_uyesi_yeniden' => 150, 'docentlik' => 250, 'profesorluk' => 250];

$esikler = [];

// ══════════════════════════════════════════════════════════════════════════
// GÜZEL SANATLAR EĞİTİMİ — MÜZİK EĞİTİMİ
// ══════════════════════════════════════════════════════════════════════════

$muzikEgitimiKume = ['A1', 'A2', 'B', 'D', 'E', 'F', 'J', 'K'];
$muzikEgitimiKumeAd = 'makale, kitap, proje, bildiri, patent-ödül, sanatsal faaliyet, çeviri ve atıf';
$icraBaraji = ['dr_ogr_uyesi' => 10, 'dr_ogr_uyesi_yeniden' => 10, 'docentlik' => 20, 'profesorluk' => 20];

$esikler = array_merge($esikler, $alanEsikleri(
    'muzik-egitimi',
    'Müzik Eğitimi',
    ['egitim'],
    'Güzel Sanatlar Eğitimi — Müzik Eğitimi',
    $sanatUst(2), $sanatAlt(4),
    array_map(
        fn (string $kadro): array => [
            Kalip::puanDan(
                ucfirst($muzikEgitimiKumeAd)." kalemlerinizden en az {$sanatBaraj[$kadro]} puan",
                $muzikEgitimiKume, $sanatBaraj[$kadro], $KADROLAR[$kadro]['donem'], madde: $KADROLAR[$kadro]['madde'],
            ),
            Kalip::puanDan(
                "Bu puanın en az {$icraBaraji[$kadro]}'i icra (albüm, resital, konser, oda müziği, şeflik, orkestra üyeliği) kalemlerinizden gelmeli",
                ['J1'], $icraBaraji[$kadro], $KADROLAR[$kadro]['donem'], madde: $KADROLAR[$kadro]['madde'],
            ),
        ],
        array_combine(array_keys($KADROLAR), array_keys($KADROLAR)),
    ),
    [
        'dr_ogr_uyesi' => 'Madde 7 (Müzik Eğitimi): SCI-grubunda 1 veya ESCI/Scopus/TR Dizin/uluslararası diğer indekste 2 özgün makale; A1+A2+B+D+E+F+J+K kümesinden 80 puan (10\'u J1); toplam 250.',
        'dr_ogr_uyesi_yeniden' => 'Madde 8 (Müzik Eğitimi): aynı makale şartı; kümeden 100 puan (10\'u J1, en çok 30\'u K3-K6 — bu üst sınır girilemedi); toplam 300, hepsi son atama sonrası.',
        'docentlik' => 'Madde 9 (Müzik Eğitimi): SCI-grubunda 2 veya alt indekste 4 makale; kümeden 200 puan (20\'si J1); toplam 600. Yayınlar doktora sonrası yedi yıl penceresinde.',
        'profesorluk' => 'Madde 10 (Müzik Eğitimi): SCI-grubunda 2 veya alt indekste 4 makale; kümeden 200 puan (20\'si J1); toplam 800, doçentlik sonrası.',
    ],
    [
        'dr_ogr_uyesi' => 'SCI, SCIE, SSCI veya AHCI dergilerinde en az 1 özgün makaleniz (ya da ESCI, Scopus, TR Dizin veya uluslararası diğer indeksli dergilerde en az 2) olmalı; en az bir araştırma ya da derleme makalenizde başlıca yazar olmalısınız. Makale, kitap, proje, bildiri, patent-ödül, sanatsal faaliyet, çeviri ve atıf kalemlerinizden en az 80 puan gerekiyor, bunun en az 10 puanı icra kalemlerinizden gelmeli. Toplamda en az 250 puan aranıyor. Merkezi yabancı dil sınavından en az 65 puan şart.',
        'dr_ogr_uyesi_yeniden' => 'Yeniden atanmada bütün şartlar SON ATAMANIZDAN SONRAKİ çalışmalarınızdan sağlanmalı ve yabancı dil şartı aranmaz. Aynı makale sayısı; belirtilen kalemlerden en az 100 puan (en az 10\'u icra kalemlerinden) ve toplamda en az 300 puan gerekiyor. DİKKAT: yönerge bu satırda atıf kalemlerinizden en çok 30 puanın sayılacağını söylüyor; bu üst sınır hesaplanamadığı için puanınız olduğundan yüksek görünebilir.',
        'docentlik' => 'Doçentlikte yayınlarınızın hem doktora/sanatta yeterlik unvanınızdan sonra hem de son yedi yıl içinde olması aranıyor. SCI, SCIE, SSCI veya AHCI dergilerinde en az 2 özgün makaleniz (ya da alt indeksli dergilerde en az 4) olmalı; en az birinde başlıca yazar olmalısınız. Belirtilen kalemlerden en az 200 puan (en az 20\'si icra kalemlerinden) ve toplamda en az 600 puan gerekiyor.',
        'profesorluk' => 'Profesörlükte DOÇENTLİK UNVANINIZDAN SONRAKİ çalışmalarınıza bakılıyor. SCI, SCIE, SSCI veya AHCI dergilerinde en az 2 özgün makaleniz (ya da alt indeksli dergilerde en az 4) olmalı; en az birinde başlıca yazar olmalısınız. Belirtilen kalemlerden en az 200 puan (en az 20\'si icra kalemlerinden) ve toplamda en az 800 puan gerekiyor.',
    ],
));

// ══════════════════════════════════════════════════════════════════════════
// GÜZEL SANATLAR EĞİTİMİ — GÖRSEL SANATLAR / RESİM / RESİM-İŞ EĞİTİMİ
// ══════════════════════════════════════════════════════════════════════════

$tasarimBaraji = ['dr_ogr_uyesi' => 20, 'dr_ogr_uyesi_yeniden' => 10, 'docentlik' => 40, 'profesorluk' => 40];

$esikler = array_merge($esikler, $alanEsikleri(
    'gorsel-sanatlar',
    'Görsel Sanatlar, Resim ve Resim-İş Eğitimi',
    ['egitim'],
    'Güzel Sanatlar Eğitimi — Görsel Sanatlar, Resim ve Resim-İş Eğitimi',
    $sanatUst(2), $sanatAlt(4),
    array_map(
        fn (string $kadro): array => [
            Kalip::puanDan(
                ucfirst($muzikEgitimiKumeAd)." kalemlerinizden en az {$sanatBaraj[$kadro]} puan",
                $muzikEgitimiKume, $sanatBaraj[$kadro], $KADROLAR[$kadro]['donem'], madde: $KADROLAR[$kadro]['madde'],
            ),
            Kalip::puanDan(
                "Bu puanın en az {$tasarimBaraji[$kadro]}'i tasarım (restorasyon projesi, uygulanmış ya da yayımlanmış sanatsal tasarım) kalemlerinizden gelmeli",
                ['J12'], $tasarimBaraji[$kadro], $KADROLAR[$kadro]['donem'], madde: $KADROLAR[$kadro]['madde'],
            ),
        ],
        array_combine(array_keys($KADROLAR), array_keys($KADROLAR)),
    ),
    [
        'dr_ogr_uyesi' => 'Madde 7 (Görsel Sanatlar/Resim/Resim-İş): makale şartı Müzik Eğitimi ile aynı; kümeden 80 puan (20\'si J12); toplam 250.',
        'dr_ogr_uyesi_yeniden' => 'Madde 8 (Görsel Sanatlar/Resim/Resim-İş): kümeden 100 puan (10\'u J12, en çok 30\'u K3-K6 — girilemedi); toplam 300, son atama sonrası.',
        'docentlik' => 'Madde 9 (Görsel Sanatlar/Resim/Resim-İş): SCI-grubunda 2 veya alt indekste 4 makale; kümeden 200 puan (40\'ı J12); toplam 600.',
        'profesorluk' => 'Madde 10 (Görsel Sanatlar/Resim/Resim-İş): SCI-grubunda 2 veya alt indekste 4 makale; kümeden 200 puan (40\'ı J12); toplam 800, doçentlik sonrası.',
    ],
    [
        'dr_ogr_uyesi' => 'SCI, SCIE, SSCI veya AHCI dergilerinde en az 1 özgün makaleniz (ya da ESCI, Scopus, TR Dizin veya uluslararası diğer indeksli dergilerde en az 2) olmalı; en az bir araştırma ya da derleme makalenizde başlıca yazar olmalısınız. Makale, kitap, proje, bildiri, patent-ödül, sanatsal faaliyet, çeviri ve atıf kalemlerinizden en az 80 puan gerekiyor, bunun en az 20 puanı tasarım kalemlerinizden gelmeli. Toplamda en az 250 puan aranıyor. Merkezi yabancı dil sınavından en az 65 puan şart.',
        'dr_ogr_uyesi_yeniden' => 'Yeniden atanmada bütün şartlar SON ATAMANIZDAN SONRAKİ çalışmalarınızdan sağlanmalı ve yabancı dil şartı aranmaz. Belirtilen kalemlerden en az 100 puan (en az 10\'u tasarım kalemlerinden) ve toplamda en az 300 puan gerekiyor. DİKKAT: yönerge bu satırda atıf kalemlerinizden en çok 30 puanın sayılacağını söylüyor; bu üst sınır hesaplanamadığı için puanınız olduğundan yüksek görünebilir.',
        'docentlik' => 'Doçentlikte yayınlarınızın hem doktora/sanatta yeterlik unvanınızdan sonra hem de son yedi yıl içinde olması aranıyor. SCI, SCIE, SSCI veya AHCI dergilerinde en az 2 özgün makaleniz (ya da alt indeksli dergilerde en az 4) olmalı. Belirtilen kalemlerden en az 200 puan (en az 40\'ı tasarım kalemlerinden) ve toplamda en az 600 puan gerekiyor.',
        'profesorluk' => 'Profesörlükte DOÇENTLİK UNVANINIZDAN SONRAKİ çalışmalarınıza bakılıyor. SCI, SCIE, SSCI veya AHCI dergilerinde en az 2 özgün makaleniz (ya da alt indeksli dergilerde en az 4) olmalı. Belirtilen kalemlerden en az 200 puan (en az 40\'ı tasarım kalemlerinden) ve toplamda en az 800 puan gerekiyor.',
    ],
));

// ══════════════════════════════════════════════════════════════════════════
// EĞİTİM BİLİMLERİ
// ══════════════════════════════════════════════════════════════════════════

$bilimKume = ['A1', 'A2', 'B', 'E', 'K3-K6'];
$bilimKumeAd = 'Makale, kitap, bildiri ve atıf';

/**
 * Eğitim Bilimleri ve Diğer Bilim Alanları'nın tek alt şartı: kümeden puan.
 *
 * @return array<string, list<array<string, mixed>>>
 */
$bilimAltSart = function () use ($KADROLAR, $bilimKume, $bilimKumeAd, $bilimBaraj): array {
    $sonuc = [];

    foreach ($KADROLAR as $kadro => $c) {
        $sonuc[$kadro] = [Kalip::puanDan(
            "{$bilimKumeAd} kalemlerinizden en az {$bilimBaraj[$kadro]} puan",
            $bilimKume, $bilimBaraj[$kadro], $c['donem'], madde: $c['madde'],
        )];
    }

    return $sonuc;
};

$bilimNotlari = fn (string $ad): array => [
    'dr_ogr_uyesi' => "Madde 7 ({$ad}): A1.1 veya A1.2'den en az 1 özgün makale (alt indeks dalı YOK); A1+A2+B+E+K3-K6 kümesinden 80 puan; toplam 250.",
    'dr_ogr_uyesi_yeniden' => "Madde 8 ({$ad}): A1.1 veya A1.2'den en az 1 makale; kümeden 150 puan; toplam 300, son atama sonrası.",
    'docentlik' => "Madde 9 ({$ad}): A1.1 veya A1.2'den en az 2 makale; kümeden 250 puan; toplam 600. Doktora sonrası yedi yıl penceresi.",
    'profesorluk' => "Madde 10 ({$ad}): A1.1 veya A1.2'den en az 2 makale; kümeden 250 puan; toplam 800, doçentlik sonrası.",
];

$bilimAdayNotlari = [
    'dr_ogr_uyesi' => 'Bu alanda makale şartının ESCI/Scopus/TR Dizin dalı YOK: SCI, SCIE, SSCI veya AHCI dergilerinde en az 1 özgün makaleniz olmak zorunda ve en az bir araştırma ya da derleme makalenizde başlıca yazar olmalısınız. Makale, kitap, bildiri ve atıf kalemlerinizden en az 80 puan, toplamda en az 250 puan gerekiyor. Merkezi yabancı dil sınavından en az 65 puan şart.',
    'dr_ogr_uyesi_yeniden' => 'Yeniden atanmada bütün şartlar SON ATAMANIZDAN SONRAKİ çalışmalarınızdan sağlanmalı ve yabancı dil şartı aranmaz. SCI, SCIE, SSCI veya AHCI dergilerinde en az 1 özgün makale; makale, kitap, bildiri ve atıf kalemlerinizden en az 150 puan; toplamda en az 300 puan gerekiyor.',
    'docentlik' => 'Doçentlikte yayınlarınızın hem doktora unvanınızdan sonra hem de son yedi yıl içinde olması aranıyor. SCI, SCIE, SSCI veya AHCI dergilerinde en az 2 özgün makaleniz olmalı, en az birinde başlıca yazar olmalısınız. Makale, kitap, bildiri ve atıf kalemlerinizden en az 250 puan; toplamda en az 600 puan gerekiyor.',
    'profesorluk' => 'Profesörlükte DOÇENTLİK UNVANINIZDAN SONRAKİ çalışmalarınıza bakılıyor. SCI, SCIE, SSCI veya AHCI dergilerinde en az 2 özgün makaleniz olmalı, en az birinde başlıca yazar olmalısınız. Makale, kitap, bildiri ve atıf kalemlerinizden en az 250 puan; toplamda en az 800 puan gerekiyor.',
];

$esikler = array_merge($esikler, $alanEsikleri(
    'egitim-bilimleri',
    'Eğitim Bilimleri',
    ['egitim'],
    'Eğitim Bilimleri',
    $bilimUst, $bilimAlt,
    $bilimAltSart(),
    $bilimNotlari('Eğitim Bilimleri'),
    $bilimAdayNotlari,
));

// ══════════════════════════════════════════════════════════════════════════
// MÜZİK — MÜZİKOLOJİ VE MÜZİK TEORİLERİ
// ══════════════════════════════════════════════════════════════════════════

$muzikKume = ['A1', 'A2', 'B1', 'B2', 'E', 'J', 'K'];
$muzikKumeAd = 'Makale, kitap, ders kitabı, bildiri, sanatsal faaliyet, çeviri ve atıf';

/**
 * Müzikoloji/Teoriler ile Teknolojiler satırlarının tek alt şartı.
 *
 * @param  array<string, list<string>>  $kadroKumeleri
 * @return array<string, list<array<string, mixed>>>
 */
$kumeAltSart = function (array $kadroKumeleri, string $kumeAd) use ($KADROLAR, $sanatBaraj): array {
    $sonuc = [];

    foreach ($KADROLAR as $kadro => $c) {
        $sonuc[$kadro] = [Kalip::puanDan(
            "{$kumeAd} kalemlerinizden en az {$sanatBaraj[$kadro]} puan",
            $kadroKumeleri[$kadro], $sanatBaraj[$kadro], $c['donem'], madde: $c['madde'],
        )];
    }

    return $sonuc;
};

$esikler = array_merge($esikler, $alanEsikleri(
    'muzikoloji',
    'Müzikoloji ve Müzik Teorileri',
    ['guzel_sanatlar'],
    'Müzik — Müzikoloji ve Müzik Teorileri',
    $sanatUst(2), $sanatAlt(4),
    $kumeAltSart(array_fill_keys(array_keys($KADROLAR), $muzikKume), $muzikKumeAd),
    [
        'dr_ogr_uyesi' => 'Madde 7 (Müzikoloji ve Müzik Teorileri): A1+A2+B1+B2+E+J+K kümesinden 80 puan; toplam 250.',
        'dr_ogr_uyesi_yeniden' => 'Madde 8 (Müzikoloji ve Müzik Teorileri): kümeden 100 puan; toplam 300, son atama sonrası.',
        'docentlik' => 'Madde 9 (Müzikoloji ve Müzik Teorileri): SCI-grubunda 2 veya alt indekste 4 makale; kümeden 200 puan; toplam 600.',
        'profesorluk' => 'Madde 10 (Müzikoloji ve Müzik Teorileri): SCI-grubunda 2 veya alt indekste 4 makale; kümeden 200 puan; toplam 800, doçentlik sonrası.',
    ],
    [
        'dr_ogr_uyesi' => 'SCI, SCIE, SSCI veya AHCI dergilerinde en az 1 özgün makaleniz (ya da ESCI, Scopus, TR Dizin veya uluslararası diğer indeksli dergilerde en az 2) olmalı; en az bir araştırma ya da derleme makalenizde başlıca yazar olmalısınız. Makale, kitap, ders kitabı, bildiri, sanatsal faaliyet, çeviri ve atıf kalemlerinizden en az 80 puan; toplamda en az 250 puan gerekiyor. Merkezi yabancı dil sınavından en az 65 puan şart.',
        'dr_ogr_uyesi_yeniden' => 'Yeniden atanmada bütün şartlar SON ATAMANIZDAN SONRAKİ çalışmalarınızdan sağlanmalı ve yabancı dil şartı aranmaz. Belirtilen kalemlerden en az 100 puan; toplamda en az 300 puan gerekiyor.',
        'docentlik' => 'Doçentlikte yayınlarınızın hem doktora/sanatta yeterlik unvanınızdan sonra hem de son yedi yıl içinde olması aranıyor. SCI, SCIE, SSCI veya AHCI dergilerinde en az 2 özgün makaleniz (ya da alt indeksli dergilerde en az 4) olmalı. Belirtilen kalemlerden en az 200 puan; toplamda en az 600 puan gerekiyor.',
        'profesorluk' => 'Profesörlükte DOÇENTLİK UNVANINIZDAN SONRAKİ çalışmalarınıza bakılıyor. SCI, SCIE, SSCI veya AHCI dergilerinde en az 2 özgün makaleniz (ya da alt indeksli dergilerde en az 4) olmalı. Belirtilen kalemlerden en az 200 puan; toplamda en az 800 puan gerekiyor.',
    ],
));

// ══════════════════════════════════════════════════════════════════════════
// MÜZİK — MÜZİK VE ÇALGI TEKNOLOJİLERİ
// Doçentlik ve profesörlükte kümeye PROJE (D) ekleniyor; Dr. satırlarında yok.
// ══════════════════════════════════════════════════════════════════════════

$teknolojiKumeleri = [
    'dr_ogr_uyesi' => $muzikKume,
    'dr_ogr_uyesi_yeniden' => $muzikKume,
    'docentlik' => ['A1', 'A2', 'B1', 'B2', 'D', 'E', 'J', 'K'],
    'profesorluk' => ['A1', 'A2', 'B1', 'B2', 'D', 'E', 'J', 'K'],
];

$esikler = array_merge($esikler, $alanEsikleri(
    'muzik-teknolojileri',
    'Müzik ve Çalgı Teknolojileri',
    ['guzel_sanatlar'],
    'Müzik — Müzik ve Çalgı Teknolojileri',
    $sanatUst(2), $sanatAlt(4),
    $kumeAltSart($teknolojiKumeleri, 'Makale, kitap, ders kitabı, proje, bildiri, sanatsal faaliyet, çeviri ve atıf'),
    [
        'dr_ogr_uyesi' => 'Madde 7 (Müzik/Çalgı Teknolojileri): A1+A2+B1+B2+E+J+K kümesinden 80 puan; toplam 250.',
        'dr_ogr_uyesi_yeniden' => 'Madde 8 (Müzik/Çalgı Teknolojileri): aynı kümeden 100 puan; toplam 300, son atama sonrası.',
        'docentlik' => 'Madde 9 (Müzik/Çalgı Teknolojileri): küme burada PROJE (D) ile genişliyor; A1+A2+B1+B2+D+E+J+K\'dan 200 puan; toplam 600.',
        'profesorluk' => 'Madde 10 (Müzik/Çalgı Teknolojileri): küme yine D içeriyor; 200 puan; toplam 800, doçentlik sonrası.',
    ],
    [
        'dr_ogr_uyesi' => 'SCI, SCIE, SSCI veya AHCI dergilerinde en az 1 özgün makaleniz (ya da ESCI, Scopus, TR Dizin veya uluslararası diğer indeksli dergilerde en az 2) olmalı; en az bir araştırma ya da derleme makalenizde başlıca yazar olmalısınız. Makale, kitap, ders kitabı, bildiri, sanatsal faaliyet, çeviri ve atıf kalemlerinizden en az 80 puan; toplamda en az 250 puan gerekiyor. Merkezi yabancı dil sınavından en az 65 puan şart. Not: bu alanda müzik ve çalgı teknolojisi kalemlerinin (kayıt-mix-mastering, MIDI, akustik düzenleme, çalgı yapımı) çoğu faaliyet kaydına girilemediği için puanınız olduğundan düşük görünebilir.',
        'dr_ogr_uyesi_yeniden' => 'Yeniden atanmada bütün şartlar SON ATAMANIZDAN SONRAKİ çalışmalarınızdan sağlanmalı ve yabancı dil şartı aranmaz. Belirtilen kalemlerden en az 100 puan; toplamda en az 300 puan gerekiyor. Müzik ve çalgı teknolojisi kalemleri girilemediği için puanınız olduğundan düşük görünebilir.',
        'docentlik' => 'Doçentlikte yayınlarınızın hem doktora/sanatta yeterlik unvanınızdan sonra hem de son yedi yıl içinde olması aranıyor; bu kadroda puan kümesine PROJELER de dâhil. SCI, SCIE, SSCI veya AHCI dergilerinde en az 2 özgün makaleniz (ya da alt indeksli dergilerde en az 4) olmalı. Belirtilen kalemlerden en az 200 puan; toplamda en az 600 puan gerekiyor.',
        'profesorluk' => 'Profesörlükte DOÇENTLİK UNVANINIZDAN SONRAKİ çalışmalarınıza bakılıyor; puan kümesine projeler de dâhil. SCI, SCIE, SSCI veya AHCI dergilerinde en az 2 özgün makaleniz (ya da alt indeksli dergilerde en az 4) olmalı. Belirtilen kalemlerden en az 200 puan; toplamda en az 800 puan gerekiyor.',
    ],
));

// ══════════════════════════════════════════════════════════════════════════
// MÜZİK — YORUMCULUK, ÇALGI EĞİTİMİ VE SES EĞİTİMİ
// Alt şart yalnızca solo sahne performansı (J1.3) ve oda müziği (J1.5)
// etkinliklerine bağlı; genel kategori barajı yok.
// ══════════════════════════════════════════════════════════════════════════

$yorumculukAd = 'Solo sahne performansı (resital, dinleti) ve oda müziği/topluluk konseri';

$esikler = array_merge($esikler, $alanEsikleri(
    'yorumculuk',
    'Yorumculuk, Çalgı Eğitimi ve Ses Eğitimi',
    ['guzel_sanatlar'],
    'Müzik — Yorumculuk, Çalgı Eğitimi ve Ses Eğitimi',
    $sanatUst(1), $sanatAlt(3),
    [
        'dr_ogr_uyesi' => [
            Kalip::adet('En az 1 solo sahne performansınız (resital, dinleti) olmalı', ['J1.3'], 1, madde: 'Madde 7'),
            Kalip::adet('En az 2 oda müziği veya topluluk konseriniz olmalı', ['J1.5'], 2, madde: 'Madde 7'),
            Kalip::puanDan("{$yorumculukAd} kalemlerinizden en az 80 puan", ['J1.3-J1.5'], 80, madde: 'Madde 7'),
        ],
        'dr_ogr_uyesi_yeniden' => [
            Kalip::adet('Son atamanızdan sonra en az 1 solo sahne performansınız olmalı', ['J1.3'], 1, donem: $SON_ATAMA, madde: 'Madde 8'),
            Kalip::adet('Son atamanızdan sonra en az 3 oda müziği veya topluluk konseriniz olmalı', ['J1.5'], 3, donem: $SON_ATAMA, madde: 'Madde 8'),
            Kalip::puanDan("{$yorumculukAd} kalemlerinizden en az 100 puan", ['J1.3-J1.5'], 100, $SON_ATAMA, madde: 'Madde 8'),
        ],
        'docentlik' => [
            Kalip::adet('Farklı programlar içeren en az 2 solo sahne performansınız olmalı', ['J1.3'], 2, donem: $DOKTORA_7YIL, madde: 'Madde 9'),
            Kalip::adet('Farklı programlar içeren en az 2 oda müziği veya topluluk konseriniz olmalı', ['J1.5'], 2, donem: $DOKTORA_7YIL, madde: 'Madde 9'),
            Kalip::puanDan("{$yorumculukAd} kalemlerinizden en az 200 puan", ['J1.3-J1.5'], 200, $DOKTORA_7YIL, madde: 'Madde 9'),
        ],
        // Profesörlük paragrafı "en az 2 (iki) etkinlik" diyor, doçentlikteki
        // "2'şer" ekini taşımıyor; kaynağa sadık kalındı (bkz. dosya başlığı).
        'profesorluk' => [
            Kalip::adet('Farklı programlara sahip en az 2 solo sahne performansı ya da oda müziği konseriniz olmalı', ['J1.3-J1.5'], 2, donem: $DOCENTLIK, madde: 'Madde 10'),
            Kalip::puanDan("{$yorumculukAd} kalemlerinizden en az 200 puan", ['J1.3-J1.5'], 200, $DOCENTLIK, madde: 'Madde 10'),
        ],
    ],
    [
        'dr_ogr_uyesi' => 'Madde 7 (Yorumculuk/Çalgı Eğitimi/Ses Eğitimi): J1.3\'ten 1, J1.5\'ten 2 etkinlik ve bu ikisinden 80 puan; toplam 250.',
        'dr_ogr_uyesi_yeniden' => 'Madde 8: J1.3\'ten 1, J1.5\'ten 3 etkinlik ve 100 puan; toplam 300, son atama sonrası.',
        'docentlik' => 'Madde 9: J1.3 ve J1.5\'ten farklı programlı 2\'ŞER etkinlik ve 200 puan; toplam 600.',
        'profesorluk' => 'Madde 10: kaynak burada "2\'şer" değil "en az 2 (iki) etkinlik" diyor — doçentlikten hafif kalan bu ifade olduğu gibi girildi; 200 puan; toplam 800, doçentlik sonrası.',
    ],
    [
        'dr_ogr_uyesi' => 'SCI, SCIE, SSCI veya AHCI dergilerinde en az 1 özgün makaleniz (ya da ESCI, Scopus, TR Dizin veya uluslararası diğer indeksli dergilerde en az 2) olmalı; en az bir araştırma ya da derleme makalenizde başlıca yazar olmalısınız. Ayrıca en az 1 solo sahne performansınız ve 2 oda müziği/topluluk konseriniz olmalı, bu etkinliklerden en az 80 puan toplamalısınız. Toplamda en az 250 puan ve merkezi yabancı dil sınavından en az 65 puan gerekiyor.',
        'dr_ogr_uyesi_yeniden' => 'Yeniden atanmada bütün şartlar SON ATAMANIZDAN SONRAKİ çalışmalarınızdan sağlanmalı ve yabancı dil şartı aranmaz: en az 1 solo sahne performansı, 3 oda müziği/topluluk konseri ve bunlardan en az 100 puan; toplamda en az 300 puan gerekiyor.',
        'docentlik' => 'Doçentlikte yayın ve etkinliklerinizin hem doktora/sanatta yeterlik unvanınızdan sonra hem de son yedi yıl içinde olması aranıyor. SCI, SCIE, SSCI veya AHCI dergilerinde en az 1 özgün makaleniz (ya da alt indeksli dergilerde en az 3) olmalı. Ayrıca farklı programlar içeren en az 2 solo sahne performansı ve 2 oda müziği/topluluk konseri ile bunlardan en az 200 puan; toplamda en az 600 puan gerekiyor.',
        'profesorluk' => 'Profesörlükte DOÇENTLİK UNVANINIZDAN SONRAKİ çalışmalarınıza bakılıyor. SCI, SCIE, SSCI veya AHCI dergilerinde en az 1 özgün makaleniz (ya da alt indeksli dergilerde en az 3) olmalı. Ayrıca farklı programlara sahip en az 2 solo sahne performansı ya da oda müziği konseri ve bunlardan en az 200 puan; toplamda en az 800 puan gerekiyor.',
    ],
));

// ══════════════════════════════════════════════════════════════════════════
// MÜZİK — BESTECİLİK
// ══════════════════════════════════════════════════════════════════════════

$besteAdet = ['dr_ogr_uyesi' => 3, 'dr_ogr_uyesi_yeniden' => 3, 'docentlik' => 4, 'profesorluk' => 4];

$esikler = array_merge($esikler, $alanEsikleri(
    'bestecilik',
    'Bestecilik',
    ['guzel_sanatlar'],
    'Müzik — Bestecilik',
    $sanatUst(1), $sanatAlt(3),
    array_map(
        fn (string $kadro): array => [
            Kalip::adet(
                "Bestecilik kalemlerinizde en az {$besteAdet[$kadro]} farklı eseriniz olmalı",
                ['J5'], $besteAdet[$kadro], donem: $KADROLAR[$kadro]['donem'], madde: $KADROLAR[$kadro]['madde'],
            ),
            Kalip::puanDan(
                "Bestecilik kalemlerinizden en az {$sanatBaraj[$kadro]} puan",
                ['J5'], $sanatBaraj[$kadro], $KADROLAR[$kadro]['donem'], madde: $KADROLAR[$kadro]['madde'],
            ),
        ],
        array_combine(array_keys($KADROLAR), array_keys($KADROLAR)),
    ),
    [
        'dr_ogr_uyesi' => 'Madde 7 (Bestecilik): J5\'ten 3 farklı etkinlik ve 80 puan; toplam 250.',
        'dr_ogr_uyesi_yeniden' => 'Madde 8 (Bestecilik): J5\'ten 3 farklı etkinlik ve 100 puan; toplam 300, son atama sonrası.',
        'docentlik' => 'Madde 9 (Bestecilik): J5\'ten 4 farklı etkinlik ve 200 puan; toplam 600.',
        'profesorluk' => 'Madde 10 (Bestecilik): J5\'ten 4 farklı etkinlik ve 200 puan; toplam 800, doçentlik sonrası.',
    ],
    [
        'dr_ogr_uyesi' => 'SCI, SCIE, SSCI veya AHCI dergilerinde en az 1 özgün makaleniz (ya da ESCI, Scopus, TR Dizin veya uluslararası diğer indeksli dergilerde en az 2) olmalı; en az bir araştırma ya da derleme makalenizde başlıca yazar olmalısınız. Ayrıca en az 3 farklı besteniz ve bestecilik kalemlerinizden en az 80 puan gerekiyor. Toplamda en az 250 puan ve merkezi yabancı dil sınavından en az 65 puan aranıyor. Bestelerinizi türüne uygun seçenekle (opera, senfonik eser, oda müziği, eğitim müziği vb.) kaydedin.',
        'dr_ogr_uyesi_yeniden' => 'Yeniden atanmada bütün şartlar SON ATAMANIZDAN SONRAKİ çalışmalarınızdan sağlanmalı ve yabancı dil şartı aranmaz: en az 3 farklı beste ve bestecilik kalemlerinizden en az 100 puan; toplamda en az 300 puan gerekiyor.',
        'docentlik' => 'Doçentlikte yayın ve eserlerinizin hem doktora/sanatta yeterlik unvanınızdan sonra hem de son yedi yıl içinde olması aranıyor. SCI, SCIE, SSCI veya AHCI dergilerinde en az 1 özgün makaleniz (ya da alt indeksli dergilerde en az 3) olmalı. Ayrıca en az 4 farklı beste ve bestecilik kalemlerinizden en az 200 puan; toplamda en az 600 puan gerekiyor.',
        'profesorluk' => 'Profesörlükte DOÇENTLİK UNVANINIZDAN SONRAKİ çalışmalarınıza bakılıyor. SCI, SCIE, SSCI veya AHCI dergilerinde en az 1 özgün makaleniz (ya da alt indeksli dergilerde en az 3) olmalı. Ayrıca en az 4 farklı beste ve bestecilik kalemlerinizden en az 200 puan; toplamda en az 800 puan gerekiyor.',
    ],
));

// ══════════════════════════════════════════════════════════════════════════
// MÜZİK — ORKESTRA VE KORO ŞEFLİĞİ
// ══════════════════════════════════════════════════════════════════════════

$seflikAdet = ['dr_ogr_uyesi' => 2, 'dr_ogr_uyesi_yeniden' => 2, 'docentlik' => 4, 'profesorluk' => 2];

$esikler = array_merge($esikler, $alanEsikleri(
    'orkestra-koro-sefligi',
    'Orkestra ve Koro Şefliği',
    ['guzel_sanatlar'],
    'Müzik — Orkestra ve Koro Şefliği',
    $sanatUst(1), $sanatAlt(3),
    array_map(
        fn (string $kadro): array => [
            Kalip::adet(
                "En az {$seflikAdet[$kadro]} şeflik etkinliğiniz olmalı",
                ['J6'], $seflikAdet[$kadro], donem: $KADROLAR[$kadro]['donem'], madde: $KADROLAR[$kadro]['madde'],
            ),
            Kalip::puanDan(
                "Şeflik kalemlerinizden en az {$sanatBaraj[$kadro]} puan",
                ['J6'], $sanatBaraj[$kadro], $KADROLAR[$kadro]['donem'], madde: $KADROLAR[$kadro]['madde'],
            ),
        ],
        array_combine(array_keys($KADROLAR), array_keys($KADROLAR)),
    ),
    [
        'dr_ogr_uyesi' => 'Madde 7 (Orkestra ve Koro Şefliği): J6\'dan 2 etkinlik ve 80 puan; toplam 250.',
        'dr_ogr_uyesi_yeniden' => 'Madde 8: J6\'dan 2 etkinlik ve 100 puan; toplam 300, son atama sonrası.',
        'docentlik' => 'Madde 9: J6\'dan 4 etkinlik ve 200 puan; toplam 600.',
        'profesorluk' => 'Madde 10: kaynak burada doçentlikteki 4 yerine 2 etkinlik istiyor; olduğu gibi girildi. 200 puan; toplam 800, doçentlik sonrası.',
    ],
    [
        'dr_ogr_uyesi' => 'SCI, SCIE, SSCI veya AHCI dergilerinde en az 1 özgün makaleniz (ya da ESCI, Scopus, TR Dizin veya uluslararası diğer indeksli dergilerde en az 2) olmalı; en az bir araştırma ya da derleme makalenizde başlıca yazar olmalısınız. Ayrıca en az 2 şeflik etkinliğiniz ve şeflik kalemlerinizden en az 80 puan gerekiyor. Toplamda en az 250 puan ve merkezi yabancı dil sınavından en az 65 puan aranıyor.',
        'dr_ogr_uyesi_yeniden' => 'Yeniden atanmada bütün şartlar SON ATAMANIZDAN SONRAKİ çalışmalarınızdan sağlanmalı ve yabancı dil şartı aranmaz: en az 2 şeflik etkinliği ve şeflik kalemlerinizden en az 100 puan; toplamda en az 300 puan gerekiyor.',
        'docentlik' => 'Doçentlikte yayın ve etkinliklerinizin hem doktora/sanatta yeterlik unvanınızdan sonra hem de son yedi yıl içinde olması aranıyor. SCI, SCIE, SSCI veya AHCI dergilerinde en az 1 özgün makaleniz (ya da alt indeksli dergilerde en az 3) olmalı. Ayrıca en az 4 şeflik etkinliği ve şeflik kalemlerinizden en az 200 puan; toplamda en az 600 puan gerekiyor.',
        'profesorluk' => 'Profesörlükte DOÇENTLİK UNVANINIZDAN SONRAKİ çalışmalarınıza bakılıyor. SCI, SCIE, SSCI veya AHCI dergilerinde en az 1 özgün makaleniz (ya da alt indeksli dergilerde en az 3) olmalı. Ayrıca en az 2 şeflik etkinliği ve şeflik kalemlerinizden en az 200 puan; toplamda en az 800 puan gerekiyor.',
    ],
));

// ══════════════════════════════════════════════════════════════════════════
// SAHNE SANATLARI
// Kaynak "J11.4'ten en az 1, J11.5'ten en az 2 etkinlik" diyor; tam oyunda ve
// kısa eserde rol alma cetvelde TEK satıra düştüğü için (bkz. cetvel başlığı)
// ayrım korunamadı ve iki sayı TOPLAMI (3) tek koşul olarak yazıldı.
// ══════════════════════════════════════════════════════════════════════════

$esikler = array_merge($esikler, $alanEsikleri(
    'sahne-sanatlari',
    'Sahne Sanatları',
    ['guzel_sanatlar'],
    'Sahne Sanatları',
    $sanatUst(1), $sanatAlt(3),
    array_map(
        fn (string $kadro): array => [
            Kalip::adet(
                'Tiyatro oyunlarında en az 3 rolünüz olmalı',
                ['J11.4-J11.5'], 3, donem: $KADROLAR[$kadro]['donem'], madde: $KADROLAR[$kadro]['madde'],
            ),
            Kalip::puanDan(
                "Tiyatro oyununda rol alma kalemlerinizden en az {$sanatBaraj[$kadro]} puan",
                ['J11.4-J11.5'], $sanatBaraj[$kadro], $KADROLAR[$kadro]['donem'], madde: $KADROLAR[$kadro]['madde'],
            ),
        ],
        array_combine(array_keys($KADROLAR), array_keys($KADROLAR)),
    ),
    [
        'dr_ogr_uyesi' => 'Madde 7 (Sahne Sanatları): J11.4\'ten 1 + J11.5\'ten 2 etkinlik (cetvelde tek satır olduğu için toplam 3 olarak yazıldı) ve 80 puan; toplam 250.',
        'dr_ogr_uyesi_yeniden' => 'Madde 8 (Sahne Sanatları): aynı adet, 100 puan; toplam 300, son atama sonrası.',
        'docentlik' => 'Madde 9 (Sahne Sanatları): aynı adet, 200 puan; toplam 600.',
        'profesorluk' => 'Madde 10 (Sahne Sanatları): aynı adet, 200 puan; toplam 800, doçentlik sonrası.',
    ],
    [
        'dr_ogr_uyesi' => 'SCI, SCIE, SSCI veya AHCI dergilerinde en az 1 özgün makaleniz (ya da ESCI, Scopus, TR Dizin veya uluslararası diğer indeksli dergilerde en az 2) olmalı; en az bir araştırma ya da derleme makalenizde başlıca yazar olmalısınız. Ayrıca tiyatro oyunlarında en az 3 rolünüz (yönergede: tam oyunda 1, kısa eserde 2) ve bu kalemlerden en az 80 puan gerekiyor. Toplamda en az 250 puan ve merkezi yabancı dil sınavından en az 65 puan aranıyor.',
        'dr_ogr_uyesi_yeniden' => 'Yeniden atanmada bütün şartlar SON ATAMANIZDAN SONRAKİ çalışmalarınızdan sağlanmalı ve yabancı dil şartı aranmaz: tiyatro oyunlarında en az 3 rol ve bu kalemlerden en az 100 puan; toplamda en az 300 puan gerekiyor.',
        'docentlik' => 'Doçentlikte yayın ve etkinliklerinizin hem doktora/sanatta yeterlik unvanınızdan sonra hem de son yedi yıl içinde olması aranıyor. SCI, SCIE, SSCI veya AHCI dergilerinde en az 1 özgün makaleniz (ya da alt indeksli dergilerde en az 3) olmalı. Ayrıca tiyatro oyunlarında en az 3 rol ve bu kalemlerden en az 200 puan; toplamda en az 600 puan gerekiyor.',
        'profesorluk' => 'Profesörlükte DOÇENTLİK UNVANINIZDAN SONRAKİ çalışmalarınıza bakılıyor. SCI, SCIE, SSCI veya AHCI dergilerinde en az 1 özgün makaleniz (ya da alt indeksli dergilerde en az 3) olmalı. Ayrıca tiyatro oyunlarında en az 3 rol ve bu kalemlerden en az 200 puan; toplamda en az 800 puan gerekiyor.',
    ],
));

// ══════════════════════════════════════════════════════════════════════════
// GELENEKSEL TÜRK SANATLARI, PLASTİK SANATLAR, TASARIM, RADYO-TV VE SİNEMA
// ══════════════════════════════════════════════════════════════════════════

$esikler = array_merge($esikler, $alanEsikleri(
    'gts-plastik-tasarim',
    'Geleneksel Türk Sanatları, Plastik Sanatlar, Tasarım, Radyo-TV ve Sinema',
    ['guzel_sanatlar'],
    'Geleneksel Türk Sanatları, Plastik Sanatlar, Tasarım, Radyo-TV ve Sinema',
    $sanatUst(1), $sanatAlt(3),
    $kumeAltSart(array_fill_keys(array_keys($KADROLAR), $muzikKume), $muzikKumeAd),
    [
        'dr_ogr_uyesi' => 'Madde 7 (GTS/Plastik/Tasarım/Radyo-TV-Sinema): A1+A2+B1+B2+E+J+K kümesinden 80 puan; toplam 250.',
        'dr_ogr_uyesi_yeniden' => 'Madde 8: kümeden 100 puan; toplam 300, son atama sonrası.',
        'docentlik' => 'Madde 9: SCI-grubunda 1 veya alt indekste 3 makale; kümeden 200 puan; toplam 600.',
        'profesorluk' => 'Madde 10: SCI-grubunda 1 veya alt indekste 3 makale; kümeden 200 puan; toplam 800, doçentlik sonrası.',
    ],
    [
        'dr_ogr_uyesi' => 'SCI, SCIE, SSCI veya AHCI dergilerinde en az 1 özgün makaleniz (ya da ESCI, Scopus, TR Dizin veya uluslararası diğer indeksli dergilerde en az 2) olmalı; en az bir araştırma ya da derleme makalenizde başlıca yazar olmalısınız. Makale, kitap, ders kitabı, bildiri, sanatsal faaliyet, çeviri ve atıf kalemlerinizden en az 80 puan; toplamda en az 250 puan gerekiyor. Merkezi yabancı dil sınavından en az 65 puan şart. Not: TV ve radyo program görevleri ile logo, afiş ve kapak tasarımı kalemleri faaliyet kaydına girilemediği için puanınız olduğundan düşük görünebilir.',
        'dr_ogr_uyesi_yeniden' => 'Yeniden atanmada bütün şartlar SON ATAMANIZDAN SONRAKİ çalışmalarınızdan sağlanmalı ve yabancı dil şartı aranmaz. Belirtilen kalemlerden en az 100 puan; toplamda en az 300 puan gerekiyor.',
        'docentlik' => 'Doçentlikte yayınlarınızın hem doktora/sanatta yeterlik unvanınızdan sonra hem de son yedi yıl içinde olması aranıyor. SCI, SCIE, SSCI veya AHCI dergilerinde en az 1 özgün makaleniz (ya da alt indeksli dergilerde en az 3) olmalı. Belirtilen kalemlerden en az 200 puan; toplamda en az 600 puan gerekiyor.',
        'profesorluk' => 'Profesörlükte DOÇENTLİK UNVANINIZDAN SONRAKİ çalışmalarınıza bakılıyor. SCI, SCIE, SSCI veya AHCI dergilerinde en az 1 özgün makaleniz (ya da alt indeksli dergilerde en az 3) olmalı. Belirtilen kalemlerden en az 200 puan; toplamda en az 800 puan gerekiyor.',
    ],
));

// ══════════════════════════════════════════════════════════════════════════
// DİĞER BİLİM ALANLARI
// "Üniversitenin atama kriterlerinde bulunmayan bilim alanları bu koşullara
// tabidir" dipnotu; Eğitim Bilimleri satırıyla birebir aynı koşullar.
// ══════════════════════════════════════════════════════════════════════════

$esikler = array_merge($esikler, $alanEsikleri(
    'diger-bilim',
    'Diğer Bilim Alanları',
    ['sosyal', 'fen', 'muhendislik', 'saglik', 'hukuk', 'filoloji', 'ilahiyat',
        'mimarlik', 'ziraat', 'spor'],
    null,
    $bilimUst, $bilimAlt,
    $bilimAltSart(),
    $bilimNotlari('Diğer Bilim Alanları'),
    $bilimAdayNotlari,
));

return $esikler;
