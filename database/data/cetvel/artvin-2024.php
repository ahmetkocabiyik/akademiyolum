<?php

/**
 * ARTVİN ÇORUH ÜNİVERSİTESİ — EK-1 Akademik Faaliyetler Puan Tablosu
 * Kaynak: pdf/17536929712.artvincoruhuniverstesi.pdf
 *
 * TEK ORTAK TABLO, TEMEL ALANA GÖRE AYRI EŞİK. Koşullar tabloya PUAN GRUBU
 * harfiyle atıf yapıyor ("A Puan Grubu kapsamında en az 140 puan", "A, B ve C
 * Puan Gruplarının toplamından 220"), o yüzden harf kodun parçası.
 *
 * A1 ÇEYREKLİĞE GÖRE PUANLANIYOR (Q1 60 · Q2 50 · Q3 40 · Q4 30); satır dört
 * alt maddeye bölündü. Koşullar "A1 kapsamındaki dergiler" dediğinde önek
 * eşleşmesi dördünü birden yakalıyor.
 *
 * YAYIN TÜRÜ ÇARPANI MADDE PUANINA GÖMÜLDÜ: yönerge A1-A3 dergilerinde
 * "derleme ve short/brief communication için puanın YARISI, vaka raporu,
 * teknik not ve editöre mektup için ÜÇTE BİRİ" diyor. Motorda tür bazlı çarpan
 * yok; bu yüzden aynı dergi kademesi için ayrı türde maddeler açılıp puanları
 * önceden bölündü (A1-Q1 60 → derleme 30 → teknik not 20).
 *
 * GRUP TAVANLARI YÖNERGENİN KENDİSİNDEN: bildiriler en fazla 50, kitaplar 80,
 * atıflar 100 puan.
 *
 * GİRİLMEYENLER: C8 ders notu, C9 ansiklopedi madde tanımlaması ve E grubunun
 * proje dışı alt kalemleri ile güzel sanatlar/spor alanlarına özgü satırlar —
 * kaynak sözlüğünde karşılıkları yok.
 */

return [
    'kapsam_notu' => 'Puanlar Artvin Çoruh Üniversitesi EK-1 Akademik Faaliyetler Puan '
        .'Tablosundan. Yönergenin bildiri (50), kitap (80) ve atıf (100) üst sınırları '
        .'uygulanıyor. Ders notu, ansiklopedi madde tanımlaması ve güzel sanatlar/spor alanına '
        .'özgü kalemler kaynak sözlüğünde karşılıksız olduğu için girilmedi; gerçek toplamınız '
        .'burada görünenden yüksek olabilir, düşük olamaz.',

    'maddeler' => [
        // ── A. MAKALELER ── (çeyreklik ve yayın türü puana gömülü)
        'A1-Q1' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI Q1 dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale'], 'puan' => 60],
        'A1-Q2' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI Q2 dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale'], 'puan' => 50],
        'A1-Q3' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI Q3 dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale'], 'puan' => 40],
        'A1-Q4' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI Q4 dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 30],
        // Derleme ve kısa bildirim: aynı dergide puanın yarısı.
        'A1-derleme' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergide derleme veya kısa bildirim', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme', 'kisa_makale'], 'puan' => 15],
        // Vaka, teknik not, editöre mektup: puanın üçte biri.
        'A1-vaka' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergide vaka raporu, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['vaka_teknik_not'], 'puan' => 10],
        'A2' => ['baslik' => 'Diğer uluslararası hakemli veya TR Dizin dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks', 'TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 20],
        'A2-derleme' => ['baslik' => 'Diğer uluslararası hakemli veya TR Dizin dergide derleme, kısa bildirim veya teknik not', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks', 'TR Dizin'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 6],
        'A3' => ['baslik' => 'Diğer yurt içi hakemli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 8],

        // ── B. BİLDİRİLER (en fazla 50 puan) ──
        'B1' => ['baslik' => 'Uluslararası kongrede çağrılı konuşmacı sunumu', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 15],
        'B2' => ['baslik' => 'Uluslararası kongrede sözlü sunulan ve tam metni yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 13],
        'B3' => ['baslik' => 'Uluslararası kongrede sözlü sunulan ve özeti yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 7],
        'B7' => ['baslik' => 'Ulusal kongrede sözlü sunulan ve tam metni yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 8],
        'B8' => ['baslik' => 'Ulusal kongrede sözlü sunulan ve özeti yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 5],

        // ── C. KİTAPLAR (en fazla 80 puan) ──
        'C2' => ['baslik' => 'Uluslararası yayınevi tarafından yabancı dilde yayımlanan özgün kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
        'C3' => ['baslik' => 'Uluslararası yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 12],
        'C4' => ['baslik' => 'Uluslararası yayınevi kitabında çeviri veya editörlük', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap', 'Çeviri Kitap Bölümü'], 'puan' => 7],
        'C5' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanan özgün bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı'], 'puan' => 12],
        'C6' => ['baslik' => 'Ulusal yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 7],
        'C7' => ['baslik' => 'Ansiklopedide bölüm veya derleme yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 5],
        'C10' => ['baslik' => 'Kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Kitap Editörlüğü'], 'puan' => 10],

        // ── D. ATIFLAR (en fazla 100 puan) ──
        'D1' => ['baslik' => 'Uluslararası kitaplarda yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 4],
        'D3' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergilerde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 4],
        'D4' => ['baslik' => 'Diğer uluslararası veya TR Dizin dergilerde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 2],

        // ── E. PROJELER ──
        'E1' => ['baslik' => 'Tamamlanmış uluslararası destekli araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'puan' => 40],
        'E2' => ['baslik' => 'Tamamlanmış TÜBİTAK, TÜSEB veya kamu destekli araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'puan' => 25],
        'E3' => ['baslik' => 'Tamamlanmış üniversite (BAP) destekli araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'puan' => 10],
        'E4' => ['baslik' => 'Patent, faydalı model veya tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent', 'Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili', 'Ticarileştirme'], 'puan' => 30],

        // ── F. TEZ DANIŞMANLIĞI ve EĞİTİM ──
        'F1' => ['baslik' => 'Tamamlanmış lisansüstü tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi', 'Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'puan' => 10],
        'F2' => ['baslik' => 'Verdiğiniz dersler', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi', 'Akreditasyon Faaliyeti'], 'puan' => 4],
        'F3' => ['baslik' => 'Editörlük, yayın kurulu üyeliği veya hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi', 'TR Dizin Dergi', 'Diğer Hakemli Dergi', 'Yayın Kurulu Üyeliği', 'Hakemlik'], 'puan' => 5],
    ],

    'gruplar' => [
        // Koşulların birebir andığı puan grupları.
        'A1' => ['A1-*'],
        'A1-A2' => ['A1-*', 'A2', 'A2-derleme'],
        'A' => ['A1-*', 'A2', 'A2-derleme', 'A3'],
        'B' => ['B*'],
        'C' => ['C*'],
        'D' => ['D*'],
        'E' => ['E*'],
        'A-B-C' => ['A1-*', 'A2', 'A2-derleme', 'A3', 'B*', 'C*'],
        'A-C' => ['A1-*', 'A2', 'A2-derleme', 'A3', 'C*'],
        'A-B-C-D' => ['A1-*', 'A2', 'A2-derleme', 'A3', 'B*', 'C*', 'D*'],
        'A-B-C-D-E' => ['A1-*', 'A2', 'A2-derleme', 'A3', 'B*', 'C*', 'D*', 'E*'],
        'MAKALE' => ['A1-*', 'A2', 'A2-derleme', 'A3'],
    ],

    // Yönergenin kendi üst sınırları.
    'grup_tavanlari' => [
        'B' => 50,
        'C' => 80,
        'D' => 100,
    ],
];
