<?php

/**
 * TARSUS ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Yönergesi
 * Kaynak: pdf/17537009432.tarsusuniverstesi.pdf (EK 1 / Tablo 1)
 *
 * KORPUSTAKİ EN DÜZENLİ EŞİK TABLOSU: altı alan grubu × üç kadro, her hücrede
 * yalnızca iki sayı — "asgari makale puanı" ve "Tablo 2'den alınması gereken
 * asgari toplam puan". Profesörlükte her iki sayının da yarısı ayrıca
 * doçentlik unvanının alındığı tarihten sonra elde edilmiş olmalı.
 *
 * MAKALE BARAJI ALANA GÖRE FARKLI KÜMEDEN SAYILIYOR (Tablo 1 dipnotları):
 *   a → yalnızca Tablo 2-(3)          SCI, SCI-E, SSCI ve AHCI makaleleri
 *   b → Tablo 2-(3) ve (4)            + alan endeksi ve ESCI/Scopus
 *   c → Tablo 2-(3), (4) ve (5)       + ULAKBİM TR Dizin
 * Yani Fen ve Mühendislik adayı makale barajını YALNIZCA SCI makaleleriyle
 * doldurabiliyorken, Sosyal ve Hukuk adayı TR Dizin makalelerini de sayabiliyor.
 * Eğitim Bilimleri ikisinin arasında: TR Dizin sayılmıyor ama ESCI sayılıyor.
 *
 * MATEMATİK VE İSTATİSTİK AYRI GRUP: Fen Bilimlerinden ayrılıp barajları üçte
 * bir düşük tutulmuş (Dr. 30/60, doçent 60/120, profesör 120/240). Korpusta bir
 * alt bilim dalının kendi eşiğini aldığı ender örneklerden biri; `birim`
 * alanıyla girildi.
 *
 * GÜZEL SANATLARDA MAKALE BARAJI YOK: Tablo 1 o satırda makale sütununu boş
 * bırakıyor, yalnızca Tablo 2 toplamını istiyor. Bu yönergenin kendi tercihi.
 *
 * YENİDEN ATANMA GİRİLMEDİ (Madde 4): koşul "ilk atanma için tanımlanan asgari
 * koşulların yeniden sağlanması" biçiminde ve son atama tarihine bağlı; o tarih
 * profilde tutulmuyor. Sayılar ilk atamayla aynı.
 *
 * YÜZDE YÜZ YABANCI DİLLE EĞİTİM YAPAN BİRİMLERDE dil barajı 85, diğerlerinde
 * 65 (Madde 2). Birim bilgisi olmadan hangisinin geçerli olduğu seçilemediği
 * için DÜŞÜK olan 65 yazıldı; yüksek olanı yazmak Türkçe eğitim veren birime
 * başvuran adaya yönergede olmayan bir baraj gösterirdi.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/tarsus-2023.php
 */

use App\Services\Scoring\Sart\Kalip;

$DOC = Kalip::DOCENTLIK_SONRASI;

$matematikBirimi = 'Matematik ve İstatistik Bilimleri';
$fenBirimi = 'Fen Bilimleri (Matematik ve İstatistik dışındaki bölümler)';

$dilNotu = 'Yüzde yüz yabancı dille eğitim yapan birimlere başvuruda dil barajı 85; '
    .'burada Türkçe eğitim veren birim varsayılarak 65 gösteriliyor.';

$yenidenAtamaNotu = 'Yeniden atanmada ilk atanma koşullarının son atama tarihinizden '
    .'sonraki çalışmalarla yeniden sağlanması isteniyor; sayılar aynı. Atama tarihi burada '
    .'tutulmadığı için ayrı bir yeniden atanma eşiği girilmedi.';

/**
 * Bir alan grubunun üç kadrosunu birden üretir. Makale barajı `$kume` ile
 * belirlenen madde kümesinden, toplam baraj Tablo 2'nin tamamından sayılıyor.
 *
 * Profesörlükte her iki barajın da yarısı doçentlik sonrası isteniyor.
 *
 * @param  list<string>  $alanlar
 * @return list<array<string, mixed>>
 */
$grup = function (string $anahtar, string $ad, array $alanlar, ?string $birim, string $kume,
    string $kumeAd, int $drMakale, int $drToplam) use ($DOC, $dilNotu, $yenidenAtamaNotu): array {
    /** @var list<array<string, mixed>> $satirlar */
    $satirlar = [];

    /** @var list<array{0: string, 1: string, 2: int, 3: int, 4: bool}> $kadrolar */
    $kadrolar = [
        ['dr_ogr_uyesi', 'Dr. Öğr. Üyesi', $drMakale, $drToplam, false],
        ['docentlik', 'Doçent', $drMakale * 2, $drToplam * 2, false],
        ['profesorluk', 'Profesör', $drMakale * 4, $drToplam * 4, true],
    ];

    foreach ($kadrolar as [$kadro, $kadroAd, $makale, $toplam, $docSonrasi]) {
        $cocuklar = [Kalip::yds(65), Kalip::toplam($toplam)];

        if ($makale > 0) {
            $cocuklar[] = Kalip::puanDan("{$kumeAd} en az {$makale} puan", [$kume], $makale,
                madde: 'Tablo 1');
        }

        if ($docSonrasi) {
            $cocuklar[] = Kalip::toplam(intdiv($toplam, 2), $DOC);

            if ($makale > 0) {
                $cocuklar[] = Kalip::puanDan(
                    'Doçentliğinizden sonra '.lcfirst($kumeAd)." en az {$makale} / 2 = "
                        .intdiv($makale, 2).' puan',
                    [$kume], intdiv($makale, 2), $DOC, madde: 'Tablo 1',
                );
            }
        }

        $satirlar[] = [
            'anahtar' => "tarsus-{$kadro}-{$anahtar}",
            'aday_notu' => $kadro === 'profesorluk'
                ? 'Profesörlükte her iki barajın da YARISI doçentlik unvanınızı aldığınız '
                    .'tarihten sonraki çalışmalarınızdan gelmeli. '.$dilNotu
                : $dilNotu.' '.($kadro === 'dr_ogr_uyesi' ? $yenidenAtamaNotu : ''),
            'universite' => 'Tarsus Üniversitesi',
            'kadro' => $kadro,
            'alan' => array_values($alanlar),
            'birim' => $birim,
            'cetvel' => 'tarsus-2023',
            'notlar' => $makale > 0
                ? "Tablo 1 ({$ad}): asgari makale puanı {$makale}, Tablo 2'den toplam {$toplam} puan."
                : "Tablo 1 ({$ad}): makale barajı yok, Tablo 2'den toplam {$toplam} puan.",
            'sart' => Kalip::ve("{$kadroAd} — {$ad}", $cocuklar),
        ];
    }

    return $satirlar;
};

return [
    // ══ Fen (Matematik ve İstatistik hariç), Mühendislik, Sağlık, Ziraat — kümе a ══
    ...$grup('fen', 'Fen Bilimleri, Mühendislik, Sağlık Bilimleri ve Ziraat',
        ['muhendislik', 'saglik', 'ziraat'], null,
        'MAKALE_a', 'SCI, SCI-Expanded, SSCI ve AHCI makalelerinizden', 45, 90),

    ...$grup('fen-bolum', 'Fen Bilimleri (Matematik ve İstatistik dışı)', ['fen'], $fenBirimi,
        'MAKALE_a', 'SCI, SCI-Expanded, SSCI ve AHCI makalelerinizden', 45, 90),

    // ══ Matematik ve İstatistik — kümе a, barajlar üçte bir düşük ══
    ...$grup('matematik', 'Matematik ve İstatistik Bilimleri', ['fen'], $matematikBirimi,
        'MAKALE_a', 'SCI, SCI-Expanded, SSCI ve AHCI makalelerinizden', 30, 60),

    // ══ Eğitim Bilimleri — kümе b (SCI + alan endeksi/ESCI) ══
    ...$grup('egitim', 'Eğitim Bilimleri', ['egitim'], null,
        'MAKALE_b', 'SCI, ESCI ve alan endeksli dergilerdeki makalelerinizden', 45, 90),

    // ══ Filoloji, Hukuk, İlahiyat, Sosyal, Spor — kümе c (+ TR Dizin) ══
    ...$grup('sosyal', 'Filoloji, Hukuk, İlahiyat, Sosyal Bilimler ve Spor Bilimleri',
        ['filoloji', 'hukuk', 'ilahiyat', 'sosyal', 'spor'], null,
        'MAKALE_c', 'SCI, ESCI ve TR Dizin makalelerinizden', 45, 90),

    // ══ Mimarlık, Planlama ve Tasarım — kümе c ══
    ...$grup('mimarlik', 'Mimarlık, Planlama ve Tasarım', ['mimarlik'], null,
        'MAKALE_c', 'SCI, ESCI ve TR Dizin makalelerinizden', 45, 90),

    // ══ Güzel Sanatlar — makale barajı yok ══
    ...$grup('guzel-sanatlar', 'Güzel Sanatlar', ['guzel_sanatlar'], null,
        'MAKALE_c', '', 0, 90),
];
