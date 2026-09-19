<?php

/**
 * DİCLE ÜNİVERSİTESİ — EK-1: Öğretim Üyeliği Kadrolarına Atanmalarda Dikkate
 * Alınacak Puanlama Sistemi Tablosu
 * Kaynak: pdf/17536992572.dicleuniverstesi.pdf (24 sayfa)
 *
 * MADDE KODLARI YÖNERGENİN KENDİSİ (A1-A9, B1-B3, C1-C5, D1-D6, E1-E4,
 * F1-F7, G1-G4, H1-H3, I1, J1-J10, K1-K2, L1-L6, M1-M5, N1-N2, O1-O6,
 * P1-P4, R1-R4, S1-S4, T1-T16, U1). Bunu birebir korumak zorunluydu:
 * Madde 12-15'in koşulları KOD ARALIKLARINA atıf yapıyor ("A1-A2 kodları
 * arasındaki faaliyetlerden en az 20 puan", "A1-D2 kodları arasından ilave
 * 50 puan", "M1-M2 kodları arasından en az 10 puan").
 *
 * Bize ait olan tek şey rol başına bölünen proje satırlarının ekleri
 * (`D1a-yurutucu`) ve birleştirilen satırların tire ile yazılmış çift
 * kodları (`C1a-C2a`).
 *
 * ── AYNI KAYNAĞA DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   C1a (yurt içi çeviri kitap 15) ile C2a (yurt dışı 25): tek 'Çeviri
 *       Kitap' etiketi → 15. Aynı şekilde C1b/C2b ders kitabı (15/25) →
 *       'Ders / Metot Kitabı' 15; C3a/C4a bölüm çevirisi (5/8) → 5.
 *   D3/D4/D5 proje panelistliği ve hakemliği (10/10/8) ile G1/G2 dergi
 *       hakemliği ve yöneticiliği (3/1): tek 'Hakemlik' etiketi → 1.
 *   G3a/G3b (WoS dergi editörlüğü 15 / alan editörlüğü 10) → 10;
 *       G4a/G4b (diğer dergilerde 10/7) → 7.
 *   H1b/H2/H3 (kitap editörlüğü 10/10/8) → 8.
 *   F2/F3/F5 davetli konuşmacılık (15/10/5): tek 'Davetli Konuşmacı'
 *       etiketi → 5.
 *   K2a bilim ödülü (10) ile TÜBİTAK/TÜBA/YÖK ödülleri: tek 'Ulusal
 *       Bilim/Sanat Ödülü' ailesi → 10.
 *   L1 (WoS atıf 1) ile L3 (yurt içi kitapta atıf 1): aynı değer.
 *   J4a/J4b/J4c komisyon üyelikleri (1/3/1) → 1.
 *   M1/M2 kongre düzenleme (15'ten 3'e): `Diger` kategorisinin tek 'Diğer'
 *       etiketi → 3.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   L2 (SCI dışı dergilerde ve tezlerde atıf, 0,5 puan) — motorun `puan`
 *       alanı tam sayı; 0,5 aşağı yuvarlanınca 0 olurdu. Bu kayıt türleri
 *       L3'ün 1 puanlık satırına bağlandı.
 *   D1c/D2c (belgelendirilmiş proje BAŞVURUSU, 5 puan) — desteklenen
 *       projeyle aynı kaynağa düşer, motor en yükseği seçeceği için başvuru
 *       sahibini destekli gibi sayardı.
 *   F1/F4 (panel yöneticiliği, oturum başkanlığı) ve F7 (bilim kurulu
 *       üyeliği) — `Diger` kategorisinin tek etiketine düşüp M1/M2'yi 3'ten
 *       aşağı çekerlerdi; M1-M2 koşullarda ADIYLA anıldığı için o satır
 *       korundu, F satırları girilmedi.
 *   C5 (makale çevirisi 5) — 'Çeviri Kitap Bölümü' etiketi C3a/C4a'da
 *       kullanıldı.
 *   J9 (öğrenci topluluk danışmanlığı), J10 (yurt dışı deneyimi, kesintisiz
 *       en az 3 ay) — sözlükte karşılıksız ya da süreye bağlı.
 *   U1 (Web of Science h-indeks × 3) — h-indeksi bir PROFİL özelliği.
 *   O (radyo-TV-sinema), P (sanatsal ödüller), R (tiyatro ve sahne),
 *       S (sanatsal faaliyetler) ve T (sportif faaliyetler) bölümlerinin
 *       çoğu — sözlükteki sanat etiketleri M3-M5 ve N bölümlerinde
 *       kullanıldı; kalanlar aynı kayıt türlerine düştüğü için ayrı satır
 *       açılamadı. Konservatuvar ve spor adaylarının puanı bu yüzden
 *       olduğundan DÜŞÜK görünür.
 *
 * ── UYGULANAN TAVANLAR ──
 * L (atıflar) 40; G1-G2 (dergi hakemliği ve yöneticiliği) 20; J3b
 * (lisansüstü jüri üyeliği) 20; J7 (idari görevler) 20; J8 (ders verme) 20 —
 * hepsi kendi dipnotlarından.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   J4, J7, J8, J9 puanları YIL BAŞINA veriliyor ("her yıl için en fazla
 *       5 puan"); yıl biriktirmesi motorda yok, tek yıl değeri girildi ve
 *       puan DÜŞÜK görünür. Grup tavanları yine de yazıldı.
 *   C3c/C4c dipnotu "aynı kitapta 1 bölümden fazlası dikkate alınmaz" —
 *       eser bazlı tavan, motorda yok.
 *   T bölümü dipnotu "her bir madde için en fazla üç etkinlik" — adet
 *       tavanı; satır puanları sabit olsa da T bölümü girilemediği için
 *       konu dışı kaldı.
 *
 * Yönerge: yonerge/dicle.php
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 *
 * KİTAPTA YAYIM YERİ AYRIMI (19.09.2026): C2c/C4c "YURT DIŞINDA yabancı dilde
 * yayımlanmış", C1c/C3c "YURT İÇİNDE yayımlanmış" diyor. Dil koşulu kayıttan
 * okunamıyor ama alt satır yurt içine ait; kapsam etiketleri kendi satırlarına
 * bağlandı (kitap 40 ↔ 30, bölüm 15 ↔ 10, editörlük H1a 15).
 */

return [
    'kapsam_notu' => 'Puanlar Dicle Üniversitesi EK-1 puanlama sistemi tablosundan. '
        .'Yönerge ortak çalışmalarda yazar sayısına göre bir bölme kuralı TANIMLAMIYOR; bu '
        .'yüzden yazar çarpanı uygulanmıyor ve çok yazarlı çalışmalarınız tam puanla sayılıyor. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: yurt içi ve yurt dışı çeviri ile '
        .'ders kitapları, dergi editörlüğü ile alan editörlüğü, kitap editörlüğü türleri ve '
        .'davetli konuşmacılık düşük olan değerle birleşti; bütün hakemlik ve yayın kurulu '
        .'kalemleri tek satırda (1 puan) toplandı; kongre düzenleme görevleri en düşük '
        .'değerden (3 puan) sayılıyor; 0,5 puanlık atıf satırı, h-indeksi, yurt dışı deneyimi, '
        .'radyo-TV-sinema, tiyatro, sanatsal ve sportif faaliyet kalemlerinin çoğu hiç '
        .'girilemedi; idari görevlerin ve derslerin yıl biriktirmesi uygulanmıyor. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünebilir: aynı kitaptan birden fazla '
        .'bölümünüz varsa hepsi sayılır. '
        .'Proje BAŞVURULARINIZI kaydetmeyin: yönerge onlara ayrı ve düşük puan veriyor ama '
        .'kayıt türü desteklenen projeden ayrılamadığı için o satırlar girilmedi.',

    'maddeler' => [
        // ══ A. MAKALELER ══
        'A1' => ['baslik' => 'SSCI, AHCI, SCI-Expanded veya SCI tarafından taranan dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 20],
        'A2' => ['baslik' => 'SSCI, AHCI, SCI-Expanded veya SCI dergisinde derleme, vaka takdimi, teknik not, editöre mektup veya yorum', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 15],
        'A3' => ['baslik' => 'Diğer uluslararası alan endekslerince taranan dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI'], 'turler' => ['ozgun_makale'], 'puan' => 15],
        'A4' => ['baslik' => 'Diğer hakemli yabancı dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Scopus'], 'turler' => ['ozgun_makale'], 'puan' => 10],
        'A5' => ['baslik' => 'Diğer uluslararası alan endeksli ya da hakemli yabancı dergide derleme, vaka takdimi, teknik not, editöre mektup veya yorum', 'kategori' => 'makale', 'kaynaklar' => ['ESCI', 'Diğer Uluslararası İndeks', 'Scopus'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 8],
        'A6' => ['baslik' => 'ULAKBİM TR Dizin tarafından taranan ulusal hakemli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 10],
        'A7' => ['baslik' => 'ULAKBİM TR Dizin tarafından taranan ulusal hakemli dergide derleme, vaka takdimi, teknik not, editöre mektup veya yorum', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 7],
        'A8' => ['baslik' => 'ULAKBİM TR Dizin kapsamı dışındaki ulusal hakemli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale'], 'puan' => 5],
        'A9' => ['baslik' => 'ULAKBİM TR Dizin kapsamı dışındaki ulusal hakemli dergide derleme, vaka takdimi, teknik not, editöre mektup veya yorum', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 3],

        // ══ B. BİLDİRİLER ══
        'B1' => ['baslik' => 'Yurt dışındaki uluslararası kongre veya sempozyumda sunulup basılan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 10],
        'B2' => ['baslik' => 'Yurt içindeki uluslararası kongre veya sempozyumda sunulup basılan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 7],
        'B3' => ['baslik' => 'Yurt içindeki ulusal kongre veya sempozyumda sunulup basılan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin', 'Ulusal Özet/Poster'], 'puan' => 5],

        // ══ C. KİTAPLAR VE ÇEVİRİLER ══
        'C1a-C2a' => ['baslik' => 'Çeviri kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 15],
        'C1b-C2b' => ['baslik' => 'Derleme veya ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 15],
        'C1c' => ['baslik' => 'Yurt içinde yayımlanmış özgün araştırma kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 30],
        'C2c' => ['baslik' => 'Yurt dışında yabancı dilde yayımlanmış özgün araştırma kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası Kitap'], 'puan' => 40],
        'C3a-C4a' => ['baslik' => 'Kitapta çeviri bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 5],
        'C3c' => ['baslik' => 'Yurt içinde yayımlanmış özgün araştırma kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap Bölümü'], 'puan' => 10],
        'C4c' => ['baslik' => 'Yurt dışında yabancı dilde yayımlanmış özgün araştırma kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Uluslararası Kitap Bölümü'], 'puan' => 15],
        'C5b' => ['baslik' => 'Ansiklopedide madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 3],

        // ══ D. PROJELER (başvuru satırları girilmedi) ══
        'D1a' => ['baslik' => 'TÜBİTAK, TÜBA, kalkınma ajansı, SANTEZ, KOSGEB veya bakanlık destekli tamamlanmış projede koordinatör ya da yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 40],
        'D1b' => ['baslik' => 'TÜBİTAK, TÜBA, kalkınma ajansı, SANTEZ, KOSGEB veya bakanlık destekli tamamlanmış projede araştırmacı ya da raportör', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
        'D2a' => ['baslik' => 'Uluslararası kuruluşça desteklenmiş tamamlanmış projede koordinatör ya da yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 40],
        'D2b' => ['baslik' => 'Uluslararası kuruluşça desteklenmiş tamamlanmış projede araştırmacı ya da raportör', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
        'D6a' => ['baslik' => 'BAP tarafından desteklenmiş tamamlanmış projede koordinatör ya da yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 15],
        'D6b' => ['baslik' => 'BAP tarafından desteklenmiş tamamlanmış projede araştırmacı ya da raportör', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],

        // ══ E. PATENT / BURS ══
        'E1' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 100],
        'E2' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 50],
        'E3' => ['baslik' => 'Faydalı model veya ürün tescili', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili', 'Yazılım', 'Ticarileştirme'], 'puan' => 25],
        'E4' => ['baslik' => 'Bir aydan uzun süreli araştırma için alınan yurt dışı kaynaklı burs', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 10],

        // ══ F. BİLİMSEL TOPLANTILAR (yalnızca davetli konuşmacılık girilebildi) ══
        'F2-F5' => ['baslik' => 'Bilimsel toplantıda panelist ya da davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 5],

        // ══ G. DERGİLERDE EDİTÖRLÜK / HAKEMLİK ══
        'G1-G2' => ['baslik' => 'Dergilerde hakemlik, yayın kurulu üyeliği veya proje hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik', 'Yayın Kurulu Üyeliği'], 'puan' => 1],
        'G3' => ['baslik' => 'SSCI, AHCI, SCI, SCI-Expanded ya da uluslararası alan endeksli dergide editörlük veya alan editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI Dergi'], 'puan' => 10],
        'G4' => ['baslik' => 'Diğer yurt dışı ya da yurt içi hakemli dergide en az iki yıl editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi', 'Scopus Dergi'], 'puan' => 7],

        // ══ H. KİTAPLARDA EDİTÖRLÜK ══
        'H1a' => ['baslik' => 'Yurt dışında yayımlanmış yabancı dilde kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Uluslararası Kitap Editörlüğü'], 'puan' => 15],
        'H1b-H3' => ['baslik' => 'Yurt içinde yayımlanmış bilimsel, ders ya da çeviri kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 8],

        // ══ I. BİLİMSEL RAPORLAR ══
        'I1' => ['baslik' => 'Bir kurum veya kuruluş tarafından talep edilen bilimsel rapor', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı', 'Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 3],

        // ══ J. EĞİTİM FAALİYETLERİ ══
        'J1' => ['baslik' => 'Tamamlanmış yüksek lisans tezi yönetmek', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 5],
        'J2' => ['baslik' => 'Tamamlanmış doktora, sanatta yeterlik ya da uzmanlık tezi yönetmek', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 10],
        'J3a' => ['baslik' => 'Tamamlanmış lisansüstü tezde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi', 'Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 3],
        'J3b' => ['baslik' => 'Lisansüstü tez jürilerinde yer almak', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 2],
        'J4' => ['baslik' => 'Eğitim ve araştırma komisyonu, değişim programı koordinatörlüğü, etik kurul ya da kalite komisyonu üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 1],
        'J5-J6' => ['baslik' => 'Belgelendirilen meslek içi veya eğitim-öğretim eğitimi almak', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Akreditasyon Faaliyeti'], 'puan' => 1],
        'J7a' => ['baslik' => 'Rektörlük, rektör yardımcılığı, dekanlık, enstitü, yüksekokul veya konservatuvar müdürlüğü ya da başhekimlik', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü'], 'puan' => 5],
        'J7b' => ['baslik' => 'Dekan yardımcılığı, müdür yardımcılığı, bölüm başkanlığı ya da uygulama ve araştırma merkezi müdürlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkanı', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 3],
        'J7c' => ['baslik' => 'Anabilim dalı başkanlığı, bölüm başkan yardımcılığı ya da merkez müdür yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük', 'Bölüm Başkan Yardımcısı'], 'puan' => 2],
        'J8' => ['baslik' => 'Ön lisans, lisans veya lisansüstü düzeyde ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 2],

        // ══ K. ÖDÜLLER ══
        'K1' => ['baslik' => 'Bilimsel yarışma ve faaliyetlerle ilgili yurt dışı ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 15],
        'K2a' => ['baslik' => 'Bilimsel kuruluşlarca verilen bilim, hizmet veya teşvik ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 10],
        'K2b' => ['baslik' => 'Ulusal kongre ve sempozyumlarda bilimsel yarışma ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 7],

        // ══ L. ATIFLAR (grup tavanı 40) ══
        'L1' => ['baslik' => 'SSCI, AHCI, SCI-Expanded, SCI ya da Scopus dergilerinde çalışmalarınıza yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 1],
        'L3' => ['baslik' => 'Yurt içinde basılmış kitaplarda, ulusal dergilerde ya da tezlerde çalışmalarınıza yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 1],
        'L4' => ['baslik' => 'Yurt dışında basılmış kitaplarda çalışmalarınıza yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 3],

        // ══ M. BİLİMSEL VE SANATSAL ETKİNLİK DÜZENLEME ══
        'M1-M2' => ['baslik' => 'Ulusal veya uluslararası kongre ya da sempozyum düzenlemek', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 3],
        'M3a' => ['baslik' => 'Yurt içinde bireysel (kişisel) sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 10],
        'M3b' => ['baslik' => 'Ulusal bienal, trienal veya üniversite sergisi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Satın Alınması (Yurt İçi)'], 'puan' => 7],
        'M3c' => ['baslik' => 'Yurt içinde grup ya da karma sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 5],
        'M4a' => ['baslik' => 'Yurt dışında bireysel sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)'], 'puan' => 20],
        'M4b' => ['baslik' => 'Uluslararası bienal veya trienal', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Yayında Yer Alması / Satın Alınması'], 'puan' => 15],
        'M4c-M4d' => ['baslik' => 'Uluslararası grup ya da karma sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Karma Sergi (Uluslararası)'], 'puan' => 8],
        'M5' => ['baslik' => 'Kumaş, giysi veya aksesuar tasarımı koleksiyonu', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman'], 'puan' => 15],

        // ══ N. MÜZİK FAALİYETLERİ ══
        'N2a' => ['baslik' => 'Sahne yapıtı kompozisyonu', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera/Bale Kompozisyonu', 'Orkestralı Sahne Eseri'], 'puan' => 20],
        'N2b' => ['baslik' => 'Senfoni, konçerto gibi müzik yapıtı kompozisyonu', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Küçük Ölçekli Orkestra Eseri'], 'puan' => 15],
        'N2c-N2d' => ['baslik' => 'Dinleti, oda müziği, koro, solo yapıt ya da müzik ve sahne düzenlemesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)', 'Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi', 'Özgün Eser / Beste / Tasarım'], 'puan' => 7],
        'N2e' => ['baslik' => 'Elektronik müzik yapıtı (CD, DVD vb.)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Albüm / Konser Kaydı', 'Karma Albüm / CD-DVD Katkısı', 'Bandrollü Kayıt (CD/DVD)', 'Eğitim Müziği Albümü'], 'puan' => 10],
        'T9' => ['baslik' => 'Ulusal spor federasyonunun yönetim, teknik, eğitim ya da hakem kurulunda görev', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Spor Federasyonu Kurul Üyeliği (Ulusal)'], 'puan' => 3],
        'M2.a' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Ulusal)'], 'puan' => 10],
        'M1.a' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 15],
        'M2.c' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 3],
        'M1.c' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 5],
    ],

    // Madde 12-15'in koşullarının andığı kod aralıkları.
    'gruplar' => [
        'A1' => ['A1'],
        'A1-A2' => ['A1', 'A2'],
        'A1-A3' => ['A1', 'A2', 'A3'],
        'A-TUM' => ['A*'],
        'B-TUM' => ['B*'],
        'C-TUM' => ['C*'],
        'D-TUM' => ['D*'],
        // "A1-D2 kodları arasındaki faaliyetler" — A, B, C ve D bölümleri.
        'A1-D2' => ['A*', 'B*', 'C*', 'D*'],
        // "A-D ve M1-M2 kodları arasındaki faaliyetler" (yeniden atanma).
        'A-D-M' => ['A*', 'B*', 'C*', 'D*', 'M1-M2'],
        // "Proje ekibinde yer almak (D1-D5)".
        'D1-D5' => ['D1a', 'D1b', 'D2a', 'D2b'],
        // "Proje yürütücülüğü (D1a ve D2a)".
        'D1a-D2a' => ['D1a', 'D2a'],
        // "M1-M2 kodları arasındaki faaliyetler" (kongre düzenleme).
        'M1-M2' => ['M1-M2'],
        // Güzel Sanatlar için M1-M4, Konservatuvar için M1-M2 ve N1-N2.
        'M1-M4' => ['M1-M2', 'M3a', 'M3b', 'M3c', 'M4a', 'M4b', 'M4c-M4d'],
        'M1-M2-N1-N2' => ['M1-M2', 'N2a', 'N2b', 'N2c-N2d', 'N2e'],
        // "J1-J2 kodları arasından (lisansüstü tez yönetimi)".
        'J1-J2' => ['J1', 'J2'],
        // "L kodu (atıf) alanı".
        'L' => ['L1', 'L3', 'L4'],
        'G1-G2' => ['G1-G2'],
        'J3b' => ['J3b'],
        'J7' => ['J7a', 'J7b', 'J7c'],
        'J8' => ['J8'],
    ],

    'grup_tavanlari' => [
        'L' => 40,
        'G1-G2' => 20,
        'J3b' => 20,
        'J7' => 20,
        'J8' => 20,
    ],
];
