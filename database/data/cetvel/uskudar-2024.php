<?php

/**
 * ÜSKÜDAR ÜNİVERSİTESİ — EK 1: Puanlama Tablosu (Puantaj Formu)
 * Kaynak: pdf/17537104342.uskudaruniversitesi.pdf
 *
 * BELGEDE TARİH YOK: MADDE 19 yürürlüğü YÖK Genel Kurulu onayına bağlıyor ama
 * tarih vermiyor. Dosya adındaki 2024, PDF'in oluşturma tarihi (17/04/2024).
 * Yönerge 20.04.2017 tarihli önceki esasları yürürlükten kaldırıyor (MADDE 18).
 *
 * MADDE KODLARI form altı ana maddeye bölünmüş ve her maddenin kendi bölüm
 * numaralaması var (MADDE 1'de de MADDE 2'de de "1)" ile başlıyor). Kodlar
 * çakışmasın diye madde öneki eklendi: 'M1.5.2', 'M2.2.1', 'M3.1.6'.
 *
 * ── YAZAR ÇARPANI YALNIZCA SIRAYA BAĞLI, SAYIYA DEĞİL ──
 * Her yayın satırının altındaki tablo aynı: tek yazar tam puan, 1. yazar 0,8 ·
 * 2. yazar 0,6 · 3. yazar 0,4 · 4. ve üstü 0,2. Yazar SAYISI hiç rol
 * oynamıyor — iki yazarlı bir makalede birinci isim de, altı yazarlıda
 * birinci isim de 0,8 alıyor. Formun kendi örneği bunu doğruluyor:
 * "aday ikinci yazar ise PUAN: 75 x 0,6 = 45".
 *
 * BİRİNCİ YAZARIN TEK YAZARDAN DÜŞÜK OLMASI kaynağın kendi tercihi: tek
 * yazarlı 75, iki yazarlı bir makalenin birinci ismi 60.
 *
 * SORUMLU YAZARA AYRICALIK YOK; `baslica` ve sırasını belirtmeyen `ortak`
 * en düşük satırı (0,2) alır.
 *
 * ── TEZDEN ÜRETİLMİŞ YAYIN İÇİN AYNA SATIRLAR (KODLAR BİZE AİT) ──
 * MADDE 13/d doktor öğretim üyeliği için "doktora tezinden üretilmiş en az bir
 * yayın (kitap, kitap bölümü, makale ya da tam metni basılmış bildiri)"
 * istiyor, ama puanlama tablosunda tezden üretilmiş yayın için AYRI SATIR YOK:
 * böyle bir çalışma kendi yayın türünün satırından puan alıyor.
 *
 * Koşulun değerlendirilebilmesi için `tez_yayini` kategorisinde altı ayna
 * satır açıldı (TZ.1-TZ.6); puanları karşılık geldikleri satırlarla birebir
 * aynı. Ayna satırlar puanı DEĞİŞTİRMİYOR, yalnızca "bu çalışma tezimden
 * üretildi" bilgisini taşıyor. Aday aynı çalışmayı ya makale ya tez yayını
 * olarak kaydeder; iki kez sayılmaz.
 *
 * ── AYNI KAYNAĞA DÜŞEN SATIRLARDA DAİMA DÜŞÜĞÜ GİRİLDİ ──
 *   Dergi görevi: her grupta editörlük, özel sayı editörlüğü, yayın kurulu
 *       üyeliği ve hakemlik ayrı satırlar (A grubunda 75/30/20/5). Kaynak
 *       etiketleri derginin düzeyini söylüyor, adayın görevini söylemiyor →
 *       her grupta hakemlik satırı. 'Diğer Hakemli Dergi' ve 'Hakemlik'
 *       grubu da belirsiz bıraktığı için en düşük gruba (diğer ulusal) düştü.
 *   Bildiri: 8.1 uluslararası davetli konuşmacı (40) / 8.4 ulusal (20):
 *       'Davetli Konuşmacı' düzeyi taşımıyor → 8.4.
 *   Burs: uluslararası (50) / ulusal (25) → ulusal.
 *   Sanat ödülü: uluslararası (15) / ulusal (5) → ulusal.
 *   Proje: tablo projeyi hem türe (uluslararası/ulusal) hem SÜRECE
 *       (tamamlanmış / devam eden / başvuru süreci tamamlanmış) göre
 *       ayırıyor; kayıt süreci tutmadığı için her türde en düşük süreç satırı
 *       alındı (uluslararası 1.3, ulusal 1.6). Sosyal sorumluluk projeleri
 *       (1.7-1.10) ayrı bir kaynak taşımadığı için girilmedi.
 *
 * ── PATENTTE TESCİL VARSAYILDI ──
 * 2.1 ile 2.2 (ve 2.3 ile 2.4) arasındaki fark patentin alınmış mı yoksa
 * değerlendirme sürecinde mi olduğu. Kaynak etiketleri ('Uluslararası
 * Patent', 'Ulusal Patent', 'Faydalı Model') tescili ifade ettiği için
 * tamamlanmış satırlar girildi; başvurusu süren adayın puanı YÜKSEK görünür.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   Sanat etkinliğinde "davetli katılım" satırları (uluslararası 50, ulusal
 *       30): kaynak sözlüğü davetli ile kişisel katılımı ayırmıyor, kişisel
 *       satırlar kullanıldı.
 *   MADDE 5'in bilimsel toplantı düzenleme bloğu (başkanlık, düzenleme kurulu
 *       ve bilim kurulu üyelikleri): sözlükte kongre düzenleme kaynağı yok.
 *   MADDE 6'da 'Rektör Yardımcısı' ve 'Bölüm Başkan Yardımcısı' için satır
 *       YOK; ikisi de girilemedi.
 *   Tezsiz yüksek lisans proje danışmanlığı (M2.2.3), sanatsal eser
 *       yarışmalarında danışmanlık, 9.2 (B grubu dergilerde atıf — 'WoS /
 *       Scopus' zaten 9.1'e düşüyor).
 *   'Islahçı Hakkı / Çeşit Tescili' ve 'Ticarileştirme' — patent bölümünde
 *       karşılık satırı yok.
 *
 * ── YÖNETİM GÖREVLERİNDE SÜRE KOŞULU UYGULANAMIYOR ──
 * MADDE 6'nın her satırı asgari bir görev süresi istiyor (rektörlükte 4 yıl,
 * ötekilerde çoğunlukla 3 yıl) ve "aynı kategorideki görevde tüm görev süresi
 * için 1 kez puanlama yapılır" diyor. Faaliyet kaydı görev süresini tutmuyor;
 * yönetim puanı OLDUĞUNDAN YÜKSEK çıkar.
 *
 * Yönerge: yonerge/uskudar.php
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 *
 * İNDEKS KADEMESİ KAPSAM ETİKETİNE DE AÇILDI (19.09.2026, kullanıcı kararı):
 * kaynağın uluslararası kitap satırı indeks kapsamına bağlı (BKCI/Scopus/WoS)
 * ama kaynakta İNDEKSSİZ uluslararası kitabın ayrı bir satırı YOK; alternatif
 * ULUSAL satır. Kapsam etiketi bu yüzden uluslararası satıra bağlandı, ulusal
 * satırlar daraltıldı. Kaynağın indeksli/indekssiz ayrımı motorda artık
 * uygulanmıyor: indekssiz uluslararası kitabınız indeksli kitapla aynı puanı
 * alır, yani puanınız OLDUĞUNDAN YÜKSEK görünebilir.
 */
$makaleA = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI', 'ESCI / Scopus'];
$tamMetin = ['ozgun_makale'];
$digerTur = ['derleme', 'vaka_teknik_not', 'kisa_makale'];

return [
    'kapsam_notu' => 'Puanlar Üsküdar Üniversitesi EK 1 Puanlama Tablosundan. YAZAR ÇARPANI '
        .'YALNIZCA SIRANIZA BAĞLI, yazar sayısına değil: tek yazarlı çalışmada tam puan, '
        .'birinci isimde %80, ikincide %60, üçüncüde %40, dördüncü ve sonrasında %20. İki '
        .'yazarlı bir makalenin birinci ismiyle altı yazarlı bir makalenin birinci ismi aynı '
        .'çarpanı alır. Sıranızı seçmezseniz en düşük satır (%20) uygulanır; yazar listesini '
        .'boş bırakırsanız çarpan hiç uygulanmaz ve puanınız olduğundan YÜKSEK görünür. '
        .'DOKTORA TEZİNİZDEN ÜRETTİĞİNİZ YAYINLARI "tez yayını" olarak kaydedin: yönerge '
        .'doktor öğretim üyeliğinde tezden üretilmiş bir yayın şart koşuyor ve bu koşul ancak '
        .'öyle değerlendirilebiliyor. Puanı değişmez, kendi yayın türünüzle aynı puanı alır. '
        .'Şu bölümlerde tavan var: bildiriler 100, atıflar 30, dersler 50, doktora tez '
        .'danışmanlığı 50, yüksek lisans tez danışmanlığı 25, uluslararası dergi hakemliği '
        .'50, bilirkişilik 10, medya katılımı 25 puan. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: bilimsel toplantı düzenleme '
        .'bölümünün tamamı (başkanlık, düzenleme ve bilim kurulu üyelikleri), sanat '
        .'etkinliklerine davetli katılım, tezsiz yüksek lisans proje danışmanlığı, rektör '
        .'yardımcılığı ve bölüm başkan yardımcılığı girilemedi. Dergi görevlerinde kaydınız '
        .'görevinizi değil derginin düzeyini tuttuğu için hakemlik satırı uygulanır; '
        .'projelerde de sürecin hangi aşamada olduğu kayıtta bulunmadığı için en düşük süreç '
        .'satırı kullanıldı. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK çıkabilir: patentlerde tescil tamamlanmış '
        .'sayıldı; yönetim görevlerinde de yönergenin aradığı asgari görev süreleri (3-4 yıl) '
        .'uygulanamıyor.'
        .' KİTAPTA İNDEKS KOŞULU DENETLENMİYOR: uluslararası yayınevi kitabınız yönergenin BKCI/Scopus taranan kitap satırından sayılıyor. Kitabınız bu kapsamda değilse puanınız olduğundan YÜKSEK görünür.',

    // Her yayın satırının altındaki aynı tablo: tek yazar 1,0 · 1. yazar 0,8 ·
    // 2. yazar 0,6 · 3. yazar 0,4 · 4. ve üstü 0,2. Yazar sayısına bakılmıyor.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'proje', 'tez_danismanligi', 'editorluk', 'odul', 'egitim_ogretim',
            'idari_gorev', 'toplumsal_katki'],
        'roller' => [
            'tek' => ['sonrasi' => 1.0],
            'ilk' => ['sonrasi' => 0.8],
            'yazar_2' => ['sonrasi' => 0.6],
            'yazar_3' => ['sonrasi' => 0.4],
            'yazar_4' => ['sonrasi' => 0.2],
            'yazar_5' => ['sonrasi' => 0.2],
            'yazar_6' => ['sonrasi' => 0.2],
            'baslica' => ['sonrasi' => 0.2],
            'ortak' => ['sonrasi' => 0.2],
        ],
    ],

    'maddeler' => [
        // ══ MADDE 1 · 1-4: DERGİ YAYINLARI ══
        'M1.1.1' => ['baslik' => 'A grubu (Scopus veya WoS) dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => $makaleA, 'turler' => $tamMetin, 'puan' => 75],
        'M1.1.2' => ['baslik' => 'A grubu (Scopus veya WoS) dergide derleme, yorum, söyleşi ya da çeviri', 'kategori' => 'makale', 'kaynaklar' => $makaleA, 'turler' => $digerTur, 'puan' => 25],
        'M1.2.1' => ['baslik' => 'B grubu uluslararası dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $tamMetin, 'puan' => 30],
        'M1.2.2' => ['baslik' => 'B grubu uluslararası dergide derleme, yorum, söyleşi ya da çeviri', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $digerTur, 'puan' => 10],
        'M1.3.1' => ['baslik' => 'Ulusal dizinli (TR Dizin) dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $tamMetin, 'puan' => 25],
        'M1.3.2' => ['baslik' => 'Ulusal dizinli (TR Dizin) dergide derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $digerTur, 'puan' => 15],
        'M1.4.1' => ['baslik' => 'Diğer ulusal hakemli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $tamMetin, 'puan' => 10],
        'M1.4.2' => ['baslik' => 'Diğer ulusal hakemli dergide derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $digerTur, 'puan' => 5],

        // ══ MADDE 1 · 5: KİTAPLAR ══
        'M1.5.1' => ['baslik' => 'Uluslararası (Scopus, WoS) bilimsel telif kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası Kitap'], 'puan' => 100],
        'M1.5.2' => ['baslik' => 'Ulusal bilimsel telif kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ulusal Ders / Metot Kitabı'], 'puan' => 75],
        'M1.5.3' => ['baslik' => 'Uluslararası (Scopus, WoS) bilimsel kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Uluslararası Kitap Bölümü'], 'puan' => 30],
        'M1.5.4' => ['baslik' => 'Ulusal bilimsel kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 15],
        'M1.5.5' => ['baslik' => 'Çeviri kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 15],
        'M1.5.6' => ['baslik' => 'Çeviri derleme kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 15],
        'M1.5.7' => ['baslik' => 'Uluslararası (Scopus, WoS) bilimsel derleme kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Uluslararası Kitap Editörlüğü'], 'puan' => 25],
        'M1.5.8' => ['baslik' => 'Ulusal bilimsel derleme kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü', 'Ulusal Kitap Editörlüğü'], 'puan' => 10],

        // ══ MADDE 1 · 6: YARATICI SANATSAL VE TASARIMSAL ESER ══
        'M1.6.1' => ['baslik' => 'Yaratıcı sanatsal ya da tasarımsal eser', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım', 'Koreografi', 'Yönetmenlik (Sahne/Ekran)', 'Sahne Tasarımı (Dekor, Kostüm, Işık)', 'Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'], 'puan' => 20],
        // Alt kodlar (b, c, e, f) bize ait: kaynak satırları numarasız veriyor.
        'M1.6.2.b' => ['baslik' => 'Uluslararası sanat ya da tasarım etkinliğine kişisel katılım', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Solistlik (Uluslararası)', 'Resital (Uluslararası)', 'Şan Resitali (Uluslararası)'], 'puan' => 30],
        'M1.6.2.c' => ['baslik' => 'Uluslararası sanat ya da tasarım etkinliğine ortak katılım', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Karma Sergi (Uluslararası)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 20],
        'M1.6.2.e' => ['baslik' => 'Ulusal sanatsal ya da tasarımsal etkinliğe kişisel katılım', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)', 'Solistlik (Ulusal)', 'Resital (Ulusal)', 'Şan Resitali (Ulusal)'], 'puan' => 20],
        'M1.6.2.f' => ['baslik' => 'Ulusal sanatsal ya da tasarımsal etkinliğe ortak katılım', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Orkestra / Koro Üyeliği', 'Oda Müziği Grup Üyeliği (Uluslararası)', 'Oda Müziği Grup Üyeliği (Ulusal)'], 'puan' => 5],
        'M1.6.3.b' => ['baslik' => 'Sanatsal ya da tasarımsal eserden alınan ödül', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 5],
        'M1.6.4.a' => ['baslik' => 'Uluslararası sanatsal ya da tasarımsal eser seçici jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], 'puan' => 10],
        'M1.6.4.b' => ['baslik' => 'Ulusal sanatsal ya da tasarımsal eser seçici jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 5],

        // ══ MADDE 1 · 7: DERGİ EDİTÖRLÜĞÜ, KURUL ÜYELİĞİ VE HAKEMLİK ══
        'M1.7.A.4' => ['baslik' => 'A grubu uluslararası dergide hakemlik, editörlük ya da yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 5],
        'M1.7.C.4' => ['baslik' => 'Ulusal dizinli (TR Dizin) dergide hakemlik, editörlük ya da yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 2],
        'M1.7.D.3' => ['baslik' => 'Diğer ulusal hakemli dergide yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 2],
        'M1.7.D.4' => ['baslik' => 'Diğer ulusal hakemli dergide hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi', 'Hakemlik'], 'puan' => 1],

        // ══ MADDE 1 · 8: BİLDİRİLER ══
        'M1.8.2' => ['baslik' => 'Uluslararası bilimsel toplantıda tam metni basılan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 25],
        'M1.8.3' => ['baslik' => 'Uluslararası bilimsel toplantıda sunum', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 15],
        'M1.8.4' => ['baslik' => 'Bilimsel toplantıda davetli konuşmacı', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 20],
        'M1.8.5' => ['baslik' => 'Ulusal bilimsel toplantıda tam metni basılan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 15],
        'M1.8.6' => ['baslik' => 'Ulusal bilimsel toplantıda sunum', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 3],

        // ══ MADDE 1 · 9: ATIFLAR ══
        'M1.9.1' => ['baslik' => 'A grubu uluslararası dergilerde alınan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 5],
        'M1.9.3' => ['baslik' => 'Uluslararası (Scopus, WoS) kitaplarda alınan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 3],
        'M1.9.4' => ['baslik' => 'Ulusal bilimsel kitap ve dergilerde alınan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Patent', 'Diğer'], 'puan' => 1],

        // ══ TEZDEN ÜRETİLMİŞ YAYIN — ayna satırlar (kodlar bize ait) ══
        'TZ.1' => ['baslik' => 'Tezinizden üretilmiş, A grubu (Scopus, WoS) dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI', 'ESCI / Scopus'], 'puan' => 75],
        'TZ.2' => ['baslik' => 'Tezinizden üretilmiş, ulusal dizinli (TR Dizin) dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['TR Dizin'], 'puan' => 25],
        'TZ.3' => ['baslik' => 'Tezinizden üretilmiş, uluslararası (Scopus, WoS) kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 100],
        'TZ.4' => ['baslik' => 'Tezinizden üretilmiş, uluslararası (Scopus, WoS) kitapta bölüm', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 30],
        'TZ.5' => ['baslik' => 'Tezinizden üretilmiş, ulusal kitap ya da kitap bölümü', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Kitap Bölümü'], 'puan' => 15],
        'TZ.6' => ['baslik' => 'Tezinizden üretilmiş, tam metni basılmış bildiri', 'kategori' => 'tez_yayini', 'kaynaklar' => ['CPCI Bildiri', 'Diğer'], 'puan' => 15],

        // ══ MADDE 2: EĞİTİM-ÖĞRETİM ══
        'M2.1' => ['baslik' => 'Ön lisans, lisans ya da lisansüstü ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 5],
        'M2.2.1' => ['baslik' => 'Sonuçlanmış doktora tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 10],
        'M2.2.2' => ['baslik' => 'Sonuçlanmış yüksek lisans tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 5],

        // ══ MADDE 3 · 1: PROJELER ══
        // Süreç kayıtta yok; her türde en düşük süreç satırı (1.3 ve 1.6).
        'M3.1.3.y' => ['baslik' => 'Uluslararası projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 75],
        'M3.1.3.a' => ['baslik' => 'Uluslararası projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 30],
        'M3.1.3.d' => ['baslik' => 'Uluslararası projede danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['danisman'], 'puan' => 10],
        'M3.1.6.y' => ['baslik' => 'Ulusal projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK', 'BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 25],
        'M3.1.6.a' => ['baslik' => 'Ulusal projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK', 'BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 15],
        'M3.1.6.d' => ['baslik' => 'Ulusal projede danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK', 'BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['danisman'], 'puan' => 5],

        // ══ MADDE 3 · 2: PATENT VE FAYDALI MODEL ══
        'M3.2.1' => ['baslik' => 'Uluslararası patent ya da faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 200],
        'M3.2.3' => ['baslik' => 'Ulusal patent ya da faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Faydalı Model'], 'puan' => 75],

        // ══ MADDE 4: BURSLAR VE ÖDÜLLER ══
        'M4.1.2' => ['baslik' => 'Bilimsel kuruluşlardan alınan burs', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 25],
        'M4.2.1' => ['baslik' => 'Uluslararası bilimsel kuruluşlardan alınan ödül', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 50],
        'M4.2.2' => ['baslik' => 'Ulusal bilimsel kuruluşlardan alınan ödül', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü', 'Ulusal Bilim/Sanat Ödülü'], 'puan' => 25],

        // ══ MADDE 5: DANIŞMANLIK VE MEDYA ══
        'M5.2' => ['baslik' => 'Bilirkişilik, üyelik ya da danışmanlık', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı', 'Topluma Hizmet Projesi'], 'puan' => 3],
        'M5.3' => ['baslik' => 'Medya katılımı', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Bilim İletişimi / Popüler Yayın'], 'puan' => 1],

        // ══ MADDE 6: AKADEMİK YÖNETİM GÖREVLERİ ══
        'M6.1' => ['baslik' => 'Rektörlük', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör'], 'puan' => 20],
        'M6.4' => ['baslik' => 'Dekanlık ya da müdürlük', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü'], 'puan' => 10],
        'M6.5' => ['baslik' => 'Dekan ya da müdür yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 5],
        'M6.6' => ['baslik' => 'Uygulama ve araştırma merkezi müdürlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 5],
        'M6.9' => ['baslik' => 'Bölüm, anabilim dalı ya da program başkanlığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 5],
        'M6.11' => ['baslik' => 'Komisyon ya da kurul üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 2],
        'TOPLANTI-BSK-N' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Ulusal)'], 'puan' => 20],
        'TOPLANTI-BSK-U' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 40],
        'TOPLANTI-UYE-N' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 2],
        'TOPLANTI-UYE-U' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 4],
    ],

    'gruplar' => [
        // MADDE 13/b, 14/b ve 15/c'nin andığı "ilgili alanda üretilen bilimsel
        // yayınlar": MADDE 1'in yayın ve eser bölümleri (1-6) ile tezden
        // üretilmiş ayna satırlar. Editörlük-hakemlik (7), bildiri sunumu (8)
        // ve atıf (9) bu kümenin dışında; gerekçe yönerge dosyasında.
        'BILIMSEL-YAYIN' => ['M1.1.*', 'M1.2.*', 'M1.3.*', 'M1.4.*', 'M1.5.*', 'M1.6.*', 'TZ.*'],

        // A grubu = Scopus veya WoS veri tabanındaki dergiler (MADDE 5/h).
        'A-GRUBU-DERGI' => ['M1.1.*', 'TZ.1'],

        // Ulusal dizin = TR Dizin (MADDE 5/c).
        'ULUSAL-DIZIN' => ['M1.3.*', 'TZ.2'],

        'KITAP' => ['M1.5.*', 'TZ.3', 'TZ.4', 'TZ.5'],
        'TEZDEN-URETILMIS' => ['TZ.*'],

        'PROJE' => ['M3.1.*'],
        'PROJE-YURUTUCU-ARASTIRMACI' => ['M3.1.3.y', 'M3.1.3.a', 'M3.1.6.y', 'M3.1.6.a'],
        'PROJE-YURUTUCU' => ['M3.1.3.y', 'M3.1.6.y'],
        'PATENT' => ['M3.2.*'],

        // Tavan grupları.
        'A-HAKEMLIK' => ['M1.7.A.4'],
        'BILDIRI' => ['M1.8.*'],
        'ATIF' => ['M1.9.*'],
        'DERS' => ['M2.1'],
        'DOKTORA-TEZ' => ['M2.2.1'],
        'YL-TEZ' => ['M2.2.2'],
        'BILIRKISILIK' => ['M5.2'],
        'MEDYA' => ['M5.3'],
    ],

    // Tablonun kendi sabit tavanları.
    'grup_tavanlari' => [
        'A-HAKEMLIK' => 50,
        'BILDIRI' => 100,
        'ATIF' => 30,
        'DERS' => 50,
        'DOKTORA-TEZ' => 50,
        'YL-TEZ' => 25,
        'BILIRKISILIK' => 10,
        'MEDYA' => 25,
    ],
];
