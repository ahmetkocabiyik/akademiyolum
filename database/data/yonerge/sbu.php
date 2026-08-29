<?php

use App\Services\Scoring\Sart\Kalip;

/**
 * SAĞLIK BİLİMLERİ ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma
 * Yönergesi
 * Kaynak: pdf/1765867210191.saglik-bilimleri-kriter-16122025.pdf
 * (11 sayfa; son değişiklik YÖK Genel Kurulu 27/11/2025)
 *
 * Cetvel: cetvel/sbu-2025.php
 *
 * KAYNAK PDF TARANMIŞ; 300 dpi görüntüden `tesseract -l tur` ile okundu.
 *
 * ── EŞİKLERİN YAPISI ──
 * Yönerge iki alan grubu tanıyor ve ikisi de aynı maddelerde yan yana
 * yazılmış:
 *   Sağlık, Mühendislik, Fen  Dr: A+B'den 30 + toplam 80
 *                             Doçent: A+B'den 60, C'den 10 + toplam 150
 *                             Profesör: A+B'den 80, C'den 20 + toplam 200
 *   Sosyal ve Spor            Dr: A+B'den 20 + toplam 60
 *                             Doçent: A+B'den 40 + toplam 120
 *                             Profesör: A+B'den 60, C'den 10 + toplam 150
 * Sosyal ve Spor doçentliğinde C bölümü için ayrı bir pay yok.
 *
 * ── YORUM KARARLARI (§0) ──
 *   ZİRAAT, MİMARLIK ve GÜZEL SANATLAR yönergede adıyla geçmiyor; §0
 *       uyarınca daha YÜKSEK eşikli Sağlık-Mühendislik-Fen grubuna
 *       bağlandı. Eğitim, İlahiyat, Hukuk ve Filoloji Sosyal Bilimler
 *       grubuna girdi.
 *   MADDE 13/2'nin BAŞLICA ARAŞTIRMA ESERİ koşulu derginin etki
 *       faktörünü de istiyor (Sağlık-Mühendislik-Fen'de en az 0,5;
 *       Sosyal ve Sporda 0,2). Kayıt etki faktörünü tutmuyor; koşulun
 *       yayın tarafı `adet` ile, etki faktörü tarafı `beyan` ile yazıldı.
 *   MADDE 8'in yeniden atama koşulu "ilk atama için gereken toplam puanın
 *       YARISINI İLAVE OLARAK tekrar karşılamak" diyor. Motor bir önceki
 *       atamada kullanılan puanı ayıramadığı için toplam, ilk atama
 *       barajının 1,5 katı olarak yazıldı (Sağlık-Mühendislik-Fen 120,
 *       Sosyal-Spor 90). MADDE 8/2 her yeniden atamada bu ilaveyi tekrar
 *       istiyor; araç yalnız ilk yeniden atamayı hesaplıyor.
 *   MADDE 8/3'ün muafiyeti ("doçentlik belgesi alan adaylar için başka
 *       koşul aranmaz") `veya` dalı olarak yazıldı.
 *   Yabancı dil MADDE 6, 10 ve 13'te 60 puan; yabancı dilde eğitim veren
 *       bölümlerde 85. Programa bağlı olduğu için genel eşik (60)
 *       yazıldı, istisna aday notunda anıldı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 4/3 (puanın tek başına öncelik sıralaması için kullanılamaması),
 *       4/4 (öncelikli alan kadrolarında ilave şart aranmaması).
 *   MADDE 7, 11, 14 (jüri oluşturma ve atama süreçleri), MADDE 15-19.
 *   MADDE 13/6'nın "son beş yılda ilgili kurumda tez yapılmadığının
 *       belgelenmesi hâlinde tez koşulu aranmaz" istisnası.
 *   Doçentlik ve profesörlükteki proje/patent koşulunun telafi yolları
 *       (Sağlık-Mühendislik-Fen'de makale sayısını 5 yerine 7, 2 yerine 4
 *       yapmak; Sosyal-Sporda iki ilave makale) `veya` ile girildi.
 */
$FEN = ['saglik', 'muhendislik', 'fen', 'ziraat', 'mimarlik', 'guzel_sanatlar'];
$SOSYAL = ['sosyal', 'egitim', 'ilahiyat', 'hukuk', 'filoloji', 'spor'];

$PUAN_NOTU = 'h-indeksi satırı, proje ve patent BAŞVURULARI, üniversitenin kendi '
    .'dergilerindeki yayınlar ve alanı kilitli satırlar cetvele girmedi. Atıf puanlarına '
    .'yönergenin koyduğu tavan ("gerekli asgari puanın %20\'si") kadroya bağlı olduğu için '
    .'uygulanmıyor; ulusal yayınların (en fazla 50), girişimcilik faaliyetlerinin (100) ve '
    .'eğitim-öğretim faaliyetlerinin (50) sabit tavanları uygulanıyor.';

$DIL = fn (): array => Kalip::yds(60);

$DIL_NOTU = 'Yabancı dil koşulu 60 puan; yabancı dilde eğitim veren bölümlere başvuruyorsanız '
    .'85 puan aranıyor ve araç bu istisnayı sormuyor.';

/**
 * Adaya gösterilen küme adları. Yönergenin Ek-1 bölüm harfleri yalnızca
 * `notlar`da ve düğümlerin `madde` alanında kalır (KONVANSIYONLAR §2).
 */
$YAYIN_ADI = 'Uluslararası ve ulusal yayın ve etkinlik';
$GIRISIM_ADI = 'Girişimci ve yenilikçi üniversite faaliyeti';

$projeVeyaPatent = fn (string $madde): array => Kalip::adet(
    'En az bir ulusal ya da uluslararası projede görev almış olmak veya patent/faydalı model belgesine sahip olmak',
    ['PROJE-PATENT'],
    1,
    madde: $madde,
);

return [
    // ══════════════ SAĞLIK, MÜHENDİSLİK, FEN ══════════════
    [
        'anahtar' => 'sbu-fen-dr',
        'universite' => 'Sağlık Bilimleri Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $FEN,
        'birim' => null,
        'cetvel' => 'sbu-2025',
        'notlar' => 'MADDE 6/2: SCI, SCI-Expanded, SSCI ya da AHCI kapsamında tezlerden '
            .'üretilmemiş en az 3 makale; bu şartı sağlayamayanlarda en az 1 böyle makale ile '
            .'birlikte alan indekslerinde en az 2 yayın. MADDE 6/3: A ve B kapsamından en az 30 '
            .'puan, tüm maddelerden toplam 80 puan. Yabancı dil 60.',
        'aday_notu' => 'Makale koşulunun iki yolu var: üç WoS makalesi ya da bir WoS makalesi + '
            .'iki alan indeksi yayını. '.$DIL_NOTU.' '.$PUAN_NOTU,
        'sart' => Kalip::ve('Doktor öğretim üyesi koşulları', [
            $DIL(),
            Kalip::beyan('Doktora ya da tıpta, diş hekimliğinde, eczacılıkta veya veteriner hekimlikte uzmanlık eğitimini tamamlamış olmak', 'MADDE 5/1'),
            Kalip::veya('WoS makale koşulunun iki yolundan biri', [
                Kalip::adet('SCI, SCI-Expanded, SSCI ya da AHCI kapsamında en az 3 makale', ['WOS-MAKALE'], 3, madde: 'MADDE 6/2'),
                Kalip::ve('Bir WoS makalesi ve iki alan indeksi yayını', [
                    Kalip::adet('SCI, SCI-Expanded, SSCI ya da AHCI kapsamında en az 1 makale', ['WOS-MAKALE'], 1, madde: 'MADDE 6/2'),
                    Kalip::adet('Alan indekslerinde taranan dergilerde en az 2 yayın', ['ALAN-INDEKSI'], 2, madde: 'MADDE 6/2'),
                ]),
            ]),
            Kalip::toplam(30, maddeler: ['AB'], liste: $YAYIN_ADI),
            Kalip::toplam(80, maddeler: ['TUM']),
        ]),
    ],
    [
        'anahtar' => 'sbu-fen-dr-yeniden',
        'universite' => 'Sağlık Bilimleri Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $FEN,
        'birim' => null,
        'cetvel' => 'sbu-2025',
        'notlar' => 'MADDE 8/1: ilk atama koşullarına ek olarak toplam puan şartının yarısını '
            .'ilave olarak karşılamak ve Sağlık Bilimleri Üniversitesi adıyla WoS kapsamında '
            .'birinci isim ya da sorumlu yazar olduğunuz en az 1 özgün araştırma makalesi. '
            .'MADDE 8/3: doçentlik belgesi alanlarda başka koşul aranmaz.',
        'aday_notu' => 'Yeniden atamada toplam baraj ilk atamanın 1,5 katı olarak (120) yazıldı; '
            .'yönerge "ilk atama için gereken puanın yarısını İLAVE olarak" istiyor ve motor bir '
            .'önceki atamada kullanılan puanı ayıramıyor. Doçentlik belgeniz varsa bu koşulların '
            .'hiçbiri aranmıyor. '.$PUAN_NOTU,
        'sart' => Kalip::veya('Yeniden atama koşulları', [
            Kalip::beyan('Üniversitelerarası Kuruldan doçentlik belgesi almış olmak (bu durumda başka koşul aranmaz)', 'MADDE 8/3'),
            Kalip::ve('Yeniden atama koşulları', [
                $DIL(),
                Kalip::adet('Üniversite adresli, WoS kapsamında birinci isim ya da sorumlu yazar olduğunuz en az 1 özgün araştırma makalesi', ['WOS-MAKALE'], 1, yazar: 'ilk', madde: 'MADDE 8/1'),
                Kalip::toplam(120, maddeler: ['TUM']),
            ]),
        ]),
    ],
    [
        'anahtar' => 'sbu-fen-docentlik',
        'universite' => 'Sağlık Bilimleri Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $FEN,
        'birim' => null,
        'cetvel' => 'sbu-2025',
        'notlar' => 'MADDE 10/2: WoS kapsamında tezlerden üretilmemiş en az 5 özgün araştırma '
            .'makalesi (en az 2\'si doktora sonrası, en az 1\'inde birinci isim). MADDE 10/3: '
            .'A ve/veya B\'den en az 60, C\'den en az 10 puan, toplam 150. MADDE 10/4: en az bir '
            .'projede görev ya da patent başvurusu; sağlanamıyorsa makale sayısı 7 olur.',
        'aday_notu' => 'Proje/patent koşulunu sağlayamıyorsanız yönerge alternatif sunuyor: beş '
            .'makale yerine yedi makale. İki yol da araca girildi. '.$DIL_NOTU.' '.$PUAN_NOTU,
        'sart' => Kalip::ve('Doçent kadrosuna atanma koşulları', [
            $DIL(),
            Kalip::beyan('Doçentlik unvanını almış olmak ya da yurt dışında alınan unvanın Üniversitelerarası Kurulca geçerli sayılması', 'MADDE 9/1'),
            Kalip::veya('Beş makale + proje ya da yedi makale', [
                Kalip::ve('Beş makale ve proje/patent koşulu', [
                    Kalip::adet('WoS kapsamında en az 5 özgün araştırma makalesi', ['WOS-MAKALE'], 5, madde: 'MADDE 10/2'),
                    $projeVeyaPatent('MADDE 10/4'),
                ]),
                Kalip::adet('Proje/patent koşulu yerine WoS kapsamında en az 7 özgün araştırma makalesi', ['WOS-MAKALE'], 7, madde: 'MADDE 10/4'),
            ]),
            Kalip::adet('Bu makalelerden en az 2\'si doktora sonrasında yayımlanmış olmalı', ['WOS-MAKALE'], 2, donem: Kalip::DOKTORA_SONRASI, madde: 'MADDE 10/2'),
            Kalip::adet('Bu makalelerden en az 1\'inde birinci isim olmak', ['WOS-MAKALE'], 1, yazar: 'ilk', madde: 'MADDE 10/2'),
            Kalip::toplam(60, maddeler: ['AB'], liste: $YAYIN_ADI),
            Kalip::toplam(10, maddeler: ['C'], liste: $GIRISIM_ADI),
            Kalip::toplam(150, maddeler: ['TUM']),
        ]),
    ],
    [
        'anahtar' => 'sbu-fen-profesorluk',
        'universite' => 'Sağlık Bilimleri Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $FEN,
        'birim' => null,
        'cetvel' => 'sbu-2025',
        'notlar' => 'MADDE 12/1: doçentlik sonrası en az beş yıl (en az iki yılı üniversitede ya '
            .'da eğitim-araştırma hastanesinde) çalışmış olmak. MADDE 13/2: başlıca araştırma '
            .'eseri olarak doçentlik sonrası WoS dergisinde birinci isim ve sorumlu yazar '
            .'olduğunuz, tezden üretilmemiş bir özgün makale (derginin etki faktörü en az 0,5). '
            .'MADDE 13/3: başlıca eser dışında doçentlik sonrası en az 2 özgün makale. '
            .'MADDE 13/4: A ve/veya B\'den 80, C\'den 20 puan, toplam 200. MADDE 13/5: proje ya '
            .'da patent; sağlanamıyorsa makale sayısı 4 olur. MADDE 13/6: en az bir tez yönetmiş '
            .'olmak.',
        'aday_notu' => 'Başlıca araştırma eserinin dergisinin etki faktörü koşulu (en az 0,5) '
            .'kayıttan doğrulanamıyor, beyan olarak duruyor. Proje/patent koşulunu '
            .'sağlayamıyorsanız iki makale yerine dört makale yolu var. Tez koşulunun "son beş '
            .'yılda kurumda tez yapılmadığı belgelenirse aranmaz" istisnası girilmedi. '
            .$DIL_NOTU.' '.$PUAN_NOTU,
        'sart' => Kalip::ve('Profesör kadrosuna atanma koşulları', [
            $DIL(),
            Kalip::beyan('Doçentlik unvanını aldıktan sonra en az beş yıl (en az iki yılı üniversitede ya da eğitim-araştırma hastanesinde) çalışmış olmak', 'MADDE 12/1'),
            Kalip::beyan('Başlıca araştırma eseri olarak sunduğunuz makalenin yayımlandığı derginin etki faktörünün son beş yılın herhangi birinde en az 0,5 olması', 'MADDE 13/2'),
            Kalip::adet('Doçentlik sonrası, WoS kapsamında birinci isim ve sorumlu yazar olduğunuz tezden üretilmemiş bir özgün araştırma makalesi (başlıca araştırma eseri)', ['WOS-MAKALE'], 1, yazar: 'ilk', donem: Kalip::DOCENTLIK_SONRASI, madde: 'MADDE 13/2'),
            Kalip::veya('İki makale + proje ya da dört makale', [
                Kalip::ve('İki makale ve proje/patent koşulu', [
                    Kalip::adet('Başlıca eser dışında doçentlik sonrası en az 2 özgün araştırma makalesi', ['WOS-MAKALE'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: 'MADDE 13/3'),
                    $projeVeyaPatent('MADDE 13/5'),
                ]),
                Kalip::adet('Proje/patent koşulu yerine doçentlik sonrası en az 4 özgün araştırma makalesi', ['WOS-MAKALE'], 4, donem: Kalip::DOCENTLIK_SONRASI, madde: 'MADDE 13/5'),
            ]),
            Kalip::adet('En az bir yüksek lisans, doktora ya da uzmanlık tezi yönetmiş olmak', ['TEZ'], 1, madde: 'MADDE 13/6'),
            Kalip::toplam(80, maddeler: ['AB'], liste: $YAYIN_ADI),
            Kalip::toplam(20, maddeler: ['C'], liste: $GIRISIM_ADI),
            Kalip::toplam(200, maddeler: ['TUM']),
        ]),
    ],

    // ══════════════ SOSYAL VE SPOR ══════════════
    [
        'anahtar' => 'sbu-sosyal-dr',
        'universite' => 'Sağlık Bilimleri Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $SOSYAL,
        'birim' => null,
        'cetvel' => 'sbu-2025',
        'notlar' => 'MADDE 6/2: WoS kapsamında en az 3 makale; ya da 1 WoS makalesi + alan '
            .'indekslerinde 2 yayın; ya da alan indeksleri, EBSCO, Index Copernicus veya '
            .'ULAKBİM taranan dergilerde 2 makale ile birlikte doktora tezinin kitap olarak '
            .'ya da tezden üretilmiş bir yayının bulunması. MADDE 6/3: A ve B\'den 20 puan, '
            .'toplam 60 puan.',
        'aday_notu' => 'Sosyal ve Spor Bilimlerinde üçüncü bir yol daha var: iki alan indeksi '
            .'makalesi + doktora tezinizin kitap olarak ya da tezden üretilmiş bir yayın olarak '
            .'çıkmış olması. '.$DIL_NOTU.' '.$PUAN_NOTU,
        'sart' => Kalip::ve('Doktor öğretim üyesi koşulları', [
            $DIL(),
            Kalip::beyan('Doktora ya da sanatta yeterlik eğitimini tamamlamış olmak', 'MADDE 5/1'),
            Kalip::veya('Makale koşulunun üç yolundan biri', [
                Kalip::adet('SCI, SCI-Expanded, SSCI ya da AHCI kapsamında en az 3 makale', ['WOS-MAKALE'], 3, madde: 'MADDE 6/2'),
                Kalip::ve('Bir WoS makalesi ve iki alan indeksi yayını', [
                    Kalip::adet('SCI, SCI-Expanded, SSCI ya da AHCI kapsamında en az 1 makale', ['WOS-MAKALE'], 1, madde: 'MADDE 6/2'),
                    Kalip::adet('Alan indekslerinde taranan dergilerde en az 2 yayın', ['ALAN-INDEKSI'], 2, madde: 'MADDE 6/2'),
                ]),
                Kalip::ve('İki alan indeksi makalesi ve doktora tezinden üretilmiş yayın', [
                    Kalip::adet('Alan indeksleri, EBSCO, Index Copernicus ya da ULAKBİM taranan dergilerde en az 2 makale', ['ALAN-INDEKSI'], 2, madde: 'MADDE 6/2'),
                    Kalip::adet('Doktora tezinizin kitap olarak ya da tezinizden üretilmiş bir yayın', ['A.3.a', 'A.3.b', 'A.3.c'], 1, madde: 'MADDE 6/2'),
                ]),
            ]),
            Kalip::toplam(20, maddeler: ['AB'], liste: $YAYIN_ADI),
            Kalip::toplam(60, maddeler: ['TUM']),
        ]),
    ],
    [
        'anahtar' => 'sbu-sosyal-dr-yeniden',
        'universite' => 'Sağlık Bilimleri Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $SOSYAL,
        'birim' => null,
        'cetvel' => 'sbu-2025',
        'notlar' => 'MADDE 8/1: ilk atama koşullarına ek olarak toplam puan şartının yarısını '
            .'ilave olarak karşılamak ve üniversite adıyla WoS kapsamında birinci isim ya da '
            .'sorumlu yazar olduğunuz en az 1 makale; Sosyal ve Sporda bu makale derleme ya da '
            .'alan indeksli bir dergide yabancı dilde yayın olarak da kabul ediliyor. '
            .'MADDE 8/3: doçentlik belgesi alanlarda başka koşul aranmaz.',
        'aday_notu' => 'Yeniden atamada toplam baraj ilk atamanın 1,5 katı olarak (90) yazıldı. '
            .'Doçentlik belgeniz varsa bu koşulların hiçbiri aranmıyor. '.$PUAN_NOTU,
        'sart' => Kalip::veya('Yeniden atama koşulları', [
            Kalip::beyan('Üniversitelerarası Kuruldan doçentlik belgesi almış olmak (bu durumda başka koşul aranmaz)', 'MADDE 8/3'),
            Kalip::ve('Yeniden atama koşulları', [
                $DIL(),
                Kalip::adet('Üniversite adresli, birinci isim ya da sorumlu yazar olduğunuz en az 1 makale', ['WOS-MAKALE', 'ALAN-INDEKSI'], 1, yazar: 'ilk', madde: 'MADDE 8/1'),
                Kalip::toplam(90, maddeler: ['TUM']),
            ]),
        ]),
    ],
    [
        'anahtar' => 'sbu-sosyal-docentlik',
        'universite' => 'Sağlık Bilimleri Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $SOSYAL,
        'birim' => null,
        'cetvel' => 'sbu-2025',
        'notlar' => 'MADDE 10/2: WoS kapsamında en az 5 özgün araştırma makalesi; sağlanamıyorsa '
            .'en az 2 WoS makalesi (birinde birinci isim) ve alan indeksli dergilerde yabancı '
            .'dilde en az 3 özgün araştırma makalesi. MADDE 10/3: A ve/veya B\'den 40 puan, '
            .'toplam 120. MADDE 10/4: proje ya da patent; sağlanamıyorsa doktora sonrası iki '
            .'ilave uluslararası makale.',
        'aday_notu' => 'Sosyal ve Sporda beş WoS makalesi yerine iki WoS + üç alan indeksi '
            .'makalesi yolu var; proje/patent koşulu için de iki ilave makale alternatifi '
            .'tanınıyor. '.$DIL_NOTU.' '.$PUAN_NOTU,
        'sart' => Kalip::ve('Doçent kadrosuna atanma koşulları', [
            $DIL(),
            Kalip::beyan('Doçentlik unvanını almış olmak ya da yurt dışında alınan unvanın Üniversitelerarası Kurulca geçerli sayılması', 'MADDE 9/1'),
            Kalip::veya('Makale koşulunun iki yolundan biri', [
                Kalip::adet('WoS kapsamında en az 5 özgün araştırma makalesi', ['WOS-MAKALE'], 5, madde: 'MADDE 10/2'),
                Kalip::ve('İki WoS makalesi ve üç alan indeksi makalesi', [
                    Kalip::adet('WoS kapsamında en az 2 özgün araştırma makalesi', ['WOS-MAKALE'], 2, madde: 'MADDE 10/2'),
                    Kalip::adet('Bu makalelerin birinde birinci isim olmak', ['WOS-MAKALE'], 1, yazar: 'ilk', madde: 'MADDE 10/2'),
                    Kalip::adet('Alan indeksli dergilerde yabancı dilde en az 3 özgün araştırma makalesi', ['ALAN-INDEKSI'], 3, madde: 'MADDE 10/2'),
                ]),
            ]),
            Kalip::veya('Proje/patent koşulu ya da iki ilave makale', [
                $projeVeyaPatent('MADDE 10/4'),
                Kalip::adet('Doktora sonrası uluslararası hakemli dergilerde en az 2 ilave makale', ['ALAN-INDEKSI'], 2, donem: Kalip::DOKTORA_SONRASI, madde: 'MADDE 10/4'),
            ]),
            Kalip::toplam(40, maddeler: ['AB'], liste: $YAYIN_ADI),
            Kalip::toplam(120, maddeler: ['TUM']),
        ]),
    ],
    [
        'anahtar' => 'sbu-sosyal-profesorluk',
        'universite' => 'Sağlık Bilimleri Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $SOSYAL,
        'birim' => null,
        'cetvel' => 'sbu-2025',
        'notlar' => 'MADDE 12/1: doçentlik sonrası en az beş yıl çalışmış olmak. MADDE 13/2: '
            .'başlıca araştırma eseri olarak doçentlik sonrası etki faktörü en az 0,2 olan bir '
            .'WoS dergisinde makale ya da tek yazarlı bir kitap. MADDE 13/3: doçentlik sonrası '
            .'en az 2 özgün makale (biri derleme olarak da kabul edilir). MADDE 13/4: A ve/veya '
            .'B\'den 60, C\'den 10 puan, toplam 150. MADDE 13/5: proje ya da patent; '
            .'sağlanamıyorsa iki ilave makale. MADDE 13/6: en az bir tez yönetmiş olmak.',
        'aday_notu' => 'Sosyal ve Sporda başlıca araştırma eseri tek yazarlı bir kitap da '
            .'olabiliyor; etki faktörü koşulu (en az 0,2) kayıttan doğrulanamadığı için beyan '
            .'olarak duruyor. '.$DIL_NOTU.' '.$PUAN_NOTU,
        'sart' => Kalip::ve('Profesör kadrosuna atanma koşulları', [
            $DIL(),
            Kalip::beyan('Doçentlik unvanını aldıktan sonra en az beş yıl ilgili bilim alanında çalışmış olmak', 'MADDE 12/1'),
            Kalip::beyan('Başlıca araştırma eseri olarak sunduğunuz makalenin dergisinin etki faktörünün en az 0,2 olması ya da eserin tek yazarlı bir kitap olması', 'MADDE 13/2'),
            Kalip::veya('Başlıca araştırma eseri: doçentlik sonrası WoS makalesi ya da tek yazarlı kitap', [
                Kalip::adet('Doçentlik sonrası WoS kapsamında bir makale', ['WOS-MAKALE'], 1, donem: Kalip::DOCENTLIK_SONRASI, madde: 'MADDE 13/2'),
                Kalip::adet('Doçentlik sonrası tek yazarlı bir bilimsel kitap', ['A.6', 'B.6'], 1, yazar: 'tek', donem: Kalip::DOCENTLIK_SONRASI, madde: 'MADDE 13/2'),
            ]),
            Kalip::veya('İki makale + proje ya da dört makale', [
                Kalip::ve('İki makale ve proje/patent koşulu', [
                    Kalip::adet('Başlıca eser dışında doçentlik sonrası en az 2 özgün araştırma makalesi', ['WOS-MAKALE', 'ALAN-INDEKSI'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: 'MADDE 13/3'),
                    $projeVeyaPatent('MADDE 13/5'),
                ]),
                Kalip::adet('Proje/patent koşulu yerine doçentlik sonrası en az 4 makale', ['WOS-MAKALE', 'ALAN-INDEKSI'], 4, donem: Kalip::DOCENTLIK_SONRASI, madde: 'MADDE 13/5'),
            ]),
            Kalip::adet('En az bir yüksek lisans, doktora ya da uzmanlık tezi yönetmiş olmak', ['TEZ'], 1, madde: 'MADDE 13/6'),
            Kalip::toplam(60, maddeler: ['AB'], liste: $YAYIN_ADI),
            Kalip::toplam(10, maddeler: ['C'], liste: $GIRISIM_ADI),
            Kalip::toplam(150, maddeler: ['TUM']),
        ]),
    ],
];
