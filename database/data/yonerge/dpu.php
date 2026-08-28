<?php

/**
 * KÜTAHYA DUMLUPINAR ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve
 * Atanma Yönergesi (İlkeler ve Kriterler)
 * Kaynak: pdf/17537002702.kutahyadumlupinaruniverstesi.pdf (28 sayfa;
 * Senato 17.11.2023-33, YÖK G.K. 29.02.2024)
 *
 * ── YAPI: ÜÇ KOŞUL GRUBU, DÖRT CETVEL SÜTUNU ──
 * Madde 5 koşulları üç alan grubuna ayırıyor:
 *   MÜHENDİSLİK GRUBU — Fen Bilimleri ve Matematik, Mühendislik,
 *       Mimarlık-Planlama-Tasarım → `dpu-2024-muh`
 *   SOSYAL GRUP — Eğitim Bilimleri, İlahiyat, Filoloji, Spor Bilimleri,
 *       Sosyal-Beşeri-İdari Bilimler → `dpu-2024` (İlahiyat kendi puan
 *       sütununa sahip olduğu için `dpu-2024-ilahiyat`)
 *   GÜZEL SANATLAR → `dpu-2024-gsf`
 * Koşul sayıları sosyal grubun tamamında aynı; cetvel sütunu İlahiyat
 * için ayrı çünkü EK-1 ulusal makale ve kitap puanlarını İlahiyat'ta
 * yüksek tutuyor.
 *
 * ── EŞİK YAZILMAYAN ALANLAR ──
 * Yönerge Sağlık Bilimleri, Ziraat-Orman-Su Ürünleri ve Hukuk temel
 * alanlarını hiç anmıyor; EK-1'in puan sütunlarında da yoklar. Bu üç
 * alan için eşik yazılmadı.
 *
 * ── DOÇENTLİKTE İLAVE KRİTER YOK ──
 * Madde 5.2.1: "Doçentlik kadrosuna atanmak için ÜAK tarafından
 * düzenlenen doçentlik sınavından başarılı olan adaylardan ilave bir
 * kriter istenmemektedir." Doçentlik eşiği yalnız bu beyanı taşıyor;
 * puan barajı yok.
 *
 * ── YENİDEN ATANMADA DÖNEM ──
 * Madde 5.1.2 "her sözleşme döneminde" / "her yeniden atanma döneminde"
 * diyor ve "iki veya üç yıllık atandığı sürelere tekabül eden, SON
 * DÖNEMDEKİ faaliyetler dikkate alınır" ekliyor; `SON_ATAMA_SONRASI`.
 * Puan sağlanamazsa bir yıl (gerekirse iki yıl) izleme süresi veriliyor;
 * bu takdir yetkisi eşiğe yazılmadı.
 *
 * ── GÜZEL SANATLAR EŞİKLERİNİN J BLOĞU ──
 * Güzel Sanatlar koşulu "24 puanı J 111, 1121, 1161, 1171
 * maddelerinden" diyor. Bunlar EK-1'in dört satırı: eserin satın
 * alınması / yayın organında yer alması (yurt dışı J111 ve yurt içi
 * J1161'in üst başlığı J116 olduğu için burada J1161 satırı), jürili
 * uluslararası kişisel kabul (J1121) ve restorasyon-konservasyon
 * yürütücülüğü (J1171). Cetvelde bu dört kod `J-BLOK` grubunda.
 *
 * ── YABANCI DİL ──
 * Madde 5.1.1 doktor öğretim üyeliğinde "Öğretim Üyesi Dışındaki
 * Öğretim Elemanı Kadrolarına... Yönetmelik"teki TABAN puanı istiyor;
 * bu yönetmelik yabancı dille öğretim yapmayan programlarda 55 puan
 * öngörüyor. Yönergenin kendisi sayı vermediği için `Kalip::yds`
 * kullanılmadı, koşul `beyan` olarak yazıldı. Doçentlik ve profesörlük
 * için yönerge ayrı bir dil koşulu koymuyor.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   "Doktora/sanatta yeterlilik unvanını aldığı bilim alanlarındaki
 *       kriterleri sağlamak" ve profesörlükte "doçentlik unvanını aldığı
 *       bilim alanı" — profil ile ilan arasındaki alan eşleşmesi.
 *   Profesörlükte "yayınlarından birini başlıca eser olarak göstermek"
 *       — yönerge başlıca eserin niteliğini tanımlamıyor, `beyan`.
 *   Güzel Sanatlar Fakültesi kadrosunda görev yapan, doçentlik temel
 *       alanı Eğitim Bilimleri ya da Sosyal-Beşeri-İdari Bilimler olan
 *       profesör adaylarına uygulanan istisna (30 puanı A başlığından,
 *       toplam 130) — adayın kadro birimine bağlı, aday notunda yazılı.
 *   Doçentlik sözlü sınavını başararak alanlara profesör atamasında
 *       verilen 25 ilave puan (EK-1 S satırı) — faaliyet değil.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/dpu-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Kütahya Dumlupınar Üniversitesi';
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$dil = Kalip::beyan(
    'Yabancı dilden, Öğretim Üyesi Dışındaki Öğretim Elemanı Kadrolarına Yapılacak Atamalarda '
    .'Uygulanacak Merkezi Sınav ile Giriş Sınavlarına İlişkin Usul ve Esaslar Hakkında '
    .'Yönetmelikte öğretim elemanları için belirlenen taban puandan az olmayan bir puan almak',
    '5.1.1',
);

$doktora = Kalip::beyan(
    'Doktora ya da sanatta yeterlik unvanını, başvurduğunuz kadronun bilim alanında almış olmak',
    '5.1.1',
);

$docentUnvani = Kalip::beyan(
    'Üniversitelerarası Kurul tarafından düzenlenen doçentlik sınavından başarılı olmak',
    '5.2.1',
);

$baslicaEser = Kalip::beyan(
    'Başvurunuzda yayınlarınızdan birini başlıca eser olarak göstermek', '5.3',
);

$besYil = Kalip::beyan(
    'Doçentlik unvanını başvurduğunuz kadronun bilim alanında almış olmak ve 2547 sayılı Kanunun '
    .'26. maddesindeki süre koşulunu sağlamak',
    '5.3',
);

$esikler = [];

// ══════════════════════════════════════════════════════════════════════════
// FEN / MÜHENDİSLİK / MİMARLIK VE SOSYAL GRUP
// ══════════════════════════════════════════════════════════════════════════

foreach ([
    ['muh', ['fen', 'muhendislik', 'mimarlik'], 'dpu-2024-muh',
        'Fen Bilimleri ve Matematik, Mühendislik ile Mimarlık, Planlama ve Tasarım temel alanları',
        ['A11'], 'A11 başlığından (uluslararası makaleler)', 20, ['A'], 'A başlığından', 40, 50,
        ['A-C'], 'A-C başlıkları arasından', 20,
        ['A'], 'A başlığından', 30, ['A-B'], 'A-B başlıkları arasından', 40],
    ['sosyal', ['egitim', 'filoloji', 'sosyal', 'spor'], 'dpu-2024',
        'Eğitim Bilimleri, Filoloji, Sosyal-Beşeri-İdari Bilimler ve Spor Bilimleri temel alanları',
        ['A11-A21'], 'A11 ve/veya A21 başlığından (uluslararası ve ulusal makaleler)', 16,
        ['A-C'], 'A-C başlıkları arasından', 30, 40,
        ['A-C'], 'A-C başlıkları arasından', 16,
        ['A'], 'A başlığından', 20, ['A-B'], 'A-B başlıkları arasından', 30],
    ['ilahiyat', ['ilahiyat'], 'dpu-2024-ilahiyat', 'İlahiyat temel alanı',
        ['A11-A21'], 'A11 ve/veya A21 başlığından (uluslararası ve ulusal makaleler)', 16,
        ['A-C'], 'A-C başlıkları arasından', 30, 40,
        ['A-C'], 'A-C başlıkları arasından', 16,
        ['A'], 'A başlığından', 20, ['A-B'], 'A-B başlıkları arasından', 30],
] as [$anahtar, $alanlar, $cetvel, $alanAdi,
    $drAltGrup, $drAltAd, $drAltPuan, $drUstGrup, $drUstAd, $drUstPuan, $drToplam,
    $yenidenGrup, $yenidenAd, $yenidenPuan,
    $prAltGrup, $prAltAd, $prAltPuan, $prUstGrup, $prUstAd, $prUstPuan]) {
    $esikler[] = [
        'anahtar' => "dpu-{$anahtar}-dr-ilk",
        'aday_notu' => "{$alanAdi} için Doktor Öğretim Üyesi kadrosuna ilk atanmada EK-1'in "
            ."{$drAltAd} en az {$drAltPuan} puan, {$drUstAd} en az {$drUstPuan} puan ve "
            ."toplamda en az {$drToplam} puan isteniyor. Ayrıca yabancı dilden, öğretim "
            .'elemanı kadroları için belirlenen taban puanı almış olmanız gerekiyor.',
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'cetvel' => $cetvel,
        'notlar' => "5.1.1 ({$alanAdi}): {$drAltAd} {$drAltPuan}; {$drUstAd} {$drUstPuan}; "
            ."toplam {$drToplam}.",
        'sart' => Kalip::ve("Doktor Öğretim Üyesi kadrosuna ilk atanma — {$alanAdi}", [
            $dil,
            $doktora,
            Kalip::puanDan("EK-1'in {$drAltAd} en az {$drAltPuan} puan", $drAltGrup, $drAltPuan, madde: '5.1.1'),
            Kalip::puanDan("EK-1'in {$drUstAd} en az {$drUstPuan} puan", $drUstGrup, $drUstPuan, madde: '5.1.1'),
            Kalip::toplam($drToplam),
        ]),
    ];

    $esikler[] = [
        'anahtar' => "dpu-{$anahtar}-dr-yeniden",
        'aday_notu' => 'Son atama döneminizdeki faaliyetleriniz sayılıyor. '
            ."{$alanAdi} için her yeniden atanma döneminde EK-1'in {$yenidenAd} en az "
            ."{$yenidenPuan} puan ve toplamda en az {$drToplam} puan isteniyor. Puanı "
            .'sağlayamazsanız bir defaya mahsus bir yıl izleme süresi veriliyor; Üniversite '
            .'Yönetim Kurulu kararıyla bu süre bir yıl daha uzatılabiliyor.',
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $alanlar,
        'cetvel' => $cetvel,
        'notlar' => "5.1.2 ({$alanAdi}): {$yenidenAd} {$yenidenPuan}; toplam {$drToplam}.",
        'sart' => Kalip::ve("Doktor Öğretim Üyesi kadrosuna yeniden atanma — {$alanAdi}", [
            Kalip::puanDan(
                "Son atama döneminizde EK-1'in {$yenidenAd} en az {$yenidenPuan} puan",
                $yenidenGrup, $yenidenPuan, $SON_ATAMA, madde: '5.1.2',
            ),
            Kalip::toplam($drToplam, $SON_ATAMA),
        ]),
    ];

    $esikler[] = [
        'anahtar' => "dpu-{$anahtar}-docentlik",
        'aday_notu' => 'Yönerge doçentlik kadrosuna atanmada ilave bir kriter aramıyor: '
            .'Üniversitelerarası Kurul tarafından düzenlenen doçentlik sınavından başarılı '
            .'olmanız yeterli. EK-1 puan tablosundan bir baraj istenmiyor.',
        'universite' => $UNIVERSITE,
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'cetvel' => $cetvel,
        'notlar' => '5.2.1: ÜAK doçentlik sınavı dışında ilave kriter yok.',
        'sart' => Kalip::ve("Doçent kadrosuna atanma — {$alanAdi}", [$docentUnvani]),
    ];

    $esikler[] = [
        'anahtar' => "dpu-{$anahtar}-profesorluk",
        'aday_notu' => 'Doçentlik unvanınızı aldıktan sonraki çalışmalarınız sayılıyor. '
            ."{$alanAdi} için EK-1'in {$prAltAd} en az {$prAltPuan} puan, {$prUstAd} en az "
            ."{$prUstPuan} puan ve toplamda en az 130 puan isteniyor. Başvurunuzda "
            .'yayınlarınızdan birini başlıca eser olarak göstermeniz gerekiyor. Doçentliğini '
            .'sözlü sınava girerek almış adaylara EK-1\'in S satırından 25 ilave puan '
            .'veriliyor; bu puan faaliyet kaydına çevrilemediği için hesaba katılmıyor.'
            .($anahtar === 'sosyal'
                ? ' Güzel Sanatlar Fakültesi kadrosunda görev yapıyorsanız koşul değişiyor: '
                .'en az 30 puanı A başlığından olmak kaydıyla toplamda 130 puan isteniyor.'
                : ''),
        'universite' => $UNIVERSITE,
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'cetvel' => $cetvel,
        'notlar' => "5.3 ({$alanAdi}): {$prAltAd} {$prAltPuan}; {$prUstAd} {$prUstPuan}; "
            .'toplam 130 (doçentlik sonrası).',
        'sart' => Kalip::ve("Profesör kadrosuna atanma — {$alanAdi}", [
            $besYil,
            $baslicaEser,
            Kalip::puanDan(
                "Doçentlik sonrası EK-1'in {$prAltAd} en az {$prAltPuan} puan",
                $prAltGrup, $prAltPuan, $DOCENTLIK, madde: '5.3',
            ),
            Kalip::puanDan(
                "Doçentlik sonrası EK-1'in {$prUstAd} en az {$prUstPuan} puan",
                $prUstGrup, $prUstPuan, $DOCENTLIK, madde: '5.3',
            ),
            Kalip::toplam(130, $DOCENTLIK),
        ]),
    ];
}

// ══════════════════════════════════════════════════════════════════════════
// GÜZEL SANATLAR TEMEL ALANI
// ══════════════════════════════════════════════════════════════════════════

$gsGovde = fn (int $ac, int $jBlok, int $jm, int $toplam, ?array $donem, string $md): array => [
    Kalip::puanDan("EK-1'in A-C başlıkları arasından en az {$ac} puan", ['A-C'], $ac, $donem, madde: $md),
    Kalip::puanDan(
        "EK-1'in J111, J1121, J1161 ve J1171 maddelerinden (eserin satın alınması veya yayında "
        ."yer alması, jürili kişisel sanat etkinliği, restorasyon yürütücülüğü) en az {$jBlok} puan",
        ['J-BLOK'], $jBlok, $donem, madde: $md,
    ),
    Kalip::puanDan("EK-1'in J-M başlıkları arasından en az {$jm} puan", ['J-M'], $jm, $donem, madde: $md),
    Kalip::toplam($toplam, $donem),
];

$esikler[] = [
    'anahtar' => 'dpu-gsf-dr-ilk',
    'aday_notu' => 'Güzel Sanatlar temel alanında Doktor Öğretim Üyesi kadrosuna ilk atanmada '
        .'EK-1\'in A-C başlıklarından en az 16 puan, J111/J1121/J1161/J1171 maddelerinden en az '
        .'24 puan, J-M başlıkları arasından en az 10 puan ve toplamda en az 50 puan isteniyor. '
        .'Ayrıca yabancı dilden, öğretim elemanı kadroları için belirlenen taban puanı almış '
        .'olmanız gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['guzel_sanatlar'],
    'cetvel' => 'dpu-2024-gsf',
    'notlar' => '5.1.1 (Güzel Sanatlar): A-C 16; J bloğu 24; J-M 10; toplam 50.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna ilk atanma — Güzel Sanatlar temel alanı',
        array_merge([$dil, $doktora], $gsGovde(16, 24, 10, 50, null, '5.1.1'))),
];

$esikler[] = [
    'anahtar' => 'dpu-gsf-dr-yeniden',
    'aday_notu' => 'Son atama döneminizdeki faaliyetleriniz sayılıyor. Güzel Sanatlar temel '
        .'alanında her yeniden atanma döneminde EK-1\'in A-C başlıklarından en az 16 puan, '
        .'J111/J1121/J1161/J1171 maddelerinden en az 24 puan, J-M başlıkları arasından en az 10 '
        .'puan ve toplamda en az 50 puan isteniyor. Puanı sağlayamazsanız bir defaya mahsus bir '
        .'yıl izleme süresi veriliyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => ['guzel_sanatlar'],
    'cetvel' => 'dpu-2024-gsf',
    'notlar' => '5.1.2 (Güzel Sanatlar): A-C 16; J bloğu 24; J-M 10; toplam 50.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna yeniden atanma — Güzel Sanatlar temel alanı',
        $gsGovde(16, 24, 10, 50, $SON_ATAMA, '5.1.2')),
];

$esikler[] = [
    'anahtar' => 'dpu-gsf-docentlik',
    'aday_notu' => 'Yönerge doçentlik kadrosuna atanmada ilave bir kriter aramıyor: '
        .'Üniversitelerarası Kurul tarafından düzenlenen doçentlik sınavından başarılı olmanız '
        .'yeterli.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['guzel_sanatlar'],
    'cetvel' => 'dpu-2024-gsf',
    'notlar' => '5.2.1: ÜAK doçentlik sınavı dışında ilave kriter yok.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — Güzel Sanatlar temel alanı', [$docentUnvani]),
];

$esikler[] = [
    'anahtar' => 'dpu-gsf-profesorluk',
    'aday_notu' => 'Doçentlik unvanınızı aldıktan sonraki çalışmalarınız sayılıyor. Güzel '
        .'Sanatlar temel alanında EK-1\'in A-C başlıklarından en az 20 puan, '
        .'J111/J1121/J1161/J1171 maddelerinden en az 48 puan, J-M başlıkları arasından en az 70 '
        .'puan ve toplamda en az 130 puan isteniyor. Başvurunuzda yayınlarınızdan birini başlıca '
        .'eser olarak göstermeniz gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['guzel_sanatlar'],
    'cetvel' => 'dpu-2024-gsf',
    'notlar' => '5.3 (Güzel Sanatlar): A-C 20; J bloğu 48; J-M 70; toplam 130 (doçentlik sonrası).',
    'sart' => Kalip::ve('Profesör kadrosuna atanma — Güzel Sanatlar temel alanı',
        array_merge([$besYil, $baslicaEser], $gsGovde(20, 48, 70, 130, $DOCENTLIK, '5.3'))),
];

return $esikler;
