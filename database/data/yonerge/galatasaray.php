<?php

/**
 * GALATASARAY ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Ölçütleri
 * Kaynak: pdf/1771228172303.galatasaray-kriter-16022026.pdf
 *         (Yükseköğretim Genel Kurulunun 30.01.2025 tarihli değişikliğiyle)
 *
 * KENDİ PUAN TABLOSU YOK, AMA PUAN İSTİYOR. Galatasaray puanı kendi cetveline
 * göre değil, "başvuru tarihinde yürürlükte olan Doçentlik Sınavı Başvuru
 * Şartları'nda belirlenmiş BİRİM PUANLAR esas alınmak suretiyle" hesaplatıyor.
 * Yani ölçek ÜAK'ın; eşik Galatasaray'ın. Cetvel olarak `uak-2024-mart-{alan}`
 * kullanıldı.
 *
 * PUAN EŞİKLERİ:
 *   Dr. Öğr. Üyesi   en az  50 puan
 *   Doçent           en az 110 puan (Ek 1 idari/topluma katkı faaliyeti varsa 100)
 *   Profesör         doçentlik sonrası en az 110 puan (aynı indirimle 100)
 * ÜAK'ın kendi doçentlik toplamı 100 olduğuna göre Galatasaray doçentlikte
 * ÜAK'ın üstüne çıkıyor; indirimi ise idari ya da topluma katkı faaliyetine
 * bağlıyor. Korpusta "toplum hizmeti yaparsan barajın düşer" diyen ender
 * yönergelerden biri.
 *
 * İNDİRİM KOŞULU BEYANA BAĞLI OLDUĞU İÇİN DÜŞÜK EŞİK YAZILMADI: Ek 1'deki
 * idari ve topluma katkı faaliyetleri listesi kaynak sözlüğünde karşılıksız.
 * Kural gereği YÜKSEK olan 110 gösteriliyor; indirimi hak eden aday aday
 * notundan öğreniyor. Düşüğü yazmak, o faaliyeti yapmamış adaya sağlanmış
 * gibi gösterirdi.
 *
 * BEŞ TEMEL ALAN, HER BİRİNDE FARKLI SAYI VE ATIF KOŞULU (Madde 5/d, 7/d, 8/f).
 * Mühendislik en ağır: doçentlikte 5 makale + 20 atıf + 1 proje yürütücülüğü;
 * profesörlükte 40 atıf, h-indeks 5 ve 2 proje.
 *
 * DOKTORA SONRASI YURT DIŞI ŞARTI (Madde 5/c) BEYAN: doktorasını 31.12.2023
 * sonrasında yurt içinde tamamlayanlardan toplam 9 aylık yurt dışı araştırma
 * isteniyor. Süre ve tarih profilde tutulmuyor.
 *
 * FRANSIZCA ÖNCELİĞİ BEYAN: yönerge "Fransızca yeterliliği öncelikli olmak
 * üzere bir yabancı dil bilmek" diyor ama sayısal bir sınav eşiği vermiyor;
 * `yds` düğümü kullanılamadı.
 *
 * ATIF KOŞULLARI BEYAN: "eserlerine WOS veri tabanında en az 20 atıf yapılmış
 * olmak" — faaliyet kaydı atıf sayısını tutuyor ama koşul atfın hangi eserlere
 * yapıldığına da bakıyor; ayrıca h-indeks profilde yok.
 *
 * YENİDEN ATANMA GİRİLMEDİ (Madde 6): "bir önceki atama tarihinden itibaren üç
 * yıllık süre içinde en az 50 puan"; atama tarihi profilde tutulmuyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: uak-2024-mart-{alan}
 */

use App\Services\Scoring\Sart\Kalip;

$DOC = Kalip::DOCENTLIK_SONRASI;

/** ÜAK cetvelinde makale kalemleri. */
$sciMakale = ['1a-*', '1b'];
$uluslararasiYayin = ['1a-*', '1b', '1c', '4a', '4b'];
$ulusalUluslararasiYayin = ['1a-*', '1b', '1c', '2a', '4a', '4b', '4c', '4d'];

$dilBeyani = Kalip::beyan('Bilimsel araştırma yapabilecek ve ders yürütebilecek düzeyde '
    .'Fransızca yeterliliği öncelikli olmak üzere bir yabancı dil bilmek', 'Madde 5-8/a');

$indirimNotu = 'Puan barajının bir indirimi var: başvuru öncesinde Ek 1\'deki idari veya '
    .'topluma katkı faaliyetlerinden en az birini yapmışsanız 110 yerine 100 puan yeterli. '
    .'Bu faaliyetler burada hesaplanamadığı için YÜKSEK olan 110 gösteriliyor.';

$yurtDisiNotu = 'Doktoranızı 31.12.2023 tarihinden sonra yurt içinde tamamladıysanız, lisansüstü '
    .'eğitiminiz sırasında ya da doktora sonrasında yurt dışı yükseköğretim kurumlarında toplam '
    .'en az 9 ay bilimsel araştırma yapmış olmanız gerekiyor (Madde 5/c).';

$yenidenAtamaNotu = 'Yeniden atanmada bir önceki atama tarihinizden itibaren üç yıl içinde en az '
    .'50 puan isteniyor; atama tarihi burada tutulmadığı için yeniden atanma eşiği girilmedi.';

return [
    // ══════════ DR. ÖĞRETİM ÜYESİ (Madde 5) ══════════
    [
        'anahtar' => 'galatasaray-dr-muhendislik',
        'aday_notu' => 'Galatasaray puanı kendi cetveline göre değil ÜAK doçentlik birim '
            .'puanlarına göre hesaplatıyor; ölçek ÜAK\'ın, eşik Galatasaray\'ın. Çok yazarlı '
            .'yayınlarda yazar sayısı ve sırası dikkate ALINMIYOR, tam puan sayılıyor '
            .'(Madde 5/ç-3). '.$yurtDisiNotu.' '.$yenidenAtamaNotu,
        'universite' => 'Galatasaray Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['muhendislik'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 5/ç: ÜAK birim puanlarıyla en az 50 puan. Madde 5/d-i: lisansüstü '
            .'tezlerden üretilmiş en az 1, toplamda en az 3 SCIE/SSCI makalesi.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Mühendislik', [
            Kalip::toplam(50),
            Kalip::adet('SCIE veya SSCI dergilerinde toplam en az 3 makale', $sciMakale, 3,
                madde: 'Madde 5/d-i'),
            Kalip::adet('Bunlardan en az 1\'i lisansüstü tezlerinizden üretilmiş olmalı',
                ['3a'], 1, madde: 'Madde 5/d-i'),
            $dilBeyani,
            Kalip::beyan($yurtDisiNotu, 'Madde 5/c'),
        ]),
    ],
    [
        'anahtar' => 'galatasaray-dr-fen',
        'aday_notu' => 'Çok yazarlı yayınlarda yazar sayısı ve sırası dikkate ALINMIYOR, tam '
            .'puan sayılıyor (Madde 5/ç-3). '.$yurtDisiNotu.' '.$yenidenAtamaNotu,
        'universite' => 'Galatasaray Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['fen'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 5/ç: ÜAK birim puanlarıyla en az 50 puan. Madde 5/d-ii: lisansüstü '
            .'tezlerden üretilmiş en az 1, toplamda en az 2 SCIE makalesi.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Fen Bilimleri ve Matematik', [
            Kalip::toplam(50),
            Kalip::adet('SCIE dergilerinde toplam en az 2 makale', $sciMakale, 2,
                madde: 'Madde 5/d-ii'),
            Kalip::adet('Bunlardan en az 1\'i lisansüstü tezlerinizden üretilmiş olmalı',
                ['3a'], 1, madde: 'Madde 5/d-ii'),
            $dilBeyani,
            Kalip::beyan($yurtDisiNotu, 'Madde 5/c'),
        ]),
    ],
    [
        'anahtar' => 'galatasaray-dr-sosyal',
        'aday_notu' => 'Çok yazarlı yayınlarda yazar sayısı ve sırası dikkate ALINMIYOR, tam '
            .'puan sayılıyor (Madde 5/ç-3). '.$yurtDisiNotu.' '.$yenidenAtamaNotu,
        'universite' => 'Galatasaray Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['sosyal'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 5/ç: ÜAK birim puanlarıyla en az 50 puan. Madde 5/d-iii: lisansüstü '
            .'tezlerden üretilmiş en az 1, toplamda en az 2 uluslararası özgün yayın.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Sosyal, Beşeri ve İdari Bilimler', [
            Kalip::toplam(50),
            Kalip::adet('Toplam en az 2 uluslararası özgün yayın', $uluslararasiYayin, 2,
                madde: 'Madde 5/d-iii'),
            Kalip::adet('Bunlardan en az 1\'i lisansüstü tezlerinizden üretilmiş olmalı',
                ['3a', '3b'], 1, madde: 'Madde 5/d-iii'),
            $dilBeyani,
            Kalip::beyan($yurtDisiNotu, 'Madde 5/c'),
        ]),
    ],
    [
        'anahtar' => 'galatasaray-dr-hukuk',
        'aday_notu' => 'Hukuk ve Filoloji alanlarında yayın ulusal da olabiliyor; sayı ise bir '
            .'fazla (3). Çok yazarlı yayınlarda yazar sayısı ve sırası dikkate ALINMIYOR. '
            .$yurtDisiNotu.' '.$yenidenAtamaNotu,
        'universite' => 'Galatasaray Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['hukuk', 'filoloji'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 5/ç: ÜAK birim puanlarıyla en az 50 puan. Madde 5/d-iv ve d-v: '
            .'lisansüstü tezlerden üretilmiş en az 1, toplamda en az 3 uluslararası/ulusal '
            .'özgün yayın.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Hukuk ve Filoloji', [
            Kalip::toplam(50),
            Kalip::adet('Toplam en az 3 uluslararası veya ulusal özgün yayın',
                $ulusalUluslararasiYayin, 3, madde: 'Madde 5/d-iv'),
            Kalip::adet('Bunlardan en az 1\'i lisansüstü tezlerinizden üretilmiş olmalı',
                ['3a', '3b'], 1, madde: 'Madde 5/d-iv'),
            $dilBeyani,
            Kalip::beyan($yurtDisiNotu, 'Madde 5/c'),
        ]),
    ],

    // ══════════ DOÇENT (Madde 7) ══════════
    [
        'anahtar' => 'galatasaray-docent-muhendislik',
        'aday_notu' => 'Mühendislikte doçentlik korpustaki en ağır Galatasaray eşiği: 5 makale, '
            .'birinde başlıca yazar, biri Q1-Q2\'de, ayrıca 20 atıf ve tamamlanmış bir proje '
            .'yürütücülüğü. '.$indirimNotu,
        'universite' => 'Galatasaray Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['muhendislik'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 7/ç: ÜAK birim puanlarıyla en az 110 puan (Ek 1 faaliyeti varsa 100). '
            .'Madde 7/d-i: 5 SCIE/SSCI makalesi, 1\'inde başlıca yazar, 1\'i Q1-Q2\'de, 20 atıf, '
            .'1 proje yürütücülüğü.',
        'sart' => Kalip::ve('Doçent — Mühendislik', [
            Kalip::toplam(110),
            Kalip::adet('SCIE veya SSCI dergilerinde toplam en az 5 makale', $sciMakale, 5,
                madde: 'Madde 7/d-i'),
            Kalip::adet('Bunlardan en az 1\'inde başlıca yazar olmalısınız', $sciMakale, 1,
                'baslica', madde: 'Madde 7/d-i'),
            Kalip::adet('En az 1\'i Web of Science Q1 veya Q2 çeyrekliğindeki bir dergide',
                ['1a-Q1', '1a-Q2'], 1, madde: 'Madde 7/d-i'),
            Kalip::adet('Başarıyla tamamlanmış en az 1 bilimsel araştırma projesinin yürütücüsü '
                .'olmak', ['7a-y', '7d'], 1, madde: 'Madde 7/d-i'),
            Kalip::beyan('SCIE/SSCI dergilerdeki eserlerinize Web of Science taranan yayınlarda '
                .'en az 20 atıf yapılmış olması', 'Madde 7/d-i'),
            $dilBeyani,
        ]),
    ],
    [
        'anahtar' => 'galatasaray-docent-fen',
        'aday_notu' => $indirimNotu,
        'universite' => 'Galatasaray Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['fen'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 7/ç: ÜAK birim puanlarıyla en az 110 puan (Ek 1 faaliyeti varsa 100). '
            .'Madde 7/d-ii: 3 SCIE makalesi, 1\'inde başlıca yazar, 10 atıf, 1 proje '
            .'yürütücülüğü.',
        'sart' => Kalip::ve('Doçent — Fen Bilimleri ve Matematik', [
            Kalip::toplam(110),
            Kalip::adet('SCIE dergilerinde toplam en az 3 makale', $sciMakale, 3,
                madde: 'Madde 7/d-ii'),
            Kalip::adet('Bunlardan en az 1\'inde başlıca yazar olmalısınız', $sciMakale, 1,
                'baslica', madde: 'Madde 7/d-ii'),
            Kalip::adet('Başarıyla tamamlanmış en az 1 bilimsel araştırma projesinin yürütücüsü '
                .'olmak', ['7a-y', '7d'], 1, madde: 'Madde 7/d-ii'),
            Kalip::beyan('SCIE/SSCI dergilerdeki eserlerinize Web of Science taranan yayınlarda '
                .'en az 10 atıf yapılmış olması', 'Madde 7/d-ii'),
            $dilBeyani,
        ]),
    ],
    [
        'anahtar' => 'galatasaray-docent-sosyal',
        'aday_notu' => $indirimNotu,
        'universite' => 'Galatasaray Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['sosyal'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 7/ç: ÜAK birim puanlarıyla en az 110 puan (Ek 1 faaliyeti varsa 100). '
            .'Madde 7/d-iii: 4 uluslararası özgün yayın, 1 SCIE/SSCI/AHCI makalesinde başlıca '
            .'yazar, 20 atıf, 1 proje yürütücülüğü.',
        'sart' => Kalip::ve('Doçent — Sosyal, Beşeri ve İdari Bilimler', [
            Kalip::toplam(110),
            Kalip::adet('Toplam en az 4 uluslararası özgün yayın', $uluslararasiYayin, 4,
                madde: 'Madde 7/d-iii'),
            Kalip::adet('SCIE, SSCI veya AHCI dergisinde başlıca yazar olduğunuz en az 1 makale',
                $sciMakale, 1, 'baslica', madde: 'Madde 7/d-iii'),
            Kalip::adet('Başarıyla tamamlanmış en az 1 bilimsel araştırma projesinin yürütücüsü '
                .'olmak', ['7a-y', '7d'], 1, madde: 'Madde 7/d-iii'),
            Kalip::beyan('Uluslararası veya ulusal özgün yayınlarınıza en az 20 atıf yapılmış '
                .'olması', 'Madde 7/d-iii'),
            $dilBeyani,
        ]),
    ],
    [
        'anahtar' => 'galatasaray-docent-hukuk',
        'aday_notu' => 'Hukuk ve Filoloji alanlarında proje yürütücülüğü şartı YOK; diğer üç '
            .'alanda var. '.$indirimNotu,
        'universite' => 'Galatasaray Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['hukuk', 'filoloji'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 7/ç: ÜAK birim puanlarıyla en az 110 puan (Ek 1 faaliyeti varsa 100). '
            .'Madde 7/d-iv ve d-v: 1 uluslararası özgün yayın, toplam 5 uluslararası/ulusal '
            .'özgün yayın, 20 atıf.',
        'sart' => Kalip::ve('Doçent — Hukuk ve Filoloji', [
            Kalip::toplam(110),
            Kalip::adet('Toplam en az 5 uluslararası veya ulusal özgün yayın',
                $ulusalUluslararasiYayin, 5, madde: 'Madde 7/d-iv'),
            Kalip::adet('Bunlardan en az 1\'i uluslararası özgün yayın olmalı',
                $uluslararasiYayin, 1, madde: 'Madde 7/d-iv'),
            Kalip::beyan('Uluslararası veya ulusal özgün yayınlarınıza toplam en az 20 atıf '
                .'yapılmış olması', 'Madde 7/d-iv'),
            $dilBeyani,
        ]),
    ],

    // ══════════ PROFESÖR (Madde 8) ══════════
    [
        'anahtar' => 'galatasaray-profesor-muhendislik',
        'aday_notu' => 'Profesörlükte bütün koşullar DOÇENTLİK SONRASI çalışmalarla sağlanmalı. '
            .'Mühendislikte ayrıca 40 atıf, WOS h-indeksi en az 5 ve iki tamamlanmış proje '
            .'yürütücülüğü isteniyor; h-indeksi burada hesaplanamadığı için beyan. '.$indirimNotu,
        'universite' => 'Galatasaray Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['muhendislik'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 8/e: doçentlik sonrası ÜAK birim puanlarıyla en az 110 puan (Ek 1 '
            .'faaliyeti varsa 100). Madde 8/f-i: 5 makale, 2\'sinde başlıca yazar, 1\'i Q1-Q2\'de, '
            .'40 atıf, h-indeks 5, 2 proje yürütücülüğü.',
        'sart' => Kalip::ve('Profesör — Mühendislik', [
            Kalip::toplam(110, $DOC),
            Kalip::adet('Doçentliğinizden sonra SCIE veya SSCI dergilerinde toplam en az 5 makale',
                $sciMakale, 5, donem: $DOC, madde: 'Madde 8/f-i'),
            Kalip::adet('Bunlardan en az 2\'sinde başlıca yazar olmalısınız', $sciMakale, 2,
                'baslica', $DOC, madde: 'Madde 8/f-i'),
            Kalip::adet('En az 1\'i Web of Science Q1 veya Q2 çeyrekliğindeki bir dergide',
                ['1a-Q1', '1a-Q2'], 1, donem: $DOC, madde: 'Madde 8/f-i'),
            Kalip::adet('Başarıyla tamamlanmış en az 2 bilimsel araştırma projesinin yürütücüsü '
                .'olmak', ['7a-y', '7d'], 2, donem: $DOC, madde: 'Madde 8/f-i'),
            Kalip::beyan('SCIE/SSCI dergilerdeki eserlerinize Web of Science taranan yayınlarda '
                .'en az 40 atıf yapılmış olması ve WOS h-indeks değerinizin en az 5 olması',
                'Madde 8/f-i'),
            Kalip::beyan('Lisansüstü programlarda ders vermiş ve lisansüstü tez yöneticiliğini '
                .'üstlenip sonuçlandırmış olmak', 'Madde 8/ç-d'),
            $dilBeyani,
        ]),
    ],
    [
        'anahtar' => 'galatasaray-profesor-fen',
        'aday_notu' => 'Profesörlükte bütün koşullar DOÇENTLİK SONRASI çalışmalarla sağlanmalı. '
            .$indirimNotu,
        'universite' => 'Galatasaray Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['fen'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 8/e: doçentlik sonrası ÜAK birim puanlarıyla en az 110 puan (Ek 1 '
            .'faaliyeti varsa 100). Madde 8/f-ii: doçentlik sonrası SCIE makalelerinde başlıca '
            .'yazarlık ve 20 atıf.',
        'sart' => Kalip::ve('Profesör — Fen Bilimleri ve Matematik', [
            Kalip::toplam(110, $DOC),
            Kalip::adet('Doçentliğinizden sonra SCIE dergilerinde başlıca yazar olduğunuz en az '
                .'1 makale', $sciMakale, 1, 'baslica', $DOC, madde: 'Madde 8/f-ii'),
            Kalip::beyan('SCIE/SSCI dergilerdeki eserlerinize Web of Science taranan yayınlarda '
                .'en az 20 atıf yapılmış olması', 'Madde 8/f-ii'),
            Kalip::beyan('Lisansüstü programlarda ders vermiş ve lisansüstü tez yöneticiliğini '
                .'üstlenip sonuçlandırmış olmak', 'Madde 8/ç-d'),
            $dilBeyani,
        ]),
    ],
    [
        'anahtar' => 'galatasaray-profesor-sosyal',
        'aday_notu' => 'Profesörlükte bütün koşullar DOÇENTLİK SONRASI çalışmalarla sağlanmalı. '
            .$indirimNotu,
        'universite' => 'Galatasaray Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['sosyal', 'hukuk', 'filoloji'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 8/e: doçentlik sonrası ÜAK birim puanlarıyla en az 110 puan (Ek 1 '
            .'faaliyeti varsa 100). Madde 8/c: doçentlik sonrası çalışmalarla ÜAK doçentlik '
            .'başvuru şartlarını sağlamış olmak.',
        'sart' => Kalip::ve('Profesör — Sosyal Bilimler, Hukuk ve Filoloji', [
            Kalip::toplam(110, $DOC),
            Kalip::adet('Doçentliğinizden sonra en az 1 uluslararası özgün yayın',
                $uluslararasiYayin, 1, donem: $DOC, madde: 'Madde 8/c'),
            Kalip::beyan('Doçent unvanını aldıktan sonraki çalışmalarınızla, başvuru tarihinde '
                .'yürürlükte olan ÜAK Doçentlik Sınavı Başvuru Şartlarını sağlamış olmak '
                .'(lisansüstü tezlerden üretilmiş yayınlara ilişkin asgari koşullar hariç)',
                'Madde 8/c'),
            Kalip::beyan('Lisansüstü programlarda ders vermiş ve lisansüstü tez yöneticiliğini '
                .'üstlenip sonuçlandırmış olmak', 'Madde 8/ç-d'),
            $dilBeyani,
        ]),
    ],
];
