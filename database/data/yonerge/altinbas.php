<?php

/**
 * ALTINBAŞ ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Asgari
 * Koşulları
 * Kaynak: pdf/1770903886868.altinbasak-kriter-12022026.pdf (12.02.2026)
 * Cetvel: cetvel/altinbas-2026.php
 *
 * ── DÖRT ALAN GRUBU, DÖRDÜ DE GİRİLDİ ──
 * Doçentlik ve profesörlük için dört ayrı tablo var: Fen Bilimleri-Sağlık
 * Bilimleri-Mühendislik; Sosyal, Beşeri ve İdari Bilimler; Mimarlık,
 * Planlama ve Tasarım; Hukuk. Bu dördünün dışındaki temel alanlar (Eğitim,
 * Spor, Filoloji, İlahiyat, Güzel Sanatlar, Ziraat) yönergede HİÇ geçmiyor;
 * §0 uyarınca o alanlara doçentlik ve profesörlük eşiği YAZILMADI. Doktor
 * öğretim üyeliği koşulları "Tüm Disiplinler için" başlığı altında
 * verildiğinden bütün temel alanlara girildi.
 *
 * ── DOKTOR ÖĞRETİM ÜYELİĞİNDE PUAN BARAJI YOK ──
 * Yönerge bu kadro için hiçbir puan eşiği koymuyor: doktora ya da uzmanlık
 * eğitimini tamamlamış olmak ve bölüm başkanlığıyla koordine edilecek bir
 * deneme dersi vermek yeterli. Sıralanan yayın, indeks ve proje ölçütlerinin
 * hepsi "puan eşitliği durumunda TERCİH SEBEBİ"; koşul değil, bu yüzden
 * eşiğe girmedi, aday notunda anlatıldı. Yeniden atanmada ders verme
 * zorunlu hâle geliyor.
 *
 * ── ATIF VE DERS KOŞULLARI HESAPLANAMIYOR ──
 * Atıf satırları (0,5 ve 0,3 puan) ile ders yükü satırı (AKTS başına 0,5
 * puan) cetvele girilemedi; ayrıntısı cetvel dosyasının başlığında. Bu iki
 * kalemin puan koşulları eşiklerde `hesaplanamiyor` olarak duruyor: adaya
 * "koşul var, ama motor hesaplayamıyor, kendiniz kontrol edin" diyor.
 *
 * ── PROJE KOŞULUNDA ARA RAPOR BEYAN ──
 * Doçentlikte ve profesörlükte proje seçeneği "ana yürütücü veya ortak kurum
 * koordinatörü olmak VE en az bir olumlu ara rapor almış olmak" diyor. Kayıt
 * projenin rapor durumunu taşımadığı için yürütücülük sayıdan, olumlu ara
 * rapor beyandan kontrol ediliyor.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Doçentlikte "başvurduğu alanda lisansüstü programı olmayan bölümlerde
 *       görevli öğretim üyeleri için en az üç TÜBİTAK 2209-A veya 2209-B
 *       öğrenci projesi danışmanlığı" muafiyeti — kayıt projenin 2209
 *       olduğunu ayrı tutmuyor ve muafiyet yolunu açmak koşulu HAFİFLETİR.
 *   Fen-Sağlık-Mühendislik doçentliğinin dipnotu: "Tıp ve Diş Hekimliği
 *       Fakültelerinde klinik bilimlere yapılan başvurularda tez
 *       danışmanlığı yoksa h-endeksinin en az 8 olması" (profesörlükte 10)
 *       — profil adayın fakültesini ve klinik/temel ayrımını tutmuyor.
 *   Profesörlükte "Altınbaş Üniversitesi ADRESLİ olarak en az üç Q1 yayın"
 *       seçeneği — kayıt yayının adresini taşımıyor; beyan olarak duruyor.
 *   "Yükseköğretim kurumlarında en az 5 yıl profesör kadrosunda görev
 *       yapmış olanlar için 600 puan" seçeneği yalnız TOPLAM PUAN barajına
 *       alternatif olarak yazıldı. Belgede Sosyal tablosunda bu alternatif
 *       "Toplam" satırının içinde, öbür tablolarda ayrı madde işareti
 *       olarak duruyor; iki okumadan DAR olanı (§0) seçildi.
 *   Uluslararası deneyim satırları ("doktora sonrasında en az 3 aylık bir
 *       süreyi yurt dışında geçirmiş olması") — yönergenin kendisi bunlara
 *       "tercih sebebidir" diyor, koşul değil.
 *   Doktor öğretim üyeliğinin bütün "puan eşitliği durumunda tercih
 *       sebebidir" ölçütleri.
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Altınbaş Üniversitesi';
$CETVEL = 'altinbas-2026';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;

$TUM_ALANLAR = ['fen', 'saglik', 'muhendislik', 'sosyal', 'egitim', 'spor', 'filoloji',
    'hukuk', 'ilahiyat', 'mimarlik', 'guzel_sanatlar', 'ziraat'];
$FSM = ['fen', 'saglik', 'muhendislik'];
$SOSYAL = ['sosyal'];
$MIMARLIK = ['mimarlik'];
$HUKUK = ['hukuk'];

$NOT_ATIF_DERS = ' Atıf ve ders yükü koşulları HESAPLANAMIYOR olarak işaretli: yönerge '
    .'uluslararası atıfa 0,5, ulusal atıfa 0,3 ve her bir AKTS\'ye 0,5 puan veriyor; motor tam '
    .'sayı puan tuttuğu ve faaliyet kaydı AKTS taşımadığı için bu satırlar cetvele girilemedi. '
    .'Bu iki koşulu kendiniz kontrol etmelisiniz, toplam puanınıza da katkı vermiyorlar.';

$DOKTORA_BEYANI = Kalip::beyan(
    'Doktora ya da tıpta, diş hekimliğinde, eczacılıkta veya veteriner hekimlikte uzmanlık ya da sanatta yeterlik eğitimini tamamlamış olmak',
    'Doktor öğretim üyesi asgari koşulları'
);
$DENEME_DERSI = Kalip::beyan(
    'İlgili bölüm başkanlığıyla koordine edilecek bir deneme dersi vermek',
    'Tüm disiplinler için'
);
$UNVAN = Kalip::beyan(
    'Üniversitelerarası Kurul tarafından verilen doçentlik unvanına sahip olmak',
    '2547 s.K. m.24'
);
$BASLICA_ESER = Kalip::beyan(
    'Bir eseri başlıca eseriniz olarak göstermek',
    'Profesör kadrosuna atama koşulları'
);
$ARA_RAPOR = Kalip::beyan(
    'Yürütücüsü olduğunuz proje için en az bir olumlu ara rapor almış olmak',
    'Araştırma etkinlikleri'
);

/** ERC, Horizon Europe, TÜBİTAK ve benzeri projelerde ana yürütücülük. */
$anaYurutuculuk = Kalip::ve('Ulusal ya da uluslararası bir projede ana yürütücü veya ortak kurum koordinatörü olmak ve olumlu ara rapor almak', [
    Kalip::adet(
        'ERC, Horizon Europe, Erasmus+, COST, TÜBİTAK, TÜSEB, kalkınma ajansları, KOSGEB ve benzeri kuruluşlarca desteklenen bir projede ana yürütücü ya da ortak kurum koordinatörü olmak',
        ['PROJE-YURUTUCU'], 1, madde: 'Araştırma etkinlikleri'
    ),
    $ARA_RAPOR,
]);

/** Doçentlikteki "Araştırma etkinlikleri" bloğu: tez yönetimi ya da proje. */
$docArastirma = Kalip::veya('Araştırma etkinliklerinden en az birini sağlamak', [
    Kalip::ve('Tez yönetimi', [
        Kalip::adet(
            'Danışmanlığınızda en az üç lisansüstü ya da uzmanlık tezi tamamlanmış olmak',
            ['TEZ-YONETIMI'], 3, madde: 'Araştırma etkinlikleri/a'
        ),
        Kalip::puanDan('Tez yönetimi faaliyetlerinden en az 5 puan almak', ['TEZ-YONETIMI'], 5, madde: 'Araştırma etkinlikleri/a'),
    ]),
    $anaYurutuculuk,
]);

/** Profesörlükteki tez yönetimi bloğu. */
$profTez = Kalip::ve('Tez yönetimi koşulunu sağlamak', [
    Kalip::veya('Danışmanlığınızda en az bir doktora ya da üç yüksek lisans veya uzmanlık tezi tamamlanmış olmak', [
        Kalip::adet('Danışmanlığınızda en az bir doktora ya da uzmanlık tezi tamamlanmış olmak', ['TEZ-DOKTORA'], 1, madde: 'Tez yönetimi'),
        Kalip::adet('Danışmanlığınızda en az üç yüksek lisans tezi tamamlanmış olmak', ['TEZ-YUKSEK-LISANS'], 3, madde: 'Tez yönetimi'),
    ]),
    Kalip::puanDan('Tez yönetimi faaliyetlerinden en az 10 puan almak', ['TEZ-YONETIMI'], 10, madde: 'Tez yönetimi'),
]);

/** Profesörlükteki "Mesleki ve diğer araştırma etkinlikleri" bloğu. */
$profMesleki = Kalip::veya('Mesleki ve diğer araştırma etkinliklerinden en az birini sağlamak', [
    $anaYurutuculuk,
    Kalip::beyan(
        'Altınbaş Üniversitesi adresli olarak SCI, SSCI ya da A&HCI dizinli dergilerde en az üç Q1 sınıfı yayının yazarı olmak',
        'Mesleki ve diğer araştırma etkinlikleri/b'
    ),
    Kalip::adet(
        'SCI, SSCI ya da A&HCI dizinli dergilerde en az beş Q1 veya Q2 sınıfı yayının yazarı olmak',
        ['Q1-Q2'], 5, madde: 'Mesleki ve diğer araştırma etkinlikleri/c'
    ),
]);

/** Profesörlükteki toplam puan barajı; 5 yıllık profesörlük alternatifiyle. */
$profToplam = function (int $toplam, int $docentlikSonrasi): array {
    return Kalip::veya('Toplam puan barajını sağlamak', [
        Kalip::ve('Asgari toplam puan', [
            Kalip::toplam($toplam),
            Kalip::toplam($docentlikSonrasi, Kalip::DOCENTLIK_SONRASI),
        ]),
        Kalip::ve('Beş yıl profesörlük yapmış adaylar için', [
            Kalip::beyan('Yükseköğretim kurumlarında en az beş yıl profesör kadrosunda görev yapmış olmak', 'Toplam'),
            Kalip::toplam(600),
        ]),
    ]);
};

$esikler = [];

// ═══════════════ DOKTOR ÖĞRETİM ÜYESİ ═══════════════
$esikler[] = [
    'anahtar' => 'altinbas-dr',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => $TUM_ALANLAR,
    'cetvel' => $CETVEL,
    'notlar' => 'Doktor öğretim üyesi asgari koşulları: doktora ya da uzmanlık eğitimini '
        .'tamamlamış olmak ve deneme dersi vermek. Puan barajı yok; yayın, indeks ve proje '
        .'ölçütleri yalnız puan eşitliği hâlinde tercih sebebi.',
    'aday_notu' => 'Altınbaş Üniversitesi doktor öğretim üyesi kadrosuna İLK ATANMA için PUAN '
        .'BARAJI KOYMUYOR. Aranan tek şey doktora ya da uzmanlık eğitimini tamamlamış olmanız '
        .'ve ilgili bölüm başkanlığıyla koordine edilecek bir deneme dersi vermeniz. Yönergenin '
        .'saydığı öbür ölçütler — en az bir yarıyıl ders vermiş olmak, SCI, SSCI, SCI-Expanded, '
        .'A&HCI ya da alan indekslerinde yayın sahibi olmak, indeksli dergilerde makalesi '
        .'bulunmak, ulusal veya uluslararası bir projede yürütücü ya da araştırmacı olmak — '
        .'koşul değil, adaylar arasında PUAN EŞİTLİĞİ olması hâlinde tercih sebebi.',
    'sart' => Kalip::ve('Doktor öğretim üyesi kadrosuna ilk atanma', [
        $DOKTORA_BEYANI,
        $DENEME_DERSI,
    ]),
];

$esikler[] = [
    'anahtar' => 'altinbas-dr-yeniden',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => $TUM_ALANLAR,
    'cetvel' => $CETVEL,
    'notlar' => 'Yeniden atanmada ders verme zorunlu: en az bir yarıyıl ders vermiş olmak ve '
        .'2547 sayılı Yükseköğretim Personel Kanunu uyarınca bir dönemde en az 10 AKTS ders '
        .'yükünü tamamlamış olmak.',
    'aday_notu' => 'Doktor öğretim üyesi kadrosuna YENİDEN ATANMA. İlk atanmada tercih sebebi '
        .'olan "en az bir yarıyıl ders vermiş olmak" burada ZORUNLU. Ayrıca bir dönemde en az '
        .'10 AKTS\'lik ders yükünü tamamlamış olmanız gerekiyor; faaliyet kaydı AKTS taşımadığı '
        .'için bu koşul beyan olarak duruyor. Yeniden atanmada da puan barajı yok.',
    'sart' => Kalip::ve('Doktor öğretim üyesi kadrosuna yeniden atanma', [
        $DOKTORA_BEYANI,
        Kalip::metrik('En az bir yarıyıl ders vermiş olmak', 'ders_yariyil', 1),
        Kalip::beyan('Bir dönemde en az 10 AKTS\'lik ders yükünü tamamlamış olmak', 'Yeniden atamalarda'),
    ]),
];

// ═══════════════ DOÇENT ═══════════════
$docentlikAlanlari = [
    ['fsm', $FSM, 'Fen Bilimleri, Sağlık Bilimleri ve Mühendislik'],
    ['sosyal', $SOSYAL, 'Sosyal, Beşeri ve İdari Bilimler'],
    ['mimarlik', $MIMARLIK, 'Mimarlık, Planlama ve Tasarım'],
];

foreach ($docentlikAlanlari as [$kod, $alanlar, $alanAdi]) {
    $esikler[] = [
        'anahtar' => "altinbas-{$kod}-docentlik",
        'universite' => $UNIVERSITE,
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => $alanAdi.' doçentlik: yayınlardan 60 puan ya da h-endeksi 7 ya da sektör '
            .'deneyimi; atıflardan 15 puan; tez yönetimi ya da proje yürütücülüğü; verilen '
            .'derslerden 30 puan; toplam 200 puan (en az 100\'ü doktora sonrası).',
        'aday_notu' => $alanAdi.' alanlarında doçent kadrosuna atanma. Yayın koşulunu üç yoldan '
            .'biriyle karşılayabilirsiniz: A türü uluslararası makale, uluslararası kitap '
            .'bölümü ve TR Dizin makalelerinden 60 puan; h-endeksinizin en az 7 olması; ya da '
            .'uzmanlık alanınızda üniversite dışındaki sektörlerde en az on yıllık profesyonel '
            .'deneyim. Araştırma etkinliği koşulu için ya danışmanlığınızda en az üç lisansüstü '
            .'tez tamamlanmış olmalı ya da desteklenen bir projede ana yürütücü olmalısınız. '
            .'Toplam 200 puanın en az 100\'ü doktora sonrası çalışmalarınızdan gelmeli.'
            .$NOT_ATIF_DERS,
        'sart' => Kalip::ve('Doçent kadrosuna atanma — '.$alanAdi, [
            $UNVAN,
            Kalip::veya('Yayın koşullarından en az birini sağlamak', [
                Kalip::puanDan('A türü uluslararası makale, uluslararası kitap bölümü ve ulusal makale ile kitap bölümü kalemlerinden en az 60 puan almak', ['DOC-YAYIN'], 60, madde: 'Yayınlar/a'),
                Kalip::metrik('h-endeksinizin en az 7 olması', 'h_indeksi', 7),
                Kalip::beyan('Uzmanlık alanınızla ilgili olarak üniversite dışındaki sektörlerde en az on yıl profesyonel deneyim sahibi olmak', 'Yayınlar/c'),
            ]),
            Kalip::hesaplanamiyor('Makale ya da kitap atıflarından en az 15 puan almak', 'Atıflar'),
            $docArastirma,
            Kalip::hesaplanamiyor('Verilen derslerden en az 30 puan almak (her bir AKTS 0,5 puan)', 'Verilen Dersler'),
            Kalip::toplam(200),
            Kalip::toplam(100, $DOKTORA),
        ]),
    ];
}

$esikler[] = [
    'anahtar' => 'altinbas-hukuk-docentlik',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => $HUKUK,
    'cetvel' => $CETVEL,
    'notlar' => 'Hukuk doçentlik: yayınlardan 15 puan ya da h-endeksi 7 ya da sektör deneyimi; '
        .'kitaplardan 25 puan; ulusal makale ve kitap kalemlerinden 50 puan (en az 30\'u '
        .'doktora sonrası); atıflardan 5 puan; tez yönetimi ya da proje; derslerden 30 puan; '
        .'toplam 120 puan (en az 70\'i doktora sonrası).',
    'aday_notu' => 'Hukuk alanında doçent kadrosuna atanma. Hukukun eşikleri öbür alanlardan '
        .'belirgin biçimde düşük (yayınlarda 60 yerine 15, toplamda 200 yerine 120 puan) ama '
        .'kitap koşulu var: kitaplardan en az 25 puan ve ulusal makale ile kitap '
        .'kalemlerinden 50 puan gerekiyor. Yönergenin kitap satırı uluslararası '
        .'kitapları gösteriyor; tanınmış ile diğer yayınevi ayrımı kayıtta taşınmadığı için '
        .'ulusal kitaplarınız da bu koşula sayılıyor.'.$NOT_ATIF_DERS,
    'sart' => Kalip::ve('Doçent kadrosuna atanma — Hukuk', [
        $UNVAN,
        Kalip::veya('Yayın koşullarından en az birini sağlamak', [
            Kalip::puanDan('A türü uluslararası makale, uluslararası kitap bölümü ve ulusal makale ile kitap bölümü kalemlerinden en az 15 puan almak', ['DOC-YAYIN'], 15, madde: 'Yayınlar/a'),
            Kalip::metrik('h-endeksinizin en az 7 olması', 'h_indeksi', 7),
            Kalip::beyan('Uzmanlık alanınızla ilgili olarak üniversite dışındaki sektörlerde en az on yıl profesyonel deneyim sahibi olmak', 'Yayınlar/c'),
        ]),
        Kalip::puanDan('Kitaplardan en az 25 puan almak', ['KITAP-ULUSLARARASI'], 25, madde: 'Kitaplar'),
        Kalip::puanDan('Ulusal makale, ulusal kitap bölümü ve ulusal kitap kalemlerinden en az 50 puan almak', ['ULUSAL-MAKALE-KITAP'], 50, madde: 'Ulusal yayınlar'),
        Kalip::puanDan('Bu 50 puanın en az 30\'unu doktora sonrası çalışmalarınızdan almak', ['ULUSAL-MAKALE-KITAP'], 30, $DOKTORA, madde: 'Ulusal yayınlar'),
        Kalip::hesaplanamiyor('Makale ya da kitap atıflarından en az 5 puan almak', 'Atıflar'),
        $docArastirma,
        Kalip::hesaplanamiyor('Verilen derslerden en az 30 puan almak (her bir AKTS 0,5 puan)', 'Verilen Dersler'),
        Kalip::toplam(120),
        Kalip::toplam(70, $DOKTORA),
    ]),
];

// ═══════════════ PROFESÖR ═══════════════
$esikler[] = [
    'anahtar' => 'altinbas-fsm-profesorluk',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => $FSM,
    'cetvel' => $CETVEL,
    'notlar' => 'Fen Bilimleri, Sağlık Bilimleri ve Mühendislik profesörlük: yayınlardan 100 '
        .'puan ya da h-endeksi 9; atıflardan 30 puan; tez yönetiminden 10 puan (ön koşul: bir '
        .'doktora ya da üç yüksek lisans tezi); mesleki araştırma etkinliklerinden biri; '
        .'derslerden 30 puan; toplam 400 puan (en az 200\'ü doçentlik sonrası).',
    'aday_notu' => 'Fen Bilimleri, Sağlık Bilimleri ve Mühendislik alanlarında profesör '
        .'kadrosuna atanma. Yayın koşulunu 100 puanla ya da h-endeksinizin en az 9 olmasıyla '
        .'karşılayabilirsiniz. Mesleki araştırma etkinliği koşulu için üç yoldan biri yeterli: '
        .'desteklenen bir projede ana yürütücülük, Altınbaş adresli üç Q1 yayın ya da beş Q1-Q2 '
        .'yayın. Toplam puan barajını, yükseköğretim kurumlarında en az beş yıl profesör '
        .'kadrosunda görev yaptıysanız 600 puanla da geçebilirsiniz.'.$NOT_ATIF_DERS,
    'sart' => Kalip::ve('Profesör kadrosuna atanma — Fen, Sağlık ve Mühendislik', [
        Kalip::veya('Yayın koşullarından en az birini sağlamak', [
            Kalip::puanDan('A ve B türü uluslararası makale, uluslararası kitap bölümü ve ulusal makale ile kitap bölümü kalemlerinden en az 100 puan almak', ['PROF-YAYIN-FSM'], 100, madde: 'Yayınlar/a'),
            Kalip::metrik('h-endeksinizin en az 9 olması', 'h_indeksi', 9),
        ]),
        Kalip::hesaplanamiyor('Makale ya da kitap atıflarından en az 30 puan almak', 'Atıflar'),
        $profTez,
        $profMesleki,
        Kalip::hesaplanamiyor('Verilen derslerden en az 30 puan almak (her bir AKTS 0,5 puan)', 'Verilen Dersler'),
        $profToplam(400, 200),
        $BASLICA_ESER,
    ]),
];

$esikler[] = [
    'anahtar' => 'altinbas-sosyal-profesorluk',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => $SOSYAL,
    'cetvel' => $CETVEL,
    'notlar' => 'Sosyal, Beşeri ve İdari Bilimler profesörlük: yayınlardan 100 puan ya da '
        .'h-endeksi 9; kitap ve kitap editörlüğü kalemlerinden 50 puan; atıflardan 30 puan; tez '
        .'yönetiminden 10 puan; mesleki araştırma etkinliklerinden biri; derslerden 30 puan; '
        .'toplam 400 puan (en az 200\'ü doçentlik sonrası).',
    'aday_notu' => 'Sosyal, Beşeri ve İdari Bilimler alanında profesör kadrosuna atanma. Fen ve '
        .'Mühendislikten farklı olarak kitap ve kitap editörlüğü kalemlerinden en az 50 puan '
        .'ayrıca aranıyor. Toplam puan barajını, yükseköğretim kurumlarında en az beş yıl '
        .'profesör kadrosunda görev yaptıysanız 600 puanla da geçebilirsiniz.'.$NOT_ATIF_DERS,
    'sart' => Kalip::ve('Profesör kadrosuna atanma — Sosyal, Beşeri ve İdari Bilimler', [
        Kalip::veya('Yayın koşullarından en az birini sağlamak', [
            Kalip::puanDan('A türü uluslararası makale, uluslararası kitap bölümü ve ulusal makale ile kitap bölümü kalemlerinden en az 100 puan almak', ['DOC-YAYIN'], 100, madde: 'Yayınlar/a'),
            Kalip::metrik('h-endeksinizin en az 9 olması', 'h_indeksi', 9),
        ]),
        Kalip::puanDan('Kitap ve kitap editörlüğü kalemlerinden en az 50 puan almak', ['KITAP-VE-EDITORLUK'], 50, madde: 'Kitaplar'),
        Kalip::hesaplanamiyor('Makale ya da kitap atıflarından en az 30 puan almak', 'Atıflar'),
        $profTez,
        $profMesleki,
        Kalip::hesaplanamiyor('Verilen derslerden en az 30 puan almak (her bir AKTS 0,5 puan)', 'Verilen Dersler'),
        $profToplam(400, 200),
        $BASLICA_ESER,
    ]),
];

$esikler[] = [
    'anahtar' => 'altinbas-mimarlik-profesorluk',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => $MIMARLIK,
    'cetvel' => $CETVEL,
    'notlar' => 'Mimarlık, Planlama ve Tasarım profesörlük: yayınlardan (uluslararası mimari ve '
        .'sanatsal ödüller dâhil) 100 puan ya da h-endeksi 9; mesleki araştırma '
        .'etkinliklerinden biri; atıflardan 30 puan; tez yönetiminden 10 puan; derslerden 30 '
        .'puan; toplam 400 puan (en az 200\'ü doçentlik sonrası).',
    'aday_notu' => 'Mimarlık, Planlama ve Tasarım alanında profesör kadrosuna atanma. Bu alanda '
        .'100 puanlık yayın barajına uluslararası mimari ve sanatsal ödül kalemleri de '
        .'sayılıyor. Toplam puan barajını, yükseköğretim kurumlarında en az beş yıl profesör '
        .'kadrosunda görev yaptıysanız 600 puanla da geçebilirsiniz.'.$NOT_ATIF_DERS,
    'sart' => Kalip::ve('Profesör kadrosuna atanma — Mimarlık, Planlama ve Tasarım', [
        Kalip::veya('Yayın koşullarından en az birini sağlamak', [
            Kalip::puanDan('Uluslararası ve ulusal makale, kitap bölümü ile uluslararası mimari ve sanatsal ödül kalemlerinden en az 100 puan almak', ['PROF-YAYIN-MIMARLIK'], 100, madde: 'Yayınlar/a'),
            Kalip::metrik('h-endeksinizin en az 9 olması', 'h_indeksi', 9),
        ]),
        $profMesleki,
        Kalip::hesaplanamiyor('Makale ya da kitap atıflarından en az 30 puan almak', 'Atıflar'),
        $profTez,
        Kalip::hesaplanamiyor('Verilen derslerden en az 30 puan almak (her bir AKTS 0,5 puan)', 'Verilen Dersler'),
        $profToplam(400, 200),
        $BASLICA_ESER,
    ]),
];

$esikler[] = [
    'anahtar' => 'altinbas-hukuk-profesorluk',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => $HUKUK,
    'cetvel' => $CETVEL,
    'notlar' => 'Hukuk profesörlük: A türü uluslararası makale, ulusal makale ve ulusal kitap '
        .'kalemlerinden 30 puan; kitaplardan 40 puan (ön koşul: tek yazarlı bir kitap); ulusal '
        .'makale, kitap bölümü ve kitap kalemlerinden 100 puan (en az 60\'ı doçentlik sonrası); '
        .'atıflardan 15 puan; tez yönetiminden 10 puan; derslerden 25 puan; toplam 220 puan '
        .'(en az 140\'ı doçentlik sonrası).',
    'aday_notu' => 'Hukuk alanında profesör kadrosuna atanma. Hukukun yolu öbür alanlardan '
        .'farklı: h-endeksi ya da mesleki araştırma etkinliği alternatifi yok, bunun yerine '
        .'kitap ağırlıklı barajlar var. TEK YAZARLI bir kitabınızın olması ÖN KOŞUL. Toplam 220 '
        .'puanın en az 140\'ı doçentlik sonrası çalışmalarınızdan gelmeli; en az beş yıl '
        .'profesör kadrosunda görev yaptıysanız 600 puanla da geçebilirsiniz.'.$NOT_ATIF_DERS,
    'sart' => Kalip::ve('Profesör kadrosuna atanma — Hukuk', [
        Kalip::puanDan('A türü uluslararası makale, ulusal makale ve ulusal kitap kalemlerinden en az 30 puan almak', ['HUKUK-PROF-A'], 30, madde: 'Yayınlar'),
        Kalip::adet('Tek yazarlı bir kitabınızın olması', ['KITAP-ULUSLARARASI'], 1, yazar: 'tek', madde: 'Kitaplar'),
        Kalip::puanDan('Kitaplardan en az 40 puan almak', ['KITAP-ULUSLARARASI'], 40, madde: 'Kitaplar'),
        Kalip::puanDan('Ulusal makale, ulusal kitap bölümü ve ulusal kitap kalemlerinden en az 100 puan almak', ['ULUSAL-MAKALE-KITAP'], 100, madde: 'Ulusal yayınlar'),
        Kalip::puanDan('Bu 100 puanın en az 60\'ını doçentlik sonrası çalışmalarınızdan almak', ['ULUSAL-MAKALE-KITAP'], 60, $DOCENTLIK, madde: 'Ulusal yayınlar'),
        Kalip::hesaplanamiyor('Makale ya da kitap atıflarından en az 15 puan almak', 'Atıflar'),
        $profTez,
        Kalip::hesaplanamiyor('Verilen derslerden en az 25 puan almak (her bir AKTS 0,5 puan)', 'Verilen Dersler'),
        $profToplam(220, 140),
        $BASLICA_ESER,
    ]),
];

return $esikler;
