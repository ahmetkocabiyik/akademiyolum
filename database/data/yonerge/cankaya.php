<?php

/**
 * ÇANKAYA ÜNİVERSİTESİ — Akademik Yükseltilme ve Atanma Kriterleri Yönergesi
 * Kaynak: pdf/17537097862.cankayauniversitesi.pdf (23 sayfa; 10.10.2019
 *         tarihli önceki yönergeyi yürürlükten kaldırıyor, MADDE 41)
 *
 * PUAN TABLOSU YOK, KRİTER SAYIYOR. Çankaya hiçbir kadroda puan istemiyor;
 * her (alan, kadro) için TEMEL KRİTERLERİN TÜMÜ ile ÖZEL KRİTERLERİN EN AZ
 * N'İ birlikte aranıyor (MADDE 12). Cetvel olarak `uak-2024-mart-{alan}`
 * kullanıldı; koşulların andığı kalemleri (SCI/SSCI/AHCI makalesi, Scopus,
 * TR Dizin, kitap, kitap bölümü, proje, patent, editörlük, bildiri, tez
 * danışmanlığı) o cetvel tanımlıyor. `Kalip::toplam` HİÇ KULLANILMADI —
 * yazmak yönergede bulunmayan bir baraj uydurmak olurdu.
 *
 * ÖZEL KRİTERLER `Kalip::kIle` İLE SAYILIYOR. Kaç kriterden kaçının
 * sağlanacağı alana ve kadroya göre değişiyor:
 *   Mühendislik/Fen  15 kriterin 4'ü (üç kadroda da)
 *   Hukuk            13 kriterin 4'ü (profesör, doçent) · 3'ü (Dr. Öğr. Üyesi)
 *   FSBİB            17 kriterin 5'i (profesör) · 15 kriterin 4'ü (doçent, Dr.)
 *   Mimarlık         19 kriterin 5'i (profesör) · 16'nın 4'ü (doçent) ·
 *                    17'nin 4'ü (Dr. Öğr. Üyesi)
 *
 * DÖRT ALAN GRUBU, YÖNERGENİN KENDİ BÖLÜMLERİ:
 *   Mühendislik, Fen Bilimleri ve Matematik (MADDE 13-19) → muhendislik, fen
 *   Hukuk (MADDE 20-26)                                   → hukuk
 *   Filoloji ile Sosyal, Beşeri ve İdari Bilimler (27-33)  → sosyal, filoloji
 *   Mimarlık, Planlama, Tasarım (MADDE 34-40)              → mimarlik
 * SAĞLIK, EĞİTİM, İLAHİYAT, SPOR, ZİRAAT VE GÜZEL SANATLAR HİÇ ANILMIYOR —
 * Çankaya'da o birimler yok; bu alanlar için eşik yazılmadı.
 *
 * FSBİB İÇİNDE İKİNCİ BİR AYRIM VAR: temel kriterler "Filoloji ile Halkla
 * İlişkiler ve Reklamcılık" için ayrı, "bu alanlar dışındakiler" için ayrı
 * yazılmış (11 makale yerine 8, 6 SCI yerine 4 gibi). Filoloji doğrudan
 * hafif kola bağlandı; Halkla İlişkiler ve Reklamcılık sosyal alanın içinde
 * kaldığı için sosyal `birim` ile ikiye ayrıldı.
 *
 * TELAFİ DALLARI `donusumler` İLE MODELLENDİ. Yönerge makale şartını
 * sağlayamayan adaya TÜBİTAK projesi yürütücülüğü, AB projesi yürütücülüğü,
 * tescilli patent ve (bazı alanlarda) kitap ile makale yerine sayma hakkı
 * veriyor; kota da veriyor ("en fazla 2 makale yerine"). Motor bu şekli
 * doğrudan destekliyor. Çankaya Üniversitesi İktisadi İşletmesi üzerinden
 * yürütülen projeler telafi listesinde ama tutar Mütevelli Heyetince her yıl
 * belirlendiği için kayıttan okunamıyor; o kol dışarıda kaldı.
 *
 * "DOÇENTLİK SÖZLÜ SINAV BAŞARI BELGESİ" OLMAYANIN EK ŞARTI GİRİLMEDİ.
 * Yönerge her alanda "sözlü sınav belgesi bulunmayan adaylardan 2 makale
 * daha" istiyor (MADDE 12/6). Adayın sınav durumu profilde yok; §0 uyarınca
 * DÜŞÜK baraj yazıldı — yüksek olanı yazmak sınavı vermiş adaya olmayan bir
 * şart gösterirdi. Aday notunda uyarıldı.
 *
 * "TEZLERDEN ÜRETİLMEMİŞ OLMAK" VE "TEMEL KRİTERLERE EK OLARAK" FİLTRELERİ
 * TAM UYGULANAMIYOR. Özel kriterlerin çoğu "temel kriterlere EK olarak"
 * diyor; bu, sayının kümülatif olduğu anlamına geliyor ve öyle yazıldı
 * (temel 1 + özel 1 = 2). Tezden üretilmiş yayınların dışlanması ise
 * kayıttan okunamıyor; aday tez yayını olarak kaydetmediyse sayılıyor.
 *
 * DR. ÖĞR. ÜYESİ YENİDEN ATANMA GİRİLMEDİ (MADDE 19, 26, 33, 40): atamalar
 * en çok 30 ay için yapılıyor ve koşul "son atama tarihinden sonrası için"
 * ölçülüyor; o tarih profilde yok.
 *
 * YABANCI DİL EŞİĞİ YOK: MADDE 7 dil şartını yükseköğretim mevzuatına
 * devrediyor, sayısal bir puan vermiyor.
 *
 * ÖN DEĞERLENDİRME BAĞLAYICI DEĞİL (MADDE 9/1): "Ön değerlendirmeye göre
 * şartların sağlanmış olması, adaylar için bir hak oluşturmaz."
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: uak-2024-mart-{alan}
 */

use App\Services\Scoring\Sart\Kalip;

$UNI = 'Çankaya Üniversitesi';
$CETVEL = 'uak-2024-mart-{alan}';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;

/** ÜAK cetvelindeki kalem kümeleri. */
$SCI = ['1a-*'];                                  // SSCI, SCI, SCI-Expanded
$SCI_AHCI = ['1a-*', '1b'];                       // + A&HCI
$SCI_SCOPUS = ['1a-*', '1b', '1c'];               // + ESCI/Scopus
$SCOPUS = ['1c'];
$TRDIZIN = ['2a'];
$ALAN_INDEKS = ['1d'];                            // ÜAK "diğer uluslararası alan indeksleri"
$ULUSLARARASI_HAKEMLI = ['1a-*', '1b', '1c', '1d'];
$ULUSLARARASI_VEYA_TRDIZIN = ['1a-*', '1b', '1c', '1d', '2a'];
$ULUSAL_HAKEMLI = ['2a', '2b'];
$KITAP = ['4a', '4c'];
$KITAP_BOLUM = ['4b', '4d'];
$EDITORLUK = ['12a', '12b', '12c'];
$SCI_EDITORLUK = ['12a'];
$PROJE = ['7a-y', '7a-a', '7a-d', '7b', '7c', '7d'];
$PROJE_YURUTUCU = ['7a-y'];
$PATENT = ['10a', '10b', '10c'];
$BILDIRI = ['8a', '8b'];
$TEZ_DOKTORA = ['6a'];
$TEZ_YL = ['6b'];
$TEZ = ['6a', '6b'];

/**
 * Makale şartının telafi dalları (TÜBİTAK/AB projesi yürütücülüğü, patent).
 *
 * @return list<array<string, mixed>>
 */
$telafi = fn (int $azami): array => [
    ['aciklama' => 'TÜBİTAK ya da AB projesi yürütücülüğü 1 makale yerine sayılır',
        'kaynak' => ['7a-y'], 'kaynak_adet' => 1, 'hedef_adet' => 1,
        'azami' => $azami, 'kota_grubu' => 'cankaya-ikame'],
    ['aciklama' => 'Tescilli patent 1 makale yerine sayılır',
        'kaynak' => ['10a', '10b'], 'kaynak_adet' => 1, 'hedef_adet' => 1,
        'azami' => $azami, 'kota_grubu' => 'cankaya-ikame'],
];

$sozluSinavNotu = 'Doçentlik sözlü sınav başarı belgeniz yoksa yönerge her alanda 2 özgün tam '
    .'araştırma makalesi DAHA istiyor. Sınav durumunuz burada tutulmadığı için '
    .'DÜŞÜK baraj gösteriliyor; belgeniz yoksa gerçek şartınız iki makale daha ağır.';

$tezNotu = 'Doçentlik ve profesörlüğün temel makale şartı LİSANSÜSTÜ TEZLERİNİZDEN ÜRETİLMEMİŞ '
    .'yayınları arıyor; bu filtre burada uygulanamıyor. Tezinizden ürettiğiniz yayınları tez '
    .'yayını olarak kaydederseniz ayrım netleşir.';

$telafiNotu = 'Yönerge makale şartını sağlayamayan adaya telafi tanıyor: TÜBİTAK ya da AB '
    .'projesi yürütücülüğü ve tescilli patent, kotası kadar makale yerine sayılabiliyor. '
    .'Sistem bunu otomatik uyguluyor. Çankaya Üniversitesi İktisadi İşletmesi üzerinden '
    .'yürütülen projeler de telafi listesinde ama gereken tutar her yıl Mütevelli Heyetince '
    .'belirlendiği için burada hesaplanamıyor.';

$kriterNotu = 'Çankaya PUAN İSTEMİYOR: her kadro için TEMEL KRİTERLERİN TÜMÜ ile ÖZEL '
    .'KRİTERLERİN EN AZ BELİRLİ SAYIDA olanı birlikte aranıyor. Ön değerlendirmede koşulları '
    .'sağlamış olmak yönergenin kendi ifadesiyle "adaylar için bir hak oluşturmaz".';

$yenidenAtanma = 'Doktor öğretim üyeliği atamaları en çok 30 ay için yapılıyor ve yeniden '
    .'atanmada temel makale şartı son atama tarihinden sonrası için yeniden isteniyor; o tarih '
    .'burada tutulmadığı için yeniden atanma eşiği girilmedi.';

$doktorBeyani = Kalip::beyan('İlgili alanda doktor unvanına sahip olmak', 'Temel kriter 1');
$docentBeyani = Kalip::beyan('Kadronun ilan edildiği alanda doçent unvanına sahip olmak ve ÜAK '
    .'Başkanlığınca belirlenecek jüri tarafından yapılacak sözlü sınavda başarılı olmak',
    'Temel kriter 1');
$alanBeyani = Kalip::beyan('Yalnızca doçent unvanını aldığınız bilim alanından başvurmak',
    'Temel kriter 2');
$kidemBeyani = Kalip::beyan('Doçent unvanını aldıktan sonra alanınızla ilgili en az 5 yıl '
    .'çalışmış olmak; bu sürenin en az 3 yılında yükseköğretim kurumlarında tam zamanlı görev '
    .'yapmış ve ders vermiş olmak', 'Temel kriter 1');
$dersBeyani = fn (int $yil, string $madde) => Kalip::beyan(
    "Alanınızla ilgili yükseköğretim kurumlarında en az {$yil} yıl tam zamanlı ders vermiş olmak",
    $madde);

/** Birçok alanda tekrar eden özel kriterler. */
$ok = [
    'ders' => Kalip::beyan('Alanınızla ilgili yükseköğretim kurumlarında en az 1 yıl tam zamanlı '
        .'teorik ders vermiş olmak (yurt dışı dâhil)', 'Özel kriter'),
    'hindeks' => fn (int $n) => Kalip::beyan("Web of Science h-indeksinizin en az {$n} olması",
        'Özel kriter'),
    'atifBeyan' => fn (string $metin) => Kalip::beyan($metin, 'Özel kriter'),
    'davetli' => Kalip::beyan('Bilimsel toplantılara davetli konuşmacı ya da panelist olarak '
        .'katılmış olmak', 'Özel kriter'),
    'konukEditor' => Kalip::beyan('Alan indeksleri tarafından taranan bir derginin özel '
        .'sayısında konuk editör olarak yer almak', 'Özel kriter'),
    'hakemlik' => fn (int $n) => Kalip::beyan(
        $n > 1
            ? "Ulusal ya da uluslararası dergilerde en az {$n} kez hakemlik yapmak"
            : 'Ulusal ya da uluslararası dergilerde hakemlik yapmak', 'Özel kriter'),
    'ceviri' => Kalip::beyan('Başvurduğunuz alanla ilgili bir kitap çevirisi yapmış olmak '
        .'(ikiden fazla kişiyle yapılan çeviriler sayılmaz)', 'Özel kriter'),
    'kurul' => Kalip::beyan('Ulusal ya da uluslararası bir bilimsel toplantının düzenleme '
        .'kurulunda veya bilim kurulunda yer almak', 'Özel kriter'),
    'etkinlik' => fn (int $n) => Kalip::beyan(
        "Alanınızla ilgili en az {$n} kez kişisel etkinlik ya da karma ortak etkinlik yapmış olmak",
        'Özel kriter'),
    'yarismaOdulu' => Kalip::beyan('Bir ulusal ya da uluslararası proje yarışmasında ödül almış '
        .'olmak', 'Özel kriter'),
    'atolyeYayini' => Kalip::beyan('Öğretim üyesi olarak bir tasarım veya planlama '
        .'atölyesindeki faaliyetlerinizin ürünlerini makale düzeyinde yayımlamış olmak',
        'Özel kriter'),
    'atolyeDuzenleme' => Kalip::beyan('Eğitime yönelik, üniversite dışında ulusal ya da '
        .'uluslararası bir atölye veya yaz okulu benzeri çalışma düzenlemiş olmak', 'Özel kriter'),
];

$tezKriteri = fn (?array $donem) => Kalip::veya('Lisansüstü tez danışmanlığı', [
    Kalip::adet('Tamamlanmış en az 1 doktora tez danışmanlığı', ['6a'], 1, donem: $donem,
        madde: 'Özel kriter 1'),
    Kalip::adet('Tamamlanmış en az 2 yüksek lisans tez danışmanlığı', ['6b'], 2, donem: $donem,
        madde: 'Özel kriter 1'),
]);

$tezKriteriTek = fn (?array $donem) => Kalip::adet(
    'Tamamlanmış en az 1 lisansüstü tez danışmanlığı', ['6a', '6b'], 1, donem: $donem,
    madde: 'Özel kriter 1');

/**
 * FSBİB doçentlik özel kriterleri (MADDE 30). Üç birim varyantı da aynı listeyi
 * kullanıyor; "temel kriterlere ek olarak" sayıları GENEL (ağır) kolun temeline
 * göre kümülatif yazıldı — Halkla İlişkiler ve Filoloji adayı için bu §0 yönünde
 * bir sıkılaştırma.
 *
 * @var list<array<string, mixed>>
 */
$fsbibDocentOzel = [
    $tezKriteriTek($DOKTORA),
    Kalip::adet('SSCI, SCI, SCI-Expanded ya da A&HCI dergilerde toplam en az 4 makale',
        $SCI_AHCI, 4, donem: $DOKTORA, madde: 'Madde 30/2'),
    Kalip::adet('Scopus ya da ESCI dergilerde 2 özgün tam araştırma makalesi', $SCOPUS, 2,
        donem: $DOKTORA, madde: 'Madde 30/3'),
    Kalip::adet('TR Dizin dergilerinde 2 özgün tam araştırma makalesi', $TRDIZIN, 2,
        donem: $DOKTORA, madde: 'Madde 30/4'),
    Kalip::adet('Ulusal ya da uluslararası kitap yazmış olmak', $KITAP, 1, donem: $DOKTORA,
        madde: 'Madde 30/5'),
    Kalip::adet('Ulusal ya da uluslararası kitap bölümü yazmış olmak', $KITAP_BOLUM, 1,
        donem: $DOKTORA, madde: 'Madde 30/6'),
    $ok['atifBeyan']('SSCI, SCI, SCI-Expanded, A&HCI ya da Scopus dergilerinde bir makalenize '
        .'en az 6 atıf yapılmış olmak (kendi atıflarınız sayılmaz)'),
    Kalip::adet('Ulusal ya da uluslararası kitap editörlüğü veya endeksli dergi editörlüğü',
        $EDITORLUK, 1, madde: 'Madde 30/8'),
    $ok['davetli'],
    $ok['ceviri'],
    $ok['hakemlik'](2),
    Kalip::adet('Ulusal ya da uluslararası bir projede yürütücülük yapmış ve başarıyla '
        .'tamamlamış olmak', $PROJE_YURUTUCU, 1, madde: 'Madde 30/12'),
    Kalip::adet('Ulusal ya da uluslararası 2 projede araştırmacı olarak görev yapmış olmak',
        ['7a-a', '7a-d', '7b', '7c', '7d'], 2, madde: 'Madde 30/13'),
    $ok['hindeks'](3),
    Kalip::adet('Uluslararası konferans, kongre ya da sempozyumda kabul edilmiş ve sunulmuş en '
        .'az 2 bildiri', $BILDIRI, 2, donem: $DOKTORA, madde: 'Madde 30/15'),
];

/**
 * FSBİB profesörlük özel kriterleri (MADDE 28); on yedi kriter.
 *
 * @var list<array<string, mixed>>
 */
$fsbibProfOzel = [
    $tezKriteri($DOCENTLIK),
    Kalip::adet('SSCI, SCI, SCI-Expanded ya da A&HCI dergilerde toplam en az 7 makale',
        $SCI_AHCI, 7, madde: 'Madde 28/2'),
    Kalip::adet('Scopus ya da ESCI dergilerde en az 2 özgün tam araştırma makalesi', $SCOPUS, 2,
        donem: $DOCENTLIK, madde: 'Madde 28/3'),
    Kalip::adet('TR Dizin dergilerinde 2 özgün tam araştırma makalesi', $TRDIZIN, 2,
        donem: $DOCENTLIK, madde: 'Madde 28/4'),
    Kalip::adet('Ulusal ya da uluslararası kitap yazmış olmak', $KITAP, 1, donem: $DOCENTLIK,
        madde: 'Madde 28/5'),
    Kalip::adet('Ulusal ya da uluslararası kitap bölümü yazmış olmak', $KITAP_BOLUM, 1,
        donem: $DOCENTLIK, madde: 'Madde 28/6'),
    $ok['atifBeyan']('SSCI, SCI, SCI-Expanded, A&HCI ya da Scopus dergilerinde en az bir '
        .'makalenize en az 9 atıf yapılmış olmak (kendi atıflarınız sayılmaz)'),
    Kalip::adet('Ulusal ya da uluslararası kitap editörlüğü veya endeksli dergi editörlüğü',
        $EDITORLUK, 1, madde: 'Madde 28/8'),
    Kalip::adet('Alan indeksleri tarafından taranan bir derginin editör listesinde yer almak',
        $EDITORLUK, 1, madde: 'Madde 28/9'),
    $ok['konukEditor'],
    $ok['davetli'],
    $ok['ceviri'],
    $ok['hakemlik'](3),
    Kalip::adet('Ulusal ya da uluslararası bir projede yürütücülük yapmış ve başarıyla '
        .'tamamlamış olmak', $PROJE_YURUTUCU, 1, donem: $DOCENTLIK, madde: 'Madde 28/14'),
    Kalip::adet('Ulusal ya da uluslararası 2 projede araştırmacı olarak görev yapmış olmak',
        ['7a-a', '7a-d', '7b', '7c', '7d'], 2, madde: 'Madde 28/15'),
    $ok['hindeks'](4),
    Kalip::adet('Uluslararası konferans, kongre ya da sempozyumda kabul edilmiş ve sunulmuş en '
        .'az 2 bildiri', $BILDIRI, 2, donem: $DOCENTLIK, madde: 'Madde 28/17'),
];

/**
 * @param  list<string>  $alanlar
 * @param  list<array<string, mixed>>  $temel
 * @param  list<array<string, mixed>>  $ozel
 * @return array<string, mixed>
 */
$esik = function (string $anahtar, string $kadro, string $kadroAd, array $alanlar, int $k,
    array $temel, array $ozel, string $notlar, string $adayNotu, ?string $birim = null) use ($UNI, $CETVEL): array {
    $kayit = [
        'anahtar' => "cankaya-{$anahtar}",
        'aday_notu' => $adayNotu,
        'universite' => $UNI,
        'kadro' => $kadro,
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => $notlar,
        'sart' => Kalip::ve($kadroAd, [
            Kalip::ve('Temel kriterlerin tümü', array_values($temel)),
            Kalip::kIle("Özel kriterlerden en az {$k} tanesini sağlamak", $k, array_values($ozel)),
        ]),
    ];

    if ($birim !== null) {
        $kayit['birim'] = $birim;
    }

    return $kayit;
};

$MUH = ['muhendislik', 'fen'];

$drNotu = $kriterNotu.' '.$yenidenAtanma;
$ustNotu = $kriterNotu.' '.$sozluSinavNotu.' '.$tezNotu.' '.$telafiNotu;

return [
    // ══════════════ MÜHENDİSLİK, FEN BİLİMLERİ VE MATEMATİK ══════════════
    $esik('muh-dr', 'dr_ogr_uyesi', 'Dr. Öğr. Üyesi', $MUH, 4, [
        $doktorBeyani,
        Kalip::adet('SSCI, SCI ya da SCI-Expanded dergilerde ilk yazar olduğunuz en az 1 özgün '
            .'tam araştırma makalesi', $SCI, 1, yazar: 'ilk', madde: 'Madde 17/2'),
    ], [
        $ok['ders'],
        Kalip::adet('SSCI, SCI, SCI-Expanded ya da Scopus dergilerde toplam en az 2 makale',
            $SCI_SCOPUS, 2, madde: 'Madde 18/2'),
        Kalip::adet('TR Dizin dergilerinde en az 2 özgün tam araştırma makalesi', $TRDIZIN, 2,
            madde: 'Madde 18/3'),
        Kalip::adet('Alanınızla ilgili ulusal ya da uluslararası kitap yazmış olmak', $KITAP, 1,
            madde: 'Madde 18/4'),
        Kalip::adet('Alanınızla ilgili ulusal ya da uluslararası kitap bölümü yazmış olmak',
            $KITAP_BOLUM, 1, madde: 'Madde 18/5'),
        $ok['atifBeyan']('Herhangi bir makalenize SSCI, SCI, SCI-Expanded ya da Scopus '
            .'dergilerinde en az 4 atıf almış olmak (kendi atıflarınız sayılmaz)'),
        Kalip::adet('Ulusal ya da uluslararası kitap editörlüğü veya endeksli dergi editörlüğü',
            $EDITORLUK, 1, madde: 'Madde 18/7'),
        Kalip::adet('SSCI, SCI, SCI-Expanded ya da Scopus dergisinin editör listesinde yer almak',
            $SCI_EDITORLUK, 1, madde: 'Madde 18/8'),
        $ok['konukEditor'],
        $ok['davetli'],
        Kalip::adet('Ulusal ya da uluslararası projede yönetici, danışman, uzman veya '
            .'araştırmacı olarak görev yapmış ve başarıyla tamamlamış olmak', $PROJE, 1,
            madde: 'Madde 18/11'),
        Kalip::adet('Tescilli ulusal incelemeli patent, Avrupa patenti, diğer uluslararası '
            .'patent ya da endüstriyel tasarım', $PATENT, 1, madde: 'Madde 18/12'),
        $ok['hakemlik'](1),
        $tezKriteriTek(null),
        Kalip::adet('Uluslararası konferans, kongre ya da sempozyumda kabul edilmiş ve sunulmuş '
            .'en az 1 bildiri', $BILDIRI, 1, madde: 'Madde 18/15'),
    ],
        'MADDE 17-18: temel kriterlerin tümü (doktor unvanı + ilk yazar olduğu 1 SCI makalesi) '
        .'ve on beş özel kriterin en az dördü.',
        $drNotu),

    $esik('muh-docentlik', 'docentlik', 'Doçent', $MUH, 4, [
        $docentBeyani,
        $dersBeyani(1, 'Madde 15/2'),
        Kalip::adet('Doktora sonrasında SSCI, SCI ya da SCI-Expanded dergilerde 4 özgün tam '
            .'araştırma makalesi', $SCI, 4, donem: $DOKTORA, madde: 'Madde 15/3')
            + ['donusumler' => $telafi(2)],
        Kalip::adet('Bu makalelerin en az birinde ilk yazar olmak', $SCI, 1, yazar: 'ilk',
            donem: $DOKTORA, madde: 'Madde 15/3'),
    ], [
        $tezKriteriTek($DOKTORA),
        Kalip::adet('SSCI, SCI, SCI-Expanded ya da Scopus dergilerde toplam en az 5 makale',
            $SCI_SCOPUS, 5, donem: $DOKTORA, madde: 'Madde 16/2'),
        Kalip::adet('TR Dizin dergilerinde en az 2 özgün tam araştırma makalesi', $TRDIZIN, 2,
            donem: $DOKTORA, madde: 'Madde 16/3'),
        Kalip::adet('Ulusal ya da uluslararası kitap yazmış olmak', $KITAP, 1, donem: $DOKTORA,
            madde: 'Madde 16/4'),
        Kalip::adet('Ulusal ya da uluslararası kitap bölümü yazmış olmak', $KITAP_BOLUM, 1,
            donem: $DOKTORA, madde: 'Madde 16/5'),
        $ok['atifBeyan']('En az 3 yayınınızın her birine en az 3 atıf almış olmak ya da '
            .'h-indeksinizin en az 3 olması (kendi atıflarınız sayılmaz)'),
        $ok['atifBeyan']('Yukarıda sayılanlar dışında kalan bir makalenize SSCI, SCI, '
            .'SCI-Expanded ya da Scopus dergilerinde en az 6 atıf almış olmak'),
        Kalip::adet('Ulusal ya da uluslararası kitap editörlüğü veya endeksli dergi editörlüğü',
            $EDITORLUK, 1, madde: 'Madde 16/8'),
        Kalip::adet('SSCI, SCI, SCI-Expanded ya da Scopus dergisinin editör listesinde yer almak',
            $SCI_EDITORLUK, 1, madde: 'Madde 16/9'),
        $ok['konukEditor'],
        $ok['davetli'],
        Kalip::adet('Ulusal ya da uluslararası projede yönetici, danışman, uzman veya '
            .'araştırmacı olarak görev yapmış ve başarıyla tamamlamış olmak', $PROJE, 1,
            donem: $DOKTORA, madde: 'Madde 16/12'),
        Kalip::adet('Tescilli patent ya da endüstriyel tasarım', $PATENT, 1, donem: $DOKTORA,
            madde: 'Madde 16/13'),
        $ok['hakemlik'](2),
        Kalip::adet('Uluslararası konferans, kongre ya da sempozyumda kabul edilmiş ve sunulmuş '
            .'en az 2 bildiri', $BILDIRI, 2, donem: $DOKTORA, madde: 'Madde 16/15'),
    ],
        'MADDE 15-16: temel kriterler (doçent unvanı, 1 yıl ders, doktora sonrası 4 SCI '
        .'makalesi, en az birinde ilk yazar) ve on beş özel kriterin en az dördü.',
        $ustNotu),

    $esik('muh-profesorluk', 'profesorluk', 'Profesör', $MUH, 4, [
        $kidemBeyani,
        $alanBeyani,
        Kalip::adet('SSCI, SCI ya da SCI-Expanded dergilerde en az 8 araştırma makalesi',
            $SCI, 8, madde: 'Madde 13/3') + ['donusumler' => $telafi(2)],
        Kalip::adet('Bu makalelerden en az 4\'ü doçentliğinizden sonra', $SCI, 4,
            donem: $DOCENTLIK, madde: 'Madde 13/3'),
        Kalip::adet('Doçentliğinizden sonraki makalelerin en az birinde başlıca yazar olmak',
            $SCI, 1, yazar: 'baslica', donem: $DOCENTLIK, madde: 'Madde 13/3'),
    ], [
        $tezKriteri($DOCENTLIK),
        Kalip::adet('SSCI, SCI, SCI-Expanded ya da Scopus dergilerde toplam en az 9 makale',
            $SCI_SCOPUS, 9, madde: 'Madde 14/2'),
        Kalip::adet('TR Dizin dergilerinde en az 2 özgün tam araştırma makalesi', $TRDIZIN, 2,
            donem: $DOCENTLIK, madde: 'Madde 14/3'),
        Kalip::adet('Alanınızla ilgili ulusal ya da uluslararası kitap yazmış olmak', $KITAP, 1,
            donem: $DOCENTLIK, madde: 'Madde 14/4'),
        Kalip::adet('Alanınızla ilgili ulusal ya da uluslararası kitap bölümü yazmış olmak',
            $KITAP_BOLUM, 1, donem: $DOCENTLIK, madde: 'Madde 14/5'),
        $ok['atifBeyan']('En az 5 yayınınızın her birine en az 5 atıf almış olmak ya da '
            .'h-indeksinizin en az 5 olması (kendi atıflarınız sayılmaz)'),
        $ok['atifBeyan']('Yukarıda sayılanlar dışında kalan bir makalenize SSCI, SCI, '
            .'SCI-Expanded ya da Scopus dergilerinde en az 10 atıf almış olmak'),
        Kalip::adet('Ulusal ya da uluslararası kitap editörlüğü veya endeksli dergi editörlüğü',
            $EDITORLUK, 1, madde: 'Madde 14/8'),
        Kalip::adet('SSCI, SCI, SCI-Expanded ya da Scopus dergisinin editör listesinde yer almak',
            $SCI_EDITORLUK, 1, madde: 'Madde 14/9'),
        $ok['konukEditor'],
        $ok['davetli'],
        Kalip::adet('Ulusal ya da uluslararası projede yönetici, danışman, uzman veya '
            .'araştırmacı olarak görev yapmış ve başarıyla tamamlamış olmak', $PROJE, 1,
            donem: $DOCENTLIK, madde: 'Madde 14/12'),
        Kalip::adet('Tescilli patent ya da endüstriyel tasarım', $PATENT, 1, donem: $DOCENTLIK,
            madde: 'Madde 14/13'),
        $ok['hakemlik'](3),
        Kalip::adet('Uluslararası konferans, kongre ya da sempozyumda kabul edilmiş ve sunulmuş '
            .'en az 2 bildiri', $BILDIRI, 2, donem: $DOCENTLIK, madde: 'Madde 14/15'),
    ],
        'MADDE 13-14: temel kriterler (5 yıl kıdem, 8 SCI makalesi — en az 4\'ü doçentlik '
        .'sonrası, birinde başlıca yazar) ve on beş özel kriterin en az dördü.',
        $ustNotu),

    // ══════════════════════════════ HUKUK ══════════════════════════════
    $esik('hukuk-dr', 'dr_ogr_uyesi', 'Dr. Öğr. Üyesi', ['hukuk'], 3, [
        $doktorBeyani,
        Kalip::adet('Uluslararası indekslerde ya da TR Dizin dergilerinde tek yazar olarak 3 '
            .'özgün tam makale', $ULUSLARARASI_VEYA_TRDIZIN, 3, yazar: 'tek', madde: 'Madde 24/2'),
    ], [
        $ok['ders'],
        Kalip::adet('Uluslararası hakemli dergilerde en az 1 özgün tam araştırma makalesi daha',
            $ULUSLARARASI_HAKEMLI, 4, madde: 'Madde 25/2'),
        Kalip::adet('TR Dizin dergilerinde 2 özgün tam araştırma makalesi', $TRDIZIN, 2,
            madde: 'Madde 25/3'),
        Kalip::adet('Alanınızda ulusal ya da uluslararası yayınevince yayımlanan bilimsel kitap',
            $KITAP, 1, madde: 'Madde 25/4'),
        Kalip::adet('Alanınızda ulusal ya da uluslararası yayınevince yayımlanan bilimsel '
            .'kitapta bölüm yazarlığı', $KITAP_BOLUM, 1, madde: 'Madde 25/5'),
        Kalip::adet('Bilimsel kitapta editörlük ya da yayın kurulunda görev', $EDITORLUK, 1,
            madde: 'Madde 25/6'),
        Kalip::adet('Ulusal ya da uluslararası indekslerde taranan bir dergide editörlük',
            $EDITORLUK, 1, madde: 'Madde 25/7'),
        $ok['kurul'],
        Kalip::adet('Ulusal ya da uluslararası projede yönetici, danışman, uzman veya '
            .'araştırmacı olarak görev yapmış olmak', $PROJE, 1, madde: 'Madde 25/9'),
        $ok['atifBeyan']('Bir yayınınıza en az 6 atıf almak (kendi atıflarınız sayılmaz)'),
        $ok['hakemlik'](1),
        $ok['davetli'],
        Kalip::adet('Ulusal ya da uluslararası konferans, kongre veya sempozyumda kabul edilmiş '
            .'ve sunulmuş en az 1 bildiri', $BILDIRI, 1, madde: 'Madde 25/13'),
    ],
        'MADDE 24-25: temel kriterler (doktor unvanı + tek yazarlı 3 makale) ve on üç özel '
        .'kriterin en az üçü.',
        $drNotu),

    $esik('hukuk-docentlik', 'docentlik', 'Doçent', ['hukuk'], 4, [
        $docentBeyani,
        $dersBeyani(2, 'Madde 22/2'),
        Kalip::adet('Doktora sonrasında uluslararası indekslerde ya da TR Dizin dergilerinde '
            .'toplam 7 özgün tam araştırma makalesi', $ULUSLARARASI_VEYA_TRDIZIN, 7,
            donem: $DOKTORA, madde: 'Madde 22/3'),
        Kalip::adet('Bu makalelerin en az üçünde tek yazar olmak', $ULUSLARARASI_VEYA_TRDIZIN, 3,
            yazar: 'tek', donem: $DOKTORA, madde: 'Madde 22/3'),
        Kalip::adet('İlgili alanda tek yazar olarak 1 kitap yayımlamış olmak', $KITAP, 1,
            yazar: 'tek', donem: $DOKTORA, madde: 'Madde 22/3'),
    ], [
        $tezKriteriTek($DOKTORA),
        Kalip::adet('Uluslararası hakemli dergilerde 1 özgün tam araştırma makalesi daha',
            $ULUSLARARASI_HAKEMLI, 8, donem: $DOKTORA, madde: 'Madde 23/2'),
        Kalip::adet('Ulusal hakemli dergi ya da TR Dizin dergilerinde 2 özgün tam araştırma '
            .'makalesi', $ULUSAL_HAKEMLI, 2, donem: $DOKTORA, madde: 'Madde 23/3'),
        Kalip::adet('Alanınızda ulusal ya da uluslararası yayınevince yayımlanan bilimsel kitap',
            $KITAP, 2, donem: $DOKTORA, madde: 'Madde 23/4'),
        Kalip::adet('Alanınızda ulusal ya da uluslararası yayınevince yayımlanan bilimsel '
            .'kitapta bölüm yazarlığı', $KITAP_BOLUM, 1, donem: $DOKTORA, madde: 'Madde 23/5'),
        Kalip::adet('Bilimsel kitapta editörlük ya da yayın kurulunda görev', $EDITORLUK, 1,
            madde: 'Madde 23/6'),
        Kalip::adet('Ulusal ya da uluslararası indekslerde taranan bir dergide editörlük',
            $EDITORLUK, 1, madde: 'Madde 23/7'),
        $ok['kurul'],
        Kalip::adet('Ulusal ya da uluslararası projede yönetici, danışman, uzman veya '
            .'araştırmacı olarak görev yapmış olmak', $PROJE, 1, madde: 'Madde 23/9'),
        $ok['atifBeyan']('Uluslararası indekslerde ya da TR Dizin yayınlarında bir eserinize en '
            .'az 6 atıf almak (kendi atıflarınız sayılmaz)'),
        $ok['hakemlik'](2),
        $ok['davetli'],
        Kalip::adet('Ulusal ya da uluslararası konferans, kongre veya sempozyumda kabul edilmiş '
            .'ve sunulmuş en az 2 bildiri', $BILDIRI, 2, madde: 'Madde 23/13'),
    ],
        'MADDE 22-23: temel kriterler (doçent unvanı, 2 yıl ders, doktora sonrası 7 makale — '
        .'üçünde tek yazar — ve tek yazarlı 1 kitap) ve on üç özel kriterin en az dördü.',
        $ustNotu),

    $esik('hukuk-profesorluk', 'profesorluk', 'Profesör', ['hukuk'], 4, [
        $kidemBeyani,
        $alanBeyani,
        Kalip::adet('Doçentliğinizden sonra uluslararası indekslerde ya da TR Dizin dergilerinde '
            .'en az 12 makale', $ULUSLARARASI_VEYA_TRDIZIN, 12, donem: $DOCENTLIK,
            madde: 'Madde 20/3'),
        Kalip::adet('Bu makalelerin en az dördünde tek yazar olmak', $ULUSLARARASI_VEYA_TRDIZIN,
            4, yazar: 'tek', donem: $DOCENTLIK, madde: 'Madde 20/3'),
        Kalip::adet('Doçentliğinizden sonra tek yazar olarak 1 kitap yayımlamış olmak', $KITAP, 1,
            yazar: 'tek', donem: $DOCENTLIK, madde: 'Madde 20/3'),
    ], [
        $tezKriteri($DOCENTLIK),
        Kalip::adet('Uluslararası hakemli dergilerde 1 özgün makale daha', $ULUSLARARASI_HAKEMLI,
            13, donem: $DOCENTLIK, madde: 'Madde 21/2'),
        Kalip::adet('Ulusal hakemli dergi ya da TR Dizin dergilerinde 2 özgün makale',
            $ULUSAL_HAKEMLI, 2, donem: $DOCENTLIK, madde: 'Madde 21/3'),
        Kalip::adet('Alanınızda ulusal ya da uluslararası yayınevince yayımlanan bilimsel kitap',
            $KITAP, 2, donem: $DOCENTLIK, madde: 'Madde 21/4'),
        Kalip::adet('Alanınızda ulusal ya da uluslararası yayınevince yayımlanan bilimsel '
            .'kitapta bölüm yazarlığı', $KITAP_BOLUM, 1, donem: $DOCENTLIK, madde: 'Madde 21/5'),
        Kalip::adet('Bilimsel kitapta editörlük ya da yayın kurulunda görev', $EDITORLUK, 1,
            madde: 'Madde 21/6'),
        Kalip::adet('Ulusal ya da uluslararası alan indekslerinde taranan bir dergide editörlük',
            $EDITORLUK, 1, madde: 'Madde 21/7'),
        $ok['davetli'],
        $ok['kurul'],
        Kalip::adet('Ulusal ya da uluslararası projede yönetici, danışman, uzman veya '
            .'araştırmacı olarak görev yapmış olmak', $PROJE, 1, madde: 'Madde 21/10'),
        $ok['atifBeyan']('Uluslararası indekslerde ya da TR Dizin yayınlarında bir eserinize en '
            .'az 6 atıf almak (kendi atıflarınız sayılmaz)'),
        $ok['hakemlik'](3),
        Kalip::adet('Ulusal ya da uluslararası konferans, kongre veya sempozyumda kabul edilmiş '
            .'ve sunulmuş en az 2 bildiri', $BILDIRI, 2, madde: 'Madde 21/13'),
    ],
        'MADDE 20-21: temel kriterler (5 yıl kıdem, doçentlik sonrası 12 makale — dördünde tek '
        .'yazar — ve tek yazarlı 1 kitap) ve on üç özel kriterin en az dördü.',
        $ustNotu),

    // ═══════ FİLOLOJİ İLE SOSYAL, BEŞERİ VE İDARİ BİLİMLER (FSBİB) ═══════
    $esik('fsbib-dr', 'dr_ogr_uyesi', 'Dr. Öğr. Üyesi', ['sosyal', 'filoloji'], 4, [
        $doktorBeyani,
        Kalip::veya('Temel makale şartı', [
            Kalip::adet('SSCI, SCI, SCI-Expanded ya da A&HCI dergilerde 1 özgün tam araştırma '
                .'makalesi', $SCI_AHCI, 1, madde: 'Madde 31/2-a'),
            Kalip::ve('Scopus kolu', [
                Kalip::adet('Scopus dergilerde 2 özgün tam araştırma makalesi', $SCOPUS, 2,
                    madde: 'Madde 31/2-b'),
                Kalip::adet('Bu makalelerin en az birinde ilk yazar olmak', $SCOPUS, 1,
                    yazar: 'ilk', madde: 'Madde 31/2-b'),
            ]),
        ]),
    ], [
        $ok['ders'],
        Kalip::adet('SSCI, SCI, SCI-Expanded ya da A&HCI dergilerde toplam en az 2 makale',
            $SCI_AHCI, 2, madde: 'Madde 32/2'),
        Kalip::adet('Scopus ya da ESCI dergilerde 2 özgün tam araştırma makalesi', $SCOPUS, 2,
            madde: 'Madde 32/3'),
        Kalip::adet('TR Dizin dergilerinde 2 özgün tam araştırma makalesi', $TRDIZIN, 2,
            madde: 'Madde 32/4'),
        Kalip::adet('Alanınızla ilgili ulusal ya da uluslararası kitap yazmış olmak', $KITAP, 1,
            madde: 'Madde 32/5'),
        Kalip::adet('Alanınızla ilgili ulusal ya da uluslararası kitap bölümü yazmış olmak',
            $KITAP_BOLUM, 1, madde: 'Madde 32/6'),
        $ok['atifBeyan']('Herhangi bir makalenize SSCI, SCI, SCI-Expanded ya da Scopus '
            .'dergilerinde en az 4 atıf almış olmak (kendi atıflarınız sayılmaz)'),
        Kalip::adet('Ulusal ya da uluslararası kitap editörlüğü veya endeksli dergi editörlüğü',
            $EDITORLUK, 1, madde: 'Madde 32/8'),
        $ok['davetli'],
        Kalip::adet('Ulusal ya da uluslararası projede yürütücü veya araştırmacı olarak görev '
            .'yapmış ve başarıyla tamamlamış olmak', $PROJE, 1, madde: 'Madde 32/10'),
        $ok['ceviri'],
        $ok['hakemlik'](1),
        $tezKriteriTek(null),
        $ok['hindeks'](2),
        Kalip::adet('Uluslararası konferans, kongre ya da sempozyumda kabul edilmiş ve sunulmuş '
            .'en az 1 bildiri', $BILDIRI, 1, madde: 'Madde 32/15'),
    ],
        'MADDE 31-32: temel kriterler (doktor unvanı + 1 SCI/A&HCI makalesi ya da ilk yazar '
        .'olunan 2 Scopus makalesi) ve on beş özel kriterin en az dördü.',
        $drNotu),

    $esik('fsbib-docentlik', 'docentlik', 'Doçent', ['sosyal'], 4, [
        $docentBeyani,
        $dersBeyani(1, 'Madde 29/2'),
        Kalip::adet('Doktora sonrasında uluslararası indekslerce taranan hakemli dergilerde en '
            .'az 5 özgün tam araştırma makalesi', $ULUSLARARASI_HAKEMLI, 5, donem: $DOKTORA,
            madde: 'Madde 29/3') + ['donusumler' => $telafi(1)],
        Kalip::adet('Bu yayınlardan en az 3\'ü SSCI, SCI, SCI-Expanded ya da A&HCI dergilerinde',
            $SCI_AHCI, 3, donem: $DOKTORA, madde: 'Madde 29/3'),
        Kalip::adet('Bu makalelerin en az birinde ilk yazar olmak', $SCI_AHCI, 1, yazar: 'ilk',
            donem: $DOKTORA, madde: 'Madde 29/3'),
    ], $fsbibDocentOzel,
        'MADDE 29-30: temel kriterler (doçent unvanı, 1 yıl ders, doktora sonrası 5 uluslararası '
        .'indeksli makale — en az 3\'ü SCI/A&HCI, birinde ilk yazar) ve on beş özel kriterin en '
        .'az dördü.',
        $ustNotu, 'Halkla İlişkiler ve Reklamcılık dışındaki bölümler'),

    $esik('fsbib-docentlik-hir', 'docentlik', 'Doçent', ['sosyal'], 4, [
        $docentBeyani,
        $dersBeyani(1, 'Madde 29/2'),
        Kalip::adet('Doktora sonrasında uluslararası hakemli dergilerde en az 4 özgün tam '
            .'araştırma makalesi', $ULUSLARARASI_HAKEMLI, 4, donem: $DOKTORA,
            madde: 'Madde 29/4') + ['donusumler' => $telafi(1)],
        Kalip::adet('Bu yayınlardan 2\'si SSCI, SCI, SCI-Expanded ya da A&HCI dergilerinde',
            $SCI_AHCI, 2, donem: $DOKTORA, madde: 'Madde 29/4'),
        Kalip::adet('Bu makalelerin en az birinde ilk yazar olmak', $SCI_AHCI, 1, yazar: 'ilk',
            donem: $DOKTORA, madde: 'Madde 29/4'),
    ], $fsbibDocentOzel,
        'MADDE 29/4: Halkla İlişkiler ve Reklamcılık için temel makale şartı hafifliyor — 5 '
        .'yerine 4 makale, 3 yerine 2 SCI/A&HCI. Özel kriterler aynı.',
        'Halkla İlişkiler ve Reklamcılık bölümlerinde temel makale şartı öteki sosyal '
        .'bölümlerden daha hafif (5 yerine 4 makale). '.$ustNotu,
        'Halkla İlişkiler ve Reklamcılık'),

    $esik('fsbib-docentlik-filoloji', 'docentlik', 'Doçent', ['filoloji'], 4, [
        $docentBeyani,
        $dersBeyani(1, 'Madde 29/2'),
        Kalip::adet('Doktora sonrasında uluslararası hakemli dergilerde en az 4 özgün tam '
            .'araştırma makalesi', $ULUSLARARASI_HAKEMLI, 4, donem: $DOKTORA,
            madde: 'Madde 29/4') + ['donusumler' => $telafi(1)],
        Kalip::adet('Bu yayınlardan 2\'si SSCI, SCI, SCI-Expanded, A&HCI, MLA ya da ERIC '
            .'dergilerinde', $SCI_AHCI, 2, donem: $DOKTORA, madde: 'Madde 29/4'),
        Kalip::adet('Bu makalelerin en az birinde ilk yazar olmak', $SCI_AHCI, 1, yazar: 'ilk',
            donem: $DOKTORA, madde: 'Madde 29/4'),
    ], $fsbibDocentOzel,
        'MADDE 29/4: Filoloji için temel makale şartı 4 makale, 2\'si SCI/A&HCI (MLA ve ERIC '
        .'de kabul ediliyor). Özel kriterler aynı.',
        'Filolojide MLA ve ERIC indeksleri de SCI/A&HCI ile eşdeğer sayılıyor; kayıt bu iki '
        .'indeksi ayrı tutmadığı için o dergilerdeki makaleleriniz burada sayılmayabilir. '
        .$ustNotu),

    $esik('fsbib-profesorluk', 'profesorluk', 'Profesör', ['sosyal'], 5, [
        $kidemBeyani,
        $alanBeyani,
        Kalip::adet('Uluslararası indekslerce taranan hakemli dergilerde en az 11 özgün tam '
            .'araştırma makalesi', $ULUSLARARASI_HAKEMLI, 11, madde: 'Madde 27/3')
            + ['donusumler' => $telafi(2)],
        Kalip::adet('Bu makalelerden en az 6\'sı doçentliğinizden sonra', $ULUSLARARASI_HAKEMLI,
            6, donem: $DOCENTLIK, madde: 'Madde 27/3'),
        Kalip::adet('Yayınlardan en az 6\'sı SSCI, SCI, SCI-Expanded ya da A&HCI dergilerinde',
            $SCI_AHCI, 6, madde: 'Madde 27/3'),
        Kalip::adet('Bunlardan en az 3\'ü doçentliğinizden sonra', $SCI_AHCI, 3,
            donem: $DOCENTLIK, madde: 'Madde 27/3'),
        Kalip::adet('Doçentliğinizden sonraki SCI/A&HCI makalelerinin en az birinde ilk yazar '
            .'olmak', $SCI_AHCI, 1, yazar: 'ilk', donem: $DOCENTLIK, madde: 'Madde 27/3'),
    ], $fsbibProfOzel,
        'MADDE 27-28: temel kriterler (5 yıl kıdem, 11 uluslararası indeksli makale — en az 6\'sı '
        .'doçentlik sonrası, en az 6\'sı SCI/A&HCI) ve on yedi özel kriterin en az beşi.',
        $ustNotu, 'Halkla İlişkiler ve Reklamcılık dışındaki bölümler'),

    $esik('fsbib-profesorluk-hir', 'profesorluk', 'Profesör', ['sosyal'], 5, [
        $kidemBeyani,
        $alanBeyani,
        Kalip::adet('Uluslararası hakemli dergilerde en az 8 özgün tam araştırma makalesi',
            $ULUSLARARASI_HAKEMLI, 8, madde: 'Madde 27/4') + ['donusumler' => $telafi(2)],
        Kalip::adet('Bu makalelerden en az 4\'ü doçentliğinizden sonra', $ULUSLARARASI_HAKEMLI,
            4, donem: $DOCENTLIK, madde: 'Madde 27/4'),
        Kalip::adet('Yayınlardan en az 4\'ü SSCI, SCI, SCI-Expanded ya da A&HCI dergilerinde',
            $SCI_AHCI, 4, madde: 'Madde 27/4'),
        Kalip::adet('Bunlardan en az 2\'si doçentliğinizden sonra', $SCI_AHCI, 2,
            donem: $DOCENTLIK, madde: 'Madde 27/4'),
        Kalip::adet('Doçentliğinizden sonraki SCI/A&HCI makalelerinin en az birinde ilk yazar '
            .'olmak', $SCI_AHCI, 1, yazar: 'ilk', donem: $DOCENTLIK, madde: 'Madde 27/4'),
    ], $fsbibProfOzel,
        'MADDE 27/4: Halkla İlişkiler ve Reklamcılık için temel makale şartı hafifliyor — 11 '
        .'yerine 8 makale, 6 yerine 4 SCI/A&HCI. Özel kriterler aynı.',
        'Halkla İlişkiler ve Reklamcılık bölümlerinde temel makale şartı öteki sosyal '
        .'bölümlerden daha hafif (11 yerine 8 makale). '.$ustNotu,
        'Halkla İlişkiler ve Reklamcılık'),

    $esik('fsbib-profesorluk-filoloji', 'profesorluk', 'Profesör', ['filoloji'], 5, [
        $kidemBeyani,
        $alanBeyani,
        Kalip::adet('Uluslararası hakemli dergilerde en az 8 özgün tam araştırma makalesi',
            $ULUSLARARASI_HAKEMLI, 8, madde: 'Madde 27/4') + ['donusumler' => $telafi(2)],
        Kalip::adet('Bu makalelerden en az 4\'ü doçentliğinizden sonra', $ULUSLARARASI_HAKEMLI,
            4, donem: $DOCENTLIK, madde: 'Madde 27/4'),
        Kalip::adet('Yayınlardan en az 4\'ü SSCI, SCI, SCI-Expanded, A&HCI, MLA ya da ERIC '
            .'dergilerinde', $SCI_AHCI, 4, madde: 'Madde 27/4'),
        Kalip::adet('Bunlardan en az 2\'si doçentliğinizden sonra', $SCI_AHCI, 2,
            donem: $DOCENTLIK, madde: 'Madde 27/4'),
        Kalip::adet('Doçentliğinizden sonraki makalelerin en az birinde ilk yazar olmak',
            $SCI_AHCI, 1, yazar: 'ilk', donem: $DOCENTLIK, madde: 'Madde 27/4'),
    ], $fsbibProfOzel,
        'MADDE 27/4: Filoloji için 8 makale, 4\'ü SCI/A&HCI (MLA ve ERIC de kabul ediliyor). '
        .'Özel kriterler on yedi, en az beşi.',
        'Filolojide MLA ve ERIC indeksleri de SCI/A&HCI ile eşdeğer sayılıyor; kayıt bu iki '
        .'indeksi ayrı tutmadığı için o dergilerdeki makaleleriniz burada sayılmayabilir. '
        .$ustNotu),

    // ═══════════════ MİMARLIK, PLANLAMA, TASARIM ═══════════════
    $esik('mimarlik-dr', 'dr_ogr_uyesi', 'Dr. Öğr. Üyesi', ['mimarlik'], 4, [
        $doktorBeyani,
        Kalip::veya('Temel makale şartı', [
            Kalip::adet('SSCI, SCI, SCI-Expanded ya da A&HCI dergilerde ilk yazar olduğunuz en az '
                .'1 özgün tam araştırma makalesi', $SCI_AHCI, 1, yazar: 'ilk',
                madde: 'Madde 38/2-a'),
            Kalip::ve('Alan indeksi kolu', [
                Kalip::adet('ÜAK\'ın tanımladığı diğer uluslararası alan indekslerinde en az 2 '
                    .'özgün tam araştırma makalesi', $ALAN_INDEKS, 2, madde: 'Madde 38/2-b'),
                Kalip::adet('Bu makalelerin birinde ilk yazar olmak', $ALAN_INDEKS, 1,
                    yazar: 'ilk', madde: 'Madde 38/2-b'),
            ]),
        ]),
    ], [
        $ok['ders'],
        Kalip::adet('SSCI, SCI, SCI-Expanded, A&HCI, ESCI ya da Scopus dergilerde toplam en az 2 '
            .'makale', $SCI_SCOPUS, 2, madde: 'Madde 39/2'),
        Kalip::adet('ÜAK\'ın tanımladığı diğer uluslararası alan indekslerinde en az 2 özgün tam '
            .'araştırma makalesi', $ALAN_INDEKS, 2, madde: 'Madde 39/3'),
        Kalip::adet('Alanınızda ulusal ya da uluslararası kitap yazmış olmak', $KITAP, 1,
            madde: 'Madde 39/4'),
        Kalip::adet('Alanınızda ulusal ya da uluslararası kitap bölümü yazmış olmak',
            $KITAP_BOLUM, 1, madde: 'Madde 39/5'),
        Kalip::adet('Ulusal ya da uluslararası kitap editörlüğü veya endeksli dergi editörlüğü',
            $EDITORLUK, 1, madde: 'Madde 39/6'),
        $ok['davetli'],
        Kalip::adet('Ulusal ya da uluslararası projede yönetici, danışman, uzman veya '
            .'araştırmacı olarak görev yapmış olmak', $PROJE, 1, madde: 'Madde 39/8'),
        $ok['etkinlik'](1),
        $ok['atifBeyan']('Herhangi bir makalenize SSCI, SCI, SCI-Expanded, Scopus, A&HCI ya da '
            .'ESCI dergilerinde en az 4 atıf almış olmak (kendi atıflarınız sayılmaz)'),
        $ok['ceviri'],
        $ok['yarismaOdulu'],
        $ok['hakemlik'](1),
        $tezKriteriTek(null),
        $ok['atolyeYayini'],
        $ok['atolyeDuzenleme'],
        Kalip::adet('Uluslararası konferans, kongre ya da sempozyumda kabul edilmiş ve sunulmuş '
            .'en az 1 bildiri', $BILDIRI, 1, madde: 'Madde 39/17'),
    ],
        'MADDE 38-39: temel kriterler (doktor unvanı + ilk yazar olunan 1 SCI/A&HCI makalesi ya '
        .'da alan indekslerinde 2 makale) ve on yedi özel kriterin en az dördü.',
        $drNotu),

    $esik('mimarlik-docentlik', 'docentlik', 'Doçent', ['mimarlik'], 4, [
        $docentBeyani,
        $dersBeyani(1, 'Madde 36/2'),
        Kalip::adet('Doktora sonrasında SSCI, SCI, SCI-Expanded ya da A&HCI dergilerde 3 özgün '
            .'tam araştırma makalesi', $SCI_AHCI, 3, donem: $DOKTORA, madde: 'Madde 36/3')
            + ['donusumler' => $telafi(1)],
        Kalip::adet('Bu makalelerin en az birinde ilk yazar olmak', $SCI_AHCI, 1, yazar: 'ilk',
            donem: $DOKTORA, madde: 'Madde 36/3'),
    ], [
        $tezKriteriTek($DOKTORA),
        Kalip::adet('SSCI, SCI, SCI-Expanded, A&HCI, ESCI ya da Scopus dergilerde toplam en az 4 '
            .'makale', $SCI_SCOPUS, 4, donem: $DOKTORA, madde: 'Madde 37/2'),
        Kalip::adet('ÜAK\'ın tanımladığı diğer uluslararası alan indekslerinde en az 2 özgün tam '
            .'araştırma makalesi', $ALAN_INDEKS, 2, donem: $DOKTORA, madde: 'Madde 37/3'),
        Kalip::adet('Alanınızda ulusal ya da uluslararası kitap yazmış olmak', $KITAP, 1,
            donem: $DOKTORA, madde: 'Madde 37/4'),
        Kalip::adet('Alanınızda ulusal ya da uluslararası kitap bölümü yazmış olmak',
            $KITAP_BOLUM, 1, donem: $DOKTORA, madde: 'Madde 37/5'),
        $ok['atifBeyan']('Herhangi bir makalenize SSCI, SCI, SCI-Expanded, Scopus, A&HCI ya da '
            .'ESCI dergilerinde en az 5 atıf almış olmak (kendi atıflarınız sayılmaz)'),
        Kalip::adet('Ulusal ya da uluslararası kitap editörlüğü veya endeksli dergi editörlüğü',
            $EDITORLUK, 1, madde: 'Madde 37/7'),
        $ok['davetli'],
        Kalip::adet('Ulusal ya da uluslararası projede yönetici, danışman, uzman veya '
            .'araştırmacı olarak görev yapmış olmak', $PROJE, 1, madde: 'Madde 37/9'),
        $ok['etkinlik'](2),
        $ok['ceviri'],
        $ok['yarismaOdulu'],
        $ok['hakemlik'](2),
        $ok['atolyeYayini'],
        $ok['atolyeDuzenleme'],
        Kalip::adet('Uluslararası konferans, kongre ya da sempozyumda kabul edilmiş ve sunulmuş '
            .'en az 2 bildiri', $BILDIRI, 2, donem: $DOKTORA, madde: 'Madde 37/16'),
    ],
        'MADDE 36-37: temel kriterler (doçent unvanı, 1 yıl ders, doktora sonrası 3 SCI/A&HCI '
        .'makalesi — birinde ilk yazar) ve on altı özel kriterin en az dördü.',
        $ustNotu),

    $esik('mimarlik-profesorluk', 'profesorluk', 'Profesör', ['mimarlik'], 5, [
        $kidemBeyani,
        $alanBeyani,
        Kalip::adet('Doçentliğinizden sonra SSCI, SCI, SCI-Expanded ya da A&HCI dergilerde 4 '
            .'özgün tam araştırma makalesi', $SCI_AHCI, 4, donem: $DOCENTLIK,
            madde: 'Madde 34/3') + ['donusumler' => $telafi(1)],
        Kalip::adet('Bu makalelerin en az birinde ilk yazar olmak', $SCI_AHCI, 1, yazar: 'ilk',
            donem: $DOCENTLIK, madde: 'Madde 34/3'),
    ], [
        $tezKriteri($DOCENTLIK),
        Kalip::adet('SSCI, SCI, SCI-Expanded, A&HCI, Scopus ya da ESCI dergilerde toplam en az 5 '
            .'makale', $SCI_SCOPUS, 5, donem: $DOCENTLIK, madde: 'Madde 35/2'),
        Kalip::adet('ÜAK\'ın tanımladığı diğer uluslararası alan indekslerinde en az 2 özgün tam '
            .'araştırma makalesi', $ALAN_INDEKS, 2, donem: $DOCENTLIK, madde: 'Madde 35/3'),
        Kalip::adet('Alanınızla ilgili ulusal ya da uluslararası kitap yazmış olmak', $KITAP, 1,
            donem: $DOCENTLIK, madde: 'Madde 35/4'),
        Kalip::adet('Alanınızla ilgili ulusal ya da uluslararası kitap bölümü yazmış olmak',
            $KITAP_BOLUM, 1, donem: $DOCENTLIK, madde: 'Madde 35/5'),
        $ok['atifBeyan']('En az bir makalenize en az 8 atıf almış olmak (kendi atıflarınız '
            .'sayılmaz)'),
        $ok['atifBeyan']('Yukarıda sayılanların dışında, SSCI, SCI, SCI-Expanded, A&HCI, Scopus '
            .'ya da ESCI dergilerinde bir makalenize en az 6 atıf almış olmak'),
        Kalip::adet('Ulusal ya da uluslararası kitap editörlüğü veya endeksli dergi editörlüğü',
            $EDITORLUK, 1, madde: 'Madde 35/8'),
        Kalip::adet('Alan indeksleri tarafından taranan bir derginin editör listesinde yer almak',
            $EDITORLUK, 1, madde: 'Madde 35/9'),
        $ok['konukEditor'],
        $ok['davetli'],
        $ok['etkinlik'](2),
        Kalip::adet('Ulusal ya da uluslararası projede yönetici, danışman, uzman veya '
            .'araştırmacı olarak görev yapmış olmak', $PROJE, 1, donem: $DOCENTLIK,
            madde: 'Madde 35/13'),
        $ok['yarismaOdulu'],
        $ok['ceviri'],
        $ok['hakemlik'](3),
        $ok['atolyeYayini'],
        $ok['atolyeDuzenleme'],
        Kalip::adet('Uluslararası konferans, kongre ya da sempozyumda kabul edilmiş ve sunulmuş '
            .'en az 2 bildiri', $BILDIRI, 2, donem: $DOCENTLIK, madde: 'Madde 35/19'),
    ],
        'MADDE 34-35: temel kriterler (5 yıl kıdem, doçentlik sonrası 4 SCI/A&HCI makalesi — '
        .'birinde ilk yazar) ve on dokuz özel kriterin en az beşi.',
        $ustNotu),
];
