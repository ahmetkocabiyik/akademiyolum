<?php

/**
 * TEKİRDAĞ NAMIK KEMAL ÜNİVERSİTESİ — EK-2 Akademik, Bilimsel ve İdari
 * Faaliyet Puanlama Cetveli
 * Kaynak: pdf/17537009192.tekirdagnamikkemaluniverstesi.pdf (19 sayfa, 2024)
 *
 * KAYNAK PDF TARANMIŞ (Canon iR-ADV); 300 dpi görüntüden `tesseract -l tur`
 * ile okundu, PUAN sütununun tamamı sayfa görüntüsünün sağ şeridi kırpılıp
 * GÖZLE DOĞRULANDI. OCR üç satırda yanlış okumuştu ve üçü de kritikti:
 *   1.6 TR Dizin makalesi 3 değil 13; 2.4 BKCI kitap bölümü 20 değil 25;
 *   12.4 TÜBİTAK büyük projede görev alma 75 değil 25.
 * Puan sütununu gözle doğrulamadan bu cetvel üç yerde yanlış olurdu.
 *
 * ÇEYREK ÇARPANI SATIRA GÖMÜLDÜ. 1.1 ve 1.3 "makalenin puanı Q1 ise 2 katı,
 * Q2 ise 1,5 katı, Q3 ise 1,25 katı, Q4 ise aynıdır" diyor; 4.1 editörlük
 * satırında da aynı kural var (Q2 için 1,35). Çarpım ham puan üzerinden bir
 * kez yapılıp AŞAĞI yuvarlandı (§0):
 *   1.1  Q1 50 · Q2 37 · Q3 31 · Q4 25            (25 × 2 / 1,5 / 1,25 / 1)
 *   1.3  Q1 30 · Q2 22 · Q3 18 · Q4 15            (15 × …)
 *   4.1  Q1 30 · Q2 20 · Q3 18 · Q4 15            (15 × 2 / 1,35 / 1,25 / 1)
 * AHCI dergilerinin çeyreği olmadığı için AHCI satırları ham puandan sayılır.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR (§0) ──
 *   1.8 (TR Dizin dışı ulusal hakemli 2) ile 1.10 (ulusal hakemli 1) tek
 *       "Diğer Ulusal Hakemli" etiketine düşüyor → 1.
 *   2.2 (tanınmış uluslararası yayınevi kitabı 40) ile 2.3 (ulusal 15) tek
 *       "Uluslararası/Ulusal Kitap" etiketine düşüyor → 15. BKCI kitabı (2.1,
 *       45) ayrı etiketi olduğu için tam değerinden sayılıyor.
 *   2.9 (uluslararası kitap çevirisi 20) ile 2.11 (ulusal 8) → 8;
 *       2.10 (uluslararası bölüm çevirisi 10) ile 2.12 (ulusal 5) → 5.
 *   2.7 (yabancı üniversite ders kitabı 30) ile 2.8 (ulusal 20) → 20.
 *   3.3 (uluslararası özet 6) ile 3.4 (poster 5) → 5; 3.7 ile 3.8 → 3.
 *   3.9 (uluslararası ansiklopedi maddesi 5) ile 3.10 (ulusal 3) → 3.
 *   4.3-4.7 arasındaki beş editörlük kademesi (8/5/2/5/3) kayıtta yalnız iki
 *       etiket taşıyor: TR Dizin dergisi 5'ten, ötekiler 2'den (4.5).
 *   4.9 (uluslararası kitap editörlüğü 20) ile 4.10 (ulusal 10) → 10.
 *   4.11 (WoS/ESCI yayın kurulu 5) ile 4.12 (diğer 3) → 3.
 *   5.1 (WoS atfı 5) ile 5.2 (ESCI/Scopus atfı 3) tek "WoS / Scopus"
 *       etiketine düşüyor → 3.
 *   5.7 (uluslararası kitapta atıf 5) ile 5.8 (ulusal 3) → 3.
 *   6. BÖLÜMÜN TAMAMI tek "Hakemlik" etiketine düşüyor (5/5/4/3/3/2/2/2/1/3/5)
 *       → en düşükten, 1.
 *   7.6-7.9 sanat ve tasarım yarışma jüri üyeliği 15/8/10/5: uluslararası
 *       kademe 8'den (7.7), ulusal 5'ten (7.9).
 *   8.4-8.7 uygulanan mimari proje 20/10/8/5 → 5.
 *   8.15-8.23 TV, reklam ve program satırları (20'den 5'e) → 5.
 *   11.2 (ulusal patent 35) ile 11.7 (ulusal incelemesiz patent 15) → 15.
 *   11.3 (uluslararası faydalı model/çeşit tescili 30) ile 11.4 (ulusal 15)
 *       → 15; 11.5 (uluslararası tasarım tescili 20) ile 11.6 (ulusal 10) → 10.
 *   12.3-12.6 TÜBİTAK satırları (30/25 ve 20/10) → 20/10.
 *   14.1-14.6 yarışma dereceleri (50/40/40/25/40/20) → 20.
 *   16.2 (uluslararası burs 5) ile 16.3 (ulusal 3) → 3.
 *   17.3 tez jürisi "doktorada tam, yüksek lisansta yarı puan" (7) → 3.
 *   9. bölümde uluslararası/ulusal ayrımı taşımayan etiketler daima ULUSAL
 *       satırdan sayılıyor (kişisel sergi 10, karma sergi 5, gösteri 10,
 *       sahne tasarımı 15, dinleti 10, icracılık 5).
 *
 * ── GİRİLMEYEN BÖLÜMLER ──
 *   10. SPORTİF ETKİNLİKLERİN TAMAMI (17 satır, 25 puana kadar): hakemlik,
 *       antrenörlük, millî takım görevi ve federasyon kurulu üyeliğinin
 *       kayıtta karşılığı yok. Spor Bilimleri adayının toplamı düşük çıkar.
 *   13. ÇALIŞTAY, KONGRE, SEMPOZYUM, WORKSHOP BÖLÜMÜNÜN TAMAMI (12 satır,
 *       10 puana kadar): toplantı yöneticiliği, düzenleme kurulu üyeliği ve
 *       küratörlük kayıtta yok.
 *   15. KAZI ÇALIŞMALARININ TAMAMI (7 satır, 15 puana kadar).
 *   7.1-7.5 panelistlik ve panel yöneticiliği (15 puana kadar).
 *   5.9 h-indeks (her puan için 5), 5.10-5.11 adayın adıyla anılan formül ve
 *       şekiller, 16.1 yurt dışı deneyimi (5), 19.1 yabancı dil puanı (10).
 *   1.7 "diğer uluslararası hakemli dergi" (3): "Diğer Uluslararası İndeks"
 *       etiketi 1.5'e bağlandığı için karşılıksız kaldı.
 *   3.11-3.14 sanat ve Türk-İslam sanatları alanında rapor, deneme, katalog
 *       yazarlığı (5/3); 8.1-8.3 plan ve proje sergileme (8/6/5); 8.24-8.25
 *       film festivaline katılım (30/20); 9.24-9.26 oyun yazarlığı ve metin
 *       uyarlaması (20/10/10); 12.7-12.8 teknoloji geliştirme bölgesi
 *       projeleri (10/5); 18.6-18.10 üniversite içi dergi, danışmanlık ve
 *       komisyon satırlarının bir bölümü.
 *   BESTE VE KOMPOZİSYON KALEMLERİ: EK-2'nin 9. bölümü icrayı sayıyor ama
 *       ESER BESTELEMEYE hiç satır ayırmıyor. Senfoni, konçerto, oda müziği,
 *       sahne müziği ve düzenleme kayıtları bu yüzden hiç puan almıyor —
 *       eksik olan bizim eşlememiz değil, yönergenin kendi tablosu.
 *
 * ── YAZAR ÇARPANI (Madde 8) ──
 * Yazar sayısı × sıra matrisi; "Sorumlu Yazar" ve "Senyör Yazar" birinci
 * isimle aynı sayıldığı için `baslica` ile `ilk` aynı satırı alıyor. Atıf,
 * proje, tez danışmanlığı, ders, editörlük-hakemlik ve idari görev dışarıda;
 * bunların satırları zaten kişi başına. Ödüller matrise DÂHİL, çünkü 14.9-14.12
 * "ekibin aldığı ödüller paylaştırılır" diyor.
 *
 * Yönerge: yonerge/tekirdag.php
 */
$OZGUN = ['ozgun_makale'];
$DERLEME = ['derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];
$WOS = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];

$maddeler = [
    // ══ 1. MAKALE ══
    '1.1-Q1' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamında Q1 dilimli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $OZGUN, 'puan' => 50],
    '1.1-Q2' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamında Q2 dilimli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $OZGUN, 'puan' => 37],
    '1.1-Q3' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamında Q3 dilimli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $OZGUN, 'puan' => 31],
    '1.1-Q4' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamında Q4 dilimli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $OZGUN, 'puan' => 25],
    '1.1-A' => ['baslik' => 'AHCI kapsamındaki dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => $OZGUN, 'puan' => 25],
    '1.2' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergide teknik not, editöre mektup, vaka takdimi, araştırma notu, tahkik, neşir, transkripsiyon, kitap eleştirisi ya da çeviri', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $KISA, 'puan' => 10],
    '1.3-Q1' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamında Q1 dilimli dergide derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $DERLEME, 'puan' => 30],
    '1.3-Q2' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamında Q2 dilimli dergide derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $DERLEME, 'puan' => 22],
    '1.3-Q3' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamında Q3 dilimli dergide derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $DERLEME, 'puan' => 18],
    '1.3-Q4' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamında Q4 dilimli dergide derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $DERLEME, 'puan' => 15],
    '1.3-A' => ['baslik' => 'AHCI kapsamındaki dergide derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => $DERLEME, 'puan' => 15],
    '1.4' => ['baslik' => 'ESCI, Scopus ya da ÜAK tarafından tanımlanan uluslararası endeksli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $OZGUN, 'puan' => 15],
    '1.5' => ['baslik' => 'Diğer uluslararası endeksli hakemli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $OZGUN, 'puan' => 9],
    '1.6' => ['baslik' => 'TR Dizin tarafından taranan ulusal hakemli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $OZGUN, 'puan' => 13],
    '1.9' => ['baslik' => 'ESCI, uluslararası endeksli hakemli ya da TR Dizin dergisinde derleme, teknik not, editöre mektup, vaka takdimi, kitap eleştirisi ya da çeviri', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks', 'TR Dizin'], 'turler' => [...$DERLEME, ...$KISA], 'puan' => 3],
    '1.10' => ['baslik' => 'Ulusal hakemli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $OZGUN, 'puan' => 1],
    '1.11' => ['baslik' => 'TR Dizin kapsamı dışındaki dergide derleme, teknik not, editöre mektup, vaka takdimi, kitap eleştirisi ya da çeviri', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => [...$DERLEME, ...$KISA], 'puan' => 1],

    // ══ 2. KİTAP VE KİTAP BÖLÜMÜ ══
    '2.1' => ['baslik' => 'BKCI kapsamında kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 45],
    '2.3' => ['baslik' => 'Tanınmış yayınevi ya da üniversite tarafından yayımlanmış özgün bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 15],
    '2.4' => ['baslik' => 'BKCI kapsamında kitap bölümü yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 25],
    '2.6' => ['baslik' => 'Tanınmış yayınevi ya da üniversite tarafından yayımlanmış özgün bilimsel kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 10],
    '2.8' => ['baslik' => 'Üniversite tarafından yayımlanmış ders kitabı yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 20],
    '2.11' => ['baslik' => 'Tanınmış yayınevi ya da üniversite tarafından yayımlanmış kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 8],
    '2.12' => ['baslik' => 'Tanınmış yayınevi ya da üniversite tarafından yayımlanmış kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 5],
    '2.13' => ['baslik' => 'Tahkik, neşir, transkripsiyon ya da sadeleştirme eseri', 'kategori' => 'kitap', 'kaynaklar' => ['Tahkik (Tenkitli Metin)'], 'puan' => 15],

    // ══ 3. BİLDİRİ, ANSİKLOPEDİ MADDESİ VE DİĞER YAZARLIKLAR ══
    '3.1' => ['baslik' => 'CPCI kapsamındaki uluslararası toplantıda sunulan ve bildiriler kitabında tam metin yayımlanan tebliğ', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 15],
    '3.2' => ['baslik' => 'Hakemli uluslararası toplantıda sözlü sunulan ve tam metni yayımlanan tebliğ', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin'], 'puan' => 12],
    '3.4' => ['baslik' => 'Hakemli uluslararası toplantıda özet metinle ya da poster olarak sunulan tebliğ', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 5],
    '3.5' => ['baslik' => 'Hakemli toplantıda davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 8],
    '3.6' => ['baslik' => 'Hakemli ulusal toplantıda sözlü sunulan ve tam metni yayımlanan tebliğ', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 6],
    '3.8' => ['baslik' => 'Hakemli ulusal toplantıda özet metinle ya da poster olarak sunulan tebliğ', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 3],
    '3.10' => ['baslik' => 'Ansiklopedide madde yazarlığı (her madde için)', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 3],

    // ══ 4. EDİTÖRLÜK (en fazla 40 puan) ══
    '4.1-Q1' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamında Q1 dilimli dergide editörlük (her yıl için)', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)'], 'puan' => 30],
    '4.1-Q2' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamında Q2 dilimli dergide editörlük (her yıl için)', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q2)'], 'puan' => 20],
    '4.1-Q3' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamında Q3 dilimli dergide editörlük (her yıl için)', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q3)'], 'puan' => 18],
    '4.1-Q4' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamında Q4 dilimli dergide editörlük (her yıl için)', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q4)'], 'puan' => 15],
    '4.2' => ['baslik' => 'ESCI ya da Scopus kapsamındaki dergide editörlük (her yıl için)', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 10],
    '4.5' => ['baslik' => 'Ulusal ya da diğer uluslararası dergide editörlük (her yıl için)', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 2],
    '4.6' => ['baslik' => 'TR Dizin tarafından taranan ulusal hakemli dergide editörlük (her yıl için)', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 5],
    '4.8' => ['baslik' => 'BKCI kapsamındaki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 25],
    '4.10' => ['baslik' => 'Tanınmış yayınevi ya da üniversite tarafından yayımlanmış özgün bilimsel kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 10],
    '4.12' => ['baslik' => 'Dergide yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 3],

    // ══ 5. ATIF (en fazla 50 puan) ══
    '5.2' => ['baslik' => 'SCI, SCI-Expanded, SSCI, AHCI, ESCI ya da Scopus kapsamındaki dergilerde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
    '5.5' => ['baslik' => 'TR Dizin tarafından taranan dergilerde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
    '5.6' => ['baslik' => 'Diğer hakemli dergilerde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],
    '5.8' => ['baslik' => 'Tanınmış yayınevi ya da üniversite tarafından yayımlanmış özgün bilimsel kitapta eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 3],
    '5.13' => ['baslik' => 'Güzel sanatlar, mimarlık, planlama ve tasarım alanındaki eserinizin kaynak ya da yayın organlarında yer alması, gösterime veya dinletime girmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Haber Olması (Uluslararası)', 'Eserin Haber Olması (Ulusal)'], 'puan' => 3],

    // ══ 6. HAKEMLİK (en fazla 20 puan) ══
    '6.10' => ['baslik' => 'Dergi, kitap, proje ya da bilimsel toplantı hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 1],

    // ══ 7. PANELİST VE JÜRİ ÜYELİĞİ (en fazla 20 puan) ══
    '7.7' => ['baslik' => 'Yurt dışındaki uluslararası yarışmalarda jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], 'puan' => 8],
    '7.9' => ['baslik' => 'Yurt içindeki ulusal yarışmalarda jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)', 'Masterclass (Uluslararası)', 'Masterclass (Ulusal)'], 'puan' => 5],

    // ══ 8. TV-SİNEMA-TASARIM ══
    '8.7' => ['baslik' => 'Kamu kurumu ya da özel sektör tarafından uygulanan mimarlık temel alanıyla ilgili plan, tasarım ve proje', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman'], 'puan' => 5],
    '8.8' => ['baslik' => 'Uygulanmış görsel kimlik, grafik, medya, ürün ya da çevresel tasarım çalışması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım'], 'puan' => 7],
    '8.12' => ['baslik' => 'Kısa film ya da belgesel çalışmasında yönetmenlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Yönetmenlik (Sahne/Ekran)'], 'puan' => 10],
    '8.13' => ['baslik' => 'Kısa film ya da belgesel çalışmasında görüntü yönetmenliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)'], 'puan' => 7],
    '8.19' => ['baslik' => 'Ulusal televizyon programı, film, dizi ya da reklam filminde görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'], 'puan' => 5],

    // ══ 9. SANAT VE TASARIM ══
    '9.1' => ['baslik' => 'Yurt dışında müze, kültür merkezi, sanat galerisi ya da üniversite mekânında açılan kişisel sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)'], 'puan' => 20],
    '9.2' => ['baslik' => 'Yurt içinde müze, kültür merkezi, sanat galerisi ya da üniversite mekânında açılan kişisel sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 10],
    '9.3' => ['baslik' => 'Uluslararası karma sergi kataloğu, dergi ya da kitapta özgün sanat veya tasarım eserinizin yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Elektronik Karma Sergi (Uluslararası)'], 'puan' => 8],
    '9.4' => ['baslik' => 'Yurt içindeki uluslararası karma sergi kataloğu, dergi ya da kitapta özgün sanat veya tasarım eserinizin yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt İçi, Uluslararası Jürili)'], 'puan' => 6],
    '9.5' => ['baslik' => 'Ulusal karma sergi kataloğu, dergi ya da kitapta özgün sanat veya tasarım eserinizin yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 5],
    '9.6' => ['baslik' => 'Eserinizin, tasarımınızın ya da projenizin yurt dışında müzeye veya koleksiyona kabul edilmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)'], 'puan' => 30],
    '9.7' => ['baslik' => 'Eserinizin, tasarımınızın ya da projenizin yurt içinde müzeye veya koleksiyona kabul edilmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)'], 'puan' => 15],
    '9.8' => ['baslik' => 'Eserinizin yurt içinde müze, kamusal alan, galeri ya da büyük koleksiyonda yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)'], 'puan' => 10],
    '9.13' => ['baslik' => 'Ulusal gösteri (görsel-işitsel tasarım) ya da defile', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Dansçı / Performans İcracısı (Uluslararası)', 'Dansçı / Performans İcracısı (Ulusal)'], 'puan' => 10],
    '9.16' => ['baslik' => 'Sahne tasarımıyla ilgili etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne Tasarımı (Dekor, Kostüm, Işık)', 'Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)'], 'puan' => 15],
    '9.19a' => ['baslik' => 'Gösteri, temsil ya da koreografi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koreografi', 'Tüm Perde Koreograflığı (Uluslararası)', 'Tüm Perde Koreograflığı (Ulusal)', 'Bölüm Koreograflığı (Uluslararası)', 'Bölüm Koreograflığı (Ulusal)', 'Bale/Dans Koreograflığı (Uluslararası)', 'Bale/Dans Koreograflığı (Ulusal)'], 'puan' => 15],
    '9.19b' => ['baslik' => 'Gösteride solo dans', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bale Başrol (Uluslararası)', 'Bale Başrol (Ulusal)', 'Bale Solist Rol (Uluslararası)', 'Bale Solist Rol (Ulusal)'], 'puan' => 10],
    '9.19c' => ['baslik' => 'Gösteride grup dansı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Corps de Ballet (Uluslararası)', 'Corps de Ballet (Ulusal)'], 'puan' => 5],
    '9.21' => ['baslik' => 'Seçkin tiyatro kurumlarında önemli rol oynamak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera Birinci Rol (Uluslararası)', 'Opera Birinci Rol (Ulusal)', 'Opera İkinci Rol (Uluslararası)', 'Opera İkinci Rol (Ulusal)', 'Oratoryo/Kantat Solistliği (Uluslararası)', 'Oratoryo/Kantat Solistliği (Ulusal)'], 'puan' => 10],
    '9.23' => ['baslik' => 'Oyun sahnelemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisörlük (Uluslararası)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Rejisör Yardımcılığı (Uluslararası)', 'Rejisör Yardımcılığı (Ulusal)', 'Rejisör Yardımcılığı (Konservatuvar)', 'Sahneleme/Repetitörlük — Tüm Perde (Uluslararası)', 'Sahneleme/Repetitörlük — Tüm Perde (Ulusal)', 'Sahneleme/Repetitörlük — Bölüm (Uluslararası)', 'Sahneleme/Repetitörlük — Bölüm (Ulusal)'], 'puan' => 10],
    '9.27' => ['baslik' => 'Yurt dışında kültür merkezi, sanat galerisi ya da üniversite mekânında verilen bireysel dinleti', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Uluslararası)', 'Şan Resitali (Uluslararası)', 'Solistlik (Uluslararası)'], 'puan' => 15],
    '9.28' => ['baslik' => 'Yurt içinde kültür merkezi, sanat galerisi ya da üniversite mekânında verilen dinleti', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Ulusal)', 'Şan Resitali (Ulusal)', 'Solistlik (Ulusal)', 'Oda Müziği Grup Üyeliği (Uluslararası)', 'Oda Müziği Grup Üyeliği (Ulusal)', 'Eğitici Konser Programı (Uluslararası)', 'Eğitici Konser Programı (Ulusal)', 'Eğitim Amaçlı Sanat Etkinliği', 'Müzikoloji Atölyesi'], 'puan' => 10],
    '9.30' => ['baslik' => 'Kurum, kuruluş ya da etkinliklerde çalgı veya ses icracısı olarak görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra / Koro Üyeliği', 'Başkemancılık (Uluslararası)', 'Başkemancılık (Ulusal)', 'Grup Şefliği (Uluslararası)', 'Grup Şefliği (Ulusal)'], 'puan' => 5],
    '9.31' => ['baslik' => 'Alanında koro ya da orkestra şefliği veya yöneticiliği yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra Şefliği (Uluslararası)', 'Orkestra Şefliği (Ulusal)', 'Koro Şefliği (Uluslararası)', 'Koro Şefliği (Ulusal)', 'Opera Şefliği (Uluslararası)', 'Opera Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Ulusal)'], 'puan' => 15],
    '9.32' => ['baslik' => 'Ses ya da çalgı icrasının CD\'ye aktarılmış stüdyo kaydı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Albüm / Konser Kaydı', 'Karma Albüm / CD-DVD Katkısı', 'Bandrollü Kayıt (CD/DVD)'], 'puan' => 7],

    // ══ 11. PATENTLER VE GİRİŞİMLER ══
    '11.1' => ['baslik' => 'Uluslararası patent ve marka kurumlarına kayıtlı patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 50],
    '11.7' => ['baslik' => 'Türk Patent ve Marka Kurumuna kayıtlı patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 15],
    '11.4' => ['baslik' => 'Faydalı model ya da çeşit tescili', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 15],
    '11.6' => ['baslik' => 'Tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım', 'Yazılım'], 'puan' => 10],
    '11.8' => ['baslik' => 'Teknoloji Geliştirme Bölgesinde firma sahibi ya da ortağı olmak', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 15],

    // ══ 12. PROJELER (tamamlanmış olmalıdır) ══
    '12.1' => ['baslik' => 'AB destekli bilimsel projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 50],
    '12.2' => ['baslik' => 'AB destekli bilimsel projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 35],
    '12.5' => ['baslik' => 'TÜBİTAK projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 20],
    '12.6' => ['baslik' => 'TÜBİTAK projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
    '12.9' => ['baslik' => 'Uluslararası üniversite ya da yabancı kamu kuruluşlarınca desteklenen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 20],
    '12.10' => ['baslik' => 'Uluslararası üniversite ya da yabancı kamu kuruluşlarınca desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
    '12.11' => ['baslik' => 'Yükseköğretim kurumunca desteklenen bilimsel araştırma projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 10],
    '12.12' => ['baslik' => 'Yükseköğretim kurumunca desteklenen bilimsel araştırma projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 5],
    '12.13' => ['baslik' => 'Kamu kurum ve kuruluşlarınca desteklenen bilimsel projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 20],
    '12.14' => ['baslik' => 'Kamu kurum ve kuruluşlarınca desteklenen bilimsel projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],

    // ══ 14. ÖDÜLLER ══
    '14.6' => ['baslik' => 'Sanat, tasarım, planlama ya da mimarlık yarışmasında derece, mansiyon veya jüri özel ödülü almak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 20],
    '14.9' => ['baslik' => 'Yurt dışı kurum ve kuruluşlarca verilen bilim, sanat ya da kültür ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 40],
    '14.11' => ['baslik' => 'Yurt içi kurum ve kuruluşlarca verilen bilim, sanat ya da kültür ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 20],

    // ══ 16. YURT DIŞI DENEYİMİ VE BURSLAR ══
    '16.3' => ['baslik' => 'Bilimsel ya da sanatsal amaçlı burs (her burs için)', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 3],

    // ══ 17. EĞİTİM-ÖĞRETİM FAALİYETLERİ ══
    '17.1' => ['baslik' => 'Yönetiminizde tamamlanan doktora, tıpta ya da diş hekimliğinde uzmanlık tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 12],
    '17.1e' => ['baslik' => 'İkinci danışman olduğunuz tamamlanmış doktora ya da uzmanlık tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 6],
    '17.2' => ['baslik' => 'Yönetiminizde tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 8],
    '17.2e' => ['baslik' => 'İkinci danışman olduğunuz tamamlanmış yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 4],
    '17.3' => ['baslik' => 'Tez jürisi ya da tez izleme komitesinde görev almak', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 3],
    '17.4' => ['baslik' => 'Ön lisans, lisans ya da lisansüstü ders (son üç yılda her dönem için)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 5],

    // ══ 18. İDARİ GÖREVLER ══
    '18.1' => ['baslik' => 'Rektörlük ya da rektör yardımcılığı (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı'], 'puan' => 15],
    '18.2' => ['baslik' => 'Dekanlık, başhekimlik, enstitü, yüksekokul, konservatuvar ya da meslek yüksekokulu müdürlüğü (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü'], 'puan' => 10],
    '18.3' => ['baslik' => 'Senato üyeliği, dekan yardımcılığı, müdür yardımcılığı ya da merkez müdürlüğü (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Senato / Üniversite Yönetim Kurulu Üyesi', 'Dekan Yrd. / Müdür Yrd.', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 5],
    '18.4' => ['baslik' => 'Bölüm başkanlığı (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 4],
    '18.5' => ['baslik' => 'Bölüm başkan yardımcılığı, anabilim dalı başkanlığı, komisyon ya da kurul üyeliği, koordinatörlük (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük', 'Kurul / Komisyon Üyeliği'], 'puan' => 3],
    '10.7' => ['baslik' => 'Uluslararası spor federasyonunun yönetim, teknik, eğitim ya da hakem kurulunda görev', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Spor Federasyonu Kurul Üyeliği (Uluslararası)'], 'puan' => 15],
    '10.12' => ['baslik' => 'Ulusal spor federasyonunun yönetim, teknik, eğitim ya da hakem kurulunda görev', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Spor Federasyonu Kurul Üyeliği (Ulusal)'], 'puan' => 5],
];

/** EK-1'in "PUAN-1" kapsamı: EK-2'nin (1).1, 2, 3, 4, 5, 6 maddeleri. */
$PUAN1 = ['1.1-Q1', '1.1-Q2', '1.1-Q3', '1.1-Q4', '1.1-A', '1.2',
    '1.3-Q1', '1.3-Q2', '1.3-Q3', '1.3-Q4', '1.3-A', '1.4', '1.5', '1.6'];

return [
    'kapsam_notu' => 'Puanlar Tekirdağ Namık Kemal Üniversitesi Öğretim Üyeliği Kadrolarına '
        .'Başvuru İçin Gerekli Koşullar ve Uygulama Esasları Yönergesinin EK-2 Faaliyet '
        .'Puanlama Cetvelinden (2024). Kaynak PDF taranmış; OCR ile okundu, puan sütunu gözle '
        .'doğrulandı. SCI, SSCI ve AHCI makalelerinde ÇEYREK ÇARPANI uygulanıyor: Q1 iki katı, '
        .'Q2 bir buçuk katı, Q3 bir çeyrek katı; AHCI dergilerinin çeyreği olmadığı için ham '
        .'puandan sayılır. Çok yazarlı eserlerde puan Madde 8\'in yazar sayısı × sıra matrisine '
        .'göre bölünüyor; sorumlu yazar ve senyör yazar birinci isimle aynı sayılıyor. Yazar '
        .'listesini boş bırakırsanız en düşük satır uygulanır. '
        .'PUANINIZ ŞU KALEMLERDE OLDUĞUNDAN DÜŞÜK GÖRÜNÜR: SPORTİF ETKİNLİKLER bölümünün '
        .'tamamı (17 satır, 25 puana kadar), ÇALIŞTAY-KONGRE-SEMPOZYUM bölümünün tamamı '
        .'(12 satır), KAZI ÇALIŞMALARININ tamamı (7 satır), panelistlik ve panel yöneticiliği, '
        .'h-indeks, yurt dışı deneyimi ve yabancı dil puanı kayıtta karşılıksız kaldı. '
        .'Bestecilik kalemleri de puan almıyor: yönergenin sanat bölümü icrayı sayıyor ama '
        .'ESER BESTELEMEYE hiç satır ayırmamış. Aynı etikete düşen satırlarda daima düşüğü '
        .'sayılıyor; en çok kaybettiren üçü hakemlik (5 yerine 1), atıf (5 yerine 3) ve '
        .'uluslararası yayınevi kitabı (40 yerine 15). Editörlük 40, atıf 50, hakemlik 20 ve '
        .'jüri üyeliği 20 puanlık tavanlarıyla uygulanıyor. '
        .'PUANINIZ ŞU KALEMDE OLDUĞUNDAN YÜKSEK GÖRÜNEBİLİR: yönergenin "son üç yılda her '
        .'dönem için" dediği ders puanı satır bazlı zaman penceresi olmadığı için eski '
        .'dersleriniz de sayılıyor; idari görev puanları da görev süresiyle çarpılmıyor.',

    'yazar_katsayisi' => [
        'haric' => ['atif', 'proje', 'tez_danismanligi', 'egitim_ogretim', 'editorluk',
            'idari_gorev', 'toplumsal_katki', 'diger'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 1.00, 3 => 0.90, 4 => 0.85, 5 => 0.80], 'sonrasi' => 0.75],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 1.00, 3 => 0.90, 4 => 0.85, 5 => 0.80], 'sonrasi' => 0.75],
            'yazar_2' => ['kademeler' => [2 => 0.90, 3 => 0.80, 4 => 0.75, 5 => 0.70], 'sonrasi' => 0.65],
            'yazar_3' => ['kademeler' => [3 => 0.70, 4 => 0.65, 5 => 0.60], 'sonrasi' => 0.55],
            'yazar_4' => ['kademeler' => [4 => 0.55, 5 => 0.50], 'sonrasi' => 0.45],
            'yazar_5' => ['kademeler' => [5 => 0.40], 'sonrasi' => 0.35],
            'yazar_6' => ['sonrasi' => 0.25],
            'ortak' => ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.70, 4 => 0.55, 5 => 0.40], 'sonrasi' => 0.25],
        ],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        'TUM' => array_keys($maddeler),
        // EK-1'in PUAN-1 kapsamı.
        'PUAN1' => $PUAN1,
        // Dipnot (e): ALAN-1 adayının PUAN-1 yayınlarından en az biri (1).1 kapsamında olmalı.
        'SCI-MAKALE' => ['1.1-Q1', '1.1-Q2', '1.1-Q3', '1.1-Q4', '1.1-A'],
        // Dipnot (b): bir adet Q1, Q2 ya da Q3 yayın PUAN-1'i tamamen karşılar.
        'Q1-Q3' => ['1.1-Q1', '1.1-Q2', '1.1-Q3'],
        'EDITORLUK' => ['4.1-Q1', '4.1-Q2', '4.1-Q3', '4.1-Q4', '4.2', '4.5', '4.6', '4.8', '4.10', '4.12'],
        'ATIF' => ['5.2', '5.5', '5.6', '5.8', '5.13'],
        'HAKEMLIK' => ['6.10'],
        'JURI' => ['7.7', '7.9'],
    ],

    'grup_tavanlari' => ['EDITORLUK' => 40, 'ATIF' => 50, 'HAKEMLIK' => 20, 'JURI' => 20],
];
