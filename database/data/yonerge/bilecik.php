<?php

/**
 * BİLECİK ŞEYH EDEBALİ ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma
 * Yönergesi
 * Kaynak: pdf/1785927020751.bilecik-seyh-edebali-kriter-16102025.pdf (18 sayfa)
 *         Revizyon 07: 18.09.2025 tarihli ve 495-2 sayılı Senato Kararı.
 *         MADDE 14: YÖK onayından sonra 30.06.2026'da yürürlüğe girer.
 *
 * DÖRT AYRI TABLO, ÜÇ AYRI ZAMAN PENCERESİ. Bilecik'i ayıran şey barajların
 * İKİ KATMANLI olması (MADDE 10/7-10): alt koşullar KISA BİR PENCEREDE, toplam
 * puan ise kariyerin tamamında aranıyor.
 *
 *   Dr. Öğr. Üyesi  alt koşullar son 2 yıl · toplam 140, tüm faaliyetler
 *   Doçent          alt koşullar son 2 yıl · toplam 200, doktora sonrası
 *   Profesör        alt koşullar son 3 yıl · toplam 300, doçentlik sonrası
 *
 * Pencerenin başlangıcı yönergede "geriye dönük iki/üç yıla denk gelen ilgili
 * yılın 1 Ocak tarihi" diye tanımlı, yani gerçek pencere 2-3 (profesörlükte
 * 3-4) yıl arasında değişiyor. §0 gereği DAR olanı yazıldı: `sonYil(2)` ve
 * `sonYil(3)`. Aday pencerenin başına denk gelen bir yayınını sayamayabilir.
 *
 * DÖRT CETVEL VARYANTI. Yazar katkı oranı temel alana göre değişiyor (MADDE 11)
 * ve M bölümü yalnızca iki alanda geçerli; ayrıntı cetvel dosyasının başlığında.
 *   fen · muhendislik · ziraat · spor · saglik  → bilecik-2025-fen
 *   mimarlik                                   → bilecik-2025-mimarlik
 *   sosyal · ilahiyat · filoloji · hukuk · egitim → bilecik-2025-sosyal
 *   guzel_sanatlar                             → bilecik-2025-guzel-sanatlar
 *
 * İKİ ALANDA `birim` KULLANILDI:
 *   fen — "Matematik ve İstatistik alanlarında" parantezi bütün kadrolarda
 *     barajı düşürüyor (70/100 yerine 40/70; doçentlik ve profesörlükte de).
 *     Aynı (üniversite, kadro, fen) üçlüsünde iki eşik olduğu için ayrım
 *     yalnız `birim` ile kurulabiliyor.
 *   filoloji ve ilahiyat — MADDE 9 yabancı dil barajını bölüme bağlıyor:
 *     İlahiyat Fakültesi Arap Dili ve Belagati Ana Bilim Dalı, Mütercim
 *     Tercümanlık Bölümü ve Yabancı Diller Yüksekokulu ile yabancı diller
 *     üzerine yürütülen bütün program ve bölümlerde 85, diğerlerinde 65.
 *
 * EĞİTİM-ÖĞRETİM KOŞULU HESAPLANAMIYOR. Doçentlik "H maddesinden en az 4",
 * profesörlük "en az 6 puan" istiyor; H.1'in puanı haftalık ders SAATİ başına
 * 0,1 (on saat bir puan) veriliyor ve kayıt ders saatini tutmuyor. Koşul
 * `Kalip::hesaplanamiyor` düğümü olarak duruyor; H'nin girilebilen tek satırı
 * değişim programı katılımı (1 puan).
 *
 * SAĞLIK BİLİMLERİNİN İKİNCİ KOLU DA HESAPLANAMIYOR. Yönerge makale barajının
 * alternatifi olarak L.9'u (hastane poliklinik, klinik, laboratuvar ya da idari
 * faaliyeti; aylık 5 puan) sunuyor. Böyle bir faaliyet kaydı yok; kol
 * `hesaplanamiyor` olarak duruyor, makale kolu tam değerlendiriliyor.
 *
 * PROFESÖRLÜĞÜN ÜAK KOŞULU BEYAN (MADDE 10/10): "geriye dönük son 3 doçentlik
 * başvuru dönemindeki ÜAK doçentlik başvuru şartlarından herhangi birinin
 * yeniden sağlanması (Lisansüstü Tezlerden Üretilmiş Yayın başlığı hariç)".
 * Hangi başvuru döneminin şartlarının seçileceği adaya bırakıldığı için
 * hesaplanamıyor; beyan olarak duruyor. MADDE 10/11'in "başlıca araştırma
 * eseri olarak sunmak" koşulu da beyan.
 *
 * DR. ÖĞR. ÜYESİ YENİDEN ATANMA GİRİLMEDİ (Tablo 2, MADDE 10/8): koşullar
 * "son atandığı tarihten sonraki atanma dönemi" içinde ölçülüyor; atama tarihi
 * profilde tutulmuyor. GEÇİCİ MADDE 1'in bir defaya mahsus eski yönergeye
 * dönme hakkı da aynı sebeple girilmedi.
 *
 * 50/D ARAŞTIRMA GÖREVLİSİ İSTİSNASI GİRİLMEDİ (MADDE 10/12): doktorasını
 * bitirmiş ve kadrosu bir yıl uzatılmış araştırma görevlileri Tablo 1
 * toplamının YARISIYLA (70 puan) son kez bir yıl atanabiliyor. Kadro durumu
 * profilde yok; aday notunda anlatıldı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: bilecik-2025-*
 */

use App\Services\Scoring\Sart\Kalip;

$UNI = 'Bilecik Şeyh Edebali Üniversitesi';
$CFEN = 'bilecik-2025-fen';
$CMIM = 'bilecik-2025-mimarlik';
$CSOS = 'bilecik-2025-sosyal';
$CGS = 'bilecik-2025-guzel-sanatlar';

$yenidenAtanma = 'Doktor öğretim üyeliğine YENİDEN ATANMA eşiği girilmedi: Tablo 2\'nin '
    .'koşulları son atandığınız tarihten sonraki dönemde ölçülüyor, o tarih burada '
    .'tutulmuyor. Yeniden atanmada toplam baraj 140 değil 80 puan. '
    .'2547 sayılı Kanunun 50/d maddesine göre görev yapan ve kadrosu bir yıl uzatılmış '
    .'araştırma görevlisiyseniz toplam barajın YARISI (70 puan) yetiyor (MADDE 10/12); '
    .'bu istisna kadro durumunuza bağlı olduğu için burada hesaplanmıyor.';

$dersNotu = 'EĞİTİM-ÖĞRETİM koşulu hesaplanamıyor: yönerge puanı haftalık ders SAATİ başına '
    .'0,1 veriyor (on saat bir puan), kayıt ders saatini tutmuyor. Koşulu belge ile '
    .'göstermeniz gerekiyor.';

$ikiKatman = 'Bilecik\'in barajları İKİ KATMANLI: alt koşullar yalnızca son yıllardaki '
    .'faaliyetlerinizden, toplam puan ise dönemin tamamından hesaplanıyor. Pencerenin '
    .'başlangıcı yönergede "geriye dönük ilgili yılın 1 Ocak\'ı" diye tanımlı olduğu için '
    .'gerçekte biraz daha uzun; burada DAR olanı uygulandı, yani pencerenin başına denk '
    .'gelen bir yayınınız sayılmamış olabilir.';

$dilNotu85 = 'Bu bölümde yabancı dil barajı 65 değil 85.';

/**
 * Kadro parametreleri: [toplam puan, toplamın dönemi, alt koşulların penceresi,
 * pencere uzunluğu, eğitim-öğretim barajı, tablo adı].
 */
$kadrolar = [
    'dr_ogr_uyesi' => ['Dr. Öğr. Üyesi', 'dr', 140, null, Kalip::sonYil(2), 2, 0, 'Tablo 1'],
    'docentlik' => ['Doçent', 'docentlik', 200, Kalip::DOKTORA_SONRASI, Kalip::sonYil(2), 2, 4, 'Tablo 3'],
    'profesorluk' => ['Profesör', 'profesorluk', 300, Kalip::DOCENTLIK_SONRASI, Kalip::sonYil(3), 3, 6, 'Tablo 4'],
];

/**
 * "A maddesinden asgari N puanı, makalelerin en az ikisinde ilk isim veya sorumlu
 * yazar olduğu {indeks} kapsamındaki dergilerde yayımlanmış olmak üzere toplamda
 * en az M puan almak" kalıbı.
 *
 * @param  array<string, mixed>  $donem
 * @return list<array<string, mixed>>
 */
$makaleBloku = function (string $indeksGrup, string $indeksAd, int $alt, int $toplam,
    array $donem, string $madde, string $toplamGrup = 'A',
    string $toplamAd = 'Makale kalemlerinizden'): array {
    return [
        Kalip::puanDan("{$indeksAd} en az {$alt} puan", [$indeksGrup], $alt, $donem, madde: $madde),
        Kalip::adet('Bu makalelerin en az 2\'sinde ilk isim ya da sorumlu yazar olmak',
            [$indeksGrup], 2, yazar: 'baslica', donem: $donem, madde: $madde),
        Kalip::puanDan("{$toplamAd} toplam en az {$toplam} puan", [$toplamGrup], $toplam,
            $donem, madde: $madde),
    ];
};

$Q13 = 'SCI, SCIE veya SSCI dergilerindeki (Q1-Q3) makalelerinizden';

/**
 * Alan grupları. `kollar` kadro anahtarına göre alt koşulları üretir.
 *
 * @var array<string, array{alan: list<string>, cetvel: string, birim?: string,
 *      yds: int, bildiri: string, kollar: callable, notlar: string}>
 */
$gruplar = [
    'fen-genel' => [
        'alan' => ['fen'],
        'cetvel' => $CFEN,
        'birim' => 'Fen Bilimleri (Matematik ve İstatistik dışındaki bölümler)',
        'yds' => 65,
        'bildiri' => 'C',
        'notlar' => 'A maddesinden 70 puanı A1-A3 kapsamında olmak üzere toplam 100 puan.',
        'kollar' => fn (string $kadro, array $donem, string $madde) => $makaleBloku('A1-A3', $Q13, 70, 100, $donem, $madde),
    ],
    'fen-matematik' => [
        'alan' => ['fen'],
        'cetvel' => $CFEN,
        'birim' => 'Matematik ve İstatistik',
        'yds' => 65,
        'bildiri' => 'C',
        'notlar' => 'Matematik ve İstatistik parantezi: A maddesinden 40 puanı A1-A3 kapsamında '
            .'olmak üzere toplam 70 puan.',
        'kollar' => fn (string $kadro, array $donem, string $madde) => $makaleBloku('A1-A3', $Q13, 40, 70, $donem, $madde),
    ],
    'muhendislik' => [
        'alan' => ['muhendislik', 'ziraat'],
        'cetvel' => $CFEN,
        'yds' => 65,
        'bildiri' => 'C',
        'notlar' => 'A maddesinden 70 puanı A1-A3 kapsamında olmak üzere toplam 100 puan.',
        'kollar' => fn (string $kadro, array $donem, string $madde) => $makaleBloku('A1-A3', $Q13, 70, 100, $donem, $madde),
    ],
    'saglik' => [
        'alan' => ['saglik'],
        'cetvel' => $CFEN,
        'yds' => 65,
        'bildiri' => 'C',
        'notlar' => 'A maddesinden 70 puanı A1-A3 kapsamında olmak üzere toplam 100 puan ya da '
            .'L.9 (hastane klinik faaliyeti) alternatifi.',
        'kollar' => fn (string $kadro, array $donem, string $madde) => [
            Kalip::veya('Makale ya da klinik faaliyet koşulu', [
                Kalip::ve('Makale koşulu', $makaleBloku('A1-A3', $Q13, 70, 100, $donem, $madde)),
                Kalip::hesaplanamiyor('Hastane poliklinik, klinik, laboratuvar ya da idari '
                    .'faaliyetlerinizden puan almak (aylık 5 puan)', $madde),
            ]),
        ],
    ],
    'mimarlik' => [
        'alan' => ['mimarlik'],
        'cetvel' => $CMIM,
        'yds' => 65,
        'bildiri' => 'B-C',
        'notlar' => 'A maddesinden 25 puan; A ve/veya F maddelerinden toplam 100 puan. '
            .'Bildiri barajı B veya C maddesinden sağlanabiliyor.',
        'kollar' => fn (string $kadro, array $donem, string $madde) => $makaleBloku(
            'A1-A7', 'Endeksli dergilerdeki makalelerinizden', 25, 100, $donem, $madde,
            'A-F', 'Makale ve fikri mülkiyet kalemlerinizden'),
    ],
    'guzel-sanatlar' => [
        'alan' => ['guzel_sanatlar'],
        'cetvel' => $CGS,
        'yds' => 65,
        'bildiri' => 'C',
        'notlar' => 'A maddesinden 25 puan ve en az bir makalede ilk isim; K, L ve/veya M '
            .'maddelerinden toplam 70 puan. Makale toplamı için ayrı bir baraj YOK.',
        'kollar' => fn (string $kadro, array $donem, string $madde) => [
            Kalip::puanDan('Makale kalemlerinizden en az 25 puan', ['A'], 25, $donem, madde: $madde),
            Kalip::adet('Makalelerinizin en az 1\'inde ilk isim olmak', ['A'], 1,
                yazar: 'ilk', donem: $donem, madde: $madde),
            Kalip::puanDan('Ödül, diğer akademik etkinlik ile sanat ve tasarım etkinliği '
                .'kalemlerinizden toplam en az 70 puan', ['K-L-M'], 70, $donem, madde: $madde),
        ],
    ],
    'egitim-spor' => [
        'alan' => ['egitim', 'spor'],
        'cetvel' => $CSOS,
        'yds' => 65,
        'bildiri' => 'C',
        'notlar' => 'Dr. Öğr. Üyesinde A maddesinden 60 puanı A1-A4 kapsamında olmak üzere '
            .'toplam 80 puan; doçentlik ve profesörlükte 40 puanı A1-A6 kapsamında olmak '
            .'üzere toplam 50 puan.',
        'kollar' => fn (string $kadro, array $donem, string $madde) => $kadro === 'dr_ogr_uyesi'
            ? $makaleBloku('A1-A4', 'SCI, SCIE veya SSCI dergilerindeki makalelerinizden', 60, 80, $donem, $madde)
            : $makaleBloku('A1-A6', 'Endeksli dergilerdeki makalelerinizden', 40, 50, $donem, $madde),
    ],
    'sosyal' => [
        'alan' => ['sosyal', 'hukuk'],
        'cetvel' => $CSOS,
        'yds' => 65,
        'bildiri' => 'C',
        'notlar' => 'Dr. Öğr. Üyesinde A maddesinden 60 puanı A1-A7 kapsamında olmak üzere '
            .'toplam 80 puan; doçentlik ve profesörlükte 40 puanı A1-A7 kapsamında olmak '
            .'üzere toplam 50 puan.',
        'kollar' => fn (string $kadro, array $donem, string $madde) => $kadro === 'dr_ogr_uyesi'
            ? $makaleBloku('A1-A7', 'Endeksli dergilerdeki makalelerinizden', 60, 80, $donem, $madde)
            : $makaleBloku('A1-A7', 'Endeksli dergilerdeki makalelerinizden', 40, 50, $donem, $madde),
    ],
];

// İlahiyat ve Filoloji: koşullar sosyal grubunun aynısı, yalnız yabancı dil
// barajı bölüme göre ikiye ayrılıyor (MADDE 9/a ve 9/c).
foreach ([
    'ilahiyat' => ['ilahiyat', 'Diğer bölümler', 'Arap Dili ve Belagati Ana Bilim Dalı'],
    'filoloji' => ['filoloji', 'Diğer bölümler',
        'Mütercim Tercümanlık ile yabancı diller üzerine yürütülen bölüm ve programlar'],
] as $ad => [$alan, $birimGenel, $birimDil]) {
    foreach ([[$birimGenel, 65, 'genel'], [$birimDil, 85, 'dil']] as [$birim, $yds, $ek]) {
        $gruplar["{$ad}-{$ek}"] = [
            'alan' => [$alan],
            'cetvel' => $CSOS,
            'birim' => $birim,
            'yds' => $yds,
            'bildiri' => 'C',
            'notlar' => $gruplar['sosyal']['notlar'].' Yabancı dil barajı '.$yds.'.',
            'kollar' => $gruplar['sosyal']['kollar'],
        ];
    }
}

$esikler = [];

foreach ($kadrolar as $kadro => [$kadroAd, $kadroEk, $toplamPuan, $toplamDonem, $donem, $pencere, $dersPuani, $tablo]) {
    foreach ($gruplar as $grupAd => $g) {
        $cocuklar = ($g['kollar'])($kadro, $donem, $tablo);

        $cocuklar[] = $g['bildiri'] === 'B-C'
            ? Kalip::puanDan('Kitap ve bildiri kalemlerinizden en az 8 puan', ['B-C'], 8, $donem, madde: $tablo)
            : Kalip::puanDan('Bildiri kalemlerinizden en az 8 puan', ['C'], 8, $donem, madde: $tablo);

        $dersEklendi = $dersPuani > 0;

        if ($dersEklendi) {
            $cocuklar[] = Kalip::hesaplanamiyor(
                "Eğitim-öğretim faaliyetlerinizden en az {$dersPuani} puan almak "
                .'(ders yükü saat başına 0,1 puan)', $tablo);
        }

        if ($kadro === 'profesorluk') {
            $cocuklar[] = Kalip::beyan('Doçent unvanınızı aldığınız bilim alanından olmak '
                .'kaydıyla, son üç doçentlik başvuru döneminden herhangi birinin ÜAK doçentlik '
                .'başvuru şartlarını yeniden sağlamak (lisansüstü tezlerden üretilmiş yayın '
                .'başlığı hariç)', 'Madde 10/10');
            $cocuklar[] = Kalip::beyan('Doçent unvanınızı aldıktan sonra alanınızla ilgili '
                .'özgün eserlerinizden birini başlıca araştırma eseri olarak sunmak', 'Madde 10/11');
        }

        $cocuklar[] = Kalip::yds($g['yds']);

        $notu = $ikiKatman.' Bu koşullar son '.$pencere.' yılınızdaki faaliyetlerden '
            .'hesaplanıyor; toplam puan ise dönemin tamamından.'
            .($dersEklendi ? ' '.$dersNotu : '')
            .($g['yds'] === 85 ? ' '.$dilNotu85 : '')
            .($kadro === 'dr_ogr_uyesi' ? ' '.$yenidenAtanma : '');

        $kayit = [
            'anahtar' => "bilecik-{$kadroEk}-{$grupAd}",
            'aday_notu' => $notu,
            'universite' => $UNI,
            'kadro' => $kadro,
            'alan' => $g['alan'],
            'cetvel' => $g['cetvel'],
            'notlar' => "{$tablo} — asgari toplam {$toplamPuan} puan. ".$g['notlar'],
            'sart' => Kalip::ve($kadroAd, array_values([Kalip::toplam($toplamPuan, $toplamDonem), ...$cocuklar])),
        ];

        if (isset($g['birim'])) {
            $kayit['birim'] = $g['birim'];
        }

        $esikler[] = $kayit;
    }
}

return $esikler;
