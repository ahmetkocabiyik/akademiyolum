<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Varsayılan Yönerge Seti
    |--------------------------------------------------------------------------
    |
    | Faz 1 için puanlama motorunu besleyen statik kural setleri. Faz 2'de bu
    | veriler veritabanına (Yonerge / YonergeKural) taşınacak; motor arayüzü
    | aynı kalacak şekilde tasarlandı.
    |
    */

    'varsayilan' => 'ilahiyat_2026',

    'setler' => [

        'ilahiyat_2026' => [
            'ad' => 'ÜAK Doçentlik — İlahiyat 2026',
            'uak_hedef' => 100,
            'universite_hedef' => 220,

            // Her kategori için puan tavanı, kaynağa göre puan tablosu ve
            // eşleşme bulunamazsa kullanılacak varsayılan puan.
            'kategoriler' => [
                'makale' => [
                    'tavan' => 40,
                    'puanlar' => [
                        'SCI/SSCI' => 20,
                        'ESCI' => 15,
                        'TR Dizin' => 10,
                        'Uluslararası Diğer' => 8,
                        'Ulusal Diğer' => 5,
                    ],
                    'varsayilan' => 5,
                ],
                'kitap' => [
                    'tavan' => 30,
                    'puanlar' => [
                        'Uluslararası Yayınevi' => 20,
                        'Ulusal Yayınevi' => 12,
                        'Kitap Bölümü' => 7,
                    ],
                    'varsayilan' => 7,
                ],
                'tez_yayini' => [
                    'tavan' => 20,
                    'puanlar' => [
                        'SCI/SSCI' => 10,
                        'TR Dizin' => 5,
                    ],
                    'varsayilan' => 3,
                ],
                'atif' => [
                    'tavan' => 10,
                    'puanlar' => [],
                    'varsayilan' => 1,
                ],
                'egitim_ogretim' => [
                    'tavan' => 6,
                    'puanlar' => [],
                    'varsayilan' => 2,
                ],
                'editorluk' => [
                    'tavan' => 8,
                    'puanlar' => [
                        'Uluslararası' => 5,
                        'Ulusal' => 3,
                    ],
                    'varsayilan' => 3,
                ],
                'toplumsal_katki' => [
                    'tavan' => 10,
                    'puanlar' => [],
                    'varsayilan' => 4,
                ],
                'diger' => [
                    'tavan' => 10,
                    'puanlar' => [],
                    'varsayilan' => 2,
                ],
            ],
        ],

    ],

];
