<?php

/**
 * ALANYA ÜNİVERSİTESİ — EK-1: Öğretim Üyesi Kadrosu Başvuru Puanlama Tablosu
 * Kaynak: pdf/17537096222.alanyauniversitesi.pdf
 *
 * MADDE KODLARI yönergenin kendi bölüm harfleri (A-M) + sıra numarası; alt
 * numaralar bize ait çünkü koşullar tabloya kodla atıf yapmıyor ("tablodan
 * toplam N puan" diyor).
 *
 * ── YAZAR KURALI KORPUSTA BENZERSİZ ──
 * "Birinci yazar tam puan alır; birden çok yazarlı çalışmalarda birinci yazar
 * tam puan alır ve tam puan diğer yazarlar arasında eşit olarak pay edilir."
 * Yani birinci yazarın payı yazar sayısından ETKİLENMİYOR (her zaman 1,0) ve
 * bölünen şey ikinci bir tam puan: kalan n−1 yazar 1/(n−1) alıyor. Üç yazarlı
 * bir yayında birinci 1,0, diğer ikisi 0,5 alır — toplam 2,0 tam puan dağılır.
 * Korpustaki öteki yönergelerin hepsi tek bir tam puanı bölüyor.
 *
 * SORUMLU YAZARA AYRICALIK YOK: kural yalnızca "birinci yazar" diyor, bu
 * yüzden `baslica` ve sırasını belirtmeyen `ortak` diğer yazarlar satırını
 * alır — sırayı bilmeden birinci yazar payını vermek puanı fazla gösterirdi.
 *
 * ── AYNI KAYNAĞA DÜŞEN İKİ SATIRDA DAİMA DÜŞÜĞÜ GİRİLDİ ──
 *   Kitap A.2 uluslararası (20) / B.3 ulusal (8): 'Uluslararası/Ulusal Kitap'
 *       etiketi ikisini ayıramıyor → B.3.
 *   Kongre düzenleme I.1 uluslararası (3) / I.2 ulusal (2) → I.2.
 *   Patent başvurusu ile tescili ayrı satırlarda; kayıt başvuru/tescil ayrımı
 *       tutmadığı için TESCİL satırları girildi (başvuru satırları düşük ama
 *       "tescil edilmiş" varsayımı formun kendi alanıyla uyumlu).
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   A.3  adayın adıyla anılan denklem, şema, şekil, tablo — sözlükte yok.
 *   C.3  TÜBİTAK proje hakemliği — sözlük hakemliği dergi/proje diye
 *        ayırmıyor, dergi hakemliği satırı (C.2) kullanılıyor.
 *   F.3  merkezlerin yürüttüğü eğitimlerde görev almak.
 *   J    üye olunan mesleki kuruluşlar.
 *   K'nın "yürütücü olarak BAŞVURU yapmak" satırları (reddedilen/bekleyen
 *        proje önerileri) — kayıt proje önerisini tutmuyor.
 *
 * Yönerge: yonerge/alanya.php
 */

return [
    'kapsam_notu' => 'Puanlar Alanya Üniversitesi EK-1 Puanlama Tablosundan. '
        .'Yönergenin yazar kuralı korpusta benzersiz: "birinci yazar tam puan alır ve tam puan '
        .'diğer yazarlar arasında eşit olarak pay edilir." Birinci yazarın puanı yazar '
        .'sayısından etkilenmiyor; diğer yazarlar ikinci bir tam puanı bölüşüyor. '
        .'Faaliyetinizde kaçıncı yazar olduğunuzu seçmezseniz diğer yazarlar payı uygulanır; '
        .'yazar listesini boş bırakırsanız çarpan hiç uygulanmaz ve puanınız olduğundan yüksek '
        .'görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: adayın adıyla anılan denklem ve '
        .'şekiller, TÜBİTAK proje hakemliği, mesleki kuruluş üyelikleri ve merkez eğitimlerinde '
        .'görev almak kaynakta ayrılamadığı için girilmedi; uluslararası ile ulusal yayınevi '
        .'ayrılamadığı için kitaplarda düşük satır kullanıldı. Proje önerileri (yürütücü olarak '
        .'başvuru) da girilmedi.',

    // NOT satırı: "Birinci yazar tam puan alır; birden çok yazarlı
    // çalışmalarda birinci yazar tam puan alır ve tam puan diğer yazarlar
    // arasında eşit olarak pay edilir."
    'yazar_katsayisi' => [
        // Atıf, proje, ders, tez, idari görev ve ödül kalemleri "çalışma"
        // değil; kural yayınlar için yazılmış.
        'haric' => ['atif', 'proje', 'patent', 'tez_danismanligi', 'egitim_ogretim',
            'idari_gorev', 'odul', 'editorluk', 'toplumsal_katki'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.0]],
            // Birinci yazar yazar sayısından bağımsız olarak tam puan alır.
            'ilk' => ['kademeler' => [1 => 1.0], 'sonrasi' => 1.0],
            // Diğer yazarlar ikinci bir tam puanı aralarında bölüşür: 1/(n−1).
            'yazar_2' => ['bol' => ['pay' => 1.0, 'eksi' => 1]],
            'yazar_3' => ['bol' => ['pay' => 1.0, 'eksi' => 1]],
            'yazar_4' => ['bol' => ['pay' => 1.0, 'eksi' => 1]],
            'yazar_5' => ['bol' => ['pay' => 1.0, 'eksi' => 1]],
            'yazar_6' => ['bol' => ['pay' => 1.0, 'eksi' => 1]],
            // Yönerge sorumlu yazara ayrıcalık tanımıyor; sırası bilinmeyen
            // aday da diğer yazarlar payını alır.
            'baslica' => ['bol' => ['pay' => 1.0, 'eksi' => 1]],
            'ortak' => ['bol' => ['pay' => 1.0, 'eksi' => 1]],
        ],
    ],

    'maddeler' => [
        // ══ A. ULUSLARARASI YAYINLAR ══
        'A.1' => ['baslik' => 'SSCI, SCI-Expanded veya AHCI kapsamındaki dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'puan' => 20],
        'A.2' => ['baslik' => 'Scopus veya WoS taranan uluslararası yayınevinde kitap, kitap bölümü veya editörlük', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'BKCI / Scopus Kitap Bölümü'], 'puan' => 20],
        'A.4' => ['baslik' => 'Scopus veya WoS taranan uluslararası bilimsel toplantıda tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 10],
        'A.5' => ['baslik' => 'Uluslararası yayınlarınıza yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 2],

        // ══ B. ULUSAL YAYINLAR ══
        'B.1' => ['baslik' => 'ULAKBİM (TR Dizin) taranan ulusal hakemli dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 8],
        'B.2' => ['baslik' => 'Diğer endeksli veya ulusal hakemli dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'], 'puan' => 6],
        'B.3' => ['baslik' => 'Ulusal yayınevi veya üniversite tarafından yayımlanan kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı', 'Çeviri Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 8],
        'B.4' => ['baslik' => 'Ulusal yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Çeviri Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 6],
        'B.5' => ['baslik' => 'Ulusal yayınevi kitabında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Kitap Editörlüğü'], 'puan' => 6],
        'B.6' => ['baslik' => 'Ulusal yayınlarınıza yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 1],

        // ══ C. HAKEMLİK ══
        'C.1' => ['baslik' => 'SSCI, SCI-Expanded veya AHCI kapsamındaki dergide hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 5],
        'C.2' => ['baslik' => 'Ulusal hakemli bilimsel dergide hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik', 'ESCI / Scopus Dergi', 'TR Dizin Dergi', 'Diğer Hakemli Dergi', 'Yayın Kurulu Üyeliği'], 'puan' => 1],

        // ══ D. YÖNETİM TECRÜBELERİ ══
        'D.1' => ['baslik' => 'Rektörlük', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör'], 'puan' => 10],
        'D.2' => ['baslik' => 'Rektör yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör Yardımcısı'], 'puan' => 4],
        'D.3' => ['baslik' => 'Dekanlık veya enstitü müdürlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü'], 'puan' => 3],
        'D.4' => ['baslik' => 'Dekan veya enstitü müdür yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 2],
        'D.5' => ['baslik' => 'Bölüm başkanlığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 3],
        'D.6' => ['baslik' => 'Bölüm başkan yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı'], 'puan' => 1],

        // ══ E. KURULLAR ══
        'E.1' => ['baslik' => 'Üniversite senatosu veya yönetim kurulu üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Senato / Üniversite Yönetim Kurulu Üyesi'], 'puan' => 2],
        'E.2' => ['baslik' => 'Fakülte, enstitü veya komisyon kurulu üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 1],
        'E.4' => ['baslik' => 'Yönergesi bulunan merkez müdürlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 3],

        // ══ F. DERS TECRÜBESİ ══
        'F.1' => ['baslik' => 'Lisans veya ön lisans dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 2],
        'F.2' => ['baslik' => 'Yüksek lisans veya doktora dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],

        // ══ G. YÖNETTİĞİ TEZLER ══
        'G.1' => ['baslik' => 'Tamamlanmış yüksek lisans tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 2],
        'G.2' => ['baslik' => 'Tamamlanmış doktora tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi', 'Tez İzleme / Jüri Üyeliği'], 'puan' => 4],

        // ══ H. JÜRİ ÜYELİĞİ ══
        'H.1' => ['baslik' => 'Uluslararası değerlendirme kurulu veya ödül jürisi üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], 'puan' => 2],
        'H.2' => ['baslik' => 'Ulusal değerlendirme kurulu veya ödül jürisi üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 1],

        // ══ İ. ÖDÜLLER VE BURSLAR ══
        'İ.1' => ['baslik' => 'Ulusal bilimsel veya mesleki ödül ya da burs', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü', 'Ulusal Bilim/Sanat Ödülü', 'Yarışma Derecesi / Mansiyon', 'Burs'], 'puan' => 2],
        'İ.2' => ['baslik' => 'Uluslararası bilimsel veya mesleki ödül ya da burs', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 4],

        // ══ K. PROJELER ══
        'K.1' => ['baslik' => 'Yurt dışı kaynaklı uluslararası katılımlı proje yürütmek', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 15],
        'K.2' => ['baslik' => 'Yurt dışı kaynaklı projede araştırmacı veya danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 5],
        'K.4' => ['baslik' => 'Yurt içi kaynaklı proje yürütmek', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK', 'BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 15],
        'K.5' => ['baslik' => 'Yurt içi kaynaklı projede araştırmacı veya danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK', 'BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 4],
        'K.8' => ['baslik' => 'Ulusal patent, faydalı model veya tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 10],
        'K.10' => ['baslik' => 'Uluslararası patent, faydalı model veya tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent', 'Ticarileştirme'], 'puan' => 20],

        // ══ L. SANAT VE MİMARLIK ══
        'L.1' => ['baslik' => 'Uluslararası kişisel sanat etkinliği (sergi, bienal, dinleti, festival)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Solistlik (Uluslararası)', 'Resital (Uluslararası)'], 'puan' => 8],
        'L.2' => ['baslik' => 'Ulusal kişisel sanat etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Solistlik (Ulusal)', 'Resital (Ulusal)', 'Özgün Eser / Beste / Tasarım'], 'puan' => 4],
        'L.3' => ['baslik' => 'Uluslararası karma veya ortak sanat etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 5],
        'L.4' => ['baslik' => 'Ulusal karma veya ortak sanat etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Orkestra / Koro Üyeliği'], 'puan' => 3],

        // ══ M. BİLİMSEL TOPLANTI ══
        'M.1' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Davetli Konuşmacı'], 'puan' => 4],
        'M.2' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 2],
        'M.3' => ['baslik' => 'Bilimsel toplantılarda yayımlanan diğer bildiriler', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster', 'Ulusal Özet/Poster'], 'puan' => 1],

        // ══ I. KONGRE DÜZENLEME ══
        'I.2' => ['baslik' => 'Kongre, seminer veya sempozyum düzenleme kurulu üyeliği', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın', 'Kamu/STK Danışmanlığı'], 'puan' => 2],
        'I.2k' => ['baslik' => 'Kongre, seminer veya sempozyum düzenleme kurulu üyeliği (kurul görevi)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 2],
        'I.3' => ['baslik' => 'Uluslararası nitelikli bilimsel ya da mesleki kuruluşta görev', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dış Kuruluş Kurul Üyeliği (Uluslararası)'], 'puan' => 10],
    ],
];
