<?php

/**
 * ÇUKUROVA ÜNİVERSİTESİ — EK 2: Asgari Ölçütler İçin Puan Tablosu
 * Kaynak: pdf/17536992412.cukurovauniverstesi.pdf (Senato değişikliği 24/12/2024)
 *
 * TEK ORTAK PUAN TABLOSU, ON İKİ ALAN İÇİN AYRI ASGARİ ÖLÇÜT TABLOSU (EK 1).
 * EK 2 faaliyet türü başına puanı verir; EK 1 her temel alan ve kadro için
 * asgari puanı ve makale/bildiri/proje sayılarını.
 *
 * ÇEYREKLİK AYRIMI WoS ile SCOPUS ARASINDA FARKLI: WoS Q1 90 puan alırken
 * Scopus Q1 75; WoS Q3 45 iken Scopus Q3 15. Kaynak sözlüğünde WoS ve Scopus
 * çeyreklikleri ayrı etiket değil — 'ESCI / Scopus' tek etiket. Bu yüzden
 * Scopus kademeleri girilmedi; girilseydi `puan()` en yükseği aldığı için her
 * Scopus makalesi Q1 sayılırdı.
 *
 * "İLK %10'LUK DİLİM" kademesi (120 puan) da aynı sebeple girilmedi: Q1
 * etiketine düşer ve her Q1 makaleyi 120 yapardı.
 *
 * KADEME ÇİFTLERİNDE DAİMA DÜŞÜK OLAN: kitapta BKCI 90 / Scopus 60 tek etikete
 * düştüğü için 60; patentte "tescillenmiş" ile "ticarileşmiş" ayrılamadığı için
 * tescil puanı. Aday puanını eksik görür, fazla görmez.
 *
 * GİRİLMEYEN: EK 4 (genel akademik etkinlikler listesi) — doçent ve profesör
 * koşullarında "en az beş tanesini sağlamak" biçiminde anılıyor, puan
 * üretmiyor; motor tarafında beyan olarak duruyor. Ayrıca 4) bölümündeki proje
 * YÖNETİCİLİĞİ (120): kayıt yöneticiliği yürütücülükten ayırmıyor, §0 uyarınca
 * yürütücü puanı (90) uygulanıyor. Kitap bölümü, çeviri ve ansiklopedi
 * maddesinin EK 2'de karşılığı yok.
 *
 * ── BAŞLIK METNİ ÜZERİNDEN DENETİM (03.09.2026) ──
 * Bu dosyanın kodları tamamen bize ait (kaynağın tablosunda satır kodu yok),
 * yani bir satırı kaynakla eşlemenin tek yolu BAŞLIK METNİ. EK 2'nin altı
 * bölümü satır satır karşılaştırıldı: GİRİLEN ON DOKUZ SATIRIN HEPSİ
 * KAYNAĞIN DEĞERİNDE, fazla sayan tek satır yok.
 *
 * Denetim ÜÇ EKSİK SATIR buldu — etiketleri hiçbir satıra düşmediği için
 * SIFIR alıyorlardı:
 *   'Ticarileştirme' — kaynak ticarileşmiş kademeyi ayrıca puanlıyor (60/60/90).
 *   'Yarışma Derecesi / Mansiyon' ile jürili karma etkinlik — YÖK Genel
 *       Kurulu'nun 30.01.2025 eklemesi "jürili yarışmalara katılmak" (45).
 *   Jüri üyeliği ve başkanlığı — aynı eklemenin ikinci satırı, "jürili
 *       yarışmalarda danışmanlık ya da jüri üyeliği" (90).
 * Üçü de EKSİK sayıyordu; eklenmeleri puanı yalnız yukarı taşır.
 *
 * KODLAR TAMAMEN BİZE AİT — KAYNAĞIN TABLOSUNDA SATIR KODU YOK. Puan
 * tablosu satırları düz metin açıklamalar hâlinde, numarasız veriliyor;
 * kodlar okunabilirlik için türetildi. Bu yüzden bir satırı kaynakla
 * eşlemenin tek yolu BAŞLIK METNİDİR — kod bir çapa değil.
 */

return [
    'kapsam_notu' => 'Çok yazarlı eserlerde puan yönergenin yazar çarpanı tablosuna göre azaltılır; çarpan adayın yazar SIRASINA da bağlı olduğu için faaliyetinizde rolü ("tek / ilk / başlıca / ortak") işaretlemeniz gerekir. Rol veya yazar listesi boşsa en düşük çarpan uygulanır ya da hiç uygulanmaz. Puanlar Çukurova Üniversitesi EK 2 tablosundan (24/12/2024 senato değişikliği). '
        .'Scopus çeyreklik kademeleri ile "ilk %10\'luk dilim" kademesi kaynak sözlüğünde WoS '
        .'çeyrekliklerinden ayrılamadığı için girilmedi; kitap ve patent kalemlerinde ayrılamayan '
        .'kademe çiftlerinin düşük olanı kullanıldı. EK 2\'de kitap bölümü, çeviri ve ansiklopedi '
        .'maddesi için satır yok. ÜNİVERSİTE BAP PROJELERİ VE ÖZEL SEKTÖR PROJELERİ '
        .'SAYILMIYOR: EK 2\'nin tanım bölümü desteklenen projeyi TÜBİTAK ile bakanlık ve kamu '
        .'Ar-Ge programlarıyla sınırlıyor, ikisi de o listede yok. Proje YÖNETİCİLİĞİ (120 puan) '
        .'da girilemedi; faaliyet kaydı yöneticiliği yürütücülükten ayırmıyor, yürütücü puanı '
        .'(90) uygulanıyor. Gerçek toplamınız burada görünenden yüksek olabilir, düşük olamaz.',

    // Yönerge: iki yazarlı eserde ikinci yazar puanın 0,5'ini alır. Yazar
    // sayısı ikiden fazlaysa puanın yarısı başlıca yazara verilir; kalan yarı
    // diğer yazar sayısına bölünüp 1,6 ile çarpılır (0,5/(n-1)×1,6 = 0,8/(n-1)).
    // Hiçbir yazar tek yazarlı puanın %10'undan azını almaz.
    'yazar_katsayisi' => [
        'taban' => 0.10,
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.0]],
            'ilk' => ['kademeler' => [1 => 1.0, 2 => 1.0], 'sonrasi' => 0.5],
            'baslica' => ['kademeler' => [1 => 1.0, 2 => 1.0], 'sonrasi' => 0.5],
            'ortak' => ['kademeler' => [1 => 1.0, 2 => 0.5], 'bol' => ['pay' => 0.8, 'eksi' => 1]],
        ],
    ],

    'maddeler' => [
        // ── MAKALE ──
        // Sözlük 17.09.2026'da dilim kademesini açtı.
        'M-D10' => ['baslik' => 'WoS CC SCIE/SSCI/AHCI ilk %10\'luk dilime giren dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (İlk %10)'], 'puan' => 120],
        'M-Q1' => ['baslik' => 'WoS CC SCIE/SSCI/AHCI Q1 sınıfı dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'puan' => 90],
        'M-Q2' => ['baslik' => 'WoS CC SCIE/SSCI/AHCI Q2 sınıfı dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'puan' => 75],
        'M-Q3' => ['baslik' => 'WoS CC SCIE/SSCI/AHCI Q3 sınıfı dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'puan' => 45],
        'M-Q4' => ['baslik' => 'WoS CC SCIE/SSCI/AHCI Q4 sınıfı dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'puan' => 15],
        'M-ESCI' => ['baslik' => 'WoS CC ESCI dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI'], 'puan' => 10],
        // Sözlük 17.09.2026'da Scopus çeyrekliğini ayırdı. Kaynağın AYRI bir Scopus
        // merdiveni var (75/45/15/10) ve hiç girilmemişti; Scopus makalesi
        // ESCI satırına düşüp 10 alıyordu.
        'M-SQ1' => ['baslik' => 'Scopus Q1 sınıfı dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Scopus (Q1)'], 'puan' => 75],
        'M-SQ2' => ['baslik' => 'Scopus Q2 sınıfı dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Scopus (Q2)'], 'puan' => 45],
        'M-SQ3' => ['baslik' => 'Scopus Q3 sınıfı dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Scopus (Q3)'], 'puan' => 15],
        'M-SQ4' => ['baslik' => 'Scopus Q4 sınıfı dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Scopus (Q4)'], 'puan' => 10],
        'M-TR' => ['baslik' => 'TR Dizin dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 10],
        'M-DIGER' => ['baslik' => 'Diğer uluslararası endeksli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'puan' => 5],

        // ── 2) KİTAP ──
        // Bölüm tablosu YAYINEVİ KADEMESİ veriyor, eser türü değil: kitap
        // bölümü, çeviri ve ansiklopedi maddesi için satır YOK. O kalemler
        // girilmedi — kitap satırına yazılsalar bir bölüm tam kitap sayılırdı.
        'K-BKCI' => ['baslik' => 'WoS CC BKCI veya Scopus kapsamında kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 60],
        'K-DIGER' => ['baslik' => 'Ulusal/uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 30],

        // ── 3) BİLDİRİ ──
        'B-CPCI' => ['baslik' => 'WoS CC CPCI kapsamında bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 15],
        'B-SCOPUS' => ['baslik' => 'Scopus kapsamında bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin'], 'puan' => 10],
        'B-DIGER' => ['baslik' => 'Diğer ulusal/uluslararası bilimsel toplantıda sunulmuş bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster', 'Ulusal Tam Metin', 'Ulusal Özet/Poster', 'Davetli Konuşmacı'], 'puan' => 5],

        // ── 4) ARAŞTIRMA PROJESİ ──
        // EK 2'nin tanım bölümü fon kuruluşlarını SAYIYOR: TÜBİTAK, TÜBİTAK
        // uluslararası iş birliği ve ulusal Ar-Ge destek programları (Sanayi ve
        // Teknoloji Bakanlığı, KOSGEB, Savunma Sanayii Başkanlığı, TÜSEB,
        // TENMAK ve diğer bakanlıklar). ÜNİVERSİTE BAP'I VE ÖZEL SEKTÖR LİSTEDE
        // YOK; ikisi de satırdan çıkarıldı (01.09.2026).
        'P-YURUTUCU' => ['baslik' => 'Desteklenen araştırma projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon', 'TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 90],
        'P-ARASTIRMACI' => ['baslik' => 'Desteklenen araştırma projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon', 'TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 45],

        // ── 5) ÖDÜL ──
        'O-ODUL' => ['baslik' => 'YÖK, TÜBİTAK, TÜBA veya eş değeri ulusal/uluslararası ödül', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'Ufuk Avrupa / ERC Ödülü', 'Uluslararası Bilim/Sanat Ödülü', 'Ulusal Bilim/Sanat Ödülü'], 'puan' => 60],

        // ── 6) PATENT / FAYDALI MODEL / TASARIM / ÇEŞİT ──
        // Her satırın "tescillenmiş" ve "ticarileşmiş" iki kademesi var;
        // sözlükte bu ayrım yok, o yüzden hepsinde TESCİL puanı (düşük olan).
        'F-ULUSLARARASI' => ['baslik' => 'Tescillenmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 60],
        'F-ULUSAL' => ['baslik' => 'Tescillenmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 45],
        'F-MODEL' => ['baslik' => 'Tescillenmiş faydalı model veya tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım'], 'puan' => 45],
        'F-CESIT' => ['baslik' => 'Tescillenmiş çeşit', 'kategori' => 'patent', 'kaynaklar' => ['Islahçı Hakkı / Çeşit Tescili'], 'puan' => 45],
        // Kaynak TİCARİLEŞMİŞ kademeyi de puanlıyor (çeşit 60, ulusal patent
        // 60, uluslararası patent 90); etiket hangisi olduğunu taşımadığı
        // için §0 uyarınca en düşüğü. Bu satır açılana kadar 'Ticarileştirme'
        // etiketi Çukurova'da hiçbir satıra düşmüyor ve SIFIR alıyordu.
        'F-TICARI' => ['baslik' => 'Ticarileşmiş patent, faydalı model, tasarım ya da çeşit', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 60],

        // ── 4) ARAŞTIRMA PROJESİ — JÜRİLİ YARIŞMA SATIRLARI ──
        // YÖK Genel Kurulu'nun 30.01.2025 eklemesi; bir tur girilmemişti.
        'P-YARISMA' => ['baslik' => 'Ulusal veya uluslararası düzeyde gerçekleştirilen jürili yarışmaya katılmak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 45],
        'P-YARISMA-SANAT' => ['baslik' => 'Ulusal veya uluslararası düzeyde gerçekleştirilen jürili yarışmaya katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Ulusal)'], 'puan' => 45],
        'P-JURI' => ['baslik' => 'Jürili yarışmada danışmanlık yapmak ya da jüri üyesi olarak görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 90],
    ],

    'gruplar' => [
        // EK 1 koşullarının birebir kullandığı küme: "WoS CC veri tabanında
        // dizinlenen Q1, Q2 veya Q3 sınıfı dergilerde".
        'WOS-Q1Q3' => ['M-Q1', 'M-Q2', 'M-Q3'],
        'MAKALE' => ['M-*'],
        'BILDIRI' => ['B-*'],
        'KITAP' => ['K-*'],

        // Tavanı yalnız "diğer yayınevi" kademesi taşıyor; BKCI/Scopus kitabı
        // sınırsız. Bu yüzden K-* değil tek madde.
        'KITAP-DIGER' => ['K-DIGER'],
    ],

    // EK 2'nin tanım bölümündeki iki bölüm tavanı (23. sayfa). İkisi de
    // 01.09.2026'ya kadar girilmemişti; tavansız bir bölüm doğrudan fazla
    // saydırır (§0).
    'grup_tavanlari' => [
        'BILDIRI' => 30,        // "Bildiri kategorisinde en fazla 30 puan alınabilir."
        'KITAP-DIGER' => 30,    // "Diğer ulusal/uluslararası yayınevleri ... en fazla 30 puan"
    ],
];
