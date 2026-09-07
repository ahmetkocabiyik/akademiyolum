<?php

/**
 * BURDUR MEHMET AKİF ERSOY ÜNİVERSİTESİ — Öğretim Üyeliği Kadrolarına Başvuru
 * Koşulları ve Uygulama İlkeleri, MADDE 9 puanlama çizelgesi
 * Kaynak: pdf/17536991522.burdurmehmetakifersoyuniverstesi.pdf (13 sayfa;
 *         09/02/2016 tarih, 273 sayılı Senato toplantısının 13 no'lu kararı)
 *
 * DOSYANIN İLK İKİ SAYFASI ÜST YAZI, YÖNERGE 3-13. SAYFALARDA. Kayıt uzun süre
 * "yönerge değil, YÖK'e gönderilen üst yazı" diye duruyordu; teşhis yanlıştı.
 * PDF taranmış ve metin katmanı yok, ama tarama temiz: sayfalar 150 dpi'da
 * görüntü olarak okunabiliyor ve puan sütununun tamamı böyle doğrulandı.
 *
 * TEK BİR BİLİM ALANI SATIRI VAR. Taban puan tablosunun tek satırı "Sağlık
 * Bilimleri, Fen Bilimleri, Sosyal Bilimler" diyor; MADDE 2 ise yönergenin
 * güzel sanatlar bölümlerini de (tasarım, görüntü, müzik, sahne sanatları)
 * kapsadığını söylüyor. Alan ayrımı yok, on iki temel alanın hepsi aynı
 * barajlara tabi — korpusta ender.
 *
 * ÇİZELGE 65 MADDE, ONU BARAJA GİRİYOR. Baraj tablosu "1 inci – 24 üncü
 * maddelerden alınması gereken puan" diye ikinci bir katman koyuyor: makale,
 * bildiri, kitap, çeviri, editörlük, atıf ve sanatsal etkinlikler. 25 ve
 * sonrası (ders, tez, proje, ödül, idari görev, toplumsal katkı, sportif
 * faaliyet) yalnız toplam puana giriyor. Grup adı `M1-24`.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR (§0) ──
 *   19 (SCI atfı 5) ile 20 (diğer indeks atfı 2) tek "WoS / Scopus" etiketine
 *       düşüyor → 2.
 *   8'in yurt dışı (70) ve yurt içi (50) kitabı: BKCI etiketi yurt dışı
 *       satırdan, genel kitap etiketi yurt içi satırdan. 9'da aynısı (25/15).
 *   16 yardımcı editörlük ve yayın kurulu üyeliği "ilgili maddelerin yarısı"
 *       → en düşük dergiden (10/2 = 5); 17 hakemlik "beşte biri" → 10/5 = 2.
 *   18'in yurt dışı kitap editörlüğü (35) ile yurt içi (25): BKCI etiketi
 *       35'ten, genel kitap editörlüğü 25'ten.
 *   37 uluslararası burs (20) ile 38 ulusal burs (10) → 10.
 *   39 uluslararası konuşmacılık (15) ile ulusal (8) → 8.
 *   Sanatsal etkinliklerde uluslararası/ulusal ayrımı taşımayan etiketler
 *       daima ULUSAL satırdan sayılıyor.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   23 ULUSLARARASI BAŞVURU KİTAPLARINDAKİ ATIFLAR (atıf başına 10) — kayıt
 *       başvuru kitabı ayrımı taşımıyor.
 *   27 devam eden tez danışmanlığı (3); 35-36 sempozyum düzenleme (15/5/10/3);
 *       41 yurt dışı deneyimi (20); 42-43 jüri üyeliği ve proje danışmanlığı
 *       (7/5); 44-45 eğitim almak ve vermek (gün başına 1 ve 2); 56 değişim
 *       programı koordinatörlüğü (5).
 *   65. SPORTİF FAALİYETLERİN TAMAMI (on üç satır, 20 puana kadar).
 *   Ticarileştirilmiş patent: çizelgede satırı yok.
 *
 * ── UYGULANAMAYAN SINIRLAR ──
 * Çizelgenin dipnotları adet sınırları koyuyor: aynı kitapta en fazla üç
 * bölüm, yılda en fazla beş hakemlik, yılda en fazla beş konuşmacılık,
 * 50-56. maddelerden yılda yalnız üç görev, sportif faaliyetlerde yılda bir
 * etkinlik, "son beş yılda verilmiş dersler, her yarıyılda en fazla üç ders".
 * Motorda yıl ya da eser bazlı adet sınırı yok; bu kalemlerde puan YÜKSEK
 * çıkabilir. Çeviri ve editörlük puanlarının çevirmen ya da editör sayısına
 * bölünmesi de uygulanamıyor.
 *
 * ── YAZAR ÇARPANI ──
 * Yazar sayısı × isim sırası matrisi; beş ve üzeri yazarlı eserlerde beş
 * isimli satır uygulanıyor. Sorumlu yazar (corresponding author) 1. isimle
 * aynı sayıldığı için `baslica` ile `ilk` aynı satırı alıyor. Çizelge
 * "puanlamaların toplamında tam sayıdan sonra gelen 5 ve üzeri sayılar tam
 * sayıya tamamlanır" diyor; motor AŞAĞI yuvarlıyor, bu §0'ın istediği yön.
 * Matris yalnız MAKALELER için yazılmış; kitap ve çeviride puan editör ya da
 * çevirmen sayısına bölünüyor. Motor cetvel başına tek matris tanımladığı için
 * §1'in Acıbadem istisnası uygulandı ve MAKALE kuralı seçildi — barajların
 * yazıldığı 1-24 kümesinin ağırlığı makalelerde.
 *
 * Yönerge: yonerge/burdur.php
 *
 * KODLAR BİZE AİT — KAYNAKTA SATIR KODU YOK. Cetvel kodlarının SAYISAL
 * ÇEKİRDEĞİ kaynağın madde/bölüm numarasıdır; baştaki harf tabloyu ya da
 * eki, sondaki harf şıkkı gösterir ve ikisi de bizim eklediğimiz parçadır.
 * Koşullar bu kodlara atıf yaptığı için değiştirilmemeli; kaynakla
 * karşılaştırırken kodun sayısal çekirdeğine bakılmalı.
 */
$TAM = ['ozgun_makale', 'derleme'];
$YARIM = ['kisa_makale', 'vaka_teknik_not'];
$WOS = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];

$maddeler = [
    // ══ MAKALELER (1-5) ══
    'M1' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI tarafından taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $TAM, 'puan' => 50],
    'M1.5' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI dergisinde teknik not, editöre mektup, tartışma, vaka takdimi ya da özet', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $YARIM, 'puan' => 25],
    'M2' => ['baslik' => 'SCI, SCI-Expanded, SSCI ve AHCI dışındaki indeks ve özler tarafından taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $TAM, 'puan' => 30],
    'M2.5' => ['baslik' => 'Diğer indekslerce taranan dergide teknik not, editöre mektup, tartışma, vaka takdimi ya da özet', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $YARIM, 'puan' => 15],
    'M3' => ['baslik' => 'Hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TAM, 'puan' => 15],
    'M3.5' => ['baslik' => 'Hakemli dergide teknik not, editöre mektup, tartışma, vaka takdimi ya da özet', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $YARIM, 'puan' => 7],
    'M4' => ['baslik' => 'Diğer bilimsel dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => 8],
    'M4.5' => ['baslik' => 'Diğer bilimsel dergide teknik not, editöre mektup, tartışma, vaka takdimi ya da özet', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $YARIM, 'puan' => 4],

    // ══ BİLDİRİLER (6-7) ══
    'M6a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan ve tam metin yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 30],
    'M6b' => ['baslik' => 'Uluslararası bilimsel toplantıda özet olarak yayımlanan ya da poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 15],
    'M7a' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan ve tam metin yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 15],
    'M7b' => ['baslik' => 'Ulusal bilimsel toplantıda özet olarak yayımlanan ya da poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 10],

    // ══ KİTAPLAR VE ÇEVİRİLER (8-11) ══
    'M8a' => ['baslik' => 'Alanınızda yurt dışında yayımlanan kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 70],
    'M8b' => ['baslik' => 'Alanınızda yurt içinde yayımlanan kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı', 'Tahkik (Tenkitli Metin)'], 'puan' => 50],
    'M9a' => ['baslik' => 'Yurt dışında yayımlanan kitapta bölüm ya da ünite yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 25],
    'M9b' => ['baslik' => 'Yurt içinde yayımlanan kitapta bölüm, ünite ya da ansiklopedi maddesi yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 15],
    'M10' => ['baslik' => 'Alanınızda kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 20],
    'M11' => ['baslik' => 'Alanınızda kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 10],

    // ══ EDİTÖRLÜKLER VE HAKEMLİKLER (12-18) ══
    'M12' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI dergisinde editörlük (her yıl için)', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 50],
    'M13' => ['baslik' => 'Diğer indeks ve özlerce taranan dergide editörlük (her yıl için)', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 25],
    'M14' => ['baslik' => 'Hakemli bilimsel ya da mesleki dergide editörlük (her yıl için)', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 15],
    'M15' => ['baslik' => 'Diğer bilimsel ya da mesleki dergide editörlük (her yıl için)', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 10],
    'M16' => ['baslik' => 'Dergide yardımcı editörlük, konuk editörlük ya da yayın kurulu üyeliği (her yıl için)', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 5],
    'M17' => ['baslik' => 'Dergide hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 2],
    'M18a' => ['baslik' => 'Alanınızda yurt dışında yayımlanan kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 35],
    'M18b' => ['baslik' => 'Alanınızda yurt içinde yayımlanan kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 25],

    // ══ ATIFLAR (19-22) ══
    'M20' => ['baslik' => 'İndeks ve özlerce taranan dergilerde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 2],
    'M21' => ['baslik' => 'Hakemli dergilerde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 1],
    'M22' => ['baslik' => 'Kitap ya da diğer yayınlarda eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap', 'Diğer', 'Patent'], 'puan' => 1],

    // ══ SANATSAL ETKİNLİKLER (24) ══
    'M24a' => ['baslik' => 'Eserinizin yurt dışında satın alınması ya da sinema, televizyon, radyo gibi yayın organlarında yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)'], 'puan' => 50],
    'M24c' => ['baslik' => 'Uluslararası jürili ya da küratörlü karma etkinliğe kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Karma Sergi (Uluslararası)'], 'puan' => 30],
    'M24ç' => ['baslik' => 'Ulusal jürili ya da küratörlü karma etkinliğe kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 20],
    'M24d' => ['baslik' => 'Yurt dışında kişisel etkinlik (sergi, proje uygulama, gösteri, dinleti, gösterim)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Solistlik (Uluslararası)', 'Resital (Uluslararası)', 'Şan Resitali (Uluslararası)', 'Opera Birinci Rol (Uluslararası)', 'Bale Başrol (Uluslararası)', 'Orkestra Şefliği (Uluslararası)', 'Koro Şefliği (Uluslararası)', 'Opera Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Uluslararası)', 'Rejisörlük (Uluslararası)', 'Dansçı / Performans İcracısı (Uluslararası)'], 'puan' => 40],
    'M24f' => ['baslik' => 'Yurt içinde kişisel etkinlik (sergi, proje uygulama, gösteri, dinleti, gösterim)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)', 'Solistlik (Ulusal)', 'Resital (Ulusal)', 'Şan Resitali (Ulusal)', 'Opera Birinci Rol (Ulusal)', 'Opera İkinci Rol (Uluslararası)', 'Opera İkinci Rol (Ulusal)', 'Oratoryo/Kantat Solistliği (Uluslararası)', 'Oratoryo/Kantat Solistliği (Ulusal)', 'Bale Başrol (Ulusal)', 'Bale Solist Rol (Uluslararası)', 'Bale Solist Rol (Ulusal)', 'Orkestra Şefliği (Ulusal)', 'Koro Şefliği (Ulusal)', 'Opera Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Ulusal)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Rejisör Yardımcılığı (Uluslararası)', 'Rejisör Yardımcılığı (Ulusal)', 'Rejisör Yardımcılığı (Konservatuvar)', 'Dansçı / Performans İcracısı (Ulusal)', 'Koreografi', 'Tüm Perde Koreograflığı (Uluslararası)', 'Tüm Perde Koreograflığı (Ulusal)', 'Bölüm Koreograflığı (Uluslararası)', 'Bölüm Koreograflığı (Ulusal)', 'Bale/Dans Koreograflığı (Uluslararası)', 'Bale/Dans Koreograflığı (Ulusal)', 'Sahneleme/Repetitörlük — Tüm Perde (Uluslararası)', 'Sahneleme/Repetitörlük — Tüm Perde (Ulusal)', 'Sahneleme/Repetitörlük — Bölüm (Uluslararası)', 'Sahneleme/Repetitörlük — Bölüm (Ulusal)', 'Sahne Tasarımı (Dekor, Kostüm, Işık)', 'Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)', 'Başkemancılık (Uluslararası)', 'Başkemancılık (Ulusal)'], 'puan' => 20],
    'M24ğ' => ['baslik' => 'Eserinizin yurt içinde satın alınması, telif hakkının ödenmesi ya da yayın organlarında yer alması; tasarım projenizin uygulanmış olması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Müzeye Kabulü (Yurt İçi)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Uygulama Projesi — Müellif', 'Yönetmenlik (Sahne/Ekran)', 'Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)'], 'puan' => 30],
    'M24ı' => ['baslik' => 'Yurt dışında karma ya da grup etkinliğine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Oda Müziği Grup Üyeliği (Uluslararası)', 'Corps de Ballet (Uluslararası)', 'Grup Şefliği (Uluslararası)'], 'puan' => 15],
    'M24i' => ['baslik' => 'Yurt içinde karma ya da grup etkinliğine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Jürisiz, Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Oda Müziği Grup Üyeliği (Ulusal)', 'Corps de Ballet (Ulusal)', 'Grup Şefliği (Ulusal)', 'Orkestra / Koro Üyeliği'], 'puan' => 10],
    'M24l' => ['baslik' => 'Rehberliğinizde hazırlanan öğrenci eseri ya da yorumuyla yurt içi etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Masterclass (Uluslararası)', 'Masterclass (Ulusal)', 'Eğitim Amaçlı Sanat Etkinliği', 'Müzikoloji Atölyesi', 'Eğitici Konser Programı (Uluslararası)', 'Eğitici Konser Programı (Ulusal)'], 'puan' => 15],
    'M24m' => ['baslik' => 'Uluslararası yarışma jürisinde görev yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], 'puan' => 30],
    'M24n' => ['baslik' => 'Ulusal yarışma jürisinde görev yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 15],
    'M24-2a' => ['baslik' => 'Yayımlanmış multimedya CD tasarımı, ses ya da görüntü kaydı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım', 'Albüm / Konser Kaydı', 'Karma Albüm / CD-DVD Katkısı', 'Bandrollü Kayıt (CD/DVD)', 'Opera/Bale Kompozisyonu', 'Orkestralı Sahne Eseri', 'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Küçük Ölçekli Orkestra Eseri', 'Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Sahne/Ekran Müziği', 'Eğitim Müziği Albümü', 'Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi'], 'puan' => 10],
    'M24-2b' => ['baslik' => 'Yayımlanmış web tasarımı ve yönetimi; uygulanmış tasarım projesinde ekip üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman'], 'puan' => 5],
    'M24-2e' => ['baslik' => 'Basılmış afiş, poster, broşür, katalog, dergi ya da kitapta eserinizin yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Haber Olması (Uluslararası)', 'Eserin Haber Olması (Ulusal)'], 'puan' => 5],

    // ══ ÖĞRETİM FAALİYETLERİ (25) ══
    'M25' => ['baslik' => 'Son beş yılda verilmiş ders (her yarıyılda en fazla üç ders)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 1],

    // ══ TEZ YÖNETİMİ (26-28) ══
    'M26a' => ['baslik' => 'Yönetiminizde tamamlanan doktora, uzmanlık ya da sanatta yeterlik tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 15],
    'M26b' => ['baslik' => 'Yönetiminizde tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 10],
    'M28a' => ['baslik' => 'İkinci danışman olduğunuz tamamlanmış doktora, uzmanlık ya da sanatta yeterlik tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 7],
    'M28b' => ['baslik' => 'İkinci danışman olduğunuz tamamlanmış yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 5],

    // ══ ARAŞTIRMA PROJELERİ (29-34) ══
    'M29' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 50],
    'M30' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 25],
    'M31' => ['baslik' => 'Ulusal kuruluşlarca (TÜBİTAK, kalkınma ajansları, bakanlıklar) desteklenen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 30],
    'M32' => ['baslik' => 'Ulusal kuruluşlarca desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],
    'M33' => ['baslik' => 'Yerel kuruluşlarca (BAP ve diğer yerel kuruluşlar) desteklenen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 20],
    'M34' => ['baslik' => 'Yerel kuruluşlarca desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],

    // ══ DİĞER BİLİMSEL ETKİNLİKLER (37-40) ══
    'M38' => ['baslik' => 'Alanınızda bilimsel araştırma ve çalışmalar için burs almak', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 10],
    'M39' => ['baslik' => 'Panel, konferans, seminer, açık oturum ya da söyleşide konuşmacı veya panelist olarak görev yapmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 8],
    'M40a' => ['baslik' => 'Yurt dışında patentleşmiş buluş', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 300],
    'M40b' => ['baslik' => 'Yurt içinde patentleşmiş buluş', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 200],
    'M40c' => ['baslik' => 'Faydalı model, endüstriyel tasarım ya da çeşit tescili', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili', 'Yazılım'], 'puan' => 100],

    // ══ ÖDÜLLER (46-49) ══
    'M46' => ['baslik' => 'Alanınızda uluslararası bilim ve hizmet ödülü almak', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 40],
    'M47' => ['baslik' => 'Alanınızda uluslararası teşvik ödülü almak', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 20],
    'M48' => ['baslik' => 'Alanınızda ulusal bilimsel nitelikli ödül almak', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'YÖK Ödülü'], 'puan' => 20],
    'M49' => ['baslik' => 'Alanınızda ulusal teşvik ödülü ya da yarışma derecesi almak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 10],

    // ══ İDARİ VE AKADEMİK GÖREVLER (50-55) ══
    'M50' => ['baslik' => 'Rektörlük görevinde bulunmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör'], 'puan' => 20],
    'M51' => ['baslik' => 'Rektör yardımcılığı, dekanlık, enstitü, yüksekokul ya da meslek yüksekokulu müdürlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü'], 'puan' => 15],
    'M52' => ['baslik' => 'Dekan yardımcılığı, müdür yardımcılığı, merkez müdürlüğü ya da bölüm başkanlığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.', 'Uygulama ve Araştırma Merkezi Müdürü', 'Bölüm Başkanı'], 'puan' => 10],
    'M53' => ['baslik' => 'Merkez müdür yardımcılığı, bölüm başkan yardımcılığı ya da anabilim dalı başkanlığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 5],
    'M54' => ['baslik' => 'Üniversite organlarında ya da rektörlükçe kurulan komisyonlarda görev almak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 5],

    // ══ TOPLUMSAL KATKILAR (57-64) ══
    'M61' => ['baslik' => 'Kamu ya da özel kurum ve kuruluşlarda görev almak, katkıda bulunmak; basında yayın faaliyetinde bulunmak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi', 'Kamu/STK Danışmanlığı', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 5],
];

/** Baraj tablosunun ikinci katmanı: 1-24. maddeler. */
$M124 = [
    'M1', 'M1.5', 'M2', 'M2.5', 'M3', 'M3.5', 'M4', 'M4.5',
    'M6a', 'M6b', 'M7a', 'M7b',
    'M8a', 'M8b', 'M9a', 'M9b', 'M10', 'M11',
    'M12', 'M13', 'M14', 'M15', 'M16', 'M17', 'M18a', 'M18b',
    'M20', 'M21', 'M22',
    'M24a', 'M24c', 'M24ç', 'M24d', 'M24f', 'M24ğ', 'M24ı', 'M24i', 'M24l', 'M24m', 'M24n',
    'M24-2a', 'M24-2b', 'M24-2e',
];

return [
    'kapsam_notu' => 'Puanlar Mehmet Akif Ersoy Üniversitesi Öğretim Üyeliği Kadrolarına Başvuru '
        .'Koşulları ve Uygulama İlkeleri Hakkında Yönergenin MADDE 9 çizelgesinden (09/02/2016 '
        .'tarih ve 273/13 sayılı Senato kararı). Kaynak PDF taranmış; sayfalar görüntü olarak '
        .'okundu, puan sütununun tamamı gözle doğrulandı. Çizelge 65 maddeli; barajın ikinci '
        .'katmanı yalnız 1-24. maddeleri (makale, bildiri, kitap, çeviri, editörlük, atıf ve '
        .'sanatsal etkinlikler) sayıyor, 25 ve sonrası yalnız toplam puana giriyor. '
        .'Çok yazarlı makalede puan yazar sayısı × isim sırası matrisine göre bölünüyor; beş ve '
        .'üzeri yazarlı eserlerde beş isimli satır uygulanıyor ve sorumlu yazar 1. isimle aynı '
        .'sayılıyor. Yazar listesini boş bırakırsanız en düşük satır uygulanır. '
        .'PUANINIZ ŞU KALEMLERDE OLDUĞUNDAN DÜŞÜK GÖRÜNÜR: 65. SPORTİF FAALİYETLERİN TAMAMI '
        .'(on üç satır, 20 puana kadar), uluslararası başvuru kitaplarındaki atıflar (atıf '
        .'başına 10), devam eden tez danışmanlığı, sempozyum düzenleme, yurt dışı deneyimi, '
        .'jüri üyeliği ve proje danışmanlığı, eğitim almak ve vermek ile değişim programı '
        .'koordinatörlüğü kayıtta karşılıksız kaldı. Aynı etikete düşen satırlarda düşüğü '
        .'sayılıyor: SCI atfı diğer indeks değerinden (2), uluslararası burs ulusaldan (10), '
        .'uluslararası konuşmacılık ulusaldan (8), yardımcı editörlük ve hakemlik en düşük '
        .'dergiden (5 ve 2). Sanatsal etkinliklerde uluslararası/ulusal ayrımı taşımayan '
        .'kayıtlar ulusal satırdan sayılıyor. '
        .'PUANINIZ ŞU KALEMLERDE OLDUĞUNDAN YÜKSEK GÖRÜNEBİLİR: çizelgenin adet sınırları '
        .'(aynı kitapta en fazla üç bölüm, yılda en fazla beş hakemlik, yılda en fazla beş '
        .'konuşmacılık, idari görevlerden yılda yalnız üçü, her yarıyılda en fazla üç ders) '
        .'motorda uygulanamıyor. Çeviri ve editörlük puanlarının çevirmen ya da editör sayısına '
        .'bölünmesi de işlemiyor; kitap ve çeviride makale yazar matrisi uygulanıyor.',

    'yazar_katsayisi' => [
        'haric' => ['atif', 'proje', 'patent', 'tez_danismanligi', 'egitim_ogretim', 'editorluk',
            'odul', 'idari_gorev', 'toplumsal_katki', 'diger'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 1.00, 3 => 0.90, 4 => 0.85], 'sonrasi' => 0.80],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 1.00, 3 => 0.90, 4 => 0.85], 'sonrasi' => 0.80],
            'yazar_2' => ['kademeler' => [2 => 0.90, 3 => 0.80, 4 => 0.75], 'sonrasi' => 0.70],
            'yazar_3' => ['kademeler' => [3 => 0.70, 4 => 0.65], 'sonrasi' => 0.60],
            'yazar_4' => ['kademeler' => [4 => 0.55], 'sonrasi' => 0.50],
            'yazar_5' => ['sonrasi' => 0.40],
            'yazar_6' => ['sonrasi' => 0.40],
            'ortak' => ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.70, 4 => 0.55], 'sonrasi' => 0.40],
        ],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        'TUM' => array_keys($maddeler),
        'M1-24' => $M124,
    ],
];
