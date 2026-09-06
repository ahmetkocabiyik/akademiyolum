<?php

use App\Enums\Kategori;

/**
 * KÜTAHYA DUMLUPINAR ÜNİVERSİTESİ — EK-1 Faaliyetler ve Puanlama Sistemi
 * Kaynak: pdf/17537002702.kutahyadumlupinaruniverstesi.pdf (28 sayfa;
 * Senato 17.11.2023-33, YÖK G.K. 29.02.2024)
 *
 * ── DÖRT SÜTUN, DÖRT CETVEL ──
 * EK-1 tablosunun puan sütunu dört temel alan grubuna ayrılıyor:
 *   `dpu-2024`          Eğitim Bilimleri, Filoloji, Sosyal-Beşeri-İdari,
 *                       Spor Bilimleri
 *   `dpu-2024-ilahiyat` İlahiyat (ulusal makale ve kitap puanları yüksek)
 *   `dpu-2024-muh`      Mimarlık-Planlama-Tasarım, Mühendislik, Fen
 *                       Bilimleri ve Matematik
 *   `dpu-2024-gsf`      Güzel Sanatlar (J bölümü yalnız burada)
 * Sütunlar arasındaki fark yalnızca yedi satırda: A114 (10/10/10/8),
 * A211 (8/8/10/8), A212 (4/4/5/4), B11 (20/20/25/20), B21 (15/15/25/15),
 * B22 (8/8/10/8) ve yalnız mühendislik sütununda bulunan G126 (15).
 *
 * ── J BÖLÜMÜ YALNIZ GÜZEL SANATLAR CETVELİNDE ──
 * EK-1'in J başlığı "UYGULAMALI FAALİYETLER (Güzel Sanatlar Temel
 * Alanı)" diyor; sanat satırları bu yüzden yalnız `dpu-2024-gsf`
 * cetvelinde. Diğer alanlarda sanatsal etkinlik kaydınız 0 puandır.
 *
 * ── GÜZEL SANATLAR SÜTUNUNUN K-P BÖLÜMÜ PDF'TEN GÜVENİLİR OKUNMUYOR ──
 * K (projeler), L (küratörlük), M (organizasyon), N, O ve P
 * bölümlerinde Güzel Sanatlar sütunu hücrelerin bir kısmında boş, bir
 * kısmında kayık düşüyor (aynı sayı hem `pdftotext -layout` hem
 * `-layout`'suz çıktıda farklı satıra oturuyor). Bu bölümlerde diğer üç
 * sütunun ORTAK değerleri kullanıldı — Güzel Sanatlar adayının proje ve
 * organizasyon puanı gerçekte farklı olabilir.
 *
 * ── ETKİ FAKTÖRÜ AYRIMI YAPILAMIYOR ──
 * A111 (etki faktörü ≥3) 25, A112 (etki faktörü <3) 20 puan. Kayıt
 * derginin etki faktörünü taşımadığı için §0 uyarınca hepsi A112'den
 * (20) sayılıyor; yüksek etkili dergide makaleniz varsa puanınız
 * OLDUĞUNDAN DÜŞÜK.
 *
 * ── AYNI ETİKETE DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   C bölümünde uluslararası özet (3) ile poster (2) → 2; davetli
 *       konuşmacı C114 (3), M113 (10) ve M213 (5) → 2.
 *   Hakemlikler (uluslararası kitap 10, SCI dergi 3, TR Dizin 1, diğer
 *       0,5) tek 'Hakemlik' etiketine düşüyor → 1.
 *   Jüri üyelikleri (uluslararası ödül 5, ulusal sanat 0,5) → 1.
 *   Ödüllerde uluslararası bilim insanı ödülü (20/10) → 10, ulusal
 *       (15/8) → 8, derece ve mansiyonlar (15/10/8/6/3/2) → 2.
 *   Yabancı dilde hazırlanmış lisansüstü tez danışmanlığı (5/4/3) ile
 *       Türkçe tez danışmanlığı (4/2) ayrılamıyor → 4 ve 2.
 *   Faydalı model/obje/tasarım tescili uluslararası (10) ile ulusal (5)
 *       → 5.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   R bölümü (Spor Bilimleri uygulamalı faaliyetleri: milli takım
 *       antrenörlüğü, madalya, federasyon kurul üyeliği) — sözlükte
 *       karşılık yok, en çok 20 puan kaybı.
 *   S satırı ("doçentlik belgesini sözlü sınavına girerek alan aday",
 *       25 puan) — faaliyet değil, unvanın alınış biçimi.
 *   L bölümü (sergi küratörlüğü 20/10) — sözlükte karşılık yok.
 *   G112, G114, G122, G124 (patent BAŞVURULARI) — kayıt tescilli
 *       patentten ayıramıyor.
 *   A115 (kitap kritiği yapılmış makale), B24-B25 (ders notu,
 *       laboratuvar kılavuzu), H1 (100/2000 burslu öğrenci
 *       danışmanlığı), F1131/F1231 aylık burslar, H314/H323 aylık
 *       misafir araştırmacılık, I19/I210 bildiri hakemliği (0,5 ve 0,25
 *       puan; tam sayıya yuvarlanınca kayboluyor).
 *   Rektör ve rektör yardımcılığı: P bölümü bu görevleri saymıyor.
 *
 * ── MOTORUN KARŞILAYAMADIĞI SINIRLAR ──
 * "Aynı kitapta en fazla 2 bölüm", "aynı ansiklopedide en fazla 4
 * madde", "en çok 3 adet jüri üyeliği", "her ay için en fazla 4/6 ay",
 * "aynı dergide hem editörlük hem hakemlik varsa biri sayılır",
 * "aynı kitapta editörlük veya bölüm yazarlığından sadece biri".
 *
 * Yönerge: yonerge/dpu.php
 */
$SCI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];
$MAKALE = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];

$sanatUlusKisisel = ['Kişisel Etkinlik (Uluslararası)', 'Elektronik Kişisel Sergi (Uluslararası)',
    'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Solistlik (Uluslararası)',
    'Resital (Uluslararası)', 'Şan Resitali (Uluslararası)', 'Opera Birinci Rol (Uluslararası)',
    'Orkestra Şefliği (Uluslararası)', 'Koro Şefliği (Uluslararası)'];
$sanatUlusalKisisel = ['Kişisel Etkinlik (Ulusal)', 'Elektronik Kişisel Sergi (Ulusal)',
    'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)',
    'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Solistlik (Ulusal)', 'Resital (Ulusal)',
    'Şan Resitali (Ulusal)', 'Opera Birinci Rol (Ulusal)', 'Orkestra Şefliği (Ulusal)',
    'Koro Şefliği (Ulusal)'];
$sanatUlusKarma = ['Karma/Jürili Etkinlik (Uluslararası)', 'Elektronik Karma Sergi (Uluslararası)',
    'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)',
    'Oda Müziği Grup Üyeliği (Uluslararası)', 'Masterclass (Uluslararası)'];
$sanatUlusalKarma = ['Karma/Jürili Etkinlik (Ulusal)', 'Elektronik Karma Sergi (Ulusal)',
    'Karma Etkinlik (Jürisiz, Ulusal)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)',
    'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)',
    'Oda Müziği Grup Üyeliği (Ulusal)', 'Masterclass (Ulusal)', 'Orkestra / Koro Üyeliği'];
$sanatUlusSatin = ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Müzeye Kabulü (Yurt Dışı)',
    'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Eserin Haber Olması (Uluslararası)'];
$sanatUlusalSatin = ['Eserin Satın Alınması (Yurt İçi)', 'Eserin Müzeye Kabulü (Yurt İçi)',
    'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Eserin Haber Olması (Ulusal)'];
$sanatFilmU = ['Belgesel/Kısa Film (Uluslararası)', 'Albüm / Konser Kaydı',
    'Bandrollü Kayıt (CD/DVD)'];
$sanatFilmN = ['Belgesel/Kısa Film (Ulusal)', 'Karma Albüm / CD-DVD Katkısı'];
$sanatKoruma = ['Koruma-Onarım Uygulaması (Uluslararası)'];
$sanatKorumaN = ['Koruma-Onarım Uygulaması (Ulusal)'];
$sanatTasarim = ['Özgün Eser / Beste / Tasarım', 'Uygulama Projesi — Müellif',
    'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı',
    'Uygulama Projesi — Danışman', 'Sahne Tasarımı (Dekor, Kostüm, Işık)'];
$sanatSahne = ['Yönetmenlik (Sahne/Ekran)', 'Koreografi', 'Rejisörlük (Uluslararası)',
    'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Dansçı / Performans İcracısı (Uluslararası)',
    'Dansçı / Performans İcracısı (Ulusal)'];
$sanatJuri = ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)',
    'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'];

$sanatKullanilan = array_merge($sanatUlusKisisel, $sanatUlusalKisisel, $sanatUlusKarma,
    $sanatUlusalKarma, $sanatUlusSatin, $sanatUlusalSatin, $sanatFilmU, $sanatFilmN,
    $sanatKoruma, $sanatKorumaN, $sanatTasarim, $sanatSahne, $sanatJuri);
$sanatKalan = array_values(array_diff(Kategori::SanatselEtkinlik->kaynaklar(), $sanatKullanilan));

/** K, M, N, O ve P bölümleri dört sütunda da aynı. */
$ortak = [
    // ══ K. ARAŞTIRMA PROJELERİ ══
    'K1111' => ['baslik' => 'NATO-SFS, Avrupa Birliği, UN, NSF, UNESCO, Dünya Bankası gibi küresel kuruluşlarca desteklenen projede yürütücülük ya da başkanlık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 30],
    'K1112' => ['baslik' => 'Küresel uluslararası kuruluşlarca desteklenen projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 15],
    'K1113' => ['baslik' => 'Küresel uluslararası kuruluşlarca desteklenen projede danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['danisman'], 'puan' => 10],
    'K1121' => ['baslik' => 'Diğer uluslararası kurum ve kuruluşlarca desteklenen projede yürütücülük ya da başkanlık', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 10],
    'K1122' => ['baslik' => 'Diğer uluslararası kurum ve kuruluşlarca desteklenen projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 6],
    'K1123' => ['baslik' => 'Diğer uluslararası kurum ve kuruluşlarca desteklenen projede danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['danisman'], 'puan' => 3],
    'K1211' => ['baslik' => 'TÜBİTAK, TTGV, kalkınma ajansları, KOSGEB ve bakanlıklarca desteklenen projede yürütücülük ya da başkanlık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 20],
    'K1212' => ['baslik' => 'Ulusal kurum ve kuruluşlarca desteklenen projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 10],
    'K1213' => ['baslik' => 'Ulusal kurum ve kuruluşlarca desteklenen projede danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['danisman'], 'puan' => 5],
    'K1221' => ['baslik' => 'Üniversite bilimsel araştırma projelerinde (BAP) yürütücülük ya da yöneticilik', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 6],
    'K1222' => ['baslik' => 'Üniversite bilimsel araştırma projelerinde (BAP) araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 3],
    'K1231' => ['baslik' => 'Ticaret ve sanayi odaları, kalkınma ajansları gibi kurumlarca desteklenen tematik ya da güdümlü projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 6],
    'K1232' => ['baslik' => 'Tematik ya da güdümlü projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 3],
    'K1233' => ['baslik' => 'Tematik ya da güdümlü projede akademik danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['danisman'], 'puan' => 2],

    // ══ M. ALANINDA AKADEMİK ORGANİZASYON ══
    'M212' => ['baslik' => 'Bilimsel toplantı ve etkinliklerde düzenleyicilik, yöneticilik, jüri, hakem, mentör ya da panelistlik', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 1],

    // ══ N. EĞİTİM SEMİNERLERİ ══
    'N1' => ['baslik' => 'Ulusal ya da yerel kurum ve kuruluşlar adına alanınızda eğitim semineri ya da sertifika programı vermek', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Bilim İletişimi / Popüler Yayın', 'Topluma Hizmet Projesi'], 'puan' => 5],

    // ══ O. DANIŞMANLIK ══
    'O1' => ['baslik' => 'Ulusal kurum ve kuruluşlarda en az kesintisiz altı ay süreli danışmanlık hizmeti', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı'], 'puan' => 10],

    // ══ P. ÜNİVERSİTE YÖNETİMİNE DOĞRUDAN KATKI ══
    'P1' => ['baslik' => 'Enstitü, yüksekokul ya da meslek yüksekokulu müdürlüğü veya dekan yardımcılığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü', 'Dekan Yrd. / Müdür Yrd.'], 'puan' => 10],
    'P3' => ['baslik' => 'Rektörlüğe bağlı merkezlerde müdürlük (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 6],
    'P5' => ['baslik' => 'Bölüm başkanlığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 4],
    'P6' => ['baslik' => 'Bölüm başkan yardımcılığı ya da anabilim dalı başkanlığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 3],
    'P9' => ['baslik' => 'Komisyonlarda üyelik ya da koordinatörlük (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 4],
    'P13' => ['baslik' => 'Üniversite yönetim kurulu ya da senato üyeliği (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Senato / Üniversite Yönetim Kurulu Üyesi', 'Rektör', 'Rektör Yardımcısı'], 'puan' => 6],
];

/** Bir puan sütununun madde listesi; `$s` sütunun farklı olan satırlarını taşır. */
$govde = function (array $s) use ($SCI, $MAKALE, $KISA, $sanatJuri): array {
    return [
        // ══ A. MAKALE ══
        'A112' => ['baslik' => 'SCI, SCI-EXP, SSCI ve AHCI indekslerince taranan dergide yayımlanmış özgün ya da derleme makale', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => $MAKALE, 'puan' => 20],
        'A113' => ['baslik' => 'Alan indeksleri dışında kalan diğer uluslararası indekslerde taranan hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $MAKALE, 'puan' => 5],
        'A114' => ['baslik' => 'Uluslararası alan indekslerinde (ISI veya Scopus) taranan dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $MAKALE, 'puan' => $s['a114']],
        'A121' => ['baslik' => 'SCI, SCI-EXP, SSCI ve AHCI indekslerince taranan dergide teknik not, kısa makale, yorum, vaka incelemesi ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => $KISA, 'puan' => 2],
        'A122' => ['baslik' => 'Diğer uluslararası hakemli dergide teknik not, kısa makale, yorum, vaka incelemesi ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 2],
        'A211' => ['baslik' => 'ULAKBİM TR Dizin kapsamındaki ulusal hakemli dergide yayımlanan tam makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $MAKALE, 'puan' => $s['a211']],
        'A212' => ['baslik' => 'TR Dizin dışında kalan diğer ulusal hakemli dergide yayımlanan tam makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $MAKALE, 'puan' => $s['a212']],

        // ══ B. KİTAP ══
        'B11' => ['baslik' => 'Uluslararası yayınevi tarafından basılan bilimsel, mesleki ya da ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => $s['b11']],
        'B12' => ['baslik' => 'Uluslararası kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 10],
        'B13' => ['baslik' => 'Uluslararası kitabın Türkçeye tam çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 10],
        'B14' => ['baslik' => 'Uluslararası kitapta bir bölümün Türkçeye tam çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 5],
        'B21' => ['baslik' => 'Ulusal yayınevi tarafından basılmış bilimsel, mesleki ya da ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı'], 'puan' => $s['b21']],
        'B22' => ['baslik' => 'Ulusal kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => $s['b22']],
        'B23' => ['baslik' => 'Ulusal yayınevi tarafından basılmış ansiklopedide konu ya da madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 2],

        // ══ C. KONFERANS ══
        'C111' => ['baslik' => 'Uluslararası bilimsel toplantıda sözlü sunulan ve organizasyon kitabında yayımlanan tam metin', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 3],
        'C121' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan özet ya da poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster', 'Davetli Konuşmacı'], 'puan' => 2],
        'C211' => ['baslik' => 'Ulusal bilimsel toplantıda sözlü sunulan ve organizasyon kitabında yayımlanan tam metin', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 2],
        'C221' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan özet ya da poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 1],

        // ══ D. ATIFLAR ══
        'D11' => ['baslik' => 'SCI, SCI-EXP, SSCI ve AHCI indekslerince taranan dergilerde ya da uluslararası kitaplarda eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 3],
        'D21' => ['baslik' => 'Ulusal dergi, kitap ve lisansüstü tezlerde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 1],

        // ══ E. YAYIN EDİTÖRLÜĞÜ ══
        'E11' => ['baslik' => 'Uluslararası yayınevince basılan kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 10],
        'E14' => ['baslik' => 'SCI, SCI-EXP, SSCI ve AHCI indeksli dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 4],
        'E15' => ['baslik' => 'Diğer uluslararası hakemli dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 3],
        'E21' => ['baslik' => 'Ulusal yayınevince basılan kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 8],
        'E24' => ['baslik' => 'ULAKBİM TR Dizin ulusal dergilerinde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 2],
        'E25' => ['baslik' => 'TR Dizin dışındaki dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 1],

        // ══ F. ÖDÜLLER VE TANINMIŞ ÇALIŞMALAR ══
        'F112' => ['baslik' => 'Uluslararası kurum ve kuruluşlarca verilen bilim insanı ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 10],
        'F122' => ['baslik' => 'Ulusal kurum ve kuruluşlarca verilen bilim insanı ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 8],
        'F1224' => ['baslik' => 'Yarışmalarda derece, mansiyon ya da özel ödül almak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 2],
        'F1231' => ['baslik' => 'Alanınızda araştırma bursu almak', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 1],

        // ══ G. PATENT ══
        'G111' => ['baslik' => 'Alınmış, tescillenmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 25],
        'G121' => ['baslik' => 'Alınmış, tescillenmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 10],
        'G123' => ['baslik' => 'Tescillenmiş faydalı model, obje ya da tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım'], 'puan' => 5],

        // ══ H. EĞİTİM ETKİNLİKLERİ ══
        'H111' => ['baslik' => 'Tamamlanmış doktora ya da sanatta yeterlik tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 4],
        'H113' => ['baslik' => 'Tamamlanmış doktora ya da sanatta yeterlik tezinde eş danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 2],
        'H121' => ['baslik' => 'Tamamlanmış yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 2],
        'H123' => ['baslik' => 'Tamamlanmış yüksek lisans tezinde eş danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'roller' => ['es_danisman'], 'puan' => 1],
        'H211' => ['baslik' => 'Bir dönem yüksek lisans ya da doktora dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
        'H212' => ['baslik' => 'Bir dönem ön lisans ya da lisans dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders'], 'puan' => 2],
        'H311' => ['baslik' => 'Erasmus, Mevlana gibi uluslararası değişim programlarından yararlanmak ya da misafir öğretim üyeliği', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Değişim Programı Dersi', 'Yabancı Dilde Ders'], 'puan' => 5],

        // ══ I. ÜYELİK VE HAKEMLİKLER ══
        'I208' => ['baslik' => 'Bilimsel dergilerde yayın hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik', 'Yayın Kurulu Üyeliği'], 'puan' => 1],
        'I202' => ['baslik' => 'Sanat ya da tasarım etkinliklerinde jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatJuri, 'puan' => 1],
    ];
};

/** Yalnız mühendislik sütununda bulunan satır. */
$g126 = [
    'G126' => ['baslik' => 'Proje ve yapım yönetimi, tasarımı ya da planlama alanlarında yazılım üreticisi veya patent sahibi olmak', 'kategori' => 'patent', 'kaynaklar' => ['Yazılım', 'Islahçı Hakkı / Çeşit Tescili', 'Ticarileştirme'], 'puan' => 15],
];

/** J bölümü: yalnız Güzel Sanatlar sütununda. */
$jSatirlari = [
    // ══ J. UYGULAMALI FAALİYETLER (Güzel Sanatlar Temel Alanı) ══
    'J111' => ['baslik' => 'Özgün sanat eserinizin, bestenizin ya da tasarımınızın yurt dışında satın alınması, yayın organlarında yer alması ya da uygulanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatUlusSatin, 'puan' => 20],
    'J115' => ['baslik' => 'Özgün sanat eserinizin, bestenizin ya da tasarımınızın yurt içinde satın alınması, yayın organlarında yer alması ya da uygulanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatUlusalSatin, 'puan' => 12],
    'J1121' => ['baslik' => 'Jürili, küratörlü ya da seçici kurullu uluslararası sanat etkinliğine kişisel olarak kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatUlusKisisel, 'puan' => 20],
    'J1122' => ['baslik' => 'Jürili, küratörlü ya da seçici kurullu uluslararası ortak veya karma sanat etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatUlusKarma, 'puan' => 7],
    'J1161' => ['baslik' => 'Jürili, küratörlü ya da seçici kurullu ulusal sanat etkinliğine kişisel olarak kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatUlusalKisisel, 'puan' => 12],
    'J1162' => ['baslik' => 'Jürili, küratörlü ya da seçici kurullu ulusal ortak veya karma sanat etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => [...$sanatUlusalKarma, ...$sanatKalan], 'puan' => 5],
    'J1128' => ['baslik' => 'Kişisel yayımlanmış görsel-işitsel program, belgesel ya da film yapmak (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatFilmU, 'puan' => 20],
    'J1168' => ['baslik' => 'Kişisel yayımlanmış görsel-işitsel program, belgesel ya da film yapmak (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatFilmN, 'puan' => 12],
    'J1131' => ['baslik' => 'Uluslararası müze, kazı buluntusu, koleksiyon ve film arşivi restorasyon-konservasyonunda yürütücülük ya da başkanlık', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKoruma, 'puan' => 20],
    'J1171' => ['baslik' => 'Müze, kazı buluntusu, koleksiyon ve film arşivi restorasyon-konservasyonunda yürütücülük ya da başkanlık', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKorumaN, 'puan' => 12],
    'J1181' => ['baslik' => 'Sahne sanatlarında (dans, bale, tiyatro, halk oyunları) grup oluşturmak ve gösterilerinin sunumunu sağlamak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatSahne, 'puan' => 12],
    'J11613' => ['baslik' => 'Basılı dergi ya da kitap kapağı, sayfa, afiş, poster, broşür ve katalog tasarımı yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatTasarim, 'puan' => 3],
    'R7' => ['baslik' => 'Uluslararası spor federasyonunun yönetim, teknik, eğitim ya da hakem kurulunda görev', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Spor Federasyonu Kurul Üyeliği (Uluslararası)'], 'puan' => 4],
    'R9' => ['baslik' => 'Ulusal spor federasyonunun yönetim, teknik, eğitim ya da hakem kurulunda görev', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Spor Federasyonu Kurul Üyeliği (Ulusal)'], 'puan' => 3],
];

/**
 * @param  array<string, array<string, mixed>>  $maddeler
 * @return list<string>
 */
$onek = fn (array $maddeler, string ...$onekler): array => array_values(array_filter(
    array_keys($maddeler),
    function (string $kod) use ($onekler) {
        foreach ($onekler as $o) {
            if (str_starts_with($kod, $o)) {
                return true;
            }
        }

        return false;
    },
));

/**
 * @param  array<string, array<string, mixed>>  $maddeler
 * @return array<string, list<string>>
 */
$gruplariKur = function (array $maddeler) use ($onek): array {
    $a = $onek($maddeler, 'A');
    $b = $onek($maddeler, 'B');
    $c = $onek($maddeler, 'C');
    $j = $onek($maddeler, 'J');
    $k = $onek($maddeler, 'K');
    $m = $onek($maddeler, 'M');

    $gruplar = [
        'A' => $a,
        'A11' => $onek($maddeler, 'A11'),
        'A21' => $onek($maddeler, 'A21'),
        'A11-A21' => array_merge($onek($maddeler, 'A11'), $onek($maddeler, 'A21')),
        'A-B' => array_merge($a, $b),
        'A-C' => array_merge($a, $b, $c),
        'J-M' => array_merge($j, $k, $m),
        // 5.1.1: "24 puanı J 111, 1121, 1161, 1171 maddelerinden".
        'J-BLOK' => array_values(array_intersect(
            ['J111', 'J1121', 'J1161', 'J1171'], array_keys($maddeler),
        )),
        'D' => $onek($maddeler, 'D'),
        'E' => $onek($maddeler, 'E'),
        'F' => $onek($maddeler, 'F'),
        'H1' => $onek($maddeler, 'H1'),
        'H2' => $onek($maddeler, 'H2'),
        'H3' => $onek($maddeler, 'H3'),
        'I' => $onek($maddeler, 'I'),
        'M' => $m,
        'N' => $onek($maddeler, 'N'),
        'O' => $onek($maddeler, 'O'),
        'P' => $onek($maddeler, 'P'),
    ];

    // J bölümü yalnız Güzel Sanatlar sütununda; diğerlerinde boş grup bırakma.
    return array_filter($gruplar);
};

// Tablo dipnotlarındaki tavanlar.
$TAVANLAR = ['D' => 20, 'E' => 20, 'F' => 30, 'H1' => 10, 'H2' => 10, 'H3' => 10,
    'I' => 10, 'M' => 20, 'N' => 10, 'O' => 10, 'P' => 20];

$KAPSAM = 'Puanlar Kütahya Dumlupınar Üniversitesi Öğretim Üyeliğine Yükseltilme ve Atanma '
    .'Yönergesinin EK-1 puanlama tablosundan. Yazar çarpanı A, B, C ve E maddelerine '
    .'uygulanıyor: tek yazarlıda tam puan, iki yazarlıda 0,8; üç yazarlıda 0,6; dört yazarlıda '
    .'0,45; beş ve daha fazlasında 1/kişi sayısı. Yazar listesini boş bırakırsanız çarpan hiç '
    .'uygulanmaz ve puanınız olduğundan YÜKSEK görünür. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: A111 satırı etki faktörü 3 ve üzeri '
    .'dergilere 25 puan veriyor, kayıt etki faktörünü taşımadığı için bütün SCI, SCI-EXP, SSCI '
    .'ve AHCI makaleleri A112\'den (20) sayılıyor. Uluslararası ve ulusal özet, poster ve '
    .'davetli konuşmacı bildirileri tek satıra düştüğü için 2 puandan; bütün hakemlikler '
    .'(uluslararası kitap hakemliği 10 puan dahil) 1 puandan; bütün jüri üyelikleri 1 puandan '
    .'sayılıyor. Ödüllerde uluslararası bilim insanı ödülü 10, ulusal 8, derece ve mansiyonlar '
    .'2 puandan. Spor Bilimleri temel alanının R bölümü (milli takım antrenörlüğü, madalya, '
    .'federasyon kurul üyeliği; en çok 20 puan), sergi küratörlüğü (L bölümü, 20/10 puan) ve '
    .'"doçentlik belgesini sözlü sınavına girerek almak" satırı (25 puan) faaliyet kaydına '
    .'çevrilemediği için girilmedi. Patent BAŞVURUNUZU kaydetmeyin: yönerge ona ayrı ve düşük '
    .'puan veriyor ama kayıt türü tescilliden ayrılamadığı için o satır girilmedi. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünebilir: "aynı kitapta en fazla iki bölüm", '
    .'"aynı ansiklopedide en fazla dört madde", "en çok üç adet jüri üyeliği", "aynı dergide hem '
    .'editörlük hem hakemlik varsa biri sayılır" gibi eser bazlı sınırlar uygulanmıyor.';

// EK-1 Genel İlke: "A, B, C, E maddeleri arasındaki çok yazarlı
// yayınlarda/kitap editörlüklerinde tek yazarlıda tam puan, 2 yazarlıda
// 0.8, 3 yazarlıda 0.6, 4 yazarlıda 0.45, 5 ve daha çoğunda 1/kişi
// sayısı." Yönerge yazar sırasına göre ayrım yapmıyor.
$YAZAR = [
    'haric' => ['atif', 'proje', 'patent', 'tez_danismanligi', 'egitim_ogretim',
        'sanatsal_etkinlik', 'odul', 'idari_gorev', 'toplumsal_katki', 'diger'],
    'kademeler' => [1 => 1.00, 2 => 0.80, 3 => 0.60, 4 => 0.45],
    'bol' => ['pay' => 1.0],
];

$sutunlar = [
    'dpu-2024' => ['a114' => 10, 'a211' => 8, 'a212' => 4, 'b11' => 20, 'b21' => 15, 'b22' => 8, 'g126' => false, 'j' => false],
    'dpu-2024-ilahiyat' => ['a114' => 10, 'a211' => 10, 'a212' => 5, 'b11' => 25, 'b21' => 25, 'b22' => 10, 'g126' => false, 'j' => false],
    'dpu-2024-muh' => ['a114' => 8, 'a211' => 8, 'a212' => 4, 'b11' => 20, 'b21' => 15, 'b22' => 8, 'g126' => true, 'j' => false],
    'dpu-2024-gsf' => ['a114' => 10, 'a211' => 8, 'a212' => 4, 'b11' => 20, 'b21' => 15, 'b22' => 8, 'g126' => false, 'j' => true],
];

$cetveller = [];

foreach ($sutunlar as $anahtar => $sutun) {
    $maddeler = array_merge(
        $govde($sutun),
        $sutun['g126'] ? $g126 : [],
        $sutun['j'] ? $jSatirlari : [],
        $ortak,
    );
    $cetveller[$anahtar] = [
        'kapsam_notu' => $KAPSAM.($sutun['j']
            ? ' Güzel Sanatlar sütununun K (projeler), L, M, N, O ve P bölümleri PDF\'te kayık '
                .'ya da boş düştüğü için bu bölümlerde diğer üç sütunun ortak değerleri '
                .'kullanıldı; proje ve organizasyon puanınız gerçekte farklı olabilir.'
            : ' EK-1\'in J bölümü (uygulamalı sanat faaliyetleri) yönergede yalnız Güzel '
                .'Sanatlar temel alanına verildiği için bu cetvelde yok; sanatsal etkinlik '
                .'kaydınız 0 puandır.'),
        'yazar_katsayisi' => $YAZAR,
        'maddeler' => $maddeler,
        'gruplar' => $gruplariKur($maddeler),
        'grup_tavanlari' => $TAVANLAR,
    ];
}

return ['cetveller' => $cetveller];
