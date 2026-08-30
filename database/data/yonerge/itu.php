<?php

/**
 * İSTANBUL TEKNİK ÜNİVERSİTESİ — Akademik Yükseltme ve Atama Ölçütleri ile
 * İlgili Senato Esasları (2022)
 * Kaynak: pdf/17536997252.istanbulteknikuniverstesi.pdf
 * Senato: 04.11.2022 / 817
 *
 * BEŞ TABLO BİRLİKTE ÇALIŞIYOR VE ÜÇÜ DE BİRİME GÖRE DEĞİŞİYOR:
 *   Tablo 1  faaliyet puanları (birime göre farklı sütun) → cetvel/itu-2022.php
 *   Tablo 2  kadro koşulları (birim grubuna göre farklı satır)
 *   Tablo 3  ESER PUANI kapsamına giren eser türleri (birime göre)
 *   Tablo 4  birim başına sınır değerler (DÖSP · U1/U2 · DSP · PSP)
 *   Tablo 5  BAŞLICA ESER türleri (birime göre)
 * Üç taksonomi birbirine denk düşmüyor: Tablo 1 dört sütun grubu, Tablo 3 beş
 * grup, Tablo 4 elli bölüm, Tablo 5 yedi grup tanımlıyor. `birim` alanı bu
 * yüzden yoğun kullanıldı.
 *
 * ── "TOPLAM PUAN" BARAJI HİÇ YAZILMADI ──
 * Tablo 2'nin son satırı bütün birimlerden Dr. için 60, doçent için 250,
 * profesör için 500 toplam puan istiyor. Bu toplamın içine Tablo 1'in üç
 * FORMÜL kalemi giriyor: h-indeksine dayalı puan ((h − sınır) × 25), FWCI'ye
 * dayalı puan ((FWCI − 1) × yayın sayısı) ve ders kredisi toplamı. Üçü de
 * faaliyet kaydından türetilemiyor ve mühendislik başvurularında toplamın
 * büyük bölümünü oluşturuyorlar. Eksik toplamla baraj göstermek, adaya
 * sağlayamayacağı bir hedef gösterirdi.
 * ESER PUANI barajı bundan etkilenmiyor: Tablo 3 eser puanına yalnızca yayın
 * türlerini katıyor, D ve K bölümlerini katmıyor. Bu yüzden yönergenin asıl
 * ayırt edici koşulları (eser puanı ve başlıca eser adedi) tam girildi.
 *
 * ── HUKUK TEMEL ALANI GİRİLMEDİ ──
 * Tablo 2, 3 ve 5 "Hukuk Temel Alanı" için ayrı satır taşıyor ama Tablo 4'te
 * hukuk için sınır değer YOK — İTÜ'nün birim listesinde hukuk fakültesi
 * bulunmuyor. DÖSP/DSP/PSP olmadan eser puanı barajı yazılamaz.
 *
 * ── "EN FAZLA N'İ ŞU TÜRDEN" SINIRLARI ──
 * Başlıca eser koşullarının çoğu hem alt sınır hem üst sınır taşıyor
 * ("en az 1'i A1/A2/A3, en fazla 1'i C1/C3"). Toplam adet ile alt sınır
 * verildiğinde üst sınır çoğu satırda kendiliğinden çıkıyor (2 eserin en az
 * 1'i A ise en fazla 1'i C olabilir) ve o satırlarda ayrıca yazmaya gerek
 * kalmadı. Mimarlık Fakültesi'nin doçent ve profesör satırlarında ise üst
 * sınır alt sınırdan türemiyor ("7 eserin en az 3'ü A1/A2/A3, en fazla 2'si
 * yarışma ödülü"); motorda "en fazla" düğümü olmadığı için o iki satırda üst
 * sınır UYGULANMIYOR ve koşul olduğundan kolay görünebilir. Aday notunda
 * söylendi.
 *
 * ── BAŞLICA ESER TANIMI ──
 * Tablo 5 başlıca eseri "tek yazarlı, ya da adayın kendi tezinden/projesinden
 * üretilmiş olup ilk ve/veya sorumlu yazar olduğu" eser diye tanımlıyor.
 * Motorda bunun karşılığı `yazar: 'baslica'` (form: "Başlıca / sorumlu
 * yazar"); eserin tezden mi projeden mi üretildiği kayıtta tutulmuyor.
 * Koşullar bu yüzden yazarlık şartını uyguluyor, üretim kaynağını değil.
 *
 * ── EŞER PUANI SINIRI YÜKSELTEN TELAFİLER ──
 * Yönergenin birkaç koşulu "yoksa" durumunda BAŞKA bir barajı yükseltiyor:
 *   Türkçe yayın yoksa eser puanı sınırına doçentte +3, profesörde +6.
 *   Araştırma projesi görevi yoksa (H/S/TMDK) sınıra doçentte +10,
 *       profesörde +20.
 *   Lisansüstü tez yoksa 1 adet ek başlıca eser.
 * Üçü de `veya` ile kuruldu: ya koşul sağlanır ya da yükseltilmiş baraj.
 *
 * ── BAŞLICA ESER KÜMESİ DAR TUTULAN BİRİMLER ──
 * Tablo 5, Denizcilik Fakültesi, Fen-Edebiyat Matematik ve İşletme Fakültesi
 * için başlıca eser kümesini A1/A2/A3 diye genişletiyor; varsayılan küme
 * A1/A2. Bu üç birim için ayrı `birim` açılmadı — dar küme adayı fazla hazır
 * göstermeyen taraf, koşul olduğundan zor görünür.
 *
 * MADDE 2.7 (QS/THE ilk 50 üniversiteden yeni doktora almış adayların asgari
 * koşulları sağlamış sayılması) ve Madde 2.9 (yağmacı dergi yasağı)
 * girilmedi: biri muafiyet yolu, diğeri bir eleme kuralı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/itu-2022.php
 */

use App\Services\Scoring\Sart\Kalip;

$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

/** Madde 2.8 — yalnızca doktor öğretim üyesi atamalarında aranıyor. */
$dil = Kalip::yds(65) + ['madde' => 'Madde 2.8'];

$uluslararasiDeneyim = Kalip::beyan(
    'Lisansüstü çalışmalarınızın en az birini yurt dışında tamamlamış olmak; yurt içinde '
    .'tamamladıysanız lisansüstü sırasında veya sonrasında en az bir yılı yurt dışı, ya da '
    .'doktora sonrasında en az iki yılı yurt içi araştırma kurumlarında geçirmiş olmak',
    'Tablo 2 — Uluslararası Deneyim',
);

/**
 * "Şu koşul yoksa eser puanı sınırı yükselir" kalıbı.
 *
 * @param  array<string, mixed>  $kosul
 * @return array<string, mixed>
 */
$sinirYukselten = fn (string $aciklama, array $kosul, int $yeniSinir, string $madde): array => Kalip::veya(
    $aciklama,
    [
        $kosul,
        Kalip::puanDan(
            "Ya da eser puanınız {$yeniSinir}'e yükselir",
            ['ESER-PUANI'],
            $yeniSinir,
            madde: $madde,
        ),
    ],
) + ['madde' => $madde];

/**
 * Birim grupları. Her satır bir `birim` değeri (null = varsayılan) ve o
 * birimin cetveli, sınır değerleri ve başlıca eser kümesi.
 *
 * sinir  [DÖSP, U1, DSP, PSP]  — Tablo 4
 */
$birimler = [
    [
        'anahtar' => 'itu-genel', 'ad' => 'Tüm Birimler', 'birim' => null,
        'alanlar' => ['fen', 'muhendislik', 'sosyal'],
        'cetvel' => 'itu-2022', 'sinir' => [30, 15, 70, 110], 'grup' => 'genel',
    ],
    [
        'anahtar' => 'itu-kimya-metalurji', 'ad' => 'Kimya ve Metalurji Fakültesi',
        'birim' => 'Kimya ve Metalurji Fakültesi', 'alanlar' => ['muhendislik'],
        'cetvel' => 'itu-2022', 'sinir' => [30, 15, 80, 120], 'grup' => 'genel',
    ],
    [
        'anahtar' => 'itu-ataturk-ilkeleri', 'ad' => 'Atatürk İlkeleri ve İnkılap Tarihi Bölümü',
        'birim' => 'Atatürk İlkeleri ve İnkılap Tarihi Bölümü', 'alanlar' => ['sosyal'],
        'cetvel' => 'itu-2022', 'sinir' => [20, 10, 50, 90], 'grup' => 'genel',
    ],
    [
        'anahtar' => 'itu-sosyoloji', 'ad' => 'Sosyoloji Bölümü',
        'birim' => 'Sosyoloji Bölümü', 'alanlar' => ['sosyal'],
        'cetvel' => 'itu-2022-hs', 'sinir' => [20, 10, 50, 90], 'grup' => 'sosyoloji',
    ],
    [
        'anahtar' => 'itu-mimarlik', 'ad' => 'Mimarlık Fakültesi', 'birim' => null,
        'alanlar' => ['mimarlik'],
        'cetvel' => 'itu-2022-mf', 'sinir' => [20, 10, 50, 90], 'grup' => 'mimarlik',
    ],
    [
        'anahtar' => 'itu-tmdk', 'ad' => 'Türk Musikisi Devlet Konservatuvarı',
        'birim' => 'Türk Musikisi Devlet Konservatuvarı', 'alanlar' => ['guzel_sanatlar'],
        'cetvel' => 'itu-2022-tmdk', 'sinir' => [30, 15, 70, 110], 'grup' => 'tmdk',
    ],
    [
        'anahtar' => 'itu-moda', 'ad' => 'Tekstil Teknolojileri ve Tasarımı Fakültesi — Moda Tasarımı',
        'birim' => 'Tekstil Teknolojileri ve Tasarımı Fakültesi — Moda Tasarımı',
        'alanlar' => ['guzel_sanatlar'],
        'cetvel' => 'itu-2022-moda', 'sinir' => [20, 10, 50, 90], 'grup' => 'moda',
    ],
];

$esikler = [];

foreach ($birimler as $b) {
    [$dosp, $u1, $dsp, $psp] = $b['sinir'];
    $grup = $b['grup'];

    $ortak = [
        'universite' => 'İstanbul Teknik Üniversitesi',
        'alan' => $b['alanlar'],
        'birim' => $b['birim'],
        'cetvel' => $b['cetvel'],
    ];

    // Araştırma projesi ve lisansüstü tez koşulları birim grubuna göre iki
    // ayrı satırdan geliyor.
    $hafifProje = in_array($grup, ['sosyoloji', 'tmdk'], true);
    $hafifTez = in_array($grup, ['sosyoloji', 'tmdk', 'moda'], true);
    $deneyimAranir = ! in_array($grup, ['tmdk', 'moda'], true);

    // ══════════════ DR. ÖĞRETİM ÜYESİ (ilk atama) ══════════════
    $kosullar = [
        $dil,
        Kalip::puanDan("Eser puanınız en az {$dosp} olmalı", ['ESER-PUANI'], $dosp, madde: 'Tablo 2 — Eser Puanı'),
        Kalip::adet('Başlıca eser sayınız en az 2 olmalı', ['BASLICA-ESER'], 2, 'baslica', madde: 'Tablo 2 — Başlıca Eser'),
    ];

    $kosullar[] = match ($grup) {
        'sosyoloji' => Kalip::adet('Bunların en az 1\'i uluslararası indeksli dergideki makaleniz olmalı', ['SOSYOLOJI-MAKALE'], 1, 'baslica', madde: 'Tablo 2 — Başlıca Eser'),
        'mimarlik' => Kalip::adet('Bunların en az 1\'i Scopus Q1-Q3 dergideki makaleniz olmalı', ['A1-A3'], 1, 'baslica', madde: 'Tablo 2 — Başlıca Eser'),
        'tmdk' => Kalip::adet('Bunların en az 1\'i makaleniz olmalı', ['A-TURU'], 1, 'baslica', madde: 'Tablo 2 — Başlıca Eser'),
        default => Kalip::adet('Bunların en az 1\'i Scopus Q1-Q2 dergideki makaleniz olmalı', ['A1-A2'], 1, 'baslica', madde: 'Tablo 2 — Başlıca Eser'),
    };

    if ($grup === 'tmdk') {
        $kosullar[] = Kalip::veya('En az 1 kitap ya da müzik-sahne çalışması', [
            Kalip::adet('En az 1 kitap kaleminiz', ['C-TAMAMI'], 1, madde: 'Tablo 2 — Başlıca Eser'),
            Kalip::adet('Ya da en az 1 müzik veya sahne çalışmanız', ['MUZIK'], 1, madde: 'Tablo 2 — Başlıca Eser'),
        ]) + ['madde' => 'Tablo 2 — Başlıca Eser'];
    }

    if ($deneyimAranir) {
        $kosullar[] = $uluslararasiDeneyim;
    }

    $esikler[] = $ortak + [
        'anahtar' => "{$b['anahtar']}-dr",
        'kadro' => 'dr_ogr_uyesi',
        'aday_notu' => "{$b['ad']} için eser puanı sınırı {$dosp}. Yönergenin toplam puan barajı "
            .'(60) burada gösterilmiyor: içine h-indeksi, FWCI ve ders kredisi formülleri '
            .'giriyor, bunlar kayıttan hesaplanamıyor.',
        'notlar' => "Madde 3 + Tablo 2, Tablo 4 ({$b['ad']}). DÖSP {$dosp}. Toplam puan barajı "
            .'(60) girilmedi; formül tabanlı kalemler hesaplanamıyor.',
        'sart' => Kalip::ve("Dr. Öğr. Üyeliğine atanma — {$b['ad']}", $kosullar),
    ];

    // ══════════════ DR. ÖĞRETİM ÜYESİ (görev süresi uzatma) ══════════════
    $esikler[] = $ortak + [
        'anahtar' => "{$b['anahtar']}-dr-yeniden",
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'aday_notu' => 'Görev süresi uzatma üç yıllık aralıklarla yapılıyor. '
            ."Uzatma için eser puanı sınırı {$u1}; yönergenin ayrıca istediği toplam puan sınırı "
            .'burada gösterilmiyor.',
        'notlar' => "Madde 9 + Tablo 4 ({$b['ad']}). U1 (eser puanı sınırı) {$u1}, U2 (toplam "
            .'puan sınırı) girilmedi. Dönem son atama sonrası alındı: görev süresi uzatma '
            .'tanımı gereği içinde bulunulan atama dönemine bakıyor.',
        'sart' => Kalip::puanDan(
            "Eser puanınız en az {$u1} olmalı",
            ['ESER-PUANI'],
            $u1,
            $SON_ATAMA,
            madde: 'Madde 9.2',
        ),
    ];

    // ══════════════ DOÇENT ══════════════
    $baslicaDoc = 4;
    $kosullar = [
        Kalip::puanDan("Eser puanınız en az {$dsp} olmalı", ['ESER-PUANI'], $dsp, madde: 'Tablo 2 — Eser Puanı'),
    ];

    // Lisansüstü tez koşulu sağlanmazsa başlıca eser sayısı bir artıyor.
    $tezSayisi = $hafifTez ? 1 : 1;
    $kosullar[] = Kalip::veya('Tamamlanmış lisansüstü tez danışmanlığı ya da ek başlıca eser', [
        Kalip::adet("Tamamlanmış en az {$tezSayisi} lisansüstü tez danışmanlığı", ['TEZ'], $tezSayisi, madde: 'Tablo 2 — Lisansüstü Tez'),
        Kalip::adet('Ya da başlıca eser sayınız en az '.($baslicaDoc + 1).' olmalı', ['BASLICA-ESER'], $baslicaDoc + 1, 'baslica', $DOKTORA, madde: 'Tablo 2 — Lisansüstü Tez'),
    ]) + ['madde' => 'Tablo 2 — Lisansüstü Tez'];

    $kosullar[] = Kalip::adet("Doktora unvanından sonra başlıca eser sayınız en az {$baslicaDoc} olmalı", ['BASLICA-ESER'], $baslicaDoc, 'baslica', $DOKTORA, madde: 'Tablo 2 — Başlıca Eser');

    $kosullar[] = match ($grup) {
        'sosyoloji' => Kalip::adet('Bunların en az 2\'si uluslararası indeksli dergideki makaleniz olmalı', ['SOSYOLOJI-MAKALE'], 2, 'baslica', $DOKTORA, madde: 'Tablo 2 — Başlıca Eser'),
        'mimarlik' => Kalip::adet('Bunların en az 2\'si Scopus Q1-Q3 dergideki makaleniz olmalı', ['A1-A3'], 2, 'baslica', $DOKTORA, madde: 'Tablo 2 — Başlıca Eser'),
        'tmdk' => Kalip::adet('Bunların en az 2\'si makale, kitap ya da müzik-sahne çalışmanız olmalı', ['ESER-PUANI'], 2, 'baslica', $DOKTORA, madde: 'Tablo 2 — Başlıca Eser'),
        default => Kalip::adet('Bunların en az 2\'si Scopus Q1-Q2 dergideki makaleniz olmalı', ['A1-A2'], 2, 'baslica', $DOKTORA, madde: 'Tablo 2 — Başlıca Eser'),
    };

    // Türkçe yayın — bütün birimlerde aynı.
    $kosullar[] = $sinirYukselten(
        'En az 1 TR Dizin makalesi ya da yükseltilmiş eser puanı',
        Kalip::adet('TR Dizin taranan dergide en az 1 makale', ['TR-DIZIN'], 1, madde: 'Tablo 2 — Türkçe Yayın'),
        $dsp + 3,
        'Tablo 2 — Türkçe Yayın',
    );

    // Araştırma projesi görevi.
    $projeKosulu = Kalip::adet('Doktora sonrası tamamlanmış en az 1 araştırma projesinde görev almak', ['PROJE'], 1, donem: $DOKTORA, madde: 'Tablo 2 — Araştırma Projesi');
    $kosullar[] = $hafifProje
        ? $sinirYukselten('Araştırma projesi görevi ya da yükseltilmiş eser puanı', $projeKosulu, $dsp + 10, 'Tablo 2 — Araştırma Projesi')
        : $projeKosulu;

    if ($grup === 'mimarlik') {
        $kosullar[] = Kalip::veya('Eğitim faaliyeti ya da ek başlıca eser', [
            Kalip::adet('En az 1 eğitim faaliyeti (yaz okulu, MOOC, uluslararası kısa süreli ders)', ['EGITIM-FAALIYETI'], 1, madde: 'Tablo 2 — Eğitim Faaliyeti'),
            Kalip::adet('Ya da Scopus Q1-Q3 makale veya uluslararası kitap kaleminizden 1 ek başlıca eser', ['A1-A3-C1-C3'], $baslicaDoc + 1, 'baslica', $DOKTORA, madde: 'Tablo 2 — Eğitim Faaliyeti'),
        ]) + ['madde' => 'Tablo 2 — Eğitim Faaliyeti'];

        $kosullar[] = Kalip::veya('Uygulama veya sanata katkı ya da ek başlıca eser', [
            Kalip::adet('En az 1 yarışma ödülü, jüri üyeliği, patent veya tasarım uygulaması', ['UYGULAMA'], 1, madde: 'Tablo 2 — Uygulama ve Sanata Katkı'),
            Kalip::adet('Ya da Scopus Q1-Q3 makale veya uluslararası kitap kaleminizden 1 ek başlıca eser', ['A1-A3-C1-C3'], $baslicaDoc + 1, 'baslica', $DOKTORA, madde: 'Tablo 2 — Uygulama ve Sanata Katkı'),
        ]) + ['madde' => 'Tablo 2 — Uygulama ve Sanata Katkı'];
    }

    if ($grup === 'moda') {
        $kosullar[] = Kalip::adet('En az 3 moda tasarımı etkinliği', ['MODA'], 3, madde: 'Tablo 2 — Uygulama ve Sanata Katkı');
    }

    $esikler[] = $ortak + [
        'anahtar' => "{$b['anahtar']}-docent",
        'kadro' => 'docentlik',
        'aday_notu' => "{$b['ad']} için eser puanı sınırı {$dsp}. Türkçe yayın koşulunu "
            .'sağlayamazsanız yönerge sınırı '.($dsp + 3).'\'e çıkarıyor'
            .($hafifProje ? ', araştırma projesi koşulunu sağlayamazsanız '.($dsp + 10).'\'e' : '')
            .'. Toplam puan barajı (250) burada gösterilmiyor.',
        'notlar' => "Madde 15 + Tablo 2, Tablo 4 ({$b['ad']}). DSP {$dsp}. Toplam puan barajı "
            .'(250) girilmedi.',
        'sart' => Kalip::ve("Doçent kadrosuna atanma — {$b['ad']}", $kosullar),
    ];

    // ══════════════ PROFESÖR ══════════════
    $baslicaProf = 7;
    $kosullar = [
        Kalip::puanDan("Eser puanınız en az {$psp} olmalı", ['ESER-PUANI'], $psp, madde: 'Tablo 2 — Eser Puanı'),
        Kalip::adet("Başlıca eser sayınız en az {$baslicaProf} olmalı", ['BASLICA-ESER'], $baslicaProf, 'baslica', madde: 'Tablo 2 — Başlıca Eser'),
        Kalip::adet('Bunların en az 3\'ü doçentlik unvanınızdan sonra üretilmiş olmalı', ['BASLICA-ESER'], 3, 'baslica', $DOCENTLIK, madde: 'Tablo 2 — Başlıca Eser'),
    ];

    $kosullar[] = match ($grup) {
        'sosyoloji' => Kalip::adet('Bunların en az 4\'ü uluslararası indeksli dergideki makaleniz olmalı', ['SOSYOLOJI-MAKALE'], 4, 'baslica', madde: 'Tablo 2 — Başlıca Eser'),
        'mimarlik' => Kalip::adet('Bunların en az 3\'ü Scopus Q1-Q3 dergideki makaleniz olmalı', ['A1-A3'], 3, 'baslica', madde: 'Tablo 2 — Başlıca Eser'),
        'tmdk' => Kalip::adet('Bunların en az 3\'ü makale, kitap ya da müzik-sahne çalışmanız olmalı', ['ESER-PUANI'], 3, 'baslica', madde: 'Tablo 2 — Başlıca Eser'),
        default => Kalip::adet('Bunların en az 3\'ü Scopus Q1-Q2 dergideki makaleniz olmalı', ['A1-A2'], 3, 'baslica', madde: 'Tablo 2 — Başlıca Eser'),
    };

    $kosullar[] = $sinirYukselten(
        'Doktora sonrası en az 2 TR Dizin makalesi ya da yükseltilmiş eser puanı',
        Kalip::adet('TR Dizin taranan dergide en az 2 makale', ['TR-DIZIN'], 2, donem: $DOKTORA, madde: 'Tablo 2 — Türkçe Yayın'),
        $psp + 6,
        'Tablo 2 — Türkçe Yayın',
    );

    $projeSayisi = $hafifProje ? 1 : 2;
    $projeKosulu = Kalip::adet(
        "Doktora sonrası en az {$projeSayisi} araştırma projesinde yürütücülük ya da uluslararası projede araştırmacılık",
        ['PROJE-YURUTUCU-ULUSLARARASI'],
        $projeSayisi,
        donem: $DOKTORA,
        madde: 'Tablo 2 — Araştırma Projesi',
    );
    $kosullar[] = $hafifProje
        ? $sinirYukselten('Araştırma projesi görevi ya da yükseltilmiş eser puanı', $projeKosulu, $psp + 20, 'Tablo 2 — Araştırma Projesi')
        : $projeKosulu;

    $tezSayisi = $hafifTez ? 1 : 3;
    $kosullar[] = $hafifTez
        ? Kalip::veya('Tamamlanmış lisansüstü tez danışmanlığı ya da ek başlıca eser', [
            Kalip::adet('Tamamlanmış en az 1 lisansüstü tez danışmanlığı', ['TEZ'], 1, madde: 'Tablo 2 — Lisansüstü Tez'),
            Kalip::adet('Ya da başlıca eser sayınız en az '.($baslicaProf + 1).' olmalı', ['BASLICA-ESER'], $baslicaProf + 1, 'baslica', madde: 'Tablo 2 — Lisansüstü Tez'),
        ]) + ['madde' => 'Tablo 2 — Lisansüstü Tez']
        : Kalip::adet("Tamamlanmış en az {$tezSayisi} lisansüstü tez danışmanlığı", ['TEZ'], $tezSayisi, madde: 'Tablo 2 — Lisansüstü Tez');

    if ($grup === 'mimarlik') {
        $kosullar[] = Kalip::veya('Eğitim faaliyeti ya da ek başlıca eser', [
            Kalip::adet('Doçent atamasında sayılmamış en az 1 eğitim faaliyeti', ['EGITIM-FAALIYETI'], 1, donem: $DOCENTLIK, madde: 'Tablo 2 — Eğitim Faaliyeti'),
            Kalip::adet('Ya da Scopus Q1-Q3 makale veya uluslararası kitap kaleminizden 1 ek başlıca eser', ['A1-A3-C1-C3'], $baslicaProf + 1, 'baslica', madde: 'Tablo 2 — Eğitim Faaliyeti'),
        ]) + ['madde' => 'Tablo 2 — Eğitim Faaliyeti'];

        $kosullar[] = Kalip::veya('Uygulama veya sanata katkı ya da ek başlıca eser', [
            Kalip::adet('Doçent atamasında sayılmamış en az 1 yarışma ödülü, jüri üyeliği, patent veya tasarım uygulaması', ['UYGULAMA'], 1, donem: $DOCENTLIK, madde: 'Tablo 2 — Uygulama ve Sanata Katkı'),
            Kalip::adet('Ya da Scopus Q1-Q3 makale veya uluslararası kitap kaleminizden 1 ek başlıca eser', ['A1-A3-C1-C3'], $baslicaProf + 1, 'baslica', madde: 'Tablo 2 — Uygulama ve Sanata Katkı'),
        ]) + ['madde' => 'Tablo 2 — Uygulama ve Sanata Katkı'];
    }

    if ($grup === 'moda') {
        $kosullar[] = Kalip::adet('En az 4 moda tasarımı etkinliği', ['MODA'], 4, madde: 'Tablo 2 — Uygulama ve Sanata Katkı');
        $kosullar[] = Kalip::adet('Bunların en az 1\'i doçentlik unvanınızdan sonra olmalı', ['MODA'], 1, donem: $DOCENTLIK, madde: 'Tablo 2 — Uygulama ve Sanata Katkı');
    }

    $esikler[] = $ortak + [
        'anahtar' => "{$b['anahtar']}-profesor",
        'kadro' => 'profesorluk',
        'aday_notu' => "{$b['ad']} için eser puanı sınırı {$psp}. Yedi başlıca eserin en az üçü "
            .'doçentlik unvanınızdan sonra üretilmiş olmalı. Toplam puan barajı (500) burada '
            .'gösterilmiyor.'
            .($grup === 'mimarlik' ? ' Yönergenin "en fazla 2\'si yarışma ödülü olabilir" sınırı '
                .'motorda uygulanmıyor; koşul olduğundan kolay görünebilir.' : ''),
        'notlar' => "Madde 16 + Tablo 2, Tablo 4 ({$b['ad']}). PSP {$psp}. Toplam puan barajı "
            .'(500) girilmedi.',
        'sart' => Kalip::ve("Profesör kadrosuna atanma — {$b['ad']}", $kosullar),
    ];
}

return $esikler;
