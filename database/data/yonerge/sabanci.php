<?php

/**
 * SABANCI ÜNİVERSİTESİ — şart ağaçları.
 *
 * Kaynak: pdf/17537103422.sabanciuniversitesi.pdf · EK-1 MDBF
 * Cetvel: database/data/cetvel/sabanci-mdbf-turler.php (puansız tür sözlüğü)
 *
 * ARKETİP: program bazlı eşik + KOTALI EŞDEĞERLİK. Eşik `birim` düzeyinde
 * (fakülte değil, program); eşdeğerlik kuralları hem oran hem azami kullanım
 * taşıyor ("iki Q3/Q4 yayın bir makale sayılır, bu koşul en fazla bir makale
 * için kullanılabilir") ve iki kota birbirinden bağımsız.
 *
 * Yazılan dilim: MDBF / Bilgisayar Bilimleri ve Mühendisliği Programı, üç kadro.
 * MDBF'in diğer programları ve diğer fakülteler henüz girilmedi.
 *
 * NOT: `alan` null — Sabancı kriterleri ÜAK temel alanına göre değil programa
 * göre tanımlı. Arayüz temel alanla eşleştirdiği için şimdilik mühendislik ve
 * fen alanlarına bağlandı; doğrusu `birim` seçimiyle eşleştirmek.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · şema: sart-agaci-taslak.php
 */

use App\Services\Scoring\Sart\Kalip;

$birim = 'MDBF — Bilgisayar Bilimleri ve Mühendisliği Programı';
$birimEmf = 'MDBF — Endüstri Mühendisliği / Matematik / Fizik Programları';
$birimMalzeme = 'MDBF — Malzeme Bilimi ve Nano Müh. / Moleküler Biyoloji, Genetik ve '
    .'Biyomüh. / Mekatronik Müh. / Elektronik Müh. Programları';
$birimArastirma = 'MDBF Tüm Programlar — Araştırma ve Uygulama Ağırlıklı';
$birimEkonomi = 'SSBF — Ekonomi / Siyaset Bilimi / Psikoloji Programları';
$birimKultur = 'SSBF — Kültürel Çalışmalar ve Tarih Programları';
$birimGorsel = 'SSBF — Görsel Sanatlar ve Görsel İletişim Tasarımı Programı';
$birimYbf = 'YBF — Yönetim Bilimleri Fakültesi';
$birimEgitim = 'Eğitim Ağırlıklı Kariyer Gelişim Yolu (tüm fakülteler)';
$birimSsbfArastirma = 'SSBF Tüm Programlar — Araştırma ve Uygulama Ağırlıklı';
$birimYbfArastirma = 'YBF — Araştırma ve Uygulama Ağırlıklı';

/**
 * EK-4 ikameleri. Diğer üç Sabancı bloğundan farkı: sanatsal sergi de makale
 * şartını karşılayabiliyor.
 *
 * @var list<array<string, mixed>>
 */
$egitimIkameler = [
    ['aciklama' => 'FT50 / AJG 4+ dergide 1 makale 2 makale sayılır', 'kaynak' => ['SU-EFT'],
        'kaynak_adet' => 1, 'hedef_adet' => 2, 'azami' => 4, 'kota_grubu' => null],
    ['aciklama' => 'CERES A veya B kategori kitap 2 makale sayılır', 'kaynak' => ['SU-ECERES'],
        'kaynak_adet' => 1, 'hedef_adet' => 2, 'azami' => 4, 'kota_grubu' => null],
    ['aciklama' => 'Prestijli solo sergi makale şartı yerine sayılır', 'kaynak' => ['SU-ESOLO'],
        'kaynak_adet' => 1, 'hedef_adet' => 1, 'azami' => 6, 'kota_grubu' => 'sergi'],
    ['aciklama' => 'Prestijli uluslararası solo sergi veya bienal 2 solo sergi sayılır', 'kaynak' => ['SU-EBIENAL'],
        'kaynak_adet' => 1, 'hedef_adet' => 2, 'azami' => 6, 'kota_grubu' => 'sergi'],
];

/**
 * EK-4 giriş koşulları — iki kadroda da aynı.
 *
 * @return list<array<string, mixed>>
 */
$egitimGiris = [
    Kalip::beyan('Doçent veya profesör olarak Sabancı Üniversitesinde en az 10 yıl istihdam edilmiş olmak'),
    Kalip::beyan('Periyodik gözden geçirmelerin en az yarısında başarılı, en fazla bir kez yetersiz değerlendirme almış olmak'),
    Kalip::beyan('Arka arkaya en az 5 akademik yıl fakültenin en üst %10 diliminde yer almak ya da eğitim alanında ulusal tanınırlığa sahip olmak'),
];

/**
 * EK-4 kriter listesi — doçentte en az 2, profesörde en az 4.
 *
 * @return array<string, mixed>
 */
$egitimKriterler = fn (int $k): array => Kalip::kIle("Aşağıdaki kriterlerden en az {$k} tanesini sağlamalısınız", $k, [
    Kalip::beyan('Ders içeriği tasarımına veya profesyonel eğitim programlarına katkı, yenilikçi ders tasarımı'),
    Kalip::beyan('Lisansüstü programlara katkı ve bu düzeyde tez/proje danışmanlığı'),
    Kalip::beyan('Lisans düzeyindeki projelerde düzenli danışmanlık'),
    Kalip::beyan('Akademik bilgi ile sektörel uygulama arasında entegrasyon, endüstriyel ortaklık, organizasyon liderliği'),
    Kalip::beyan('Saygın uluslararası yayınlarda yazı yazmış olmak ya da prestijli atıf almak'),
    Kalip::beyan('Akademi dışı önemli kurumlarda yönetim veya danışma kurulu görevi'),
]);

/**
 * YBF'nin tek makale ikamesi: FT50 listesindeki ve Academic Journal Guide'da
 * en az 4 puan almış dergilerde yayımlanan her makale 2 SSCI makalesi sayılır.
 *
 * @var list<array<string, mixed>>
 */
$ybfIkameler = [
    ['aciklama' => 'FT50 / AJG 4+ dergide 1 makale 2 SSCI makalesi sayılır', 'kaynak' => ['SU-FT50'],
        'kaynak_adet' => 1, 'hedef_adet' => 2, 'azami' => 6, 'kota_grubu' => null],
];

/**
 * YBF'nin doçent ve profesörde tekrarlayan "en az N başarı" listesi.
 *
 * @return array<string, mixed>
 */
$ybfBasarilar = fn (int $k): array => Kalip::kIle("Aşağıdaki başarılardan en az {$k} tanesini sağlamalısınız", $k, [
    Kalip::beyan('Tamamlanmış TÜBİTAK projesinde yürütücülük veya araştırmacılık'),
    Kalip::beyan('AB veya ABD projesinde yürütücülük, ortaklık ya da araştırmacılık'),
    Kalip::beyan('FT50 listesindeki dergide yayımlanmış makale'),
    Kalip::beyan('Web of Science "highly cited" tanımına giren makale'),
    Kalip::beyan('Uluslararası saygın yayınevi için kitap editörlüğü'),
    Kalip::beyan('Uluslararası saygın yayınevinden kitap veya kitap bölümü'),
    Kalip::beyan('Patent'),
    Kalip::beyan('Uluslararası veya ulusal saygın bilimsel ödül ya da burs'),
    Kalip::beyan('Eğitim ödülü'),
    Kalip::beyan('SU Eğitim Ödüllerinde ilk üçe girmek (kurum içi yükseltmeler için)'),
    Kalip::beyan('Yenilikçi ders tasarımı'),
    Kalip::beyan('Uluslararası tanınmışlık (keynote, editörlük, program komitesi, fellowship)'),
    Kalip::beyan('Profesyonel veya yönetici geliştirme eğitimlerine kayda değer katkı'),
    Kalip::beyan('Şirket, devlet ya da STK\'lara kayda değer danışmanlık'),
    Kalip::beyan('Çalıştay veya konferans organizasyonuna katkı'),
]);

/**
 * SSBF'nin makale ikameleri. Çeyreklik ve CERES kitap kategorileri farklı
 * ağırlıkta sayılıyor; kitap editörlüğü ve CERES'te olmayan kitap sayılmaz.
 *
 * @return list<array<string, mixed>>
 */
$ssbfIkameler = [
    ['aciklama' => 'Alan endeksinin ilk çeyreğindeki dergide 1 makale 2 makale sayılır',
        'kaynak' => ['SU-S1Q1'], 'kaynak_adet' => 1, 'hedef_adet' => 2, 'azami' => 4, 'kota_grubu' => null],
    ['aciklama' => 'CERES A kategori kitap 3 makale sayılır', 'kaynak' => ['SU-CA'],
        'kaynak_adet' => 1, 'hedef_adet' => 3, 'azami' => 3, 'kota_grubu' => 'ceres'],
    ['aciklama' => 'CERES B kategori kitap 2 makale sayılır', 'kaynak' => ['SU-CB'],
        'kaynak_adet' => 1, 'hedef_adet' => 2, 'azami' => 3, 'kota_grubu' => 'ceres'],
    ['aciklama' => 'CERES C/D/E kategori kitap 1 makale sayılır', 'kaynak' => ['SU-CCDE'],
        'kaynak_adet' => 1, 'hedef_adet' => 1, 'azami' => 3, 'kota_grubu' => 'ceres'],
];

/**
 * SSBF'nin doçent ve profesörde tekrarlayan "en az N başarı" listesi.
 *
 * @return array<string, mixed>
 */
$ssbfBasarilar = fn (int $k): array => Kalip::kIle("Aşağıdaki başarılardan en az {$k} tanesini sağlamalısınız", $k, [
    Kalip::beyan('Uluslararası veya ulusal ödül ya da burs'),
    Kalip::beyan('Saygın uluslararası üniversitede davetli konuşmacılık (en çok bir kez sayılır)'),
    Kalip::beyan('Yurt dışı saygın üniversitelerde eşdeğer pozisyona atananlarla benzer h-indeksi'),
    Kalip::beyan('Uluslararası tanınmışlık (keynote, editörlük, program komitesi, fellowship)'),
    Kalip::beyan('Eğitim ödülü'),
    Kalip::beyan('SU Eğitim Ödüllerinde ilk üçe girmek (kurum içi yükseltmeler için)'),
    Kalip::beyan('Çalışmaların medyada tanınırlığı (en çok bir kez sayılır)'),
    Kalip::beyan('Tamamlanmış TÜBİTAK projesinde yürütücülük veya araştırmacılık'),
    Kalip::beyan('AB veya ABD projesinde yürütücülük, ortaklık ya da araştırmacılık'),
    Kalip::beyan('Patent'),
    Kalip::beyan('CERES A/B kitap editörlüğü, o kitaplarda bölüm ya da kategorize Türkçe kitap (en çok bir kez)'),
    Kalip::beyan('Çalıştay veya konferans organizasyonuna katkı'),
]);

/**
 * "İki Q3/Q4 yayın / iki konferans / iki kitap bölümü bir makale sayılır" —
 * üçü TEK kotayı paylaşır. Yüksek etkili konferans ise ayrı kotada.
 *
 * @return list<array<string, mixed>>
 */
$ikameler = fn (int $azami): array => [
    ['aciklama' => '2 adet Q3/Q4 yayın 1 makaleye denk', 'kaynak' => ['SU-M2'],
        'kaynak_adet' => 2, 'hedef_adet' => 1, 'azami' => $azami, 'kota_grubu' => 'ikame-a'],
    ['aciklama' => '2 adet WoS/SCOPUS listeli konferans 1 makaleye denk', 'kaynak' => ['SU-K1'],
        'kaynak_adet' => 2, 'hedef_adet' => 1, 'azami' => $azami, 'kota_grubu' => 'ikame-a'],
    ['aciklama' => '2 adet saygın yayınevi kitap bölümü 1 makaleye denk', 'kaynak' => ['SU-B1'],
        'kaynak_adet' => 2, 'hedef_adet' => 1, 'azami' => $azami, 'kota_grubu' => 'ikame-a'],
    ['aciklama' => 'Yüksek etki değerli konferans yayını 1 makale sayılır (bağımsız kota)',
        'kaynak' => ['SU-K2'], 'kaynak_adet' => 1, 'hedef_adet' => 1, 'azami' => $azami,
        'kota_grubu' => 'ikame-b'],
];

$alanlar = ['muhendislik', 'fen'];

return [

    [
        'anahtar' => 'sabanci-dr-mdbf-cs',
        'aday_notu' => 'Bu yönerge eşdeğerlik tanıyor: iki projede araştırmacılık bir yürütücülüğe, iki eş danışmanlık bir baş danışmanlığa sayılabiliyor. Kotalar sınırlı, sistem bunları otomatik uyguluyor.',
        'universite' => 'Sabancı Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => 'sabanci-turler',
        'notlar' => 'EK-1 MDBF, "EĞİTİM ve ARAŞTIRMA AĞIRLIKLI ÖĞRETİM ÜYESİ / DR. ÖĞRETİM ÜYESİ". '
            .'Yönerge ikinci eşdeğerlik için açıkça "üstteki maddeden bağımsız şekilde en fazla '
            .'bir bilimsel makale için kullanılabilir" diyor.',
        'sart' => Kalip::adet(
            'Q1/Q2 (veya SNIP ≥ 1.0) dergilerde en az 3 bilimsel makale',
            ['SU-M1'],
            3,
        ) + ['donusumler' => $ikameler(1)],
    ],

    [
        'anahtar' => 'sabanci-docent-mdbf-cs',
        'aday_notu' => 'Bu yönerge eşdeğerlik tanıyor: iki projede araştırmacılık bir yürütücülüğe, iki eş danışmanlık bir baş danışmanlığa sayılabiliyor. Kotalar sınırlı, sistem bunları otomatik uyguluyor.',
        'universite' => 'Sabancı Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => 'sabanci-turler',
        'notlar' => 'EK-1 MDBF / DOÇENT. Proje ve tez koşullarının kendi eşdeğerlikleri var: '
            .'"İki projede araştırmacı olmak bir proje yürütücülüğüne eşdeğer olarak '
            .'değerlendirilebilir." · "İki eş danışmanlık bir baş danışmanlığa eşdeğer olarak '
            .'değerlendirilebilir. Bu koşul en fazla bir lisansüstü tez baş danışmanlığı için '
            .'kullanılabilir."',
        'sart' => Kalip::ve('Doçent asgari şartları', [
            Kalip::adet('Q1/Q2 (veya SNIP ≥ 1.0) dergilerde en az 8 makale', ['SU-M1'], 8)
                + ['donusumler' => $ikameler(2)],
            Kalip::adet('Bu makalelerin en az 3\'ü doktora tezinden üretilmemiş olmalı', ['SU-M1'], 3)
                + ['haric' => ['doktora_tezinden']],
            Kalip::metrik('Lisans ve lisansüstü seviyede ders vermiş olmak', 'ders_yariyil', 1),
            Kalip::metrik('En az 1 yıl öğrenci desteği olan 2 TÜBİTAK/AB/ÜSİ projesinde yürütücülük', 'proje_yurutuculuk', 2)
                + ['donusumler' => [
                    ['aciklama' => '2 projede araştırmacılık 1 yürütücülüğe denk', 'kaynak' => ['proje_arastirmaci'],
                        'kaynak_adet' => 2, 'hedef_adet' => 1, 'azami' => 2, 'kota_grubu' => null],
                    ['aciklama' => '4 projede danışmanlık 1 yürütücülüğe denk', 'kaynak' => ['proje_danisman'],
                        'kaynak_adet' => 4, 'hedef_adet' => 1, 'azami' => 2, 'kota_grubu' => null],
                ]],
            Kalip::beyan('Projelerden en az biri tamamlanmış olmalı; 1 AB Çerçeve/ERC projesi tüm proje koşulunu karşılar'),
            Kalip::metrik('Bitmiş en az 3 lisansüstü tezde baş danışmanlık', 'tez_danismanlik', 3)
                + ['donusumler' => [
                    ['aciklama' => '2 eş danışmanlık 1 baş danışmanlığa denk (en fazla 1 tez için)',
                        'kaynak' => ['tez_es_danismanlik'],
                        'kaynak_adet' => 2, 'hedef_adet' => 1, 'azami' => 1, 'kota_grubu' => null],
                ]],
        ]),
    ],

    [
        'anahtar' => 'sabanci-profesor-mdbf-cs',
        'aday_notu' => 'Bu yönerge eşdeğerlik tanıyor: iki projede araştırmacılık bir yürütücülüğe, iki eş danışmanlık bir baş danışmanlığa sayılabiliyor. Kotalar sınırlı, sistem bunları otomatik uyguluyor.',
        'universite' => 'Sabancı Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => 'sabanci-turler',
        'notlar' => 'EK-1 MDBF / PROFESÖR. Muafiyet: "Doçent unvanını 1.1.2016 tarihinden önce alan '
            .'öğretim üyeleri için, doktora tezi baş danışmanlığı şartı aranmaz."',
        'sart' => Kalip::ve('Profesör asgari şartları', [
            Kalip::adet('Q1/Q2 (veya SNIP ≥ 1.0) dergilerde en az 16 makale', ['SU-M1'], 16)
                + ['donusumler' => $ikameler(3)],
            Kalip::adet('Bunların en az 8\'i doçentlik sonrası üretilmiş olmalı', ['SU-M1'], 8, donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::metrik('Lisans ve lisansüstü seviyede ders vermiş olmak', 'ders_yariyil', 1),
            Kalip::metrik('En az 4 TÜBİTAK/AB/ÜSİ projesinde yürütücülük', 'proje_yurutuculuk', 4)
                + ['donusumler' => [
                    ['aciklama' => '1 AB Çerçeve Programı projesi 2 proje yerine sayılır', 'kaynak' => ['proje_ab'],
                        'kaynak_adet' => 1, 'hedef_adet' => 2, 'azami' => 4, 'kota_grubu' => null],
                    ['aciklama' => '2 projede araştırmacılık 1 yürütücülüğe denk', 'kaynak' => ['proje_arastirmaci'],
                        'kaynak_adet' => 2, 'hedef_adet' => 1, 'azami' => 4, 'kota_grubu' => null],
                ]],
            Kalip::beyan('Projelerden en az üçü tamamlanmış olmalı'),
            Kalip::metrik('Bitmiş en az 5 lisansüstü tezde baş danışmanlık', 'tez_danismanlik', 5)
                + ['donusumler' => [
                    ['aciklama' => '2 eş danışmanlık 1 baş danışmanlığa denk (en fazla 1 tez için)',
                        'kaynak' => ['tez_es_danismanlik'],
                        'kaynak_adet' => 2, 'hedef_adet' => 1, 'azami' => 1, 'kota_grubu' => null],
                ]],
            Kalip::metrik('Bunlardan en az 1\'i doktora tezi baş danışmanlığı olmalı', 'doktora_tez_danismanlik', 1)
                + ['telafi' => Kalip::beyan('Doçent unvanı 1.1.2016 tarihinden önce alınmışsa bu şart aranmaz')],
        ]),
    ],
    [
        'anahtar' => 'sabanci-dr-mdbf-emf',
        'aday_notu' => 'Bu yönerge eşdeğerlik tanıyor: iki Q3/Q4 yayın, iki uluslararası konferans '
            .'ya da iki kitap bölümü bir makaleye; iki projede araştırmacılık bir yürütücülüğe; iki eş '
            .'danışmanlık bir baş danışmanlığa sayılabiliyor. Kotalar sınırlı, sistem otomatik uyguluyor.',
        'universite' => 'Sabancı Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'birim' => $birimEmf,
        'cetvel' => 'sabanci-turler',
        'notlar' => 'EK-1 MDBF / Endüstri Mühendisliği / Matematik / Fizik Programları, DR. ÖĞRETİM ÜYESİ.',
        'sart' => Kalip::ve('Endüstri Mühendisliği / Matematik / Fizik — Dr. Öğr. Üyesi', [
            Kalip::adet('Q1/Q2 (veya SNIP ≥ 1.0) dergilerde en az 3 bilimsel makale', ['SU-M1'], 3)
                + ['donusumler' => $ikameler(1)],
        ]),
    ],
    [
        'anahtar' => 'sabanci-docent-mdbf-emf',
        'aday_notu' => 'Bu yönerge eşdeğerlik tanıyor: iki Q3/Q4 yayın, iki uluslararası konferans '
            .'ya da iki kitap bölümü bir makaleye; iki projede araştırmacılık bir yürütücülüğe; iki eş '
            .'danışmanlık bir baş danışmanlığa sayılabiliyor. Kotalar sınırlı, sistem otomatik uyguluyor.',
        'universite' => 'Sabancı Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'birim' => $birimEmf,
        'cetvel' => 'sabanci-turler',
        'notlar' => 'EK-1 MDBF / Endüstri Mühendisliği / Matematik / Fizik Programları, DOÇENT.',
        'sart' => Kalip::ve('Endüstri Mühendisliği / Matematik / Fizik — Doçent', [
            Kalip::adet('Q1/Q2 (veya SNIP ≥ 1.0) dergilerde en az 8 makale', ['SU-M1'], 8)
                + ['donusumler' => $ikameler(2)],
            Kalip::adet('Bu makalelerin en az 3\'ü doktora tezinden üretilmemiş olmalı', ['SU-M1'], 3)
                + ['haric' => ['doktora_tezinden']],
            Kalip::metrik('Lisans ve lisansüstü seviyede ders vermiş olmak', 'ders_yariyil', 1),
            Kalip::metrik('Kapsamında en az 1 yıl öğrenci desteği olan 1 TÜBİTAK/AB/ÜSİ projesinde yürütücülük', 'proje_yurutuculuk', 1)
                + ['donusumler' => [
                    ['aciklama' => '2 projede araştırmacılık 1 yürütücülüğe denk', 'kaynak' => ['proje_arastirmaci'],
                        'kaynak_adet' => 2, 'hedef_adet' => 1, 'azami' => 2, 'kota_grubu' => null],
                    ['aciklama' => '4 projede danışmanlık 1 yürütücülüğe denk', 'kaynak' => ['proje_danisman'],
                        'kaynak_adet' => 4, 'hedef_adet' => 1, 'azami' => 2, 'kota_grubu' => null],
                ]],
            Kalip::beyan('Projelerden en az biri tamamlanmış olmalı'),
            Kalip::metrik('Bitmiş en az 2 lisansüstü tezde baş danışmanlık', 'tez_danismanlik', 2)
                + ['donusumler' => [
                    ['aciklama' => '2 eş danışmanlık 1 baş danışmanlığa denk (en fazla 1 tez için)',
                        'kaynak' => ['tez_es_danismanlik'],
                        'kaynak_adet' => 2, 'hedef_adet' => 1, 'azami' => 1, 'kota_grubu' => null],
                ]],
        ]),
    ],
    [
        'anahtar' => 'sabanci-profesor-mdbf-emf',
        'aday_notu' => 'Bu yönerge eşdeğerlik tanıyor: iki Q3/Q4 yayın, iki uluslararası konferans '
            .'ya da iki kitap bölümü bir makaleye; iki projede araştırmacılık bir yürütücülüğe; iki eş '
            .'danışmanlık bir baş danışmanlığa sayılabiliyor. Kotalar sınırlı, sistem otomatik uyguluyor.',
        'universite' => 'Sabancı Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'birim' => $birimEmf,
        'cetvel' => 'sabanci-turler',
        'notlar' => 'EK-1 MDBF / Endüstri Mühendisliği / Matematik / Fizik Programları, PROFESÖR.',
        'sart' => Kalip::ve('Endüstri Mühendisliği / Matematik / Fizik — Profesör', [
            Kalip::adet('Q1/Q2 (veya SNIP ≥ 1.0) dergilerde en az 16 makale', ['SU-M1'], 16)
                + ['donusumler' => $ikameler(3)],
            Kalip::adet('Bunların en az 8\'i doçentlik sonrası üretilmiş olmalı', ['SU-M1'], 8, donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::metrik('Lisans ve lisansüstü seviyede ders vermiş olmak', 'ders_yariyil', 1),
            Kalip::metrik('Kapsamında en az 1 yıl öğrenci desteği olan 3 TÜBİTAK/AB/ÜSİ projesinde yürütücülük', 'proje_yurutuculuk', 3)
                + ['donusumler' => [
                    ['aciklama' => '2 projede araştırmacılık 1 yürütücülüğe denk', 'kaynak' => ['proje_arastirmaci'],
                        'kaynak_adet' => 2, 'hedef_adet' => 1, 'azami' => 4, 'kota_grubu' => null],
                    ['aciklama' => '4 projede danışmanlık 1 yürütücülüğe denk', 'kaynak' => ['proje_danisman'],
                        'kaynak_adet' => 4, 'hedef_adet' => 1, 'azami' => 4, 'kota_grubu' => null],
                ]],
            Kalip::beyan('Projelerden gerekli sayıda olanı tamamlanmış olmalı'),
            Kalip::metrik('Bitmiş en az 4 lisansüstü tezde baş danışmanlık', 'tez_danismanlik', 4)
                + ['donusumler' => [
                    ['aciklama' => '2 eş danışmanlık 1 baş danışmanlığa denk (en fazla 1 tez için)',
                        'kaynak' => ['tez_es_danismanlik'],
                        'kaynak_adet' => 2, 'hedef_adet' => 1, 'azami' => 1, 'kota_grubu' => null],
                ]],
            Kalip::metrik('Bunlardan en az 1\'i doktora tezi baş danışmanlığı olmalı', 'doktora_tez_danismanlik', 1),
        ]),
    ],
    [
        'anahtar' => 'sabanci-dr-mdbf-malzeme',
        'aday_notu' => 'Bu yönerge eşdeğerlik tanıyor: iki Q3/Q4 yayın, iki uluslararası konferans '
            .'ya da iki kitap bölümü bir makaleye; iki projede araştırmacılık bir yürütücülüğe; iki eş '
            .'danışmanlık bir baş danışmanlığa sayılabiliyor. Kotalar sınırlı, sistem otomatik uyguluyor.',
        'universite' => 'Sabancı Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'birim' => $birimMalzeme,
        'cetvel' => 'sabanci-turler',
        'notlar' => 'EK-1 MDBF / Malzeme Bilimi / MolBiyo / Mekatronik / Elektronik Programları, DR. ÖĞRETİM ÜYESİ.',
        'sart' => Kalip::ve('Malzeme Bilimi / MolBiyo / Mekatronik / Elektronik — Dr. Öğr. Üyesi', [
            Kalip::adet('Q1/Q2 (veya SNIP ≥ 1.0) dergilerde en az 3 bilimsel makale', ['SU-M1'], 3)
                + ['donusumler' => $ikameler(1)],
        ]),
    ],
    [
        'anahtar' => 'sabanci-docent-mdbf-malzeme',
        'aday_notu' => 'Bu yönerge eşdeğerlik tanıyor: iki Q3/Q4 yayın, iki uluslararası konferans '
            .'ya da iki kitap bölümü bir makaleye; iki projede araştırmacılık bir yürütücülüğe; iki eş '
            .'danışmanlık bir baş danışmanlığa sayılabiliyor. Kotalar sınırlı, sistem otomatik uyguluyor.',
        'universite' => 'Sabancı Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'birim' => $birimMalzeme,
        'cetvel' => 'sabanci-turler',
        'notlar' => 'EK-1 MDBF / Malzeme Bilimi / MolBiyo / Mekatronik / Elektronik Programları, DOÇENT.',
        'sart' => Kalip::ve('Malzeme Bilimi / MolBiyo / Mekatronik / Elektronik — Doçent', [
            Kalip::adet('Q1/Q2 (veya SNIP ≥ 1.0) dergilerde en az 8 makale', ['SU-M1'], 8)
                + ['donusumler' => $ikameler(2)],
            Kalip::adet('Bu makalelerin en az 3\'ü doktora tezinden üretilmemiş olmalı', ['SU-M1'], 3)
                + ['haric' => ['doktora_tezinden']],
            Kalip::metrik('Lisans ve lisansüstü seviyede ders vermiş olmak', 'ders_yariyil', 1),
            Kalip::metrik('Kapsamında en az 1 yıl öğrenci desteği olan 2 TÜBİTAK/AB/ÜSİ projesinde yürütücülük', 'proje_yurutuculuk', 2)
                + ['donusumler' => [
                    ['aciklama' => '2 projede araştırmacılık 1 yürütücülüğe denk', 'kaynak' => ['proje_arastirmaci'],
                        'kaynak_adet' => 2, 'hedef_adet' => 1, 'azami' => 2, 'kota_grubu' => null],
                    ['aciklama' => '4 projede danışmanlık 1 yürütücülüğe denk', 'kaynak' => ['proje_danisman'],
                        'kaynak_adet' => 4, 'hedef_adet' => 1, 'azami' => 2, 'kota_grubu' => null],
                ]],
            Kalip::beyan('Projelerden en az biri tamamlanmış olmalı'),
            Kalip::metrik('Bitmiş en az 3 lisansüstü tezde baş danışmanlık', 'tez_danismanlik', 3)
                + ['donusumler' => [
                    ['aciklama' => '2 eş danışmanlık 1 baş danışmanlığa denk (en fazla 1 tez için)',
                        'kaynak' => ['tez_es_danismanlik'],
                        'kaynak_adet' => 2, 'hedef_adet' => 1, 'azami' => 1, 'kota_grubu' => null],
                ]],
        ]),
    ],
    [
        'anahtar' => 'sabanci-profesor-mdbf-malzeme',
        'aday_notu' => 'Bu yönerge eşdeğerlik tanıyor: iki Q3/Q4 yayın, iki uluslararası konferans '
            .'ya da iki kitap bölümü bir makaleye; iki projede araştırmacılık bir yürütücülüğe; iki eş '
            .'danışmanlık bir baş danışmanlığa sayılabiliyor. Kotalar sınırlı, sistem otomatik uyguluyor.',
        'universite' => 'Sabancı Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'birim' => $birimMalzeme,
        'cetvel' => 'sabanci-turler',
        'notlar' => 'EK-1 MDBF / Malzeme Bilimi / MolBiyo / Mekatronik / Elektronik Programları, PROFESÖR.',
        'sart' => Kalip::ve('Malzeme Bilimi / MolBiyo / Mekatronik / Elektronik — Profesör', [
            Kalip::adet('Q1/Q2 (veya SNIP ≥ 1.0) dergilerde en az 16 makale', ['SU-M1'], 16)
                + ['donusumler' => $ikameler(3)],
            Kalip::adet('Bunların en az 8\'i doçentlik sonrası üretilmiş olmalı', ['SU-M1'], 8, donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::metrik('Lisans ve lisansüstü seviyede ders vermiş olmak', 'ders_yariyil', 1),
            Kalip::metrik('Kapsamında en az 1 yıl öğrenci desteği olan 4 TÜBİTAK/AB/ÜSİ projesinde yürütücülük', 'proje_yurutuculuk', 4)
                + ['donusumler' => [
                    ['aciklama' => '2 projede araştırmacılık 1 yürütücülüğe denk', 'kaynak' => ['proje_arastirmaci'],
                        'kaynak_adet' => 2, 'hedef_adet' => 1, 'azami' => 4, 'kota_grubu' => null],
                    ['aciklama' => '4 projede danışmanlık 1 yürütücülüğe denk', 'kaynak' => ['proje_danisman'],
                        'kaynak_adet' => 4, 'hedef_adet' => 1, 'azami' => 4, 'kota_grubu' => null],
                ]],
            Kalip::beyan('Projelerden gerekli sayıda olanı tamamlanmış olmalı'),
            Kalip::metrik('Bitmiş en az 5 lisansüstü tezde baş danışmanlık', 'tez_danismanlik', 5)
                + ['donusumler' => [
                    ['aciklama' => '2 eş danışmanlık 1 baş danışmanlığa denk (en fazla 1 tez için)',
                        'kaynak' => ['tez_es_danismanlik'],
                        'kaynak_adet' => 2, 'hedef_adet' => 1, 'azami' => 1, 'kota_grubu' => null],
                ]],
            Kalip::metrik('Bunlardan en az 1\'i doktora tezi baş danışmanlığı olmalı', 'doktora_tez_danismanlik', 1),
        ]),
    ],
    [
        'anahtar' => 'sabanci-dr-mdbf-arastirma',
        'aday_notu' => 'Bu, araştırma ve uygulama ağırlıklı AYRI bir kariyer yolu; yayın ve proje '
            .'eşikleri eğitim-araştırma ağırlıklı yoldan belirgin biçimde yüksek. Endüstriyel proje '
            .'ve liderlik koşulları belge ile teyit ediliyor.',
        'universite' => 'Sabancı Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'birim' => $birimArastirma,
        'cetvel' => 'sabanci-turler',
        'notlar' => 'EK-1 MDBF Tüm Programlar, ARAŞTIRMA ve UYGULAMA AĞIRLIKLI, DR. ÖĞRETİM ÜYESİ.',
        'sart' => Kalip::ve('MDBF Araştırma ve Uygulama Ağırlıklı — Dr. Öğr. Üyesi', [
            Kalip::adet('Q1/Q2 (veya SNIP ≥ 1.0) dergilerde en az 3 bilimsel makale', ['SU-M1'], 3)
                + ['donusumler' => $ikameler(1)],
            Kalip::beyan('Proje başvuru, ilerleme ve sonuç raporu süreçlerinde yer almış olmak'),
        ]),
    ],
    [
        'anahtar' => 'sabanci-docent-mdbf-arastirma',
        'aday_notu' => 'Bu, araştırma ve uygulama ağırlıklı AYRI bir kariyer yolu; yayın ve proje '
            .'eşikleri eğitim-araştırma ağırlıklı yoldan belirgin biçimde yüksek. Endüstriyel proje '
            .'ve liderlik koşulları belge ile teyit ediliyor.',
        'universite' => 'Sabancı Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'birim' => $birimArastirma,
        'cetvel' => 'sabanci-turler',
        'notlar' => 'EK-1 MDBF Tüm Programlar, DOÇENT. "En fazla 3 tanesi doktora tezinden üretilmiş olmak '
            .'kaydıyla … en az 13 bilimsel makale." DİKKAT: bu bir TAVAN (en fazla); motorun '
            .'`haric` mekanizması dışlama yapıyor, tavan koyamıyor — beyan olarak girildi.',
        'sart' => Kalip::ve('MDBF Araştırma ve Uygulama Ağırlıklı — Doçent', [
            Kalip::adet('Q1/Q2 (veya SNIP ≥ 1.0) dergilerde en az 13 bilimsel makale', ['SU-M1'], 13)
                + ['donusumler' => $ikameler(1)],
            Kalip::beyan('Bu makalelerin en fazla 3\'ü doktora tezinden üretilmiş olabilir'),
            Kalip::metrik('En az iki yıl öğrenci desteği sağlayan 3 TÜBİTAK/AB/ÜSİ projesinde yürütücülük', 'proje_yurutuculuk', 3)
                + ['donusumler' => [
                    ['aciklama' => '2 projede araştırmacılık 1 yürütücülüğe denk', 'kaynak' => ['proje_arastirmaci'],
                        'kaynak_adet' => 2, 'hedef_adet' => 1, 'azami' => 1, 'kota_grubu' => null],
                    ['aciklama' => '4 projede danışmanlık 1 yürütücülüğe denk', 'kaynak' => ['proje_danisman'],
                        'kaynak_adet' => 4, 'hedef_adet' => 1, 'azami' => 1, 'kota_grubu' => null],
                ]],
            Kalip::beyan('TÜBİTAK 1003 ölçeğinde alt proje yürütücülüğü bir yürütücülüğe, büyük ölçekli proje yürütücülüğü ikiye sayılabilir'),
            Kalip::beyan('Projelerden en az biri tamamlanmış / final raporu hazırlanmış olmalı'),
            Kalip::beyan('En az 2 endüstriyel projeye iştirak (en az birinde yürütücü veya eş yürütücü)'),
            Kalip::metrik('Dr. Öğr. Üyeliğinden sonra ortalama yılda 1 ders vermiş olmak', 'ders_yariyil', 1),
            Kalip::metrik('Bitmiş en az 3 yüksek lisans tezinde baş danışmanlık', 'tez_danismanlik', 3)
                + ['donusumler' => [
                    ['aciklama' => '2 eş danışmanlık 1 baş danışmanlığa denk (en fazla 1 tez için)',
                        'kaynak' => ['tez_es_danismanlik'],
                        'kaynak_adet' => 2, 'hedef_adet' => 1, 'azami' => 1, 'kota_grubu' => null],
                ]],
            Kalip::beyan('Ayrıca devam eden veya tamamlanan 2 yüksek lisans/doktora öğrencisine baş danışmanlık'),
        ]),
    ],
    [
        'anahtar' => 'sabanci-profesor-mdbf-arastirma',
        'aday_notu' => 'Bu, araştırma ve uygulama ağırlıklı AYRI bir kariyer yolu; yayın ve proje '
            .'eşikleri eğitim-araştırma ağırlıklı yoldan belirgin biçimde yüksek. Endüstriyel proje '
            .'ve liderlik koşulları belge ile teyit ediliyor.',
        'universite' => 'Sabancı Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'birim' => $birimArastirma,
        'cetvel' => 'sabanci-turler',
        'notlar' => 'EK-1 MDBF Tüm Programlar, PROFESÖR. Ayırt edici yanı son madde: dokuz başarıdan en az beşi.',
        'sart' => Kalip::ve('MDBF Araştırma ve Uygulama Ağırlıklı — Profesör', [
            Kalip::adet('Q1/Q2 (veya SNIP ≥ 1.0) dergilerde en az 27 bilimsel makale', ['SU-M1'], 27)
                + ['donusumler' => $ikameler(3)],
            Kalip::adet('Bunların en az 15\'i doçentlik sonrası üretilmiş olmalı', ['SU-M1'], 15, donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::metrik('En az iki yıl öğrenci desteği sağlayan 6 TÜBİTAK/AB/ÜSİ projesinde yürütücülük', 'proje_yurutuculuk', 6)
                + ['donusumler' => [
                    ['aciklama' => '2 projede araştırmacılık 1 yürütücülüğe denk', 'kaynak' => ['proje_arastirmaci'],
                        'kaynak_adet' => 2, 'hedef_adet' => 1, 'azami' => 2, 'kota_grubu' => null],
                    ['aciklama' => '4 projede danışmanlık 1 yürütücülüğe denk', 'kaynak' => ['proje_danisman'],
                        'kaynak_adet' => 4, 'hedef_adet' => 1, 'azami' => 2, 'kota_grubu' => null],
                ]],
            Kalip::beyan('TÜBİTAK 1003 ölçeğinde alt proje yürütücülüğü bir yürütücülüğe, büyük ölçekli proje yürütücülüğü ikiye sayılabilir'),
            Kalip::beyan('Projelerden en az dördü tamamlanmış / final raporu hazırlanmış olmalı'),
            Kalip::beyan('En az 4 endüstriyel projeye iştirak (en az ikisinde yürütücü veya eş yürütücü)'),
            Kalip::metrik('Doçentliğe atandıktan sonra ortalama yılda 1 ders vermiş olmak', 'ders_yariyil', 1, Kalip::DOCENTLIK_SONRASI),
            Kalip::metrik('Bitmiş en az 7 lisansüstü tezde baş danışmanlık', 'tez_danismanlik', 7)
                + ['donusumler' => [
                    ['aciklama' => '2 eş danışmanlık 1 baş danışmanlığa denk (en fazla 1 tez için)',
                        'kaynak' => ['tez_es_danismanlik'],
                        'kaynak_adet' => 2, 'hedef_adet' => 1, 'azami' => 1, 'kota_grubu' => null],
                ]],
            Kalip::metrik('Bunlardan en az 2\'si doktora tezi olmalı', 'doktora_tez_danismanlik', 2),
            Kalip::kIle('Aşağıdaki dokuz başarıdan en az beşini sağlamalısınız', 5, [
                Kalip::beyan('Web of Science "highly cited" tanımına giren makale'),
                Kalip::beyan('Uluslararası saygın yayınevinden kitap bölümü'),
                Kalip::beyan('ABD, Avrupa veya Japonya patent ofisinden tescil'),
                Kalip::beyan('Yurt dışı saygın üniversitelerde eşdeğer pozisyona atananlarla benzer h-indeksi'),
                Kalip::beyan('Endüstriyel ders programı veya laboratuvar kurma/geliştirme katkısı'),
                Kalip::beyan('Önemli endüstriyel veya kurumsal ortaklık kurmak ya da desteklemek'),
                Kalip::beyan('Ulusal veya uluslararası saygın bilimsel ödül'),
                Kalip::beyan('Uluslararası tanınmışlık (ana davetli konuşmacılık, saygın dergide editörlük)'),
                Kalip::beyan('Çalıştay veya konferans organizasyonuna katkı'),
            ]),
        ]),
    ],
    [
        'anahtar' => 'sabanci-docent-ssbf-ekonomi',
        'aday_notu' => 'Kitap eşdeğerlikleri CERES sıralamasına göre: A kategori kitap 3 makale, B kategori 2, C/D/E kategori 1 makale yerine sayılıyor. Alan endeksinin ilk çeyreğindeki bir makale de 2 makale sayılıyor. Kitap editörlükleri ve CERES\'te endekslenmemiş kitaplar sayılmaz.',
        'universite' => 'Sabancı Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['sosyal'],
        'birim' => $birimEkonomi,
        'cetvel' => 'sabanci-turler',
        'notlar' => 'EK-2 SSBF / Ekonomi / Siyaset Bilimi / Psikoloji Programları, DOÇENT.',
        'sart' => Kalip::ve('SSBF Ekonomi / Siyaset Bilimi / Psikoloji — Doçent', [
            Kalip::adet('SCI/SSCI/AHCI/SCOPUS endeksli dergilerde en az 5 bilimsel makale', ['SU-S1'], 5)
                + ['donusumler' => $ssbfIkameler],
            Kalip::adet('Bu makalelerin en az 2\'si doktora tezinden üretilmemiş olmalı', ['SU-S1'], 2)
                + ['haric' => ['doktora_tezinden']],
            Kalip::metrik('Doktora sonrasında en az 4 lisans/lisansüstü ders vermiş olmak', 'ders_yariyil', 4, Kalip::DOKTORA_SONRASI),
            Kalip::veya('Bitmiş 2 yüksek lisans tezi ya da 1 doktora tezi danışmanlığı', [
                Kalip::metrik('Bitmiş en az 2 yüksek lisans tezinde danışmanlık', 'tez_danismanlik', 2),
                Kalip::metrik('Bitmiş en az 1 doktora tezinde danışmanlık', 'doktora_tez_danismanlik', 1),
            ]),
            Kalip::beyan('Önceki kurumunuzun programı lisansüstü derece vermiyorsa: en az 4 lisans projesi danışmanlığı'),
            $ssbfBasarilar(2),
        ]),
    ],
    [
        'anahtar' => 'sabanci-profesor-ssbf-ekonomi',
        'aday_notu' => 'Kitap eşdeğerlikleri CERES sıralamasına göre: A kategori kitap 3 makale, B kategori 2, C/D/E kategori 1 makale yerine sayılıyor. Alan endeksinin ilk çeyreğindeki bir makale de 2 makale sayılıyor. Kitap editörlükleri ve CERES\'te endekslenmemiş kitaplar sayılmaz.',
        'universite' => 'Sabancı Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['sosyal'],
        'birim' => $birimEkonomi,
        'cetvel' => 'sabanci-turler',
        'notlar' => 'EK-2 SSBF / Ekonomi / Siyaset Bilimi / Psikoloji Programları, PROFESÖR.',
        'sart' => Kalip::ve('SSBF Ekonomi / Siyaset Bilimi / Psikoloji — Profesör', [
            Kalip::adet('SCI/SSCI/AHCI/SCOPUS endeksli dergilerde en az 10 bilimsel makale', ['SU-S1'], 10)
                + ['donusumler' => $ssbfIkameler],
            Kalip::adet('Bunların en az 4\'ü doçentlik sonrası üretilmiş olmalı', ['SU-S1'], 4, donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::metrik('Doktora sonrası toplam 8 ders (en az 4\'ü lisansüstü düzeyde)', 'ders_yariyil', 8, Kalip::DOKTORA_SONRASI),
            Kalip::veya('Bitmiş 4 yüksek lisans tezi ya da 2 doktora tezi danışmanlığı', [
                Kalip::metrik('Bitmiş en az 4 yüksek lisans tezinde danışmanlık', 'tez_danismanlik', 4),
                Kalip::metrik('Bitmiş en az 2 doktora tezinde danışmanlık', 'doktora_tez_danismanlik', 2),
            ]),
            $ssbfBasarilar(4),
        ]),
    ],
    [
        'anahtar' => 'sabanci-docent-ssbf-kultur',
        'aday_notu' => 'Kitap eşdeğerlikleri CERES sıralamasına göre: A kategori kitap 3 makale, B kategori 2, C/D/E kategori 1 makale yerine sayılıyor. Alan endeksinin ilk çeyreğindeki bir makale de 2 makale sayılıyor. Kitap editörlükleri ve CERES\'te endekslenmemiş kitaplar sayılmaz.',
        'universite' => 'Sabancı Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['sosyal'],
        'birim' => $birimKultur,
        'cetvel' => 'sabanci-turler',
        'notlar' => 'EK-2 SSBF / Kültürel Çalışmalar ve Tarih Programları, DOÇENT.',
        'sart' => Kalip::ve('SSBF Kültürel Çalışmalar ve Tarih — Doçent', [
            Kalip::adet('SCI/SSCI/AHCI/SCOPUS endeksli dergilerde en az 5 bilimsel makale', ['SU-S1'], 5)
                + ['donusumler' => $ssbfIkameler],
            Kalip::adet('Bu makalelerin en az 2\'si doktora tezinden üretilmemiş olmalı', ['SU-S1'], 2)
                + ['haric' => ['doktora_tezinden']],
            Kalip::metrik('Doktora sonrasında en az 4 lisans/lisansüstü ders vermiş olmak', 'ders_yariyil', 4, Kalip::DOKTORA_SONRASI),
            Kalip::veya('Bitmiş 2 yüksek lisans tezi ya da 1 doktora tezi danışmanlığı', [
                Kalip::metrik('Bitmiş en az 2 yüksek lisans tezinde danışmanlık', 'tez_danismanlik', 2),
                Kalip::metrik('Bitmiş en az 1 doktora tezinde danışmanlık', 'doktora_tez_danismanlik', 1),
            ]),
            Kalip::beyan('Önceki kurumunuzun programı lisansüstü derece vermiyorsa: en az 4 lisans projesi danışmanlığı'),
            $ssbfBasarilar(2),
        ]),
    ],
    [
        'anahtar' => 'sabanci-profesor-ssbf-kultur',
        'aday_notu' => 'Kitap eşdeğerlikleri CERES sıralamasına göre: A kategori kitap 3 makale, B kategori 2, C/D/E kategori 1 makale yerine sayılıyor. Alan endeksinin ilk çeyreğindeki bir makale de 2 makale sayılıyor. Kitap editörlükleri ve CERES\'te endekslenmemiş kitaplar sayılmaz.',
        'universite' => 'Sabancı Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['sosyal'],
        'birim' => $birimKultur,
        'cetvel' => 'sabanci-turler',
        'notlar' => 'EK-2 SSBF / Kültürel Çalışmalar ve Tarih Programları, PROFESÖR.',
        'sart' => Kalip::ve('SSBF Kültürel Çalışmalar ve Tarih — Profesör', [
            Kalip::adet('SCI/SSCI/AHCI/SCOPUS endeksli dergilerde en az 10 bilimsel makale', ['SU-S1'], 10)
                + ['donusumler' => $ssbfIkameler],
            Kalip::adet('Bunların en az 4\'ü doçentlik sonrası üretilmiş olmalı', ['SU-S1'], 4, donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::metrik('Doktora sonrası toplam 8 ders (en az 4\'ü lisansüstü düzeyde)', 'ders_yariyil', 8, Kalip::DOKTORA_SONRASI),
            Kalip::veya('Bitmiş 4 yüksek lisans tezi ya da 2 doktora tezi danışmanlığı', [
                Kalip::metrik('Bitmiş en az 4 yüksek lisans tezinde danışmanlık', 'tez_danismanlik', 4),
                Kalip::metrik('Bitmiş en az 2 doktora tezinde danışmanlık', 'doktora_tez_danismanlik', 2),
            ]),
            $ssbfBasarilar(4),
        ]),
    ],
    [
        'anahtar' => 'sabanci-docent-ssbf-gorsel',
        'aday_notu' => 'Bu programda makale yerine prestijli sanatsal etkinlikler sayılıyor.',
        'universite' => 'Sabancı Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['guzel_sanatlar'],
        'birim' => $birimGorsel,
        'cetvel' => 'sabanci-turler',
        'notlar' => 'EK-2 SSBF / Görsel Sanatlar ve Görsel İletişim Tasarımı Programı, DOÇENT. Makale yerine prestijli sanatsal etkinlik sayılıyor.',
        'sart' => Kalip::ve('SSBF Görsel Sanatlar ve Görsel İletişim Tasarımı — Doçent', [
            Kalip::adet('En az 5 prestijli sanatsal etkinlik', ['SU-SANAT'], 5),
            Kalip::adet('Bunların en az 2\'si doktora/sanatta yeterlik sonrası olmalı', ['SU-SANAT'], 2, donem: Kalip::DOKTORA_SONRASI),
            Kalip::metrik('Doktora/sanatta yeterlik sonrasında en az 4 lisans/lisansüstü ders', 'ders_yariyil', 4, Kalip::DOKTORA_SONRASI),
            Kalip::veya('Bitmiş 2 yüksek lisans tezi ya da 1 doktora tezi danışmanlığı', [
                Kalip::metrik('Bitmiş en az 2 yüksek lisans tezinde danışmanlık', 'tez_danismanlik', 2),
                Kalip::metrik('Bitmiş en az 1 doktora tezinde danışmanlık', 'doktora_tez_danismanlik', 1),
            ]),
            $ssbfBasarilar(2),
        ]),
    ],
    [
        'anahtar' => 'sabanci-docent-ybf',
        'aday_notu' => 'Danışmanlık ağırlıklı puanla ölçülüyor: doktora tezi 4, yüksek lisans tezi 2, lisans/lisansüstü proje 1 puan. FT50 listesindeki ve AJG\'de en az 4 puan almış dergideki bir makale iki SSCI makalesi sayılıyor.',
        'universite' => 'Sabancı Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['sosyal'],
        'birim' => $birimYbf,
        'cetvel' => 'sabanci-turler',
        'notlar' => 'EK-3 YBF, DOÇENT. \"En az 3 tanesi doktora tezinden üretilmemiş olmak kaydıyla … en az 6 bilimsel makale.\"',
        'sart' => Kalip::ve('YBF — Doçent', [
            Kalip::adet('SCI/SCIE/SSCI endeksli dergilerde en az 6 bilimsel makale', ['SU-Y1'], 6)
                + ['donusumler' => $ybfIkameler],
            Kalip::adet('Bu makalelerin en az 3\'ü doktora tezinden üretilmemiş olmalı', ['SU-Y1'], 3)
                + ['haric' => ['doktora_tezinden']],
            Kalip::metrik('En az biri lisansüstü düzeyde olmak üzere toplam 3 farklı ders', 'ders_yariyil', 3),
            Kalip::puanDan('Danışmanlıklardan en az 4 puan değerinde', ['YBF-DANISMANLIK'], 4, madde: 'EK-3 YBF · danışmanlık ağırlıkları'),
            $ybfBasarilar(2),
        ]),
    ],
    [
        'anahtar' => 'sabanci-profesor-ybf',
        'aday_notu' => 'Danışmanlık ağırlıklı puanla ölçülüyor: doktora tezi 4, yüksek lisans tezi 2, lisans/lisansüstü proje 1 puan. FT50 listesindeki ve AJG\'de en az 4 puan almış dergideki bir makale iki SSCI makalesi sayılıyor.',
        'universite' => 'Sabancı Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['sosyal'],
        'birim' => $birimYbf,
        'cetvel' => 'sabanci-turler',
        'notlar' => 'EK-3 YBF, PROFESÖR. \"En az 4 tanesi doçentlik sonrası üretilmiş olmak kaydıyla … en az 14 bilimsel makale.\"',
        'sart' => Kalip::ve('YBF — Profesör', [
            Kalip::adet('SCI/SCIE/SSCI endeksli dergilerde en az 14 bilimsel makale', ['SU-Y1'], 14)
                + ['donusumler' => $ybfIkameler],
            Kalip::adet('Bunların en az 4\'ü doçentlik sonrası üretilmiş olmalı', ['SU-Y1'], 4, donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::metrik('En az ikisi lisansüstü düzeyde olmak üzere toplam 5 farklı ders', 'ders_yariyil', 5),
            Kalip::puanDan('Danışmanlıklardan en az 8 puan değerinde', ['YBF-DANISMANLIK'], 8, madde: 'EK-3 YBF · danışmanlık ağırlıkları'),
            $ybfBasarilar(4),
        ]),
    ],
    // ══════════ EK-2 SSBF · ARAŞTIRMA VE UYGULAMA AĞIRLIKLI ══════════
    //
    // SSBF'nin İKİNCİ kariyer yolu. "Eğitim ve Araştırma Ağırlıklı" yolda
    // yönerge Dr. Öğr. Üyesi tanımlamıyor (doçentten başlıyor); bu yolda ise
    // üç kadro da var. Yayın eşiği belirgin yüksek: doçent 10, profesör 20.
    [
        'anahtar' => 'sabanci-dr-ssbf-arastirma',
        'aday_notu' => 'Bu, araştırma ve uygulama ağırlıklı AYRI bir kariyer yolu; yayın eşiği eğitim ağırlıklı yoldan yüksektir. Alan endeksinin ilk çeyreğindeki bir makale 2 makale sayılıyor.',
        'universite' => 'Sabancı Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['sosyal', 'guzel_sanatlar'],
        'birim' => $birimSsbfArastirma,
        'cetvel' => 'sabanci-turler',
        'notlar' => 'EK-2 SSBF / Araştırma ve Uygulama Ağırlıklı Öğretim Üyesi, DR. ÖĞRETİM ÜYESİ.',
        'sart' => Kalip::ve('SSBF Araştırma ve Uygulama Ağırlıklı — Dr. Öğr. Üyesi', [
            Kalip::adet('SCI/SSCI/AHCI/SCOPUS endeksli dergilerde en az 2 bilimsel makale', ['SU-S1'], 2)
                + ['donusumler' => $ssbfIkameler],
            Kalip::beyan('Proje başvuru/ilerleme ve sonuç raporları süreçlerinde yer almış olmak'),
        ]),
    ],
    [
        'anahtar' => 'sabanci-docent-ssbf-arastirma',
        'aday_notu' => 'Bu, araştırma ve uygulama ağırlıklı AYRI bir kariyer yolu. Kitap eşdeğerlikleri CERES sıralamasına göre: A kategori kitap 3 makale, B kategori 2, C/D/E kategori 1 makale yerine sayılıyor.',
        'universite' => 'Sabancı Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['sosyal', 'guzel_sanatlar'],
        'birim' => $birimSsbfArastirma,
        'cetvel' => 'sabanci-turler',
        'notlar' => 'EK-2 SSBF / Araştırma ve Uygulama Ağırlıklı, DOÇENT. "En az 4 tanesi doktora tezinden üretilmemiş olmak kaydıyla … en az 10 bilimsel makale."',
        'sart' => Kalip::ve('SSBF Araştırma ve Uygulama Ağırlıklı — Doçent', [
            Kalip::adet('SCI/SSCI/AHCI/SCOPUS endeksli dergilerde en az 10 bilimsel makale', ['SU-S1'], 10)
                + ['donusumler' => $ssbfIkameler],
            Kalip::adet('Bu makalelerin en az 4\'ü doktora tezinden üretilmemiş olmalı', ['SU-S1'], 4)
                + ['haric' => ['doktora_tezinden']],
            Kalip::metrik('Doktora sonrasında en az 4 lisans/lisansüstü ders vermiş olmak', 'ders_yariyil', 4, Kalip::DOKTORA_SONRASI),
            Kalip::veya('Bitmiş 2 yüksek lisans tezi ya da 1 doktora tezi danışmanlığı', [
                Kalip::metrik('Bitmiş en az 2 yüksek lisans tezinde danışmanlık', 'tez_danismanlik', 2),
                Kalip::metrik('Bitmiş en az 1 doktora tezinde danışmanlık', 'doktora_tez_danismanlik', 1),
            ]),
            Kalip::beyan('En az biri uluslararası olmak kaydıyla 2 tamamlanmış projede yürütücülük ya da baş araştırmacılık'),
            $ssbfBasarilar(3),
        ]),
    ],
    [
        'anahtar' => 'sabanci-profesor-ssbf-arastirma',
        'aday_notu' => 'Bu, araştırma ve uygulama ağırlıklı AYRI bir kariyer yolu. Yirmi makalenin en az sekizi doçentlik sonrası olmalı.',
        'universite' => 'Sabancı Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['sosyal', 'guzel_sanatlar'],
        'birim' => $birimSsbfArastirma,
        'cetvel' => 'sabanci-turler',
        'notlar' => 'EK-2 SSBF / Araştırma ve Uygulama Ağırlıklı, PROFESÖR. "En az 8 tanesi doçentlik sonrası olmak kaydıyla … en az 20 bilimsel makale."',
        'sart' => Kalip::ve('SSBF Araştırma ve Uygulama Ağırlıklı — Profesör', [
            Kalip::adet('SCI/SSCI/AHCI/SCOPUS endeksli dergilerde en az 20 bilimsel makale', ['SU-S1'], 20)
                + ['donusumler' => $ssbfIkameler],
            Kalip::adet('Bunların en az 8\'i doçentlik sonrası olmalı', ['SU-S1'], 8, donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::metrik('Doktora sonrası en az dördü lisansüstü olmak üzere toplam 8 ders', 'ders_yariyil', 8, Kalip::DOKTORA_SONRASI),
            Kalip::veya('Bitmiş 4 yüksek lisans tezi ya da 2 doktora tezi danışmanlığı', [
                Kalip::metrik('Bitmiş en az 4 yüksek lisans tezinde danışmanlık', 'tez_danismanlik', 4),
                Kalip::metrik('Bitmiş en az 2 doktora tezinde danışmanlık', 'doktora_tez_danismanlik', 2),
            ]),
            Kalip::beyan('En az üçü uluslararası olmak kaydıyla 5 tamamlanmış projede yürütücülük ya da baş araştırmacılık'),
            $ssbfBasarilar(6),
        ]),
    ],

    // ══════════ EK-3 YBF · ARAŞTIRMA VE UYGULAMA AĞIRLIKLI ══════════
    //
    // YBF'nin ikinci kariyer yolu; eğitim ağırlıklı yolda olmayan Dr. Öğr.
    // Üyesi kadrosu burada tanımlı. Danışmanlık burada ağırlıklı puanla değil
    // ADETLE isteniyor — eğitim ağırlıklı yoldan ayrıldığı nokta.
    [
        'anahtar' => 'sabanci-dr-ybf-arastirma',
        'aday_notu' => 'Bu, araştırma ve uygulama ağırlıklı AYRI bir kariyer yolu. FT50 listesindeki ve AJG\'de en az 4 puan almış dergideki bir makale iki SSCI makalesi sayılıyor.',
        'universite' => 'Sabancı Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['sosyal'],
        'birim' => $birimYbfArastirma,
        'cetvel' => 'sabanci-turler',
        'notlar' => 'EK-3 YBF / Araştırma ve Uygulama Ağırlıklı, DR. ÖĞRETİM ÜYESİ.',
        'sart' => Kalip::ve('YBF Araştırma ve Uygulama Ağırlıklı — Dr. Öğr. Üyesi', [
            Kalip::adet('SCI/SCIE/SSCI endeksli dergilerde en az 2 bilimsel makale', ['SU-Y1'], 2)
                + ['donusumler' => $ybfIkameler],
            Kalip::beyan('Proje başvuru/ilerleme ve sonuç raporları süreçlerinde yer almış olmak'),
        ]),
    ],
    [
        'anahtar' => 'sabanci-docent-ybf-arastirma',
        'aday_notu' => 'Bu, araştırma ve uygulama ağırlıklı AYRI bir kariyer yolu; yayın eşiği eğitim ağırlıklı yoldan yüksek (9 ↔ 6). Danışmanlık burada puanla değil adetle isteniyor.',
        'universite' => 'Sabancı Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['sosyal'],
        'birim' => $birimYbfArastirma,
        'cetvel' => 'sabanci-turler',
        'notlar' => 'EK-3 YBF / Araştırma ve Uygulama Ağırlıklı, DOÇENT.',
        'sart' => Kalip::ve('YBF Araştırma ve Uygulama Ağırlıklı — Doçent', [
            Kalip::adet('SCI/SCIE/SSCI endeksli dergilerde en az 9 bilimsel makale', ['SU-Y1'], 9)
                + ['donusumler' => $ybfIkameler],
            Kalip::beyan('En az biri uluslararası olmak kaydıyla en az 2 projede proje yürütücülüğü'),
            Kalip::beyan('Endüstriyel ve kurumsal ortaklıklar kurmak ya da bu çalışmalara destek vermiş olmak'),
            Kalip::metrik('En az biri lisansüstü düzeyde olmak üzere toplam en az 2 farklı ders', 'ders_yariyil', 2),
            Kalip::metrik('Bitmiş 2 yüksek lisans/doktora tezinde danışmanlık', 'tez_danismanlik', 2),
            Kalip::beyan('Alanındaki yüksek lisans/doktora programlarına katkıda bulunmuş olmak'),
            $ybfBasarilar(3),
        ]),
    ],
    [
        'anahtar' => 'sabanci-profesor-ybf-arastirma',
        'aday_notu' => 'Bu, araştırma ve uygulama ağırlıklı AYRI bir kariyer yolu; yayın eşiği eğitim ağırlıklı yoldan yüksek (21 ↔ 14).',
        'universite' => 'Sabancı Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['sosyal'],
        'birim' => $birimYbfArastirma,
        'cetvel' => 'sabanci-turler',
        'notlar' => 'EK-3 YBF / Araştırma ve Uygulama Ağırlıklı, PROFESÖR.',
        'sart' => Kalip::ve('YBF Araştırma ve Uygulama Ağırlıklı — Profesör', [
            Kalip::adet('SCI/SCIE/SSCI endeksli dergilerde en az 21 bilimsel makale', ['SU-Y1'], 21)
                + ['donusumler' => $ybfIkameler],
            Kalip::beyan('En az ikisi uluslararası olmak kaydıyla en az 4 projede proje yürütücülüğü'),
            Kalip::beyan('Endüstriyel ve kurumsal ortaklıklar kurmak ya da bu çalışmalara destek vermiş olmak'),
            Kalip::metrik('En az ikisi lisansüstü düzeyde olmak üzere toplam en az 3 farklı ders', 'ders_yariyil', 3),
            Kalip::metrik('Bitmiş 4 yüksek lisans/doktora tezinde danışmanlık', 'tez_danismanlik', 4),
            $ybfBasarilar(6),
        ]),
    ],

    [
        'anahtar' => 'sabanci-docent-egitim',
        'aday_notu' => 'Bu, en az 10 yıl kıdem gerektiren AYRI bir kariyer yolu. Yayın eşiği düşük ama giriş ve eğitim performansı koşulları belge ile teyit ediliyor. Sanat alanında prestijli sergi makale şartının yerine geçebiliyor.',
        'universite' => 'Sabancı Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['sosyal', 'muhendislik', 'fen', 'guzel_sanatlar'],
        'birim' => $birimEgitim,
        'cetvel' => 'sabanci-turler',
        'notlar' => 'EK-4 Eğitim Ağırlıklı Kariyer Gelişim Yolu, doçent seviyesi. Giriş koşulları (10 yıl kıdem, periyodik gözden geçirme, öğrenci değerlendirmesi) iki kadroda da ortak.',
        'sart' => Kalip::ve('Eğitim Ağırlıklı Kariyer Yolu — Doçent', [
            ...$egitimGiris,
            Kalip::adet('Doçentlik sonrası yüksek etki faktörlü dergilerde en az 3 bilimsel makale', ['SU-E1'], 3, donem: Kalip::DOCENTLIK_SONRASI)
                + ['donusumler' => $egitimIkameler],
            $egitimKriterler(2),
        ]),
    ],
    [
        'anahtar' => 'sabanci-profesor-egitim',
        'aday_notu' => 'Bu, en az 10 yıl kıdem gerektiren AYRI bir kariyer yolu. Yayın eşiği düşük ama giriş ve eğitim performansı koşulları belge ile teyit ediliyor. Sanat alanında prestijli sergi makale şartının yerine geçebiliyor.',
        'universite' => 'Sabancı Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['sosyal', 'muhendislik', 'fen', 'guzel_sanatlar'],
        'birim' => $birimEgitim,
        'cetvel' => 'sabanci-turler',
        'notlar' => 'EK-4 Eğitim Ağırlıklı Kariyer Gelişim Yolu, PROFESÖR. Doçentten farkı: 6 makale ve dört kriter.',
        'sart' => Kalip::ve('Eğitim Ağırlıklı Kariyer Yolu — Profesör', [
            ...$egitimGiris,
            Kalip::adet('Doçentlik sonrası yüksek etki faktörlü dergilerde en az 6 bilimsel makale', ['SU-E1'], 6, donem: Kalip::DOCENTLIK_SONRASI)
                + ['donusumler' => $egitimIkameler],
            $egitimKriterler(4),
        ]),
    ],
];
