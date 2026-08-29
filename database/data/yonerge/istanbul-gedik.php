<?php

use App\Services\Scoring\Sart\Kalip;

/**
 * İSTANBUL GEDİK ÜNİVERSİTESİ — Akademik Yükseltme ve Atama Yönergesi
 * Kaynak: pdf/17537099642.istanbulgedikuniversitesi.pdf (7 sayfa)
 *
 * Cetvel: cetvel/istanbul-gedik-2025.php
 *
 * ── EŞİKLERİN YAPISI ──
 * Puanlama tablosu tek; ayrışma yalnız doktor öğretim üyeliğinde ve
 * temel alana göre (MADDE 6):
 *   6.1 Mühendislik ve Sağlık Bilimleri — bir uluslararası alan indeksli
 *       araştırma makalesi + 20 puan
 *   6.2 Sosyal Bilimler — bir makale ya da kitap/kitap bölümü + 15 puan
 *   6.3 Mimarlık ve Tasarım — bir makale ya da yarışma derecesi/jüri
 *       üyeliği ya da uygulama projesi + 15 puan
 * Doçentlik (120 puan, en az 20'si doçentlik başvurusu sonrası) ve
 * profesörlük (150 puan, en az 50'si doçentlik başvurusu sonrası) temel
 * alandan bağımsız. MADDE 6.4 meslek yüksekokulları ve yüksekokullar
 * için adayın ALANINA göre aynı bentleri işaret ediyor, yani `birim`
 * ayrımı gerekmiyor.
 *
 * ── YORUM KARARLARI (§0) ──
 *   YÖNERGE ÜÇ ALAN GRUBU SAYIYOR, KAYIT ON İKİ TEMEL ALAN TAŞIYOR.
 *       Fen Bilimleri ve Ziraat yönergede adıyla geçmiyor; ikisi de
 *       Mühendislik-Sağlık koluna (20 puan, uluslararası makale şartı)
 *       bağlandı — §0 uyarınca daha YÜKSEK eşik seçildi. Eğitim,
 *       İlahiyat, Hukuk, Filoloji ve Spor Sosyal Bilimler koluna girdi.
 *       Güzel Sanatlar da Sosyal koluna bağlandı: Mimarlık-Tasarım
 *       kolunun yarışma seçeneği daha gevşek, §0 daha DAR olanı seçmeyi
 *       söylüyor. Güzel sanatlar adayıysanız yarışma dereceniz ön koşulu
 *       karşılamıyor gibi görünebilir.
 *   MADDE 6.3'ün "Döner Sermaye ya da üniversiteye bağlı kuruluşlar
 *       aracılığıyla bir uygulama projesi yaparak yayımlamış olmak"
 *       seçeneği girilmedi; kayıtta uygulama projesi etiketi yok.
 *   Doçentlik ve profesörlükteki "doçentlik BAŞVURUSU yaptıktan sonrası"
 *       kaydı `DOCENTLIK_SONRASI` penceresiyle yazıldı. Motor doçentlik
 *       UNVANININ alındığı tarihi tutuyor; başvuru ile unvan arasındaki
 *       çalışmalarınız bu pencerenin dışında kalıyor ve koşul gerçeğinden
 *       SIKI çalışıyor.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 10: yabancı dille öğretim yapan bölüm kadrolarında ilgili
 *       yönetmeliğin dil yeterliliği. Yönerge genel bir YDS/YÖKDİL
 *       barajı koymuyor, koşul yalnız bu bölümler için geçerli ve
 *       muafiyetleri var; eşiklere dil düğümü yazılmadı.
 *   MADDE 9'un ön değerlendirme komisyonu usulü.
 *   Tablo açıklama 4 ("içeriği aynı olan birden fazla yayından yalnız en
 *       yüksek puanlı olanı sayılır") — eser bazlı bir kural.
 *   Yönerge doktor öğretim üyeliğinde YENİDEN ATAMA için ayrı bir koşul
 *       tanımlamıyor; o kadro için eşik yazılmadı.
 */
$MUH_SAGLIK = ['muhendislik', 'saglik', 'fen', 'ziraat'];
$SOSYAL = ['sosyal', 'egitim', 'ilahiyat', 'hukuk', 'filoloji', 'spor', 'guzel_sanatlar'];
$TUM_ALANLAR = [...$MUH_SAGLIK, ...$SOSYAL, 'mimarlik'];

$PUAN_NOTU = 'Üniversitenin kendi BAP projeleri EK-2 tablosunda hiç geçmiyor; lisansüstü tezden '
    .'üretilmiş yayın, idari görev, toplumsal katkı ve yarışma dışındaki ödüller için de satır '
    .'yok, bu kayıtlar toplama girmiyor. Eş danışmanlık ile tezsiz yüksek lisans danışmanlığı '
    .'girilmedi. J bölümünün "son iki yılda alınan dersler" kaydı uygulanamadığı için daha eski '
    .'dersleriniz de sayılıyor.';

$docentlik = Kalip::ve('Doçent kadrosuna atanma koşulları', [
    Kalip::beyan('Doçentlik Yönetmeliği ve Doçentlik Başvuru Şartlarına uygun olarak doçent unvanını almış olmak', 'MADDE 7'),
    Kalip::toplam(120, maddeler: ['TUM'], liste: 'EK-2'),
    Kalip::toplam(20, donem: Kalip::DOCENTLIK_SONRASI, maddeler: ['TUM'], liste: 'EK-2'),
]);

$profesorluk = Kalip::ve('Profesör kadrosuna atanma koşulları', [
    Kalip::beyan('Yayınlarınızdan birini başlıca araştırma eseri olarak göstermiş olmak', 'MADDE 8'),
    Kalip::toplam(150, maddeler: ['TUM'], liste: 'EK-2'),
    Kalip::toplam(50, donem: Kalip::DOCENTLIK_SONRASI, maddeler: ['TUM'], liste: 'EK-2'),
]);

return [
    [
        'anahtar' => 'istanbul-gedik-dr-muhendislik-saglik',
        'universite' => 'İstanbul Gedik Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $MUH_SAGLIK,
        'birim' => null,
        'cetvel' => 'istanbul-gedik-2025',
        'notlar' => 'MADDE 6.1: en az bir uluslararası alan indeksinde taranan dergide yayımlanmış '
            .'araştırma makalesi ve EK-2 tablosundan en az 20 puan.',
        'aday_notu' => 'Yönerge yalnız üç alan grubu sayıyor: Mühendislik-Sağlık, Sosyal Bilimler ve '
            .'Mimarlık-Tasarım. Fen Bilimleri ile Ziraat adıyla geçmediği için bu gruba bağlandı; '
            .'ikisi de daha yüksek olan 20 puanlık eşiği ve uluslararası makale ön koşulunu '
            .'karşılamak durumunda görünüyor. '.$PUAN_NOTU,
        'sart' => Kalip::ve('Doktor öğretim üyesi koşulları', [
            Kalip::adet('Uluslararası alan indekslerinde taranan bir dergide yayımlanmış araştırma makalesi', ['MAKALE-ULUS'], 1, madde: 'MADDE 6.1'),
            Kalip::toplam(20, maddeler: ['TUM'], liste: 'EK-2'),
        ]),
    ],
    [
        'anahtar' => 'istanbul-gedik-dr-sosyal',
        'universite' => 'İstanbul Gedik Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $SOSYAL,
        'birim' => null,
        'cetvel' => 'istanbul-gedik-2025',
        'notlar' => 'MADDE 6.2: ön koşul olarak en az bir araştırma makalesi ya da kitap ya da kitap '
            .'içinde bölüm; EK-2 tablosundan en az 15 puan.',
        'aday_notu' => 'Sosyal Bilimler kolunda ön koşul esnek: bir makale, bir kitap ya da bir kitap '
            .'bölümü yeterli. Güzel Sanatlar yönergede adıyla geçmiyor; Mimarlık-Tasarım kolunun '
            .'yarışma seçeneği daha gevşek olduğu için bu koldan değerlendiriliyor, yani yarışma '
            .'dereceniz ön koşulu tek başına karşılamıyor gibi görünebilir. '.$PUAN_NOTU,
        'sart' => Kalip::ve('Doktor öğretim üyesi koşulları', [
            Kalip::veya('En az bir araştırma makalesi, kitap ya da kitap bölümü', [
                Kalip::adet('Hakemli bir dergide yayımlanmış araştırma makalesi', ['MAKALE'], 1, madde: 'MADDE 6.2'),
                Kalip::adet('Bilimsel kitap ya da kitap bölümü', ['KITAP'], 1, madde: 'MADDE 6.2'),
            ]),
            Kalip::toplam(15, maddeler: ['TUM'], liste: 'EK-2'),
        ]),
    ],
    [
        'anahtar' => 'istanbul-gedik-dr-mimarlik',
        'universite' => 'İstanbul Gedik Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['mimarlik'],
        'birim' => null,
        'cetvel' => 'istanbul-gedik-2025',
        'notlar' => 'MADDE 6.3: ön koşul olarak en az bir araştırma makalesi ya da bir yarışmada jüri '
            .'üyeliği/derece/mansiyon ya da yayımlanmış bir uygulama projesi; EK-2 tablosundan en az '
            .'15 puan.',
        'aday_notu' => 'Ön koşulun üçüncü seçeneği ("Döner Sermaye ya da üniversiteye bağlı kuruluşlar '
            .'aracılığıyla yapılan uygulama projesini yayımlamış olmak") kayıtta karşılığı olmadığı '
            .'için girilmedi; yalnız makale ve yarışma seçenekleri aranıyor. '.$PUAN_NOTU,
        'sart' => Kalip::ve('Doktor öğretim üyesi koşulları', [
            Kalip::veya('En az bir araştırma makalesi ya da yarışma derecesi/jüri üyeliği', [
                Kalip::adet('Hakemli bir dergide yayımlanmış araştırma makalesi', ['MAKALE'], 1, madde: 'MADDE 6.3'),
                Kalip::adet('Yarışmada jüri üyeliği ya da derece/mansiyon', ['YARISMA'], 1, madde: 'MADDE 6.3'),
            ]),
            Kalip::toplam(15, maddeler: ['TUM'], liste: 'EK-2'),
        ]),
    ],
    [
        'anahtar' => 'istanbul-gedik-docentlik',
        'universite' => 'İstanbul Gedik Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $TUM_ALANLAR,
        'birim' => null,
        'cetvel' => 'istanbul-gedik-2025',
        'notlar' => 'MADDE 7: EK-2 tablosundan en az 120 puan; 120 puanın en az 20\'si doçentlik '
            .'başvurusundan sonraki çalışmalardan.',
        'aday_notu' => 'Yönerge "doçentlik BAŞVURUSU yaptıktan sonrası" diyor; motor doçentlik '
            .'UNVANININ alındığı tarihi tuttuğu için başvuru ile unvan arasındaki çalışmalarınız 20 '
            .'puanlık paya girmiyor, koşul gerçeğinden sıkı çalışıyor. '.$PUAN_NOTU,
        'sart' => $docentlik,
    ],
    [
        'anahtar' => 'istanbul-gedik-profesorluk',
        'universite' => 'İstanbul Gedik Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $TUM_ALANLAR,
        'birim' => null,
        'cetvel' => 'istanbul-gedik-2025',
        'notlar' => 'MADDE 8: EK-2 tablosundan en az 150 puan; 150 puanın en az 50\'si doçentlik '
            .'başvurusundan sonraki çalışmalardan. Yayınlardan biri başlıca araştırma eseri olarak '
            .'gösterilir.',
        'aday_notu' => 'Doçentlikteki gibi, "doçentlik başvurusu sonrası" penceresi unvan tarihinden '
            .'başlatıldığı için 50 puanlık pay gerçeğinden dar hesaplanıyor. '.$PUAN_NOTU,
        'sart' => $profesorluk,
    ],
];
