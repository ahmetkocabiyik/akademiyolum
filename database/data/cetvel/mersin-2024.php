<?php

/**
 * MERSİN ÜNİVERSİTESİ — puan cetveli (Senato 07/02/2024, 2024/15)
 * Kaynak: pdf/17537003802.mersinuniverstesi.pdf
 *
 * Yönerge puanları ÜÇ ayrı listede tanımlıyor ve hangi listenin geçerli olduğu
 * adayın alanına göre değişiyor:
 *
 *   TABLO A  Akademik Etkinlikler (makale, kitap, proje)   — çoğu temel alan
 *   TABLO B  Güzel Sanatlar ile Mimarlık/Planlama/Tasarım  — s. 23-25
 *   TABLO C  Konservatuvar (müzik, sahne sanatları)        — s. 25-28
 *
 * Üçü tek cetvelde tutuluyor çünkü hepsi aynı yönergenin ekleri. Ayrım
 * kaybolmuyor: her liste `A` / `B` / `C` grubuyla adlandırılmış ve eşikler
 * puan barajını hangi listeden istiyorsa o grubu veriyor. Güzel sanatlar
 * adayının makalesi TABLO A'da puanlanır ama sanat barajına SAYILMAZ —
 * grup kapsamı bunu garanti eder.
 *
 * Gruplar `array_keys()` ile türetiliyor; yeni bir madde eklenip listesine
 * yazılmayı unutması mümkün değil.
 *
 * MADDE KODLARI yönergenin kendi kodlarıdır, üç listede de birbirinden ayrık:
 * TABLO A noktalı ("2.a", "5.g"), TABLO B düz harf ("ç-1", "m-2"), TABLO C
 * bölüm numarası + bent ("1a-1", "5ç-2"). Eşik metinleri doğrudan bu kodlara
 * atıf yaptığı için gruplar da yönergenin ifadeleriyle adlandırıldı.
 *
 * OKUMA NOTU: PDF taranmış belge. TABLO A metni OCR ile çıkarıldı
 * (pdf-ocr/…mersinuniverstesi.txt); OCR çeyreklik işaretlerini bozduğu için
 * ("O," / "02" / "Oz" / "04") puanların azalan sırasıyla çapraz doğrulanarak
 * Q1/Q2/Q3/Q4 okundu. TABLO B ve C'de tesseract puan sütununu satırlarla
 * yanlış eşlediğinden OCR çıktısına güvenilmedi; puanlar sayfa
 * görüntülerinden birebir okundu.
 */

/** TABLO A — Akademik Etkinlikler ve Puanlar Listesi. */
$tabloA = [
    // ── 1. KİTAPLAR ve KİTAP BÖLÜMLERİ ──
    '1.a' => ['baslik' => 'BKCI yayınevince yayımlanmış kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 40],
    '1.b' => ['baslik' => 'BKCI yayınevince yayımlanmış kitapta editörlük/bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 20],
    '1.c' => ['baslik' => 'Tanınmış uluslararası/ulusal yayınevi kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 20],
    '1.ç' => ['baslik' => 'Tanınmış yayınevi kitapta editörlük/bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 8],
    '1.d' => ['baslik' => 'Bilimsel kitap çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 10],
    '1.e' => ['baslik' => 'Bilimsel kitap bölümü çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 3],
    '1.f' => ['baslik' => 'Tahkik/neşir/araştırma notu/kitap kritiği', 'kategori' => 'kitap', 'kaynaklar' => ['Tahkik (Tenkitli Metin)'], 'puan' => 3],

    // ── 2. MAKALE ──
    '2.a' => ['baslik' => 'WoS (SCI-E/SSCI) Q1 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'puan' => 50],
    '2.b' => ['baslik' => 'WoS (SCI-E/SSCI) Q2 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'puan' => 40],
    '2.c' => ['baslik' => 'WoS (SCI-E/SSCI) Q3 ve AHCI kapsamında makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)', 'AHCI'], 'puan' => 30],
    '2.ç' => ['baslik' => 'WoS (SCI-E/SSCI) Q4 dergide tam metinli araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'puan' => 20],
    '2.h' => ['baslik' => 'ESCI veya SCOPUS dergide tam metinli araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 15],
    '2.ı' => ['baslik' => 'TR Dizin kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 10],
    '2.i' => ['baslik' => 'Diğer uluslararası hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'], 'puan' => 5],

    // ── 5. BİLİMSEL ARAŞTIRMA PROJESİ GÖREVİ ── (puan fon kaynağı × role göre)
    '5.a' => ['baslik' => 'AB Çerçeve projesinde koordinatör/yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 50],
    '5.b' => ['baslik' => 'AB Çerçeve projesinde ortak/araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 30],
    '5.c' => ['baslik' => 'Uluslararası destekli projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 30],
    '5.ç' => ['baslik' => 'Uluslararası destekli projede araştırmacı/danışman/bursiyer', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],
    '5.d' => ['baslik' => 'Üniversite dışı kaynaklı (TÜBİTAK, Bakanlık vb.) projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 35],
    '5.e' => ['baslik' => 'Üniversite dışı kaynaklı projede araştırmacı/danışman/bursiyer', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],
    '5.f' => ['baslik' => 'Sanayi/kamu kuruluşu ile tamamlanmış projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 10],
    '5.g' => ['baslik' => 'BAP projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 10],
    '5.h' => ['baslik' => 'BAP projesinde araştırmacı/danışman/bursiyer', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 5],
];

/**
 * TABLO B — Güzel Sanatlar ile Mimarlık, Planlama ve Tasarım Alanlarında
 * Akademik Etkinlikler ve Puanlar Listesi.
 *
 * Madde kodları yönergenin bent harfleridir; alt kırılımlar kod-1, kod-2 diye
 * numaralanır ("c-1" = Proje Müellifi).
 *
 * HER MADDENİN AYRI `kaynaklar` ETİKETİ VAR — bilinçli. Etiketsiz bir madde
 * kategorideki TÜM faaliyetlere uyar ve `puan()` en yükseğini aldığı için her
 * sanatsal etkinlik en pahalı kalemden puanlanırdı.
 */
$tabloB = [
    // a-b) Eserin satın alınması / uygulanması / yayında yer alması
    'a' => ['baslik' => 'Özgün eserin yurt dışı kurumlarca satın alınması veya uygulanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Yayında Yer Alması / Satın Alınması'], 'puan' => 30],
    'b' => ['baslik' => 'Özgün eserin yurt içi kurumlarca satın alınması veya uygulanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Satın Alınması (Yurt İçi)'], 'puan' => 20],

    // c) Uygulama projesi (mimari, restorasyon, imar planı vb.)
    'c-1' => ['baslik' => 'Uygulama projesinde proje müellifi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif'], 'puan' => 20],
    'c-2' => ['baslik' => 'Uygulama projesinde proje ekibi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Ekip'], 'puan' => 16],
    'c-3' => ['baslik' => 'Uygulama projesinde proje ekibi yardımcısı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Ekip Yardımcısı'], 'puan' => 10],
    'c-4' => ['baslik' => 'Uygulama projesinde danışman', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Danışman'], 'puan' => 8],

    // ç) Kişisel etkinlik
    'ç-1' => ['baslik' => 'Yurt dışı kişisel sanat etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)'], 'puan' => 30],
    'ç-2' => ['baslik' => 'Yurt içi kişisel sanat etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)'], 'puan' => 20],

    // d) Jürili karma etkinlik. Yönerge yurtdışı(15)/uluslararası(10)/ulusal(7)
    // diye üçe ayırıyor; sözlükte yalnız uluslararası-ulusal ayrımı olduğu
    // için yurtdışı ile uluslararası tek etikette birleşti (düşük değer alındı).
    'd-2' => ['baslik' => 'Uluslararası jürili karma sanat/tasarım etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)'], 'puan' => 10],
    'd-3' => ['baslik' => 'Ulusal jürili karma sanat/tasarım etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)'], 'puan' => 7],

    // e) Ulusal karma etkinlik (jürisiz)
    'e' => ['baslik' => 'Ulusal karma sanat/tasarım etkinliğine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Jürisiz, Ulusal)'], 'puan' => 5],

    // f) Sempozyum, çalıştay, bienal, yaz okulu
    'f-1' => ['baslik' => 'Yurt dışı uygulamalı sanat sempozyumu/çalıştay/bienal', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 30],
    'f-2' => ['baslik' => 'Yurt içi uygulamalı sanat sempozyumu/çalıştay/bienal', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 20],

    // g-h) Ödüller — bunlar Odul kategorisinde kaydediliyor
    'g-1' => ['baslik' => 'Uluslararası jürili sanat/tasarım etkinliğinde birincilik', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü'], 'puan' => 20],
    'g-3' => ['baslik' => 'Jürili sanat/tasarım etkinliğinde derece veya mansiyon', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 10],
    'h-1' => ['baslik' => 'Ulusal jürili sanat/tasarım etkinliğinde birincilik', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 15],

    // ı-i) Jüri görevi
    'ı-1' => ['baslik' => 'Uluslararası sanat etkinliğinde jüri başkanlığı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)'], 'puan' => 10],
    'ı-2' => ['baslik' => 'Uluslararası sanat etkinliğinde jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Üyeliği (Uluslararası)'], 'puan' => 7],
    'i-1' => ['baslik' => 'Ulusal sanat etkinliğinde jüri başkanlığı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Ulusal)'], 'puan' => 5],
    'i-2' => ['baslik' => 'Ulusal sanat etkinliğinde jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Üyeliği (Ulusal)'], 'puan' => 3],

    // j) Jürili belgesel / kısa film / festival
    'j-1' => ['baslik' => 'Uluslararası jürili belgesel/kısa film/festival katılımı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Uluslararası)'], 'puan' => 10],
    'j-2' => ['baslik' => 'Ulusal jürili belgesel/kısa film/festival katılımı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Ulusal)'], 'puan' => 5],

    // k) Müzeye kabul
    'k-1' => ['baslik' => 'Özgün eserin yurt dışı müzeye kabulü', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)'], 'puan' => 15],
    'k-2' => ['baslik' => 'Özgün eserin yurt içi müzeye kabulü', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)'], 'puan' => 10],

    // l) Yayın mecrasında haber olarak yer alma
    'l-1' => ['baslik' => 'Özgün eserin uluslararası yayın mecrasında haber olması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Haber Olması (Uluslararası)'], 'puan' => 10],
    'l-2' => ['baslik' => 'Özgün eserin ulusal yayın mecrasında haber olması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Haber Olması (Ulusal)'], 'puan' => 5],

    // m-n) Elektronik sergi
    'm-1' => ['baslik' => 'Uluslararası elektronik kişisel sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Elektronik Kişisel Sergi (Uluslararası)'], 'puan' => 20],
    'm-2' => ['baslik' => 'Ulusal elektronik kişisel sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 10],
    'n-1' => ['baslik' => 'Uluslararası elektronik karma/grup sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Elektronik Karma Sergi (Uluslararası)'], 'puan' => 10],
    'n-2' => ['baslik' => 'Ulusal elektronik karma/grup sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Elektronik Karma Sergi (Ulusal)'], 'puan' => 5],
];

/**
 * TABLO C — Konservatuvar Alanında (Müzik-Sahne Sanatları, Müzikoloji)
 * Sanatsal Etkinlikler ve Puanlar Listesi.
 *
 * Yönergedeki altı bölüm: 1) Çalgı performansı 2) Kompozisyon 3) Orkestra
 * şefliği 4) Opera performansı 5) Bale ve modern dans 6) Müzikoloji.
 * Madde kodu bölüm numarası + bent harfi + uluslararası/ulusal ekidir.
 *
 * Puanlar yönergede "45 puan/konser", "40 puan/resital" gibi ETKİNLİK BAŞINA
 * verilmiştir; motor her faaliyet satırını bir etkinlik saydığı için bire bir
 * karşılık gelir.
 */
$tabloC = [
    '1a-1' => ['baslik' => 'Orkestra eşliğinde solistlik (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Solistlik (Uluslararası)'], 'puan' => 45],
    '1a-2' => ['baslik' => 'Orkestra eşliğinde solistlik (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Solistlik (Ulusal)'], 'puan' => 35],
    '1b-1' => ['baslik' => 'Resital (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Uluslararası)'], 'puan' => 40],
    '1b-2' => ['baslik' => 'Resital (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Ulusal)'], 'puan' => 30],
    '1c-1' => ['baslik' => 'Oda müziği konserinde grup üyeliği (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Uluslararası)'], 'puan' => 30],
    '1c-2' => ['baslik' => 'Oda müziği konserinde grup üyeliği (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Ulusal)'], 'puan' => 25],
    '1ç-1' => ['baslik' => 'Orkestra konserinde başkemancılık (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Başkemancılık (Uluslararası)'], 'puan' => 25],
    '1ç-2' => ['baslik' => 'Orkestra konserinde başkemancılık (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Başkemancılık (Ulusal)'], 'puan' => 20],
    '1d-1' => ['baslik' => 'Orkestra konserinde grup şefliği (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Grup Şefliği (Uluslararası)'], 'puan' => 20],
    '1d-2' => ['baslik' => 'Orkestra konserinde grup şefliği (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Grup Şefliği (Ulusal)'], 'puan' => 15],
    '1e' => ['baslik' => 'Bandrollü CD/DVD kaydında performans', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bandrollü Kayıt (CD/DVD)'], 'puan' => 45],
    '1f-1' => ['baslik' => 'Masterclass/seminer/konferans (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Masterclass (Uluslararası)'], 'puan' => 35],
    '1f-2' => ['baslik' => 'Masterclass/seminer/konferans (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Masterclass (Ulusal)'], 'puan' => 20],
    '1g' => ['baslik' => 'Eğitim amaçlı etkinlik düzenlemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eğitim Amaçlı Sanat Etkinliği'], 'puan' => 10],
    '2a' => ['baslik' => 'Opera veya bale kompozisyonu', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera/Bale Kompozisyonu'], 'puan' => 48],
    '2b' => ['baslik' => 'Orkestralı sahne eseri kompozisyonu', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestralı Sahne Eseri'], 'puan' => 40],
    '2c' => ['baslik' => 'Senfoni kompozisyonu', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Senfoni Kompozisyonu'], 'puan' => 40],
    '2ç' => ['baslik' => 'Konçerto, senfonik şiir veya orkestra süiti', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Konçerto/Senfonik Şiir'], 'puan' => 35],
    '2d' => ['baslik' => 'Küçük ölçekli orkestra eseri kompozisyonu', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Küçük Ölçekli Orkestra Eseri'], 'puan' => 30],
    '2e' => ['baslik' => 'En az 15 dk oda/koro müziği eseri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda/Koro Müziği Eseri (≥15 dk)'], 'puan' => 20],
    '2f' => ['baslik' => '15 dk altı oda/koro müziği eseri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda/Koro Müziği Eseri (<15 dk)'], 'puan' => 15],
    '2g' => ['baslik' => 'En az 15 dk elektronik/elektro-akustik müzik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Elektronik Müzik Eseri (≥15 dk)'], 'puan' => 18],
    '2h' => ['baslik' => '15 dk altı elektronik/elektro-akustik müzik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Elektronik Müzik Eseri (<15 dk)'], 'puan' => 12],
    '2ı' => ['baslik' => 'Tiyatro, televizyon, sinema, multimedya müziği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne/Ekran Müziği'], 'puan' => 15],
    '2i' => ['baslik' => 'Eğitim müziği albümü kompozisyonu', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eğitim Müziği Albümü'], 'puan' => 15],
    '2j' => ['baslik' => 'Orkestrasyon veya transkripsiyon', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestrasyon/Transkripsiyon'], 'puan' => 10],
    '2k' => ['baslik' => 'Eğitim müziği eserlerinde düzenleme', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eğitim Müziği Düzenlemesi'], 'puan' => 8],
    '3a-1' => ['baslik' => 'Opera repertuvarı şefliği (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera Şefliği (Uluslararası)'], 'puan' => 45],
    '3a-2' => ['baslik' => 'Opera repertuvarı şefliği (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera Şefliği (Ulusal)'], 'puan' => 35],
    '3b-1' => ['baslik' => 'Senfoni/oda orkestrası şefliği (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra Şefliği (Uluslararası)'], 'puan' => 40],
    '3b-2' => ['baslik' => 'Senfoni/oda orkestrası şefliği (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra Şefliği (Ulusal)'], 'puan' => 30],
    '3c-1' => ['baslik' => 'Bale temsilinde orkestra şefliği (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bale Orkestra Şefliği (Uluslararası)'], 'puan' => 45],
    '3c-2' => ['baslik' => 'Bale temsilinde orkestra şefliği (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bale Orkestra Şefliği (Ulusal)'], 'puan' => 35],
    '3ç-1' => ['baslik' => 'Koro konserinde şeflik (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koro Şefliği (Uluslararası)'], 'puan' => 20],
    '3ç-2' => ['baslik' => 'Koro konserinde şeflik (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koro Şefliği (Ulusal)'], 'puan' => 15],
    '4a-1' => ['baslik' => 'Opera/operet temsilinde birinci derece rol (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera Birinci Rol (Uluslararası)'], 'puan' => 45],
    '4a-2' => ['baslik' => 'Opera/operet temsilinde birinci derece rol (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera Birinci Rol (Ulusal)'], 'puan' => 35],
    '4b-1' => ['baslik' => 'Şan resitali (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Şan Resitali (Uluslararası)'], 'puan' => 40],
    '4b-2' => ['baslik' => 'Şan resitali (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Şan Resitali (Ulusal)'], 'puan' => 30],
    '4c-1' => ['baslik' => 'Opera temsilinde ikinci derece rol (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera İkinci Rol (Uluslararası)'], 'puan' => 30],
    '4c-2' => ['baslik' => 'Opera temsilinde ikinci derece rol (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera İkinci Rol (Ulusal)'], 'puan' => 25],
    '4ç-1' => ['baslik' => 'Oratoryo/kantat solistliği (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oratoryo/Kantat Solistliği (Uluslararası)'], 'puan' => 30],
    '4ç-2' => ['baslik' => 'Oratoryo/kantat solistliği (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oratoryo/Kantat Solistliği (Ulusal)'], 'puan' => 25],
    '4e-1' => ['baslik' => 'Profesyonel sanat kurumunda rejisörlük (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisörlük (Uluslararası)'], 'puan' => 40],
    '4e-2' => ['baslik' => 'Profesyonel sanat kurumunda rejisörlük (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisörlük (Ulusal)'], 'puan' => 30],
    '4f' => ['baslik' => 'Devlet konservatuvarında rejisörlük', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisörlük (Konservatuvar)'], 'puan' => 25],
    '4g-1' => ['baslik' => 'Rejisör yardımcılığı (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisör Yardımcılığı (Uluslararası)'], 'puan' => 25],
    '4g-2' => ['baslik' => 'Rejisör yardımcılığı (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisör Yardımcılığı (Ulusal)'], 'puan' => 20],
    '4h' => ['baslik' => 'Konservatuvarda rejisör yardımcılığı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisör Yardımcılığı (Konservatuvar)'], 'puan' => 15],
    '5a-1' => ['baslik' => 'Bale/modern dans temsilinde başrol (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bale Başrol (Uluslararası)'], 'puan' => 45],
    '5a-2' => ['baslik' => 'Bale/modern dans temsilinde başrol (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bale Başrol (Ulusal)'], 'puan' => 35],
    '5b-1' => ['baslik' => 'Bale/modern dans temsilinde solist rol (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bale Solist Rol (Uluslararası)'], 'puan' => 45],
    '5b-2' => ['baslik' => 'Bale/modern dans temsilinde solist rol (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bale Solist Rol (Ulusal)'], 'puan' => 35],
    '5c-1' => ['baslik' => 'Bale/modern dansta "corps de ballet" (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Corps de Ballet (Uluslararası)'], 'puan' => 35],
    '5c-2' => ['baslik' => 'Bale/modern dansta "corps de ballet" (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Corps de Ballet (Ulusal)'], 'puan' => 30],
    '5ç-1' => ['baslik' => 'Tüm perde koreograflığı (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Tüm Perde Koreograflığı (Uluslararası)'], 'puan' => 40],
    '5ç-2' => ['baslik' => 'Tüm perde koreograflığı (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Tüm Perde Koreograflığı (Ulusal)'], 'puan' => 30],
    '5d-1' => ['baslik' => 'Bölüm koreograflığı (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bölüm Koreograflığı (Uluslararası)'], 'puan' => 35],
    '5d-2' => ['baslik' => 'Bölüm koreograflığı (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bölüm Koreograflığı (Ulusal)'], 'puan' => 25],
    '5e-1' => ['baslik' => 'Bale/dans koreograflığı — tiyatro/konservatuvar (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bale/Dans Koreograflığı (Uluslararası)'], 'puan' => 30],
    '5e-2' => ['baslik' => 'Bale/dans koreograflığı — tiyatro/konservatuvar (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bale/Dans Koreograflığı (Ulusal)'], 'puan' => 20],
    '5f-1' => ['baslik' => 'Tüm perde eser sahneleme veya repetitörlük (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahneleme/Repetitörlük — Tüm Perde (Uluslararası)'], 'puan' => 30],
    '5f-2' => ['baslik' => 'Tüm perde eser sahneleme veya repetitörlük (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahneleme/Repetitörlük — Tüm Perde (Ulusal)'], 'puan' => 20],
    '5g-1' => ['baslik' => 'Bölüm sahneleme veya repetitörlük (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahneleme/Repetitörlük — Bölüm (Uluslararası)'], 'puan' => 30],
    '5g-2' => ['baslik' => 'Bölüm sahneleme veya repetitörlük (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahneleme/Repetitörlük — Bölüm (Ulusal)'], 'puan' => 20],
    '6a' => ['baslik' => 'Müzikoloji alanında atölye çalışması yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Müzikoloji Atölyesi'], 'puan' => 35],
    '6b-1' => ['baslik' => 'Eğitici konser programı etkinliği (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eğitici Konser Programı (Uluslararası)'], 'puan' => 35],
    '6b-2' => ['baslik' => 'Eğitici konser programı etkinliği (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eğitici Konser Programı (Ulusal)'], 'puan' => 25],
];

return [
    'maddeler' => $tabloA + $tabloB + $tabloC,

    'gruplar' => [
        // ── Puan barajının hangi listeden okunacağı ──
        // Eşikler bunları `Kalip::toplam()`'a verir; hangi alanın hangi listeye
        // tabi olduğu yönergede yazılıdır (md. 2.1.1 c-6/c-7, 2.2 e-6/e-7).
        'A' => array_keys($tabloA),
        'B' => array_keys($tabloB),
        'C' => array_keys($tabloC),

        // ── TABLO A içi kırılımlar ──
        // Eşik metninin birebir kullandığı ifadeler — koşullar bu adlarla yazıldı.
        '2.a-ç/h,ı' => ['2.a', '2.b', '2.c', '2.ç', '2.h', '2.ı'],
        '2.a-ç/h' => ['2.a', '2.b', '2.c', '2.ç', '2.h'],
        '2.a-ç' => ['2.a', '2.b', '2.c', '2.ç'],
        // Doçent koşulları "2.a, b, c" ile "2.a, b, c, ç"yi ayrı ayrı anıyor.
        '2.a-c' => ['2.a', '2.b', '2.c'],
        '1.a/c' => ['1.a', '1.c'],
        '1.b/ç' => ['1.b', '1.ç'],
        // "5.a,b,c,ç,d,e,f,g bentlerinde belirtilen projelerden birinde ... görev almak"
        '5.a-g' => ['5.a', '5.b', '5.c', '5.ç', '5.d', '5.e', '5.f', '5.g', '5.h'],
        // Profesörlük yalnızca "koordinatör/yürütücü" görevini sayıyor.
        '5.a-g-yurutucu' => ['5.a', '5.c', '5.d', '5.f', '5.g'],
        // Nokta'lı önek TABLO A'ya özgü: TABLO C'nin '2a' / '1a-1' kodlarını yakalamaz.
        'MAKALE' => ['2.*'],
        'KITAP' => ['1.*'],
    ],

    'grup_tavanlari' => [
        // TABLO C'nin "bu kapsamda en çok 18/12 puan alınır" dipnotları.
        '2g' => 18,
        '2h' => 12,
    ],
];
