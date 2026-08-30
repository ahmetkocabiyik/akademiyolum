<?php

/**
 * GEBZE TEKNİK ÜNİVERSİTESİ — Akademik Yükseltme ve Atama Koşulları Yönergesi
 * Kaynak: pdf/17536994892.gebzeteknikuniverstesi.pdf (16 sayfa, YÖ-0055,
 * yayın 14.01.2019, revizyon 9 · 27.09.2023)
 *
 * ── YAPI: ÜÇ FAKÜLTE BLOĞU + ORTAK TEMEL İLKELER ──
 * MADDE 2 bütün başvurulara uygulanan temel ilkeleri (doktora sonrası
 * araştırmacılık, seminer, başlıca eser tanımı) veriyor; kadro koşulları
 * fakülte bloklarında:
 *   MADDE 3-6   Mühendislik · Havacılık ve Uzay Bilimleri · Temel Bilimler
 *               fakülteleri  → temel alan `muhendislik` ve `fen`
 *   MADDE 7-10  İşletme Fakültesi                          → `sosyal`
 *   MADDE 11-14 Mimarlık Fakültesi                         → `mimarlik`
 * MADDE 15 enstitüleri adayın doçentlik temel alanına göre ilgili fakültenin
 * koşullarına bağlıyor; ayrı eşik gerekmiyor.
 *
 * Yönerge başka temel alana koşul koymuyor; kalan sekiz temel alan
 * (sağlık, eğitim, ilahiyat, hukuk, filoloji, güzel sanatlar, ziraat, spor)
 * kapsam dışı bırakıldı.
 *
 * ── MATEMATİK BÖLÜMÜ AYRI BARAJ TAŞIYOR ──
 * MADDE 3.d: "toplamda en az 100 puan (Matematik Bölümü için en az 75 puan)".
 * Aynı (üniversite, kadro, temel alan) üçlüsünde iki eşik doğduğu için
 * `fen` alanının Dr. Öğr. Üyesi eşikleri `birim` ile ayrıldı. Ayrım yalnızca
 * Dr. Öğr. Üyeliğinde var; doçentlik ve profesörlükte Matematik Bölümü
 * diğer bölümlerle aynı barajı taşıyor.
 *
 * ── BAŞLICA ESER: TEMEL ALANA GÖRE ÜÇ AYRI TANIM ──
 * MADDE 2.ç üç tanım veriyor ve tanımlar puanlama tablosuna KODLA atıf
 * yapıyor; cetvelde `BASLICA-MF`, `BASLICA-MF-DR`, `BASLICA-SBI` ve
 * `BASLICA-MPT` grupları bu kümelerin birebir karşılığı.
 * Tanımın "tek yazar / ilk yazar / irtibat kurulacak yazar" kısmı `yazar:
 * 'baslica'` ile yazıldı; "öğrencileri ile birlikte yapılmış yayını olmak"
 * ve "yazar isimleri alfabetik sıralanmışsa feragatname almış olmak"
 * alternatifleri kayıttan okunamıyor, o yüzden koşul olduğundan ZOR
 * görünüyor (aday notunda söylendi).
 *
 * ── BÖLÜM BARAJLARI TABLO BAŞLIKLARINDA ──
 * Puan barajlarının bir kısmı madde metninde değil, EK 1'in bölüm
 * başlıklarında duruyor ve kadroya göre değişiyor:
 *   5 (atıf):    doçentte en az 5, profesörde en az 8 puan
 *   7 (proje):   doçent ve profesörde Mühendislik/Fen 40, Sosyal ve
 *                Mimarlık 15 puan; profesörde "doçentlikten sonra"
 *   9 (eğitim):  doçent ve profesörde en az 5 puan
 * Hepsi yazıldı. Aynı başlıkların ÜST sınırları (atıf Dr. 15 / doçent 35 /
 * profesör 50, tez danışmanlığı doçent 40 / profesör 60, eğitim Dr. 20 /
 * doçent 40 / profesör 60) cetvelin kadro varyantlarına yazıldı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 4 (Mühendislik/Havacılık/Temel Bilimler Dr. Öğr. Üyesi YENİDEN
 *       ATAMA): baraj atama süresine bağlı — 1 yıllık yeniden atamada 24,
 *       2 yıllıkta 48, 3 yıllıkta 72, 4 yıllıkta 96 puan. Atama süresi
 *       profilde yok; herhangi birini sabitlemek adaya yanlış baraj
 *       gösterirdi (KONVANSIYONLAR §"Girilmeyen tipik koşullar"). Bu üç
 *       fakültede yeniden atanma kadrosu açılmadı. İşletme (MADDE 8) ve
 *       Mimarlık (MADDE 12) yeniden atanmaları süreye bağlı olmadığı için
 *       girildi.
 *   MADDE 2.a: "ilgili birimde doktorasını GTÜ'de tamamlamış öğretim üyesi
 *       sayısının o birimdeki toplam öğretim üyesi sayısına oranı %30'u
 *       geçemez" — birimin o günkü kadro bileşimine bağlı, adayın kendi
 *       dosyasından okunamaz.
 *   MADDE 6.ç / 10.d / 14.ç: "Doçentlik unvanını aldıktan sonra en az beş
 *       yıl ... çalışmış olmak" — `beyan` olarak duruyor.
 *   GEÇİCİ MADDE 1 (Mimarlık Fakültesi Dr. Öğr. Üyeliğinde MADDE 2.b'nin
 *       hafifletilmiş hâli): yönergenin yürürlüğe girmesinden sonra YALNIZCA
 *       BİR YIL geçerli, 27.09.2023 revizyonundan bu yana süresi dolmuş
 *       sayıldı; hafifletme yazılmadı.
 *   MADDE 8.b/8.c ve 12.b/12.c'nin "en az iki farklı ders" kaydı: ders
 *       sayısı ile yarıyıl sayısı kayıttan ayrı ayrı okunamıyor; koşul
 *       yarıyıl sayısı (3) olarak yazıldı, "iki farklı ders" kısmı
 *       uygulanmıyor.
 *   MADDE 8.e / 12.f'nin "kurullarda veya komisyonlarda görev almak,
 *       Üniversite tanıtımında görev almak, okul kulüplerinde danışman
 *       olmak" dalları: puanlama tablosunun 11.3 satırı yalnızca sayılı
 *       idari görevleri tanıyor, kurul/komisyon üyeliği ve tanıtım görevi
 *       tabloda yok. Koşul yalnızca idari görev dalıyla yazıldı.
 *   MADDE 2.c'nin jüri kuruluşu, MADDE 16 yürürlük hükümleri, EK 2 başvuru
 *       belgeleri ve EK 3 Avrupa Araştırmacı Şartları — süreç kuralları.
 *
 * ── DİL ŞARTI YOK ──
 * Yönerge hiçbir kadroda yabancı dil puanı istemiyor; `Kalip::yds`
 * kullanılmadı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/gebze-teknik-2023.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Gebze Teknik Üniversitesi';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$UYARI = ' DİKKAT: başlıca eser koşulu "tek yazar, ilk yazar ya da sorumlu yazar olmak" '
    .'dalıyla uygulanıyor; yönergenin "öğrencileriyle birlikte yapılmış yayın" ve "yazar '
    .'adları alfabetikse feragatname" alternatifleri kayıttan okunamadığı için koşul '
    .'olduğundan ZOR görünür. Yönergenin "birimdeki GTÜ doktoralı öğretim üyesi oranı '
    .'%30\'u geçemez" kuralı birimin kadro bileşimine bağlı olduğu için hiç uygulanmıyor.';

$postdoc = Kalip::beyan(
    'Bir üniversite ya da araştırma kurumunda en az 1 yıl tam zamanlı doktora sonrası '
    .'araştırmacı olarak çalışmış olmak (doktorasını dünya sıralamalarında ilk 700\'e giren '
    .'bir kurumda yapanlardan, ilan tarihi itibarıyla en az 1 yıl Dr. Öğr. Üyesi ya da doçent '
    .'olarak görev yapanlardan aranmaz)',
    'MADDE 2.b',
);

$seminer = Kalip::beyan(
    'Başvurduğunuz birimde, önceden duyurusu yapılmış ve üniversiteye açık bir seminer vermiş olmak',
    'MADDE 2.c',
);

$uakDocentlik = Kalip::beyan('Üniversitelerarası Kurul tarafından verilen doçentlik unvanına sahip olmak', 'MADDE 5.a / 9.a / 13.a');

$besYil = Kalip::beyan(
    'Doçentlik unvanını aldıktan sonra en az beş yıl, açık bulunan profesörlük kadrosuyla '
    .'ilgili bölümde ya da bilim alanında çalışmış olmak',
    'MADDE 6.ç / 10.d / 14.ç',
);

// MADDE 6.d / 10.e / 14.d + GEÇİCİ MADDE 2: doktora programı olmayan
// bölümlerden başvuranlar için dört lisansüstü tez ikame ediliyor.
$doktoraTezi = Kalip::adet(
    'Asıl danışman olarak en az 1 doktora tezi tamamlatmış olmak',
    ['6.1'],
    1,
    telafi: Kalip::adet(
        'Ya da doktora programı olmayan bir bölümden başvuruyorsanız en az 4 lisansüstü tez '
        .'tamamlatmış olmak',
        ['TEZ-ASIL'],
        4,
    ),
    madde: 'MADDE 6.d / 10.e / 14.d',
);

$lisansustuTez = Kalip::adet(
    'Asıl danışman olarak en az 1 lisansüstü tez tamamlatmış olmak',
    ['TEZ-ASIL'],
    1,
    madde: 'MADDE 5.e / 9.f / 13.e',
);

$atifDocent = Kalip::puanDan('Atıf kalemlerinizden en az 5 puan', ['5'], 5, madde: 'EK 1 · 5. bölüm');
$atifProfesor = Kalip::puanDan('Atıf kalemlerinizden en az 8 puan', ['5'], 8, madde: 'EK 1 · 5. bölüm');
$egitim = Kalip::puanDan('Eğitim öğretim kalemlerinizden en az 5 puan', ['9'], 5, madde: 'EK 1 · 9. bölüm');

$esikler = [];

// ══════════════════════════════════════════════════════════════════════════
// MÜHENDİSLİK · HAVACILIK VE UZAY BİLİMLERİ · TEMEL BİLİMLER FAKÜLTELERİ
// MADDE 3-6 · temel alan: muhendislik, fen
// ══════════════════════════════════════════════════════════════════════════

$mfDrKosullari = [
    $postdoc,
    $seminer,
    Kalip::adet(
        'SCI, SCI-E, SSCI ya da AHCI kapsamındaki dergilerde tek yazar, ilk yazar ya da sorumlu '
        .'yazar olduğunuz en az 1 makaleniz olmalı (başlıca eser; tezinizden üretilmiş makale de sayılır)',
        ['BASLICA-MF-DR'], 1, yazar: 'baslica', madde: 'MADDE 3.ç',
    ),
];

foreach ([
    ['muh-fen', ['muhendislik', 'fen'], 'Matematik Bölümü dışındaki bölümler', 100],
    ['matematik', ['fen'], 'Matematik Bölümü', 75],
] as [$anahtar, $alanlar, $birim, $toplam]) {
    $esikler[] = [
        'anahtar' => "gebze-teknik-{$anahtar}-dr",
        'aday_notu' => 'Mühendislik, Havacılık ve Uzay Bilimleri ve Temel Bilimler fakültelerinde '
            ."Dr. Öğretim Üyeliği için {$birim} adaylarından toplamda en az {$toplam} puan ve en az "
            .'bir başlıca eser isteniyor. Yeniden atanma koşulları atama süresine bağlı '
            .'olduğu için burada gösterilmiyor: 1 yıllık yeniden atamada 24, 2 yıllıkta 48, '
            .'3 yıllıkta 72, 4 yıllıkta 96 puan ve bu puanın en az üçte biri makale, kitap, '
            .'bildiri, proje ve patent kalemlerinden isteniyor.'.$UYARI,
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => 'gebze-teknik-2023-mf-dr',
        'notlar' => "MADDE 3: MADDE 2.a-2.c koşulları, MADDE 2.ç.i'de tanımlı en az bir başlıca eser "
            ."ve Faaliyet Puanlama Tablosu bağlamında toplamda en az {$toplam} puan ({$birim}).",
        'sart' => Kalip::ve("Doktor Öğretim Üyesi kadrosuna atanma — {$birim}", array_merge(
            $mfDrKosullari,
            [Kalip::toplam($toplam)],
        )),
    ];
}

$esikler[] = [
    'anahtar' => 'gebze-teknik-muh-fen-docentlik',
    'aday_notu' => 'Mühendislik, Havacılık ve Uzay Bilimleri ve Temel Bilimler fakültelerinde doçent '
        .'kadrosu için toplamda en az 250 puan, bunun en az 100 puanı makale, tez yayını ve kitap '
        .'kalemlerinden isteniyor. Başlıca eser koşulu doktora derecenizi aldıktan sonraki '
        .'yayınlarınıza bakıyor; toplam puanda dönem sınırı yok.'.$UYARI,
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['muhendislik', 'fen'],
    'cetvel' => 'gebze-teknik-2023-mf-docent',
    'notlar' => 'MADDE 5: doçentlik unvanı, MADDE 2.b-2.c, doktora sonrası en az iki başlıca eser '
        .'(MADDE 2.ç.i), 1-2-3 kodlu başlıklardan en az 100 puan, toplamda en az 250 puan ve asıl '
        .'danışman olarak tamamlatılmış en az bir lisansüstü tez. EK 1 bölüm barajları: atıf 5, '
        .'proje 40, eğitim 5 puan.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — Mühendislik, Havacılık ve Uzay Bilimleri, Temel Bilimler', [
        $uakDocentlik,
        $postdoc,
        $seminer,
        Kalip::adet(
            'Doktora derecenizi aldıktan sonra, SCI, SCI-E, SSCI ya da AHCI kapsamındaki dergilerde '
            .'tek yazar, ilk yazar ya da sorumlu yazar olduğunuz en az 2 makaleniz olmalı (başlıca eser)',
            ['BASLICA-MF'], 2, yazar: 'baslica', donem: $DOKTORA, madde: 'MADDE 5.ç',
        ),
        Kalip::puanDan('Makale, tez yayını ve kitap kalemlerinizden en az 100 puan', ['1-2-3'], 100, madde: 'MADDE 5.d'),
        $atifDocent,
        Kalip::puanDan('Bilimsel araştırma projesi kalemlerinizden en az 40 puan', ['7'], 40, madde: 'EK 1 · 7. bölüm'),
        $egitim,
        $lisansustuTez,
        Kalip::toplam(250),
    ]),
];

$esikler[] = [
    'anahtar' => 'gebze-teknik-muh-fen-profesorluk',
    'aday_notu' => 'Mühendislik, Havacılık ve Uzay Bilimleri ve Temel Bilimler fakültelerinde profesör '
        .'kadrosu için toplamda en az 400 puan, bunun en az 200 puanı 1, 2, 3, 4 ve 7.1-7.6 kodlu '
        .'faaliyetlerden isteniyor; tez yayınlarından (2 kodlu başlık) bu 200 puanın en fazla 80\'i '
        .'sayılabiliyor. Beş başlıca eserin en az üçü doçentlik unvanınızı aldıktan sonra olmalı.'.$UYARI,
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['muhendislik', 'fen'],
    'cetvel' => 'gebze-teknik-2023-mf-profesor',
    'notlar' => 'MADDE 6: en az üçü doçentlik sonrası olmak üzere MADDE 2.ç.i tanımlı beş başlıca eser, '
        .'MADDE 2.b, 1-2-3-4 ve 7.1-7.6 kodlu başlıklardan en az 200 puan (2 kodlu başlıktan en fazla '
        .'80), toplamda en az 400 puan, doçentlik sonrası beş yıl çalışma ve asıl danışman olarak '
        .'tamamlatılmış en az bir doktora tezi (ya da GEÇİCİ MADDE 2). EK 1 bölüm barajları: atıf 8, '
        .'proje 40 (doçentlik sonrası), eğitim 5 puan.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma — Mühendislik, Havacılık ve Uzay Bilimleri, Temel Bilimler', [
        $postdoc,
        $seminer,
        Kalip::adet(
            'SCI, SCI-E, SSCI ya da AHCI kapsamındaki dergilerde tek yazar, ilk yazar ya da sorumlu '
            .'yazar olduğunuz en az 5 makaleniz olmalı (başlıca eser)',
            ['BASLICA-MF'], 5, yazar: 'baslica', madde: 'MADDE 6.a',
        ),
        Kalip::adet(
            'Bu beş başlıca eserin en az 3\'ü doçentlik unvanınızı aldıktan sonra olmalı',
            ['BASLICA-MF'], 3, yazar: 'baslica', donem: $DOCENTLIK, madde: 'MADDE 6.a',
        ),
        Kalip::puanDan(
            'Makale, tez yayını, kitap, ödül-patent ve 7.1-7.6 kodlu proje kalemlerinizden en az 200 puan',
            ['1-2-3-4-7.1-7.6'], 200, madde: 'MADDE 6.c',
        ),
        $atifProfesor,
        Kalip::puanDan('Doçentlik sonrası bilimsel araştırma projesi kalemlerinizden en az 40 puan', ['7'], 40, $DOCENTLIK, madde: 'EK 1 · 7. bölüm'),
        $egitim,
        $besYil,
        $doktoraTezi,
        Kalip::toplam(400),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// İŞLETME FAKÜLTESİ · MADDE 7-10 · temel alan: sosyal
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'gebze-teknik-isletme-dr',
    'aday_notu' => 'İşletme Fakültesinde Dr. Öğretim Üyeliği için toplamda en az 50 puan, en az bir '
        .'SCI/SCI-E/SSCI/AHCI makalesi ve en az bir başlıca eser isteniyor.'.$UYARI,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['sosyal'],
    'cetvel' => 'gebze-teknik-2023-sbi-dr',
    'notlar' => 'MADDE 7: MADDE 2.a-2.c koşulları, SCI/SCI-E/SSCI/AHCI kapsamında en az bir özgün '
        .'makale, MADDE 2.ç.ii\'de tanımlı en az bir başlıca eser ve toplamda en az 50 puan.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma — İşletme Fakültesi', [
        $postdoc,
        $seminer,
        Kalip::adet('SCI, SCI-E, SSCI ya da AHCI kapsamındaki dergilerde en az 1 özgün makaleniz olmalı', ['SCI-MAKALE'], 1, madde: 'MADDE 7.ç'),
        Kalip::adet(
            'Makale, tez yayını ya da kitap türünden, tek yazar, ilk yazar ya '
            .'da sorumlu yazar olduğunuz en az 1 eseriniz olmalı (başlıca eser)',
            ['BASLICA-SBI'], 1, yazar: 'baslica', madde: 'MADDE 7.d',
        ),
        Kalip::toplam(50),
    ]),
];

$esikler[] = [
    'anahtar' => 'gebze-teknik-isletme-dr-yeniden',
    'aday_notu' => 'Bir önceki atama tarihinizden itibaren yaptığınız çalışmalar sayılıyor. İşletme '
        .'Fakültesinde yeniden atanmada puan barajı yok: son atamanızdan sonra en az bir başlıca eser '
        .'ve aşağıdaki beş ölçütten en az ikisi isteniyor. Yönergenin "kurullarda veya komisyonlarda '
        .'görev almak, Üniversite tanıtımında görev almak, okul kulüplerinde danışman olmak" dalları '
        .'faaliyet kaydından okunamadığı için idari görev ölçütü yalnızca sayılı idari görevlerle '
        .'değerlendiriliyor; "en az iki farklı ders" koşulu da uygulanamıyor. Bu iki ölçütü '
        .'sağlıyorsanız gerçek durumunuz ekrandakinden iyidir.'.$UYARI,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => ['sosyal'],
    'cetvel' => 'gebze-teknik-2023-sbi-dr',
    'notlar' => 'MADDE 8: son atama tarihinden sonra MADDE 2.ç.ii tanımlı en az bir başlıca eser ve '
        .'b-e bentlerinden en az ikisi. Puan barajı yok.',
    'sart' => Kalip::ve('Doktor Öğretim Üyeliğine yeniden atanma — İşletme Fakültesi', [
        Kalip::adet(
            'Son atamanızdan sonra makale, tez yayını ya da kitap türünden, tek yazar, ilk yazar ya da '
            .'sorumlu yazar olduğunuz en az 1 eseriniz olmalı (başlıca eser)',
            ['BASLICA-SBI'], 1, yazar: 'baslica', donem: $SON_ATAMA, madde: 'MADDE 8.a',
        ),
        Kalip::kIle('Aşağıdaki ölçütlerden en az 2 tanesini sağlamalısınız', 2, [
            Kalip::adet('En az 3 yarıyıl lisans dersi yürütmüş olmak', ['9.2'], 3, donem: $SON_ATAMA, madde: 'MADDE 8.b'),
            Kalip::adet('En az 3 yarıyıl lisansüstü ders yürütmüş olmak', ['9.1'], 3, donem: $SON_ATAMA, madde: 'MADDE 8.c'),
            Kalip::adet('Başlıca eserinize ek olarak en az 2 makale ya da bildiriniz olmak', ['MAKALE-BILDIRI'], 2, donem: $SON_ATAMA, madde: 'MADDE 8.ç'),
            Kalip::adet('Üniversite kaynakları dışındaki ulusal ya da uluslararası bir projede yürütücü veya araştırmacı olmak', ['PROJE-DIS'], 1, donem: $SON_ATAMA, madde: 'MADDE 8.d'),
            Kalip::adet('Üniversite ya da birim yönetiminde en az bir yıl idari görev almış olmak', ['11.3'], 1, donem: $SON_ATAMA, madde: 'MADDE 8.e'),
        ]),
    ]),
];

$esikler[] = [
    'anahtar' => 'gebze-teknik-isletme-docentlik',
    'aday_notu' => 'İşletme Fakültesinde doçent kadrosu için toplamda en az 200 puan, bunun en az 100 '
        .'puanı makale, tez yayını, kitap ve ödül-patent kalemlerinden isteniyor.'.$UYARI,
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['sosyal'],
    'cetvel' => 'gebze-teknik-2023-sbi-docent',
    'notlar' => 'MADDE 9: doçentlik unvanı, MADDE 2.b-2.c, en az biri doktora sonrası olmak üzere '
        .'SCI/SCI-E/SSCI/AHCI kapsamında toplam iki özgün makale, MADDE 2.ç.ii tanımlı en az iki '
        .'başlıca eser, 1-2-3-4 kodlu başlıklardan en az 100 puan, toplamda en az 200 puan ve asıl '
        .'danışman olarak tamamlatılmış en az bir lisansüstü tez. EK 1 bölüm barajları: atıf 5, '
        .'proje 15, eğitim 5 puan.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — İşletme Fakültesi', [
        $uakDocentlik,
        $postdoc,
        $seminer,
        Kalip::adet('SCI, SCI-E, SSCI ya da AHCI kapsamındaki dergilerde en az 2 özgün makaleniz olmalı', ['SCI-MAKALE'], 2, madde: 'MADDE 9.ç'),
        Kalip::adet('Bu makalelerden en az 1\'i doktora derecenizi aldıktan sonra olmalı', ['SCI-MAKALE'], 1, donem: $DOKTORA, madde: 'MADDE 9.ç'),
        Kalip::adet(
            'Makale, tez yayını ya da kitap türünden, tek yazar, ilk yazar ya da sorumlu yazar olduğunuz '
            .'en az 2 eseriniz olmalı (başlıca eser)',
            ['BASLICA-SBI'], 2, yazar: 'baslica', madde: 'MADDE 9.d',
        ),
        Kalip::puanDan('Makale, tez yayını, kitap ve ödül-patent kalemlerinizden en az 100 puan', ['1-2-3-4'], 100, madde: 'MADDE 9.e'),
        $atifDocent,
        Kalip::puanDan('Bilimsel araştırma projesi kalemlerinizden en az 15 puan', ['7'], 15, madde: 'EK 1 · 7. bölüm'),
        $egitim,
        $lisansustuTez,
        Kalip::toplam(200),
    ]),
];

$esikler[] = [
    'anahtar' => 'gebze-teknik-isletme-profesorluk',
    'aday_notu' => 'İşletme Fakültesinde profesör kadrosu için toplamda en az 300 puan, bunun en az '
        .'150 puanı makale, tez yayını, kitap ve ödül-patent kalemlerinden isteniyor. Dört '
        .'SCI/SCI-E/SSCI/AHCI makalesinin en az ikisi doçentlik unvanınızı aldıktan sonra olmalı.'.$UYARI,
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['sosyal'],
    'cetvel' => 'gebze-teknik-2023-sbi-profesor',
    'notlar' => 'MADDE 10: en az ikisi doçentlik sonrası olmak üzere SCI/SCI-E/SSCI/AHCI kapsamında '
        .'toplam dört özgün makale, MADDE 2.b, doçentlik sonrası MADDE 2.ç.ii tanımlı en az iki '
        .'başlıca eser, 1-2-3-4 kodlu başlıklardan en az 150 puan, toplamda en az 300 puan, '
        .'doçentlik sonrası beş yıl çalışma ve asıl danışman olarak tamamlatılmış en az bir doktora '
        .'tezi (ya da GEÇİCİ MADDE 2). EK 1 bölüm barajları: atıf 8, proje 15 (doçentlik sonrası), '
        .'eğitim 5 puan.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma — İşletme Fakültesi', [
        $postdoc,
        $seminer,
        Kalip::adet('SCI, SCI-E, SSCI ya da AHCI kapsamındaki dergilerde en az 4 özgün makaleniz olmalı', ['SCI-MAKALE'], 4, madde: 'MADDE 10.a'),
        Kalip::adet('Bu makalelerden en az 2\'si doçentlik unvanınızı aldıktan sonra olmalı', ['SCI-MAKALE'], 2, donem: $DOCENTLIK, madde: 'MADDE 10.a'),
        Kalip::adet(
            'Doçentlik unvanınızı aldıktan sonra makale, tez yayını ya da kitap türünden, tek yazar, ilk '
            .'yazar ya da sorumlu yazar olduğunuz en az 2 eseriniz olmalı (başlıca eser)',
            ['BASLICA-SBI'], 2, yazar: 'baslica', donem: $DOCENTLIK, madde: 'MADDE 10.c',
        ),
        Kalip::puanDan('Makale, tez yayını, kitap ve ödül-patent kalemlerinizden en az 150 puan', ['1-2-3-4'], 150, madde: 'MADDE 10.ç'),
        $atifProfesor,
        Kalip::puanDan('Doçentlik sonrası bilimsel araştırma projesi kalemlerinizden en az 15 puan', ['7'], 15, $DOCENTLIK, madde: 'EK 1 · 7. bölüm'),
        $egitim,
        $besYil,
        $doktoraTezi,
        Kalip::toplam(300),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// MİMARLIK FAKÜLTESİ · MADDE 11-14 · temel alan: mimarlik
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'gebze-teknik-mimarlik-dr',
    'aday_notu' => 'Mimarlık Fakültesinde Dr. Öğretim Üyeliği için toplamda en az 50 puan ve en az bir '
        .'başlıca eser isteniyor. Mimarlık adaylarında başlıca eser tanımı yayınların yanı sıra '
        .'yarışma ödülü, uygulama projesi ve patent kalemlerini de kapsıyor.'.$UYARI,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['mimarlik'],
    'cetvel' => 'gebze-teknik-2023-mpt-dr',
    'notlar' => 'MADDE 11: MADDE 2.a-2.c koşulları, MADDE 2.ç.iii\'te tanımlı en az bir başlıca eser '
        .'ve toplamda en az 50 puan. GEÇİCİ MADDE 1\'in bir yıllık hafifletmesi süresi dolduğu için '
        .'yazılmadı.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma — Mimarlık Fakültesi', [
        $postdoc,
        $seminer,
        Kalip::adet(
            'Makale, tez yayını ya da kitap türünden, tek yazar, ilk yazar ya '
            .'da sorumlu yazar olduğunuz en az 1 eseriniz ya da 4.1, 4.2, 4.3, 4.7, 4.8 kodlu '
            .'kalemlerden birine sahip olmanız gerekiyor (başlıca eser)',
            ['BASLICA-MPT'], 1, yazar: 'baslica', madde: 'MADDE 11.ç',
        ),
        Kalip::toplam(50),
    ]),
];

$esikler[] = [
    'anahtar' => 'gebze-teknik-mimarlik-dr-yeniden',
    'aday_notu' => 'Bir önceki atama tarihinizden itibaren yaptığınız çalışmalar sayılıyor. Mimarlık '
        .'Fakültesinde yeniden atanmada puan barajı yok: son atamanızdan sonra en az bir başlıca eser '
        .'ve aşağıdaki altı ölçütten en az üçü isteniyor. "En az iki farklı ders" koşulu ile idari '
        .'görev ölçütünün kurul, komisyon ve tanıtım dalları faaliyet kaydından okunamadığı için '
        .'uygulanmıyor; bunları sağlıyorsanız gerçek durumunuz ekrandakinden iyidir.'.$UYARI,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => ['mimarlik'],
    'cetvel' => 'gebze-teknik-2023-mpt-dr',
    'notlar' => 'MADDE 12: son atama tarihinden sonra MADDE 2.ç.iii tanımlı en az bir başlıca eser ve '
        .'b-f bentlerinden en az üçü. Puan barajı yok.',
    'sart' => Kalip::ve('Doktor Öğretim Üyeliğine yeniden atanma — Mimarlık Fakültesi', [
        Kalip::adet(
            'Son atamanızdan sonra makale, tez yayını ya da kitap türünden en az 1 başlıca eseriniz olmalı',
            ['BASLICA-MPT'], 1, yazar: 'baslica', donem: $SON_ATAMA, madde: 'MADDE 12.a',
        ),
        Kalip::kIle('Aşağıdaki ölçütlerden en az 3 tanesini sağlamalısınız', 3, [
            Kalip::adet('En az 3 yarıyıl lisans dersi yürütmüş olmak', ['9.2'], 3, donem: $SON_ATAMA, madde: 'MADDE 12.b'),
            Kalip::adet('En az 3 yarıyıl lisansüstü ders yürütmüş olmak', ['9.1'], 3, donem: $SON_ATAMA, madde: 'MADDE 12.c'),
            Kalip::adet('Başlıca eserinize ek olarak en az 2 makale ya da bildiriniz olmak', ['MAKALE-BILDIRI'], 2, donem: $SON_ATAMA, madde: 'MADDE 12.ç'),
            Kalip::adet('Ulusal ya da uluslararası proje yarışmalarında ödül almış olmak', ['YARISMA-ODUL'], 1, donem: $SON_ATAMA, madde: 'MADDE 12.d'),
            Kalip::adet('Üniversite kaynakları dışındaki ulusal ya da uluslararası bir projede yürütücü veya araştırmacı olmak', ['PROJE-DIS'], 1, donem: $SON_ATAMA, madde: 'MADDE 12.e'),
            Kalip::adet('Üniversite ya da birim yönetiminde en az bir yıl idari görev almış olmak', ['11.3'], 1, donem: $SON_ATAMA, madde: 'MADDE 12.f'),
        ]),
    ]),
];

$esikler[] = [
    'anahtar' => 'gebze-teknik-mimarlik-docentlik',
    'aday_notu' => 'Mimarlık Fakültesinde doçent kadrosu için toplamda en az 200 puan, bunun en az 100 '
        .'puanı makale, tez yayını, kitap ve ödül-patent kalemlerinden isteniyor. DİKKAT: yönergenin '
        .'puanlama tablosunda sergi, konser ya da tasarım gibi sanatsal etkinlik satırı yok; sanat ve '
        .'tasarım üretiminiz yalnızca yarışma ödülü, uygulama projesi ve patent satırlarından puan '
        .'alabiliyor.'.$UYARI,
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['mimarlik'],
    'cetvel' => 'gebze-teknik-2023-mpt-docent',
    'notlar' => 'MADDE 13: doçentlik unvanı, MADDE 2.b-2.c, en az biri doktora sonrası olmak üzere '
        .'MADDE 2.ç.iii tanımlı en az iki başlıca eser, 1-2-3-4 kodlu başlıklardan en az 100 puan, '
        .'toplamda en az 200 puan ve asıl danışman olarak tamamlatılmış en az bir lisansüstü tez. '
        .'EK 1 bölüm barajları: atıf 5, proje 15, eğitim 5 puan.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — Mimarlık Fakültesi', [
        $uakDocentlik,
        $postdoc,
        $seminer,
        Kalip::adet(
            'Makale, tez yayını ya da kitap türünden en az 2 başlıca eseriniz olmalı',
            ['BASLICA-MPT'], 2, yazar: 'baslica', madde: 'MADDE 13.ç',
        ),
        Kalip::adet(
            'Bu başlıca eserlerden en az 1\'i doktora derecenizi aldıktan sonra olmalı',
            ['BASLICA-MPT'], 1, yazar: 'baslica', donem: $DOKTORA, madde: 'MADDE 13.ç',
        ),
        Kalip::puanDan('Makale, tez yayını, kitap ve ödül-patent kalemlerinizden en az 100 puan', ['1-2-3-4'], 100, madde: 'MADDE 13.d'),
        $atifDocent,
        Kalip::puanDan('Bilimsel araştırma projesi kalemlerinizden en az 15 puan', ['7'], 15, madde: 'EK 1 · 7. bölüm'),
        $egitim,
        $lisansustuTez,
        Kalip::toplam(200),
    ]),
];

$esikler[] = [
    'anahtar' => 'gebze-teknik-mimarlik-profesorluk',
    'aday_notu' => 'Mimarlık Fakültesinde profesör kadrosu için toplamda en az 300 puan, bunun en az '
        .'150 puanı makale, tez yayını, kitap ve ödül-patent kalemlerinden isteniyor. Dört başlıca '
        .'eserin en az ikisi doçentlik unvanınızı aldıktan sonra olmalı. DİKKAT: yönergenin puanlama '
        .'tablosunda sanatsal etkinlik satırı yok.'.$UYARI,
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['mimarlik'],
    'cetvel' => 'gebze-teknik-2023-mpt-profesor',
    'notlar' => 'MADDE 14: en az ikisi doçentlik sonrası olmak üzere MADDE 2.ç.iii tanımlı dört '
        .'başlıca eser, MADDE 2.b, 1-2-3-4 kodlu başlıklardan en az 150 puan, toplamda en az 300 '
        .'puan, doçentlik sonrası beş yıl çalışma ve asıl danışman olarak tamamlatılmış en az bir '
        .'doktora tezi (ya da GEÇİCİ MADDE 2). EK 1 bölüm barajları: atıf 8, proje 15 (doçentlik '
        .'sonrası), eğitim 5 puan.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma — Mimarlık Fakültesi', [
        $postdoc,
        $seminer,
        Kalip::adet(
            'Makale, tez yayını ya da kitap türünden en az 4 başlıca eseriniz olmalı',
            ['BASLICA-MPT'], 4, yazar: 'baslica', madde: 'MADDE 14.a',
        ),
        Kalip::adet(
            'Bu başlıca eserlerin en az 2\'si doçentlik unvanınızı aldıktan sonra olmalı',
            ['BASLICA-MPT'], 2, yazar: 'baslica', donem: $DOCENTLIK, madde: 'MADDE 14.a',
        ),
        Kalip::puanDan('Makale, tez yayını, kitap ve ödül-patent kalemlerinizden en az 150 puan', ['1-2-3-4'], 150, madde: 'MADDE 14.c'),
        $atifProfesor,
        Kalip::puanDan('Doçentlik sonrası bilimsel araştırma projesi kalemlerinizden en az 15 puan', ['7'], 15, $DOCENTLIK, madde: 'EK 1 · 7. bölüm'),
        $egitim,
        $besYil,
        $doktoraTezi,
        Kalip::toplam(300),
    ]),
];

return $esikler;
