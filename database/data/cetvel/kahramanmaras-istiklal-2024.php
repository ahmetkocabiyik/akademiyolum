<?php

/**
 * KAHRAMANMARAŞ İSTİKLAL ÜNİVERSİTESİ — EK-1: Akademik Faaliyet ve Etkinlik
 * Puanları
 * Kaynak: pdf/17536998712.kahramanmarasistiklaluniverstesi.pdf
 *
 * TEK ORTAK PUAN TABLOSU, TEMEL ALAN AYRIMI YOK. Koşullar tabloya yalnızca iki
 * yerde kodla atıf yapıyor ("A1 kapsamında en az 3 adet makale"), gerisi
 * "EK-1'de yer alan faaliyetlerden N puan" biçiminde; kodlar yine de birebir
 * korundu.
 *
 * YAZAR ÇARPANI SAYI × SIRA MATRİSİ (Madde 9): tek yazarlı %100; iki isimli
 * 90/80; üç isimli 80/70/60; çok isimli 70/60/50 ve 4. isimden sonrası %40.
 * "Sorumlu yazar birinci isimle aynı puanı alır" — `baslica` rolü bu yüzden
 * `ilk` ile aynı satırı kullanıyor.
 *
 * MAKALE TÜRLERİ AYRI AYRI PUANLANMIŞ: her indeks düzeyinde özgün araştırma
 * makalesi, derleme ve kısa yayın için üç ayrı satır var (ör. SCI'de 40/30/20).
 * Korpusta derlemeyi özgün makaleden ayıran ama ikisini de anlamlı puanlayan
 * az sayıdaki cetvelden biri; `turler` alanıyla ayrıldı.
 *
 * ÇOK DEĞERLİ SATIRLAR EN DÜŞÜĞÜNDEN GİRİLDİ. Proje (A5), editörlük (A6),
 * organizasyon (B4), ödül (B7-B8) ve burs (B3.4) kalemleri "a) … b) … c) …"
 * biçiminde birden çok değer taşıyor ve PDF'te yalnızca ilki ayrıştırılabildi.
 * Kural gereği bu kalemler tek satır olarak, ROL AYRIMI YAPILMADAN girildi;
 * yani projede araştırmacı olan aday yürütücü puanını alıyor — puan
 * OLDUĞUNDAN YÜKSEK görünebilir.
 *
 * GİRİLMEYEN KALEMLER: B3.1-B3.3 (yurt dışı görevlendirme süreleri — profilde
 * tutulmuyor), B9 (uluslararası/ulusal üyelikler), C bölümünün alt kırılımları
 * kısmen.
 */

return [
    'kapsam_notu' => 'Puanlar Kahramanmaraş İstiklal Üniversitesi EK-1 tablosundan. Puan yazar '
        .'sayınıza ve sıranıza göre azaltılır (Madde 9: iki isimli 90/80 · üç isimli 80/70/60 · '
        .'çok isimli 70/60/50 ve 4. isimden sonrası 40); sorumlu yazar birinci isimle aynı puanı '
        .'alır. PROJE, EDİTÖRLÜK VE ÖDÜL KALEMLERİNDE PUANINIZ YÜKSEK GÖRÜNEBİLİR: yönergenin '
        .'bu satırları yürütücü/araştırmacı ya da başkanlık/üyelik diye ayrılıyor, kaynakta '
        .'yalnızca ilk değer okunabildiği için rol ayrımı yapılamadı.',

    // Madde 9 — Çok Yazarlı Kitap, Makale ve Bildirilerde Puanlama Tablosu.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'proje', 'patent', 'editorluk', 'odul', 'egitim_ogretim',
            'tez_danismanligi', 'idari_gorev', 'toplumsal_katki'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.0]],
            'ilk' => ['kademeler' => [1 => 1.0, 2 => 0.90, 3 => 0.80], 'sonrasi' => 0.70],
            // "Sorumlu yazar, birinci isimle aynı puanı alır."
            'baslica' => ['kademeler' => [1 => 1.0, 2 => 0.90, 3 => 0.80], 'sonrasi' => 0.70],
            'yazar_2' => ['kademeler' => [2 => 0.80, 3 => 0.70], 'sonrasi' => 0.60],
            'yazar_3' => ['kademeler' => [3 => 0.60], 'sonrasi' => 0.50],
            'yazar_4' => ['sonrasi' => 0.40],
            'yazar_5' => ['sonrasi' => 0.40],
            'yazar_6' => ['sonrasi' => 0.40],
            'ortak' => ['kademeler' => [1 => 1.0, 2 => 0.80, 3 => 0.60], 'sonrasi' => 0.40],
        ],
    ],

    'maddeler' => [
        // ══ A1 — MAKALELER ══
        'A1.1.1' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergide tam metin özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 40],
        'A1.1.2' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergide tam metin derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme'], 'puan' => 30],
        'A1.1.3' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergide vaka takdimi, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 20],
        'A1.2.1' => ['baslik' => 'ESCI veya alan indeksli dergide tam metin özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale'], 'puan' => 30],
        'A1.2.2' => ['baslik' => 'ESCI veya alan indeksli dergide tam metin derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['derleme'], 'puan' => 25],
        'A1.2.3' => ['baslik' => 'ESCI veya alan indeksli dergide vaka takdimi, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 15],
        'A1.3.1' => ['baslik' => 'Diğer indeksli dergide tam metin özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale'], 'puan' => 25],
        'A1.3.2' => ['baslik' => 'Diğer indeksli dergide tam metin derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['derleme'], 'puan' => 20],
        'A1.3.3' => ['baslik' => 'Diğer indeksli dergide vaka takdimi, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 10],
        'A1.4.1' => ['baslik' => 'TÜBİTAK-ULAKBİM taranan dergide tam metin özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 20],
        'A1.4.2' => ['baslik' => 'TÜBİTAK-ULAKBİM taranan dergide tam metin derleme', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['derleme'], 'puan' => 15],
        'A1.4.3' => ['baslik' => 'TÜBİTAK-ULAKBİM taranan dergide vaka takdimi, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 8],
        'A1.4.4' => ['baslik' => 'Diğer ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 10],

        // ══ A2 — KİTAPLAR ══
        'A2.1.1' => ['baslik' => 'Uluslararası bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 50],
        'A2.1.2' => ['baslik' => 'Uluslararası bilimsel kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 25],
        'A2.1.5' => ['baslik' => 'Uluslararası bilimsel ansiklopedide madde yazarlığı (en fazla altı madde)', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 10],
        'A2.2.1' => ['baslik' => 'Ulusal bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı'], 'puan' => 40],
        'A2.2.2' => ['baslik' => 'Ulusal bilimsel kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 20],
        'A2.2.3' => ['baslik' => 'Bilimsel kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 20],
        'A2.2.4' => ['baslik' => 'Bilimsel kitapta bölüm ya da makale çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 10],

        // ══ A3 — BİLDİRİLER ══
        'A3.1.1' => ['baslik' => 'Uluslararası toplantıda tam metni yayımlanmış sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Uluslararası Tam Metin (CPCI)'], 'puan' => 15],
        'A3.1.2' => ['baslik' => 'Uluslararası toplantıda özet metni yayımlanmış bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 10],
        'A3.2.1' => ['baslik' => 'Ulusal toplantıda tam metni yayımlanmış sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 10],
        'A3.2.2' => ['baslik' => 'Ulusal toplantıda özet metni yayımlanmış bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 5],

        // ══ A4 — ATIFLAR ══
        'A4.1' => ['baslik' => 'Web of Science taranan dergide veya uluslararası kitapta atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 3],
        'A4.2' => ['baslik' => 'Diğer hakemli dergide veya ulusal bilimsel kitapta atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer'], 'puan' => 2],

        // ══ A5 — PROJELER (rol ayrımı yapılamadı, bkz. dosya başlığı) ══
        'A5.1' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen proje', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'puan' => 40],
        'A5.2' => ['baslik' => 'TÜBİTAK, kalkınma ajansı veya bakanlık destekli proje', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'puan' => 30],
        'A5.3' => ['baslik' => 'Üniversite döner sermaye veya BAP birimince desteklenen proje', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'puan' => 15],

        // ══ A6 — EDİTÖRLÜK VE HAKEMLİK ══
        'A6.2' => ['baslik' => 'Kitap editörlüğü, yardımcı editörlük veya hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü', 'BKCI Kitap'], 'puan' => 30],
        'A6.3' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 40],
        'A6.4' => ['baslik' => 'ESCI veya alan indeksli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 30],
        'A6.6' => ['baslik' => 'Ulusal hakemli dergide editörlük, yayın kurulu üyeliği veya hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi', 'Yayın Kurulu Üyeliği', 'Hakemlik'], 'puan' => 10],

        // ══ B1-B2 — EĞİTİM-ÖĞRETİM ══
        'B1.1' => ['baslik' => 'Danışmanlığında tamamlanan doktora veya uzmanlık tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 20],
        'B1.2' => ['baslik' => 'Danışmanlığında tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 10],
        'B2.1' => ['baslik' => 'Ön lisans veya lisans dersi (dönem ve ders başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 2],
        'B2.2' => ['baslik' => 'Lisansüstü ders (dönem ve ders başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
        'B3.4' => ['baslik' => 'Uluslararası araştırma bursu', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 15],

        // ══ B4-B5 — ORGANİZASYON VE DAVETLİ KONUŞMA ══
        'B5.2' => ['baslik' => 'Kongre, konferans veya sempozyumda davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 12],

        // ══ B6 — JÜRİ ÜYELİĞİ ══
        'B6.2' => ['baslik' => 'Doktora, sanatta yeterlik, uzmanlık veya yüksek lisans jürisinde görev', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 5],

        // ══ B7-B8 — ÖDÜLLER ══
        'B7.1' => ['baslik' => 'Jürili uluslararası bilim veya sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 30],
        'B7.2' => ['baslik' => 'TÜBİTAK veya TÜBA bilim ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 25],
        'B7.3' => ['baslik' => 'Jürili ulusal bilim veya sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'Yarışma Derecesi / Mansiyon'], 'puan' => 15],

        // ══ B10 — PATENT VE TESCİL ══
        'B10.1' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 70],
        'B10.2' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 40],
        'B10.3' => ['baslik' => 'Faydalı model veya endüstriyel tasarım belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 20],

        // ══ B11 — İDARİ GÖREVLER ══
        'B11.1' => ['baslik' => 'Rektörlük veya rektör yardımcılığı (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı'], 'puan' => 20],
        'B11.2' => ['baslik' => 'Dekanlık, başhekimlik veya müdürlük (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 15],
        'B11.3' => ['baslik' => 'Dekan, başhekim veya müdür yardımcılığı (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 10],
        'B11.4' => ['baslik' => 'Komisyon, kurul veya koordinatörlük görevi (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği', 'Senato / Üniversite Yönetim Kurulu Üyesi'], 'puan' => 8],
        'B11.6' => ['baslik' => 'Bölüm başkanlığı (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 7],
        'B11.8' => ['baslik' => 'Bölüm başkan yardımcılığı veya anabilim dalı başkanlığı (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 5],

        // ══ C — SANATSAL ETKİNLİKLER ══
        'C1.1' => ['baslik' => 'Uluslararası kişisel sanat etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Resital (Uluslararası)', 'Solistlik (Uluslararası)', 'Elektronik Kişisel Sergi (Uluslararası)'], 'puan' => 50],
        'C1.2' => ['baslik' => 'Uluslararası karma veya ortak sanat etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Karma Sergi (Uluslararası)'], 'puan' => 30],
        'C1.3' => ['baslik' => 'Uluslararası sempozyum, festival veya bienale eserle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Masterclass (Uluslararası)'], 'puan' => 30],
        'C1.4' => ['baslik' => 'Eserin yurt dışında satın alınması veya koleksiyona kabulü', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Haber Olması (Uluslararası)'], 'puan' => 25],
        'C2.1' => ['baslik' => 'Ulusal kişisel sanat etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Resital (Ulusal)', 'Solistlik (Ulusal)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 30],
        'C2.2' => ['baslik' => 'Ulusal karma veya ortak sanat etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 20],
        'C2.3' => ['baslik' => 'Ulusal sempozyum, festival veya bienale eserle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Masterclass (Ulusal)', 'Özgün Eser / Beste / Tasarım'], 'puan' => 20],
        'C2.4' => ['baslik' => 'Eserin yurt içinde satın alınması veya koleksiyona kabulü', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Haber Olması (Ulusal)'], 'puan' => 15],
    ],

    'gruplar' => [
        // Dr. Öğr. Üyeliği koşulunun andığı küme: A1 (makaleler).
        'A1' => ['A1.*'],
        // Profesörlükteki "EK-1'de yer alan yayınlar" — makale, kitap, bildiri.
        'YAYIN' => ['A1.*', 'A2.*', 'A3.*'],
    ],

    'grup_tavanlari' => [],
];
