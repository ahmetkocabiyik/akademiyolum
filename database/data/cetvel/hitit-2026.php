<?php

/**
 * HİTİT ÜNİVERSİTESİ — Tablo-7 Akademik Faaliyetler Puan Tablosu
 * Kaynak: pdf/1785851759631.hitit-kriter.pdf
 *
 * Madde kodları Tablo-7'nin kendi harf ve numaralarından türetildi
 * (A01 = A bölümünün 1. satırı); iki haneli yazım A1 ile A10'un
 * karışmaması için bize ait.
 *
 * ── DEVAM EDEN PROJELERE YARIM PUAN, ROL PAYLARI SATIRA GÖMÜLDÜ (§0) ──
 * G bölümünün açıklaması "sonuçlanmış projeden tam puan, devam eden
 * projeden tam puanın %50'si" ve "yürütücü tam puan, araştırmacı %50,
 * danışman %20" diyor. Faaliyet kaydı projenin bitip bitmediğini
 * taşımadığı için bütün proje satırlarına DEVAM EDEN değeri (%50) yazıldı;
 * rol payları da bu değerin üstüne uygulandı. Yani TÜBİTAK yürütücülüğü
 * tablodaki 10 puan yerine 5, araştırmacılık 2 puan görünüyor.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   A.3 (SCOPUS Q1-Q4: 20/18/16/10) ile A.4 (ESCI 14) tek 'ESCI / Scopus'
 *       etiketine düşüyor → 10. Scopus çeyreğiniz yüksekse puanınız
 *       olduğundan belirgin biçimde düşük çıkar.
 *   Atıfta SCIE-SSCI-AHCI (3) ile Scopus-ESCI (2) tek 'WoS / Scopus'
 *       etiketine düşüyor → 2.
 *   G bölümünde 'TÜBİTAK' etiketi 1004'ten 4004'e kadar bütün programları
 *       kapsıyor (28'den 4 puana); en düşük değer (4) girildi ve devam eden
 *       proje oranıyla yürütücülük 2 puana indi. TÜBİTAK 1001 gibi büyük
 *       projeleriniz varsa puanınız olduğundan ÇOK düşük çıkar.
 *   Editörlükte diğer indeksler (2) ile indekssiz hakemli dergi (1) → 1.
 *   Hakemlikte dört kademe (2 · 1,5 · 1 · 0,5) tek 'Hakemlik' etiketine
 *       düşüyor → tam sayıya sığan en düşük değer olan 1.
 *   K bölümünün ödül satırlarında derece çarpanı (birincilik %100,
 *       ikincilik %75, üçüncülük %50, mansiyon %25) kayıtta ayrışmadığı
 *       için en düşük kademe (mansiyon, %25) uygulandı: uluslararası ödül
 *       20 yerine 5, ulusal ödül 8 yerine 2 puan.
 *   N bölümünün yönetim satırları (1,5 · 1 · 0,75) tam sayıya
 *       yuvarlanınca 1 puanda toplandı.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   ÇEVİRİ ESERLER — Tablo-7 açıkça "çeviri eserler puanlamaya dâhil
 *       edilmez" diyor; 'Çeviri Kitap' ve 'Çeviri Kitap Bölümü'
 *       etiketlerine hiçbir satır bağlanmadı.
 *   Lisansüstü tezlerinden ÜRETİLMİŞ yayın satırları (A.6, A.7, B.3, B.5,
 *       B.9, B.10) ile A.1-A.3'ün "tezden üretilen makaleden tam puanın
 *       yarısı" kuralı — kayıt yayının tez kökenli olup olmadığını
 *       taşımıyor; tezinizden ürettiğiniz yayınlar tam satırlardan
 *       puanlanıyor ve toplamınız olduğundan YÜKSEK çıkar.
 *   Ondalıklı satırlar: D.5 (indekssiz dergide atıf, 0,5), F.2 ve F.4
 *       (hakemlik, 1,5 ve 0,5), N bölümünün 0,75 ve 0,5 puanlı satırları
 *       (jüri üyeliği, akreditasyon, sertifika, burs). Akreditasyon
 *       satırlarının dördü de (N.12 0,5 · N.13 1,25 · N.14 0,5 · N.15 0,75)
 *       ya sıfıra yuvarlanıyor ya da görev YILIYLA çarpılıyor; bu yüzden
 *       'Akreditasyon Faaliyeti' etiketinin Hitit'te hiç satırı yok.
 *       Etiket bir tur J02 ders satırında duruyordu, çıkarıldı.
 *   L KAZI FAALİYETLERİ ve M SPOR FAALİYETLERİ bölümlerinin TAMAMI —
 *       faaliyet kaydında karşılığı yok.
 *   N bölümünün Hitit Üniversitesine özgü satırlarının çoğu (MİTAM,
 *       HÜBTUAM, TTO, Proje Koordinasyon Ofisi, Hitit FM, üniversite
 *       dergileri, HEP sorumluluğu) — kayıt faaliyetin hangi kurumda
 *       yapıldığını taşımıyor.
 *   G.7, G.9 ve G.12 (üniversitenin İHTİSASLAŞMA ALANINDAKİ projeler),
 *       G.15 (teknopark danışmanlığı), H.9 ve H.10, K bölümünün
 *       'Ticarileştirme' karşılığı olmayan satırları.
 *   B.11 (ders kitabında bölüm) ve E bölümünün "üniversiteye ait
 *       dergilerde 2 puan ilave" kuralı.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   J bölümünün "her yıl için en fazla 5 puan" sınırı yıl başına değil
 *       toplamda uygulandı; çok yıllık ders kayıtlarınız bu tavanla
 *       sınırlanıyor.
 *   Madde 4/e ve B bölümünün "aynı kitapta en fazla iki bölüm puanlanır"
 *       sınırı; madde 4/j'nin "bir eser yalnız bir kategoride puanlanır"
 *       kuralı; H bölümünün "tekrarlanan sanatsal faaliyet bir kez sayılır"
 *       kuralı.
 *
 * Yönerge: yonerge/hitit.php
 */
$TAM = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];
$WOS = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];

$maddeler = [
    // ══ A. MAKALE ══
    'A01.q1' => ['baslik' => 'SCIE veya SSCI tarafından dizinlenen Q1 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $TAM, 'puan' => 24],
    'A01.q2' => ['baslik' => 'SCIE veya SSCI tarafından dizinlenen Q2 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $TAM, 'puan' => 20],
    'A01.q3' => ['baslik' => 'SCIE veya SSCI tarafından dizinlenen Q3 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $TAM, 'puan' => 18],
    'A01.q4' => ['baslik' => 'SCIE veya SSCI tarafından dizinlenen Q4 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $TAM, 'puan' => 10],
    'A02' => ['baslik' => 'AHCI tarafından dizinlenen dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => $TAM, 'puan' => 20],
    'A03' => ['baslik' => 'SCOPUS ya da ESCI tarafından dizinlenen dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $TAM, 'puan' => 10],
    'A05' => ['baslik' => 'TR Dizin tarafından dizinlenen dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TAM, 'puan' => 12],
    'A08' => ['baslik' => 'SCIE, SSCI, AHCI, ESCI, Scopus ve TR Dizin dışındaki indekslerde dizinlenen hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $TAM, 'puan' => 5],
    'A11' => ['baslik' => 'Herhangi bir indekste dizinlenmeyen hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => 2],
    'A09' => ['baslik' => 'SCIE, SSCI veya AHCI dergisinde teknik not, araştırma notu, editöre mektup, olgu sunusu ya da kitap değerlendirmesi', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $KISA, 'puan' => 4],
    'A10' => ['baslik' => 'Scopus, ESCI veya TR Dizin dergisinde teknik not, araştırma notu, editöre mektup, olgu sunusu ya da kitap değerlendirmesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'TR Dizin', 'Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 2],
    'A12' => ['baslik' => 'İndekssiz hakemli dergide teknik not, editöre mektup, olgu sunusu, araştırma notu ya da kitap değerlendirmesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 1],

    // ══ B. KİTAP ══
    'B01' => ['baslik' => 'BkCI veya Scopus tarafından dizinlenen bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 24],
    'B02' => ['baslik' => 'Uluslararası ya da ulusal yayınevi tarafından yayımlanmış bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 20],
    'B04' => ['baslik' => 'Bilimsel tenkitli metin, edisyon kritik ya da tahkik yapılmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Tahkik (Tenkitli Metin)'], 'puan' => 8],
    'B06' => ['baslik' => 'Uluslararası ya da ulusal yayınevi tarafından yayımlanmış ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 4],
    'B07' => ['baslik' => 'BkCI veya Scopus tarafından dizinlenen bilimsel kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 10],
    'B08' => ['baslik' => 'Uluslararası ya da ulusal yayınevi tarafından yayımlanmış bilimsel kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 5],
    'B12' => ['baslik' => 'Uluslararası ya da ulusal yayınevi tarafından yayımlanmış ansiklopedide madde', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 2],

    // ══ C. BİLDİRİ ══
    'C01' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan ve CPCI ya da SCOPUS\'ta dizinlenen bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 8],
    'C02' => ['baslik' => 'Uluslararası ya da ulusal bilimsel toplantıda sunulan, tam metni veya özeti yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Ulusal Tam Metin'], 'puan' => 4],
    'C03' => ['baslik' => 'Uluslararası ya da ulusal bilimsel toplantıda poster olarak sergilenen ve tam metni veya özeti yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster', 'Ulusal Özet/Poster'], 'puan' => 2],

    // ══ D. ATIF ══
    'D01' => ['baslik' => 'SCIE, SSCI, AHCI, Scopus ya da ESCI dergisindeki yayında eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 2],
    'D03' => ['baslik' => 'TR Dizin dergisindeki yayında eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
    'D04' => ['baslik' => 'Diğer indekslerdeki dergilerde ve bildirilerde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],
    'D06' => ['baslik' => 'Yazar ya da editör olarak yer almadığınız kitapta eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],

    // ══ E. EDİTÖRLÜK ══
    'E01' => ['baslik' => 'BkCI veya Scopus tarafından dizinlenen bilimsel kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 8],
    'E02' => ['baslik' => 'Uluslararası ya da ulusal yayınevi tarafından yayımlanmış bilimsel kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 4],
    'E03' => ['baslik' => 'SCIE, SSCI veya AHCI kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 8],
    'E04' => ['baslik' => 'Scopus veya ESCI kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 4],
    'E05' => ['baslik' => 'TR Dizin kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 3],
    'E07' => ['baslik' => 'Diğer indekslerdeki ya da indekssiz hakemli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 1],
    'E08' => ['baslik' => 'Dergide editör yardımcılığı ya da yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 2],

    // ══ F. HAKEMLİK ══
    'F01' => ['baslik' => 'Hakemli dergide hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 1],

    // ══ G. PROJE (devam eden oranı ve rol payı gömülü) ══
    'G01.y' => ['baslik' => 'Ufuk Avrupa projesinde yürütücülük ya da koordinatörlük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 14],
    'G01.a' => ['baslik' => 'Ufuk Avrupa projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 7],
    'G01.d' => ['baslik' => 'Ufuk Avrupa projesinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['danisman'], 'puan' => 2],
    'G08.y' => ['baslik' => 'Çok taraflı uluslararası araştırma projesinde ya da uluslararası kuruluşlarca desteklenen Ar-Ge projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 6],
    'G08.a' => ['baslik' => 'Çok taraflı uluslararası araştırma projesinde ya da uluslararası kuruluşlarca desteklenen Ar-Ge projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 3],
    'G08.d' => ['baslik' => 'Çok taraflı uluslararası araştırma projesinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['danisman'], 'puan' => 1],
    'G06.y' => ['baslik' => 'TÜBİTAK ya da TÜSEB projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 2],
    'G06.a' => ['baslik' => 'TÜBİTAK ya da TÜSEB projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 1],
    'G10.y' => ['baslik' => 'Üniversite-sanayi iş birliği kapsamındaki Ar-Ge projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 10],
    'G10.a' => ['baslik' => 'Üniversite-sanayi iş birliği kapsamındaki Ar-Ge projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 5],
    'G10.d' => ['baslik' => 'Üniversite-sanayi iş birliği kapsamındaki Ar-Ge projesinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['danisman'], 'puan' => 2],
    'G17.y' => ['baslik' => 'Üniversite dışındaki kamu kurum ve kuruluşlarıyla yürütülen bilimsel araştırma projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 2],
    'G17.a' => ['baslik' => 'Üniversite dışındaki kamu kurum ve kuruluşlarıyla yürütülen bilimsel araştırma projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 1],
    'G11.y' => ['baslik' => 'TÜBİTAK 2209-A, 2209-B ya da 2242 projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 3],
    'G11.a' => ['baslik' => 'TÜBİTAK 2209-A, 2209-B ya da 2242 projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 1],
    'G14.y' => ['baslik' => 'Üniversite BAP projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 2],
    'G14.a' => ['baslik' => 'Üniversite BAP projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 1],

    // ══ H. SANATSAL, MİMARİ, TASARIM VE UYGULAMAYA YÖNELİK ETKİNLİKLER ══
    'H01' => ['baslik' => 'Özgün sanat yapıtının kurumlarca satın alınması, yayın organlarında gösterime girmesi ya da tasarım projesinin kamu veya özel sektörce uygulanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Haber Olması (Uluslararası)', 'Eserin Haber Olması (Ulusal)', 'Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman'], 'puan' => 30],
    'H02' => ['baslik' => 'Yurt dışında kişisel sanat ve tasarım etkinliğinde bulunmak (sergi, bienal, gösteri, dinleti, konser, festival, yarışma)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Resital (Uluslararası)', 'Şan Resitali (Uluslararası)', 'Solistlik (Uluslararası)', 'Oratoryo/Kantat Solistliği (Uluslararası)', 'Orkestra Şefliği (Uluslararası)', 'Koro Şefliği (Uluslararası)', 'Opera Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Uluslararası)', 'Grup Şefliği (Uluslararası)', 'Opera Birinci Rol (Uluslararası)', 'Bale Başrol (Uluslararası)', 'Rejisörlük (Uluslararası)', 'Bale/Dans Koreograflığı (Uluslararası)', 'Tüm Perde Koreograflığı (Uluslararası)', 'Belgesel/Kısa Film (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)'], 'puan' => 20],
    'H03' => ['baslik' => 'Yurt dışında karma ya da ortak sanat ve tasarım etkinliğinde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Elektronik Karma Sergi (Uluslararası)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Oda Müziği Grup Üyeliği (Uluslararası)', 'Başkemancılık (Uluslararası)', 'Corps de Ballet (Uluslararası)', 'Opera İkinci Rol (Uluslararası)', 'Bale Solist Rol (Uluslararası)', 'Dansçı / Performans İcracısı (Uluslararası)', 'Masterclass (Uluslararası)', 'Eğitici Konser Programı (Uluslararası)'], 'puan' => 10],
    'H04' => ['baslik' => 'Yurt içinde kişisel sanat ve tasarım etkinliğinde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Kişisel Sergi (Ulusal)', 'Resital (Ulusal)', 'Şan Resitali (Ulusal)', 'Solistlik (Ulusal)', 'Oratoryo/Kantat Solistliği (Ulusal)', 'Orkestra Şefliği (Ulusal)', 'Koro Şefliği (Ulusal)', 'Opera Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Ulusal)', 'Grup Şefliği (Ulusal)', 'Opera Birinci Rol (Ulusal)', 'Bale Başrol (Ulusal)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Yönetmenlik (Sahne/Ekran)', 'Bale/Dans Koreograflığı (Ulusal)', 'Tüm Perde Koreograflığı (Ulusal)', 'Belgesel/Kısa Film (Ulusal)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Özgün Eser / Beste / Tasarım'], 'puan' => 15],
    'H05' => ['baslik' => 'Yurt içinde karma ya da ortak sanat ve tasarım etkinliğinde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Karma Sergi (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Oda Müziği Grup Üyeliği (Ulusal)', 'Başkemancılık (Ulusal)', 'Orkestra / Koro Üyeliği', 'Corps de Ballet (Ulusal)', 'Opera İkinci Rol (Ulusal)', 'Bale Solist Rol (Ulusal)', 'Dansçı / Performans İcracısı (Ulusal)', 'Masterclass (Ulusal)', 'Eğitici Konser Programı (Ulusal)', 'Müzikoloji Atölyesi', 'Sahne Tasarımı (Dekor, Kostüm, Işık)', 'Koreografi'], 'puan' => 5],
    'H06' => ['baslik' => 'Sanatsal performansa dayalı yayımlanmış (bandrollü) özgün kişisel ses ya da görüntü kaydı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bandrollü Kayıt (CD/DVD)'], 'puan' => 15],
    'H07' => ['baslik' => 'Sanatsal performansa dayalı yayımlanmış (bandrollü) özgün karma ya da ortak ses ya da görüntü kaydı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Albüm / CD-DVD Katkısı', 'Eğitim Müziği Albümü'], 'puan' => 5],
    'H08' => ['baslik' => 'Dijital müzik platformunda yayımlanmış özgün kişisel albüm kaydı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Albüm / Konser Kaydı'], 'puan' => 10],

    // ══ İ. TEZ DANIŞMANLIĞI ══
    'I01' => ['baslik' => 'Yönetiminde tamamlanmış doktora, tıpta uzmanlık ya da sanatta yeterlik tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 4],
    'I02' => ['baslik' => 'Yönetiminde tamamlanmış yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 2],

    // ══ J. EĞİTİME KATKI (yalnız doktor öğretim üyeliği başvurularında) ══
    'J01' => ['baslik' => 'Lisansüstü düzeyde ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 2],
    'J02' => ['baslik' => 'Önlisans veya lisans düzeyinde ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 1],

    // ══ K. ÖDÜL, YARIŞMA, UYGULAMA, YAZILIM VE PATENT ══
    'K01' => ['baslik' => 'Alanında uluslararası jürili bilimsel ya da sanatsal yarışma nitelikli etkinlikte ödül almak', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 5],
    'K02' => ['baslik' => 'Alanında ulusal jürili bilimsel ya da sanatsal yarışma nitelikli etkinlikte ödül almak; mimarlık ve tasarım yarışmalarında ilk üç dereceye girmek', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'Yarışma Derecesi / Mansiyon'], 'puan' => 2],
    'K03' => ['baslik' => 'TÜBİTAK, TÜBA veya YÖK tarafından verilen bilim, teşvik, sanat ya da hizmet ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 12],
    'K05' => ['baslik' => 'Mimarlık ve planlama-tasarım alanında yazılım üreticisi olmak', 'kategori' => 'patent', 'kaynaklar' => ['Yazılım'], 'puan' => 15],
    'K06' => ['baslik' => 'Araştırma raporu alınmış uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 30],
    'K07' => ['baslik' => 'Türk Patent Enstitüsünden araştırma raporu alınmış ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 20],
    'K08' => ['baslik' => 'Ürün çeşit ya da ırk tescili', 'kategori' => 'patent', 'kaynaklar' => ['Islahçı Hakkı / Çeşit Tescili'], 'puan' => 8],
    'K09' => ['baslik' => 'Endüstriyel tasarım belgesi, faydalı model ya da tescil', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım', 'Faydalı Model'], 'puan' => 15],

    // ══ N. ÜNİVERSİTENİN KAPASİTESİNE KATKI ══
    'N01' => ['baslik' => 'Dekan, dekan yardımcılığı, müdürlük ya da müdür yardımcılığı görevi (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü', 'Dekan Yrd. / Müdür Yrd.'], 'puan' => 1],
    'N02' => ['baslik' => 'Bölüm başkanlığı ya da yardımcılığı, anabilim dalı başkanlığı, dönem koordinatörlüğü (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı', 'Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 1],
    'N03' => ['baslik' => 'Rektörlük bünyesindeki kurul ve komisyon üyeliği, araştırma uygulama merkezi müdürlüğü, birim koordinatörlüğü (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 1],
    '23' => ['baslik' => 'Spor federasyonunun yönetim, teknik, eğitim ya da hakem kurulunda görev', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Spor Federasyonu Kurul Üyeliği (Uluslararası)'], 'puan' => 2],
    '23-ulusal' => ['baslik' => 'Spor federasyonunun yönetim, teknik, eğitim ya da hakem kurulunda görev', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Spor Federasyonu Kurul Üyeliği (Ulusal)'], 'puan' => 2],
];

$A_MAKALE = ['A01.q1', 'A01.q2', 'A01.q3', 'A01.q4', 'A02', 'A03'];
$CEKIRDEK = [...$A_MAKALE, 'A05', 'B01', 'B02', 'B04', 'B07', 'B08', 'N01', 'N02', 'N03'];
$DERS = ['J01', 'J02'];

return [
    'kapsam_notu' => 'Puanlar Hitit Üniversitesi Öğretim Üyeliği Kadrolarına Yükseltilme ve '
        .'Atanma Yönergesinin Tablo-7 Akademik Faaliyetler Puan Tablosundan. Ortak yazarlı '
        .'çalışmalarda Tablo-1 uygulanıyor: iki yazarlıda birinci isim tam puan, ikinci %90; '
        .'üç yazarlıda %90, %80, %70; dört yazarlıda %80\'den %50\'ye; beş yazarlıda %70\'ten '
        .'%30\'a; altı-dokuz yazarlıda %60\'tan %10\'a; on ve üzeri yazarlıda %50\'den %10\'a. '
        .'Yazar listesini boş bırakırsanız çarpan uygulanmaz ve puanınız olduğundan yüksek '
        .'görünür. Bildirilerden en fazla 30, atıflardan 10, editörlükten 10, hakemlikten 6, '
        .'sanatsal etkinliklerden 50, tez danışmanlığından 10, eğitime katkıdan 5, ödül ve '
        .'patentten 30, üniversite kapasitesine katkıdan 35 puan alınabiliyor. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: SCOPUS çeyrekleri ESCI\'den '
        .'ayrılamadığı için Scopus makaleleri 10 puandan sayılıyor; TÜBİTAK etiketi 1004\'ten '
        .'4004\'e bütün programları kapsadığı için en düşük değerden ve devam eden proje '
        .'oranından hesaplanıyor; ödüller mansiyon değerinden sayılıyor; L kazı ve M spor '
        .'faaliyetleri bölümlerinin tamamı ile N bölümünün Hitit\'e özgü satırları (MİTAM, '
        .'HÜBTUAM, TTO, Proje Ofisi) ve ondalıklı satırlar girilemedi; çeviri eserler zaten '
        .'yönergece kapsam dışı. Puanınız şu kalemde OLDUĞUNDAN YÜKSEK görünür: lisansüstü '
        .'tezinizden ürettiğiniz yayınlar için yönergenin öngördüğü yarım puan ve düşük '
        .'satırlar uygulanamıyor.',

    // Tablo-1: yazar sayısı × isim sırası.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'editorluk', 'proje', 'tez_danismanligi', 'tez_yayini',
            'egitim_ogretim', 'idari_gorev', 'toplumsal_katki', 'sanatsal_etkinlik', 'diger'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 1.00, 3 => 0.90, 4 => 0.80, 5 => 0.70, 6 => 0.60, 7 => 0.60, 8 => 0.60, 9 => 0.60], 'sonrasi' => 0.50],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 1.00, 3 => 0.90, 4 => 0.80, 5 => 0.70, 6 => 0.60, 7 => 0.60, 8 => 0.60, 9 => 0.60], 'sonrasi' => 0.50],
            'yazar_2' => ['kademeler' => [2 => 0.90, 3 => 0.80, 4 => 0.70, 5 => 0.60, 6 => 0.50, 7 => 0.50, 8 => 0.50, 9 => 0.50], 'sonrasi' => 0.40],
            'yazar_3' => ['kademeler' => [3 => 0.70, 4 => 0.60, 5 => 0.50, 6 => 0.40, 7 => 0.40, 8 => 0.40, 9 => 0.40], 'sonrasi' => 0.30],
            'yazar_4' => ['kademeler' => [4 => 0.50, 5 => 0.40, 6 => 0.30, 7 => 0.30, 8 => 0.30, 9 => 0.30], 'sonrasi' => 0.20],
            'yazar_5' => ['kademeler' => [5 => 0.30, 6 => 0.20, 7 => 0.20, 8 => 0.20, 9 => 0.20], 'sonrasi' => 0.10],
            'ortak' => ['sonrasi' => 0.10],
        ],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        // Tablo-2, Tablo-3 ve Tablo-5'in temel alana göre değişen makale
        // kategorileri. A.3 (SCOPUS) ile A.4 (ESCI) tek satırda birleştiği
        // için A.1-3 ile A.1-4 aynı kod listesine düşüyor.
        'A1-3' => $A_MAKALE,
        'A1-4' => $A_MAKALE,
        'A1-5' => [...$A_MAKALE, 'A05'],
        // Madde 5/1-c, 9/d ve 12/d'nin "A.1-7, B.1-4, B.7-8 ve N" kümesi.
        'CEKIRDEK' => $CEKIRDEK,
        // Tablo-7'nin tamamı. J (Eğitime Katkı) yalnızca doktor öğretim
        // üyeliği başvurularında dolduruluyor, doçentlik ve profesörlük
        // toplamlarına girmiyor.
        'TOPLAM' => array_values(array_diff(array_keys($maddeler), $DERS)),
        'TOPLAM-DR' => array_keys($maddeler),
        // Tablo-4 ve Tablo-6'nın proje kategorileri.
        'G1-10' => ['G01.y', 'G01.a', 'G01.d', 'G08.y', 'G08.a', 'G08.d', 'G06.y', 'G06.a',
            'G10.y', 'G10.a', 'G10.d'],
        'G1-12' => ['G01.y', 'G01.a', 'G01.d', 'G08.y', 'G08.a', 'G08.d', 'G06.y', 'G06.a',
            'G10.y', 'G10.a', 'G10.d', 'G11.y', 'G11.a'],
        // Madde 9/ç ve 12/ç'nin proje koşulundan muafiyet yolları.
        'K6-9' => ['K06', 'K07', 'K08', 'K09'],
        'Q1-AHCI' => ['A01.q1', 'A02'],
        'Q2' => ['A01.q2'],
        // Madde 5/1-ç, 9/e ve 12/e'nin Güzel Sanatlar koşulu.
        'H' => ['H01', 'H02', 'H03', 'H04', 'H05', 'H06', 'H07', 'H08'],
        // Tavan grupları.
        'C' => ['C01', 'C02', 'C03'],
        'D' => ['D01', 'D03', 'D04', 'D06'],
        'E' => ['E01', 'E02', 'E03', 'E04', 'E05', 'E07', 'E08'],
        'F' => ['F01'],
        'I' => ['I01', 'I02'],
        'J' => $DERS,
        'K' => ['K01', 'K02', 'K03', 'K05', 'K06', 'K07', 'K08', 'K09'],
        'N' => ['N01', 'N02', 'N03'],
    ],

    'grup_tavanlari' => [
        'C' => 30,
        'D' => 10,
        'E' => 10,
        'F' => 6,
        'H' => 50,
        'I' => 10,
        'J' => 5,
        'K' => 30,
        'N' => 35,
    ],
];
