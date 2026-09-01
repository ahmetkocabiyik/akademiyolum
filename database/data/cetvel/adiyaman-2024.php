<?php

/**
 * ADIYAMAN ÜNİVERSİTESİ — EK-1 Akademik Atamalarda Dikkate Alınacak
 * Puanlama Sistemi
 * Kaynak: pdf/17536926992.adiyamanuniversitesi.pdf (Senato 30/04/2024)
 *
 * TEK ORTAK PUAN TABLOSU, DÖRT ALAN GRUBU İÇİN AYRI EŞİK. Koşullar tabloya
 * HARF ARALIĞIYLA atıf yapıyor: "A-D arası faaliyetlerden en az 300 puan",
 * "N1-N16 arası faaliyetlerden en az 200 puan". Bu yüzden bölüm harfleri
 * kodun parçası olarak korundu.
 *
 * YAZAR SAYISI ÇARPANI VAR (Tablo 1) ve motorun role duyarlı çarpan desteğine
 * birebir oturuyor: 1. isim tek yazarlıda %100, iki yazarlıda %90, altı ve
 * üzerinde %50; ikinci isim sırasıyla %80, %70… Sorumlu yazar birinci isim
 * gibi değerlendiriliyor, bu yüzden 'baslica' rolü 'ilk' ile aynı kademeyi
 * kullanıyor.
 *
 * A.5 GİRİLMEDİ: "1-4. maddelerde belirtilen dergilerde yayımlanan teknik not,
 * editöre mektup, vaka takdimi… adı geçen maddelerde belirtilen puanların
 * YARISINI alır" diyor. Bu bir kalem değil, A.1-A.4'ün üzerine uygulanan bir
 * kural; motorda karşılığı yok. Bu tür yayınlar şimdilik hiç puanlanmıyor
 * (eksik sayma yönünde).
 *
 * GİRİLMEYEN BÖLÜMLER: E (adayın adıyla anılan formül), G (kongre düzenleme),
 * H (kongre derecesi), K (üniversite-sanayi iş birliği), O (sportif
 * faaliyetler), P (kazı ve yüzey araştırması) ve N'nin sanat/tasarım alt
 * kırılımlarının çoğu — kaynak sözlüğünde karşılıkları yok.
 */

return [
    'kapsam_notu' => 'Puanlar Adıyaman Üniversitesi EK-1 Puanlama Sisteminden (30/04/2024). Çok '
        .'yazarlı eserlerde puan yazar sayısına ve sıranıza göre azaltılır (Tablo 1) — bu hesap '
        .'uygulanıyor, ancak YAZAR LİSTESİNİ BOŞ BIRAKTIĞINIZ faaliyetlerde uygulanamaz. Kongre '
        .'düzenleme, üniversite-sanayi iş birliği, sportif faaliyet ve kazı bölümleri ile teknik '
        .'not/editöre mektup türü yayınlar kaynak sözlüğünde karşılıksız olduğu için girilmedi.',

    // Tablo 1: 1. isim (ve sorumlu yazar) tek yazarlıda %100, iki yazarlıda
    // %90, üç %80, dört %70, beş %60, altı ve üzeri %50. Sonraki isimler her
    // kademede birer basamak aşağıda.
    'yazar_katsayisi' => [
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.0]],
            'ilk' => ['kademeler' => [1 => 1.0, 2 => 0.90, 3 => 0.80, 4 => 0.70, 5 => 0.60], 'sonrasi' => 0.50],
            'baslica' => ['kademeler' => [1 => 1.0, 2 => 0.90, 3 => 0.80, 4 => 0.70, 5 => 0.60], 'sonrasi' => 0.50],
            'yazar_2' => ['kademeler' => [2 => 0.80, 3 => 0.70, 4 => 0.60, 5 => 0.50], 'sonrasi' => 0.40],
            'yazar_3' => ['kademeler' => [3 => 0.60, 4 => 0.50, 5 => 0.40], 'sonrasi' => 0.30],
            'yazar_4' => ['kademeler' => [4 => 0.40, 5 => 0.30], 'sonrasi' => 0.20],
            'yazar_5' => ['kademeler' => [5 => 0.20], 'sonrasi' => 0.10],
            'yazar_6' => ['sonrasi' => 0.10],
            // Sırasını belirtmeyen aday o yazar sayısındaki en düşük satırı alır.
            'ortak' => ['kademeler' => [1 => 1.0, 2 => 0.80, 3 => 0.60, 4 => 0.40, 5 => 0.20], 'sonrasi' => 0.10],
        ],
    ],

    'maddeler' => [
        // ── A. MAKALELER ──
        'A.1' => ['baslik' => 'SCI, SSCI veya AHCI taranan dergide orijinal araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 150],
        'A.2' => ['baslik' => 'ÜAK alan indeksleri kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 90],
        'A.3' => ['baslik' => 'Diğer uluslararası hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 70],
        'A.4' => ['baslik' => 'Ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 50],

        // ── B. BİLDİRİLER ──
        'B.1' => ['baslik' => 'Uluslararası kongrede davetli konuşmacı veya tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin', 'Davetli Konuşmacı'], 'puan' => 40],
        'B.2' => ['baslik' => 'Uluslararası kongrede özet veya poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 25],
        'B.3' => ['baslik' => 'Ulusal kongrede bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin', 'Ulusal Özet/Poster'], 'puan' => 20],

        // ── C. KİTAPLAR VE ÇEVİRİLER ──
        'C.1' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 150],
        'C.2' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitap (ders kitabı dâhil)', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı'], 'puan' => 100],
        'C.3' => ['baslik' => 'Kitap bölümü', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 50],
        'C.4' => ['baslik' => 'Kitap veya kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap', 'Çeviri Kitap Bölümü'], 'puan' => 30],

        // ── D. ATIFLAR ──
        'D.1' => ['baslik' => 'Yayınlarınıza yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap', 'TR Dizin', 'Diğer', 'Patent'], 'puan' => 8],

        // ── F. EDİTÖRLÜK VE HAKEMLİK ──
        'F.1' => ['baslik' => 'SCI, SSCI veya AHCI dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 100],
        'F.2.a' => ['baslik' => 'Yurt dışı dergide editörlük (yıl başına)', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 70],
        'F.3.a' => ['baslik' => 'Yurt içinde çıkan hakemli dergide editörlük (yıl başına)', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 50],
        // Yayın kurulu üyeliği üç dergi düzeyinde 40/30/20; kayıt düzeyi
        // taşımadığı için §0 uyarınca en düşükten (F.3.c).
        'F.3.c' => ['baslik' => 'Dergide yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 20],
        'F.3.d' => ['baslik' => 'Dergi hakemliği (her yayın için)', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 10],
        'F.4.a' => ['baslik' => 'Yabancı dilde, yurt dışında yayımlanmış kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 100],
        // Kitap editörlüğü dört kademeli (100/60/50/40); kayıt kitabın dilini ve
        // yayım yerini taşımadığı için §0 uyarınca Türkçe kitap satırından (50).
        'F.5.a' => ['baslik' => 'Türkçe bilimsel veya ders kitabında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 50],

        // ── I. LİSANSÜSTÜ TEZ YÖNETİMİ ──
        'I.1' => ['baslik' => 'Yüksek lisans tezi yönetmiş olmak', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 50],
        'I.2' => ['baslik' => 'Doktora veya tıpta uzmanlık tezi yönetmiş olmak', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 80],
        'I.3' => ['baslik' => 'İkinci danışmanlık veya tez izleme komitesi üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 30],

        // ── J. PROJELER ──
        // J bölümünün ÜÇ SATIRI DA yürütücü/araştırmacı diye ikiye ayrılıyor;
        // cetvel rol ayrımı yapmıyordu ve araştırmacı yürütücü puanını alıyordu
        // (01.09.2026'da ayrıldı).
        'J.1.yur' => ['baslik' => 'Uluslararası destekli sonuçlandırılmış projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 250],
        'J.1.ara' => ['baslik' => 'Uluslararası destekli sonuçlandırılmış projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 100],
        'J.2.yur' => ['baslik' => 'TÜBİTAK, KOSGEB veya bakanlık destekli sonuçlandırılmış projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 200],
        'J.2.ara' => ['baslik' => 'TÜBİTAK, KOSGEB veya bakanlık destekli sonuçlandırılmış projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 75],
        'J.3.yur' => ['baslik' => 'Üniversite (BAP) destekli sonuçlandırılmış projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 50],
        'J.3.ara' => ['baslik' => 'Üniversite (BAP) destekli sonuçlandırılmış projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 25],

        // ── L. PATENTLER ──
        'L.1' => ['baslik' => 'Uluslararası veya PCT patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 500],
        'L.2' => ['baslik' => 'Endüstride kullanılan patent (lisans satışı veya kiralama gerçekleşmiş)', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 400],
        'L.3' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 300],
        'L.4' => ['baslik' => 'Faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 200],
        'L.5' => ['baslik' => 'Marka veya tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili', 'Yazılım'], 'puan' => 100],

        // ── M. ÖDÜLLER ──
        'M.1' => ['baslik' => 'TÜBİTAK veya TÜBA bilim ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'YÖK Ödülü'], 'puan' => 250],
        'M.2' => ['baslik' => 'TÜBİTAK veya TÜBA teşvik ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 150],
        'M.3' => ['baslik' => 'Yurt dışı ödül', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 150],
        // Burs iki kademeli: yurt dışı 150 (M.3), yurt içi 75 (M.4). Kayıt
        // bursun nerede alındığını taşımadığı için §0 uyarınca yurt içinden.
        'M.4' => ['baslik' => 'Doktora sonrası araştırma bursu (en az 6 ay)', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 75],
        // 'Yarışma Derecesi / Mansiyon' M.5'ten çıkarıldı: M.5 "SÜREKLİ VE
        // PERİYODİK olarak verilen, jürili" ödülleri sayıyor, tek seferlik bir
        // yarışma derecesi bu tanıma girmiyor (01.09.2026).
        'M.5' => ['baslik' => 'Sürekli ve periyodik olarak verilen jürili ulusal bilim veya sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 50],

        // ── N. SANAT VE TASARIM ETKİNLİKLERİ ──
        'N.1' => ['baslik' => 'Uluslararası bireysel sergi, bienal veya trienal', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)'], 'puan' => 200],
        'N.2' => ['baslik' => 'Ulusal bireysel sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)'], 'puan' => 150],
        'N.3' => ['baslik' => 'Karma veya grup sergi etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Ulusal)'], 'puan' => 100],
        'N.5' => ['baslik' => 'Senfonik yapıt, oda müziği veya koro eseri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım', 'Albüm / Konser Kaydı'], 'puan' => 100],
        'N.10' => ['baslik' => 'Uluslararası tasarım alanında üretime girmiş çalışma veya koleksiyon', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Yönetmenlik (Sahne/Ekran)'], 'puan' => 200],
        'N.12' => ['baslik' => 'Ulusal tasarım alanında üretime girmiş çalışma veya koleksiyon', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Karma Albüm / CD-DVD Katkısı'], 'puan' => 100],
    ],

    'gruplar' => [
        // Koşulların birebir andığı harf aralıkları.
        'A-D' => ['A.*', 'B.*', 'C.*', 'D.*'],
        'N1-N16' => ['N.*'],
        'A.1' => ['A.1'],
        'MAKALE' => ['A.*'],
    ],

    'grup_tavanlari' => [],
];
