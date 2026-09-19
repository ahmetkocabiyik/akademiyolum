<?php

/**
 * BAŞKENT ÜNİVERSİTESİ — EK-1 Genel Puanlama Çizelgesi ve EK-2 Sanat Alanı
 * Puanlama Çizelgesi
 * Kaynak: pdf/17537097092.baskentuniversitesi.pdf
 *
 * Madde kodları çizelgelerin sıra numaraları; başlarındaki M harfi bize ait
 * (PHP salt sayısal dizi anahtarlarını tam sayıya çeviriyor). 1. maddenin
 * çeyrekliğe göre bölünmüş .a ve .b alt kodları ile 13. maddenin editörlük
 * ve çeviri ayrımı da bize ait.
 *
 * ── ÇEYREKLİK PRİMİ CETVELE GÖMÜLDÜ ──
 * [3] numaralı dipnot "Web of Science Incites kapsamında taranan Q1, Q2
 * veya Q3 kategorisindeki dergilerde yayım için kabul edilen makalelerden
 * ham puandan %50 daha fazla puan alınır" diyor. Çeyreklik kayıtta
 * taşındığı için prim satıra gömüldü: Q1-Q3 makaleler 450, Q4 makaleler
 * 300 puan. AHCI dergileri çeyreklik taşımadığı için 300 puandan sayılıyor.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   Atıfta 14. madde (SCI/SSCI/AHCI, 20) ile 15. madde (WoS Core
 *       Collection veya SCOPUS, 12) tek 'WoS / Scopus' etiketine düşüyor
 *       → 12.
 *   Girişimde 30. madde (teknopark şirketi, 300) ile 33 ve 34. maddeler
 *       (patenti ticarileştirmek, 1000 ve 750) tek 'Ticarileştirme'
 *       etiketine düşüyor → 300. Faydalı model yurt dışında 1000, yurt
 *       içinde 750 → 750.
 *   Görsel ve işitsel kayıtlarda uluslararası (190) ile ulusal (70) → 70.
 *   Sanat yarışmalarında uluslararası derece (150) ile ulusal derece (75)
 *       tek 'Yarışma Derecesi / Mansiyon' etiketine düşüyor → 75.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   SCI, SCI-Expanded, SSCI ve AHCI dergilerindeki vaka takdimi, editöre
 *       mektup, özet ve kitap kritikleri — 1 ve 2. maddeler bunları
 *       AÇIKÇA dışlıyor ve çizelgede karşılıkları yok.
 *   39. madde (yurt dışında kesintisiz en az üç ay görev almak, 100 puan)
 *       — faaliyet değil süre ölçütü.
 *   ESCI, Scopus, TR Dizin ve diğer hakemli dergilerde EDİTÖRLÜK —
 *       çizelge yalnız SCI, SCI-Expanded, SSCI ve AHCI editörlüğünü
 *       (38. madde) ve bu dergilerle ESCI-Scopus'ta yayın kurulu üyeliğini
 *       (37. madde) puanlıyor. Hakemlik satırı da yok.
 *   Tez danışmanlığı, ders verme ve idari görevler — çizelgede hiç yok.
 *   55. madde (sanat eserlerine yapılan atıf, 3 puan) — EK-1'in atıf
 *       satırlarından ayrılamıyor.
 *   Sanat ve tasarım etkinliklerinde jüri üyeliği — çizelgede karşılığı
 *       yok.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   [2] yurt dışı kurumlardan akademisyenlerle ortak çalışmalara verilen
 *       %50 prim — kayıt ortak yazarların kurumunu taşımıyor.
 *   [4] genişletilmiş yeniden baskılara ham puanın %30'u.
 *   [5] projenin Ar-Ge (%50), girişimcilik (%50), danışmanlık (%30) ya da
 *       eğitim projesi (%30) olmasına ve grupta uluslararası araştırmacı
 *       bulunmasına (%20) verilen primler.
 *   [6] uluslararası kitap ve kitap bölümünün WoS Core Collection ya da
 *       SCOPUS kapsamında taranmasına verilen %50 prim.
 *   9 ve 12. maddelerin "aynı kitaptaki bölümlerden en fazla ikisinden
 *       puan alınabilir" sınırı.
 *
 * Yönerge: yonerge/baskent.php
 *
 * KODLAR BİZE AİT — KAYNAKTA SATIR KODU YOK. Cetvel kodlarının SAYISAL
 * ÇEKİRDEĞİ kaynağın madde/bölüm numarasıdır; baştaki harf tabloyu ya da
 * eki, sondaki harf şıkkı gösterir ve ikisi de bizim eklediğimiz parçadır.
 * Koşullar bu kodlara atıf yaptığı için değiştirilmemeli; kaynakla
 * karşılaştırırken kodun sayısal çekirdeğine bakılmalı.
 *
 * DİL KOŞULU SATIR SEÇİMİNİ DEĞİŞTİRMİYOR (19.09.2026, kullanıcı kararı): üst
 * satırın dil koşulu kayıttan okunamıyor ama alt satır ULUSAL yayınevine ait;
 * kapsam etiketi kendi kapsamının satırına bağlandı, ulusal satırlar
 * daraltıldı.
 *
 * Kaynağın dipnot [6]'sı "uluslararası kitap veya kitap bölümü WoS Core
 * Collection ya da SCOPUS kapsamında taranıyorsa ham puandan %50 daha fazla"
 * diyor; bu prim UYGULANMIYOR — BKCI/Scopus etiketi de aynı satırdan sayılıyor,
 * yani indeksli kitabınız olduğundan düşük görünür.
 */
$TAM = ['ozgun_makale', 'derleme', 'kisa_makale'];
$WOS_Q13 = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)'];
$ULUSLARARASI_FON = ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'];
$KAMU_FON = ['TÜSEB', 'Diğer Kamu Kurumu'];
$BAP_FON = ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'];

$maddeler = [
    // ══ EK-1 YAYIN / MAKALE ══
    'M1.a' => ['baslik' => 'SCI, SCI-Expanded ya da SSCI kapsamında Q1, Q2 veya Q3 kategorisindeki dergide yayımlanmış makale (çeyreklik primiyle)', 'kategori' => 'makale', 'kaynaklar' => $WOS_Q13, 'turler' => $TAM, 'puan' => 450],
    'M1.b' => ['baslik' => 'SCI, SCI-Expanded ya da SSCI kapsamında Q4 kategorisindeki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $TAM, 'puan' => 300],
    'M2' => ['baslik' => 'AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => $TAM, 'puan' => 300],
    'M3' => ['baslik' => 'Web of Science Core Collection ya da SCOPUS veri tabanında taranan dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'kisa_makale'], 'puan' => 170],
    'M4' => ['baslik' => 'Web of Science Core Collection ya da SCOPUS veri tabanında taranan dergide yayımlanmış derleme, vaka takdimi, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['derleme', 'vaka_teknik_not'], 'puan' => 90],
    'M5' => ['baslik' => 'Diğer uluslararası endeksler kapsamındaki dergide yayımlanmış tam makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $TAM, 'puan' => 60],
    'M6' => ['baslik' => 'ULAKBİM TR Dizin tarafından taranan ulusal hakemli dergide yayımlanmış tam makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TAM, 'puan' => 80],
    'M7' => ['baslik' => 'Diğer ulusal hakemli dergide yayımlanmış tam makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => 50],

    // ══ EK-1 YAYIN / KİTAP ══
    'M8' => ['baslik' => 'Yurt dışında uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası Kitap'], 'puan' => 300],
    'M9' => ['baslik' => 'Yurt dışında uluslararası yayınevi tarafından yayımlanmış kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Uluslararası Kitap Bölümü'], 'puan' => 150],
    'M10' => ['baslik' => 'Yurt dışında uluslararası yayınevi tarafından yayımlanmış kitabın editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Uluslararası Kitap Editörlüğü'], 'puan' => 200],
    'M11' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap', 'Ders / Metot Kitabı', 'Tahkik (Tenkitli Metin)'], 'puan' => 150],
    'M12' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 60],
    'M13' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitabın editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü', 'Ulusal Kitap Editörlüğü'], 'puan' => 100],
    // 13. madde "kitap editörlüğü VEYA KİTAP ÇEVİRİSİ" diyor; bölüm çevirisi
    // için satır yok, 'Çeviri Kitap Bölümü' 01.09.2026'da çıkarıldı. 'Burs' da
    // M36'dan çıkarıldı: kriter listesinde burs satırı hiç yok.
    'M13.b' => ['baslik' => 'Kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 100],

    // ══ EK-1 YAYIN / ATIF ══
    'M15' => ['baslik' => 'Web of Science Core Collection ya da SCOPUS tarafından taranan makale veya kitaplarda eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 12],
    'M16' => ['baslik' => 'ULAKBİM TR Dizin kapsamındaki dergilerde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 5],

    // ══ EK-1 YAYIN / BİLDİRİ ══
    'M17' => ['baslik' => 'Web of Science Core Collection ya da SCOPUS veri tabanında taranan uluslararası bilimsel toplantıda sözlü sunulup tam veya genişletilmiş özet metin olarak yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 100],
    'M18' => ['baslik' => 'Uluslararası ya da ulusal bir organizasyonun düzenli hakemli konferansında sözlü sunulup tam veya genişletilmiş özet metin olarak yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Ulusal Tam Metin'], 'puan' => 40],
    'M19' => ['baslik' => 'Uluslararası ya da ulusal bir organizasyonun düzenli hakemli konferansında sözlü sunulup özet metin olarak yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster', 'Ulusal Özet/Poster', 'Davetli Konuşmacı'], 'puan' => 20],

    // ══ EK-1 PROJE ══
    'M20' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen projede yürütücü veya yönetici olmak', 'kategori' => 'proje', 'kaynaklar' => $ULUSLARARASI_FON, 'roller' => ['yurutucu'], 'puan' => 300],
    'M21' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen projede araştırmacı veya danışman olmak', 'kategori' => 'proje', 'kaynaklar' => $ULUSLARARASI_FON, 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 175],
    'M22' => ['baslik' => 'TÜBİTAK tarafından desteklenen projede yürütücü veya yönetici olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 250],
    'M23' => ['baslik' => 'TÜBİTAK tarafından desteklenen projede araştırmacı veya danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 125],
    'M24' => ['baslik' => 'Kamu kurumları tarafından desteklenen projede yürütücü veya yönetici olmak', 'kategori' => 'proje', 'kaynaklar' => $KAMU_FON, 'roller' => ['yurutucu'], 'puan' => 150],
    'M25' => ['baslik' => 'Kamu kurumları tarafından desteklenen projede araştırmacı veya danışman olmak', 'kategori' => 'proje', 'kaynaklar' => $KAMU_FON, 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 75],
    'M26' => ['baslik' => 'Özel sektör tarafından desteklenen projede yürütücü veya yönetici olmak', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 100],
    'M27' => ['baslik' => 'Özel sektör tarafından desteklenen projede araştırmacı veya danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 50],
    'M28' => ['baslik' => 'Başkent Üniversitesi bilimsel araştırma projesinde yürütücü veya yönetici olmak', 'kategori' => 'proje', 'kaynaklar' => $BAP_FON, 'roller' => ['yurutucu'], 'puan' => 30],
    'M29' => ['baslik' => 'Başkent Üniversitesi bilimsel araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => $BAP_FON, 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],

    // ══ EK-1 GİRİŞİM ══
    'M30' => ['baslik' => 'Teknoloji geliştirme bölgesinde şirket kurmak ya da alınmış patenti ticari hâle getirmek', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 300],
    'M31' => ['baslik' => 'Yurt dışında patentlenmiş bir buluş', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 1000],
    'M32' => ['baslik' => 'Yurt içinde patentlenmiş ya da faydalı model olarak kaydedilmiş bir buluş', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili', 'Yazılım'], 'puan' => 750],

    // ══ EK-1 BİLGİ TRANSFERİ ══
    'M35' => ['baslik' => 'Alanında bilimsel nitelikli, adaylar arasından jüri seçimine dayalı uluslararası ödül almak', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 200],
    'M36' => ['baslik' => 'Alanında bilimsel nitelikli, adaylar arasından jüri seçimine dayalı ulusal ödül almak', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 100],
    'M37' => ['baslik' => 'SCI, SCI-Expanded, SSCI, AHCI, ESCI ya da Scopus kapsamındaki dergilerde yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 100],
    'M38' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 200],

    // ══ EK-2 SANATSAL ETKİNLİKLER ══
    'M40' => ['baslik' => 'Uluslararası konser, temsil ya da müzik festivali', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Uluslararası)', 'Solistlik (Uluslararası)', 'Şan Resitali (Uluslararası)', 'Oratoryo/Kantat Solistliği (Uluslararası)', 'Orkestra Şefliği (Uluslararası)', 'Opera Şefliği (Uluslararası)', 'Koro Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Uluslararası)', 'Grup Şefliği (Uluslararası)', 'Opera Birinci Rol (Uluslararası)', 'Opera İkinci Rol (Uluslararası)', 'Bale Başrol (Uluslararası)', 'Bale Solist Rol (Uluslararası)', 'Corps de Ballet (Uluslararası)', 'Dansçı / Performans İcracısı (Uluslararası)', 'Oda Müziği Grup Üyeliği (Uluslararası)', 'Başkemancılık (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Rejisörlük (Uluslararası)', 'Rejisör Yardımcılığı (Uluslararası)', 'Masterclass (Uluslararası)', 'Eğitici Konser Programı (Uluslararası)', 'Tüm Perde Koreograflığı (Uluslararası)', 'Bölüm Koreograflığı (Uluslararası)', 'Bale/Dans Koreograflığı (Uluslararası)', 'Sahneleme/Repetitörlük — Tüm Perde (Uluslararası)', 'Sahneleme/Repetitörlük — Bölüm (Uluslararası)'], 'puan' => 80],
    'M41' => ['baslik' => 'Ulusal konser, temsil ya da müzik festivali', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Ulusal)', 'Solistlik (Ulusal)', 'Şan Resitali (Ulusal)', 'Oratoryo/Kantat Solistliği (Ulusal)', 'Orkestra Şefliği (Ulusal)', 'Opera Şefliği (Ulusal)', 'Koro Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Ulusal)', 'Grup Şefliği (Ulusal)', 'Opera Birinci Rol (Ulusal)', 'Opera İkinci Rol (Ulusal)', 'Bale Başrol (Ulusal)', 'Bale Solist Rol (Ulusal)', 'Corps de Ballet (Ulusal)', 'Dansçı / Performans İcracısı (Ulusal)', 'Oda Müziği Grup Üyeliği (Ulusal)', 'Orkestra / Koro Üyeliği', 'Başkemancılık (Ulusal)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Rejisör Yardımcılığı (Ulusal)', 'Rejisör Yardımcılığı (Konservatuvar)', 'Yönetmenlik (Sahne/Ekran)', 'Sahne Tasarımı (Dekor, Kostüm, Işık)', 'Koreografi', 'Masterclass (Ulusal)', 'Eğitici Konser Programı (Ulusal)', 'Müzikoloji Atölyesi', 'Eğitim Amaçlı Sanat Etkinliği', 'Tüm Perde Koreograflığı (Ulusal)', 'Bölüm Koreograflığı (Ulusal)', 'Bale/Dans Koreograflığı (Ulusal)', 'Sahneleme/Repetitörlük — Tüm Perde (Ulusal)', 'Sahneleme/Repetitörlük — Bölüm (Ulusal)'], 'puan' => 54],
    'M43' => ['baslik' => 'Ulusal ya da uluslararası kurum ve kuruluşlarca yayımı ve dağıtımı yapılmış görsel ve işitsel kayıtlar', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)', 'Karma Albüm / CD-DVD Katkısı', 'Eğitim Müziği Albümü'], 'puan' => 70],
    'M44' => ['baslik' => 'Uluslararası sergi, görsel sanat festivali, proje uygulama, fikir projesi ya da gösteri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Karma Sergi (Uluslararası)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Belgesel/Kısa Film (Uluslararası)', 'Uygulama Projesi — Müellif', 'Koruma-Onarım Uygulaması (Uluslararası)'], 'puan' => 200],
    'M45' => ['baslik' => 'Ulusal sergi, görsel sanat festivali, proje uygulama, fikir projesi ya da gösteri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)', 'Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Belgesel/Kısa Film (Ulusal)', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman', 'Koruma-Onarım Uygulaması (Ulusal)'], 'puan' => 75],
    'M46' => ['baslik' => 'Büyük ölçekli senfonik, opera ya da bale eseri bestelemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera/Bale Kompozisyonu', 'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Orkestralı Sahne Eseri'], 'puan' => 300],
    'M49' => ['baslik' => 'Orta ölçekli oda müziği ya da solo çalgı eseri bestelemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda/Koro Müziği Eseri (≥15 dk)', 'Küçük Ölçekli Orkestra Eseri', 'Elektronik Müzik Eseri (≥15 dk)'], 'puan' => 130],
    'M50' => ['baslik' => 'Müzikli tiyatro, operet, film ve tiyatro müziği ya da müzik eğitimi için öncü çalışma', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne/Ekran Müziği', 'Orkestrasyon/Transkripsiyon'], 'puan' => 100],
    'M51' => ['baslik' => 'Küçük ölçekli çalgı ve ses eğitimi eseri bestelemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Eğitim Müziği Düzenlemesi', 'Özgün Eser / Beste / Tasarım'], 'puan' => 75],

    // ══ EK-2 ÖDÜL, TELİF VE ATIFLAR ══
    'M57' => ['baslik' => 'Sanat yapıtının ya da müzik yorum kaydının sanat, eğitim ve kültür kurumlarınca satın alınması veya telif hakkının ödenmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Haber Olması (Uluslararası)', 'Eserin Haber Olması (Ulusal)'], 'puan' => 60],
    'M60' => ['baslik' => 'Sanat yapıtı, tasarım ve yorum çalışmalarıyla jürili etkinliklerde derece almak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 75],
];

return [
    'kapsam_notu' => 'Puanlar Başkent Üniversitesi EK-1 Genel Puanlama Çizelgesi ile EK-2 Sanat '
        .'Alanı Puanlama Çizelgesinden. Ortak çalışmalarda puan yazar SIRASINA değil kişi '
        .'sayısına bakıyor: tek yazarlıda tam puan, iki yazarlıda %80, üçte %70, dörtte %60, '
        .'beşte %50, altı ve daha fazla yazarlıda %40. Yazar listesini boş bırakırsanız çarpan '
        .'uygulanmaz ve puanınız olduğundan yüksek görünür. '
        .'Q1, Q2 ve Q3 dergilerindeki makalelere verilen %50 çeyreklik primi satıra gömüldü: bu '
        .'makaleler 300 yerine 450 puan alıyor. AHCI dergileri çeyreklik taşımadığı için 300 '
        .'puandan sayılıyor. '
        .'Çizelgede tez danışmanlığı, ders verme ve idari görev satırı YOK; bu kayıtlarınız '
        .'toplam puanınıza katkı vermiyor. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: yurt dışı kurumlardan '
        .'akademisyenlerle ortak çalışmalara (%50), Ar-Ge, girişimcilik, danışmanlık ve eğitim '
        .'projelerine (%30-50) ve WoS ya da SCOPUS kapsamında taranan uluslararası kitaplara '
        .'(%50) verilen primler uygulanmıyor; SCI ve SSCI dergilerindeki atıflar (20 puan) WoS '
        .'Core Collection atıflarından ayrılamadığı için 12 puandan sayılıyor; patenti '
        .'ticarileştirmenin 1000 ve 750 puanlık satırları teknopark şirketi kurmaktan '
        .'ayrılamadığı için 300 puandan sayılıyor; yurt dışında en az üç ay görev almak '
        .'(39. madde, 100 puan) faaliyet olarak kaydedilemediği için girilmedi. '
        .'Puanınız şu kalemde OLDUĞUNDAN YÜKSEK görünür: "aynı kitaptaki bölümlerden en fazla '
        .'ikisinden puan alınabilir" sınırı uygulanmıyor.'
        .' KİTAPTA DİL KOŞULU DENETLENMİYOR: uluslararası yayınevi kitabınız yönergenin "yabancı dilde yayımlanmış" satırından sayılıyor. Kitabınız Türkçe ise puanınız olduğundan YÜKSEK görünür.',

    // [1] numaralı dipnot: tek yazarlıda tam puan, iki yazarlıda 0,80,
    // üçte 0,70, dörtte 0,60, beşte 0,50, altı ve daha fazlada 0,40.
    // Sıralama fark etmediği için bütün roller aynı tabloyu paylaşıyor.
    'yazar_katsayisi' => [
        'kademeler' => [1 => 1.00, 2 => 0.80, 3 => 0.70, 4 => 0.60, 5 => 0.50],
        'sonrasi' => 0.40,
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        // Tablo 2'nin atıf yaptığı madde aralıkları.
        '01-02' => ['M1.a', 'M1.b', 'M2'],
        '01-03' => ['M1.a', 'M1.b', 'M2', 'M3'],
        '01-06' => ['M1.a', 'M1.b', 'M2', 'M3', 'M4', 'M5', 'M6'],
        '01-07' => ['M1.a', 'M1.b', 'M2', 'M3', 'M4', 'M5', 'M6', 'M7'],
        '40-48' => ['M40', 'M41', 'M43', 'M44', 'M45', 'M46'],
        // Hukukta aranan "tek yazarlı ve ders kitabı dışındaki kitap".
        'KITAP' => ['M8', 'M11'],
    ],

    'grup_tavanlari' => [],
];
