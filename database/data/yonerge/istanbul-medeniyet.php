<?php

/**
 * İSTANBUL MEDENİYET ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve
 * Atanma Yönergesi
 * Kaynak: pdf/17536997062.istanbulmedeniyetuniverstesi.pdf (7 sayfa;
 * PDF oluşturma tarihi 06.12.2018)
 *
 * ── YAPI: TEK MADDE, ÜÇ KADRO ──
 * MADDE 7 bütün kadrolara dil şartı koyuyor, MADDE 8 üç kadronun akademik
 * etkinlik şartlarını veriyor:
 *   8(1) Dr. Öğretim Üyesi — PUAN BARAJI YOK; dört "akademik eser"
 *        şartından ikisini sağlamak yeterli. Son cümle "Yeniden atamalarda
 *        ilk atama şartı aranır" dediği için yeniden atanma eşiği ilk
 *        atanmanın birebir aynısı (dönem kısıtı da yok).
 *   8(2) Doçent — toplam 120 puan, en az 100'ü doktora sonrası.
 *   8(3) Profesör — doçentlik sonrası en az 150 puan.
 *   8(4) Sanat, Tasarım ve Mimarlık Fakültesi doçent ve profesörleri bu
 *        puanların en az 30'unu tablonun 1., 2. ve 4. bölümlerinden almalı.
 *
 * Yönerge hiçbir temel alanı dışlamıyor ve 8(4) dışında alana göre baraj
 * değiştirmiyor; on iki temel alanın hepsine eşik yazıldı. Sanat, Tasarım
 * ve Mimarlık Fakültesi `guzel_sanatlar` ve `mimarlik` temel alanlarına
 * eşlendi ve o iki alanda doçentlik ile profesörlük ayrı eşik taşıyor.
 *
 * ── KAYNAKTAKİ HATA OLDUĞU GİBİ BIRAKILDI ──
 * MADDE 8(4) "Madde 8'in 3. ve 4. bentlerinde belirtilen puanların en az
 * 30'u" diyor, ama puan barajları 8(2) ve 8(3) bentlerinde; 8(4) zaten
 * bendin kendisi. Cümlenin öznesi "doçent kadrosuna atanmak, profesör
 * kadrosuna yükseltilmek veya atanmak" olduğu için koşul bu iki kadroya
 * uygulandı, numaralandırma hatası düzeltilmeden kaydedildi.
 *
 * ── TABLO DİPNOTLARI DA EŞİĞİN PARÇASI ──
 * Puanlama Tablosunun bölüm altlarındaki zorunluluklar koşul olarak
 * yazıldı:
 *   2. bölüm (ulusal makale): "Bu madde kapsamında en az 10 puan
 *       alınmalıdır."
 *   7. bölüm (atıflar): "Profesör ve Doçent atamalarında bu madde
 *       kapsamında en az 10 puan alınmalıdır."
 *   10. bölüm (bilimsel toplantı): "Profesör ve Doçent atamalarında bu
 *       madde kapsamında en az 4 puan alınmalıdır."
 * 2. bölümün dipnotu hangi kadroyu bağladığını söylemiyor; Dr. Öğretim
 * Üyeliğinde puan tablosu hiç kullanılmadığı için doçent ve profesöre
 * uygulandı. Dipnot barajlarının dönemi kadronun kendi toplam barajıyla
 * aynı tutuldu (doçentte dönemsiz, profesörde doçentlik sonrası).
 * Bölüm TAVANLARI (atıf 25, tez danışmanlığı 10, proje 40, toplantı 15,
 * eğitim 10, dergi görevleri 25) cetvelde `grup_tavanlari` olarak duruyor.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 7(1): yabancı dille eğitim yapan programlarda YDS yerine
 *       "ilgili yabancı dilde ders verebilme şartını sağlamak" — programın
 *       eğitim dili ve adayın ders verme yeterliği profilde yok; herkese
 *       MADDE 7(2)'nin 65 puanlık YDS eşiği uygulandı, aday notunda
 *       alternatif anlatıldı.
 *   MADDE 8(2)a ve 8(3)a: "Üniversitelerarası Kurul tarafından belirlenecek
 *       jürilerce yapılacak sözlü sınavdan başarılı olmak" — `beyan`.
 *   MADDE 9: ön değerlendirme komisyonlarının kuruluşu — süreç kuralı.
 *   MADDE 10: "eserlerin yayımlanmış veya yayımlanmak üzere kabul yazısı
 *       almış olması" — kaydın kapsamını genişleten kural, baraj değil.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/istanbul-medeniyet-2018.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'İstanbul Medeniyet Üniversitesi';
$CETVEL = 'istanbul-medeniyet-2018';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;

$DIGER_ALANLAR = ['sosyal', 'fen', 'muhendislik', 'saglik', 'egitim', 'ilahiyat',
    'hukuk', 'filoloji', 'ziraat', 'spor'];
$SANAT_ALANLARI = ['guzel_sanatlar', 'mimarlik'];

$DIL_NOTU = ' Yabancı dille eğitim yapan bir lisans programına başvuruyorsanız YDS yerine '
    .'"ilgili yabancı dilde ders verebilme" şartı geçerli; bu şart profilden '
    .'okunamadığı için burada herkese 65 puanlık dil eşiği uygulanıyor.';

$dil = Kalip::yds(65);

$docentUnvani = Kalip::beyan(
    'Doçentlik unvanına sahip olmak ve Üniversitelerarası Kurul tarafından belirlenecek '
    .'jürilerce yapılacak sözlü sınavdan başarılı olmak',
    'MADDE 8/2-a ve 8/3-a',
);

$ulusalMakaleBaraji = fn (?array $donem): array => Kalip::puanDan(
    'Ulusal makale kalemlerinizden en az 10 puan',
    ['2'], 10, $donem, madde: 'Puanlama Tablosu · 2. bölüm dipnotu',
);

$atifBaraji = fn (?array $donem): array => Kalip::puanDan(
    'Atıf kalemlerinizden en az 10 puan',
    ['7'], 10, $donem, madde: 'Puanlama Tablosu · 7. bölüm dipnotu',
);

$toplantiBaraji = fn (?array $donem): array => Kalip::puanDan(
    'Bilimsel toplantı kalemlerinizden en az 4 puan',
    ['10'], 4, $donem, madde: 'Puanlama Tablosu · 10. bölüm dipnotu',
);

$sanatBaraji = fn (?array $donem): array => Kalip::puanDan(
    'Bu puanın en az 30\'u uluslararası makale, ulusal makale ve kitap kalemlerinizden gelmeli',
    ['1-2-4'], 30, $donem, madde: 'MADDE 8/4',
);

// MADDE 8(1): dört akademik eser şartından ikisi. Aynı düğüm hem ilk
// atanmada hem yeniden atanmada kullanılıyor ("Yeniden atamalarda ilk
// atama şartı aranır").
$drKosullari = [
    $dil,
    Kalip::beyan(
        'Doktora, tıpta uzmanlık ya da sanatta yeterlilik unvanını aldıktan sonra en az bir yıl geçmiş olmak',
        'MADDE 8/1',
    ),
    Kalip::kIle('Aşağıdaki akademik eser şartlarından en az 2 tanesini sağlamalısınız', 2, [
        Kalip::adet('SCI, SCI-Expanded, SSCI ya da AHCI tarafından taranan dergilerde en az 1 özgün makaleniz olmalı', ['SCI-MAKALE'], 1, madde: 'MADDE 8/1-a'),
        Kalip::adet('Uluslararası niteliğe sahip hakemli dergilerde en az 1 makaleniz olmalı', ['ULUSLARARASI-MAKALE'], 1, madde: 'MADDE 8/1-b'),
        Kalip::adet('Tanınmış ulusal ya da uluslararası yayınevlerince yayımlanmış en az 1 kitabınız veya kitap bölümünüz olmalı', ['KITAP-BOLUM'], 1, madde: 'MADDE 8/1-c'),
        Kalip::adet('ULAKBİM tarafından taranan ulusal hakemli dergilerde en az 1 tam makaleniz olmalı', ['ULAKBIM-MAKALE'], 1, madde: 'MADDE 8/1-d'),
    ]),
];

$drNotu = 'Dr. Öğretim Üyeliğinde puan barajı YOK: yönerge dört akademik eser şartından ikisini '
    .'sağlamanızı ve doktora unvanınızın üzerinden en az bir yıl geçmiş olmasını istiyor. Puanlama '
    .'Tablosu bu kadroda kullanılmıyor; ekranda gördüğünüz puan yalnızca bilgi amaçlıdır.'.$DIL_NOTU;

$esikler = [
    [
        'anahtar' => 'istanbul-medeniyet-dr',
        'aday_notu' => $drNotu,
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi',
        'alan' => [...$DIGER_ALANLAR, ...$SANAT_ALANLARI],
        'cetvel' => $CETVEL,
        'notlar' => 'MADDE 7 ve MADDE 8/1: dil şartı 65 puan; doktora/tıpta uzmanlık/sanatta '
            .'yeterlilik unvanının üzerinden en az bir yıl geçmiş olmak; a-d bentlerindeki '
            .'akademik eser şartlarından toplamda ikisini sağlamak. Puan barajı yok.',
        'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma', $drKosullari),
    ],
    [
        'anahtar' => 'istanbul-medeniyet-dr-yeniden',
        'aday_notu' => 'Yeniden atanmada (görev süresi uzatımı) yönerge ilk atanma şartlarının '
            .'aynısını arıyor; dönem kısıtı koymadığı için bütün '
            .'çalışmalarınız sayılıyor. '.$drNotu,
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => [...$DIGER_ALANLAR, ...$SANAT_ALANLARI],
        'cetvel' => $CETVEL,
        'notlar' => 'MADDE 8/1 son cümle: "Yeniden atamalarda ilk atama şartı aranır." Koşullar '
            .'ilk atanmayla birebir aynı, dönem kısıtı yok.',
        'sart' => Kalip::ve('Doktor Öğretim Üyeliğine yeniden atanma', $drKosullari),
    ],
];

// ── Doçentlik ve profesörlük: sanat/mimarlık alanları ek baraj taşıyor ──

$docentKosullari = [
    $dil,
    $docentUnvani,
    Kalip::toplam(100, $DOKTORA, ['*'], 'Puanlama Tablosunun tamamı (doktora sonrası)'),
    $ulusalMakaleBaraji(null),
    $atifBaraji(null),
    $toplantiBaraji(null),
];

$profesorKosullari = [
    $dil,
    $docentUnvani,
    $ulusalMakaleBaraji($DOCENTLIK),
    $atifBaraji($DOCENTLIK),
    $toplantiBaraji($DOCENTLIK),
];

$docentNotu = 'Doçent kadrosu için Puanlama Tablosundan toplam en az 120 puan gerekiyor; bunun en '
    .'az 100 puanı doktora, tıpta uzmanlık ya da sanatta yeterlilik unvanınızı aldıktan sonraki '
    .'çalışmalardan olmalı. Tablo dipnotları ayrıca ulusal makaleden en az 10, atıftan en az 10 ve '
    .'bilimsel toplantıdan en az 4 puan istiyor.'.$DIL_NOTU;

$profesorNotu = 'Doçent unvanınızı aldığınız tarihten sonraki çalışmalarınız sayılıyor. Profesör '
    .'kadrosu için Puanlama Tablosundan en az 150 puan gerekiyor. Tablo dipnotları ayrıca ulusal '
    .'makaleden en az 10, atıftan en az 10 ve bilimsel toplantıdan en az 4 puan istiyor.'.$DIL_NOTU;

$sanatNotu = ' Sanat, Tasarım ve Mimarlık Fakültesi adaylarında bu puanın en az 30\'u Puanlama '
    .'Tablosunun 1. (uluslararası makale), 2. (ulusal makale) ve 4. (kitap) bölümlerinden gelmeli '
    .'.';

$esikler[] = [
    'anahtar' => 'istanbul-medeniyet-docentlik',
    'aday_notu' => $docentNotu,
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => $DIGER_ALANLAR,
    'cetvel' => $CETVEL,
    'notlar' => 'MADDE 7 ve MADDE 8/2: dil şartı 65 puan; doçentlik unvanı ve ÜAK sözlü sınavı; '
        .'en az 100 puanı doktora sonrası olmak üzere toplam en az 120 puan. Tablo dipnotları: '
        .'ulusal makale 10, atıf 10, bilimsel toplantı 4 puan.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma', [...$docentKosullari, Kalip::toplam(120)]),
];

$esikler[] = [
    'anahtar' => 'istanbul-medeniyet-sanat-docentlik',
    'aday_notu' => $docentNotu.$sanatNotu,
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => $SANAT_ALANLARI,
    'birim' => 'Sanat, Tasarım ve Mimarlık Fakültesi',
    'cetvel' => $CETVEL,
    'notlar' => 'MADDE 7, MADDE 8/2 ve MADDE 8/4: doçentlik koşullarına ek olarak puanın en az '
        .'30\'unun Puanlama Tablosunun 1., 2. ve 4. bölümlerinden sağlanması.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — Sanat, Tasarım ve Mimarlık Fakültesi', [
        ...$docentKosullari,
        $sanatBaraji(null),
        Kalip::toplam(120),
    ]),
];

$esikler[] = [
    'anahtar' => 'istanbul-medeniyet-profesorluk',
    'aday_notu' => $profesorNotu,
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => $DIGER_ALANLAR,
    'cetvel' => $CETVEL,
    'notlar' => 'MADDE 7 ve MADDE 8/3: dil şartı 65 puan; doçentlik unvanı ve ÜAK sözlü sınavı; '
        .'doçentlik sonrası çalışmalardan en az 150 puan. Tablo dipnotları: ulusal makale 10, '
        .'atıf 10, bilimsel toplantı 4 puan.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma', [
        ...$profesorKosullari,
        Kalip::toplam(150, $DOCENTLIK),
    ]),
];

$esikler[] = [
    'anahtar' => 'istanbul-medeniyet-sanat-profesorluk',
    'aday_notu' => $profesorNotu.$sanatNotu,
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => $SANAT_ALANLARI,
    'birim' => 'Sanat, Tasarım ve Mimarlık Fakültesi',
    'cetvel' => $CETVEL,
    'notlar' => 'MADDE 7, MADDE 8/3 ve MADDE 8/4: profesörlük koşullarına ek olarak puanın en az '
        .'30\'unun Puanlama Tablosunun 1., 2. ve 4. bölümlerinden sağlanması.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma — Sanat, Tasarım ve Mimarlık Fakültesi', [
        ...$profesorKosullari,
        $sanatBaraji($DOCENTLIK),
        Kalip::toplam(150, $DOCENTLIK),
    ]),
];

return $esikler;
