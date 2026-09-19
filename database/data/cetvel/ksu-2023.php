<?php

use App\Enums\Kategori;

/**
 * KAHRAMANMARAŞ SÜTÇÜ İMAM ÜNİVERSİTESİ — Tablo 1, 2 ve 3
 * Kaynak: pdf/17536998942.kahramanmarassutcuimamuniverstesi.pdf (10 sayfa;
 * Senato 25.01.2023-2023/02-19, YÖK onayı 19.04.2023)
 *
 * MADDE KODLARI YÖNERGENİN KENDİSİ: tablo numarası + bölüm numarası + harf
 * (`T1-2a`, `T2-5a`, `T3-8c`). Koşullar bu kodlarla atıf yapıyor ("Tablo
 * 1'de yer alan 1/a, b, 2/a, b, c, d ve 4/e, f, g, h maddelerinde
 * belirtilen yayın türlerinde"), bu yüzden kodlar birebir korundu. Bize ait
 * olan tek şey tek kayda düşen satırların tire ile yazılmış çift kodları
 * (`T1-3ef`, `T1-6ab`) ve editörlük dalı için açılan `-ed` ekleri.
 *
 * ── HANGİ TABLO KİMİN İÇİN ──
 * Madde 4-5 fen, sağlık ve sosyal alanların barajını Tablo 1 + Tablo 3
 * kümesine, Güzel Sanatlar ve Mimarlık alanlarının barajını Tablo 1 +
 * Tablo 2 + Tablo 3 kümesine bağlıyor. Bu yüzden bütün `Kalip::toplam`
 * çağrıları `maddeler` grubu ve düz Türkçe `liste` adı taşıyor.
 *
 * ── AYNI KAYNAĞA DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   Tablo 1/3-e (uluslararası ders kitabı 30) ile 3-f (ulusal 20): tek
 *       'Ders / Metot Kitabı' etiketi → 20.
 *   Tablo 1/3-g (uluslararası ansiklopedi maddesi 8) ile 3-h (ulusal 3) →
 *       3.
 *   Tablo 1/4-ı (uluslararası tez bildirisi 5) ile 4-j (ulusal 3): tek
 *       'CPCI Bildiri' etiketi → 3.
 *   Tablo 1/5-e (üniversite destekli proje 6) ile 5-f (altyapı projesi 4):
 *       tek 'BAP (Üniversite)' etiketi → 4.
 *   Tablo 1/6 patent satırlarında onay belgeli (100/50) ile araştırma
 *       raporu düzenlenmiş (25/12) ayrımı kayıtta yok → 25 ve 12.
 *   Tablo 2/5 (jürili yarışmada ödül 15/10) ile 2/7 (mimarlık yarışmasında
 *       derece 20/15): tek 'Yarışma Derecesi / Mansiyon' etiketi → 10.
 *   Tablo 3/1 davetli konuşmacılık (8/3/2) → 2; Tablo 3/6 dergi görevleri
 *       editör, yardımcı editör ve kurul üyeliği ayrımı kayıtta olmadığı
 *       için uluslararası 8, ulusal 4, kurul üyeliği 3, hakemlik 2.
 *   Tablo 3/8-a'nın dekanlığı (8) ile 8-b'nin enstitü/yüksekokul müdürlüğü
 *       (6) tek 'Dekan / Enstitü-YO Müdürü' etiketine düşüyor → 6.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   Patent BAŞVURU satırları (Tablo 1/6-c ve 6-f) — tescilliden ayrılamıyor.
 *   Tablo 1/3-k (makale çevirisi 2), 1/8 (yurt dışı çalışma 10),
 *       Tablo 3/5 (h-indeksi), 3/9 (soruşturma), 3/11 (spor branşlarında
 *       görev), 3/12 (öğrenci danışmanlığı) — sözlükte karşılık yok.
 *   Tablo 1/7-d (ulusal poster bildiri 0,5) — aşağı yuvarlandığında
 *       sıfırlandığı için yazılmadı.
 *   'Yazılım', 'Islahçı Hakkı' ve 'Ticarileştirme' — patent bölümünde
 *       karşılık gelen satır yok.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   Madde 7(2)(ç) "her bir yayına yalnız bir puan türü uygulanır" — motor
 *       zaten kayıt başına EN İYİ kodu seçiyor, bu kural karşılanıyor.
 *   İdari görevler "her bir yıl için", dergi görevleri ve öğrenci
 *       danışmanlıkları "her bir yıl için" veriliyor; yıl biriktirmesi yok,
 *       görev başına tek yıl sayılıyor ve puan DÜŞÜK görünür.
 *   "En çok 2 adet/yıl" sınırları (tez jüri üyeliği, bilirkişilik).
 *   Tablo 1/6 dipnotu "patentlerde puan kişi sayısına bölünür" derken
 *       Tablo 4'ün katkı oranları SIRAYA bağlı; cetvel başına tek matris
 *       tanımlanabildiği için sıraya bağlı olan yazıldı. ÇOK BULUŞÇULU
 *       PATENTİN PUANI OLDUĞUNDAN YÜKSEK görünür (en çok 25 puanlık
 *       sapma); `kapsam_notu` uyarıyor.
 *
 * Yönerge: yonerge/ksu.php
 *
 * KODLAR BİZE AİT — KAYNAKTA SATIR KODU YOK. Cetvel kodlarının SAYISAL
 * ÇEKİRDEĞİ kaynağın madde/bölüm numarasıdır; baştaki harf tabloyu ya da
 * eki, sondaki harf şıkkı gösterir ve ikisi de bizim eklediğimiz parçadır.
 * Koşullar bu kodlara atıf yaptığı için değiştirilmemeli; kaynakla
 * karşılaştırırken kodun sayısal çekirdeğine bakılmalı.
 *
 * KİTAPTA YAYINEVİ KAPSAMI (19.09.2026): 3. bölüm kitabı (35 ↔ 30), kitap
 * editörlüğünü (15 ↔ 10), bölüm yazarlığını (15 ↔ 10) ve DERS KİTABINI
 * (30 ↔ 20) uluslararası/ulusal yayınevine göre ayırıyor; indeks aranmıyor.
 * Üst satırlar yalnız BKCI/Scopus etiketiyle yazıldığı için indekssiz
 * uluslararası kitap 35 yerine 30, bölümü 15 yerine 10, editörlüğü 15 yerine
 * 10 puandaydı. Ders kitabının iki kademesi tek satırda (T1-3ef, 20)
 * toplanmıştı; T1-3e (30) ve T1-3f (20) olarak ayrıldı.
 */
$SCI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];
$OZGUN = ['ozgun_makale'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];

// Tablo 2'nin sanat etiketleri; listede olmayan her sanat etiketi en düşük
// satıra (çalıştay katılımcılığı, 2 puan) düşer.
$t2Uygulama = ['Uygulama Projesi — Müellif'];
$t2UygulamaEkip = ['Uygulama Projesi — Ekip'];
$t2UygulamaYrd = ['Uygulama Projesi — Ekip Yardımcısı'];
$t2UygulamaDan = ['Uygulama Projesi — Danışman', 'Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)'];
$t2KisiselU = ['Kişisel Etkinlik (Uluslararası)', 'Elektronik Kişisel Sergi (Uluslararası)',
    'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)',
    'Resital (Uluslararası)', 'Solistlik (Uluslararası)', 'Şan Resitali (Uluslararası)'];
$t2KisiselN = ['Kişisel Etkinlik (Ulusal)', 'Elektronik Kişisel Sergi (Ulusal)',
    'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)',
    'Resital (Ulusal)', 'Solistlik (Ulusal)', 'Şan Resitali (Ulusal)'];
$t2KarmaU = ['Karma/Jürili Etkinlik (Uluslararası)', 'Elektronik Karma Sergi (Uluslararası)',
    'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)',
    'Oda Müziği Grup Üyeliği (Uluslararası)'];
$t2KarmaN = ['Karma/Jürili Etkinlik (Ulusal)', 'Elektronik Karma Sergi (Ulusal)',
    'Karma Etkinlik (Jürisiz, Ulusal)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)',
    'Oda Müziği Grup Üyeliği (Ulusal)', 'Orkestra / Koro Üyeliği'];
$t2FilmU = ['Belgesel/Kısa Film (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)'];
$t2FilmN = ['Belgesel/Kısa Film (Ulusal)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'];
$t2SatinU = ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Müzeye Kabulü (Yurt Dışı)'];
$t2SatinN = ['Eserin Satın Alınması (Yurt İçi)', 'Eserin Müzeye Kabulü (Yurt İçi)'];
$t2HaberU = ['Eserin Haber Olması (Uluslararası)'];
$t2HaberN = ['Eserin Haber Olması (Ulusal)'];
$t2JuriU = ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'];
$t2JuriN = ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'];
$t2CalistayU = ['Masterclass (Uluslararası)', 'Eğitici Konser Programı (Uluslararası)'];
$t2CalistayN = ['Masterclass (Ulusal)', 'Eğitici Konser Programı (Ulusal)', 'Müzikoloji Atölyesi',
    'Eğitim Amaçlı Sanat Etkinliği'];
$t2KatilimU = ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)'];

$t2Kullanilan = array_merge($t2Uygulama, $t2UygulamaEkip, $t2UygulamaYrd, $t2UygulamaDan,
    $t2KisiselU, $t2KisiselN, $t2KarmaU, $t2KarmaN, $t2FilmU, $t2FilmN, $t2SatinU, $t2SatinN,
    $t2HaberU, $t2HaberN, $t2JuriU, $t2JuriN, $t2CalistayU, $t2CalistayN, $t2KatilimU);
$t2Kalan = array_values(array_diff(Kategori::SanatselEtkinlik->kaynaklar(), $t2Kullanilan));

$maddeler = [
    // ══════════ TABLO 1 — BİLİMSEL YAYINLAR / FAALİYETLER ══════════
    'T1-1a' => ['baslik' => 'SSCI, SCI, SCI-Expanded veya AHCI kapsamındaki dergide yayımlanmış derleme', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => ['derleme'], 'puan' => 15],
    'T1-1b' => ['baslik' => 'Diğer dergilerde yayımlanmış derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks', 'TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => ['derleme'], 'puan' => 7],

    'T1-2a' => ['baslik' => 'SSCI, SCI, SCI-Expanded veya AHCI kapsamındaki dergide yayımlanmış araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => $OZGUN, 'puan' => 20],
    'T1-2b' => ['baslik' => 'Uluslararası alan endekslerinde taranan dergide yayımlanmış araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $OZGUN, 'puan' => 10],
    'T1-2c' => ['baslik' => 'ULAKBİM tarafından taranan ulusal hakemli dergide yayımlanmış araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $OZGUN, 'puan' => 10],
    'T1-2d' => ['baslik' => 'ULAKBİM tarafından taranmayan ulusal hakemli dergide yayımlanmış araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $OZGUN, 'puan' => 7],
    'T1-2e' => ['baslik' => 'SSCI, SCI, SCI-Expanded veya AHCI kapsamındaki dergide editöre mektup, teknik not, vaka takdimi ya da tartışma', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => $KISA, 'puan' => 5],
    'T1-2f' => ['baslik' => 'Ulusal hakemli dergide editöre mektup, teknik not, vaka takdimi ya da tartışma', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks', 'TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 3],

    'T1-3a' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası Kitap'], 'puan' => 35],
    'T1-3e' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası Ders / Metot Kitabı'], 'puan' => 30],
    'T1-3c' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap'], 'puan' => 30],
    'T1-3b' => ['baslik' => 'Uluslararası yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Uluslararası Kitap Bölümü'], 'puan' => 15],
    'T1-3b-ed' => ['baslik' => 'Uluslararası yayınevi kitabının editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Uluslararası Kitap Editörlüğü'], 'puan' => 15],
    'T1-3d' => ['baslik' => 'Ulusal yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap Bölümü'], 'puan' => 10],
    'T1-3d-ed' => ['baslik' => 'Ulusal yayınevi kitabının editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Ulusal Kitap Editörlüğü', 'Kitap Editörlüğü'], 'puan' => 10],
    'T1-3f' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Ders / Metot Kitabı'], 'puan' => 20],
    'T1-3gh' => ['baslik' => 'Ansiklopedide konu ya da madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 3],
    'T1-3i' => ['baslik' => 'Yabancı dilde basılmış bilimsel ya da edebi eserin Türkçeye tam kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 8],
    'T1-3j' => ['baslik' => 'Yabancı dilde basılmış bilimsel ya da edebi eserin Türkçeye bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 4],
    'T1-3l' => ['baslik' => 'Arap harfleriyle yazılmış tarihî ve yazma eserin latin harfleriyle günümüz Türkçesine çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Tahkik (Tenkitli Metin)'], 'puan' => 10],

    'T1-4a' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 10],
    'T1-4b' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, uluslararası yayınevi kitabında bölüm', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 8],
    'T1-4c' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 5],
    'T1-4d' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, ulusal yayınevi kitabında bölüm', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 4],
    'T1-4e' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, SSCI, SCI, SCI-Expanded veya AHCI kapsamındaki dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 10],
    'T1-4f' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, uluslararası alan endeksli dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 7],
    'T1-4g' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, ULAKBİM tarafından taranan dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['TR Dizin'], 'puan' => 5],
    'T1-4h' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, ULAKBİM tarafından taranmayan ulusal dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Diğer'], 'puan' => 4],
    'T1-4ij' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, sempozyum ya da kongrede sunulmuş ve tam metni basılmış sözlü bildiri', 'kategori' => 'tez_yayini', 'kaynaklar' => ['CPCI Bildiri'], 'puan' => 3],

    'T1-5a' => ['baslik' => 'AB Çerçeve Programı bilimsel araştırma projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 50],
    'T1-5b' => ['baslik' => 'AB Çerçeve Programı bilimsel araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 30],
    'T1-5c' => ['baslik' => 'Diğer uluslararası destekli bilimsel araştırma projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'puan' => 12],
    'T1-5d' => ['baslik' => 'Üniversiteler dışındaki kamu kurumlarıyla yapılan bilimsel araştırma projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'puan' => 8],
    'T1-5ef' => ['baslik' => 'Üniversite destekli proje ya da altyapı projesi', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'puan' => 4],

    'T1-6ab' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 25],
    'T1-6de' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 12],
    'T1-6g' => ['baslik' => 'Faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 20],
    'T1-6h' => ['baslik' => 'Endüstriyel tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım'], 'puan' => 15],

    'T1-7a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulmuş ve tam metni yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 5],
    'T1-7b' => ['baslik' => 'Ulusal bilimsel toplantıda sunulmuş ve tam metni yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 3],
    'T1-7c' => ['baslik' => 'Uluslararası bilimsel toplantıda poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 1],

    'T1-9a' => ['baslik' => 'Tamamlanmış doktora ya da tıpta uzmanlık tezinde danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 4],
    'T1-9b' => ['baslik' => 'Tamamlanmış yüksek lisans tezinde danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 2],
    'T1-9c' => ['baslik' => 'Tamamlanmış doktora ya da tıpta uzmanlık tezinde eş veya ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 2],
    'T1-9d' => ['baslik' => 'Tamamlanmış yüksek lisans tezinde eş veya ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 1],

    'T1-10a' => ['baslik' => 'SCI, SCI-Expanded, SSCI ve AHCI dergilerinde ya da uluslararası yayınevi kitaplarında eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 3],
    'T1-10b' => ['baslik' => 'Diğer endeksli dergilerde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer'], 'puan' => 2],
    'T1-10c' => ['baslik' => 'Ulusal hakemli dergilerde ya da ulusal yayınevi kitaplarında eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Patent'], 'puan' => 1],

    // ══════════ TABLO 2 — MİMARİ VE SANATSAL ETKİNLİKLER ══════════
    'T2-1a' => ['baslik' => 'Mimari, kentsel tasarım ya da planlama projesinde müellif', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $t2Uygulama, 'puan' => 20],
    'T2-1b' => ['baslik' => 'Mimari, kentsel tasarım ya da planlama projesinde proje ekibi üyesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $t2UygulamaEkip, 'puan' => 10],
    'T2-1c' => ['baslik' => 'Mimari, kentsel tasarım ya da planlama projesinde proje ekibi yardımcısı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $t2UygulamaYrd, 'puan' => 5],
    'T2-1d' => ['baslik' => 'Mimari, kentsel tasarım ya da planlama projesinde danışman', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $t2UygulamaDan, 'puan' => 7],
    'T2-2a' => ['baslik' => 'Müellifi olduğunuz özgün eserle uluslararası kişisel etkinlik (sergi, defile, dinleti, resital, konser)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $t2KisiselU, 'puan' => 20],
    'T2-2b' => ['baslik' => 'Müellifi olduğunuz özgün eserle ulusal kişisel etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $t2KisiselN, 'puan' => 15],
    'T2-3a' => ['baslik' => 'Uluslararası karma sanat etkinliğine bireysel ya da ekip hâlinde katılma', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $t2KarmaU, 'puan' => 8],
    'T2-3b' => ['baslik' => 'Ulusal karma sanat etkinliğine bireysel ya da ekip hâlinde katılma', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $t2KarmaN, 'puan' => 4],
    'T2-57' => ['baslik' => 'Jürili sanat, tasarım, proje ya da mimarlık yarışmasında derece veya mansiyon almak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 10],
    'T2-6a' => ['baslik' => 'Jürili uluslararası belgesel, kısa film, film ya da festivale eserinizle katılma', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $t2FilmU, 'puan' => 15],
    'T2-6b' => ['baslik' => 'Jürili ulusal belgesel, kısa film, film ya da festivale eserinizle katılma', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $t2FilmN, 'puan' => 10],
    'T2-8a' => ['baslik' => 'Yapıtlarınızın uluslararası resmî ya da özel kurumlarca yayımlanması veya satın alınması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $t2SatinU, 'puan' => 15],
    'T2-8b' => ['baslik' => 'Yapıtlarınızın ulusal resmî ya da özel kurumlarca yayımlanması veya satın alınması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $t2SatinN, 'puan' => 10],
    'T2-9a' => ['baslik' => 'Yapıtlarınızın uluslararası yayınlarda yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $t2HaberU, 'puan' => 8],
    'T2-9b' => ['baslik' => 'Yapıtlarınızın ulusal yayınlarda yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $t2HaberN, 'puan' => 4],
    'T2-10a' => ['baslik' => 'Uluslararası sanat, proje ya da tasarım yarışması jürisinde görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $t2JuriU, 'puan' => 5],
    'T2-10b' => ['baslik' => 'Ulusal sanat, proje ya da tasarım yarışması jürisinde görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $t2JuriN, 'puan' => 2],
    'T2-11a' => ['baslik' => 'Uluslararası çalıştay yürütücülüğü ya da moderatörlüğü', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $t2CalistayU, 'puan' => 5],
    'T2-11b' => ['baslik' => 'Ulusal çalıştay yürütücülüğü ya da moderatörlüğü', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $t2CalistayN, 'puan' => 2],
    'T2-12a' => ['baslik' => 'Uluslararası çalıştayda katılımcı olmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $t2KatilimU, 'puan' => 4],
    'T2-12b' => ['baslik' => 'Ulusal çalıştayda katılımcı olmak ve diğer sanatsal etkinlikler', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $t2Kalan, 'puan' => 2],

    // ══════════ TABLO 3 — EĞİTİM-ÖĞRETİM, İDARİ VE DİĞER ══════════
    'T3-1' => ['baslik' => 'Kongre, konferans, sempozyum, çalıştay ya da mesleki kursta davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 2],
    'T3-2a' => ['baslik' => 'Uluslararası bilim ve araştırma ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 15],
    'T3-2b' => ['baslik' => 'Ulusal bilim ve araştırma ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'YÖK Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 8],
    'T3-4' => ['baslik' => 'Bilim ve araştırma bursu almak', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 2],
    'T3-6a' => ['baslik' => 'Uluslararası hakemli dergide editörlük, yardımcı editörlük ya da kurul üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 8],
    'T3-6e' => ['baslik' => 'Ulusal hakemli dergide editörlük ya da yardımcı editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 4],
    'T3-6c' => ['baslik' => 'Hakemli dergide yayın, bilim kurulu ya da komisyon üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 3],
    'T3-6d' => ['baslik' => 'Hakemli dergide hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 2],
    'T3-7' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu, bilim kurulu ya da sekretarya görevi', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 1],
    // Kaynağın 7. maddesi dört rungu ayrı yazıyor: a) uluslararası düzenleme
    // kurulu başkanlığı 12 · e) ULUSAL 3 · b/c uluslararası düzenleme-bilim
    // kurulu üyeliği 6/3 → 3 · f/g ULUSAL 1/1 → 1. Dördü de tek satırda
    // (T3-7, 1 puan) duruyordu.
    'T3-7a' => ['baslik' => 'Uluslararası bilimsel toplantı düzenleme kurulu başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 12],
    'T3-7e' => ['baslik' => 'Ulusal bilimsel toplantı düzenleme kurulu başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Ulusal)'], 'puan' => 3],
    'T3-7c' => ['baslik' => 'Uluslararası bilimsel toplantı düzenleme ya da bilim/sanat danışma kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 3],
    'T3-7f' => ['baslik' => 'Ulusal bilimsel toplantı düzenleme ya da bilim/sanat kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 1],
    'T3-8a' => ['baslik' => 'Rektör ya da rektör yardımcısı olarak görev yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı'], 'puan' => 8],
    'T3-8b' => ['baslik' => 'Dekan, yüksekokul, meslek yüksekokulu, enstitü ya da merkez müdürü, başhekim olarak görev yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 6],
    'T3-8c' => ['baslik' => 'Dekan yardımcısı, müdür yardımcısı ya da bölüm başkanı olarak görev yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkanı'], 'puan' => 4],
    'T3-8d' => ['baslik' => 'Bölüm başkan yardımcısı, anabilim dalı başkanı, koordinatör ya da komisyon üyesi olarak görev yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük', 'Kurul / Komisyon Üyeliği'], 'puan' => 3],
    'T3-10a' => ['baslik' => 'Lisansüstü tez jüri üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 2],
    'T3-10b' => ['baslik' => 'Bir dönem lisansüstü ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
    'T3-10c' => ['baslik' => 'Bir dönem ön lisans ya da lisans dersi vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 2],
    'T3-10g' => ['baslik' => 'Kamu ya da özel sektörde danışman olarak resmî görev; üniversite-sanayi iş birliği görevlendirmesi', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı'], 'puan' => 2],
    'T3-10e' => ['baslik' => 'İdari ve sosyal aktiviteler için resmî görevlendirme; bilirkişilik ve eğiticilik', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 1],
];

$t1 = array_values(array_filter(array_keys($maddeler), fn (string $k) => str_starts_with($k, 'T1-')));
$t2 = array_values(array_filter(array_keys($maddeler), fn (string $k) => str_starts_with($k, 'T2-')));
$t3 = array_values(array_filter(array_keys($maddeler), fn (string $k) => str_starts_with($k, 'T3-')));

return [
    'kapsam_notu' => 'Puanlar Kahramanmaraş Sütçü İmam Üniversitesi Öğretim Üyeliğine Atama, '
        .'Yükseltme Ölçütleri ve Uygulama Esaslarının Tablo 1, 2 ve 3\'ünden. Barajlar tablonun '
        .'tamamına değil kümesine bağlı: fen, sağlık ve sosyal alanlarda Tablo 1 + Tablo 3, '
        .'Güzel Sanatlar ve Mimarlık alanlarında Tablo 1 + Tablo 2 + Tablo 3. '
        .'Yazar çarpanı Tablo 4\'e göre işliyor (tek yazar %100; iki yazarlıda %90/%70; üç '
        .'yazarlıda %80/%60/%50; dört yazarlıda %70/%50/%40/%30; beş ve daha fazla yazarlıda '
        .'%60/%40/%30/%20 ve beşinciden sonrası %10). Yazar listesini boş bırakırsanız çarpan hiç '
        .'uygulanmaz ve puanınız olduğundan YÜKSEK görünür. Atıf puanı yönerge gereği yazarlar '
        .'arasında bölünmüyor. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: idari görevler, dergi görevleri ve '
        .'danışmanlıklar yönergede "her bir yıl için" verildiği hâlde yıl biriktirmesi '
        .'hesaplanamadığı için görev başına tek yıl sayılıyor; dergi görevlerinde editör, '
        .'yardımcı editör ve kurul üyesi ayrımı, patentte onay belgeli ile araştırma raporu '
        .'ayrımı, ansiklopedi maddesinde uluslararası-ulusal ayrımı kayıttan '
        .'okunamadığı için hepsi en düşük değerden sayılıyor. Ulusal poster bildiri (0,5 puan) '
        .'aşağı yuvarlandığında sıfırlandığı için hiç sayılmıyor. Yurt dışı çalışma, h-indeksi, '
        .'spor branşlarında görev ve öğrenci danışmanlığı kalemleri sözlükte karşılıksız olduğu '
        .'için girilemedi. '
        .'Patent BAŞVURUNUZU kaydetmeyin: yönerge ona ayrı ve düşük puan veriyor ama kayıt türü '
        .'tescilliden ayrılamadığı için o satırlar girilmedi. '
        .'Puanınız şu kalemde OLDUĞUNDAN YÜKSEK görünebilir: yönerge "patentlerde puan kişi '
        .'sayısına bölünür" derken Tablo 4\'ün katkı oranları sıraya bağlı olduğu için çok '
        .'buluşçulu patentin puanı bölünmüyor (en çok 25 puanlık sapma).',

    // Tablo 4: Yayınlarda Kullanılacak Katkı Oranları Hesabı.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev',
            'odul', 'editorluk', 'toplumsal_katki', 'proje', 'diger'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.80, 4 => 0.70, 5 => 0.60], 'sonrasi' => 0.60],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.80, 4 => 0.70, 5 => 0.60], 'sonrasi' => 0.60],
            'yazar_2' => ['kademeler' => [2 => 0.70, 3 => 0.60, 4 => 0.50, 5 => 0.40], 'sonrasi' => 0.40],
            'yazar_3' => ['kademeler' => [3 => 0.50, 4 => 0.40, 5 => 0.30], 'sonrasi' => 0.30],
            'yazar_4' => ['kademeler' => [4 => 0.30, 5 => 0.20], 'sonrasi' => 0.20],
            'yazar_5' => ['kademeler' => [5 => 0.10], 'sonrasi' => 0.10],
            'yazar_6' => ['sonrasi' => 0.10],
            'ortak' => ['kademeler' => [1 => 1.00, 2 => 0.70, 3 => 0.50, 4 => 0.30, 5 => 0.10], 'sonrasi' => 0.10],
        ],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        'T1' => $t1,
        'T2' => $t2,
        'T3' => $t3,
        'T1-T3' => array_merge($t1, $t3),
        'T1-T2-T3' => array_merge($t1, $t2, $t3),

        // Madde 4(4)(a) ve 4(5)(a): "Tablo 1'de yer alan 1/a, b, 2/a, b, c, d
        // ve 4/e, f, g, h maddelerinde belirtilen yayın türleri".
        'DR-YAYIN' => ['T1-1a', 'T1-1b', 'T1-2a', 'T1-2b', 'T1-2c', 'T1-2d',
            'T1-4e', 'T1-4f', 'T1-4g', 'T1-4h'],

        // Madde 5 ve 6: "Tablo 1'de yer alan 1/a, b ve 2/a, b, c, d maddeleri".
        'DOC-YAYIN' => ['T1-1a', 'T1-1b', 'T1-2a', 'T1-2b', 'T1-2c', 'T1-2d'],
    ],

    'grup_tavanlari' => [],
];
