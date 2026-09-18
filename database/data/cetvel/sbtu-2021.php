<?php

/**
 * SİVAS BİLİM VE TEKNOLOJİ ÜNİVERSİTESİ — Ek-2 Faaliyet Puanlama Tablosu
 * Kaynak: pdf/17537008372.sivasbilimveteknolojiuniverstesi.pdf
 * (10 sayfa; YÖK onayıyla 24/03/2021'de yürürlüğe girdi.)
 *
 * Madde kodları Ek-2'nin kendi numaralandırması (A1.1, A4.3, C1.12 …).
 * Yalnız projelerdeki rol ayrımı için açılan `-yur`, `-ars`, `-dan`,
 * `-burs` ekleri bize ait.
 *
 * ── KADROYA GÖRE DEĞİŞEN TEK TAVAN ──
 * Tablo 1 kongre faaliyetlerinde doçentlik için "en fazla 100 puan
 * sayılır", profesörlük için "en fazla 150 puan sayılır" diyor; cetvelin
 * iki varyantı üretildi. Atıf tavanı (100) her iki kadroda aynı.
 * Doktor öğretim üyeliği sütununda tavan yazmıyor; §0 uyarınca doçentlik
 * tavanları uygulandı (puanı düşük gösterir).
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   A3.2 sözlü özet bildiri (15) ile A3.4 poster özeti (5) → tek
 *       'Uluslararası Özet/Poster' etiketi; 5 girildi. Ulusal karşılığı
 *       A3.7 (9) ile A3.9 (3) → 3 girildi.
 *   B1.1 tek danışman (15) ile B1.2 asıl danışman (14) → 14 girildi;
 *       yüksek lisansta 10 ile 9 → 9.
 *   B1.7 doktora tez jüri üyeliği (4) ile B1.8 yüksek lisans jüri
 *       üyeliği (2) → tek 'Tez İzleme / Jüri Üyeliği' etiketi; 2.
 *   B2.1 uluslararası lisanslı patent (100) ile B2.3 ulusal lisanslı
 *       patent (50) → tek 'Ticarileştirme' etiketi; 50.
 *   C1.2 baş editörlük (70), C1.4 yardımcı editörlük (35), C1.5 dil
 *       editörlüğü (30) ve C1.6 misafir editörlük (25) → sözlük editör
 *       türünü ayırmıyor; 25 girildi. Aynı biçimde C1.8-C1.10 (35, 20,
 *       15) → 15; C1.7 ile C1.11 (20, 15) → 15; C1.17 ile C1.19-C1.20
 *       (20, 10) → 10; C1.12 ile C1.22 hakemlik (5, 3) → 3.
 *   C2.1, C2.2 ve C2.6 yarışma dereceleri (30/15, 60/40, 25/10) → tek
 *       'Yarışma Derecesi / Mansiyon' etiketi; 10 girildi.
 *   C2.7 bilim ödülü (150) ile teşvik ödülü (75) → 75; C2.8 (75, 30)
 *       → 30; C2.3, C2.4 ve C2.9 burslar (15, 5, 4) → 4.
 *   A4.3 TÜBİTAK ve yüksek bütçeli bakanlık projeleri (yürütücü 100) ile
 *       A4.4 TÜBİTAK Hızlı Destek (50) ve A4.10 TÜBİTAK kamu, bilim ve
 *       toplum projeleri (30) → sözlük TÜBİTAK program türünü ayırmıyor;
 *       burada §0'dan SAPILDI ve etiketin baskın anlamı olan A4.3
 *       değerleri girildi (Hızlı Destek ve bilim-toplum projeleri
 *       olduğundan yüksek puanlanır). Aynı gerekçeyle A1.2 ESCI makalesi
 *       (60) 'ESCI / Scopus' etiketine bağlandı; yalnız Scopus'ta
 *       taranan bir dergi aslında A1.6 (25) satırına girer.
 *   A4.6 BAP Üniversite-Sektör İşbirliği projesi (yürütücü 100) ile
 *       A4.8 normal BAP projesi (30) → tek 'BAP (Üniversite)' etiketi;
 *       30 girildi ve BAP satırı "A4.1-A4.7 projesinde yürütücü olmak"
 *       koşulunun kümesine ALINMADI.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   B1.9-B1.11 dersler — puan DERS SAATİ başına veriliyor (lisans 1,
 *       lisansüstü 1,5, ön lisans 0,5), kayıt ders başına tutuluyor.
 *       Bölümün tavanı 40 puan; bu puan hiç sayılmıyor.
 *   B1.12 (laboratuvar altyapısı kurmak), A1.18 (hakemsiz dergi),
 *       A2.7 (ders notu), A4.12 (reddedilen TÜBİTAK başvurusu),
 *       C1.3 ve C1.18 (konferans kitabı editörlüğü), C1.14 ve C1.24
 *       (proje hakemliği), C1.26 (TÜBA/TÜBİTAK üyeliği), B3.4 ve B3.10
 *       (sergi küratörlüğü) — sözlükte karşılıksız.
 *   A1.12 ve A1.13 (özet, kitap değerlendirmesi) — kayıt bu türü
 *       vaka/teknik nottan ayırmıyor, A1.11 satırından sayılıyor.
 *   Tezlerde "devam eden" satırları — kayıt tezin tamamlanıp
 *       tamamlanmadığını taşımıyor, tamamlanmış değerleri kullanıldı.
 *   A5'in "20'den sonraki her atıf 1,5 puan" kademesi — kayıt atıfları
 *       tek tek tutuyor, hepsi 1 puandan sayılıyor.
 *
 * Yönerge: yonerge/sbtu.php
 */
$SCI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)'];
$ULUSAL_DERGI = ['TR Dizin', 'Diğer Ulusal Hakemli'];
$WOS_DERGI = ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'];

$maddeler = [
    // ══ A1. MAKALELER ══
    'A1.1' => ['baslik' => 'SCI-Expanded kapsamındaki dergide yayımlanan tam metin araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => ['ozgun_makale'], 'puan' => 70],
    'A1.2' => ['baslik' => 'ESCI kapsamındaki dergide yayımlanan tam metin araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI'], 'turler' => ['ozgun_makale'], 'puan' => 60],
    'A1.3' => ['baslik' => 'SCI-Expanded kapsamındaki dergide yayımlanan short communication, letter ya da brief report', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => ['kisa_makale'], 'puan' => 40],
    'A1.4' => ['baslik' => 'ESCI kapsamındaki dergide yayımlanan short communication, letter ya da brief report', 'kategori' => 'makale', 'kaynaklar' => ['ESCI'], 'turler' => ['kisa_makale'], 'puan' => 30],
    'A1.5' => ['baslik' => 'Üniversitelerarası Kurulun kabul ettiği uluslararası alan indeksi kapsamındaki hakemli dergide yayımlanan tam metin araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 40],
    'A1.6' => ['baslik' => 'Diğer uluslararası hakemli dergide yayımlanan tam metin araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Scopus'], 'turler' => ['ozgun_makale'], 'puan' => 25],
    'A1.7' => ['baslik' => 'SCI-Expanded kapsamındaki dergide derleme', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => ['derleme'], 'puan' => 25],
    'A1.8' => ['baslik' => 'ESCI kapsamındaki dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI'], 'turler' => ['derleme'], 'puan' => 20],
    'A1.9' => ['baslik' => 'Uluslararası alan indeksi kapsamındaki dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => ['derleme'], 'puan' => 15],
    'A1.10' => ['baslik' => 'Diğer uluslararası hakemli dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Scopus'], 'turler' => ['derleme'], 'puan' => 10],
    'A1.11' => ['baslik' => 'Uluslararası hakemli dergide yayımlanan editöre mektup, teknik not, vaka incelemesi ya da tartışma', 'kategori' => 'makale', 'kaynaklar' => [...$SCI, 'ESCI', 'AHCI', 'Diğer Uluslararası İndeks', 'Scopus'], 'turler' => ['vaka_teknik_not'], 'puan' => 20],
    'A1.14' => ['baslik' => 'Ulusal hakemli dergide yayımlanan tam metin özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => $ULUSAL_DERGI, 'turler' => ['ozgun_makale'], 'puan' => 25],
    'A1.15' => ['baslik' => 'Ulusal hakemli dergide derleme', 'kategori' => 'makale', 'kaynaklar' => $ULUSAL_DERGI, 'turler' => ['derleme'], 'puan' => 15],
    'A1.16' => ['baslik' => 'Ulusal hakemli dergide yayımlanan editöre mektup, teknik not, vaka incelemesi ya da tartışma', 'kategori' => 'makale', 'kaynaklar' => $ULUSAL_DERGI, 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 5],
    'A1.17' => ['baslik' => 'Bilimsel nitelikli ansiklopedide madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 5],

    // ══ A2. KİTAPLAR ══
    'A2.1' => ['baslik' => 'Uluslararası yayınevi tarafından yabancı dilde yayımlanan bilimsel, mesleki ya da ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 150],
    'A2.2' => ['baslik' => 'Uluslararası yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 75],
    'A2.3' => ['baslik' => 'Uluslararası yayınevi kitabının yayımlanmış çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 30],
    'A2.4' => ['baslik' => 'Uluslararası yayınevi kitabının yayımlanmış bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 20],
    'A2.5' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanan bilimsel, mesleki ya da ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı', 'Tahkik (Tenkitli Metin)'], 'puan' => 50],
    'A2.6' => ['baslik' => 'Ulusal yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 20],

    // ══ A3. KONGRE ÇALIŞMALARI ══
    'A3.1' => ['baslik' => 'Uluslararası hakemli konferansta sözlü sunulan ve tam metni yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 25],
    'A3.4' => ['baslik' => 'Uluslararası hakemli konferansta özet metni yayımlanan bildiri ya da poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 5],
    'A3.6' => ['baslik' => 'Ulusal hakemli konferansta sözlü sunulan ve tam metni yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 15],
    'A3.9' => ['baslik' => 'Ulusal hakemli konferansta özet metni yayımlanan bildiri ya da poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 3],

    // ══ A4. ARAŞTIRMA PROJELERİ ══
    'A4.1-yur' => ['baslik' => 'AB, UN, NATO-SFS, NSF gibi uluslararası kuruluşların desteklediği projede yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 150],
    'A4.1-ars' => ['baslik' => 'AB, UN, NATO-SFS, NSF gibi uluslararası kuruluşların desteklediği projede araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci'], 'puan' => 100],
    'A4.1-dan' => ['baslik' => 'AB, UN, NATO-SFS, NSF gibi uluslararası kuruluşların desteklediği projede danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['danisman'], 'puan' => 75],
    'A4.1-burs' => ['baslik' => 'AB, UN, NATO-SFS, NSF gibi uluslararası kuruluşların desteklediği projede bursiyer olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['bursiyer'], 'puan' => 30],
    'A4.2-yur' => ['baslik' => 'Diğer uluslararası kurum ya da üniversitelerin desteklediği projede yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 100],
    'A4.2-ars' => ['baslik' => 'Diğer uluslararası kurum ya da üniversitelerin desteklediği projede araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci'], 'puan' => 70],
    'A4.2-dan' => ['baslik' => 'Diğer uluslararası kurum ya da üniversitelerin desteklediği projede danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['danisman'], 'puan' => 50],
    'A4.2-burs' => ['baslik' => 'Diğer uluslararası kurum ya da üniversitelerin desteklediği projede bursiyer olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['bursiyer'], 'puan' => 20],
    'A4.3-yur' => ['baslik' => 'TÜBİTAK ya da bakanlık, kalkınma ajansı gibi kamu kurumlarının desteklediği projede yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 100],
    'A4.3-ars' => ['baslik' => 'TÜBİTAK ya da bakanlık, kalkınma ajansı gibi kamu kurumlarının desteklediği projede araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci'], 'puan' => 75],
    'A4.3-dan' => ['baslik' => 'TÜBİTAK ya da bakanlık, kalkınma ajansı gibi kamu kurumlarının desteklediği projede danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['danisman'], 'puan' => 50],
    'A4.3-burs' => ['baslik' => 'TÜBİTAK ya da bakanlık, kalkınma ajansı gibi kamu kurumlarının desteklediği projede bursiyer olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['bursiyer'], 'puan' => 20],
    'A4.8-yur' => ['baslik' => 'Üniversitenin BAP komisyonunca desteklenen projede yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 30],
    'A4.8-ars' => ['baslik' => 'Üniversitenin BAP komisyonunca desteklenen projede araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 20],
    'A4.8-dan' => ['baslik' => 'Üniversitenin BAP komisyonunca desteklenen projede danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['danisman'], 'puan' => 15],
    'A4.9-yur' => ['baslik' => 'Özel kuruluş, sivil toplum kuruluşu ya da endüstriyel tasarım projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 30],
    'A4.9-ars' => ['baslik' => 'Özel kuruluş, sivil toplum kuruluşu ya da endüstriyel tasarım projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 20],
    'A4.9-dan' => ['baslik' => 'Özel kuruluş, sivil toplum kuruluşu ya da endüstriyel tasarım projesinde danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['danisman'], 'puan' => 15],
    'A4.11' => ['baslik' => 'TÜBİTAK öğrenci projelerinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'puan' => 10],

    // ══ A5. ATIFLAR ══ (en fazla 100 puan)
    'A5.1' => ['baslik' => 'Uluslararası hakemli dergilerde başka yazarlarca yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'Diğer (Uluslararası)', 'Patent'], 'puan' => 1],
    'A5.2' => ['baslik' => 'Uluslararası yayınevi kitaplarında başka yazarlarca yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 1],
    'A5.3' => ['baslik' => 'Yayımlanan lisansüstü tezlerde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 1],

    // ══ B1. EĞİTİM ETKİNLİKLERİ ══
    'B1.2' => ['baslik' => 'Danışmanlığınızda tamamlanan doktora ya da uzmanlık tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 14],
    'B1.3' => ['baslik' => 'Eş danışmanlığınızda tamamlanan doktora ya da uzmanlık tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 12],
    'B1.5' => ['baslik' => 'Danışmanlığınızda tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 9],
    'B1.6' => ['baslik' => 'Eş danışmanlığınızda tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 8],
    'B1.8' => ['baslik' => 'Lisansüstü tez jüri üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 2],

    // ══ B2. PATENTLER ══
    'B2.2' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 60],
    'B2.3' => ['baslik' => 'Lisans sözleşmesi yapılmış patent', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 50],
    'B2.4' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 30],
    'B2.5' => ['baslik' => 'Faydalı model ya da patent müracaatı', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 10],

    // ══ B3. MESLEKİ VE DİĞER ARAŞTIRMA ETKİNLİKLERİ ══
    'B3.2' => ['baslik' => 'Hakemli bir konferansta davetli konuşmacı ya da panelist olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 10],
    // B3.8 (ULUSAL hakemli konferansta oturum başkanı/davetli konuşmacı/
    // panelist, 10) girilmemişti; ulusal oturum başkanlığı etiketinin
    // karşılığı yoktu. `Davetli Konuşmacı` kapsam taşımadığı için B3.2'nin
    // 20'si yerine B3.8'in 10'unu alır.
    'B3.2k' => ['baslik' => 'Uluslararası hakemli bir konferansta oturum başkanlığı yapmak', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Uluslararası)'], 'puan' => 20],
    'B3.8k' => ['baslik' => 'Ulusal hakemli bir konferansta oturum başkanlığı yapmak', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Ulusal)'], 'puan' => 10],
    'B3.12' => ['baslik' => 'Hakemli bir konferansın düzenleme ya da bilim kurulunda görev almak', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 3],
    // Kaynak B3.3/B3.6 uluslararası düzenleme-bilim kurulu 15/5 → 5, B3.11/B3.12 ULUSAL 5/3 → 3 diyor.
    'B3.12-kur-u' => ['baslik' => 'Uluslararası bilimsel ya da sanatsal toplantı düzenleme ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 5],
    'B3.12-kur-n' => ['baslik' => 'Ulusal bilimsel ya da sanatsal toplantı düzenleme ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 3],
    'B3.13' => ['baslik' => 'Uzmanlık alanınızla ilgili sanayiye danışmanlık hizmeti vermek ya da bilirkişi/teknik rapor hazırlamak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı', 'Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 3],

    // ══ C1. ÜYELİK VE HAKEMLİK ══
    'C1.1' => ['baslik' => 'Uluslararası yayınevi kitabında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 75],
    'C1.6' => ['baslik' => 'SCI-Expanded ya da ESCI kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => $WOS_DERGI, 'puan' => 25],
    'C1.10' => ['baslik' => 'Diğer uluslararası hakemli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi (Uluslararası)'], 'puan' => 15],
    'C1.11' => ['baslik' => 'Hakemli dergide yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 15],
    'C1.16' => ['baslik' => 'Ulusal yayınevi kitabında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 20],
    'C1.19' => ['baslik' => 'TR Dizin kapsamındaki ulusal hakemli dergide editörlük ya da editör yardımcılığı', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 10],
    'C1.22' => ['baslik' => 'Makale hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 3],

    // ══ C2. ÖDÜLLER ══
    'C2.5' => ['baslik' => 'Sürekli ve periyodik olarak verilen jürili uluslararası bilim ya da sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 150],
    'C2.6' => ['baslik' => 'Mesleki organizasyon ya da bakanlıklarca düzenlenen proje yarışmasında derece veya mansiyon almak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 10],
    'C2.7' => ['baslik' => 'TÜBİTAK ya da TÜBA bilim veya teşvik ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 75],
    'C2.8' => ['baslik' => 'Sürekli ve periyodik olarak verilen jürili ulusal bilim ya da sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'YÖK Ödülü'], 'puan' => 30],
    'C2.9' => ['baslik' => 'Doktora sonrası araştırma bursu', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 4],
];

$gruplar = [
    // Tablo 1'in "A1.1 - A1.6 makaleleri" satırı.
    'A1-A16' => ['A1.1', 'A1.2', 'A1.3', 'A1.4', 'A1.5', 'A1.6'],
    'A1.1-SCI' => ['A1.1'],
    // "A1 (makale) ve A2 (kitap) türünde faaliyetler".
    'A1-A2' => ['A1.1', 'A1.2', 'A1.3', 'A1.4', 'A1.5', 'A1.6', 'A1.7', 'A1.8', 'A1.9',
        'A1.10', 'A1.11', 'A1.14', 'A1.15', 'A1.16', 'A1.17',
        'A2.1', 'A2.2', 'A2.3', 'A2.4', 'A2.5', 'A2.6'],
    'ANSIKLOPEDI' => ['A1.17'],
    'KITAP-ULUSAL' => ['A2.5'],
    'A3' => ['A3.1', 'A3.4', 'A3.6', 'A3.9'],
    'A4' => ['A4.1-yur', 'A4.1-ars', 'A4.1-dan', 'A4.1-burs', 'A4.2-yur', 'A4.2-ars', 'A4.2-dan',
        'A4.2-burs', 'A4.3-yur', 'A4.3-ars', 'A4.3-dan', 'A4.3-burs', 'A4.8-yur', 'A4.8-ars',
        'A4.8-dan', 'A4.9-yur', 'A4.9-ars', 'A4.9-dan', 'A4.11'],
    // "A4.1-A4.7 projelerde yürütücü olmalı" — BAP ve özel kuruluş
    // satırları bu kümenin dışında (bkz. dosya başlığı).
    'A4-YURUTUCU' => ['A4.1-yur', 'A4.2-yur', 'A4.3-yur'],
    'A5' => ['A5.1', 'A5.2', 'A5.3'],
    'TEZ-JURI' => ['B1.8'],
    // "B1, B2, B3, C1 ve C2 faaliyetleri".
    'BC' => ['B1.2', 'B1.3', 'B1.5', 'B1.6', 'B1.8', 'B2.2', 'B2.3', 'B2.4', 'B2.5',
        'B3.2', 'B3.12', 'B3.13', 'C1.1', 'C1.6', 'C1.10', 'C1.11', 'C1.16', 'C1.19', 'C1.22',
        'C2.5', 'C2.6', 'C2.7', 'C2.8', 'C2.9'],
];

// Ek-3: Ortak çalışmalarla ilgili katkı oranları tablosu. Lisansüstü
// tezlerden üretilen yayınlarda danışman ve makalelerin sorumlu yazarı
// birinci isim gibi değerlendirilir.
$yazarKatsayisi = [
    'haric' => ['atif', 'proje', 'patent', 'tez_danismanligi', 'egitim_ogretim', 'odul',
        'idari_gorev', 'toplumsal_katki', 'diger', 'editorluk', 'sanatsal_etkinlik'],
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.00]],
        'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.95, 3 => 0.90, 4 => 0.85, 5 => 0.80], 'sonrasi' => 0.75],
        'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.95, 3 => 0.90, 4 => 0.85, 5 => 0.80], 'sonrasi' => 0.75],
        'yazar_2' => ['kademeler' => [2 => 0.85, 3 => 0.80, 4 => 0.75, 5 => 0.70], 'sonrasi' => 0.65],
        'yazar_3' => ['kademeler' => [3 => 0.70, 4 => 0.65, 5 => 0.60], 'sonrasi' => 0.55],
        'yazar_4' => ['kademeler' => [4 => 0.55, 5 => 0.50], 'sonrasi' => 0.45],
        'yazar_5' => ['kademeler' => [5 => 0.40], 'sonrasi' => 0.35],
        'yazar_6' => ['sonrasi' => 0.25],
        'ortak' => ['sonrasi' => 0.25],
    ],
];

$kapsamNotu = 'Puanlar Sivas Bilim ve Teknoloji Üniversitesi Öğretim Üyesi Kadrolarına '
    .'Yükseltilme ve Atanma Yönergesinin Ek-2 tablosundan (24/03/2021 yürürlük). Yazar çarpanı '
    .'Ek-3\'teki katkı oranları tablosundan: birinci isim tek yazarlıda tam puan, iki yazarlıda '
    .'%95, üç yazarlıda %90 … beşten fazla yazarlıda %75; ikinci isim %85\'ten %65\'e, üçüncü '
    .'isim %70\'ten %55\'e iner. Lisansüstü tezden üretilen yayınlarda danışman ve makalenin '
    .'sorumlu yazarı birinci isim sayılır. Yazar listesini boş bırakırsanız çarpan hiç '
    .'uygulanmaz ve puanınız olduğundan YÜKSEK görünür. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünür: TÜBİTAK Hızlı Destek ile kamu, '
    .'girişimcilik ve bilim-toplum projeleri tablonun 100 puanlık TÜBİTAK satırından sayılıyor '
    .'(yönergede 50 ve 30 puan); yalnız Scopus\'ta taranan dergilerdeki makaleler ESCI '
    .'satırından 60 puanla sayılıyor (yönergede 25 puan). '
    .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: verdiğiniz dersler HİÇ sayılmıyor, çünkü '
    .'yönerge puanı ders saati başına veriyor, kayıt ise ders başına tutuluyor (bu bölümün '
    .'tavanı 40 puan). Uluslararası sözlü özet bildiri 15 yerine 5, ulusal sözlü özet bildiri 9 '
    .'yerine 3, dergi editörlükleri en düşük editör türünün puanıyla, yarışma dereceleri en '
    .'düşük satırla, TÜBİTAK/TÜBA bilim ödülü teşvik ödülü puanıyla sayılıyor. Atıfların '
    .'"20\'den sonraki her atıf 1,5 puan" kademesi uygulanmıyor. Laboratuvar altyapısı kurmak, '
    .'proje hakemliği, konferans kitabı editörlüğü, TÜBA/TÜBİTAK üyeliği ve sergi küratörlüğü '
    .'satırları sözlükte karşılıksız. Rolü girilmemiş projeler 0 puan alır.';

$TAVAN = ['ANSIKLOPEDI' => 25, 'KITAP-ULUSAL' => 100, 'A5' => 100, 'TEZ-JURI' => 20];

return [
    'cetveller' => [
        'sbtu-2021' => [
            'kapsam_notu' => $kapsamNotu,
            'yazar_katsayisi' => $yazarKatsayisi,
            'maddeler' => $maddeler,
            'gruplar' => $gruplar,
            'grup_tavanlari' => [...$TAVAN, 'A3' => 100],
        ],
        'sbtu-2021-prof' => [
            'kapsam_notu' => $kapsamNotu,
            'yazar_katsayisi' => $yazarKatsayisi,
            'maddeler' => $maddeler,
            'gruplar' => $gruplar,
            'grup_tavanlari' => [...$TAVAN, 'A3' => 150],
        ],
    ],
];
