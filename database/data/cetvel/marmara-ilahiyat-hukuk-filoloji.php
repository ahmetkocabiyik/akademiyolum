<?php

/**
 * MARMARA ÜNİVERSİTESİ — Tablo 3
 * "İlahiyat, Hukuk ve Filoloji Temel Alanı Puanlama Formu"
 * Kaynak: pdf/17537003632.marmarauniverstesi.pdf (s. 16-17)
 *
 * MADDE NUMARALARI yönergenin kendi numaralandırmasıdır ve koşullar bunlara
 * ARALIK olarak atıf yapıyor: "3-21 numaralı faaliyetlerden en az 42 puan ve
 * 3-21, 23, 24, 32, 36, 37, 47, 49 numaralı faaliyetlerden 90 puan"
 * (md. 7/d-3, Filoloji).
 *
 * BİRİNCİL İNDEKS SATIRI (1) YOK: tablo doğrudan 3'ten başlıyor ve en yüksek
 * makale satırı "hakemli uluslararası dergi" (36 puan). SCIE/SSCI/AHCI
 * yayınları da bu satıra düşüyor; alanın yayın kültürü gereği yönerge
 * birincil-ikincil ayrımı yapmamış.
 *
 * KİTAP PUANLARI DİĞER TABLOLARDAN DÜŞÜK: ulusal kitap 50 (Tablo 2/6'da 70),
 * uluslararası kitap bölümü 50 (60), ulusal kitap editörlüğü 5 (20).
 *
 * TABLODA KOREOGRAFİ SATIRLARI (29, 30) DA VAR — kaynak belgede Tablo 3'e
 * konmuş; alanla ilgisi kurulamadığı ve kayıt karşılığı sanatsal etkinlik
 * kategorisinde olduğu için girildi.
 *
 * GİRİLMEYEN SATIRLAR: 27 (akademik organizasyon yöneticiliği ve
 * düzenleme kurulu üyeliği — kaynak sözlüğünde kongre düzenleme etiketi yok;
 * geniş bir "Diğer" kovasına bağlamak §0'a aykırı olurdu, fazla sayardı),
 * 16 (sorumlu yazar çarpanı), 28 (müzik kompozisyonları
 * — başlık dışında satır verilmemiş), 43 (yükseltme jürisi), 51 (bilirkişi,
 * proje değerlendirme, danışmanlık) ve 52 (görev süresi). Tablo 8'in idari
 * faaliyetleri de girilmedi.
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 */

return [
    'kapsam_notu' => 'Puanlar Marmara Üniversitesi Tablo 3\'ten (İlahiyat, Hukuk ve Filoloji). '
        .'Belge 2018 öncesi terminoloji kullanıyor; kadro adları güncel karşılıklarına '
        .'eşlendi. Akademik organizasyon yöneticiliği (27), sorumlu yazar çarpanı, müzik kompozisyonu, jüri görevleri, bilirkişilik ve '
        .'görev süresi ile idari faaliyetler (Tablo 8) girilmedi. Gerçek toplamınız burada '
        .'görünenden yüksek olabilir, düşük olamaz.',

    'maddeler' => [
        // ── MAKALE ── (3-15) · tabloda birincil indeks satırı yok
        '3' => ['baslik' => 'Hakemli uluslararası dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI', 'ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale'], 'puan' => 36],
        '5' => ['baslik' => 'Hakemli uluslararası dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI', 'ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['derleme'], 'puan' => 24],
        '11' => ['baslik' => 'Hakemli ulusal dergide Türkçe makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 18],
        '13' => ['baslik' => 'Hakemli ulusal dergide Türkçe derleme', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['derleme'], 'puan' => 6],
        '15' => ['baslik' => 'Hakemsiz dergide makale veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 5],

        // ── KİTAP ── (17-21)
        '17' => ['baslik' => 'Uzmanlık alanında uluslararası kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 100],
        '18' => ['baslik' => 'Uzmanlık alanında uluslararası kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 50],
        '18b' => ['baslik' => 'Uzmanlık alanında uluslararası kitap veya dergi editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 20],
        '19' => ['baslik' => 'Uzmanlık alanında ulusal kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı'], 'puan' => 50],
        '20' => ['baslik' => 'Uzmanlık alanında ulusal kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 20],
        '20b' => ['baslik' => 'Uzmanlık alanında ulusal kitap veya dergi editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü', 'TR Dizin Dergi'], 'puan' => 5],
        '21' => ['baslik' => 'Uzmanlık alanında kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap', 'Çeviri Kitap Bölümü'], 'puan' => 15],

        // ── BİLDİRİ ── (23-26)
        '23' => ['baslik' => 'Uluslararası kongrede tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 24],
        '24' => ['baslik' => 'Uluslararası kongrede özet bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 18],
        '25' => ['baslik' => 'Ulusal kongrede tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 24],
        '26' => ['baslik' => 'Ulusal kongrede özet bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 12],

        // ── KOREOGRAFİ ── (29-30) · kaynak belgede bu tabloda yer alıyor
        '29' => ['baslik' => 'Uluslararası düzeyde koreografi eseri meydana getirmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Tüm Perde Koreograflığı (Uluslararası)', 'Bölüm Koreograflığı (Uluslararası)', 'Bale/Dans Koreograflığı (Uluslararası)'], 'puan' => 60],
        '29b' => ['baslik' => 'Ulusal düzeyde koreografi eseri meydana getirmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koreografi', 'Tüm Perde Koreograflığı (Ulusal)', 'Bölüm Koreograflığı (Ulusal)', 'Bale/Dans Koreograflığı (Ulusal)'], 'puan' => 30],
        '30' => ['baslik' => 'Koreografisini yaptığı eseri uluslararası düzeyde sahnelemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahneleme/Repetitörlük — Tüm Perde (Uluslararası)', 'Sahneleme/Repetitörlük — Bölüm (Uluslararası)'], 'puan' => 35],
        '30b' => ['baslik' => 'Koreografisini yaptığı eseri ulusal düzeyde sahnelemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahneleme/Repetitörlük — Tüm Perde (Ulusal)', 'Sahneleme/Repetitörlük — Bölüm (Ulusal)'], 'puan' => 20],

        // ── DERS ── (32) · Tablo 3 tek satır veriyor
        '32' => ['baslik' => 'Verdiği ders (yarıyıl başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Yabancı Dilde Ders', 'Lisans/Önlisans Ders', 'Değişim Programı Dersi'], 'puan' => 5],

        // ── PROJE ── (34-37)
        '34' => ['baslik' => 'Tamamlanmış uluslararası projede yöneticilik', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 30],
        '34b' => ['baslik' => 'Tamamlanmış ulusal veya kurumsal projede yöneticilik', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'BAP (Üniversite)', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 15],
        '36' => ['baslik' => 'Tamamlanmış uluslararası projede katılımcılık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 12],
        '36b' => ['baslik' => 'Tamamlanmış ulusal veya kurumsal projede katılımcılık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'BAP (Üniversite)', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 8],

        // ── DAVETLİ KONUŞMACI ve EDİTÖRLÜK ── (38-42)
        '38' => ['baslik' => 'Uluslararası toplantıda davetli konuşmacı', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 30],
        '41' => ['baslik' => 'Yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği', 'Diğer Hakemli Dergi'], 'puan' => 2],
        // Yönergenin her alan tablosunda bu satırlar ULUSLARARASI/ULUSAL diye
        // ikiye ayrılıyor; faaliyet kaydı dergi ya da bursun düzeyini taşımadığı
        // için §0 uyarınca ulusal değerden sayılıyor (01.09.2026).
        '42' => ['baslik' => 'Dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 5],

        // ── ÖDÜL ve BURS ── (45-46)
        '45' => ['baslik' => 'Uluslararası başarı ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 35],
        '45b' => ['baslik' => 'Ulusal başarı ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'YÖK Ödülü', 'Yarışma Derecesi / Mansiyon'], 'puan' => 10],
        '46' => ['baslik' => 'Araştırma bursu', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 10],

        // ── ATIF ── (47)
        '47' => ['baslik' => 'Uluslararası bilimsel dergi veya kitapta atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 40],
        '47b' => ['baslik' => 'Ulusal bilimsel dergi veya kitapta atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 20],

        // ── TEZ DANIŞMANLIĞI ── (49)
        '49' => ['baslik' => 'Tamamlanmış doktora tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 20],
        '49b' => ['baslik' => 'Tamamlanmış yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 10],
        '31a2' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 20],
        '31b2' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 15],
    ],

    'gruplar' => [
        // Koşulların birebir kullandığı ARALIKLAR (md. 7/d-3, 8/b-3, 13/a, 18/2-a).
        '3-21' => ['3', '5', '11', '13', '15', '17', '18', '18b', '19', '20', '20b', '21'],
        // "3-21, 23, 24, 32, 36, 37, 47, 49" — Filoloji dr. öğr. üyeliği toplamı.
        'FILOLOJI-TOPLAM' => ['3', '5', '11', '13', '15', '17', '18', '18b', '19', '20', '20b', '21', '23', '24', '32', '36', '36b', '47', '47b', '49', '49b'],
        // "27, 32-52 numaralı faaliyetler" — doçentlik koşulu (md. 13/a).
        '27,32-52' => ['29', '29b', '30', '30b', '32', '34', '34b', '36', '36b', '38', '41', '42', '45', '45b', '46', '47', '47b', '49', '49b'],
        // "17, 18, 27, 34, 41, 49, 50" — profesörlük koşulu (md. 18/2-a).
        'PROF-CEKIRDEK' => ['17', '18', '18b', '34', '34b', '41', '49', '49b'],
        // Md. 7/d-5 ve 7/d-6: "hakemli dergilerde iki makale" (Hukuk, İlahiyat).
        'HAKEMLI-MAKALE' => ['3', '11'],
        // Md. 7/d-3: "indekslerce taranan bir makale" (Filoloji).
        'INDEKSLI-MAKALE' => ['3'],
    ],

    'grup_tavanlari' => [],
];
