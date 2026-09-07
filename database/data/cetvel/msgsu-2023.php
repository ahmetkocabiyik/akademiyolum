<?php

use App\Enums\Kategori;

/**
 * MİMAR SİNAN GÜZEL SANATLAR ÜNİVERSİTESİ — EK 1 Akademik Yükseltilme,
 * İlk Atanma ve Yeniden Atanma Ölçütleri Tablosu
 * Kaynak: pdf/17537004062.mimarsinanguzelsanatlaruniverstesi.pdf
 * (59 sayfa)
 *
 * Madde kodları tablonun kendi numaralandırması (1.2.1, 2.8.4, 6.1.3 …).
 * EK 3'ün koşulları "1.2.1 kısımdan en az 30 puan", "1. veya 6.1
 * kısmından en az 20 puan" gibi BÖLÜM atıfları yaptığı için bölüm
 * grupları (`1`, `1.1`, `1.2`, `1.2.1`, `2`, `5`, `6.1`) tanımlandı.
 *
 * ── ESCI 1.2.2'DEN SAYILIYOR ──
 * 1.2.1 satırı "SCI, SCI-Expanded, SSCI, AHCI ve ESCI kapsamındaki
 * dergiler" diyerek ESCI'ye 35 puan veriyor; 1.2.2 ise alan indekslerine
 * (Scopus dâhil) 25. Sözlükte ESCI ile Scopus tek etiket ('ESCI /
 * Scopus') olduğu için §0 uyarınca düşük olan alındı. Bu sadece puanı
 * değil, BARAJI da etkiliyor: Fizik bilim alanının "1.2.1 kısımdan en az
 * 30 puan" koşulu ESCI makalenizi saymaz. ESCI makaleniz varsa hem
 * puanınız hem baraj durumunuz OLDUĞUNDAN DÜŞÜK görünür.
 *
 * ── AYNI ETİKETE DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   1.3'te uluslararası özet bildiri (5) ile poster (3) → 3; ulusal özet
 *       (3) ile poster (2) → 2.
 *   1.6'da uluslararası konu yazarlığı (15), ulusal konu (10),
 *       uluslararası madde (10) ve ulusal madde (5) → 5.
 *   3.1'de dergi editörlüğü SCI-E/SSCI/AHCI/ESCI (30), alan indeksi
 *       (20), diğer uluslararası (10), uluslararası (5), TR Dizin (15),
 *       diğer ulusal (5) — etiket ayrımı kısmen var, kalanlar en düşükten.
 *   3.3'te hakemlik (15/10/10/5/5/3/5/3) tek 'Hakemlik' etiketine
 *       düşüyor → 3.
 *   4.1.1-4.1.3 doktora tez danışmanlığı (tek 15 / birinci 10 / ikinci
 *       5): kayıt "tek" ile "birinci" yürütücüyü ayırmadığı için asıl
 *       danışman 10, ikinci danışman 5.
 *   5.1'de derece (45/40), mansiyon (35/30) ve diğer ödül (25/20) tek
 *       'Yarışma Derecesi / Mansiyon' etiketine düşüyor → 20.
 *   6.3'te uluslararası patent (60), ulusal patent (40), faydalı model
 *       (30) ve endüstriyel tasarım (30) — etiket ayrımı var, tescil
 *       aşaması yok.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   1.7.1, 1.7.2, 1.7.4, 1.7.5 (basında mesleki yazı, katalog metni),
 *       1.5.3, 4.2.2, 4.2.5-4.2.8, 6.2.3, 6.2.4, 6.6.3-6.6.10 — sözlükte
 *       karşılık yok.
 *   4.1.8 yükseltilme ve atama jüri üyeliği, 6.4'ün yirmi iki satırı
 *       (toplantı düzenleme, küratörlük, oturum başkanlığı) — tek
 *       'Diğer' etiketine düşüyor, en düşük değerden (2) tek satır.
 *   6.5.1 idari görevler (10 puan × yıl) tek satırda toplandı; yönerge
 *       görevleri ayırmıyor.
 *
 * ── MOTORUN KARŞILAYAMADIĞI SINIRLAR ──
 * "En çok bir/üç/beş adet", "her aktif 5 öğrenci 1 puan × yıl",
 * "kişi sayısına bölünecektir" (6.2.1-6.2.4), "yıl ile çarpılacaktır"
 * (6.5, 6.6.2) ve "son iki yılda verilen" pencereleri.
 *
 * ── YAZAR ÇARPANI YOK ──
 * Yönerge çok yazarlı eserler için genel bir puan paylaştırma kuralı
 * KOYMUYOR; yalnız 6.2'nin dört satırında "kişi sayısına bölünecektir"
 * yazıyor. Bu yüzden cetvelde yazar çarpanı tanımlanmadı — çok yazarlı
 * eserleriniz tam puan alıyor.
 *
 * Yönerge: yonerge/msgsu.php
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 */
$SCI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];

$sanatKisiselU = ['Kişisel Etkinlik (Uluslararası)', 'Elektronik Kişisel Sergi (Uluslararası)',
    'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)'];
$sanatKisiselN = ['Kişisel Etkinlik (Ulusal)', 'Elektronik Kişisel Sergi (Ulusal)',
    'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)'];
$sanatMuzeU = ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Yayında Yer Alması / Satın Alınması',
    'Eserin Haber Olması (Uluslararası)'];
$sanatMuzeN = ['Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Satın Alınması (Yurt İçi)',
    'Eserin Haber Olması (Ulusal)'];
$sanatTasarim = ['Uygulama Projesi — Müellif', 'Özgün Eser / Beste / Tasarım'];
$sanatTasarimE = ['Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı',
    'Uygulama Projesi — Danışman'];
$sanatFilmU = ['Belgesel/Kısa Film (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)',
    'Yönetmenlik (Sahne/Ekran)'];
$sanatFilmN = ['Belgesel/Kısa Film (Ulusal)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'];
$sanatSahneTasarim = ['Sahne Tasarımı (Dekor, Kostüm, Işık)'];
$sanatSolistU = ['Solistlik (Uluslararası)', 'Resital (Uluslararası)', 'Şan Resitali (Uluslararası)',
    'Opera Birinci Rol (Uluslararası)', 'Bale Başrol (Uluslararası)',
    'Orkestra Şefliği (Uluslararası)', 'Opera Şefliği (Uluslararası)',
    'Bale Orkestra Şefliği (Uluslararası)', 'Koro Şefliği (Uluslararası)',
    'Rejisörlük (Uluslararası)', 'Tüm Perde Koreograflığı (Uluslararası)',
    'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Opera/Bale Kompozisyonu',
    'Orkestralı Sahne Eseri'];
$sanatSolistN = ['Solistlik (Ulusal)', 'Resital (Ulusal)', 'Şan Resitali (Ulusal)',
    'Opera Birinci Rol (Ulusal)', 'Bale Başrol (Ulusal)', 'Orkestra Şefliği (Ulusal)',
    'Opera Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Ulusal)', 'Koro Şefliği (Ulusal)',
    'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Tüm Perde Koreograflığı (Ulusal)',
    'Küçük Ölçekli Orkestra Eseri', 'Oda/Koro Müziği Eseri (≥15 dk)',
    'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)',
    'Elektronik Müzik Eseri (<15 dk)', 'Sahne/Ekran Müziği', 'Orkestrasyon/Transkripsiyon'];
$sanatRolU = ['Opera İkinci Rol (Uluslararası)', 'Bale Solist Rol (Uluslararası)',
    'Oda Müziği Grup Üyeliği (Uluslararası)', 'Başkemancılık (Uluslararası)',
    'Dansçı / Performans İcracısı (Uluslararası)', 'Koreografi',
    'Oratoryo/Kantat Solistliği (Uluslararası)', 'Bale/Dans Koreograflığı (Uluslararası)',
    'Rejisör Yardımcılığı (Uluslararası)'];
$sanatRolN = ['Opera İkinci Rol (Ulusal)', 'Bale Solist Rol (Ulusal)',
    'Oda Müziği Grup Üyeliği (Ulusal)', 'Başkemancılık (Ulusal)',
    'Dansçı / Performans İcracısı (Ulusal)', 'Oratoryo/Kantat Solistliği (Ulusal)',
    'Bale/Dans Koreograflığı (Ulusal)', 'Rejisör Yardımcılığı (Ulusal)',
    'Rejisör Yardımcılığı (Konservatuvar)', 'Sahneleme/Repetitörlük — Tüm Perde (Ulusal)',
    'Sahneleme/Repetitörlük — Bölüm (Ulusal)', 'Sahneleme/Repetitörlük — Tüm Perde (Uluslararası)',
    'Sahneleme/Repetitörlük — Bölüm (Uluslararası)', 'Bölüm Koreograflığı (Uluslararası)',
    'Bölüm Koreograflığı (Ulusal)'];
$sanatKoro = ['Orkestra / Koro Üyeliği', 'Corps de Ballet (Uluslararası)',
    'Corps de Ballet (Ulusal)'];
$sanatKarmaU = ['Karma/Jürili Etkinlik (Uluslararası)', 'Elektronik Karma Sergi (Uluslararası)',
    'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)'];
$sanatKarmaN = ['Karma/Jürili Etkinlik (Ulusal)', 'Elektronik Karma Sergi (Ulusal)',
    'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Jürisiz, Ulusal)',
    'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)'];
$sanatRestU = ['Koruma-Onarım Uygulaması (Uluslararası)'];
$sanatRestN = ['Koruma-Onarım Uygulaması (Ulusal)'];
$sanatJuri = ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)',
    'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'];
$sanatAlbum = ['Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)', 'Karma Albüm / CD-DVD Katkısı',
    'Masterclass (Uluslararası)', 'Masterclass (Ulusal)', 'Müzikoloji Atölyesi',
    'Eğitici Konser Programı (Uluslararası)', 'Eğitici Konser Programı (Ulusal)',
    'Eğitim Amaçlı Sanat Etkinliği', 'Eğitim Müziği Albümü', 'Eğitim Müziği Düzenlemesi'];

$sanatKullanilan = array_merge($sanatKisiselU, $sanatKisiselN, $sanatMuzeU, $sanatMuzeN,
    $sanatTasarim, $sanatTasarimE, $sanatFilmU, $sanatFilmN, $sanatSahneTasarim,
    $sanatSolistU, $sanatSolistN, $sanatRolU, $sanatRolN, $sanatKoro, $sanatKarmaU,
    $sanatKarmaN, $sanatRestU, $sanatRestN, $sanatJuri, $sanatAlbum);
$sanatKalan = array_values(array_diff(Kategori::SanatselEtkinlik->kaynaklar(), $sanatKullanilan));

$maddeler = [
    // ══ 1.1 KİTAP ══
    '1.1.1' => ['baslik' => 'Tanınmış uluslararası yayınevleri tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 60],
    '1.1.2' => ['baslik' => 'Tanınmış uluslararası yayınevleri tarafından yayımlanmış kitap içinde bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 20],
    '1.1.3' => ['baslik' => 'Tanınmış ulusal yayınevleri tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 30],
    '1.1.4' => ['baslik' => 'Tanınmış ulusal yayınevleri tarafından yayımlanmış kitap içinde bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 10],

    // ══ 1.2 MAKALE ══
    '1.2.1' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'puan' => 35],
    '1.2.2' => ['baslik' => 'Alan indeksleri (Scopus dâhil) kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 25],
    '1.2.3' => ['baslik' => 'Uluslararası diğer indekslerde yer alan hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'puan' => 15],
    '1.2.4' => ['baslik' => 'TÜBİTAK ULAKBİM TR Dizinde yer alan ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 15],
    '1.2.5' => ['baslik' => 'Ulusal diğer hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 5],

    // ══ 1.3 BİLDİRİ ══
    '1.3.1' => ['baslik' => 'Uluslararası kongre ya da sempozyumda sunulmuş, tam metni yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 10],
    '1.3.3' => ['baslik' => 'Uluslararası kongre ya da sempozyumda sunulmuş özet veya poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster', 'Davetli Konuşmacı'], 'puan' => 3],
    '1.3.4' => ['baslik' => 'Ulusal kongre ya da sempozyumda sunulmuş, tam metni yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 5],
    '1.3.6' => ['baslik' => 'Ulusal kongre ya da sempozyumda sunulmuş özet veya poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 2],

    // ══ 1.4 ÇEVİRİ ══
    '1.4.1' => ['baslik' => 'Tanınmış ulusal yayınevleri tarafından yayımlanmış kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 15],
    '1.4.2' => ['baslik' => 'Makale ya da kitap içinden bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 5],

    // ══ 1.5 RAPOR ══
    '1.5.1' => ['baslik' => 'Yayımlanmış bilimsel rapor', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Bilim İletişimi / Popüler Yayın', 'Kamu/STK Danışmanlığı', 'Topluma Hizmet Projesi'], 'puan' => 5],

    // ══ 1.6 ANSİKLOPEDİ ══
    '1.6.4' => ['baslik' => 'Ansiklopedide konu ya da madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 5],

    // ══ 1.7 DİĞER YAYIN ══
    '1.7.3' => ['baslik' => 'Basılı veya dijital ortamda yayımlanmış ders notu', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 10],

    // ══ 1.8 ATIFLAR ══
    '1.8.1' => ['baslik' => 'SCI, SCI-Expanded, SSCI, AHCI ya da ESCI dergilerinde ve tanınmış uluslararası yayınevi kitaplarında eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 5],
    '1.8.2' => ['baslik' => 'Alan indeksli dergilerde ve uluslararası yayınevi kitap bölümlerinde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 3],
    '1.8.3' => ['baslik' => 'ULAKBİM TR Dizin dergilerinde ve tanınmış ulusal yayınevi kitaplarında eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
    '1.8.4' => ['baslik' => 'Diğer atıflar', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],

    // ══ 2. SANAT VE TASARIM ETKİNLİKLERİ ══
    '2.1.1' => ['baslik' => 'Uluslararası ya da yurt dışında seçici kurulu bulunan tanınmış müze, kültür merkezi veya sanat galerisinde kişisel sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKisiselU, 'puan' => 60],
    '2.1.2' => ['baslik' => 'Yurt içinde seçici kurulu bulunan tanınmış müze, kültür merkezi veya sanat galerisinde kişisel sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKisiselN, 'puan' => 30],
    '2.2.1' => ['baslik' => 'Uluslararası ya da yurt dışı tanınmış müze veya büyük koleksiyonlarda eserinizin yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatMuzeU, 'puan' => 60],
    '2.2.2' => ['baslik' => 'Yurt içi tanınmış müze veya büyük koleksiyonlarda eserinizin yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatMuzeN, 'puan' => 40],
    '2.4.1' => ['baslik' => 'Tasarım alanında seri üretime girmiş çalışma, koleksiyon ya da uygulanmış proje (müellif)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatTasarim, 'puan' => 30],
    '2.4.2' => ['baslik' => 'Tasarım ya da uygulama projesinde ekip üyesi veya danışman olarak görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatTasarimE, 'puan' => 10],
    '2.5.1' => ['baslik' => 'Uluslararası etkinliklerde film gösterisi, yönetmenlik ya da yayımlanmış film, dizi veya televizyon programı bölümü', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatFilmU, 'puan' => 40],
    '2.5.5' => ['baslik' => 'Ulusal etkinliklerde film gösterisi ya da yayımlanmış film, dizi veya televizyon programı bölümü', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatFilmN, 'puan' => 30],
    '2.7.3' => ['baslik' => 'Sahne tasarımı (dekor, kostüm, ses, ışık)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatSahneTasarim, 'puan' => 30],
    '2.8.1' => ['baslik' => 'Uluslararası ya da yurt dışı etkinlikte besteniz seslendirilmesi, orkestra yönetmek, solist olarak konser vermek, başrol oynamak, koreografi yapmak ya da solo resital', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatSolistU, 'puan' => 60],
    '2.8.4' => ['baslik' => 'Ulusal etkinlikte besteniz seslendirilmesi, orkestra yönetmek, solist olarak konser vermek, başrol oynamak, koreografi yapmak ya da solo resital', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatSolistN, 'puan' => 30],
    '2.8.2' => ['baslik' => 'Uluslararası ya da yurt dışı gösteride orkestrada çalmak, rol almak, oda müziği konseri ya da koreograflık', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatRolU, 'puan' => 30],
    '2.8.5' => ['baslik' => 'Ulusal gösteride orkestrada çalmak, rol almak, oda müziği konseri ya da koreograflık', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatRolN, 'puan' => 15],
    '2.8.6' => ['baslik' => 'Gösteride koroda söylemek ya da korist olarak sahneye çıkmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKoro, 'puan' => 5],
    '2.10.1' => ['baslik' => 'Uluslararası sergi, bienal, trienal, festival, uygulamalı sempozyum ya da gösteride jürili karma etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKarmaU, 'puan' => 30],
    '2.10.2' => ['baslik' => 'Ulusal sergi, bienal, trienal, festival, uygulamalı sempozyum ya da gösteride jürili karma etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => [...$sanatKarmaN, ...$sanatAlbum, ...$sanatKalan], 'puan' => 15],
    '2.13.1' => ['baslik' => 'Yurt dışında müze eseri, kazı buluntusu, koleksiyon, film arşivi ve sinematografik malzemelerin restorasyon ve konservasyon çalışması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatRestU, 'puan' => 60],
    '2.13.3' => ['baslik' => 'Ulusal müze eseri, kazı buluntusu, koleksiyon, film arşivi ve sinematografik malzemelerin restorasyon ve konservasyon çalışması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatRestN, 'puan' => 50],

    // ══ 3. EDİTÖRLÜK, HAKEMLİK, JÜRİ ÜYELİĞİ ══
    '3.1.1' => ['baslik' => 'Tanınmış uluslararası yayınevleri tarafından yayımlanmış kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 30],
    '3.1.2' => ['baslik' => 'Tanınmış ulusal yayınevleri tarafından yayımlanmış kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 20],
    '3.1.3' => ['baslik' => 'SCI-E, SSCI, AHCI ya da ESCI indekslerinde yer alan dergi editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 30],
    '3.1.4' => ['baslik' => 'Alan indekslerinde yer alan dergi editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 20],
    '3.1.7' => ['baslik' => 'TÜBİTAK ULAKBİM TR Dizinde yer alan ulusal dergi editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 15],
    '3.1.8' => ['baslik' => 'Ulusal diğer dergi editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 5],
    '3.2.2' => ['baslik' => 'Yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 5],
    '3.3.8' => ['baslik' => 'Dergi, kitap ya da sanat etkinliği hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 3],
    '3.4.2' => ['baslik' => 'Sanat ve tasarım etkinliklerinde jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatJuri, 'puan' => 10],

    // ══ 4. ÖĞRETİM ETKİNLİKLERİ ══
    '4.1.2' => ['baslik' => 'Jüri tarafından kabul edilmiş doktora ya da sanatta yeterlik tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 10],
    '4.1.3' => ['baslik' => 'Doktora ya da sanatta yeterlik tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 5],
    '4.1.4' => ['baslik' => 'Jüri tarafından kabul edilmiş yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 5],
    '4.1.5' => ['baslik' => 'Tez jüri üyeliği ya da tez izleme jüri üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'roller' => ['es_danisman'], 'puan' => 2],
    '4.2.1' => ['baslik' => 'Son iki yılda verilen ön lisans, lisans ya da lisansüstü ders yürütücülüğü', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders'], 'puan' => 3],
    '4.2.4' => ['baslik' => 'Yurt dışında ders vermek üzere konuk öğretim üyeliği', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Değişim Programı Dersi'], 'puan' => 5],

    // ══ 5. ÖDÜLLER ══
    '5.1.3' => ['baslik' => 'Bilim, sanat, tasarım ya da proje yarışmasında alınmış derece, mansiyon veya diğer ödül', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon', 'Uluslararası Bilim/Sanat Ödülü', 'Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 20],
    '5.2.3' => ['baslik' => 'Ulusal ya da uluslararası kuruluşlardan alınan araştırma bursu', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 10],

    // ══ 6.1 ARAŞTIRMA PROJELERİ ══
    '6.1.1' => ['baslik' => 'AB, BM, Dünya Bankası, OECD, NATO ve eşdeğer kurumlarda sonuçlanmış projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 60],
    '6.1.2' => ['baslik' => 'AB, BM, Dünya Bankası, OECD, NATO ve eşdeğer kurumlarda sonuçlanmış projede üye', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 50],
    '6.1.3' => ['baslik' => 'TÜBİTAK, bakanlıklar, TTGV ve eşdeğer kurumlarda sonuçlanmış projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 40],
    '6.1.4' => ['baslik' => 'TÜBİTAK, bakanlıklar, TTGV ve eşdeğer kurumlarda sonuçlanmış projede üye ya da danışman', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 30],
    '6.1.5' => ['baslik' => 'Diğer uluslararası araştırma projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 30],
    '6.1.6' => ['baslik' => 'Diğer uluslararası araştırma projesinde üye', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
    '6.1.7' => ['baslik' => 'Diğer ulusal araştırma projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 20],
    '6.1.8' => ['baslik' => 'Diğer ulusal araştırma projesinde üye', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],

    // ══ 6.3 PATENT, YAZILIM VE TASARIM TESCİLİ ══
    '6.3.1' => ['baslik' => 'Uluslararası patent, yazılım geliştirme ya da tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 60],
    '6.3.2' => ['baslik' => 'Ulusal patent, yazılım geliştirme ya da tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili', 'Ticarileştirme'], 'puan' => 40],
    '6.3.3' => ['baslik' => 'Faydalı model belgesi ya da endüstriyel tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım'], 'puan' => 30],

    // ══ 6.4 BİLİMSEL VE SANATSAL TOPLANTI DÜZENLEME ══
    '6.4.18' => ['baslik' => 'Bilimsel ya da sanatsal toplantı düzenleme, küratörlük, oturum başkanlığı ve benzeri görevler', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 2],
    // Kaynak 6.4.17 uluslararası panel/seminer oturum başkanlığı 3, 6.4.18 ULUSAL 2 diyor.
    '6.4.18-otr' => ['baslik' => 'Uluslararası bilimsel ya da sanatsal toplantıda oturum başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Uluslararası)'], 'puan' => 3],
    '6.4.18-otr-ulusal' => ['baslik' => 'Ulusal bilimsel ya da sanatsal toplantıda oturum başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Ulusal)'], 'puan' => 2],

    // ══ 6.5 İDARİ GÖREVLER ══
    '6.5.1' => ['baslik' => 'Akademik teşkilat yönetmeliğinde tanımlanan idari görevleri üstlenmek (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü', 'Dekan Yrd. / Müdür Yrd.', 'Uygulama ve Araştırma Merkezi Müdürü', 'Bölüm Başkanı', 'Bölüm Başkan Yardımcısı'], 'puan' => 10],

    // 'Anabilim Dalı Başkanı / Koordinatörlük' etiketi anabilim dalı
    // başkanlığını (6.5.1, 10 puan) koordinatörlükle birleştiriyor;
    // koordinatörlük 6.6'da 1 ya da 3 puan ve kayıt süreyi taşımıyor,
    // §0 uyarınca altı aydan kısa satırdan sayılıyor (01.09.2026).
    '6.6.1' => ['baslik' => 'Altı aydan kısa süreli komisyon, kurul üyeliği veya koordinatörlük', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 1],    '6.6.2' => ['baslik' => 'Altı aydan uzun süreli komisyon, kurul üyeliği ve koordinatörlükler (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 3],
];

/** @param list<string> $onekler */
$onek = fn (array $onekler): array => array_values(array_filter(
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

return [
    'kapsam_notu' => 'Puanlar Mimar Sinan Güzel Sanatlar Üniversitesi Akademik Yükseltilme, İlk '
        .'Atanma ve Yeniden Atanma Ölçütleri Tablosundan (EK 1). Yönerge çok yazarlı eserler '
        .'için genel bir puan paylaştırma kuralı KOYMUYOR (yalnız 6.2\'nin dört satırında "kişi '
        .'sayısına bölünecektir" yazıyor); bu yüzden yazar çarpanı uygulanmıyor ve çok yazarlı '
        .'eserleriniz tam puan alıyor. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: 1.2.1 satırı ESCI dergilerine de 35 '
        .'puan veriyor ama sözlükte ESCI ile Scopus tek etiket olduğu için ikisi de 1.2.2\'den '
        .'(25) sayılıyor. Bu yalnız puanı değil BARAJI da etkiler: "1.2.1 kısımdan en az 30 '
        .'puan" koşulu ESCI makalenizi saymaz. Özet ve poster bildiriler 3 ve 2 puandan, '
        .'ansiklopedi yazarlıkları 5 puandan, hakemlikler 3 puandan, ödüller 20 puandan '
        .'sayılıyor. Doktora tez danışmanlığında "tek yürütücü" (15) ile "birinci yürütücü" (10) '
        .'ayrımı kayıttan okunamadığı için 10 puandan. Basında mesleki yazı ve katalog metni '
        .'(1.7), akademik danışmanlık ve yardımcılık satırları (4.2.2, 4.2.5-4.2.8), laboratuvar '
        .'çalışmaları (6.2.3-6.2.4) ile 6.6\'nın çoğu satırı sözlükte karşılıksız olduğu için '
        .'girilemedi. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünebilir: "en çok bir/üç/beş adet", "her '
        .'aktif 5 öğrenci 1 puan × yıl", "kişi sayısına bölünecektir", "yıl ile çarpılacaktır" ve '
        .'"son iki yılda verilen" sınırları uygulanmıyor.',

    'maddeler' => $maddeler,

    'gruplar' => [
        // EK 3'ün atıf yaptığı bölümler.
        '1' => $onek(['1.']),
        '1.1' => $onek(['1.1.']),
        '1.2' => $onek(['1.2.']),
        '1.2.1' => ['1.2.1'],
        '2' => $onek(['2.']),
        '3' => $onek(['3.']),
        '4' => $onek(['4.']),
        '5' => $onek(['5.']),
        '6.1' => $onek(['6.1.']),
        '6' => $onek(['6.']),

        // Adet tavanı olan satırlar. Motorda "en fazla N faaliyet" düğümü
        // yok, ama satırın puanı sabit olduğu için tavan puana çevriliyor
        // (KONVANSIYONLAR: "Adet tavanı puana ÇEVRİLEBİLİR").
        'A-1.4.1' => ['1.4.1'],
        'A-1.4.2' => ['1.4.2'],
        'A-1.6.4' => ['1.6.4'],
        'A-2.8.6' => ['2.8.6'],
        'A-3.3.8' => ['3.3.8'],
        'A-3.4.2' => ['3.4.2'],
        'A-4.1.4' => ['4.1.4'],
        'A-4.1.5' => ['4.1.5'],
        'A-6.6.1' => ['6.6.1'],
    ],

    /*
     * EK 3'ün satır başlıklarındaki ADET TAVANLARI, puana çevrilmiş hâli.
     * Hiçbiri girilmemişti; tavansız satır doğrudan fazla saydırır (§0).
     * Çeviri: adet × satırın puanı.
     *
     *   1.4.1 kitap çevirisi          en çok bir adet × 15 =  15
     *   1.4.2 bölüm çevirisi          en çok üç adet  ×  5 =  15
     *   1.6.4 ansiklopedi yazarlığı   en çok iki adet ×  5 =  10
     *   2.8.6 koro / korist           en çok beş adet ×  5 =  25
     *   3.3.8 hakemlik                en çok beş adet ×  3 =  15
     *   3.4.2 etkinlikte jüri üyeliği en çok üç adet  × 10 =  30
     *   4.1.4 YL tez danışmanlığı     en çok üç adet  ×  5 =  15
     *   4.1.5 tez jüri üyeliği        en çok üç adet  ×  2 =   6
     *   6.6.1 kısa süreli komisyon    en çok üç adet  ×  1 =   3
     *
     * ÜÇ SATIR KAYNAKTA BİRDEN ÇOK SATIRIN BİRLEŞİMİ (1.6.4 = 1.6.1-1.6.4,
     * 3.4.2 = 3.4.1-3.4.2, 4.1.5 = 4.1.5-4.1.7) ve kaynak adet tavanını her
     * satıra AYRI AYRI veriyor. Birleşik satırın adedi hangi alt satıra ait
     * olduğunu bilemediğimiz için TEK satırın tavanı yazıldı; aday bu
     * kalemlerde puanını olduğundan DÜŞÜK görebilir. Yön §0'a uygun,
     * alternatifi (tavansız bırakmak) fazla saydırırdı.
     *
     * GİRİLMEYEN ADET TAVANLARI: 6.6.2 ve 6.5.1 (tavan yıl ile çarpılıyor,
     * puana sabit çevrilemiyor) ve 6.4.18 (kaynakta tavan yalnız YENİDEN
     * ATANMADA geçerli, cetvel kadroya göre varyantlanmıyor).
     */
    'grup_tavanlari' => [
        'A-1.4.1' => 15,
        'A-1.4.2' => 15,
        'A-1.6.4' => 10,
        'A-2.8.6' => 25,
        'A-3.3.8' => 15,
        'A-3.4.2' => 30,
        'A-4.1.4' => 15,
        'A-4.1.5' => 6,
        'A-6.6.1' => 3,
    ],
];
