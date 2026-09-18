<?php

/**
 * KIRKLARELİ ÜNİVERSİTESİ — EK-I Aday Etkinlik Puanlama Tablosu
 * Kaynak: pdf/1770040975746.kirklareli-kriter-02022026.pdf (18 sayfa)
 *         08/11/2018 tarih, 91 sayılı Senato toplantısının 1 no'lu karar eki;
 *         02 Ocak 2019 itibarıyla yürürlükte (MADDE 15).
 *
 * KAYNAK PDF TARANMIŞ (HP Scan, metin katmanı yok); 400 dpi görüntüden
 * `tesseract -l tur` ile okundu. TABLONUN PUAN SÜTUNU OCR ÇIKTISINDA A, B ve
 * Ç bölümlerinde HİÇ GÖRÜNMÜYORDU — sütun dar ve dikey "PUAN" başlığı taşıyor.
 * Puanlar sayfa görüntüsünün sağ şeridi ayrıca kırpılıp gözle okunarak alındı.
 * Bir OCR çıktısında bir bölümün puanları eksikse tabloyu okunamaz ilan etmeden
 * önce sayfanın SAĞ ŞERİDİNİ kırpıp bak.
 *
 * MADDE KODLARI yönergenin kendi bölüm harfi + satır numarası. Koşullar tabloya
 * BÖLÜM HARFİYLE atıf yapıyor ("A bendi kapsamında en az iki yayın",
 * "A, B, C, Ç, D ve E bendi kapsamında en az iki çalışma"), bu yüzden harf
 * grupları `gruplar` altında ayrı ayrı duruyor.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR (§0) ──
 *   A.3 (90) ile A.4 (70) ÇAKIŞIYOR. A.3 "SCI/SSCI/AHCI/ESCI dışındaki
 *       indeksler tarafından taranan uluslararası hakemli dergiler", A.4 ise
 *       "1 ve 2 nci fıkralardaki indekslere girmeyen uluslararası hakemli
 *       dergiler" diyor — ikinci tanım birincisini de kapsıyor (kaynak
 *       metninde bir çakışma). İkisi de "Diğer Uluslararası İndeks"
 *       etiketine düştüğü için DÜŞÜĞÜ (70) girildi; 90'lık satır yazılmadı.
 *   B.2 (30), B.3 (20) ve B.4 (15) tek "Uluslararası Özet/Poster" etiketine
 *       düşüyor → 15. B.6 (15) ile B.7 (10) tek "Ulusal Özet/Poster"
 *       etiketine düşüyor → 10.
 *   C.3 (uluslararası ansiklopedi maddesi 50) ile C.7 (ulusal 25) tek
 *       "Ansiklopedi Maddesi" etiketine düşüyor → 25.
 *   Ç.1 (yüz sayfadan fazla kitap çevirisi 200) ile Ç.2 (yüz sayfa ve altı
 *       100) tek "Çeviri Kitap" etiketine düşüyor → 100.
 *   F bölümünde editör yardımcılığı/yayın kurulu üyeliği beş dergi türü için
 *       75/50/40/30/20, hakemlik 20/10/8/6/5; kayıtta "Yayın Kurulu Üyeliği"
 *       ve "Hakemlik" tek etiket → en düşükten (20 ve 5).
 *   H.3 (uluslararası marka/tasarım/faydalı model 250) ile H.4 (ulusal 100)
 *       tek etiket kümesine düşüyor → 100.
 *   I.6 (uluslararası burs 50) ile I.7 (ulusal 25) tek "Burs" etiketi → 25.
 *   L.4 (TÜBİTAK 300/150/50) ile L.5 (TÜBİTAK hızlı destek 250/125/50) tek
 *       "TÜBİTAK" etiketi → L.5 değerleri.
 *   K.6 (ABD Başkanlığı 10) ile K.8 (Koordinatörlük, Merkez Müdürlüğü 40)
 *       "Anabilim Dalı Başkanı / Koordinatörlük" etiketini paylaşıyor → 10.
 *       Merkez Müdürlüğü ayrı etiketi olduğu için 40'tan sayılıyor.
 *   N bölümünde davetli konuşmacı uluslararası 200 / ulusal 100; kayıt ayrım
 *       taşımadığı için 100'den.
 *   D bölümünün yarışma satırları (19-22: derece 60/40, mansiyon 30/20) tek
 *       "Yarışma Derecesi / Mansiyon" etiketine düşüyor → 20.
 *
 * ── GİRİLMEYEN KALEMLER (kaynak sözlüğünde karşılığı yok) ──
 *   A.7 "diğer dergilerde yayımlanmış" (30) — hakemsiz dergi etiketi yok.
 *   C.4 ve C.8 bilimsel olmayan kitap yazarlığı (25 / 10).
 *   Ç.4 makale çevirisi (25), Ç.5-Ç.7 bilimsel olmayan çeviriler (5/3/2).
 *   G BÖLÜMÜNÜN TAMAMI — basılmış bilimsel rapor (uluslararası 30, ulusal 20);
 *       kayıtta "bilimsel rapor" kalemi yok.
 *   H.5 lisanslama çarpanı ("puanı 5 ile çarpılır") — motorda çarpan yok.
 *   F.2 diğer uluslararası indeks editörlüğü (75) ve F.8-F.9 sempozyum
 *       hakemliği (20/10).
 *   K.9 Erasmus vb. ile yurtdışında geçici öğretim üyeliği (10).
 *   L.3 uluslararası özel sektör projeleri (300/150/50) — "Özel Sektör / STK"
 *       etiketi ulusal satıra (L.8) bağlandı; L.9-L.10 proje hakemliği ve
 *       danışmanlığı (100/50/50/25).
 *   N bölümünün panelist, oturum başkanı, kongre başkanı, düzenleme kurulu ve
 *       bilim kurulu satırlarının TAMAMI (300'e kadar).
 *   D.19-D.21 yarışma derecelerinin uluslararası/ulusal ayrımı.
 *   Rektörlük, rektör yardımcılığı, senato üyeliği ve komisyon üyeliği:
 *       K bölümünde satırları yok.
 *   "Uzman" proje rolü: motorda böyle bir rol yok, danışman satırından sayılır.
 *
 * ── YAZAR ÇARPANI (MADDE 10) ──
 * Tablo yazar sayısı × sıra matrisi; sorumlu yazar (corresponding author)
 * 1. isimle aynı sayılıyor, bu yüzden `baslica` ile `ilk` aynı satırı alıyor.
 * Matris YAYIN, SANAT VE SPOR ETKİNLİKLERİ için yazılmış (madde başlığı);
 * atıf, proje, tez yönetimi, editörlük, ödül, ders ve idari görev dışarıda —
 * bunların satırları zaten kişi başına. PATENT bölümü için yönerge bir
 * paylaşım kuralı yazmıyor; matris yine de uygulandı, çünkü uygulamamak
 * çok kişili patentte puanı FAZLA gösterirdi (§0).
 *
 * Yönerge: yonerge/kirklareli.php
 */
$TAM = ['ozgun_makale'];
$YARIM = ['derleme', 'kisa_makale', 'vaka_teknik_not'];
$WOS = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];

$maddeler = [
    // ══ A. MAKALELER ══
    'A-1' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamında taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $TAM, 'puan' => 200],
    'A-2' => ['baslik' => 'ESCI kapsamında taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI'], 'turler' => $TAM, 'puan' => 150],
    'A-4' => ['baslik' => 'Diğer indekslerce taranan uluslararası hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Scopus'], 'turler' => $TAM, 'puan' => 70],
    'A-5' => ['baslik' => 'TÜBİTAK-ULAKBİM TR Dizin kapsamındaki ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TAM, 'puan' => 70],
    'A-6' => ['baslik' => 'Hakemli ulusal bilimsel dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => 50],
    // A.8: yukarıdaki dergilerde derleme, teknik not, editöre mektup, tartışma,
    // vaka takdimi, özet ve kısa bildiri türü yayınlar için puanların YARISI.
    'A-8a' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergide derleme, teknik not, editöre mektup, tartışma, vaka takdimi ya da özet', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $YARIM, 'puan' => 100],
    'A-8b' => ['baslik' => 'ESCI kapsamındaki dergide derleme, teknik not, editöre mektup, tartışma, vaka takdimi ya da özet', 'kategori' => 'makale', 'kaynaklar' => ['ESCI'], 'turler' => $YARIM, 'puan' => 75],
    'A-8d' => ['baslik' => 'Diğer indekslerce taranan uluslararası hakemli dergide derleme, teknik not, editöre mektup, tartışma, vaka takdimi ya da özet', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Scopus'], 'turler' => $YARIM, 'puan' => 35],
    'A-8e' => ['baslik' => 'TR Dizin kapsamındaki dergide derleme, teknik not, editöre mektup, tartışma, vaka takdimi ya da özet', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $YARIM, 'puan' => 35],
    'A-8f' => ['baslik' => 'Hakemli ulusal bilimsel dergide derleme, teknik not, editöre mektup, tartışma, vaka takdimi ya da özet', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $YARIM, 'puan' => 25],

    // ══ B. BİLDİRİLER ══
    'B-1' => ['baslik' => 'Uluslararası sempozyum, kongre ya da konferansta sözlü sunulmuş ve tam metni yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 40],
    'B-4' => ['baslik' => 'Uluslararası sempozyum, kongre ya da konferansta özet olarak ya da poster olarak sunulmuş bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 15],
    'B-5' => ['baslik' => 'Ulusal sempozyum, kongre ya da konferansta sözlü sunulmuş ve tam metni yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 20],
    'B-7' => ['baslik' => 'Ulusal sempozyum, kongre ya da konferansta özet olarak ya da poster olarak sunulmuş bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 10],

    // ══ C. KİTAPLAR ══
    'C-1' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış bilimsel ya da mesleki kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 300],
    'C-2' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 100],
    'C-5' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış bilimsel ya da mesleki kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 150],
    'C-6' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 50],
    'C-7' => ['baslik' => 'Yayımlanmış ansiklopedi konu ya da madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 25],
    'C-9' => ['baslik' => 'Kitap formatında basılmış ders notu, yardımcı ders notu ya da laboratuvar föyü yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 30],

    // ══ Ç. ÇEVİRİLER ══
    'CE-2' => ['baslik' => 'Bilimsel kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 100],
    'CE-3' => ['baslik' => 'Bilimsel kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 50],

    // ══ D. SANAT VE TASARIM ETKİNLİKLERİ ══
    'D-1' => ['baslik' => 'Özgün sanat eseri, tasarım ya da yorum çalışmasının yurt dışında satın alınması, yayın organlarında yer alması ya da tasarım projesinin dış ülkelerde uygulanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)'], 'puan' => 120],
    'D-2' => ['baslik' => 'Özgün sanat eseri, tasarım ya da yorum çalışmasının yurt içinde satın alınması, yayın organlarında yer alması ya da tasarım projesinin uygulanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Uygulama Projesi — Müellif'], 'puan' => 100],
    'D-3' => ['baslik' => 'Özgün sanat eseri, tasarım ya da yorum çalışmasıyla uluslararası jürili karma sanat ve tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Karma Sergi (Uluslararası)'], 'puan' => 80],
    'D-4' => ['baslik' => 'Özgün sanat eseri, tasarım ya da yorum çalışmasıyla ulusal jürili karma sanat ve tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 45],
    'D-5' => ['baslik' => 'Özgün sanat eseri, tasarım ya da yorum çalışmasıyla uluslararası kişisel etkinlikte bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)'], 'puan' => 120],
    'D-6' => ['baslik' => 'Özgün sanat eseri, tasarım ya da yorum çalışmasıyla ulusal kişisel etkinlikte bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 80],
    'D-7' => ['baslik' => 'Özgün sanat eseri, tasarım ya da yorum çalışmasıyla uluslararası karma ya da grup sanat ve tasarım etkinliğine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Jürisiz)'], 'puan' => 45],
    'D-8' => ['baslik' => 'Özgün sanat eseri, tasarım ya da yorum çalışmasıyla ulusal karma ya da grup sanat ve tasarım etkinliğine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Jürisiz, Ulusal)', 'Özgün Eser / Beste / Tasarım'], 'puan' => 30],
    'D-9' => ['baslik' => 'Uluslararası ölçekte sempozyum, festival, çalıştay, bienal ya da trienal gibi sanat ve tasarım etkinliğine eserinizle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 50],
    'D-10' => ['baslik' => 'Ulusal ölçekte sempozyum, festival, çalıştay, bienal ya da trienal gibi sanat ve tasarım etkinliğine eserinizle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 40],
    'D-15' => ['baslik' => 'Uluslararası yarışma jürisinde görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], 'puan' => 40],
    'D-16' => ['baslik' => 'Ulusal yarışma jürisinde görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 20],
    'D-22' => ['baslik' => 'Şehir planlama, mimari, kentsel, peyzaj, iç mimari ya da endüstri ürünleri tasarımı yarışmasında derece veya mansiyon kazanmak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 20],

    // ══ E. SAHNE SANATLARI, MÜZİK VE MÜZİKOLOJİ ALANI ETKİNLİKLERİ ══
    'E-4' => ['baslik' => 'Sahne eserinizin (tiyatro, opera, bale, oratoryo, kantat) uygulanmış olması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera/Bale Kompozisyonu', 'Orkestralı Sahne Eseri'], 'puan' => 100],
    'E-6' => ['baslik' => 'Senfonik eserinizin (senfoni, senfonik şiir, konçerto, suit) uygulanmış olması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir'], 'puan' => 75],
    'E-8' => ['baslik' => 'Küçük ölçekli orkestra eserinizin uygulanmış olması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Küçük Ölçekli Orkestra Eseri'], 'puan' => 50],
    'E-9' => ['baslik' => 'Oda müziği, koro, solo ya da eğitim müziği eseri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Eğitim Müziği Albümü', 'Sahne/Ekran Müziği'], 'puan' => 50],
    'E-10' => ['baslik' => 'Koro ve orkestra için düzenleme', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi'], 'puan' => 35],
    'E-11' => ['baslik' => 'Yurt dışında bireysel sanat etkinliği: orkestra ya da koro şefliği, orkestra eşliğinde solistlik, resital, opera, bale; dramatik eserde reji ya da başrol', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra Şefliği (Uluslararası)', 'Koro Şefliği (Uluslararası)', 'Opera Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Uluslararası)', 'Solistlik (Uluslararası)', 'Resital (Uluslararası)', 'Şan Resitali (Uluslararası)', 'Opera Birinci Rol (Uluslararası)', 'Bale Başrol (Uluslararası)', 'Rejisörlük (Uluslararası)'], 'puan' => 75],
    'E-12' => ['baslik' => 'Bireysel sanat etkinliği: orkestra ya da koro şefliği, solistlik, resital, opera, bale; dramatik eserde reji, oyunculuk, dramaturgi ya da sahne tasarımı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra Şefliği (Ulusal)', 'Koro Şefliği (Ulusal)', 'Opera Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Ulusal)', 'Solistlik (Ulusal)', 'Resital (Ulusal)', 'Şan Resitali (Ulusal)', 'Opera Birinci Rol (Ulusal)', 'Bale Başrol (Ulusal)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Opera İkinci Rol (Uluslararası)', 'Opera İkinci Rol (Ulusal)', 'Oratoryo/Kantat Solistliği (Uluslararası)', 'Oratoryo/Kantat Solistliği (Ulusal)', 'Bale Solist Rol (Uluslararası)', 'Bale Solist Rol (Ulusal)', 'Rejisör Yardımcılığı (Uluslararası)', 'Rejisör Yardımcılığı (Ulusal)', 'Rejisör Yardımcılığı (Konservatuvar)', 'Sahne Tasarımı (Dekor, Kostüm, Işık)'], 'puan' => 40],
    'E-13' => ['baslik' => 'Topluluk ya da grup üyesi veya eşlikçi olarak yurt dışındaki sanat etkinliğinde yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Uluslararası)', 'Corps de Ballet (Uluslararası)', 'Başkemancılık (Uluslararası)', 'Grup Şefliği (Uluslararası)'], 'puan' => 25],
    'E-14' => ['baslik' => 'Topluluk ya da grup üyesi veya eşlikçi olarak yurt içindeki sanat etkinliğinde yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Ulusal)', 'Corps de Ballet (Ulusal)', 'Başkemancılık (Ulusal)', 'Grup Şefliği (Ulusal)', 'Orkestra / Koro Üyeliği'], 'puan' => 20],
    'E-16' => ['baslik' => 'Sanatsal çalışmanızla radyo, televizyon, CD ya da DVD kayıt ortamında yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bandrollü Kayıt (CD/DVD)'], 'puan' => 30],
    'E-17' => ['baslik' => 'Bireysel ses ya da görüntü yayımı yapmak (kaset, CD, albüm çıkarmak)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Albüm / Konser Kaydı'], 'puan' => 80],
    'E-18' => ['baslik' => 'Karma ses ya da görüntü yayımı yapmak (kaset, CD, albüm çıkarmak)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Albüm / CD-DVD Katkısı'], 'puan' => 45],
    'E-20' => ['baslik' => 'Sahne ya da görsel sanatlarda yönetmen, sanat yönetmeni, koreograf veya performans sanatçısı olarak etkinlikte bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Yönetmenlik (Sahne/Ekran)', 'Koreografi', 'Tüm Perde Koreograflığı (Uluslararası)', 'Tüm Perde Koreograflığı (Ulusal)', 'Bölüm Koreograflığı (Uluslararası)', 'Bölüm Koreograflığı (Ulusal)', 'Bale/Dans Koreograflığı (Uluslararası)', 'Bale/Dans Koreograflığı (Ulusal)', 'Dansçı / Performans İcracısı (Uluslararası)', 'Dansçı / Performans İcracısı (Ulusal)', 'Sahneleme/Repetitörlük — Tüm Perde (Uluslararası)', 'Sahneleme/Repetitörlük — Tüm Perde (Ulusal)', 'Sahneleme/Repetitörlük — Bölüm (Uluslararası)', 'Sahneleme/Repetitörlük — Bölüm (Ulusal)'], 'puan' => 100],

    // ══ F. EDİTÖR VE HAKEMLİKLER ══
    'F-1a' => ['baslik' => 'SCI, SCI-Expanded, ESCI, SSCI ya da AHCI kapsamındaki dergide editörlük (her yıl için)', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI Dergi'], 'puan' => 150],
    'F-4a' => ['baslik' => 'TÜBİTAK-ULAKBİM TR Dizin kapsamındaki dergide editörlük (her yıl için)', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 50],
    'F-5a' => ['baslik' => 'Ulusal hakemli dergide editörlük (her yıl için)', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 30],
    'F-5b' => ['baslik' => 'Dergide editör yardımcılığı, yayın kurulu ya da danışma kurulu üyeliği (her yıl için)', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 20],
    'F-5c' => ['baslik' => 'Dergide hakemlik (her yıl için)', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 5],
    'F-6' => ['baslik' => 'Uluslararası yayımlanan kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 100],
    'F-7' => ['baslik' => 'Ulusal yayımlanan kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 50],

    // ══ H. PATENTLER ══
    'H-1' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 500],
    'H-2' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 250],
    'H-4' => ['baslik' => 'Marka, endüstriyel tasarım ya da faydalı model tescili', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 100],

    // ══ I. ÖDÜLLER VE BURSLAR ══
    'I-1' => ['baslik' => 'Uluslararası bilim, sanat ya da tasarım ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 200],
    'I-2' => ['baslik' => 'Ulusal bilim, sanat ya da tasarım ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'YÖK Ödülü'], 'puan' => 100],
    'I-3' => ['baslik' => 'TÜBİTAK ya da TÜBA Bilim Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü'], 'puan' => 150],
    'I-4' => ['baslik' => 'TÜBİTAK ya da TÜBA Teşvik Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 75],
    'I-7' => ['baslik' => 'Bilimsel araştırma için kurum ve kuruluşlardan alınan üç ay ve üzeri süreli burs', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 25],

    // ══ İ. ATIFLAR ══
    'AT-1' => ['baslik' => 'SCI, SCI-Expanded, ESCI, SSCI ya da AHCI kapsamındaki dergilerde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['SCIE/SSCI/AHCI', 'ESCI'], 'puan' => 5],
    'AT-3' => ['baslik' => 'Diğer bilimsel ve sanatsal hakemli dergilerde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent', 'Scopus'], 'puan' => 2],
    'AT-4' => ['baslik' => 'TÜBİTAK-ULAKBİM TR Dizin kapsamındaki dergilerde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
    'AT-5' => ['baslik' => 'Kitaplarda eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 5],

    // ══ J. TEZ YÖNETİMİ ══
    'J-1' => ['baslik' => 'Yönetiminizde tamamlanan doktora, tıpta uzmanlık ya da sanatta yeterlik tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 150],
    'J-2' => ['baslik' => 'Yönetiminizde tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 75],
    'J-3a' => ['baslik' => 'İkinci ya da eş danışman olarak görev aldığınız tamamlanmış doktora, tıpta uzmanlık ya da sanatta yeterlik tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 75],
    'J-3b' => ['baslik' => 'İkinci ya da eş danışman olarak görev aldığınız tamamlanmış yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 37],

    // ══ K. ÖĞRETİM VE YÖNETİME KATKI ══
    'K-1' => ['baslik' => 'Lisansüstü düzeyde ders vermek (her ders için)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 5],
    'K-2' => ['baslik' => 'Lisans ya da ön lisans düzeyinde ders vermek (her ders için)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 3],
    'K-3' => ['baslik' => 'Müdürlük ya da müdür vekilliği (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü'], 'puan' => 80],
    'K-4' => ['baslik' => 'Müdür yardımcılığı ya da dekan yardımcılığı (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 40],
    'K-5' => ['baslik' => 'Bölüm başkanlığı (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 20],
    'K-6' => ['baslik' => 'Anabilim dalı başkanlığı (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 10],
    'K-7' => ['baslik' => 'Bölüm başkan yardımcılığı (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı'], 'puan' => 10],
    'K-8' => ['baslik' => 'Merkez müdürlüğü ya da benzeri görevler (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 40],

    // ══ L. ARAŞTIRMA PROJELERİ (tamamlandığı onaylanmış projeler) ══
    'L-1y' => ['baslik' => 'Uluslararası destekli projede (Dünya Bankası, Avrupa Birliği, OECD, Birleşmiş Milletler, UNESCO) yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 500],
    'L-1a' => ['baslik' => 'Uluslararası destekli projede (Dünya Bankası, Avrupa Birliği, OECD, Birleşmiş Milletler, UNESCO) araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci'], 'puan' => 250],
    'L-1d' => ['baslik' => 'Uluslararası destekli projede (Dünya Bankası, Avrupa Birliği, OECD, Birleşmiş Milletler, UNESCO) danışman', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 100],
    'L-2y' => ['baslik' => 'Uluslararası diğer resmi kurum ve kuruluşlarca desteklenen projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 400],
    'L-2a' => ['baslik' => 'Uluslararası diğer resmi kurum ve kuruluşlarca desteklenen projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci'], 'puan' => 200],
    'L-2d' => ['baslik' => 'Uluslararası diğer resmi kurum ve kuruluşlarca desteklenen projede danışman', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 60],
    'L-5y' => ['baslik' => 'TÜBİTAK ya da bakanlık destekli projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 250],
    'L-5a' => ['baslik' => 'TÜBİTAK ya da bakanlık destekli projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci'], 'puan' => 125],
    'L-5d' => ['baslik' => 'TÜBİTAK ya da bakanlık destekli projede danışman', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 50],
    'L-6y' => ['baslik' => 'Üniversitenin bilimsel araştırma projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 100],
    'L-6a' => ['baslik' => 'Üniversitenin bilimsel araştırma projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci'], 'puan' => 50],
    'L-6d' => ['baslik' => 'Üniversitenin bilimsel araştırma projesinde danışman', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 20],
    'L-7y' => ['baslik' => 'Ulusal diğer kamu kurum ve kuruluşlarınca desteklenen projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 100],
    'L-7a' => ['baslik' => 'Ulusal diğer kamu kurum ve kuruluşlarınca desteklenen projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['arastirmaci'], 'puan' => 50],
    'L-7d' => ['baslik' => 'Ulusal diğer kamu kurum ve kuruluşlarınca desteklenen projede danışman', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 20],
    'L-8y' => ['baslik' => 'Özel sektörce desteklenen projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 70],
    'L-8a' => ['baslik' => 'Özel sektörce desteklenen projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci'], 'puan' => 35],
    'L-8d' => ['baslik' => 'Özel sektörce desteklenen projede danışman', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 10],

    // ══ M. PROTOKOL İLE YAPILAN SOSYAL SORUMLULUK PROJELERİ ══
    'M-2b' => ['baslik' => 'Protokol ile yapılan sosyal sorumluluk projesinde görev almak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi', 'Kamu/STK Danışmanlığı', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 20],

    // ══ N. DİĞER BİLİMSEL ETKİNLİKLER ══
    'N-2a' => ['baslik' => 'Sempozyum, kongre ya da konferansta davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 100],
    'N-1c' => ['baslik' => 'Bilimsel toplantıda oturum başkanlığı (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Uluslararası)'], 'puan' => 100],
    'N-2c' => ['baslik' => 'Bilimsel toplantıda oturum başkanlığı (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Ulusal)'], 'puan' => 40],
    'N-1ç' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 300],
    'N-2ç' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Ulusal)'], 'puan' => 200],
    'N-1e' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 50],
    'N-2e' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 40],
];

$A = ['A-1', 'A-2', 'A-4', 'A-5', 'A-6', 'A-8a', 'A-8b', 'A-8d', 'A-8e', 'A-8f'];
$B = ['B-1', 'B-4', 'B-5', 'B-7'];
// MADDE 8/1-c "B bendi (sadece sözlü bildiriler)": özet ve poster satırları
// tek etikete düştüğü için sözlü ayrımı YALNIZCA tam metin satırlarında
// güvenli; §0 gereği küme B-1 ve B-5 ile sınırlandı.
$B_SOZLU = ['B-1', 'B-5'];
$C = ['C-1', 'C-2', 'C-5', 'C-6', 'C-7', 'C-9'];
// MADDE 8/1-c "C bendi (1, 2, 3, 4, 5 ve 6. maddeler)": ders notu (C.9) ile
// bilimsel olmayan kitaplar (C.4, C.8) dışarıda.
$C_1_6 = ['C-1', 'C-2', 'C-5', 'C-6', 'C-7'];
$CE = ['CE-2', 'CE-3'];
$D = ['D-1', 'D-2', 'D-3', 'D-4', 'D-5', 'D-6', 'D-7', 'D-8', 'D-9', 'D-10', 'D-15', 'D-16', 'D-22'];
$E = ['E-4', 'E-6', 'E-8', 'E-9', 'E-10', 'E-11', 'E-12', 'E-13', 'E-14', 'E-16', 'E-17', 'E-18', 'E-20'];
$L_DIS = ['L-1y', 'L-1a', 'L-1d', 'L-2y', 'L-2a', 'L-2d'];

return [
    'kapsam_notu' => 'Puanlar Kırklareli Üniversitesi Öğretim Üyeliğine Yükseltilme ve Atanma '
        .'Kriterlerinin EK-I Aday Etkinlik Puanlama Tablosundan (08/11/2018 tarihli 91 sayılı '
        .'Senato kararı eki). Kaynak PDF taranmış; 400 dpi görüntüden OCR ile okundu, puan '
        .'sütunu ayrıca gözle doğrulandı. ÇOK YAZARLI ESERDE PUAN MADDE 10\'un yazar sayısı × '
        .'sıra matrisine göre bölünüyor (tek yazar %100; iki yazarda 1. isim %100, 2. isim %90; '
        .'altı ve üzeri yazarda %75\'ten %25\'e). Sorumlu yazar 1. isimle aynı sayılıyor. '
        .'Yazar listesini boş bırakırsanız en düşük satır uygulanır. Atıf, proje, tez yönetimi, '
        .'editörlük, ödül, ders ve idari görev kalemlerinde bölme yok. '
        .'PUANINIZ ŞU KALEMLERDE OLDUĞUNDAN DÜŞÜK GÖRÜNÜR: basılmış bilimsel raporlar '
        .'bölümünün tamamı (G, 30/20), bilimsel olmayan kitap ve çeviriler, makale çevirisi, '
        .'hakemsiz dergi yazıları, sempozyum hakemliği, proje hakemliği ve panelistlik, '
        .'Erasmus ile yurt dışı geçici öğretim üyeliği, rektörlük ve komisyon üyeliği '
        .'kayıtta karşılıksız kaldı. N bölümünün panelist, oturum başkanı, kongre başkanı, '
        .'düzenleme ve bilim kurulu satırları (300 puana kadar) da girilmedi. Aynı etikete '
        .'düşen satırlarda daima düşüğü sayılıyor: uluslararası bildiri özeti poster '
        .'değerinden (15), yüz sayfadan uzun kitap çevirisi kısa çeviri değerinden (100), '
        .'uluslararası ansiklopedi maddesi ulusal değerinden (25), editör yardımcılığı ve '
        .'hakemlik en düşük dergi türünden (20 ve 5), uluslararası marka ve faydalı model '
        .'tescili ulusal değerinden (100), uluslararası burs ulusal değerinden (25), '
        .'TÜBİTAK projeleri hızlı destek değerinden. '
        .'PUANINIZ ŞU KALEMDE OLDUĞUNDAN YÜKSEK GÖRÜNEBİLİR: Scopus dergilerindeki '
        .'makaleleriniz ESCI ile aynı etikete düştüğü için ESCI değerinden (150) sayılıyor. '
        .'Yönergenin "her dönem en fazla 6 ders" ve "her yıl en fazla 10 hakemlik" '
        .'sınırları dönem ve yıl bazlı olduğu için uygulanmıyor; bu kalemlerde de puan '
        .'yüksek çıkabilir.',

    'yazar_katsayisi' => [
        'haric' => ['atif', 'proje', 'editorluk', 'tez_danismanligi', 'egitim_ogretim',
            'odul', 'idari_gorev', 'toplumsal_katki', 'diger'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 1.00, 3 => 0.90, 4 => 0.85, 5 => 0.80], 'sonrasi' => 0.75],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 1.00, 3 => 0.90, 4 => 0.85, 5 => 0.80], 'sonrasi' => 0.75],
            'yazar_2' => ['kademeler' => [2 => 0.90, 3 => 0.80, 4 => 0.75, 5 => 0.70], 'sonrasi' => 0.65],
            'yazar_3' => ['kademeler' => [3 => 0.70, 4 => 0.65, 5 => 0.60], 'sonrasi' => 0.55],
            'yazar_4' => ['kademeler' => [4 => 0.55, 5 => 0.50], 'sonrasi' => 0.45],
            'yazar_5' => ['kademeler' => [5 => 0.40], 'sonrasi' => 0.35],
            'yazar_6' => ['sonrasi' => 0.25],
            'ortak' => ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.70, 4 => 0.55, 5 => 0.40], 'sonrasi' => 0.25],
        ],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        'TUM' => array_keys($maddeler),
        'A' => $A,
        'B' => $B,
        'B-SOZLU' => $B_SOZLU,
        'C' => $C,
        'C-1-6' => $C_1_6,
        'CE' => $CE,
        'D' => $D,
        'E' => $E,
        // MADDE 8/1-c'nin yayın kümesi: A bendi + B bendinin sözlü bildirileri
        // + C bendinin 1-6. maddeleri.
        'DR-YAYIN' => array_merge($A, $B_SOZLU, $C_1_6),
        // MADDE 6/1-c-2'nin sanat kümesi: A, B, C, Ç, D ve E bentleri.
        'SANAT-CALISMA' => array_merge($A, $B, $C, $CE, $D, $E),
        // MADDE 8/1-c'nin ikinci kolu: kabul edilmiş DIŞ KAYNAKLI proje.
        'DIS-PROJE' => $L_DIS,
    ],
];
