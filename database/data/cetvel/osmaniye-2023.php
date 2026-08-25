<?php

/**
 * OSMANİYE KORKUT ATA ÜNİVERSİTESİ — Ek-1: Akademik Faaliyet ve Etkinlik
 * Puanları
 * Kaynak: pdf/17537010842.osmaniyekorkutatauniverstesi.pdf (01/01/2023 yürürlük)
 *
 * TEK ORTAK PUAN TABLOSU, ALANA GÖRE ÇOK AYRINTILI ÖZEL ŞARTLAR. Koşullar
 * tabloya madde koduyla atıf yapıyor ("1.1.1 maddesinden 1 çalışma veya
 * 1.1.2/1.1.3/1.2.1 maddelerinden en az biri 1.1.2 maddesinden olmak koşuluyla
 * 2 çalışma"), bu yüzden kodlar birebir korundu.
 *
 * NUMARALAR TEK HANELİ; GRUP DESENİNDE NOKTA ŞART: '1*' deseni 10-13'ü de
 * yakalar. Bütün gruplarda '1.*' biçimi kullanıldı.
 *
 * DR. ÖĞR. ÜYELİĞİNDE PUAN DEĞİL ÇALIŞMA SAYISI İSTENİYOR (Tablo 1) — korpusta
 * ender. On iki temel alanın her biri farklı bir sayım kuralı taşıyor; puan
 * barajı yalnızca yeniden atamada ve üst kadrolarda var.
 *
 * YAZAR ÇARPANI SAYI × SIRA MATRİSİ (Tablo 4): 1 yazarlı 1,00; 2 yazarlıda
 * 0,95/0,85; 3 yazarlıda 0,90/0,80/0,75; 4 ve fazlasında 0,80/0,70/0,60 ve
 * 4. isimden sonrası 0,50.
 *
 * İKİ GRUP TAVANI VAR VE UYGULANDI: atıflar (5) en fazla 75 puan, dergi
 * editörlüğü ve hakemlik (9) en fazla 75 puan.
 *
 * PROJE ORANLARI GÖMÜLDÜ: 6.1'de yürütücü 150 · araştırmacı 50 · danışman 30;
 * 6.2'de 100 · 30 · 15. Yönergenin "bu maddede adı geçen kuruluşlar dışındaki
 * uluslararası projeler için puanların %30'u alınır" kuralı uygulanmıyor —
 * kayıt fon kuruluşunu bu ayrıntıda tutmuyor.
 *
 * AYNI KAYNAĞA DÜŞEN KALEMLERDE DÜŞÜK OLAN GİRİLDİ:
 *   'Kitap Editörlüğü' uluslararası/ulusal ayırmıyor → 2.1.2 (30) yerine
 *       2.2.2 (20).
 *   'Hakemlik' ve 'Yayın Kurulu Üyeliği' dergi düzeyi taşımıyor → 9.4 (2).
 *   'Davetli Konuşmacı' ulusal/uluslararası ayırmıyor → 4.2.4 (3).
 *
 * GİRİLMEYEN KALEMLER: 3 (çeviri alt kırılımları), 7 (yurt dışı görevlendirme
 * süreleri — profilde tutulmuyor), 8.4 (komisyon ve kulüp danışmanlıkları),
 * 10.1.1-10.1.2 (puan sütunu ayrıştırılamadı), 11.9, 12.3 ve sonrası.
 */

return [
    'kapsam_notu' => 'Puanlar Osmaniye Korkut Ata Üniversitesi Ek-1 tablosundan. Puan yazar '
        .'sayınıza ve sıranıza göre azaltılır (Tablo 4). Atıf (en fazla 75) ve dergi '
        .'editörlüğü-hakemlik (en fazla 75) tavanları uygulanıyor. Uluslararası projelerde '
        .'yönergenin "listede olmayan kuruluşlar için puanın %30\'u" kuralı uygulanmıyor; fon '
        .'kuruluşu kayıtta bu ayrıntıda tutulmuyor. Sanatsal etkinliklerin bir kısmı (10.1.1 ve '
        .'10.1.2) puan sütunu ayrıştırılamadığı için girilemedi.',

    // Tablo 4 — Akademik çalışmalarla ilgili katkı oranları.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'proje', 'patent', 'editorluk', 'odul', 'egitim_ogretim',
            'tez_danismanligi', 'idari_gorev', 'toplumsal_katki'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.0]],
            'ilk' => ['kademeler' => [1 => 1.0, 2 => 0.95, 3 => 0.90], 'sonrasi' => 0.80],
            'baslica' => ['kademeler' => [1 => 1.0, 2 => 0.95, 3 => 0.90], 'sonrasi' => 0.80],
            'yazar_2' => ['kademeler' => [2 => 0.85, 3 => 0.80], 'sonrasi' => 0.70],
            'yazar_3' => ['kademeler' => [3 => 0.75], 'sonrasi' => 0.60],
            'yazar_4' => ['sonrasi' => 0.50],
            'yazar_5' => ['sonrasi' => 0.50],
            'yazar_6' => ['sonrasi' => 0.50],
            'ortak' => ['kademeler' => [1 => 1.0, 2 => 0.85, 3 => 0.75], 'sonrasi' => 0.50],
        ],
    ],

    'maddeler' => [
        // ══ 1. MAKALELER ══
        '1.1.1a' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI Q1 dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 100],
        '1.1.1b' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI Q2 dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 80],
        '1.1.1c' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI Q3 dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 60],
        '1.1.1d' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI Q4 dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 50],
        '1.1.2' => ['baslik' => 'ÜAK alan indeksli dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 40],
        '1.1.3' => ['baslik' => 'SCI veya alan indeksli dergide vaka takdimi, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI', 'ESCI / Scopus'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 30],
        '1.1.4' => ['baslik' => 'Diğer uluslararası indeksli dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 20],
        '1.2.1' => ['baslik' => 'ULAKBİM TR Dizin dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 15],
        '1.2.2' => ['baslik' => 'Alanla ilgili diğer hakemli dergide yayın', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 5],
        '1.2.4' => ['baslik' => 'Bilimsel ansiklopedide madde yazarlığı (en çok 5 madde)', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 5],

        // ══ 2. KİTAPLAR ══
        '2.1.1' => ['baslik' => 'Uluslararası yayınevince basılmış bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI Kitap', 'BKCI / Scopus Kitap'], 'puan' => 50],
        '2.1.3' => ['baslik' => 'Uluslararası yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 25],
        '2.2.1' => ['baslik' => 'Ulusal yayınevince basılmış bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 30],
        '2.2.2' => ['baslik' => 'Bilimsel kitap editörlüğü', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 20],
        '2.2.3' => ['baslik' => 'Ulusal yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 10],
        '2.2.4' => ['baslik' => 'Ders kitabı yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 15],

        // ══ 3. ÇEVİRİLER ══
        '3.1' => ['baslik' => 'Alanında bilimsel kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap', 'Çeviri Kitap Bölümü'], 'puan' => 15],

        // ══ 4. BİLDİRİLER ══
        '4.1.1' => ['baslik' => 'Uluslararası kongrede tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Uluslararası Tam Metin (CPCI)'], 'puan' => 10],
        '4.1.2' => ['baslik' => 'Uluslararası kongrede özet metin bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 5],
        '4.2.1' => ['baslik' => 'Ulusal kongrede tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 7],
        '4.2.2' => ['baslik' => 'Ulusal kongrede özet metin bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 3],
        '4.2.4' => ['baslik' => 'Kongre veya sempozyumda davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 3],

        // ══ 5. ATIFLAR (en fazla 75 puan) ══
        '5.1' => ['baslik' => 'Uluslararası kitap veya alan indeksli dergide atıf (atıf başına)', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 3],
        '5.2' => ['baslik' => 'Ulusal kitap veya makalede atıf (atıf başına)', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer'], 'puan' => 1],

        // ══ 6. ARAŞTIRMA PROJELERİ (sonuçlandırılmış) ══
        '6.1a' => ['baslik' => 'AB, NATO, UN gibi uluslararası kuruluş projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 150],
        '6.1b' => ['baslik' => 'AB, NATO, UN gibi uluslararası kuruluş projesinde araştırmacı ya da bursiyer olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 50],
        '6.1c' => ['baslik' => 'AB, NATO, UN gibi uluslararası kuruluş projesinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['danisman'], 'puan' => 30],
        '6.2a' => ['baslik' => 'TÜBİTAK, UDAP veya bakanlık destekli projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 100],
        '6.2b' => ['baslik' => 'TÜBİTAK, UDAP veya bakanlık destekli projede araştırmacı ya da bursiyer olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 30],
        '6.2c' => ['baslik' => 'TÜBİTAK, UDAP veya bakanlık destekli projede danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['danisman'], 'puan' => 15],
        '6.4' => ['baslik' => 'BAP, kalkınma ajansı veya özel kuruluş destekli araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'], 'puan' => 3],

        // ══ 8. EĞİTİM ETKİNLİKLERİ ══
        '8.1' => ['baslik' => 'Danışmanlığında tamamlanan doktora veya uzmanlık tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 25],
        '8.1b' => ['baslik' => 'Doktora veya uzmanlık tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 12],
        '8.2' => ['baslik' => 'Danışmanlığında tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 10],
        '8.2b' => ['baslik' => 'Yüksek lisans tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 5],
        '8.3' => ['baslik' => 'Ön lisans, lisans veya lisansüstü ders (son üç yılda her ders için)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 4],

        // ══ 9. DERGİ EDİTÖRLÜĞÜ VE HAKEMLİK (en fazla 75 puan) ══
        '9.1' => ['baslik' => 'SCI, SSCI veya AHCI dergide baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 10],
        '9.2' => ['baslik' => 'Diğer uluslararası indeksli dergide baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 3],
        '9.3' => ['baslik' => 'ULAKBİM TR Dizin dergide baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 3],
        '9.4' => ['baslik' => 'Diğer ulusal hakemli dergide editörlük, yayın kurulu üyeliği veya hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi', 'Yayın Kurulu Üyeliği', 'Hakemlik', 'BKCI Kitap'], 'puan' => 2],

        // ══ 10. SANATSAL ETKİNLİKLER ══
        '10.1.3' => ['baslik' => 'Uluslararası sempozyum, festival veya bienale eserleriyle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Resital (Uluslararası)', 'Solistlik (Uluslararası)', 'Masterclass (Uluslararası)'], 'puan' => 40],
        '10.1.4' => ['baslik' => 'Uluslararası kişisel sergi veya eserin satın alınması ya da yayında yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Haber Olması (Uluslararası)', 'Elektronik Kişisel Sergi (Uluslararası)'], 'puan' => 30],
        '10.1.5' => ['baslik' => 'Uluslararası sanat etkinliğinde icracı olarak yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Uluslararası)', 'Opera Birinci Rol (Uluslararası)', 'Koro Şefliği (Uluslararası)', 'Orkestra Şefliği (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Karma Sergi (Uluslararası)'], 'puan' => 20],
        '10.2.3' => ['baslik' => 'Ulusal sempozyum, festival veya bienale eserleriyle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Resital (Ulusal)', 'Solistlik (Ulusal)', 'Masterclass (Ulusal)'], 'puan' => 20],
        '10.2.4' => ['baslik' => 'Ulusal kişisel sergi veya eserin satın alınması ya da yayında yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Haber Olması (Ulusal)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 15],
        '10.2.5' => ['baslik' => 'Ulusal sanat etkinliğinde icracı olarak yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Ulusal)', 'Orkestra / Koro Üyeliği', 'Opera Birinci Rol (Ulusal)', 'Koro Şefliği (Ulusal)', 'Orkestra Şefliği (Ulusal)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Ulusal)', 'Özgün Eser / Beste / Tasarım'], 'puan' => 10],

        // ══ 11. ÖDÜLLER VE PATENTLER ══
        '11.1' => ['baslik' => 'Uluslararası ödül', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 50],
        '11.2' => ['baslik' => 'Ulusal ödül', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 30],
        '11.3' => ['baslik' => 'Üniversite ödülü veya yarışma derecesi', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 15],
        '11.4' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 150],
        '11.5' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Patent'], 'puan' => 100],
        '11.6' => ['baslik' => 'Uluslararası veya ulusal faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 40],
        '11.7' => ['baslik' => 'Tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım'], 'puan' => 20],
        '11.8' => ['baslik' => 'Uluslararası araştırma bursu', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 15],

        // ══ 12. İDARİ GÖREVLER ══
        '12.1' => ['baslik' => 'Rektörlük (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör'], 'puan' => 20],
        '12.2' => ['baslik' => 'Rektör yardımcılığı, dekanlık veya müdürlük (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü', 'Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkanı', 'Bölüm Başkan Yardımcısı', 'Uygulama ve Araştırma Merkezi Müdürü', 'Anabilim Dalı Başkanı / Koordinatörlük', 'Senato / Üniversite Yönetim Kurulu Üyesi', 'Kurul / Komisyon Üyeliği'], 'puan' => 15],

        // ══ 13. JÜRİ ÜYELİKLERİ ══
        '13.5' => ['baslik' => 'Tez izleme komitesi veya tez savunma jürisi üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 1],
    ],

    'gruplar' => [
        // Koşulların birebir andığı madde kodları ve kümeleri.
        // Nokta ŞART: '1*' deseni 10-13'ü de yakalar.
        '1.1.1' => ['1.1.1*'],
        '1.1.2' => ['1.1.2'],
        '1.1.3' => ['1.1.3'],
        '1.1.4' => ['1.1.4'],
        '1.2.1' => ['1.2.1'],
        '1.2.2' => ['1.2.2'],
        '2.1.1' => ['2.1.1'],
        '2.1.3' => ['2.1.3'],
        '2.2.1' => ['2.2.1'],
        '2.2.3' => ['2.2.3'],
        '4.1.1' => ['4.1.1'],
        // "1.1 maddesinden (1.1.4 hariç)" biçimindeki kümeler.
        '1.1 (1.1.4 hariç)' => ['1.1.1*', '1.1.2', '1.1.3'],
        '1.1/1.2 (1.1.4 ve 1.2.4 hariç)' => ['1.1.1*', '1.1.2', '1.1.3', '1.2.1', '1.2.2'],
        '1' => ['1.*'],
        '1/2 (2.2.4 hariç)' => ['1.*', '2.1.1', '2.1.3', '2.2.1', '2.2.2', '2.2.3'],
        '2.1' => ['2.1.*'],
        '4' => ['4.*'],
        '6' => ['6.*'],
        '8' => ['8.*'],
        '10' => ['10.*'],
        '11' => ['11.*'],
        '1.1.1/6/11.4/11.5' => ['1.1.1*', '6.*', '11.4', '11.5'],
        '2.1.1/2.2.1' => ['2.1.1', '2.2.1'],
        '2.1.3/2.2.3' => ['2.1.3', '2.2.3'],
        '1.2.1/4.1.1' => ['1.2.1', '4.1.1'],
        '1.2.1/1.2.2' => ['1.2.1', '1.2.2'],
        '1.1.1/1.1.2' => ['1.1.1*', '1.1.2'],
        '1.1.2/1.2.1' => ['1.1.2', '1.2.1'],
        '1.1.2/1.1.3/1.1.4' => ['1.1.2', '1.1.3', '1.1.4'],
        '1.1.2/1.1.3/1.2.1' => ['1.1.2', '1.1.3', '1.2.1'],
        '1.1.1/1.1.2/1.1.3/1.2.1' => ['1.1.1*', '1.1.2', '1.1.3', '1.2.1'],
        '1.2.1/2.1.1/2.1.3/2.2.1/4.1.1' => ['1.2.1', '2.1.1', '2.1.3', '2.2.1', '4.1.1'],
        'ATIF' => ['5.*'],
        'EDITORLUK' => ['9.*'],
    ],

    // Madde 5 "en fazla 75 puan", madde 9 "en fazla 75 puan".
    'grup_tavanlari' => [
        'ATIF' => 75,
        'EDITORLUK' => 75,
    ],
];
