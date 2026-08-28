<?php

/**
 * UŞAK ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Yönergesi
 * Kaynak: pdf/1780987731728.usak-kriter-09062026.pdf (12 sayfa; Senato
 * 16.06.2020-2020/13-05, değişiklikler 29.09.2021-2021/16-04,
 * 13.04.2022-2022/07-14 ve 04.03.2026-2026/06-11.)
 *
 * ── ALTI ALAN KÜMESİ ──
 * MADDE 7, 8 ve 9 temel alanları ayrı ayrı ele alıyor. Kümeler kadroya
 * göre biraz kayıyor: doktor öğretim üyeliği ve doçentlikte Mimarlık
 * kendi başına, profesörlükte ise Eğitim, Filoloji, Sosyal ve Spor ile
 * aynı kümede.
 *
 * ── GÜZEL SANATLARDA PUAN BARAJI YOK ──
 * MADDE 7(1)(c)(6) Güzel Sanatlar temel alanında ilk atanma için toplam
 * puan istemiyor; makale, bildiri ve sanat etkinliği SAYISI istiyor.
 * MADDE 8(1)(ç)(6) doçentlikte "güncel doçentlik başvuru koşullarına
 * göre en az 160 puan" diyor; bu ÜAK'ın kendi puanlama sistemine bağlı
 * olduğu için `hesaplanamiyor`.
 *
 * ── YENİDEN ATANMADA "EN AZ İKİSİ" ──
 * MADDE 7(2) 30 puanlık yayın şartına ek olarak altı koşuldan en az
 * ikisini istiyor; `k_ile` düğümüyle yazıldı. Koşullardan (d) Google
 * Akademi H3 indeksi ve (e)-(f) ders yarıyılı sayısı motorun
 * `h_indeksi` ve `ders_yariyil` metriklerine çevrildi.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 6(1)(e): temininde güçlük çekilen birimlerde Üniversite
 *       Yönetim Kurulu kararıyla şartların aranmayabilmesi.
 *   MADDE 6(1)(f): YÖK'ün asgari öğretim üyesi şartını sağlamayan
 *       bölümlere, ihtisaslaşma projesi kapsamındaki birimlere ve Tıp
 *       ile Diş Hekimliği fakültelerine yapılacak doçent ve profesör
 *       atamalarında yayın ve toplam puanın YÜZDE 60'ının aranması.
 *   MADDE 7(1)(c)(6)(a)'nın "en fazla 2 yazarlı" ve "en fazla dört
 *       yazarlı 4 makale eşdeğerdir" koşulları — kayıt yazar sayısını
 *       koşula bağlayamıyor.
 *   MADDE 7(3): yönergenin yürürlüğe girmesinden sonraki ilk yeniden
 *       atamada kriterlerin aranmaması.
 *   MADDE 7(4): asgari şartı sağlayamayanlara bir defaya mahsus iki
 *       yıllık yeniden atama.
 *   MADDE 9'un "profesör unvanlı adaylarda son beş yıllık faaliyetlerin
 *       değerlendirilmesi" kuralı.
 *   Profesörlükte yönerge ayrı bir yabancı dil puanı istemiyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/usak-2020.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Uşak Üniversitesi';
$CETVEL = 'usak-2020';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$SOSYAL = ['egitim', 'filoloji', 'sosyal', 'spor'];
$FEN = ['fen', 'muhendislik', 'saglik', 'ziraat'];
$TUM = [...$SOSYAL, ...$FEN, 'hukuk', 'ilahiyat', 'mimarlik', 'guzel_sanatlar'];

$SOSYAL_AD = 'Eğitim Bilimleri, Filoloji, Sosyal-Beşeri-İdari Bilimler ve Spor Bilimleri';
$FEN_AD = 'Fen Bilimleri ve Matematik, Mühendislik, Sağlık Bilimleri ile Ziraat-Orman-Su Ürünleri';

$SCI_AD = 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergilerde';
$SCI_ESCI_AD = 'SCI, SCI-Expanded, SSCI, AHCI, ESCI ya da SCOPUS kapsamındaki dergilerde';
$ULUS_AD = 'uluslararası hakemli dergilerde';
$ULUS_TR_AD = 'uluslararası hakemli dergilerde ya da TR Dizin kapsamındaki dergilerde';
$TR_AD = 'TR Dizin kapsamındaki dergilerde';
$TR_ULUSAL_AD = 'ulusal hakemli dergilerde';

$NOT_DIL = ' Yabancı dil koşulu 65 puandan uygulanıyor; tamamen ya da kısmen yabancı dilde '
    .'eğitim yapan birimlerde 85 puan gerekiyor.';
$NOT_YUZDE60 = ' YÖK\'ün asgari öğretim üyesi şartını sağlamayan bölümlere, Bölgesel Kalkınma '
    .'Odaklı İhtisaslaşma Projesi kapsamındaki birimlere ve Tıp ile Diş Hekimliği fakültelerine '
    .'yapılacak doçent ve profesör atamalarında yönergedeki yayın ve toplam puanın yalnız yüzde '
    .'60\'ı aranıyor; motor tam puanı uyguluyor.';
$NOT_YURTDISI = ' Yurt dışı araştırma çalışmaları bölümü (en fazla 20 puan) faaliyet değil süre '
    .'ölçütü olduğu için puana katılmıyor.';

$bildiriBaslica = Kalip::adet(
    'Uluslararası bir kongrede sunulmuş ve tam metni yayımlanmış en az bir bildiride başlıca '
    .'yazar olmak',
    ['BILDIRI-ULUSLARARASI'], 1, 'baslica', madde: '7-1-c',
);

$esikler = [];

// ══════════════════════════════════════════════════════════════════════════
// DOKTOR ÖĞRETİM ÜYESİ — İLK ATANMA (MADDE 7/1)
// ══════════════════════════════════════════════════════════════════════════

/**
 * @param  list<string>  $alanlar
 * @return array<string, mixed>
 */
$drEsigi = function (string $anahtar, array $alanlar, string $alanAdi, string $grup, string $grupAdi, int $puan, string $md) use ($UNIVERSITE, $CETVEL, $bildiriBaslica, $NOT_DIL, $NOT_YURTDISI): array {
    return [
        'anahtar' => "usak-{$anahtar}-dr",
        'aday_notu' => "{$alanAdi} temel alanlarında doktor öğretim üyesi kadrosuna İLK ATANMA "
            .'koşulları. Atamalar üç yıl süreyle yapılıyor.'.$NOT_DIL.$NOT_YURTDISI,
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => "MADDE 7(1)({$md}): {$grup} kümesinden {$puan} puan ve en az bir makalede "
            .'başlıca yazarlık; uluslararası kongrede tam metin bildiride başlıca yazarlık; '
            .'toplam 50 puan. Yabancı dil 65.',
        'sart' => Kalip::ve("Doktor Öğretim Üyesi kadrosuna ilk atanma — {$alanAdi}", [
            Kalip::yds(65),
            Kalip::puanDan(
                "{$grupAdi} yayımlanmış makalelerden en az {$puan} puan almış olmak",
                [$grup], $puan, madde: $md,
            ),
            Kalip::adet(
                "{$grupAdi} yayımlanmış en az bir makalede başlıca yazar olmak",
                [$grup], 1, 'baslica', madde: $md,
            ),
            $bildiriBaslica,
            Kalip::toplam(50),
        ]),
    ];
};

$esikler[] = $drEsigi('sosyal', $SOSYAL, $SOSYAL_AD, 'ULUS-ABC', $SCI_ESCI_AD, 20, 'c-1');
$esikler[] = $drEsigi('fen', $FEN, $FEN_AD, 'ULUS-A', $SCI_AD, 25, 'c-2');
$esikler[] = $drEsigi('hukuk', ['hukuk'], 'Hukuk', 'ULUSAL-A', $TR_AD, 20, 'c-3');
$esikler[] = $drEsigi('ilahiyat', ['ilahiyat'], 'İlahiyat', 'ULUSAL-AB', $TR_ULUSAL_AD, 20, 'c-4');
$esikler[] = $drEsigi('mimarlik', ['mimarlik'], 'Mimarlık, Planlama ve Tasarım',
    'ULUS-HEPSI-ULUSAL-A', $ULUS_TR_AD, 20, 'c-5');

$esikler[] = [
    'anahtar' => 'usak-guzel-sanatlar-dr',
    'aday_notu' => 'Güzel Sanatlar temel alanında doktor öğretim üyesi kadrosuna İLK ATANMA '
        .'koşulları. Bu alanda yönerge toplam puan istemiyor, yayın ve etkinlik SAYISI istiyor. '
        .'Ulusal makale koşulunda yönerge "en fazla iki yazarlı 2 makale" (ya da en fazla dört '
        .'yazarlı 4 makale) diyor; motor yazar sayısını koşula bağlayamadığı için yalnız 2 '
        .'makale şartı uygulanıyor, koşul burada göründüğünden hafif kalabilir.'.$NOT_DIL,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['guzel_sanatlar'],
    'cetvel' => $CETVEL,
    'notlar' => 'MADDE 7(1)(c)(6): uluslararası dergide 1 makale; TR Dizinde en fazla 2 yazarlı '
        .'2 makale; uluslararası bildiri 1; 1 kişisel ve 4 karma sanat etkinliği. Yazar sayısı '
        .'koşulu uygulanmadı.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna ilk atanma — Güzel Sanatlar', [
        Kalip::yds(65),
        Kalip::adet(
            'Editöre mektup, özet ve kitap kritiği hariç, uluslararası dergilerde en az 1 makale '
            .'yayımlamış olmak',
            ['ULUS-HEPSI'], 1, madde: '7-1-c-6-a',
        ),
        Kalip::adet(
            'TR Dizin kapsamındaki dergilerde en az 2 makale yayımlamış olmak',
            ['ULUSAL-A'], 2, madde: '7-1-c-6-a',
        ),
        Kalip::adet(
            'Uluslararası bir sempozyum, kongre ya da panele en az bir bildiriyle katılmış ve '
            .'bildirinizin yayımlanmış olması',
            ['BILDIRI-ULUSLARARASI'], 1, madde: '7-1-c-6-b',
        ),
        Kalip::adet(
            'Özgün sanat eserleri, tasarımlar ya da yorum çalışmalarıyla en az bir kişisel '
            .'etkinliğe katılmış olmak',
            ['SANAT-KISISEL'], 1, madde: '7-1-c-6-c',
        ),
        Kalip::adet(
            'Özgün sanat eserleri, tasarımlar ya da yorum çalışmalarıyla en az dört karma ya da '
            .'ortak etkinliğe katılmış olmak',
            ['SANAT-KARMA'], 4, madde: '7-1-c-6-c',
        ),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// DOKTOR ÖĞRETİM ÜYESİ — YENİDEN ATANMA (MADDE 7/2)
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'usak-dr-yeniden',
    'aday_notu' => 'Doktor öğretim üyesi kadrosuna YENİDEN ATANMA koşulları: son atanma '
        .'tarihinizden sonra Ek-1 tablosunun yayın bölümlerinden en az 30 puan ve aşağıdaki altı '
        .'koşuldan en az ikisi. Asgari şartı sağlayamayanlara bir defaya mahsus iki yıllık '
        .'yeniden atama yapılıyor; bu sürenin sonunda da sağlanamazsa yeniden atama '
        .'yapılmıyor.'.$NOT_YURTDISI,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => $TUM,
    'cetvel' => $CETVEL,
    'notlar' => 'MADDE 7(2): Ek-1\'in yayın bölümlerinden 30 puan (son atanma sonrası, §0 '
        .'uyarınca dönem kısıtı eklendi) + altı koşuldan en az ikisi. (d) Google Akademi H3 '
        .'indeksi `h_indeksi` metriğine, (e) dört yarıyıl lisans dersi ve (f) iki yarıyıl '
        .'lisansüstü ders `ders_yariyil` metriğine çevrildi.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna yeniden atanma', [
        Kalip::puanDan(
            'Son atanma tarihinizden sonra makale, kitap ve tez yayını kalemlerinden en az 30 '
            .'puan almış olmak',
            ['YAYIN'], 30, $SON_ATAMA, madde: '7-2',
        ),
        Kalip::kIle('Aşağıdaki koşullardan en az ikisini sağlamak', 2, [
            Kalip::adet(
                'Ulusal ya da uluslararası bir bilimsel toplantıda sunulan ve tam metni bildiri '
                .'kitapçığında yayımlanmış en az bir bildirinizin bulunması',
                ['BILDIRI'], 1, madde: '7-2-a',
            ),
            Kalip::adet(
                'Son atanma tarihinizden sonra en az bir yüksek lisans ya da doktora tez '
                .'danışmanlığını başarıyla sonuçlandırmış olmak',
                ['TEZ-DANISMANLIK'], 1, donem: $SON_ATAMA, madde: '7-2-b',
            ),
            Kalip::adet(
                'Üniversite ya da birim yönetimine katkı sağlamış olmak; yönetimde, kurullarda '
                .'veya komisyonlarda en az bir yıl süreyle görev almak',
                ['IDARI'], 1, madde: '7-2-c',
            ),
            Kalip::adet(
                'Son atanma tarihinizden sonra ulusal ya da uluslararası tamamlanmış bir projede '
                .'görev almak',
                ['PROJE'], 1, donem: $SON_ATAMA, madde: '7-2-ç',
            ),
            Kalip::metrik('Google Akademiye göre en az H3 indeksine sahip olmak', 'h_indeksi', 3),
            Kalip::metrik(
                'En az dört yarıyıl süreyle lisans seviyesinde zorunlu dersler dışında seçmeli '
                .'ders vermiş olmak',
                'ders_yariyil', 4,
            ),
        ]),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// DOÇENT (MADDE 8)
// ══════════════════════════════════════════════════════════════════════════

/**
 * @param  list<string>  $alanlar
 * @return array<string, mixed>
 */
$docentEsigi = function (string $anahtar, array $alanlar, string $alanAdi, string $grup, string $grupAdi, int $puan, string $md) use ($UNIVERSITE, $CETVEL, $DOKTORA, $NOT_DIL, $NOT_YUZDE60, $NOT_YURTDISI): array {
    return [
        'anahtar' => "usak-{$anahtar}-docentlik",
        'aday_notu' => "{$alanAdi} temel alanlarında doçent kadrosuna atanma koşulları. Puanların "
            .'tamamı DOKTORA unvanınızı aldıktan sonraki faaliyetlerden sağlanmalı. İdari '
            .'görevlerden aldığınız puan doçentlik kriterinde kullanılamıyor; motor bu kuralı '
            .'işletmiyor.'.$NOT_DIL.$NOT_YUZDE60.$NOT_YURTDISI,
        'universite' => $UNIVERSITE,
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => "MADDE 8(1)(ç)({$md}): doktora sonrası {$grup} kümesinden {$puan} puan; "
            .'toplam 120 puan. Yabancı dil 65.',
        'sart' => Kalip::ve("Doçent kadrosuna atanma — {$alanAdi}", [
            Kalip::beyan(
                'Üniversitelerarası Kurul kararıyla doçentlik unvanını almış olmak ya da yurt '
                .'dışında alınan doçentlik unvanının Türkiye\'de denkliğini almak',
                '8-1-a',
            ),
            Kalip::yds(65),
            Kalip::puanDan(
                "Doktora unvanınızı aldıktan sonra {$grupAdi} yayımlanmış makalelerden en az "
                ."{$puan} puan almış olmak",
                [$grup], $puan, $DOKTORA, madde: "8-1-ç-{$md}",
            ),
            Kalip::toplam(120, $DOKTORA),
        ]),
    ];
};

$esikler[] = $docentEsigi('sosyal', $SOSYAL, $SOSYAL_AD, 'ULUS-ABC', $SCI_ESCI_AD, 35, '1');
$esikler[] = $docentEsigi('fen', $FEN, $FEN_AD, 'ULUS-A', $SCI_AD, 45, '2');
$esikler[] = $docentEsigi('hukuk', ['hukuk'], 'Hukuk', 'ULUS-HEPSI-ULUSAL-A', $ULUS_TR_AD, 35, '3');
$esikler[] = $docentEsigi('ilahiyat', ['ilahiyat'], 'İlahiyat', 'ULUS-HEPSI-ULUSAL-AB',
    'uluslararası hakemli dergilerde ya da ulusal hakemli dergilerde', 30, '4');
$esikler[] = $docentEsigi('mimarlik', ['mimarlik'], 'Mimarlık, Planlama ve Tasarım',
    'ULUS-HEPSI-ULUSAL-AB', 'uluslararası hakemli dergilerde ya da ulusal hakemli dergilerde', 35, '5');

$esikler[] = [
    'anahtar' => 'usak-guzel-sanatlar-docentlik',
    'aday_notu' => 'Güzel Sanatlar temel alanında doçent kadrosuna atanma koşulları. Yönerge bu '
        .'alanda kendi puan tablosunu değil, güncel ÜAK doçentlik başvuru koşullarını esas alıp '
        .'oradan en az 160 puan istiyor; bu koşul ÜAK\'ın kendi puanlama sistemine bağlı olduğu '
        .'için motor hesaplayamıyor.'.$NOT_DIL,
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['guzel_sanatlar'],
    'cetvel' => $CETVEL,
    'notlar' => 'MADDE 8(1)(ç)(6): güncel doçentlik başvuru koşullarına göre en az 160 puan '
        .'(hesaplanamıyor). Yabancı dil 65.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — Güzel Sanatlar', [
        Kalip::beyan(
            'Üniversitelerarası Kurul kararıyla doçentlik unvanını almış olmak ya da yurt dışında '
            .'alınan doçentlik unvanının Türkiye\'de denkliğini almak',
            '8-1-a',
        ),
        Kalip::yds(65),
        Kalip::hesaplanamiyor(
            'Güncel ÜAK doçentlik başvuru koşullarına göre en az 160 puan almış olmak',
            '8-1-ç-6',
        ),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// PROFESÖR (MADDE 9)
// ══════════════════════════════════════════════════════════════════════════

/**
 * @param  list<string>  $alanlar
 * @return array<string, mixed>
 */
$profEsigi = function (string $anahtar, array $alanlar, string $alanAdi, string $grup, string $grupAdi, int $puan, string $md) use ($UNIVERSITE, $CETVEL, $DOCENTLIK, $NOT_YUZDE60, $NOT_YURTDISI): array {
    return [
        'anahtar' => "usak-{$anahtar}-profesorluk",
        'aday_notu' => "{$alanAdi} temel alanlarında profesör kadrosuna yükseltilerek atanma "
            .'koşulları. Puanların tamamı DOÇENT unvanınızı aldıktan sonraki faaliyetlerden '
            .'sağlanmalı. Ayrıca doçentlik unvanınızı aldığınız sırada yürürlükte olan ÜAK yayın '
            .'koşullarını doçentlik sonrası çalışmalarınızla bir kez daha sağlamış olmanız '
            .'gerekiyor; bu koşul ÜAK\'ın kendi cetveline bağlı olduğu için motor '
            .'hesaplayamıyor. Zaten profesör unvanlı adayların başvurusunda yalnız son beş yıllık '
            .'faaliyetler değerlendiriliyor; motor bu sınırı uygulamıyor.'.$NOT_YUZDE60.$NOT_YURTDISI,
        'universite' => $UNIVERSITE,
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => "MADDE 9(1)(a) ÜAK yayın koşulları hesaplanamıyor; 9(1)(b)({$md}): {$grup} "
            ."kümesinden {$puan} puan, en az ikisinde başlıca yazarlık; doçentlik sonrası toplam "
            .'150 puan.',
        'sart' => Kalip::ve("Profesör kadrosuna yükseltilerek atanma — {$alanAdi}", [
            Kalip::hesaplanamiyor(
                'Doçentlik unvanınızı aldığınız sırada yürürlükte olan ÜAK yayın koşullarını, '
                .'doçentlik unvanını aldıktan sonra yaptığınız çalışma ve yayınlarla bir kez daha '
                .'sağlamış olmak',
                '9-1-a',
            ),
            Kalip::puanDan(
                "Doçent unvanınızı aldıktan sonra {$grupAdi} yayımlanmış makalelerden en az "
                ."{$puan} puan almış olmak",
                [$grup], $puan, $DOCENTLIK, madde: "9-1-b-{$md}",
            ),
            Kalip::adet(
                "Doçent unvanınızı aldıktan sonra {$grupAdi} yayımlanmış en az 2 makalede başlıca "
                .'yazar olmak',
                [$grup], 2, 'baslica', $DOCENTLIK, madde: "9-1-b-{$md}",
            ),
            Kalip::toplam(150, $DOCENTLIK),
        ]),
    ];
};

$esikler[] = $profEsigi('sosyal', [...$SOSYAL, 'mimarlik'],
    $SOSYAL_AD.' ile Mimarlık, Planlama ve Tasarım', 'ULUS-ABC', $SCI_ESCI_AD, 40, '1');
$esikler[] = $profEsigi('ilahiyat', ['ilahiyat'], 'İlahiyat', 'ULUS-HEPSI-ULUSAL-A', $ULUS_TR_AD, 40, '2');
$esikler[] = $profEsigi('guzel-sanatlar', ['guzel_sanatlar'], 'Güzel Sanatlar',
    'ULUS-HEPSI-ULUSAL-A', $ULUS_TR_AD, 40, '3');
$esikler[] = $profEsigi('hukuk', ['hukuk'], 'Hukuk', 'ULUS-HEPSI-ULUSAL-A', $ULUS_TR_AD, 40, '4');
$esikler[] = $profEsigi('fen', $FEN, $FEN_AD, 'ULUS-A', $SCI_AD, 50, '5');

return $esikler;
