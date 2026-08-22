<?php

/**
 * Atatürk Üniversitesi — Ek-2 Gösterge Tablosu (KISMİ)
 * Kaynak: pdf/17536930072.ataturkuniversitesi.pdf
 *
 * Yalnızca eşiklerin atıf yaptığı 02.01 / 02.02 / 02.04 blokları girildi;
 * proje (02.03), atıf ve idari görev blokları henüz yok — o koşullar
 * ağaçta `beyan` düğümü olarak duruyor ve toplam puanı düşük gösterir.
 *
 * Madde kodu → (kategori, kaynaklar, roller, puan). Bir faaliyet birden çok
 * maddeye giriyorsa puanı EN YÜKSEK maddeden alınır.
 * Şema ve projeksiyon notları: database/data/sart-agaci-taslak.php
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
        // duruyordu; yönergede o kod ERC ödülüdür (30 puan), 5 puanlı olan
        // 07.02.06'dır. Uydurma kalem kaldırıldı.
        //
        // 07.02.04 (TÜBA GEBİP/TWAS, 30), 07.02.05 (Ufuk Avrupa/ERC, 30) ve
        // 07.02.06 (jürili ulusal derece ödülü, 5) BİLEREK girilmedi: kaynak
        // sözlüğümüz bunları 07.02.03 ile 07.01.05'ten ayırt edemiyor, aynı
        // etiketle eklenirlerse `puan()` en yükseği aldığı için hesabı
        // değiştirmeden kapsanmış gibi görünürler. Eksik kalmak, olduğundan
        // geniş görünmekten iyidir.
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
