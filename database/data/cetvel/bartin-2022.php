<?php

/**
 * BARTIN ÜNİVERSİTESİ — Tablo-3: Yayın-Faaliyet Puanlama Tablosu
 * Kaynak: pdf/17536931192.bartinuniverstesi.pdf (22 sayfa, Senato
 * 20.04.2022/2022/07-11, YÖK Genel Kurulu onayı 18.07.2022, yürürlük
 * 18.07.2023)
 *
 * ── BU CETVEL HİÇBİR PUAN BARAJINA BAĞLI DEĞİL ──
 * Bartın'ın atama ölçütleri PUAN değil ÖLÇÜT SAYIYOR: Tablo-1 (Dr. Öğr.
 * Üyesi) yirmi, Tablo-2 (doçent ve profesör) yirmi iki satırlık bir ölçüt
 * listesi veriyor ve yönerge "şu ölçütlerin en az N'ini sağlamış olmak"
 * diyor. Tablo-3'ün puanları yönergenin hiçbir maddesinde bir barajla
 * karşılaştırılmıyor.
 *
 * Cetvel yine de puanlarıyla girildi: adayın başvuru formunda beyan ettiği
 * puan tablosu bu ve kendi toplamını görmesi işine yarıyor. Ama yönerge
 * dosyasında `Kalip::toplam` HİÇ KULLANILMADI — koşullar tamamen
 * `Kalip::adet` ve `Kalip::kIle` üstünde kuruldu. Kapsam notu adaya
 * toplam puanın atamada bir eşiği olmadığını söylüyor.
 *
 * MADDE KODLARI YÖNERGENİN KENDİSİ (A.1.a-d, A.2-A.10, B.1-B.24, C.1-C.14,
 * Ç.1-Ç.3, D, E, F, G, H, I, İ, J, K, L, M, N, O, P, R, S). Bize ait olan
 * tek şey birleştirilen satırların tire ile yazılmış çift kodları
 * (`A.8-A.10`) ve A.1'in araştırma/derleme ayrımı için açılan `-derleme`
 * ekleri.
 *
 * ── A.1 İKİ KEZ YAZILDI: ARAŞTIRMA VE DERLEME ──
 * A.1 "Q1-Q4 kategorisindeki dergilerde yayımlanmış MAKALE" diyor, tür
 * ayırmıyor; A.9 aynı dergilerdeki teknik not/mektup/özet türlerini ayrı
 * puanlıyor. Yani Q dergisindeki derleme de A.1'den puan alıyor. Ama
 * ölçütler "araştırma makalesi" ile "araştırma ya da derleme makalesi"
 * arasında ayrım yapıyor, dolayısıyla iki türün AYRI KODA ihtiyacı vardı.
 * Çözüm: her çeyreklik iki satır (`A.1.a` araştırma, `A.1.a-derleme`), ikisi
 * de aynı puanda. Puan aynı olduğu için çifte sayım doğmuyor (motor bir
 * faaliyete uyan maddelerden en yükseğini alıyor, toplamıyor).
 *
 * ── AYNI KAYNAĞA DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   A.3 (Senato onaylı alan endeksleri 90) ile A.4 (diğer uluslararası
 *       hakemli 80): sözlükte kuruma özel indeks listesi yok, tek 'Diğer
 *       Uluslararası İndeks' etiketi → 80. Aynı sebeple A.8 (50) ile
 *       A.10 (40) → 40.
 *   B bölümünün SONUÇLANMIŞ / DEVAM EDEN satır çiftleri: faaliyet kaydında
 *       projenin bittiği bilgisi yok, çiftler devam eden değerinde
 *       birleştirildi (B.1-B.3 → 400, B.2-B.4 → 300, B.5-B.7 → 150,
 *       B.6-B.8 → 100, B.19-B.20 → 60, B.21-B.22 → 50→40, B.23-B.24 → 20).
 *   C.1 (uluslararası kitap 200) ile C.2 (ulusal kitap 180): 'Uluslararası/
 *       Ulusal Kitap' etiketi ikisini birden kapsıyor. C.1'e BKCI etiketi
 *       verilerek ayrım korundu (BKCI'de taranan kitap her hâlde
 *       uluslararası yayımlanmıştır); C.2 ortak etikette 180'de kaldı.
 *   C.3/C.4 ders kitabı (100/80): tek 'Ders / Metot Kitabı' → 80.
 *   C.5/C.6 uluslararası kitap editörlüğü ve yardımcı editörlüğü (150/120)
 *       → 120; C.7/C.8 ulusal (120/100) → 100.
 *   K.3 (yurtiçi kamu bilim ödülü 120) ile K.6 (özel kurum ödülü 60): tek
 *       'Ulusal Bilim/Sanat Ödülü' etiketi → 60.
 *   K.4/K.5 etkinlik ödülü (80/40) ile R.7 yarışma derecesi (30): tek
 *       'Yarışma Derecesi / Mansiyon' etiketi → 30.
 *   G.1/G.2 kitapta atıf (uluslararası 5 / ulusal 2): tek 'BKCI Kitap'
 *       etiketi → 2.
 *   İ.5/İ.6/İ.7 tez jürisi, yeterlik ve izleme komitesi (10/15/10): tek
 *       'Tez İzleme / Jüri Üyeliği' etiketi → 10.
 *   I.4/I.9 davetli konuşmacılık (uluslararası 40 / ulusal 15): tek
 *       'Davetli Konuşmacı' etiketi → 15.
 *   J.5/J.6/J.7 hakemlik (15/10/5) → 5; 'Yayın Kurulu Üyeliği' de bu
 *       satıra bağlandı (Tablo-2 ölçüt 15 "editör kurulunda yer almak"
 *       diyor ama Tablo-3'te karşılığı yok, en düşük satır seçildi).
 *   L.3 (ABD başkanlığı, bölüm başkan yrd., merkez müdür yrd. 60) ile
 *       L.5-L.6 (kurul/komisyon ve koordinatörlük 20/15): 'Anabilim Dalı
 *       Başkanı / Koordinatörlük' etiketi ikisine birden düşüyor → o etiket
 *       15'lik satırda, L.3 yalnızca 'Bölüm Başkan Yardımcısı' ile 60'ta.
 *   M.2/M.3 lisans ve önlisans dersi (5/4): tek 'Lisans/Önlisans Ders'
 *       etiketi → 4.
 *   O bölümünün "yer almak / kabul edilmek" çiftleri (O.2-O.3 60/40,
 *       O.8-O.9 40/30) → 40 ve 30; O.5/O.6 yurt içi kişisel etkinlik
 *       (30/20) → 20; O.15/O.16 sahne sanatları grubu (20/15) → 15.
 *   R.1-R.6 (mimarlık uygulama projesi hakkında yayın, 140'tan 40'a):
 *       sözlükteki dört 'Uygulama Projesi' etiketi rol ayrımı taşıyor,
 *       yayın türü ayrımı taşımıyor → hepsi tek satırda 40.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   E.3, F.2, F.4 — patent, faydalı model ve endüstriyel tasarım
 *       BAŞVURUSU. Tescilliyle aynı kaynağa düşer, motor en yükseği
 *       seçeceği için başvuru sahibi tescilli gibi sayılırdı. Bu, Tablo-1
 *       ölçüt 14.a ile Tablo-2 ölçüt 9.a'nın yardımcı dalını da düşürüyor
 *       (satırın temel dalı duruyor, satır yalnızca zorlaşıyor).
 *   H bölümünün tamamı (h-indeksi kademeleri) — h-indeksi bir PROFİL
 *       özelliği, faaliyet kaydı değil.
 *   B.15-B.18 — "Bartın Üniversitesi Akıllı Lojistik Sistemler ve Bütünleşik
 *       Bölge Uygulamaları ihtisas alanı" projeleri; kuruma ve konuya özel,
 *       sözlükte karşılıksız.
 *   I.3, I.5, I.8, I.10, I.11, I.12 — düzenleme kurulu başkanlığı, oturum
 *       başkanlığı, üniversite içi etkinlikler. `Diger` kategorisinin tek
 *       'Diğer' etiketine düşerlerdi ve C.13/Ç satırlarını 20'den 3'e
 *       çekerlerdi; girilmedi.
 *   L.7 (kulüp danışmanlığı 10) — aynı sebeple; L.5-L.6 satırını 10'a
 *       çekerdi.
 *   M.4 (akademik danışmanlık) — sözlükte karşılıksız.
 *   N bölümünün tamamı (sportif faaliyetler: milli takım antrenörlüğü,
 *       federasyon kurulları, sporcu dereceleri) — `Kategori` sözlüğünde
 *       spor karşılığı yok. Bu, Tablo-2'nin 16/16.a satırını tamamen
 *       değerlendirilemez kılıyor.
 *   P bölümünün tamamı (arkeolojik kazı ve yüzey araştırması) — sözlükte
 *       karşılıksız; Tablo-1 ölçüt 12 ile Tablo-2 ölçüt 12'nin temel dalı
 *       düşüyor, yardımcı dalları duruyor.
 *   S bölümünün tamamı (yurt dışı araştırma süresi) — süreye bağlı bir
 *       görev kaydı; sözlükte karşılıksız. Tablo-1 ölçüt 15 ile Tablo-2
 *       ölçüt 8.a düşüyor.
 *   'Burs' ve 'Akreditasyon Faaliyeti' etiketlerinin Tablo-3'te karşılığı
 *       yok; bu türde kayıt tutan aday o kalemden puan almaz.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   L bölümü dipnotu "bu bölümden alınacak toplam puan, diğer bölümlerin
 *       toplamının %10'unu aşamaz" — başka bir grubun toplamına bağlı
 *       tavan motorda yok; idari görev puanı YÜKSEK görünebilir.
 *   L ve M bölümleri "her yıl için" / "son beş yılda her bir ders" diyor;
 *       yıl biriktirmesi motorda yok, tek yıl/tek ders değeri girildi ve
 *       puan DÜŞÜK görünür.
 *   MADDE 11/5 "yazar sayısı beşten fazla ise tam puanın %30'u verilir"
 *       kuralı Tablo-3'ün (isim sırası yüzdeleri) yerine geçen bir tavan;
 *       yazar matrisinde `sonrasi: 0.30` ile karşılandı.
 *
 * Yönerge: yonerge/bartin.php
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 */

return [
    'kapsam_notu' => 'Puanlar Bartın Üniversitesi Tablo-3 Yayın-Faaliyet Puanlama Tablosundan. '
        .'DİKKAT: bu üniversitede atama bir PUAN BARAJINA değil, ÖLÇÜT SAYISINA bağlı — yönerge '
        .'"şu ölçütlerin en az dördünü/onunu sağlamış olmak" diyor ve toplam puan için hiçbir '
        .'eşik koymuyor. Burada gördüğünüz toplam, başvuru formunda beyan edeceğiniz puandır; '
        .'atanma kararını tek başına belirlemez. '
        .'Yazar çarpanı MADDE 11 uyarınca isim sırasına göre işliyor ve yazar sayısı beşten '
        .'fazlaysa tam puanın %30\'u veriliyor (sorumlu yazar birinci isim sayılır). Yazar '
        .'listesini boş bırakırsanız çarpan hiç uygulanmaz ve puanınız olduğundan YÜKSEK '
        .'görünür. Yönerge ayrıca bilimsel faaliyetlerin tümünde yazar sayısının sekizi '
        .'geçmemesini şart koşuyor; bu sınır hesaplanmıyor. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: sonuçlanmış ve devam eden proje '
        .'satırları tek kayda düştüğü için devam eden değerle sayılıyor; kitap editörlüğü ile '
        .'yardımcı editörlüğü, uluslararası ile ulusal atıf, tez jürisi türleri ve davetli '
        .'konuşmacılık gibi satır çiftleri düşük olanla birleşti; h-indeksi, arkeolojik kazı, '
        .'yurt dışı araştırma süresi, sportif faaliyetler, üniversitenin ihtisas alanı '
        .'projeleri ve etkinlik düzenleme görevleri hiç girilemedi; idari görevlerin ve '
        .'derslerin yıl biriktirmesi uygulanmıyor. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünebilir: idari görev puanının diğer '
        .'bölümlerin %10\'unu aşamayacağı sınırı uygulanmıyor; tescilli patent, faydalı model '
        .'ve endüstriyel tasarım satırları BAŞVURU aşamasındaki kayıtları ayıramıyor, o yüzden '
        .'yalnızca TESCİLLİ olanları kaydedin.',

    // MADDE 11/5-6: isim sırasına göre yüzde (Tablo-3), yazar sayısı beşten
    // fazlaysa tam puanın %30'u; "Corresponding Author" birinci isim sayılır.
    // Tablo-3'ün kendisi PDF'te görüntü olarak duruyor ve metin olarak
    // çıkmıyor; bu yüzden yalnızca metinde YAZILI olan iki kural girildi:
    // beşten fazla yazarda %30 ve sorumlu yazarın birinci isim sayılması.
    // Beş ve daha az yazarda sıraya göre kademe bilinmediğinden çarpan
    // uygulanmıyor — puan bu aralıkta olduğundan YÜKSEK görünebilir.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev',
            'odul', 'editorluk', 'toplumsal_katki'],
        'roller' => (function (): array {
            $besUstu = ['kademeler' => [1 => 1.0, 2 => 1.0, 3 => 1.0, 4 => 1.0, 5 => 1.0], 'sonrasi' => 0.30];

            return [
                'tek' => ['kademeler' => [1 => 1.0]],
                'ilk' => $besUstu,
                // "Corresponding Author birinci isim gibi değerlendirilir."
                'baslica' => $besUstu,
                'yazar_2' => $besUstu,
                'yazar_3' => $besUstu,
                'yazar_4' => $besUstu,
                'yazar_5' => $besUstu,
                'yazar_6' => $besUstu,
                'ortak' => $besUstu,
            ];
        })(),
    ],

    'maddeler' => [
        // ══ A. MAKALELER ══
        'A.1.a' => ['baslik' => 'Q1 kategorisindeki dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale'], 'puan' => 300],
        'A.1.b' => ['baslik' => 'Q2 kategorisindeki dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale'], 'puan' => 240],
        'A.1.c' => ['baslik' => 'Q3 kategorisindeki dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale'], 'puan' => 180],
        // Çeyrekliği bilinmeyen AHCI kaydı en düşük çeyrekliğe konuldu:
        // yönergenin Q tanımı AHCI dergilerini de kapsıyor ama kayıt
        // çeyreklik taşımıyor.
        'A.1.d' => ['baslik' => 'Q4 kategorisindeki dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 120],
        // Aynı dergilerdeki DERLEME için ayna satırlar; puanlar birebir aynı,
        // tek işlevleri ölçütlerdeki "araştırma makalesi" / "araştırma ya da
        // derleme makalesi" ayrımını taşımak. Kodların '-derleme' eki bize ait.
        'A.1.a-derleme' => ['baslik' => 'Q1 kategorisindeki dergide derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['derleme'], 'puan' => 300],
        'A.1.b-derleme' => ['baslik' => 'Q2 kategorisindeki dergide derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['derleme'], 'puan' => 240],
        'A.1.c-derleme' => ['baslik' => 'Q3 kategorisindeki dergide derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['derleme'], 'puan' => 180],
        'A.1.d-derleme' => ['baslik' => 'Q4 kategorisindeki dergide derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme'], 'puan' => 120],
        'A.2' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale'], 'puan' => 100],
        'A.4' => ['baslik' => 'Diğer uluslararası hakemli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale'], 'puan' => 80],
        'A.5' => ['baslik' => 'ULAKBİM TR Dizin\'de taranan ulusal hakemli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 70],
        'A.6' => ['baslik' => 'Diğer ulusal hakemli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale'], 'puan' => 60],
        'A.7' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['derleme'], 'puan' => 60],
        'A.9' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI kapsamındaki dergide teknik not, mektup, tartışma, vaka takdimi veya özet', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 40],
        'A.8-A.10' => ['baslik' => 'Diğer uluslararası hakemli dergide derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['derleme'], 'puan' => 40],
        'A-ULUSAL-DERLEME' => ['baslik' => 'ESCI, Scopus veya diğer uluslararası indeks dışındaki hakemli dergide derleme, kısa makale veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 20],

        // ══ B. PROJELER (sonuçlanmış/devam eden çiftleri birleştirildi) ══
        'B.1-B.3' => ['baslik' => 'Dünya Bankası, Avrupa Birliği veya Avrupa Konseyine bağlı ajanslarca desteklenen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 400],
        'B.2-B.4' => ['baslik' => 'Dünya Bankası, Avrupa Birliği veya Avrupa Konseyine bağlı ajanslarca desteklenen projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 300],
        'B.5-B.7' => ['baslik' => 'Diğer uluslararası özel veya resmi kuruluşça desteklenen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 150],
        'B.6-B.8' => ['baslik' => 'Diğer uluslararası özel veya resmi kuruluşça desteklenen projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 100],
        'B.9' => ['baslik' => 'Diğer uluslararası özel veya resmi kuruluşça desteklenen projede yürütücü ve araştırmacı dışında görev', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['danisman'], 'puan' => 50],
        'B.10' => ['baslik' => 'TÜBA, TÜBİTAK, Kalkınma Bakanlığı veya TÜSEB destekli sonuçlandırılmış projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 400],
        'B.11' => ['baslik' => 'TÜBA, TÜBİTAK, Kalkınma Bakanlığı veya TÜSEB destekli sonuçlandırılmış projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 300],
        'B.12' => ['baslik' => 'TÜBA, TÜBİTAK, Kalkınma Bakanlığı veya TÜSEB destekli sonuçlandırılmış projede yürütücü ve araştırmacı dışında görev', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['danisman'], 'puan' => 100],
        'B.13' => ['baslik' => 'Yükseköğretim kurumunca desteklenen sonuçlandırılmış bilimsel araştırma projesinde (BAP) yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 90],
        'B.14' => ['baslik' => 'Yükseköğretim kurumunca desteklenen sonuçlandırılmış bilimsel araştırma projesinde (BAP) araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 45],
        'B.19-B.20' => ['baslik' => 'Diğer kamu veya özel kuruluşça desteklenen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 60],
        'B.21-B.22' => ['baslik' => 'Diğer kamu veya özel kuruluşça desteklenen projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 40],
        'B.23-B.24' => ['baslik' => 'Diğer kamu veya özel kuruluşça desteklenen projede yürütücü ve araştırmacı dışında görev', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['danisman'], 'puan' => 20],

        // ══ C. KİTAPLAR VE ANSİKLOPEDİ MADDELERİ ══
        'C.1' => ['baslik' => 'Alanında uluslararası yayımlanan bilimsel, eğitsel veya sanatsal kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 200],
        'C.2' => ['baslik' => 'Alanında ulusal yayımlanan bilimsel, eğitsel veya sanatsal kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 180],
        'C.3-C.4' => ['baslik' => 'Alanında yayımlanan ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 80],
        'C.5-C.6' => ['baslik' => 'Alanında uluslararası yayımlanan kitapta editörlük veya yardımcı editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 120],
        'C.7-C.8' => ['baslik' => 'Alanında ulusal yayımlanan kitapta editörlük veya yardımcı editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 100],
        'C.9' => ['baslik' => 'Alanında uluslararası yayımlanan kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 100],
        'C.10' => ['baslik' => 'Alanında ulusal yayımlanan kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 60],
        'C.11' => ['baslik' => 'Alanında yayımlanmış tam kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 80],
        'C.12' => ['baslik' => 'Alanında kitap bölümü veya makale çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 40],
        'C.14' => ['baslik' => 'Ansiklopedi madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 20],
        'C.13-Ç' => ['baslik' => 'Yayımlanmış kitap değerlendirme yazısı, eleştiri yazısı, katalog yazısı veya biyografi', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 20],

        // ══ D. KAMU-ÜNİVERSİTE-SANAYİ İŞBİRLİĞİ ══
        'D.1' => ['baslik' => 'Teknopark, TEKMER veya teknokentte en az 3 yıl faaliyet gösteren şirket sahibi ya da ortağı olmak', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 100],
        'D.2' => ['baslik' => 'Teknopark, TEKMER veya teknokentte faaliyet gösteren şirkette danışmanlık', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı'], 'puan' => 50],

        // ══ E-F. PATENT, FAYDALI MODEL, ENDÜSTRİYEL TASARIM (başvurular girilmedi) ══
        'E.1' => ['baslik' => 'Uluslararası tescillenmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 1000],
        'E.2' => ['baslik' => 'Ulusal tescillenmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 500],
        'F.1' => ['baslik' => 'Tescillenmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 500],
        'F.3' => ['baslik' => 'Tescillenmiş endüstriyel tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım', 'Yazılım'], 'puan' => 300],

        // ══ G. ATIFLAR ══
        'G.1-G.2' => ['baslik' => 'Yazar olarak yer almadığınız kitapta eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
        'G.3' => ['baslik' => 'SCI, SCI-Expanded, SSCI, AHCI veya ESCI kapsamındaki dergide, yazar olarak yer almadığınız makalede eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 5],
        'G.4' => ['baslik' => 'Diğer uluslararası dergide, yazar olarak yer almadığınız makalede eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer'], 'puan' => 3],
        'G.5' => ['baslik' => 'Hakemli ulusal dergide, yazar olarak yer almadığınız makalede eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Patent'], 'puan' => 2],

        // ══ I. BİLİMSEL ETKİNLİK ÇALIŞMALARI ══
        'I.1' => ['baslik' => 'Uluslararası bilimsel etkinlikte sözlü sunulan ve tam metin yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 40],
        'I.2' => ['baslik' => 'Uluslararası bilimsel etkinlikte sözlü sunulan ve özet yayımlanan ya da poster olarak sergilenen bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 20],
        'I.6' => ['baslik' => 'Ulusal bilimsel etkinlikte sözlü sunulan ve tam metin yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 15],
        'I.7' => ['baslik' => 'Ulusal bilimsel etkinlikte sözlü sunulan ve özet yayımlanan ya da poster olarak sergilenen bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 10],
        'I.4-I.9' => ['baslik' => 'Bilimsel etkinlikte davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 15],

        // ══ İ. LİSANSÜSTÜ EĞİTİM FAALİYETLERİ ══
        'İ.1' => ['baslik' => 'Tamamlanmış doktora tez danışmanlığı (asıl danışman)', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 100],
        'İ.2' => ['baslik' => 'Tamamlanmış yüksek lisans tez danışmanlığı (asıl danışman)', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 50],
        'İ.3' => ['baslik' => 'Tamamlanmış doktora tez danışmanlığı (eş danışman)', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 50],
        'İ.4' => ['baslik' => 'Tamamlanmış yüksek lisans tez danışmanlığı (eş danışman)', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 20],
        'İ.5-İ.7' => ['baslik' => 'Lisansüstü tez savunmasında, doktora yeterlik sınavında veya tez izleme komitesinde jüri üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 10],

        // ══ J. EDİTÖRLÜK VE HAKEMLİK ══
        'J.1' => ['baslik' => 'SCI, SCI-Expanded, SSCI, AHCI veya ESCI kapsamındaki dergide en az iki yıl süreyle editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 60],
        'J.2' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide alan editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 40],
        'J.3' => ['baslik' => 'SCI, SSCI, AHCI ve ESCI kapsamı dışındaki uluslararası dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 20],
        'J.4' => ['baslik' => 'ULAKBİM tarafından taranan ulusal dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 20],
        'J.5-J.7' => ['baslik' => 'Dergi hakemliği veya yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik', 'Yayın Kurulu Üyeliği'], 'puan' => 5],

        // ══ K. ÖDÜLLER ══
        'K.1' => ['baslik' => 'TÜBA, TÜBİTAK (yayın teşvik ödülü hariç) veya TÜSEB\'den alınan ödül', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 200],
        'K.2' => ['baslik' => 'Alanında yurt dışı kurum ve kuruluşlardan alınan bilim ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 150],
        'K.3-K.6' => ['baslik' => 'Alanında yurt içi kamu, özel kurum veya kuruluşlardan alınan bilim ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'YÖK Ödülü'], 'puan' => 60],
        'K.4-K.5-R.7' => ['baslik' => 'Bilimsel veya sanatsal etkinlikte bilim/sanat kurulunca verilen ödül ya da tasarım yarışmasında derece veya mansiyon', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 30],

        // ══ L. İDARİ GÖREVLER (yalnızca bir yıllık taban değeri) ══
        'L.1' => ['baslik' => 'Dekanlık, enstitü, yüksekokul, meslek yüksekokulu veya uygulama ve araştırma merkezi müdürlüğü ya da üniversite genel koordinatörlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 100],
        'L.2' => ['baslik' => 'Dekan yardımcılığı, enstitü veya yüksekokul müdür yardımcılığı ya da bölüm başkanlığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkanı'], 'puan' => 80],
        'L.3' => ['baslik' => 'Öğrencisi olan anabilim dalı başkanlığı, bölüm başkan yardımcılığı veya merkez müdür yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı'], 'puan' => 60],
        'L.5-L.6' => ['baslik' => 'Rektörlük veya dekanlık tarafından yapılan kurul, komisyon ve koordinatörlük görevlendirmeleri', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 15],
        'L.8' => ['baslik' => 'Hizmet içi eğitim veya sertifika programında konuşmacı olarak görev almak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Bilim İletişimi / Popüler Yayın', 'Topluma Hizmet Projesi'], 'puan' => 10],

        // ══ M. EĞİTİM-ÖĞRETİM FAALİYETLERİ ══
        'M.1' => ['baslik' => 'Lisansüstü seviyede verilen ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 10],
        'M.2-M.3' => ['baslik' => 'Lisans veya ön lisans seviyesinde verilen ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 4],

        // ══ O. GÜZEL SANATLAR FAALİYETLERİ ══
        'O.1' => ['baslik' => 'Özgün sanat eseri, beste, tasarım veya yorum çalışmasının yurt dışında satın alınması, yayın organlarında yer alması, gösterime girmesi ya da tasarım projesinin yurt dışında uygulanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Yayında Yer Alması / Satın Alınması', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)'], 'puan' => 120],
        'O.7' => ['baslik' => 'Özgün sanat eseri, beste, tasarım veya yorum çalışmasının yurt içinde satın alınması, yayın organlarında yer alması, gösterime girmesi ya da tasarım projesinin kamu kurumlarınca uygulanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Satın Alınması (Yurt İçi)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'], 'puan' => 60],
        'O.2-O.3' => ['baslik' => 'Uluslararası jürili karma sanat veya tasarım etkinliğinde yer almak ya da kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)'], 'puan' => 40],
        'O.4' => ['baslik' => 'Yurt dışında kişisel sanat veya tasarım etkinliğinde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)'], 'puan' => 40],
        'O.5-O.6' => ['baslik' => 'Yurt içinde kişisel sanat veya tasarım etkinliğinde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 20],
        'O.8-O.9' => ['baslik' => 'Ulusal jürili yurt dışı karma sanat veya tasarım etkinliğinde yer almak ya da kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Ulusal Jürili)'], 'puan' => 30],
        'O.10' => ['baslik' => 'Yurt içinde jürili karma sanat veya tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 20],
        'O.11' => ['baslik' => 'Yurt dışında karma veya grup sanat/tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Karma Sergi (Uluslararası)'], 'puan' => 20],
        'O.12' => ['baslik' => 'Yurt içinde karma veya grup sanat/tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Jürisiz, Ulusal)', 'Özgün Eser / Beste / Tasarım'], 'puan' => 10],
        'O.13' => ['baslik' => 'Uluslararası sempozyum, festival, çalıştay, bienal veya trienal gibi sanat/tasarım etkinliğine eserle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 30],
        'O.14' => ['baslik' => 'Ulusal sempozyum, festival, çalıştay, bienal veya trienal gibi sanat/tasarım etkinliğine eserle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 20],
        'O.15-O.16' => ['baslik' => 'Sahne sanatlarında (dans, bale, tiyatro, halk oyunları) sanat grubu hazırlamak ve gösterimini sağlamak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Dansçı / Performans İcracısı (Uluslararası)', 'Dansçı / Performans İcracısı (Ulusal)', 'Koreografi', 'Yönetmenlik (Sahne/Ekran)', 'Rejisörlük (Uluslararası)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Sahne Tasarımı (Dekor, Kostüm, Işık)'], 'puan' => 15],
        'O.17' => ['baslik' => 'Uluslararası sanat veya tasarım etkinliğinde jüri olarak görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], 'puan' => 15],
        'O.18' => ['baslik' => 'Ulusal sanat veya tasarım etkinliğinde jüri olarak görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 10],

        // ══ R. PLANLAMA, MİMARLIK, KENTSEL VE PEYZAJ TASARIM ══
        'R.1-R.6' => ['baslik' => 'Mimarlık, planlama ve tasarım alanında ürettiğiniz bir uygulama projesi hakkında hakemli dergide makale ya da tanınmış yayınevinde kitap veya kitap bölümü yayımlanmış olması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman', 'Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)'], 'puan' => 40],
        // Kaynak satırı KAPSAMSIZ ("Olimpik spor federasyonlarının kurullarında
        // görev") — uluslararası/ulusal ayrımı yapmıyor, bu yüzden iki etiket
        // de aynı satırdan sayılır. Önce yalnız uluslararası etiket bağlıydı,
        // ulusal federasyon kurulu görevi olan aday hiç puan almıyordu.
        'N.6' => ['baslik' => 'Olimpik spor federasyonunun kurullarında görev', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Spor Federasyonu Kurul Üyeliği (Uluslararası)', 'Spor Federasyonu Kurul Üyeliği (Ulusal)'], 'puan' => 60],
        'I.8' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Ulusal)'], 'puan' => 20],
        'I.3' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 40],
        'I.11' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 5],
        // Kaynak I.5 uluslararası 10, I.10 ulusal 5, I.12 ÜNİVERSİTE İÇİ 3 diyor; satır üniversite içi değere yazılmıştı.
        'I.12' => ['baslik' => 'Uluslararası bilimsel ya da sanatsal toplantıda oturum başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Uluslararası)'], 'puan' => 10],
        'I.12-ulusal' => ['baslik' => 'Ulusal bilimsel ya da sanatsal toplantıda oturum başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Ulusal)'], 'puan' => 5],
    ],

    // Ölçütlerin andığı kümeler. Kod uzayı nokta ve harf karışık olduğu için
    // desen değil TEK TEK KOD yazıldı; 'A.1*' deseni 'A.1.a-derleme'yi de
    // yakalar ve araştırma/derleme ayrımını bozardı.
    'gruplar' => [
        'A-TUM' => ['A.*'],
        // Ölçüt 1: "Q1 kategorisindeki dergilerde araştırma makalesi".
        'Q1-ARASTIRMA' => ['A.1.a'],
        'Q2-ARASTIRMA' => ['A.1.b'],
        // Ölçüt 1.a: "Q4 kategorisinde olmaması koşuluyla" — Q1, Q2, Q3.
        'Q1-Q3-ARASTIRMA' => ['A.1.a', 'A.1.b', 'A.1.c'],
        // Ölçüt 2: "SCI, SSCI, SCI-Expanded, AHCI kapsamındaki veya Scopus veri
        // tabanında taranan dergilerde araştırma ya da derleme makalesi".
        'WOS-SCOPUS-MAKALE' => ['A.1.a', 'A.1.b', 'A.1.c', 'A.1.d',
            'A.1.a-derleme', 'A.1.b-derleme', 'A.1.c-derleme', 'A.1.d-derleme',
            'A.2', 'A.7'],
        'WOS-SCOPUS-ARASTIRMA' => ['A.1.a', 'A.1.b', 'A.1.c', 'A.1.d', 'A.2'],
        'ESCI-ARASTIRMA' => ['A.2'],
        // Tablo-2 ölçüt 21.a ve 22.a'nın ikinci dalı: "uluslararası dergilerde
        // yayımlanmış bir araştırma makalesi".
        'ULUSLARARASI-ARASTIRMA' => ['A.1.a', 'A.1.b', 'A.1.c', 'A.1.d', 'A.2', 'A.4'],
        // Ölçüt 4 / 4.a: uluslararası hakemli dergide araştırma ya da derleme.
        'ULUSLARARASI-HAKEMLI' => ['A.2', 'A.4', 'A.7', 'A.8-A.10'],
        'TR-DIZIN-ARASTIRMA' => ['A.5'],
        // Ölçüt 5.a: derleme, mektup, eleştiri, katalog yazısı, kitap
        // değerlendirme veya biyografi.
        'DERLEME-ELESTIRI' => ['A.7', 'A.8-A.10', 'A-ULUSAL-DERLEME',
            'A.1.a-derleme', 'A.1.b-derleme', 'A.1.c-derleme', 'A.1.d-derleme',
            'A.9', 'C.13-Ç'],
        'CEVIRI-KITAP' => ['C.11'],
        'CEVIRI-BOLUM' => ['C.12'],
        'ULUSLARARASI-KITAP' => ['C.1'],
        'ULUSLARARASI-BOLUM' => ['C.9'],
        'ULUSLARARASI-EDITORLUK' => ['C.5-C.6'],
        'ULUSAL-KITAP' => ['C.2'],
        'ULUSAL-BOLUM' => ['C.10'],
        'ULUSAL-EDITORLUK' => ['C.7-C.8'],
        'KITAP-BOLUM-TUM' => ['C.9', 'C.10'],
        'ANSIKLOPEDI' => ['C.14'],
        'ULUSLARARASI-BILDIRI' => ['I.1', 'I.2'],
        'ULUSAL-BILDIRI' => ['I.6', 'I.7'],
        'TAM-METIN-BILDIRI' => ['I.1', 'I.6'],
        // Ölçüt 8 / Tablo-2 ölçüt 7: TÜBİTAK, TÜSEB ve AB destekli projeler.
        'BUYUK-PROJE' => ['B.1-B.3', 'B.2-B.4', 'B.5-B.7', 'B.6-B.8', 'B.9',
            'B.10', 'B.11', 'B.12'],
        'AB-PROJE' => ['B.1-B.3', 'B.2-B.4'],
        'KUCUK-PROJE' => ['B.13', 'B.14', 'B.19-B.20', 'B.21-B.22', 'B.23-B.24'],
        'BAP' => ['B.13', 'B.14'],
        'BAP-YURUTUCU' => ['B.13'],
        'PATENT-TESCIL' => ['E.1', 'E.2', 'F.1', 'F.3'],
        'ATIF-TUM' => ['G.1-G.2', 'G.3', 'G.4', 'G.5'],
        'TEZ-DANISMANLIK' => ['İ.1', 'İ.2', 'İ.3', 'İ.4'],
        'ODUL-ULUSLARARASI-KURUM' => ['K.1'],
        'ODUL-ULUSAL' => ['K.2', 'K.3-K.6', 'K.4-K.5-R.7'],
        'WOS-EDITORLUK' => ['J.1'],
        'ESCI-EDITORLUK' => ['J.2'],
        'DIGER-EDITORLUK' => ['J.3', 'J.4'],
        'HAKEMLIK' => ['J.5-J.7'],
        'LISANS-DERS' => ['M.2-M.3'],
        'TUM-DERS' => ['M.1', 'M.2-M.3'],
        // Ölçüt 11 / Tablo-2 ölçüt 11: sanat etkinlikleri.
        'SANAT-ULUSLARARASI-KARMA' => ['O.2-O.3'],
        'SANAT-KISISEL-YURTDISI' => ['O.4'],
        'SANAT-ULUSAL-KARMA' => ['O.8-O.9', 'O.10', 'O.11', 'O.12'],
        'SANAT-KISISEL-YURTICI' => ['O.5-O.6'],
        'MIMARLIK-UYGULAMA' => ['R.1-R.6'],
    ],
];
