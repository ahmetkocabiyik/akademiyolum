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
 * YÖNETİCİLİĞİ (120) ve jürili yarışma satırları ile kitap bölümü / çeviri /
 * ansiklopedi maddesi — bunların EK 2'de karşılığı yok.
 */

return [
    'kapsam_notu' => 'Çok yazarlı eserlerde puan yönergenin yazar çarpanı tablosuna göre azaltılır; çarpan adayın yazar SIRASINA da bağlı olduğu için faaliyetinizde rolü ("tek / ilk / başlıca / ortak") işaretlemeniz gerekir. Rol veya yazar listesi boşsa en düşük çarpan uygulanır ya da hiç uygulanmaz. Puanlar Çukurova Üniversitesi EK 2 tablosundan (24/12/2024 senato değişikliği). '
        .'Scopus çeyreklik kademeleri ile "ilk %10\'luk dilim" kademesi kaynak sözlüğünde WoS '
        .'çeyrekliklerinden ayrılamadığı için girilmedi; kitap ve patent kalemlerinde ayrılamayan '
        .'kademe çiftlerinin düşük olanı kullanıldı. EK 2\'de kitap bölümü, çeviri ve ansiklopedi '
        .'maddesi için satır yok. Gerçek toplamınız burada görünenden yüksek olabilir, düşük olamaz.',

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
        'M-Q1' => ['baslik' => 'WoS CC SCIE/SSCI/AHCI Q1 sınıfı dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'puan' => 90],
        'M-Q2' => ['baslik' => 'WoS CC SCIE/SSCI/AHCI Q2 sınıfı dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'puan' => 75],
        'M-Q3' => ['baslik' => 'WoS CC SCIE/SSCI/AHCI Q3 sınıfı dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'puan' => 45],
        'M-Q4' => ['baslik' => 'WoS CC SCIE/SSCI/AHCI Q4 sınıfı dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'puan' => 15],
        'M-ESCI' => ['baslik' => 'WoS CC ESCI dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 10],
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
        'P-YURUTUCU' => ['baslik' => 'Desteklenen araştırma projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon', 'TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK', 'BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 90],
        'P-ARASTIRMACI' => ['baslik' => 'Desteklenen araştırma projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon', 'TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK', 'BAP (Üniversite)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 45],

        // ── 5) ÖDÜL ──
        'O-ODUL' => ['baslik' => 'YÖK, TÜBİTAK, TÜBA veya eş değeri ulusal/uluslararası ödül', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'Ufuk Avrupa / ERC Ödülü', 'Uluslararası Bilim/Sanat Ödülü', 'Ulusal Bilim/Sanat Ödülü'], 'puan' => 60],

        // ── 6) PATENT / FAYDALI MODEL / TASARIM / ÇEŞİT ──
        // Her satırın "tescillenmiş" ve "ticarileşmiş" iki kademesi var;
        // sözlükte bu ayrım yok, o yüzden hepsinde TESCİL puanı (düşük olan).
        'F-ULUSLARARASI' => ['baslik' => 'Tescillenmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 60],
        'F-ULUSAL' => ['baslik' => 'Tescillenmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 45],
        'F-MODEL' => ['baslik' => 'Tescillenmiş faydalı model veya tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım'], 'puan' => 45],
        'F-CESIT' => ['baslik' => 'Tescillenmiş çeşit', 'kategori' => 'patent', 'kaynaklar' => ['Islahçı Hakkı / Çeşit Tescili'], 'puan' => 45],
    ],

    'gruplar' => [
        // EK 1 koşullarının birebir kullandığı küme: "WoS CC veri tabanında
        // dizinlenen Q1, Q2 veya Q3 sınıfı dergilerde".
        'WOS-Q1Q3' => ['M-Q1', 'M-Q2', 'M-Q3'],
        'MAKALE' => ['M-*'],
        'BILDIRI' => ['B-*'],
        'KITAP' => ['K-*'],
    ],

    'grup_tavanlari' => [],
];
