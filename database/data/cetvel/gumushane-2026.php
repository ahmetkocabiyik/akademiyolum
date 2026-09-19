<?php

/**
 * Gümüşhane Üniversitesi — EK-1 Akademik Faaliyetler Puanlama Cetveli
 * Kaynak: pdf/178176998238.gumushane-kriter-18062026.pdf
 *
 * Madde kodu → (kategori, kaynaklar, roller, puan). Bir faaliyet birden çok
 * maddeye giriyorsa puanı EN YÜKSEK maddeden alınır.
 *
 * GRUP TAVANLARI (yönergede kadroya göre değişiyor, motor henüz kadro bazlı
 * tavan uygulamıyor — burada en yüksek kadronun tavanı kayıtlı):
 *   B. Bildiri  Dr 20P · Doçent 30P · Profesör 40P
 *   C. Kitap    Dr 30P · Doçent 40P · Profesör 60P
 *   D. Atıf     Dr 30P · Doçent 40P · Profesör 60P
 *   E. Proje    en fazla 80P
 *   İ. Lisansüstü en fazla 20P
 *   M. Öğretim  Dr 30P · Doçent 40P · Profesör 60P
 *
 * PROJEKSİYON: 'Uluslararası/Ulusal Kitap' tek etiket olduğu için C2 (uluslararası,
 * 20P) ile C3 (ulusal, 15P) ayrılamıyor; C2'ye bağlandı — ulusal yayınevi kitabı
 * 5 puan fazla sayılır. Kalıcı çözüm etiketi ikiye bölmek.
 * A6/A7 (teknik not, editöre mektup) karşılığı olan bir kaynak etiketi yok.
 *
 * KİTAPTA DÖRT SATIR EKSİKTİ (19.09.2026): kaynağın C3 (ulusal kitap, 15),
 * C7 (uluslararası kitap bölümü, 7), C8 (ulusal kitap çevirisi, 6) ve C9
 * (ders kitabı, 5) satırları cetvelde YOKTU. Genel `Uluslararası/Ulusal Kitap`
 * etiketi C2'de (uluslararası kitap, 20) durduğu için ULUSAL yayınevi kitabı
 * da 20 puan alıyordu; uluslararası kitap bölümü ise C10'un ulusal 3 puanından
 * sayılıyordu. Dört satır açıldı, etiketler kendi kapsamlarına bağlandı.
 */
$YUKSEK = ['ozgun_makale', 'derleme', 'kisa_makale'];

return [
    'maddeler' => [
        // A. MAKALE
        // A6 ve A7 önce girilmemişti: kaynak indeksli dergilerdeki teknik
        // not/mektup/tartışma/vaka takdimi/özet yayınlarını 3 puana, diğer
        // hakemli dergilerdekini 2 puana indiriyor. Yüksek satırlar tür
        // kısıtsız olduğu için editöre mektup kaydeden aday Q1'de 3 yerine
        // 35 puan alıyordu (§0 ihlali).
        //
        // `kisa_makale` YÜKSEK satırlarda bırakıldı: A6/A7'nin listesinde
        // "kısa makale" geçmiyor, A1-A5 ise "araştırma makalesi" diyor ve
        // brief communication bir araştırma makalesidir.
        //
        // `derleme` de yüksek satırlarda: A4 "diğer uluslararası hakemli
        // dergilerde araştırma makalesi VEYA DERLEME 5" diyor, A7 aynı
        // dergilerdeki derlemeye 2 diyor. Kaynağın kendi çelişkisi;
        // A4/A5 daha açık olduğu için onlar esas alındı.
        'A6' => ['baslik' => 'SCI, SCIE, SSCI, AHCI, ESCI ya da SCOPUS dergide teknik not, mektup, tartışma, vaka takdimi ya da özet', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI', 'ESCI', 'Scopus (Q1)', 'Scopus (Q2)', 'Scopus (Q3)', 'Scopus (Q4)'], 'turler' => ['vaka_teknik_not'], 'puan' => 3],
        'A7' => ['baslik' => 'Diğer ulusal ya da uluslararası hakemli dergide editöre mektup, araştırma notu, teknik not, vaka takdimi, özet ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'], 'turler' => ['vaka_teknik_not'], 'puan' => 2],
        'A1a' => ['baslik' => 'WOS Q1 dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $YUKSEK, 'puan' => 35],
        // ── ÇAPRAZ EŞLEME ──
        // Kaynak her basamakta WoS ile Scopus çeyrekliğini BİR BASAMAK KAYDIRARAK
        // eşliyor: "WOS Q2 VEYA SCOPUS Q1", "WOS Q3 veya SCOPUS Q2"… Satır
        // başlıkları bunu zaten söylüyordu ama Scopus tarafının etiketi yoktu;
        // Scopus makalesi A2'ye (15) düşüyordu. 17.09.2026'da bağlandı.
        'A1b' => ['baslik' => 'WOS Q2 veya SCOPUS Q1 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)', 'AHCI', 'Scopus (Q1)'], 'turler' => $YUKSEK, 'puan' => 28],
        'A1c' => ['baslik' => 'WOS Q3 veya SCOPUS Q2 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)', 'Scopus (Q2)'], 'turler' => $YUKSEK, 'puan' => 22],
        'A1d' => ['baslik' => 'WOS Q4 veya SCOPUS Q3 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'Scopus (Q3)'], 'turler' => $YUKSEK, 'puan' => 18],
        // Kaynak A2'de Scopus'un yalnız Q4'ünü sayıyor; genel etiket bütün
        // çeyreklikleri buraya topluyordu.
        'A2' => ['baslik' => 'ESCI/SPORTDiscus/SCOPUS Q4 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI', 'Scopus (Q4)'], 'turler' => $YUKSEK, 'puan' => 15],
        'A3' => ['baslik' => 'TR Dizin dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $YUKSEK, 'puan' => 10],
        'A4' => ['baslik' => 'Diğer uluslararası hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $YUKSEK, 'puan' => 5],
        'A5' => ['baslik' => 'TR Dizin dışı ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $YUKSEK, 'puan' => 4],

        // B. BİLDİRİ
        'B2-B6' => ['baslik' => 'Bilimsel etkinlikte çağrılı konuşmacı', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 5],
        // SÖZLÜ/POSTER ekseni sözlükte YOK: `Özet/Poster` etiketi hem özet
        // hem POSTER satırlarını taşıdığı için hepsinin en düşüğünü alır.
        // B4: sözlü tam 6 · sözlü özet-veya-poster 4 · poster tam 3 · poster
        // özet 2 → 2. B8: 5 · 3 · 2 · 1 → 1. Önce yalnız b bentleri (4 ve 3)
        // yazılmıştı, yani posteri olan aday sözlü özet puanı alıyordu.
        'B4a' => ['baslik' => 'Uluslararası etkinlikte sözlü/tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 6],
        'B4b' => ['baslik' => 'Uluslararası etkinlikte özet/poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 2],
        'B8a' => ['baslik' => 'Ulusal etkinlikte sözlü/tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 5],
        'B8b' => ['baslik' => 'Ulusal etkinlikte özet/poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 1],

        // C. KİTAP
        'C1' => ['baslik' => 'BKCI veya Scopus kapsamındaki kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 30],
        'C2' => ['baslik' => 'Uluslararası yayınevi kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası Kitap'], 'puan' => 20],
        'C3' => ['baslik' => 'Ulusal yayınevleri tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap'], 'puan' => 15],
        'C4' => ['baslik' => 'BKCI veya Scopus kapsamındaki kitap bölümü', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 15],
        'C5' => ['baslik' => 'Tahkik (tenkitli metin neşri)', 'kategori' => 'kitap', 'kaynaklar' => ['Tahkik (Tenkitli Metin)'], 'puan' => 15],
        'C6' => ['baslik' => 'Uluslararası yayınevinde kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası Çeviri Kitap'], 'puan' => 8],
        'C7' => ['baslik' => 'Uluslararası yayınevleri tarafından yayımlanmış kitap bölümü', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası Kitap Bölümü'], 'puan' => 7],
        'C8' => ['baslik' => 'Ulusal yayınevlerinde yayımlanmış kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Çeviri Kitap'], 'puan' => 6],
        'C9' => ['baslik' => 'Ulusal ya da uluslararası yayınevinde yayımlanmış ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 5],
        'C10' => ['baslik' => 'Ulusal yayınevinde kitap bölümü', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap Bölümü', 'Çeviri Kitap Bölümü'], 'puan' => 3],
        'C11' => ['baslik' => 'Ansiklopedi bölüm/maddesi', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 1],

        // D. ATIF
        // Sözlük 16.09.2026'da atıfta ESCI'yi çekirdek indeksten ayırdı.
        'D1' => ['baslik' => 'SCI/SCIE/SSCI/AHCI kapsamında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 5],
        'D4' => ['baslik' => 'ESCI, Scopus veya SPORTDiscus kapsamında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 3],
        'D2' => ['baslik' => 'BKCI kapsamındaki kitapta yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 4],
        'D6' => ['baslik' => 'TR Dizin kapsamında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
        'D7' => ['baslik' => 'Patentlerde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Patent'], 'puan' => 2],
        'D10' => ['baslik' => 'Diğer ulusal/uluslararası dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer'], 'puan' => 1],

        // E. PROJE — puan fon kaynağı × role göre (yönergede "60/40" = yürütücü/araştırmacı)
        'E1y' => ['baslik' => 'AB Çerçeve projesinde koordinatör/yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 60],
        'E1a' => ['baslik' => 'AB Çerçeve projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 40],
        'E2y' => ['baslik' => 'Diğer uluslararası kuruluş projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 40],
        'E2a' => ['baslik' => 'Diğer uluslararası kuruluş projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 30],
        'E3' => ['baslik' => 'TÜBİTAK/Kalkınma Bakanlığı/TÜBA projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 40],
        'E3a' => ['baslik' => 'TÜBİTAK projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
        'E4' => ['baslik' => 'Kamu kuruluşu Ar-Ge projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 30],
        'E5' => ['baslik' => 'Özel kuruluş Ar-Ge projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 20],
        'E6' => ['baslik' => 'BAP projesi', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'puan' => 12],
        'E9' => ['baslik' => 'TÜBİTAK 2209 A/B öğrenci projesi', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'puan' => 3],

        // İ. LİSANSÜSTÜ EĞİTİM
        'İ1' => ['baslik' => 'Tamamlanmış doktora tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 10],
        'İ2' => ['baslik' => 'Tamamlanmış yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 6],
        'İ3' => ['baslik' => 'Doktora tez izleme jüri üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 3],

        // P. SANATSAL ETKİNLİKLER — TABLO-4 (Güzel Sanatlar) bu gruba dayanıyor.
        'P1' => ['baslik' => 'Yurt dışı kurumlarca satın alınan/yayında yer alan özgün eser', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Yayında Yer Alması / Satın Alınması'], 'puan' => 40],
        'P2' => ['baslik' => 'Yurt dışında uluslararası jürili kişisel sanat etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)'], 'puan' => 40],
        'P3' => ['baslik' => 'Yurt içi kurumlarca satın alınan/yayında yer alan özgün eser', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Satın Alınması (Yurt İçi)'], 'puan' => 30],
        'P4' => ['baslik' => 'Yurt dışında ulusal jürili kişisel etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)'], 'puan' => 25],
        'P5' => ['baslik' => 'Yurt dışında uluslararası jürili karma etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)'], 'puan' => 20],
        'P6' => ['baslik' => 'Yurt dışında ulusal jürili karma/grup etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Ulusal Jürili)'], 'puan' => 18],
        'P7' => ['baslik' => 'Yurt dışında jürisiz kişisel etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Yurt Dışı, Jürisiz)'], 'puan' => 16],
        'P8' => ['baslik' => 'Yurt içinde uluslararası jürili kişisel etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)'], 'puan' => 15],
        'P9' => ['baslik' => 'Yurt içinde uluslararası jürili karma/grup etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt İçi, Uluslararası Jürili)'], 'puan' => 10],
        'P10' => ['baslik' => 'Yurt dışında jürisiz karma/grup etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Jürisiz)'], 'puan' => 10],
        'P11' => ['baslik' => 'Yurt içinde jürisiz kişisel etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Yurt İçi, Jürisiz)'], 'puan' => 8],
        'P12' => ['baslik' => 'Yurt içinde ulusal jürili kişisel etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)'], 'puan' => 8],
        'P13' => ['baslik' => 'Yurt içinde ulusal jürili karma/grup etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)'], 'puan' => 5],
        'P14' => ['baslik' => 'Uluslararası sempozyum/festival/bienal katılımı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 5],
        'P15' => ['baslik' => 'Yurt içinde jürisiz karma etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Jürisiz, Ulusal)'], 'puan' => 4],
        'P16' => ['baslik' => 'Ulusal sempozyum/festival/çalıştay katılımı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 3],

        // M. ÖĞRETİM
        'M1' => ['baslik' => 'Lisansüstü seviyede verilen her bir ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 5],
        'M2' => ['baslik' => 'Değişim programı çerçevesinde verilen ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Değişim Programı Dersi', 'Yabancı Dilde Ders'], 'puan' => 5],
        'M3' => ['baslik' => 'Lisans/önlisans seviyesinde verilen her bir ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders'], 'puan' => 4],
        'M4' => ['baslik' => 'Eğitim-öğretim danışmanlığı (yıllık)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Akreditasyon Faaliyeti'], 'puan' => 2],

        'T1' => ['baslik' => 'Lisansüstü tezden üretilmiş yayın', 'kategori' => 'tez_yayini', 'puan' => 10],

        // ── G. PATENTLER, FAYDALI MODEL VE ENDÜSTRİYEL TASARIMLAR ──
        // Yönerge slash ile birden çok kalemi tek satırda veriyor:
        // "G2. Uluslararası tescillenmiş patent / faydalı model ve tasarım 60/30".
        //
        // Faydalı model ve tasarım için uluslararası (30) ile ulusal (20) ayrımı
        // kaynak sözlüğümüzde YOK. Düşük değer alındı: `puan()` en yükseği
        // aldığı için 30 yazılsaydı her ulusal faydalı model uluslararası gibi
        // puanlanırdı.
        'G1' => ['baslik' => 'Ticarileştirilmiş patent sahipliği (buluş sahibi olmak şartıyla)', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 70],
        'G2' => ['baslik' => 'Uluslararası tescillenmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 60],
        'G3' => ['baslik' => 'Ulusal tescillenmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 40],
        'G3b' => ['baslik' => 'Tescillenmiş faydalı model veya endüstriyel tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım'], 'puan' => 20],
        'N6' => ['baslik' => 'Spor federasyonunun yönetim, teknik, eğitim ya da hakem kurulunda görev', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Spor Federasyonu Kurul Üyeliği (Uluslararası)'], 'puan' => 12],
        'N6-ulusal' => ['baslik' => 'Spor federasyonunun yönetim, teknik, eğitim ya da hakem kurulunda görev', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Spor Federasyonu Kurul Üyeliği (Ulusal)'], 'puan' => 12],
        'B5' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Ulusal)'], 'puan' => 7],
        'B1' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 10],
        'B9' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 1],
    ],

    'gruplar' => [
        // Yönergenin EK-2 tablolarının atıf yaptığı grup adları.
        'A' => ['A*'],
        'A1-A2' => ['A1a', 'A1b', 'A1c', 'A1d', 'A2'],
        'A1-A3' => ['A1a', 'A1b', 'A1c', 'A1d', 'A2', 'A3'],
        'A1' => ['A1a', 'A1b', 'A1c', 'A1d'],
        'B' => ['B*'],
        'C' => ['C*'],
        'D' => ['D*'],
        'E' => ['E*'],
        'E1-E7' => ['E1y', 'E1a', 'E2y', 'E2a', 'E3', 'E3a', 'E4', 'E5', 'E6'],
        'İ' => ['İ*'],
        'İ1-İ2' => ['İ1', 'İ2'],
        'M' => ['M*'],
        'P' => ['P*'],
        'M3-M4' => ['M3', 'M4'],
        'G' => ['G*'],
    ],

    'grup_tavanlari' => [
        'B' => 40,
        'C' => 60,
        'D' => 60,
        'E' => 80,
        'İ' => 20,
        'M' => 60,
        // "Bu madde kapsamında en fazla 60P alınabilir."
        'P' => 60,
        // "Bu bölümden en fazla 100P alınabilir."
        'G' => 100,
    ],
];
