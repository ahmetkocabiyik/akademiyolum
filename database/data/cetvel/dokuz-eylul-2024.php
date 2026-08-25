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
 * ── D BÖLÜMÜ (GÜZEL SANATLAR-KONSERVATUVAR, 24-41) KISMEN GİRİLDİ ──
 * Sergiler (24) ve tiyatro (33) kaleminin sözlükte karşılığı olan satırları
 * yazıldı; müzik teknolojisi, film, animasyon, TV ve reklam blokları (25-32,
 * 34-41) girilemedi. Güzel Sanatlar ve Konservatuvar alanlarının KOŞULLARI da
 * bu yüzden girilmedi — bkz. yonerge/dokuz-eylul.php.
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
        .'kullanıldı. Güzel sanatlar ve konservatuvar bölümünün yalnızca sergi ve tiyatro '
        .'kalemleri girilebildi.',

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
        '18.b.1' => ['baslik' => 'Bilim, sanat veya tasarım ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'YÖK Ödülü', 'Ulusal Bilim/Sanat Ödülü', 'Yarışma Derecesi / Mansiyon'], 'puan' => 15],
        '18.b.2' => ['baslik' => 'Teşvik ödülü veya burs', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü', 'Burs'], 'puan' => 10],

        // ══ C. EĞİTİME KATKI (19-22) ══
        '19.a' => ['baslik' => 'Danışmanlığında tamamlanmış doktora, tıpta uzmanlık veya sanatta yeterlik tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman', 'es_danisman'], 'puan' => 10],
        '19.d' => ['baslik' => 'Danışmanlığında tamamlanmış yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman', 'es_danisman'], 'puan' => 5],
        '22.a' => ['baslik' => 'Uluslararası yayınevinde ders kitabı yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 20],

        // ══ D. GÜZEL SANATLAR - KONSERVATUVAR (kısmen) ══
        '24.a.1' => ['baslik' => 'Yurt dışı bireysel (kişisel) sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)'], 'puan' => 30],
        '24.a.2' => ['baslik' => 'Yurt dışı hakemli sergi, bienal veya trienal', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 20],
        '24.a.6' => ['baslik' => 'Yurt dışında koleksiyon veya müzede sürekli sergilenen yapıt', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Yayında Yer Alması / Satın Alınması'], 'puan' => 20],
        '24.b.1' => ['baslik' => 'Yurt içi bireysel (kişisel) sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)'], 'puan' => 20],
        '24.b.2' => ['baslik' => 'Yurt içi hakemli sergi, bienal veya trienal', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 15],
        '24.b.6' => ['baslik' => 'Yurt içinde koleksiyon veya müzede sürekli sergilenen yapıt', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Satın Alınması (Yurt İçi)'], 'puan' => 15],
        '33.b.1' => ['baslik' => 'Sahne oyunu yazmak veya özgün eser üretmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım'], 'puan' => 20],
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

        // Madde 1.10.1/c — alanlara göre zorunlu puan madde kümeleri.
        'ZORUNLU-FEN' => ['1.*', '2.a', '8.a', '8.a.a', '8.b', '8.b.a', 'B-GIRISIMCILIK'],
        'ZORUNLU-SOSYAL' => ['1.*', '2.*', '5.*', '22.*', '8.a', '8.a.a', '8.b', '8.b.a', 'B-GIRISIMCILIK'],
        'ZORUNLU-MIMARLIK' => ['1.*', '2.*', '5.*', '22.*', '8.a', '8.a.a', '8.b', '8.b.a', '8.c', '8.c.a', 'B-GIRISIMCILIK'],

        'CEVIRI' => ['6.b.1', '6.b.2'],
    ],

    'grup_tavanlari' => [
        // 6.b: "Bu maddeden en fazla 30 puan alınabilir."
        'CEVIRI' => 30,
    ],
];
