<?php

use App\Services\Scoring\Sart\Kalip;

/**
 * TOKAT GAZİOSMANPAŞA ÜNİVERSİTESİ — Öğretim Üyeliği Kadrolarına Başvuru
 * Koşulları ve Uygulama İlkeleri
 * Kaynak: pdf/17766907611.Tokat Gaziosmanpaşa Üni. Kriter.pdf
 * (25.12.2025 tarihli YÖK Genel Kurul kararıyla değişik; 31.03.2026'dan
 * itibaren geçerli)
 *
 * Cetvel: cetvel/tokat-gaziosmanpasa-2026.php
 *
 * ── EŞİKLERİN YAPISI ──
 * Puan barajları temel alandan bağımsız: doktor öğretim üyeliğinde 150,
 * doçentlikte 300 (en az 150'si makale, kitap, bildiri ya da projeden),
 * profesörlükte doçentlik sonrası 500 (en az 250'si aynı kalemlerden).
 * Temel alana göre değişen tek şey, zorunlu makalenin hangi indeks
 * kademesinden geleceği.
 *
 * ── YORUM KARARLARI (§0) ──
 *   Doktor öğretim üyeliğinde görev süresi uzatımının puanı istenen süreye
 *       bağlı (1 yıl 40, 2 yıl 80, 3 yıl 120, 4 yıl 150 puan). Araç kaç
 *       yıllık uzatım istendiğini bilmediği için eşiğe en düşük basamak
 *       (40 puan) yazıldı; merdivenin tamamı aday notunda duruyor.
 *   Doçentlik ve profesörlüğün 4. maddesindeki seçeneklerden "kesintisiz
 *       üç ay yurt dışında görev almak" belgeye bağlı olduğu için
 *       yazılmadı; kitap, proje, patent ve makale kolları yazıldı.
 *       Maddenin "1,5 kat puan" alternatifi de ayrı bir kol olarak duruyor.
 *   Profesörlüğün 1. maddesi ÜAK doçentlik temel alan başvuru şartlarının
 *       yeniden sağlanmasını istiyor; şartlar temel alana ve döneme göre
 *       değiştiği için koşul `hesaplanamiyor` düğümünde.
 *   Yabancı dil eşiği 60 puan olarak yazıldı; doçentlik bilim alanı bir
 *       yabancı dille ilgiliyse yönerge başka bir dilden 55 puan istiyor.
 *   Doktor öğretim üyeliğinin 6. maddesindeki Tıp ve Diş Hekimliği
 *       istisnası ile 5. maddedeki %30 kotası yazılmadı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Profesörlüğün 6. maddesindeki başlıca araştırma eseri tanımı beyan
 *       olarak eklendi.
 *   Doktor öğretim üyeliğinin 4. maddesindeki askerlik, hamilelik ve
 *       hastalık nedeniyle süre ekleme hükmü.
 */
$FEN = ['fen', 'muhendislik', 'ziraat', 'saglik'];
$SOSYAL = ['egitim', 'spor', 'filoloji', 'guzel_sanatlar', 'hukuk', 'ilahiyat', 'mimarlik', 'sosyal'];

$DIL_NOTU = 'Bütün kadrolarda merkezi bir yabancı dil sınavından en az 60 puan aranıyor; '
    .'doçentlik bilim alanınız bir yabancı dille ilgiliyse sınavı başka bir dilde verip 55 puan '
    .'almanız yeterli, araç 60 üzerinden değerlendiriyor.';

/** Doçentlik ve profesörlüğün 4. maddesindeki seçenekler. */
$dortuncuMadde = fn (string $makaleGrubu, int $toplam, int $yayinPuani, ?array $donem, string $madde): array => Kalip::veya('4. maddedeki şartlardan en az biri', [
    Kalip::adet('Lisansüstü tezlerinizden üretilmemiş, Web of Science Book Citation Index\'te taranan bir kitap, kitap bölümü ya da kitap editörlüğü', ['BKCI'], 1, donem: $donem, madde: $madde.'/a'),
    Kalip::adet('Uluslararası kuruluşlar, COST, AB, TÜBİTAK, TÜBA, TÜSEB, TAGEM ya da diğer kamu kuruluşları projelerinden en az 1\'inde yürütücü olmak', ['PROJE-YURUTUCU'], 1, donem: $donem, madde: $madde.'/b'),
    Kalip::adet('Aynı projelerden en az 2\'sinde araştırmacı olmak', ['PROJE-ARASTIRMACI'], 2, donem: $donem, madde: $madde.'/b'),
    Kalip::adet('Uluslararası ya da ulusal patent veya faydalı model almış olmak', ['PATENT'], 1, donem: $donem, madde: $madde.'/c'),
    Kalip::adet('Alanınıza göre belirtilen indeks kademelerinde en az 1 makale', [$makaleGrubu], 1, donem: $donem, madde: $madde.'/d'),
    Kalip::ve('Bu şartların hiçbiri sağlanmıyorsa toplam puanların bir buçuk katı', [
        Kalip::toplam($toplam, donem: $donem, liste: $madde),
        Kalip::toplam($yayinPuani, donem: $donem, maddeler: ['YAYIN-PROJE'], liste: $madde),
    ]),
]);

$esikler = [];

foreach ([
    ['ad' => 'Fen Bilimleri, Mühendislik, Ziraat ve Sağlık Bilimleri', 'anahtar' => 'fen', 'alan' => $FEN,
        'drGrup' => '1.1.A-D', 'drAdet' => 1, 'dortGrup' => '1.1.A-B',
        'drAd' => 'SCIE, SSCI, AHCI (Q1-Q4) ya da ESCI-Scopus kademelerinden (1.1.a-1.1.d)',
        'dortAd' => 'SCIE, SSCI ya da AHCI\'nin Q1 veya Q2 kademesinden (1.1.a, 1.1.b)'],
    ['ad' => 'Eğitim, Spor, Filoloji, Güzel Sanatlar, Hukuk, İlahiyat, Mimarlık ve Sosyal Bilimler',
        'anahtar' => 'sosyal', 'alan' => $SOSYAL,
        'drGrup' => '1.1.A-E', 'drAdet' => 2, 'dortGrup' => '1.1.A-C',
        'drAd' => 'SCIE, SSCI, AHCI, ESCI-Scopus ya da TR Dizin kademelerinden (1.1.a-1.1.e)',
        'dortAd' => 'SCIE, SSCI ya da AHCI\'nin Q1, Q2 veya Q3 kademesinden (1.1.a-1.1.c)'],
] as $g) {
    $ortak = ['universite' => 'Tokat Gaziosmanpaşa Üniversitesi', 'alan' => $g['alan'],
        'cetvel' => 'tokat-gaziosmanpasa-2026'];

    // ══ DOKTOR ÖĞRETİM ÜYELİĞİ ══
    $esikler[] = array_merge($ortak, [
        'anahtar' => 'tokat-gaziosmanpasa-'.$g['anahtar'].'-dr',
        'kadro' => 'dr_ogr_uyesi',
        'notlar' => 'Doktor öğretim üyeliği Madde 1: toplam en az 150 puan. Madde 2: en az üç '
            .'yayın; bunların en az '.$g['drAdet'].' tanesi '.$g['drAd'].' olmalı.',
        'aday_notu' => $g['ad'].' temel alanlarında doktor öğretim üyeliğine ilk atanma için 150 '
            .'puan ve en az üç yayın gerekiyor; bu yayınların en az '.$g['drAdet'].' tanesi '
            .$g['drAd'].' olmalı. Puan barajı temel alandan bağımsız; alan farkı yalnızca zorunlu '
            .'makalenin indeks kademesinde. '.$DIL_NOTU,
        'sart' => Kalip::ve('Doktor öğretim üyeliğine ilk atanma koşulları', [
            Kalip::toplam(150, liste: 'Doktor öğretim üyeliği Madde 1'),
            Kalip::adet('En az 3 makale', ['MAKALE'], 3, madde: 'Doktor öğretim üyeliği Madde 2'),
            Kalip::adet('Bu makalelerden en az '.$g['drAdet'].' tanesi belirtilen indeks kademelerinde olmak', [$g['drGrup']], $g['drAdet'], madde: 'Doktor öğretim üyeliği Madde 2'),
        ]),
    ]);

    // ══ GÖREV SÜRESİ UZATIMI ══
    $esikler[] = array_merge($ortak, [
        'anahtar' => 'tokat-gaziosmanpasa-'.$g['anahtar'].'-dr-yeniden',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'notlar' => 'Doktor öğretim üyeliği Madde 3: son atanma döneminde 1 yıllık uzatım için '
            .'40, 2 yıllık için 80, 3 yıllık için 120, 4 yıllık için 150 puan. Eşiğe en düşük '
            .'basamak (40) yazıldı. Madde 2: uzatımlarda en az '.$g['drAdet'].' yayın belirtilen '
            .'kademelerde olmalı.',
        'aday_notu' => 'Görev süresi uzatımında gereken puan, istediğiniz uzatma süresine bağlı: '
            .'bir yıl için 40, iki yıl için 80, üç yıl için 120, dört yıl için 150 puan. Araç kaç '
            .'yıllık uzatma istediğinizi bilmediği için en düşük basamağı (40 puan) '
            .'değerlendiriyor; daha uzun bir süre istiyorsanız hedefinizi buna göre yükseltin. '
            .'Puanlar son atanma döneminde yapılan çalışmalardan sayılıyor. Ayrıca uzatımda en az '
            .$g['drAdet'].' yayınınızın '.$g['drAd'].' olması gerekiyor. Askerlik, hamilelik ve '
            .'hastalık gibi zorunlu nedenlerle üç ay ve üzeri ayrı kaldığınız süreler görev '
            .'sürenize ekleniyor.',
        'sart' => Kalip::ve('Görev süresi uzatımı koşulları', [
            Kalip::toplam(40, donem: Kalip::SON_ATAMA_SONRASI, liste: 'Doktor öğretim üyeliği Madde 3'),
            Kalip::adet('Belirtilen indeks kademelerinde en az '.$g['drAdet'].' yayın', [$g['drGrup']], $g['drAdet'], donem: Kalip::SON_ATAMA_SONRASI, madde: 'Doktor öğretim üyeliği Madde 2'),
        ]),
    ]);

    // ══ DOÇENTLİK ══
    $esikler[] = array_merge($ortak, [
        'anahtar' => 'tokat-gaziosmanpasa-'.$g['anahtar'].'-docentlik',
        'kadro' => 'docentlik',
        'notlar' => 'Doçentlik Madde 1-4: doçentlik unvanı; toplam en az 300 puan; bunun en az '
            .'150 puanı makale, kitap, bildiri ya da projelerden; doktora sonrası 4. maddedeki '
            .'şartlardan en az biri ya da 450 ve 225 puan.',
        'aday_notu' => 'Doçent kadrosu için doçentlik unvanının yanında 300 puan gerekiyor ve '
            .'bunun en az 150\'si makale, kitap, bildiri ya da projelerden gelmeli. Ayrıca '
            .'doktora unvanınızı aldıktan sonra dört seçenekten en az birini sağlamalısınız: '
            .'BKCI\'de taranan bir kitap ya da bölüm, bir projede yürütücülük (ya da iki projede '
            .'araştırmacılık), bir patent veya faydalı model, ya da '.$g['dortAd'].' en az bir '
            .'makale. Bunların hiçbiri yoksa 300 ve 150 puanın bir buçuk katını (450 ve 225) '
            .'toplamanız gerekiyor. Yönergenin beşinci seçeneği olan "kesintisiz üç ay yurt '
            .'dışında görev almak" belgeye bağlı olduğu için araçta değerlendirilmiyor. '.$DIL_NOTU,
        'sart' => Kalip::ve('Doçentlik koşulları', [
            Kalip::beyan('Doçentlik unvanını almış olmak', 'Doçentlik Madde 1'),
            Kalip::yds(60),
            Kalip::toplam(300, liste: 'Doçentlik Madde 2'),
            Kalip::toplam(150, maddeler: ['YAYIN-PROJE'], liste: 'Doçentlik Madde 3'),
            $dortuncuMadde($g['dortGrup'], 450, 225, Kalip::DOKTORA_SONRASI, 'Doçentlik Madde 4'),
        ]),
    ]);

    // ══ PROFESÖRLÜK ══
    $esikler[] = array_merge($ortak, [
        'anahtar' => 'tokat-gaziosmanpasa-'.$g['anahtar'].'-profesorluk',
        'kadro' => 'profesorluk',
        'notlar' => 'Profesörlük Madde 1-6: doçentlik başvuru döneminden sonra ÜAK temel alan '
            .'şartlarını tekrar sağlamak; toplam en az 500 puan; bunun en az 250 puanı makale, '
            .'bildiri, kitap ya da projelerden; 4. maddedeki şartlardan en az biri ya da 750 ve '
            .'375 puan; başlıca araştırma eseri.',
        'aday_notu' => 'Profesörlük için doçentlik unvanınızı aldığınız başvuru döneminden '
            .'sonraki çalışmalardan 500 puan gerekiyor ve bunun en az 250\'si makale, bildiri, '
            .'kitap ya da projelerden gelmeli. Dördüncü madde doçentlikteki seçeneklerin aynısını '
            .'arıyor; hiçbiri yoksa 500 ve 250 puanın bir buçuk katı (750 ve 375) isteniyor. '
            .'Ayrıca doçentliği alırken sağladığınız ÜAK temel alan başvuru şartlarını yeniden '
            .'sağlamanız gerekiyor (lisansüstü tezlerden üretilmiş yayınlar bu kez zorunlu '
            .'değil); bu koşul temel alana ve döneme göre değiştiğinden araç hesaplayamıyor. '
            .$DIL_NOTU,
        'sart' => Kalip::ve('Profesörlük koşulları', [
            Kalip::yds(60),
            Kalip::hesaplanamiyor('Doçentlik unvanının alındığı başvuru döneminden sonra, bu unvanı alırken sağladığınız ÜAK doçentlik temel alan başvuru şartlarını yeniden sağlamış olmak (lisansüstü tezlerden üretilmiş yayınlar zorunlu değil)', 'Profesörlük Madde 1'),
            Kalip::toplam(500, donem: Kalip::DOCENTLIK_SONRASI, liste: 'Profesörlük Madde 2'),
            Kalip::toplam(250, donem: Kalip::DOCENTLIK_SONRASI, maddeler: ['YAYIN-PROJE'], liste: 'Profesörlük Madde 3'),
            $dortuncuMadde($g['dortGrup'], 750, 375, Kalip::DOCENTLIK_SONRASI, 'Profesörlük Madde 4'),
            Kalip::beyan('Doçentlikten sonra yayımlanmış, tek yazarlı ya da ilk yazar veya sorumlu yazar olduğunuz bir makaleyi, tez danışmanlığı yaptığınız öğrenciyle birlikte tezden üretilmiş bir makaleyi, yürütücüsü olduğunuz bir projeden üretilmiş makaleyi ya da birinci ismi veya editörü olduğunuz bir kitabı başlıca araştırma eseri olarak göstermek', 'Profesörlük Madde 6'),
        ]),
    ]);
}

return $esikler;
