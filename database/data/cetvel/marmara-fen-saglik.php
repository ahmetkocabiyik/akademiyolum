<?php

/**
 * MARMARA ÜNİVERSİTESİ — Tablo 2
 * "Sağlık, Fen Bilimleri, Matematik, Mesleki ve Teknik Eğitim Temel Alanları
 * Puanlama Formu"
 * Kaynak: pdf/17537003632.marmarauniverstesi.pdf
 *
 * MADDE NUMARALARI yönergenin kendi numaralandırmasıdır ve koşullar bunlara
 * ARALIK olarak atıf yapıyor: "1-16, 23-26, 32-37, 45, 47-52 numaralı
 * faaliyetlerden en az 42 puan". Bu yüzden numaralar birebir korundu ve
 * gruplar aralık desenleriyle tanımlandı.
 *
 * MARMARA HER TEMEL ALANA AYRI TABLO VERİYOR (Tablo 1-7). Bu dosya yalnızca
 * Tablo 2; sosyal alanlar için marmara-sosyal.php var. Diğer tablolar
 * (Eğitim, Filoloji/Hukuk/İlahiyat, Güzel Sanatlar, Mühendislik, Spor) henüz
 * girilmedi ve o alanlarda eşik üretilmiyor.
 *
 * BELGE ESKİ TERMİNOLOJİ KULLANIYOR: "yardımcı doçent" 2018'de "Dr. Öğretim
 * Üyesi" oldu; kadro aynı olduğu için o koşullar `dr_ogr_uyesi` altına
 * girildi. Yabancı dil koşulunda KPDS/ÜDS anılıyor (2013'te YDS ile
 * değişti) — puan eşikleri korunarak `yds` metriğine bağlandı.
 *
 * KİTAPTA KAPSAM AYRIMI (19.09.2026): tablo 17-20'yi "uzmanlık alanında
 * ULUSLARARASI kitap / kitaba bölüm / kitap editörlüğü" ↔ "ULUSAL …" diye
 * ayırıyor; indeks aranmıyor. Tanımlar maddesi (n) kitabı "saygınlığı olan
 * yayınevlerince basılmış" diye tarif ediyor ama bu koşul iki kademede de
 * aynı, ayrımı yapan tek şey yayınevinin kapsamı. Uluslararası satırlar yalnız
 * BKCI/Scopus etiketiyle yazıldığı için indekssiz uluslararası kitap ULUSAL
 * satırdan sayılıyordu (100 yerine 70, bölümde 60 yerine 20).
 */

return [
    'kapsam_notu' => 'Puanlar Marmara Üniversitesi Tablo 2\'den (Sağlık, Fen, Matematik, Mesleki '
        .'ve Teknik Eğitim). Belge 2018 öncesi terminoloji kullanıyor; kadro adları güncel '
        .'karşılıklarına eşlendi. Akademik organizasyon yöneticiliği (27. satır), İdari faaliyetler (Tablo 8) ve bazı ödül/burs kalemleri '
        .'girilmedi. Gerçek toplamınız burada görünenden yüksek olabilir.'
        .' Kitapta ters yön var: tanım maddesi kitabı "saygınlığı olan yayınevlerince basılmış" diye tarif ediyor ama bu koşul kayıtta olmadığı için denetlenmiyor; yayıneviniz tanıma girmiyorsa kitap puanınız olduğundan YÜKSEK görünür.',

    'maddeler' => [
        // ── MAKALE ── (1-15)
        '1' => ['baslik' => 'Birincil indekslerde taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 48],
        '3' => ['baslik' => 'İkincil indekslerde taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale'], 'puan' => 36],
        '4' => ['baslik' => 'Birincil indekslerde taranan dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme'], 'puan' => 30],
        '5' => ['baslik' => 'İkincil indekslerde taranan dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['derleme'], 'puan' => 24],
        '6' => ['baslik' => 'Hakemli ulusal dergide yabancı dilde makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale'], 'puan' => 18],
        '10' => ['baslik' => 'Hakemli ulusal dergide Türkçe makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 18],
        '12' => ['baslik' => 'Hakemli ulusal dergide Türkçe derleme', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['derleme'], 'puan' => 6],
        '15' => ['baslik' => 'Hakemsiz dergide makale veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 5],

        // ── KİTAP ── (17-21)
        '17' => ['baslik' => 'Uzmanlık alanında uluslararası kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası Kitap', 'Uluslararası Ders / Metot Kitabı'], 'puan' => 100],
        '18' => ['baslik' => 'Uzmanlık alanında uluslararası kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Uluslararası Kitap Bölümü'], 'puan' => 60],
        '19' => ['baslik' => 'Uzmanlık alanında ulusal kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap'], 'puan' => 70],
        '20' => ['baslik' => 'Uzmanlık alanında ulusal kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap Bölümü'], 'puan' => 20],
        '21' => ['baslik' => 'Uzmanlık alanında kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 25],
        '21b' => ['baslik' => 'Uzmanlık alanında makale veya bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 15],

        // ── BİLDİRİ ── (23-26)
        '23' => ['baslik' => 'Uluslararası kongrede tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 24],
        '24' => ['baslik' => 'Uluslararası kongrede özet bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 18],
        '25' => ['baslik' => 'Ulusal kongrede tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 24],
        '26' => ['baslik' => 'Ulusal kongrede özet bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 12],

        // ── DERS ── (32-33)
        '32' => ['baslik' => 'Verdiği lisansüstü ders (yarıyıl başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Yabancı Dilde Ders'], 'puan' => 4],
        '33' => ['baslik' => 'Verdiği lisans/önlisans dersi (yarıyıl başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Değişim Programı Dersi'], 'puan' => 2],

        // ── PROJE ── (34-37)
        '34' => ['baslik' => 'Tamamlanmış projede yöneticilik (uluslararası)', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 40],
        '34c' => ['baslik' => 'Tamamlanmış TÜBİTAK projesinde yöneticilik', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 25],
        '34d' => ['baslik' => 'Tamamlanmış kamu/kurumsal projede yöneticilik', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK', 'BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 15],
        '36' => ['baslik' => 'Tamamlanmış projede katılımcılık (uluslararası)', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 30],
        '36c' => ['baslik' => 'Tamamlanmış TÜBİTAK projesinde katılımcılık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],
        '36d' => ['baslik' => 'Tamamlanmış kamu/kurumsal projede katılımcılık', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK', 'BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],

        // ── DAVETLİ KONUŞMACI ve EDİTÖRLÜK ── (38-42)
        '38-39' => ['baslik' => 'Kongre ya da sempozyumda davetli konuşmacı', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 15],
        '41' => ['baslik' => 'Uluslararası dergide yayın kurulu üyeliği veya editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 10],
        '41b' => ['baslik' => 'Ulusal dergide yayın kurulu üyeliği veya editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Kitap Editörlüğü', 'BKCI Kitap'], 'puan' => 4],
        // Yönergenin her alan tablosunda bu satırlar ULUSLARARASI/ULUSAL diye
        // ikiye ayrılıyor; faaliyet kaydı dergi ya da bursun düzeyini taşımadığı
        // için §0 uyarınca ulusal değerden sayılıyor (01.09.2026).
        '42' => ['baslik' => 'Dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 5],

        // ── ÖDÜL ve BURS ── (45-46)
        '45' => ['baslik' => 'Uluslararası başarı ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'Ufuk Avrupa / ERC Ödülü', 'YÖK Ödülü'], 'puan' => 35],
        '45b' => ['baslik' => 'Ulusal kuruluşlardan başarı ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'Yarışma Derecesi / Mansiyon'], 'puan' => 20],
        '46' => ['baslik' => 'Araştırma bursu', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 10],

        // ── ATIF ── (47)
        '47' => ['baslik' => 'Uluslararası bilimsel dergi veya kitapta atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 40],
        '47b' => ['baslik' => 'Ulusal bilimsel dergi veya kitapta atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 20],

        // ── TEZ DANIŞMANLIĞI ── (49-50)
        '49' => ['baslik' => 'Tamamlanmış doktora/uzmanlık tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 40],
        '50' => ['baslik' => 'Tamamlanmış yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 20],
        '51' => ['baslik' => 'Tez izleme komitesi veya jüri üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 5],

        // ── PATENT ── (52)
        '52' => ['baslik' => 'Patent, faydalı model veya tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent', 'Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Ticarileştirme', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 40],
        '31a2' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 20],
        '31b2' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 15],
    ],

    'gruplar' => [
        // Koşulların birebir kullandığı ARALIKLAR (md. 7/d-2, 13/a, 18/2-a).
        '1-16' => ['1', '3', '4', '5', '6', '10', '12', '15'],
        '17-27' => ['17', '18', '19', '20', '21', '21b', '23', '24', '25', '26'],
        '23-26' => ['23', '24', '25', '26'],
        '32-37' => ['32', '33', '34', '34c', '34d', '36', '36c', '36d'],
        '34-37' => ['34', '34c', '34d', '36', '36c', '36d'],
        '45' => ['45', '45b'],
        '47-52' => ['47', '47b', '49', '50', '51', '52'],
        '49-50' => ['49', '50'],
        // "27, 32-52 numaralı faaliyetler" — doçentlik koşulu.
        '27,32-52' => ['32', '33', '34', '34c', '34d', '36', '36c', '36d', '38', '41', '41b', '42', '45', '45b', '46', '47', '47b', '49', '50', '51', '52'],
        // "17, 18, 27, 34, 41, 49, 50" — profesörlük koşulu.
        'PROF-CEKIRDEK' => ['17', '18', '34', '34c', '34d', '41', '41b', '49', '50'],
        'BIRINCIL' => ['1', '4'],
    ],

    'grup_tavanlari' => [],
];
