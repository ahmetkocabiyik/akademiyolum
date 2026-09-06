<?php

/**
 * İSTANBUL AREL ÜNİVERSİTESİ — Değerlendirme Ölçütleri Puanlama Tablosu
 * Kaynak: pdf/17537098882.istanbulareluniversitesi.pdf (12 sayfa;
 * Senato 18.07.2018 tarihinde yürürlüğe girmiş, ek kriterlerle birlikte)
 *
 * Madde kodları tablonun kendi kodları (A.1.a, F.2.b, S.7.a).
 *
 * ── EN ÇOK PUAN KAYBETTİREN KARARLAR ──
 *   IMPACT FAKTÖRÜ ÇARPANI UYGULANMIYOR. Tablonun genel açıklaması
 *       "birden fazla ismin yer aldığı yayınlar için yazılan puanı hak
 *       ediş oranları, derginin IMPACT FAKTÖRÜ İLE ÇARPILDIKTAN SONRA
 *       aşağıdaki oranlara göre hesaplanır" diyor. Motorun puan alanı
 *       sabit; dergi etki faktörü kayıtta tutulmuyor. Bütün makale
 *       puanları çarpansız, yani tablo değerinden sayılıyor.
 *   PATENT BAŞVURULARI (yurt dışı 50, yurt içi 25) girilmedi; kayıt
 *       başvuruyu tescilden ayırmıyor. Faydalı model, endüstriyel tasarım
 *       ve yazılımın da tabloda satırı yok.
 *   A.3.c SATIRI ÖNCE "PUANI OKUNAMIYOR" DİYE GİRİLMEMİŞTİ; 01.09.2026'da
 *       sayfa 190 dpi görüntüye çevrilip okundu, değer 5 puan. `pdftotext`
 *       hücreyi kaybediyor çünkü satır iki satıra taşıyor ve puan sütunu
 *       ikinci satırın hizasında. Taranmamış PDF'te bile metin çıkarımının
 *       hücre kaybedebileceğinin örneği.
 *   O BÖLÜMÜNÜN organizasyon başkanlığı (150 ve 100), düzenleme ve bilim
 *       kurulu üyeliği (20) ile O.6 TÜBİTAK görevlendirmeleri (50)
 *       girilmedi; kayıtta bu görevlerin etiketi yok. Yalnız davetli
 *       konuşmacılık (20) girildi.
 *   P.3 rektör danışmanlığı (30) ile P.8 öğrenci danışmanlığı (10)
 *       girilmedi; ikisinin de karşılığı yok.
 *   LİSANSÜSTÜ TEZDEN ÜRETİLMİŞ YAYIN kategorisinin tabloda satırı yok.
 *   N bölümünün ders puanı HAFTALIK DERS SAATİ başına veriliyor
 *       (lisansüstü 2, lisans 1). Kayıt ders saatini tutmadığı için ders
 *       başına tek puan sayılıyor; haftada üç saatlik bir lisansüstü ders
 *       6 değil 2 puan görünür.
 *
 * ── AYNI ETİKETE DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   H.1 WoS atfı (10) ile H.2 Scopus/ESCI atfı (5) tek etikette: 5.
 *   F ve G bölümlerinde editörlük, yayın kurulu üyeliği ve hakemlik dergi
 *       türüne göre dört kademe; "Yayın Kurulu Üyeliği" (30/20/15/10) ve
 *       "Hakemlik" (10/5/3/2) etiketleri tek olduğu için en düşükten.
 *   T bölümünde uluslararası derece (45), mansiyon (35), ulusal derece
 *       (40) ve mansiyon (30) tek etikete düşüyor: 30'dan sayılıyor.
 *   R bölümünde uluslararası kuruluşta görev (15), kamu/özel kurumda
 *       görev (10) ve STK'da görev (5) tek etikette: 5'ten sayılıyor.
 *   S.7 satın alınan/uygulanan tasarım uluslararası 100 / ulusal 50;
 *       kayıt ayrımı taşımadığı için 50'den sayılıyor.
 *
 * ── PUANI YÜKSEK GÖSTEREBİLEN TEK KARAR ──
 *   TABLODA ULUSAL KİTAP YAZARLIĞI SATIRI YOK. B bölümü yalnız
 *       uluslararası kitapları puanlıyor (BKCI 100/40, diğer uluslararası
 *       60/30); Türkçe yayımlanmış kitaplar yalnız G.2'de EDİTÖRLÜK
 *       olarak geçiyor. Kayıt uluslararası ile ulusal kitabı ayırmadığı
 *       için "Uluslararası/Ulusal Kitap" etiketi B.3'ten (60), bölümü
 *       B.4'ten (30) sayılıyor. Ulusal bir kitabınız varsa puanınız
 *       OLDUĞUNDAN YÜKSEK görünür. Satırı hiç girmemek bu kez daha
 *       yanıltıcı olurdu: uluslararası kitapların tamamı sıfırlanırdı.
 *
 * ── YAZAR ÇARPANI ──
 * Birinci isim %100, ikinci %80, üçüncü %60, dördüncü %40, diğer sıralar
 * %20; yazışma yazarı %100. "Senior isim" (son yazar, alanında en az on
 * uluslararası yayını olmak şartıyla) da %100 alıyor ama kayıtta böyle
 * bir rol yok; senior yazarsanız puanınız DÜŞÜK görünür.
 *
 * Yönerge: yonerge/istanbul-arel.php
 */
$SCI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)'];
$OZGUN = ['ozgun_makale'];
$DERLEME = ['derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];

$maddeler = [
    // ══ A. ULUSLARARASI MAKALE ══
    'A.1.a' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI kapsamındaki dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => [...$SCI, 'AHCI'], 'turler' => $OZGUN, 'puan' => 50],
    'A.1.b' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI kapsamındaki dergide derleme makalesi', 'kategori' => 'makale', 'kaynaklar' => [...$SCI, 'AHCI'], 'turler' => $DERLEME, 'puan' => 40],
    'A.1.c' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI kapsamındaki dergide editöre mektup, vaka raporu, teknik not ya da yorum', 'kategori' => 'makale', 'kaynaklar' => [...$SCI, 'AHCI'], 'turler' => $KISA, 'puan' => 30],
    'A.2.a' => ['baslik' => 'Scopus, ESCI, Avery, DAAI, Art Index, ICONDA ya da Ergo-Abs kapsamındaki dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $OZGUN, 'puan' => 30],
    'A.2.b' => ['baslik' => 'Scopus, ESCI, Avery, DAAI, Art Index, ICONDA ya da Ergo-Abs kapsamındaki dergide derleme makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $DERLEME, 'puan' => 20],
    'A.2.c' => ['baslik' => 'Scopus, ESCI, Avery, DAAI, Art Index, ICONDA ya da Ergo-Abs kapsamındaki dergide editöre mektup, vaka raporu, teknik not ya da yorum', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $KISA, 'puan' => 10],
    'A.3.a' => ['baslik' => 'Diğer uluslararası dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $OZGUN, 'puan' => 20],
    'A.3.b' => ['baslik' => 'Diğer uluslararası dergide derleme makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $DERLEME, 'puan' => 10],
    'A.3.c' => ['baslik' => 'Diğer uluslararası dergide editöre mektup, vaka raporu, teknik not ya da yorum', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 5],

    // ══ B. KİTAPLAR ══
    'B.1' => ['baslik' => 'Book Citation Index kapsamında taranan kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 100],
    'B.2' => ['baslik' => 'Book Citation Index kapsamında taranan kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 40],
    'B.3' => ['baslik' => 'Uluslararası yayınevlerince yayımlanmış kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı', 'Tahkik (Tenkitli Metin)'], 'puan' => 60],
    'B.4' => ['baslik' => 'Uluslararası yayınevlerince yayımlanmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 30],
    'B.5.b' => ['baslik' => 'ISBN numaralı bilimsel ya da sanatsal kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 20],
    'B.5.c' => ['baslik' => 'Kitap bölümü ya da makale çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 10],

    // ══ C. ULUSAL MAKALELER ══
    'C.1.a' => ['baslik' => 'TÜBİTAK ULAKBİM tarafından taranan yurt içi hakemli dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $OZGUN, 'puan' => 25],
    'C.1.b' => ['baslik' => 'TÜBİTAK ULAKBİM tarafından taranan yurt içi hakemli dergide derleme makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $DERLEME, 'puan' => 20],
    'C.1.c' => ['baslik' => 'TÜBİTAK ULAKBİM tarafından taranan yurt içi hakemli dergide editöre mektup, vaka raporu, teknik not ya da yorum', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $KISA, 'puan' => 15],
    'C.2.a' => ['baslik' => 'Diğer yurt içi hakemli dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $OZGUN, 'puan' => 15],
    'C.2.b' => ['baslik' => 'Diğer yurt içi hakemli dergide derleme makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $DERLEME, 'puan' => 10],
    'C.2.c' => ['baslik' => 'Diğer yurt içi hakemli dergide editöre mektup, vaka raporu, teknik not ya da yorum', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 5],

    // ══ D-E. BİLDİRİLER ══
    'D.1' => ['baslik' => 'Uluslararası kongrede sunulan, SCI, SCI-Expanded, SSCI veya AHCI kapsamındaki dergi özel sayısında ya da kongre kitabında yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 25],
    'D.2' => ['baslik' => 'Uluslararası kongrede sunulan, diğer dergi özel sayılarında ya da kongre kitaplarında yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Uluslararası Özet/Poster'], 'puan' => 15],
    'E.1' => ['baslik' => 'Ulusal kongrede sunulan, ulusal veri tabanlarında taranan dergi özel sayısında yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 10],
    'E.2' => ['baslik' => 'Ulusal kongrede sunulan, kongre kitabında yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 5],
    'O.4.c' => ['baslik' => 'Bilimsel ya da sanatsal organizasyonda davetli konuşmacı, panelist veya oturum başkanı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 20],

    // ══ F-G. EDİTÖRLÜK, YAYIN KURULU, HAKEMLİK ══
    'F.2.a' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI kapsamındaki dergide editörlük ya da yardımcı editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 80],
    'F.3.a' => ['baslik' => 'Scopus ya da ESCI kapsamındaki dergide editörlük ya da yardımcı editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 50],
    'F.1' => ['baslik' => 'Yurt dışında yayımlanmış ISBN numaralı bilimsel ya da sanatsal kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 50],
    'G.2' => ['baslik' => 'Türkçe yayımlanmış kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 30],
    'G.1.a' => ['baslik' => 'Ulusal veri tabanlarında taranan dergide editörlük ya da yardımcı editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 30],
    'G.1.b' => ['baslik' => 'Dergide yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 10],
    'G.1.c' => ['baslik' => 'Dergi hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 2],

    // ══ H. ATIFLAR ══
    'H.2' => ['baslik' => 'WoS, Scopus ya da ESCI kapsamındaki dergilerde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 5],
    'H.4' => ['baslik' => 'Book Citation Index kapsamındaki kitaplarda eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 10],
    'H.6' => ['baslik' => 'Diğer dergilerde, kitaplarda ve ulusal yayınlarda eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 2],

    // ══ J. TEZ DANIŞMANLIĞI ══
    'J.1.a' => ['baslik' => 'Danışman ya da ikinci danışman olarak tamamlanmış yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman', 'es_danisman'], 'puan' => 5],
    'J.1.b' => ['baslik' => 'Danışman ya da ikinci danışman olarak tamamlanmış doktora, sanatta yeterlik ya da tıpta uzmanlık tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman', 'es_danisman'], 'puan' => 10],

    // ══ K. PROJELER ══
    'K.1.a' => ['baslik' => 'Avrupa Birliği Çerçeve Programı destekli bilimsel projede yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 200],
    'K.1.b' => ['baslik' => 'Avrupa Birliği Çerçeve Programı destekli bilimsel projede araştırmacı ya da bursiyer olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 100],
    'K.1.c' => ['baslik' => 'Avrupa Birliği Çerçeve Programı destekli bilimsel projede danışman, uzman ya da eğitmen olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['danisman'], 'puan' => 50],
    'K.2.a' => ['baslik' => 'Diğer uluslararası bilimsel projede yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 100],
    'K.2.b' => ['baslik' => 'Diğer uluslararası bilimsel projede araştırmacı ya da bursiyer olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 50],
    'K.2.c' => ['baslik' => 'Diğer uluslararası bilimsel projede danışman, uzman ya da eğitmen olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['danisman'], 'puan' => 20],
    'K.3.a' => ['baslik' => 'TÜBİTAK tarafından desteklenen bilimsel projede yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 150],
    'K.3.b' => ['baslik' => 'TÜBİTAK tarafından desteklenen bilimsel projede araştırmacı ya da bursiyer olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 75],
    'K.3.c' => ['baslik' => 'TÜBİTAK tarafından desteklenen bilimsel projede danışman, uzman ya da eğitmen olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['danisman'], 'puan' => 20],
    'K.4.a' => ['baslik' => 'Bakanlıklar ya da kalkınma ajansları tarafından desteklenen bilimsel projede yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 150],
    'K.4.b' => ['baslik' => 'Bakanlıklar ya da kalkınma ajansları tarafından desteklenen bilimsel projede araştırmacı ya da bursiyer olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'TÜSEB'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 50],
    'K.4.c' => ['baslik' => 'Bakanlıklar ya da kalkınma ajansları tarafından desteklenen bilimsel projede danışman, uzman ya da eğitmen olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'TÜSEB'], 'roller' => ['danisman'], 'puan' => 20],
    'K.5.a' => ['baslik' => 'BAP tarafından desteklenen bilimsel projede yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 50],
    'K.5.b' => ['baslik' => 'BAP tarafından desteklenen bilimsel projede araştırmacı ya da bursiyer olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 20],
    'K.5.c' => ['baslik' => 'BAP tarafından desteklenen bilimsel projede danışman, uzman ya da eğitmen olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['danisman'], 'puan' => 10],
    'K.7' => ['baslik' => 'Sanayi destekli üniversite-sanayi iş birliği projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'puan' => 20],

    // ══ L. PATENTLER — R.4 TEKNOPARK ══
    'L.1.a' => ['baslik' => 'Yurt dışında alınmış patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 300],
    'L.2.a' => ['baslik' => 'Yurt içinde alınmış patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 150],
    'R.4' => ['baslik' => 'Teknoparkta şirket sahipliği ya da ortaklığı', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 50],

    // ══ M. ÖDÜLLER ══
    'M.1.a' => ['baslik' => 'Uluslararası bilimsel kuruluşlarca sürekli ve periyodik olarak verilen jürili bilim, sanat veya tasarım ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü'], 'puan' => 500],
    'M.2.a' => ['baslik' => 'TÜBİTAK ya da TÜBA tarafından verilen bilim, sanat veya tasarım ödülü (teşvik ödülleri hariç)', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü'], 'puan' => 200],
    'M.3.b' => ['baslik' => 'Bilimsel araştırma bursu', 'kategori' => 'odul', 'kaynaklar' => ['Burs', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 100],
    'M.2.b' => ['baslik' => 'Üniversite ya da ulusal kuruluşlarca verilen bilim, sanat veya tasarım ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'YÖK Ödülü'], 'puan' => 50],
    'T.2.b' => ['baslik' => 'Sanat ya da tasarım yarışmasında alınmış derece veya mansiyon', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 30],

    // ══ N. EĞİTİM-ÖĞRETİM ══
    'N.1' => ['baslik' => 'Son iki yılda lisansüstü seviyesinde verilen ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 2],
    'N.2' => ['baslik' => 'Son iki yılda lisans ya da ön lisans seviyesinde verilen ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 1],

    // ══ P. YÖNETİM FAALİYETLERİ ══
    'P.1' => ['baslik' => 'Rektörlük', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör'], 'puan' => 50],
    'P.2' => ['baslik' => 'Rektör yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör Yardımcısı'], 'puan' => 40],
    'P.4' => ['baslik' => 'Rektörlüğe bağlı komisyon ya da kurullarda görev almak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Senato / Üniversite Yönetim Kurulu Üyesi'], 'puan' => 30],
    'P.5' => ['baslik' => 'Dekanlık, yüksekokul, meslek yüksekokulu ya da enstitü müdürlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü'], 'puan' => 30],
    'P.6' => ['baslik' => 'Dekan yardımcılığı, müdür yardımcılığı, bölüm başkanlığı ya da araştırma merkezi müdürlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkanı', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 25],
    'P.7' => ['baslik' => 'Bölüm başkan yardımcılığı ya da anabilim dalı başkanlığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 20],
    'P.9' => ['baslik' => 'Diğer komisyon ya da kurullarda görev almak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 5],

    // ══ R. SEKTÖR DENEYİMİ ══
    'R.3' => ['baslik' => 'Uluslararası kuruluşlarda, kamu ya da özel kurumlarda veya sivil toplum örgütlerinde görev almak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı', 'Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 5],

    // ══ S. SANAT VE TASARIM ETKİNLİKLERİ ══
    'S.1.a' => ['baslik' => 'Uluslararası tanınmış müze, kültür merkezi ya da sanat galerisinde kişisel sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)'], 'puan' => 60],
    'S.1.b' => ['baslik' => 'Ulusal tanınmış müze, kültür merkezi ya da sanat galerisinde kişisel sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 30],
    'S.3.a' => ['baslik' => 'Uluslararası jürili karma sergi, bienal, trienal, çalıştay ya da uygulamalı sempozyum', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Karma Sergi (Uluslararası)'], 'puan' => 30],
    'S.3.b' => ['baslik' => 'Ulusal jürili karma sergi, bienal, trienal, çalıştay ya da uygulamalı sempozyum', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 15],
    'S.4.a' => ['baslik' => 'Uluslararası karma sergi ya da çalıştay', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 20],
    'S.4.b' => ['baslik' => 'Ulusal karma sergi ya da çalıştay', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 10],
    'S.5.a' => ['baslik' => 'Uluslararası tanınmış müze ya da büyük koleksiyonlarda yapıt', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)'], 'puan' => 60],
    'S.5.b' => ['baslik' => 'Ulusal tanınmış müze ya da büyük koleksiyonlarda yapıt', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)'], 'puan' => 40],
    'S.6.a' => ['baslik' => 'Uluslararası gösteri, görsel-işitsel tasarım ya da defile', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Dansçı / Performans İcracısı (Uluslararası)', 'Belgesel/Kısa Film (Uluslararası)'], 'puan' => 60],
    'S.6.b' => ['baslik' => 'Ulusal gösteri, görsel-işitsel tasarım ya da defile', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Dansçı / Performans İcracısı (Ulusal)', 'Belgesel/Kısa Film (Ulusal)'], 'puan' => 30],
    'S.7.b' => ['baslik' => 'Satın alınan ya da uygulanan tasarım veya proje', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)', 'Özgün Eser / Beste / Tasarım', 'Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip'], 'puan' => 50],
    'S.8.a' => ['baslik' => 'Uluslararası mimarlık ya da tasarım yarışmasına katılım', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Uluslararası)'], 'puan' => 60],
    'S.8.b' => ['baslik' => 'Ulusal mimarlık ya da tasarım yarışmasına katılım', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Üyeliği (Ulusal)', 'Jüri Başkanlığı (Ulusal)'], 'puan' => 30],
    'O.4.a' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 150],
    'O.5.a' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Ulusal)'], 'puan' => 100],
    'O.4.b' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 20],
    'O.4.ck' => ['baslik' => 'Bilimsel toplantıda oturum başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Uluslararası)', 'Oturum Başkanlığı (Ulusal)'], 'puan' => 20],
];

return [
    'kapsam_notu' => 'Puanlar İstanbul Arel Üniversitesi Öğretim Üyeliğine Yükseltilme ve Atanma '
        .'Yönergesinin Değerlendirme Ölçütleri Puanlama Tablosundan. Yazar çarpanı: birinci isim '
        .'tam puan, ikinci 0,8; üçüncü 0,6; dördüncü 0,4; diğer sıralar 0,2. Yazışma yazarı tam '
        .'puan alıyor. Yazar listesini boş bırakırsanız çarpan hiç uygulanmaz ve puanınız '
        .'olduğundan YÜKSEK görünür. '
        .'DERGİ ETKİ FAKTÖRÜ ÇARPANI UYGULANMIYOR: tablo makale puanlarının derginin impact '
        .'faktörüyle çarpılmasını istiyor, kayıt etki faktörünü tutmuyor, puanlar tablo '
        .'değerinden sayılıyor. "Senior isim" (alanında en az on uluslararası yayını olan son '
        .'yazar) tam puan alıyor ama kayıtta böyle bir rol yok; senior yazarsanız puanınız düşük '
        .'görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: patent BAŞVURULARI (yurt dışı 50, '
        .'yurt içi 25) tescilliden ayrılamadığı için girilmedi, faydalı model ve endüstriyel '
        .'tasarımın da tabloda satırı yok; O '
        .'bölümünün organizasyon başkanlığı (150 ve 100), kurul üyeliği (20) ve TÜBİTAK '
        .'görevlendirmeleri (50) ile P.3 rektör danışmanlığı, P.8 öğrenci danışmanlığı '
        .'girilmedi; lisansüstü tezden üretilmiş yayın kategorisinin tabloda karşılığı yok. Ders '
        .'puanı HAFTALIK DERS SAATİ başına verildiği hâlde ders başına tek puan sayılıyor. WoS '
        .'atfı (10), yayın kurulu üyeliği (30\'a kadar), hakemlik (10\'a kadar), yarışma '
        .'dereceleri (45\'e kadar) ve sektör deneyimi (15\'e kadar) etiket ayrımı taşımadığı '
        .'için en düşük satırlarından sayılıyor. '
        .'Puanınız şu kalemde OLDUĞUNDAN YÜKSEK görünebilir: tabloda ULUSAL KİTAP YAZARLIĞI '
        .'satırı yok, yalnız uluslararası kitaplar puanlanıyor. Kayıt ikisini ayırmadığı için '
        .'Türkçe yayımlanmış kitabınız da uluslararası kitap satırından (60) sayılıyor.',

    'yazar_katsayisi' => [
        'haric' => ['atif', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev', 'odul',
            'editorluk', 'toplumsal_katki', 'proje', 'patent', 'sanatsal_etkinlik', 'diger'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00], 'sonrasi' => 1.00],
            'baslica' => ['kademeler' => [1 => 1.00], 'sonrasi' => 1.00],
            'yazar_2' => ['kademeler' => [1 => 1.00], 'sonrasi' => 0.80],
            'yazar_3' => ['kademeler' => [1 => 1.00], 'sonrasi' => 0.60],
            'yazar_4' => ['kademeler' => [1 => 1.00], 'sonrasi' => 0.40],
            'ortak' => ['kademeler' => [1 => 1.00], 'sonrasi' => 0.20],
        ],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        'TUM' => array_keys($maddeler),
        // Ek atanma kriterleri: "A veya C grubundan özgün araştırma makalesi".
        'AC-OZGUN' => ['A.1.a', 'A.2.a', 'A.3.a', 'C.1.a', 'C.2.a'],
        // Profesörlükte "A1a'dan en az bir/iki yayın".
        'A1A' => ['A.1.a'],
        // Mimarlık profesörlüğünde "A veya B grubundan iki yayın".
        'AB' => ['A.1.a', 'A.1.b', 'A.1.c', 'A.2.a', 'A.2.b', 'A.2.c', 'A.3.a', 'A.3.b', 'A.3.c',
            'B.1', 'B.2', 'B.3', 'B.4', 'B.5.b', 'B.5.c'],
        // Profesörlükte "K1, K2, K3 ve K4 gruplarından en az bir projede yürütücü".
        'K1-4-YURUTUCU' => ['K.1.a', 'K.2.a', 'K.3.a', 'K.4.a'],
        // Güzel Sanatlar eşiklerinin dayandığı S ve T maddeleri.
        'ST' => ['S.1.a', 'S.1.b', 'S.3.a', 'S.3.b', 'S.4.a', 'S.4.b', 'S.5.a', 'S.5.b',
            'S.6.a', 'S.6.b', 'S.7.b', 'S.8.a', 'S.8.b', 'T.2.b'],
    ],

    'grup_tavanlari' => [],
];
