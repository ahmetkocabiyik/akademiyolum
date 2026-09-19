<?php

/**
 * KAHRAMANMARAŞ İSTİKLAL ÜNİVERSİTESİ — EK-1: Akademik Faaliyet ve Etkinlik
 * Puanları
 * Kaynak: pdf/17536998712.kahramanmarasistiklaluniverstesi.pdf
 *
 * TEK ORTAK PUAN TABLOSU, TEMEL ALAN AYRIMI YOK. Koşullar tabloya yalnızca iki
 * yerde kodla atıf yapıyor ("A1 kapsamında en az 3 adet makale"), gerisi
 * "EK-1'de yer alan faaliyetlerden N puan" biçiminde; kodlar yine de birebir
 * korundu.
 *
 * YAZAR ÇARPANI SAYI × SIRA MATRİSİ (Madde 9): tek yazarlı %100; iki isimli
 * 90/80; üç isimli 80/70/60; çok isimli 70/60/50 ve 4. isimden sonrası %40.
 * "Sorumlu yazar birinci isimle aynı puanı alır" — `baslica` rolü bu yüzden
 * `ilk` ile aynı satırı kullanıyor.
 *
 * MAKALE TÜRLERİ AYRI AYRI PUANLANMIŞ: her indeks düzeyinde özgün araştırma
 * makalesi, derleme ve kısa yayın için üç ayrı satır var (ör. SCI'de 40/30/20).
 * Korpusta derlemeyi özgün makaleden ayıran ama ikisini de anlamlı puanlayan
 * az sayıdaki cetvelden biri; `turler` alanıyla ayrıldı.
 *
 * ── ÇOK DEĞERLİ SATIRLAR 01.09.2026'DA AÇILDI ──
 * Dosya "proje (A5), editörlük (A6), ödül (B7-B8) ve burs (B3.4) kalemlerinde
 * PDF'te yalnızca ilk değer ayrıştırılabildi, rol ayrımı yapılamadı" diyordu.
 * `pdftotext -q -layout` ile bütün alt kırılımlar temiz çıkıyor. Düzeltilenler:
 *
 *   A5 (projeler) rolsüz tek satırdı: projede BURSİYER olan aday yürütücü
 *       puanını (40/30/15) alıyordu. Üç satır da dört role ayrıldı
 *       (40/20/10/15 · 30/15/6/10 · 15/10/5). ÇOK FAZLA sayıyordu.
 *   A6.6 tek satırda dergi editörlüğünü, editör kurulu üyeliğini ve hakemliği
 *       10 puanla topluyordu. Kaynak dört görev × dört dergi düzeyi veriyor;
 *       kurul üyeliği 3, hakemlik 2 puana indi. FAZLA sayıyordu.
 *   A6'nın "en fazla 50 puan" ve B2'nin "en fazla 30 puan" sınırları
 *       uygulanmıyordu; `grup_tavanlari` ile girildi.
 *   B7.3'te 'Yarışma Derecesi / Mansiyon' 15 puandaydı; yarışma ödülü B8'de
 *       ayrı ve sekiz kademeli (30/25/20/15 · 20/15/10/5). Kayıt derece ve
 *       düzey taşımadığı için §0 uyarınca 5'e indi. FAZLA sayıyordu.
 *   B5 (davetli konuşmacı) 12 puandaydı; kaynak 20/15/12/10 diyor → 10.
 *   A6.1 uluslararası kitap editörlüğü (40) ulusal satırla (30) birlikte
 *       yazılmıştı; 'BKCI Kitap' kendi satırına alındı. EKSİK sayıyordu.
 *
 * Yeni girilenler: B1'in "ikinci danışman için puanın yarısı" kuralı
 * (doktora 10, yüksek lisans 5) ve B9 (yarışma jüri üyeliği, 1).
 *
 * GİRİLMEYEN KALEMLER: B3.1-B3.3 (yurt dışı görevlendirme süreleri — profilde
 * tutulmuyor), B4 (bilimsel toplantı düzenleme kurulu — sözlükte karşılık
 * yok), B1.3-B1.4 (lisans öğrenci ve topluluk danışmanlığı), C bölümünün alt
 * kırılımları kısmen.
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 *
 * KİTAPTA KAPSAM AYRIMI (19.09.2026): üst kademe uluslararası yayınevine (ve
 * dile) bağlı, alt kademe ulusal yayınevi ya da Türkçe yayın. Dil koşulu
 * kayıttan okunamıyor ama kapsam etiketi kendi kapsamının satırına bağlandı;
 * ulusal satırlar daraltıldı.
 */

return [
    'kapsam_notu' => 'Puanlar Kahramanmaraş İstiklal Üniversitesi EK-1 tablosundan. Puan yazar '
        .'sayınıza ve sıranıza göre azaltılır (Madde 9: iki isimli 90/80 · üç isimli 80/70/60 · '
        .'çok isimli 70/60/50 ve 4. isimden sonrası 40); sorumlu yazar birinci isimle aynı puanı '
        .'alır. Editörlük ve hakemlik bölümünden en fazla 50, verilen derslerden en fazla 30 '
        .'puan sayılıyor. EDİTÖR KURULU ÜYELİĞİ, HAKEMLİK, DAVETLİ KONUŞMACILIK VE YARIŞMA '
        .'ÖDÜLÜ PUANINIZ DÜŞÜK GÖRÜNEBİLİR: yönerge bunları dergi düzeyine, toplantı düzeyine '
        .'ya da dereceye göre kademelendiriyor, faaliyet kaydı bu ayrımı taşımadığı için en '
        .'düşük kademeden sayılıyor.',

    // Madde 9 — Çok Yazarlı Kitap, Makale ve Bildirilerde Puanlama Tablosu.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'proje', 'patent', 'editorluk', 'odul', 'egitim_ogretim',
            'tez_danismanligi', 'idari_gorev', 'toplumsal_katki'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.0]],
            'ilk' => ['kademeler' => [1 => 1.0, 2 => 0.90, 3 => 0.80], 'sonrasi' => 0.70],
            // "Sorumlu yazar, birinci isimle aynı puanı alır."
            'baslica' => ['kademeler' => [1 => 1.0, 2 => 0.90, 3 => 0.80], 'sonrasi' => 0.70],
            'yazar_2' => ['kademeler' => [2 => 0.80, 3 => 0.70], 'sonrasi' => 0.60],
            'yazar_3' => ['kademeler' => [3 => 0.60], 'sonrasi' => 0.50],
            'yazar_4' => ['sonrasi' => 0.40],
            'yazar_5' => ['sonrasi' => 0.40],
            'yazar_6' => ['sonrasi' => 0.40],
            'ortak' => ['kademeler' => [1 => 1.0, 2 => 0.80, 3 => 0.60], 'sonrasi' => 0.40],
        ],
    ],

    'maddeler' => [
        // ══ A1 — MAKALELER ══
        'A1.1.1' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergide tam metin özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 40],
        'A1.1.2' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergide tam metin derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme'], 'puan' => 30],
        'A1.1.3' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergide vaka takdimi, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 20],
        'A1.2.1' => ['baslik' => 'ESCI veya alan indeksli dergide tam metin özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI'], 'turler' => ['ozgun_makale'], 'puan' => 30],
        'A1.2.2' => ['baslik' => 'ESCI veya alan indeksli dergide tam metin derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI'], 'turler' => ['derleme'], 'puan' => 25],
        'A1.2.3' => ['baslik' => 'ESCI veya alan indeksli dergide vaka takdimi, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['ESCI'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 15],
        'A1.3.1' => ['baslik' => 'Diğer indeksli dergide tam metin özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Scopus'], 'turler' => ['ozgun_makale'], 'puan' => 25],
        'A1.3.2' => ['baslik' => 'Diğer indeksli dergide tam metin derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Scopus'], 'turler' => ['derleme'], 'puan' => 20],
        'A1.3.3' => ['baslik' => 'Diğer indeksli dergide vaka takdimi, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Scopus'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 10],
        'A1.4.1' => ['baslik' => 'TÜBİTAK-ULAKBİM taranan dergide tam metin özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 20],
        'A1.4.2' => ['baslik' => 'TÜBİTAK-ULAKBİM taranan dergide tam metin derleme', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['derleme'], 'puan' => 15],
        'A1.4.3' => ['baslik' => 'TÜBİTAK-ULAKBİM taranan dergide vaka takdimi, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 8],
        'A1.4.4' => ['baslik' => 'Diğer ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 10],

        // ══ A2 — KİTAPLAR ══
        'A2.1.1' => ['baslik' => 'Uluslararası bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası Kitap'], 'puan' => 50],
        'A2.1.2' => ['baslik' => 'Uluslararası bilimsel kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Uluslararası Kitap Bölümü'], 'puan' => 25],
        'A2.1.5' => ['baslik' => 'Uluslararası bilimsel ansiklopedide madde yazarlığı (en fazla altı madde)', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 10],
        'A2.2.1' => ['baslik' => 'Ulusal bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap', 'Ulusal Ders / Metot Kitabı'], 'puan' => 40],
        'A2.2.2' => ['baslik' => 'Ulusal bilimsel kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap Bölümü'], 'puan' => 20],
        'A2.2.3' => ['baslik' => 'Bilimsel kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 20],
        'A2.2.4' => ['baslik' => 'Bilimsel kitapta bölüm ya da makale çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 10],

        // ══ A3 — BİLDİRİLER ══
        // SÖZLÜ/POSTER ekseni sözlükte YOK. Etiket çifti şöyle bölüşüyor:
        // `Tam Metin` = SÖZLÜ sunulup tam metni basılan bildiri;
        // `Özet/Poster` = özet basılanlar ile POSTER'lerin tamamı (poster
        // adı ikinci etikette geçiyor). Bu yüzden `Özet/Poster` satırı,
        // kaynağın özet ve poster hücrelerinin EN DÜŞÜĞÜNÜ alır.
        // İstiklal: uluslararası sözlü 15/10 · poster 10/5 → özet/poster 5;
        // ulusal sözlü 10/5 · poster 5/2 → özet/poster 2.
        'A3.1.1' => ['baslik' => 'Uluslararası toplantıda tam metni yayımlanmış sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Uluslararası Tam Metin (CPCI)'], 'puan' => 15],
        'A3.1.2' => ['baslik' => 'Uluslararası toplantıda özet metni yayımlanmış bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 5],
        'A3.2.1' => ['baslik' => 'Ulusal toplantıda tam metni yayımlanmış sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 10],
        'A3.2.2' => ['baslik' => 'Ulusal toplantıda özet metni yayımlanmış bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 2],

        // ══ A4 — ATIFLAR ══
        'A4.1' => ['baslik' => 'Web of Science taranan dergide veya uluslararası kitapta atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 3],
        'A4.2' => ['baslik' => 'Diğer hakemli dergide veya ulusal bilimsel kitapta atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer'], 'puan' => 2],

        // ══ A5 — PROJELER (her satır dört role ayrılıyor) ══
        'A5.1.a' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 40],
        'A5.1.b' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen projede yardımcı araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci'], 'puan' => 20],
        'A5.1.c' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen projede bursiyerlik', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['bursiyer'], 'puan' => 10],
        'A5.1.d' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen projede danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['danisman'], 'puan' => 15],
        'A5.2.a' => ['baslik' => 'TÜBİTAK, kalkınma ajansı veya bakanlık destekli projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 30],
        'A5.2.b' => ['baslik' => 'TÜBİTAK, kalkınma ajansı veya bakanlık destekli projede yardımcı araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci'], 'puan' => 15],
        'A5.2.c' => ['baslik' => 'TÜBİTAK, kalkınma ajansı veya bakanlık destekli projede bursiyerlik', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['bursiyer'], 'puan' => 6],
        'A5.2.d' => ['baslik' => 'TÜBİTAK, kalkınma ajansı veya bakanlık destekli projede danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['danisman'], 'puan' => 10],
        'A5.3.a' => ['baslik' => 'Döner sermaye veya BAP destekli projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 15],
        'A5.3.b' => ['baslik' => 'Döner sermaye veya BAP destekli projede yardımcı araştırmacılık ya da danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman'], 'puan' => 10],
        'A5.3.c' => ['baslik' => 'Döner sermaye veya BAP destekli projede bursiyerlik', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['bursiyer'], 'puan' => 5],

        // ══ A6 — EDİTÖRLÜK VE HAKEMLİK (bu bölümden en fazla 50 puan) ══
        'A6.1.a' => ['baslik' => 'Uluslararası kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Uluslararası Kitap Editörlüğü'], 'puan' => 40],
        // 'Kitap Editörlüğü' uluslararası/ulusal ayırmıyor → ulusal satır (30).
        'A6.2.a' => ['baslik' => 'Ulusal kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 30],
        'A6.3.a' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergide baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 40],
        'A6.4.a' => ['baslik' => 'ESCI veya alan indeksli dergide baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 30],
        // TR Dizin hem "diğer indeks" (A6.5, 20) hem "ulusal hakemli dergi" (A6.6, 10)
        // okunabiliyor; §0 uyarınca 10.
        'A6.6.a' => ['baslik' => 'Ulusal hakemli dergide baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 10],
        // Editör kurulu üyeliği A6.3-A6.6'da 10/7/5/3, hakemlik 5/4/3/2; kayıt bu
        // görevlerde dergi düzeyini taşımadığı için §0 uyarınca en düşükten.
        'A6.6.c' => ['baslik' => 'Dergide editör kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 3],
        'A6.6.d' => ['baslik' => 'Dergi hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 2],

        // ══ B1-B2 — EĞİTİM-ÖĞRETİM ══
        'B1.1' => ['baslik' => 'Danışmanlığında tamamlanan doktora veya uzmanlık tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 20],
        'B1.2' => ['baslik' => 'Danışmanlığında tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 10],
        // B1 başlığı: "İkinci danışman için puanın yarısı."
        'B1.1-es' => ['baslik' => 'İkinci danışmanlığında tamamlanan doktora veya uzmanlık tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 10],
        'B1.2-es' => ['baslik' => 'İkinci danışmanlığında tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 5],
        'B2.1' => ['baslik' => 'Ön lisans veya lisans dersi (dönem ve ders başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 2],
        'B2.2' => ['baslik' => 'Lisansüstü ders (dönem ve ders başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
        'B3.4' => ['baslik' => 'Uluslararası araştırma bursu', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 15],

        // ══ B4-B5 — ORGANİZASYON VE DAVETLİ KONUŞMA ══
        // B5 dört kademeli (20/15/12/10); kayıt toplantı düzeyini taşımıyor → §0 uyarınca 10.
        'B5.2.b' => ['baslik' => 'Panel, çalıştay veya mesleki kursta davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 10],

        // ══ B6 — JÜRİ ÜYELİĞİ ══
        'B6.2' => ['baslik' => 'Doktora, sanatta yeterlik, uzmanlık veya yüksek lisans jürisinde görev', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 5],

        // ══ B7-B8 — ÖDÜLLER ══
        'B7.1' => ['baslik' => 'Jürili uluslararası bilim veya sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 30],
        'B7.2' => ['baslik' => 'TÜBİTAK veya TÜBA bilim ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 25],
        'B7.3' => ['baslik' => 'Jürili ulusal bilim veya sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 15],
        // B8 yarışma ödülü sekiz kademeli (uluslararası 30/25/20/15, ulusal 20/15/10/5);
        // kayıt derece ve düzey ayrımı taşımıyor → §0 uyarınca 5.
        'B8.2.d' => ['baslik' => 'Ulusal yarışmada mansiyon ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 5],
        // B9 yarışma jüri üyeliği: uluslararası 2, ulusal 1 → §0 uyarınca 1.
        'B9.2' => ['baslik' => 'Ulusal yarışmada jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 1],

        // ══ B10 — PATENT VE TESCİL ══
        'B10.1' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 70],
        'B10.2' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 40],
        'B10.3' => ['baslik' => 'Faydalı model veya endüstriyel tasarım belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 20],

        // ══ B11 — İDARİ GÖREVLER ══
        'B11.1' => ['baslik' => 'Rektörlük veya rektör yardımcılığı (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı'], 'puan' => 20],
        'B11.2' => ['baslik' => 'Dekanlık, başhekimlik veya müdürlük (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 15],
        'B11.3' => ['baslik' => 'Dekan, başhekim veya müdür yardımcılığı (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 10],
        'B11.6' => ['baslik' => 'Bölüm başkanlığı (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 7],
        'B11.8' => ['baslik' => 'Bölüm başkan yardımcılığı veya anabilim dalı başkanlığı (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 5],

        // ══ C — SANATSAL ETKİNLİKLER ══
        'C1.1' => ['baslik' => 'Uluslararası kişisel sanat etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Resital (Uluslararası)', 'Solistlik (Uluslararası)', 'Elektronik Kişisel Sergi (Uluslararası)'], 'puan' => 50],
        'C1.2' => ['baslik' => 'Uluslararası karma veya ortak sanat etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Karma Sergi (Uluslararası)'], 'puan' => 30],
        'C1.3' => ['baslik' => 'Uluslararası sempozyum, festival veya bienale eserle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Masterclass (Uluslararası)'], 'puan' => 30],
        'C1.4' => ['baslik' => 'Eserin yurt dışında satın alınması veya koleksiyona kabulü', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Haber Olması (Uluslararası)'], 'puan' => 25],
        'C2.1' => ['baslik' => 'Ulusal kişisel sanat etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Resital (Ulusal)', 'Solistlik (Ulusal)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 30],
        'C2.2' => ['baslik' => 'Ulusal karma veya ortak sanat etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 20],
        'C2.3' => ['baslik' => 'Ulusal sempozyum, festival veya bienale eserle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Masterclass (Ulusal)', 'Özgün Eser / Beste / Tasarım'], 'puan' => 20],
        'C2.4' => ['baslik' => 'Eserin yurt içinde satın alınması veya koleksiyona kabulü', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Haber Olması (Ulusal)'], 'puan' => 15],
        'TOPLANTI-BSK' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)', 'Toplantı Düzenleme Başkanlığı (Ulusal)'], 'puan' => 15],
        'TOPLANTI-UYE' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 6],
        'B11.5' => ['baslik' => 'Üniversite ile ilgili diğer kurul görevleri', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 5],
    ],

    'gruplar' => [
        // Dr. Öğr. Üyeliği koşulunun andığı küme: A1 (makaleler).
        'A1' => ['A1.*'],
        // Profesörlükteki "EK-1'de yer alan yayınlar" — makale, kitap, bildiri.
        'YAYIN' => ['A1.*', 'A2.*', 'A3.*'],
        // Bölüm tavanı olan iki küme.
        'A6' => ['A6.*'],
        'B2' => ['B2.*'],
        'A2.1.5' => ['A2.1.5'],
    ],

    'grup_tavanlari' => [
        // Kaynaktaki iki bölüm sınırı: A6 "en fazla 50 puan", B2 "en fazla 30 puan".
        'A6' => 50,
        'B2' => 30,

        // A2.1.5'in ADET sınırı puana çevrildi: "Uluslararası Bilimsel
        // ansiklopedilerde madde yazarlığı (En fazla altı maddeden puan
        // alınabilir)" — madde başına 10 puan, yani 6 × 10 = 60.
        //
        // Kaynağın "BİR KİTAPTAN en fazla …" biçimindeki sınırları
        // (A2.1.4 iki bölüm, A2.2 başlığı 40 puan) uygulanamıyor: kayıt
        // aynı esere ait kalemleri birbirine bağlamıyor. A2.2.6'nın altı
        // madde sınırı da girilmedi, o satır cetvelde yok.
        'A2.1.5' => 60,
    ],
];
