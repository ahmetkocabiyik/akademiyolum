<?php

/**
 * IŞIK ÜNİVERSİTESİ — EK-1 PUANLAMA TABLOSU
 * Kaynak: pdf/17537098592.isikuniversitesi.pdf
 * Senato: 18.12.2018 / 301 — yürürlük 31.01.2019
 *
 * İKİ CETVEL BİR DOSYADA, FARK TEK BİR ÇARPAN. Koşulların çoğu şu notu
 * taşıyor: "(A.1 ve B grubu faaliyetler 1.3 katsayısı ile çarpılarak
 * değerlendirilir.)" Çarpan Mühendislik Fakültesi ve Fen-Edebiyat'ın FİZİK
 * bölümünde YOK; Madde 6-8'in (c) bendi çarpanı yalnızca MATEMATİK bölümü
 * için tanıyor. Bu yüzden:
 *
 *   isik-2019            Mühendislik Fakültesi, Fizik Bölümü (çarpansız)
 *   isik-2019-carpanli   diğer bütün birimler (A.1 ve B × 1,3)
 *
 * Çarpan cetvele GÖMÜLDÜ, koşula değil: motor `carpanlar` alanı tanımıyor ve
 * çarpan aynı birimde bütün kadrolarda geçerli. Çarpımdan sonra kesirli çıkan
 * değerler AŞAĞI yuvarlandı (15 × 1,3 = 19,5 → 19).
 *
 * ── TABLONUN KENDİSİ DE KESİRLİ ──
 * Yönergenin puanları ondalıklı (A.1.2a 10,5 · A.1.3a 9 · atıflar 0,6-2,4).
 * Motor tam sayı tuttuğu için hepsi aşağı yuvarlandı. En çok atıflar
 * etkileniyor: 0,6 puanlık atıf satırları SIFIRA düşüyor, yani ulusal ve
 * ESCI atıfları puan getirmiyor. Uluslararası kitap atfı (2,4 → 2) ve
 * SSCI/SCI-E atfı (1,2 → 1) duruyor.
 *
 * ── YAZAR PAYI SIRAYA BAĞLI, SAYIYA DEĞİL ──
 * Açıklama 2: birinci isim %100 · sorumlu ve senyör yazar ile bildiriyi sunan
 * isim sıraya bakılmaksızın %100 · ikinci %90 · üçüncü %80 · dördüncü %70 ·
 * beşinci ve sonrası %50. Yazar SAYISI hiç rol oynamıyor, bu yüzden bütün
 * roller `sonrasi` kullanıyor ve `kademeler` boş.
 * Açıklama 3: paylaşım oranı tanımlı olmayan faaliyetlerde bütün yazarlar
 * %50 alıyor — o kalemler `haric` dışında bırakılıp 0,5 ile işaretlenemediği
 * için (motor kategori başına tek kural tanıyor) çarpanın dışında tutuldu;
 * o kalemlerde puan YÜKSEK görünür.
 * Açıklama 4: atıfta kişi sayısı dikkate alınmıyor — atıf `haric` listesinde.
 *
 * ── UYGULANAMAYAN SINIRLAR ──
 * Yönerge çok sayıda kalemde yıl ve adet sınırı koyuyor: "yılda en fazla 3
 * öğrenci için, yıl başına, en fazla 3 yıl" (tez), "her yıl için" (proje ve
 * idari görev), "yılda en çok 3 kez" (bilirkişi). Motor faaliyet başına
 * puanlıyor ve yıl bazlı tekrar tanımıyor; bu kalemlerde puan YÜKSEK görünür.
 * F, G ve H bölümlerinin kadroya bağlı tavanları (doçentlikte 15/10/10,
 * profesörlükte 30/20/20) da uygulanamıyor: motor tavanı cetvele bağlıyor,
 * kadroya değil. En yüksek olan profesörlük tavanı kullanıldı — düşük tavan
 * yazmak doçent adayının puanını fazla kısardı, yüksek tavan ise yalnızca
 * doçentlikte gevşek kalıyor.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   A.4 g-m  besteci, sanat sözlüğünde yer alma, hakkında kitap/tez yazılması.
 *   A.2.2    hakemsiz ulusal dergi · A.2.1c, A.2.5 makale ve bölüm çevirisi.
 *   C.6-C.8  mimari eser sınıfları ve üniversite içi içerik üretimi.
 *   E.2-E.4  yarışma dereceleri ayrı ayrı (birincilik/ikincilik/üçüncülük),
 *            koleksiyon ve müze seçimleri — sözlük dereceyi ayırmıyor,
 *            'Yarışma Derecesi / Mansiyon' tek satıra (E.3d) bağlandı.
 *   F.1-F.6  editörlük ve hakemlik bölümünün büyük kısmı: bildiri kitabı
 *            editörlüğü, düzenleme kurulu, panelistlik, akreditasyon
 *            raporları, küratörlük — sözlükte ayırt edici etiket yok.
 *   G.1.3-4  tezsiz yüksek lisans ve lisans bitirme projeleri.
 *   H.3      Erasmus ve akreditasyon koordinatörlükleri.
 *
 * Yönerge: yonerge/isik.php
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 */
$kapsamNotu = 'Puanlar Işık Üniversitesi EK-1 Puanlama Tablosundan. '
    .'Çok yazarlı çalışmalarda pay yazar SIRASINA bağlı (birinci isim ve sorumlu yazar %100, '
    .'ikinci %90, üçüncü %80, dördüncü %70, beşinci ve sonrası %50); yazar sayısı rol '
    .'oynamıyor. Faaliyetinizde kaçıncı yazar olduğunuzu seçmezseniz en düşük pay uygulanır. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: yönergenin puanları ondalıklı ve motor '
    .'tam sayı tuttuğu için aşağı yuvarlandı; 0,6 puanlık atıf satırları sıfıra düştüğünden '
    .'ulusal ve ESCI atıflarınız puan getirmiyor. Editörlük ve hakemlik bölümünün büyük kısmı, '
    .'yarışma dereceleri, koleksiyon seçimleri ve mimari eser sınıfları kaynakta ayrılamadığı '
    .'için girilmedi. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünebilir: yönerge tez, proje ve idari görev '
    .'kalemlerinde yıl ve adet sınırı koyuyor ("yılda en fazla 3 öğrenci", "her yıl için"), '
    .'motor bu sınırları uygulamıyor. Mesleğe katkı, eğitim-öğretim ve üniversiteye hizmet '
    .'bölümlerinin kadroya bağlı tavanları da uygulanamıyor; profesörlük tavanı kullanıldı, '
    .'doçentlikte gevşek kalıyor.';

/**
 * Tablonun ham değerleri. Ondalıklı olanlar yönergede de ondalıklı; çarpan
 * uygulandıktan SONRA bir kez aşağı yuvarlanıyor.
 */
$ham = [
    // ══ A.1 ULUSLARARASI YAYINLAR ══
    'A.1.1.a' => [15.0, 'SSCI, AHCI veya SCI-Expanded kapsamındaki dergide yayımlanmış tam makale', 'makale', ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], ['ozgun_makale', 'derleme']],
    'A.1.1.b' => [3.0, 'SSCI, AHCI veya SCI-Expanded dergide editöre mektup, teknik not veya vaka incelemesi', 'makale', ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], ['kisa_makale', 'vaka_teknik_not']],
    'A.1.2.a' => [10.5, 'ESCI kapsamındaki dergide yayımlanmış tam makale', 'makale', ['ESCI / Scopus'], ['ozgun_makale', 'derleme']],
    'A.1.2.b' => [2.4, 'ESCI kapsamındaki dergide editöre mektup, teknik not veya vaka incelemesi', 'makale', ['ESCI / Scopus'], ['kisa_makale', 'vaka_teknik_not']],
    'A.1.3.a' => [9.0, 'Alan indeksinde taranan uluslararası dergide yayımlanmış tam makale', 'makale', ['Diğer Uluslararası İndeks'], ['ozgun_makale', 'derleme']],
    'A.1.3.b' => [1.8, 'Alan indeksli uluslararası dergide editöre mektup, teknik not veya vaka incelemesi', 'makale', ['Diğer Uluslararası İndeks'], ['kisa_makale', 'vaka_teknik_not']],
    'A.1.5.a' => [30.0, 'Uluslararası yayınevince basılan bilimsel kitap yazarlığı', 'kitap', ['BKCI / Scopus Kitap'], null],
    'A.1.5.b' => [12.0, 'Uluslararası yayınevince basılan bilimsel kitapta bölüm yazarlığı', 'kitap', ['BKCI / Scopus Kitap Bölümü'], null],
    'A.1.6.a' => [21.0, 'Uluslararası yayınevince basılan ders kitabı yazarlığı', 'kitap', ['Uluslararası Ders / Metot Kitabı'], null],

    // ══ A.2 ULUSAL YAYINLAR ══
    'A.2.1.a' => [6.0, 'Hakemli ulusal dergide yayımlanmış tam makale', 'makale', ['TR Dizin', 'Diğer Ulusal Hakemli'], ['ozgun_makale', 'derleme']],
    'A.2.1.b' => [1.0, 'Hakemli ulusal dergide editöre mektup, teknik not veya vaka incelemesi', 'makale', ['TR Dizin', 'Diğer Ulusal Hakemli'], ['kisa_makale', 'vaka_teknik_not']],
    'A.2.3.a' => [18.0, 'Ulusal yayınevince basılan bilimsel kitap yazarlığı', 'kitap', ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], null],
    'A.2.3.b' => [9.0, 'Ulusal yayınevince basılan bilimsel kitapta bölüm yazarlığı', 'kitap', ['Kitap Bölümü'], null],
    'A.2.5.a' => [9.0, 'Bilimsel, mesleki veya ders kitabının tüm çevirisi', 'kitap', ['Çeviri Kitap'], null],
    'A.2.5.b' => [3.0, 'Kitap bölümü çevirisi', 'kitap', ['Çeviri Kitap Bölümü'], null],
    'A.2.6.a' => [3.0, 'Uluslararası yayımlanan ansiklopedide konu veya madde yazarlığı', 'kitap', ['Ansiklopedi Maddesi'], null],

    // ══ A.3 TEBLİĞLER ══
    'A.3.1.a' => [7.5, 'Uluslararası toplantıda davetli olarak sunulan ve tam metin yayımlanan tebliğ', 'bildiri', ['Davetli Konuşmacı'], null],
    'A.3.1.b' => [3.0, 'Uluslararası toplantıda sözlü sunulan ve tam metin yayımlanan tebliğ', 'bildiri', ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], null],
    'A.3.1.c' => [1.5, 'Uluslararası toplantıda poster olarak sunulan ve yayımlanan tebliğ', 'bildiri', ['Uluslararası Özet/Poster'], null],
    'A.3.2.b' => [2.0, 'Ulusal toplantıda sözlü sunulan ve tam metin yayımlanan tebliğ', 'bildiri', ['Ulusal Tam Metin'], null],
    'A.3.2.c' => [1.0, 'Ulusal toplantıda poster olarak sunulan ve yayımlanan tebliğ', 'bildiri', ['Ulusal Özet/Poster'], null],

    // ══ A.4 ATIFLAR ══ (yönergede 0,6-2,4; aşağı yuvarlanınca bir kısmı 0)
    'A.4.a' => [2.4, 'Uluslararası kitaplarda eserlerinize yapılan her bir atıf', 'atif', ['BKCI Kitap'], null],
    'A.4.c' => [1.2, 'SSCI, SCI-Expanded veya AHCI dergilerinde eserlerinize yapılan her bir atıf', 'atif', ['WoS / Scopus'], null],
    'A.4.f' => [0.6, 'Hakemli ulusal dergilerde eserlerinize yapılan her bir atıf', 'atif', ['TR Dizin', 'Diğer', 'Patent'], null],

    // ══ A.5 PATENTLER ══
    'A.5.a' => [30.0, 'Alanında uluslararası tescillenmiş patent', 'patent', ['Uluslararası Patent', 'Ticarileştirme'], null],
    'A.5.b' => [18.0, 'Alanında ulusal tescillenmiş patent', 'patent', ['Ulusal Patent', 'Faydalı Model', 'Islahçı Hakkı / Çeşit Tescili'], null],

    // ══ B BİLİMSEL PROJE VE DANIŞMANLIK ══ (her yıl için)
    'B.1.a' => [15.0, 'Birleşmiş Milletler, Dünya Bankası veya AB destekli Ar-Ge projesinde yürütücülük (yıl başına)', 'proje', ['AB Çerçeve / Ufuk'], null, ['yurutucu']],
    'B.1.b' => [10.0, 'Birleşmiş Milletler, Dünya Bankası veya AB destekli Ar-Ge projesinde araştırıcılık (yıl başına)', 'proje', ['AB Çerçeve / Ufuk'], null, ['arastirmaci', 'danisman', 'bursiyer']],
    'B.2.a' => [12.0, 'Diğer uluslararası kurum destekli Ar-Ge projesinde yürütücülük (yıl başına)', 'proje', ['Diğer Uluslararası Fon'], null, ['yurutucu']],
    'B.2.b' => [8.0, 'Diğer uluslararası kurum destekli Ar-Ge projesinde araştırıcılık (yıl başına)', 'proje', ['Diğer Uluslararası Fon'], null, ['arastirmaci', 'danisman', 'bursiyer']],
    'B.3.a' => [12.0, 'TÜBİTAK, TÜBA veya bakanlık destekli Ar-Ge projesinde yürütücülük (yıl başına)', 'proje', ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], null, ['yurutucu']],
    'B.3.b' => [8.0, 'TÜBİTAK, TÜBA veya bakanlık destekli Ar-Ge projesinde araştırıcılık (yıl başına)', 'proje', ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], null, ['arastirmaci', 'danisman', 'bursiyer']],
    'B.4.a' => [5.0, 'Üniversite BAP projesinde yürütücülük (yıl başına)', 'proje', ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], null, ['yurutucu']],
    'B.4.b' => [3.0, 'Üniversite BAP projesinde araştırıcılık (yıl başına)', 'proje', ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], null, ['arastirmaci', 'danisman', 'bursiyer']],
    'B.5.a' => [4.0, 'Üniversite dışı Ar-Ge veya özgün tasarım projesinde yürütücülük (yıl başına)', 'proje', ['Özel Sektör / STK'], null, ['yurutucu']],
    'B.5.b' => [3.0, 'Üniversite dışı Ar-Ge veya özgün tasarım projesinde araştırıcılık (yıl başına)', 'proje', ['Özel Sektör / STK'], null, ['arastirmaci', 'danisman', 'bursiyer']],

    // ══ C TASARIM VE SANATSAL FAALİYETLER ══
    'C.1.a' => [12.0, 'Kamu veya özel kuruluş bünyesinde uygulanmış sanatsal tasarım', 'sanatsal_etkinlik', ['Uygulama Projesi — Müellif', 'Eserin Yayında Yer Alması / Satın Alınması'], null],
    'C.2.a' => [6.0, 'Bilimsel yayınla tescillenmiş bilimsel tasarım', 'sanatsal_etkinlik', ['Özgün Eser / Beste / Tasarım'], null],
    'C.3' => [6.0, 'TSE veya TPE tarafından tescillenmiş faydalı obje', 'patent', ['Endüstriyel Tasarım', 'Yazılım'], null],
    'C.4.a' => [12.0, 'Uluslararası boyutta performansa dayalı özgün kişisel ses veya görüntü kaydı', 'sanatsal_etkinlik', ['Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)'], null],
    'C.4.b' => [6.0, 'Uluslararası boyutta performansa dayalı karma kayıt', 'sanatsal_etkinlik', ['Karma Albüm / CD-DVD Katkısı'], null],

    // ══ D SERGİ / ETKİNLİK ══
    'D.1.a' => [18.0, 'Uluslararası özgün kişisel sanat etkinliği', 'sanatsal_etkinlik', ['Kişisel Etkinlik (Uluslararası)', 'Solistlik (Uluslararası)', 'Resital (Uluslararası)'], null],
    'D.1.b' => [9.0, 'Ulusal özgün kişisel sanat etkinliği', 'sanatsal_etkinlik', ['Kişisel Etkinlik (Ulusal)', 'Solistlik (Ulusal)', 'Resital (Ulusal)'], null],
    'D.2.a' => [4.5, 'Davetli veya yarışmalı uluslararası karma etkinlik', 'sanatsal_etkinlik', ['Karma/Jürili Etkinlik (Uluslararası)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], null],
    'D.2.b' => [3.0, 'Davetli veya yarışmalı ulusal karma etkinlik', 'sanatsal_etkinlik', ['Karma/Jürili Etkinlik (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Orkestra / Koro Üyeliği'], null],

    // ══ E ÖDÜL ══
    'E.1.a' => [30.0, 'TÜBA veya TÜBİTAK bilim ödülü', 'odul', ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], null],
    'E.1.b' => [24.0, 'Yurt dışı kurumlardan alınan bilim ödülü', 'odul', ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], null],
    'E.1.c' => [12.0, 'Yurt içi kamu kurumlarından alınan bilim ödülü', 'odul', ['Ulusal Bilim/Sanat Ödülü'], null],
    'E.3.d' => [2.0, 'Proje veya sanat yarışmasında derece ya da mansiyon', 'odul', ['Yarışma Derecesi / Mansiyon', 'Burs'], null],
    'E.2.e' => [2.0, 'Uluslararası proje veya sanat yarışmasında jüri üyeliği', 'sanatsal_etkinlik', ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], null],
    'E.3.e' => [1.0, 'Ulusal proje veya sanat yarışmasında jüri üyeliği', 'sanatsal_etkinlik', ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], null],

    // ══ F MESLEĞE KATKI ══ (profesörlük tavanı 30)
    'F.2.1.a' => [18.0, 'Uluslararası yayınevince yayımlanan kitabın editörlüğü', 'editorluk', ['BKCI Kitap'], null],
    'F.3.a' => [1.0, 'Dergi yayın kurulu üyeliği veya editörlüğü', 'editorluk', ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi', 'TR Dizin Dergi', 'Diğer Hakemli Dergi', 'Yayın Kurulu Üyeliği', 'Kitap Editörlüğü'], null],
    'F.3.b' => [1.0, 'Makale veya proje hakemliği', 'editorluk', ['Hakemlik'], null],
    // Kaynak F.1.1 (ULUSLARARASI kongre) ile F.1.2 (ULUSAL) bloklarını ayrı
    // puanlıyor: başkanlık 10/6 · düzenleme kurulu üyeliği 5/3 · bilim-danışma
    // kurulu üyeliği 1/1. `Düzenleme/Bilim Kurulu Üyeliği` etiketi ikisini
    // birden taşıdığı için her kapsamda 1. Önce başkanlık 6/6, üyelik 3/3
    // yazılmıştı: hem kapsam çökmüştü hem de üyelik bilim kurulu satırını
    // atlayıp fazla sayıyordu.
    'F.4.c' => [10.0, 'Uluslararası bilimsel toplantı düzenleme kurulu başkanlığı', 'diger', ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], null],
    'F.4.c.2' => [6.0, 'Ulusal bilimsel toplantı düzenleme kurulu başkanlığı', 'diger', ['Toplantı Düzenleme Başkanlığı (Ulusal)'], null],
    'F.4.d' => [1.0, 'Uluslararası bilimsel toplantı düzenleme, bilim ya da danışma kurulu üyeliği', 'diger', ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], null],
    'F.4.d.2' => [1.0, 'Ulusal bilimsel toplantı düzenleme, bilim ya da danışma kurulu üyeliği', 'diger', ['Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], null],

    // ══ G EĞİTİM-ÖĞRETİM ══ (profesörlük tavanı 20)
    'G.1.1.a' => [5.0, 'Doktora veya sanatta yeterlik tezi danışmanlığı (yıl başına)', 'tez_danismanligi', ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], null, ['danisman']],
    'G.1.1.c' => [2.0, 'Doktora veya sanatta yeterlik tezi eş danışmanlığı (yıl başına)', 'tez_danismanligi', ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], null, ['es_danisman']],
    'G.1.2.a' => [4.0, 'Yüksek lisans tezi danışmanlığı (yıl başına)', 'tez_danismanligi', ['Yüksek Lisans Tezi'], null, ['danisman']],
    'G.1.2.c' => [2.0, 'Yüksek lisans tezi eş danışmanlığı (yıl başına)', 'tez_danismanligi', ['Yüksek Lisans Tezi'], null, ['es_danisman']],
    'G.1.1.d' => [0.5, 'Tez savunma, izleme veya yeterlik jürisi üyeliği', 'tez_danismanligi', ['Tez İzleme / Jüri Üyeliği'], null],
    'G.2.a' => [2.0, 'Lisans veya ön lisans dersi (kodu farklı her ders için)', 'egitim_ogretim', ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], null],
    'G.2.b' => [3.0, 'Lisansüstü ders (kodu farklı her ders için)', 'egitim_ogretim', ['Lisansüstü Ders'], null],

    // ══ H ÜNİVERSİTEYE HİZMET ══ (profesörlük tavanı 20)
    'H.1.a' => [6.0, 'Enstitü müdürlüğü, dekan yardımcılığı, yüksekokul müdürlüğü veya bölüm başkanlığı (yıl başına)', 'idari_gorev', ['Dekan / Enstitü-YO Müdürü', 'Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkanı', 'Uygulama ve Araştırma Merkezi Müdürü'], null],
    'H.1.b' => [5.0, 'Müdür veya bölüm başkan yardımcılığı (yıl başına)', 'idari_gorev', ['Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük'], null],
    'H.2.g' => [1.0, 'Diğer aktif kurul, komisyon veya merkez üyelikleri', 'idari_gorev', ['Kurul / Komisyon Üyeliği'], null],
    // H.3.c — bölüm görevleri arasında. Akreditasyon koordinatörlüğü DERS
    // DEĞİL; etiket bir tur G.2.a ders satırında duruyordu.
    'H.3.c' => [3.0, 'Bölüm akreditasyon koordinatörlüğü', 'egitim_ogretim', ['Akreditasyon Faaliyeti'], null],
];

// Açıklama 2 — pay yazar SIRASINA bağlı, sayıya değil. Bütün roller
// `sonrasi` kullanıyor; `kademeler` bilinçli olarak boş.
$yazarKatsayisi = [
    // Açıklama 4: "Atıf faaliyet türünün puanlanmasında kişi sayısı dikkate
    // alınmaz." Açıklama 3'ün "%50" kuralı proje, ders, idari görev gibi
    // sıralaması olmayan kalemlere ait; motor kategori başına tek kural
    // tanıdığı için o kalemler çarpanın dışında bırakıldı.
    'haric' => ['atif', 'proje', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev',
        'editorluk', 'odul', 'toplumsal_katki'],
    'roller' => [
        'tek' => ['sonrasi' => 1.0],
        'ilk' => ['sonrasi' => 1.0],
        // "sorumlu yazar ve senyör yazar ile bildiriyi sunan isim için yazar
        // sırasına bakılmaksızın %100"
        'baslica' => ['sonrasi' => 1.0],
        'yazar_2' => ['sonrasi' => 0.9],
        'yazar_3' => ['sonrasi' => 0.8],
        'yazar_4' => ['sonrasi' => 0.7],
        'yazar_5' => ['sonrasi' => 0.5],
        'yazar_6' => ['sonrasi' => 0.5],
        // Sırasını belirtmeyen aday en düşük payı alır.
        'ortak' => ['sonrasi' => 0.5],
    ],
];

$gruplar = [
    'A.1' => ['A.1.*'],
    'A.1.1' => ['A.1.1.a', 'A.1.1.b'],
    'A.1.1-3' => ['A.1.1.a', 'A.1.2.a', 'A.1.3.a'],
    'A.2' => ['A.2.*'],
    'A.2.1' => ['A.2.1.a', 'A.2.1.b'],
    'A.1-A.2' => ['A.1.*', 'A.2.*'],
    'A.1-A.2.1' => ['A.1.*', 'A.2.1.a', 'A.2.1.b'],
    // Kadroya bağlı tavanları olan bölümler.
    'F' => ['F.*'],
    'G' => ['G.*'],
    'H' => ['H.*'],
];

// Profesörlük tavanları; doçentlikte yönerge yarısını istiyor ama tavan
// cetvele ait olduğu için kadroya göre değiştirilemiyor.
$tavanlar = ['F' => 30, 'G' => 20, 'H' => 20];

/**
 * Ham değerlerden bir cetvel üretir. `$carpan` A.1 ve B kalemlerine uygulanır
 * (yönergenin "1,3 katsayısı" notu); çarpımdan sonra bir kez aşağı yuvarlanır.
 *
 * @param  array<string, array{0: float, 1: string, 2: string, 3: list<string>, 4?: list<string>|null, 5?: list<string>}>  $ham
 * @return array<string, array<string, mixed>>
 */
$uret = function (array $ham, float $carpan): array {
    $maddeler = [];

    foreach ($ham as $kod => $satir) {
        [$puan, $baslik, $kategori, $kaynaklar] = $satir;
        $carpanli = str_starts_with($kod, 'A.1.') || str_starts_with($kod, 'B.');

        $madde = [
            'baslik' => $baslik,
            'kategori' => $kategori,
            'kaynaklar' => $kaynaklar,
            'puan' => (int) floor($puan * ($carpanli ? $carpan : 1.0)),
        ];

        if (($satir[4] ?? null) !== null) {
            $madde['turler'] = $satir[4];
        }

        if (($satir[5] ?? null) !== null) {
            $madde['roller'] = $satir[5];
        }

        $maddeler[$kod] = $madde;
    }

    return $maddeler;
};

return ['cetveller' => [
    // ══════════ Mühendislik Fakültesi ve Fizik Bölümü — çarpan yok ══════════
    'isik-2019' => [
        'kapsam_notu' => $kapsamNotu,
        'yazar_katsayisi' => $yazarKatsayisi,
        'maddeler' => $uret($ham, 1.0),
        'gruplar' => $gruplar,
        'grup_tavanlari' => $tavanlar,
    ],

    // ══════════ Diğer bütün birimler — A.1 ve B × 1,3 ══════════
    'isik-2019-carpanli' => [
        'kapsam_notu' => $kapsamNotu.' Biriminizde yönergenin "A.1 ve B grubu faaliyetler 1,3 '
            .'katsayısı ile çarpılarak değerlendirilir" kuralı geçerli; uluslararası yayın ve '
            .'proje puanlarınız bu çarpanla hesaplandı.',
        'yazar_katsayisi' => $yazarKatsayisi,
        'maddeler' => $uret($ham, 1.3),
        'gruplar' => $gruplar,
        'grup_tavanlari' => $tavanlar,
    ],
]];
