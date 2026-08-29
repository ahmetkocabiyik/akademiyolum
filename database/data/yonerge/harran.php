<?php

use App\Services\Scoring\Sart\Kalip;

/**
 * HARRAN ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Yönergesi
 * Kaynak: pdf/1782307205408.harran-kriter-18052026.pdf (18.05.2026'dan
 * itibaren yürürlükte)
 *
 * Cetvel: cetvel/harran-2026.php
 *
 * ── EŞİKLERİN YAPISI ──
 * Yönerge dört alan grubu tanımlıyor: Sağlık Bilimleri, Sosyal Bilimler
 * (İlahiyat, Filoloji, Sosyal-Beşerî-İdari, Eğitim, Hukuk), Fen Bilimleri
 * (Mühendislik, Ziraat, Fen-Edebiyat) ile Güzel Sanatlar-Müzik-Mimarlık.
 * Son grup kendi içinde beş alt dala ayrılıyor (Mimarlık; Güzel Sanatlar
 * Kuramsal ve Uygulamalı; Müzik Kuramsal, Yorumculuk ve Kompozisyon).
 * Alt dallar aynı temel alana (Güzel Sanatlar) düştüğü için `birim` ile
 * ayrıldı; aday alt dalını seçmeden eşik bulunamıyor.
 *
 * ── YORUM KARARLARI (§0) ──
 *   Cetveldeki puanlar yönergenin bölüm katsayılarıyla (A ×0,7; B ×0,3;
 *       C ×0,3) çarpılmış hâlde. "A5 kapsamındaki faaliyetlerden en az 5
 *       puan", "A17-29'dan en az 40 puan" gibi bölüm içi eşiklerin ham
 *       puana mı çarpılmış puana mı ait olduğu yönergede açık değil;
 *       §0 gereği daha zor okuma seçildi ve eşikler ÇARPILMIŞ puan
 *       üzerinden aranıyor (5 çarpılmış puan ≈ 7,1 ham puan).
 *   MADDE 11/4'ün "koşulları sağlayamayan doktor öğretim üyesi, koşulların
 *       ve toplam puanın en az yarısını sağlarsa bir defaya mahsus yeniden
 *       atanabilir" istisnası ile MADDE 5/4'ün asgari koşulları sağlayamayan
 *       bölümler için Üniversite Yönetim Kurulu kararıyla dil, proje ve
 *       yayın koşullarını kaldırabilen hükmü yazılmadı; ikisi de koşulu
 *       gevşeten yollar.
 *   MADDE 10'un "ÜAK'ın ilgili doçentlik başvuru dönemine ait asgari
 *       koşullarını bir kez daha sağlamak" koşulu `hesaplanamiyor` olarak
 *       duruyor: koşullar temel alana ve başvuru dönemine göre değişiyor ve
 *       araç adayın hangi dönemin ölçütlerine tabi olduğunu bilmiyor.
 *       Profesörlük sonuçları bu yüzden "belirsiz" dönebilir.
 *   Spor Bilimleri temel alanı yönergenin dört alan grubunda geçmiyor;
 *       hangi gruba düştüğü belirsiz olduğu için bu alanda eşik yazılmadı.
 *       A11 (Sportif Başarı ve Temsil) bölümü de cetvele girilemedi.
 *   Yabancı dil eşiği 55 puan olarak yazıldı. Bilim ya da sanat alanı bir
 *       yabancı dil olan doktor öğretim üyeliği kadrolarında ve yabancı
 *       dilde eğitim yapan birimlerde bu eşik 85 puana çıkıyor; araç 55
 *       üzerinden değerlendiriyor.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 5, 6 ve 7'nin başvuru usulü, belgeleme ve komisyon hükümleri.
 *   MADDE 11/1'in "görev süresi uzatmada yabancı dil puanı ve kadro ilanı
 *       koşulları aranmaz" hükmü uygulandı: yeniden atama eşiklerinde dil
 *       koşulu yok.
 */
$SAGLIK = ['saglik'];
$SOSYAL = ['ilahiyat', 'filoloji', 'sosyal', 'egitim', 'hukuk'];
$FEN = ['muhendislik', 'ziraat', 'fen'];

$DIL_NOTU = 'Yabancı dil eşiği 55 puan; bilim veya sanat alanı bir yabancı dil olan kadrolarda '
    .'ve yabancı dilde eğitim yapan birimlerde 85 puana çıkıyor, araç 55 üzerinden '
    .'değerlendiriyor.';

$PUAN_NOTU = 'Yönerge bölüm toplamlarını çarpıyor (Akademik ×0,7; Eğitim-Öğretim ×0,3; İdari '
    .'×0,3); cetveldeki puanlar bu çarpımdan sonraki değerler, dolayısıyla eşiklerle aynı '
    .'ölçekte. Ham puanı 1 olan satırlar çarpımdan sonra sıfıra düştüğü için ders, jüri ve '
    .'kurul faaliyetleriniz toplama katkı vermiyor; eğitim-öğretim bölümünden yalnızca doktora '
    .'tez danışmanlığı sayılıyor.';

$YENIDEN_NOTU = 'Yeniden atamada yabancı dil ve kadro ilanı koşulu aranmıyor ve yalnızca bir '
    .'önceki atama tarihinden sonraki faaliyetler sayılıyor. Yönerge, koşulları sağlayamayan '
    .'adaya koşulların ve toplam puanın yarısını sağlaması hâlinde bir defaya mahsus yeniden '
    .'atanma yolu açıyor; araç bu istisnayı uygulamıyor.';

$PROF_NOTU = 'Profesörlükte tüm sayısal koşullar doçentlik unvanını aldıktan sonraki '
    .'çalışmalardan sayılıyor. Ayrıca ÜAK\'ın doçentlik başvurunuzun ait olduğu dönemdeki '
    .'asgari koşullarını (lisansüstü tezlerden yayın şartı hariç) bir kez daha sağlamanız '
    .'gerekiyor; bu koşul temel alana ve döneme göre değiştiği için araç hesaplayamıyor ve '
    .'sonucu belirsiz bırakıyor.';

/** MADDE 8'in "1 indeksli makale ya da 2 hakemli makale" kalıbı. */
$makaleKosulu = fn (string $grup, ?array $donem, string $madde): array => Kalip::veya('Makale koşulu', [
    Kalip::adet('Belirtilen indeksler kapsamındaki dergilerde en az 1 makale', [$grup], 1, donem: $donem, madde: $madde),
    Kalip::adet('Ulusal veya uluslararası hakemli dergilerde en az 2 makale', ['HAKEMLI-MAKALE'], 2, donem: $donem, madde: $madde),
]);

/** MADDE 11'in "proje ya da 20 puan" alternatifi. */
$yenidenEk = fn (bool $a4): array => Kalip::veya('Ek koşul', array_values(array_filter([
    Kalip::adet('BAP ya da üniversite dışı kurum ve kuruluşlarla yapılan en az 1 araştırma projesinde yürütücü veya araştırmacı olmak', ['A5'], 1, donem: Kalip::SON_ATAMA_SONRASI, madde: 'MADDE 11/2-a'),
    $a4 ? Kalip::toplam(5, donem: Kalip::SON_ATAMA_SONRASI, maddeler: ['A4'], liste: 'Patent') : null,
    Kalip::toplam(20, donem: Kalip::SON_ATAMA_SONRASI),
])));

$esikler = [];

/**
 * Sağlık, Sosyal ve Fen alan grupları: doçentlik ve profesörlük koşulları
 * özdeş, yalnızca doktor öğretim üyeliğinin makale koşulu ve yeniden
 * atamanın ek koşulu farklı.
 *
 * @var list<array{ad: string, anahtar: string, alan: list<string>, drGrup: string, drVe: bool, a4: bool}>
 */
$temelGruplar = [
    ['ad' => 'Sağlık Bilimleri', 'anahtar' => 'saglik', 'alan' => $SAGLIK,
        'drGrup' => 'WOS-SCOPUS-MAKALE', 'drVe' => false, 'a4' => false],
    ['ad' => 'Sosyal Bilimler', 'anahtar' => 'sosyal', 'alan' => $SOSYAL,
        'drGrup' => 'INDEKS-TR', 'drVe' => false, 'a4' => false],
    ['ad' => 'Fen Bilimleri', 'anahtar' => 'fen', 'alan' => $FEN,
        'drGrup' => 'WOS-SCOPUS-MAKALE', 'drVe' => true, 'a4' => true],
];

foreach ($temelGruplar as $g) {
    $ortak = ['universite' => 'Harran Üniversitesi', 'alan' => $g['alan'], 'cetvel' => 'harran-2026'];

    $drMakale = $g['drVe']
        ? Kalip::ve('Makale koşulu', [
            Kalip::adet('En az 1 makalenin SCI-Expanded, SSCI, AHCI ya da Scopus kapsamındaki dergilerde olması', ['WOS-SCOPUS-MAKALE'], 1, madde: 'MADDE 8/D-1'),
            Kalip::adet('Ulusal veya uluslararası hakemli dergilerde en az 2 makale', ['HAKEMLI-MAKALE'], 2, madde: 'MADDE 8/D-1'),
        ])
        : $makaleKosulu($g['drGrup'], null, 'MADDE 8');

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'harran-'.$g['anahtar'].'-dr',
        'kadro' => 'dr_ogr_uyesi',
        'notlar' => 'MADDE 8: doktora/uzmanlık/sanatta yeterlik unvanı, merkezi yabancı dil '
            .'sınavından 55 puan ve '.$g['ad'].' alanına özgü makale koşulu.',
        'aday_notu' => $g['ad'].' alanında doktor öğretim üyeliği için yönerge puan barajı '
            .'koymuyor; yalnızca makale koşulu ve yabancı dil aranıyor. '
            .($g['drVe']
                ? 'Fen Bilimlerinde en az iki makale gerekiyor ve bunlardan en az biri '
                    .'SCI-Expanded, SSCI, AHCI ya da Scopus kapsamında olmalı. '
                : 'Koşulu iki yoldan sağlayabilirsiniz: belirtilen indeksler kapsamında bir '
                    .'makale ya da ulusal veya uluslararası hakemli dergilerde iki makale. ')
            .$DIL_NOTU,
        'sart' => Kalip::ve('Doktor öğretim üyeliği koşulları', [
            Kalip::beyan('Doktora ya da tıp, eczacılık, veteriner, diş hekimliğinde uzmanlık veya sanatta yeterlik unvanını almış olmak', 'MADDE 8/A-1'),
            Kalip::yds(55),
            $drMakale,
        ]),
    ]);

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'harran-'.$g['anahtar'].'-dr-yeniden',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'notlar' => 'MADDE 11: bir önceki atama tarihinden sonra 1 indeksli ya da 2 hakemli '
            .'makale; ayrıca proje'.($g['a4'] ? ', A4\'ten 5 puan' : '').' veya 20 puan '
            .'koşullarından en az biri.',
        'aday_notu' => 'Yeniden atamada makale koşulunun yanında ikinci bir koşul daha var: '
            .'ya en az bir araştırma projesinde yürütücü veya araştırmacı olmalısınız, '
            .($g['a4'] ? 'ya patent kalemlerinizden 5 puan almalısınız, ' : '')
            .'ya da tüm faaliyetlerinizden toplam 20 puan toplamalısınız. '.$YENIDEN_NOTU,
        'sart' => Kalip::ve('Yeniden atama koşulları', [
            $makaleKosulu('WOS-SCOPUS-MAKALE', Kalip::SON_ATAMA_SONRASI, 'MADDE 11'),
            $yenidenEk($g['a4']),
        ]),
    ]);

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'harran-'.$g['anahtar'].'-docentlik',
        'kadro' => 'docentlik',
        'notlar' => 'MADDE 9: ÜAK doçent unvanı, yabancı dil 55, Ek-1\'in A5 (araştırma projesi) '
            .'bölümünden en az 5 puan ve Ek-1\'den toplam en az 120 puan.',
        'aday_notu' => 'Doçent kadrosu için iki puan koşulu var: araştırma projesi '
            .'bölümünden en az 5 puan ve tablonun tamamından 120 puan. A5 koşulu proje '
            .'puanı olmadan sağlanamıyor; BAP projesi bile bu barajı tek başına kapatabilir. '
            .$PUAN_NOTU,
        'sart' => Kalip::ve('Doçentlik koşulları', [
            Kalip::beyan('Üniversitelerarası Kuruldan doçent unvanı almış olmak', 'MADDE 9/A-1'),
            Kalip::yds(55),
            Kalip::toplam(5, maddeler: ['A5'], liste: 'Proje'),
            Kalip::toplam(120),
        ]),
    ]);

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'harran-'.$g['anahtar'].'-profesorluk',
        'kadro' => 'profesorluk',
        'notlar' => 'MADDE 10: yabancı dil 55, başlıca araştırma eseri, ÜAK asgari doçentlik '
            .'koşullarını bir kez daha sağlamak; doçentlik sonrası A5\'ten 10 puan ve toplamda '
            .'50 puan.',
        'aday_notu' => 'Profesörlükte puan barajları doçentliğe göre düşük (A5\'ten 10, toplamda '
            .'50 puan) ama yalnızca doçentlik unvanını aldıktan sonraki çalışmalar sayılıyor. '
            .$PROF_NOTU.' '.$PUAN_NOTU,
        'sart' => Kalip::ve('Profesörlük koşulları', [
            Kalip::yds(55),
            Kalip::beyan('Doçentlik başvuru tarihinden sonraki yayınlarınızdan birini başlıca araştırma eseri olarak sunmak', 'MADDE 10/A-3'),
            Kalip::hesaplanamiyor('ÜAK tarafından belirlenen ve doçentlik unvanını almaya hak kazandığınız başvuru dönemine ait temel alan asgari koşullarını (lisansüstü tezlerden yayın şartı hariç) bir kez daha sağlamış olmak', 'MADDE 10/1'),
            Kalip::toplam(10, donem: Kalip::DOCENTLIK_SONRASI, maddeler: ['A5'], liste: 'Proje'),
            Kalip::toplam(50, donem: Kalip::DOCENTLIK_SONRASI),
        ]),
    ]);
}

// ══════════ MİMARLIK ══════════
$mimarlikOrtak = ['universite' => 'Harran Üniversitesi', 'alan' => ['mimarlik'], 'cetvel' => 'harran-2026'];

$esikler[] = array_merge($mimarlikOrtak, [
    'anahtar' => 'harran-mimarlik-dr',
    'kadro' => 'dr_ogr_uyesi',
    'notlar' => 'MADDE 8/E-1: indeksli ya da TR Dizin dergilerde BİRİNCİ İSİM olarak 1 makale ya '
        .'da ulusal veya uluslararası hakemli dergilerde 2 makale.',
    'aday_notu' => 'Mimarlık alanında tek makaleyle başvuracaksanız o makalede BİRİNCİ İSİM '
        .'olmanız gerekiyor; ikinci yolda (iki hakemli makale) böyle bir şart yok. '.$DIL_NOTU,
    'sart' => Kalip::ve('Doktor öğretim üyeliği koşulları', [
        Kalip::beyan('Doktora ya da sanatta yeterlik unvanını almış olmak', 'MADDE 8/A-1'),
        Kalip::yds(55),
        Kalip::veya('Makale koşulu', [
            Kalip::adet('İndeksli ya da TR Dizin dergilerde birinci isim olarak en az 1 makale', ['INDEKS-TR'], 1, yazar: 'ilk', madde: 'MADDE 8/E-1'),
            Kalip::adet('İndeksli ya da TR Dizin dergilerde tek yazarlı en az 1 makale', ['INDEKS-TR'], 1, yazar: 'tek', madde: 'MADDE 8/E-1'),
            Kalip::adet('Ulusal veya uluslararası hakemli dergilerde en az 2 makale', ['HAKEMLI-MAKALE'], 2, madde: 'MADDE 8/E-1'),
        ]),
    ]),
]);

$esikler[] = array_merge($mimarlikOrtak, [
    'anahtar' => 'harran-mimarlik-dr-yeniden',
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'notlar' => 'MADDE 11/E-1: bir önceki atama tarihinden sonra 1 indeksli ya da 2 hakemli '
        .'makale; ayrıca proje veya 20 puan.',
    'aday_notu' => 'Yeniden atamada birinci isim şartı aranmıyor. '.$YENIDEN_NOTU,
    'sart' => Kalip::ve('Yeniden atama koşulları', [
        $makaleKosulu('INDEKS-TR', Kalip::SON_ATAMA_SONRASI, 'MADDE 11/E-1'),
        $yenidenEk(false),
    ]),
]);

$esikler[] = array_merge($mimarlikOrtak, [
    'anahtar' => 'harran-mimarlik-docentlik',
    'kadro' => 'docentlik',
    'notlar' => 'MADDE 9/E: A5\'ten en az 5 puan ve Ek-1\'den toplam 120 puan.',
    'aday_notu' => 'Mimarlık alanında doçentlik koşulları fen, sağlık ve sosyal alanlarla aynı: '
        .'A5 (araştırma projesi) bölümünden 5 puan ve tablonun tamamından 120 puan. '.$PUAN_NOTU,
    'sart' => Kalip::ve('Doçentlik koşulları', [
        Kalip::beyan('Üniversitelerarası Kuruldan doçent unvanı almış olmak', 'MADDE 9/A-1'),
        Kalip::yds(55),
        Kalip::toplam(5, maddeler: ['A5'], liste: 'Proje'),
        Kalip::toplam(120),
    ]),
]);

$esikler[] = array_merge($mimarlikOrtak, [
    'anahtar' => 'harran-mimarlik-profesorluk',
    'kadro' => 'profesorluk',
    'notlar' => 'MADDE 10/E: doçentlik sonrası A5\'ten 10 puan ve toplamda 50 puan.',
    'aday_notu' => 'Mimarlık alanında profesörlük koşulları diğer temel alanlarla aynı. '
        .$PROF_NOTU.' '.$PUAN_NOTU,
    'sart' => Kalip::ve('Profesörlük koşulları', [
        Kalip::yds(55),
        Kalip::beyan('Doçentlik başvuru tarihinden sonraki yayınlarınızdan birini başlıca araştırma eseri olarak sunmak', 'MADDE 10/A-3'),
        Kalip::hesaplanamiyor('ÜAK tarafından belirlenen ve doçentlik unvanını almaya hak kazandığınız başvuru dönemine ait temel alan asgari koşullarını (lisansüstü tezlerden yayın şartı hariç) bir kez daha sağlamış olmak', 'MADDE 10/1'),
        Kalip::toplam(10, donem: Kalip::DOCENTLIK_SONRASI, maddeler: ['A5'], liste: 'Proje'),
        Kalip::toplam(50, donem: Kalip::DOCENTLIK_SONRASI),
    ]),
]);

/**
 * Güzel Sanatlar ve Müzik alt dalları. Kuramsal dallarda makale, uygulamalı
 * dallarda Ek-1'in ilgili bölümünden puan aranıyor.
 *
 * @var list<array{ad: string, anahtar: string, birim: string, grup: ?string, dr: int, doc: int, prof: int, yeniden: int}>
 */
$sanatDallari = [
    ['ad' => 'Güzel Sanatlar — Kuramsal Alanlar', 'anahtar' => 'gs-kuramsal',
        'birim' => 'Güzel Sanatlar — Kuramsal Alanlar', 'grup' => null,
        'dr' => 0, 'doc' => 0, 'prof' => 0, 'yeniden' => 0],
    ['ad' => 'Güzel Sanatlar — Uygulamalı Alanlar', 'anahtar' => 'gs-uygulamali',
        'birim' => 'Güzel Sanatlar — Uygulamalı Alanlar', 'grup' => 'A17-29',
        'dr' => 40, 'doc' => 20, 'prof' => 60, 'yeniden' => 20],
    ['ad' => 'Müzik — Kuramsal Alanlar', 'anahtar' => 'muzik-kuramsal',
        'birim' => 'Müzik — Kuramsal Alanlar', 'grup' => null,
        'dr' => 0, 'doc' => 0, 'prof' => 0, 'yeniden' => 0],
    ['ad' => 'Müzik — Yorumculuk Alanı', 'anahtar' => 'muzik-yorumculuk',
        'birim' => 'Müzik — Yorumculuk Alanı', 'grup' => 'A33-35',
        'dr' => 40, 'doc' => 20, 'prof' => 40, 'yeniden' => 20],
    ['ad' => 'Müzik — Kompozisyon Alanı', 'anahtar' => 'muzik-kompozisyon',
        'birim' => 'Müzik — Kompozisyon Alanı', 'grup' => 'A37',
        'dr' => 40, 'doc' => 20, 'prof' => 40, 'yeniden' => 20],
];

$SANAT_PUAN_NOTU = 'Bu alt dalın eşikleri belirli bir sanatsal faaliyet kümesinden alınan puana bağlı. '
    .'Bölümdeki satırların bir kısmı (kişisel sergilerde "en az 15 özgün eser" koşulu taşıyan '
    .'satırlar, Türk müziği kompozisyon ve yorumculuk bölümleri, klasik bale, çağdaş dans, halk '
    .'dansları, televizyon programları ve festival çalışmaları) faaliyet kaydında karşılığı '
    .'olmadığı için girilemedi; bölüm puanınız olduğundan düşük çıkabilir.';

foreach ($sanatDallari as $d) {
    $ortak = ['universite' => 'Harran Üniversitesi', 'alan' => ['guzel_sanatlar'],
        'birim' => $d['birim'], 'cetvel' => 'harran-2026'];
    $kuramsal = $d['grup'] === null;
    $grup = $d['grup'] ?? 'HAKEMLI-MAKALE';
    // Adaya gösterilen küme adı (KONVANSIYONLAR §2); kod `madde`de kalıyor.
    $grupAdi = match ($grup) {
        'A17-29' => 'Sergi, bienal, gösteri ve performans',
        'A33-35' => 'Dinleti, konser ve icra',
        'A37' => 'Beste',
        default => 'Hakemli dergilerdeki makale',
    };

    // ── Doktor öğretim üyeliği ──
    $drSart = $kuramsal
        ? [
            Kalip::beyan('Doktora ya da sanatta yeterlik unvanını almış olmak', 'MADDE 8/A-1'),
            Kalip::yds(55),
            Kalip::adet(
                $d['anahtar'] === 'gs-kuramsal'
                    ? 'Ulusal veya uluslararası hakemli dergilerde en az 1 makale, bilimsel kitap ya da kitap bölümü'
                    : 'Ulusal veya uluslararası hakemli dergilerde en az 1 makale',
                [$d['anahtar'] === 'gs-kuramsal' ? 'KURAMSAL-ESER' : 'HAKEMLI-MAKALE'],
                1,
                madde: 'MADDE 8/E'
            ),
        ]
        : [
            Kalip::beyan('Doktora ya da sanatta yeterlik unvanını almış olmak', 'MADDE 8/A-1'),
            Kalip::yds(55),
            Kalip::toplam($d['dr'], maddeler: [$grup], liste: $grupAdi),
            Kalip::toplam(60),
        ];

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'harran-'.$d['anahtar'].'-dr',
        'kadro' => 'dr_ogr_uyesi',
        'notlar' => 'MADDE 8/E: '.$d['ad'].' için '
            .($kuramsal ? 'en az 1 makale ya da kitap.' : 'Ek-1\'in '.$grup.' bölümünden '.$d['dr'].' puan ve genel toplamda 60 puan.'),
        'aday_notu' => $d['ad'].' alt dalında doktor öğretim üyeliği için '
            .($kuramsal
                ? 'yalnızca bir makale (Güzel Sanatlar kuramsal dallarda bilimsel kitap ya da kitap bölümü de olur) yeterli; puan barajı yok. '
                : 'iki baraj birden aranıyor: ilgili sanat bölümünden '.$d['dr'].' puan ve tablonun tamamından 60 puan. '.$SANAT_PUAN_NOTU.' ')
            .$DIL_NOTU.' '.$PUAN_NOTU,
        'sart' => Kalip::ve('Doktor öğretim üyeliği koşulları', $drSart),
    ]);

    // ── Yeniden atama ──
    $esikler[] = array_merge($ortak, [
        'anahtar' => 'harran-'.$d['anahtar'].'-dr-yeniden',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'notlar' => 'MADDE 11/E: '
            .($kuramsal ? 'bir önceki atamadan sonra 1 makale ya da Ek-1\'den 20 puan.' : 'Ek-1\'in '.$grup.' bölümünden '.$d['yeniden'].' puan.'),
        'aday_notu' => $kuramsal
            ? 'Yeniden atamada iki yol var: bir önceki atama tarihinden sonra en az bir makale ya '
                .'da tüm faaliyetlerinizden toplam 20 puan. '.$YENIDEN_NOTU
            : 'Yeniden atamada tek koşul, ilgili sanat bölümünden '.$d['yeniden'].' puan. '
                .$SANAT_PUAN_NOTU.' '.$YENIDEN_NOTU,
        'sart' => $kuramsal
            ? Kalip::veya('Yeniden atama koşulları', [
                Kalip::adet('Ulusal veya uluslararası dergilerde en az 1 makale', ['HAKEMLI-MAKALE'], 1, donem: Kalip::SON_ATAMA_SONRASI, madde: 'MADDE 11/E'),
                Kalip::toplam(20, donem: Kalip::SON_ATAMA_SONRASI),
            ])
            : Kalip::toplam($d['yeniden'], donem: Kalip::SON_ATAMA_SONRASI, maddeler: [$grup], liste: $grupAdi),
    ]);

    // ── Doçentlik ──
    $docSart = [
        Kalip::beyan('Üniversitelerarası Kuruldan doçent unvanı almış olmak', 'MADDE 9/A-1'),
        Kalip::yds(55),
        $kuramsal
            ? Kalip::adet('Ulusal veya uluslararası hakemli dergilerde en az 1 makale', ['HAKEMLI-MAKALE'], 1, madde: 'MADDE 9/E-1-a')
            : Kalip::toplam($d['doc'], maddeler: [$grup], liste: $grupAdi),
        Kalip::toplam(120),
    ];

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'harran-'.$d['anahtar'].'-docentlik',
        'kadro' => 'docentlik',
        'notlar' => 'MADDE 9/E: '
            .($kuramsal ? 'en az 1 makale' : 'Ek-1\'in '.$grup.' bölümünden '.$d['doc'].' puan')
            .' ve Ek-1\'den toplam 120 puan.',
        'aday_notu' => $d['ad'].' alt dalında doçentlik için '
            .($kuramsal ? 'en az bir makale' : 'ilgili sanat bölümünden '.$d['doc'].' puan')
            .' ve tablonun tamamından 120 puan gerekiyor. '
            .($kuramsal ? '' : $SANAT_PUAN_NOTU.' ').$PUAN_NOTU,
        'sart' => Kalip::ve('Doçentlik koşulları', $docSart),
    ]);

    // ── Profesörlük ──
    $profSart = [
        Kalip::yds(55),
        Kalip::beyan('Doçentlik başvuru tarihinden sonraki yayınlarınızdan birini başlıca araştırma eseri olarak sunmak', 'MADDE 10/A-3'),
        Kalip::hesaplanamiyor('ÜAK tarafından belirlenen ve doçentlik unvanını almaya hak kazandığınız başvuru dönemine ait temel alan asgari koşullarını (lisansüstü tezlerden yayın şartı hariç) bir kez daha sağlamış olmak', 'MADDE 10/1'),
        $kuramsal
            ? Kalip::adet('Ulusal veya uluslararası hakemli dergilerde en az 1 makale', ['HAKEMLI-MAKALE'], 1, donem: Kalip::DOCENTLIK_SONRASI, madde: 'MADDE 10/E-2-a')
            : Kalip::toplam($d['prof'], donem: Kalip::DOCENTLIK_SONRASI, maddeler: [$grup], liste: $grupAdi),
        Kalip::toplam(50, donem: Kalip::DOCENTLIK_SONRASI),
    ];

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'harran-'.$d['anahtar'].'-profesorluk',
        'kadro' => 'profesorluk',
        'notlar' => 'MADDE 10/E: doçentlik sonrası '
            .($kuramsal ? 'en az 1 makale' : 'Ek-1\'in '.$grup.' bölümünden '.$d['prof'].' puan')
            .' ve genel toplamda 50 puan.',
        'aday_notu' => $d['ad'].' alt dalında profesörlük için doçentlik sonrası '
            .($kuramsal ? 'en az bir makale' : 'ilgili sanat bölümünden '.$d['prof'].' puan')
            .' ve tablonun tamamından 50 puan gerekiyor. '
            .($kuramsal ? '' : $SANAT_PUAN_NOTU.' ').$PROF_NOTU,
        'sart' => Kalip::ve('Profesörlük koşulları', $profSart),
    ]);
}

return $esikler;
