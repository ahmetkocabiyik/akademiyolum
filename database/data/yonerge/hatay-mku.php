<?php

/**
 * HATAY MUSTAFA KEMAL ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma
 * Kriterleri
 * Kaynak: pdf/17536995922.hataymustafakemaluniverstesi.pdf
 *
 * İKİ FARKLI CETVEL KULLANIYOR — korpusta ilk kez:
 *   Dr. Öğr. Üyeliği    Hatay MKÜ'nün kendi "Akademik Etkinlikler ve Puanlar
 *                       Listesi" (cetvel/hatay-mku-2024.php)
 *   Doçentlik/Profesörlük  ÜAK doçentlik kriterleri (cetvel uak-2024-mart-{alan})
 * Yönerge doçentlikte kendi tablosunu hiç kullanmıyor; "adayın doçent unvanını
 * aldığı doçentlik başvuru kriterlerindeki asgari puan şartını %30 oranında
 * aşmış olmak" diyor ve hesabın ÜAK puanlama sistemine göre yapılacağını
 * açıkça yazıyor.
 *
 * DOÇENTLİKTE 1,3 KATI ŞARTI SABİT PUANA ÇEVRİLDİ: ÜAK doçentlik toplam puanı
 * 100 olduğu için 130 yazıldı. ÜAK'ın alan bazında farklı toplam istediği bir
 * durumda bu sayı değişir; korpustaki ÜAK cetvelinde toplam bütün alanlarda
 * 100.
 *
 * DR. ÖĞR. ÜYELİĞİNDE BEŞ ALAN GRUBU, ÜÇÜ FARKLI KÜMEDEN SAYIYOR:
 *   Fen, Mühendislik, Mimarlık   A1a-A1c + A2a/A2d'den 30 · A-B-C-D-E-F'den 80
 *   Sosyal, Güzel Sanatlar,
 *   Konservatuvar                A1a-A1e + A2a/A2d'den 30 · A-B-C-D-E-F-G'den 80
 *   Sağlık Bilimleri             A1a'dan en az 1 eser  · A-B-C-D-E'den 60
 *   Spor Bilimleri               A1a-A1c + A2a/A2d'den 30 · A-B-C-D-E'den 80
 * Sağlık'ın barajı hem düşük (60) hem farklı biçimde kurulu: puan değil ADET
 * şartı koyuyor. Fen grubu ESCI'yi (A1b) alt baraja sayarken sosyal grup ayrıca
 * TR Dizin ve ulusal hakemli dergileri de sayıyor.
 *
 * YENİDEN ATANMA GİRİLMEDİ: koşullar "her yeniden atanma dönemi sonunda YIL
 * ORTALAMASININ en az 10, toplamda en az 25 puan" biçiminde; yıl ortalaması
 * atanma dönemi uzunluğuna bağlı ve o süre profilde tutulmuyor.
 *
 * DOÇENTLİK VE PROFESÖRLÜKTEKİ DİL ALTERNATİFİ BEYAN: yönerge "en az 65 puan
 * VEYA en az 60 puan alıp ayrıca Ar-Ge projesi yürütücülüğü ya da Q1/Q2 yayın"
 * diyor. Motorun `yds` düğümü tek eşik alıyor; burada YÜKSEK olan 65 yazıldı ve
 * alternatif aday notunda anlatıldı — düşük olanı yazmak dil puanı 60 olan ama
 * projesi olmayan adaya sağlandı derdi.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/hatay-mku-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$DOC = Kalip::DOCENTLIK_SONRASI;

$fenGrubu = ['fen', 'muhendislik', 'mimarlik', 'ziraat'];
$sosyalGrubu = ['sosyal', 'egitim', 'hukuk', 'ilahiyat', 'filoloji', 'guzel_sanatlar'];
$saglikGrubu = ['saglik'];
$sporGrubu = ['spor'];
$tumAlanlar = [...$fenGrubu, ...$sosyalGrubu, ...$saglikGrubu, ...$sporGrubu];

$dilNotu = 'Yabancı dil koşulunun bir alternatifi var: 65 yerine en az 60 puan alıp ayrıca '
    .'TÜBİTAK çağrılı destek programlarından bir Ar-Ge projesinde yürütücü olmak ya da Q1/Q2 '
    .'(Sosyal Bilimlerde Q1/Q2/Q3) grubu bir yayın yapmış olmak. Burada yüksek olan 65 '
    .'gösteriliyor; alternatifi sağlıyorsanız 60 da yeterli.';

$yenidenAtamaNotu = 'Yeniden atanmada yönerge yıl ortalaması istiyor (dönem sonunda yıl '
    .'ortalamasının belirli maddelerden en az 10-15, toplamda en az 25 puan). Atanma dönemi '
    .'uzunluğu burada tutulmadığı için yeniden atanma eşiği girilmedi.';

/**
 * Dr. Öğr. Üyeliği eşiği. Alt baraj kimi alanda puan, Sağlık'ta adet.
 *
 * @param  list<string>  $alanlar
 * @param  list<array<string, mixed>>  $altBaraj
 * @return array<string, mixed>
 */
$dr = function (string $anahtar, string $ad, array $alanlar, int $toplam, string $kume,
    array $altBaraj, string $madde) use ($yenidenAtamaNotu): array {
    return [
        'anahtar' => "hatay-mku-dr-{$anahtar}",
        'aday_notu' => $yenidenAtamaNotu,
        'universite' => 'Hatay Mustafa Kemal Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => array_values($alanlar),
        'cetvel' => 'hatay-mku-2024',
        'notlar' => "Madde 2.1.1/{$madde} ({$ad}): {$kume} maddeleri kapsamında en az {$toplam} puan.",
        'sart' => Kalip::ve("Dr. Öğr. Üyesi — {$ad}", [
            Kalip::yds(60),
            Kalip::puanDan("Yayın, tebliğ, proje, eğitim-öğretim ve ödül kalemlerinizden en az {$toplam} puan",
                [$kume], $toplam, madde: "Madde 2.1.1/{$madde}"),
            ...array_values($altBaraj),
        ]),
    ];
};

return [
    // ══════════ DR. ÖĞRETİM ÜYESİ (ilk atama, Madde 2.1.1) ══════════
    $dr('fen', 'Fen, Mühendislik ve Mimarlık', $fenGrubu, 80, 'A-B-C-D-E-F', [
        Kalip::puanDan('SCI, ESCI veya alan indeksli dergilerdeki makaleleriniz ile kitap ve '
            .'kitap bölümlerinizden en az 30 puan', ['FEN_MAKALE'], 30, madde: 'Madde 2.1.1/c'),
    ], 'c'),

    $dr('sosyal', 'Sosyal Bilimler, Güzel Sanatlar ve Konservatuvar', $sosyalGrubu, 80, 'A-B-C-D-E-F-G', [
        Kalip::puanDan('Makaleleriniz ile kitap ve kitap bölümlerinizden en az 30 puan',
            ['SOSYAL_MAKALE'], 30, madde: 'Madde 2.1.1/d'),
    ], 'd'),

    $dr('saglik', 'Sağlık Bilimleri', $saglikGrubu, 60, 'A-B-C-D-E', [
        Kalip::adet('SCI, SCI-Expanded, SSCI veya AHCI dergide en az 1 eser',
            ['A1a'], 1, madde: 'Madde 2.1.1/e'),
    ], 'e'),

    $dr('spor', 'Spor Bilimleri', $sporGrubu, 80, 'A-B-C-D-E', [
        Kalip::puanDan('SCI, ESCI veya alan indeksli dergilerdeki makaleleriniz ile kitap ve '
            .'kitap bölümlerinizden en az 30 puan', ['FEN_MAKALE'], 30, madde: 'Madde 2.1.1/f'),
    ], 'f'),

    // ══════════ DOÇENT (Madde 2.2) — ÜAK cetveli ══════════
    [
        'anahtar' => 'hatay-mku-docent',
        'aday_notu' => 'Hatay MKÜ doçentlikte kendi puan tablosunu kullanmıyor: ÜAK doçentlik '
            .'kriterlerindeki asgari puanı %30 aşmanızı istiyor (100 yerine 130). Aşağıdaki '
            .'puanlar ÜAK doçentlik cetveline göre hesaplanıyor. '.$dilNotu,
        'universite' => 'Hatay Mustafa Kemal Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $tumAlanlar,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 2.2/c: ÜAK doçentlik kriterlerindeki asgari puanın en az 1,3 katı '
            .'(100 → 130); Madde 2.2/d: yabancı dil sınavından en az 65.',
        'sart' => Kalip::ve('Doçent — Hatay Mustafa Kemal Üniversitesi', [
            Kalip::yds(65),
            Kalip::toplam(130),
            Kalip::beyan('Üniversitelerarası Kurul Başkanlığı tarafından verilen doçent unvanını '
                .'almış olmak', 'Madde 2.2/b'),
        ]),
    ],

    // ══════════ PROFESÖR (Madde 2.3) — ÜAK cetveli ══════════
    [
        'anahtar' => 'hatay-mku-profesor',
        'aday_notu' => 'Hatay MKÜ profesörlükte de kendi puan tablosunu kullanmıyor: doçent '
            .'unvanını aldığınız dönemin ÜAK doçentlik kriterlerini bir kez daha sağlamanızı '
            .'istiyor (lisansüstü tezlerden yayın zorunluluğu hariç). Hangi dönemin kriterlerinin '
            .'geçerli olduğu doçentlik tarihinize bağlı olduğu için burada güncel ÜAK toplamı '
            .'gösteriliyor. '.$dilNotu,
        'universite' => 'Hatay Mustafa Kemal Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $tumAlanlar,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 2.3/e: doçentlik kriterlerini yeniden sağlamak (100 puan); '
            .'Madde 2.3/c: yabancı dil sınavından en az 65; Madde 2.3/d: başlıca araştırma eseri.',
        'sart' => Kalip::ve('Profesör — Hatay Mustafa Kemal Üniversitesi', [
            Kalip::yds(65),
            Kalip::toplam(100, $DOC),
            Kalip::beyan('Doçent unvanınızı aldıktan sonra ilgili bilim alanında yaptığınız özgün '
                .'yayın veya araştırmalardan kaynaklanan bir Başlıca Araştırma Eserine sahip '
                .'olmak; Sosyal Bilimlerde bu eserin yabancı dilde ve başlıca yazar olarak '
                .'yayımlanmış olması gerekiyor', 'Madde 2.3/d'),
            Kalip::beyan('Doçent unvanını aldığınız dönemin ÜAK doçentlik kriterlerini, '
                .'lisansüstü tezlerden yayın zorunluluğu hariç, yeniden sağlamış olmak',
                'Madde 2.3/e'),
        ]),
    ],
];
