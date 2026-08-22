<?php

/**
 * Ege Üniversitesi — "Değerlendirmede Dikkate Alınacak Faaliyetlerin Türü ve
 * Puanlama Çizelgesi" (01.01.2026'dan itibaren yürürlükte)
 *
 * Kaynak: pdf/1768554344259.ege-kriter-16012026.pdf
 *
 * MADDE KODLARI yönergenin kendi numaralandırmasıdır ve zorunlu koşullar
 * doğrudan bunlara atıf yapıyor: "1 (a) maddesinden Q1 veya Q2 kategorisinden
 * en az birinde başlıca yazar olmak koşulu ile beş yayını olmak" (md. 11.8).
 * Bu yüzden çeyreklik kırılımı koda taşındı: `1a-Q1`, `1a-Q2` …
 *
 * ÇEYREKLİK HER SATIRDA AYRI PUAN: yönerge yalnızca özgün makaleyi değil
 * derlemeyi, editöre mektubu ve dergi editörlüğünü de Q1-Q4 diye ayırıyor.
 *
 * OKUNMAYAN BÖLÜMLER (bilinçli):
 *   · 8, 9 — ödüller ve patent; kaynak sözlüğünde karşılığı olan kalemler
 *     girildi, geri kalanı (kazı ruhsatı, hafızlık icazeti, sportif hakemlik
 *     gibi alana özgü kalemler) modellenmiyor.
 *   · 10.1-10.4 — arkeoloji, ilahiyat, spor ve sanat alanlarına özgü uzun
 *     listeler. 10.4 (k, l) güzel sanatlar koşullarında anılıyor; ikisi
 *     girildi, kalanı girilmedi.
 *   Bu bölümler yalnızca TOPLAM puana katkı sağlar, zorunlu koşulların
 *   sayısal kısmına girmez; hesaplanan toplam bu kadar EKSİK kalabilir.
 */

return [
    'kapsam_notu' => 'Puanlar Ege Üniversitesi 2026 çizelgesinden. Arkeoloji kazıları, sportif '
        .'hakemlik, hafızlık icazeti gibi alana özgü kalemler ile bazı ödül türleri kaynak '
        .'sözlüğünde karşılığı olmadığı için hesaba katılmadı; gerçek toplamınız burada '
        .'görünenden yüksek olabilir, düşük olamaz.',

    'maddeler' => [
        // ── 1. MAKALE ──
        '1a-Q1' => ['baslik' => 'SCIE/SSCI/AHCI Q1 dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'puan' => 75],
        '1a-Q2' => ['baslik' => 'SCIE/SSCI/AHCI Q2 dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'puan' => 60],
        '1a-Q3' => ['baslik' => 'SCIE/SSCI/AHCI Q3 dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'puan' => 40],
        '1a-Q4' => ['baslik' => 'SCIE/SSCI/AHCI Q4 dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'puan' => 30],

        // 1b (derleme) ve 1c (editöre mektup) da çeyrekliğe göre ayrı puanlı
        // ama GİRİLMEDİ: sözlükte "derleme" ile "özgün araştırma makalesi" ayrı
        // etiket değil, ikisi de 'SCIE/SSCI (Q1)' etiketine düşer. Aynı etiketi
        // ikinci kez vermek `puan()` en yükseği aldığı için hiçbir şeyi
        // değiştirmez; girseydik kapsanmış gibi görünürdü.
        '1d' => ['baslik' => 'Diğer uluslararası alan indeksli dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 20],
        '1e' => ['baslik' => 'Diğer uluslararası alan indeksli dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'puan' => 10],
        '1g1' => ['baslik' => 'ULAKBİM taranan ulusal dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 10],
        '1g3' => ['baslik' => 'Ulusal dergide editöre mektup, olgu sunumu, teknik not', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 3],

        // ── 2. BİLİMSEL TOPLANTI (BİLDİRİ) ──
        // "8/4" = tam metin / özet. Sözlükte ikisi ayrı etiket olduğu için
        // yönergenin ikili değeri iki maddeye açıldı.
        '2a' => ['baslik' => 'Uluslararası toplantıda davetli konuşmacı', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 15],
        '2b' => ['baslik' => 'Uluslararası toplantıda sözlü bildiri (tam metin)', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 8],
        '2c' => ['baslik' => 'Uluslararası toplantıda poster bildiri (özet)', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 5],
        '2e' => ['baslik' => 'Ulusal toplantıda sözlü bildiri (tam metin)', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 6],
        '2f' => ['baslik' => 'Ulusal toplantıda poster bildiri (özet)', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 4],

        // ── 3. KİTAP ──
        '3a1' => ['baslik' => 'Uluslararası tanınırlığı olan yayınevinden yabancı dilde kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 75],
        '3a2' => ['baslik' => 'Uluslararası tanınırlığı olan yayınevinden Türkçe kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 40],
        '3b1' => ['baslik' => 'Uluslararası tanınırlığı olan yayınevinden yabancı dilde kitap bölümü', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 20],
        '3b2' => ['baslik' => 'Uluslararası tanınırlığı olan yayınevinden Türkçe kitap bölümü', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 10],
        // 3d (ulusal yayınevi kitabı, 30) ve 3e (ulusal yayınevi kitap bölümü,
        // 10) GİRİLMEDİ: sözlükte uluslararası/ulusal yayınevi ayrımı için ayrı
        // etiket kalmadı, 3a2 ile 3b2 zaten o etiketleri tutuyor. Uydurma bir
        // etikete (ör. "Tahkik") bağlamak kalemi yanlış yere sayardı.
        '3g' => ['baslik' => 'Yabancı dilde yayımlanan bilimsel kitap çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 20],
        '3h' => ['baslik' => 'Yabancı dilde yayımlanan bilimsel kitap bölümü çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 10],

        // c1/c2/f (kitap editörlüğü) editörlük kategorisinde:
        '3c1' => ['baslik' => 'Uluslararası yayınevinde yabancı dilde kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 30],
        '3f' => ['baslik' => 'Ulusal yayınevinde kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 15],

        // ── 4. ATIF ──
        '4a' => ['baslik' => 'SCIE/SSCI/AHCI dergilerde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 2],
        '4c' => ['baslik' => 'ULAKBİM taranan ulusal dergilerde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 1],
        '4d' => ['baslik' => 'Kitaplarda yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 1],
        '4e' => ['baslik' => 'İncelemeli patent atıfları', 'kategori' => 'atif', 'kaynaklar' => ['Patent'], 'puan' => 2],

        // ── 5. BİLİMSEL ARAŞTIRMA PROJESİ ──
        '5a1' => ['baslik' => 'Uluslararası dış kaynaklı projede koordinatör/yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 80],
        '5a3' => ['baslik' => 'Uluslararası dış kaynaklı projede araştırıcı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 50],
        '5a4' => ['baslik' => 'Uluslararası dış kaynaklı projede danışman', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['danisman'], 'puan' => 30],
        '5b1' => ['baslik' => 'Ulusal dış kaynaklı projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 60],
        '5b2' => ['baslik' => 'Ulusal dış kaynaklı projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci'], 'puan' => 35],
        '5b3' => ['baslik' => 'Ulusal dış kaynaklı projede danışman', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['danisman'], 'puan' => 15],
        '5b4' => ['baslik' => 'Ulusal dış kaynaklı projede bursiyer/uzman', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['bursiyer'], 'puan' => 10],
        '5c' => ['baslik' => 'Öğrenci TÜBİTAK projesinde danışman (en çok 6 proje)', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'roller' => ['danisman'], 'puan' => 5],
        '5e1' => ['baslik' => 'BAP-ÖNAP/ADP/GDM/ÜAP/UİP projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 40],
        '5e2' => ['baslik' => 'BAP-ÖNAP/ADP/GDM/ÜAP/UİP projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 25],
        '5g1' => ['baslik' => 'Özel kurum-kuruluş destekli projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 20],
        '5g2' => ['baslik' => 'Özel kurum-kuruluş destekli projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],

        // ── 6. TEZ DANIŞMANLIĞI ve JÜRİ ÜYELİĞİ ──
        '6a' => ['baslik' => 'Tamamlanmış doktora/uzmanlık/sanatta yeterlik tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 20],
        '6b' => ['baslik' => 'Tamamlanmış doktora/uzmanlık tez eş danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 10],
        '6c' => ['baslik' => 'Tamamlanmış yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 10],
        '6d' => ['baslik' => 'Tamamlanmış yüksek lisans tez eş danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 5],
        '6e' => ['baslik' => 'Doktora tez izleme komitesi üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 2],

        // ── 7. DERGİ EDİTÖRLÜĞÜ ── (çeyrekliğe göre; bölüm tavanı 75 puan)
        '7a-Q1' => ['baslik' => 'SCIE/SSCI/AHCI Q1 dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)'], 'puan' => 15],
        '7a-Q2' => ['baslik' => 'SCIE/SSCI/AHCI Q2 dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q2)'], 'puan' => 10],
        '7a-Q3' => ['baslik' => 'SCIE/SSCI/AHCI Q3 dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q3)'], 'puan' => 8],
        '7a-Q4' => ['baslik' => 'SCIE/SSCI/AHCI Q4 dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q4)'], 'puan' => 5],

        // ── 8. ÖDÜLLER ──
        '8a' => ['baslik' => 'Cumhurbaşkanlığı Kültür ve Sanat Büyük Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü'], 'puan' => 100],
        '8b' => ['baslik' => 'YÖK, TÜBA veya TÜBİTAK bilim/başarı ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'YÖK Ödülü'], 'puan' => 100],
    ],

    'gruplar' => [
        // Zorunlu koşulların birebir kullandığı atıflar (md. 10-12).
        '1a' => ['1a-Q1', '1a-Q2', '1a-Q3', '1a-Q4'],
        '1a-Q1Q2' => ['1a-Q1', '1a-Q2'],
        '1a-Q1Q3' => ['1a-Q1', '1a-Q2', '1a-Q3'],
        // "1 (a, b, c, d)" — sosyal/ilahiyat/hukuk koşullarının saydığı küme.
        '1-abcd' => ['1a-Q1', '1a-Q2', '1a-Q3', '1a-Q4', '1d'],
        // "3 (a1, a2, b1)" — sosyal bilimler kitap kümesi.
        '3-a1a2b1' => ['3a1', '3a2', '3b1'],
        // "3 (a1, a2, b1, b2, d)" — ilahiyat ve hukuk kitap kümesi.
        '3-ilahiyat' => ['3a1', '3a2', '3b1', '3b2'],
        'MAKALE' => ['1*'],
        'KITAP' => ['3*'],
        'PROJE' => ['5*'],
        'PROJE_YURUTUCU' => ['5a1', '5b1', '5e1', '5g1'],
        'TEZ' => ['6*'],
    ],

    'grup_tavanlari' => [
        // "Bu kategoride en çok 75 puan alınır." (md. 7a)
        '7a-Q1' => 75,
    ],
];
