<?php

/**
 * İZMİR YÜKSEK TEKNOLOJİ ENSTİTÜSÜ — Minimum Akademik Yükseltme ve Atama
 * Ölçütleri ile İlgili Esaslar
 * Kaynak: pdf/17536998302.izmiryuksekteknolojiuniverstesi.pdf
 * (Senato 25.07.2017-14/3; 17.04.2018-9/4 ve 15.05.2018-10/9 kararlarıyla
 * değişik)
 *
 * ── YAPI: ÜÇ TEMEL ALAN × DÖRT KADRO ──
 * Madde 5 kadro ölçütlerini alan grubu başına veriyor ve her grup kendi
 * puanlama ekine bağlanıyor:
 *   5.1 (FM) Fen ve Mühendislik Fakültesi → Ek-1 → `fen`, `muhendislik`
 *   5.2 (M)  Mimarlık Fakültesi           → Ek-2 → `mimarlik`
 *   5.3 (EB) Eğitim Bilimleri Temel Alanı → Ek-3 → `egitim`
 * Yönerge başka temel alan anmıyor; kalan dokuz alan kapsam dışı.
 *
 * ── BARAJLAR HEP "ŞU MADDEDEN ŞU KADAR" BİÇİMİNDE ──
 * Her kadro tek bir toplam barajı ve onun içinde birkaç alt baraj taşıyor
 * (ör. FM doçentlik: "64 puanı Ek-1 1(a), 60 puanı 5(a-c), 2 puanı 6(a-b),
 * 4 puanı 9(a-b) olmak üzere en az 150 puan"). Alt barajlar
 * `Kalip::puanDan` ile ilgili madde grubuna, toplam `Kalip::toplam`'a
 * yazıldı.
 *
 * ── DÖNEM: "DR. ÖĞR. ÜYELİĞİNE YÜKSELTİLDİKTEN SONRA" ──
 * Doçentlik barajları "doktor öğretim üyeliğine yükseltildikten sonraki
 * çalışmalardan" sayılıyor. Profilde Dr. Öğr. Üyeliğine atanma tarihi ayrı
 * tutulmadığı için `DOKTORA_SONRASI` kullanıldı: pencere yönergenin
 * istediğinden GENİŞ, yani doçentlik puanınız olduğundan YÜKSEK görünebilir.
 * Aday notunda uyarıldı. Profesörlük barajları "doçentliğe yükseltildikten
 * sonra" olduğu için `DOCENTLIK_SONRASI` birebir karşılıyor.
 *
 * ── YENİDEN ATANMA GİRİLDİ ──
 * 5.1.2, 5.2.2 ve 5.3.2 yeniden atanmayı süreye değil "her atama dönemi
 * için" ölçütlere bağlıyor; `SON_ATAMA_SONRASI` dönemiyle yazıldı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde 1'in İngilizce dil ve ders verme yetkinliği koşulu: yönerge sayı
 *       vermiyor, "Yükseköğretim Kurumlarında Yabancı Dil Öğretimi ...
 *       Yönetmelik hükümleri uygulanır" diyor. Sayı uydurmamak için
 *       `Kalip::yds` yerine `beyan` yazıldı.
 *   Madde 1'in "kendileştirme" (in-breeding) ilkesi: doktorasını İYTE'den
 *       alan ya da danışmanı İYTE'li olan adayların atanması ilke olarak
 *       uygun görülmüyor — kesin bir baraj değil, tercih kuralı.
 *   Madde 2.2 niyet mektubu ve yeniden atanmadaki "önceki dönemde
 *       belirttiği hedefleri gerçekleştirmiş olmak" — `beyan`.
 *   Madde 6: yabancı uyruklu öğretim üyelerinden minimum ölçütlerin İKİ
 *       KATI isteniyor; uyruk profilde yok, tek katı uygulandı.
 *   5.1.2(b), 5.2.2(b) ve 1.1.x(b): "bir defaya mahsus olmak üzere daha
 *       düşük puanla atanma" istisnası — idari takdir.
 *   GEÇİCİ MADDE 1'in 1.1, 1.2 ve 1.3 geçici ölçütleri: yeniden atanma ve
 *       doçentlik için 01.01.2020, profesörlük için 03.01.2022 tarihine
 *       kadar geçerliydi; iki tarih de geçtiği için asıl ölçütler yazıldı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/iyte-2018.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'İzmir Yüksek Teknoloji Enstitüsü';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$dil = Kalip::beyan(
    'İYTE\'de eğitim öğretim dili İngilizce olduğu için İngilizce dil bilgisine ve İngilizce ders '
    .'verme yetkinliğine sahip olmak; başvurduğunuz birimde İngilizce bilimsel seminer ve deneme '
    .'dersi vermek (dil puanı Yükseköğretim Kurumlarında Yabancı Dil Öğretimi Yönetmeliği\'ne göre '
    .'belirlenir, yönerge sayı vermiyor)',
    'Madde 1',
);

$niyetMektubu = Kalip::beyan(
    'Bir önceki atama döneminde sunduğunuz niyet mektubunda belirttiğiniz hedefleri '
    .'gerçekleştirmiş olmak',
    'Madde 5.1.2 / 5.2.2 / 5.3.2',
);

$DOCENT_NOTU = ' DİKKAT: yönerge doçentlik barajlarını "doktor öğretim üyeliğine yükseltildikten '
    .'sonraki çalışmalardan" sayıyor; Dr. Öğr. Üyeliğine atanma tarihi profilde tutulmadığı için '
    .'burada doktora tarihiniz kullanılıyor. Pencere yönergenin istediğinden geniş olduğu için '
    .'doçentlik puanınız olduğundan YÜKSEK görünebilir.';

$esikler = [];

// ══════════════════════════════════════════════════════════════════════════
// 5.1 (FM) FEN VE MÜHENDİSLİK FAKÜLTESİ — Ek-1
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'iyte-fm-dr',
    'aday_notu' => 'Fen ve Mühendislik Fakültesinde Dr. Öğretim Üyeliği için toplam en az 50 puan; '
        .'bunun en az 24 puanının SCI/SCI-Expanded/SSCI/AHCI makalelerinden (tezinizden üretilmiş '
        .'olanlar dâhil) ve en az 15 puanının atıflardan gelmesi gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['fen', 'muhendislik'],
    'cetvel' => 'iyte-2018-e1-dr',
    'notlar' => 'Madde 5.1.1: 24 puanı Ek-1 1(a) veya 2(a) ve 15 puanı Ek-1 5(a), (b), (c)\'den '
        .'olmak üzere en az 50 puan.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma — Fen ve Mühendislik', [
        $dil,
        Kalip::puanDan('SCI, SCI-Expanded, SSCI veya AHCI makalelerinizden en az 24 puan', ['E1-1a-2a'], 24, madde: 'Madde 5.1.1'),
        Kalip::puanDan('Atıf kalemlerinizden en az 15 puan', ['E1-5'], 15, madde: 'Madde 5.1.1'),
        Kalip::toplam(50),
    ]),
];

$esikler[] = [
    'anahtar' => 'iyte-fm-dr-yeniden',
    'aday_notu' => 'Bir önceki atama tarihinizden itibaren yaptığınız çalışmalar sayılıyor. Fen ve '
        .'Mühendislik Fakültesinde yeniden atanma için toplam en az 30 puan; bunun 16 puanının '
        .'SCI makalelerinden ya da 12 puanının araştırma projelerinden ya da 20 puanının '
        .'patentlerden gelmesi, ayrıca atıflardan 6 ve eğitim öğretimden 4 puan alınması '
        .'gerekiyor. Yönerge SCI makalesi için "İYTE adresli olması" şartı da koyuyor; adres '
        .'bilgisi kayıtta tutulmadığı için bu şart uygulanmıyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => ['fen', 'muhendislik'],
    'cetvel' => 'iyte-2018-e1-dr',
    'notlar' => 'Madde 5.1.2(a): her atama dönemi için 16 puanı Ek-1 1(a) veya 12 puanı Ek-1 '
        .'7(a)-(d)\'den veya 20 puanı Ek-1 4(a)-(b)\'den, 6 puanı Ek-1 5(a)-(c)\'den ve 4 puanı '
        .'Ek-1 9(a)-(b)\'den olmak üzere en az 30 puan.',
    'sart' => Kalip::ve('Doktor Öğretim Üyeliğine yeniden atanma — Fen ve Mühendislik', [
        Kalip::veya('Yayın, proje ya da patent barajlarından biri', [
            Kalip::puanDan('SCI, SCI-Expanded, SSCI veya AHCI makalelerinizden en az 16 puan', ['E1-1a'], 16, $SON_ATAMA, madde: 'Madde 5.1.2'),
            Kalip::puanDan('Ya da bilimsel araştırma projesi kalemlerinizden en az 12 puan', ['E1-7'], 12, $SON_ATAMA, madde: 'Madde 5.1.2'),
            Kalip::puanDan('Ya da patent kalemlerinizden en az 20 puan', ['E1-4'], 20, $SON_ATAMA, madde: 'Madde 5.1.2'),
        ]),
        Kalip::puanDan('Atıf kalemlerinizden en az 6 puan', ['E1-5'], 6, $SON_ATAMA, madde: 'Madde 5.1.2'),
        Kalip::puanDan('Eğitim öğretim faaliyetlerinizden en az 4 puan', ['E1-9'], 4, $SON_ATAMA, madde: 'Madde 5.1.2'),
        $niyetMektubu,
        Kalip::toplam(30, $SON_ATAMA),
    ]),
];

$esikler[] = [
    'anahtar' => 'iyte-fm-docentlik',
    'aday_notu' => 'Fen ve Mühendislik Fakültesinde doçentlik için toplam en az 150 puan; bunun en '
        .'az 64 puanının SCI/SCI-Expanded/SSCI/AHCI makalelerinden, 60 puanının atıflardan, '
        .'2 puanının tez danışmanlığından ve 4 puanının eğitim öğretimden gelmesi gerekiyor.'
        .$DOCENT_NOTU,
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['fen', 'muhendislik'],
    'cetvel' => 'iyte-2018-e1-docent',
    'notlar' => 'Madde 5.1.3: doktor öğretim üyeliğine yükseltildikten sonraki çalışmalardan 64 '
        .'puanı Ek-1 1(a), 60 puanı Ek-1 5(a)-(c), 2 puanı 6(a)-(b) ve 4 puanı 9(a)-(b)\'den olmak '
        .'üzere en az 150 puan.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — Fen ve Mühendislik', [
        $dil,
        Kalip::puanDan('SCI, SCI-Expanded, SSCI veya AHCI makalelerinizden en az 64 puan', ['E1-1a'], 64, $DOKTORA, madde: 'Madde 5.1.3'),
        Kalip::puanDan('Atıf kalemlerinizden en az 60 puan', ['E1-5'], 60, $DOKTORA, madde: 'Madde 5.1.3'),
        Kalip::puanDan('Lisansüstü tez danışmanlığı kalemlerinizden en az 2 puan', ['E1-6'], 2, $DOKTORA, madde: 'Madde 5.1.3'),
        Kalip::puanDan('Eğitim öğretim faaliyetlerinizden en az 4 puan', ['E1-9'], 4, $DOKTORA, madde: 'Madde 5.1.3'),
        Kalip::toplam(150, $DOKTORA),
    ]),
];

$esikler[] = [
    'anahtar' => 'iyte-fm-profesorluk',
    'aday_notu' => 'Doçentliğe yükseltildiğiniz tarihten sonraki çalışmalarınız sayılıyor. Fen ve '
        .'Mühendislik Fakültesinde profesörlük için toplam en az 400 puan; bunun en az 64 puanının '
        .'SCI makalelerinden, 150 puanının atıflardan, 4 puanının tez danışmanlığından ve 7 '
        .'puanının eğitim öğretimden gelmesi gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['fen', 'muhendislik'],
    'cetvel' => 'iyte-2018-e1-profesor',
    'notlar' => 'Madde 5.1.4: doçentliğe yükseltildikten sonraki çalışmalardan 64 puanı Ek-1 1(a), '
        .'150 puanı Ek-1 5(a)-(c), 4 puanı 6(a)-(b) ve 7 puanı 9(a)-(b)\'den olmak üzere en az 400 '
        .'puan.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma — Fen ve Mühendislik', [
        $dil,
        Kalip::puanDan('SCI, SCI-Expanded, SSCI veya AHCI makalelerinizden en az 64 puan', ['E1-1a'], 64, $DOCENTLIK, madde: 'Madde 5.1.4'),
        Kalip::puanDan('Atıf kalemlerinizden en az 150 puan', ['E1-5'], 150, $DOCENTLIK, madde: 'Madde 5.1.4'),
        Kalip::puanDan('Lisansüstü tez danışmanlığı kalemlerinizden en az 4 puan', ['E1-6'], 4, $DOCENTLIK, madde: 'Madde 5.1.4'),
        Kalip::puanDan('Eğitim öğretim faaliyetlerinizden en az 7 puan', ['E1-9'], 7, $DOCENTLIK, madde: 'Madde 5.1.4'),
        Kalip::toplam(400, $DOCENTLIK),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// 5.2 (M) MİMARLIK FAKÜLTESİ — Ek-2
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'iyte-m-dr',
    'aday_notu' => 'Mimarlık Fakültesinde Dr. Öğretim Üyeliği için toplam en az 34 puan; bunun en '
        .'az 16 puanının uluslararası makalelerden (tezinizden üretilmiş olanlar dâhil) ve en az '
        .'10 puanının atıflardan gelmesi gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['mimarlik'],
    'cetvel' => 'iyte-2018-e2-dr',
    'notlar' => 'Madde 5.2.1: 16 puanı Ek-2 1(a) veya 2(a) ve 10 puanı Ek-2 5(a)-(c)\'den olmak '
        .'üzere en az 34 puan.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma — Mimarlık', [
        $dil,
        Kalip::puanDan('Uluslararası makalelerinizden en az 16 puan', ['E2-1a-2a'], 16, madde: 'Madde 5.2.1'),
        Kalip::puanDan('Atıf kalemlerinizden en az 10 puan', ['E2-5'], 10, madde: 'Madde 5.2.1'),
        Kalip::toplam(34),
    ]),
];

$esikler[] = [
    'anahtar' => 'iyte-m-dr-yeniden',
    'aday_notu' => 'Bir önceki atama tarihinizden itibaren yaptığınız çalışmalar sayılıyor. Mimarlık '
        .'Fakültesinde yeniden atanma için toplam en az 30 puan; bunun 16 puanının uluslararası '
        .'makalelerden ya da yarışma-uygulama-yazılım-patent kalemlerinden ya da araştırma '
        .'projelerinden, ayrıca atıflardan 6 ve eğitim öğretimden 4 puan gelmesi gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => ['mimarlik'],
    'cetvel' => 'iyte-2018-e2-dr',
    'notlar' => 'Madde 5.2.2(a): her atama dönemi için 16 puanı Ek-2 1(a) veya Ek-2 4(a)-(c)\'den '
        .'veya Ek-2 7(a)-(d)\'den, 6 puanı Ek-2 5(a)-(c) ve 4 puanı Ek-2 9(a)-(b)\'den olmak üzere '
        .'en az 30 puan.',
    'sart' => Kalip::ve('Doktor Öğretim Üyeliğine yeniden atanma — Mimarlık', [
        Kalip::veya('Yayın, yarışma-uygulama-patent ya da proje barajlarından biri', [
            Kalip::puanDan('Uluslararası makalelerinizden en az 16 puan', ['E2-1a'], 16, $SON_ATAMA, madde: 'Madde 5.2.2'),
            Kalip::puanDan('Ya da yarışma, uygulama, yazılım ve patent kalemlerinizden en az 16 puan', ['E2-4'], 16, $SON_ATAMA, madde: 'Madde 5.2.2'),
            Kalip::puanDan('Ya da bilimsel araştırma projesi kalemlerinizden en az 16 puan', ['E2-7'], 16, $SON_ATAMA, madde: 'Madde 5.2.2'),
        ]),
        Kalip::puanDan('Atıf kalemlerinizden en az 6 puan', ['E2-5'], 6, $SON_ATAMA, madde: 'Madde 5.2.2'),
        Kalip::puanDan('Eğitim öğretim faaliyetlerinizden en az 4 puan', ['E2-9'], 4, $SON_ATAMA, madde: 'Madde 5.2.2'),
        $niyetMektubu,
        Kalip::toplam(30, $SON_ATAMA),
    ]),
];

$esikler[] = [
    'anahtar' => 'iyte-m-docentlik',
    'aday_notu' => 'Mimarlık Fakültesinde doçentlik için toplam en az 140 puan; bunun en az 32 '
        .'puanının uluslararası makalelerden, 15 puanının yarışma-uygulama-yazılım-patent '
        .'kalemlerinden, 50 puanının atıflardan, 2 puanının tez danışmanlığından ve 4 puanının '
        .'eğitim öğretimden gelmesi gerekiyor.'.$DOCENT_NOTU,
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['mimarlik'],
    'cetvel' => 'iyte-2018-e2-docent',
    'notlar' => 'Madde 5.2.3: doktor öğretim üyeliğine yükseltildikten sonraki çalışmalardan 32 '
        .'puanı Ek-2 1(a), 15 puanı Ek-2 4(a)-(c), 50 puanı Ek-2 5(a)-(c), 2 puanı Ek-2 6(a)-(b) '
        .'ve 4 puanı Ek-2 9(a)-(b)\'den olmak üzere en az 140 puan. Ek-2 4. madde dipnotu da bu '
        .'maddeden en az 15 puan alınmasını istiyor.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — Mimarlık', [
        $dil,
        Kalip::puanDan('Uluslararası makalelerinizden en az 32 puan', ['E2-1a'], 32, $DOKTORA, madde: 'Madde 5.2.3'),
        Kalip::puanDan('Yarışma, uygulama, yazılım ve patent kalemlerinizden en az 15 puan', ['E2-4'], 15, $DOKTORA, madde: 'Madde 5.2.3'),
        Kalip::puanDan('Atıf kalemlerinizden en az 50 puan', ['E2-5'], 50, $DOKTORA, madde: 'Madde 5.2.3'),
        Kalip::puanDan('Lisansüstü tez danışmanlığı kalemlerinizden en az 2 puan', ['E2-6'], 2, $DOKTORA, madde: 'Madde 5.2.3'),
        Kalip::puanDan('Eğitim öğretim faaliyetlerinizden en az 4 puan', ['E2-9'], 4, $DOKTORA, madde: 'Madde 5.2.3'),
        Kalip::toplam(140, $DOKTORA),
    ]),
];

$esikler[] = [
    'anahtar' => 'iyte-m-profesorluk',
    'aday_notu' => 'Doçentliğe yükseltildiğiniz tarihten sonraki çalışmalarınız sayılıyor. Mimarlık '
        .'Fakültesinde profesörlük için toplam en az 400 puan; bunun en az 48 puanının uluslararası '
        .'makalelerden, 15 puanının yarışma-uygulama-patent ya da araştırma projesi kalemlerinden, '
        .'100 puanının atıflardan, 4 puanının tez danışmanlığından ve 7 puanının eğitim öğretimden '
        .'gelmesi gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['mimarlik'],
    'cetvel' => 'iyte-2018-e2-profesor',
    'notlar' => 'Madde 5.2.4: doçentliğe yükseltildikten sonraki çalışmalardan 48 puanı Ek-2 1(a), '
        .'15 puanı Ek-2 4(a)-(c) veya Ek-2 7(a)-(d), 100 puanı Ek-2 5(a)-(c), 4 puanı Ek-2 '
        .'6(a)-(b) ve 7 puanı Ek-2 9(a)-(b)\'den olmak üzere en az 400 puan.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma — Mimarlık', [
        $dil,
        Kalip::puanDan('Uluslararası makalelerinizden en az 48 puan', ['E2-1a'], 48, $DOCENTLIK, madde: 'Madde 5.2.4'),
        Kalip::puanDan('Yarışma, uygulama, patent ve araştırma projesi kalemlerinizden en az 15 puan', ['E2-4-7'], 15, $DOCENTLIK, madde: 'Madde 5.2.4'),
        Kalip::puanDan('Atıf kalemlerinizden en az 100 puan', ['E2-5'], 100, $DOCENTLIK, madde: 'Madde 5.2.4'),
        Kalip::puanDan('Lisansüstü tez danışmanlığı kalemlerinizden en az 4 puan', ['E2-6'], 4, $DOCENTLIK, madde: 'Madde 5.2.4'),
        Kalip::puanDan('Eğitim öğretim faaliyetlerinizden en az 7 puan', ['E2-9'], 7, $DOCENTLIK, madde: 'Madde 5.2.4'),
        Kalip::toplam(400, $DOCENTLIK),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// 5.3 (EB) EĞİTİM BİLİMLERİ TEMEL ALANI — Ek-3
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'iyte-eb-dr',
    'aday_notu' => 'Eğitim Bilimleri Temel Alanında Dr. Öğretim Üyeliği için toplam en az 70 puan; '
        .'bunun en az 32 puanının uluslararası makalelerden (tezinizden üretilmiş olanlar dâhil) ve '
        .'en az 15 puanının atıflardan gelmesi gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['egitim'],
    'cetvel' => 'iyte-2018-e3',
    'notlar' => 'Madde 5.3.1: 32 puanı Ek-3 1(a) veya Ek-3 2(a) ve 15 puanı Ek-3 4(a)-(c)\'den '
        .'olmak üzere en az 70 puan.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma — Eğitim Bilimleri', [
        $dil,
        Kalip::puanDan('SCI, SCI-Expanded, SSCI veya AHCI makalelerinizden en az 32 puan', ['E3-1a-2a'], 32, madde: 'Madde 5.3.1'),
        Kalip::puanDan('Atıf kalemlerinizden en az 15 puan', ['E3-4'], 15, madde: 'Madde 5.3.1'),
        Kalip::toplam(70),
    ]),
];

$esikler[] = [
    'anahtar' => 'iyte-eb-dr-yeniden',
    'aday_notu' => 'Bir önceki atama tarihinizden itibaren yaptığınız çalışmalar sayılıyor. Eğitim '
        .'Bilimleri Temel Alanında yeniden atanma için SCI makaleleri, atıflar, araştırma '
        .'projeleri ve eğitim öğretim faaliyetlerinden toplam en az 10 puan isteniyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => ['egitim'],
    'cetvel' => 'iyte-2018-e3',
    'notlar' => 'Madde 5.3.2: her atama dönemi için Ek-3 1(a) veya Ek-3 4(a)-(c)\'den veya Ek-3 '
        .'6(a)-(d) veya Ek-3 8(a)-(c)\'den olmak üzere en az 10 puan.',
    'sart' => Kalip::ve('Doktor Öğretim Üyeliğine yeniden atanma — Eğitim Bilimleri', [
        Kalip::toplam(10, $SON_ATAMA, ['E3-YENIDEN'], 'Ek-3 1(a), 4, 6 ve 8. maddeleri'),
        $niyetMektubu,
    ]),
];

$esikler[] = [
    'anahtar' => 'iyte-eb-docentlik',
    'aday_notu' => 'Eğitim Bilimleri Temel Alanında doçentlik için toplam en az 150 puan; bunun en '
        .'az 48 puanının SCI makalelerinden, 50 puanının atıflardan, 4 puanının araştırma '
        .'projelerinden ve 10 puanının eğitim öğretimden gelmesi gerekiyor.'.$DOCENT_NOTU,
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['egitim'],
    'cetvel' => 'iyte-2018-e3',
    'notlar' => 'Madde 5.3.3: doktor öğretim üyeliğine yükseltildikten sonraki çalışmalardan 48 '
        .'puanı Ek-3 1(a), 50 puanı Ek-3 4(a)-(c), 4 puanı Ek-3 6(a)-(d) ve 10 puanı Ek-3 '
        .'8(a)-(c)\'den olmak üzere en az 150 puan.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — Eğitim Bilimleri', [
        $dil,
        Kalip::puanDan('SCI, SCI-Expanded, SSCI veya AHCI makalelerinizden en az 48 puan', ['E3-1a'], 48, $DOKTORA, madde: 'Madde 5.3.3'),
        Kalip::puanDan('Atıf kalemlerinizden en az 50 puan', ['E3-4'], 50, $DOKTORA, madde: 'Madde 5.3.3'),
        Kalip::puanDan('Bilimsel araştırma projesi kalemlerinizden en az 4 puan', ['E3-6'], 4, $DOKTORA, madde: 'Madde 5.3.3'),
        Kalip::puanDan('Eğitim öğretim faaliyetlerinizden en az 10 puan', ['E3-8'], 10, $DOKTORA, madde: 'Madde 5.3.3'),
        Kalip::toplam(150, $DOKTORA),
    ]),
];

$esikler[] = [
    'anahtar' => 'iyte-eb-profesorluk',
    'aday_notu' => 'Doçentliğe yükseltildiğiniz tarihten sonraki çalışmalarınız sayılıyor. Eğitim '
        .'Bilimleri Temel Alanında profesörlük için toplam en az 400 puan; bunun en az 48 puanının '
        .'SCI makalelerinden, 100 puanının atıflardan, 4 puanının araştırma projelerinden ve 10 '
        .'puanının eğitim öğretimden gelmesi gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['egitim'],
    'cetvel' => 'iyte-2018-e3',
    'notlar' => 'Madde 5.3.4: doçentliğe yükseltildikten sonraki çalışmalardan 48 puanı Ek-3 1(a), '
        .'100 puanı Ek-3 4(a)-(c), 4 puanı Ek-3 6(a)-(d) ve 10 puanı Ek-3 8(a)-(c)\'den olmak '
        .'üzere en az 400 puan.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma — Eğitim Bilimleri', [
        $dil,
        Kalip::puanDan('SCI, SCI-Expanded, SSCI veya AHCI makalelerinizden en az 48 puan', ['E3-1a'], 48, $DOCENTLIK, madde: 'Madde 5.3.4'),
        Kalip::puanDan('Atıf kalemlerinizden en az 100 puan', ['E3-4'], 100, $DOCENTLIK, madde: 'Madde 5.3.4'),
        Kalip::puanDan('Bilimsel araştırma projesi kalemlerinizden en az 4 puan', ['E3-6'], 4, $DOCENTLIK, madde: 'Madde 5.3.4'),
        Kalip::puanDan('Eğitim öğretim faaliyetlerinizden en az 10 puan', ['E3-8'], 10, $DOCENTLIK, madde: 'Madde 5.3.4'),
        Kalip::toplam(400, $DOCENTLIK),
    ]),
];

return $esikler;
