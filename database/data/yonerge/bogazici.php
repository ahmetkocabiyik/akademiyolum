<?php

/**
 * BOĞAZİÇİ ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Esasları
 * Kaynak: pdf/17536987652.bogaziciuniverstesi.pdf
 *
 * KENDİ PUAN TABLOSU YOK. Boğaziçi hiçbir kadroda puan istemiyor; koşulların
 * tamamı "en az N başlıca eser, en az M'si şu indekste" biçiminde SAYI şartı.
 * Cetvel olarak ÜAK doçentlik tablosu (`uak-2024-mart-{alan}`) kullanıldı;
 * koşulların andığı kalemleri (SCIE/SSCI/AHCI makalesi, ESCI/Scopus makalesi,
 * uluslararası kitap ve kitap bölümü, TR Dizin makalesi) o cetvel tanımlıyor.
 *
 * "BAŞLICA ESER" YÖNERGENİN KENDİ TANIMI (Madde 9), yazarlık sırasıyla ilgisi
 * yok. Dört kategoriden biri olmak yeterli:
 *   1. SCIE, SSCI veya AHCI dergilerde makale
 *   2. Scopus veya ESCI dergilerde makale
 *   3. Uluslararası yayınevlerince yayımlanan kitap ve kitap bölümleri
 *      (derleme kitap editörlüğü HARİÇ)
 *   4. TR Dizin dergilerde özgün makale — yalnızca Hukuk Fakültesi ve
 *      Türk Dili ve Edebiyatı Bölümü için
 * Motorun `baslica` rolüyle karıştırılmaması için koşullarda rol filtresi
 * kullanılmadı; "başlıca eser" burada bir YAYIN TÜRÜ kümesi.
 *
 * KOŞULLAR FAKÜLTEYE GÖRE DEĞİŞİYOR, TEMEL ALANA GÖRE DEĞİL. Madde 11 genel
 * kuralı koyuyor (Dr. 1 · doçent 5 · profesör 5 başlıca eser), sonra yedi
 * birim kendi sayılarını yazıyor. Bu yüzden eşikler `birim` alanıyla ayrıldı;
 * aday fakültesini seçmeden doğru eşiği bulamıyor.
 *
 * MÜHENDİSLİK VE FEN GRUBU EN AĞIR VE EN FARKLI: orada koşul "başlıca eser"
 * değil doğrudan SCIE/SSCI/AHCI MAKALESİ. Profesörlükte doçentlik sonrası 6
 * makale isteniyor, ayrıca kariyer boyu toplam en az 14 makale şartı var —
 * korpusta kariyer toplamına bakan ender koşullardan biri.
 *
 * GİRİLEMEYEN NİTELİKLER (beyan olarak duruyor):
 *   Mühendislik profesörlüğünde "altı makalenin en az ikisinde aday veya tez
 *   öğrencisi ilk yazar olmalı" ve "en az ikisi Makale Etki Faktörü ilk %50'lik
 *   dilimde bir dergide olmalı". Etki faktörü dilimi kaynak sözlüğünde yok;
 *   tez öğrencisinin ilk yazarlığı faaliyet kaydından türetilemiyor.
 *
 *   İletişim Fakültesinde film festivali ödülü alternatifi: sinema eserinin
 *   senaryo yazarlığı, yönetmenliği veya görüntü yönetmenliği. Sanatsal
 *   etkinlik kalemleri ÜAK cetvelinde olmadığı için beyan.
 *
 * YENİDEN ATANMA GİRİLMEDİ: koşullar "her üç yıllık sürenin sonunda, son
 * atanma tarihi sonrasında" biçiminde; atama tarihi profilde tutulmuyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: uak-2024-mart-{alan}
 */

use App\Services\Scoring\Sart\Kalip;

$DOC = Kalip::DOCENTLIK_SONRASI;

/** Madde 9'un "başlıca eser" tanımı: dört yayın kategorisi. */
$baslicaEser = ['1a-*', '1b', '1c', '4a', '4b'];
/** Yalnızca atıf endeksli dergiler (SCIE, SSCI, AHCI). */
$atifEndeksi = ['1a-*', '1b'];
/** Scopus ve ESCI. */
$scopusEsci = ['1c'];
/** Hukuk ve Türk Dili için TR Dizin de başlıca eser sayılıyor. */
$baslicaEserHukuk = ['1a-*', '1b', '1c', '4a', '4b', '2a'];

$tumAlanlar = ['fen', 'muhendislik', 'saglik', 'sosyal', 'egitim', 'hukuk', 'ilahiyat',
    'filoloji', 'guzel_sanatlar', 'mimarlik', 'spor', 'ziraat'];

$yenidenAtamaNotu = 'Yeniden atanma koşulları her üç yıllık sürenin sonunda son atanma '
    .'tarihinize göre hesaplanıyor; o tarih burada tutulmadığı için yeniden atanma eşiği '
    .'girilmedi.';

$eserNotu = 'Boğaziçi PUAN İSTEMİYOR; koşullar "en az N başlıca eser" biçiminde. "Başlıca eser" '
    .'burada yazarlık sırası değil, Madde 9\'daki dört yayın kategorisinden biri anlamına '
    .'geliyor: SCIE/SSCI/AHCI makalesi, Scopus/ESCI makalesi ya da uluslararası yayınevi kitabı '
    .'veya kitap bölümü (derleme kitap editörlüğü sayılmıyor).';

$birimGenel = 'Genel kural (birimine özel koşul tanımlanmamış fakülteler)';
$birimSosyal = 'Eğitim Fakültesi; Batı Dilleri, Dilbilimi, Çeviribilim, Felsefe, Psikoloji, Sosyoloji ve Tarih Bölümleri';
$birimHukuk = 'Hukuk Fakültesi; Türk Dili ve Edebiyatı Bölümü';
$birimIletisim = 'İletişim Fakültesi';
$birimIsletme = 'İktisadi ve İdari Bilimler Fakültesi; Yönetim Bilimleri Fakültesi';
$birimMuhendislik = 'Mühendislik Fakültesi; Fizik, Kimya, Matematik, Moleküler Biyoloji ve Genetik Bölümleri; Biyomedikal, Çevre, Kandilli ve Veri Bilimi Enstitüleri';
$birimYabanciDiller = 'Yabancı Diller Yüksekokulu';

/**
 * "En az N başlıca eser, en az M'si şu endekste" kalıbı.
 *
 * @param  list<string>  $eserKumesi
 * @param  list<string>  $endeksKumesi
 * @param  list<array<string, mixed>>  $ek
 * @return array<string, mixed>
 */
$esik = function (string $anahtar, string $kadro, string $kadroAd, string $birim, array $alanlar,
    int $eser, ?int $endeks, array $eserKumesi, array $endeksKumesi, string $endeksAd,
    string $notu, array $ek = []) use ($DOC): array {
    $donem = $kadro === 'profesorluk' ? $DOC : null;
    $cocuklar = [];

    if ($eser > 0) {
        $cocuklar[] = Kalip::adet(
            $kadro === 'profesorluk'
                ? "Doçentliğinizden sonra en az {$eser} başlıca eser"
                : "En az {$eser} başlıca eser",
            array_values($eserKumesi), $eser, donem: $donem, madde: 'Madde 11',
        );
    }

    if ($endeks !== null) {
        $cocuklar[] = Kalip::adet("Bunlardan en az {$endeks}'i {$endeksAd} taranan dergilerde",
            array_values($endeksKumesi), $endeks, donem: $donem, madde: 'Madde 11');
    }

    return [
        'anahtar' => "bogazici-{$kadro}-{$anahtar}",
        'aday_notu' => $notu,
        'universite' => 'Boğaziçi Üniversitesi',
        'kadro' => $kadro,
        'alan' => array_values($alanlar),
        'birim' => $birim,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => "{$birim} — {$kadroAd}: en az {$eser} başlıca eser"
            .($endeks !== null ? ", en az {$endeks}'i {$endeksAd} taranan dergilerde." : '.'),
        'sart' => Kalip::ve("{$kadroAd} — {$birim}", [...$cocuklar, ...array_values($ek)]),
    ];
};

$docentlikBeyani = Kalip::beyan('2547 sayılı Kanunun 24. maddesi uyarınca doçentlik unvanını almış '
    .'olmak; yurt dışında alınmışsa Üniversitelerarası Kurulca Türkiye\'de geçerli sayılmış olması',
    'Madde 10');

$profesorlukBeyani = Kalip::beyan('Doçentlik unvanını aldıktan sonra en az beş yıl açık bulunan '
    .'profesörlük kadrosuyla ilgili alanda çalışmış ve en az iki yıl öğretim üyesi kadrosunda '
    .'görev yapmış olmak', 'Madde 10');

return [
    // ══════════ GENEL KURAL (Madde 11) ══════════
    $esik('genel', 'dr_ogr_uyesi', 'Dr. Öğr. Üyesi', $birimGenel, $tumAlanlar,
        1, null, $baslicaEser, [], '', $eserNotu.' '.$yenidenAtamaNotu),
    $esik('genel', 'docentlik', 'Doçent', $birimGenel, $tumAlanlar,
        5, 3, $baslicaEser, $atifEndeksi, 'SCIE, SSCI veya AHCI tarafından', $eserNotu,
        [$docentlikBeyani]),
    $esik('genel', 'profesorluk', 'Profesör', $birimGenel, $tumAlanlar,
        5, 3, $baslicaEser, $atifEndeksi, 'SCIE, SSCI veya AHCI tarafından', $eserNotu,
        [$profesorlukBeyani]),

    // ══════════ EĞİTİM VE SOSYAL BÖLÜMLER ══════════
    $esik('sosyal', 'dr_ogr_uyesi', 'Dr. Öğr. Üyesi', $birimSosyal, ['egitim', 'sosyal', 'filoloji'],
        2, 1, $baslicaEser, $atifEndeksi, 'SCIE, SSCI veya AHCI tarafından',
        $eserNotu.' '.$yenidenAtamaNotu),
    $esik('sosyal', 'docentlik', 'Doçent', $birimSosyal, ['egitim', 'sosyal', 'filoloji'],
        5, 3, $baslicaEser, $atifEndeksi, 'SCIE, SSCI veya AHCI tarafından', $eserNotu,
        [$docentlikBeyani]),
    $esik('sosyal', 'profesorluk', 'Profesör', $birimSosyal, ['egitim', 'sosyal', 'filoloji'],
        5, 3, $baslicaEser, $atifEndeksi, 'SCIE, SSCI veya AHCI tarafından', $eserNotu,
        [$profesorlukBeyani]),

    // ══════════ HUKUK VE TÜRK DİLİ (TR Dizin de başlıca eser sayılıyor) ══════════
    $esik('hukuk', 'dr_ogr_uyesi', 'Dr. Öğr. Üyesi', $birimHukuk, ['hukuk', 'filoloji'],
        2, 1, $baslicaEserHukuk, ['1b', '1c'], 'SSCI, AHCI, ESCI veya Scopus tarafından',
        'Bu iki birimde TR Dizin makaleleri de başlıca eser sayılıyor (Madde 9/4); korpustaki '
        .'diğer Boğaziçi birimlerinde sayılmıyor. '.$yenidenAtamaNotu),
    $esik('hukuk', 'docentlik', 'Doçent', $birimHukuk, ['hukuk', 'filoloji'],
        6, null, $baslicaEserHukuk, [], '',
        'Bu iki birimde TR Dizin makaleleri de başlıca eser sayılıyor. Endeks koşulunun iki '
        .'alternatifi var: 6 eserin en az 1\'i SSCI/AHCI\'de ya da en az 2\'si Scopus/ESCI\'de '
        .'olabilir.', [
            Kalip::veya('Endeks koşulu', [
                Kalip::adet('Bu eserlerden en az 1\'i SSCI veya AHCI dergilerinde',
                    ['1a-*', '1b'], 1, madde: 'Hukuk/Türk Dili — doçentlik'),
                Kalip::adet('Bu eserlerden en az 2\'si Scopus veya ESCI dergilerinde',
                    ['1c'], 2, madde: 'Hukuk/Türk Dili — doçentlik'),
            ]),
            $docentlikBeyani,
        ]),
    $esik('hukuk', 'profesorluk', 'Profesör', $birimHukuk, ['hukuk', 'filoloji'],
        6, null, $baslicaEserHukuk, [], '',
        'Bu iki birimde TR Dizin makaleleri de başlıca eser sayılıyor. Endeks koşulunun iki '
        .'alternatifi var: 6 eserin en az 1\'i SSCI/AHCI\'de ya da en az 2\'si Scopus/ESCI\'de '
        .'olabilir.', [
            Kalip::veya('Endeks koşulu', [
                Kalip::adet('Bu eserlerden en az 1\'i SSCI veya AHCI dergilerinde',
                    ['1a-*', '1b'], 1, donem: $DOC, madde: 'Hukuk/Türk Dili — profesörlük'),
                Kalip::adet('Bu eserlerden en az 2\'si Scopus veya ESCI dergilerinde',
                    ['1c'], 2, donem: $DOC, madde: 'Hukuk/Türk Dili — profesörlük'),
            ]),
            $profesorlukBeyani,
        ]),

    // ══════════ İLETİŞİM FAKÜLTESİ ══════════
    [
        'anahtar' => 'bogazici-dr-iletisim',
        'aday_notu' => 'İletişim Fakültesinde yayın koşulunun bir sinema alternatifi var: '
            .'uluslararası bir film festivalinde ödüllendirilmiş bir sinema eserinin senaryo '
            .'yazarlığı, yönetmenliği, görüntü yönetmenliği veya kurguculuğu. Bu alternatif '
            .'beyan olarak duruyor, çünkü sanatsal etkinlik kalemleri kullanılan cetvelde yok. '
            .$yenidenAtamaNotu,
        'universite' => 'Boğaziçi Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['sosyal', 'guzel_sanatlar'],
        'birim' => $birimIletisim,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'İletişim Fakültesi — Dr. Öğr. Üyesi: en az 2 başlıca eser (en az 1\'i '
            .'SSCI/AHCI/ESCI/Scopus\'ta) ya da ödüllü bir sinema eserinde belirtilen görevler.',
        'sart' => Kalip::veya('Dr. Öğr. Üyesi — İletişim Fakültesi', [
            Kalip::ve('Yayın koşulu', [
                Kalip::adet('En az 2 başlıca eser', $baslicaEser, 2, madde: 'İletişim Fakültesi'),
                Kalip::adet('Bunlardan en az 1\'i SSCI, AHCI, ESCI veya Scopus dergilerinde',
                    ['1a-*', '1b', '1c'], 1, madde: 'İletişim Fakültesi'),
            ]),
            Kalip::beyan('Uluslararası bir film festivalinde ödüllendirilmiş bir sinema eserinin '
                .'senaryo yazarlığını, yönetmenliğini, prodüksiyon/ses/ışık/animasyon/görsel efekt '
                .'tasarımcılığını, görüntü yönetmenliğini veya kurguculuğunu yapmış olmak',
                'İletişim Fakültesi'),
        ]),
    ],
    $esik('iletisim', 'docentlik', 'Doçent', $birimIletisim, ['sosyal', 'guzel_sanatlar'],
        5, 3, $baslicaEser, ['1a-*', '1b', '1c'], 'SSCI, AHCI, ESCI veya Scopus tarafından',
        $eserNotu, [$docentlikBeyani]),
    $esik('iletisim', 'profesorluk', 'Profesör', $birimIletisim, ['sosyal', 'guzel_sanatlar'],
        5, 3, $baslicaEser, ['1a-*', '1b', '1c'], 'SSCI, AHCI, ESCI veya Scopus tarafından',
        $eserNotu, [$profesorlukBeyani]),

    // ══════════ İKTİSADİ VE İDARİ BİLİMLER / YÖNETİM BİLİMLERİ ══════════
    $esik('isletme', 'dr_ogr_uyesi', 'Dr. Öğr. Üyesi', $birimIsletme, ['sosyal'],
        2, 1, $baslicaEser, $atifEndeksi, 'SCIE, SSCI veya AHCI tarafından',
        $eserNotu.' '.$yenidenAtamaNotu),
    $esik('isletme', 'docentlik', 'Doçent', $birimIsletme, ['sosyal'],
        7, 3, $baslicaEser, $atifEndeksi, 'SCIE, SSCI veya AHCI tarafından',
        'Bu iki fakültede eser sayısı korpustaki Boğaziçi birimlerinin en yükseği: 5 değil 7. '
        .$eserNotu, [$docentlikBeyani]),
    $esik('isletme', 'profesorluk', 'Profesör', $birimIsletme, ['sosyal'],
        7, 3, $baslicaEser, $atifEndeksi, 'SCIE, SSCI veya AHCI tarafından',
        'Bu iki fakültede eser sayısı korpustaki Boğaziçi birimlerinin en yükseği: 5 değil 7. '
        .$eserNotu, [$profesorlukBeyani]),

    // ══════════ MÜHENDİSLİK VE FEN ══════════
    // Bu grupta koşul "başlıca eser" değil, doğrudan SCIE/SSCI/AHCI makalesi.
    $esik('muhendislik', 'dr_ogr_uyesi', 'Dr. Öğr. Üyesi', $birimMuhendislik,
        ['muhendislik', 'fen'], 2, null, $atifEndeksi, [], '',
        'Bu grupta koşul "başlıca eser" değil doğrudan SCIE/SSCI/AHCI MAKALESİ; kitap ve '
        .'ESCI/Scopus yayınları sayılmıyor. '.$yenidenAtamaNotu),
    $esik('muhendislik', 'docentlik', 'Doçent', $birimMuhendislik, ['muhendislik', 'fen'],
        5, null, $atifEndeksi, [], '',
        'Bu grupta koşul "başlıca eser" değil doğrudan SCIE/SSCI/AHCI MAKALESİ; kitap ve '
        .'ESCI/Scopus yayınları sayılmıyor.', [$docentlikBeyani]),
    [
        'anahtar' => 'bogazici-profesorluk-muhendislik',
        'aday_notu' => 'Bu grupta koşul "başlıca eser" değil doğrudan SCIE/SSCI/AHCI MAKALESİ. '
            .'Ayrıca korpusta ender bir şart var: KARİYER BOYU toplam en az 14 SCIE/SSCI/AHCI '
            .'makalesi (dönem sınırı olmadan). Altı makalenin en az ikisinde sizin ya da tez '
            .'öğrencinizin ilk yazar olması ve en az ikisinin Makale Etki Faktörü ilk %50\'lik '
            .'dilimdeki bir dergide olması koşulları beyan olarak duruyor; etki faktörü dilimi ve '
            .'tez öğrencisinin yazarlığı faaliyet kaydından hesaplanamıyor.',
        'universite' => 'Boğaziçi Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['muhendislik', 'fen'],
        'birim' => $birimMuhendislik,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Mühendislik ve Fen — Profesör: doçentlik sonrası SCIE/SSCI/AHCI dergilerde '
            .'en az 6 makale; kariyer boyu toplam en az 14 makale.',
        'sart' => Kalip::ve("Profesör — {$birimMuhendislik}", [
            Kalip::adet('Doçentliğinizden sonra SCIE, SSCI veya AHCI dergilerde en az 6 makale',
                $atifEndeksi, 6, donem: $DOC, madde: 'Mühendislik ve Fen — profesörlük'),
            Kalip::adet('Kariyeriniz boyunca SCIE, SSCI veya AHCI dergilerde toplam en az 14 makale',
                $atifEndeksi, 14, madde: 'Mühendislik ve Fen — profesörlük'),
            Kalip::beyan('Doçentlik sonrası altı makalenin en az ikisinde sizin veya tez '
                .'danışmanlığını yürüttüğünüz öğrencinin ilk yazar olması', 'Mühendislik ve Fen — profesörlük'),
            Kalip::beyan('Bu makalelerin en az ikisinin Makale Etki Faktörü (Article Influence '
                .'Score) değeri ilk %50\'lik dilimde bulunan bir dergide yer alması',
                'Mühendislik ve Fen — profesörlük'),
            $profesorlukBeyani,
        ]),
    ],

    // ══════════ YABANCI DİLLER YÜKSEKOKULU ══════════
    $esik('yabanci-diller', 'dr_ogr_uyesi', 'Dr. Öğr. Üyesi', $birimYabanciDiller, ['filoloji'],
        1, null, $baslicaEser, [], '', $eserNotu.' '.$yenidenAtamaNotu),
];
