<?php

/**
 * İSTANBUL GALATA ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma
 * Yönergesi
 * Kaynak: pdf/17537099462.istanbulgalatauniversitesi.pdf
 *
 * KENDİ PUAN TABLOSU YOK, PUAN DA İSTEMİYOR. Koşulların tamamı "en az N tam
 * metin makale ya da şu alternatif" biçiminde sayı şartı. Cetvel olarak ÜAK
 * doçentlik tablosu (`uak-2024-mart-{alan}`) kullanıldı.
 *
 * DR. ÖĞR. ÜYELİĞİ İÇİN AKADEMİK KOŞUL YOK: Madde 5 yalnızca ilan, jüri ve
 * atama usulünü düzenliyor, yayın ya da puan şartı koymuyor. Bu yüzden o kadro
 * için eşik yazılmadı — olmayan bir koşul uydurmak yerine kadro kapsam dışı
 * bırakıldı.
 *
 * DOÇENTLİK VE PROFESÖRLÜK AYNI YAPIDA, YALNIZCA SAYI DEĞİŞİYOR: doçentlikte
 * 2, profesörlükte 1 makale. Korpusta profesörlük şartının doçentlikten DAHA
 * HAFİF olduğu ender örneklerden biri — çünkü profesörlükteki sayı doçentlik
 * unvanı alındıktan SONRAKİ döneme ait, doçentlikteki ise doktora sonrasına.
 *
 * HER İKİ KADRODA DA ÜÇ ALAN GRUBU VE HER GRUPTA BİR ALTERNATİF:
 *   Fen, Mühendislik, Sağlık   WoS/Scopus makale  ya da tescil edilmiş patent
 *   Sosyal ve benzeri alanlar  WoS/Scopus/TR Dizin makale ya da uluslararası kitap
 *   Sanatla ilgili alanlar     WoS/Scopus/TR Dizin makale ya da ulusal sergi
 *
 * SANAT ALANININ SERGİ ALTERNATİFİ BEYAN: ÜAK doçentlik cetvelinde sanatsal
 * etkinlik kalemleri bulunmuyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: uak-2024-mart-{alan}
 */

use App\Services\Scoring\Sart\Kalip;

$DR = Kalip::DOKTORA_SONRASI;
$DOC = Kalip::DOCENTLIK_SONRASI;

$fenGrubu = ['fen', 'muhendislik', 'saglik', 'ziraat'];
$sosyalGrubu = ['egitim', 'ilahiyat', 'filoloji', 'hukuk', 'spor', 'sosyal', 'mimarlik'];
$sanatGrubu = ['guzel_sanatlar'];

$drNotu = 'İstanbul Galata yönergesi Dr. Öğr. Üyeliği için akademik koşul koymuyor; Madde 5 '
    .'yalnızca ilan, jüri ve atama usulünü düzenliyor. Bu kadro için eşik yazılmadı.';

/**
 * Doçentlik ve profesörlükte ortak yapı: alan grubuna göre makale sayısı ve
 * bir alternatif.
 *
 * @param  list<string>  $alanlar
 * @param  list<string>  $maddeler
 * @return array<string, mixed>
 */
$esik = function (string $kadro, string $kadroAd, string $anahtar, string $ad, array $alanlar,
    int $sayi, array $maddeler, string $makaleAd, array $alternatif, string $madde,
    array $donem, string $notu): array {
    return [
        'anahtar' => "istanbul-galata-{$kadro}-{$anahtar}",
        'aday_notu' => $notu,
        'universite' => 'İstanbul Galata Üniversitesi',
        'kadro' => $kadro,
        'alan' => array_values($alanlar),
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => "{$madde} ({$ad}): en az {$sayi} tam metin makale ya da belirtilen alternatif.",
        'sart' => Kalip::ve("{$kadroAd} — {$ad}", [
            Kalip::veya('Aşağıdaki seçeneklerden birini sağlamak', [
                Kalip::adet("{$makaleAd} en az {$sayi} tam metin makale",
                    array_values($maddeler), $sayi, donem: $donem, madde: $madde),
                ...array_values($alternatif),
            ]),
        ]),
    ];
};

$docNotu = 'Koşulun tamamı DOKTORA unvanınızı aldıktan sonraki çalışmalarınızla sağlanmalı. '
    .$drNotu;
$profNotu = 'Koşulun tamamı DOÇENTLİK unvanınızı aldıktan sonraki çalışmalarınızla sağlanmalı. '
    .'Sayı doçentlikten düşük görünüyor (2 yerine 1) çünkü pencere daha dar: doçentlikte '
    .'doktora sonrası, profesörlükte doçentlik sonrası sayılıyor.';

return [
    // ══════════ DOÇENT (Madde 6) — doktora sonrası ══════════
    $esik('docentlik', 'Doçent', 'fen', 'Fen Bilimleri, Matematik, Mühendislik ve Sağlık Bilimleri',
        $fenGrubu, 2, ['1a-*', '1b', '1c'], 'Web of Science veya Scopus dergilerinde', [
            Kalip::adet('Tescil edilmiş en az 1 patent', ['10*'], 1, donem: $DR, madde: 'Madde 6/a'),
        ], 'Madde 6/a', $DR, $docNotu),

    $esik('docentlik', 'Doçent', 'sosyal', 'Eğitim, İlahiyat, Filoloji, Hukuk, Spor ve Sosyal Bilimler',
        $sosyalGrubu, 2, ['1a-*', '1b', '1c', '2a'], 'Web of Science, Scopus veya TR Dizin dergilerinde', [
            Kalip::adet('Uzmanlık alanınızla ilgili en az 1 uluslararası özgün bilimsel kitap',
                ['4a', '4b'], 1, donem: $DR, madde: 'Madde 6/b'),
        ], 'Madde 6/b', $DR, $docNotu),

    $esik('docentlik', 'Doçent', 'sanat', 'Sanatla İlgili Alanlar',
        $sanatGrubu, 2, ['1a-*', '1b', '1c', '2a'], 'Web of Science, Scopus veya TR Dizin dergilerinde', [
            Kalip::beyan('Alanınızla ilgili en az 1 ulusal sergi açmış olmak', 'Madde 6/c'),
        ], 'Madde 6/c', $DR, $docNotu),

    // ══════════ PROFESÖR (Madde 7) — doçentlik sonrası ══════════
    $esik('profesorluk', 'Profesör', 'fen', 'Fen Bilimleri, Matematik, Mühendislik ve Sağlık Bilimleri',
        $fenGrubu, 1, ['1a-*', '1b', '1c'], 'Web of Science veya Scopus dergilerinde', [
            Kalip::adet('Tescil edilmiş en az 1 patent', ['10*'], 1, donem: $DOC, madde: 'Madde 7/a'),
        ], 'Madde 7/a', $DOC, $profNotu),

    $esik('profesorluk', 'Profesör', 'sosyal', 'Eğitim, İlahiyat, Filoloji, Hukuk, Spor ve Sosyal Bilimler',
        $sosyalGrubu, 1, ['1a-*', '1b', '1c', '2a'], 'Web of Science, Scopus veya TR Dizin dergilerinde', [
            Kalip::adet('Uzmanlık alanınızla ilgili en az 1 uluslararası özgün bilimsel kitap',
                ['4a', '4b'], 1, donem: $DOC, madde: 'Madde 7/b'),
        ], 'Madde 7/b', $DOC, $profNotu),

    $esik('profesorluk', 'Profesör', 'sanat', 'Sanatla İlgili Alanlar',
        $sanatGrubu, 1, ['1a-*', '1b', '1c', '2a'], 'Web of Science, Scopus veya TR Dizin dergilerinde', [
            Kalip::beyan('Alanınızla ilgili en az 1 ulusal sergi açmış olmak', 'Madde 7/c'),
        ], 'Madde 7/c', $DOC, $profNotu),
];
