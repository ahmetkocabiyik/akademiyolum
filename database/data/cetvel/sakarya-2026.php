<?php

/**
 * SAKARYA ÜNİVERSİTESİ — EK-1: Puanlama Tablosu
 * Kaynak: pdf/1780987685769.sakarya-kriter-09062026.pdf (32 sayfa)
 *
 * TEK ORTAK PUAN TABLOSU, FAKÜLTE GRUBU BAŞINA AYRI EŞİK. EK-1'in 231 ölçütü
 * bütün fakültelerde aynı puanı taşıyor; değişen, hangi ölçüt kümesinden ne
 * kadar puan isteneceği (yonerge/sakarya.php).
 *
 * KODLAR YÖNERGENİN KENDİ KODLARI (1.1a, 2.3d, 14.39…). Eşik tabloları bu
 * kodları TEK TEK sayarak "1. BÖLÜM" gibi kümeler tanımlıyor; bu yüzden aynı
 * kaynak etiketine düşen ölçütler BİRLEŞTİRİLMEDİ. Birleştirilselerdi kümede
 * anılan bir kod cetvelde bulunamaz, o küme sessizce eksik puanlanırdı.
 *
 * ÇAKIŞAN ÖLÇÜTLERDE EN DÜŞÜK PUAN: kaynak sözlüğü iki ölçütü ayıramıyorsa
 * (ör. 2.1a 340 puanlık ERC yürütücülüğü ile 2.1d 270 puanlık MSCA
 * yürütücülüğü tek etikete düşüyor) her ikisi de düşük olan puanı taşıyor.
 * Kod korunur, puan güvenli tarafta kalır — aday puanını eksik görür.
 *
 * GİRİLMEYEN ÖLÇÜTLER: 6. bölüm yurt dışı/yurt içi araştırma faaliyeti,
 * 8. bölüm tasarım, 5. bölümün sanat etkinliği alt kırılımlarının çoğu,
 * 14. bölümün dernek üyeliği/kurs/bilirkişilik kalemleri ve patent BAŞVURUSU
 * satırları. Kaynak sözlüğünde karşılıkları yok.
 */

return [
    'kapsam_notu' => 'Puanlar Sakarya Üniversitesi EK-1 Puanlama Tablosundan. EK-1\'in 231 ölçütünden '
        .'127\'si girildi; yurt dışı araştırma faaliyeti, tasarım, dernek üyeliği ve patent başvurusu '
        .'gibi kalemlerin kaynak sözlüğünde karşılığı yok. Ayrıca sözlüğün ayıramadığı ölçütler en '
        .'düşük puanlarıyla girildi. Gerçek toplamınız burada görünenden yüksek olabilir, düşük olamaz.',

    'maddeler' => [
        '1.1a' => ['baslik' => 'SCI, SCI-E veya SSCI kapsamındaki (Q1 olarak taranan)', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 90],
        '1.1b' => ['baslik' => 'SCOPUS (Q1 olarak taranan) veya SCI, SCI-E, SSCI', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 80],
        '1.1c' => ['baslik' => 'SCOPUS (Q2 olarak taranan) veya SCI, SCI-E, SSCI', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 55],
        '1.1d' => ['baslik' => 'SCOPUS (Q3 olarak taranan) veya SCI, SCI-E, SSCI', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 45],
        '1.1e' => ['baslik' => 'AHCI kapsamındaki dergilerde yayımlanmış araştırma ya da', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 80],
        '1.2a' => ['baslik' => 'SCOPUS kapsamındaki dergilerde (Q4 olarak taranan)', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 25],
        '1.2b' => ['baslik' => 'ESCI kapsamındaki dergilerde yayımlanmış araştırma ya da', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 25],
        '1.3' => ['baslik' => 'ULAKBİM TR-DİZİN tarafından taranan ulusal hakemli', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 20],
        '1.4' => ['baslik' => 'Diğer uluslararası hakemli dergilerde yayımlanmış', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'puan' => 15],
        '1.5' => ['baslik' => 'Diğer ulusal hakemli dergilerde yayımlanmış bilimsel/sanatsal', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 5],
        '1.6a' => ['baslik' => 'SSCI, SCI-E ve AHCI kapsamındaki Q1 ve Q2 olarak taranan', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 15],
        '1.6b' => ['baslik' => 'SSCI, SCI-E ve AHCI kapsamındaki Q3 ve Q4 olarak taranan', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 10],
        '1.7' => ['baslik' => 'SSCI, SCI-E ve AHCI kapsamındaki dergilerde yayımlanan, teknik', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 7],
        '1.8' => ['baslik' => 'ESCI veya SCOPUS kapsamındaki dergilerde yayımlanan, teknik', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 5],
        '2.1a' => ['baslik' => 'Ufuk Avrupa Konsorsiyum, PRIMA, INTERREG, ERC hibe', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 270],
        '2.1b' => ['baslik' => 'Ufuk Avrupa Konsorsiyum, PRIMA, INTERREG, ERC hibe', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 50],
        '2.1c' => ['baslik' => 'Ufuk Avrupa Konsorsiyum, PRIMA ERC hibe programları veya', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 50],
        '2.1d' => ['baslik' => 'MSCA (MSCA&Citizens projeleri hariç) COST 2515 hibe', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 270],
        '2.1e' => ['baslik' => 'MSCA (MSCA&Citizens projeleri hariç) ve COST 2515 hibe', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 50],
        '2.1f' => ['baslik' => 'COST aksiyonunda ilk öneren ekipte partner olarak yer almak (en', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 50],
        '2.2a' => ['baslik' => 'AB uyum süreci (derleme ve rapor hazırlama çalışmaları hariç,', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 30],
        '2.2b' => ['baslik' => 'AB uyum süreci (derleme ve rapor hazırlama çalışmaları hariç,', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
        '2.2c' => ['baslik' => 'AB uyum süreci projelerinde (derleme ve rapor hazırlama çalışmaları', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
        '2.2d' => ['baslik' => 'ERA-NET, Uluslararası İkili veya Çoklu İş Birlikleri, Birleşmiş', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 30],
        '2.2e' => ['baslik' => 'ERA-NET, Uluslararası İkili veya Çoklu İş Birlikleri, Birleşmiş', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
        '2.2f' => ['baslik' => 'ERA-NET, Uluslararası İkili veya Çoklu İş Birlikleri, Birleşmiş', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
        /*
         * TÜBİTAK ETİKETİ PROGRAM KODUNU TAŞIMIYOR — 2.4 KADEMESİNE İNDİRİLDİ.
         *
         * Kaynak TÜBİTAK desteklerini üç kademede puanlıyor: 2.3 (1001, 1003,
         * 1005, 1505, 2232, 2236, 2244, 2247, 3005, 3501 + BOREN, SSB,
         * TENMAK, TAGEM, TÜSEB B) yürütücü 240, 2.4a (1002, 3001 ve TÜSEB A)
         * 80, 2.4d (YÖK DOSAP veya 2213, 2214, 2216, 2218, 2219, 2221) 80.
         * Sözlükteki tek `TÜBİTAK` etiketi program kodunu taşımıyor.
         *
         * 2.3a ilk girişte 240 yerine 120 yazılmıştı (TÜBA'nın 2.3d satırına
         * göre tabanlanmış) ama taban yeterince aşağı çekilmemişti: aynı
         * etiket 2.4'te 80/20 puan alıyor ve `puan()` en yükseği aldığı için
         * her TÜBİTAK yürütücüsü 120 alıyordu. Dosyanın öbür fon aileleri
         * (AB, Diğer Uluslararası Fon, Diğer Kamu Kurumu) zaten tek kademeye
         * indirilmişti; TÜBİTAK ailesi atlanmış. 04.09.2026'da 80/20'ye
         * çekildi (§0).
         */
        '2.3a' => ['baslik' => 'TÜBİTAK (1001, 1003, 1005, 1505, 2232, 2236, 2244, 2247, 3005,', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 80],
        '2.3b' => ['baslik' => 'TÜBİTAK (1001, 1003, 1005, 1505, 2232, 2236, 2244, 2247, 3005,', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
        '2.3c' => ['baslik' => 'TÜBİTAK (1001, 1003, 1005, 1505, 2232, 2236, 2244, 2247, 3005,', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
        '2.3d' => ['baslik' => 'TÜBA projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 80],
        '2.3e' => ['baslik' => 'TÜBA projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
        '2.3f' => ['baslik' => 'TÜBA projesinde danışman/bursiyer olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
        '2.4a' => ['baslik' => 'TÜBİTAK (1002, 3001) ve TÜSEB A destekli projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 80],
        '2.4b' => ['baslik' => 'TÜBİTAK (1002, 3001) ve TÜSEB A destekli projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
        '2.4c' => ['baslik' => 'TÜBİTAK (1002, 3001) ve TÜSEB A destekli projede', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
        '2.4d' => ['baslik' => 'YÖK DOSAP veya TÜBİTAK 2213, 2214, 2216, 2218, 2219, 2221', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 80],
        '2.5a' => ['baslik' => 'T.C. Cumhurbaşkanlığı Strateji ve Bütçe Başkanlığı destekli projede', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 30],
        '2.5b' => ['baslik' => 'T.C. Cumhurbaşkanlığı Strateji ve Bütçe Başkanlığı destekli projede', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
        '2.5c' => ['baslik' => 'Bakanlıklar tarafından destekli projede yürütücü olmak (2547 sayılı', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
        '2.5d' => ['baslik' => 'Bakanlıklar tarafından destekli projede araştırmacı olmak (2547', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 30],
        '2.10a' => ['baslik' => 'Arkeolojik kazı ya da yüzey araştırmasında yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 30],
        '2.10b' => ['baslik' => 'Arkeolojik kazı ya da yüzey araştırmasında araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
        '2.11a' => ['baslik' => 'Jean Monnet projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 30],
        '2.11b' => ['baslik' => 'Jean Monnet projesinde araştırmacı ya da eğitmen olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
        '2.11c' => ['baslik' => 'Başarıyla tamamlanan TÜBİTAK (4004, 4005, 4008, 4009, SAYEM', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
        '2.11d' => ['baslik' => 'Başarıyla tamamlanan TÜBİTAK (4004, 4005, 4008, 4009, SAYEM', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 30],
        '2.11e' => ['baslik' => 'Başarıyla tamamlanan TÜBİTAK (4004, 4005, 4008, 4009, SAYEM', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
        '2.12a' => ['baslik' => 'Başarıyla tamamlanan Özel kuruluşlar (2547 dışındaki TTO ve', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 60],
        '2.12b' => ['baslik' => 'Başarıyla tamamlanan Özel kuruluşlar (2547 dışındaki TTO ve', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
        '2.13a' => ['baslik' => 'Başarıyla tamamlanan Yükseköğretim kurumları tarafından', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 10],
        '2.13b' => ['baslik' => 'Başarıyla tamamlanan Yükseköğretim kurumları tarafından', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 5],
        '2.15' => ['baslik' => 'TÜBİTAK 2209-A, 2209-B, 2242 projelerinde danışman olmak.', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 20],
        '3.1' => ['baslik' => 'Web of Science Book Citation Index/SCOPUS Veri Tabanında', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 70],
        '3.2' => ['baslik' => 'Uluslararası yayınevleri tarafından yayımlanmış özgün kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 40],
        '3.3' => ['baslik' => 'Web of Science Book Citation Index/SCOPUS Veri Tabanında', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 50],
        '3.4' => ['baslik' => 'Uluslararası yayınevleri tarafından yayımlanmış özgün kitapta', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 20],
        '3.5' => ['baslik' => 'Ulusal yayınevleri tarafından yayımlanmış özgün kitap (bilimsel', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 40],
        '3.6' => ['baslik' => 'Ulusal yayınevleri tarafından yayımlanmış özgün kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 20],
        '3.7' => ['baslik' => 'Tam kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 30],
        '3.8' => ['baslik' => 'Kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 5],
        '3.9' => ['baslik' => 'Uluslararası yayımlanan ansiklopedi konusu/maddesi', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 3],
        '3.10' => ['baslik' => 'Ulusal yayımlanan ansiklopedi konusu/maddesi', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 3],
        '4.1a' => ['baslik' => 'Ticarileşmiş uluslararası patent (Patent ofisinden ticarileşme lisansı', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 200],
        '4.1b' => ['baslik' => 'Ticarileşmiş ulusal patent (Patent ofisinden ticarileşme lisansı', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 200],
        '4.2a' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 150],
        '4.3a' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 80],
        '4.4' => ['baslik' => 'Faydalı model belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 60],
        '4.5' => ['baslik' => 'Tasarım belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım'], 'puan' => 30],
        '4.6' => ['baslik' => 'Telif Hakları Genel Müdürlüğünden isteğe bağlı kayıt-tescil', 'kategori' => 'patent', 'kaynaklar' => ['Yazılım'], 'puan' => 10],
        '5.5' => ['baslik' => 'Yurtdışı özgün kişisel sergi etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)'], 'puan' => 80],
        '5.6' => ['baslik' => 'Yurtiçi özgün kişisel sergi etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)'], 'puan' => 40],
        '5.8' => ['baslik' => 'Uluslararası karma/grup sergi etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)'], 'puan' => 20],
        '5.9' => ['baslik' => 'Ulusal karma/grup sergi etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)'], 'puan' => 15],
        '5.14a' => ['baslik' => 'Uluslararası (TV, dijital platform, festival, müze, sanat galerisi, sinema salonu ve kültür merkezlerinde) gös', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)'], 'puan' => 80],
        '5.15a' => ['baslik' => 'Ulusal (TV, dijital platform, festival, müze, sanat galerisi, sinema salonu ve kültür merkezlerinde) gösterimi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'], 'puan' => 40],
        '5.16a' => ['baslik' => 'Uluslararası (TV/Dijital) yayımlanmış kurmaca ya da belgesel türde, kısa/orta/uzun metrajlı TV programları ve ', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Yönetmenlik (Sahne/Ekran)'], 'puan' => 50],
        '5.21' => ['baslik' => 'Özgün sanat eserlerinin, ses ve görüntü CD’lerinin, bestelerin, tasarımların veya yorum çalışmalarının yurt dı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım', 'Albüm / Konser Kaydı'], 'puan' => 30],
        '5.22' => ['baslik' => 'Özgün sanat eserlerinin, ses ve görüntü CD’lerinin, bestelerin, tasarımların veya yorum çalışmalarının yurt iç', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Albüm / CD-DVD Katkısı'], 'puan' => 20],
        '7.1a' => ['baslik' => 'Uluslararası kongre ve sempozyumlarda davetli olarak sunulan', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 12],
        '7.1b' => ['baslik' => 'Uluslararası kongre ve sempozyumlarda davetli olarak sunulan', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 12],
        '7.2' => ['baslik' => 'Uluslararası kongre ve sempozyumlarda sözlü olarak sunulan ve', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 15],
        '7.3' => ['baslik' => 'Uluslararası kongre ve sempozyumlarda sözlü olarak sunulan ve', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 6],
        '7.4' => ['baslik' => 'Uluslararası kongre ve sempozyumlarda poster olarak sunulan', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 6],
        '7.5' => ['baslik' => 'Ulusal kongre ve sempozyumlarda davetli olarak sunulan tebliğ', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 12],
        '7.6' => ['baslik' => 'Ulusal kongre ve sempozyumlarda sözlü olarak sunulan ve tam', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 10],
        '7.7' => ['baslik' => 'Ulusal kongre ve sempozyumlarda sözlü olarak sunulan ve özet', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 4],
        '7.8' => ['baslik' => 'Ulusal kongre ve sempozyumlarda poster olarak sunulan ve', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 4],
        '9.1' => ['baslik' => 'SSCI, SCI-Exp, AHCI, SCOPUS kapsamındaki dergilerde baş', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 40],
        '9.2' => ['baslik' => 'ESCI kapsamındaki dergilerde baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 25],
        '9.3' => ['baslik' => 'SSCI, SCI-Exp, AHCI, SCOPUS, ESCI dışındaki endeksli', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 20],
        '9.4' => ['baslik' => 'SSCI, SCI-Exp, AHCI, SCOPUS kapsamındaki dergilerde baş', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 10],
        '9.5' => ['baslik' => 'ESCI kapsamındaki dergilerde baş editörlük dışındaki diğer', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 10],
        '9.6' => ['baslik' => 'SSCI, SCI-Exp, AHCI, SCOPUS, ESCI dışındaki endeksli', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 10],
        '9.7' => ['baslik' => 'Alanında uluslararası yayımlanan kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 25],
        '9.8' => ['baslik' => 'Alanında ulusal yayımlanan kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 15],
        '9.10' => ['baslik' => 'SSCI, SCI-Exp, AHCI, SCOPUS kapsamındaki dergilerde', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 3],
        '9.11' => ['baslik' => 'ESCI kapsamındaki dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 3],
        '9.12' => ['baslik' => 'Diğer uluslararası endekslerindeki dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 3],
        '9.13' => ['baslik' => 'ULAKBİM, TR-DİZİN tarafından taranan ulusal hakemli', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 5],
        '9.14' => ['baslik' => 'Diğer ulusal indekslerdeki dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 3],
        '10.1a' => ['baslik' => 'TÜBA, YÖK veya TÜBİTAK\'tan alınan bilim ödülü (UBYT hariç)', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'YÖK Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 150],
        '10.1b' => ['baslik' => 'Cumhurbaşkanlığı kültür ve sanat büyük ödülleri', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 15],
        '10.2' => ['baslik' => 'Alanında yurtdışı kurum veya kuruluşlardan alınan bilim', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 25],
        '10.3' => ['baslik' => 'Alanında yurtiçi kamu kurum ve kuruluşlarından alınan', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 15],
        '10.4' => ['baslik' => 'Uluslararası kongre, kurultay, sempozyum, konferans, festival gibi', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 10],
        '10.5' => ['baslik' => 'Ulusal kongre, kurultay, sempozyum, konferans, festival gibi', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 10],
        '11.1' => ['baslik' => 'Öğretim elemanının yazar olarak yer almadığı Book Citation Index,', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 3],
        '11.2' => ['baslik' => 'Öğretim elemanının yazar olarak yer almadığı ulusal kitaplarda ve', 'kategori' => 'atif', 'kaynaklar' => ['Diğer'], 'puan' => 2],
        '11.3' => ['baslik' => 'SSCI, SCI-Exp, AHCI, SCOPUS tarafından taranan dergilerde,', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 5],
        '11.4' => ['baslik' => 'SSCI, SCI-Exp, AHCI, SCOPUS, ESCI dışındaki uluslararası', 'kategori' => 'atif', 'kaynaklar' => ['Diğer'], 'puan' => 2],
        '11.6' => ['baslik' => 'TR Dizin tarafından taranan dergilerdeki, öğretim elemanının yazar', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
        '12.1' => ['baslik' => 'Yönetiminde tamamlanan her DOKTORA/Sanatta Yeterlilik tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 30],
        '12.2' => ['baslik' => 'Yönetiminde tamamlanan her YÜKSEK LİSANS tezi için*', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 20],
        '12.3' => ['baslik' => 'Kurum dışı doktora/uzmanlık/yüksek lisans sınavlarında jüri', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 8],
        '13.1a' => ['baslik' => 'Doktora düzeyinde ders vermek. (Son 3 yılda her ders için) [en', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 10],
        '13.1b' => ['baslik' => 'Yüksek lisans düzeyinde ders vermek. (Son 3 yılda her ders için)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 10],
        '13.2' => ['baslik' => 'Lisans düzeyinde ders vermek. (Son 3 yılda her ders için, her yıl', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders'], 'puan' => 4],
        '13.3' => ['baslik' => 'Ön lisans düzeyinde ders vermek. (Son 3 yıldaki dersler için) [en', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders'], 'puan' => 4],
        '14.23' => ['baslik' => '30 günden daha az devam eden toplumsal katkı projesi', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi'], 'puan' => 20],
        '14.25' => ['baslik' => '30 gün ve üstünde devam eden toplumsal katkı projesi', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi'], 'puan' => 20],
        '14.34' => ['baslik' => 'Resmi Kurumlara, sivil toplum kuruluşlarına ve özel kuruluşlara', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı'], 'puan' => 20],
        '14.38' => ['baslik' => 'Üniversitenin bilim iletişimi (bilim söyleşileri, podcast, video vb.)', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Bilim İletişimi / Popüler Yayın'], 'puan' => 10],
        '14.39' => ['baslik' => 'Rektörlüğe Bağlı Ofis/Koordinatörlüklerde Koordinatör *', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 30],
        '14.40' => ['baslik' => 'Rektörlüğe Bağlı Ofis/Koordinatörlük Koordinatör Yardımcısı *', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 10],
        '14.42' => ['baslik' => 'Araştırma Merkez Müdürlüğü *', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 20],
        '14.43' => ['baslik' => 'Müdür yardımcılığı, Dekan yardımcılığı, Bölüm başkanlığı *', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkanı'], 'puan' => 15],
        '14.44' => ['baslik' => 'Bölüm başkan yardımcılığı *', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı'], 'puan' => 10],
        '14.45' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)', 'Toplantı Düzenleme Başkanlığı (Ulusal)'], 'puan' => 20],
        '14.46' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 10],
        '14.47' => ['baslik' => 'Bilimsel toplantıda oturum başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Uluslararası)', 'Oturum Başkanlığı (Ulusal)'], 'puan' => 10],
        '14.35' => ['baslik' => 'Üniversite kurul ya da komisyonlarında görev almak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 10],
    ],

    'gruplar' => [
        '1' => ['1.*'],
        '2' => ['2.*'],
        '3' => ['3.*'],
        '4' => ['4.*'],
        '5' => ['5.*'],
        '7' => ['7.*'],
        '9' => ['9.*'],
        '10' => ['10.*'],
        '11' => ['11.*'],
        '12' => ['12.*'],
        '13' => ['13.*'],
        '14' => ['14.*'],

        // Tavanı olan tek maddeler ve tavanı PAYLAŞAN madde kümeleri.
        'T-1.3' => ['1.3'],
        'T-1.2b' => ['1.2b'],
        'T-2.15' => ['2.15'],
        'T-3.2' => ['3.2'],
        'T-3.7' => ['3.7'],
        'T-4.6' => ['4.6'],
        'T-5-SERGI' => ['5.5', '5.6'],
        // 11. bölümün tavanı ikiye ayrılıyor: 11.3'ün kendi tavanı var,
        // öteki atıf satırları ortak ve çok daha düşük bir tavanı paylaşıyor.
        'T-ATIF-DIGER' => ['11.1', '11.2', '11.4', '11.6'],
        'T-11.3' => ['11.3'],
    ],

    /*
     * Kaynağın madde ve bölüm tavanları. Hiçbiri girilmemişti (`grup_tavanlari`
     * boş diziydi); tavansız bölüm doğrudan fazla saydırır (§0).
     *
     * "Faaliyetlerin Puanlanması" başlığındaki madde tavanları (2.2 maddesi,
     * 5. sayfa) ile 3, 5, 9, 11 ve 14. bölümlerin tablo başlıklarındaki bölüm
     * tavanları. Kaynak bunların bir kısmını "Bölüm 1 ve Bölüm 2'de bulunan"
     * diye eşik kümesine göre yazıyor; cetvel tek ortak tablo olduğu için
     * tavan doğrudan madde koduna bağlandı.
     *
     * Cetvelde satırı olmayan tavanlar girilmedi: 2.14 (panelistlik 60),
     * 4.7 (buluş bildirimi 25), 14.31 ve 14.32 (40).
     */
    'grup_tavanlari' => [
        'T-1.3' => 60,          // "Bölüm 1 ve Bölüm 2'de bulunan 1.3 yayınları için toplamda en fazla 60 puan"
        'T-1.2b' => 60,         // "… 1.2b. maddesi için toplamda en fazla 60 puan"
        'T-2.15' => 60,         // "Bölüm 1'de bulunan 2.15 projelerinden en fazla 60 puan"
        'T-3.2' => 50,          // "2. Bölümde bulunan 3.2 maddesi için en fazla 50 puan"
        'T-3.7' => 30,          // "Bölüm 2'de yer alan 3.7 maddesi için en fazla 30 puan"
        'T-4.6' => 50,          // "(En fazla 50 puan alınabilir)" — 4.6 satırının kendi notu
        'T-5-SERGI' => 160,     // "5.1, 5.2, 5.5, 5.6, 5.7 maddelerinden toplamda en fazla 160 puan"
        '9' => 300,             // 9. bölüm başlığı: "Bu bölümden en fazla 300 puan alınabilir."
        'T-ATIF-DIGER' => 100,  // 11. bölüm başlığı: "11.3'ün dışındaki atıflardan en fazla 100 puan"
        'T-11.3' => 500,        // "11.3'ten en fazla 500 puan alınır"
        '14' => 300,            // 14. bölüm başlığı: "Bu bölümden en fazla 300 puan alınabilir."
    ],
];
