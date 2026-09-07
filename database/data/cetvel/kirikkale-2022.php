<?php

use App\Enums\Kategori;

/**
 * KIRIKKALE ÜNİVERSİTESİ — Bölüm 4: Puanlama ve Değerlendirme Sistemi
 * Kaynak: pdf/1770041063500.kirikkale-kriter-02022026.pdf (17 sayfa;
 * Senato 02.12.2022-29/02)
 *
 * MADDE KODLARI YÖNERGENİN KENDİSİ: bölüm numarası + satır numarası
 * (`41-1`, `4.14`'ün satırları `414-1` …). Koşullar hem bölüme ("Bölüm
 * 4.1., 4.2., … 4.6. kapsamında en az 150 puan") hem satıra ("4.1.1.
 * maddesi kapsamında en az 3 yayın") atıf yaptığı için ikisi de `gruplar`
 * altında tanımlandı. Bize ait olan tek şey çeyrekliğe göre bölünen
 * 4.1.1 satırının `-Q1..-Q4` ekleri ve rol başına bölünen proje
 * satırlarının `-y`, `-a`, `-d` ekleri.
 *
 * ── PROJE PUANLARI İKİ KEZ İNDİRİLDİ ──
 * 4.14'ün rol tablosu yürütücüye %100, araştırmacıya %75, danışmana %50,
 * bursiyere %25 veriyor; dipnot ise projenin durumuna göre ikinci bir
 * çarpan uyguluyor (başvuru %25, kabul edilmiş/devam eden %50, sonuç
 * raporu kabul edilmiş %100). Kayıt projenin tamamlanıp tamamlanmadığını
 * taşımadığı için §0 uyarınca DEVAM EDEN varsayımı (%50) alındı ve
 * çarpımlar aşağı yuvarlandı. Tamamlanmış projeniz varsa puanınız
 * OLDUĞUNDAN DÜŞÜK görünür.
 *
 * ── AYNI KAYNAĞA DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   4.1.5 "yukarıdaki maddelerde belirtilen puanların yarısı" satırı kısa
 *       yayın türleri için ayrı satırlara açıldı; SCI kapsamında hangi
 *       çeyrekliğin yarısı olduğu belirsiz olduğu için en düşük
 *       çeyrekliğin yarısı (40) alındı.
 *   4.2.2 uluslararası özet bildiri (20) ile 4.2.3 yayımlanmamış poster
 *       (10): tek 'Uluslararası Özet/Poster' etiketi → 10. Ulusal karşılığı
 *       (10/5) → 5.
 *   4.7'de editörlük, yardımcı editörlük (yarısı) ve hakemlik (dörtte
 *       biri) tek etikete düştüğü için SCI dergilerinde 75, hakemlikte 25.
 *   4.10'da yurt dışı (30) ve yurt içi (20) burs → 20; ödüllerde ulusal
 *       düzey → 50.
 *   4.15'te uluslararası davetli konuşmacılık (40) ile ulusal (20) → 20;
 *       toplantı düzenleme görevleri (60/40/30/15) → 15.
 *   4.6'nın sanat satırlarında uluslararası/ulusal ve kişisel/karma
 *       ayrımı taşımayan etiketler en düşük satıra düşürüldü.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   4.9.2 patent BAŞVURUSU (100) — tescilliden ayrılamıyor.
 *   4.4.6 basılmış ders notu, 4.7.8 sanat/sergi katalog yazarlığı,
 *       4.13.3 Bologna etkinlikleri, 4.13.4 öğrenci değerlendirmesi,
 *       4.15'in laboratuvar/kamp/yarışma düzenleme, kurs katılımı ve
 *       teknopark satırları, 4.6'nın spor hakemliği ve antrenörlük
 *       satırları — sözlükte karşılık yok.
 *   Ansiklopedi maddesi ve dergi yayın kurulu üyeliği — tabloda karşılık
 *       gelen satır yok.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   "Aynı kitapta en fazla 2 bölüm", "bir yayın için en fazla 5 atıf",
 *       "her yıl için en fazla 5 ders", "son 3 yılda" gibi eser, yıl ve
 *       pencere bazlı sınırlar.
 *   4.11.6: adayın isim olarak yer aldığı yayınlardaki atıflara yarım
 *       puan verilmesi — atıf kaydı bunu ayırmıyor.
 *   Tablo 1'in "sorumlu yazar birinci isim yazar kadar puan alır" kuralı
 *       `baslica` rolüne birinci isim satırı verilerek karşılandı.
 *
 * Yönerge: yonerge/kirikkale.php
 */
$SCI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];
$OZGUN = ['ozgun_makale'];
$KISA = ['derleme', 'kisa_makale', 'vaka_teknik_not'];

$sanatSatinU = ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Müzeye Kabulü (Yurt Dışı)',
    'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)'];
$sanatSatinN = ['Eserin Satın Alınması (Yurt İçi)', 'Eserin Müzeye Kabulü (Yurt İçi)',
    'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'];
$sanatKarmaU = ['Karma/Jürili Etkinlik (Uluslararası)', 'Elektronik Karma Sergi (Uluslararası)',
    'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)',
    'Oda Müziği Grup Üyeliği (Uluslararası)'];
$sanatKarmaN = ['Karma/Jürili Etkinlik (Ulusal)', 'Elektronik Karma Sergi (Ulusal)',
    'Karma Etkinlik (Jürisiz, Ulusal)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)',
    'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)',
    'Oda Müziği Grup Üyeliği (Ulusal)', 'Orkestra / Koro Üyeliği'];
$sanatKisiselU = ['Kişisel Etkinlik (Uluslararası)', 'Elektronik Kişisel Sergi (Uluslararası)',
    'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)',
    'Resital (Uluslararası)', 'Solistlik (Uluslararası)', 'Şan Resitali (Uluslararası)',
    'Opera Birinci Rol (Uluslararası)'];
$sanatKisiselN = ['Kişisel Etkinlik (Ulusal)', 'Elektronik Kişisel Sergi (Ulusal)',
    'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)',
    'Resital (Ulusal)', 'Solistlik (Ulusal)', 'Şan Resitali (Ulusal)', 'Opera Birinci Rol (Ulusal)'];
$sanatTasarim = ['Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip',
    'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman',
    'Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)',
    'Özgün Eser / Beste / Tasarım'];
$sanatSahneU = ['Rejisörlük (Uluslararası)', 'Yönetmenlik (Sahne/Ekran)', 'Koreografi',
    'Bale/Dans Koreograflığı (Uluslararası)', 'Orkestra Şefliği (Uluslararası)',
    'Koro Şefliği (Uluslararası)', 'Belgesel/Kısa Film (Uluslararası)'];
$sanatSahneN = ['Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)',
    'Bale/Dans Koreograflığı (Ulusal)', 'Orkestra Şefliği (Ulusal)', 'Koro Şefliği (Ulusal)',
    'Belgesel/Kısa Film (Ulusal)'];
$sanatAlbumU = ['Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)'];
$sanatAlbumN = ['Karma Albüm / CD-DVD Katkısı'];
$sanatJuri = ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)',
    'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'];

$sanatKullanilan = array_merge($sanatSatinU, $sanatSatinN, $sanatKarmaU, $sanatKarmaN,
    $sanatKisiselU, $sanatKisiselN, $sanatTasarim, $sanatSahneU, $sanatSahneN,
    $sanatAlbumU, $sanatAlbumN, $sanatJuri);
$sanatKalan = array_values(array_diff(Kategori::SanatselEtkinlik->kaynaklar(), $sanatKullanilan));

/** Proje satırı: rol yüzdesi × "devam eden proje" varsayımı (%50), aşağı yuvarlanmış. */
$proje = function (string $kod, string $ad, array $kaynaklar, int $taban): array {
    $y = (int) floor($taban * 0.5);

    return [
        "{$kod}-y" => ['baslik' => "{$ad} — yürütücü", 'kategori' => 'proje', 'kaynaklar' => $kaynaklar, 'roller' => ['yurutucu'], 'puan' => $y],
        "{$kod}-a" => ['baslik' => "{$ad} — araştırmacı", 'kategori' => 'proje', 'kaynaklar' => $kaynaklar, 'roller' => ['arastirmaci'], 'puan' => (int) floor($taban * 0.5 * 0.75)],
        "{$kod}-d" => ['baslik' => "{$ad} — danışman ya da bursiyer", 'kategori' => 'proje', 'kaynaklar' => $kaynaklar, 'roller' => ['danisman', 'bursiyer'], 'puan' => (int) floor($taban * 0.5 * 0.25)],
    ];
};

$maddeler = array_merge([
    // ══ 4.1 MAKALELER ══
    '41-1-Q1' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI kapsamındaki Q1 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $OZGUN, 'puan' => 130],
    '41-1-Q2' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI kapsamındaki Q2 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $OZGUN, 'puan' => 100],
    '41-1-Q3' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI kapsamındaki Q3 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $OZGUN, 'puan' => 90],
    '41-1-Q4' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI kapsamındaki Q4 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => $OZGUN, 'puan' => 80],
    '41-2' => ['baslik' => 'Uluslararası alan indekslerinde taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $OZGUN, 'puan' => 60],
    '41-3' => ['baslik' => 'Hakemli bilimsel ya da sanatsal dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $OZGUN, 'puan' => 50],
    '41-4' => ['baslik' => 'Diğer bilimsel ya da sanatsal dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $OZGUN, 'puan' => 30],
    '41-5a' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergisinde derleme, teknik not, editöre mektup, vaka takdimi ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => $KISA, 'puan' => 40],
    '41-5b' => ['baslik' => 'Uluslararası alan indeksli dergide derleme, teknik not, editöre mektup, vaka takdimi ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 30],
    '41-5c' => ['baslik' => 'Hakemli dergide derleme, teknik not, editöre mektup, vaka takdimi ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $KISA, 'puan' => 25],
    '41-5d' => ['baslik' => 'Diğer dergilerde derleme, teknik not, editöre mektup, vaka takdimi ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 15],

    // ══ 4.2 ULUSLARARASI BİLDİRİLER ══
    '42-1' => ['baslik' => 'Uluslararası sempozyum, kongre ya da konferansta tam metin olarak yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 40],
    '42-2' => ['baslik' => 'Uluslararası sempozyum, kongre ya da konferansta özet olarak yayımlanmış bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 10],

    // ══ 4.3 ULUSAL BİLDİRİLER ══
    '43-1' => ['baslik' => 'Ulusal sempozyum, kongre ya da konferansta tam metin olarak yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 20],
    '43-2' => ['baslik' => 'Ulusal sempozyum, kongre ya da konferansta özet olarak yayımlanmış bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 5],

    // ══ 4.4 KİTAPLAR ══
    '44-1' => ['baslik' => 'Yurt dışında yayımlanmış kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 200],
    '44-2' => ['baslik' => 'Yurt dışında yayımlanmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 75],
    '44-3' => ['baslik' => 'Yurt içinde yayımlanmış kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 100],
    '44-4' => ['baslik' => 'Yurt içinde yayımlanmış ders kitabı yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 60],
    '44-5' => ['baslik' => 'Yurt içinde yayımlanmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 50],

    // ══ 4.5 ÇEVİRİLER ══
    '45-1' => ['baslik' => 'Kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 60],
    '45-2' => ['baslik' => 'Makale ya da kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 20],

    // ══ 4.6 SANAT VE SPOR ETKİNLİKLERİ ══
    '46-1' => ['baslik' => 'Eserinizin yurt dışında satın alınması, sergilenmesi ya da yayın organlarında yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatSatinU, 'puan' => 100],
    '46-2' => ['baslik' => 'Eserinizin yurt içinde satın alınması, sergilenmesi ya da yayın organlarında yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatSatinN, 'puan' => 80],
    '46-3' => ['baslik' => 'Uluslararası ortak, grup ya da karma sanat etkinliğine eserinizle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKarmaU, 'puan' => 70],
    '46-4' => ['baslik' => 'Ulusal ortak, grup ya da karma sanat etkinliğine eserinizle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKarmaN, 'puan' => 35],
    '46-6' => ['baslik' => 'Yurt dışında kişisel sanat etkinliğinde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKisiselU, 'puan' => 100],
    '46-7' => ['baslik' => 'Yurt içinde kişisel sanat etkinliğinde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKisiselN, 'puan' => 80],
    '46-9' => ['baslik' => 'Uygulanmış mekân, ürün, grafik ya da endüstriyel tasarım', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatTasarim, 'puan' => 50],
    '46-13' => ['baslik' => 'Sahne ve görsel sanatlarda yönetmen, sanat yönetmeni, küratör, koreograf ya da performans sanatçısı olarak yurt dışında etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatSahneU, 'puan' => 100],
    '46-14' => ['baslik' => 'Sahne ve görsel sanatlarda yönetmen, sanat yönetmeni, küratör, koreograf ya da performans sanatçısı olarak yurt içinde etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatSahneN, 'puan' => 65],
    '46-15' => ['baslik' => 'Bireysel ses ya da görüntü yayımı yapmak, albüm çıkarmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatAlbumU, 'puan' => 80],
    '46-16' => ['baslik' => 'Karma ses ya da görüntü yayımı yapmak, albüm çıkarmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => [...$sanatAlbumN, ...$sanatKalan], 'puan' => 70],

    // ══ 4.7 EDİTÖR VE HAKEMLİKLER ══
    '47-1' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergilerinde editörlük ya da yardımcı editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 75],
    '47-2' => ['baslik' => 'Diğer uluslararası indeksli ya da ULAKBİM taranan dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi', 'TR Dizin Dergi'], 'puan' => 50],
    '47-3' => ['baslik' => 'Bilimsel dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik', 'Yayın Kurulu Üyeliği'], 'puan' => 25],
    '47-5' => ['baslik' => 'Uluslararası kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 75],
    '47-6' => ['baslik' => 'Ulusal kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 50],
    '47-7' => ['baslik' => 'Ulusal hakemli dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 50],
    '47-9' => ['baslik' => 'Sanat ve tasarım etkinliklerinde jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatJuri, 'puan' => 30],

    // ══ 4.8 BASILMIŞ BİLİMSEL/SANATSAL RAPORLAR ══
    '48-1' => ['baslik' => 'Yayımlanmış bilimsel ya da sanatsal rapor', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Bilim İletişimi / Popüler Yayın', 'Kamu/STK Danışmanlığı', 'Topluma Hizmet Projesi'], 'puan' => 30],

    // ══ 4.9 PATENTLER ══
    '49-1' => ['baslik' => 'Alınan patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent', 'Ulusal Patent'], 'puan' => 400],
    '49-3' => ['baslik' => 'Faydalı model, endüstriyel tasarım tescili ya da telif hakkı', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili', 'Ticarileştirme'], 'puan' => 200],

    // ══ 4.10 ÖDÜLLER ══
    '410-1' => ['baslik' => 'Uluslararası bilim, sanat ya da tasarım ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 100],
    '410-2' => ['baslik' => 'Ulusal bilim, sanat ya da tasarım ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü', 'Yarışma Derecesi / Mansiyon'], 'puan' => 50],
    '410-3' => ['baslik' => 'Üç aydan uzun süreli araştırma bursu', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 20],

    // ══ 4.11 ATIFLAR ══
    '411-1' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergilerinde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 20],
    '411-2' => ['baslik' => 'Diğer uluslararası indeksli ya da ULAKBİM taranan dergilerde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 15],
    '411-3' => ['baslik' => 'Diğer hakemli dergilerde ya da uluslararası kitaplarda eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'BKCI Kitap'], 'puan' => 10],
    '411-5' => ['baslik' => 'Ulusal kitaplarda eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Patent'], 'puan' => 5],

    // ══ 4.12 TEZ YÖNETİMİ ══
    '412-1' => ['baslik' => 'Yönetiminizde tamamlanan doktora ya da sanatta yeterlik tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 40],
    '412-1-es' => ['baslik' => 'Tamamlanan doktora ya da sanatta yeterlik tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 20],
    '412-2' => ['baslik' => 'Yönetiminizde tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 20],
    '412-2-es' => ['baslik' => 'Tamamlanan yüksek lisans tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'roller' => ['es_danisman'], 'puan' => 10],

    // ══ 4.13 ÖĞRETİME KATKI ══
    '413-1' => ['baslik' => 'Lisansüstü düzeyde ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 5],
    '413-2' => ['baslik' => 'Lisans ya da ön lisans düzeyinde ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 3],
    '413-5' => ['baslik' => 'Akademik birimlerde oluşturulan akreditasyon kurullarında yer almak', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Akreditasyon Faaliyeti'], 'puan' => 10],

    // ══ 4.15 DİĞER BİLİMSEL/SANATSAL ETKİNLİKLER ══
    '415-9' => ['baslik' => 'Bilimsel toplantıda davetli konuşmacı olmak ya da çağrılı bildiri sunmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 20],
    '415-13' => ['baslik' => 'Bilimsel ya da sanatsal toplantı düzenleme kurulunda başkanlık, üyelik veya oturum başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 15],
    '415-idari' => ['baslik' => 'Üniversitenin akademik ve idari birimlerinde görev yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü', 'Dekan Yrd. / Müdür Yrd.', 'Uygulama ve Araştırma Merkezi Müdürü', 'Bölüm Başkanı', 'Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük', 'Kurul / Komisyon Üyeliği'], 'puan' => 15],
],
    $proje('414-1', 'AB Çerçeve Programı gibi uluslararası kuruluşlarca desteklenen Ar-Ge projesi', ['AB Çerçeve / Ufuk'], 100),
    $proje('414-2', 'Erasmus gibi uluslararası eğitim ve sosyal içerikli proje', ['Diğer Uluslararası Fon'], 80),
    $proje('414-3', 'Ulusal kuruluşlarca desteklenen proje', ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 70),
    $proje('414-5', 'Şirketler, kamu yararına çalışan STK\'lar ya da yerel yönetimlerle ortak proje', ['Özel Sektör / STK'], 40),
    $proje('414-6', 'Üniversite Bilimsel Araştırma Projeleri Birimince desteklenen proje', ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 25),
);

$bolum = fn (string $p): array => array_values(array_filter(
    array_keys($maddeler), fn (string $k) => str_starts_with($k, $p),
));

$b41 = $bolum('41-');
$b42 = $bolum('42-');
$b43 = $bolum('43-');
$b44 = $bolum('44-');
$b45 = $bolum('45-');
$b46 = $bolum('46-');
$b414 = $bolum('414-');

return [
    'kapsam_notu' => 'Puanlar Kırıkkale Üniversitesi Öğretim Üyeliğine Yükseltilme ve Atanma '
        .'Kriterlerinin Bölüm 4 puanlama listesinden. Yazar çarpanı Tablo 1\'e göre işliyor (tek '
        .'yazar %100; iki yazarlıda %90/%80; üç yazarlıda %80/%70/%60; on ve daha fazla yazarlıda '
        .'ilk isim %50, beşinciden sonrası %10). Sorumlu yazar birinci isim yazar kadar puan '
        .'alıyor. Yazar listesini boş bırakırsanız çarpan hiç uygulanmaz ve puanınız olduğundan '
        .'YÜKSEK görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: 4.14 proje puanları iki kez indiriliyor '
        .'— rol yüzdesi (yürütücü %100, araştırmacı %75, danışman ve bursiyer %25) ve projenin '
        .'durumuna bağlı çarpan. Kayıt projenin tamamlanıp tamamlanmadığını taşımadığı için DEVAM '
        .'EDEN varsayımı (%50) alındı; sonuç raporu kabul edilmiş projeniz varsa puanı iki katı '
        .'olmalıydı. Ayrıca özet bildiri ile yayımlanmamış poster, dergi editörlüğü ile yardımcı '
        .'editörlük ve hakemlik, yurt dışı ile yurt içi burs, davetli konuşmacılıkta uluslararası '
        .'ile ulusal ayrımı kayıttan okunamadığı için hepsi en düşük değerden sayılıyor. Basılmış '
        .'ders notu, katalog yazarlığı, Bologna etkinlikleri, laboratuvar kurma, teknopark '
        .'ortaklığı ve spor hakemliği kalemleri sözlükte karşılıksız olduğu için girilemedi. '
        .'Patent BAŞVURUNUZU kaydetmeyin: yönerge ona ayrı ve düşük puan veriyor ama kayıt türü '
        .'alınmış patentten ayrılamadığı için o satır girilmedi. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünebilir: "aynı kitaptan en fazla iki '
        .'bölüm", "bir yayın için en fazla beş atıf", "her yıl en fazla beş ders" ve "son üç '
        .'yılda" gibi eser, yıl ve pencere sınırları uygulanmıyor.',

    // Tablo 1: Yazar Sayısına Göre Uygulanacak Değerlendirme Tablosu.
    // "Sorumlu yazar birinci isim yazar kadar puan alır."
    'yazar_katsayisi' => [
        'haric' => ['atif', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev',
            'odul', 'editorluk', 'toplumsal_katki', 'proje', 'diger'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.80, 4 => 0.70, 5 => 0.60], 'sonrasi' => 0.50],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.80, 4 => 0.70, 5 => 0.60], 'sonrasi' => 0.50],
            'yazar_2' => ['kademeler' => [2 => 0.80, 3 => 0.70, 4 => 0.60, 5 => 0.50], 'sonrasi' => 0.40],
            'yazar_3' => ['kademeler' => [3 => 0.60, 4 => 0.50, 5 => 0.40], 'sonrasi' => 0.30],
            'yazar_4' => ['kademeler' => [4 => 0.40, 5 => 0.30], 'sonrasi' => 0.20],
            'yazar_5' => ['kademeler' => [5 => 0.20], 'sonrasi' => 0.10],
            'yazar_6' => ['sonrasi' => 0.10],
            'ortak' => ['kademeler' => [1 => 1.00, 2 => 0.80, 3 => 0.60, 4 => 0.40, 5 => 0.20], 'sonrasi' => 0.10],
        ],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        'B41' => $b41,
        'B42' => $b42,
        'B43' => $b43,
        'B44' => $b44,
        'B45' => $b45,
        'B46' => $b46,
        'B414' => $b414,
        'B41-46' => array_merge($b41, $b42, $b43, $b44, $b45, $b46),

        // Koşulların satır bazlı atıfları: 4.1.1, 4.1.2, 4.1.3, 4.1.4.
        'M411' => ['41-1-Q1', '41-1-Q2', '41-1-Q3', '41-1-Q4'],
        'M412' => ['41-2'],
        'M411-412' => ['41-1-Q1', '41-1-Q2', '41-1-Q3', '41-1-Q4', '41-2'],
        'M411-414' => ['41-1-Q1', '41-1-Q2', '41-1-Q3', '41-1-Q4', '41-2', '41-3', '41-4'],

        // 2.1.f / 2.2.f / 2.3'ün "4.14'ten (BAP hariç) proje" koşulu.
        'PROJE-BAP-HARIC' => ['414-1-y', '414-1-a', '414-1-d', '414-2-y', '414-2-a', '414-2-d',
            '414-3-y', '414-3-a', '414-3-d', '414-5-y', '414-5-a', '414-5-d'],
        'PROJE-BAP-HARIC-Y' => ['414-1-y', '414-2-y', '414-3-y', '414-5-y'],

        // Özgün kitap ve tez yönetimi koşulları.
        'OZGUN-KITAP' => ['44-1', '44-3'],
        'TEZ' => ['412-1', '412-1-es', '412-2', '412-2-es'],
        'BAP' => ['414-6-y', '414-6-a', '414-6-d'],
    ],

    // 4.14.6 dipnotu: "Bu kapsamda en fazla 25 puan alınabilir."
    'grup_tavanlari' => ['BAP' => 25],
];
