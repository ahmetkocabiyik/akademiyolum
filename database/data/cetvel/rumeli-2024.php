<?php

/**
 * İSTANBUL RUMELİ ÜNİVERSİTESİ — EK 1 / TABLO 1: Değerlendirme Ölçütleri
 * Puanlama Tablosu
 * Kaynak: pdf/17537100672.istanbulrumeliuniversitesi.pdf
 *
 * DOSYA ADINDAKİ YIL PDF'TEN GELİYOR, YÖNERGEDEN DEĞİL: MADDE 19 "Yükseköğretim
 * Kurulu'nca onaylandığı tarih itibariyle yürürlüğe girer" diyor ama tarih
 * yazmıyor ve belgenin hiçbir yerinde kabul tarihi ya da karar numarası yok.
 * 2024, PDF'in oluşturma tarihi (11/07/2024).
 *
 * MADDE KODLARI yönergenin kendi numaralarını birebir koruyor; koşullar tabloya
 * kodla atıf yapıyor ("1.1. veya 1.2 veya 1.3'den en az bir (1) yayın").
 * Bize ait tek kod kümesi 1.1.5'in dört alt şıkkı (aşağıda).
 *
 * ── TOPLAM PUAN, TABLONUN TAMAMI DEĞİL ──
 * Tablonun ara değerlendirme satırı toplamı açıkça sınırlıyor: "TOPLAM 1 PUANI
 * (1.1;1.2;1.3;1.4;1.6)" — yani 1.5 (editörlük ve hakemlikler) ile 1.7 (atıflar)
 * bölüm toplamına GİRMİYOR. Genel değerlendirme tablosu da aynı ayrımı yapıyor:
 * 1-8 bölümleri toplanıp "TOPLAM" yazılıyor, ATIFLAR ve HAKEMLİKLER o satırın
 * ALTINDA ayrı ayrı raporlanıyor.
 *
 * Bu yüzden 100 ve 120 puanlık barajlar `TOPLAM` grubuna bağlandı; 1.5 ve 1.7
 * satırları cetvelde duruyor (aday puanını görsün diye) ama baraja saymıyor.
 * İki bağımsız işaret aynı yönü gösteriyor ve bu okuma adayın puanını fazla
 * göstermeyen taraf.
 *
 * ── YAZAR FORMÜLÜ: 1,5 × PUAN / n ──
 * MADDE 16(1): "Çok isimli yayın ve diğer faaliyetlerde puanların
 * hesaplanmasında n isim sayısı olmak üzere 1.5xPuan/n formülü uygulanır."
 * Sıraya bağlı DEĞİL, yalnızca kişi sayısına bağlı; bütün roller aynı formülü
 * paylaşıyor (`bol` + `pay: 1.5`, `roller` tanımlanmadı). Tek yazarlıda formül
 * 1,5 verir; motor `min(1.0, …)` uyguladığı için tam puanda kalır. İki
 * yazarlıda 0,75, üç yazarlıda 0,50.
 *
 * Formül "diğer faaliyetlerde" de geçerli, ama yönergenin KENDİ paylaşım
 * kuralını yazdığı satırlarda uygulanmadı (`haric`): proje 2.1 rolü üçe
 * bölüyor (yürütücü / yardımcı / görev alan), tez 5.2 danışman ile ikinci
 * danışmanı ayırıyor, editörlük-hakemlik ve yönetim görevi kişisel, ödül ve
 * burs kişiye veriliyor. Atıf da hariç: 1.7 puanı adayın aldığı HER ATIF için
 * veriliyor, atıf ortak yazarlı bir eser değil.
 *
 * ── AYNI KAYNAĞA DÜŞEN SATIRLARDA DAİMA DÜŞÜĞÜ GİRİLDİ ──
 *   Kitap 1.3.1 yurt dışı (60) / 1.3.3 yurt içi (30): 'Uluslararası/Ulusal
 *       Kitap' ayıramıyor → 1.3.3. Bölümde 1.3.2 (25) / 1.3.4 (10) → 1.3.4.
 *       'BKCI / Scopus Kitap' da yayın yerini söylemediği için 1.3.3'e düştü;
 *       Rumeli kitapta indeks aramıyor, yalnızca yurt içi/dışı ayırıyor.
 *   Bildiri 1.2.2 yayınlanmış özet (5) / 1.2.3 yayınlanmamış poster (3):
 *       'Uluslararası Özet/Poster' ikisini ayıramıyor → 1.2.3. Ulusalda aynı
 *       şekilde 1.2.5 (5) yerine 1.2.6 (3).
 *   Dergi görevi 1.5.1 editörlük (50) / 1.5.3 yardımcı editörlük (10) / 1.5.4
 *       hakemlik (5): 'WoS Dergi (Q1-Q4)' ve 'ESCI / Scopus Dergi' derginin
 *       düzeyini söylüyor, adayın görevini söylemiyor → 1.5.4. Ulusalda 1.5.5
 *       (10) yerine 1.5.6 (5).
 *   Davetli konuşmacı 8.1 uluslararası (50) / 8.3 ulusal (20): 'Davetli
 *       Konuşmacı' ayıramıyor → 8.3.
 *   Burs 4.5 yurt dışı 2 aydan uzun (10) / 4.6 yurt içi 3 aydan uzun (5):
 *       'Burs' ne yeri ne süreyi taşıyor → 4.6.
 *   Ödül 4.1 uluslararası (80) / 4.3 diğer ulusal (30): 'Yarışma Derecesi /
 *       Mansiyon' düzeyini söylemiyor → 4.3.
 *   Proje 2.1.4 TÜBİTAK-TÜBA-DPT (20) / 2.1.7 üniversite fonu (10): 'Özel
 *       Sektör / STK' ikisinden birine girmiyor → düşük olan 2.1.7.
 *
 * ── ATIF: HEPSİ EN DÜŞÜK SATIRA DÜŞTÜ ──
 * 1.7.1-1.7.5 puanı "adayın YAZAR OLARAK YER ALMADIĞI yayınlarda" aldığı atıf
 * için veriyor; 1.7.6 ise adayın isim olarak yer aldığı yayınlardaki atfı 1
 * puanla geçiyor. Faaliyet kaydı atıf yapan yayında adayın olup olmadığını
 * TUTMUYOR — aynı bölüm içinde, aynı olayın iki okuması. Kural gereği en düşük
 * satır (1.7.6) alındı ve 1.7.1-1.7.5 girilmedi. Etkisi sınırlı: atıf zaten
 * `TOPLAM` grubuna girmiyor, yalnızca ayrı raporlanan atıf puanını düşürüyor.
 * Aynı satırın "son 5 yıl içinde yapılmış atıflar" dipnotu da uygulanamıyor
 * (madde bazında pencere motorda yok); o yön tersine, puanı yükseltiyor.
 *
 * ── 1.1.5'İN DÖRT ALT ŞIKKI BİZE AİT ──
 * Kaynak tek satırda dört puan veriyor (20/15/10/5) ve "adı geçen maddelerde
 * belirtilen puanların yarısı" diyor; yani 1.1.1-1.1.4'ün yarısı. Satır dört
 * koda bölündü (1.1.5.a-d) ve her biri kendi dergi kümesine bağlandı.
 * 1.1.1-1.1.4 yalnızca ÖZGÜN MAKALE sayıyor ("teknik not, editöre mektup,
 * tartışma, vaka takdimi, özet, DERLEME ve kitap kritiği türünden yayınlar
 * dışındaki makaleler"); derleme bu yüzden tam puan satırında değil, 1.1.5'te.
 *
 * ── KAYNAKTAKİ TEKRARLAR VE NUMARA HATALARI (düzeltilmedi, kaydedildi) ──
 *   5.1.4 ile 1.3.5 KELİMESİ KELİMESİNE aynı satır ve aynı puan (20): basılmış
 *       ya da uzaktan eğitim ders notu yazarlığı. Kaynak kalemi iki bölümde
 *       birden sayıyor; çifte sayım olmasın diye yalnızca 1.3.5 girildi.
 *   2.1.5 tabloda iki kez basılmış (aynı metin, aynı puan) — tek satır sayıldı.
 *   6. bölümün onuncu ve sonrası satırları 6.10-6.19 yerine 6.1.0-6.1.9 diye
 *       numaralanmış. Bölümün tamamı girilemediği için sonuca etkisi yok.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   6. bölümün TAMAMI (mimarlık ve mühendislik proje etkinlikleri, 19 satır):
 *       satırlar ya "İRÜ AR-GE bünyesinde" gibi kuruma özgü ya da öğrenci
 *       yarışması danışmanlığı ve yarışma derecesi; kaynak sözlüğünde
 *       karşılıkları yok. Mimarlık ve Mühendislik adayının toplamı DÜŞÜK çıkar.
 *   2.1.2 / 2.1.5 / 2.1.8 proje yürütücü YARDIMCILIĞI — faaliyet kaydının rol
 *       listesinde yürütücü yardımcısı yok; yürütücü ya da görev alan satırına
 *       zorlamak puanı bozardı.
 *   2.2 dışındaki sınai haklar ('Faydalı Model', 'Endüstriyel Tasarım',
 *       'Yazılım', 'Islahçı Hakkı', 'Ticarileştirme') — yönerge yalnızca
 *       "patentler" diyor, uydurulmadı.
 *   4.4 İRÜ destekli ödül — kaydın ödülü verenin kurumu tutmuyor.
 *   5.1.3 uzaktan eğitim dersi, 5.2.3 ikinci tez danışmanlığı, 1.5.1-1.5.3
 *       (görev ayrımı yok), 1.7.1-1.7.5, 1.6.1 (yurt dışı rapor),
 *       8.2 / 8.4 panelistlik, 8.5-8.8 kongre düzenleme — sözlükte ayrı
 *       karşılığı olmayan satırlar.
 *   'Ansiklopedi Maddesi', 'Akreditasyon Faaliyeti', 'Tez İzleme / Jüri
 *       Üyeliği', 'Senato / Üniversite Yönetim Kurulu Üyesi', 'Kurul /
 *       Komisyon Üyeliği', 'Özgün Eser / Beste / Tasarım', 'Topluma Hizmet
 *       Projesi', 'Bilim İletişimi / Popüler Yayın', 'Uygulama Projesi'
 *       kalemleri ve konservatuvara özgü icra kaynakları (opera, bale,
 *       koreografi, rejisörlük, şeflik, kompozisyon) — tabloda satırı YOK.
 *       Rumeli'nin sanat bölümü dört satırdan ibaret ve hepsi "etkinlikte
 *       bulunmak / etkinliğe katılmak" diyor.
 *
 * ── DERS PUANI OLDUĞUNDAN YÜKSEK ÇIKAR ──
 * 5.1.1 ve 5.1.2 "son 3 yılda her ders için, her yıl için en fazla 5 ders"
 * diyor. Motor ne madde bazında kayan pencere ne yıl başına adet sınırı
 * tutuyor; iki kısıt da uygulanmadı.
 *
 * Yönerge: yonerge/rumeli.php
 */

return [
    'kapsam_notu' => 'Puanlar İstanbul Rumeli Üniversitesi EK 1 / Tablo 1\'den. '
        .'Çok isimli çalışmalarda yönergenin formülü uygulanır (MADDE 16: 1,5 × puan / yazar '
        .'sayısı; iki yazarlıda puanın %75\'i, üç yazarlıda yarısı). Formül yazar sırasına '
        .'bakmıyor; yazar listesini boş bırakırsanız uygulanamaz ve puanınız olduğundan YÜKSEK '
        .'görünür. Proje, tez danışmanlığı, hakemlik, yönetim görevi, ödül ve atıf '
        .'kalemlerinde formül uygulanmaz — yönerge bu satırların paylaşımını zaten kendisi '
        .'ayırıyor. '
        .'BARAJA SAYILAN PUAN TABLONUN TAMAMI DEĞİL: yönergenin ara değerlendirme satırı '
        .'toplamı "1.1; 1.2; 1.3; 1.4; 1.6" diye sınırlıyor ve genel değerlendirme tablosu '
        .'atıf ile hakemlik puanını toplamın altında ayrı raporluyor. Hakemlik, editörlük ve '
        .'atıf puanınız hesaplanıp gösterilir ama 100 ve 120 puanlık barajlara girmez. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: mimarlık ve mühendislik proje '
        .'etkinlikleri bölümünün on dokuz satırı (üniversitenin kendi Ar-Ge birimine ve '
        .'öğrenci yarışmalarına özgü) girilemedi — Mimarlık ve Mühendislik adaylarını en çok '
        .'bu etkiler; proje yürütücü yardımcılığı, faydalı model ve tasarım tescili, '
        .'panelistlik, kongre düzenleme, uzaktan eğitim dersi ve ikinci tez danışmanlığı da '
        .'girilemedi. Yurt dışı ile yurt içi ayrımını taşımayan kalemlerde (kitap, bildiri, '
        .'davetli konuşmacı, burs, ödül) düşük satır kullanıldı. Atıflarda kaydınız atfı '
        .'yapan yayında sizin olup olmadığınızı tutmadığı için en düşük satır uygulanır. '
        .'Puanınız yalnızca derslerde OLDUĞUNDAN YÜKSEK çıkabilir: yönerge "son 3 yıl" ve '
        .'"yılda en fazla 5 ders" sınırı koyuyor, ikisi de uygulanamıyor.',

    // MADDE 16(1): "n isim sayısı olmak üzere 1.5xPuan/n". Sıraya bağlı
    // olmadığı için `roller` tanımlanmadı; bütün roller aynı formülü paylaşır.
    'yazar_katsayisi' => [
        'haric' => ['proje', 'tez_danismanligi', 'editorluk', 'idari_gorev',
            'egitim_ogretim', 'odul', 'atif'],
        'bol' => ['pay' => 1.5],
    ],

    'maddeler' => [
        // ══ 1.1 ULUSAL VE ULUSLARARASI DERGİDE MAKALE ══
        // 1.1.1-1.1.4 yalnızca özgün makale; derleme ve kısa yayınlar 1.1.5'te.
        '1.1.1' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 40],
        '1.1.2' => ['baslik' => 'Alan indeksleri tarafından listelenen dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale'], 'puan' => 30],
        '1.1.3' => ['baslik' => 'TÜBİTAK ULAKBİM dergi listesindeki hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 20],
        '1.1.4' => ['baslik' => 'Diğer bilimsel dergilerde makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale'], 'puan' => 10],
        // Kaynak 1.1.5'i tek satırda dört puanla veriyor ("puanların yarısı");
        // alt kodlar (a-d) bize ait, her biri kendi dergi kümesinin yarısı.
        '1.1.5.a' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI taranan dergide derleme, vaka takdimi, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 20],
        '1.1.5.b' => ['baslik' => 'Alan indekslerindeki dergide derleme, vaka takdimi, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 15],
        '1.1.5.c' => ['baslik' => 'TÜBİTAK ULAKBİM dergisinde derleme, vaka takdimi, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 10],
        '1.1.5.d' => ['baslik' => 'Diğer bilimsel dergilerde derleme, vaka takdimi, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 5],

        // ══ 1.2 BİLDİRİLER ══
        '1.2.1' => ['baslik' => 'Uluslararası kongre bildiriler kitabında tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 15],
        '1.2.3' => ['baslik' => 'Uluslararası kongrede sunulan poster ya da sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 3],
        '1.2.4' => ['baslik' => 'Ulusal kongre bildiriler kitabında tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 10],
        '1.2.6' => ['baslik' => 'Ulusal kongrede sunulan poster ya da sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 3],

        // ══ 1.3 KİTAPLAR ══
        '1.3.3' => ['baslik' => 'Ulusal yayınevi ya da üniversite tarafından yayımlanan bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'BKCI / Scopus Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 30],
        '1.3.4' => ['baslik' => 'Ulusal yayınevi ya da üniversite tarafından yayımlanan kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'BKCI / Scopus Kitap Bölümü'], 'puan' => 10],
        // Kaynakta 5.1.4 olarak bir kez daha geçiyor; çifte sayım olmasın diye
        // yalnızca burada.
        '1.3.5' => ['baslik' => 'Basılmış ders notu ya da ulusal yayınevi tarafından yayımlanan ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 20],

        // ══ 1.4 ÇEVİRİLER ══
        '1.4.1' => ['baslik' => 'Bilimsel kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 15],
        '1.4.2' => ['baslik' => 'Makale ya da kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 5],

        // ══ 1.5 EDİTÖRLÜK VE HAKEMLİKLER (baraja saymaz) ══
        '1.5.4' => ['baslik' => 'SCI, SSCI, AHCI ya da alan indeksi dergisinde hakemlik, yardımcı editörlük veya editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 5],
        '1.5.5' => ['baslik' => 'Ulusal hakemli dergide yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 10],
        '1.5.6' => ['baslik' => 'TÜBİTAK ULAKBİM listesindeki ya da ulusal hakemli dergide hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi', 'Hakemlik'], 'puan' => 5],
        '1.5.7' => ['baslik' => 'Bilimsel kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü', 'BKCI Kitap'], 'puan' => 10],

        // ══ 1.6 BASILMIŞ BİLİMSEL RAPORLAR ══
        '1.6.2' => ['baslik' => 'Ulusal kuruluşlar için hazırlanmış ve tamamlanmış uzmanlık raporu', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı'], 'puan' => 5],

        // ══ 1.7 ATIFLAR (baraja saymaz) ══
        // Kaydınız atfı yapan yayında sizin yer alıp almadığınızı tutmuyor;
        // aynı bölümdeki en düşük satır uygulandı.
        '1.7.6' => ['baslik' => 'Yayınlarınıza yapılan her bir atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap', 'TR Dizin', 'Patent', 'Diğer'], 'puan' => 1],

        // ══ 2.1 ARAŞTIRMA PROJELERİ ══
        '2.1.1' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 40],
        '2.1.3' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
        '2.1.4' => ['baslik' => 'TÜBİTAK, TÜBA ya da bakanlık destekli projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 20],
        '2.1.6' => ['baslik' => 'TÜBİTAK, TÜBA ya da bakanlık destekli projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
        '2.1.7' => ['baslik' => 'Üniversite araştırma fonu destekli projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 10],
        '2.1.9' => ['baslik' => 'Üniversite araştırma fonu destekli projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 5],

        // ══ 2.2 PATENTLER ══
        '2.2.1' => ['baslik' => 'Yurt dışı patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 100],
        '2.2.2' => ['baslik' => 'Yurt içi patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 50],

        // ══ 3 SANAT ETKİNLİKLERİ ══
        '3.1' => ['baslik' => 'Uluslararası kişisel sanat etkinliği (sergi, bienal, gösteri, dinleti, festival)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Solistlik (Uluslararası)', 'Resital (Uluslararası)', 'Şan Resitali (Uluslararası)'], 'puan' => 20],
        '3.2' => ['baslik' => 'Ulusal kişisel sanat etkinliği (sergi, bienal, gösteri, dinleti, festival)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)', 'Solistlik (Ulusal)', 'Resital (Ulusal)', 'Şan Resitali (Ulusal)'], 'puan' => 15],
        '3.3' => ['baslik' => 'Uluslararası karma sergi, bienal ya da konsere katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Karma Sergi (Uluslararası)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Oda Müziği Grup Üyeliği (Uluslararası)'], 'puan' => 10],
        '3.4' => ['baslik' => 'Ulusal karma sergi, bienal ya da konsere katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Oda Müziği Grup Üyeliği (Ulusal)', 'Orkestra / Koro Üyeliği'], 'puan' => 5],

        // ══ 4 ÖDÜLLER VE BURSLAR ══
        '4.1' => ['baslik' => 'Uluslararası bilim, sanat veya tasarım ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 80],
        '4.2' => ['baslik' => 'TÜBİTAK ya da TÜBA destekli ulusal bilim, sanat veya tasarım ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 50],
        '4.3' => ['baslik' => 'Diğer kurumlarca verilen ulusal bilim, sanat veya tasarım ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü', 'Ulusal Bilim/Sanat Ödülü', 'Yarışma Derecesi / Mansiyon'], 'puan' => 30],
        '4.6' => ['baslik' => 'Bilimsel araştırma bursu', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 5],

        // ══ 5.1 ÖĞRETİME KATKI ══
        '5.1.1' => ['baslik' => 'Verdiğiniz lisansüstü ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 10],
        '5.1.2' => ['baslik' => 'Verdiğiniz lisans ya da ön lisans dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 5],

        // ══ 5.2 TEZ YÖNETİMİ ══
        '5.2.1' => ['baslik' => 'Yönetiminizde tamamlanan doktora tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 10],
        '5.2.2' => ['baslik' => 'Yönetiminizde tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 5],

        // ══ 7 YÖNETİM ETKİNLİKLERİ ══
        '7.1' => ['baslik' => 'Rektörlük, rektör yardımcılığı, dekanlık ya da enstitü-yüksekokul müdürlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü'], 'puan' => 10],
        '7.2' => ['baslik' => 'Dekan yardımcılığı, bölüm başkanlığı, müdür yardımcılığı ya da araştırma merkezi müdürlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkanı', 'Bölüm Başkan Yardımcısı', 'Uygulama ve Araştırma Merkezi Müdürü', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 5],

        // ══ 8 DİĞER BİLİMSEL ETKİNLİKLER ══
        '8.3' => ['baslik' => 'Bilimsel toplantıda davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 20],
        '8.5' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 30],
        '8.7' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Ulusal)'], 'puan' => 20],
        '8.6' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 20],
        '8.8' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 10],
    ],

    'gruplar' => [
        // MADDE 13/1-c'nin andığı üç bölüm. Nokta zorunlu: '1.1*' deseni
        // olmayan bir '1.10' kodunu da yakalardı.
        '1.1' => ['1.1.*'],
        '1.2' => ['1.2.*'],
        '1.3' => ['1.3.*'],
        '1.1-1.2-1.3' => ['1.1.*', '1.2.*', '1.3.*'],

        // Barajların saydığı küme. Yönerge bölüm toplamını "1.1; 1.2; 1.3;
        // 1.4; 1.6" diye sınırlıyor — 1.5 (hakemlik) ve 1.7 (atıf) toplamın
        // dışında, genel değerlendirme tablosunda ayrı raporlanıyor.
        // 6. bölüm hiç girilemediği için desende yok.
        'TOPLAM' => ['1.1.*', '1.2.*', '1.3.*', '1.4.*', '1.6.*',
            '2.*', '3.*', '4.*', '5.*', '7.*', '8.*'],
    ],

    // Yönerge hiçbir bölüme sabit tavan koymuyor. 5.1'in "yılda en fazla 5
    // ders" sınırı adet tavanı; motor bunu tutmuyor (dosya başlığına bak).
    'grup_tavanlari' => [],
];
