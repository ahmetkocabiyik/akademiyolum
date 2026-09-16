<?php

/**
 * PİRİ REİS ÜNİVERSİTESİ — EK-1 "Öğretim Üyeliğine Yükseltilme ve
 * Atanmalarda Kullanılacak Puanlar"
 * Kaynak: pdf/17634009071.Piri Reis Üniversitesi Kriter.pdf (25 sayfa,
 *         Senato 16.04.2025 / 2025-08)
 *
 * KAYNAK TARANMIŞ GÖRÜNTÜ PDF'İ: `pdftotext` on bir baytlık çıktı veriyor,
 * metin `pdf-ocr/` altındaki OCR dosyasından okundu. Tablo YATAY basıldığı
 * ve OCR "Q1"i "Ol", "Q2"yi "O2" diye çözdüğü için puan sütunları 13-19.
 * sayfaların görüntüsünden GÖZLE doğrulandı.
 *
 * DÖRT TEMEL ALAN SÜTUNU, ÜÇ CETVEL. Tablo dört sütun taşıyor (Mühendislik,
 * Sosyal-Beşeri-İdari, Hukuk, Fen-Matematik) ama satır değerleri yalnız
 * HUKUK sütununda ayrışıyor: E.2.a 20 (ötekilerde 5), E.2.b 10 (3),
 * F.1.a 20 (5), F.1.c 10 (3). Mühendislik ile Fen sütunları birebir aynı,
 * bu yüzden `muhfen` tek cetvelde birleşti.
 *
 * TAVANLAR KADROYA GÖRE DEĞİŞİYOR, o yüzden her alan üç kez üretiliyor:
 *
 *   piri-reis-2025-muhfen-dr    · -docent    · -profesor
 *   piri-reis-2025-sosyal-dr    · -docent    · -profesor
 *   piri-reis-2025-hukuk-dr     · -docent    · -profesor
 *
 * GİRİLEMEYEN: H.1.a "h-indeksi = h puan". Aday kaydı h-indeksi taşımıyor
 * ve değer faaliyet başına değil PROFİLE bağlı; satır açılmadı.
 *
 * I (hakemlik) satırları kaynakta "4 x hakemlik sayısı" diye yazılı; motor
 * her faaliyeti bir kez saydığı için birim puan (4 · 3 · 3) yazıldı, çarpım
 * kendiliğinden oluşuyor.
 */
$yazarKatsayisi = [
    // EK-1 dipnotu: tek yazar tam; iki yazarlıda başlıca 0,8; üç ve
    // üzerinde başlıca YARISINI alır, diğerleri öteki yarısını paylaşır;
    // başlıca belirtilmemişse eşit bölünür. Motor "pay/n" biçimini
    // kullandığı için üç ve üzeri kademeler tek tek yazıldı; altıdan çok
    // yazarlı yayında 0,5/n'e düşüyor — §0 yönünde eksik sayıyor.
    'haric' => ['atif', 'proje', 'tez_danismanligi', 'egitim_ogretim',
        'idari_gorev', 'odul', 'editorluk', 'patent', 'toplumsal_katki', 'diger'],
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.0]],
        'baslica' => ['kademeler' => [1 => 1.0, 2 => 0.8, 3 => 0.5, 4 => 0.5, 5 => 0.5, 6 => 0.5], 'bol' => ['pay' => 0.5]],
        'ilk' => ['kademeler' => [1 => 1.0, 2 => 0.8, 3 => 0.5, 4 => 0.5, 5 => 0.5, 6 => 0.5], 'bol' => ['pay' => 0.5]],
        'yazar_2' => ['kademeler' => [1 => 1.0, 2 => 0.5], 'bol' => ['pay' => 0.5]],
        'yazar_3' => ['kademeler' => [1 => 1.0, 2 => 0.5], 'bol' => ['pay' => 0.5]],
        'yazar_4' => ['kademeler' => [1 => 1.0, 2 => 0.5], 'bol' => ['pay' => 0.5]],
        'yazar_5' => ['kademeler' => [1 => 1.0, 2 => 0.5], 'bol' => ['pay' => 0.5]],
        'yazar_6' => ['kademeler' => [1 => 1.0, 2 => 0.5], 'bol' => ['pay' => 0.5]],
        'ortak' => ['kademeler' => [1 => 1.0, 2 => 0.5], 'bol' => ['pay' => 0.5]],
    ],
];

/** @return array<string, array<string, mixed>> */
$maddeler = static function (bool $hukuk): array {
    return [
        // ── A. ULUSLARARASI MAKALE ──
        'A.1.a' => ['baslik' => 'Q1 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'puan' => 30],
        'A.1.b' => ['baslik' => 'Q2 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'puan' => 20],
        'A.1.c' => ['baslik' => 'Q3 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)', 'AHCI'], 'puan' => 15],
        'A.1.d' => ['baslik' => 'Q4 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'puan' => 10],
        'A.2.a' => ['baslik' => 'Q puanı olmayan uluslararası hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'puan' => 5],

        // ── B. ULUSAL MAKALE ──
        'B.1' => ['baslik' => 'TR Dizinde taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 10],
        'B.3' => ['baslik' => 'TR Dizinde olmayan diğer hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 4],

        // ── C/D. BİLDİRİ ──
        'C.1.a' => ['baslik' => 'Uluslararası bilimsel toplantıda tam metinli bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 5],
        'C.1.c' => ['baslik' => 'Uluslararası bilimsel toplantıda özet bildiri ya da poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 1],
        'D.1.a' => ['baslik' => 'Ulusal bilimsel toplantıda tam metinli bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 3],
        'D.1.b' => ['baslik' => 'Ulusal bilimsel toplantıda özet bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 1],

        // ── E. ULUSLARARASI KİTAP ──
        'E.1.a' => ['baslik' => 'Scopus ya da BKCI kapsamındaki yayınevinden kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
        'E.1.b' => ['baslik' => 'Scopus ya da BKCI kapsamındaki kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 10],
        'E.2.a' => ['baslik' => 'Diğer uluslararası kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Uluslararası Ders / Metot Kitabı'], 'puan' => $hukuk ? 20 : 5],
        'E.2.b' => ['baslik' => 'Diğer uluslararası kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => $hukuk ? 10 : 3],

        // ── F. ULUSAL KİTAP ──
        'F.1.b' => ['baslik' => 'Kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 3],
        'F.1.d' => ['baslik' => 'Kitap içinde bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 2],
        'F.1.e' => ['baslik' => 'Ulusal kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 1],

        // ── G. ATIF ──
        'G.1.a' => ['baslik' => 'SCIE, SSCI, AHCI, ESCI ya da Scopus kapsamında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
        'G.1.b' => ['baslik' => 'BKCI kapsamındaki kitapta yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
        'G.1.c' => ['baslik' => 'TR Dizin kapsamındaki dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
        'G.1.d' => ['baslik' => 'Diğer kitap ya da dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],

        // ── I. HAKEMLİK · J. EDİTÖRLÜK ──
        'I.2.a' => ['baslik' => 'Hakemli dergide hakemlik (her hakemlik için)', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 3],
        'J.1.a' => ['baslik' => 'Dizinli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 2],
        'J.3.b' => ['baslik' => 'Dergide editör kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi', 'Yayın Kurulu Üyeliği'], 'puan' => 1],

        // ── K. TEZ YÖNETİMİ ──
        'K.1.a' => ['baslik' => 'Tamamlanmış doktora ya da sanatta yeterlik tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 5],
        'K.1.b' => ['baslik' => 'Tamamlanmış yüksek lisans tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'puan' => 3],

        // ── L. PATENT ──
        'L.1.a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
        'L.1.b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Islahçı Hakkı / Çeşit Tescili', 'Ticarileştirme'], 'puan' => 10],
        'L.1.c' => ['baslik' => 'Tescil edilmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım'], 'puan' => 5],

        // ── M. ÖDÜL ──
        'M.1' => ['baslik' => 'YÖK, TÜBİTAK ya da TÜBA ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü', 'Ulusal Bilim/Sanat Ödülü'], 'puan' => 25],

        // ── N. EĞİTİME KATKI ──
        'N.1' => ['baslik' => 'Ön lisans, lisans ya da lisansüstü ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 2],

        // ── O. İDARİ GÖREV ──
        'O.1' => ['baslik' => 'Rektör yardımcılığı, dekanlık, müdürlük ya da bölüm başkanlığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü', 'Dekan Yrd. / Müdür Yrd.', 'Uygulama ve Araştırma Merkezi Müdürü', 'Bölüm Başkanı', 'Bölüm Başkan Yardımcısı'], 'puan' => 3],
        'O.2' => ['baslik' => 'Komisyon ya da kurul çalışmalarında görev (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 1],

        // ── P. ARAŞTIRMA PROJESİ ──
        'P.4' => ['baslik' => 'Tamamlanmış bilimsel araştırma projesinde yürütücülük ya da görev', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon', 'TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK', 'BAP (Üniversite)'], 'puan' => 3],

        // ── R. DİĞER AKADEMİK FAALİYETLER ──
        'R.1.e' => ['baslik' => 'Bilimsel toplantı düzenleme ya da seçici/bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)', 'Oturum Başkanlığı (Uluslararası)', 'Oturum Başkanlığı (Ulusal)', 'Toplantı Düzenleme Başkanlığı (Uluslararası)', 'Toplantı Düzenleme Başkanlığı (Ulusal)'], 'puan' => 2],
        // YÖK 30.01.2025 kararıyla eklenen jürili yarışma bendi (R.1.f).
        'R.1.f' => ['baslik' => 'Jürili yarışmalarda jüri üyeliği, danışmanlık ya da yarışmaya katılım', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)', 'Karma/Jürili Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Ulusal)'], 'puan' => 2],
        'R.1.g' => ['baslik' => 'Jürili yarışmada derece ya da mansiyon', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 2],
    ];
};

/*
 * F.1.a (ulusal kitap yazarlığı) ve F.1.c (ulusal kitapta bölüm) AYRI SATIR
 * OLARAK AÇILMADI: sözlükte "ulusal kitap" diye ayrı etiket yok,
 * `Uluslararası/Ulusal Kitap` ikisini birden taşıyor ve puanları E.2.a ile
 * BİREBİR AYNI (5, Hukukta 20). İki satır açmak aynı etiketi iki kez
 * yazmak olurdu; motor zaten MAX aldığı için sonuç değişmiyor.
 */

/** @return array<string, int> */
$tavanlar = static function (string $kadro, bool $hukuk, bool $projeDar): array {
    $prof = $kadro === 'profesor';

    return [
        'BILDIRI' => $prof ? 20 : 10,
        'KITAP' => ($hukuk ? 30 : 20) * ($prof ? 2 : 1),
        'ATIF' => 20,
        'HAKEMLIK' => 20,
        'EDITORLUK' => $prof ? 8 : 4,
        'TEZ' => $kadro === 'dr' ? 10 : 20,
        'PATENT' => $prof ? 50 : 25,
        'ODUL' => $prof ? 50 : 25,
        'EGITIM' => $prof ? 12 : 6,
        'IDARI' => $prof ? 12 : 6,
        'PROJE' => ($projeDar ? 20 : 30) * ($prof ? 2 : 1),
        'DIGER' => $prof ? 20 : 10,
    ];
};

$cetveller = [];

foreach ([
    ['ad' => 'muhfen', 'hukuk' => false, 'projeDar' => false],
    ['ad' => 'sosyal', 'hukuk' => false, 'projeDar' => true],
    ['ad' => 'hukuk', 'hukuk' => true, 'projeDar' => true],
] as $alan) {
    foreach (['dr', 'docent', 'profesor'] as $kadro) {
        $cetveller["piri-reis-2025-{$alan['ad']}-{$kadro}"] = [
            'yazar_katsayisi' => $yazarKatsayisi,
            'maddeler' => $maddeler($alan['hukuk']),
            'gruplar' => [
                'A1' => ['A.1.*'],
                'A' => ['A.*'],
                'B' => ['B.*'],
                'A-B' => ['A.*', 'B.*'],
                'BILDIRI' => ['C.*', 'D.*'],
                'KITAP' => ['E.*', 'F.*'],
                'ATIF' => ['G.*'],
                'HAKEMLIK' => ['I.*'],
                'EDITORLUK' => ['J.*'],
                'TEZ' => ['K.*'],
                'PATENT' => ['L.*'],
                'ODUL' => ['M.*'],
                'EGITIM' => ['N.*'],
                'IDARI' => ['O.*'],
                'PROJE' => ['P.*'],
                'DIGER' => ['R.*'],
                'PROJE-DIGER' => ['P.*', 'R.*'],
            ],
            'grup_tavanlari' => $tavanlar($kadro, $alan['hukuk'], $alan['projeDar']),
        ];
    }
}

return ['cetveller' => $cetveller];
