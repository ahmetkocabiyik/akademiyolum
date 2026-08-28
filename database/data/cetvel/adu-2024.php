<?php

/**
 * AYDIN ADNAN MENDERES ÜNİVERSİTESİ — Ek.1 Akademik Değerlendirme Puan
 * Tablosu
 * Kaynak: pdf/17634002431.Aydın Adnan Menderes Üniversitesi.pdf
 *
 * Madde kodları tablonun kendi kodlaması (A1.1, B2.3, D7.2, F2.1 …); satır
 * içindeki numaralı kalemler için açılan son basamak bize ait (A1.1.1,
 * B2.1 gibi) ve tez ile projelerde rol ayrımı için kullanılıyor.
 *
 * ── DEVAM EDEN PROJELERE YARIM PUAN (§0) ──
 * B bölümünün başlığı "devam eden projelere puanın yarısı verilir" diyor.
 * Faaliyet kaydı projenin tamamlanıp tamamlanmadığını taşımadığı için
 * bütün proje satırlarına YARIM puan yazıldı: uluslararası yürütücülük
 * 100 yerine 50, ulusal yürütücülük 50 yerine 25 gibi. Aynı gerekçeyle tez
 * yöneticiliğinde de "devam eden" değerleri girildi (doktora 40 yerine 20,
 * yüksek lisans 20 yerine 10); ikinci danışmanlık bunların yarısını alıyor.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   Kitaplarda sayfa sayısı kayıtta yok: uluslararası kitap 250/200 → 200,
 *       ulusal kitap 125/100 → 100, ders kitabı 75/50 → 50.
 *   Çeviride yabancı dile (125/100) ile yabancı dilden (60/50) tek 'Çeviri
 *       Kitap' etiketine düşüyor → 50; bölüm çevirisi 40/20 → 20.
 *   Ansiklopedi maddesi uluslararası 20 ile ulusal 10 → 10.
 *   Atıfta bilimsel kitap 20/10 → 10; SCI dergisi (10), diğer uluslararası
 *       dergi (5) ve ulusal hakemli dergi (5) tek 'WoS / Scopus' ile
 *       'TR Dizin' etiketlerine dağılıyor → 5.
 *   Bildiride davetli konuşmacılık uluslararası tam metinde 60'tan ulusal
 *       yayımlanmamışta 25'e iniyor; tek 'Davetli Konuşmacı' etiketi için
 *       → 25. Uluslararası özet/poster 40 ile 30 → 30.
 *   Toplantı etkinliklerinin (D1) bütün kademeleri tek 'Diğer' etiketine
 *       düşüyor (60'tan 5'e) → 5. Hakemlik 40/20/20/5 → 5.
 *   Sanat ödüllerinin sekiz kademesi (100'den 20'ye) tek 'Yarışma Derecesi
 *       / Mansiyon' etiketine düşüyor → 20. Burslar 20/10 → 10.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   A1.3 (indekslere girmeyen diğer hakemli dergiler) ve A1.5 (diğer
 *       ulusal dergiler) — sözlükte hakemsiz dergi karşılığı yok.
 *   A1.3.4, A1.4.4 ve A1.5.4 (sanat dergilerinde katalog yazısı, sanatçı
 *       yorumu ve benzeri kuramsal yazılar) — sözlükte karşılıksız.
 *   C2 DERS VERME bölümünün tamamı — puanlar DERS SAATİ başına veriliyor
 *       (0,25 ve 0,5 puan/saat), faaliyet kaydı ise ders saatini değil
 *       yarıyıl sayısını taşıyor. Ek 3'ün "C2'den şu kadar puan" koşulları
 *       bu yüzden yönergede `hesaplanamiyor` olarak duruyor.
 *   C3 (öğrenci danışmanlıkları), B1.3-B1.4 ve B2.7-B2.8 (arkeolojik kazı
 *       başkanlığı ve kazıda görev), D8 (yurt dışı deneyimi) ve F3
 *       (sportif etkinlikler) — sözlükte karşılıksız. F3'e bağlı Spor
 *       Bilimleri koşulları da `hesaplanamiyor`.
 *   A5.1.4 ve A5.2.4 (adayın adıyla anılan formül, şema, buluş) — atıf
 *       kaydından ayrılamıyor.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   A1 başlığının "uluslararası etki faktörü 1'den büyükse öngörülen puan
 *       etki faktörüyle ÇARPILIR" kuralı — kayıt derginin etki faktörünü
 *       taşımıyor, çarpan uygulanmadı; Q1 dergilerdeki makalelerin puanı
 *       bu yüzden olduğundan düşük görünür.
 *   A1.1.2'nin "davetli derlemeye %50 fazla puan" eki.
 *   "Aynı kitapta en fazla 2 bölüm", "aynı ansiklopedide en fazla 2 madde",
 *       "en fazla 2 makale çevirisi", D1'in "her yıl en çok 3 etkinlik" ve
 *       D5'in 100 puanlık tavanı gibi kayıt başına ya da yıl başına
 *       sınırlar.
 *   Madde 5(2): aynı çalışmadan mükerrer bildiri yapılması hâlinde en
 *       yüksek puanlının sayılması — motorun zaten yaptığı şey.
 *
 * Yönerge: yonerge/adu.php
 */
$OZGUN = ['ozgun_makale'];
$DERLEME = ['derleme'];
$KISA = ['kisa_makale'];
$VAKA = ['vaka_teknik_not'];
$WOS = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];
$DIGER_INDEKS = ['ESCI / Scopus', 'Diğer Uluslararası İndeks'];
$ULUSAL_DERGI = ['TR Dizin', 'Diğer Ulusal Hakemli'];
$ULUSLARARASI_FON = ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'];
$ULUSAL_FON = ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'];
$DOKTORA_TEZ = ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'];

$maddeler = [
    // ══ A1. MAKALELER ══
    'A1.1.1' => ['baslik' => 'SCI-Expanded, SSCI ya da A&HCI indekslerince taranan dergide yayımlanan tam metin özgün makale', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $OZGUN, 'puan' => 100],
    'A1.1.2' => ['baslik' => 'SCI-Expanded, SSCI ya da A&HCI indekslerince taranan dergide yayımlanan derleme', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $DERLEME, 'puan' => 60],
    'A1.1.3' => ['baslik' => 'SCI-Expanded, SSCI ya da A&HCI indekslerince taranan dergide yayımlanan kısa makale', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $KISA, 'puan' => 40],
    'A1.1.4' => ['baslik' => 'SCI-Expanded, SSCI ya da A&HCI indekslerince taranan dergide yayımlanan vaka takdimi, teknik not, editöre mektup, özet veya tartışma', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $VAKA, 'puan' => 20],
    'A1.2.1' => ['baslik' => 'SCI-Expanded, SSCI ve A&HCI dışındaki indeksler tarafından taranan dergide yayımlanan tam metin özgün makale', 'kategori' => 'makale', 'kaynaklar' => $DIGER_INDEKS, 'turler' => $OZGUN, 'puan' => 60],
    'A1.2.2' => ['baslik' => 'SCI-Expanded, SSCI ve A&HCI dışındaki indeksler tarafından taranan dergide yayımlanan derleme', 'kategori' => 'makale', 'kaynaklar' => $DIGER_INDEKS, 'turler' => $DERLEME, 'puan' => 40],
    'A1.2.3' => ['baslik' => 'SCI-Expanded, SSCI ve A&HCI dışındaki indeksler tarafından taranan dergide yayımlanan kısa makale', 'kategori' => 'makale', 'kaynaklar' => $DIGER_INDEKS, 'turler' => $KISA, 'puan' => 20],
    'A1.2.4' => ['baslik' => 'SCI-Expanded, SSCI ve A&HCI dışındaki indeksler tarafından taranan dergide yayımlanan vaka takdimi, teknik not, editöre mektup, özet veya tartışma', 'kategori' => 'makale', 'kaynaklar' => $DIGER_INDEKS, 'turler' => $VAKA, 'puan' => 10],
    'A1.4.1' => ['baslik' => 'Ulusal hakemli dergide yayımlanan tam metin özgün makale', 'kategori' => 'makale', 'kaynaklar' => $ULUSAL_DERGI, 'turler' => $OZGUN, 'puan' => 50],
    'A1.4.2' => ['baslik' => 'Ulusal hakemli dergide yayımlanan derleme', 'kategori' => 'makale', 'kaynaklar' => $ULUSAL_DERGI, 'turler' => $DERLEME, 'puan' => 20],
    'A1.4.3' => ['baslik' => 'Ulusal hakemli dergide yayımlanan vaka takdimi, teknik not, kısa makale, editöre mektup, özet veya tartışma', 'kategori' => 'makale', 'kaynaklar' => $ULUSAL_DERGI, 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 10],

    // ══ A2. BİLDİRİLER ══
    'A2.1.2' => ['baslik' => 'Uluslararası bilimsel ya da sanatsal toplantıda sunulan ve tam metni yayımlanan sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 50],
    'A2.2.3' => ['baslik' => 'Uluslararası bilimsel ya da sanatsal toplantıda sunulan ve özeti yayımlanan poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 30],
    'A2.4.2' => ['baslik' => 'Ulusal bilimsel ya da sanatsal toplantıda sunulan ve tam metni yayımlanan sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 30],
    'A2.5.3' => ['baslik' => 'Ulusal bilimsel ya da sanatsal toplantıda sunulan ve özeti yayımlanan poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 15],
    'A2.6.1' => ['baslik' => 'Bilimsel ya da sanatsal toplantıda davetli konuşmacı veya panelist olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 25],

    // ══ A3. KİTAPLAR ══
    'A3.1.1' => ['baslik' => 'Uluslararası yayınevi ya da kuruluşça basılmış kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 200],
    'A3.1.2' => ['baslik' => 'Uluslararası yayınevi ya da kuruluşça basılmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 100],
    'A3.2.1' => ['baslik' => 'Ulusal yayınevi ya da kuruluşça basılmış kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 100],
    'A3.2.2' => ['baslik' => 'Ulusal yayınevi ya da kuruluşça basılmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 50],
    'A3.2.3' => ['baslik' => 'Ansiklopedide madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 10],
    'A3.3.1' => ['baslik' => 'Ders kitabı ya da ders notu', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 50],

    // ══ A4. ÇEVİRMENLİK ══
    'A4.2.1' => ['baslik' => 'Kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 50],
    'A4.2.2' => ['baslik' => 'Kitapta bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 20],

    // ══ A5. ATIFLAR ══
    'A5.2.1' => ['baslik' => 'Bilimsel kitapta yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 10],
    'A5.2.2' => ['baslik' => 'Hakemli bilimsel dergilerde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'TR Dizin'], 'puan' => 5],
    'A5.2.3' => ['baslik' => 'Diğer bilimsel ve mesleki yayınlarda yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 2],

    // ══ B. ARAŞTIRMA PROJELERİ (devam eden değerleriyle) ══
    'B1.1' => ['baslik' => 'NATO, AB, COST, UN, NSF, UNESCO, Dünya Bankası ve benzeri kuruluşlarca desteklenen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => $ULUSLARARASI_FON, 'roller' => ['yurutucu'], 'puan' => 50],
    'B1.2' => ['baslik' => 'NATO, AB, COST, UN, NSF, UNESCO, Dünya Bankası ve benzeri kuruluşlarca desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => $ULUSLARARASI_FON, 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 25],
    'B2.1' => ['baslik' => 'TÜBİTAK, TÜBA, TTGV, KOSGEB ya da bakanlıklar gibi ulusal kuruluşlarca desteklenen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => $ULUSAL_FON, 'roller' => ['yurutucu'], 'puan' => 25],
    'B2.2' => ['baslik' => 'TÜBİTAK, TÜBA, TTGV, KOSGEB ya da bakanlıklar gibi ulusal kuruluşlarca desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => $ULUSAL_FON, 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 12],
    'B2.3' => ['baslik' => 'BAP tarafından desteklenen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 15],
    'B2.4' => ['baslik' => 'BAP tarafından desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 7],
    'B2.5' => ['baslik' => 'Yerel kuruluşlarca ya da özel sektörce desteklenen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 10],
    'B2.6' => ['baslik' => 'Yerel kuruluşlarca ya da özel sektörce desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 5],

    // ══ C1. TEZ YÖNETİCİLİĞİ (devam eden değerleriyle) ══
    'C1.2' => ['baslik' => 'Doktora, tıpta uzmanlık ya da sanatta yeterlik tezi yönetmek', 'kategori' => 'tez_danismanligi', 'kaynaklar' => $DOKTORA_TEZ, 'roller' => ['danisman'], 'puan' => 20],
    'C1.2.b' => ['baslik' => 'Doktora, tıpta uzmanlık ya da sanatta yeterlik tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => $DOKTORA_TEZ, 'roller' => ['es_danisman'], 'puan' => 10],
    'C1.4' => ['baslik' => 'Yüksek lisans tezi yönetmek', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'roller' => ['danisman'], 'puan' => 10],
    'C1.4.b' => ['baslik' => 'Yüksek lisans tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 5],

    // ══ C2. DERS VERME (yalnız yıllık görevler) ══
    'C2.3' => ['baslik' => 'Staj kurulu, ders kurulu başkanlığı ya da koordinatörlük (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük', 'Kurul / Komisyon Üyeliği', 'Bölüm Başkanı', 'Bölüm Başkan Yardımcısı', 'Dekan / Enstitü-YO Müdürü', 'Dekan Yrd. / Müdür Yrd.', 'Rektör', 'Rektör Yardımcısı', 'Senato / Üniversite Yönetim Kurulu Üyesi', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 5],

    // ══ D. DİĞER BİLİMSEL VE SANATSAL ETKİNLİKLER ══
    'D1.2.3' => ['baslik' => 'Sempozyum, kongre, panel, çalıştay ya da yaz okulu gibi etkinliklerde düzenleme kurulu, bilim kurulu, oturum başkanlığı veya katılım', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 5],
    'D3.2' => ['baslik' => 'Sanat eserinin koleksiyona girmesi ya da satın alınması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Satın Alınması (Yurt İçi)', 'Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Haber Olması (Uluslararası)', 'Eserin Haber Olması (Ulusal)'], 'puan' => 15],
    'D4.2.2' => ['baslik' => 'Bienal, trienal, fuar, festival gibi bilimsel ve tasarıma yönelik etkinliklerde küratörlük, proje tasarımcılığı ya da katılımcılık', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman', 'Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)'], 'puan' => 30],
    'D5.1' => ['baslik' => 'Uluslararası bilimsel, proje ya da sanat yarışmasında jüri üyeliği veya sanat kurullarında üyelik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], 'puan' => 15],
    'D5.2' => ['baslik' => 'Ulusal bilimsel, proje ya da sanat yarışmasında jüri üyeliği veya sanat kurullarında üyelik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 10],
    'D5.2.3' => ['baslik' => 'Kamu ve özel kurum ve kuruluşlar için hazırlanan fizibilite, deney, ÇED, uzmanlık, bilirkişi ve komisyon üyeliği', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı', 'Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 5],
    'D6.4' => ['baslik' => 'Bilimsel dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 5],
    'D7.1.1' => ['baslik' => 'Uluslararası bilimsel kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 100],
    'D7.1.2' => ['baslik' => 'Ulusal bilimsel kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 50],
    'D7.2.1' => ['baslik' => 'SCI-Expanded, SSCI ya da A&HCI kapsamındaki dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 75],
    'D7.2.3' => ['baslik' => 'Diğer uluslararası ya da ulusal hakemli bilimsel dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi', 'TR Dizin Dergi'], 'puan' => 40],
    'D7.2.4' => ['baslik' => 'Diğer bilimsel ve mesleki dergilerde editörlük ya da yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi', 'Yayın Kurulu Üyeliği'], 'puan' => 5],

    // ══ E. ÖDÜLLER, PATENTLER, BURSLAR ══
    'E1.1.1.1' => ['baslik' => 'Uluslararası bilimsel kuruluşlarca verilen bilim, hizmet veya teşvik ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 100],
    'E1.1.2.1' => ['baslik' => 'Ulusal bilimsel kuruluşlarca verilen bilim, hizmet veya teşvik ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 50],
    'E1.2.2.4' => ['baslik' => 'Sanat alanında derece, teşvik, onur ya da mansiyon ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 20],
    'E2.1' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 300],
    'E2.2' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 150],
    'E2.3' => ['baslik' => 'Faydalı model, endüstriyel tasarım ya da çeşit tescili', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 75],
    'E2.4' => ['baslik' => 'Tescil edilmiş bilimsel amaçlı yazılım ya da web sayfası tasarımı', 'kategori' => 'patent', 'kaynaklar' => ['Yazılım', 'Ticarileştirme'], 'puan' => 50],
    'E3.2' => ['baslik' => 'Bilimsel amaçlı ulusal ya da uluslararası burs', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 10],

    // ══ F1. SERGİ ETKİNLİKLERİ ══
    'F1.1.1' => ['baslik' => 'Uluslararası kişisel sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)'], 'puan' => 60],
    'F1.1.2' => ['baslik' => 'Uluslararası grup ya da yarışma sergisi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Karma Sergi (Uluslararası)'], 'puan' => 40],
    'F1.2.1' => ['baslik' => 'Ulusal kişisel sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 30],
    'F1.2.4' => ['baslik' => 'Ulusal grup, yarışma ya da diğer sergiler', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 15],

    // ══ F2. MÜZİK ETKİNLİKLERİ ══
    'F2.1.1' => ['baslik' => 'Uluslararası orkestra eşliğinde solistlik, resital ya da geleneksel Türk müziği alanında kişisel etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Solistlik (Uluslararası)', 'Resital (Uluslararası)', 'Şan Resitali (Uluslararası)', 'Oratoryo/Kantat Solistliği (Uluslararası)', 'Orkestra Şefliği (Uluslararası)', 'Koro Şefliği (Uluslararası)', 'Opera Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Uluslararası)', 'Opera Birinci Rol (Uluslararası)', 'Bale Başrol (Uluslararası)', 'Rejisörlük (Uluslararası)'], 'puan' => 60],
    'F2.1.6' => ['baslik' => 'Uluslararası oda müziği grup üyeliği, grup şefliği, tutti üyeliği ya da karma etkinliklerde icra', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Uluslararası)', 'Grup Şefliği (Uluslararası)', 'Başkemancılık (Uluslararası)', 'Corps de Ballet (Uluslararası)', 'Opera İkinci Rol (Uluslararası)', 'Bale Solist Rol (Uluslararası)', 'Dansçı / Performans İcracısı (Uluslararası)', 'Masterclass (Uluslararası)', 'Eğitici Konser Programı (Uluslararası)', 'Rejisör Yardımcılığı (Uluslararası)', 'Tüm Perde Koreograflığı (Uluslararası)', 'Bölüm Koreograflığı (Uluslararası)', 'Bale/Dans Koreograflığı (Uluslararası)', 'Sahneleme/Repetitörlük — Tüm Perde (Uluslararası)', 'Sahneleme/Repetitörlük — Bölüm (Uluslararası)'], 'puan' => 20],
    'F2.1.10' => ['baslik' => 'Bandrollü CD, DVD ve benzeri kayıt ortamlarında performans ya da özgün beste veya güfte', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)', 'Karma Albüm / CD-DVD Katkısı', 'Eğitim Müziği Albümü', 'Özgün Eser / Beste / Tasarım', 'Opera/Bale Kompozisyonu', 'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Orkestralı Sahne Eseri', 'Küçük Ölçekli Orkestra Eseri', 'Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Sahne/Ekran Müziği', 'Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi'], 'puan' => 15],
    'F2.2.2' => ['baslik' => 'Ulusal orkestra eşliğinde solistlik, resital ya da geleneksel Türk müziği alanında kişisel etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Solistlik (Ulusal)', 'Resital (Ulusal)', 'Şan Resitali (Ulusal)', 'Oratoryo/Kantat Solistliği (Ulusal)', 'Orkestra Şefliği (Ulusal)', 'Koro Şefliği (Ulusal)', 'Opera Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Ulusal)', 'Opera Birinci Rol (Ulusal)', 'Bale Başrol (Ulusal)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Yönetmenlik (Sahne/Ekran)', 'Sahne Tasarımı (Dekor, Kostüm, Işık)', 'Koreografi', 'Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'], 'puan' => 30],
    'F2.2.7' => ['baslik' => 'Ulusal oda müziği grup üyeliği, grup şefliği, tutti üyeliği ya da karma etkinliklerde icra', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Ulusal)', 'Orkestra / Koro Üyeliği', 'Grup Şefliği (Ulusal)', 'Başkemancılık (Ulusal)', 'Corps de Ballet (Ulusal)', 'Opera İkinci Rol (Ulusal)', 'Bale Solist Rol (Ulusal)', 'Dansçı / Performans İcracısı (Ulusal)', 'Masterclass (Ulusal)', 'Eğitici Konser Programı (Ulusal)', 'Müzikoloji Atölyesi', 'Eğitim Amaçlı Sanat Etkinliği', 'Rejisör Yardımcılığı (Ulusal)', 'Rejisör Yardımcılığı (Konservatuvar)', 'Tüm Perde Koreograflığı (Ulusal)', 'Bölüm Koreograflığı (Ulusal)', 'Bale/Dans Koreograflığı (Ulusal)', 'Sahneleme/Repetitörlük — Tüm Perde (Ulusal)', 'Sahneleme/Repetitörlük — Bölüm (Ulusal)'], 'puan' => 10],
];

$kodlar = fn (string $onek): array => array_values(array_filter(
    array_keys($maddeler),
    fn (string $kod): bool => str_starts_with($kod, $onek)
));

return [
    'kapsam_notu' => 'Puanlar Aydın Adnan Menderes Üniversitesi Ek.1 Akademik Değerlendirme '
        .'Puan Tablosundan. Ortak çalışmalarda puan Ek.2\'ye göre bölünüyor: birinci isim '
        .'%100, ikinci %80, üçüncü %60, dördüncü ve sonrası %50. Atıflarda yazar sayısı dikkate '
        .'alınmıyor. Yazar listesini boş bırakırsanız çarpan uygulanmaz. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: A1 başlığının "uluslararası etki '
        .'faktörü 1\'den büyükse puan etki faktörüyle ÇARPILIR" kuralı uygulanmıyor — kayıt '
        .'derginin etki faktörünü taşımıyor, yüksek etkili dergilerdeki makaleleriniz taban '
        .'puandan sayılıyor. Projelerde ve tez yöneticiliğinde "devam eden" değerleri girildi '
        .'(kayıt projenin ya da tezin tamamlanıp tamamlanmadığını taşımıyor), yani tamamlanmış '
        .'projeleriniz gerçek puanının yarısından sayılıyor. DERS VERME (C2) bölümü puanlarını '
        .'ders SAATİ başına verdiği için hiç girilemedi; ders kayıtlarınız toplam puana katkı '
        .'vermiyor ve Ek 3\'ün "C2\'den şu kadar puan" koşulları hesaplanamıyor olarak '
        .'işaretli. Sportif etkinlikler (F3), öğrenci danışmanlıkları, arkeolojik kazılar ve '
        .'yurt dışı deneyimi de girilemedi. Kitaplarda sayfa sayısı, atıf ve bildiri '
        .'kademelerinde ise kaynak sözlüğü ayrım yapamadığı için en düşük satır uygulanıyor. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünür: "aynı kitapta en fazla iki bölüm", '
        .'"aynı ansiklopedide en fazla iki madde", D1\'in "her yıl en çok üç etkinlik" ve '
        .'D5\'in 100 puanlık tavanı gibi sınırlar uygulanamıyor.',

    // Ek.2 Ortak Çalışmalarda Puan Dağılımı: 1. isim %100, 2. isim %80,
    // 3. isim %60, 4. isim ve üzeri %50. Sıra yazar SAYISINA bağlı değil.
    // Atıflar Ek.1'in A başlığı uyarınca bölünmüyor.
    'yazar_katsayisi' => [
        'haric' => ['atif'],
        'roller' => [
            'tek' => ['sonrasi' => 1.00],
            'ilk' => ['sonrasi' => 1.00],
            'baslica' => ['sonrasi' => 1.00],
            'yazar_2' => ['sonrasi' => 0.80],
            'yazar_3' => ['sonrasi' => 0.60],
            'yazar_4' => ['sonrasi' => 0.50],
            'yazar_5' => ['sonrasi' => 0.50],
            'yazar_6' => ['sonrasi' => 0.50],
            'ortak' => ['sonrasi' => 0.50],
        ],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        'A1' => $kodlar('A1.'),
        'A1.1' => $kodlar('A1.1.'),
        'A1.1-A1.2' => [...$kodlar('A1.1.'), ...$kodlar('A1.2.')],
        // A1.3 (indekslere girmeyen hakemli dergiler) girilemediği için
        // "A1.1-A1.4" kümesi A1'in tamamıyla aynı.
        'A1.1-A1.4' => $kodlar('A1.'),
        'A1-A2' => [...$kodlar('A1.'), ...$kodlar('A2.')],
        'A1-A3' => [...$kodlar('A1.'), ...$kodlar('A2.'), ...$kodlar('A3.')],
        'A1-A4' => [...$kodlar('A1.'), ...$kodlar('A2.'), ...$kodlar('A3.'), ...$kodlar('A4.')],
        'A1-A5' => [...$kodlar('A1.'), ...$kodlar('A2.'), ...$kodlar('A3.'), ...$kodlar('A4.'),
            ...$kodlar('A5.')],
        'B' => [...$kodlar('B1.'), ...$kodlar('B2.')],
        'C1' => $kodlar('C1.'),
        'F1-F2' => [...$kodlar('F1.'), ...$kodlar('F2.')],
    ],

    'grup_tavanlari' => [],
];
