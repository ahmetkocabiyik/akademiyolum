<?php

/**
 * ALANYA ALAADDİN KEYKUBAT ÜNİVERSİTESİ — Akademik Yükseltme ve Atama
 * Kriterleri
 * Kaynak: pdf/17536928472.alanyaalaattinkeykubatuniverstesi.pdf
 * Cetvel: cetvel/alku-2024.php (Tablo 1a, 1b ve 2)
 *
 * NOT: PDF'in font kodlamasında "i" harfi kayıp; metin okunabiliyor ve
 * bütün sayılar sağlam.
 *
 * ── ÜÇ BİRİM GRUBU ──
 * Doktor öğretim üyeliği koşulları üç birim grubuna göre değişiyor:
 *   (B) Mühendislik Fakültesi, Sanat Tasarım ve Mimarlık Fakültesi,
 *       Havacılık ve Uzay Bilimleri Fakültesi (Havacılık Yönetimi hariç),
 *       meslek yüksekokullarının teknik bilimler ile mimarlık, sanat ve
 *       tasarım bölümleri → Mühendislik, Mimarlık, Güzel Sanatlar, Ziraat
 *       ve Fen temel alanları.
 *   (C) Havacılık Yönetimi, Çocuk Gelişimi, İİBF, Eğitim Fakültesi, Spor
 *       Bilimleri Fakültesi, Turizm Fakültesi, Yabancı Diller Yüksekokulu
 *       ve meslek yüksekokullarının sosyal, beşerî ve idari bölümleri →
 *       Sosyal, Eğitim, Spor ve Filoloji temel alanları.
 *   (D) Tıp, Diş Hekimliği ve Sağlık Bilimleri Fakülteleri ile meslek
 *       yüksekokullarının sağlık bölümleri → Sağlık temel alanı.
 * Doçentlik ve profesörlükte grup ayrımı YOK; koşullar bütün birimlerde
 * aynı, bu yüzden tek eşik olarak yazıldı.
 *
 * Fen temel alanı kriterlerde ayrıca sayılmıyor. Üniversitenin ayrı bir
 * fen fakültesi yok; temel bilim kadroları Mühendislik Fakültesinde
 * bulunduğu ve (B) grubu üç grubun en ağırı olduğu için Fen o gruba
 * bağlandı. HUKUK ve İLAHİYAT temel alanları kriterlerde hiç geçmiyor;
 * §0 uyarınca eşik yazılmadı.
 *
 * ── "ARAŞTIRMA MAKALESİ" KOŞULLARI TÜRE BAĞLI ──
 * Açıklama 8: "Araştırma makalesi türü yayın şartının karşılanmasında
 * derleme, vaka takdimi, editöre mektup veya eleştiri değerlendirilmez."
 * Koşulların bağlandığı gruplar bu yüzden yalnız araştırma makalesi
 * satırlarını içeriyor; kaydınızda yayın türünü "özgün araştırma
 * makalesi" olarak işaretlemeniz gerekiyor.
 *
 * ── GÖREV SÜRESİ UZATIMI ──
 * Açıklama 13: süresi ilk kez uzatılacaklar için kadroya atanma, ötekiler
 * için son süre uzatım tarihinden sonraki faaliyetler dikkate alınıyor.
 * Motorun SON ATAMA SONRASI dönemi bu iki durumu birden karşılıyor.
 * Açıklama 12: süre uzatmaları en çok iki yıl.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Açıklama 6'nın MUAFİYETİ: etki faktörü 5 ve üzeri bir dergide en az
 *       bir makalesi olanlar ya da h-indeksi doktor öğretim üyeliğinde 5,
 *       doçentlikte 10, profesörlükte 15 olanlar birim şartlarından muaf.
 *       Muafiyet koşulu hafiflettiği için §0 uyarınca girilmedi; ayrıca
 *       kayıt derginin etki faktörünü taşımıyor.
 *   Açıklama 5 (yeni kurulan ya da öğretim üyesi temininde güçlük çekilen
 *       birimler için Üniversite Yönetim Kurulunun karar vermesi) ve
 *       Açıklama 7 (dünyada ilk 200'e giren üniversitede doktora yapmış
 *       adaylar için Senatonun karar vermesi) — muafiyet.
 *   Açıklama 4: puanların adayın başvurduğu bilim alanındaki
 *       faaliyetlerden alınması — kayıt çalışmanın alanını taşımıyor.
 *   Açıklama 14: süre uzatımı hesabında küsuratların yukarı yuvarlanması
 *       — motorun eşikleri zaten tam sayı.
 *   Açıklama 19: askerlik, sağlık ve doğum izni sürelerinin süre
 *       uzatımına eklenmesi.
 *   Açıklama 20: Eğitim Fakültesinde doçentlik temel alanı Eğitim
 *       Bilimleri dışında olanların kendi alanlarından da puan alması.
 *   Açıklama 23 (50/d araştırma görevlileri), Geçici Madde 1 ve
 *       "İlave ve Farklı Ölçütler" bölümü — süreç ve geçiş hükümleri.
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Alanya Alaaddin Keykubat Üniversitesi';
$CETVEL = 'alku-2024';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$DOKTORA_BEYANI = Kalip::beyan(
    'Doktora ya da tıp ve diş hekimliklerinde uzmanlık veya sanatta yeterlik derecesini almış olmak',
    'Doktor öğretim üyesi A/1'
);
$DIL_85 = Kalip::beyan(
    '%100 yabancı dilde eğitim yapan bir birime başvuruyorsanız öğretim dilinin anadiliniz olması, lisans ya da doktoranızı o dille tamamlamış olmanız, o dilde eğitim veren bir yükseköğretim kurumunda en az bir yıl ders vermiş olmanız ya da merkezi yabancı dil sınavından en az 85 puan almanız',
    'Ortak Şartlar A'
);
$UNVAN = Kalip::beyan(
    'Üniversitelerarası Kurul tarafından verilen doçentlik unvanına sahip olmak',
    '2547 s.K. m.24'
);

$NOT_CETVEL = ' Ortak çalışmalarda puan Tablo 3\'ün yazar sayısı × sıra matrisine göre '
    .'bölünüyor; sorumlu yazar sıraya bakılmaksızın en yüksek yüzdeyle değerlendiriliyor. '
    .'"Araştırma makalesi" koşullarında derleme, vaka takdimi ve editöre mektup sayılmıyor '
    .'(Açıklama 8); kaydınızda yayın türünü doğru işaretlemeniz gerekiyor. ESCI dergileri ile '
    .'ÜAK\'ın kabul ettiği alan indeksleri yönergede 50 puan alıyor ama sözlük bunları Scopus '
    .'ve diğer indekslerden ayıramadığı için 25 puandan sayılıyor.';

$NOT_MUAFIYET = ' Açıklama 6 bir MUAFİYET tanıyor: etki faktörü 5 ve üzeri bir dergide en az '
    .'bir makaleniz varsa ya da Web of Science h-indeksiniz doktor öğretim üyeliği için 5, '
    .'doçentlik için 10, profesörlük için 15 ve üzeriyse birim şartlarından muafsınız. Kayıt '
    .'derginin etki faktörünü ve h-indeksinizi taşımadığı için bu muafiyet motorda '
    .'uygulanmıyor; koşullar burada olduğundan sıkı görünebilir.';

$esikler = [];

// ═══════════════ DOKTOR ÖĞRETİM ÜYESİ ═══════════════
$ikiYayin = Kalip::ve('Biri SCI, SCI-E, SSCI, AHCI ya da ESCI, biri uluslararası alan indeksi kapsamında olmak üzere en az iki araştırma makalesi', [
    Kalip::adet('SCI, SCI-Expanded, SSCI, AHCI ya da ESCI kapsamındaki dergilerde en az bir araştırma makalesi yayımlamış olmak', ['SCI-ESCI'], 1, madde: 'İlk atama'),
    Kalip::adet('ÜAK ya da Üniversite Senatosunca kabul edilen uluslararası alan indekslerinde en az bir araştırma makalesi yayımlamış olmak', ['ALAN-INDEKS'], 1, madde: 'İlk atama'),
]);

$uzatmaBD = Kalip::veya('Görev süresi uzatımı koşullarından en az birini sağlamak', [
    Kalip::adet('SCI, SCI-Expanded, SSCI, AHCI ya da ESCI kapsamındaki dergilerde en az bir araştırma makalesi yayımlamış olmak', ['SCI-ESCI'], 1, donem: $SON_ATAMA, madde: 'Görev süresi uzatımı/a'),
    Kalip::ve('Alan indekslerinde iki makale ve 150 puan', [
        Kalip::adet('Uluslararası alan indekslerinde en az iki araştırma makalesi yayımlamış olmak', ['ALAN-INDEKS'], 2, donem: $SON_ATAMA, madde: 'Görev süresi uzatımı/b'),
        Kalip::toplam(150, $SON_ATAMA),
    ]),
]);

$drGruplari = [
    ['b', ['muhendislik', 'mimarlik', 'guzel_sanatlar', 'ziraat', 'fen'],
        'Mühendislik, Sanat Tasarım ve Mimarlık ile Havacılık ve Uzay Bilimleri Fakülteleri',
        $ikiYayin, $uzatmaBD],
    ['d', ['saglik'], 'Tıp, Diş Hekimliği ve Sağlık Bilimleri Fakülteleri',
        $ikiYayin, $uzatmaBD],
    ['c', ['sosyal', 'egitim', 'spor', 'filoloji'],
        'İktisadi ve İdari Bilimler, Eğitim, Spor Bilimleri ve Turizm Fakülteleri ile Yabancı Diller Yüksekokulu',
        Kalip::veya('İlk atama koşullarından en az birini sağlamak', [
            Kalip::adet('SCI, SCI-Expanded, SSCI, AHCI ya da ESCI kapsamındaki dergilerde en az bir araştırma makalesi yayımlamış olmak', ['SCI-ESCI'], 1, madde: 'İlk atama/a'),
            Kalip::ve('Alan indekslerinde iki makale ve 100 puan', [
                Kalip::adet('Uluslararası alan indekslerinde en az iki araştırma makalesi yayımlamış olmak', ['ALAN-INDEKS'], 2, madde: 'İlk atama/b'),
                Kalip::toplam(100),
            ]),
        ]),
        Kalip::veya('Görev süresi uzatımı koşullarından en az birini sağlamak', [
            Kalip::adet('SCI, SCI-Expanded, SSCI, AHCI ya da ESCI kapsamındaki dergilerde en az bir araştırma makalesi yayımlamış olmak', ['SCI-ESCI'], 1, donem: $SON_ATAMA, madde: 'Görev süresi uzatımı/a'),
            Kalip::adet('Uluslararası alan indekslerinde en az iki araştırma makalesi yayımlamış olmak', ['ALAN-INDEKS'], 2, donem: $SON_ATAMA, madde: 'Görev süresi uzatımı/b'),
            Kalip::ve('TR Dizin dergilerinde iki makale ve 150 puan', [
                Kalip::adet('TR Dizin kapsamındaki dergilerde en az iki araştırma makalesi yayımlamış olmak', ['TR-DIZIN'], 2, donem: $SON_ATAMA, madde: 'Görev süresi uzatımı/c'),
                Kalip::toplam(150, $SON_ATAMA),
            ]),
        ])],
];

foreach ($drGruplari as [$kod, $alanlar, $ad, $ilkAtama, $uzatma]) {
    $esikler[] = [
        'anahtar' => "alku-{$kod}-dr",
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => $ad.' için doktor öğretim üyesi ilk atama koşulları.',
        'aday_notu' => $ad.' için doktor öğretim üyesi kadrosuna İLK ATANMA. Yönerge ilk '
            .'atamada dönem sınırı koymuyor, bütün akademik geçmişiniz sayılıyor. Yabancı dil '
            .'koşulu 55 puan; çalışma alanı bir dil olan bölümlerde bu puanın çalışma alanınız '
            .'DIŞINDAKİ başka bir dilden alınması gerekiyor.'.$NOT_CETVEL.$NOT_MUAFIYET,
        'sart' => Kalip::ve('Doktor öğretim üyesi kadrosuna ilk atanma — '.$ad, [
            $DOKTORA_BEYANI,
            Kalip::yds(55),
            $DIL_85,
            $ilkAtama,
        ]),
    ];

    $esikler[] = [
        'anahtar' => "alku-{$kod}-dr-yeniden",
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => $ad.' için doktor öğretim üyesi görev süresi uzatımı koşulları. '
            .'Açıklama 13: son atama ya da son süre uzatım tarihinden sonraki faaliyetler.',
        'aday_notu' => $ad.' için doktor öğretim üyesi GÖREV SÜRESİ UZATIMI. Açıklama 13 '
            .'uyarınca yalnız kadroya atanma (ilk uzatmada) ya da SON SÜRE UZATIM TARİHİNDEN '
            .'sonraki faaliyetleriniz sayılıyor. Süre uzatmaları en çok iki yıllık yapılıyor ve '
            .'dosyanızı görev sürenizin bitiminden en az iki ay önce ilgili birime teslim '
            .'etmeniz gerekiyor.'.$NOT_CETVEL.$NOT_MUAFIYET,
        'sart' => Kalip::ve('Doktor öğretim üyesi görev süresi uzatımı — '.$ad, [
            Kalip::yds(55),
            $DIL_85,
            $uzatma,
        ]),
    ];
}

// ═══════════════ DOÇENT (bütün birimlerde aynı) ═══════════════
$TUM_ALANLAR = ['muhendislik', 'mimarlik', 'guzel_sanatlar', 'ziraat', 'fen',
    'sosyal', 'egitim', 'spor', 'filoloji', 'saglik'];

$esikler[] = [
    'anahtar' => 'alku-docentlik',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => $TUM_ALANLAR,
    'cetvel' => $CETVEL,
    'notlar' => 'Doçentlik B: doktora ya da uzmanlık unvanı alındıktan sonra en az 240 puanı '
        .'Tablo 1a\'dan olmak kaydıyla Tablo 1a, 1b ve/veya 2\'den toplam en az 400 puan.',
    'aday_notu' => 'Doçent kadrosuna atanma. Koşul bütün birimlerde aynı: doktora ya da '
        .'tıpta/diş hekimliğinde uzmanlık unvanını ALDIKTAN SONRA, en az 240 puanı Tablo 1a '
        .'(bilimsel yayınlar) kaleminden gelmek üzere toplam en az 400 puan. Yabancı dil '
        .'koşulu Üniversitelerarası Kurulun güncel doçentlik başvurularında istediği puan; '
        .'motorda 55 olarak uygulanıyor, ÜAK bu değeri değiştirirse yönerge de değişiyor.'
        .$NOT_CETVEL.$NOT_MUAFIYET,
    'sart' => Kalip::ve('Doçent kadrosuna atanma', [
        $UNVAN,
        Kalip::yds(55),
        $DIL_85,
        Kalip::puanDan('Doktora ya da uzmanlık unvanını aldıktan sonra Tablo 1a bilimsel yayın kalemlerinden en az 240 puan almak', ['TABLO-1A'], 240, $DOKTORA, madde: 'Doçentlik B'),
        Kalip::toplam(400, $DOKTORA),
    ]),
];

// ═══════════════ PROFESÖR (bütün birimlerde aynı) ═══════════════
$esikler[] = [
    'anahtar' => 'alku-profesorluk',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => $TUM_ALANLAR,
    'cetvel' => $CETVEL,
    'notlar' => 'Profesörlük: doçentlik sonrası SCI-ESCI dergilerinde başlıca yazarlı bir '
        .'makale, doçentlik sonrası başlıca yazarlı toplam iki araştırma makalesi, en az 360 '
        .'puanı Tablo 1a\'dan olmak kaydıyla toplam en az 600 puan.',
    'aday_notu' => 'Profesör kadrosuna atanma. Bütün koşullar DOÇENT UNVANINI ALDIKTAN SONRAKİ '
        .'çalışmalardan sağlanmalı: SSCI, SCI, SCI-Expanded, AHCI ya da ESCI kapsamındaki bir '
        .'dergide başlıca yazar olduğunuz bir makale, tek yazarlı ya da sorumlu/birinci yazar '
        .'olduğunuz toplam iki araştırma makalesi ve en az 360 puanı Tablo 1a\'dan gelmek üzere '
        .'toplam 600 puan. Ayrıca doçentlik sonrası yasal süreyi doldurmuş ve bir üniversitede '
        .'ya da araştırma kuruluşunda en az iki yıl fiilen çalışmış olmanız gerekiyor. Yabancı '
        .'dil koşulu 60 puan; çalışma alanı bir dil olan bölümlerde başka bir dilden en az 70 '
        .'puan aranıyor.'.$NOT_CETVEL.$NOT_MUAFIYET,
    'sart' => Kalip::ve('Profesör kadrosuna atanma', [
        $UNVAN,
        Kalip::yds(60),
        Kalip::beyan('Çalışma alanı bir dil olan bölümlerde çalışma alanınız dışındaki başka bir dilden en az 70 puan almış olmak', 'Profesörlük A/3'),
        $DIL_85,
        Kalip::beyan('Doçent unvanını aldıktan sonra profesörlüğe atanabilmek için gerekli yasal süreyi doldurmuş ve bir üniversitede ya da alanıyla ilgili bir araştırma kuruluşunda en az iki yıl fiilen çalışmış olmak', 'Profesörlük A/1'),
        Kalip::adet('Doçent unvanını aldıktan sonra SSCI, SCI, SCI-Expanded, AHCI ya da ESCI kapsamındaki bir dergide başlıca yazar olarak bir makale yayımlamış olmak', ['SCI-ESCI'], 1, yazar: 'baslica', donem: $DOCENTLIK, madde: 'Profesörlük A/2'),
        Kalip::adet('Doçent unvanını aldıktan sonra tek yazarlı, sorumlu yazarlı ya da birinci yazarlı toplam en az iki araştırma makalesi yayımlamış olmak', ['ARASTIRMA-MAKALE'], 2, yazar: 'baslica', donem: $DOCENTLIK, madde: 'Profesörlük A/5'),
        Kalip::puanDan('Doçent unvanını aldıktan sonra Tablo 1a bilimsel yayın kalemlerinden en az 360 puan almak', ['TABLO-1A'], 360, $DOCENTLIK, madde: 'Profesörlük B'),
        Kalip::toplam(600, $DOCENTLIK),
    ]),
];

return $esikler;
