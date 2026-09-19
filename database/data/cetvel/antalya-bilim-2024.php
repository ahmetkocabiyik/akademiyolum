<?php

/**
 * ANTALYA BİLİM ÜNİVERSİTESİ — EK-1 Genel Puanlama Çizelgesi
 * Kaynak: pdf/17634002431.Antalya Bilim Üniversitesi Kriter.pdf
 * (Öğretim Üyesi Atama ve Yükseltme Yönergesi, 51 satırlık çizelge.)
 *
 * Madde kodları çizelgenin kendi sıra numaraları; başlarındaki M harfi
 * bize ait: PHP salt sayısal dizi anahtarlarını tam sayıya çevirdiği için
 * '1' yerine 'M1' yazılıyor. Öbür bize ait kodlar:
 *   - Projelerde ve kitap satırında rol/kategori ayrımı için açılan alt
 *     kodlar (13.b, 51.b).
 *   - Çizelgede 51 numarası İKİ KEZ kullanılmış (yazılım/patent sahipliği
 *     ve mimarlık yarışmalarında derece); ikincisi 51.b olarak yazıldı.
 *
 * ── YAZAR SAYISINA GÖRE BÖLME YOK ──
 * Yönerge ortak çalışmalarda puan dağılımı için HİÇBİR kural koymuyor;
 * çizelgede yalnız "birim puan" sütunu var. Bu yüzden cetvelde yazar
 * katsayısı tanımlanmadı: çok yazarlı bir çalışma da tam puan alıyor.
 * Bu yönergeye sadık bir okuma, üniversitenin kendi tercihi.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   Madde 1 (SCI/SCI-Expanded) ile madde 2 (SSCI ve AHCI) puanları aynı
 *       (20) ve sözlük SCI ile SSCI'yi ayırmıyor; tek satırda birleşti.
 *   Atıfta madde 14 (SCI/SSCI/AHCI, 3) ile madde 15 (WoS Core Collection
 *       veya SCOPUS, 2) tek 'WoS / Scopus' etiketine düşüyor → 2.
 *   Patentte madde 35 (yurt dışı, 5) ile madde 36 (yurt içi, 4) faydalı
 *       modeli de kapsıyor; tek 'Faydalı Model' etiketi için → 4.
 *   Ticarileştirmede madde 32 (teknopark şirketi, 20), 37 (yurt dışı
 *       patenti ticarileştirmek, 50) ve 38 (yurt içi, 30) tek
 *       'Ticarileştirme' etiketine düşüyor → 20.
 *   Bursta madde 33 (uluslararası, 30) ile madde 34 (ulusal, 20) → 20.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   Madde 44 (yurt dışında kesintisiz en az üç ay görev almak, 20) —
 *       faaliyet değil süre ölçütü.
 *   ESCI, Scopus, TR Dizin ve diğer hakemli dergilerde EDİTÖRLÜK —
 *       çizelge yalnız SCI, SCI-Expanded, SSCI ve AHCI dergilerinde
 *       editörlüğü (madde 42) ve bu dergilerle ESCI-Scopus'ta yayın
 *       kurulu üyeliğini (madde 41) puanlıyor.
 *   Tez danışmanlığı, ders verme ve idari görev — çizelgede hiç yok;
 *       Antalya Bilim yalnız araştırma çıktısını puanlıyor.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   Madde 9 ve 12'nin "aynı kitaptaki bölümlerden en fazla ikisinden puan
 *       alınabilir" sınırı — kitap başına tavan motorda yok.
 *   SCI, SCI-Expanded, SSCI ve AHCI dergilerinde yayımlanan vaka
 *       takdimi ve teknik notlar: madde 1 bunları açıkça dışlamıyor ama
 *       çizelgenin ayrı bir satırı da yok; §0 uyarınca puansız bırakıldı.
 *
 * Yönerge: yonerge/antalya-bilim.php
 *
 * DİL KOŞULU SATIR SEÇİMİNİ DEĞİŞTİRMİYOR (19.09.2026, kullanıcı kararı): üst
 * satırın dil koşulu kayıttan okunamıyor ama alt satır ULUSAL yayınevine ait;
 * kapsam etiketi kendi kapsamının satırına bağlandı, ulusal satırlar
 * daraltıldı.
 */
$TAM = ['ozgun_makale', 'derleme', 'kisa_makale'];
$ULUSLARARASI_PROJE = ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'];
$KAMU_PROJE = ['TÜSEB', 'Diğer Kamu Kurumu', 'BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'];

return [
    'kapsam_notu' => 'Puanlar Antalya Bilim Üniversitesi Öğretim Üyesi Atama ve Yükseltme '
        .'Ölçütleri Genel Puanlama Çizelgesinden (EK-1). Yönerge ortak çalışmalarda puanın '
        .'yazarlar arasında bölünmesi için HİÇBİR kural koymuyor; bu yüzden çok yazarlı '
        .'çalışmalarınız da tam puan alıyor. '
        .'Çizelge yalnız araştırma çıktısını puanlıyor: tez danışmanlığı, ders verme ve idari '
        .'görevlerin puan satırı YOK, bu kayıtlarınız toplam puanınıza katkı vermiyor. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: SCI, SCI-Expanded, SSCI ve AHCI '
        .'dergilerinde yayımlanan vaka takdimi ve teknik notların çizelgede satırı yok; ESCI, '
        .'Scopus, TR Dizin ve diğer hakemli dergilerdeki editörlükler puanlanmıyor; yurt '
        .'dışında kesintisiz en az üç ay görev almak (madde 44, 20 puan) faaliyet olarak '
        .'kaydedilemediği için girilmedi; atıfta SCI dergilerine yapılan 3 puanlık atıflar WoS '
        .'Core Collection atıflarından ayrılamadığı için 2 puandan sayılıyor; patenti ticari '
        .'hâle getirmenin 50 ve 30 puanlık satırları teknopark şirketi kurmaktan ayrılamadığı '
        .'için 20 puandan sayılıyor. '
        .'Puanınız şu kalemde OLDUĞUNDAN YÜKSEK görünür: "aynı kitaptaki bölümlerden en fazla '
        .'ikisinden puan alınabilir" sınırı uygulanmıyor.'
        .' KİTAPTA DİL KOŞULU DENETLENMİYOR: uluslararası yayınevi kitabınız yönergenin "yabancı dilde yayımlanmış" satırından sayılıyor. Kitabınız Türkçe ise puanınız olduğundan YÜKSEK görünür.',

    'maddeler' => [
        // ══ 1. MAKALE ══
        'M1' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergilerde yayımlanmış veya yayım için kabul edilmiş makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => $TAM, 'puan' => 20],
        'M3' => ['baslik' => 'Web of Science Core Collection ya da SCOPUS veri tabanında taranan dergilerde yayımlanmış veya yayım için kabul edilmiş tam makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale'], 'puan' => 12],
        'M4' => ['baslik' => 'Web of Science Core Collection ya da SCOPUS veri tabanında taranan dergilerde yayımlanmış diğer çalışmalar (vaka takdimi, teknik not, editöre mektup, özet, derleme veya karar tahlili)', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 12],
        'M5' => ['baslik' => 'Diğer uluslararası endeksler kapsamındaki dergilerde yayımlanmış veya yayım için kabul edilmiş tam makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $TAM, 'puan' => 8],
        'M6' => ['baslik' => 'ULAKBİM TR Dizin tarafından taranan ulusal hakemli dergilerde yayımlanmış veya yayım için kabul edilmiş tam makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TAM, 'puan' => 8],
        'M7' => ['baslik' => 'Diğer ulusal hakemli dergilerde yayımlanmış veya yayım için kabul edilmiş tam makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => 5],

        // ══ 2. KİTAP ══
        'M8' => ['baslik' => 'Doçentlik yabancı dil sınavları için kabul edilen dillerden biriyle yazılmış ve uluslararası yayınevleri tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası Kitap'], 'puan' => 20],
        'M9' => ['baslik' => 'Doçentlik yabancı dil sınavları için kabul edilen dillerden biriyle yazılmış ve uluslararası yayınevleri tarafından yayımlanmış kitap bölümü', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Uluslararası Kitap Bölümü'], 'puan' => 12],
        'M10' => ['baslik' => 'Doçentlik yabancı dil sınavları için kabul edilen dillerden biriyle yazılmış ve yurt dışında uluslararası yayınevleri tarafından yayımlanmış kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Uluslararası Kitap Editörlüğü'], 'puan' => 12],
        'M11' => ['baslik' => 'Ulusal yayınevleri tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap', 'Ders / Metot Kitabı', 'Tahkik (Tenkitli Metin)'], 'puan' => 10],
        'M12' => ['baslik' => 'Ulusal yayınevleri tarafından yayımlanmış kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 8],
        'M13' => ['baslik' => 'Ulusal yayınevleri tarafından yayımlanmış kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü', 'Ulusal Kitap Editörlüğü'], 'puan' => 8],
        'M13.b' => ['baslik' => 'Ulusal yayınevleri tarafından yayımlanmış kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap', 'Çeviri Kitap Bölümü'], 'puan' => 8],

        // ══ 3. ATIF ══
        'M15' => ['baslik' => 'Web of Science Core Collection ya da SCOPUS tarafından taranan, adayın yazar olarak yer almadığı makale veya kitaplarda eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 2],
        'M16' => ['baslik' => 'ULAKBİM TR Dizin kapsamındaki dergilerde, adayın yazar olarak yer almadığı makalelerde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
        'M17' => ['baslik' => 'Yukarıdakiler dışında kalan ve adayın yazar olarak yer almadığı yayınlarda eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap', 'Diğer', 'Patent'], 'puan' => 1],

        // ══ 4. BİLDİRİ ══
        'M18' => ['baslik' => 'Web of Science Core Collection ya da SCOPUS veri tabanında taranan uluslararası bilimsel toplantıda sözlü sunulmuş ve tam veya genişletilmiş özet metin olarak yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 10],
        'M19' => ['baslik' => 'Uluslararası ya da ulusal bir organizasyon tarafından düzenli olarak gerçekleştirilen hakemli konferansta sözlü sunulmuş ve tam veya genişletilmiş özet metin olarak yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Ulusal Tam Metin'], 'puan' => 10],
        'M20' => ['baslik' => 'Uluslararası ya da ulusal bir organizasyon tarafından düzenli olarak gerçekleştirilen hakemli konferansta sözlü sunulmuş ve özet metin veya poster olarak yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster', 'Ulusal Özet/Poster', 'Davetli Konuşmacı'], 'puan' => 6],

        // ══ 5. PROJE / GİRİŞİMCİLİK / DESTEK PROGRAMI ══
        'M21' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen projede ya da destek programında yürütücü veya yönetici olmak', 'kategori' => 'proje', 'kaynaklar' => $ULUSLARARASI_PROJE, 'roller' => ['yurutucu'], 'puan' => 30],
        'M22' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen projede ya da destek programında araştırmacı veya danışman olmak', 'kategori' => 'proje', 'kaynaklar' => $ULUSLARARASI_PROJE, 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
        'M23' => ['baslik' => 'TÜBİTAK tarafından desteklenen projede ya da destek programında yürütücü veya yönetici olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 25],
        'M24' => ['baslik' => 'TÜBİTAK tarafından desteklenen projede ya da destek programında araştırmacı veya danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['arastirmaci', 'danisman'], 'puan' => 15],
        'M25' => ['baslik' => 'TÜBİTAK tarafından desteklenen projede ya da destek programında bursiyer olarak görev almak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['bursiyer'], 'puan' => 10],
        'M26' => ['baslik' => 'Kamu kurumları tarafından desteklenen projede ya da destek programında yürütücü veya yönetici olmak', 'kategori' => 'proje', 'kaynaklar' => $KAMU_PROJE, 'roller' => ['yurutucu'], 'puan' => 10],
        'M27' => ['baslik' => 'Kamu kurumları tarafından desteklenen projede ya da destek programında araştırmacı veya danışman olmak', 'kategori' => 'proje', 'kaynaklar' => $KAMU_PROJE, 'roller' => ['arastirmaci', 'danisman'], 'puan' => 8],
        'M28' => ['baslik' => 'Kamu kurumları tarafından desteklenen projede ya da destek programında görev almak', 'kategori' => 'proje', 'kaynaklar' => $KAMU_PROJE, 'roller' => ['bursiyer'], 'puan' => 5],
        'M29' => ['baslik' => 'Özel sektör tarafından desteklenen projede ya da destek programında yürütücü veya yönetici olmak', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 10],
        'M30' => ['baslik' => 'Özel sektör tarafından desteklenen projede ya da destek programında araştırmacı veya danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman'], 'puan' => 8],
        'M31' => ['baslik' => 'Özel sektör tarafından desteklenen projede ya da destek programında görev almak', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['bursiyer'], 'puan' => 5],
        'M32' => ['baslik' => 'Teknoloji geliştirme bölgelerinde araştırma geliştirme amacıyla şirket kurmak ya da patenti ticari hâle getirmek', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 20],
        'M34' => ['baslik' => 'Akademik çalışmalar için kazanılan ulusal ya da uluslararası burs, fon ve destekler', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 20],

        // ══ 6. PATENT / ÖDÜL ══
        'M35' => ['baslik' => 'Yurt dışında patentlenmiş bir buluş', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 5],
        'M36' => ['baslik' => 'Yurt içinde patentlenmiş ya da faydalı model olarak kaydedilmiş bir buluş', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 4],
        'M39' => ['baslik' => 'Alanında bilimsel nitelikli, adaylar arasından jüri seçimine dayalı uluslararası ödül almak', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 20],
        'M40' => ['baslik' => 'Alanında bilimsel nitelikli, adaylar arasından jüri seçimine dayalı ulusal ödül almak', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 10],
        'M41' => ['baslik' => 'SCI, SCI-Expanded, SSCI, AHCI, ESCI ya da Scopus kapsamındaki dergilerde yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 10],
        'M42' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 15],
        'M43' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergilerde fiilen yapılan hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 4],

        // ══ 7. SANATSAL ETKİNLİKLER ve MİMARİ TASARIM ══
        'M45' => ['baslik' => 'Uluslararası sergi, görsel sanat festivali, konser, temsil, proje uygulama, fikir projesi ya da gösteri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Elektronik Karma Sergi (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Belgesel/Kısa Film (Uluslararası)', 'Koruma-Onarım Uygulaması (Uluslararası)', 'Uygulama Projesi — Müellif', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Resital (Uluslararası)', 'Solistlik (Uluslararası)', 'Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Yayında Yer Alması / Satın Alınması', 'Masterclass (Uluslararası)', 'Eğitici Konser Programı (Uluslararası)'], 'puan' => 20],
        'M46' => ['baslik' => 'Ulusal sergi, görsel sanat festivali, konser, temsil, proje uygulama, fikir projesi ya da gösteri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Karma/Jürili Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Kişisel Sergi (Ulusal)', 'Elektronik Karma Sergi (Ulusal)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Belgesel/Kısa Film (Ulusal)', 'Koruma-Onarım Uygulaması (Ulusal)', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Resital (Ulusal)', 'Solistlik (Ulusal)', 'Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Satın Alınması (Yurt İçi)', 'Özgün Eser / Beste / Tasarım', 'Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)', 'Karma Albüm / CD-DVD Katkısı', 'Orkestra / Koro Üyeliği', 'Oda Müziği Grup Üyeliği (Uluslararası)', 'Oda Müziği Grup Üyeliği (Ulusal)', 'Koreografi', 'Yönetmenlik (Sahne/Ekran)', 'Sahne Tasarımı (Dekor, Kostüm, Işık)', 'Dansçı / Performans İcracısı (Uluslararası)', 'Dansçı / Performans İcracısı (Ulusal)', 'Eserin Haber Olması (Uluslararası)', 'Eserin Haber Olması (Ulusal)', 'Masterclass (Ulusal)', 'Eğitici Konser Programı (Ulusal)', 'Eğitim Amaçlı Sanat Etkinliği'], 'puan' => 10],
        'M47' => ['baslik' => 'Sanat yapıtı, tasarım ve yorum çalışmalarıyla uluslararası jürili etkinliklerde derece almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], 'puan' => 20],
        'M49' => ['baslik' => 'Sanat yapıtı, tasarım ve yorum çalışmalarıyla ulusal jürili etkinliklerde derece almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 10],
        'M51' => ['baslik' => 'Proje ve yapım yönetimi, tasarım ya da planlama alanlarında yazılım üreticisi olmak', 'kategori' => 'patent', 'kaynaklar' => ['Yazılım'], 'puan' => 15],
        'M51.b' => ['baslik' => 'Planlama, mimarlık, kentsel tasarım, peyzaj, iç mimari ya da endüstri ürünleri tasarımı yarışmalarında derece veya mansiyon almak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 15],
    ],

    'gruplar' => [
        // Tablo 2'nin atıf yaptığı madde aralıkları. Madde 2 (SSCI ve AHCI)
        // madde 1 ile aynı satırda birleştiği için kümelerde ayrı görünmüyor.
        '1-2' => ['M1'],
        '3-6' => ['M3', 'M4', 'M5', 'M6'],
        '01-03' => ['M1', 'M3'],
        '01-06' => ['M1', 'M3', 'M4', 'M5', 'M6'],
        // Sağlık, Mühendislik ile Fen ve Matematikte doktor öğretim üyeliği
        // "iki ULUSLARARASI yayın" istiyor: uluslararası dergi satırları.
        'ULUSLARARASI-MAKALE' => ['M1', 'M3', 'M4', 'M5'],
        '45-51' => ['M45', 'M46', 'M47', 'M49', 'M51', 'M51.b'],
        // Hukukta profesörlüğün "tek yazarlı ve ders kitabı dışındaki kitap"
        // koşulu için kitap satırları.
        'KITAP' => ['M8', 'M11'],
    ],

    'grup_tavanlari' => [],
];
