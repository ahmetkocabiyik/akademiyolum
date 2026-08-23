<?php

/**
 * SELÇUK ÜNİVERSİTESİ — Öğretim Üyeliği Kadrolarına Atanma ve Yükseltme
 * Kriterleri Yönergesi
 * Kaynak: pdf/17537007702.selcukuniverstesi.pdf (93 sayfa)
 *
 * İKİ KATMANLI: Tablo 2 bütün alanlarda AYNI toplam puan barajlarını veriyor,
 * her temel alan ise kendi "Temel Alan Özel Kriterleri" bloğunda bölüm bazlı
 * ALT barajlar koyuyor ("Atıflar bölümünden en az 15 puan" gibi). Alt barajlar
 * asıl ayırt edici koşullar; toplam baraj çoğu adayda zaten sağlanıyor.
 *
 * TABLO 2 — bütün temel alanlarda ortak:
 *   Dr. Öğr. Üyesi   ilk atanma 70 · yeniden atanma 35
 *   Doçent           doktoradan sonra 120 · toplam 140
 *   Profesör         doçentlik unvanı sonrası 140 · toplam 280
 *
 * BÖLÜM NUMARALARI ALANLAR ARASINDA KAYIYOR. Özel kriterler bölüme ADIYLA atıf
 * yapıyor ("Makaleler bölümü", "Atıflar bölümü") ama cetveldeki numara alandan
 * alana değişiyor: Eğitim ve Hukuk'ta makale iki ayrı bölüm (1 Uluslararası,
 * 2 Ulusal), Fen'de tek bölüm; atıf Eğitim'de 4, Fen'de 3, Güzel Sanatlar'da 5.
 * Bu yüzden her alan bloğunun başına bölüm eşlemesi yorum olarak yazıldı ve
 * koşullar o alanın kendi numarasını kullanıyor.
 *
 * "YENİDEN ATANMA" ayrı bir kadro olarak modellenmiyor; motorun kadro listesi
 * ilk atamayı tanıyor, o yüzden Dr. Öğr. Üyesi eşiği ilk atanma koşullarını
 * taşıyor ve yeniden atanma barajı aday notunda anılıyor.
 *
 * TEZDEN ÜRETİLMİŞ OLMA koşulları (`beyan`): birçok alan "adayın doktora
 * tezinden üretilmiş olmak koşulu ile en az N puan" istiyor. Bir yayının
 * tezden üretilip üretilmediği faaliyet kaydında tutulmuyor; puan koşulu
 * doğrulanabilse de tez bağı doğrulanamadığı için düğüm bütünüyle beyan.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/selcuk-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

/** Tablo 2, Dr. Öğr. Üyesi ilk atanma. */
$TOPLAM_DR = 70;

/**
 * Bir temel alanın üç kadrosunu birden üretir.
 *
 * @param  list<array<string, mixed>>  $dr
 * @param  list<array<string, mixed>>  $docent
 * @param  list<array<string, mixed>>  $profesor
 * @return list<array<string, mixed>>
 */
$alan = function (string $alan, string $ad, array $dr, array $docent, array $profesor, ?string $ekNot = null) use ($TOPLAM_DR): array {
    // Kapanış imzasındaki `@param list<...>` çözümlemede taşınmıyor; koşul
    // listeleri liste biçimine burada yeniden kavuşuyor.
    $dr = array_values($dr);
    $docent = array_values($docent);
    $profesor = array_values($profesor);

    return [
        [
            'anahtar' => "selcuk-dr-{$alan}",
            'aday_notu' => 'Bu koşullar İLK KEZ ATANMA içindir. Yeniden atanmada (görev uzatma) toplam '
                .'baraj 35 puana iner ve yalnızca en son atanma tarihinden sonraki çalışmalarınız sayılır.',
            'universite' => 'Selçuk Üniversitesi',
            'kadro' => 'dr_ogr_uyesi',
            'alan' => [$alan],
            'cetvel' => "selcuk-2024-{$alan}",
            'notlar' => "Tablo 2 ilk atanma {$TOPLAM_DR} puan; {$ad} Özel Kriterleri I- İlk Kez Atanma.",
            'sart' => Kalip::ve("Dr. Öğr. Üyesi — {$ad}", [Kalip::toplam($TOPLAM_DR), ...$dr]),
        ],
        [
            'anahtar' => "selcuk-docent-{$alan}",
            'aday_notu' => 'Bütün koşullar doktora, uzmanlık veya sanatta yeterlik unvanınızı aldıktan '
                .'sonraki çalışmalarla sağlanmalı.'.($ekNot !== null ? ' '.$ekNot : ''),
            'universite' => 'Selçuk Üniversitesi',
            'kadro' => 'docentlik',
            'alan' => [$alan],
            'cetvel' => "selcuk-2024-{$alan}",
            'notlar' => "Tablo 2 doktoradan sonra 120, toplam 140; {$ad} Özel Kriterleri B- Doçent.",
            'sart' => Kalip::ve("Doçent — {$ad}", [
                Kalip::beyan('Üniversitelerarası Kuruldan doçentlik unvanı almış olmak', 'Tablo 2'),
                Kalip::toplam(140),
                Kalip::toplam(120, Kalip::DOKTORA_SONRASI),
                ...$docent,
            ]),
        ],
        [
            'anahtar' => "selcuk-profesor-{$alan}",
            'aday_notu' => 'Bütün koşullar doçentlik unvanınızı aldıktan sonraki çalışmalarla sağlanmalı. '
                .'Başvuru Şartları Tablosu puanlaması doçentlik öncesi ve sonrası için ayrı ayrı iki defa '
                .'kullanılabiliyor.'.($ekNot !== null ? ' '.$ekNot : ''),
            'universite' => 'Selçuk Üniversitesi',
            'kadro' => 'profesorluk',
            'alan' => [$alan],
            'cetvel' => "selcuk-2024-{$alan}",
            'notlar' => "Tablo 2 doçentlik sonrası 140, toplam 280; {$ad} Özel Kriterleri C- Profesör.",
            'sart' => Kalip::ve("Profesör — {$ad}", [
                Kalip::toplam(280),
                Kalip::toplam(140, Kalip::DOCENTLIK_SONRASI),
                ...$profesor,
            ]),
        ],
    ];
};

/** Doçentlikte doktora sonrası, profesörlükte doçentlik sonrası kapsam. */
$D = Kalip::DOKTORA_SONRASI;
$P = Kalip::DOCENTLIK_SONRASI;

/**
 * "X bölümünden en az N puan" — özel kriterlerin en sık tekrarlayan cümlesi.
 *
 * @param  list<string>  $maddeler
 * @return array<string, mixed>
 */
$bolumden = function (string $bolum, array $maddeler, int $puan, ?array $donem, string $madde): array {
    return Kalip::puanDan("{$bolum} bölümünden en az {$puan} puan", array_values($maddeler), $puan, $donem, madde: $madde);
};

/**
 * "… bendi kapsamında en az N eserde başlıca yazar olmak".
 *
 * @param  list<string>  $maddeler
 * @return array<string, mixed>
 */
$baslica = function (string $bent, array $maddeler, int $adet, ?array $donem, string $madde): array {
    return Kalip::adet("{$bent} kapsamında başlıca yazar olduğunuz en az {$adet} eser",
        array_values($maddeler), $adet, 'baslica', $donem, madde: $madde);
};

return [
    // ══════════ EĞİTİM BİLİMLERİ ══════════
    // 1 Uluslararası Makale · 2 Ulusal Makale · 3 Kitap · 4 Atıf · 5 Tez
    // 6 Proje · 7 Bilimsel Toplantı · 8 Eğitim-Öğretim
    ...$alan('egitim', 'Eğitim Bilimleri', [
        $baslica('Uluslararası Makale bölümü "a ve/veya b" bendi', ['1a', '1b'], 1, null, 'Özel Kriterler I-a'),
        $bolumden('Uluslararası Makale "a ve/veya b" bendi', ['1a', '1b'], 20, null, 'Özel Kriterler I-a'),
        $baslica('Ulusal Makale bölümü "a" bendi', ['2a'], 1, null, 'Özel Kriterler I-b'),
        $bolumden('Ulusal Makale "a" bendi', ['2a'], 20, null, 'Özel Kriterler I-b'),
        Kalip::beyan('Doktora tezinden üretilmiş olmak koşulu ile "Uluslararası Makale ve/veya Ulusal '
            .'Makale" bölümü kapsamında en az 5 puan almış olmak', 'Özel Kriterler I-c'),
        $bolumden('Bilimsel Toplantı Faaliyeti (tam metin ve sözlü sunum)', ['7*'], 3, null, 'Özel Kriterler I-d'),
    ], [
        $baslica('Uluslararası Makale bölümü "a ve/veya b" bendi', ['1a', '1b'], 2, $D, 'Özel Kriterler B-a'),
        $bolumden('Uluslararası Makaleler', ['1*'], 40, $D, 'Özel Kriterler B-a'),
        $baslica('Ulusal Makale bölümü "a" bendi', ['2a'], 2, $D, 'Özel Kriterler B-b'),
        $bolumden('Ulusal Makale', ['2*'], 40, $D, 'Özel Kriterler B-b'),
        $baslica('Bilimsel Toplantı Faaliyeti bölümü (tam metin ve sözlü sunum)', ['7*'], 2, $D, 'Özel Kriterler B-c'),
        $bolumden('Bilimsel Toplantı Faaliyeti', ['7*'], 10, $D, 'Özel Kriterler B-c'),
        $bolumden('Atıflar', ['4*'], 15, $D, 'Özel Kriterler B-d'),
        $bolumden('Bilimsel Araştırma Projeleri', ['6*'], 4, $D, 'Özel Kriterler B-e'),
    ], [
        $baslica('Uluslararası Makale bölümü "a ve/veya b" bendi', ['1a', '1b'], 2, $P, 'Özel Kriterler C-a'),
        $bolumden('Uluslararası Makaleler', ['1*'], 40, $P, 'Özel Kriterler C-a'),
        $baslica('Ulusal Makale bölümü "a" bendi', ['2a'], 2, $P, 'Özel Kriterler C-b'),
        $bolumden('Ulusal Makale', ['2*'], 40, $P, 'Özel Kriterler C-b'),
        $baslica('Bilimsel Toplantı Faaliyeti bölümü (tam metin ve sözlü sunum)', ['7*'], 2, $P, 'Özel Kriterler C-c'),
        $bolumden('Bilimsel Toplantı Faaliyeti', ['7*'], 10, $P, 'Özel Kriterler C-c'),
        $bolumden('Atıflar', ['4*'], 20, $P, 'Özel Kriterler C-d'),
        Kalip::adet('Bilimsel araştırma projelerinin en az birinde yürütücülük yapmak', ['6a'], 1, donem: $P, madde: 'Özel Kriterler C-e'),
        $bolumden('Bilimsel Araştırma Projeleri', ['6*'], 8, $P, 'Özel Kriterler C-e'),
    ]),

    // ══════════ FEN BİLİMLERİ VE MATEMATİK ══════════
    // 1 Makaleler · 2 Kitap · 3 Atıf · 4 Tez · 5 Proje · 6 Bilimsel Toplantı · 7 Eğitim-Öğretim
    ...$alan('fen', 'Fen Bilimleri ve Matematik', [
        $bolumden('Makaleler "a" bendi', ['1a'], 15, null, 'Özel Kriterler I-a'),
        $bolumden('Makaleler', ['1*'], 30, null, 'Özel Kriterler I-a'),
        Kalip::beyan('Doktora tezinden üretilmiş olmak üzere Makaleler bölümü "a, b, c ve/veya d" bendi '
            .'kapsamında en az 5 puan almış olmak', 'Özel Kriterler I-b'),
        $bolumden('Bilimsel Toplantı Faaliyeti "a" bendi (doktora yeterliliği sonrası, tam metin ve sözlü sunum)', ['6a'], 3, null, 'Özel Kriterler I-c'),
        $bolumden('Bilimsel Araştırma Projesi', ['5*'], 4, null, 'Özel Kriterler I-d'),
    ], [
        $baslica('Makaleler bölümü "a" bendi', ['1a'], 2, $D, 'Özel Kriterler B-a'),
        $bolumden('Makaleler', ['1*'], 55, $D, 'Özel Kriterler B-a'),
        $bolumden('Bilimsel Toplantı Faaliyeti "a" bendi (başlıca yazar, tam metin ve sözlü sunum)', ['6a'], 5, $D, 'Özel Kriterler B-b'),
        $bolumden('Atıflar', ['3*'], 15, $D, 'Özel Kriterler B-c'),
        $bolumden('Bilimsel Araştırma Projesi', ['5*'], 8, $D, 'Özel Kriterler B-d'),
    ], [
        $baslica('Makaleler bölümü "a" bendi', ['1a'], 2, $P, 'Özel Kriterler C-a'),
        $bolumden('Makaleler', ['1*'], 55, $P, 'Özel Kriterler C-a'),
        $bolumden('Bilimsel Toplantı Faaliyeti "a" bendi (başlıca yazar, tam metin ve sözlü sunum)', ['6a'], 5, $P, 'Özel Kriterler C-b'),
        $bolumden('Atıflar', ['3*'], 20, $P, 'Özel Kriterler C-c'),
        $bolumden('Bilimsel Araştırma Projesi', ['5*'], 12, $P, 'Özel Kriterler C-d'),
    ], 'Aktüerya, İstatistik ve Matematik bölümlerinde makale barajı 55 yerine 40 puan ve '
        .'başlıca yazarlık iki eser yerine bir eser olarak uygulanıyor; motor bölüm ayrımı '
        .'yapmadığı için burada yüksek olan koşul gösteriliyor.'),

    // ══════════ FİLOLOJİ ══════════
    ...$alan('filoloji', 'Filoloji', [
        $baslica('Makaleler bölümü', ['1*'], 1, null, 'Özel Kriterler I-a'),
        $bolumden('Makaleler', ['1*'], 40, null, 'Özel Kriterler I-a'),
        $bolumden('Bilimsel Toplantı Faaliyeti', ['6*'], 5, null, 'Özel Kriterler I-b'),
    ], [
        $baslica('Makaleler bölümü "a ve/veya b" bendi', ['1a', '1b'], 1, $D, 'Özel Kriterler B-a'),
        $bolumden('Makaleler "a ve/veya b" bendi', ['1a', '1b'], 20, $D, 'Özel Kriterler B-a'),
        $bolumden('Makaleler', ['1*'], 40, $D, 'Özel Kriterler B-a'),
        $bolumden('Bilimsel Toplantı Faaliyeti (başlıca yazar)', ['6*'], 5, $D, 'Özel Kriterler B-b'),
        $bolumden('Atıflar', ['3*'], 15, $D, 'Özel Kriterler B-c'),
        $bolumden('Bilimsel Araştırma Projeleri', ['5*'], 4, $D, 'Özel Kriterler B-d'),
    ], [
        $baslica('Makaleler bölümü "a ve/veya b" bendi', ['1a', '1b'], 1, $P, 'Özel Kriterler C-a'),
        $bolumden('Makaleler "a ve/veya b" bendi', ['1a', '1b'], 20, $P, 'Özel Kriterler C-a'),
        $bolumden('Makaleler', ['1*'], 40, $P, 'Özel Kriterler C-a'),
        Kalip::beyan('Kitap bölümünden en az bir adet TEK YAZARLI kitap veya kitap bölümü yapmış olmak',
            'Özel Kriterler C-b'),
        $bolumden('Bilimsel Toplantı Faaliyeti (başlıca yazar)', ['6*'], 5, $P, 'Özel Kriterler C-c'),
        $bolumden('Atıflar', ['3*'], 20, $P, 'Özel Kriterler C-d'),
        Kalip::adet('Bilimsel araştırma projelerinin birinde yürütücülük yapmak', ['5a'], 1, donem: $P, madde: 'Özel Kriterler C-e'),
        $bolumden('Bilimsel Araştırma Projeleri', ['5*'], 4, $P, 'Özel Kriterler C-e'),
    ]),

    // ══════════ GÜZEL SANATLAR ══════════
    // 1 Makaleler · 2 Sanatsal Etkinlikler · 4 Bilimsel Toplantı · 5 Atıf
    // 6 Proje · 7 Tez · 8 Eğitim-Öğretim  (3. bölüm yok)
    ...$alan('guzel_sanatlar', 'Güzel Sanatlar', [
        Kalip::beyan('Yüksek lisans tezinden üretilmiş olmak koşulu ile "Makaleler ve/veya Bilimsel '
            .'Toplantı Faaliyeti" kapsamında en az 1 puan almış olmak', 'Özel Kriterler I-a'),
        Kalip::beyan('Doktora veya sanatta yeterlik tezinden üretilmiş olmak koşulu ile Makaleler bölümü '
            .'"a, b, c ve/veya d" bendi kapsamında en az 5 puan almış olmak', 'Özel Kriterler I-b'),
        $baslica('Makaleler bölümü "a, b ve/veya c" bendi', ['1a', '1b', '1c'], 1, null, 'Özel Kriterler I-c'),
        $bolumden('Makaleler "a, b ve/veya c" bendi', ['1a', '1b', '1c'], 20, null, 'Özel Kriterler I-c'),
        $bolumden('Bilimsel Toplantı Faaliyeti', ['4*'], 5, null, 'Özel Kriterler I-d'),
        $bolumden('Sanatsal Etkinlikler (özgün sanat eserleri)', ['2*'], 30, null, 'Özel Kriterler I-e'),
    ], [
        $baslica('Makaleler bölümü "a, b ve/veya c" bendi', ['1a', '1b', '1c'], 2, $D, 'Özel Kriterler B-a'),
        $bolumden('Makaleler', ['1*'], 30, $D, 'Özel Kriterler B-a'),
        $bolumden('Bilimsel Toplantı Faaliyeti (başlıca yazar)', ['4*'], 10, $D, 'Özel Kriterler B-b'),
        $bolumden('Sanatsal Etkinlik', ['2*'], 50, $D, 'Özel Kriterler B-c'),
        $bolumden('Atıflar', ['5*'], 10, $D, 'Özel Kriterler B-d'),
    ], [
        $baslica('Makaleler bölümü', ['1*'], 2, $P, 'Özel Kriterler C-a'),
        $bolumden('Makaleler', ['1*'], 30, $P, 'Özel Kriterler C-a'),
        Kalip::adet('Sanatsal Etkinlik bölümünde en az iki KİŞİSEL etkinlik',
            ['2a-kisisel', '2b-kisisel'], 2, donem: $P, madde: 'Özel Kriterler C-b'),
        $bolumden('Sanatsal Etkinlik', ['2*'], 50, $P, 'Özel Kriterler C-b'),
        $bolumden('Bilimsel Toplantı Faaliyeti (başlıca yazar)', ['4*'], 10, $P, 'Özel Kriterler C-c'),
        $bolumden('Atıflar', ['5*'], 15, $P, 'Özel Kriterler C-d'),
    ]),

    // ══════════ HUKUK ══════════
    // 1 Uluslararası Makale · 2 Ulusal Makale · 3 Kitap · 4 Atıf · 5 Tez
    // 6 Proje · 7 Bilimsel Toplantı
    // Makale koşulu İKİ SEÇENEKLİ: ya uluslararası makalede başlıca yazarlık,
    // ya ulusal makalede tek yazarlılık — ikincisinde baraj yükseliyor.
    ...$alan('hukuk', 'Hukuk', [
        Kalip::veya('Makale koşulu (iki seçenekten biri)', [
            Kalip::ve('Uluslararası makalede başlıca yazar', [
                $baslica('Uluslararası Makale bölümü', ['1*'], 1, null, 'Özel Kriterler I-a'),
                $bolumden('Uluslararası ve/veya Ulusal Makale', ['1*', '2*'], 30, null, 'Özel Kriterler I-a'),
            ]),
            Kalip::ve('Ulusal makalede tek yazar', [
                Kalip::beyan('Ulusal Makale "a" bendinden TEK YAZARLI olarak en az 30 puan '
                    .'almış olmak', 'Özel Kriterler I-a'),
                $bolumden('Uluslararası ve/veya Ulusal Makale', ['1*', '2*'], 40, null, 'Özel Kriterler I-a'),
            ]),
        ]),
        $bolumden('Bilimsel Toplantı Faaliyeti (tam metin ve sözlü sunum)', ['7*'], 3, null, 'Özel Kriterler I-b'),
    ], [
        Kalip::veya('Makale koşulu (iki seçenekten biri)', [
            Kalip::ve('Uluslararası makalede başlıca yazar', [
                $baslica('Uluslararası Makale bölümü', ['1*'], 1, $D, 'Özel Kriterler B-a'),
                $bolumden('Uluslararası ve/veya Ulusal Makale', ['1*', '2*'], 60, $D, 'Özel Kriterler B-a'),
            ]),
            Kalip::ve('Ulusal makalede tek yazar', [
                Kalip::beyan('Ulusal Makale "a" bendinden TEK YAZARLI olarak en az 40 puan '
                    .'almış olmak', 'Özel Kriterler B-a'),
                $bolumden('Uluslararası ve/veya Ulusal Makale', ['1*', '2*'], 80, $D, 'Özel Kriterler B-a'),
            ]),
        ]),
        Kalip::beyan('Başvurduğunuz doçentlik bilim alanı ile ilgili olmak koşulu ile Kitap bölümü '
            .'"a ve/veya c" bendi kapsamında TEK YAZARLI kitap çalışmasından en az 25 puan almış olmak',
            'Özel Kriterler B-b'),
        $bolumden('Atıflar', ['4*'], 15, $D, 'Özel Kriterler B-c'),
        $bolumden('Bilimsel Toplantı Faaliyeti (başlıca yazar, tam metin ve sözlü sunum)', ['7*'], 6, $D, 'Özel Kriterler B-d'),
    ], [
        Kalip::veya('Makale koşulu (iki seçenekten biri)', [
            Kalip::ve('Uluslararası makalede başlıca yazar', [
                $baslica('Uluslararası Makale bölümü', ['1*'], 1, $P, 'Özel Kriterler C-a'),
                $bolumden('Uluslararası ve/veya Ulusal Makale', ['1*', '2*'], 60, $P, 'Özel Kriterler C-a'),
            ]),
            Kalip::ve('Ulusal makalede tek yazar', [
                Kalip::beyan('Ulusal Makale "a" bendinden TEK YAZARLI olarak en az 60 puan '
                    .'almış olmak', 'Özel Kriterler C-a'),
                $bolumden('Uluslararası ve/veya Ulusal Makale', ['1*', '2*'], 80, $P, 'Özel Kriterler C-a'),
            ]),
        ]),
        Kalip::beyan('Kitap bölümü "a ve/veya c" bendi kapsamında TEK YAZARLI olarak en az 25 puan '
            .'almış olmak', 'Özel Kriterler C-b'),
        $bolumden('Atıflar', ['4*'], 20, $P, 'Özel Kriterler C-c'),
        $bolumden('Bilimsel Toplantı Faaliyeti (başlıca yazar, tam metin ve sözlü sunum)', ['7*'], 8, $P, 'Özel Kriterler C-d'),
    ]),

    // ══════════ İLAHİYAT ══════════
    ...$alan('ilahiyat', 'İlahiyat', [
        $baslica('Makaleler bölümü "a, b ve/veya c" bendi', ['1a', '1b', '1c'], 1, null, 'Özel Kriterler I-a'),
        $bolumden('Makaleler "a, b ve/veya c" bendi', ['1a', '1b', '1c'], 30, null, 'Özel Kriterler I-a'),
        Kalip::beyan('Doktora tezinden üretilmiş olmak üzere Makaleler bölümü "a, b ve/veya c" bendi '
            .'ve/veya Bilimsel Toplantı Faaliyeti kapsamında en az 5 puan almış olmak', 'Özel Kriterler I-b'),
        $bolumden('Bilimsel Toplantı Faaliyeti (başlıca yazar, tam metin ve sözlü sunum)', ['6*'], 3, null, 'Özel Kriterler I-c'),
    ], [
        $baslica('Makaleler bölümü "a ve/veya b" bendi', ['1a', '1b'], 1, $D, 'Özel Kriterler B-a'),
        $bolumden('Makaleler "a, b ve/veya c" bendi', ['1a', '1b', '1c'], 50, $D, 'Özel Kriterler B-a'),
        Kalip::beyan('Kitap bölümü "a ve/veya c" bendi kapsamında TEK YAZARLI olarak en az 20 puan '
            .'almış olmak', 'Özel Kriterler B-b'),
        $bolumden('Atıflar', ['3*'], 15, $D, 'Özel Kriterler B-c'),
        $bolumden('Bilimsel Toplantı Faaliyeti (başlıca yazar, tam metin ve sözlü sunum)', ['6*'], 6, $D, 'Özel Kriterler B-d'),
    ], [
        $baslica('Makaleler bölümü "a ve/veya b" bendi', ['1a', '1b'], 1, $P, 'Özel Kriterler C-a'),
        $bolumden('Makaleler "a, b ve/veya c" bendi', ['1a', '1b', '1c'], 60, $P, 'Özel Kriterler C-a'),
        Kalip::beyan('Kitap bölümü "a ve/veya c" bendi kapsamında TEK YAZARLI olarak en az 20 puan '
            .'almış olmak', 'Özel Kriterler C-b'),
        $bolumden('Atıflar', ['3*'], 20, $P, 'Özel Kriterler C-c'),
        $bolumden('Bilimsel Toplantı Faaliyeti (başlıca yazar, tam metin ve sözlü sunum)', ['6*'], 6, $P, 'Özel Kriterler C-d'),
    ]),

    // ══════════ MİMARLIK VE TASARIM ══════════
    // 1 Makaleler · 2 Kitap · 3 Yarışma/Uygulama/Yazılım · 4 Atıf · 5 Tez
    // 6 Proje · 7 Bilimsel Toplantı · 8 Eğitim-Öğretim
    ...$alan('mimarlik', 'Mimarlık ve Tasarım', [
        Kalip::beyan('Yüksek lisans tezinden üretilmiş olmak koşulu ile "Makaleler ve/veya Bilimsel '
            .'Toplantı Faaliyeti" bölümü kapsamında en az 1 puan almış olmak', 'Özel Kriterler I-a'),
        Kalip::beyan('Doktora tezinden üretilmiş olmak koşulu ile Makaleler bölümü "a, b ve/veya c" bendi '
            .'kapsamında en az 5 puan almış olmak', 'Özel Kriterler I-b'),
        $baslica('Makaleler bölümü "a ve/veya b" bendi', ['1a', '1b'], 1, null, 'Özel Kriterler I-c'),
        $bolumden('Makaleler', ['1*'], 25, null, 'Özel Kriterler I-c'),
        $bolumden('Bilimsel Toplantı Faaliyeti "a" bendi (tam metin ve sözlü sunum)', ['7a'], 3, null, 'Özel Kriterler I-d'),
        $bolumden('Bilimsel Araştırma Projesi', ['6*'], 4, null, 'Özel Kriterler I-e'),
    ], [
        $baslica('Makaleler bölümü "a ve/veya b" bendi', ['1a', '1b'], 2, $D, 'Özel Kriterler B-a'),
        $bolumden('Makaleler', ['1*'], 40, $D, 'Özel Kriterler B-a'),
        $baslica('Bilimsel Toplantı Faaliyeti bölümü (tam metin ve sözlü sunum)', ['7*'], 2, $D, 'Özel Kriterler B-b'),
        $bolumden('Bilimsel Toplantı Faaliyeti', ['7*'], 6, $D, 'Özel Kriterler B-b'),
        $bolumden('Atıflar', ['4*'], 15, $D, 'Özel Kriterler B-c'),
        $bolumden('Bilimsel Araştırma Projesi', ['6*'], 4, $D, 'Özel Kriterler B-d'),
        $bolumden('Eğitim-Öğretim Faaliyeti', ['8*'], 4, $D, 'Özel Kriterler B-e'),
    ], [
        $baslica('Makaleler bölümü "a ve/veya b" bendi', ['1a', '1b'], 2, $P, 'Özel Kriterler C-a'),
        $bolumden('Makaleler', ['1*'], 40, $P, 'Özel Kriterler C-a'),
        $baslica('Bilimsel Toplantı Faaliyeti bölümü (tam metin ve sözlü sunum)', ['7*'], 2, $P, 'Özel Kriterler C-b'),
        $bolumden('Bilimsel Toplantı Faaliyeti', ['7*'], 8, $P, 'Özel Kriterler C-b'),
        $bolumden('Atıflar', ['4*'], 20, $P, 'Özel Kriterler C-c'),
        Kalip::adet('Bilimsel araştırma projelerinin birinde yürütücülük yapmak', ['6a'], 1, donem: $P, madde: 'Özel Kriterler C-d'),
        $bolumden('Bilimsel Araştırma Projesi', ['6*'], 8, $P, 'Özel Kriterler C-d'),
    ]),

    // ══════════ MÜHENDİSLİK ══════════
    // 1 Makaleler · 2 Kitap · 3 Atıf · 4 Tez · 5 Proje · 6 Bilimsel Toplantı
    // 7 Eğitim-Öğretim · 8 Patent
    // Patent, makalede başlıca yazarlık koşuluna EŞDEĞER sayılıyor; bu yüzden
    // başlıca yazarlık düğümü patent telafisi taşıyor.
    ...$alan('muhendislik', 'Mühendislik', [
        $baslica('Makaleler bölümü "a ve/veya b" bendi', ['1a', '1b'], 1, null, 'Özel Kriterler I-a'),
        $bolumden('Makaleler', ['1*'], 30, null, 'Özel Kriterler I-a'),
        $bolumden('Bilimsel Toplantı Faaliyeti "a" bendi (tam metin ve sözlü sunum)', ['6a'], 3, null, 'Özel Kriterler I-b'),
    ], [
        Kalip::adet('Makaleler bölümü "a" bendi kapsamında başlıca yazar olduğunuz en az 1 eser',
            ['1a'], 1, 'baslica', $D,
            telafi: Kalip::adet('Patent/Faydalı Model bölümü "a ve/veya b" bendi kapsamında en az 1 tescil',
                ['8a', '8b'], 1, donem: $D),
            madde: 'Özel Kriterler B-a'),
        $bolumden('Makaleler', ['1*'], 55, $D, 'Özel Kriterler B-a'),
        $bolumden('Bilimsel Toplantı Faaliyeti "a" bendi (tam metin ve sözlü sunum)', ['6a'], 5, $D, 'Özel Kriterler B-b'),
        $bolumden('Atıflar', ['3*'], 15, $D, 'Özel Kriterler B-c'),
        $bolumden('Bilimsel Araştırma Projesi', ['5*'], 8, $D, 'Özel Kriterler B-d'),
    ], [
        Kalip::adet('Makaleler bölümü "a" bendi kapsamında başlıca yazar olduğunuz en az 2 eser',
            ['1a'], 2, 'baslica', $P,
            telafi: Kalip::adet('Patent/Faydalı Model bölümü "a ve/veya b" bendi kapsamında en az 2 tescil',
                ['8a', '8b'], 2, donem: $P),
            madde: 'Özel Kriterler C-a'),
        $bolumden('Makaleler', ['1*'], 55, $P, 'Özel Kriterler C-a'),
        $bolumden('Bilimsel Toplantı Faaliyeti "a" bendi (tam metin ve sözlü sunum)', ['6a'], 5, $P, 'Özel Kriterler C-b'),
        $bolumden('Atıflar "a" bendi', ['3a'], 20, $P, 'Özel Kriterler C-c'),
        $bolumden('Bilimsel Araştırma Projesi', ['5*'], 12, $P, 'Özel Kriterler C-d'),
        $bolumden('Eğitim-Öğretim Faaliyetleri', ['7*'], 4, $P, 'Özel Kriterler C-e'),
    ]),

    // ══════════ SAĞLIK BİLİMLERİ ══════════
    ...$alan('saglik', 'Sağlık Bilimleri', [
        Kalip::beyan('Doktora veya uzmanlık tezinden üretilmiş olmak koşulu ile Makaleler bölümü '
            .'"a, b, c ve/veya d" bendi kapsamında en az 5 puan almış olmak', 'Özel Kriterler I-a'),
        $baslica('Makaleler bölümü "a ve/veya b" bendi', ['1a', '1b'], 1, null, 'Özel Kriterler I-b'),
        $bolumden('Makaleler', ['1*'], 30, null, 'Özel Kriterler I-b'),
        $bolumden('Bilimsel Toplantı Faaliyeti "a" bendi (doktora yeterliliği sonrası, özet veya tam metin, sözlü sunum)', ['6a'], 3, null, 'Özel Kriterler I-c'),
    ], [
        $baslica('Makaleler bölümü "a" bendi', ['1a'], 3, $D, 'Özel Kriterler B-a'),
        $bolumden('Makaleler', ['1*'], 55, $D, 'Özel Kriterler B-a'),
        $bolumden('Bilimsel Toplantı Faaliyeti "a" bendi (başlıca yazar, özet veya tam metin, sözlü sunum)', ['6a'], 5, $D, 'Özel Kriterler B-b'),
        $bolumden('Atıflar', ['3*'], 15, $D, 'Özel Kriterler B-c'),
        $bolumden('Bilimsel Araştırma Projesi', ['5*'], 4, $D, 'Özel Kriterler B-d'),
    ], [
        $baslica('Makaleler bölümü "a" bendi', ['1a'], 3, $P, 'Özel Kriterler C-a'),
        $bolumden('Makaleler', ['1*'], 55, $P, 'Özel Kriterler C-a'),
        $bolumden('Bilimsel Toplantı Faaliyeti "a" bendi (özet veya tam metin, sözlü sunum)', ['6a'], 5, $P, 'Özel Kriterler C-b'),
        $bolumden('Atıflar "a" bendi', ['3a'], 20, $P, 'Özel Kriterler C-c'),
        Kalip::adet('Bilimsel araştırma projelerinin birinde yürütücülük yapmak', ['5a'], 1, donem: $P, madde: 'Özel Kriterler C-d'),
        $bolumden('Bilimsel Araştırma Projesi', ['5*'], 8, $P, 'Özel Kriterler C-d'),
    ]),

    // ══════════ SOSYAL, BEŞERÎ VE İDARİ BİLİMLER ══════════
    ...$alan('sosyal', 'Sosyal, Beşerî ve İdari Bilimler', [
        Kalip::beyan('Yüksek lisans ve doktora tezlerinden üretilmiş olmak üzere Makaleler ve/veya '
            .'Bilimsel Toplantı Faaliyeti bölümü kapsamında en az 1 puan almış olmak', 'Özel Kriterler I-a'),
        $baslica('Makaleler bölümü "a, b ve/veya c" bendi', ['1a', '1b', '1c'], 1, null, 'Özel Kriterler I-b'),
        $bolumden('Makaleler', ['1*'], 30, null, 'Özel Kriterler I-b'),
        $bolumden('Bilimsel Toplantı Faaliyeti (başlıca yazar)', ['6*'], 5, null, 'Özel Kriterler I-c'),
        $bolumden('Atıflar', ['3*'], 15, null, 'Özel Kriterler I-d'),
        $bolumden('Bilimsel Araştırma Projesi', ['5*'], 4, null, 'Özel Kriterler I-e'),
    ], [
        $baslica('Makaleler bölümü "a ve/veya b" bendi', ['1a', '1b'], 1, $D, 'Özel Kriterler B-a'),
        $bolumden('Makaleler', ['1*'], 60, $D, 'Özel Kriterler B-a'),
        $bolumden('Bilimsel Toplantı Faaliyeti (başlıca yazar)', ['6*'], 6, $D, 'Özel Kriterler B-b'),
        $bolumden('Atıflar', ['3*'], 15, $D, 'Özel Kriterler B-c'),
        $bolumden('Bilimsel Araştırma Projesi', ['5*'], 8, $D, 'Özel Kriterler B-d'),
        $bolumden('Eğitim-Öğretim Faaliyeti', ['7*'], 4, $D, 'Özel Kriterler B-e'),
    ], [
        $baslica('Makaleler bölümü "a ve/veya b" bendi', ['1a', '1b'], 1, $P, 'Özel Kriterler C-a'),
        $bolumden('Makaleler', ['1*'], 80, $P, 'Özel Kriterler C-a'),
        $bolumden('Bilimsel Toplantı Faaliyeti (başlıca yazar)', ['6*'], 8, $P, 'Özel Kriterler C-b'),
        $bolumden('Atıflar', ['3*'], 20, $P, 'Özel Kriterler C-c'),
        $bolumden('Bilimsel Araştırma Projesi', ['5*'], 8, $P, 'Özel Kriterler C-d'),
        $bolumden('Lisansüstü Tez Danışmanlığı', ['4*'], 6, $P, 'Özel Kriterler C-e'),
        $bolumden('Eğitim-Öğretim Faaliyeti', ['7*'], 4, $P, 'Özel Kriterler C-f'),
    ]),

    // ══════════ SPOR BİLİMLERİ ══════════
    // 8. bölüm "Sportif Başarı ve Temsil" — kaynak sözlüğünde karşılığı yok,
    // cetvele girmedi; özel kriterler de o bölümden puan istemiyor.
    ...$alan('spor', 'Spor Bilimleri', [
        Kalip::beyan('Yüksek lisans tezinden üretilmiş olmak koşulu ile "Makaleler ve/veya Bilimsel '
            .'Toplantı Faaliyeti" bölümü kapsamında en az 1 puan almış olmak', 'Özel Kriterler I-a'),
        Kalip::beyan('Doktora tezinden üretilmiş olmak koşulu ile Makaleler bölümü "a, b, c ve/veya d" '
            .'bendi veya Bilimsel Toplantı Faaliyeti bölümü kapsamında en az 5 puan almış olmak', 'Özel Kriterler I-b'),
        $baslica('Makaleler bölümü "a ve/veya b" bendi', ['1a', '1b'], 1, null, 'Özel Kriterler I-c'),
        $bolumden('Makaleler "a ve/veya b" bendi', ['1a', '1b'], 30, null, 'Özel Kriterler I-c'),
        $bolumden('Bilimsel Toplantı Faaliyeti "a" bendi (tam metin ve sözlü sunum)', ['6a'], 3, null, 'Özel Kriterler I-d'),
        $bolumden('Bilimsel Araştırma Projesi', ['5*'], 4, null, 'Özel Kriterler I-e'),
    ], [
        $baslica('Makaleler bölümü "a" bendi', ['1a'], 2, $D, 'Özel Kriterler B-a'),
        $bolumden('Makaleler', ['1*'], 55, $D, 'Özel Kriterler B-a'),
        $bolumden('Bilimsel Toplantı Faaliyeti "a" bendi (başlıca yazar, tam metin ve sözlü sunum)', ['6a'], 6, $D, 'Özel Kriterler B-b'),
        $bolumden('Atıflar', ['3*'], 15, $D, 'Özel Kriterler B-c'),
        $bolumden('Bilimsel Araştırma Projesi', ['5*'], 4, $D, 'Özel Kriterler B-d'),
    ], [
        $baslica('Makaleler bölümü "a" bendi', ['1a'], 2, $P, 'Özel Kriterler C-a'),
        $bolumden('Makaleler', ['1*'], 55, $P, 'Özel Kriterler C-a'),
        $bolumden('Bilimsel Toplantı Faaliyeti (tam metin ve sözlü sunum)', ['6*'], 8, $P, 'Özel Kriterler C-b'),
        $bolumden('Atıflar "a" bendi', ['3a'], 20, $P, 'Özel Kriterler C-c'),
        Kalip::adet('Bilimsel araştırma projelerinin en az birinde yürütücülük yapmak', ['5a'], 1, donem: $P, madde: 'Özel Kriterler C-d'),
        $bolumden('Bilimsel Araştırma Projesi', ['5*'], 8, $P, 'Özel Kriterler C-d'),
        $bolumden('Eğitim-Öğretim Faaliyeti', ['7*'], 2, $P, 'Özel Kriterler C-e'),
    ]),

    // ══════════ ZİRAAT ══════════
    ...$alan('ziraat', 'Ziraat', [
        Kalip::beyan('Yüksek lisans tezinden üretilmiş olmak koşulu ile "Makaleler ve/veya Bilimsel '
            .'Toplantı Faaliyeti" bölümü kapsamında en az 1 puan almış olmak', 'Özel Kriterler I-a'),
        Kalip::beyan('Doktora tezinden üretilmiş olmak koşulu ile Makaleler bölümü "a, b, c ve/veya d" '
            .'bendi kapsamında en az 5 puan almış olmak', 'Özel Kriterler I-b'),
        $baslica('Makaleler bölümü "a" bendi', ['1a'], 1, null, 'Özel Kriterler I-c'),
        $bolumden('Makaleler', ['1*'], 30, null, 'Özel Kriterler I-c'),
        $bolumden('Bilimsel Toplantı Faaliyeti "a" bendi (doktora yeterliliği sonrası, tam metin ve sözlü sunum)', ['6a'], 3, null, 'Özel Kriterler I-d'),
        $bolumden('Bilimsel Araştırma Projesi', ['5*'], 4, null, 'Özel Kriterler I-e'),
    ], [
        $baslica('Makaleler bölümü "a" bendi', ['1a'], 2, $D, 'Özel Kriterler B-a'),
        $bolumden('Makaleler', ['1*'], 55, $D, 'Özel Kriterler B-a'),
        $bolumden('Bilimsel Toplantı Faaliyeti "a" bendi (başlıca yazar, tam metin ve sözlü sunum)', ['6a'], 5, $D, 'Özel Kriterler B-b'),
        $bolumden('Atıflar', ['3*'], 15, $D, 'Özel Kriterler B-c'),
        $bolumden('Bilimsel Araştırma Projesi', ['5*'], 8, $D, 'Özel Kriterler B-d'),
    ], [
        $baslica('Makaleler bölümü "a" bendi', ['1a'], 2, $P, 'Özel Kriterler C-a'),
        $bolumden('Makaleler', ['1*'], 55, $P, 'Özel Kriterler C-a'),
        $bolumden('Bilimsel Toplantı Faaliyeti "a" bendi (tam metin ve sözlü sunum)', ['6a'], 5, $P, 'Özel Kriterler C-b'),
        $bolumden('Atıflar "a" bendi', ['3a'], 20, $P, 'Özel Kriterler C-c'),
        Kalip::adet('Bilimsel araştırma projelerinin en az birinde yürütücülük yapmak', ['5a'], 1, donem: $P, madde: 'Özel Kriterler C-d'),
        $bolumden('Bilimsel Araştırma Projesi', ['5*'], 8, $P, 'Özel Kriterler C-d'),
    ]),
];
