<?php

/**
 * SABANCI ÜNİVERSİTESİ — çalışma türü cetveli
 * Kaynak: pdf/17537103422.sabanciuniversitesi.pdf · EK 1-4
 *
 * PUANSIZ CETVEL. Sabancı'nın kriterleri neredeyse tamamen ADET tabanlı; puan
 * tablosu yok. Maddeler "hangi çalışma hangi koşula sayılır" sorusunu cevaplar,
 * kaç puan ettiğini değil. Tek istisna YBF danışmanlık maddeleri (aşağıda).
 *
 * DÖRT FAKÜLTE, DÖRT FARKLI KABUL KÜMESİ — bu cetvelin varlık sebebi. Aynı
 * makale fakülteye göre sayılır ya da sayılmaz:
 *
 *   MDBF    (EK-1)  Q1/Q2 veya SNIP ≥ 1.0          SCOPUS yok, çeyreklik şartı var
 *   SSBF    (EK-2)  SCI/SSCI/AHCI/SCOPUS           çeyreklik şartı YOK
 *   YBF     (EK-3)  SCI/SCIE/SSCI                  SCOPUS yok
 *   EK-4            Q1/Q2 veya SNIP > 1, SCOPUS dâhil
 *
 * Bir SCOPUS makalesi bu yüzden SSBF ve EK-4'te sayılır, MDBF ve YBF'de
 * sayılmaz. Dördü tek dosyada duruyor ama karışmıyor: her fakültenin kodları
 * kendi önekini taşıyor (MDBF "SU-M", SSBF "SU-S" ve "SU-C", YBF "SU-Y" ve
 * "SU-D", EK-4 "SU-E") ve eşikler doğrudan bu kodlara atıf yapıyor. Grup
 * adları da fakülte nitelikli — tek bir
 * `MAKALE` grubu olsaydı hangi kabul kümesini kastettiği belirsiz kalırdı.
 *
 * KOD UZAYI yönergede tanımlı değil, burada türetildi.
 *
 * PROJEKSİYON: MDBF ve EK-4 "Q1/Q2 **veya** CWTS SNIP ≥ 1.0" diyor. Uygulamanın
 * kaynak sözlüğünde dergi metriği (SNIP) yok; yalnızca çeyreklik tarafı
 * eşleşiyor. SNIP'i yüksek ama Q3 olan bir dergideki makale bu maddelere
 * giremiyor — kalıcı çözüm Faaliyet'e sayısal dergi metriği alanı eklemek.
 */

/** EK-1 · MDBF — Mühendislik ve Doğa Bilimleri Fakültesi. */
$mdbf = [
    'SU-M1' => ['baslik' => 'SCI/SCIE/SSCI Q1-Q2 (veya CWTS SNIP ≥ 1.0) dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)']],
    'SU-M2' => ['baslik' => 'JCR Q3-Q4 dergide yayın', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI']],
    'SU-K1' => ['baslik' => 'WoS/SCOPUS listeli uluslararası konferans bildirisi', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)']],
    'SU-K2' => ['baslik' => 'Yüksek etki değerli konferans bildirisi (program listesi)', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin']],
    'SU-B1' => ['baslik' => 'Saygın yayınevi kitap bölümü', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Kitap Bölümü']],
];

/**
 * EK-2 · SSBF — Sanat ve Sosyal Bilimler Fakültesi.
 *
 * Kabul kümesi MDBF'den geniş: "SCI/SSCI/AHCI/SCOPUS endeksli" diyor, çeyreklik
 * şartı koymuyor. Ortak cetvel kullansalardı SSBF adayının Q3 makalesi
 * sayılmazdı.
 */
$ssbf = [
    // Ana koşulun saydığı küme: çeyreklik ayrımı YOK.
    'SU-S1' => ['baslik' => 'SCI/SSCI/AHCI/SCOPUS endeksli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI', 'ESCI / Scopus']],

    // "Programın genel alan endeksinin ilk çeyreğinde yer alan dergi" —
    // 1 makale 2 makale yerine sayılır.
    'SU-S1Q1' => ['baslik' => 'Alan endeksinin ilk çeyreğindeki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)']],

    // CERES kategorili uluslararası kitaplar. Sözlükte CERES ayrımı olmadığı
    // için kategori başına ayrı kaynak etiketi kullanılıyor. Kitap
    // editörlükleri ve CERES'te endekslenmemiş kitaplar bu kapsamda sayılmaz.
    'SU-CA' => ['baslik' => 'CERES A kategori uluslararası kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap']],
    'SU-CB' => ['baslik' => 'CERES B kategori uluslararası kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap']],
    'SU-CCDE' => ['baslik' => 'CERES C, D veya E kategori uluslararası kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap']],

    // Görsel Sanatlar programı makale yerine sanatsal etkinlik sayıyor.
    'SU-SANAT' => ['baslik' => 'Prestijli sanatsal etkinlik / sergi / gösterim', 'kategori' => 'sanatsal_etkinlik'],
];

/**
 * EK-3 · YBF — Yönetim Bilimleri Fakültesi.
 *
 * KISMEN PUANLI: yayın koşulları adetle yazılmış ama DANIŞMANLIK ağırlıklı
 * puanla ölçülüyor — "Doktora tezi 4 puan, yüksek lisans tezi 2 puan ve
 * lisans/lisansüstü projeler 1 puan olmak üzere, en az 4/8 puan değerinde
 * danışmanlık yapmış olmak." Bu yüzden yalnızca bu maddeler `puan` taşır.
 *
 * Kabul kümesi SCI/SCIE/SSCI — SCOPUS yok; ikamesi FT50 + Academic Journal
 * Guide temelli.
 */
$ybf = [
    'SU-Y1' => ['baslik' => 'SCI/SCIE/SSCI endeksli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI']],

    // "FT50 listesinde yer alan ve AJG'de en az 4 puan almış dergide her
    // makale 2 SSCI makale yerine geçer." Ayrı etiketi yok; sözlükte en
    // yakın karşılık Q1.
    'SU-FT50' => ['baslik' => 'FT50 / AJG 4+ dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)']],

    // Ağırlıklı danışmanlık puanı.
    'SU-D1' => ['baslik' => 'Doktora tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 4],
    'SU-D2' => ['baslik' => 'Yüksek lisans tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 2],
    'SU-D3' => ['baslik' => 'Lisans/lisansüstü proje danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'roller' => ['danisman', 'es_danisman'], 'puan' => 1],
];

/**
 * EK-4 · Eğitim Ağırlıklı Kariyer Gelişim Yolu (fakülteden bağımsız).
 *
 * Ayrı tutulmasının sebebi ikamelerin benzersizliği: burada CERES kitabın
 * YANINDA sanatsal sergi de makale yerine geçiyor, ki diğer üç blokta böyle
 * bir kural yok.
 */
$egitim = [
    'SU-E1' => ['baslik' => 'Yüksek etki faktörlü (Q1-Q2 veya SNIP > 1) dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'AHCI', 'ESCI / Scopus']],
    'SU-EFT' => ['baslik' => 'FT50 / AJG 4+ dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)']],
    'SU-ECERES' => ['baslik' => 'CERES A veya B kategori kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası/Ulusal Kitap']],

    // "Sanat alanında prestijli uluslararası sergi veya prestijli solo sergi
    // makale şartı yerine kabul edilir."
    'SU-ESOLO' => ['baslik' => 'Prestijli solo sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)']],
    'SU-EBIENAL' => ['baslik' => 'Prestijli uluslararası solo sergi veya bienal katılımı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)']],
];

return [
    'kapsam_notu' => 'Sabancı kriterleri puanla değil çalışma sayısıyla tanımlı. Kabul edilen '
        .'dergi kümesi fakülteye göre değişir: SCOPUS bir makale SSBF ve eğitim ağırlıklı yolda '
        .'sayılırken MDBF ve YBF\'de sayılmaz.',

    'maddeler' => $mdbf + $ssbf + $ybf + $egitim,

    'gruplar' => [
        // Grup adları fakülte nitelikli: dört blokta da "makale" var ama kabul
        // kümeleri farklı, tek bir MAKALE grubu hangisini kastettiğini
        // söyleyemezdi.
        'MDBF-MAKALE' => ['SU-M1', 'SU-M2'],
        'SSBF-MAKALE' => ['SU-S1', 'SU-S1Q1'],
        'SSBF-CERES' => ['SU-CA', 'SU-CB', 'SU-CCDE'],
        'YBF-MAKALE' => ['SU-Y1', 'SU-FT50'],
        'YBF-DANISMANLIK' => ['SU-D1', 'SU-D2', 'SU-D3'],
        'EGITIM-MAKALE' => ['SU-E1', 'SU-EFT'],
        'EGITIM-SERGI' => ['SU-ESOLO', 'SU-EBIENAL'],
    ],

    'grup_tavanlari' => [],
];
