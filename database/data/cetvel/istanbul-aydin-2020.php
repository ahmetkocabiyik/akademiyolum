<?php

/**
 * İSTANBUL AYDIN ÜNİVERSİTESİ — Ek-1, Ek-2 ve Ek-3 puan listeleri
 * Kaynak: pdf/17537099242.istanbulaydinuniversitesi.pdf
 *
 * Madde kodları eklerin kendi harf ve numaralarını izliyor (A01 = Ek-1'in
 * A bölümünün 1. satırı, E2-03 = Ek-2'nin 3. satırı, E3-05 = Ek-3'ün 5.
 * satırı); iki haneli yazım A1 ile A10'un karışmaması için bize ait.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   A.7 (uluslararası dergilerde editörlük ve hakemlik, 20) ile B.8 (ulusal
 *       hakemli dergilerde hakemlik ve editörlük, 15) hakemlik etiketinde
 *       birleşiyor → 15.
 *   Projelerde yürütücü yardımcılığı (20 ve 10) ile projede görev alma
 *       (10 ve 5) ayrışmıyor → uluslararası projede 10, ulusal projede 5.
 *   Uzmanlık raporu (uluslararası 6, ulusal 3) ile kamu danışmanlığı (2)
 *       tek 'Kamu/STK Danışmanlığı' etiketine düşüyor → 2.
 *   Burslarda uluslararası (20) ile ulusal (10) → 10.
 *   Ek-3'te sahne tasarımı satırları (30 ve 20) → 20; jürili yarışma
 *       ödülleri (40 ve 20) → 20.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   A.3 (önde gelen ülkelerin hakemli bilimsel dergilerinde makale, 20) ve
 *       B.6 (hakemli olmayan ulusal dergide makale, 5) — sözlükte karşılığı
 *       yok; 'Diğer Ulusal Hakemli' etiketi B.1'e bağlı.
 *   B.5 (ders notu, 10) ve B.11 (hakemsiz dergide makale tercümesi, 3).
 *   EK-2'nin 6. satırı (son dört yarıyılda verilen derslerden KREDİ SAAT
 *       başına 1 puan) — kayıt dersin kredi saatini taşımıyor; ders
 *       kayıtlarınız toplam puana katkı vermiyor.
 *   BAP ve özel sektör projeleri — Ek-1'in C bölümü yalnız yurt dışı
 *       kaynaklı projeler ile TÜBİTAK, TÜBA ve DPT destekli yurt içi
 *       projeleri sayıyor.
 *   Ek-3'ün 15-16 (sergi organizasyonu ve küratörlük) ile 19-20 (arşiv
 *       belgelerinin tasnifi ve yayını) satırları.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   EK-2'nin 3-5. satırlarındaki "her dönem için" çarpanı ile G bölümünün
 *       "her yıl için" çarpanı: kayıt görev süresini taşımadığı için her
 *       görev bir kez sayılıyor, çok dönemli idari görevlerde puanınız
 *       DÜŞÜK görünür.
 *   "Güzel Sanatlar Fakültesi Özel Puanlama Tablosu"nun ek bazlı yüzde
 *       dağılımı (EK1 %30, EK2 %10-20, EK3 %50-60): motor toplam puanın
 *       hangi ekten geldiğini oransal olarak sınırlayamıyor.
 *
 * Yönerge: yonerge/istanbul-aydin.php
 *
 * "ÖNDE GELEN ULUSLARARASI" ↔ "TANINMIŞ ULUSAL" AYRIMI KAPSAM ETİKETİNE BAĞLANDI (19.09.2026): sıfat iki
 * kademede de aynı, ayrımı yapan tek şey yayınevinin kapsamı. Kapsamlı
 * etiketler üst satırlara bağlandı, ulusal satırlar daraltıldı.
 */
$TAM = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];
$WOS = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];
$ENDEKS = ['ESCI / Scopus', 'Diğer Uluslararası İndeks'];
$ULUSL_PROJE = ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'];
$ULUSAL_PROJE = ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'];

$maddeler = [
    // ══ EK-1/A. ULUSLARARASI YAYIN VE ETKİNLİKLER ══
    'A01' => ['baslik' => 'SSCI, SCI-Expanded veya AHCI kapsamındaki dergide yayımlanmış tam makale', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $TAM, 'puan' => 40],
    'A02' => ['baslik' => 'Alan endeksleri kapsamındaki dergide yayımlanmış tam makale', 'kategori' => 'makale', 'kaynaklar' => $ENDEKS, 'turler' => $TAM, 'puan' => 30],
    'A04' => ['baslik' => 'Önde gelen uluslararası yayınevi tarafından yayımlanan kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası Kitap'], 'puan' => 50],
    'A05' => ['baslik' => 'Önde gelen uluslararası yayınevi tarafından yayımlanan kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Uluslararası Kitap Bölümü'], 'puan' => 30],
    'A06' => ['baslik' => 'Önde gelen uluslararası yayınevi tarafından yayımlanan kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Uluslararası Kitap Editörlüğü'], 'puan' => 40],
    'A07' => ['baslik' => 'Uluslararası hakemli dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 20],
    'A08' => ['baslik' => 'Uluslararası hakemli bilimsel toplantıda yabancı dilde sunulup tam metin yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 15],
    'A09' => ['baslik' => 'Uluslararası bilimsel toplantıda yabancı dilde sunulup yayımlanan bildiri özeti', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster', 'Davetli Konuşmacı'], 'puan' => 5],
    'A10' => ['baslik' => 'Diğer uluslararası bilimsel toplantılarda yabancı dilde sunulup tam metin yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin'], 'puan' => 10],
    'A11' => ['baslik' => 'Yurt dışında yayımlanan kitap ve makalelerde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 6],
    'A12' => ['baslik' => 'Uluslararası dergilerde yayımlanan eleştiri yazısı', 'kategori' => 'makale', 'kaynaklar' => [...$WOS, ...$ENDEKS], 'turler' => $KISA, 'puan' => 5],

    // ══ EK-1/B. ULUSAL YAYIN VE ETKİNLİKLER ══
    'B01' => ['baslik' => 'Ulusal hakemli dergide yayımlanmış tam makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => 20],
    'B02' => ['baslik' => 'Tanınmış ulusal yayınevi ya da üniversite tarafından yayımlanan bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 40],
    'B03' => ['baslik' => 'Tanınmış ulusal yayınevi ya da üniversite tarafından yayımlanan bilimsel kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 10],
    'B04' => ['baslik' => 'Tanınmış ulusal yayınevi ya da üniversite tarafından yayımlanan ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 20],
    'B07' => ['baslik' => 'Tanınmış ulusal yayınevi ya da üniversite tarafından yayımlanan bilimsel kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü', 'Ulusal Kitap Editörlüğü'], 'puan' => 15],
    'B08' => ['baslik' => 'Ulusal hakemli dergilerde hakemlik ya da editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi', 'Hakemlik', 'Yayın Kurulu Üyeliği'], 'puan' => 15],
    'B09' => ['baslik' => 'Tanınmış ulusal yayınevi ya da üniversite tarafından yayımlanan bilimsel kitap tercümesi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 15],
    'B10' => ['baslik' => 'Ulusal hakemli dergide yayımlanmış tam makale tercümesi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 5],
    // Kaynak B/12'yi açıkça "ulusal TAM bildiriler" diye yazıyor ve ulusal
    // bildiri ÖZETİ için satır yok (uluslararası tarafta A/9 var, ulusalda
    // yok). Etiket satırda kalsaydı karşılıksız 5 puan verirdi ve DR-30
    // adet koşulunu da beslerdi.
    'B12' => ['baslik' => 'Yayımlanmış ulusal tam bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 5],
    'B13' => ['baslik' => 'Yurt içinde yayımlanan kitap ve makalelerde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 3],
    'B14' => ['baslik' => 'Ulusal dergilerde yayımlanan eleştiri yazısı', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 5],

    // ══ EK-1/C. ARAŞTIRMA PROJELERİ VE UZMANLIK RAPORLARI ══
    'C01' => ['baslik' => 'Yurt dışı kaynaklı, uluslararası katılımlı proje yürütmek', 'kategori' => 'proje', 'kaynaklar' => $ULUSL_PROJE, 'roller' => ['yurutucu'], 'puan' => 40],
    'C03' => ['baslik' => 'Yurt dışı kaynaklı, uluslararası katılımlı projede görev almak', 'kategori' => 'proje', 'kaynaklar' => $ULUSL_PROJE, 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
    'C04' => ['baslik' => 'Yurt içi kaynaklı proje (TÜBİTAK, TÜBA, DPT destekli) yürütmek', 'kategori' => 'proje', 'kaynaklar' => $ULUSAL_PROJE, 'roller' => ['yurutucu'], 'puan' => 20],
    'C06' => ['baslik' => 'Yurt içi kaynaklı projede görev almak', 'kategori' => 'proje', 'kaynaklar' => $ULUSAL_PROJE, 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 5],
    'C07' => ['baslik' => 'Uluslararası ya da ulusal organizasyonlar için hazırlanmış uzmanlık raporu; kamu kuruluşlarında danışmanlık', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı', 'Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 2],

    // ══ EK-1/D. JÜRİ ÜYELİKLERİ ══
    'D01' => ['baslik' => 'Uluslararası değerlendirme kurulu ya da ödül jürisinde yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], 'puan' => 10],
    'D02' => ['baslik' => 'Ulusal değerlendirme kurulu ya da ödül jürisinde yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 5],

    // ══ EK-1/E. BİLİMSEL ÖDÜLLER ══
    'E01' => ['baslik' => 'Uluslararası bilim ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 60],
    'E02' => ['baslik' => 'Ulusal bilim ödülü (TÜBİTAK, TÜBA, DPT)', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 40],
    'E03' => ['baslik' => 'Bilimsel araştırmalar için alınan burs', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 10],

    // ══ EK-1/F. PATENTLER ══
    'F01' => ['baslik' => 'Yurt dışı patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 100],
    'F02' => ['baslik' => 'Yurt içi patent, faydalı model ya da tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili', 'Ticarileştirme'], 'puan' => 50],

    // ══ EK-2. DİĞER AKADEMİK ÇALIŞMALAR ══
    'E2-01' => ['baslik' => 'Danışmanlığında tamamlanan doktora tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 10],
    'E2-02' => ['baslik' => 'Danışmanlığında tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'puan' => 3],
    'E2-03' => ['baslik' => 'Rektörlük, dekanlık, enstitü, yüksekokul ya da konservatuvar müdürlüğü (her dönem için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Dekan / Enstitü-YO Müdürü'], 'puan' => 10],
    'E2-04' => ['baslik' => 'Bölüm başkanlığı, dekan yardımcılığı, müdür yardımcılığı ya da araştırma merkezi müdürlüğü (her dönem için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör Yardımcısı', 'Bölüm Başkanı', 'Dekan Yrd. / Müdür Yrd.', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 4],
    'E2-05' => ['baslik' => 'Senato, üniversite ve fakülte yönetim kurulu ile fakülte kurulu üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği', 'Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 2],

    // ══ EK-3. GÜZEL SANATLAR ALANI ══
    'E3-01' => ['baslik' => 'Özgün sanat eserinin yurt dışında sanat, eğitim ve kültür kurumlarınca satın alınması ya da gösterime girmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Haber Olması (Uluslararası)'], 'puan' => 60],
    'E3-02' => ['baslik' => 'Oyun yazarı ya da yönetmen olarak uluslararası gösterilerde görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisörlük (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Belgesel/Kısa Film (Uluslararası)'], 'puan' => 60],
    'E3-03' => ['baslik' => 'Oyun yazarı ya da yönetmen olarak ulusal gösterilerde görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Yönetmenlik (Sahne/Ekran)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Belgesel/Kısa Film (Ulusal)'], 'puan' => 40],
    'E3-04' => ['baslik' => 'Özgün sanat eserinin yurt içinde sanat, eğitim ve kültür kurumlarınca satın alınması ya da gösterime girmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Haber Olması (Ulusal)'], 'puan' => 40],
    'E3-05' => ['baslik' => 'Uluslararası jürili sempozyum, bienal, trienal ya da festival gibi karma sanat etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)'], 'puan' => 40],
    'E3-06' => ['baslik' => 'Ulusal jürili sempozyum, bienal, trienal ya da festival gibi karma sanat etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)'], 'puan' => 30],
    'E3-07' => ['baslik' => 'Uluslararası çalıştay, sergi, proje, gösteri ya da dinleti gibi kişisel etkinliklerde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Resital (Uluslararası)', 'Şan Resitali (Uluslararası)', 'Solistlik (Uluslararası)', 'Oratoryo/Kantat Solistliği (Uluslararası)', 'Orkestra Şefliği (Uluslararası)', 'Koro Şefliği (Uluslararası)', 'Opera Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Uluslararası)', 'Grup Şefliği (Uluslararası)', 'Masterclass (Uluslararası)', 'Eğitici Konser Programı (Uluslararası)'], 'puan' => 30],
    'E3-08' => ['baslik' => 'Ulusal çalıştay, sergi, proje, gösteri ya da dinleti gibi kişisel etkinliklerde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)', 'Resital (Ulusal)', 'Şan Resitali (Ulusal)', 'Solistlik (Ulusal)', 'Oratoryo/Kantat Solistliği (Ulusal)', 'Orkestra Şefliği (Ulusal)', 'Koro Şefliği (Ulusal)', 'Opera Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Ulusal)', 'Grup Şefliği (Ulusal)', 'Masterclass (Ulusal)', 'Eğitici Konser Programı (Ulusal)', 'Özgün Eser / Beste / Tasarım', 'Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)'], 'puan' => 20],
    'E3-09' => ['baslik' => 'Oyuncu, dramaturg ya da sahne tasarımcısı olarak gösterilerde görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera Birinci Rol (Uluslararası)', 'Opera Birinci Rol (Ulusal)', 'Bale Başrol (Uluslararası)', 'Bale Başrol (Ulusal)', 'Dansçı / Performans İcracısı (Uluslararası)', 'Dansçı / Performans İcracısı (Ulusal)', 'Sahne Tasarımı (Dekor, Kostüm, Işık)', 'Koreografi', 'Rejisör Yardımcılığı (Uluslararası)', 'Rejisör Yardımcılığı (Ulusal)', 'Rejisör Yardımcılığı (Konservatuvar)'], 'puan' => 20],
    'E3-11' => ['baslik' => 'Uluslararası karma sanat etkinliğine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Karma Sergi (Uluslararası)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Oda Müziği Grup Üyeliği (Uluslararası)', 'Başkemancılık (Uluslararası)', 'Corps de Ballet (Uluslararası)', 'Opera İkinci Rol (Uluslararası)', 'Bale Solist Rol (Uluslararası)'], 'puan' => 15],
    'E3-12' => ['baslik' => 'Ulusal karma sanat etkinliğine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Oda Müziği Grup Üyeliği (Ulusal)', 'Başkemancılık (Ulusal)', 'Orkestra / Koro Üyeliği', 'Corps de Ballet (Ulusal)', 'Opera İkinci Rol (Ulusal)', 'Bale Solist Rol (Ulusal)', 'Karma Albüm / CD-DVD Katkısı'], 'puan' => 10],
    'E3-13' => ['baslik' => 'Jürili yarışmalarda özgün sanat eseri, performans ya da yorumla ödül almak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 20],
    'E3-17' => ['baslik' => 'Yurt dışında arşiv ve koleksiyonlardaki sanat eserlerinin restorasyonu, konservasyonu ve tasnifi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koruma-Onarım Uygulaması (Uluslararası)'], 'puan' => 15],
    'E3-18' => ['baslik' => 'Yurt içinde arşiv ve koleksiyonlardaki sanat eserlerinin restorasyonu, konservasyonu ve tasnifi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koruma-Onarım Uygulaması (Ulusal)'], 'puan' => 10],
    'E3-21' => ['baslik' => 'Açık ve kapalı alanlarda resim, heykel, seramik gibi sanat yapıtı uygulaması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman'], 'puan' => 15],
];

$kodlar = fn (string ...$onekler): array => array_values(array_filter(
    array_keys($maddeler),
    fn (string $kod): bool => array_reduce($onekler, fn (bool $t, string $o): bool => $t || str_starts_with($kod, $o), false)
));

$A_B = [...$kodlar('A0', 'A1'), ...$kodlar('B0', 'B1')];
$EK3 = $kodlar('E3-');

return [
    'kapsam_notu' => 'Puanlar İstanbul Aydın Üniversitesi Akademik Yükseltme ve Atama '
        .'Yönergesinin Ek-1, Ek-2 ve Ek-3 listelerinden. Ortak çalışmalarda Ek-1\'in dipnotu '
        .'uygulanıyor: iki yazarlıda birinci yazar %60, ikinci %40; üç yazarlıda %50, %30, %20; '
        .'dört ve daha fazla yazarlıda birinci yazar %40, kalan %60 diğer yazarlar arasında eşit '
        .'bölünüyor. Yazar listesini boş bırakırsanız bölme uygulanmaz ve puanınız olduğundan '
        .'yüksek görünür. Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: A.3 (önde gelen '
        .'ülkelerin hakemli dergileri) ve B.6 (hakemsiz ulusal dergi) sözlükte karşılıksız; '
        .'ders notu ve hakemsiz dergide tercüme satırları girilemedi; EK-2\'nin ders satırı '
        .'KREDİ SAAT başına puanlandığı için ders kayıtlarınız toplama katkı vermiyor; BAP ve '
        .'özel sektör projeleri yönergenin C bölümünde sayılmıyor; hakemlik, proje '
        .'yardımcılığı, uzmanlık raporu ve burs kalemleri aynı etikete düştüğü için en düşük '
        .'değerden sayılıyor; "her dönem" ve "her yıl" çarpanları uygulanamadığı için idari '
        .'görevler bir kez sayılıyor. Güzel Sanatlar Fakültesi için yönergenin öngördüğü ek '
        .'bazlı yüzde dağılımı (EK1 %30, EK2 %10-20, EK3 %50-60) motorda uygulanamıyor.',

    // Ek-1 dipnotu: iki yazarlı %60-%40; üç yazarlı %50-%30-%20; dört ve
    // üzeri birinci yazar %40, kalan %60 diğerleri arasında eşit.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'editorluk', 'proje', 'tez_danismanligi', 'tez_yayini',
            'egitim_ogretim', 'idari_gorev', 'toplumsal_katki', 'diger'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.60, 3 => 0.50], 'sonrasi' => 0.40],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.60, 3 => 0.50], 'sonrasi' => 0.40],
            'yazar_2' => ['kademeler' => [2 => 0.40, 3 => 0.30], 'bol' => ['pay' => 0.6, 'eksi' => 1]],
            'yazar_3' => ['kademeler' => [3 => 0.20], 'bol' => ['pay' => 0.6, 'eksi' => 1]],
            'ortak' => ['bol' => ['pay' => 0.6, 'eksi' => 1]],
        ],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        // MADDE 6.1: "A1, A2, A3, A4, A5 ile B1, B2, B3, B4, B5, B7, B12".
        // A3 ve B5 sözlükte karşılıksız olduğu için girilemedi.
        'DR-30' => ['A01', 'A02', 'A04', 'A05', 'B01', 'B02', 'B03', 'B04', 'B07', 'B12'],
        // MADDE 6.2, 6.3 ve 6.4: "A ve B maddelerinde tanımlı ulusal ve
        // uluslararası yayınlar".
        'A-B' => $A_B,
        // MADDE 6.5: Sanat ve Mimarlık alanlarında Ek-3 listesi esas alınır.
        'A-B-EK3' => [...$A_B, ...$EK3],
        'TOPLAM' => array_keys($maddeler),
    ],

    'grup_tavanlari' => [],
];
