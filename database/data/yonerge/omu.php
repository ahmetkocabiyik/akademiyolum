<?php

/**
 * ONDOKUZ MAYIS ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma
 * Yönergesi
 * Kaynak: pdf/17634002431.Ondokuz Mayıs Üniversitesi Kriter.pdf (Mayıs 2025)
 *
 * ÜÇ TEMEL ALAN GRUBU (Madde 4/e):
 *   A  Fen Bilimleri ve Matematik · Mühendislik · Mimarlık, Planlama ve
 *      Tasarım · Sağlık Bilimleri · Ziraat, Orman ve Su Ürünleri
 *   B  Eğitim Bilimleri · Filoloji · Hukuk · İlahiyat · Sosyal, Beşeri ve
 *      İdari Bilimler · Spor Bilimleri
 *   C  Güzel Sanatlar
 *
 * KATEGORİ ARALIĞININ ÜST SINIRI ALAN GRUBUNA GÖRE DEĞİŞİYOR — bu yönergenin
 * en kolay yanlış okunan yeri. Hepsi "1-10 kategorilerinden" ile başlıyor ama
 * ikinci baraj A'da 1-14, B'de 1-15, C'de 1-16 kategorilerinden. C ayrıca tek
 * başına 16. kategoriden (sanatsal etkinlik) de baraj istiyor:
 *
 *              1-10        ikinci baraj              16. kategori
 *   Dr    A    120         1-14 ≥ 200                —
 *         B    120         1-15 ≥ 200                —
 *         C     50         1-16 ≥ 200                60
 *   Doç   A    360         1-14 ≥ 750                —
 *         B    330         1-15 ≥ 500                —
 *         C    150         1-16 ≥ 500                180
 *   Prof  A    720 (360*)  1-14 ≥ 1500               —
 *         B    660 (330*)  1-15 ≥ 1000               —
 *         C    300 (150*)  1-16 ≥ 1000               360
 *   (*) parantez içindeki kısmın doçentlik unvanı sonrası olması şartıyla.
 *
 * ORTAK ŞARTLAR: her kadroda "beşinci bölüm puanlı maddelerden N tanesini ve
 * altıncı bölüm puansız maddelerden N tanesini sağlamak" (Dr 2+2, doçent 4+4,
 * profesör 5+5). Bu bölümler yönergenin kendi metnindeki nitelik listeleri —
 * yurt dışı araştırma, ödül, danışmanlık gibi — ve faaliyet kaydından
 * türetilemedikleri için beyan olarak duruyor.
 *
 * 16. KATEGORİ BARAJI ARTIK GERÇEK BİR PUAN KOŞULU. C grubunun sanatsal
 * etkinlik barajı (60 · 180 · 360) cetvelde yalnız üç satır varken de
 * `puanDan` olarak duruyordu ama kaba ölçüyordu; 02.09.2026'da 16. bölümün
 * on yedi bendi girilince baraj kaynağın kademeleriyle ölçülür oldu.
 *
 * MADDE 11/4-a'NIN "en az 1 jürili kişisel sanatsal etkinlik" KOŞULU HÂLÂ
 * BEYAN. Sayının kendisi artık hesaplanabilir (16.3, 16.5, 16.10 ve 16.12
 * jürili kişisel bentler), ama koşul yalnızca "Sanat ve Tasarım alanında
 * sanatta yeterlik veya doktora yapanlar" için geçerli ve profil doktoranın
 * hangi alanda yapıldığını taşımıyor. Koşulu düğüme çevirmek, kuralın
 * bağlamadığı adaya da "sağlanmadı" gösterirdi.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/omu-2025.php
 */

use App\Services\Scoring\Sart\Kalip;

$P = Kalip::DOCENTLIK_SONRASI;

/**
 * Bir temel alan grubunun üç kadrosunu üretir.
 *
 * @param  list<string>  $alanlar
 * @param  array{int, int, int}  $dr  1-10 · ikinci baraj · 16. kategori (0 ise yok)
 * @param  array{int, int, int}  $docent
 * @param  array{int, int, int, int}  $profesor  1-10 · doçentlik sonrası 1-10 · ikinci · 16.
 * @return list<array<string, mixed>>
 */
$grup = function (
    string $anahtar,
    string $ad,
    array $alanlar,
    string $ikinciKume,
    array $dr,
    array $docent,
    array $profesor,
    array $drMakale,
    array $profMakale,
) use ($P): array {
    $alanlar = array_values($alanlar);

    // Cetvel (alan grubu × kadro) ile varyantlanıyor: 5, 7 ve 12. bölümlerin
    // tavanları "1-10 asgari puanının yüzdesi" ve o taban her kadroda farklı.
    $cetvel = fn (string $kadro): string => "omu-2025-{$anahtar}-{$kadro}";

    /** @return list<array<string, mixed>> */
    $sanat = fn (int $puan, ?array $donem, string $madde) => $puan > 0
        ? [Kalip::puanDan("Sanatsal etkinliklerinizden en az {$puan} puan", ['16'], $puan, $donem, madde: $madde)]
        : [];

    return [
        [
            'anahtar' => "omu-dr-{$anahtar}",
            'aday_notu' => 'Ayrıca yönergenin beşinci bölümündeki puanlı maddelerden 2, altıncı '
                .'bölümündeki puansız maddelerden 2 tanesini sağlamanız gerekiyor. Ticarileştirilmiş '
                .'patenti olanlarda bu şart aranmıyor.',
            'universite' => 'Ondokuz Mayıs Üniversitesi',
            'kadro' => 'dr_ogr_uyesi',
            'alan' => $alanlar,
            'cetvel' => $cetvel('dr'),
            'notlar' => "Madde 11: 1-10 kategorilerinden {$dr[0]}, {$ikinciKume} kategorilerinden {$dr[1]} puan.",
            'sart' => Kalip::ve("Dr. Öğr. Üyesi — {$ad} temel alanları", [
                Kalip::yds(65),
                Kalip::puanDan("Yayın, proje, patent ve tez danışmanlığı kalemlerinizden en az {$dr[0]} puan",
                    ['1-10'], $dr[0], madde: 'Madde 11 · 1-10'),
                Kalip::puanDan("Tüm kalemlerinizden en az {$dr[1]} puan",
                    [$ikinciKume], $dr[1], madde: "Madde 11 · {$ikinciKume}"),
                ...$sanat($dr[2], null, 'Madde 11 · 16'),
                ...array_values($drMakale),
                Kalip::beyan('Beşinci bölüm puanlı maddelerden en az 2, altıncı bölüm puansız '
                    .'maddelerden en az 2 tanesini sağlamak', 'Madde 11/1-c'),
            ]),
        ],
        [
            'anahtar' => "omu-docent-{$anahtar}",
            'aday_notu' => 'Beşinci bölüm puanlı maddelerden 4, altıncı bölüm puansız maddelerden 4 '
                .'tanesi doktora sonrası sağlanmalı.',
            'universite' => 'Ondokuz Mayıs Üniversitesi',
            'kadro' => 'docentlik',
            'alan' => $alanlar,
            'cetvel' => $cetvel('doc'),
            'notlar' => "Madde 12: 1-10 kategorilerinden {$docent[0]}, {$ikinciKume} kategorilerinden {$docent[1]} puan.",
            'sart' => Kalip::ve("Doçent — {$ad} temel alanları", [
                Kalip::beyan('ÜAK tarafından verilen doçentlik unvanını almış olmak', 'Madde 12/1-a'),
                Kalip::beyan('ÜAK jürilerince yapılan sözlü sınavda başarılı olmak', 'Madde 12/1-b'),
                Kalip::puanDan("Yayın, proje, patent ve tez danışmanlığı kalemlerinizden en az {$docent[0]} puan",
                    ['1-10'], $docent[0], madde: 'Madde 12 · 1-10'),
                Kalip::puanDan("Tüm kalemlerinizden en az {$docent[1]} puan",
                    [$ikinciKume], $docent[1], madde: "Madde 12 · {$ikinciKume}"),
                ...$sanat($docent[2], null, 'Madde 12 · 16'),
                Kalip::beyan('Beşinci bölüm puanlı maddelerden doktora sonrası en az 4, altıncı bölüm '
                    .'puansız maddelerden en az 4 tanesini sağlamak', 'Madde 12/1-c'),
            ]),
        ],
        [
            'anahtar' => "omu-profesor-{$anahtar}",
            'aday_notu' => 'Birinci barajın bir kısmının doçentlik unvanı sonrası kazanılmış olması '
                .'şartı var; ekranda iki ayrı satır olarak gösteriliyor.',
            'universite' => 'Ondokuz Mayıs Üniversitesi',
            'kadro' => 'profesorluk',
            'alan' => $alanlar,
            'cetvel' => $cetvel('prof'),
            'notlar' => "Madde 13: 1-10 kategorilerinden {$profesor[0]} (en az {$profesor[1]} doçentlik sonrası), {$ikinciKume} kategorilerinden {$profesor[2]} puan.",
            'sart' => Kalip::ve("Profesör — {$ad} temel alanları", [
                Kalip::puanDan("Yayın, proje, patent ve tez danışmanlığı kalemlerinizden en az {$profesor[0]} puan",
                    ['1-10'], $profesor[0], madde: 'Madde 13 · 1-10'),
                Kalip::puanDan("Bunun en az {$profesor[1]} puanı doçentlik unvanınızdan sonra olmalı",
                    ['1-10'], $profesor[1], $P, madde: 'Madde 13 · 1-10 (dönem)'),
                Kalip::puanDan("Tüm kalemlerinizden en az {$profesor[2]} puan",
                    [$ikinciKume], $profesor[2], madde: "Madde 13 · {$ikinciKume}"),
                ...$sanat($profesor[3], $P, 'Madde 13 · 16'),
                ...array_values($profMakale),
                Kalip::beyan('Beşinci bölüm puanlı maddelerden doçentlik sonrası en az 5, altıncı '
                    .'bölüm puansız maddelerden en az 5 tanesini sağlamak', 'Madde 13/1-a'),
            ]),
        ],
    ];
};

return [
    // ══════════ A TEMEL ALANLARI ══════════
    ...$grup('a', 'A', ['fen', 'muhendislik', 'mimarlik', 'saglik', 'ziraat'], '1-14',
        [120, 200, 0], [360, 750, 0], [720, 360, 1500, 0],
        [Kalip::adet('SCI, SCIE, SSCI veya AHCI dergilerinde en az birinde başlıca yazar olduğunuz 2 makale',
            ['1.1'], 2, 'baslica', madde: 'Madde 11/2-b')],
        [Kalip::adet('Doçentlik sonrası SCI, SCIE, SSCI veya AHCI dergilerinde en az birinde başlıca '
            .'yazar olduğunuz 3 makale', ['1.1'], 3, 'baslica', Kalip::DOCENTLIK_SONRASI, madde: 'Madde 13/2-a')]),

    // ══════════ B TEMEL ALANLARI ══════════
    ...$grup('b', 'B', ['egitim', 'filoloji', 'hukuk', 'ilahiyat', 'sosyal', 'spor'], '1-15',
        [120, 200, 0], [330, 500, 0], [660, 330, 1000, 0],
        [Kalip::veya('Makale koşulu (seçeneklerden biri)', [
            Kalip::adet('SCI, SCIE, SSCI veya AHCI dergisinde başlıca yazar olduğunuz en az 1 makale',
                ['1.1'], 1, 'baslica', madde: 'Madde 11/3-a'),
            Kalip::adet('Ya da ESCI/Scopus dergilerinde en az birinde başlıca yazar olduğunuz 2 makale',
                ['2.1'], 2, 'baslica', madde: 'Madde 11/3-a'),
            Kalip::adet('Ya da (hukuk, filoloji ve ilahiyat için) TR Dizin dergilerinde en az ikisinde '
                .'başlıca yazar olduğunuz makaleler', ['3.1'], 2, 'baslica', madde: 'Madde 11/3-a'),
        ])],
        [Kalip::veya('Makale koşulu (seçeneklerden biri)', [
            Kalip::adet('Doçentlik sonrası SCI, SCIE, SSCI veya AHCI dergisinde başlıca yazar olduğunuz en az 1 makale',
                ['1.1'], 1, 'baslica', Kalip::DOCENTLIK_SONRASI, madde: 'Madde 13/3-a'),
            Kalip::adet('Ya da doçentlik sonrası ESCI/Scopus dergilerinde en az ikisinde başlıca yazar '
                .'olduğunuz makaleler', ['2.1'], 2, 'baslica', Kalip::DOCENTLIK_SONRASI, madde: 'Madde 13/3-a'),
        ])]),

    // ══════════ C TEMEL ALANI (Güzel Sanatlar) ══════════
    ...$grup('c', 'C', ['guzel_sanatlar'], '1-16',
        [50, 200, 60], [150, 500, 180], [300, 150, 1000, 360],
        [
            Kalip::adet('WoS, ESCI/Scopus veya TR Dizin dergilerinde en az birinde başlıca yazar '
                .'olduğunuz 2 makale', ['1.1-2.1-3.1'], 2, 'baslica', madde: 'Madde 11/4-a'),
            Kalip::beyan('Sanat ve Tasarım alanında sanatta yeterlik veya doktora yapanlar için en az '
                .'1 adet jürili kişisel sanatsal etkinlik', 'Madde 11/4-a'),
        ],
        [
            Kalip::adet('Doçentlik sonrası WoS, ESCI/Scopus veya TR Dizin dergilerinde en az birinde '
                .'başlıca yazar olduğunuz 3 makale', ['1.1-2.1-3.1'], 3, 'baslica', Kalip::DOCENTLIK_SONRASI,
                madde: 'Madde 13/4-a'),
        ]),
];
