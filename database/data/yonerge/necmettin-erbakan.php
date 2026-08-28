<?php

use App\Services\Scoring\Sart\Kalip;

/**
 * NECMETTİN ERBAKAN ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve
 * Atanma Yönergesi
 * Kaynak: pdf/17721844331.Necmettin Erbakan Üniversitesi Kriteri 05.02.2026 GK.pdf
 *
 * Cetvel: cetvel/necmettin-erbakan-2026.php
 *
 * ── EŞİKLERİN YAPISI ──
 * Tablo-3 beş alan grubu için kadro bazında ZORUNLU KATEGORİ barajları ve
 * bir de "gereken en az puan (tüm kategoriler)" toplamı veriyor. Zorunlu
 * kategoriler alana göre değişiyor: bütün alanlarda makale (A) ve atıf (K)
 * barajı var; Fen ve Sağlıkta ayrıca proje (N), Sosyal ve Mimarlıkta kitap
 * (D) ile proje, Görsel ve Sahne Sanatlarında sanat etkinliği (F veya G)
 * ile proje barajı aranıyor.
 *
 * ── YORUM KARARLARI (§0) ──
 *   Spor Bilimleri temel alanı Tablo-3'te ayrı bir grup olarak geçmiyor;
 *       D grubunun zorunlu kategorisi "Sahne Sanatları Alanına ve SPORTİF
 *       FAALİYETLERE İlişkin Etkinlikleri VEYA Görsel Sanatlar Alanına
 *       İlişkin Etkinlikleri" olduğu için Spor Bilimleri bu gruba bağlandı.
 *   Tablo-1'de SCOPUS dergileri A1 kategorisinde ama kayıtta ESCI ile aynı
 *       etikette; bu yüzden cetvelde A2 değerinden sayılıyor ve "A1'den en
 *       az X puan" barajına katkı vermiyor. Scopus makalesi olan adayın A1
 *       barajı olduğundan zor görünür.
 *   Profesörlükte "A1 kategorisindeki yayınlardan en az birinde başlıca
 *       yazar olma" şartı BAŞLICA YAZAR rolüyle karşılanıyor.
 *   MADDE 7/e'nin "A. Makale kategorisindeki zorunlu puanın en az %25'i
 *       doktora sonrası çalışmalardan" koşulu, ilgili alan grubunun makale
 *       barajının dörtte biri olarak hesaplandı ve aşağı yuvarlandı.
 *   Tablo-3'ün 15 numaralı dipnotundaki proje puanı MUAFİYETİ (en az 90 gün
 *       yurt dışı gözlem ve araştırma deneyimi, doktora sonrası bir yıllık
 *       istihdam, merkez görevlendirmesi) ile 16 numaralı dipnotun "eksik
 *       proje puanını makale kategorisinden katlayarak tamamlama" yolu
 *       yazılmadı; ikisi de belgeye bağlı ya da koşullu gevşetici yollar.
 *   MADDE 10'un Tıp ve Diş Hekimliği fakülteleri için puan şartını
 *       kaldırabilen istisnası yazılmadı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 5/c, 6/c ve 7/c'nin yabancı dille eğitim yapan bölümler için
 *       aradığı ek dil şartı (ilgili yönetmeliğe atıf).
 *   MADDE 4, 8 ve 9'un başvuru, puanlama ilkeleri ve komisyon usulleri.
 */
$FEN = ['fen', 'muhendislik', 'ziraat'];
$SAGLIK = ['saglik'];
$SOSYAL = ['sosyal', 'egitim', 'filoloji', 'ilahiyat', 'hukuk'];
$SANAT = ['guzel_sanatlar', 'spor'];
$MIMARLIK = ['mimarlik'];

$DIL_NOTU = 'Bütün kadrolarda merkezi bir yabancı dil sınavından en az 70 puan aranıyor.';

$ORTAK_NOTU = 'Tablo-3 iki tür baraj koyuyor: zorunlu kategori barajları (makale, atıf ve '
    .'alana göre proje, kitap ya da sanat etkinliği) ile tüm kategorilerin toplamı. İkisini '
    .'birden sağlamanız gerekiyor. Proje barajını sağlayamayan adaylar için yönergede iki '
    .'muafiyet yolu var (en az 90 gün yurt dışı araştırma deneyimi ya da eksik proje puanını '
    .'makale kategorisinden katlayarak tamamlama); araç bu yolları uygulamıyor.';

/**
 * Tablo-3'ün alan grupları. Her kadro için: [makale alt barajı grubu,
 * makale alt barajı, A1-A5 toplamı, atıf, proje, kitap ya da sanat barajı,
 * tüm kategoriler toplamı].
 *
 * @var list<array{ad: string, anahtar: string, alan: list<string>, altGrup: ?string, ek: ?string, dr: array<string, int>, doc: array<string, int>, prof: array<string, int>}>
 */
$gruplar = [
    ['ad' => 'Fen ve Mühendislik Bilimleri', 'anahtar' => 'fen', 'alan' => $FEN,
        'altGrup' => 'A1-A2', 'ek' => null,
        'dr' => ['alt' => 100, 'makale' => 180, 'atif' => 20, 'proje' => 50, 'toplam' => 580],
        'doc' => ['alt' => 100, 'makale' => 220, 'atif' => 50, 'proje' => 80, 'toplam' => 870],
        'prof' => ['alt' => 150, 'makale' => 260, 'atif' => 80, 'proje' => 110, 'toplam' => 1160]],
    ['ad' => 'Sağlık Bilimleri', 'anahtar' => 'saglik', 'alan' => $SAGLIK,
        'altGrup' => 'A1-A2', 'ek' => null,
        'dr' => ['alt' => 100, 'makale' => 180, 'atif' => 20, 'proje' => 50, 'toplam' => 550],
        'doc' => ['alt' => 100, 'makale' => 220, 'atif' => 50, 'proje' => 80, 'toplam' => 825],
        'prof' => ['alt' => 150, 'makale' => 260, 'atif' => 80, 'proje' => 110, 'toplam' => 1100]],
    ['ad' => 'Sosyal Bilimler', 'anahtar' => 'sosyal', 'alan' => $SOSYAL,
        'altGrup' => null, 'ek' => 'D',
        'dr' => ['alt' => 0, 'makale' => 150, 'atif' => 20, 'proje' => 20, 'ekPuan' => 60, 'toplam' => 480],
        'doc' => ['alt' => 0, 'makale' => 190, 'atif' => 30, 'proje' => 30, 'ekPuan' => 100, 'toplam' => 720],
        'prof' => ['alt' => 0, 'makale' => 230, 'atif' => 50, 'proje' => 50, 'ekPuan' => 120, 'toplam' => 960]],
    ['ad' => 'Görsel Sanatlar, Sahne Sanatları ve Spor Bilimleri', 'anahtar' => 'sanat', 'alan' => $SANAT,
        'altGrup' => null, 'ek' => 'F-G',
        'dr' => ['alt' => 0, 'makale' => 100, 'atif' => 20, 'proje' => 20, 'ekPuan' => 110, 'toplam' => 480],
        'doc' => ['alt' => 0, 'makale' => 130, 'atif' => 30, 'proje' => 30, 'ekPuan' => 160, 'toplam' => 720],
        'prof' => ['alt' => 0, 'makale' => 150, 'atif' => 50, 'proje' => 50, 'ekPuan' => 200, 'toplam' => 960]],
    ['ad' => 'Mimarlık', 'anahtar' => 'mimarlik', 'alan' => $MIMARLIK,
        'altGrup' => 'A1-A2', 'ek' => 'D',
        'dr' => ['alt' => 80, 'makale' => 160, 'atif' => 20, 'proje' => 20, 'ekPuan' => 50, 'toplam' => 500],
        'doc' => ['alt' => 100, 'makale' => 200, 'atif' => 30, 'proje' => 30, 'ekPuan' => 90, 'toplam' => 750],
        'prof' => ['alt' => 150, 'makale' => 240, 'atif' => 40, 'proje' => 50, 'ekPuan' => 120, 'toplam' => 1000]],
];

$EK_AD = ['D' => 'kitap ve kitap bölümü', 'F-G' => 'sanat ve sahne etkinliği'];

/**
 * Bir kadronun zorunlu kategori ve toplam koşulları.
 *
 * @param  array<string, int>  $e
 * @return list<array<string, mixed>>
 */
$kategoriler = function (array $g, array $e, ?array $donem, string $altGrupKodu, string $madde) use ($EK_AD): array {
    $cocuklar = [];

    if ($e['alt'] > 0) {
        $cocuklar[] = Kalip::toplam($e['alt'], donem: $donem, maddeler: [$altGrupKodu], liste: $madde);
    } else {
        $cocuklar[] = Kalip::adet('A1 ya da A2 kategorisinde en az 1 makale', ['A1-A2'], 1, donem: $donem, madde: $madde);
    }

    $cocuklar[] = Kalip::toplam($e['makale'], donem: $donem, maddeler: ['A1-A5'], liste: $madde);
    $cocuklar[] = Kalip::toplam($e['atif'], donem: $donem, maddeler: ['K'], liste: $madde);

    if ($g['ek'] !== null) {
        $cocuklar[] = Kalip::toplam($e['ekPuan'], donem: $donem, maddeler: [$g['ek']], liste: $madde.' ('.$EK_AD[$g['ek']].')');
    }

    $cocuklar[] = Kalip::toplam($e['proje'], donem: $donem, maddeler: ['N'], liste: $madde);
    $cocuklar[] = Kalip::toplam($e['toplam'], donem: $donem, liste: $madde.' (tüm kategoriler)');

    return $cocuklar;
};

$esikler = [];

foreach ($gruplar as $g) {
    $ortak = ['universite' => 'Necmettin Erbakan Üniversitesi', 'alan' => $g['alan'],
        'cetvel' => 'necmettin-erbakan-2026'];
    $altGrup = $g['altGrup'] ?? 'A1-A2';
    $altAd = $g['altGrup'] === null
        ? 'en az bir makalenin A1 ya da A2 kategorisinden olması'
        : ($g['anahtar'] === 'mimarlik' ? 'A1 ve A2 kategorilerinden' : 'A1 ya da A2 kategorisinden');
    $ekAd = $g['ek'] !== null ? $EK_AD[$g['ek']] : null;

    // ══ DOKTOR ÖĞRETİM ÜYELİĞİNE İLK ATAMA (MADDE 7) ══
    $drCocuklar = [
        Kalip::yds(70),
        ...$kategoriler($g, $g['dr'], null, $altGrup, 'Tablo-3'),
        Kalip::toplam((int) floor($g['dr']['makale'] / 4), donem: Kalip::DOKTORA_SONRASI, maddeler: ['A1-A5'], liste: 'MADDE 7/e'),
    ];

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'necmettin-erbakan-'.$g['anahtar'].'-dr',
        'kadro' => 'dr_ogr_uyesi',
        'notlar' => 'Tablo-3/'.$g['ad'].': makalede '.$altAd.' '.($g['dr']['alt'] > 0 ? $g['dr']['alt'].' puan ve ' : '')
            .'A1-A5\'ten '.$g['dr']['makale'].' puan; atıftan '.$g['dr']['atif'].' puan; '
            .($ekAd !== null ? $ekAd.' kategorisinden '.$g['dr']['ekPuan'].' puan; ' : '')
            .'projeden '.$g['dr']['proje'].' puan; tüm kategorilerden '.$g['dr']['toplam'].' puan. '
            .'MADDE 7/e: makale barajının %25\'i doktora sonrası.',
        'aday_notu' => $g['ad'].' alanında doktor öğretim üyeliği için Tablo-3\'ün bütün zorunlu '
            .'kategori barajlarını ve '.$g['dr']['toplam'].' puanlık genel toplamı birlikte '
            .'sağlamanız gerekiyor. Makale barajı '.$g['dr']['makale'].' puan ve bunun en az '
            .'dörtte biri ('.(int) floor($g['dr']['makale'] / 4).' puan) DOKTORA unvanınızı '
            .'aldıktan sonraki çalışmalardan gelmeli. '.$ORTAK_NOTU.' '.$DIL_NOTU,
        'sart' => Kalip::ve('Doktor öğretim üyeliğine ilk atanma koşulları', $drCocuklar),
    ]);

    // ══ YENİDEN ATAMA (MADDE 7/f) ══
    $esikler[] = array_merge($ortak, [
        'anahtar' => 'necmettin-erbakan-'.$g['anahtar'].'-dr-yeniden',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'notlar' => 'MADDE 7/f: ilk atama dört yıllıktır; yeniden atamada en son atanma '
            .'tarihinden itibaren Tablo-3\'ün aynı kategorilerdeki puan şartları aranır.',
        'aday_notu' => 'İlk atama dört yıllık yapılıyor. Yeniden atamada Tablo-3\'ün doktor '
            .'öğretim üyeliği için öngördüğü barajların aynısı aranıyor; fark, puanların EN SON '
            .'ATANMA TARİHİNDEN İTİBAREN gerçekleştirilen çalışmalardan hesaplanması. Doçent '
            .'unvanını almış ya da doçent kadrosu koşullarını sağlamış doktor öğretim üyeleri '
            .'atama işlemleri tamamlanıncaya kadar görevlerine devam ediyor. '.$ORTAK_NOTU,
        'sart' => Kalip::ve('Yeniden atanma koşulları',
            $kategoriler($g, $g['dr'], Kalip::SON_ATAMA_SONRASI, $altGrup, 'MADDE 7/f')),
    ]);

    // ══ DOÇENTLİK (MADDE 6) ══
    $esikler[] = array_merge($ortak, [
        'anahtar' => 'necmettin-erbakan-'.$g['anahtar'].'-docentlik',
        'kadro' => 'docentlik',
        'notlar' => 'MADDE 6/ç: Tablo-3\'ün zorunlu kategori puanları doktora ya da uzmanlık '
            .'eğitimini tamamladıktan sonra sağlanmalı. Makale '.$g['doc']['makale'].', atıf '
            .$g['doc']['atif'].', proje '.$g['doc']['proje'].', toplam '.$g['doc']['toplam'].' puan.',
        'aday_notu' => $g['ad'].' alanında doçent kadrosu için Tablo-3\'ün doçentlik sütunundaki '
            .'bütün barajlar aranıyor ve hepsi DOKTORA (ya da tıpta, diş hekimliğinde, '
            .'eczacılıkta, veteriner hekimlikte uzmanlık veya sanatta yeterlik) eğitimini '
            .'tamamladıktan sonraki çalışmalardan hesaplanıyor. Genel toplam '
            .$g['doc']['toplam'].' puan. '.$ORTAK_NOTU.' '.$DIL_NOTU,
        'sart' => Kalip::ve('Doçentlik koşulları', [
            Kalip::yds(70),
            ...$kategoriler($g, $g['doc'], Kalip::DOKTORA_SONRASI, $altGrup, 'MADDE 6/ç'),
        ]),
    ]);

    // ══ PROFESÖRLÜK (MADDE 5) ══
    $profCocuklar = [
        Kalip::yds(70),
        ...$kategoriler($g, $g['prof'], Kalip::DOCENTLIK_SONRASI, $altGrup, 'MADDE 5/ç'),
    ];

    if ($g['altGrup'] !== null) {
        $profCocuklar[] = Kalip::adet('A1 kategorisindeki yayınlardan en az birinde başlıca yazar olmak', ['A1'], 1, yazar: 'baslica', donem: Kalip::DOCENTLIK_SONRASI, madde: 'Tablo-3 dipnot 14');
    }

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'necmettin-erbakan-'.$g['anahtar'].'-profesorluk',
        'kadro' => 'profesorluk',
        'notlar' => 'MADDE 5/ç: Tablo-3\'ün zorunlu kategori puanları doçent unvanı alındıktan '
            .'sonra sağlanmalı. Makale '.$g['prof']['makale'].', atıf '.$g['prof']['atif']
            .', proje '.$g['prof']['proje'].', toplam '.$g['prof']['toplam'].' puan.'
            .($g['altGrup'] !== null ? ' Dipnot 14: A1 yayınlarından en az birinde başlıca yazar olmak.' : ''),
        'aday_notu' => $g['ad'].' alanında profesörlük için Tablo-3\'ün profesörlük sütunundaki '
            .'barajların tamamı DOÇENT unvanını aldıktan sonraki çalışmalardan sağlanmalı; genel '
            .'toplam '.$g['prof']['toplam'].' puan. '
            .($g['altGrup'] !== null
                ? 'Ayrıca A1 kategorisindeki yayınlarınızdan en az birinde başlıca yazar '
                    .'olmalısınız; kaydınızda bu rolü işaretlemezseniz koşul sağlanmamış '
                    .'görünür. '
                : '')
            .$ORTAK_NOTU.' '.$DIL_NOTU,
        'sart' => Kalip::ve('Profesörlük koşulları', $profCocuklar),
    ]);
}

return $esikler;
