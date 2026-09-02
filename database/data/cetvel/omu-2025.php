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
 * GİRİLMEYEN: 15. bölüm (görsel etkinlikler — İletişim Fakültesi'ne özgü),
 * 16. bölüm sanatsal etkinliklerin alt kırılımları ve 13. bölümün ödül dışı
 * hizmet kalemleri. Kaynak sözlüğünde karşılıkları yok.
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
 * '1-14' İLE '1-15' HÂLÂ EŞİT VE BU DOĞRU: aradaki tek fark 15. bölüm ve o
 * bölümün (görsel etkinlikler) satırları kaynak sözlüğünde karşılıksız
 * olduğu için hiç girilmedi. Eşitlik artık bir sızıntı değil, girilemeyen
 * bir bölümün sonucu — tarama bunu yeniden işaretlerse buraya bakılsın.
 */

return [
    'kapsam_notu' => 'Puanlar Ondokuz Mayıs Üniversitesi Puan Cetvelinden (Mayıs 2025). Görsel '
        .'etkinlikler ve sanatsal etkinliklerin alt kırılımları kaynak sözlüğünde karşılıksız '
        .'olduğu için girilmedi; güzel sanatlar alanında 16. kategori barajı bu yüzden beyan '
        .'olarak duruyor. '
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

        // ── 16. SANATSAL ETKİNLİK ──
        '16.1' => ['baslik' => 'Uluslararası jürili kişisel sanatsal etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)'], 'puan' => 60],
        '16.2' => ['baslik' => 'Ulusal jürili kişisel sanatsal etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)'], 'puan' => 40],
        '16.3' => ['baslik' => 'Karma veya grup sanatsal etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Ulusal)'], 'puan' => 20],
    ],

    'gruplar' => [
        // Koşulların birebir andığı KATEGORİ ARALIKLARI. Üst sınır alan grubuna
        // göre değişiyor: A 1-14, B 1-15, C 1-16.
        '1-10' => ['1.*', '2.*', '3.*', '4.*', '5.*', '6.*', '7.*', '8.*', '9.*', '10.*'],
        '1-14' => ['1.*', '2.*', '3.*', '4.*', '5.*', '6.*', '7.*', '8.*', '9.*', '10.*', '11.*', '12.*', '13.*', '14.*'],
        '1-15' => ['1.*', '2.*', '3.*', '4.*', '5.*', '6.*', '7.*', '8.*', '9.*', '10.*', '11.*', '12.*', '13.*', '14.*'],
        '1-16' => ['*'],
        '16' => ['16.*'],
        // Makale adet koşullarının andığı kategoriler.
        '1.1' => ['1.1-*'],
        '1.1-2.1-3.1' => ['1.1-*', '2.1', '3.1'],
        'MAKALE' => ['1.1-*', '2.1', '3.1', '4.1'],
    ],

    'grup_tavanlari' => [],
];
