<?php

/**
 * FIRAT ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Yönergesi
 * Kaynak: pdf/1775657147400.firat-kriter-07042026.pdf (07/04/2026)
 *
 * YEDİ BİLİM ALANI, ORTAK PUAN TABLOSU. EK-1'in 255 ölçütü bütün alanlarda
 * aynı puanı taşıyor (cetvel/firat-2026.php); değişen, hangi kod aralığından
 * ne kadar puan isteneceği.
 *
 * TOPLAM BARAJ İKİLİ, ALT BARAJLAR ALANA GÖRE:
 *   Dr. Öğr. Üyesi   güzel sanatlar 500 · diğer alanlar 1000
 *   Doçent           güzel sanatlar 1000 · diğer alanlar 2000
 *   Profesör         güzel sanatlar 1750 · diğer alanlar 3500
 *
 * ALANLAR ÜÇ DESENE AYRILIYOR:
 *   Sağlık / Mühendislik / Fen   WoS makalesinden (A2.1-A2.2) baraj + TR Dizin
 *   Sosyal / Mimarlık / İlahiyat WoS'tan ESCI ve TR Dizin'e kadar geniş küme
 *                                (A2.1-A2.4) + tek/ilk isimli bir A2.1 makale
 *   Güzel sanatlar               yayın barajı düşük, sanat etkinliği barajı var
 *
 * TELAFİ DALLARI: yönergedeki alt koşulların çoğu "bu şartın sağlanamaması
 * durumunda eksik puanlar şu kapsamdan karşılanabilir" cümlesiyle bitiyor.
 * Telafi kümeleri koşuldan koşula değiştiği ve çoğu "başlıca araştırma eseri
 * koşullarını taşıyan" gibi doğrulanamayan nitelik istediği için düğüm olarak
 * değil, koşulun aday notunda anıldı — telafiyi düğüm yapmak, sağlanmadığı
 * hâlde sağlanmış göstermeye yol açardı.
 *
 * YÖNERGENİN KENDİ TUTARSIZLIĞI: profesör / güzel sanatlar e.2 maddesi
 * "F1.1, F1.2, F4.3 ve F4.4 faaliyetlerinden toplamda en az 800 puan" derken
 * aynı cümlenin parantezi "bu maddeden alması gereken 80 puanı" diyor. Metnin
 * ana hükmü olan 800 alındı; eşiği düşük tutmak adayı yanlış biçimde
 * "sağladınız" diye bilgilendirirdi. Zaten o kalemler cetvele girmediği için
 * koşul beyan olarak duruyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/firat-2026.php
 */

use App\Services\Scoring\Sart\Kalip;

$D = Kalip::DOKTORA_SONRASI;
$P = Kalip::DOCENTLIK_SONRASI;

/** Kadro başına toplam baraj: [güzel sanatlar, diğer alanlar]. */
$TOPLAM = ['dr_ogr_uyesi' => [500, 1000], 'docentlik' => [1000, 2000], 'profesorluk' => [1750, 3500]];

/**
 * Bir bilim alanının üç kadrosunu üretir.
 *
 * @param  list<string>  $alanlar
 * @param  array{dr: list<array<string, mixed>>, docent: list<array<string, mixed>>, profesor: list<array<string, mixed>>}  $kosullar
 * @return list<array<string, mixed>>
 */
$alan = function (string $anahtar, string $ad, array $alanlar, array $kosullar, bool $guzelSanatlar = false) use ($TOPLAM): array {
    $satirlar = [];

    foreach ([['dr_ogr_uyesi', 'dr', 'Dr. Öğr. Üyesi'], ['docentlik', 'docent', 'Doçent'], ['profesorluk', 'profesor', 'Profesör']] as [$kadro, $kisa, $kadroAd]) {
        $toplam = $TOPLAM[$kadro][$guzelSanatlar ? 0 : 1];

        $satirlar[] = [
            'anahtar' => "firat-{$kisa}-{$anahtar}",
            'aday_notu' => 'Yönergedeki alt koşulların çoğu "sağlanamaması durumunda eksik puanlar '
                .'şu kapsamdan karşılanabilir" telafisi taşıyor. Telafi kümeleri koşuldan koşula '
                .'değiştiği ve çoğu "başlıca araştırma eseri" gibi doğrulanamayan nitelik istediği '
                .'için burada uygulanmadı; bir koşulu sağlayamıyorsanız yönergenin ilgili '
                .'maddesindeki telafi seçeneğini kontrol edin.',
            'universite' => 'Fırat Üniversitesi',
            'kadro' => $kadro,
            'alan' => array_values($alanlar),
            'cetvel' => 'firat-2026',
            'notlar' => "{$ad} — {$kadroAd}: tüm maddelerden toplam en az {$toplam} puan.",
            'sart' => Kalip::ve("{$kadroAd} — {$ad}", [
                Kalip::yds(65),
                Kalip::toplam($toplam, match ($kadro) {
                    'docentlik' => Kalip::DOKTORA_SONRASI,
                    'profesorluk' => Kalip::DOCENTLIK_SONRASI,
                    default => null,
                }),
                ...array_values($kosullar[$kisa]),
            ]),
        ];
    }

    return $satirlar;
};

/** WoS makalesine dayanan alanlar (sağlık, mühendislik, fen) ortak deseni. */
$wosDeseni = [
    'dr' => [
        Kalip::adet('SCI, SSCI, SCI-E veya AHCI dergilerinde, en az birinde birinci isim olduğunuz en az 3 yayın',
            ['A2.1-A2.2'], 3, 'ilk', madde: 'Madde 10 · a.1'),
        Kalip::puanDan('SCI, SSCI, SCI-E veya AHCI dergilerindeki yayınlarınızdan en az 250 puan',
            ['A2.1-A2.2'], 250, madde: 'Madde 10 · a.1'),
        Kalip::puanDan('TR Dizin dergilerindeki yayınlarınızdan en az 50 puan',
            ['A2.4'], 50, madde: 'Madde 10 · a.2'),
        Kalip::puanDan('Proje, patent ve Ar-Ge etkinliklerinizden en az 30 puan',
            ['C2-C6'], 30, madde: 'Madde 10 · a.3'),
    ],
    'docent' => [
        Kalip::puanDan('SCI, SSCI, SCI-E veya AHCI dergilerindeki yayınlarınızdan en az 500 puan',
            ['A2.1-A2.2'], 500, Kalip::DOKTORA_SONRASI, madde: 'Madde 11 · a.1'),
        Kalip::puanDan('TR Dizin dergilerindeki yayınlarınızdan en az 100 puan',
            ['A2.4'], 100, Kalip::DOKTORA_SONRASI, madde: 'Madde 11 · a.2'),
        Kalip::puanDan('Proje, patent ve Ar-Ge etkinliklerinizden en az 150 puan',
            ['C2-C6'], 150, Kalip::DOKTORA_SONRASI, madde: 'Madde 11 · a.3'),
    ],
    'profesor' => [
        Kalip::puanDan('SCI, SSCI, SCI-E veya AHCI dergilerindeki yayınlarınızdan en az 500 puan',
            ['A2.1-A2.2'], 500, Kalip::DOCENTLIK_SONRASI, madde: 'Madde 12 · a.1'),
        Kalip::puanDan('TR Dizin dergilerindeki yayınlarınızdan en az 100 puan',
            ['A2.4'], 100, Kalip::DOCENTLIK_SONRASI, madde: 'Madde 12 · a.2'),
        Kalip::puanDan('Proje, patent ve Ar-Ge etkinliklerinizden en az 150 puan',
            ['C2-C6'], 150, Kalip::DOCENTLIK_SONRASI, madde: 'Madde 12 · a.3'),
        Kalip::puanDan('Tez danışmanlıklarınızdan en az 100 puan',
            ['C1'], 100, Kalip::DOCENTLIK_SONRASI, madde: 'Madde 12 · a.5'),
    ],
];

/** Sosyal, mimarlık ve ilahiyat alanlarının ortak deseni. */
$genisDesen = [
    'dr' => [
        Kalip::puanDan('WoS, ESCI/Scopus ve TR Dizin dergilerindeki yayınlarınızdan en az 250 puan',
            ['A2.1-A2.4'], 250, madde: 'Madde 10 · ç.1'),
        Kalip::adet('SCI, SSCI, SCI-E veya AHCI dergisinde tek veya ilk isim olduğunuz en az 1 makale',
            ['A2.1'], 1, 'ilk', madde: 'Madde 10 · ç.2'),
        Kalip::puanDan('Proje, patent ve Ar-Ge etkinliklerinizden en az 30 puan',
            ['C2-C6'], 30, madde: 'Madde 10 · ç.3'),
    ],
    'docent' => [
        Kalip::puanDan('WoS, ESCI/Scopus ve TR Dizin dergilerindeki yayınlarınızdan en az 500 puan',
            ['A2.1-A2.4'], 500, Kalip::DOKTORA_SONRASI, madde: 'Madde 11 · ç.1'),
        Kalip::adet('SCI, SSCI, SCI-E veya AHCI dergisinde tek veya ilk isim olduğunuz en az 1 makale',
            ['A2.1'], 1, 'ilk', Kalip::DOKTORA_SONRASI, madde: 'Madde 11 · ç.2'),
        Kalip::puanDan('Kitap ve kitap bölümü çalışmalarınızdan en az 100 puan',
            ['A1-A4'], 100, Kalip::DOKTORA_SONRASI, madde: 'Madde 11 · ç.3'),
        Kalip::puanDan('Proje, patent ve Ar-Ge etkinliklerinizden en az 100 puan',
            ['C2-C6'], 100, Kalip::DOKTORA_SONRASI, madde: 'Madde 11 · ç.4'),
    ],
    'profesor' => [
        Kalip::puanDan('WoS, ESCI/Scopus ve TR Dizin dergilerindeki yayınlarınızdan en az 500 puan',
            ['A2.1-A2.4'], 500, Kalip::DOCENTLIK_SONRASI, madde: 'Madde 12 · ç.1'),
        Kalip::adet('SCI, SSCI, SCI-E veya AHCI dergisinde tek veya ilk isim olduğunuz en az 1 makale',
            ['A2.1'], 1, 'ilk', Kalip::DOCENTLIK_SONRASI, madde: 'Madde 12 · ç.2'),
        Kalip::puanDan('Kitap ve kitap bölümü çalışmalarınızdan en az 100 puan',
            ['A1-A4'], 100, Kalip::DOCENTLIK_SONRASI, madde: 'Madde 12 · ç.3'),
        Kalip::puanDan('Proje, patent ve Ar-Ge etkinliklerinizden en az 100 puan',
            ['C2-C6'], 100, Kalip::DOCENTLIK_SONRASI, madde: 'Madde 12 · ç.4'),
        Kalip::puanDan('Tez danışmanlıklarınızdan en az 100 puan',
            ['C1'], 100, Kalip::DOCENTLIK_SONRASI, madde: 'Madde 12 · ç.5'),
    ],
];

return [
    ...$alan('saglik', 'Sağlık bilimleri', ['saglik'], $wosDeseni),
    ...$alan('muhendislik', 'Mühendislik bilimleri', ['muhendislik'], $wosDeseni),
    ...$alan('fen', 'Fen bilimleri', ['fen', 'ziraat'], $wosDeseni),
    ...$alan('sosyal', 'Sosyal bilimler', ['sosyal', 'egitim', 'filoloji', 'hukuk', 'spor'], $genisDesen),
    ...$alan('mimarlik', 'Mimarlık bilimleri', ['mimarlik'], $genisDesen),
    ...$alan('ilahiyat', 'İlahiyat bilimleri', ['ilahiyat'], $genisDesen),

    // ══════════ GÜZEL SANATLAR ══════════
    // Yayın barajı düşük ama sanatsal etkinlik ve konservatuvar barajları var.
    // O kalemler (F ve E bölümleri) cetvele girmediği için beyan olarak duruyor.
    ...$alan('guzel-sanatlar', 'Güzel sanatlar bilimleri', ['guzel_sanatlar'], [
        'dr' => [
            Kalip::puanDan('WoS, ESCI/Scopus ve TR Dizin dergilerindeki yayınlarınızdan en az 50 puan',
                ['A2.1-A2.4'], 50, madde: 'Madde 10 · e.1'),
            Kalip::puanDan('Yayın, bildiri, proje ve patent etkinliklerinizden toplam en az 150 puan',
                ['A1-A4', 'B1-B3', 'C2-C6'], 150, madde: 'Madde 10 · e.1'),
            Kalip::beyan('Tanınmış müze, kültür merkezi veya sanat galerisinde açtığınız kişisel '
                .'sergilerden ve ulusal veya uluslararası sempozyumlardaki kişisel '
                .'sergilerinizden toplam en az 40 puan almış olmak', 'Madde 10 · e.3'),
            Kalip::beyan('Devlet Konservatuvarı adayları için müzik etkinliklerinden (solo konser, '
                .'resital, yayımlanmış albüm, koro şefliği, atölye çalışması) en az 100 puan '
                .'almış olmak', 'Madde 10 · e.4'),
            Kalip::puanDan('Proje, patent ve Ar-Ge etkinliklerinizden en az 20 puan',
                ['C2-C6'], 20, madde: 'Madde 10 · e.5'),
        ],
        'docent' => [
            Kalip::puanDan('WoS, ESCI/Scopus ve TR Dizin dergilerindeki yayınlarınızdan en az 150 puan',
                ['A2.1-A2.4'], 150, $D, madde: 'Madde 11 · e.1'),
            Kalip::puanDan('Yayın, bildiri, proje ve patent etkinliklerinizden toplam en az 300 puan',
                ['A1-A4', 'B1-B3', 'C2-C6'], 300, $D, madde: 'Madde 11 · e.1'),
            Kalip::beyan('Tanınmış müze, kültür merkezi veya sanat galerisinde açtığınız kişisel '
                .'sergilerden ve ulusal veya uluslararası sempozyumlardaki kişisel '
                .'sergilerinizden toplam en az 80 puan almış olmak', 'Madde 11 · e.2'),
            Kalip::beyan('Devlet Konservatuvarı adayları için müzik etkinliklerinden (solo konser, '
                .'resital, yayımlanmış albüm, koro şefliği, atölye çalışması) en az 100 puan '
                .'almış olmak', 'Madde 11 · e.3'),
            Kalip::puanDan('Proje, patent ve Ar-Ge etkinliklerinizden en az 50 puan',
                ['C2-C6'], 50, $D, madde: 'Madde 11 · e.4'),
        ],
        'profesor' => [
            Kalip::puanDan('WoS, ESCI/Scopus ve TR Dizin dergilerindeki yayınlarınızdan en az 150 puan',
                ['A2.1-A2.4'], 150, $P, madde: 'Madde 12 · e.1'),
            Kalip::puanDan('Yayın, bildiri, proje ve patent etkinliklerinizden toplam en az 300 puan',
                ['A1-A4', 'B1-B3', 'C2-C6'], 300, $P, madde: 'Madde 12 · e.1'),
            Kalip::beyan('Tanınmış müze, kültür merkezi veya sanat galerisinde açtığınız kişisel '
                .'sergilerden ve ulusal veya uluslararası sempozyumlardaki kişisel '
                .'sergilerinizden toplam en az 800 puan almış olmak (yönerge aynı cümlenin '
                .'parantezinde 80 puan diyor; ana hüküm 800 kabul edildi)', 'Madde 12 · e.2'),
            Kalip::beyan('Devlet Konservatuvarı adayları için müzik etkinliklerinden (solo konser, '
                .'resital, yayımlanmış albüm, koro şefliği, atölye çalışması) en az 100 puan '
                .'almış olmak', 'Madde 12 · e.3'),
            Kalip::puanDan('Proje, patent ve Ar-Ge etkinliklerinizden en az 50 puan',
                ['C2-C6'], 50, $P, madde: 'Madde 12 · e.4'),
            Kalip::beyan('Doçentlik unvanını aldıktan sonra yayımlanmış başlıca araştırma eserine '
                .'sahip olmak', 'Madde 12 · c'),
        ],
    ], guzelSanatlar: true),
];
