<?php

use App\Enums\Kategori;

/**
 * ORDU ÜNİVERSİTESİ — EK-1 Akademik Etkinlik Puanlama Tablosu
 * Kaynak: pdf/17537005692.orduuniverstesi.pdf (13 sayfa; Senato
 * 04.08.2017-2017/84, değişiklikler 2017/150, 2018/76, 2019/111,
 * 2020/91, 2022/143 ve 2023/52 Senato kararları)
 *
 * Madde kodları tablonun kendi numaralandırması (A.1.1.1, G.3, M.7 …).
 * Koşullar PUAN GRUBU harflerine atıf yapıyor ("A, B ve C puan grubu
 * kapsamında", "A, B, C, G, I, K, L ve M puan grubu"), bu yüzden harf
 * grupları `gruplar` altında tanımlandı.
 *
 * ── AYNI ETİKETE DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   A.1.1.3 kısa rapor (25) ile A.1.1.4 olgu sunumu, editöre mektup ve
 *       teknik not (20) tek `vaka_teknik_not` türüne düşüyor → 20;
 *       A.1.2 karşılıkları (20/15) → 15.
 *   A.1.1.5 özet ve kitap değerlendirmesi (15) ayrı bir tür olmadığı
 *       için girilmedi.
 *   C.2 uluslararası kitap bölümü ile editörlüğü aynı satırda (50);
 *       C.4 ulusal karşılığı (40).
 *   D.1/D.3 (SCI dergisi ve uluslararası kitap atfı, 5) ile D.2/D.4
 *       (diğer dergi ve ulusal kitap, 2).
 *   F bölümünde editörlük ve yayın kurulu üyeliği satırları; hakemlik
 *       için en düşük satır (F.8, 10) alındı.
 *   H bölümündeki toplantı düzenleme görevleri (25/15/15/10) → 10.
 *   K bölümündeki sportif faaliyetler (25/20/20) → 20 ve yıl çarpanlı
 *       satırlar tek satırda.
 *   M bölümündeki sanat etkinliklerinin uluslararası ve ulusal ayrımı
 *       etiketten okunabildiği yerde ayrıldı.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   C.7 (adayın adıyla anılan denklem, şema, şekil, sendrom ve tablolar;
 *       40 puan) — sözlükte karşılık yok.
 *   I.2 ve I.4 (DEVAM EDEN tez yönetimi, 15 ve 5) — kayıt yalnız
 *       tamamlanmış tezleri taşıyor.
 *   L bölümünün ayrıntılı film, video ve radyo-TV satırları kısmen.
 *
 * ── MOTORUN KARŞILAYAMADIĞI SINIRLAR ──
 * "I.5 verilen ders başına, en çok beş ders" (tavan olarak yazıldı),
 * "J idari görevlerde en az 6 ay belgelendirilmiş olmak" ve "× yıl"
 * çarpanları.
 *
 * Yönerge: yonerge/ordu.php
 */
$SCI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];
$TAM = ['ozgun_makale'];
$DERLEME = ['derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];

$sanatKisiselU = ['Kişisel Etkinlik (Uluslararası)', 'Elektronik Kişisel Sergi (Uluslararası)',
    'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)'];
$sanatKisiselN = ['Kişisel Etkinlik (Ulusal)', 'Elektronik Kişisel Sergi (Ulusal)',
    'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)'];
$sanatSatin = ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)',
    'Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt İçi)',
    'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)',
    'Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı',
    'Uygulama Projesi — Danışman'];
$sanatKarmaJurili = ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Ulusal)',
    'Elektronik Karma Sergi (Uluslararası)', 'Elektronik Karma Sergi (Ulusal)',
    'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)',
    'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)'];
$sanatKarma = ['Karma Etkinlik (Jürisiz, Ulusal)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)',
    'Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)',
    'Jüri Üyeliği (Ulusal)', 'Eserin Haber Olması (Uluslararası)', 'Eserin Haber Olması (Ulusal)'];
$sanatBireysel = ['Resital (Uluslararası)', 'Resital (Ulusal)', 'Solistlik (Uluslararası)',
    'Solistlik (Ulusal)', 'Şan Resitali (Uluslararası)', 'Şan Resitali (Ulusal)',
    'Opera Birinci Rol (Uluslararası)', 'Opera Birinci Rol (Ulusal)', 'Bale Başrol (Uluslararası)',
    'Bale Başrol (Ulusal)', 'Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)'];
$sanatGrup = ['Orkestra / Koro Üyeliği', 'Oda Müziği Grup Üyeliği (Uluslararası)',
    'Oda Müziği Grup Üyeliği (Ulusal)', 'Corps de Ballet (Uluslararası)', 'Corps de Ballet (Ulusal)',
    'Karma Albüm / CD-DVD Katkısı', 'Başkemancılık (Uluslararası)', 'Başkemancılık (Ulusal)'];
$muzikTasarim = ['Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Opera/Bale Kompozisyonu',
    'Orkestralı Sahne Eseri', 'Küçük Ölçekli Orkestra Eseri', 'Oda/Koro Müziği Eseri (≥15 dk)',
    'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)',
    'Elektronik Müzik Eseri (<15 dk)', 'Sahne/Ekran Müziği', 'Özgün Eser / Beste / Tasarım',
    'Orkestrasyon/Transkripsiyon'];
$filmYonetim = ['Yönetmenlik (Sahne/Ekran)', 'Belgesel/Kısa Film (Uluslararası)',
    'Belgesel/Kısa Film (Ulusal)', 'Rejisörlük (Uluslararası)', 'Rejisörlük (Ulusal)',
    'Rejisörlük (Konservatuvar)'];

$sanatKullanilan = array_merge($sanatKisiselU, $sanatKisiselN, $sanatSatin, $sanatKarmaJurili,
    $sanatKarma, $sanatBireysel, $sanatGrup, $muzikTasarim, $filmYonetim);
$sanatKalan = array_values(array_diff(Kategori::SanatselEtkinlik->kaynaklar(), $sanatKullanilan));

$maddeler = [
    // ══ A.1 ULUSLARARASI MAKALELER ══
    'A.1.1.1' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI indekslerince taranan dergide yayımlanan tam metin makale', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => $TAM, 'puan' => 50],
    'A.1.1.2' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI dergisinde derleme makale', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => $DERLEME, 'puan' => 25],
    'A.1.1.4' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI dergisinde kısa rapor, olgu sunumu, editöre mektup veya teknik not', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => $KISA, 'puan' => 20],
    'A.1.2.1' => ['baslik' => 'Diğer indekslerce taranan uluslararası dergide yayımlanan tam metin makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $TAM, 'puan' => 40],
    'A.1.2.2' => ['baslik' => 'Diğer indekslerce taranan uluslararası dergide derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $DERLEME, 'puan' => 20],
    'A.1.2.4' => ['baslik' => 'Diğer indekslerce taranan uluslararası dergide kısa rapor, olgu sunumu, editöre mektup veya teknik not', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 15],

    // ══ A.2 ULUSAL MAKALELER ══
    'A.2.1' => ['baslik' => 'Hakemli ulusal dergide yayımlanmış tam metin ya da derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 30],
    'A.2.2' => ['baslik' => 'Hakemli ulusal dergide yayımlanmış olgu sunumu, teknik not ve benzeri makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 15],

    // ══ B. BİLDİRİLER ══
    'B.1.1' => ['baslik' => 'Uluslararası kongre ya da sempozyum kitapçığında yayımlanmış sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin', 'Davetli Konuşmacı'], 'puan' => 25],
    'B.1.2' => ['baslik' => 'Uluslararası kongre ya da sempozyum kitapçığında yayımlanmış poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 20],
    'B.2.1' => ['baslik' => 'Ulusal kongre ya da sempozyum kitapçığında yayımlanmış sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 20],
    'B.2.2' => ['baslik' => 'Ulusal kongre ya da sempozyum kitapçığında yayımlanmış poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 15],

    // ══ C. KİTAP VE KİTAP BÖLÜMLERİ ══
    'C.1' => ['baslik' => 'Alanınızda yabancı dilde yazılmış ve yurt dışında basılmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 150],
    'C.2' => ['baslik' => 'Alanınızda yabancı dilde yazılmış ve yurt dışında basılmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 50],
    'C.2-ed' => ['baslik' => 'Alanınızda yurt dışında basılmış kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 50],
    'C.3' => ['baslik' => 'Alanınızda Türkçe yazılmış, ulusal yayınevlerinde basılmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Çeviri Kitap'], 'puan' => 80],
    'C.4' => ['baslik' => 'Alanınızda Türkçe yazılmış, ulusal yayınevlerinde basılmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Çeviri Kitap Bölümü', 'Ders / Metot Kitabı'], 'puan' => 40],
    'C.4-ed' => ['baslik' => 'Alanınızda ulusal yayınevlerinde basılmış kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 40],
    'C.6' => ['baslik' => 'Alanınızda ansiklopedi bölümü ya da maddesi', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 10],

    // ══ D. ATIFLAR ══
    'D.1' => ['baslik' => 'SCI, SCI-Expanded, SSCI ve AHCI kapsamındaki dergilerde ve uluslararası bilimsel kitaplarda eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 5],
    'D.2' => ['baslik' => 'Diğer dergilerde ve ulusal bilimsel kitaplarda eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 2],

    // ══ E. ÖDÜLLER VE PATENTLER ══
    'E.1' => ['baslik' => 'Uluslararası bilimsel ya da sanatsal kuruluşlarca verilen jürili bilim ve sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 50],
    'E.3' => ['baslik' => 'Ulusal bilimsel ya da sanatsal kuruluşlarca verilen bilim, sanat ve teşvik ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü', 'Yarışma Derecesi / Mansiyon', 'Burs'], 'puan' => 30],
    'E.6' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 100],
    'E.7' => ['baslik' => 'Ulusal patent, faydalı model, endüstriyel tasarım ya da yazılım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili', 'Ticarileştirme'], 'puan' => 60],

    // ══ F. DERGİLERDE EDİTÖRLÜK, KURUL ÜYELİĞİ VE HAKEMLİK ══
    'F.1' => ['baslik' => 'SCI, SCI-Expanded, SSCI ve AHCI kapsamındaki dergilerde editörlük ya da yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 40],
    'F.3' => ['baslik' => 'Diğer uluslararası indekslere kayıtlı dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 40],
    'F.5' => ['baslik' => 'Ulusal hakemli dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 20],
    'F.6' => ['baslik' => 'Ulusal hakemli dergilerde yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 15],
    'F.8' => ['baslik' => 'Dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 10],

    // ══ G. PROJELER ══
    'G.1' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen araştırma projesi yürütücülüğü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 150],
    'G.2' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen araştırma projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 75],
    'G.3' => ['baslik' => 'Ulusal kuruluşlarca (TÜBİTAK, TÜBA ve benzeri) desteklenen araştırma projesi yürütücülüğü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 75],
    'G.4' => ['baslik' => 'Ulusal kuruluşlarca desteklenen araştırma projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 40],
    'G.5' => ['baslik' => 'Üniversite BAP projesi yürütücülüğü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 30],
    'G.6' => ['baslik' => 'Üniversite BAP projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],

    // ══ H. BİLİMSEL TOPLANTI DÜZENLEME ══
    'H.4' => ['baslik' => 'Bilimsel ya da sanatsal etkinlik düzenlemede yöneticilik veya kurul üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 10],

    // ══ I. EĞİTİM-ÖĞRETİM FAALİYETLERİ ══
    'I.1' => ['baslik' => 'Sonuçlanmış doktora ya da tıpta uzmanlık tez yönetimi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 30],
    'I.3' => ['baslik' => 'Sonuçlanmış yüksek lisans tez yönetimi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'puan' => 10],
    'I.5' => ['baslik' => 'Verilen ders başına', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi', 'Akreditasyon Faaliyeti'], 'puan' => 2],

    // ══ J. İDARİ GÖREVLER ══
    'J.1' => ['baslik' => 'Rektörlük (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör'], 'puan' => 20],
    'J.2' => ['baslik' => 'Rektör yardımcılığı, dekanlık ya da enstitü müdürlüğü (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü'], 'puan' => 15],
    'J.3' => ['baslik' => 'Meslek yüksekokulu, yüksekokul ya da uygulama ve araştırma merkezi müdürlüğü (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 10],
    'J.4' => ['baslik' => 'Dekan yardımcılığı ya da bölüm başkanlığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkanı'], 'puan' => 8],
    'J.5' => ['baslik' => 'Müdür yardımcılığı, bölüm başkan yardımcılığı, anabilim dalı başkanlığı ya da kurul üyeliği (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük', 'Senato / Üniversite Yönetim Kurulu Üyesi', 'Kurul / Komisyon Üyeliği'], 'puan' => 5],
    'J.6' => ['baslik' => 'Toplumsal katkı ve kamu kurumlarıyla iş birliği faaliyetleri', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı', 'Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 5],

    // ══ L. MÜZİK VE GÖRSEL-İŞİTSEL TASARIMLAR ══
    'L.3' => ['baslik' => 'Film, video, radyo ya da televizyon yapıtlarının yapımcılığı, yönetmenliği veya görüntü yönetmenliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $filmYonetim, 'puan' => 20],
    'L.1' => ['baslik' => 'Çalgı tasarımı, kompozisyon, senfonik, oda ve koro müziği yapıtı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $muzikTasarim, 'puan' => 15],

    // ══ M. SANATSAL ETKİNLİKLER ══
    'M.1' => ['baslik' => 'Üniversiteler, müzik okulları ve festivallerde bireysel olarak icra edilen sanatsal etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatBireysel, 'puan' => 15],
    'M.2' => ['baslik' => 'Üniversiteler, müzik okulları ve festivallerde grup olarak icra edilen sanatsal etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatGrup, 'puan' => 10],
    'M.3' => ['baslik' => 'Özgün sanat eserinizin, bestenizin ya da tasarımınızın satın alınması, uygulanması veya yayın organlarında yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatSatin, 'puan' => 20],
    'M.4' => ['baslik' => 'Yurt dışında kişisel sanat etkinliğinde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKisiselU, 'puan' => 25],
    'M.5' => ['baslik' => 'Yurt içinde kişisel sanat etkinliğinde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKisiselN, 'puan' => 20],
    'M.6' => ['baslik' => 'Jürili karma sanat ve tasarım etkinliğine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKarmaJurili, 'puan' => 20],
    'M.8' => ['baslik' => 'Karma sanat ve tasarım etkinliğine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => [...$sanatKarma, ...$sanatKalan], 'puan' => 10],

    // ══ K. SPORTİF FAALİYETLER ══
    'K.2' => ['baslik' => 'Ulusal ya da uluslararası müsabakalarda ilk üçe giren takımın teknik kadrosunda yer almak, hakemlik ya da antrenörlük yapmak', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 20],
];

return [
    'kapsam_notu' => 'Puanlar Ordu Üniversitesi EK-1 Akademik Etkinlik Puanlama Tablosundan. '
        .'Yönerge madde 6 çok yazarlı eserlerde EK-2 tablosunu uygulamaya gönderiyor; EK-2 '
        .'tablosu PDF metninde yer almadığı için yazar çarpanı UYGULANMIYOR ve çok yazarlı '
        .'eserleriniz tam puan alıyor — puanınız olduğundan YÜKSEK görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: A.1.1.3 kısa rapor (25) ile A.1.1.4 '
        .'olgu sunumu ve editöre mektup (20) aynı türe düştüğü için 20 puandan; A.1.1.5 özet ve '
        .'kitap değerlendirmesi (15) ayrı bir tür olmadığı için hiç girilmedi. Hakemlikler 10, '
        .'toplantı düzenleme görevleri 10 puandan sayılıyor. C.7 (adayınızın adıyla anılan '
        .'denklem, şema, şekil, sendrom ve tablolar; 40 puan) ile I.2 ve I.4 (DEVAM EDEN tez '
        .'yönetimi) sözlükte karşılıksız ya da kayıtta yok. '
        .'Puanınız şu kalemde OLDUĞUNDAN YÜKSEK görünebilir: I.5\'in "en çok beş ders" sınırı '
        .'tavan olarak yazıldı ama J bölümünün "en az 6 ay belgelendirilmiş olmak" koşulu ve '
        .'"× yıl" çarpanları uygulanmıyor.',

    'maddeler' => $maddeler,

    'gruplar' => [
        // Koşulların atıf yaptığı puan grubu harfleri.
        'A' => ['A.1.1.1', 'A.1.1.2', 'A.1.1.4', 'A.1.2.1', 'A.1.2.2', 'A.1.2.4', 'A.2.1', 'A.2.2'],
        'B' => ['B.1.1', 'B.1.2', 'B.2.1', 'B.2.2'],
        'C' => ['C.1', 'C.2', 'C.2-ed', 'C.3', 'C.4', 'C.4-ed', 'C.6'],
        'G' => ['G.1', 'G.2', 'G.3', 'G.4', 'G.5', 'G.6'],
        'I' => ['I.1', 'I.3', 'I.5'],
        'K' => ['K.2'],
        'L' => ['L.1', 'L.3'],
        'M' => ['M.1', 'M.2', 'M.3', 'M.4', 'M.5', 'M.6', 'M.8'],

        'ABC' => ['A.1.1.1', 'A.1.1.2', 'A.1.1.4', 'A.1.2.1', 'A.1.2.2', 'A.1.2.4', 'A.2.1', 'A.2.2',
            'B.1.1', 'B.1.2', 'B.2.1', 'B.2.2',
            'C.1', 'C.2', 'C.2-ed', 'C.3', 'C.4', 'C.4-ed', 'C.6'],
        'ABCK' => ['A.1.1.1', 'A.1.1.2', 'A.1.1.4', 'A.1.2.1', 'A.1.2.2', 'A.1.2.4', 'A.2.1', 'A.2.2',
            'B.1.1', 'B.1.2', 'B.2.1', 'B.2.2',
            'C.1', 'C.2', 'C.2-ed', 'C.3', 'C.4', 'C.4-ed', 'C.6', 'K.2'],
        'ABCLM' => ['A.1.1.1', 'A.1.1.2', 'A.1.1.4', 'A.1.2.1', 'A.1.2.2', 'A.1.2.4', 'A.2.1', 'A.2.2',
            'B.1.1', 'B.1.2', 'B.2.1', 'B.2.2',
            'C.1', 'C.2', 'C.2-ed', 'C.3', 'C.4', 'C.4-ed', 'C.6',
            'L.1', 'L.3', 'M.1', 'M.2', 'M.3', 'M.4', 'M.5', 'M.6', 'M.8'],
        // Doçentlik ve profesörlüğün baraj kümesi: A, B, C, G, I, K, L, M.
        'ABCGIKLM' => ['A.1.1.1', 'A.1.1.2', 'A.1.1.4', 'A.1.2.1', 'A.1.2.2', 'A.1.2.4', 'A.2.1', 'A.2.2',
            'B.1.1', 'B.1.2', 'B.2.1', 'B.2.2',
            'C.1', 'C.2', 'C.2-ed', 'C.3', 'C.4', 'C.4-ed', 'C.6',
            'G.1', 'G.2', 'G.3', 'G.4', 'G.5', 'G.6',
            'I.1', 'I.3', 'I.5', 'K.2', 'L.1', 'L.3',
            'M.1', 'M.2', 'M.3', 'M.4', 'M.5', 'M.6', 'M.8'],

        // "A.1 kapsamındaki dergilerde yayımlanmış TAM METİN makale".
        'A.1-TAM' => ['A.1.1.1', 'A.1.2.1'],
        // "A.1.1 kapsamındaki dergilerde yayımlanmış TAM METİN makale".
        'A.1.1-TAM' => ['A.1.1.1'],
        // Profesörlükte başlıca eser: makale ya da ISBN'li kitap.
        'BASLICA-ESER' => ['A.1.1.1', 'A.1.2.1', 'A.2.1', 'C.1', 'C.2', 'C.3', 'C.4'],
        // Tavan grubu.
        'DERS' => ['I.5'],
    ],

    // I.5: "Verilen ders başına (en çok beş ders için)".
    'grup_tavanlari' => ['DERS' => 10],
];
