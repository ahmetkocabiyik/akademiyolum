<?php

/**
 * İSTANBUL KÜLTÜR ÜNİVERSİTESİ — EK-1 ÖĞRETİM ÜYESİ PUANLAMA SİSTEMİ
 * Kaynak: pdf/17537099812.istanbulkulturuniversitesi.pdf
 *
 * DOKUZ TEMEL ALAN TABLOSU, PUANLARI NEREDEYSE AYNI. Yönerge her temel alan
 * için ayrı tablo veriyor (TABLO 1-9) ama on iki bölümün puanları tabloların
 * çoğunda birebir aynı. Ayrım koşullarda: her tablo 1. (ya da Hukuk ve Dil'de
 * 2.) bölümüne kendi kadro alt koşulunu ekliyor — bunlar yonerge/ dosyasında.
 *
 * PUAN OLARAK FARKLI OLAN ÜÇ TABLO:
 *   Hukuk           kitap c/d = 20/10 (ortak gövdede 5/3)
 *   Dil Bilimleri   kitap c/d = 20/5
 *   Güzel Sanatlar  "Özel Başvuru Şartları" adında on altı satırlık ek bölüm
 *
 * Bu yüzden dosya dört cetvel döndürüyor: ortak gövde ve üç varyant. Kalan
 * altı alan (Eğitim, Fen, Mimarlık, Mühendislik, Sağlık, Sosyal) ortak gövdeyi
 * paylaşıyor.
 *
 * ── YAZAR PAYI: 1,5 × PUAN / n ──
 * Madde 16: "Çok isimli yayın ve diğer faaliyetlerde puanların hesaplanmasında
 * n isim sayısı olmak üzere 1.5 x Puan / n formülü uygulanır." Tek yazarlı
 * çalışmada formül 1,5 veriyor ama motor çarpanı 1,0'da kesiyor — puanı
 * artıran bir çarpan cetvelin kendi değerini aşardı. İki yazarlıda 0,75, üç
 * yazarlıda 0,5. Yönerge SIRAYA ya da sorumlu yazarlığa hiç bakmıyor; bütün
 * roller aynı formülü paylaşıyor.
 * Madde 11'in dipnotu editörlüğün a ve c bentlerini formülün dışında tutuyor
 * ("kişi sayısına bölünmeden puanlanmaktadır") — editörlük `haric` listesinde.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   6.e   kamu veya özel sektörde yazılım/donanım/süreç proje yöneticiliği —
 *         sözlükte istihdam türü ayrımı yok.
 *   6.g   öğrenci proje ve yarışmalarında danışmanlık (2 puan) — 'Öğrenci
 *         Projesi (2209 vb.)' etiketi 6.f BAP satırına bağlı.
 *   9.d, 9.e  patent BAŞVURUSU (tescil değil) — kayıt bu ayrımı tutmuyor,
 *         tescil satırları girildi.
 *   10.d  öğrenci yarışması danışmanlığında derece.
 *   12.a, 12.b  h-indeksi ve yurt dışı doktora sonrası araştırmacılık: ikisi
 *         de faaliyet satırı değil metrik; koşula değil puana katkı verdikleri
 *         için girilemedi. Toplam puanınız en fazla 10 puan düşük görünür.
 *   Güzel Sanatlar özel bölümünün h (oyunculuk), i (reji), m (dramatik metin)
 *         ve p (sahne tasarımı) bentleri sözlükte karşılıksız.
 *
 * Yönerge: yonerge/istanbul-kultur.php
 *
 * KODLAR BİZE AİT — KAYNAKTA SATIR KODU YOK. Cetvel kodlarının SAYISAL
 * ÇEKİRDEĞİ kaynağın madde/bölüm numarasıdır; baştaki harf tabloyu ya da
 * eki, sondaki harf şıkkı gösterir ve ikisi de bizim eklediğimiz parçadır.
 * Koşullar bu kodlara atıf yaptığı için değiştirilmemeli; kaynakla
 * karşılaştırırken kodun sayısal çekirdeğine bakılmalı.
 */
$kapsamNotu = 'Puanlar İstanbul Kültür Üniversitesi EK-1 Puanlama Sisteminden. '
    .'Çok yazarlı çalışmalarda yönerge "1,5 × puan / yazar sayısı" formülünü uyguluyor '
    .'(iki yazarlıda puanın %75\'i, üç yazarlıda %50\'si); tek yazarlı çalışmada formül '
    .'puanı artırırdı, motor çarpanı 1,0\'da kestiği için tam puan verilir. Bu bölme yalnızca '
    .'yazar listesini doldurduğunuzda uygulanabiliyor; liste boşsa çarpan uygulanmaz ve '
    .'puanınız olduğundan yüksek görünür. Yönerge sıraya ya da sorumlu yazarlığa bakmıyor. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: h-indeksi ve yurt dışı doktora sonrası '
    .'araştırmacılık (12. madde, en fazla 10 puan) faaliyet satırı olmadığı için hesaba '
    .'katılamadı; patent başvuruları, öğrenci proje danışmanlığı ve kamu/özel sektör proje '
    .'yöneticiliği kaynakta ayrılamadığı için girilmedi.';

// ── ORTAK GÖVDE (TABLO 1'in değerleri) ──────────────────────────────────────
$maddeler = [
    // ══ 1. ULUSLARARASI MAKALE ══
    '1.a.Q1' => ['baslik' => 'SCI, SSCI, SCI-Expanded veya AHCI kapsamındaki Q1 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'puan' => 30],
    '1.a.Q2' => ['baslik' => 'SCI, SSCI, SCI-Expanded veya AHCI kapsamındaki Q2 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'puan' => 20],
    '1.a.Q3' => ['baslik' => 'SCI, SSCI, SCI-Expanded veya AHCI kapsamındaki Q3 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'puan' => 15],
    '1.a.Q4' => ['baslik' => 'SCI, SSCI, SCI-Expanded veya AHCI kapsamındaki Q4 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'puan' => 10],
    '1.b' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 10],
    '1.c' => ['baslik' => 'Diğer uluslararası indekslerde taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'puan' => 5],
    // 1.d yalnızca 1.a-1.c dergilerindeki kısa yayınlar; kaynak ayrımı
    // olmadığı için tür ile sınırlandı.
    '1.d' => ['baslik' => 'Uluslararası indeksli dergide editöre mektup, araştırma notu, özet veya kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI', 'ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 3],

    // ══ 2. ULUSAL MAKALE ══
    '2.a' => ['baslik' => 'TR Dizin kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 10],
    '2.b' => ['baslik' => 'Diğer hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 4],
    '2.c' => ['baslik' => 'Diğer hakemli dergide editöre mektup, araştırma notu veya kitap incelemesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 2],

    // ══ 3. KİTAP ══
    '3.a' => ['baslik' => 'BKCI kapsamındaki kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
    '3.b' => ['baslik' => 'BKCI kapsamındaki kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 10],
    '3.c' => ['baslik' => 'Diğer uluslararası veya ulusal kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Çeviri Kitap'], 'puan' => 5],
    '3.d' => ['baslik' => 'Diğer uluslararası veya ulusal kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Çeviri Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 3],

    // ══ 4. ATIF ══ (bölüm tavanı 10)
    '4.a' => ['baslik' => 'SCIE, SSCI, AHCI, ESCI veya Scopus kapsamında eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
    '4.b' => ['baslik' => 'BKCI kapsamındaki kitapta eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
    '4.c' => ['baslik' => 'TR Dizin kapsamındaki dergide eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
    '4.d' => ['baslik' => 'Diğer uluslararası veya ulusal kaynakta eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],

    // ══ 5. LİSANSÜSTÜ TEZ DANIŞMANLIĞI ══ (bölüm tavanı 20)
    // "İkinci/eş danışman … yarısını alır" — eş danışman satırı ayrı.
    '5.a' => ['baslik' => 'Danışmanlığında tamamlanmış doktora tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 6],
    '5.a.es' => ['baslik' => 'Eş danışmanlığında tamamlanmış doktora tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 3],
    '5.b' => ['baslik' => 'Danışmanlığında tamamlanmış yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 4],
    '5.b.es' => ['baslik' => 'Eş danışmanlığında tamamlanmış yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 2],

    // ══ 6. BİLİMSEL ARAŞTIRMA PROJESİ ══
    '6.a.y' => ['baslik' => 'AB Çerçeve Programı projesinde koordinatör veya yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 30],
    '6.a.a' => ['baslik' => 'AB Çerçeve Programı projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci'], 'puan' => 20],
    '6.a.d' => ['baslik' => 'AB Çerçeve Programı projesinde bursiyer veya danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 10],
    '6.b.y' => ['baslik' => 'TÜBİTAK veya bakanlık projesinde koordinatör ya da yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 15],
    '6.b.a' => ['baslik' => 'TÜBİTAK veya bakanlık projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci'], 'puan' => 10],
    '6.b.d' => ['baslik' => 'TÜBİTAK veya bakanlık projesinde bursiyer ya da danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 5],
    '6.c.y' => ['baslik' => 'Diğer uluslararası destekli projede koordinatör ya da yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 15],
    '6.c.a' => ['baslik' => 'Diğer uluslararası destekli projede araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci'], 'puan' => 10],
    '6.c.d' => ['baslik' => 'Diğer uluslararası destekli projede bursiyer ya da danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 5],
    '6.d' => ['baslik' => 'Diğer ulusal destekli Ar-Ge projesinde koordinatör ya da yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 6],
    // 6.f bölüm tavanı 6 puan.
    '6.f' => ['baslik' => 'Üniversite BAP projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 3],

    // ══ 7. BİLİMSEL TOPLANTI ══ (bölüm tavanı 20)
    '7.a.tam' => ['baslik' => 'Uluslararası toplantıda CPCI\'da yayımlanmış tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 6],
    '7.a.ozet' => ['baslik' => 'Uluslararası toplantıda CPCI\'da yayımlanmış özet metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 4],
    '7.b.tam' => ['baslik' => 'Diğer uluslararası veya ulusal toplantıda tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Ulusal Tam Metin'], 'puan' => 3],
    '7.b.ozet' => ['baslik' => 'Diğer uluslararası veya ulusal toplantıda özet metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster', 'Ulusal Özet/Poster'], 'puan' => 2],

    // ══ 8. EĞİTİM-ÖĞRETİM ══ (bölüm tavanı 15)
    '8.a' => ['baslik' => 'Önlisans, lisans veya lisansüstü seviyesinde verilen her bir ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 3],

    // ══ 9. PATENT / FAYDALI MODEL ══
    '9.a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent', 'Ticarileştirme'], 'puan' => 30],
    '9.b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 20],
    '9.c' => ['baslik' => 'Tescil edilmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 10],

    // ══ 10. ÖDÜL ══ (b ve c bentlerinin ortak tavanı 15)
    '10.a' => ['baslik' => 'YÖK, TÜBA veya TÜBİTAK ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 30],
    '10.b' => ['baslik' => 'Uluslararası bilim, sanat veya tasarım ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 10],
    '10.c' => ['baslik' => 'Ulusal bilim, sanat veya tasarım ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'Yarışma Derecesi / Mansiyon', 'Burs'], 'puan' => 5],

    // ══ 11. EDİTÖRLÜK ══ (bölüm tavanı 4)
    '11.a' => ['baslik' => 'SCIE, SSCI, AHCI, ESCI veya Scopus kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi', 'Yayın Kurulu Üyeliği', 'Hakemlik'], 'puan' => 2],
    '11.b' => ['baslik' => 'BKCI veya Scopus kapsamındaki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Kitap Editörlüğü'], 'puan' => 1],
    '11.c' => ['baslik' => 'TR Dizin kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 1],
];

// ── GÜZEL SANATLAR — "Özel Başvuru Şartları" bölümü ─────────────────────────
$ozelSanat = [
    'S.a' => ['baslik' => 'En az 15 özgün eser barındıran kişisel sergi açmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Ulusal)'], 'puan' => 20],
    'S.b' => ['baslik' => 'Festivale seçilen filmin yönetmenliğini yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Yönetmenlik (Sahne/Ekran)', 'Belgesel/Kısa Film (Uluslararası)'], 'puan' => 20],
    'S.c' => ['baslik' => 'Festivale seçilen filmin görüntü yönetmenliğini yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Ulusal)'], 'puan' => 10],
    'S.d' => ['baslik' => 'Uluslararası veya ulusal karma etkinlikte eserinizle yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Ulusal)'], 'puan' => 5],
    'S.e' => ['baslik' => 'Sanatsal etkinlikte gösterimi yapılmış filmin ekibinde yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'], 'puan' => 5],
    // f bölüm tavanı 10.
    'S.f' => ['baslik' => 'Reklam, tanıtım filmi veya müzik klibi yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Albüm / Konser Kaydı', 'Karma Albüm / CD-DVD Katkısı'], 'puan' => 5],
    // g bölüm tavanı 10.
    'S.g' => ['baslik' => 'Oyun, film veya sahne gösterisinde dramatik tasarım ya da danışmanlık görevi almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne Tasarımı (Dekor, Kostüm, Işık)', 'Koreografi'], 'puan' => 10],
    // j, k, l ortak tavanı 10.
    'S.j' => ['baslik' => 'Atölye çalışması yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 5],
    'S.k' => ['baslik' => 'Tiyatro topluluğu çalıştırmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra / Koro Üyeliği'], 'puan' => 5],
    'S.l' => ['baslik' => 'Rejisör yardımcılığı yapmış olmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisör Yardımcılığı (Uluslararası)', 'Rejisör Yardımcılığı (Ulusal)', 'Rejisör Yardımcılığı (Konservatuvar)'], 'puan' => 5],
    // n, o ortak tavanı 10.
    'S.o' => ['baslik' => 'Yayımlanmış senaryo incelemesi, eleştiri veya tanıtım yazısı yazmak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Bilim İletişimi / Popüler Yayın', 'Topluma Hizmet Projesi', 'Kamu/STK Danışmanlığı'], 'puan' => 5],
];

$gruplar = [
    // Koşulların bent harfleriyle andığı kümeler.
    '1' => ['1.*'],
    '1.a' => ['1.a.Q1', '1.a.Q2', '1.a.Q3', '1.a.Q4'],
    '1.a-b' => ['1.a.Q1', '1.a.Q2', '1.a.Q3', '1.a.Q4', '1.b'],
    '1.a-c' => ['1.a.Q1', '1.a.Q2', '1.a.Q3', '1.a.Q4', '1.b', '1.c'],
    '2.a' => ['2.a'],
    // Bölüm tavanları.
    '3.c-d' => ['3.c', '3.d'],
    '4' => ['4.*'],
    '5' => ['5.*'],
    '6.f' => ['6.f'],
    '7' => ['7.*'],
    '8' => ['8.*'],
    '10.b-c' => ['10.b', '10.c'],
    '11' => ['11.*'],
];

$tavanlar = [
    '3.c-d' => 5,
    '4' => 10,
    '5' => 20,
    '6.f' => 6,
    '7' => 20,
    '8' => 15,
    '10.b-c' => 15,
    '11' => 4,
];

// Madde 16 — "1.5 x Puan / n". Motor çarpanı 1,0'da kesiyor, bu yüzden tek
// yazarlı çalışma tam puan alıyor (formülün 1,5'i cetvelin değerini aşardı).
// Yönerge sıraya bakmıyor; bütün roller aynı formülü paylaşıyor.
$bol = ['bol' => ['pay' => 1.5]];

$yazarKatsayisi = [
    // Madde 11 dipnotu: editörlüğün a ve c bentleri "kişi sayısına bölünmeden
    // puanlanmaktadır". Atıf, ders, tez ve idari kalemler zaten tek kişilik.
    'haric' => ['atif', 'editorluk', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev'],
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.0]],
        'ilk' => $bol,
        'baslica' => $bol,
        'yazar_2' => $bol,
        'yazar_3' => $bol,
        'yazar_4' => $bol,
        'yazar_5' => $bol,
        'yazar_6' => $bol,
        'ortak' => $bol,
    ],
];

/**
 * @param  array<string, array<string, mixed>>  $fark
 * @param  array<string, array<string, mixed>>  $ek
 * @return array<string, mixed>
 */
$cetvel = function (string $notEki, array $fark = [], array $ek = [], array $ekGrup = [], array $ekTavan = []) use ($kapsamNotu, $maddeler, $gruplar, $tavanlar, $yazarKatsayisi): array {
    foreach ($fark as $kod => $degisiklik) {
        $maddeler[$kod] = array_replace($maddeler[$kod] ?? [], $degisiklik);
    }

    return [
        'kapsam_notu' => $kapsamNotu.$notEki,
        'yazar_katsayisi' => $yazarKatsayisi,
        'maddeler' => $maddeler + $ek,
        'gruplar' => $gruplar + $ekGrup,
        'grup_tavanlari' => $tavanlar + $ekTavan,
    ];
};

return ['cetveller' => [
    // Eğitim, Fen, Mimarlık, Mühendislik, Sağlık ve Sosyal aynı gövdeyi paylaşır.
    'istanbul-kultur-2024' => $cetvel(''),

    // Hukuk: kitap c/d bentleri 5/3 yerine 20/10.
    'istanbul-kultur-2024-hukuk' => $cetvel(
        ' Hukuk tablosunda kitap ve kitap bölümü puanları diğer alanların dört katı '
        .'(20 ve 10 puan).',
        ['3.c' => ['puan' => 20], '3.d' => ['puan' => 10]],
    ),

    // Dil Bilimleri: kitap c/d bentleri 20/5.
    'istanbul-kultur-2024-dil' => $cetvel(
        ' Dil Bilimleri tablosunda kitap puanı diğer alanların dört katı (20 puan), '
        .'kitap bölümü ise 5 puan.',
        ['3.c' => ['puan' => 20], '3.d' => ['puan' => 5]],
    ),

    // Güzel Sanatlar: "Özel Başvuru Şartları" bölümü eklenir.
    'istanbul-kultur-2024-guzel-sanatlar' => $cetvel(
        ' Güzel Sanatlar tablosunda ayrıca "Özel Başvuru Şartları" bölümü sayılıyor: sergi, '
        .'film, sahne ve atölye çalışmaları. O bölümün oyunculuk, reji, dramatik metin ve '
        .'sahne tasarımı bentleri kaynakta karşılıksız olduğu için girilemedi.',
        [],
        $ozelSanat,
        ['S' => ['S.*'], 'S.j-l' => ['S.j', 'S.k', 'S.l'], 'S.f' => ['S.f'], 'S.g' => ['S.g'], 'S.o' => ['S.o']],
        ['S.j-l' => 10, 'S.f' => 10, 'S.g' => 10, 'S.o' => 10],
    ),
]];
