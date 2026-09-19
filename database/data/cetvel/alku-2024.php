<?php

/**
 * ALANYA ALAADDİN KEYKUBAT ÜNİVERSİTESİ — Tablo 1a, Tablo 1b ve Tablo 2
 * Kaynak: pdf/17536928472.alanyaalaattinkeykubatuniverstesi.pdf
 *
 * NOT: PDF'in font kodlamasında "i" harfi kayıp ("Öğret m Üyes " gibi).
 * Metin okunabiliyor ve BÜTÜN SAYILAR sağlam; başlıklar okunurken harf
 * tamamlandı.
 *
 * Madde kodları bize ait: yönergenin tabloları satırlara kod vermiyor.
 * "1a.", "1b." ve "2." önekleri hangi tablodan geldiğini gösteriyor.
 *
 * ── ARAŞTIRMA MAKALESİ / DERLEME AYRIMI ──
 * Tablo 1a araştırma makalesi ile derleme makaleye ayrı puan veriyor
 * (60 ↔ 50, 30 ↔ 20 …). Açıklama 8 ayrıca "araştırma makalesi türü yayın
 * şartının karşılanmasında derleme, vaka takdimi, editöre mektup veya
 * eleştiri değerlendirilmez" diyor; koşulların bağlandığı gruplar bu
 * yüzden yalnız araştırma makalesi satırlarını içeriyor.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   ESCI dergileri 50 puan alıyor ama sözlükteki 'ESCI / Scopus' etiketi
 *       Scopus'u da kapsıyor; Scopus yönergede ayrıca sayılmadığı için
 *       "diğer indeksler" satırının 25 puanı uygulandı. Aynı gerekçeyle
 *       ÜAK'ın kabul ettiği uluslararası alan indeksleri de (50) 25
 *       puandan sayılıyor. Derlemede 40 yerine 15.
 *   Patentte incelemeli (120) ile incelemesiz (60) ayrımı kayıtta yok →
 *       60; BAŞVURU satırları (40, 20, 10) girilmedi.
 *   Kitapta ansiklopedi maddesi uluslararası 15 ↔ ulusal 10 → 10: etiketin
 *       kapsam ayrımı yok. Bilimsel kitap, ders kitabı ve kitap bölümü ise
 *       19.09.2026'da iki kademesine açıldı — Açıklama iii "uluslararası"yı
 *       YAYINEVİNE bağlıyor ("yabancı dilde yazılmış veya … uluslararası
 *       nitelikte faaliyet gösterdiği belgelenebilen yayınevleri tarafından
 *       basılmış eserler"), indeks aramıyor; sözlükteki `Uluslararası Kitap`
 *       ailesi bu ayrımın birebir karşılığı. Önceden üst satırlar yalnız
 *       BKCI/Scopus etiketini taşıdığı için indekssiz uluslararası kitap
 *       120 yerine 70, bölümü 30 yerine 15 puan alıyordu.
 *   Sanat yarışmalarında ödül (30/20) ile meslek odası yarışmalarında
 *       derece (50/40) tek 'Yarışma Derecesi / Mansiyon' etiketine
 *       düşüyor → 20.
 *   Dergi görevlerinde yayın kurulu üyeliği 10 ↔ 5 → 5, hakemlik 5 ↔ 3
 *       → 3. Bilimsel toplantı görevlerinin altı kademesi (30'dan 3'e)
 *       tek 'Diğer' etiketine düşüyor → 3.
 *   Atıfta 'WoS / Scopus' etiketi 8, 5 ve 3 puanlık üç satırı birden
 *       karşılıyor → 3.
 *   İdari görevlerde dekanlık (30), enstitü müdürlüğü (20) ve yüksekokul
 *       müdürlüğü (15) tek etikete düşüyor → 15; dekan yardımcılığı (15)
 *       ile yüksekokul müdür yardımcılığı (10) → 10.
 *   Bilirkişilik ve eğiticilik (2), kamu/özel sektör danışmanlığı (3) ve
 *       bilim kurulu üyelikleri (20/10) tek 'Kamu/STK Danışmanlığı'
 *       etiketine düşüyor → 2.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   Yurt dışı üniversite destekli proje (20) ve altyapı projesi (20) —
 *       sözlükte karşılıksız.
 *   Kitap eleştirisi (10/5), uluslararası yayınevlerince basılmış eserin
 *       makale tercümesi (8), TÜBİTAK panelistliği (10/5/3) ve
 *       "TÜBİTAK'a proje başvurusu" (30) — sözlükte karşılıksız ya da
 *       başvuru satırı.
 *   Spor branşlarında görev almak (millî takım 20, takım hazırlama 10,
 *       derece 10) ve öğrenci danışmanlıkları (10/5/2/1) — sözlükte
 *       karşılıksız; danışmanlığın 50 puanlık tavanı da bu yüzden
 *       yazılamadı.
 *   Rektörlük ve rektör yardımcılığı — Tablo 2'nin idari görev
 *       satırlarında yok.
 *   Üniversite-sanayi iş birliği görevlendirmesi (5).
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   "İndekslenmeyen hakemli dergilerde en çok 2 adet/yıl", "diğer
 *       çalışmalarda en çok 3 adet/yıl", "yabancı dilde ders en çok 2
 *       adet/yıl", "bilirkişilik en çok 2 adet/yıl" ve "basında mülakat
 *       en çok 5 adet/yıl" gibi YIL BAŞINA sınırlar.
 *   İdari görevlerin "en az 1 yıl görev yapmak kaydıyla en fazla 5 yıl
 *       olmak üzere her yıl için" hesabı; kayıt görev süresini taşımadığı
 *       için kayıt başına puanlanıyor.
 *   Lisansüstü ve lisans derslerinin "son beş eğitim-öğretim yılı"
 *       penceresi.
 *   Açıklama 6'nın muafiyeti (etki faktörü 5 üzeri dergide bir makale ya
 *       da h-indeksi 5/10/15) — koşulu hafifletir, girilmedi.
 *
 * Yönerge: yonerge/alku.php
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 */
$ARASTIRMA = ['ozgun_makale'];
$DERLEME = ['derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];
$WOS = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];
$ULUSLARARASI_FON = ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'];
$ULUSAL_FON = ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'];
$BAP_FON = ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'];

$maddeler = [
    // ══ TABLO 1a — ARAŞTIRMA MAKALESİ ══
    '1a.1' => ['baslik' => 'SSCI, AHCI, SCI ya da SCI-Expanded kapsamındaki dergide yayımlanmış araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $ARASTIRMA, 'puan' => 60],
    '1a.2' => ['baslik' => 'ESCI kapsamındaki dergide yayımlanmış araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $ARASTIRMA, 'puan' => 25],
    '1a.3' => ['baslik' => 'ÜAK ya da Üniversite Senatosunca kabul edilen uluslararası alan indeksleri kapsamındaki dergide yayımlanmış araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $ARASTIRMA, 'puan' => 25],
    '1a.4' => ['baslik' => 'TR Dizin kapsamında yer alan dergide yayımlanmış araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $ARASTIRMA, 'puan' => 30],
    '1a.5' => ['baslik' => 'İndekslenmeyen hakemli dergide yayımlanmış araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $ARASTIRMA, 'puan' => 10],

    // ══ TABLO 1a — DERLEME MAKALE ══
    '1a.6' => ['baslik' => 'SSCI, AHCI, SCI ya da SCI-Expanded kapsamındaki dergide yayımlanmış derleme makale', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $DERLEME, 'puan' => 50],
    '1a.7' => ['baslik' => 'ESCI ya da uluslararası alan indeksleri kapsamındaki dergide yayımlanmış derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $DERLEME, 'puan' => 15],
    '1a.8' => ['baslik' => 'TR Dizin kapsamında yer alan dergide yayımlanmış derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $DERLEME, 'puan' => 20],
    '1a.9' => ['baslik' => 'İndekslenmeyen hakemli dergide yayımlanmış derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $DERLEME, 'puan' => 5],

    // ══ TABLO 1a — DİĞER ÇALIŞMALAR ══
    '1a.10' => ['baslik' => 'SSCI, AHCI, SCI ya da SCI-Expanded kapsamındaki dergide yayımlanmış teknik not, yorum, vaka takdimi veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $KISA, 'puan' => 15],
    '1a.11' => ['baslik' => 'ESCI ya da uluslararası alan indeksleri kapsamındaki dergide yayımlanmış teknik not, yorum, vaka takdimi veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 5],
    '1a.12' => ['baslik' => 'TR Dizin ya da indekslenmeyen dergide yayımlanmış teknik not, yorum, vaka takdimi veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 1],

    // ══ TABLO 1a — PATENT ══
    '1a.13' => ['baslik' => 'Ulusal ya da uluslararası patent (başvuru sonuçlanmış)', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent', 'Ulusal Patent'], 'puan' => 60],
    '1a.14' => ['baslik' => 'Faydalı model ya da yeni ürün tescili (başvuru sonuçlanmış)', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 25],
    '1a.15' => ['baslik' => 'Teknoloji Transfer Ofisine buluş bildiriminde bulunup olumlu rapor almak', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme', 'Yazılım'], 'puan' => 15],

    // ══ TABLO 1a — ARAŞTIRMA PROJESİ ══
    '1a.16' => ['baslik' => 'Yurt dışı destekli araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => $ULUSLARARASI_FON, 'roller' => ['yurutucu', 'arastirmaci', 'bursiyer'], 'puan' => 100],
    '1a.17' => ['baslik' => 'Yurt içi, üniversite dışı destekli araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => $ULUSAL_FON, 'roller' => ['yurutucu', 'arastirmaci', 'bursiyer'], 'puan' => 80],
    '1a.18' => ['baslik' => 'Yurt içi üniversite destekli araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => $BAP_FON, 'roller' => ['yurutucu', 'arastirmaci', 'bursiyer'], 'puan' => 15],
    '1a.19' => ['baslik' => 'Araştırma projesi danışmanlığı', 'kategori' => 'proje', 'kaynaklar' => [...$ULUSLARARASI_FON, ...$ULUSAL_FON, ...$BAP_FON], 'roller' => ['danisman'], 'puan' => 5],

    // ══ TABLO 1a — BİLDİRİLER ══
    '1a.20' => ['baslik' => 'Uluslararası toplantıda sunulmuş, basılı ya da elektronik olarak yayımlanmış tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 15],
    '1a.21' => ['baslik' => 'Ulusal toplantıda sunulmuş, basılı ya da elektronik olarak yayımlanmış tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 3],
    '1a.22' => ['baslik' => 'Uluslararası katılımlı toplantıda sunulmuş özet ya da poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 3],
    '1a.23' => ['baslik' => 'Ulusal toplantıda sunulmuş özet ya da poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 2],

    // ══ TABLO 1a — KİTAP ══
    '1a.24' => ['baslik' => 'Uluslararası yayınevince basılmış bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası Kitap'], 'puan' => 120],
    '1a.25' => ['baslik' => 'Ulusal yayınevince basılmış bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap'], 'puan' => 70],
    '1a.26u' => ['baslik' => 'Uluslararası yayınevince basılmış ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası Ders / Metot Kitabı'], 'puan' => 50],
    '1a.26' => ['baslik' => 'Ulusal yayınevince basılmış ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Ders / Metot Kitabı'], 'puan' => 30],
    '1a.27' => ['baslik' => 'Uluslararası yayınevince basılmış kitaba bölüm düzeyinde katkıda bulunmak', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Uluslararası Kitap Bölümü'], 'puan' => 30],
    '1a.28' => ['baslik' => 'Ulusal yayınevince basılmış kitaba bölüm düzeyinde katkıda bulunmak', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap Bölümü'], 'puan' => 15],
    '1a.29' => ['baslik' => 'Uluslararası yayınevince basılmış kitapta editör olmak (çeviri editörü dâhil)', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Uluslararası Kitap Editörlüğü'], 'puan' => 40],
    '1a.30' => ['baslik' => 'Kitapta editör olmak (çeviri editörü dâhil)', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 20],
    '1a.31' => ['baslik' => 'Ansiklopedide konu ya da madde yazarı olmak', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 10],
    '1a.32' => ['baslik' => 'Uluslararası yayınevlerince yabancı dilde basılmış bilimsel ya da edebî eserin Türkçeye tercümesi (tam kitap)', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 40],
    '1a.33' => ['baslik' => 'Uluslararası yayınevlerince yabancı dilde basılmış bilimsel ya da edebî eserin bölüm tercümesi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 20],
    '1a.34' => ['baslik' => 'Tarihî ve yazma eserlerin (1928 ve öncesi) günümüz Türkçesine ya da Latin harflerine çevrilmesi', 'kategori' => 'kitap', 'kaynaklar' => ['Tahkik (Tenkitli Metin)'], 'puan' => 30],

    // ══ TABLO 1b — MİMARİ VE SANATSAL ETKİNLİKLER ══
    '1b.1' => ['baslik' => 'Eğitim-öğretim ya da meslek pratiğine yönelik geliştirilmiş model, proje ya da planlarda proje müellifi olmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif'], 'puan' => 60],
    '1b.2' => ['baslik' => 'Eğitim-öğretim ya da meslek pratiğine yönelik geliştirilmiş model, proje ya da planlarda proje ekibinde yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Ekip'], 'puan' => 30],
    '1b.3' => ['baslik' => 'Eğitim-öğretim ya da meslek pratiğine yönelik geliştirilmiş model, proje ya da planlarda proje ekibi yardımcısı olmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Ekip Yardımcısı'], 'puan' => 15],
    '1b.4' => ['baslik' => 'Eğitim-öğretim ya da meslek pratiğine yönelik geliştirilmiş model, proje ya da planlarda danışmanlık yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Danışman'], 'puan' => 20],
    '1b.5' => ['baslik' => 'Uluslararası kişisel etkinlik: sergi açma, proje uygulama, gösteri, resital, konserlere solist ya da icracı olarak katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Resital (Uluslararası)', 'Solistlik (Uluslararası)', 'Şan Resitali (Uluslararası)', 'Oratoryo/Kantat Solistliği (Uluslararası)', 'Orkestra Şefliği (Uluslararası)', 'Opera Şefliği (Uluslararası)', 'Koro Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Uluslararası)', 'Opera Birinci Rol (Uluslararası)', 'Bale Başrol (Uluslararası)', 'Rejisörlük (Uluslararası)'], 'puan' => 30],
    '1b.6' => ['baslik' => 'Ulusal kişisel etkinlik: sergi açma, proje uygulama, gösteri, resital, konserlere solist ya da icracı olarak katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)', 'Resital (Ulusal)', 'Solistlik (Ulusal)', 'Şan Resitali (Ulusal)', 'Oratoryo/Kantat Solistliği (Ulusal)', 'Orkestra Şefliği (Ulusal)', 'Opera Şefliği (Ulusal)', 'Koro Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Ulusal)', 'Opera Birinci Rol (Ulusal)', 'Bale Başrol (Ulusal)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Yönetmenlik (Sahne/Ekran)', 'Özgün Eser / Beste / Tasarım', 'Opera/Bale Kompozisyonu', 'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Orkestralı Sahne Eseri', 'Küçük Ölçekli Orkestra Eseri', 'Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Sahne/Ekran Müziği', 'Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi', 'Sahne Tasarımı (Dekor, Kostüm, Işık)', 'Koreografi'], 'puan' => 20],
    '1b.7' => ['baslik' => 'Uluslararası karma sanat etkinliğine bireysel ya da ekip hâlinde katılmak, TV ve radyo programlarına katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Karma Sergi (Uluslararası)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Oda Müziği Grup Üyeliği (Uluslararası)', 'Grup Şefliği (Uluslararası)', 'Başkemancılık (Uluslararası)', 'Corps de Ballet (Uluslararası)', 'Opera İkinci Rol (Uluslararası)', 'Bale Solist Rol (Uluslararası)', 'Dansçı / Performans İcracısı (Uluslararası)', 'Masterclass (Uluslararası)', 'Eğitici Konser Programı (Uluslararası)', 'Rejisör Yardımcılığı (Uluslararası)', 'Tüm Perde Koreograflığı (Uluslararası)', 'Bölüm Koreograflığı (Uluslararası)', 'Bale/Dans Koreograflığı (Uluslararası)', 'Sahneleme/Repetitörlük — Tüm Perde (Uluslararası)', 'Sahneleme/Repetitörlük — Bölüm (Uluslararası)'], 'puan' => 15],
    '1b.8' => ['baslik' => 'Ulusal karma sanat etkinliğine bireysel ya da ekip hâlinde katılmak, TV ve radyo programlarına katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Oda Müziği Grup Üyeliği (Ulusal)', 'Orkestra / Koro Üyeliği', 'Grup Şefliği (Ulusal)', 'Başkemancılık (Ulusal)', 'Corps de Ballet (Ulusal)', 'Opera İkinci Rol (Ulusal)', 'Bale Solist Rol (Ulusal)', 'Dansçı / Performans İcracısı (Ulusal)', 'Masterclass (Ulusal)', 'Eğitici Konser Programı (Ulusal)', 'Müzikoloji Atölyesi', 'Eğitim Amaçlı Sanat Etkinliği', 'Rejisör Yardımcılığı (Ulusal)', 'Rejisör Yardımcılığı (Konservatuvar)', 'Tüm Perde Koreograflığı (Ulusal)', 'Bölüm Koreograflığı (Ulusal)', 'Bale/Dans Koreograflığı (Ulusal)', 'Sahneleme/Repetitörlük — Tüm Perde (Ulusal)', 'Sahneleme/Repetitörlük — Bölüm (Ulusal)'], 'puan' => 10],
    '1b.9' => ['baslik' => 'Jürili belgesel, kısa film, film ya da festivallere katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)'], 'puan' => 15],
    '1b.10' => ['baslik' => 'Adayın yapıtlarının ve icralarının resmî ya da özel kurum ve kuruluşlarca yayımlanması veya satın alınması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt İçi)', 'Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)', 'Karma Albüm / CD-DVD Katkısı', 'Eğitim Müziği Albümü', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)'], 'puan' => 15],
    '1b.11' => ['baslik' => 'Adayın yapıtlarının ve icralarının kitap, ansiklopedi, dergi, belgesel ya da filmde yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Haber Olması (Uluslararası)', 'Eserin Haber Olması (Ulusal)'], 'puan' => 5],
    '1b.12' => ['baslik' => 'Sanat, proje ve tasarım yarışma jürilerinde görev almış olmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 5],
    '1b.13' => ['baslik' => 'Jürili sanat, tasarım ya da proje yarışmalarında derece veya mansiyon almak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 20],

    // ══ TABLO 2 ══
    '2.1' => ['baslik' => 'Uzmanlık ya da çalışma alanıyla ilgili bilimsel etkinliklerde davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 10],
    '2.2' => ['baslik' => 'Uluslararası yayınevlerince basılan kitaplarda ya da bölümlerde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 5],
    '2.3' => ['baslik' => 'SSCI, AHCI, SCI, SCI-Expanded ve ESCI kapsamındaki dergilerde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['SCIE/SSCI/AHCI', 'ESCI'], 'puan' => 3],
    '2.4' => ['baslik' => 'Uluslararası alan indeksleri ya da TR Dizin kapsamındaki dergilerde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Scopus'], 'puan' => 2],
    '2.5' => ['baslik' => 'Yukarıdakiler dışında kalan atıflar', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],
    '2.6' => ['baslik' => 'Uluslararası bilim ve araştırma ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 50],
    '2.7' => ['baslik' => 'Ulusal bilim ve araştırma ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü', 'Burs'], 'puan' => 25],
    '2.8' => ['baslik' => 'Bilim ya da sanat kurulu üyeliği, bilirkişilik, kayyumluk, eğiticilik ve kamu ya da özel sektörde resmî danışmanlık', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı', 'Topluma Hizmet Projesi'], 'puan' => 2],
    '2.9' => ['baslik' => 'Alanıyla ilgili basında mülakat vermek', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Bilim İletişimi / Popüler Yayın'], 'puan' => 2],
    '2.10' => ['baslik' => 'Uluslararası indekslenen bilimsel dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 60],
    '2.11' => ['baslik' => 'Ulusal bilimsel dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 30],
    '2.12' => ['baslik' => 'Bilimsel dergide yayın kurulu, bilim kurulu ya da komisyon üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 5],
    '2.13' => ['baslik' => 'Bilimsel dergide hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 3],
    '2.14' => ['baslik' => 'Bilimsel toplantılarda düzenleme kurulu başkanlığı, üyeliği, sekretarya, raportörlük ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Diğer', 'Toplantı Düzenleme Başkanlığı (Uluslararası)', 'Toplantı Düzenleme Başkanlığı (Ulusal)', 'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 3],
    '2.15' => ['baslik' => 'Danışmanı olarak sonuçlandırılmış doktora, sanatta yeterlik ya da tıpta uzmanlık tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman', 'es_danisman'], 'puan' => 20],
    '2.16' => ['baslik' => 'Danışmanı olarak sonuçlandırılmış tezli yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman', 'es_danisman'], 'puan' => 10],
    '2.17' => ['baslik' => 'Lisansüstü tez jüri üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 5],
    '2.18' => ['baslik' => 'Lisansüstü ders vermek (son beş eğitim-öğretim yılı, ders başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
    '2.19' => ['baslik' => 'Ön lisans ya da lisans dersi vermek (son beş eğitim-öğretim yılı, ders başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 2],
    '2.20' => ['baslik' => 'Fakülte dekanlığı, enstitü ya da yüksekokul müdürlüğü (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü'], 'puan' => 15],
    '2.21' => ['baslik' => 'Dekan yardımcılığı, enstitü ya da yüksekokul müdür yardımcılığı (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 10],
    '2.22' => ['baslik' => 'Bölüm başkanlığı (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 10],
    '2.23' => ['baslik' => 'Anabilim ya da bilim dalı başkanlığı, merkez müdürlüğü (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük', 'Bölüm Başkan Yardımcısı', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 5],
    '2.24' => ['baslik' => 'İdari ve sosyal aktiviteler için resmî görevlendirme (her eğitim-öğretim yılı için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 2],
];

$kodlar = fn (string $onek): array => array_values(array_filter(
    array_keys($maddeler),
    fn (string $kod): bool => str_starts_with($kod, $onek)
));

return [
    'kapsam_notu' => 'Puanlar Alanya Alaaddin Keykubat Üniversitesi Akademik Yükseltme ve Atama '
        .'Kriterlerinin Tablo 1a (bilimsel yayınlar), Tablo 1b (mimari ve sanatsal etkinlikler) '
        .'ve Tablo 2 (eğitim-öğretim, idari ve diğer bilimsel faaliyetler) çizelgelerinden. '
        .'Ortak çalışmalarda puan Tablo 3\'ün yazar sayısı × sıra matrisine göre bölünüyor: iki '
        .'isimli eserde birinci yazar tam puan, ikinci %90; üç isimlide %90, %80, %70; on dört '
        .'ve daha fazla isimlide birinci yazar %35\'e kadar iner ve beşinci sıradan sonrası '
        .'%25\'te sabitlenir. Sorumlu yazar sıraya bakılmaksızın en yüksek yüzdeyle '
        .'değerlendiriliyor. Matris yalnız Tablo 1a ve 1b kalemlerine uygulanıyor. Yazar '
        .'listesini boş bırakırsanız çarpan uygulanmaz ve puanınız olduğundan yüksek görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: ESCI dergileri ile ÜAK\'ın kabul '
        .'ettiği uluslararası alan indeksleri yönergede 50 puan alıyor, ama sözlükteki '
        .'etiketler Scopus ve diğer indeksleri de kapsadığı için "diğer indeksler" satırının 25 '
        .'puanı uygulanıyor. Patentte incelemeli tescil (120) incelemesizden (60) ayrılamadığı '
        .'için düşük satır uygulanıyor ve BAŞVURU satırları girilmedi. Spor '
        .'branşlarında görev almak, öğrenci danışmanlıkları, TÜBİTAK panelistliği, altyapı '
        .'projesi ve kitap eleştirisi satırları girilemedi. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünür: "yılda en çok 2 adet" gibi yıl '
        .'başına sınırlar, idari görevlerin "en fazla 5 yıl" hesabı ve derslerin "son beş '
        .'eğitim-öğretim yılı" penceresi uygulanamıyor.',

    // Tablo 3: yazar sayısı × sıra matrisi. Sorumlu yazar sıralamaya
    // bakılmaksızın ilgili kategorideki EN YÜKSEK yüzdeyle değerlendirilir,
    // bu yüzden 'baslica' ile 'ilk' aynı satırı paylaşıyor. Matris yalnız
    // Tablo 1a ve 1b yayınlarına uygulanıyor.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'editorluk', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev',
            'toplumsal_katki', 'diger'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 1.00, 3 => 0.90, 4 => 0.85, 5 => 0.80,
                6 => 0.75, 7 => 0.70, 8 => 0.65, 9 => 0.60, 10 => 0.55, 11 => 0.50, 12 => 0.45,
                13 => 0.40, 14 => 0.35], 'sonrasi' => 0.35],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 1.00, 3 => 0.90, 4 => 0.85, 5 => 0.80,
                6 => 0.75, 7 => 0.70, 8 => 0.65, 9 => 0.60, 10 => 0.55, 11 => 0.50, 12 => 0.45,
                13 => 0.40, 14 => 0.35], 'sonrasi' => 0.35],
            'yazar_2' => ['kademeler' => [2 => 0.90, 3 => 0.80, 4 => 0.75, 5 => 0.70, 6 => 0.65,
                7 => 0.60, 8 => 0.55, 9 => 0.50, 10 => 0.45, 11 => 0.40, 12 => 0.35, 13 => 0.30,
                14 => 0.25], 'sonrasi' => 0.25],
            'yazar_3' => ['kademeler' => [3 => 0.70, 4 => 0.65, 5 => 0.60, 6 => 0.55, 7 => 0.50,
                8 => 0.45, 9 => 0.40, 10 => 0.35, 11 => 0.30], 'sonrasi' => 0.25],
            'yazar_4' => ['kademeler' => [4 => 0.55, 5 => 0.50, 6 => 0.45, 7 => 0.40, 8 => 0.35,
                9 => 0.30], 'sonrasi' => 0.25],
            'yazar_5' => ['kademeler' => [5 => 0.40, 6 => 0.35, 7 => 0.30], 'sonrasi' => 0.25],
            'yazar_6' => ['sonrasi' => 0.25],
            'ortak' => ['kademeler' => [2 => 0.90, 3 => 0.70, 4 => 0.55, 5 => 0.40], 'sonrasi' => 0.25],
        ],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        'TABLO-1A' => $kodlar('1a.'),
        'TABLO-1B' => $kodlar('1b.'),
        'TABLO-2' => $kodlar('2.'),
        // Koşulların atıf yaptığı ARAŞTIRMA MAKALESİ kümeleri. Açıklama 8:
        // derleme, vaka takdimi ve editöre mektup bu koşullarda sayılmaz.
        'SCI-ESCI' => ['1a.1', '1a.2'],
        'ALAN-INDEKS' => ['1a.3'],
        'TR-DIZIN' => ['1a.4'],
        'ARASTIRMA-MAKALE' => ['1a.1', '1a.2', '1a.3', '1a.4', '1a.5'],
    ],

    'grup_tavanlari' => [],
];
