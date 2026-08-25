<?php

/**
 * TRABZON ÜNİVERSİTESİ — TABLO 2: Puanlandırma Tablosu
 * Kaynak: pdf/17537009582.trabzonuniverstesi.pdf
 *
 * YÖNERGEDE TARİH YOK; dosya adındaki yıl PDF'in oluşturulma tarihinden
 * (14/01/2025). Yönergenin kendisi ne kabul tarihi ne karar numarası taşıyor.
 *
 * MADDE KODLARI yönergenin kendi numaralandırması. Koşullar tabloya KOD
 * ARALIĞIYLA atıf yapıyor ("1.1.1 - 1.3.4.1 arası", "2.1.1. - 2.4.4. arası"),
 * bu yüzden kodlar birebir korundu ve bölüm başlıkları (1.1., 2.2., 3.3. …)
 * madde olarak GİRİLMEDİ — girilseydi aralık grupları başlığı da kalem sayardı.
 *
 * KENDİ ÜRETTİĞİMİZ ALT KODLAR: `2.2.x.a` ve `2.2.x.b`. Yönerge proje puanını
 * tek satırda verip payı dipnotta bölüyor ("Araştırmacılar için puanın 1/3'ü,
 * danışmanlar için 1/5'i"); motor bir kodda tek puan tuttuğu için her proje
 * satırı role göre üçe ayrıldı. `.a` araştırmacı, `.b` danışman ve bursiyer.
 * Kesirler AŞAĞI yuvarlandı (20/3 → 6, 8/3 → 2).
 *
 * ── AYNI KAYNAĞA DÜŞEN İKİ SATIRDA DAİMA DÜŞÜĞÜ GİRİLDİ ──
 * Yönerge, kaynak sözlüğünün ayırmadığı nitelikleri ayrı puanlıyor. Bu
 * satırlarda düşük olan yazıldı, yüksek olan hiç girilmedi:
 *
 *   SSCI/SCI (1.1.1, 10) ↔ SCI-Expanded (1.1.1.1, 8)   → 8
 *       'SCIE/SSCI (Q*)' etiketi ikisini birleştiriyor. Yalnızca AHCI tek
 *       başına ayrılabildiği için 1.1.1'de sadece o kaldı.
 *   Uluslararası bildiri özet (1.2.1.1, 2) ↔ poster (1.2.1.2, 3)      → 2
 *   Yurt içi bildiri özet (1.2.2.1, 1) ↔ poster (1.2.2.2, 2)          → 1
 *   Ulusal hakemli kitap (1.3.2, 25) ↔ hakemsiz kitap (1.3.2.2, 15)   → 15
 *   Ulusal hakemli bölüm (1.3.2.1, 8) ↔ hakemsiz bölüm (1.3.2.3, 5)   → 5
 *   Uluslararası ansiklopedi maddesi (1.3.4, 10) ↔ ulusal (1.3.4.1, 5)→ 5
 *   Uluslararası faydalı model (2.4.3, 20) ↔ ulusal (2.4.4, 10)       → 10
 *   Uluslararası kitap editörlüğü hakemli (3.1.1, 20) ↔ hakemsiz
 *       (3.1.1.1, 15)                                                 → 15
 *   Uluslararası hakemlik (3.1.3, 2) ↔ ulusal hakemlik (3.1.4, 1)     → 1
 *
 * ── GİRİLMEYEN KALEMLER (kaynak sözlüğünde karşılığı yok) ──
 *   1.2.1.3, 1.2.2.3  hakemsiz bildiri — sözlükte "hakemsiz" ayrımı yok.
 *   1.3.3.1           makale çevirisi — 'Çeviri Kitap Bölümü' etiketi bunun
 *                     karşılığı değil; kitap bölümü çevirisi puansız kalıyor.
 *   2.1.1.3, 2.1.2.3  "çalışma üzerine başkalarının yazdığı makale".
 *   2.2.1.2           reddedilen/sunulan proje önerisi.
 *   2.3.1-2.3.3       EĞİTİM-UYGULAMA PROJESİ bölümünün tamamı. Sözlük projeyi
 *                     FON KAYNAĞINA göre ayırıyor (AB, TÜBİTAK, kamu, özel,
 *                     BAP), yönergenin buradaki ayrımı ise projenin AMACI.
 *                     Aynı kayıt 2.2 satırlarından zaten puanlanıyor; iki
 *                     bölüm birden girilseydi motor yükseği alacağı için hesap
 *                     değişmezdi. Eğitim projesi olan aday 2.2'nin daha yüksek
 *                     puanını görür.
 *   3.3.2, 3.3.3      sergi küratörlüğü + sergiye ilişkin yayın yazarlığı.
 *   3.3.2.1-3.3.3.2   sempozyum başkanlığı ve bilim kurulu üyeliği.
 *   3.3.5             laboratuvar / merkez ünite / atölye kurma.
 *   3.3.7, 3.3.7.2    atölye koordinatörlüğü, radyo-televizyon söyleşisi.
 *   3.3.7.1, 3.3.8,   yapımcılık-yönetmenlik ve "eserle katılma" satırları:
 *   3.3.8.1           sözlükteki sanatsal etiketler bunları 3.3.9 kümesinden
 *                     ayıramıyor, düşük olan 3.3.9 satırları yazıldı.
 *   4.1.3-4.1.3.4     kazı başkanlığı, yüzey araştırması, bilirkişilik.
 *
 * ── HİÇ PUAN ALMAYAN KATEGORİLER ──
 * Tablo 2'de DERS VERME satırı yok: eğitim-öğretim kayıtları 0 puan. İdari
 * görevlerden yalnızca komisyon üyeliği (3.3.4) puanlı; dekanlık, bölüm
 * başkanlığı vb. 0. Toplumsal katkı bölümü yok.
 *
 * Yönerge: yonerge/trabzon.php
 */

return [
    'kapsam_notu' => 'Puanlar Trabzon Üniversitesi Tablo 2 (Puanlandırma Tablosu) kalemlerinden. '
        .'Çok yazarlı eserlerde puan, yönergenin Tablo 3 çarpanına göre azaltılır; çarpan hem '
        .'yazar sayısına hem sıranıza bağlı olduğu için faaliyetinizde kaçıncı yazar olduğunuzu '
        .'seçmeniz gerekir. Sırayı belirtmezseniz (ya da "başlıca yazar" seçerseniz) o yazar '
        .'sayısındaki en düşük çarpan uygulanır; yazar listesini boş bırakırsanız çarpan hiç '
        .'uygulanmaz ve puanınız olduğundan yüksek görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: SSCI ve SCI makaleleri, sözlük bu '
        .'dergileri SCI-Expanded ile aynı etikette tuttuğu için 10 yerine 8 puan alır; ders '
        .'verme, idari görev (komisyon üyeliği dışında) ve ulusal atıf (yönergede 0,5 puan, '
        .'motor tam sayı tuttuğu için 0) hiç puan getirmez; sempozyum başkanlığı, sergi '
        .'küratörlüğü, laboratuvar kurma ve kazı çalışmaları kaynakta ayrılamadığı için '
        .'girilmedi. Güzel Sanatlar ve Devlet Konservatuvarı adayları en çok bundan etkilenir: '
        .'sanatsal üretimin yalnızca sergi ve jüri üyeliği kalemleri sayılıyor. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünebilir: TÜBİTAK projeleri 15 puanla '
        .'sayılır, oysa yönerge kısa süreli hareketlilik projelerine 3, hızlı destek '
        .'projelerine 5 puan veriyor; eğitim-uygulama projeleri araştırma projesi satırından '
        .'puanlanır; disiplinler arası projelere yönergenin verdiği %25 artış uygulanmaz.',

    // Tablo 3: Ortak Çalışmalar İçin Puan Dağılımı. Çarpan hem yazar sayısına
    // hem adayın sırasına bağlı; yönergenin matrisi satır satır aktarıldı.
    //
    //   sıra \ sayı        1     2     3     4     5    N>5
    //   1. isim          1,00  0,95  0,90  0,85  0,80  0,75
    //   2. isim             -  0,85  0,80  0,75  0,70  0,65
    //   3. isim             -     -  0,75  0,70  0,65  0,60
    //   4. isim             -     -     -  0,60  0,55  0,50
    //   5. isim             -     -     -     -  0,50  0,45
    //   6., 7., 8. isim     -     -     -     -     -  0,35
    //   9. ve sonrası                                  0,25
    //
    // 'yazar_6' ("6. yazar veya sonrası") iki satıra birden karşılık geliyor.
    // Yazar sayısı 6-8 ise aday zorunlu olarak 0,35 satırındadır; 9 ve üzeri
    // yazarda 0,25 olabileceği için orada düşük satır alınır.
    //
    // 'baslica' YÖNERGEDE YOK: Tablo 3 yalnızca isim sırasına bakıyor, sorumlu
    // yazara ayrıcalık tanımıyor. Sorumlu yazarın kaçıncı isim olduğunu
    // bilmediğimiz için 'ortak' ile aynı (en düşük) satırı alır.
    'yazar_katsayisi' => [
        // Proje puanının paylaşımını yönerge kendisi yazıyor (2.2 dipnotu:
        // araştırmacıya 1/3, danışmana 1/5) ve o kural cetvelde ayrı madde
        // olarak duruyor; üstüne yazar çarpanı uygulamak iki kez bölmek olurdu.
        // Atıf, ders, idari görev, tez danışmanlığı ve toplumsal katkı "ortak
        // çalışma" değil, adayın kendi kaydı.
        'haric' => ['atif', 'proje', 'egitim_ogretim', 'idari_gorev',
            'tez_danismanligi', 'toplumsal_katki'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.0]],
            'ilk' => ['kademeler' => [1 => 1.0, 2 => 0.95, 3 => 0.90, 4 => 0.85, 5 => 0.80], 'sonrasi' => 0.75],
            'yazar_2' => ['kademeler' => [2 => 0.85, 3 => 0.80, 4 => 0.75, 5 => 0.70], 'sonrasi' => 0.65],
            'yazar_3' => ['kademeler' => [3 => 0.75, 4 => 0.70, 5 => 0.65], 'sonrasi' => 0.60],
            'yazar_4' => ['kademeler' => [4 => 0.60, 5 => 0.55], 'sonrasi' => 0.50],
            'yazar_5' => ['kademeler' => [5 => 0.50], 'sonrasi' => 0.45],
            'yazar_6' => ['kademeler' => [6 => 0.35, 7 => 0.35, 8 => 0.35], 'sonrasi' => 0.25],
            'baslica' => ['kademeler' => [1 => 1.0, 2 => 0.85, 3 => 0.75, 4 => 0.60, 5 => 0.50, 6 => 0.35, 7 => 0.35, 8 => 0.35], 'sonrasi' => 0.25],
            'ortak' => ['kademeler' => [1 => 1.0, 2 => 0.85, 3 => 0.75, 4 => 0.60, 5 => 0.50, 6 => 0.35, 7 => 0.35, 8 => 0.35], 'sonrasi' => 0.25],
        ],
    ],

    'maddeler' => [
        // ══ 1.1. MAKALELER (en az yayına kabul yazısı bulunmalı) ══
        '1.1.1' => ['baslik' => 'AHCI kapsamındaki dergide yayımlanmış tam makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 10],
        '1.1.1.1' => ['baslik' => 'SCI-Expanded, SSCI veya alan indeksli dergide yayımlanmış tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 8],
        '1.1.1.2' => ['baslik' => 'Diğer uluslararası hakemli dergide yayımlanmış tam makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 6],
        '1.1.1.3' => ['baslik' => 'Ulusal hakemli dergide yayımlanmış tam makale (hakemli armağanlar dâhil)', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 5],

        // ══ 1.2. BİLDİRİLER (makale düzeninde sunulmuş veya basılmış olmalı) ══
        '1.2.1' => ['baslik' => 'Uluslararası hakemli toplantıda tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 5],
        '1.2.1.1' => ['baslik' => 'Uluslararası hakemli toplantıda özet veya poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 2],
        '1.2.2' => ['baslik' => 'Periyodik hakemli toplantıda yurt içi tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 3],
        '1.2.2.1' => ['baslik' => 'Periyodik hakemli toplantıda yurt içi özet veya poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 1],

        // ══ 1.3. KİTAP ══
        '1.3.1' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanan bilimsel veya mesleki kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 50],
        '1.3.1.2' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanan kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 15],
        '1.3.2.2' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanan bilimsel veya mesleki kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 15],
        '1.3.2.3' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanan kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 5],
        '1.3.2.4' => ['baslik' => 'Üniversite tarafından hakem incelemesinden geçirilerek yayımlanan ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 8],
        '1.3.3' => ['baslik' => 'Alanında kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 8],
        '1.3.4.1' => ['baslik' => 'Ansiklopedide madde (en fazla dört madde hesaba katılır)', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 5],

        // ══ 2.1. YARIŞMALAR ve ÖDÜLLER ══
        '2.1.1.2' => ['baslik' => 'Tamamlanan bir çalışmaya tanınmış uluslararası bir organizasyon tarafından verilen ödül', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 30],
        '2.1.2.1' => ['baslik' => 'Kuralları belirlenmiş yarışmada derece veya mansiyon', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 10],
        '2.1.2.2' => ['baslik' => 'Tamamlanan bir çalışmaya tanınmış ulusal bir organizasyon tarafından verilen ödül', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 10],
        '2.1.4' => ['baslik' => 'TÜBİTAK, TÜBA, YÖK vb. ulusal bilim kuruluşlarının verdiği ödül', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 30],

        // ══ 2.2. ARAŞTIRMA PROJESİ ══
        // Dipnot: araştırmacıya puanın 1/3'ü, danışmana 1/5'i. Bursiyer
        // yönergede anılmıyor; en düşük pay olan danışman satırına konuldu.
        '2.2.1' => ['baslik' => 'Uluslararası destekli projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 20],
        '2.2.1.a' => ['baslik' => 'Uluslararası destekli projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci'], 'puan' => 6],
        '2.2.1.b' => ['baslik' => 'Uluslararası destekli projede danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 4],
        '2.2.1.1' => ['baslik' => 'TÜBİTAK, SAN-TEZ, bakanlık veya kamu kurumu projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 15],
        '2.2.1.1.a' => ['baslik' => 'TÜBİTAK, SAN-TEZ, bakanlık veya kamu kurumu projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci'], 'puan' => 5],
        '2.2.1.1.b' => ['baslik' => 'TÜBİTAK, SAN-TEZ, bakanlık veya kamu kurumu projesinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 3],
        '2.2.2' => ['baslik' => 'Özel kuruluş, vakıf veya sivil toplum kuruluşu desteğiyle yürütülen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 8],
        '2.2.2.a' => ['baslik' => 'Özel kuruluş, vakıf veya sivil toplum kuruluşu projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci'], 'puan' => 2],
        '2.2.2.b' => ['baslik' => 'Özel kuruluş, vakıf veya sivil toplum kuruluşu projesinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 1],
        '2.2.2.1' => ['baslik' => 'Üniversite araştırma fonu desteğiyle yürütülen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 3],
        // Danışman payı (3/5) aşağı yuvarlanınca 0 ettiği için ayrı satır yok.
        '2.2.2.1.a' => ['baslik' => 'Üniversite araştırma fonu projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci'], 'puan' => 1],

        // ══ 2.4. PATENTLER ══
        '2.4.1' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 40],
        '2.4.2' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 20],
        '2.4.4' => ['baslik' => 'Faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 10],

        // ══ 3.1. EDİTÖRLÜK - HAKEMLİK ══
        '3.1.1.1' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanan kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 15],
        '3.1.2.1' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanan kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 5],
        '3.1.2.2' => ['baslik' => 'Uluslararası bir derginin editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 5],
        '3.1.2.4' => ['baslik' => 'Ulusal bir derginin editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 3],
        '3.1.4' => ['baslik' => 'Makale, proje ve panel hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 1],

        // ══ 3.2. ATIFLAR (yazarın kendi yayınlarına yaptığı atıflar hariç) ══
        '3.2.1' => ['baslik' => 'Uluslararası makale ve kitaplarda atıf (her bir atıf için)', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 1],
        // Yönergedeki değer 0,5. Motor tam sayı tuttuğu için aşağı yuvarlandı:
        // ulusal atıf puan getirmiyor. Kalem yine de duruyor ki koşulların
        // kapsam rozetinde ulusal atıfın sayıldığı görünsün.
        '3.2.1.1' => ['baslik' => 'Ulusal makale ve kitaplarda atıf (her bir atıf için)', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer'], 'puan' => 0],

        // ══ 3.3. ÜYELİK, BİLİMSEL ETKİNLİK ORGANİZASYONU, SERGİLER ══
        '3.3.1.1' => ['baslik' => 'Yayın veya değerlendirme kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 5],
        '3.3.4' => ['baslik' => 'Bakanlık, YÖK, TÜBİTAK vb. kamu kurumları ile meslek kuruluşlarının verdiği komisyon üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 5],
        '3.3.6' => ['baslik' => 'Uluslararası sanat ve tasarım yarışmasında jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], 'puan' => 7],
        '3.3.6.1' => ['baslik' => 'Ulusal sanat ve tasarım yarışmasında jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 5],
        '3.3.9' => ['baslik' => 'Yurt dışı bienal, trienal ve kişisel sergiler', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)'], 'puan' => 10],
        '3.3.9.1' => ['baslik' => 'Yurt içi bienal, trienal ve kişisel sergiler', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)'], 'puan' => 6],
        '3.3.9.2' => ['baslik' => 'Yurt dışı grup ve karma sergiler', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)'], 'puan' => 6],
        '3.3.9.3' => ['baslik' => 'Yurt içi grup ve karma sergiler', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)'], 'puan' => 3],

        // ══ 4.1. EĞİTİM ETKİNLİKLERİ ve DİĞER BİLİMSEL ETKİNLİKLER ══
        // Eş danışmanlık yönergede anılmıyor; roller yalnızca 'danisman'.
        '4.1.1' => ['baslik' => 'Tamamlanmış doktora veya uzmanlık tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 8],
        '4.1.2' => ['baslik' => 'Tamamlanmış yüksek lisans tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 4],
    ],

    'gruplar' => [
        // Doçent ve profesörlük koşulunun andığı iki aralık. Bölüm başlıkları
        // madde olmadığı için '1.*' tam olarak 1.1.1-1.3.4.1 aralığına,
        // '2.*' tam olarak 2.1.1-2.4.4 aralığına karşılık geliyor.
        // NOKTA ZORUNLU: '1*' deseni 2 ve 3 ile başlamayan her kodu değil,
        // yalnızca "1." önekini yakalasın diye.
        '1.1.1-1.3.4.1' => ['1.*'],
        '2.1.1-2.4.4' => ['2.*'],

        // Dr. Öğr. Üyeliğindeki "puanın 2/3'ü makalelerden" koşulu.
        'MAKALELER' => ['1.1.*'],

        'ANSIKLOPEDI' => ['1.3.4.1'],
    ],

    'grup_tavanlari' => [
        // 1.3.4: "en fazla dört madde hesaplamada dikkate alınır" — adet
        // sınırı, 4 × 5 puanla sabit tavana çevrildi.
        'ANSIKLOPEDI' => 20,
    ],
];
