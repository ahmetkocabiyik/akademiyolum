<?php

/**
 * GAZİANTEP İSLAM BİLİM VE TEKNOLOJİ ÜNİVERSİTESİ — Kategoriler ve Puanlama
 * Tablosu
 * Kaynak: pdf/17536994372.gaziantepislambilimveteknolojiuniverstesi.pdf
 *
 * Gaziantep Üniversitesi'nden AYRI bir üniversite (cetvel/gaziantep-2026.php
 * ile karıştırılmamalı).
 *
 * TEK ORTAK PUAN TABLOSU, BEŞ TEMEL ALAN İÇİN AYRI EŞİK. Koşullar tabloya
 * madde numarasıyla atıf yapıyor: "1.a veya 1.b maddelerinden en az 20",
 * "4, 5, 6 numaralı maddelerden en az 10", "genel toplamda en az 60".
 *
 * ARAŞTIRMA MAKALESİ İLE DİĞER MAKALE AYRI BÖLÜMDE: 1. bölüm araştırma
 * makalelerini (teknik not, olgu sunumu, editöre mektup hariç), 2. bölüm bu
 * hariç tutulan türleri puanlıyor. `turler` boyutu tam bunun için var.
 *
 * GİRİLMEYEN: sanatsal etkinlik bölümleri (22-36 arası; tiyatro, opera, bale,
 * kompozisyon, müzik teknolojisi, film), burslar, jüri üyelikleri ve proje
 * değerlendirme panelleri — kaynak sözlüğünde karşılıkları yok. Koşullar
 * yalnızca 1, 4, 5, 6 numaralı bölümlere ve genel toplama atıf yaptığı için
 * eksik bölümler yalnızca genel toplamı düşürüyor.
 */

return [
    'kapsam_notu' => 'Puanlar Gaziantep İslam Bilim ve Teknoloji Üniversitesi Kategoriler ve '
        .'Puanlama Tablosundan. Sanatsal etkinlik, burs, jüri üyeliği ve proje değerlendirme '
        .'panelleri bölümlerinin kaynak sözlüğünde karşılığı olmadığı için girilmedi; genel '
        .'toplamınız burada görünenden yüksek olabilir, düşük olamaz.',

    'maddeler' => [
        // ── 1. ARAŞTIRMA MAKALELERİ ──
        '1.a' => ['baslik' => 'SSCI, AHCI, SCI veya SCI-E endeksli hakemli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 40],
        '1.b' => ['baslik' => 'E-SCI endeksli hakemli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 30],
        '1.c' => ['baslik' => 'Alan endeksli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 25],
        '1.d' => ['baslik' => 'ULAKBİM TR Dizin ulusal hakemli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 20],
        '1.f' => ['baslik' => 'Ulusal hakemli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 15],

        // ── 2. DİĞER MAKALELER (teknik not, olgu sunumu, editöre mektup…) ──
        '2.a' => ['baslik' => 'SSCI, AHCI, SCI veya SCI-E endeksli dergide teknik not, olgu sunumu veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 20],
        '2.b' => ['baslik' => 'E-SCI endeksli dergide teknik not, olgu sunumu veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 15],
        '2.d' => ['baslik' => 'TR Dizin dergide teknik not, olgu sunumu veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 10],

        // ── 3. ATIFLAR ──
        '3.a' => ['baslik' => 'SSCI, SCI, SCI-E veya AHCI dergilerdeki yayınlarda yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 2],
        '3.b' => ['baslik' => 'Kitaplarda yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap', 'TR Dizin', 'Diğer', 'Patent'], 'puan' => 2],

        // ── 4. KİTAPLAR ──
        '4.a' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanan ISBN\'li kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 50],
        '4.b' => ['baslik' => 'Uluslararası yayınevi kitabında bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 15],
        '4.c' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanan ISBN\'li kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 30],
        '4.d' => ['baslik' => 'Ulusal yayınevi kitabında bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 10],

        // ── 5. DİĞER KİTAPLAR ──
        '5.a' => ['baslik' => 'Lisansüstü tezden üretilmiş kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı', 'Ansiklopedi Maddesi'], 'puan' => 25],
        '5.b' => ['baslik' => 'Çeviri kitap veya kitap bölümü', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap', 'Çeviri Kitap Bölümü'], 'puan' => 8],

        // ── 6. BİLDİRİLER ──
        '6.a' => ['baslik' => 'Uluslararası bilim kurulu olan hakemli etkinlikte bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin', 'Uluslararası Özet/Poster', 'Davetli Konuşmacı'], 'puan' => 15],
        '6.b' => ['baslik' => 'Ulusal bilim kurulu olan hakemli etkinlikte bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin', 'Ulusal Özet/Poster'], 'puan' => 10],

        // ── 7. BİLİMSEL PROJELER ──
        '7.a' => ['baslik' => 'Uluslararası destekli bilimsel projede görev', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'puan' => 20],
        '7.b' => ['baslik' => 'TÜBİTAK, TÜSEB veya kamu destekli bilimsel projede görev', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'puan' => 20],
        '7.c' => ['baslik' => 'Üniversite (BAP) destekli bilimsel projede görev', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'puan' => 20],

        // ── 8. EDİTÖRLÜK ve YAYIN KURULU ──
        '8.a' => ['baslik' => 'Uluslararası yayınevi kitabında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 25],
        '8.b' => ['baslik' => 'Ulusal yayınevi kitabında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 15],
        '8.i' => ['baslik' => 'SSCI, AHCI, SCI veya SCI-E endeksli dergide editörlük veya yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 20],
        '8.j' => ['baslik' => 'Diğer dergilerde editörlük veya yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi', 'TR Dizin Dergi', 'Diğer Hakemli Dergi', 'Yayın Kurulu Üyeliği'], 'puan' => 15],
        '9.a' => ['baslik' => 'Hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 2],

        // ── 10. PATENT ──
        '10.a' => ['baslik' => 'Uluslararası patent (incelemeli)', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 40],
        '10.b' => ['baslik' => 'Ulusal patent (incelemeli)', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 30],
        '10.c' => ['baslik' => 'Faydalı model veya tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım'], 'puan' => 12],

        // ── 12. EĞİTİME KATKI ──
        '12.a' => ['baslik' => 'Yönettiği tamamlanmış lisansüstü tez', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi', 'Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'puan' => 15],
        '12.b' => ['baslik' => 'Normal ders yükü dışında verilen ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi', 'Akreditasyon Faaliyeti'], 'puan' => 1],
    ],

    'gruplar' => [
        // Koşulların birebir andığı kümeler.
        '1.a-1.b' => ['1.a', '1.b'],
        '1' => ['1.*'],
        '4-5-6' => ['4.*', '5.*', '6.*'],
        'MAKALE' => ['1.*', '2.*'],
    ],

    'grup_tavanlari' => [],
];
