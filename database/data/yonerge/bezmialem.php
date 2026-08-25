<?php

/**
 * BEZMİÂLEM VAKIF ÜNİVERSİTESİ — Akademik Yükseltilme ve Atanma Yönergesi
 * Kaynak: pdf/17537097412.bezmialemuniversitesi.pdf
 *         (27.06.2018 tarihli ve 12 sayılı Senato kararı)
 *
 * KENDİ PUAN TABLOSU YOK, PUAN DA İSTEMİYOR. Koşulların tamamı "son beş yılda
 * SCI kapsamında N özgün araştırma makalesi, birinde/ikisinde 1. isim" biçiminde
 * sayı şartı. Cetvel olarak ÜAK doçentlik tablosu (`uak-2024-mart-{alan}`)
 * kullanıldı.
 *
 * KORPUSTA "SON BEŞ YIL" PENCERESİNİ HER KADRODA KULLANAN İLK YÖNERGE. Düzce
 * toplam puanın yanında son beş yıl barajı koyuyordu; Bezmiâlem ise makale
 * sayısının TAMAMINI son beş yıla bağlıyor. Pencere `Kalip::sonYil(5)` ile
 * girildi ve doçentlik/profesörlükte unvan penceresiyle BİRLİKTE uygulanıyor
 * (ör. profesörlükte "doçentlik sonrası VE son beş yıl").
 *
 * İKİ BİRİM GRUBU, HER KADRODA FARKLI SAYI:
 *   Tıp, Diş Hekimliği, Eczacılık Fakülteleri ve tüm Enstitüler
 *   Sağlık Bilimleri Fakültesi ve Meslek Yüksekokulları
 * Sağlık Bilimleri grubunun sayıları belirgin biçimde düşük (Dr. 1'e karşı 3,
 * doçent 3'e karşı 5). Ayrım temel alanla değil BİRİMLE ilgili olduğu için
 * `birim` alanı kullanıldı — üniversitenin bütün birimleri sağlık alanında.
 *
 * "1. İSİM" KOŞULU `ilk` ROLÜYLE GİRİLDİ. Profesörlükte Tıp grubunda "birisi
 * 1. isim ve bir diğeri 1. isim VEYA SON İSİM" deniyor; motorun rol sözlüğünde
 * "son isim" karşılığı olmadığı için ikinci koşul da `ilk` olarak girildi —
 * yani son yazar olduğu makaleyle bu şartı sağlayan aday burada sağlanmamış
 * görünür. Kural gereği eksik sayan taraf seçildi.
 *
 * DERLEME SINIRI UYGULANMIYOR: profesörlükte "bunlardan en fazla 2'si derleme
 * olabilir" deniyor. Motor bir sayı koşulunun içinde alt tür tavanı
 * tanımlamıyor; derlemeleri de sayan geniş küme kullanıldı, yani beş
 * makalesinin üçü derleme olan aday burada sağlanmış görünebilir.
 *
 * YENİDEN ATANMA GİRİLMEDİ (Madde 10-11): koşul atama süreleri sonuna ve
 * "Bezmiâlem adresli yayın" şartına bağlı; ikisi de profilde tutulmuyor.
 * Yeniden atanmada ayrıca 65 yabancı dil puanı isteniyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: uak-2024-mart-{alan}
 */

use App\Services\Scoring\Sart\Kalip;

/** Son beş yıl penceresi; her kadroda geçerli. */
$sonBes = Kalip::sonYil(5);
/** Doçentlik sonrası VE son beş yıl (profesörlük koşulu). */
$docSonBes = Kalip::sonYil(5, 'docentlik');
/** Doktora sonrası VE son beş yıl (doçentlik koşulu). */
$drSonBes = Kalip::sonYil(5, 'doktora');

/** SCI, SCI-Expanded, SSCI ve AHCI makaleleri. */
$sci = ['1a-*', '1b'];

$birimTip = 'Tıp, Diş Hekimliği ve Eczacılık Fakülteleri; tüm Enstitüler';
$birimSaglik = 'Sağlık Bilimleri Fakültesi; Sağlık Hizmetleri Meslek Yüksekokulu';

$alanlar = ['saglik', 'fen'];

$pencereNotu = 'Bezmiâlem makale sayısının TAMAMINI SON BEŞ YILA bağlıyor; daha eski '
    .'yayınlarınız bu koşula sayılmaz.';

$yenidenAtamaNotu = 'Yeniden atanmada Bezmiâlem adresli yayın şartı ve 65 yabancı dil puanı '
    .'isteniyor (Madde 10-11); yayının kurum adresi burada tutulmadığı için yeniden atanma '
    .'eşiği girilmedi.';

$derlemeNotu = 'Yönerge "bunlardan en fazla 2\'si derleme olabilir" diyor; motor bir sayı '
    .'koşulunun içinde alt tür tavanı tanımlayamadığı için bu sınır uygulanmıyor.';

$tezNotu = 'Ayrıca en az bir yüksek lisans, doktora veya uzmanlık tezi yönetmiş olmanız '
    .'gerekiyor (Madde 21). Kurumunuzda son beş yılda tez yapılmadığını belgelerseniz bu koşul '
    .'aranmıyor.';

return [
    // ══════════ DR. ÖĞRETİM ÜYESİ (Madde 9) ══════════
    [
        'anahtar' => 'bezmialem-dr-tip',
        'aday_notu' => $pencereNotu.' '.$yenidenAtamaNotu,
        'universite' => 'Bezmiâlem Vakıf Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'birim' => $birimTip,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 9: son beş yılda SCI/SCI-Expanded (uygun alanda SSCI veya AHCI) '
            .'dergilerde en az 3 makale, birinde 1. isim.',
        'sart' => Kalip::ve("Dr. Öğr. Üyesi — {$birimTip}", [
            Kalip::adet('Son beş yılda SCI, SCI-Expanded, SSCI veya AHCI dergilerde en az '
                .'3 makale', $sci, 3, donem: $sonBes, madde: 'Madde 9'),
            Kalip::adet('Bunlardan en az 1\'inde 1. isim olmalısınız', $sci, 1, 'ilk',
                $sonBes, madde: 'Madde 9'),
            Kalip::beyan('Doktora ya da tıpta, diş hekimliğinde, eczacılıkta veya veteriner '
                .'hekimlikte uzmanlık eğitimini tamamlamış olmak', 'Madde 5'),
        ]),
    ],
    [
        'anahtar' => 'bezmialem-dr-saglik',
        'aday_notu' => 'Bu birim grubunda Dr. Öğr. Üyeliği koşulu tek bir makaleye iniyor, ama '
            .'o makalede 1. isim olmanız şart. '.$pencereNotu.' '.$yenidenAtamaNotu,
        'universite' => 'Bezmiâlem Vakıf Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'birim' => $birimSaglik,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 9: son beş yılda SCI/SCI-Expanded (uygun alanda SSCI veya AHCI) '
            .'dergilerde 1. isim olduğunuz en az 1 özgün araştırma makalesi.',
        'sart' => Kalip::ve("Dr. Öğr. Üyesi — {$birimSaglik}", [
            Kalip::adet('Son beş yılda SCI, SCI-Expanded, SSCI veya AHCI dergilerde 1. isim '
                .'olduğunuz en az 1 özgün araştırma makalesi', $sci, 1, 'ilk', $sonBes,
                madde: 'Madde 9'),
            Kalip::beyan('Doktora ya da tıpta, diş hekimliğinde, eczacılıkta veya veteriner '
                .'hekimlikte uzmanlık eğitimini tamamlamış olmak', 'Madde 5'),
        ]),
    ],

    // ══════════ DOÇENT (Madde 15) ══════════
    [
        'anahtar' => 'bezmialem-docent-tip',
        'aday_notu' => 'Makaleler doktora ya da uzmanlık unvanınızı aldıktan SONRA ve son beş '
            .'yıl içinde olmalı; ayrıca tezinizden üretilmemiş olmalı (tez koşulu burada '
            .'hesaplanamadığı için beyan). '.$pencereNotu,
        'universite' => 'Bezmiâlem Vakıf Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'birim' => $birimTip,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 15: doktora/uzmanlık sonrası son beş yılda SCI dergilerde en az '
            .'5 özgün araştırma makalesi, ikisinde 1. isim.',
        'sart' => Kalip::ve("Doçent — {$birimTip}", [
            Kalip::adet('Doktora veya uzmanlık sonrası son beş yılda SCI, SCI-Expanded, SSCI '
                .'veya AHCI dergilerde en az 5 özgün araştırma makalesi', $sci, 5,
                donem: $drSonBes, madde: 'Madde 15'),
            Kalip::adet('Bunlardan en az 2\'sinde 1. isim olmalısınız', $sci, 2, 'ilk',
                $drSonBes, madde: 'Madde 15'),
            Kalip::beyan('Bu makalelerin doktora veya uzmanlık tezinizden üretilmemiş olması',
                'Madde 15'),
            Kalip::beyan('Doçentlik unvanını almış olmak ve Öğretim Üyeliğine Yükseltilme ve '
                .'Atanma Yönetmeliğinin 10. maddesine göre doçentlik sözlü sınavında başarılı '
                .'olmak', 'Madde 12'),
        ]),
    ],
    [
        'anahtar' => 'bezmialem-docent-saglik',
        'aday_notu' => 'Bu birim grubunda doçentlik koşulu 3 makale ve birinde 1. isim; Tıp '
            .'grubunda 5 makale ve ikisinde 1. isim isteniyor. Derleme de sayılabiliyor. '
            .$pencereNotu,
        'universite' => 'Bezmiâlem Vakıf Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'birim' => $birimSaglik,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 15: doktora/uzmanlık sonrası son beş yılda SCI dergilerde en az '
            .'3 özgün araştırma makalesi veya derleme, birinde 1. isim.',
        'sart' => Kalip::ve("Doçent — {$birimSaglik}", [
            Kalip::adet('Doktora veya uzmanlık sonrası son beş yılda SCI, SCI-Expanded, SSCI '
                .'veya AHCI dergilerde en az 3 makale ya da derleme', $sci, 3,
                donem: $drSonBes, madde: 'Madde 15'),
            Kalip::adet('Bunlardan en az 1\'inde 1. isim olmalısınız', $sci, 1, 'ilk',
                $drSonBes, madde: 'Madde 15'),
            Kalip::beyan('Bu makalelerin doktora veya uzmanlık tezinizden üretilmemiş olması',
                'Madde 15'),
            Kalip::beyan('Doçentlik unvanını almış olmak ve doçentlik sözlü sınavında başarılı '
                .'olmak', 'Madde 12'),
        ]),
    ],

    // ══════════ PROFESÖR (Madde 19-21) ══════════
    [
        'anahtar' => 'bezmialem-profesor-tip',
        'aday_notu' => 'Makalelerin tamamı doçentlik unvanınızı aldıktan SONRA ve son beş yıl '
            .'içinde olmalı. Yönerge ikinci makale için "1. isim VEYA SON İSİM" diyor; motorun '
            .'rol sözlüğünde "son isim" karşılığı olmadığı için burada ikisi de 1. isim olarak '
            .'aranıyor — son yazar olduğunuz makaleyle bu şartı sağlıyorsanız eşik olduğundan '
            .'zor görünür. '.$derlemeNotu.' '.$tezNotu,
        'universite' => 'Bezmiâlem Vakıf Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'birim' => $birimTip,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 20: doçentlik sonrası son beş yılda SCI dergilerde en az 5 özgün '
            .'araştırma makalesi veya derleme; birisi 1. isim, bir diğeri 1. isim veya son isim.',
        'sart' => Kalip::ve("Profesör — {$birimTip}", [
            Kalip::adet('Doçentliğinizden sonra son beş yılda SCI, SCI-Expanded, SSCI veya AHCI '
                .'dergilerde en az 5 makale ya da derleme', $sci, 5, donem: $docSonBes,
                madde: 'Madde 20'),
            Kalip::adet('Bunlardan en az 2\'sinde 1. isim olmalısınız', $sci, 2, 'ilk',
                $docSonBes, madde: 'Madde 20'),
            Kalip::beyan('En az bir yüksek lisans, doktora veya uzmanlık tezi yönetmiş olmak; '
                .'kurumunuzda son beş yılda tez yapılmadığını belgelerseniz bu koşul aranmaz',
                'Madde 21'),
            Kalip::beyan('Doçentlik unvanını aldıktan sonra en az beş yıl açık bulunan '
                .'profesörlük kadrosuyla ilgili bilim alanında çalışmış olmak', 'Madde 19'),
        ]),
    ],
    [
        'anahtar' => 'bezmialem-profesor-saglik',
        'aday_notu' => 'Makalelerin tamamı doçentlik unvanınızı aldıktan SONRA ve son beş yıl '
            .'içinde olmalı. '.$derlemeNotu.' '.$tezNotu,
        'universite' => 'Bezmiâlem Vakıf Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'birim' => $birimSaglik,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 20: doçentlik sonrası son beş yılda SCI dergilerde en az 3 özgün '
            .'araştırma makalesi veya derleme, 1\'i 1. isim.',
        'sart' => Kalip::ve("Profesör — {$birimSaglik}", [
            Kalip::adet('Doçentliğinizden sonra son beş yılda SCI, SCI-Expanded, SSCI veya AHCI '
                .'dergilerde en az 3 makale ya da derleme', $sci, 3, donem: $docSonBes,
                madde: 'Madde 20'),
            Kalip::adet('Bunlardan en az 1\'inde 1. isim olmalısınız', $sci, 1, 'ilk',
                $docSonBes, madde: 'Madde 20'),
            Kalip::beyan('En az bir yüksek lisans, doktora veya uzmanlık tezi yönetmiş olmak; '
                .'kurumunuzda son beş yılda tez yapılmadığını belgelerseniz bu koşul aranmaz',
                'Madde 21'),
            Kalip::beyan('Doçentlik unvanını aldıktan sonra en az beş yıl açık bulunan '
                .'profesörlük kadrosuyla ilgili bilim alanında çalışmış olmak', 'Madde 19'),
        ]),
    ],
];
