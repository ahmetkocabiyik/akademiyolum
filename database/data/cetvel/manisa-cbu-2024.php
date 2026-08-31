<?php

/**
 * MANİSA CELAL BAYAR ÜNİVERSİTESİ — Akademik Etkinlik Değerlendirmesi (AED)
 * Kaynak: pdf/17537003232.manisacelalbayaruniverstesi.pdf
 *
 * TEK ORTAK PUAN TABLOSU, TEMEL ALAN AYRIMI YOK. Koşullar AED'ye madde
 * NUMARASI ARALIĞIYLA atıf yapıyor ("1-24 maddelerinden en az 800 puan",
 * "28-30. maddelerinden en az 50 puan"), bu yüzden numaralar birebir korundu;
 * bir maddenin a/b/c şıkları varsa harf eklendi (1a, 1b, …).
 *
 * AED BÖLÜMLERİ VE MADDE ARALIKLARI:
 *   A) Makaleler 1-6 · B) Bildiriler 7-8 · C) Kitaplar 9-10
 *   D) Girişim, yenilik ve proje 11-18 · E) Atıflar 19-24
 *   F) Editörlük ve hakemlik 25-27 · G) Öğretim 28 · H) Tez ve jüri 29-31
 *   I) Diğer bilimsel etkinlikler 32-51 · J) Spor 52-53 · K) Sanatsal 54-68
 *
 * YAZAR ÇARPANI KİŞİ SAYISI × SIRA MATRİSİ (Bölüm V): 1 kişilik çalışmada %100,
 * 14 kişilikte 1. isim %35, 6. isimden sonra taban %25. Sorumlu yazar
 * (corresponding author) 1. isimle aynı sayılıyor — `baslica` rolü bu yüzden
 * `ilk` ile aynı satırı kullanıyor.
 *
 * ATIF TAVANI UYGULANMIYOR: yönerge "atıflardan alınan puanlar başvurulan
 * kadronun gerektirdiği toplam puanın %20'sini aşamaz" diyor. Motor yüzdeye
 * bağlı tavan tanımıyor; atıf puanınız yüksekse gerçek toplamınız görünenden
 * DÜŞÜK olabilir.
 *
 * AYNI KAYNAĞA DÜŞEN KALEMLERDE DÜŞÜK OLAN GİRİLDİ:
 *   Patent 11 bireysel/grup ayrımı yapıyor (300/150 karşısında 120/90); kayıt
 *       bu ayrımı taşımadığı için GRUP satırı girildi.
 *   'Kitap Editörlüğü' uluslararası/ulusal ayırmıyor → 26a (60) yerine 26b (45).
 *   'Davetli Konuşmacı' ulusal/uluslararası ayırmıyor → 7'nin iki katı (60)
 *       yerine 8'in iki katı (40).
 *   'Yarışma Derecesi / Mansiyon' derece ve ölçek taşımıyor → 18a (60) yerine
 *       18c'nin en düşük satırı (10).
 *
 * GİRİLEMEYEN BÖLÜMLER: I (32-51 diğer bilimsel etkinlikler), J (52-53 spor) ve
 * K (54-68 performansa dayalı ve sanatsal etkinlikler). Kaynak sözlüğünde
 * karşılıkları yok. K bölümü 1-24 alt barajına GİRMEDİĞİ için o baraj
 * etkilenmiyor, ama GÜZEL SANATLAR VE KONSERVATUVAR ADAYLARININ GENEL TOPLAMI
 * olduğundan düşük çıkar.
 *
 * 24. madde (h-endeks × 5) girilmedi: h-endeks profilde tutulmuyor.
 */

return [
    'kapsam_notu' => 'Puanlar Manisa Celal Bayar Üniversitesi AED tablosundan. Makale, bildiri '
        .'ve kitap kalemlerinde puan çalışmadaki kişi sayısına ve sıranıza göre azaltılır '
        .'(Bölüm V); yazar listesini boş bırakırsanız uygulanamaz. Sorumlu yazar 1. isimle aynı '
        .'sayılır. ATIF TAVANI UYGULANMIYOR: yönerge atıf puanını toplamın %20\'siyle '
        .'sınırlıyor, atıf puanınız yüksekse gerçek toplamınız görünenden düşük olabilir. '
        .'Diğer bilimsel etkinlikler (32-51), spor (52-53) ve sanatsal etkinlikler (54-68) '
        .'bölümleri girilemedi; Güzel Sanatlar ve Konservatuvar adaylarında toplam olduğundan '
        .'düşük çıkar.',

    // Bölüm V — Ortak Çalışmalar İçin Puan Dağılımı Tablosu.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'proje', 'patent', 'editorluk', 'odul', 'egitim_ogretim',
            'tez_danismanligi', 'idari_gorev', 'toplumsal_katki', 'sanatsal_etkinlik'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.0]],
            // 1. isim ve sorumlu yazar aynı satır.
            'ilk' => ['kademeler' => [1 => 1.0, 2 => 1.0, 3 => 0.90, 4 => 0.85, 5 => 0.80,
                6 => 0.75, 7 => 0.70, 8 => 0.65, 9 => 0.60, 10 => 0.55, 11 => 0.50,
                12 => 0.45, 13 => 0.40], 'sonrasi' => 0.35],
            'baslica' => ['kademeler' => [1 => 1.0, 2 => 1.0, 3 => 0.90, 4 => 0.85, 5 => 0.80,
                6 => 0.75, 7 => 0.70, 8 => 0.65, 9 => 0.60, 10 => 0.55, 11 => 0.50,
                12 => 0.45, 13 => 0.40], 'sonrasi' => 0.35],
            'yazar_2' => ['kademeler' => [2 => 0.90, 3 => 0.80, 4 => 0.75, 5 => 0.70, 6 => 0.65,
                7 => 0.60, 8 => 0.55, 9 => 0.50, 10 => 0.45, 11 => 0.40, 12 => 0.35,
                13 => 0.30], 'sonrasi' => 0.25],
            'yazar_3' => ['kademeler' => [3 => 0.70, 4 => 0.65, 5 => 0.60, 6 => 0.55, 7 => 0.50,
                8 => 0.45, 9 => 0.40, 10 => 0.35, 11 => 0.30], 'sonrasi' => 0.25],
            'yazar_4' => ['kademeler' => [4 => 0.55, 5 => 0.50, 6 => 0.45, 7 => 0.40, 8 => 0.35,
                9 => 0.30], 'sonrasi' => 0.25],
            'yazar_5' => ['kademeler' => [5 => 0.40, 6 => 0.35, 7 => 0.30], 'sonrasi' => 0.25],
            'yazar_6' => ['sonrasi' => 0.25],
            // Sırasını belirtmeyen aday o kişi sayısındaki en düşük satırı alır.
            'ortak' => ['kademeler' => [1 => 1.0, 2 => 0.90, 3 => 0.70, 4 => 0.55, 5 => 0.40],
                'sonrasi' => 0.25],
        ],
    ],

    'maddeler' => [
        // ══ A) MAKALELER (1-6) ══
        '1a' => ['baslik' => 'SCI-E, SSCI veya AHCI Q1 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale'], 'puan' => 150],
        '1b' => ['baslik' => 'SCI-E, SSCI veya AHCI Q2 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale'], 'puan' => 120],
        '1c' => ['baslik' => 'SCI-E, SSCI veya AHCI Q3 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale'], 'puan' => 90],
        // AHCI çeyreklik taşımadığı için en düşük satıra yazıldı.
        '1d' => ['baslik' => 'SCI-E, SSCI veya AHCI Q4 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 60],
        '2' => ['baslik' => 'ÜAK alan endeksli veya ESCI dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale'], 'puan' => 50],
        '3' => ['baslik' => 'ULAKBİM TR-Dizin dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 40],
        '4' => ['baslik' => 'Diğer uluslararası hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale'], 'puan' => 20],
        '5' => ['baslik' => 'Diğer ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale'], 'puan' => 15],
        // Madde 6: teknik not, editöre mektup, tartışma, olgu sunusu, özet ve
        // derleme türü yayınlar için yukarıdaki puanların 1/4'ü. Aşağı yuvarlandı.
        '6a' => ['baslik' => 'SCI-E, SSCI veya AHCI Q1 dergide derleme, olgu sunusu veya teknik not', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 37],
        '6b' => ['baslik' => 'SCI-E, SSCI veya AHCI Q2 dergide derleme, olgu sunusu veya teknik not', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 30],
        '6c' => ['baslik' => 'SCI-E, SSCI veya AHCI Q3 dergide derleme, olgu sunusu veya teknik not', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 22],
        '6d' => ['baslik' => 'SCI-E, SSCI veya AHCI Q4 dergide derleme, olgu sunusu veya teknik not', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 15],
        '6e' => ['baslik' => 'ÜAK alan endeksli veya ESCI dergide derleme, olgu sunusu veya teknik not', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 12],
        '6f' => ['baslik' => 'TR-Dizin dergide derleme, olgu sunusu veya teknik not', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 10],
        '6g' => ['baslik' => 'Diğer uluslararası dergide derleme, olgu sunusu veya teknik not', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 5],
        '6h' => ['baslik' => 'Diğer ulusal dergide derleme, olgu sunusu veya teknik not', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 3],

        // ══ B) BİLDİRİLER (7-8) ══
        '7a' => ['baslik' => 'Uluslararası toplantıda sözlü sunulan tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Uluslararası Tam Metin (CPCI)'], 'puan' => 30],
        '7b' => ['baslik' => 'Uluslararası toplantıda sözlü sunulan özet metin bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 15],
        '8a' => ['baslik' => 'Ulusal toplantıda sözlü sunulan tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 20],
        '8b' => ['baslik' => 'Ulusal toplantıda sözlü sunulan özet metin bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 10],
        // Davetli konuşmacılar için 7 ve 8'de belirtilen puanların 2 katı.
        '8d' => ['baslik' => 'Bilimsel toplantıda davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 40],

        // ══ C) KİTAPLAR (9-10) ══
        '9a' => ['baslik' => 'Uluslararası yayınevince yayımlanan kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 100],
        '9b' => ['baslik' => 'Ulusal yayınevince yayımlanan kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı'], 'puan' => 60],
        '9c' => ['baslik' => 'Çeviri kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 20],
        '10a' => ['baslik' => 'Uluslararası yayınevi kitabında bölüm veya ünite yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 30],
        '10b' => ['baslik' => 'Ulusal yayınevi kitabında bölüm veya ünite yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 20],
        '10c' => ['baslik' => 'Çeviri kitapta bölüm veya ünite yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 15],
        '10d' => ['baslik' => 'Ansiklopedi veya sözlükte madde yazarlığı (en fazla 4 madde)', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 5],

        // ══ D) GİRİŞİM, YENİLİK VE PROJE (11-18) ══
        // Kayıt bireysel/grup ayrımı taşımadığı için GRUP satırı girildi.
        '11b1' => ['baslik' => 'Grup patenti (uluslararası, EPA/IPA veya eşdeğeri)', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 120],
        '11b2' => ['baslik' => 'Grup patenti (ulusal)', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 90],
        '11c2' => ['baslik' => 'Faydalı model veya endüstriyel tasarım belgesi (ulusal)', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 45],
        '12a1' => ['baslik' => 'Yurt dışı kaynaklı uluslararası projede koordinatör veya yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 150],
        '12a2' => ['baslik' => 'Yurt dışı kaynaklı uluslararası projede araştırmacı veya danışman', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 90],
        '12b1' => ['baslik' => 'TÜBİTAK, TÜBA, SANTEZ gibi ulusal fon projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 100],
        '12b2' => ['baslik' => 'TÜBİTAK, TÜBA, SANTEZ gibi ulusal fon projesinde araştırmacı veya danışman', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 50],
        '12c1' => ['baslik' => 'Üniversite destekli araştırma projesinde (BAP) yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 40],
        '12c2' => ['baslik' => 'Üniversite destekli araştırma projesinde (BAP) araştırmacı veya danışman', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 30],
        '12e1' => ['baslik' => 'Kamu, sivil toplum veya özel kurumca desteklenen diğer projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 20],
        '12e2' => ['baslik' => 'Kamu, sivil toplum veya özel kurumca desteklenen diğer projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
        '18b' => ['baslik' => 'TÜBİTAK veya TÜBA bilim ödülü (yayın teşvik ödülü hariç)', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü'], 'puan' => 50],
        '18c' => ['baslik' => 'Jürili yarışmada derece veya mansiyon', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 10],
        '18e' => ['baslik' => 'Diğer jürili uluslararası veya ulusal bilim, sanat ya da tasarım ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ulusal Bilim/Sanat Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 5],

        // ══ E) ATIFLAR (19-24) — atıf başına, kişi sayısı dikkate alınmaz ══
        '19' => ['baslik' => 'SCI-E, SSCI, AHCI veya Scopus dergisinde atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 5],
        '20' => ['baslik' => 'Alan endeksli veya TR-Dizin dergisinde atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 4],
        '22' => ['baslik' => 'Diğer ulusal hakemli dergide atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer'], 'puan' => 2],
        '23' => ['baslik' => 'Kitapta veya kitap bölümünde atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 5],

        // ══ F) EDİTÖRLÜK VE HAKEMLİK (25-27) ══
        '25a' => ['baslik' => 'SCI-E, SSCI veya AHCI dergide editörlük (her yıl için)', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 90],
        '25b' => ['baslik' => 'Alan endeksli, ESCI veya TR-Dizin dergide editörlük (her yıl için)', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi', 'TR Dizin Dergi'], 'puan' => 50],
        '25d' => ['baslik' => 'Diğer ulusal hakemli dergide editörlük (her yıl için)', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 15],
        // Yayın kurulu üyeliği 25'in 1/6'sı, hakemlik 1/5'i (yılda en fazla 5).
        '25e' => ['baslik' => 'Dergide yayın kurulu üyeliği (her yıl için)', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 2],
        '25f' => ['baslik' => 'Dergi hakemliği (yılda en fazla 5 hakemlik)', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 3],
        '26b' => ['baslik' => 'Bilimsel kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü', 'BKCI Kitap'], 'puan' => 45],

        // ══ G) ÖĞRETİM FAALİYETLERİ (28) — son beş yıl, yarıyılda en fazla 4 ders ══
        '28a' => ['baslik' => 'Lisansüstü ders (ders başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 8],
        '28b' => ['baslik' => 'Ön lisans veya lisans dersi (ders başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 5],

        // ══ H) TEZ YÖNETİMİ VE JÜRİ ÜYELİĞİ (29-31) ══
        '29a' => ['baslik' => 'Yönetiminde tamamlanan doktora tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi'], 'roller' => ['danisman'], 'puan' => 40],
        '29b' => ['baslik' => 'Yönetiminde tamamlanan tıpta uzmanlık tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 30],
        '29c' => ['baslik' => 'Yönetiminde tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 20],
        // İkinci danışmanlık için puanların 1/2'si.
        '29d' => ['baslik' => 'Tamamlanan doktora tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 20],
        '29e' => ['baslik' => 'Tamamlanan yüksek lisans tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 10],
        '31e' => ['baslik' => 'Tez, yeterlik veya atama jüri üyeliği (yılda en fazla 4 görev)', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 3],
    ],

    'gruplar' => [
        // Koşulların andığı madde aralıkları. Numaralar tek haneli olduğu için
        // '1*' deseni 10-19'u da yakalardı; kodlar TEK TEK sayıldı.
        '1-24' => ['1a', '1b', '1c', '1d', '2', '3', '4', '5',
            '6a', '6b', '6c', '6d', '6e', '6f', '6g', '6h',
            '7a', '7b', '8a', '8b', '8d',
            '9a', '9b', '9c', '10a', '10b', '10c', '10d',
            '11b1', '11b2', '11c2',
            '12a1', '12a2', '12b1', '12b2', '12c1', '12c2', '12e1', '12e2',
            '18b', '18c', '18e',
            '19', '20', '22', '23'],
        '28-30' => ['28a', '28b', '29a', '29b', '29c', '29d', '29e'],
    ],

    // "Atıflardan alınan puanlar toplam puanın %20'sini aşamaz" ve "yılda en
    // fazla 5 hakemlik / 4 jüri görevi" gibi sınırlar faaliyet kaydından ya da
    // yüzdeden türetilemiyor; uygulanmıyor.
    'grup_tavanlari' => [],
];
