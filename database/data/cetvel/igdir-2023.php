<?php

/**
 * IĞDIR ÜNİVERSİTESİ — EK-1: Akademik Etkinlik Değerlendirme Tablosu
 * Kaynak: pdf/17536996342.igdiruniverstesi.pdf
 * Senato: 05.11.2020 / 2020.42.196 · 24.11.2020 / 2020.45.208 ·
 *         25.04.2023 / 2023.20.63 (Değişik) — YÖK 18.05.2023 / 24269
 *
 * MADDE KODLARI yönergenin kendi numaraları (1-27) ve şık harfleri. Koşullar
 * tabloya numara aralığıyla atıf yapıyor ("6 ve 7. maddelerden en az 1000
 * puan", "20-23. maddelerinden en az 500 puan"), kodlar bu yüzden birebir
 * korundu.
 *
 * KENDİ ÜRETTİĞİMİZ ALT KODLAR:
 *   `1.a.1` / `1.a.2` — yönergede tek satır (100 puan) ama koşullar "en az 1
 *       adedi Q1/Q2 olmak üzere" diyor. Puan aynı, yalnızca SAYI koşulu
 *       çeyrekliğe bakabilsin diye ikiye bölündü.
 *   `26.a.p` / `26.b.p` — 26. madde ödül ile patenti aynı satırda ve aynı
 *       puanda topluyor ("ödül veya patent almak"); iki ayrı kategori tek
 *       kodda duramadığı için patent tarafı ayrı satır.
 *
 * ── AYNI KAYNAĞA DÜŞEN İKİ SATIRDA DAİMA DÜŞÜĞÜ GİRİLDİ ──
 *   Editörlük 13.a (150) / 14.a (100) / 15.a (80) / 16.a (50): sözlük derginin
 *       indeksini yalnızca WoS ve ESCI düzeyinde ayırıyor. WoS → 13.a,
 *       ESCI/Scopus → 14.a; 'TR Dizin Dergi' ve 'Diğer Hakemli Dergi'
 *       ayrılamadığı için ikisi de en düşük satıra (16.a) kondu.
 *   Yayın kurulu üyeliği 13.c (50) / 14.c (40) / 15.c (30) / 16.c (25) → 25.
 *   Hakemlik 13.d (25) / 14.d (20) / 15.d (15) / 16.d (10) → 10.
 *   Kongrede görev 24.b (50, uluslararası) / 25.b (25, ulusal) → 25.
 *   Burs 27.a (150, uluslararası) / 27.b (100, kamu) → 100.
 *   Ödül ve patentte uluslararası (26.a, 350) ile ulusalın (26.b, 300) ayrımı
 *       yalnızca etiketten okunabilen yerlerde yapıldı; yarışma derecesi gibi
 *       ayrılamayan kalemler 26.b'ye kondu.
 *
 * ── GİRİLMEYEN KALEMLER (kaynak sözlüğünde karşılığı yok) ──
 *   5           ulusal HAKEMSİZ dergi/gazete yazısı — sözlükteki 'Diğer Ulusal
 *               Hakemli' hakemli olduğunu söylüyor, 4. maddeye gitti.
 *   13.b, 14.b, editör YARDIMCILIĞI — sözlükte editörlük ile yardımcılığı
 *   15.b, 16.b  ayıran etiket yok.
 *   18.c, 19.a  "diğer uluslararası dergilerdeki atıf" ve "ulusal referans
 *               kitabındaki atıf" — atıf sözlüğü bu iki kaynağı ayırmıyor.
 *   21.c        tezsiz yüksek lisans danışmanlığı.
 *   24.a, 25.a  sempozyum/kongre BAŞKANLIĞI — sözlükte yalnızca kurul üyeliği
 *               var, başkanlık ayrılamıyor.
 *   Eş danışmanlık, tez izleme jürisi, akreditasyon faaliyeti, ders/metot
 *   kitabı, ansiklopedi maddesi, tahkik, endüstriyel tasarım, faydalı model,
 *   yazılım, ıslahçı hakkı, ticarileştirme, özel sektör projesi ve etkinlikten
 *   bağımsız "özgün eser/beste/tasarım" kaydı: EK-1'de karşılık satırı yok.
 *
 * ── SAYI SINIRLARI SABİT TAVANA ÇEVRİLDİ ──
 *   10.b "sadece 1 bölüm dikkate alınır"      → 100
 *   11.b "en fazla 2 bölüm"                   → 50
 *   12.b "en fazla 2 bölüm"                   → 30
 *   17   "Kitap editörlüğü (4)" başlıktaki (4) en fazla dört kitap diye
 *        okundu → 4 × 150 = 600. Yönerge sayıyı açıklamıyor; tavan koymak
 *        koymamaktan güvenli taraf.
 *   20   "son beş yılda, her yarıyılda en fazla dört ders" — hem pencere hem
 *        yarıyıl başına sayı gerektiriyor, motorda karşılığı yok. Ders puanı
 *        olduğundan YÜKSEK görünebilir.
 *
 * ── UYGULANAMAYAN KURALLAR ──
 *   22-23 "tamamlanmış" ve "üniversitenin altyapısına destek veren" nitelikleri
 *   faaliyet kaydında yok; devam eden proje de puan alır, puan YÜKSEK görünür.
 *   EK Madde 2'nin bir defalık 15 puanı (belirli bir dersi tamamlamak) girilmedi.
 *
 * Yönerge: yonerge/igdir.php
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 */

return [
    'kapsam_notu' => 'Puanlar Iğdır Üniversitesi Akademik Etkinlik Değerlendirme Tablosu (EK-1) '
        .'kalemlerinden. Çok yazarlı yayınlarda puan yönergenin yazar tablosuna göre azaltılır; '
        .'çarpan hem yazar sayısına hem sıranıza bağlı olduğu için faaliyetinizde kaçıncı yazar '
        .'olduğunuzu seçmeniz gerekir. Sırayı belirtmezseniz o yazar sayısındaki en düşük çarpan '
        .'uygulanır; yazar listesini boş bırakırsanız çarpan hiç uygulanmaz ve puanınız '
        .'olduğundan yüksek görünür. Çarpan yalnızca makale, sanat etkinliği, bildiri ve kitap '
        .'kalemlerinde işler — yönerge çarpanı bu kalemlerle sınırlıyor. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: editör yardımcılığı, sempozyum '
        .'başkanlığı, tezsiz yüksek lisans danışmanlığı, eş danışmanlık ve hakemsiz ulusal '
        .'yazılar kaynakta ayrılamadığı için girilmedi; dergi editörlüğü, yayın kurulu üyeliği ve '
        .'hakemlikte derginin indeksi ayrılamayan yerlerde en düşük satır alındı. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünebilir: yönerge ders puanını "son beş '
        .'yılda, her yarıyıl en fazla dört ders" diye sınırlıyor, bu sınır uygulanmıyor; proje '
        .'kalemlerinde "tamamlanmış" ve "üniversitenin altyapısına destek veren" koşulları '
        .'denetlenemiyor, devam eden projeniz de puan alır.',

    // Genel İlkeler: "(1-12) maddelerindeki ikiden çok yazarlı yayınlarda
    // adayların puanı (%) olarak aşağıdaki şekilde hesaplanır."
    //
    //   sıra \ sayı   1.isim 2.isim 3.isim 4.isim 5.isim
    //   tek yazarlı    100
    //   2 yazarlı       90     80
    //   3 yazarlı       80     70     60
    //   4 yazarlı       70     60     50     40
    //   5 yazarlı       60     50     40     30     30
    //
    // 6 ve daha fazla yazarlı: ilk isim = Puan × 1,2 / yazar sayısı;
    // diğerleri = (Puan − ilk ismin puanı) / diğer yazar sayısı.
    //
    // İlk isim formülü motorun `bol` alanına birebir giriyor (pay 1,2).
    // Diğer yazarların formülü girmiyor: (1 − 1,2/n) / (n − 1). Yerine
    // 0,8 / (n − 1) yazıldı — altı yazarlıda İKİSİ DE 0,16 veriyor, daha
    // kalabalık yayınlarda bizimki bir tık düşük kalıyor. Sapma adayın
    // puanını fazla göstermeyen yönde.
    //
    // "Bir makalenin sorumlu yazarı (corresponding author) 1. isimle aynı
    // şekilde değerlendirilir" — `baslica` bu yüzden `ilk` ile aynı satırda.
    'yazar_katsayisi' => [
        // Çarpan yalnızca 1-12. maddelere ait: makale, sanat etkinliği,
        // bildiri ve kitap. 13'ten sonrası (editörlük, atıf, ders, tez, proje,
        // organizasyon, ödül, burs) çarpanın dışında.
        'haric' => ['atif', 'proje', 'patent', 'editorluk', 'odul', 'egitim_ogretim',
            'tez_danismanligi', 'idari_gorev', 'toplumsal_katki'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.0]],
            'ilk' => ['kademeler' => [1 => 1.0, 2 => 0.90, 3 => 0.80, 4 => 0.70, 5 => 0.60], 'bol' => ['pay' => 1.2]],
            'baslica' => ['kademeler' => [1 => 1.0, 2 => 0.90, 3 => 0.80, 4 => 0.70, 5 => 0.60], 'bol' => ['pay' => 1.2]],
            'yazar_2' => ['kademeler' => [2 => 0.80, 3 => 0.70, 4 => 0.60, 5 => 0.50], 'bol' => ['pay' => 0.8, 'eksi' => 1]],
            'yazar_3' => ['kademeler' => [3 => 0.60, 4 => 0.50, 5 => 0.40], 'bol' => ['pay' => 0.8, 'eksi' => 1]],
            'yazar_4' => ['kademeler' => [4 => 0.40, 5 => 0.30], 'bol' => ['pay' => 0.8, 'eksi' => 1]],
            'yazar_5' => ['kademeler' => [5 => 0.30], 'bol' => ['pay' => 0.8, 'eksi' => 1]],
            'yazar_6' => ['bol' => ['pay' => 0.8, 'eksi' => 1]],
            'ortak' => ['kademeler' => [1 => 1.0, 2 => 0.80, 3 => 0.60, 4 => 0.40, 5 => 0.30], 'bol' => ['pay' => 0.8, 'eksi' => 1]],
        ],
    ],

    'maddeler' => [
        // ══ 1. YAYIN ve SUNUM ETKİNLİKLERİ · A. MAKALELER ══
        '1.a.1' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI kapsamındaki Q1-Q2 dergide özgün araştırma, makale veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 100],
        '1.a.2' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI kapsamındaki dergide özgün araştırma, makale veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 100],
        '1.b' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI kapsamındaki dergide editöre mektup, teknik not, tartışma, vaka takdimi veya özet', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 65],
        '2.a' => ['baslik' => 'Uluslararası indeksli hakemli dergide özgün araştırma, makale veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 80],
        '2.b' => ['baslik' => 'Uluslararası indeksli hakemli dergide editöre mektup, teknik not, tartışma, vaka takdimi veya özet', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 45],
        '3.a' => ['baslik' => 'Diğer uluslararası hakemli dergide özgün araştırma, makale veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 70],
        '3.b' => ['baslik' => 'Diğer uluslararası hakemli dergide teknik not, editöre mektup, tartışma, vaka takdimi veya özet', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 40],
        '4.a' => ['baslik' => 'Ulusal hakemli bilimsel dergide özgün araştırma, makale veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 65],
        '4.b' => ['baslik' => 'Ulusal hakemli bilimsel dergide teknik not, editöre mektup, tartışma, vaka takdimi veya özet', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 35],

        // ══ B. SANAT DALLARINDAKİ ETKİNLİKLER ══
        '6.a' => ['baslik' => 'Özgün sanat yapıtının yurt dışındaki kurumlarca satın alınması, yayın organlarında yer alması veya tasarım projesinin yurt dışında uygulanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Müzeye Kabulü (Yurt Dışı)', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)'], 'puan' => 150],
        '6.b' => ['baslik' => 'Yurt dışında kişisel sanat veya tasarım etkinliği, gösterim, dinleti', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)'], 'puan' => 100],
        '6.c' => ['baslik' => 'Yurt dışında jürili karma sanat veya tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)'], 'puan' => 50],
        '7.a' => ['baslik' => 'Özgün sanat yapıtının yurt içindeki kurumlarca satın alınması, yayın organlarında yer alması veya tasarım projesinin yurt içinde uygulanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Satın Alınması (Yurt İçi)', 'Eserin Müzeye Kabulü (Yurt İçi)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'], 'puan' => 100],
        '7.b' => ['baslik' => 'Ulusal düzeyde kişisel sanat veya tasarım etkinliği, gösterim, dinleti', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)'], 'puan' => 50],
        '7.c' => ['baslik' => 'Ulusal düzeyde jürili karma sanat veya tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)'], 'puan' => 25],

        // ══ C. KONGRE SUNULARI ══
        '8.a' => ['baslik' => 'Uluslararası bilimsel toplantıda indeksli dergi özel sayısı veya kongre kitabında yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 60],
        '8.b' => ['baslik' => 'Uluslararası kongre kitapçığında tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin'], 'puan' => 55],
        '8.c' => ['baslik' => 'Uluslararası toplantıda özet bildiri, poster veya gösteri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster', 'Davetli Konuşmacı'], 'puan' => 35],
        '9.a' => ['baslik' => 'Ulusal bilimsel toplantıda tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 30],
        '9.b' => ['baslik' => 'Ulusal bilimsel toplantıda özet bildiri, poster veya gösteri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 20],

        // ══ D. ALANINDA KİTAP YAZARLIĞI ══
        '10.a' => ['baslik' => 'Yurt dışında uluslararası yayınevinde basılmış kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 150],
        '10.b' => ['baslik' => 'Yurt dışında uluslararası yayınevinde basılmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 100],
        '11.a' => ['baslik' => 'Alanıyla ilgili ulusal nitelikte kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 100],
        '11.b' => ['baslik' => 'Türkçe yazılan bir kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 25],
        '12.a' => ['baslik' => 'Referans kitaplarından birinin çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 50],
        '12.b' => ['baslik' => 'Çevirisi yapılan bir kitabın bir bölümünün çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 15],

        // ══ E. EDİTÖRLÜK ve HAKEMLİKLER ══
        '13.a' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI kapsamındaki dergide editörlük (her yıl için)', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 150],
        '14.a' => ['baslik' => 'Uluslararası indeksli hakemli dergide editörlük (her yıl için)', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 100],
        '16.a' => ['baslik' => 'Ulusal hakemli bilimsel dergide editörlük (her yıl için)', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 50],
        '16.c' => ['baslik' => 'Derginin yayın veya bilimsel kurulunda yer almak (her yıl için)', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 25],
        '16.d' => ['baslik' => 'Dergide hakemlik yapmak (her yıl için)', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 10],
        '17.a' => ['baslik' => 'Alanında yurt dışında yayımlanan kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 150],
        '17.b' => ['baslik' => 'Alanında yurt içinde yayımlanan kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 100],

        // ══ F. ATIFLAR ══
        '18.a' => ['baslik' => 'Uluslararası kaynak kitaplardaki atıflar', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 20],
        '18.b' => ['baslik' => 'SCI, SSCI ve AHCI tarafından taranan dergilerdeki atıflar', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 10],
        '19.b' => ['baslik' => 'Ulusal hakemli bilimsel dergilerdeki atıflar', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer'], 'puan' => 3],

        // ══ II. EĞİTİM-ÖĞRETİM · G. ÖĞRETİM ETKİNLİKLERİ ══
        '20.a' => ['baslik' => 'Lisansüstü ders (son beş yılda, her yarıyıl en fazla dört ders)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 5],
        '20.b' => ['baslik' => 'Ön lisans veya lisans dersi (son beş yılda, her yarıyıl en fazla dört ders)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 3],
        '21.a' => ['baslik' => 'Yönetiminde tamamlanmış doktora veya tıpta uzmanlık tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 40],
        '21.b' => ['baslik' => 'Yönetiminde tamamlanmış tezli yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 20],

        // ══ H. BİLİMSEL ARAŞTIRMA ETKİNLİKLERİ ══
        '22.a' => ['baslik' => 'Yurt dışı kaynaklı uluslararası projeyi yürütmek', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 250],
        '22.b' => ['baslik' => 'Ulusal kuruluşlarca (TÜBİTAK, DPT, TÜBA, TEKNOFEST vb.) desteklenen projeyi yürütmek', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 150],
        '22.c' => ['baslik' => 'Üniversite tarafından desteklenen projeyi yürütmek', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 50],
        '23.a' => ['baslik' => 'Yurt dışı kaynaklı uluslararası projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 150],
        '23.b' => ['baslik' => 'Ulusal kuruluşlarca desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 100],
        '23.c' => ['baslik' => 'Üniversite tarafından desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 50],

        // ══ I. DİĞER BİLİMSEL VE SANATSAL ETKİNLİKLER ══
        '25.b' => ['baslik' => 'Sempozyum, kongre, çalıştay, sanat sergisi veya festival düzenlemesinde bilimsel komite ya da organizasyon kurulu üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 25],
        '25.bk' => ['baslik' => 'Sempozyum, kongre ya da çalıştay düzenlemesinde bilimsel komite veya organizasyon kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 25],

        // ══ J. ÖDÜLLER ve BURSLAR ══
        '26.a' => ['baslik' => 'Jürili uluslararası bilim veya sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 350],
        '26.a.p' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 350],
        // 'Yarışma Derecesi / Mansiyon' 01.09.2026'da çıkarıldı: 26. madde ödülü
        // "(TÜBİTAK/TÜBA vb.)" parantezyle bu sınıfa bağlıyor, tek seferlik bir
        // yarışma derecesi ya da mansiyon 300 puanlık bu satıra girmiyor. Kriter
        // listesinde daha düşük bir ödül satırı yok; yarışma dereceniz sayılmıyor.
        '26.b' => ['baslik' => 'Ulusal bilim (TÜBİTAK, TÜBA vb.) veya sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü', 'Ulusal Bilim/Sanat Ödülü'], 'puan' => 300],
        '26.b.p' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 300],
        '27.b' => ['baslik' => 'Bilimsel veya sanatsal çalışma için alınan burs', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 100],
    ],

    'gruplar' => [
        // Koşulların birebir andığı numara aralıkları.
        // NOKTA ZORUNLU: '2*' deseni 20-27 arasını da yakalardı.
        '6-7' => ['6.*', '7.*'],
        '20-23' => ['20.*', '21.*', '22.*', '23.*'],
        '22-23' => ['22.*', '23.*'],

        // Koşulların adıyla andığı yayın kümeleri.
        'Q1_Q2' => ['1.a.1'],
        'SCI_MAKALE' => ['1.a.1', '1.a.2'],
        'HAKEMLI_MAKALE' => ['1.a.1', '1.a.2', '2.a', '3.a', '4.a'],
        'KITAP' => ['10.a', '11.a'],
        'KITAP_BOLUM' => ['10.b', '11.b'],
        'BILDIRI' => ['8.*', '9.*'],

        // Yalnızca tavan taşıyan kümeler.
        'KITAP_EDITORLUGU' => ['17.*'],
    ],

    'grup_tavanlari' => [
        // Yönergenin kendi sayı sınırlarının puan karşılığı.
        '10.b' => 100,
        '11.b' => 50,
        '12.b' => 30,
        'KITAP_EDITORLUGU' => 600,
    ],
];
