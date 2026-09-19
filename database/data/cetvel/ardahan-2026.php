<?php

/**
 * ARDAHAN ÜNİVERSİTESİ — EK: Faaliyet Puanlama Tablosu
 * Kaynak: pdf/1785845846194.ardahan-kriter-16072026.pdf (16.07.2026)
 *
 * Madde kodları tablonun kendi numaralandırması (3.1.1, 4.10.6.1 …).
 * Bize ait olanlar:
 *   - Makale satırlarının ".a" (araştırma makalesi) ve ".b" (derleme) alt
 *     kodları. Yönerge her makale satırına "derleme makalede puanın %80'i
 *     alınır" notu düşüyor; motorda tür başına ayrı satır gerektiği için
 *     her satır ikiye bölündü ve %80 aşağı yuvarlanarak yazıldı (§0:
 *     3.1.8'de 18 × 0,8 = 14,4 → 14; 3.1.9'da 16 × 0,8 = 12,8 → 12).
 *   - Proje ve tez satırlarında rol ayrımı için açılan alt kodlar.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   ESCI çeyreklere göre 25/20/18/16, SCOPUS ise düz 25 puan; sözlükte
 *       tek 'ESCI / Scopus' etiketi var, en düşük değer (16) girildi.
 *       Kısa yazılarda 3.1.11'in 10 puanı ayrı satırda.
 *   'Diğer Uluslararası İndeks' etiketi hem 3.1.12 (Uluslararası Alan
 *       İndeksleri, 20) hem 3.1.14 (diğer uluslararası hakemli, 15)
 *       karşılığı → 15; kısa yazıda 10 ve 5 → 5. Atıfta 3 ve 2 → 2.
 *       Editörlükte 15/10/8 ile 5/3/2 → 2, hakemlikte 10 ile 5 → 5.
 *   AHCI dergilerinin çeyreği sözlükte yok; MADDE 31 "Q değeri
 *       bulunmayan AHCI dergileri Q4 kabul edilir" dediği için AHCI
 *       satırları Q4 puanından (30 / derleme 24) sayılıyor.
 *   Tez danışmanlığında asıl ve ortak danışman ayrımı kayıtta var
 *       (danışman / eş danışman), o yüzden ikisi de girildi; tez izleme
 *       komitesi (2) ile savunma jüri üyeliği (5 ve 1) tek 'Tez İzleme /
 *       Jüri Üyeliği' etiketine düşüyor → 1.
 *   Patentte tescil kademeleri (incelemeli/incelemesiz) kayıtta
 *       ayrılamıyor: uluslararası 200/45 → 45, ulusal 25/15 → 15.
 *   Ödüllerde 'Uluslararası Bilim/Sanat Ödülü' 3.15.1 (50) ile 3.15.3
 *       (20) ve 3.15.4 (15) arasında → 15; 'Ulusal Bilim/Sanat Ödülü'
 *       3.15.5 (10), 3.15.11 (15), 3.15.13 (10) arasında → 10.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   1.2 (yurt dışı/yurt içi hareketlilik), 3.5 (burslar) ve 3.18
 *       (arkeolojik kazı) — sözlükte karşılıksız; 1.2 ve 3.5 ayrıca
 *       faaliyet değil bulunma süresi ölçütü.
 *   2.2 (deney föyü, antrenör-hakem eğitimi, program geliştirme),
 *       3.16 ve 3.17 (bilimsel toplantı düzenleme kurulları), 4.4, 4.7,
 *       4.8, 4.12 (spor ve sosyal organizasyon), 4.13 (bilirkişilik) ve
 *       4.14 (girişimcilik) — sözlükte karşılıksız.
 *   3.12 (mimari proje, tasarım ve faydalı obje) — sözlükte yalnız
 *       'Endüstriyel Tasarım' ve 'Uygulama Projesi' etiketleri var;
 *       yönergenin yirmi kademesi bu ikisine indirgenemedi, yalnız
 *       uygulama projesi satırları girildi.
 *   PATENT BAŞVURUSU satırları (4.1.2, 4.1.5, 4.1.8, 4.1.9, 4.1.12,
 *       4.1.15, 4.1.18, 4.1.19) — tescilden ayrılamıyor.
 *   4.5 ve 4.9 (görsel etkinlikler), 4.6.1-4.6.5 ile 4.10.1-4.10.5
 *       (müzik, sahne ve dans performansları) sözlükteki karşılıklarıyla
 *       eşleştirildi; eşleşmeyen kademeler girilmedi.
 *   3.11.1 (h-indeksi × 2 puan) — profil h-indeksini metrik olarak
 *       tutuyor, puan satırı olarak girilemedi.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   MADDE 32: "Bir kitapta yazılmış iki bölüm dikkate alınır" ve aynı
 *       kitapta editörlük varsa yalnız bir bölümün sayılması.
 *   MADDE 34: aynı toplantıda en fazla iki bildiri.
 *   MADDE 65: yönetimsel faaliyetlerin YILLIK hesaplanması ve en az altı
 *       ay görev şartı; kayıt görev süresini taşımıyor, kayıt başına
 *       puanlanıyor.
 *   MADDE 71: "Ardahan" örneklemli çalışmaya azami 3 puan eklenmesi.
 *   MADDE 72: küsuratlı puanların bir ÜST tam puana yuvarlanması —
 *       motor §0 uyarınca aşağı yuvarlıyor.
 *   2.1'in "yabancı dilde verilen dersler için iki katı puan" kuralı
 *       ayrı satırla karşılandı; 3.11.2-3.11.9 ile 3.13, 3.14, 4.1 ve
 *       4.3'ün satır başına azami puanları girilemedi (grup tavanı
 *       yalnız başlık düzeyinde tanımlanabiliyor).
 *
 * Yönerge: yonerge/ardahan.php
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 *
 * İNDEKS KADEMESİ KAPSAM ETİKETİNE DE AÇILDI (19.09.2026, kullanıcı kararı):
 * kaynağın uluslararası kitap satırı indeks kapsamına bağlı (BKCI/Scopus/WoS)
 * ama kaynakta İNDEKSSİZ uluslararası kitabın ayrı bir satırı YOK; alternatif
 * ULUSAL satır. Kapsam etiketi bu yüzden uluslararası satıra bağlandı, ulusal
 * satırlar daraltıldı. Kaynağın indeksli/indekssiz ayrımı motorda artık
 * uygulanmıyor: indekssiz uluslararası kitabınız indeksli kitapla aynı puanı
 * alır, yani puanınız OLDUĞUNDAN YÜKSEK görünebilir.
 */
$ARASTIRMA = ['ozgun_makale'];
$DERLEME = ['derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];

/**
 * Makale satırı: yönerge her satıra "derleme makalede puanın %80'i alınır"
 * notu düştüğü için araştırma ve derleme ayrı kodlara bölünüyor.
 *
 * @param  list<string>  $kaynaklar
 * @return array<string, array<string, mixed>>
 */
$makale = function (string $kod, string $baslik, array $kaynaklar, int $puan) use ($ARASTIRMA, $DERLEME): array {
    return [
        $kod.'.a' => ['baslik' => $baslik.' (araştırma makalesi)', 'kategori' => 'makale', 'kaynaklar' => $kaynaklar, 'turler' => $ARASTIRMA, 'puan' => $puan],
        $kod.'.b' => ['baslik' => $baslik.' (derleme makale)', 'kategori' => 'makale', 'kaynaklar' => $kaynaklar, 'turler' => $DERLEME, 'puan' => (int) floor($puan * 0.8)],
    ];
};

$maddeler = [
    // ══ 1. KURUMSAL KATKI — 1.1 YÖNETİMSEL FAALİYETLER ══
    '1.1.1' => ['baslik' => 'Rektör', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör'], 'puan' => 10],
    '1.1.2' => ['baslik' => 'Rektör yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör Yardımcısı'], 'puan' => 8],
    '1.1.5' => ['baslik' => 'Dekan ya da enstitü, konservatuvar, yüksekokul veya MYO müdürü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü'], 'puan' => 5],
    '1.1.6' => ['baslik' => 'Dekan yardımcısı ya da enstitü, konservatuvar, yüksekokul veya MYO müdür yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 3],
    '1.1.9' => ['baslik' => 'Uygulama ve araştırma merkezi müdürü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 4],
    '1.1.11' => ['baslik' => 'Bölüm başkanı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 3],
    '1.1.12' => ['baslik' => 'Bölüm başkan yardımcısı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı'], 'puan' => 2],
    '1.1.13' => ['baslik' => 'Anabilim ya da bilim dalı başkanı, koordinatörlük', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 2],
    '1.1.14' => ['baslik' => 'Fakülte, enstitü, konservatuvar, yüksekokul veya MYO kurulu ya da yönetim kurulu üyesi', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 1],

    // ══ 2. EĞİTİME KATKI — 2.1 DERS YÜKÜ ══
    '2.1.1' => ['baslik' => 'Ön lisans ya da lisans dersi (dönem başına her bir ders)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Değişim Programı Dersi'], 'puan' => 2],
    '2.1.2' => ['baslik' => 'Yüksek lisans, doktora ya da uzmanlık dersi (dönem başına her bir ders)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
    '2.1.3' => ['baslik' => 'Yabancı dilde verilen ders (dönem başına her bir ders, iki katı puan)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Yabancı Dilde Ders'], 'puan' => 4],
    '2.1.4' => ['baslik' => 'Sürekli eğitim merkezi ve benzeri birimlerce düzenlenen eğitim veya kurs faaliyetlerinde ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Akreditasyon Faaliyeti'], 'puan' => 1],
];

// ══ 3.1 ULUSLARARASI HAKEMLİ DERGİDE MAKALE ══
$maddeler += $makale('3.1.1', 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamında Q1 grubundaki dergide yayımlanmış makale', ['SCIE/SSCI (Q1)'], 60);
$maddeler += $makale('3.1.2', 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamında Q2 grubundaki dergide yayımlanmış makale', ['SCIE/SSCI (Q2)'], 50);
$maddeler += $makale('3.1.3', 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamında Q3 grubundaki dergide yayımlanmış makale', ['SCIE/SSCI (Q3)'], 40);
$maddeler += $makale('3.1.4', 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamında Q4 grubundaki dergide yayımlanmış makale', ['SCIE/SSCI (Q4)', 'AHCI'], 30);
$maddeler['3.1.5'] = ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergide yayımlanmış kısa makale (editöre mektup, teknik not, vaka takdimi, tartışma, kitap incelemesi)', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => $KISA, 'puan' => 15];
$maddeler += $makale('3.1.9', 'ESCI ya da SCOPUS kapsamındaki dergide yayımlanmış makale', ['ESCI / Scopus'], 16);
$maddeler['3.1.11'] = ['baslik' => 'SCOPUS ya da ESCI kapsamındaki dergide yayımlanmış kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $KISA, 'puan' => 10];
$maddeler += $makale('3.1.14', 'Uluslararası alan indeksleri ya da diğer uluslararası hakemli dergilerde yayımlanmış makale', ['Diğer Uluslararası İndeks'], 15);
$maddeler['3.1.15'] = ['baslik' => 'Uluslararası alan indeksleri ya da diğer uluslararası hakemli dergilerde yayımlanmış kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 5];

// ══ 3.2 ULUSAL HAKEMLİ DERGİDE MAKALE ══
$maddeler += $makale('3.2.1', 'TR Dizin tarafından indekslenen hakemli dergide yayımlanmış makale', ['TR Dizin'], 25);
$maddeler['3.2.2'] = ['baslik' => 'TR Dizin tarafından indekslenen hakemli dergide yayımlanmış kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $KISA, 'puan' => 10];
$maddeler += $makale('3.2.3', 'Diğer ulusal hakemli dergide yayımlanmış makale', ['Diğer Ulusal Hakemli'], 10);
$maddeler['3.2.4'] = ['baslik' => 'Diğer ulusal hakemli dergide yayımlanmış kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 5];

$maddeler += [
    // ══ 3.3 ÖZGÜN BİLİMSEL KİTAP, KİTAP BÖLÜMÜ VE KİTAP ÇEVİRİSİ ══
    '3.3.1' => ['baslik' => 'BKCI kapsamındaki uluslararası yayınevi tarafından yayımlanan özgün bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası Kitap'], 'puan' => 100],
    '3.3.3' => ['baslik' => 'BKCI kapsamındaki uluslararası yayınevi tarafından yayımlanan özgün bilimsel kitap veya ders kitabı bölümü yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Uluslararası Kitap Bölümü'], 'puan' => 60],
    '3.3.7' => ['baslik' => 'BKCI kapsamındaki uluslararası yayınevi tarafından yayımlanan özgün bilimsel kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Uluslararası Kitap Editörlüğü'], 'puan' => 60],
    '3.3.9' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanan özgün bilimsel kitabın yayımlanmış çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 10],
    '3.3.10' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanan özgün bilimsel kitap bölümünün yayımlanmış çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 5],
    '3.3.11' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanan özgün bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 40],
    '3.3.12' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanan özgün bilimsel ders kitabı yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Ders / Metot Kitabı'], 'puan' => 20],
    '3.3.13' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanan özgün bilimsel kitap bölümü yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap Bölümü'], 'puan' => 10],
    '3.3.15' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanan özgün bilimsel kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 20],

    // ══ 3.4 TEZ DANIŞMANLIKLARI VE JÜRİ ÜYELİKLERİ ══
    '3.4.1' => ['baslik' => 'Tamamlanmış doktora, sanatta yeterlik ya da uzmanlık tezinde asıl danışman', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 20],
    '3.4.2' => ['baslik' => 'Tamamlanmış doktora, sanatta yeterlik ya da uzmanlık tezinde ortak danışman', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 15],
    '3.4.5' => ['baslik' => 'Tamamlanmış yüksek lisans tezinde asıl danışman', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 10],
    '3.4.6' => ['baslik' => 'Tamamlanmış yüksek lisans tezinde ortak danışman', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 8],
    '3.4.7' => ['baslik' => 'Tez izleme komisyonu ya da tez savunma jüri üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 1],

    // ══ 3.6 ULUSLARARASI AR-GE PROJE ÇALIŞMASI ══
    '3.6.1' => ['baslik' => 'AB Çerçeve Programları ya da benzeri uluslararası kurumlarca desteklenen Ar-Ge projesinde yürütücü veya koordinatör', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 150],
    '3.6.2' => ['baslik' => 'AB Çerçeve Programları ya da benzeri uluslararası kurumlarca desteklenen Ar-Ge projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 75],
    '3.6.3' => ['baslik' => 'AB Çerçeve Programları ya da benzeri uluslararası kurumlarca desteklenen Ar-Ge projesinde danışman', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['danisman'], 'puan' => 60],
    '3.6.7' => ['baslik' => 'Diğer uluslararası kuruluşlarca desteklenen Ar-Ge projesinde yürütücü veya koordinatör', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 50],
    '3.6.8' => ['baslik' => 'Diğer uluslararası kuruluşlarca desteklenen Ar-Ge projesinde proje ekibinde yer almak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 30],
    '3.6.9' => ['baslik' => 'Diğer uluslararası kuruluşlarca desteklenen Ar-Ge projesinde danışman', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['danisman'], 'puan' => 20],

    // ══ 3.7 ULUSAL AR-GE PROJE ÇALIŞMASI ══
    '3.7.1' => ['baslik' => 'TÜSEB ya da TÜBİTAK Ar-Ge projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 100],
    '3.7.2' => ['baslik' => 'TÜSEB ya da TÜBİTAK Ar-Ge projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci'], 'puan' => 60],
    '3.7.3' => ['baslik' => 'TÜSEB ya da TÜBİTAK Ar-Ge projesinde danışman', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['danisman'], 'puan' => 30],
    '3.7.4' => ['baslik' => 'TÜSEB ya da TÜBİTAK Ar-Ge projesinde bursiyer', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['bursiyer'], 'puan' => 15],
    '3.7.8' => ['baslik' => 'Bakanlıklar ya da diğer kamu kurumlarınca desteklenen Ar-Ge projesinde sorumlu yürütücü veya koordinatör', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 75],
    '3.7.9' => ['baslik' => 'Bakanlıklar ya da diğer kamu kurumlarınca desteklenen Ar-Ge projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 50],
    '3.7.10' => ['baslik' => 'Bakanlıklar ya da diğer kamu kurumlarınca desteklenen Ar-Ge projesinde danışman', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['danisman'], 'puan' => 30],
    '3.7.11' => ['baslik' => 'Özel sektör, sivil toplum kuruluşu ya da ulusal ajans tarafından desteklenen Ar-Ge projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 25],
    '3.7.12' => ['baslik' => 'Özel sektör, sivil toplum kuruluşu ya da ulusal ajans tarafından desteklenen Ar-Ge projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
    '3.7.15' => ['baslik' => 'BAP destekli bilimsel araştırma projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 40],
    '3.7.16' => ['baslik' => 'BAP destekli bilimsel araştırma projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 25],
    '3.7.17' => ['baslik' => 'TÜBİTAK 2209-A, 2209-B ve benzeri öğrenci projelerinde sonuçlandırılmış projede danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'puan' => 15],

    // ══ 3.8 BİLİMSEL TOPLANTI ══
    '3.8.1' => ['baslik' => 'Hakemli uluslararası bilimsel toplantıda sunulan ve bildiri kitabında yayımlanan tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 15],
    '3.8.2' => ['baslik' => 'Hakemli uluslararası bilimsel toplantıda sunulan özet metin ya da poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 4],
    '3.8.4' => ['baslik' => 'Hakemli ulusal bilimsel toplantıda sunulan ve bildiri kitabında yayımlanan tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 10],
    '3.8.5' => ['baslik' => 'Hakemli ulusal bilimsel toplantıda sunulan özet metin ya da poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 3],

    // ══ 3.9 ANSİKLOPEDİDE BÖLÜM/KONU/MADDE ══
    '3.9.4' => ['baslik' => 'Bilimsel ansiklopedide bölüm, konu ya da madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 4],

    // ══ 3.10 ATIFLAR ══
    '3.10.1' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergilerdeki yayınlarda her bir atıf', 'kategori' => 'atif', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 4],
    '3.10.2' => ['baslik' => 'SCOPUS ya da ESCI kapsamındaki dergilerdeki yayınlarda her bir atıf', 'kategori' => 'atif', 'kaynaklar' => ['ESCI', 'Scopus'], 'puan' => 4],
    '3.10.3' => ['baslik' => 'Uluslararası alan indeksleri kapsamındaki dergilerdeki yayınlarda her bir atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer (Uluslararası)', 'Patent'], 'puan' => 2],
    '3.10.4' => ['baslik' => 'TR Dizin tarafından indekslenen hakemli dergilerdeki yayınlarda her bir atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
    '3.10.6' => ['baslik' => 'Uluslararası yayınevleri tarafından yayımlanan kitaplarda her bir atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],

    // ══ 3.11 BİLİMSEL TANINIRLIK ══
    '3.11.6' => ['baslik' => 'Ulusal ya da uluslararası bilimsel toplantıda davetli konuşmacı, moderatör veya oturum başkanı', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 5],
    // Kaynak 3.11.4 uluslararası 5, 3.11.8 ULUSAL 2 diyor; iki kapsam tek satırda birleşmişti.
    '3.11.6k' => ['baslik' => 'Uluslararası bilimsel ya da sanatsal toplantıda oturum başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Uluslararası)'], 'puan' => 5],
    '3.11.6k-ulusal' => ['baslik' => 'Ulusal bilimsel ya da sanatsal toplantıda oturum başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Ulusal)'], 'puan' => 2],

    // ══ 3.12 SANAT / TASARIM, MİMARİ PROJE VE PLANLAR ══
    '3.12.1' => ['baslik' => 'Uluslararası mimari proje, kentsel tasarım projesi ya da imar planı çalışmalarında proje müellifi olmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif'], 'puan' => 20],
    '3.12.2' => ['baslik' => 'Uluslararası mimari proje, kentsel tasarım projesi ya da imar planı çalışmalarında proje ekibinde yer almak veya danışmanlık yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman'], 'puan' => 12],
    '3.12.14' => ['baslik' => 'Ulusal sanatsal tasarım', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım'], 'puan' => 4],
    '3.12.18' => ['baslik' => 'Ulusal faydalı obje (TSE veya TPE tarafından tescillenmiş)', 'kategori' => 'patent', 'kaynaklar' => ['Yazılım'], 'puan' => 16],

    // ══ 3.13 BİLİMSEL DERGİLERDEKİ GÖREVLER ══
    '3.13.1' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki uluslararası hakemli dergide baş editör', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 100],
    '3.13.4' => ['baslik' => 'SCOPUS ya da ESCI kapsamındaki uluslararası hakemli dergide baş editör', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 30],
    '3.13.11' => ['baslik' => 'Dergide editör kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 3],
    '3.13.12' => ['baslik' => 'Diğer uluslararası hakemli dergide baş editör ya da özel sayı editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi (Uluslararası)'], 'puan' => 2],
    '3.13.13' => ['baslik' => 'TR Dizin kapsamındaki ulusal hakemli dergide baş editör', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 20],

    // ══ 3.14 BİLİMSEL HAKEMLİKLER ══
    '3.14.4' => ['baslik' => 'Hakemli dergide ya da bilimsel araştırma projesi için hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 5],

    // ══ 3.15 BİLİMSEL ÖDÜLLER ══
    '3.15.4' => ['baslik' => 'Uluslararası kurum, organizasyon, kongre veya festival kurullarınca bilimsel, sosyal, kültürel ya da sanatsal çalışmalara verilen ödül', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü'], 'puan' => 15],
    '3.15.5' => ['baslik' => 'Tamamlanan bir çalışmaya tanınmış ulusal bir organizasyon tarafından düzenli olarak verilen ödül', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 10],
    '3.15.7' => ['baslik' => 'TÜBA ya da TÜBİTAK tarafından bilimsel çalışmaları nedeniyle verilen bilim ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'YÖK Ödülü'], 'puan' => 100],
    '3.15.8' => ['baslik' => 'TÜBA GEBİP ya da TÜBİTAK TWAS teşvik ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 200],
    '3.15.9' => ['baslik' => 'TÜBİTAK Ufuk Avrupa ve ERC programı eşik üstü ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ufuk Avrupa / ERC Ödülü'], 'puan' => 150],
    '3.15.10' => ['baslik' => 'Jürili ve sürekli düzenlenen güzel sanatlar etkinliklerinde ya da yarışmalarında eserlere verilen derece ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 20],
    '3.15.11' => ['baslik' => 'Lisansüstü eğitim ya da bilimsel araştırma amacıyla alınan burs', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 5],

    // ══ 4.1 PATENT ══
    '4.1.3' => ['baslik' => 'Uluslararası patent tescili', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 45],
    '4.1.10' => ['baslik' => 'Telif hakkıyla korunan uluslararası fikri mülkiyet (materyal, bitki) tescili', 'kategori' => 'patent', 'kaynaklar' => ['Islahçı Hakkı / Çeşit Tescili'], 'puan' => 10],
    '4.1.13' => ['baslik' => 'Ulusal patent tescili', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 15],
    '4.1.14' => ['baslik' => 'Ulusal faydalı model tescili', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 15],
    '4.1.16' => ['baslik' => 'Ulusal endüstriyel tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım'], 'puan' => 15],

    // ══ 4.3 BİLİMSEL DANIŞMANLIKLAR VE KURUL ÜYELİKLERİ ══
    '4.3.13' => ['baslik' => 'Kamu kurumları, meslek kuruluşları ya da sivil toplum kuruluşları için bilimsel danışmanlık, kurul veya jüri üyeliği', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı', 'Topluma Hizmet Projesi'], 'puan' => 3],

    // ══ 4.5 ve 4.9 GÖRSEL ETKİNLİKLER ══
    '4.9.1' => ['baslik' => 'Sinema, belgesel, kısa metrajlı kurmaca ya da reklam filminde yönetmenlik, yapımcılık, kurgu veya senaryo yazarlığı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)', 'Yönetmenlik (Sahne/Ekran)'], 'puan' => 6],
    '4.9.5' => ['baslik' => 'Yazılı, görsel ve işitsel medyada katılımcı, konuşmacı, konuk ya da yazar olmak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Bilim İletişimi / Popüler Yayın'], 'puan' => 1],
];

// ══ 4.6 ULUSLARARASI ve 4.10 ULUSAL SANATSAL ETKİNLİKLER ══
$maddeler += [
    '4.6.1.1' => ['baslik' => 'Uluslararası karma konserde çalgı ya da vokal icracılığı, oda müziği grup üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Uluslararası)', 'Solistlik (Uluslararası)', 'Başkemancılık (Uluslararası)'], 'puan' => 25],
    '4.6.1.2' => ['baslik' => 'Uluslararası resital (solo) çalgı ya da vokal konser', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Uluslararası)', 'Şan Resitali (Uluslararası)', 'Oratoryo/Kantat Solistliği (Uluslararası)'], 'puan' => 100],
    '4.6.2.3' => ['baslik' => 'Uluslararası opera, senfoni, bale ya da karma konserde şeflik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera Şefliği (Uluslararası)', 'Orkestra Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Uluslararası)', 'Koro Şefliği (Uluslararası)', 'Grup Şefliği (Uluslararası)'], 'puan' => 25],
    '4.6.3.2' => ['baslik' => 'Uluslararası bale, modern dans ya da halk dansları temsilinde başrol, solist rol veya dansçılık', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bale Başrol (Uluslararası)', 'Bale Solist Rol (Uluslararası)', 'Corps de Ballet (Uluslararası)', 'Dansçı / Performans İcracısı (Uluslararası)'], 'puan' => 40],
    '4.6.4.2' => ['baslik' => 'Uluslararası bir oyunda birinci ya da ikinci derece rol', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera Birinci Rol (Uluslararası)', 'Opera İkinci Rol (Uluslararası)'], 'puan' => 20],
    '4.6.4.6' => ['baslik' => 'Uluslararası bir oyunda rejisörlük ya da rejisör yardımcılığı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisörlük (Uluslararası)', 'Rejisör Yardımcılığı (Uluslararası)', 'Tüm Perde Koreograflığı (Uluslararası)', 'Bölüm Koreograflığı (Uluslararası)', 'Bale/Dans Koreograflığı (Uluslararası)', 'Sahneleme/Repetitörlük — Tüm Perde (Uluslararası)', 'Sahneleme/Repetitörlük — Bölüm (Uluslararası)'], 'puan' => 20],
    '4.6.6.1' => ['baslik' => 'Yurt dışında özgün yapıt ve eserlerle kişisel sergi veya gösteri gerçekleştirmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)'], 'puan' => 100],
    '4.6.6.2' => ['baslik' => 'Uluslararası jürili, küratörlü ya da davetli karma etkinliklere özgün eseriyle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Karma Sergi (Uluslararası)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 20],
    '4.6.6.4' => ['baslik' => 'Sanat eserinin uluslararası koleksiyonlarda, tanınmış müze ve galerilerde daimî olarak yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Haber Olması (Uluslararası)'], 'puan' => 40],
    '4.6.6.6' => ['baslik' => 'Uluslararası karma sergi ve toplu etkinliklere özgün eseriyle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Masterclass (Uluslararası)', 'Eğitici Konser Programı (Uluslararası)'], 'puan' => 20],
    '4.10.1.1' => ['baslik' => 'Ulusal karma konserde çalgı ya da vokal icracılığı, oda müziği grup üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Ulusal)', 'Solistlik (Ulusal)', 'Başkemancılık (Ulusal)', 'Orkestra / Koro Üyeliği'], 'puan' => 15],
    '4.10.1.2' => ['baslik' => 'Ulusal resital (solo) çalgı ya da vokal konser', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Ulusal)', 'Şan Resitali (Ulusal)', 'Oratoryo/Kantat Solistliği (Ulusal)'], 'puan' => 70],
    '4.10.2.3' => ['baslik' => 'Ulusal opera, senfoni, bale ya da karma konserde şeflik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera Şefliği (Ulusal)', 'Orkestra Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Ulusal)', 'Koro Şefliği (Ulusal)', 'Grup Şefliği (Ulusal)'], 'puan' => 15],
    '4.10.3.2' => ['baslik' => 'Ulusal bale, modern dans ya da halk dansları temsilinde başrol, solist rol veya dansçılık', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bale Başrol (Ulusal)', 'Bale Solist Rol (Ulusal)', 'Corps de Ballet (Ulusal)', 'Dansçı / Performans İcracısı (Ulusal)'], 'puan' => 20],
    '4.10.4.2' => ['baslik' => 'Ulusal bir oyunda birinci ya da ikinci derece rol', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera Birinci Rol (Ulusal)', 'Opera İkinci Rol (Ulusal)'], 'puan' => 10],
    '4.10.4.6' => ['baslik' => 'Ulusal bir oyunda rejisörlük ya da rejisör yardımcılığı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Rejisör Yardımcılığı (Ulusal)', 'Rejisör Yardımcılığı (Konservatuvar)', 'Tüm Perde Koreograflığı (Ulusal)', 'Bölüm Koreograflığı (Ulusal)', 'Bale/Dans Koreograflığı (Ulusal)', 'Koreografi', 'Sahneleme/Repetitörlük — Tüm Perde (Ulusal)', 'Sahneleme/Repetitörlük — Bölüm (Ulusal)'], 'puan' => 10],
    '4.10.5.1' => ['baslik' => 'Ulusal sahnelenmiş bir oyunda sahne, hareket ya da dramaturgi tasarımı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne Tasarımı (Dekor, Kostüm, Işık)'], 'puan' => 20],
    '4.10.5.7' => ['baslik' => 'Ulusal sergilenmiş gösteri ya da oyunda müzik planlayıcısı veya uygulayıcısı olmak; özgün müzik eseri üretmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne/Ekran Müziği', 'Opera/Bale Kompozisyonu', 'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Küçük Ölçekli Orkestra Eseri', 'Orkestralı Sahne Eseri', 'Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi'], 'puan' => 25],
    '4.10.6.1' => ['baslik' => 'Yurt içinde özgün yapıt ve eserlerle kişisel sergi veya gösteri gerçekleştirmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 80],
    '4.10.6.2' => ['baslik' => 'Ulusal jürili, küratörlü ya da davetli karma etkinliklere özgün eseriyle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Elektronik Karma Sergi (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 10],
    '4.10.6.4' => ['baslik' => 'Sanat eserinin ulusal koleksiyonlarda, tanınmış müze ve galerilerde daimî olarak yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Haber Olması (Ulusal)', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'], 'puan' => 20],
    '4.10.6.6' => ['baslik' => 'Ulusal karma sergi ve toplu etkinliklere özgün eseriyle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Jürisiz, Ulusal)', 'Masterclass (Ulusal)', 'Eğitici Konser Programı (Ulusal)', 'Müzikoloji Atölyesi', 'Eğitim Amaçlı Sanat Etkinliği', 'Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)'], 'puan' => 10],
    '4.11.1' => ['baslik' => 'Bilim, sanat, festival, fuar, eğitim ve kültür kuruluşlarınca yapılan yarışmalarda jüri üyeliği yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 10],
    '4.11.7' => ['baslik' => 'Sanat alanındaki eserlerin yayın organlarında yer alması ya da gösterime, dinletime girmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)', 'Karma Albüm / CD-DVD Katkısı', 'Eğitim Müziği Albümü'], 'puan' => 6],
    '4.7.3' => ['baslik' => 'Uluslararası spor federasyonunun yönetim, teknik, eğitim ya da hakem kurulunda görev', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Spor Federasyonu Kurul Üyeliği (Uluslararası)'], 'puan' => 12],
    '4.12.5' => ['baslik' => 'Ulusal spor federasyonunun yönetim, teknik, eğitim ya da hakem kurulunda görev', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Spor Federasyonu Kurul Üyeliği (Ulusal)'], 'puan' => 3],
];

$kodlar = fn (string $onek): array => array_values(array_filter(
    array_keys($maddeler),
    fn (string $kod): bool => str_starts_with($kod, $onek)
));

$SANATSAL = array_values(array_filter(
    array_keys($maddeler),
    fn (string $kod): bool => str_starts_with($kod, '4.6.') || str_starts_with($kod, '4.10.')
        || str_starts_with($kod, '4.11.') || str_starts_with($kod, '3.12.')
));

return [
    'kapsam_notu' => 'Puanlar Ardahan Üniversitesi Öğretim Üyeliğine Yükseltilme ve Atanma '
        .'Kriterleri Yönergesinin EK Faaliyet Puanlama Tablosundan (16.07.2026). '
        .'Ortak çalışmalarda puan MADDE 67\'nin yazar sayısı × sıra matrisine göre hesaplanıyor: '
        .'iki yazarlı eserde birinci yazar %90, ikinci %80; üç yazarlıda %80, %70, %60; dört '
        .'yazarlıda %70, %60, %50, %40; beş ve daha fazla yazarlıda %60\'tan %30\'a iner. '
        .'Sorumlu yazar MADDE 68 uyarınca birinci yazar sayılıyor. Yazar listesini boş '
        .'bırakırsanız çarpan uygulanmaz ve puanınız olduğundan yüksek görünür. '
        .'MADDE 69 kitap, kitap bölümü ve bildiride puanın yazarlar arasında EŞİT bölünmesini '
        .'istiyor; motorda cetvel başına tek yazar matrisi tanımlanabildiği için bu kalemler de '
        .'MADDE 67\'nin matrisiyle hesaplanıyor. Çok yazarlı kitap ve bildirilerde ilk sıradaki '
        .'yazarın puanı bu yüzden OLDUĞUNDAN YÜKSEK görünür (iki yazarlı kitapta %50 yerine '
        .'%90). Matris, yönergenin bütün puan barajlarının yazıldığı MAKALE kalemi için doğru. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: ESCI dergileri çeyrekliğe göre 25 ile '
        .'16 puan arasında değişiyor ama sözlük ESCI ile SCOPUS\'u ayırmadığı için en düşük '
        .'değer uygulanıyor; patent tescilinde incelemeli ve incelemesiz ayrımı kayıtta '
        .'olmadığı için düşük satır uygulanıyor (uluslararası 200 yerine 45, ulusal 25 yerine '
        .'15); h-indeksi puanı (h × 2), burslar, yurt dışı hareketlilik, arkeolojik kazı, '
        .'bilimsel toplantı düzenleme kurulları, spor ve sosyal organizasyonlar, bilirkişilik ve '
        .'girişimcilik satırları girilemedi; patent BAŞVURUSU satırları tescilden ayrılamadığı '
        .'için girilmedi. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünür: bir kitapta en fazla iki bölümün '
        .'sayılması (MADDE 32), aynı toplantıda en fazla iki bildiri (MADDE 34) ve yönetimsel '
        .'faaliyetlerin yıllık hesaplanması (MADDE 65) kuralları uygulanamıyor.',

    // MADDE 67: yazar sayısı × sıra matrisi. MADDE 68: sorumlu yazar birinci
    // yazar sayılır, bu yüzden 'baslica' ile 'ilk' aynı satırı paylaşıyor.
    // Altıncı ve sonraki sıradaki yazarlar beşinci yazarın yüzdesini alır.
    'yazar_katsayisi' => [
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.80, 4 => 0.70], 'sonrasi' => 0.60],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.80, 4 => 0.70], 'sonrasi' => 0.60],
            'yazar_2' => ['kademeler' => [2 => 0.80, 3 => 0.70, 4 => 0.60], 'sonrasi' => 0.50],
            'yazar_3' => ['kademeler' => [3 => 0.60, 4 => 0.50], 'sonrasi' => 0.40],
            'yazar_4' => ['kademeler' => [4 => 0.40], 'sonrasi' => 0.30],
            'yazar_5' => ['sonrasi' => 0.30],
            'yazar_6' => ['sonrasi' => 0.30],
            'ortak' => ['sonrasi' => 0.30],
        ],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        'KURUMSAL-KATKI' => $kodlar('1.1.'),
        'EGITIME-KATKI' => $kodlar('2.1.'),
        '3.1' => $kodlar('3.1.'),
        '3.2' => $kodlar('3.2.'),
        '3.1-3.2' => [...$kodlar('3.1.'), ...$kodlar('3.2.')],
        '3.1-3.2-3.3' => [...$kodlar('3.1.'), ...$kodlar('3.2.'), ...$kodlar('3.3.')],
        '3.1.1-3.1.3' => ['3.1.1.a', '3.1.1.b', '3.1.2.a', '3.1.2.b', '3.1.3.a', '3.1.3.b'],
        '3.1.1-3.1.4' => ['3.1.1.a', '3.1.1.b', '3.1.2.a', '3.1.2.b', '3.1.3.a', '3.1.3.b',
            '3.1.4.a', '3.1.4.b'],
        // 3.1.1-3.1.11: SCI-SSCI-AHCI, ESCI ve SCOPUS dergilerindeki bütün
        // makale satırları (uluslararası alan indeksleri hariç).
        '3.1.1-3.1.11' => ['3.1.1.a', '3.1.1.b', '3.1.2.a', '3.1.2.b', '3.1.3.a', '3.1.3.b',
            '3.1.4.a', '3.1.4.b', '3.1.5', '3.1.9.a', '3.1.9.b', '3.1.11'],
        '3.2.1' => ['3.2.1.a', '3.2.1.b'],
        '3.3' => $kodlar('3.3.'),
        '3.3.1-3.3.4-3.3.11' => ['3.3.1', '3.3.11'],
        '3.4' => $kodlar('3.4.'),
        '3.6' => $kodlar('3.6.'),
        '3.7' => $kodlar('3.7.'),
        '3.7-YURUTUCU' => ['3.6.1', '3.6.7', '3.7.1', '3.7.8', '3.7.11', '3.7.15'],
        '3.8' => $kodlar('3.8.'),
        '3.8.1-3.8.2' => ['3.8.1', '3.8.2'],
        '3.9' => $kodlar('3.9.'),
        '3.10' => $kodlar('3.10.'),
        '3.11' => $kodlar('3.11.'),
        '3.14' => $kodlar('3.14.'),
        '3.15' => $kodlar('3.15.'),
        'SANATSAL' => $SANATSAL,
        // Güzel Sanatlarda "Kurumsal Katkı ve Sanatsal Faaliyetler" kümesi.
        'KURUMSAL-VE-SANATSAL' => [...$kodlar('1.1.'), ...$SANATSAL],
        // Sağlık Bilimlerinin yeniden atama ve profesörlük kümeleri.
        'SAGLIK-YENIDEN' => [...$kodlar('3.1.'), ...$kodlar('3.2.'), ...$kodlar('3.3.'),
            ...$kodlar('3.6.'), ...$kodlar('3.7.'), ...$kodlar('3.8.'), ...$kodlar('3.11.'),
            ...$kodlar('3.14.'), ...$kodlar('3.15.')],
        'SAGLIK-PROF' => [...$kodlar('3.3.'), ...$kodlar('3.4.'), ...$kodlar('3.6.'),
            ...$kodlar('3.7.'), ...$kodlar('3.8.'), ...$kodlar('3.11.'), ...$kodlar('3.14.'),
            ...$kodlar('3.15.')],
        // Güzel Sanatlarda profesörlüğün plastik/görsel sanatlar koşulu.
        'KISISEL-SERGI' => ['4.6.6.1', '4.10.6.1'],
    ],

    /*
     * Yönergenin azami puanları İKİ DÜZEYDE: başlık ("3.4 TEZ DANIŞMANLIKLARI
     * … Bu başlıktan azami 30 puan alınabilir") ve SATIR ("* Azami N puan
     * alınabilir." notu tek bir kodun altında). Başlık düzeyindekiler
     * girilmişti; satır düzeyindekiler 01.09.2026'ya kadar girilmemişti ve
     * tavansız satır doğrudan fazla saydırır (§0).
     *
     * Kaynakta otuz dokuz satır tavanı var; onunun cetvelde karşılığı
     * bulunuyor, kalan yirmi dokuzun satırı girilmemiş.
     *
     * ÜÇ SATIR KAYNAKTA BİRDEN ÇOK SATIRIN BİRLEŞİMİ: 3.11.6 (davetli
     * konuşmacı + moderatör + oturum başkanı, kaynakta 3.11.6-3.11.9),
     * 3.13.11 (dergi türüne bakmadan editör kurulu üyeliği) ve 3.13.12
     * (baş editörlük + özel sayı editörlüğü). Birleşik satırda hangi alt
     * satırın tavanının geçerli olduğu bilinemediği için o alt satırın
     * tavanı yazıldı; aday bu üç kalemde puanını olduğundan DÜŞÜK görebilir.
     * Yön §0'a uygun, alternatifi (tavansız bırakmak) fazla saydırırdı.
     */
    'grup_tavanlari' => [
        // Başlık düzeyi.
        'KURUMSAL-KATKI' => 20,
        'EGITIME-KATKI' => 20,
        '3.4' => 30,
        '3.8' => 40,
        '3.9' => 45,
        '3.10' => 60,
        '3.14' => 50,

        // Satır düzeyi ("* Azami N puan alınabilir.").
        '3.3.12' => 40,
        '3.3.13' => 50,
        '3.3.15' => 40,
        '3.11.6' => 10,
        '3.13.11' => 6,
        '3.13.12' => 4,
        '4.1.13' => 30,
        '4.1.14' => 45,
        '4.1.16' => 45,
        '4.9.5' => 3,
    ],
];
