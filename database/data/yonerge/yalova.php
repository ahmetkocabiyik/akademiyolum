<?php

/**
 * YALOVA ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Kriterleri
 * (01.07.2024'ten geçerli) · Kaynak: pdf/17537010472.yalovauniverstesi.pdf
 *
 * ALTI TEMEL ALAN, ALTI AYRI EK. Yönergenin gövdesi (MADDE 1-13) usul
 * kuralları; sayısal ölçütlerin tamamı EK-A…EK-E tablolarının başındaki
 * "BAŞVURU ESASLARI" bölümlerinde. Her ekte üç kadro için ayrı paragraf var,
 * doktor öğretim üyeliğinde ayrıca "ilk başvuru" ile "yeniden atama" ayrımı
 * yapılıyor.
 *
 * ── ALANLARIN ORTAK İSKELETİ ──
 *   Dr. Öğr. Üyesi ilk başvuru  : birkaç bölümden 50 puan + yayın koşulu
 *   Dr. Öğr. Üyesi yeniden atama: son atamadan sonra 40 puan, 15'i makaleden
 *   Doçent                      : ÜAK belgesi + toplam 150 puan + alt kapı
 *   Profesör                    : doçentlik sonrası toplam 150 puan + alt kapı
 *
 * ── ALANLARI AYIRAN ALT KAPILAR ──
 *   Sosyal      Doç: 1,2,4,7,8'den 50p · Prof: 1,2,4'ten birer yayın +
 *               maddelerin EN AZ BEŞİNDEN 150p
 *   Mühendislik Dr: 1a veya 3a'dan 1 yayın · Doç: doktora sonrası 1a'dan
 *               3 yayın · Prof: 7. maddeden (BAP hariç) 1 faaliyet + beş madde
 *   Sağlık      Tablo dipnotlarıyla dört ek zorunluluk (aşağıda) ·
 *               Prof: altı bölümün HER BİRİNDEN bir faaliyet
 *   Mimarlık    Doç: 1. maddede (1ç hariç) TEK YAZARLI bir makale ·
 *               Prof: altı bölümün her birinden bir faaliyet + 9. maddeden 6p
 *   Güzel San.  Puanın çoğu 13. bölümden (sanatsal faaliyet): Dr 35p,
 *               Doç 80p
 *   Spor        Doç: 1. maddede başlıca yazar olarak 20p
 *
 * ── SAĞLIK TABLOSUNUN DİPNOT ZORUNLULUKLARI ──
 * EK-C'nin puan tablosu, kadro paragraflarının dışında dört koşul daha
 * getiriyor. Bunlar tablo bölümlerinin altında yazdığı için bütün kadrolara
 * uygulandı:
 *   1. bölüm: "doçent ve profesör kadrolarına başvurularda, en az bir
 *      makalede başlıca yazar olmak kaydıyla en az 40 puan alınmalıdır"
 *      (yalnızca doçent ve profesöre)
 *   2. bölüm: "a bendi kapsamında en az 10 puan alınmalıdır"
 *   3. bölüm: "en az 1 yayın zorunludur"
 *   5. bölüm: "en az 4 puan alınması zorunludur"
 *
 * ── GÜZEL SANATLAR'DA PROFESÖRLÜK METNİ DOÇENTLİĞİN AYNISI ──
 * EK-D'nin 3. maddesi ("PROFESÖR KADROSUNA BAŞVURU") kelimesi kelimesine 2.
 * maddeyi tekrarlıyor; "Doçentlik kadrosuna atama için adayın…" diye
 * başlıyor ve dönem olarak da doktora sonrasını gösteriyor. Kaynakta böyle
 * yazdığı için profesörlük eşiği de bu metne göre kuruldu; düzeltilmedi.
 * Aday notunda bu durum açıkça söyleniyor.
 *
 * ── "1., 2. VEYA 3. MADDE KAPSAMINDA BİRER MAKALE … EN AZ 2 YAYIN" ──
 * Sosyal, Sağlık, Mimarlık ve Spor'un doktor öğretim üyeliği paragrafı bu
 * bozuk cümleyle kurulu. Ölçülebilir olan tek ifade "en az 2 yayın"; koşul
 * o şekilde yazıldı. "Her birinden birer makale" okuması adayı gereğinden
 * fazla eleyeceği için seçilmedi, ama cümlenin belirsizliği aday notunda
 * belirtildi.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   "Yükseköğretim kurumları DIŞINDAN" gelen adaylardan istenen ek koşul
 *       (9. maddeden en az 6 puan, ya da Güzel Sanatlar'da son beş yılda bir
 *       dönem ders vermiş olmak): adayın hâlen bir yükseköğretim kurumunda
 *       olup olmadığını kayıt tutmuyor. Koşul yazılmadı, aday notunda anıldı.
 *   MADDE 10(2) yabancı dil: yalnızca doçentlik (65) ve doktor öğretim
 *       üyeliği (55) için sayı veriyor, profesörlük için vermiyor. İkisi
 *       yazıldı, profesörlüğe uydurulmadı.
 *   Mimarlık 13. bölümünün "en az 15 puan alınmalıdır (Dr. atamalarında
 *       aranmaz)" notu ile telafisi ("yarışma, uygulama, yazılım ve patent
 *       koşullarını yerine getiremeyenlerden 1a, 1b veya 1c bendi kapsamında
 *       en az bir yayın") doçent ve profesöre yazıldı.
 *   Tıp Fakültesi klinik branşlarda "Fakülte Yönetim Kurulu komisyonu kararı
 *       ile atama" istisnası: sayısal değil, girilmedi.
 *   Yönergenin anmadığı temel alanlar (ilahiyat, hukuk, fen, filoloji,
 *       eğitim, ziraat) için eşik yazılmadı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip
 * cetvel: cetvel/yalova-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$UAK = fn (): array => Kalip::beyan(
    'Üniversitelerarası Kurul tarafından verilen doçentlik belgesini almış olmak',
    'EK · 2. DOÇENT KADROSUNA BAŞVURU',
);

$DISARIDAN = 'Yükseköğretim kurumları dışından başvuruyorsanız yönerge ek olarak '
    .'9. maddedeki eğitim-öğretim faaliyetlerinden en az 6 puan istiyor; sistem hâlen bir '
    .'yükseköğretim kurumunda olup olmadığınızı bilmediği için bu koşul hesaba katılmadı.';

/**
 * "Şu bölümlerin HER BİRİNDEN en az bir faaliyet" koşulu.
 *
 * @param  array<string, string>  $bolumler  grup anahtarı => adayın göreceği ad
 * @param  array<string, mixed>|null  $donem
 * @return list<array<string, mixed>>
 */
$herBirinden = function (array $bolumler, ?array $donem, string $madde): array {
    $dugumler = [];

    foreach ($bolumler as $grup => $ad) {
        $dugumler[] = Kalip::adet("{$ad} en az 1 faaliyet", [$grup], 1, donem: $donem, madde: $madde);
    }

    return $dugumler;
};

/**
 * "Maddelerin en az beşinden asgari 150 puan" — Sosyal ve Mühendislik
 * profesörlüğü. Beş ayrı bölümde faaliyet olması ayrı, toplam baraj ayrı
 * sınanıyor.
 *
 * @param  array<string, mixed>|null  $donem
 * @return array<string, mixed>
 */
$besMadde = fn (?array $donem, string $madde): array => Kalip::kIle(
    'Değerlendirme puan tablosunun en az BEŞ ayrı maddesinden faaliyetiniz olmalı',
    5,
    array_map(
        fn (string $g): array => Kalip::adet("{$g}. maddeden en az 1 faaliyet", [$g], 1, donem: $donem, madde: $madde),
        ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11'],
    ),
);

$esikler = [];

// ═══════════════════════════════════════════════════════════════════════════
// EK-A · SOSYAL, BEŞERÎ VE İDARİ BİLİMLER
// ═══════════════════════════════════════════════════════════════════════════
$sosyalNotu = 'EK-A tablosu kullanılıyor. Doktor öğretim üyeliği paragrafındaki '
    .'"1., 2. veya 3. madde kapsamında birer makale olmak şartıyla ile en az 2 yayın" '
    .'cümlesi kaynakta bozuk; ölçülebilir olan "en az 2 yayın" koşulu yazıldı.';

$esikler[] = [
    'anahtar' => 'yalova-sosyal-dr',
    'aday_notu' => $sosyalNotu.' '.$DISARIDAN,
    'universite' => 'Yalova Üniversitesi',
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['sosyal'],
    'cetvel' => 'yalova-2024-sosyal',
    'notlar' => 'EK-A · 1. DOKTOR ÖĞRETİM ÜYESİ KADROSUNA BAŞVURU, ilk başvuru dalı: '
        .'1., 2. veya 3. maddeden en az 2 yayın; 1., 2., 3., 4., 5. veya 8. maddelerden 50 puan.',
    'sart' => Kalip::ve('Dr. Öğr. Üyeliğine ilk atanma — Sosyal, Beşerî ve İdari Bilimler', [
        Kalip::adet('Makale ve tez yayınlarından en az 2 yayın', ['1-2-3'], 2, madde: 'EK-A · 1'),
        Kalip::puanDan('Makale, tez yayını, kitap, atıf ve bildirilerden en az 50 puan', ['1-2-3-4-5-8'], 50, madde: 'EK-A · 1'),
        Kalip::yds(55),
    ]),
];

$esikler[] = [
    'anahtar' => 'yalova-sosyal-dr-yeniden',
    'aday_notu' => 'EK-A tablosu kullanılıyor. Yeniden atanmada dönem son atama tarihinizden başlıyor.',
    'universite' => 'Yalova Üniversitesi',
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => ['sosyal'],
    'cetvel' => 'yalova-2024-sosyal',
    'notlar' => 'EK-A · 1, yeniden atama dalı: son atama tarihinden itibaren en az 15 puanı '
        .'1., 2. veya 3. maddelerden olmak kaydıyla toplam en az 40 puan.',
    'sart' => Kalip::ve('Dr. Öğr. Üyeliğine yeniden atanma — Sosyal, Beşerî ve İdari Bilimler', [
        Kalip::puanDan('Makale ve tez yayınlarından en az 15 puan', ['1-2-3'], 15, $SON_ATAMA, madde: 'EK-A · 1'),
        Kalip::toplam(40, $SON_ATAMA),
    ]),
];

$esikler[] = [
    'anahtar' => 'yalova-sosyal-docent',
    'aday_notu' => 'EK-A tablosu kullanılıyor. '.$DISARIDAN,
    'universite' => 'Yalova Üniversitesi',
    'kadro' => 'docentlik',
    'alan' => ['sosyal'],
    'cetvel' => 'yalova-2024-sosyal',
    'notlar' => 'EK-A · 2. DOÇENT KADROSUNA BAŞVURU: ÜAK doçentlik belgesi + 1., 2., 4., 7. veya '
        .'8. maddelerden en az 50 puan olmak şartıyla toplamda 150 puan. Paragraf bu koşullar '
        .'için bir dönem başlangıcı belirtmiyor; dönem sınırı konmadı.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — Sosyal, Beşerî ve İdari Bilimler', [
        $UAK(),
        Kalip::puanDan('Makale, kitap, proje ve bilimsel toplantı faaliyetlerinden en az 50 puan', ['1-2-4-7-8'], 50, madde: 'EK-A · 2'),
        Kalip::yds(65),
        Kalip::toplam(150),
    ]),
];

$esikler[] = [
    'anahtar' => 'yalova-sosyal-profesor',
    'aday_notu' => 'EK-A tablosu kullanılıyor. Profesörlükte puanın en az beş AYRI maddeye '
        .'dağılmış olması isteniyor: tek bölümden toplanan 150 puan yetmiyor. '.$DISARIDAN,
    'universite' => 'Yalova Üniversitesi',
    'kadro' => 'profesorluk',
    'alan' => ['sosyal'],
    'cetvel' => 'yalova-2024-sosyal',
    'notlar' => 'EK-A · 3. PROFESÖR KADROSUNA BAŞVURU: doçentlik başvuru tarihinden sonra '
        .'1., 2. veya 4. madde kapsamında en az birer yayın olmak şartıyla maddelerin en az '
        .'beşinden asgari 150 puan.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma — Sosyal, Beşerî ve İdari Bilimler', [
        Kalip::adet('Uluslararası makalelerden en az 1 yayın', ['1'], 1, donem: $DOCENTLIK, madde: 'EK-A · 3'),
        Kalip::adet('Ulusal makalelerden en az 1 yayın', ['2'], 1, donem: $DOCENTLIK, madde: 'EK-A · 3'),
        Kalip::adet('Kitap bölümünden en az 1 yayın', ['4'], 1, donem: $DOCENTLIK, madde: 'EK-A · 3'),
        $besMadde($DOCENTLIK, 'EK-A · 3'),
        Kalip::toplam(150, $DOCENTLIK),
    ]),
];

// ═══════════════════════════════════════════════════════════════════════════
// EK-B · MÜHENDİSLİK
// ═══════════════════════════════════════════════════════════════════════════
$esikler[] = [
    'anahtar' => 'yalova-muhendislik-dr',
    'aday_notu' => 'EK-B tablosu kullanılıyor. Mühendislikte SCIE/SSCI/AHCI koşulu doğrudan '
        .'1a bendine bağlı; tezden üretilmiş bir SCIE makalesi (3a) de kabul ediliyor. '.$DISARIDAN,
    'universite' => 'Yalova Üniversitesi',
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['muhendislik'],
    'cetvel' => 'yalova-2024-muhendislik',
    'notlar' => 'EK-B · 1, ilk başvuru dalı: 1a veya 3a kapsamında en az 1 yayın; '
        .'1., 2., 3., 4., 7. veya 10. maddelerden en az 50 puan.',
    'sart' => Kalip::ve('Dr. Öğr. Üyeliğine ilk atanma — Mühendislik', [
        Kalip::adet('SCIE, SSCI veya AHCI kapsamındaki bir dergide en az 1 makale (tezden üretilmiş olabilir)', ['1a', '3a'], 1, madde: 'EK-B · 1'),
        Kalip::puanDan('Makale, tez yayını, kitap, proje ve patentlerden en az 50 puan', ['1-2-3-4-7-10'], 50, madde: 'EK-B · 1'),
        Kalip::yds(55),
    ]),
];

$esikler[] = [
    'anahtar' => 'yalova-muhendislik-dr-yeniden',
    'aday_notu' => 'EK-B tablosu kullanılıyor. Yeniden atanmada dönem son atama tarihinizden başlıyor.',
    'universite' => 'Yalova Üniversitesi',
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => ['muhendislik'],
    'cetvel' => 'yalova-2024-muhendislik',
    'notlar' => 'EK-B · 1, yeniden atama dalı: son atama tarihinden itibaren 1a kapsamında '
        .'en az 1 yayın, 1., 2. veya 4. maddelerden 20 puan, toplamda en az 40 puan.',
    'sart' => Kalip::ve('Dr. Öğr. Üyeliğine yeniden atanma — Mühendislik', [
        Kalip::adet('SCIE, SSCI veya AHCI kapsamındaki bir dergide en az 1 makale', ['1a'], 1, donem: $SON_ATAMA, madde: 'EK-B · 1'),
        Kalip::puanDan('Makale ve kitaplardan en az 20 puan', ['1-2-4'], 20, $SON_ATAMA, madde: 'EK-B · 1'),
        Kalip::toplam(40, $SON_ATAMA),
    ]),
];

$esikler[] = [
    'anahtar' => 'yalova-muhendislik-docent',
    'aday_notu' => 'EK-B tablosu kullanılıyor. Doçentlikte SCIE/SSCI/AHCI koşulu üç yayın ve '
        .'doktora sonrası olmak zorunda. '.$DISARIDAN,
    'universite' => 'Yalova Üniversitesi',
    'kadro' => 'docentlik',
    'alan' => ['muhendislik'],
    'cetvel' => 'yalova-2024-muhendislik',
    'notlar' => 'EK-B · 2: ÜAK doçentlik belgesi + doktora sonrası yayınlarından 1a kapsamında '
        .'en az 3 yayın + toplamda en az 150 puan.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — Mühendislik', [
        $UAK(),
        Kalip::adet('SCIE, SSCI veya AHCI kapsamındaki dergilerde en az 3 makale', ['1a'], 3, donem: $DOKTORA, madde: 'EK-B · 2'),
        Kalip::yds(65),
        Kalip::toplam(150),
    ]),
];

$esikler[] = [
    'anahtar' => 'yalova-muhendislik-profesor',
    'aday_notu' => 'EK-B tablosu kullanılıyor. Profesörlükte puanın en az beş AYRI maddeye '
        .'dağılmış olması ve BAP dışı bir projede görev almış olmanız isteniyor. '.$DISARIDAN,
    'universite' => 'Yalova Üniversitesi',
    'kadro' => 'profesorluk',
    'alan' => ['muhendislik'],
    'cetvel' => 'yalova-2024-muhendislik',
    'notlar' => 'EK-B · 3: 7. maddeden (7ğ-7h hariç) en az 1 faaliyet + doçentlik başvuru '
        .'tarihinden sonra maddelerin en az beşinden asgari 150 puan.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma — Mühendislik', [
        Kalip::adet('BAP dışı bir araştırma projesinde en az 1 görev', ['7-bap-haric'], 1, donem: $DOCENTLIK, madde: 'EK-B · 3'),
        $besMadde($DOCENTLIK, 'EK-B · 3'),
        Kalip::toplam(150, $DOCENTLIK),
    ]),
];

// ═══════════════════════════════════════════════════════════════════════════
// EK-C · SAĞLIK BİLİMLERİ
// ═══════════════════════════════════════════════════════════════════════════
/**
 * EK-C'nin puan tablosuna serpiştirilmiş, kadro paragrafının dışındaki
 * zorunluluklar. Tablo bölümlerinin altında yazdıkları için her kadroya
 * uygulandı.
 *
 * @return list<array<string, mixed>>
 */
$saglikDipnotlari = fn (): array => [
    Kalip::puanDan('TR Dizin kapsamındaki ulusal hakemli dergi makalelerinden en az 10 puan', ['2a'], 10, madde: 'EK-C · 2. bölüm dipnotu'),
    Kalip::adet('Lisansüstü veya tıpta uzmanlık tezinizden üretilmiş en az 1 yayın', ['3'], 1, madde: 'EK-C · 3. bölüm dipnotu'),
    Kalip::puanDan('Atıflardan en az 4 puan', ['5'], 4, madde: 'EK-C · 5. bölüm dipnotu'),
];

$saglikNotu = 'EK-C tablosu kullanılıyor. Kadro paragrafının yanı sıra puan tablosunun kendi '
    .'dipnotları da zorunluluk getiriyor: TR Dizin makalelerinden 10 puan, tezden üretilmiş '
    .'en az 1 yayın ve atıflardan en az 4 puan. Bunlar da koşullara eklendi.';

$esikler[] = [
    'anahtar' => 'yalova-saglik-dr',
    'aday_notu' => $saglikNotu.' '.$DISARIDAN,
    'universite' => 'Yalova Üniversitesi',
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['saglik'],
    'cetvel' => 'yalova-2024-saglik',
    'notlar' => 'EK-C · 1, ilk başvuru dalı: 1. veya 2. maddeden en az 2 yayın (birinde başlıca '
        .'yazar) + 1., 2., 3., 5. veya 8. maddelerden en az 50 puan.',
    'sart' => Kalip::ve('Dr. Öğr. Üyeliğine ilk atanma — Sağlık Bilimleri', [
        Kalip::adet('Uluslararası ve ulusal makalelerden en az 2 yayın', ['1-2'], 2, madde: 'EK-C · 1'),
        Kalip::adet('Bu makalelerden en az birinde başlıca yazar olmak', ['1-2'], 1, yazar: 'baslica', madde: 'EK-C · 1'),
        Kalip::puanDan('Makale, tez yayını, atıf ve bilimsel toplantı faaliyetlerinden en az 50 puan', ['1-2-3-5-8'], 50, madde: 'EK-C · 1'),
        ...$saglikDipnotlari(),
        Kalip::yds(55),
    ]),
];

$esikler[] = [
    'anahtar' => 'yalova-saglik-dr-yeniden',
    'aday_notu' => $saglikNotu.' Yeniden atanmada dönem son atama tarihinizden başlıyor; tablo '
        .'dipnotlarında ise dönem yazmadığı için onlar bütün kariyerinize bakıyor.',
    'universite' => 'Yalova Üniversitesi',
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => ['saglik'],
    'cetvel' => 'yalova-2024-saglik',
    'notlar' => 'EK-C · 1, yeniden atama dalı: son atama tarihinden itibaren en az 15 puanı '
        .'1., 2., 3. veya 4. maddelerden olmak kaydıyla toplam en az 40 puan.',
    'sart' => Kalip::ve('Dr. Öğr. Üyeliğine yeniden atanma — Sağlık Bilimleri', [
        Kalip::puanDan('Makale, tez yayını ve kitaplardan en az 15 puan', ['1-2-3-4'], 15, $SON_ATAMA, madde: 'EK-C · 1'),
        ...$saglikDipnotlari(),
        Kalip::toplam(40, $SON_ATAMA),
    ]),
];

$esikler[] = [
    'anahtar' => 'yalova-saglik-docent',
    'aday_notu' => $saglikNotu.' Doçentlikte 1. bölümün dipnotu da devreye giriyor: uluslararası '
        .'makalelerden en az 40 puan ve bunların birinde başlıca yazarlık. '.$DISARIDAN,
    'universite' => 'Yalova Üniversitesi',
    'kadro' => 'docentlik',
    'alan' => ['saglik'],
    'cetvel' => 'yalova-2024-saglik',
    'notlar' => 'EK-C · 2: ÜAK doçentlik belgesi + doktora sonrası 1a veya 1b kapsamında en az '
        .'2 yayın + toplamda en az 150 puan. 1. bölüm dipnotu doçent ve profesörden ayrıca '
        .'uluslararası makalelerden 40 puan ve bir makalede başlıca yazarlık istiyor.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — Sağlık Bilimleri', [
        $UAK(),
        Kalip::adet('SCIE, SSCI, AHCI, ESCI veya Scopus kapsamındaki dergilerde en az 2 makale', ['1a-1b'], 2, donem: $DOKTORA, madde: 'EK-C · 2'),
        Kalip::puanDan('Uluslararası makalelerden en az 40 puan', ['1'], 40, madde: 'EK-C · 1. bölüm dipnotu'),
        Kalip::adet('Uluslararası makalelerinizden en az birinde başlıca yazar olmak', ['1'], 1, yazar: 'baslica', madde: 'EK-C · 1. bölüm dipnotu'),
        ...$saglikDipnotlari(),
        Kalip::yds(65),
        Kalip::toplam(150),
    ]),
];

$esikler[] = [
    'anahtar' => 'yalova-saglik-profesor',
    'aday_notu' => $saglikNotu.' Profesörlükte ALTI ayrı bölümün her birinden en az bir '
        .'faaliyet isteniyor; birinden bile yoksa başvuru düşer. '.$DISARIDAN,
    'universite' => 'Yalova Üniversitesi',
    'kadro' => 'profesorluk',
    'alan' => ['saglik'],
    'cetvel' => 'yalova-2024-saglik',
    'notlar' => 'EK-C · 3: doçentlik başvurusundan sonra 1., 2., 6., 7., 8. veya 9. maddelerin '
        .'HER BİRİNDEN en az bir faaliyet + 1a kapsamında en az bir makalede başlıca yazarlık + '
        .'1. ve 2. maddelerin toplamından doçentlik sonrası en az 50 puan + toplamda en az 150 puan.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma — Sağlık Bilimleri', [
        ...$herBirinden([
            '1' => 'Uluslararası makalelerden',
            '2' => 'Ulusal makalelerden',
            '6' => 'Lisansüstü tez danışmanlığından',
            '7' => 'Bilimsel araştırma projelerinden',
            '8' => 'Bilimsel toplantı faaliyetlerinden',
            '9' => 'Eğitim-öğretim faaliyetlerinden',
        ], $DOCENTLIK, 'EK-C · 3'),
        Kalip::adet('SCIE, SSCI veya AHCI kapsamındaki bir makalede başlıca yazar olmak', ['1a'], 1, yazar: 'baslica', donem: $DOCENTLIK, madde: 'EK-C · 3'),
        Kalip::puanDan('Uluslararası ve ulusal makalelerden en az 50 puan', ['1-2'], 50, $DOCENTLIK, madde: 'EK-C · 3'),
        Kalip::puanDan('Uluslararası makalelerden en az 40 puan', ['1'], 40, madde: 'EK-C · 1. bölüm dipnotu'),
        ...$saglikDipnotlari(),
        Kalip::toplam(150, $DOCENTLIK),
    ]),
];

// ═══════════════════════════════════════════════════════════════════════════
// EK-Ç · MİMARLIK, PLANLAMA VE TASARIM
// ═══════════════════════════════════════════════════════════════════════════
/**
 * EK-Ç 13. bölüm notu: "Bu madde kapsamında en az 15 puan alınmalıdır.
 * (Yarışma, uygulama, yazılım ve patent koşullarını yerine getiremeyenlerden
 * 1a, 1b veya 1c bendi kapsamında en az bir yayın yapması gerekmektedir).
 * Doktor Öğretim Üyesi atamalarında en az puan sınırı aranmaz."
 *
 * @return array<string, mixed>
 */
$mimarlikYarisma = fn (): array => Kalip::puanDan(
    'Yarışma, uygulanmış proje ve yazılımlardan en az 15 puan',
    ['13'],
    15,
    madde: 'EK-Ç · 13. bölüm notu',
) + ['telafi' => Kalip::adet(
    'Yarışma, uygulama, yazılım ve patent koşullarını sağlayamıyorsanız: 1a, 1b veya 1c '
    .'bendi kapsamında en az 1 yayın',
    ['1-1ç-haric'],
    1,
    madde: 'EK-Ç · 13. bölüm notu',
)];

$esikler[] = [
    'anahtar' => 'yalova-mimarlik-dr',
    'aday_notu' => 'EK-Ç tablosu kullanılıyor. Doktor öğretim üyeliğinde 13. bölümün '
        .'(yarışma, proje, yazılım) asgari puan sınırı aranmıyor. '.$DISARIDAN,
    'universite' => 'Yalova Üniversitesi',
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['mimarlik'],
    'cetvel' => 'yalova-2024-mimarlik',
    'notlar' => 'EK-Ç · 1, ilk başvuru dalı: 1. veya 2. maddeden başlıca yazar olarak 1 makale '
        .'olmak şartıyla en az 2 yayın + 1., 2., 3., 4., 5. veya 8. maddelerden toplam 50 puan.',
    'sart' => Kalip::ve('Dr. Öğr. Üyeliğine ilk atanma — Mimarlık, Planlama ve Tasarım', [
        Kalip::adet('Uluslararası ve ulusal makalelerden en az 2 yayın', ['1-2'], 2, madde: 'EK-Ç · 1'),
        Kalip::adet('Bu makalelerden en az birinde başlıca yazar olmak', ['1-2'], 1, yazar: 'baslica', madde: 'EK-Ç · 1'),
        Kalip::puanDan('Makale, tez yayını, kitap, atıf ve bildirilerden en az 50 puan', ['1-2-3-4-5-8'], 50, madde: 'EK-Ç · 1'),
        Kalip::yds(55),
    ]),
];

$esikler[] = [
    'anahtar' => 'yalova-mimarlik-dr-yeniden',
    'aday_notu' => 'EK-Ç tablosu kullanılıyor. Yeniden atanmada dönem son atama tarihinizden başlıyor.',
    'universite' => 'Yalova Üniversitesi',
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => ['mimarlik'],
    'cetvel' => 'yalova-2024-mimarlik',
    'notlar' => 'EK-Ç · 1, yeniden atama dalı: son atama tarihinden itibaren en az 15 puanı '
        .'1., 2. veya 3. maddelerden olmak kaydıyla toplam en az 40 puan.',
    'sart' => Kalip::ve('Dr. Öğr. Üyeliğine yeniden atanma — Mimarlık, Planlama ve Tasarım', [
        Kalip::puanDan('Makale ve tez yayınlarından en az 15 puan', ['1-2-3'], 15, $SON_ATAMA, madde: 'EK-Ç · 1'),
        Kalip::toplam(40, $SON_ATAMA),
    ]),
];

$esikler[] = [
    'anahtar' => 'yalova-mimarlik-docent',
    'aday_notu' => 'EK-Ç tablosu kullanılıyor. Doçentlikte TEK YAZARLI bir uluslararası makale '
        .'zorunlu; ortak yazarlı yayınlar bu koşulu karşılamıyor. '.$DISARIDAN,
    'universite' => 'Yalova Üniversitesi',
    'kadro' => 'docentlik',
    'alan' => ['mimarlik'],
    'cetvel' => 'yalova-2024-mimarlik',
    'notlar' => 'EK-Ç · 2: ÜAK doçentlik belgesi + doktora sonrası 1. madde (1ç bendi hariç) '
        .'kapsamında en az 1 tek yazarlı makale + toplamda en az 150 puan. 13. bölüm notu '
        .'ayrıca 15 puan istiyor (telafisi 1a-1c\'den bir yayın).',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — Mimarlık, Planlama ve Tasarım', [
        $UAK(),
        Kalip::adet('1ç bendi dışındaki uluslararası dergilerde en az 1 TEK YAZARLI makale', ['1-1ç-haric'], 1, yazar: 'tek', donem: $DOKTORA, madde: 'EK-Ç · 2'),
        $mimarlikYarisma(),
        Kalip::yds(65),
        Kalip::toplam(150),
    ]),
];

$esikler[] = [
    'anahtar' => 'yalova-mimarlik-profesor',
    'aday_notu' => 'EK-Ç tablosu kullanılıyor. Profesörlükte ALTI ayrı bölümün her birinden en '
        .'az bir faaliyet ve 1. maddeden tek başına 50 puan isteniyor. '.$DISARIDAN,
    'universite' => 'Yalova Üniversitesi',
    'kadro' => 'profesorluk',
    'alan' => ['mimarlik'],
    'cetvel' => 'yalova-2024-mimarlik',
    'notlar' => 'EK-Ç · 3: doçentlik başvurusundan sonra 1., 2., 5., 7., 8. veya 9. maddelerin '
        .'HER BİRİNDEN en az bir faaliyet + 1a veya 1b kapsamında bir makalede başlıca yazarlık + '
        .'1. maddeden 50 puan + 9. maddeden 6 puan + toplamda 150 puan.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma — Mimarlık, Planlama ve Tasarım', [
        ...$herBirinden([
            '1' => 'Uluslararası makalelerden',
            '2' => 'Ulusal makalelerden',
            '5' => 'Atıflardan',
            '7' => 'Bilimsel araştırma projelerinden',
            '8' => 'Bilimsel toplantı faaliyetlerinden',
            '9' => 'Eğitim-öğretim faaliyetlerinden',
        ], $DOCENTLIK, 'EK-Ç · 3'),
        Kalip::adet('SCIE, SSCI, AHCI, ESCI veya Scopus kapsamındaki bir makalede başlıca yazar olmak', ['1a-1b'], 1, yazar: 'baslica', donem: $DOCENTLIK, madde: 'EK-Ç · 3'),
        Kalip::puanDan('Uluslararası makalelerden en az 50 puan', ['1'], 50, $DOCENTLIK, madde: 'EK-Ç · 3'),
        Kalip::puanDan('Eğitim-öğretim faaliyetlerinden en az 6 puan', ['9'], 6, $DOCENTLIK, madde: 'EK-Ç · 3'),
        $mimarlikYarisma(),
        Kalip::toplam(150, $DOCENTLIK),
    ]),
];

// ═══════════════════════════════════════════════════════════════════════════
// EK-D · GÜZEL SANATLAR
// ═══════════════════════════════════════════════════════════════════════════
$gsNotu = 'EK-D tablosu kullanılıyor. Güzel Sanatlar\'da puanın çoğu 13. bölümden '
    .'(sanatsal faaliyetler) gelmek zorunda.';

$esikler[] = [
    'anahtar' => 'yalova-guzel-sanatlar-dr',
    'aday_notu' => $gsNotu.' İlk başvuruda 13. bölümden 35, bilimsel bölümlerden 15 puan '
        .'isteniyor; toplam baraj yalnızca 50 puan.',
    'universite' => 'Yalova Üniversitesi',
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['guzel_sanatlar'],
    'cetvel' => 'yalova-2024-guzel-sanatlar',
    'notlar' => 'EK-D · 1, ilk başvuru dalı: 13. maddeden en az 35 puan sanatsal etkinlik + '
        .'1., 2., 3., 4. ve 8. maddelerinden en az 15 puan + toplamda en az 50 puan.',
    'sart' => Kalip::ve('Dr. Öğr. Üyeliğine ilk atanma — Güzel Sanatlar', [
        Kalip::puanDan('Sanatsal faaliyetlerden en az 35 puan', ['13'], 35, madde: 'EK-D · 1'),
        Kalip::puanDan('Makale, tez yayını, kitap ve bilimsel toplantı faaliyetlerinden en az 15 puan', ['1-2-3-4-8'], 15, madde: 'EK-D · 1'),
        Kalip::yds(55),
        Kalip::toplam(50),
    ]),
];

$esikler[] = [
    'anahtar' => 'yalova-guzel-sanatlar-dr-yeniden',
    'aday_notu' => $gsNotu.' Yeniden atanmada dönem son atama tarihinizden başlıyor.',
    'universite' => 'Yalova Üniversitesi',
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => ['guzel_sanatlar'],
    'cetvel' => 'yalova-2024-guzel-sanatlar',
    'notlar' => 'EK-D · 1, yeniden atama dalı: son atama tarihinden itibaren en az 10 puanı '
        .'1., 2., 3., 4. veya 8. maddelerinden olmak kaydıyla toplam en az 40 puan.',
    'sart' => Kalip::ve('Dr. Öğr. Üyeliğine yeniden atanma — Güzel Sanatlar', [
        Kalip::puanDan('Makale, tez yayını, kitap ve bilimsel toplantı faaliyetlerinden en az 10 puan', ['1-2-3-4-8'], 10, $SON_ATAMA, madde: 'EK-D · 1'),
        Kalip::toplam(40, $SON_ATAMA),
    ]),
];

/**
 * EK-D'nin doçentlik ve profesörlük paragrafları kaynakta BİREBİR AYNI;
 * profesörlük başlığının altındaki metin de "Doçentlik kadrosuna atama
 * için…" diye başlıyor ve doktora sonrasını dönem olarak gösteriyor.
 * İkisi de aynı koşul kümesinden üretiliyor.
 *
 * @return list<array<string, mixed>>
 */
$gsUstKadro = fn (array $DOKTORA): array => [
    Kalip::beyan(
        'Üniversitelerarası Kurul tarafından verilen doçentlik belgesini almış olmak',
        'EK-D · 2 ve 3',
    ),
    Kalip::puanDan('Sanatsal faaliyetlerden en az 80 puan', ['13'], 80, $DOKTORA, madde: 'EK-D · 2 ve 3'),
    Kalip::puanDan('Makale, tez yayını, kitap ve bilimsel toplantı faaliyetlerinden en az 20 puan', ['1-2-3-4-8'], 20, $DOKTORA, madde: 'EK-D · 2 ve 3'),
    Kalip::puanDan('Eğitim-öğretim faaliyetlerinden en az 6 puan', ['9'], 6, $DOKTORA, madde: 'EK-D · 2 ve 3'),
    Kalip::toplam(150, $DOKTORA),
];

$esikler[] = [
    'anahtar' => 'yalova-guzel-sanatlar-docent',
    'aday_notu' => $gsNotu.' Doçentlikte 13. bölümden 80 puan zorunlu. '
        .'Yükseköğretim kurumları dışından başvuruyorsanız yönerge ayrıca son beş yılda bir '
        .'eğitim-öğretim döneminde ders vermiş olmanızı istiyor; bu koşul hesaba katılmadı.',
    'universite' => 'Yalova Üniversitesi',
    'kadro' => 'docentlik',
    'alan' => ['guzel_sanatlar'],
    'cetvel' => 'yalova-2024-guzel-sanatlar',
    'notlar' => 'EK-D · 2: ÜAK doçentlik belgesi + doktora sonrası 13. maddeden 80 puan + '
        .'1., 2., 3., 4. veya 8. maddelerden 20 puan + 9. maddeden 6 puan + toplamda 150 puan.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — Güzel Sanatlar', [
        ...$gsUstKadro($DOKTORA),
        Kalip::yds(65),
    ]),
];

$esikler[] = [
    'anahtar' => 'yalova-guzel-sanatlar-profesor',
    'aday_notu' => $gsNotu.' DİKKAT: Yönergenin "PROFESÖR KADROSUNA BAŞVURU" başlığı altındaki '
        .'metin, doçentlik paragrafının kelimesi kelimesine aynısı — "Doçentlik kadrosuna atama '
        .'için…" diye başlıyor ve dönem olarak doktora sonrasını gösteriyor. Kaynakta böyle '
        .'yazdığı için koşullar aynen alındı; başvurmadan önce üniversiteye teyit ettirin.',
    'universite' => 'Yalova Üniversitesi',
    'kadro' => 'profesorluk',
    'alan' => ['guzel_sanatlar'],
    'cetvel' => 'yalova-2024-guzel-sanatlar',
    'notlar' => 'EK-D · 3. PROFESÖR KADROSUNA BAŞVURU: metin 2. maddenin birebir kopyası, '
        .'"Doçentlik kadrosuna atama için…" diye başlıyor. Kaynak hatası düzeltilmedi; koşullar '
        .'doçentlikle aynı yazıldı ve dönem metnin dediği gibi doktora sonrası bırakıldı.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma — Güzel Sanatlar', $gsUstKadro($DOKTORA)),
];

// ═══════════════════════════════════════════════════════════════════════════
// EK-E · SPOR BİLİMLERİ
// ═══════════════════════════════════════════════════════════════════════════
$esikler[] = [
    'anahtar' => 'yalova-spor-dr',
    'aday_notu' => 'EK-E tablosu kullanılıyor. '.$DISARIDAN,
    'universite' => 'Yalova Üniversitesi',
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['spor'],
    'cetvel' => 'yalova-2024-spor',
    'notlar' => 'EK-E · 1, ilk başvuru dalı: 1. veya 2. maddeden en az 2 yayın + '
        .'1., 2., 3., 4. veya 8. maddelerden en az 50 puan.',
    'sart' => Kalip::ve('Dr. Öğr. Üyeliğine ilk atanma — Spor Bilimleri', [
        Kalip::adet('Uluslararası ve ulusal makalelerden en az 2 yayın', ['1-2'], 2, madde: 'EK-E · 1'),
        Kalip::puanDan('Makale, tez yayını, kitap ve bilimsel toplantı faaliyetlerinden en az 50 puan', ['1-2-3-4-8'], 50, madde: 'EK-E · 1'),
        Kalip::yds(55),
    ]),
];

$esikler[] = [
    'anahtar' => 'yalova-spor-dr-yeniden',
    'aday_notu' => 'EK-E tablosu kullanılıyor. Yeniden atanmada dönem son atama tarihinizden başlıyor.',
    'universite' => 'Yalova Üniversitesi',
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => ['spor'],
    'cetvel' => 'yalova-2024-spor',
    'notlar' => 'EK-E · 1, yeniden atama dalı: son atama tarihinden itibaren en az 15 puanı '
        .'1., 2., 3. veya 4. maddelerden olmak kaydıyla toplam en az 40 puan.',
    'sart' => Kalip::ve('Dr. Öğr. Üyeliğine yeniden atanma — Spor Bilimleri', [
        Kalip::puanDan('Makale, tez yayını ve kitaplardan en az 15 puan', ['1-2-3-4'], 15, $SON_ATAMA, madde: 'EK-E · 1'),
        Kalip::toplam(40, $SON_ATAMA),
    ]),
];

$esikler[] = [
    'anahtar' => 'yalova-spor-docent',
    'aday_notu' => 'EK-E tablosu kullanılıyor. Doçentlikte 20 puanlık uluslararası makale '
        .'koşulunun BAŞLICA YAZAR olduğunuz yayınlardan gelmesi gerekiyor. '.$DISARIDAN,
    'universite' => 'Yalova Üniversitesi',
    'kadro' => 'docentlik',
    'alan' => ['spor'],
    'cetvel' => 'yalova-2024-spor',
    'notlar' => 'EK-E · 2: ÜAK doçentlik belgesi + doktora sonrası 1. madde kapsamında başlıca '
        .'yazar olmak kaydıyla en az 20 puan + toplamda 150 puan.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — Spor Bilimleri', [
        $UAK(),
        Kalip::puanDan('Uluslararası makalelerden en az 20 puan', ['1'], 20, $DOKTORA, madde: 'EK-E · 2'),
        Kalip::adet('Bu makalelerden en az birinde başlıca yazar olmak', ['1'], 1, yazar: 'baslica', donem: $DOKTORA, madde: 'EK-E · 2'),
        Kalip::yds(65),
        Kalip::toplam(150),
    ]),
];

$esikler[] = [
    'anahtar' => 'yalova-spor-profesor',
    'aday_notu' => 'EK-E tablosu kullanılıyor. Profesörlükte BEŞ ayrı bölümün her birinden en '
        .'az bir faaliyet isteniyor. Yükseköğretim kurumları dışından başvuruyorsanız yönerge '
        .'ek olarak 6. ve 9. maddelerden altışar puan istiyor; bu koşul hesaba katılmadı.',
    'universite' => 'Yalova Üniversitesi',
    'kadro' => 'profesorluk',
    'alan' => ['spor'],
    'cetvel' => 'yalova-2024-spor',
    'notlar' => 'EK-E · 3: doçentlik başvuru tarihinden sonra 1., 2., 4., 5. veya 8. maddelerin '
        .'HER BİRİNDEN en az bir faaliyet + 1. ve 2. madde kapsamında en az 30 puan + '
        .'toplamda 150 puan.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma — Spor Bilimleri', [
        ...$herBirinden([
            '1' => 'Uluslararası makalelerden',
            '2' => 'Ulusal makalelerden',
            '4' => 'Kitaplardan',
            '5' => 'Atıflardan',
            '8' => 'Bilimsel toplantı faaliyetlerinden',
        ], $DOCENTLIK, 'EK-E · 3'),
        Kalip::puanDan('Uluslararası ve ulusal makalelerden en az 30 puan', ['1-2'], 30, $DOCENTLIK, madde: 'EK-E · 3'),
        Kalip::toplam(150, $DOCENTLIK),
    ]),
];

return $esikler;
