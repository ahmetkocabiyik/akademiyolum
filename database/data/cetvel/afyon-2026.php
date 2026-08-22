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
    ],
];
