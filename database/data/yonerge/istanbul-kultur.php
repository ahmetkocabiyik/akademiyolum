<?php

/**
 * İSTANBUL KÜLTÜR ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma
 * Yönergesi
 * Kaynak: pdf/17537099812.istanbulkulturuniversitesi.pdf
 *
 * DOKUZ TEMEL ALAN TABLOSU, AYNI TOPLAM BARAJ, FARKLI ALT KAPI. Bütün
 * tablolarda kadro barajı aynı:
 *   Dr. Öğr. Üyesi 60 · Doçent 100 · Profesör 130
 * Alanları ayıran şey, tablonun BİR bölümüne eklenmiş kadro alt koşulu:
 *
 *   Eğitim      1. bölüm: 1 makale + 15p · 2 makale + 30p (doçent, profesör)
 *   Fen         1. bölüm: 1 makale + 20p · 2 makale + 40p
 *               (Matematik ve İstatistik'te 1 yayın + 10p · 2 yayın + 20p)
 *   Güzel San.  1. bölüm: yalnızca puan — 5p · 10p
 *   Hukuk       2. bölüm: TR Dizin'de 3 yayın · 6 yayın (TELAFİLİ)
 *   Mimarlık    1. bölüm: 1 makale + 10p · 2 makale + 20p
 *   Mühendislik 1. bölüm: 2 makale + 20p · 3 makale + 40p
 *   Sağlık      1. bölüm: 2 makale + 20p · 3 makale + 40p
 *   Sosyal      1. bölüm: yalnızca puan — 5p · 10p
 *   Dil Bilim.  2. bölüm: TR Dizin'de 3 yayın · 6 yayın (TELAFİLİ)
 *
 * Profesörlük alt koşulu doçentlikle AYNI sayıdadır; fark yalnızca dönemde
 * (doçentlik sonrası). Toplam baraj ise 100'den 130'a çıkıyor.
 *
 * ── HUKUK VE DİL'DE ALT KAPI ULUSAL MAKALEDE VE TELAFİLİ ──
 * Bu iki alanda koşul 1. bölüme değil 2. bölüme (Ulusal Makale) bağlı:
 * "a bendinden en az üç yayın yapmak zorunludur. Ulusal makale asgari
 * koşulunu sağlayamayan adaylar, 1. maddenin a, b veya c bentlerinden en az
 * bir yayın yapmak zorundadırlar." Yani TR Dizin şartı uluslararası yayınla
 * telafi edilebiliyor — `telafi` dalıyla kuruldu.
 *
 * ── FEN'DE BİLİM ALANI AYRIMI `birim` İLE ──
 * Fen tablosu "Biyoloji, Fizik, Kimya, Moleküler Biyoloji ve Genetik" ile
 * "Matematik ve İstatistik" için farklı sayı ve puan istiyor. İkisi de `fen`
 * temel alanına düştüğü için ayrım `birim` ile yapıldı; birim seçilmezse
 * YÜKSEK olan (Biyoloji-Fizik-Kimya) eşiği uygulanır — adayı fazla hazır
 * göstermeyen taraf.
 *
 * ── DERS YARIYILI KOŞULU ──
 * 8. bölümün notu: "Doçentlik ve profesörlük kadrolarına atamalarda; doktora
 * ünvanının alınmasından sonra, yükseköğretim kurumlarında en az 4 farklı
 * yarıyılda ders vermiş olması zorunludur." Profildeki `ders_yariyil`
 * ölçütüne bağlandı.
 *
 * ── KAPSAM DIŞI ALANLAR ──
 * Yönergenin dokuz tablosu ilahiyat, spor ve ziraatı hiç anmıyor; İstanbul
 * Kültür'ün bu alanlarda birimi yok. Eşik yazılmadı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde 7(2)-(3): profesörlükte doçentlik sonrası beş yıl çalışmış olmak ve
 *       özgün yayın yapmak — ikisi de beyan.
 *   Madde 13: doktor öğretim üyeliğinde yeniden atanma "ilgili yönetim
 *       kurulunun görüşü" ile yapılıyor, sayısal eşik yok.
 *   Yabancı dil şartı yönergede geçmiyor; uydurulmadı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip
 * cetvel: cetvel/istanbul-kultur-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;

/** Kadro başına toplam baraj — dokuz tabloda da aynı. */
$toplamlar = ['dr_ogr_uyesi' => 60, 'docentlik' => 100, 'profesorluk' => 130];

$kadroAdi = ['dr_ogr_uyesi' => 'Dr. Öğr. Üyeliğine', 'docentlik' => 'Doçent kadrosuna', 'profesorluk' => 'Profesör kadrosuna'];

/**
 * "N makale ve M puan" biçimindeki alt kapı.
 *
 * @param  array<string, mixed>|null  $donem
 * @return list<array<string, mixed>>
 */
$makaleVePuan = function (string $kume, string $kumeAd, int $adet, int $puan,
    ?array $donem, string $madde): array {
    $dugumler = [];

    if ($adet > 0) {
        $dugumler[] = Kalip::adet("{$kumeAd} en az {$adet} makale", [$kume], $adet, donem: $donem, madde: $madde);
    }

    $dugumler[] = Kalip::puanDan("{$kumeAd} en az {$puan} puan", [$kume], $puan, $donem, madde: $madde);

    return $dugumler;
};

/**
 * Hukuk ve Dil'in ulusal makale kapısı: TR Dizin'de N yayın, sağlanamıyorsa
 * uluslararası kalemlerden M yayın.
 *
 * @param  array<string, mixed>|null  $donem
 * @return array<string, mixed>
 */
$ulusalKapi = fn (int $trAdet, int $telafiAdet, ?array $donem, string $madde): array => Kalip::adet(
    "TR Dizin kapsamındaki dergilerde en az {$trAdet} yayın",
    ['2.a'],
    $trAdet,
    donem: $donem,
    madde: $madde,
    telafi: Kalip::adet(
        "TR Dizin koşulunu sağlayamıyorsanız: uluslararası indeksli dergilerde en az {$telafiAdet} yayın",
        ['1.a-c'],
        $telafiAdet,
        donem: $donem,
        madde: $madde,
    ),
);

/**
 * Alan tanımları.
 *
 * kapi  [kadro => [adet, puan]] — 0 adet "yalnızca puan" demek
 */
$alanlar = [
    [
        'anahtar' => 'ik-egitim', 'ad' => 'Eğitim Bilimleri', 'alanlar' => ['egitim'],
        'birim' => null, 'cetvel' => 'istanbul-kultur-2024', 'tablo' => 'TABLO 1',
        'kume' => '1.a-c', 'kumeAd' => 'Uluslararası indeksli dergilerde',
        'kapi' => ['dr_ogr_uyesi' => [1, 15], 'docentlik' => [2, 30], 'profesorluk' => [2, 30]],
    ],
    [
        'anahtar' => 'ik-fen', 'ad' => 'Fen Bilimleri', 'alanlar' => ['fen'],
        'birim' => null, 'cetvel' => 'istanbul-kultur-2024', 'tablo' => 'TABLO 2',
        'kume' => '1.a-b', 'kumeAd' => 'SCI, SSCI, AHCI, ESCI veya Scopus dergilerinde',
        'kapi' => ['dr_ogr_uyesi' => [1, 20], 'docentlik' => [2, 40], 'profesorluk' => [2, 40]],
    ],
    [
        'anahtar' => 'ik-matematik', 'ad' => 'Matematik ve İstatistik', 'alanlar' => ['fen'],
        'birim' => 'Matematik ve İstatistik', 'cetvel' => 'istanbul-kultur-2024', 'tablo' => 'TABLO 2',
        'kume' => '1.a-b', 'kumeAd' => 'SCI, SSCI, AHCI, ESCI veya Scopus dergilerinde',
        'kapi' => ['dr_ogr_uyesi' => [1, 10], 'docentlik' => [2, 20], 'profesorluk' => [2, 20]],
    ],
    [
        'anahtar' => 'ik-guzel-sanatlar', 'ad' => 'Güzel Sanatlar', 'alanlar' => ['guzel_sanatlar'],
        'birim' => null, 'cetvel' => 'istanbul-kultur-2024-guzel-sanatlar', 'tablo' => 'TABLO 3',
        'kume' => '1.a-c', 'kumeAd' => 'Uluslararası indeksli dergilerde',
        'kapi' => ['dr_ogr_uyesi' => [0, 5], 'docentlik' => [0, 10], 'profesorluk' => [0, 10]],
    ],
    [
        'anahtar' => 'ik-hukuk', 'ad' => 'Hukuk', 'alanlar' => ['hukuk'],
        'birim' => null, 'cetvel' => 'istanbul-kultur-2024-hukuk', 'tablo' => 'TABLO 4',
        'ulusal' => ['dr_ogr_uyesi' => [3, 1], 'docentlik' => [6, 2], 'profesorluk' => [6, 2]],
    ],
    [
        'anahtar' => 'ik-mimarlik', 'ad' => 'Mimarlık, Planlama ve Tasarım', 'alanlar' => ['mimarlik'],
        'birim' => null, 'cetvel' => 'istanbul-kultur-2024', 'tablo' => 'TABLO 5',
        'kume' => '1.a-c', 'kumeAd' => 'Uluslararası indeksli dergilerde',
        'kapi' => ['dr_ogr_uyesi' => [1, 10], 'docentlik' => [2, 20], 'profesorluk' => [2, 20]],
    ],
    [
        'anahtar' => 'ik-muhendislik', 'ad' => 'Mühendislik', 'alanlar' => ['muhendislik'],
        'birim' => null, 'cetvel' => 'istanbul-kultur-2024', 'tablo' => 'TABLO 6',
        'kume' => '1.a-b', 'kumeAd' => 'SCI, SSCI, AHCI, ESCI veya Scopus dergilerinde',
        'kapi' => ['dr_ogr_uyesi' => [2, 20], 'docentlik' => [3, 40], 'profesorluk' => [3, 40]],
    ],
    [
        'anahtar' => 'ik-saglik', 'ad' => 'Sağlık Bilimleri', 'alanlar' => ['saglik'],
        'birim' => null, 'cetvel' => 'istanbul-kultur-2024', 'tablo' => 'TABLO 7',
        'kume' => '1.a-b', 'kumeAd' => 'SCI, SSCI, AHCI, ESCI veya Scopus dergilerinde',
        'kapi' => ['dr_ogr_uyesi' => [2, 20], 'docentlik' => [3, 40], 'profesorluk' => [3, 40]],
    ],
    [
        'anahtar' => 'ik-sosyal', 'ad' => 'Sosyal, Beşeri ve İdari Bilimler', 'alanlar' => ['sosyal'],
        'birim' => null, 'cetvel' => 'istanbul-kultur-2024', 'tablo' => 'TABLO 8',
        'kume' => '1.a-c', 'kumeAd' => 'Uluslararası indeksli dergilerde',
        'kapi' => ['dr_ogr_uyesi' => [0, 5], 'docentlik' => [0, 10], 'profesorluk' => [0, 10]],
    ],
    [
        'anahtar' => 'ik-dil', 'ad' => 'Dil Bilimleri', 'alanlar' => ['filoloji'],
        'birim' => null, 'cetvel' => 'istanbul-kultur-2024-dil', 'tablo' => 'TABLO 9',
        'ulusal' => ['dr_ogr_uyesi' => [3, 1], 'docentlik' => [6, 2], 'profesorluk' => [6, 2]],
    ],
];

$esikler = [];

foreach ($alanlar as $a) {
    foreach ($toplamlar as $kadro => $toplam) {
        $donem = match ($kadro) {
            'dr_ogr_uyesi' => null,
            'docentlik' => $DOKTORA,
            default => $DOCENTLIK,
        };
        $madde = "{$a['tablo']} — {$kadroAdi[$kadro]}";

        $kosullar = [];

        if ($kadro === 'docentlik') {
            $kosullar[] = Kalip::beyan('Üniversitelerarası Kurul\'dan doçent unvanını almış olmak', 'Madde 9(2)');
        }

        if ($kadro === 'profesorluk') {
            $kosullar[] = Kalip::beyan(
                'Doçent unvanını aldıktan sonra en az beş yıl, başvurduğunuz bilim alanında '
                .'çalışmış ve özgün yayınlar yapmış olmak',
                'Madde 7(2)-(3)',
            );
        }

        // Alt kapı: çoğu alanda 1. bölüme, Hukuk ve Dil'de 2. bölüme bağlı.
        if (isset($a['ulusal'])) {
            [$trAdet, $telafiAdet] = $a['ulusal'][$kadro];
            $kosullar[] = $ulusalKapi($trAdet, $telafiAdet, $donem, $madde);
        } else {
            [$adet, $puan] = $a['kapi'][$kadro];
            $kosullar = [...$kosullar, ...$makaleVePuan($a['kume'], $a['kumeAd'], $adet, $puan, $donem, $madde)];
        }

        // 8. bölümün notu: doçentlik ve profesörlükte dört farklı yarıyıl ders.
        if ($kadro !== 'dr_ogr_uyesi') {
            $kosullar[] = Kalip::metrik(
                'Doktora unvanınızdan sonra en az 4 farklı yarıyılda ders vermiş olmak',
                'ders_yariyil',
                4,
            );
        }

        $kosullar[] = Kalip::toplam($toplam);

        $aciklama = isset($a['ulusal'])
            ? "TR Dizin'de {$a['ulusal'][$kadro][0]} yayın (uluslararası yayınla telafi edilebilir)"
            : ($a['kapi'][$kadro][0] > 0
                ? "{$a['kapi'][$kadro][0]} uluslararası makale ve {$a['kapi'][$kadro][1]} puan"
                : "uluslararası kalemlerden {$a['kapi'][$kadro][1]} puan");

        $esikler[] = [
            'anahtar' => "{$a['anahtar']}-".str_replace('_', '-', $kadro),
            'aday_notu' => "{$a['ad']} tablosunda toplam baraj {$toplam} puan; bunun yanında "
                .'alt kapı olarak '.$aciklama.' isteniyor.'
                .($kadro === 'dr_ogr_uyesi' ? '' : ' Ayrıca doktora sonrası en az dört farklı '
                    .'yarıyılda ders vermiş olmanız gerekiyor.'),
            'universite' => 'İstanbul Kültür Üniversitesi',
            'kadro' => $kadro,
            'alan' => $a['alanlar'],
            'birim' => $a['birim'],
            'cetvel' => $a['cetvel'],
            'notlar' => "{$a['tablo']} ({$a['ad']}), {$kadroAdi[$kadro]} sütunu. Toplam baraj "
                ."{$toplam} puan; dokuz tabloda da aynı. Alt kapı: {$aciklama}.",
            'sart' => Kalip::ve("{$kadroAdi[$kadro]} atanma — {$a['ad']}", $kosullar),
        ];
    }
}

return $esikler;
