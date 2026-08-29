<?php

/**
 * KARADENİZ TEKNİK ÜNİVERSİTESİ — EK-15 Değerlendirmede Kullanılacak Puanlar
 * Tablosu
 * Kaynak: pdf/17536999312.karadenizteknikuniverstesi.pdf (48 sayfa;
 *         17.10.2023 tarih ve 342 sayılı Senato değişiklikleriyle)
 *
 * KAYNAK PDF TARANMIŞ; 150-250 dpi görüntüden `tesseract -l tur` ile okundu ve
 * BÜTÜN PUAN SÜTUNU sayfa görüntülerinden gözle doğrulandı. OCR'ın yanlış
 * okuduğu satırlar: 10/A-f ve 10/A-g yapımcılık ve koordinatörlük 15 değil
 * 1,5; EK-1'in yurt dışı alternatifi "430"/"930" değil %30; kongre bildirisi
 * satırlarındaki çeyrek harfleri (Q1-Q4) tamamen çöp çıkmıştı.
 *
 * DOKUZ CETVEL VARYANTI ÜRETİYOR. Bölüm tavanları hem KADROYA hem FAKÜLTEYE
 * göre değiştiği için (tavan profili × kadro) çarpımı gerekti:
 *
 *                       Kitap        Atıf         Bildiri
 *   fen profili         60/60/60     160/120/15   50/50/40
 *   sosyal profili     120/90/60     160/160/15   50/50/40
 *   mimarlık profili    80/80/60     160/160/15   70/70/50
 *   (üçünde de: tez 30/30/—, editörlük 20/20/10, diğer 30/30/15;
 *    makale, proje, ödül ve patent bölümlerinde tavan yok)
 *
 * Fakülte → profil eşlemesi yönerge dosyasında; sosyal profili yalnız
 * Edebiyat ve İİBF'de, mimarlık profili yalnız Mimarlık Fakültesinde (ve
 * Orman Fakültesinin Peyzaj Mimarlığı Bölümünde) geçerli.
 *
 * ── ÇEYREK DİLİMİ SATIRA GÖMÜLÜ, "TAM/DİĞER MAKALE" AYRIMI `turler` İLE ──
 * Tablo her çeyrek için iki değer veriyor: tam makale / diğer makale. "Diğer
 * makale" tanımı teknik not, kısa makale, yorum, vaka takdimi, editöre mektup,
 * özet, kitap kritiği, araştırma notu VE DERLEME MAKALE. Derleme bu yüzden
 * `turler`de düşük satıra bağlandı.
 * AHCI dergilerinin WoS çeyreği olmadığı için tablo Scimago'ya bakmayı
 * söylüyor; kayıt çeyrek taşımadığından AHCI §0 gereği Q4 satırından (25/20)
 * sayılıyor.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR (§0) ──
 *   1d (SCOPUS 30/25) ile 1e (ESCI 20/15) tek "ESCI / Scopus" etiketine
 *       düşüyor → 20/15.
 *   PROJE BÖLÜMÜNÜN TAMAMI "DEVAM EDEN" DEĞERLERİNDEN sayılıyor: tablo her
 *       proje türü için tamamlanmış ve devam eden diye iki değer veriyor
 *       (AB 60 ↔ 30, TÜBİTAK 40 ↔ 20, kamu 45-20 ↔ 25-10), kayıt projenin
 *       bitip bitmediğini tutmuyor. Eşiklerin kendisi de "tamamlanmış veya
 *       devam eden projeler için puanlama yapılabilir" diyor.
 *   Kamu ve özel sektör projelerinde bütçe basamakları (45/40/30/25/20) kayıtta
 *       yok; en düşük basamaktan sayılıyor.
 *   3a (SCI atfı 3) ile 3b'nin Scopus kolu (2) tek "WoS / Scopus" etiketi → 2.
 *   6a (uluslararası davetli konuşmacı 16) ile 6ç (ulusal 8) tek "Davetli
 *       Konuşmacı" etiketi → 8; bu yüzden davetli konuşmacılık eşiklerin
 *       "(6a),(6b),(6c) kapsamında en az 10 puan" koşuluna GİRMİYOR.
 *   6b'nin özeti (8) ile 6c posteri (4) → 4; 6d'nin özeti (4) ile 6e posteri
 *       (2) → 2.
 *   2a (uluslararası kitap 80/60) ile 2f-2g (ulusal 40/30): BKCI etiketi
 *       uluslararası satırdan, genel kitap etiketi ulusal satırdan.
 *   7a (SCI/Scopus dergi editörlüğü 20), 7b (ESCI 10) ve 7c (Scopus Q 8) —
 *       ESCI ile Scopus tek etiket olduğu için 8'den.
 *   7d-7g makale editörlüğü ve hakemlik (5/3/2/1,5/1) tek "Hakemlik" etiketi
 *       → 1.
 *   9b (uluslararası faydalı model ve tasarım 30) ile 9c (ulusal 20) → 20.
 *   9g (uluslararası kişisel sergi 40, ulusal 20) → 20; 9h karma sergi
 *       (10/5) → 5.
 *   10/A-a (uluslararası kurul üyeliği 3) ile 10/A-b (ulusal 1,5) → 1.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   1g-1i KONGRE BİLDİRİSİNİN DERGİDE YAYIMLANMASI (Q1-Q4 için 20/10, 15/8,
 *       10/5, 5/3): kayıt bir bildirinin hangi dergide yayımlandığını
 *       tutmuyor.
 *   1f'nin "diğer hakemli uluslararası veya TR Dizin" tanımı TR Dizin dışı
 *       ulusal hakemli dergileri KAPSAMIYOR; o dergilerdeki makaleler tabloda
 *       hiç puanlanmıyor.
 *   2b, 2ç, 2d, 2e çeviri editörlüğü kademeleri; 3d-3f kitap ve patent
 *       atıflarının ondalıklı satırları (2,5 ve 1,5); 4a TÜBİTAK 2244 ve YÖK
 *       100/2000 tez danışmanlığı (25); 5'in COST asıl/ikincil öneren ve
 *       kamu-üniversite-sanayi satırları; 8'in burs ve teşekkür belgeleri
 *       (yönerge zaten hariç tutuyor).
 *   10/A-d laboratuvar kurma (3), 10/A-e teknokent şirketi (20), 10/A-h radyo
 *       ve televizyon söyleşisi (2), 10/B-ı ve 10/B-i kazı başkanlığı ve
 *       katılımı (3 ve 2), 10/B-k resmi görevlendirmeler (1,5), 10/C-n
 *       üniversite ve eğitim projeleri koordinatörlüğü (10).
 *   REKTÖRLÜK, DEKANLIK VE MÜDÜRLÜĞÜN SATIRI YOK: 10/B-l yalnız bölüm ve
 *       anabilim dalı başkanlığı ile rektör tarafından görevlendirilen
 *       koordinatörlükleri sayıyor. Dekan ya da rektör olan adayın bu
 *       görevlerden puanı SIFIR.
 *
 * ── YAZAR ÇARPANI (Çizelge 1) ──
 * Yazar sayısı × isim sırası matrisi. AMA 1. bölümün dipnotu "yayındaki
 * BAŞLICA YAZAR, SIRASINA BAKILMAKSIZIN TAM PUANI ALIR" diyor ve başlıca
 * yazar tanımına "makalenin yazarlarından ilk sırada yer alan yazar" da
 * dâhil; bu yüzden `tek`, `ilk` ve `baslica` rolleri 1,00 alıyor, matris
 * yalnız ikinci ve sonraki isimlerde işliyor.
 * Çizelge KİTAPLARI DIŞARIDA BIRAKIYOR (2. bölüm "puanlar eşit olarak
 * bölünür" diyor); motor cetvel başına tek matris tanımladığı için §1'in
 * Acıbadem istisnası uygulandı ve MAKALE kuralı seçildi — bütün alt barajlar
 * makale bölümü üzerine kurulu. Çok yazarlı kitapta başlıca yazarın puanı bu
 * yüzden olduğundan yüksek görünür.
 * Atıf ("atıf puanları yazar sayısına bölünmez"), proje (rol satırları),
 * patent ("buluşçu katkısı oranında"), tez, ders, editörlük ve idari görev
 * matrisin dışında.
 *
 * Yönerge: yonerge/ktu.php
 */
$TAM = ['ozgun_makale'];
$DIGER = ['derleme', 'kisa_makale', 'vaka_teknik_not'];
$WOSQ = ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'];

$maddeler = [
    // ══ 1. MAKALE ══
    '1a' => ['baslik' => 'Q1 dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $TAM, 'puan' => 45],
    '1a.2' => ['baslik' => 'Q1 dergide derleme, teknik not, kısa makale, vaka takdimi, editöre mektup ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $DIGER, 'puan' => 35],
    '1b' => ['baslik' => 'Q2 dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $TAM, 'puan' => 35],
    '1b.2' => ['baslik' => 'Q2 dergide derleme, teknik not, kısa makale, vaka takdimi, editöre mektup ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $DIGER, 'puan' => 30],
    '1c' => ['baslik' => 'Q3 dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $TAM, 'puan' => 30],
    '1c.2' => ['baslik' => 'Q3 dergide derleme, teknik not, kısa makale, vaka takdimi, editöre mektup ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $DIGER, 'puan' => 25],
    '1ç' => ['baslik' => 'Q4 dergide ya da AHCI kapsamındaki dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => $TAM, 'puan' => 25],
    '1ç.2' => ['baslik' => 'Q4 ya da AHCI dergisinde derleme, teknik not, kısa makale, vaka takdimi, editöre mektup ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => $DIGER, 'puan' => 20],
    '1e' => ['baslik' => 'ESCI ya da Scopus dergisinde tam makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $TAM, 'puan' => 20],
    '1e.2' => ['baslik' => 'ESCI ya da Scopus dergisinde derleme, teknik not, kısa makale, vaka takdimi, editöre mektup ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $DIGER, 'puan' => 15],
    '1f' => ['baslik' => 'Diğer hakemli uluslararası ya da TR Dizin kapsamındaki dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'TR Dizin'], 'turler' => $TAM, 'puan' => 15],
    '1f.2' => ['baslik' => 'Diğer hakemli uluslararası ya da TR Dizin dergisinde derleme, teknik not, kısa makale, vaka takdimi, editöre mektup ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'TR Dizin'], 'turler' => $DIGER, 'puan' => 5],

    // ══ 2. KİTAP ══
    '2a' => ['baslik' => 'Web of Science Book Citation Index kapsamındaki kitapta yazarlık', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 80],
    '2a.e' => ['baslik' => 'Web of Science Book Citation Index kapsamındaki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 60],
    '2c' => ['baslik' => 'Web of Science Book Citation Index kapsamındaki kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 50],
    '2f' => ['baslik' => 'Tanınmış yayınevince yayımlanmış kitapta yazarlık', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı'], 'puan' => 40],
    '2g' => ['baslik' => 'Tanınmış yayınevince yayımlanmış kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 30],
    '2h' => ['baslik' => 'Tanınmış yayınevince yayımlanmış kitapta bölüm ya da ansiklopedi maddesi yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 10],
    '2i' => ['baslik' => 'Bilimsel kitap çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 15],
    '2k' => ['baslik' => 'Bilimsel kitap bölümü çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 10],
    '2l' => ['baslik' => 'Tahkik, neşir, araştırma notu ya da detaylı kitap kritiği', 'kategori' => 'kitap', 'kaynaklar' => ['Tahkik (Tenkitli Metin)'], 'puan' => 5],

    // ══ 3. ATIF ══
    '3b' => ['baslik' => 'Web of Science ya da Scopus dergilerinde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 2],
    '3ç' => ['baslik' => 'Web of Science Book Citation Index kapsamındaki kitapta eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 3],
    '3c' => ['baslik' => 'TR Dizin ile diğer ulusal ve uluslararası yayınlarda eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 1],

    // ══ 4. LİSANSÜSTÜ TEZ DANIŞMANLIĞI ══
    '4b' => ['baslik' => 'Danışman olarak yönetilmiş doktora, uzmanlık ya da sanatta yeterlik tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 20],
    '4b.e' => ['baslik' => 'Eş danışman olarak yönetilmiş doktora, uzmanlık ya da sanatta yeterlik tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 10],
    '4c' => ['baslik' => 'Danışman olarak yönetilmiş tezli yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 10],
    '4c.e' => ['baslik' => 'Eş danışman olarak yönetilmiş tezli yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 5],

    // ══ 5. BİLİMSEL ARAŞTIRMA PROJESİ (devam eden değerlerinden) ══
    '5a.y' => ['baslik' => 'Avrupa Birliği Çerçeve Programı projesinde koordinatör ya da yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 30],
    '5a.a' => ['baslik' => 'Avrupa Birliği Çerçeve Programı projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci'], 'puan' => 15],
    '5a.b' => ['baslik' => 'Avrupa Birliği Çerçeve Programı projesinde bursiyer ya da danışman', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['bursiyer', 'danisman'], 'puan' => 7],
    '5c.y' => ['baslik' => 'Diğer uluslararası kuruluşlarca desteklenen projede koordinatör ya da yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 20],
    '5c.a' => ['baslik' => 'Diğer uluslararası kuruluşlarca desteklenen projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci'], 'puan' => 10],
    '5c.b' => ['baslik' => 'Diğer uluslararası kuruluşlarca desteklenen projede bursiyer ya da danışman', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['bursiyer', 'danisman'], 'puan' => 5],
    '5d.y' => ['baslik' => 'TÜBİTAK ya da TÜBA destekli Ar-Ge projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 20],
    '5d.a' => ['baslik' => 'TÜBİTAK ya da TÜBA destekli Ar-Ge projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci'], 'puan' => 10],
    '5d.b' => ['baslik' => 'TÜBİTAK ya da TÜBA destekli Ar-Ge projesinde bursiyer ya da danışman', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['bursiyer', 'danisman'], 'puan' => 5],
    '5d.o' => ['baslik' => 'TÜBİTAK 2209 gibi öğrenci projesinde danışman', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'puan' => 3],
    '5f.y' => ['baslik' => 'Kamu kuruluşlarınca desteklenen Ar-Ge projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 10],
    '5f.a' => ['baslik' => 'Kamu kuruluşlarınca desteklenen Ar-Ge projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['arastirmaci'], 'puan' => 5],
    '5f.b' => ['baslik' => 'Kamu kuruluşlarınca desteklenen Ar-Ge projesinde bursiyer ya da danışman', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['bursiyer', 'danisman'], 'puan' => 2],
    '5h' => ['baslik' => 'Yükseköğretim kurumunca desteklenen Ar-Ge projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 5],
    '5i' => ['baslik' => 'Özel kuruluşlarca desteklenen Ar-Ge, yenilik ya da özgün tasarım projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 5],

    // ══ 6. BİLİMSEL TOPLANTI ══
    '6b' => ['baslik' => 'Uluslararası bilimsel toplantıda sözlü sunulmuş ve tam metni basılmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 12],
    '6c' => ['baslik' => 'Uluslararası bilimsel toplantıda özet ya da poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 4],
    '6ç' => ['baslik' => 'Bilimsel toplantıda davetli konuşmacı olarak sunum yapmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 8],
    '6d' => ['baslik' => 'Ulusal bilimsel toplantıda sözlü sunulmuş ve tam metni basılmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 6],
    '6e' => ['baslik' => 'Ulusal bilimsel toplantıda özet ya da poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 2],

    // ══ 7. EDİTÖRLÜK VE HAKEMLİK ══
    '7a' => ['baslik' => 'SCI, SCI-Expanded, SSCI, AHCI ya da Scopus kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => $WOSQ, 'puan' => 20],
    '7c' => ['baslik' => 'ESCI ya da Scopus dergisinde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 8],
    '7ç' => ['baslik' => 'Diğer hakemli ulusal ya da uluslararası dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 5],
    '7g' => ['baslik' => 'Dergide makale editörlüğü ya da hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 1],

    // ══ 8. ÖDÜL ══
    '8a' => ['baslik' => 'TÜBA ya da TÜBİTAK bilim, teşvik, sanat veya araştırma ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 60],
    '8b' => ['baslik' => 'Alanınızda yurt dışı kurum ya da kuruluşlardan alınan bilim, teşvik, sanat, tasarım veya araştırma ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 50],
    '8c' => ['baslik' => 'Alanınızda yurt içi kamu kurum ve kuruluşlarından alınan ödül ile YÖK ödülleri', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'YÖK Ödülü'], 'puan' => 25],
    '8ç' => ['baslik' => 'Meslek alanına yönelik uluslararası ya da ulusal yarışma ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 10],

    // ══ 9. PATENT, FAYDALI MODEL, TASARIM VE SERGİ ══
    '9a' => ['baslik' => 'Kendiniz buluş sahibi olmak şartıyla ticarileştirilmiş patent sahipliği', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 70],
    '9b' => ['baslik' => 'Uluslararası tescillenmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 60],
    '9c' => ['baslik' => 'Ulusal tescillenmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 40],
    '9c.2' => ['baslik' => 'Tescillenmiş faydalı model ya da tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 20],
    '9c.3' => ['baslik' => 'Tescillenmiş telif hakkı', 'kategori' => 'patent', 'kaynaklar' => ['Yazılım'], 'puan' => 5],
    '9d' => ['baslik' => 'Uygulanmış ve belgelenmiş sanatsal ya da bilimsel tasarım müellifi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif', 'Özgün Eser / Beste / Tasarım'], 'puan' => 10],
    '9d.d' => ['baslik' => 'Uygulanmış tasarımda danışman ya da koordinatör', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Danışman'], 'puan' => 7],
    '9d.e' => ['baslik' => 'Uygulanmış tasarımda ekip üyesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Ekip'], 'puan' => 5],
    '9d.y' => ['baslik' => 'Uygulanmış tasarımda ekip yardımcısı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Ekip Yardımcısı'], 'puan' => 3],
    '9g' => ['baslik' => 'Özgün kişisel sergi ya da proje pazarı katılımı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Elektronik Kişisel Sergi (Ulusal)', 'Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt İçi)'], 'puan' => 20],
    '9h' => ['baslik' => 'Davetli ya da yarışmalı karma sergi, bienal, festival veya gösterim', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Uluslararası)', 'Elektronik Karma Sergi (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)'], 'puan' => 5],

    // ══ 10. DİĞER ETKİNLİKLER ══
    '10Aa' => ['baslik' => 'Yayın, değerlendirme kurulu ya da ödül jürisi üyeliği; bakanlık, YÖK veya TÜBİTAK komisyon ve kurul üyelikleri', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 1],
    '10Aa.2' => ['baslik' => 'Kurum kurul ve komisyon üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği', 'Senato / Üniversite Yönetim Kurulu Üyesi'], 'puan' => 1],
    '10Ac' => ['baslik' => 'Sergi küratörlüğü; sanat ve tasarım yarışmalarında jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 1],
    '10Ag' => ['baslik' => 'Yapımcı, yönetmen, senarist, görüntü yönetmeni ya da sanat yönetmeni olarak görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Yönetmenlik (Sahne/Ekran)', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)'], 'puan' => 1],
    '10Bj' => ['baslik' => 'Lisansüstü tez jürisi üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 1],
    '10Bl' => ['baslik' => 'Bölüm ya da anabilim dalı başkanlığı, rektörlükçe görevlendirilen koordinatörlük (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 3],
    '10Bl.y' => ['baslik' => 'Bölüm ya da anabilim dalı başkan yardımcılığı (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı'], 'puan' => 1],
    '10Bm' => ['baslik' => 'Kredili ders vermek (dönem başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi', 'Akreditasyon Faaliyeti'], 'puan' => 2],
    '10Co' => ['baslik' => 'Sosyal sorumluluk projesinde görev almak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi', 'Kamu/STK Danışmanlığı', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 5],
];

$M1AC = ['1a', '1a.2', '1b', '1b.2', '1c', '1c.2', '1ç', '1ç.2'];
$M1AE = [...$M1AC, '1e', '1e.2'];
$M1AI = [...$M1AE, '1f', '1f.2'];
$M1AB = ['1a', '1a.2', '1b', '1b.2'];
$KITAP = ['2a', '2a.e', '2c', '2f', '2g', '2h', '2i', '2k', '2l'];
$ATIF = ['3b', '3ç', '3c'];
$TEZ = ['4b', '4b.e', '4c', '4c.e'];
$PROJE = ['5a.y', '5a.a', '5a.b', '5c.y', '5c.a', '5c.b', '5d.y', '5d.a', '5d.b', '5d.o',
    '5f.y', '5f.a', '5f.b', '5h', '5i'];
$BILDIRI = ['6b', '6c', '6ç', '6d', '6e'];
$EDITORLUK = ['7a', '7c', '7ç', '7g'];
$ODUL = ['8a', '8b', '8c', '8ç'];
$PATENT = ['9a', '9b', '9c', '9c.2', '9c.3', '9d', '9d.d', '9d.e', '9d.y', '9g', '9h'];
$DIGER_B = ['10Aa', '10Aa.2', '10Ac', '10Ag', '10Bj', '10Bl', '10Bl.y', '10Bm', '10Co'];

$gruplar = [
    'TUM' => array_keys($maddeler),
    'MAKALE' => $M1AI,
    '1a-1ç' => $M1AC,
    '1a-1e' => $M1AE,
    '1a-1i' => $M1AI,
    '1a-1b' => $M1AB,
    'KITAP' => $KITAP,
    'ATIF' => $ATIF,
    'TEZ' => $TEZ,
    'TEZ-DOKTORA' => ['4b', '4b.e'],
    'TEZ-YL' => ['4c', '4c.e'],
    'PROJE' => $PROJE,
    'BILDIRI' => $BILDIRI,
    // Eşiklerin andığı "(6a), (6b), (6c)" kümesi: uluslararası bildiriler.
    'BILDIRI-ULUS' => ['6b', '6c'],
    'EDITORLUK' => $EDITORLUK,
    'ODUL' => $ODUL,
    'PATENT' => $PATENT,
    'DIGER' => $DIGER_B,
];

/** Çizelge 1; başlıca yazar sırasına bakılmaksızın tam puan alır (1. bölüm dipnotu). */
$yazarKatsayisi = [
    'haric' => ['atif', 'proje', 'patent', 'tez_danismanligi', 'egitim_ogretim', 'editorluk',
        'idari_gorev', 'sanatsal_etkinlik', 'toplumsal_katki', 'diger'],
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.00]],
        'ilk' => ['kademeler' => [1 => 1.00]],
        'baslica' => ['kademeler' => [1 => 1.00]],
        'yazar_2' => ['kademeler' => [2 => 0.85, 3 => 0.80, 4 => 0.75, 5 => 0.70], 'sonrasi' => 0.65],
        'yazar_3' => ['kademeler' => [3 => 0.75, 4 => 0.70, 5 => 0.65], 'sonrasi' => 0.60],
        'yazar_4' => ['kademeler' => [4 => 0.60, 5 => 0.55], 'sonrasi' => 0.50],
        'yazar_5' => ['kademeler' => [5 => 0.50], 'sonrasi' => 0.45],
        'yazar_6' => ['sonrasi' => 0.35],
        'ortak' => ['kademeler' => [1 => 1.00, 2 => 0.85, 3 => 0.75, 4 => 0.60, 5 => 0.50], 'sonrasi' => 0.25],
    ],
];

$kapsamNotu = 'Puanlar Karadeniz Teknik Üniversitesi Öğretim Üyeliğine Yükseltilme ve Atanma '
    .'Yönergesinin EK-15 Puanlar Tablosundan (17.10.2023 tarih ve 342 sayılı Senato '
    .'değişiklikleriyle). Kaynak PDF taranmış; OCR ile okundu, puan sütununun tamamı gözle '
    .'doğrulandı. Makalelerde ÇEYREK DİLİMİ satıra gömülü ve her çeyrek için iki değer var: '
    .'tam makale ile "diğer makale" (teknik not, kısa makale, vaka takdimi, editöre mektup, '
    .'özet, kitap kritiği VE DERLEME). Derlemeleriniz bu yüzden düşük satırdan sayılıyor. '
    .'BAŞLICA YAZAR SIRASINA BAKILMAKSIZIN TAM PUAN ALIYOR (1. bölüm dipnotu) ve "ilk sırada '
    .'yer alan yazar" da başlıca yazar sayılıyor; matris yalnız ikinci ve sonraki isimlerde '
    .'işliyor. '
    .'PUANINIZ ŞU KALEMLERDE OLDUĞUNDAN DÜŞÜK GÖRÜNÜR: PROJE BÖLÜMÜNÜN TAMAMI "devam eden" '
    .'değerlerinden sayılıyor (tablo tamamlanmış projeye iki katını veriyor ama kayıt projenin '
    .'bitip bitmediğini tutmuyor); kamu ve özel sektör projelerinde bütçe basamakları '
    .'bilinmediği için en düşük basamak uygulanıyor. Kongre bildirisinin dergide yayımlanması '
    .'(1g-1i, 20 puana kadar), TR Dizin dışındaki ulusal hakemli dergilerdeki makaleler, çeviri '
    .'editörlüğü kademeleri, TÜBİTAK 2244 ve YÖK 100/2000 tez danışmanlığı, laboratuvar kurma, '
    .'teknokent şirketi, kazı başkanlığı ve üniversite eğitim projeleri koordinatörlüğü kayıtta '
    .'karşılıksız kaldı. REKTÖRLÜK, DEKANLIK VE MÜDÜRLÜĞÜN TABLODA SATIRI YOK; bu görevlerden '
    .'puan alınmıyor. Aynı etikete düşen satırlarda daima düşüğü sayılıyor: Scopus makalesi '
    .'ESCI değerinden (20/15), uluslararası davetli konuşmacılık ulusal değerinden (8), '
    .'uluslararası bildiri özeti poster değerinden (4), SCI atfı Scopus değerinden (2), '
    .'hakemlik en düşük dergiden (1), uluslararası kişisel sergi ulusal değerinden (20). '
    .'PUANINIZ ŞU KALEMDE OLDUĞUNDAN YÜKSEK GÖRÜNEBİLİR: Çizelge 1 kitapları dışarıda '
    .'bırakıyor (kitapta puan eşit bölünüyor) ama motor cetvel başına tek matris tanımladığı '
    .'için makale kuralı seçildi; çok yazarlı kitapta başlıca yazarın puanı yüksek çıkar. '
    .'İdari görev ve ders puanları da görev süresiyle çarpılmıyor.';

/** Tavan profilleri: [kitap, atıf, bildiri] — kadro sırası profesör, doçent, Dr. Öğr. Üyesi. */
$profiller = [
    'fen' => ['kitap' => [60, 60, 60], 'atif' => [160, 120, 15], 'bildiri' => [50, 50, 40]],
    'sosyal' => ['kitap' => [120, 90, 60], 'atif' => [160, 160, 15], 'bildiri' => [50, 50, 40]],
    'mimarlik' => ['kitap' => [80, 80, 60], 'atif' => [160, 160, 15], 'bildiri' => [70, 70, 50]],
];

$kadrolar = ['prof' => 0, 'docentlik' => 1, 'dr' => 2];

$cetveller = [];

foreach ($profiller as $profilAd => $p) {
    foreach ($kadrolar as $kadroAd => $i) {
        $tavanlar = [
            'KITAP' => $p['kitap'][$i],
            'ATIF' => $p['atif'][$i],
            'BILDIRI' => $p['bildiri'][$i],
            'EDITORLUK' => $i === 2 ? 10 : 20,
            'DIGER' => $i === 2 ? 15 : 30,
        ];

        // Tez bölümünün tavanı yalnız profesörlük ve doçentlikte var.
        if ($i !== 2) {
            $tavanlar['TEZ'] = 30;
        }

        $cetveller["ktu-2023-{$profilAd}-{$kadroAd}"] = [
            'kapsam_notu' => $kapsamNotu.' Bu varyantın bölüm tavanları: kitap '
                .$p['kitap'][$i].', atıf '.$p['atif'][$i].', bildiri '.$p['bildiri'][$i]
                .', editörlük '.$tavanlar['EDITORLUK'].', diğer etkinlikler '
                .$tavanlar['DIGER'].($i === 2 ? '' : ', tez yönetimi 30')
                .'. Makale, proje, ödül ve patent bölümlerinde tavan yok.',
            'yazar_katsayisi' => $yazarKatsayisi,
            'maddeler' => $maddeler,
            'gruplar' => $gruplar,
            'grup_tavanlari' => $tavanlar,
        ];
    }
}

return ['cetveller' => $cetveller];
