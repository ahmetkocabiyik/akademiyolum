<?php

/**
 * DÜZCE ÜNİVERSİTESİ — EK-1: Akademik Etkinlik Puanlama Sistemi
 * Kaynak: pdf/17536992892.duzceuniverstesi.pdf
 *
 * TEK ORTAK PUAN TABLOSU, ÜÇ ALAN GRUBUNA GÖRE AYRI EŞİK. Koşullar tabloya
 * bölüm numarasıyla değil, "bilimsel/sanatsal yayınlar" gibi adla atıf yapıyor;
 * yine de EK-1'in kendi numaraları (1.1.a, 4.2.b …) birebir korundu.
 *
 * DÜZCE'NİN AYIRT EDİCİ KURALI — "ÇAĞRILI MAKALE": SCI/SCI-E/SSCI/AHCI
 * dergilerde çağrılı makale (50) normal makaleden (40) yüksek puan alıyor.
 * Faaliyet kaydı "çağrılı" bilgisini taşımadığı için bu satır girilmedi;
 * çağrılı makaleniz varsa puanınız olduğundan DÜŞÜK görünür.
 *
 * ATIF PUANI ÇOK DÜŞÜK: SCI atfı 3, diğerleri 1 puan. Düzce'nin eşikleri
 * (profesörlükte 650'ye kadar) bu yüzden yayın ve proje ağırlıklı çıkıyor.
 *
 * YAZAR ÇARPANI SAYI × SIRA MATRİSİ (EK-1 madde 13): 6 yazarlıya kadar kademeli
 * iniş, 7 yazarlıdan sonra 3. isim ve sonrası doğrudan tabana (%20) düşüyor.
 *
 * UYGULANMAYAN TAVANLAR — yönerge dört ayrı yüzde sınırı koyuyor ve motor
 * yüzdeye bağlı tavan tanımıyor; bu kalemlerde puanınız OLDUĞUNDAN YÜKSEK
 * görünebilir:
 *   Genel ilke 13: eğitim-öğretim (madde 4) taban puanın %20'sini geçemez.
 *   Genel ilke 14: burs ve yurt dışı çalışma (madde 7) %10'unu geçemez.
 *   Genel ilke 15: idari ve akademik görevler (madde 11) %10'unu geçemez.
 * Genel ilke 16'daki "ihtisas alanlarında puanlar 1,10 ile çarpılır" kuralı da
 * uygulanmıyor: hangi faaliyetin ihtisas alanına girdiği kayıttan türetilemiyor.
 *
 * AYNI KAYNAĞA DÜŞEN KALEMLERDE DÜŞÜK OLAN GİRİLDİ:
 *   'Kitap Editörlüğü' uluslararası/ulusal ayırmıyor → 1.4.b (50) yerine
 *       1.4.d (30).
 *   'Yayın Kurulu Üyeliği' ve 'Hakemlik' dergi düzeyi taşımıyor → 2.3.c (5) ve
 *       2.3.d (2).
 *   'Davetli Konuşmacı' ulusal/uluslararası ayırmıyor → 3.1.e (15) yerine
 *       3.2.d (10).
 *   'Burs' yurt içi/dışı ayırmıyor → 7.a (20) yerine 7.b (10).
 *
 * GİRİLMEYEN BÖLÜMLER: 9 (sportif faaliyetler), 10 (mimari tasarım), 12.2-12.5
 * (sahne sanatları — kuram, oyunculuk, reji, dramatik yazarlık, sahne tasarımı).
 * Kaynak sözlüğünde karşılıkları yok.
 */

return [
    'kapsam_notu' => 'Puanlar Düzce Üniversitesi EK-1 tablosundan. Makale, bildiri, kitap ve '
        .'sanat kalemlerinde puan yazar sayınıza ve sıranıza göre azaltılır (EK-1 madde 13); '
        .'yazar listesini boş bırakırsanız uygulanamaz. YÖNERGENİN DÖRT YÜZDE TAVANI '
        .'UYGULANMIYOR (eğitim-öğretim %20, burs %10, idari görev %10) — bu kalemlerde puanınız '
        .'olduğundan yüksek görünebilir. Çağrılı makale satırı (50 puan) girilemedi; çağrılı '
        .'makaleniz varsa puanınız olduğundan düşük görünür. Sportif faaliyetler, mimari '
        .'tasarım ve sahne sanatları bölümleri girilmedi.',

    // EK-1 madde 13 — Çok Yazarlı Çalışmalar İçin Puanlama Oranları Tablosu.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'proje', 'editorluk', 'odul', 'egitim_ogretim',
            'tez_danismanligi', 'idari_gorev', 'toplumsal_katki'],
        // Düzce'nin bölme kuralı yalnız SANATSAL ETKİNLİĞE özgü: "Sanat ve
        // tasarım etkinliği ortak gerçekleştirilmişse, söz konusu puan
        // katılımcı sayısına bölünür." Proje ve editörlükte böyle bir cümle
        // yok, onlar `haric` kalıyor.
        'kategoriler' => [
            'sanatsal_etkinlik' => ['sonrasi_pay' => 1.0],
        ],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.0]],
            'ilk' => ['kademeler' => [1 => 1.0, 2 => 1.0, 3 => 0.90, 4 => 0.85, 5 => 0.80,
                6 => 0.75, 7 => 0.70, 8 => 0.65, 9 => 0.60, 10 => 0.55], 'sonrasi' => 0.50],
            'baslica' => ['kademeler' => [1 => 1.0, 2 => 1.0, 3 => 0.90, 4 => 0.85, 5 => 0.80,
                6 => 0.75, 7 => 0.70, 8 => 0.65, 9 => 0.60, 10 => 0.55], 'sonrasi' => 0.50],
            'yazar_2' => ['kademeler' => [2 => 0.90, 3 => 0.80, 4 => 0.75, 5 => 0.70, 6 => 0.65,
                7 => 0.60, 8 => 0.55, 9 => 0.50, 10 => 0.45], 'sonrasi' => 0.40],
            // 7 yazarlıdan sonra 3. isim ve sonrası doğrudan tabana düşüyor.
            'yazar_3' => ['kademeler' => [3 => 0.70, 4 => 0.65, 5 => 0.60, 6 => 0.55], 'sonrasi' => 0.20],
            'yazar_4' => ['kademeler' => [4 => 0.55, 5 => 0.50, 6 => 0.45], 'sonrasi' => 0.20],
            'yazar_5' => ['kademeler' => [5 => 0.40, 6 => 0.35], 'sonrasi' => 0.20],
            'yazar_6' => ['kademeler' => [6 => 0.25], 'sonrasi' => 0.20],
            'ortak' => ['kademeler' => [1 => 1.0, 2 => 0.90, 3 => 0.70, 4 => 0.55, 5 => 0.40,
                6 => 0.25], 'sonrasi' => 0.20],
        ],
    ],

    'maddeler' => [
        // ══ 1. YAYINLAR ══
        '1.1.b' => ['baslik' => 'SCI, SCI-E, SSCI veya AHCI dergide makale veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 40],
        '1.1.c' => ['baslik' => 'SCI, SCI-E, SSCI veya AHCI dergide olgu sunumu, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 20],
        '1.2.a' => ['baslik' => 'Diğer indeksli dergide makale veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 30],
        '1.2.b' => ['baslik' => 'Diğer indeksli dergide olgu sunumu, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 15],
        '1.3.a' => ['baslik' => 'Ulusal hakemli dergide makale veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 20],
        '1.3.b' => ['baslik' => 'Ulusal hakemli dergide olgu sunumu, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 7],
        '1.4.a' => ['baslik' => 'Uluslararası yayınevince yabancı dilde basılmış bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 80],
        '1.4.b' => ['baslik' => 'Uluslararası yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 50],
        '1.4.c' => ['baslik' => 'Ulusal yayınevince Türkçe basılmış bilimsel veya ders kitabı (en az 50 sayfa)', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı'], 'puan' => 40],
        '1.4.d' => ['baslik' => 'Türkçe kitapta bölüm yazarlığı, editörlük, kitapçık veya ansiklopedi maddesi', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 30],
        '1.4.e' => ['baslik' => 'Türkçe kitap çevirmenliği (en az 50 sayfa)', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 30],
        '1.4.f' => ['baslik' => 'Kitap bölümü, kitapçık veya makale çevirmenliği (50 sayfadan az)', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 15],
        '1.5.a' => ['baslik' => 'SCI, SCI-E, SSCI veya AHCI dergisinde atıf (atıf başına)', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
        '1.5.c' => ['baslik' => 'Uluslararası kitapta atıf (atıf başına)', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 3],
        '1.5.d' => ['baslik' => 'Ulusal yayında atıf (atıf başına)', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer'], 'puan' => 1],

        // ══ 2. DERGİ EDİTÖRLÜĞÜ, YAYIN KURULU ÜYELİĞİ VE HAKEMLİK ══
        '2.1.a' => ['baslik' => 'SCI, SCI-E, SSCI veya AHCI dergide baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 30],
        '2.2.a' => ['baslik' => 'Diğer uluslararası indeksli dergide baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 20],
        '2.3.a' => ['baslik' => 'Ulusal hakemli alan dergisinde baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 10],
        '2.3.c' => ['baslik' => 'Dergide yayın kurulu üyeliği, editör yardımcılığı veya danışma kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 5],
        '2.3.d' => ['baslik' => 'Dergi hakemliği (makale başına)', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 2],
        '2.4' => ['baslik' => 'Uluslararası kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 10],

        // ══ 3. KONFERANS / SEMPOZYUM / ÇALIŞTAY ══
        '3.1.a' => ['baslik' => 'Uluslararası etkinlik kitabında yayımlanan tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Uluslararası Tam Metin (CPCI)'], 'puan' => 15],
        '3.1.b' => ['baslik' => 'Uluslararası etkinlik kitabında yayımlanan bildiri özeti veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 10],
        '3.2.a' => ['baslik' => 'Ulusal etkinlik kitabında yayımlanan tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 7],
        '3.2.b' => ['baslik' => 'Ulusal etkinlik kitabında yayımlanan bildiri özeti veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 5],
        '3.2.d' => ['baslik' => 'Bilimsel etkinliğe davetli veya çağrılı bildiri sunmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 10],

        // ══ 4. EĞİTİM VE ÖĞRETİM FAALİYETLERİ (taban puanın %20'siyle sınırlı) ══
        '4.1.a' => ['baslik' => 'Tamamlanan doktora veya tıpta uzmanlık tezinde danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 20],
        '4.1.b' => ['baslik' => 'Tamamlanan yüksek lisans tezinde danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 10],
        '4.1.c' => ['baslik' => 'Tez izleme komitesi üyeliği veya ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi', 'Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 10],
        '4.2.a' => ['baslik' => 'Ön lisans veya lisans dersi (dönem ve ders başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders'], 'puan' => 2],
        '4.2.b' => ['baslik' => 'Lisansüstü ders (dönem ve ders başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
        '4.2.c' => ['baslik' => 'Değişim programı kapsamında verilen ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Değişim Programı Dersi'], 'puan' => 4],
        '4.3.b' => ['baslik' => 'Tez, yeterlik veya atama jüri üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 2],

        // ══ 5. FİKRÎ MÜLKİYET HAKLARI ══
        '5.a' => ['baslik' => 'Uluslararası patent belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 80],
        '5.b' => ['baslik' => 'Ulusal patent belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 60],
        '5.g' => ['baslik' => 'Faydalı model veya endüstriyel tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 30],

        // ══ 6. ÖDÜLLER (TÜBİTAK yayın teşvik ödülleri hariç) ══
        '6.a' => ['baslik' => 'Uluslararası bilim, teşvik veya hizmet ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 50],
        '6.b' => ['baslik' => 'Ulusal bilim, teşvik veya hizmet ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü', 'Yarışma Derecesi / Mansiyon'], 'puan' => 30],

        // ══ 7. BURSLAR VE YURT DIŞI ÇALIŞMALAR (taban puanın %10'uyla sınırlı) ══
        '7.b' => ['baslik' => 'Bilimsel amaçlı burs', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 10],

        // ══ 8. GİRİŞİMCİ YENİLİKÇİ ÜNİVERSİTE FAALİYETLERİ ══
        '8.a' => ['baslik' => 'Uluslararası Ar-Ge kuruluşlarınca desteklenen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 60],
        '8.b' => ['baslik' => 'Uluslararası Ar-Ge kuruluşlarınca desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 40],
        '8.c' => ['baslik' => 'TÜBİTAK, bakanlık veya kalkınma ajansı projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 40],
        '8.d' => ['baslik' => 'TÜBİTAK, bakanlık veya kalkınma ajansı projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
        '8.e' => ['baslik' => 'Üniversite veya yerel kuruluşlarca desteklenen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 10],
        '8.f' => ['baslik' => 'Üniversite veya yerel kuruluşlarca desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 5],
        '8.g' => ['baslik' => 'Kamu veya özel kuruluşa verilen danışmanlık, girişimcilik ya da inovasyon hizmeti', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı', 'Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 5],

        // ══ 11. İDARİ VE AKADEMİK GÖREVLER (taban puanın %10'uyla sınırlı) ══
        '11.a' => ['baslik' => 'Rektörlük (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör'], 'puan' => 20],
        '11.b' => ['baslik' => 'Rektör yardımcılığı, dekanlık veya başhekimlik (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü'], 'puan' => 15],
        '11.c' => ['baslik' => 'Enstitü, yüksekokul müdürlüğü veya dekan yardımcılığı (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.', 'Senato / Üniversite Yönetim Kurulu Üyesi'], 'puan' => 10],
        '11.e' => ['baslik' => 'Merkez müdürlüğü veya bölüm başkanlığı (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü', 'Bölüm Başkanı', 'Bölüm Başkan Yardımcısı'], 'puan' => 5],
        '11.g' => ['baslik' => 'Anabilim dalı başkanlığı veya akademik komisyon üyeliği (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük', 'Kurul / Komisyon Üyeliği'], 'puan' => 2],

        // ══ 12. SANATSAL FAALİYETLER (12.1 plastik sanatlar, 12.6 müzik, 12.7 sinema) ══
        '12.1.a' => ['baslik' => 'Uluslararası alanda kişisel sanat etkinliği (sergi, performans, çalıştay)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Elektronik Kişisel Sergi (Uluslararası)'], 'puan' => 40],
        '12.1.b' => ['baslik' => 'Ulusal alanda kişisel sanat etkinliği (sergi, performans, çalıştay)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 30],
        '12.1.c' => ['baslik' => 'Uluslararası karma sergi veya etkinliğe katılmak (bienal, festival, çalıştay)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Masterclass (Uluslararası)', 'Elektronik Karma Sergi (Uluslararası)'], 'puan' => 15],
        '12.1.d' => ['baslik' => 'Ulusal karma sergi veya etkinliğe katılmak (bienal, festival, çalıştay)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Masterclass (Ulusal)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 7],
        '12.1.e' => ['baslik' => 'Eserlerinin yurt dışında satın alınması veya yayın organında yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Haber Olması (Uluslararası)'], 'puan' => 40],
        '12.1.f' => ['baslik' => 'Eserlerinin yurt içinde satın alınması veya yayın organında yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Haber Olması (Ulusal)'], 'puan' => 30],
        '12.6.a' => ['baslik' => 'Uluslararası alanda bireysel CD veya albüm yayımlamak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)', 'Eğitim Müziği Albümü'], 'puan' => 40],
        '12.6.d' => ['baslik' => 'Karma CD veya albümde yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Albüm / CD-DVD Katkısı'], 'puan' => 10],
        '12.6.i' => ['baslik' => 'Solist olarak konser veya dinleti vermek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Ulusal)', 'Resital (Uluslararası)', 'Şan Resitali (Ulusal)', 'Şan Resitali (Uluslararası)', 'Solistlik (Ulusal)', 'Solistlik (Uluslararası)', 'Oratoryo/Kantat Solistliği (Ulusal)', 'Oratoryo/Kantat Solistliği (Uluslararası)'], 'puan' => 15],
        '12.6.k' => ['baslik' => 'Karma etkinlikte veya opera temsilinde ses ya da çalgı icracısı olmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Ulusal)', 'Oda Müziği Grup Üyeliği (Uluslararası)', 'Orkestra / Koro Üyeliği', 'Opera İkinci Rol (Ulusal)', 'Opera İkinci Rol (Uluslararası)', 'Opera Birinci Rol (Ulusal)', 'Opera Birinci Rol (Uluslararası)'], 'puan' => 7],
        '12.6.l' => ['baslik' => 'Öğretim elemanı veya öğrenci konseri düzenlemek ya da yönetmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koro Şefliği (Ulusal)', 'Koro Şefliği (Uluslararası)', 'Orkestra Şefliği (Ulusal)', 'Orkestra Şefliği (Uluslararası)', 'Opera Şefliği (Ulusal)', 'Opera Şefliği (Uluslararası)', 'Grup Şefliği (Ulusal)', 'Grup Şefliği (Uluslararası)', 'Eğitici Konser Programı (Ulusal)', 'Eğitici Konser Programı (Uluslararası)'], 'puan' => 7],
        '12.6.n' => ['baslik' => 'Eser bestelemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Opera/Bale Kompozisyonu', 'Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)', 'Özgün Eser / Beste / Tasarım', 'Sahne/Ekran Müziği'], 'puan' => 30],
        '12.6.o' => ['baslik' => 'Eser aranje etmek, derlemek veya notaya almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi'], 'puan' => 15],
        '12.7.a' => ['baslik' => 'Uluslararası alanda film, belgesel veya deneysel film', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Yönetmenlik (Sahne/Ekran)'], 'puan' => 40],
        '12.7.b' => ['baslik' => 'Ulusal alanda film, belgesel veya deneysel film', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Ulusal)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'], 'puan' => 20],
    ],

    'gruplar' => [
        // Genel ilke 9: "taban puanın en az %50'si bilimsel/sanatsal yayınlardan"
        // — EK-1'in 1. (yayınlar) ve 12. (sanatsal faaliyetler) bölümleri.
        'YAYINLAR' => ['1.*', '12.*'],
    ],

    'grup_tavanlari' => [],
];
