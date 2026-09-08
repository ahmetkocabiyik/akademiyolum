<?php

/**
 * KONYA GIDA VE TARIM ÜNİVERSİTESİ — EK-1 Bilimsel ve Akademik Etkinlik
 * Puanlama Tablosu
 * Kaynak: pdf/17634002431.Konya Gıda ve Tarım Üniversitesi Kriter.pdf
 * (8 sayfa; YNRG.013, Revize 03.07.2024, YÖK onay 24.10.2024)
 *
 * Madde kodları tablonun kendi harf-numara düzeni (A1…G9). Koşullar
 * "A.1-6, B.1-5, C.1-6" gibi ARALIKLARA atıf yaptığı için bunlar
 * `gruplar` altında tanımlandı — B.6 (ulusal özet bildiri) bu ara
 * toplamın DIŞINDA, tablonun kendi yazdığı gibi.
 *
 * ── A.2 İKİYE BÖLÜNDÜ ──
 * Tablo A.2'de "ESCI, Scopus vd. VEYA ULAKBİM" dergilerini tek satırda
 * topluyor (20 puan). Dr. Öğretim Üyeliği koşulu ise "SSCI, AHCI, SCI,
 * SCI-Expanded veya ULAKBİM" diyor — ESCI ve Scopus bu listede YOK.
 * Puanı aynı kalacak biçimde satır ikiye bölündü (`A2-ulakbim`,
 * `A2-esci`); özgün yayın koşulu yalnız ULAKBİM yarısını sayıyor.
 *
 * ── AYNI ETİKETE DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   D.7 SCI hakemliği (10) ile D.8 diğer indeks hakemliği (5) tek
 *       'Hakemlik' etiketine düşüyor → 5.
 *   F bölümünde "adına" (tek isim) ve "birden fazla isimli" patent ayrı
 *       satırlar; kayıt hak sahibi sayısını taşımadığı için hepsi ÇOK
 *       İSİMLİ satırdan sayılıyor (uluslararası 40, ulusal 20, faydalı
 *       model 15). Tek isimli patentiniz varsa puanınız olduğundan
 *       DÜŞÜK (100 / 50 / 30 olmalıydı).
 *   G.1'de uluslararası bilim ödülü (50) ile teşvik ödülü (30), G.2'de
 *       ulusal bilim (30) ile teşvik (20), G.4-5'te bir yıla kadar (5)
 *       ile bir yıldan uzun (20) burs, G.6-9'da kongre başkanlığı (20/10)
 *       ile düzenleme kurulu üyeliği (10/5) ayrımı etiketten okunamadığı
 *       için hepsi en düşükten.
 *   B.2 (uluslararası özet, SCI dergi özel sayısı, 5) ile B.4 (özet,
 *       diğer, 3) tek 'Uluslararası Özet/Poster' etiketine düşüyor → 3.
 *
 * ── GİRİLMEYEN BÖLÜM: Ç (ATIFLAR ve ETKİ DEĞERLERİ) ──
 * Ç.1-4 puanı h faktörüne veriyor (10/30/60/90), Ç.5 en yüksek etki
 * değerli on derginin toplamını istiyor ve puan sütunu BOŞ. İkisi de
 * faaliyet satırı değil; h faktörü profil ölçütü, etki değeri toplamı
 * ise yönergede sayısal karşılığı olmayan bir kalem. Bölüm Ç "Tüm
 * Faaliyetler" barajına dahil olduğu için TOPLAM PUANINIZ OLDUĞUNDAN
 * DÜŞÜK görünür — h faktörü 10 ve üzeri bir adayda 90 puanlık fark.
 *
 * ── UYGULANMAYAN ÇARPAN: PATENT HAK SAHİPLİĞİ ──
 * Dipnot [3] patent puanını hak sahipliği oranına göre 1,5 / 2 / 3 ile
 * ÇARPIYOR. Kayıt hak sahipliği oranını taşımadığı için çarpan hiç
 * uygulanmadı; patent puanınız olduğundan DÜŞÜK.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   G.3 üniversite bilim ödülü (15) — sözlükte karşılık yok.
 *   Endüstriyel tasarım, yazılım, ıslahçı hakkı ve ticarileştirme —
 *       tabloda karşılık gelen satır yok (F yalnız patent ve faydalı
 *       model).
 *   Ders verme, idari görev, toplumsal katkı ve sanatsal etkinlik —
 *       yönergenin tablosunda hiç yok.
 *
 * Yönerge: yonerge/konya-gida-tarim.php
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 */
$SCI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];
$OZGUN = ['ozgun_makale'];
$KISA = ['derleme', 'kisa_makale', 'vaka_teknik_not'];

return [
    'kapsam_notu' => 'Puanlar Konya Gıda ve Tarım Üniversitesi Bilimsel ve Akademik Etkinlik '
        .'Puanlama Tablosundan (EK-1). Yazar çarpanı yalnızca A, B ve C bölümlerine (yayın, '
        .'bildiri, kitap) uygulanıyor: tek yazarda tam puan, iki yazarda 0,8; üç yazarda 0,6; '
        .'dört yazarda 0,4; beş ve daha fazlasında 0,3. Birinci yazar ya da iletişim yazarıysanız '
        .'yazar sayısı ikiden fazla olsa da 0,8 uygulanıyor. Yazar listesini boş bırakırsanız '
        .'çarpan hiç uygulanmaz ve puanınız olduğundan YÜKSEK görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: Bölüm Ç (h faktörüne göre 10-90 puan '
        .'ve dergi etki değerleri toplamı) faaliyet satırına çevrilemediği için hiç girilmedi, '
        .'oysa "Tüm Faaliyetler" barajına dahil — h faktörünüz 10 ve üzerindeyse 90 puan eksik '
        .'sayılıyorsunuz. Patent ve faydalı modellerde tek isimli ("adına") satırlar kayıt hak '
        .'sahibi sayısını taşımadığı için girilmedi; hepsi çok isimli satırdan (uluslararası 40, '
        .'ulusal 20, faydalı model 15) sayılıyor ve dipnot [3]\'ün hak sahipliği oranına göre '
        .'1,5-3 kat artırma kuralı uygulanmıyor. Uluslararası ve ulusal bilim ödülleri teşvik '
        .'ödüllerinden, bir yıldan uzun burslar kısa burslardan, kongre başkanlığı düzenleme '
        .'kurulu üyeliğinden ayrılamadığı için hepsi en düşük değerden sayılıyor. SCI dergi '
        .'hakemliği (10) diğer hakemliklerden (5) ayrılamıyor.',

    // Dipnot [2]: "A, B ve C bölümlerinde verilen puanlar tek yazarı ve
    // toplam puanı ifade etmektedir." Diğer bölümlerde yazar bölüşümü yok.
    // Not: "Adayın yayında birinci yazar veya iletişim yazarı olması veya
    // eşit katkı sağladığına dair bir ibare bulunması durumunda, yazar
    // sayısı 2'den fazla olsa dahi katsayı 0,8'dir."
    'yazar_katsayisi' => [
        'haric' => ['atif', 'proje', 'patent', 'tez_danismanligi', 'egitim_ogretim',
            'editorluk', 'sanatsal_etkinlik', 'odul', 'idari_gorev', 'toplumsal_katki', 'diger'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00], 'sonrasi' => 0.80],
            'baslica' => ['kademeler' => [1 => 1.00], 'sonrasi' => 0.80],
            'ortak' => ['kademeler' => [1 => 1.00, 2 => 0.80, 3 => 0.60, 4 => 0.40], 'sonrasi' => 0.30],
        ],
    ],

    'maddeler' => [
        // ══ A. BİLİMSEL YAYINLAR ══
        'A1' => ['baslik' => 'SCI, SCI-Expanded, SSCI ve AHCI kapsamındaki dergilerde yayımlanan tam metinli özgün makale', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => $OZGUN, 'puan' => 30],
        'A2-ulakbim' => ['baslik' => 'ULAKBİM kapsamındaki dergilerde yayımlanan tam metinli özgün makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $OZGUN, 'puan' => 20],
        'A2-esci' => ['baslik' => 'ESCI, Scopus ve benzeri uluslararası indeksler kapsamındaki dergilerde yayımlanan tam metinli özgün makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $OZGUN, 'puan' => 20],
        'A3' => ['baslik' => 'SCI, SCI-Expanded, SSCI ve AHCI kapsamındaki dergilerde yayımlanan vaka takdimi, kısa not, teknik not, editöre mektup ve benzeri yazı', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => $KISA, 'puan' => 15],
        'A4' => ['baslik' => 'ESCI, Scopus veya ULAKBİM kapsamındaki dergilerde yayımlanan vaka takdimi, kısa not, teknik not, editöre mektup ve benzeri yazı', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'TR Dizin'], 'turler' => $KISA, 'puan' => 10],
        'A5' => ['baslik' => 'Diğer yurt içi ya da yurt dışı hakemli ve süreli dergilerde yayımlanan tam metinli özgün makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'], 'turler' => $OZGUN, 'puan' => 5],
        'A6' => ['baslik' => 'Diğer yurt içi ya da yurt dışı hakemli ve süreli dergilerde yayımlanan vaka takdimi, kısa not, teknik not, editöre mektup ve benzeri yazı', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 3],

        // ══ B. KONGRE VE SEMPOZYUM SUNUMLARI ══
        'B1' => ['baslik' => 'Uluslararası kongrede sunulan ve tam metni SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergilerde yayımlanan sözlü veya poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 10],
        'B3' => ['baslik' => 'Uluslararası kongrede sunulan ve tam metni diğer dergilerde ya da kongre kitapçığında yayımlanan sözlü veya poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin'], 'puan' => 5],
        'B4' => ['baslik' => 'Uluslararası kongrede sunulan ve özeti yayımlanan sözlü veya poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster', 'Davetli Konuşmacı'], 'puan' => 3],
        'B5' => ['baslik' => 'Ulusal kongrede sunulan ve tam metni yayımlanan sözlü veya poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 3],
        'B6' => ['baslik' => 'Ulusal kongrede sunulan ve özeti yayımlanan sözlü veya poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 2],

        // ══ C. KİTAP YAZARLIĞI VE ÇEVİRİSİ ══
        'C1' => ['baslik' => 'Uluslararası, yabancı dilde yayımlanmış kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 120],
        'C2' => ['baslik' => 'Uluslararası, yabancı dilde yayımlanmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 40],
        'C3' => ['baslik' => 'Türkçe telif kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı'], 'puan' => 60],
        'C4' => ['baslik' => 'Türkçe telif kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 20],
        'C5' => ['baslik' => 'Yabancı dilde ders kitabı çevirisi editörlüğü', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 60],
        'C6' => ['baslik' => 'Yabancı dilde ders kitabı bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 20],

        // ══ D. EDİTÖRLÜK VE HAKEMLİK ══
        'D1' => ['baslik' => 'SCI, SCI-Expanded, SSCI ve AHCI kapsamındaki dergilerde editörlük ya da yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 40],
        'D2' => ['baslik' => 'Diğer uluslararası indeksler kapsamındaki dergilerde editörlük ya da editör yardımcılığı', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 20],
        'D3' => ['baslik' => 'Ulusal dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 20],
        'D4' => ['baslik' => 'Ulusal dergilerde editör yardımcılığı ya da yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 10],
        'D5' => ['baslik' => 'Yabancı dilde yazılmış kitaplarda editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 40],
        'D6' => ['baslik' => 'Türkçe yazılmış kitaplarda editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 20],
        'D8' => ['baslik' => 'Bilimsel dergilerde her bir hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 5],

        // ══ E. TEZ DANIŞMANLIĞI VE PROJE YÜRÜTÜCÜLÜĞÜ ══
        'E1' => ['baslik' => 'Tamamlanmış her bir doktora tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 20],
        'E2' => ['baslik' => 'Tamamlanmış her bir doktora tezi eş danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 15],
        'E3' => ['baslik' => 'Tamamlanmış her bir yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 10],
        'E4' => ['baslik' => 'Tamamlanmış her bir yüksek lisans tezi eş danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'roller' => ['es_danisman'], 'puan' => 5],
        'E5' => ['baslik' => 'Tamamlanmış ya da devam eden uluslararası proje yürütücülüğü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 60],
        'E6' => ['baslik' => 'Tamamlanmış ya da devam eden uluslararası projede yürütücü yardımcılığı veya araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
        'E7' => ['baslik' => 'Tamamlanmış ya da devam eden, TÜBİTAK ve benzeri resmî kuruluşlarca desteklenmiş proje yürütücülüğü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 30],
        'E8' => ['baslik' => 'Tamamlanmış ya da devam eden, TÜBİTAK ve benzeri resmî kuruluşlarca desteklenmiş projede yürütücü yardımcılığı veya araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
        'E9' => ['baslik' => 'Üniversite fonları ya da derneklerce desteklenmiş proje yürütücülüğü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 15],
        'E10' => ['baslik' => 'Üniversite fonları ya da derneklerce desteklenmiş projede yürütücü yardımcılığı veya araştırıcılık', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 5],
        'E11' => ['baslik' => 'Özel sektörce desteklenen proje yürütücülüğü', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 20],
        'E12' => ['baslik' => 'Özel sektörce desteklenen projede yardımcı araştırıcılık', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],

        // ══ F. PATENTLER VE FAYDALI MODEL ══
        'F2' => ['baslik' => 'Birden fazla isimli uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 40],
        'F4' => ['baslik' => 'Birden fazla isimli ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 20],
        'F6' => ['baslik' => 'Birden fazla isimli faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 15],

        // ══ G. ÖDÜLLER, BURSLAR VE KONGRE DÜZENLEME ══
        'G1' => ['baslik' => 'Uluslararası bilim ya da teşvik ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 30],
        'G2' => ['baslik' => 'Ulusal bilim ya da teşvik ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 20],
        'G4' => ['baslik' => 'Yurt dışı araştırma bursu', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 5],
        'G9' => ['baslik' => 'Kongre başkanlığı ya da kongre düzenleme kurulunda yer almak', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 5],
        // Kaynak 6 uluslararası kongre başkanlığı 20 · 8 ULUSAL 10 · 7 uluslararası düzenleme kurulu 10 · 9 ULUSAL 5 diyor; dördü de tek satırda 5 puanla duruyordu.
        'G9-bsk-u' => ['baslik' => 'Uluslararası bilimsel ya da sanatsal toplantı düzenleme kurulu başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 20],
        'G9-bsk-n' => ['baslik' => 'Ulusal bilimsel ya da sanatsal toplantı düzenleme kurulu başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Ulusal)'], 'puan' => 10],
        'G9-kur-u' => ['baslik' => 'Uluslararası bilimsel ya da sanatsal toplantı düzenleme ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 10],
        'G9-kur-n' => ['baslik' => 'Ulusal bilimsel ya da sanatsal toplantı düzenleme ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 5],
    ],

    'gruplar' => [
        // Madde 6'nın ara toplam kümesi: "A.1-6, B.1-5, C.1-6".
        // B.6 (ulusal özet bildiri) bu kümenin DIŞINDA.
        'A1-6' => ['A1', 'A2-ulakbim', 'A2-esci', 'A3', 'A4', 'A5', 'A6'],
        'B1-5' => ['B1', 'B3', 'B4', 'B5'],
        'C1-6' => ['C1', 'C2', 'C3', 'C4', 'C5', 'C6'],
        'ABC' => ['A1', 'A2-ulakbim', 'A2-esci', 'A3', 'A4', 'A5', 'A6',
            'B1', 'B3', 'B4', 'B5',
            'C1', 'C2', 'C3', 'C4', 'C5', 'C6'],

        // 6.b.1: doçentlik ve profesörlükte sayılan makale kümeleri.
        'A1235' => ['A1', 'A2-ulakbim', 'A2-esci', 'A3', 'A5'],
        'A123' => ['A1', 'A2-ulakbim', 'A2-esci', 'A3'],

        // 6.a.2: "SSCI, AHCI, SCI, SCI-Expanded veya ULAKBİM ... özgün yayın"
        // (tam metinli makale ya da tam metin basılmış bildiri).
        'OZGUN' => ['A1', 'A2-ulakbim', 'B1'],
    ],

    'grup_tavanlari' => [],
];
