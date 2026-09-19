<?php

/**
 * ATAŞEHİR ADIGÜZEL MESLEK YÜKSEKOKULU — Akademik Etkinlik Değerlendirme
 * Tablosu
 * Kaynak: pdf/17537096622.atasehiradiguzelmeslekyuksekokulu.pdf
 * (Yüksekokul Kurulunun 20.07.2018 tarih 05 sayılı kararı, Mütevelli
 * Heyetin 23.07.2018 tarih 08 sayılı onayı.)
 *
 * Madde kodları tablonun kendi sıra numaraları; başlarındaki M harfi bize
 * ait (PHP salt sayısal dizi anahtarlarını tam sayıya çeviriyor). Satır
 * içindeki alt kalemler için .a, .b, .c alt kodları da bize ait.
 *
 * ── ALTINCI YAZARDAN SONRAKİ FORMÜL YAKLAŞTIRILDI (§0) ──
 * MADDE 6(10) altı ve daha fazla yazarlı eserlerde "ilk isim = (puan ×
 * 1,2) / yazar sayısı, diğer isimler = (puan − ilk ismin aldığı puan) /
 * diğer yazar sayısı" diyor. İlk isim formülü motorun `bol` kalıbıyla
 * birebir yazılabiliyor (pay 1,2). Diğer isimlerin formülü yazılamadığı
 * için pay 0,9 ile yaklaştırıldı; bu değer her yazar sayısında gerçek
 * formülün ALTINDA kalıyor (altı yazarlıda 0,150 ↔ 0,160; on yazarlıda
 * 0,090 ↔ 0,098), yani puanı fazla göstermiyor.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   Yayın ve bilim kurulu üyeliği 50/40/30/25 → 25; hakemlik 25/20/15/10
 *       → 10; "diğer uluslararası hakemli dergide editörlük" 80 ile ulusal
 *       hakemli dergide editörlük 50 tek etikete düşüyor → 50.
 *   Atıfta uluslararası kaynak kitap (20) ile ulusal referans kitap (10)
 *       tek 'BKCI Kitap' etiketine düşüyor → 10; diğer uluslararası dergi
 *       atfı (5) ile ulusal hakemli dergi atfı (3) → 3.
 *   Etkinlik düzenlemede uluslararası başkanlık (100), uluslararası görev
 *       (50), ulusal başkanlık (50) ve ulusal görev (25) tek 'Diğer'
 *       etiketine düşüyor → 25.
 *   Burslarda uluslararası (150) ile kamu bursu (100) → 100.
 *   'Yarışma Derecesi / Mansiyon' 01.09.2026'da M26.b'den çıkarıldı: 26. madde
 *       ödülü "(TÜBİTAK/TÜBA vb.)" parantezyle bu sınıfa bağlıyor, tek seferlik
 *       bir yarışma derecesi 250 puanlık satıra girmiyor.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   Madde 5 (ulusal diğer bilimsel dergiler, gazete ve dergiler, 20 puan,
 *       en çok iki çalışma) — hakemsiz yayınların sözlükte karşılığı yok.
 *   Tez izleme komitesi ve jüri üyelikleri, idari görevler ve topluma
 *       katkı kalemleri — tabloda hiç yok.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   MADDE 6(6): yalnız adayın ALANIYLA İLGİLİ etkinliklerin sayılması.
 *   MADDE 6(8): yayımlanması kabul edilmiş eserlerden en çok ikisinin
 *       yayımlanmış sayılması.
 *   Madde 10'un "sadece bir bölüm dikkate alınır", Madde 11 ile 12'nin
 *       "en fazla 2 bölüm" ve Madde 20'nin "son beş yılda, her yarıyılda
 *       en fazla dört ders" sınırları.
 *   Editörlük ve hakemlik satırlarının "her yıl için" hesaplanması.
 *
 * Yönerge: yonerge/atasehir-adiguzel.php
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 *
 * 19.09.2026: KİTAPTA YAYINEVİ KAPSAMI. 10. madde "Yurtdışında uluslararası
 * yayınevlerinde basılı olması şartıyla", 11. madde "alanıyla ilgili ULUSAL
 * nitelikte bir kitap" diyor; kaynak indeks ya da tanınmışlık aramıyor.
 * Satırlar `Uluslararası Kitap(+Bölümü)` ve `Ulusal Kitap(+Bölümü)`
 * etiketleriyle bağlandı; önceden indekssiz uluslararası kitap 150 yerine
 * 100, bölümü 100 yerine 25 puan alıyordu.
 */
$TAM = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];
$WOS = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];
$ULUSLARARASI_FON = ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'];
$ULUSAL_FON = ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'];
$KURUM_FON = ['BAP (Üniversite)', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'];

return [
    'kapsam_notu' => 'Puanlar Ataşehir Adıgüzel Meslek Yüksekokulu Akademik Etkinlik '
        .'Değerlendirme Tablosundan (2018). Yönerge bütün temel alanlara aynı ölçütleri '
        .'uyguluyor; alan ayrımı yok. Ortak çalışmalarda puan MADDE 6(10)\'un yazar sayısı × '
        .'sıra matrisine göre hesaplanıyor: iki yazarlıda %90 ve %80, üç yazarlıda %80, %70, '
        .'%60, dört yazarlıda %70\'ten %40\'a, beş yazarlıda %60\'tan %30\'a iner; altı ve daha '
        .'fazla yazarlıda ilk isim (puan × 1,2) / yazar sayısı alır. Sorumlu yazar MADDE 6(11) '
        .'uyarınca birinci isim sayılıyor. Yazar listesini boş bırakırsanız çarpan uygulanmaz '
        .'ve puanınız olduğundan yüksek görünür. '
        .'Tabloda tez izleme ve jüri üyeliği, idari görev ve topluma katkı satırı YOK; bu '
        .'kayıtlarınız toplam puanınıza katkı vermiyor. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: yayın kurulu üyeliği, hakemlik, '
        .'editörlük, atıf, etkinlik düzenleme ve burs satırlarının yüksek kademeleri kaynak '
        .'sözlüğünde düşük kademelerinden ayrılamadığı için en düşük değerden sayılıyor; '
        .'hakemsiz ulusal dergilerdeki yayınlar (madde 5, 20 puan) girilemedi. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünür: "aynı kitapta en fazla iki bölüm", '
        .'"her yarıyılda en fazla dört ders" ve "son beş yılda verilmiş dersler" sınırları ile '
        .'editörlük ve hakemliğin yıllık hesaplanması uygulanamıyor.',

    // MADDE 6(10) ve 6(11): yazar sayısı × sıra matrisi; sorumlu yazar
    // birinci isim sayıldığı için 'baslica' ile 'ilk' aynı satırı paylaşıyor.
    // Altı ve daha fazla yazarlıda ilk isim (puan × 1,2) / n; öbür isimlerin
    // formülü motorda yazılamadığı için 0,9 / n ile aşağıdan yaklaştırıldı.
    'yazar_katsayisi' => [
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.80, 4 => 0.70, 5 => 0.60], 'bol' => ['pay' => 1.2]],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.80, 4 => 0.70, 5 => 0.60], 'bol' => ['pay' => 1.2]],
            'yazar_2' => ['kademeler' => [2 => 0.80, 3 => 0.70, 4 => 0.60, 5 => 0.50], 'bol' => ['pay' => 0.9]],
            'yazar_3' => ['kademeler' => [3 => 0.60, 4 => 0.50, 5 => 0.40], 'bol' => ['pay' => 0.9]],
            'yazar_4' => ['kademeler' => [4 => 0.40, 5 => 0.30], 'bol' => ['pay' => 0.9]],
            'yazar_5' => ['kademeler' => [5 => 0.30], 'bol' => ['pay' => 0.9]],
            'yazar_6' => ['bol' => ['pay' => 0.9]],
            'ortak' => ['kademeler' => [2 => 0.80, 3 => 0.60, 4 => 0.40, 5 => 0.30], 'bol' => ['pay' => 0.9]],
        ],
    ],

    'maddeler' => [
        // ══ A. MAKALELER ══
        'M1.a' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergide yayımlanan özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $TAM, 'puan' => 100],
        'M1.b' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergide yayımlanan editöre mektup, teknik not, tartışma, vaka takdimi veya özet', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $KISA, 'puan' => 65],
        'M2.a' => ['baslik' => 'SCI, SCI-Expanded, SSCI ve AHCI dışındaki uluslararası indeksler tarafından taranan hakemli dergide yayımlanan özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $TAM, 'puan' => 80],
        'M2.b' => ['baslik' => 'SCI, SCI-Expanded, SSCI ve AHCI dışındaki uluslararası indeksler tarafından taranan hakemli dergide yayımlanan editöre mektup, teknik not, tartışma, vaka takdimi veya özet', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $KISA, 'puan' => 45],
        'M3.a' => ['baslik' => 'Diğer uluslararası hakemli dergide yayımlanan özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $TAM, 'puan' => 70],
        'M3.b' => ['baslik' => 'Diğer uluslararası hakemli dergide yayımlanan teknik not, editöre mektup, tartışma, vaka takdimi veya özet', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 40],
        'M4.a' => ['baslik' => 'Ulusal hakemli bilimsel dergide yayımlanan özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => 65],
        'M4.b' => ['baslik' => 'Ulusal hakemli bilimsel dergide yayımlanan teknik not, editöre mektup, tartışma, vaka takdimi veya özet', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 35],

        // ══ B. SANAT DALLARINDAKİ ETKİNLİKLER ══
        'M6.a' => ['baslik' => 'Özgün sanat yapıtının, tasarımın ya da yorum çalışmasının yurt dışındaki eğitim ve kültür kurumlarınca satın alınması, yayın organlarında yer alması veya tasarım projesinin dış ülkelerde uygulanmış olması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Haber Olması (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Belgesel/Kısa Film (Uluslararası)', 'Uygulama Projesi — Müellif', 'Koruma-Onarım Uygulaması (Uluslararası)'], 'puan' => 150],
        'M6.b' => ['baslik' => 'Yurt dışında kişisel sanat ya da tasarım etkinliğiyle gösterim, dinletim veya yarışmaya girmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Resital (Uluslararası)', 'Solistlik (Uluslararası)', 'Şan Resitali (Uluslararası)', 'Orkestra Şefliği (Uluslararası)', 'Opera Şefliği (Uluslararası)', 'Koro Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Uluslararası)', 'Grup Şefliği (Uluslararası)', 'Opera Birinci Rol (Uluslararası)', 'Bale Başrol (Uluslararası)', 'Rejisörlük (Uluslararası)', 'Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], 'puan' => 100],
        'M6.c' => ['baslik' => 'Yurt dışında sempozyum, festival, workshop, bienal ya da trienal gibi jürili karma sanat ve tasarım etkinliklerine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Karma Sergi (Uluslararası)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Oda Müziği Grup Üyeliği (Uluslararası)', 'Corps de Ballet (Uluslararası)', 'Opera İkinci Rol (Uluslararası)', 'Bale Solist Rol (Uluslararası)', 'Dansçı / Performans İcracısı (Uluslararası)', 'Masterclass (Uluslararası)', 'Eğitici Konser Programı (Uluslararası)', 'Başkemancılık (Uluslararası)', 'Oratoryo/Kantat Solistliği (Uluslararası)', 'Rejisör Yardımcılığı (Uluslararası)', 'Tüm Perde Koreograflığı (Uluslararası)', 'Bölüm Koreograflığı (Uluslararası)', 'Bale/Dans Koreograflığı (Uluslararası)', 'Sahneleme/Repetitörlük — Tüm Perde (Uluslararası)', 'Sahneleme/Repetitörlük — Bölüm (Uluslararası)'], 'puan' => 50],
        'M7.a' => ['baslik' => 'Özgün sanat yapıtının, tasarımın ya da yorum çalışmasının yurt içindeki eğitim ve kültür kurumlarınca satın alınması, ulusal yayın organlarında yer alması veya tasarım projesinin yurt içinde uygulanmış olması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Satın Alınması (Yurt İçi)', 'Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Haber Olması (Ulusal)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Belgesel/Kısa Film (Ulusal)', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman', 'Koruma-Onarım Uygulaması (Ulusal)', 'Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)', 'Karma Albüm / CD-DVD Katkısı', 'Eğitim Müziği Albümü'], 'puan' => 100],
        'M7.b' => ['baslik' => 'Ulusal düzeyde kişisel sanat ya da tasarım etkinliğiyle gösterim, dinletim veya yarışmaya girmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)', 'Resital (Ulusal)', 'Solistlik (Ulusal)', 'Şan Resitali (Ulusal)', 'Orkestra Şefliği (Ulusal)', 'Opera Şefliği (Ulusal)', 'Koro Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Ulusal)', 'Grup Şefliği (Ulusal)', 'Opera Birinci Rol (Ulusal)', 'Bale Başrol (Ulusal)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Yönetmenlik (Sahne/Ekran)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)', 'Özgün Eser / Beste / Tasarım', 'Opera/Bale Kompozisyonu', 'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Orkestralı Sahne Eseri', 'Küçük Ölçekli Orkestra Eseri', 'Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Sahne/Ekran Müziği', 'Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi', 'Sahne Tasarımı (Dekor, Kostüm, Işık)', 'Koreografi'], 'puan' => 50],
        'M7.c' => ['baslik' => 'Ulusal düzeyde sempozyum, festival, workshop, bienal ya da trienal gibi jürili karma sanat ve tasarım etkinliklerine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Oda Müziği Grup Üyeliği (Ulusal)', 'Orkestra / Koro Üyeliği', 'Corps de Ballet (Ulusal)', 'Opera İkinci Rol (Ulusal)', 'Bale Solist Rol (Ulusal)', 'Dansçı / Performans İcracısı (Ulusal)', 'Masterclass (Ulusal)', 'Eğitici Konser Programı (Ulusal)', 'Müzikoloji Atölyesi', 'Eğitim Amaçlı Sanat Etkinliği', 'Başkemancılık (Ulusal)', 'Oratoryo/Kantat Solistliği (Ulusal)', 'Rejisör Yardımcılığı (Ulusal)', 'Rejisör Yardımcılığı (Konservatuvar)', 'Tüm Perde Koreograflığı (Ulusal)', 'Bölüm Koreograflığı (Ulusal)', 'Bale/Dans Koreograflığı (Ulusal)', 'Sahneleme/Repetitörlük — Tüm Perde (Ulusal)', 'Sahneleme/Repetitörlük — Bölüm (Ulusal)'], 'puan' => 25],

        // ══ C. KONGRE SUNUMLARI ══
        'M8.a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulup SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergi özel sayısında veya kongre kitabında yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 60],
        'M8.b' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulup kongre kitapçığında tam metin olarak yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin'], 'puan' => 55],
        'M8.c' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulup özet metin olarak yayımlanan bildiri, poster ya da gösteri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 35],
        'M9.a' => ['baslik' => 'Ulusal bilimsel toplantıda sunulup tam metin olarak yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 50],
        'M9.b' => ['baslik' => 'Ulusal bilimsel toplantıda sunulup özet metin olarak yayımlanan bildiri, poster ya da gösteri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster', 'Davetli Konuşmacı'], 'puan' => 30],

        // ══ Ç. ALANINDA KİTAP YAZARLIĞI ══
        'M10.a' => ['baslik' => 'Yurt dışında uluslararası yayınevinde basılmış kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası Kitap'], 'puan' => 150],
        'M10.b' => ['baslik' => 'Yurt dışında uluslararası yayınevinde basılmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Uluslararası Kitap Bölümü'], 'puan' => 100],
        'M11.a' => ['baslik' => 'Alanıyla ilgili ulusal nitelikte kitap yazmak', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap', 'Ders / Metot Kitabı', 'Tahkik (Tenkitli Metin)'], 'puan' => 100],
        'M11.b' => ['baslik' => 'Alanıyla ilgili Türkçe yazılan bir kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 25],
        'M12.a' => ['baslik' => 'Alanındaki referans kitaplarından birinin çevirisini yapmak', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 50],
        'M12.b' => ['baslik' => 'Çevirisi yapılan bir kitabın bölümlerinden birinin çevirisini yüklenmek', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 15],

        // ══ D. EDİTÖRLÜK VE HAKEMLİKLER ══
        'M13.a' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergide editör olmak', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 150],
        'M14.a' => ['baslik' => 'SCI, SCI-Expanded, SSCI ve AHCI dışındaki uluslararası indeksler tarafından taranan hakemli dergide editörlük yapmak', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 100],
        'M16.a' => ['baslik' => 'Ulusal ya da diğer uluslararası hakemli bilimsel dergide editörlük yapmak', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 50],
        'M16.b' => ['baslik' => 'Hakemli bir dergide yayın ya da bilim kurulu listesinde yer almak', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 25],
        'M16.c' => ['baslik' => 'Hakemli bir dergide hakemlik yapmak', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 10],
        'M17.a' => ['baslik' => 'Alanında yurt dışında yayımlanan kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Uluslararası Kitap Editörlüğü'], 'puan' => 150],
        'M17.b' => ['baslik' => 'Alanında yurt içinde yayımlanan kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 100],

        // ══ E. ATIFLAR ══
        'M18.b' => ['baslik' => 'SCI, SSCI ya da AHCI tarafından taranan dergilerdeki atıflar', 'kategori' => 'atif', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 10],
        'M18.c' => ['baslik' => 'Diğer uluslararası dergilerde yayımlanan makalelerdeki atıflar', 'kategori' => 'atif', 'kaynaklar' => ['ESCI', 'Scopus', 'Diğer (Uluslararası)'], 'puan' => 5],
        'M19.a' => ['baslik' => 'Ulusal ya da uluslararası referans kitaplarındaki atıflar', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 10],
        'M19.b' => ['baslik' => 'Ulusal hakemli bilimsel dergilerdeki ve diğer yayınlardaki atıflar', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 3],

        // ══ F. ÖĞRETİM ETKİNLİKLERİ ══
        'M20.a' => ['baslik' => 'Son beş yılda verilmiş lisansüstü ders (her yarıyılda en fazla dört ders)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 5],
        'M20.b' => ['baslik' => 'Son beş yılda verilmiş ön lisans ya da lisans dersi (her yarıyılda en fazla dört ders)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 3],
        'M21.a' => ['baslik' => 'Yönetiminde tamamlanan doktora tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 20],
        'M21.b' => ['baslik' => 'Yönetiminde tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 10],

        // ══ G. BİLİMSEL ARAŞTIRMA ETKİNLİKLERİ ══
        'M22.a' => ['baslik' => 'Yurt dışı kaynaklı uluslararası tamamlanmış projeyi yürütmek', 'kategori' => 'proje', 'kaynaklar' => $ULUSLARARASI_FON, 'roller' => ['yurutucu'], 'puan' => 250],
        'M22.b' => ['baslik' => 'TÜBİTAK, DPT, TÜBA gibi ulusal kuruluşlarca desteklenen tamamlanmış projeyi yürütmek', 'kategori' => 'proje', 'kaynaklar' => $ULUSAL_FON, 'roller' => ['yurutucu'], 'puan' => 100],
        'M22.c' => ['baslik' => 'Yüksekokul tarafından desteklenen proje ya da uluslararası destekli eğitim projesini yürütmek', 'kategori' => 'proje', 'kaynaklar' => $KURUM_FON, 'roller' => ['yurutucu'], 'puan' => 50],
        'M23.a' => ['baslik' => 'Yurt dışı kaynaklı uluslararası tamamlanmış projede görev almak', 'kategori' => 'proje', 'kaynaklar' => $ULUSLARARASI_FON, 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 125],
        'M23.b' => ['baslik' => 'TÜBİTAK, DPT, TÜBA gibi ulusal kuruluşlarca desteklenen tamamlanmış projede görev almak', 'kategori' => 'proje', 'kaynaklar' => $ULUSAL_FON, 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 75],
        'M23.c' => ['baslik' => 'Yüksekokul tarafından desteklenen proje ya da uluslararası destekli eğitim projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => $KURUM_FON, 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 30],

        // ══ Ğ. DİĞER BİLİMSEL VE SANATSAL ETKİNLİKLER ══
        'M25.b' => ['baslik' => 'Ulusal ya da uluslararası sempozyum, kongre, çalıştay, yaz okulu, sanat sergisi veya festival düzenlenmesinde başkanlık yapmak ya da görev almak', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 25],

        // ══ H. ÖDÜLLER VE BURSLAR ══
        'M26.a' => ['baslik' => 'Alanında jürili uluslararası bilim veya sanat ödülü almak', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 350],
        'M26.a.p' => ['baslik' => 'Uluslararası patent almak', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 350],
        'M26.b' => ['baslik' => 'Alanında ulusal bilim (TÜBİTAK, TÜBA vb.) ya da sanat ödülü almak', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 250],
        'M26.b.p' => ['baslik' => 'Ulusal patent, faydalı model ya da tasarım tescili almak', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili', 'Yazılım', 'Ticarileştirme'], 'puan' => 250],
        'M27.b' => ['baslik' => 'Alanında bilimsel ya da sanatsal çalışma ve araştırmalar için burs almak', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 100],
        'TOPLANTI-UYE' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 25],
    ],

    'gruplar' => [
        // MADDE 4 ve 5'in atıf yaptığı "1-12 numaralı maddeler": makale,
        // sanat etkinlikleri, kongre sunumları, kitap yazarlığı ve çeviri.
        '1-12' => ['M1.a', 'M1.b', 'M2.a', 'M2.b', 'M3.a', 'M3.b', 'M4.a', 'M4.b',
            'M6.a', 'M6.b', 'M6.c', 'M7.a', 'M7.b', 'M7.c', 'M8.a', 'M8.b', 'M8.c',
            'M9.a', 'M9.b', 'M10.a', 'M10.b', 'M11.a', 'M11.b', 'M12.a', 'M12.b'],
        // Doktor öğretim üyeliğinin "ulusal ya da uluslararası hakemli bir
        // dergide bilimsel makale" koşulu.
        'HAKEMLI-MAKALE' => ['M1.a', 'M1.b', 'M2.a', 'M2.b', 'M3.a', 'M3.b', 'M4.a', 'M4.b'],
    ],

    'grup_tavanlari' => [],
];
