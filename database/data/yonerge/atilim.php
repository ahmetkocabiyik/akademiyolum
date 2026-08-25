<?php

/**
 * ATILIM ÜNİVERSİTESİ — Öğretim Üyeliğine Atanma ve Yükseltilme Yönergesi
 * Kaynak: pdf/17634002431.Atılım Üniversitesi Kriter.pdf
 *         (17.01.2024 Senato ve 29.02.2024 YÖK Genel Kurul kararıyla revize)
 *
 * KENDİ PUAN TABLOSU YOK, PUAN DA İSTEMİYOR. Koşulların tamamı sayı ve
 * çeyreklik şartı. Cetvel olarak ÜAK doçentlik tablosu
 * (`uak-2024-mart-{alan}`) kullanıldı.
 *
 * KORPUSTA TELAFİ MEKANİZMASINI EN SİSTEMLİ KURAN YÖNERGE. Neredeyse her koşulun
 * yanında "gerçekleşmediği durumda ilave şu kadar makale" karşılığı var:
 *   Doçentlikte tez danışmanlığı yoksa → 1 ilave Q1-Q4 makale ya da 2 ESCI makale
 *   Proje/patent/kitap koşulu yoksa    → 1 ilave Q1-Q2 makale
 *   Profesörlükte eksik kalan HER TEZ için → 1 ilave Q1-Q4 makale
 * Bu telafiler `veya` düğümleriyle girildi; motorun `telafi` alanı tek bir
 * alternatif aldığı için çok seçenekli olanlarda `veya` tercih edildi.
 *
 * "TOPLAMDA EN AZ 2 ADEDİNİN GERÇEKLEŞTİRİLMESİ" LİSTELERİ `k_ile` İLE
 * GİRİLDİ. Yönerge bu listelerde "aynı koşul iki kez de gerçekleştirilebilir"
 * diyor; motorun `k_ile` düğümü ise FARKLI çocukların kaçının sağlandığını
 * sayıyor. Yani aynı koşulu iki kez sağlayan aday (ör. iki patent) burada
 * eşiği geçmiş görünmez. Kural gereği eksik sayan taraf seçildi; aday notunda
 * uyarıldı.
 *
 * ALTI DİSİPLİN GRUBU VE ÜÇÜ FARKLI ÇEYREKLİK EŞİĞİ KULLANIYOR:
 *   Fen, Mühendislik, Sağlık   Q1-Q3 (en dar)
 *   Sosyal ve Beşeri           Q1-Q3
 *   Mimarlık, Güzel Sanatlar,
 *   Hukuk, Sanat               Q1-Q4 (en geniş)
 * Yani aynı Q4 makalesi Hukuk adayının şartını karşılarken Mühendislik
 * adayınınkini karşılamıyor.
 *
 * HUKUKTA KOŞUL YAPISI TÜMÜYLE FARKLI: doçentlikte sabit makale sayısı yerine
 * "üç seçenekten toplamda en az 2 adet" deniyor. Bu da `k_ile` ile girildi ve
 * yukarıdaki aynı sınırlama geçerli.
 *
 * SİVİL HAVACILIK DİSİPLİNİ İÇİN yalnızca Dr. Öğr. Üyeliği koşulu tanımlanmış;
 * doçentlik ve profesörlükte bu disiplin anılmıyor, o kadrolarda eşik
 * yazılmadı.
 *
 * ATIF KOŞULLARI DÜĞÜM OLARAK GİRİLDİ (5, 15, 3, 6, 2 atıf): ÜAK cetvelinde
 * atıf kalemi var ve koşul yalnızca atıf SAYISINA bakıyor, hangi esere
 * yapıldığına değil.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: uak-2024-mart-{alan}
 */

use App\Services\Scoring\Sart\Kalip;

$DR = Kalip::DOKTORA_SONRASI;
$DOC = Kalip::DOCENTLIK_SONRASI;

/** ÜAK cetvelinde çeyreklik kümeleri. */
$q1q3 = ['1a-Q1', '1a-Q2', '1a-Q3', '1b'];
$q1q4 = ['1a-*', '1b'];
$esciScopus = ['1c'];
$ulusal = ['2a', '2b'];
$atif = ['5a', '5b'];
$tez = ['6a', '6b'];
$kitap = ['4a', '4b', '4c', '4d'];
$patent = ['10a', '10b', '10c'];
$proje = ['7a-y', '7d'];

$kIleNotu = 'Yönerge bu listede "aynı koşul iki kez de gerçekleştirilebilir" diyor; burada ise '
    .'FARKLI koşullardan kaçını sağladığınız sayılıyor. İki patentiniz varsa yönergeye göre '
    .'şartı sağlıyorsunuz ama burada sağlanmamış görünür.';

$telafiNotu = 'Atılım koşulların çoğuna bir telafi bağlıyor: tez danışmanlığınız yoksa ilave '
    .'makaleyle, proje veya kitap koşulunu sağlamıyorsanız yine ilave makaleyle '
    .'karşılayabiliyorsunuz. Bu alternatifler aşağıda ayrı seçenekler olarak duruyor.';

return [
    // ══════════ DR. ÖĞRETİM ÜYESİ (Madde 6.1) ══════════
    [
        'anahtar' => 'atilim-dr-fen',
        'aday_notu' => 'Atılım PUAN İSTEMİYOR; koşullar makale sayısı ve çeyreklik üzerine '
            .'kurulu. Bu disiplinlerde çeyreklik eşiği Q1-Q3; Q4 makalesi tek başına yetmiyor, '
            .'iki tane gerekiyor.',
        'universite' => 'Atılım Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['fen', 'muhendislik', 'saglik', 'ziraat'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 6.1: SCI-E/SSCI Q1-Q3\'te 1 tam makale ya da Q4 veya Scopus\'ta '
            .'2 tam makale.',
        'sart' => Kalip::veya('Dr. Öğr. Üyesi — Fen, Sağlık ve Mühendislik Bilimleri', [
            Kalip::adet('SCI-E veya SSCI dergilerde Q1-Q3 kategorisinde en az 1 tam makale',
                $q1q3, 1, madde: 'Madde 6.1'),
            Kalip::adet('Q4 kategorisinde ya da Scopus kapsamında en az 2 tam makale',
                ['1a-Q4', '1c'], 2, madde: 'Madde 6.1'),
        ]),
    ],
    [
        'anahtar' => 'atilim-dr-sosyal',
        'aday_notu' => 'Bu disiplinde çeyreklik eşiği Q1-Q3; Q4 makalesi tek başına yetmiyor, '
            .'iki tane gerekiyor.',
        'universite' => 'Atılım Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['sosyal', 'egitim', 'filoloji', 'ilahiyat', 'spor'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 6.1: SCI-E/SSCI/AHCI Q1-Q3\'te 1 tam makale ya da Q4 veya Scopus\'ta '
            .'2 tam makale.',
        'sart' => Kalip::veya('Dr. Öğr. Üyesi — Sosyal ve Beşeri Bilimler', [
            Kalip::adet('SCI-E, SSCI veya AHCI dergilerde Q1-Q3 kategorisinde en az 1 tam makale',
                $q1q3, 1, madde: 'Madde 6.1'),
            Kalip::adet('Q4 kategorisinde ya da Scopus kapsamında en az 2 tam makale',
                ['1a-Q4', '1c'], 2, madde: 'Madde 6.1'),
        ]),
    ],
    [
        'anahtar' => 'atilim-dr-mimarlik',
        'aday_notu' => 'Bu disiplinlerde çeyreklik eşiği Q1-Q4, yani Q4 makalesi de tek başına '
            .'yeterli. Fen ve Sosyal disiplinlerinde bu böyle değil.',
        'universite' => 'Atılım Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['mimarlik'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 6.1: SCI-E/SSCI/AHCI Q1-Q4\'te 1 tam makale ya da ESCI/Scopus\'ta '
            .'2 tam makale.',
        'sart' => Kalip::veya('Dr. Öğr. Üyesi — Mimarlık, Planlama ve Tasarım', [
            Kalip::adet('SCI-E, SSCI veya AHCI dergilerde Q1-Q4 kategorisinde en az 1 tam makale',
                $q1q4, 1, madde: 'Madde 6.1'),
            Kalip::adet('ESCI veya Scopus kapsamında en az 2 tam makale', $esciScopus, 2,
                madde: 'Madde 6.1'),
        ]),
    ],
    [
        'anahtar' => 'atilim-dr-hukuk',
        'aday_notu' => 'Hukuk ve Sanat disiplinlerinde üçüncü bir alternatif var: 3 ulusal tam '
            .'makale de yeterli. Diğer disiplinlerde ulusal makale sayılmıyor.',
        'universite' => 'Atılım Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['hukuk', 'guzel_sanatlar'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 6.1: SCI-E/SSCI/AHCI Q1-Q4\'te 1 tam makale ya da ESCI/Scopus\'ta '
            .'2 tam makale ya da en az 3 ulusal tam makale.',
        'sart' => Kalip::veya('Dr. Öğr. Üyesi — Hukuk ve Sanat', [
            Kalip::adet('SCI-E, SSCI veya AHCI dergilerde Q1-Q4 kategorisinde en az 1 tam makale',
                $q1q4, 1, madde: 'Madde 6.1'),
            Kalip::adet('ESCI veya Scopus kapsamında en az 2 tam makale', $esciScopus, 2,
                madde: 'Madde 6.1'),
            Kalip::adet('En az 3 ulusal tam makale', $ulusal, 3, madde: 'Madde 6.1'),
        ]),
    ],

    // ══════════ DOÇENT (Madde 6.2) ══════════
    [
        'anahtar' => 'atilim-docent-fen',
        'aday_notu' => $telafiNotu.' '.$kIleNotu,
        'universite' => 'Atılım Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['fen', 'muhendislik', 'saglik', 'ziraat'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 6.2: Q1-Q3\'te 3 tam makale (doktora sonrası en az 2), 5 atıf, '
            .'1 lisansüstü tez ve proje/patent/kitap koşulu; son ikisinin telafisi var.',
        'sart' => Kalip::ve('Doçent — Fen, Sağlık ve Mühendislik Bilimleri', [
            Kalip::adet('SCI-E veya SSCI dergilerde Q1-Q3 kategorisinde en az 3 tam makale',
                $q1q3, 3, madde: 'Madde 6.2'),
            Kalip::adet('Bunlardan en az 2\'si doktoranızdan sonra', $q1q3, 2, donem: $DR,
                madde: 'Madde 6.2'),
            Kalip::adet('İndeksli dergilerden yapılan en az 5 atıf', $atif, 5, madde: 'Madde 6.2'),
            Kalip::veya('Tez danışmanlığı koşulu', [
                Kalip::adet('Danışmanlığınızda tamamlanmış en az 1 lisansüstü tez', $tez, 1,
                    madde: 'Madde 6.2'),
                Kalip::adet('Tez yoksa telafi olarak ilave 1 adet Q1-Q4 tam makale', $q1q4, 4,
                    madde: 'Madde 6.2'),
            ]),
            Kalip::veya('Proje, patent veya kitap koşulu', [
                Kalip::adet('Sözleşmesi imzalanmış en az 1 araştırma projesinde yürütücü olmak',
                    $proje, 1, madde: 'Madde 6.2'),
                Kalip::adet('En az 1 patent veya faydalı model tescili', $patent, 1,
                    madde: 'Madde 6.2'),
                Kalip::adet('En az 1 uluslararası kitap ya da 3 uluslararası kitap bölümü',
                    ['4a', '4b'], 1, madde: 'Madde 6.2'),
                Kalip::adet('Telafi olarak ilave 1 adet Q1-Q2 tam makale',
                    ['1a-Q1', '1a-Q2'], 4, madde: 'Madde 6.2'),
            ]),
        ]),
    ],
    [
        'anahtar' => 'atilim-docent-sosyal',
        'aday_notu' => 'Sosyal ve Beşeri Bilimlerde makale ve atıf sayıları fen grubundan düşük '
            .'(3 yerine 2 makale, 5 yerine 3 atıf). '.$telafiNotu,
        'universite' => 'Atılım Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['sosyal', 'egitim', 'filoloji', 'ilahiyat', 'spor'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 6.2: Q1-Q3\'te 2 tam makale (doktora sonrası en az 1), 3 atıf, '
            .'1 lisansüstü tez ve proje/patent/kitap koşulu.',
        'sart' => Kalip::ve('Doçent — Sosyal ve Beşeri Bilimler', [
            Kalip::adet('SCI-E, SSCI veya AHCI dergilerde Q1-Q3 kategorisinde en az 2 tam makale',
                $q1q3, 2, madde: 'Madde 6.2'),
            Kalip::adet('Bunlardan en az 1\'i doktoranızdan sonra', $q1q3, 1, donem: $DR,
                madde: 'Madde 6.2'),
            Kalip::adet('İndeksli dergilerden yapılan en az 3 atıf', $atif, 3, madde: 'Madde 6.2'),
            Kalip::veya('Tez danışmanlığı koşulu', [
                Kalip::adet('Danışmanlığınızda tamamlanmış en az 1 lisansüstü tez', $tez, 1,
                    madde: 'Madde 6.2'),
                Kalip::adet('Tez yoksa telafi olarak ilave 1 adet Q1-Q4 tam makale', $q1q4, 3,
                    madde: 'Madde 6.2'),
            ]),
            Kalip::veya('Proje, patent veya kitap koşulu', [
                Kalip::adet('Sözleşmesi imzalanmış en az 1 araştırma projesinde yürütücü olmak',
                    $proje, 1, madde: 'Madde 6.2'),
                Kalip::adet('En az 1 patent veya faydalı model tescili', $patent, 1,
                    madde: 'Madde 6.2'),
                Kalip::adet('En az 1 ulusal ya da uluslararası kitap veya 3 uluslararası kitap '
                    .'bölümü', $kitap, 1, madde: 'Madde 6.2'),
                Kalip::adet('Telafi olarak ilave 1 adet Q1-Q4 tam makale', $q1q4, 3,
                    madde: 'Madde 6.2'),
            ]),
        ]),
    ],
    [
        'anahtar' => 'atilim-docent-mimarlik',
        'aday_notu' => 'Bu disiplinlerde çeyreklik eşiği Q1-Q4 ve makale koşulunun bir '
            .'alternatifi var: 2 Q1-Q4 makale ya da 1 Q1-Q4 makale ile 2 ESCI/Scopus makalesi. '
            .$telafiNotu,
        'universite' => 'Atılım Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['mimarlik', 'guzel_sanatlar'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 6.2: Q1-Q4\'te 2 tam makale ya da 1 Q1-Q4 + 2 ESCI/Scopus makalesi '
            .'(doktora sonrası en az 1), 3 atıf, 1 lisansüstü tez ve proje/patent/kitap koşulu.',
        'sart' => Kalip::ve('Doçent — Mimarlık, Planlama, Tasarım ve Güzel Sanatlar', [
            Kalip::veya('Makale koşulu', [
                Kalip::adet('SCI-E, SSCI veya AHCI dergilerde Q1-Q4 kategorisinde en az '
                    .'2 tam makale', $q1q4, 2, madde: 'Madde 6.2'),
                Kalip::ve('1 Q1-Q4 makalesi ve 2 ESCI/Scopus makalesi', [
                    Kalip::adet('Q1-Q4 kategorisinde en az 1 tam makale', $q1q4, 1,
                        madde: 'Madde 6.2'),
                    Kalip::adet('ESCI veya Scopus kapsamında en az 2 tam makale', $esciScopus, 2,
                        madde: 'Madde 6.2'),
                ]),
            ]),
            Kalip::adet('Bu makalelerden en az 1\'i doktoranızdan sonra', $q1q4, 1, donem: $DR,
                madde: 'Madde 6.2'),
            Kalip::adet('İndeksli dergilerden yapılan en az 3 atıf', $atif, 3, madde: 'Madde 6.2'),
            Kalip::veya('Tez danışmanlığı koşulu', [
                Kalip::adet('Danışmanlığınızda tamamlanmış en az 1 lisansüstü tez', $tez, 1,
                    madde: 'Madde 6.2'),
                Kalip::adet('Tez yoksa telafi olarak ilave 1 adet Q1-Q4 tam makale', $q1q4, 3,
                    madde: 'Madde 6.2'),
            ]),
            Kalip::veya('Proje, patent, kitap veya ödül koşulu', [
                Kalip::adet('Sözleşmesi imzalanmış en az 1 araştırma projesinde yürütücü olmak',
                    $proje, 1, madde: 'Madde 6.2'),
                Kalip::adet('En az 1 patent, faydalı model ya da tescilli tasarım', $patent, 1,
                    madde: 'Madde 6.2'),
                Kalip::adet('En az 1 ulusal ya da uluslararası kitap veya 3 uluslararası kitap '
                    .'bölümü', $kitap, 1, madde: 'Madde 6.2'),
                Kalip::beyan('Yarışma ödülü ya da uygulanmış-tamamlanmış proje', 'Madde 6.2'),
            ]),
        ]),
    ],
    [
        'anahtar' => 'atilim-docent-hukuk',
        'aday_notu' => 'Hukukta koşul yapısı tümüyle farklı: sabit makale sayısı yerine üç '
            .'seçenekten toplamda en az 2 adedi isteniyor. '.$kIleNotu,
        'universite' => 'Atılım Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['hukuk'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 6.2: üç makale seçeneğinden toplamda en az 2 adet (doktora sonrası '
            .'en az 1 tam makale), iki atıf seçeneğinden en az 2 adet ve 1 lisansüstü tez.',
        'sart' => Kalip::ve('Doçent — Hukuk', [
            Kalip::kIle('Aşağıdaki makale seçeneklerinden en az 2 adedini sağlamak', 2, [
                Kalip::adet('SCI-E, SSCI veya AHCI dergilerde Q1-Q4 kategorisinde 1 tam makale',
                    $q1q4, 1, madde: 'Madde 6.2'),
                Kalip::adet('ESCI veya Scopus kapsamında 2 tam makale', $esciScopus, 2,
                    madde: 'Madde 6.2'),
                Kalip::adet('Ulusal endeksli dergilerde 3 tam makale', $ulusal, 3,
                    madde: 'Madde 6.2'),
            ]),
            Kalip::adet('Bu makalelerden en az 1\'i doktoranızdan sonra',
                [...$q1q4, ...$esciScopus, ...$ulusal], 1, donem: $DR, madde: 'Madde 6.2'),
            Kalip::kIle('Aşağıdaki atıf seçeneklerinden en az 2 adedini sağlamak', 2, [
                Kalip::adet('İndeksli dergilerden yapılan en az 1 atıf', $atif, 1,
                    madde: 'Madde 6.2'),
                Kalip::adet('Ulusal veya uluslararası endeksli dergilerden yapılan en az 3 atıf',
                    $atif, 3, madde: 'Madde 6.2'),
            ]),
            Kalip::veya('Tez danışmanlığı koşulu', [
                Kalip::adet('Danışmanlığınızda tamamlanmış en az 1 lisansüstü tez', $tez, 1,
                    madde: 'Madde 6.2'),
                Kalip::adet('Tez yoksa telafi olarak ilave 1 adet Q1-Q4 tam makale', $q1q4, 2,
                    madde: 'Madde 6.2'),
            ]),
        ]),
    ],

    // ══════════ PROFESÖR (Madde 6.3) ══════════
    [
        'anahtar' => 'atilim-profesor-fen',
        'aday_notu' => 'Profesörlükte tez koşulu ikiye çıkıyor ve telafi EKSİK KALAN HER TEZ '
            .'için ayrı ayrı işliyor. '.$kIleNotu,
        'universite' => 'Atılım Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['fen', 'muhendislik', 'saglik', 'ziraat'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 6.3: Q1-Q3\'te 5 tam makale (doçentlik sonrası en az 2), 15 atıf, '
            .'2 lisansüstü tez ve beş seçenekten en az 2 adet.',
        'sart' => Kalip::ve('Profesör — Fen, Sağlık ve Mühendislik Bilimleri', [
            Kalip::adet('SCI-E veya SSCI dergilerde Q1-Q3 kategorisinde en az 5 tam makale',
                $q1q3, 5, madde: 'Madde 6.3'),
            Kalip::adet('Bunlardan en az 2\'si doçentliğinizden sonra', $q1q3, 2, donem: $DOC,
                madde: 'Madde 6.3'),
            Kalip::adet('İndeksli dergilerden yapılan en az 15 atıf', $atif, 15,
                madde: 'Madde 6.3'),
            Kalip::veya('Tez danışmanlığı koşulu', [
                Kalip::adet('Danışmanlığınızda tamamlanmış en az 2 lisansüstü tez', $tez, 2,
                    madde: 'Madde 6.3'),
                Kalip::adet('Eksik kalan her tez için telafi olarak ilave Q1-Q4 tam makale',
                    $q1q4, 7, madde: 'Madde 6.3'),
            ]),
            Kalip::kIle('Aşağıdaki seçeneklerden en az 2 adedini sağlamak', 2, [
                Kalip::adet('Sözleşmesi imzalanmış araştırma projesinde yürütücü olmak',
                    $proje, 1, madde: 'Madde 6.3'),
                Kalip::adet('Patent veya faydalı model tescili', $patent, 1, madde: 'Madde 6.3'),
                Kalip::adet('Uluslararası kitap ya da 3 uluslararası kitap bölümü',
                    ['4a', '4b'], 1, madde: 'Madde 6.3'),
                Kalip::adet('İlave 1 adet Q1-Q2 tam makale', ['1a-Q1', '1a-Q2'], 6,
                    madde: 'Madde 6.3'),
            ]),
        ]),
    ],
    [
        'anahtar' => 'atilim-profesor-sosyal',
        'aday_notu' => 'Makale koşulunun bir alternatifi var: 4 Q1-Q3 makale ya da 3 Q1-Q3 ile '
            .'2 ESCI/Scopus makalesi. '.$kIleNotu,
        'universite' => 'Atılım Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['sosyal', 'egitim', 'filoloji', 'ilahiyat', 'spor', 'hukuk', 'mimarlik',
            'guzel_sanatlar'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 6.3: Q1-Q3\'te 4 tam makale ya da 3 Q1-Q3 + 2 ESCI/Scopus (doçentlik '
            .'sonrası en az 2), 6 atıf, 2 lisansüstü tez ve beş seçenekten en az 2 adet.',
        'sart' => Kalip::ve('Profesör — Sosyal, Beşeri ve diğer alanlar', [
            Kalip::veya('Makale koşulu', [
                Kalip::adet('SCI-E, SSCI veya AHCI dergilerde Q1-Q3 kategorisinde en az '
                    .'4 tam makale', $q1q3, 4, madde: 'Madde 6.3'),
                Kalip::ve('3 Q1-Q3 makalesi ve 2 ESCI/Scopus makalesi', [
                    Kalip::adet('Q1-Q3 kategorisinde en az 3 tam makale', $q1q3, 3,
                        madde: 'Madde 6.3'),
                    Kalip::adet('ESCI veya Scopus kapsamında en az 2 tam makale', $esciScopus, 2,
                        madde: 'Madde 6.3'),
                ]),
            ]),
            Kalip::adet('Bu makalelerden en az 2\'si doçentliğinizden sonra', $q1q3, 2,
                donem: $DOC, madde: 'Madde 6.3'),
            Kalip::adet('İndeksli dergilerden yapılan en az 6 atıf', $atif, 6, madde: 'Madde 6.3'),
            Kalip::veya('Tez danışmanlığı koşulu', [
                Kalip::adet('Danışmanlığınızda tamamlanmış en az 2 lisansüstü tez', $tez, 2,
                    madde: 'Madde 6.3'),
                Kalip::adet('Eksik kalan her tez için telafi olarak ilave Q1-Q4 tam makale',
                    $q1q4, 6, madde: 'Madde 6.3'),
            ]),
            Kalip::kIle('Aşağıdaki seçeneklerden en az 2 adedini sağlamak', 2, [
                Kalip::adet('Sözleşmesi imzalanmış araştırma projesinde yürütücü olmak',
                    $proje, 1, madde: 'Madde 6.3'),
                Kalip::adet('Patent veya faydalı model tescili', $patent, 1, madde: 'Madde 6.3'),
                Kalip::adet('Ulusal ya da uluslararası kitap veya 3 uluslararası kitap bölümü',
                    $kitap, 1, madde: 'Madde 6.3'),
                Kalip::adet('İlave 1 adet Q1-Q4 tam makale', $q1q4, 5, madde: 'Madde 6.3'),
            ]),
        ]),
    ],
];
