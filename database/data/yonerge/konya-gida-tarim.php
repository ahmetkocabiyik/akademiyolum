<?php

/**
 * KONYA GIDA VE TARIM ÜNİVERSİTESİ — Öğretim Üyeliğine Atanma ve
 * Yükseltilme Kriterleri Yönergesi
 * Kaynak: pdf/17634002431.Konya Gıda ve Tarım Üniversitesi Kriter.pdf
 * (8 sayfa; YNRG.013, Senato 26.06.2024, YÖK onay 24.10.2024)
 *
 * ── YAPI ──
 * Tek puanlama tablosu (EK-1), koşullar madde 6'da üç eşik satırıyla
 * veriliyor: bir ARA TOPLAM ("A.1-6, B.1-5, C.1-6"), bir GENEL TOPLAM
 * ("Tüm Faaliyetler") ve doçentlik/profesörlükte bir MAKALE SAYISI.
 * Dr. Öğretim Üyeliğinde ara toplam ve genel toplam alandan bağımsız;
 * doçentlik ve profesörlükte iki alan grubu var:
 *   Sosyal, Beşerî ve İdari Bilimler → `sosyal`
 *   Fen, Mühendislik ve Tarım        → `fen`, `muhendislik`, `ziraat`
 *
 * ── EŞİK YAZILMAYAN ALANLAR ──
 * Yönerge yalnızca yukarıdaki beş temel alanı anıyor. Sağlık, eğitim,
 * hukuk, ilahiyat, filoloji, spor, mimarlık ve güzel sanatlar için eşik
 * YAZILMADI — üniversitenin fakülteleri de bu alanlarda değil.
 *
 * ── "KGTÜ ADRESLİ" KOŞULU UYGULANMIYOR ──
 * Dr. Öğretim Üyeliğine yeniden atanmada hem puan tablosu ("İlk atamadan
 * sonra, KGTÜ adresli olarak") hem de özgün yayın koşulu yayının KGTÜ
 * adresli olmasını istiyor. Faaliyet kaydı adres bilgisi taşımadığı için
 * bu koşul uygulanmıyor; başka kurum adresli yayınlarınız da sayılıyor,
 * yani puanınız olduğundan YÜKSEK görünebilir.
 *
 * ── DÖNEMLER ──
 * Dr. yeniden atanmada "ilk atamadan sonra" → `SON_ATAMA_SONRASI`.
 * Profesörlükte ara toplamın bir kısmı ("en az 20 / 40 puanı doçentlik
 * sonrası") → `DOCENTLIK_SONRASI`; kalan barajlar dönemsiz, yönerge
 * bütün akademik geçmişi sayıyor.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde 5-a: yabancı dille eğitim yapan bölümlerde YÖK yönetmeliğinin
 *       asgari dil koşulu ve 45 dakikalık deneme dersi. Yönerge sayısal
 *       bir dil puanı yazmıyor (madde 5-b Türkçe bölümlerde puanı
 *       senatoya bırakıyor); `beyan` olarak yazıldı, `Kalip::yds` yok.
 *   2547 sayılı Kanun ve Öğretim Üyeliğine Yükseltilme ve Atanma
 *       Yönetmeliğinin doçentlik unvanı, doktora ve süre koşulları —
 *       `beyan`.
 *   Dipnot [1]: yayınların yağmacı/şaibeli sayılmayan dergilerde olması.
 *       Q4 dergilerde ücret talebine ve derginin kurumsal niteliğine
 *       bağlı bir ayrım; kayıt bunu taşımıyor.
 *   Madde 13: yeniden atanmanın bir ile dört yıl arasında değişen
 *       süresi ve mütevelli heyet onayı — süreç kuralı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/konya-gida-tarim-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Konya Gıda ve Tarım Üniversitesi';
$CETVEL = 'konya-gida-tarim-2024';
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$ARA = ['ABC'];
// Adaya gösterilen küme adı (KONVANSIYONLAR §2); yönergenin madde kodları
// yalnızca `notlar`da ve düğümlerin `madde` alanında kalıyor.
$ARA_ADI = 'makale, bildiri ve kitap kalemleri';

$dil = Kalip::beyan(
    'Yabancı dille eğitim-öğretim yapan bölümlerde YÖK\'ün yabancı dille öğretim yeterliliği '
    .'için istediği asgari koşulları sağlamak ve Deneme Dersi Değerlendirme Komisyonu önünde '
    .'45 dakikalık deneme dersini başarıyla vermek',
    '5',
);

$doktora = Kalip::beyan('Doktora ya da tıpta uzmanlık unvanını almış olmak', '4');

$docentUnvani = Kalip::beyan('Doçentlik unvanını almış olmak', '4');

$besYil = Kalip::beyan(
    'Öğretim Üyeliğine Yükseltilme ve Atanma Yönetmeliği uyarınca doçent unvanını aldıktan sonra '
    .'en az beş yıl açık bulunan profesörlük kadrosuyla ilgili bilim alanında çalışmış olmak',
    '4',
);

/** 6.a.2: SCI/SCIE/SSCI/AHCI ya da ULAKBİM dergilerinde en az bir özgün yayın. */
$ozgunYayin = fn (?array $donem): array => Kalip::adet(
    'SCI, SCI-Expanded, SSCI, AHCI ya da ULAKBİM tarafından taranan dergilerde en az 1 özgün '
    .'yayında (tam metinli makale ya da tam metin basılmış bildiri) yer almış olmak',
    ['OZGUN'], 1, donem: $donem, madde: '6.a.2',
);

$esikler = [];

// ══════════════════════════════════════════════════════════════════════════
// DOKTOR ÖĞRETİM ÜYESİ (Madde 6.a)
// ══════════════════════════════════════════════════════════════════════════

foreach ([
    ['dr_ogr_uyesi', 'ilk', 5, 10, null],
    ['dr_ogr_uyesi_yeniden', 'yeniden', 10, 20, $SON_ATAMA],
] as [$kadro, $ek, $araPuan, $toplamPuan, $donem]) {
    $esikler[] = [
        'anahtar' => "kgtu-dr-{$ek}",
        'aday_notu' => ($donem === null
            ? 'Bütün akademik geçmişiniz sayılıyor. '
            : 'İlk atamanızdan sonraki çalışmalarınız sayılıyor. Yönerge bu çalışmaların KGTÜ '
                .'adresli olmasını istiyor; kayıt adres bilgisi taşımadığı için bu koşul '
                .'uygulanmıyor, başka kurum adresli yayınlarınız da sayılıyor. ')
            ."{$ARA_ADI} kapsamından en az {$araPuan} puan, tüm faaliyetlerinizden "
            ."en az {$toplamPuan} puan isteniyor. Ayrıca SCI, SCI-Expanded, SSCI, AHCI ya da "
            .'ULAKBİM dergilerinde en az bir özgün yayınınız olmalı. Bölüm Ç (h faktörü) '
            .'girilemediği için toplam puanınız olduğundan düşük görünür.',
        'universite' => $UNIVERSITE,
        'kadro' => $kadro,
        'alan' => ['sosyal', 'fen', 'muhendislik', 'ziraat'],
        'cetvel' => $CETVEL,
        'notlar' => "Madde 6.a: A.1-6+B.1-5+C.1-6'dan {$araPuan} puan, tüm faaliyetlerden "
            ."{$toplamPuan} puan; SCI/SSCI/AHCI/ULAKBİM'de en az 1 özgün yayın.",
        'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma', [
            $dil,
            $doktora,
            Kalip::puanDan(ucfirst($ARA_ADI)." kapsamından en az {$araPuan} puan", $ARA, $araPuan, $donem, madde: '6.a.1'),
            $ozgunYayin($donem),
            Kalip::toplam($toplamPuan, $donem),
        ]),
    ];
}

// ══════════════════════════════════════════════════════════════════════════
// DOÇENT VE PROFESÖR (Madde 6.b)
// ══════════════════════════════════════════════════════════════════════════

foreach ([
    ['sosyal', ['sosyal'], 'Sosyal, Beşerî ve İdari Bilimler Temel Alanı', 'A1235',
        'SCI-Expanded, SSCI, AHCI, ESCI, Scopus ve TR Dizin dergilerinde', 3, 20, 50, 5, 60, 20, 150],
    ['fen', ['fen', 'muhendislik', 'ziraat'], 'Fen, Mühendislik ve Tarım Temel Alanı', 'A123',
        'SCI-Expanded, SSCI, AHCI, ESCI ve Scopus dergilerinde', 3, 50, 100, 5, 100, 40, 200],
] as [$anahtar, $alanlar, $grupAdi, $makaleGrubu, $makaleAdi,
    $dcMakale, $dcAra, $dcToplam, $prMakale, $prAra, $prDocentlikSonrasi, $prToplam]) {
    $esikler[] = [
        'anahtar' => "kgtu-{$anahtar}-docentlik",
        'aday_notu' => "{$grupAdi} için doçentlik kadrosunda {$makaleAdi} toplam en az "
            ."{$dcMakale} makalede yer almanız, {$ARA_ADI} kapsamından en az {$dcAra} "
            ."puan ve tablonun tamamından en az {$dcToplam} puan almanız isteniyor. Yönerge bu "
            .'puanlar için dönem sınırı koymuyor, bütün akademik geçmişiniz sayılıyor. Bölüm Ç '
            .'(h faktörü) girilemediği için toplam puanınız olduğundan düşük görünür.',
        'universite' => $UNIVERSITE,
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => "Madde 6.b.1 ({$grupAdi}): {$makaleGrubu} grubundan {$dcMakale} makale; "
            ."A.1-6+B.1-5+C.1-6'dan {$dcAra} puan; tüm faaliyetlerden {$dcToplam} puan.",
        'sart' => Kalip::ve("Doçent kadrosuna atanma — {$grupAdi}", [
            $dil,
            $docentUnvani,
            Kalip::adet("{$makaleAdi} toplam en az {$dcMakale} makalede yer almak", [$makaleGrubu], $dcMakale, madde: '6.b.1'),
            Kalip::puanDan(ucfirst($ARA_ADI)." kapsamından en az {$dcAra} puan", $ARA, $dcAra, madde: '6.b.1'),
            Kalip::toplam($dcToplam),
        ]),
    ];

    $esikler[] = [
        'anahtar' => "kgtu-{$anahtar}-profesorluk",
        'aday_notu' => "{$grupAdi} için profesörlük kadrosunda {$makaleAdi} toplam en az "
            ."{$prMakale} makalede yer almanız, {$ARA_ADI} kapsamından en az {$prAra} "
            ."puan (bunun en az {$prDocentlikSonrasi} puanı doçentlik unvanını aldıktan sonra) "
            ."ve tablonun tamamından en az {$prToplam} puan almanız isteniyor. Bölüm Ç "
            .'(h faktörü) girilemediği için toplam puanınız olduğundan düşük görünür.',
        'universite' => $UNIVERSITE,
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => "Madde 6.b.1 ({$grupAdi}): {$makaleGrubu} grubundan {$prMakale} makale; "
            ."A.1-6+B.1-5+C.1-6'dan {$prAra} puan (en az {$prDocentlikSonrasi} puanı doçentlik "
            ."sonrası); tüm faaliyetlerden {$prToplam} puan.",
        'sart' => Kalip::ve("Profesör kadrosuna yükseltilme ve atanma — {$grupAdi}", [
            $dil,
            $besYil,
            Kalip::adet("{$makaleAdi} toplam en az {$prMakale} makalede yer almak", [$makaleGrubu], $prMakale, madde: '6.b.1'),
            Kalip::puanDan(ucfirst($ARA_ADI)." kapsamından en az {$prAra} puan", $ARA, $prAra, madde: '6.b.1'),
            Kalip::puanDan(
                "Bu puanın en az {$prDocentlikSonrasi} puanı doçentlik unvanını aldıktan sonra",
                $ARA, $prDocentlikSonrasi, $DOCENTLIK, madde: '6.b.1',
            ),
            Kalip::toplam($prToplam),
        ]),
    ];
}

return $esikler;
