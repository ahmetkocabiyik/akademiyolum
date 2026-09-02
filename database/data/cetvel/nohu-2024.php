<?php

use App\Enums\Kategori;

/**
 * NİĞDE ÖMER HALİSDEMİR ÜNİVERSİTESİ — Puanlama Tablosu
 * Kaynak: pdf/17537005372.nigdeomerhalisdemiruniverstesi.pdf
 * (12 sayfa; değişiklikler 09.02.2024-2024/29 ve 27.07.2023-2023/211
 * Senato kararları)
 *
 * Madde kodları tablonun kendi numaralandırması (1a, 9c, 12h …).
 * Puanlama Tablosu yalnız DOKTOR ÖĞRETİM ÜYELİĞİNE YENİDEN ATANMADA
 * kullanılıyor; ilk atanma, doçentlik ve profesörlük koşulları puan
 * değil sayı ve belge şartı.
 *
 * ── TEZDEN ÜRETİLMİŞ YAYIN AYRIMI YAPILAMIYOR ──
 * Tablonun 1., 2. ve 4. maddeleri "adayın hazırladığı lisansüstü
 * tezlerden ÜRETİLMEMİŞ olmak kaydıyla" diyor; 3. madde ise tezden
 * üretilmiş yayınlara ayrı ve daha düşük puanlar veriyor (SCI makalesi
 * 20 yerine 10, uluslararası kitap 20 yerine 15). Kayıt bir yayının
 * tezden üretilip üretilmediğini taşımadığı için §0 uyarınca YÜKSEK
 * satırlar (tezden üretilmemiş) kullanıldı ve 3. madde girilmedi.
 * Doktora tezinizden üretilmiş yayınlarınız varsa puanınız OLDUĞUNDAN
 * YÜKSEK görünür.
 *
 * ── AYNI ETİKETE DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   1.d (hiçbir endekste taranmayan uluslararası hakemli dergi, 6) ile
 *       1.c (uluslararası hakemli dergi, 10) → 'Diğer Uluslararası
 *       İndeks' etiketi 1.c'den, ayrı bir 1.d satırı yok.
 *   4.b uluslararası kitap editörlüğü ile bölüm yazarlığı aynı satırda
 *       (15); 4.d ulusal karşılığı (10).
 *   9. maddede TÜBİTAK yürütücülüğü (15) ile ikili iş birliği
 *       yürütücülüğü (15) aynı; TEYDEB danışmanlığı (8) ayrı satır.
 *   12. maddede sanat etkinliklerinin uluslararası ve ulusal ayrımı yok;
 *       etiketler kişisel (20), jürili karma (10) ve yayında yer alma
 *       (5) satırlarına dağıtıldı.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   3. madde (lisansüstü tezlerden üretilmiş yayınlar) — yukarıdaki
 *       nedenle.
 *   5. madde (Mimarlık temel alanına özgü yarışma, uygulama projesi ve
 *       yazılım; 15 puan) — 'Yarışma Derecesi / Mansiyon' ve 'Yazılım'
 *       etiketleriyle karşılandı, uygulama projesi hakkında yazılan
 *       makale satırı girilmedi.
 *   12.l (müzik teknolojisi özgün yapım sunuşu) ve 12.j-k (konser
 *       kaydı, şeflik) kısmen; 13. maddenin bazı görevleri sözlükte
 *       karşılıksız.
 *
 * ── MOTORUN KARŞILAYAMADIĞI SINIRLAR ──
 * 12. madde "en fazla 10 puan" ve 13. madde "en fazla 10 puan" tavan
 * olarak yazıldı. Madde 6(e)'nin "bir akademik faaliyet en yüksek
 * puanlandığı maddeden değerlendirilir" kuralı motorun zaten yaptığı
 * şey. 7. maddenin "metin içindeki atıf sayısına bakılmaksızın" kuralı
 * uygulanmıyor.
 *
 * Yönerge: yonerge/nohu.php
 */
$SCI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];
$TAM = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];

$sanatKisisel = ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Ulusal)',
    'Elektronik Kişisel Sergi (Uluslararası)', 'Elektronik Kişisel Sergi (Ulusal)',
    'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)',
    'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)',
    'Resital (Uluslararası)', 'Resital (Ulusal)', 'Solistlik (Uluslararası)', 'Solistlik (Ulusal)'];
$sanatKarma = ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Ulusal)',
    'Elektronik Karma Sergi (Uluslararası)', 'Elektronik Karma Sergi (Ulusal)',
    'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Jürisiz, Ulusal)',
    'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)',
    'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)'];
$sanatYayin = ['Eserin Haber Olması (Uluslararası)', 'Eserin Haber Olması (Ulusal)',
    'Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)'];
$sanatSatin = ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)',
    'Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt İçi)',
    'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)',
    'Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip'];
$sanatJuri = ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)',
    'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'];
$sanatBeste = ['Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Opera/Bale Kompozisyonu',
    'Orkestralı Sahne Eseri', 'Küçük Ölçekli Orkestra Eseri', 'Oda/Koro Müziği Eseri (≥15 dk)',
    'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)',
    'Elektronik Müzik Eseri (<15 dk)', 'Sahne/Ekran Müziği', 'Özgün Eser / Beste / Tasarım'];
$sanatKonser = ['Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)', 'Karma Albüm / CD-DVD Katkısı',
    'Orkestra Şefliği (Uluslararası)', 'Orkestra Şefliği (Ulusal)', 'Koro Şefliği (Uluslararası)',
    'Koro Şefliği (Ulusal)', 'Grup Şefliği (Uluslararası)', 'Grup Şefliği (Ulusal)'];

$sanatKullanilan = array_merge($sanatKisisel, $sanatKarma, $sanatYayin, $sanatSatin,
    $sanatJuri, $sanatBeste, $sanatKonser);
$sanatKalan = array_values(array_diff(Kategori::SanatselEtkinlik->kaynaklar(), $sanatKullanilan));

return [
    'kapsam_notu' => 'Puanlar Niğde Ömer Halisdemir Üniversitesi Öğretim Üyeliğine Yükseltilme '
        .'ve Atanma Yönergesinin Puanlama Tablosundan. Bu tablo YALNIZCA doktor öğretim '
        .'üyeliğine yeniden atanmada kullanılıyor; ilk atanma, doçentlik ve profesörlük '
        .'koşulları puan değil sayı ve belge şartı. Yazar çarpanı tablonun dipnotundan: tek '
        .'yazarlıda tam puan; iki yazarlıda başlıca yazar %80, ikinci yazar %50; üç ve daha '
        .'fazla yazarlıda başlıca yazar toplam puanın yarısını alır, diğerleri kalan yarıyı eşit '
        .'paylaşır; başlıca yazar belirtilmemişse puan eşit bölünür. Yazar listesini boş '
        .'bırakırsanız çarpan hiç uygulanmaz ve puanınız olduğundan YÜKSEK görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünür: tablonun 3. maddesi lisansüstü '
        .'tezlerden ÜRETİLMİŞ yayınlara daha düşük puan veriyor (SCI makalesi 20 yerine 10, '
        .'uluslararası kitap 20 yerine 15); kayıt bir yayının tezden üretilip üretilmediğini '
        .'taşımadığı için hepsi yüksek satırdan sayılıyor. Ayrıca dipnotun "diğer yayınlarda '
        .'(bildiri, kitap, kitap bölümü) toplam puan yazarlar arasında eşit bölünür" kuralı '
        .'yerine makale çarpanı uygulanıyor; çok yazarlı kitap ve bildirilerde puanınız birkaç '
        .'puan fazla görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: 1.d satırı (hiçbir endekste '
        .'taranmayan uluslararası hakemli dergi, 6 puan) ayrı girilmedi; 12. maddenin müzik '
        .'teknolojisi ve konser satırları ile 13. maddenin bazı idari görevleri sözlükte '
        .'karşılıksız.',

    // Puanlama Tablosu dipnotu: ortak çalışmalarda puan dağılımı.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'proje', 'patent', 'editorluk', 'tez_danismanligi', 'egitim_ogretim',
            'odul', 'idari_gorev', 'toplumsal_katki', 'diger', 'sanatsal_etkinlik'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.80], 'sonrasi' => 0.50],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.80], 'sonrasi' => 0.50],
            'yazar_2' => ['kademeler' => [2 => 0.50], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
            'yazar_3' => ['bol' => ['pay' => 0.5, 'eksi' => 1]],
            'yazar_4' => ['bol' => ['pay' => 0.5, 'eksi' => 1]],
            'yazar_5' => ['bol' => ['pay' => 0.5, 'eksi' => 1]],
            'yazar_6' => ['bol' => ['pay' => 0.5, 'eksi' => 1]],
            'ortak' => ['bol' => ['pay' => 1.0]],
        ],
    ],

    'maddeler' => [
        // ══ 1. ULUSLARARASI MAKALE ══
        '1a' => ['baslik' => 'SSCI, SCI, SCI-Expanded ya da AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => $TAM, 'puan' => 20],
        '1b' => ['baslik' => 'ÜAK tarafından belirlenen uluslararası alan endekslerinde taranan dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $TAM, 'puan' => 15],
        '1c' => ['baslik' => 'Uluslararası hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $TAM, 'puan' => 10],
        '1e' => ['baslik' => 'SSCI, SCI, SCI-Expanded ya da AHCI dergisinde vaka takdimi, kitap kritiği makalesi veya benzeri kısa çalışma', 'kategori' => 'makale', 'kaynaklar' => [...$SCI, 'ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 5],

        // ══ 2. ULUSAL MAKALE ══
        '2a' => ['baslik' => 'ULAKBİM tarafından taranan ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 10],
        '2b' => ['baslik' => 'Diğer ulusal hakemli dergilerde yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 5],

        // ══ 4. KİTAP ══
        '4a' => ['baslik' => 'Uluslararası yayınevleri tarafından yayımlanmış kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
        '4b' => ['baslik' => 'Uluslararası yayınevleri tarafından yayımlanmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 15],
        '4b-ed' => ['baslik' => 'Uluslararası yayınevleri tarafından yayımlanmış kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 15],
        '4c' => ['baslik' => 'Ulusal yayınevleri tarafından yayımlanmış kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı', 'Çeviri Kitap'], 'puan' => 15],
        '4d' => ['baslik' => 'Ulusal yayınevleri tarafından yayımlanmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi', 'Çeviri Kitap Bölümü'], 'puan' => 10],
        '4d-ed' => ['baslik' => 'Ulusal yayınevleri tarafından yayımlanmış kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 10],

        // ══ 5. YARIŞMA, UYGULAMA VE YAZILIM (Mimarlık) ══
        '5a' => ['baslik' => 'Mimarlık temel alanıyla ilgili yarışmalarda derece ya da mansiyon almak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 15],
        '5c' => ['baslik' => 'Proje ve yapım yönetimi, tasarımı ya da planlama alanlarında yazılım üreticisi olmak', 'kategori' => 'patent', 'kaynaklar' => ['Yazılım', 'Endüstriyel Tasarım', 'Faydalı Model', 'Islahçı Hakkı / Çeşit Tescili', 'Ticarileştirme'], 'puan' => 15],

        // ══ 6. PATENT ══
        '6a' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
        '6b' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 10],

        // ══ 7. ATIFLAR ══
        '7a' => ['baslik' => 'SCI, SCI-Expanded, SSCI ve AHCI dergilerinde ya da uluslararası yayınevi kitaplarında eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 4],
        '7b' => ['baslik' => 'Diğer endeksli dergilerde ya da uluslararası kitap bölümlerinde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 3],
        '7c' => ['baslik' => 'Ulusal hakemli dergilerde ya da ulusal yayınevi kitaplarında eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 2],

        // ══ 8. LİSANSÜSTÜ TEZ DANIŞMANLIĞI ══
        '8a' => ['baslik' => 'Danışmanlığınızda tamamlanan doktora tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 4],
        '8b' => ['baslik' => 'Danışmanlığınızda tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'puan' => 2],

        // ══ 9. BİLİMSEL ARAŞTIRMA PROJESİ ══
        '9a' => ['baslik' => 'Uluslararası bilimi destekleme kuruluşlarınca desteklenen projede koordinatör ya da baş araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 20],
        '9b' => ['baslik' => 'Uluslararası bilimi destekleme kuruluşlarınca desteklenen projede ortak araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],
        '9c' => ['baslik' => 'TÜBİTAK tarafından desteklenen araştırma projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 15],
        '9d' => ['baslik' => 'TÜBİTAK tarafından desteklenen araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 10],
        '9e' => ['baslik' => 'TÜBİTAK TEYDEB projesinde danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['danisman'], 'puan' => 8],
        '9h' => ['baslik' => 'Üniversiteler dışındaki kamu kurumlarıyla yürütülen bilimsel araştırma projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'puan' => 6],
        '9i' => ['baslik' => 'Üniversitenin Bilimsel Araştırma Projeleri birimince desteklenen projede yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 5],
        '9j' => ['baslik' => 'Üniversitenin Bilimsel Araştırma Projeleri birimince desteklenen projede araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 3],
        '9k' => ['baslik' => 'Özel sektör ya da sivil toplum kuruluşlarıyla yürütülen araştırma projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 5],
        '9l' => ['baslik' => 'Özel sektör ya da sivil toplum kuruluşlarıyla yürütülen projede danışman veya araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 3],

        // ══ 10. BİLİMSEL TOPLANTI FAALİYETLERİ ══
        '10a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan, tam metni bildiri kitapçığında yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin', 'Davetli Konuşmacı'], 'puan' => 5],
        '10b' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan poster ya da özeti yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 3],
        '10c' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan, tam metni yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 3],
        '10d' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan poster ya da özeti yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 2],

        // ══ 11. EĞİTİM-ÖĞRETİM FAALİYETİ ══
        '11a' => ['baslik' => 'Bir dönem yüksek lisans ya da doktora dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
        '11b' => ['baslik' => 'Bir dönem ön lisans ya da lisans dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 2],

        // ══ 12. SANAT DALLARINDAKİ ETKİNLİKLER ══
        '12a' => ['baslik' => 'Özgün sanat eserleri, tasarımlar ya da yorum çalışmalarıyla kişisel etkinlikte bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKisisel, 'puan' => 20],
        '12b' => ['baslik' => 'Özgün sanat eserleri, tasarımlar ya da yorum çalışmalarıyla jürili karma sanat ve tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => [...$sanatKarma, ...$sanatKalan], 'puan' => 10],
        '12c' => ['baslik' => 'Sanat eserlerinizin yayınlarda yer alması (kitap, katalog, dergi, belgesel film)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatYayin, 'puan' => 5],
        '12d' => ['baslik' => 'Özgün sanat eserlerinizin, tasarımlarınızın ya da yorum çalışmalarınızın satın alınması veya uygulanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatSatin, 'puan' => 10],
        '12e' => ['baslik' => 'Alanınızla ilgili jürilerde görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatJuri, 'puan' => 5],
        '12i' => ['baslik' => 'Solo çalgı, oda müziği, orkestra, sahne müziği ya da elektronik müzik türlerinde özgün eser vermiş olmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatBeste, 'puan' => 10],
        '12j' => ['baslik' => 'Alanınızda en az bir saatlik solo veya karma konser kaydı, orkestra ya da koro konserinde şeflik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKonser, 'puan' => 10],
        '12f' => ['baslik' => 'Sanatsal etkinlikleri düzenleyenler listesinde yer almak ya da sanat dergilerinde editörlük', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 5],
        '12g' => ['baslik' => 'Sanat ve tasarım dergilerinde editörlük veya yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi', 'TR Dizin Dergi', 'Diğer Hakemli Dergi', 'Yayın Kurulu Üyeliği', 'Hakemlik'], 'puan' => 5],

        // ══ 13. İDARİ GÖREVLER ══
        '13a' => ['baslik' => 'Enstitü, konservatuvar, yüksekokul ya da meslek yüksekokulu müdürlüğü, başhekimlik', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü'], 'puan' => 6],
        '13b' => ['baslik' => 'Dekan yardımcılığı, müdür yardımcılığı ya da başhekim yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 5],
        '13c' => ['baslik' => 'Senato ya da üniversite yönetim kurulu üyeliği, teknopark ve teknoloji transfer ofisi temsilciliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Senato / Üniversite Yönetim Kurulu Üyesi'], 'puan' => 4],
        '13d' => ['baslik' => 'Bölüm başkanlığı, araştırma ve uygulama merkezi müdürlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 3],
        '13e' => ['baslik' => 'Bölüm başkan yardımcılığı, anabilim dalı başkanlığı, koordinatörlük ya da kurul ve komisyon üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük', 'Kurul / Komisyon Üyeliği'], 'puan' => 2],
        '13f' => ['baslik' => 'Toplumsal katkı ve kamu kurumlarıyla iş birliği faaliyetleri', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı', 'Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 2],

        // ══ ÖDÜLLER (tabloda ayrı satır yok; yarışma satırından) ══
        'odul' => ['baslik' => 'Bilim ya da sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü', 'Ufuk Avrupa / ERC Ödülü', 'Burs'], 'puan' => 5],
    ],

    'gruplar' => [
        // Koşulların atıf yaptığı indeks kümeleri.
        'SCI' => ['1a'],
        'SCI-ESCI' => ['1a', '1b'],
        'ALAN-ENDEKS' => ['1b'],
        'ULUSLARARASI-HAKEMLI' => ['1c'],
        'ULAKBIM' => ['2a'],
        'ULUSAL' => ['2a', '2b'],
        // "Uluslararası hakemli dergi yahut ULAKBİM'de taranan ya da
        // taranmayan ulusal hakemli dergilerde".
        'HAKEMLI' => ['1c', '2a', '2b'],
        'KITAP-ULUSLARARASI' => ['4a', '4b', '4b-ed'],
        'KITAP-ULUSAL' => ['4c', '4d', '4d-ed'],
        // Tavan grupları.
        'SANAT' => ['12a', '12b', '12c', '12d', '12e', '12i', '12j', '12f', '12g'],
        'IDARI' => ['13a', '13b', '13c', '13d', '13e', '13f'],
    ],

    // 12. madde "Bu maddeden en fazla 10 puan alınabilir";
    // 13. madde "Bu görevlerden en fazla 10 puan alınabilir".
    'grup_tavanlari' => ['SANAT' => 10, 'IDARI' => 10],
];
