<?php

/**
 * ACIBADEM MEHMET ALİ AYDINLAR ÜNİVERSİTESİ — EK-1 Temel Kriterler
 * Kaynak: pdf/17634002431.Acıbadem Mehmet Ali Aydınlar Üniversitesi Kriter.pdf
 * (10 sayfa; YÖK Başkanlığının 27.02.2025 tarih 8352 sayılı yazısıyla
 * yürürlüğe girmiştir.)
 *
 * Madde kodları EK-1'in kendi numaralandırması (1.A.1, 4.A.3.a, 6.B.10 …).
 * Bize ait olanlar: 2.E ile 3.E'nin tam metin / özet ayrımı için açılan
 * .1 ve .2 alt kodları.
 *
 * ── Q4 SATIRLARI SIFIR PUAN ──
 * Yönerge 1. kategorinin bütün Q4 satırlarına 0 puan veriyor. Satırlar
 * cetvele 0 puanla girildi: puana katkıları yok ama "1A-D kategorilerinde
 * en az iki yayın" gibi SAYI koşullarında sayılmaları gerekiyor.
 *
 * ── AHCI DERGİLERİ Q4 SAYILIYOR ──
 * Yönerge AHCI dergilerinin çeyreğini Scimago'ya göre belirliyor; kayıt
 * AHCI için çeyrek taşımadığından §0 uyarınca en düşük çeyrek (Q4)
 * uygulandı, yani AHCI yayınları 0 puan alıyor ama sayı koşullarında
 * sayılıyor.
 *
 * ── KESİRLİ PUANLAR AŞAĞI YUVARLANDI (§0) ──
 *   1.C.2 22,5 → 22 · 2.C 7,5 → 7 · 4.B.6 ve 4.B.11 7,5 → 7 ·
 *   6.B.14 2,5 → 2 · 2.E özet 2,5 → 2 · 5.B, 5.C ve 5.E 0,5 → 0.
 * Atıf satırlarının yarım puanlıları böylece SIFIRA düşüyor: yalnız
 * 5.A (SCI/SSCI/AHCI dergilerinde atıf) ile 5.D (BKCI/SCOPUS/SENSE
 * kitaplarında atıf) 1 puan veriyor, ama sözlükte 'WoS / Scopus' etiketi
 * 5.A ile 5.B'nin ikisini birden karşıladığı için düşük olan (0) girildi.
 * Pratikte yalnız kitaplarda yapılan atıflar puan getiriyor.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   Kitapta yayınevi sınıfı (WoS/SENSE A-B ↔ SCOPUS/SENSE C ↔ SENSE D-E)
 *       kayıtta taşınmıyor: 4.A.1 80/60/30 → 30, 4.A.3 40/30/20 → 20,
 *       4.A.5 30/20/10 → 10.
 *   Çeviri kitap 4.A.2 (40/30/20) ile 4.B.2 (30) ve 4.B.8 (15) tek
 *       'Çeviri Kitap' etiketine düşüyor → 15. Bölüm çevirisi 4.A.4,
 *       4.B.4 ve 4.B.10 → 3.
 *   Kitap yazarlığı 4.B.1 (40) ile 4.B.7 (20) → 20; bölüm 4.B.3 (20) ile
 *       4.B.9 (10) → 10; editörlük 4.B.5 (10) ile 4.B.11 (7,5) → 7.
 *   Projede koordinatör ile yürütücü kayıtta ayrılamıyor: 6.B.1/6.B.2
 *       50/30 → 30, 6.B.5/6.B.6 40/30 → 30, 6.B.9/6.B.10 30/20 → 20.
 *       6.B.3 (10) ile 6.B.4 (AB kariyer projesi araştırmacılığı, 30)
 *       ayrılamıyor → 10.
 *   Davetli konuşmacılık 8.A.2 (8) ile 8.A.8 (5) → 5. Kongre başkanlığı,
 *       düzenleme ve bilim kurulu üyelikleri tek 'Diğer' etiketine
 *       düşüyor (10/8/7/5/4/3) → 3.
 *   Uluslararası özet/poster 2.E özeti (2) ile 8.A.6 (4) → 2. Ulusal
 *       bildiride TR Dizin'de yayımlanan (3.E, 2/1) ile yayımlanmayan
 *       (8.A.11/12, 3/2) ayrılamıyor → 2 ve 1.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   1.E (SCI dergisinde yayımlanmış kongre bildirisi, 20/15/10/0 ve
 *       10/7,5/5/0) — bildiri kaydı derginin çeyreğini taşımıyor;
 *       CPCI'da taranan bildiriler 2.E'nin 5 puanından sayılıyor.
 *   1.F, 2.F ve 3.F (kitap değerlendirmesi) — sözlükte karşılıksız.
 *   'Diğer Uluslararası İndeks' ve 'Diğer Ulusal Hakemli' dergiler —
 *       yönerge yalnız WoS/SCOPUS ve TR Dizin dergilerini puanlıyor.
 *   Özel kurum ve kuruluşlarla yapılan projelerde YÜRÜTÜCÜLÜK — yönerge
 *       6.B.9/6.B.10'da yalnız kamu kurumlarını sayıyor, özel kurumlarda
 *       yalnız araştırmacı (6.B.11) ve danışman (6.B.12) satırı var.
 *   Faydalı model, endüstriyel tasarım, ıslahçı hakkı, yazılım ve
 *       ticarileştirme — yönerge yalnız patent tanıyor.
 *   Hakemlik, tez izleme komitesi üyeliği, idari görevler, ödüller ve
 *       topluma hizmet kalemleri — yönergede karşılığı yok.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   "Aynı kitapta sadece iki bölüm yazarlığından/çevirmenliğinden puan
 *       alınabilir" — kitap başına tavan motorda yok.
 *   "Kitap/kitap bölümü yazarı ve editör aynı kişi ise puan sadece tek
 *       bir kategoriden hesaplanır."
 *   Atıf tavanının kadroya göre değişmesi cetvel varyantlarıyla çözüldü;
 *       her eşik kendi tavanını taşıyan varyanta bağlı.
 *
 * Yönerge: yonerge/acibadem.php
 */
$OZGUN = ['ozgun_makale'];
$DERLEME = ['derleme'];
$KISA = ['kisa_makale'];
$VAKA = ['vaka_teknik_not'];
$TUM_TUR = ['ozgun_makale', 'derleme', 'kisa_makale', 'vaka_teknik_not'];
$KAMU = ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'];

$maddeler = [
    // ══ 1. SCI-EXP, SSCI VEYA AHCI KAPSAMINDAKİ DERGİLER ══
    '1.A.1' => ['baslik' => 'Q1 kategorisindeki dergide yayınlanmış özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $OZGUN, 'puan' => 60],
    '1.A.2' => ['baslik' => 'Q2 kategorisindeki dergide yayınlanmış özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $OZGUN, 'puan' => 40],
    '1.A.3' => ['baslik' => 'Q3 kategorisindeki dergide yayınlanmış özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $OZGUN, 'puan' => 20],
    '1.A.4' => ['baslik' => 'Q4 kategorisindeki ya da AHCI kapsamındaki dergide yayınlanmış özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => $OZGUN, 'puan' => 0],
    '1.B.1' => ['baslik' => 'Q1 kategorisindeki dergide yayınlanmış derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $DERLEME, 'puan' => 60],
    '1.B.2' => ['baslik' => 'Q2 kategorisindeki dergide yayınlanmış derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $DERLEME, 'puan' => 40],
    '1.B.3' => ['baslik' => 'Q3 kategorisindeki dergide yayınlanmış derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $DERLEME, 'puan' => 20],
    '1.B.4' => ['baslik' => 'Q4 kategorisindeki ya da AHCI kapsamındaki dergide yayınlanmış derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => $DERLEME, 'puan' => 0],
    '1.C.1' => ['baslik' => 'Q1 kategorisindeki dergide yayınlanmış kısa makale (short/brief communication)', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $KISA, 'puan' => 30],
    '1.C.2' => ['baslik' => 'Q2 kategorisindeki dergide yayınlanmış kısa makale (short/brief communication)', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $KISA, 'puan' => 22],
    '1.C.3' => ['baslik' => 'Q3 kategorisindeki dergide yayınlanmış kısa makale (short/brief communication)', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $KISA, 'puan' => 15],
    '1.C.4' => ['baslik' => 'Q4 kategorisindeki ya da AHCI kapsamındaki dergide yayınlanmış kısa makale (short/brief communication)', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => $KISA, 'puan' => 0],
    '1.D.1' => ['baslik' => 'Q1 kategorisindeki dergide yayınlanmış vaka raporu, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $VAKA, 'puan' => 20],
    '1.D.2' => ['baslik' => 'Q2 kategorisindeki dergide yayınlanmış vaka raporu, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $VAKA, 'puan' => 15],
    '1.D.3' => ['baslik' => 'Q3 kategorisindeki dergide yayınlanmış vaka raporu, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $VAKA, 'puan' => 10],
    '1.D.4' => ['baslik' => 'Q4 kategorisindeki ya da AHCI kapsamındaki dergide yayınlanmış vaka raporu, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => $VAKA, 'puan' => 0],
    '1.G.1' => ['baslik' => 'Q1 kategorisindeki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)'], 'puan' => 20],
    '1.G.2' => ['baslik' => 'Q2 kategorisindeki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q2)'], 'puan' => 15],
    '1.G.3' => ['baslik' => 'Q3 kategorisindeki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q3)'], 'puan' => 10],
    '1.G.4' => ['baslik' => 'Q4 kategorisindeki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q4)'], 'puan' => 0],

    // ══ 2. WoS ALL DATABASES / SCOPUS Q1-Q2 KAPSAMINDAKİ DİĞER DERGİLER ══
    '2.A' => ['baslik' => 'WoS All Databases ya da SCOPUS Q1-Q2 kapsamındaki dergide yayınlanmış özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $OZGUN, 'puan' => 10],
    '2.B' => ['baslik' => 'WoS All Databases ya da SCOPUS Q1-Q2 kapsamındaki dergide yayınlanmış derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $DERLEME, 'puan' => 10],
    '2.C' => ['baslik' => 'WoS All Databases ya da SCOPUS Q1-Q2 kapsamındaki dergide yayınlanmış kısa makale (short/brief communication)', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $KISA, 'puan' => 7],
    '2.D' => ['baslik' => 'WoS All Databases ya da SCOPUS Q1-Q2 kapsamındaki dergide yayınlanmış vaka raporu, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $VAKA, 'puan' => 5],
    '2.E.1' => ['baslik' => 'WoS All Databases ya da SCOPUS kapsamında taranan kongre tam metni', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 5],
    '2.E.2' => ['baslik' => 'WoS All Databases ya da SCOPUS kapsamında taranan kongre bildiri özeti', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 2],
    '2.G' => ['baslik' => 'WoS All Databases ya da SCOPUS Q1-Q2 kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 5],

    // ══ 3. ULAKBİM TR DİZİN KAPSAMINDAKİ ULUSAL DERGİLER ══
    '3.A' => ['baslik' => 'TR Dizin kapsamındaki dergide yayınlanmış özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $OZGUN, 'puan' => 7],
    '3.B' => ['baslik' => 'TR Dizin kapsamındaki dergide yayınlanmış derleme', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $DERLEME, 'puan' => 7],
    '3.C' => ['baslik' => 'TR Dizin kapsamındaki dergide yayınlanmış kısa makale (short/brief communication)', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $KISA, 'puan' => 4],
    '3.D' => ['baslik' => 'TR Dizin kapsamındaki dergide yayınlanmış vaka raporu, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $VAKA, 'puan' => 4],
    '3.E.1' => ['baslik' => 'Ulusal kongrede sunulmuş tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 2],
    '3.E.2' => ['baslik' => 'Ulusal kongrede sunulmuş bildiri özeti ya da poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 1],
    '3.G' => ['baslik' => 'TR Dizin kapsamındaki dergide editörlük ya da yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Yayın Kurulu Üyeliği'], 'puan' => 2],

    // ══ 4. KİTAP / KİTAP BÖLÜMÜ ══
    '4.A.1' => ['baslik' => 'WoS Book Citation Index, SCOPUS ya da SENSE kapsamındaki uluslararası yayınevinde kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 30],
    '4.A.3' => ['baslik' => 'WoS Book Citation Index, SCOPUS ya da SENSE kapsamındaki uluslararası yayınevinde kitap bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 20],
    '4.A.5' => ['baslik' => 'WoS Book Citation Index, SCOPUS ya da SENSE kapsamındaki uluslararası yayınevinde kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 10],
    '4.B.7' => ['baslik' => 'Uluslararası ya da ulusal yayınevi tarafından yayınlanmış kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı', 'Tahkik (Tenkitli Metin)'], 'puan' => 20],
    '4.B.8' => ['baslik' => 'Uluslararası ya da ulusal yayınevi tarafından yayınlanmış kitabın çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 15],
    '4.B.9' => ['baslik' => 'Uluslararası ya da ulusal yayınevi tarafından yayınlanmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 10],
    '4.B.10' => ['baslik' => 'Uluslararası ya da ulusal yayınevi tarafından yayınlanmış kitap bölümünün çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 3],
    '4.B.11' => ['baslik' => 'Uluslararası ya da ulusal yayınevi tarafından yayınlanmış kitabın editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 7],

    // ══ 5. ATIFLAR ══
    '5.A' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki uluslararası dergilerde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'TR Dizin', 'Diğer', 'Patent'], 'puan' => 0],
    '5.D' => ['baslik' => 'WoS Book Citation Index, SCOPUS ya da SENSE kapsamındaki kitaplarda yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 1],

    // ══ 6. TEZLER ve PROJELER ══
    '6.A.1' => ['baslik' => 'Tamamlanmış doktora ya da uzmanlık tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 30],
    '6.A.2' => ['baslik' => 'Tamamlanmış tezli yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 10],
    '6.B.2' => ['baslik' => 'AB Çerçeve Programı, NIH, NSF ya da ERC bilimsel araştırma projesinde koordinatör veya yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 30],
    '6.B.3' => ['baslik' => 'AB Çerçeve Programı, NIH, NSF ya da ERC bilimsel araştırma projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
    '6.B.6' => ['baslik' => 'Uluslararası destekli diğer bilimsel araştırma projesinde koordinatör veya yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 30],
    '6.B.7' => ['baslik' => 'Uluslararası destekli diğer bilimsel araştırma projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 20],
    '6.B.8' => ['baslik' => 'Uluslararası destekli diğer bilimsel araştırma projesinde danışman', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['danisman'], 'puan' => 10],
    '6.B.10' => ['baslik' => 'Üniversiteler dışındaki kamu kurumlarıyla yapılan bilimsel araştırma projesinde koordinatör veya yürütücü', 'kategori' => 'proje', 'kaynaklar' => $KAMU, 'roller' => ['yurutucu'], 'puan' => 20],
    '6.B.11' => ['baslik' => 'Üniversiteler dışındaki kamu ya da özel kurumlarla yapılan bilimsel araştırma projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => [...$KAMU, 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 10],
    '6.B.12' => ['baslik' => 'Üniversiteler dışındaki kamu ya da özel kurumlarla yapılan bilimsel araştırma projesinde danışman', 'kategori' => 'proje', 'kaynaklar' => [...$KAMU, 'Özel Sektör / STK'], 'roller' => ['danisman'], 'puan' => 5],
    '6.B.13' => ['baslik' => 'Üniversite tarafından fonlanan bilimsel araştırma projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 5],
    '6.B.14' => ['baslik' => 'Üniversite tarafından fonlanan bilimsel araştırma projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 2],
    '6.B.15' => ['baslik' => 'Ulusal ya da uluslararası jürili yarışmaya katılmak veya danışmanlık yapmak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 10],
    // Kaynağın 6.B.15'i katılmayı, danışmanlığı VE jüri üyeliğini tek bende
    // topluyor; jüri etiketleri `sanatsal_etkinlik` kategorisinde olduğu için
    // aynı bendin ikinci satırı gerekiyor, yoksa jüri üyeliği hiç sayılmıyor.
    '6.B.15-juri' => ['baslik' => 'Ulusal ya da uluslararası jürili yarışmada jüri üyesi olarak görev yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 10],

    // ══ 7. PATENT ══
    '7.A.1' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
    '7.A.2' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 10],

    // ══ 8. KONGRE FAALİYETLERİ ══
    '8.A.5' => ['baslik' => 'Uluslararası kongrede indekslenmemiş sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin'], 'puan' => 5],
    '8.A.8' => ['baslik' => 'Ulusal ya da uluslararası kongrede davetli konuşmacı', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 5],
    '8.A.10' => ['baslik' => 'Kongre başkanlığı, düzenleme kurulu ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 3],
];

$gruplar = [
    '1A' => ['1.A.*'],
    '1A-B' => ['1.A.*', '1.B.*'],
    '1A-C' => ['1.A.*', '1.B.*', '1.C.*'],
    // 1.E girilemediği için "1A-E" kümesi 1A-D ile aynı (dosya başlığına bakın).
    '1A-D' => ['1.A.*', '1.B.*', '1.C.*', '1.D.*'],
    '1A-D-Q1' => ['1.A.1', '1.B.1', '1.C.1', '1.D.1'],
    '1A-D-Q2' => ['1.A.2', '1.B.2', '1.C.2', '1.D.2'],
    '2A' => ['2.A'],
    '2A-B' => ['2.A', '2.B'],
    '2A-G' => ['2.A', '2.B', '2.C', '2.D', '2.E.1', '2.E.2', '2.G'],
    '3A' => ['3.A'],
    '3A-B' => ['3.A', '3.B'],
    '3D-G' => ['3.D', '3.E.1', '3.E.2', '3.G'],
    '3A-G' => ['3.A', '3.B', '3.C', '3.D', '3.E.1', '3.E.2', '3.G'],
    '4A-B' => ['4.A.1', '4.A.3', '4.A.5', '4.B.7', '4.B.8', '4.B.9', '4.B.10', '4.B.11'],
    // 4A.1, 4A.3, 4B.1 ve 4B.3: kitap ve kitap bölümü yazarlığı satırları.
    '4-YAZARLIK' => ['4.A.1', '4.A.3', '4.B.7', '4.B.9'],
    '1A-2A' => ['1.A.*', '2.A'],
    '1A-2A-3A' => ['1.A.*', '2.A', '3.A'],
    '1A-D-2A-B' => ['1.A.*', '1.B.*', '1.C.*', '1.D.*', '2.A', '2.B'],
    '1A-B-2A-B-3A-B' => ['1.A.*', '1.B.*', '2.A', '2.B', '3.A', '3.B'],
    '3A-B-3D-G' => ['3.A', '3.B', '3.D', '3.E.1', '3.E.2', '3.G'],
    'YAYIN-HEPSI' => ['1.A.*', '1.B.*', '1.C.*', '1.D.*', '2.A', '2.B', '2.C', '2.D',
        '2.E.1', '2.E.2', '2.G', '3.A', '3.B', '3.C', '3.D', '3.E.1', '3.E.2', '3.G'],
    // Doktor öğretim üyeliğine ilk atanmada sosyal alanın (a) maddesi.
    'SOSYAL-A' => ['1.A.*', '2.A', '3.A', '4.A.1', '4.A.3', '4.B.7', '4.B.9'],
    // Profesörlükte sosyal alanın (b) maddesi.
    'SOSYAL-PROF-B' => ['1.A.*', '1.B.*', '2.A', '2.B', '3.A', '3.B',
        '4.A.1', '4.A.3', '4.B.7', '4.B.9'],
    // Doçentlikte sosyal alanın (b) maddesi.
    'SOSYAL-DOC-B' => ['3.A', '3.B', '4.A.1', '4.A.3', '4.B.7', '4.B.9'],
    'PROJE-YURUTUCU' => ['6.B.2', '6.B.6', '6.B.10', '6.B.13'],
    'PROJE-ARASTIRMACI' => ['6.B.3', '6.B.7', '6.B.11', '6.B.14'],
    'ATIF' => ['5.A', '5.D'],
];

$kapsamNotu = 'Puanlar Acıbadem Mehmet Ali Aydınlar Üniversitesi Öğretim Üyeliğine Atanma ve '
    .'Yükseltilme Kriterlerinin EK-1 Temel Kriterler tablosundan (YÖK\'ün 27.02.2025 tarihli '
    .'onayı). Ortak çalışmalarda puan yazar sayısına bölünüyor; 1A-D, 2A-D ve 3A-D '
    .'kategorilerinde başlıca yazar toplam puanın %40\'ını, ikinci yazar %20\'sini ek olarak '
    .'alıyor. Bu ek, motorda tek bir yazar matrisi tanımlanabildiği için kongre bildirilerine '
    .'de uygulanıyor; bildiri puanınız 2-5 puanlık kalemlerde OLDUĞUNDAN BİRKAÇ PUAN YÜKSEK '
    .'görünebilir. Kitap, proje, patent ve tez danışmanlığı puanları yönerge gereği kişi '
    .'başına verildiği için bölünmüyor. Yazar listesini boş bırakırsanız bölme hiç uygulanmaz '
    .'ve puanınız olduğundan yüksek görünür. '
    .'Yönergenin Q4 satırları SIFIR puan; Q4 dergilerdeki yayınlar puana katkı vermiyor ama '
    .'"en az iki yayın" gibi sayı koşullarında sayılıyor. AHCI dergilerinin çeyreği kayıtta '
    .'taşınmadığı için AHCI yayınları da Q4 sayılıyor, yani 0 puan alıyor. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: kitap satırlarında yayınevi sınıfı '
    .'(WoS/SENSE A-B, SCOPUS/SENSE C, SENSE D-E) kayıtta taşınmadığı için en düşük sınıf '
    .'uygulanıyor (kitap yazarlığı 80 yerine 30, bölüm 40 yerine 20); projede koordinatörlük '
    .'yürütücülükten ayrılamadığı için düşük satır uygulanıyor; SCI dergilerinde yayımlanmış '
    .'kongre bildirileri (1.E, 20 puana kadar) girilemedi ve CPCI bildirileri 5 puandan '
    .'sayılıyor; atıflarda yarım puanlı satırlar aşağı yuvarlanınca sıfırlandığı için pratikte '
    .'yalnız kitaplarda yapılan atıflar puan getiriyor. '
    .'Atıflardan alınabilecek puan, o kadro ve alan için gereken toplam puanın %20\'siyle '
    .'sınırlı; her eşik kendi tavanını taşıyan cetvel varyantına bağlı.';

// Ortak çalışmalarda puan yazar sayısına bölünür (AÇIKLAMALAR 1). Başlıca
// yazar toplam puanın %40'ını, ikinci yazar %20'sini EK OLARAK alır. Kitap,
// proje, patent ve tez danışmanlığı satırları "…/yazar", "…/fikir hak
// sahibi" ya da "iki danışman da tam puan alır" dediği için bölünmüyor.
$yazarKatsayisi = [
    'haric' => ['kitap', 'proje', 'patent', 'tez_danismanligi', 'atif', 'odul',
        'idari_gorev', 'toplumsal_katki', 'diger', 'egitim_ogretim', 'sanatsal_etkinlik'],
    'roller' => [
        'tek' => ['bol' => ['pay' => 1.0, 'ek' => 0.40]],
        'ilk' => ['bol' => ['pay' => 1.0, 'ek' => 0.40]],
        'baslica' => ['bol' => ['pay' => 1.0, 'ek' => 0.40]],
        'yazar_2' => ['bol' => ['pay' => 1.0, 'ek' => 0.20]],
        'yazar_3' => ['sonrasi_pay' => 1.0],
        'yazar_4' => ['sonrasi_pay' => 1.0],
        'yazar_5' => ['sonrasi_pay' => 1.0],
        'yazar_6' => ['sonrasi_pay' => 1.0],
        'ortak' => ['sonrasi_pay' => 1.0],
    ],
];

$cetveller = [];

// Atıf tavanı, o kadro ve alan için gereken TOPLAM puanın %20'si.
// 30 → 6, 60 → 12, 65 → 13, 80 → 16, 90 → 18, 120 → 24.
foreach ([6, 12, 13, 16, 18, 24] as $atifTavani) {
    $cetveller["acibadem-2025-atif{$atifTavani}"] = [
        'kapsam_notu' => $kapsamNotu,
        'yazar_katsayisi' => $yazarKatsayisi,
        'maddeler' => $maddeler,
        'gruplar' => $gruplar,
        'grup_tavanlari' => ['ATIF' => $atifTavani],
    ];
}

return ['cetveller' => $cetveller];
