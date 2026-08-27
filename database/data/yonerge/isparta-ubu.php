<?php

/**
 * ISPARTA UYGULAMALI BİLİMLER ÜNİVERSİTESİ (ISUBÜ) — Akademik Yükseltilme
 * ve Atanma Ölçütleri Yönergesi
 * Kaynak: pdf/17536996862.ispartauygulamalibilimleruniverstesi.pdf
 * (11 sayfa; Senato 20.10.2020-57/09, 2022/86-04 sayılı Senato Kararı
 * değişiklikleriyle)
 *
 * ── YAPI: ÜÇ ALAN GRUBU × DÖRT KADRO ──
 * Her kadro maddesi önce "Ortak Şartlar (Tüm Birimler)" veriyor, sonra üç
 * alan grubuna ayrılıyor:
 *   Fen, Mühendislik Bilimleriyle İlgili Fakülteler/Yüksekokullar → `fen`,
 *       `muhendislik`
 *   Sosyal, Beşeri ve İdari Bilimlerle İlgili Fakülteler         → `sosyal`
 *   Güzel Sanatlar Temel Alanı                                   → `guzel_sanatlar`
 * Yönerge başka temel alana koşul koymuyor; sağlık, eğitim, ilahiyat,
 * hukuk, filoloji, mimarlık, ziraat ve spor kapsam dışı bırakıldı.
 *
 * ── BARAJ TABLONUN TAMAMINA DEĞİL, BÖLÜMÜNE BAĞLI ──
 * "Tablo 1'den en az 40 puan almak şartıyla, Tablo 1 ve Tablo 2'den
 * toplamda asgari 60 puan" — iki ayrı düğüm: alt baraj `Kalip::puanDan`
 * ile `T1` grubuna, toplam `Kalip::toplam`'a `maddeler` ve `liste`
 * geçilerek `T1`+`T2` kümesine bağlandı. Güzel Sanatlar adaylarında küme
 * `T2`+`T3`; Tablo 1 onların hiçbir barajında yok.
 *
 * ── "ŞARTLARDAN EN AZ BİRİNİ/İKİSİNİ SAĞLAMAK" ──
 * Kadro maddelerinin çoğu puan barajının yanına bir de ölçüt listesi
 * koyuyor; karşılığı `Kalip::kIle`. Faaliyet kaydından okunamayan dallar
 * listeden ÇIKARILDI (KONVANSIYONLAR §"Puan barajı olmayan, ÖLÇÜT SAYAN
 * yönergeler"): sayım daralıyor, yani aday bir ölçüt daha az sayıyor.
 * Çıkarılan dallar:
 *   MADDE 6/2-c-2'nin "kamu kurumu projesine yürütücü olarak BAŞVURMUŞ ve
 *       panelde bilimsel değerlendirmeye alınmış olmak" dalı — başvuru
 *       kaydı yok; aynı bendin "en az 1 projede araştırmacı olmak" dalı
 *       yazıldı.
 *   MADDE 6/2-c-3 "BAP birimlerince desteklenen münferit projede (TEZ
 *       PROJESİ HARİÇ) yürütücü olmak" — tez projesi ile münferit proje
 *       kayıtta ayrılamıyor; yazsaydık tez projesi olan adayı sağlamış
 *       gösterirdik.
 *   MADDE 8/2-b-7 "WOS etki faktörü 4 ve üzeri dergilerde başlıca yazar
 *       olarak yayın yapmak" — etki faktörü kayıtta yok.
 *
 * ── "İLAVETEN" BENTLERİ ──
 * Ölçüt listelerinin son bendi hep aynı kalıpta: "(a) bendindeki puana
 * ilaveten Tablo 1'den en az N puan". Bunlar toplama EKLENEN barajlar,
 * ayrı bir küme değil; iki barajın toplamı tek `puanDan`/`toplam`
 * düğümüne yazıldı (ör. MADDE 6/2-b'nin 40 puanı + 6/2-c-6'nın 20 puanı
 * → `T1`den 60 puan).
 * Aynı kalıbın makale hâli MADDE 6/2-c-4: "6/2-a bendine ilaveten
 * SSCI/SCI/SCI-Expanded'de en az 1 araştırma makalesi". 6/2-a zaten bir
 * SCI makalesiyle de sağlanabildiği için "ilaveten" ikinci bir makale
 * demek; §0 uyarınca sıkı okuma alındı ve 2 makale yazıldı.
 *
 * ── YENİDEN ATANMA GİRİLDİ ──
 * MADDE 6/3, 6/5 ve 6/7 yeniden atanmayı süreye değil son atanma tarihine
 * bağlıyor ("Son atanma tarihinden sonra Tablo 1'den en az 20 puan olacak
 * şekilde ... toplamda en az 40 puan"), bu yüzden `SON_ATAMA_SONRASI`
 * dönemiyle yazıldı. Aynı maddelerin (b) fıkrasındaki "izleme amaçlı en
 * fazla 2 yıllık yeniden atama" düzenlemesi bir süreç kuralı; barajı
 * değiştirmiyor, aday notunda anlatıldı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 5/ç: başvuruların rektörlükçe kurulan 7 kişilik inceleme
 *       komisyonunca değerlendirilmesi — süreç kuralı.
 *   MADDE 5/e: askerlik, sağlık ve doğum izni nedeniyle görevde
 *       bulunulamayan sürenin düşülmesi — profilde yok.
 *   MADDE 8/1-b: "İlgili alanda ÜAK tarafından belirlenmiş doçentlik
 *       müracaat ölçütlerini tekrar sağlamış olmak" — `beyan` olarak
 *       duruyor; ÜAK ölçütleri adayın başvurduğu döneme göre değiştiği
 *       için `referans` ile bağlanamıyor.
 *   Doçentlikte "en az 2 yıl akademik kadroda fiilen çalışmış olmak",
 *       profesörlükte "3 yıl" koşulları `beyan`; ikisinin de h-indeksi
 *       alternatifi (8 ve 12) `metrik` ile yazıldı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/isparta-ubu-2022.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Isparta Uygulamalı Bilimler Üniversitesi';
$CETVEL = 'isparta-ubu-2022';
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$T12 = ['T1', 'T2'];
$T23 = ['T2', 'T3'];
$LISTE12 = 'Tablo 1 ve Tablo 2';
$LISTE23 = 'Tablo 2 ve Tablo 3';

$UYARI = ' DİKKAT: yönergenin ölçüt listelerinden faaliyet kaydından okunamayan dallar '
    .'çıkarıldı (kamu kurumu projesine yapılmış BAŞVURU, tez projesi dışındaki BAP '
    .'yürütücülüğü, WOS etki faktörü 4 üzeri dergide yayın); bu ölçütlerden birini '
    .'sağlıyorsanız gerçek durumunuz ekrandakinden iyidir.';

$doktora = Kalip::beyan(
    'Doktora ya da tıpta, diş hekimliğinde, eczacılıkta, veteriner hekimlikte uzmanlık '
    .'veya sanatta yeterlilik eğitimini tamamlamış olmak',
    'MADDE 6/1-a',
);

$docentUnvani = Kalip::beyan('Doçent unvanını almış olmak', 'MADDE 7/1-a');

$uakOlcutleri = Kalip::beyan(
    'İlgili alanda ÜAK tarafından belirlenmiş doçentlik müracaat ölçütlerini (başvurduğunuz '
    .'dönemdeki doçentlik başvuru şartlarını) tekrar sağlamış olmak; lisansüstü tezlerinizden '
    .'üretilen yayın zorunluluğu tekrar aranmaz',
    'MADDE 8/1-b',
);

$docentKidem = Kalip::veya('Akademik kıdem koşulu', [
    Kalip::beyan('En az 2 yıl süreyle üniversitelerde akademik kadrolarda fiilen çalışmış olmak', 'MADDE 7/1-c'),
    Kalip::metrik('Ya da Web of Science h-indeksiniz en az 8 olmalı', 'h_indeksi', 8),
]);

$profesorKidem = Kalip::veya('Akademik kıdem koşulu', [
    Kalip::beyan('Doçent unvanını aldıktan sonra en az 3 yıl süreyle üniversitelerde akademik kadrolarda fiilen çalışmış olmak', 'MADDE 8/1-c'),
    Kalip::metrik('Ya da Web of Science h-indeksiniz en az 12 olmalı', 'h_indeksi', 12),
]);

// MADDE 6/2-c-1, 6/4-b-4, 7/2-b-1, 8/2-b-1, 8/3-b-1 — aynı ölçüt.
$yurtdisi = Kalip::metrik(
    'Yurt dışında bir yükseköğretim ya da araştırma kurumunda en az 3 ay çalışmış olmak',
    'yurtdisi_ay', 3,
);

/** @param 'tek'|'ilk' $yazar */
$kitapVeyaEditor = fn (string $madde, string $yazar): array => Kalip::veya(
    'Atanacağınız temel alanda ulusal ya da uluslararası nitelikte bilimsel bir kitap veya '
    .'kitap bölümü yazmış ya da editörlüğünü yapmış olmak',
    [
        Kalip::adet(
            $yazar === 'tek'
                ? 'Tek yazarlı bilimsel bir kitabınız ya da kitap bölümünüz olmalı'
                : 'İlk isim yazar olduğunuz bilimsel bir kitabınız ya da kitap bölümünüz olmalı',
            ['KITAP'], 1, yazar: $yazar === 'tek' ? 'tek' : 'ilk', madde: $madde,
        ),
        Kalip::adet('Ya da bir kitabın editörlüğünü yapmış olmalısınız', ['KITAP-EDITOR'], 1, madde: $madde),
    ],
);

$tezTamamlama = fn (string $madde, ?array $donem): array => Kalip::veya(
    'En az 2 yüksek lisans ya da 1 doktora tez danışmanlığı yaparak ilgili tezleri tamamlatmış olmak',
    [
        Kalip::adet('Yönetiminizde tamamlanmış en az 1 doktora teziniz olmalı', ['TEZ-DOKTORA'], 1, donem: $donem, madde: $madde),
        Kalip::adet('Ya da yönetiminizde tamamlanmış en az 2 yüksek lisans teziniz olmalı', ['TEZ-YL'], 2, donem: $donem, madde: $madde),
    ],
);

$esikler = [];

// ══════════════════════════════════════════════════════════════════════════
// MADDE 6 — DOKTOR ÖĞRETİM ÜYESİ
// ══════════════════════════════════════════════════════════════════════════

$drOrtak = [
    $doktora,
    Kalip::yds(55),
];

$esikler[] = [
    'anahtar' => 'isparta-ubu-fen-muh-dr',
    'aday_notu' => 'Fen ve Mühendislik Bilimleriyle ilgili birimlerde Dr. Öğretim Üyeliği için '
        .'Tablo 1\'den en az 40 puan olmak üzere Tablo 1 ve Tablo 2\'den toplam 60 puan, bir '
        .'yayın koşulu ve altı ölçütten en az ikisi isteniyor.'.$UYARI,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['fen', 'muhendislik'],
    'cetvel' => $CETVEL,
    'notlar' => 'MADDE 6/1 ve 6/2: doktora, YDS 55; SSCI/SCI/SCI-Expanded\'de en az 1 ya da diğer '
        .'indekslerde en az 3 araştırma makalesi; Tablo 1\'den en az 40 puan olmak üzere Tablo 1 ve '
        .'Tablo 2\'den toplam en az 60 puan; 6/2-c bendindeki şartlardan en az ikisi.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma — Fen ve Mühendislik Bilimleri', [
        ...$drOrtak,
        Kalip::veya('Yayın koşulu', [
            Kalip::adet('SSCI, SCI ya da SCI-Expanded kapsamındaki dergilerde en az 1 araştırma makaleniz olmalı', ['SCI-MAKALE'], 1, madde: 'MADDE 6/2-a'),
            Kalip::adet('Ya da diğer indekslere giren hakemli dergilerde en az 3 araştırma makaleniz olmalı', ['DIGER-INDEKS-MAKALE'], 3, madde: 'MADDE 6/2-a'),
        ]),
        Kalip::puanDan('Tablo 1 kalemlerinizden en az 40 puan', ['T1'], 40, madde: 'MADDE 6/2-b'),
        Kalip::kIle('Aşağıdaki ölçütlerden en az 2 tanesini sağlamalısınız', 2, [
            $yurtdisi,
            Kalip::adet('Üniversite dışındaki kamu kurumları projelerinden en az 1\'inde araştırmacı olmak', ['PROJE-KAMU-A'], 1, madde: 'MADDE 6/2-c-2'),
            Kalip::adet('Madde 6/2-a\'daki yayına ilaveten SSCI, SCI ya da SCI-Expanded kapsamında bir makale daha (toplam 2)', ['SCI-MAKALE'], 2, madde: 'MADDE 6/2-c-4'),
            $kitapVeyaEditor('MADDE 6/2-c-5', 'ilk'),
            Kalip::puanDan('Madde 6/2-b\'deki puana ilaveten Tablo 1\'den 20 puan daha (toplam 60)', ['T1'], 60, madde: 'MADDE 6/2-c-6'),
        ]),
        Kalip::toplam(60, null, $T12, $LISTE12),
    ]),
];

$esikler[] = [
    'anahtar' => 'isparta-ubu-sosyal-dr',
    'aday_notu' => 'Sosyal, Beşeri ve İdari Bilimlerle ilgili birimlerde Dr. Öğretim Üyeliği için '
        .'Tablo 1\'den en az 40 puan olmak üzere Tablo 1 ve Tablo 2\'den toplam 60 puan ve beş '
        .'ölçütten en az biri isteniyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['sosyal'],
    'cetvel' => $CETVEL,
    'notlar' => 'MADDE 6/1 ve 6/4: doktora, YDS 55; Tablo 1\'den en az 40 puan olmak üzere Tablo 1 '
        .'ve Tablo 2\'den toplam en az 60 puan; 6/4-b bendindeki şartlardan en az biri.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma — Sosyal, Beşeri ve İdari Bilimler', [
        ...$drOrtak,
        Kalip::puanDan('Tablo 1 kalemlerinizden en az 40 puan', ['T1'], 40, madde: 'MADDE 6/4-a'),
        Kalip::kIle('Aşağıdaki ölçütlerden en az 1 tanesini sağlamalısınız', 1, [
            Kalip::adet('SSCI, AHCI, SCI ya da SCI-Expanded kapsamındaki dergilerde 1 makaleniz olmalı', ['SCI-MAKALE'], 1, madde: 'MADDE 6/4-b-1'),
            Kalip::ve('En az 1\'i ISI indeksli ya da SCOPUS hakemli dergide olmak üzere toplam 2 makale', [
                Kalip::adet('Toplam en az 2 makaleniz olmalı', ['TUM-MAKALE'], 2, madde: 'MADDE 6/4-b-2'),
                Kalip::adet('Bunlardan en az 1\'i ISI indeksli ya da SCOPUS hakemli dergide olmalı', ['ISI-SCOPUS-MAKALE'], 1, madde: 'MADDE 6/4-b-2'),
            ]),
            Kalip::adet('ULAKBİM tarafından taranan dergilerde en az 3 makaleniz olmalı', ['ULAKBIM-MAKALE'], 3, madde: 'MADDE 6/4-b-3'),
            $yurtdisi,
            Kalip::puanDan('Madde 6/4-a\'daki puana ilaveten Tablo 1\'den 20 puan daha (toplam 60)', ['T1'], 60, madde: 'MADDE 6/4-b-5'),
        ]),
        Kalip::toplam(60, null, $T12, $LISTE12),
    ]),
];

$esikler[] = [
    'anahtar' => 'isparta-ubu-gsf-dr',
    'aday_notu' => 'Güzel Sanatlar Temel Alanında Dr. Öğretim Üyeliği için Tablo 3\'ten en az 40 '
        .'puan olmak üzere Tablo 2 ve Tablo 3\'ten toplam 60 puan; ayrıca Tablo 3/A\'nın 4. '
        .'maddesindeki asgari puanı (12,5 → 13) sağladıktan sonra 1, 2, 3 ve 5 numaralı '
        .'maddelerden en az üçünde eser vermiş olmak isteniyor. DİKKAT: Tablo 3\'ün puanı bir '
        .'PORTFÖYE bağlı satırları (altı eserlik beste dosyası, üç saatlik resital dizisi, dört '
        .'saatlik şeflik kaydı gibi) eser başına bölünemediği için hiç girilemedi; bu satırlardan '
        .'puan alacaksanız gerçek durumunuz ekrandakinden iyidir.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['guzel_sanatlar'],
    'cetvel' => $CETVEL,
    'notlar' => 'MADDE 6/1 ve 6/6: doktora ya da sanatta yeterlik, YDS 55; Tablo 3\'ten en az 40 '
        .'puan olmak üzere Tablo 2 ve Tablo 3\'ten toplam en az 60 puan; Tablo 3/A-4\'ün asgari '
        .'puanından sonra A-1, A-2, A-3 ve A-5\'ten en az üçünde eser.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma — Güzel Sanatlar', [
        ...$drOrtak,
        Kalip::puanDan('Tablo 3 kalemlerinizden en az 40 puan', ['T3'], 40, madde: 'MADDE 6/6-a'),
        Kalip::puanDan('Tablo 3/A-4 kalemlerinizden (kitap, makale, çeviri) en az 13 puan', ['A4'], 13, madde: 'MADDE 6/6-b'),
        Kalip::kIle('Tablo 3/A\'nın 1, 2, 3 ve 5 numaralı maddelerinden en az 3\'ünde eseriniz olmalı', 3, [
            Kalip::adet('Kişisel etkinlik (sergi, bienal, gösteri, dinleti, festival, gösterim)', ['A1'], 1, madde: 'MADDE 6/6-b'),
            Kalip::adet('Karma ya da ortak etkinlik veya kamusal alanda sergilenen/satın alınan eser', ['A2'], 1, madde: 'MADDE 6/6-b'),
            Kalip::adet('Sempozyum, festival, workshop ya da bienale eserle katılım', ['A3'], 1, madde: 'MADDE 6/6-b'),
            Kalip::adet('Bilimsel ya da sanatsal toplantıda bildiri', ['A5'], 1, madde: 'MADDE 6/6-b'),
        ]),
        Kalip::toplam(60, null, $T23, $LISTE23),
    ]),
];

// ── MADDE 6/3, 6/5, 6/7: yeniden atanma ──

$yenidenNotu = 'Bir önceki atama tarihinizden itibaren yaptığınız çalışmalar sayılıyor. Asgari '
    .'puanı sağlayamayan adaylara, durumunun izlenmesi amacıyla her defasında bir yıllık olmak '
    .'üzere en fazla 2 yıllığına yeniden atama yapılabiliyor; o dönemin sonunda aynı puanlar '
    .'aranıyor (MADDE 6/3-b, 6/5-b, 6/7-b).';

foreach ([
    ['fen-muh', ['fen', 'muhendislik'], 'T1', $T12, $LISTE12, 'Fen ve Mühendislik Bilimleri', 'MADDE 6/3-a'],
    ['sosyal', ['sosyal'], 'T1', $T12, $LISTE12, 'Sosyal, Beşeri ve İdari Bilimler', 'MADDE 6/5-a'],
    ['gsf', ['guzel_sanatlar'], 'T3', $T23, $LISTE23, 'Güzel Sanatlar', 'MADDE 6/7-a'],
] as [$anahtar, $alanlar, $altGrup, $kume, $listeAdi, $grupAdi, $madde]) {
    $esikler[] = [
        'anahtar' => "isparta-ubu-{$anahtar}-dr-yeniden",
        'aday_notu' => $yenidenNotu." {$grupAdi} birimlerinde son atanma tarihinizden sonra "
            ."{$altGrup} kalemlerinizden en az 20 puan olmak üzere {$listeAdi}'den toplam en az "
            .'40 puan isteniyor.',
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => "{$madde}: son atanma tarihinden sonra {$altGrup}'den en az 20 puan olacak "
            ."şekilde {$listeAdi}'den toplamda en az 40 puan.",
        'sart' => Kalip::ve("Doktor Öğretim Üyeliğine yeniden atanma — {$grupAdi}", [
            Kalip::puanDan("Son atamanızdan sonra {$altGrup} kalemlerinizden en az 20 puan", [$altGrup], 20, $SON_ATAMA, madde: $madde),
            Kalip::toplam(40, $SON_ATAMA, $kume, $listeAdi),
        ]),
    ];
}

// ══════════════════════════════════════════════════════════════════════════
// MADDE 7 — DOÇENT
// ══════════════════════════════════════════════════════════════════════════

$docentOrtak = [
    $docentUnvani,
    Kalip::yds(65),
    $docentKidem,
];

$esikler[] = [
    'anahtar' => 'isparta-ubu-fen-muh-docentlik',
    'aday_notu' => 'Fen ve Mühendislik Bilimleriyle ilgili birimlerde doçent kadrosu için Tablo 1 '
        .'ve Tablo 2\'den toplam en az 100 puan ve dokuz ölçütten en az biri isteniyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['fen', 'muhendislik'],
    'cetvel' => $CETVEL,
    'notlar' => 'MADDE 7/1 ve 7/2: doçent unvanı, YDS 65, 2 yıl akademik kadro ya da h-indeksi 8; '
        .'Tablo 1 ve Tablo 2\'den toplam en az 100 puan; 7/2-b bendindeki şartlardan en az biri.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — Fen ve Mühendislik Bilimleri', [
        ...$docentOrtak,
        Kalip::kIle('Aşağıdaki ölçütlerden en az 1 tanesini sağlamalısınız', 1, [
            $yurtdisi,
            Kalip::adet('AB ya da uluslararası fonlarca desteklenen en az 1 projede yürütücü veya yardımcı araştırmacı olmak', ['PROJE-AB'], 1, madde: 'MADDE 7/2-b-2'),
            Kalip::veya('Üniversite dışındaki kamu kurumlarınca desteklenen projede görev almak', [
                Kalip::adet('En az 1 projede yürütücü olmak', ['PROJE-KAMU-Y'], 1, madde: 'MADDE 7/2-b-3'),
                Kalip::adet('Ya da en az 2 projede araştırmacı olmak', ['PROJE-KAMU-A'], 2, madde: 'MADDE 7/2-b-3'),
            ]),
            Kalip::veya('Araştırma projesinde görev almak', [
                Kalip::adet('En az 1 araştırma projesinde yürütücü olmak', ['PROJE-Y'], 1, madde: 'MADDE 7/2-b-4'),
                Kalip::adet('Ya da en az 2 araştırma projesinde araştırmacı olmak', ['PROJE-A'], 2, madde: 'MADDE 7/2-b-4'),
            ]),
            Kalip::adet('Üniversite bilimsel araştırma projeleri biriminden desteklenen en az 2 projede yürütücü olmak', ['PROJE-BAP-Y'], 2, madde: 'MADDE 7/2-b-5'),
            $kitapVeyaEditor('MADDE 7/2-b-6', 'ilk'),
            Kalip::adet('SSCI, AHCI, SCI ya da SCI-Expanded kapsamındaki Q1 veya Q2 dergilerde en az 1 araştırma makalesi', ['SCI-Q1Q2'], 1, madde: 'MADDE 7/2-b-7'),
            $tezTamamlama('MADDE 7/2-b-8', null),
            Kalip::ve('Madde 7/2-a\'daki puana ilaveten Tablo 1\'den 10, Tablo 2\'den 10, toplamda 20 puan daha', [
                Kalip::puanDan('Tablo 1 kalemlerinizden en az 10 puan', ['T1'], 10, madde: 'MADDE 7/2-b-9'),
                Kalip::puanDan('Tablo 2 kalemlerinizden en az 10 puan', ['T2'], 10, madde: 'MADDE 7/2-b-9'),
                Kalip::toplam(120, null, $T12, $LISTE12),
            ]),
        ]),
        Kalip::toplam(100, null, $T12, $LISTE12),
    ]),
];

$esikler[] = [
    'anahtar' => 'isparta-ubu-sosyal-docentlik',
    'aday_notu' => 'Sosyal, Beşeri ve İdari Bilimlerle ilgili birimlerde doçent kadrosu için Tablo 1 '
        .'ve Tablo 2\'den toplam en az 100 puan ve yedi ölçütten en az biri isteniyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['sosyal'],
    'cetvel' => $CETVEL,
    'notlar' => 'MADDE 7/1 ve 7/3: doçent unvanı, YDS 65, 2 yıl akademik kadro ya da h-indeksi 8; '
        .'Tablo 1 ve Tablo 2\'den toplam asgari 100 puan; 7/3-b bendindeki şartlardan en az biri.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — Sosyal, Beşeri ve İdari Bilimler', [
        ...$docentOrtak,
        Kalip::kIle('Aşağıdaki ölçütlerden en az 1 tanesini sağlamalısınız', 1, [
            Kalip::adet('AB ya da uluslararası fonlarca desteklenen en az 1 projede yürütücü veya yardımcı araştırmacı olmak', ['PROJE-AB'], 1, madde: 'MADDE 7/3-b-1'),
            Kalip::veya('Üniversite dışındaki kamu kurumlarınca desteklenen projede görev almak', [
                Kalip::adet('En az 1 projede yürütücü olmak', ['PROJE-KAMU-Y'], 1, madde: 'MADDE 7/3-b-2'),
                Kalip::adet('Ya da en az 2 projede araştırmacı olmak', ['PROJE-KAMU-A'], 2, madde: 'MADDE 7/3-b-2'),
            ]),
            Kalip::adet('Üniversite bilimsel araştırma projeleri biriminden desteklenen en az 2 projede yürütücü olmak', ['PROJE-BAP-Y'], 2, madde: 'MADDE 7/3-b-3'),
            Kalip::adet('SSCI, AHCI, SCI ya da SCI-Expanded kapsamındaki dergilerde 1 makalenizin yayımlanmış olması', ['SCI-MAKALE'], 1, madde: 'MADDE 7/3-b-4'),
            $kitapVeyaEditor('MADDE 7/3-b-5', 'tek'),
            $tezTamamlama('MADDE 7/3-b-6', null),
            Kalip::toplam(120, null, $T12, 'Tablo 1 ve Tablo 2 (Madde 7/3-a\'daki puana ilaveten 20 puan)'),
        ]),
        Kalip::toplam(100, null, $T12, $LISTE12),
    ]),
];

$esikler[] = [
    'anahtar' => 'isparta-ubu-gsf-docentlik',
    'aday_notu' => 'Güzel Sanatlar Temel Alanında doçent kadrosu için Tablo 2 ve Tablo 3\'ten toplam '
        .'en az 150 puan isteniyor; yönerge bu kadroda ayrıca ölçüt listesi vermiyor. DİKKAT: '
        .'Tablo 3\'ün portföye bağlı satırları girilemediği için puanınız olduğundan düşük '
        .'görünebilir.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['guzel_sanatlar'],
    'cetvel' => $CETVEL,
    'notlar' => 'MADDE 7/1 ve 7/4: doçent unvanı, YDS 65, 2 yıl akademik kadro ya da h-indeksi 8; '
        .'Tablo 2 ve Tablo 3\'ten toplam en az 150 puan.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — Güzel Sanatlar', [
        ...$docentOrtak,
        Kalip::toplam(150, null, $T23, $LISTE23),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// MADDE 8 — PROFESÖR
// ══════════════════════════════════════════════════════════════════════════

$profesorOrtak = [
    Kalip::yds(65),
    $uakOlcutleri,
    $profesorKidem,
];

$esikler[] = [
    'anahtar' => 'isparta-ubu-fen-muh-profesorluk',
    'aday_notu' => 'Doçent unvanınızı aldığınız tarihten sonraki çalışmalarınız sayılıyor. Fen ve '
        .'Mühendislik Bilimleriyle ilgili birimlerde profesör kadrosu için Tablo 1\'den en az 60 '
        .'puan olmak üzere Tablo 1 ve Tablo 2\'den toplam 120 puan ve sekiz ölçütten en az biri '
        .'isteniyor.'.$UYARI,
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['fen', 'muhendislik'],
    'cetvel' => $CETVEL,
    'notlar' => 'MADDE 8/1 ve 8/2: YDS 65, ÜAK doçentlik müracaat ölçütlerini tekrar sağlamak, '
        .'doçentlik sonrası 3 yıl akademik kadro ya da h-indeksi 12; doçentlik sonrası Tablo 1\'den '
        .'en az 60 puan olmak üzere Tablo 1 ve Tablo 2\'den toplam en az 120 puan; 8/2-b bendindeki '
        .'şartlardan en az biri.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma — Fen ve Mühendislik Bilimleri', [
        ...$profesorOrtak,
        Kalip::puanDan('Doçentlik sonrası Tablo 1 kalemlerinizden en az 60 puan', ['T1'], 60, $DOCENTLIK, madde: 'MADDE 8/2-a'),
        Kalip::kIle('Aşağıdaki ölçütlerden en az 1 tanesini sağlamalısınız', 1, [
            $yurtdisi,
            Kalip::adet('AB ya da uluslararası fonlarca desteklenen en az 1 projede yürütücü veya yardımcı araştırmacı olmak', ['PROJE-AB'], 1, madde: 'MADDE 8/2-b-2'),
            Kalip::veya('Üniversite dışındaki kamu kurumlarınca desteklenen araştırma projesinde görev almak', [
                Kalip::adet('En az 1 projede yürütücü olmak', ['PROJE-KAMU-Y'], 1, madde: 'MADDE 8/2-b-3'),
                Kalip::adet('Ya da en az 2 projede araştırmacı olmak', ['PROJE-KAMU-A'], 2, madde: 'MADDE 8/2-b-3'),
            ]),
            $kitapVeyaEditor('MADDE 8/2-b-4', 'ilk'),
            Kalip::adet('Doçent unvanınızı aldıktan sonra SSCI, AHCI, SCI ya da SCI-Expanded kapsamındaki Q1 veya Q2 dergilerde 1 araştırma makalesi', ['SCI-Q1Q2'], 1, donem: $DOCENTLIK, madde: 'MADDE 8/2-b-5'),
            $tezTamamlama('MADDE 8/2-b-6', $DOCENTLIK),
            Kalip::ve('Madde 8/2-a\'daki puana ilaveten Tablo 1\'den 10, Tablo 2\'den 10, toplamda 20 puan daha', [
                Kalip::puanDan('Doçentlik sonrası Tablo 1 kalemlerinizden en az 10 puan daha (toplam 70)', ['T1'], 70, $DOCENTLIK, madde: 'MADDE 8/2-b-8'),
                Kalip::puanDan('Doçentlik sonrası Tablo 2 kalemlerinizden en az 10 puan', ['T2'], 10, $DOCENTLIK, madde: 'MADDE 8/2-b-8'),
                Kalip::toplam(140, $DOCENTLIK, $T12, $LISTE12),
            ]),
        ]),
        Kalip::toplam(120, $DOCENTLIK, $T12, $LISTE12),
    ]),
];

$esikler[] = [
    'anahtar' => 'isparta-ubu-sosyal-profesorluk',
    'aday_notu' => 'Doçent unvanınızı aldığınız tarihten sonraki çalışmalarınız sayılıyor. Sosyal, '
        .'Beşeri ve İdari Bilimlerle ilgili birimlerde profesör kadrosu için Tablo 1\'den en az 60 '
        .'puan olmak üzere Tablo 1 ve Tablo 2\'den toplam 120 puan ve sekiz ölçütten en az biri '
        .'isteniyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['sosyal'],
    'cetvel' => $CETVEL,
    'notlar' => 'MADDE 8/1 ve 8/3: YDS 65, ÜAK doçentlik müracaat ölçütlerini tekrar sağlamak, '
        .'doçentlik sonrası 3 yıl akademik kadro ya da h-indeksi 12; doçentlik sonrası Tablo 1\'den '
        .'en az 60 puan olmak üzere Tablo 1 ve Tablo 2\'den toplam en az 120 puan; doçentlik sonrası '
        .'8/3-b bendindeki şartlardan en az biri.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma — Sosyal, Beşeri ve İdari Bilimler', [
        ...$profesorOrtak,
        Kalip::puanDan('Doçentlik sonrası Tablo 1 kalemlerinizden en az 60 puan', ['T1'], 60, $DOCENTLIK, madde: 'MADDE 8/3-a'),
        Kalip::kIle('Doçentlik sonrası aşağıdaki ölçütlerden en az 1 tanesini sağlamalısınız', 1, [
            $yurtdisi,
            Kalip::adet('AB ya da uluslararası fonlarca desteklenen en az 1 projede yürütücü veya yardımcı araştırmacı olmak', ['PROJE-AB'], 1, donem: $DOCENTLIK, madde: 'MADDE 8/3-b-2'),
            Kalip::veya('Üniversite dışındaki kamu kurumlarınca desteklenen araştırma projesinde görev almak', [
                Kalip::adet('En az 1 projede yürütücü olmak', ['PROJE-KAMU-Y'], 1, donem: $DOCENTLIK, madde: 'MADDE 8/3-b-3'),
                Kalip::adet('Ya da en az 2 projede araştırmacı olmak', ['PROJE-KAMU-A'], 2, donem: $DOCENTLIK, madde: 'MADDE 8/3-b-3'),
            ]),
            Kalip::adet('Üniversite bilimsel araştırma projeleri biriminden desteklenen en az 2 projede yürütücü olmak', ['PROJE-BAP-Y'], 2, donem: $DOCENTLIK, madde: 'MADDE 8/3-b-4'),
            $kitapVeyaEditor('MADDE 8/3-b-5', 'tek'),
            Kalip::adet('Başlıca yazar olarak SSCI, AHCI, SCI ya da SCI-Expanded kapsamındaki dergilerde 1 makale', ['SCI-MAKALE'], 1, yazar: 'baslica', donem: $DOCENTLIK, madde: 'MADDE 8/3-b-6'),
            $tezTamamlama('MADDE 8/3-b-7', $DOCENTLIK),
            Kalip::toplam(140, $DOCENTLIK, $T12, 'Tablo 1 ve Tablo 2 (Madde 8/3-a\'daki puana ilaveten 20 puan)'),
        ]),
        Kalip::toplam(120, $DOCENTLIK, $T12, $LISTE12),
    ]),
];

$esikler[] = [
    'anahtar' => 'isparta-ubu-gsf-profesorluk',
    'aday_notu' => 'Doçent unvanınızı aldığınız tarihten sonraki çalışmalarınız sayılıyor. Güzel '
        .'Sanatlar Temel Alanında profesör kadrosu için Tablo 3\'ten en az 70 puan olmak üzere '
        .'Tablo 2 ve Tablo 3\'ten toplam 200 puan isteniyor; yönerge bu kadroda ayrıca ölçüt '
        .'listesi vermiyor. DİKKAT: Tablo 3\'ün portföye bağlı satırları girilemediği için '
        .'puanınız olduğundan düşük görünebilir.',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['guzel_sanatlar'],
    'cetvel' => $CETVEL,
    'notlar' => 'MADDE 8/1 ve 8/4: YDS 65, ÜAK doçentlik müracaat ölçütlerini tekrar sağlamak, '
        .'doçentlik sonrası 3 yıl akademik kadro ya da h-indeksi 12; doçentlik sonrası Tablo 3\'ten '
        .'en az 70 puan olmak üzere Tablo 2 ve Tablo 3\'ten toplam en az 200 puan.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma — Güzel Sanatlar', [
        ...$profesorOrtak,
        Kalip::puanDan('Doçentlik sonrası Tablo 3 kalemlerinizden en az 70 puan', ['T3'], 70, $DOCENTLIK, madde: 'MADDE 8/4-a'),
        Kalip::toplam(200, $DOCENTLIK, $T23, $LISTE23),
    ]),
];

return $esikler;
