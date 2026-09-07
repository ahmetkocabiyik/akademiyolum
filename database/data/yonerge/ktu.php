<?php

use App\Services\Scoring\Sart\Kalip;

/*
 * KARADENİZ TEKNİK ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma
 * Yönergesi
 * Kaynak: pdf/17536999312.karadenizteknikuniverstesi.pdf (48 sayfa)
 *         Senato 09.02.2023/336-5, değişiklik 17.10.2023/342
 *         Cetvel: ktu-2023-{fen|sosyal|mimarlik}-{dr|docent|profesor}
 *
 * ON ÜÇ FAKÜLTE, ÜÇ KADRO = OTUZ DOKUZ EŞİK. Koşullar fakülte başına ayrı
 * eklerde (EK-2…EK-13); aynı temel alanda birden çok fakülte olduğu için
 * (sağlık alanında dört, fen alanında iki) eşikler `birim` ile ayrıldı ve
 * araç adaya fakültesini soruyor.
 *
 * EK-14 (öğretim üyesi tahsisli enstitü, yüksekokul, MYO) kendi sayısını
 * vermiyor: "adayın bulunduğu bilim alanı ile ilgili fakülte koşulları
 * geçerlidir" — ayrı eşik açılmadı, aday fakültesini seçiyor.
 *
 * GİRİLEMEYEN KOŞULLAR:
 *
 *   1. "(1a-1ç) makalelerinden en az birinde BİRİNCİ VEYA İKİNCİ İSİM
 *      olmak" (bütün fakültelerin dr. öğr. üyesi sütunu). Motor yazar
 *      sırasını yalnız `tek`/`ilk`/`baslica` olarak süzebiliyor; koşul
 *      `ilk` ile girildi, yani İKİNCİ isim olduğunuz yayınlar sayılmıyor.
 *      Bu, kaynaktan SIKI bir okuma; aday notunda yazılı.
 *   2. "Yüksekokul ve Meslek Yüksekokulu bünyesinde çalışan kişilerde bu
 *      koşul (tez danışmanlığı) aranmaz." Faaliyet kaydı adayın biriminin
 *      yüksekokul olup olmadığını taşımıyor; koşul herkese uygulanıyor.
 *   3. Fen Fakültesi'nin Matematik ve Bilgisayar Bilimleri bölümlerine özgü
 *      genişletilmiş küme ((1a-1i) makaleleri) ve Matematik Bölümü'nün
 *      proje telafisi (75/50 puan). Bölüm bazlı; fakülte eşiğine yazılamaz.
 *   4. Doktor Öğretim Üyesi'nin "KTÜ 50/d doktora mezunu" ve "yeniden
 *      atanma" sütunları — motor bu iki kadroyu ayırt etmiyor. Yalnız ilk
 *      atama koşulları girildi.
 *   5. "Aynı toplantıda sunulan bildirilerden yalnızca ikisi puanlamaya
 *      dahil edilir" ve kitap kalemlerindeki "en fazla iki kitap" gibi
 *      kaleme özgü sayı sınırları (cetvel dosyasında da not düşüldü).
 *   6. Sözlü sınav ve WoS H-indeksi muafiyeti (profesörde 25, doçentte 20)
 *      beyana bağlı.
 */

$UNIVERSITE = 'Karadeniz Teknik Üniversitesi';

$ORTAK_NOT = 'KTÜ koşulları bölüm bölüm çalışıyor: her bölümün hem bir '
    .'ZORUNLU puanı hem de bir EN FAZLA tavanı var, yani bir bölümden ne '
    .'kadar puan toplarsanız toplayın tavanın üstü toplama girmiyor. '
    .'Ortak çalışmalarda puan, isim sıranıza ve yazar sayısına göre '
    .'bölünüyor; başlıca yazar sıraya bakılmaksızın tam puan alıyor. '
    .'Kitaplarda bu bölüşüm geçerli değil, puan yazarlar arasında eşit '
    .'paylaştırılıyor.';

$YURTDISI_NOTU = 'Lisans sonrasında alanınızda en az 89 gün yurt dışı '
    .'gözlem, eğitim ya da araştırma faaliyetinde bulunmuş olmanız gerekiyor. '
    .'Bunu sağlayamıyorsanız iki çıkış yolu var: AB Çerçeve Programı, COST, '
    .'ikili/çoklu işbirliği ya da benzeri uluslararası bir projede '
    .'koordinatör/yürütücü olmak, ya da istenen asgari puanın en az %30 '
    .'fazlasını toplamak.';

/**
 * "Adayın başlıca yazar olduğu en az N yayın olmalıdır; sağlanamıyorsa eksik
 * yayın başına ilave en az 40 puan."
 *
 * Telafi eksik yayın SAYISINA bağlı olduğu için tek düğüm yetmiyor: her
 * eksik sayı ayrı bir kol. Kollar tam kaynağın dediği gibi kuruldu, yani ne
 * fazla ne eksik sayıyor.
 *
 * @return array<string, mixed>
 */
$baslicaKolu = static function (int $sayi, string $kume, int $taban, string $madde): array {
    $kollar = [];

    for ($eksik = 0; $eksik <= $sayi; $eksik++) {
        $kalan = $sayi - $eksik;
        $puan = $taban + 40 * $eksik;

        $cocuklar = [];
        if ($kalan > 0) {
            $cocuklar[] = Kalip::adet(
                "Başlıca yazar olduğunuz en az {$kalan} makale",
                [$kume],
                $kalan,
                yazar: 'baslica',
                madde: $madde,
            );
        }
        $cocuklar[] = Kalip::puanDan(
            "Makale bölümünün ilgili maddelerinden en az {$puan} puan",
            [$kume],
            $puan,
            madde: $madde,
        );

        $kollar[] = count($cocuklar) === 1
            ? $cocuklar[0]
            : Kalip::ve("Başlıca yazar olduğunuz {$kalan} makale ve {$puan} puan", $cocuklar);
    }

    return Kalip::veya(
        "Başlıca yazar olduğunuz en az {$sayi} makale (eksik her yayın için ilave 40 puan)",
        $kollar,
    );
};

/**
 * "89 gün yurt dışı" koşulu ve iki telafisi.
 *
 * @return array<string, mixed>
 */
$yurtDisi = static function (int $asgari, string $madde): array {
    return Kalip::veya('Yurt dışı deneyimi ya da telafisi', [
        Kalip::beyan('Lisans sonrasında alanınızda en az 89 gün yurt dışı gözlem, eğitim ya da araştırma faaliyeti', $madde),
        Kalip::beyan('AB Çerçeve Programı, COST ya da benzeri uluslararası bir projede koordinatörlük/yürütücülük', $madde),
        Kalip::toplam((int) ceil($asgari * 1.3), maddeler: ['*']),
    ]);
};

$fakulteler = [
    ['birim' => 'Diş Hekimliği Fakültesi', 'ek' => 'EK-2', 'alan' => ['saglik'], 'aile' => 'fen',
        'kume' => '1a-1ç', 'drPuan' => 50, 'drKume' => 30],
    ['birim' => 'Eczacılık Fakültesi', 'ek' => 'EK-3', 'alan' => ['saglik'], 'aile' => 'fen',
        'kume' => '1a-1ç', 'drPuan' => 70, 'drKume' => 40],
    ['birim' => 'Edebiyat Fakültesi', 'ek' => 'EK-4', 'alan' => ['sosyal', 'filoloji'], 'aile' => 'sosyal',
        'kume' => '1a-1e', 'drPuan' => 70, 'drKume' => 40],
    ['birim' => 'Fen Fakültesi', 'ek' => 'EK-5', 'alan' => ['fen'], 'aile' => 'fen',
        'kume' => '1a-1ç', 'drPuan' => 70, 'drKume' => 40],
    ['birim' => 'İktisadi ve İdari Bilimler Fakültesi', 'ek' => 'EK-6', 'alan' => ['sosyal'], 'aile' => 'sosyal',
        'kume' => '1a-1e', 'drPuan' => 70, 'drKume' => 40],
    ['birim' => 'Mimarlık Fakültesi', 'ek' => 'EK-7', 'alan' => ['mimarlik'], 'aile' => 'mimarlik',
        'kume' => 'MAKALE', 'drPuan' => 70, 'drKume' => 0],
    ['birim' => 'Mühendislik Fakültesi', 'ek' => 'EK-8', 'alan' => ['muhendislik'], 'aile' => 'fen',
        'kume' => '1a-1ç', 'drPuan' => 70, 'drKume' => 40],
    ['birim' => 'Of Teknoloji Fakültesi', 'ek' => 'EK-9', 'alan' => ['muhendislik'], 'aile' => 'fen',
        'kume' => '1a-1ç', 'drPuan' => 70, 'drKume' => 40],
    ['birim' => 'Orman Fakültesi', 'ek' => 'EK-10', 'alan' => ['ziraat'], 'aile' => 'fen',
        'kume' => '1a-1ç', 'drPuan' => 70, 'drKume' => 40],
    ['birim' => 'Sağlık Bilimleri Fakültesi', 'ek' => 'EK-11', 'alan' => ['saglik'], 'aile' => 'fen',
        'kume' => '1a-1e', 'drPuan' => 70, 'drKume' => 40],
    ['birim' => 'Sürmene Deniz Bilimleri Fakültesi', 'ek' => 'EK-12', 'alan' => ['fen'], 'aile' => 'fen',
        'kume' => '1a-1e', 'drPuan' => 80, 'drKume' => 40],
    ['birim' => 'Tıp Fakültesi', 'ek' => 'EK-13', 'alan' => ['saglik'], 'aile' => 'fen',
        'kume' => '1a-1ç', 'drPuan' => 50, 'drKume' => 30],
];

// Aile başına bölüm barajları (EK tablolarının "Zorunlu" sütunu).
$barajlar = [
    'fen' => [
        'profesor' => ['makale' => 200, 'kume' => 120, 'baslica' => 3, 'atif' => 100, 'tez' => 20, 'proje' => 25, 'toplanti' => 25, 'uluslararasi' => 10],
        'docent' => ['makale' => 160, 'kume' => 80, 'baslica' => 2, 'atif' => 80, 'tez' => 0, 'proje' => 20, 'toplanti' => 20, 'uluslararasi' => 10],
        'dr' => ['toplanti' => 15, 'uluslararasi' => 5],
    ],
    'sosyal' => [
        'profesor' => ['makale' => 200, 'kume' => 120, 'baslica' => 1, 'atif' => 60, 'tez' => 20, 'proje' => 15, 'toplanti' => 20, 'uluslararasi' => 10],
        'docent' => ['makale' => 160, 'kume' => 80, 'baslica' => 1, 'atif' => 40, 'tez' => 0, 'proje' => 10, 'toplanti' => 15, 'uluslararasi' => 10],
        'dr' => ['toplanti' => 10, 'uluslararasi' => 5],
    ],
    'mimarlik' => [
        'profesor' => ['makale' => 200, 'kume' => 0, 'baslica' => 3, 'atif' => 10, 'tez' => 20, 'proje' => 15, 'toplanti' => 30, 'uluslararasi' => 10],
        'docent' => ['makale' => 160, 'kume' => 0, 'baslica' => 3, 'atif' => 5, 'tez' => 0, 'proje' => 10, 'toplanti' => 15, 'uluslararasi' => 10],
        'dr' => ['toplanti' => 10, 'uluslararasi' => 5],
    ],
];

$ASGARI = ['profesor' => 420, 'docent' => 330, 'dr' => 135];

$esikler = [];

foreach ($fakulteler as $f) {
    $tip = $barajlar[$f['aile']];
    $kume = [$f['kume']];
    $ortak = ['universite' => $UNIVERSITE, 'alan' => $f['alan'], 'birim' => $f['birim']];

    // ── PROFESÖR ──
    $p = $tip['profesor'];
    $profKollar = [
        Kalip::toplam($ASGARI['profesor']),
        Kalip::puanDan('Makale bölümünden en az '.$p['makale'].' puan', ['MAKALE'], $p['makale'], madde: $f['ek']),
    ];
    if ($p['kume'] > 0) {
        $profKollar[] = Kalip::puanDan(
            'Bu puanın en az '.$p['kume'].'\'si dizinli dergi makalelerinden',
            $kume,
            $p['kume'],
            madde: $f['ek'],
        );
    }
    $profKollar[] = $baslicaKolu($p['baslica'], $f['kume'], max($p['kume'], 40), $f['ek']);
    $profKollar[] = Kalip::puanDan('Atıf bölümünden en az '.$p['atif'].' puan', ['ATIF'], $p['atif'], madde: $f['ek']);
    $profKollar[] = Kalip::veya('Tez danışmanlığı koşulu', [
        Kalip::ve('Tez danışmanlığı', [
            Kalip::puanDan('Tez danışmanlığı bölümünden en az '.$p['tez'].' puan', ['TEZ'], $p['tez'], madde: $f['ek']),
            Kalip::veya('Tamamlanmış ya da süren tez danışmanlığı', [
                Kalip::adet('En az 1 doktora, uzmanlık ya da sanatta yeterlik tezi danışmanlığı', ['4.b'], 1, madde: $f['ek']),
                Kalip::adet('En az 2 tezli yüksek lisans tezi danışmanlığı', ['4.c'], 2, madde: $f['ek']),
            ]),
        ]),
        Kalip::adet('Başlıca yazar olduğunuz ilave 2 makale', $kume, 2, yazar: 'baslica', madde: $f['ek']),
    ]);
    $profKollar[] = Kalip::puanDan('Bilimsel araştırma projesi bölümünden en az '.$p['proje'].' puan', ['PROJE'], $p['proje'], madde: $f['ek']);
    $profKollar[] = Kalip::puanDan('Bilimsel toplantı bölümünden en az '.$p['toplanti'].' puan', ['TOPLANTI'], $p['toplanti'], madde: $f['ek']);
    $profKollar[] = Kalip::puanDan('Bunun en az '.$p['uluslararasi'].' puanı uluslararası toplantı bildirilerinden', ['6a-6c'], $p['uluslararasi'], madde: $f['ek']);
    $profKollar[] = $yurtDisi($ASGARI['profesor'], 'EK-1');
    $profKollar[] = Kalip::beyan('Doçentlik unvanını aldıktan sonra en az üç yılı üniversitede ya da alanla ilgili bir araştırma kuruluşunda fiilen çalışarak geçirmiş olmak', 'EK-1');
    $profKollar[] = Kalip::beyan('Üniversitelerarası Kurul jürisinin sözlü sınavında başarılı olmak (Web of Science H indeksi 25 olanlarda aranmaz)', 'EK-1');

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'ktu-'.$f['ek'].'-profesor',
        'kadro' => 'profesor',
        'cetvel' => 'ktu-2023-'.$f['aile'].'-profesor',
        'notlar' => $f['ek'].' ('.$f['birim'].') profesör sütunu ve EK-1 zorunlu başvuru koşulları. '
            .'Asgari başvuru puanı '.$ASGARI['profesor'].'. Bölüm barajları: makale '.$p['makale']
            .' ('.($p['kume'] > 0 ? 'en az '.$p['kume'].'\'si ('.$f['kume'].')' : 'alt küme koşulu yok').'), '
            .'atıf '.$p['atif'].', tez '.$p['tez'].', proje '.$p['proje'].', toplantı '.$p['toplanti']
            .' (en az '.$p['uluslararasi'].'\'ı 6a-6c).',
        'aday_notu' => $f['birim'].' profesörlük başvurusu için toplam en az '.$ASGARI['profesor']
            .' puan gerekiyor. Bunun '.$p['makale'].' puanı makale bölümünden'
            .($p['kume'] > 0 ? ' ve o puanın en az '.$p['kume'].'\'si dizinli dergilerdeki makalelerden' : '')
            .' gelmeli. Ayrıca başlıca yazar olduğunuz en az '.$p['baslica'].' makale isteniyor; '
            .'bu sayı eksikse her eksik yayın için makale bölümünden 40 puan daha toplamanız gerekiyor. '
            .'Danışmanlığında en az bir doktora ya da iki yüksek lisans tezi tamamlanmış olmalı; '
            .'olmayanlar başlıca yazar olduğu iki ilave makaleyle bu koşulu karşılayabiliyor. '
            .$YURTDISI_NOTU.' '.$ORTAK_NOT,
        'sart' => Kalip::ve('Profesörlüğe yükseltilme ve atanma koşulları', $profKollar),
    ]);

    // ── DOÇENT ──
    $d = $tip['docent'];
    $docKollar = [
        Kalip::toplam($ASGARI['docent']),
        Kalip::puanDan('Makale bölümünden en az '.$d['makale'].' puan', ['MAKALE'], $d['makale'], madde: $f['ek']),
    ];
    if ($d['kume'] > 0) {
        $docKollar[] = Kalip::puanDan(
            'Bu puanın en az '.$d['kume'].'\'i dizinli dergi makalelerinden',
            $kume,
            $d['kume'],
            madde: $f['ek'],
        );
    }
    $docKollar[] = $baslicaKolu($d['baslica'], $f['kume'], max($d['kume'], 40), $f['ek']);
    $docKollar[] = Kalip::puanDan('Atıf bölümünden en az '.$d['atif'].' puan', ['ATIF'], $d['atif'], madde: $f['ek']);
    $docKollar[] = Kalip::puanDan('Bilimsel araştırma projesi bölümünden en az '.$d['proje'].' puan', ['PROJE'], $d['proje'], madde: $f['ek']);
    $docKollar[] = Kalip::puanDan('Bilimsel toplantı bölümünden en az '.$d['toplanti'].' puan', ['TOPLANTI'], $d['toplanti'], madde: $f['ek']);
    $docKollar[] = Kalip::puanDan('Bunun en az '.$d['uluslararasi'].' puanı uluslararası toplantı bildirilerinden', ['6a-6c'], $d['uluslararasi'], madde: $f['ek']);
    $docKollar[] = Kalip::yds(65);
    $docKollar[] = $yurtDisi($ASGARI['docent'], 'EK-1');
    $docKollar[] = Kalip::beyan('Üniversitelerarası Kurul jürisinin sözlü sınavında başarılı olmak ve doçentlik unvanını atanacağı temel alanda almış olmak (Web of Science H indeksi 20 olanlarda sözlü sınav aranmaz)', 'EK-1');

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'ktu-'.$f['ek'].'-docent',
        'kadro' => 'docent',
        'cetvel' => 'ktu-2023-'.$f['aile'].'-docent',
        'notlar' => $f['ek'].' ('.$f['birim'].') doçent sütunu ve EK-1 zorunlu başvuru koşulları. '
            .'Asgari başvuru puanı '.$ASGARI['docent'].'. Bölüm barajları: makale '.$d['makale']
            .' ('.($d['kume'] > 0 ? 'en az '.$d['kume'].'\'i ('.$f['kume'].')' : 'alt küme koşulu yok').'), '
            .'atıf '.$d['atif'].', proje '.$d['proje'].', toplantı '.$d['toplanti']
            .' (en az '.$d['uluslararasi'].'\'ı 6a-6c). Tez danışmanlığında zorunlu puan yok, tavan 30.',
        'aday_notu' => $f['birim'].' doçentlik kadrosu başvurusu için toplam en az '.$ASGARI['docent']
            .' puan gerekiyor; puanlar doktora unvanını aldığınız tarihten sonraki çalışmalardan sayılıyor. '
            .'Makale bölümünden en az '.$d['makale'].' puan'
            .($d['kume'] > 0 ? ', bunun en az '.$d['kume'].'\'i dizinli dergilerdeki makalelerden' : '')
            .' gelmeli ve başlıca yazar olduğunuz en az '.$d['baslica'].' makaleniz olmalı '
            .'(eksik her yayın için 40 puan daha). Yabancı dil sınavından en az 65 (yabancı dille ilgili '
            .'bölümlerde 85) puan isteniyor. '.$YURTDISI_NOTU.' '.$ORTAK_NOT,
        'sart' => Kalip::ve('Doçent kadrosuna atanma koşulları', $docKollar),
    ]);

    // ── DOKTOR ÖĞRETİM ÜYESİ ──
    $dr = $tip['dr'];
    $drKollar = [
        Kalip::toplam($ASGARI['dr']),
        Kalip::puanDan('Makale bölümünden en az '.$f['drPuan'].' puan', ['MAKALE'], $f['drPuan'], madde: $f['ek']),
    ];
    if ($f['drKume'] > 0) {
        $drKollar[] = Kalip::puanDan(
            'Bu puanın en az '.$f['drKume'].'\'ı dizinli dergi makalelerinden',
            $kume,
            $f['drKume'],
            madde: $f['ek'],
        );
    }
    $drKollar[] = $f['aile'] === 'mimarlik'
        ? Kalip::adet('Makalelerinizden en az birinde başlıca yazar olmak', $kume, 1, yazar: 'baslica', madde: $f['ek'])
        : Kalip::adet('Makalelerinizden en az birinde birinci isim olmak', $kume, 1, yazar: 'ilk', madde: $f['ek']);
    $drKollar[] = Kalip::puanDan('Bilimsel toplantı bölümünden en az '.$dr['toplanti'].' puan', ['TOPLANTI'], $dr['toplanti'], madde: $f['ek']);
    if ($f['birim'] !== 'Tıp Fakültesi') {
        $drKollar[] = Kalip::puanDan('Bunun en az '.$dr['uluslararasi'].' puanı uluslararası toplantı bildirilerinden', ['6a-6c'], $dr['uluslararasi'], madde: $f['ek']);
    }
    $drKollar[] = Kalip::yds(65);

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'ktu-'.$f['ek'].'-dr',
        'kadro' => 'dr_ogr_uyesi',
        'cetvel' => 'ktu-2023-'.$f['aile'].'-dr',
        'notlar' => $f['ek'].' ('.$f['birim'].') "Doktor Öğretim Üyesi" sütunu (ilk atama) ve EK-1 '
            .'zorunlu başvuru koşulları. Asgari başvuru puanı '.$ASGARI['dr'].'; makale '.$f['drPuan']
            .' ('.($f['drKume'] > 0 ? 'en az '.$f['drKume'].'\'ı ('.$f['kume'].')' : 'alt küme koşulu yok').'), '
            .'toplantı '.$dr['toplanti']
            .($f['birim'] === 'Tıp Fakültesi' ? ' (Tıp sütununda 6a-6c alt barajı yok).' : ' (en az '.$dr['uluslararasi'].'\'i 6a-6c).'),
        'aday_notu' => $f['birim'].' doktor öğretim üyeliğine ilk atama için toplam en az '.$ASGARI['dr']
            .' puan, makale bölümünden en az '.$f['drPuan'].' puan'
            .($f['drKume'] > 0 ? ' (bunun en az '.$f['drKume'].'\'ı dizinli dergilerdeki makalelerden)' : '')
            .' ve bilimsel toplantı bölümünden en az '.$dr['toplanti'].' puan gerekiyor. '
            .'Yabancı dil sınavından en az 65 (yabancı dille ilgili bölümlerde 85) puan isteniyor. '
            .($f['aile'] === 'mimarlik'
                ? 'Makalelerinizden en az birinde başlıca yazar olmalısınız. '
                : 'Yönerge makalelerinizden en az birinde "birinci veya ikinci isim" olmanızı istiyor; '
                    .'araç yazar sırasını yalnız birinci isim olarak süzebildiği için koşul burada '
                    .'olduğundan sıkı görünüyor — ikinci isim olduğunuz bir yayınla da sağlanabilir. ')
            .'Lisans sonrası en az 89 gün yurt dışında bulunduysanız makale barajınız için '
            .'aranan dizinli dergi puanı daha düşük tutuluyor; bu esneklik araca girilmedi. '
            .$ORTAK_NOT,
        'sart' => Kalip::ve('Doktor öğretim üyeliğine ilk atanma koşulları', $drKollar),
    ]);
}

return $esikler;
