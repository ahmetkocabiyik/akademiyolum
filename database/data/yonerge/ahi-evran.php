<?php

/**
 * KIRŞEHİR AHİ EVRAN ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve
 * Atanma Yönergesi
 * Kaynak: pdf/17682164575.kirsehir-ahi-evran-kriter-09012026.pdf
 * (20 sayfa; YÖK Genel Kurulu 24.10.2024)
 *
 * ── YAPI ──
 * Tek puanlama tablosu (Ek-1) bütün alanlarda geçerli; Güzel Sanatlar
 * temel alanında Ek-2 de sayıldığı için o alan `ahi-evran-2024-gsf`
 * cetveline bağlandı. Dr. Öğretim Üyeliği ve doçentlik eşikleri alandan
 * bağımsız (Güzel Sanatlar hariç); PROFESÖRLÜK ise madde 12(5)-ii'de
 * temel alan başına ayrı makale barajı koyuyor, bu yüzden yedi ayrı
 * profesörlük eşiği var.
 *
 * ── PROFESÖRLÜKTE ÜÇ SEÇENEKTEN BİRİ ──
 * Madde 12(5) üç seçenekli koşul tanımlıyor; biri yeterli:
 *   i.  ÜAK'ın yürürlükteki doçentlik tablosundan 120 puan + doçentlik
 *       asgari başvuru şartlarını bir kez daha sağlamak. ÜAK tablosu bu
 *       cetvelden ayrı bir puanlama düzeni olduğu ve "asgari şartları bir
 *       kez daha sağlamak" başvuru dönemine göre değiştiği için
 *       `hesaplanamiyor`.
 *   ii. Temel alan başına makale barajı + toplam 120 puan.
 *   iii. 7.a veya 7.b'den en az bir projede, ya da 7.c'den en az iki
 *       projede YÜRÜTÜCÜ olmak + 7. maddeden 40 puan + toplam 120.
 *
 * ── FEN BİLİMLERİNDE BARAJ İKİYE BÖLÜNÜYOR ──
 * 12(5)-ii Fen Bilimleri ve Matematik temel alanında Biyoloji, Fizik,
 * Kimya, Moleküler Biyoloji ve Genetik bilim alanlarına 50, Matematik ve
 * İstatistik bilim alanlarına 25 puan barajı koyuyor. Profil bilim alanı
 * tutmadığı için §0 uyarınca YÜKSEK olan (50) uygulandı; matematikçi ve
 * istatistikçiler için sonuç olduğundan katı çıkar, aday notu bunu
 * söylüyor.
 *
 * ── KURUMSAL KATKI TABLOSU BEYANA BAĞLANDI ──
 * Her kadroda Tablo 1'den belirli sayıda madde belgelemek zorunlu
 * (Dr. 3, doçent 5, profesör 7 madde; son beş yıl). Tablo 1 nitel
 * maddelerden oluşuyor (koordinatörlük, hakemlik, kazı görevi, sosyal
 * sorumluluk projesi...) ve faaliyet kaydına çevrilemiyor; `beyan` olarak
 * yazıldı. Karşılanamayan her madde için asgari puana 3 puan eklenmesi
 * kuralı da bu yüzden uygulanmıyor — eşik puanları TABAN değerinden
 * gösteriliyor, gerçek eşik daha yüksek olabilir.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   657 sayılı Kanun'un 48. maddesi ve doçentlik unvanı — `beyan`.
 *   Profesörlükte doçentlikten sonra beş yıl çalışma ve bunun en az iki
 *       yılının yükseköğretim kurumunda geçmesi — `beyan`.
 *   Profesörlükte "başlıca araştırma eseri" göstermek (madde 4-c'de temel
 *       alana göre tanımlı) — `beyan`.
 *   Yabancı dil: madde 6(3) dil şartını "ilgili mevzuatta arandığı
 *       durumlarda" doçentlik başvuru puanına bağlıyor, sayısal bir eşik
 *       koymuyor; `Kalip::yds` kullanılmadı.
 *   Madde 10(9): yeniden atanma puanının yarısını sağlayanların bir
 *       defaya mahsus atanabilmesi — takdir yetkisi.
 *   Madde 9(4): izinli geçen sürelerin puanı oranlama kuralı.
 *   Madde 6(12): Tıp Fakültesinde öğretim üyesi eksiği olan anabilim
 *       dallarında yönetim kurulu kararıyla istisna.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/ahi-evran-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Kırşehir Ahi Evran Üniversitesi';
$CETVEL = 'ahi-evran-2024';
$CETVEL_GSF = 'ahi-evran-2024-gsf';
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$ALANLAR = ['fen', 'muhendislik', 'saglik', 'ziraat', 'mimarlik', 'egitim', 'spor',
    'sosyal', 'filoloji', 'hukuk', 'ilahiyat'];

$genelSartlar = Kalip::beyan(
    '657 sayılı Devlet Memurları Kanunu\'nun 48. maddesindeki genel şartlara sahip olmak',
    '6(2)',
);

$doktora = Kalip::beyan('Doktora ya da sanatta yeterlik eğitimini tamamlamış olmak', '10');

$docentUnvani = Kalip::beyan(
    'Doçentlik unvanını almış olmak ya da yurt dışında alınan doçentlik unvanının ÜAK tarafından '
    .'Türkiye\'de geçerli sayılmış olması',
    '11(1)',
);

$besYil = Kalip::beyan(
    'Doçentlik unvanını aldıktan sonra en az beş yıl açık bulunan profesörlük kadrosuyla ilgili '
    .'bilim alanında, bu sürenin en az iki yılını yükseköğretim kurumlarında çalışmış olmak',
    '12(1)',
);

$baslicaEser = Kalip::beyan(
    'Doçentlik unvanını aldıktan sonra yayımlanan eserlerden birini başlıca araştırma eseri '
    .'olarak göstermek',
    '12(2)',
);

/** Tablo 1: Kurumsal Katkı ve Diğer Akademik Faaliyetler. */
$kurumsalKatki = fn (int $sayi, string $md): array => Kalip::beyan(
    'Kurumsal Katkı ve Diğer Akademik Faaliyetler tablosundan (Tablo 1) son beş yıl içinde en az '
    ."{$sayi} maddeyi belgelendirerek karşılamak — karşılayamadığınız her madde için asgari puana "
    .'3 puan ekleniyor',
    $md,
);

$esikler = [];

// ══════════════════════════════════════════════════════════════════════════
// DOKTOR ÖĞRETİM ÜYESİ — İLK VE YENİDEN ATANMA (Madde 10)
// ══════════════════════════════════════════════════════════════════════════

foreach ([
    ['dr_ogr_uyesi', 'ilk', 30, null, '10(7)'],
    ['dr_ogr_uyesi_yeniden', 'yeniden', 45, $SON_ATAMA, '10(8)'],
] as [$kadro, $ek, $toplam, $donem, $madde]) {
    $govde = fn (bool $gsf): array => Kalip::ve(
        $gsf
            ? 'Doktor Öğretim Üyesi kadrosuna atanma — Güzel Sanatlar temel alanı'
            : 'Doktor Öğretim Üyesi kadrosuna atanma',
        [
            $genelSartlar,
            $doktora,
            $kurumsalKatki(3, '10(6)'),
            Kalip::puanDan(
                'Ek-1 puanlama tablosunun 1.a, 1.b, 1.c ve 2.a maddelerinden (uluslararası '
                .'indeksli ve TR Dizin makaleleriniz) en az 15 puan',
                ['M1ABC2A'], 15, $donem, madde: $madde,
            ),
            Kalip::toplam($toplam, $donem),
        ],
    );

    $esikler[] = [
        'anahtar' => "ahi-evran-dr-{$ek}",
        'aday_notu' => ($donem === null
            ? 'Doktoranızı tamamladıktan sonraki bütün çalışmalarınız sayılıyor. '
            : 'Bir önceki atama döneminizden sonraki çalışmalarınız sayılıyor. ')
            ."Ek-1 tablosundan toplam {$toplam} puan isteniyor; bunun en az 15 puanı 1.a, 1.b, "
            .'1.c veya 2.a maddelerinden (uluslararası indeksli veya TR Dizin makalesi) gelmek '
            .'zorunda. Ayrıca Kurumsal Katkı ve Diğer Akademik Faaliyetler tablosundan 3 madde '
            .'belgelemeniz gerekiyor; belgeleyemediğiniz her madde için asgari puan 3 puan artar, '
            .'motor bu artışı uygulamıyor.',
        'universite' => $UNIVERSITE,
        'kadro' => $kadro,
        'alan' => $ALANLAR,
        'cetvel' => $CETVEL,
        'notlar' => "Madde 10: {$madde} — 1a/1b/1c/2a'dan 15 puan, toplam {$toplam} puan; "
            .'10(6) Tablo 1\'den 3 madde.',
        'sart' => $govde(false),
    ];

    $esikler[] = [
        'anahtar' => "ahi-evran-gsf-dr-{$ek}",
        'aday_notu' => ($donem === null
            ? 'Doktora ya da sanatta yeterliğinizi tamamladıktan sonraki çalışmalarınız sayılıyor. '
            : 'Bir önceki atama döneminizden sonraki çalışmalarınız sayılıyor. ')
            ."Güzel Sanatlar temel alanında Ek-1 ve Ek-2 tablolarından toplam {$toplam} puan "
            .'isteniyor; bunun en az 15 puanı Ek-1\'in 1.a, 1.b, 1.c veya 2.a maddelerinden '
            .'gelmek zorunda. Ayrıca Tablo 1\'den 3 madde belgelemeniz gerekiyor.',
        'universite' => $UNIVERSITE,
        'kadro' => $kadro,
        'alan' => ['guzel_sanatlar'],
        'cetvel' => $CETVEL_GSF,
        'notlar' => "Madde 10: {$madde} — Güzel Sanatlar temel alanında Ek-2 de sayılıyor.",
        'sart' => $govde(true),
    ];
}

// ══════════════════════════════════════════════════════════════════════════
// DOÇENT (Madde 11)
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'ahi-evran-docentlik',
    'aday_notu' => 'Doçentlik kadrosuna başvurabilmek için Ek-1 puanlama tablosundan en az 120 '
        .'puan isteniyor. Yönerge bu puan için bir dönem sınırı koymuyor, bütün akademik '
        .'geçmişiniz sayılıyor. Ayrıca Kurumsal Katkı ve Diğer Akademik Faaliyetler tablosundan '
        .'son beş yılda 5 madde belgelemeniz gerekiyor; belgeleyemediğiniz her madde için asgari '
        .'puan 3 puan artar, motor bu artışı uygulamıyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => $ALANLAR,
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 11(2): Ek-1\'den en az 120 puan; 11(4): Tablo 1\'den 5 madde.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma', [
        $genelSartlar,
        $docentUnvani,
        $kurumsalKatki(5, '11(4)'),
        Kalip::toplam(120),
    ]),
];

$esikler[] = [
    'anahtar' => 'ahi-evran-gsf-docentlik',
    'aday_notu' => 'Güzel Sanatlar temel alanında Ek-1 ve Ek-2 tablolarından toplam en az 120 '
        .'puan isteniyor; bunun en az 40 puanı Ek-1 tablosundan gelmek zorunda. Ayrıca Tablo '
        .'1\'den son beş yılda 5 madde belgelemeniz gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['guzel_sanatlar'],
    'cetvel' => $CETVEL_GSF,
    'notlar' => 'Madde 11(3): Ek-1\'den en az 40 puan, Ek-1 ve/veya Ek-2\'den toplam 120 puan.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — Güzel Sanatlar temel alanı', [
        $genelSartlar,
        $docentUnvani,
        $kurumsalKatki(5, '11(4)'),
        Kalip::puanDan('Ek-1 puanlama tablosundan en az 40 puan', ['EK1'], 40, madde: '11(3)'),
        Kalip::toplam(120),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// PROFESÖR (Madde 12)
// ══════════════════════════════════════════════════════════════════════════

/** 12(5)-iii: proje yürütücülüğü + 7. maddeden 40 puan. */
$projeSecenegi = Kalip::ve(
    'Ya da proje yürütücülüğü ile 120 puanı tamamlamak',
    [
        Kalip::veya('Yürütücülük koşulu', [
            Kalip::adet(
                'Ek-1\'in 7.a veya 7.b başlığındaki en az bir projede yürütücü olmak',
                ['P7AB-Y'], 1, donem: $DOCENTLIK, madde: '12(5)-iii',
            ),
            Kalip::adet(
                'Ya da 7.c başlığındaki en az iki projede yürütücü olmak',
                ['P7C-Y'], 2, donem: $DOCENTLIK, madde: '12(5)-iii',
            ),
        ]),
        Kalip::puanDan(
            'Bilimsel araştırma projesi başlığından (Ek-1 madde 7) en az 40 puan',
            ['B7'], 40, $DOCENTLIK, madde: '12(5)-iii',
        ),
        Kalip::toplam(120, $DOCENTLIK),
    ],
);

$uakSecenegi = Kalip::hesaplanamiyor(
    'Ya da ÜAK\'ın yürürlükteki doçentlik temel alan tablosundan en az 120 puan almak ve '
    .'yürürlükteki başvuru dönemine ait asgari doçentlik başvuru şartlarını bir kez daha '
    .'sağlamak — ÜAK tablosu bu cetvelden ayrı bir puanlama düzeni, motor hesaplayamıyor',
    '12(5)-i',
);

foreach ([
    ['p50', ['fen', 'muhendislik', 'saglik'], 'M1A', 50, 'Ek-1\'in 1.a maddesindeki (SCIE veya SSCI) dergilerde yayımlanmış makalelerden'],
    ['p40-ziraat', ['ziraat'], 'M1A', 40, 'Ek-1\'in 1.a maddesindeki (SCIE veya SSCI) dergilerde yayımlanmış makalelerden'],
    ['p40', ['egitim', 'spor'], 'M1ABC', 40, 'Ek-1\'in 1.a, 1.b ve 1.c maddelerindeki dergilerde yayımlanmış makalelerden'],
    ['p30', ['sosyal'], 'M1ABC', 30, 'Ek-1\'in 1.a, 1.b ve 1.c maddelerindeki dergilerde yayımlanmış makalelerden'],
    ['p25', ['mimarlik'], 'M1ABC', 25, 'Ek-1\'in 1.a, 1.b ve 1.c maddelerindeki dergilerde yayımlanmış makalelerden'],
    ['p20', ['filoloji', 'hukuk', 'ilahiyat'], 'M1ABC', 20, 'Ek-1\'in 1.a, 1.b ve 1.c maddelerindeki dergilerde yayımlanmış makalelerden'],
] as [$anahtar, $alanlar, $grup, $baraj, $aciklama]) {
    $esikler[] = [
        'anahtar' => "ahi-evran-{$anahtar}-profesorluk",
        'aday_notu' => 'Doçentlik unvanınızı aldığınız başvuru tarihinden sonraki faaliyetleriniz '
            .'sayılıyor. Yönerge üç seçenek sunuyor, birini sağlamanız yeterli: (i) ÜAK doçentlik '
            .'tablosundan 120 puan alıp doçentlik asgari şartlarını bir kez daha sağlamak — motor '
            .'bunu hesaplayamıyor; (ii) '.mb_strtolower(mb_substr($aciklama, 0, 1)).mb_substr($aciklama, 1)
            ." en az {$baraj} puan alıp toplam 120 puanı tamamlamak; (iii) 7.a veya 7.b'den bir, "
            .'ya da 7.c\'den iki projede yürütücü olup bilimsel araştırma projesi başlığından 40 '
            .'puan alarak toplam 120 puanı tamamlamak. Ayrıca Tablo 1\'den son beş yılda 7 madde '
            .'belgelemeniz gerekiyor.'
            .($anahtar === 'p50'
                ? ' Fen Bilimleri ve Matematik temel alanında Matematik ve İstatistik bilim '
                .'alanları için bu baraj 25 puandır; motor bilim alanını ayırt edemediği için '
                .'yüksek olan (50) uygulanıyor.'
                : ''),
        'universite' => $UNIVERSITE,
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => "Madde 12(5): üç seçenekli koşul; ii için {$grup} grubundan {$baraj} puan ve "
            .'toplam 120 puan. 12(4): Tablo 1\'den 7 madde.',
        'sart' => Kalip::ve('Profesör kadrosuna yükseltilme ve atanma', [
            $genelSartlar,
            $besYil,
            $baslicaEser,
            $kurumsalKatki(7, '12(4)'),
            Kalip::veya('Madde 12(5)\'teki üç seçenekli koşuldan biri', [
                Kalip::ve('Makale barajı ile 120 puanı tamamlamak', [
                    Kalip::puanDan("{$aciklama} en az {$baraj} puan", [$grup], $baraj, $DOCENTLIK, madde: '12(5)-ii'),
                    Kalip::toplam(120, $DOCENTLIK),
                ]),
                $projeSecenegi,
                $uakSecenegi,
            ]),
        ]),
    ];
}

$esikler[] = [
    'anahtar' => 'ahi-evran-gsf-profesorluk',
    'aday_notu' => 'Doçentlik unvanınızı aldığınız başvuru tarihinden sonraki faaliyetleriniz '
        .'sayılıyor. Güzel Sanatlar temel alanında Ek-1\'in 1.a, 1.b ve 1.c maddelerindeki '
        .'dergilerde yayımlanmış makalelerden en az 20 puan almak kaydıyla Ek-1 ve/veya Ek-2 '
        .'tablolarından toplam 120 puanı tamamlamanız isteniyor. Alternatif olarak ÜAK tablosu '
        .'(motor hesaplayamıyor) ya da proje yürütücülüğü seçeneği kullanılabilir. Ayrıca Tablo '
        .'1\'den son beş yılda 7 madde belgelemeniz gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['guzel_sanatlar'],
    'cetvel' => $CETVEL_GSF,
    'notlar' => 'Madde 12(5)-ii: Güzel Sanatlar temel alanında 1a/1b/1c\'den 20 puan, Ek-1 '
        .'ve/veya Ek-2\'den toplam 120 puan.',
    'sart' => Kalip::ve('Profesör kadrosuna yükseltilme ve atanma — Güzel Sanatlar temel alanı', [
        $genelSartlar,
        $besYil,
        $baslicaEser,
        $kurumsalKatki(7, '12(4)'),
        Kalip::veya('Madde 12(5)\'teki üç seçenekli koşuldan biri', [
            Kalip::ve('Makale barajı ile 120 puanı tamamlamak', [
                Kalip::puanDan(
                    'Ek-1\'in 1.a, 1.b ve 1.c maddelerindeki dergilerde yayımlanmış '
                    .'makalelerden en az 20 puan',
                    ['M1ABC'], 20, $DOCENTLIK, madde: '12(5)-ii',
                ),
                Kalip::toplam(120, $DOCENTLIK),
            ]),
            $projeSecenegi,
            $uakSecenegi,
        ]),
    ]),
];

return $esikler;
