<?php

/**
 * BAŞKENT ÜNİVERSİTESİ — Öğretim Elemanı Atama, Yükseltme ve Performans
 * Ölçütleri Yönergesi
 * Kaynak: pdf/17537097092.baskentuniversitesi.pdf
 * Cetvel: cetvel/baskent-2024.php (EK-1 ve EK-2 puanlama çizelgeleri)
 *
 * ── İKİ TABLO BİRLİKTE SAĞLANMALI ──
 * MADDE 4: "Atamalar ve yükseltmeler için adayların kendi alanlarında,
 * Tablo 1 ve Tablo 2'de belirtilen asgari koşulları BİRLİKTE sağlaması
 * zorunludur." Tablo 1 asgari puanı, Tablo 2 asgari yayın sınırlamalarını
 * veriyor; her eşik ikisinin "ve"si.
 *
 * ── BEŞ ALAN GRUBU ──
 * Tablo 3 akademik birimleri beş gruba ayırıyor. Bizim temel alan
 * listemize şöyle düşüyor:
 *   Tıp, Diş Hekimliği ve Eczacılık → Sağlık (birim ayrımlı)
 *   Mühendislik, Sağlık ve Fen Bilimleri → Mühendislik, Fen ve Sağlık
 *       (Sağlık Bilimleri Fakültesinin fizyoterapi, beslenme, hemşirelik
 *       ve odyoloji programları bu grupta; birim ayrımlı)
 *   Eğitim, Sosyal, Beşerî Bilimler ve Filoloji → Eğitim, Sosyal,
 *       Filoloji ve Spor (Egzersiz ve Spor Bilimleri bu grupta)
 *   Sanat, Tasarım ve Mimarlık → Güzel Sanatlar ve Mimarlık
 *   Hukuk → Hukuk
 * İlahiyat ve Ziraat temel alanları yönergede HİÇ geçmiyor; §0 uyarınca
 * eşik yazılmadı. Sağlık temel alanı iki grupta birden geçtiği için
 * `birim` ayrımı gerekti.
 *
 * ── "VE/VEYA" VEYA OKUNDU ──
 * Sanat, Tasarım ve Mimarlık satırları "01-06 numaralı maddeler
 * kapsamındaki dergilerde en az dört makale VE/VEYA 40-48 numaralı
 * maddeler kapsamındaki sanat etkinliklerinden en az dört sanatsal
 * etkinlik" diyor. İki okumadan hangisinin kastedildiği belirsiz; "ve"
 * okuması bir sanat adayından hem dört makale hem dört sergi isterdi ki
 * yönergenin öbür alanlara koyduğu eşiklerle orantısız kalır. VEYA olarak
 * yazıldı ve karar aday notunda belirtildi.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Tablo 2'nin [1] numaralı dipnotu: "öğretim üyesi temininde güçlük
 *       çekilen birimlerde adayın üniversite dışı bir ileri teknoloji ya
 *       da araştırma-geliştirme kuruluşunda çalışmış olması hâlinde
 *       Rektörlük onayıyla bu koşul aranmayabilir" — muafiyet, koşulu
 *       hafifletir (§0).
 *   Tablo 2'nin [3] numaralı dipnotu: makalenin ÖZGÜN ARAŞTIRMA MAKALESİ
 *       olması — sayı koşullarında derleme ve kısa makaleler de sayılıyor,
 *       koşul burada olduğundan hafif görünür.
 *   Sanat, Tasarım ve Mimarlık ile Hukuk doçentliğindeki "YÖK doçentlik
 *       kriterlerinin sağlanması" — doçentlik unvanı beyanı olarak
 *       duruyor; ÜAK'ın kendi tabloları bu motorda hesaplanmıyor.
 *   Hukukta aranan kitabın "ders kitabı DIŞINDA" olması — kayıt kitabın
 *       ders kitabı olup olmadığını ayrı tutmuyor, ders kitapları da
 *       sayılıyor.
 *   MADDE 3: ölçütlerin yalnız ön değerlendirmede belirleyici olması ve
 *       MADDE 6-7'nin kadro isteği ile başvuru evrakı hükümleri.
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Başkent Üniversitesi';
$CETVEL = 'baskent-2024';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$DIL = Kalip::yds(65);
$DIL_NOT = Kalip::beyan(
    'Bilim alanı bir yabancı dille ilgili olan ya da eğitim dili kısmen veya tamamen yabancı dil olan birimlerde yabancı dil puanının en az 85 olması',
    'Tablo 1 dipnot [2]'
);
$UNVAN = Kalip::beyan(
    'Üniversitelerarası Kurul tarafından verilen doçentlik unvanına sahip olmak',
    '2547 s.K. m.24'
);

$NOT_DIL = ' Yabancı dil koşulu 65 puandan uygulanıyor; bilim alanınız bir yabancı dille '
    .'ilgiliyse ya da biriminizin eğitim dili kısmen veya tamamen yabancı dilse en az 85 puan '
    .'gerekiyor.';

$NOT_CETVEL = ' Q1, Q2 ve Q3 dergilerindeki makalelere verilen %50 çeyreklik primi cetvele '
    .'gömüldü: bu makaleler 300 yerine 450 puan alıyor. Ortak çalışmalarda puan yazar sırasına '
    .'değil kişi sayısına bakıyor (iki yazarlıda %80, altı ve daha fazlada %40). Çizelgede tez '
    .'danışmanlığı, ders verme ve idari görev satırı yok; bu kayıtlarınız toplam puana katkı '
    .'vermiyor. Yönerge sayı koşullarındaki makalelerin ÖZGÜN ARAŞTIRMA MAKALESİ olmasını '
    .'istiyor; motor sayı '
    .'koşullarında derleme ve kısa makaleleri de sayıyor, koşul burada olduğundan hafif '
    .'görünüyor.';

$esikler = [];

/**
 * Bir alan grubunun dört kadrosunu üretir.
 *
 * @param  list<string>  $alanlar
 * @param  list<array<string, mixed>>  $drKosul
 * @param  list<array<string, mixed>>  $yenidenKosul
 * @param  list<array<string, mixed>>  $docKosul
 * @param  list<array<string, mixed>>  $profKosul
 * @param  array{int, int, int, int}  $puanlar
 */
$grup = function (string $kod, array $alanlar, ?string $birim, string $ad, array $puanlar,
    array $drKosul, array $yenidenKosul, array $docKosul, array $profKosul) use (&$esikler, $UNIVERSITE, $CETVEL, $DIL, $DIL_NOT, $UNVAN, $DOCENTLIK, $SON_ATAMA,
    $NOT_DIL, $NOT_CETVEL): void {
    [$drPuan, $yenidenPuan, $docPuan, $profPuan] = $puanlar;

    $esikler[] = [
        'anahtar' => "baskent-{$kod}-dr",
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => $CETVEL,
        'notlar' => $ad.' doktor öğretim üyesi ilk atama: Tablo 1\'den '.$drPuan.' puan ve '
            .'Tablo 2\'nin yayın koşulları.',
        'aday_notu' => $ad.' alanlarında doktor öğretim üyesi kadrosuna İLK ATANMA. Yönerge '
            .'puan barajıyla yayın koşullarının BİRLİKTE sağlanmasını istiyor.'.$NOT_DIL.$NOT_CETVEL,
        'sart' => Kalip::ve('Doktor öğretim üyesi kadrosuna ilk atanma — '.$ad,
            array_values([$DIL, $DIL_NOT, ...$drKosul, Kalip::toplam($drPuan)])),
    ];

    $esikler[] = [
        'anahtar' => "baskent-{$kod}-dr-yeniden",
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => $CETVEL,
        'notlar' => $ad.' doktor öğretim üyesi yeniden atama: son atamadan sonra Tablo 1\'den '
            .$yenidenPuan.' puan ve Tablo 2\'nin yayın koşulları.',
        'aday_notu' => $ad.' alanlarında doktor öğretim üyesi kadrosuna YENİDEN ATANMA. '
            .'Puan çizelgesinin dipnotu uyarınca puanlar SON ATAMADAN SONRA alınmış '
            .'olmalı.'.$NOT_DIL.$NOT_CETVEL,
        'sart' => Kalip::ve('Doktor öğretim üyesi kadrosuna yeniden atanma — '.$ad,
            array_values([$DIL, $DIL_NOT, ...$yenidenKosul, Kalip::toplam($yenidenPuan, $SON_ATAMA)])),
    ];

    $esikler[] = [
        'anahtar' => "baskent-{$kod}-docentlik",
        'universite' => $UNIVERSITE,
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => $CETVEL,
        'notlar' => $ad.' doçentlik: Tablo 1\'den '.$docPuan.' puan ve Tablo 2\'nin yayın '
            .'koşulları.',
        'aday_notu' => $ad.' alanlarında doçent kadrosuna atanma. Yönerge bu grup için '
            .$docPuan.' puan istiyor; puan barajında dönem sınırı yok, yayın koşullarının bir '
            .'kısmı ise doktora ya da uzmanlık derecesinden sonraki çalışmalardan '
            .'sağlanmalı.'.$NOT_DIL.$NOT_CETVEL,
        'sart' => Kalip::ve('Doçent kadrosuna atanma — '.$ad,
            array_values([$UNVAN, $DIL, $DIL_NOT, ...$docKosul, Kalip::toplam($docPuan)])),
    ];

    $esikler[] = [
        'anahtar' => "baskent-{$kod}-profesorluk",
        'universite' => $UNIVERSITE,
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => $CETVEL,
        'notlar' => $ad.' profesörlük: Tablo 1\'den '.$profPuan.' puan (en az 700\'ü doçentlik '
            .'sonrası) ve Tablo 2\'nin yayın koşulları.',
        'aday_notu' => $ad.' alanlarında profesör kadrosuna atanma. Yönerge bu grup için '
            .$profPuan.' puan istiyor; [4] numaralı dipnot ayrıca bu puanın en az 700\'ünün '
            .'DOÇENTLİK UNVANI ALINDIKTAN SONRA kazanılmasını şart koşuyor.'
            .$NOT_DIL.$NOT_CETVEL,
        'sart' => Kalip::ve('Profesör kadrosuna atanma — '.$ad,
            array_values([$UNVAN, $DIL, $DIL_NOT, ...$profKosul, Kalip::toplam($profPuan),
                Kalip::toplam(700, $DOCENTLIK)])),
    ];
};

$adet = function (string $ad, string $g, int $n, ?string $yazar = null, ?array $donem = null): array {
    return match ($yazar) {
        'tek' => Kalip::adet($ad, [$g], $n, yazar: 'tek', donem: $donem, madde: 'Tablo 2'),
        'baslica' => Kalip::adet($ad, [$g], $n, yazar: 'baslica', donem: $donem, madde: 'Tablo 2'),
        default => Kalip::adet($ad, [$g], $n, donem: $donem, madde: 'Tablo 2'),
    };
};

// ── Tıp, Diş Hekimliği ve Eczacılık ──
$grup('tip', ['saglik'], 'Tıp, Diş Hekimliği ve Eczacılık Fakülteleri',
    'Tıp, Diş Hekimliği ve Eczacılık', [600, 500, 1500, 2500],
    [$adet('01 ya da 02 numaralı maddeler kapsamındaki dergilerde en az dört makale yayımlamış olmak', '01-02', 4),
        $adet('Bu makalelerin en az ikisinde başlıca yazar olmak', '01-02', 2, 'baslica'),
        $adet('Toplamda en az altı makalesi olmak', '01-07', 6)],
    [$adet('Son atamadan sonra 01 ya da 02 numaralı maddeler kapsamındaki dergilerde en az iki makale yayımlamış olmak', '01-02', 2, donem: $SON_ATAMA)],
    [$adet('01 ya da 02 numaralı maddeler kapsamındaki dergilerde toplam en az yedi makale yayımlamış olmak', '01-02', 7),
        $adet('Bu makalelerin en az üçünü doktora ya da uzmanlık derecesinden sonra yayımlamış olmak', '01-02', 3, donem: $DOKTORA),
        $adet('Bu yedi makalenin en az üçünde başlıca yazar olmak', '01-02', 3, 'baslica')],
    [$adet('01 ya da 02 numaralı maddeler kapsamındaki dergilerde toplam en az on iki makale yayımlamış olmak', '01-02', 12),
        $adet('Bu makalelerin en az beşini doçentlik unvanından sonra yayımlamış olmak', '01-02', 5, donem: $DOCENTLIK),
        $adet('Bu on iki makalenin en az dördünde başlıca yazar olmak', '01-02', 4, 'baslica')]);

// ── Mühendislik, Sağlık ve Fen Bilimleri ──
$grup('muhfen', ['muhendislik', 'fen', 'saglik'], 'Mühendislik, Sağlık ve Fen Bilimleri',
    'Mühendislik, Sağlık ve Fen Bilimleri', [500, 400, 1500, 2500],
    [$adet('01 ya da 02 numaralı maddeler kapsamındaki dergilerde en az iki makale yayımlamış olmak', '01-02', 2),
        $adet('Toplamda en az dört makalesi olmak', '01-07', 4)],
    [$adet('Son atamadan sonra 01 ya da 02 numaralı maddeler kapsamındaki dergilerde en az bir makale yayımlamış olmak', '01-02', 1, donem: $SON_ATAMA)],
    [$adet('01 ya da 02 numaralı maddeler kapsamındaki dergilerde toplam en az dört makale yayımlamış olmak', '01-02', 4),
        $adet('Bu makalelerin en az ikisini doktora derecesinden sonra yayımlamış olmak', '01-02', 2, donem: $DOKTORA),
        $adet('01-03 numaralı maddeler kapsamındaki dergilerde toplam en az sekiz makalesi olmak', '01-03', 8)],
    [$adet('Doçentlik unvanından sonra 01 ya da 02 numaralı maddeler kapsamındaki dergilerde en az üç makale yayımlamış olmak', '01-02', 3, donem: $DOCENTLIK),
        $adet('01-03 numaralı maddeler kapsamındaki dergilerde toplam en az on bir makalesi olmak', '01-03', 11)]);

// ── Eğitim, Sosyal, Beşerî Bilimler ve Filoloji ──
$grup('sosyal', ['egitim', 'sosyal', 'filoloji', 'spor'], null,
    'Eğitim, Sosyal, Beşerî Bilimler ve Filoloji', [400, 300, 1500, 2500],
    [$adet('01-03 numaralı maddeler kapsamındaki dergilerde en az bir makale yayımlamış olmak', '01-03', 1),
        $adet('Toplamda en az dört makalesi olmak', '01-07', 4)],
    [$adet('Son atamadan sonra 01-03 numaralı maddeler kapsamındaki dergilerde en az bir makale yayımlamış olmak', '01-03', 1, donem: $SON_ATAMA)],
    [$adet('01-03 numaralı maddeler kapsamındaki dergilerde toplam en az iki makale yayımlamış olmak', '01-03', 2),
        $adet('Toplamda en az yedi makalesi olmak', '01-07', 7)],
    [$adet('Doçentlik unvanından sonra 01 ya da 02 numaralı maddeler kapsamındaki dergilerde en az iki makale yayımlamış olmak', '01-02', 2, donem: $DOCENTLIK),
        $adet('01-03 numaralı maddeler kapsamındaki dergilerde toplam en az beş makalesi olmak', '01-03', 5)]);

// ── Sanat, Tasarım ve Mimarlık ──
$grup('sanat', ['guzel_sanatlar', 'mimarlik'], null, 'Sanat, Tasarım ve Mimarlık',
    [300, 300, 900, 1500],
    [Kalip::veya('Makale ya da sanatsal etkinlik koşulunu sağlamak', [
        $adet('01-06 numaralı maddeler kapsamındaki dergilerde en az dört makale yayımlamış olmak', '01-06', 4),
        $adet('40-48 numaralı maddeler kapsamında en az dört sanatsal etkinlik yapmış olmak', '40-48', 4),
    ])],
    [Kalip::veya('Makale ya da sanatsal etkinlik koşulunu sağlamak', [
        $adet('Son atamadan sonra 01-06 numaralı maddeler kapsamındaki dergilerde en az üç makale yayımlamış olmak', '01-06', 3, donem: $SON_ATAMA),
        $adet('Son atamadan sonra 40-48 numaralı maddeler kapsamında en az üç sanatsal etkinlik yapmış olmak', '40-48', 3, donem: $SON_ATAMA),
    ])],
    [Kalip::veya('Makale ya da sanatsal etkinlik koşulunu sağlamak', [
        $adet('01-06 numaralı maddeler kapsamındaki dergilerde en az yedi makale yayımlamış olmak', '01-06', 7),
        $adet('40-48 numaralı maddeler kapsamında en az yedi sanatsal etkinlik yapmış olmak', '40-48', 7),
    ])],
    [Kalip::veya('Makale ya da sanatsal etkinlik koşulunu sağlamak', [
        Kalip::ve('01-06 numaralı maddelerde sekiz makale (en az üçü doçentlik sonrası)', [
            $adet('01-06 numaralı maddeler kapsamındaki dergilerde toplam en az sekiz makale yayımlamış olmak', '01-06', 8),
            $adet('Bu makalelerin en az üçünü doçentlik unvanından sonra yayımlamış olmak', '01-06', 3, donem: $DOCENTLIK),
        ]),
        Kalip::ve('40-48 numaralı maddelerde sekiz sanatsal etkinlik (en az üçü doçentlik sonrası)', [
            $adet('40-48 numaralı maddeler kapsamında toplam en az sekiz sanatsal etkinlik yapmış olmak', '40-48', 8),
            $adet('Bu etkinliklerin en az üçünü doçentlik unvanından sonra yapmış olmak', '40-48', 3, donem: $DOCENTLIK),
        ]),
    ])]);

// ── Hukuk ──
$grup('hukuk', ['hukuk'], null, 'Hukuk', [300, 300, 900, 1500],
    [$adet('01-06 numaralı maddeler kapsamındaki dergilerde en az dört makale yayımlamış olmak', '01-06', 4)],
    [$adet('Son atamadan sonra 01-06 numaralı maddeler kapsamındaki dergilerde en az üç makale yayımlamış olmak', '01-06', 3, donem: $SON_ATAMA)],
    [$adet('01-06 numaralı maddeler kapsamındaki dergilerde en az yedi makale yayımlamış olmak', '01-06', 7),
        $adet('Bu makalelerin en az üçünü doktora derecesinden sonra yayımlamış olmak', '01-06', 3, donem: $DOKTORA),
        $adet('Tek yazarlı ve ders kitabı dışında bir kitabınızın olması', 'KITAP', 1, 'tek')],
    [$adet('Doçentlik unvanından sonra tek yazarlı ve ders kitabı dışında bir kitabınızın olması', 'KITAP', 1, 'tek', $DOCENTLIK),
        Kalip::veya('Makale koşulunu sağlamak', [
            Kalip::ve('01-06 numaralı maddelerde on bir makale (en az dördü doçentlik sonrası)', [
                $adet('01-06 numaralı maddeler kapsamındaki dergilerde toplam en az on bir makale yayımlamış olmak', '01-06', 11),
                $adet('Bu makalelerin en az dördünü doçentlik unvanından sonra yayımlamış olmak', '01-06', 4, donem: $DOCENTLIK),
            ]),
            Kalip::ve('01-03 numaralı maddelerde dokuz makale (en az ikisi doçentlik sonrası)', [
                $adet('01-03 numaralı maddeler kapsamındaki dergilerde toplam en az dokuz makale yayımlamış olmak', '01-03', 9),
                $adet('Bu makalelerin en az ikisini doçentlik unvanından sonra yayımlamış olmak', '01-03', 2, donem: $DOCENTLIK),
            ]),
        ])]);

return $esikler;
