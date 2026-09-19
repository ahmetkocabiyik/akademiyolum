<?php

/**
 * HALİÇ ÜNİVERSİTESİ — Akademik Yükseltme ve Atama Yönergesi ekleri
 * Kaynak: pdf/1781013026765.halic-kriter-09062026.pdf
 *
 * Madde kodları yönergenin ek ve bölüm numaralarından türetildi
 * (EK1.A1 = EK-1'in A bölümünün 1. satırı).
 *
 * ── SCOPUS ÇEYREKLERİ WoS ÇEYREKLERİYLE EŞLEŞTİRİLDİ ──
 * Yönerge dergi çeyreğini Scopus CiteScore'a göre tanımlıyor; faaliyet
 * kaydı ise çeyreği SCIE/SSCI etiketlerinde taşıyor. Q1-Q4 satırları bu
 * etiketlere bağlandı. Çeyreği kayıtta belli olmayan ESCI/Scopus ve AHCI
 * dergileri §0 gereği en düşük kademeden (Q4, 20 puan) sayılıyor.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   A/1 (Scopus Q1'in en üst %10'u, 70) ile A/2 (diğer Q1, 50) tek
 *       'SCIE/SSCI (Q1)' etiketine düşüyor → 50.
 *   C/2 (Scopus-WoS uluslararası özet bildiri, 10) ile C/4 (diğer
 *       uluslararası bildiri özeti, 4) → 4.
 *   F/1-F/3 (Scopus dergi editörü 40, editör yardımcısı 20, alan editörü
 *       10) tek etiket kümesine düşüyor → 10. F/4 (yayın kurulu üyeliği 5)
 *       ile F/6 (TR Dizin editör yardımcılığı 5) → 5.
 *   EK-2'nin doktora tez danışmanlığında danışmanlık (8) ile eş
 *       danışmanlık (4) ayrılamıyor → 4.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   Ondalıklı puanlar (motor tam sayı taşıyor): EK-1/B-2 TR Dizin atfı
 *       (0,5), EK-2/9 kurul üyeliği (0,5/yıl). EK-2'nin yüksek lisans eş
 *       danışmanlığı da 1,5 olduğu için ayrılamadı; bu satırda tek
 *       danışmanlık değeri (3) girildi ve eş danışmanlıklarınız olduğundan
 *       yüksek puanlanıyor.
 *   EK-2/3 yüksek lisans proje danışmanlığı (1) — sözlükte karşılıksız.
 *   EK-3/A-1 ("en az İKİ kişisel etkinlikte yer almak", 24 puan) — puan tek
 *       etkinliğe değil dosyaya veriliyor; motor eser başına puanladığı için
 *       yazılmadı.
 *   EK-3'ün C/1, D/4, E/3, E/4, F/3 ve G/2 satırları (oyun-film-gösteride
 *       araştırma, yorum ve üretken görev almak; stüdyo kaydı; tiyatro
 *       topluluğu çalıştırmak) — sözlükte ayrışan karşılığı yok.
 *   EK-4 BEDEN EĞİTİMİ VE SPOR BİLİMLERİ formunun TAMAMI (akademik
 *       organizasyon, spor teşkilatı kurul üyeliği, antrenörlük, hakemlik,
 *       sporcu derecesi, eğiticilik) — faaliyet kaydında karşılığı yok.
 *       Spor Bilimleri adayının toplamı bu yüzden düşük çıkar.
 *   Kitapta çeviri satırları ile projelerde BAP: yönerge BAP'ı açıkça
 *       kapsam dışı bıraktığı için BAP ve öğrenci projesi etiketleri
 *       puanlanmıyor.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   Madde 5/3'ün "aynı çalışma yalnız bir kez puanlanır" mükerrer puan
 *       yasağı, EK-1/F'nin "editörlük görevi en az bir takvim yılı sürmüş
 *       olmalı" koşulu, EK-1/E'nin "başarı ile tamamlanmış" proje şartı ve
 *       EK-3'ün kanıt (katalog, afiş, kurum yazısı) koşulları.
 *   Kitap editörlüğünde puanın editör sayısına bölünmesi (EK-1 Ortak
 *       Çalışmalarda Puanlama Esası 2. fıkra) — editör sayısı kayıtta yok.
 *
 * Yönerge: yonerge/halic.php
 *
 * KODLAR BİZE AİT — KAYNAKTA SATIR KODU YOK. Cetvel kodlarının SAYISAL
 * ÇEKİRDEĞİ kaynağın madde/bölüm numarasıdır; baştaki harf tabloyu ya da
 * eki, sondaki harf şıkkı gösterir ve ikisi de bizim eklediğimiz parçadır.
 * Koşullar bu kodlara atıf yaptığı için değiştirilmemeli; kaynakla
 * karşılaştırırken kodun sayısal çekirdeğine bakılmalı.
 *
 * EK-4 (Beden Eğitimi ve Spor Bilimleri) girilmedi; 06.09.2026'da açılan
 * toplantı organizasyonu etiketleri de bu yüzden yazılamadı: A başlığının
 * düzenleme kurulu üyeliği satırları (16/12) yalnız spor alanı formunda
 * geçerli, EK-1/EK-2 adayına verilemez.
 */
$TAM = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];
$ULUSL_PROJE = ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'];
$ULUSAL_PROJE = ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'];
$SCOPUS_DERGI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI', 'ESCI / Scopus'];

$maddeler = [
    // ══ EK-1/A MAKALE ══
    // Sözlük 17.09.2026'da Scopus çeyrekliğini ayırdı. Bu merdivenin çeyreklikleri
    // kaynağın 4/c maddesine göre SCOPUS CiteScore'dan geliyor, WoS'tan
    // değil; etiketler WoS çeyrekliğine bağlıydı. Scopus Q1 makalesi
    // A5'e düşüp 20 alıyordu. WoS dergileri kaynağın kendi sözleriyle
    // A5'te ("Scopus dışı WoS dergide makale").
    // Kaynağın 1. sırası: "Scopus Q1 makale (En üst %10'luk dilim) — 70",
    // 2. sırası: "Scopus Q1 (Diğer) makale — 50". Üst dilim satırı sözlükte
    // karşılığı olmadığı için girilememişti; 17.09.2026'da dilim ekseni
    // eklendi. Kaynağın 4/b maddesi dilimi "Scopus CiteScore Percentile ≥90"
    // diye tanımlıyor.
    'EK1.A1' => ['baslik' => 'Scopus Q1 dergide, en üst %10\'luk dilimde makale', 'kategori' => 'makale', 'kaynaklar' => ['Scopus (İlk %10)'], 'turler' => $TAM, 'puan' => 70],
    'EK1.A2' => ['baslik' => 'Scopus Q1 dergide makale (üst %10 dışında)', 'kategori' => 'makale', 'kaynaklar' => ['Scopus (Q1)'], 'turler' => $TAM, 'puan' => 50],
    'EK1.A3' => ['baslik' => 'Scopus Q2 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Scopus (Q2)'], 'turler' => $TAM, 'puan' => 40],
    'EK1.A4' => ['baslik' => 'Scopus Q3 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Scopus (Q3)'], 'turler' => $TAM, 'puan' => 30],
    'EK1.A5' => ['baslik' => 'Scopus Q4 dergide ya da Scopus dışı WoS dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI', 'ESCI / Scopus'], 'turler' => $TAM, 'puan' => 20],
    'EK1.A6' => ['baslik' => 'Scopus veya WoS dergide yayımlanmış editöre mektup, teknik not, vaka analizi ya da tartışma', 'kategori' => 'makale', 'kaynaklar' => $SCOPUS_DERGI, 'turler' => $KISA, 'puan' => 6],
    'EK1.A8' => ['baslik' => 'TR Dizin dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TAM, 'puan' => 16],
    'EK1.A9' => ['baslik' => 'En az iki uluslararası ya da ulusal veri tabanında taranan diğer hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'], 'puan' => 6],

    // ══ EK-1/B ATIF ══
    'EK1.B1' => ['baslik' => 'Scopus atıf raporundaki her bir atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 1],

    // ══ EK-1/C KONFERANS ══
    'EK1.C1' => ['baslik' => 'Scopus veya WoS kapsamındaki uluslararası tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 16],
    'EK1.C3' => ['baslik' => 'Scopus ve WoS dışında uluslararası tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin'], 'puan' => 8],
    'EK1.C4' => ['baslik' => 'Uluslararası bildiri özeti ya da posteri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 4],
    'EK1.C5' => ['baslik' => 'Ulusal tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 4],
    'EK1.C6' => ['baslik' => 'Ulusal bildiri özeti ya da posteri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 2],

    // ══ EK-1/D KİTAP ══
    'EK1.D1' => ['baslik' => 'Scopus veya WoS kapsamındaki kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası Kitap'], 'puan' => 40],
    'EK1.D2' => ['baslik' => 'Scopus veya WoS kapsamındaki kitabın editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Uluslararası Kitap Editörlüğü'], 'puan' => 24],
    'EK1.D3' => ['baslik' => 'Scopus veya WoS kapsamındaki kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Uluslararası Kitap Bölümü'], 'puan' => 16],
    'EK1.D4' => ['baslik' => 'Diğer uluslararası ya da ulusal kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı'], 'puan' => 10],
    'EK1.D5' => ['baslik' => 'Diğer uluslararası ya da ulusal kitabın editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 6],
    'EK1.D6' => ['baslik' => 'Diğer uluslararası ya da ulusal kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 4],

    // ══ EK-1/E PROJELER ══
    'EK1.E1' => ['baslik' => 'Başarıyla tamamlanmış uluslararası fonlu projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => $ULUSL_PROJE, 'roller' => ['yurutucu'], 'puan' => 90],
    'EK1.E2' => ['baslik' => 'Başarıyla tamamlanmış uluslararası fonlu projede görev', 'kategori' => 'proje', 'kaynaklar' => $ULUSL_PROJE, 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 45],
    'EK1.E3' => ['baslik' => 'Başarıyla tamamlanmış ulusal projede (TÜBİTAK vb., BAP hariç) yürütücülük', 'kategori' => 'proje', 'kaynaklar' => $ULUSAL_PROJE, 'roller' => ['yurutucu'], 'puan' => 45],
    'EK1.E4' => ['baslik' => 'Başarıyla tamamlanmış ulusal projede (TÜBİTAK vb., BAP hariç) görev', 'kategori' => 'proje', 'kaynaklar' => $ULUSAL_PROJE, 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 22],

    // ══ EK-1/F EDİTÖRLÜK ══
    'EK1.F3' => ['baslik' => 'Scopus dergide editörlük, editör yardımcılığı ya da alan editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 10],
    'EK1.F4' => ['baslik' => 'Dergi yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 5],
    'EK1.F5' => ['baslik' => 'TR Dizin dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 10],

    // ══ EK-1/G PATENT ══
    'EK1.G1' => ['baslik' => 'Uluslararası tescil edilmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 50],
    'EK1.G2' => ['baslik' => 'Ulusal tescil edilmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 30],
    'EK1.G3' => ['baslik' => 'Faydalı model ya da tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım'], 'puan' => 15],

    // ══ EK-1/H ÖDÜL ══
    'EK1.H1' => ['baslik' => 'YÖK yılın doktora tezi ödülü, YÖK üstün başarı ödülü, TÜBİTAK bilim ya da teşvik ödülü, TÜBA GEBİP ya da TESEP ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 50],

    // ══ EK-2 DİĞER AKADEMİK ÇALIŞMALAR ══
    'EK2.1' => ['baslik' => 'Tamamlanan doktora tezi danışmanlığı ya da eş danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 4],
    'EK2.2' => ['baslik' => 'Tamamlanan yüksek lisans tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 3],
    'EK2.4' => ['baslik' => 'Bölüm ya da program başkanlığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı', 'Bölüm Başkan Yardımcısı'], 'puan' => 1],
    'EK2.5' => ['baslik' => 'Dekan yardımcılığı, müdür yardımcılığı ya da merkez müdürlüğü (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 2],
    'EK2.6' => ['baslik' => 'Dekanlık ya da müdürlük (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü'], 'puan' => 3],
    'EK2.7' => ['baslik' => 'Rektörlük ya da rektör yardımcılığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı'], 'puan' => 4],

    // ══ EK-3 SANAT VE MİMARLIK DALLARI ══
    'EK3.A2' => ['baslik' => 'Özgün sanat eseri, tasarım ya da yorum çalışmalarıyla karma-ortak etkinliğe (sergi, bienal, gösteri, dinleti, festival, gösterim) katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Karma Sergi (Uluslararası)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 16],
    'EK3.A3' => ['baslik' => 'Sempozyum, festival, çalıştay ya da bienal gibi etkinliklere eserle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 8],
    'EK3.B1' => ['baslik' => 'Özgün kompozisyon sunmak (saz eseri, sözlü eser, solo çalgı, oda müziği, orkestra, sahne ya da elektronik müzik)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım', 'Opera/Bale Kompozisyonu', 'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Orkestralı Sahne Eseri', 'Küçük Ölçekli Orkestra Eseri', 'Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Sahne/Ekran Müziği'], 'puan' => 10],
    'EK3.B2' => ['baslik' => 'Solo konser, resital ya da orkestra eşliğinde canlı solo konser vermek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Uluslararası)', 'Resital (Ulusal)', 'Solistlik (Uluslararası)', 'Solistlik (Ulusal)', 'Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 10],
    'EK3.B3' => ['baslik' => 'Türk müziği ses ve çalgılarına yönelik metot ya da alıştırma kitabı tarzında eser vermek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eğitim Müziği Düzenlemesi', 'Orkestrasyon/Transkripsiyon'], 'puan' => 5],
    'EK3.B4' => ['baslik' => 'En az 45 dakikalık solo icra albümü (bandrollü ya da dijital yayımlanmış kayıt)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)', 'Eğitim Müziği Albümü'], 'puan' => 20],
    'EK3.B5' => ['baslik' => 'Koro, karma ya da oda müziği konserinde icracı olarak bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra / Koro Üyeliği', 'Oda Müziği Grup Üyeliği (Uluslararası)', 'Oda Müziği Grup Üyeliği (Ulusal)', 'Karma Albüm / CD-DVD Katkısı', 'Başkemancılık (Uluslararası)', 'Başkemancılık (Ulusal)'], 'puan' => 5],
    'EK3.D1' => ['baslik' => 'Ödenekli ya da ulusal tiyatroda rol almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Dansçı / Performans İcracısı (Uluslararası)', 'Dansçı / Performans İcracısı (Ulusal)', 'Bale Başrol (Uluslararası)', 'Bale Başrol (Ulusal)'], 'puan' => 10],
    'EK3.D2' => ['baslik' => 'Ödenekli ya da ulusal tiyatroda oyun sahnelemek; opera eseri sahnelemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisörlük (Uluslararası)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Yönetmenlik (Sahne/Ekran)', 'Opera Şefliği (Uluslararası)', 'Opera Şefliği (Ulusal)'], 'puan' => 20],
    'EK3.D3' => ['baslik' => 'Atölye çalışması ya da ustalık sınıfı yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Masterclass (Uluslararası)', 'Masterclass (Ulusal)', 'Eğitici Konser Programı (Uluslararası)', 'Eğitici Konser Programı (Ulusal)', 'Müzikoloji Atölyesi'], 'puan' => 5],
    'EK3.D5' => ['baslik' => 'Rejisör yardımcılığı yapmış olmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisör Yardımcılığı (Uluslararası)', 'Rejisör Yardımcılığı (Ulusal)', 'Rejisör Yardımcılığı (Konservatuvar)'], 'puan' => 5],
    'EK3.E1' => ['baslik' => 'Dramatik metin ya da özgün oyun metni yazıp üretime veya sahneye sunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)'], 'puan' => 10],
    'EK3.F1' => ['baslik' => 'Opera eserinde solist icracı olarak bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera Birinci Rol (Uluslararası)', 'Opera Birinci Rol (Ulusal)', 'Şan Resitali (Uluslararası)', 'Şan Resitali (Ulusal)', 'Oratoryo/Kantat Solistliği (Uluslararası)', 'Oratoryo/Kantat Solistliği (Ulusal)'], 'puan' => 20],
    'EK3.F4' => ['baslik' => 'Farklı repertuvardan oluşan sahne etkinliğinde icracı olarak bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera İkinci Rol (Uluslararası)', 'Opera İkinci Rol (Ulusal)', 'Bale Solist Rol (Uluslararası)', 'Bale Solist Rol (Ulusal)', 'Corps de Ballet (Uluslararası)', 'Corps de Ballet (Ulusal)'], 'puan' => 5],
    'EK3.G1' => ['baslik' => 'Sahne, televizyon oyunu ya da gösteri tasarımı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne Tasarımı (Dekor, Kostüm, Işık)', 'Koreografi', 'Bale/Dans Koreograflığı (Uluslararası)', 'Bale/Dans Koreograflığı (Ulusal)', 'Tüm Perde Koreograflığı (Uluslararası)', 'Tüm Perde Koreograflığı (Ulusal)'], 'puan' => 16],
    'EK3.H1' => ['baslik' => 'Planlama, mimari proje, kentsel tasarım ya da endüstri tasarımı yarışmalarında jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 16],
    'EK3.H2' => ['baslik' => 'Uygulama projesi (kurum onayı, ruhsat, ihale belgesi ya da yayımlanmış raporla belgelenmiş)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman', 'Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)'], 'puan' => 16],
    'EK3.H3' => ['baslik' => 'Ulusal ya da uluslararası mimarlık ve tasarım yarışmalarında ödül, derece veya mansiyon', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon', 'Uluslararası Bilim/Sanat Ödülü', 'Ulusal Bilim/Sanat Ödülü'], 'puan' => 8],
];

$kodlar = fn (string ...$onekler): array => array_values(array_filter(
    array_keys($maddeler),
    fn (string $kod): bool => array_reduce($onekler, fn (bool $t, string $o): bool => $t || str_starts_with($kod, $o), false)
));

$EK1 = $kodlar('EK1.');
$EK2 = $kodlar('EK2.');
$EK3 = $kodlar('EK3.');

return [
    'kapsam_notu' => 'Puanlar Haliç Üniversitesi Akademik Yükseltme ve Atama Yönergesinin EK-1, '
        .'EK-2 ve EK-3 tablolarından. Makale, konferans ve kitap kalemlerinde ortak çalışma '
        .'çarpanı uygulanıyor: tek yazarlı çalışmada tam puan, iki yazarlıda %80, üç ve daha '
        .'fazla yazarlıda 1,8 × puan / yazar sayısı. Yazar listesini boş bırakırsanız çarpan '
        .'uygulanmaz ve puanınız olduğundan yüksek görünür. Atıflardan en fazla 40, '
        .'konferanslardan 40, projelerden 90, EK-2\'den 30, A/9 kapsamındaki dergilerden 12 puan '
        .'alınabiliyor. Dergi çeyreği yönergede Scopus CiteScore\'a göre belirleniyor; kayıtta '
        .'çeyreği bulunmayan ESCI, Scopus ve AHCI dergileri en düşük kademeden (20 puan) '
        .'sayılıyor. Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: ondalıklı satırlar '
        .'(TR Dizin atfı 0,5; kurul üyeliği 0,5) ve yüksek lisans proje danışmanlığı girilemedi; '
        .'EK-3\'ün "en az iki kişisel etkinlik" satırı dosyaya puan verdiği için yazılmadı; '
        .'EK-4 Beden Eğitimi ve Spor Bilimleri formunun tamamı faaliyet kaydında karşılıksız; '
        .'Scopus Q1\'in en üst %10\'u, editörlük kademeleri ve uluslararası özet bildiri kendi '
        .'alt kademelerinden ayrılamadığı için en düşük değerden sayılıyor. Puanınız şu kalemde '
        .'OLDUĞUNDAN YÜKSEK görünür: yüksek lisans eş danışmanlığı (1,5) tek danışmanlıktan '
        .'ayrılamadığı için 3 puandan sayılıyor.'
        .' KİTAPTA İNDEKS KOŞULU DENETLENMİYOR: uluslararası yayınevi kitabınız yönergenin BKCI/Scopus taranan kitap satırından sayılıyor. Kitabınız bu kapsamda değilse puanınız olduğundan YÜKSEK görünür; yönerge o kitabı daha düşük bir satırda sayıyor olabilir.',

    // EK-1 "Ortak Çalışmalarda Puanlama Esası": tek yazarlı tam puan, iki
    // yazarlı 0,8; üç ve daha fazla yazarlı 1,8 × puan / yazar sayısı.
    // Kural yalnızca EK-1/A, EK-1/C ve EK-1/D için yazılmış.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'editorluk', 'proje', 'patent', 'odul', 'tez_danismanligi', 'tez_yayini',
            'egitim_ogretim', 'idari_gorev', 'toplumsal_katki', 'sanatsal_etkinlik', 'diger'],
        'kademeler' => [1 => 1.00, 2 => 0.80],
        'sonrasi_pay' => 1.80,
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        'EK1' => $EK1,
        'EK2' => $EK2,
        'EK3' => $EK3,
        // Madde 9/3, 10/2 ve 11/2: EK-1 + EK-2; sanat alanlarında EK-3 de
        // eklenir. EK-4 (Spor Bilimleri) girilemedi.
        'TOPLAM' => [...$EK1, ...$EK2],
        'TOPLAM-SANAT' => [...$EK1, ...$EK2, ...$EK3],
        // Madde 9/2-a: başlıca eser EK-1/A (makale) ya da EK-1/D
        // (kitap/kitap bölümü) kapsamında olmalı; kitap editörlüğü sayılmaz.
        'EK1-A' => $kodlar('EK1.A'),
        'EK1-D-YAZAR' => ['EK1.D1', 'EK1.D3', 'EK1.D4', 'EK1.D6'],
        // Madde 9/2-b: EK-1/A–EK-1/D kapsamında en az bir eser.
        'EK1-A-D' => [...$kodlar('EK1.A', 'EK1.C'), 'EK1.D1', 'EK1.D3', 'EK1.D4', 'EK1.D6'],
        // Madde 9/2-b'nin EK-3 alternatifi: kişisel ve özgün nitelikli
        // faaliyetler (karma etkinlikler ve jüri üyeliği hariç).
        'EK3-KISISEL' => ['EK3.B1', 'EK3.B2', 'EK3.B3', 'EK3.B4', 'EK3.D1', 'EK3.D2', 'EK3.E1',
            'EK3.F1', 'EK3.G1', 'EK3.H2'],
        // Madde 9/4: tez danışmanlığı koşulu.
        'TEZ-DOKTORA' => ['EK2.1'],
        'TEZ-YL' => ['EK2.2'],
        // Tavan grupları.
        'ATIF' => ['EK1.B1'],
        'KONFERANS' => $kodlar('EK1.C'),
        'PROJE' => $kodlar('EK1.E'),
        'DIGER-HAKEMLI' => ['EK1.A9'],
        'ICRA' => ['EK3.B5'],
    ],

    'grup_tavanlari' => [
        'ATIF' => 40,
        'KONFERANS' => 40,
        'PROJE' => 90,
        'EK2' => 30,
        'DIGER-HAKEMLI' => 12,
        'ICRA' => 5,
    ],
];
