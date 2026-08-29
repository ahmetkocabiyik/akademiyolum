<?php

/**
 * ÇUKUROVA ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Ölçütleri
 * Kaynak: pdf/17536992412.cukurovauniverstesi.pdf (Senato değişikliği 24/12/2024)
 *
 * ON İKİ TEMEL ALAN, ON İKİ AYRI TABLO. EK 1 doçentlik temel alanı başına bir
 * tablo veriyor ve her tabloda üç kadro sütunu var. Bu, uygulamanın
 * TemelAlan enum'undaki on iki alanla birebir örtüşüyor — nadir bir durum,
 * çoğu yönerge alanları kendi gruplarına topluyor.
 *
 * DESEN HER TABLODA AYNI, SAYILAR FARKLI:
 *   Dr. Öğr. Üyesi   N makale (en az birinde başlıca yazar) + 1 bildiri
 *   Doçent           M makale (en az K'sında başlıca) + 3 bildiri + asgari puan
 *                    + Ek 4'ten en az BEŞ genel akademik etkinlik
 *   Profesör         aynı yayın koşulu + daha yüksek asgari puan
 *                    + Ek 4'ten en az YEDİ genel akademik etkinlik
 *
 * Doçent ve profesörün YAYIN koşulları iki alan dışında birebir aynı; fark
 * yalnızca asgari puanda. Mimarlık ve Sosyal'de profesör iki makale fazla
 * istiyor (5 → 7).
 *
 * DÖNEM (madde 5.4 ve 5.5): doçentlikte doktora/uzmanlık/sanatta yeterlik
 * sonrası, profesörlükte doçentlik başvuru döneminin son başvuru tarihinden
 * sonraki çalışmalar sayılıyor. Dr. Öğr. Üyeliğinde (ilk atama) dönem kaydı yok.
 *
 * DERGİ KÜMESİ İKİ TÜRLÜ:
 *   WoS Q1-Q3   Eğitim, Fen, Mühendislik, Sağlık, Spor, Ziraat
 *   TR Dizin    Filoloji, Güzel Sanatlar, Hukuk, İlahiyat
 *   karma       Mimarlık ve Sosyal — "en az biri WoS CC (ESCI hariç)"
 * TR Dizin isteyen tablolarda dipnot 2 "WoS CC dergilerdeki makaleler de bu
 * kapsamda kullanılabilir" dediği için WoS maddeleri de kümeye dahil.
 *
 * GİRİLMEYEN: Ek 4 listesinin tek tek kalemleri (idari görev, ödül, danışmanlık
 * vb.) — "en az beş tanesini sağlamak" biçiminde sayılıyor ama listenin kendisi
 * puan üretmiyor; tek `beyan` düğümü olarak duruyor. Ayrıca doçent ve profesör
 * koşullarındaki A/B/C alternatifleri (proje yürütücülüğü, kitap, patent) da
 * beyan — "en az birini sağlamak" biçiminde alternatif kümeler.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/cukurova-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

/**
 * EK 1'in on iki tablosu. Her satır bir temel alan.
 *
 * @var array<string, array{
 *     alan: string,
 *     tablo: string,
 *     kume: list<string>,
 *     kumeAdi: string,
 *     dr: int,
 *     doc: int,
 *     prof: int,
 *     docBaslica: int,
 *     docPuan: int,
 *     profPuan: int
 * }>
 */
$tablolar = [
    'egitim' => ['alan' => 'egitim', 'tablo' => 'Tablo 1. Eğitim Bilimleri', 'kume' => ['WOS-Q1Q3'], 'kumeAdi' => 'WoS CC Q1, Q2 veya Q3 sınıfı dergilerde',
        'dr' => 1, 'doc' => 3, 'prof' => 3, 'docBaslica' => 2, 'docPuan' => 180, 'profPuan' => 240],
    'fen' => ['alan' => 'fen', 'tablo' => 'Tablo 2. Fen Bilimleri ve Matematik', 'kume' => ['WOS-Q1Q3'], 'kumeAdi' => 'WoS CC Q1, Q2 veya Q3 sınıfı dergilerde',
        'dr' => 3, 'doc' => 4, 'prof' => 4, 'docBaslica' => 2, 'docPuan' => 240, 'profPuan' => 300],
    'filoloji' => ['alan' => 'filoloji', 'tablo' => 'Tablo 3. Filoloji', 'kume' => ['M-TR', 'WOS-Q1Q3'], 'kumeAdi' => 'TR Dizin dergilerde',
        'dr' => 3, 'doc' => 6, 'prof' => 6, 'docBaslica' => 3, 'docPuan' => 120, 'profPuan' => 150],
    'guzel_sanatlar' => ['alan' => 'guzel_sanatlar', 'tablo' => 'Tablo 4. Güzel Sanatlar', 'kume' => ['M-TR', 'WOS-Q1Q3'], 'kumeAdi' => 'TR Dizin dergilerde',
        'dr' => 2, 'doc' => 4, 'prof' => 4, 'docBaslica' => 2, 'docPuan' => 50, 'profPuan' => 50],
    'hukuk' => ['alan' => 'hukuk', 'tablo' => 'Tablo 5. Hukuk', 'kume' => ['M-TR', 'WOS-Q1Q3'], 'kumeAdi' => 'TR Dizin dergilerde',
        'dr' => 3, 'doc' => 6, 'prof' => 6, 'docBaslica' => 3, 'docPuan' => 120, 'profPuan' => 150],
    'ilahiyat' => ['alan' => 'ilahiyat', 'tablo' => 'Tablo 6. İlahiyat', 'kume' => ['M-TR', 'WOS-Q1Q3'], 'kumeAdi' => 'TR Dizin dergilerde',
        'dr' => 3, 'doc' => 6, 'prof' => 6, 'docBaslica' => 3, 'docPuan' => 120, 'profPuan' => 150],
    'mimarlik' => ['alan' => 'mimarlik', 'tablo' => 'Tablo 7. Mimarlık, Planlama ve Tasarım', 'kume' => ['MAKALE'], 'kumeAdi' => 'en az biri WoS CC (ESCI hariç) dergilerde olmak üzere',
        'dr' => 3, 'doc' => 5, 'prof' => 7, 'docBaslica' => 3, 'docPuan' => 120, 'profPuan' => 150],
    'muhendislik' => ['alan' => 'muhendislik', 'tablo' => 'Tablo 8. Mühendislik', 'kume' => ['WOS-Q1Q3'], 'kumeAdi' => 'WoS CC Q1, Q2 veya Q3 sınıfı dergilerde',
        'dr' => 3, 'doc' => 4, 'prof' => 4, 'docBaslica' => 2, 'docPuan' => 240, 'profPuan' => 300],
    'saglik' => ['alan' => 'saglik', 'tablo' => 'Tablo 9. Sağlık Bilimleri', 'kume' => ['WOS-Q1Q3'], 'kumeAdi' => 'WoS CC Q1, Q2 veya Q3 sınıfı dergilerde',
        'dr' => 1, 'doc' => 4, 'prof' => 4, 'docBaslica' => 2, 'docPuan' => 180, 'profPuan' => 240],
    'sosyal' => ['alan' => 'sosyal', 'tablo' => 'Tablo 10. Sosyal, Beşerî ve İdari Bilimler', 'kume' => ['MAKALE'], 'kumeAdi' => 'en az biri WoS CC (ESCI hariç) dergilerde olmak üzere',
        'dr' => 3, 'doc' => 5, 'prof' => 7, 'docBaslica' => 3, 'docPuan' => 120, 'profPuan' => 150],
    'spor' => ['alan' => 'spor', 'tablo' => 'Tablo 11. Spor Bilimleri', 'kume' => ['WOS-Q1Q3'], 'kumeAdi' => 'WoS CC Q1, Q2 veya Q3 sınıfı dergilerde',
        'dr' => 3, 'doc' => 3, 'prof' => 3, 'docBaslica' => 2, 'docPuan' => 180, 'profPuan' => 240],
    'ziraat' => ['alan' => 'ziraat', 'tablo' => 'Tablo 12. Ziraat, Orman ve Su Ürünleri', 'kume' => ['WOS-Q1Q3'], 'kumeAdi' => 'WoS CC Q1, Q2 veya Q3 sınıfı dergilerde',
        'dr' => 3, 'doc' => 4, 'prof' => 4, 'docBaslica' => 2, 'docPuan' => 240, 'profPuan' => 300],
];

/**
 * Güzel Sanatlar tablosunun yalnızca kendisinde bulunan sanat etkinliği koşulu
 * (Tablo 4, Dr. Öğr. Üyesi sütunu 3. madde).
 *
 * @return list<array<string, mixed>>
 */
$sanatEtkinligi = function (string $alan): array {
    if ($alan !== 'guzel_sanatlar') {
        return [];
    }

    return [Kalip::beyan('Başvurduğunuz bilim/sanat alanı için kültür ve sanat kurumlarında '
        .'gerçekleştirilmiş en az bir kişisel sanat etkinliğinde (sergi, gösteri, dinleti, '
        .'tasarım uygulaması vb.) bulunmuş olmak', 'Tablo 4')];
};

/**
 * Doçent ve profesörün ortak "yayın + bildiri + alternatif" bloğu.
 *
 * @param  list<string>  $kume
 * @param  array<string, mixed>  $donem
 * @return list<array<string, mixed>>
 */
$yayinBlogu = function (array $kume, string $kumeAdi, int $makale, int $baslica, int $bildiri, array $donem, string $tablo): array {
    // Kapanış imzasındaki `@param list<string>` çözümlemede taşınmadığı için
    // liste biçimi burada yeniden kuruluyor.
    $kume = array_values($kume);

    return [
        Kalip::adet("{$kumeAdi} en az {$baslica}'sinde başlıca yazar olduğunuz en az {$makale} makale",
            $kume, $makale, 'baslica', $donem, madde: $tablo),
        Kalip::adet("Bilimsel toplantılarda sunulmuş en az {$bildiri} bildiri",
            ['BILDIRI'], $bildiri, donem: $donem, madde: $tablo),
        Kalip::beyan('Ulusal veya uluslararası kuruluşlarca desteklenen bir araştırma projesinde '
            .'yürütücü veya araştırmacı olarak görev almış olmak; ya da tabloda sayılan A/B/C '
            .'seçeneklerinden (WoS dergide üniversite adresli yayın, uluslararası yayınevi kitabı, '
            .'tescilli patent) en az birini sağlamak', $tablo),
    ];
};

$esikler = [];

foreach ($tablolar as $t) {
    // Düğüm başlığı adaya gösteriliyor: tablo numarası değil alan adı yazılır
    // (KONVANSIYONLAR §2). `notlar` tablo numarasını olduğu gibi koruyor.
    $alanAdi = preg_replace('/^Tablo \d+\. /u', '', $t['tablo']);

    $esikler[] = [
        'anahtar' => "cukurova-dr-{$t['alan']}",
        'aday_notu' => 'Dr. Öğretim Üyeliğinde asgari puan barajı yok; yalnızca makale ve bildiri sayısı aranıyor. '
            .'Yeniden atanmada (madde 5.3) aynı ölçütlerin bir önceki atanmadan sonraki çalışmalarla yeniden sağlanması gerekir.',
        'universite' => 'Çukurova Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => [$t['alan']],
        'cetvel' => 'cukurova-2024',
        'notlar' => "EK 1 {$t['tablo']}, Doktor Öğretim Üyesi sütunu. Madde 5.2: Ek 1 asgari ölçütleri Ek 2 akademik etkinlikleri ile karşılanmalı.",
        'sart' => Kalip::ve("Dr. Öğr. Üyesi — {$alanAdi}", [
            Kalip::adet("{$t['kumeAdi']} en az birinde başlıca yazar olduğunuz en az {$t['dr']} makale",
                $t['kume'], $t['dr'], 'baslica', madde: $t['tablo']),
            Kalip::adet('Bilimsel toplantılarda sunulmuş en az bir bildiri', ['BILDIRI'], 1, madde: $t['tablo']),
            ...$sanatEtkinligi($t['alan']),
        ]),
    ];

    $esikler[] = [
        'anahtar' => "cukurova-docent-{$t['alan']}",
        'aday_notu' => 'Yalnızca doktora, uzmanlık veya sanatta yeterlik eğitiminizi tamamladıktan sonraki çalışmalarınız sayılır. '
            .'Ayrıca yönergenin genel akademik etkinlik listesinden en az beşini sağlamanız gerekiyor.',
        'universite' => 'Çukurova Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => [$t['alan']],
        'cetvel' => 'cukurova-2024',
        'notlar' => "EK 1 {$t['tablo']}, Doçent sütunu: asgari puan {$t['docPuan']}. Madde 5.4: doktora/uzmanlık/sanatta yeterlik sonrası çalışmalar, Ek 4'ten en az beş etkinlik.",
        'sart' => Kalip::ve("Doçent — {$alanAdi}", [
            Kalip::beyan('Üniversitelerarası Kuruldan doçentlik unvanı almış olmak', 'Madde 5.4'),
            Kalip::toplam($t['docPuan'], Kalip::DOKTORA_SONRASI),
            ...$yayinBlogu($t['kume'], $t['kumeAdi'], $t['doc'], $t['docBaslica'], 3, Kalip::DOKTORA_SONRASI, $t['tablo']),
            Kalip::beyan('Yönergenin genel akademik etkinlik listesinden en az beş tanesini sağlamak', 'Madde 5.4'),
        ]),
    ];

    $esikler[] = [
        'anahtar' => "cukurova-profesor-{$t['alan']}",
        'aday_notu' => 'Yalnızca doçent unvanını almaya hak kazandığınız başvuru döneminin son başvuru tarihinden sonraki '
            .'çalışmalarınız sayılır. Genel akademik etkinlik listesinden en az yedi etkinlik gerekiyor.',
        'universite' => 'Çukurova Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => [$t['alan']],
        'cetvel' => 'cukurova-2024',
        'notlar' => "EK 1 {$t['tablo']}, Profesör sütunu: asgari puan {$t['profPuan']}. Madde 5.5: doçentlik başvuru dönemi sonrası çalışmalar, Ek 4'ten en az yedi etkinlik.",
        'sart' => Kalip::ve("Profesör — {$alanAdi}", [
            Kalip::toplam($t['profPuan'], Kalip::DOCENTLIK_SONRASI),
            ...$yayinBlogu($t['kume'], $t['kumeAdi'], $t['prof'], $t['docBaslica'], 3, Kalip::DOCENTLIK_SONRASI, $t['tablo']),
            Kalip::beyan('Yayınlarınızdan birini başlıca araştırma eseri olarak göstermek', 'Madde 5.5'),
            Kalip::beyan('Yönergenin genel akademik etkinlik listesinden en az yedi tanesini sağlamak', 'Madde 5.5'),
        ]),
    ];
}

return $esikler;
