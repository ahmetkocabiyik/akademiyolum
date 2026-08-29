<?php

use App\Services\Scoring\Sart\Kalip;

/**
 * HALİÇ ÜNİVERSİTESİ — Akademik Yükseltme ve Atama Yönergesi
 * Kaynak: pdf/1781013026765.halic-kriter-09062026.pdf
 *
 * Cetvel: cetvel/halic-2026.php
 *
 * ── EŞİKLERİN YAPISI ──
 * Yönerge tek bir puan havuzu kullanıyor: EK-1 (yayın, atıf, proje,
 * editörlük, patent, ödül) ile EK-2 (tez danışmanlığı ve yönetsel görevler)
 * puanları toplanıyor; Mimarlık-Tasarım, Güzel Sanatlar ve Konservatuvar
 * alanlarında EK-3, Spor Bilimlerinde EK-4 de bu toplama ekleniyor.
 * Doktor öğretim üyeliğinde 40 (en az 20'si EK-1'den), doçentlikte doktora
 * sonrası 100, profesörlükte doçentlik sonrası alana göre 130-180 puan.
 *
 * ── YORUM KARARLARI (§0) ──
 *   EK-4 (Beden Eğitimi ve Spor Bilimleri formu) cetvele girilemedi;
 *       Spor Bilimleri adayının toplamı yalnızca EK-1 ve EK-2 üzerinden
 *       hesaplanıyor ve olduğundan düşük çıkıyor. Eşik yine de 150 puan
 *       olarak yazıldı.
 *   Madde 9/4'ün "Üniversitede lisansüstü program bulunmaması veya son beş
 *       yılda öğrenci almamış olması hâlinde tez koşulu aranmaz" muafiyeti
 *       ile Madde 6'nın Tıp Fakültesi kadroları için puan şartını
 *       kaldırabilen istisnası yazılmadı; ikisi de koşulu gevşeten yollar.
 *   Madde 9/4 eş danışmanlığın tez koşulunu sağlamayacağını söylüyor;
 *       faaliyet kaydı danışmanlık ile eş danışmanlığı ayırmadığı için
 *       koşul eş danışmanlıklarınızla da sağlanmış görünebilir.
 *   Ziraat, Orman ve Su Ürünleri temel alanı yönergenin alan grupları
 *       tablosunda geçmiyor (Haliç'te böyle bir birim yok); bu alanda eşik
 *       yazılmadı.
 *   Konservatuvar alanı Güzel Sanatlar temel alanına bağlandı; ikisinin de
 *       eşiği 130 puan ve ikisi de EK-3 uyguluyor.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde 10/3'ün jüri karşısında akademik sunum ve Madde 11/3'ün deneme
 *       dersi koşulları beyan olarak eklendi.
 *   Madde 5'in kanıt, mükerrer puan ve etik ilkeleri ile Madde 8'in ön
 *       inceleme usulü.
 */

/**
 * Madde 9/3'ün alan grupları tablosu.
 *
 * @var list<array{ad: string, anahtar: string, alan: list<string>, prof: int, toplam: string, sanat: bool}>
 */
$gruplar = [
    ['ad' => 'Sağlık Alanları', 'anahtar' => 'saglik', 'alan' => ['saglik'],
        'prof' => 150, 'toplam' => 'TOPLAM', 'sanat' => false],
    ['ad' => 'Mühendislik ve Teknoloji Alanları', 'anahtar' => 'muhendislik', 'alan' => ['muhendislik'],
        'prof' => 180, 'toplam' => 'TOPLAM', 'sanat' => false],
    ['ad' => 'Fen Bilimleri ve Matematik', 'anahtar' => 'fen', 'alan' => ['fen'],
        'prof' => 150, 'toplam' => 'TOPLAM', 'sanat' => false],
    ['ad' => 'Sosyal, Beşerî ve İdari Bilimler', 'anahtar' => 'sosyal',
        'alan' => ['sosyal', 'egitim', 'filoloji', 'ilahiyat', 'hukuk'],
        'prof' => 130, 'toplam' => 'TOPLAM', 'sanat' => false],
    ['ad' => 'Spor Bilimleri', 'anahtar' => 'spor', 'alan' => ['spor'],
        'prof' => 150, 'toplam' => 'TOPLAM', 'sanat' => false],
    ['ad' => 'Mimarlık ve Tasarım', 'anahtar' => 'mimarlik', 'alan' => ['mimarlik'],
        'prof' => 130, 'toplam' => 'TOPLAM-SANAT', 'sanat' => true],
    ['ad' => 'Güzel Sanatlar ve Konservatuvar', 'anahtar' => 'guzel-sanatlar', 'alan' => ['guzel_sanatlar'],
        'prof' => 130, 'toplam' => 'TOPLAM-SANAT', 'sanat' => true],
];

/**
 * Adaya gösterilen küme adları. Yönergenin EK numaraları yalnızca `notlar`da
 * ve düğümlerin `madde` alanında kalır — KONVANSIYONLAR §2, kod yasağı.
 */
$EK1_ADI = 'Yayın, atıf, proje, editörlük, patent ve ödül';
$TOPLAM_ADI = ['TOPLAM' => 'Akademik ve yönetsel faaliyet', 'TOPLAM-SANAT' => null];

$SANAT_NOTU = 'Bu alanda sanat ve mimarlık etkinlikleriniz de toplama giriyor. '
    .'Yönergenin "en az iki kişisel etkinlikte yer almak" satırı (24 puan) tek bir etkinliğe '
    .'değil dosyanın tamamına puan verdiği için araca girilemedi; kişisel sergi ve '
    .'gösterileriniz varsa sanat puanınız olduğundan düşük çıkar.';

$SPOR_NOTU = 'Spor Bilimlerinde sportif faaliyet puanlarınız da toplama giriyor; ancak '
    .'yönergenin bu formundaki satırların (akademik organizasyon, spor teşkilatı kurul üyeliği, '
    .'antrenörlük, hakemlik, sporcu derecesi, eğiticilik) faaliyet kaydında karşılığı olmadığı '
    .'için hiçbiri girilemedi. Sportif kariyeriniz varsa toplamınız burada belirgin biçimde '
    .'düşük çıkar; bu formdan en çok 60 puan sayılabildiğini de göz önünde bulundurun.';

$esikler = [];

foreach ($gruplar as $g) {
    $ortak = ['universite' => 'Haliç Üniversitesi', 'alan' => $g['alan'], 'cetvel' => 'halic-2026'];
    $alanNotu = $g['sanat'] ? ' '.$SANAT_NOTU : ($g['anahtar'] === 'spor' ? ' '.$SPOR_NOTU : '');

    // ══ DOKTOR ÖĞRETİM ÜYELİĞİ (MADDE 11) ══
    $esikler[] = array_merge($ortak, [
        'anahtar' => 'halic-'.$g['anahtar'].'-dr',
        'kadro' => 'dr_ogr_uyesi',
        'notlar' => 'Madde 11/2: EK-1, EK-2 (ilgili alanlarda EK-3 veya EK-4) toplamından en az '
            .'40 puan ve bu toplamın en az 20 puanının EK-1 kapsamında olması.',
        'aday_notu' => 'Doktor öğretim üyeliği için toplam 40 puan yetiyor ama bunun en az 20 '
            .'puanı yayın, atıf, proje, editörlük, patent ve ödül '
            .'kalemlerinden gelmeli; tez danışmanlığı ve yönetsel görev puanlarınız tek '
            .'başına barajı kapatmıyor. Atamalar en fazla dört yıllık yapılıyor ve ilgili '
            .'birimce belirlenen jüri karşısında deneme dersi vermeniz gerekiyor.'.$alanNotu,
        'sart' => Kalip::ve('Doktor öğretim üyeliği koşulları', [
            Kalip::beyan('Doktora ya da sanatta yeterlik unvanına sahip olmak', 'Madde 11/1'),
            Kalip::toplam(40, maddeler: [$g['toplam']], liste: $TOPLAM_ADI[$g['toplam']]),
            Kalip::toplam(20, maddeler: ['EK1'], liste: $EK1_ADI),
            Kalip::beyan('İlgili birimce belirlenen jüri karşısında deneme dersi yapmak', 'Madde 11/3'),
        ]),
    ]);

    // ══ YENİDEN ATAMA (MADDE 11/4) ══
    $esikler[] = array_merge($ortak, [
        'anahtar' => 'halic-'.$g['anahtar'].'-dr-yeniden',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'notlar' => 'Madde 11/4: başvuru tarihinden geriye doğru son 4 yıl içinde en az 40 puan; '
            .'ikinci fıkradaki EK-1 asgari payı (20 puan) yeniden atamada da uygulanır.',
        'aday_notu' => 'Yeniden atamada barajın penceresi dar: başvuru tarihinden geriye doğru '
            .'SON DÖRT YIL içindeki faaliyetlerden 40 puan toplamanız ve bunun en az 20 '
            .'puanının yayın, atıf, proje, editörlük, patent ve ödül kalemlerinizden gelmesi '
            .'gerekiyor. Daha eski çalışmalarınız bu hesaba '
            .'girmiyor.'.$alanNotu,
        'sart' => Kalip::ve('Yeniden atama koşulları', [
            Kalip::toplam(40, donem: Kalip::sonYil(4), maddeler: [$g['toplam']], liste: $TOPLAM_ADI[$g['toplam']]),
            Kalip::toplam(20, donem: Kalip::sonYil(4), maddeler: ['EK1'], liste: $EK1_ADI),
        ]),
    ]);

    // ══ DOÇENTLİK (MADDE 10) ══
    $esikler[] = array_merge($ortak, [
        'anahtar' => 'halic-'.$g['anahtar'].'-docentlik',
        'kadro' => 'docentlik',
        'notlar' => 'Madde 10: doçentlik belgesi ve doktora sonrası dönemde EK-1, EK-2 (ilgili '
            .'alanlarda EK-3 veya EK-4) toplamından en az 100 puan; jüri karşısında akademik '
            .'sunum.',
        'aday_notu' => 'Doçent kadrosu için 100 puanlık baraj DOKTORA unvanını aldıktan sonraki '
            .'çalışmalardan hesaplanıyor. Doktor öğretim üyeliğinden farklı olarak yayın '
            .'kalemleri için ayrı bir asgari pay aranmıyor; tez danışmanlığı ve yönetsel görev '
            .'puanlarınız da '
            .'(en fazla 30 puan) toplama giriyor. Ayrıca ilgili birimce belirlenen jüri '
            .'karşısında alanınıza ilişkin akademik sunum yapmanız gerekiyor.'.$alanNotu,
        'sart' => Kalip::ve('Doçentlik koşulları', [
            Kalip::beyan('Doçentlik belgesine sahip olmak', 'Madde 10/1'),
            Kalip::toplam(100, donem: Kalip::DOKTORA_SONRASI, maddeler: [$g['toplam']], liste: $TOPLAM_ADI[$g['toplam']]),
            Kalip::beyan('İlgili birimce belirlenen jüri karşısında alanınıza ilişkin akademik sunum yapmak', 'Madde 10/3'),
        ]),
    ]);

    // ══ PROFESÖRLÜK (MADDE 9) ══
    $baslicaEser = $g['sanat']
        ? Kalip::veya('Başlıca eser koşulu', [
            Kalip::adet('Hakemli dergide makale, tam metin bildiri ya da kitap türünden en az 1 eser', ['EK1-A-D'], 1, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Madde 9/2-b'),
            Kalip::adet('Ya da kişisel veya özgün nitelikte en az 1 sanat ya da tasarım etkinliği', ['EK3-KISISEL'], 1, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Madde 9/2-b'),
        ])
        : Kalip::veya('Başlıca eser koşulu', [
            Kalip::adet('Hakemli dergide tek yazarlı en az 1 makale', ['EK1-A'], 1, yazar: 'tek', donem: Kalip::DOCENTLIK_SONRASI, madde: 'Madde 9/2-a'),
            Kalip::adet('Ya da hakemli dergide ilk yazar olduğunuz en az 1 makale', ['EK1-A'], 1, yazar: 'ilk', donem: Kalip::DOCENTLIK_SONRASI, madde: 'Madde 9/2-a'),
            Kalip::adet('Ya da hakemli dergide sorumlu yazar olduğunuz en az 1 makale', ['EK1-A'], 1, yazar: 'baslica', donem: Kalip::DOCENTLIK_SONRASI, madde: 'Madde 9/2-a'),
            Kalip::adet('Ya da yazarı veya bölüm yazarı olduğunuz en az 1 kitap (editörlük sayılmaz)', ['EK1-D-YAZAR'], 1, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Madde 9/2-a'),
        ]);

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'halic-'.$g['anahtar'].'-profesorluk',
        'kadro' => 'profesorluk',
        'notlar' => 'Madde 9: doçentlik sonrası üretilmiş başlıca eser; '.$g['ad'].' alan grubu '
            .'için doçentlik sonrası EK-1, EK-2 (ilgili alanlarda EK-3 veya EK-4) toplamından '
            .'en az '.$g['prof'].' puan; doçentlik sonrası tamamlanmış en az 1 tezli yüksek '
            .'lisans ya da doktora tez danışmanlığı.',
        'aday_notu' => $g['ad'].' alan grubunda profesörlük için doçentlik sonrası '.$g['prof']
            .' puan gerekiyor. Üç koşulun tamamı doçentlik sonrasına ait: başlıca eser, puan '
            .'toplamı ve en az bir tamamlanmış tezli yüksek lisans veya doktora tez '
            .'danışmanlığı. Yönerge tez koşulunda EŞ DANIŞMANLIĞI saymıyor; araç danışmanlık '
            .'ile eş danışmanlığı ayırt edemediği için eş danışmanlıklarınız da koşulu '
            .'sağlıyormuş gibi görünür. Üniversitede ilgili lisansüstü program yoksa ya da '
            .'program son beş yılda öğrenci almamışsa bu koşul aranmıyor; araç bu muafiyeti '
            .'uygulamıyor.'.$alanNotu,
        'sart' => Kalip::ve('Profesörlük koşulları', [
            Kalip::beyan('Doçentlik unvanını aldıktan sonra ilgili mevzuatta öngörülen süre ve şartları tamamlamış olmak', 'Madde 9/1'),
            $baslicaEser,
            Kalip::toplam($g['prof'], donem: Kalip::DOCENTLIK_SONRASI, maddeler: [$g['toplam']], liste: $TOPLAM_ADI[$g['toplam']]),
            Kalip::veya('Tez danışmanlığı koşulu', [
                Kalip::adet('Doçentlik sonrası tamamlanmış en az 1 doktora tezi danışmanlığı', ['TEZ-DOKTORA'], 1, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Madde 9/4'),
                Kalip::adet('Doçentlik sonrası tamamlanmış en az 1 tezli yüksek lisans danışmanlığı', ['TEZ-YL'], 1, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Madde 9/4'),
            ]),
        ]),
    ]);
}

return $esikler;
