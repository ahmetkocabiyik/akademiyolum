<?php

/**
 * GEBZE TEKNİK ÜNİVERSİTESİ — EK 1: Faaliyet Puanlama Tablosu
 * Kaynak: pdf/17536994892.gebzeteknikuniverstesi.pdf (16 sayfa, YÖ-0055,
 * yayın 14.01.2019, revizyon 9 · 27.09.2023)
 *
 * MADDE KODLARI YÖNERGENİN KENDİSİ (1.1-11.3). Koşullar tabloya kodla atıf
 * yapıyor ("en az 100 puanı 1, 2 ve/veya 3 kodlu faaliyet başlıklarından",
 * "4.1., 4.2., 4.3., 4.7., 4.8. kodlu eserlerden birine sahip olmak"), bu
 * yüzden kodlar birebir korundu. Bize ait olan tek şey çeyrekliğe göre
 * bölünen 1.1 satırı (`1.1-Q1`…`1.1-Q4`), tek kayda düşen satırların tire
 * ile yazılmış çift kodları (`2.3-2.5`, `4.1-4.2`, `10.2-10.6`) ve alt
 * satırlara ayrılan kalemlerin harf/ek ekleri (`4.3a`, `6.1-es`,
 * `8.1-poster`).
 *
 * ── ÜÇ TEMEL ALAN SÜTUNU → ÜÇ CETVEL GÖVDESİ ──
 * Tablo tek ama üç puan sütunu taşıyor:
 *   mf  → Mühendislik, Havacılık ve Uzay Bilimleri, Fen Bilimleri ve
 *         Matematik Temel Alanı (Mühendislik, Havacılık ve Uzay Bilimleri
 *         ve Temel Bilimler fakülteleri)
 *   sbi → Sosyal, Beşeri ve İdari Bilimler Temel Alanı (İşletme Fakültesi)
 *   mpt → Mimarlık, Planlama ve Tasarım Temel Alanı (Mimarlık Fakültesi)
 * Sütunlar 20'den fazla satırda ayrıştığı için tek gövde + fark yerine
 * satır başına üçlü puan matrisi tutuldu (`$puanlar`); `null` o sütunda
 * "GD (Geçerli Değil)" demektir ve satır o cetvele hiç girmez.
 *
 * ── TAVANLAR KADROYA GÖRE DEĞİŞİYOR → ALAN × KADRO = 9 CETVEL ──
 * Tablo başlıkları bölüm tavanlarının bir kısmını kadroya bağlıyor:
 *   5 (atıf):     Dr. en fazla 15 · doçent 35 · profesör 50
 *   6 (tez dan.): doçentte 40 · profesörde 60 (Dr. için tavan yok)
 *   9 (eğitim):   Dr. en fazla 20 · doçent 40 · profesör 60
 * `grup_tavanlari` cetvel geneline uygulandığı için cetvel üç kadro
 * varyantında üretildi (KONVANSIYONLAR "Tavan FAKÜLTE × KADRO ise cetveli
 * çarpanla üret"). Sabit tavanlar her varyantta aynı: 3 → 35, 4 → 40,
 * 8 → 40, 10 → 25, 11 → 40. MADDE 6.c'nin "2 kodlu faaliyet başlığından en
 * fazla 80 puan" sınırı yalnızca Mühendislik/Fen profesörlüğünde geçerli
 * olduğu için sadece `mf-profesor` varyantına yazıldı.
 *
 * ── 1.1 VE 2.1 ÇEYREKLİK PUANI ──
 * Mühendislik/Fen sütununda 1.1 ve 2.1 "5-20" yazıyor ve dipnot 1 bunu
 * Q1 20 · Q2 15 · Q3 10 · Q4 5 diye açıyor. 1.1 dört satıra bölündü.
 * 2.1 BÖLÜNEMEDİ: `tez_yayini` kategorisinin kaynak sözlüğünde çeyreklik
 * ayrımı yok (tek 'SCIE/SSCI/AHCI' etiketi), §0 uyarınca EN DÜŞÜK çeyreklik
 * değeri (5) girildi — tezden üretilmiş Q1 makalesi olan Mühendislik/Fen
 * adayının puanı OLDUĞUNDAN DÜŞÜK görünür. Sosyal ve Mimarlık sütunlarında
 * 1.1 ve 2.1 çeyreklikten bağımsız tek değer taşıdığı için sorun yok.
 * AHCI dergilerinin çeyrekliği kayıtta olmadığı için 1.1-Q4 satırına
 * (en düşük) bağlandı.
 *
 * ── AYNI KAYNAĞA DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   2.3 (diğer uluslararası hakemli, 4/8/8) ile 2.5 (ULAKBİM taranmayan
 *       ulusal, 2/2/3): `tez_yayini` sözlüğünde ikisine de karşılık gelen
 *       tek etiket 'Diğer' → 2/2/3.
 *   2.8 (uluslararası tam metin sözlü bildiri) ile 2.9 (ulusal): tek
 *       'CPCI Bildiri' etiketi → Sosyal 2, Mimarlık 3; Mühendislik/Fen'de
 *       ikisi de GD olduğu için satır hiç yok.
 *   4.1 (uluslararası yarışma, ilk 3 ödül 25/40/40 · mansiyon 15/25/25) ile
 *       4.2 (ulusal yarışma, 10/25/25 · 5/15/15): `odul` sözlüğünde tek
 *       'Yarışma Derecesi / Mansiyon' etiketi var, derece de ayrılamıyor
 *       → dördünün en düşüğü: 5/15/15.
 *   4.8 yazılım üreticiliği ile ulusal patent (30 uluslararası / 15 ulusal):
 *       'Yazılım' etiketi ulusal patentle aynı satıra (15) bağlandı.
 *   4.9 endüstriyel tasarım uluslararası 10 / ulusal 5: tek 'Endüstriyel
 *       Tasarım' etiketi → 5.
 *   6.1/6.2'de "tek danışman" ile "asıl danışman" ayrımı sözlükte yok
 *       ('danisman' rolü ikisini de taşıyor) → doktorada 15 yerine 10.
 *   7.11 (toplumsal katkı projesi yürütücüsü 8) ile 7.12 (araştırmacı 5):
 *       `toplumsal_katki` kategorisinde rol ayrımı yok → 5.
 *   8.1 davetli konuşma (15) ile 8.2 davetli konuşma (8): tek 'Davetli
 *       Konuşmacı' etiketi → 8.
 *   10.1 jüri/bilim kurulu üyeliği uluslararası 5 / ulusal 2 → 2.
 *   10.2/10.3/10.4 dergi hakemliği (3/2/1), 10.5 kitap hakemliği (5) ve
 *       10.6 proje hakemliği (6/3): tek 'Hakemlik' etiketi → 1.
 *   10.8/10.9/10.10 dergi editörlüğü ile yardımcı/konuk editörlük
 *       (10/5, 8/4, 5/3): kayıt editörlük düzeyini ayırmıyor → 5/4/3.
 *   3.5'in editörlük dalı (ulusal yayınevi kitap editörlüğü 6/8/8) ile 10.7
 *       (sempozyum kitabı veya dergi özel sayısı editörlüğü 3): tek 'Kitap
 *       Editörlüğü' etiketi → 3, ve satır `10.7` kodunda durduğu için
 *       3. bölümün 35 puanlık tavanı yerine 10. bölümün 25 puanlık tavanına
 *       tabi. 3.5'in "bölüm yazarlığı" dalı `3.5-bolum` kodunda ayrı duruyor.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   4.6 (GTÜ "Yılın Bilim İnsanı" ödülü) — kuruma özel, sözlükte karşılığı
 *       yok.
 *   11.1 (küratörlük, yalnızca Mimarlık sütununda 15/8) — `sanatsal_etkinlik`
 *       sözlüğünde küratörlük etiketi yok; 'Diğer' etiketine bağlansaydı
 *       11.2 ile aynı kayda düşerdi.
 *   9.3 (bir yarıyıl yardımcı öğretim elemanlığı, 2) — `egitim_ogretim`
 *       sözlüğünde yardımcılık etiketi yok.
 *   Faydalı model, ıslahçı hakkı, ansiklopedi maddesi, akreditasyon
 *       faaliyeti, bilim iletişimi, kamu/STK danışmanlığı, burs, senato
 *       üyeliği, uygulama ve araştırma merkezi müdürlüğü, kurul/komisyon
 *       üyeliği — tabloda karşılık gelen satır YOK.
 *   Mimarlık Fakültesi adayları için sergi, konser, tasarım gibi sanatsal
 *       etkinlik satırları tabloda hiç yok: yönerge yalnızca 4.1-4.3 ödül
 *       satırları, 4.7 uygulama projesi ve 11.1 küratörlük üzerinden sanat
 *       ve tasarım faaliyetine puan veriyor.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   "Bir kitapta birden fazla bölüm yazılmışsa (1+(k/c))×p" — çarpanı 1'in
 *       ÜSTÜNE çıkaran tek kural; motor `min(1.0, …)` uyguluyor ve zaten
 *       bölüm sayısı kayıtta yok. Puan olduğundan DÜŞÜK görünür.
 *   10.2-10.4'ün "her yıl en fazla 5 adet" ve 10.8-10.10'un "her yıl için"
 *       ifadeleri yıl başına tavan/çarpan; motorda yıl biriktirmesi yok.
 *   11.3 idari görev "görevde her yıl için 3 puan" — yıl çarpanı yok, görev
 *       başına tek yıl sayılıyor; puan olduğundan DÜŞÜK görünür.
 *   5. bölümün Dr. Öğr. Üyesi için 15, doçent için 35, profesör için 50
 *       olan tavanları kadro varyantlarıyla karşılandı; ama 5. bölümün
 *       "adayın atıf yapılan her eseri için" sayımı kayıtta atıf başına
 *       tutulduğu için puan olduğundan YÜKSEK görünebilir.
 *
 * Yönerge: yonerge/gebze-teknik.php
 */

/**
 * Satır gövdesi — puan hariç her şey üç sütunda ortak.
 *
 * @var array<string, array{baslik: string, kategori: string, kaynaklar: list<string>, turler?: list<string>, roller?: list<string>}>
 */
$satirlar = [
    // ══ 1. MAKALELER (tezden üretilmemiş, tam araştırma makalesi) ══
    '1.1-Q1' => ['baslik' => 'SCI, SCI-E, SSCI veya AHCI kapsamındaki Q1 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale']],
    '1.1-Q2' => ['baslik' => 'SCI, SCI-E, SSCI veya AHCI kapsamındaki Q2 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale']],
    '1.1-Q3' => ['baslik' => 'SCI, SCI-E, SSCI veya AHCI kapsamındaki Q3 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale']],
    '1.1-Q4' => ['baslik' => 'SCI, SCI-E, SSCI veya AHCI kapsamındaki Q4 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale']],
    '1.2' => ['baslik' => 'Uluslararası alan indekslerinde taranan dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale']],
    '1.3' => ['baslik' => 'Diğer uluslararası hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale']],
    '1.4' => ['baslik' => 'ULAKBİM tarafından taranan ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale']],
    '1.5' => ['baslik' => 'ULAKBİM tarafından taranmayan ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale']],

    // ══ 2. LİSANSÜSTÜ TEZLERDEN ÜRETİLMİŞ YAYINLAR ══
    '2.1' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, SCI, SCI-E, SSCI veya AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI']],
    '2.2' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, uluslararası alan indekslerinde taranan dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['ESCI / Scopus']],
    '2.3-2.5' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, diğer uluslararası ya da ULAKBİM tarafından taranmayan ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Diğer']],
    '2.4' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, ULAKBİM tarafından taranan ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['TR Dizin']],
    '2.6' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, uluslararası yayınevi tarafından yayımlanmış kitap ya da kitap bölümü', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap', 'BKCI / Scopus Kitap Bölümü']],
    '2.7' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, ulusal yayınevi tarafından yayımlanmış kitap ya da kitap bölümü', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Kitap Bölümü']],
    '2.8-2.9' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, sempozyum ya da kongrede sunulmuş ve tam metni basılmış sözlü bildiri', 'kategori' => 'tez_yayini', 'kaynaklar' => ['CPCI Bildiri']],

    // ══ 3. KİTAP (tezden üretilmemiş) — en fazla 35 puan ══
    '3.1' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap']],
    '3.2' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü']],
    '3.3' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitabın editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap']],
    '3.4' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı']],
    '3.5-bolum' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü']],

    // ══ 4. YARIŞMA, ÖDÜL, UYGULAMA, YAZILIM ve PATENT — en fazla 40 puan ══
    '4.1-4.2' => ['baslik' => 'Uluslararası ya da ulusal mesleki kuruluşların düzenlediği yarışmada derece veya mansiyon', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon']],
    '4.3a' => ['baslik' => 'Alanınızda geleneksel olarak verilen uluslararası bilimsel ya da sanatsal ödül', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü']],
    '4.3b' => ['baslik' => 'Alanınızda geleneksel olarak verilen ulusal bilimsel ya da sanatsal ödül', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'YÖK Ödülü']],
    '4.4' => ['baslik' => 'TÜBİTAK Bilim Özel Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü']],
    '4.5' => ['baslik' => 'TÜBA, Global Young Academy ya da benzeri kurumların verdiği ödül', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü', 'Ufuk Avrupa / ERC Ödülü']],
    '4.7' => ['baslik' => 'Döner sermaye ya da üniversite dışında ürettiğiniz uygulama projesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif']],
    '4.8a' => ['baslik' => 'Uluslararası patent sahibi olmak', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent']],
    '4.8b' => ['baslik' => 'Ulusal patent sahibi ya da yazılım üreticisi olmak', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Yazılım']],
    '4.9' => ['baslik' => 'Tescil edilen endüstriyel tasarım ürününün tasarımcısı olmak', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım']],
    '4.10' => ['baslik' => 'Patent, endüstriyel tasarım, tez ya da proje çıktısının sanayide uygulanması veya ticarileştirilmesi', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme']],

    // ══ 5. ATIFLAR ══
    '5.1' => ['baslik' => 'SCI, SCI-E, SSCI, AHCI dergilerinde ya da uluslararası yayınevi kitaplarında atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap']],
    '5.2' => ['baslik' => 'Diğer uluslararası indeksli dergilerde ya da uluslararası yayınevi kitap bölümlerinde atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer']],
    '5.3' => ['baslik' => 'Ulusal hakemli dergilerde ya da ulusal yayınevi kitaplarında atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Patent']],

    // ══ 6. LİSANSÜSTÜ TEZ DANIŞMANLIĞI ══
    '6.1' => ['baslik' => 'Tamamlanmış doktora tezinde danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman']],
    '6.1-es' => ['baslik' => 'Tamamlanmış doktora tezinde eş danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman']],
    '6.1-tik' => ['baslik' => 'Doktora tez izleme komitesi üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği']],
    '6.2' => ['baslik' => 'Tamamlanmış yüksek lisans tezinde danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman']],
    '6.2-es' => ['baslik' => 'Tamamlanmış yüksek lisans tezinde eş danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman']],

    // ══ 7. BİLİMSEL ARAŞTIRMA PROJESİ ══
    '7.1' => ['baslik' => 'AB Çerçeve programı ya da diğer uluslararası program projesinde koordinatör veya baş araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu']],
    '7.2' => ['baslik' => 'AB Çerçeve programı ya da diğer uluslararası program projesinde ortak araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer']],
    '7.3' => ['baslik' => 'Diğer uluslararası destekli bilimsel araştırma projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu']],
    '7.4' => ['baslik' => 'Diğer uluslararası destekli bilimsel araştırma projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer']],
    '7.5' => ['baslik' => 'Üniversite dışındaki kamu kurumlarıyla yapılan bilimsel araştırma projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu']],
    '7.6' => ['baslik' => 'Üniversite dışındaki kamu kurumlarıyla yapılan bilimsel araştırma projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer']],
    '7.7' => ['baslik' => 'Üniversite tarafından desteklenen Bilimsel Araştırma Projesi (BAP) yürütücülüğü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu']],
    '7.8' => ['baslik' => 'Üniversite tarafından desteklenen Bilimsel Araştırma Projesinde (BAP) görev almak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer']],
    '7.9' => ['baslik' => 'Üniversite dışındaki özel kurum kaynaklı fonla yapılan bilimsel araştırma projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu']],
    '7.10' => ['baslik' => 'Üniversite dışındaki özel kurum kaynaklı fonla yapılan bilimsel araştırma projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer']],
    '7.11-7.12' => ['baslik' => 'Ulusal ya da uluslararası toplumsal katkı projesinde (TÜBİTAK 4004, 4005, STK projeleri) görev almak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi']],

    // ══ 8. BİLİMSEL TOPLANTI FAALİYETİ — en fazla 40 puan ══
    '8.1-davetli' => ['baslik' => 'Bilimsel toplantıda davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı']],
    '8.1-sozlu' => ['baslik' => 'Uluslararası bilimsel toplantıda sözlü sunum', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin']],
    '8.1-poster' => ['baslik' => 'Uluslararası bilimsel toplantıda poster sunumu', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster']],
    '8.2-sozlu' => ['baslik' => 'Ulusal bilimsel toplantıda sözlü sunum', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin']],
    '8.2-poster' => ['baslik' => 'Ulusal bilimsel toplantıda poster sunumu', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster']],

    // ══ 9. EĞİTİM ÖĞRETİM FAALİYETİ ══
    '9.1' => ['baslik' => 'Bir yarıyıl yüksek lisans veya doktora dersi yürütücülüğü', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders']],
    '9.2' => ['baslik' => 'Bir yarıyıl ön lisans veya lisans dersi yürütücülüğü', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi']],

    // ══ 10. ÜYELİK, HAKEMLİK, EDİTÖRLÜK VE ÇEVİRMENLİK — en fazla 25 puan ══
    '10.1' => ['baslik' => 'Yayın, değerlendirme, sanat ve tasarım yarışması jüri üyeliği ya da bilim kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği']],
    '10.2-10.6' => ['baslik' => 'Dergi, kitap ya da proje hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik']],
    '10.7' => ['baslik' => 'Sempozyum/kongre kitabı, derginin özel sayısı ya da ulusal yayınevi kitabı editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü']],
    '10.8' => ['baslik' => 'SCI, SCI-E, SSCI veya AHCI tarafından taranan dergide editörlük ya da konuk editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)']],
    '10.9' => ['baslik' => 'Diğer uluslararası indeks ve alan indekslerinde taranan dergide editörlük ya da konuk editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi']],
    '10.10' => ['baslik' => 'Diğer bilimsel, sanatsal veya mesleki hakemli dergide editörlük ya da konuk editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi']],
    '10.11' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış bir kitabın çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap']],
    '10.12' => ['baslik' => 'Makale veya kitap bölümünün yayımlanmış çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü']],

    // ══ 11. DİĞER FAALİYETLER — en fazla 40 puan ══
    '11.2' => ['baslik' => 'Sempozyum ya da kongre düzenleme veya bilimsel komite üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Diğer']],
    '11.3' => ['baslik' => 'İdari görev (rektör, rektör yardımcısı, dekan, dekan yardımcısı, bölüm başkanı, bölüm başkan yardımcısı, enstitü müdürü, enstitü anabilim dalı başkanı)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü', 'Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkanı', 'Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük']],
];

/**
 * Satır → [Mühendislik-Fen, Sosyal, Mimarlık] puanı. `null` = "GD".
 *
 * @var array<string, array{0: ?int, 1: ?int, 2: ?int}>
 */
$puanlar = [
    '1.1-Q1' => [20, 20, 20],
    '1.1-Q2' => [15, 20, 20],
    '1.1-Q3' => [10, 20, 20],
    '1.1-Q4' => [5, 20, 20],
    '1.2' => [5, 15, 20],
    '1.3' => [4, 10, 10],
    '1.4' => [3, 8, 8],
    '1.5' => [null, 4, 4],
    '2.1' => [5, 15, 15],
    '2.2' => [5, 10, 10],
    '2.3-2.5' => [2, 2, 3],
    '2.4' => [3, 4, 4],
    '2.6' => [10, 10, 10],
    '2.7' => [6, 6, 6],
    '2.8-2.9' => [null, 2, 3],
    '3.1' => [20, 20, 20],
    '3.2' => [15, 15, 15],
    '3.3' => [10, 10, 10],
    '3.4' => [10, 10, 15],
    '3.5-bolum' => [6, 8, 8],
    '4.1-4.2' => [5, 15, 15],
    '4.3a' => [20, 20, 20],
    '4.3b' => [10, 15, 15],
    '4.4' => [20, 20, 20],
    '4.5' => [20, 20, 20],
    '4.7' => [20, 20, 20],
    '4.8a' => [30, 30, 30],
    '4.8b' => [15, 15, 15],
    '4.9' => [5, 5, 5],
    '4.10' => [20, 20, 20],
    '5.1' => [3, 3, 3],
    '5.2' => [2, 2, 2],
    '5.3' => [1, 1, 1],
    '6.1' => [10, 10, 10],
    '6.1-es' => [5, 5, 5],
    '6.1-tik' => [1, 1, 1],
    '6.2' => [6, 6, 6],
    '6.2-es' => [3, 3, 3],
    '7.1' => [40, 40, 40],
    '7.2' => [20, 20, 20],
    '7.3' => [20, 20, 20],
    '7.4' => [10, 10, 10],
    '7.5' => [15, 15, 15],
    '7.6' => [8, 8, 8],
    '7.7' => [5, 5, 5],
    '7.8' => [3, 3, 3],
    '7.9' => [10, 10, 10],
    '7.10' => [6, 6, 6],
    '7.11-7.12' => [5, 5, 5],
    '8.1-davetli' => [8, 8, 8],
    '8.1-sozlu' => [8, 8, 8],
    '8.1-poster' => [4, 4, 4],
    '8.2-sozlu' => [3, 3, 4],
    '8.2-poster' => [2, 2, 2],
    '9.1' => [3, 3, 3],
    '9.2' => [3, 3, 3],
    '10.1' => [2, 2, 2],
    '10.2-10.6' => [1, 1, 1],
    '10.7' => [3, 3, 3],
    '10.8' => [5, 5, 5],
    '10.9' => [4, 4, 4],
    '10.10' => [3, 3, 3],
    '10.11' => [6, 6, 6],
    '10.12' => [1, 1, 1],
    '11.2' => [5, 5, 5],
    '11.3' => [3, 3, 3],
];

/**
 * Koşulların andığı kod kümeleri. Tek haneli bölüm numaraları için nokta
 * zorunlu: `'1*'` deseni 10. ve 11. bölümü de yakalardı.
 *
 * @var array<string, list<string>>
 */
$gruplar = [
    '1' => ['1.*'],
    '1.1' => ['1.1-*'],
    '2' => ['2.*'],
    '3' => ['3.*'],
    '4' => ['4.*'],
    '5' => ['5.*'],
    '6' => ['6.*'],
    '7' => ['7.*'],
    '8' => ['8.*'],
    '9' => ['9.*'],
    '10' => ['10.*'],
    '11' => ['11.*'],

    // MADDE 5.d / 9.e / 13.d / 6.c / 10.ç / 14.c'nin andığı kod kümeleri.
    '1-2-3' => ['1.*', '2.*', '3.*'],
    '1-2-3-4' => ['1.*', '2.*', '3.*', '4.*'],
    '7.1-7.6' => ['7.1', '7.2', '7.3', '7.4', '7.5', '7.6'],
    '1-2-3-4-7.1-7.6' => ['1.*', '2.*', '3.*', '4.*', '7.1-7.6'],

    // MADDE 2.ç'deki başlıca eser tanımları.
    'BASLICA-MF' => ['1.1-*'],
    'BASLICA-MF-DR' => ['1.1-*', '2.1'],
    'BASLICA-SBI' => ['1.1-*', '1.2', '1.3', '2.1', '2.2', '2.6', '3.1', '3.2', '3.3', '3.4'],
    'BASLICA-MPT' => ['1.1-*', '1.2', '1.3', '2.1', '2.2', '2.6', '3.1', '3.2', '3.4',
        '4.1-4.2', '4.3a', '4.3b', '4.7', '4.8a', '4.8b'],

    // MADDE 7.ç / 9.ç / 10.a: "SCI, SCI-E, SSCI veya AHCI kapsamındaki
    // dergilerde özgün makale" — tezden üretilmiş olanı da kapsıyor.
    'SCI-MAKALE' => ['1.1-*', '2.1'],

    // MADDE 8.ç / 12.ç: "en az iki yayın daha (makale veya bildiri)".
    'MAKALE-BILDIRI' => ['1.*', '2.*', '8.*'],

    // MADDE 8.d / 12.e: "üniversite kaynakları dışında ulusal veya
    // uluslararası projede yürütücü veya araştırmacı" — BAP (7.7, 7.8) hariç.
    'PROJE-DIS' => ['7.1', '7.2', '7.3', '7.4', '7.5', '7.6', '7.9', '7.10', '7.11-7.12'],

    // MADDE 12.d: "ulusal ve/veya uluslararası proje yarışmalarında ödül".
    'YARISMA-ODUL' => ['4.1-4.2'],

    // MADDE 5.e / 6.d / 9.f / 10.e / 13.e / 14.d: asıl danışmanlık.
    'TEZ-ASIL' => ['6.1', '6.2'],
];

// Kadro başına değişen bölüm tavanları. Sabit olanlar (3, 4, 8, 10, 11)
// her varyantta aynı.
$tavanlar = [
    'dr' => ['3' => 35, '4' => 40, '5' => 15, '8' => 40, '9' => 20, '10' => 25, '11' => 40],
    'docent' => ['3' => 35, '4' => 40, '5' => 35, '6' => 40, '8' => 40, '9' => 40, '10' => 25, '11' => 40],
    'profesor' => ['3' => 35, '4' => 40, '5' => 50, '6' => 60, '8' => 40, '9' => 60, '10' => 25, '11' => 40],
];

// "ORTAK ÇALIŞMALARDA PUAN DAĞILIMI": tek kişi p, iki kişi 0,8p, ikiden
// fazlaysa 1,8p/n ve n dörtten büyükse n=4. Çarpan yalnızca KİŞİ SAYISINA
// bağlı, sıraya değil; bütün roller aynı kademeleri paylaşıyor.
$kademeler = ['kademeler' => [1 => 1.00, 2 => 0.80, 3 => 0.60, 4 => 0.45], 'sonrasi' => 0.45];

$yazarKatsayisi = [
    'haric' => ['atif', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev',
        'odul', 'editorluk', 'toplumsal_katki'],
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.0]],
        'ilk' => $kademeler,
        'baslica' => $kademeler,
        'yazar_2' => $kademeler,
        'yazar_3' => $kademeler,
        'yazar_4' => $kademeler,
        'yazar_5' => $kademeler,
        'yazar_6' => $kademeler,
        'ortak' => $kademeler,
    ],
];

$alanlar = [
    'mf' => [0, 'Mühendislik, Havacılık ve Uzay Bilimleri, Fen Bilimleri ve Matematik Temel Alanı'],
    'sbi' => [1, 'Sosyal, Beşeri ve İdari Bilimler Temel Alanı'],
    'mpt' => [2, 'Mimarlık, Planlama ve Tasarım Temel Alanı'],
];

$kadroAdlari = [
    'dr' => 'Doktor Öğretim Üyesi',
    'docent' => 'doçent',
    'profesor' => 'profesör',
];

$cetveller = [];

foreach ($alanlar as $alan => [$sutun, $alanAdi]) {
    $maddeler = [];

    foreach ($satirlar as $kod => $satir) {
        $puan = $puanlar[$kod][$sutun];

        // "GD (Geçerli Değil)" — satır bu temel alanda hiç puan almıyor.
        if ($puan === null) {
            continue;
        }

        $maddeler[$kod] = [...$satir, 'puan' => $puan];
    }

    foreach ($tavanlar as $kadro => $tavan) {
        // MADDE 6.c yalnızca Mühendislik/Fen profesörlüğünde: "2 kodlu
        // faaliyet başlığından en fazla 80 puan".
        if ($alan === 'mf' && $kadro === 'profesor') {
            $tavan['2'] = 80;
        }

        $cetveller["gebze-teknik-2023-{$alan}-{$kadro}"] = [
            'kapsam_notu' => 'Puanlar Gebze Teknik Üniversitesi Akademik Yükseltme ve Atama Koşulları '
                ."Yönergesi EK 1 Faaliyet Puanlama Tablosu'nun \"{$alanAdi}\" sütunundan; bölüm "
                ."tavanları {$kadroAdlari[$kadro]} kadrosuna göre uygulanıyor. Yazar çarpanı "
                .'yönergenin "Ortak Çalışmalarda Puan Dağılımı" tablosuna göre işliyor (tek yazar tam '
                .'puan, iki yazar 0,80; ikiden fazlaysa 1,8/n ve n dörtten büyükse n=4 alınır). '
                .'Yazar listesini boş bırakırsanız çarpan hiç uygulanmaz ve puanınız olduğundan '
                .'YÜKSEK görünür. '
                .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: idari görev puanı yönergede '
                .'"görevde her yıl için 3 puan" iken yıl biriktirmesi hesaplanamadığı için görev '
                .'başına tek yıl sayılıyor; aynı kitapta birden fazla bölüm yazdıysanız yönergenin '
                .'(1+k/c) çarpanı uygulanmıyor; yarışma ödülleri derece ve mansiyon ayrımı '
                .'yapılamadığı için en düşük değerden, dergi editörlükleri editör ile konuk editör '
                .'ayrımı yapılamadığı için en düşük değerden, bütün hakemlik kalemleri tek satırdan '
                .'(1 puan) sayılıyor. '
                .($alan === 'mf'
                    ? 'Lisansüstü tezinizden üretilmiş SCI makaleniz çeyreklik bilgisi taşımadığı '
                        .'için en düşük çeyreklikten (5 puan) sayılıyor. '
                    : '')
                .($alan === 'mpt'
                    ? 'Yönergenin puanlama tablosunda sergi, konser ve tasarım gibi sanatsal '
                        .'etkinlik satırı YOK; sanat ve tasarım faaliyetiniz yalnızca yarışma '
                        .'ödülü, uygulama projesi ve patent satırlarından puan alabiliyor. '
                        .'Küratörlük kalemi hiç girilemedi. '
                    : '')
                .'GTÜ "Yılın Bilim İnsanı" ödülü, yardımcı öğretim elemanlığı, faydalı model, '
                .'ansiklopedi maddesi ve kurul/komisyon üyeliği kalemleri hiç girilemedi. '
                .'Puanınız şu kalemde OLDUĞUNDAN YÜKSEK görünebilir: atıf puanı yönergede "adayın '
                .'atıf yapılan her eseri için" veriliyor, kayıt ise atıf başına tutuluyor.',
            'yazar_katsayisi' => $yazarKatsayisi,
            'maddeler' => $maddeler,
            'gruplar' => $gruplar,
            'grup_tavanlari' => $tavan,
        ];
    }
}

return ['cetveller' => $cetveller];
