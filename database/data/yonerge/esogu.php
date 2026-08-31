<?php

/**
 * ESKİŞEHİR OSMANGAZİ ÜNİVERSİTESİ — Akademik Yükseltilme ve Atanma
 * İlkeleri
 * Kaynak: pdf/17536993862.eskisehirosmangaziuniverstesi.pdf (17 sayfa;
 * 17.05.2023-15/6 Senato Kararı ve 15.06.2023 YÖK Genel Kurul Kararı ile
 * değişik)
 *
 * ── YAPI: TEK PUAN TABLOSU, "EN AZ BİRİNİ SAĞLA" LİSTELERİ ──
 * Puan tablosu üniversite geneli ortak; alan ayrımı yalnızca Dr. Öğr.
 * Üyesi ilk atanmanın yayın şartında (Madde 2.2 ↔ 2.3) ve Madde 2.4'ün alt
 * barajında (Tıp ve Diş Hekimliği 30, diğer birimler 40) var. Kadroların
 * asıl deseni ise şu: bir toplam puan barajı + arkasından "aşağıdaki
 * şartlardan en az birini sağlamış olmak" diye açılan seçenek listeleri
 * (Madde 2.5, 3.2, 4.6, 4.7, 5.6, 5.7). Hepsi `Kalip::veya` ile kuruldu.
 *
 * ── ALAN AYRIMI ──
 *   Madde 2.2 (Fen, Mühendislik, Sağlık) → fen, muhendislik, saglik:
 *       en az biri Q1-Q4 ya da tez yayını Q1-Q4 kapsamında olmak üzere,
 *       Q1-Q4 + alan indeksi + diğer uluslararası kümesinden 2 yayın.
 *   Madde 2.3 (diğer alanlar) → 2.2'yi sağlamak VEYA yalnızca alan indeksi
 *       ve diğer uluslararası dergilerden 3 yayın.
 *   Madde 2.4: Tıp ve Diş Hekimliği Fakültesi için 30, diğer birimler için
 *       40 puanlık alt baraj; toplam 60. Sağlık temel alanı bu yüzden iki
 *       `birim`e ayrıldı.
 *
 * Yönergenin anmadığı bir temel alan yok (2.3 "diğer alanlar" diyerek
 * hepsini kapsıyor), o yüzden on iki temel alanın tamamı girildi.
 *
 * ── DOÇENT UNVANLI DR. ÖĞR. ÜYESİNE YENİDEN ATANMADA KOŞUL YOK ──
 * Madde 3: "Doçent unvanına sahip olan Doktor Öğretim Üyelerinde yeniden
 * atanma için asgari koşul aranmaz." Bu bir MUAFİYET ve profilden
 * okunamıyor (adayın doçentlik unvanı olup olmadığı ayrı bir alan değil);
 * yeniden atanma eşiği koşullarıyla yazıldı ve aday notunda muafiyet
 * hatırlatıldı.
 *
 * ── "SON 4 YIL" PENCERESİ ──
 * Madde 3.1 ve 3.2 yeniden atanmada açıkça "son 4 yılda yapılan
 * çalışmalar" diyor; `Kalip::sonYil(4)` ile kuruldu. Motorun
 * `SON_ATAMA_SONRASI` dönemi yerine kayan pencere seçildi çünkü kaynak
 * atama tarihine değil, dört yıla bağlıyor.
 *
 * ── 4.6c / 4.7ç VE 5.6c / 5.7ç ÇAKIŞMA NOTU ──
 * Yönerge iki yerde "Madde 4.6c kullanılması durumunda Madde 4.7ç
 * kullanılamaz" diyor: aynı 300 (profesörlükte 450) puanlık toplam iki ayrı
 * seçenek listesinde birden seçenek olarak duruyor ve aday ikisinde birden
 * kullanamıyor. Motorda "bir düğüm iki kez sayılmasın" kısıtı yok; iki
 * listede de puan seçeneği duruyor, dolayısıyla yalnızca puanla ilerleyen
 * aday burada olduğundan HAZIR görünebilir. Aday notunda uyarıldı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde 2.5a, 3.2a, 4.7a, 5.7a (yurt dışında 3 ya da 6 ay çalışmış
 *       olmak) — süre ve kurum bilgisi profilde yok.
 *   Madde 4.7c ve 5.7c (teknoloji geliştirme bölgesinde en az 2 yıl
 *       faaliyet gösteren şirket sahibi olmak) — cetvelde 5ç satırı var
 *       ama "en az 2 yıl" ve "%50 ortak" nitelikleri kayıtta yok; satır
 *       adet koşulu olarak yazıldı, süre aranmadı.
 *   Madde 2.5b(i) ve türevlerinin "panelde bilimsel değerlendirmeye
 *       alınmış proje başvurusu" dalı — başvuru satırı cetvele girmedi.
 *   Madde 4.2 (dört yarıyıl ders vermiş olmak), 4.4 ve 5.3 (ÜAK sözlü
 *       sınavı), 5.1 (doçentlik koşullarını yeniden sağlamak), 5.4
 *       (doçentlikten sonra beş yıl çalışmış olmak) — beyan olarak
 *       eklendi.
 *   Madde 1.2'nin yağmacı dergi eleme kuralı ve 1.8'in "bir çıktı bir
 *       koşulda" kuralı — kayıt düzeyinde uygulanamıyor.
 *
 * ── KAYNAKTAKİ ÇELİŞKİ: ATIF BARAJI TAVANIN ÜSTÜNDE ──
 * Madde 4.7e doçentlikte atıflardan 300, madde 5.7e profesörlükte 500 puan
 * istiyor; aynı belgenin ATIF bölümü ise "bu madde kapsamında (adayın yazar
 * olarak yer almadığı yayınlardan her birinde, metin içindeki atıf sayısına
 * bakılmaksızın) toplamda en fazla 100 puan alınabilir" diyor. Yazıldığı gibi
 * bırakılsaydı bu SEÇENEĞİ hiçbir aday sağlayamazdı (ikisi de bir `veya`
 * dalının içinde, eşiğin tamamı sağlanabilir kalıyordu ama bu kol ölüydü).
 * KONVANSIYONLAR "Sağlanamaz eşik yazma" uyarınca ulaşılabilir en sıkı değer
 * — tavanın kendisi, 100 puan — uygulandı ve çelişki aday notuna yazıldı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/esogu-2023.php
 */

use App\Services\Scoring\Sart\Kalip;

$CETVEL = 'esogu-2023';
$UNIVERSITE = 'Eskişehir Osmangazi Üniversitesi';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_DORT_YIL = Kalip::sonYil(4);

$SAYISAL = ['fen', 'muhendislik'];
$DIGER = ['sosyal', 'egitim', 'hukuk', 'ilahiyat', 'filoloji', 'guzel_sanatlar',
    'mimarlik', 'spor', 'ziraat'];
$TUM = [...$SAYISAL, 'saglik', ...$DIGER];

$CAKISMA_UYARISI = ' DİKKAT: yönerge "aynı bilimsel çıktı bir başka koşulu sağlamada '
    .'kullanılamaz" diyor ve doçentlik ile profesörlükte aynı toplam puanın iki ayrı seçenek '
    .'listesinde birden kullanılmasını yasaklıyor; bu iki kural burada uygulanamıyor, '
    .'dolayısıyla yalnızca puanla ilerliyorsanız gerçek durumunuz buradakinden zayıf olabilir.';

$ATIF_UYARISI = ' DİKKAT: yönergenin gövdesi atıf seçeneğinde doçentlikte 300, '
    .'profesörlükte 500 puan istiyor ama aynı belgenin atıf bölümü "bu madde kapsamında '
    .'toplamda en fazla 100 puan alınabilir" diyor. Yazıldığı gibi bırakılsaydı bu seçeneği '
    .'hiçbir aday sağlayamazdı; ulaşılabilir en sıkı değer olan 100 puan uygulanıyor. Bu '
    .'seçeneğe güveniyorsanız başvurmadan önce üniversiteye teyit ettirin.';

/**
 * Madde 2.2'nin yayın şartı: en az biri üst basamaktan olmak üzere
 * kümeden iki yayın.
 *
 * @return array<string, mixed>
 */
$madde22 = fn (): array => Kalip::ve('Yayın şartı', [
    Kalip::adet('Web of Science Q1-Q4 dergilerinde ya da tezinizden üretilmiş Q1-Q4 yayınlarınız arasında en az 1 makaleniz olmalı', ['2.2-UST'], 1, madde: 'Madde 2.2'),
    Kalip::adet('Web of Science, uluslararası alan indeksli ve diğer uluslararası hakemli dergilerdeki yayınlarınız toplam en az 2 olmalı', ['2.2-KUME'], 2, madde: 'Madde 2.2'),
]);

/**
 * Proje koşulu (Madde 2.5b, 3.2ç, 4.6b, 5.6b).
 *
 * @param  array<string, mixed>|null  $donem
 * @return array<string, mixed>
 */
$projeKosulu = function (?array $donem, string $madde, bool $yurutucuZorunlu = false): array {
    return $yurutucuZorunlu
        ? Kalip::veya('Proje koşulu', [
            Kalip::adet('TÜBİTAK, TÜBA, AB ya da eşdeğer kurumlarca desteklenen bir projede yürütücü olarak görev almış olmalısınız', ['PROJE-YURUTUCU'], 1, donem: $donem, madde: $madde),
            Kalip::adet('Üniversite BAP birimince desteklenen başarıyla tamamlanmış bir projede yürütücü olarak görev almış olmalısınız', ['8m'], 1, donem: $donem, madde: $madde),
        ])
        : Kalip::veya('Proje koşulu', [
            Kalip::adet('Devam eden ya da tamamlanmış en az 1 projede yürütücü, uzman veya araştırmacı olarak görev almış olmalısınız', ['PROJE'], 1, donem: $donem, madde: $madde),
            Kalip::adet('Üniversite BAP birimince desteklenen projelerde 2 kez araştırmacı olarak görev almış olmalısınız', ['8n'], 2, donem: $donem, madde: $madde),
        ]);
};

/**
 * Kitap veya patent koşulu (Madde 2.5c, 3.2c, 4.7b, 5.7b).
 *
 * @param  array<string, mixed>|null  $donem
 * @return array<string, mixed>
 */
$kitapPatent = fn (?array $donem, string $madde): array => Kalip::veya('Kitap ya da patent koşulu', [
    Kalip::adet('Lisansüstü tezlerinizden üretilmemiş en az 1 kitap ya da kitap bölümünüz olmalı', ['4a', '4b', '4c', '4ç', '4d', '4e'], 1, donem: $donem, madde: $madde),
    Kalip::adet('Alanınızda en az 1 patentiniz ya da faydalı buluşunuz olmalı', ['PATENT'], 1, donem: $donem, madde: $madde),
]);

/**
 * Sanat, tasarım ve konservatuvar alanları için kişisel etkinlik koşulu.
 *
 * @param  array<string, mixed>|null  $donem
 * @return array<string, mixed>
 */
$sanatKosulu = fn (int $sayi, ?array $donem, string $madde): array => Kalip::adet(
    "Özgün sanat eseri, tasarım ya da yorum çalışmanızla tanınmış müze, kültür merkezi ya da sanat galerisinde en az {$sayi} kişisel etkinlikte bulunmuş olmalısınız",
    ['SANAT-KISISEL'], $sayi, donem: $donem, madde: $madde,
);

$esikler = [];

// ══════════════════════════════════════════════════════════════════════════
// DOKTOR ÖĞRETİM ÜYESİ — İLK ATANMA (Madde 2)
// ══════════════════════════════════════════════════════════════════════════

/**
 * @param  list<string>  $alanlar
 * @return array<string, mixed>
 */
$drIlk = function (string $anahtar, array $alanlar, ?string $birim, bool $sayisal, int $altBaraj, string $notlar) use ($UNIVERSITE, $CETVEL, $madde22, $projeKosulu, $kitapPatent, $sanatKosulu): array {
    $yayinSarti = $sayisal
        ? $madde22()
        : Kalip::veya('Yayın şartı', [
            $madde22(),
            Kalip::adet('Uluslararası alan indeksli ya da diğer uluslararası hakemli dergilerde en az 3 yayınınız olmalı', ['2.3-KUME'], 3, madde: 'Madde 2.3'),
        ]);

    return [
        'anahtar' => "esogu-{$anahtar}-dr",
        'aday_notu' => 'İlk atanmada '
            .($sayisal
                ? 'Web of Science Q1-Q4 dergilerinde en az 1 makaleniz olmak kaydıyla toplam 2 uluslararası yayınınız'
                : 'Web of Science koşulunu sağlamanız ya da uluslararası alan indeksli dergilerde en az 3 yayınınız')
            ." olmalı. Puan tablosunun makale, bildiri ve sanat maddelerinden en az {$altBaraj} puan almak "
            .'kaydıyla toplamda en az 60 puan gerekiyor. Ayrıca yurt dışı araştırma, proje görevi, '
            .'kitap/patent, 120 puanlık toplam ya da (sanat alanlarında) kişisel etkinlik '
            .'seçeneklerinden en az birini sağlamalısınız. Yabancı dil koşulu YÖK doçentlik dil '
            .'şartıdır (en az 55 puan).'
            .' Tezinizden ürettiğiniz yayınları kayıtta "Tezden Üretilmiş Yayın" olarak '
            .'işaretlemeyi unutmayın; yönerge onları ayrı bir maddeden sayıyor.',
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => $CETVEL,
        'notlar' => $notlar,
        'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna ilk atanma', [
            Kalip::yds(55),
            Kalip::beyan('Doktora, tıpta uzmanlık ya da sanatta yeterlik derecesine sahip olmak', 'Madde 2'),
            $yayinSarti,
            Kalip::puanDan("Makale, bildiri ve sanat etkinliği kalemlerinizden en az {$altBaraj} puan", ['1-2-3-9-16'], $altBaraj, madde: 'Madde 2.4'),
            Kalip::toplam(60),
            Kalip::veya('Aşağıdaki şartlardan en az birini sağlamalısınız', [
                $projeKosulu(null, 'Madde 2.5b'),
                $kitapPatent(null, 'Madde 2.5c'),
                Kalip::toplam(120, null),
                $sanatKosulu(1, null, 'Madde 2.5d'),
            ]),
        ]),
    ];
};

$esikler[] = $drIlk('sayisal', $SAYISAL, null, true, 40,
    'Madde 2.2 (Fen, Mühendislik): en az biri Q1-Q4\'ten olmak üzere kümeden 2 yayın; 2.4 alt baraj 40, toplam 60; 2.5 seçenek listesi.');
$esikler[] = $drIlk('saglik-tip-dis', ['saglik'], 'Tıp Fakültesi ve Diş Hekimliği Fakültesi', true, 30,
    'Madde 2.2 + 2.4 (Tıp ve Diş Hekimliği alt barajı 30): toplam 60; 2.5 seçenek listesi.');
$esikler[] = $drIlk('saglik-diger', ['saglik'], 'Diğer sağlık birimleri', true, 40,
    'Madde 2.2 + 2.4 (diğer birimler alt barajı 40): toplam 60; 2.5 seçenek listesi.');
$esikler[] = $drIlk('diger', $DIGER, null, false, 40,
    'Madde 2.3 (diğer alanlar): 2.2 koşulu VEYA 1f-1g-3f-3g\'den 3 yayın; 2.4 alt baraj 40, toplam 60; 2.5 seçenek listesi.');

// ══════════════════════════════════════════════════════════════════════════
// DOKTOR ÖĞRETİM ÜYESİ — YENİDEN ATANMA (Madde 3, son 4 yıl)
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'esogu-dr-yeniden',
    'aday_notu' => 'Yeniden atanmada SON 4 YILDA yaptığınız çalışmalar sayılıyor ve bu '
        .'çalışmalar kendi lisansüstü tezlerinizden üretilmemiş olmalı. Puan tablosunun makale, '
        .'bildiri ve sanat maddelerinden en az 40 puan almak kaydıyla toplamda en az 60 puan '
        .'gerekiyor. Ayrıca yurt dışı araştırma, tamamlanmış lisansüstü tez danışmanlığı, '
        .'kitap/patent, proje görevi, 120 puanlık toplam ya da (sanat alanlarında) kişisel '
        .'etkinlik seçeneklerinden en az birini sağlamalısınız. '
        .'ÖNEMLİ MUAFİYET: doçentlik unvanına sahipseniz yönerge yeniden atanmada hiçbir asgari '
        .'koşul aramıyor; bu muafiyet burada hesaplanamadığı için koşullar yine de listeleniyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => $TUM,
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 3.1: son 4 yılda 1, 2, 9, 16. maddelerden en az 40 puan, toplam 60. '
        .'Madde 3.2: beş seçenekten biri. Madde 3 girişi: doçent unvanlı Dr. Öğr. Üyelerinde '
        .'asgari koşul aranmaz (muafiyet yazılamadı).',
    'sart' => Kalip::ve('Doktor Öğretim Üyeliğine yeniden atanma', [
        Kalip::puanDan('Son 4 yılda makale, bildiri ve sanat etkinliği kalemlerinizden en az 40 puan', ['1-2-9-16'], 40, $SON_DORT_YIL, madde: 'Madde 3.1'),
        Kalip::toplam(60, $SON_DORT_YIL),
        Kalip::veya('Aşağıdaki şartlardan en az birini sağlamalısınız', [
            Kalip::adet('Son 4 yılda danışmanlığınızda en az 1 lisansüstü tez tamamlanmış olmalı', ['TEZ-DOKTORA', 'TEZ-YL'], 1, donem: $SON_DORT_YIL, madde: 'Madde 3.2b'),
            $kitapPatent($SON_DORT_YIL, 'Madde 3.2c'),
            $projeKosulu($SON_DORT_YIL, 'Madde 3.2ç'),
            Kalip::toplam(120, $SON_DORT_YIL),
            $sanatKosulu(1, $SON_DORT_YIL, 'Madde 3.2e'),
        ]),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// DOÇENT (Madde 4) — doktora sonrası
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'esogu-docent',
    'aday_notu' => 'Doçentlikte doktora, uzmanlık ya da sanatta yeterlik sonrası '
        .'çalışmalarınızla puan tablosundan toplamda en az 200 puan gerekiyor. Ayrıca iki ayrı '
        .'seçenek listesinden birer koşul sağlamalısınız: birincisi tez danışmanlığı, proje '
        .'yürütücülüğü ya da 300 puanlık toplam; ikincisi yurt dışı araştırma, kitap/patent, '
        .'teknopark şirketi, 300 puanlık toplam, üç kişisel sanat etkinliği ya da 300 puanlık '
        .'atıf. Doçentlik unvanına ve YÖK dil şartına (en az 65 puan) sahip olmalısınız.'
        .$CAKISMA_UYARISI.$ATIF_UYARISI,
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => $TUM,
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 4.7e atıflardan 300 puan istiyor ama ATIF bölümü tavanı 100; ulaşılabilir '
        .'en sıkı değer yazıldı. Madde 4.5: doktora sonrası toplam 200 puan. Madde 4.6 ve 4.7: iki seçenek '
        .'listesi. Madde 4.1-4.4 beyan (ÜAK doçentlik yetkisi, dört yarıyıl ders, YDS 65, '
        .'sözlü sınav).',
    'sart' => Kalip::ve('Doçent kadrosuna atanma', [
        Kalip::yds(65),
        Kalip::beyan('Başvurduğunuz temel alanda doçentlik yetkisine ya da denkliğine sahip olduğunuzu ÜAK belgesiyle kanıtlamak', 'Madde 4.1'),
        Kalip::beyan('Dönemlik program uygulayan birimlerde en az dört yarıyıl, yıllık program uygulayan birimlerde en az iki yıl ders vermiş olmak', 'Madde 4.2'),
        Kalip::beyan('ÜAK tarafından oluşturulan jürilerce yapılan sözlü sınavda başarılı olmak', 'Madde 4.4'),
        Kalip::toplam(200, $DOKTORA),
        Kalip::veya('Aşağıdaki şartlardan en az birini sağlamalısınız', [
            Kalip::adet('Danışmanlığınızda en az 2 yüksek lisans tezi tamamlanmış olmalı', ['TEZ-YL'], 2, donem: $DOKTORA, madde: 'Madde 4.6a'),
            Kalip::adet('Danışmanlığınızda en az 1 doktora, uzmanlık ya da sanatta yeterlik tezi tamamlanmış olmalı', ['TEZ-DOKTORA'], 1, donem: $DOKTORA, madde: 'Madde 4.6a'),
            $projeKosulu($DOKTORA, 'Madde 4.6b', yurutucuZorunlu: true),
            Kalip::toplam(300, $DOKTORA),
        ]),
        Kalip::veya('Aşağıdaki şartlardan en az birini sağlamalısınız', [
            $kitapPatent($DOKTORA, 'Madde 4.7b'),
            Kalip::adet('Teknoloji geliştirme bölgesinde faaliyet gösteren bir şirketin sahibi ya da ortağı olmalısınız', ['TEKNOPARK'], 1, donem: $DOKTORA, madde: 'Madde 4.7c'),
            Kalip::toplam(300, $DOKTORA),
            $sanatKosulu(3, $DOKTORA, 'Madde 4.7d'),
            Kalip::puanDan('Bilimsel çalışmalarınıza yapılan atıflardan toplam en az 100 puan', ['ATIF'], 100, $DOKTORA, madde: 'Madde 4.7e'),
        ]),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// PROFESÖR (Madde 5) — doçentlik başvurusu sonrası
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'esogu-profesor',
    'aday_notu' => 'Profesörlükte doçentlik başvuru aşaması sonrası çalışmalarınızla puan '
        .'tablosundan toplamda en az 300 puan gerekiyor. Ayrıca iki ayrı seçenek listesinden '
        .'birer koşul sağlamalısınız: birincisi tez danışmanlığı, proje yürütücülüğü ya da 450 '
        .'puanlık toplam; ikincisi yurt dışı araştırma, kitap/patent, teknopark şirketi, 450 '
        .'puanlık toplam, dört kişisel sanat etkinliği ya da 500 puanlık atıf. Doçentlik '
        .'unvanınızı aldıktan sonra en az beş yıl üniversitede çalışmış olmanız ve ÜAK\'ın son '
        .'üç yıldaki doçentlik başvuru koşullarından birini yeniden sağlamanız da aranıyor.'
        .$CAKISMA_UYARISI.$ATIF_UYARISI,
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => $TUM,
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 5.7e atıflardan 500 puan istiyor ama ATIF bölümü tavanı 100; ulaşılabilir '
        .'en sıkı değer yazıldı. Madde 5.5: doçentlik başvurusu sonrası toplam 300 puan. Madde 5.6 ve 5.7: iki '
        .'seçenek listesi (450 puanlık toplam ikisinde de seçenek; çakışma kuralı '
        .'uygulanamadı). Madde 5.1-5.4 beyan.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma', [
        Kalip::yds(65),
        Kalip::beyan('Doçentlik bilimsel eser başvurunuzdan sonraki çalışmalarla, ÜAK\'ın son üç yıldaki temel alan doçentlik başvuru koşullarından birini yeniden sağlamak', 'Madde 5.1'),
        Kalip::beyan('ÜAK tarafından oluşturulan jürilerce yapılan doçentlik sözlü sınavını başarmış olmak', 'Madde 5.3'),
        Kalip::beyan('Doçentlik unvanını aldıktan sonra en az beş yıl süreyle üniversitelerde çalışmış olmak', 'Madde 5.4'),
        Kalip::toplam(300, $DOCENTLIK),
        Kalip::veya('Aşağıdaki şartlardan en az birini sağlamalısınız', [
            Kalip::adet('Doçentlik unvanınızdan sonra danışmanlığınızda en az 3 yüksek lisans tezi tamamlanmış olmalı', ['TEZ-YL'], 3, donem: $DOCENTLIK, madde: 'Madde 5.6a'),
            Kalip::adet('Doçentlik unvanınızdan sonra danışmanlığınızda en az 2 doktora ya da sanatta yeterlik tezi tamamlanmış olmalı', ['TEZ-DOKTORA'], 2, donem: $DOCENTLIK, madde: 'Madde 5.6a'),
            Kalip::ve('Bir yüksek lisans ve bir doktora tezi', [
                Kalip::adet('Doçentlik unvanınızdan sonra danışmanlığınızda en az 1 yüksek lisans tezi tamamlanmış olmalı', ['TEZ-YL'], 1, donem: $DOCENTLIK, madde: 'Madde 5.6a'),
                Kalip::adet('Doçentlik unvanınızdan sonra danışmanlığınızda en az 1 doktora ya da sanatta yeterlik tezi tamamlanmış olmalı', ['TEZ-DOKTORA'], 1, donem: $DOCENTLIK, madde: 'Madde 5.6a'),
            ]),
            $projeKosulu($DOCENTLIK, 'Madde 5.6b', yurutucuZorunlu: true),
            Kalip::toplam(450, $DOCENTLIK),
        ]),
        Kalip::veya('Aşağıdaki şartlardan en az birini sağlamalısınız', [
            $kitapPatent($DOCENTLIK, 'Madde 5.7b'),
            Kalip::adet('Doçentlik unvanınızdan sonra teknoloji geliştirme bölgesinde faaliyet gösteren bir şirketin sahibi ya da ortağı olmalısınız', ['TEKNOPARK'], 1, donem: $DOCENTLIK, madde: 'Madde 5.7c'),
            Kalip::toplam(450, $DOCENTLIK),
            $sanatKosulu(4, $DOCENTLIK, 'Madde 5.7d'),
            Kalip::puanDan('Bilimsel çalışmalarınıza yapılan atıflardan toplam en az 100 puan', ['ATIF'], 100, $DOCENTLIK, madde: 'Madde 5.7e'),
        ]),
    ]),
];

return $esikler;
