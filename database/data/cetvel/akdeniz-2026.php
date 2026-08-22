<?php

/**
 * Akdeniz Üniversitesi — Genel Akademik Faaliyet ve Puan Tablosu
 * Kaynak: pdf/17536928172.akdenizuniversitesi.pdf
 *
 * Madde kodu → (kategori, kaynaklar, roller, puan). Bir faaliyet birden çok
 * maddeye giriyorsa puanı EN YÜKSEK maddeden alınır.
 * Şema ve projeksiyon notları: database/data/sart-agaci-taslak.php
 */

return [
    'maddeler' => [
        '1.1' => [
            'baslik' => 'SCI-Expanded/SSCI/AHCI ilk %10 dergide makale',
            'kategori' => 'makale',
            'kaynaklar' => [
            ],
            'puan' => 450,
        ],
        '1.2' => [
            'baslik' => 'SCI-Expanded/SSCI/AHCI Q1 dergide makale',
            'kategori' => 'makale',
            'kaynaklar' => ['SCIE/SSCI (Q1)'],
            'puan' => 300,
        ],
        '1.3' => [
            'baslik' => 'SCI-Expanded/SSCI/AHCI Q2 dergide makale',
            'kategori' => 'makale',
            'kaynaklar' => ['SCIE/SSCI (Q2)', 'AHCI'],
            'puan' => 150,
        ],
        '1.4' => [
            'baslik' => 'SCI-Expanded/SSCI/AHCI Q3 dergide makale',
            'kategori' => 'makale',
            'kaynaklar' => ['SCIE/SSCI (Q3)'],
            'puan' => 90,
        ],
        '1.5' => [
            'baslik' => 'SCI-Expanded/SSCI/AHCI Q4 dergide makale',
            'kategori' => 'makale',
            'kaynaklar' => ['SCIE/SSCI (Q4)'],
            'puan' => 75,
        ],
        '1.6' => [
            'baslik' => 'ESCI dergide makale',
            'kategori' => 'makale',
            'kaynaklar' => [
            ],
            'puan' => 50,
        ],
        '1.7' => [
            'baslik' => 'SCOPUS dergide makale',
            'kategori' => 'makale',
            'kaynaklar' => ['ESCI / Scopus'],
            'puan' => 30,
        ],
        '1.8' => [
            'baslik' => 'TR-Dizin dergide makale',
            'kategori' => 'makale',
            'kaynaklar' => ['TR Dizin'],
            'puan' => 15,
        ],
        '1.9' => [
            'baslik' => 'SOBIAD/EBSCO/DOAJ/Index Copernicus dergide makale',
            'kategori' => 'makale',
            'kaynaklar' => ['Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'],
            'puan' => 10,
        ],
        '2.6' => [
            'baslik' => 'Uluslararası yayınevi kitap editörlüğü/yazarlığı',
            'kategori' => 'kitap',
            'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası/Ulusal Kitap'],
            'puan' => 30,
        ],
        '2.6b' => [
            'baslik' => 'Uluslararası yayınevi kitap bölümü (kitabın yarısı)',
            'kategori' => 'kitap',
            'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'],
            'puan' => 15,
        ],
        '2.7' => [
            'baslik' => 'Ulusal yayınevi kitap editörlüğü/yazarlığı',
            'kategori' => 'kitap',
            'kaynaklar' => ['Tahkik (Tenkitli Metin)'],
            'puan' => 20,
        ],
        '2.7b' => [
            'baslik' => 'Ulusal yayınevi kitap bölümü (kitabın yarısı)',
            'kategori' => 'kitap',
            'kaynaklar' => ['Kitap Bölümü'],
            'puan' => 10,
        ],
        '3.1' => [
            'baslik' => 'SCI-Expanded/SSCI/AHCI dergilerde yapılan atıf',
            'kategori' => 'atif',
            'kaynaklar' => ['WoS / Scopus'],
            'puan' => 5,
        ],
        '3.2' => [
            'baslik' => 'SENSE kategorisindeki kitaplarda yapılan atıf',
            'kategori' => 'atif',
            'kaynaklar' => ['BKCI Kitap'],
            'puan' => 4,
        ],
        '3.3' => [
            'baslik' => 'Diğer kitap/hakemli dergilerde yapılan atıf',
            'kategori' => 'atif',
            'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'],
            'puan' => 2,
        ],
        '4.2' => [
            'baslik' => 'Uluslararası patent tescili',
            'kategori' => 'patent',
            'kaynaklar' => ['Uluslararası Patent'],
            'puan' => 250,
        ],
        '4.6' => [
            'baslik' => 'Çeşit tescili / ıslahçı hakkı',
            'kategori' => 'patent',
            'kaynaklar' => ['Islahçı Hakkı / Çeşit Tescili'],
            'puan' => 200,
        ],
        '4.3' => [
            'baslik' => 'Ulusal patent tescili',
            'kategori' => 'patent',
            'kaynaklar' => ['Ulusal Patent'],
            'puan' => 50,
        ],
        '4.9' => [
            'baslik' => 'Ticarileştirilmiş endüstriyel/sanatsal/mimari tasarım',
            'kategori' => 'patent',
            'kaynaklar' => ['Endüstriyel Tasarım', 'Yazılım', 'Ticarileştirme'],
            'puan' => 30,
        ],
        '4.10' => [
            'baslik' => 'Ticarileştirilmiş faydalı model',
            'kategori' => 'patent',
            'kaynaklar' => ['Faydalı Model'],
            'puan' => 25,
        ],
        '5.1' => [
            'baslik' => 'Doktora tezi danışmanlığı',
            'kategori' => 'tez_danismanligi',
            'kaynaklar' => ['Doktora Tezi'],
            'puan' => 15,
        ],
        '5.2' => [
            'baslik' => 'Tıpta/diş/sanatta yeterlik tezi danışmanlığı',
            'kategori' => 'tez_danismanligi',
            'kaynaklar' => ['Tıpta/Diş/Sanatta Yeterlik Tezi'],
            'puan' => 10,
        ],
        '5.3' => [
            'baslik' => 'Yüksek lisans tezi danışmanlığı',
            'kategori' => 'tez_danismanligi',
            'kaynaklar' => ['Yüksek Lisans Tezi'],
            'puan' => 7,
        ],
        '6.1' => [
            'baslik' => 'Uluslararası fonlu projede yürütücü/koordinatör',
            'kategori' => 'proje',
            'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'],
            'roller' => ['yurutucu'],
            'puan' => 200,
        ],
        '6.2' => [
            'baslik' => 'Uluslararası fonlu projede araştırıcı',
            'kategori' => 'proje',
            'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'],
            'roller' => ['arastirmaci', 'danisman', 'bursiyer'],
            'puan' => 50,
        ],
        '6.3' => [
            'baslik' => 'Ulusal fonlu projede yürütücü/koordinatör',
            'kategori' => 'proje',
            'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'],
            'roller' => ['yurutucu'],
            'puan' => 50,
        ],
        '6.4' => [
            'baslik' => 'Ulusal fonlu projede araştırmacı veya bursiyer',
            'kategori' => 'proje',
            'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'],
            'roller' => ['arastirmaci', 'danisman', 'bursiyer'],
            'puan' => 15,
        ],
        '6.5' => [
            'baslik' => 'BAP projesinde yürütücü',
            'kategori' => 'proje',
            'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'],
            'roller' => ['yurutucu'],
            'puan' => 20,
        ],
        '6.6' => [
            'baslik' => 'BAP projesinde araştırıcı',
            'kategori' => 'proje',
            'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'],
            'roller' => ['arastirmaci', 'danisman', 'bursiyer'],
            'puan' => 5,
        ],
        '7.1' => [
            'baslik' => 'SCI-Expanded/SSCI/AHCI dergide yayımlanan bildiri',
            'kategori' => 'bildiri',
            'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'],
            'puan' => 8,
        ],
        '7.2' => [
            'baslik' => 'Uluslararası kongrede tam metin bildiri',
            'kategori' => 'bildiri',
            'kaynaklar' => ['Uluslararası Tam Metin', 'Davetli Konuşmacı'],
            'puan' => 4,
        ],
        '7.3' => [
            'baslik' => 'Uluslararası kongrede özet bildiri',
            'kategori' => 'bildiri',
            'kaynaklar' => ['Uluslararası Özet/Poster'],
            'puan' => 2,
        ],
        '7.4' => [
            'baslik' => 'Ulusal kongrede tam metin bildiri',
            'kategori' => 'bildiri',
            'kaynaklar' => ['Ulusal Tam Metin'],
            'puan' => 2,
        ],
        '7.5' => [
            'baslik' => 'Ulusal kongrede özet bildiri',
            'kategori' => 'bildiri',
            'kaynaklar' => ['Ulusal Özet/Poster'],
            'puan' => 1,
        ],
        'T.1' => [
            'baslik' => 'Lisansüstü tezden üretilmiş yayın',
            'kategori' => 'tez_yayini',
            'puan' => 15,
        ],
    ],
    'gruplar' => [
        'BOLUM_1_MAKALE' => ['1.*'],
        'BOLUM_2_KITAP' => ['2.*'],
        'BOLUM_3_ATIF' => ['3.*'],
        'BOLUM_4_PATENT' => ['4.*'],
        'BOLUM_5_TEZ' => ['5.*'],
        'BOLUM_6_PROJE' => ['6.*'],
        'BOLUM_7_BILDIRI' => ['7.*'],
        'YAYIN' => ['1.*', '2.*', 'T.1'],
    ],
];
