<?php

/**
 * HATAY MUSTAFA KEMAL ÜNİVERSİTESİ — Akademik Etkinlikler ve Puanlar Listesi
 * Kaynak: pdf/17536995922.hataymustafakemaluniverstesi.pdf
 *         (05.06.2024 senato ve 27.06.2024 YÖK Genel Kurulu değişiklikleriyle)
 *
 * BU CETVEL YALNIZCA DR. ÖĞR. ÜYELİĞİNDE KULLANILIYOR. Hatay MKÜ doçentlik ve
 * profesörlük koşullarını kendi tablosuna değil ÜAK doçentlik kriterlerine
 * bağlıyor; o eşikler `uak-2024-mart-{alan}` cetvelini kullanıyor
 * (bkz. yonerge/hatay-mku.php).
 *
 * KOŞULLAR TABLOYA HEM MADDE KODUYLA HEM BÖLÜM HARFİYLE atıf yapıyor
 * ("A1a, A1b ve A1c, A2a ve A2d maddeleri kapsamında en az 30 puan almak
 * şartıyla, A-B-C-D-E-F maddeleri kapsamında en az 80 puan"), bu yüzden hem
 * kodlar hem bölüm harfleri birebir korundu.
 *
 * YAZAR ÇARPANI YOK: yönerge çok yazarlı çalışmalar için oran tablosu
 * içermiyor; puanlar yazar sayısından bağımsız veriliyor.
 *
 * AYNI KAYNAĞA DÜŞEN KALEMLERDE DÜŞÜK OLAN GİRİLDİ:
 *   'Kitap Editörlüğü' uluslararası/ulusal ayırmıyor → A2c'nin ulusal satırı (20).
 *   'Hakemlik' dergi düzeyi taşımıyor → A3c (2).
 *   'Davetli Konuşmacı' ulusal/uluslararası ayırmıyor → B1b (10).
 *
 * ── E BÖLÜMÜ 01.09.2026'DA YENİDEN OKUNDU ──
 * E2 (patentler) "puan satırları PDF'te ayrıştırılamadı" diye kayıtlıydı;
 * `pdftotext -q -layout` ile üç satır da temiz çıkıyor (uluslararası 50 ·
 * ulusal 25 · çeşit geliştirme 50) ve girildi. PATENTİ OLAN ADAY BUGÜNE KADAR
 * SIFIR GÖRÜYORDU.
 *
 * Aynı okumada E1'de fazla sayan iki satır bulundu: E1b (yurt dışı bilim
 * ödülü, 50) ile E1d (uluslararası kongre ödülü, 15) ve E1c (yurt içi bilim
 * ödülü, 25) ile E1e (ulusal kongre ödülü, 10) kayıtta tek etikete düşüyor.
 * Genel ödül etiketleri §0 uyarınca düşük olan E1d ve E1e'ye taşındı; E1b'de
 * yalnızca kendi etiketi olan ERC ödülü kaldı. 'Burs' etiketi de çıkarıldı,
 * listede karşılığı yok.
 *
 * GİRİLMEYEN KALEMLER: A4f (bestecinin eserinin uluslararası konserde
 * seslendirilmesi), A3d-A3e (proje hakemliği ve UDAP), C3 (yurt dışı araştırma
 * süresi — profilde tutulmuyor), G bölümü (sanat tarihi, arkeoloji ve
 * antropoloji kazı çalışmaları — kazı projesi ve ruhsatı için kaynak
 * sözlüğünde karşılık yok; proje etiketlerine bağlamak C bölümünün proje
 * satırlarıyla çifte sayım olurdu).
 *
 * G BÖLÜMÜNÜN GİRİLEMEMESİ SOSYAL/GÜZEL SANATLAR ADAYINI ETKİLER: o alanların
 * 80 puanlık barajı "A-B-C-D-E-F-G" kümesinden sayılıyor; G girilmediği için
 * baraj olduğundan ZOR görünür.
 */

return [
    'kapsam_notu' => 'Puanlar Hatay Mustafa Kemal Üniversitesi "Akademik Etkinlikler ve Puanlar '
        .'Listesi"nden. Hatay MKÜ çok yazarlı çalışmalar için oran tablosu içermiyor; puan '
        .'yazar sayısından bağımsız veriliyor. Bu tablo yalnızca Dr. Öğr. Üyeliği koşullarında '
        .'kullanılıyor — doçentlik ve profesörlük ÜAK doçentlik kriterlerine bağlı. Sanat '
        .'tarihi, arkeoloji ve antropoloji kazı çalışmaları (G bölümü) girilemedi. ÖDÜL '
        .'PUANINIZ DÜŞÜK GÖRÜNEBİLİR: liste kurum ödülü ile kongre ödülünü ayrı puanlıyor, '
        .'faaliyet kaydı ikisini ayırmadığı için genel ödül kayıtlarınız düşük olan kongre '
        .'ödülü değerinden sayılıyor.',

    'maddeler' => [
        // ══ A. YAYINLAR — 1. Makaleler ══
        'A1a' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 40],
        'A1b' => ['baslik' => 'ESCI dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 35],
        'A1c' => ['baslik' => 'ÜAK alan indeksli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 30],
        'A1d' => ['baslik' => 'ULAKBİM TR Dizin dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 15],
        'A1e' => ['baslik' => 'Ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 10],
        'A1f1' => ['baslik' => 'SCI, SSCI, AHCI veya ESCI dergide teknik not, vaka takdimi, editöre mektup veya kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI', 'ESCI'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 20],
        'A1f2' => ['baslik' => 'ÜAK alan indeksli dergide teknik not, vaka takdimi veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Scopus'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 15],
        'A1f3' => ['baslik' => 'TR Dizin dergide teknik not, vaka takdimi veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 10],
        'A1f4' => ['baslik' => 'Ulusal hakemli dergide teknik not, vaka takdimi veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 8],

        // ══ A. 2. Kitaplar, kitap bölümleri ve dergi editörlüğü ══
        'A2a1' => ['baslik' => 'Uluslararası yayınevince yayımlanmış bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 60],
        'A2a2' => ['baslik' => 'Ulusal yayınevince yayımlanmış bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 30],
        'A2b' => ['baslik' => 'Ulusal yayınevince yayımlanmış ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 20],
        'A2c' => ['baslik' => 'Kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 20],
        'A2d1' => ['baslik' => 'Uluslararası yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 10],
        'A2d2' => ['baslik' => 'Ulusal yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 5],
        'A2e' => ['baslik' => 'Alanında yayımlanmış tam kitap tercümesi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap', 'Çeviri Kitap Bölümü'], 'puan' => 15],
        'A2f1' => ['baslik' => 'SCI, SSCI, AHCI veya ESCI dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI Dergi'], 'puan' => 30],
        'A2f3' => ['baslik' => 'Ulusal veya diğer uluslararası hakemli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi', 'Yayın Kurulu Üyeliği', 'Scopus Dergi'], 'puan' => 5],

        // ══ A. 3. Hakemlikler ══
        'A3c' => ['baslik' => 'Dergi hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 2],

        // ══ A. 4. Atıflar ══
        'A4a' => ['baslik' => 'Uluslararası yayınevi kitabında atıf (atıf başına)', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 8],
        'A4c' => ['baslik' => 'SCI-Expanded, SSCI, AHCI veya ESCI dergisinde atıf (atıf başına)', 'kategori' => 'atif', 'kaynaklar' => ['SCIE/SSCI/AHCI', 'ESCI'], 'puan' => 4],
        'A4e' => ['baslik' => 'Ulusal hakemli dergide atıf (atıf başına)', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer'], 'puan' => 2],

        // ══ B. TEBLİĞLER ══
        'B1b' => ['baslik' => 'Kongre veya sempozyumda davetli sözlü tebliğ', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 10],
        'B1c' => ['baslik' => 'Uluslararası kongrede sunulan ve SCI kapsamlı yayında tam metin tebliğ', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 15],
        'B1e1' => ['baslik' => 'Uluslararası kongrede tam metin olarak yayımlanan tebliğ', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin'], 'puan' => 8],
        'B1e2' => ['baslik' => 'Uluslararası kongrede özet olarak yayımlanan tebliğ veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 3],
        'B1f1' => ['baslik' => 'Ulusal kongrede tam metin olarak yayımlanan tebliğ', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 6],
        'B1f2' => ['baslik' => 'Ulusal kongrede özet olarak yayımlanan tebliğ veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 2],

        // ══ C. PROJELER VE ARAŞTIRMA (yalnızca Ar-Ge nitelikli, sonuçlandırılmış) ══
        'C1a' => ['baslik' => 'Dünya Bankası, Avrupa Birliği veya Avrupa Konseyi destekli proje', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'puan' => 60],
        'C1b' => ['baslik' => 'Diğer uluslararası kurum veya kuruluşça desteklenmiş proje', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'puan' => 50],
        'C2a' => ['baslik' => 'TÜBA, TÜBİTAK, Kalkınma Bakanlığı veya SAN-TEZ destekli proje', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'puan' => 40],
        'C2d' => ['baslik' => 'Diğer kamu kuruluşlarınca desteklenmiş Ar-Ge projesi', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'puan' => 20],
        'C2e' => ['baslik' => 'Yükseköğretim kurumunca desteklenmiş bilimsel araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'puan' => 5],
        'C2f' => ['baslik' => 'Özel kuruluşlarca desteklenmiş Ar-Ge, yenilik veya özgün tasarım projesi', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'puan' => 10],

        // ══ D. EĞİTİM-ÖĞRETİM FAALİYETLERİ ══
        'D1a' => ['baslik' => 'Sonuçlandırılmış doktora veya uzmanlık tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 10],
        'D1b' => ['baslik' => 'Sonuçlandırılmış yüksek lisans tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 5],
        'D1c' => ['baslik' => 'Tez izleme komitesi veya jüri üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 2],
        'D2a' => ['baslik' => 'Bir dönem ön lisans veya lisans dersi (her ders için)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders'], 'puan' => 2],
        'D2b' => ['baslik' => 'Bir dönem lisansüstü ders (her ders için)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
        'D2c' => ['baslik' => 'Yurt dışında ders veya konferans vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Değişim Programı Dersi'], 'puan' => 10],

        // ══ E. ÖDÜLLER VE PATENTLER ══
        'E1a' => ['baslik' => 'YÖK, TÜBA veya TÜBİTAK bilim ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 60],
        'E1b' => ['baslik' => 'Alanında yurt dışı kurum veya kuruluştan alınan bilim ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ufuk Avrupa / ERC Ödülü'], 'puan' => 50],
        // E1b (50) ile E1d (15), E1c (25) ile E1e (10) kayıtta tek etikete düşüyor;
        // §0 uyarınca genel ödül etiketleri düşük olan kongre-ödülü satırlarından sayılıyor.
        'E1d' => ['baslik' => 'Uluslararası kongre, sempozyum, konferans veya festivalin bilim ve sanat kurulunca verilen ödül', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü'], 'puan' => 15],
        'E1e' => ['baslik' => 'Ulusal kongre, sempozyum, konferans veya festivalin bilim ve sanat kurulunca verilen ödül', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'Yarışma Derecesi / Mansiyon'], 'puan' => 10],
        'E2a' => ['baslik' => 'Alanında uluslararası tescillenmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 50],
        'E2b' => ['baslik' => 'Alanında ulusal tescillenmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 25],
        'E2c' => ['baslik' => 'Çeşit geliştirme (Ziraat alanı)', 'kategori' => 'patent', 'kaynaklar' => ['Islahçı Hakkı / Çeşit Tescili'], 'puan' => 50],

        // ══ F. SANAT DALLARINDAKİ ETKİNLİKLER ══
        'F1a1' => ['baslik' => 'Uluslararası kişisel sanat etkinliği (sergi, festival, dinleti, gösterim)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Resital (Uluslararası)', 'Şan Resitali (Uluslararası)', 'Solistlik (Uluslararası)'], 'puan' => 60],
        'F1a2' => ['baslik' => 'Ulusal kişisel sanat etkinliği (sergi, festival, dinleti, gösterim)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Kişisel Sergi (Ulusal)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Resital (Ulusal)', 'Şan Resitali (Ulusal)', 'Solistlik (Ulusal)'], 'puan' => 40],
        'F1b1' => ['baslik' => 'Uluslararası jürili karma sanat veya tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Masterclass (Uluslararası)'], 'puan' => 30],
        'F1b2' => ['baslik' => 'Ulusal jürili karma sanat veya tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Masterclass (Ulusal)'], 'puan' => 15],
        'F1d1' => ['baslik' => 'Uluslararası karma sanat veya tasarım etkinliğinde yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Karma Sergi (Uluslararası)'], 'puan' => 5],
        'F1d2' => ['baslik' => 'Ulusal karma sanat veya tasarım etkinliğinde yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 3],
        'B4a' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)', 'Toplantı Düzenleme Başkanlığı (Ulusal)'], 'puan' => 12],
    ],

    'gruplar' => [
        // Koşulların andığı bölüm kümeleri.
        'A-B-C-D-E' => ['A*', 'B*', 'C*', 'D*', 'E*'],
        'A-B-C-D-E-F' => ['A*', 'B*', 'C*', 'D*', 'E*', 'F*'],
        // G bölümü (sanat tarihi, arkeoloji, antropoloji) cetvele girmedi;
        // bu küme fiilen A-F ile aynı, yani baraj olduğundan zor görünür.
        'A-B-C-D-E-F-G' => ['A*', 'B*', 'C*', 'D*', 'E*', 'F*'],
        'FEN_MAKALE' => ['A1a', 'A1b', 'A1c', 'A2a1', 'A2a2', 'A2d1', 'A2d2'],
        'SOSYAL_MAKALE' => ['A1a', 'A1b', 'A1c', 'A1d', 'A1e', 'A2a1', 'A2a2', 'A2d1', 'A2d2'],
        'BASLICA_ESER' => ['A1a', 'A1b', 'A1c', 'A1d', 'A1e', 'A2a1', 'A2a2', 'A2d1', 'A2d2', 'F*'],
        'A1a' => ['A1a'],
    ],

    /*
     * "Her bir yıl için atıflardan en fazla 5 puan" sınırı yalnızca yeniden
     * atanma koşulunda geçiyor; yeniden atanma eşiği girilmediği için
     * uygulanmıyor.
     *
     * TAVAN TARAMASI (01.09.2026): kaynağın öteki iki tavanı da uygulanamaz —
     * 8. madde (halkı bilgilendirme, röportaj) ile 9. maddenin (yayımlanmamış
     * sunum, seminer) "Bu maddeden en fazla 10 puan alınabilir" notları;
     * ikisinin de satırı cetvele girmedi.
     */
    'grup_tavanlari' => [],
];
