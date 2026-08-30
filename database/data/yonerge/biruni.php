<?php

use App\Services\Scoring\Sart\Kalip;

/**
 * BİRUNİ ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Yönergesi
 * Kaynak: pdf/17537097592.biruniuniversitesi.pdf
 * (6 sayfa; 05.07.2024 tarihli Senato Karar Eki)
 *
 * Cetvel: cetvel/biruni-2024.php
 *
 * KAYNAK PDF TARANMIŞ; 300 dpi görüntüden `tesseract -l tur` ile okundu.
 * Bkz. GIRILEMEYEN-YONERGELER.md, "Okuma engeli çözüldü".
 *
 * ── EŞİKLERİN YAPISI ──
 * Koşullar temel alana göre değişmiyor ve olağandışı biçimde kısa:
 *   Dr. Öğr. Üyesi (MADDE 5): son üç yılda EN AZ BİR yayın YA DA Ek-1'den
 *       250 puan. İki alternatiften biri yeterli.
 *   Doçent (MADDE 6): yalnızca doçentlik belgesi. Sayısal koşul YOK.
 *   Profesör (MADDE 7/1): doçentlik sonrası son beş yılda SSCI,
 *       SCI-Expanded ya da AHCI kapsamında en az iki özgün makale,
 *       birinde ilk isim.
 *   Profesör (MADDE 7/2, başka kurumda profesör olmuşsa): profesörlük
 *       sonrası WoS, ESCI ya da ulusal taranan dergilerde en az iki
 *       makale YA DA Ek-1'den 600 puan.
 *
 * ── YORUM KARARLARI (§0) ──
 *   MADDE 5'in "yayıma gönderilmiş" makaleyi de sayan kaydı uygulanmıyor;
 *       kayıt yalnız yayımlanmış eseri tutuyor. Koşul bu yönde SIKI.
 *   MADDE 7/2 ayrı bir kadro değil, aynı profesörlük kadrosunun ikinci
 *       yolu. İki fıkra `veya` ile birleştirildi: ya doçentlik sonrası
 *       iki WoS makalesi (biri ilk isim), ya profesörlük sonrası iki
 *       makale, ya 600 puan.
 *   MADDE 4/d'nin "öğretim dili İngilizce olan programlar" için yabancı
 *       dil koşulu programa bağlı; `beyan` olarak yazıldı. Yönerge genel
 *       bir dil barajı koymuyor — Ek-1'in B9.1 satırı dili PUANLI bir
 *       kalem yapıyor, koşul değil.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 4'ün kadro ilanı, ön değerlendirme komisyonu ve jüri sıralaması
 *       usulleri; MADDE 8-9 (yürürlük, yürütme).
 *   Yönerge doktor öğretim üyeliğinde yeniden atama için ayrı bir ölçüt
 *       tanımlamıyor; o kadroya ilk atamanın koşulu verildi.
 */
$TUM_ALANLAR = ['fen', 'muhendislik', 'saglik', 'ziraat', 'sosyal', 'egitim', 'filoloji',
    'ilahiyat', 'spor', 'hukuk', 'guzel_sanatlar', 'mimarlik'];

$DIL_BEYANI = Kalip::beyan(
    'Öğretim dili İngilizce olan bir programa başvuruyorsanız "Yükseköğretim Kurumlarında Yabancı Dil Öğretimi ve Yabancı Dille Öğretim Yapılmasında Uyulacak Esaslara İlişkin Yönetmelik" koşullarını sağlamak',
    'MADDE 4/d',
);

$PUAN_NOTU = 'WoS dışındaki uluslararası dergi atıfları (atıf başına 0,6) ondalık olduğu için '
    .'girilemedi; ulusal proje yürütücülüğünde puan proje bütçesine bağlı olduğundan en düşük '
    .'basamaktan (100) sayılıyor; yabancı dil satırı (75) ve proje BAŞVURULARI girilmedi. '
    .'Puan çizelgesinin makale bölümü yalnız Q1-Q3 satırı taşıyor; Q4 makaleleriniz "diğer uluslararası '
    .'dergi" satırından (20) sayılıyor.';

$drSart = Kalip::ve('Doktor öğretim üyesi koşulları', [
    $DIL_BEYANI,
    Kalip::veya('Son üç yılda bir yayın ya da tüm faaliyetlerinizden 250 puan', [
        Kalip::adet('Son üç yılda bilim alanınızla ilgili en az bir araştırma makalesi, derleme, tam metin bildiri ya da olgu sunumu', ['MAKALE-BILDIRI'], 1, donem: Kalip::sonYil(3), madde: 'MADDE 5/1'),
        Kalip::toplam(250, maddeler: ['TUM']),
    ]),
]);

return [
    [
        'anahtar' => 'biruni-dr',
        'universite' => 'Biruni Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $TUM_ALANLAR,
        'birim' => null,
        'cetvel' => 'biruni-2024',
        'notlar' => 'MADDE 5/1: son üç yılda ulusal ya da uluslararası hakemli dergide yayımlanmış '
            .'en az bir araştırma makalesi, derleme, tam metin bildiri veya olgu sunumu; ya da '
            .'tüm faaliyetlerinizden en az 250 puan.',
        'aday_notu' => 'İki alternatiften biri yeterli: son üç yılda tek bir yayın ya da tabloda '
            .'250 puan. Yönerge "yayıma gönderilmiş" makaleyi de sayıyor ama kayıt yalnız '
            .'yayımlanmış eseri tuttuğu için araç bu esnekliği gösteremiyor. '.$PUAN_NOTU,
        'sart' => $drSart,
    ],
    [
        'anahtar' => 'biruni-dr-yeniden',
        'universite' => 'Biruni Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $TUM_ALANLAR,
        'birim' => null,
        'cetvel' => 'biruni-2024',
        'notlar' => 'Yönerge yeniden atama için ayrı bir ölçüt tanımlamıyor; MADDE 5/1\'in ilk '
            .'atama koşulu uygulandı.',
        'aday_notu' => 'Yönergede yeniden atamaya ayrı bir baraj yok; araç ilk atamanın koşulunu '
            .'arıyor. '.$PUAN_NOTU,
        'sart' => $drSart,
    ],
    [
        'anahtar' => 'biruni-docentlik',
        'universite' => 'Biruni Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $TUM_ALANLAR,
        'birim' => null,
        'cetvel' => 'biruni-2024',
        'notlar' => 'MADDE 6/1: doçentlik belgesine sahip olmak. Puan ya da yayın barajı yok.',
        'aday_notu' => 'Biruni doçent kadrosu için üniversiteye özgü hiçbir sayısal koşul '
            .'koymuyor; tek şart doçentlik belgesi. '.$PUAN_NOTU,
        'sart' => Kalip::ve('Doçent kadrosuna atanma koşulları', [
            $DIL_BEYANI,
            Kalip::beyan('Doçentlik belgesine sahip olmak', 'MADDE 6/1'),
        ]),
    ],
    [
        'anahtar' => 'biruni-profesorluk',
        'universite' => 'Biruni Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $TUM_ALANLAR,
        'birim' => null,
        'cetvel' => 'biruni-2024',
        'notlar' => 'MADDE 7/1: doçentlik unvanından sonraki son beş yılda SSCI, SCI-Expanded ya '
            .'da AHCI kapsamındaki dergilerde en az iki özgün makale, birinde ilk isim. '
            .'MADDE 7/2 (başka kurumda profesör olmuşsa): profesörlük sonrası WoS, ESCI ya da '
            .'ulusal taranan dergilerde en az iki makale, ya da tüm faaliyetlerinizden en az 600 puan.',
        'aday_notu' => 'Yönergenin iki fıkrası profesörlüğün iki ayrı yolu: ilk kez '
            .'yükseltilenler için doçentlik sonrası son beş yılda iki WoS makalesi (birinde ilk '
            .'isim), başka kurumda profesör olmuşlar için iki makale ya da 600 puan. Üçü `veya` '
            .'ile birleştirildi. '.$PUAN_NOTU,
        'sart' => Kalip::ve('Profesör kadrosuna atanma koşulları', [
            $DIL_BEYANI,
            Kalip::veya('Aşağıdaki üç yoldan biri', [
                Kalip::ve('Doçentlik sonrası son beş yılda iki WoS makalesi', [
                    Kalip::adet('SSCI, SCI-Expanded ya da AHCI kapsamında en az iki özgün makale', ['WOS-MAKALE'], 2, donem: Kalip::sonYil(5), madde: 'MADDE 7/1'),
                    Kalip::adet('Bu makalelerin birinde ilk isim olmak', ['WOS-MAKALE'], 1, yazar: 'ilk', donem: Kalip::sonYil(5), madde: 'MADDE 7/1'),
                ]),
                Kalip::adet('Ya da WoS, ESCI ya da ulusal taranan dergilerde en az iki makale', ['WOS-ESCI-TRDIZIN'], 2, madde: 'MADDE 7/2'),
                Kalip::toplam(600, maddeler: ['TUM']),
            ]),
        ]),
    ],
];
