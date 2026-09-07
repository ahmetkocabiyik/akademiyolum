<?php

/**
 * YILDIZ TEKNİK ÜNİVERSİTESİ — EK-1 Puanlama Tablosu
 * Kaynak: pdf/17537010672.yildizteknikuniverstesi.pdf (Rev. 24.03.2021)
 *
 * MADDE KODLARI yönergenin kendi numaralandırmasıdır; EK-2 asgari puan
 * tablosu doğrudan bunlara atıf yapıyor ("1(a)", "1(a,b,c)", "4(a,b,c)").
 *
 * MAKALEDE ÇEYREKLİK KIRILIMI DÖRT DEĞİL ÜÇ + BİR: a-1/a-2/a-3 sırasıyla
 * Q1/Q2/Q3, Q4 ise AYRI bir bende (b) düşüyor ve ESCI ile aynı puanı alıyor.
 * Bu yüzden 1(a) kümesi Q1-Q3'ü kapsar, Q4'ü kapsamaz — EK-2'nin "1(a)"
 * satırıyla "1(a,b,c)" satırı arasındaki fark tam olarak budur.
 *
 * GİRİLMEYEN BÖLÜMLER: 10 (editörlük/hakemlik), 13 ve 14 (sanat-tasarım
 * temel alanına özgü kalemler) — EK-2'de yalnızca azami sınırla anılıyorlar,
 * asgari koşul üretmiyorlar.
 */

return [
    'kapsam_notu' => 'Puanlar Yıldız Teknik Üniversitesi EK-1 tablosundan. Editörlük ve '
        .'sanat-tasarım alanına özgü kalemler girilmedi; onlar yönergede yalnızca azami '
        .'sınır taşıyor. Gerçek toplamınız burada görünenden yüksek olabilir, düşük olamaz.',

    'maddeler' => [
        // ── 1. MAKALELER ── (tam araştırma makalesi; editöre mektup, özet,
        // teknik not ve kitap kritiği hariç → `turler` ile sınırlandı)
        '1a-1' => ['baslik' => 'SCI/SCI-E/SSCI/AHCI Q1 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 35],
        '1a-2' => ['baslik' => 'SCI/SCI-E/SSCI/AHCI Q2 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 30],
        '1a-3' => ['baslik' => 'SCI/SCI-E/SSCI/AHCI Q3 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 15],
        '1b' => ['baslik' => 'ESCI veya Q4 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 12],
        '1c' => ['baslik' => 'ÜAK ve YTÜ senatosunca belirlenen uluslararası alan indeksli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 10],
        '1d' => ['baslik' => 'Diğer uluslararası hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 8],
        '1e' => ['baslik' => 'ULAKBİM taranan ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 8],
        '1f' => ['baslik' => 'Diğer ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 4],

        // ── 2. KİTAPLAR ──
        '2a' => ['baslik' => 'Uluslararası yayınevinden özgün kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
        '2c' => ['baslik' => 'Ulusal yayınevinden özgün kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 15],
        '2e' => ['baslik' => 'Çeviri kitap, kitap bölümü çevirisi veya kitap bölümü', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap', 'Çeviri Kitap Bölümü', 'Kitap Bölümü', 'BKCI / Scopus Kitap Bölümü'], 'puan' => 8],
        '2b' => ['baslik' => 'Uluslararası yayınevinden özgün kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 10],
        '2d' => ['baslik' => 'Ulusal yayınevinden özgün kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 8],

        // ── 3. PATENT / TASARIM ──
        '3a' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 35],
        '3b' => ['baslik' => 'Ulusal patent (incelemeli)', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 20],
        '3d' => ['baslik' => 'Faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 6],
        '3e' => ['baslik' => 'Endüstriyel tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım'], 'puan' => 3],
        '3g' => ['baslik' => 'Patent lisanslama', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 10],
        '3h' => ['baslik' => 'Teknoloji geliştirme bölgesinde şirket sahibi olmak', 'kategori' => 'patent', 'kaynaklar' => ['Yazılım'], 'puan' => 10],

        // ── 4. ATIFLAR ──
        '4a' => ['baslik' => 'SCI/SCI-E/SSCI/AHCI dergilerde ve uluslararası kitaplarda atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 3],
        '4b' => ['baslik' => 'SCI/SCI-E/SSCI/AHCI dışındaki endekslerde atıf', 'kategori' => 'atif', 'kaynaklar' => ['Patent'], 'puan' => 2],
        '4c' => ['baslik' => 'Ulusal hakemli dergilerde ve ulusal kitaplarda atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer'], 'puan' => 1],

        // ── 5. LİSANSÜSTÜ TEZ DANIŞMANLIĞI ──
        '5a' => ['baslik' => 'Tamamlanmış doktora tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 6],
        '5b' => ['baslik' => 'Tamamlanmış yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 3],
        '5c' => ['baslik' => 'Doktora tezi eş danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 3],
        '5d' => ['baslik' => 'Yüksek lisans tezi eş danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 2],

        // ── 6. PROJELER ──
        '6a' => ['baslik' => 'Tamamlanmış AB çerçeve programı projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 50],
        '6b' => ['baslik' => 'Tamamlanmış AB çerçeve programı projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 40],
        '6c' => ['baslik' => 'Diğer uluslararası destekli projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 40],
        '6d' => ['baslik' => 'Diğer uluslararası destekli projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 25],
        '6f' => ['baslik' => 'TÜBİTAK Ar-Ge projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 30],
        '6g' => ['baslik' => 'TÜBİTAK Ar-Ge projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'danisman'], 'puan' => 15],
        '6h' => ['baslik' => 'TÜBİTAK Ar-Ge projesinde bursiyer', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['bursiyer'], 'puan' => 5],
        '6i' => ['baslik' => 'Diğer TÜBİTAK projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu', 'danisman'], 'puan' => 10],
        '6k' => ['baslik' => 'Üniversite dışı kamu kurumu projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 20],
        '6l' => ['baslik' => 'Üniversite dışı kamu kurumu projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
        '6m' => ['baslik' => 'Üniversite BAP projesi', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'puan' => 10],

        // ── 7. BİLİMSEL TOPLANTI FAALİYETLERİ ──
        // Bölümün TAMAMI girilmemişti; başlıktaki "girilmeyen bölümler"
        // listesinde de anılmıyor, yani gözden kaçmış. Bildiri etiketlerinin
        // hiçbirinin karşılığı yoktu.
        //
        // Kaynak üç kolonda kademelendiriyor (tam metin 3 · özet 2 · poster
        // 2 uluslararası; 2 · 1 · 1 ulusal). `Özet/Poster` etiketi hem özet
        // hem poster satırını taşıdığı için ikisinin en düşüğünü alır.
        '7a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan, tam metni bildiri kitapçığında yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 3],
        '7b-7c' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan, özeti yayımlanmış ya da poster olarak sunulmuş çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 2],
        '7d' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan, tam metni bildiri kitapçığında yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 2],
        '7e-7f' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan, özeti yayımlanmış ya da poster olarak sunulmuş çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 1],
        '7g' => ['baslik' => 'Uluslararası kongre, konferans ya da sempozyumun organizasyon veya yürütme komitesinde görev almak', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 2],
        '7h' => ['baslik' => 'Ulusal kongre, konferans ya da sempozyumun organizasyon veya yürütme komitesinde görev almak', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Ulusal)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 1],

        // ── 8. EĞİTİM-ÖĞRETİM ──
        '8a' => ['baslik' => 'Lisansüstü ders (İngilizce)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Yabancı Dilde Ders'], 'puan' => 6],
        '8b' => ['baslik' => 'Lisansüstü ders (Türkçe)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
        '8c' => ['baslik' => 'Lisans dersi (İngilizce)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Değişim Programı Dersi'], 'puan' => 4],
        '8d' => ['baslik' => 'Lisans dersi (Türkçe)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders'], 'puan' => 2],
    ],

    'gruplar' => [
        // EK-2 asgari puan tablosunun birebir kullandığı atıflar.
        // 1(a) yalnızca Q1-Q3; Q4 yönergede ayrı bende (b) düşüyor.
        '1(a)' => ['1a-1', '1a-2', '1a-3'],
        '1(a,b,c)' => ['1a-1', '1a-2', '1a-3', '1b', '1c'],
        '4(a,b,c)' => ['4a', '4b', '4c'],
        '5(a,b)' => ['5a', '5b'],
        '6' => ['6*'],
        '8(a,b,c,d)' => ['8a', '8b', '8c', '8d'],
        'MAKALE' => ['1*'],
        'KITAP' => ['2*'],
    ],

    'grup_tavanlari' => [
        // EK-2'nin "Azami" sütunundan: doçent ve profesörde aynı sınırlar.
        '4(a,b,c)' => 60,
        '8(a,b,c,d)' => 30,
    ],
];
