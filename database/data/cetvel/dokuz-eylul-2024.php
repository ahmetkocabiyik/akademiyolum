<?php

/**
 * DOKUZ EYLÜL ÜNİVERSİTESİ — EK: Akademik Atamalarda Dikkate Alınacak
 * Puanlama Sistemi (Puanlandırma Formu)
 * Kaynak: pdf/17536992732.dokuzeyluluniverstesi.pdf
 *
 * ZORUNLU PUAN / TOPLAM PUAN AYRIMI. Yönerge iki ayrı toplam istiyor: alanın
 * "zorunlu puan maddeleri"nden bir baraj, tablonun tamamından ayrı bir baraj.
 * Zorunlu puan madde kümesi alana göre değişiyor (Madde 1.10.1/c) ve altı
 * grup hâlinde tanımlı; kümeler `gruplar` altında ZORUNLU-* adlarıyla duruyor.
 *
 * MADDE KODLARI yönergenin kendi numaraları. Koşullar tabloya numarayla atıf
 * yapıyor ("B. Girişimcilik-Yenilikçilik bölümünden 15 puanlık etkinlik",
 * "Madde 8.a., Madde 8.b."), kodlar bu yüzden birebir korundu.
 *
 * ── KENDİ ÜRETTİĞİMİZ ALT KODLAR ──
 *   `8.*.a`  proje satırları puanı iki role bölüyor ("koordinatör veya
 *       yöneticisi 20 puan, proje araştırmacısı veya danışmanı 15 puan");
 *       motor kod başına tek puan tuttuğu için araştırmacı payı ayrı satır.
 *   `9.*.a`  editörlük satırlarında yardımcı editör payı ayrı satır.
 *   `11.a`-`11.c`  yönergenin kendi harflendirmesi, uluslararası/ulusal
 *       ayrımı için `.1`/`.2` eklendi.
 *
 * ── AYNI KAYNAĞA DÜŞEN İKİ SATIRDA DAİMA DÜŞÜĞÜ GİRİLDİ ──
 *   Bildiri 7.a.1 sözlü (10) / poster (7) → poster satırı ayrı girildi;
 *       sözlü-poster ayrımı sözlükte var, ikisi de yazıldı.
 *   Patent 11.a bireysel (100/50) / 11.b grup (40/30): kayıt patentin
 *       bireysel mi grup mu olduğunu söylemiyor → GRUP satırı alındı.
 *   Editörlük 9.f alan endeksi (25) / 9.g ULAKBİM (25) / 9.h ulusal (20):
 *       'Diğer Hakemli Dergi' ayrılamadığı için 9.h.
 *   Hakemlik 10.b (5) / 10.c (4) / 10.d (4) / 10.e (3) → 10.e.
 *   Yayın kurulu 9.i (25) / 9.j (15) → 9.j.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   7.c sivil toplum kuruluşu etkinliğinde davetli konuşmacılık ·
 *   10.f-10.g proje değerlendirme ve izleyiciliği · 12-13 teknopark firması ·
 *   14 meslek odası görevi (formül: 4 × 2 × yıl) · 15 girişimcilik dersi ve
 *   sertifikası · 16 değişim programı · 17 bilim köprüsü · 19.b-19.c SAN-TEZ
 *   ve ticarileşen tezler · 19.e-19.f tezsiz yüksek lisans ve lisans bitirme
 *   projeleri · 20 öğrenci geri bildirimi · 21 ders yükü dışı ders (formül:
 *   kredi başına 1 puan) · 23 animasyon eğitim materyali. Hepsinin ortak
 *   sebebi: kaynak sözlüğünde ayırt edici etiket yok ya da kalem formüllü.
 *
 * ── D BÖLÜMÜ (GÜZEL SANATLAR-KONSERVATUVAR, 24-41) TAMAMLANDI ──
 * Bölüm uzun süre "sözlükte karşılığı yok" diye yarım durdu; yalnızca sergiler
 * (24) ve tiyatro yazarlığının (33.b) bir kısmı girilmişti. Sözlüğe 19 yeni
 * etiket eklendi (`Kategori::SanatselEtkinlik`) ve bölümün tamamı yazıldı.
 * 38-41 arası (çalgı, opera, bale, kompozisyon) neredeyse bütünüyle MEVCUT
 * konservatuvar etiketleriyle karşılandı — Mersin TABLO C için açılmış küme
 * DEÜ'nün satırlarına birebir oturuyor.
 *
 * ── D BÖLÜMÜNDE AYNI ETİKETE DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR (§0) ──
 *   25 uygulanmış tasarımın sekiz satırı (25→7) → 7 · 26 müzik teknolojisinin
 *       altı satırı (20→5) → 5 · 34 sahne tasarımının altı satırı (20→5) → 5.
 *   27.b-f, 29.c ve 30.a-e'nin tamamı tek "animasyon" etiketinde (30→7) → 7.
 *   31 ve 32'de yönetmenlik (15/10) ile görüntü yönetmenliği (10/5) tek
 *       etikette → 10/5.
 *   33.a tam uzunlukta oyun (20) ile kısa oyun (10) → 10; 33.b'nin üç yazarlık
 *       satırı (20/15/10) → 10. Eskiden 33.b.1 20 puandı, düşürüldü.
 *   38.g tutti üyeliği (3/2) ve 39.g konservatuvar rejisörlüğü (20/10): kaynak
 *       etiketleri yurt dışı/yurt içi ayrımı taşımıyor → 2 ve 10.
 *   41.a opera kompozisyonu (30) ile 41.b oratoryo/bale (20) tek etikette → 20;
 *       41.c-e'nin yurt dışı/yurt içi çiftlerinde yurt içi değeri alındı.
 *
 * ── D BÖLÜMÜNDE GİRİLMEYENLER ──
 *   35.c.2 festivale eserle katılım (15/5) ve 35.d atölye yöneticiliği (3/2):
 *       etiketleri (Sempozyum/Bienal ve Masterclass) 24.a.2 ile 38.h'nin;
 *       girilseydi motor kaydı yüksek satırdan sayardı.
 *   36 retrospektif kitap ve bireysel katalog (5) — etiket yok.
 *   37 ödüllerin tamamı: bütün satırları 18.a/18.b.1'e düşüyor, 18 zaten her
 *       zorunlu kümede var. Ayrı satır ölü kod olurdu.
 *   38.d etkinlikte eşlikçilik (15/10) — etiket yok.
 *   38.i, 39.k, 40.j, 41.i "eğiticiliğini yaptığı öğrencinin ödül alması" —
 *       kayıt öğrencinin ödülünü tutmuyor.
 *   Sözlükteki şeflik etiketlerinin (opera, orkestra, bale, koro şefliği)
 *       yönergede karşılık satırı YOK; şeflik kaydeden aday 0 puan görür.
 *
 * ── ZORUNLU-MIMARLIK DÜZELTİLDİ ──
 * Küme 8.c ve 8.c.a (üniversite-sanayi projeleri) sayıyordu; Madde 1.10.1/c ve
 * kadro puan çizelgelerinin ikisi de mimarlık için "8.a, 8.b, 8.f" diyor. 8.c
 * çıkarıldı, 8.f eklendi (satırı bu düzeltmeyle açıldı).
 *
 * Yönerge: yonerge/dokuz-eylul.php
 */

return [
    'kapsam_notu' => 'Puanlar Dokuz Eylül Üniversitesi Puanlandırma Formundan. '
        .'Çok yazarlı yayınlarda puan yönergenin Madde 1.10.1/e dağılımına göre azaltılır; '
        .'çarpan hem yazar sayısına hem sıranıza bağlı olduğu için faaliyetinizde kaçıncı yazar '
        .'olduğunuzu seçmeniz gerekir. Sorumlu yazar yönergede ikinci isim gibi değerlendiriliyor. '
        .'Sırayı belirtmezseniz o yazar sayısındaki en düşük çarpan uygulanır; yazar listesini boş '
        .'bırakırsanız çarpan hiç uygulanmaz ve puanınız olduğundan yüksek görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: teknopark firması, meslek odası '
        .'görevi, girişimcilik dersi ve sertifikası, değişim programları, proje değerlendirme ve '
        .'izleyiciliği, öğrenci geri bildirimi ve ders yükü dışı dersler kaynakta ayrılamadığı '
        .'için girilmedi; patentte bireysel/grup ayrımı yapılamadığı için düşük olan grup satırı '
        .'kullanıldı. Güzel sanatlar ve konservatuvar bölümü (24-41) tamamen girildi, ama '
        .'bir kaynak etiketine birden çok yönerge satırı düştüğünde daima DÜŞÜK olan puan '
        .'kullanıldı: uygulanmış tasarım, müzik teknolojisi, sahne tasarımı ve animasyon '
        .'kalemlerinde puanınız olduğundan düşük görünebilir. Festivale eserle katılım, sanat '
        .'atölyesi yöneticiliği, retrospektif katalog, etkinlikte eşlikçilik ve öğrencinizin '
        .'aldığı ödüller girilmedi; şeflik kalemlerinin yönergede satırı yok.',

    // Madde 1.10.1/e — çok isimli yayınlarda puan dağılımı.
    //
    //   yazar sayısı   1. isim   2. isim   3. isim   4. ve sonrası
    //   tek            %100
    //   iki             %80       %70
    //   üç              %70       %60       %50
    //   çok (4+)        %60       %50       %40         %30
    //
    // "Corresponding author (sorumlu yazar) 2. isim puanı ile değerlendirilir."
    'yazar_katsayisi' => [
        // Atıf, proje, patent, tez ve idari kalemlerin puanı yazarlar arasında
        // bölüşülmüyor; kural yalnızca çok isimli YAYINLAR için yazılmış.
        'haric' => ['atif', 'proje', 'patent', 'tez_danismanligi', 'egitim_ogretim',
            'idari_gorev', 'odul', 'toplumsal_katki', 'sanatsal_etkinlik'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.0]],
            'ilk' => ['kademeler' => [1 => 1.0, 2 => 0.80, 3 => 0.70], 'sonrasi' => 0.60],
            // Sorumlu yazar yönergenin kendi cümlesiyle 2. isim satırında.
            'baslica' => ['kademeler' => [1 => 1.0, 2 => 0.70, 3 => 0.60], 'sonrasi' => 0.50],
            'yazar_2' => ['kademeler' => [2 => 0.70, 3 => 0.60], 'sonrasi' => 0.50],
            'yazar_3' => ['kademeler' => [3 => 0.50], 'sonrasi' => 0.40],
            'yazar_4' => ['sonrasi' => 0.30],
            'yazar_5' => ['sonrasi' => 0.30],
            'yazar_6' => ['sonrasi' => 0.30],
            'ortak' => ['kademeler' => [1 => 1.0, 2 => 0.70, 3 => 0.50], 'sonrasi' => 0.30],
        ],
    ],

    'maddeler' => [
        // ══ A.1 ARAŞTIRMA MAKALELERİ ══
        '1.a' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 25],
        '1.b' => ['baslik' => 'Alan endeksli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale'], 'puan' => 20],
        '1.c' => ['baslik' => 'ULAKBİM listesindeki ulusal hakemli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 15],
        '1.d' => ['baslik' => 'Yabancı hakemli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale'], 'puan' => 12],
        '1.e' => ['baslik' => 'Ulusal hakemli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale'], 'puan' => 10],

        // ══ A.2 DERLEME MAKALELER ══
        '2.a' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergide derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme'], 'puan' => 20],
        '2.b' => ['baslik' => 'Alan endeksli dergide derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['derleme'], 'puan' => 15],
        '2.c' => ['baslik' => 'ULAKBİM listesindeki ulusal hakemli dergide derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['derleme'], 'puan' => 12],
        '2.d' => ['baslik' => 'Yabancı hakemli dergide derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['derleme'], 'puan' => 10],
        '2.e' => ['baslik' => 'Ulusal hakemli dergide derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['derleme'], 'puan' => 8],

        // ══ A.3 DİĞER MAKALELER (teknik not, olgu sunumu, editöre mektup) ══
        '3.a' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergide teknik not, olgu sunumu veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 12],
        '3.b' => ['baslik' => 'Alan endeksli dergide teknik not, olgu sunumu veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 10],
        '3.c' => ['baslik' => 'ULAKBİM listesindeki dergide teknik not, olgu sunumu veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 8],
        '3.d' => ['baslik' => 'Yabancı hakemli dergide teknik not, olgu sunumu veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 8],
        '3.e' => ['baslik' => 'Ulusal hakemli dergide teknik not, olgu sunumu veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 5],

        // ══ A.4 ATIFLAR ══
        '4' => ['baslik' => 'Yayınlarınıza yapılan her bir atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap', 'TR Dizin', 'Diğer', 'Patent'], 'puan' => 5],

        // ══ A.5 KİTAPLAR (lisansüstü tezlerden üretilmemiş) ══
        '5.a' => ['baslik' => 'Uluslararası yayınevinde kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 50],
        '5.b' => ['baslik' => 'Uluslararası yayınevi kitabında bölüm veya ansiklopedi maddesi yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 15],
        '5.c' => ['baslik' => 'Ulusal yayınevinde kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 30],
        '5.d' => ['baslik' => 'Ulusal yayınevi kitabında bölüm veya ansiklopedi maddesi yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 10],

        // ══ A.6 DİĞER KİTAPLAR ══
        '6.a.1' => ['baslik' => 'Lisansüstü tezden üretilmiş, uluslararası yayınevinde kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 25],
        '6.a.2' => ['baslik' => 'Lisansüstü tezden üretilmiş, uluslararası yayınevinde kitap bölümü', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 8],
        '6.a.3' => ['baslik' => 'Lisansüstü tezden üretilmiş, ulusal yayınevinde kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 15],
        '6.a.4' => ['baslik' => 'Lisansüstü tezden üretilmiş, ulusal yayınevinde kitap bölümü', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 5],
        // Tezden üretilmiş MAKALELER: yönergenin ayrı satırı yok, sıradan
        // makale gibi puanlanıyor. Kodlar bize ait.
        '1.a.tz' => ['baslik' => 'Lisansüstü tezden üretilmiş, SCI, SCI-Expanded, SSCI veya AHCI dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 25],
        '1.b.tz' => ['baslik' => 'Lisansüstü tezden üretilmiş, alan endeksli dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 20],
        '1.c.tz' => ['baslik' => 'Lisansüstü tezden üretilmiş, ULAKBİM listesindeki dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['TR Dizin'], 'puan' => 15],
        '1.e.tz' => ['baslik' => 'Lisansüstü tezden üretilmiş, diğer hakemli dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Diğer', 'CPCI Bildiri'], 'puan' => 10],
        // 6.b çeviri yayınları — bölüm tavanı 30 puan.
        '6.b.1' => ['baslik' => 'Çeviri kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 20],
        '6.b.2' => ['baslik' => 'Çeviri kitap bölümü', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 8],

        // ══ A.7 BİLDİRİLER ══
        '7.a.1' => ['baslik' => 'Uluslararası etkinlikte sunulmuş ve tam metin basılmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 10],
        '7.a.2' => ['baslik' => 'Uluslararası etkinlikte sunulmuş ve özeti basılmış bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 5],
        '7.a.3' => ['baslik' => 'Uluslararası etkinlikte belgelendirilmiş davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 10],
        '7.b.1' => ['baslik' => 'Ulusal etkinlikte sunulmuş ve tam metin basılmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 7],
        '7.b.2' => ['baslik' => 'Ulusal etkinlikte sunulmuş ve özeti basılmış bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 3],

        // ══ A.8 PROJELER ══
        '8.a' => ['baslik' => 'Uluslararası fonlarca desteklenen projede koordinatörlük veya yöneticilik', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 20],
        '8.a.a' => ['baslik' => 'Uluslararası fonlarca desteklenen projede araştırmacılık veya danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],
        '8.b' => ['baslik' => 'TÜBİTAK veya bakanlık fonlarınca desteklenen Ar-Ge projesinde yöneticilik', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 15],
        '8.b.a' => ['baslik' => 'TÜBİTAK veya bakanlık projesinde araştırmacılık veya danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
        '8.c' => ['baslik' => 'SAN-TEZ, bakanlık destekli veya üniversite-sanayi iş birliği projesinde yöneticilik', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 10],
        '8.c.a' => ['baslik' => 'SAN-TEZ, bakanlık destekli veya üniversite-sanayi projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 8],
        '8.d' => ['baslik' => 'Üniversite destekli projede yöneticilik', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 10],
        '8.d.a' => ['baslik' => 'Üniversite destekli projede araştırmacılık veya danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 8],
        // 8.f mimarlık ve sanat alanlarının yarışma/uygulama projesi. Mimarlık
        // ile Konservatuvar zorunlu kümelerinin ikisi de bu maddeyi anıyor.
        '8.f' => ['baslik' => 'Mimarlık, sanat veya tasarım yarışma projesi ya da yayımlanmış uygulama projesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman'], 'puan' => 10],

        // ══ A.9 EDİTÖRLÜK VE YAYIN KURULU ÜYELİĞİ ══
        '9.a' => ['baslik' => 'Uluslararası yayınevi bilimsel kitabında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 25],
        '9.b' => ['baslik' => 'Ulusal yayınevi kitabında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 20],
        '9.e' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 30],
        '9.f' => ['baslik' => 'Alan endeksli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 25],
        '9.g' => ['baslik' => 'ULAKBİM listesindeki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 25],
        '9.h' => ['baslik' => 'Ulusal hakemli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 20],
        '9.j' => ['baslik' => 'Dergi yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 15],

        // ══ A.10 HAKEMLİK ══
        '10.e' => ['baslik' => 'Dergide hakemlik (değerlendirilen makale başına)', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 3],

        // ══ B. GİRİŞİMCİLİK - YENİLİKÇİLİK (11-18) ══
        // Patentin bireysel mi grup mu olduğu kayıtta yok; grup satırı alındı.
        '11.b.1' => ['baslik' => 'Uluslararası tescilli patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 40],
        '11.b.2' => ['baslik' => 'Ulusal tescilli patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 30],
        '11.c' => ['baslik' => 'Faydalı model veya endüstriyel tasarım belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 15],
        '11.d' => ['baslik' => 'Lisans anlaşmasıyla sanayiye devredilmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 30],
        '18.a' => ['baslik' => 'Sürekli ve periyodik verilen jürili uluslararası bilim, sanat veya tasarım ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 20],

        // 18.b maddesi SÜREKLİ VE PERİYODİK olarak verilen jürili ödülleri
        // sayıyor; tek seferlik bir yarışma derecesi bu tanıma girmiyor,
        // etiket 01.09.2026'da satırdan çıkarıldı.
        '18.b.1' => ['baslik' => 'Bilim, sanat veya tasarım ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'YÖK Ödülü', 'Ulusal Bilim/Sanat Ödülü'], 'puan' => 15],
        '18.b.2' => ['baslik' => 'Teşvik ödülü veya burs', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü', 'Burs'], 'puan' => 10],

        // ── 37. MİMARLIK, SANAT VE TASARIM ÖDÜLLERİ ──
        // 01.09.2026'da ayrı satır açıldı. Daha önce yarışma ödülleri 18.b.1'in
        // (jürili ulusal bilim ödülü, 15) etiketlerine bağlıydı; oysa 18.b
        // "SÜREKLİ VE PERİYODİK olarak verilen" ödülleri sayıyor ve tek
        // seferlik bir yarışma derecesi oraya girmiyor. Madde 37 derece ve
        // mansiyonu uluslararası 20/15, ulusal 10 puanlıyor; kayıt ne dereceyi
        // ne düzeyi taşıdığı için §0 uyarınca ulusal kademeden.
        '37.a' => ['baslik' => 'Mimarlık, sanat veya tasarım yarışmasında derece, mansiyon ya da jüri özel ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 10],

        // ══ C. EĞİTİME KATKI (19-22) ══
        '19.a' => ['baslik' => 'Danışmanlığında tamamlanmış doktora, tıpta uzmanlık veya sanatta yeterlik tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman', 'es_danisman'], 'puan' => 10],
        '19.d' => ['baslik' => 'Danışmanlığında tamamlanmış yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman', 'es_danisman'], 'puan' => 5],
        '22.a' => ['baslik' => 'Uluslararası yayınevinde ders kitabı yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 20],

        // ══ D. GÜZEL SANATLAR - KONSERVATUVAR (24-41) ══
        // 24 SERGİLER — yurt dışı / yurt içi ayrımı yönergenin kendi ayrımı.
        '24.a.1' => ['baslik' => 'Yurt dışı bireysel (kişisel) sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)'], 'puan' => 30],
        '24.a.2' => ['baslik' => 'Yurt dışı hakemli sergi, bienal veya trienal', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 20],
        '24.a.3' => ['baslik' => 'Yurt dışı grup sergisi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Grup Etkinliği (Uluslararası)'], 'puan' => 10],
        '24.a.4' => ['baslik' => 'Yurt dışı karma sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Jürisiz)'], 'puan' => 5],
        '24.a.5' => ['baslik' => 'Yurt dışında kamusal alanda uygulanmış yapıt', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kamusal Alanda Uygulanmış Yapıt (Yurt Dışı)'], 'puan' => 15],
        '24.a.6' => ['baslik' => 'Yurt dışında koleksiyon veya müzede sürekli sergilenen yapıt', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Yayında Yer Alması / Satın Alınması'], 'puan' => 20],
        '24.b.1' => ['baslik' => 'Yurt içi bireysel (kişisel) sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)'], 'puan' => 20],
        '24.b.2' => ['baslik' => 'Yurt içi hakemli sergi, bienal veya trienal', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 15],
        '24.b.3' => ['baslik' => 'Yurt içi grup sergisi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Grup Etkinliği (Ulusal)'], 'puan' => 8],
        '24.b.4' => ['baslik' => 'Yurt içi karma sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Jürisiz, Ulusal)'], 'puan' => 3],
        '24.b.5' => ['baslik' => 'Yurt içinde kamusal alanda uygulanmış yapıt', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kamusal Alanda Uygulanmış Yapıt (Yurt İçi)'], 'puan' => 10],
        '24.b.6' => ['baslik' => 'Yurt içinde koleksiyon veya müzede sürekli sergilenen yapıt', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Satın Alınması (Yurt İçi)'], 'puan' => 15],

        // 25 UYGULANMIŞ TASARIM — sekiz satır (25→7) tek etikete düşüyor, en
        // düşüğü (25.f-h, 7 puan) alındı.
        '25.h' => ['baslik' => 'Uygulanmış tasarım çalışması veya koleksiyon hazırlığı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulanmış Tasarım / Koleksiyon'], 'puan' => 7],

        // 26 MÜZİK TEKNOLOJİSİ — altı satır (20→5) tek etikette, en düşüğü
        // (26.f kayıt/mix/mastering katılımcılığı, 5 puan) alındı.
        '26.f' => ['baslik' => 'Müzik teknolojisi uygulaması (kayıt, mix, akustik proje, MIDI)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Müzik Teknolojisi Uygulaması'], 'puan' => 5],

        // 27-32 EKRAN YAPIMLARI. 27.a ile 28 uluslararası/ulusal ayrımını
        // taşıyor; animasyon satırlarının tamamı (27.b-f, 29.c, 30.a-e, 30→7)
        // tek etikete düştüğü için en düşüğü (30.e, 7 puan) alındı.
        '27.a.1' => ['baslik' => 'Uluslararası uzun metrajlı film veya belgeselde yönetmen, görüntü yönetmeni veya senaryo yazarı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uzun Metrajlı Film / Belgesel (Uluslararası)'], 'puan' => 30],
        '27.a.2' => ['baslik' => 'Ulusal uzun metrajlı film veya belgeselde yönetmen, görüntü yönetmeni veya senaryo yazarı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uzun Metrajlı Film / Belgesel (Ulusal)'], 'puan' => 20],
        '30.e' => ['baslik' => 'Animasyon, canlandırma veya video efekt yapımı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Animasyon / Canlandırma Yapımı'], 'puan' => 7],
        '28.1' => ['baslik' => 'Uluslararası TV filmi, dizisi veya belgeselinde yönetmen, görüntü yönetmeni veya senaryo yazarı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['TV Filmi / Dizisi (Uluslararası)'], 'puan' => 30],
        '28.2' => ['baslik' => 'Ulusal TV filmi, dizisi veya belgeselinde yönetmen, görüntü yönetmeni veya senaryo yazarı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['TV Filmi / Dizisi (Ulusal)'], 'puan' => 20],
        '29.a' => ['baslik' => 'Uluslararası kısa filmde yönetmen, görüntü yönetmeni veya senaryo yazarı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Uluslararası)'], 'puan' => 20],
        '29.b' => ['baslik' => 'Ulusal kısa filmde yönetmen, görüntü yönetmeni veya senaryo yazarı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Ulusal)'], 'puan' => 10],
        // 31.a yönetmenlik (15/10) ile 31.b görüntü yönetmenliği (10/5) aynı
        // etikete düşüyor; 32'de de aynı ikilik var. İkisinde de düşüğü alındı.
        '31.b.1' => ['baslik' => 'Uluslararası TV programında yönetmen, görüntü yönetmeni veya senaryo yazarı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['TV Programı (Uluslararası)'], 'puan' => 10],
        '31.b.2' => ['baslik' => 'Ulusal TV programında yönetmen, görüntü yönetmeni veya senaryo yazarı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['TV Programı (Ulusal)'], 'puan' => 5],
        '32.b.1' => ['baslik' => 'Uluslararası reklam veya tanıtım filminde yönetmen, kameraman veya metin yazarı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Reklam / Tanıtım Filmi (Uluslararası)'], 'puan' => 10],
        '32.b.2' => ['baslik' => 'Ulusal reklam veya tanıtım filminde yönetmen, kameraman veya metin yazarı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Reklam / Tanıtım Filmi (Ulusal)'], 'puan' => 5],

        // 33 TİYATRO. 33.a tam uzunlukta (20) ile kısa oyun (10) sahnelemesi
        // tek "Yönetmenlik" etiketinde → 10. 33.b yazarlığında da üç satır
        // (20/15/10) tek "Özgün Eser" etiketinde → 10.
        '33.a.2' => ['baslik' => 'Oyun sahneleme', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Yönetmenlik (Sahne/Ekran)'], 'puan' => 10],
        '33.b.2' => ['baslik' => 'Sahne oyunu yazarlığı, uyarlama veya özgün eser', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım'], 'puan' => 10],
        // 33.c uygulama: hareket düzeni, dramatizasyon, performans, happening.
        // Üç satır (5/3/2) tek etikette → en düşüğü değil, gösterim satırının
        // kendisi alındı: atölye satırları (c.2, c.3) 35.d ile aynı kalem.
        '33.c.1' => ['baslik' => 'İzleyici karşısına çıkmış uygulama gösterimi (hareket düzeni, dramatizasyon, performans)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Dansçı / Performans İcracısı (Uluslararası)', 'Dansçı / Performans İcracısı (Ulusal)'], 'puan' => 5],

        // 34 SAHNE TASARIMI — altı satır (20→5) tek etikette, en düşüğü alındı.
        '34.e' => ['baslik' => 'Sahne tasarımı: dekor, kostüm, ışık, makyaj veya kukla', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne Tasarımı (Dekor, Kostüm, Işık)'], 'puan' => 5],

        // 35 SANAT ETKİNLİKLERİ
        '35.a.1' => ['baslik' => 'Uluslararası sergi yapımcılığı (küratörlük)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sergi Küratörlüğü (Uluslararası)'], 'puan' => 10],
        '35.a.2' => ['baslik' => 'Ulusal sergi yapımcılığı (küratörlük)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sergi Küratörlüğü (Ulusal)'], 'puan' => 5],
        '35.b' => ['baslik' => 'Sanat ve tasarım danışmanlığı veya sanat kurulu üyeliği', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı'], 'puan' => 5],
        '35.c.1.1' => ['baslik' => 'Uluslararası sanat festivali koordinatörlüğü', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Festival Koordinatörlüğü (Uluslararası)'], 'puan' => 20],
        '35.c.1.2' => ['baslik' => 'Ulusal sanat festivali koordinatörlüğü', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Festival Koordinatörlüğü (Ulusal)'], 'puan' => 10],

        // 38 ÇALGI VE SES PERFORMANSI
        '38.a.1' => ['baslik' => 'Yurt dışında orkestra eşliğinde solistlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Solistlik (Uluslararası)'], 'puan' => 25],
        '38.a.2' => ['baslik' => 'Yurt içinde orkestra eşliğinde solistlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Solistlik (Ulusal)'], 'puan' => 15],
        '38.b.1' => ['baslik' => 'Yurt dışı resital veya dinleti', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Uluslararası)'], 'puan' => 30],
        '38.b.2' => ['baslik' => 'Yurt içi resital veya dinleti', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Ulusal)'], 'puan' => 20],
        '38.c.1' => ['baslik' => 'Yurt dışı karma dinleti veya oda müziği konseri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Uluslararası)'], 'puan' => 30],
        '38.c.2' => ['baslik' => 'Yurt içi karma dinleti veya oda müziği konseri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Ulusal)'], 'puan' => 20],
        '38.e.1' => ['baslik' => 'Yurt dışı orkestra konserinde başkemancılık', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Başkemancılık (Uluslararası)'], 'puan' => 5],
        '38.e.2' => ['baslik' => 'Yurt içi orkestra konserinde başkemancılık', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Başkemancılık (Ulusal)'], 'puan' => 3],
        '38.f.1' => ['baslik' => 'Yurt dışı orkestra konserinde grup şefliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Grup Şefliği (Uluslararası)'], 'puan' => 5],
        '38.f.2' => ['baslik' => 'Yurt içi orkestra konserinde grup şefliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Grup Şefliği (Ulusal)'], 'puan' => 3],
        // 38.g tutti üyeliği (3/2): etiket yurt ayrımı taşımıyor → düşüğü.
        '38.g' => ['baslik' => 'Orkestra veya koro konserinde tutti üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra / Koro Üyeliği'], 'puan' => 2],
        // 38.h, 39.j, 40.i ve 41.h aynı workshop satırı (20/10).
        '38.h.1' => ['baslik' => 'Konservatuvar veya müzik kurumunda yurt dışında workshop yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Masterclass (Uluslararası)'], 'puan' => 20],
        '38.h.2' => ['baslik' => 'Konservatuvar veya müzik kurumunda yurt içinde workshop yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Masterclass (Ulusal)'], 'puan' => 10],
        // 38.j, 39.i ve 40.h aynı bandrollü kayıt satırı (20).
        '38.j' => ['baslik' => 'Performansın bandrollü CD, DVD veya benzeri kayıt ortamında yayımlanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bandrollü Kayıt (CD/DVD)'], 'puan' => 20],

        // 39 OPERA PERFORMANSI
        '39.a.1' => ['baslik' => 'Yurt dışında opera veya operet temsilinde birinci derece rol', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera Birinci Rol (Uluslararası)'], 'puan' => 30],
        '39.a.2' => ['baslik' => 'Yurt içinde opera veya operet temsilinde birinci derece rol', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera Birinci Rol (Ulusal)'], 'puan' => 20],
        '39.b.1' => ['baslik' => 'Yurt dışında oratoryo, kantat veya ensemble solistliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oratoryo/Kantat Solistliği (Uluslararası)'], 'puan' => 20],
        '39.b.2' => ['baslik' => 'Yurt içinde oratoryo, kantat veya ensemble solistliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oratoryo/Kantat Solistliği (Ulusal)'], 'puan' => 10],
        '39.c.1' => ['baslik' => 'Yurt dışı şan resitali', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Şan Resitali (Uluslararası)'], 'puan' => 30],
        '39.c.2' => ['baslik' => 'Yurt içi şan resitali', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Şan Resitali (Ulusal)'], 'puan' => 20],
        '39.d.1' => ['baslik' => 'Yurt dışında opera veya operet temsilinde ikinci derece rol', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera İkinci Rol (Uluslararası)'], 'puan' => 20],
        '39.d.2' => ['baslik' => 'Yurt içinde opera veya operet temsilinde ikinci derece rol', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera İkinci Rol (Ulusal)'], 'puan' => 10],
        '39.f.1' => ['baslik' => 'Yurt dışı profesyonel sanat kurumunda rejisörlük', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisörlük (Uluslararası)'], 'puan' => 30],
        '39.f.2' => ['baslik' => 'Yurt içi profesyonel sanat kurumunda rejisörlük', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisörlük (Ulusal)'], 'puan' => 20],
        // 39.g konservatuvar rejisörlüğü (20/10): etiket yurt ayrımı taşımıyor.
        '39.g' => ['baslik' => 'Devlet konservatuvarında en az 60 dakikalık bir eserin rejisörlüğü', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisörlük (Konservatuvar)'], 'puan' => 10],
        '39.h.1' => ['baslik' => 'Yurt dışı profesyonel sanat kurumunda rejisör yardımcılığı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisör Yardımcılığı (Uluslararası)', 'Rejisör Yardımcılığı (Konservatuvar)'], 'puan' => 20],
        '39.h.2' => ['baslik' => 'Yurt içi profesyonel sanat kurumunda rejisör yardımcılığı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisör Yardımcılığı (Ulusal)'], 'puan' => 10],

        // 40 BALE PERFORMANSI
        '40.a.1' => ['baslik' => 'Yurt dışı bale temsilinde başrol', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bale Başrol (Uluslararası)'], 'puan' => 30],
        '40.a.2' => ['baslik' => 'Yurt içi bale temsilinde başrol', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bale Başrol (Ulusal)'], 'puan' => 20],
        '40.b.1' => ['baslik' => 'Yurt dışı bale temsilinde solist rol', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bale Solist Rol (Uluslararası)'], 'puan' => 20],
        '40.b.2' => ['baslik' => 'Yurt içi bale temsilinde solist rol', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bale Solist Rol (Ulusal)'], 'puan' => 10],
        '40.c.1' => ['baslik' => 'Yurt dışı bale temsilinde corps de ballet rolü', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Corps de Ballet (Uluslararası)'], 'puan' => 10],
        '40.c.2' => ['baslik' => 'Yurt içi bale temsilinde corps de ballet rolü', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Corps de Ballet (Ulusal)'], 'puan' => 5],
        '40.d.1' => ['baslik' => 'Yurt dışı profesyonel sanat kurumunda tüm perde koreograflığı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Tüm Perde Koreograflığı (Uluslararası)'], 'puan' => 20],
        '40.d.2' => ['baslik' => 'Yurt içi profesyonel sanat kurumunda tüm perde koreograflığı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Tüm Perde Koreograflığı (Ulusal)'], 'puan' => 10],
        '40.e.1' => ['baslik' => 'Yurt dışı profesyonel sanat kurumunda bölüm koreograflığı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bölüm Koreograflığı (Uluslararası)'], 'puan' => 10],
        '40.e.2' => ['baslik' => 'Yurt içi profesyonel sanat kurumunda bölüm koreograflığı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bölüm Koreograflığı (Ulusal)'], 'puan' => 5],
        '40.f.1' => ['baslik' => 'Yurt dışı konservatuvarda bale veya dans koreograflığı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bale/Dans Koreograflığı (Uluslararası)', 'Koreografi'], 'puan' => 10],
        '40.f.2' => ['baslik' => 'Yurt içi konservatuvarda bale veya dans koreograflığı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bale/Dans Koreograflığı (Ulusal)'], 'puan' => 5],
        '40.g.1' => ['baslik' => 'Yurt dışı konservatuvarda klasik bir bale eserini sahnelemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahneleme/Repetitörlük — Tüm Perde (Uluslararası)', 'Sahneleme/Repetitörlük — Bölüm (Uluslararası)'], 'puan' => 20],
        '40.g.2' => ['baslik' => 'Yurt içi konservatuvarda klasik bir bale eserini sahnelemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahneleme/Repetitörlük — Tüm Perde (Ulusal)', 'Sahneleme/Repetitörlük — Bölüm (Ulusal)'], 'puan' => 10],

        // 41 KOMPOZİSYON. Yurt dışı/yurt içi ayrımı taşıyan satırlarda yurt içi
        // değeri alındı: kaynak sözlüğündeki beste etiketleri yer ayrımı
        // taşımıyor. 41.a opera (30) ile 41.b oratoryo/bale (20) tek etikette.
        '41.b' => ['baslik' => 'Opera, oratoryo, bale ya da eşdeğeri sahne kompozisyonu', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera/Bale Kompozisyonu', 'Orkestralı Sahne Eseri'], 'puan' => 20],
        '41.c' => ['baslik' => 'Orkestra için senfonik eser kompozisyonu', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Küçük Ölçekli Orkestra Eseri'], 'puan' => 20],
        '41.d' => ['baslik' => 'En az 5 dakika süreli solo çalgı, ses, koro, oda müziği veya elektronik müzik eseri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda/Koro Müziği Eseri (≥15 dk)', 'Elektronik Müzik Eseri (≥15 dk)'], 'puan' => 15],
        '41.e' => ['baslik' => '5 dakikadan kısa solo çalgı, ses, koro, oda müziği veya elektronik müzik eseri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (<15 dk)'], 'puan' => 10],
        '41.f' => ['baslik' => 'Film müziği, tiyatro müziği ya da eşdeğeri eser kompozisyonu', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne/Ekran Müziği'], 'puan' => 15],
        '41.g' => ['baslik' => 'Eğitim müziği albümü kompozisyonu', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eğitim Müziği Albümü'], 'puan' => 8],
        '47.a.1' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 15],
        '47.b.1' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Ulusal)'], 'puan' => 12],
        '47.a.4' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 7],
        '47.b.4' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 5],
        '47.a.3' => ['baslik' => 'Bilimsel toplantıda oturum başkanlığı (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Uluslararası)'], 'puan' => 7],
        '47.b.3' => ['baslik' => 'Bilimsel toplantıda oturum başkanlığı (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Ulusal)'], 'puan' => 5],
    ],

    'gruplar' => [
        // Koşulların adıyla andığı dergi kümeleri.
        'SCI' => ['1.a'],
        'SCI-ALAN' => ['1.a', '1.b'],
        'HAKEMLI-MAKALE' => ['1.a', '1.b', '1.c', '1.d', '1.e'],
        'KITAP' => ['5.a', '5.c'],
        'KITAP-VEYA-BOLUM' => ['5.a', '5.b', '5.c', '5.d'],
        'MAKALE-KITAP-BOLUM' => ['1.a', '1.b', '1.c', '1.d', '1.e', '5.a', '5.b', '5.c', '5.d'],
        // "Puanlandırma Formundaki B. Girişimcilik-Yenilikçilik bölümünden
        // 15 puanlık etkinlik" telafisinin kümesi.
        'B-GIRISIMCILIK' => ['11.b.1', '11.b.2', '11.c', '11.d', '18.a', '18.b.1', '18.b.2'],
        // Mimarlık doçentliğinin ek koşulu (yarışma, uygulama, yazılım/patent).
        'MIMARLIK-EK' => ['11.b.1', '11.b.2', '11.c', '11.d', '18.a', '18.b.1'],

        // Madde 1.10.1/c — alanlara göre zorunlu puan madde kümeleri. Altı küme
        // hem Madde 1.10.1/c'de hem de kadro puan çizelgelerinin ilk satırında
        // yazılı; ikisi de aynı listeyi veriyor.
        //
        // MADDE 37 (Mimarlık, Sanat ve Tasarım Ödülleri) 01.09.2026'da kendi
        // satırına ayrıldı. Önce "bütün satırları 18.a/18.b.1'e düşüyor" diye
        // bırakılmıştı; oysa 18.b SÜREKLİ VE PERİYODİK ödülleri sayıyor ve tek
        // seferlik bir yarışma derecesi 15 puan alıyordu. Artık 37.a'dan 10.
        'ZORUNLU-FEN' => ['1.*', '2.a', '8.a', '8.a.a', '8.b', '8.b.a', 'B-GIRISIMCILIK'],
        'ZORUNLU-SOSYAL' => ['1.*', '2.*', '5.*', '22.*', '8.a', '8.a.a', '8.b', '8.b.a', 'B-GIRISIMCILIK'],
        'ZORUNLU-MIMARLIK' => ['1.*', '2.*', '5.*', '22.*', '8.a', '8.a.a', '8.b', '8.b.a', '8.f', 'B-GIRISIMCILIK'],
        // Güzel sanatların kuramsal alanları tiyatro çalışmalarını (33) da
        // sayıyor; uygulamalı alanlar D bölümünün 24-34 arasının tamamını.
        'ZORUNLU-GS-KURAMSAL' => ['1.*', '2.*', '5.*', '22.*', '33.*', '8.a', '8.a.a', '8.b', '8.b.a', 'B-GIRISIMCILIK'],
        'ZORUNLU-GS-UYGULAMALI' => ['1.*', '2.*', '5.*', '22.*', '8.a', '8.a.a', '8.b', '8.b.a', 'B-GIRISIMCILIK',
            '24.*', '25.*', '26.*', '27.*', '28.*', '29.*', '30.*', '31.*', '32.*', '33.*', '34.*'],
        'ZORUNLU-KONSERVATUVAR' => ['1.*', '2.*', '5.*', '22.*', '8.a', '8.a.a', '8.b', '8.b.a', 'B-GIRISIMCILIK',
            '38.*', '39.*', '40.*', '41.*'],

        'CEVIRI' => ['6.b.1', '6.b.2'],

        // Madde 2.11-2.12'nin koşul metinlerinin andığı sanatsal kümeler.
        'BILDIRI' => ['7.*'],
        'KISISEL-ETKINLIK' => ['24.a.1', '24.b.1'],
        'KARMA-ETKINLIK' => ['24.a.2', '24.a.3', '24.a.4', '24.b.2', '24.b.3', '24.b.4'],
        'SANAT-ETKINLIGI' => ['24.a.2', '24.b.2'],
        'MUZIK-TEKNOLOJISI' => ['26.*'],
        'TIYATRO-UYGULAMA' => ['33.*', '34.*'],
        'SAHNE-TASARIMI' => ['34.*'],
        'DRAMATIK-METIN' => ['33.b.2'],
        'KOMPOZISYON' => ['41.*'],
        'OPERA-REJI' => ['39.f.1', '39.f.2', '39.g'],
        'DANS-SOLIST' => ['40.a.1', '40.a.2', '40.b.1', '40.b.2'],
        'DANS-KOREOGRAFI' => ['40.d.1', '40.d.2', '40.e.1', '40.e.2', '40.f.1', '40.f.2'],
        'DANS-SAHNELEME' => ['40.c.1', '40.c.2', '40.g.1', '40.g.2'],
    ],

    'grup_tavanlari' => [
        // 6.b: "Bu maddeden en fazla 30 puan alınabilir."
        'CEVIRI' => 30,
    ],
];
