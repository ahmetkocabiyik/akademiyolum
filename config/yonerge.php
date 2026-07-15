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

        // ÜAK Doçentlik — İlahiyat Temel Alanı (Tablo 6) resmi puan cetveli.
        // Asgari 100 puan (en az 90'ı doktora sonrası). 14 ÜAK maddesi, motorun
        // 8 kategorisine eşlenmiştir; yayın kategorileri birebir ÜAK değerleridir.
        'ilahiyat_2026' => [
            'ad' => 'ÜAK Doçentlik — İlahiyat 2026',
            'uak_hedef' => 100,
            'universite_hedef' => 220,

            // Her kategori için puan tavanı, kaynağa/indekse göre puan tablosu ve
            // eşleşme bulunamazsa kullanılacak varsayılan puan.
            'kategoriler' => [
                // Madde 1-2: Uluslararası + Ulusal Makale (ÜAK'ta üst sınır yok).
                'makale' => [
                    'tavan' => 100,
                    'puanlar' => [
                        'SCIE/SSCI (Q1)' => 30,
                        'SCIE/SSCI (Q2)' => 20,
                        'AHCI' => 20,
                        'SCIE/SSCI (Q3)' => 15,
                        'ESCI / Scopus' => 10,
                        'SCIE/SSCI (Q4)' => 10,
                        'TR Dizin' => 10,
                        'Diğer Uluslararası İndeks' => 5,
                        'Diğer Ulusal Hakemli' => 4,
                    ],
                    'varsayilan' => 4,
                ],
                // Madde 4: Kitap (c/d/e bentleri en fazla 30 puan).
                'kitap' => [
                    'tavan' => 40,
                    'puanlar' => [
                        'BKCI / Scopus Kitap' => 20,
                        'Uluslararası/Ulusal Kitap' => 20,
                        'Tahkik (Tenkitli Metin)' => 10,
                        'BKCI / Scopus Kitap Bölümü' => 10,
                        'Kitap Bölümü' => 5,
                    ],
                    'varsayilan' => 5,
                ],
                // Madde 3: Lisansüstü Tezlerden Üretilmiş Yayın (en fazla 20).
                'tez_yayini' => [
                    'tavan' => 20,
                    'puanlar' => [
                        'SCIE/SSCI/AHCI' => 20,
                        'BKCI / Scopus Kitap' => 20,
                        'ESCI / Scopus' => 10,
                        'Kitap Bölümü' => 10,
                        'TR Dizin' => 5,
                        'CPCI Bildiri' => 5,
                        'Diğer' => 3,
                    ],
                    'varsayilan' => 3,
                ],
                // Madde 5: Atıf (en fazla 10, en az 5 doktora sonrası).
                'atif' => [
                    'tavan' => 10,
                    'puanlar' => [
                        'WoS / Scopus' => 3,
                        'BKCI Kitap' => 2,
                        'TR Dizin' => 2,
                        'Diğer' => 1,
                    ],
                    'varsayilan' => 1,
                ],
                // Madde 9: Eğitim-Öğretim (en fazla 6, en az 2).
                'egitim_ogretim' => [
                    'tavan' => 6,
                    'puanlar' => [
                        'Ders (4 yarıyıl / 2 yıl)' => 2,
                    ],
                    'varsayilan' => 2,
                ],
                // Madde 12: Editörlük (en fazla 4).
                'editorluk' => [
                    'tavan' => 4,
                    'puanlar' => [
                        'WoS / Scopus Dergi' => 2,
                        'BKCI Kitap' => 1,
                        'TR Dizin Dergi' => 1,
                    ],
                    'varsayilan' => 1,
                ],
                // Madde 7 + 10: Bilimsel Araştırma Projesi / Patent (BAP en fazla 20).
                'toplumsal_katki' => [
                    'tavan' => 20,
                    'puanlar' => [
                        'Uluslararası Patent' => 20,
                        'AB/TÜBİTAK Koordinatör' => 15,
                        'Ulusal Patent' => 10,
                        'AB/TÜBİTAK Araştırmacı' => 10,
                        'Kamu Ar-Ge / Danışman' => 5,
                        'BAP Yürütücü' => 3,
                    ],
                    'varsayilan' => 5,
                ],
                // Madde 6, 8, 11, 13, 14: Danışmanlık / Bildiri / Ödül / Sanatsal / Diğer.
                'diger' => [
                    'tavan' => 25,
                    'puanlar' => [
                        'Ödül (YÖK/TÜBİTAK/TÜBA)' => 25,
                        'Doktora Tez Danışmanlığı' => 5,
                        'Uluslararası Bildiri (CPCI)' => 5,
                        'h-indeksi ≥5 / Yurtdışı Araştırma' => 5,
                        'Yüksek Lisans Tez Danışmanlığı' => 3,
                        'Diğer Bildiri' => 3,
                    ],
                    'varsayilan' => 3,
                ],
            ],
        ],

    ],

];
