<?php

/**
 * İSTANBUL ATLAS ÜNİVERSİTESİ — EK-1 Akademik Atama ve Yükseltme
 * Ölçütleri Puan Tablosu
 * Kaynak: pdf/1778824161643.istanbul-atlas-kriter-15052026.pdf (13 sayfa)
 *
 * Madde kodları tablonun kendi kodları (1.1.a, 2.1.c, 3.4.d).
 *
 * ── EN ÇOK PUAN KAYBETTİREN KARARLAR ──
 *   ATIF BÖLÜMÜ NEREDEYSE BOŞ. 1.4.a Scopus atıflarına atıf başına 0,5
 *       puan veriyor; motorun puan alanı tam sayı tuttuğu için satır
 *       girilemedi. Yalnız 1.4.b (patent atfı, 5) girildi. Yüz atfınız
 *       varsa 50 puan kaybınız var.
 *   TÜBİTAK PROJELERİ 10 PUANDAN SAYILIYOR. 2.1.c ARDEB, TEYDEB ve Kamu
 *       Ar-Ge projelerinde yürütücüye 60 puan verirken 2.1.e TÜBİTAK
 *       1002 ve Bilim-Toplum projelerinde 10 veriyor. Kayıt ikisini
 *       ayırmadığı (tek "TÜBİTAK" etiketi var) için §0 uyarınca en düşük
 *       satır alındı: yürütücü 10, araştırmacı 5. ARDEB yürütücülüğünüz
 *       varsa puanınız OLDUĞUNDAN ÇOK DÜŞÜK görünür.
 *   1.5 BİLİMSEL TOPLANTI DÜZENLEME (organizasyon başkanlığı 10 ve 5,
 *       komite üyeliği 2 ve 1) GİRİLMEDİ: kayıtta bu görevlerin etiketi
 *       yok. Aynı sebeple dergi HAKEMLİĞİ ve YAYIN KURULU ÜYELİĞİ için
 *       de tabloda satır yok.
 *   1.2.n (İstanbul Atlas Üniversitesi dergilerinde yayın, 15) ve 2.4.a
 *       (Scopus h-indeksi, değer başına 2) girilmedi; ilki kurumun kendi
 *       dergisini ayırt eden bir etiket istiyor, ikincisi profil ölçütü.
 *   PATENT BAŞVURULARI (uluslararası 30, ulusal 20) girilmedi; kayıt
 *       başvuruyu tescilden ayırmıyor ve girilseydi motor en yükseği
 *       seçip başvuru sahibini tescil sahibi gibi sayardı.
 *   LİSANSÜSTÜ TEZDEN ÜRETİLMİŞ YAYIN, İDARİ GÖREV ve TOPLUMSAL KATKI
 *       kategorilerinin tabloda hiç karşılığı yok.
 *   4.1 ders puanı GÜZ VE BAHAR YARIYILLARI TOPLAM HAFTALIK DERS SAATİ
 *       başına veriliyor; kayıt ders saatini tutmadığı için ders başına
 *       tek puan sayılıyor. Açıklamalardaki "son bir yıl" kısıtı da satır
 *       bazlı olduğu için uygulanamıyor.
 *
 * ── AYNI ETİKETE DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   1.6.a baş editörlük (Scopus 50) ile 1.6.b editörlük/yardımcı
 *       editörlük (30) tek etikete düşüyor: 30'dan sayılıyor. Aynı
 *       durum ULAKBİM (20/10) ve diğer dergiler (20/10, 10/5) için de
 *       geçerli; hepsinde düşük olan alındı.
 *   Uluslararası çeviri kitap (40) ile ulusal çeviri kitap (20), bölüm
 *       çevirisinde 10 ile 5 tek etikette: 20 ve 5.
 *   Bildirilerde sözlü/poster ve tam metin/özet ayrımının dördü tek
 *       "Özet/Poster" etiketine düşüyor; uluslararasıda 2, ulusalda 1.
 *   3.3 tasarım ürünü uluslararası 45 / ulusal 30: 30.
 *   3.4.a orta-uzun metrajlı film yönetmenliği (45) ile 3.4.b kısa
 *       metrajlı (30) tek etikette: 30.
 *   AHCI kapsamındaki dergilerin tabloda satırı yok (tablo Scopus
 *       merkezli); AHCI makaleleri "diğer uluslararası hakemli dergi"
 *       satırından (7) sayılıyor.
 *
 * ── YAZAR ÇARPANINDA BİLİNÇLİ SAPMA ──
 * Açıklamalar çarpanı esere göre ayırıyor: MAKALEDE tek yazar tam puan,
 * iki yazarlıda başlıca yazar 0,8 ikinci yazar 0,5, üç ve daha fazlada
 * başlıca yazar yarısını alıp kalan yarı diğerlerine eşit bölünüyor;
 * KİTAP, BİLDİRİ ve SANATSAL ETKİNLİKTE ise puan daima eşit bölünüyor.
 * Motorun yazar tablosu kategori ayrımı taşımadığı için makale kuralı
 * bütün kategorilere uygulandı. Çok yazarlı bir kitapta ya da sergide
 * ilk isimseniz puanınız OLDUĞUNDAN YÜKSEK görünür.
 *
 * Yönerge: yonerge/istanbul-atlas.php
 */
$OZGUN = ['ozgun_makale'];
$KISA_HEPSI = ['derleme', 'kisa_makale', 'vaka_teknik_not'];
$ULUSLARARASI_PROJE = ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'];
$TUBITAK = ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'];

$maddeler = [
    // ══ 1.1 KİTAPLAR ══
    '1.1.a' => ['baslik' => 'Uluslararası yayımlanmış yabancı dilde kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 120],
    '1.1.b' => ['baslik' => 'Ulusal tanınmış yayınevince yayımlanmış kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı', 'Tahkik (Tenkitli Metin)'], 'puan' => 60],
    '1.1.c' => ['baslik' => 'Uluslararası yayımlanmış kitapta yabancı dilde bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 15],
    '1.1.e' => ['baslik' => 'Yayımlanmış çeviri kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 20],
    '1.1.i' => ['baslik' => 'Ulusal tanınmış yayınevince yayımlanmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 6],
    '1.1.j' => ['baslik' => 'Yayımlanmış çeviri kitapta bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 5],
    '1.1.g' => ['baslik' => 'Uluslararası yayımlanmış yabancı dilde kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 30],
    '1.1.h' => ['baslik' => 'Ulusal tanınmış yayınevince yayımlanmış kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 10],

    // ══ 1.2 MAKALELER ══
    '1.2.a' => ['baslik' => 'Q1 kategorisindeki dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $OZGUN, 'puan' => 60],
    '1.2.b' => ['baslik' => 'Q2 kategorisindeki dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $OZGUN, 'puan' => 45],
    '1.2.c' => ['baslik' => 'Q3 kategorisindeki dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $OZGUN, 'puan' => 30],
    '1.2.d' => ['baslik' => 'Q4 kategorisindeki dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $OZGUN, 'puan' => 15],
    '1.2.e' => ['baslik' => 'Q1 kategorisindeki dergide derleme, teknik not, vaka analizi, editöre mektup ya da araştırma notu', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $KISA_HEPSI, 'puan' => 20],
    '1.2.f' => ['baslik' => 'Q2 kategorisindeki dergide derleme, teknik not, vaka analizi, editöre mektup ya da araştırma notu', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $KISA_HEPSI, 'puan' => 15],
    '1.2.g' => ['baslik' => 'Q3 kategorisindeki dergide derleme, teknik not, vaka analizi, editöre mektup ya da araştırma notu', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $KISA_HEPSI, 'puan' => 10],
    '1.2.h' => ['baslik' => 'Q4 kategorisindeki dergide derleme, teknik not, vaka analizi, editöre mektup ya da araştırma notu', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $KISA_HEPSI, 'puan' => 5],
    '1.2.i' => ['baslik' => 'Scopus veri tabanında taranan ancak çeyreklik değeri olmayan dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $OZGUN, 'puan' => 10],
    '1.2.j' => ['baslik' => 'Scopus veri tabanında taranan ancak çeyreklik değeri olmayan dergide derleme, teknik not, vaka analizi ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $KISA_HEPSI, 'puan' => 3],
    '1.2.k' => ['baslik' => 'Diğer uluslararası hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'AHCI'], 'puan' => 7],
    '1.2.l' => ['baslik' => 'TR Dizin tarafından taranan ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 10],
    '1.2.m' => ['baslik' => 'Diğer ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 7],

    // ══ 1.3 BİLDİRİLER ══
    '1.3.a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan, tam metni bildiri kitapçığında yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 6],
    '1.3.d' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan, özeti ya da posteri bildiri kitapçığında yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 2],
    '1.3.e' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan, tam metni bildiri kitapçığında yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 4],
    '1.3.h' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan, özeti ya da posteri bildiri kitapçığında yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster', 'Davetli Konuşmacı'], 'puan' => 1],

    // ══ 1.4 ATIFLAR ══
    '1.4.b' => ['baslik' => 'Scopus veri tabanındaki patentlerde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Patent'], 'puan' => 5],

    // ══ 1.6 EDİTÖRLÜK ══
    '1.6.b' => ['baslik' => 'Scopus veri tabanı kapsamındaki dergilerde editörlük ya da editör yardımcılığı', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 30],
    '1.6.d' => ['baslik' => 'ULAKBİM tarafından taranan dergilerde editörlük ya da editör yardımcılığı', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 10],
    '1.6.h' => ['baslik' => 'Diğer hakemli dergilerde editörlük ya da editör yardımcılığı', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 5],

    // ══ 2.1 ARAŞTIRMA PROJELERİ ══
    '2.1.a' => ['baslik' => 'Uluslararası destekli bilimsel araştırma projesinde yürütücü ya da koordinatör olmak', 'kategori' => 'proje', 'kaynaklar' => $ULUSLARARASI_PROJE, 'roller' => ['yurutucu'], 'puan' => 100],
    '2.1.b' => ['baslik' => 'Uluslararası destekli bilimsel araştırma projesinde araştırmacı ya da danışman olmak', 'kategori' => 'proje', 'kaynaklar' => $ULUSLARARASI_PROJE, 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 50],
    '2.1.e' => ['baslik' => 'TÜBİTAK ya da TÜSEB projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => $TUBITAK, 'roller' => ['yurutucu'], 'puan' => 10],
    '2.1.f' => ['baslik' => 'TÜBİTAK ya da TÜSEB projesinde araştırmacı veya danışman olmak', 'kategori' => 'proje', 'kaynaklar' => $TUBITAK, 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 5],
    '2.1.g' => ['baslik' => 'Üniversite-sanayi-kamu iş birliği (kontratlı Ar-Ge) projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 15],
    '2.1.h' => ['baslik' => 'Üniversite-sanayi-kamu iş birliği (kontratlı Ar-Ge) projesinde araştırmacı veya danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 5],

    // ══ 2.2 FİKRİ SINAİ MÜLKİYET HAKLARI ══
    '2.2.a' => ['baslik' => 'Tescil işlemleri tamamlanmış uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 120],
    '2.2.b' => ['baslik' => 'Tescil işlemleri tamamlanmış ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 80],
    '2.2.c' => ['baslik' => 'Tescil işlemleri tamamlanmış faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 50],
    '2.2.d' => ['baslik' => 'Tescil işlemleri tamamlanmış endüstriyel tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım'], 'puan' => 30],

    // ══ 2.3 BİLİMSEL ÖDÜLLER ══
    '2.3.a' => ['baslik' => 'Uluslararası bilimsel kuruluşlarca verilen bilim ya da sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 50],
    '2.3.b' => ['baslik' => 'TÜBİTAK, TÜBA ya da Yükseköğretim Kurulu tarafından verilen bilim ödülü (yayın teşvik ödülü hariç)', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 100],

    // ══ 3.1 SANATSAL TOPLANTI ══
    '3.1.a' => ['baslik' => 'Uluslararası bireysel sanat etkinliği (sergi, bienal, gösteri, dinleti, festival, gösterim)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)'], 'puan' => 60],
    '3.1.c' => ['baslik' => 'Ulusal bireysel sanat etkinliği (sergi, bienal, gösteri, dinleti, festival, gösterim)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 30],
    '3.1.b' => ['baslik' => 'Uluslararası karma ya da ortak sanat etkinliğine katılmak veya eserinizin kamusal alanda sergilenmesi ya da satın alınması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Karma Sergi (Uluslararası)'], 'puan' => 15],
    '3.1.e' => ['baslik' => 'Ulusal karma ya da ortak sanat etkinliğine katılmak veya eserinizin kamusal alanda sergilenmesi ya da satın alınması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Ulusal)', 'Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)'], 'puan' => 10],
    '3.1.d' => ['baslik' => 'Uluslararası seçici kurulu bulunan sergi, sempozyum, festival, workshop ya da bienale eserlerinizle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 15],
    '3.1.f' => ['baslik' => 'Ulusal seçici kurulu bulunan sergi, sempozyum, festival, workshop ya da bienale eserlerinizle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 10],

    // ══ 3.2 MÜZE VE KOLEKSİYONLAR ══
    '3.2.a' => ['baslik' => 'Yurt dışı tanınmış müze ya da büyük koleksiyonlarda yapıtınızın yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)'], 'puan' => 30],
    '3.2.b' => ['baslik' => 'Yurt içi tanınmış müze ya da büyük koleksiyonlarda yapıtınızın yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)'], 'puan' => 20],

    // ══ 3.3 TASARIM ÜRÜNÜ — 3.4 GÖSTERİ VE FİLM ══
    '3.3.b' => ['baslik' => 'Tasarım alanında üretime girmiş çalışma ya da koleksiyon', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım', 'Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip'], 'puan' => 30],
    '3.4.b' => ['baslik' => 'Film festivaline kabul edilen belgesel, kurmaca ya da deneysel bir filmin yönetmenliğini yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)'], 'puan' => 30],
    '3.4.c' => ['baslik' => 'Filmin görüntü ya da sanat yönetmenliğini yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Yönetmenlik (Sahne/Ekran)'], 'puan' => 20],
    '3.4.d' => ['baslik' => 'Sahne sanatları, radyo, televizyon ya da sinema alanında yayımlanmış veya sahnelenmiş bir metnin yazarlığını yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'], 'puan' => 10],

    // ══ 4.1 DERS VERME — 4.2 TEZ DANIŞMANLIĞI ══
    '4.1.a' => ['baslik' => 'Ön lisans ya da lisans düzeyinde teorik ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi', 'Akreditasyon Faaliyeti'], 'puan' => 2],
    '4.1.b' => ['baslik' => 'Lisansüstü düzeyde teorik ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
    '4.2.a' => ['baslik' => 'Yüksek lisans tezi yönetmek', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 2],
    '4.2.b' => ['baslik' => 'Doktora tezi yönetmek', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 4],
];

$onek = function (array $maddeler, string ...$onekler): array {
    return array_values(array_filter(
        array_keys($maddeler),
        function (string $kod) use ($onekler): bool {
            foreach ($onekler as $baslangic) {
                if (str_starts_with($kod, $baslangic)) {
                    return true;
                }
            }

            return false;
        }
    ));
};

return [
    'kapsam_notu' => 'Puanlar İstanbul Atlas Üniversitesi Akademik Atama ve Yükseltme Ölçütleri '
        .'Puan Tablosundan (EK-1). Yazar çarpanı: tek yazarlı makalede tam puan, iki yazarlıda '
        .'başlıca yazar 0,8 ikinci yazar 0,5; üç ve daha fazla yazarlıda başlıca yazar puanın '
        .'yarısını, diğerleri kalan yarıyı eşit paylaşır. Yazar listesini boş bırakırsanız çarpan '
        .'hiç uygulanmaz ve puanınız olduğundan YÜKSEK görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: Scopus ATIFLARI (atıf başına 0,5) '
        .'ondalık olduğu için girilemedi, yalnız patent atfı (5) sayılıyor; TÜBİTAK projeleri 10 '
        .'puandan sayılıyor çünkü tablo ARDEB ve TEYDEB projelerine 60, 1002 ve Bilim-Toplum '
        .'projelerine 10 verirken kayıt ikisini ayırmıyor; bilimsel toplantı düzenleme, dergi '
        .'hakemliği, yayın kurulu üyeliği, üniversitenin kendi dergilerindeki yayınlar (15) ve '
        .'h-indeksi (değer başına 2) için satır girilmedi; patent BAŞVURULARI (30 ve 20) '
        .'tescilliden ayrılamadığı için girilmedi; lisansüstü tezden üretilmiş yayın, idari görev '
        .'ve toplumsal katkı kategorilerinin tabloda karşılığı yok. Baş editörlük (50\'ye kadar), '
        .'uluslararası çeviri kitap (40), orta-uzun metrajlı film yönetmenliği (45) ve tam '
        .'metinli sözlü bildiri özet-posterden ayrılamayan kısımları en düşük satırlarından '
        .'sayılıyor. Ders puanı haftalık ders SAATİ başına verildiği hâlde ders başına tek puan '
        .'sayılıyor; açıklamalardaki "son bir yıl" kısıtı da uygulanamıyor. '
        .'Puanınız şu kalemde OLDUĞUNDAN YÜKSEK görünebilir: tablo kitap, bildiri ve sanatsal '
        .'etkinlikte puanı daima eşit bölüyor, motor ise makale kuralını (başlıca yazara 0,8 ve '
        .'yarı pay) bütün kategorilere uyguluyor.',

    'yazar_katsayisi' => [
        'haric' => ['atif', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev', 'odul',
            'editorluk', 'toplumsal_katki', 'proje', 'patent', 'diger'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.80], 'sonrasi' => 0.50],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.80], 'sonrasi' => 0.50],
            'ortak' => ['kademeler' => [1 => 1.00], 'bol' => ['pay' => 0.50, 'eksi' => 1]],
        ],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        'TUM' => array_keys($maddeler),
        // MADDE 5: "1.1. Kitaplar ve 1.2. Makaleler başlığı maddeleri".
        'KITAP-MAKALE' => $onek($maddeler, '1.1.', '1.2.'),
        // MADDE 5/b: "Sanatsal Faaliyetler bölümü".
        'SANAT' => $onek($maddeler, '3.'),
        // MADDE 5/b: "Bilimsel Yayın ve Faaliyetler, Araştırma ve
        // Yenilikçilik Faaliyetleri ve Eğitim ve Öğretim Faaliyetleri".
        'BILIMSEL' => $onek($maddeler, '1.', '2.', '4.'),
    ],

    'grup_tavanlari' => [],
];
