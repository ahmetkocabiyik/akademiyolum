<?php

/**
 * İZMİR KAVRAM MESLEK YÜKSEKOKULU — Ek-1 puanlama cetveli
 * Kaynak: pdf/1766066729695.izmir-kavram-myo-kriter-18122025.pdf (7 sayfa)
 *
 * KAYNAK METNİN GLİF KAYBI VAR. PDF taranıp OCR'lanmış; "ı", "ş", "ğ" ve
 * "İ" harflerinin bir bölümü düşmüş ("Uluslararas at f indekslerince").
 * Puan değerlerinin TAMAMI okunabiliyor, başlık metni yer yer eksik.
 *
 * EKSİK BAŞLIKLAR 01.09.2026'DA SAYFA GÖRÜNTÜSÜNDEN OKUNDU (220 dpi, 3. ve
 * 5. sayfa). İki sonuç:
 *   2.c ve 2.d doğru tahmin edilmiş: "Diğer uluslararası yayınevleri
 *       tarafından yayımlanmış bilimsel kitap" (15) ve aynısının "editörlüğü
 *       veya bölüm yazarlığı" (10). Satırlar olduğu gibi kaldı.
 *   17. MADDE YANLIŞ OKUNMUŞ. Metin katmanı "2 ders … olmak" gösteriyordu ve
 *       ders BAŞINA 2 puan girilmişti; görüntüde madde "Yükseköğretim
 *       Kurumlarında 2 YIL ders vermiş olmak (En fazla 6 puan alınabilir)"
 *       diyor. Yani puan ders sayısına değil GÖREV SÜRESİNE bağlı. Bir
 *       dönemde dört ders veren aday tavanı tek dönemde dolduruyordu.
 *       Faaliyet kaydı ders süresini yıl olarak tutmadığı için satır
 *       kaldırıldı; §0 uyarınca eksik saymak fazla saymaya yeğ.
 *
 * ÜÇ CETVEL. Ek-1'in 15. maddesi "sadece güzel sanatlar temel alanı
 * için", 16. maddesi "sadece mimarlık, planlama ve tasarım temel alanı
 * için" yazıyor. Tek cetvelde toplanırsa bu satırlar bütün alanlara
 * açılırdı; bu yüzden:
 *   izmir-kavram-2025      1-14 ve 17. maddeler (bütün alanlar)
 *   izmir-kavram-2025-gsf  + 15. madde (güzel sanatlar)
 *   izmir-kavram-2025-mim  + 16. madde (mimarlık, planlama, tasarım)
 *
 * ── OKUNAMAYAN YERDE VERİLEN KARARLAR ──
 *   2.c ve 2.d satırlarının başlıkları eksik. Bölüm "Uluslararası
 *       Kitaplar", (a) ve (b) BKCI; (c) 15 puan ve (d) 10 puan "veya
 *       bölüm" ekiyle bitiyor. BKCI dışındaki uluslararası kitap (15) ve
 *       bölümü/editörlüğü (10) olarak okundu.
 *
 * ── EN ÇOK PUAN KAYBETTİREN KARARLAR ──
 *   13. MADDE (bilimsel ve sanatsal etkinlik düzenlemelerinde yer almak,
 *       5 ve 3) GİRİLMEDİ: düzenleme kurulu üyeliğinin kayıtta karşılığı
 *       olan bir etiket yok.
 *   18. MADDE (Web of Science h-indeksi, 5) ve 19. MADDE (yabancı dil
 *       sınavından 85+, 5) girilmedi; ikisi de faaliyet değil profil
 *       ölçütü.
 *   DERGİ EDİTÖRLÜĞÜ satırı yok. Cetvel yalnız hakemlik ve yayın kurulu
 *       üyeliğini puanlıyor; editörlük kayıtlarınız yayın kurulu
 *       satırından (uluslararası 2, ulusal 1) sayılıyor.
 *   LİSANSÜSTÜ TEZDEN ÜRETİLMİŞ YAYIN, İDARİ GÖREV ve TOPLUMSAL KATKI
 *       kalemlerinin cetvelde hiç karşılığı yok.
 *   16.b (Döner Sermaye ya da üniversiteye bağlı kuruluşlar aracılığıyla
 *       yapılan uygulama projesini yayımlamış olmak, 15) girilmedi;
 *       uygulama projesi etiketi kayıtta yok.
 *   3. maddenin "ders notu hariç" kaydı gereği ders ve metot kitapları
 *       kitap satırlarından çıkarıldı.
 *
 * ── AYNI ETİKETE DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   1.b E-SCI (20) ile 1.c diğer uluslararası indeksler (15) kayıtta tek
 *       "ESCI / Scopus" etiketine düşüyor; §0 uyarınca 15'ten sayılıyor.
 *       ESCI makaleniz varsa puanınız beş puan düşük görünür.
 *   Uluslararası faydalı model (20) ile ulusal faydalı model (15) tek
 *       etikette; 15'ten sayılıyor.
 *   11-12. maddelerde uluslararası (3 ve 2) ile ulusal (2 ve 1) hakemlik
 *       ve yayın kurulu üyeliği ayrımı kayıtta dergi türünden okunuyor;
 *       "Hakemlik" etiketi tek olduğu için en düşükten (2) sayılıyor.
 *   14. maddede davetli konuşmacı uluslararası 10 / ulusal 6; kayıtta
 *       ayrım yok, 6'dan sayılıyor.
 *
 * ── YAZAR ÇARPANI ──
 * Ek-2'nin "Ortak Çalışmalar İçin Puanlama Oranları" tablosu yazar
 * sayısı × sıra matrisi; birebir kademe tablosuna çevrildi. Tablonun
 * dipnotu "sorumlu yazar 1. isimle aynı değerlendirilir" diyor, bu
 * yüzden `baslica` ile `ilk` aynı satırı kullanıyor.
 *
 * Yönerge: yonerge/izmir-kavram.php
 *
 * KODLAR BİZE AİT — KAYNAKTA SATIR KODU YOK. Cetvel kodlarının SAYISAL
 * ÇEKİRDEĞİ kaynağın madde/bölüm numarasıdır; baştaki harf tabloyu ya da
 * eki, sondaki harf şıkkı gösterir ve ikisi de bizim eklediğimiz parçadır.
 * Koşullar bu kodlara atıf yaptığı için değiştirilmemeli; kaynakla
 * karşılaştırırken kodun sayısal çekirdeğine bakılmalı.
 */
$SCI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)'];
$OZGUN = ['ozgun_makale', 'derleme'];
$YURTDISI_PROJE = ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'];
$YURTICI_PROJE = ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK',
    'BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'];

$genel = [
    // ══ 1. MAKALELER ══
    '1a' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI kapsamındaki dergilerde yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => [...$SCI, 'AHCI'], 'turler' => $OZGUN, 'puan' => 30],
    '1c' => ['baslik' => 'ESCI, Scopus ya da diğer uluslararası indekslerde taranan dergilerde yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $OZGUN, 'puan' => 15],
    '1d' => ['baslik' => 'ULAKBİM tarafından taranan ulusal hakemli dergilerde yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $OZGUN, 'puan' => 10],
    '1e' => ['baslik' => 'Ulusal hakemli dergilerde yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $OZGUN, 'puan' => 4],
    '1f' => ['baslik' => 'Hakemli dergilerde yayımlanan kitap eleştirisi, araştırma notu ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => [...$SCI, 'AHCI', 'ESCI / Scopus', 'Diğer Uluslararası İndeks', 'TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 2],

    // ══ 2-3. KİTAPLAR ══
    '2a' => ['baslik' => 'Uluslararası yayınevleri tarafından yayımlanmış BKCI kapsamındaki bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 25],
    '2b' => ['baslik' => 'BKCI kapsamındaki kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 20],
    '2c' => ['baslik' => 'BKCI dışındaki uluslararası ya da ulusal yayınevi tarafından yayımlanmış bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 15],
    '2d' => ['baslik' => 'BKCI dışındaki kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 10],
    '2e' => ['baslik' => 'Çeviri kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 10],
    '2f' => ['baslik' => 'Çeviri kitapta editörlük ya da bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 5],
    '2b-ed' => ['baslik' => 'BKCI kapsamındaki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 20],
    '2d-ed' => ['baslik' => 'BKCI dışındaki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 5],

    // ══ 4. BİLDİRİLER — 14. DAVETLİ KONUŞMACI ══
    '4a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 8],
    '4b' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan özet ya da poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 4],
    '4d' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 4],
    '4e' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan özet ya da poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 2],
    '14a' => ['baslik' => 'Kongrede davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 6],

    // ══ 5. PROJELER ══
    '5a' => ['baslik' => 'Yurt dışı kaynaklı projede yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => $YURTDISI_PROJE, 'roller' => ['yurutucu'], 'puan' => 20],
    '5b' => ['baslik' => 'Yurt dışı kaynaklı projede çalışan olmak', 'kategori' => 'proje', 'kaynaklar' => $YURTDISI_PROJE, 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
    '5c' => ['baslik' => 'Yurt içi kaynaklı projede (TÜBİTAK, TAGEM, TEYDEB, BAP vb.) yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => $YURTICI_PROJE, 'roller' => ['yurutucu'], 'puan' => 10],
    '5d' => ['baslik' => 'Yurt içi kaynaklı projede (TÜBİTAK, TAGEM, TEYDEB, BAP vb.) çalışan olmak', 'kategori' => 'proje', 'kaynaklar' => $YURTICI_PROJE, 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 5],

    // ══ 6. ATIFLAR (en fazla 20 puan) ══
    '6a' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki yayınlarda eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 3],
    '6b' => ['baslik' => 'TR Dizin kapsamındaki yayınlarda eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
    '6c' => ['baslik' => 'Diğer uluslararası ya da ulusal atıf indekslerindeki yayınlarda eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap', 'Diğer', 'Patent', 'ESCI', 'Scopus'], 'puan' => 1],

    // ══ 7. ÖDÜLLER ══
    '7a' => ['baslik' => 'Uluslararası bilim ya da sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 20],
    '7b' => ['baslik' => 'YÖK ya da TÜBİTAK ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 10],
    '7c' => ['baslik' => 'Diğer ulusal ödüller', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'Yarışma Derecesi / Mansiyon', 'Burs'], 'puan' => 5],

    // ══ 8. PATENT / FAYDALI MODEL ══
    '8a' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 40],
    '8c' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 30],
    '8d' => ['baslik' => 'Faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 15],

    // ══ 9-10. TEZ DANIŞMANLIĞI ══
    '9a' => ['baslik' => 'Tamamlanmış doktora ya da uzmanlık tezinde birinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 6],
    '9b' => ['baslik' => 'Tamamlanmış doktora ya da uzmanlık tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 3],
    '10a' => ['baslik' => 'Tamamlanmış yüksek lisans tezinde birinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 3],
    '10b' => ['baslik' => 'Tamamlanmış yüksek lisans tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 2],
    '10c' => ['baslik' => 'Tez izleme komitesi ya da atama jürisi üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 2],

    // ══ 11-12. HAKEMLİK VE YAYIN KURULU ÜYELİĞİ ══
    '11a' => ['baslik' => 'Dergi, kitap ya da kongre hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 2],
    '11b' => ['baslik' => 'Uluslararası yayınlarda yayın kurulu üyeliği ya da editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi', 'Yayın Kurulu Üyeliği'], 'puan' => 2],
    '12b' => ['baslik' => 'Ulusal yayınlarda yayın kurulu üyeliği ya da editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 1],

];

// ══ 15. SANAT VE TASARIM ETKİNLİKLERİ (yalnız güzel sanatlar) ══
$sanat = [
    '15a' => ['baslik' => 'Özgün sanat eserinizin, tasarımınızın ya da yorum çalışmanızın yurt dışında satın alınması, sinema, televizyon veya radyoda yer alması ya da tasarım projenizin yurt dışında uygulanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Yayında Yer Alması / Satın Alınması', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Eserin Müzeye Kabulü (Yurt Dışı)'], 'puan' => 15],
    '15b' => ['baslik' => 'Özgün sanat eserinizin, tasarımınızın ya da yorum çalışmanızın yurt içinde satın alınması, sinema, televizyon veya radyoda yer alması ya da tasarım projenizin uygulanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Satın Alınması (Yurt İçi)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Eserin Müzeye Kabulü (Yurt İçi)'], 'puan' => 7],
    '15c' => ['baslik' => 'Özgün sanat yapıtınızla ya da icracı olarak yurt dışında bireysel sanat ve tasarım etkinliğine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Solistlik (Uluslararası)', 'Resital (Uluslararası)'], 'puan' => 12],
    '15d' => ['baslik' => 'Özgün sanat yapıtınızla ya da icracı olarak ulusal düzeyde bireysel sanat ve tasarım etkinliğine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)', 'Solistlik (Ulusal)', 'Resital (Ulusal)'], 'puan' => 7],
    '15e' => ['baslik' => 'Yurt dışında jürili karma sanat ve tasarım etkinliğine (sempozyum, festival, workshop, bienal, trienal) kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Elektronik Karma Sergi (Uluslararası)'], 'puan' => 7],
    '15f' => ['baslik' => 'Ulusal düzeyde jürili karma sanat ve tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 4],
    '15g' => ['baslik' => 'Diğer uluslararası sanat etkinlikleri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım', 'Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)', 'Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Masterclass (Uluslararası)', 'Belgesel/Kısa Film (Uluslararası)', 'Eserin Haber Olması (Uluslararası)'], 'puan' => 2],
    '15h' => ['baslik' => 'Diğer ulusal sanat etkinlikleri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra / Koro Üyeliği', 'Karma Albüm / CD-DVD Katkısı', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)', 'Masterclass (Ulusal)', 'Belgesel/Kısa Film (Ulusal)', 'Eserin Haber Olması (Ulusal)'], 'puan' => 1],
];

// ══ 16. PROJE, UYGULAMA, YAZILIM VE PATENT (yalnız mimarlık) ══
$mimarlik = [
    '16a' => ['baslik' => 'Planlama, mimarlık, kentsel tasarım, peyzaj, iç mimari ya da endüstri ürünleri tasarımı yarışmalarında derece veya mansiyon', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 15],
    '16c' => ['baslik' => 'Proje ve yapım yönetimi, tasarım ya da planlama alanında yazılım üreticisi olmak', 'kategori' => 'patent', 'kaynaklar' => ['Yazılım', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili', 'Ticarileştirme'], 'puan' => 15],
];

// Ek-2: ortak çalışmalarda yazar sayısı × sıra matrisi.
$YAZAR = [
    'haric' => ['atif', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev', 'odul',
        'editorluk', 'toplumsal_katki', 'proje', 'patent', 'sanatsal_etkinlik', 'diger'],
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.00]],
        'ilk' => ['kademeler' => [1 => 1.00, 2 => 1.00, 3 => 0.90, 4 => 0.85, 5 => 0.80, 6 => 0.75, 7 => 0.70, 8 => 0.65, 9 => 0.60], 'sonrasi' => 0.60],
        'baslica' => ['kademeler' => [1 => 1.00, 2 => 1.00, 3 => 0.90, 4 => 0.85, 5 => 0.80, 6 => 0.75, 7 => 0.70, 8 => 0.65, 9 => 0.60], 'sonrasi' => 0.60],
        'yazar_2' => ['kademeler' => [2 => 0.90, 3 => 0.80, 4 => 0.75, 5 => 0.70, 6 => 0.65, 7 => 0.60, 8 => 0.55, 9 => 0.50], 'sonrasi' => 0.50],
        'yazar_3' => ['kademeler' => [3 => 0.70, 4 => 0.65, 5 => 0.60, 6 => 0.55, 7 => 0.50, 8 => 0.45, 9 => 0.40], 'sonrasi' => 0.40],
        'yazar_4' => ['kademeler' => [4 => 0.55, 5 => 0.50, 6 => 0.45, 7 => 0.40, 8 => 0.35, 9 => 0.30], 'sonrasi' => 0.30],
        'yazar_5' => ['kademeler' => [5 => 0.40, 6 => 0.40, 7 => 0.30, 8 => 0.25, 9 => 0.20], 'sonrasi' => 0.20],
        'yazar_6' => ['kademeler' => [6 => 0.30, 7 => 0.20, 8 => 0.20, 9 => 0.20], 'sonrasi' => 0.20],
        'ortak' => ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.70, 4 => 0.55, 5 => 0.40, 6 => 0.30], 'sonrasi' => 0.20],
    ],
];

$KAPSAM = 'Puanlar İzmir Kavram Meslek Yüksekokulu Yükseltme ve Atama Yönergesinin Ek-1 '
    .'puanlama cetvelinden. Yazar çarpanı Ek-2\'nin yazar sayısı × sıra tablosundan geliyor '
    .'(iki yazarlı bir yayında birinci isim tam puan, ikinci isim 0,9; dokuz ve daha fazla '
    .'yazarlıda birinci isim 0,6, beşinci ve sonraki isimler 0,2). Sorumlu yazar birinci isimle '
    .'aynı sayılıyor. Yazar listesini boş bırakırsanız çarpan hiç uygulanmaz ve puanınız '
    .'olduğundan YÜKSEK görünür. '
    .'KAYNAK PDF TARANMIŞ VE OCR\'LANMIŞ; metinde harf kaybı var. Eksik başlıklar sayfa '
    .'görüntüsünden okundu: 2.c-2.d BKCI dışındaki uluslararası kitap (15) ve bölümü (10). '
    .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: 13. madde (bilimsel ve sanatsal etkinlik '
    .'düzenlemelerinde yer almak, 5 ve 3), 17. madde (Yükseköğretim kurumlarında 2 yıl ders '
    .'vermiş olmak, en çok 6), 18. madde (h-indeksi, 5) ve 19. madde (yabancı dil '
    .'sınavından 85 ve üzeri, 5) faaliyet kaydına çevrilemediği için girilmedi. Dergi editörlüğü '
    .'için ayrı satır yok; editörlük kayıtlarınız yayın kurulu üyeliği satırından (uluslararası '
    .'2, ulusal 1) sayılıyor. Lisansüstü tezden üretilmiş yayın, idari görev ve toplumsal katkı '
    .'kalemlerinin cetvelde hiç karşılığı yok. E-SCI makaleleri (20) diğer uluslararası '
    .'indekslerden ayrılamadığı için 15\'ten, uluslararası faydalı model (20) ulusaldan (15) '
    .'ayrılamadığı için 15\'ten, uluslararası hakemlik (3) ve davetli konuşmacılık (10) ulusal '
    .'karşılıklarından (2 ve 6) sayılıyor. Ders notları 3. maddenin "ders notu hariç" kaydı '
    .'gereği kitap satırlarına girmiyor.';

$GRUPLAR_ORTAK = [
    'ATIF' => ['6a', '6b', '6c'],
    'PROJE' => ['5a', '5b', '5c', '5d'],
    'PROJE-YURUTUCU' => ['5a', '5c'],
];

$TAVANLAR = [
    'ATIF' => 20, // 6. madde: en fazla 20 puan alınabilir
];

$gsf = array_merge($genel, $sanat);
$mim = array_merge($genel, $mimarlik);

return [
    'cetveller' => [
        'izmir-kavram-2025' => [
            'kapsam_notu' => $KAPSAM,
            'yazar_katsayisi' => $YAZAR,
            'maddeler' => $genel,
            'gruplar' => array_merge($GRUPLAR_ORTAK, ['TUM' => array_keys($genel)]),
            'grup_tavanlari' => $TAVANLAR,
        ],
        'izmir-kavram-2025-gsf' => [
            'kapsam_notu' => $KAPSAM.' Güzel Sanatlar temel alanında Ek-1\'in 15. maddesindeki '
                .'sanat ve tasarım etkinlikleri de sayılıyor; satırlar kayıttaki sanatsal etkinlik '
                .'etiketlerine yaklaştırılarak eşlendi.',
            'yazar_katsayisi' => $YAZAR,
            'maddeler' => $gsf,
            'gruplar' => array_merge($GRUPLAR_ORTAK, ['TUM' => array_keys($gsf)]),
            'grup_tavanlari' => $TAVANLAR,
        ],
        'izmir-kavram-2025-mim' => [
            'kapsam_notu' => $KAPSAM.' Mimarlık, planlama ve tasarım temel alanında Ek-1\'in 16. '
                .'maddesi de sayılıyor; 16.b (Döner Sermaye ya da üniversiteye bağlı kuruluşlar '
                .'aracılığıyla yapılan uygulama projesini yayımlamış olmak, 15) kayıtta etiketi '
                .'olmadığı için girilmedi.',
            'yazar_katsayisi' => $YAZAR,
            'maddeler' => $mim,
            'gruplar' => array_merge($GRUPLAR_ORTAK, ['TUM' => array_keys($mim)]),
            'grup_tavanlari' => $TAVANLAR,
        ],
    ],
];
