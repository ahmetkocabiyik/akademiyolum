<?php

/**
 * ONDOKUZ MAYIS ÜNİVERSİTESİ — Yükseltilme ve Atanmalarda Uygulanacak
 * Puan Cetveli
 * Kaynak: pdf/17634002431.Ondokuz Mayıs Üniversitesi Kriter.pdf (Mayıs 2025)
 *
 * TEK ORTAK CETVEL, ÜÇ TEMEL ALAN GRUBU İÇİN AYRI EŞİK. Koşullar cetvele
 * KATEGORİ ARALIĞIYLA atıf yapıyor ("1-10 kategorilerinden en az 360 puan",
 * "1-14 kategorilerinden en az 750") ve aralığın ÜST SINIRI alan grubuna göre
 * değişiyor: A 1-14, B 1-15, C 1-16. Bu yüzden gruplar üç ayrı aralık olarak
 * tanımlandı.
 *
 * ÇEYREKLİKLER TEK SATIRDA: 1. bölümün satırları puanı "80/70/60/50" biçiminde
 * Q1'den Q4'e veriyor. Kaynak sözlüğü çeyrekliği ayırdığı için satırlar alt
 * maddelere bölündü (1.1-Q1 … 1.1-Q4); kategori aralıkları önek eşleşmesiyle
 * bunları da yakalıyor.
 *
 * ── 1-12. BÖLÜMLER: KAYNAĞIN EKSENİ İLE SÖZLÜĞÜN EKSENİ AYRI ──
 * 02.09.2026'da bütün bölümler kaynakla karşılaştırıldı. Tekrar eden desen
 * şu: kaynak bir kalemi bizim etiketimizin TAŞIMADIĞI bir eksende
 * kademelendiriyor (derginin indeksi, yayınevinin sınıfı, fon kademesi,
 * çeyreklik) ve satır o kademelerin ortasından ya da en üstünden yazılmış.
 * §0 uyarınca her etiket, temsil edebileceği bentlerin EN DÜŞÜĞÜNE alındı.
 *
 * Düzeltilen fazla saymalar:
 *   1.5 hakemlik 15 puandaydı — o sayı "toplamda en fazla 15 hakemlik"
 *       ADET tavanı; satırın değeri 5 ve etiket indeksi taşımadığı için
 *       en düşük bent 2 (4.6). Konvansiyonun "TAVAN DEĞERİ SATIR DEĞERİ
 *       SANILABİLİR" tuzağı.
 *   1.4 yayın kurulu üyeliği 21 → 6 (kaynak 21/13/10/6).
 *   3.1 derlemeyi özgün makaleyle aynı satırda 30 sayıyordu → 20 (3.2).
 *   3.3 vaka takdimi 20 → 10.  4.2 derleme 20 → 10.  4.3 vaka 20 → 8.
 *   5. bölüm baştan yanlış eksendeydi: kaynak bildiriyi YAYIMLANDIĞI YERİN
 *       İNDEKSİNE göre puanlıyor (24/8 · 20/7 · 16/5 · 12/4), cetvel ise
 *       toplantının uluslararası olup olmadığına göre. Özet/poster 20 ve 10
 *       puandaydı, kaynakta 3 ve 2.
 *   6.2 bölüm yazarlığı 50 → 40 (50 kaynağın ÇEVİRMENLİK bendi).
 *   7.2 bölüm yazarlığı 15 → 13 (15 yine çevirmenlik).
 *   8. bölüm fon × rol matrisi kuruldu; uluslararası araştırmacı 50 → 40,
 *       kamu/özel sektör yürütücü 70 → 20 (o etiketler 8.6 yerel bendine de
 *       düşebiliyor).
 *   10.1 ve 10.2 kaynağın İKİ KATIYDI (40/20 · doğrusu 20/10).
 *   11.1 atıf 5 → 4, 'Diğer' ve 'Patent' atfı 2 → 1.
 *   12.1 ders 10 → 1: kaynak puanı DERS BAŞINA değil KREDİ BAŞINA veriyor.
 *
 * Düzeltilen eksik saymalar:
 *   1.3 editörlük tek satırda 40'ta toplanmıştı; kaynak çeyrekliğe göre
 *       70/60/50/40 veriyor ve 'WoS Dergi' etiketleri çeyrekliği taşıyor.
 *   9.1.1 uluslararası patent tescili 100 → 150, 9.2.1 ulusal 60 → 75.
 *   11.2 uluslararası yayınevi kitabındaki atıf 2 → 5.
 *   'Ticarileştirme' etiketinin satırı hiç yoktu → 90 (9.2.1).
 *
 * Kaynağın hiç saymadığı için çıkarılanlar: 'Islahçı Hakkı / Çeşit Tescili'
 * (9. bölüm faydalı model ve TASARIM diyor, çeşit demiyor).
 *
 * ── UYGULANAMAYAN İKİ KURAL ──
 *   10. bölüm "iki danışman olması durumunda birinci danışman %70, ikinci
 *       %50 alır" — kayıt eş danışmanlığı taşımıyor, tam puan sayılıyor
 *       (YÜKSEK sapma, `kapsam_notu`'nda yazılı). Aynı bölümün "1-7
 *       kategorilerinden tezden üretilmiş yayın" şartı da doğrulanamıyor.
 *   Sorumlu yazara %20 ilave puan (ortak çalışma notu) — motorun yazar
 *       çarpanı rolü çarpan olarak alıyor, ilave puan veremiyor.
 *
 * ── 13. ÖDÜLLER VE DİĞER HİZMETLER ──
 * Kaynağın yirmi iki bendi ödülü VERENE (YÖK/TÜBİTAK/TÜBA, uluslararası
 * kuruluş, üniversite) ve yarışmalarda DERECEYE göre ayırıyor; sözlük
 * etiketleri daha kaba. Her etiket temsil edebileceği bentlerin EN
 * DÜŞÜĞÜNE yazıldı (§0).
 *
 * ÖNCEKİ İKİ SATIR HEM EKSİK HEM FAZLA SAYIYORDU:
 *   '13.1' 60 puanla dört etiketi topluyordu. 'Uluslararası Bilim/Sanat
 *       Ödülü' kaynakta 50 (13.7) — ON PUAN FAZLA; 'Ufuk Avrupa / ERC'
 *       en yakın bendi 13.9 uluslararası burs (40) — YİRMİ PUAN FAZLA.
 *   '13.2' 30 puanla 'TÜBİTAK / TÜBA Ödülü' ve 'YÖK Ödülü'nü de taşıyordu;
 *       kaynak bunlara 13.3'te 120, 13.4'te 80 veriyor — ELLİ PUAN EKSİK.
 *       Aynı satırdaki 'Yarışma Derecesi / Mansiyon' ise kaynakta en düşük
 *       15 (13.2 ulusal en iyi bildiri) — ON BEŞ PUAN FAZLA.
 *
 * İKİ ETİKET BAŞKA BÖLÜMLERDEN ALINDI:
 *   'Davetli Konuşmacı' 5.2 bildiri satırında 20 puan alıyordu; kaynağın 5.
 *       bölümünde davetli konuşma bendi YOK, açılış konuşması yalnız
 *       13.16'da ve 10 puan. ON PUAN FAZLA sayıyordu.
 *   'Öğrenci Projesi (2209 vb.)' 8.5 BAP satırında 20 puan alıyordu;
 *       kaynağın 8. bölümü öğrenci projesi saymıyor, 2209 danışmanlığı
 *       yalnız 13.21'de ve 8 puan. ON İKİ PUAN FAZLA sayıyordu.
 *
 * 13. BÖLÜMDEN GİRİLMEYENLER — ETİKETİ ZATEN DAHA DÜŞÜK BİR BENTTE:
 *   13.14-13.15 (TÜBİTAK kurul üyeliği 30, panelistlik 15) ve 13.17-13.19
 *       (kurum yönetim, kurul, komisyon ve jüri üyelikleri 13/11/8) —
 *       hepsinin karşılığı 'Kurul / Komisyon Üyeliği' ve o etiket 14.3'te
 *       zaten 5 puanda, yani §0 minimumunda. Ayrı satır açmak motor en
 *       yükseği seçtiği için fazla saydırırdı.
 *   13.20 (kamu görevlendirmesi 8) — 'Kamu/STK Danışmanlığı' 14.16'da 4
 *       puanda, yine minimumda.
 *   13.12 (uluslararası düzenleme kurulu ÜYELİĞİ 15) — sözlükte
 *       koordinatörlük/başkanlık var, üyelik yok.
 *
 * ── 16. SANATSAL ETKİNLİK: ÜÇ EKSEN, BİREBİR EŞLEME ──
 * Kaynak etkinlikleri YER (yurt dışı / yurt içi), JÜRİ (uluslararası jürili /
 * ulusal jürili / jürisiz) ve KATILIM BİÇİMİ (kişisel / karma-grup)
 * eksenlerinde ayırıyor; sözlüğün sanat etiketleri de aynı üç ekseni
 * taşıdığı için on yedi bendin on dördü birebir eşleşti.
 *
 * ÖNCEKİ ÜÇ SATIR YANLIŞ EŞLENMİŞTİ ve ikisi FAZLA SAYIYORDU:
 *   '16.1' Kişisel Etkinlik (Uluslararası) 60 — değeri doğru ama kaynakta o
 *       bent satın alma/yayında yer alma (80); kişisel etkinlik 16.3.
 *   '16.2' Kişisel Etkinlik (Ulusal) 40 — kaynakta yurt içi ulusal jürili
 *       kişisel etkinlik 16.12 ve 20 puan. YİRMİ PUAN FAZLA sayıyordu.
 *   '16.3' Karma/Jürili (Uluslararası + Ulusal) 20 — kaynakta uluslararası
 *       karma 30 (16.4), yurt içi ulusal karma 5 (16.13). Ulusal karma
 *       etkinlik ON BEŞ PUAN FAZLA, uluslararası olan ise on puan eksik
 *       sayılıyordu.
 *
 * 16. BÖLÜMDEN GİRİLMEYEN ETİKETLER:
 *   'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası/Ulusal)' — 16.1 ve 16.2
 *       "sinema, televizyon, radyo gibi yayın organlarında yer alması"
 *       diyor ama bendin kapısı "proje bedeli ve TELİF HAKKI ÖDENMİŞ veya
 *       yapıtın ALIMI YAPILMIŞ olması"; kayıt bu koşulu taşımıyor ve etiket
 *       ayrıca sahne yapıtlarını da kapsıyor. 80 puanlık bir bende
 *       doğrulanamayan koşulla girmek fazla saymak olurdu.
 *   'Elektronik Kişisel/Karma Sergi' — bölümün madde altı notu sergiyi
 *       "galeri, sanat galerisi, sergi salonu" gibi belgelenebilir FİZİKSEL
 *       mekân şartına bağlıyor.
 *   'Karma Albüm / CD-DVD Katkısı', 'Oda Müziği Grup Üyeliği', 'Grup
 *       Şefliği', 'Festival Koordinatörlüğü' — etiketler etkinliğin yerini,
 *       jürisini ya da katılım biçimini taşımıyor; hangi bende düşecekleri
 *       okunamıyor.
 *
 * YARIŞMA DERECESİ ÇARPANI UYGULANMIYOR: bölümün notu yarışma puanlarını
 * dereceye göre ölçekliyor (birincilik %100, ikincilik %90, üçüncülük %80,
 * mansiyon %70, satın alma %60, katılım %50). Kayıt dereceyi taşımadığı için
 * hepsi TAM puandan sayılıyor; yarışma kaleminiz varsa puanınız olduğundan
 * YÜKSEK görünür.
 *
 * 14. BÖLÜM GÖRSEL ETKİNLİK DEĞİL: başlığı "ONDOKUZ MAYIS ÜNİVERSİTESİNE
 * KATKI" ve içeriği idari görev. Bir tur 15. bölümle birlikte "görsel
 * etkinlikler" diye kaydedilmişti; düzeltildi ve bölüm girildi.
 *
 * ── 14. BÖLÜMÜN PUANI YIL İLE ÇARPILIYOR ──
 * Tablonun * dipnotu: "Puanlar görev alınan yıl ile çarpılarak toplam puana
 * yansıtılır." 14.1-14.6 ve 14.17 bu dipnotu taşıyor. Faaliyet kaydı görev
 * süresini tutmadığı için satırlar TEK YIL değeriyle girildi; üç yıl dekan
 * yardımcılığı yapmış aday 90 yerine 30 görür. Bu bölümün puanı olduğundan
 * DÜŞÜK çıkar.
 *
 * ── 14.2'DE FAKÜLTEYE BAĞLI ÇELİŞKİ ──
 * Kaynak bölüm başkanlığını Tıp, Eczacılık, Diş Hekimliği ve Veteriner
 * DIŞINDAKİ birimlerde sayıyor; o fakültelerde ise bölüm başkanlığını
 * saymayıp anabilim dalı başkanlığını sayıyor. Kayıt fakülteyi taşımıyor ve
 * iki okumadan biri seçilmek zorunda. Çoğunluğu yöneten okuma yazıldı
 * (bölüm başkanlığı 20), anabilim dalı başkanlığı 14.3'ün düşük satırından
 * (5) sayılıyor. Sapma: sağlık alanındaki bir anabilim dalı başkanı 20
 * yerine 5 görür (DÜŞÜK, güvenli yön); sağlık alanındaki bir bölüm başkanı
 * ise kaynağın hiç saymadığı 20 puanı görür (YÜKSEK). İkinci durum
 * `kapsam_notu`'nda adaya söyleniyor.
 *
 * ── 14. BÖLÜMDEN GİRİLMEYENLER ──
 *   14.6 öğrenci topluluğu akademik danışmanlığı (5), 14.8 sürdürülebilirlik
 *       çalışmaları (4) — kaynak sözlüğünde karşılıkları yok.
 *   14.9 yabancı dilde ders verme YETERLİLİĞİ (6) — bir yeterlilik, faaliyet
 *       değil; 'Yabancı Dilde Ders' etiketi ders VERMEYİ anlatıyor ve 12.1'de.
 *   14.10-14.13 (OMÜ dergi/kitap editörlüğü 7, hakemliği 3, OMÜ Yayınevi
 *       kitabı 30, onaylı ders notu 10) — kayıt derginin ya da kitabın OMÜ
 *       yayını olduğunu taşımıyor. Üstelik *** dipnotu bu puanların "ilgili
 *       kategorideki puanlara İLAVE edileceğini" söylüyor; motor bir
 *       faaliyete tek maddenin puanını veriyor, toplama yapmıyor. Satır
 *       açmak ya ölü kalırdı (7 < editörlüğün 15-40'ı) ya da fazla saydırırdı
 *       (30, ulusal yayınevi kitabının 15'inin üstünde).
 *   14.14 ve 14.15 (görünürlüğe ve kurumsal kimliğe katkı, 4'er) — ** dipnotu
 *       ölçütleri Rektörlük Eğitim Komisyonu'na bırakıyor; kapsam belirsiz ve
 *       mevcut sanatsal etkinlik ile bildiri satırlarıyla çakışırdı.
 *   14.17 kalite görevleri (8/6/4/2) — rolleri 14.3 ve 14.4'ün etiketleriyle
 *       aynı kovaya düşüyor; ayrı satır motor en yükseği seçtiği için ya ölü
 *       kalır ya fazla saydırır.
 *   Rektörlük ve rektör yardımcılığı — kaynağın 14. bölümü bu iki görevi hiç
 *       saymıyor, o yüzden satırları da yok.
 *
 * '1-14' ve '1-15' grupları 14. bölüm hiç girilmediği için 13'te bitiyordu
 * ve BİRBİRİNİN AYNISIYDI — konvansiyonun "ardışık aralık gruplarının
 * boyutları kesin artmalı" kontrolünün yakaladığı desen. İkisine de '14.*'
 * eklendi ve 1-10 (38) → 1-14 (50) → 1-16 (53) artışı kuruldu.
 *
 * 15. bölüm de girilince aralıklar kesin artar oldu:
 * 1-10 (38) → 1-14 (50) → 1-15 (54) → 1-16 (57).
 *
 * ── 15. GÖRSEL ETKİNLİKLER: ROL OKUNAMIYOR, DÜŞÜK BENT YAZILDI ──
 * Bölüm bir tur "kaynak sözlüğünde karşılıksız" diye atlanmıştı; Dokuz Eylül
 * için açılan film, TV ve reklam etiketleri çoğunu karşılıyor.
 *
 * Kaynak her mecrada YÖNETMENLİĞİ ile ÖTEKİ GÖREVLERİ ayrı puanlıyor
 * (sinemada 80/36, belgeselde 40/20, TV programında 16/8). Sözlük etiketi ise
 * YAPITIN TÜRÜNÜ ve düzeyini söylüyor, adayın rolünü değil. §0 uyarınca her
 * etiket temsil edebileceği en DÜŞÜK bende yazıldı — "öteki görevler"
 * değerine. Uluslararası bir sinema filmi yönetmeni 80 yerine 20 görür;
 * buna karşılık kurgucu olan aday yönetmen puanı almaz.
 *
 * Dört satır bize ait kodlarla girildi (15.2-15.4 ve 15.7-15.8 birleşimleri).
 *
 * BÖLÜM İLETİŞİM FAKÜLTESİ'NE ÖZGÜ, CETVEL İSE ORTAK. Kaynağın başlığı
 * "(İletişim Fakültesi için geçerlidir)" diyor ama motor tek cetveli
 * paylaştırıyor ve İletişim, B grubunun ('1-15') içinde — grup ayrıca
 * eğitim, filoloji, hukuk, ilahiyat, sosyal ve sporu da taşıyor. Ayrı bir
 * `birim` eşiği açmak çözüm DEĞİL: `bul()` aynı (üniversite, kadro, alan)
 * için iki aday bulunca birim boşsa null döner ve sosyal alanın TAMAMI
 * kapsam dışı kalırdı. Bu yüzden satırlar ortak cetvelde duruyor ve
 * `kapsam_notu` adaya "İletişim Fakültesi dışındaysanız bu kalemleri
 * saymayın" diyor.
 *
 * 15. BÖLÜMDEN GİRİLMEYENLER:
 *   15.5 reklam filmi yönetmenliği (20/10) — kaynak reklam filminde YALNIZ
 *       yönetmenliği puanlıyor, "öteki görevler" bendi yok; etiket rolü
 *       taşımadığı için yönetmen olduğu doğrulanamayan adaya puan vermek
 *       fazla saymak olurdu.
 *   15.6 gazete yayın yönetmenliği, görsel yönetmenlik ve editörlüğü
 *       (16/8/4) ile 15.9 radyo programı/reklamı (6/5/4) — sözlükte
 *       karşılıkları yok.
 *   'Yönetmenlik (Sahne/Ekran)' etiketi hiçbir satıra yazılmadı: mecrayı da
 *       düzeyi de taşımıyor, §0 değeri yerel TV'nin 4'üne inerdi ve etiket
 *       ayrıca sahne yönetmenliğini de kapsıyor — bölümün hiç saymadığı bir
 *       iş. Aynı sebeple 'Animasyon / Canlandırma Yapımı' ile geniş 'Sahne,
 *       TV, Radyo, Sinema Yapıtı' etiketleri de dışarıda kaldı.
 */

/*
 * ── ÜÇ YÜZDE TAVANI: CETVEL (ALAN GRUBU × KADRO) İLE VARYANTLANIYOR ──
 *
 * Kaynak üç bölümün toplamını "asgari puanın (1-10 kategorileri arasında)
 * yüzdesi" ile sınırlıyor:
 *
 *   5. bölüm (bildiri)          A ve B %20 · C %45
 *   7. bölüm (ulusal kitap)     A %20 · B %30 · C %60
 *   12. bölüm (eğitim-öğretim)  hepsinde %20
 *
 * Tabanı olan 1-10 asgari puanı kadro ve alan grubuna göre sabit
 * (Dr A/B 120, C 50; doçent A 360, B 330, C 150; profesör A 720, B 660,
 * C 300), yani yüzde SABİT SAYIYA çevrilebiliyor — KONVANSIYONLAR'ın
 * "Yüzde tavanını ASGARİ PUANDAN SABİTE ÇEVİR" kuralı. Bu yüzden cetvel
 * dokuz varyant döndürüyor ve her eşik kendi varyantına bağlanıyor
 * (Yalova ile Acıbadem'de kullanılan yolun aynısı).
 *
 * Kesirli tavanlar AŞAĞI yuvarlandı (C doçentlikte %45 × 150 = 67,5 → 67):
 * tavanı düşük tutmak eksik saydırır, §0'ın istediği yön.
 */
/*
 * 15. BÖLÜM YALNIZCA İLETİŞİM FAKÜLTESİNE AİT (04.09.2026'da düzeltildi).
 *
 * Kaynağın bölüm başlığı birebir şöyle: "15. GÖRSEL ETKİNLİKLER (İletişim
 * Fakültesi için geçerlidir)". Kısıt faaliyetin bir NİTELİĞİ değil, ADAYIN
 * BİRİMİNİN durumu; hiçbir sözlük etiketi taşıyamıyor. Buna karşılık B
 * grubunun barajı "1-15 kategorilerinden", C grubununki "1-16
 * kategorilerinden" diyor — yani hukuk, ilahiyat, spor ve güzel sanatlar
 * adayları da kaynağın onlara vermediği görsel etkinlik puanını topluyordu
 * (§0). A grubu zaten 1-14'te bittiği için etkilenmiyordu.
 *
 * Motorun ayırabildiği en ince eksen `alan` ve İletişim Fakültesi `sosyal`
 * temel alanına düşüyor. Bölüm bu yüzden yalnız `sosyal` varyantında
 * duruyor, öteki varyantlarda satırları hiç yazılmıyor. Kalan sızıntı
 * `sosyal` alanının kendi genişliği (iktisat, psikoloji de orada) —
 * Akdeniz'in 11. bölümünde kabul edilen ödünün aynısı.
 */
$govde = function (int $bildiri, int $ulusalKitap, int $egitim, bool $gorselEtkinlik): array {
    $cetvel = [
        'kapsam_notu' => 'Puanlar Ondokuz Mayıs Üniversitesi Puan Cetvelinden (Mayıs 2025). '
            .'ÜÇ BÖLÜMÜN TAVANI VAR: bildiri, ulusal yayınevi kitabı ve eğitim-öğretim '
            .'bölümlerinden alınacak toplam puan, kadronuzun 1-10 kategorilerinden istediği asgari '
            .'puanın bir yüzdesini geçemiyor; bu sınırlar uygulanıyor. '
            .'BİLDİRİ PUANINIZ DÜŞÜK GÖRÜNEBİLİR: yönerge bildiriyi yayımlandığı yerin İNDEKSİNE '
            .'göre puanlıyor (WoS özel sayısında tam metin 24, ESCI 20, TR Dizin 16), faaliyet '
            .'kaydınız ise indeksi taşımıyor; hepsi düz uluslararası (10) ya da ulusal (8) '
            .'toplantı değerinden sayılıyor, özet ve poster ise 3 ve 2 puandan. '
            .'DERS PUANI KREDİ BAŞINA: yönerge lisansüstü dersin her kredisine 1, lisans dersinin '
            .'her kredisine 0,5 puan veriyor. Kaydınız dersin kredisini taşımadığı için lisansüstü '
            .'ders tek kredi sayılıyor, lisans dersi ise 0,5 puanla motorun tam sayı puanına '
            .'sığmadığı için hiç sayılmıyor. '
            .'TEZ DANIŞMANLIĞINDA İKİNCİ DANIŞMAN İNDİRİMİ UYGULANMIYOR: yönerge iki danışman '
            .'olması durumunda birinci danışmana puanın %70\'ini, ikinciye %50\'sini veriyor; '
            .'kaydınız bu ayrımı taşımadığı için tam puan sayılıyor ve eş danışmansanız puanınız '
            .'YÜKSEK görünür. Aynı bölümün "tezden üretilmiş yayın" şartı da kayıttan '
            .'doğrulanamıyor. '
            .'ÜNİVERSİTEYE KATKI (14.) BÖLÜMÜNÜN PUANI DÜŞÜK GÖRÜNÜR: kaynak bu bölümün puanlarını '
            .'görev alınan YIL SAYISIYLA çarpıyor, faaliyet kaydınız görev süresini tutmadığı için '
            .'satırlar tek yıl değeriyle sayılıyor — üç yıl dekan yardımcılığı yaptıysanız 90 yerine '
            .'30 puan görürsünüz. Aynı bölümün öğrenci topluluğu danışmanlığı, sürdürülebilirlik '
            .'çalışmaları, kalite görevleri ve OMÜ\'nün kendi yayınlarına özgü kalemleri de '
            .'girilemedi. '
            .'TEK İSTİSNA — TIP, ECZACILIK, DİŞ HEKİMLİĞİ VE VETERİNER FAKÜLTELERİ: kaynak bu '
            .'fakültelerde bölüm başkanlığını saymıyor, anabilim dalı başkanlığını sayıyor. Kaydınız '
            .'fakülteyi taşımadığı için bölüm başkanlığı her fakültede 20 puan sayılıyor; bu '
            .'fakültelerdeyseniz ve bölüm başkanıysanız puanınız 20 puan YÜKSEK görünür. '
            .'GÖRSEL ETKİNLİKLER (15.) BÖLÜMÜ İLETİŞİM FAKÜLTESİ İÇİNDİR: yönerge bu bölümü '
            .'yalnız İletişim Fakültesi\'ne veriyor, ama puan cetveli bütün alanlarca paylaşıldığı '
            .'için satırlar herkese görünüyor. İletişim Fakültesi dışındaysanız film ve televizyon '
            .'kalemlerinizi saymayın, yoksa puanınız olduğundan yüksek görünür. Bu bölümde ayrıca '
            .'yönetmenlik ile yapımcılık, kurgu ve senaryo görevleri kaynakta ayrı puanlanıyor '
            .'(sinemada 80\'e karşı 36); faaliyet kaydınız rolünüzü taşımadığı için hepsi DÜŞÜK '
            .'olan görev puanından sayılıyor — yönetmenseniz puanınız olduğundan düşük görünür. '
            .'Reklam filmi yönetmenliği, gazete editörlüğü ve radyo programı kalemleri girilemedi. '
            .'SANATSAL ETKİNLİKLERDE (16.) YARIŞMA DERECESİ SAYILMIYOR: yönerge yarışma '
            .'puanlarını dereceye göre ölçekliyor (birincilik tam puan, mansiyon %70, katılım %50) '
            .'ama faaliyet kaydınız dereceyi taşımıyor; yarışma kaleminiz varsa puanınız olduğundan '
            .'YÜKSEK görünür. Elektronik sergiler ile albüm, oda müziği ve şeflik kalemleri bu '
            .'bölümde girilemedi. '
            .'Bunun dışında gerçek toplamınız burada görünenden yüksek olabilir, düşük olamaz.',

        'maddeler' => [
            // ── 1. SCI, SCIE, SSCI veya AHCI ──
            '1.1-Q1' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI Q1 dergide özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 80],
            '1.1-Q2' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI Q2 dergide özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 70],
            '1.1-Q3' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI Q3 dergide özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 60],
            '1.1-Q4' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI Q4 dergide özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 50],
            '1.2-Q1' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI Q1 dergide vaka takdimi, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 20],
            '1.2-Q4' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI Q2-Q4 dergide vaka takdimi, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 14],
            // Editörlük de çeyrekliğe göre kademeli (70/60/50/40) ve 'WoS Dergi'
            // etiketleri çeyrekliği taşıyor — tek satırda 40'ta toplanmıştı.
            '1.3-Q1' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI Q1 dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)'], 'puan' => 70],
            '1.3-Q2' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI Q2 dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q2)'], 'puan' => 60],
            '1.3-Q3' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI Q3 dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q3)'], 'puan' => 50],
            '1.3-Q4' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI Q4 dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q4)'], 'puan' => 40],
            // 'Yayın Kurulu Üyeliği' ve 'Hakemlik' derginin indeksini TAŞIMIYOR;
            // kaynak her iki kalemi de dört bölümde ayrı puanlıyor (alan
            // editörlüğü 21/13/10/6, hakemlik 5/4/3/2) — §0 uyarınca en düşüğü.
            '4.5' => ['baslik' => 'Hakemli dergide alan editörlüğü, editör yardımcılığı veya yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 6],
            '4.6' => ['baslik' => 'Hakemli dergide hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 2],

            // ── 2. ESCI, SCOPUS ──
            '2.1' => ['baslik' => 'ESCI veya Scopus dergide özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 40],
            '2.2' => ['baslik' => 'ESCI veya Scopus dergide vaka takdimi, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 10],
            '2.3' => ['baslik' => 'ESCI veya Scopus dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 35],

            // ── 3. TR DİZİN ──
            // Kaynak özgün makale (30) ile derlemeyi (20) AYRI puanlıyor; kayıt
            // türü taşıdığı için ikisi ayrı satır.
            '3.1' => ['baslik' => 'TR Dizin hakemli dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 30],
            '3.2' => ['baslik' => 'TR Dizin hakemli dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['derleme'], 'puan' => 20],
            '3.3' => ['baslik' => 'TR Dizin hakemli dergide vaka takdimi, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 10],
            '3.4' => ['baslik' => 'TR Dizin hakemli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 25],

            // ── 4. DİĞER HAKEMLİ DERGİLER ──
            '4.1' => ['baslik' => 'Diğer ulusal veya uluslararası hakemli dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale'], 'puan' => 20],
            '4.2' => ['baslik' => 'Diğer ulusal veya uluslararası hakemli dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'], 'turler' => ['derleme'], 'puan' => 10],
            '4.3' => ['baslik' => 'Diğer ulusal veya uluslararası hakemli dergide vaka takdimi, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 8],
            '4.4' => ['baslik' => 'Diğer hakemli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 15],

            // ── 5. BİLİMSEL TOPLANTILARDA SUNULAN ──
            // Kaynağın ekseni TOPLANTININ ULUSLARARASILIĞI DEĞİL, bildirinin
            // yayımlandığı yerin İNDEKSİ (5.1-5.4) ve puanı "tam metin/özet"
            // çifti olarak veriyor (24/8, 20/7, 16/5, 12/4). Sözlük etiketi
            // indeksi taşımadığı için her etiket, temsil edebileceği bentlerin
            // en düşüğüne yazıldı: uluslararası toplantı 5.5 (10/3), ulusal
            // toplantı 5.6 (8/2).
            '5.5' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan ve kongre kitabında tam metni yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 10],
            '5.5-ozet' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan ve kongre kitabında özeti yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 3],
            '5.6' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan ve kongre kitabında tam metni yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 8],
            '5.6-ozet' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan ve kongre kitabında özeti yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 2],

            // ── 6. ULUSLARARASI YAYINEVLERİ ──
            // Yalnız BKCI/Scopus sınıflı yayınevleri bu bölümde; sözlükte
            // sınıfı taşıyan tek çift 'BKCI / Scopus Kitap' ve '… Kitap Bölümü'.
            '6.1' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitapta yazarlık', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 120],
            '6.3' => ['baslik' => 'Uluslararası yayınevi kitabında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 60],
            '6.4' => ['baslik' => 'Uluslararası yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 40],

            // ── 7. ULUSAL / DİĞER ULUSLARARASI YAYINEVLERİ ──
            // Çeviri etiketleri yayınevinin sınıfını TAŞIMIYOR (6.2 çevirmenlik
            // 50, 7.2 ise 15) — §0 uyarınca 7. bölümün değerleri.
            '7.1' => ['baslik' => 'Ulusal veya diğer uluslararası yayınevi tarafından yayımlanmış kitapta yazarlık', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı'], 'puan' => 40],
            '7.2' => ['baslik' => 'Kitap çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 15],
            '7.3' => ['baslik' => 'Ulusal veya diğer uluslararası yayınevi kitabında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 20],
            '7.4' => ['baslik' => 'Ulusal veya diğer uluslararası yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 13],
            '7.5' => ['baslik' => 'Kitap bölümü çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 6],

            // ── 8. TAMAMLANMIŞ PROJELER ──
            // Kaynak FON KADEMESİ × ROL matrisi veriyor (8.1-8.6 × yürütücü /
            // araştırmacı / görev almak); etiketler fon kademesini taşıdığı için
            // matris birebir kuruldu. 'Diğer Kamu Kurumu' ile 'Özel Sektör'
            // ulusal (8.5) ya da yerel (8.6) olabilir — §0 uyarınca 8.6.
            '8.1.1' => ['baslik' => 'AB Çerçeve, NIH, NSF veya ERC projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 120],
            '8.1.2' => ['baslik' => 'AB Çerçeve, NIH, NSF veya ERC projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci'], 'puan' => 50],
            '8.1.3' => ['baslik' => 'AB Çerçeve, NIH, NSF veya ERC projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 20],
            '8.2.1' => ['baslik' => 'Diğer uluslararası destekli projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 100],
            '8.2.2' => ['baslik' => 'Diğer uluslararası destekli projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci'], 'puan' => 40],
            '8.2.3' => ['baslik' => 'Diğer uluslararası destekli projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 16],
            '8.3.1' => ['baslik' => 'TÜBİTAK veya TÜSEB Ar-Ge projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 90],
            '8.3.2' => ['baslik' => 'TÜBİTAK veya TÜSEB Ar-Ge projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci'], 'puan' => 35],
            '8.3.3' => ['baslik' => 'TÜBİTAK veya TÜSEB Ar-Ge projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 14],
            '8.5.1' => ['baslik' => 'Üniversite (BAP) projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 40],
            '8.5.2' => ['baslik' => 'Üniversite (BAP) projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['arastirmaci'], 'puan' => 15],
            '8.5.3' => ['baslik' => 'Üniversite (BAP) projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 6],
            '8.6.1' => ['baslik' => 'Kamu kurumu veya özel sektör destekli projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 20],
            '8.6.2' => ['baslik' => 'Kamu kurumu veya özel sektör destekli projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci'], 'puan' => 8],
            '8.6.3' => ['baslik' => 'Kamu kurumu veya özel sektör destekli projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 2],

            // ── 9. PATENT, FAYDALI MODEL, TESCİL ──
            // Kaynak "Ticarileştirilmiş/Tescillenmiş" çiftini tek satırda
            // veriyor (180/150 · 90/75); etiket tescil dediği için TESCİL değeri.
            '9.1.1' => ['baslik' => 'Tescillenmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 150],
            '9.2.1' => ['baslik' => 'Tescillenmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 75],
            // 'Ticarileştirme' düzeyi taşımıyor: uluslararası 180, ulusal 90.
            '9.2.1-tic' => ['baslik' => 'Ticarileştirilmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 90],
            // Faydalı model ve tasarım da düzeysiz: uluslararası 45, ulusal 30.
            '9.2.4' => ['baslik' => 'Faydalı model veya tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım'], 'puan' => 30],

            // ── 10. TAMAMLANMIŞ TEZ DANIŞMANLIĞI ──
            '10.1' => ['baslik' => 'Tamamlanmış doktora, uzmanlık ya da sanatta yeterlik tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 20],
            '10.2' => ['baslik' => 'Tamamlanmış tezli yüksek lisans danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 10],

            // ── 11. ATIFLAR ──
            // 'WoS / Scopus' etiketi ikisini birleştiriyor: WoS atfı 6, Scopus
            // atfı 4 — §0 uyarınca 4.
            '11.3' => ['baslik' => 'SCI, SCIE, SSCI, AHCI, ESCI veya Scopus kapsamındaki dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 4],
            '11.2' => ['baslik' => 'Uluslararası yayınevi kitabında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 5],
            '11.5' => ['baslik' => 'TR Dizin kapsamındaki dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
            '11.6' => ['baslik' => 'Diğer ulusal veya uluslararası dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer'], 'puan' => 1],
            '11.7' => ['baslik' => 'İncelemeli patentte yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Patent'], 'puan' => 1],

            // ── 12. EĞİTİM-ÖĞRETİM ──
            // Puan DERS BAŞINA DEĞİL KREDİ BAŞINA: lisansüstü kredisi 1, ön
            // lisans/lisans kredisi 0,5. Kayıt dersin kredisini taşımıyor;
            // lisansüstü ders bir kredi sayıldı. Lisans dersi 0,5 puanla
            // motorun tam sayı puanına sığmıyor, satırı yok.
            '12.1' => ['baslik' => 'Bir dönem yürütülen lisansüstü dersin her bir ulusal kredisi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 1],

            // ── 13. ÖDÜLLER VE DİĞER HİZMETLER ──
            // Kaynağın yirmi iki bendi ödülü VERENE ve DERECEYE göre ayırıyor;
            // sözlük etiketleri daha kaba. Her etiket, temsil edebileceği
            // bentlerin EN DÜŞÜĞÜNE yazıldı (§0).
            '13.3-13.4' => ['baslik' => 'YÖK, TÜBİTAK ya da TÜBA bilim, teşvik veya akademi ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'YÖK Ödülü'], 'puan' => 80],
            // 'TÜBA GEBİP / TWAS Teşvik Ödülü' birleşik: GEBİP 13.4'e (80) düşer
            // ama TWAS kaynağın hiçbir bendinde adı geçmeyen uluslararası bir
            // ödül, en yakını 13.7 (50) — §0 uyarınca düşüğü.
            '13.7' => ['baslik' => 'Uluslararası bilim, sanat veya tasarım ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 50],
            '13.8' => ['baslik' => 'Üniversite ödülü ya da ulusal bilim veya sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 30],
            // Yarışma dereceleri kaynakta düzeye VE dereceye göre kademeli
            // (uluslararası 60-45, ulusal 40-25, en iyi bildiri 30/15, Türk
            // Patent ve Teknofest 25). Etiket ikisini de taşımıyor → en düşük.
            '13.2-13.5-13.6-13.22' => ['baslik' => 'Bilim, sanat ya da tasarım yarışmasında derece, mansiyon veya en iyi bildiri ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 15],
            '13.9' => ['baslik' => 'En az üç dönem süreli bilimsel araştırma için alınan uluslararası burs', 'kategori' => 'odul', 'kaynaklar' => ['Ufuk Avrupa / ERC Ödülü'], 'puan' => 40],
            '13.10' => ['baslik' => 'En az üç dönem süreli bilimsel araştırma için alınan burs', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 25],
            '13.11' => ['baslik' => 'Uluslararası sanat etkinliği düzenleme kurulu başkanlığı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Festival Koordinatörlüğü (Uluslararası)'], 'puan' => 20],
            '13.13' => ['baslik' => 'Ulusal bilimsel ya da sanatsal toplantı düzenleme kurulu görevi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Festival Koordinatörlüğü (Ulusal)'], 'puan' => 10],
            '13.16' => ['baslik' => 'Bilimsel faaliyette alanıyla ilgili açılış konuşması', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 10],
            '13.21' => ['baslik' => 'TÜBİTAK 2209, 2241, 2242, BAP ya da öğrenci topluluğu projesinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'puan' => 8],

            // ── 14. ONDOKUZ MAYIS ÜNİVERSİTESİNE KATKI ──
            // Bölümün bütün satırlarının puanı GÖREV ALINAN YIL İLE ÇARPILIYOR
            // (tablonun * dipnotu); kayıt görev süresini taşımadığı için hepsi
            // TEK YIL değeriyle girildi. Bu bölümün puanı olduğundan düşük çıkar.
            '14.1' => ['baslik' => 'Senato üyeliği, dekan yardımcılığı, müdürlük ya da müdür yardımcılığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Senato / Üniversite Yönetim Kurulu Üyesi', 'Dekan / Enstitü-YO Müdürü', 'Dekan Yrd. / Müdür Yrd.'], 'puan' => 30],
            // Kaynak bölüm başkanlığını YALNIZCA Tıp/Eczacılık/Diş/Veteriner
            // DIŞINDAKİ birimlerde sayıyor, o fakültelerde ise anabilim dalı
            // başkanlığını. Kayıt fakülteyi taşımıyor; çoğunluğu yöneten okuma
            // (bölüm başkanlığı) yazıldı, anabilim dalı başkanlığı 14.3'ün düşük
            // satırından sayılıyor. Sapma dosya başlığında.
            '14.2' => ['baslik' => 'Bölüm başkanlığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 20],
            // Kaynak 10/5 diyor; hangi kademenin geçerli olduğu kayıttan
            // okunamadığı için §0 uyarınca DÜŞÜK olan.
            '14.3' => ['baslik' => 'Rektörlük, dekanlık ya da müdürlük tarafından oluşturulan kurul, komisyon ve koordinatörlük görevleri (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 5],
            '14.4' => ['baslik' => 'Fakülte, bölüm, program ya da laboratuvar akreditasyon kurulunda görev (yıl başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Akreditasyon Faaliyeti'], 'puan' => 6],
            // 6/3 → §0 düşük. Tez izleme komitesi üyeliği bu bendin örneklerinde
            // ama etiketi 10.2'de 20 puan alıyor, motor yükseği seçiyor.
            '14.5' => ['baslik' => 'Rektörlük, dekanlık ya da müdürlük tarafından kurulmuş bir faaliyet alanındaki görev (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 3],
            // Kaynağın 14.5 bendi örneklerinde "tez izleme komitesi üyeliği"
            // sayılıyor (6/3 → §0 düşük). Etiket bir tur 10.2'de yüksek lisans
            // danışmanlığıyla aynı satırdaydı ve 20 puan alıyordu; kaynağın 10.
            // bölümünde jüri ya da izleme komitesi bendi YOK.
            '14.5-tez' => ['baslik' => 'Tez izleme komitesi ya da tez jürisi üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 3],
            '14.7' => ['baslik' => 'Bir ay ya da daha uzun süreli sosyal sorumluluk projesi görevi', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi'], 'puan' => 6],
            '14.16' => ['baslik' => 'OMÜ adına resmî veya özel kurumlara bilimsel, kültürel ya da sanatsal danışmanlık', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı'], 'puan' => 4],

            // ── 15. GÖRSEL ETKİNLİKLER ──
            // KODLAR BİZE AİT (kaynağın 15.2/15.4 ve 15.7/15.8 bentlerinin
            // birleşimi). Kaynak her mecrada YÖNETMENLİK ile ÖTEKİ GÖREVLERİ
            // ayrı puanlıyor (sinemada 80/36, belgeselde 40/20, TV'de 16/8);
            // sözlük etiketi YAPITIN TÜRÜNÜ söylüyor, adayın rolünü değil.
            // §0 uyarınca her etikete temsil edebileceği en DÜŞÜK bent yazıldı,
            // yani "öteki görevler" değeri: yönetmen olan aday puanını düşük
            // görür, kurgucu olan aday hak etmediği puanı görmez.
            '15.2-15.4' => ['baslik' => 'Uluslararası sinema, belgesel ya da kısa metrajlı kurmaca filmde görev (yönetmenlik, yapımcılık, görsel yönetmenlik, kurgu ya da senaryo yazarlığı)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uzun Metrajlı Film / Belgesel (Uluslararası)', 'Belgesel/Kısa Film (Uluslararası)'], 'puan' => 20],
            '15.2-15.4-ulusal' => ['baslik' => 'Ulusal sinema, belgesel ya da kısa metrajlı kurmaca filmde görev (yönetmenlik, yapımcılık, görsel yönetmenlik, kurgu ya da senaryo yazarlığı)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uzun Metrajlı Film / Belgesel (Ulusal)', 'Belgesel/Kısa Film (Ulusal)'], 'puan' => 10],
            '15.7-15.8' => ['baslik' => 'Uluslararası televizyon programı ya da dizisinde görev (yönetmenlik, yapımcılık, görsel yönetmenlik, kurgu ya da senaryo yazarlığı)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['TV Programı (Uluslararası)', 'TV Filmi / Dizisi (Uluslararası)'], 'puan' => 8],
            '15.7-15.8-ulusal' => ['baslik' => 'Ulusal televizyon programı ya da dizisinde görev (yönetmenlik, yapımcılık, görsel yönetmenlik, kurgu ya da senaryo yazarlığı)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['TV Programı (Ulusal)', 'TV Filmi / Dizisi (Ulusal)'], 'puan' => 6],

            // ── 16. SANATSAL ETKİNLİK ──
            // Kaynak etkinlikleri ÜÇ EKSENDE ayırıyor: yer (yurt dışı / yurt içi),
            // jüri (uluslararası jürili / ulusal jürili / jürisiz) ve katılım
            // biçimi (kişisel / karma-grup). Sözlüğün sanat etiketleri aynı üç
            // ekseni taşıdığı için eşleme birebir kuruldu.
            '16.1' => ['baslik' => 'Özgün yapıt ya da tasarımın yurt dışında satın alınması, yayın organlarında yer alması ya da tasarım projesinin dış ülkede uygulanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kamusal Alanda Uygulanmış Yapıt (Yurt Dışı)'], 'puan' => 80],
            '16.2' => ['baslik' => 'Özgün yapıt ya da tasarımın yurt içinde satın alınması, ulusal yayın organlarında yer alması ya da tasarım projesinin yurt içinde uygulanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Satın Alınması (Yurt İçi)', 'Kamusal Alanda Uygulanmış Yapıt (Yurt İçi)', 'Eserin Yayında Yer Alması / Satın Alınması'], 'puan' => 40],
            '16.3' => ['baslik' => 'Yurt dışında uluslararası jürili kişisel sanat ya da tasarım etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)'], 'puan' => 60],
            '16.4' => ['baslik' => 'Yurt dışında uluslararası jürili karma sanat ya da tasarım etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)'], 'puan' => 30],
            '16.5' => ['baslik' => 'Yurt dışında ulusal jürili kişisel etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)'], 'puan' => 35],
            '16.6' => ['baslik' => 'Yurt dışında ulusal jürili grup ya da karma etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Ulusal Jürili)'], 'puan' => 30],
            '16.7' => ['baslik' => 'Yurt dışında yarışmasız ve jürisiz etkinliğe kişisel davetli olarak katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Yurt Dışı, Jürisiz)'], 'puan' => 20],
            '16.8' => ['baslik' => 'Yurt dışında yarışmasız ve jürisiz etkinliğe karma ya da grup davetli olarak katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Jürisiz)'], 'puan' => 10],
            '16.9' => ['baslik' => 'Uluslararası ölçekte sempozyum, festival, çalıştay, bienal ya da trienal etkinliğine yapıtıyla veya icracı olarak katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 10],
            '16.10' => ['baslik' => 'Yurt içinde uluslararası jürili kişisel sanat ya da tasarım etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)'], 'puan' => 15],
            // 'Grup Etkinliği (Uluslararası)' etiketi yeri ("yurt dışı" mı
            // "uluslararası jürili" mi) ayırmıyor; temsil edebileceği bentler
            // 16.4 (30), 16.6 (30) ve 16.11 (10) — §0 uyarınca en düşüğü.
            '16.11' => ['baslik' => 'Yurt içinde uluslararası jürili karma ya da grup etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Grup Etkinliği (Uluslararası)'], 'puan' => 10],
            '16.12' => ['baslik' => 'Yurt içinde ulusal jürili kişisel etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)'], 'puan' => 20],
            '16.13' => ['baslik' => 'Yurt içinde ulusal jürili karma ya da grup etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Grup Etkinliği (Ulusal)'], 'puan' => 5],
            '16.14' => ['baslik' => 'Yurt içinde yarışmasız ve jürisiz etkinliğe kişisel davetli olarak katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Yurt İçi, Jürisiz)'], 'puan' => 15],
            '16.15' => ['baslik' => 'Yurt içinde yarışmasız ve jürisiz etkinliğe karma ya da grup davetli olarak katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Jürisiz, Ulusal)'], 'puan' => 10],
            '16.16' => ['baslik' => 'Ulusal ölçekte sempozyum, festival, çalıştay, bienal ya da trienal etkinliğine yapıtıyla veya icracı olarak katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 10],
            '16.17' => ['baslik' => 'Eser, tasarım ya da projenin müzeye kabul edilmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt İçi)'], 'puan' => 100],
        ],

        'gruplar' => [
            // Koşulların birebir andığı KATEGORİ ARALIKLARI. Üst sınır alan grubuna
            // göre değişiyor: A 1-14, B 1-15, C 1-16.
            '1-10' => ['1.*', '2.*', '3.*', '4.*', '5.*', '6.*', '7.*', '8.*', '9.*', '10.*'],
            '1-14' => ['1.*', '2.*', '3.*', '4.*', '5.*', '6.*', '7.*', '8.*', '9.*', '10.*', '11.*', '12.*', '13.*', '14.*'],
            '1-15' => ['1.*', '2.*', '3.*', '4.*', '5.*', '6.*', '7.*', '8.*', '9.*', '10.*', '11.*', '12.*', '13.*', '14.*', '15.*'],
            '1-16' => ['*'],
            '16' => ['16.*'],
            // Yüzde tavanı taşıyan üç bölüm.
            '5' => ['5.*'],
            '7' => ['7.*'],
            '12' => ['12.*'],
            // Makale adet koşullarının andığı kategoriler.
            '1.1' => ['1.1-*'],
            '1.1-2.1-3.1' => ['1.1-*', '2.1', '3.1'],
            'MAKALE' => ['1.1-*', '2.1', '3.1', '4.1'],
        ],

        'grup_tavanlari' => [
            '5' => $bildiri,
            '7' => $ulusalKitap,
            '12' => $egitim,
        ],
    ];

    if (! $gorselEtkinlik) {
        $cetvel['maddeler'] = array_filter(
            $cetvel['maddeler'],
            fn (string $kod): bool => ! str_starts_with($kod, '15.'),
            ARRAY_FILTER_USE_KEY,
        );

        // Desen de düşmeli: satırı olmayan `15.*` ölü desen olurdu ve
        // `CetvelKaynakTest` onu yakalıyor. `1-15` adı yönergedeki koşulda
        // geçtiği için grubun ADI korunuyor, yalnız içeriği daralıyor.
        $cetvel['gruplar']['1-15'] = array_diff($cetvel['gruplar']['1-15'], ['15.*']);
    }

    return $cetvel;
};

/*
 * (alan grubu, kadro) → [5. bölüm, 7. bölüm, 12. bölüm] tavanları.
 * Üçü de 1-10 asgari puanının yüzdesi; tablo tek yerde tutuluyor ki
 * kadro atlanmasın (MEF'teki fakülte × kadro matrisinin aynısı).
 */
$TAVAN = [
    'a-dr' => [24, 24, 24],      // asgari 120 · %20 · %20 · %20
    'a-doc' => [72, 72, 72],     // asgari 360
    'a-prof' => [144, 144, 144], // asgari 720
    // B temel alanları iki varyant: `b` yalnız `sosyal` (İletişim Fakültesi
    // orada) ve 15. bölümü taşıyor, `bx` öteki beş alan ve taşımıyor.
    'b-dr' => [24, 36, 24],      // asgari 120 · %20 · %30 · %20
    'b-doc' => [66, 99, 66],     // asgari 330
    'b-prof' => [132, 198, 132], // asgari 660
    'bx-dr' => [24, 36, 24],
    'bx-doc' => [66, 99, 66],
    'bx-prof' => [132, 198, 132],
    'c-dr' => [22, 30, 10],      // asgari  50 · %45 · %60 · %20 (22,5 → 22)
    'c-doc' => [67, 90, 30],     // asgari 150 (67,5 → 67)
    'c-prof' => [135, 180, 60],  // asgari 300
];

$cetveller = [];

foreach ($TAVAN as $anahtar => [$bildiri, $ulusalKitap, $egitim]) {
    // 15. bölüm yalnız `b` (sosyal) varyantlarında.
    $cetveller["omu-2025-{$anahtar}"] = $govde($bildiri, $ulusalKitap, $egitim, str_starts_with($anahtar, 'b-'));
}

// Tavansız gövde: hiçbir eşik buna bağlı değil ama cetvel anahtarı
// korpusta başka yerlerden anılabiliyor.
$cetveller['omu-2025'] = $govde(24, 24, 24, true);

return ['cetveller' => $cetveller];
