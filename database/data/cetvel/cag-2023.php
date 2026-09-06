<?php

/**
 * ÇAĞ ÜNİVERSİTESİ — Ek-1 puanlama sistemi
 * Kaynak: pdf/17537097722.caguniversitesi.pdf (11 sayfa;
 * Senato 15.05.2023 tarih ve 2023/11 sayılı karar, 01.06.2023'te yürürlükte)
 *
 * PDF'in başlık fontunda sistematik harf ikamesi var (İ→Ġ, Ş→Ģ, ş→ġ);
 * metin çıkarılırken düzeltildi, gövde ve puanlar zaten temiz.
 *
 * Madde kodları tablonun kendi harfleri (A-U), alt satırlar numaralandı.
 *
 * ── EN ÇOK PUAN KAYBETTİREN KARARLAR ──
 *   KISA BİLDİRİ, TEKNİK NOT, TARTIŞMA VE EDİTÖRE MEKTUP İÇİN
 *       TANIMLANAN %60 KURALI UYGULANMIYOR. Yönerge bu yayınları A
 *       bölümünün puanının %60'ıyla değerlendiriyor (SCIE makalesinde
 *       9 puan), ama A-5 ile D'nin üçüncü satırı kitap eleştirilerine 2
 *       ve 1 puan veriyor. Kayıt kitap eleştirisini kısa bildiriden
 *       ayırmadığı için §0 uyarınca DÜŞÜK olan kitap eleştirisi satırı
 *       alındı. Kısa bildiri ya da teknik notunuz varsa puanınız
 *       OLDUĞUNDAN ÇOK DÜŞÜK görünür (SCIE'de 9 yerine 2).
 *   U BÖLÜMÜNÜN "EĞİTİME KATKI" SATIRI (kredi başına 0,5) GİRİLMEDİ:
 *       hem ondalık hem kredi bazlı, motorun puan alanı tam sayı tutuyor.
 *   İDARİ GÖREV PUANLARI YIL SAYISIYLA ÇARPILMIYOR. Yönerge üst düzey
 *       yöneticiliğe 10 × yıl, yöneticiliğe 5 × yıl, kurul üyeliğine
 *       3 × yıl veriyor; motor bir görev kaydına tek puan verebiliyor.
 *       Beş yıllık dekanlık 50 değil 10 puan görünür.
 *   T BÖLÜMÜ (bilimsel toplantı düzenleme; uluslararası yürütücülük 20,
 *       üyelik 5, ulusal 10 ve 2, seçici kurul üyeliği 5 ve 2) GİRİLMEDİ:
 *       düzenleme kurulu üyeliğinin kayıtta karşılığı olan etiket yok.
 *   LİSANSÜSTÜ TEZDEN ÜRETİLMİŞ YAYIN kategorisinin cetvelde satırı yok.
 *
 * ── AYNI ETİKETE DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   C bölümü "uluslararası kitap" (20), F bölümü "ulusal kitap" (15)
 *       diyor; BKCI/Scopus etiketi C'den, öteki kitap etiketleri F'den
 *       sayılıyor.
 *   I uluslararası dergi hakemliği (3) ile J ulusal dergi ve konferans
 *       hakemliği (1) tek "Hakemlik" etiketine düşüyor: 1'den sayılıyor.
 *   K uluslararası yayın kurulu üyeliği (15) ile L ulusal (5) tek
 *       etikette: 5'ten sayılıyor.
 *   R bölümünde uluslararası yarışma derecesi (10), mansiyonu (4), ulusal
 *       derece (5) ve mansiyon (2) tek etikete düşüyor: 2'den sayılıyor.
 *   P bölümünde yurt içi patent, faydalı model, endüstriyel tasarım ve
 *       yazılım tek satırdan (25) sayılıyor.
 *
 * ── YAZAR ÇARPANI ──
 * MADDE 18: "her bir yazarın alacağı puan, temel puanın yazar sayısına
 * bölünmesi suretiyle bulunur." Sıraya göre ayrım yok; çarpan rol
 * tablosuz tek kural (1/n) olarak yazıldı.
 *
 * Yönerge: yonerge/cag.php
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 */
$SCI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)'];
$OZGUN = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];
$A_TURU = ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'];
$B_TURU = ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'BAP (Üniversite)'];
$C_TURU = ['Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'];

$maddeler = [
    // ══ A. BİLİMSEL ÇALIŞMALAR / YAYINLAR ══
    'A1' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI kapsamındaki dergilerde yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => [...$SCI, 'AHCI'], 'turler' => $OZGUN, 'puan' => 15],
    'A2' => ['baslik' => 'ISI Database indeksleri, SCOPUS ya da ERIC kapsamındaki dergilerde yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $OZGUN, 'puan' => 9],
    'A3' => ['baslik' => 'Diğer uluslararası hakemli dergilerde yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $OZGUN, 'puan' => 5],
    'A4' => ['baslik' => 'ULAKBİM TR Dizin kapsamındaki dergilerde yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $OZGUN, 'puan' => 6],
    'A5' => ['baslik' => 'Uluslararası hakemli dergilerde yayımlanan kitap eleştirisi, kısa bildiri, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => [...$SCI, 'AHCI', 'ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 2],

    // ══ D. ULUSAL MAKALELER ══
    'D2' => ['baslik' => 'Diğer ulusal hakemli dergilerde yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $OZGUN, 'puan' => 4],
    'D3' => ['baslik' => 'Ulusal hakemli dergilerde yayımlanan kitap eleştirisi ya da yargısal karar tahlili', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 1],

    // ══ B. ULUSLARARASI BİLDİRİLER — E. ULUSAL BİLDİRİLER ══
    'B1' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan, bildiriler kitabında yayımlanmış tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 4],
    'B2' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan poster ya da sözlü sunum', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 1],
    'B3' => ['baslik' => 'Keynote speaker ya da davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 2],
    'E1' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan, bildiriler kitabında yayımlanmış tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 3],
    'E2' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan poster ya da sözlü sunum', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 1],

    // ══ C. ULUSLARARASI KİTAP — F. ULUSAL KİTAP ══
    'C1' => ['baslik' => 'Uluslararası yayınevi tarafından basılmış kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
    'C2' => ['baslik' => 'Uluslararası yayınevi kitabında makale ya da bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 10],
    'F1' => ['baslik' => 'Ulusal yayınevi tarafından basılmış kitap yazarlığı (ders notu hariç)', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı', 'Tahkik (Tenkitli Metin)'], 'puan' => 15],
    'F2' => ['baslik' => 'Ulusal yayınevi kitabında makale ya da bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 5],
    'F4' => ['baslik' => 'Çeviri kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap', 'Çeviri Kitap Bölümü'], 'puan' => 4],
    'C3' => ['baslik' => 'Uluslararası yayınevi kitabında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 10],
    'F3' => ['baslik' => 'Ulusal yayınevi kitabında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 5],

    // ══ G. BASILMIŞ BİLİMSEL RAPOR ══
    'G' => ['baslik' => 'Uluslararası ya da ulusal kuruluşlarca desteklenen araştırmanın bu kuruluşlarca basılmış bilimsel raporu (TÜBİTAK, NATO vb.)', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 5],

    // ══ H. ATIFLAR ══
    'H1' => ['baslik' => 'A, B ve C kategorilerindeki yayınlardan eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 2],
    'H2' => ['baslik' => 'D, E ve F kategorilerindeki yayınlardan eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 1],

    // ══ I-J. HAKEMLİK — K-L. YAYIN KURULU — M-N. EDİTÖRLÜK ══
    'J' => ['baslik' => 'Uluslararası konferans ya da ulusal dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 1],
    'L' => ['baslik' => 'Hakemli dergilerin yayın kurulu üyeliği (Editorial Board)', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 5],
    'M' => ['baslik' => 'Uluslararası hakemli dergi editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 20],
    'N' => ['baslik' => 'Ulusal hakemli dergi editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 10],

    // ══ O. TEZ YÖNETİMİ ══
    'O1' => ['baslik' => 'Danışman ya da eş danışman olarak tamamlanmış doktora tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman', 'es_danisman'], 'puan' => 6],
    'O2' => ['baslik' => 'Danışman ya da eş danışman olarak tamamlanmış yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman', 'es_danisman'], 'puan' => 3],

    // ══ P. PATENTLER ══
    'P1' => ['baslik' => 'Yurt dışı patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 50],
    'P2' => ['baslik' => 'Yurt içi patent, faydalı model, endüstriyel tasarım ya da yazılım', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili', 'Ticarileştirme'], 'puan' => 25],

    // ══ R. ÖDÜLLER ══
    'R1' => ['baslik' => 'Sürekli ve periyodik olarak verilen jürili uluslararası bilim ödülü ya da TÜBİTAK/TÜBA Bilim Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 40],
    'R2' => ['baslik' => 'Sürekli ve periyodik olarak verilen TÜBİTAK/TÜBA Teşvik Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 25],
    'R3' => ['baslik' => 'Burs ya da fellowship (Post-Doc, Visiting Scholarship, Fulbright, grant vb.)', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 20],
    'R4' => ['baslik' => 'Sürekli ve periyodik olarak verilen jürili ulusal bilim ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'YÖK Ödülü'], 'puan' => 10],
    'R5' => ['baslik' => 'Yarışmada derece ya da mansiyon', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 2],
    'R6' => ['baslik' => 'Yarışma jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 2],

    // ══ S. ARAŞTIRMA PROJELERİ ══
    'S1' => ['baslik' => 'A türü projede (AB, NATO-SFS, COST, EUREKA, UN, NSF vb.) yürütücülük', 'kategori' => 'proje', 'kaynaklar' => $A_TURU, 'roller' => ['yurutucu'], 'puan' => 30],
    'S2' => ['baslik' => 'A türü projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => $A_TURU, 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 20],
    'S3' => ['baslik' => 'A türü projede danışmanlık', 'kategori' => 'proje', 'kaynaklar' => $A_TURU, 'roller' => ['danisman'], 'puan' => 10],
    'S4' => ['baslik' => 'B türü projede (TÜBİTAK, TTGV, DPT, araştırma fonu vb.) yürütücülük', 'kategori' => 'proje', 'kaynaklar' => $B_TURU, 'roller' => ['yurutucu'], 'puan' => 15],
    'S5' => ['baslik' => 'B türü projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => $B_TURU, 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 10],
    'S6' => ['baslik' => 'B türü projede danışmanlık', 'kategori' => 'proje', 'kaynaklar' => $B_TURU, 'roller' => ['danisman'], 'puan' => 5],
    'S7' => ['baslik' => 'C türü (diğer yurt içi) projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => $C_TURU, 'roller' => ['yurutucu'], 'puan' => 6],
    'S8' => ['baslik' => 'C türü (diğer yurt içi) projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => $C_TURU, 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 4],
    'S9' => ['baslik' => 'C türü (diğer yurt içi) projede danışmanlık', 'kategori' => 'proje', 'kaynaklar' => $C_TURU, 'roller' => ['danisman'], 'puan' => 2],

    // ══ U. DİĞER AKADEMİK FAALİYETLER ══
    'U2' => ['baslik' => 'Üniversitelerde üst düzey yöneticilik (rektör, rektör yardımcısı, genel sekreter, dekan, yüksekokul ya da enstitü müdürü)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü'], 'puan' => 10],
    'U3' => ['baslik' => 'Üniversitelerde yöneticilik (koordinatörlük, bölüm başkanlığı, dekan yardımcılığı, merkez müdürlüğü vb.)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkanı', 'Bölüm Başkan Yardımcısı', 'Uygulama ve Araştırma Merkezi Müdürü', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 5],
    'U4' => ['baslik' => 'Üniversitelerde komisyon ya da kurul üyelikleri', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği', 'Senato / Üniversite Yönetim Kurulu Üyesi'], 'puan' => 3],
    'U5' => ['baslik' => 'Sosyal sorumluluk projesi yürütücülüğü', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi'], 'puan' => 3],
    'TOPLANTI-UYE' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 5],
];

return [
    'kapsam_notu' => 'Puanlar Çağ Üniversitesi Öğretim Üyeliğine Yükseltilme ve Atanma '
        .'Yönergesinin Ek-1 puanlama sisteminden. Yazar çarpanı MADDE 18: çok yazarlı '
        .'çalışmalarda puan yazar sayısına bölünür, sıraya göre ayrım yok. Yazar listesini boş '
        .'bırakırsanız çarpan hiç uygulanmaz ve puanınız olduğundan YÜKSEK görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: yönergenin kısa bildiri, teknik not, '
        .'tartışma ve editöre mektup için tanımladığı %60 kuralı uygulanmıyor — kayıt bunları '
        .'kitap eleştirisinden ayırmadığı için A-5\'in 2 puanlık (ulusalda 1 puanlık) satırı '
        .'kullanılıyor, SCIE\'de olması gereken 9 puan yerine 2 puan görürsünüz. İdari görev '
        .'puanları yıl sayısıyla ÇARPILMIYOR: beş yıllık bir dekanlık 50 değil 10 puan sayılıyor. '
        .'U bölümünün "eğitime katkı" satırı (kredi başına 0,5) hem ondalık hem kredi bazlı '
        .'olduğu için girilmedi; T bölümü (bilimsel toplantı düzenleme ve seçici kurul üyeliği) '
        .'ile lisansüstü tezden üretilmiş yayın kategorisinin de cetvelde karşılığı yok. '
        .'Uluslararası dergi hakemliği (3), uluslararası yayın kurulu üyeliği (15) ve yarışma '
        .'dereceleri (10\'a kadar) ulusal karşılıklarından ayrılamadığı için en düşükten '
        .'(1, 5 ve 2) sayılıyor. "Uluslararası yayınevi" ile "ulusal yayınevi" ayrımı kayıtta '
        .'olmadığından BKCI ve Scopus kitapları uluslararası (20/10), öteki kitaplar ulusal '
        .'(15/5) satırından sayılıyor.',

    'yazar_katsayisi' => [
        'haric' => ['atif', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev', 'odul',
            'editorluk', 'toplumsal_katki', 'proje', 'patent', 'sanatsal_etkinlik', 'diger'],
        'bol' => ['pay' => 1.0],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        'TUM' => array_keys($maddeler),
        // MADDE 6/2: "A, B, C, D, E, F, G, H maddelerinde tanımlanmış etkinlikler".
        'ABCDEFGH' => ['A1', 'A2', 'A3', 'A4', 'A5', 'B1', 'B2', 'B3', 'C1', 'C2', 'C3',
            'D2', 'D3', 'E1', 'E2', 'F1', 'F2', 'F3', 'F4', 'G', 'H1', 'H2'],
        'A5' => ['A5'],
        'B3' => ['B3'],
        'D3' => ['D3'],
        'O1' => ['O1'],
        'O2' => ['O2'],
    ],

    'grup_tavanlari' => [
        'A5' => 6,  // A-5: en fazla 6 puan
        'B3' => 4,  // B: keynote/davetli konuşmacı en fazla 4 puan
        'D3' => 3,  // D: kitap eleştirisi ve yargısal karar tahlili en fazla 3'er puan
        'O1' => 30, // O: doktora en fazla 5 tez × 6 puan
        'O2' => 15, // O: yüksek lisans en fazla 5 tez × 3 puan
    ],
];
