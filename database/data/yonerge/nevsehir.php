<?php

/**
 * NEVŞEHİR HACI BEKTAŞ VELİ ÜNİVERSİTESİ — Öğretim Üyeliğine
 * Yükseltilme ve Atanma Yönergesi
 * Kaynak: pdf/17537005202.nevsehirhacıbektasiveliuniverstesi.pdf
 * (30 sayfa)
 *
 * ── YAPI: ON İKİ TEMEL ALAN, DÖRT KADRO ──
 * Tek puan tablosu (EK 1) — yalnız A.11 ve A.12 satırları Hukuk,
 * İlahiyat ve Filoloji alanlarında farklı, o yüzden üç cetvel varyantı.
 * Koşullar madde 7 (profesör), 8 (doçent), 9 (doktor öğretim üyesi ilk)
 * ve 11 (yeniden atanma) içinde A'dan K'ya on iki temel alan başına ayrı
 * yazılmış. Profesörlük ve doçentlik koşulları SAYICA AYNI; tek fark
 * dönem: profesörlükte doçentlik sonrası, doçentlikte doktora sonrası.
 *
 * ── YENİDEN ATANMADA ÜÇ BASAMAKLI MERDİVEN ──
 * Madde 11 yeniden atanmayı süreye bağlıyor: en ağır koşul dört yıl, en
 * hafifi iki yıl. Eşiğe EN HAFİF basamak (iki yıllık atama) yazıldı —
 * bunun altında yeniden atanma yok. Dört ve üç yıllık basamaklar aday
 * notunda.
 *
 * ── FEN BİLİMLERİNDE İKİ BARAJ ──
 * Madde 7/8(G): "Matematik ve İstatistik alanlarında en az 20 puan,
 * diğer bilim alanlarında en az 40 puan". Profil bilim alanını tutmadığı
 * için §0 uyarınca YÜKSEK olan (40) uygulandı; matematikçi ve
 * istatistikçiler için sonuç olduğundan katı çıkar, aday notu bunu
 * söylüyor.
 *
 * ── GİRİLEMEYEN KOŞUL AYRINTILARI ──
 *   "En az 3'ü FARKLI DERGİLERDE yayınlanmış" koşulu: kayıt derginin
 *       adını tutmadığı için dergi çeşitliliği denetlenemiyor; yalnız
 *       makale sayısı sayılıyor, koşul olduğundan KOLAY görünür.
 *   "Bilimsel toplantılarda sunulan çalışmalardan en az 1'ini KENDİSİ
 *       sunmuş olmak": kayıt sunumu yapanın kim olduğunu taşımıyor.
 *   Yabancı uyruklu adaylar ile yurt dışı doçentlik denkliği başvurusu
 *       yapanlara tanınan "TR Dizin yerine SCI/ESCI/Scopus" istisnası.
 *   Hukuk, İlahiyat ve Sosyal alanlarındaki "ulusal makale şartını
 *       sağlayamayanlar SCI/ESCI/Scopus indeksli 1'i tek yazarlı en az
 *       2-3 yayın yapmak zorundadır" telafisi — `veya` dalı olarak
 *       yazıldı.
 *   Madde 11(c): uzun süreli tedavi, doğum izni ve askerlik gibi
 *       durumlarda puan şartının aranmaması.
 *   Madde 10: 2547 sayılı Kanunun Ek 38. maddesi kapsamındaki %30 kota
 *       ataması — doktor öğretim üyeliği koşullarının aynısı.
 *
 * ── YABANCI DİL ──
 * Bütün kadrolarda 65 puan. Öğretimin en az %30'u yabancı dilde olan
 * bölümlerde 85, çalışma alanı yabancı dil olan bölümlerde başka bir
 * dilden 55 isteniyor; profil bölümün öğretim dilini tutmadığı için §0
 * uyarınca 65 uygulandı ve diğerleri aday notunda yazıldı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/nevsehir-2021.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Nevşehir Hacı Bektaş Veli Üniversitesi';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$DIL_NOTU = ' Yabancı dil koşulu 65 puandan uygulanıyor; öğretimin en az %30\'u yabancı dilde '
    .'yürütülen bölümlerde 85, çalışma alanı yabancı dil olan bölümlerde çalışma alanı dışında '
    .'bir dilden 55 puan gerekiyor.';

$dil = Kalip::yds(65);
$doktora = Kalip::beyan('Doktora, uzmanlık ya da sanatta yeterlik derecesi almış olmak', '9-b');
$docentUnvani = Kalip::beyan(
    'Alanınızla ilgili olarak ÜAK tarafından doçentlik için belirlenen asgari başvuru '
    .'koşullarını yerine getirmiş ve doçent unvanını almış olmak',
    '8-a',
);
$besYil = Kalip::beyan(
    'Doçentlik unvanını aldıktan sonra en az beş yıl, açık bulunan profesörlük kadrosuyla ilgili '
    .'bilim alanında çalışmış olmak',
    '7-b',
);

/** Madde 7/8-1: her alanda ortak proje koşulu. */
$projeKosulu = fn (?array $donem): array => Kalip::adet(
    'Ulusal (TÜBA, TÜBİTAK ve benzeri), uluslararası (AB, BM ve benzeri) kuruluşlarca ya da '
    .'bakanlıklarca desteklenen ve sonuç raporu onaylanan en az bir araştırma projesinde '
    .'yürütücü, araştırmacı veya danışman olmak; ya da yükseköğretim kurumlarının ihtisaslaşma '
    .'veya BAP birimince desteklenmiş en az bir araştırma projesinde yürütücülük yapmış olmak',
    ['PROJE'], 1, donem: $donem, madde: '7/8-1',
);

/** Her alanda ortak bildiri koşulu. */
$bildiriKosulu = fn (?array $donem): array => Kalip::puanDan(
    'Uluslararası ya da ulusal bilimsel toplantılarda sunulan, tam metni veya özeti basılmış '
    .'çalışmalardan en az 5 puan (en az birini kendiniz sunmuş olmalısınız)',
    ['BILDIRI'], 5, $donem, madde: '7/8-2-c',
);

/**
 * Bir temel alanın profesörlük ve doçentlik yayın koşulları.
 *
 * @return list<array<string, mixed>>
 */
$yayinKosullari = function (string $alan, ?array $donem): array {
    $k = [];

    $tr = fn (int $puan) => Kalip::puanDan("TR Dizin kapsamındaki dergilerde yayımlanmış makalelerden en az {$puan} puan", ['TRDIZIN'], $puan, $donem, madde: '7/8-2-b');
    $trAdet = fn (int $sayi) => Kalip::adet(
        "TR Dizin kapsamındaki dergilerde yayımlanmış en az {$sayi} makaleniz olmak",
        ['TRDIZIN'], $sayi, donem: $donem, madde: '7/8-2-b',
    );
    $trAdetTek = fn (int $sayi) => Kalip::adet(
        "TR Dizin kapsamındaki dergilerde yayımlanmış en az {$sayi} tek yazarlı makaleniz olmak",
        ['TRDIZIN'], $sayi, yazar: 'tek', donem: $donem, madde: '7/8-2-b',
    );
    $trAdetBaslica = fn (int $sayi) => Kalip::adet(
        "TR Dizin kapsamındaki dergilerde yayımlanmış en az {$sayi} makalede başlıca yazar olmak",
        ['TRDIZIN'], $sayi, yazar: 'baslica', donem: $donem, madde: '7/8-2-b',
    );
    $ulusalAdet = fn (int $sayi) => Kalip::adet("Toplam en az {$sayi} ulusal makaleniz olmak", ['ULUSAL'], $sayi, donem: $donem, madde: '7/8-2-b');
    $kitap = fn () => Kalip::veya('Kitap koşulu', [
        Kalip::adet('BKCI indeksinde yer alan ya da ÜAK tarafından tanımlanan yayınevlerince basılmış en az bir kitap yayımlamış olmak', ['KITAP'], 1, donem: $donem, madde: '7/8-2'),
        Kalip::adet('Ya da bu indekslerde yayımlanmış en az iki kitap bölümü yayımlamış olmak', ['KITAP-BOLUM'], 2, donem: $donem, madde: '7/8-2'),
    ]);

    switch ($alan) {
        case 'egitim':
            $k[] = Kalip::puanDan('SCI, SCIE ya da SSCI indeksli Q1, Q2 ve Q3 dergilerde yayımlanmış makalelerden en az 30 puan', ['SCI-Q123'], 30, $donem, madde: '7/8-2-a');
            $k[] = $trAdet(1);
            $k[] = $ulusalAdet(2);
            break;
        case 'filoloji':
        case 'hukuk':
            $k[] = $trAdetTek(4);
            $k[] = $ulusalAdet(6);
            $k[] = $kitap();
            break;
        case 'ilahiyat':
            $k[] = $trAdetTek(3);
            $k[] = $ulusalAdet(5);
            $k[] = $kitap();
            break;
        case 'sosyal':
            $k[] = Kalip::puanDan('Uluslararası indekslerde taranan dergilerde yayımlanmış makalelerden en az 10 puan', ['ULUSLARARASI'], 10, $donem, madde: '7/8-2-a');
            $k[] = $trAdetTek(3);
            $k[] = $ulusalAdet(5);
            $k[] = $kitap();
            break;
        case 'ziraat':
            $k[] = Kalip::puanDan('SCI, SCIE ve SSCI indekslerinde taranan dergilerde yayımlanmış makalelerden en az 30 puan', ['SCI'], 30, $donem, madde: '7/8-2-a');
            $k[] = Kalip::adet('Q1, Q2 ve Q3 dergilerde en az bir makalede başlıca yazar olmak', ['SCI-Q123'], 1, yazar: 'baslica', donem: $donem, madde: '7/8-2-a');
            $k[] = Kalip::puanDan('Q1, Q2 ve Q3 dergilerdeki makalelerinizden en az 20 puan', ['SCI-Q123'], 20, $donem, madde: '7/8-2-a');
            $k[] = $tr(20);
            break;
        case 'fen':
        case 'muhendislik':
            $k[] = Kalip::adet('SCI, SCIE ya da SSCI indeksli Q1, Q2 ve Q3 dergilerde en az bir makalede başlıca yazar olmak', ['SCI-Q123'], 1, yazar: 'baslica', donem: $donem, madde: '7/8-2-a');
            $k[] = Kalip::puanDan('Q1, Q2 ve Q3 dergilerdeki makalelerinizden en az 40 puan', ['SCI-Q123'], 40, $donem, madde: '7/8-2-a');
            $k[] = $tr(10);
            break;
        case 'saglik':
            $k[] = Kalip::adet('SCI, SCIE ya da SSCI indeksli dergilerde en az üç makalede başlıca yazar olmak', ['SCI'], 3, yazar: 'baslica', donem: $donem, madde: '7/8-2-a');
            $k[] = Kalip::puanDan('SCI, SCIE ve SSCI indeksli dergilerdeki makalelerinizden en az 40 puan', ['SCI'], 40, $donem, madde: '7/8-2-a');
            $k[] = $trAdet(3);
            $k[] = $trAdetBaslica(2);
            break;
        case 'spor':
            $k[] = Kalip::adet('SCI, SCIE, SSCI ya da AHCI indekslerinde en az bir makalede başlıca yazar olmak', ['SCI-AHCI'], 1, yazar: 'baslica', donem: $donem, madde: '7/8-2-a');
            $k[] = Kalip::puanDan('SCI, SCIE, SSCI ve AHCI indekslerinde taranan makalelerinizden en az 30 puan', ['SCI-AHCI'], 30, $donem, madde: '7/8-2-a');
            $k[] = $trAdet(2);
            $k[] = $ulusalAdet(3);
            $k[] = $kitap();
            break;
        case 'mimarlik':
            $k[] = Kalip::adet('SCI, SCIE, SSCI, AHCI, ESCI ya da Scopus indekslerinde en az bir makalede başlıca yazar olmak', ['SCI-ESCI'], 1, yazar: 'baslica', donem: $donem, madde: '7/8-2-a');
            $k[] = Kalip::puanDan('Bu indekslerde taranan makalelerinizden en az 20 puan', ['SCI-ESCI'], 20, $donem, madde: '7/8-2-a');
            $k[] = $trAdet(1);
            break;
        default: // guzel_sanatlar
            $k[] = Kalip::puanDan('Uluslararası indekslerde taranan dergilerde yayımlanmış makalelerden en az 10 puan', ['ULUSLARARASI'], 10, $donem, madde: '7/8-2-a');
            $k[] = $trAdetTek(1);
            $k[] = $kitap();
    }

    return $k;
};

$ALANLAR = [
    'egitim' => ['Eğitim Bilimleri', 'nevsehir-2021'],
    'filoloji' => ['Filoloji', 'nevsehir-2021-ilahiyat'],
    'hukuk' => ['Hukuk', 'nevsehir-2021-hukuk'],
    'ilahiyat' => ['İlahiyat', 'nevsehir-2021-ilahiyat'],
    'sosyal' => ['Sosyal, Beşeri ve İdari Bilimler', 'nevsehir-2021'],
    'ziraat' => ['Ziraat, Orman ve Su Ürünleri', 'nevsehir-2021'],
    'fen' => ['Fen Bilimleri ve Matematik', 'nevsehir-2021'],
    'muhendislik' => ['Mühendislik', 'nevsehir-2021'],
    'saglik' => ['Sağlık Bilimleri', 'nevsehir-2021'],
    'spor' => ['Spor Bilimleri', 'nevsehir-2021'],
    'mimarlik' => ['Mimarlık, Planlama ve Tasarım', 'nevsehir-2021'],
    'guzel_sanatlar' => ['Güzel Sanatlar', 'nevsehir-2021'],
];

// Madde 9: doktor öğretim üyeliğine ilk atanma — alan başına
// [uluslararası grup, uluslararası puan, TR Dizin puanı].
$DR_ILK = [
    'egitim' => ['SCI-ESCI', 10, 10],
    'filoloji' => [null, 0, 20],
    'hukuk' => [null, 0, 20],
    'ilahiyat' => [null, 0, 20],
    'sosyal' => ['ULUSLARARASI', 5, 20],
    'ziraat' => ['SCI-ESCI', 10, 10],
    'fen' => ['SCI', 10, 10],
    'muhendislik' => ['SCI', 10, 10],
    'saglik' => ['SCI', 10, 10],
    'spor' => ['SCI-ESCI', 10, 10],
    'mimarlik' => [null, 0, 20],
    'guzel_sanatlar' => [null, 0, 20],
];

// Madde 11: yeniden atanmanın EN HAFİF basamağı (iki yıllık atama).
$DR_YENIDEN_SCI = ['egitim', 'ziraat', 'fen', 'muhendislik', 'saglik', 'spor'];

$esikler = [];

foreach ($ALANLAR as $alan => [$alanAdi, $cetvel]) {
    $ortak = ['universite' => $UNIVERSITE, 'alan' => [$alan], 'cetvel' => $cetvel];
    [$drGrup, $drPuan, $drTr] = $DR_ILK[$alan];

    // ── Doktor Öğretim Üyeliğine ilk atanma (madde 9) ──
    $drKosullar = [$doktora, $dil];

    if ($drGrup !== null) {
        $drKosullar[] = Kalip::puanDan(
            "Uluslararası indeksli dergilerde yayımlanmış makalelerden en az {$drPuan} puan",
            [$drGrup], $drPuan, madde: '9-e',
        );
    }

    $drKosullar[] = Kalip::puanDan(
        "TR Dizin kapsamındaki dergilerde yayımlanmış makalelerden en az {$drTr} puan",
        ['TRDIZIN'], $drTr, madde: '9-e',
    );
    $drKosullar[] = Kalip::toplam(30);

    $esikler[] = array_merge($ortak, [
        'anahtar' => "nevsehir-{$alan}-dr",
        'kadro' => 'dr_ogr_uyesi',
        'aday_notu' => "{$alanAdi} alanında doktor öğretim üyeliğine ilk atanma için EK 1 "
            .'puanlama tablosundan toplam en az 30 puan, TR Dizin dergilerinden en az '
            ."{$drTr} puan"
            .($drGrup !== null ? " ve uluslararası indeksli dergilerden en az {$drPuan} puan" : '')
            .' isteniyor. İlk atama üç yıl süreyle yapılıyor.'.$DIL_NOTU,
        'notlar' => "Madde 9 ({$alanAdi}): TR Dizin {$drTr} puan"
            .($drGrup !== null ? ", uluslararası {$drPuan} puan" : '').'; toplam 30 puan.',
        'sart' => Kalip::ve("Doktor Öğretim Üyesi kadrosuna ilk atanma — {$alanAdi}", $drKosullar),
    ]);

    // ── Doktor Öğretim Üyeliğine yeniden atanma (madde 11) ──
    $sciTabanli = in_array($alan, $DR_YENIDEN_SCI, true);

    $esikler[] = array_merge($ortak, [
        'anahtar' => "nevsehir-{$alan}-dr-yeniden",
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'aday_notu' => 'Son atama tarihinizden sonraki faaliyetleriniz sayılıyor. Madde 11 '
            .'yeniden atanmayı SÜREYE bağlıyor; aşağıda EN HAFİF basamak (iki yıllık atama) '
            .'gösteriliyor: '
            .($sciTabanli
                ? 'SCI, SCIE, SSCI, AHCI, ESCI ya da Scopus indeksli dergilerden en az 10 puan '
                    .'ya da diğer uluslararası indeksler ile TR Dizin dergilerinden en az 15 puan'
                : 'uluslararası indeksli ya da TR Dizin dergilerinden en az 10 puan')
            .' almak şartıyla toplam en az 30 puan. Üç yıllık atama için toplam 50-60, dört '
            .'yıllık atama için toplam 70-80 puan ve daha yüksek indeks barajları gerekiyor. '
            .'Uzun süreli tedavi, doğum izni, askerlik ve ücretsiz izin gibi durumlarda puan '
            .'şartı aranmadan bir yıl süreyle atanabiliyorsunuz.',
        'notlar' => "Madde 11 ({$alanAdi}): en hafif basamak — toplam 30 puan, son atama sonrası.",
        'sart' => Kalip::ve("Doktor Öğretim Üyesi kadrosuna yeniden atanma — {$alanAdi}", [
            $sciTabanli
                ? Kalip::veya('İndeks koşulu', [
                    Kalip::puanDan('SCI, SCIE, SSCI, AHCI, ESCI ya da Scopus indeksli dergilerde yayımlanmış makalelerden en az 10 puan', ['SCI-ESCI'], 10, $SON_ATAMA, madde: '11-d'),
                    Kalip::puanDan('Ya da diğer uluslararası indeksler ile TR Dizin dergilerinde yayımlanmış makalelerden en az 15 puan', ['DIGER-TRDIZIN'], 15, $SON_ATAMA, madde: '11-d'),
                ])
                : Kalip::puanDan('Uluslararası indeksli ya da TR Dizin kapsamındaki dergilerde yayımlanmış makalelerden en az 10 puan', ['ULUSLARARASI-TRDIZIN'], 10, $SON_ATAMA, madde: '11-d'),
            Kalip::toplam(30, $SON_ATAMA),
        ]),
    ]);

    // ── Doçentlik (madde 8) ve profesörlük (madde 7) ──
    foreach ([
        ['docentlik', 'Doçent', $DOKTORA, 'doktor unvanınızı aldıktan sonraki', '8',
            [$docentUnvani, $dil]],
        ['profesorluk', 'Profesör', $DOCENTLIK, 'doçent unvanınızı aldıktan sonraki', '7',
            [$besYil, $dil]],
    ] as [$kadro, $kadroAd, $donem, $donemAd, $md, $onKosullar]) {
        $esikler[] = array_merge($ortak, [
            'anahtar' => "nevsehir-{$alan}-{$kadro}",
            'kadro' => $kadro,
            'aday_notu' => "{$alanAdi} alanında {$kadroAd} kadrosu için {$donemAd} "
                .'çalışmalarınız sayılıyor: desteklenen ve sonuç raporu onaylanan en az bir '
                .'araştırma projesinde görev almış olmanız, alanınıza özgü makale ve kitap '
                .'koşullarını sağlamanız, bilimsel toplantı çalışmalarından en az 5 puan '
                .'almanız ve EK 1 puanlama tablosundan toplam en az 100 puan almanız gerekiyor.'
                .($alan === 'fen'
                    ? ' Matematik ve İstatistik bilim alanlarında Q1-Q3 barajı 20 puandır; '
                        .'motor bilim alanını ayırt edemediği için yüksek olan (40) uygulanıyor.'
                    : '')
                .' "En az üçü farklı dergilerde yayımlanmış" ve "en az birini kendiniz sunmuş '
                .'olmak" koşulları kayıttan denetlenemiyor.'.$DIL_NOTU,
            'notlar' => "Madde {$md} ({$alanAdi}): proje; alana özgü makale ve kitap koşulları; "
                .'bildiri 5 puan; toplam 100 puan.',
            'sart' => Kalip::ve("{$kadroAd} kadrosuna atanma — {$alanAdi}", array_merge(
                $onKosullar,
                [$projeKosulu($donem)],
                $yayinKosullari($alan, $donem),
                [$bildiriKosulu($donem), Kalip::toplam(100, $donem)],
            )),
        ]);
    }
}

return $esikler;
