<?php

/**
 * ŞIRNAK ÜNİVERSİTESİ — EK-1 Akademik Kadrolara Yükseltilme ve Atanma
 * Esaslarına İlişkin Puan Çizelgesi
 * Kaynak: pdf/17634009071.Şırnak Üniversitesi Kriter.pdf (11 sayfa;
 * belge 31.12.2024 tarihli, Senato kabulü ve YÖK onayıyla yürürlüğe
 * girer.)
 *
 * Madde kodları çizelgenin kendi numaralandırması (1.1.1, 2.3.5,
 * II.5.4 …). Roman rakamlı iki ana bölüm ayrımı için "I." ve "II."
 * önekleri korundu. Yalnız 1.1.1'in çeyreklik alt kodları ve
 * projelerdeki rol ayrımı (`-yur`, `-ars`, `-dan`, `-burs`) bize ait.
 *
 * ── ÇEYREKLİK EKİ CETVELE GÖMÜLDÜ ──
 * MADDE 5.3: SCI, SCI-E, SSCI ve AHCI makalelerinde derginin çeyreklik
 * dilimine göre Q1 için +30, Q2 için +20, Q3 için +10 puan ekleniyor.
 * 1.1.1'in taban puanı 30 olduğundan satır dört koda bölündü: Q1 60,
 * Q2 50, Q3 40, Q4 30.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   AHCI dergileri için sözlük çeyreklik taşımıyor; en düşük çeyrek
 *       (30) uygulandı.
 *   3.2 uluslararası poster tam metin (10), 3.3 sözlü özet (7) ve 3.4
 *       poster özet (5) tek 'Uluslararası Özet/Poster' etiketine
 *       düşüyor; 5 girildi. Ulusal karşılıklarında 3 girildi.
 *   5.2 TÜBİTAK ARDEB (60), 5.3 hızlı destek (30) ve 5.5 TEYDEB (40)
 *       tek 'TÜBİTAK' etiketine düşüyor; 30 girildi.
 *   6.1.1 uluslararası çağrılı konuşma (8) ile 6.2.1 ulusal çağrılı
 *       konuşma (5) → 5.
 *   8.3 uluslararası editör yardımcılığı (8) ile 8.6 ulusal editör
 *       kurulu üyeliği (2) → 2; 8.7 uluslararası hakemlik (5) ile 8.8
 *       ulusal hakemlik (3) → 3.
 *   9. bölümdeki sergi satırları (bireysel 15, grup 10-15, karma 5)
 *       yurtiçi/yurtdışı ayrımı taşımayan etiketlerde en düşük
 *       değerle girildi.
 *   II.3'ün jüri üyelikleri (doktora yeterlik 2, TİK 3, doktora tez
 *       jürisi 3, yüksek lisans tez jürisi 2) tek 'Tez İzleme / Jüri
 *       Üyeliği' etiketine düşüyor; 2 girildi.
 *   II.5.5 fakülte kurulu üyeliği (3) ile II.5.2'nin bölüm başkan
 *       yardımcılığı karşılığı → 3.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   4.3 (H indeksi × 5) — faaliyet değil ölçüt.
 *   1.2.4 (makale çevirisi), 5.6 (yurt dışı araştırma projesinde ay
 *       başına puan), 5.8 (proje başvurusu), 7. bölümün başkanlık ve
 *       sekreterlik satırları, 8.2 ve 8.5 (toplantı kitabı
 *       editörlüğü), 10. bölüm (koleksiyon), 11. bölüm (müzik
 *       teknolojisi), II.2.2.1 (dijital okuryazarlık belgesi) ve
 *       II.4 (sağlık eğitimi hizmetleri) — sözlükte karşılıksız.
 *   Derslerde puan HAFTALIK DERS SAATİ başına 1 puan; kayıt ders
 *       başına tutulduğu için her ders 1 puan sayılıyor (bölümün
 *       tavanı 30 puan).
 *
 * Yönerge: yonerge/sirnak.php
 */
$SCI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)'];
$TAM = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];

$SANAT_KISISEL = ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Ulusal)',
    'Elektronik Kişisel Sergi (Uluslararası)', 'Elektronik Kişisel Sergi (Ulusal)',
    'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)',
    'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)',
    'Resital (Uluslararası)', 'Resital (Ulusal)', 'Solistlik (Uluslararası)', 'Solistlik (Ulusal)',
    'Şan Resitali (Uluslararası)', 'Şan Resitali (Ulusal)', 'Opera Birinci Rol (Uluslararası)',
    'Opera Birinci Rol (Ulusal)', 'Bale Başrol (Uluslararası)', 'Bale Başrol (Ulusal)',
    'Bandrollü Kayıt (CD/DVD)', 'Albüm / Konser Kaydı'];
$SANAT_KARMA = ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Ulusal)',
    'Elektronik Karma Sergi (Uluslararası)', 'Elektronik Karma Sergi (Ulusal)',
    'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Jürisiz, Ulusal)',
    'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)',
    'Oda Müziği Grup Üyeliği (Uluslararası)', 'Oda Müziği Grup Üyeliği (Ulusal)',
    'Karma Albüm / CD-DVD Katkısı', 'Eğitici Konser Programı (Uluslararası)',
    'Eğitici Konser Programı (Ulusal)', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)',
    'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'];
$SANAT_TOPLULUK = ['Orkestra / Koro Üyeliği', 'Corps de Ballet (Uluslararası)',
    'Corps de Ballet (Ulusal)', 'Opera İkinci Rol (Uluslararası)', 'Opera İkinci Rol (Ulusal)',
    'Bale Solist Rol (Uluslararası)', 'Bale Solist Rol (Ulusal)', 'Grup Şefliği (Uluslararası)',
    'Grup Şefliği (Ulusal)', 'Başkemancılık (Uluslararası)', 'Başkemancılık (Ulusal)'];
$MUZIK_ESER = ['Özgün Eser / Beste / Tasarım', 'Opera/Bale Kompozisyonu', 'Orkestralı Sahne Eseri',
    'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Küçük Ölçekli Orkestra Eseri',
    'Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)',
    'Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Sahne/Ekran Müziği',
    'Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi', 'Eğitim Müziği Albümü'];

$maddeler = [
    // ══ I.1. MAKALELER ══ (çeyreklik alt kodları MADDE 5.3'ten)
    '1.1.1-Q1' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki Q1 dergide yayımlanan makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $TAM, 'puan' => 60],
    '1.1.1-Q2' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki Q2 dergide yayımlanan makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $TAM, 'puan' => 50],
    '1.1.1-Q3' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki Q3 dergide yayımlanan makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $TAM, 'puan' => 40],
    '1.1.1-Q4' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki Q4 dergide yayımlanan makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => $TAM, 'puan' => 30],
    '1.1.2' => ['baslik' => 'ÜAK tarafından belirlenen alan indekslerinde taranan hakemli dergide yayımlanan makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $TAM, 'puan' => 25],
    '1.1.3' => ['baslik' => 'Diğer uluslararası indekslerde taranan hakemli dergide yayımlanan makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $TAM, 'puan' => 15],
    '1.1.4' => ['baslik' => 'Uluslararası atıf endeksli dergide yayımlanan vaka takdimi, çağrılı derleme, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => [...$SCI, 'AHCI', 'ESCI / Scopus'], 'turler' => $KISA, 'puan' => 15],
    '1.1.5' => ['baslik' => 'Atıf endekslerince taranmayan uluslararası hakemli dergide yayımlanan vaka takdimi, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 5],
    '1.2.1' => ['baslik' => 'TR Dizinde taranan ulusal hakemli dergide yayımlanan makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TAM, 'puan' => 20],
    '1.2.2' => ['baslik' => 'TR Dizinde taranmayan ulusal hakemli dergide yayımlanan makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => 10],
    '1.2.3' => ['baslik' => 'Ulusal hakemli dergide yayımlanan vaka takdimi, çağrılı derleme, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 7],

    // ══ I.2. KİTAPLAR ══
    '2.1.1' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanan bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 40],
    '2.1.2' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanan bilimsel kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 20],
    '2.1.3' => ['baslik' => 'Uluslararası bilimsel kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 20],
    '2.2.1' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanan bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 25],
    '2.2.2' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanan bilimsel kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 10],
    '2.2.3' => ['baslik' => 'Ulusal yayımlanan bilimsel kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 10],
    '2.3.1' => ['baslik' => 'Yardımcı ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 10],
    '2.3.3' => ['baslik' => 'Çeviri kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 15],
    '2.3.4' => ['baslik' => 'Kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 10],
    '2.3.5' => ['baslik' => 'Ansiklopedide madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 7],

    // ══ I.3. BİLDİRİLER ══
    '3.1' => ['baslik' => 'Sözlü sunulan ve tam metni yayımlanmış uluslararası bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 15],
    '3.4' => ['baslik' => 'Özet metni yayımlanmış uluslararası bildiri ya da poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 5],
    '3.5' => ['baslik' => 'Sözlü sunulan ve tam metni yayımlanmış ulusal bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 10],
    '3.8' => ['baslik' => 'Özet metni yayımlanmış ulusal bildiri ya da poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 3],

    // ══ I.4. ATIFLAR ══ (4.1 ve 4.2'den en fazla 100 puan)
    '4.1' => ['baslik' => 'Uluslararası kaynak kitaplarda ve atıf endeksli dergilerde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 5],
    '4.2' => ['baslik' => 'Ulusal kaynak kitaplarda ve hakemli dergilerde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 2],

    // ══ I.5. ARAŞTIRMA PROJELERİ ══ (rol oranları MADDE 5.2)
    '5.1-yur' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen Ar-Ge projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 80],
    '5.1-ars' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen Ar-Ge projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci'], 'puan' => 40],
    '5.1-dan' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen Ar-Ge projesinde danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['danisman'], 'puan' => 24],
    '5.1-burs' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen Ar-Ge projesinde bursiyer olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['bursiyer'], 'puan' => 16],
    '5.3-yur' => ['baslik' => 'TÜBİTAK destekli projede yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 30],
    '5.3-ars' => ['baslik' => 'TÜBİTAK destekli projede araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['arastirmaci'], 'puan' => 15],
    '5.3-dan' => ['baslik' => 'TÜBİTAK destekli projede danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['danisman'], 'puan' => 9],
    '5.3-burs' => ['baslik' => 'TÜBİTAK destekli projede bursiyer olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['bursiyer'], 'puan' => 6],
    '5.4-yur' => ['baslik' => 'Diğer ulusal kuruluşlarca desteklenen projede yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 50],
    '5.4-ars' => ['baslik' => 'Diğer ulusal kuruluşlarca desteklenen projede araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK', 'TÜSEB'], 'roller' => ['arastirmaci'], 'puan' => 25],
    '5.4-dan' => ['baslik' => 'Diğer ulusal kuruluşlarca desteklenen projede danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK', 'TÜSEB'], 'roller' => ['danisman'], 'puan' => 15],
    '5.4-burs' => ['baslik' => 'Diğer ulusal kuruluşlarca desteklenen projede bursiyer olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK', 'TÜSEB'], 'roller' => ['bursiyer'], 'puan' => 10],
    '5.7-yur' => ['baslik' => 'Üniversite Araştırma Fonu (BAP) projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 10],
    '5.7-ars' => ['baslik' => 'Üniversite Araştırma Fonu (BAP) projesinde araştırmacı, danışman ya da bursiyer olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 5],
    '5.9' => ['baslik' => 'Kurum dışı destekli öğrenci proje programlarında danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'puan' => 5],

    // ══ I.6. KONFERANS, SEMİNER, PANEL ══ (en fazla 5 faaliyet)
    '6.2.1' => ['baslik' => 'Bilimsel toplantıda çağrılı konuşmacı olarak katılmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 5],
    '6.2.3' => ['baslik' => 'Ulusal radyo ve televizyonda mesleki konularda konuşma yapmak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Bilim İletişimi / Popüler Yayın', 'Kamu/STK Danışmanlığı', 'Topluma Hizmet Projesi'], 'puan' => 5],

    // ══ I.7. BİLİMSEL TOPLANTILAR ══
    '7.2.2' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulunda üyelik', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 3],

    // ══ I.8. EDİTÖRLÜK VE HAKEMLİK ══
    '8.1' => ['baslik' => 'Uluslararası atıf endekslerince taranan bilimsel dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 15],
    '8.4' => ['baslik' => 'Ulusal hakemli bilimsel dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 6],
    '8.6' => ['baslik' => 'Bilimsel dergide editör yardımcılığı, alan editörlüğü ya da editörler kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 2],
    '8.8' => ['baslik' => 'Bilimsel dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 3],

    // ══ I.9. SERGİLER ══
    '9.1.1' => ['baslik' => 'Bireysel (kişisel) sergi ya da dinleti', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $SANAT_KISISEL, 'puan' => 15],
    '9.1.3' => ['baslik' => 'Grup sergisi, bienal, trienal ya da karma dinleti', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => [...$SANAT_KARMA, 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 10],
    '9.1.6' => ['baslik' => 'Karma sergi ya da toplulukta yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $SANAT_TOPLULUK, 'puan' => 5],

    // ══ I.12. MÜZİK KOMPOZİSYONLARI ══
    '12.3' => ['baslik' => 'Sahne yapıtı, senfonik yapıt, oda müziği, koro, solo ya da elektronik müzik yapıtı bestelemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $MUZIK_ESER, 'puan' => 15],

    // ══ I.13. SANATSAL ETKİNLİKLER ══
    '13.7' => ['baslik' => 'Sahne, televizyon, radyo ya da sinema yapıtında yer almak; koreografi, rejisörlük veya sahne tasarımı yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koreografi', 'Yönetmenlik (Sahne/Ekran)', 'Sahne Tasarımı (Dekor, Kostüm, Işık)', 'Rejisörlük (Uluslararası)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Orkestra Şefliği (Uluslararası)', 'Orkestra Şefliği (Ulusal)', 'Koro Şefliği (Uluslararası)', 'Koro Şefliği (Ulusal)', 'Opera Şefliği (Uluslararası)', 'Opera Şefliği (Ulusal)'], 'puan' => 10],

    // ══ I.17. ÖDÜLLER VE PATENTLER ══
    '17.1' => ['baslik' => 'Uluslararası bilim ya da sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 30],
    '17.2' => ['baslik' => 'Ulusal bilim ödülü ya da ilanlı ve jürili ödül', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'YÖK Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'Yarışma Derecesi / Mansiyon'], 'puan' => 20],
    '17.3' => ['baslik' => 'Yabancı ülkeden alınan patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 30],
    '17.4' => ['baslik' => 'Ulusal patent, faydalı model ya da çeşit tescili', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili', 'Yazılım', 'Ticarileştirme'], 'puan' => 20],

    // ══ II.1. EĞİTİM-ÖĞRETİMDE VERİLEN DERSLER ══ (en fazla 30 puan)
    'II.1' => ['baslik' => 'Ön lisans, lisans ya da lisansüstü ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 1],

    // ══ II.2. YÖNETİMİNDE TAMAMLANAN TEZLER ══
    'II.2.1.1' => ['baslik' => 'Danışmanlığınızda tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 5],
    'II.2.1.1-es' => ['baslik' => 'Eş danışmanlığınızda tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 2],
    'II.2.1.2' => ['baslik' => 'Danışmanlığınızda tamamlanan doktora ya da uzmanlık tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 10],
    'II.2.1.2-es' => ['baslik' => 'Eş danışmanlığınızda tamamlanan doktora ya da uzmanlık tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 5],

    // ══ II.3. JÜRİ ÜYELİKLERİ ══
    'II.3.4' => ['baslik' => 'Lisansüstü tez izleme komitesi ya da tez jürisi üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 2],
    'II.3.6' => ['baslik' => 'Uluslararası bilimsel ya da sanatsal yarışma jürisi üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 10],

    // ══ II.5. İDARİ GÖREVLER ══
    'II.5.1' => ['baslik' => 'Rektör, rektör yardımcısı, dekan, enstitü ya da yüksekokul müdürü veya başhekim olarak görev yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü'], 'puan' => 10],
    'II.5.2' => ['baslik' => 'Bölüm başkanı, dekan yardımcısı ya da müdür yardımcısı olarak görev yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı', 'Dekan Yrd. / Müdür Yrd.'], 'puan' => 5],
    'II.5.4' => ['baslik' => 'Seçilmiş senato ya da üniversite yönetim kurulu üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Senato / Üniversite Yönetim Kurulu Üyesi'], 'puan' => 4],
    'II.5.5' => ['baslik' => 'Anabilim dalı başkanlığı, uygulama ve araştırma merkezi müdürlüğü, koordinatörlük ya da bölüm başkan yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük', 'Uygulama ve Araştırma Merkezi Müdürü', 'Bölüm Başkan Yardımcısı'], 'puan' => 3],
    'II.5.6' => ['baslik' => 'Kurul ya da komisyon üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 2],
];

$gruplar = [
    // MADDE 6.2'nin "Makaleler başlığı altında verilen yayınlar" kümesi.
    'MAKALELER' => ['1.1.1-Q1', '1.1.1-Q2', '1.1.1-Q3', '1.1.1-Q4', '1.1.2', '1.1.3', '1.1.4',
        '1.1.5', '1.2.1', '1.2.2', '1.2.3'],
    'KITAPLAR' => ['2.1.1', '2.1.2', '2.1.3', '2.2.1', '2.2.2', '2.2.3', '2.3.1', '2.3.3',
        '2.3.4', '2.3.5'],
    // MADDE 8.3'ün "1. ve/veya 2. Puanlama Tablosunda belirtilen faaliyetler" kümesi.
    'MAKALE-KITAP' => ['MAKALELER', 'KITAPLAR'],
    'ATIF' => ['4.1', '4.2'],
    'PROJE' => ['5.1-yur', '5.1-ars', '5.1-dan', '5.1-burs', '5.3-yur', '5.3-ars', '5.3-dan',
        '5.3-burs', '5.4-yur', '5.4-ars', '5.4-dan', '5.4-burs', '5.7-yur', '5.7-ars', '5.9'],
    'DAVETLI' => ['6.2.1'],
    'CEVIRI' => ['2.3.3'],
    'ANSIKLOPEDI' => ['2.3.5'],
    'DERS' => ['II.1'],
];

// MADDE 5.1: kitap, makale ve bildirilerde yazar başına katkı oranları.
$yazarKatsayisi = [
    'haric' => ['atif', 'proje', 'patent', 'tez_danismanligi', 'egitim_ogretim', 'odul',
        'idari_gorev', 'toplumsal_katki', 'diger', 'editorluk', 'sanatsal_etkinlik'],
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.00]],
        'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.80], 'sonrasi' => 0.60],
        'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.80], 'sonrasi' => 0.60],
        'yazar_2' => ['kademeler' => [2 => 0.80, 3 => 0.70], 'bol' => ['pay' => 0.60, 'eksi' => 1]],
        'yazar_3' => ['kademeler' => [3 => 0.60], 'bol' => ['pay' => 0.60, 'eksi' => 1]],
        'yazar_4' => ['bol' => ['pay' => 0.60, 'eksi' => 1]],
        'yazar_5' => ['bol' => ['pay' => 0.60, 'eksi' => 1]],
        'yazar_6' => ['bol' => ['pay' => 0.60, 'eksi' => 1]],
        'ortak' => ['bol' => ['pay' => 0.60, 'eksi' => 1]],
    ],
];

return [
    'kapsam_notu' => 'Puanlar Şırnak Üniversitesi Akademik Kadrolara Yükseltilme ve Atanma '
        .'Esaslarına İlişkin Puan Çizelgesinden (EK-1). SCI, SCI-Expanded, SSCI ve AHCI '
        .'makalelerinde MADDE 5.3\'ün çeyreklik eki cetvele gömüldü: Q1 60, Q2 50, Q3 40, Q4 30 '
        .'puan. Yazar çarpanı MADDE 5.1\'den: iki yazarlıda birinci %90, ikinci %80; üç yazarlıda '
        .'%80, %70, %60; dört ve daha fazla yazarlıda birinci %60, diğerleri %60 / (yazar sayısı '
        .'- 1). Projelerde yürütücü tam puan, araştırmacı yarısı, danışman %30\'u, bursiyer '
        .'%20\'si. Yazar listesini boş bırakırsanız çarpan hiç uygulanmaz ve puanınız olduğundan '
        .'YÜKSEK görünür; rolü girilmemiş projeler 0 puan alır. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: dersler HAFTALIK DERS SAATİ başına 1 '
        .'puan alıyor, kayıt ders başına tutulduğu için her ders 1 puan sayılıyor (bölümün '
        .'tavanı 30). H indeksi puanı (5 × H) hesaplanmıyor. TÜBİTAK ARDEB (60) ve TEYDEB (40) '
        .'projeleri hızlı destek satırından (30) sayılıyor. Uluslararası poster tam metin (10) ve '
        .'sözlü özet bildiri (7) poster özeti puanıyla (5), uluslararası çağrılı konuşma (8) '
        .'ulusal puanıyla (5), uluslararası editör yardımcılığı (8) ulusal puanıyla (2), '
        .'uluslararası hakemlik (5) ulusal puanıyla (3) sayılıyor. Koleksiyon, müzik teknolojisi, '
        .'bilimsel toplantı başkanlığı ve sağlık eğitimi hizmetleri satırları sözlükte '
        .'karşılıksız. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünür: aynı kitaptan en fazla iki bölümün, '
        .'en fazla üç kitap çevirisinin, aynı ansiklopediden en fazla üç maddenin ve konferans '
        .'bölümünden en fazla beş faaliyetin sayılması kuralları tavana çevrildi ama idari '
        .'görevlerin ay başına oranlanması uygulanmıyor.',

    'yazar_katsayisi' => $yazarKatsayisi,
    'maddeler' => $maddeler,
    'gruplar' => $gruplar,

    // 4. bölüm "4.1, 4.2'den en fazla 100 puan"; 2.3.3 "en çok üç kitap
    // çevirisi" (3 × 15); 2.3.5 "en fazla üç madde" (3 × 7); 6. bölüm
    // "en fazla 5 faaliyet" (5 × 5); II.1 "maksimum 30 puan".
    'grup_tavanlari' => ['ATIF' => 100, 'CEVIRI' => 45, 'ANSIKLOPEDI' => 21, 'DAVETLI' => 25,
        'DERS' => 30],
];
