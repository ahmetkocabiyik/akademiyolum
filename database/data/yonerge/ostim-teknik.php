<?php

use App\Services\Scoring\Sart\Kalip;

/**
 * OSTİM TEKNİK ÜNİVERSİTESİ — Öğretim Üyesi Atama ve Yükseltme Yönergesi
 * Kaynak: pdf/17634009071.Ostim Teknik Üniversitesi Kriter.pdf
 *
 * Cetvel: cetvel/ostim-teknik-2024.php
 *
 * ── EŞİKLERİN YAPISI ──
 * Ek-1 koşulları temel alana göre değişmiyor; bütün birimler için ortak.
 * Doktor öğretim üyeliğinde 100, doçentlikte doktora sonrası 200,
 * profesörlükte 400 (en az 200'ü doçentlik sonrası) puan aranıyor. Puan
 * barajının yanında doçentlik ve profesörlükte Web of Science makale
 * sayısı, tek yazarlık, birinci yazarlık ve son üç yıl koşulları var.
 *
 * ── YORUM KARARLARI (§0) ──
 *   Ek-1/III-1-c "yayınlardan en az birisinde ilk üç ismin içinde olmak"
 *       diyor. Araç yalnız tek yazar, birinci yazar ve başlıca yazar
 *       rollerini sorgulayabiliyor; koşul §0 gereği daha DAR olan
 *       "birinci isim" okumasıyla yazıldı. İkinci ya da üçüncü yazar
 *       olduğunuz bir yayınla koşulu sağlıyorsanız araç bunu göremez.
 *   Doçentlik ve profesörlükteki "yayınların son üç yıl içinde yapılmış
 *       olması" koşulu `sonYil(3)` penceresiyle yazıldı; profesörlükte
 *       aynı yayın kümesine hem doçentlik sonrası hem son üç yıl kısıtı
 *       birlikte uygulanamadığı için iki koşul ayrı ayrı aranıyor.
 *   Ek-1/I-2'nin "en az birinde tek yazar, en az ikisinde birinci yazar"
 *       koşulları ayrı adet düğümleri olarak yazıldı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 6/1-c'nin İngilizce eğitim veren bölümler için aradığı 85 puanlık
 *       dil belgesi — bölüme bağlı ve muafiyetleri var.
 *   MADDE 5, 7 ve 8'in başvuru, değerlendirme kurulu ve mülakat usulleri.
 *   Ek-1/I-3 ile II-4'ün "atıflar doktora unvanından sonra yapılmış
 *       olmalı" kuralı — atıfın yapıldığı tarih kayıtta ayrı tutulmuyor.
 */
$TUM_ALANLAR = ['fen', 'muhendislik', 'saglik', 'ziraat', 'sosyal', 'egitim', 'filoloji',
    'ilahiyat', 'spor', 'hukuk', 'guzel_sanatlar', 'mimarlik'];

$PUAN_NOTU = 'Puanlama ölçütlerinde ders puanı AKTS başına verildiği için ders '
    .'kayıtlarınız toplama girmiyor; TR Dizin dışındaki ulusal hakemli dergiler, çeviriler, '
    .'sanatsal etkinlikler ve toplumsal katkı kalemleri de ölçütlerde hiç yok. Scopus '
    .'makaleleri ESCI ile aynı etikette olduğu için 5 puandan sayılıyor.';

return [
    [
        'anahtar' => 'ostim-teknik-dr',
        'universite' => 'Ostim Teknik Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $TUM_ALANLAR,
        'cetvel' => 'ostim-teknik-2024',
        'notlar' => 'Ek-1/III-1: toplam asgari 100 puan; puanlama cetvelindeki nitelikleri '
            .'taşıyan bilimsel yayınlardan en az biri özgün araştırma makalesi olmak; '
            .'yayınlardan en az birinde ilk üç ismin içinde olmak.',
        'aday_notu' => 'Doktor öğretim üyeliği için 100 puan, en az bir özgün araştırma '
            .'makalesi ve yayınlarınızdan en az birinde ilk üç isim arasında olmak gerekiyor. '
            .'Araç "ilk üç isim" koşulunu yalnız BİRİNCİ İSİM üzerinden değerlendirebiliyor; '
            .'ikinci ya da üçüncü yazar olduğunuz bir yayınla koşulu sağlıyorsanız burada '
            .'görünmez. '.$PUAN_NOTU,
        'sart' => Kalip::ve('Doktor öğretim üyeliği koşulları', [
            Kalip::toplam(100),
            Kalip::adet('Puanlama cetvelindeki nitelikleri taşıyan yayınlardan en az biri özgün araştırma makalesi olmak', ['OZGUN'], 1, madde: 'Ek-1/III-1-b'),
            Kalip::veya('Yayınlardan en az birinde ilk üç ismin içinde olmak', [
                Kalip::adet('Tek yazarlı en az 1 yayın', ['MAKALE'], 1, yazar: 'tek', madde: 'Ek-1/III-1-c'),
                Kalip::adet('Birinci yazar olduğunuz en az 1 yayın', ['MAKALE'], 1, yazar: 'ilk', madde: 'Ek-1/III-1-c'),
                Kalip::adet('Sorumlu yazar olduğunuz en az 1 yayın', ['MAKALE'], 1, yazar: 'baslica', madde: 'Ek-1/III-1-c'),
            ]),
        ]),
    ],
    [
        'anahtar' => 'ostim-teknik-dr-yeniden',
        'universite' => 'Ostim Teknik Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $TUM_ALANLAR,
        'cetvel' => 'ostim-teknik-2024',
        'notlar' => 'Ek-1/III-2: son atamadan sonra en az bir ulusal ya da uluslararası hakemli '
            .'dergide yayımlanmış veya yayına kabul edilmiş tam metinli makale.',
        'aday_notu' => 'Yeniden atamada puan barajı yok. Tek koşul, son atama tarihinizden sonra '
            .'ulusal ya da uluslararası hakemli bir dergide yayımlanmış (ya da yayına kabul '
            .'edilmiş) en az bir tam metinli makale. Dikkat: puanlama ölçütlerinde TR Dizin '
            .'dışındaki ulusal hakemli dergiler için satır olmadığından araç yalnız indeksli '
            .'ve TR Dizin makalelerini sayabiliyor; TR Dizin dışı ulusal bir dergide '
            .'makaleniz varsa koşulu sağlıyor olsanız da burada görünmez.',
        'sart' => Kalip::adet('Ulusal ya da uluslararası hakemli dergide yayımlanmış en az 1 tam metinli makale', ['MAKALE'], 1, donem: Kalip::SON_ATAMA_SONRASI, madde: 'Ek-1/III-2-a'),
    ],
    [
        'anahtar' => 'ostim-teknik-docentlik',
        'universite' => 'Ostim Teknik Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $TUM_ALANLAR,
        'cetvel' => 'ostim-teknik-2024',
        'notlar' => 'Ek-1/II: ÜAK doçent unvanı; doktora sonrası yayınlarla toplam 200 puan; '
            .'Web of Science indekslerinde en az 4 makale (en az 1\'i tek yazarlı, en az 2\'si '
            .'birinci yazar, hepsi son üç yıl içinde).',
        'aday_notu' => 'Doçent kadrosu için 200 puanın tamamı DOKTORA sonrası çalışmalardan '
            .'gelmeli. Ayrıca Web of Science (SCI-Expanded, SSCI, AHCI) indekslerinde en az dört '
            .'makaleniz olmalı; bunlardan en az biri tek yazarlı, en az ikisi birinci yazar '
            .'olduğunuz makale olmalı ve dördü de başvuru tarihi itibarıyla SON ÜÇ YIL içinde '
            .'yayımlanmış olmalı. '.$PUAN_NOTU,
        'sart' => Kalip::ve('Doçentlik koşulları', [
            Kalip::beyan('Üniversitelerarası Kuruldan doçent unvanını almış olmak', 'Ek-1/II-2'),
            Kalip::toplam(200, donem: Kalip::DOKTORA_SONRASI),
            Kalip::adet('Web of Science indekslerinde son üç yılda en az 4 makale', ['WOS'], 4, donem: Kalip::sonYil(3), madde: 'Ek-1/II-3'),
            Kalip::adet('Bu makalelerden en az 1\'inde tek yazar olmak', ['WOS'], 1, yazar: 'tek', donem: Kalip::sonYil(3), madde: 'Ek-1/II-3'),
            Kalip::adet('Bu makalelerden en az 2\'sinde birinci yazar olmak', ['WOS'], 2, yazar: 'ilk', donem: Kalip::sonYil(3), madde: 'Ek-1/II-3'),
        ]),
    ],
    [
        'anahtar' => 'ostim-teknik-profesorluk',
        'universite' => 'Ostim Teknik Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $TUM_ALANLAR,
        'cetvel' => 'ostim-teknik-2024',
        'notlar' => 'Ek-1/I: toplam 400 puan (en az 200\'ü doçentlik sonrası); Web of Science '
            .'indekslerinde en az 6 makale (3\'ü doçentlik sonrası, en az 1\'i tek yazarlı, en '
            .'az 2\'si birinci yazar, en az 4\'ü son üç yılda); doçent unvanından sonra ilan '
            .'edilen bilim alanında en az 5 yıl görev yapmış olmak.',
        'aday_notu' => 'Profesörlükte toplam 400 puanın en az 200\'ü doçent unvanınızı aldıktan '
            .'sonraki döneme ait olmalı. Web of Science koşulu üç katmanlı: toplam en az altı '
            .'makale, bunların üçü doçentlik sonrası, en az biri tek yazarlı ve en az ikisi '
            .'birinci yazar olduğunuz makale; ayrıca en az dördü son üç yıl içinde yayımlanmış '
            .'olmalı. '.$PUAN_NOTU,
        'sart' => Kalip::ve('Profesörlük koşulları', [
            Kalip::beyan('Doçent unvanını aldıktan sonra ilan edilen bilim alanında en az beş yıl görev yapmış olmak', 'Ek-1/I-2'),
            Kalip::toplam(400),
            Kalip::toplam(200, donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('Web of Science indekslerinde en az 6 makale', ['WOS'], 6, madde: 'Ek-1/I-2'),
            Kalip::adet('Bu makalelerden en az 3\'ü doçentlik sonrasında yayımlanmış olmak', ['WOS'], 3, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Ek-1/I-2'),
            Kalip::adet('Doçentlik sonrası makalelerden en az 1\'inde tek yazar olmak', ['WOS'], 1, yazar: 'tek', donem: Kalip::DOCENTLIK_SONRASI, madde: 'Ek-1/I-2'),
            Kalip::adet('Doçentlik sonrası makalelerden en az 2\'sinde birinci yazar olmak', ['WOS'], 2, yazar: 'ilk', donem: Kalip::DOCENTLIK_SONRASI, madde: 'Ek-1/I-2'),
            Kalip::adet('Makalelerden en az 4\'ünün son üç yıl içinde yayımlanmış olması', ['WOS'], 4, donem: Kalip::sonYil(3), madde: 'Ek-1/I-2'),
        ]),
    ],
];
