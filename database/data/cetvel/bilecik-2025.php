<?php

/**
 * BİLECİK ŞEYH EDEBALİ ÜNİVERSİTESİ — EK-I Faaliyet Puanlama Tablosu
 * Kaynak: pdf/1785927020751.bilecik-seyh-edebali-kriter-16102025.pdf (18 sayfa)
 *         Revizyon 07: 18.09.2025 tarihli ve 495-2 sayılı Senato Kararı;
 *         MADDE 14 uyarınca 30.06.2026'da yürürlüğe giriyor.
 *
 * KAYNAK PDF TARANMIŞ; 300 dpi görüntüden `tesseract -l tur` ile okundu.
 * OCR bölüm harflerini yer yer bozmuş ("I" ↔ "1", "İ" ↔ "M"); J.4, L.5-L.9 ve
 * M.9-M.11 puanları sayfanın sağ şeridi kırpılıp gözle doğrulandı.
 *
 * DÖRT CETVEL VARYANTI ÜRETİYOR. İki eksende ayrışıyorlar:
 *
 *   1. YAZAR KATKI ORANI TEMEL ALANA GÖRE DEĞİŞİYOR (MADDE 11). Fen, Mühendislik,
 *      Ziraat, Spor, Sağlık ve Mimarlık'ta makalede başlıca yazara ayrıcalık var
 *      (iki yazarlıda 0,8; üç ve daha fazlada yarısı, diğerleri kalan yarıyı
 *      paylaşır); Sosyal, İlahiyat, Filoloji, Hukuk, Eğitim ve Güzel Sanatlar'da
 *      hiçbir ayrıcalık yok, puan daima eşit bölünür.
 *   2. M BÖLÜMÜ YALNIZCA İKİ ALAN İÇİN GEÇERLİ. Tablonun kendi dipnotu:
 *      "Mimarlık, Planlama ve Tasarım Temel Alanı ile Güzel Sanatlar Temel Alanı
 *      için geçerlidir." Öteki on alanın cetvelinde M satırları HİÇ YOK; olsaydı
 *      bir fen adayının sanatsal etkinlik kaydı yönergenin vermediği puanı alırdı.
 *
 *   bilecik-2025-fen            başlıca yazar ayrıcalıklı · M yok
 *   bilecik-2025-mimarlik       başlıca yazar ayrıcalıklı · M var
 *   bilecik-2025-sosyal         eşit bölüşme · M yok
 *   bilecik-2025-guzel-sanatlar eşit bölüşme · M var
 *
 * MAKALEDE BAŞLICA YAZAR AYRICALIĞI SEÇİLDİ, "DİĞER YAYINLARDA EŞİT BÖLÜŞME"
 * KURALI DEĞİL. MADDE 11 aynı satırda iki kural veriyor: makalede kademeli,
 * "diğer yayınlarda" (kitap, bildiri) eşit. Motor cetvel başına tek matris
 * tanımlıyor. §1 istisnası gereği EŞİKLERİN YAZILDIĞI kategoriyi yöneten kural
 * seçildi: Bilecik'in bütün alt barajları A (makaleler) üzerine kurulu, eşit
 * bölüşmeyi seçmek iki yazarlı bir makalenin puanını %80 yerine %50'ye
 * düşürüp adaya gereken makale sayısını neredeyse iki katına çıkarırdı. Ters
 * yöndeki sapma kitap ve bildiri satırlarında kalıyor: çok yazarlı kitapta
 * başlıca yazarın puanı OLDUĞUNDAN YÜKSEK görünür (iki yazarlıda %80 yerine
 * %50 olmalıydı).
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR (§0) ──
 *   B.7 (uluslararası ansiklopedi maddesi 5) ile B.8 (ulusal 3) → 3.
 *   C.1 (uluslararası sözlü tam metin 10) ile C.3 (uluslararası poster tam
 *       metin 8) tek "Uluslararası Tam Metin" etiketine düşüyor → 8.
 *       C.2 ve C.4 (ikisi de 5) → 5. C.5 (8) ile C.7 (6) → 6.
 *   F.1 (lisanslanan uluslararası patent 80) ile F.3 (tescillenmiş 40) → 40;
 *       F.2 (60) ile F.4 (20) → 20. Kayıt lisanslamayı tutmuyor.
 *   F.6/F.7/F.8 (ıslahçı hakkı 70/60, çeşit tescili 80) tek etikete → 60.
 *   I.7 (SCI-Scopus hakemliği 3) ile I.8 (diğer 2) → 2.
 *   E.2, E.4 ve E.5 tek "Diğer" etiketine düşüyor → 2.
 *   K.3 (mansiyon/jüri özel ödülü 15) ile M.12 (yarışmada derece veya mansiyon
 *       40) tek "Yarışma Derecesi / Mansiyon" etiketine düşüyor → 15.
 *   N.2'nin koordinatörlüğü (10) ile N.3'ün ABD başkanlığı (5) tek etikete → 5.
 *   N.4 (rektörlük görevlendirmesi 3) ile N.5 (dekanlık 2) → 2.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   H.1 EĞİTİM-ÖĞRETİMİN TAMAMI: puan haftalık ders SAATİ başına 0,1 (on saat
 *       bir puan). Kayıt ders saatini tutmuyor ve puan ondalıklı. H yalnızca
 *       H.2'den (değişim programı, 1 puan) ibaret kaldı; doçentlik ve
 *       profesörlüğün "H maddesinden en az 4/6 puan" koşulu bu yüzden
 *       eşiklerde `hesaplanamiyor` düğümü olarak duruyor.
 *   J BÖLÜMÜNÜN TAMAMI (kurum dışı araştırma, 20/15/10/5): "en az 3 ay süreli
 *       yurt dışında bulunmak" kaydı yok.
 *   L.1 h-indeksi (15), L.2 düzenleme kurulu başkanlığı (10), L.4 etkinlikte
 *       görev almak (5), L.8 probleme dayalı öğrenim (3), L.9 HASTANE
 *       POLİKLİNİK FAALİYETİ (aylık 5) — sonuncusu Sağlık Bilimlerinde A
 *       maddesinin alternatifi olduğu için o kol eşiklerde `hesaplanamiyor`.
 *   K.4-K.5 kongre bilim/sanat kurulu ödülleri (10/5).
 *   F.5 lisanslanan faydalı model/tasarım (15): yönerge yalnız LİSANSLANMIŞ
 *       olanı puanlıyor, kayıt lisanslamayı tutmuyor; tescilli faydalı modelin
 *       yönergede satırı yok.
 *   M.12 (yarışma derecesi, K.3'e düştü) ve M.13 (uygulama projesi hakkında
 *       yayın, 20).
 *   Yayın kurulu üyeliği: yönergede satırı yok (I bölümü yalnız editörlük ve
 *       hakemlik sayıyor).
 *
 * ── SANAT ETİKETLERİNİN M SATIRLARINA EŞLENMESİ ──
 * M bölümü sahne ve müzik icrasını ayrı satırlarla saymıyor; "yorum
 * çalışmaları ile kişisel/karma etkinlik" ifadesi üzerinden eşleniyor. Solo
 * icra (resital, solistlik, başrol, şeflik, rejisörlük) KİŞİSEL ETKİNLİK
 * satırlarına (M.3 yurt dışı 40, M.4 yurt içi 30), topluluk üyeliği KARMA/GRUP
 * satırlarına (M.8 yurt dışı 10, M.9 yurt içi 8), besteler ise M.9'a bağlandı.
 *
 * Yönerge: yonerge/bilecik.php
 */
$TAM = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];
$WOS = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];

$maddeler = [
    // ══ A. MAKALELER ══
    'A.1' => ['baslik' => 'SCI, SCIE veya SSCI kapsamında Q1 dilimli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $TAM, 'puan' => 60],
    'A.2' => ['baslik' => 'SCI, SCIE veya SSCI kapsamında Q2 dilimli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $TAM, 'puan' => 50],
    'A.3' => ['baslik' => 'SCI, SCIE veya SSCI kapsamında Q3 dilimli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $TAM, 'puan' => 40],
    'A.4' => ['baslik' => 'SCI, SCIE veya SSCI kapsamında Q4 dilimli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $TAM, 'puan' => 30],
    'A.5' => ['baslik' => 'AHCI kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => $TAM, 'puan' => 50],
    'A.6' => ['baslik' => 'ESCI, Scopus veya SPORTDiscus tarafından taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $TAM, 'puan' => 25],
    'A.7' => ['baslik' => 'TR Dizin tarafından taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TAM, 'puan' => 15],
    'A.8' => ['baslik' => 'Diğer uluslararası indekslerde taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $TAM, 'puan' => 7],
    'A.9' => ['baslik' => 'Diğer ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => 6],
    'A.10' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI kapsamındaki dergide teknik not, kısa makale, yorum, editöre mektup, özet ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $KISA, 'puan' => 10],
    'A.11' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI kapsamı dışındaki dergide teknik not, kısa makale, yorum, editöre mektup, özet ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'TR Dizin', 'Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 5],

    // ══ B. KİTAP (azami 100 puan) ══
    'B.1' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış özgün kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 50],
    'B.2' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 15],
    'B.3' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış özgün kitap (bilimsel, sanatsal ya da ders kitabı)', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı', 'Tahkik (Tenkitli Metin)'], 'puan' => 30],
    'B.4' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 10],
    'B.5' => ['baslik' => 'Tam kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 20],
    'B.6' => ['baslik' => 'Kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 5],
    'B.8' => ['baslik' => 'Yayımlanan ansiklopedi konusu ya da maddesi', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 3],

    // ══ C. BİLİMSEL TOPLANTI (azami 15 puan) ══
    'C.3' => ['baslik' => 'Uluslararası kongre ya da sempozyumda sunulan ve tam metni basılmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 8],
    'C.4' => ['baslik' => 'Uluslararası kongre ya da sempozyumda sunulan ve özet metni basılmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 5],
    'C.7' => ['baslik' => 'Ulusal kongre ya da sempozyumda sunulan ve tam metni basılmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 6],
    'C.8' => ['baslik' => 'Ulusal kongre ya da sempozyumda sunulan ve özet metni basılmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 4],

    // ══ D. BİLİMSEL ARAŞTIRMA PROJESİ ══
    'D.1a' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen ya da AB Çerçeve Programı projesinde koordinatör, yürütücü ya da baş araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 80],
    'D.1b' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen ya da AB Çerçeve Programı projesinde ortak ya da araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci'], 'puan' => 40],
    'D.1c' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen ya da AB Çerçeve Programı projesinde danışman ya da bursiyer', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 15],
    'D.2a' => ['baslik' => 'TÜBİTAK Ar-Ge projesinde ya da uluslararası ikili iş birliği projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 60],
    'D.2b' => ['baslik' => 'TÜBİTAK Ar-Ge projesinde ya da uluslararası ikili iş birliği projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci'], 'puan' => 30],
    'D.2c' => ['baslik' => 'TÜBİTAK Ar-Ge projesinde ya da uluslararası ikili iş birliği projesinde danışman ya da bursiyer', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 10],
    'D.3a' => ['baslik' => 'Üniversite dışı kaynaklarca (kamu kurumu, özel kuruluş) desteklenen projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 40],
    'D.3b' => ['baslik' => 'Üniversite dışı kaynaklarca (kamu kurumu, özel kuruluş) desteklenen projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci'], 'puan' => 20],
    'D.3c' => ['baslik' => 'Üniversite dışı kaynaklarca (kamu kurumu, özel kuruluş) desteklenen projede danışman ya da bursiyer', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 8],
    'D.4' => ['baslik' => 'Kamu ya da özel kuruluşlarca desteklenen öğrencilere yönelik projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 5],
    'D.5a' => ['baslik' => 'Üniversitenin bilimsel araştırma projesinde (BAP) yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 10],
    'D.5b' => ['baslik' => 'Üniversitenin bilimsel araştırma projesinde (BAP) araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['arastirmaci'], 'puan' => 5],
    'D.5c' => ['baslik' => 'Üniversitenin bilimsel araştırma projesinde (BAP) danışman ya da bursiyer', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 2],

    // ══ E. ATIFLAR (azami 10 puan) ══
    'E.1' => ['baslik' => 'Uluslararası kitap ya da kitap bölümlerinde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 5],
    'E.3' => ['baslik' => 'SCI, SCIE, SSCI, AHCI, ESCI veya Scopus taranan dergilerde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 5],
    'E.5' => ['baslik' => 'Ulusal hakemli dergilerde ve diğer yayınlarda eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 2],

    // ══ F. FİKRİ SINAİ MÜLKİYET HAKLARI VE GİRİŞİMCİLİK ══
    'F.3' => ['baslik' => 'Tescillenmiş uluslararası patent ya da PCT olumlu araştırma raporu', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 40],
    'F.4' => ['baslik' => 'Tescillenmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 20],
    'F.7' => ['baslik' => 'Islahçı hakkı ya da çeşit tescili', 'kategori' => 'patent', 'kaynaklar' => ['Islahçı Hakkı / Çeşit Tescili'], 'puan' => 60],

    // ══ G. LİSANSÜSTÜ TEZ DANIŞMANLIĞI ══
    'G.1' => ['baslik' => 'Yönetiminizde tamamlanan doktora ya da sanatta yeterlik tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 20],
    'G.2' => ['baslik' => 'Yönetiminizde tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 10],
    'G.1e' => ['baslik' => 'İkinci ya da eş danışman olduğunuz tamamlanmış doktora ya da sanatta yeterlik tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 10],
    'G.2e' => ['baslik' => 'İkinci ya da eş danışman olduğunuz tamamlanmış yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 5],

    // ══ H. EĞİTİM-ÖĞRETİM FAALİYETLERİ ══
    'H.2' => ['baslik' => 'Uluslararası ya da ulusal değişim programına (Erasmus, Farabi, Mevlana) katılmak', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Değişim Programı Dersi'], 'puan' => 1],

    // ══ İ. EDİTÖRLÜK VE HAKEMLİK ══
    'I.1' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 10],
    'I.2' => ['baslik' => 'ESCI veya Scopus tarafından taranan dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 8],
    'I.3' => ['baslik' => 'TR Dizin tarafından taranan dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 5],
    'I.4' => ['baslik' => 'Diğer uluslararası indekslerde taranan hakemli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 3],
    'I.5' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 10],
    'I.6' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 5],
    'I.8' => ['baslik' => 'Dergide hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 2],

    // ══ K. ÖDÜLLER ══
    'K.1' => ['baslik' => 'Alanınızda uluslararası kurum ya da kuruluşlardan alınan bilim, teşvik, sanat, tasarım veya araştırma ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 30],
    'K.2' => ['baslik' => 'Alanınızda ulusal kurum ya da kuruluşlardan alınan bilim, teşvik, sanat, tasarım veya araştırma ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 20],
    'K.3' => ['baslik' => 'Jürili yarışmalarda mansiyon ya da jüri özel ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 15],

    // ══ L. DİĞER AKADEMİK, BİLİMSEL VE TOPLUMA HİZMET ETKİNLİKLERİ ══
    'L.3' => ['baslik' => 'Bilimsel ya da sanatsal toplantı ve etkinliklerde davetli konuşmacı veya davetli sanatçı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 10],
    'L.5' => ['baslik' => 'Uluslararası jürili yarışma ile sanat ve tasarım yarışmalarında danışmanlık yapmak ya da jürilerinde görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], 'puan' => 10],
    'L.6' => ['baslik' => 'Ulusal jürili yarışma ile sanat ve tasarım yarışmalarında danışmanlık yapmak ya da jürilerinde görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 5],
    'L.7' => ['baslik' => 'Rektörlük, dekanlık, müdürlük ya da kamu kurumlarınca düzenlenen konferans, seminer, söyleşi ve kariyer günlerinde konuşmacı olmak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Bilim İletişimi / Popüler Yayın', 'Topluma Hizmet Projesi', 'Kamu/STK Danışmanlığı'], 'puan' => 2],

    // ══ N. AKADEMİK İDARİ GÖREVLER ══
    'N.1' => ['baslik' => 'Rektörlük, rektör yardımcılığı, dekanlık, enstitü, yüksekokul ya da meslek yüksekokulu müdürlüğü (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü'], 'puan' => 15],
    'N.2' => ['baslik' => 'Dekan yardımcılığı, müdür yardımcılığı, bölüm başkanlığı ya da merkez müdürlüğü (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkanı', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 10],
    'N.3' => ['baslik' => 'Anabilim dalı başkanlığı, bölüm başkan yardımcılığı ya da koordinatörlük (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük', 'Bölüm Başkan Yardımcısı'], 'puan' => 5],
    'N.5' => ['baslik' => 'Kurul, komisyon, heyet, konsey görevlendirmesi ya da bilirkişilik (her görev yılı için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 2],
];

/**
 * M bölümü — yalnızca Mimarlık, Planlama ve Tasarım ile Güzel Sanatlar temel
 * alanlarının cetvelinde bulunur (tablonun kendi dipnotu).
 */
$sanat = [
    'M.1' => ['baslik' => 'Özgün sanat eseri, beste, tasarım, mimari eser ya da yorum çalışmanızın yurt dışında satın alınması, yayın organlarında yer alması veya tasarım projesinin dış ülkelerde uygulanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)'], 'puan' => 50],
    'M.2' => ['baslik' => 'Uluslararası jürili karma sanat veya tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Karma Sergi (Uluslararası)'], 'puan' => 20],
    'M.3' => ['baslik' => 'Yurt dışında kişisel etkinlikte bulunmak (festival, sergi, proje uygulaması, gösteri, dinleti, gösterim)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Solistlik (Uluslararası)', 'Resital (Uluslararası)', 'Şan Resitali (Uluslararası)', 'Opera Birinci Rol (Uluslararası)', 'Bale Başrol (Uluslararası)', 'Orkestra Şefliği (Uluslararası)', 'Koro Şefliği (Uluslararası)', 'Opera Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Uluslararası)', 'Rejisörlük (Uluslararası)', 'Dansçı / Performans İcracısı (Uluslararası)'], 'puan' => 40],
    'M.4' => ['baslik' => 'Yurt içinde kişisel etkinlikte bulunmak (festival, sergi, proje uygulaması, gösteri, dinleti, gösterim)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)', 'Solistlik (Ulusal)', 'Resital (Ulusal)', 'Şan Resitali (Ulusal)', 'Opera Birinci Rol (Ulusal)', 'Bale Başrol (Ulusal)', 'Orkestra Şefliği (Ulusal)', 'Koro Şefliği (Ulusal)', 'Opera Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Ulusal)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Dansçı / Performans İcracısı (Ulusal)', 'Yönetmenlik (Sahne/Ekran)', 'Koreografi', 'Tüm Perde Koreograflığı (Uluslararası)', 'Tüm Perde Koreograflığı (Ulusal)', 'Bölüm Koreograflığı (Uluslararası)', 'Bölüm Koreograflığı (Ulusal)', 'Bale/Dans Koreograflığı (Uluslararası)', 'Bale/Dans Koreograflığı (Ulusal)'], 'puan' => 30],
    'M.5' => ['baslik' => 'Özgün sanat eseri, beste, tasarım, mimari eser ya da yorum çalışmanızın yurt içinde satın alınması, yayın organlarında yer alması veya tasarım projesinin uygulanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Uygulama Projesi — Müellif', 'Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)'], 'puan' => 30],
    'M.6' => ['baslik' => 'Ulusal jürili yurt dışı karma sanat veya tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Ulusal Jürili)'], 'puan' => 15],
    'M.7' => ['baslik' => 'Yurt içinde jürili karma sanat veya tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 10],
    'M.8' => ['baslik' => 'Yurt dışında karma veya grup sanat ya da tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Oda Müziği Grup Üyeliği (Uluslararası)', 'Corps de Ballet (Uluslararası)', 'Başkemancılık (Uluslararası)', 'Grup Şefliği (Uluslararası)', 'Masterclass (Uluslararası)'], 'puan' => 10],
    'M.9' => ['baslik' => 'Yurt içinde karma veya grup sanat ya da tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Jürisiz, Ulusal)', 'Özgün Eser / Beste / Tasarım', 'Oda Müziği Grup Üyeliği (Ulusal)', 'Corps de Ballet (Ulusal)', 'Başkemancılık (Ulusal)', 'Grup Şefliği (Ulusal)', 'Orkestra / Koro Üyeliği', 'Masterclass (Ulusal)', 'Albüm / Konser Kaydı', 'Karma Albüm / CD-DVD Katkısı', 'Bandrollü Kayıt (CD/DVD)', 'Opera/Bale Kompozisyonu', 'Orkestralı Sahne Eseri', 'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Küçük Ölçekli Orkestra Eseri', 'Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Sahne/Ekran Müziği', 'Eğitim Müziği Albümü', 'Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi', 'Sahne Tasarımı (Dekor, Kostüm, Işık)', 'Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman', 'Opera İkinci Rol (Uluslararası)', 'Opera İkinci Rol (Ulusal)', 'Oratoryo/Kantat Solistliği (Uluslararası)', 'Oratoryo/Kantat Solistliği (Ulusal)', 'Bale Solist Rol (Uluslararası)', 'Bale Solist Rol (Ulusal)', 'Rejisör Yardımcılığı (Uluslararası)', 'Rejisör Yardımcılığı (Ulusal)', 'Rejisör Yardımcılığı (Konservatuvar)', 'Sahneleme/Repetitörlük — Tüm Perde (Uluslararası)', 'Sahneleme/Repetitörlük — Tüm Perde (Ulusal)', 'Sahneleme/Repetitörlük — Bölüm (Uluslararası)', 'Sahneleme/Repetitörlük — Bölüm (Ulusal)', 'Müzikoloji Atölyesi', 'Eğitici Konser Programı (Uluslararası)', 'Eğitici Konser Programı (Ulusal)', 'Eğitim Amaçlı Sanat Etkinliği', 'Eserin Haber Olması (Uluslararası)', 'Eserin Haber Olması (Ulusal)'], 'puan' => 8],
    'M.10' => ['baslik' => 'Uluslararası ölçekte sempozyum, festival, çalıştay, bienal ya da trienal gibi sanat ve tasarım etkinliğine eserinizle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 10],
    'M.11' => ['baslik' => 'Ulusal ölçekte sempozyum, festival, çalıştay, bienal ya da trienal gibi sanat ve tasarım etkinliğine eserinizle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 8],
    'L.2' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)', 'Toplantı Düzenleme Başkanlığı (Ulusal)'], 'puan' => 10],
    'L.4' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 5],
];

$A = ['A.1', 'A.2', 'A.3', 'A.4', 'A.5', 'A.6', 'A.7', 'A.8', 'A.9', 'A.10', 'A.11'];
$A1A3 = ['A.1', 'A.2', 'A.3'];
$A1A4 = ['A.1', 'A.2', 'A.3', 'A.4'];
$A1A6 = ['A.1', 'A.2', 'A.3', 'A.4', 'A.5', 'A.6'];
$A1A7 = ['A.1', 'A.2', 'A.3', 'A.4', 'A.5', 'A.6', 'A.7'];
$B = ['B.1', 'B.2', 'B.3', 'B.4', 'B.5', 'B.6', 'B.8'];
$C = ['C.3', 'C.4', 'C.7', 'C.8'];
$F = ['F.3', 'F.4', 'F.7'];
$K = ['K.1', 'K.2', 'K.3'];
$L = ['L.3', 'L.5', 'L.6', 'L.7'];
$M = array_keys($sanat);

/** MADDE 11: Fen, Mühendislik, Ziraat, Spor, Sağlık, Mimarlık — makalede başlıca yazar ayrıcalıklı. */
$digerYazar = ['kademeler' => [1 => 1.00], 'bol' => ['pay' => 0.5, 'eksi' => 1]];
$esitBolusme = ['bol' => ['pay' => 1.0]];
$katkiFen = [
    'haric' => ['atif', 'proje', 'patent', 'tez_danismanligi', 'egitim_ogretim',
        'editorluk', 'odul', 'idari_gorev', 'toplumsal_katki', 'diger'],
    // MADDE 11 aynı satırda İKİ kural veriyor: makalede başlıca yazara
    // ayrıcalıklı kademe, "diğer yayınlarda" (kitap, bildiri) daima eşit
    // bölüşme. Kategori bazlı çarpan olmadığı sürece makale kuralı kitaba da
    // uygulanıyordu ve başlıca yazarın kitap puanı FAZLA çıkıyordu.
    'kategoriler' => [
        'kitap' => $esitBolusme,
        'bildiri' => $esitBolusme,
    ],
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.00]],
        'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.80], 'sonrasi' => 0.50],
        'ilk' => $digerYazar,
        'yazar_2' => $digerYazar,
        'yazar_3' => $digerYazar,
        'yazar_4' => $digerYazar,
        'yazar_5' => $digerYazar,
        'yazar_6' => $digerYazar,
        'ortak' => $digerYazar,
    ],
];

/** MADDE 11: Sosyal, İlahiyat, Filoloji, Hukuk, Eğitim, Güzel Sanatlar — daima eşit bölüşme. */
$katkiSosyal = [
    'haric' => $katkiFen['haric'],
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.00]],
        'ilk' => $esitBolusme,
        'baslica' => $esitBolusme,
        'yazar_2' => $esitBolusme,
        'yazar_3' => $esitBolusme,
        'yazar_4' => $esitBolusme,
        'yazar_5' => $esitBolusme,
        'yazar_6' => $esitBolusme,
        'ortak' => $esitBolusme,
    ],
];

$ortakNot = 'Puanlar Bilecik Şeyh Edebali Üniversitesi Öğretim Üyeliğine Yükseltilme ve Atanma '
    .'Yönergesinin EK-I Faaliyet Puanlama Tablosundan (Revizyon 07, 18.09.2025 tarihli 495-2 '
    .'sayılı Senato Kararı; 30.06.2026\'da yürürlüğe giriyor). Kaynak PDF taranmış; 300 dpi '
    .'görüntüden OCR ile okundu, puan sütunu gözle doğrulandı. '
    .'PUANINIZ ŞU KALEMLERDE OLDUĞUNDAN DÜŞÜK GÖRÜNÜR: EĞİTİM-ÖĞRETİM bölümünün ders satırı '
    .'(H.1) girilemedi — puan haftalık ders SAATİ başına 0,1 veriliyor, kayıt ders saatini '
    .'tutmuyor; H yalnız değişim programı satırından ibaret. J bölümünün tamamı (kurum dışı '
    .'araştırma, üç ay ve üzeri yurt dışı bulunma, 20/15/10/5), L.1 h-indeksi, L.2 düzenleme '
    .'kurulu başkanlığı, L.4 etkinlikte görev alma, L.8 probleme dayalı öğrenim, L.9 hastane '
    .'poliklinik faaliyeti, K.4-K.5 kongre kurulu ödülleri ve F.5 lisanslanan faydalı model de '
    .'kayıtta karşılıksız kaldı. Aynı etikete düşen satırlarda daima düşüğü sayılıyor: '
    .'lisanslanan patent tescilli patent değerinden (40/20), uluslararası ansiklopedi maddesi '
    .'ulusaldan (3), uluslararası sözlü tam metin bildiri poster değerinden (8), SCI-Scopus '
    .'hakemliği diğer hakemlikten (2), koordinatörlük anabilim dalı başkanlığından (5). '
    .'Yönerge kitap ve bildiride puanı daima EŞİT bölerken makalede kademeli bölüyor; '
    .'ikisi de uygulanıyor.';

$sanatNotu = ' Bu cetvel M (Sanat ve Tasarım Etkinlikleri) bölümünü içerir; tablonun dipnotu '
    .'M bölümünü yalnızca Mimarlık, Planlama ve Tasarım ile Güzel Sanatlar temel alanları için '
    .'geçerli sayıyor. Sahne ve müzik icrası M bölümünde ayrı satırlarla sayılmadığı için solo '
    .'icra kişisel etkinlik (M.3/M.4), topluluk üyeliği ve besteler karma/grup etkinlik '
    .'(M.8/M.9) satırlarından puanlanıyor.';

$gruplar = function (array $maddeler, bool $mVar) use ($A, $A1A3, $A1A4, $A1A6, $A1A7, $B, $C, $F, $K, $L, $M): array {
    $km = $mVar ? array_merge($K, $L, $M) : array_merge($K, $L);

    return [
        'TUM' => array_keys($maddeler),
        'A' => $A,
        'A1-A3' => $A1A3,
        'A1-A4' => $A1A4,
        'A1-A6' => $A1A6,
        'A1-A7' => $A1A7,
        'B' => $B,
        'C' => $C,
        'B-C' => array_merge($B, $C),
        'A-F' => array_merge($A, $F),
        'K-L-M' => $km,
    ];
};

$tavanlar = ['B' => 100, 'C' => 15, 'E' => 10];

$cetveller = [];

foreach ([
    'bilecik-2025-fen' => [$katkiFen, false],
    'bilecik-2025-mimarlik' => [$katkiFen, true],
    'bilecik-2025-sosyal' => [$katkiSosyal, false],
    'bilecik-2025-guzel-sanatlar' => [$katkiSosyal, true],
] as $anahtar => [$katki, $mVar]) {
    $tablo = $mVar ? array_merge($maddeler, $sanat) : $maddeler;

    $cetveller[$anahtar] = [
        'kapsam_notu' => $ortakNot.($mVar ? $sanatNotu : ''),
        'yazar_katsayisi' => $katki,
        'maddeler' => $tablo,
        'gruplar' => array_merge($gruplar($tablo, $mVar), ['E' => ['E.1', 'E.3', 'E.5']]),
        'grup_tavanlari' => $tavanlar,
    ];
}

return ['cetveller' => $cetveller];
