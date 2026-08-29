<?php

/**
 * ANTALYA BİLİM ÜNİVERSİTESİ — Öğretim Üyesi Atama ve Yükseltme Yönergesi
 * Kaynak: pdf/17634002431.Antalya Bilim Üniversitesi Kriter.pdf
 * Cetvel: cetvel/antalya-bilim-2024.php (EK-1 Genel Puanlama Çizelgesi)
 *
 * ── İKİ TABLO BİRLİKTE SAĞLANMALI ──
 * MADDE 7(1): "adayların kendi alanlarında, Tablo 1 ve Tablo 2'de belirtilen
 * asgari koşulları BİRLİKTE sağlaması zorunludur." Tablo 1 asgari puanı,
 * Tablo 2 asgari yayın koşullarını veriyor; her eşik ikisinin "ve"si.
 *
 * ── YEDİ TEMEL ALAN, YEDİSİ DE GİRİLDİ ──
 * Tablo 1 ve Tablo 2 yedi temel alan sayıyor: Sosyal-Beşerî-İdari, Sağlık,
 * Mühendislik, Mimarlık-Planlama-Tasarım, Hukuk, Güzel Sanatlar, Fen
 * Bilimleri ve Matematik. Eğitim, Spor, Filoloji, İlahiyat ve Ziraat temel
 * alanları yönergede HİÇ geçmiyor; §0 uyarınca o alanlara eşik yazılmadı.
 *
 * ── ASGARİ PUANLAR BÜTÜN ALANLARDA AYNI ──
 * Tablo 1 yedi alanın hepsine aynı değerleri veriyor: doktor öğretim üyesi
 * 40, yeniden atama 20, doçent 100, profesör 150. Alanlar yalnız Tablo 2'nin
 * yayın koşullarında ayrışıyor.
 *
 * ── "VE/VEYA" VEYA OKUNDU ──
 * Mimarlık ile Güzel Sanatlar satırları "01-06 numaralı maddeler
 * kapsamındaki dergilerde en az dört makale VE/VEYA 45-51 numaralı maddeler
 * kapsamında en az dört sanatsal etkinlik" diyor. İki okuma var; "ve"
 * okuması bir mimarlık adayından hem dört makale hem dört sergi isterdi ki
 * yönergenin öbür alanlara koyduğu eşiklerle orantısız kalır. Bu yüzden
 * VEYA olarak yazıldı ve karar aday notunda açıkça belirtildi.
 *
 * ── 40-48 ARALIĞI 45-51 OKUNDU ──
 * Güzel Sanatlar doçentlik ve profesörlük satırları sanat etkinlikleri için
 * "40-48 numaralı maddeler" diyor; çizelgede 40 ulusal bilim ödülü, 41 yayın
 * kurulu üyeliği, 42 editörlük, 43 hakemlik ve 44 yurt dışı görev. Sanat
 * etkinlikleri 45-51 arasında ve aynı tablonun Mimarlık satırları 45-51
 * diyor. Bu, çizelgenin eski bir sürümünden kalma numara; 45-51 uygulandı.
 *
 * ── YABANCI DİL ──
 * MADDE 7(2) ve MADDE 12(2): 85 puanlık dil koşulu YALNIZCA yabancı dilde
 * eğitim yapan birimler için. Türkçe eğitim yapan birimlere yönerge dil
 * koşulu koymuyor. Adayın birimi kayıtta taşınmadığı için sayısal eşik
 * yerine beyan yazıldı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Doçentlikteki "YÖK Doçentlik kriterlerinin sağlanması" — doçentlik
 *       unvanı beyanı olarak duruyor; ÜAK'ın kendi tabloları bu motorda
 *       ayrıca hesaplanmıyor.
 *   MADDE 9-10 (kadro isteği, başvuru dosyası içeriği), MADDE 13 (jüri
 *       oluşturma) ve MADDE 5(c)'nin "ön değerlendirmeyi geçmiş olmak
 *       kazanılmış hak değildir" hükmü — süreç hükümleri.
 *   MADDE 5(a) ve 5(b): adayın bilim alanındaki yeri, potansiyeli, eğitim
 *       katkısı, mesleki deneyimi ve topluma katkısının değerlendirilmesi —
 *       ölçülebilir eşik değil.
 *   Hukukta doktor öğretim üyeliğinin "doktora tezini tanınmış uluslararası
 *       veya ulusal yayınevinde yayımlamış olmak" seçeneği: kayıt kitabın
 *       adayın doktora tezinden üretildiğini taşımadığı için bu yol beyan
 *       koşuluyla açıldı, kitap sayısı ayrıca aranıyor.
 *   Tablo 1 dipnotu: "Sözleşmelerin 1 yıllık olması hâlinde geçerli puandır"
 *       — yeniden atamada sözleşme süresine göre oranlama; kayıt sözleşme
 *       süresini taşımıyor, bir yıllık değer uygulandı.
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Antalya Bilim Üniversitesi';
$CETVEL = 'antalya-bilim-2024';
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$DIL = Kalip::beyan(
    'Yabancı dilde eğitim yapan bir birime başvuruyorsanız YDS, e-YDS ya da YÖKDİL sınavlarından en az 85 puan veya eşdeğeri almış olmak',
    'MADDE 7(2)'
);
$DOKTORA = Kalip::beyan(
    'Doktora ya da tıpta, diş hekimliğinde, eczacılıkta veya veteriner hekimlikte uzmanlık ya da sanatta yeterlik eğitimini tamamlamış olmak',
    'MADDE 11'
);
$UNVAN = Kalip::beyan(
    'YÖK doçentlik kriterlerini sağlayarak doçentlik unvanını almış olmak',
    'Tablo 2'
);

$NOT_DIL = ' Yabancı dil koşulu yalnız YABANCI DİLDE EĞİTİM yapan birimler için geçerli (en az '
    .'85 puan); Türkçe eğitim yapan birimlere yönerge dil koşulu koymuyor. Başvuracağınız '
    .'birimin eğitim dili kayıtta taşınmadığı için bu koşul beyan olarak duruyor.';

$NOT_CETVEL = ' Puan çizelgesi yalnız araştırma çıktısını puanlıyor: tez danışmanlığı, ders '
    .'verme ve idari görevlerin puan satırı yok, bu kayıtlarınız toplam puanınıza katkı '
    .'vermiyor. Yönerge ortak çalışmalarda puanın yazarlar arasında bölünmesi için de bir kural '
    .'koymuyor; çok yazarlı çalışmalarınız tam puan alıyor.';

/** Mimarlık ve Güzel Sanatların "makale ve/veya sanatsal etkinlik" koşulu. */
$sanatYaDaMakale = function (int $makale, int $etkinlik, ?array $donem, string $madde): array {
    return Kalip::veya('Makale ya da sanatsal etkinlik koşulunu sağlamak', [
        Kalip::adet(
            "Hakemli dergilerde en az {$makale} makale yayımlamış olmak",
            ['01-06'], $makale, donem: $donem, madde: $madde
        ),
        Kalip::adet(
            "Sergi, konser, temsil ya da tasarım türünden en az {$etkinlik} sanatsal etkinlik yapmış olmak",
            ['45-51'], $etkinlik, donem: $donem, madde: $madde
        ),
    ]);
};

$esikler = [];

// ═══════════════ DOKTOR ÖĞRETİM ÜYESİ — İLK ATANMA ═══════════════
$drKosullari = [
    'sosyal' => [['sosyal'], 'Sosyal, Beşerî ve İdari Bilimler', Kalip::ve('Yayın koşulunu sağlamak', [
        Kalip::adet('SCI, SCI-Expanded, SSCI ya da AHCI dergilerinde en az bir makale yayımlamış olmak', ['1-2'], 1, madde: 'Tablo 2'),
        Kalip::adet('Web of Science, Scopus, alan indeksli ya da TR Dizin dergilerinde en az bir makale yayımlamış olmak', ['3-6'], 1, madde: 'Tablo 2'),
    ])],
    'saglik' => [['saglik'], 'Sağlık Bilimleri', null],
    'muhendislik' => [['muhendislik'], 'Mühendislik', null],
    'fen' => [['fen'], 'Fen Bilimleri ve Matematik', null],
];

$ikiUluslararasi = Kalip::ve('Yayın koşulunu sağlamak', [
    Kalip::adet('SCI, SCI-Expanded, SSCI ya da AHCI dergilerinde en az bir makale yayımlamış olmak', ['1-2'], 1, madde: 'Tablo 2'),
    Kalip::adet('Uluslararası dergilerde toplam en az iki yayın yapmış olmak', ['ULUSLARARASI-MAKALE'], 2, madde: 'Tablo 2'),
]);

foreach ($drKosullari as $kod => [$alanlar, $alanAdi, $yayin]) {
    $esikler[] = [
        'anahtar' => "antalya-bilim-{$kod}-dr",
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => $alanAdi.' doktor öğretim üyesi: Tablo 1\'den 40 puan ve Tablo 2\'nin '
            .'yayın koşulu.',
        'aday_notu' => $alanAdi.' alanında doktor öğretim üyesi kadrosuna İLK ATANMA. Yönerge '
            .'puan barajıyla yayın koşulunun BİRLİKTE sağlanmasını istiyor. Puan barajı '
            .'bütün temel alanlarda aynı: 40 puan.'
            .$NOT_DIL.$NOT_CETVEL,
        'sart' => Kalip::ve('Doktor öğretim üyesi kadrosuna atanma — '.$alanAdi, [
            $DOKTORA,
            $DIL,
            $yayin ?? $ikiUluslararasi,
            Kalip::toplam(40),
        ]),
    ];
}

$esikler[] = [
    'anahtar' => 'antalya-bilim-mimarlik-dr',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['mimarlik'],
    'cetvel' => $CETVEL,
    'notlar' => 'Mimarlık, Planlama ve Tasarım doktor öğretim üyesi: Tablo 1\'den 40 puan; '
        .'01-06\'da en az dört makale ve/veya 45-51\'de en az dört sanatsal etkinlik.',
    'aday_notu' => 'Mimarlık, Planlama ve Tasarım alanında doktor öğretim üyesi kadrosuna İLK '
        .'ATANMA. Yönergenin "dört makale VE/VEYA dört sanatsal etkinlik" ifadesi VEYA olarak '
        .'okundu: ikisinden birini sağlamanız yeterli sayılıyor.'.$NOT_DIL.$NOT_CETVEL,
    'sart' => Kalip::ve('Doktor öğretim üyesi kadrosuna atanma — Mimarlık, Planlama ve Tasarım', [
        $DOKTORA,
        $DIL,
        $sanatYaDaMakale(4, 4, null, 'Tablo 2'),
        Kalip::toplam(40),
    ]),
];

$esikler[] = [
    'anahtar' => 'antalya-bilim-guzel-sanatlar-dr',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['guzel_sanatlar'],
    'cetvel' => $CETVEL,
    'notlar' => 'Güzel Sanatlar doktor öğretim üyesi: Tablo 1\'den 40 puan; 01-06\'da en az '
        .'dört makale ve/veya 45-51\'de en az dört sanatsal etkinlik.',
    'aday_notu' => 'Güzel Sanatlar alanında doktor öğretim üyesi kadrosuna İLK ATANMA. '
        .'Yönergenin "dört makale VE/VEYA dört sanatsal etkinlik" ifadesi VEYA olarak okundu.'
        .$NOT_DIL.$NOT_CETVEL,
    'sart' => Kalip::ve('Doktor öğretim üyesi kadrosuna atanma — Güzel Sanatlar', [
        $DOKTORA,
        $DIL,
        $sanatYaDaMakale(4, 4, null, 'Tablo 2'),
        Kalip::toplam(40),
    ]),
];

$esikler[] = [
    'anahtar' => 'antalya-bilim-hukuk-dr',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['hukuk'],
    'cetvel' => $CETVEL,
    'notlar' => 'Hukuk doktor öğretim üyesi: Tablo 1\'den 40 puan; 01-06\'da en az dört yayın '
        .'ya da doktora tezi tanınmış bir yayınevinde yayımlanmış olmak kaydıyla 01-06\'da en '
        .'az iki yayın.',
    'aday_notu' => 'Hukuk alanında doktor öğretim üyesi kadrosuna İLK ATANMA. Yayın koşulunu '
        .'iki yoldan biriyle karşılayabilirsiniz: hakemli dergilerde dört yayın ya da '
        .'doktora tezinizin tanınmış bir yayınevinde kitap olarak '
        .'yayımlanmış olması kaydıyla iki yayın. İkinci yolda kitabın doktora tezinizden '
        .'üretildiği kayıtta taşınmadığı için o kısım beyan olarak duruyor.'.$NOT_DIL.$NOT_CETVEL,
    'sart' => Kalip::ve('Doktor öğretim üyesi kadrosuna atanma — Hukuk', [
        $DOKTORA,
        $DIL,
        Kalip::veya('Yayın koşulunu sağlamak', [
            Kalip::adet('Hakemli dergilerde en az dört yayın yapmış olmak', ['01-06'], 4, madde: 'Tablo 2'),
            Kalip::ve('Doktora tezi kitap olarak yayımlanmış adaylar için', [
                Kalip::beyan('Doktora tezinizin tanınmış bir uluslararası ya da ulusal yayınevinde kitap olarak yayımlanmış olması', 'Tablo 2'),
                Kalip::adet('Tanınmış bir yayınevinde yayımlanmış en az bir kitabınızın olması', ['KITAP'], 1, madde: 'Tablo 2'),
                Kalip::adet('Hakemli dergilerde en az iki yayın yapmış olmak', ['01-06'], 2, madde: 'Tablo 2'),
            ]),
        ]),
        Kalip::toplam(40),
    ]),
];

// ═══════════════ DOKTOR ÖĞRETİM ÜYESİ — YENİDEN ATANMA ═══════════════
$TUM_ALANLAR = ['sosyal', 'saglik', 'muhendislik', 'mimarlik', 'hukuk', 'guzel_sanatlar', 'fen'];

$esikler[] = [
    'anahtar' => 'antalya-bilim-dr-yeniden',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => $TUM_ALANLAR,
    'cetvel' => $CETVEL,
    'notlar' => 'Yeniden atama: Tablo 1\'den 20 puan, son atamadan sonra alınmış olmak üzere. '
        .'Tablo 2\'nin yeniden atama için ayrı bir yayın koşulu yok.',
    'aday_notu' => 'Doktor öğretim üyesi kadrosuna YENİDEN ATANMA. Yönerge yeniden atamaya '
        .'yalnız puan barajı koyuyor: son atamanızdan sonra alınmış en az 20 puan. İlk '
        .'atamadaki yayın koşulları yeniden atamada aranmıyor. Bu 20 puan BİR YILLIK sözleşme için '
        .'geçerli; sözleşmeniz daha uzunsa puanın da orantılı olarak artması gerekiyor, '
        .'sözleşme süresi kayıtta taşınmadığı için bir yıllık değer uygulandı.'
        .$NOT_DIL.$NOT_CETVEL,
    'sart' => Kalip::ve('Doktor öğretim üyesi kadrosuna yeniden atanma', [
        $DOKTORA,
        $DIL,
        Kalip::toplam(20, $SON_ATAMA),
    ]),
];

// ═══════════════ DOÇENT ═══════════════
/**
 * Yayın koşulunun dergi kümesi alana göre değişiyor. `$KUME_ADI` adaya
 * gösterilen adı taşır (KONVANSIYONLAR §2); kod yalnızca `notlar`da kalır.
 */
$KUME_ADI = [
    '01-03' => 'SCI, SCI-Expanded, SSCI, AHCI, Web of Science ve Scopus',
    '01-06' => 'hakemli',
];

$docKosullari = [
    ['sosyal', ['sosyal'], 'Sosyal, Beşerî ve İdari Bilimler', '01-06'],
    ['saglik', ['saglik'], 'Sağlık Bilimleri', '01-03'],
    ['muhendislik', ['muhendislik'], 'Mühendislik', '01-03'],
    ['fen', ['fen'], 'Fen Bilimleri ve Matematik', '01-03'],
    ['hukuk', ['hukuk'], 'Hukuk', '01-06'],
];

foreach ($docKosullari as [$kod, $alanlar, $alanAdi, $kume]) {
    $kumeAdi = $KUME_ADI[$kume];
    $esikler[] = [
        'anahtar' => "antalya-bilim-{$kod}-docentlik",
        'universite' => $UNIVERSITE,
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => $alanAdi.' doçentlik: YÖK doçentlik kriterlerine ek olarak EK-1 çizelgesinin '
            .$kume.' numaralı maddeleri kapsamındaki dergilerde toplam iki makale; Tablo 1\'den '
            .'100 puan.',
        'aday_notu' => $alanAdi.' alanında doçent kadrosuna atanma. YÖK doçentlik kriterlerini '
            .'sağlayıp unvanı almış olmanıza EK OLARAK, '.$kumeAdi.' dergilerde toplam iki '
            .'makaleniz olması ve 100 '
            .'puanlık barajını geçmeniz gerekiyor. Yönerge bu yayınlar için dönem sınırı '
            .'koymuyor, bütün akademik geçmişiniz sayılıyor.'.$NOT_DIL.$NOT_CETVEL,
        'sart' => Kalip::ve('Doçent kadrosuna atanma — '.$alanAdi, [
            $UNVAN,
            $DIL,
            Kalip::adet($kumeAdi.' dergilerde toplam en az iki makale yayımlamış olmak', [$kume], 2, madde: 'Tablo 2'),
            Kalip::toplam(100),
        ]),
    ];
}

foreach ([['mimarlik', ['mimarlik'], 'Mimarlık, Planlama ve Tasarım'],
    ['guzel-sanatlar', ['guzel_sanatlar'], 'Güzel Sanatlar']] as [$kod, $alanlar, $alanAdi]) {
    $esikler[] = [
        'anahtar' => "antalya-bilim-{$kod}-docentlik",
        'universite' => $UNIVERSITE,
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => $alanAdi.' doçentlik: YÖK doçentlik kriterlerine ek olarak 01-06\'da iki '
            .'makale ve/veya 45-51\'de en az beş sanatsal etkinlik; Tablo 1\'den 100 puan.',
        'aday_notu' => $alanAdi.' alanında doçent kadrosuna atanma. YÖK doçentlik kriterlerine '
            .'ek olarak ya hakemli dergilerde iki makaleniz ya da sergi, konser, temsil '
            .'türünden en az beş sanatsal etkinliğiniz olmalı; yönergenin "ve/veya" ifadesi '
            .'VEYA olarak okundu. 100 puanlık baraj '
            .'ayrıca geçilmeli.'.$NOT_DIL.$NOT_CETVEL,
        'sart' => Kalip::ve('Doçent kadrosuna atanma — '.$alanAdi, [
            $UNVAN,
            $DIL,
            $sanatYaDaMakale(2, 5, null, 'Tablo 2'),
            Kalip::toplam(100),
        ]),
    ];
}

// ═══════════════ PROFESÖR ═══════════════
$profKosullari = [
    ['sosyal', ['sosyal'], 'Sosyal, Beşerî ve İdari Bilimler', '01-06'],
    ['saglik', ['saglik'], 'Sağlık Bilimleri', '01-03'],
    ['muhendislik', ['muhendislik'], 'Mühendislik', '01-03'],
    ['fen', ['fen'], 'Fen Bilimleri ve Matematik', '01-03'],
];

foreach ($profKosullari as [$kod, $alanlar, $alanAdi, $kume]) {
    $kumeAdi = $KUME_ADI[$kume];
    $esikler[] = [
        'anahtar' => "antalya-bilim-{$kod}-profesorluk",
        'universite' => $UNIVERSITE,
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => $alanAdi.' profesörlük: doçentlik ataması sonrasında EK-1 çizelgesinin '
            .$kume.' numaralı maddeleri kapsamındaki dergilerde toplam iki makale; Tablo 1\'den '
            .'150 puan.',
        'aday_notu' => $alanAdi.' alanında profesör kadrosuna atanma. İki makale koşulu '
            .'DOÇENTLİK ATAMASINDAN SONRAKİ çalışmalarınızdan hesaplanıyor; 150 '
            .'puanlık barajı için yönerge dönem sınırı koymuyor, bütün akademik geçmişiniz '
            .'sayılıyor.'.$NOT_DIL.$NOT_CETVEL,
        'sart' => Kalip::ve('Profesör kadrosuna atanma — '.$alanAdi, [
            $UNVAN,
            $DIL,
            Kalip::adet('Doçentlik atamanızdan sonra '.$kumeAdi.' dergilerde toplam en az iki makale yayımlamış olmak', [$kume], 2, donem: $DOCENTLIK, madde: 'Tablo 2'),
            Kalip::toplam(150),
        ]),
    ];
}

foreach ([['mimarlik', ['mimarlik'], 'Mimarlık, Planlama ve Tasarım'],
    ['guzel-sanatlar', ['guzel_sanatlar'], 'Güzel Sanatlar']] as [$kod, $alanlar, $alanAdi]) {
    $esikler[] = [
        'anahtar' => "antalya-bilim-{$kod}-profesorluk",
        'universite' => $UNIVERSITE,
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => $alanAdi.' profesörlük: doçentlik ataması sonrasında 01-06\'da en az üç '
            .'makale ve/veya 45-51\'de en az üç sanatsal etkinlik; Tablo 1\'den 150 puan.',
        'aday_notu' => $alanAdi.' alanında profesör kadrosuna atanma. Üç makale ya da üç '
            .'sanatsal etkinlik koşulu DOÇENTLİK ATAMASINDAN SONRAKİ çalışmalarınızdan '
            .'hesaplanıyor; yönergenin "ve/veya" ifadesi VEYA olarak okundu. 150 puanlık '
            .'barajda dönem sınırı yok.'.$NOT_DIL.$NOT_CETVEL,
        'sart' => Kalip::ve('Profesör kadrosuna atanma — '.$alanAdi, [
            $UNVAN,
            $DIL,
            $sanatYaDaMakale(3, 3, $DOCENTLIK, 'Tablo 2'),
            Kalip::toplam(150),
        ]),
    ];
}

$esikler[] = [
    'anahtar' => 'antalya-bilim-hukuk-profesorluk',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['hukuk'],
    'cetvel' => $CETVEL,
    'notlar' => 'Hukuk profesörlük: doçentlik ataması sonrasında bir tek yazarlı ve ders kitabı '
        .'dışında kitap; 01-06\'da toplam iki yayın (ikisi de doçentlik sonrası); Tablo 1\'den '
        .'150 puan.',
    'aday_notu' => 'Hukuk alanında profesör kadrosuna atanma. Doçentlik atamanızdan sonra TEK '
        .'YAZARLI ve ders kitabı dışında bir kitabınızın olması zorunlu. Buna ek olarak 01-06 '
        .'numaralı maddeler kapsamındaki dergilerde iki yayın gerekiyor; yönerge bu iki yayının '
        .'da doçentlik sonrası olmasını istiyor. Kitabın ders kitabı olmadığı kayıtta '
        .'ayrılamadığı için ders kitapları da bu koşula sayılıyor, koşul burada olduğundan '
        .'hafif görünür.'.$NOT_DIL.$NOT_CETVEL,
    'sart' => Kalip::ve('Profesör kadrosuna atanma — Hukuk', [
        $UNVAN,
        $DIL,
        Kalip::adet('Doçentlik atamanızdan sonra tek yazarlı ve ders kitabı dışında bir kitabınızın olması', ['KITAP'], 1, yazar: 'tek', donem: $DOCENTLIK, madde: 'Tablo 2'),
        Kalip::adet('Doçentlik atamanızdan sonra hakemli dergilerde toplam en az iki yayın yapmış olmak', ['01-06'], 2, donem: $DOCENTLIK, madde: 'Tablo 2'),
        Kalip::toplam(150),
    ]),
];

return $esikler;
