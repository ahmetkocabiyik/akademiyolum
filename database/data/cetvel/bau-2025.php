<?php

/**
 * BAHÇEŞEHİR ÜNİVERSİTESİ — Yükseltme ve Atamalarda Kullanılacak Puanlama
 * Sistemi (MADDE 5)
 * Kaynak: pdf/17537096942.bahcesehiruniversitesi.pdf (Senato 10.02.2025,
 * YÖK Genel Kurul onayı 30.01.2025)
 *
 * Madde kodları esasların kendi kriter kodları (A-1.1, C-3, H-3.5 …);
 * projelerde ve tez danışmanlığında rol ayrımı için açılan alt kodlar
 * bize ait.
 *
 * ── ALTI CETVEL VARYANTI ──
 * Eczacılık, Mühendislik ve Uygulamalı Bilimler tablolarında bazı
 * başlıklara KADRO BAŞINA DEĞİŞEN tavanlar konmuş ("(A-4) ve (A-5)
 * türünden en fazla 40 puan", "B'den en fazla 40 puan" gibi). Tavan
 * cetvel başına tanımlanabildiği için cetvelin altı varyantı üretildi;
 * tavansız tablolar temel varyanta bağlı.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   A-1 çeyreklikleri SCOPUS veri tabanına göre; sözlük çeyrekliği WoS
 *       üzerinden taşıdığı için SCIE/SSCI çeyreklikleriyle eşleştirildi.
 *       Çeyreklik taşımayan 'ESCI / Scopus' etiketi en düşük Scopus
 *       satırından (A-1.4, 8 puan) sayılıyor.
 *   Patentte A tipi ülke tescili (100) ile B tipi ülke tescili (30) tek
 *       'Uluslararası Patent' etiketine düşüyor → 30.
 *   Ödülde TÜBİTAK, TÜBA, TÜSEB ve YÖK bilim ödülü (80) ile teşvik ödülü
 *       (40) → 40. Yarışma dereceleri ve mansiyonlar (40/25/25/15) → 15.
 *   Editörlükte 'Yayın Kurulu Üyeliği' hem A-5.3 (Q1 editör listesi, 20)
 *       hem A-6.2 (TR Dizin editör yardımcılığı, 6) karşılığı → 6.
 *   Danışmanlıkta yurt dışı (15) ile yurt içi (8) → 8. Bildiride
 *       Scopus'ta taranan özet (6) ile uluslararası özet (2) → 2.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   A-4.2 (Scopus h-indeksi × 10 puan) — profil h-indeksini metrik olarak
 *       tutuyor, puan satırına çevrilemedi.
 *   A-4.3, A-4.4 ve A-4.5 (mahkeme kararlarında atıf) ve C-7 (kanun
 *       şerhlerinde yazarlık) — sözlükte karşılıksız.
 *   E-2 (tescil edilmek üzere başvurulmuş patentler) — tescilliden
 *       ayrılamıyor.
 *   Hakemlik, tez izleme ve jüri üyeliği, ders verme ve burs kalemleri —
 *       esasların puanlama sisteminde hiç yok.
 *   Q4 Scopus dergilerinde editörlük ve diğer hakemli dergilerde
 *       editörlük — tabloda karşılığı yok.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   "Bir kitapta birden fazla bölüm: (1 + k/c) × puan" formülü — kitaptaki
 *       toplam bölüm sayısı kayıtta yok.
 *   H-3'ün idari görevleri YIL BAŞINA puanlanıyor; kayıt görev süresini
 *       taşımadığı için kayıt başına puanlanıyor.
 *   MADDE 6(2)/a: "bir kategorideki makul bir zafiyet diğer kategorilerdeki
 *       bir mükemmeliyetle aşılabilir" — jüri takdirine bırakılmış.
 *   Tasarım projelerinin "en az üç çalışmadan oluşması" koşulu.
 *
 * Yönerge: yonerge/bau.php
 */
$TAM = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];
$A_PROJE = ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon', 'TÜBİTAK'];
$B_PROJE = ['TÜSEB', 'Diğer Kamu Kurumu', 'BAP (Üniversite)', 'Özel Sektör / STK',
    'Öğrenci Projesi (2209 vb.)'];

$maddeler = [
    // ══ A-1: SCOPUS VERİ TABANINDA ══
    'A-1.1' => ['baslik' => 'Scopus veri tabanında Q1 olarak taranan dergide yayımlanan tam metin makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'Scopus (Q1)'], 'turler' => $TAM, 'puan' => 24],
    'A-1.2' => ['baslik' => 'Scopus veri tabanında Q2 olarak taranan dergide yayımlanan tam metin makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)', 'Scopus (Q2)'], 'turler' => $TAM, 'puan' => 18],
    'A-1.3' => ['baslik' => 'Scopus veri tabanında Q3 olarak taranan dergide yayımlanan tam metin makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)', 'Scopus (Q3)'], 'turler' => $TAM, 'puan' => 12],
    'A-1.4' => ['baslik' => 'Scopus veri tabanında Q4 olarak taranan dergide yayımlanan tam metin makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'Scopus (Q4)'], 'turler' => $TAM, 'puan' => 8],
    'A-1.5' => ['baslik' => 'Scopus veri tabanındaki dergide yayımlanmış editöre mektup, teknik not, vaka analizi veya tartışma', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'Scopus'], 'turler' => $KISA, 'puan' => 5],

    // ══ A-2: SCI, SCI-EXPANDED, SSCI, AHCI ══
    'A-2.1' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI veri tabanında taranan dergide yayımlanan tam metin makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => $TAM, 'puan' => 24],
    'A-2.2' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI veri tabanındaki dergide yayımlanmış editöre mektup, teknik not, vaka analizi veya tartışma', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => $KISA, 'puan' => 5],

    // ══ A-3: DİĞER VERİ TABANLARI ══
    'A-3.1' => ['baslik' => 'ESCI, Scopus ya da TR Dizin\'de taranan dergide yayımlanan tam metin makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'TR Dizin'], 'turler' => $TAM, 'puan' => 8],
    'A-3.2' => ['baslik' => 'ESCI, Scopus ya da TR Dizin\'de yayımlanmış editöre mektup, teknik not, vaka analizi veya tartışma', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'TR Dizin'], 'turler' => $KISA, 'puan' => 4],
    'A-3.3' => ['baslik' => 'Diğer en az iki uluslararası ya da ulusal veri tabanında taranan hakemli dergide yayımlanan tam metin makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => 3],

    // ══ A-4: ATIFLAR ══
    'A-4.1' => ['baslik' => 'Scopus veri tabanında atıf raporundaki her bir atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 1],
    'A-4.6' => ['baslik' => 'Ulusal ve uluslararası patentlerde makalelere verilen atıflar', 'kategori' => 'atif', 'kaynaklar' => ['Patent'], 'puan' => 10],

    // ══ A-5 ve A-6: DERGİ EDİTÖRLÜĞÜ ══
    'A-5.1' => ['baslik' => 'Scopus veri tabanında Q1 olarak taranan dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'Scopus Dergi (Q1)'], 'puan' => 50],
    'A-5.4' => ['baslik' => 'Scopus veri tabanında Q2 olarak taranan dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q2)', 'Scopus Dergi (Q2)'], 'puan' => 40],
    'A-5.6' => ['baslik' => 'Scopus veri tabanında Q3 olarak taranan dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q3)', 'Scopus Dergi (Q3)'], 'puan' => 20],
    'A-6.1' => ['baslik' => 'TR Dizin\'de taranan dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 8],
    'A-6.2' => ['baslik' => 'Dergide editör yardımcılığı ya da editör listesinde olmak', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 6],

    // ══ B: KONFERANS BİLDİRİLERİ ══
    'B-1' => ['baslik' => 'Scopus\'ta taranan tam metinli bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 8],
    'B-3' => ['baslik' => 'Uluslararası konferansta tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin'], 'puan' => 4],
    'B-4' => ['baslik' => 'Uluslararası konferansta özeti basılmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 2],
    'B-5' => ['baslik' => 'Ulusal konferansta tam metinli bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 2],
    'B-6' => ['baslik' => 'Ulusal konferansta özeti basılmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster', 'Davetli Konuşmacı'], 'puan' => 1],

    // ══ C: KİTAP ══
    'C-1' => ['baslik' => 'Scopus\'ta taranan ya da BKCI kapsamındaki kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 40],
    'C-2' => ['baslik' => 'Scopus\'ta taranan ya da BKCI kapsamındaki kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 24],
    'C-3' => ['baslik' => 'Scopus\'ta taranan ya da BKCI kapsamındaki kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 16],
    'C-4' => ['baslik' => 'Diğer uluslararası ya da ulusal kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı', 'Tahkik (Tenkitli Metin)', 'Çeviri Kitap'], 'puan' => 10],
    'C-5' => ['baslik' => 'Diğer uluslararası ya da ulusal kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 6],
    'C-6' => ['baslik' => 'Diğer uluslararası ya da ulusal kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi', 'Çeviri Kitap Bölümü'], 'puan' => 4],

    // ══ D: ARAŞTIRMA PROJELERİ ══
    'D-1' => ['baslik' => 'A türü araştırma projesinde (AB çerçeve programları, TÜBİTAK, EUREKA, NATO, UN, NSF vb.) yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => $A_PROJE, 'roller' => ['yurutucu'], 'puan' => 30],
    'D-2' => ['baslik' => 'A türü araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => $A_PROJE, 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 8],
    'D-3' => ['baslik' => 'A türü araştırma projesinde danışman olmak', 'kategori' => 'proje', 'kaynaklar' => $A_PROJE, 'roller' => ['danisman'], 'puan' => 5],
    'D-4' => ['baslik' => 'B türü araştırma projesinde (ERASMUS+, TÜBİTAK 1002, TTGV, bakanlıklar, kalkınma ajansları, üniversite fonları) yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => $B_PROJE, 'roller' => ['yurutucu'], 'puan' => 20],
    'D-5' => ['baslik' => 'B türü araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => $B_PROJE, 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 5],
    'D-6' => ['baslik' => 'B türü araştırma projesinde danışman olmak', 'kategori' => 'proje', 'kaynaklar' => $B_PROJE, 'roller' => ['danisman'], 'puan' => 3],

    // ══ E: PATENTLER VE FAYDALI MODELLER ══
    'E-3' => ['baslik' => 'Yurt dışında tescil edilmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 30],
    'E-4' => ['baslik' => 'Yurt içinde tescil edilmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 40],
    'E-5' => ['baslik' => 'Faydalı model tescili', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 15],
    'E-6' => ['baslik' => 'Tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili', 'Yazılım'], 'puan' => 15],

    // ══ F: YARIŞMALAR VE ÖDÜLLER ══
    'F-1' => ['baslik' => 'Jürili uluslararası bilim ya da sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 80],
    'F-2.2' => ['baslik' => 'TÜBİTAK, TÜBA, TÜSEB ya da YÖK bilim veya teşvik ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'YÖK Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 40],
    'F-2.4' => ['baslik' => 'Sanatta ve bilimde verilen diğer ödüller', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'Burs'], 'puan' => 20],
    'F-3.4' => ['baslik' => 'Ulusal ya da uluslararası yarışmada derece veya mansiyon', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 15],
    'F-3.7' => ['baslik' => 'Uluslararası düzeyde gerçekleştirilen jürili yarışmalarda danışmanlık ya da jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], 'puan' => 25],
    'F-3.8' => ['baslik' => 'Ulusal düzeyde gerçekleştirilen jürili yarışmalarda danışmanlık ya da jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 20],

    // ══ G: SANATSAL ETKİNLİKLER ══
    'G-1.1' => ['baslik' => 'Özgün sanat eserinin yurt dışında satın alınması, yayın organlarında yer alması ya da tasarım projesinin dış ülkelerde uygulanmış olması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Haber Olması (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Belgesel/Kısa Film (Uluslararası)', 'Uygulama Projesi — Müellif', 'Koruma-Onarım Uygulaması (Uluslararası)'], 'puan' => 40],
    'G-1.2' => ['baslik' => 'Özgün sanat eserleriyle uluslararası jürili karma sanat ve tasarım etkinliklerine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Karma Sergi (Uluslararası)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Resital (Uluslararası)', 'Solistlik (Uluslararası)', 'Şan Resitali (Uluslararası)', 'Orkestra Şefliği (Uluslararası)', 'Opera Şefliği (Uluslararası)', 'Koro Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Uluslararası)', 'Opera Birinci Rol (Uluslararası)', 'Bale Başrol (Uluslararası)', 'Rejisörlük (Uluslararası)', 'Oratoryo/Kantat Solistliği (Uluslararası)'], 'puan' => 20],
    'G-1.4' => ['baslik' => 'Özgün sanat eserleriyle yurt dışında kişisel etkinliklerde bulunmak ya da ulusal jüri elemesinden geçip yurt dışı etkinliklere katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)'], 'puan' => 10],
    'G-1.5' => ['baslik' => 'Özgün sanat eserleriyle yurt dışında karma veya grup sanat ve tasarım etkinliklerine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Oda Müziği Grup Üyeliği (Uluslararası)', 'Corps de Ballet (Uluslararası)', 'Opera İkinci Rol (Uluslararası)', 'Bale Solist Rol (Uluslararası)', 'Dansçı / Performans İcracısı (Uluslararası)', 'Masterclass (Uluslararası)', 'Eğitici Konser Programı (Uluslararası)', 'Grup Şefliği (Uluslararası)', 'Başkemancılık (Uluslararası)', 'Rejisör Yardımcılığı (Uluslararası)', 'Tüm Perde Koreograflığı (Uluslararası)', 'Bölüm Koreograflığı (Uluslararası)', 'Bale/Dans Koreograflığı (Uluslararası)', 'Sahneleme/Repetitörlük — Tüm Perde (Uluslararası)', 'Sahneleme/Repetitörlük — Bölüm (Uluslararası)'], 'puan' => 5],
    'G-2.1' => ['baslik' => 'Özgün sanat eserinin yurt içinde satın alınması, yayın organlarında yer alması ya da tasarım projesinin uygulanmış olması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Satın Alınması (Yurt İçi)', 'Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Haber Olması (Ulusal)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Belgesel/Kısa Film (Ulusal)', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman', 'Koruma-Onarım Uygulaması (Ulusal)', 'Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)', 'Karma Albüm / CD-DVD Katkısı', 'Eğitim Müziği Albümü', 'Özgün Eser / Beste / Tasarım', 'Opera/Bale Kompozisyonu', 'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Orkestralı Sahne Eseri', 'Küçük Ölçekli Orkestra Eseri', 'Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Sahne/Ekran Müziği', 'Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi'], 'puan' => 20],
    'G-2.3' => ['baslik' => 'Özgün sanat eserleriyle yurt içinde jürili karma etkinliklere kabul edilmek ya da kişisel etkinliklerde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)', 'Karma/Jürili Etkinlik (Ulusal)', 'Elektronik Karma Sergi (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Resital (Ulusal)', 'Solistlik (Ulusal)', 'Şan Resitali (Ulusal)', 'Orkestra Şefliği (Ulusal)', 'Opera Şefliği (Ulusal)', 'Koro Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Ulusal)', 'Opera Birinci Rol (Ulusal)', 'Bale Başrol (Ulusal)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Yönetmenlik (Sahne/Ekran)', 'Sahne Tasarımı (Dekor, Kostüm, Işık)', 'Koreografi', 'Oratoryo/Kantat Solistliği (Ulusal)'], 'puan' => 5],
    'G-2.4' => ['baslik' => 'Özgün sanat eserleriyle yurt içinde karma veya grup sanat ve tasarım etkinliklerine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Jürisiz, Ulusal)', 'Oda Müziği Grup Üyeliği (Ulusal)', 'Orkestra / Koro Üyeliği', 'Corps de Ballet (Ulusal)', 'Opera İkinci Rol (Ulusal)', 'Bale Solist Rol (Ulusal)', 'Dansçı / Performans İcracısı (Ulusal)', 'Masterclass (Ulusal)', 'Eğitici Konser Programı (Ulusal)', 'Müzikoloji Atölyesi', 'Eğitim Amaçlı Sanat Etkinliği', 'Grup Şefliği (Ulusal)', 'Başkemancılık (Ulusal)', 'Rejisör Yardımcılığı (Ulusal)', 'Rejisör Yardımcılığı (Konservatuvar)', 'Tüm Perde Koreograflığı (Ulusal)', 'Bölüm Koreograflığı (Ulusal)', 'Bale/Dans Koreograflığı (Ulusal)', 'Sahneleme/Repetitörlük — Tüm Perde (Ulusal)', 'Sahneleme/Repetitörlük — Bölüm (Ulusal)'], 'puan' => 3],

    // ══ H: DİĞER AKADEMİK FAALİYETLER ══
    'H-1.1' => ['baslik' => 'Tamamlanmış doktora tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 10],
    'H-1.2' => ['baslik' => 'Tamamlanmış yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'puan' => 3],
    'H-2.2' => ['baslik' => 'Yurt içinde ya da yurt dışında yerleşik kurumlar için yapılan sözleşmeli danışmanlık', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 8],
    'H-3.1' => ['baslik' => 'Dekan yardımcılığı, üst düzey idari görev ya da enstitü, yüksekokul veya meslek yüksekokulu müdürlüğü (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü', 'Dekan Yrd. / Müdür Yrd.', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 5],
    'H-3.5' => ['baslik' => 'Bölüm başkanlığı ya da enstitü, yüksekokul veya meslek yüksekokulu müdür yardımcılığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı', 'Bölüm Başkan Yardımcısı'], 'puan' => 4],
    'H-3.7' => ['baslik' => 'Program koordinatörlüğü, komisyon başkanlığı veya üyeliği, etik kurul ya da yönetim kurulu üyeliği (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük', 'Kurul / Komisyon Üyeliği'], 'puan' => 1],
    'H-4.2' => ['baslik' => 'Sosyal sorumluluk projesinde yer almak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi'], 'puan' => 3],
];

$kodlar = fn (string $onek): array => array_values(array_filter(
    array_keys($maddeler),
    fn (string $kod): bool => str_starts_with($kod, $onek)
));

$gruplar = [
    'A' => $kodlar('A-'),
    'A-1' => $kodlar('A-1.'),
    'A-2' => $kodlar('A-2.'),
    'A-1-A-2' => [...$kodlar('A-1.'), ...$kodlar('A-2.')],
    // Eczacılık, Mühendislik ve Uygulamalı Bilimlerin "başlıca yazar
    // olunacak" makale kümesi: Scopus Q1 ile SCI-SSCI-AHCI tam metin.
    'A-1.1-A-2.1' => ['A-1.1', 'A-2.1'],
    // Uygulamalı Bilimler ayrıca Q4 ve kısa yazıları da sayıyor.
    'A-1.1-A-1.4-A-2.1-A-2.2' => ['A-1.1', 'A-1.4', 'A-2.1', 'A-2.2'],
    'A-1-A-4' => [...$kodlar('A-1.'), ...$kodlar('A-2.'), ...$kodlar('A-3.'), ...$kodlar('A-4.')],
    'A-4-A-5' => [...$kodlar('A-4.'), ...$kodlar('A-5.'), ...$kodlar('A-6.')],
    'B' => $kodlar('B-'),
    'C' => $kodlar('C-'),
    // Mimarlık tablosunun eski numaralandırmasındaki "C.7-C.11" kümesi:
    // Scopus ve BKCI dışındaki kitap satırları.
    'C-4-C-6' => ['C-4', 'C-5', 'C-6'],
    'C-1-C-6' => $kodlar('C-'),
    'D' => $kodlar('D-'),
    'D-YURUTUCU-ARASTIRMACI' => ['D-1', 'D-2', 'D-4', 'D-5'],
    'E' => $kodlar('E-'),
    'F' => $kodlar('F-'),
    'F-3' => ['F-3.4', 'F-3.7', 'F-3.8'],
    'G' => $kodlar('G-'),
    'H' => $kodlar('H-'),
    'H-1' => $kodlar('H-1.'),
    'A-B-C' => [...$kodlar('A-'), ...$kodlar('B-'), ...$kodlar('C-')],
    'A-B-C-D' => [...$kodlar('A-'), ...$kodlar('B-'), ...$kodlar('C-'), ...$kodlar('D-')],
    'A-B-C-D-E' => [...$kodlar('A-'), ...$kodlar('B-'), ...$kodlar('C-'), ...$kodlar('D-'),
        ...$kodlar('E-')],
    'E-F-G-H' => [...$kodlar('E-'), ...$kodlar('F-'), ...$kodlar('G-'), ...$kodlar('H-')],
    'A-B-C-D-E-F-G' => [...$kodlar('A-'), ...$kodlar('B-'), ...$kodlar('C-'), ...$kodlar('D-'),
        ...$kodlar('E-'), ...$kodlar('F-'), ...$kodlar('G-')],
    // Mimarlık: (A.1-A.4), (B.1-B.5), (C.1-C.11) ve/veya (F.3).
    'MIMARLIK-ANA' => [...$kodlar('A-1.'), ...$kodlar('A-2.'), ...$kodlar('A-3.'),
        ...$kodlar('A-4.'), ...$kodlar('B-'), ...$kodlar('C-'), 'F-3.4', 'F-3.7', 'F-3.8'],
];

$kapsamNotu = 'Puanlar Bahçeşehir Üniversitesi Akademik Personel Yükseltme ve Atama '
    .'Esaslarının MADDE 5 puanlama sisteminden (YÖK Genel Kurul onayı 30.01.2025). '
    .'Ortak çalışmalarda puan yazar SIRASINA değil yalnız KİŞİ SAYISINA bakıyor: tek kişide '
    .'tam puan, iki kişide %80, ikiden fazla kişide 1,8 × puan / kişi sayısı. Yazar listesini '
    .'boş bırakırsanız bölme uygulanmaz ve puanınız olduğundan yüksek görünür. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: A-4.2\'nin h-indeksi puanı (h × 10) '
    .'faaliyet olarak kaydedilemediği için girilemedi; mahkeme kararlarındaki atıflar, kanun '
    .'şerhlerinde yazarlık ve patent BAŞVURUSU satırları da girilemedi. A-1\'in çeyreklikleri '
    .'Scopus veri tabanına göre belirleniyor; çeyrekliği kayıtta bulunmayan Scopus dergileri en '
    .'düşük çeyrekten (8 puan) sayılıyor. Yurt dışında tescil edilmiş patentlerde A tipi ülke '
    .'(100 puan) ile B tipi ülke (30 puan) ayrımı yapılamadığı için düşük satır uygulanıyor. '
    .'Esasların puanlama sisteminde hakemlik, ders verme ve burs satırı yok; bu kayıtlarınız '
    .'toplam puana katkı vermiyor. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünür: "bir kitapta birden fazla bölüm" için '
    .'öngörülen (1 + k/c) çarpanı uygulanmıyor ve idari görevler yıl başına değil kayıt başına '
    .'puanlanıyor.'
    .'Dergi editörlüğü yalnız SCOPUS çeyrekliğine göre puanlanıyor (Q1 50, Q2 40, Q3 20); yönergede Q4 kademesi yok ve ESCI için ayrı bir kademe tanımlanmamış, o yüzden Scopus Q4 ya da yalnız ESCI kapsamındaki dergide editörlüğünüz SAYILMIYOR.';

// ORTAK ÇALIŞMALARDA PUAN DAĞILIMI: tek kişi p, iki kişi 0,8p, ikiden
// fazla kişi 1,8p/n. Yazar sırasına bakılmadığı için bütün roller aynı
// tabloyu paylaşıyor.
$yazarKatsayisi = [
    'kademeler' => [1 => 1.00, 2 => 0.80],
    'bol' => ['pay' => 1.8],
];

$cetvel = fn (array $tavanlar): array => [
    'kapsam_notu' => $kapsamNotu,
    'yazar_katsayisi' => $yazarKatsayisi,
    'maddeler' => $maddeler,
    'gruplar' => $gruplar,
    'grup_tavanlari' => $tavanlar,
];

return ['cetveller' => [
    'bau-2025' => $cetvel([]),
    // Eczacılık doçentlik: A-4 ve A-5'ten en fazla 40, B'den 40, C'den 40,
    // D'den 20 puan.
    'bau-2025-ecz-doc' => $cetvel(['A-4-A-5' => 40, 'B' => 40, 'C' => 40, 'D' => 20]),
    // Mühendislik doçentlik: A-4 ve A-5'ten 40, B'den 40, C'den 40 puan.
    'bau-2025-muh-doc' => $cetvel(['A-4-A-5' => 40, 'B' => 40, 'C' => 40]),
    // Eczacılık ve Mühendislik profesörlük: hepsinde 80 puan tavanı.
    'bau-2025-cap80' => $cetvel(['A-4-A-5' => 80, 'B' => 80, 'C' => 80]),
    // Uygulamalı Bilimler doçentlik: A-4 ve A-5'ten 30, B'den 30, C'den 40.
    'bau-2025-uyg-doc' => $cetvel(['A-4-A-5' => 30, 'B' => 30, 'C' => 40]),
    // Uygulamalı Bilimler profesörlük: A-4 ve A-5'ten 60, B'den 40, C'den 60.
    'bau-2025-uyg-prof' => $cetvel(['A-4-A-5' => 60, 'B' => 40, 'C' => 60]),
]];
