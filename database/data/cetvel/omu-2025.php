<?php

/**
 * ONDOKUZ MAYIS ÜNİVERSİTESİ — Yükseltilme ve Atanmalarda Uygulanacak
 * Puan Cetveli
 * Kaynak: pdf/17634002431.Ondokuz Mayıs Üniversitesi Kriter.pdf (Mayıs 2025)
 *
 * TEK ORTAK CETVEL, ÜÇ TEMEL ALAN GRUBU İÇİN AYRI EŞİK. Koşullar cetvele
 * KATEGORİ ARALIĞIYLA atıf yapıyor ("1-10 kategorilerinden en az 360 puan",
 * "1-14 kategorilerinden en az 750") ve aralığın ÜST SINIRI alan grubuna göre
 * değişiyor: A 1-14, B 1-15, C 1-16. Bu yüzden gruplar üç ayrı aralık olarak
 * tanımlandı.
 *
 * ÇEYREKLİKLER TEK SATIRDA: 1. bölümün satırları puanı "80/70/60/50" biçiminde
 * Q1'den Q4'e veriyor. Kaynak sözlüğü çeyrekliği ayırdığı için satırlar alt
 * maddelere bölündü (1.1-Q1 … 1.1-Q4); kategori aralıkları önek eşleşmesiyle
 * bunları da yakalıyor.
 *
 * GİRİLMEYEN: 13. bölümün ödül dışı hizmet kalemleri — kaynak sözlüğünde
 * karşılıkları yok.
 *
 * ── 16. SANATSAL ETKİNLİK: ÜÇ EKSEN, BİREBİR EŞLEME ──
 * Kaynak etkinlikleri YER (yurt dışı / yurt içi), JÜRİ (uluslararası jürili /
 * ulusal jürili / jürisiz) ve KATILIM BİÇİMİ (kişisel / karma-grup)
 * eksenlerinde ayırıyor; sözlüğün sanat etiketleri de aynı üç ekseni
 * taşıdığı için on yedi bendin on dördü birebir eşleşti.
 *
 * ÖNCEKİ ÜÇ SATIR YANLIŞ EŞLENMİŞTİ ve ikisi FAZLA SAYIYORDU:
 *   '16.1' Kişisel Etkinlik (Uluslararası) 60 — değeri doğru ama kaynakta o
 *       bent satın alma/yayında yer alma (80); kişisel etkinlik 16.3.
 *   '16.2' Kişisel Etkinlik (Ulusal) 40 — kaynakta yurt içi ulusal jürili
 *       kişisel etkinlik 16.12 ve 20 puan. YİRMİ PUAN FAZLA sayıyordu.
 *   '16.3' Karma/Jürili (Uluslararası + Ulusal) 20 — kaynakta uluslararası
 *       karma 30 (16.4), yurt içi ulusal karma 5 (16.13). Ulusal karma
 *       etkinlik ON BEŞ PUAN FAZLA, uluslararası olan ise on puan eksik
 *       sayılıyordu.
 *
 * 16. BÖLÜMDEN GİRİLMEYEN ETİKETLER:
 *   'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası/Ulusal)' — 16.1 ve 16.2
 *       "sinema, televizyon, radyo gibi yayın organlarında yer alması"
 *       diyor ama bendin kapısı "proje bedeli ve TELİF HAKKI ÖDENMİŞ veya
 *       yapıtın ALIMI YAPILMIŞ olması"; kayıt bu koşulu taşımıyor ve etiket
 *       ayrıca sahne yapıtlarını da kapsıyor. 80 puanlık bir bende
 *       doğrulanamayan koşulla girmek fazla saymak olurdu.
 *   'Elektronik Kişisel/Karma Sergi' — bölümün madde altı notu sergiyi
 *       "galeri, sanat galerisi, sergi salonu" gibi belgelenebilir FİZİKSEL
 *       mekân şartına bağlıyor.
 *   'Karma Albüm / CD-DVD Katkısı', 'Oda Müziği Grup Üyeliği', 'Grup
 *       Şefliği', 'Festival Koordinatörlüğü' — etiketler etkinliğin yerini,
 *       jürisini ya da katılım biçimini taşımıyor; hangi bende düşecekleri
 *       okunamıyor.
 *
 * YARIŞMA DERECESİ ÇARPANI UYGULANMIYOR: bölümün notu yarışma puanlarını
 * dereceye göre ölçekliyor (birincilik %100, ikincilik %90, üçüncülük %80,
 * mansiyon %70, satın alma %60, katılım %50). Kayıt dereceyi taşımadığı için
 * hepsi TAM puandan sayılıyor; yarışma kaleminiz varsa puanınız olduğundan
 * YÜKSEK görünür.
 *
 * 14. BÖLÜM GÖRSEL ETKİNLİK DEĞİL: başlığı "ONDOKUZ MAYIS ÜNİVERSİTESİNE
 * KATKI" ve içeriği idari görev. Bir tur 15. bölümle birlikte "görsel
 * etkinlikler" diye kaydedilmişti; düzeltildi ve bölüm girildi.
 *
 * ── 14. BÖLÜMÜN PUANI YIL İLE ÇARPILIYOR ──
 * Tablonun * dipnotu: "Puanlar görev alınan yıl ile çarpılarak toplam puana
 * yansıtılır." 14.1-14.6 ve 14.17 bu dipnotu taşıyor. Faaliyet kaydı görev
 * süresini tutmadığı için satırlar TEK YIL değeriyle girildi; üç yıl dekan
 * yardımcılığı yapmış aday 90 yerine 30 görür. Bu bölümün puanı olduğundan
 * DÜŞÜK çıkar.
 *
 * ── 14.2'DE FAKÜLTEYE BAĞLI ÇELİŞKİ ──
 * Kaynak bölüm başkanlığını Tıp, Eczacılık, Diş Hekimliği ve Veteriner
 * DIŞINDAKİ birimlerde sayıyor; o fakültelerde ise bölüm başkanlığını
 * saymayıp anabilim dalı başkanlığını sayıyor. Kayıt fakülteyi taşımıyor ve
 * iki okumadan biri seçilmek zorunda. Çoğunluğu yöneten okuma yazıldı
 * (bölüm başkanlığı 20), anabilim dalı başkanlığı 14.3'ün düşük satırından
 * (5) sayılıyor. Sapma: sağlık alanındaki bir anabilim dalı başkanı 20
 * yerine 5 görür (DÜŞÜK, güvenli yön); sağlık alanındaki bir bölüm başkanı
 * ise kaynağın hiç saymadığı 20 puanı görür (YÜKSEK). İkinci durum
 * `kapsam_notu`'nda adaya söyleniyor.
 *
 * ── 14. BÖLÜMDEN GİRİLMEYENLER ──
 *   14.6 öğrenci topluluğu akademik danışmanlığı (5), 14.8 sürdürülebilirlik
 *       çalışmaları (4) — kaynak sözlüğünde karşılıkları yok.
 *   14.9 yabancı dilde ders verme YETERLİLİĞİ (6) — bir yeterlilik, faaliyet
 *       değil; 'Yabancı Dilde Ders' etiketi ders VERMEYİ anlatıyor ve 12.1'de.
 *   14.10-14.13 (OMÜ dergi/kitap editörlüğü 7, hakemliği 3, OMÜ Yayınevi
 *       kitabı 30, onaylı ders notu 10) — kayıt derginin ya da kitabın OMÜ
 *       yayını olduğunu taşımıyor. Üstelik *** dipnotu bu puanların "ilgili
 *       kategorideki puanlara İLAVE edileceğini" söylüyor; motor bir
 *       faaliyete tek maddenin puanını veriyor, toplama yapmıyor. Satır
 *       açmak ya ölü kalırdı (7 < editörlüğün 15-40'ı) ya da fazla saydırırdı
 *       (30, ulusal yayınevi kitabının 15'inin üstünde).
 *   14.14 ve 14.15 (görünürlüğe ve kurumsal kimliğe katkı, 4'er) — ** dipnotu
 *       ölçütleri Rektörlük Eğitim Komisyonu'na bırakıyor; kapsam belirsiz ve
 *       mevcut sanatsal etkinlik ile bildiri satırlarıyla çakışırdı.
 *   14.17 kalite görevleri (8/6/4/2) — rolleri 14.3 ve 14.4'ün etiketleriyle
 *       aynı kovaya düşüyor; ayrı satır motor en yükseği seçtiği için ya ölü
 *       kalır ya fazla saydırır.
 *   Rektörlük ve rektör yardımcılığı — kaynağın 14. bölümü bu iki görevi hiç
 *       saymıyor, o yüzden satırları da yok.
 *
 * '1-14' ve '1-15' grupları 14. bölüm hiç girilmediği için 13'te bitiyordu
 * ve BİRBİRİNİN AYNISIYDI — konvansiyonun "ardışık aralık gruplarının
 * boyutları kesin artmalı" kontrolünün yakaladığı desen. İkisine de '14.*'
 * eklendi ve 1-10 (38) → 1-14 (50) → 1-16 (53) artışı kuruldu.
 *
 * 15. bölüm de girilince aralıklar kesin artar oldu:
 * 1-10 (38) → 1-14 (50) → 1-15 (54) → 1-16 (57).
 *
 * ── 15. GÖRSEL ETKİNLİKLER: ROL OKUNAMIYOR, DÜŞÜK BENT YAZILDI ──
 * Bölüm bir tur "kaynak sözlüğünde karşılıksız" diye atlanmıştı; Dokuz Eylül
 * için açılan film, TV ve reklam etiketleri çoğunu karşılıyor.
 *
 * Kaynak her mecrada YÖNETMENLİĞİ ile ÖTEKİ GÖREVLERİ ayrı puanlıyor
 * (sinemada 80/36, belgeselde 40/20, TV programında 16/8). Sözlük etiketi ise
 * YAPITIN TÜRÜNÜ ve düzeyini söylüyor, adayın rolünü değil. §0 uyarınca her
 * etiket temsil edebileceği en DÜŞÜK bende yazıldı — "öteki görevler"
 * değerine. Uluslararası bir sinema filmi yönetmeni 80 yerine 20 görür;
 * buna karşılık kurgucu olan aday yönetmen puanı almaz.
 *
 * Dört satır bize ait kodlarla girildi (15.2-15.4 ve 15.7-15.8 birleşimleri).
 *
 * BÖLÜM İLETİŞİM FAKÜLTESİ'NE ÖZGÜ, CETVEL İSE ORTAK. Kaynağın başlığı
 * "(İletişim Fakültesi için geçerlidir)" diyor ama motor tek cetveli
 * paylaştırıyor ve İletişim, B grubunun ('1-15') içinde — grup ayrıca
 * eğitim, filoloji, hukuk, ilahiyat, sosyal ve sporu da taşıyor. Ayrı bir
 * `birim` eşiği açmak çözüm DEĞİL: `bul()` aynı (üniversite, kadro, alan)
 * için iki aday bulunca birim boşsa null döner ve sosyal alanın TAMAMI
 * kapsam dışı kalırdı. Bu yüzden satırlar ortak cetvelde duruyor ve
 * `kapsam_notu` adaya "İletişim Fakültesi dışındaysanız bu kalemleri
 * saymayın" diyor.
 *
 * 15. BÖLÜMDEN GİRİLMEYENLER:
 *   15.5 reklam filmi yönetmenliği (20/10) — kaynak reklam filminde YALNIZ
 *       yönetmenliği puanlıyor, "öteki görevler" bendi yok; etiket rolü
 *       taşımadığı için yönetmen olduğu doğrulanamayan adaya puan vermek
 *       fazla saymak olurdu.
 *   15.6 gazete yayın yönetmenliği, görsel yönetmenlik ve editörlüğü
 *       (16/8/4) ile 15.9 radyo programı/reklamı (6/5/4) — sözlükte
 *       karşılıkları yok.
 *   'Yönetmenlik (Sahne/Ekran)' etiketi hiçbir satıra yazılmadı: mecrayı da
 *       düzeyi de taşımıyor, §0 değeri yerel TV'nin 4'üne inerdi ve etiket
 *       ayrıca sahne yönetmenliğini de kapsıyor — bölümün hiç saymadığı bir
 *       iş. Aynı sebeple 'Animasyon / Canlandırma Yapımı' ile geniş 'Sahne,
 *       TV, Radyo, Sinema Yapıtı' etiketleri de dışarıda kaldı.
 */

return [
    'kapsam_notu' => 'Puanlar Ondokuz Mayıs Üniversitesi Puan Cetvelinden (Mayıs 2025). '
        .'ÜNİVERSİTEYE KATKI (14.) BÖLÜMÜNÜN PUANI DÜŞÜK GÖRÜNÜR: kaynak bu bölümün puanlarını '
        .'görev alınan YIL SAYISIYLA çarpıyor, faaliyet kaydınız görev süresini tutmadığı için '
        .'satırlar tek yıl değeriyle sayılıyor — üç yıl dekan yardımcılığı yaptıysanız 90 yerine '
        .'30 puan görürsünüz. Aynı bölümün öğrenci topluluğu danışmanlığı, sürdürülebilirlik '
        .'çalışmaları, kalite görevleri ve OMÜ\'nün kendi yayınlarına özgü kalemleri de '
        .'girilemedi. '
        .'TEK İSTİSNA — TIP, ECZACILIK, DİŞ HEKİMLİĞİ VE VETERİNER FAKÜLTELERİ: kaynak bu '
        .'fakültelerde bölüm başkanlığını saymıyor, anabilim dalı başkanlığını sayıyor. Kaydınız '
        .'fakülteyi taşımadığı için bölüm başkanlığı her fakültede 20 puan sayılıyor; bu '
        .'fakültelerdeyseniz ve bölüm başkanıysanız puanınız 20 puan YÜKSEK görünür. '
        .'GÖRSEL ETKİNLİKLER (15.) BÖLÜMÜ İLETİŞİM FAKÜLTESİ İÇİNDİR: yönerge bu bölümü '
        .'yalnız İletişim Fakültesi\'ne veriyor, ama puan cetveli bütün alanlarca paylaşıldığı '
        .'için satırlar herkese görünüyor. İletişim Fakültesi dışındaysanız film ve televizyon '
        .'kalemlerinizi saymayın, yoksa puanınız olduğundan yüksek görünür. Bu bölümde ayrıca '
        .'yönetmenlik ile yapımcılık, kurgu ve senaryo görevleri kaynakta ayrı puanlanıyor '
        .'(sinemada 80\'e karşı 36); faaliyet kaydınız rolünüzü taşımadığı için hepsi DÜŞÜK '
        .'olan görev puanından sayılıyor — yönetmenseniz puanınız olduğundan düşük görünür. '
        .'Reklam filmi yönetmenliği, gazete editörlüğü ve radyo programı kalemleri girilemedi. '
        .'SANATSAL ETKİNLİKLERDE (16.) YARIŞMA DERECESİ SAYILMIYOR: yönerge yarışma '
        .'puanlarını dereceye göre ölçekliyor (birincilik tam puan, mansiyon %70, katılım %50) '
        .'ama faaliyet kaydınız dereceyi taşımıyor; yarışma kaleminiz varsa puanınız olduğundan '
        .'YÜKSEK görünür. Elektronik sergiler ile albüm, oda müziği ve şeflik kalemleri bu '
        .'bölümde girilemedi. '
        .'Bunun dışında gerçek toplamınız burada görünenden yüksek olabilir, düşük olamaz.',

    'maddeler' => [
        // ── 1. SCI, SCIE, SSCI veya AHCI ── (çeyrekliğe göre 80/70/60/50)
        '1.1-Q1' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI Q1 dergide özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 80],
        '1.1-Q2' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI Q2 dergide özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 70],
        '1.1-Q3' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI Q3 dergide özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 60],
        '1.1-Q4' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI Q4 dergide özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 50],
        '1.2-Q1' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI Q1 dergide vaka takdimi, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 20],
        '1.2-Q4' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI Q2-Q4 dergide vaka takdimi, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 14],
        '1.3' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 40],
        '1.4' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI dergide alan editörlüğü veya yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 21],
        '1.5' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI dergide hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 15],

        // ── 2. ESCI, SCOPUS ve SPORTDiscus ──
        '2.1' => ['baslik' => 'ESCI veya Scopus dergide özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 40],
        '2.2' => ['baslik' => 'ESCI veya Scopus dergide vaka takdimi, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 10],
        '2.3' => ['baslik' => 'ESCI veya Scopus dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 35],

        // ── 3. TR DİZİN ──
        '3.1' => ['baslik' => 'TR Dizin hakemli dergide özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 30],
        '3.2' => ['baslik' => 'TR Dizin hakemli dergide vaka takdimi, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 20],
        '3.4' => ['baslik' => 'TR Dizin hakemli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 25],

        // ── 4. DİĞER HAKEMLİ DERGİLER ──
        '4.1' => ['baslik' => 'Diğer ulusal veya uluslararası hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 20],
        '4.4' => ['baslik' => 'Diğer hakemli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 15],

        // ── 5. BİLİMSEL TOPLANTILAR ── (uluslararası/ulusal ikili değer)
        '5.1' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 24],
        '5.2' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan özet veya poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster', 'Davetli Konuşmacı'], 'puan' => 20],
        '5.4' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 12],
        '5.5' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan özet veya poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 10],

        // ── 6. ULUSLARARASI YAYINEVLERİ ──
        '6.1' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 120],
        '6.2' => ['baslik' => 'Uluslararası yayınevi kitabında bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 50],
        '6.3' => ['baslik' => 'Uluslararası yayınevi kitabında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 60],
        '6.5' => ['baslik' => 'Uluslararası kitap veya kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap', 'Çeviri Kitap Bölümü'], 'puan' => 20],

        // ── 7. ULUSAL / DİĞER ULUSLARARASI YAYINEVLERİ ──
        '7.1' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı'], 'puan' => 40],
        '7.2' => ['baslik' => 'Ulusal yayınevi kitabında bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 15],
        '7.3' => ['baslik' => 'Ulusal yayınevi kitabında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 20],

        // ── 8. TAMAMLANMIŞ PROJELER ──
        '8.1' => ['baslik' => 'Uluslararası destekli tamamlanmış projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 100],
        '8.2' => ['baslik' => 'Uluslararası destekli tamamlanmış projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 50],
        '8.3' => ['baslik' => 'TÜBİTAK, TÜSEB veya kamu destekli tamamlanmış projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 70],
        '8.4' => ['baslik' => 'TÜBİTAK, TÜSEB veya kamu destekli tamamlanmış projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 35],
        '8.5' => ['baslik' => 'Üniversite (BAP) destekli tamamlanmış proje', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'puan' => 20],

        // ── 9. PATENT, FAYDALI MODEL, TESCİL ──
        '9.1' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 100],
        '9.2' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 60],
        '9.3' => ['baslik' => 'Faydalı model, tasarım veya çeşit tescili', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili', 'Yazılım', 'Ticarileştirme'], 'puan' => 30],

        // ── 10. TAMAMLANMIŞ TEZ DANIŞMANLIĞI ──
        '10.1' => ['baslik' => 'Tamamlanmış doktora veya uzmanlık tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 40],
        '10.2' => ['baslik' => 'Tamamlanmış yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'puan' => 20],

        // ── 11. ATIFLAR ──
        '11.1' => ['baslik' => 'SCI, SCIE, SSCI, AHCI veya Scopus kapsamında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 5],
        '11.2' => ['baslik' => 'Diğer kaynaklarda yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap', 'TR Dizin', 'Diğer', 'Patent'], 'puan' => 2],

        // ── 12. EĞİTİM-ÖĞRETİM ──
        '12.1' => ['baslik' => 'Verilen ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 10],

        // ── 13. ÖDÜLLER ──
        '13.1' => ['baslik' => 'Uluslararası bilim veya sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 60],
        '13.2' => ['baslik' => 'Ulusal bilim veya sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'YÖK Ödülü', 'Ulusal Bilim/Sanat Ödülü', 'Yarışma Derecesi / Mansiyon'], 'puan' => 30],

        // ── 14. ONDOKUZ MAYIS ÜNİVERSİTESİNE KATKI ──
        // Bölümün bütün satırlarının puanı GÖREV ALINAN YIL İLE ÇARPILIYOR
        // (tablonun * dipnotu); kayıt görev süresini taşımadığı için hepsi
        // TEK YIL değeriyle girildi. Bu bölümün puanı olduğundan düşük çıkar.
        '14.1' => ['baslik' => 'Senato üyeliği, dekan yardımcılığı, müdürlük ya da müdür yardımcılığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Senato / Üniversite Yönetim Kurulu Üyesi', 'Dekan / Enstitü-YO Müdürü', 'Dekan Yrd. / Müdür Yrd.'], 'puan' => 30],
        // Kaynak bölüm başkanlığını YALNIZCA Tıp/Eczacılık/Diş/Veteriner
        // DIŞINDAKİ birimlerde sayıyor, o fakültelerde ise anabilim dalı
        // başkanlığını. Kayıt fakülteyi taşımıyor; çoğunluğu yöneten okuma
        // (bölüm başkanlığı) yazıldı, anabilim dalı başkanlığı 14.3'ün düşük
        // satırından sayılıyor. Sapma dosya başlığında.
        '14.2' => ['baslik' => 'Bölüm başkanlığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 20],
        // Kaynak 10/5 diyor; hangi kademenin geçerli olduğu kayıttan
        // okunamadığı için §0 uyarınca DÜŞÜK olan.
        '14.3' => ['baslik' => 'Rektörlük, dekanlık ya da müdürlük tarafından oluşturulan kurul, komisyon ve koordinatörlük görevleri (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 5],
        '14.4' => ['baslik' => 'Fakülte, bölüm, program ya da laboratuvar akreditasyon kurulunda görev (yıl başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Akreditasyon Faaliyeti'], 'puan' => 6],
        // 6/3 → §0 düşük. Tez izleme komitesi üyeliği bu bendin örneklerinde
        // ama etiketi 10.2'de 20 puan alıyor, motor yükseği seçiyor.
        '14.5' => ['baslik' => 'Rektörlük, dekanlık ya da müdürlük tarafından kurulmuş bir faaliyet alanındaki görev (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 3],
        '14.7' => ['baslik' => 'Bir ay ya da daha uzun süreli sosyal sorumluluk projesi görevi', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi'], 'puan' => 6],
        '14.16' => ['baslik' => 'OMÜ adına resmî veya özel kurumlara bilimsel, kültürel ya da sanatsal danışmanlık', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı'], 'puan' => 4],

        // ── 15. GÖRSEL ETKİNLİKLER ──
        // KODLAR BİZE AİT (kaynağın 15.2/15.4 ve 15.7/15.8 bentlerinin
        // birleşimi). Kaynak her mecrada YÖNETMENLİK ile ÖTEKİ GÖREVLERİ
        // ayrı puanlıyor (sinemada 80/36, belgeselde 40/20, TV'de 16/8);
        // sözlük etiketi YAPITIN TÜRÜNÜ söylüyor, adayın rolünü değil.
        // §0 uyarınca her etikete temsil edebileceği en DÜŞÜK bent yazıldı,
        // yani "öteki görevler" değeri: yönetmen olan aday puanını düşük
        // görür, kurgucu olan aday hak etmediği puanı görmez.
        '15.2-15.4' => ['baslik' => 'Uluslararası sinema, belgesel ya da kısa metrajlı kurmaca filmde görev (yönetmenlik, yapımcılık, görsel yönetmenlik, kurgu ya da senaryo yazarlığı)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uzun Metrajlı Film / Belgesel (Uluslararası)', 'Belgesel/Kısa Film (Uluslararası)'], 'puan' => 20],
        '15.2-15.4-ulusal' => ['baslik' => 'Ulusal sinema, belgesel ya da kısa metrajlı kurmaca filmde görev (yönetmenlik, yapımcılık, görsel yönetmenlik, kurgu ya da senaryo yazarlığı)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uzun Metrajlı Film / Belgesel (Ulusal)', 'Belgesel/Kısa Film (Ulusal)'], 'puan' => 10],
        '15.7-15.8' => ['baslik' => 'Uluslararası televizyon programı ya da dizisinde görev (yönetmenlik, yapımcılık, görsel yönetmenlik, kurgu ya da senaryo yazarlığı)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['TV Programı (Uluslararası)', 'TV Filmi / Dizisi (Uluslararası)'], 'puan' => 8],
        '15.7-15.8-ulusal' => ['baslik' => 'Ulusal televizyon programı ya da dizisinde görev (yönetmenlik, yapımcılık, görsel yönetmenlik, kurgu ya da senaryo yazarlığı)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['TV Programı (Ulusal)', 'TV Filmi / Dizisi (Ulusal)'], 'puan' => 6],

        // ── 16. SANATSAL ETKİNLİK ──
        // Kaynak etkinlikleri ÜÇ EKSENDE ayırıyor: yer (yurt dışı / yurt içi),
        // jüri (uluslararası jürili / ulusal jürili / jürisiz) ve katılım
        // biçimi (kişisel / karma-grup). Sözlüğün sanat etiketleri aynı üç
        // ekseni taşıdığı için eşleme birebir kuruldu.
        '16.1' => ['baslik' => 'Özgün yapıt ya da tasarımın yurt dışında satın alınması, yayın organlarında yer alması ya da tasarım projesinin dış ülkede uygulanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kamusal Alanda Uygulanmış Yapıt (Yurt Dışı)'], 'puan' => 80],
        '16.2' => ['baslik' => 'Özgün yapıt ya da tasarımın yurt içinde satın alınması, ulusal yayın organlarında yer alması ya da tasarım projesinin yurt içinde uygulanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Satın Alınması (Yurt İçi)', 'Kamusal Alanda Uygulanmış Yapıt (Yurt İçi)', 'Eserin Yayında Yer Alması / Satın Alınması'], 'puan' => 40],
        '16.3' => ['baslik' => 'Yurt dışında uluslararası jürili kişisel sanat ya da tasarım etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)'], 'puan' => 60],
        '16.4' => ['baslik' => 'Yurt dışında uluslararası jürili karma sanat ya da tasarım etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)'], 'puan' => 30],
        '16.5' => ['baslik' => 'Yurt dışında ulusal jürili kişisel etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)'], 'puan' => 35],
        '16.6' => ['baslik' => 'Yurt dışında ulusal jürili grup ya da karma etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Ulusal Jürili)'], 'puan' => 30],
        '16.7' => ['baslik' => 'Yurt dışında yarışmasız ve jürisiz etkinliğe kişisel davetli olarak katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Yurt Dışı, Jürisiz)'], 'puan' => 20],
        '16.8' => ['baslik' => 'Yurt dışında yarışmasız ve jürisiz etkinliğe karma ya da grup davetli olarak katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Jürisiz)'], 'puan' => 10],
        '16.9' => ['baslik' => 'Uluslararası ölçekte sempozyum, festival, çalıştay, bienal ya da trienal etkinliğine yapıtıyla veya icracı olarak katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 10],
        '16.10' => ['baslik' => 'Yurt içinde uluslararası jürili kişisel sanat ya da tasarım etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)'], 'puan' => 15],
        // 'Grup Etkinliği (Uluslararası)' etiketi yeri ("yurt dışı" mı
        // "uluslararası jürili" mi) ayırmıyor; temsil edebileceği bentler
        // 16.4 (30), 16.6 (30) ve 16.11 (10) — §0 uyarınca en düşüğü.
        '16.11' => ['baslik' => 'Yurt içinde uluslararası jürili karma ya da grup etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Grup Etkinliği (Uluslararası)'], 'puan' => 10],
        '16.12' => ['baslik' => 'Yurt içinde ulusal jürili kişisel etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)'], 'puan' => 20],
        '16.13' => ['baslik' => 'Yurt içinde ulusal jürili karma ya da grup etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Grup Etkinliği (Ulusal)'], 'puan' => 5],
        '16.14' => ['baslik' => 'Yurt içinde yarışmasız ve jürisiz etkinliğe kişisel davetli olarak katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Yurt İçi, Jürisiz)'], 'puan' => 15],
        '16.15' => ['baslik' => 'Yurt içinde yarışmasız ve jürisiz etkinliğe karma ya da grup davetli olarak katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Jürisiz, Ulusal)'], 'puan' => 10],
        '16.16' => ['baslik' => 'Ulusal ölçekte sempozyum, festival, çalıştay, bienal ya da trienal etkinliğine yapıtıyla veya icracı olarak katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 10],
        '16.17' => ['baslik' => 'Eser, tasarım ya da projenin müzeye kabul edilmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt İçi)'], 'puan' => 100],
    ],

    'gruplar' => [
        // Koşulların birebir andığı KATEGORİ ARALIKLARI. Üst sınır alan grubuna
        // göre değişiyor: A 1-14, B 1-15, C 1-16.
        '1-10' => ['1.*', '2.*', '3.*', '4.*', '5.*', '6.*', '7.*', '8.*', '9.*', '10.*'],
        '1-14' => ['1.*', '2.*', '3.*', '4.*', '5.*', '6.*', '7.*', '8.*', '9.*', '10.*', '11.*', '12.*', '13.*', '14.*'],
        '1-15' => ['1.*', '2.*', '3.*', '4.*', '5.*', '6.*', '7.*', '8.*', '9.*', '10.*', '11.*', '12.*', '13.*', '14.*', '15.*'],
        '1-16' => ['*'],
        '16' => ['16.*'],
        // Makale adet koşullarının andığı kategoriler.
        '1.1' => ['1.1-*'],
        '1.1-2.1-3.1' => ['1.1-*', '2.1', '3.1'],
        'MAKALE' => ['1.1-*', '2.1', '3.1', '4.1'],
    ],

    'grup_tavanlari' => [],
];
