<?php

use App\Services\Scoring\Sart\Kalip;

/**
 * İSTANBUL ATLAS ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltme ve Atanma
 * Ölçütleri Yönergesi
 * Kaynak: pdf/1778824161643.istanbul-atlas-kriter-15052026.pdf (13 sayfa)
 *
 * Cetvel: cetvel/istanbul-atlas-2026.php
 *
 * ── EŞİKLERİN YAPISI ──
 * MADDE 5 her kadro için iki paralel koşul yazıyor: genel kural ve Sanat,
 * Tasarım ve Mimarlık Fakültesinin TASARIM ALANINDAN başvuranlar için
 * ayrı kural. Genel kural bütün temel alanlar için aynı.
 *
 *   Kadro            Genel                     Tasarım Alanı
 *   Dr. Öğr. Üyesi   1.1+1.2'den 15, toplam 30 Sanat 15 + bilimsel 15, toplam 30
 *   Doçent           1.1+1.2'den 45, toplam 100 Sanat 45 + bilimsel 55, toplam 100
 *   Profesör         1.1+1.2'den 90, toplam 200 Sanat 90 + bilimsel 110, toplam 200
 *
 * ── YORUM KARARLARI (§0) ──
 *   "TASARIM ALANI" PROGRAM DÜZEYİNDE BİR AYRIM; kayıt temel alan
 *       tutuyor. Güzel Sanatlar temel alanı tasarım koluna, öteki on bir
 *       temel alan (mimarlık dâhil) genel kola bağlandı. Yönergenin
 *       kendi ifadesi de "Sanat, Tasarım ve Mimarlık Fakültesine TASARIM
 *       ALANI DIŞINDAN başvuracak adaylar" diyerek mimarlığı genel
 *       kurala bırakıyor.
 *   Yönerge doçentlik ve profesörlükte hiçbir dönem kısıtı koymuyor;
 *       puanlar bütün kariyer boyunca toplanıyor. Doçentlik sonrası pay
 *       ya da son yıl penceresi aranmadı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 7 (Tıp ve Diş Hekimliği Fakültelerinde istisnai haller):
 *       koşulları sağlayan aday bulunmaması hâlinde sağlamayan adayların
 *       da atanabilmesi. Kadro ilanına ve yönetim kurulu kararına bağlı.
 *   MADDE 4/2'nin EK-2 bildirim formu ve MADDE 6 (jüri görevlendirmeleri).
 *   Yönerge yabancı dil için ayrı bir baraj koymuyor; doktor öğretim
 *       üyeliği için yeniden atama ölçütü de tanımlamıyor.
 */
$GENEL_ALANLAR = ['fen', 'muhendislik', 'saglik', 'ziraat', 'sosyal', 'egitim', 'filoloji',
    'ilahiyat', 'spor', 'hukuk', 'mimarlik'];

$PUAN_NOTU = 'Scopus atıfları (atıf başına 0,5) ondalık olduğu için girilemedi; TÜBİTAK '
    .'projeleri ARDEB ile 1002 ayrılamadığından en düşük satırdan (yürütücü 10) sayılıyor; '
    .'bilimsel toplantı düzenleme, dergi hakemliği, yayın kurulu üyeliği, üniversitenin kendi '
    .'dergilerindeki yayınlar, h-indeksi ve patent BAŞVURULARI için satır girilmedi. Ders puanı '
    .'haftalık ders saati başına verildiği hâlde ders başına tek puan sayılıyor.';

$genel = fn (int $kitapMakale, int $toplam): array => Kalip::ve('Atama koşulları', [
    Kalip::toplam($kitapMakale, maddeler: ['KITAP-MAKALE'], liste: 'EK-1\'in 1.1 Kitaplar ve 1.2 Makaleler başlıkları'),
    Kalip::toplam($toplam, maddeler: ['TUM'], liste: 'EK-1'),
]);

$tasarim = fn (int $sanat, int $bilimsel, int $toplam): array => Kalip::ve('Atama koşulları', [
    Kalip::toplam($sanat, maddeler: ['SANAT'], liste: 'EK-1\'in 3. Sanatsal Faaliyetler bölümü'),
    Kalip::toplam($bilimsel, maddeler: ['BILIMSEL'], liste: 'EK-1\'in 1, 2 ve 4. bölümleri'),
    Kalip::toplam($toplam, maddeler: ['TUM'], liste: 'EK-1'),
]);

$docentBeyani = Kalip::beyan('Üniversitelerarası Kurul tarafından doçent unvanını almış olmak', 'MADDE 5/3');

return [
    [
        'anahtar' => 'istanbul-atlas-dr',
        'universite' => 'İstanbul Atlas Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $GENEL_ALANLAR,
        'birim' => null,
        'cetvel' => 'istanbul-atlas-2026',
        'notlar' => 'MADDE 5/2-a: en az 15 puanı 1.1 Kitaplar ve 1.2 Makaleler başlıklarından '
            .'olmak üzere toplamda 30 puan.',
        'aday_notu' => 'Barajın yarısı kitap ve makale kalemlerinden gelmek zorunda; bildiri, '
            .'proje, patent, ödül ve ders puanları yalnız kalan 15 puanı doldurabiliyor. '.$PUAN_NOTU,
        'sart' => $genel(15, 30),
    ],
    [
        'anahtar' => 'istanbul-atlas-docentlik',
        'universite' => 'İstanbul Atlas Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $GENEL_ALANLAR,
        'birim' => null,
        'cetvel' => 'istanbul-atlas-2026',
        'notlar' => 'MADDE 5/3-a: doçent unvanını almış olmak; en az 45 puanı 1.1 Kitaplar ve 1.2 '
            .'Makaleler başlıklarından olmak üzere toplamda 100 puan.',
        'aday_notu' => 'Yönerge doçentlikte dönem kısıtı koymuyor; doktora öncesi faaliyetleriniz '
            .'de toplama giriyor. '.$PUAN_NOTU,
        'sart' => Kalip::ve('Doçent kadrosuna atanma koşulları', [
            $docentBeyani,
            Kalip::toplam(45, maddeler: ['KITAP-MAKALE'], liste: 'EK-1\'in 1.1 Kitaplar ve 1.2 Makaleler başlıkları'),
            Kalip::toplam(100, maddeler: ['TUM'], liste: 'EK-1'),
        ]),
    ],
    [
        'anahtar' => 'istanbul-atlas-profesorluk',
        'universite' => 'İstanbul Atlas Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $GENEL_ALANLAR,
        'birim' => null,
        'cetvel' => 'istanbul-atlas-2026',
        'notlar' => 'MADDE 5/4-a: en az 90 puanı 1.1 Kitaplar ve 1.2 Makaleler başlıklarından '
            .'olmak üzere toplamda 200 puan.',
        'aday_notu' => 'Profesörlükte de dönem kısıtı yok; doçentlik sonrası için ayrı bir pay '
            .'ayrılmıyor. '.$PUAN_NOTU,
        'sart' => $genel(90, 200),
    ],
    [
        'anahtar' => 'istanbul-atlas-tasarim-dr',
        'universite' => 'İstanbul Atlas Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['guzel_sanatlar'],
        'birim' => null,
        'cetvel' => 'istanbul-atlas-2026',
        'notlar' => 'MADDE 5/2-b (Tasarım Alanı): Sanatsal Faaliyetler bölümünden en az 15 puan ve '
            .'Bilimsel Yayın, Araştırma-Yenilikçilik ile Eğitim-Öğretim bölümlerinden en az 15 '
            .'puan olmak üzere toplamda 30 puan.',
        'aday_notu' => 'Bu eşik Sanat, Tasarım ve Mimarlık Fakültesinin TASARIM ALANINDAN '
            .'başvuranlar içindir. Ayrım program düzeyinde; kayıt temel alan tuttuğu için Güzel '
            .'Sanatlar temel alanı bu kola bağlandı. Mimarlık, yönergenin kendi ifadesiyle '
            .'"Tasarım Alanı dışından" sayıldığı için genel kuraldan değerlendiriliyor. '.$PUAN_NOTU,
        'sart' => $tasarim(15, 15, 30),
    ],
    [
        'anahtar' => 'istanbul-atlas-tasarim-docentlik',
        'universite' => 'İstanbul Atlas Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['guzel_sanatlar'],
        'birim' => null,
        'cetvel' => 'istanbul-atlas-2026',
        'notlar' => 'MADDE 5/3-b (Tasarım Alanı): doçent unvanını almış olmak; Sanatsal '
            .'Faaliyetler bölümünden en az 45 puan ve öteki bölümlerden en az 55 puan olmak üzere '
            .'toplamda 100 puan.',
        'aday_notu' => 'Tasarım kolunda 100 puanın dağılımı belirlenmiş: 45 sanat, 55 bilimsel. '
            .'İkisinin toplamı zaten 100 olduğu için her iki payı da tam doldurmanız '
            .'gerekiyor. '.$PUAN_NOTU,
        'sart' => Kalip::ve('Doçent kadrosuna atanma koşulları', [
            $docentBeyani,
            Kalip::toplam(45, maddeler: ['SANAT'], liste: 'EK-1\'in 3. Sanatsal Faaliyetler bölümü'),
            Kalip::toplam(55, maddeler: ['BILIMSEL'], liste: 'EK-1\'in 1, 2 ve 4. bölümleri'),
            Kalip::toplam(100, maddeler: ['TUM'], liste: 'EK-1'),
        ]),
    ],
    [
        'anahtar' => 'istanbul-atlas-tasarim-profesorluk',
        'universite' => 'İstanbul Atlas Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['guzel_sanatlar'],
        'birim' => null,
        'cetvel' => 'istanbul-atlas-2026',
        'notlar' => 'MADDE 5/4-b (Tasarım Alanı): Sanatsal Faaliyetler bölümünden en az 90 puan ve '
            .'öteki bölümlerden en az 110 puan olmak üzere toplamda 200 puan.',
        'aday_notu' => 'Doçentlikteki gibi iki pay toplamda barajın tamamını kaplıyor: 90 sanat, '
            .'110 bilimsel. '.$PUAN_NOTU,
        'sart' => $tasarim(90, 110, 200),
    ],
];
