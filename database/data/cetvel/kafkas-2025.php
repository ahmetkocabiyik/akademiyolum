<?php

use App\Enums\Kategori;

/**
 * KAFKAS ÜNİVERSİTESİ — Temel Alanlara Göre Başvuru Şartları Tabloları
 * Kaynak: pdf/1767879369889.kafkas-kriter-08012026.pdf (69 sayfa; Senato
 * 08.12.2025 tarih ve 13/20 sayılı kararı)
 *
 * ── ON TEMEL ALAN, ON TABLO ──
 * Yönerge her temel alan için ayrı "Başvuru Şartları Tablosu" veriyor.
 * Tablolar ORTAK BİR GÖVDEYİ paylaşıyor (kitap, atıf, tez danışmanlığı,
 * proje, bilimsel toplantı, patent, ödül, editörlük, kurumsal katkı,
 * organizasyon, diğer bölümleri satır satır aynı); ayrıştıkları noktalar
 * bu dosyada `$farklar` altında toplandı:
 *   Eğitim Bilimleri  — makaleyi "Uluslararası Makale" ve "Ulusal Makale"
 *       diye İKİ bölüme ayırıyor; diğerlerinde tek "Makaleler" bölümü var.
 *   Güzel Sanatlar    — kendi "Sanatsal Etkinlikler" bölümü var, kitap
 *       puanları yarı yarıya düşük ve kitap satırı "tek yazarlı" diyor.
 *   İlahiyat          — makale satırlarının harf sırası farklı (d bendi
 *       çeviri/tahkik makale, 8 puan) ve ulusal kitap bölümü 5 puan.
 *   Mimarlık ve Tasarım — kendi "Yarışma, Uygulama, Yazılım ve Patent"
 *       bölümü var, "Organizasyon" bölümü yok.
 *   Spor Bilimleri    — kendi "Sportif Başarı ve Temsil" bölümü var ve
 *       proje bölümü yedi satırlı.
 *
 * ── MADDE KODLARI ──
 * Yönergenin tablolarında bölümler NUMARALI ama numaralandırma alandan
 * alana kayıyor (Eğitim'de kitap 3., Fen'de 2., Güzel Sanatlar'da 3.).
 * Koşullar ise bölümlere ADIYLA atıf yapıyor ("Makaleler bölümü a ve/veya
 * b bendi"). Bu yüzden kodlar bölüm adının kısaltması + yönergenin kendi
 * harfi biçiminde yazıldı: `M-a` (Makaleler a), `K-b` (Kitap b),
 * `BT-a` (Bilimsel Toplantı a) gibi. Bize ait olan tek şey bu kısaltmalar,
 * çeyrekliğe göre bölünen makale satırlarının `-Q1..-Q4` ekleri ve
 * editörlük dalı için açılan `-ed` ekleri.
 *
 * ── ÇEYREKLİK ÇARPANI CETVELE GÖMÜLDÜ ──
 * Her tablonun altındaki "Puan Hesaplama" notu: "SCI, SCI-Expanded, SSCI
 * ve AHCI kapsamında Q1 için 2, Q2 için 1.5 ve Q3 için 1.25 çarpan
 * katsayısı uygulanır." Çarpım cetvele gömüldü ve §0 uyarınca AŞAĞI
 * yuvarlandı: 25 → Q1 50 · Q2 37 · Q3 31 · Q4 25. Yönergenin kendi kuralı
 * gereği "Q değeri bulunmayan AHCI kapsamındaki dergiler Q4 kategorisinde
 * kabul edilir".
 *
 * ── AYNI KAYNAĞA DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   Ödül bölümünde TÜBİTAK Bilim Ödülü (40) ile Teşvik Ödülü (25) tek
 *       'TÜBİTAK / TÜBA Ödülü' etiketine düşüyor → 25; TÜBA GEBİP (10) ile
 *       TESEP (5) tek etikete düşüyor → 5.
 *   Editörlük bölümünde uluslararası hakemlik (2) ile TR Dizin hakemliği
 *       (1) tek 'Hakemlik' etiketine düşüyor → 1.
 *   Kurumsal katkıda koordinatörlük (10) ile anabilim dalı başkanlığı (5)
 *       tek etikete düşüyor → 5; rektörlük komisyon başkanlığı (5), üyeliği
 *       (3) ve diğer jüri/komisyon üyelikleri (2) tek 'Kurul / Komisyon
 *       Üyeliği' etiketine düşüyor → 2.
 *   Organizasyon bölümünün dört satırı (15/8/5/10) ile "ulusal
 *       organizasyonlarda ilgili puanın yarısı" kuralı tek 'Diğer'
 *       etiketine düşüyor → 2.
 *   Güzel Sanatlar'ın sanatsal etkinlik satırları "kişisel/grup-karma"
 *       biçiminde çift puanlı (20/5, 15/3); kişisel etkinlik etiketleri
 *       yüksek, karma etiketleri düşük değeri aldı.
 *   Spor Bilimleri'nin sportif başarı satırları (olimpiyat altın 15 …
 *       üniversite oyunları bronz 3) tek 'Yarışma Derecesi / Mansiyon'
 *       etiketine düşüyor → 3.
 *
 * ── EĞİTİM-ÖĞRETİM BÖLÜMÜ PUANLANAMIYOR ──
 * Bölümün birimi ESER DEĞİL, BLOK: "Dönemlik programlarda DÖRT FARKLI
 * YARIYILDA ders vermiş olmak — 3 puan". Ders kaydı yarıyıl başına
 * tutulduğu için 3 puan dörde bölünemez (0,75 → 0). Bu yüzden eğitim
 * öğretim satırları CETVELE HİÇ YAZILMADI; bölümün koşulları yönerge
 * dosyasında `Kalip::metrik('ders_yariyil', …)` ile karşılandı ("en az 2
 * puan" → 4 yarıyıl, "en az 4 puan" → 8 yarıyıl). Toplam puan bu yüzden
 * en fazla 10 puan DÜŞÜK görünür.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   Patent bölümünün "d) Kişisel patent başvurusunda bulunmuş olmak" (5)
 *       satırı — başvuru ile tescil kayıtta ayrılamıyor, tescilliyi
 *       başvuru gibi saymamak için yazılmadı.
 *   Bilimsel toplantı bölümü "poster hariç" dediği hâlde kayıt özet ile
 *       posteri tek etikette taşıyor; §0 uyarınca yalnızca TAM METİN
 *       satırları girildi, özet/poster hiç sayılmıyor.
 *   Kurumsal katkıda rektörlük ve dekanlık — yönergenin listesinde YOK.
 *   Güzel Sanatlar sanatsal etkinliklerinde derleme çalışması (g) ve
 *       "programlı olmayan etkinlikler" (h) — sözlükte karşılık yok.
 *   Spor sportif başarıda antrenörlük belgesi (c) ve A Milli Sporcu
 *       belgesi (d) — sözlükte karşılık yok.
 *   Ödül bölümünde uluslararası/ulusal bilim-sanat ödülleri ve burslar —
 *       yönergenin listesinde YOK.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   "Aynı kitaptaki bölümlerden sadece ikisi puanlanabilir" ve "aynı
 *       toplantıda sunulan en fazla iki bildiri puanlandırılır" — eser
 *       bazlı tavan.
 *   "Ansiklopedi maddelerinin üç veya daha çok maddesi bir kitap bölümü
 *       kabul edilir": üçe bölünüp aşağı yuvarlandı (8/3 → 2).
 *   Editörlük ve kurumsal katkıda "görevde tamamlanan tam yıl başına
 *       puanlama yapılır" — yıl biriktirmesi yok, görev başına tek yıl.
 *
 * Yönerge: yonerge/kafkas.php
 */
$SCI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];

// "Yazar sayısının birden fazla olması halinde adayın bu çalışmadan alacağı
// puan aşağıdaki tabloya göre saptanır" — sıraya VE yazar sayısına bağlı
// matris (1 isimli %100; 2 isimli %100/%90; 3 isimli %90/%80/%70 …).
$yazarKatsayisi = [
    'haric' => ['atif', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev',
        'odul', 'editorluk', 'toplumsal_katki', 'proje', 'patent', 'diger'],
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.00]],
        'ilk' => ['kademeler' => [1 => 1.00, 2 => 1.00, 3 => 0.90, 4 => 0.85, 5 => 0.80,
            6 => 0.75, 7 => 0.70, 8 => 0.65, 9 => 0.60, 10 => 0.55, 11 => 0.50, 12 => 0.45,
            13 => 0.40], 'sonrasi' => 0.35],
        'baslica' => ['kademeler' => [1 => 1.00, 2 => 1.00, 3 => 0.90, 4 => 0.85, 5 => 0.80,
            6 => 0.75, 7 => 0.70, 8 => 0.65, 9 => 0.60, 10 => 0.55, 11 => 0.50, 12 => 0.45,
            13 => 0.40], 'sonrasi' => 0.35],
        'yazar_2' => ['kademeler' => [2 => 0.90, 3 => 0.80, 4 => 0.75, 5 => 0.70, 6 => 0.65,
            7 => 0.60, 8 => 0.55, 9 => 0.50, 10 => 0.45, 11 => 0.40, 12 => 0.35, 13 => 0.30],
            'sonrasi' => 0.25],
        'yazar_3' => ['kademeler' => [3 => 0.70, 4 => 0.65, 5 => 0.60, 6 => 0.55, 7 => 0.50,
            8 => 0.45, 9 => 0.40, 10 => 0.35, 11 => 0.30], 'sonrasi' => 0.25],
        'yazar_4' => ['kademeler' => [4 => 0.55, 5 => 0.50, 6 => 0.45, 7 => 0.40, 8 => 0.35,
            9 => 0.30], 'sonrasi' => 0.25],
        'yazar_5' => ['kademeler' => [5 => 0.40, 6 => 0.35, 7 => 0.30], 'sonrasi' => 0.25],
        'yazar_6' => ['sonrasi' => 0.25],
        'ortak' => ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.70, 4 => 0.55, 5 => 0.40,
            6 => 0.35, 7 => 0.30], 'sonrasi' => 0.25],
    ],
];

$IDARI = [
    'mudur' => ['Dekan / Enstitü-YO Müdürü', 'Uygulama ve Araştırma Merkezi Müdürü'],
    'yardimci' => ['Dekan Yrd. / Müdür Yrd.'],
    'bolum' => ['Bölüm Başkanı'],
    'abd' => ['Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük'],
    'kurul' => ['Senato / Üniversite Yönetim Kurulu Üyesi', 'Kurul / Komisyon Üyeliği'],
];

/**
 * Bütün tabloların paylaştığı gövde. `$p` yalnızca ayrışan puanları taşır.
 *
 * @param  array<string, int>  $p
 * @return array<string, array<string, mixed>>
 */
$govde = function (array $p) use ($IDARI): array {
    return [
        // ══ KİTAP ══
        'K-a' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => $p['K-a']]
            + ($p['K-tek'] ? ['roller' => ['tek']] : []),
        'K-b' => ['baslik' => 'Uluslararası yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => $p['K-b']],
        'K-b-ed' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitabın editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => $p['K-b']],
        'K-c' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı'], 'puan' => $p['K-c']]
            + ($p['K-tek'] ? ['roller' => ['tek']] : []),
        'K-d' => ['baslik' => 'Ulusal yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => $p['K-d']],
        'K-d-ed' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitabın editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => $p['K-d']],
        'K-e' => ['baslik' => 'Uluslararası ya da ulusal yayınevi tarafından yayımlanan kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 6],
        'K-f' => ['baslik' => 'Uluslararası ya da ulusal yayınevi tarafından yayımlanan kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 4],
        'K-ans' => ['baslik' => 'Ansiklopedi maddesi (üç madde bir kitap bölümü sayılır)', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => intdiv($p['K-d'], 3)],

        // ══ ATIF ══
        'AT-a' => ['baslik' => 'SCIE, SSCI, AHCI, ESCI veya Scopus kapsamında eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
        'AT-b' => ['baslik' => 'Uluslararası yayınevi kitabında eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
        'AT-c' => ['baslik' => 'TR Dizin kapsamındaki dergilerde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
        'AT-d' => ['baslik' => 'Diğer uluslararası ya da ulusal kitap ve dergilerde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],

        // ══ LİSANSÜSTÜ TEZ DANIŞMANLIĞI ══
        'TD-a' => ['baslik' => 'Tamamlanmış doktora ya da uzmanlık tezinde asıl danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 5],
        'TD-a-es' => ['baslik' => 'Tamamlanmış doktora ya da uzmanlık tezinde ikinci/eş danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 2],
        'TD-b' => ['baslik' => 'Tamamlanmış yüksek lisans tezinde asıl danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 3],
        'TD-b-es' => ['baslik' => 'Tamamlanmış yüksek lisans tezinde ikinci/eş danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 1],

        // ══ BİLİMSEL ARAŞTIRMA PROJESİ ══
        'BAP-a' => ['baslik' => 'AB Çerçeve Programı ya da TÜBİTAK projesinde koordinatör veya yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 15],
        'BAP-b' => ['baslik' => 'AB Çerçeve Programı ya da TÜBİTAK projesinde ortak araştırmacı veya danışman', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
        'BAP-c' => ['baslik' => 'Kamu kurumu ya da özel kuruluşla yapılan Ar-Ge/Ür-Ge projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'puan' => $p['BAP-c']],
        'BAP-d' => ['baslik' => 'Üniversite dışındaki kamu kurumlarıyla ya da uluslararası fonlarla yapılan projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['TÜSEB', 'Diğer Kamu Kurumu', 'Diğer Uluslararası Fon'], 'puan' => $p['BAP-d']],
        'BAP-e' => ['baslik' => 'Üniversite tarafından desteklenen projede (tez ve uzmanlık projeleri dâhil) yürütücü veya araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'puan' => $p['BAP-e']],

        // ══ BİLİMSEL TOPLANTI FAALİYETİ ══
        'BT-a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan ve tam metni yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => $p['BT-a']],
        'BT-b' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan ve tam metni yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => $p['BT-b']],

        // ══ PATENT / FAYDALI MODEL ══
        'PT-a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 40],
        'PT-b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 20],
        'PT-c' => ['baslik' => 'Tescil edilmiş faydalı model ya da benzeri sınai hak', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili', 'Ticarileştirme'], 'puan' => 10],

        // ══ ÖDÜL ══
        'OD-ab' => ['baslik' => 'YÖK yılın doktora tezi ya da üstün başarı ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü'], 'puan' => 40],
        'OD-cd' => ['baslik' => 'TÜBİTAK Bilim ya da Teşvik Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü'], 'puan' => 25],
        'OD-ef' => ['baslik' => 'TÜBA GEBİP ya da TESEP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 5],

        // ══ EDİTÖRLÜK VE HAKEMLİK ══
        'ED-a' => ['baslik' => 'SCIE, SSCI, AHCI, ESCI veya Scopus kapsamındaki dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 2],
        'ED-c' => ['baslik' => 'TR Dizin kapsamındaki dergilerde editörlük ya da hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi', 'Yayın Kurulu Üyeliği', 'Hakemlik'], 'puan' => 1],

        // ══ KURUMSAL KATKI ══
        'KK-a' => ['baslik' => 'Enstitü, yüksekokul, konservatuvar, meslek yüksekokulu ya da merkez müdürlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => $IDARI['mudur'], 'puan' => 15],
        'KK-b' => ['baslik' => 'Dekan yardımcılığı ya da müdür yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => $IDARI['yardimci'], 'puan' => 10],
        'KK-c' => ['baslik' => 'Bölüm başkanlığı', 'kategori' => 'idari_gorev', 'kaynaklar' => $IDARI['bolum'], 'puan' => 8],
        'KK-d' => ['baslik' => 'Bölüm başkan yardımcılığı, anabilim dalı başkanlığı ya da koordinatörlük', 'kategori' => 'idari_gorev', 'kaynaklar' => $IDARI['abd'], 'puan' => 5],
        'KK-i' => ['baslik' => 'Kurul, yönetim kurulu, komisyon ya da jüri üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => $IDARI['kurul'], 'puan' => 2],

        // ══ DİĞER ══
        'DG-a' => ['baslik' => 'Eğitici Eğitimi ve Gelişimi Programına katılmak', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Akreditasyon Faaliyeti'], 'puan' => 3],
    ];
};

/** Çeyrekliğe göre bölünen makale satırları. */
$makaleSci = fn (string $kod, string $baslik, int $taban, array $turler): array => [
    "{$kod}-Q1" => ['baslik' => "{$baslik} (Q1)", 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $turler, 'puan' => $taban * 2],
    "{$kod}-Q2" => ['baslik' => "{$baslik} (Q2)", 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $turler, 'puan' => (int) floor($taban * 1.5)],
    "{$kod}-Q3" => ['baslik' => "{$baslik} (Q3)", 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $turler, 'puan' => (int) floor($taban * 1.25)],
    "{$kod}-Q4" => ['baslik' => "{$baslik} (Q4 ya da çeyreklik değeri olmayan AHCI)", 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => $turler, 'puan' => $taban],
];

$OZGUN = ['ozgun_makale'];
$KISA = ['derleme', 'kisa_makale', 'vaka_teknik_not'];

/** Ortak makale bölümü (Eğitim, Güzel Sanatlar ve İlahiyat dışındaki yedi alan). */
$makaleOrtak = fn (int $ulusalDiger): array => array_merge(
    $makaleSci('M-a', 'SCI-Expanded, SSCI veya AHCI kapsamındaki dergide yayımlanmış makale', 25, $OZGUN),
    [
        'M-b' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $OZGUN, 'puan' => 20],
        'M-c' => ['baslik' => 'TR Dizin tarafından taranan ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $OZGUN, 'puan' => 15],
        'M-d' => ['baslik' => 'Diğer uluslararası hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $OZGUN, 'puan' => 10],
        'M-e' => ['baslik' => 'Diğer ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $OZGUN, 'puan' => $ulusalDiger],
    ],
    $makaleSci('M-f', 'SCI-Expanded, SSCI, AHCI, ESCI veya Scopus kapsamındaki dergide editöre mektup, derleme, özet, teknik not ya da kitap kritiği', 5, $KISA),
    ['M-f-esci' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide editöre mektup, derleme, özet, teknik not ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks', 'TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 5]],
);

$makaleGuzelSanatlar = array_merge(
    $makaleSci('M-a', 'SCI-Expanded, SSCI veya AHCI kapsamındaki dergide yayımlanmış makale', 25, $OZGUN),
    [
        'M-b' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $OZGUN, 'puan' => 20],
        'M-c' => ['baslik' => 'TR Dizin tarafından taranan ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $OZGUN, 'puan' => 15],
        'M-d' => ['baslik' => 'Diğer uluslararası hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $OZGUN, 'puan' => 5],
        'M-e' => ['baslik' => 'Ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $OZGUN, 'puan' => 5],
    ],
    $makaleSci('M-f', 'SCI-Expanded, SSCI, AHCI, ESCI veya Scopus kapsamındaki dergide editöre mektup, derleme, özet, teknik not ya da kitap kritiği', 5, $KISA),
    ['M-f-esci' => ['baslik' => 'Diğer dergilerde editöre mektup, derleme, özet, teknik not ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks', 'TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 5]],
);

// İlahiyat'ta harf sırası farklı: d bendi çeviri/tahkik makale (8), e bendi
// kısa yayın (5), f bendi diğer ulusal hakemli (5).
$makaleIlahiyat = array_merge(
    $makaleSci('M-a', 'SCI-Expanded, SSCI veya AHCI kapsamındaki dergide yayımlanmış makale', 25, $OZGUN),
    [
        'M-b' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $OZGUN, 'puan' => 20],
        'M-c' => ['baslik' => 'TR Dizin tarafından taranan ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $OZGUN, 'puan' => 15],
        'M-d' => ['baslik' => 'Çeviri ya da tahkik/edisyon kritik olarak ulusal veya uluslararası hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $OZGUN, 'puan' => 8],
        'M-f' => ['baslik' => 'Diğer ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $OZGUN, 'puan' => 5],
    ],
    $makaleSci('M-e', 'SCI-Expanded, SSCI, AHCI, ESCI veya Scopus kapsamındaki dergide editöre mektup, derleme, özet, teknik not ya da kitap kritiği', 5, $KISA),
    ['M-e-esci' => ['baslik' => 'Diğer dergilerde editöre mektup, derleme, özet, teknik not ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 5]],
);

// Eğitim Bilimleri makaleyi iki bölüme ayırıyor.
$makaleEgitim = array_merge(
    $makaleSci('UM-a', 'SSCI, SCI, SCI-Expanded veya AHCI kapsamındaki dergide yayımlanmış makale', 25, $OZGUN),
    [
        'UM-b' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $OZGUN, 'puan' => 20],
        'UM-c' => ['baslik' => 'Diğer uluslararası indekslerde taranan dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $OZGUN, 'puan' => 10],
        'NM-a' => ['baslik' => 'TR Dizin tarafından taranan ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $OZGUN, 'puan' => 15],
        'NM-b' => ['baslik' => 'Diğer ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $OZGUN, 'puan' => 5],
    ],
    $makaleSci('UM-d', 'Uluslararası dergide editöre mektup, derleme, özet, teknik not ya da kitap kritiği', 5, $KISA),
    ['UM-d-esci' => ['baslik' => 'Diğer dergilerde editöre mektup, derleme, özet, teknik not ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks', 'TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 5]],
);

// Güzel Sanatlar "Sanatsal Etkinlikler" bölümü. Satırlar "kişisel/grup-karma"
// biçiminde çift puanlı; kişisel etiketler yüksek, karma etiketler düşük değeri
// alıyor. Listede yer almayan sanat etiketleri en düşük satıra düşer.
$seKisiselU = ['Kişisel Etkinlik (Uluslararası)', 'Elektronik Kişisel Sergi (Uluslararası)',
    'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)'];
$seKarmaU = ['Karma/Jürili Etkinlik (Uluslararası)', 'Elektronik Karma Sergi (Uluslararası)',
    'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)'];
$seKisiselN = ['Kişisel Etkinlik (Ulusal)', 'Elektronik Kişisel Sergi (Ulusal)',
    'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)'];
$seKarmaN = ['Karma/Jürili Etkinlik (Ulusal)', 'Elektronik Karma Sergi (Ulusal)',
    'Karma Etkinlik (Jürisiz, Ulusal)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)'];
$seSempozyum = ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)'];
$seTasarim = ['Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip',
    'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman',
    'Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)'];
$seAlbum = ['Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)'];
$seKarmaAlbum = ['Karma Albüm / CD-DVD Katkısı', 'Orkestra / Koro Üyeliği'];
$seBeste = ['Özgün Eser / Beste / Tasarım', 'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir',
    'Küçük Ölçekli Orkestra Eseri', 'Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)',
    'Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Opera/Bale Kompozisyonu',
    'Orkestralı Sahne Eseri', 'Sahne/Ekran Müziği'];
$seDuzenleme = ['Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi', 'Eğitim Müziği Albümü'];
$seResital = ['Resital (Uluslararası)', 'Resital (Ulusal)', 'Solistlik (Uluslararası)',
    'Solistlik (Ulusal)', 'Şan Resitali (Uluslararası)', 'Şan Resitali (Ulusal)'];
$seOpera = ['Opera Birinci Rol (Uluslararası)', 'Opera Birinci Rol (Ulusal)',
    'Opera İkinci Rol (Uluslararası)', 'Opera İkinci Rol (Ulusal)',
    'Oratoryo/Kantat Solistliği (Uluslararası)', 'Oratoryo/Kantat Solistliği (Ulusal)'];
$seMaster = ['Masterclass (Uluslararası)', 'Masterclass (Ulusal)', 'Müzikoloji Atölyesi',
    'Eğitim Amaçlı Sanat Etkinliği', 'Eğitici Konser Programı (Uluslararası)',
    'Eğitici Konser Programı (Ulusal)'];
$seFilmU = ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Belgesel/Kısa Film (Uluslararası)',
    'Yönetmenlik (Sahne/Ekran)'];
$seFilmN = ['Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Belgesel/Kısa Film (Ulusal)'];

$seKullanilan = array_merge($seKisiselU, $seKarmaU, $seKisiselN, $seKarmaN, $seSempozyum,
    $seTasarim, $seAlbum, $seKarmaAlbum, $seBeste, $seDuzenleme, $seResital, $seOpera,
    $seMaster, $seFilmU, $seFilmN);
$seKalan = array_values(array_diff(Kategori::SanatselEtkinlik->kaynaklar(), $seKullanilan));

$sanatsalEtkinlik = [
    'SE-a' => ['baslik' => 'Özgün sanat eseri, tasarım ya da yorum çalışmasıyla uluslararası kişisel etkinlikte bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $seKisiselU, 'puan' => 20],
    'SE-a-karma' => ['baslik' => 'Özgün sanat eseri, tasarım ya da yorum çalışmasıyla uluslararası grup ya da karma etkinlikte bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $seKarmaU, 'puan' => 5],
    'SE-b' => ['baslik' => 'Özgün sanat eseri, tasarım ya da yorum çalışmasıyla ulusal kişisel etkinlikte bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $seKisiselN, 'puan' => 15],
    'SE-b-karma' => ['baslik' => 'Özgün sanat eseri, tasarım ya da yorum çalışmasıyla ulusal grup ya da karma etkinlikte bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $seKarmaN, 'puan' => 3],
    'SE-c' => ['baslik' => 'Sempozyum, festival, workshop ya da bienal gibi etkinliklere eserlerinizle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $seSempozyum, 'puan' => 7],
    'SE-d' => ['baslik' => 'Endüstriyel ürüne dönüştürülmüş, üretilmiş ve ticarileşmiş özgün tasarım', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $seTasarim, 'puan' => 5],
    'SE-ef' => ['baslik' => 'Bandrollü CD, plak, kaset, VCD ya da DVD yayınında kişisel olarak yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $seAlbum, 'puan' => 15],
    'SE-ef-karma' => ['baslik' => 'Bandrollü CD, plak, kaset, VCD ya da DVD yayınında grup ya da karma olarak yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $seKarmaAlbum, 'puan' => 3],
    'SE-I' => ['baslik' => 'Senfoni, konçerto, oda müziği, koro ya da solo eser yazmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $seBeste, 'puan' => 7],
    'SE-i' => ['baslik' => 'Müzik eseri düzenleme ya da çok seslendirme', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $seDuzenleme, 'puan' => 2],
    'SE-j' => ['baslik' => 'Solo konser ya da resital vermek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $seResital, 'puan' => 10],
    'SE-k' => ['baslik' => 'Orkestra, opera ve benzeri etkinliklerde solist olarak yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $seOpera, 'puan' => 10],
    'SE-m' => ['baslik' => 'Ulusal ya da uluslararası akademik eğitim kurumlarında masterclass yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $seMaster, 'puan' => 2],
    'SE-n' => ['baslik' => 'Uluslararası yayımlanmış görsel-işitsel program ya da filmde yönetmenlik, görüntü yönetmenliği, senaristlik veya kurguculuk', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $seFilmU, 'puan' => 10],
    'SE-o' => ['baslik' => 'Ulusal yayımlanmış görsel-işitsel program ya da filmde yönetmenlik, görüntü yönetmenliği, senaristlik veya kurguculuk', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $seFilmN, 'puan' => 5],
    'SE-l' => ['baslik' => 'Ulusal ya da uluslararası sanatsal etkinliklere programlı olarak kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $seKalan, 'puan' => 3],
];

/**
 * Alan tanımları: makale bölümü, gövde puanları ve alana özgü ek satırlar.
 *
 * `K-tek` yalnızca Güzel Sanatlar'da 1: o tablonun kitap satırı açıkça
 * "tek yazarlı kitap" diyor.
 */
$ORTAK_P = ['K-a' => 20, 'K-b' => 10, 'K-c' => 15, 'K-d' => 8, 'K-tek' => false,
    'BAP-c' => 6, 'BAP-d' => 4, 'BAP-e' => 4, 'BT-a' => 3, 'BT-b' => 2];

$organizasyon = ['OR' => ['baslik' => 'Uluslararası ya da ulusal bilimsel kongre, konferans veya sempozyum düzenleme kurulunda görev almak', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 2]];

$alanlar = [
    'egitim' => ['ad' => 'Eğitim Bilimleri Temel Alanı', 'makale' => $makaleEgitim, 'p' => $ORTAK_P, 'ek' => $organizasyon],
    'fen' => ['ad' => 'Fen Bilimleri ve Matematik Temel Alanı', 'makale' => $makaleOrtak(4), 'p' => $ORTAK_P, 'ek' => $organizasyon],
    'filoloji' => ['ad' => 'Filoloji Temel Alanı', 'makale' => $makaleOrtak(5), 'p' => $ORTAK_P, 'ek' => $organizasyon],
    'guzel_sanatlar' => ['ad' => 'Güzel Sanatlar Temel Alanı', 'makale' => $makaleGuzelSanatlar,
        'p' => ['K-a' => 12, 'K-b' => 6, 'K-c' => 10, 'K-d' => 5, 'K-tek' => true,
            'BAP-c' => 6, 'BAP-d' => 4, 'BAP-e' => 4, 'BT-a' => 5, 'BT-b' => 3],
        'ek' => $organizasyon + $sanatsalEtkinlik],
    'ilahiyat' => ['ad' => 'İlahiyat Temel Alanı', 'makale' => $makaleIlahiyat,
        'p' => ['K-a' => 20, 'K-b' => 10, 'K-c' => 15, 'K-d' => 5, 'K-tek' => false,
            'BAP-c' => 6, 'BAP-d' => 4, 'BAP-e' => 4, 'BT-a' => 3, 'BT-b' => 2],
        'ek' => $organizasyon],
    'mimarlik' => ['ad' => 'Mimarlık ve Tasarım Temel Alanı', 'makale' => $makaleOrtak(5), 'p' => $ORTAK_P,
        'ek' => [
            'YU-a' => ['baslik' => 'Meslek odaları, yerel yönetimler, bakanlıklar ya da uluslararası kuruluşların düzenlediği mimarlık, planlama veya tasarım yarışmasında derece ya da mansiyon', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon', 'Uluslararası Bilim/Sanat Ödülü', 'Ulusal Bilim/Sanat Ödülü'], 'puan' => 15],
            'YU-b' => ['baslik' => 'Ürettiğiniz bir uygulama projesi hakkında yayımlanmış makale, kitap bölümü ya da kitap', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman', 'Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)'], 'puan' => 15],
            // YU-c'nin kapsamı YALNIZ patent ve yazılım: kaynak "yazılım üreticisi
            // veya PATENT SAHİBİ olmak" diyor. İlk girişte bütün sınai hak
            // etiketleri listeye kopyalanmıştı; 15 puanı PT-c'nin 10'undan yüksek
            // olduğu için faydalı model, endüstriyel tasarım, ıslahçı hakkı ve
            // ticarileştirme kayıtları kaynağın vermediği puanı alıyordu (§0).
            'YU-c' => ['baslik' => 'Proje ve yapım yönetimi, tasarım ya da planlama alanlarında yazılım üreticisi veya patent sahibi olmak', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent', 'Ulusal Patent', 'Yazılım'], 'puan' => 15],
        ]],
    'muhendislik' => ['ad' => 'Mühendislik Temel Alanı', 'makale' => $makaleOrtak(5), 'p' => $ORTAK_P, 'ek' => $organizasyon],
    'saglik' => ['ad' => 'Sağlık Bilimleri Temel Alanı', 'makale' => $makaleOrtak(5), 'p' => $ORTAK_P, 'ek' => $organizasyon],
    'sosyal' => ['ad' => 'Sosyal, Beşeri ve İdari Bilimler Temel Alanı', 'makale' => $makaleOrtak(5), 'p' => $ORTAK_P, 'ek' => $organizasyon],
    'spor' => ['ad' => 'Spor Bilimleri Temel Alanı', 'makale' => $makaleOrtak(5),
        'p' => ['K-a' => 20, 'K-b' => 10, 'K-c' => 15, 'K-d' => 8, 'K-tek' => false,
            'BAP-c' => 8, 'BAP-d' => 6, 'BAP-e' => 4, 'BT-a' => 3, 'BT-b' => 2],
        'ek' => $organizasyon + [
            // Spor tablosunda kamu kurumu projeleri koordinatörlük (6) ve
            // yürütücü/araştırmacı/danışman (4) diye ikiye ayrılıyor.
            'BAP-e2' => ['baslik' => 'Üniversite dışındaki kamu kurumlarıyla yapılan projede koordinatör ya da baş araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 6],
            'BAP-f' => ['baslik' => 'Üniversite dışındaki kamu kurumlarıyla yapılan projede yürütücü, araştırmacı ya da danışman', 'kategori' => 'proje', 'kaynaklar' => ['TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 4],
            'SP-ab' => ['baslik' => 'Olimpiyat, üniversite oyunları ya da Avrupa-Dünya şampiyonalarında sporcu olarak derece almak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon', 'Uluslararası Bilim/Sanat Ödülü', 'Ulusal Bilim/Sanat Ödülü'], 'puan' => 3],
        ]],
];

/**
 * TEZ YAYINI AYNA SATIRLARI — kodlar bize ait, puanlar karşılıklarıyla aynı.
 *
 * Kafkas'ın hiçbir tablosunda "lisansüstü tezlerden üretilmiş yayın" diye
 * ayrı bir bölüm YOK; tezden üretilmiş bir makale kendi yayın türünün
 * satırından puan alıyor. Buna karşılık kadro koşullarının çoğu "adayın
 * doktora tezinden olmak koşulu ile Makaleler bölümü kapsamında en az 5
 * puan" diyor. Koşul değerlendirilebilsin ve `tez_yayini` kategorisindeki
 * kayıtlar sıfırlanmasın diye ayna satırlar açıldı; çeyreklik bilgisi bu
 * kategoride tutulmadığı için SCI ayna satırı §0 uyarınca ÇARPANSIZ taban
 * değeri alıyor.
 *
 * @param  array<string, int>  $p
 * @return array<string, array<string, mixed>>
 */
$tezAynalari = fn (array $p, int $ulusalDiger): array => [
    'M-a-tez' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, SCI-Expanded, SSCI veya AHCI kapsamındaki dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 25],
    'M-b-tez' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, ESCI veya Scopus kapsamındaki dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 20],
    'M-c-tez' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, TR Dizin tarafından taranan dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['TR Dizin'], 'puan' => 15],
    'M-d-tez' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, diğer hakemli dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Diğer'], 'puan' => $ulusalDiger],
    'BT-a-tez' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, bilimsel toplantıda sunulmuş ve tam metni yayımlanmış bildiri', 'kategori' => 'tez_yayini', 'kaynaklar' => ['CPCI Bildiri'], 'puan' => $p['BT-a']],
    'K-a-tez' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => $p['K-a']],
    'K-b-tez' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, uluslararası yayınevi kitabında bölüm', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => $p['K-b']],
    'K-c-tez' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => $p['K-c']],
    'K-d-tez' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, ulusal yayınevi kitabında bölüm', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => $p['K-d']],
];

$TAVANLAR = ['K' => 30, 'AT' => 30, 'TD' => 10, 'BAP' => 20, 'BT' => 20, 'ED' => 4,
    'KK' => 25, 'OR' => 30, 'DG' => 15, 'SP' => 15];

$cetveller = [];

foreach ($alanlar as $alan => $tanim) {
    $ulusalDiger = $alan === 'guzel_sanatlar' ? 5 : ($alan === 'fen' ? 4 : 10);
    $maddeler = array_merge(
        $tanim['makale'],
        $govde($tanim['p']),
        $tezAynalari($tanim['p'], $ulusalDiger),
        $tanim['ek'],
    );
    $kodlar = array_keys($maddeler);

    /** Bir önek ile başlayan bütün kodlar (harf sınırına dikkat: `K-` ile `KK-` ayrı). */
    $ile = fn (string $onek): array => array_values(array_filter(
        $kodlar, fn (string $k) => str_starts_with($k, $onek),
    ));

    $gruplar = [
        'M' => $ile('M-') ?: ['UM-a-Q1'],
        'K' => $ile('K-'),
        'AT' => $ile('AT-'),
        'TD' => $ile('TD-'),
        'BAP' => $ile('BAP-'),
        'BT' => $ile('BT-'),
        'PT' => $ile('PT-'),
        'OD' => $ile('OD-'),
        'ED' => $ile('ED-'),
        'KK' => $ile('KK-'),
        'DG' => $ile('DG-'),
    ];

    // Eğitim Bilimleri'nde makale bölümü ikiye ayrıldığı için ayna satırlar da
    // "Uluslararası Makale" bölümüne bağlanır.
    if ($alan === 'egitim') {
        $gruplar['UM'] = array_merge($ile('UM-'), ['M-a-tez', 'M-b-tez', 'M-c-tez', 'M-d-tez']);
        $gruplar['NM'] = $ile('NM-');
        $gruplar['M'] = array_merge($gruplar['UM'], $gruplar['NM']);
        $gruplar['UM-ab'] = array_merge($ile('UM-a'), ['UM-b', 'M-a-tez', 'M-b-tez']);
        $gruplar['NM-a'] = ['NM-a'];
    } else {
        $gruplar['M-a'] = $ile('M-a');
        $gruplar['M-ab'] = array_merge($ile('M-a'), ['M-b']);
        $gruplar['M-abc'] = array_merge($ile('M-a'), ['M-b', 'M-c']);
        $gruplar['M-abcd'] = array_merge($ile('M-a'), ['M-b', 'M-c', 'M-d']);
    }

    // "Adayın doktora tezinden olmak koşulu ile" diyen koşulların kümesi.
    $gruplar['TZ'] = array_values(array_filter($kodlar, fn (string $k) => str_ends_with($k, '-tez')));
    $gruplar['TZ-M'] = ['M-a-tez', 'M-b-tez', 'M-c-tez', 'M-d-tez'];

    if ($alan === 'guzel_sanatlar') {
        // Profesörlükte "en az iki KİŞİSEL etkinlik" koşulunun kümesi.
        $gruplar['SE-KISISEL'] = ['SE-a', 'SE-b'];
    }

    foreach (['OR', 'SE', 'YU', 'SP'] as $ek) {
        $bulunan = $ek === 'OR' ? array_values(array_filter($kodlar, fn ($k) => $k === 'OR')) : $ile("{$ek}-");
        if ($bulunan !== []) {
            $gruplar[$ek] = $bulunan;
        }
    }

    $cetveller["kafkas-2025-{$alan}"] = [
        'kapsam_notu' => 'Puanlar Kafkas Üniversitesi Akademik Yükseltme ve Atama Yönergesi '
            ."\"{$tanim['ad']} Başvuru Şartları Tablosu\"ndan. Yazar çarpanı yönergenin katkı "
            .'oranları tablosuna göre işliyor (tek isimli %100; iki isimlide %100/%90; üç '
            .'isimlide %90/%80/%70; on dört ve üzeri isimde ilk isim %35, kalanlar %25). Yazar '
            .'listesini boş bırakırsanız çarpan hiç uygulanmaz ve puanınız olduğundan YÜKSEK '
            .'görünür. Çeyreklik çarpanı (Q1 2 kat, Q2 1,5 kat, Q3 1,25 kat) cetvele gömüldü ve '
            .'§0 uyarınca aşağı yuvarlandı. '
            .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: EĞİTİM-ÖĞRETİM bölümü hiç '
            .'sayılmıyor, çünkü yönerge puanı ders başına değil "dört farklı yarıyılda ders '
            .'vermiş olmak" bloğuna veriyor ve 3 puan dörde bölünemiyor (bu bölümün KOŞULLARI '
            .'yarıyıl sayısı üzerinden uygulanıyor). Bilimsel toplantı bölümünde yönerge posteri '
            .'dışladığı ve kayıt özet ile posteri ayırmadığı için yalnızca tam metin bildiriler '
            .'sayılıyor. Kongre organizasyonu, hakemlik, komisyon üyeliği ve TÜBİTAK ödülleri en '
            .'düşük satırdan sayılıyor; editörlük ve kurumsal katkıda "tamamlanan tam yıl başına" '
            .'çarpanı uygulanmıyor. Rektörlük ve dekanlık görevleri yönergenin kurumsal katkı '
            .'listesinde YOK. '
            .($alan === 'guzel_sanatlar'
                ? 'Güzel Sanatlar tablosunun kitap satırları açıkça "tek yazarlı" diyor: '
                    .'kitabınızı tek yazar olarak kaydetmezseniz o satırlardan puan alamazsınız. '
                    .'Sanatsal etkinliklerde kişisel/grup-karma ayrımı taşımayan etiketler en '
                    .'düşük satıra düşürüldü. '
                : '')
            .'Patent BAŞVURUNUZU kaydetmeyin: yönerge ona ayrı ve düşük puan veriyor ama kayıt '
            .'türü tescilliden ayrılamadığı için o satır girilmedi. '
            .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünebilir: "aynı kitaptan en fazla iki '
            .'bölüm" ve "aynı toplantıdan en fazla iki bildiri" gibi eser bazlı sınırlar '
            .'uygulanmıyor.',
        'yazar_katsayisi' => $yazarKatsayisi,
        'maddeler' => $maddeler,
        'gruplar' => $gruplar,
        'grup_tavanlari' => array_intersect_key($TAVANLAR, $gruplar),
    ];
}

return ['cetveller' => $cetveller];
