<?php

use App\Services\Scoring\Sart\Kalip;

/**
 * İSTANBUL 29 MAYIS ÜNİVERSİTESİ — Öğretim Üyeliğine Atama ve Yükseltme
 * Kriterleri
 * Kaynak: pdf/17537098732.istanbul29mayisuniversitesi.pdf
 * (Senato kararı 30.01.2017; YÖK Genel Kurulu 15.02.2017)
 *
 * Cetvel: cetvel/istanbul-29-mayis-2017.php
 *
 * ── EŞİKLERİN YAPISI ──
 * Doktor öğretim üyeliği (metinde 2018 öncesi adıyla "yardımcı doçentlik")
 * bütün birimler için ortak: hakemli bir dergide en az bir makale YA DA
 * MADDE 8 tablosundan 15 puan. Doçentlik ve profesörlükte ise kriterler
 * yalnızca ÜÇ TEMEL ALAN için yazılmış (Filoloji, İlahiyat ile Sosyal,
 * Beşerî ve İdari Bilimler) ve her birinde iki baraj var: MADDE 8/1
 * (tezden üretilmemiş yayınlar) alt barajı ile tablonun tamamından toplam.
 *
 * ── YORUM KARARLARI (§0) ──
 *   Yönerge doçentlik ve profesörlük için yalnız Filoloji, İlahiyat ve
 *       Sosyal-Beşerî-İdari Bilimler temel alanlarını düzenliyor.
 *       Üniversitede bu alanlar dışında bir kadro ilan edilirse hangi
 *       eşiğin uygulanacağı yazılı değil; §0 gereği başka temel alanlara
 *       eşik UYDURULMADI, o alanlarda yalnızca doktor öğretim üyeliği
 *       eşiği var.
 *   Kriterler yeniden atamayı hiç düzenlemiyor; MADDE 5'in ilk atama
 *       koşulları yeniden atamaya da uygulandı.
 *   Ortak yayınlarda başlıca yazar dışındaki roller için iki okumanın
 *       düşüğü seçildi (cetvelin kapsam notunda açıklandı).
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 4'ün ISBN, belgeleme ve öz atıf kuralları ile MADDE 9'un ön
 *       değerlendirme komisyonu usulü.
 */
$TUM_ALANLAR = ['fen', 'muhendislik', 'saglik', 'ziraat', 'sosyal', 'egitim', 'filoloji',
    'ilahiyat', 'spor', 'hukuk', 'guzel_sanatlar', 'mimarlik'];

$DR_NOTU = 'Doktor öğretim üyeliği için iki yoldan biri yeterli: alanınızla ilgili hakemli bir '
    .'dergide yayımlanmış en az bir makale ya da MADDE 8 tablosundaki çalışmalardan 15 puan. '
    .'İkinci yol bildiri, atıf, proje, editörlük, tez danışmanlığı ve idari görev puanlarını da '
    .'kapsıyor.';

/** MADDE 6 ve 7: alt baraj MADDE 8/1'den, toplam bütün tablodan. */
$puanSarti = fn (int $alt, int $toplam, ?array $donem, string $madde): array => Kalip::ve('Puan koşulları', [
    Kalip::toplam($alt, donem: $donem, maddeler: ['MADDE-8-1'], liste: $madde),
    Kalip::toplam($toplam, donem: $donem, liste: $madde),
]);

$drSarti = Kalip::ve('Doktor öğretim üyeliği koşulları', [
    Kalip::beyan('İlgili alanda Türkiye\'de geçerli doktora belgesine sahip olmak', 'MADDE 5'),
    Kalip::veya('Yayın ya da puan koşulu', [
        Kalip::adet('Alanınızla ilgili hakemli bir dergide yayımlanmış en az 1 makale', ['MAKALE'], 1, madde: 'MADDE 5'),
        Kalip::toplam(15, liste: 'MADDE 5'),
    ]),
]);

/**
 * Doçentlik ve profesörlükte temel alana göre değişen barajlar.
 *
 * @var list<array{ad: string, anahtar: string, alan: list<string>, docAlt: int, docToplam: int, profAlt: int, profToplam: int}>
 */
$alanlar = [
    ['ad' => 'Filoloji', 'anahtar' => 'filoloji', 'alan' => ['filoloji'],
        'docAlt' => 80, 'docToplam' => 100, 'profAlt' => 80, 'profToplam' => 130],
    ['ad' => 'İlahiyat', 'anahtar' => 'ilahiyat', 'alan' => ['ilahiyat'],
        'docAlt' => 100, 'docToplam' => 120, 'profAlt' => 100, 'profToplam' => 150],
    ['ad' => 'Sosyal, Beşerî ve İdari Bilimler', 'anahtar' => 'sosyal', 'alan' => ['sosyal'],
        'docAlt' => 100, 'docToplam' => 120, 'profAlt' => 100, 'profToplam' => 150],
];

$esikler = [
    [
        'anahtar' => 'istanbul-29-mayis-dr',
        'universite' => 'İstanbul 29 Mayıs Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $TUM_ALANLAR,
        'cetvel' => 'istanbul-29-mayis-2017',
        'notlar' => 'MADDE 5: doktora belgesi ve hakemli dergide en az 1 makale ya da MADDE 8 '
            .'çalışmalarından en az 15 puan. Koşul bütün akademik birimler için ortak.',
        'aday_notu' => $DR_NOTU.' Kriterler 2017 tarihli olduğu için metinde bu kadro '
            .'"yardımcı doçentlik" adıyla geçiyor.',
        'sart' => $drSarti,
    ],
    [
        'anahtar' => 'istanbul-29-mayis-dr-yeniden',
        'universite' => 'İstanbul 29 Mayıs Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $TUM_ALANLAR,
        'cetvel' => 'istanbul-29-mayis-2017',
        'notlar' => 'Kriterler yeniden atamayı ayrıca düzenlemiyor; MADDE 5\'in ilk atama '
            .'koşulları uygulandı.',
        'aday_notu' => 'Kriterlerde yeniden atama için ayrı bir ölçüt yok; bu yüzden ilk '
            .'atamanın koşulları uygulandı. '.$DR_NOTU.' Biriminizin ayrıca bir beklentisi '
            .'olabilir.',
        'sart' => $drSarti,
    ],
];

foreach ($alanlar as $a) {
    $ortak = ['universite' => 'İstanbul 29 Mayıs Üniversitesi', 'alan' => $a['alan'],
        'cetvel' => 'istanbul-29-mayis-2017'];

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'istanbul-29-mayis-'.$a['anahtar'].'-docentlik',
        'kadro' => 'docentlik',
        'notlar' => 'MADDE 6: doktora sonrasında MADDE 8/1 çalışmalarından en az '.$a['docAlt']
            .', MADDE 8\'in tamamından en az '.$a['docToplam'].' puan.',
        'aday_notu' => $a['ad'].' temel alanında doçent kadrosu için iki baraj birden: MADDE '
            .'8/1\'de sayılan yayınlardan (makale, kitap ve kitap bölümü) en az '.$a['docAlt']
            .' puan ve tablonun tamamından en az '.$a['docToplam'].' puan. Her ikisi de DOKTORA '
            .'unvanını aldıktan sonraki çalışmalardan hesaplanıyor. Aradaki '
            .($a['docToplam'] - $a['docAlt']).' puanlık farkı bildiri, atıf, proje, editörlük, '
            .'hakemlik, tez danışmanlığı, ders, ödül ve idari görev kalemleriyle '
            .'kapatabilirsiniz.',
        'sart' => $puanSarti($a['docAlt'], $a['docToplam'], Kalip::DOKTORA_SONRASI, 'MADDE 6'),
    ]);

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'istanbul-29-mayis-'.$a['anahtar'].'-profesorluk',
        'kadro' => 'profesorluk',
        'notlar' => 'MADDE 7: doçent unvanını aldıktan sonra MADDE 8/1 çalışmalarından en az '
            .$a['profAlt'].', MADDE 8\'in tamamından en az '.$a['profToplam'].' puan.',
        'aday_notu' => $a['ad'].' temel alanında profesörlük için MADDE 8/1 yayınlarından '
            .$a['profAlt'].' puan ve tablonun tamamından '.$a['profToplam'].' puan gerekiyor; '
            .'ikisi de DOÇENT unvanını aldıktan sonraki çalışmalardan sayılıyor. Alt baraj '
            .'doçentlikle aynı, değişen yalnızca toplam.',
        'sart' => $puanSarti($a['profAlt'], $a['profToplam'], Kalip::DOCENTLIK_SONRASI, 'MADDE 7'),
    ]);
}

return $esikler;
