<?php

/**
 * NİĞDE ÖMER HALİSDEMİR ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve
 * Atanma Yönergesi
 * Kaynak: pdf/17537005372.nigdeomerhalisdemiruniverstesi.pdf
 * (12 sayfa; değişiklikler 09.02.2024-2024/29 ve 27.07.2023-2023/211
 * Senato kararları)
 *
 * ── YAPI: PUAN YALNIZ YENİDEN ATANMADA ──
 * Yönergenin Puanlama Tablosu sadece DOKTOR ÖĞRETİM ÜYELİĞİNE YENİDEN
 * ATANMADA kullanılıyor (madde 10). İlk atanma (madde 9), doçentlik
 * (madde 11) ve profesörlük (madde 12) koşulları puan barajı değil,
 * "şu indekste en az bir makale" biçiminde SAYI ve BELGE şartı.
 *
 * ── DOKTOR ÖĞRETİM ÜYELİĞİNE İLK ATANMA: YEDİ ALAN GRUBU ──
 * Madde 9 temel alan başına farklı bir yayın koşulu koyuyor:
 *   (2) Eğitim Bilimleri            SCI-ESCI ya da alan endeksi 1 makale
 *   (3) Fen, Mühendislik, Ziraat    SCI/SSCI/AHCI 1 makale
 *   (4) Sağlık Bilimleri            SCI-ESCI 1 makale
 *   (5) Güzel Sanatlar              1 makale, kitap ya da 2 hakemli makale
 *   (6) Sosyal, Filoloji, İlahiyat, Hukuk   1 makale ya da 2 hakemli makale
 *   (7) Spor Bilimleri              1 makale ya da 2 hakemli makale
 *   (8) Mimarlık                    1 makale ya da 2 hakemli makale
 * İlk atanmada TOPLAM PUAN ŞARTI YOK.
 *
 * ── YENİDEN ATANMADA DÖRT BASAMAKLI MERDİVEN ──
 * Madde 10 yeniden atanmayı süreye bağlıyor: 40 puan ve iki SCI
 * makalesi dört yıl, 30 puan üç yıl, 20 puan iki yıl, 10 puan bir yıl.
 * Madde 10(g) 10 puanın altında kalanı da bir yıl atıyor ama ÜST ÜSTE
 * İKİ KEZ 10 puanın altında kalanın görev süresi yenilenmiyor. Eşiğe bu
 * gerçek taban (bir yıllık atama: bir hakemli makale + 10 puan)
 * yazıldı; merdivenin tamamı aday notunda.
 *
 * ── DOÇENTLİK VE PROFESÖRLÜKTE PUAN YOK ──
 * Madde 11 doçentlik için doktora/uzmanlık unvanı, doçentlik belgesi ve
 * yabancı dil; madde 12 profesörlük için doçentlik başarı belgesi, 2547
 * sayılı Kanunun süre şartı, yabancı dil ve "doçentlik unvanını aldığı
 * başvuru dönemindeki ÜAK puan şartlarını yeniden sağlamak" istiyor.
 * Sonuncusu ÜAK'ın kendi puan cetveline bağlı olduğu için
 * `hesaplanamiyor`.
 *
 * ── YABANCI DİL ──
 * Doktor öğretim üyeliğinde 55 (tamamı yabancı dilde öğretim yapan
 * bölümlerde 85), doçentlik ve profesörlükte 55 (yabancı dilde öğretim
 * yapan bölümlerde 80). Profil bölümün öğretim dilini tutmadığı için §0
 * uyarınca 55 uygulandı; yüksek eşikler aday notunda.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde 9(1)-b ve 11(2): bilim alanı belli bir yabancı dille ilgili
 *       olanların 55 puanı BAŞKA bir dilden alması.
 *   Madde 9(10): 2547 sayılı Kanunun Ek 38. maddesi kapsamındaki %20
 *       kota ataması — ilk atanma koşullarının aynısı.
 *   Madde 10(g)'nin "üst üste iki kez 10 puanın altında kalanın görev
 *       süresi yenilenmez" kuralı — geçmiş atama geçmişi profilde yok.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/nohu-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Niğde Ömer Halisdemir Üniversitesi';
$CETVEL = 'nohu-2024';
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$DIL_NOTU_DR = ' Yabancı dil koşulu 55 puandan uygulanıyor; tamamı yabancı dille eğitim-öğretim '
    .'yürütülen bölümlere başvuruyorsanız aynı dilden en az 85 puan gerekiyor. Bilim alanınız '
    .'belli bir yabancı dille ilgiliyse 55 puanı BAŞKA bir dilden almanız gerekir.';
$DIL_NOTU = ' Yabancı dil koşulu 55 puandan uygulanıyor; tamamı yabancı dille eğitim-öğretim '
    .'yürütülen bölümlerde en az 80 puan gerekiyor.';

$doktora = Kalip::beyan('Doktora, sanatta yeterlik ya da tıpta uzmanlık unvanını almış olmak', '9');

$esikler = [];

// ══════════════════════════════════════════════════════════════════════════
// DOKTOR ÖĞRETİM ÜYESİ — İLK ATANMA (Madde 9)
// ══════════════════════════════════════════════════════════════════════════

/**
 * @param  list<string>  $alanlar
 * @param  list<array<string, mixed>>  $secenekler
 * @return array<string, mixed>
 */
$drEsigi = function (string $anahtar, array $alanlar, string $alanAdi, array $secenekler, string $md) use ($UNIVERSITE, $CETVEL, $doktora, $DIL_NOTU_DR): array {
    return [
        'anahtar' => "nohu-{$anahtar}-dr",
        'aday_notu' => "{$alanAdi} temel alanında doktor öğretim üyesi kadrosuna ilk atanma için "
            .'yönerge TOPLAM PUAN İSTEMİYOR; yalnız belirli indekslerde yayın koşulu var. Vaka '
            .'raporu, editöre mektup, ön bildiri ve teknik özet bu kapsamda sayılmıyor. '
            .'Atamalar en az bir, en fazla dört yıl süreyle yapılıyor.'.$DIL_NOTU_DR,
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => "Madde 9({$md}) ({$alanAdi}): indeks bazlı yayın koşulu; toplam puan şartı yok.",
        'sart' => Kalip::ve("Doktor Öğretim Üyesi kadrosuna ilk atanma — {$alanAdi}", [
            $doktora,
            Kalip::yds(55),
            count($secenekler) === 1
                ? $secenekler[0]
                : Kalip::veya('Yayın koşullarından en az biri', array_values($secenekler)),
        ]),
    ];
};

$esikler[] = $drEsigi('egitim', ['egitim'], 'Eğitim Bilimleri', [
    Kalip::adet(
        'SCI, SCI-Expanded, SSCI, AHCI ya da ESCI kapsamında taranan dergilerde veya ÜAK\'ın '
        .'Eğitim Bilimleri temel alanı için belirlediği alan endekslerinde en az bir makale '
        .'yayımlamış olmak',
        ['SCI-ESCI'], 1, madde: '9-2',
    ),
], '2');

$esikler[] = $drEsigi('fen', ['fen', 'muhendislik', 'ziraat'],
    'Fen Bilimleri ve Matematik, Mühendislik ile Ziraat, Orman ve Su Ürünleri', [
        Kalip::adet(
            'SCI, SCI-Expanded, SSCI ya da AHCI kapsamında taranan dergilerin birinde en az bir '
            .'makale yayımlamış olmak',
            ['SCI'], 1, madde: '9-3',
        ),
    ], '3');

$esikler[] = $drEsigi('saglik', ['saglik'], 'Sağlık Bilimleri', [
    Kalip::adet(
        'SCI, SCI-Expanded, SSCI, AHCI ya da ESCI kapsamında taranan dergilerin birinde en az '
        .'bir makale yayımlamış olmak',
        ['SCI-ESCI'], 1, madde: '9-4',
    ),
], '4');

$esikler[] = $drEsigi('guzel-sanatlar', ['guzel_sanatlar'], 'Güzel Sanatlar', [
    Kalip::adet('SCI, SCI-Expanded, ESCI, SSCI, AHCI, alan endeksleri ya da ULAKBİM tarafından taranan ulusal hakemli dergilerin birinde en az bir makale yayımlamış olmak', ['SCI-ESCI', 'ULAKBIM'], 1, madde: '9-5'),
    Kalip::adet('Ya da alanınızla ilgili uluslararası yayınevlerince yayımlanmış bilimsel, sanatsal veya eğitsel içerikli bir kitap ya da kitap bölümü yayımlamış olmak', ['KITAP-ULUSLARARASI'], 1, madde: '9-5'),
    Kalip::adet('Ya da uluslararası hakemli dergilerde veya ULAKBİM tarafından taranan ya da taranmayan ulusal hakemli dergilerde en az iki makale yayımlamış olmak', ['HAKEMLI'], 2, madde: '9-5'),
], '5');

$esikler[] = $drEsigi('sosyal', ['sosyal', 'filoloji', 'ilahiyat', 'hukuk'],
    'Sosyal, Beşeri ve İdari Bilimler, Filoloji, İlahiyat ve Hukuk', [
        Kalip::adet('SCI, SCI-Expanded, ESCI, SSCI, AHCI kapsamında taranan dergilerde ya da ÜAK\'ın ilgili temel alan için belirlediği alan endeksinde en az bir makale yayımlamış olmak', ['SCI-ESCI'], 1, madde: '9-6'),
        Kalip::adet('Ya da uluslararası hakemli dergilerde veya ULAKBİM tarafından taranan ya da taranmayan ulusal hakemli dergilerde en az iki makale yayımlamış olmak', ['HAKEMLI'], 2, madde: '9-6'),
    ], '6');

$esikler[] = $drEsigi('spor', ['spor'], 'Spor Bilimleri', [
    Kalip::adet('SCI, SCI-Expanded, ESCI, SSCI, AHCI kapsamında taranan dergilerde ya da ÜAK\'ın Spor Bilimleri temel alanı için belirlediği alan endekslerinde en az bir makale yayımlamış olmak', ['SCI-ESCI'], 1, madde: '9-7'),
    Kalip::adet('Ya da uluslararası hakemli dergilerde veya ULAKBİM tarafından taranan ya da taranmayan ulusal hakemli dergilerde en az iki makale yayımlamış olmak', ['HAKEMLI'], 2, madde: '9-7'),
], '7');

$esikler[] = $drEsigi('mimarlik', ['mimarlik'], 'Mimarlık, Planlama ve Tasarım', [
    Kalip::adet('SCI, SCI-Expanded, ESCI, SSCI, AHCI kapsamında taranan dergilerde ya da ÜAK\'ın Mimarlık temel alanı için belirlediği alan endekslerinde en az bir makale yayımlamış olmak', ['SCI-ESCI'], 1, madde: '9-8'),
    Kalip::adet('Ya da uluslararası hakemli dergilerde veya ULAKBİM tarafından taranan ya da taranmayan ulusal hakemli dergilerde en az iki makale yayımlamış olmak', ['HAKEMLI'], 2, madde: '9-8'),
], '8');

// ══════════════════════════════════════════════════════════════════════════
// DOKTOR ÖĞRETİM ÜYESİ — YENİDEN ATANMA (Madde 10)
// ══════════════════════════════════════════════════════════════════════════

$MERDIVEN = ' Yeniden atanma SÜREYE bağlı dört basamaklı bir merdiven: dört yıllık atama için '
    .'SCI, SCI-Expanded, SSCI ve AHCI dergilerinde en az iki makale ile toplam 40 puan; üç '
    .'yıllık atama için bir SCI-ESCI makalesi ya da iki alan endeksli makale ile toplam 30 puan; '
    .'iki yıllık atama için bir alan endeksli makale ya da iki hakemli makale ile toplam 20 '
    .'puan; bir yıllık atama için bir hakemli makale ile toplam 10 puan. Aşağıda bu TABAN '
    .'gösteriliyor. Madde 10(g): 10 puanın altında kalanlar da bir yıl atanıyor, ancak ÜST ÜSTE '
    .'İKİ KEZ 10 puanın altında kalanın görev süresi üçüncü kez yenilenmiyor.';

foreach ([
    ['egitim', ['egitim'], 'Eğitim Bilimleri'],
    ['fen', ['fen', 'muhendislik', 'saglik', 'ziraat'], 'Fen Bilimleri ve Matematik, Mühendislik, Sağlık Bilimleri ile Ziraat, Orman ve Su Ürünleri'],
    ['guzel-sanatlar', ['guzel_sanatlar'], 'Güzel Sanatlar'],
    ['sosyal', ['sosyal', 'filoloji', 'ilahiyat', 'hukuk'], 'Sosyal, Beşeri ve İdari Bilimler, Filoloji, İlahiyat ve Hukuk'],
    ['spor', ['spor'], 'Spor Bilimleri'],
    ['mimarlik', ['mimarlik'], 'Mimarlık, Planlama ve Tasarım'],
] as [$anahtar, $alanlar, $alanAdi]) {
    $esikler[] = [
        'anahtar' => "nohu-{$anahtar}-dr-yeniden",
        'aday_notu' => 'Son atandığınız tarihten sonraki akademik faaliyetleriniz sayılıyor.'
            .$MERDIVEN,
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => "Madde 10 ({$alanAdi}): en hafif basamak — 1 hakemli makale, toplam 10 puan.",
        'sart' => Kalip::ve("Doktor Öğretim Üyesi kadrosuna yeniden atanma — {$alanAdi}", [
            Kalip::adet(
                'Son atamanızdan sonra uluslararası hakemli dergilerde ya da ULAKBİM tarafından '
                .'taranan veya taranmayan ulusal hakemli dergilerde en az bir makale yayımlamış '
                .'olmak',
                ['HAKEMLI'], 1, donem: $SON_ATAMA, madde: '10-iv',
            ),
            Kalip::toplam(10, $SON_ATAMA),
        ]),
    ];
}

// ══════════════════════════════════════════════════════════════════════════
// DOÇENT (Madde 11) ve PROFESÖR (Madde 12)
// ══════════════════════════════════════════════════════════════════════════

$TUM_ALANLAR = ['egitim', 'fen', 'muhendislik', 'saglik', 'ziraat', 'guzel_sanatlar',
    'sosyal', 'filoloji', 'ilahiyat', 'hukuk', 'spor', 'mimarlik'];

$esikler[] = [
    'anahtar' => 'nohu-docentlik',
    'aday_notu' => 'Doçent kadrosuna atanmada yönerge puan barajı istemiyor: doktora ya da '
        .'uzmanlık unvanı, doçentlik unvanı veya belgesi ve yabancı dil koşulu yeterli. '
        .'Başvuru dönemine esas olan ÜAK doçentlik kriteri ayrıca uygulanıyor.'.$DIL_NOTU,
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => $TUM_ALANLAR,
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 11: doktora/uzmanlık unvanı, doçentlik unvanı, yabancı dil 55.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma', [
        $doktora,
        Kalip::beyan(
            'Bilimsel ve sanatsal yayınlarınızın değerlendirilmesi sonucunda doçentlik unvanı ya '
            .'da doçentlik belgesi almış olmak',
            '11-1',
        ),
        Kalip::yds(55),
    ]),
];

$esikler[] = [
    'anahtar' => 'nohu-profesorluk',
    'aday_notu' => 'Profesör kadrosuna atanmada yönerge kendi puan tablosundan baraj istemiyor; '
        .'doçentlik başarı belgesi, 2547 sayılı Kanunun süre şartı, yabancı dil ve doçentlik '
        .'unvanınızı aldığınız başvuru dönemindeki ÜAK PUAN ŞARTLARINI (lisansüstü tezlerinizden '
        .'üretilmiş yayın şartı hariç) YENİDEN sağlamış olmanız gerekiyor. Son koşul ÜAK\'ın '
        .'kendi puan cetveline bağlı olduğu için motor onu hesaplayamıyor.'.$DIL_NOTU,
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => $TUM_ALANLAR,
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 12: doçentlik başarı belgesi; 2547 süre şartı; yabancı dil 55; ÜAK puan '
        .'şartlarını yeniden sağlama.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma', [
        Kalip::beyan(
            'Doçent unvanını aldıktan sonra 2547 sayılı Kanunun gerekli gördüğü süre ve şartları '
            .'sağlamış olmak ve doçentlik başarı belgesine sahip olmak',
            '12-1',
        ),
        Kalip::yds(55),
        Kalip::hesaplanamiyor(
            'Doçentlik unvanını aldığınız başvuru dönemindeki ÜAK puan şartlarını (lisansüstü '
            .'tezlerinizden üretilmiş yayın şartı hariç) yeniden sağlamış olmak — ÜAK\'ın kendi '
            .'puan cetveline bağlı olduğu için motor hesaplayamıyor',
            '12-4',
        ),
    ]),
];

return $esikler;
