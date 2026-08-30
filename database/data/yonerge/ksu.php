<?php

/**
 * KAHRAMANMARAŞ SÜTÇÜ İMAM ÜNİVERSİTESİ — Öğretim Üyeliğine Atama,
 * Yükseltme Ölçütleri ve Uygulama Esasları
 * Kaynak: pdf/17536998942.kahramanmarassutcuimamuniverstesi.pdf (10 sayfa;
 * Senato 25.01.2023-2023/02-19, YÖK onayı 19.04.2023-28877)
 *
 * ── YAPI: FAKÜLTE KÜMELERİNE GÖRE İKİ (DOÇENTLİKTE ÜÇ) VARYANT ──
 * Madde 4 doktor öğretim üyeliğini iki kümeye ayırıyor: Güzel Sanatlar
 * Fakültesi ile Mimarlık Bölümü Tablo 1 + Tablo 2 + Tablo 3'ten, kalan
 * bütün fakülteler Tablo 1 + Tablo 3'ten 30 puan topluyor. Madde 5
 * doçentliği dört kümeye ayırıyor ama kümeler arasındaki tek fark ders
 * verme şartı ve kullanılan tablo kümesi; yayın (6 adet, üçü başlıca) ve
 * puan (150) barajları hepsinde aynı. Madde 6 profesörlükte tek kural
 * veriyor, yalnızca güzel sanatlar alanına ayrı bir dal açıyor.
 *
 * Fakülte → temel alan eşlemesi:
 *   Tıp, Diş Hekimliği, Sağlık Bilimleri          → saglik
 *   Spor Bilimleri                                → spor
 *   Orman, Ziraat                                 → ziraat
 *   Fen                                           → fen
 *   Mühendislik ve Mimarlık (Mimarlık dışı)       → muhendislik
 *   Eğitim                                        → egitim
 *   İktisadi ve İdari Bilimler                    → sosyal
 *   İnsan ve Toplum Bilimleri                     → sosyal, filoloji
 *   İlahiyat                                      → ilahiyat
 *   Güzel Sanatlar                                → guzel_sanatlar
 *   Mühendislik ve Mimarlık Fak. Mimarlık Bölümü  → mimarlik
 * Yönerge hukuk temel alanını anmıyor (üniversitede hukuk fakültesi yok);
 * o alan kapsam dışı.
 *
 * ── YENİDEN ATANMA ──
 * Madde 7(1)(e): "Doktor öğretim üyelerinin yeniden atanmalarında bu
 * yönergede belirtilen ilk atamadaki yayın şartlarını ve puan şartlarını
 * BİR KEZ DAHA sağlamış olmalıdır." Koşullar ilk atanmayla birebir aynı,
 * yalnızca dönem `SON_ATAMA_SONRASI`.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde 4(3) deneme dersi: jüri karşısında ders anlatma — `beyan`.
 *       "Yükseköğretim kurumlarında en az 1 yıl ders vermiş olanlardan bu
 *       şart aranmaz" istisnası profilden okunamıyor.
 *   Madde 4(2), 5(2) ve 6(1)'in ikinci dil şartı ("çalışma alanı bir
 *       yabancı dil olan bölümlerde AYRICA ilgili dilde 70/85 puan") —
 *       bölümün çalışma alanı profilde yok; genel eşik (55/60) yazıldı ve
 *       aday notunda uyarıldı.
 *   Madde 4(6)-(7): 50/d kapsamındaki araştırma görevlilerine ayrılan %30
 *       kota — kontenjan kuralı, adayın kendi dosyasından okunamaz.
 *   Madde 6(2): "ÜAK'ın doçentlik şartlarında belirlediği yayın şartlarını
 *       (lisansüstü tezlerden üretilmiş olma şartı hariç) bir kez daha
 *       yerine getirmiş olmak" — ÜAK şartları adayın doçent olduğu döneme
 *       göre değiştiği için `beyan`.
 *   Madde 7(1)(f): asgari koşulları sağlayan aday çıkmadığında Üniversite
 *       Yönetim Kurulu kararıyla atama — idari takdir.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/ksu-2023.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Kahramanmaraş Sütçü İmam Üniversitesi';
$CETVEL = 'ksu-2023';
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$T13 = ['T1-T3'];
$T123 = ['T1-T2-T3'];
// Adaya gösterilen küme adları (KONVANSIYONLAR §2). T1 akademik yayın ve
// faaliyet, T2 mimari ve sanatsal etkinlik, T3 eğitim ve kurumsal katkı.
$LISTE13 = 'Akademik faaliyet ve kurumsal katkı';
$LISTE123 = 'Akademik faaliyet, sanatsal etkinlik ve kurumsal katkı';

$DIL_NOTU = ' DİKKAT: çalışma alanı bir yabancı dil olan bölümlerde yönerge AYRICA ilgili dilde '
    .'70 (doktor öğretim üyeliği) ya da 85 (doçentlik ve profesörlük) puan istiyor; bölümün '
    .'çalışma alanı profilde tutulmadığı için burada yalnızca genel eşik uygulanıyor.';

$denemeDersi = Kalip::beyan(
    'Bölüm ya da anabilim dalı başkanlığında en az üç öğretim üyesinden oluşan jüri karşısında '
    .'deneme dersi vererek başarılı olmak (yükseköğretim kurumlarında en az 1 yıl ders vermiş '
    .'olanlardan aranmaz)',
    'Madde 4(3)',
);

$doktora = Kalip::beyan(
    'Doktora ya da tıpta, diş hekimliğinde uzmanlık veya sanatta yeterlik eğitimini tamamlamış olmak',
    'Madde 4(1)',
);

$docentUnvani = Kalip::beyan('İlgili alanda doçent unvanını almış olmak', 'Madde 5(1)');

$ikiYil = fn (string $md): array => Kalip::beyan(
    'En az iki yıl süreyle üniversitelerde ya da alanınızla ilgili bilimsel bir araştırma '
    .'kuruluşunda fiilen çalışmış olmak',
    $md,
);

$drYayin = fn (?array $donem): array => Kalip::ve('Yayın koşulu', [
    Kalip::adet(
        'Makale, kitap ve bildiri türünden en az 3 yayınınız olmalı',
        ['DR-YAYIN'], 3, donem: $donem, madde: 'Madde 4(4)(a) / 4(5)(a)',
    ),
    Kalip::adet(
        'Bu yayınlardan en az 1 tanesinde başlıca yazar olmalısınız',
        ['DR-YAYIN'], 1, yazar: 'baslica', donem: $donem, madde: 'Madde 4(4)(a) / 4(5)(a)',
    ),
]);

$docYayin = Kalip::ve('Yayın koşulu', [
    Kalip::adet(
        'Makale ve kitap türünden en az 6 yayınınız olmalı',
        ['DOC-YAYIN'], 6, madde: 'Madde 5(3)(b) / 5(4)(c) / 5(5)(c) / 5(6)(a)',
    ),
    Kalip::adet(
        'Bu yayınlardan en az 3 tanesinde başlıca yazar olmalısınız',
        ['DOC-YAYIN'], 3, yazar: 'baslica', madde: 'Madde 5(3)(b) / 5(4)(c) / 5(5)(c) / 5(6)(a)',
    ),
]);

$dersSarti = Kalip::metrik(
    'Alanınızda en az bir yarıyıl ön lisans, lisans ya da lisansüstü ders vermiş olmak',
    'ders_yariyil', 1,
);

$esikler = [];

$profesorKidem = Kalip::beyan(
    'İlgili alanda doçent unvanını aldıktan sonra en az iki yıl süreyle üniversitelerde çalışmış olmak',
    'Madde 6(2)',
);

$uakTekrar = Kalip::beyan(
    'Doçent olduğunuz dönemde Üniversitelerarası Kurulun alanınız için belirlediği doçentlik '
    .'yayın şartlarını (lisansüstü tezlerden üretilmiş olma şartı hariç) bir kez daha yerine '
    .'getirmiş olmak',
    'Madde 6(2)',
);

$FEN_SOSYAL = ['saglik', 'spor', 'ziraat', 'fen', 'muhendislik', 'egitim', 'sosyal', 'ilahiyat', 'filoloji'];
$SANAT = ['guzel_sanatlar', 'mimarlik'];

// ══════════════════════════════════════════════════════════════════════════
// DOKTOR ÖĞRETİM ÜYESİ (Madde 4) — ilk atanma ve yeniden atanma
// ══════════════════════════════════════════════════════════════════════════

/**
 * @param  list<string>  $alanlar
 * @param  list<string>  $kume
 * @return list<array<string, mixed>>
 */
$drEsikleri = function (string $anahtar, array $alanlar, array $kume, string $listeAdi,
    string $madde, string $birimAdi,
) use ($UNIVERSITE, $CETVEL, $SON_ATAMA, $doktora, $denemeDersi, $drYayin, $DIL_NOTU): array {
    return [
        [
            'anahtar' => "ksu-{$anahtar}-dr",
            'aday_notu' => "{$birimAdi} için Dr. Öğretim Üyeliğinde biri başlıca yazar olmak üzere "
                ."en az 3 yayın ve {$listeAdi}'ten toplam 30 puan isteniyor.".$DIL_NOTU,
            'universite' => $UNIVERSITE,
            'kadro' => 'dr_ogr_uyesi',
            'alan' => $alanlar,
            'cetvel' => $CETVEL,
            'notlar' => "{$madde}: doktora ya da uzmanlık eğitimi, YDS 55, deneme dersi; Tablo 1'in "
                .'1/a-b, 2/a-d ve 4/e-h maddelerinde biri başlıca yazar olarak en az 3 yayın; '
                ."{$listeAdi}'ten toplam 30 puan.",
            'sart' => Kalip::ve("Doktor Öğretim Üyesi kadrosuna atanma — {$birimAdi}", [
                $doktora,
                Kalip::yds(55),
                $denemeDersi,
                $drYayin(null),
                Kalip::toplam(30, null, array_values($kume), $listeAdi),
            ]),
        ],
        [
            'anahtar' => "ksu-{$anahtar}-dr-yeniden",
            'aday_notu' => 'Bir önceki atama tarihinizden itibaren yaptığınız çalışmalar '
                .'sayılıyor. Yönerge yeniden atanmada ilk atanmadaki yayın ve puan şartlarının '
                .'BİR KEZ DAHA sağlanmasını istiyor: biri başlıca yazar olmak üzere en az 3 yayın '
                ."ve {$listeAdi}'ten toplam 30 puan. Şartları tamamlayamayanların görev süresi bir "
                .'yıl uzatılıyor.',
            'universite' => $UNIVERSITE,
            'kadro' => 'dr_ogr_uyesi_yeniden',
            'alan' => $alanlar,
            'cetvel' => $CETVEL,
            'notlar' => "Madde 7(1)(e) ile {$madde}: ilk atanmadaki yayın ve puan şartları son "
                .'atanma tarihinden sonra bir kez daha aranır.',
            'sart' => Kalip::ve("Doktor Öğretim Üyeliğine yeniden atanma — {$birimAdi}", [
                $drYayin($SON_ATAMA),
                Kalip::toplam(30, $SON_ATAMA, array_values($kume), $listeAdi),
            ]),
        ],
    ];
};

$esikler = array_merge($esikler, $drEsikleri('genel', $FEN_SOSYAL, $T13, $LISTE13, 'Madde 4(4)',
    'Tıp, Diş Hekimliği, Sağlık, Orman, Ziraat, Fen, Eğitim, İİBF, İlahiyat, İnsan ve Toplum, Spor fakülteleri ile Mimarlık dışındaki mühendislik bölümleri'));

$esikler = array_merge($esikler, $drEsikleri('sanat', $SANAT, $T123, $LISTE123, 'Madde 4(5)',
    'Güzel Sanatlar Fakültesi ve Mimarlık Bölümü'));

// ══════════════════════════════════════════════════════════════════════════
// DOÇENT (Madde 5)
// ══════════════════════════════════════════════════════════════════════════

/**
 * @param  list<string>  $alanlar
 * @param  list<string>  $kume
 * @param  list<array<string, mixed>>  $ekKosullar
 * @return array<string, mixed>
 */
$docentEsik = function (string $anahtar, array $alanlar, array $kume, string $listeAdi,
    string $madde, string $birimAdi, array $ekKosullar, string $ekNot,
) use ($UNIVERSITE, $CETVEL, $docentUnvani, $docYayin, $DIL_NOTU): array {
    return [
        'anahtar' => "ksu-{$anahtar}-docentlik",
        'aday_notu' => "{$birimAdi} için doçent kadrosunda en az üçü başlıca yazar olmak üzere 6 "
            ."yayın ve {$listeAdi}'ten toplam 150 puan isteniyor.{$ekNot}".$DIL_NOTU,
        'universite' => $UNIVERSITE,
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => "{$madde}: doçent unvanı, YDS 60; Tablo 1'in 1/a-b ve 2/a-d maddelerinde en az "
            ."üçü başlıca yazar olarak 6 yayın; {$listeAdi}'ten toplam 150 puan.{$ekNot}",
        'sart' => Kalip::ve("Doçent kadrosuna atanma — {$birimAdi}", array_values(array_merge(
            [$docentUnvani, Kalip::yds(60)],
            $ekKosullar,
            [$docYayin, Kalip::toplam(150, null, array_values($kume), $listeAdi)],
        ))),
    ];
};

$esikler[] = $docentEsik('saglik', ['saglik', 'spor'], $T13, $LISTE13, 'Madde 5(3)',
    'Tıp, Diş Hekimliği, Sağlık Bilimleri ve Spor Bilimleri fakülteleri',
    [$ikiYil('Madde 5(3)(a)')],
    ' Ayrıca en az iki yıl fiilen çalışmış olmanız gerekiyor.');

$esikler[] = $docentEsik('fen-sosyal',
    ['ziraat', 'fen', 'muhendislik', 'egitim', 'sosyal', 'ilahiyat', 'filoloji'],
    $T13, $LISTE13, 'Madde 5(4) ve 5(5)',
    'Orman, Ziraat, Fen, Eğitim, İİBF, İnsan ve Toplum, İlahiyat fakülteleri ile Mimarlık dışındaki mühendislik bölümleri',
    [$ikiYil('Madde 5(4)(a) / 5(5)(a)'), $dersSarti],
    ' Ayrıca en az iki yıl fiilen çalışmış ve alanınızda en az bir yarıyıl ders vermiş olmanız gerekiyor.');

$esikler[] = $docentEsik('sanat', $SANAT, $T123, $LISTE123, 'Madde 5(6)',
    'Güzel Sanatlar Fakültesi ve Mimarlık Bölümü', [], '');

// ══════════════════════════════════════════════════════════════════════════
// PROFESÖR (Madde 6)
// ══════════════════════════════════════════════════════════════════════════

/**
 * @param  list<string>  $alanlar
 * @param  list<string>  $kume
 * @param  list<array<string, mixed>>  $yayinKosulu
 * @return array<string, mixed>
 */
$profesorEsik = function (string $anahtar, array $alanlar, array $kume, string $listeAdi,
    string $birimAdi, array $yayinKosulu, string $yayinMetni,
) use ($UNIVERSITE, $CETVEL, $DOCENTLIK, $profesorKidem, $uakTekrar, $DIL_NOTU): array {
    return [
        'anahtar' => "ksu-{$anahtar}-profesorluk",
        'aday_notu' => 'Doçent unvanınızı aldığınız tarihten sonraki çalışmalarınız sayılıyor. '
            ."{$birimAdi} için doçentlik sonrası {$listeAdi}'ten toplam 150 puan ve {$yayinMetni} "
            .'isteniyor. Ayrıca ÜAK doçentlik yayın şartlarının (tez şartı hariç) bir kez daha '
            .'sağlanması gerekiyor; bu koşul beyana bırakıldı.'.$DIL_NOTU,
        'universite' => $UNIVERSITE,
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => 'Madde 6: YDS 60, doçentlik sonrası en az iki yıl çalışma, ÜAK doçentlik yayın '
            ."şartlarının tekrarı, {$yayinMetni} ve {$listeAdi}'ten doçentlik sonrası toplam 150 puan.",
        'sart' => Kalip::ve("Profesör kadrosuna atanma — {$birimAdi}", array_values(array_merge(
            [Kalip::yds(60), $profesorKidem, $uakTekrar],
            $yayinKosulu,
            [Kalip::toplam(150, $DOCENTLIK, array_values($kume), $listeAdi)],
        ))),
    ];
};

$esikler[] = $profesorEsik('genel', $FEN_SOSYAL, $T13, $LISTE13, 'kalan bütün fakülteler',
    [
        Kalip::adet('Doçentlik sonrası makale ve kitap türünden en az 3 yayın daha', ['DOC-YAYIN'], 3, donem: $DOCENTLIK, madde: 'Madde 6(2)'),
        Kalip::adet('Bu yayınlardan en az 1 tanesinde başlıca yazar olmalısınız', ['DOC-YAYIN'], 1, yazar: 'baslica', donem: $DOCENTLIK, madde: 'Madde 6(2)'),
    ],
    'biri başlıca yazar olmak üzere 3 yayın daha');

$esikler[] = $profesorEsik('sanat', $SANAT, $T123, $LISTE123,
    'Güzel Sanatlar Fakültesi ve Mimarlık Bölümü',
    [Kalip::puanDan('Doçentlik sonrası mimari ve sanatsal etkinlik kalemlerinizden en az 50 puan', ['T2'], 50, $DOCENTLIK, madde: 'Madde 6(2)')],
    'mimari ve sanatsal etkinliklerinizden en az 50 puan');

return $esikler;
