<?php

use App\Enums\Kategori;

/**
 * KAYSERİ ÜNİVERSİTESİ — Tablo 1a, Tablo 1b ve Tablo 2
 * Kaynak: pdf/17536999912.kayseriuniverstesi.pdf (23 sayfa; Senato
 * 03.04.2024-10, YÖK Genel Kurulu 24.10.2024; Bilgisayar ve Bilişim
 * Bilimleri Fakültesi ölçütleri 27.12.2024-2024.30.209 ve YÖK 30.01.2025)
 *
 * MADDE KODLARI BİZE AİT: yönergenin üç tablosunda satır numarası yok,
 * satırlar "Türü / Tanımı / Puanı" sütunlarıyla veriliyor. Koşullar
 * tablolara ADIYLA atıf yapıyor ("Tablo 1a ve Tablo 2'den toplamda en az
 * 75 puan"), bu yüzden kodlar `T1A-`, `T1B-`, `T2-` önekleriyle üretildi
 * ve tablo kümeleri `T1A`, `T1B`, `T2`, `T1A-T2`, `T1A-T1B` gruplarına
 * karşılık geliyor.
 *
 * ── BARAJ TABLONUN TAMAMINA DEĞİL KÜMESİNE BAĞLI ──
 * Mühendislik, fen, sosyal ve sağlık alanlarında baraj "Tablo 1a ve Tablo
 * 2"ye; mimarlık ve güzel sanatlar alanlarında ise hem "Tablo 1a ve Tablo
 * 1b"ye hem "Tablo 2"ye ayrı ayrı bağlı. Bütün `Kalip::toplam` çağrıları
 * bu yüzden `maddeler` grubu ve düz Türkçe `liste` adı taşıyor.
 *
 * ── AYNI KAYNAĞA DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   Derleme ve diğer çalışmalarda SSCI/AHCI/SCI (60 ve 15) ile
 *       SCI-Expanded (50 ve 10) ayrımı kayıtta yok → 50 ve 10.
 *   Patentte incelemeli (120) ile incelemesiz (60) ayrımı yok → 60.
 *   Tam metin bildiride uluslararası (15) ile uluslararası katılımlı (10)
 *       ayrımı yok → 10; özet bildiride (8/4) → 4.
 *   Ders kitabı (50/30), kitap bölümü (30/15), editörlük (40/20),
 *       ansiklopedi maddesi (15/10) ve davetli konuşmacılık (25/10/5)
 *       satırlarında uluslararası-ulusal ayrımı yalnızca kitap ve bölüm
 *       etiketlerinde tutulabildiği için kalanlar en düşük değerden.
 *   Dergi görevlerinde editör, yardımcı editör, misafir editör ve kurul
 *       üyeliği ayrımı yok → uluslararası 10, ulusal 5, yayın kurulu 10,
 *       hakemlik 5.
 *   İdari görevlerde dekanlık (25) ile enstitü/yüksekokul müdürlüğü (20)
 *       tek etikete düşüyor → 20; bilimsel kurul üyeliği (20/10) ile idari
 *       kurul üyeliği (5) tek etikete düşüyor → 5.
 *   Ödüllerde ulusal bilim ödülü (25) ile kongre en iyi bildiri ödülü
 *       (10/3) ayrı etiketlerde tutuldu; yarışma dereceleri → 3.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   Patent, faydalı model BAŞVURU satırları ve Teknoloji Transfer Ofisi
 *       buluş bildirimi — tescilliden ayrılamıyor.
 *   Hakemsiz dergilerde yayın (5 ve 1), indeksli dergide özet/abstract
 *       (2), kitap eleştirisi (10/5), makale çevirisi (8), spor
 *       branşlarında görev, soruşturma, lisans öğrenci danışmanlığı ve
 *       öğrenci kulübü danışmanlığı — sözlükte karşılık yok.
 *   Tablo 2'nin "adayın adı ile anılan formül, şema, grafik, tablo ve
 *       resimlere yer verilmesi" satırı (40) — atıf sözlüğünde karşılığı
 *       yok.
 *   Endüstriyel tasarım, yazılım ve ticarileştirme — patent bölümünde
 *       karşılık gelen satır yok.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   Proje satırlarının "Yürütücü %100, araştırmacı öğretim üyesi %75"
 *       açıklaması rol satırlarına gömüldü ve §0 uyarınca aşağı
 *       yuvarlandı; "danışman gerçek kişi projelerinde %50" ayrımı
 *       yapılamadı.
 *   "En çok N adet/yıl" sınırları (bildiri, hakemlik, proje danışmanlığı,
 *       tez jüri üyeliği) ve idari görevin "görev süresi boyunca 1 kez
 *       puanlanacaktır" kuralı — yıl biriktirmesi motorda yok.
 *   V/9: "İlgili tablolardan alınması gereken asgari puanların tamamı
 *       aynı maddeden olamaz" — kayıt bazlı dağılım kuralı.
 *   V/1: WOS etki faktörü 5 üzeri dergide başlıca yazar olan ya da
 *       h-indeksi eşiğini aşan adaylardan "herhangi bir ölçüt aranmaz"
 *       muafiyeti — yönerge dosyasında `beyan` olarak anıldı.
 *   Tablo 3'ün "sorumlu yazara tekabül eden puanın %15'i ilave edilir"
 *       kuralı: kayıt sorumlu yazarlığı başlıca yazarlıktan ayırmadığı
 *       için §0 uyarınca ZAM UYGULANMADI; sorumlu yazar olduğunuz
 *       yayınlarda puanınız olduğundan DÜŞÜK görünür.
 *
 * Yönerge: yonerge/kayseri.php
 */
$SCI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];
$DIGER_INDEKS = ['ESCI / Scopus', 'Diğer Uluslararası İndeks'];
$ULUSAL = ['TR Dizin', 'Diğer Ulusal Hakemli'];
$OZGUN = ['ozgun_makale'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];

$sanatKisiselU = ['Kişisel Etkinlik (Uluslararası)', 'Elektronik Kişisel Sergi (Uluslararası)',
    'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)',
    'Resital (Uluslararası)', 'Solistlik (Uluslararası)', 'Şan Resitali (Uluslararası)'];
$sanatKisiselN = ['Kişisel Etkinlik (Ulusal)', 'Elektronik Kişisel Sergi (Ulusal)',
    'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)',
    'Resital (Ulusal)', 'Solistlik (Ulusal)', 'Şan Resitali (Ulusal)'];
$sanatKarmaU = ['Karma/Jürili Etkinlik (Uluslararası)', 'Elektronik Karma Sergi (Uluslararası)',
    'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)',
    'Oda Müziği Grup Üyeliği (Uluslararası)'];
$sanatKarmaN = ['Karma/Jürili Etkinlik (Ulusal)', 'Elektronik Karma Sergi (Ulusal)',
    'Karma Etkinlik (Jürisiz, Ulusal)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)',
    'Oda Müziği Grup Üyeliği (Ulusal)', 'Orkestra / Koro Üyeliği'];
$sanatFilmU = ['Belgesel/Kısa Film (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)'];
$sanatFilmN = ['Belgesel/Kısa Film (Ulusal)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'];
$sanatSatinU = ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Müzeye Kabulü (Yurt Dışı)'];
$sanatSatinN = ['Eserin Satın Alınması (Yurt İçi)', 'Eserin Müzeye Kabulü (Yurt İçi)'];
$sanatHaberU = ['Eserin Haber Olması (Uluslararası)'];
$sanatHaberN = ['Eserin Haber Olması (Ulusal)'];
$sanatJuriU = ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'];
$sanatJuriN = ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'];
$sanatCalistayU = ['Masterclass (Uluslararası)', 'Eğitici Konser Programı (Uluslararası)'];
$sanatCalistayN = ['Masterclass (Ulusal)', 'Eğitici Konser Programı (Ulusal)', 'Müzikoloji Atölyesi',
    'Eğitim Amaçlı Sanat Etkinliği'];
$sanatKatilimU = ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)'];
$sanatUygulama = ['Uygulama Projesi — Müellif'];
$sanatUygulamaEkip = ['Uygulama Projesi — Ekip'];
$sanatUygulamaYrd = ['Uygulama Projesi — Ekip Yardımcısı'];
$sanatUygulamaDan = ['Uygulama Projesi — Danışman', 'Koruma-Onarım Uygulaması (Uluslararası)',
    'Koruma-Onarım Uygulaması (Ulusal)'];

$sanatKullanilan = array_merge($sanatKisiselU, $sanatKisiselN, $sanatKarmaU, $sanatKarmaN,
    $sanatFilmU, $sanatFilmN, $sanatSatinU, $sanatSatinN, $sanatHaberU, $sanatHaberN,
    $sanatJuriU, $sanatJuriN, $sanatCalistayU, $sanatCalistayN, $sanatKatilimU,
    $sanatUygulama, $sanatUygulamaEkip, $sanatUygulamaYrd, $sanatUygulamaDan);
$sanatKalan = array_values(array_diff(Kategori::SanatselEtkinlik->kaynaklar(), $sanatKullanilan));

$maddeler = [
    // ══════════ TABLO 1a — BİLİMSEL YAYINLAR ══════════
    'T1A-D1' => ['baslik' => 'SSCI, AHCI, SCI veya SCI-Expanded kapsamındaki dergide yayımlanmış derleme', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => ['derleme'], 'puan' => 50],
    'T1A-D2' => ['baslik' => 'Ulusal ya da uluslararası hakemli dergide yayımlanmış derleme', 'kategori' => 'makale', 'kaynaklar' => [...$DIGER_INDEKS, ...$ULUSAL], 'turler' => ['derleme'], 'puan' => 20],

    'T1A-A1' => ['baslik' => 'SSCI, AHCI, SCI veya SCI-Expanded kapsamındaki dergide yayımlanmış araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => $OZGUN, 'puan' => 50],
    'T1A-A2' => ['baslik' => 'Diğer indekslere giren dergide yayımlanmış araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => $DIGER_INDEKS, 'turler' => $OZGUN, 'puan' => 30],
    'T1A-A3' => ['baslik' => 'Ulusal hakemli dergide yayımlanmış araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => $ULUSAL, 'turler' => $OZGUN, 'puan' => 20],

    'T1A-C1' => ['baslik' => 'SSCI, AHCI, SCI veya SCI-Expanded kapsamındaki dergide teknik not, yorum, vaka takdimi ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => $KISA, 'puan' => 10],
    'T1A-C2' => ['baslik' => 'Ulusal ya da uluslararası hakemli dergide teknik not, yorum, vaka takdimi ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => [...$DIGER_INDEKS, ...$ULUSAL], 'turler' => $KISA, 'puan' => 5],

    'T1A-P1' => ['baslik' => 'Ulusal ya da uluslararası patent (başvuru sonuçlanmış)', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent', 'Ulusal Patent'], 'puan' => 60],
    'T1A-P2' => ['baslik' => 'Faydalı model ya da yeni ürün (başvuru sonuçlanmış)', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 25],

    'T1A-PR1' => ['baslik' => 'Yurt dışı destekli araştırma projesinde yürütücü, baş araştırmacı ya da koordinatör', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 100],
    'T1A-PR2' => ['baslik' => 'Yurt dışı destekli araştırma projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 75],
    'T1A-PR3' => ['baslik' => 'Yurt içi, üniversite dışı destekli araştırma projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 80],
    'T1A-PR4' => ['baslik' => 'Yurt içi, üniversite dışı destekli araştırma projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 60],
    'T1A-PR5' => ['baslik' => 'Üniversite destekli araştırma projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 15],
    'T1A-PR6' => ['baslik' => 'Üniversite destekli araştırma projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 11],
    'T1A-PR7' => ['baslik' => 'Proje danışmanlığı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon', 'TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK', 'BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['danisman'], 'puan' => 5],

    'T1A-B1' => ['baslik' => 'Uluslararası toplantıda sunulmuş ve tam metni yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 10],
    'T1A-B2' => ['baslik' => 'Ulusal toplantıda sunulmuş ve tam metni yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 3],
    'T1A-B3' => ['baslik' => 'Uluslararası toplantıda sunulmuş ve özeti yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 4],
    'T1A-B4' => ['baslik' => 'Ulusal toplantıda sunulmuş ve özeti yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 2],

    'T1A-K1' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 100],
    'T1A-K2' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 50],
    'T1A-K3' => ['baslik' => 'Ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 30],
    'T1A-K4' => ['baslik' => 'Uluslararası yayınevi kitabına bölüm düzeyinde katkı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 30],
    'T1A-K5' => ['baslik' => 'Ulusal yayınevi kitabına bölüm düzeyinde katkı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 15],
    'T1A-K6' => ['baslik' => 'Uluslararası kitapta editörlük (çeviri editörlüğü dâhil)', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 40],
    'T1A-K7' => ['baslik' => 'Ulusal kitapta editörlük (çeviri editörlüğü dâhil)', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 20],
    'T1A-K8' => ['baslik' => 'Ansiklopedide konu ya da madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 10],
    'T1A-K9' => ['baslik' => 'Yabancı dilde basılmış bilimsel ya da edebi eserin Türkçeye tam kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 50],
    'T1A-K10' => ['baslik' => 'Yabancı dilde basılmış eserin Türkçeye bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 20],
    'T1A-K11' => ['baslik' => 'Tarihî ve yazma eserlerin (1928 ve öncesi) günümüz Türkçesine ya da latin harflerine çevrilmesi', 'kategori' => 'kitap', 'kaynaklar' => ['Tahkik (Tenkitli Metin)'], 'puan' => 40],

    // ══════════ TABLO 1b — MİMARİ VE SANATSAL ETKİNLİKLER ══════════
    'T1B-1a' => ['baslik' => 'Mimari, kentsel tasarım ya da planlama projesinde müellif', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatUygulama, 'puan' => 60],
    'T1B-1b' => ['baslik' => 'Mimari, kentsel tasarım ya da planlama projesinde proje ekibi üyesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatUygulamaEkip, 'puan' => 30],
    'T1B-1c' => ['baslik' => 'Mimari, kentsel tasarım ya da planlama projesinde proje ekibi yardımcısı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatUygulamaYrd, 'puan' => 15],
    'T1B-1d' => ['baslik' => 'Mimari, kentsel tasarım ya da planlama projesinde danışman', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatUygulamaDan, 'puan' => 20],
    'T1B-2a' => ['baslik' => 'Müellifi olduğunuz özgün yapı ve tasarımlarla uluslararası kişisel etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKisiselU, 'puan' => 20],
    'T1B-2b' => ['baslik' => 'Müellifi olduğunuz özgün yapı ve tasarımlarla ulusal kişisel etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKisiselN, 'puan' => 15],
    'T1B-3a' => ['baslik' => 'Uluslararası karma sanat etkinliğine bireysel ya da ekip hâlinde katılma', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKarmaU, 'puan' => 10],
    'T1B-3b' => ['baslik' => 'Ulusal karma sanat etkinliğine bireysel ya da ekip hâlinde katılma', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKarmaN, 'puan' => 5],
    'T1B-5' => ['baslik' => 'Jürili sanat, tasarım, proje ya da mimarlık yarışmasında derece veya mansiyon almak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 20],
    'T1B-6a' => ['baslik' => 'Jürili uluslararası belgesel, kısa film, film ya da festivale katılma', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatFilmU, 'puan' => 20],
    'T1B-6b' => ['baslik' => 'Jürili ulusal belgesel, kısa film, film ya da festivale katılma', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatFilmN, 'puan' => 10],
    'T1B-8a' => ['baslik' => 'Yapıtlarınızın uluslararası kurumlarca yayımlanması ya da satın alınması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatSatinU, 'puan' => 30],
    'T1B-8b' => ['baslik' => 'Yapıtlarınızın ulusal kurumlarca yayımlanması ya da satın alınması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatSatinN, 'puan' => 15],
    'T1B-9a' => ['baslik' => 'Yapıtlarınızın uluslararası yayınlarda yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatHaberU, 'puan' => 10],
    'T1B-9b' => ['baslik' => 'Yapıtlarınızın ulusal yayınlarda yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatHaberN, 'puan' => 5],
    'T1B-10a' => ['baslik' => 'Uluslararası sanat, proje ya da tasarım yarışması jürisinde görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatJuriU, 'puan' => 15],
    'T1B-10b' => ['baslik' => 'Ulusal sanat, proje ya da tasarım yarışması jürisinde görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatJuriN, 'puan' => 5],
    'T1B-11a' => ['baslik' => 'Uluslararası çalıştay yürütücülüğü ya da moderatörlüğü', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatCalistayU, 'puan' => 15],
    'T1B-11b' => ['baslik' => 'Ulusal çalıştay yürütücülüğü ya da moderatörlüğü', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatCalistayN, 'puan' => 5],
    'T1B-12a' => ['baslik' => 'Uluslararası çalıştayda katılımcı olmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKatilimU, 'puan' => 8],
    'T1B-12b' => ['baslik' => 'Ulusal çalıştayda katılımcı olmak ve diğer sanatsal etkinlikler', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKalan, 'puan' => 4],

    // ══════════ TABLO 2 — EĞİTİM-ÖĞRETİM, İDARİ VE DİĞER ══════════
    'T2-1' => ['baslik' => 'Kongre, konferans, sempozyum, çalıştay ya da mesleki kursta davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 5],
    'T2-2a' => ['baslik' => 'SCI, AHCI, SSCI ve SCI-Expanded dergilerinde ya da uluslararası kitaplarda eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 5],
    'T2-2b' => ['baslik' => 'Diğer indekslere giren dergilerde ya da uluslararası kongre bildirilerinde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer'], 'puan' => 3],
    'T2-2c' => ['baslik' => 'Hakemli dergiler, tezler, kongre özetleri, bildiri kitapları ve kitaplarda eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Patent'], 'puan' => 2],
    'T2-3a' => ['baslik' => 'Uluslararası bilim ve araştırma ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 50],
    'T2-3b' => ['baslik' => 'Ulusal bilim ve araştırma ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 25],
    'T2-4' => ['baslik' => 'Bilim ve araştırma bursu almak', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 5],
    'T2-5a' => ['baslik' => 'Uluslararası indekslerde taranan dergide editörlük, yardımcı editörlük ya da misafir editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 10],
    'T2-5b' => ['baslik' => 'Ulusal hakemli dergide editörlük, yardımcı editörlük ya da misafir editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 5],
    'T2-5c' => ['baslik' => 'Hakemli dergide yayın, bilim kurulu ya da komisyon üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 10],
    'T2-5d' => ['baslik' => 'Hakemli dergide hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 5],
    'T2-6' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu, bilim kurulu ya da sekretarya görevi', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 2],
    'T2-7a' => ['baslik' => 'Rektör ya da rektör yardımcısı olarak görev yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı'], 'puan' => 25],
    'T2-7b' => ['baslik' => 'Dekan, yüksekokul, meslek yüksekokulu, enstitü ya da merkez müdürü, başhekim olarak görev yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 20],
    'T2-7c' => ['baslik' => 'Dekan yardımcısı, müdür yardımcısı ya da bölüm başkanı olarak görev yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkanı'], 'puan' => 15],
    'T2-7d' => ['baslik' => 'Kurul üyeliği, bölüm başkan yardımcılığı, koordinatörlük ya da anabilim dalı başkanlığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Senato / Üniversite Yönetim Kurulu Üyesi', 'Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük', 'Kurul / Komisyon Üyeliği'], 'puan' => 5],
    'T2-8a' => ['baslik' => 'Yabancı dilde ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Yabancı Dilde Ders'], 'puan' => 10],
    'T2-8b' => ['baslik' => 'Lisansüstü, ön lisans ya da lisans dersi vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Değişim Programı Dersi', 'Akreditasyon Faaliyeti'], 'puan' => 5],
    'T2-8c' => ['baslik' => 'Lisansüstü tez jüri üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 5],
    'T2-8d' => ['baslik' => 'Üniversite-sanayi iş birliği için resmî görevlendirme', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı'], 'puan' => 5],
    'T2-8e' => ['baslik' => 'İdari ve sosyal aktiviteler için resmî görevlendirme; bilirkişilik', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 2],
    'T2-9a' => ['baslik' => 'Tamamlanmış doktora ya da tıpta uzmanlık tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 10],
    'T2-9a-es' => ['baslik' => 'Tamamlanmış doktora ya da tıpta uzmanlık tezinde eş veya ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 5],
    'T2-9b' => ['baslik' => 'Tamamlanmış yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 4],
    'T2-9b-es' => ['baslik' => 'Tamamlanmış yüksek lisans tezinde eş veya ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 2],
];

$onek = fn (string $p): array => array_values(array_filter(
    array_keys($maddeler), fn (string $k) => str_starts_with($k, $p),
));

$t1a = $onek('T1A-');
$t1b = $onek('T1B-');
$t2 = $onek('T2-');

return [
    'kapsam_notu' => 'Puanlar Kayseri Üniversitesi Akademik Yükseltme ve Atama Ölçütleri Tablo 1a, '
        .'1b ve 2\'den. Barajlar tablonun tamamına değil kümesine bağlı: mühendislik, fen, sosyal '
        .'ve sağlık alanlarında Tablo 1a + Tablo 2; mimarlık ve güzel sanatlarda ayrıca Tablo 1a + '
        .'Tablo 1b kümesi. Yazar çarpanı Tablo 3\'e göre işliyor (tek yazar %100; iki yazarlıda '
        .'%85/%70; üç yazarlıda %75/%60/%50; beş ve daha fazla yazarlıda %60/%50/%40/%30/%20 ve '
        .'altıncıdan sonrası %10). Yazar listesini boş bırakırsanız çarpan hiç uygulanmaz ve '
        .'puanınız olduğundan YÜKSEK görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: Tablo 3\'ün "sorumlu yazara %15 ilave '
        .'edilir" kuralı, kayıt sorumlu yazarlığı başlıca yazarlıktan ayırmadığı için hiç '
        .'uygulanmıyor. SCI ile SCI-Expanded, patentte incelemeli ile incelemesiz, bildiride '
        .'uluslararası ile uluslararası katılımlı ayrımı kayıttan okunamadığı için hepsi en düşük '
        .'değerden sayılıyor; dergi görevlerinde editör, yardımcı editör ve misafir editör ayrımı '
        .'da öyle. İdari görevler ve dergi görevleri "yıl başına" verildiği hâlde yıl biriktirmesi '
        .'hesaplanamıyor. Hakemsiz dergi yayınları, kitap eleştirisi, makale çevirisi, spor '
        .'branşlarında görev ve öğrenci danışmanlığı kalemleri sözlükte karşılıksız olduğu için '
        .'girilemedi. '
        .'Patent ve faydalı model BAŞVURULARINIZI kaydetmeyin: yönerge onlara ayrı ve düşük puan '
        .'veriyor ama kayıt türü tescilliden ayrılamadığı için o satırlar girilmedi. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünebilir: "en çok N adet/yıl" sınırları, '
        .'idari görevin "görev süresi boyunca bir kez puanlanır" kuralı ve "asgari puanların '
        .'tamamı aynı maddeden olamaz" kuralı uygulanmıyor.',

    // Tablo 3. Sorumlu yazara verilen %15 ilave, kayıt sorumlu yazarlığı
    // ayırmadığı için §0 uyarınca uygulanmadı.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev',
            'odul', 'editorluk', 'toplumsal_katki', 'proje', 'diger'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.85, 3 => 0.75, 4 => 0.70, 5 => 0.60], 'sonrasi' => 0.60],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.85, 3 => 0.75, 4 => 0.70, 5 => 0.60], 'sonrasi' => 0.60],
            'yazar_2' => ['kademeler' => [2 => 0.70, 3 => 0.60, 4 => 0.60, 5 => 0.50], 'sonrasi' => 0.50],
            'yazar_3' => ['kademeler' => [3 => 0.50, 4 => 0.50, 5 => 0.40], 'sonrasi' => 0.40],
            'yazar_4' => ['kademeler' => [4 => 0.40, 5 => 0.30], 'sonrasi' => 0.30],
            'yazar_5' => ['kademeler' => [5 => 0.20], 'sonrasi' => 0.20],
            'yazar_6' => ['sonrasi' => 0.10],
            'ortak' => ['kademeler' => [1 => 1.00, 2 => 0.70, 3 => 0.50, 4 => 0.40, 5 => 0.20], 'sonrasi' => 0.10],
        ],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        'T1A' => $t1a,
        'T1B' => $t1b,
        'T2' => $t2,
        'T1A-T2' => array_merge($t1a, $t2),
        'T1A-T1B' => array_merge($t1a, $t1b),

        // Koşulların andığı yayın kümeleri.
        'SCI-MAKALE' => ['T1A-A1'],
        'ULUSLARARASI-MAKALE' => ['T1A-A1', 'T1A-A2'],
        'ALAN-INDEKS-MAKALE' => ['T1A-A2'],
        'TUM-MAKALE' => ['T1A-A1', 'T1A-A2', 'T1A-A3'],
        'KITAP-TEK' => ['T1A-K1', 'T1A-K2'],
        'KITAP-EDITOR' => ['T1A-K6', 'T1A-K7'],
        'PROJE-Y' => ['T1A-PR1', 'T1A-PR3', 'T1A-PR5'],
        'PROJE-A' => ['T1A-PR2', 'T1A-PR4', 'T1A-PR6'],
        'TEZ-DOKTORA' => ['T2-9a'],
        'TEZ-YL' => ['T2-9b'],
        'MIMARI-PROJE' => ['T1B-1a', 'T1B-1b', 'T1B-1c', 'T1B-1d'],
        'YARISMA-ODUL' => ['T1B-5'],
        'DANISMANLIK' => ['T2-9a', 'T2-9a-es', 'T2-9b', 'T2-9b-es'],
    ],

    // "Danışmanlıklardan alınacak puanlar, toplamda 50 puanı aşamaz."
    'grup_tavanlari' => ['DANISMANLIK' => 50],
];
