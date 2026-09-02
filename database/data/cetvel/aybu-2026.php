<?php

/**
 * ANKARA YILDIRIM BEYAZIT ÜNİVERSİTESİ — Tablo 1 Değerlendirmede
 * Kullanılacak Puanlar
 * Kaynak: pdf/1785505464273.Ankara Yıldırım Beyazıt Üniversitesi Kriteri
 * 16.07.2026 GK.pdf (Senato 06.05.2026, YÖK Genel Kurul onayı 16.07.2026)
 *
 * Madde kodları bize ait: Tablo 1 başlık ve bent harfleriyle çalışıyor,
 * satırlara kod vermiyor. "M." makale, "K." kitap, "P." proje, "B."
 * bildiri, "A." atıf, "E." eğitim, "T." tez, "D." editörlük-hakemlik,
 * "O." ödül, "PT." patent, "AO." alanlara özgü etkinlik, "DG." diğer
 * etkinlikler bölümünü gösteriyor.
 *
 * ── İKİ CETVEL VARYANTI: ALANLARA ÖZGÜ ETKİNLİK TAVANI ──
 * "Alanlara Özgü Etkinlik" başlığından Mimarlık, Planlama ve Tasarım ile
 * Güzel Sanatlar temel alanlarında en fazla 60, öbür alanlarda en fazla
 * 30 puan alınabiliyor. Tavan cetvel başına tanımlandığı için iki varyant
 * üretildi: `aybu-2026` (30) ve `aybu-2026-sanat` (60).
 *
 * ── AHCI VE ESCI Q4 SAYILIYOR ──
 * Makale başlığının (a) bendi WoS'un beş indeksini birden sayıyor ve
 * dipnotu "WoS'a girmiş fakat Q değeri belirlenmemiş dergilerde
 * yayımlanan makalelerin değeri Q4 olarak puanlanır" diyor. AHCI ile ESCI
 * çeyreklik taşımadığı için 10 puandan giriliyor. Zorunlu şartlar ise
 * AHCI'yi ve ESCI'yi "WoS Q1-Q3" kümesinin DIŞINDA, Scopus ve TR Dizin
 * ile aynı kümede sayıyor; gruplar buna göre kuruldu.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   Projelerde TÜBİTAK 1004 (40), 1001 ve benzeri (30) ile 1002-2209 ve
 *       benzeri (20) tek 'TÜBİTAK' etiketine düşüyor → 20/10/6/3. TÜSEB
 *       (d bendinde 30, e bendinde 25) → 25/15/10/5. BAP'ta ÖNAP-ÇAP-KAP
 *       (10/7/4) ile hızlı destek (8/4/2) → 8/4/2.
 *   Ödülde ulusal (5) ile uluslararası (10) bilim ödülü tek etikete
 *       düşenlerde düşük olan; kongre ödülünde 2, mimarlık yarışmasında 5.
 *   Editörlükte WoS-Scopus dergi editörlüğü (4) ile diğer indeks ve TR
 *       Dizin editörlüğü (2) ayrı satırlarda; 'Yayın Kurulu Üyeliği' ve
 *       'Hakemlik' etiketleri en düşük değerden (1) sayılıyor.
 *   Atıfta WoS-Scopus (2) ile diğer alan indeksleri (1) ve TR Dizin (1)
 *       ayrı; 'Diğer' etiketi 1 puandan.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   "Diğer Etkinlikler" başlığının h-indeksi bendi (h-indeksi kadar puan)
 *       — faaliyet değil profil ölçütü.
 *   Alanlara Özgü Etkinliğin spor bentleri (m, n: olimpiyat ve üniversite
 *       oyunlarında madalya), hizmet içi eğitim sertifikaları (ş, t),
 *       yurt dışı ziyaret (y) ve üniversite-sanayi danışmanlığı (v) —
 *       sözlükte karşılıksız ya da süre ölçütü.
 *   Diğer Etkinlikler başlığının standart hazırlama, firma sahipliği,
 *       TEKNOFEST danışmanlığı, millî takım görevi, bilirkişilik,
 *       arabuluculuk ve komisyon üyelikleri bentlerinin çoğu — sözlükte
 *       karşılıksız; toplumsal katkı ve idari görev satırlarında
 *       toplananlar girildi.
 *   Projelerde "eşik üzeri puan ile ret cevabı alan projelerde puanların
 *       %50'si" kuralı — kayıt reddedilmiş projeyi taşımıyor.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   Makale başlığının "iş birliği ile üretilen makalelere %25 ek puan"
 *       kuralı — kayıt ortak yazarların kurumunu taşımıyor.
 *   "Aynı toplantıda sunulan çoklu bildirilerde yalnızca ikisi
 *       puanlamaya dâhil edilir" kuralı.
 *   MADDE 11 ve 14'ün "kullanılacak puanların en az %75'i şu dönemden
 *       gelmelidir" oranları — motor toplamın bir ORANINI değil, sabit
 *       bir alt sınırı kontrol edebiliyor; yönergede bu koşullar asgari
 *       puanın %75'i olarak yazıldı.
 *   Yöneticilik puanının yıl başına hesaplanması.
 *
 * Yönerge: yonerge/aybu.php
 */
$TAM = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];
$AB = ['AB Çerçeve / Ufuk'];
$ULUSLARARASI = ['Diğer Uluslararası Fon'];
$KAMU = ['TÜSEB', 'Diğer Kamu Kurumu'];
$OZEL = ['Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'];
$BAP = ['BAP (Üniversite)'];

$maddeler = [
    // ══ MAKALE ══
    'M.a.q1' => ['baslik' => 'Web of Science kapsamında Q1 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $TAM, 'puan' => 30],
    'M.a.q2' => ['baslik' => 'Web of Science kapsamında Q2 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $TAM, 'puan' => 20],
    'M.a.q3' => ['baslik' => 'Web of Science kapsamında Q3 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $TAM, 'puan' => 15],
    'M.a.q4' => ['baslik' => 'Web of Science kapsamında Q4 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $TAM, 'puan' => 10],
    'M.a.ahci' => ['baslik' => 'AHCI kapsamındaki dergide yayımlanmış makale (Q değeri belirlenmemiş dergiler Q4 sayılır)', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => $TAM, 'puan' => 10],
    'M.b' => ['baslik' => 'SPORT Discus, Scopus ya da ESCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $TAM, 'puan' => 10],
    'M.c' => ['baslik' => 'TR Dizin kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TAM, 'puan' => 10],
    'M.d' => ['baslik' => 'Diğer uluslararası indekslerde taranan dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $TAM, 'puan' => 5],
    'M.e' => ['baslik' => 'İndeksli dergide yayımlanmış editöre mektup, editöryal, araştırma notu, teknik not, özet veya kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI', 'ESCI / Scopus', 'TR Dizin', 'Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 3],
    'M.f' => ['baslik' => 'Diğer hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => 4],
    'M.g' => ['baslik' => 'Diğer hakemli dergide yayımlanmış editöre mektup, araştırma notu, teknik not, özet veya kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 2],

    // ══ KİTAP ══
    'K.a' => ['baslik' => 'BKCI kapsamındaki kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 30],
    'K.b' => ['baslik' => 'BKCI kapsamındaki kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 15],
    'K.c' => ['baslik' => 'BKCI kapsamı dışında kalan diğer kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Çeviri Kitap'], 'puan' => 20],
    'K.d' => ['baslik' => 'BKCI kapsamı dışında kalan diğer kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi', 'Çeviri Kitap Bölümü'], 'puan' => 10],

    // ══ PROJELER ══
    'P.a.1' => ['baslik' => 'AB, NATO ya da NSF gibi uluslararası kuruluşlarca desteklenmiş araştırma projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => $AB, 'roller' => ['yurutucu'], 'puan' => 40],
    'P.a.2' => ['baslik' => 'AB, NATO ya da NSF gibi uluslararası kuruluşlarca desteklenmiş araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => $AB, 'roller' => ['arastirmaci'], 'puan' => 30],
    'P.a.3' => ['baslik' => 'AB, NATO ya da NSF gibi uluslararası kuruluşlarca desteklenmiş araştırma projesinde danışman olmak', 'kategori' => 'proje', 'kaynaklar' => $AB, 'roller' => ['danisman'], 'puan' => 20],
    'P.a.4' => ['baslik' => 'AB, NATO ya da NSF gibi uluslararası kuruluşlarca desteklenmiş araştırma projesinde bursiyer olmak', 'kategori' => 'proje', 'kaynaklar' => $AB, 'roller' => ['bursiyer'], 'puan' => 10],
    'P.b.1' => ['baslik' => 'Diğer uluslararası destekli bilimsel araştırma projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => $ULUSLARARASI, 'roller' => ['yurutucu'], 'puan' => 35],
    'P.b.2' => ['baslik' => 'Diğer uluslararası destekli bilimsel araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => $ULUSLARARASI, 'roller' => ['arastirmaci'], 'puan' => 25],
    'P.b.3' => ['baslik' => 'Diğer uluslararası destekli bilimsel araştırma projesinde danışman olmak', 'kategori' => 'proje', 'kaynaklar' => $ULUSLARARASI, 'roller' => ['danisman'], 'puan' => 18],
    'P.b.4' => ['baslik' => 'Diğer uluslararası destekli bilimsel araştırma projesinde bursiyer olmak', 'kategori' => 'proje', 'kaynaklar' => $ULUSLARARASI, 'roller' => ['bursiyer'], 'puan' => 9],
    'P.f.1' => ['baslik' => 'TÜBİTAK destekli bilimsel araştırma projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 20],
    'P.f.2' => ['baslik' => 'TÜBİTAK destekli bilimsel araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['arastirmaci'], 'puan' => 10],
    'P.f.3' => ['baslik' => 'TÜBİTAK destekli bilimsel araştırma projesinde danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['danisman'], 'puan' => 6],
    'P.f.4' => ['baslik' => 'TÜBİTAK destekli bilimsel araştırma projesinde bursiyer olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['bursiyer'], 'puan' => 3],
    'P.e.1' => ['baslik' => 'TÜBA, TÜSEB, bakanlık ya da eş değer üniversite dışı kurumlarca desteklenen projede yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => $KAMU, 'roller' => ['yurutucu'], 'puan' => 25],
    'P.e.2' => ['baslik' => 'TÜBA, TÜSEB, bakanlık ya da eş değer üniversite dışı kurumlarca desteklenen projede araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => $KAMU, 'roller' => ['arastirmaci'], 'puan' => 15],
    'P.e.3' => ['baslik' => 'TÜBA, TÜSEB, bakanlık ya da eş değer üniversite dışı kurumlarca desteklenen projede danışman olmak', 'kategori' => 'proje', 'kaynaklar' => $KAMU, 'roller' => ['danisman'], 'puan' => 10],
    'P.e.4' => ['baslik' => 'TÜBA, TÜSEB, bakanlık ya da eş değer üniversite dışı kurumlarca desteklenen projede bursiyer olmak', 'kategori' => 'proje', 'kaynaklar' => $KAMU, 'roller' => ['bursiyer'], 'puan' => 5],
    'P.g.1' => ['baslik' => 'Üniversiteler dışındaki özel kurumlarca desteklenen projede yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => $OZEL, 'roller' => ['yurutucu'], 'puan' => 20],
    'P.g.2' => ['baslik' => 'Üniversiteler dışındaki özel kurumlarca desteklenen projede araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => $OZEL, 'roller' => ['arastirmaci'], 'puan' => 10],
    'P.g.3' => ['baslik' => 'Üniversiteler dışındaki özel kurumlarca desteklenen projede danışman olmak', 'kategori' => 'proje', 'kaynaklar' => $OZEL, 'roller' => ['danisman'], 'puan' => 6],
    'P.g.4' => ['baslik' => 'Üniversiteler dışındaki özel kurumlarca desteklenen projede bursiyer olmak', 'kategori' => 'proje', 'kaynaklar' => $OZEL, 'roller' => ['bursiyer'], 'puan' => 3],
    'P.i.1' => ['baslik' => 'Üniversitenin BAP birimince desteklenen projede yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => $BAP, 'roller' => ['yurutucu'], 'puan' => 8],
    'P.i.2' => ['baslik' => 'Üniversitenin BAP birimince desteklenen projede araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => $BAP, 'roller' => ['arastirmaci', 'danisman'], 'puan' => 4],
    'P.i.3' => ['baslik' => 'Üniversitenin BAP birimince desteklenen projede bursiyer olmak', 'kategori' => 'proje', 'kaynaklar' => $BAP, 'roller' => ['bursiyer'], 'puan' => 2],

    // ══ BİLİMSEL TOPLANTI ══
    'B.a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulup tam metni CPCI\'da yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 5],
    'B.b' => ['baslik' => 'Diğer uluslararası ya da ulusal bilimsel toplantıda sunulup tam metni yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Ulusal Tam Metin', 'Davetli Konuşmacı'], 'puan' => 3],
    'B.c' => ['baslik' => 'Uluslararası ya da ulusal bilimsel toplantıda sunulan poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster', 'Ulusal Özet/Poster'], 'puan' => 1],

    // ══ ATIFLAR ══
    'A.a' => ['baslik' => 'SCI, SCI-Expanded, SSCI, AHCI, ESCI ya da Scopus kapsamında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 2],
    'A.c' => ['baslik' => 'TR Dizin kapsamındaki dergide ya da diğer yayınlarda yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer'], 'puan' => 1],
    'A.d' => ['baslik' => 'Kitaplarda yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
    'A.e' => ['baslik' => 'İncelemeli patent atıfları', 'kategori' => 'atif', 'kaynaklar' => ['Patent'], 'puan' => 3],

    // ══ EĞİTİM / ÖĞRETİM ══
    'E.a' => ['baslik' => 'Lisansüstü ya da uzmanlık dersi vermek (ders sayısı üzerinden)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 2],
    'E.b' => ['baslik' => 'Ön lisans ya da lisans dersi vermek (ders sayısı üzerinden)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 2],

    // ══ TEZ DANIŞMANLIĞI VE JÜRİ ÜYELİĞİ ══
    'T.a' => ['baslik' => 'Doktora, uzmanlık ya da sanatta yeterlik tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 10],
    'T.b' => ['baslik' => 'Doktora, uzmanlık ya da sanatta yeterlik tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 5],
    'T.c' => ['baslik' => 'Tezli yüksek lisans tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 8],
    'T.d' => ['baslik' => 'Tezli yüksek lisans tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 4],
    'T.f' => ['baslik' => 'Lisansüstü tez savunması jüri üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 1],

    // ══ EDİTÖRLÜK / HAKEMLİK ══
    'D.a' => ['baslik' => 'WoS ya da Scopus\'ta taranan dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 4],
    'D.b' => ['baslik' => 'Diğer indeksler ya da TR Dizin tarafından taranan dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 2],
    'D.b2' => ['baslik' => 'Dergilerde hakemlik ya da yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik', 'Yayın Kurulu Üyeliği'], 'puan' => 1],
    'D.g' => ['baslik' => 'Ulusal ya da uluslararası sanat ve tasarım etkinliklerinde hakemlik veya jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 1],
    'D.h' => ['baslik' => 'WoS ve Scopus kitap indekslerinde taranan kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 5],
    'D.h2' => ['baslik' => 'Diğer kitaplarda editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 2],

    // ══ ÖDÜL ══
    'O.a' => ['baslik' => 'TÜBİTAK Bilim, Özel, Hizmet ya da Teşvik Ödülü, TÜBA Akademi, GEBİP ve TESEP ödülleri, YÖK Üstün Başarı ve Bireysel Ödülleri', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 25],
    'O.b' => ['baslik' => 'Ulusal ya da uluslararası bilim ve sanat kurumlarınca verilen bilim, teşvik, sanat veya araştırma ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ulusal Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü', 'Burs'], 'puan' => 5],
    'O.d' => ['baslik' => 'Mimarlık, planlama ve tasarım ile güzel sanatlar alanındaki yarışmalarda derece veya mansiyon almak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 5],

    // ══ PATENT, FAYDALI MODEL VE TASARIM ══
    'PT.a' => ['baslik' => 'Alanında uluslararası tescillenmiş patent, faydalı model ya da tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
    'PT.b' => ['baslik' => 'Alanında ulusal tescillenmiş patent, faydalı model ya da tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili', 'Yazılım', 'Ticarileştirme'], 'puan' => 10],

    // ══ ALANLARA ÖZGÜ ETKİNLİK ══
    'AO.d' => ['baslik' => 'Sanat sergisi ya da özgün eser, proje ve tasarım sergisi açmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)'], 'puan' => 10],
    'AO.d2' => ['baslik' => 'Elektronik ortamda kişisel sergi açmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Elektronik Kişisel Sergi (Uluslararası)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 10],
    'AO.e' => ['baslik' => 'Ulusal ya da uluslararası tasarım', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman', 'Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)'], 'puan' => 2],
    'AO.f' => ['baslik' => 'Ulusal ya da uluslararası sergi, çalıştay, bienal, trienal, defile, gösteri, performans veya festival tarzındaki karma etkinlikte eseriyle yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Uluslararası)', 'Elektronik Karma Sergi (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 5],
    'AO.g' => ['baslik' => 'Alanıyla ilgili televizyon, radyo programı ya da podcast yayınlarına katılmak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Bilim İletişimi / Popüler Yayın'], 'puan' => 4],
    'AO.h' => ['baslik' => 'Alanıyla ilgili albüm yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)', 'Karma Albüm / CD-DVD Katkısı', 'Eğitim Müziği Albümü'], 'puan' => 2],
    'AO.l' => ['baslik' => 'Ulusal ya da uluslararası sanatsal bireysel veya karma etkinliklerde şef, sanat yönetmeni, solist ya da çalgı icracısı olarak yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Uluslararası)', 'Resital (Ulusal)', 'Solistlik (Uluslararası)', 'Solistlik (Ulusal)', 'Şan Resitali (Uluslararası)', 'Şan Resitali (Ulusal)', 'Oratoryo/Kantat Solistliği (Uluslararası)', 'Oratoryo/Kantat Solistliği (Ulusal)', 'Orkestra Şefliği (Uluslararası)', 'Orkestra Şefliği (Ulusal)', 'Opera Şefliği (Uluslararası)', 'Opera Şefliği (Ulusal)', 'Koro Şefliği (Uluslararası)', 'Koro Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Ulusal)', 'Grup Şefliği (Uluslararası)', 'Grup Şefliği (Ulusal)', 'Oda Müziği Grup Üyeliği (Uluslararası)', 'Oda Müziği Grup Üyeliği (Ulusal)', 'Orkestra / Koro Üyeliği', 'Başkemancılık (Uluslararası)', 'Başkemancılık (Ulusal)', 'Opera Birinci Rol (Uluslararası)', 'Opera Birinci Rol (Ulusal)', 'Opera İkinci Rol (Uluslararası)', 'Opera İkinci Rol (Ulusal)', 'Bale Başrol (Uluslararası)', 'Bale Başrol (Ulusal)', 'Bale Solist Rol (Uluslararası)', 'Bale Solist Rol (Ulusal)', 'Corps de Ballet (Uluslararası)', 'Corps de Ballet (Ulusal)', 'Dansçı / Performans İcracısı (Uluslararası)', 'Dansçı / Performans İcracısı (Ulusal)'], 'puan' => 5],
    'AO.i' => ['baslik' => 'Ulusal ya da uluslararası atölye çalışması, festival, bienal türü sanatsal etkinlik ve çalıştay düzenlemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Masterclass (Uluslararası)', 'Masterclass (Ulusal)', 'Eğitici Konser Programı (Uluslararası)', 'Eğitici Konser Programı (Ulusal)', 'Müzikoloji Atölyesi', 'Eğitim Amaçlı Sanat Etkinliği'], 'puan' => 5],
    'AO.o' => ['baslik' => 'Uygulanmış veya tamamlanmış tasarım, planlama ya da koruma projesi; yapı ve çevre tasarımı uygulama projesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif', 'Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Haber Olması (Uluslararası)', 'Eserin Haber Olması (Ulusal)'], 'puan' => 10],
    'AO.s' => ['baslik' => 'Sanatsal değeri olan beste, dijital platformlarda yayımlanmış en az otuz dakikalık ses veya video kaydı, sahne ve ekran yapıtı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera/Bale Kompozisyonu', 'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Orkestralı Sahne Eseri', 'Küçük Ölçekli Orkestra Eseri', 'Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Sahne/Ekran Müziği', 'Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)', 'Yönetmenlik (Sahne/Ekran)', 'Rejisörlük (Uluslararası)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Rejisör Yardımcılığı (Uluslararası)', 'Rejisör Yardımcılığı (Ulusal)', 'Rejisör Yardımcılığı (Konservatuvar)', 'Sahne Tasarımı (Dekor, Kostüm, Işık)', 'Koreografi', 'Tüm Perde Koreograflığı (Uluslararası)', 'Tüm Perde Koreograflığı (Ulusal)', 'Bölüm Koreograflığı (Uluslararası)', 'Bölüm Koreograflığı (Ulusal)', 'Bale/Dans Koreograflığı (Uluslararası)', 'Bale/Dans Koreograflığı (Ulusal)', 'Sahneleme/Repetitörlük — Tüm Perde (Uluslararası)', 'Sahneleme/Repetitörlük — Tüm Perde (Ulusal)', 'Sahneleme/Repetitörlük — Bölüm (Uluslararası)', 'Sahneleme/Repetitörlük — Bölüm (Ulusal)'], 'puan' => 10],

    // ══ DİĞER ETKİNLİKLER ══
    'DG.f' => ['baslik' => 'Topluma yönelik akademik ve sosyal sorumluluk çalışmaları, eğitimler ve projelerde yer almak; üniversite-toplum ya da üniversite-endüstri iş birliğinde görev almak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi', 'Kamu/STK Danışmanlığı'], 'puan' => 2],
    'DG.g' => ['baslik' => 'Ulusal ya da uluslararası bir bilimsel etkinliğin düzenleme veya bilimsel değerlendirme komitesinde yer almak', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 2],
    'DG.i' => ['baslik' => 'Üniversite birimlerinde yöneticilik, yönetici yardımcılığı ya da kurul, komisyon ve koordinatörlüklerde görev yapmak (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü', 'Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkanı', 'Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük', 'Kurul / Komisyon Üyeliği', 'Senato / Üniversite Yönetim Kurulu Üyesi', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 5],
];

$kodlar = fn (string $onek): array => array_values(array_filter(
    array_keys($maddeler),
    fn (string $kod): bool => str_starts_with($kod, $onek)
));

$gruplar = [
    // Zorunlu şartların atıf yaptığı kümeler.
    'WOS-Q1-Q2' => ['M.a.q1', 'M.a.q2'],
    'WOS-Q3' => ['M.a.q3'],
    'WOS-Q1-Q3' => ['M.a.q1', 'M.a.q2', 'M.a.q3'],
    'SCIE-SSCI' => ['M.a.q1', 'M.a.q2', 'M.a.q3', 'M.a.q4'],
    // "Scopus, SPORT Discus, ESCI, AHCI, ASCI veya TR Dizin dergileri".
    'SCOPUS-TR' => ['M.a.ahci', 'M.b', 'M.c'],
    'WOS-Q1-Q3-SCOPUS' => ['M.a.q1', 'M.a.q2', 'M.a.q3', 'M.b'],
    'PROJE' => $kodlar('P.'),
    // "Uluslararası bilimsel toplantıda sunulan (poster hariç) bildiri".
    'BILDIRI-TAM' => ['B.a', 'B.b'],
    'KITAP' => $kodlar('K.'),
    'MAKALE' => $kodlar('M.'),
    'ATIF' => $kodlar('A.'),
    'BILIMSEL-TOPLANTI' => $kodlar('B.'),
    'EGITIM' => $kodlar('E.'),
    'TEZ' => $kodlar('T.'),
    'EDITORLUK' => [...$kodlar('D.'), 'D.g'],
    'ODUL' => $kodlar('O.'),
    'PATENT' => $kodlar('PT.'),
    'ALANLARA-OZGU' => $kodlar('AO.'),
    // Bölüm tavanının (30/60) ALTINDA kendi tavanı olan satırlar.
    'AO.g' => ['AO.g'],
    'AO.h' => ['AO.h'],
    'AO.o' => ['AO.o'],
    'AO.s' => ['AO.s'],
    'DIGER' => $kodlar('DG.'),
    // MADDE 8'in yurt dışı deneyimi muafiyetinde sayılan kümeler.
    'MAKALE-PROJE-ATIF-KITAP-PATENT' => [...$kodlar('M.'), ...$kodlar('P.'), ...$kodlar('A.'),
        ...$kodlar('K.'), ...$kodlar('PT.')],
];

$grupTavanlari = [
    // Başlık düzeyi.
    'BILIMSEL-TOPLANTI' => 15,
    'ATIF' => 20,
    'EGITIM' => 20,
    'TEZ' => 20,
    'EDITORLUK' => 20,
    'ODUL' => 35,
    'DIGER' => 30,

    // Satır düzeyi: "Alanlara Özgü Etkinlikler" bölümünün dört satırı bölüm
    // tavanının (30/60) altında kendi tavanını taşıyor. Bölüm tavanı bunları
    // tek başına bağlamıyor — üç podcast katılımı (4 puan) 12 eder, bölüm
    // tavanına takılmadan satır tavanını aşar; kaynak 10'da kesiyor (§0).
    'AO.g' => 10,   // televizyon/radyo/podcast — "(En fazla 10 puan alınabilir)"
    'AO.h' => 10,   // albüm — "(En fazla 10 puan alınabilir)"
    'AO.o' => 10,   // uygulanmış/tamamlanmış proje — "(En fazla 10 puan)"
    'AO.s' => 20,   // beste, ses/video kaydı — "(En fazla 20 puan)"
];

$kapsamNotu = 'Puanlar Ankara Yıldırım Beyazıt Üniversitesi Akademik Yükseltilme ve Atanma '
    .'Kriterleri Yönergesinin Tablo 1 çizelgesinden (YÖK Genel Kurul onayı 16.07.2026). '
    .'Ortak çalışmalarda puan Tablo 2\'nin yazar sayısı × isim sırası matrisine göre '
    .'hesaplanıyor: iki yazarlı bir eserde birinci isim %95, ikinci %90; yedi ve daha fazla '
    .'yazarlıda birinci isim %70\'e, yedinci ve sonraki isimler %40\'a iner. Yazar listesini '
    .'boş bırakırsanız çarpan uygulanmaz ve puanınız olduğundan yüksek görünür. '
    .'Başlıkların çoğunda azami puan var: ödül 35, diğer etkinlikler 30, atıf, eğitim-öğretim, '
    .'tez danışmanlığı ve editörlük 20\'şer, bilimsel toplantı 15 puan. Alanlara özgü '
    .'etkinliklerden Mimarlık ve Güzel Sanatlarda 60, öbür alanlarda 30 puan alınabiliyor. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: "iş birliği ile üretilen makalelere %25 '
    .'ek puan" kuralı kayıt ortak yazarların kurumunu taşımadığı için uygulanmıyor; TÜBİTAK '
    .'projelerinde 1004 (40) ve 1001 (30) satırları 1002-2209 satırından (20) ayrılamadığı için '
    .'düşük olan uygulanıyor; BAP projelerinde de düşük satır geçerli; h-indeksi puanı, spor '
    .'madalyaları, hizmet içi eğitim sertifikaları ve yurt dışı ziyaret satırları faaliyet '
    .'olarak kaydedilemediği için girilmedi. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünür: "aynı toplantıda en fazla iki bildiri" '
    .'kuralı ve yöneticilik puanının yıl başına hesaplanması uygulanamıyor.';

// Tablo 2: Ortak Çalışmalar İçin Puan Dağılımı. Yazar sayısı × isim sırası.
$yazarKatsayisi = [
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.00]],
        'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.95, 3 => 0.90, 4 => 0.85, 5 => 0.80,
            6 => 0.75], 'sonrasi' => 0.70],
        'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.95, 3 => 0.90, 4 => 0.85, 5 => 0.80,
            6 => 0.75], 'sonrasi' => 0.70],
        'yazar_2' => ['kademeler' => [2 => 0.90, 3 => 0.85, 4 => 0.80, 5 => 0.75, 6 => 0.70],
            'sonrasi' => 0.65],
        'yazar_3' => ['kademeler' => [3 => 0.80, 4 => 0.75, 5 => 0.70, 6 => 0.65],
            'sonrasi' => 0.60],
        'yazar_4' => ['kademeler' => [4 => 0.70, 5 => 0.65, 6 => 0.60], 'sonrasi' => 0.55],
        'yazar_5' => ['kademeler' => [5 => 0.60, 6 => 0.55], 'sonrasi' => 0.50],
        'yazar_6' => ['kademeler' => [6 => 0.50], 'sonrasi' => 0.45],
        // Sırasını belirtmeyen aday için o yazar sayısındaki en düşük satır.
        'ortak' => ['kademeler' => [2 => 0.90, 3 => 0.80, 4 => 0.70, 5 => 0.60, 6 => 0.50],
            'sonrasi' => 0.40],
    ],
];

$cetvel = fn (int $alanTavani): array => [
    'kapsam_notu' => $kapsamNotu,
    'yazar_katsayisi' => $yazarKatsayisi,
    'maddeler' => $maddeler,
    'gruplar' => $gruplar,
    'grup_tavanlari' => [...$grupTavanlari, 'ALANLARA-OZGU' => $alanTavani],
];

return ['cetveller' => [
    'aybu-2026' => $cetvel(30),
    'aybu-2026-sanat' => $cetvel(60),
]];
