<?php

/**
 * BAHÇEŞEHİR ÜNİVERSİTESİ — Akademik Personel (Öğretim Elemanları)
 * Yükseltme ve Atama Esasları
 * Kaynak: pdf/17537096942.bahcesehiruniversitesi.pdf (Senato 10.02.2025,
 * YÖK Genel Kurul onayı 30.01.2025)
 * Cetvel: cetvel/bau-2025.php (altı varyant; farkları başlık tavanları)
 *
 * ── EŞİKLER FAKÜLTEYE GÖRE ──
 * MADDE 6 on üç ayrı fakülte/yüksekokul tablosu veriyor. Üç temel alanda
 * birden fazla tablo çakıştığı için `birim` ayrımı gerekti:
 *   Sağlık Bilimleri → "Diş Hekimliği Fakültesi", "Eczacılık Fakültesi",
 *       "Sağlık Bilimleri Fakültesi", "Tıp Fakültesi" ve "Sağlık
 *       Hizmetleri Meslek Yüksekokulu".
 *   Sosyal, Beşeri ve İdari Bilimler → "İktisadi, İdari ve Sosyal
 *       Bilimler Fakültesi", "İletişim Fakültesi" ve "Uygulamalı Bilimler
 *       Yüksekokulu".
 * Öbür tablolar tek temel alana düşüyor: Eğitim Bilimleri Fakültesi,
 * Hukuk Fakültesi, Mimarlık ve Tasarım Fakültesi, Mühendislik ve Doğa
 * Bilimleri Fakültesi (Mühendislik ve Fen temel alanları) ve
 * Konservatuvar (Güzel Sanatlar). Filoloji, İlahiyat, Spor ve Ziraat
 * temel alanları esaslarda HİÇ geçmiyor; §0 uyarınca eşik yazılmadı.
 *
 * ── DOKTOR ÖĞRETİM ÜYELİĞİNDE YENİDEN ATAMA PUANSIZ ──
 * MADDE 7 sözleşme yenilenmesini üç kişilik bir jürinin son üç yıllık
 * eğitim ve araştırma faaliyetlerini değerlendirmesine bağlıyor; sayısal
 * bir baraj koymuyor. Yeniden atama eşiği bu yüzden beyan koşullarından
 * ibaret ve bütün temel alanlara tek eşik olarak yazıldı.
 *
 * ── MİMARLIK TABLOSUNDAKİ ESKİ NUMARALAR ──
 * Mimarlık ve Tasarım tablosu "(C.1-C.11)" ve "(C.7-C.11)" diyor; oysa
 * puanlama sisteminde C yalnız C-1'den C-7'ye gidiyor. Bu, esasların
 * önceki sürümünden kalma numaralandırma. "(C.1-C.11)" bütün kitap
 * satırları, "(C.7-C.11)" ise Scopus ve BKCI dışındaki kitap satırları
 * (C-4, C-5, C-6) olarak okundu. Aynı biçimde İletişim tablosunun
 * "C1-C11" ve "A-1.-A-5" ifadeleri de bütün C ve A satırları sayıldı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Tez danışmanlığı koşullarının yıldızlı notu ("ilgili anabilim dalında
 *       lisansüstü öğrenci olmaması durumunda bu koşul aranmayabilir") —
 *       muafiyet, koşulu hafifletir (§0).
 *   MADDE 6(2)/b ve İletişim tablosunun notu: "kurulma aşamasında olan
 *       birimlerde bu ölçütler uygulanmayıp sadece jüri raporları dikkate
 *       alınır" — muafiyet.
 *   Konservatuvar doktor öğretim üyeliğinin yıldızlı notu: yeni mezun
 *       adaylardan asgari puan yerine jüri raporlarının aranması.
 *   Mühendislik ve Uygulamalı Bilimler tablolarındaki D telafi yolu
 *       ("bu şartın sağlanamadığı durumda eksik kalan puan H-2 türünden
 *       veya A'ya ek olarak sağlanabilir") — telafi koşulu hafifletir.
 *   MADDE 6(2)/a: "bir kategorideki makul bir zafiyet diğer
 *       kategorilerdeki bir mükemmeliyetle aşılabilir" — jüri takdiri.
 *   Esaslarda yabancı dil için sayısal bir eşik yok; başvuru evrakında
 *       merkezi yabancı dil sınav sonuç belgesi isteniyor, beyan olarak
 *       yazıldı.
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Bahçeşehir Üniversitesi';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;

$DIL = Kalip::beyan(
    'Merkezi yabancı dil sınavı sonuç belgesini başvuru dosyasına eklemek',
    'MADDE 6(1)/a'
);
$UNVAN = Kalip::beyan(
    'Üniversitelerarası Kurul tarafından verilen doçentlik unvanına sahip olmak',
    '2547 s.K. m.24'
);

$NOT_CETVEL = ' Ortak çalışmalarda puan yazar SIRASINA değil kişi sayısına bakıyor: tek kişide '
    .'tam puan, iki kişide %80, ikiden fazla kişide 1,8 × puan / kişi sayısı. Esasların '
    .'puanlama sisteminde hakemlik, ders verme ve burs satırı yok; h-indeksi puanı (A-4.2) da '
    .'faaliyet olarak kaydedilemediği için girilemedi.';

$esikler = [];

/**
 * Bir fakülte tablosunun üç kadrosunu birden üretir.
 *
 * @param  list<string>  $alanlar
 * @param  list<array<string, mixed>>  $drKosul
 * @param  list<array<string, mixed>>  $docKosul
 * @param  list<array<string, mixed>>  $profKosul
 */
$tablo = function (string $kod, array $alanlar, ?string $birim, string $ad,
    array $drKosul, array $docKosul, array $profKosul,
    string $drCetvel = 'bau-2025', string $docCetvel = 'bau-2025',
    string $profCetvel = 'bau-2025') use (&$esikler, $UNIVERSITE, $DIL, $UNVAN, $NOT_CETVEL): void {
    $esikler[] = [
        'anahtar' => "bau-{$kod}-dr",
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => $drCetvel,
        'notlar' => $ad.' doktor öğretim üyesi asgari koşulları (MADDE 6).',
        'aday_notu' => $ad.' için doktor öğretim üyesi kadrosuna atanma. Esaslar ilk atamada '
            .'dönem sınırı koymuyor, bütün akademik geçmişiniz sayılıyor.'.$NOT_CETVEL,
        'sart' => Kalip::ve('Doktor öğretim üyesi kadrosuna atanma — '.$ad,
            array_values([$DIL, ...$drKosul])),
    ];
    $esikler[] = [
        'anahtar' => "bau-{$kod}-docentlik",
        'universite' => $UNIVERSITE,
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => $docCetvel,
        'notlar' => $ad.' doçentlik asgari koşulları (MADDE 6).',
        'aday_notu' => $ad.' için doçent kadrosuna atanma. Toplam puanın belirtilen kısmının '
            .'DOKTORA DERECESİNDEN SONRAKİ çalışmalardan gelmesi gerekiyor.'.$NOT_CETVEL,
        'sart' => Kalip::ve('Doçent kadrosuna atanma — '.$ad,
            array_values([$UNVAN, $DIL, ...$docKosul])),
    ];
    $esikler[] = [
        'anahtar' => "bau-{$kod}-profesorluk",
        'universite' => $UNIVERSITE,
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => $profCetvel,
        'notlar' => $ad.' profesörlük asgari koşulları (MADDE 6).',
        'aday_notu' => $ad.' için profesör kadrosuna atanma. Toplam puanın belirtilen kısmının '
            .'DOÇENT UNVANINDAN SONRAKİ çalışmalardan gelmesi gerekiyor.'.$NOT_CETVEL,
        'sart' => Kalip::ve('Profesör kadrosuna atanma — '.$ad,
            array_values([$UNVAN, $DIL, ...$profKosul])),
    ];
};

$P = fn (string $ad, string $grup, int $puan, ?array $donem = null): array => Kalip::puanDan(
    $ad, [$grup], $puan, $donem, madde: 'MADDE 6'
);
$DERS = fn (int $yariyil): array => Kalip::metrik(
    'Başvurudan önce en az '.$yariyil.' yarıyıl üniversitede öğretim deneyimi', 'ders_yariyil', $yariyil
);

// ── Diş Hekimliği Fakültesi ──
$tablo('dis', ['saglik'], 'Diş Hekimliği Fakültesi', 'Diş Hekimliği Fakültesi',
    [$P('A, B, C ve D türü yayınlardan en az 20 puan almak', 'A-B-C-D', 20), Kalip::toplam(20)],
    [$P('A, B, C ve D türü yayınlardan en az 40 puan almak', 'A-B-C-D', 40),
        Kalip::adet('En az bir uzmanlık ya da doktora tezi danışmanlığını tamamlamış olmak', ['H-1'], 1, madde: 'MADDE 6'),
        $DERS(2), Kalip::toplam(60), Kalip::toplam(30, $DOKTORA)],
    [$P('A, B, C ve D türü yayınlardan en az 80 puan almak', 'A-B-C-D', 80),
        Kalip::adet('En az iki uzmanlık ya da doktora tezi danışmanlığını tamamlamış olmak', ['H-1'], 2, madde: 'MADDE 6'),
        $DERS(4), Kalip::toplam(120), Kalip::toplam(60, $DOCENTLIK)]);

// ── Eğitim Bilimleri Fakültesi ──
$tablo('egitim', ['egitim'], null, 'Eğitim Bilimleri Fakültesi',
    [$P('A, B ve C türü yayınlardan en az 30 puan almak', 'A-B-C', 30), Kalip::toplam(50)],
    [$P('A, B ve C türü yayınlardan en az 80 puan almak', 'A-B-C', 80),
        Kalip::toplam(140), Kalip::toplam(40, $DOKTORA)],
    [$P('A, B ve C türü yayınlardan en az 140 puan almak', 'A-B-C', 140),
        Kalip::toplam(240), Kalip::toplam(80, $DOCENTLIK)]);

// ── Eczacılık Fakültesi ──
$tablo('eczacilik', ['saglik'], 'Eczacılık Fakültesi', 'Eczacılık Fakültesi',
    [$P('A-1.1 ve A-2.1 türündeki makalelerden en az 20 puan almak', 'A-1.1-A-2.1', 20),
        $P('B türü bildirilerden en az 4 puan almak', 'B', 4),
        $P('D türü araştırma projelerinden en az 5 puan almak', 'D', 5),
        Kalip::toplam(35)],
    [Kalip::adet('Doktor unvanını aldıktan sonra A-1.1 ya da A-2.1 türündeki en az iki makalede başlıca yazar olmak', ['A-1.1-A-2.1'], 2, yazar: 'baslica', donem: $DOKTORA, madde: 'MADDE 6'),
        $P('Doktor unvanını aldıktan sonra A türü yayınlardan en az 60 puan almak', 'A', 60, $DOKTORA),
        $P('Doktor unvanını aldıktan sonra B türü bildirilerden en az 8 puan almak', 'B', 8, $DOKTORA),
        Kalip::toplam(140), Kalip::toplam(90, $DOKTORA)],
    [Kalip::adet('Doçent unvanını aldıktan sonra A-1.1 ya da A-2.1 türündeki en az üç makalede başlıca yazar olmak', ['A-1.1-A-2.1'], 3, yazar: 'baslica', donem: $DOCENTLIK, madde: 'MADDE 6'),
        $P('Doçent unvanını aldıktan sonra A türü yayınlardan en az 90 puan almak', 'A', 90, $DOCENTLIK),
        $P('Doçent unvanını aldıktan sonra B türü bildirilerden en az 4 puan almak', 'B', 4, $DOCENTLIK),
        $P('Doçent unvanını aldıktan sonra D türü araştırma projelerinden en az 30 puan almak', 'D', 30, $DOCENTLIK),
        Kalip::toplam(280), Kalip::toplam(140, $DOCENTLIK)],
    'bau-2025', 'bau-2025-ecz-doc', 'bau-2025-cap80');

// ── Hukuk Fakültesi ──
$tablo('hukuk', ['hukuk'], null, 'Hukuk Fakültesi',
    [$P('A, B, C ve D türü yayınlardan en az 20 puan almak', 'A-B-C-D', 20), Kalip::toplam(30)],
    [$P('A, B, C ve D türü yayınlardan en az 40 puan almak', 'A-B-C-D', 40),
        Kalip::toplam(60), Kalip::toplam(30, $DOKTORA)],
    [$P('A, B, C ve D türü yayınlardan en az 80 puan almak', 'A-B-C-D', 80),
        Kalip::toplam(120), Kalip::toplam(40, $DOCENTLIK)]);

// ── İktisadi, İdari ve Sosyal Bilimler Fakültesi ──
$tablo('iisbf', ['sosyal'], 'İktisadi, İdari ve Sosyal Bilimler Fakültesi',
    'İktisadi, İdari ve Sosyal Bilimler Fakültesi',
    [$P('A-1 ve A-2 türü makalelerden en az 12 puan almak', 'A-1-A-2', 12), Kalip::toplam(40)],
    [Kalip::veya('Makale koşulunu sağlamak', [
        Kalip::ve('Scopus Q1 ya da SCI-SSCI-AHCI dergilerinde iki yayın', [
            Kalip::adet('A-1.1 ya da A-2.1 grubundan en az iki yayın yapmış olmak', ['A-1.1-A-2.1'], 2, madde: 'MADDE 6'),
            Kalip::puanDan('A-1 ve A-2 türü makalelerden en az 20 puan almak', ['A-1-A-2'], 20, madde: 'MADDE 6'),
        ]),
        Kalip::ve('A-1 ve A-2 gruplarında üç yayın', [
            Kalip::adet('A-1 ve A-2 gruplarından en az üç yayın yapmış olmak', ['A-1-A-2'], 3, madde: 'MADDE 6'),
            Kalip::puanDan('A-1 ve A-2 türü makalelerden en az 20 puan almak', ['A-1-A-2'], 20, madde: 'MADDE 6'),
        ]),
    ]),
        Kalip::adet('D-1, D-2, D-4 ya da D-5 türü bir araştırma projesinde yer almak', ['D-YURUTUCU-ARASTIRMACI'], 1, madde: 'MADDE 6'),
        Kalip::toplam(140), Kalip::toplam(100, $DOKTORA)],
    [Kalip::adet('Doçentlikten sonra A-1 ve A-2 gruplarından en az iki yayın yapmış olmak', ['A-1-A-2'], 2, donem: $DOCENTLIK, madde: 'MADDE 6'),
        $P('Doçentlikten sonra A-1 ve A-2 türü makalelerden en az 20 puan almak', 'A-1-A-2', 20, $DOCENTLIK),
        Kalip::adet('D-1, D-2, D-4 ya da D-5 türü iki araştırma projesinde yer almak (en az biri doçentlikten sonra)', ['D-YURUTUCU-ARASTIRMACI'], 2, madde: 'MADDE 6'),
        Kalip::adet('Bu projelerden en az birinin doçentlikten sonra olması', ['D-YURUTUCU-ARASTIRMACI'], 1, donem: $DOCENTLIK, madde: 'MADDE 6'),
        $P('Tamamlanmış tez danışmanlıklarından en az 8 puan almak', 'H-1', 8),
        Kalip::toplam(230), Kalip::toplam(100, $DOCENTLIK)]);

// ── İletişim Fakültesi ──
$tablo('iletisim', ['sosyal'], 'İletişim Fakültesi', 'İletişim Fakültesi',
    [$P('A türü yayınlardan en az 10 puan almak', 'A', 10),
        $P('B türü bildirilerden en az 10 puan almak', 'B', 10),
        $P('C türü kitaplardan en az 10 puan almak', 'C', 10),
        Kalip::toplam(45)],
    [$P('A türü yayınlardan en az 25 puan almak', 'A', 25),
        $P('B türü bildirilerden en az 10 puan almak', 'B', 10),
        $P('C türü kitaplardan en az 10 puan almak', 'C', 10),
        Kalip::adet('En az iki yüksek lisans tezi danışmanlığını tamamlamış olmak', ['H-1.2'], 2, madde: 'MADDE 6'),
        Kalip::toplam(90), Kalip::toplam(45, $DOKTORA)],
    [$P('A türü yayınlardan en az 40 puan almak', 'A', 40),
        $P('B türü bildirilerden en az 15 puan almak', 'B', 15),
        $P('C türü kitaplardan en az 25 puan almak', 'C', 25),
        Kalip::veya('Tez danışmanlığı koşulunu sağlamak', [
            Kalip::adet('En az dört yüksek lisans tezi danışmanlığını tamamlamış olmak', ['H-1.2'], 4, madde: 'MADDE 6'),
            Kalip::adet('En az iki doktora tezi danışmanlığını tamamlamış olmak', ['H-1.1'], 2, madde: 'MADDE 6'),
        ]),
        Kalip::toplam(180), Kalip::toplam(90, $DOCENTLIK)]);

// ── Mimarlık ve Tasarım Fakültesi ──
$tablo('mimarlik', ['mimarlik'], null, 'Mimarlık ve Tasarım Fakültesi',
    [$P('A, B, C ve F-3 türü etkinliklerden en az 20 puan almak', 'MIMARLIK-ANA', 20),
        Kalip::adet('A-1, A-2 ya da C-1 – C-6 türünde en az bir yayın yapmış olmak', ['A-1-A-2', 'C-1-C-6'], 1, madde: 'MADDE 6'),
        $P('B türü bildiriler ile Scopus ve BKCI dışındaki kitaplardan en az 10 puan almak', 'B', 10),
        Kalip::toplam(20)],
    [$P('A, B, C ve F-3 türü etkinliklerden en az 60 puan almak', 'MIMARLIK-ANA', 60),
        $P('Bu 60 puanın en az 30\'unu doktora sonrası çalışmalardan almak', 'MIMARLIK-ANA', 30, $DOKTORA),
        Kalip::adet('A-1, A-2 ya da C-1 – C-6 türünde en az üç yayın yapmış olmak', ['A-1-A-2', 'C-1-C-6'], 3, madde: 'MADDE 6'),
        Kalip::adet('Bu yayınların en az ikisinin doktora sonrası olması', ['A-1-A-2', 'C-1-C-6'], 2, donem: $DOKTORA, madde: 'MADDE 6'),
        $P('B türü bildiriler ile Scopus ve BKCI dışındaki kitaplardan en az 20 puan almak', 'B', 20),
        $P('Tez yönetiminden en az 6 puan almak', 'H-1', 6),
        $DERS(2), Kalip::toplam(100), Kalip::toplam(50, $DOKTORA)],
    [$P('A, B, C ve F-3 türü etkinliklerden en az 120 puan almak', 'MIMARLIK-ANA', 120),
        $P('Bu 120 puanın en az 60\'ını doçentlik sonrası çalışmalardan almak', 'MIMARLIK-ANA', 60, $DOCENTLIK),
        Kalip::adet('A-1, A-2 ya da C-1 – C-6 türünde en az beş yayın yapmış olmak', ['A-1-A-2', 'C-1-C-6'], 5, madde: 'MADDE 6'),
        Kalip::adet('Bu yayınların en az üçünün doçentlik sonrası olması', ['A-1-A-2', 'C-1-C-6'], 3, donem: $DOCENTLIK, madde: 'MADDE 6'),
        $P('B türü bildiriler ile Scopus ve BKCI dışındaki kitaplardan en az 40 puan almak', 'B', 40),
        $P('Tez yönetiminden en az 12 puan almak', 'H-1', 12),
        $DERS(4), Kalip::toplam(200), Kalip::toplam(100, $DOCENTLIK)]);

// ── Mühendislik ve Doğa Bilimleri Fakültesi ──
$tablo('muhendislik', ['muhendislik', 'fen'], null, 'Mühendislik ve Doğa Bilimleri Fakültesi',
    [$P('A-1.1 ve A-2.1 türündeki makalelerden en az 14 puan almak', 'A-1.1-A-2.1', 14),
        $P('B türü bildirilerden en az 4 puan almak', 'B', 4),
        Kalip::toplam(35)],
    [Kalip::adet('Doktor unvanını aldıktan sonra A-1.1 ya da A-2.1 türündeki en az bir makalede başlıca yazar olmak', ['A-1.1-A-2.1'], 1, yazar: 'baslica', donem: $DOKTORA, madde: 'MADDE 6'),
        $P('Doktor unvanını aldıktan sonra A türü yayınlardan en az 48 puan almak', 'A', 48, $DOKTORA),
        $P('Doktor unvanını aldıktan sonra B türü bildirilerden en az 4 puan almak', 'B', 4, $DOKTORA),
        $P('D türü araştırma projelerinden en az 20 puan almak', 'D', 20),
        Kalip::toplam(140), Kalip::toplam(90, $DOKTORA)],
    [Kalip::adet('Doçent unvanını aldıktan sonra A-1.1 ya da A-2.1 türündeki en az bir makalede başlıca yazar olmak', ['A-1.1-A-2.1'], 1, yazar: 'baslica', donem: $DOCENTLIK, madde: 'MADDE 6'),
        $P('Doçent unvanını aldıktan sonra A türü yayınlardan en az 60 puan almak', 'A', 60, $DOCENTLIK),
        $P('Doçent unvanını aldıktan sonra B türü bildirilerden en az 4 puan almak', 'B', 4, $DOCENTLIK),
        $P('Doçent unvanını aldıktan sonra D türü araştırma projelerinden en az 30 puan almak', 'D', 30, $DOCENTLIK),
        Kalip::toplam(280), Kalip::toplam(140, $DOCENTLIK)],
    'bau-2025', 'bau-2025-muh-doc', 'bau-2025-cap80');

// ── Sağlık Bilimleri Fakültesi ──
$tablo('saglik-bilimleri', ['saglik'], 'Sağlık Bilimleri Fakültesi', 'Sağlık Bilimleri Fakültesi',
    [$P('A, B, C ve D türü yayınlardan en az 25 puan almak', 'A-B-C-D', 25),
        $P('E, F, G ve H türü etkinliklerden en az 5 puan almak', 'E-F-G-H', 5),
        Kalip::toplam(30)],
    [$P('A, B, C ve D türü yayınlardan en az 50 puan almak', 'A-B-C-D', 50),
        $P('E, F, G ve H türü etkinliklerden en az 10 puan almak', 'E-F-G-H', 10),
        Kalip::toplam(60), Kalip::toplam(30, $DOKTORA)],
    [$P('A, B, C ve D türü yayınlardan en az 100 puan almak', 'A-B-C-D', 100),
        $P('E, F, G ve H türü etkinliklerden en az 20 puan almak', 'E-F-G-H', 20),
        Kalip::toplam(120), Kalip::toplam(60, $DOCENTLIK)]);

// ── Tıp Fakültesi ──
$tablo('tip', ['saglik'], 'Tıp Fakültesi', 'Tıp Fakültesi',
    [$P('A, B, C ve D türü yayınlardan en az 30 puan almak', 'A-B-C-D', 30), Kalip::toplam(30)],
    [$P('A, B, C ve D türü yayınlardan en az 60 puan almak', 'A-B-C-D', 60),
        Kalip::toplam(90), Kalip::toplam(60, $DOKTORA)],
    [$P('A, B, C ve D türü yayınlardan en az 90 puan almak', 'A-B-C-D', 90),
        Kalip::toplam(180), Kalip::toplam(90, $DOCENTLIK)]);

// ── Uygulamalı Bilimler Yüksekokulu ──
$tablo('uygulamali', ['sosyal'], 'Uygulamalı Bilimler Yüksekokulu',
    'Uygulamalı Bilimler Yüksekokulu',
    [$P('A-1.1, A-1.4, A-2.1 ve A-2.2 türündeki makalelerden en az 12 puan almak', 'A-1.1-A-1.4-A-2.1-A-2.2', 12),
        $P('B türü bildirilerden en az 4 puan almak', 'B', 4),
        Kalip::toplam(30)],
    [Kalip::adet('Doktor unvanını aldıktan sonra A-1.1, A-1.4, A-2.1 ya da A-2.2 türündeki en az bir makalede başlıca yazar olmak', ['A-1.1-A-1.4-A-2.1-A-2.2'], 1, yazar: 'baslica', donem: $DOKTORA, madde: 'MADDE 6'),
        $P('Doktor unvanını aldıktan sonra A türü yayınlardan en az 30 puan almak', 'A', 30, $DOKTORA),
        $P('Doktor unvanını aldıktan sonra B türü bildirilerden en az 4 puan almak', 'B', 4, $DOKTORA),
        $P('D türü araştırma projelerinden en az 10 puan almak', 'D', 10),
        Kalip::toplam(90), Kalip::toplam(60, $DOKTORA)],
    [Kalip::adet('Doçent unvanını aldıktan sonra A-1.1, A-1.4, A-2.1 ya da A-2.2 türündeki en az bir makalede başlıca yazar olmak', ['A-1.1-A-1.4-A-2.1-A-2.2'], 1, yazar: 'baslica', donem: $DOCENTLIK, madde: 'MADDE 6'),
        $P('Doçent unvanını aldıktan sonra A türü yayınlardan en az 40 puan almak', 'A', 40, $DOCENTLIK),
        $P('Doçent unvanını aldıktan sonra B türü bildirilerden en az 4 puan almak', 'B', 4, $DOCENTLIK),
        $P('Doçent unvanını aldıktan sonra D türü araştırma projelerinden en az 20 puan almak', 'D', 20, $DOCENTLIK),
        Kalip::toplam(180), Kalip::toplam(80, $DOCENTLIK)],
    'bau-2025', 'bau-2025-uyg-doc', 'bau-2025-uyg-prof');

// ── Konservatuvar ──
$tablo('konservatuvar', ['guzel_sanatlar'], null, 'Konservatuvar',
    [$P('A, B ve C türü yayınlardan en az 15 puan almak', 'A-B-C', 15),
        Kalip::adet('A, B, C, F ve G türü yayın ve etkinliklerden en az üç adet', ['A-B-C-D-E-F-G'], 3, madde: 'MADDE 6'),
        Kalip::adet('Bunların en az ikisinin doktora sonrası olması', ['A-B-C-D-E-F-G'], 2, donem: $DOKTORA, madde: 'MADDE 6'),
        $P('A – G türü yayın ve etkinliklerden toplam en az 30 puan almak', 'A-B-C-D-E-F-G', 30),
        Kalip::toplam(50)],
    [$P('A, B ve C türü yayınlardan en az 20 puan almak', 'A-B-C', 20),
        Kalip::adet('A, B, C, F ve G türü yayın ve etkinliklerden en az dört adet', ['A-B-C-D-E-F-G'], 4, madde: 'MADDE 6'),
        Kalip::adet('Bunların en az ikisinin doktora sonrası olması', ['A-B-C-D-E-F-G'], 2, donem: $DOKTORA, madde: 'MADDE 6'),
        $P('A – G türü yayın ve etkinliklerden toplam en az 60 puan almak', 'A-B-C-D-E-F-G', 60),
        $P('Bu 60 puanın en az 30\'unu doktora ya da sanatta yeterlik sonrası çalışmalardan almak', 'A-B-C-D-E-F-G', 30, $DOKTORA),
        Kalip::adet('En az iki yüksek lisans tezi danışmanlığını tamamlamış olmak', ['H-1.2'], 2, madde: 'MADDE 6'),
        $DERS(2), Kalip::toplam(90), Kalip::toplam(45, $DOKTORA)],
    [$P('A, B ve C türü yayınlardan en az 40 puan almak', 'A-B-C', 40),
        Kalip::adet('A, B, C, F ve G türü yayın ve etkinliklerden en az altı adet', ['A-B-C-D-E-F-G'], 6, madde: 'MADDE 6'),
        Kalip::adet('Bunların en az üçünün doçentlik sonrası olması', ['A-B-C-D-E-F-G'], 3, donem: $DOCENTLIK, madde: 'MADDE 6'),
        $P('A – G türü yayın ve etkinliklerden toplam en az 120 puan almak', 'A-B-C-D-E-F-G', 120),
        $P('Bu 120 puanın en az 60\'ını doçentlik sonrası çalışmalardan almak', 'A-B-C-D-E-F-G', 60, $DOCENTLIK),
        Kalip::veya('Tez danışmanlığı koşulunu sağlamak', [
            Kalip::adet('En az dört yüksek lisans tezi danışmanlığını tamamlamış olmak', ['H-1.2'], 4, madde: 'MADDE 6'),
            Kalip::adet('En az iki doktora tezi danışmanlığını tamamlamış olmak', ['H-1.1'], 2, madde: 'MADDE 6'),
        ]),
        $DERS(4), Kalip::toplam(180), Kalip::toplam(90, $DOCENTLIK)]);

// ── Sağlık Hizmetleri Meslek Yüksekokulu ──
$tablo('shmyo', ['saglik'], 'Sağlık Hizmetleri Meslek Yüksekokulu',
    'Sağlık Hizmetleri Meslek Yüksekokulu',
    [$P('A, B, C, D ve E türü yayın ve etkinliklerden en az 20 puan almak', 'A-B-C-D-E', 20),
        Kalip::toplam(30)],
    [$P('A, B, C, D ve E türü yayın ve etkinliklerden en az 40 puan almak', 'A-B-C-D-E', 40),
        $DERS(2), Kalip::toplam(60), Kalip::toplam(30, $DOKTORA)],
    [$P('A, B, C, D ve E türü yayın ve etkinliklerden en az 80 puan almak', 'A-B-C-D-E', 80),
        $DERS(4), Kalip::toplam(120), Kalip::toplam(60, $DOCENTLIK)]);

// ═══════ DOKTOR ÖĞRETİM ÜYESİ — SÖZLEŞME YENİLENMESİ (MADDE 7) ═══════
$esikler[] = [
    'anahtar' => 'bau-dr-yeniden',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => ['saglik', 'egitim', 'hukuk', 'sosyal', 'mimarlik', 'muhendislik', 'fen',
        'guzel_sanatlar'],
    'cetvel' => 'bau-2025',
    'notlar' => 'MADDE 7: sözleşme yenilenmesi puan barajına değil, son üç yıllık eğitim ve '
        .'araştırma faaliyetlerini değerlendiren üç kişilik jürinin raporuna bağlı.',
    'aday_notu' => 'Doktor öğretim üyesi kadrosunda SÖZLEŞME YENİLENMESİ. Bahçeşehir '
        .'Üniversitesi yeniden atamaya sayısal bir puan barajı koymuyor: yönerge her dört yılın '
        .'sonunda bir değerlendirme öngörüyor ve bu değerlendirmede son ÜÇ YILDAKİ eğitim ve '
        .'araştırma faaliyetleriniz, biri üniversite dışından olmak üzere üç kişilik bir jüri '
        .'tarafından raporlanıyor. Sözleşmeler bir ya da iki yıllık sürelerle yenileniyor.',
    'sart' => Kalip::ve('Doktor öğretim üyesi sözleşmesinin yenilenmesi', [
        Kalip::beyan('Son üç yıldaki eğitim ve araştırma faaliyetlerinizin, biri üniversite dışından olmak üzere üç kişilik jüri tarafından olumlu değerlendirilmesi', 'MADDE 7'),
        Kalip::beyan('İlgili yönetim kurulunun önerisi ve Rektörün oluru', 'MADDE 7'),
    ]),
];

return $esikler;
