<?php

/**
 * BİRUNİ ÜNİVERSİTESİ — Ek-1 Faaliyete Göre Puanlama Esasları
 * Kaynak: pdf/17537097592.biruniuniversitesi.pdf
 * (6 sayfa; 05.07.2024 tarihli Senato Karar Eki)
 *
 * KAYNAK PDF TARANMIŞ. Metin katmanı yok; sayfalar 300 dpi PNG'ye
 * çevrilip `tesseract -l tur` ile okundu (PSM verilmedi). Puan sütununun
 * OCR'da bozulduğu üç blok — B1.1'in çeyreklik satırları, B2.1'in tam
 * makale satırı ve B3.1'in atıf satırları — 300 dpi kırpma görüntüleri
 * gözle okunarak doğrulandı.
 *
 * ── EN ÇOK PUAN KAYBETTİREN KARARLAR ──
 *   ATIFLARIN BÜYÜK BÖLÜMÜ GİRİLEMEDİ. B3.1 WoS atfına 1, WoS dışındaki
 *       uluslararası dergi atfına 0,6 puan veriyor; ikincisi ondalık
 *       olduğu için motorun tam sayı puan alanına girmiyor. Yalnız WoS
 *       atfı (1) sayılıyor; TR Dizin ve kitap atıflarının tabloda satırı
 *       zaten yok.
 *   B8.5 ve B8.6 (değerlendirmede olan ya da reddedilmiş proje
 *       BAŞVURULARI, 5-35 puan) girilmedi: kayıt proje başvurusunu
 *       tamamlanmış projeden ayırmıyor ve girilseydi motor en yükseği
 *       seçerdi.
 *   B8.2'nin ulusal proje yürütücülüğü PROJE BÜTÇESİNE bağlı (500 bin
 *       altı 100, 500 bin-1,5 milyon 150, üstü 200). Kayıt bütçe
 *       tutmadığı için §0 uyarınca en düşük basamak (100) alındı.
 *   B9.1 (YDS/YÖKDİL 85 ve üzeri ya da yurt dışında lisans/doktora, 75
 *       puan) girilmedi: faaliyet değil profil ölçütü.
 *   LİSANSÜSTÜ TEZDEN ÜRETİLMİŞ YAYIN kategorisinin tabloda satırı yok.
 *
 * ── TABLODA SATIRI OLMAYAN ÇEYREKLİK ──
 * B1.1 yalnız Q1 (80), Q2 (60) ve Q3 (40) satırlarını taşıyor; Q4 için
 * satır YOK. Q4 makaleleri §0 uyarınca B1.3'ün "diğer uluslararası
 * hakemli dergi" satırından (20) sayılıyor. AHCI'nin de çeyrekliği
 * olmadığı için Q3 değerinden (40) sayılıyor.
 *
 * ── AYNI ETİKETE DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   B7'de uluslararası ödüller (40/30/20) ile ulusal ödüller (30/20/10)
 *       tek "Yarışma Derecesi / Mansiyon" etiketine düşüyor: 10.
 *   B4'te uluslararası kongre görevleri (60'a kadar) ile ulusal
 *       karşılıkları (40'a kadar) ayrılamayan kalemlerde ulusal değerden.
 *   B5'te baş editörlük, yardımcı editörlük, alan editörlüğü ve yayın
 *       kurulu üyeliği dergi türüne göre dört kademe; kayıt "Yayın Kurulu
 *       Üyeliği" ve "Hakemlik" etiketlerini tek tuttuğu için en düşükten.
 *   B6'da faydalı model ve tescilli tasarım uluslararası 80 / ulusal 40:
 *       40'tan sayılıyor.
 *
 * ── YAZAR ÇARPANINDA BİLİNÇLİ SAPMA ──
 * Ek-2'nin oran tablosu "KURUMDAN KATILAN yazar sayısı"na göre kurulmuş;
 * motor toplam yazar sayısını biliyor, kaçının Biruni'den olduğunu
 * bilmiyor. Tablo toplam yazar sayısına uygulandı. Çok yazarlı bir
 * yayında kurumdan yalnız siz varsanız puanınız OLDUĞUNDAN DÜŞÜK görünür.
 *
 * Yönerge: yonerge/biruni.php
 *
 * KİTAPTA KAPSAM AYRIMI (19.09.2026): B1.5 bloğu "ULUSLARARASI yayınevinde
 * yayımlanmış bilimsel kitap" (yabancı dilde basılan eserler), B2.4 ise
 * "ULUSAL yayınevinde yayımlanmış" (Türkçe eserler). Dil koşulu kayıttan
 * okunamıyor ama alt blok ulusal yayınevine ait; kapsam etiketleri kendi
 * bloklarına bağlandı (kitap 150 ↔ 80, bölüm 30 ↔ 20, çeviri 100 ↔ ulusal
 * satırı yok).
 *
 * Kaynakta duran ama cetvelde olmayan kitap editörlüğü kademeleri açıldı:
 * B1.5.c (uluslararası, 100) ve B2.4.d (ulusal, 60). Kapsamsız
 * `Kitap Editörlüğü` etiketi B4.1.e'nin bildiri kitabı editörlüğünde (40)
 * kalmayı sürdürüyor.
 */
$OZGUN = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];
$DERSLER = ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders'];
$ULUSLARARASI_PROJE = ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'];
$ULUSAL_PROJE = ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'];

$maddeler = [
    // ══ A. EĞİTİM-ÖĞRETİM ══
    'A.1.1' => ['baslik' => 'En az bir yıl lisansüstü, lisans ya da ön lisans dersi vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => $DERSLER, 'puan' => 20],
    'A.1.2' => ['baslik' => 'YÖK tarafından tanınan yurt dışındaki bir üniversitede en az bir dönem ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Değişim Programı Dersi'], 'puan' => 25],
    'A.2.1' => ['baslik' => 'Tamamlanmış doktora tezi yönetmek', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman', 'es_danisman'], 'puan' => 15],
    'A.2.2' => ['baslik' => 'Tamamlanmış yüksek lisans tezi yönetmek', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman', 'es_danisman'], 'puan' => 10],
    'A.2.3' => ['baslik' => 'Tez izleme komitesi ya da atama jürisi üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 5],

    // ══ B1. ULUSLARARASI YAYINLAR ══
    'B1.1.Q1' => ['baslik' => 'SSCI, SCI-Expanded ya da AHCI kapsamındaki Q1 dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $OZGUN, 'puan' => 80],
    'B1.1.Q2' => ['baslik' => 'SSCI, SCI-Expanded ya da AHCI kapsamındaki Q2 dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $OZGUN, 'puan' => 60],
    'B1.1.Q3' => ['baslik' => 'SSCI, SCI-Expanded ya da AHCI kapsamındaki Q3 dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)', 'AHCI'], 'turler' => $OZGUN, 'puan' => 40],
    'B1.1.k1' => ['baslik' => 'Q1 dergide editöre mektup, teknik not, vaka incelemesi ya da tartışma', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $KISA, 'puan' => 20],
    'B1.1.k2' => ['baslik' => 'Q2 dergide editöre mektup, teknik not, vaka incelemesi ya da tartışma', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $KISA, 'puan' => 15],
    'B1.1.k3' => ['baslik' => 'Q3 dergide editöre mektup, teknik not, vaka incelemesi ya da tartışma', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)', 'AHCI'], 'turler' => $KISA, 'puan' => 10],
    'B1.2' => ['baslik' => 'ESCI ya da Scopus indeksindeki dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $OZGUN, 'puan' => 30],
    'B1.2.k' => ['baslik' => 'ESCI ya da Scopus indeksindeki dergide editöre mektup, teknik not, vaka incelemesi ya da tartışma', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $KISA, 'puan' => 10],
    'B1.3' => ['baslik' => 'Diğer uluslararası hakemli dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'SCIE/SSCI (Q4)'], 'turler' => $OZGUN, 'puan' => 20],
    'B1.3.k' => ['baslik' => 'Diğer uluslararası hakemli dergide editöre mektup, teknik not, vaka incelemesi ya da tartışma', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'SCIE/SSCI (Q4)'], 'turler' => $KISA, 'puan' => 5],
    'B1.4.t' => ['baslik' => 'Uluslararası hakemli kongre, konferans, sempozyum ya da çalıştayda bildiri kitabında tam metin', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 15],
    'B1.4.o' => ['baslik' => 'Uluslararası hakemli kongre, konferans, sempozyum ya da çalıştayda özet veya poster sunumu', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 10],
    'B1.5.a' => ['baslik' => 'Uluslararası yayınevinde yabancı dilde yayımlanmış bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası Kitap'], 'puan' => 150],
    'B1.5.b' => ['baslik' => 'Uluslararası yayınevinde yayımlanmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Uluslararası Kitap Bölümü'], 'puan' => 30],
    'B2.4.d' => ['baslik' => 'Ulusal yayınevinde yayımlanmış kitapta editörlük (en az 100 sayfa)', 'kategori' => 'editorluk', 'kaynaklar' => ['Ulusal Kitap Editörlüğü'], 'puan' => 60],
    'B1.6.a' => ['baslik' => 'Uluslararası yayınevinde yayımlanmış tüm kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası Çeviri Kitap'], 'puan' => 100],
    'B1.6.b' => ['baslik' => 'Uluslararası yayınevinde yayımlanmış kitapta bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası Çeviri Kitap Bölümü'], 'puan' => 20],

    // ══ B2. ULUSAL YAYINLAR ══
    'B2.1' => ['baslik' => 'ULAKBİM TR Dizininde yer alan dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $OZGUN, 'puan' => 40],
    'B2.1.k' => ['baslik' => 'TR Dizin dergisinde editöre mektup, teknik not, vaka incelemesi, tartışma ya da kitap incelemesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $KISA, 'puan' => 15],
    'B2.2' => ['baslik' => 'Diğer ulusal hakemli bilimsel dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $OZGUN, 'puan' => 15],
    'B2.2.k' => ['baslik' => 'Diğer ulusal hakemli dergide editöre mektup, teknik not, vaka incelemesi, tartışma ya da kitap incelemesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 5],
    'B2.3.t' => ['baslik' => 'Ulusal hakemli kongre, konferans, sempozyum ya da çalıştayda bildiri kitabında tam metin', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 10],
    'B2.3.o' => ['baslik' => 'Ulusal hakemli kongre, konferans, sempozyum ya da çalıştayda özet veya poster sunumu', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 5],
    'B2.4.a' => ['baslik' => 'Ulusal yayınevinde yayımlanmış bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap', 'Ders / Metot Kitabı', 'Tahkik (Tenkitli Metin)'], 'puan' => 80],
    'B2.4.b' => ['baslik' => 'Ulusal yayınevinde yayımlanmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap Bölümü'], 'puan' => 20],
    'B2.4.c' => ['baslik' => 'Ansiklopedide madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 10],

    // ══ B3. ATIFLAR ══
    'B3.1' => ['baslik' => 'SSCI, SCI-Expanded ya da AHCI kapsamındaki dergilerde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 1],

    // ══ B4. KONGRE GÖREVLERİ VE SERGİLER ══
    'B4.1.e' => ['baslik' => 'Uluslararası hakemli kongre, konferans ya da sempozyumda bildiri kitabı editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 40],
    'B4.1.d' => ['baslik' => 'Kongre ya da sempozyumda davetli konuşmacı, panelist veya özel oturum konuşmacısı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 15],
    'B4.1.s' => ['baslik' => 'Uluslararası hakemli kongre, konferans ya da sempozyumda eser sergileme', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Uluslararası)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 80],
    'B4.2.s' => ['baslik' => 'Ulusal hakemli kongre, konferans ya da sempozyumda eser sergileme', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Karma/Jürili Etkinlik (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 30],

    // ══ B5. HAKEMLİK VE EDİTÖRLÜK ══
    'B5.1' => ['baslik' => 'SSCI, SCI-Expanded ya da AHCI kapsamındaki dergide baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 20],
    'B5.2' => ['baslik' => 'ESCI ya da Scopus indeksindeki dergide baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 15],
    'B5.4' => ['baslik' => 'ULAKBİM TR Dizininde yer alan dergide baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 8],
    'B5.5' => ['baslik' => 'Diğer ulusal hakemli dergide baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 5],
    'B5.k' => ['baslik' => 'Dergide yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 1],
    'B5.h' => ['baslik' => 'Dergi ya da kitap hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 5],
    'B5.6' => ['baslik' => 'Uluslararası yayınevinde yayımlanmış bilimsel kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Uluslararası Kitap Editörlüğü'], 'puan' => 100],

    // ══ B6. PATENT, MODEL VE TASARIM ══
    'B6.1.a' => ['baslik' => 'Uluslararası yetkili kuruluşlarca onaylanan patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 200],
    'B6.2.a' => ['baslik' => 'Ulusal yetkili kuruluşlarca onaylanan patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 90],
    'B6.2.b' => ['baslik' => 'Faydalı model ya da tescilli tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili', 'Yazılım'], 'puan' => 40],
    'B8.4.t' => ['baslik' => 'Teknopark bünyesinde şirket kurmak', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 30],

    // ══ B7. ÖDÜLLER ══
    'B7.c' => ['baslik' => 'Cumhurbaşkanlığı Bilim, Kültür ve Sanat Ödülü, YÖK Üstün Başarı Ödülü, TÜBİTAK ya da TÜBA ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 100],
    'B7.y' => ['baslik' => 'Resmi ya da profesyonel kuruluşların düzenlediği organizasyonlarda alınan derece veya mansiyon', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon', 'Ulusal Bilim/Sanat Ödülü', 'Burs'], 'puan' => 10],

    // ══ B8. PROJE FAALİYETLERİ ══
    'B8.1.y' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen ve tamamlanmış projede yürütücü ya da eş yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => $ULUSLARARASI_PROJE, 'roller' => ['yurutucu'], 'puan' => 250],
    'B8.1.a' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen ve tamamlanmış projede araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => $ULUSLARARASI_PROJE, 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 100],
    'B8.1.d' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen ve tamamlanmış projede danışman ya da izleyici olmak', 'kategori' => 'proje', 'kaynaklar' => $ULUSLARARASI_PROJE, 'roller' => ['danisman'], 'puan' => 30],
    'B8.2.y' => ['baslik' => 'Ulusal kuruluşlarca desteklenen ve tamamlanmış projede yürütücü ya da eş yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => $ULUSAL_PROJE, 'roller' => ['yurutucu'], 'puan' => 100],
    'B8.2.a' => ['baslik' => 'Ulusal kuruluşlarca desteklenen ve tamamlanmış projede araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => $ULUSAL_PROJE, 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 60],
    'B8.2.d' => ['baslik' => 'Ulusal kuruluşlarca desteklenen ve tamamlanmış projede danışman ya da izleyici olmak', 'kategori' => 'proje', 'kaynaklar' => $ULUSAL_PROJE, 'roller' => ['danisman'], 'puan' => 20],
    'B8.3' => ['baslik' => 'Diğer üniversite ya da kuruluşlarca desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'puan' => 75],
    'B8.4' => ['baslik' => 'Sivil toplum kuruluşları için proje ya da danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'puan' => 15],
    'B8.o' => ['baslik' => 'Öğrenci projesi danışmanlığı (TÜBİTAK 2209, TÜSEB)', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'puan' => 15],

    // ══ C. İDARİ GÖREVLER ══
    'C1.r' => ['baslik' => 'Rektörlük', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör'], 'puan' => 600],
    'C1.ry' => ['baslik' => 'Rektör yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör Yardımcısı'], 'puan' => 300],
    'C1.d' => ['baslik' => 'Dekanlık, enstitü ya da meslek yüksekokulu müdürlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü'], 'puan' => 150],
    'C1.dy' => ['baslik' => 'Dekan yardımcılığı, enstitü ya da meslek yüksekokulu müdür yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 70],
    'C1.b' => ['baslik' => 'Bölüm başkanlığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 50],
    'C1.a' => ['baslik' => 'Anabilim dalı başkanlığı ya da koordinatörlük', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük', 'Bölüm Başkan Yardımcısı'], 'puan' => 40],
    'C1.m' => ['baslik' => 'Rektörlüğe bağlı merkezlerde müdürlük ya da birimlerde yöneticilik', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 40],
    'C1.2' => ['baslik' => 'Senato, üniversite ya da fakülte yönetim kurulu üyeliği; kurul ve komisyon üyelikleri', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 20],

    // ══ C2. DİĞER GÖREVLER ══
    'C2.a' => ['baslik' => 'Sosyal sorumluluk projesi yönetmek', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi'], 'puan' => 15],
    'C2.b' => ['baslik' => 'Sosyal sorumluluk projesinde görev almak ya da kamu-STK danışmanlığı', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı'], 'puan' => 10],
    'C2.c' => ['baslik' => 'Üniversite dışı dergi ve gazetelerde makale yazmak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Bilim İletişimi / Popüler Yayın'], 'puan' => 5],
    'TOPLANTI-UYE' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 5],
    'TOPLANTI-OTR' => ['baslik' => 'Bilimsel toplantıda oturum başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Uluslararası)', 'Oturum Başkanlığı (Ulusal)'], 'puan' => 2],
];

return [
    'kapsam_notu' => 'Puanlar Biruni Üniversitesi Öğretim Üyeliğine Yükseltilme ve Atanma '
        .'Yönergesinin Ek-1 tablosundan. Kaynak PDF taranmış; sayfalar 300 dpi görüntüden OCR '
        .'ile okundu, puan sütununun bozulduğu bloklar kırpma görüntüleriyle gözle doğrulandı. '
        .'Yazar çarpanı Ek-2\'nin yazar sayısı × sıra tablosundan; tablo "KURUMDAN KATILAN yazar '
        .'sayısı"na göre kurulmuş, motor toplam yazar sayısını bildiği için tablo toplam sayıya '
        .'uygulandı — çok yazarlı bir yayında kurumdan yalnız siz varsanız puanınız düşük '
        .'görünür. Yazar listesini boş bırakırsanız çarpan hiç uygulanmaz ve puanınız yüksek '
        .'görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: WoS dışındaki uluslararası dergi '
        .'atıfları (atıf başına 0,6) ondalık olduğu için girilemedi; ulusal proje '
        .'yürütücülüğünde puan PROJE BÜTÇESİNE bağlı (100/150/200) ve kayıt bütçe tutmadığı için '
        .'en düşük basamak alındı; B9.1 yabancı dil satırı (75) profil ölçütü olduğu için, '
        .'B8.5-B8.6 proje BAŞVURULARI tamamlanmış projeden ayrılamadığı için girilmedi; '
        .'lisansüstü tezden üretilmiş yayın kategorisinin tabloda karşılığı yok. B1.1 yalnız '
        .'Q1-Q3 satırı taşıyor; Q4 makaleleriniz "diğer uluslararası dergi" satırından (20), '
        .'AHCI makaleleriniz Q3 değerinden (40) sayılıyor. Uluslararası ödüller, kongre '
        .'görevleri, editörlük kademeleri ve faydalı model etiket ayrımı taşımadığı için en '
        .'düşük satırlarından sayılıyor.'
        .'ESCI ya da Scopus dergilerinde aldığınız atıflar SAYILMIYOR: yönergenin atıf tablosu yalnız SCI-E/SSCI/AHCI dergilerini, kitapları ve ulusal dergileri anıyor, aradaki kademe için karşılık vermiyor.'
        .' KİTAPTA DİL KOŞULU DENETLENMİYOR: uluslararası yayınevi kitabınız yönergenin "yabancı dilde yayımlanmış" satırından sayılıyor. Kitabınız Türkçe ise puanınız olduğundan YÜKSEK görünür.',

    'yazar_katsayisi' => [
        'haric' => ['atif', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev', 'odul',
            'editorluk', 'toplumsal_katki', 'proje', 'patent', 'sanatsal_etkinlik', 'diger'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.60, 3 => 0.50, 4 => 0.40, 5 => 0.35, 6 => 0.30, 7 => 0.30, 8 => 0.30, 9 => 0.30], 'sonrasi' => 0.30],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.60, 3 => 0.50, 4 => 0.40, 5 => 0.35, 6 => 0.30, 7 => 0.30, 8 => 0.30, 9 => 0.30], 'sonrasi' => 0.30],
            'yazar_2' => ['kademeler' => [2 => 0.40, 3 => 0.30, 4 => 0.30, 5 => 0.20, 6 => 0.20, 7 => 0.20, 8 => 0.20, 9 => 0.20], 'sonrasi' => 0.20],
            'yazar_3' => ['kademeler' => [3 => 0.20, 4 => 0.15, 5 => 0.15, 6 => 0.15, 7 => 0.15, 8 => 0.15, 9 => 0.15], 'sonrasi' => 0.10],
            'yazar_4' => ['kademeler' => [4 => 0.15, 5 => 0.15, 6 => 0.15, 7 => 0.15, 8 => 0.15, 9 => 0.10], 'sonrasi' => 0.10],
            'yazar_5' => ['kademeler' => [5 => 0.15, 6 => 0.10, 7 => 0.10, 8 => 0.05, 9 => 0.05], 'sonrasi' => 0.05],
            'yazar_6' => ['kademeler' => [6 => 0.10, 7 => 0.05, 8 => 0.05, 9 => 0.05], 'sonrasi' => 0.05],
            'ortak' => ['kademeler' => [1 => 1.00, 2 => 0.40, 3 => 0.20, 4 => 0.15, 5 => 0.15, 6 => 0.10], 'sonrasi' => 0.05],
        ],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        'TUM' => array_keys($maddeler),
        // MADDE 5: "ulusal veya uluslararası hakemli dergide makale/derleme,
        // bildiri kitabında tam metin bildiri ya da olgu sunumu".
        'MAKALE-BILDIRI' => ['B1.1.Q1', 'B1.1.Q2', 'B1.1.Q3', 'B1.1.k1', 'B1.1.k2', 'B1.1.k3',
            'B1.2', 'B1.2.k', 'B1.3', 'B1.3.k', 'B2.1', 'B2.1.k', 'B2.2', 'B2.2.k',
            'B1.4.t', 'B2.3.t'],
        // MADDE 7: SSCI, SCI-Expanded ve AHCI kapsamındaki özgün makaleler.
        'WOS-MAKALE' => ['B1.1.Q1', 'B1.1.Q2', 'B1.1.Q3'],
        // MADDE 7/2: WoS ve ESCI kapsamı ile ulusal taranan dergiler.
        'WOS-ESCI-TRDIZIN' => ['B1.1.Q1', 'B1.1.Q2', 'B1.1.Q3', 'B1.2', 'B2.1'],
    ],

    'grup_tavanlari' => [],
];
