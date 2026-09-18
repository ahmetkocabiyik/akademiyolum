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
        '1.b' => ['baslik' => 'E-SCI endeksli hakemli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 30],
        '1.c' => ['baslik' => 'Alan endeksli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 25],
        '1.d' => ['baslik' => 'ULAKBİM TR Dizin ulusal hakemli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 20],
        '1.f' => ['baslik' => 'Ulusal hakemli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 15],

        // ── 2. DİĞER MAKALELER (teknik not, olgu sunumu, editöre mektup…) ──
        '2.a' => ['baslik' => 'SSCI, AHCI, SCI veya SCI-E endeksli dergide teknik not, olgu sunumu veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 20],
        '2.b' => ['baslik' => 'E-SCI endeksli dergide teknik not, olgu sunumu veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['ESCI'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 15],
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
        // SÖZLÜ/POSTER ekseni sözlükte YOK. Etiket çifti şöyle bölüşüyor:
        // `Tam Metin` = SÖZLÜ sunulup tam metni basılan bildiri;
        // `Özet/Poster` = özet basılanlar ile POSTER'lerin tamamı (poster
        // adı ikinci etikette geçiyor). Bu yüzden `Özet/Poster` satırı,
        // kaynağın özet ve poster hücrelerinin EN DÜŞÜĞÜNÜ alır.
        // GİBTÜ: uluslararası sözlü 15/10 · poster 10/8 → özet/poster 8;
        // ulusal sözlü 10/8 · poster 8/5 → özet/poster 5. Önce dört kolonun
        // tamamı tek satıra (uluslararası 15, ulusal 10) çökmüştü.
        // Davetli konuşmacı etiketi kapsam taşımıyor; kaynak uluslararası 15,
        // ulusal 10, STK/bakanlık etkinliği 2 diyor → 2.
        '6.a' => ['baslik' => 'Uluslararası bilim kurulu olan hakemli etkinlikte sunulmuş, tam metni basılmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 15],
        '6.a2' => ['baslik' => 'Uluslararası bilim kurulu olan hakemli etkinlikte sunulmuş, özeti basılmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 8],
        '6.b' => ['baslik' => 'Ulusal bilim kurulu olan hakemli etkinlikte sunulmuş, tam metni basılmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 10],
        '6.b2' => ['baslik' => 'Ulusal bilim kurulu olan hakemli etkinlikte sunulmuş, özeti basılmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 5],
        '6.davetli' => ['baslik' => 'Bilimsel ya da sanatsal etkinlikte belgelendirilmiş davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 2],

        // ── 7. BİLİMSEL PROJELER ──
        // 7. maddenin altı fon kademesi ve her kademede iki rol var; cetvelde
        // üçü de tek 20 puanlık satırdaydı (01.09.2026'da açıldı).
        '7.a.yon' => ['baslik' => 'Uluslararası fonlarca desteklenen projede koordinatörlük ya da yöneticilik', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 50],
        '7.a.ara' => ['baslik' => 'Uluslararası fonlarca desteklenen projede araştırmacılık ya da danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 30],
        '7.b.yon' => ['baslik' => 'TÜBİTAK ya da ulusal fon destekli Ar-Ge projesinde koordinatörlük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 40],
        '7.b.ara' => ['baslik' => 'TÜBİTAK ya da ulusal fon destekli Ar-Ge projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
        '7.c.yon' => ['baslik' => 'SAN-TEZ, KOSGEB, kalkınma ajansı ya da bakanlık destekli projede koordinatörlük', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 30],
        '7.c.ara' => ['baslik' => 'SAN-TEZ, KOSGEB, kalkınma ajansı ya da bakanlık destekli projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],
        // 7.d (BAP, 20/15) ile 7.e (lisansüstü tez BAP, 10/5) tek etikete
        // düşüyor; §0 uyarınca 7.e'den.
        '7.e.yon' => ['baslik' => 'Üniversite (BAP) destekli projede yöneticilik', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 10],
        '7.e.ara' => ['baslik' => 'Üniversite (BAP) destekli projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 5],
        // 7.f KAYNAKTA KENDİYLE ÇELİŞİYOR: satır metni "koordinatör 20, araştırmacı
        // 15" derken sağdaki puan sütunu "(10-15)" diyor. §0 uyarınca her rol için
        // iki okumanın DÜŞÜĞÜ alındı; bu, araştırmacıyı yöneticiden yüksek bırakıyor
        // ama kaynaktaki hata düzeltilmeden kaydediliyor.
        '7.f.yon' => ['baslik' => 'Diğer kamu ya da özel kurum destekli Ar-Ge projesinde koordinatörlük', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 10],
        '7.f.ara' => ['baslik' => 'Diğer kamu ya da özel kurum destekli Ar-Ge projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],

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
        '12.b' => ['baslik' => 'Normal ders yükü dışında verilen ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 1],
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
