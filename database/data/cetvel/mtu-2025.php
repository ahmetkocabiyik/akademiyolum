<?php

use App\Enums\Kategori;

/**
 * MALATYA TURGUT ÖZAL ÜNİVERSİTESİ — EK-1 Puan Tablosu
 * Kaynak: pdf/17537003072.malatyaturgutozaluniverstesi.pdf
 * (15 sayfa; Senato 30.05.2025-2025/14-01, YÖK onay 30.04.2025)
 *
 * Tek puan tablosu; koşullar bilim alanı grubuna göre değişiyor ama
 * puanlar değişmiyor. Madde kodları tablonun kendi düzeni (A1.1, B1.2,
 * N1.1.1 …); koşullar bu kodlara ve harf bloklarına ("A-C kapsamındaki
 * faaliyetler", "N1-N25 kapsamındaki faaliyetler") atıf yapıyor.
 *
 * ── ESCI İKİ SATIRA BÖLÜNMÜŞ, EN DÜŞÜĞÜ ALINDI ──
 * A1.4 satırı "Q4/E-SCI" diyerek ESCI dergilerine 80 puan veriyor; A3
 * ise Scopus ve TR Dizin dergilerine 60. Sözlükte ESCI ile Scopus tek
 * etiket ('ESCI / Scopus') olduğu için §0 uyarınca düşük olan (60)
 * alındı. ESCI makaleniz varsa puanınız OLDUĞUNDAN DÜŞÜK.
 *
 * ── AHCI DERGİLERİ Q4'TEN ──
 * Madde 6(10) AHCI dergilerinin Q değerini Scimago'dan alıyor ve "Q
 * değeri beyan edilmeyen ve kanıtlanamayan durumlarda Q4 olarak
 * değerlendirilir" diyor. Kayıt AHCI için çeyrek taşımadığından bu kural
 * uygulandı: AHCI → Q4 satırı.
 *
 * ── AYNI ETİKETE DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   B1.1 uluslararası çağrılı bildiri (80) ile B2.1 ulusal (40) → 40.
 *   B1.4 uluslararası düzenleme kurulu üyeliği (10) ile B2.4 ulusal (5)
 *       → 5; bu satır zaten baraj gruplarının dışında.
 *   C1.4 uluslararası ansiklopedi maddesi (50) ile C2.4 ulusal (20) →
 *       20.
 *   E bölümünde yayın kurulu üyeliği (100/50/40/20) → 20; hakemlik
 *       (30/15/10/5) ve proje panelistliği (30) → 5.
 *   I bölümünde uluslararası (300) ile ulusal (150) belgeler → 150;
 *       lisanslanan/ticarileşen patent (400/200) ile teknokent şirket
 *       ortaklığı (75) tek 'Ticarileştirme' etiketine düşüyor → 75.
 *   J1.2 yurt dışı doktora sonrası burs (80) ile J2.3 yurt içi (50) →
 *       50; J2.2 teşvik ödülü (50) ile ulusal bilim ödülü (100) → 50.
 *   L3 TÜBA/TÜBİTAK kurul üyeliği (80) ile L2 senato-kurul üyeliği (10)
 *       → 10.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   D1 ve D2 (adayın adıyla anılan formül, şema, şekil, grafik, tablo,
 *       buluş; 250 ve 120 puan) — sözlükte karşılık yok.
 *   I1.1 / I2.1 patent BAŞVURUSU (200/100) — kayıt belgeden ayıramıyor.
 *   M bölümü (sertifikalar, 5-30 puan) — karşılık yok.
 *   O bölümü (sportif etkinlikler: antrenörlük, hakemlik, millî takım;
 *       10-40 puan) — karşılık yok.
 *   N2 küratörlük, N4 müzik teknolojisi, N12 belge çözümleme, N14
 *       arkeolojik kazı, N19 oyun yazarlığı — karşılık yok.
 *   Rektör ve rektör yardımcılığı: L bölümü bu görevleri saymıyor.
 *
 * ── UYGULANMAYAN ARTIRIM: YABANCI ÜLKE ORTAKLIĞI ──
 * Madde 7(3): A1 ve A2 yayınlarında en az bir farklı yabancı ülke kurumu
 * adresli yazar varsa ya da G1.1, G1.2, G2.1 projelerinde farklı ülkeden
 * araştırmacı/danışman varsa puan %50 ARTIRIMLI hesaplanıyor. Kayıt
 * yazar ve ortak adreslerini taşımadığı için artırım uygulanmadı;
 * uluslararası ortaklı yayın ve projeleriniz varsa puanınız
 * OLDUĞUNDAN DÜŞÜK görünür.
 *
 * Yönerge: yonerge/mtu.php
 */
$SCI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];
$Q4 = ['SCIE/SSCI (Q4)', 'AHCI'];
$MAKALE = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];

$sanatKisiselU = ['Kişisel Etkinlik (Uluslararası)', 'Elektronik Kişisel Sergi (Uluslararası)',
    'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)'];
$sanatKisiselN = ['Kişisel Etkinlik (Ulusal)', 'Elektronik Kişisel Sergi (Ulusal)',
    'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)'];
$sanatGrupU = ['Karma/Jürili Etkinlik (Uluslararası)', 'Elektronik Karma Sergi (Uluslararası)',
    'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)'];
$sanatGrupN = ['Karma/Jürili Etkinlik (Ulusal)', 'Elektronik Karma Sergi (Ulusal)',
    'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)'];
$sanatKarma = ['Karma Etkinlik (Jürisiz, Ulusal)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)'];
$sanatKoleksiyon = ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt İçi)',
    'Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)',
    'Eserin Haber Olması (Uluslararası)', 'Eserin Haber Olması (Ulusal)'];
$besteBuyuk = ['Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Opera/Bale Kompozisyonu',
    'Orkestralı Sahne Eseri'];
$besteKucuk = ['Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)',
    'Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Sahne/Ekran Müziği',
    'Küçük Ölçekli Orkestra Eseri'];
$besteDuzenleme = ['Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi',
    'Özgün Eser / Beste / Tasarım', 'Eğitim Müziği Albümü'];
$filmU = ['Yönetmenlik (Sahne/Ekran)'];
$filmN = ['Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)',
    'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)',
    'Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)', 'Karma Albüm / CD-DVD Katkısı'];
$restorasyonU = ['Koruma-Onarım Uygulaması (Uluslararası)'];
$restorasyonN = ['Koruma-Onarım Uygulaması (Ulusal)'];
$juri = ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)',
    'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'];
$tiyatro = ['Rejisörlük (Uluslararası)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)',
    'Opera Birinci Rol (Uluslararası)', 'Opera Birinci Rol (Ulusal)',
    'Opera İkinci Rol (Uluslararası)', 'Opera İkinci Rol (Ulusal)',
    'Rejisör Yardımcılığı (Uluslararası)', 'Rejisör Yardımcılığı (Ulusal)',
    'Rejisör Yardımcılığı (Konservatuvar)'];
$dinletiU = ['Resital (Uluslararası)', 'Solistlik (Uluslararası)', 'Şan Resitali (Uluslararası)',
    'Orkestra Şefliği (Uluslararası)', 'Koro Şefliği (Uluslararası)', 'Grup Şefliği (Uluslararası)',
    'Opera Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Uluslararası)'];
$dinletiN = ['Resital (Ulusal)', 'Solistlik (Ulusal)', 'Şan Resitali (Ulusal)',
    'Orkestra Şefliği (Ulusal)', 'Koro Şefliği (Ulusal)', 'Grup Şefliği (Ulusal)',
    'Opera Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Ulusal)'];
$esliktU = ['Oda Müziği Grup Üyeliği (Uluslararası)', 'Başkemancılık (Uluslararası)',
    'Oratoryo/Kantat Solistliği (Uluslararası)'];
$esliktN = ['Oda Müziği Grup Üyeliği (Ulusal)', 'Başkemancılık (Ulusal)', 'Orkestra / Koro Üyeliği',
    'Oratoryo/Kantat Solistliği (Ulusal)'];
$mimarlikY = ['Uygulama Projesi — Müellif'];
$mimarlikE = ['Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı',
    'Uygulama Projesi — Danışman', 'Sahne Tasarımı (Dekor, Kostüm, Işık)'];

$sanatKullanilan = array_merge($sanatKisiselU, $sanatKisiselN, $sanatGrupU, $sanatGrupN,
    $sanatKarma, $sanatKoleksiyon, $besteBuyuk, $besteKucuk, $besteDuzenleme, $filmU, $filmN,
    $restorasyonU, $restorasyonN, $juri, $tiyatro, $dinletiU, $dinletiN, $esliktU, $esliktN,
    $mimarlikY, $mimarlikE);
$sanatKalan = array_values(array_diff(Kategori::SanatselEtkinlik->kaynaklar(), $sanatKullanilan));

/** Tablo 2 katsayıları: yürütücü 1, araştırmacı ve danışman 0,5; bursiyer 0,1. */
$proje = fn (string $kod, string $ad, array $kaynaklar, int $p): array => [
    "{$kod}-y" => ['baslik' => "{$ad} — yürütücü, yönetici ya da koordinatör", 'kategori' => 'proje', 'kaynaklar' => $kaynaklar, 'roller' => ['yurutucu'], 'puan' => $p],
    "{$kod}-a" => ['baslik' => "{$ad} — araştırmacı ya da danışman", 'kategori' => 'proje', 'kaynaklar' => $kaynaklar, 'roller' => ['arastirmaci', 'danisman'], 'puan' => (int) ($p * 0.5)],
    "{$kod}-b" => ['baslik' => "{$ad} — bursiyer", 'kategori' => 'proje', 'kaynaklar' => $kaynaklar, 'roller' => ['bursiyer'], 'puan' => (int) ($p * 0.1)],
];

$maddeler = array_merge([
    // ══ A. MAKALELER ══
    'A1.1' => ['baslik' => 'SCI, SCI-Exp, SSCI ya da AHCI kapsamındaki Q1 dergide yayımlanmış makale (derleme dâhil)', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $MAKALE, 'puan' => 200],
    'A1.2' => ['baslik' => 'SCI, SCI-Exp, SSCI ya da AHCI kapsamındaki Q2 dergide yayımlanmış makale (derleme dâhil)', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $MAKALE, 'puan' => 160],
    'A1.3' => ['baslik' => 'SCI, SCI-Exp, SSCI ya da AHCI kapsamındaki Q3 dergide yayımlanmış makale (derleme dâhil)', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $MAKALE, 'puan' => 120],
    'A1.4' => ['baslik' => 'SCI, SCI-Exp, SSCI ya da AHCI kapsamındaki Q4 dergide yayımlanmış makale (derleme dâhil)', 'kategori' => 'makale', 'kaynaklar' => $Q4, 'turler' => $MAKALE, 'puan' => 80],
    'A2.1' => ['baslik' => 'Q1 dergide yayımlanmış editöre mektup, teknik not ya da vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $KISA, 'puan' => 100],
    'A2.2' => ['baslik' => 'Q2 dergide yayımlanmış editöre mektup, teknik not ya da vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $KISA, 'puan' => 80],
    'A2.3' => ['baslik' => 'Q3 dergide yayımlanmış editöre mektup, teknik not ya da vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $KISA, 'puan' => 60],
    'A2.4' => ['baslik' => 'Q4 dergide yayımlanmış editöre mektup, teknik not ya da vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => $Q4, 'turler' => $KISA, 'puan' => 40],
    'A3' => ['baslik' => 'Uluslararası alan indeksleri (Scopus) ile TR Dizinde taranan dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'TR Dizin'], 'turler' => $MAKALE, 'puan' => 60],
    'A4' => ['baslik' => 'Diğer uluslararası dergilerde yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $MAKALE, 'puan' => 40],
    'A5' => ['baslik' => 'Ulusal dergilerde yayımlanmış makale ile alan indeksli dergilerde yayımlanmış editöre mektup, özet ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli', 'ESCI / Scopus', 'TR Dizin', 'Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 25],
    'A5.1' => ['baslik' => 'Ulusal hakemli dergilerde yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $MAKALE, 'puan' => 25],

    // ══ B. BİLİMSEL ETKİNLİKLER ══
    'B2.1' => ['baslik' => 'Bilimsel toplantıda çağrılı bildiri sunumu', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 40],
    'B1.2' => ['baslik' => 'Uluslararası toplantıda sözlü sunum yapılan, özeti ya da tam metni yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 40],
    'B1.3' => ['baslik' => 'Uluslararası toplantıda poster sunum yapılan, özeti ya da tam metni yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 20],
    'B2.2' => ['baslik' => 'Ulusal toplantıda sözlü sunum yapılan, özeti ya da tam metni yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 20],
    'B2.3' => ['baslik' => 'Ulusal toplantıda poster sunum yapılan, özeti ya da tam metni yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 10],
    'B2.4' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 5],

    // ══ C. KİTAPLAR ══
    'C1.1' => ['baslik' => 'Uluslararası, yabancı dilde basılmış bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 250],
    'C1.2' => ['baslik' => 'Uluslararası bilimsel kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 150],
    'C1.3' => ['baslik' => 'Uluslararası bilimsel kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 100],
    'C2.1' => ['baslik' => 'Ulusal bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 80],
    'C2.2' => ['baslik' => 'Ulusal bilimsel kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 50],
    'C2.3' => ['baslik' => 'Ulusal bilimsel kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 30],
    'C2.4' => ['baslik' => 'Ansiklopedide madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 20],
    'C2.5' => ['baslik' => 'Ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 30],
    'C2.6' => ['baslik' => 'Bilimsel kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 80],
    'C2.7' => ['baslik' => 'Bilimsel kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 40],

    // ══ D. ATIFLAR ══
    'D3' => ['baslik' => 'Yabancı dilde basılmış kitaplarda ya da SCI, SCI-Exp, SSCI, AHCI dergilerinde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 5],
    'D4' => ['baslik' => 'Türkçe basılmış kitaplarda, TR Dizin ya da uluslararası indeksli dergilerde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 3],
    'D5' => ['baslik' => 'Diğer yayınlarda eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 2],

    // ══ E. EDİTÖRLÜK VE HAKEMLİKLER ══
    'E1.1.1' => ['baslik' => 'SCI, SCI-Exp, SSCI ya da AHCI kapsamındaki dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 150],
    'E1.2.1' => ['baslik' => 'Diğer indekslerde yer alan yabancı dilde yayımlanan dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 80],
    'E1.3.1' => ['baslik' => 'Diğer indekslerde yer alan Türkçe yayımlanan dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 60],
    'E2.1.1' => ['baslik' => 'Yurt içi dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 40],
    'E2.1.2' => ['baslik' => 'Dergilerde yayın kurulunda ya da editörler listesinde yer almak', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 20],
    'E2.1.3' => ['baslik' => 'Dergilerde hakemlik, proje ve araştırmalarda hakemlik ya da panelistlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 5],

    // ══ F. LİSANSÜSTÜ TEZLER ══
    'F1' => ['baslik' => 'Danışmanlığınızda tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 50],
    'F2' => ['baslik' => 'Danışmanlığınızda tamamlanan doktora, sanatta yeterlik ya da tıpta uzmanlık tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 100],
    'F3' => ['baslik' => 'Tamamlanan yüksek lisans tezi ikinci danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'roller' => ['es_danisman'], 'puan' => 25],
    'F4' => ['baslik' => 'Tamamlanan doktora, sanatta yeterlik ya da tıpta uzmanlık tezi ikinci danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 50],

    // ══ I. FİKRİ VE SINAİ MÜLKİYET HAKLARI ══
    'I2.2' => ['baslik' => 'Patent belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent', 'Ulusal Patent'], 'puan' => 150],
    'I2.4' => ['baslik' => 'Faydalı model belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 150],
    'I2.6' => ['baslik' => 'Marka ya da tasarım tescil belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 150],
    'H1.2' => ['baslik' => 'Teknokent ya da TGB\'de faaliyet yürüten şirkette kurucu veya ortak olmak', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 75],

    // ══ J. ÖDÜLLER ══
    'J1.1' => ['baslik' => 'Uluslararası bilimsel kuruluşlarca verilen jürili bilim, sanat ya da hizmet ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 100],
    'J2.1' => ['baslik' => 'YÖK, TÜBİTAK ya da TÜBA bilim, sanat ve hizmet ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü', 'TÜBİTAK / TÜBA Ödülü'], 'puan' => 100],
    'J2.2' => ['baslik' => 'TÜBİTAK ya da TÜBA teşvik ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü', 'Ulusal Bilim/Sanat Ödülü'], 'puan' => 50],
    'J2.3' => ['baslik' => 'En az altı aylık doktora sonrası araştırma bursu', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 50],

    // ══ K. EĞİTİM-ÖĞRETİM FAALİYETİ ══
    'K1' => ['baslik' => 'Ön lisans, lisans ya da lisansüstü ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 5],

    // ══ L. İDARİ GÖREVLER VE KURULLAR ══
    'L1.1' => ['baslik' => 'Dekan ya da müdür olarak görev yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 50],
    'L1.2' => ['baslik' => 'Bölüm, anabilim dalı ya da ana sanat dalı başkanlığı, dekan veya müdür yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı', 'Anabilim Dalı Başkanı / Koordinatörlük', 'Dekan Yrd. / Müdür Yrd.'], 'puan' => 40],
    'L1.5' => ['baslik' => 'Bölüm başkan yardımcılığı ya da koordinatör yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı'], 'puan' => 15],
    'L2' => ['baslik' => 'Senato, kurul ya da komisyon üyeliği (doğal üyelikler puanlanmaz)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Senato / Üniversite Yönetim Kurulu Üyesi', 'Kurul / Komisyon Üyeliği'], 'puan' => 10],
    'L4.2' => ['baslik' => 'Bilirkişilik, kayyımlık, eğiticilik ve öğrenci topluluğu danışmanlığı', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı', 'Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 5],
],
    $proje('G1.1', 'Avrupa Birliği destekli proje (HORIZON, COST ve benzeri)', ['AB Çerçeve / Ufuk'], 250),
    $proje('G1.2', 'Avrupa Birliği dışındaki uluslararası proje (FAO, NATO, NSF ve benzeri)', ['Diğer Uluslararası Fon'], 200),
    $proje('G2.1', 'TÜBİTAK ARDEB, TEYDEB, TAGEM, TÜSEB, TÜBA, KOSGEB ya da üniversite-sanayi iş birliği projesi', ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 200),
    $proje('G2.2', 'TÜBİTAK hızlı destek, BİDEB, BİTO ya da BAP projesi', ['BAP (Üniversite)'], 80),
    [
        'G2.3' => ['baslik' => 'TÜBİTAK 2209 üniversite öğrencileri proje başvurularında danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'puan' => 40],

        // ══ N. SANAT VE TASARIM ETKİNLİKLERİ ══
        'N1.2.1' => ['baslik' => 'Yurt dışında kişisel sergi açmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKisiselU, 'puan' => 60],
        'N1.1.1' => ['baslik' => 'Yurt içinde kişisel sergi açmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKisiselN, 'puan' => 25],
        'N1.3.1' => ['baslik' => 'Uluslararası bienal, trienal ya da grup sergisine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatGrupU, 'puan' => 20],
        'N1.1.2' => ['baslik' => 'Ulusal bienal, trienal, grup ya da üniversite sergisine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatGrupN, 'puan' => 15],
        'N1.1.4' => ['baslik' => 'Karma sergiye katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => [...$sanatKarma, ...$sanatKalan], 'puan' => 5],
        'N3.2' => ['baslik' => 'Eserinizin koleksiyona girmesi ya da satın alınması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKoleksiyon, 'puan' => 5],
        'N5.1' => ['baslik' => 'Sahne yapıtı ya da senfonik yapıt bestelemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $besteBuyuk, 'puan' => 20],
        'N5.2' => ['baslik' => 'Oda müziği, koro, solo, elektronik müzik ya da oyun için özgün müzik yapıtı bestelemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $besteKucuk, 'puan' => 15],
        'N5.3' => ['baslik' => 'Düzenleme yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $besteDuzenleme, 'puan' => 10],
        'N8.1' => ['baslik' => 'Televizyon filmi ya da dizisinde yönetmenlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $filmU, 'puan' => 15],
        'N7.1' => ['baslik' => 'Film, belgesel, televizyon programı ya da reklam filminde yönetmenlik, görüntü yönetmenliği veya senaryo yazarlığı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $filmN, 'puan' => 10],
        'N13.1' => ['baslik' => 'Uluslararası eski eser restorasyonu', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $restorasyonU, 'puan' => 15],
        'N13.2' => ['baslik' => 'Ulusal eski eser restorasyonu', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $restorasyonN, 'puan' => 10],
        'N17.2' => ['baslik' => 'Sanatsal yarışmalarda ve koruma kurullarında jüri ya da kurul üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $juri, 'puan' => 10],
        'N18.2' => ['baslik' => 'Tiyatro, opera ya da bale yapıtında rejisörlük, yönetmenlik veya oyunculuk', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $tiyatro, 'puan' => 10],
        'N20.1.2' => ['baslik' => 'Oyun, film ya da televizyon prodüksiyonunda dekor veya kostüm tasarımı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $mimarlikE, 'puan' => 10],
        'N22.1' => ['baslik' => 'Yurt dışında bireysel dinleti ya da müzik topluluğunda şeflik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $dinletiU, 'puan' => 40],
        'N21.1' => ['baslik' => 'Yurt içinde bireysel dinleti ya da müzik topluluğunda şeflik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $dinletiN, 'puan' => 20],
        'N22.3' => ['baslik' => 'Yurt dışında solist, çalgı performansı ya da eşlikçi olarak katılım', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $esliktU, 'puan' => 20],
        'N21.3' => ['baslik' => 'Yurt içinde solist, çalgı performansı ya da eşlikçi olarak katılım', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $esliktN, 'puan' => 10],
        'N23.1' => ['baslik' => 'Mimarlık alanında resmî kanallardan alınmış projede yürütücülük', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $mimarlikY, 'puan' => 50],
        'N16.4' => ['baslik' => 'Sanatsal ya da mimarlık yarışmalarında ödül almak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 5],
    ]);

/** @param list<string> $onekler */
$onek = fn (array $onekler): array => array_values(array_filter(
    array_keys($maddeler),
    function (string $kod) use ($onekler) {
        foreach ($onekler as $o) {
            if (str_starts_with($kod, $o)) {
                return true;
            }
        }

        return false;
    },
));

$a = $onek(['A']);
$b = $onek(['B']);
$c = $onek(['C']);
$g = $onek(['G']);
$i = $onek(['I', 'H']);
$n = $onek(['N']);

return [
    'kapsam_notu' => 'Puanlar Malatya Turgut Özal Üniversitesi Öğretim Üyeliğine Yükseltilme ve '
        .'Atanma Ölçütleri Yönergesinin EK-1 puan tablosundan. Yazar çarpanı Tablo 1\'e göre hem '
        .'yazar sayısına hem sıraya bakıyor: üç yazarlıda 0,9/0,8/0,7; beş ve üzerinde '
        .'0,7/0,6/0,5/0,4/0,3. Sorumlu yazar birinci isim gibi puan alıyor. Proje puanları Tablo '
        .'2 katsayılarıyla: yürütücü tam, araştırmacı ve danışman yarım, bursiyer onda bir. '
        .'Yazar listesini boş bırakırsanız çarpan hiç uygulanmaz ve puanınız olduğundan YÜKSEK '
        .'görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: madde 7(3) A1 ve A2 yayınlarında '
        .'yabancı ülke kurumu adresli ortak yazar ya da G1.1, G1.2, G2.1 projelerinde farklı '
        .'ülkeden araştırmacı varsa puanı %50 ARTIRIYOR; kayıt ortak adreslerini taşımadığı için '
        .'artırım uygulanmıyor. A1.4 satırı ESCI dergilerine 80 puan veriyor ama sözlükte ESCI '
        .'ile Scopus tek etiket olduğu için ikisi de A3\'ten (60) sayılıyor. Çağrılı bildiriler '
        .'40, yayın kurulu üyelikleri 20, hakemlikler 5, ansiklopedi maddeleri 20, patent ve '
        .'faydalı model belgeleri 150 puandan sayılıyor (uluslararası olanların ayrı ve yüksek '
        .'satırları kayıttan okunamıyor). D1 ve D2 (adayınızın adıyla anılan formül, şema, '
        .'grafik, tablo ve buluşlar; 250 ve 120 puan), M bölümü (sertifikalar) ve O bölümü '
        .'(sportif etkinlikler) sözlükte karşılıksız olduğu için girilemedi. Patent BAŞVURUNUZU '
        .'kaydetmeyin: yönerge ona ayrı ve düşük puan veriyor ama kayıt türü belgeden '
        .'ayrılamadığı için o satırlar girilmedi. Rektörlük ve rektör yardımcılığı EK-1\'in idari '
        .'görevler listesinde yok; bu kayıtlarınız 0 puandır.',

    // Madde 7(1) ve Tablo 1: yazar sayısı ve sırasına göre katsayılar.
    // "Makalede sorumlu yazar olarak ismi geçen araştırmacılar için
    // 1. isim gibi puan hesaplanır."
    'yazar_katsayisi' => [
        'haric' => ['atif', 'proje', 'patent', 'editorluk', 'tez_danismanligi', 'egitim_ogretim',
            'odul', 'idari_gorev', 'toplumsal_katki', 'diger', 'sanatsal_etkinlik'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 1.00, 3 => 0.90, 4 => 0.80], 'sonrasi' => 0.70],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 1.00, 3 => 0.90, 4 => 0.80], 'sonrasi' => 0.70],
            'yazar_2' => ['kademeler' => [2 => 0.90, 3 => 0.80, 4 => 0.70], 'sonrasi' => 0.60],
            'yazar_3' => ['kademeler' => [3 => 0.70, 4 => 0.60], 'sonrasi' => 0.50],
            'yazar_4' => ['kademeler' => [4 => 0.50], 'sonrasi' => 0.40],
            'yazar_5' => ['sonrasi' => 0.30],
            'yazar_6' => ['sonrasi' => 0.30],
            'ortak' => ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.70, 4 => 0.50], 'sonrasi' => 0.30],
        ],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        'A' => $a,
        'B' => $b,
        'C' => $c,
        'G' => $g,
        'I' => $i,
        'N' => $n,
        'A-C' => array_merge($a, $b, $c),
        'G-I' => array_merge($g, $i),
        // Madde 8(2): B kapsamındaki barajlarda B1.4 ve B2.4 (düzenleme
        // kurulu üyeliği) sayılmıyor.
        'B-HARIC' => array_values(array_filter($b, fn (string $k) => $k !== 'B2.4')),
        // "A1 ve/veya A2 kapsamındaki yayınlar".
        'A1-A2' => $onek(['A1', 'A2']),
    ],

    'grup_tavanlari' => [],
];
