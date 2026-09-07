<?php

/**
 * İSTANBUL TEKNİK ÜNİVERSİTESİ — TABLO 1: Akademik, Kurumsal ve Toplumsal
 * Katkı Faaliyetlerine İlişkin Puanlar
 * Kaynak: pdf/17536997252.istanbulteknikuniverstesi.pdf
 * Senato: 04.11.2022 / 817
 *
 * BEŞ CETVEL BİR DOSYADA. Tablo 1'in puanları birime göre değişiyor: A bölümü
 * üç sütunlu, C ve J bölümleri iki sütunlu, L (müzik-sahne) yalnızca
 * konservatuvarda, M (moda tasarımı) yalnızca Moda Tasarımı anahtar
 * kelimesinde, G.7 ve N (yarışma, tasarım-planlama) yalnızca Mimarlık
 * Fakültesi'nde geçerli. Tek cetvelle okumak yanlış birimin puanını atardı,
 * bu yüzden dosya beş cetveli birden döndürüyor:
 *
 *   itu-2022         Tüm Birimler (H, S, MF, TMDK hariç)
 *   itu-2022-hs      Hukuk Temel Alanı ve Sosyoloji Bölümü
 *   itu-2022-mf      Mimarlık Fakültesi
 *   itu-2022-tmdk    Türk Musikisi Devlet Konservatuvarı
 *   itu-2022-moda    Tekstil Teknolojileri ve Tasarımı Fak. Moda Tasarımı
 *
 * Kısaltmalar belgenin kendi tanımı: H = Hukuk Temel Alanı,
 * S = Sosyoloji Bölümü, MF = Mimarlık Fakültesi,
 * TMDK = Türk Musikisi Devlet Konservatuvarı.
 *
 * ── PUAN ÜRETEN FORMÜLLER GİRİLEMEDİ ──
 * Tablo 1'in üç kalemi sabit puan değil formül veriyor:
 *   D.1  (h-indeksi − sınır değer) × 25
 *   D.2  (FWCI − 1) × yayın sayısı
 *   K.1  son iki yılda verilen ders kredilerinin toplamı
 * Motorun `puan` alanı sabit sayı tutuyor; üçü de girilemedi. Bu yüzden
 * yönergenin TOPLAM PUAN barajı (Dr. 60 · doçent 250 · profesör 500) şart
 * ağacına HİÇ YAZILMADI — bkz. yonerge/itu.php. Eser puanı barajı ise
 * etkilenmiyor: Tablo 3'e göre eser puanı kapsamına yalnızca yayın türleri
 * giriyor, D ve K bölümleri girmiyor.
 *
 * ATIF PUANI YOK: İTÜ atıfı yalnızca h-indeksi üzerinden puanlıyor (D.1),
 * atıf başına puan vermiyor. Atıf kayıtları bu cetvelde 0 puan alır.
 *
 * ── AYNI KAYNAĞA DÜŞEN İKİ SATIRDA DAİMA DÜŞÜĞÜ GİRİLDİ ──
 *   Proje F.1 baş yürütücü (50) / F.2 ortak yürütücü (40) → F.2.
 *   Yarışma ödülü G.7a uluslararası derece (20) / G.7d ulusal derece (10)
 *       → G.7d.
 *   Müzik L.1 uluslararası yapım (25) / L.2 ulusal yapım (15) → L.2;
 *       L.3 (15) / L.4 (8) → L.4.
 *   İdari görev O.2 rektörlük komisyonu (4) / O.3 kurul üyeliği (2) /
 *       O.4 fakülte komisyonu (3) → O.3.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   A.7, A.8, A.10  EBSCO/Proquest/RILM/MLA, ASOS/Sobiad, forum ve kitap
 *       değerlendirmeleri — sözlük bu indeksleri ayırmıyor.
 *   G.4, G.6        TÜBA telif kitap ödülü, en iyi makale/bildiri ödülü.
 *   H.2, H.4        editör yardımcısı, konuk editör.
 *   K.1-K.7         ders kredisi (formül), MOOC geliştirme, yaz okulu
 *       düzenleme, MF'ye özgü eğitim çıktıları.
 *   O.1'in rektörlük satırı yok: İTÜ idari görev listesinde rektör ve rektör
 *       yardımcısı hiç anılmıyor, o kayıtlar 0 puan alır.
 *   P.1-P.4         program koordinatörlüğü, öğrenci takım danışmanlığı,
 *       toplantı düzenleme kurulu üyeliği.
 *   Toplumsal katkı bölümü yok; o kayıtlar 0 puan alır.
 *
 * ── UYGULANAMAYAN SINIRLAR ──
 *   O.1'in tavanı yüzdeye bağlı ("atama için istenilen asgari puanın %10'unu
 *       geçemez"); motor yalnızca sabit tavan tanıyor, uygulanmadı. AMA BU
 *       BARAJI ŞİŞİRMİYOR: İTÜ'nün bütün koşulları ESER-PUANI grubuna bağlı
 *       ve idari görev satırları o grupta değil. Tavansızlık yalnız faaliyet
 *       listesinde görünen puanı etkiliyor, hiçbir eşiğe girmiyor.
 *   Hukuk ve Sosyoloji'de "A1/A2/A3 türü yayınların puanları 2 ile çarpılır"
 *       (Tablo 3) uygulanmadı; çarpan eser puanına özgü ama motor puanı
 *       cetvelden tek türlü okuyor. Eser puanı bu iki birimde olduğundan
 *       DÜŞÜK görünür, yani baraj olduğundan zor.
 *
 * Yönerge: yonerge/itu.php
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 */
$kapsamNotu = function (string $birim, string $ek = ''): string {
    return "Puanlar İTÜ Akademik Yükseltme ve Atama Ölçütleri (2022) Tablo 1'den, {$birim} "
        .'sütunu. Yönergenin toplam puan barajı (Dr. 60, doçent 250, profesör 500) burada '
        .'GÖSTERİLMİYOR: o barajın içine h-indeksi, FWCI ve ders kredisi formülleriyle '
        .'hesaplanan puanlar giriyor, bunlar faaliyet kaydından türetilemiyor. Eser puanı '
        .'barajı etkilenmiyor — yönerge eser puanına yalnızca yayın türlerini katıyor. '
        .'Atıflarınız puan getirmez: İTÜ atıfı yalnızca h-indeksi üzerinden değerlendiriyor. '
        .'Ders verme, program koordinatörlüğü ve toplumsal katkı kalemlerinin de karşılığı '
        .'yok. Editör yardımcılığı ve konuk editörlük kaynakta ayrılamadığı için girilmedi; '
        .'proje yürütücülüğünde baş yürütücü ile ortak yürütücü ayrılamadığı için düşük satır '
        .'alındı. İdari görev bölümünün yüzdeye bağlı tavanı (asgari puanın %10\'u) '
        .'uygulanmıyor; bu yalnız listede görünen puanı etkiliyor, koşulların hiçbiri '
        .'idari görev kalemlerini saymıyor.'.$ek;
};

// ── ORTAK GÖVDE ─────────────────────────────────────────────────────────────
// Değerler "Tüm Birimler" sütunundan; varyantlar yalnızca farkı yazar.
// Puanı 0 olan satırlar yönergede "-" ile gösterilen hücrelerdir: o birimde
// kalem sayılmıyor. Kod yine de duruyor ki koşulların kapsam rozeti neyin
// sayıldığını gösterebilsin.
$maddeler = [
    // ══ A. ARAŞTIRMA MAKALELERİ ══
    // Kısa makale, editöre mektup ve kitap değerlendirmeleri A.10'a girer;
    // o satır kaynakta karşılıksız olduğu için A.1-A.4 özgün makale ve
    // derlemeyle sınırlandı.
    'A.1' => ['baslik' => 'Scopus Q1 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 10],
    'A.2' => ['baslik' => 'Scopus Q2 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 8],
    'A.3' => ['baslik' => 'Scopus Q3 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 4],
    'A.4' => ['baslik' => 'Scopus Q4 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 3],
    'A.5' => ['baslik' => 'AHCI taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 0],
    'A.6' => ['baslik' => 'SSCI, ESCI veya SCI-E taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 0],
    'A.9' => ['baslik' => 'ÜAK alan indeksinde yer alan dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 0],
    'A.11' => ['baslik' => 'TR Dizin taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 3],

    // ══ B. BİLDİRİLER ══
    'B.1' => ['baslik' => 'Uluslararası bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin', 'Uluslararası Özet/Poster', 'Davetli Konuşmacı'], 'puan' => 3],
    'B.2' => ['baslik' => 'Ulusal bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin', 'Ulusal Özet/Poster'], 'puan' => 2],

    // ══ C. KİTAP ══
    'C.1' => ['baslik' => 'Uluslararası kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 40],
    'C.2' => ['baslik' => 'Ulusal kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı'], 'puan' => 30],
    'C.3' => ['baslik' => 'Uluslararası kitap içinde bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 10],
    'C.4' => ['baslik' => 'Ulusal kitap içinde bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 3],
    'C.5' => ['baslik' => 'Uluslararası kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 30],
    'C.6' => ['baslik' => 'Ulusal kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 15],
    'C.7' => ['baslik' => 'Kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap', 'Çeviri Kitap Bölümü'], 'puan' => 10],
    'C.8' => ['baslik' => 'Uluslararası ansiklopedi maddesi', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 0],

    // ══ E. PATENTLER (tescil edilmiş olmalı) ══
    'E.1' => ['baslik' => 'Ticarileştirilmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 40],
    'E.2' => ['baslik' => 'Yurt dışı incelemeli patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 10],
    'E.3' => ['baslik' => 'Yurt içi incelemeli patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 10],

    // ══ F. ARAŞTIRMA PROJELERİ (tamamlanmış olmalı) ══
    'F.2' => ['baslik' => 'Uluslararası projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 40],
    'F.3' => ['baslik' => 'Uluslararası projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 20],
    'F.4' => ['baslik' => 'Uluslararası projede danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['danisman'], 'puan' => 5],
    'F.5' => ['baslik' => 'Ulusal projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK', 'BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 25],
    'F.6' => ['baslik' => 'Ulusal projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK', 'BAP (Üniversite)'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 10],
    'F.7' => ['baslik' => 'Ulusal projede danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK', 'BAP (Üniversite)'], 'roller' => ['danisman'], 'puan' => 3],

    // ══ G. ÖDÜLLER ══
    'G.1' => ['baslik' => 'Sürekli ve periyodik verilen jürili uluslararası bilim veya sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 80],
    'G.2' => ['baslik' => 'TÜBİTAK veya TÜBA bilim ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'YÖK Ödülü'], 'puan' => 80],
    'G.3' => ['baslik' => 'TÜBİTAK veya TÜBA teşvik ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 50],
    'G.5' => ['baslik' => 'Sürekli ve periyodik verilen jürili ulusal bilim veya sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 20],

    // ══ H. DERGİLERDE EDİTÖRLÜK · I. HAKEMLİK ══
    'H.1' => ['baslik' => 'Dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi', 'TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 40],
    'H.3' => ['baslik' => 'Derginin editör listesinde yer almak', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 20],
    'I.1' => ['baslik' => 'Uluslararası dergide hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 2],

    // ══ J. TEZ YÖNETİMİ (tamamlanmış olmalı) ══
    'J.1' => ['baslik' => 'Doktora tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 40],
    'J.2' => ['baslik' => 'Yüksek lisans tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 10],
    'J.3' => ['baslik' => 'Doktora tezi eş danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 20],
    'J.4' => ['baslik' => 'Yüksek lisans tezi eş danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 5],

    // ══ K. ÖĞRETİM ══
    'K.8' => ['baslik' => 'Uluslararası kısa süreli programda verilen ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Değişim Programı Dersi', 'Yabancı Dilde Ders'], 'puan' => 1],

    // ══ O. İDARİ GÖREVLER ══
    'O.1.a' => ['baslik' => 'Dekan, enstitü, yüksekokul veya konservatuvar müdürlüğü (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü'], 'puan' => 10],
    'O.1.b' => ['baslik' => 'Bölüm başkanlığı veya anabilim dalı başkanlığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 8],
    'O.1.c' => ['baslik' => 'Merkez müdürlüğü (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 8],
    'O.1.d' => ['baslik' => 'Dekan, müdür veya bölüm başkanı yardımcılığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkan Yardımcısı'], 'puan' => 5],
    'O.3' => ['baslik' => 'Kurul, komisyon veya ofis üyeliği (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 2],
];

$gruplar = [
    'A1-A2' => ['A.1', 'A.2'],
    'A1-A3' => ['A.1', 'A.2', 'A.3'],
    'A1-A11' => ['A.*'],
    'A-TURU' => ['A.*'],
    'TR-DIZIN' => ['A.11'],
    'B' => ['B.*'],
    'C-TAMAMI' => ['C.*'],
    'C1-C3' => ['C.1', 'C.3'],
    'C1-C3-C5' => ['C.1', 'C.3', 'C.5'],
    'A1-A3-C1-C3' => ['A.1', 'A.2', 'A.3', 'C.1', 'C.3'],
    'SOSYOLOJI-MAKALE' => ['A.1', 'A.2', 'A.3', 'A.5', 'A.6'],
    'PROJE' => ['F.*'],
    // Profesörlük: "yürütücü veya uluslararası projede araştırmacı".
    'PROJE-YURUTUCU-ULUSLARARASI' => ['F.2', 'F.5', 'F.3'],
    'TEZ' => ['J.1', 'J.2'],
    'EGITIM-FAALIYETI' => ['K.8'],
    'HAKEMLIK' => ['I.1'],
    // Tablo 3, "Tüm Birimler": eser puanına yalnızca A1/A2/A3 giriyor.
    'ESER-PUANI' => ['A.1', 'A.2', 'A.3'],
    // Tablo 5, "Tüm Birimler": başlıca eser yalnızca A1/A2.
    'BASLICA-ESER' => ['A.1', 'A.2'],
];

$tavanlar = ['HAKEMLIK' => 20];

/**
 * Bir varyantı ortak gövdeden türetir.
 *
 * @param  array<string, array<string, mixed>>  $maddeFarki
 * @param  array<string, list<string>>  $grupFarki
 * @return array<string, mixed>
 */
$varyant = function (string $notu, array $maddeFarki = [], array $grupFarki = []) use ($maddeler, $gruplar, $tavanlar): array {
    foreach ($maddeFarki as $kod => $degisiklik) {
        $maddeler[$kod] = array_replace($maddeler[$kod] ?? [], $degisiklik);
    }

    return [
        'kapsam_notu' => $notu,
        'maddeler' => $maddeler,
        'gruplar' => array_replace($gruplar, $grupFarki),
        'grup_tavanlari' => $tavanlar,
    ];
};

// ── L. MÜZİK VE SAHNE ÇALIŞMALARI (yalnızca TMDK) ───────────────────────────
$muzik = [
    'L.2' => ['baslik' => 'Resmî yapım şirketi ürünü görsel-işitsel yapımda solo icracı, besteci, şef, koreograf veya sanat yönetmeni olarak yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)'], 'puan' => 15],
    'L.4' => ['baslik' => 'Resmî yapım şirketi ürünü görsel-işitsel yapımda topluluk içinde icracı veya aranjör olarak yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Albüm / CD-DVD Katkısı'], 'puan' => 8],
    'L.5' => ['baslik' => 'Uluslararası etkinlikte solo icracı, besteci, şef, koreograf veya küratör olmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Solistlik (Uluslararası)', 'Resital (Uluslararası)'], 'puan' => 10],
    'L.6' => ['baslik' => 'Ulusal etkinlikte solo icracı, besteci, şef, koreograf veya küratör olmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Solistlik (Ulusal)', 'Resital (Ulusal)', 'Özgün Eser / Beste / Tasarım', 'Koreografi'], 'puan' => 5],
    'L.7' => ['baslik' => 'Uluslararası etkinlikte topluluk içinde icracı veya aranjör olarak yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Oda Müziği Grup Üyeliği (Uluslararası)'], 'puan' => 8],
    'L.8' => ['baslik' => 'Ulusal etkinlikte topluluk içinde icracı veya aranjör olarak yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Oda Müziği Grup Üyeliği (Ulusal)', 'Orkestra / Koro Üyeliği'], 'puan' => 3],
    'L.9' => ['baslik' => 'Uluslararası radyo, televizyon veya sinema yayınında solo icracı, besteci veya şef olmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)'], 'puan' => 10],
    'L.10' => ['baslik' => 'Ulusal radyo, televizyon veya sinema yayınında solo icracı, besteci veya şef olmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'], 'puan' => 5],
];

// ── M. MODA TASARIMI ÇALIŞMALARI (yalnızca Moda Tasarımı) ───────────────────
$moda = [
    'M.1' => ['baslik' => 'Özgün tasarımlarıyla uluslararası kişisel etkinlikte bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)'], 'puan' => 30],
    'M.2' => ['baslik' => 'Özgün tasarımlarıyla ulusal kişisel etkinlikte bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Özgün Eser / Beste / Tasarım'], 'puan' => 10],
    'M.3' => ['baslik' => 'Özgün tasarımlarıyla uluslararası karma etkinliğe katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)'], 'puan' => 20],
    'M.4' => ['baslik' => 'Özgün tasarımlarıyla ulusal karma etkinliğe katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)'], 'puan' => 8],
    'M.5' => ['baslik' => 'Uluslararası sempozyum, festival veya bienale tasarımıyla katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 15],
    'M.6' => ['baslik' => 'Ulusal sempozyum, festival veya bienale tasarımıyla katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 6],

    /*
     * M.5 VE M.6 İKİ KOLLU: "…etkinliklere tasarımlarıyla katılmak VE/VEYA
     * … tasarım yarışmalarında derece/mansiyon almak." Yarışma kolu ilk
     * girişte hiç yazılmamıştı; sorun yalnız puan değil KÜME:
     *
     *   `itu-2022-mf`'in ESER-PUANI kümesi G.7d'yi içeriyor, M'yi içermiyor.
     *   `itu-2022-moda`'nınki ise TERSİ: `M.*` var, G.7d yok.
     *
     * Yani moda adayının tasarım yarışması ödülü toplam puana giriyor ama
     * ESER-PUANI barajına HİÇ girmiyordu — yanlış FAIL yönü. Ayrı bir satır
     * açıldı: M bölümünde durduğu için moda barajına giriyor, puanı G.7d ile
     * AYNI (5) olduğu için hiçbir yerde toplamı değiştirmiyor.
     *
     * Puan neden 6 değil 5: `Yarışma Derecesi / Mansiyon` etiketi G.7'nin
     * dört derece/mansiyon kademesini de taşıyor ve en düşüğü ulusal
     * mansiyon (G.7e, 5). M.6'nın 6'sını yazmak o kademeyi fazla saydırırdı.
     */
    'M.6y' => ['baslik' => 'Ulusal kuruluşlarca düzenlenen tasarım yarışmasında derece veya mansiyon', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 5],
];

// ── G.7 ve N (yalnızca Mimarlık Fakültesi) ──────────────────────────────────
$mimarlik = [
    // G.7 ALTI KADEME SAYIYOR, ETİKET TEK: uluslararası derece 20 · mansiyon
    // 10 · satın alma 5, ulusal derece 10 · mansiyon 5 · satın alma 3.
    // `Yarışma Derecesi / Mansiyon` bunlardan yalnız DERECE ve MANSİYON
    // kademelerini temsil edebiliyor (satın alma ayrı bir sonuç ve sözlükte
    // karşılığı yok, o kayıtlar 0 alır). Dört kademenin en düşüğü ulusal
    // mansiyon: 5. İlk girişte ulusal derecenin 10'u yazılmıştı; mansiyon
    // alan aday kaynağın verdiğinin iki katını alıyordu (§0) ve satır MF
    // varyantının ESER-PUANI kümesinde olduğu için baraja da giriyordu.
    'G.7d' => ['baslik' => 'Planlama, mimarlık, kentsel tasarım veya endüstriyel tasarım yarışmasında derece veya mansiyon', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 5],
    'N.1' => ['baslik' => 'Tasarım, planlama veya mimarlık yarışmasında jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 3],
    'N.3' => ['baslik' => 'Çalışma alanıyla ilgili yazılım üreticisi veya faydalı model sahibi olmak', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Yazılım'], 'puan' => 3],
    'P.4' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (başkanlık çarpanı girilemedi)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)', 'Toplantı Düzenleme Başkanlığı (Ulusal)', 'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 3],
];

return ['cetveller' => [
    // ══════════ Tüm Birimler (H, S, MF, TMDK hariç) ══════════
    'itu-2022' => $varyant($kapsamNotu('Tüm Birimler')),

    // ══════════ Hukuk Temel Alanı ve Sosyoloji Bölümü ══════════
    // A bölümünün ikinci sütunu; C.4 ve C.8 yükseliyor; tez yönetimi ayrı.
    'itu-2022-hs' => $varyant(
        $kapsamNotu('Hukuk ve Sosyoloji', ' Yönergenin "A1/A2/A3 puanları 2 ile çarpılır" '
            .'kuralı uygulanmadı; eser puanınız olduğundan düşük görünür.'),
        [
            'A.5' => ['puan' => 4], 'A.6' => ['puan' => 4], 'A.9' => ['puan' => 4],
            'C.4' => ['puan' => 6], 'C.8' => ['puan' => 6],
            'J.1' => ['puan' => 60], 'J.2' => ['puan' => 15], 'J.3' => ['puan' => 30], 'J.4' => ['puan' => 8],
        ],
        [
            // Tablo 3: Hukuk ve Sosyoloji'de eser puanı A, B ve C bölümlerinin tamamı.
            'ESER-PUANI' => ['A.*', 'B.*', 'C.*'],
            // Tablo 5, Sosyoloji satırı.
            'BASLICA-ESER' => ['A.1', 'A.2', 'A.3', 'A.5', 'A.6', 'C.1', 'C.3', 'C.5'],
        ],
    ),

    // ══════════ Mimarlık Fakültesi ══════════
    // A bölümünün ikinci sütunu, C ve J bölümlerinin birinci sütunu.
    'itu-2022-mf' => $varyant(
        $kapsamNotu('Mimarlık Fakültesi'),
        ['A.5' => ['puan' => 4], 'A.6' => ['puan' => 4], 'A.9' => ['puan' => 4]] + $mimarlik,
        [
            'ESER-PUANI' => ['A.1', 'A.2', 'A.3', 'A.4', 'A.5', 'A.6', 'A.9', 'B.1', 'C.1', 'C.3', 'G.7d'],
            'BASLICA-ESER' => ['A.1', 'A.2', 'A.3', 'C.1', 'C.3', 'G.7d'],
            'YARISMA-ODULU' => ['G.7d'],
            'UYGULAMA' => ['G.7d', 'N.1', 'N.3', 'E.1', 'E.2', 'E.3'],
        ],
    ),

    // ══════════ Türk Musikisi Devlet Konservatuvarı ══════════
    'itu-2022-tmdk' => $varyant(
        $kapsamNotu('Türk Musikisi Devlet Konservatuvarı'),
        [
            'A.5' => ['puan' => 10], 'A.6' => ['puan' => 8], 'A.9' => ['puan' => 4],
            'A.11' => ['puan' => 8], 'C.4' => ['puan' => 6], 'C.8' => ['puan' => 6],
        ] + $muzik,
        [
            'ESER-PUANI' => ['A.*', 'C.1', 'C.2', 'C.3', 'C.4', 'C.5', 'C.6', 'C.7', 'L.*'],
            'BASLICA-ESER' => ['A.*', 'C.1', 'C.2', 'C.3', 'C.4', 'C.6', 'C.7', 'C.8', 'L.*'],
            'MUZIK' => ['L.*'],
        ],
    ),

    // ══════════ Tekstil Teknolojileri ve Tasarımı Fak. — Moda Tasarımı ══════════
    'itu-2022-moda' => $varyant(
        $kapsamNotu('Moda Tasarımı'),
        $moda,
        [
            'ESER-PUANI' => ['A.1', 'A.2', 'A.3', 'B.1', 'C.1', 'C.3', 'C.5', 'M.*'],
            'BASLICA-ESER' => ['A.1', 'A.2', 'A.3', 'C.1', 'C.2', 'C.3', 'C.4', 'M.*'],
            'MODA' => ['M.*'],
        ],
    ),
]];
