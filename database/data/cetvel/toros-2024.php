<?php

/**
 * TOROS ÜNİVERSİTESİ — EK: Akademik Yükseltilme ve Atanmalarda Esas Alınacak
 * Puanlama Tablosu
 * Kaynak: pdf/17537103872.torosuniversitesi.pdf
 *
 * MADDE KODLARI yönergenin kendi bölüm harfleri (A-J) + sıra numarası.
 * Koşullar tabloya kodla atıf yapmıyor ("ekte yer alan tablodan en az toplam
 * N puan" diyor), bu yüzden alt numaralar bize ait.
 *
 * ── G BÖLÜMÜNDE PUAN TERS ──
 * Yönergenin proje bölümü üniversite dışı kaynaklı projede ARAŞTIRICIYA 8,
 * YÜRÜTÜCÜYE 6 puan veriyor — yani yürütücülük araştırıcılıktan az. Kaynakta
 * böyle yazıyor (uluslararası projelerde sıra doğru: yürütücü 15, araştırıcı
 * 10), muhtemelen iki satır yer değiştirmiş. Kendi başımıza düzeltmedik:
 * yönergenin yazdığı değer girildi.
 *
 * ── E VE H BÖLÜMLERİ ÜST ÜSTE BİNİYOR ──
 * E "sunulmuş ve TAM METNİ BASILMIŞ sözlü bildiri" (5/3), H yalnızca "sunulan
 * bildiri" (3/2) diyor. İkisi ayrı bölüm olduğuna göre H tam metin dışında
 * kalanları (özet, poster) kapsıyor; kaynak etiketleri buna göre bölündü.
 *
 * ── AYNI KAYNAĞA DÜŞEN İKİ SATIRDA DAİMA DÜŞÜĞÜ GİRİLDİ ──
 *   Kitap B.1 uluslararası (15) / B.4 ulusal (10): sözlük yayınevinin
 *       indeksli olup olmadığını ayırıyor, "tanınmış uluslararası" ile
 *       "tanınmış ulusal"ı ayıramıyor → 'Uluslararası/Ulusal Kitap' B.4'e.
 *   Atıf D.1 (3) / D.2 (2): 'WoS / Scopus' ile 'BKCI Kitap' aynı satırda
 *       anılıyor; D.1 girildi çünkü ikisi de o satırın kapsamında.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   F.3 tezsiz yüksek lisans danışmanlığı — sözlükte tez düzeyi ayrımı var
 *       ama "tezsiz" karşılığı yok.
 *   J bölümündeki "son iki yılda" penceresi — motorda ders için kayan
 *       pencere yok, bütün dersler sayılıyor; ders puanı YÜKSEK görünür.
 *
 * Yönerge: yonerge/toros.php
 *
 * TANINMIŞ YAYINEVİ AYRIMI KAPSAM ETİKETİNE BAĞLANDI (19.09.2026): sıfat iki
 * kademede de aynı, ayrımı yapan tek şey yayınevinin kapsamı. Kapsamlı
 * etiketler üst satırlara bağlandı, ulusal satırlar daraltıldı.
 *
 * B.3 kapsamsız `Kitap Editörlüğü` etiketini korudu: kaynakta ulusal kitap
 * editörlüğü satırı yok.
 */

return [
    'kapsam_notu' => 'Puanlar Toros Üniversitesi Puanlama Tablosundan. Yönerge çok yazarlı '
        .'yayınlarda puanın nasıl paylaşılacağını HİÇ SÖYLEMİYOR; bu yüzden yazar çarpanı '
        .'uygulanmadı ve çok yazarlı eserlerinizin puanı tam sayılıyor. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünebilir: ders puanının "son iki yılda '
        .'verilen dersler" sınırı uygulanmıyor, bütün ders kayıtlarınız sayılıyor. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: tezsiz yüksek lisans danışmanlığı '
        .'kaynakta ayrılamadığı için girilmedi; tanınmış uluslararası ile ulusal yayınevi '
        .'ayrılamadığı için kitaplarda düşük satır kullanıldı. '
        .'Not: yönergenin proje bölümünde üniversite dışı kaynaklı projede araştırıcılık (8) '
        .'yürütücülükten (6) yüksek puan alıyor; kaynakta böyle yazdığı için aynen girildi.',

    'maddeler' => [
        // ══ A. MAKALELER ══
        'A.1' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'puan' => 20],
        'A.2' => ['baslik' => 'Diğer uluslararası hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'puan' => 10],
        'A.3' => ['baslik' => 'ULAKBİM tarafından taranan ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 8],
        'A.4' => ['baslik' => 'Ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 5],

        // ══ B. KİTAPLAR ══
        'B.1' => ['baslik' => 'Tanınmış uluslararası yayınevinde özgün bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası Kitap'], 'puan' => 15],
        'B.2' => ['baslik' => 'Tanınmış uluslararası yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Uluslararası Kitap Bölümü'], 'puan' => 10],
        'B.3' => ['baslik' => 'Tanınmış uluslararası yayınevinde bilimsel kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Kitap Editörlüğü', 'Uluslararası Kitap Editörlüğü'], 'puan' => 10],
        'B.4' => ['baslik' => 'Tanınmış ulusal yayınevinde özgün bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap', 'Ders / Metot Kitabı', 'Çeviri Kitap'], 'puan' => 10],
        'B.5' => ['baslik' => 'Tanınmış ulusal yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap Bölümü', 'Çeviri Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 5],

        // ══ C. PATENT, YARIŞMA ══
        'C.1' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent', 'Ticarileştirme'], 'puan' => 20],
        'C.2' => ['baslik' => 'Ulusal patent, faydalı model veya tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 10],
        'C.3' => ['baslik' => 'Planlama, mimarlık veya tasarım yarışmasında derece ya da mansiyon', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 15],

        // ══ D. ATIFLAR ══
        'D.1' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergilerinde ve uluslararası kitaplarda atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 3],
        'D.3' => ['baslik' => 'Ulusal hakemli dergilerde ve kitaplarda atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 1],

        // ══ E. KONGRE / SEMPOZYUM (tam metin sözlü bildiri) ══
        'E.1' => ['baslik' => 'Uluslararası kongrede sunulmuş ve tam metni basılmış sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 5],
        'E.2' => ['baslik' => 'Ulusal kongrede sunulmuş ve tam metni basılmış sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 3],

        // ══ F. LİSANSÜSTÜ TEZ DANIŞMANLIĞI (tezli, tamamlanmış) ══
        'F.1' => ['baslik' => 'Tamamlanmış doktora tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 4],
        'F.2' => ['baslik' => 'Tamamlanmış tezli yüksek lisans danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 2],

        // ══ G. BİLİMSEL ARAŞTIRMA PROJESİ ══
        // DİKKAT: üniversite dışı kaynaklı projede araştırıcı (8) yürütücüden
        // (6) yüksek. Kaynakta böyle yazıyor, aynen girildi.
        'G.1' => ['baslik' => 'Uluslararası kaynaklı araştırma projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 15],
        'G.2' => ['baslik' => 'Uluslararası kaynaklı araştırma projesinde ortak araştırıcılık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
        'G.3' => ['baslik' => 'Üniversite dışı kaynaklı araştırma projesinde araştırıcılık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 8],
        'G.4' => ['baslik' => 'Üniversite dışı kaynaklı araştırma projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 6],

        // ══ H. BİLİMSEL TOPLANTI (tam metin dışı) ══
        'H.1' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster', 'Davetli Konuşmacı'], 'puan' => 3],
        'H.2' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 2],

        // ══ I. DİĞER FAALİYETLER ══
        'I.1' => ['baslik' => 'Dergi editörlüğü, düzenleme kurulu veya jüri üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi', 'TR Dizin Dergi', 'Diğer Hakemli Dergi', 'Yayın Kurulu Üyeliği', 'Hakemlik'], 'puan' => 1],
        'I.2' => ['baslik' => 'Kurul, komisyon veya jüri üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 1],
        'I.3' => ['baslik' => 'Sanat ve tasarım yarışmalarında jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 1],

        // ══ J. EĞİTİM-ÖĞRETİM FAALİYETLERİ ══
        'J.1' => ['baslik' => 'Bir dönem verilen lisansüstü ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
        'J.2' => ['baslik' => 'Bir dönem verilen lisans veya ön lisans dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 1],
        'I.1k' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 1],
    ],

    'gruplar' => [
        // Dr. Öğr. Üyeliği koşullarının andığı kümeler.
        'ARASTIRMA-MAKALESI' => ['A.*'],
        'ULUSLARARASI-INDEKS' => ['A.1', 'A.2'],
        'MAKALE-KITAP' => ['A.*', 'B.1', 'B.2', 'B.4', 'B.5'],
        // Güzel Sanatlar/Mimarlık dalının alternatifleri: yarışma derecesi,
        // jüri üyeliği ya da uygulama projesi.
        'MIMARLIK-ALTERNATIF' => ['C.3', 'I.3'],
    ],
];
