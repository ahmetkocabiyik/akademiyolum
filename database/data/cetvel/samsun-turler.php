<?php

/**
 * Samsun Üniversitesi — "Başlıca Çalışma" türleri (MADDE 5)
 * Kaynak: pdf/17537007522.samsununiverstesi.pdf
 *
 * PUANSIZ CETVEL. Samsun'un yönergesinde puan tablosu yok; şartlar tamamen
 * "en az N adet şu türden çalışma" biçiminde. Bu dosya bir puan cetveli değil,
 * tür sözlüğü: madde kodları yönergenin kendi A1/B2/D3 etiketleri, `puan`
 * anahtarı bilinçli olarak yok (motor 0 sayar, zaten hiçbir koşul puana bakmıyor).
 *
 * TANINMIŞ YAYINEVİ AYRIMI KAPSAM ETİKETİNE BAĞLANDI (19.09.2026): sıfat iki
 * kademede de aynı, ayrımı yapan tek şey yayınevinin kapsamı. Kapsamlı
 * etiketler üst satırlara bağlandı, ulusal satırlar daraltıldı.
 *
 * B1 GENEL etiketi taşıdığı için adayın ULUSAL yayınevi kitabı da uluslararası
 * satırdan sayılıyordu; B3'te (tanınmış ulusal kitap) yalnız tahkik vardı.
 * Samsun ADET sayan bir yönerge, yani yanlış kademe yanlış KOŞULU sağlıyordu.
 */

return [
    'kapsam_notu' => 'Bu cetvel PUANSIZ: Samsun Üniversitesi yönergesi puan tablosu değil, "en az N adet şu türden '
        .'çalışma" biçiminde koşullar veriyor; satırlar yalnızca hangi kaydın hangi türe girdiğini '
        .'belirler. KİTAPTA "TANINMIŞ YAYINEVİ" KOŞULU DENETLENMİYOR: uluslararası yayınevi kitabınız '
        .'B1 türünden sayılıyor, yayıneviniz yönergenin tanımına girmiyorsa koşulu olduğundan KOLAY '
        .'sağlamış görünürsünüz; başvurunuzda yayınevini belgeleyin.',

    'maddeler' => [
        // A Türü — makale
        'A1' => ['baslik' => 'SCI/SCIE/SSCI/AHCI dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI']],
        'A2' => ['baslik' => 'ÜAK alan indeksi, ESCI veya SCOPUS dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus']],
        'A3' => ['baslik' => 'ULAKBİM (TR Dizin) dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin']],
        'A4' => ['baslik' => 'Diğer uluslararası hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli']],

        // B Türü — kitap
        'B1' => ['baslik' => 'Tanınmış uluslararası yayınevi kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası Kitap']],
        'B2' => ['baslik' => 'Tanınmış uluslararası yayınevi kitap bölümü', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Uluslararası Kitap Bölümü']],
        'B3' => ['baslik' => 'Tanınmış ulusal yayınevi kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Tahkik (Tenkitli Metin)', 'Ulusal Kitap']],
        'B4' => ['baslik' => 'Tanınmış ulusal yayınevi kitap bölümü', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap Bölümü', 'Çeviri Kitap', 'Çeviri Kitap Bölümü', 'Ansiklopedi Maddesi']],

        // C Türü — bildiri
        'C1' => ['baslik' => 'Uluslararası kongrede tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin', 'Davetli Konuşmacı']],
        'C2' => ['baslik' => 'Ulusal kongrede tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin']],

        // D Türü — proje
        'D1' => ['baslik' => 'AB Çerçeve / uluslararası ikili iş birliği projesi', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk']],
        'D2' => ['baslik' => 'Diğer uluslararası kuruluş projesi', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon']],
        'D3' => ['baslik' => 'TÜBİTAK ARDEB projesi', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK']],
        'D4' => ['baslik' => 'TÜBİTAK TEYDEB projesi', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK']],
        'D5' => ['baslik' => 'TÜSEB projesi', 'kategori' => 'proje', 'kaynaklar' => ['TÜSEB']],
        'D6' => ['baslik' => 'Diğer kamu kurumu projesi', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu']],

        // E Türü — patent / tasarım
        'E1' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent']],
        'E2' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent']],
        'E3' => ['baslik' => 'Faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model']],
        'E4' => ['baslik' => 'Endüstriyel/çevresel/grafiksel tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili', 'Ticarileştirme']],

        // G Türü — ödül / danışmanlık
        'G1' => ['baslik' => 'Uluslararası bilim/hizmet ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü']],
        'G2' => ['baslik' => 'TÜBİTAK veya TÜBA bilim/hizmet ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü']],
        'G3' => ['baslik' => 'Yarışmada ilk üç — akademik danışmanlık', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon', 'Ulusal Bilim/Sanat Ödülü', 'Burs']],
    ],

    'gruplar' => [
        'HEPSI' => ['*'],
        'A' => ['A*'],
        'A1-A2' => ['A1', 'A2'],
        'A1-A3' => ['A1', 'A2', 'A3'],
        'D1-D3-D5' => ['D1', 'D3', 'D5'],
        'D1-D3-D4-D5' => ['D1', 'D3', 'D4', 'D5'],
        'D1-D3-D4' => ['D1', 'D3', 'D4'],
        'A1-A4' => ['A1', 'A2', 'A3', 'A4'],
        // Mimarlık yeniden atanmasının saydığı geniş küme (G4/G5 cetvelde yok).
        'MIMARLIK-YENIDEN' => ['A1', 'A2', 'A3', 'A4', 'B1', 'B2', 'B3', 'B4', 'D1', 'D3', 'D5', 'E1', 'E2', 'E4', 'G1', 'G2', 'G3'],
    ],
];
