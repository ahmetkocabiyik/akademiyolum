<?php

/**
 * MARMARA ÜNİVERSİTESİ — Tablo 5
 * "Mühendislik Temel Alanı Puanlama Formu"
 * Kaynak: pdf/17537003632.marmarauniverstesi.pdf (s. 21-22)
 *
 * MADDE NUMARALARI yönergenin kendi numaralandırmasıdır ve koşullar bunlara
 * ARALIK olarak atıf yapıyor: "en az 25 puanının 1-12 ve 16-26, 48 numaralı
 * faaliyetlerden, en az 15 puanının ise 32 ve 50 numaralı faaliyetlerden"
 * (md. 8/b-8).
 *
 * PROJE SATIRLARI FON KAYNAĞINA GÖRE: Tablo 5, diğer tablolardaki
 * uluslararası/ulusal/kurumsal ayrımı yerine uluslararası / TÜBİTAK / DPT /
 * kurumsal ayrımı kullanıyor ve DPT'ye TÜBİTAK'tan yüksek puan veriyor.
 *
 * TABLO 5'TE PATENT SATIRI (48) VAR, diğer bilim tablolarındaki 52 numaralı
 * patent satırından farklı numarada. Yalnız tescil edilmiş patentler girildi;
 * "başvurduysa" alt satırı başvuru aşamasını faaliyet olarak tutmadığımız
 * için girilmedi.
 *
 * GİRİLMEYEN SATIRLAR: 27 (akademik organizasyon yöneticiliği ve
 * düzenleme kurulu üyeliği — kaynak sözlüğünde kongre düzenleme etiketi yok;
 * geniş bir "Diğer" kovasına bağlamak §0'a aykırı olurdu, fazla sayardı),
 * 16 (sorumlu yazar çarpanı), 43 (yükseltme jürisi),
 * 51 (bilirkişi, proje değerlendirme, danışmanlık, laboratuvar yöneticiliği)
 * ve 52 (görev süresi). Tablo 8'in idari faaliyetleri de girilmedi.
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 */

return [
    'kapsam_notu' => 'Puanlar Marmara Üniversitesi Tablo 5\'ten (Mühendislik). Belge 2018 '
        .'öncesi terminoloji kullanıyor; kadro adları güncel karşılıklarına eşlendi. Sorumlu '
        .'yazar çarpanı, patent BAŞVURUSU satırı, jüri görevleri, bilirkişilik, laboratuvar '
        .'yöneticiliği ve görev süresi ile idari faaliyetler (Tablo 8) girilmedi. Gerçek '
        .'toplamınız burada görünenden yüksek olabilir, düşük olamaz.',

    'maddeler' => [
        // ── MAKALE ── (1-15)
        '1' => ['baslik' => 'Birincil indekslerde taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 48],
        '3' => ['baslik' => 'İkincil indekslerde taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale'], 'puan' => 36],
        '4' => ['baslik' => 'Birincil indekslerde taranan dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme'], 'puan' => 30],
        '5' => ['baslik' => 'İkincil indekslerde taranan dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['derleme'], 'puan' => 24],
        '6' => ['baslik' => 'Hakemli ulusal dergide yabancı dilde makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale'], 'puan' => 18],
        '8' => ['baslik' => 'Hakemli ulusal dergide yabancı dilde derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['derleme'], 'puan' => 12],
        '10' => ['baslik' => 'Hakemli ulusal dergide Türkçe makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 18],
        '12' => ['baslik' => 'Hakemli ulusal dergide Türkçe derleme', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['derleme'], 'puan' => 6],
        '15' => ['baslik' => 'Hakemsiz dergide makale veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 5],

        // ── KİTAP ── (17-21)
        '17' => ['baslik' => 'Uzmanlık alanında uluslararası kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 100],
        '18' => ['baslik' => 'Uzmanlık alanında uluslararası kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 60],
        '19' => ['baslik' => 'Uzmanlık alanında ulusal kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı'], 'puan' => 70],
        '20' => ['baslik' => 'Uzmanlık alanında ulusal kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 20],
        '21' => ['baslik' => 'Uzmanlık alanında kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 25],
        '21b' => ['baslik' => 'Uzmanlık alanında makale veya bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 15],

        // ── BİLDİRİ ── (23-26)
        '23' => ['baslik' => 'Uluslararası kongrede tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 24],
        '24' => ['baslik' => 'Uluslararası kongrede özet bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 18],
        '25' => ['baslik' => 'Ulusal kongrede tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 12],
        '26' => ['baslik' => 'Ulusal kongrede özet bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 6],

        // ── DERS ── (32)
        '32' => ['baslik' => 'Verdiği lisansüstü ders (yarıyıl başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Yabancı Dilde Ders'], 'puan' => 4],
        '32b' => ['baslik' => 'Verdiği lisans/önlisans dersi (yarıyıl başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Değişim Programı Dersi'], 'puan' => 2],

        // ── PROJE ── (34-37) · fon kaynağına göre ayrışıyor
        '34' => ['baslik' => 'Tamamlanmış uluslararası projede yöneticilik', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 50],
        '34b' => ['baslik' => 'Tamamlanmış kalkınma ajansı veya bakanlık projesinde yöneticilik', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 40],
        '34c' => ['baslik' => 'Tamamlanmış TÜBİTAK projesinde yöneticilik', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 30],
        '34d' => ['baslik' => 'Tamamlanmış kurumsal projede yöneticilik', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 15],
        '36' => ['baslik' => 'Tamamlanmış uluslararası projede katılımcılık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 30],
        '36b' => ['baslik' => 'Tamamlanmış kalkınma ajansı veya bakanlık projesinde katılımcılık', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
        '36c' => ['baslik' => 'Tamamlanmış TÜBİTAK projesinde katılımcılık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],
        '36d' => ['baslik' => 'Tamamlanmış kurumsal projede katılımcılık', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],

        // ── DAVETLİ KONUŞMACI ve EDİTÖRLÜK ── (38-42)
        '38' => ['baslik' => 'Uluslararası toplantıda davetli konuşmacı', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 30],
        '41' => ['baslik' => 'Uluslararası dergide yayın kurulu üyeliği veya editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi', 'BKCI Kitap'], 'puan' => 10],
        '41b' => ['baslik' => 'Ulusal dergide yayın kurulu üyeliği veya editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi', 'Yayın Kurulu Üyeliği', 'Kitap Editörlüğü'], 'puan' => 4],
        // Yönergenin her alan tablosunda bu satırlar ULUSLARARASI/ULUSAL diye
        // ikiye ayrılıyor; faaliyet kaydı dergi ya da bursun düzeyini taşımadığı
        // için §0 uyarınca ulusal değerden sayılıyor (01.09.2026).
        '42' => ['baslik' => 'Dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 5],

        // ── ÖDÜL ve BURS ── (45-46)
        '45' => ['baslik' => 'Uluslararası başarı ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 35],
        '45b' => ['baslik' => 'Ulusal başarı ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'YÖK Ödülü', 'Yarışma Derecesi / Mansiyon'], 'puan' => 20],
        '46' => ['baslik' => 'Araştırma bursu', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 10],

        // ── ATIF ── (47)
        '47' => ['baslik' => 'Uluslararası bilimsel dergi veya kitapta atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 40],
        '47b' => ['baslik' => 'Ulusal bilimsel dergi veya kitapta atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 20],

        // ── PATENT ── (48) · yalnız tescil edilmiş olanlar
        '48' => ['baslik' => 'Tescil edilmiş uluslararası patent veya know-how', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 50],
        '48b' => ['baslik' => 'Tescil edilmiş ulusal patent, faydalı model veya tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Ticarileştirme', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 25],

        // ── TEZ DANIŞMANLIĞI ── (49)
        '49' => ['baslik' => 'Tamamlanmış doktora tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 25],
        '49b' => ['baslik' => 'Tamamlanmış yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 20],
        '49c' => ['baslik' => 'Tez jüri üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 4],
        '31a2' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 20],
        '31b2' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 15],
    ],

    'gruplar' => [
        // Koşulların birebir kullandığı ARALIKLAR (md. 7/d-8, 8/b-8, 13/a, 18/2-a).
        '1-12' => ['1', '3', '4', '5', '6', '8', '10', '12'],
        '1-12,16-26,48' => ['1', '3', '4', '5', '6', '8', '10', '12', '17', '18', '19', '20', '21', '21b', '23', '24', '25', '26', '48', '48b'],
        '32,50' => ['32', '32b', '49b'],
        // "27, 32-52 numaralı faaliyetler" — doçentlik koşulu (md. 13/a).
        '27,32-52' => ['32', '32b', '34', '34b', '34c', '34d', '36', '36b', '36c', '36d', '38', '41', '41b', '42', '45', '45b', '46', '47', '47b', '48', '48b', '49', '49b', '49c'],
        // "17, 18, 27, 34, 41, 49, 50" — profesörlük koşulu (md. 18/2-a).
        'PROF-CEKIRDEK' => ['17', '18', '34', '34b', '34c', '34d', '41', '41b', '49', '49b'],
        // Md. 7/d-8 ve 8/b-8: "SCI-Expanded kapsamındaki dergilerde makale".
        'BIRINCIL' => ['1', '4'],
    ],

    'grup_tavanlari' => [],
];
