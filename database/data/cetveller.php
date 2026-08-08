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
        // NOT: Bu düz cetvel (kaynak → puan) rolü ifade edemiyor; proje puanları
        // yürütücülük değeriyle değil, ADAYIN LEHİNE OLMAYAN düşük değerle
        // (araştırmacı) girildi ki Dashboard önizlemesi puanı şişirmesin.
        // Rol ayrımını yapan cetvel: cetveller-agac.php.
        'proje' => [
            'tavan' => 300,
            'puanlar' => [
                'AB Çerçeve / Ufuk' => 100,
                'Diğer Uluslararası Fon' => 100,
                'TÜBİTAK' => 100,
                'TÜSEB' => 100,
                'Diğer Kamu Kurumu' => 60,
                'Özel Sektör / STK' => 60,
                'BAP (Üniversite)' => 40,
                'Öğrenci Projesi (2209 vb.)' => 20,
            ],
            'varsayilan' => 40,
        ],
        'patent' => [
            'tavan' => 300,
            'puanlar' => [
                'Uluslararası Patent' => 140,
                'Ulusal Patent' => 115,
                'Faydalı Model' => 60,
                'Endüstriyel Tasarım' => 60,
                'Yazılım' => 60,
                'Islahçı Hakkı / Çeşit Tescili' => 60,
                'Ticarileştirme' => 100,
            ],
            'varsayilan' => 60,
        ],
        'tez_danismanligi' => [
            'tavan' => 100,
            'puanlar' => [
                'Doktora Tezi' => 25,
                'Tıpta/Diş/Sanatta Yeterlik Tezi' => 25,
                'Yüksek Lisans Tezi' => 10,
                'Tez İzleme / Jüri Üyeliği' => 5,
            ],
            'varsayilan' => 10,
        ],
        'bildiri' => [
            'tavan' => 100,
            'puanlar' => [
                'Uluslararası Tam Metin (CPCI)' => 10,
                'Uluslararası Tam Metin' => 10,
                'Uluslararası Özet/Poster' => 5,
                'Ulusal Tam Metin' => 8,
                'Ulusal Özet/Poster' => 4,
                'Davetli Konuşmacı' => 10,
            ],
            'varsayilan' => 8,
        ],
        'odul' => [
            'tavan' => 100,
            'puanlar' => [
                'Uluslararası Bilim/Sanat Ödülü' => 25,
                'TÜBİTAK / TÜBA Ödülü' => 25,
                'Ulusal Bilim/Sanat Ödülü' => 15,
                'Yarışma Derecesi / Mansiyon' => 10,
                'Burs' => 10,
            ],
            'varsayilan' => 10,
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
        // Ek-1, 6. Bölüm. Düz cetvel rolü ifade edemediği için araştırıcı değeri
        // girildi (yürütücülük daha yüksek); rol ayrımı cetveller-agac.php'de.
        'proje' => [
            'tavan' => 400,
            'puanlar' => [
                'AB Çerçeve / Ufuk' => 50,
                'Diğer Uluslararası Fon' => 50,
                'TÜBİTAK' => 15,
                'TÜSEB' => 15,
                'Diğer Kamu Kurumu' => 15,
                'Özel Sektör / STK' => 15,
                'BAP (Üniversite)' => 5,
                'Öğrenci Projesi (2209 vb.)' => 5,
            ],
            'varsayilan' => 5,
        ],
        // Ek-1, 4. Bölüm: Patent ve Girişimcilik.
        'patent' => [
            'tavan' => 400,
            'puanlar' => [
                'Uluslararası Patent' => 250,
                'Islahçı Hakkı / Çeşit Tescili' => 200,
                'Ulusal Patent' => 50,
                'Endüstriyel Tasarım' => 30,
                'Yazılım' => 30,
                'Ticarileştirme' => 30,
                'Faydalı Model' => 25,
            ],
            'varsayilan' => 25,
        ],
        // Ek-1, 5. Bölüm: Lisansüstü Tez Danışmanlığı.
        'tez_danismanligi' => [
            'tavan' => 100,
            'puanlar' => [
                'Doktora Tezi' => 15,
                'Tıpta/Diş/Sanatta Yeterlik Tezi' => 10,
                'Yüksek Lisans Tezi' => 7,
                'Tez İzleme / Jüri Üyeliği' => 3,
            ],
            'varsayilan' => 7,
        ],
        // Ek-1, 7. Bölüm: Bilimsel Toplantı Faaliyeti.
        'bildiri' => [
            'tavan' => 100,
            'puanlar' => [
                'Uluslararası Tam Metin (CPCI)' => 8,
                'Uluslararası Tam Metin' => 4,
                'Davetli Konuşmacı' => 4,
                'Uluslararası Özet/Poster' => 2,
                'Ulusal Tam Metin' => 2,
                'Ulusal Özet/Poster' => 1,
            ],
            'varsayilan' => 2,
        ],
        // Ek-1, 9. Bölüm: Uluslararasılaşma Faaliyetleri ve Ödüller.
        'odul' => [
            'tavan' => 100,
            'puanlar' => [
                'Uluslararası Bilim/Sanat Ödülü' => 25,
                'TÜBİTAK / TÜBA Ödülü' => 25,
                'Ulusal Bilim/Sanat Ödülü' => 15,
                'Yarışma Derecesi / Mansiyon' => 10,
                'Burs' => 10,
            ],
            'varsayilan' => 10,
        ],
    ],

];
