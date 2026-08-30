<?php

/**
 * TÜRK-ALMAN ÜNİVERSİTESİ — Öğretim Üyeliği Kadrolarına Atanma ve
 * Yükseltilme Kriterleri Yönergesi
 * Kaynak: pdf/17537009962.turk-almannuniverstesi.pdf (10 sayfa; Senato
 * 24/06/2020-2020/59, değişiklikler 08/09/2021, 15/12/2021, 06/07/2022,
 * 22.11.2023 ve 20/08/2024; MADDE 24 uyarınca YÖK onayını takiben
 * 01.01.2021'de yürürlüğe girdi.)
 *
 * ── İKİ FAKÜLTE GRUBU ──
 * Yönerge koşulları iki gruba ayırıyor:
 *   Sosyal Bilimler: Hukuk, İktisadi ve İdari Bilimler ile Kültür ve
 *       Sosyal Bilimler fakülteleri ve Sosyal Bilimler Enstitüsü
 *       → hukuk, sosyal ve filoloji temel alanları,
 *   Fen ve Mühendislik: Fen ve Mühendislik fakülteleri ile Fen
 *       Bilimleri Enstitüsü → fen ve mühendislik temel alanları.
 * Üniversitenin başka temel alanda birimi olmadığı ve yönerge başka
 * grup tanımlamadığı için diğer temel alanlarda eşik yazılmadı.
 *
 * ── PUAN YALNIZ YENİDEN ATANMADA ──
 * İlk atanma (MADDE 10), doçentlik (MADDE 14) ve profesörlük (MADDE 18)
 * koşulları SAYI ve BELGE şartı. Puan yalnız doktor öğretim üyeliğine
 * yeniden atanmada (MADDE 11) kullanılıyor ve EK-1'in faaliyet
 * türlerine verilen ağırlıklardan hesaplanıyor.
 *
 * ── YABANCI DİL ──
 * MADDE 7(1): adayların Yükseköğretim Kurumlarında Yabancı Dil Öğretimi
 * ve Yabancı Dille Öğretim Yapılmasında Uygulanacak Esaslara İlişkin
 * Yönetmelikteki ders verme kriterlerini (85 puan) sağlaması gerekiyor.
 * MADDE 7(2) yalnızca yabancı dilde okutulmayacak dersler için ve
 * programın asgari öğretim üyesi sayısının ÜSTÜNDEKİ kadrolarda 70
 * puana izin veriyor. §0 uyarınca genel kural olan 85 uygulandı; 70
 * istisnası ve MADDE 7(3)'ün Almanca/İngilizce ülkede öğrenim muafiyeti
 * aday notunda.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 7(3): lisans ya da doktora öğrenimini Almancanın veya
 *       İngilizcenin resmî dil olduğu bir ülkede o dilde tamamlayanlardan
 *       dil belgesi istenmemesi.
 *   MADDE 11'in "dört yıldan kısa atanma dönemlerinde oran kurulması".
 *   MADDE 24'ün geçiş hükmü: yönergenin yürürlüğe girdiği tarihte
 *       yeniden atanmasına üç yıldan kısa süre kalanlara ilk yeniden
 *       atanmada eski yönerge koşullarının uygulanması.
 *   MADDE 18(3) ve (6): yurt dışında alınan doçentlik ve profesörlük
 *       unvanlarının ÜAK kararıyla Türkiye'de geçerli sayılması.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/tau-2021.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Türk-Alman Üniversitesi';
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_UC_YIL = Kalip::sonYil(3);

$SOSYAL = ['hukuk', 'sosyal', 'filoloji'];
$FEN = ['fen', 'muhendislik'];

$SOSYAL_AD = 'Hukuk, İktisadi ve İdari Bilimler ile Kültür ve Sosyal Bilimler fakülteleri';
$FEN_AD = 'Fen ve Mühendislik fakülteleri';

$NOT_DIL = ' Yabancı dil koşulu, Yükseköğretim Kurumlarında Yabancı Dil Öğretimi Yönetmeliğinin '
    .'ders verme kriteri olan 85 puandan uygulanıyor. Yabancı dilde okutulmayacak dersler için '
    .'ve programın asgari öğretim üyesi sayısının üstündeki kadrolarda 70 puan yeterli oluyor; '
    .'ayrıca lisans ya da doktora öğreniminizin tamamını Almancanın veya İngilizcenin resmî dil '
    .'olduğu bir ülkede o dilde tamamladıysanız dil belgesi istenmiyor.';
$NOT_SUNUM = ' İlk kez başvuranlardan eğiticinin eğitilmesi sertifikası ya da kurul huzurunda '
    .'başarılı bulunan bir ders sunumu isteniyor; Türkçe dışında okutulmayacak dersler için '
    .'ayrıca Almanca deneme dersi sunumu gerekebiliyor.';
$NOT_POSTER = ' Özet olarak yayımlanan bildirileriniz sayılmıyor: EK-1\'in E türü posteri hariç '
    .'tutuyor, kaynak sözlüğü ise sözlü özet bildiriyi posterden ayırmıyor.';

$dil = Kalip::yds(85);
$doktora = Kalip::beyan(
    'Doktora eğitimini tamamlamış ve doktor unvanını almış olmak; yurt dışından alınan doktora '
    .'derecelerinin Türkiye\'de denkliğini almış olmak',
    '10-a',
);
$tezYayini = Kalip::adet(
    'Doktora tezinizi yayımlamış olmak ya da doktora tezinizden üretilmiş en az bir yayınınızın '
    .'bulunması (bu çalışmayı "tez yayını" olarak kaydedin)',
    ['TEZ-YAYINI'], 1, madde: '10-b',
);
$sertifika = Kalip::beyan(
    'Eğiticinin eğitilmesi sertifika programlarından birini başarıyla tamamlamış olmak ya da '
    .'oluşturulacak kurul huzurunda çalışmalarınız ve yürüteceğiniz derslerle ilgili başarılı '
    .'bulunan bir sunum yapmış olmak',
    '6',
);

$esikler = [];

// ══════════════════════════════════════════════════════════════════════════
// DOKTOR ÖĞRETİM ÜYESİ — İLK ATANMA (MADDE 10)
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'tau-sosyal-dr',
    'aday_notu' => "{$SOSYAL_AD} bünyesindeki doktor öğretim üyesi kadrolarına İLK ATANMA "
        .'koşulları. İlk atama doğrudan üç yıl süreyle yapılıyor.'.$NOT_DIL.$NOT_SUNUM.$NOT_POSTER,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => $SOSYAL,
    'cetvel' => 'tau-2021-sosyal',
    'notlar' => 'MADDE 10(c): A, B, C, D veya F türünden en az üç faaliyet; en az biri doktora '
        .'sonrası, en az biri A, B veya C türünden.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna ilk atanma — Sosyal Bilimler', [
        $doktora,
        $dil,
        $sertifika,
        $tezYayini,
        Kalip::adet(
            'Makale, kitap ya da kitap bölümü türünde yayımlanmış veya yayına kabul edilmiş en '
            .'az 3 bilimsel çalışmanızın bulunması',
            ['ABCDF'], 3, madde: '10-c',
        ),
        Kalip::adet(
            'Bu çalışmalardan en az birinin SCI, SCI-Expanded, SSCI, AHCI, uluslararası alan '
            .'indeksi ya da TR Dizin kapsamındaki bir dergide yayımlanmış makale olması',
            ['ABC'], 1, madde: '10-c',
        ),
        Kalip::adet(
            'Bu çalışmalardan en az birinin doktora unvanınızı aldıktan sonra yapılmış olması',
            ['ABCDF'], 1, donem: $DOKTORA, madde: '10-c',
        ),
    ]),
];

$esikler[] = [
    'anahtar' => 'tau-fen-dr',
    'aday_notu' => "{$FEN_AD} bünyesindeki doktor öğretim üyesi kadrolarına İLK ATANMA "
        .'koşulları. İlk atama doğrudan üç yıl süreyle yapılıyor.'.$NOT_DIL.$NOT_SUNUM.$NOT_POSTER,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => $FEN,
    'cetvel' => 'tau-2021-fen',
    'notlar' => 'MADDE 10(d): A, B, C veya D türünden en az iki faaliyet; en az biri son üç '
        .'yılda, en az biri A türünden.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna ilk atanma — Fen ve Mühendislik', [
        $doktora,
        $dil,
        $sertifika,
        $tezYayini,
        Kalip::adet(
            'Hakemli dergilerde yayımlanmış veya yayına kabul edildiği belgelenmiş en az 2 '
            .'makalenizin bulunması',
            ['ABCD'], 2, madde: '10-d',
        ),
        Kalip::adet(
            'Bu makalelerden en az birinin SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki bir '
            .'dergide yayımlanmış olması',
            ['A'], 1, madde: '10-d',
        ),
        Kalip::adet(
            'Bu makalelerden en az birinin son üç yıl içinde yayımlanmış ya da yayına kabul '
            .'edilmiş olması',
            ['ABCD'], 1, donem: $SON_UC_YIL, madde: '10-d',
        ),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// DOKTOR ÖĞRETİM ÜYESİ — YENİDEN ATANMA (MADDE 11)
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'tau-sosyal-dr-yeniden',
    'aday_notu' => "{$SOSYAL_AD} bünyesindeki doktor öğretim üyesi kadrolarına YENİDEN ATANMA "
        .'koşulları. Bir atanma dönemi kural olarak dört yıldır; daha kısa dönemlerde koşullar '
        .'oranlanır. Puanlar faaliyet türlerinin ağırlıklarından geliyor: makale (SCI, '
        .'SSCI, AHCI), kitap, proje ve patent 3\'er puan; uluslararası indeksli ve TR Dizin '
        .'makaleleri 2\'şer puan; diğer ulusal makale ve bildiri 1\'er puan.'.$NOT_POSTER,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => $SOSYAL,
    'cetvel' => 'tau-2021-sosyal',
    'notlar' => 'MADDE 11(a): en az biri A, F, G veya H türünden olmak üzere 5 puan; ya da en az '
        .'ikisi B veya C türünden olmak üzere 7 puan. Ağırlıklar A, F, G, H = 3; B, C = 2; '
        .'D, E = 1.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna yeniden atanma — Sosyal Bilimler', [
        Kalip::veya('Yeniden atanma koşullarından biri', [
            Kalip::ve('Beş puanlık seçenek', [
                Kalip::adet(
                    'Son atanma döneminizde SCI, SCI-Expanded, SSCI ya da AHCI kapsamında en az '
                    .'bir makale, kitap, proje veya patent üretmiş olmak',
                    ['AFGH'], 1, donem: $SON_ATAMA, madde: '11-a',
                ),
                Kalip::toplam(5, $SON_ATAMA),
            ]),
            Kalip::ve('Yedi puanlık seçenek', [
                Kalip::adet(
                    'Son atanma döneminizde uluslararası indeksli ya da TR Dizin kapsamındaki '
                    .'dergilerde en az 2 makale yayımlamış olmak',
                    ['BC'], 2, donem: $SON_ATAMA, madde: '11-a',
                ),
                Kalip::toplam(7, $SON_ATAMA),
            ]),
        ]),
    ]),
];

$esikler[] = [
    'anahtar' => 'tau-fen-dr-yeniden',
    'aday_notu' => "{$FEN_AD} bünyesindeki doktor öğretim üyesi kadrolarına YENİDEN ATANMA "
        .'koşulları. Bir atanma dönemi kural olarak dört yıldır; daha kısa dönemlerde koşullar '
        .'oranlanır. Puanlar faaliyet türlerinin ağırlıklarından geliyor: makale (SCI, '
        .'SSCI, AHCI), proje ve patent 3\'er puan; uluslararası indeksli makale, TR Dizin '
        .'makalesi ve kitap 2\'şer puan; diğer ulusal makale ve bildiri 1\'er puan.'.$NOT_POSTER,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => $FEN,
    'cetvel' => 'tau-2021-fen',
    'notlar' => 'MADDE 11(b): en az biri A türünden olmak üzere 5 puan; ya da en az ikisi B, C '
        .'veya F türünden olmak üzere 7 puan. Ağırlıklar A, G, H = 3; B, C, F = 2; D, E = 1.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna yeniden atanma — Fen ve Mühendislik', [
        Kalip::veya('Yeniden atanma koşullarından biri', [
            Kalip::ve('Beş puanlık seçenek', [
                Kalip::adet(
                    'Son atanma döneminizde SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki bir '
                    .'dergide en az bir makale yayımlamış olmak',
                    ['A'], 1, donem: $SON_ATAMA, madde: '11-b',
                ),
                Kalip::toplam(5, $SON_ATAMA),
            ]),
            Kalip::ve('Yedi puanlık seçenek', [
                Kalip::adet(
                    'Son atanma döneminizde uluslararası indeksli ya da TR Dizin kapsamındaki '
                    .'dergilerde makale veya kitap türünden en az 2 çalışma üretmiş olmak',
                    ['BCF'], 2, donem: $SON_ATAMA, madde: '11-b',
                ),
                Kalip::toplam(7, $SON_ATAMA),
            ]),
        ]),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// DOÇENT (MADDE 14)
// ══════════════════════════════════════════════════════════════════════════

$docentOrtak = [
    Kalip::beyan(
        'Üniversitelerarası Kurul kararıyla doçentlik unvanını almış olmak ya da yurt dışında '
        .'alınan doçentlik unvanının Türkiye\'de geçerli sayılmış olması',
        '14',
    ),
    Kalip::beyan('Doçentlik sözlü sınavında başarılı olmak', '14-a'),
    Kalip::yds(85),
];

$esikler[] = [
    'anahtar' => 'tau-sosyal-docentlik',
    'aday_notu' => "{$SOSYAL_AD} bünyesindeki doçent kadrolarına atanma koşulları. Başvuru "
        .'anındaki güncel ÜAK doçentlik asgari kriterlerini sağlamanız ve orada öngörülen asgari '
        .'puandan 20 fazla puan almanız gerekiyor; bu koşul ÜAK\'ın kendi puanlama sistemine '
        .'bağlı olduğu için motor hesaplayamıyor.'.$NOT_DIL,
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => $SOSYAL,
    'cetvel' => 'tau-2021-sosyal',
    'notlar' => 'MADDE 14(c): güncel ÜAK doçentlik kriterleri + asgari puandan 20 fazla puan '
        .'(hesaplanamıyor).',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — Sosyal Bilimler', [
        ...$docentOrtak,
        Kalip::hesaplanamiyor(
            'Kadroya başvuru anındaki güncel ÜAK doçentlik asgari kriterlerini karşılamak ve '
            .'orada öngörülen asgari puandan 20 fazla puan almış olmak',
            '14-c',
        ),
    ]),
];

$esikler[] = [
    'anahtar' => 'tau-fen-docentlik',
    'aday_notu' => "{$FEN_AD} bünyesindeki doçent kadrolarına atanma koşulları. İki seçenekten "
        .'birini sağlamanız yeterli: güncel ÜAK doçentlik asgari kriterlerini yerine getirmiş '
        .'olmak (motor bunu hesaplayamıyor) ya da doçentlik başvurunuzdan sonra, en az biri son '
        .'üç yılda yayımlanmış olmak üzere SCI/SCI-Expanded kapsamındaki dergilerde 3 veya daha '
        .'fazla yayın yapmış olmak.'.$NOT_DIL,
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => $FEN,
    'cetvel' => 'tau-2021-fen',
    'notlar' => 'MADDE 14(b): (aa) güncel ÜAK doçentlik kriterleri (hesaplanamıyor) VEYA (bb) '
        .'doçentlik başvurusundan sonra SCI/SCI-E\'de 3 yayın, en az 1\'i son 3 yılda. Kaynak '
        .'sözlüğü SCI ile SSCI\'yi ayırmadığı için A-SCI kümesi SSCI\'yi de kapsıyor.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — Fen ve Mühendislik', [
        ...$docentOrtak,
        Kalip::veya('Doçentlik ek koşullarından biri', [
            Kalip::hesaplanamiyor(
                'Üniversitelerarası Kurulun görüşü üzerine Yükseköğretim Kurulu tarafından '
                .'belirlenen güncel doçentlik asgari kriterlerini yerine getirmiş olmak',
                '14-b-aa',
            ),
            Kalip::ve('Yayın seçeneği', [
                Kalip::adet(
                    'Doçentlik başvurunuzdan sonra SCI, SCI-Expanded ya da SSCI kapsamındaki '
                    .'dergilerde en az 3 yayın yapmış olmak',
                    ['A-SCI'], 3, donem: $DOCENTLIK, madde: '14-b-bb',
                ),
                Kalip::adet(
                    'Bu yayınlardan en az birinin son üç yılda yayımlanmış olması',
                    ['A-SCI'], 1, donem: $SON_UC_YIL, madde: '14-b-bb',
                ),
            ]),
        ]),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// PROFESÖR (MADDE 18-19)
// ══════════════════════════════════════════════════════════════════════════

/**
 * @param  list<string>  $alanlar
 * @return array<string, mixed>
 */
$profesorluk = function (string $anahtar, array $alanlar, string $alanAdi, string $cetvel) use ($UNIVERSITE, $NOT_DIL): array {
    return [
        'anahtar' => "tau-{$anahtar}-profesorluk",
        'aday_notu' => "{$alanAdi} bünyesindeki profesör kadrolarına atanma koşulları. Doçentlik "
            .'unvanını aldıktan sonra en az beş yıl ilgili bilim alanında çalışmış, ders vermiş '
            .'ve uluslararası düzeyde orijinal eserler vermiş olmanız gerekiyor. Ayrıca başvuru '
            .'tarihi itibarıyla yürürlükteki ÜAK doçentlik başvuru şartlarını doçentlik sonrası '
            .'çalışmalarınızla bir kez daha yerine getirmiş olmalısınız (lisansüstü tezlerden '
            .'üretilmiş yayınlar sayılmaz); bu koşul ÜAK\'ın kendi cetveline bağlı olduğu için '
            .'motor hesaplayamıyor. Başvurunuzda yayınlarınızdan birini başlıca araştırma eseri '
            .'olarak göstermeniz gerekiyor.'.$NOT_DIL,
        'universite' => $UNIVERSITE,
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'cetvel' => $cetvel,
        'notlar' => 'MADDE 18 ve 19: 5 yıl çalışma, ders verme ve orijinal eser beyanı; '
            .'doçentlik sözlü sınavı; dil yeterliliği; ÜAK doçentlik şartlarının doçentlik '
            .'sonrası bir kez daha sağlanması (hesaplanamıyor); başlıca araştırma eseri.',
        'sart' => Kalip::ve("Profesör kadrosuna atanma — {$alanAdi}", [
            Kalip::beyan(
                'Doçentlik unvanını aldıktan sonra en az beş yıl açık bulunan profesörlük '
                .'kadrosuyla ilgili bilim alanında çalışmış, kısmi ya da tam zamanlı ders vermiş '
                .'ve kendi bilim alanında uluslararası düzeyde orijinal eserler vermiş olmak',
                '18-1',
            ),
            Kalip::beyan('Doçentlik sözlü sınavında başarılı olmak', '18-2'),
            Kalip::yds(85),
            Kalip::hesaplanamiyor(
                'Başvuru tarihi itibarıyla yürürlükteki ÜAK doçentlik başvuru şartlarını, '
                .'doçentlik sonrası yapılan çalışmalarla (lisansüstü tezlerden üretilmiş yayınlar '
                .'hariç) bir kez daha yerine getirmiş olmak',
                '18-5',
            ),
            Kalip::beyan(
                'Yayınlarınızdan birini, profesör kadrosuna yönelik özel olarak hazırlanmış '
                .'başlıca araştırma eseri olarak göstermek',
                '19',
            ),
        ]),
    ];
};

$esikler[] = $profesorluk('sosyal', $SOSYAL, $SOSYAL_AD, 'tau-2021-sosyal');
$esikler[] = $profesorluk('fen', $FEN, $FEN_AD, 'tau-2021-fen');

return $esikler;
