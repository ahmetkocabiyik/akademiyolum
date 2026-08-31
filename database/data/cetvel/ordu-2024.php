<?php

/**
 * ORDU ÜNİVERSİTESİ — TABLO-1 Akademik Etkinlik Puanlama Tablosu
 * Kaynak: pdf/1785505490169.ODÜ Atanma Yönergesi.pdf (31 sayfa;
 *         Senato 03.04.2024 ve 2024-58)
 *
 * 2017 SÜRÜMÜNÜN YERİNE GEÇTİ. Yeni yönergenin MADDE 14'ü eskisini açıkça
 * yürürlükten kaldırıyor. Eski `ordu-2017.php` cetveli silindi — hiçbir eşiğe
 * bağlı değildi ve canlı sanılıp düzenlenme riski taşıyordu; geçmişi git'te.
 *
 * MADDE KODLARI tablonun kendi numaralandırması (A.1, E.13, M.6 …).
 * TABLO-3'ten TABLO-13'e kadarki alan tabloları koşullarını HARF BÖLÜMÜNE
 * ve BENT ARALIĞINA atıf yaparak yazıyor ("A.1'den A.5'e kadar olan
 * kategorilerden en az 100 puan", "A.6 kapsamında en az 80 puan"), bu yüzden
 * numaralar birebir korundu ve aralıklar `gruplar` altında tanımlandı.
 *
 * PUANLAR 2017'YE GÖRE ÇOK DAHA DÜŞÜK: SCI makale 150 → 50, uluslararası
 * kitap 150 → 25, uluslararası patent 100 → 50. Toplam barajlar da düştü
 * (profesörlük 500'de kaldı, doçentlik 300 → 400, dr. öğr. üyeliği 100'de
 * kaldı) ama ölçek tümüyle değiştiği için eski ve yeni puanlar
 * KARŞILAŞTIRILAMAZ.
 *
 * ÇEYREK DİLİMİ SATIRLARI AYRI (A.1-A.4): 2017 sürümü SCI dergilerini tek
 * satırda topluyordu, 2024 sürümü Q1'den Q4'e dört ayrı satır veriyor.
 *
 * ── AYNI ETİKETE DÜŞEN SATIRLAR ──
 *   A.9 (editöre mektup, derleme, araştırma notu, özet, kitap kritiği) tek
 *       satır ve 5 puan; kayıtta bu türler ayrı ayrı tutulduğu için hepsi
 *       aynı satıra bağlandı.
 *   E.1-E.13 atıf satırlarının çoğu kaynak sözlüğünde ayrılamıyor; dergi
 *       atfı (E.1/E.2/E.3), kitap-tez atfı (E.4/E.5) ve patent atfı
 *       (E.11/E.12) olmak üzere üç satırda toplandı. E.13 (Ordu
 *       Üniversitesi dergilerine yapılan atıf) kayıtta ayrı etiketi
 *       olmadığı için girilmedi — o kalemi olan adayın gerçek puanı burada
 *       görünenden yüksektir.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   E.13 (Ordu Üniversitesi dergilerindeki atıf), F.22 (milli takım
 *       antrenörlüğü) ve F bölümünün yüzdeli sergileme çarpanları
 *       ("ilk sergileme %100, 2. sergileme %50") — kayıt kaçıncı sergileme
 *       olduğunu tutmuyor, §0 gereği hepsi TAM puandan sayıldı, yani bu
 *       satırlarda puan yüksek çıkabilir. Bu, kuralın tersine bir sapma
 *       olduğu için aday notunda söyleniyor.
 *   G.2 ve G.4 (patent BAŞVURUSU, "olumlu araştırma raporu düzenlenmiş")
 *       — başvuru aşaması faaliyet olarak tutulmuyor.
 *   N.1-N.3 (mimarlık yarışma ödülü, yazılım üreticiliği, uygulanmış
 *       proje hakkında yayın) ve O bölümünün tamamı (idari faaliyetler) —
 *       kayıt karşılığı yok.
 *   K.3 (ikinci danışmanlık, yarım puan) — kayıtta danışmanlık sırası
 *       tutulmuyor.
 *   L.4 (üniversite bünyesinde kurs ya da seminerde ders vermek) — kaynak
 *       sözlüğünde kurs eğitmenliği etiketi yok.
 */
$kapsamNotu = 'Puanlar Ordu Üniversitesi TABLO-1\'den (Senato 03.04.2024, 2024-58). '
        .'Ordu Üniversitesi dergilerine yapılan atıflar, milli takım antrenörlüğü, patent '
        .'BAŞVURUSU, mimarlık yarışma ödülleri, üniversite içi kurs eğitmenliği ve idari faaliyetler girilmedi. Sanat '
        .'etkinliklerinin tekrar sergileme indirimi (2. sergileme %50, 3. %25) '
        .'uygulanamıyor; o satırlarda puanınız gerçeğinden YÜKSEK görünebilir.';

$maddeler = [
    // ══ A. MAKALELER ══
    'A.1' => ['baslik' => 'SCI, SSCI, SCI-Expanded ya da AHCI kapsamındaki Q1 dergide araştırma makalesi veya olgu sunumu', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale', 'vaka_teknik_not'], 'puan' => 50],
    'A.2' => ['baslik' => 'SCI, SSCI, SCI-Expanded ya da AHCI kapsamındaki Q2 dergide araştırma makalesi veya olgu sunumu', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale', 'vaka_teknik_not'], 'puan' => 45],
    'A.3' => ['baslik' => 'SCI, SSCI, SCI-Expanded ya da AHCI kapsamındaki Q3 dergide araştırma makalesi veya olgu sunumu', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale', 'vaka_teknik_not'], 'puan' => 40],
    'A.4' => ['baslik' => 'SCI, SSCI, SCI-Expanded ya da AHCI kapsamındaki Q4 dergide araştırma makalesi veya olgu sunumu', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale', 'vaka_teknik_not'], 'puan' => 35],
    'A.5' => ['baslik' => 'ESCI, Scopus ya da alan indeksli dergide makale veya olgu sunumu', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'vaka_teknik_not'], 'puan' => 30],
    'A.6' => ['baslik' => 'TR Dizin tarafından taranan dergide araştırma makalesi veya olgu sunumu', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'vaka_teknik_not'], 'puan' => 20],
    'A.7' => ['baslik' => 'Diğer uluslararası hakemli dergide araştırma makalesi veya olgu sunumu', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'vaka_teknik_not'], 'puan' => 15],
    'A.8' => ['baslik' => 'TR Dizin dışında taranan ulusal hakemli dergide araştırma makalesi veya olgu sunumu', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'vaka_teknik_not'], 'puan' => 10],
    'A.9' => ['baslik' => 'Yukarıdaki dergilerde editöre mektup, derleme, araştırma notu, özet veya kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI', 'ESCI / Scopus', 'TR Dizin', 'Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'], 'turler' => ['derleme'], 'puan' => 5],

    // ══ B. ULUSAL / ULUSLARARASI BİLDİRİLER ══
    'B.1' => ['baslik' => 'Uluslararası bilimsel toplantıda tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 10],
    'B.2' => ['baslik' => 'Uluslararası bilimsel toplantıda özet metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 5],
    'B.3' => ['baslik' => 'Ulusal bilimsel toplantıda tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 5],
    'B.4' => ['baslik' => 'Ulusal bilimsel toplantıda özet metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 3],

    // ══ C. KİTAP / KİTAP BÖLÜMLERİ ══
    'C.1' => ['baslik' => 'Uluslararası yayınevinde yayımlanmış kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 25],
    'C.2' => ['baslik' => 'Uluslararası yayınevinde yayımlanmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 15],
    'C.3' => ['baslik' => 'Ulusal yayınevinde yayımlanmış kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı', 'Tahkik (Tenkitli Metin)'], 'puan' => 15],
    'C.4' => ['baslik' => 'Ulusal yayınevinde yayımlanmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 5],
    'C.5' => ['baslik' => 'Alanınızda uluslararası ansiklopedi bölümü ya da maddesi', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 5],

    // ══ D. ÇEVİRİLER ══
    'D.1' => ['baslik' => 'Uluslararası yayınevinde yayımlanmış bilimsel ya da sanatsal kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 10],
    'D.2' => ['baslik' => 'Ulusal yayınevinde yayımlanmış bilimsel ya da sanatsal kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 5],

    // ══ E. ATIFLAR ══
    'E.1' => ['baslik' => 'SCI, SSCI, SCI-Expanded, AHCI, ESCI ya da Scopus dergisinde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 5],
    'E.2' => ['baslik' => 'Alan indeksli ya da TR Dizin dergisinde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer'], 'puan' => 3],
    'E.4' => ['baslik' => 'Kitap ya da tezde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 3],
    'E.11' => ['baslik' => 'Patentte eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Patent'], 'puan' => 3],

    // ══ F. SANAT VE SPOR ETKİNLİKLERİ ══
    'F.1' => ['baslik' => 'Özgün sanat eserinizin yurt dışında satın alınması, yayımlanması, gösterime ya da dinletime girmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Kamusal Alanda Uygulanmış Yapıt (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt Dışı)'], 'puan' => 30],
    'F.2' => ['baslik' => 'Yurt dışında kamusal alanda kişisel sanat ya da tasarım etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)'], 'puan' => 25],
    'F.3' => ['baslik' => 'Özgün sanat eserinizin yurt içinde satın alınması, yayımlanması, gösterime ya da dinletime girmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Kamusal Alanda Uygulanmış Yapıt (Yurt İçi)', 'Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Yayında Yer Alması / Satın Alınması'], 'puan' => 20],
    'F.4' => ['baslik' => 'Yurt içinde kamusal alanda kişisel sergi açmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 15],
    'F.7' => ['baslik' => 'Yurt dışında karma ya da grup sanat, konser ve tasarım etkinliğine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Grup Etkinliği (Uluslararası)'], 'puan' => 15],
    'F.8' => ['baslik' => 'Uluslararası jürili karma sanat ya da tasarım etkinliğine kişi olarak katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)'], 'puan' => 15],
    'F.10' => ['baslik' => 'Jürili karma sanat ya da tasarım etkinliğine kişi olarak katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)'], 'puan' => 10],
    'F.11' => ['baslik' => 'Jürili karma sanat ya da tasarım etkinliğine grup olarak katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Jürisiz, Ulusal)', 'Grup Etkinliği (Ulusal)'], 'puan' => 5],
    'F.12' => ['baslik' => 'Uluslararası uygulamalı sanat sempozyumu, bienal ya da trienale uygulamacı olarak katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 15],
    'F.13' => ['baslik' => 'Uluslararası karma sergiye kişi olarak katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Elektronik Karma Sergi (Uluslararası)'], 'puan' => 10],
    'F.14' => ['baslik' => 'Ulusal karma sergiye grup olarak katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Elektronik Karma Sergi (Ulusal)'], 'puan' => 5],
    'F.16' => ['baslik' => 'Plastik sanatlarda eser restorasyonu ya da konservasyonu çalışmasına katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)'], 'puan' => 10],
    'F.17' => ['baslik' => 'Sanatsal etkinliğin projelendirmesini yapmak, sergi düzenlemek, uygulamalı etkinlik yönetmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sergi Küratörlüğü (Uluslararası)', 'Sergi Küratörlüğü (Ulusal)', 'Festival Koordinatörlüğü (Uluslararası)', 'Festival Koordinatörlüğü (Ulusal)'], 'puan' => 20],
    'F.19' => ['baslik' => 'Ulusal uygulamalı sanat sempozyumu, çalıştay ya da bienale uygulamacı olarak katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 3],
    'F.20' => ['baslik' => 'Sahne ya da görsel sanatlarda yönetmenlik, koreograflık veya performans sanatçılığı (yurt dışı sunum)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Yönetmenlik (Sahne/Ekran)', 'Rejisörlük (Uluslararası)', 'Dansçı / Performans İcracısı (Uluslararası)', 'Bale/Dans Koreograflığı (Uluslararası)', 'Sahne Tasarımı (Dekor, Kostüm, Işık)'], 'puan' => 5],
    'F.21' => ['baslik' => 'Sahne ya da görsel sanatlarda yönetmenlik, koreograflık veya performans sanatçılığı (yurt içi sunum)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Dansçı / Performans İcracısı (Ulusal)', 'Koreografi', 'Bale/Dans Koreograflığı (Ulusal)'], 'puan' => 3],
    'F.23' => ['baslik' => 'Yaratıcılık ve bestecilik niteliği taşıyan özgün müzik eseri sunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım', 'Opera/Bale Kompozisyonu', 'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Küçük Ölçekli Orkestra Eseri', 'Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Sahne/Ekran Müziği', 'Orkestralı Sahne Eseri'], 'puan' => 30],
    'F.24' => ['baslik' => 'Orkestra eşliğinde canlı solo konser ya da resital vermek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Şan Resitali (Uluslararası)', 'Şan Resitali (Ulusal)', 'Eğitici Konser Programı (Uluslararası)', 'Eğitici Konser Programı (Ulusal)'], 'puan' => 15],
    'F.25' => ['baslik' => 'Solo icracı olarak bandrollü ya da dijital yayımlanmış kayıt sahibi olmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bandrollü Kayıt (CD/DVD)', 'Albüm / Konser Kaydı'], 'puan' => 30],
    'F.26' => ['baslik' => 'Dijital müzik platformunda yayımlanmış albüm yapmış olmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Albüm / CD-DVD Katkısı', 'Eğitim Müziği Albümü'], 'puan' => 15],
    'F.28' => ['baslik' => 'Karma konserde icracı olarak bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra / Koro Üyeliği', 'Grup Şefliği (Uluslararası)', 'Grup Şefliği (Ulusal)'], 'puan' => 10],
    'F.29' => ['baslik' => 'Oda müziği konserinde icracı olarak bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Başkemancılık (Ulusal)', 'Masterclass (Uluslararası)', 'Masterclass (Ulusal)'], 'puan' => 15],

    // ══ G. PATENTLER ══ (yalnız tescil edilmiş olanlar)
    'G.1' => ['baslik' => 'Onay belgeli uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 50],
    'G.3' => ['baslik' => 'Onay belgeli ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 30],
    'G.5' => ['baslik' => 'Endüstriyel tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 30],
    'G.6' => ['baslik' => 'Faydalı model tescili', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 25],
    'G.7' => ['baslik' => 'Marka tescili', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 20],

    // ══ H. EDİTÖRLÜK ══
    'H.1' => ['baslik' => 'SCI, SSCI, SCI-Expanded ya da AHCI dergisinde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 20],
    'H.2' => ['baslik' => 'ESCI ya da Scopus dergisinde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 15],
    'H.3' => ['baslik' => 'Diğer uluslararası indeksli ya da TR Dizin dergisinde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 10],
    'H.4' => ['baslik' => 'Diğer bilimsel ya da sanatsal hakemli dergide editörlük ve hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi', 'Hakemlik', 'Yayın Kurulu Üyeliği'], 'puan' => 5],
    'H.5' => ['baslik' => 'Uluslararası yayınevinde yayımlanmış kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 15],
    'H.6' => ['baslik' => 'Ulusal yayınevinde yayımlanmış kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 10],

    // ══ I. ÖDÜLLER ══
    'I.1' => ['baslik' => 'Uluslararası jürili bilim, sanat ya da tasarım eseri ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 25],
    'I.3' => ['baslik' => 'Ulusal jürili bilim, sanat ya da tasarım eseri ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'YÖK Ödülü', 'Yarışma Derecesi / Mansiyon'], 'puan' => 20],

    // ══ K. TEZ YÖNETİMİ ══
    'K.1' => ['baslik' => 'Tamamlanmış doktora, uzmanlık ya da sanatta yeterlik tezi yönetmek', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 5],
    'K.2' => ['baslik' => 'Tamamlanmış yüksek lisans tezi yönetmek', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 3],

    // ══ L. ÖĞRETİM FAALİYETLERİ ══
    'L.1' => ['baslik' => 'Lisansüstü düzeyde ders vermek (son beş yılda en fazla beş ders)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 5],
    'L.2' => ['baslik' => 'Lisans ya da önlisans düzeyinde ders vermek (son beş yılda en fazla beş ders)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders'], 'puan' => 5],
    'L.5' => ['baslik' => 'Uluslararası değişim programı çerçevesinde ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Değişim Programı Dersi', 'Yabancı Dilde Ders'], 'puan' => 5],

    // ══ M. PROJELER ══
    'M.1' => ['baslik' => 'Uluslararası destekli sonuçlandırılmış projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 40],
    'M.2' => ['baslik' => 'Uluslararası destekli sonuçlandırılmış projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
    'M.3' => ['baslik' => 'TÜBİTAK, bakanlık ya da kalkınma ajansı destekli sonuçlandırılmış projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 15],
    'M.4' => ['baslik' => 'TÜBİTAK, bakanlık ya da kalkınma ajansı destekli sonuçlandırılmış projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
    'M.5' => ['baslik' => 'Üniversite BAP destekli sonuçlandırılmış projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 10],
    'M.6' => ['baslik' => 'Üniversite BAP destekli sonuçlandırılmış projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 5],

    // ══ N. DİĞER BİLİMSEL ETKİNLİKLER ══
    'N.4' => ['baslik' => 'Uluslararası sempozyum, çalıştay ya da kongrede davetli konuşmacı', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 10],
    'N.8' => ['baslik' => 'Jürili yarışmalarda danışmanlık ya da jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 25],
];

$gruplar = [
    // Alan tablolarının atıf yaptığı harf bölümleri ve bent aralıkları.
    'A' => ['A.*'],
    'A.1-A.4' => ['A.1', 'A.2', 'A.3', 'A.4'],
    'A.1-A.5' => ['A.1', 'A.2', 'A.3', 'A.4', 'A.5'],
    'A.1-A.6' => ['A.1', 'A.2', 'A.3', 'A.4', 'A.5', 'A.6'],
    'A.1-A.7' => ['A.1', 'A.2', 'A.3', 'A.4', 'A.5', 'A.6', 'A.7'],
    'A.1-A.8' => ['A.1', 'A.2', 'A.3', 'A.4', 'A.5', 'A.6', 'A.7', 'A.8'],
    'A.5-A.6' => ['A.5', 'A.6'],
    'A.6' => ['A.6'],
    'B' => ['B.*'],
    'C' => ['C.*'],
    'C-D' => ['C.*', 'D.*'],
    'D' => ['D.*'],
    'E' => ['E.*'],
    'F' => ['F.*'],
    'G' => ['G.*'],
    'H' => ['H.*'],
    'I' => ['I.*'],
    'K' => ['K.*'],
    'L' => ['L.*'],
    'M' => ['M.*'],
    'N' => ['N.*'],
    // Kategori dışı puanın toplandığı küme: "TOPLAM ASGARİ PUAN"
    // bütün tabloyu sayıyor.
    'TUM' => ['*'],
];

/**
 * TAVANLAR KADROYA, KİTAPTA TABLOYA GÖRE DEĞİŞİYOR.
 *
 * Her alan tablosu kategori satırlarında hem "en az" hem "en fazla
 * değerlendirmeye alınır" diyor. Alt barajlar eşiğin kendi düğümlerinde;
 * TAVANLAR burada, çünkü `grup_tavanlari` cetvel başına tanımlı ve tavan
 * kadroya göre değişiyor (KONVANSIYONLAR "Tavan FAKÜLTE × KADRO ise cetveli
 * çarpanla üret").
 *
 * Bildiri, atıf ve öğretim tavanları on bir tabloda da aynı; yalnız kitap
 * tavanı tablodan tabloya değişiyor ve beş tabloda kitap satırı hiç yok.
 * Bu yüzden varyant anahtarı kadro + kitap tavanı.
 *
 * @var array<string, array<string, int>>
 */
$KADRO_TAVANI = [
    'profesorluk' => ['B' => 40, 'E' => 200, 'L' => 80],
    'docentlik' => ['B' => 30, 'E' => 150, 'L' => 40],
    'dr' => ['B' => 30],
    'dr-yeniden' => ['B' => 30, 'L' => 40],
];

$cetveller = [];

foreach ($KADRO_TAVANI as $kadro => $tavan) {
    $cetveller["ordu-2024-{$kadro}"] = [
        'kapsam_notu' => $kapsamNotu,
        'maddeler' => $maddeler,
        'gruplar' => $gruplar,
        'grup_tavanlari' => $tavan,
    ];

    // Kitap tavanı olan tablolar için ayrı varyant.
    foreach ([60, 75, 120, 180] as $kitapTavani) {
        $cetveller["ordu-2024-{$kadro}-c{$kitapTavani}"] = [
            'kapsam_notu' => $kapsamNotu,
            'maddeler' => $maddeler,
            'gruplar' => $gruplar,
            'grup_tavanlari' => $tavan + ['C' => $kitapTavani],
        ];
    }
}

return ['cetveller' => $cetveller];
