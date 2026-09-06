<?php

/**
 * Afyon Kocatepe Üniversitesi — EK-1 Puanlama Tablosu
 * Kaynak: pdf/17536927832.afyonkocatepeuniversitesi.pdf
 *
 * Madde kodu → (kategori, kaynaklar, roller, puan). Bir faaliyet birden çok
 * maddeye giriyorsa puanı EN YÜKSEK maddeden alınır.
 * Şema ve projeksiyon notları: database/data/sart-agaci-taslak.php
 */

return [
    'maddeler' => [
        '1.1a' => [
            'baslik' => 'Q1 kategorisinde özgün makale',
            'kategori' => 'makale',
            'kaynaklar' => ['SCIE/SSCI (Q1)'],
            'puan' => 160,
        ],
        '1.1b' => [
            'baslik' => 'Q2 kategorisinde özgün makale',
            'kategori' => 'makale',
            'kaynaklar' => ['SCIE/SSCI (Q2)', 'AHCI'],
            'puan' => 140,
        ],
        '1.1c' => [
            'baslik' => 'Q3 kategorisinde özgün makale',
            'kategori' => 'makale',
            'kaynaklar' => ['SCIE/SSCI (Q3)'],
            'puan' => 120,
        ],
        '1.1d' => [
            'baslik' => 'Q4 kategorisinde özgün makale',
            'kategori' => 'makale',
            'kaynaklar' => ['SCIE/SSCI (Q4)'],
            'puan' => 100,
        ],
        '1.2' => [
            'baslik' => 'ESCI veya SCOPUS dergide makale',
            'kategori' => 'makale',
            'kaynaklar' => ['ESCI / Scopus'],
            'puan' => 80,
        ],
        '1.3' => [
            'baslik' => 'TR Dizin dergide makale',
            'kategori' => 'makale',
            'kaynaklar' => ['TR Dizin'],
            'puan' => 80,
        ],
        '1.4' => [
            'baslik' => 'Diğer hakemli dergide makale',
            'kategori' => 'makale',
            'kaynaklar' => ['Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'],
            'puan' => 40,
        ],
        '2.1' => [
            'baslik' => 'Uluslararası toplantıda tam metin bildiri',
            'kategori' => 'bildiri',
            'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin', 'Davetli Konuşmacı'],
            'puan' => 10,
        ],
        '2.2' => [
            'baslik' => 'Uluslararası toplantıda özet bildiri',
            'kategori' => 'bildiri',
            'kaynaklar' => ['Uluslararası Özet/Poster'],
            'puan' => 5,
        ],
        '2.3' => [
            'baslik' => 'Ulusal toplantıda tam metin bildiri',
            'kategori' => 'bildiri',
            'kaynaklar' => ['Ulusal Tam Metin'],
            'puan' => 8,
        ],
        '2.4' => [
            'baslik' => 'Ulusal toplantıda özet bildiri',
            'kategori' => 'bildiri',
            'kaynaklar' => ['Ulusal Özet/Poster'],
            'puan' => 4,
        ],
        '3.1' => [
            'baslik' => 'Uluslararası yayınevi kitabı',
            'kategori' => 'kitap',
            'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası/Ulusal Kitap'],
            'puan' => 100,
        ],
        '3.2' => [
            'baslik' => 'Ulusal yayınevi kitabı',
            'kategori' => 'kitap',
            'kaynaklar' => ['Tahkik (Tenkitli Metin)'],
            'puan' => 80,
        ],
        '3.3' => [
            'baslik' => 'Uluslararası yayınevi kitap bölümü',
            'kategori' => 'kitap',
            'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'],
            'puan' => 45,
        ],
        '3.4' => [
            'baslik' => 'Ulusal yayınevi kitap bölümü',
            'kategori' => 'kitap',
            'kaynaklar' => ['Kitap Bölümü'],
            'puan' => 40,
        ],
        'T.1' => [
            'baslik' => 'Lisansüstü tezden üretilmiş yayın',
            'kategori' => 'tez_yayini',
            'puan' => 40,
        ],

        // ── 4. PROJELER ──
        // "Yürütücü olarak görev alanlar tam puan, araştırmacı/danışman/bursiyer
        // olarak görev alanlar ise ilgili maddedeki puanın %50'sini alır."
        // Bu yüzden her fon kaynağı iki maddeye açılıyor.
        '4.1y' => ['baslik' => 'Dünya Bankası/AB vb. uluslararası kuruluş projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 140],
        '4.1a' => ['baslik' => 'Dünya Bankası/AB vb. uluslararası kuruluş projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 70],
        '4.2y' => ['baslik' => 'TÜBA veya TÜBİTAK destekli projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 100],
        '4.2a' => ['baslik' => 'TÜBA veya TÜBİTAK destekli projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 50],

        // 4.3 (bakanlık, 80) ile 4.4 (diğer kamu, 60) ayrı kalemler ama kaynak
        // sözlüğümüz ikisini ayırt etmiyor. DÜŞÜK değer alındı: `puan()` en
        // yükseği aldığı için 80 yazılsaydı her kamu projesi bakanlık projesi
        // gibi puanlanırdı. Eksik kalmak, olduğundan fazla göstermekten iyidir.
        '4.3y' => ['baslik' => 'Bakanlık veya diğer kamu kuruluşu projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 60],
        '4.3a' => ['baslik' => 'Bakanlık veya diğer kamu kuruluşu projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 30],
        '4.5y' => ['baslik' => 'Özel kuruluş destekli Ar-Ge projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 60],
        '4.5a' => ['baslik' => 'Özel kuruluş destekli Ar-Ge projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 30],
        '4.6y' => ['baslik' => 'Yükseköğretim kurumu destekli araştırma projesinde (BAP) yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 40],
        '4.6a' => ['baslik' => 'Yükseköğretim kurumu destekli araştırma projesinde (BAP) araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],

        // ── 5. PATENT / TESCİL EDİLMİŞ BULUŞ / FAYDALI MODEL ──
        // Sözlükle birebir örtüşüyor; beşi de ayrı etiket taşıyor.
        '5.1' => ['baslik' => 'Alanında uluslararası tescillenmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 140],
        '5.2' => ['baslik' => 'Alanında ulusal tescillenmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 115],
        '5.3' => ['baslik' => 'Faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 70],
        '5.4' => ['baslik' => 'Endüstriyel tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım'], 'puan' => 45],
        '5.5' => ['baslik' => 'Çeşit/ırk/tür tescili', 'kategori' => 'patent', 'kaynaklar' => ['Islahçı Hakkı / Çeşit Tescili'], 'puan' => 45],

        // ── 6. ÇEVİRİLER ──
        '6.1' => ['baslik' => 'Alanında kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 25],
        '6.2' => ['baslik' => 'Alanında makale, kitap bölümü veya karar tahlili çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 10],

        // ── 7. EDİTÖRLÜK VE HAKEMLİKLER ── ("her yıl için")
        // 7.1 aynı işi çeyrekliğe göre farklı puanlıyor; kaynak sözlüğü bu
        // yüzden WoS editörlüğünü Q1-Q4 diye ayırdı.
        '7.1a' => ['baslik' => 'SCI/SCIE/SSCI/AHCI Q1 dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)'], 'puan' => 100],
        '7.1b' => ['baslik' => 'SCI/SCIE/SSCI/AHCI Q2 dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q2)'], 'puan' => 80],
        '7.1c' => ['baslik' => 'SCI/SCIE/SSCI/AHCI Q3 dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q3)'], 'puan' => 70],
        '7.1d' => ['baslik' => 'SCI/SCIE/SSCI/AHCI Q4 dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q4)'], 'puan' => 60],
        '7.2' => ['baslik' => 'ESCI veya SCOPUS dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 50],
        '7.3' => ['baslik' => 'TR Dizin dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 50],
        '7.4' => ['baslik' => 'Diğer hakemli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 20],
        '7.8' => ['baslik' => 'Uluslararası yayınevi kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 70],
        '7.9' => ['baslik' => 'Ulusal kurum/yayınevi kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 40],

        // 7.6 (yardımcı/konuk editörlük, %50) ve 7.7 (hakemlik, %20) oransal
        // türev maddeler — motor bir faaliyeti yüzdeyle indirgeyemiyor, ayrı
        // etiketleri de yok. Girilmedi.

        // ── 8. ATIFLAR ──
        // 8.1 (h faktörü × 10) bir metriktir, faaliyet satırı başına puan
        // değildir; cetvelde ifade edilemiyor ve girilmedi.
        '8.2' => ['baslik' => 'SCI/SCIE/SSCI/AHCI dergilerde yayımlanan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 7],
        '8.3' => ['baslik' => 'Diğer endeks ve özlerce taranan dergilerde atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 4],
        '8.4' => ['baslik' => 'Hakemli dergi, tez veya bilimsel kitapta atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 3],
        '8.5' => ['baslik' => 'Diğer yayınlarda atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer'], 'puan' => 1],
        '14.13' => ['baslik' => 'Uluslararası akademik ya da mesleki kuruluşta yönetim kurulu görevi veya üyelik', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dış Kuruluş Kurul Üyeliği (Uluslararası)'], 'puan' => 10],
        '14.14' => ['baslik' => 'Ulusal akademik ya da mesleki kuruluşta üyelik', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dış Kuruluş Kurul Üyeliği (Ulusal)'], 'puan' => 5],
    ],
    'gruplar' => [
        '1.1' => ['1.1a', '1.1b', '1.1c', '1.1d'],
        'ULUSLARARASI' => ['1.1a', '1.1b', '1.1c', '1.1d'],
        'ULUSLARARASI_VE_ESCI' => ['1.1a', '1.1b', '1.1c', '1.1d', '1.2'],
        'Q1_Q3' => ['1.1a', '1.1b', '1.1c'],
        'MAKALE' => ['1.*'],
        'BILDIRI' => ['2.*'],
        'KITAP' => ['3.1', '3.2'],
        'KITAP_BOLUM' => ['3.3', '3.4'],
        'PROJE' => ['4.*'],
        'PROJE_YURUTUCU' => ['4.1y', '4.2y', '4.3y', '4.5y', '4.6y'],
        'PATENT' => ['5.*'],
        'CEVIRI' => ['6.*'],
        'ATIF' => ['8.*'],
    ],

    /*
     * Atıf bölümünün altındaki not: "Atıflardan en fazla 500 puan alınabilir."
     * Girilmemişti; tavansız bölüm fazla saydırır (§0). SCI atfı 7 puan, yani
     * yetmiş ikinci atıftan sonrası sayılmıyor.
     *
     * 14. bölümün "toplamda en fazla 30 puan" tavanı girilmedi: o bölümün
     * (akademik/mesleki kuruluş üyelikleri, kulüp danışmanlığı) satırları
     * cetvelde yok.
     */
    'grup_tavanlari' => [
        'ATIF' => 500,
    ],
];
