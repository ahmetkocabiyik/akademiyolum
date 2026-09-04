<?php

/**
 * İSTANBUL SABAHATTİN ZAİM ÜNİVERSİTESİ — EK-I: Akademik Yükseltilme ve Atama
 * Kriterleri Puan Tablosu
 * Kaynak: pdf/17537100932.istanbulsabahattinzaimuniversitesi.pdf
 *
 * DOSYA ADINDAKİ YIL PDF'TEN GELİYOR: belgede kabul tarihi, karar numarası ya
 * da yürürlük maddesi yok. 2019, PDF'in oluşturma tarihi (14/05/2019).
 *
 * MADDE KODLARI yönergenin kendi bölüm harflerini ve numaralarını koruyor;
 * koşullar tabloya HARF ARALIĞIYLA atıf yapıyor ("A-J kategorileri arasından",
 * "A-C kategorileri arasından en az 100 olmak üzere A-U kategorileri arasından
 * en az 500 puan"). Aralıklar `gruplar` altında tek tek sayıldı — aralık
 * deseni ('A..U') cetveldeki SIRAYA bakıyor, harf sırasına değil.
 *
 * TÜRKÇE ALFABE TUZAĞI: "A-J" aralığı I ile J arasındaki İ'yi de kapsıyor
 * (ulusal atıflar), "A-U" ise V (güzel sanatlar) ile Y'yi (idari) DIŞARIDA
 * bırakıyor. Bu yüzden bölüm harfleri gruplarda elle sayıldı.
 *
 * ── YAZAR PAYLAŞIMI KURALI YOK ──
 * Yönergenin tamamında (ölçüt metni + EK-I) çok yazarlı çalışmalarda puanın
 * nasıl bölüneceğine dair TEK BİR CÜMLE geçmiyor: ne "1,5 × puan / n" gibi bir
 * formül, ne yazar sırasına göre kademe. `yazar_katsayisi` bu yüzden hiç
 * tanımlanmadı — uydurulmuş bir bölme, yönergede olmayan bir kısıt olurdu.
 * Sonuç: puanlar tam veriliyor ve korpustaki yazar çarpanı olan yönergelere
 * göre yüksek görünüyor. Bu bir veri hatası değil, yönergenin kendi tercihi;
 * kapsam notunda söylendi. (Karşılaştırma için R.1 ve R.3 ödül satırları
 * "her bir araştırmacıya" diyor — yönerge paylaşımı istediği tek yerde bunu
 * açıkça yazıyor.)
 *
 * ── PDF METİN KATMANINDAKİ RAKAM BOZULMALARI (düzeltildi) ──
 * Bazı madde numaralarında rakam harfe dönüşmüş. Hepsi bölüm içindeki SIRA
 * konumundan tereddütsüz okunuyor; kodlar sıraya göre normalleştirildi:
 *   'GB'  → G.3   (G.1, G.2'den sonra)      'LA'   → L.4  (L.3'ten sonra)
 *   'RB'  → R.8   (R.7'den sonra)           'SA'   → S.4  (S.3'ten sonra)
 *   'VB'  → V.8   (V.7'den sonra)           'V.IO' → V.10 · 'V.II' → V.11
 *   I bölümünün '1.1, 1.2, 1.3' kodları → I.1, I.2, I.3
 * A.6 satırı "AB'deki dergilerde derleme" diyor; A.4 = A.1'in yarısı (60),
 * A.5 = A.2'nin yarısı (40), A.6 = 30 = A.3'ün yarısı olduğu için "A.3'teki"
 * okundu. Bu bir yorum değil, bölümün kendi yarılama düzeninin sonucu.
 *
 * ── DERLEME VE KISA YAYIN SATIRLARI ÖZDEŞ PUANDA ──
 * A.4-A.6 (derleme) ile A.8 (teknik not, editöre mektup, tartışma, vaka
 * takdimi, özet) aynı dergi kademelerinin yarısını veriyor: 60/40/30. A.8 tek
 * satırda üç puan taşıdığı için üçe bölündü; alt kodlar (a-c) BİZE AİT.
 *
 * ── C BÖLÜMÜ (ULUSLARARASI KİTAPLAR) TAMAMEN BOŞ KALDI ──
 * C.1-C.4'ün dördü de yurt dışı/yurt içi ayrımına dayanıyor ve kaynak kaydı bu
 * ayrımı taşımıyor; kural gereği dördü de H bölümünün düşük satırlarına düştü.
 * Sonucu önemli: doçentlik ve profesörlüğün "A-C kategorilerinden en az 100 /
 * 200 puan" alt kapısı pratikte YALNIZCA uluslararası makale ve bildiriden
 * besleniyor, kitaplar o kapıya girmiyor. Kapı ulaşılamaz değil (iki SCI
 * makalesi 240 puan eder) ama kitap ağırlıklı alanlarda OLDUĞUNDAN ZOR
 * görünür. Aday notunda söylendi.
 *
 * ── AYNI KAYNAĞA DÜŞEN SATIRLARDA DAİMA DÜŞÜĞÜ GİRİLDİ ──
 *   Kitap C.1 yurt dışı (150) / H.1 ulusal (70): 'Uluslararası/Ulusal Kitap'
 *       ve 'BKCI / Scopus Kitap' yayın yerini söylemiyor → H.1. Bölümde
 *       C.2 (50) / H.2 (35) → H.2. Editörlükte C.3 (100) / H.3 (40) → H.3.
 *   Rapor C.4 uluslararası (40) / H.4 ulusal (25) → H.4.
 *   Bildiri B.2 yayımlanmış özet (20) / B.3 sözlü sunum-poster (10):
 *       'Uluslararası Özet/Poster' ikisini ayıramıyor → B.3. Ulusalda
 *       G.2 (15) yerine G.3 (10).
 *   Ders kitabı I.1 yabancı dil (60) / I.2 Türkçe (40): 'Ders / Metot Kitabı'
 *       dili söylemiyor → I.2. I.3 "YARDIMCI ders kitabı" ayrı bir tür;
 *       kaynak etiketi "Ders / Metot Kitabı" o niteleyiciyi taşımadığı için
 *       ikame edilmedi.
 *   Dergi görevi M editörlük (120) / N hakemlik (40): 'WoS Dergi (Q1-Q4)' ve
 *       'ESCI / Scopus Dergi' derginin düzeyini söylüyor, görevi değil → N.
 *       Diğer dergilerde O (50) / P (15) → P.
 *   Ödül R.1 uluslararası derece (120) / mansiyon (60) / R.3 ulusal derece
 *       (60) / mansiyon (30): 'Yarışma Derecesi / Mansiyon' ne düzeyi ne
 *       dereceyi taşıyor → en düşük satır R.3.b.
 *   Burs R.6 uluslararası (90) / R.7 ulusal (60) → R.7.
 *   Davetli konuşmacı U.3 uluslararası (40) / U.4 ulusal (20) → U.4.
 *   Jüri üyeliği U.9 tek satır (5); uluslararası/ulusal ayrımı yok.
 *   Proje L.3 TÜBİTAK-DPT (90) / L.5 BAP (50): 'Özel Sektör / STK' ikisinden
 *       birine girmiyor → düşük olan L.5.
 *   Atıf E uluslararası (12) / İ ulusal (6): 'Diğer' ve 'Patent' atıf
 *       kaynakları düzeyi söylemiyor → İ.
 *
 * ── ATIF PUANI OLDUĞUNDAN YÜKSEK ÇIKAR ──
 * E ve İ bölümleri puanı "atıf yapılan her ESER için" veriyor, her atıf için
 * değil. Faaliyet kaydı atıf sayısını tutuyor; bu ayrım kayıttan türetilemiyor.
 * Karabük'te de aynı sapma var.
 *
 * ── DERS VE İDARİ GÖREV PUANI ──
 * T.1 ve T.2 "son 3 yılda verilen her ders için, en fazla 15 ders" diyor;
 * motor ne madde bazında kayan pencere ne adet tavanı tutuyor, ders puanı
 * YÜKSEK çıkar. Y bölümü ise tersine: puan "30 × yıl sayısı" biçiminde
 * veriliyor, cetvel sabit sayı tuttuğu için görevini tek kayıtla giren adayın
 * idari puanı bir yıllık sayılır ve DÜŞÜK çıkar.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   A.3 / A.6 / A.7 / A.8.c — "diğer uluslararası hakemli dergiler", yani
 *       indekslenmemiş uluslararası dergiler. Kaynak sözlüğünde bu kademe yok
 *       ('Diğer Uluslararası İndeks' A.2'ye, 'Diğer Ulusal Hakemli' F.2'ye
 *       düşüyor). A.7'nin Türkçe/yabancı dil ayrımı da bu yüzden konusuz.
 *   D.3 makale çevirisi — sözlükte makale çevirisi kaynağı yok.
 *   R.2 / R.4 kongre derecesi, R.8 yurt dışı deneyimi, S.3 / S.4 ikinci
 *       danışmanlık, S.6 tezsiz proje yöneticiliği, U.11 tanıtım faaliyeti.
 *   U.1 / U.2 / U.5 / U.6 / U.7 / U.8 bilimsel toplantı düzenleme, görev alma
 *       ve oturum başkanlığı — sözlükte kongre düzenleme kaynağı yok.
 *   J dışındaki sınai haklar ('Faydalı Model', 'Endüstriyel Tasarım',
 *       'Yazılım', 'Islahçı Hakkı', 'Ticarileştirme') — yönerge yalnızca
 *       "patent" diyor.
 *   V.12 / V.13 sahne sanatları grubu hazırlamak ve konservatuvara özgü icra
 *       kaynakları (opera, bale, koreografi, rejisörlük, şeflik, kompozisyon,
 *       orkestra ve oda müziği üyeliği) — V bölümü eser sunma ve etkinliğe
 *       kabul üzerine kurulu, icra satırı yok.
 *   'Yayın Kurulu Üyeliği', 'Ansiklopedi Maddesi', 'Akreditasyon Faaliyeti',
 *       'Özgün Eser / Beste / Tasarım' — tabloda karşılık satırı YOK.
 *   Ulusal dergilerde kısa yayın (teknik not, editöre mektup, vaka takdimi):
 *       F bölümü yalnızca "tam makale" diyor, yarım puan kuralı ulusal
 *       tarafta yok.
 *
 * Yönerge: yonerge/istanbul-zaim.php
 */

/*
 * V. BÖLÜM YALNIZCA GÜZEL SANATLAR TEMEL ALANINDA (04.09.2026'da düzeltildi).
 *
 * Kaynağın bölüm başlığı: "V. UYGULAMALI FAALİYETLER (Güzel Sanatlar Temel
 * Alanında)". Cetvel on iki temel alanın tamamına bağlıydı ve profesörlük
 * eşiğinin toplam barajı `Kalip::toplam()` varsayılanıyla BÜTÜN maddeleri
 * sayıyor — yani mimarlık, sosyal ya da eğitim adayının sanatsal etkinlik
 * kaydı 100 puana kadar barajı besliyordu (§0). `A-U` grubu V'yi zaten
 * dışarıda bırakıyordu ama toplam barajı bırakmıyordu.
 *
 * Kısıt burada FAKÜLTEYE değil TEMEL ALANA bağlı, yani motorun `alan`
 * ekseniyle birebir ifade edilebiliyor: cetvel iki varyanta ayrıldı ve V
 * yalnız `guzel_sanatlar` varyantında duruyor.
 */
$govde = function (bool $guzelSanatlar): array {
    $cetvel = [
        'kapsam_notu' => 'Puanlar İstanbul Sabahattin Zaim Üniversitesi EK-I tablosundan. '
            .'YÖNERGENİN ÇOK YAZARLI ÇALIŞMALAR İÇİN PAYLAŞIM KURALI YOK: metnin hiçbir yerinde '
            .'puanın yazar sayısına ya da sıraya göre bölüneceği yazmıyor, bu yüzden puanlar tam '
            .'veriliyor. Yazar çarpanı olan üniversitelerle karşılaştırırken bunu hesaba katın. '
            .'Barajlar bölüm harfi aralıklarıyla tanımlı: uluslararası makale, bildiri ve kitap '
            .'(A-C), bunların üstüne çeviri, atıf, ulusal yayın, ders kitabı ve patent (A-J), '
            .'sonra proje, editörlük, ödül, tez, ders ve etkinlikler (A-U); güzel sanatlar '
            .'uygulamaları ile idari görevler yalnızca genel toplama giriyor. '
            .'ULUSLARARASI KİTAPLARINIZ ALT KAPIYA SAYMIYOR: yönergenin uluslararası kitap '
            .'satırları kitabın yurt dışında ve tanınmış bir yabancı yayınevince basılmış '
            .'olmasını şart koşuyor, kaydınız bu ayrımı tutmadığı için kitaplarınız ulusal kitap '
            .'satırına düşüyor. Kitaplarınız genel toplama girer ama uluslararası makale ve '
            .'bildiri alt kapısına (doçentlikte 100, profesörlükte 200 puan) girmez; kitap '
            .'ağırlıklı alanlarda bu kapı olduğundan zor görünür. '
            .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: indekslenmemiş uluslararası '
            .'hakemli dergilerdeki makaleler, makale çevirisi, kongre derecesi, yurt dışı '
            .'deneyimi, ikinci tez danışmanlığı, bilimsel toplantı düzenleme ve oturum '
            .'başkanlığı, faydalı model ve tasarım tescili girilemedi. Yurt dışı ile yurt içi '
            .'ayrımını taşımayan kalemlerde (kitap, kitap bölümü, editörlük, rapor, bildiri özeti, '
            .'ders kitabı, ödül, burs, davetli konuşmacı, atıf) düşük satır kullanıldı. Dergi '
            .'editörlüğü ve hakemliğinde kaydınız görevinizi değil derginin düzeyini tuttuğu için '
            .'hakemlik satırı uygulanır. İdari görev puanı yönergede "yıl sayısıyla çarpılarak" '
            .'veriliyor; görevinizi tek kayıtla girerseniz bir yıllık sayılır. '
            .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK çıkabilir: atıf puanı yönergede "atıf '
            .'yapılan her ESER için" veriliyor, kayıt ise atıf sayısını tutuyor; ders puanında da '
            .'"son 3 yıl" ve "en fazla 15 ders" sınırları uygulanamıyor.',

        // Yönergede çok yazarlı çalışmalar için paylaşım kuralı yok; `yazar_katsayisi`
        // bilinçli olarak tanımlanmadı (gerekçe dosya başlığında).

        'maddeler' => [
            // ══ A. ULUSLARARASI MAKALELER ══
            'A.1' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI taranan dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 120],
            'A.2' => ['baslik' => 'Diğer uluslararası indekslerde taranan dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale'], 'puan' => 80],
            'A.4' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI taranan dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme'], 'puan' => 60],
            'A.5' => ['baslik' => 'Diğer uluslararası indekslerde taranan dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['derleme'], 'puan' => 40],
            // A.8 kaynakta tek satırda üç puan taşıyor ("puanların yarısı");
            // alt kodlar (a-c) bize ait, c girilemedi (bkz. dosya başlığı).
            'A.8.a' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI taranan dergide teknik not, editöre mektup, tartışma veya vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 60],
            'A.8.b' => ['baslik' => 'Diğer uluslararası indekslerde taranan dergide teknik not, editöre mektup, tartışma veya vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 40],

            // ══ B. ULUSLARARASI BİLDİRİLER ══
            'B.1' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan ve tam metin yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 40],
            'B.3' => ['baslik' => 'Uluslararası bilimsel toplantıda sözlü sunum ya da poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 10],

            // ══ C. ULUSLARARASI KİTAPLAR ══
            // C.1-C.4 kaynak ayrımı taşımadığı için H bölümüne düştü.

            // ══ D. ÇEVİRİLER ══
            'D.1' => ['baslik' => 'Bilimsel kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 50],
            'D.2' => ['baslik' => 'Bilimsel kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 15],

            // ══ E. ULUSLARARASI ATIFLAR ══
            'E' => ['baslik' => 'Uluslararası makale, bildiri ve kitaplarda yayınlarınıza yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 12],

            // ══ F. ULUSAL MAKALELER ══
            'F.1' => ['baslik' => 'ULAKBİM veri tabanlarındaki ulusal hakemli dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 50],
            'F.2' => ['baslik' => 'Diğer hakemli dergilerde tam makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 30],

            // ══ G. ULUSAL BİLDİRİLER ══
            'G.1' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan ve tam metin yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 20],
            'G.3' => ['baslik' => 'Ulusal bilimsel toplantıda sözlü sunum ya da poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 10],

            // ══ H. ULUSAL KİTAPLAR ══
            'H.1' => ['baslik' => 'Alanınızda yayımlanan bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'BKCI / Scopus Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 70],
            'H.2' => ['baslik' => 'Bilimsel kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'BKCI / Scopus Kitap Bölümü'], 'puan' => 35],
            'H.3' => ['baslik' => 'Bilimsel kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü', 'BKCI Kitap'], 'puan' => 40],
            'H.4' => ['baslik' => 'Sunulmuş ya da basılmış bilimsel veya teknik rapor', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı'], 'puan' => 25],

            // ══ I. DERS KİTABI ══
            'I.2' => ['baslik' => 'Ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 40],

            // ══ İ. ULUSAL ATIFLAR ══
            'İ' => ['baslik' => 'Ulusal makale, bildiri ve kitaplarda yayınlarınıza yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Patent', 'Diğer'], 'puan' => 6],

            // ══ J. PATENTLER ══
            'J.1' => ['baslik' => 'Yurt dışı patenti almak', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 200],
            'J.2' => ['baslik' => 'Yurt içi patenti almak', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 100],

            // ══ K. ERASMUS ÖĞRETİM ELEMANI DEĞİŞİMİ ══
            'K' => ['baslik' => 'Erasmus kapsamında öğretim elemanı değişim etkinliği', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Değişim Programı Dersi'], 'puan' => 20],

            // ══ L. ARAŞTIRMA PROJELERİ ══
            'L.1' => ['baslik' => 'Uluslararası kurum ve kuruluşlarca desteklenen projede yöneticilik', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 120],
            'L.2' => ['baslik' => 'Uluslararası kurum ve kuruluşlarca desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 60],
            'L.3' => ['baslik' => 'TÜBİTAK ya da benzeri ulusal kuruluşlarca desteklenen projede yöneticilik', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 90],
            'L.4' => ['baslik' => 'TÜBİTAK ya da benzeri ulusal kuruluşlarca desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 40],
            'L.5' => ['baslik' => 'Üniversite bilimsel araştırma projesinde (BAP) yöneticilik', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 50],
            'L.6' => ['baslik' => 'Üniversite bilimsel araştırma projesinde (BAP) görev almak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 25],

            // ══ N. ULUSLARARASI DERGİLERDE HAKEMLİK ══
            // (M editörlük satırı görev ayrımı taşımadığı için girilemedi.)
            'N' => ['baslik' => 'Uluslararası indeksli dergide hakemlik ya da editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 40],

            // ══ P. DİĞER DERGİ VE BİLDİRİ KİTAPÇIKLARINDA HAKEMLİK ══
            'P' => ['baslik' => 'Diğer hakemli dergilerde ya da bildiri kitapçığında hakemlik veya editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi', 'Hakemlik'], 'puan' => 15],

            // ══ R. ÖDÜLLER ══
            // R.1 ve R.3 tek satırda derece ve mansiyon puanı taşıyor; alt kodlar
            // (a-b) bize ait. Kaynak ayrımı olmadığı için yalnızca R.3.b girildi.
            'R.3.b' => ['baslik' => 'Bilimsel nitelikli yarışmada derece ya da mansiyon', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon', 'YÖK Ödülü', 'Ulusal Bilim/Sanat Ödülü'], 'puan' => 30],
            'R.1.b' => ['baslik' => 'Uluslararası bilimsel nitelikli yarışmada derece ya da mansiyon', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 60],
            'R.5' => ['baslik' => 'TÜBİTAK ya da TÜBA bilim ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 120],
            'R.7' => ['baslik' => 'Bilimsel ya da sanatsal amaçlı burs', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 60],

            // ══ S. TEZ YÖNETİMİ ══
            'S.1' => ['baslik' => 'Yönetiminizde tamamlanan doktora tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 40],
            'S.2' => ['baslik' => 'Yönetiminizde tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 20],
            'S.5' => ['baslik' => 'Tez izleme komitesi üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 5],

            // ══ T. EĞİTİM VE ÖĞRETİME KATKI ══
            'T.1' => ['baslik' => 'Verdiğiniz lisansüstü ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 5],
            'T.2' => ['baslik' => 'Verdiğiniz lisans ya da ön lisans dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders'], 'puan' => 3],

            // ══ U. DİĞER AKADEMİK VE BİLİMSEL ETKİNLİKLER ══
            'U.4' => ['baslik' => 'Bilimsel toplantıda davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 20],
            'U.9' => ['baslik' => 'Meslek odası, yerel yönetim ya da bakanlık yarışmasında jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 5],
            'U.10' => ['baslik' => 'Sosyal sorumluluk projesi ya da topluma hizmet faaliyeti', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 5],

            // ══ V. UYGULAMALI FAALİYETLER (Güzel Sanatlar Temel Alanı) ══
            'V.1' => ['baslik' => 'Eserinizin yurt dışında satın alınması ya da yayın organlarında yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Eserin Müzeye Kabulü (Yurt Dışı)', 'Belgesel/Kısa Film (Uluslararası)'], 'puan' => 100],
            'V.2' => ['baslik' => 'Uluslararası jürili karma sanat ya da tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)'], 'puan' => 60],
            'V.3' => ['baslik' => 'Yurt dışında kişisel sanat etkinliği (festival, sergi, gösteri, dinleti)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Solistlik (Uluslararası)', 'Resital (Uluslararası)', 'Şan Resitali (Uluslararası)'], 'puan' => 40],
            'V.4' => ['baslik' => 'Yurt içinde kişisel sanat etkinliği (festival, sergi, gösteri, dinleti)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Solistlik (Ulusal)', 'Resital (Ulusal)', 'Şan Resitali (Ulusal)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 20],
            'V.5' => ['baslik' => 'Eserinizin yurt içinde satın alınması, yayın organlarında yer alması ya da tasarım projenizin uygulanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Eserin Müzeye Kabulü (Yurt İçi)', 'Belgesel/Kısa Film (Ulusal)', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Yayında Yer Alması / Satın Alınması', 'Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman'], 'puan' => 60],
            'V.6' => ['baslik' => 'Ulusal jürili yurt dışı karma sanat ya da tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Ulusal Jürili)'], 'puan' => 40],
            'V.7' => ['baslik' => 'Yurt içinde jürili karma sanat ya da tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)'], 'puan' => 20],
            'V.8' => ['baslik' => 'Yurt dışında jürisiz karma ya da grup etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Jürisiz)'], 'puan' => 20],
            'V.9' => ['baslik' => 'Yurt içinde jürisiz karma ya da grup etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Uluslararası)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 10],
            'V.10' => ['baslik' => 'Uluslararası sempozyum, festival, çalıştay ya da bienale eserinizle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 30],
            'V.11' => ['baslik' => 'Ulusal sempozyum, festival, çalıştay ya da bienale eserinizle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 20],

            // ══ Y. İDARİ VE DİĞER FAALİYETLER ══
            // Yönerge puanı "× yıl sayısı" veriyor; cetvel sabit sayı tutuyor.
            'Y.1' => ['baslik' => 'Üniversitede üst düzey yöneticilik (rektör, rektör yardımcısı, dekan, enstitü müdürü)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü'], 'puan' => 30],
            'Y.2' => ['baslik' => 'Üniversitede yöneticilik (koordinatörlük, bölüm başkanlığı, dekan yardımcılığı, merkez müdürlüğü)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkanı', 'Anabilim Dalı Başkanı / Koordinatörlük', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 20],
            'Y.3' => ['baslik' => 'Üniversitede komisyon ya da kurul üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Senato / Üniversite Yönetim Kurulu Üyesi', 'Kurul / Komisyon Üyeliği', 'Bölüm Başkan Yardımcısı'], 'puan' => 5],
        ],

        'gruplar' => [
            // Koşulların andığı harf aralıkları. Aralık deseni ('A..U') cetveldeki
            // SIRAYA bakar, harf sırasına değil; bu yüzden bölümler tek tek sayıldı.
            // Nokta zorunlu: 'A.*' yerine 'A*' deseni bölüm harfi olmayan kodları
            // da yakalardı.
            'A-C' => ['A.*', 'B.*'],

            // Türkçe alfabede I ile J arasında İ var; ulusal atıflar bu yüzden
            // A-J aralığının içinde.
            'A-J' => ['A.*', 'B.*', 'D.*', 'E', 'F.*', 'G.*', 'H.*', 'I.*', 'İ', 'J.*'],

            // A-U, V (güzel sanatlar) ile Y'yi (idari) DIŞARIDA bırakıyor.
            'A-U' => ['A.*', 'B.*', 'D.*', 'E', 'F.*', 'G.*', 'H.*', 'I.*', 'İ', 'J.*',
                'K', 'L.*', 'N', 'P', 'R.*', 'S.*', 'T.*', 'U.*'],
        ],

        // Yönerge hiçbir bölüme sabit tavan koymuyor. T bölümünün "en fazla 15
        // ders" sınırı adet tavanı; motor bunu tutmuyor (dosya başlığına bak).
        'grup_tavanlari' => [],
    ];

    if (! $guzelSanatlar) {
        $cetvel['maddeler'] = array_filter(
            $cetvel['maddeler'],
            fn (string $kod): bool => ! str_starts_with($kod, 'V.'),
            ARRAY_FILTER_USE_KEY,
        );
    }

    return $cetvel;
};

return ['cetveller' => [
    'istanbul-zaim-2019' => $govde(false),                  // on bir temel alan
    'istanbul-zaim-2019-guzel-sanatlar' => $govde(true),    // V. bölüm burada
]];
