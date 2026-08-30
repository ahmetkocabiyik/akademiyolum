<?php

/**
 * PİRİ REİS ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma
 * Ölçütlerine İlişkin Senato Esasları
 * Kaynak: pdf/17634009071.Piri Reis Üniversitesi Kriter.pdf (25 sayfa;
 *         Senato 16.04.2025 tarih ve 2025/08 sayılı kararı. MADDE 14: 11 ve
 *         12. maddeler 01.06.2026'da, kalanı YÖK onayıyla yürürlüğe giriyor.)
 *
 * ÜNİVERSİTE KORPUSA BU DOSYAYLA GİRDİ: Piri Reis `universiteler.php`'de yoktu,
 * birlikte eklendi (İstanbul, vakıf). Ad listeye yazılmadan girilen eşikler
 * hesaplanır ama Yönerge Analizi ekranında adaya HİÇ GÖRÜNMEZ.
 *
 * DÖRT TEMEL ALAN, YÖNERGENİN KENDİ AYRIMI (MADDE 8-12): Mühendislik, Sosyal-
 * Beşeri-İdari Bilimler, Hukuk, Fen Bilimleri ve Matematik. Denizcilik
 * ağırlıklı bir üniversite olduğu için sağlık, eğitim, ilahiyat, filoloji,
 * spor, ziraat, mimarlık ve güzel sanatlar HİÇ ANILMIYOR; o alanlar için eşik
 * yazılmadı.
 *
 * BARAJLAR İKİ KATMANLI: toplam puanın belirli bir bölümü ÖNCEKİ UNVANDAN
 * SONRA kazanılmış olmalı.
 *   Dr. Öğr. Üyesi  toplam 20 puan (Fen Bilimleri ve Matematik'te 30)
 *   Doçent          toplam 100 puan · en az 90'ı doktora sonrası
 *   Profesör        toplam 200 puan · en az 100'ü doçentlik sonrası
 * İki katman da `Kalip::toplam` ile ayrı düğüm olarak yazıldı; dönemli olanın
 * metnine dönem kendiliğinden ekleniyor.
 *
 * ALTI CETVEL VARYANTI: yazar matrisi (MADDE 9), Hukuk'un yüksek kitap
 * puanları ve kadroya göre ikiye katlanan bölüm tavanları birlikte
 * değiştiğinden (alan grubu × kadro) çarpımı gerekti. Ayrıntı cetvel
 * dosyasının başlığında.
 *
 * HUKUK'UN DOÇENTLİK ŞARTI KORPUSTA ENDER BİR KURGU: "A veya B türü
 * yayınlardan EN AZ DÖRDÜ TEK YAZARLI olmak üzere, ÜÇÜ FARKLI DERGİDE
 * yayımlanmış en az altı yayın". "Üçü farklı dergide" koşulu faaliyet
 * kaydından okunamıyor (dergi adı tutulmuyor); yalnız altı yayın ve dördünün
 * tek yazarlı olması değerlendiriliyor, dergi çeşitliliği aday notunda
 * uyarı olarak duruyor.
 *
 * TEZDEN ÜRETİLMİŞ YAYIN KOŞULLARI `hesaplanamiyor`. Doçentlik ve
 * profesörlükte "lisansüstü tezlerden ÜRETİLMİŞ A, B, C ve D türü
 * yayınlardan en az bir yayını olmak" isteniyor; EK-1 tablosunda tez
 * yayınına ayrı satır yok, kayıt da bir yayının tez kökenini yalnız aday tez
 * yayını olarak kaydettiyse taşıyor.
 *
 * DERS KOŞULLARI BEYAN. "Son 2 yıl içerisinde iki dönem", "son 5 yıl
 * içerisinde dört dönem ders vermiş olmak" koşulları N bölümüne bağlı; o
 * bölümün puanı derse değil BLOĞA veriliyor ve cetvele hiç yazılmadı.
 *
 * DOKTORA TEZ İZLEME JÜRİSİ ALTERNATİFİ BEYAN: profesörlükte "K kapsamında en
 * az iki lisansüstü tez yönetmiş olmak VEYA en az iki doktora tezi izleme
 * jürisinde yer almış olmak" deniyor; ikinci kolun tabloda satırı yok.
 *
 * YENİDEN ATANMA HÜKMÜ YOK: yönerge yalnız ilk atama ve yükseltmeyi
 * düzenliyor.
 *
 * ÖN DEĞERLENDİRME BAĞLAYICI DEĞİL (MADDE 3/c-d): ölçütler "en alt düzeyi
 * belirler, yeterlilik anlamı taşımaz" ve yalnız başvurunun kabulü ya da
 * reddi için kullanılır.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: piri-reis-2025-*
 */

use App\Services\Scoring\Sart\Kalip;

$UNI = 'Piri Reis Üniversitesi';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;

$genelNot = 'Piri Reis\'in ölçütleri yönergenin kendi ifadesiyle "en alt düzeyi belirler, '
    .'yeterlilik anlamı taşımaz" ve yalnız başvurunun kabulü ya da reddi için kullanılır '
    .'. Jüri ayrıca akademik niteliğinizi ve yayın etiğini ayrıntılı '
    .'değerlendiriyor.';

$dersNotu = 'DERS KOŞULLARI BEYAN olarak duruyor: yönergenin eğitime katkı bölümü puanı derse '
    .'değil BLOĞA veriliyor ("dört farklı yarıyılda ders vermiş olmak"), bu yüzden o bölüm '
    .'cetvele hiç yazılmadı ve ders puanınız sıfır görünüyor.';

$tezNotu = 'Lisansüstü tezlerinizden ÜRETİLMİŞ yayın koşulu hesaplanamıyor: tabloda tez '
    .'yayınına ayrı satır yok. Koşulu belge ile göstermeniz gerekiyor.';

$drBeyani = Kalip::beyan('Doktor unvanı ya da sanatta yeterlik kazanmış olmak', 'Madde 10/1');
$docentBeyani = Kalip::beyan('2547 sayılı Kanun uyarınca doçent unvanını kazanmış olmak; unvan '
    .'yurt dışında alınmışsa Üniversitelerarası Kurul kararıyla Türkiye\'de geçerli sayılmış '
    .'olması', 'Madde 11/1');
$profBeyani = Kalip::beyan('Doçentlik unvanını aldıktan sonra en az beş yıl açık bulunan '
    .'profesörlük kadrosuyla ilgili bilim alanında çalışmış olmak ve doçentlik sonrası '
    .'yayınlarınızdan birini başlıca araştırma eseri olarak sunmak', 'Madde 12');

$tezYayini = fn (string $madde) => Kalip::hesaplanamiyor(
    'Lisansüstü tezlerinizden üretilmiş makale, kitap ya da bildirilerinizden en az bir yayın',
    $madde);

$dersBeyani = fn (int $donem, int $yil, string $madde) => Kalip::beyan(
    "Son {$yil} yıl içinde en az {$donem} dönem ön lisans, lisans ya da lisansüstü ders vermiş olmak",
    $madde);

$juriKolu = fn (string $madde) => Kalip::veya('Tez yönetimi koşulu', [
    Kalip::adet('Asıl ya da eş danışman olarak yönetilmiş en az 2 lisansüstü tez', ['K'], 2,
        madde: $madde),
    Kalip::beyan('En az 2 doktora tezi izleme jürisinde yer almış olmak', $madde),
]);

/**
 * @param  list<string>  $alanlar
 * @param  list<array<string, mixed>>  $cocuklar
 * @return array<string, mixed>
 */
$esik = function (string $anahtar, string $kadro, string $kadroAd, array $alanlar, string $cetvel,
    array $toplamlar, array $cocuklar, string $notlar, string $adayNotu) use ($UNI): array {
    return [
        'anahtar' => "piri-reis-{$anahtar}",
        'aday_notu' => $adayNotu,
        'universite' => $UNI,
        'kadro' => $kadro,
        'alan' => $alanlar,
        'cetvel' => $cetvel,
        'notlar' => $notlar,
        'sart' => Kalip::ve($kadroAd, array_values([...$toplamlar, ...$cocuklar])),
    ];
};

$YAYIN = 'Makale ve kitap kalemlerinizden';
$drNotu = $genelNot;
$ustNotu = $genelNot.' '.$dersNotu.' '.$tezNotu;

return [
    // ══════════════ DOKTOR ÖĞRETİM ÜYESİ (MADDE 10) ══════════════
    $esik('dr-muhendislik', 'dr_ogr_uyesi', 'Dr. Öğr. Üyesi', ['muhendislik'],
        'piri-reis-2025-fen', [Kalip::toplam(20)], [
            $drBeyani,
            Kalip::adet('Q1-Q4 dilimli uluslararası dergilerde en az 1 makale', ['A1'], 1,
                madde: 'Madde 10/2-a'),
            Kalip::adet('Uluslararası ya da ulusal bilimsel toplantıda en az 1 tam metinli bildiri',
                ['C.1.a', 'D.1.a'], 1, madde: 'Madde 10/2-a'),
        ],
        'MADDE 10/2-a: tüm kalemlerden toplam 20 puan; Q dilimli bir dergide en az bir makale '
        .'ve en az bir tam metinli bildiri.',
        $drNotu),
    $esik('dr-fen', 'dr_ogr_uyesi', 'Dr. Öğr. Üyesi', ['fen'],
        'piri-reis-2025-fen', [Kalip::toplam(30)], [
            $drBeyani,
            Kalip::adet('Q1-Q4 dilimli uluslararası dergilerde en az 1 makale', ['A1'], 1,
                madde: 'Madde 10/2-d'),
            Kalip::adet('Uluslararası ya da ulusal bilimsel toplantıda en az 1 bildiri', ['CD'], 1,
                madde: 'Madde 10/2-d'),
        ],
        'MADDE 10/2-d: Fen Bilimleri ve Matematik\'te toplam baraj 20 değil 30 puan.',
        'Fen Bilimleri ve Matematik alanında toplam baraj öteki alanlardan yüksek: 20 değil 30 '
        .'puan. '.$drNotu),
    $esik('dr-sosyal', 'dr_ogr_uyesi', 'Dr. Öğr. Üyesi', ['sosyal'],
        'piri-reis-2025-sosyal', [Kalip::toplam(20)], [
            $drBeyani,
            Kalip::adet('Uluslararası ya da ulusal hakemli dergilerde en az 2 makale',
                ['A-B'], 2, madde: 'Madde 10/2-b'),
            Kalip::adet('Uluslararası ya da ulusal bilimsel toplantıda en az 1 bildiri', ['CD'], 1,
                madde: 'Madde 10/2-b'),
            Kalip::adet('Kitap kalemlerinizden en az 1 yayın', ['EF'], 1, madde: 'Madde 10/2-b'),
        ],
        'MADDE 10/2-b: toplam 20 puan; makale kalemlerinden 2 yayın, 1 bildiri ve 1 kitap yayını.',
        $drNotu),
    $esik('dr-hukuk', 'dr_ogr_uyesi', 'Dr. Öğr. Üyesi', ['hukuk'],
        'piri-reis-2025-hukuk', [Kalip::toplam(20)], [
            $drBeyani,
            Kalip::adet('Uluslararası ya da ulusal hakemli dergilerde en az 1 makale',
                ['A-B'], 1, madde: 'Madde 10/2-c'),
            Kalip::adet('Uluslararası ya da ulusal bilimsel toplantıda en az 1 bildiri', ['CD'], 1,
                madde: 'Madde 10/2-c'),
            Kalip::adet('Kitap kalemlerinizden en az 1 yayın', ['EF'], 1, madde: 'Madde 10/2-c'),
        ],
        'MADDE 10/2-c: toplam 20 puan; en az 1 makale, 1 bildiri ve 1 kitap yayını.',
        'Hukuk temel alanında kitap yazarlığı ve kitap bölümü puanları dört kat yüksek '
        .'(5 yerine 20, 3 yerine 10). '.$drNotu),

    // ══════════════════════ DOÇENT (MADDE 11) ══════════════════════
    $esik('docentlik-muhendislik', 'docentlik', 'Doçent', ['muhendislik', 'fen'],
        'piri-reis-2025-fen', [Kalip::toplam(100), Kalip::toplam(90, $DOKTORA)], [
            $docentBeyani,
            Kalip::puanDan('Q dilimli uluslararası dergilerdeki makalelerinizden doktora '
                .'unvanınızdan sonra en az 40 puan', ['A1'], 40, $DOKTORA, madde: 'Madde 11/2-a.1'),
            Kalip::adet('Bu makalelerin en az birinde başlıca yazar olmak', ['A1'], 1,
                yazar: 'baslica', donem: $DOKTORA, madde: 'Madde 11/2-a.1'),
            Kalip::puanDan('TR Dizin dergilerindeki makalelerinizden doktora unvanınızdan sonra '
                .'en az 10 puan', ['B1'], 10, $DOKTORA, madde: 'Madde 11/2-a.2'),
            Kalip::puanDan('Bildiri kalemlerinizden doktora unvanınızdan sonra en az 5 puan',
                ['CD'], 5, $DOKTORA, madde: 'Madde 11/2-a.3'),
            $tezYayini('Madde 11/2-a.4'),
            Kalip::adet('Başarıyla tamamlanmış en az 1 bilimsel araştırma projesinde yer almak',
                ['P'], 1, madde: 'Madde 11/2-a.5'),
        ],
        'MADDE 11/2-a ve 11/2-d: toplam 100 puan, en az 90\'ı doktora sonrası; A.1\'den 40 puan '
        .'(birinde başlıca yazar), B.1\'den 10 puan, bildirilerden 5 puan, en az 1 proje.',
        $ustNotu),
    $esik('docentlik-sosyal', 'docentlik', 'Doçent', ['sosyal'],
        'piri-reis-2025-sosyal', [Kalip::toplam(100), Kalip::toplam(90, $DOKTORA)], [
            $docentBeyani,
            Kalip::puanDan('Uluslararası makale kalemlerinizden doktora unvanınızdan sonra en az '
                .'10 puan', ['A'], 10, $DOKTORA, madde: 'Madde 11/2-b.1'),
            Kalip::adet('TR Dizin dergilerinde doktora unvanınızdan sonra en az 5 makale',
                ['B1'], 5, donem: $DOKTORA, madde: 'Madde 11/2-b.1'),
            Kalip::adet('Bu makalelerin en az üçünde tek yazar olmak', ['B1'], 3, yazar: 'tek',
                donem: $DOKTORA, madde: 'Madde 11/2-b.1'),
            Kalip::puanDan('Bildiri kalemlerinizden doktora unvanınızdan sonra en az 5 puan',
                ['CD'], 5, $DOKTORA, madde: 'Madde 11/2-b.2'),
            Kalip::adet('Kitap kalemlerinizden doktora unvanınızdan sonra en az 1 yayın',
                ['EF'], 1, donem: $DOKTORA, madde: 'Madde 11/2-b.3'),
            Kalip::adet('Başarıyla tamamlanmış en az 1 bilimsel araştırma projesinde yer almak',
                ['P'], 1, madde: 'Madde 11/2-b.4'),
        ],
        'MADDE 11/2-b: toplam 100 puan, en az 90\'ı doktora sonrası; A\'dan 10 puan, TR Dizinde '
        .'farklı dergilerde 5 makale (üçü tek yazarlı), bildirilerden 5 puan, 1 kitap yayını, '
        .'1 proje.',
        'Yönerge TR Dizin makalelerinin FARKLI DERGİLERDE yayımlanmış olmasını istiyor; dergi '
        .'adı burada tutulmadığı için bu koşul değerlendirilemiyor, yalnız sayı ve tek yazarlılık '
        .'ölçülüyor. '.$ustNotu),
    $esik('docentlik-hukuk', 'docentlik', 'Doçent', ['hukuk'],
        'piri-reis-2025-hukuk', [Kalip::toplam(100), Kalip::toplam(90, $DOKTORA)], [
            $docentBeyani,
            Kalip::adet('Uluslararası ya da TR Dizin dergilerinde doktora unvanınızdan sonra en '
                .'az 6 yayın', ['A', 'B1'], 6, donem: $DOKTORA, madde: 'Madde 11/2-c.1'),
            Kalip::adet('Bu yayınların en az dördünde tek yazar olmak', ['A', 'B1'], 4,
                yazar: 'tek', donem: $DOKTORA, madde: 'Madde 11/2-c.1'),
            $tezYayini('Madde 11/2-c.2'),
            Kalip::puanDan('Bildiri kalemlerinizden en az 5 puan', ['CD'], 5,
                madde: 'Madde 11/2-c.3'),
            Kalip::adet('Kitap yazarlığı kalemlerinizden doktora unvanınızdan sonra en az 1 yayın',
                ['EF-yazarlik'], 1, donem: $DOKTORA, madde: 'Madde 11/2-c.4'),
            Kalip::adet('Kitap kalemlerinizden doktora unvanınızdan sonra en az 2 yayın',
                ['EF'], 2, donem: $DOKTORA, madde: 'Madde 11/2-c.5'),
            $dersBeyani(2, 2, 'Madde 11/2-c.6'),
            Kalip::adet('Proje ya da diğer akademik faaliyet kalemlerinizden en az 1 çalışma',
                ['PR'], 1, madde: 'Madde 11/2-c.7'),
        ],
        'MADDE 11/2-c: toplam 100 puan, en az 90\'ı doktora sonrası; A veya B türü yayınlardan '
        .'en az 6 (dördü tek yazarlı, üçü farklı dergide), bildirilerden 5 puan, kitap '
        .'yazarlığından 1 ve kitap kalemlerinden 2 yayın, 2 dönem ders, 1 proje ya da faaliyet.',
        'Yönerge altı yayının ÜÇÜNÜN FARKLI DERGİDE yayımlanmış olmasını da istiyor; dergi adı '
        .'burada tutulmadığı için bu koşul değerlendirilemiyor. '.$ustNotu),

    // ═════════════════════ PROFESÖR (MADDE 12) ═════════════════════
    $esik('profesorluk-muhendislik', 'profesorluk', 'Profesör', ['muhendislik', 'fen'],
        'piri-reis-2025-fen-prof', [Kalip::toplam(200), Kalip::toplam(100, $DOCENTLIK)], [
            $profBeyani,
            Kalip::puanDan('Q1-Q3 dilimli uluslararası dergilerdeki makalelerinizden '
                .'doçentliğinizden sonra en az 40 puan', ['A1-abc'], 40, $DOCENTLIK,
                madde: 'Madde 12/a.1'),
            Kalip::adet('Uluslararası ya da ulusal bilimsel toplantıda en az 5 bildiri', ['CD'], 5,
                madde: 'Madde 12/a.2'),
            Kalip::adet('Bu bildirilerin en az üçü doçentliğinizden sonra', ['CD'], 3,
                donem: $DOCENTLIK, madde: 'Madde 12/a.2'),
            $juriKolu('Madde 12/a.3'),
            $dersBeyani(4, 5, 'Madde 12/a.4'),
            Kalip::adet('Başarıyla tamamlanmış en az 2 bilimsel projede yer almak', ['P'], 2,
                madde: 'Madde 12/a.5'),
            Kalip::adet('Bu projelerin en az biri doçentliğinizden sonra', ['P'], 1,
                donem: $DOCENTLIK, madde: 'Madde 12/a.5'),
        ],
        'MADDE 12/a ve 12/d: toplam 200 puan, en az 100\'ü doçentlik sonrası; Q1-Q3 '
        .'dergilerinden 40 puan, 5 bildiri (üçü doçentlik sonrası), 2 tez yönetimi, 4 dönem ders, '
        .'2 proje (biri doçentlik sonrası).',
        $ustNotu),
    $esik('profesorluk-sosyal', 'profesorluk', 'Profesör', ['sosyal'],
        'piri-reis-2025-sosyal-prof', [Kalip::toplam(200), Kalip::toplam(100, $DOCENTLIK)], [
            $profBeyani,
            Kalip::adet('Q1-Q3 dilimli uluslararası dergilerde doçentliğinizden sonra en az 2 '
                .'makale', ['A1-abc'], 2, donem: $DOCENTLIK, madde: 'Madde 12/b.1'),
            Kalip::adet('Uluslararası ya da ulusal bilimsel toplantıda en az 5 bildiri', ['CD'], 5,
                madde: 'Madde 12/b.2'),
            Kalip::adet('Bu bildirilerin en az üçü doçentliğinizden sonra', ['CD'], 3,
                donem: $DOCENTLIK, madde: 'Madde 12/b.2'),
            Kalip::adet('Kitap kalemlerinizden en az 2 yayın', ['EF'], 2, madde: 'Madde 12/b.3'),
            Kalip::adet('Bu yayınların en az biri doçentliğinizden sonra', ['EF'], 1,
                donem: $DOCENTLIK, madde: 'Madde 12/b.3'),
            $juriKolu('Madde 12/b.4'),
            $dersBeyani(4, 5, 'Madde 12/b.5'),
            Kalip::adet('Başarıyla tamamlanmış en az 2 bilimsel projede yer almak', ['P'], 2,
                madde: 'Madde 12/b.6'),
            Kalip::adet('Bu projelerin en az biri doçentliğinizden sonra', ['P'], 1,
                donem: $DOCENTLIK, madde: 'Madde 12/b.6'),
        ],
        'MADDE 12/b: toplam 200 puan, en az 100\'ü doçentlik sonrası; doçentlik sonrası 2 Q1-Q3 '
        .'makalesi, 5 bildiri, 2 kitap yayını, 2 tez yönetimi, 4 dönem ders, 2 proje.',
        $ustNotu),
    $esik('profesorluk-hukuk', 'profesorluk', 'Profesör', ['hukuk'],
        'piri-reis-2025-hukuk-prof', [Kalip::toplam(200), Kalip::toplam(100, $DOCENTLIK)], [
            $profBeyani,
            Kalip::puanDan('Q dilimli uluslararası dergiler ile TR Dizin dergilerindeki '
                .'makalelerinizden doçentliğinizden sonra en az 50 puan', ['A1', 'B1'], 50,
                $DOCENTLIK, madde: 'Madde 12/c.1'),
            $tezYayini('Madde 12/c.2'),
            Kalip::adet('Uluslararası ya da ulusal bilimsel toplantıda en az 3 bildiri', ['CD'], 3,
                madde: 'Madde 12/c.3'),
            Kalip::adet('Bu bildirilerin en az biri doçentliğinizden sonra', ['CD'], 1,
                donem: $DOCENTLIK, madde: 'Madde 12/c.3'),
            Kalip::adet('Kitap yazarlığı kalemlerinizden en az 2 yayın', ['EF-yazarlik'], 2,
                madde: 'Madde 12/c.4'),
            Kalip::adet('Bu yayınların en az biri doçentliğinizden sonra', ['EF-yazarlik'], 1,
                donem: $DOCENTLIK, madde: 'Madde 12/c.4'),
            $juriKolu('Madde 12/c.5'),
            $dersBeyani(4, 5, 'Madde 12/c.6'),
            Kalip::adet('Proje ya da diğer akademik faaliyet kalemlerinizden en az 2 çalışma',
                ['PR'], 2, madde: 'Madde 12/c.7'),
            Kalip::adet('Bunların en az biri doçentliğinizden sonra', ['PR'], 1,
                donem: $DOCENTLIK, madde: 'Madde 12/c.7'),
        ],
        'MADDE 12/c: toplam 200 puan, en az 100\'ü doçentlik sonrası; doçentlik sonrası A.1 veya '
        .'B.1\'den 50 puan, 3 bildiri, 2 kitap yazarlığı, 2 tez yönetimi, 4 dönem ders, 2 proje '
        .'ya da faaliyet.',
        $ustNotu),
];
