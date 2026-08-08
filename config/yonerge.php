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
                // Madde 7: Bilimsel Araştırma Projesi (BAP en fazla 20).
                'proje' => [
                    'tavan' => 20,
                    'puanlar' => [
                        'AB Çerçeve / Ufuk' => 15,
                        'Diğer Uluslararası Fon' => 12,
                        'TÜBİTAK' => 10,
                        'TÜSEB' => 10,
                        'Diğer Kamu Kurumu' => 5,
                        'Özel Sektör / STK' => 5,
                        'BAP (Üniversite)' => 3,
                        'Öğrenci Projesi (2209 vb.)' => 2,
                    ],
                    'varsayilan' => 3,
                ],
                // Madde 10: Patent.
                'patent' => [
                    'tavan' => 20,
                    'puanlar' => [
                        'Uluslararası Patent' => 20,
                        'Ulusal Patent' => 10,
                        'Faydalı Model' => 5,
                        'Endüstriyel Tasarım' => 5,
                        'Yazılım' => 5,
                        'Islahçı Hakkı / Çeşit Tescili' => 5,
                        'Ticarileştirme' => 10,
                    ],
                    'varsayilan' => 5,
                ],
                // Madde 6: Lisansüstü Tez Danışmanlığı.
                'tez_danismanligi' => [
                    'tavan' => 10,
                    'puanlar' => [
                        'Doktora Tezi' => 5,
                        'Tıpta/Diş/Sanatta Yeterlik Tezi' => 5,
                        'Yüksek Lisans Tezi' => 3,
                        'Tez İzleme / Jüri Üyeliği' => 1,
                    ],
                    'varsayilan' => 3,
                ],
                // Madde 8: Bilimsel Toplantı Faaliyeti (bildiri).
                'bildiri' => [
                    'tavan' => 10,
                    'puanlar' => [
                        'Uluslararası Tam Metin (CPCI)' => 5,
                        'Uluslararası Tam Metin' => 4,
                        'Uluslararası Özet/Poster' => 2,
                        'Ulusal Tam Metin' => 3,
                        'Ulusal Özet/Poster' => 1,
                        'Davetli Konuşmacı' => 5,
                    ],
                    'varsayilan' => 3,
                ],
                // Madde 11: Ödüller.
                'odul' => [
                    'tavan' => 25,
                    'puanlar' => [
                        'Uluslararası Bilim/Sanat Ödülü' => 25,
                        'TÜBİTAK / TÜBA Ödülü' => 25,
                        'Ulusal Bilim/Sanat Ödülü' => 10,
                        'Yarışma Derecesi / Mansiyon' => 5,
                        'Burs' => 5,
                    ],
                    'varsayilan' => 5,
                ],
                // Madde 13: Sanat ve tasarım etkinlikleri (Güzel Sanatlar alanı).
                'sanatsal_etkinlik' => [
                    'tavan' => 20,
                    'puanlar' => [
                        'Kişisel Etkinlik (Uluslararası)' => 20,
                        'Kişisel Etkinlik (Ulusal)' => 10,
                        'Karma/Jürili Etkinlik (Uluslararası)' => 10,
                        'Karma/Jürili Etkinlik (Ulusal)' => 5,
                        'Özgün Eser / Beste / Tasarım' => 10,
                        'Albüm / Konser Kaydı' => 10,
                        'Eserin Yayında Yer Alması / Satın Alınması' => 5,
                    ],
                    'varsayilan' => 5,
                ],
                // İdari görevler (yönergelerin ~yarısında puanlanır).
                'idari_gorev' => [
                    'tavan' => 10,
                    'puanlar' => [
                        'Rektör / Rektör Yardımcısı' => 6,
                        'Dekan / Enstitü-YO Müdürü' => 6,
                        'Dekan Yrd. / Müdür Yrd.' => 5,
                        'Bölüm Başkanı' => 3,
                        'Anabilim Dalı Başkanı / Koordinatörlük' => 2,
                        'Kurul / Komisyon Üyeliği' => 2,
                    ],
                    'varsayilan' => 2,
                ],
                // Madde 14: Toplumsal katkı faaliyetleri.
                'toplumsal_katki' => [
                    'tavan' => 10,
                    'puanlar' => [
                        'Topluma Hizmet Projesi' => 5,
                        'Bilim İletişimi / Popüler Yayın' => 3,
                        'Kamu/STK Danışmanlığı' => 3,
                    ],
                    'varsayilan' => 5,
                ],
                // Sınıflanamayan diğer akademik faaliyetler.
                'diger' => [
                    'tavan' => 10,
                    'puanlar' => [
                        'Diğer' => 3,
                    ],
                    'varsayilan' => 3,
                ],
            ],
        ],

    ],

];
