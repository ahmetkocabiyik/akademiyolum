<?php

/**
 * KIRIKKALE ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma
 * Kriterleri
 * Kaynak: pdf/1770041063500.kirikkale-kriter-02022026.pdf (17 sayfa;
 * Senato 02.12.2022-29/02)
 *
 * ── YAPI: TEK PUANLAMA LİSTESİ, ÜÇ TEMEL ALAN GRUBU ──
 * Bölüm 4 bütün alanların paylaştığı tek puanlama listesi; kadro
 * koşulları (2.1-2.3) yalnızca YAYIN ŞARTINDA üç alan grubuna ayrılıyor:
 *   G1 — Mühendislik, Fen Bilimleri ve Matematik, Sağlık Bilimleri,
 *        Mimarlık Planlama ve Tasarım, Ziraat Orman ve Su Ürünleri
 *        → `muhendislik`, `fen`, `saglik`, `mimarlik`, `ziraat`
 *   G2 — Sosyal Bilimler (Eğitim Bilimleri, Sosyal Beşeri ve İdari
 *        Bilimler, Hukuk, Filoloji, İlahiyat) ve Spor Bilimleri
 *        → `egitim`, `sosyal`, `hukuk`, `filoloji`, `ilahiyat`, `spor`
 *   G3 — Güzel Sanatlar → `guzel_sanatlar`
 * Puan barajları (150/300/1000/1500) alan grubundan bağımsız.
 *
 * ── DÖNEMLER ──
 * Profesörlükte yayın ve puan şartları "doçent unvanı aldıktan sonra"
 * (`DOCENTLIK_SONRASI`), toplam 1500 puan ise dönemsiz. Doçentlikte yayın
 * şartı "doçentlik başvurusu yaptıktan sonra"; bu tarih profilde ayrı
 * tutulmadığı için `DOCENTLIK_SONRASI` kullanıldı. Dr. Öğretim Üyeliğine
 * yeniden atanmada "her yeniden atanma döneminde" denildiği için
 * `SON_ATAMA_SONRASI`.
 *
 * ── "4.14'DEN PUAN ŞARTI ARANMAZ" MUAFİYETİ ──
 * Profesörlükte 2.1.d, doçentlikte 2.2.d "c bendi dışında 4.1.1'den 1
 * (veya 4.1.2'den 2) yayın olduğunda 4.14'den puan şartı aranmaz" diyor.
 * Bu muafiyet proje puanı düğümüne `telafi` dalı olarak yazıldı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   657 sayılı Kanun'un 48. maddesindeki genel şartlar — `beyan`.
 *   Profesörlükte "doçent unvanını aldıktan sonra en az beş yıl ilgili
 *       bilim alanında çalışmış olmak" — `beyan`.
 *   2.1.c.ii'nin "1 adet bilimsel özgün kitap yayımlandığında 4.1.1
 *       kapsamında yayın şartı aranmaz" istisnası — `telafi` dalı olarak
 *       yazıldı.
 *   2.3.2.f: yeniden atanma şartları sağlanmazsa verilen bir yıllık ek
 *       süre — süreç kuralı.
 *   Yönerge hiçbir kadroda yabancı dil puan eşiği koymuyor (puanlama
 *       tablosunun sonunda "yabancı dil puanı" satırı var ama sayısal bir
 *       şart bağlanmamış); `Kalip::yds` kullanılmadı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/kirikkale-2022.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Kırıkkale Üniversitesi';
$CETVEL = 'kirikkale-2022';
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$G1 = ['muhendislik', 'fen', 'saglik', 'mimarlik', 'ziraat'];
$G2 = ['egitim', 'sosyal', 'hukuk', 'filoloji', 'ilahiyat', 'spor'];
$G3 = ['guzel_sanatlar'];

$B4146 = ['B41-46'];
$LISTE46 = 'Yayın, atıf ve proje kalemleri';

$genelSartlar = Kalip::beyan('657 sayılı Devlet Memurları Kanunu\'nun 48. maddesindeki genel şartlara sahip olmak', '2.x-a');

$doktora = Kalip::beyan(
    'Doktora ya da tıpta uzmanlık unvanını veya ÜAK önerisiyle YÖK tarafından tespit edilen sanat '
    .'dallarının birinde yeterlik kazanmış olmak',
    '2.3.1-b',
);

$docentUnvani = Kalip::beyan('Doçentlik unvanını almış olmak', '2.2-b');

$besYil = Kalip::beyan(
    'Doçent unvanını aldıktan sonra en az beş yıl süreyle, açık bulunan profesörlük kadrosuyla '
    .'ilgili bilim alanında çalışmış olmak',
    '2.1-b',
);

/** "4.14'den (BAP hariç) tamamlanan 1 projede yer almak 1 özgün makale yerine geçebilir." */
$projeTelafisi = fn (?array $donem): array => Kalip::adet(
    'Ya da BAP dışı tamamlanmış bir araştırma projesinde yer almak',
    ['PROJE-BAP-HARIC'], 1, donem: $donem, madde: '2.3-c',
);

/** Tez yönetimi koşulu ve alternatifleri (2.1.f / 2.2.f). */
$tezKosulu = fn (?array $donem, string $md): array => Kalip::veya(
    'Tez yönetimi koşulu', [
        Kalip::adet('Başvurduğunuz alanda en az 1 doktora, uzmanlık, sanatta yeterlik ya da yüksek lisans tezi yönetmiş olmak', ['TEZ'], 1, donem: $donem, madde: $md),
        Kalip::adet('Ya da BAP dışı bir araştırma projesini yürütücü olarak tamamlamış olmak', ['PROJE-BAP-HARIC-Y'], 1, donem: $donem, madde: $md),
        Kalip::adet('Ya da SCI, SCI-Expanded, SSCI ya da AHCI dergilerinde 1 yayın yapmış olmak', ['M411'], 1, donem: $donem, madde: $md),
        Kalip::adet('Ya da uluslararası alan indekslerindeki dergilerde 2 yayın yapmış olmak', ['M412'], 2, donem: $donem, madde: $md),
    ],
);

$esikler = [];

// ══════════════════════════════════════════════════════════════════════════
// PROFESÖR (2.1)
// ══════════════════════════════════════════════════════════════════════════

$profesorYayin = [
    'G1' => [Kalip::adet('Doçentlik sonrası SCI, SCI-Expanded, SSCI ya da AHCI dergilerinde en az 3 yayın', ['M411'], 3, donem: $DOCENTLIK, madde: '2.1-c-i')],
    'G2' => [
        Kalip::adet(
            'Doçentlik sonrası SCI, SCI-Expanded, SSCI ya da AHCI dergilerinde en az 1 yayın', ['M411'], 1, donem: $DOCENTLIK,
            telafi: Kalip::adet('Ya da 1 adet bilimsel özgün kitap yayımlamış olmak', ['OZGUN-KITAP'], 1, donem: $DOCENTLIK),
            madde: '2.1-c-ii',
        ),
        Kalip::adet('Doçentlik sonrası uluslararası alan indekslerindeki dergilerde en az 2 yayın', ['M412'], 2, donem: $DOCENTLIK, madde: '2.1-c-ii'),
    ],
    'G3' => [
        Kalip::adet('Doçentlik sonrası uluslararası indeksli dergilerde en az 1 yayın', ['M411-414'], 1, donem: $DOCENTLIK, madde: '2.1-c-iii'),
        Kalip::adet('Doçentlik sonrası yayın, atıf ve proje kalemlerinden en az 5 çalışma', ['B41-46'], 5, donem: $DOCENTLIK, madde: '2.1-c-iii'),
    ],
];

$docentYayin = [
    'G1' => [Kalip::veya('Yayın koşulu', [
        Kalip::adet('SCI, SCI-Expanded, SSCI ya da AHCI dergilerinde en az 2 yayın', ['M411'], 2, donem: $DOCENTLIK, madde: '2.2-c-i'),
        Kalip::adet('Ya da uluslararası alan indekslerindeki dergilerde en az 2 yayın', ['M412'], 2, donem: $DOCENTLIK, madde: '2.2-c-i'),
    ])],
    'G2' => [Kalip::adet('Uluslararası indeksli ya da alan indeksli dergilerde en az 2 yayın', ['M411-412'], 2, donem: $DOCENTLIK, madde: '2.2-c-ii')],
    'G3' => [
        Kalip::adet('uluslararası indeksli dergilerde en az 1 yayın', ['M411-414'], 1, donem: $DOCENTLIK, madde: '2.2-c-iii'),
        Kalip::adet('Yayın, atıf ve proje kalemlerinden en az 2 çalışma', ['B41-46'], 2, donem: $DOCENTLIK, madde: '2.2-c-iii'),
    ],
];

$drYayin = fn (string $grup, ?array $donem, int $sayi): array => Kalip::adet(
    $grup === 'G3'
        ? "uluslararası indeksli dergilerde en az {$sayi} yayın"
        : "Uluslararası indeksli ya da alan indeksli dergilerde en az {$sayi} yayın",
    $grup === 'G3' ? ['M411-414'] : ['M411-412'], $sayi, donem: $donem,
    telafi: Kalip::adet(
        'Ya da BAP dışı tamamlanmış bir araştırma projesinde yer almak bir özgün makale yerine geçer',
        ['PROJE-BAP-HARIC'], 1, donem: $donem,
    ),
    madde: '2.3-c',
);

foreach ([['g1', $G1, 'G1', 'Mühendislik, fen, sağlık, mimarlık ve ziraat temel alanları'],
    ['g2', $G2, 'G2', 'Sosyal bilimler ve spor bilimleri temel alanları'],
    ['g3', $G3, 'G3', 'Güzel sanatlar temel alanı'],
] as [$anahtar, $alanlar, $grup, $grupAdi]) {
    $esikler[] = [
        'anahtar' => "kirikkale-{$anahtar}-profesorluk",
        'aday_notu' => 'Doçent unvanınızı aldığınız tarihten sonraki çalışmalarınız sayılıyor. '
            ."{$grupAdi} için doçentlik sonrası yayın, atıf ve proje kalemlerinden en az 500 puan, "
            .'50 puan ve toplam 1000 puan; ayrıca bütün dönemler için toplam 1500 puan isteniyor. '
            .'Proje puanı şartı, uluslararası indeksli dergilerde bir ya da alan indeksli '
            .'dergilerde iki yayınınız varsa aranmıyor.',
        'universite' => $UNIVERSITE,
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => "2.1 ({$grupAdi}): doçentlikten sonra beş yıl çalışma; alan grubuna göre yayın "
            .'şartı; yayın, atıf ve proje kalemlerinden 500, araştırma projelerinden 50 puan olmak üzere doçentlik sonrası '
            .'1000 puan; toplam 1500 puan; tez yönetimi ya da alternatifi.',
        'sart' => Kalip::ve("Profesör kadrosuna atanma — {$grupAdi}", array_merge(
            [$genelSartlar, $besYil],
            $profesorYayin[$grup],
            [
                Kalip::puanDan('Doçentlik sonrası yayın, atıf ve proje kalemlerinizden en az 500 puan', $B4146, 500, $DOCENTLIK, madde: '2.1-d'),
                Kalip::puanDan(
                    'Doçentlik sonrası araştırma projelerinizden en az 50 puan',
                    ['B414'], 50, $DOCENTLIK, madde: '2.1-d',
                ),
                $tezKosulu($DOCENTLIK, '2.1-f'),
                Kalip::toplam(1000, $DOCENTLIK),
                Kalip::toplam(1500),
            ],
        )),
    ];

    $esikler[] = [
        'anahtar' => "kirikkale-{$anahtar}-docentlik",
        'aday_notu' => 'Doçentlik başvurunuzu yaptığınız tarihten sonraki çalışmalarınız '
            ."sayılıyor. {$grupAdi} için yayın, atıf ve proje kalemlerinden en az 300 puan, araştırma projelerinden en az 50 "
            .'puan ve Bölüm 4\'ten toplam 1000 puan isteniyor.',
        'universite' => $UNIVERSITE,
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => "2.2 ({$grupAdi}): doçentlik unvanı; alan grubuna göre yayın şartı; Bölüm "
            .'yayın, atıf ve proje kalemlerinden 300, araştırma projelerinden 50 puan; toplam 1000 puan; tez yönetimi ya da '
            .'alternatifi.',
        'sart' => Kalip::ve("Doçent kadrosuna atanma — {$grupAdi}", array_merge(
            [$genelSartlar, $docentUnvani],
            $docentYayin[$grup],
            [
                Kalip::puanDan('Yayın, atıf ve proje kalemlerinizden en az 300 puan', $B4146, 300, madde: '2.2-d'),
                Kalip::puanDan('araştırma projelerinizden en az 50 puan', ['B414'], 50, madde: '2.2-d'),
                $tezKosulu(null, '2.2-f'),
                Kalip::toplam(1000),
            ],
        )),
    ];

    $esikler[] = [
        'anahtar' => "kirikkale-{$anahtar}-dr",
        'aday_notu' => "{$grupAdi} için Dr. Öğretim Üyeliğinde yayın, atıf ve proje kalemlerinden en az 150 puan "
            .'ve yayın kalemlerinden toplam 300 puan isteniyor. BAP dışı tamamlanmış '
            .'bir projede yer almak bir özgün makale yerine geçebiliyor.',
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => "2.3.1 ({$grupAdi}): doktora ya da sanatta yeterlik; alan grubuna göre yayın "
            .'şartı; yayın, atıf ve proje kalemleri\'dan 150 puan; toplam 300 puan.',
        'sart' => Kalip::ve("Doktor Öğretim Üyesi kadrosuna atanma — {$grupAdi}", [
            $genelSartlar,
            $doktora,
            $drYayin($grup, null, $grup === 'G3' ? 1 : 2),
            Kalip::puanDan('Yayın, atıf ve proje kalemlerinizden en az 150 puan', $B4146, 150, madde: '2.3.1-d'),
            Kalip::toplam(300),
        ]),
    ];

    $esikler[] = [
        'anahtar' => "kirikkale-{$anahtar}-dr-yeniden",
        'aday_notu' => 'Bir önceki atama tarihinizden itibaren yaptığınız çalışmalar sayılıyor. '
            ."{$grupAdi} için her yeniden atanma döneminde yayın, atıf ve proje kalemlerinden en az 150 puan ve "
            .'Bölüm 4\'ten toplam 300 puan isteniyor. Şartları sağlayamayanlara bir yıl ek süre '
            .'veriliyor.',
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => "2.3.2 ({$grupAdi}): her yeniden atanma döneminde alan grubuna göre yayın "
            .'şartı; yayın, atıf ve proje kalemleri\'dan 150 puan; toplam 300 puan.',
        'sart' => Kalip::ve("Doktor Öğretim Üyeliğine yeniden atanma — {$grupAdi}", [
            $drYayin($grup, $SON_ATAMA, 2),
            Kalip::puanDan('Son atamanızdan sonra yayın, atıf ve proje kalemlerinizden en az 150 puan', $B4146, 150, $SON_ATAMA, madde: '2.3.2-d'),
            Kalip::toplam(300, $SON_ATAMA),
        ]),
    ];
}

return $esikler;
