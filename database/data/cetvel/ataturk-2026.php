<?php

/**
 * Atatürk Üniversitesi — Ek-2 Gösterge Tablosu (KISMİ)
 * Kaynak: pdf/17536930072.ataturkuniversitesi.pdf
 *
 * Girilen bloklar: 01.03 (kitap), 02.01/02.02 (makale), 02.03/02.04 (proje),
 * 07 (ödüller), 00.01 (idari görevler).
 *
 * ATIF bloğu henüz yok — o koşullar ağaçta `beyan` düğümü olarak duruyor ve
 * toplam puanı düşük gösterir (fazla değil).
 *
 * Madde kodu → (kategori, kaynaklar, roller, puan). Bir faaliyet birden çok
 * maddeye giriyorsa puanı EN YÜKSEK maddeden alınır.
 * Şema ve projeksiyon notları: database/data/sart-agaci-taslak.php
 *
 * TAVAN TARAMASI (01.09.2026): kaynakta elli beş "en fazla N puan" ifadesi
 * var ama HİÇBİRİ girilen bloklara ait değil, `grup_tavanlari` bilerek yok.
 * Tavanlı satırların tamamı 00.04 (eğitim-öğretim etkinlikleri), 01.02
 * (deney föyü), 02.11 (atıf), 05.02 (kurs ve dijital ders) ile 07.04-07.08
 * (toplantı düzenleme) bloklarında; bu blokların hiçbiri girilmedi.
 * Ayrıca 07.04-07.08 tavanları KADRO SÜTUNUNA göre değişiyor (aynı satır
 * tabloda 60 ve 30 olarak iki kez geçiyor), yani girilecek olsalar cetvel
 * kadroya göre varyantlanmalı.
 */

return [
    'maddeler' => [
        '02.01.01' => [
            'baslik' => 'SCIE/SSCI/AHCI Q1 dergide araştırma makalesi',
            'kategori' => 'makale',
            'kaynaklar' => ['SCIE/SSCI (Q1)'],
            'puan' => 30,
        ],
        '02.01.02' => [
            'baslik' => 'SCIE/SSCI/AHCI Q2 veya SCOPUS Q1 dergide makale',
            'kategori' => 'makale',
            'kaynaklar' => ['SCIE/SSCI (Q2)', 'AHCI'],
            'puan' => 24,
        ],
        '02.01.03' => [
            'baslik' => 'SCIE/SSCI/AHCI Q3 veya SCOPUS Q2 dergide makale',
            'kategori' => 'makale',
            'kaynaklar' => ['SCIE/SSCI (Q3)'],
            'puan' => 16,
        ],
        '02.01.04' => [
            'baslik' => 'SCIE/SSCI/AHCI Q4 veya SCOPUS Q3 dergide makale',
            'kategori' => 'makale',
            'kaynaklar' => ['SCIE/SSCI (Q4)'],
            'puan' => 10,
        ],
        '02.01.06' => [
            'baslik' => 'SCOPUS Q4, ESCI veya alan endeksi dergide makale',
            'kategori' => 'makale',
            'kaynaklar' => ['ESCI / Scopus'],
            'puan' => 8,
        ],
        '02.01.08' => [
            'baslik' => 'Diğer uluslararası hakemli dergide makale',
            'kategori' => 'makale',
            'kaynaklar' => ['Diğer Uluslararası İndeks'],
            'puan' => 5,
        ],
        '02.02.01' => [
            'baslik' => 'TR Dizin dergide araştırma makalesi',
            'kategori' => 'makale',
            'kaynaklar' => ['TR Dizin'],
            'puan' => 6,
        ],
        '02.02.03' => [
            'baslik' => 'Diğer ulusal hakemli dergide makale',
            'kategori' => 'makale',
            'kaynaklar' => ['Diğer Ulusal Hakemli'],
            'puan' => 4,
        ],
        // Kitap kalemleri yönergede 01.03 (Özgün Bilimsel Araştırma veya Ders
        // Kitabı) altında; daha önce sehven 02.04 (Ulusal AR-GE Projesi)
        // kodlarıyla girilmişti.
        '01.03.01' => [
            'baslik' => 'Uluslararası tanınmış yayınevinden özgün bilimsel kitap',
            'kategori' => 'kitap',
            'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)'],
            'puan' => 40,
        ],
        '01.03.02' => [
            'baslik' => 'Uluslararası tanınmış yayınevinden kitap bölümü',
            'kategori' => 'kitap',
            'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'],
            'puan' => 6,
        ],
        '01.03.05' => [
            'baslik' => 'Ulusal tanınmış yayınevinden özgün bilimsel kitap',
            'kategori' => 'kitap',
            'kaynaklar' => ['Çeviri Kitap'],
            'puan' => 20,
        ],
        '01.03.06' => [
            'baslik' => 'Ulusal tanınmış yayınevinden kitap bölümü',
            'kategori' => 'kitap',
            'kaynaklar' => ['Kitap Bölümü', 'Çeviri Kitap Bölümü'],
            'puan' => 3,
        ],
        // ── 02.03 ULUSLARARASI AR-GE PROJE ÇALIŞMASI ──
        '02.03.01' => ['baslik' => 'AB Çerçeve Programı Ar-Ge projesinde yürütücü/koordinatör', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 100],
        '02.03.02' => ['baslik' => 'AB Çerçeve Programı Ar-Ge projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 60],
        '02.03.03' => ['baslik' => 'AB Çerçeve Programı Ar-Ge projesinde danışman', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['danisman'], 'puan' => 30],
        '02.03.04' => ['baslik' => 'ERASMUS+/Dünya Bankası/OECD vb. projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 40],
        '02.03.05' => ['baslik' => 'ERASMUS+/Dünya Bankası/OECD vb. projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 20],
        '02.03.06' => ['baslik' => 'ERASMUS+/Dünya Bankası/OECD vb. projede danışman', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['danisman'], 'puan' => 15],

        // ── 02.04 ULUSAL AR-GE PROJE ÇALIŞMASI ──
        '02.04.01' => ['baslik' => 'Bakanlık destekli Ar-Ge projesinde sorumlu yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 20],
        '02.04.02' => ['baslik' => 'Bakanlık destekli Ar-Ge projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 10],
        '02.04.03' => ['baslik' => 'Bakanlık destekli Ar-Ge projesinde danışman', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['danisman'], 'puan' => 5],
        '02.04.04' => ['baslik' => 'TÜBİTAK Ar-Ge projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 20],
        '02.04.05' => ['baslik' => 'TÜBİTAK Ar-Ge projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 10],
        '02.04.06' => ['baslik' => 'TÜBİTAK Ar-Ge projesinde danışman', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['danisman'], 'puan' => 10],
        '02.04.08' => ['baslik' => 'Diğer kurum destekli Ar-Ge projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK', 'BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 8],

        // ── 07 · 7. BÖLGE — ÇARPAN KATKI (ödüller) ──
        '07.01.03' => ['baslik' => 'Tanınmış uluslararası organizasyonun bilim ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü'], 'puan' => 20],
        '07.01.05' => ['baslik' => 'Jürili uluslararası güzel sanatlar etkinliğinde derece ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 10],
        '07.02.01' => ['baslik' => 'Tanınmış ulusal organizasyonun ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 20],
        '07.02.03' => ['baslik' => 'TÜBA/TÜBİTAK bilim ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü'], 'puan' => 40],
        // BURS KALEMİ YOK — 07.02.03 açıkça "(Burs, UBYT vb. kapsamındaki
        // ödüller hariç)" diyor. Burada bir süre '07.02.05' => "Burs, 5 puan"
        // duruyordu; yönergede o kod ERC ödülüdür. Uydurma kalem kaldırıldı.
        //
        // 07.02.02/04/05 önce girilememişti: hepsi 'TÜBİTAK / TÜBA Ödülü'
        // etiketine düşüyor, `puan()` en yükseği aldığı için üçü de 40 sayılırdı.
        // Kaynak sözlüğüne ayrı etiketler eklendikten sonra girildiler.
        '07.02.02' => ['baslik' => 'YÖK Doktora Tezi Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü'], 'puan' => 30],
        '07.02.04' => ['baslik' => 'TÜBA GEBİP veya TÜBİTAK TWAS Teşvik Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 30],
        '07.02.05' => ['baslik' => 'TÜBİTAK Ufuk Avrupa / ERC programı eşik üstü ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ufuk Avrupa / ERC Ödülü'], 'puan' => 30],

        // ── 00.01 İDARİ GÖREVLER ── (yıllık hesaplanır)
        // Yönerge her görevi ayrı puanlıyor; birleşik etiketler bu ayrımı
        // taşıyamadığı için sözlük görev başına bölündü.
        '00.01.01' => ['baslik' => 'Rektör', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör'], 'puan' => 50],
        '00.01.02' => ['baslik' => 'Rektör Yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör Yardımcısı'], 'puan' => 40],
        '00.01.03' => ['baslik' => 'Senato veya Üniversite Yönetim Kurulu üyesi', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Senato / Üniversite Yönetim Kurulu Üyesi'], 'puan' => 5],
        '00.01.05/07' => ['baslik' => 'Dekan, enstitü/konservatuvar/yüksekokul/MYO müdürü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü'], 'puan' => 25],
        '00.01.06/08' => ['baslik' => 'Dekan yardımcısı veya müdür yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 15],
        '00.01.09' => ['baslik' => 'Uygulama ve Araştırma Merkezi müdürü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 10],
        '00.01.11' => ['baslik' => 'Bölüm başkanı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 10],
        '00.01.12' => ['baslik' => 'Bölüm başkan yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı'], 'puan' => 5],
        '00.01.13' => ['baslik' => 'Anabilim/bilim dalı başkanı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 5],
        '03.10.03' => ['baslik' => 'Uluslararası spor federasyonunun yönetim, teknik, eğitim ya da hakem kurulunda görev', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Spor Federasyonu Kurul Üyeliği (Uluslararası)'], 'puan' => 15],
        '03.14.05' => ['baslik' => 'Ulusal spor federasyonunun yönetim, teknik, eğitim ya da hakem kurulunda görev', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Spor Federasyonu Kurul Üyeliği (Ulusal)'], 'puan' => 4],
        '07.05.01' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)', 'Toplantı Düzenleme Başkanlığı (Ulusal)'], 'puan' => 15],
        '07.05.02' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 5],

        // 00.01.05/07 (dekan 30 ↔ enstitü müdürü 25) ile 00.01.06/08 (dekan yrd.
        // 20 ↔ müdür yrd. 15) sözlükte tek etiket. DÜŞÜK değer alındı: yüksek
        // yazılsaydı her enstitü müdürü dekan gibi puanlanırdı.
        'T.1' => [
            'baslik' => 'Lisansüstü tezden üretilmiş yayın',
            'kategori' => 'tez_yayini',
            'puan' => 10,
        ],
    ],
    'gruplar' => [
        // Yönergenin "AR-GE projeleri" ve "7. bölge" ifadelerinin karşılığı.
        'AR-GE' => ['02.03*', '02.04*'],
        'AR-GE-YURUTUCU' => ['02.03.01', '02.03.04', '02.04.01', '02.04.04', '02.04.08'],
        '7. BÖLGE' => ['07*'],
        'Q1-Q2' => ['02.01.01', '02.01.02'],
        'ALAN-ENDEKS' => ['02.01.06'],
        'MAKALE' => ['02.01.*', '02.02.*'],
        'INDEKS_SCIE_SSCI_AHCI' => ['02.01.01', '02.01.02', '02.01.03', '02.01.04'],
        'INDEKS_GENIS' => ['02.01.01', '02.01.02', '02.01.03', '02.01.04', '02.01.06'],
        'KITAP' => ['01.03.*'],
        'YAYIN' => ['02.01.*', '02.02.*', '01.03.*', 'T.1'],
    ],
];
