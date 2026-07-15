<?php

/*
|--------------------------------------------------------------------------
| Üniversiteye Özel Puan Cetvelleri (Ek-1 Tabloları)
|--------------------------------------------------------------------------
|
| Her üniversite akademik faaliyetleri KENDİ Ek-1 tablosuna göre puanlar; bu
| değerler ÜAK cetvelinden ciddi farklılaşabilir (ör. Afyon TR Dizin = 80,
| ÜAK = 10). Yönerge Analizi, kullanıcının puanını ilgili üniversitenin bu
| cetveliyle YENİDEN hesaplayıp o üniversitenin barajıyla karşılaştırır.
|
| Burada tanımlı olmayan üniversiteler ÜAK cetveline (config) düşer. Kaynak
| adları (dizin/endeks) evrensel ÜAK taksonomisiyle aynıdır; yalnızca puan
| değerleri ve tavanları üniversiteye göre değişir.
|
*/

return [

    // Afyon Kocatepe Üniversitesi — Ek-1 (2026). Puanlar ÜAK'ın ~5-8 katı.
    'Afyon Kocatepe Üniversitesi' => [
        'makale' => [
            'tavan' => 800,
            'puanlar' => [
                'SCIE/SSCI (Q1)' => 160,
                'SCIE/SSCI (Q2)' => 140,
                'AHCI' => 130,
                'SCIE/SSCI (Q3)' => 120,
                'SCIE/SSCI (Q4)' => 100,
                'ESCI / Scopus' => 80,
                'TR Dizin' => 80,
                'Diğer Uluslararası İndeks' => 40,
                'Diğer Ulusal Hakemli' => 40,
            ],
            'varsayilan' => 30,
        ],
        'kitap' => [
            'tavan' => 300,
            'puanlar' => [
                'BKCI / Scopus Kitap' => 100,
                'Uluslararası/Ulusal Kitap' => 80,
                'Tahkik (Tenkitli Metin)' => 80,
                'BKCI / Scopus Kitap Bölümü' => 45,
                'Kitap Bölümü' => 40,
            ],
            'varsayilan' => 40,
        ],
        'tez_yayini' => [
            'tavan' => 200,
            'puanlar' => [
                'SCIE/SSCI/AHCI' => 120,
                'BKCI / Scopus Kitap' => 100,
                'ESCI / Scopus' => 80,
                'TR Dizin' => 80,
                'Kitap Bölümü' => 45,
                'Diğer' => 40,
                'CPCI Bildiri' => 10,
            ],
            'varsayilan' => 40,
        ],
        'atif' => [
            'tavan' => 60,
            'puanlar' => [
                'WoS / Scopus' => 3,
                'BKCI Kitap' => 2,
                'TR Dizin' => 2,
                'Diğer' => 1,
            ],
            'varsayilan' => 1,
        ],
        'egitim_ogretim' => [
            'tavan' => 40,
            'puanlar' => ['Ders (4 yarıyıl / 2 yıl)' => 10],
            'varsayilan' => 5,
        ],
        'editorluk' => [
            'tavan' => 200,
            'puanlar' => [
                'WoS / Scopus Dergi' => 80,
                'BKCI Kitap' => 50,
                'TR Dizin Dergi' => 50,
            ],
            'varsayilan' => 50,
        ],
        'toplumsal_katki' => [
            'tavan' => 300,
            'puanlar' => [
                'Uluslararası Patent' => 140,
                'AB/TÜBİTAK Koordinatör' => 140,
                'Ulusal Patent' => 115,
                'AB/TÜBİTAK Araştırmacı' => 100,
                'Kamu Ar-Ge / Danışman' => 60,
                'BAP Yürütücü' => 40,
            ],
            'varsayilan' => 40,
        ],
        'diger' => [
            'tavan' => 100,
            'puanlar' => [
                'Ödül (YÖK/TÜBİTAK/TÜBA)' => 25,
                'Doktora Tez Danışmanlığı' => 25,
                'h-indeksi ≥5 / Yurtdışı Araştırma' => 25,
                'Uluslararası Bildiri (CPCI)' => 10,
                'Yüksek Lisans Tez Danışmanlığı' => 10,
                'Diğer Bildiri' => 8,
            ],
            'varsayilan' => 8,
        ],
    ],

    // Akdeniz Üniversitesi — Ek-1 (Akademik Yayın Puanlama). Makale/kitap/atıf/patent
    // birebir tablodan; tez/eğitim/proje kategorilerinde makul değerler.
    'Akdeniz Üniversitesi' => [
        'makale' => [
            'tavan' => 1000,
            'puanlar' => [
                'SCIE/SSCI (Q1)' => 300,
                'SCIE/SSCI (Q2)' => 150,
                'AHCI' => 150,
                'SCIE/SSCI (Q3)' => 90,
                'SCIE/SSCI (Q4)' => 75,
                'ESCI / Scopus' => 50,
                'TR Dizin' => 15,
                'Diğer Uluslararası İndeks' => 30,
                'Diğer Ulusal Hakemli' => 10,
            ],
            'varsayilan' => 10,
        ],
        'kitap' => [
            'tavan' => 300,
            'puanlar' => [
                'BKCI / Scopus Kitap' => 100,
                'Uluslararası/Ulusal Kitap' => 30,
                'Tahkik (Tenkitli Metin)' => 30,
                'BKCI / Scopus Kitap Bölümü' => 50,
                'Kitap Bölümü' => 15,
            ],
            'varsayilan' => 15,
        ],
        'tez_yayini' => [
            'tavan' => 300,
            'puanlar' => [
                'SCIE/SSCI/AHCI' => 150,
                'BKCI / Scopus Kitap' => 100,
                'ESCI / Scopus' => 50,
                'TR Dizin' => 15,
                'Kitap Bölümü' => 50,
                'Diğer' => 10,
                'CPCI Bildiri' => 10,
            ],
            'varsayilan' => 15,
        ],
        'atif' => [
            'tavan' => 250,
            'puanlar' => [
                'WoS / Scopus' => 5,
                'BKCI Kitap' => 4,
                'TR Dizin' => 2,
                'Diğer' => 2,
            ],
            'varsayilan' => 2,
        ],
        'egitim_ogretim' => [
            'tavan' => 40,
            'puanlar' => ['Ders (4 yarıyıl / 2 yıl)' => 5],
            'varsayilan' => 5,
        ],
        'editorluk' => [
            'tavan' => 100,
            'puanlar' => [
                'WoS / Scopus Dergi' => 30,
                'BKCI Kitap' => 30,
                'TR Dizin Dergi' => 15,
            ],
            'varsayilan' => 15,
        ],
        'toplumsal_katki' => [
            'tavan' => 400,
            'puanlar' => [
                'Uluslararası Patent' => 250,
                'AB/TÜBİTAK Koordinatör' => 150,
                'AB/TÜBİTAK Araştırmacı' => 75,
                'Ulusal Patent' => 50,
                'Kamu Ar-Ge / Danışman' => 50,
                'BAP Yürütücü' => 30,
            ],
            'varsayilan' => 30,
        ],
        'diger' => [
            'tavan' => 100,
            'puanlar' => [
                'Ödül (YÖK/TÜBİTAK/TÜBA)' => 25,
                'Doktora Tez Danışmanlığı' => 20,
                'h-indeksi ≥5 / Yurtdışı Araştırma' => 20,
                'Uluslararası Bildiri (CPCI)' => 10,
                'Yüksek Lisans Tez Danışmanlığı' => 10,
                'Diğer Bildiri' => 8,
            ],
            'varsayilan' => 8,
        ],
    ],

];
