<?php

/**
 * NECMETTİN ERBAKAN ÜNİVERSİTESİ — Tablo-1 Puanlama Tablosu
 * Kaynak: pdf/17721844331.Necmettin Erbakan Üniversitesi Kriteri 05.02.2026 GK.pdf
 *
 * Madde kodları Tablo-1'in kendi kodlarını izliyor (A1, D3, N4 …); makale
 * satırlarında kaynak ve yayın türü için açılan alt kodlar bize ait.
 *
 * ── A7'NİN YAYIN TÜRÜ ORANLARI SATIRA GÖMÜLDÜ ──
 * A7 bendi, A1-A6 dergilerinde yayımlanan derleme ile kısa makaleye o
 * satırın puanının %75'ini; teknik not, editöre mektup, olgu sunumu, özet
 * ve kitap kritiği türlerine %50'sini veriyor. Her kaynak etiketi için üç
 * satır açıldı (özgün / derleme-kısa / vaka-teknik) ve oranlar puanlara
 * gömülüp aşağı yuvarlandı.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   A1'in dört Q1 kademesi (ilk %1 için 200, ilk %5 için 175, ilk %10 için
 *       150, diğer Q1 için 100) tek 'SCIE/SSCI (Q1)' etiketine düşüyor →
 *       100. En üst dilimlerdeki makaleleriniz olduğundan düşük sayılır.
 *   SCOPUS dergileri A1'de çeyreğe göre puanlanıyor ama kayıtta ESCI ile
 *       aynı etikette; 'ESCI / Scopus' A2'nin ESCI değerinden (50)
 *       sayılıyor. Bu yüzden Scopus makaleleri A1 kategorisine de
 *       girmiyor, A1 barajına katkı vermiyor.
 *   'Diğer Uluslararası İndeks' etiketi A2 kategorisindeki indeksler (40)
 *       ile A4 kategorisindekileri (25) ayıramıyor → 25; bu satır A2
 *       barajına da sayılmıyor.
 *   Bildiride CPCI özet (15), özet metin (5) ve yayımlanmamış sunum (3)
 *       aynı etikete düşüyor → 3.
 *   Kitapta uluslararası (60) ile ulusal yayınevi (30) → 30; uluslararası
 *       bölüm (30) ile ulusal bölüm (15) → 15.
 *   Çeviride uluslararası (40) ile ulusal kitap çevirisi (20) → 20.
 *   Patentte onay belgeli (100 ve 60) ile olumlu araştırma raporlu (40 ve
 *       20) satırlar ayrışmıyor → uluslararası 40, ulusal 20; BAŞVURU
 *       satırları hiç girilmedi.
 *   Editörlükte A4 kategorisi (18) ile diğer hakemli dergiler (6) → 6;
 *       hakemlik ve yayın kurulu üyeliği ilgili puanların üçte biri
 *       olduğundan 6 ve 2.
 *   Atıfta SCI-SSCI-AHCI-SCOPUS (10) ile ESCI-A2 (7) → 7; uluslararası
 *       kitap atfı (5) ile ulusal kitap atfı (2) → 2.
 *   Tez yönetiminde ikinci danışmanlık puanın yarısı olduğundan doktora 5,
 *       yüksek lisans 3 girildi.
 *   Davetli konuşmacılıkta uluslararası (15) ile ulusal (5) → 5; jüri
 *       üyeliklerinde 30, 15 ve 5 → 5; toplantı düzenleme, proje
 *       hakemliği ve danışmanlık satırları tek 'Diğer' etiketinde → 5.
 *   Sanat bölümlerinde F ve G kategorileri aynı etiketlere düştüğü için
 *       her etikette en düşük değer girildi (yurt dışı kişisel etkinlik
 *       40, yurt içi 20, yurt dışı karma 15, yurt içi karma 10).
 *
 * ── DEVAM EDEN PROJELERE VE KISA SÜRELİ PROJELERE DÜŞÜK DEĞER (§0) ──
 * N bölümü her proje için iki sütun veriyor: destek süresi bir yıldan az
 * olanlar ve olmayanlar. Kayıt proje süresini taşımadığı için DÜŞÜK sütun
 * (bir yıldan az) esas alındı. Ayrıca "devam etmekte olan projelerde
 * puanların yarısı alınır" notu gereği bu değerler yarıya indirildi:
 * uluslararası proje yürütücülüğü 400 yerine 100, ulusal proje
 * yürütücülüğü 200 yerine 50 puan görünüyor.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   A5 (Necmettin Erbakan Üniversitesi dergilerinde makale, 20), I5 ve K5
 *       (aynı dergilerde editörlük ve atıf) — kayıt derginin hangi
 *       üniversiteye ait olduğunu taşımıyor.
 *   K16 (h-indeksi × 10) — faaliyet değil profil ölçütü.
 *   Patent, faydalı model ve marka BAŞVURUSU satırları (H3, H6).
 *   H12-H16 (girişimcilik, TGB, TTO danışmanlığı), F19-F26 (çalgı yapımı
 *       ve sportif faaliyetler), G14-G15 (sosyal medyada gösterim),
 *       M3-M5, M7, M10, O7-O9, O11-O12, O15, O17, P10-P14 (kalite ve
 *       akreditasyon süreçleri) — sözlükte karşılığı yok.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   A bölümünün "ilk 1000'e girmiş yurt dışı kurumdan ortak yazar varsa
 *       %25 ek puan" kuralı ile D bölümünün "yabancı dilde kitap için %50
 *       ek puan" kuralı: kayıt ortak yazarın kurumunu ve kitabın dilini
 *       taşımıyor, ek puanlar uygulanmıyor.
 *   F bölümünün çevrimiçi (%50) ve kayıttan (%25) etkinlik oranları ile
 *       düzenlemelerde %50 kuralı.
 *   I ve P bölümlerinin "son 5 yıldaki görevler her yıl ayrı puanlanır"
 *       kuralı ile M bölümünün "her yıl en fazla 5 ders" sınırı: kayıt
 *       görev süresini taşımadığı için her görev bir kez sayılıyor.
 *
 * Yönerge: yonerge/necmettin-erbakan.php
 */
$OZGUN = ['ozgun_makale'];
$DERLEME = ['derleme', 'kisa_makale'];
$VAKA = ['vaka_teknik_not'];

/**
 * A bölümünün bir kaynak etiketi için üç satırı: özgün makale (tam puan),
 * derleme ve kısa makale (%75), teknik not ve olgu sunumu (%50).
 *
 * @param  list<string>  $kaynaklar
 * @return array<string, array<string, mixed>>
 */
$makale = function (string $kod, string $ad, array $kaynaklar, int $puan) use ($OZGUN, $DERLEME, $VAKA): array {
    return [
        $kod => ['baslik' => $ad.' — özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => $kaynaklar, 'turler' => $OZGUN, 'puan' => $puan],
        $kod.'.d' => ['baslik' => $ad.' — derleme ya da kısa makale', 'kategori' => 'makale', 'kaynaklar' => $kaynaklar, 'turler' => $DERLEME, 'puan' => (int) floor($puan * 0.75)],
        $kod.'.v' => ['baslik' => $ad.' — teknik not, editöre mektup, olgu sunumu, özet ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => $kaynaklar, 'turler' => $VAKA, 'puan' => (int) floor($puan * 0.50)],
    ];
};

$maddeler = [
    // ══ A. MAKALELER ══
    // Kaynak Q1'in üstünde ÜÇ dilim kademesi tanıyor (sayfa 14, TABLO-1):
    // ilk %1 → 200, ilk %5 → 175, ilk %10 → 150; Q1'in 100'ü "%1-%10
    // dilimler dışındaki" demek. Sözlük 17.09.2026'da bu ekseni açtı.
    ...$makale('A1.d1', 'SCI-Expanded, SSCI ya da SCOPUS kapsamındaki Q1 dergide, ilk %1\'lik dilimde makale', ['SCIE/SSCI (İlk %1)'], 200),
    ...$makale('A1.d5', 'SCI-Expanded, SSCI ya da SCOPUS kapsamındaki Q1 dergide, ilk %5\'lik dilimde makale', ['SCIE/SSCI (İlk %5)'], 175),
    ...$makale('A1.d10', 'SCI-Expanded, SSCI ya da SCOPUS kapsamındaki Q1 dergide, ilk %10\'luk dilimde makale', ['SCIE/SSCI (İlk %10)', 'Scopus (İlk %10)'], 150),
    ...$makale('A1.q1', 'SCI-Expanded, SSCI ya da SCOPUS kapsamındaki Q1 dergide makale (ilk %10 dışında)', ['SCIE/SSCI (Q1)', 'Scopus (Q1)'], 100),
    ...$makale('A1.q2', 'SCI-Expanded, SSCI ya da SCOPUS kapsamındaki Q2 dergide makale', ['SCIE/SSCI (Q2)', 'Scopus (Q2)'], 85),
    ...$makale('A1.q3', 'SCI-Expanded, SSCI ya da SCOPUS kapsamındaki Q3 dergide makale', ['SCIE/SSCI (Q3)', 'Scopus (Q3)'], 70),
    // A1'in kümesi kaynağın kendi sözleriyle "SCI-Expanded, SSCI, AHCI VEYA
    // SCOPUS"; Scopus makalesi ESCI'nin satırına (A2, 50) değil BU merdivene
    // ait. 17.09.2026'da sözlük Scopus çeyrekliğini açtı, basamaklar tek tek
    // bağlandı (Q1 100 · Q2 85 · Q3 70 · Q4 60). Çeyreksiz `Scopus` kaydı
    // §0 uyarınca en alt basamakta kalıyor.
    ...$makale('A1.q4', 'SCI-Expanded, SSCI ya da SCOPUS kapsamındaki Q4 dergide makale', ['SCIE/SSCI (Q4)', 'Scopus'], 60),
    ...$makale('A1.ahci', 'AHCI kapsamındaki dergide makale (Q değeri yoksa Q3 sayılır)', ['AHCI'], 70),
    // A2 kaynakta yalnız "ESCI" diyor.
    ...$makale('A2', 'ESCI kapsamındaki dergide makale', ['ESCI'], 50),
    ...$makale('A3', 'ULAKBİM TR Dizin tarafından taranan dergide makale', ['TR Dizin'], 30),
    ...$makale('A4', 'Senato tarafından belirlenen indekslerde taranan dergide makale', ['Diğer Uluslararası İndeks'], 25),
    ...$makale('A6', 'Diğer uluslararası ya da ulusal hakemli dergide makale', ['Diğer Ulusal Hakemli'], 5),

    // ══ B. ULUSLARARASI BİLDİRİLER ══
    'B1' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulmuş, CPCI\'de yer alan bildiriler kitabında tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 30],
    'B3' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulmuş ve bildiriler kitabında tam metin yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin'], 'puan' => 10],
    'B4' => ['baslik' => 'Uluslararası bilimsel toplantıda özet metin, poster ya da sözlü sunum', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 3],

    // ══ C. ULUSAL BİLDİRİLER ══
    'C1' => ['baslik' => 'Ulusal bilimsel toplantıda sunulmuş ve bildiriler kitabında tam metin yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 5],
    'C2' => ['baslik' => 'Ulusal bilimsel toplantıda özet metin, poster ya da sözlü sunum', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 2],
    'O1' => ['baslik' => 'Sempozyum, çalıştay, kongre ve konferanslarda davetli konuşmacı ya da panelist olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 5],

    // ══ D. KİTAPLAR ══
    'D1' => ['baslik' => 'BKCI, Scopus, Jstor, DOAB gibi dizinlerde yer alan kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası Kitap'], 'puan' => 100],
    'D2' => ['baslik' => 'BKCI, Scopus, Jstor, DOAB gibi dizinlerde yer alan kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Uluslararası Kitap Bölümü'], 'puan' => 50],
    'D5' => ['baslik' => 'Uluslararası ya da ulusal yayınevinde yayımlanmış kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 30],
    'D6' => ['baslik' => 'Uluslararası ya da ulusal yayınevinde yayımlanmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 15],
    'D7' => ['baslik' => 'Ulusal yayınevinde yayımlanmış ders kitabı yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 10],
    'D8' => ['baslik' => 'Ansiklopedi bölümü ya da maddesi yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 5],
    'E2' => ['baslik' => 'Yayımlanmış bilimsel kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 20],
    'E4' => ['baslik' => 'Makale ya da bilimsel kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 10],

    // ══ F ve G. SAHNE VE GÖRSEL SANATLAR ETKİNLİKLERİ ══
    'FG1' => ['baslik' => 'Özgün sanat eserinin yurt dışındaki sanat, eğitim ve kültür kurumlarınca satın alınması ya da yayın organlarında gösterime girmesi; tasarım projesinin uygulanmış olması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Yayında Yer Alması / Satın Alınması', 'Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman'], 'puan' => 40],
    'FG2' => ['baslik' => 'Özgün sanat eserinin yurt içindeki sanat, eğitim ve kültür kurumlarınca satın alınması ya da yayın organlarında gösterime girmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Satın Alınması (Yurt İçi)'], 'puan' => 20],
    'F3' => ['baslik' => 'Özgün eserin (beste, düzenleme) gösterime ya da dinletime girmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım', 'Opera/Bale Kompozisyonu', 'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Orkestralı Sahne Eseri', 'Küçük Ölçekli Orkestra Eseri', 'Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Sahne/Ekran Müziği', 'Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi'], 'puan' => 10],
    'FG5' => ['baslik' => 'Yurt dışında kişisel sanat etkinliğinde bulunmak (kişisel sergi, resital, solo sahne performansı)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Resital (Uluslararası)', 'Şan Resitali (Uluslararası)', 'Solistlik (Uluslararası)', 'Oratoryo/Kantat Solistliği (Uluslararası)', 'Opera Birinci Rol (Uluslararası)', 'Bale Başrol (Uluslararası)'], 'puan' => 40],
    'FG6' => ['baslik' => 'Yurt içinde kişisel sanat etkinliğinde bulunmak (kişisel sergi, resital, solo sahne performansı)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Kişisel Sergi (Ulusal)', 'Resital (Ulusal)', 'Şan Resitali (Ulusal)', 'Solistlik (Ulusal)', 'Oratoryo/Kantat Solistliği (Ulusal)', 'Opera Birinci Rol (Ulusal)', 'Bale Başrol (Ulusal)'], 'puan' => 20],
    'FG7' => ['baslik' => 'Yurt dışında karma ya da grup sanat etkinliğinde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Elektronik Karma Sergi (Uluslararası)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Oda Müziği Grup Üyeliği (Uluslararası)', 'Başkemancılık (Uluslararası)', 'Corps de Ballet (Uluslararası)', 'Opera İkinci Rol (Uluslararası)', 'Bale Solist Rol (Uluslararası)', 'Dansçı / Performans İcracısı (Uluslararası)'], 'puan' => 15],
    'FG8' => ['baslik' => 'Yurt içinde karma ya da grup sanat etkinliğinde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Karma Sergi (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Oda Müziği Grup Üyeliği (Ulusal)', 'Başkemancılık (Ulusal)', 'Orkestra / Koro Üyeliği', 'Corps de Ballet (Ulusal)', 'Opera İkinci Rol (Ulusal)', 'Bale Solist Rol (Ulusal)', 'Dansçı / Performans İcracısı (Ulusal)'], 'puan' => 10],
    'F13' => ['baslik' => 'Uluslararası düzeyde sanatsal etkinlik düzenlemek; sanat yönetmeni, eğitmen ya da şef olarak bu etkinliklerde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra Şefliği (Uluslararası)', 'Koro Şefliği (Uluslararası)', 'Opera Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Uluslararası)', 'Grup Şefliği (Uluslararası)', 'Rejisörlük (Uluslararası)', 'Masterclass (Uluslararası)', 'Eğitici Konser Programı (Uluslararası)', 'Tüm Perde Koreograflığı (Uluslararası)', 'Bale/Dans Koreograflığı (Uluslararası)'], 'puan' => 20],
    'F14' => ['baslik' => 'Ulusal düzeyde sanatsal etkinlik düzenlemek; sanat yönetmeni, eğitmen ya da şef olarak bu etkinliklerde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra Şefliği (Ulusal)', 'Koro Şefliği (Ulusal)', 'Opera Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Ulusal)', 'Grup Şefliği (Ulusal)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Rejisör Yardımcılığı (Uluslararası)', 'Rejisör Yardımcılığı (Ulusal)', 'Rejisör Yardımcılığı (Konservatuvar)', 'Masterclass (Ulusal)', 'Eğitici Konser Programı (Ulusal)', 'Müzikoloji Atölyesi', 'Tüm Perde Koreograflığı (Ulusal)', 'Bale/Dans Koreograflığı (Ulusal)', 'Bölüm Koreograflığı (Uluslararası)', 'Bölüm Koreograflığı (Ulusal)', 'Koreografi', 'Sahne Tasarımı (Dekor, Kostüm, Işık)'], 'puan' => 10],
    'F17' => ['baslik' => 'Bireysel ses ya da görüntü yayımı (bandrollü ya da dijital platformda yayımlanmış albüm)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)'], 'puan' => 40],
    'F18' => ['baslik' => 'Karma ses ya da görüntü yayımı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Albüm / CD-DVD Katkısı', 'Eğitim Müziği Albümü'], 'puan' => 20],
    'G9' => ['baslik' => 'Müze, tarihi eser, yazma eser ya da koleksiyon malzemelerinin restorasyonu veya konservasyonu', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)'], 'puan' => 15],
    'G10' => ['baslik' => 'Uzun metraj sinema filmi, dizi ya da televizyon programında yönetmenlik, senaryo yazarlığı, görüntü yönetmenliği veya sanat yönetmenliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'], 'puan' => 30],
    'G11' => ['baslik' => 'Kısa film, belgesel, reklam filmi ya da mini dizide görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)'], 'puan' => 15],
    'G13' => ['baslik' => 'İnternet yayını yapan kanallarda program yapımcılığı, yönetmenlik ya da danışmanlık', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Yönetmenlik (Sahne/Ekran)'], 'puan' => 10],
    'K9' => ['baslik' => 'Sanatsal faaliyet, eser ve tasarım projelerinin yurt dışı basın ve yayın organlarında yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Haber Olması (Uluslararası)'], 'puan' => 5],
    'K10' => ['baslik' => 'Sanatsal faaliyet, eser ve tasarım projelerinin yurt içi basın ve yayın organlarında yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Haber Olması (Ulusal)'], 'puan' => 2],
    'O13' => ['baslik' => 'Jürili sanat, proje ve tasarım yarışmalarında jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 5],

    // ══ H. PATENTLER VE GİRİŞİMCİLİK ══
    'H2' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 40],
    'H5' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 20],
    'H7' => ['baslik' => 'Endüstriyel tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım'], 'puan' => 60],
    'H8' => ['baslik' => 'Faydalı model tescili', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Yazılım'], 'puan' => 50],
    'H11' => ['baslik' => 'Islahçı hakkı ya da çeşit tescili', 'kategori' => 'patent', 'kaynaklar' => ['Islahçı Hakkı / Çeşit Tescili'], 'puan' => 20],
    'H14' => ['baslik' => 'Teknoloji geliştirme bölgesinde faal şirket kurmak ya da ortağı olmak', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 40],

    // ══ I. EDİTÖRLÜK VE HAKEMLİKLER ══
    'I1' => ['baslik' => 'SSCI, SCI-Expanded, AHCI veya SCOPUS tarafından taranan dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'Scopus Dergi'], 'puan' => 60],
    'I2' => ['baslik' => 'ESCI ya da Senato tarafından belirlenen indekslerde taranan dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI Dergi'], 'puan' => 30],
    'I3' => ['baslik' => 'ULAKBİM TR Dizin tarafından taranan dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 24],
    'I6' => ['baslik' => 'Diğer bilimsel ve sanatsal hakemli dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 6],
    'I9' => ['baslik' => 'Dergilerde yayın ya da danışma kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 2],
    'I10' => ['baslik' => 'Dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 6],
    'I11' => ['baslik' => 'Uluslararası yayınevinde yayımlanmış kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Uluslararası Kitap Editörlüğü'], 'puan' => 50],
    'I12' => ['baslik' => 'Ulusal yayınevinde yayımlanmış kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 25],

    // ══ İ ve O. RAPORLAR VE DİĞER BİLİMSEL ETKİNLİKLER ══
    'I_RAPOR' => ['baslik' => 'Yurt dışında ya da yurt içinde yayımlanmış bilimsel rapor yazarlığı', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı'], 'puan' => 15],
    'O16' => ['baslik' => 'Öğrenci kulübü, topluluğu ya da sosyal sorumluluk danışmanlığı', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi'], 'puan' => 5],
    'G16' => ['baslik' => 'Radyo, televizyon ve gazetelerde alanı ile ilgili konularda yorumcu ya da konuşmacı olarak katılım', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Bilim İletişimi / Popüler Yayın'], 'puan' => 10],
    'O3' => ['baslik' => 'Bilimsel toplantı düzenleme kurulunda görev almak, proje hakemliği ya da panelistlik', 'kategori' => 'diger', 'kaynaklar' => ['Diğer', 'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 5],

    // ══ J. ÖDÜLLER ══
    'J1' => ['baslik' => 'Cumhurbaşkanlığı Kültür ve Sanat Büyük Ödülü, YÖK ödülleri, TÜBA ve TÜBİTAK bilim, teşvik, GEBİP ya da TESEP ödülleri, ERC ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 150],
    'J3' => ['baslik' => 'Uluslararası jürili bilim, sanat ya da tasarım eseri ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü'], 'puan' => 80],
    'J4' => ['baslik' => 'Ulusal jürili bilim, sanat ya da tasarım eseri ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'Yarışma Derecesi / Mansiyon'], 'puan' => 40],
    'J6' => ['baslik' => 'Bilimsel araştırmalar için üç aydan uzun süreli burs', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 10],

    // ══ K. ATIFLAR ══
    'K1' => ['baslik' => 'SCI-Expanded, SSCI, AHCI, SCOPUS ya da ESCI dergilerinde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 7],
    'K3' => ['baslik' => 'ULAKBİM TR Dizin dergilerinde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 5],
    'K6' => ['baslik' => 'Diğer bilimsel ve sanatsal hakemli dergilerde ve bildirilerde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer'], 'puan' => 1],
    'K8' => ['baslik' => 'Kitaplarda, kitap bölümlerinde ya da tezlerde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
    'K15' => ['baslik' => 'Patentlerde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Patent'], 'puan' => 3],

    // ══ L. TEZ YÖNETİMİ ══
    'L1' => ['baslik' => 'Tamamlanmış doktora, uzmanlık ya da sanatta yeterlik tezi yönetmek', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 5],
    'L2' => ['baslik' => 'Tamamlanmış yüksek lisans tezi yönetmek', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'puan' => 3],

    // ══ M. ÖĞRETİME KATKI ══
    'M1' => ['baslik' => 'Lisansüstü düzeyde ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 4],
    'M2' => ['baslik' => 'Lisans ya da önlisans düzeyinde ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders'], 'puan' => 4],
    'M6' => ['baslik' => 'Uluslararası değişim programı çerçevesinde ya da yabancı dilde ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 10],
    'M5' => ['baslik' => 'Bologna süreci ve akreditasyon etkinliklerine katkı vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Akreditasyon Faaliyeti'], 'puan' => 1],

    // ══ N. PROJELER (kısa süreli ve devam eden oranıyla) ══
    'N1' => ['baslik' => 'Uluslararası projede baş yürütücülük, koordinatörlük ya da yöneticilik', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 100],
    'N3' => ['baslik' => 'Uluslararası projede araştırmacılık, uzmanlık, bursiyerlik ya da danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 40],
    'N4' => ['baslik' => 'Ulusal projede (TÜBİTAK, TÜSEB, bakanlıklar, kalkınma ajansları) yürütücülük ya da koordinatörlük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 50],
    'N5' => ['baslik' => 'Ulusal projede araştırmacılık, uzmanlık, bursiyerlik ya da danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
    'N8' => ['baslik' => 'Diğer ulusal projede (BAP, yerel yönetim, özel kuruluş, STK, öğrenci projesi) yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 10],
    'N9' => ['baslik' => 'Diğer ulusal projede araştırmacılık, uzmanlık, bursiyerlik ya da danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 5],

    // ══ P. İDARİ AKTİVİTELER ══
    'P1' => ['baslik' => 'Rektörlük ya da rektör yardımcılığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı'], 'puan' => 45],
    'P2' => ['baslik' => 'Dekanlık, başhekimlik, enstitü, yüksekokul ya da konservatuvar müdürlüğü (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü'], 'puan' => 30],
    'P3' => ['baslik' => 'Dekan yardımcılığı ya da müdür yardımcılığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 10],
    'P6' => ['baslik' => 'Rektörlüğe bağlı araştırma merkezi müdürlüğü ya da koordinatörlük (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 10],
    'P8' => ['baslik' => 'Bölüm başkanlığı ya da bölüm başkan yardımcılığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı', 'Bölüm Başkan Yardımcısı'], 'puan' => 10],
    'P9' => ['baslik' => 'Rektörlükçe görevlendirilen üniversite düzeyindeki kurul ya da komisyon üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 5],
    'H16' => ['baslik' => 'Meslek odalarında, bakanlık komisyon ve kurullarında görev', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dış Kuruluş Kurul Üyeliği (Ulusal)'], 'puan' => 5],
];

$kodlar = fn (string ...$onekler): array => array_values(array_filter(
    array_keys($maddeler),
    fn (string $kod): bool => array_reduce($onekler, fn (bool $t, string $o): bool => $t || str_starts_with($kod, $o), false)
));

$A1 = $kodlar('A1.');
$A1_A2 = [...$A1, ...$kodlar('A2')];
$A1_A5 = [...$A1_A2, ...$kodlar('A3', 'A4')];
$KITAP = ['D1', 'D2', 'D5', 'D6', 'D7', 'D8', 'E2', 'E4'];
$SANAT = ['FG1', 'FG2', 'FG5', 'FG6', 'FG7', 'FG8', 'F3', 'F13', 'F14', 'F17', 'F18',
    'G9', 'G10', 'G11', 'G13', 'K9', 'K10', 'O13'];

return [
    'kapsam_notu' => 'Puanlar Necmettin Erbakan Üniversitesi Öğretim Üyeliğine Yükseltilme ve '
        .'Atanma Yönergesinin Tablo-1 Puanlama Tablosundan (05.02.2026). Ortak yayınlarda '
        .'Tablo-2 uygulanıyor: iki yazarlıda %95 ve %90; üç yazarlıda %90, %85, %80; her '
        .'yazar eklendiğinde kademeler beşer puan düşüyor ve on ve üzeri yazarlıda birinci isim '
        .'%55, onuncu isim %10 alıyor. Sorumlu yazar birinci isimle aynı sayılıyor. Yazar '
        .'listesini boş bırakırsanız çarpan uygulanmaz ve puanınız olduğundan yüksek görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: A1\'in ilk %1, %5 ve %10 dilim '
        .'kademeleri (200, 175, 150 puan) kayıtta ayrışmadığı için Q1 makaleleri 100 puandan '
        .'sayılıyor; SCOPUS dergileri ESCI ile aynı etikette olduğu için 50 puandan sayılıyor '
        .'ve A1 barajına katkı vermiyor; projelerde bir yıldan uzun süreli ve tamamlanmış olma '
        .'ayrımı yapılamadığı için en düşük değerler (bir yıldan kısa ve devam eden proje '
        .'oranı) uygulandı; patentte onay belgesi ile araştırma raporu ayrışmıyor; h-indeksi, '
        .'girişimcilik, sportif faaliyet ve akreditasyon satırları girilemedi; "son beş yılda '
        .'her yıl ayrı puanlanır" kuralı uygulanamadığı için idari görev ve editörlükler bir '
        .'kez sayılıyor. Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünür: yurt dışı ortak '
        .'yazarlık için verilen %25 ve yabancı dilde kitap için verilen %50 ek puanlar '
        .'uygulanamadığı gibi, tersine, ikinci danışmanlık ve çevrimiçi etkinlik indirimleri de '
        .'uygulanamıyor.'
        .' KİTAPTA İNDEKS KOŞULU DENETLENMİYOR: uluslararası yayınevi kitabınız yönergenin BKCI/Scopus taranan kitap satırından sayılıyor. Kitabınız bu kapsamda değilse puanınız olduğundan YÜKSEK görünür; yönerge o kitabı daha düşük bir satırda sayıyor olabilir.',

    // Tablo-2 (Yazar/Oran Tablosu). Sorumlu yazar 1. isimle aynı.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'editorluk', 'proje', 'tez_danismanligi', 'tez_yayini',
            'egitim_ogretim', 'idari_gorev', 'toplumsal_katki', 'odul', 'diger'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.95, 3 => 0.90, 4 => 0.85, 5 => 0.80, 6 => 0.75, 7 => 0.70, 8 => 0.65, 9 => 0.60], 'sonrasi' => 0.55],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.95, 3 => 0.90, 4 => 0.85, 5 => 0.80, 6 => 0.75, 7 => 0.70, 8 => 0.65, 9 => 0.60], 'sonrasi' => 0.55],
            'yazar_2' => ['kademeler' => [2 => 0.90, 3 => 0.85, 4 => 0.80, 5 => 0.75, 6 => 0.70, 7 => 0.65, 8 => 0.60, 9 => 0.55], 'sonrasi' => 0.50],
            'yazar_3' => ['kademeler' => [3 => 0.80, 4 => 0.75, 5 => 0.70, 6 => 0.65, 7 => 0.60, 8 => 0.55, 9 => 0.50], 'sonrasi' => 0.45],
            'yazar_4' => ['kademeler' => [4 => 0.70, 5 => 0.65, 6 => 0.60, 7 => 0.55, 8 => 0.50, 9 => 0.45], 'sonrasi' => 0.40],
            'yazar_5' => ['kademeler' => [5 => 0.60, 6 => 0.55, 7 => 0.50, 8 => 0.45, 9 => 0.40], 'sonrasi' => 0.35],
            'yazar_6' => ['kademeler' => [6 => 0.50, 7 => 0.45, 8 => 0.40, 9 => 0.35], 'sonrasi' => 0.30],
            'ortak' => ['sonrasi' => 0.10],
        ],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        'TOPLAM' => array_keys($maddeler),
        // Tablo-3'ün "A1", "A1 veya A2" ve "A1, A2, A3, A4, A5" kümeleri.
        // SCOPUS ile ESCI ayrışmadığı için A2 satırı A1'e dahil edilmedi;
        // 'Diğer Uluslararası İndeks' satırı da A4 değerinden girildiği için
        // A2 kümesinin dışında tutuldu.
        'A1' => $A1,
        'A1-A2' => $A1_A2,
        'A1-A5' => $A1_A5,
        // Tablo-3'ün K (atıf), D (kitap), N (proje) ve F-G (sanat) barajları.
        'K' => ['K1', 'K3', 'K6', 'K8', 'K15'],
        'D' => $KITAP,
        'N' => $kodlar('N'),
        'F-G' => $SANAT,
    ],

    'grup_tavanlari' => [],
];
