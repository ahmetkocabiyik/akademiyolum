<?php

/**
 * BATMAN ÜNİVERSİTESİ — Akademik Yükseltilme ve Atanma Kriterleri Yönergesi
 * Kaynak: pdf/17536931322.batmanuniverstesi.pdf
 *         (30.05.2024 ve 15.08.2024 senato değişiklikleriyle)
 *
 * ÜAK CETVELİNİN KOD DÜZENİ KULLANILIYOR: makale kalemleri 1a-Q1…1d, grup '1'
 * bunların tamamı. Batman'ın kendi kodu olmadığı için koşullar ÜAK kodlarına
 * bağlandı.
 *
 * PUANLAMAYI ÜAK'A DEVREDİYOR. Yönergenin kendi puan cetveli yok; koşullar
 * "güncel Yükseköğretim Kurulu Doçentlik Şartlarında belirtilen
 * faaliyetlerden en az 30 puan" diyor. Bu yüzden cetvel `uak-2024-mart-{alan}`
 * — ÜAK her temel alan için ayrı tablo yayımladığı için alan başına çözülüyor.
 * Korpusta aynı deseni Bursa Uludağ da kullanıyor.
 *
 * ÜÇ ALAN GRUBU, YALNIZCA DR. ÖĞR. ÜYELİĞİNDE AYRIŞIYOR (Madde 9/2):
 *   Fen, Mühendislik, Sağlık   en az biri SCI/SCI-E/SSCI'de olmak üzere,
 *                              indeksli dergilerde 2 makale
 *   Sosyal                     SSCI/SCI/AHCI/ESCI/Scopus/TR Dizin'de 2 makale
 *                              YA DA diğer hakemli dergilerde 4 makale
 *   Güzel Sanatlar, Spor       TR Dizin'de 1 makale YA DA diğer hakemli
 *                              dergilerde 2 makale
 * Doçentlik ve profesörlükte alan ayrımı yok; koşullar 2547 sayılı Kanuna ve
 * ÜAK doçentlik şartlarına atıf yapıyor.
 *
 * "ENERJİ" İHTİSASLAŞMA ÇARPANI GİRİLMEDİ (Madde 8): üniversitenin
 * ihtisaslaşma alanı enerji olduğu için, anahtar kelimeleri arasında enerji
 * geçen çalışmaların puanı 1,2 ile çarpılıyor. Faaliyet kaydı anahtar kelime
 * tutmadığı için bu çarpan uygulanamıyor; enerji alanında çalışan adayın
 * gerçek puanı burada görünenden YÜKSEK olur.
 *
 * DOÇENTLİKTE PUAN BARAJI YOK, bu kasıtlı: Madde 11 yalnızca doçentlik unvanı
 * ve yabancı dil şartı koyuyor. Profesörlükte de kendi puan tablosu yerine
 * "ÜAK doçentlik koşullarını bir kez daha sağlamış olmak" deniyor — bu
 * doğrulanabilir bir puan barajı olmadığı için beyan.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip
 */

use App\Services\Scoring\Sart\Kalip;

/**
 * Dr. Öğr. Üyeliğinde her alan grubunda tekrarlayan gövde.
 *
 * @param  list<string>  $alanlar
 * @param  list<array<string, mixed>>  $makale
 * @return array<string, mixed>
 */
$dr = function (string $anahtar, string $ad, array $alanlar, array $makale, string $madde): array {
    return [
        'anahtar' => "batman-dr-{$anahtar}",
        'aday_notu' => 'Yeniden atanmada her atama yılı için ÜAK Doçentlik Şartları tablosundan '
            .'en az 8 puan gerekiyor ve bunun en az yarısı makale, proje, kitap veya patent '
            .'kaleminden olmalı.',
        'universite' => 'Batman Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => array_values($alanlar),
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => "Madde 9/2-{$madde} ve 9/3 ({$ad}): yayın şartı + ÜAK faaliyetlerinden en az 30 puan.",
        'sart' => Kalip::ve("Dr. Öğr. Üyesi — {$ad}", [
            Kalip::yds(60),
            ...array_values($makale),
            Kalip::toplam(30, liste: 'ÜAK Doçentlik Şartları'),
        ]),
    ];
};

return [
    // ══════════ FEN, MÜHENDİSLİK VE SAĞLIK BİLİMLERİ ══════════
    $dr('fen', 'Fen, Mühendislik ve Sağlık Bilimleri', ['fen', 'muhendislik', 'saglik', 'ziraat'], [
        Kalip::adet('SCI, SCI-Expanded veya SSCI dergilerinde en az 1 makale',
            ['1a-Q1', '1a-Q2', '1a-Q3', '1a-Q4'], 1, madde: 'Madde 9/2-a'),
        Kalip::adet('İndeksli hakemli dergilerde toplam en az 2 makale',
            ['1'], 2, madde: 'Madde 9/2-a'),
    ], 'a'),

    // ══════════ SOSYAL BİLİMLER ══════════
    $dr('sosyal', 'Sosyal Bilimler', ['sosyal', 'egitim', 'filoloji', 'hukuk', 'ilahiyat'], [
        Kalip::veya('Makale koşulu (iki seçenekten biri)', [
            Kalip::adet('SSCI, SCI, AHCI, ESCI, Scopus veya TR Dizin dergilerinde en az 2 makale',
                ['1'], 2, madde: 'Madde 9/2-b'),
            Kalip::adet('Ya da diğer ulusal/uluslararası hakemli dergilerde en az 4 makale',
                ['*'], 4, madde: 'Madde 9/2-b'),
        ]),
    ], 'b'),

    // ══════════ GÜZEL SANATLAR VE SPOR BİLİMLERİ ══════════
    $dr('guzel-sanatlar', 'Güzel Sanatlar ve Spor Bilimleri', ['guzel_sanatlar', 'spor', 'mimarlik'], [
        Kalip::veya('Makale koşulu (iki seçenekten biri)', [
            Kalip::adet('TR Dizin dergilerinde en az 1 makale', ['1'], 1, madde: 'Madde 9/2-c'),
            Kalip::adet('Ya da diğer ulusal/uluslararası hakemli dergilerde en az 2 makale',
                ['*'], 2, madde: 'Madde 9/2-c'),
        ]),
    ], 'c'),

    // ══════════ DOÇENT ve PROFESÖR (alan ayrımı yok) ══════════
    [
        'anahtar' => 'batman-docent',
        'aday_notu' => 'Batman yönergesi doçentlik için kendi puan tablosunu uygulamıyor; '
            .'Madde 11 yalnızca doçentlik unvanı ve yabancı dil şartı koyuyor. Burada puan '
            .'barajı görmüyorsunuz — eksik veri değil, yönergede öyle.',
        'universite' => 'Batman Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['fen', 'muhendislik', 'saglik', 'ziraat', 'sosyal', 'egitim', 'filoloji',
            'hukuk', 'ilahiyat', 'guzel_sanatlar', 'spor', 'mimarlik'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 11: doçentlik unvanı, yurt dışı belgede ÜAK denkliği ve YDS 65.',
        'sart' => Kalip::ve('Doçent — Batman Üniversitesi', [
            Kalip::beyan('2547 sayılı Kanunun 24. maddesi uyarınca doçent unvanına sahip olmak; '
                .'yurt dışından doçentlik belgesi olanlarda Üniversitelerarası Kurul denkliği', 'Madde 11/1'),
            Kalip::yds(65),
        ]),
    ],
    [
        'anahtar' => 'batman-profesor',
        'aday_notu' => 'Ön koşul, ÜAK doçentlik başvuru koşullarını doçent unvanınızı aldıktan '
            .'sonra bir kez daha sağlamış olmanız (lisansüstü tezlerden gelen zorunlu asgari '
            .'puanlardan muaf tutularak). Bu doğrulanabilir tek bir baraj olmadığı için beyan.',
        'universite' => 'Batman Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['fen', 'muhendislik', 'saglik', 'ziraat', 'sosyal', 'egitim', 'filoloji',
            'hukuk', 'ilahiyat', 'guzel_sanatlar', 'spor', 'mimarlik'],
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 12: doçentlik sonrası beş yıl çalışma + ÜAK doçentlik koşullarını bir kez daha sağlama.',
        'sart' => Kalip::ve('Profesör — Batman Üniversitesi', [
            Kalip::beyan('Doçent unvanını aldıktan sonra en az beş yıl süreyle, açık bulunan '
                .'profesörlük kadrosuyla ilgili bilim alanında çalışmış olmak', 'Madde 12/1-a'),
            Kalip::beyan('Doçent unvanını aldıktan sonra ÜAK Doçentliğe Yükseltilme Başvuru '
                .'Koşullarını ilgili bilim alanı için en az bir kez daha sağlamış olmak '
                .'(lisansüstü tezlerden gelen zorunlu asgari puanlardan muaf)', 'Madde 12/1-b'),
        ]),
    ],
];
