<?php

/**
 * ANKARA BİLİM ÜNİVERSİTESİ — EK1: Akademik Yükseltilme ve Atanma Özel Kriterleri
 * Kaynak: pdf/17537096492.ankarabilimuniversitesi.pdf (15 sayfa, 08/03/2023)
 *
 * BELGEDE YÜRÜRLÜK TARİHİ YOK: Madde 39 yürürlüğü YÖK'ün uygun bulduğu tarihe
 * bağlıyor ama tarih vermiyor. Dosya adındaki 2023 PDF'in oluşturma tarihidir.
 *
 * MADDE KODLARI yönergenin kendi üç kademeli numaraları (1.1.1 … 6.7.4).
 * Koşullar tabloya kodla atıf yapıyor ("1.1 ve/veya 1.2. kısımdan", "özel
 * kriterlerin 6.1.1 ila 6.1.8'inci maddeleri"), bu yüzden kodlar birebir
 * korundu. Grup desenlerinde nokta zorunlu ('1.1.*'), yoksa '1.1*' deseni
 * 1.10 gibi bir kodu da yakalardı.
 *
 * ── 1.2.1 DÖRDE BÖLÜNDÜ (ALT KODLAR a-d BİZE AİT) ──
 * Tablonun tek bir "1.2.1" satırı var: "Uluslararası SCI, SCI-Expanded, SSCI,
 * AHCI VEYA ALAN İNDEKSLERİ kapsamındaki dergilerde makale — 20 puan". Ama
 * yönergenin temel kriterleri bu ikisini AYIRIYOR: Madde 3/n "Uluslararası
 * İndeks"i yalnızca SCI, SSCI, SCI-Expanded ve AHCI diye tanımlıyor, alan
 * indeksi (Madde 3/a: WOS, SCOPUS ve ÜAK'ın belirlediği diğer alan
 * indeksleri) ayrı bir tanım. Mühendislik profesörlüğü "uluslararası indeks"
 * isterken doktor öğretim üyeliği "ulusal, uluslararası VEYA alan indeksi"
 * diyor. Tek kod bu ayrımı taşıyamazdı.
 *
 * Ayrıca koşullar "ÖZGÜN TAM araştırma makalesi" istiyor; tablo makalenin
 * türünü ayırmıyor. Derlemeyi ya da editöre mektubu araştırma makalesi
 * saymak koşulu olduğundan KOLAY gösterirdi. Bu yüzden bütün 1.2 makale
 * satırları özgün / diğer türler diye ikiye bölündü. Puanlar bölünmedi:
 * her alt kod kaynak satırın puanını aynen taşıyor, bir faaliyet yalnızca
 * bir alt koda düşüyor.
 *
 *   1.2.1.a  uluslararası indeks (SCI, SCI-E, SSCI, AHCI) · özgün makale
 *   1.2.1.b  uluslararası indeks · derleme, kısa makale, editöre mektup
 *   1.2.1.c  alan indeksi (WOS/Scopus vb.) · özgün makale
 *   1.2.1.d  alan indeksi · diğer türler
 *   1.2.2.a/b, 1.2.4.a/b, 1.2.5.a/b aynı mantıkla ikiye ayrıldı.
 *
 * ── YAZAR KURALI: HER ROLDE 1/n ──
 * Tablonun dipnotu: "Tek yazarlı çalışmalarda yazar tam puan alır. İki veya
 * daha fazla yazarlı makalelerde her bir yazar için toplam puan yazar
 * sayısına bölünür." Sıraya ya da sorumlu yazarlığa ayrıcalık yok; bütün
 * roller aynı `bol` satırını paylaşıyor.
 *
 * SANAT ETKİNLİKLERİ ÇARPANIN DIŞINDA: aynı dipnotun ikinci paragrafı
 * "sanat alanında yapılan karma sergi, sempozyum, çalıştay, konser, gösteri
 * gibi etkinliklerde kişi sayısına bakılmaksızın tam puan ile
 * değerlendirilir" diyor.
 *
 * ── AYNI KAYNAĞA DÜŞEN SATIRLARDA DAİMA DÜŞÜĞÜ GİRİLDİ ──
 *   Ansiklopedi: 1.5.1-1.5.4 dört satır (10/5/2/1), sözlükte tek etiket
 *       ('Ansiklopedi Maddesi') → 1.5.4 (1 puan).
 *   Yayın kurulu üyeliği: 3.2.1 uluslararası (5) / 3.2.2 ulusal (1) → 3.2.2.
 *   Hakemlik: 3.3.1-3.3.9 dokuz satır (8'den 1'e), sözlükte tek etiket
 *       ('Hakemlik') → 3.3.7 (1 puan).
 *   Tez jürisi: 4.1.6 yüksek lisans (1) / 4.1.7 doktora (2) / 4.1.8 tez
 *       izleme (1), sözlükte tek etiket → 4.1.6 (1 puan).
 *   Ders: 4.2.1 AKTS>5 (2) / 4.2.2 AKTS<5 (1); kayıt AKTS tutmuyor → 4.2.2.
 *   Yarışma ödülü: derece ve mansiyon satırları (20/15/15/12) → 5.1.5 (12).
 *   Uluslararası ödül: 5.1.3 (10) / 5.1.7 (8) → 5.1.7.
 *   Ulusal ödül: 5.1.6 (8) / 5.1.8 (4) → 5.1.8. TÜBİTAK, TÜBA, GEBİP ve YÖK
 *       ödülleri de ulusal kuruluş ödülü olduğundan buraya düştü.
 *   Burs: 5.2.1 uluslararası (4) / 5.2.2 ulusal (2) → 5.2.2.
 *   Danışmanlık: 6.6.1 uluslararası (4) / 6.6.2 ulusal (3) → 6.6.2.
 *   Konuşmacılık: 6.4.19 uluslararası (4) / 6.4.20 ulusal (3) → 6.4.20.
 *   Kamusal alanda sergilenen ürün: 2.3.1 yurtdışı (20) / 2.3.2 yurtiçi (15)
 *       → 2.3.2. Elektronik sergiler de fiziksel mekân koşulunu taşımadığı
 *       için ulusal satırlara (2.1.2 ve 2.7.2) bağlandı.
 *   Sahne tasarımı: 2.6.1 uluslararası (20) / 2.6.2 ulusal (10) → 2.6.2.
 *   Film yaratıcı kadrosu: 2.5.5-2.5.9 beş satır (10/8/3/5/3); sözlükteki
 *       'Yönetmenlik (Sahne/Ekran)' etiketi yönetmeni kadronun diğer
 *       üyelerinden ayıramadığı için → 2.5.7 (3 puan).
 *
 * ── ADET TAVANLARI PUANA ÇEVRİLDİ ──
 *   1.7.1 atıf "en çok 10 adet" × 2 puan → 20.
 *   1.7.2 atıf "en çok 10 adet" × 1 puan → 10.
 *   6.2.1 "en çok üç adet" × 8 → 24; 6.2.2 × 6 → 18.
 *   6.6.2 "en çok üç adet" × 3 → 9.
 *   5.1 ödüller "en çok 5 adet" satır satır değil BÖLÜM başına verilmiş ve
 *       satır puanları farklı; girilen en yüksek satır 12 olduğu için tavan
 *       5 × 12 = 60 yazıldı. Gerçek tavan bundan düşük olabilir, yani bu
 *       kalemde puan YÜKSEK görünebilir.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   1.2.3  indeks kapsamı dışındaki uluslararası hakemli dergi (5) —
 *          sözlükte indekssiz uluslararası dergi etiketi yok. Böyle bir
 *          yayını olan adayın puanı DÜŞÜK görünür.
 *   1.5.1-1.5.3  ansiklopedi konu ve madde yazarlığının üst satırları.
 *   1.6.1  uluslararası yazılı basında araştırma/eleştiri (3) — ulusal
 *          satırla (1.6.2) aynı etikete düştüğü için düşüğü girildi.
 *   1.6.3  yayına hazır ders notu (2) — sözlükteki 'Ders / Metot Kitabı'
 *          etiketi basılı kitabı anlatıyor, 1.1.3'e bağlandı.
 *   1.7.3  atıf 0,5 puan — motorun `puan` alanı tam sayı; aşağı yuvarlanınca
 *          0 ediyor.
 *   2.4    tasarım alanında üretime girmiş çalışma/koleksiyon (20/15/10) —
 *          sözlükte karşılığı yok.
 *   2.5.5-2.5.6, 2.5.8-2.5.9  film yaratıcı kadrosunun üst satırları.
 *   2.8.2, 2.8.3, 2.8.5, 2.8.6  restorasyon ekibinde ve düzenleme
 *          kurullarında görev almak — sözlükte yalnızca uygulamayı üstlenen
 *          satırın karşılığı var.
 *   3.1.5  indeks dışı uluslararası dergi editörlüğü (1) — ulusal karşılığı
 *          (3.1.7) ile aynı etiket ve aynı puan.
 *   4.1.9  yükseltilme ve atama jüri üyeliği (2).
 *   4.2.5  elektronik ortamda ders açma; 4.2.6 yurtdışında konuk öğretim
 *          üyeliği; 4.2.7-4.2.8 sertifikalı/katılım belgeli kurs.
 *   6.1.9-6.1.14  arkeolojik kazı ve yüzey araştırması kalemleri.
 *   6.2.3-6.2.4  laboratuvar çalışması.
 *   6.4.1-6.4.18 bilimsel/sanatsal toplantı düzenleme, küratörlük, sergi
 *          organizasyonu ve oturum başkanlığı bloğunun tamamı — sözlükte
 *          toplantı düzenleme kalemleri için etiket yok. 6.4.18 ayrıca
 *          0,5 puan.
 *   6.5.4  yurtdışı idari görev (2).
 *   6.7.1  altı aydan uzun komisyon üyeliği — 6.5.3 ile aynı etiket ve
 *          aynı puan; 6.7.2 atölye/alan çalışması; 6.7.4 sergi düzenleme.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   "Yıl ile çarpılacaktır" (6.5.1-6.5.4): yönetim görevleri görev yılıyla
 *       çarpılıyor; motor çarpmıyor, yönetim puanı DÜŞÜK görünür.
 *   "Kişi sayısına bölünecektir" (6.1.6, 6.1.8, 6.2.1, 6.2.2): proje ve
 *       uygulama projesi kalemleri çarpanın dışında (yazar kuralı yalnızca
 *       yayınlar için yazılmış), puan YÜKSEK görünür.
 *   Kayan pencereler: 3.1.3-3.1.4 editörlük "her yıl için (son 3 yıl)",
 *       4.1.1-4.1.9 tez ve jüri kalemleri "son 5 yılda", 4.2.1-4.2.2 ders
 *       "son iki yılda". Cetvel satırına dönem yazılamıyor (dönem yalnızca
 *       koşulda tutuluyor) ve bu kadroların toplam barajında dönem kısıtı
 *       yok; bu kalemlerde puan YÜKSEK görünür.
 *
 * Yönerge: yonerge/ankara-bilim.php
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 */

return [
    'kapsam_notu' => 'Puanlar Ankara Bilim Üniversitesi EK1 Özel Kriterler tablosundan. '
        .'Yazar kuralı her rolde aynı: tek yazarlı çalışma tam puan, iki ve daha fazla '
        .'yazarlıda puan yazar sayısına bölünür (sıraya ya da sorumlu yazarlığa ayrıcalık '
        .'yok). Yazar listesini boş bırakırsanız çarpan hiç uygulanmaz ve puanınız olduğundan '
        .'YÜKSEK görünür. Sanat etkinliklerinde yönerge kişi sayısına bakmadan tam puan '
        .'veriyor; o kalemlerde bölme uygulanmıyor. '
        .'Makale satırları özgün araştırma makalesi ile derleme, kısa makale ve editöre '
        .'mektubu ayrı kodlarda tutuyor: puanı aynı, ama yönergenin "özgün tam araştırma '
        .'makalesi" koşulları yalnızca özgün makaleleri sayıyor. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünür: yönetim görevleri, tez '
        .'danışmanlığı, ders ve editörlük satırlarının yıl kısıtları (son 2, son 3, son 5 yıl) '
        .'uygulanamıyor; proje ve mimari proje kalemlerinde yönergenin istediği kişi sayısına '
        .'bölme yapılmıyor; ödüllerdeki "en çok 5 adet" sınırı yaklaşık çevrildi. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: yönetim görevleri görev yılıyla '
        .'çarpılmıyor; indeks kapsamı dışındaki uluslararası hakemli dergiler, ansiklopedi '
        .'konu yazarlığı, tasarım koleksiyonları, film yaratıcı kadrosunun üst satırları, '
        .'arkeolojik kazı kalemleri, bilimsel toplantı düzenleme bölümünün tamamı ve 0,5 '
        .'puanlık satırlar (atıf 1.7.3, oturum başkanlığı 6.4.18) kaynakta karşılıksız '
        .'kaldığı için girilmedi.',

    // EK1 dipnotu: "Tek yazarlı çalışmalarda yazar tam puan alır. İki veya
    // daha fazla yazarlı makalelerde her bir yazar için toplam puan yazar
    // sayısına bölünür."
    'yazar_katsayisi' => [
        // Dipnotun ikinci paragrafı sanat etkinliklerini açıkça dışarıda
        // bırakıyor. Atıf, proje, patent, tez, ders, idari görev, ödül ve
        // editörlük kalemleri "yayın" değil; kural yayınlar için yazılmış.
        'haric' => ['atif', 'proje', 'patent', 'tez_danismanligi', 'egitim_ogretim',
            'idari_gorev', 'odul', 'editorluk', 'sanatsal_etkinlik', 'toplumsal_katki'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.0]],
            'ilk' => ['bol' => ['pay' => 1.0]],
            'baslica' => ['bol' => ['pay' => 1.0]],
            'yazar_2' => ['bol' => ['pay' => 1.0]],
            'yazar_3' => ['bol' => ['pay' => 1.0]],
            'yazar_4' => ['bol' => ['pay' => 1.0]],
            'yazar_5' => ['bol' => ['pay' => 1.0]],
            'yazar_6' => ['bol' => ['pay' => 1.0]],
            'ortak' => ['bol' => ['pay' => 1.0]],
        ],
    ],

    'maddeler' => [
        // ══ 1.1 KİTAP ══
        '1.1.1' => ['baslik' => 'Tanınmış uluslararası yayınevi tarafından yayımlanan kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
        '1.1.2' => ['baslik' => 'Tanınmış uluslararası yayınevi kitabında bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 10],
        '1.1.3' => ['baslik' => 'Tanınmış ulusal yayınevi tarafından yayımlanan kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı', 'Tahkik (Tenkitli Metin)'], 'puan' => 10],
        '1.1.4' => ['baslik' => 'Tanınmış ulusal yayınevi kitabında bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 5],

        // ══ 1.2 MAKALE ══
        // Alt kodlar (a-d) bize ait: kaynak tabloda tek satır var, ayrım
        // Madde 3/a ile 3/n'nin farklı indeks tanımlarından ve koşulların
        // "özgün tam araştırma makalesi" ifadesinden geliyor.
        '1.2.1.a' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 20],
        '1.2.1.b' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergide derleme, kısa makale veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 20],
        '1.2.1.c' => ['baslik' => 'Alan indeksi kapsamındaki dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale'], 'puan' => 20],
        '1.2.1.d' => ['baslik' => 'Alan indeksi kapsamındaki dergide derleme, kısa makale veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 20],
        '1.2.2.a' => ['baslik' => 'Uluslararası diğer indekslerdeki hakemli dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale'], 'puan' => 10],
        '1.2.2.b' => ['baslik' => 'Uluslararası diğer indekslerdeki hakemli dergide derleme, kısa makale veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 10],
        '1.2.4.a' => ['baslik' => 'TR Dizin kapsamındaki ulusal hakemli dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 10],
        '1.2.4.b' => ['baslik' => 'TR Dizin kapsamındaki ulusal hakemli dergide derleme, kısa makale veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 10],
        '1.2.5.a' => ['baslik' => 'Ulusal diğer hakemli dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale'], 'puan' => 5],
        '1.2.5.b' => ['baslik' => 'Ulusal diğer hakemli dergide derleme, kısa makale veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 5],

        // ══ 1.3 BİLDİRİ ══
        '1.3.1' => ['baslik' => 'Uluslararası kongre veya sempozyumda tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 8],
        '1.3.2' => ['baslik' => 'Uluslararası kongre veya sempozyumda özet, poster ya da sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 2],
        '1.3.5' => ['baslik' => 'Ulusal kongre veya sempozyumda tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 4],
        '1.3.6' => ['baslik' => 'Ulusal kongre veya sempozyumda özet, poster ya da sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 1],

        // ══ 1.4 ÇEVİRİ ══
        '1.4.1' => ['baslik' => 'Tanınmış ulusal yayınevi tarafından yayımlanan kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 15],
        '1.4.2' => ['baslik' => 'Makale veya kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 5],

        // ══ 1.5 ANSİKLOPEDİ ══
        '1.5.4' => ['baslik' => 'Ansiklopedide madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 1],

        // ══ 1.6 DİĞER YAYIN ══
        '1.6.2' => ['baslik' => 'Yazılı basında mesleki araştırma, eleştiri, deneme, röportaj veya katalog metni', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Bilim İletişimi / Popüler Yayın'], 'puan' => 1],

        // ══ 1.7 ATIFLAR ══
        '1.7.1' => ['baslik' => 'Doçentlik indekslerindeki dergilerde veya yurt dışında basılmış kitaplarda yayınlarınıza yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 2],
        '1.7.2' => ['baslik' => 'Diğer uluslararası dergilerde veya yurt içinde basılmış kitaplarda yayınlarınıza yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Patent', 'Diğer'], 'puan' => 1],

        // ══ 2. SANAT VE TASARIM ETKİNLİKLERİ ══
        '2.1.1' => ['baslik' => 'Yurt dışında tanınmış mekânda açılan özgün kişisel sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)'], 'puan' => 20],
        '2.1.2' => ['baslik' => 'Yurt içinde tanınmış mekânda açılan özgün kişisel sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 15],
        '2.2.1' => ['baslik' => 'Yurt dışı tanınmış müze veya büyük koleksiyonda yapıtınızın yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)'], 'puan' => 20],
        '2.2.2' => ['baslik' => 'Yurt içi tanınmış müze veya büyük koleksiyonda yapıtınızın yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Yayında Yer Alması / Satın Alınması'], 'puan' => 15],
        '2.3.2' => ['baslik' => 'Kamusal veya özel alanda sergilenen sanat ya da tasarım ürünü', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım'], 'puan' => 15],
        '2.5.1' => ['baslik' => 'Uluslararası etkinlikte özgün film gösterisi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Uluslararası)'], 'puan' => 20],
        '2.5.2' => ['baslik' => 'Ulusal etkinlikte özgün film gösterisi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Ulusal)'], 'puan' => 10],
        '2.5.3' => ['baslik' => 'Yurt dışında kitle iletişim araçlarında özgün filminizin yayımlanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)'], 'puan' => 15],
        '2.5.4' => ['baslik' => 'Ulusal yayınlarda filminizin yayımlanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'], 'puan' => 10],
        '2.5.7' => ['baslik' => 'Gösterimi yapılan filmin yaratıcı kadrosunda yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Yönetmenlik (Sahne/Ekran)'], 'puan' => 3],
        '2.6.2' => ['baslik' => 'Sahne tasarımı ile ilgili etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne Tasarımı (Dekor, Kostüm, Işık)'], 'puan' => 10],
        '2.7.1' => ['baslik' => 'Uluslararası karma sergi veya çalıştay', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 20],
        '2.7.2' => ['baslik' => 'Ulusal karma sergi veya çalıştay', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Elektronik Karma Sergi (Uluslararası)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 10],
        '2.8.1' => ['baslik' => 'Yurt dışında müze, kazı buluntusu veya koleksiyon restorasyon-konservasyon çalışmasını üstlenmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koruma-Onarım Uygulaması (Uluslararası)'], 'puan' => 20],
        '2.8.4' => ['baslik' => 'Ulusal müze, kazı buluntusu veya koleksiyon restorasyon-konservasyon çalışmasını üstlenmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koruma-Onarım Uygulaması (Ulusal)'], 'puan' => 12],

        // ══ 3. EDİTÖRLÜK, HAKEMLİK, JÜRİ ÜYELİĞİ ══
        '3.1.1' => ['baslik' => 'Tanınmış uluslararası yayınevi kitabında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 8],
        '3.1.2' => ['baslik' => 'Tanınmış ulusal yayınevi kitabında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 5],
        '3.1.3' => ['baslik' => 'Doçentlik indekslerindeki dergide fiilen yapılan editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 5],
        '3.1.4' => ['baslik' => 'Uluslararası diğer indekslerdeki hakemli dergide fiilen yapılan editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 4],
        '3.1.6' => ['baslik' => 'TR Dizin kapsamındaki ulusal dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 2],
        '3.1.7' => ['baslik' => 'İndeks kapsamı dışındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 1],
        '3.2.2' => ['baslik' => 'Yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 1],
        '3.3.7' => ['baslik' => 'Dergi veya kitap hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 1],
        '3.4.1' => ['baslik' => 'Uluslararası sanat ve tasarım etkinliğinde jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], 'puan' => 8],
        '3.4.2' => ['baslik' => 'Ulusal sanat ve tasarım etkinliğinde jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 5],

        // ══ 4. ÖĞRETİM ETKİNLİKLERİ ══
        '4.1.2' => ['baslik' => 'Tamamlanmış doktora veya sanatta yeterlik tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 8],
        '4.1.3' => ['baslik' => 'Tamamlanmış doktora veya sanatta yeterlik tezinde eş danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 4],
        '4.1.4' => ['baslik' => 'Tamamlanmış yüksek lisans tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 4],
        '4.1.5' => ['baslik' => 'Tamamlanmış yüksek lisans tezinde eş danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 2],
        '4.1.6' => ['baslik' => 'Tez jürisi veya tez izleme komitesi üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 1],
        '4.2.2' => ['baslik' => 'Ön lisans, lisans veya lisansüstü ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 1],
        '4.2.4' => ['baslik' => 'Yeni bir öğretim programı geliştirme', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Akreditasyon Faaliyeti'], 'puan' => 4],

        // ══ 5. ÖDÜLLER ══
        '5.1.5' => ['baslik' => 'Bilim, sanat, tasarım veya proje yarışmasında alınmış derece ya da mansiyon', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 12],
        '5.1.7' => ['baslik' => 'Yurt dışı kurum ve kuruluşlarca verilen ödül', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 8],
        '5.1.8' => ['baslik' => 'Ulusal kurum ve kuruluşlarca verilen ödül', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü', 'Ulusal Bilim/Sanat Ödülü'], 'puan' => 4],
        '5.2.2' => ['baslik' => 'Yurt dışı araştırma bursu', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 2],

        // ══ 6.1 ARAŞTIRMA PROJELERİ ══
        '6.1.1' => ['baslik' => 'NATO, AB, BM, Dünya Bankası veya OECD projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 20],
        '6.1.2' => ['baslik' => 'NATO, AB, BM, Dünya Bankası veya OECD projesinde üyelik', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
        '6.1.3' => ['baslik' => 'TÜBİTAK, bakanlık veya benzeri ulusal kurum projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 12],
        '6.1.4' => ['baslik' => 'TÜBİTAK, bakanlık veya benzeri ulusal kurum projesinde üyelik', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 8],
        '6.1.5' => ['baslik' => 'Diğer uluslararası araştırma projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 10],
        '6.1.6' => ['baslik' => 'Diğer uluslararası araştırma projesinde üyelik', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 8],
        '6.1.7' => ['baslik' => 'Diğer ulusal araştırma projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK', 'BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 8],
        '6.1.8' => ['baslik' => 'Diğer ulusal araştırma projesinde üyelik', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK', 'BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 6],

        // ══ 6.2 TASARIM, PROJE, PLANLAMA ══
        '6.2.1' => ['baslik' => 'Mimari proje, planlama veya tasarım çalışmasında yürütücülük', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif'], 'puan' => 8],
        '6.2.2' => ['baslik' => 'Mimari proje, planlama veya tasarım çalışmasında yardımcılık', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman'], 'puan' => 6],

        // ══ 6.3 PATENT, TASARIM TESCİLİ ══
        '6.3.1' => ['baslik' => 'Uluslararası patent veya tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent', 'Ticarileştirme'], 'puan' => 10],
        '6.3.2' => ['baslik' => 'Ulusal patent veya tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 5],

        // ══ 6.4 TOPLANTI DÜZENLEME ══
        '6.4.20' => ['baslik' => 'Bilimsel veya sanatsal nitelikli konferans ya da panelde konuşmacılık', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 3],

        // ══ 6.5 YÖNETİME KATKI ══
        '6.5.1' => ['baslik' => 'Yöneticilik (rektörlük, dekanlık, müdürlük, bölüm başkanlığı)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Dekan / Enstitü-YO Müdürü', 'Uygulama ve Araştırma Merkezi Müdürü', 'Bölüm Başkanı'], 'puan' => 3],
        '6.5.2' => ['baslik' => 'Yönetimde yardımcılık', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör Yardımcısı', 'Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 2],
        '6.5.3' => ['baslik' => 'Akademik kurul veya komisyon üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 1],

        // ══ 6.6 DANIŞMANLIK ══
        '6.6.2' => ['baslik' => 'Bir kuruluşta danışmanlık hizmeti', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı'], 'puan' => 3],

        // ══ 6.7 DİĞER FAALİYETLER ══
        '6.7.3' => ['baslik' => 'Seminer, dizi konferans veya panel düzenleme', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi'], 'puan' => 2],
        '6.4.6' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Ulusal)'], 'puan' => 4],
        '6.4.3' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 5],
        // 6.4.18 (ULUSAL panel/seminer etkinliğinde oturum başkanlığı, 0,5)
        // aşağı yuvarlanınca 0 ediyor ve satır açılmadı; ulusal etiket bu
        // satırda kalsaydı karşılıksız 1 puan verirdi.
        '6.4.17' => ['baslik' => 'Uluslararası panel ya da seminer etkinliğinde oturum başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Uluslararası)'], 'puan' => 1],
        '6.4.7' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 3],
        '6.4.4' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 4],
    ],

    'gruplar' => [
        // Madde 37'nin andığı iki kısım. Nokta zorunlu: '1.1*' deseni
        // 1.1.1-1.1.4 dışında bir kod olsaydı onu da yakalardı.
        'KITAP' => ['1.1.*'],
        'MAKALE' => ['1.2.*'],
        'KITAP-MAKALE' => ['1.1.*', '1.2.*'],

        // Madde 3/n: "Uluslararası İndeks" YALNIZCA SCI, SSCI, SCI-Expanded
        // ve AHCI. Alan indeksi (Madde 3/a) ayrı tanım, bu kümeye girmiyor.
        'ULUSLARARASI-INDEKS' => ['1.2.1.a'],

        // Madde 3/a: alan indeksi (WOS, SCOPUS ve ÜAK'ın belirlediği diğer
        // uluslararası alan indeksleri).
        'ALAN-INDEKSI' => ['1.2.1.c'],

        // Madde 3/m: "Ulusal İndeks" = TÜBİTAK-ULAKBİM TR Dizin.
        'ULUSAL-INDEKS' => ['1.2.4.a'],

        // Doçentlik ve profesörlük koşullarındaki "ulusal ya da uluslararası
        // indeks tarafından taranan dergiler".
        'ULUSAL-VEYA-ULUSLARARASI-INDEKS' => ['1.2.1.a', '1.2.4.a'],

        // Doktor öğretim üyeliği koşullarındaki "ulusal, uluslararası veya
        // alan indeksi tarafından taranan dergiler".
        'DR-DERGI' => ['1.2.1.a', '1.2.1.c', '1.2.4.a'],

        // Madde 3/l: "Ulusal Hakemli Dergi" — TR Dizin ve diğer ulusal
        // hakemli dergiler. Hukuk doktor öğretim üyeliği bu kümeyi anıyor.
        'HUKUK-DR-DERGI' => ['1.2.1.a', '1.2.1.c', '1.2.4.a', '1.2.5.a'],

        // Mühendislik profesörlüğünde bir makalenin yerine geçebilen özgün
        // kitap (Madde 12/3) — kitap bölümü değil, kitap.
        'OZGUN-KITAP' => ['1.1.1', '1.1.3'],

        // Aynı maddede bir makalenin yerine geçebilen patent buluşu ve
        // endüstriyel tasarım tescili.
        'PATENT-TASARIM' => ['6.3.*'],

        // Aynı maddede iki tanesi bir makalenin yerine geçen, yürütücü
        // olarak tamamlanmış ulusal/uluslararası projeler.
        'PROJE-YURUTUCU' => ['6.1.1', '6.1.3', '6.1.5', '6.1.7'],

        // Madde 11/11'in yeniden atanmada andığı küme: "özel kriterlerin
        // 6.1.1 ila 6.1.8'inci maddeleri".
        'PROJE-6.1' => ['6.1.*'],

        // Adet tavanlarının puana çevrildiği tekil satırlar.
        'ATIF-UST' => ['1.7.1'],
        'ATIF-ALT' => ['1.7.2'],
        'ODUL' => ['5.1.*'],
        'MIMARI-PROJE-YURUTUCU' => ['6.2.1'],
        'MIMARI-PROJE-YARDIMCI' => ['6.2.2'],
        'DANISMANLIK' => ['6.6.2'],
    ],

    // Yönergenin kendi adet tavanlarının puan karşılığı.
    'grup_tavanlari' => [
        'ATIF-UST' => 20,               // 1.7.1: en çok 10 adet × 2 puan
        'ATIF-ALT' => 10,               // 1.7.2: en çok 10 adet × 1 puan
        'ODUL' => 60,                   // 5.1: en çok 5 adet, girilen en yüksek satır 12
        'MIMARI-PROJE-YURUTUCU' => 24,  // 6.2.1: en çok 3 adet × 8 puan
        'MIMARI-PROJE-YARDIMCI' => 18,  // 6.2.2: en çok 3 adet × 6 puan
        'DANISMANLIK' => 9,             // 6.6.2: en çok 3 adet × 3 puan
    ],
];
