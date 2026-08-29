<?php

/**
 * ANKARA HACI BAYRAM VELİ ÜNİVERSİTESİ — Akademik Yükseltilme ve Atanma
 * Kriterleri Yönergesi
 * Kaynak: pdf/1772448652440.ankara-haci-bayram-veli-kriter-020232026.pdf
 * Cetvel: cetvel/hbv-2026.php (iki varyant; farkları yazar payı rejimi)
 *
 * ── YAPI: TABLO 1 PUAN + TABLO 2 ZORUNLU KRİTERLER ──
 * Her kadro için iki katman var: MADDE 7'nin genel puan barajı (doktor
 * öğretim üyeliğinde 40, yeniden atamada 20, doçentlik ve profesörlükte
 * 100) ve Tablo 2'nin ON İKİ TEMEL ALAN için ayrı ayrı yazdığı zorunlu
 * kriterler. On iki temel alanın hepsi girildi.
 *
 * ── İKİ CETVEL VARYANTI ──
 * MADDE 6/o yazar payını temel alana göre ikiye ayırıyor: Eğitim,
 * Filoloji, Güzel Sanatlar, Hukuk, İlahiyat ve Sosyal alanlarında eşit
 * bölüşme (`hbv-2026-esit`); Fen, Mimarlık, Mühendislik, Sağlık, Spor ve
 * Ziraat alanlarında başlıca yazar ağırlıklı rejim (`hbv-2026-baslica`).
 *
 * ── TOPLAM PUANDA TEZ YAYINI HARİÇ ──
 * MADDE 7/B-3, C-2 ve Ç-1 toplam puanı "Lisansüstü Tezlerden Üretilmiş
 * Yayınlardan alınacak puanlar hariç" hesaplatıyor; doktor öğretim üyeliği
 * ve doçentlik barajları bu yüzden `TEZ-HARIC` kümesinden. Profesörlükte
 * (MADDE 7/A-3) böyle bir kayıt yok, orada bütün faaliyetler sayılıyor.
 *
 * ── EĞİTİM-ÖĞRETİM KOŞULU METRİĞE ÇEVRİLDİ ──
 * Tablo 1'in 9. maddesi puanı BLOĞA veriyor ("dönemlik programlarda dört
 * farklı yarıyılda ders vermiş olmak — 2 puan"). Cetvele satır olarak
 * girilemediği için Tablo 2'nin "9. maddeden en az 2 puan" koşulu
 * `metrik('ders_yariyil', 4)`'e, MADDE 7'nin "iki yıl/dört yarıyıl
 * kadrolu ders vermiş olmak" koşulu da aynı metriğe çevrildi.
 *
 * ── GÜZEL SANATLAR VE BİLİM/SANAT DALI KİLİDİ ──
 * SANATSAL FAALİYETLER tablosu Güzel Sanatlarda dört ayrı bilim/sanat
 * dalına (El Sanatları-Grafik-Plastik, Müzik, Sahne Sanatları, Sanat
 * Yönetimi), Müzik ve Sahne Sanatları da kendi içinde dörder alt dala
 * bölünmüş. Profil adayın bilim/sanat dalını taşımadığı için bu tablo
 * cetvele girilemedi; Güzel Sanatlar eşiklerinde "100 puanın en az 50'sini
 * Sanatsal Faaliyetlerden almak" koşulu `hesaplanamiyor` olarak duruyor,
 * "Bilimsel ve Akademik Faaliyetlerden en az 45 puan" koşulu ise
 * hesaplanıyor.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   İlahiyat Tablo 2'sinin 14. maddesi (Dînî Musıkî bilim alanı için
 *       sanatsal uygulamadan en az 10 puan) ve Sosyal Tablo 2'sinin 13.
 *       maddesi (Görsel İletişim, İletişim, Reklamcılık, Sinema ve Halkla
 *       İlişkiler bilim alanları için en az 10 puan) — ikisi de tek bir
 *       BİLİM ALANINA özgü ek koşul. Bütün temel alana uygulamak, teoloji
 *       ya da iktisat adayından müzik icrası veya film çalışması istemek
 *       olurdu; girilmedi ve aday notunda anlatıldı.
 *   Fen Bilimleri Tablo 2'sinde Matematik ve İstatistik bilim alanlarına
 *       tanınan düşük eşik (40 yerine 20 puan) — profil bilim alanını
 *       taşımadığı için §0 uyarınca yüksek olan (40) uygulandı.
 *   Filoloji, Hukuk, İlahiyat ve Sosyal alanlarındaki "üçü/ikisi FARKLI
 *       DERGİLERDE yayımlanmış" kaydı — kayıt derginin kimliğini
 *       taşımıyor; yalnız yayın sayısı ve tek yazarlılık kontrol ediliyor.
 *   MADDE 6/h (eserlerin adayın alanıyla ilgili olması), 6/ı (her eserin
 *       bir kez puanlanması), MADDE 6/a-g (komisyonlar ve itiraz süreci),
 *       MADDE 8 (yürürlük tarihleri).
 *   Yabancı dil koşulu MADDE 7'ye göre yalnız profesörlük, doçentlik ve
 *       doktor öğretim üyeliğine İLK atamada aranıyor; yeniden atamada
 *       aranmıyor.
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Ankara Hacı Bayram Veli Üniversitesi';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$DIL = Kalip::yds(65);
$DIL_NOT = Kalip::beyan(
    'Bilim alanı belli bir dille ilgili olanlar için o dilde en az 85 ve başka bir yabancı dilde en az 65 puan; öğretim dilinin en az %30\'u yabancı dilde olan bölümlerde o dilden en az 85 puan',
    'MADDE 7'
);
$UNVAN = Kalip::beyan(
    'Üniversitelerarası Kurul tarafından verilen doçentlik unvanına sahip olmak',
    'MADDE 7/A-1, B-1'
);
$DOKTORA_BEYANI = Kalip::beyan('Doktora ya da sanatta yeterlik mezunu olmak', 'MADDE 7/C-1');
$DERS = Kalip::metrik(
    'Yükseköğretim kurumlarında en az iki yıl (dört yarıyıl) kadrolu ve tam zamanlı olarak ders vermiş olmak',
    'ders_yariyil', 4
);
$TEZ_YAYINI = Kalip::adet(
    'Lisansüstü tezlerinizden üretilmiş en az bir yayınınızın olması',
    ['M3'], 1, madde: 'Tablo 2 / 3'
);

$NOT_CETVEL = ' Puan çizelgesindeki kalemlerin çoğunda azami puan var (kitap 40, ödül 25, '
    .'patent ve diğer 20, proje 15, atıf, tez danışmanlığı ve bilimsel toplantı 10\'ar, '
    .'editörlük 4). Eğitim-öğretim puanı dört farklı yarıyılda ders vermiş olma bloğuna '
    .'verildiği için satır olarak girilemedi; o koşul ders yarıyılı sayısından kontrol ediliyor. '
    .'H-indeksi, yurt dışı araştırma, idari görev ve yabancı dil puanı kalemleri de faaliyet '
    .'olarak kaydedilemediği için girilmedi.';

$esikler = [];

/**
 * Bir temel alanın dört kadrosunu üretir.
 *
 * @param  list<string>  $alanlar
 * @param  callable(array|null): list<array<string, mixed>>  $zorunlu
 * @param  list<array<string, mixed>>  $gsPuan  Güzel Sanatlara özgü puan koşulları
 */
$alan = function (string $kod, array $alanlar, string $ad, string $cetvel, callable $zorunlu,
    ?callable $gsPuan = null) use (&$esikler, $UNIVERSITE, $DIL, $DIL_NOT, $UNVAN,
    $DOKTORA_BEYANI, $DERS, $TEZ_YAYINI, $DOKTORA, $DOCENTLIK, $SON_ATAMA,
    $NOT_CETVEL): void {
    $drPuan = $gsPuan !== null ? $gsPuan('dr') : [Kalip::toplam(40, $DOKTORA, ['TEZ-HARIC'], 'Lisansüstü tez yayınları dışındaki')];
    $docPuan = $gsPuan !== null ? $gsPuan('docentlik') : [Kalip::toplam(100, $DOKTORA, ['TEZ-HARIC'], 'Lisansüstü tez yayınları dışındaki')];
    $profPuan = $gsPuan !== null ? $gsPuan('profesorluk') : [Kalip::toplam(100, $DOCENTLIK)];

    $esikler[] = [
        'anahtar' => "hbv-{$kod}-dr",
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'cetvel' => $cetvel,
        'notlar' => $ad.' doktor öğretim üyeliği: doktora sonrası, lisansüstü tez yayınları '
            .'hariç toplam 40 puan ve Tablo 2\'nin zorunlu tez yayını koşulu.',
        'aday_notu' => $ad.' alanında doktor öğretim üyesi kadrosuna İLK ATANMA. Yalnız '
            .'DOKTOR UNVANINI ALDIKTAN SONRAKİ çalışmalarınız sayılıyor '
            .'(lisansüstü tez yayınları hariç). Toplam puan barajına lisansüstü tezlerinizden '
            .'üretilmiş yayınların puanı DAHİL EDİLMİYOR; o kalem yalnız kendi zorunlu '
            .'koşulunu karşılıyor. Doktor öğretim üyeliğine ilk atamalar iki yıllığına '
            .'yapılıyor.'.$NOT_CETVEL,
        'sart' => Kalip::ve('Doktor öğretim üyesi kadrosuna atanma — '.$ad,
            array_values([$DOKTORA_BEYANI, $DIL, $DIL_NOT, $TEZ_YAYINI, ...$drPuan])),
    ];

    $esikler[] = [
        'anahtar' => "hbv-{$kod}-dr-yeniden",
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $alanlar,
        'cetvel' => $cetvel,
        'notlar' => $ad.' doktor öğretim üyeliğine yeniden atanma: bir önceki atanma tarihinden '
            .'sonra, lisansüstü tez yayınları hariç toplam 20 puan. Doçentlik unvanı olanlarda '
            .'puan şartı aranmıyor.',
        'aday_notu' => $ad.' alanında doktor öğretim üyesi kadrosuna YENİDEN ATANMA. Yalnız BİR '
            .'ÖNCEKİ ATANMA TARİHİNDEN sonraki çalışmalarınız sayılıyor. Yeniden atamalar iki '
            .'yıllığına yapılıyor; bu şartlara ilave her 10 puan için atama süresi bir yıl '
            .'artıyor ve toplam süre dört yılı geçemiyor. Doçentlik unvanınız varsa puan şartı '
            .'aranmadan yeniden atanabilirsiniz. Dosyanızı atanma süreniz bitmeden en geç bir '
            .'ay önce biriminize teslim etmeniz gerekiyor.'.$NOT_CETVEL,
        'sart' => Kalip::veya('Yeniden atanma koşullarından birini sağlamak', [
            Kalip::beyan('Üniversitelerarası Kurul tarafından verilen doçentlik unvanına sahip olmak (bu durumda puan şartı aranmaz)', 'MADDE 7/Ç-2'),
            Kalip::toplam(20, $SON_ATAMA, ['TEZ-HARIC'], 'Lisansüstü tez yayınları dışındaki'),
        ]),
    ];

    $esikler[] = [
        'anahtar' => "hbv-{$kod}-docentlik",
        'universite' => $UNIVERSITE,
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'cetvel' => $cetvel,
        'notlar' => $ad.' doçentlik: doçentlik unvanı, dört yarıyıl kadrolu ders, doktora '
            .'sonrası lisansüstü tez yayınları hariç toplam 100 puan ve Tablo 2\'nin '.$ad
            .' zorunlu kriterleri.',
        'aday_notu' => $ad.' alanında doçent kadrosuna yükseltilme ve atanma. Yalnız DOKTOR '
            .'UNVANINI ALDIKTAN SONRAKİ çalışmalarınız sayılıyor. Toplam puan '
            .'barajına lisansüstü tez yayınlarının puanı dâhil edilmiyor. Ayrıca yükseköğretim '
            .'kurumlarında en az iki yıl (dört yarıyıl) kadrolu ve tam zamanlı ders vermiş '
            .'olmanız gerekiyor.'.$NOT_CETVEL,
        'sart' => Kalip::ve('Doçent kadrosuna atanma — '.$ad,
            array_values([$UNVAN, $DIL, $DIL_NOT, $DERS, $TEZ_YAYINI, ...$zorunlu($DOKTORA),
                ...$docPuan])),
    ];

    $esikler[] = [
        'anahtar' => "hbv-{$kod}-profesorluk",
        'universite' => $UNIVERSITE,
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'cetvel' => $cetvel,
        'notlar' => $ad.' profesörlük: doçentlik sonrası beş yıl çalışma, dört yarıyıl kadrolu '
            .'ders, doçentlik sonrası toplam 100 puan ve Tablo 2\'nin '.$ad.' zorunlu '
            .'kriterleri.',
        'aday_notu' => $ad.' alanında profesör kadrosuna yükseltilme ve atanma. Yalnız DOÇENT '
            .'UNVANINI ALDIKTAN SONRAKİ çalışmalarınız sayılıyor. '
            .'Doçentlik sonrası en az beş yıl alanınızda çalışmış ve bu süre içinde en az iki '
            .'yıl (dört yarıyıl) kadrolu ders vermiş olmanız, ayrıca hangi çalışmanızı '
            .'"başlıca eser" olarak sunduğunuzu belirtmeniz gerekiyor. Profesörlük barajında '
            .'lisansüstü tez yayınları da sayılıyor.'.$NOT_CETVEL,
        'sart' => Kalip::ve('Profesör kadrosuna atanma — '.$ad,
            array_values([$UNVAN, $DIL, $DIL_NOT,
                Kalip::beyan('Doçent unvanını aldıktan sonra alanınızda en az beş yıl çalışmış olmak', 'MADDE 7/A-2'),
                Kalip::metrik('Bu süre içinde yükseköğretim kurumlarında en az iki yıl (dört yarıyıl) kadrolu ve tam zamanlı ders vermiş olmak', 'ders_yariyil', 4, Kalip::DOCENTLIK_SONRASI),
                Kalip::beyan('Doçent unvanını aldıktan sonra yayımlanmış özgün bir kitap ya da makalenizi "başlıca eser" olarak sunmak', 'MADDE 7/A'),
                ...$zorunlu($DOCENTLIK), ...$profPuan])),
    ];
};

$P = fn (string $ad, string $grup, int $puan, ?array $donem): array => Kalip::puanDan(
    $ad, [$grup], $puan, $donem, madde: 'Tablo 2'
);
$A = fn (string $ad, string $grup, int $n, ?array $donem, ?string $yazar = null): array => $yazar === 'tek'
        ? Kalip::adet($ad, [$grup], $n, yazar: 'tek', donem: $donem, madde: 'Tablo 2')
        : ($yazar === 'baslica'
            ? Kalip::adet($ad, [$grup], $n, yazar: 'baslica', donem: $donem, madde: 'Tablo 2')
            : Kalip::adet($ad, [$grup], $n, donem: $donem, madde: 'Tablo 2'));

$ORTAK = fn (?array $d): array => [
    Kalip::puanDan('Atıflardan en az 5 puan almak', ['M5'], 5, $d, madde: 'Tablo 2 / 5'),
    Kalip::puanDan('Bilimsel toplantı kaleminden en az 5 puan almak', ['M8'], 5, $d, madde: 'Tablo 2 / 8'),
    Kalip::metrik('Eğitim-öğretim kaleminden en az 2 puan almak (dört farklı yarıyılda ders vermiş olmak)', 'ders_yariyil', 4, $d),
];

// ── EĞİTİM BİLİMLERİ ──
$alan('egitim', ['egitim'], 'Eğitim Bilimleri', 'hbv-2026-esit',
    fn (?array $d): array => [
        $P('SCIE ya da SSCI kapsamında Q1, Q2 veya Q3 dergilerde yayımlanmış makalelerden en az 30 puan almak', '1.a.q1-q3', 30, $d),
        $A('Ulusal makale kaleminden en az iki yayın yapmış olmak', 'M2', 2, $d),
        $A('Bu yayınlardan en az birinin TR Dizin kapsamındaki bir dergide olması', '2.a', 1, $d),
        ...$ORTAK($d),
    ]);

// ── FEN BİLİMLERİ VE MATEMATİK ──
$alan('fen', ['fen'], 'Fen Bilimleri ve Matematik', 'hbv-2026-baslica',
    fn (?array $d): array => [
        $P('SCIE ya da SSCI kapsamında Q1, Q2 veya Q3 dergilerde yayımlanmış makalelerden en az 40 puan almak', '1.a.q1-q3', 40, $d),
        $A('Bu makalelerden en az birinde başlıca yazar olmak', '1.a.q1-q3', 1, $d, 'baslica'),
        $P('TR Dizin kapsamındaki dergilerde yayımlanmış makalelerden en az 10 puan almak', '2.a', 10, $d),
        ...$ORTAK($d),
    ]);

// ── FİLOLOJİ ──
$alan('filoloji', ['filoloji'], 'Filoloji', 'hbv-2026-esit',
    fn (?array $d): array => [
        Kalip::veya('Ulusal ya da uluslararası makale koşulunu sağlamak', [
            Kalip::ve('TR Dizin dergilerinde altı yayın (dördü tek yazarlı) ve 50 puan', [
                Kalip::adet('TR Dizin kapsamındaki dergilerde en az altı yayın yapmış olmak', ['2.a'], 6, donem: $d, madde: 'Tablo 2 / 2'),
                Kalip::adet('Bu yayınlardan en az dördünün tek yazarlı olması', ['2.a'], 4, yazar: 'tek', donem: $d, madde: 'Tablo 2 / 2'),
                Kalip::puanDan('Bu kalemden en az 50 puan almak', ['2.a'], 50, $d, madde: 'Tablo 2 / 2'),
            ]),
            Kalip::ve('Uluslararası dergilerde iki yayın (biri tek yazarlı) ve 50 puan', [
                Kalip::adet('Uluslararası makale kaleminin a, b veya c bentlerinde en az iki yayın yapmış olmak', ['1.a-c'], 2, donem: $d, madde: 'Tablo 2 / 2'),
                Kalip::adet('Bu yayınlardan en az birinin tek yazarlı olması', ['1.a-c'], 1, yazar: 'tek', donem: $d, madde: 'Tablo 2 / 2'),
                Kalip::puanDan('Bu kalemden en az 50 puan almak', ['1.a-c'], 50, $d, madde: 'Tablo 2 / 2'),
            ]),
        ]),
        $A('Kitap kaleminin a veya c bentlerinden tek yazarlı özgün en az bir kitabınızın olması', '4.a-c', 1, $d, 'tek'),
        ...$ORTAK($d),
    ]);

// ── HUKUK ──
$alan('hukuk', ['hukuk'], 'Hukuk', 'hbv-2026-esit',
    fn (?array $d): array => [
        Kalip::veya('Ulusal ya da uluslararası makale koşulunu sağlamak', [
            Kalip::ve('TR Dizin dergilerinde altı yayın (dördü tek yazarlı) ve 50 puan', [
                Kalip::adet('TR Dizin kapsamındaki dergilerde en az altı yayın yapmış olmak', ['2.a'], 6, donem: $d, madde: 'Tablo 2 / 2'),
                Kalip::adet('Bu yayınlardan en az dördünün tek yazarlı olması', ['2.a'], 4, yazar: 'tek', donem: $d, madde: 'Tablo 2 / 2'),
                Kalip::puanDan('Bu kalemden en az 50 puan almak', ['2.a'], 50, $d, madde: 'Tablo 2 / 2'),
            ]),
            Kalip::ve('Uluslararası dergilerde iki yayın (biri tek yazarlı) ve 50 puan', [
                Kalip::adet('Uluslararası makale kaleminin a, b veya c bentlerinde en az iki yayın yapmış olmak', ['1.a-c'], 2, donem: $d, madde: 'Tablo 2 / 2'),
                Kalip::adet('Bu yayınlardan en az birinin tek yazarlı olması', ['1.a-c'], 1, yazar: 'tek', donem: $d, madde: 'Tablo 2 / 2'),
                Kalip::puanDan('Bu kalemden en az 50 puan almak', ['1.a-c'], 50, $d, madde: 'Tablo 2 / 2'),
            ]),
        ]),
        $A('Kitap kaleminin a veya c bentlerinden tek yazarlı özgün en az bir kitabınızın olması', '4.a-c', 1, $d, 'tek'),
        ...$ORTAK($d),
    ]);

// ── İLAHİYAT ──
$alan('ilahiyat', ['ilahiyat'], 'İlahiyat', 'hbv-2026-esit',
    fn (?array $d): array => [
        Kalip::veya('Ulusal ya da uluslararası makale koşulunu sağlamak', [
            Kalip::ve('TR Dizin dergilerinde beş yayın (üçü tek yazarlı) ve 50 puan', [
                Kalip::adet('TR Dizin kapsamındaki dergilerde en az beş yayın yapmış olmak', ['2.a'], 5, donem: $d, madde: 'Tablo 2 / 2'),
                Kalip::adet('Bu yayınlardan en az üçünün tek yazarlı olması', ['2.a'], 3, yazar: 'tek', donem: $d, madde: 'Tablo 2 / 2'),
                Kalip::puanDan('Bu kalemden en az 50 puan almak', ['2.a'], 50, $d, madde: 'Tablo 2 / 2'),
            ]),
            Kalip::ve('Uluslararası dergilerde iki yayın (biri tek yazarlı) ve 50 puan', [
                Kalip::adet('Uluslararası makale kaleminin a, b veya c bentlerinde en az iki yayın yapmış olmak', ['1.a-c'], 2, donem: $d, madde: 'Tablo 2 / 2'),
                Kalip::adet('Bu yayınlardan en az birinin tek yazarlı olması', ['1.a-c'], 1, yazar: 'tek', donem: $d, madde: 'Tablo 2 / 2'),
                Kalip::puanDan('Bu kalemden en az 50 puan almak', ['1.a-c'], 50, $d, madde: 'Tablo 2 / 2'),
            ]),
        ]),
        $A('Kitap kaleminin a veya c bentlerinden tek yazarlı özgün en az bir kitabınızın olması', '4.a-c', 1, $d, 'tek'),
        ...$ORTAK($d),
    ]);

// ── MİMARLIK, PLANLAMA VE TASARIM ──
$alan('mimarlik', ['mimarlik'], 'Mimarlık, Planlama ve Tasarım', 'hbv-2026-baslica',
    fn (?array $d): array => [
        $P('Uluslararası makale kaleminin a, b veya c bentlerinden en az 20 puan almak', '1.a-c', 20, $d),
        $A('Bu makalelerden en az birinde başlıca yazar olmak', '1.a-c', 1, $d, 'baslica'),
        $P('TR Dizin kapsamındaki dergilerde yayımlanmış makalelerden en az 10 puan almak', '2.a', 10, $d),
        Kalip::veya('Yarışma, proje ve yazılım koşulunu sağlamak', [
            Kalip::puanDan('Yarışma, proje ve yazılım kaleminden en az 15 puan almak', ['M15'], 15, $d, madde: 'Tablo 2 / 15'),
            Kalip::adet('Bu koşulu sağlayamayanlar için uluslararası makale kaleminin a, b veya c bentlerinden en az bir yayın', ['1.a-c'], 1, donem: $d, madde: 'Tablo 2 / 15'),
        ]),
        ...$ORTAK($d),
    ]);

// ── SOSYAL, BEŞERÎ VE İDARİ BİLİMLER ──
$alan('sosyal', ['sosyal'], 'Sosyal, Beşerî ve İdari Bilimler', 'hbv-2026-esit',
    fn (?array $d): array => [
        $P('Uluslararası makale kaleminin a, b, c veya d bentlerinden en az 10 puan almak', '1.a-d', 10, $d),
        Kalip::veya('Ulusal ya da uluslararası makale koşulunu sağlamak', [
            Kalip::ve('TR Dizin dergilerinde beş yayın (üçü tek yazarlı)', [
                Kalip::adet('TR Dizin kapsamındaki dergilerde en az beş yayın yapmış olmak', ['2.a'], 5, donem: $d, madde: 'Tablo 2 / 2'),
                Kalip::adet('Bu yayınlardan en az üçünün tek yazarlı olması', ['2.a'], 3, yazar: 'tek', donem: $d, madde: 'Tablo 2 / 2'),
            ]),
            Kalip::ve('Uluslararası dergilerde üç yayın (biri tek yazarlı)', [
                Kalip::adet('Uluslararası makale kaleminin a veya b bentlerinde en az üç yayın yapmış olmak', ['1.a-b'], 3, donem: $d, madde: 'Tablo 2 / 2'),
                Kalip::adet('Bu yayınlardan en az birinin tek yazarlı olması', ['1.a-b'], 1, yazar: 'tek', donem: $d, madde: 'Tablo 2 / 2'),
            ]),
        ]),
        Kalip::veya('Kitap koşulunu sağlamak', [
            Kalip::adet('En az bir kitap yayımlamış olmak', ['4.a-c'], 1, donem: $d, madde: 'Tablo 2 / 4'),
            Kalip::adet('En az iki kitap bölümü yayımlamış olmak', ['4.b-d'], 2, donem: $d, madde: 'Tablo 2 / 4'),
        ]),
        ...$ORTAK($d),
    ]);

// ── MÜHENDİSLİK ──
$alan('muhendislik', ['muhendislik'], 'Mühendislik', 'hbv-2026-baslica',
    fn (?array $d): array => [
        $P('SCIE ya da SSCI kapsamında Q1, Q2 veya Q3 dergilerde yayımlanmış makalelerden en az 40 puan almak', '1.a.q1-q3', 40, $d),
        $A('Bu makalelerden en az birinde başlıca yazar olmak', '1.a.q1-q3', 1, $d, 'baslica'),
        $P('TR Dizin kapsamındaki dergilerde yayımlanmış makalelerden en az 10 puan almak', '2.a', 10, $d),
        ...$ORTAK($d),
    ]);

// ── ZİRAAT, ORMAN VE SU ÜRÜNLERİ ──
$alan('ziraat', ['ziraat'], 'Ziraat, Orman ve Su Ürünleri', 'hbv-2026-baslica',
    fn (?array $d): array => [
        $P('SCIE ya da SSCI kapsamındaki dergilerde yayımlanmış makalelerden en az 30 puan almak', '1.a', 30, $d),
        $P('Bunların Q1, Q2 veya Q3 dergilerinde yayımlanmış olanlarından en az 20 puan almak', '1.a.q1-q3', 20, $d),
        $A('Bu makalelerden en az birinde başlıca yazar olmak', '1.a.q1-q3', 1, $d, 'baslica'),
        $P('TR Dizin kapsamındaki dergilerde yayımlanmış makalelerden en az 20 puan almak', '2.a', 20, $d),
        ...$ORTAK($d),
    ]);

// ── SPOR BİLİMLERİ ──
$alan('spor', ['spor'], 'Spor Bilimleri', 'hbv-2026-baslica',
    fn (?array $d): array => [
        $P('Uluslararası makale kaleminin a veya b bentlerinden en az 30 puan almak', '1.a-b', 30, $d),
        $A('Bu makalelerden en az birinde başlıca yazar olmak', '1.a-b', 1, $d, 'baslica'),
        $A('Ulusal makale kaleminden en az üç yayın yapmış olmak', 'M2', 3, $d),
        $A('Bu yayınlardan en az ikisinin TR Dizin kapsamındaki dergilerde olması', '2.a', 2, $d),
        Kalip::veya('Kitap koşulunu sağlamak', [
            Kalip::adet('En az bir kitap yayımlamış olmak', ['4.a-c'], 1, donem: $d, madde: 'Tablo 2 / 4'),
            Kalip::adet('En az iki kitap bölümü yayımlamış olmak', ['4.b-d'], 2, donem: $d, madde: 'Tablo 2 / 4'),
        ]),
        ...$ORTAK($d),
    ]);

// ── SAĞLIK BİLİMLERİ ──
$alan('saglik', ['saglik'], 'Sağlık Bilimleri', 'hbv-2026-baslica',
    fn (?array $d): array => [
        $P('SCIE ya da SSCI kapsamındaki dergilerde yayımlanmış makalelerden en az 40 puan almak', '1.a', 40, $d),
        $A('Bu makalelerden en az üçünde başlıca yazar olmak', '1.a', 3, $d, 'baslica'),
        $A('Ulusal makale kaleminden en az üç yayın yapmış olmak', 'M2', 3, $d),
        $A('Bu yayınlardan en az ikisinin TR Dizin kapsamındaki dergilerde olması', '2.a', 2, $d),
        $A('Bu ulusal yayınlardan en az ikisinde başlıca yazar olmak', 'M2', 2, $d, 'baslica'),
        ...$ORTAK($d),
    ]);

// ── GÜZEL SANATLAR ──
$alan('guzel-sanatlar', ['guzel_sanatlar'], 'Güzel Sanatlar', 'hbv-2026-esit',
    fn (?array $d): array => [
        $P('Uluslararası makale kaleminin a, b, c veya d bentlerinden en az 10 puan almak', '1.a-d', 10, $d),
        $A('TR Dizin kapsamındaki bir dergide tek yazarlı en az bir yayınınızın olması', '2.a', 1, $d, 'tek'),
        $A('En az bir kitap ya da kitap bölümü yayımlamış olmak (tek yazarlı özgün)', 'M4', 1, $d, 'tek'),
        Kalip::puanDan('Atıflardan en az 2 puan almak', ['M5'], 2, $d, madde: 'Tablo 2 / 5'),
        Kalip::puanDan('Bilimsel toplantı kaleminden en az 5 puan almak', ['M8'], 5, $d, madde: 'Tablo 2 / 8'),
        Kalip::metrik('Eğitim-öğretim kaleminden en az 2 puan almak (dört farklı yarıyılda ders vermiş olmak)', 'ders_yariyil', 4, $d),
        Kalip::hesaplanamiyor('Bilim/sanat dalınıza özgü Sanatsal Faaliyetler zorunlu kriterlerini sağlamak', 'Tablo 2 / Sanatsal Faaliyetler'),
    ],
    fn (string $kadro): array => match ($kadro) {
        'dr' => [
            Kalip::hesaplanamiyor('40 puanın en az 20\'sini Sanatsal Faaliyetlerden almak', 'MADDE 7/C-2'),
            Kalip::toplam(20, Kalip::DOKTORA_SONRASI, ['TEZ-HARIC'], 'Bilimsel ve Akademik Faaliyetlerden (lisansüstü tez yayınları hariç)'),
        ],
        'docentlik' => [
            Kalip::hesaplanamiyor('100 puanın en az 50\'sini Sanatsal Faaliyetlerden almak', 'MADDE 7/B-3'),
            Kalip::toplam(45, Kalip::DOKTORA_SONRASI, ['TEZ-HARIC'], 'Bilimsel ve Akademik Faaliyetlerden (lisansüstü tez yayınları hariç)'),
        ],
        default => [
            Kalip::hesaplanamiyor('100 puanın en az 50\'sini Sanatsal Faaliyetlerden almak', 'MADDE 7/A-3'),
            Kalip::toplam(45, Kalip::DOCENTLIK_SONRASI, ['TEZ-HARIC'], 'Bilimsel ve Akademik Faaliyetlerden'),
        ],
    });

return $esikler;
