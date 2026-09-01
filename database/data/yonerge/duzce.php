<?php

/**
 * DÜZCE ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atama Ek Koşulları
 * Kaynak: pdf/17536992892.duzceuniverstesi.pdf (B bölümü)
 *
 * ÜÇ ALAN GRUBU, HER KADRODA AYRI TABLO:
 *   Sağlık Bilimleri
 *   Fen Bilimleri, Mühendislik Bilimleri, Mimarlık
 *   Sosyal Bilimler, Eğitim Bilimleri, Spor Bilimleri, Güzel Sanatlar
 *
 * KORPUSTA NADİR BİR PENCERE: Düzce toplam puanın yanında "SON BEŞ YILDA EN AZ"
 * puan istiyor (profesörlükte 450/350/250). Bu, doçentlik veya doktora tarihine
 * değil BAŞVURU TARİHİNE bağlı kayan bir pencere; motorda `sonYil` ile
 * karşılandı. Korpustaki diğer yönergelerin çoğu unvan tarihine göre pencere
 * açıyor, Düzce ise adayın son beş yıldaki üretkenliğini ölçüyor.
 *
 * "TABAN PUANIN EN AZ %50'Sİ BİLİMSEL/SANATSAL YAYINLARDAN" (genel ilke 9)
 * koşulu sabit puana çevrildi: profesör sağlık 650 → yayınlardan 325.
 *
 * DR. ÖĞR. ÜYESİNDE "TÜMÜ AYNI ETKİNLİK TÜRÜNDEN OLMAMAK" KOŞULU BEYAN:
 * yönerge puanın tek bir etkinlik türünden toplanmasını yasaklıyor. Etkinlik
 * türü çeşitliliği faaliyet kaydından hesaplanabilir görünse de yönerge "tür"ü
 * tanımlamıyor (bölüm mü, alt madde mi belirsiz); yanlış tanımla adaya
 * sağlanmış/sağlanmamış demek yerine beyan olarak duruyor.
 *
 * YENİDEN ATANMA GİRİLMEDİ: yönerge sabit puan değil "30 puan/yıl" ve "20
 * puan/yıl" diyor; görev süresi profilde tutulmuyor.
 *
 * GÜZEL SANATLAR EK KOŞULU (profesörlükte 5 adet derleme/eleştiri/katalog
 * yazısı, Dr. Öğr. Üyesinde 1 adet) beyan olarak duruyor: "katalog yazısı,
 * biyografi, kitap değerlendirme" türleri kaynak sözlüğünde ayrı ayrı
 * tanımlanmadığı için sayım güvenilir olmaz.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/duzce-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$sonBesYil = Kalip::sonYil(5);

$saglik = ['saglik'];
$fenGrubu = ['fen', 'muhendislik', 'mimarlik'];
$sosyalGrubu = ['sosyal', 'egitim', 'spor', 'guzel_sanatlar'];

$yenidenAtamaNotu = 'Yeniden atanmada yönerge sabit puan değil GÖREV YILI BAŞINA puan istiyor '
    .'(sağlık, fen, mühendislik ve mimarlıkta 30/yıl; sosyal, eğitim, spor ve güzel sanatlarda '
    .'20/yıl). Görev süreniz burada tutulmadığı için yeniden atanma eşiği girilmedi.';

/**
 * Bir kadronun üç alan grubundaki eşiği. Yapı üç grupta da aynı, yalnızca
 * sayılar değişiyor.
 *
 * @param  list<string>  $alanlar
 * @param  list<array<string, mixed>>  $ek
 * @return array<string, mixed>
 */
$esik = function (string $kadro, string $kadroAd, string $anahtar, string $ad, array $alanlar,
    int $toplam, ?int $sonBes, string $madde, string $adayNotu, array $ek = []) use ($sonBesYil): array {
    $cocuklar = [Kalip::toplam($toplam)];

    if ($sonBes !== null) {
        $cocuklar[] = Kalip::toplam($sonBes, $sonBesYil);
    }

    // Genel ilke 9: taban puanın en az yarısı yayınlardan.
    $yariTaban = intdiv($toplam, 2);
    $cocuklar[] = Kalip::puanDan(
        "Makale, kitap, atıf ve sanatsal çalışmalarınızdan en az {$yariTaban} puan (taban puanın yarısı)",
        ['YAYINLAR'], $yariTaban, madde: 'Genel ilke 9',
    );

    return [
        'anahtar' => "duzce-{$kadro}-{$anahtar}",
        'aday_notu' => $adayNotu,
        'universite' => 'Düzce Üniversitesi',
        'kadro' => $kadro,
        'alan' => array_values($alanlar),
        'cetvel' => 'duzce-2024',
        'notlar' => $sonBes === null
            ? "{$madde} ({$ad}): EK-1'den toplam {$toplam} puan; genel ilke 9: en az {$yariTaban} puanı yayınlardan."
            : "{$madde} ({$ad}): EK-1'den toplam {$toplam} puan, son beş yılda en az {$sonBes}; genel ilke 9: en az {$yariTaban} puanı yayınlardan.",
        'sart' => Kalip::ve("{$kadroAd} — {$ad}", [...$cocuklar, ...array_values($ek)]),
    ];
};

$profNotu = 'Toplam puanın yanında SON BEŞ YILDA da bir baraj var; bu pencere doçentlik '
    .'tarihinize değil başvuru tarihine göre kayıyor. Ayrıca doçentliğinizden sonra en az '
    .'ikisi uluslararası endeksli olmak üzere toplam 10 yayın yapmış olmanız gerekiyor.';

$docNotu = 'Toplam puanın yanında SON BEŞ YILDA da bir baraj var; bu pencere doktora '
    .'tarihinize değil başvuru tarihine göre kayıyor.';

$drNotu = 'Yönerge puanın "tümü aynı etkinlik türünden olmamak" kaydını koyuyor; bu koşul '
    .'beyan olarak duruyor. Ayrıca bir komisyon önünde deneme dersi vermeniz gerekiyor. '
    .$yenidenAtamaNotu;

$profEk = [
    Kalip::adet('Doçentliğinizden sonra en az 2 tanesi uluslararası endeksli dergide olmak üzere '
        .'toplam en az 10 yayın', ['1.1.*', '1.2.*', '1.3.*', '1.4.*'], 10,
        donem: Kalip::DOCENTLIK_SONRASI, madde: 'Madde I/2'),
    Kalip::adet('Doçentliğinizden sonra uluslararası endeksli dergilerde en az 2 makale',
        ['1.1.b', '1.2.a'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Madde I/2'),
    Kalip::beyan('Doçent unvanını aldıktan sonra alanınızda en az beş yıl görev yapmış olmak',
        'Madde I/1'),
];

$drEk = [
    Kalip::yds(60),
    Kalip::beyan('Puanınızın tümü aynı etkinlik türünden olmamak', 'Madde III/1.4'),
    Kalip::beyan('Bir komisyon önünde deneme dersi veya sunumu başarıyla tamamlamış olmak',
        'Madde III/1.3'),
];

$gsProfEk = [
    Kalip::beyan('Doçentliğinizden sonra alanınızla ilgili en az bir makale olmak üzere toplam '
        .'5 adet derleme, eleştiri, katalog yazısı, kitap değerlendirmesi veya biyografi '
        .'yayımlamış olmak', 'Madde I/3'),
];

$gsDrEk = [
    Kalip::beyan('Alanınızla ilgili en az 1 makale, derleme, eleştiri, katalog yazısı, kitap '
        .'değerlendirmesi veya biyografi yayımlamış olmak', 'Madde III/1.2'),
];

return [
    // ══════════ PROFESÖR (Madde I) ══════════
    $esik('profesorluk', 'Profesör', 'saglik', 'Sağlık Bilimleri', $saglik, 650, 450, 'Madde I/4', $profNotu, $profEk),
    $esik('profesorluk', 'Profesör', 'fen', 'Fen Bilimleri, Mühendislik ve Mimarlık', $fenGrubu, 550, 350, 'Madde I/4', $profNotu, $profEk),
    $esik('profesorluk', 'Profesör', 'sosyal', 'Sosyal, Eğitim, Spor Bilimleri ve Güzel Sanatlar',
        $sosyalGrubu, 450, 250, 'Madde I/4', $profNotu.' Güzel Sanatlar adaylarında ayrıca 5 adet '
        .'derleme, eleştiri veya katalog yazısı koşulu var.', [...$profEk, ...$gsProfEk]),

    // ══════════ DOÇENT (Madde II) ══════════
    $esik('docentlik', 'Doçent', 'saglik', 'Sağlık Bilimleri', $saglik, 450, 300, 'Madde II/3', $docNotu, [Kalip::yds(65)]),
    $esik('docentlik', 'Doçent', 'fen', 'Fen Bilimleri, Mühendislik ve Mimarlık', $fenGrubu, 400, 250, 'Madde II/3', $docNotu, [Kalip::yds(65)]),
    $esik('docentlik', 'Doçent', 'sosyal', 'Sosyal, Eğitim, Spor Bilimleri ve Güzel Sanatlar',
        $sosyalGrubu, 300, 200, 'Madde II/3', $docNotu, [Kalip::yds(65)]),

    // ══════════ DR. ÖĞRETİM ÜYESİ (ilk atama, Madde III) ══════════
    $esik('dr_ogr_uyesi', 'Dr. Öğr. Üyesi', 'saglik', 'Sağlık Bilimleri', $saglik, 200, null, 'Madde III/1.4', $drNotu, $drEk),
    $esik('dr_ogr_uyesi', 'Dr. Öğr. Üyesi', 'fen', 'Fen Bilimleri, Mühendislik ve Mimarlık', $fenGrubu, 175, null, 'Madde III/1.4', $drNotu, $drEk),
    $esik('dr_ogr_uyesi', 'Dr. Öğr. Üyesi', 'sosyal', 'Sosyal, Eğitim, Spor Bilimleri ve Güzel Sanatlar',
        $sosyalGrubu, 125, null, 'Madde III/1.4', $drNotu, [...$drEk, ...$gsDrEk]),
];
