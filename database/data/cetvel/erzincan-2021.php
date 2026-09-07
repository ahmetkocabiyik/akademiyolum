<?php

/**
 * ERZİNCAN BİNALİ YILDIRIM ÜNİVERSİTESİ — Performans Değerlendirme Sistemi
 * Kaynak: pdf/1769428294367.erzincan-binali-yildirim-kriter-16102025gk-26012026.pdf
 * (2021 tarihli Uygulama Esasları; 28.08.2025 tarihli YÖK Genel Kurul
 * kararıyla değişik hâli)
 *
 * Madde kodları bize ait; yönergenin bölüm numaralarını izliyor (MK =
 * makaleler, KT = kitaplar, BD = bildiriler, AT = atıflar, PR = projeler,
 * ED = editörlük, HK = hakemlik, DB = diğer bilimsel etkinlikler,
 * EG = eğitim öğretim, MS = mesleki faaliyetler, SN = sanat ve tasarım,
 * YN = yönetimsel faaliyetler).
 *
 * ── Q ÇARPANI SATIRA GÖMÜLDÜ ──
 * Yönerge SCI-Expanded, SSCI ve AHCI makalelerinin puanını derginin Q
 * dilimiyle çarpıyor (Q1 ×2,00; Q2 ×1,70; Q3 ×1,35; Q4 ×1,00). Kaynak
 * etiketi zaten çeyreği taşıdığı için çarpan satır puanına gömüldü:
 * tam makale 80/68/54/40, kısa makale 40/34/27/20.
 *
 * Q tanımı yalnızca SCI-Expanded, SSCI ve AHCI dergilerini kapsadığı için
 * çarpan 2-5. maddelere uygulanmadı. AHCI dergilerinin çeyrek dilimi
 * genellikle yayımlanmıyor; §0 gereği en düşük çarpan (Q4, ×1,00)
 * varsayıldı, yani AHCI makaleniz olduğundan düşük puanlanabilir.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   Atıfta SCI-E/SSCI/AHCI (3) ile ESCI-alan indeksi (2) tek 'WoS / Scopus'
 *       etiketine düşüyor → 2. Uluslararası (3) ile ulusal (1) kitap atfı
 *       tek 'BKCI Kitap' etiketine düşüyor → 1.
 *   Editörlükte "ESCI ve alan indeksleri dışındaki uluslararası hakemli
 *       dergi" (20) ile "diğer ulusal dergi" (10) → 10.
 *   Hakemlikte beş kademe (5'ten 1'e) tek 'Hakemlik' etiketine düşüyor → 1.
 *   Bildiride özet sözlü (5/3) ile poster (3/2) aynı etikete düşüyor →
 *       uluslararası 3, ulusal 2. Davetli konuşmacıda uluslararası (20)
 *       ile ulusal (10) → 10.
 *   Kurul ve komisyon üyeliklerinde akademik birim komisyonu (1),
 *       üniversite komisyonunda görev (2) ve başkanlık (3) → 1.
 *   Diğer bilimsel etkinliklerin sözlükte karşılığı olmayan satırları
 *       (toplantı düzenleme 20/10/10/5, sertifika 5, TÜBİTAK-AB panelistliği
 *       10, TBMM-TDK-DPT komisyon üyeliği 15) tek 'Diğer' etiketine
 *       düşüyor → 5.
 *   Sanat bölümünde çok sayıda satır aynı etikete düşüyor; her etikette
 *       en düşük değer girildi (ayrıntı satır yorumlarında).
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   Ondalıklı puanlar (motor tam sayı taşıyor): A.1.1 önlisans/lisans
 *       danışmanlığı (0,05), A.2 sınav gözetmenliği (0,1), atıf tablosunun
 *       TR-Dizin (0,8) ve diğer ulusal dergi (0,5) satırları.
 *   Sözlükte karşılığı olmayan satırlar: lisans tez danışmanlığı, tezsiz
 *       yüksek lisans danışmanlığı, öğrenci kulübü danışmanlığı, derleme
 *       kitap yazarlığı (20), çeviri makale (5).
 *   C.3 SPOR ETKİNLİKLERİ bölümünün tamamı (millî takım görevi, spor
 *       hakemliği, organizasyon, federasyon kurulu, sportif ödüller) —
 *       faaliyet kaydında karşılığı yok.
 *   Sanat bölümünde küratörlük (2), festival çalışmaları (11), geleneksel
 *       el sanatları belge çözümlemesi (12), arkeolojik kazı (14), kısa
 *       oyun ve dizi yazarlığı (19.2-19.3), sunuculuk satırları (21.7,
 *       22.7) ve koruma kurulu üyeliği (25.2).
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   "Tekrar baskısı yapılmış kitap, lisansüstü tezden üretilmiş kitap,
 *       devam eden proje, yardımcı/konuk editörlük, yönetici yardımcılığı
 *       ve tekrarlanan sanat etkinliği için puanın yarısı alınır" — kayıt
 *       bu ayrımı taşımadığı için tam puan uygulanıyor; bu kalemlerde
 *       puanınız OLDUĞUNDAN YÜKSEK görünebilir. Yalnızca yönetici
 *       yardımcılıkları ayrı satıra yazıldı (rektör/dekan yardımcılığı 5,
 *       bölüm başkan yardımcılığı 2 — 2,5 aşağı yuvarlandı).
 *   "Aynı kitap veya ansiklopedide en fazla 3 bölüm değerlendirilir" ve
 *       "spor etkinliklerinde her maddeden en fazla 5 adet" sınırları.
 *
 * Yönerge: yonerge/erzincan.php
 *
 * ── 28.08.2025 MÜLGA MADDELERİ: CETVELDE KARŞILIĞI YOK, DOĞRUSU BU ──
 * YÖK Genel Kurulunun 28.08.2025 kararı beş maddeyi mülga etti. İkisi PUAN
 * SATIRI: "C. MESLEKİ FAALİYETLER / 1. Kurum Dışı Görevler" başlığı altındaki
 * Yönetim Kurulu Üyeliği ve Komisyon Üyeliği. Cetveldeki 'EG.KOMISYON' ve
 * 'YN5' satırları bunlar DEĞİL — ikisi de üniversite İÇİ kurul ve komisyon
 * görevleri, ayrı bölümden geliyor. Kaldırılan kurum DIŞI satırların
 * karşılığı hiç girilmemiş, yani fazla sayma yok.
 *
 * Kalan üç mülga madde koşul metnindeydi (Sağlık Bilimleri profesörlüğünün
 * 3. bendi ile iki genel not); yönergedeki koşullar zaten yalnız yürürlükte
 * kalan 1. ve 2. bentleri sayıyor.
 */
$OZGUN = ['ozgun_makale'];
$DERLEME = ['derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];

$maddeler = [
    // ══ B.1.1 MAKALELER ══
    // Madde 1: SSCI, SCI-Expanded ve AHCI (40/20 puan × Q çarpanı).
    'MK1a.q1' => ['baslik' => 'SSCI, SCI-Expanded veya AHCI kapsamındaki Q1 dergide tam araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $OZGUN, 'puan' => 80],
    'MK1a.q2' => ['baslik' => 'SSCI, SCI-Expanded veya AHCI kapsamındaki Q2 dergide tam araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $OZGUN, 'puan' => 68],
    'MK1a.q3' => ['baslik' => 'SSCI, SCI-Expanded veya AHCI kapsamındaki Q3 dergide tam araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $OZGUN, 'puan' => 54],
    'MK1a.q4' => ['baslik' => 'SSCI, SCI-Expanded veya AHCI kapsamındaki Q4 dergide tam araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $OZGUN, 'puan' => 40],
    'MK1a.ahci' => ['baslik' => 'AHCI kapsamındaki dergide tam araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => $OZGUN, 'puan' => 40],
    'MK1d.q1' => ['baslik' => 'SSCI, SCI-Expanded veya AHCI kapsamındaki Q1 dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $DERLEME, 'puan' => 80],
    'MK1d.q2' => ['baslik' => 'SSCI, SCI-Expanded veya AHCI kapsamındaki Q2 dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $DERLEME, 'puan' => 68],
    'MK1d.q3' => ['baslik' => 'SSCI, SCI-Expanded veya AHCI kapsamındaki Q3 dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $DERLEME, 'puan' => 54],
    'MK1d.q4' => ['baslik' => 'SSCI, SCI-Expanded veya AHCI kapsamındaki Q4 dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $DERLEME, 'puan' => 40],
    'MK1d.ahci' => ['baslik' => 'AHCI kapsamındaki dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => $DERLEME, 'puan' => 40],
    'MK1b.q1' => ['baslik' => 'SSCI, SCI-Expanded veya AHCI kapsamındaki Q1 dergide kısa makale (editöre mektup, teknik not, vaka takdimi, tartışma, kitap incelemesi)', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $KISA, 'puan' => 40],
    'MK1b.q2' => ['baslik' => 'SSCI, SCI-Expanded veya AHCI kapsamındaki Q2 dergide kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $KISA, 'puan' => 34],
    'MK1b.q3' => ['baslik' => 'SSCI, SCI-Expanded veya AHCI kapsamındaki Q3 dergide kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $KISA, 'puan' => 27],
    'MK1b.q4' => ['baslik' => 'SSCI, SCI-Expanded veya AHCI kapsamındaki Q4 dergide kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $KISA, 'puan' => 20],
    'MK1b.ahci' => ['baslik' => 'AHCI kapsamındaki dergide kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => $KISA, 'puan' => 20],

    // Madde 2: ESCI veya alan indeksleri.
    'MK2a' => ['baslik' => 'ESCI veya alan indeksleri kapsamındaki dergide tam araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $OZGUN, 'puan' => 30],
    'MK2d' => ['baslik' => 'ESCI veya alan indeksleri kapsamındaki dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $DERLEME, 'puan' => 30],
    'MK2b' => ['baslik' => 'ESCI veya alan indeksleri kapsamındaki dergide kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $KISA, 'puan' => 15],

    // Madde 3: diğer indeksli uluslararası hakemli dergiler.
    'MK3a' => ['baslik' => 'Diğer indeksli uluslararası hakemli dergide tam araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $OZGUN, 'puan' => 12],
    'MK3d' => ['baslik' => 'Diğer indeksli uluslararası hakemli dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $DERLEME, 'puan' => 12],
    'MK3b' => ['baslik' => 'Diğer indeksli uluslararası hakemli dergide kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 6],

    // Madde 4: TR-Dizin.
    'MK4a' => ['baslik' => 'TR-Dizin kapsamındaki dergide tam araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $OZGUN, 'puan' => 20],
    'MK4d' => ['baslik' => 'TR-Dizin kapsamındaki dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $DERLEME, 'puan' => 20],
    'MK4b' => ['baslik' => 'TR-Dizin kapsamındaki dergide kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $KISA, 'puan' => 10],

    // Madde 5: diğer hakemli dergiler.
    'MK5a' => ['baslik' => 'Diğer hakemli dergide tam araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $OZGUN, 'puan' => 10],
    'MK5d' => ['baslik' => 'Diğer hakemli dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $DERLEME, 'puan' => 10],
    'MK5b' => ['baslik' => 'Diğer hakemli dergide kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 5],

    // ══ B.1.2 KİTAP VE KİTAP BÖLÜMLERİ ══
    'KT1.1' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 60],
    'KT1.2.1' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış araştırma-inceleme niteliğinde özgün kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 50],
    'KT1.2.2' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 40],
    'KT2.1' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanan kitap veya ansiklopedide bölüm, madde ya da ünite yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 25],
    'KT2.2' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanan kitap veya ansiklopedide bölüm, madde ya da ünite yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 15],
    'KT3.1' => ['baslik' => 'Çeviri kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 30],
    'KT3.2' => ['baslik' => 'Çeviri kitap bölümü', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 8],

    // ══ B.1.3 BİLDİRİLER ══
    'BD1.1' => ['baslik' => 'Uluslararası bilimsel toplantıda tam metin olarak yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 10],
    'BD1.2' => ['baslik' => 'Uluslararası bilimsel toplantıda özet metin olarak yayımlanan sözlü bildiri ya da poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 3],
    'BD2.1' => ['baslik' => 'Ulusal bilimsel toplantıda tam metin olarak yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 6],
    'BD2.2' => ['baslik' => 'Ulusal bilimsel toplantıda özet metin olarak yayımlanan sözlü bildiri ya da poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 2],
    'BD.DAVET' => ['baslik' => 'Bilimsel kongre veya sempozyumda davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 10],

    // ══ B.2 ATIFLAR ══
    'AT1' => ['baslik' => 'SSCI, SCI-Expanded, AHCI, ESCI ya da alan indeksleri kapsamındaki dergilerde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 2],
    'AT6' => ['baslik' => 'Kitap ya da kitap bölümlerinde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 1],

    // ══ B.3 PROJELER ══
    'PR1.1' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen projede koordinatörlük ya da yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 50],
    'PR1.2' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen projede araştırmacılık, danışmanlık ya da bursiyerlik', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 30],
    'PR2.1' => ['baslik' => 'TÜBİTAK tarafından desteklenen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 40],
    'PR2.2' => ['baslik' => 'TÜBİTAK tarafından desteklenen projede araştırmacılık, danışmanlık ya da bursiyerlik', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
    'PR3.1' => ['baslik' => 'Üniversite dışı ulusal kuruluşlarca desteklenen projede koordinatörlük ya da yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 30],
    'PR3.2' => ['baslik' => 'Üniversite dışı ulusal kuruluşlarca desteklenen projede araştırmacılık, danışmanlık ya da bursiyerlik', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],
    'PR4.1' => ['baslik' => 'Üniversite araştırma fonunca desteklenen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 10],
    'PR4.2' => ['baslik' => 'Üniversite araştırma fonunca desteklenen projede araştırmacılık, danışmanlık ya da bursiyerlik', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 5],

    // ══ B.4 EDİTÖRLÜK ══
    'ED1' => ['baslik' => 'SSCI, SCI-Expanded veya AHCI kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 40],
    'ED2' => ['baslik' => 'ESCI veya alan indeksleri kapsamındaki uluslararası hakemli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 25],
    'ED4' => ['baslik' => 'TR-Dizin kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 15],
    'ED5' => ['baslik' => 'Diğer hakemli dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 10],
    'ED6' => ['baslik' => 'Yayın kurulundaki diğer görevler (haberleşme, dizgi, tashih vb.)', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 3],
    'ED7.1' => ['baslik' => 'Alanında uluslararası yayımlanan kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 25],
    'ED7.2' => ['baslik' => 'Alanında ulusal yayımlanan kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 20],

    // ══ B.5 HAKEMLİK ══
    'HK1' => ['baslik' => 'Hakemli dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 1],

    // ══ B.6 DİĞER BİLİMSEL ETKİNLİKLER ══
    'DB.BURS' => ['baslik' => 'Alanında bilimsel araştırma ve çalışmalar için burs almak', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 2],
    'DB.PATENT.ULUSL' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 100],
    'DB.PATENT.ULUSAL' => ['baslik' => 'Ulusal patent, faydalı model ya da tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili', 'Ticarileştirme'], 'puan' => 50],
    'DB.ODUL.ULUSL' => ['baslik' => 'Alanında uluslararası bilimsel ya da sanatsal nitelikli ödül', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 20],
    'DB.ODUL.ULUSAL' => ['baslik' => 'Alanında ulusal bilimsel ya da sanatsal nitelikli ödül', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 5],
    'DB.BILIRKISI' => ['baslik' => 'Bilirkişilik ya da hukuki mütalaa', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı'], 'puan' => 5],
    'DB.DIGER' => ['baslik' => 'Bilimsel toplantı düzenlemek, sertifika almak, panelistlik ve kurum komisyonu üyeliği gibi diğer bilimsel etkinlikler', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 5],

    // ══ A. EĞİTİM ÖĞRETİM FAALİYETLERİ ══
    'EG1.3' => ['baslik' => 'Tamamlanmış yüksek lisans tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 5],
    'EG1.5' => ['baslik' => 'Tamamlanmış doktora, sanatta yeterlik ya da uzmanlık tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 10],
    'EG6' => ['baslik' => 'Lisansüstü tez savunma jürilerinde görev almak', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 2],
    'EG.KOORD' => ['baslik' => 'Akademik birimlerde koordinatör, temsilci, sorumlu ya da komisyon başkanı olmak (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 2],
    'EG.KOMISYON' => ['baslik' => 'Akademik birimlerdeki ve üniversitedeki komisyon ve kurullarda görev almak (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 1],
    'EG5' => ['baslik' => 'Yarıyılda verilen her bir ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 1],

    // ══ C.1 MESLEKİ FAALİYETLER — KURUM DIŞI GÖREVLER ══
    'MS1.3' => ['baslik' => 'Fakülte veya üniversite onayı ile görevlendirildiği sosyal, kültürel ve bilimsel faaliyetler ile SODES projelerinde görev almak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 1],

    // ══ C.2 SANAT VE TASARIM ETKİNLİKLERİ ══
    // Aynı etikete düşen satırlarda en düşük değer girildi: yurt içi karma
    // sergilerde 5 (grup 15, bienal 10, karma 5), uluslararası ve yurt dışı
    // karma sergilerde 10 (bienal 25, grup 20, karma 10).
    'SN1.1.1' => ['baslik' => 'Yurt içi kişisel sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 25],
    'SN1.2.1' => ['baslik' => 'Yurt dışı kişisel sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Elektronik Kişisel Sergi (Uluslararası)'], 'puan' => 40],
    'SN1.1.6' => ['baslik' => 'Yurt içi grup, bienal, devlet ve karma sergileri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 5],
    'SN1.3.3' => ['baslik' => 'Yurt dışı ve uluslararası grup, bienal ve karma sergileri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Elektronik Karma Sergi (Uluslararası)'], 'puan' => 10],
    'SN1.4' => ['baslik' => 'Uluslararası sanat sempozyumu düzenlemek ya da katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 10],
    'SN1.5' => ['baslik' => 'Ulusal sanat sempozyumu düzenlemek ya da katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 5],
    'SN3.1' => ['baslik' => 'Kumaş, giysi ya da aksesuar koleksiyonu hazırlamak; uzun oyun (sahne, radyo, televizyon, senaryo) yazmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım'], 'puan' => 20],
    'SN3.2.1' => ['baslik' => 'Eserin resmî koleksiyonda yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt İçi)'], 'puan' => 10],
    'SN3.2.2' => ['baslik' => 'Eserin özel koleksiyonda yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Satın Alınması (Yurt İçi)'], 'puan' => 5],
    'SN4' => ['baslik' => 'Tonmaysterlik ya da ses sistemi projesi gerçekleştirmek; ses yayını (kaset, CD)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Albüm / Konser Kaydı'], 'puan' => 15],
    'SN4.b' => ['baslik' => 'Bandrollü kayıt, karma albüm ve eğitim müziği albümü', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bandrollü Kayıt (CD/DVD)', 'Karma Albüm / CD-DVD Katkısı', 'Eğitim Müziği Albümü'], 'puan' => 20],
    'SN5.1' => ['baslik' => 'Sahne yapıtı bestelemek (opera, bale, oratoryo vb.)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera/Bale Kompozisyonu', 'Orkestralı Sahne Eseri'], 'puan' => 20],
    'SN5.2' => ['baslik' => 'Senfonik yapıt bestelemek (senfoni, konçerto vb.)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Küçük Ölçekli Orkestra Eseri'], 'puan' => 20],
    'SN5.3' => ['baslik' => 'Oda müziği, koro ya da solo yapıt bestelemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)'], 'puan' => 15],
    'SN5.4' => ['baslik' => 'Düzenleme, orkestrasyon ve transkripsiyon', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi'], 'puan' => 10],
    'SN5.5' => ['baslik' => 'Elektronik müzik yapıtı bestelemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)'], 'puan' => 15],
    'SN5.6' => ['baslik' => 'Oyun için özgün müzik yapıtı bestelemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne/Ekran Müziği'], 'puan' => 15],
    'SN6' => ['baslik' => 'Uzun metrajlı filmde yönetmenlik, görüntü yönetmenliği ya da senaryo yazarlığı; yurt dışı radyo ve televizyon etkinlikleri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)'], 'puan' => 20],
    'SN7' => ['baslik' => 'Kısa film ve belgesellerde yönetmenlik, görüntü yönetmenliği ya da senaryo yazarlığı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)'], 'puan' => 10],
    'SN8' => ['baslik' => 'Tam uzunlukta oyun sergilemek; yurt içi radyo ve televizyon etkinlikleri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'], 'puan' => 10],
    'SN9' => ['baslik' => 'Televizyon filmi, dizi, televizyon programı ve reklam filminde yönetmenlik ya da metin yazarlığı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Yönetmenlik (Sahne/Ekran)', 'Rejisörlük (Uluslararası)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)'], 'puan' => 5],
    'SN13' => ['baslik' => 'Taşınmaz ya da taşınabilir eski eser restorasyonu', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)'], 'puan' => 10],
    'SN15.1' => ['baslik' => 'Uluslararası kültür sanat gösterileri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Dansçı / Performans İcracısı (Uluslararası)'], 'puan' => 20],
    'SN15.2' => ['baslik' => 'Ulusal kültür sanat gösterileri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Dansçı / Performans İcracısı (Ulusal)'], 'puan' => 10],
    'SN17' => ['baslik' => 'Sanatsal yarışmalarda ve mimarlık yarışmalarında jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 10],
    'SN20' => ['baslik' => 'Oyun, film ya da televizyon programı prodüksiyonunda dekor ve kostüm tasarımı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne Tasarımı (Dekor, Kostüm, Işık)', 'Koreografi'], 'puan' => 10],
    'SN21.1' => ['baslik' => 'Yurt içinde bireysel çalgı konseri ya da resital', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Ulusal)', 'Şan Resitali (Ulusal)'], 'puan' => 20],
    'SN21.4' => ['baslik' => 'Yurt içinde orkestra, oda müziği, koro ya da vokal topluluğu etkinliğinde solistlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Solistlik (Ulusal)', 'Oratoryo/Kantat Solistliği (Ulusal)', 'Opera Birinci Rol (Ulusal)', 'Bale Başrol (Ulusal)'], 'puan' => 10],
    'SN21.5' => ['baslik' => 'Yurt içinde orkestra, oda müziği, koro ya da vokal topluluğu yönetmek (şeflik)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra Şefliği (Ulusal)', 'Koro Şefliği (Ulusal)', 'Opera Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Ulusal)', 'Grup Şefliği (Ulusal)'], 'puan' => 20],
    'SN21.6' => ['baslik' => 'Yurt içinde orkestra ve oda müziği etkinliklerinde çalgı performansı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra / Koro Üyeliği', 'Oda Müziği Grup Üyeliği (Ulusal)', 'Başkemancılık (Ulusal)', 'Corps de Ballet (Ulusal)', 'Bale Solist Rol (Ulusal)', 'Opera İkinci Rol (Ulusal)'], 'puan' => 10],
    'SN22.1' => ['baslik' => 'Yurt dışında bireysel çalgı konseri ya da resital', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Uluslararası)', 'Şan Resitali (Uluslararası)'], 'puan' => 30],
    'SN22.4' => ['baslik' => 'Yurt dışında orkestra, oda müziği, koro ya da vokal topluluğu etkinliğinde solistlik ve şeflik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Solistlik (Uluslararası)', 'Oratoryo/Kantat Solistliği (Uluslararası)', 'Opera Birinci Rol (Uluslararası)', 'Bale Başrol (Uluslararası)', 'Orkestra Şefliği (Uluslararası)', 'Koro Şefliği (Uluslararası)', 'Opera Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Uluslararası)', 'Grup Şefliği (Uluslararası)'], 'puan' => 30],
    'SN22.6' => ['baslik' => 'Yurt dışında orkestra ve oda müziği etkinliklerinde çalgı performansı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Uluslararası)', 'Başkemancılık (Uluslararası)', 'Corps de Ballet (Uluslararası)', 'Bale Solist Rol (Uluslararası)', 'Opera İkinci Rol (Uluslararası)'], 'puan' => 20],
    'SN23.1' => ['baslik' => 'Mimarlık alanında döner sermaye ve resmî kanallardan alınmış projede yürütücülük', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif'], 'puan' => 20],
    'SN23.2' => ['baslik' => 'Mimarlık alanında döner sermaye ve resmî kanallardan alınmış projede ekipte yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman'], 'puan' => 10],
    'SN24' => ['baslik' => 'Mimarlık alanında proje yarışmalarında derece ya da ödül', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 10],

    // ══ D. YÖNETİMSEL FAALİYETLER ══
    'YN1' => ['baslik' => 'Rektör, dekan, enstitü, yüksekokul, konservatuvar ya da meslek yüksekokulu müdürlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Dekan / Enstitü-YO Müdürü'], 'puan' => 10],
    'YN1.y' => ['baslik' => 'Rektör yardımcılığı ile dekan ve müdür yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör Yardımcısı', 'Dekan Yrd. / Müdür Yrd.'], 'puan' => 5],
    'YN2' => ['baslik' => 'Merkez müdürlükleri ve koordinatörlükler', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 5],
    'YN3' => ['baslik' => 'Bölüm başkanlığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 5],
    'YN3.y' => ['baslik' => 'Bölüm başkan yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı'], 'puan' => 2],
];

$kodlar = fn (string ...$onekler): array => array_values(array_filter(
    array_keys($maddeler),
    fn (string $kod): bool => array_reduce($onekler, fn (bool $t, string $o): bool => $t || str_starts_with($kod, $o), false)
));

/** "Makaleler" başlığının özgün makale satırları (madde numarasına göre). */
$ozgunMakale = fn (string ...$onekler): array => $kodlar(...$onekler);

$MAKALE = $kodlar('MK');
$KITAP = $kodlar('KT');
$BILDIRI = $kodlar('BD');
$ATIF = $kodlar('AT');
$PROJE = $kodlar('PR');
$SANAT = $kodlar('SN');
$MESLEKI = [...$kodlar('MS'), ...$SANAT];
$DERS = ['EG5'];
$PUAN = [...$MAKALE, ...$KITAP, ...$BILDIRI, ...$ATIF, ...$PROJE];

return [
    'kapsam_notu' => 'Puanlar Erzincan Binali Yıldırım Üniversitesi Performans Değerlendirme '
        .'Sisteminden (2021; 28.08.2025 tarihli YÖK Genel Kurul kararıyla değişik). Makale, '
        .'kitap ve bildirilerde puan yazar katkı katsayısı ile çarpılıyor: tek yazarlı eserde '
        .'1,0; iki yazarlıda 0,9 ve 0,8; üç yazarlıda 0,8, 0,7 ve 0,6; dört ve daha fazla '
        .'yazarlıda 0,7, 0,6, 0,5 ve dördüncüden sonrası için 0,4. Sorumlu yazar birinci yazar '
        .'katsayısına tabi. Yazar listesini boş bırakırsanız katsayı uygulanmaz ve puanınız '
        .'olduğundan yüksek görünür. SCI-Expanded, SSCI ve AHCI makalelerinde derginin Q dilimi '
        .'puanı çarpıyor (Q1 ×2,00 ile 80 puana kadar); bu çarpan satır puanlarına gömüldü. '
        .'Atıflarda en fazla 30, hakemliklerde 20, yönetimsel faaliyetlerde 20 puan sayılıyor. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: ondalıklı satırlar (lisans '
        .'danışmanlığı 0,05; sınav gözetmenliği 0,1; TR-Dizin atfı 0,8; diğer ulusal dergi atfı '
        .'0,5) motorun tam sayı puanına sığmadığı için girilmedi; C.3 Spor Etkinlikleri '
        .'bölümünün tamamı ile küratörlük, festival, arkeolojik kazı ve el sanatları belge '
        .'çözümlemesi satırlarının faaliyet kaydında karşılığı yok; hakemlik, editörlük, bildiri '
        .'özeti, kurul üyeliği ve pek çok sanat satırı aynı kaynak etiketine düştüğü için en '
        .'düşük değerden sayılıyor. Puanınız şu kalemde OLDUĞUNDAN YÜKSEK görünür: tekrar '
        .'baskısı yapılmış kitap, tezden üretilmiş kitap, devam eden proje, konuk editörlük ve '
        .'tekrarlanan sanat etkinliği için yönergenin öngördüğü yarım puan uygulanamıyor.',

    // "Yazar Katkı Katsayıları" tablosu: satır = toplam yazar sayısı,
    // sütun = adayın sırası. Sorumlu yazar 1. yazar katsayısına tabi.
    // Atıf puanlamasında kişi sayısı dikkate alınmıyor (Madde 4/e).
    'yazar_katsayisi' => [
        'haric' => ['atif', 'editorluk', 'proje', 'patent', 'tez_danismanligi', 'tez_yayini',
            'egitim_ogretim', 'idari_gorev', 'toplumsal_katki', 'odul', 'sanatsal_etkinlik', 'diger'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.80], 'sonrasi' => 0.70],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.80], 'sonrasi' => 0.70],
            'yazar_2' => ['kademeler' => [2 => 0.80, 3 => 0.70], 'sonrasi' => 0.60],
            'yazar_3' => ['kademeler' => [3 => 0.60], 'sonrasi' => 0.50],
            'ortak' => ['sonrasi' => 0.40],
        ],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        // Madde 5, 6 ve 8'in "Makaleler başlığı altında … maddelerde
        // tanımlanan dergilerde özgün makale" koşulları.
        'MAKALE-1' => $ozgunMakale('MK1a'),
        'MAKALE-1-2' => $ozgunMakale('MK1a', 'MK2a'),
        'MAKALE-1-4' => $ozgunMakale('MK1a', 'MK2a', 'MK3a', 'MK4a'),
        'MAKALE-1-5' => $ozgunMakale('MK1a', 'MK2a', 'MK3a', 'MK4a', 'MK5a'),
        // Profesörlükte koşul "özgün makale" değil "yayın" olduğu için
        // derleme ve kısa makale satırları da sayılıyor.
        'MAKALE-1-TUM' => $kodlar('MK1'),
        'MAKALE-2-TUM' => $kodlar('MK2'),
        'MAKALE-1-4-TUM' => $kodlar('MK1', 'MK2', 'MK3', 'MK4'),
        // "Makaleler, Kitap-Kitap Bölümleri, Bildiriler, Atıflar ve Projeler".
        'PUAN' => $PUAN,
        // Spor Bilimlerinde aynı küme "Mesleki Faaliyetler" ile birlikte
        // değerlendiriliyor (C bölümü; C.3 Spor Etkinlikleri girilemedi).
        'PUAN-MESLEKI' => [...$PUAN, ...$MESLEKI],
        // Madde 6/d'nin "ders kitabı niteliği dışındaki özgün bilimsel
        // kitap" alternatifi.
        'KITAP-OZGUN' => ['KT1.1', 'KT1.2.1'],
        // Güzel Sanatlarda ayrıca "Sanat ve Tasarım Etkinlikleri" barajı var.
        'SANAT' => $SANAT,
        // "Dersler başlığı dışındaki tüm faaliyetler".
        'TUM-DERS-HARIC' => array_values(array_diff(array_keys($maddeler), $DERS)),
        // Tavan grupları.
        'ATIF' => $ATIF,
        'HAKEMLIK' => ['HK1'],
        'IDARI' => $kodlar('YN'),
    ],

    'grup_tavanlari' => [
        'ATIF' => 30,
        'HAKEMLIK' => 20,
        'IDARI' => 20,
    ],
];
