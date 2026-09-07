<?php

/**
 * ERZURUM TEKNİK ÜNİVERSİTESİ — EK: Etkinlik Puanları
 * Kaynak: pdf/17536993662.erzurumteknikuniversitesi.pdf (20 sayfa,
 * yürürlük 01.01.2024)
 *
 * MADDE KODLARI YÖNERGENİN KENDİSİ (A1.1-A8, B1-B10, C1-C9, D1-D5,
 * E1.1-E8.2, F1-F7, G1-G6, H1.1-H11, K1-K14, L1-L9, M1-M3, N1-N8, O1-O12).
 * Zorunlu başvuru koşulları HARF GRUBUNA atıf yapıyor ("A grubu etkinlik
 * türünden toplamda en az 40 puan", "G grubu etkinliklerinden en fazla 10
 * puan alınabilir"), bu yüzden harfler `gruplar` altında birebir tanımlandı.
 *
 * Bize ait olan tek şey rol başına bölünen proje satırlarının ekleri
 * (`E1.1`) ve birleştirilen satırların tire ile yazılmış çift kodları
 * (`A1.4-AHCI`, `B4-B5`).
 *
 * ── A2: "A1'e GÖRE YARI PUAN" ──
 * A2 satırı kendi puanını yazmıyor, "A1 maddesindeki sınıflandırmadaki tam
 * metin yayınına göre yarı puan alır" diyor. Dört çeyreklik için ayrı ayrı
 * yarılandı ve §0 uyarınca AŞAĞI yuvarlandı: 15 / 12 / 10 / 7.
 *
 * ── AYNI KAYNAĞA DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   AHCI dergilerinin çeyrekliği kayıtta yok; A1.4'ün (Q4) değerinden
 *       sayıldı (15), A2'de de en düşük yarı puandan (7).
 *   B1/B2/B6/B7 kongre başkanlığı, oturum başkanlığı ve düzenleme kurulu
 *       üyeliği (30/20/20/10): `Diger` kategorisinin tek 'Diğer' etiketi
 *       → 10.
 *   B4 (uluslararası sözlü özet 5) ile B5 (poster 3) → 3; B9 (ulusal sözlü
 *       özet 3) ile B10 (poster 1) → 1.
 *   C5 (uluslararası ansiklopedi maddesi 30) ile C9 (ulusal 15) → 15.
 *   E2.1/E2.2 uluslararası proje hakemliği ve panel üyeliği (20/30),
 *       E4.1/E4.2 ulusal (3/5), N3 dergi hakemliği (2), N6 ulusal dergi
 *       hakemliği (1): tek 'Hakemlik' etiketi → 1.
 *   H1.1 tamamlanmış doktora tez danışmanlığı (30) ile H1.3 devam eden
 *       (15): faaliyet kaydında tezin bittiği bilgisi yok → 15. Aynı
 *       şekilde H1.2/H1.4 eş danışmanlık (10/5) → 5.
 *   K10 enstitü anabilim dalı başkanlığı (10) ile K12 anabilim dalı
 *       başkanlığı (3): tek 'Anabilim Dalı Başkanı / Koordinatörlük'
 *       etiketi → 3.
 *   L3/L7 ulusal patent (75 / ticarileşen 150) → 75; L5/L8 faydalı model
 *       (50/100) → 50; L6/L9 endüstriyel tasarım (50/100) → 50.
 *   M1/M2 firma kurmak ve ortak olmak (70/35) ile L7-L9'un ticarileşme
 *       satırları: tek 'Ticarileştirme' etiketi → 35.
 *   O2/O9 yarışma derecesi (30/10) ile O4/O10 kongre ödülü (10/5): tek
 *       'Yarışma Derecesi / Mansiyon' etiketi → 5.
 *   E7 yurt dışı araştırma bursu (20) ile O5/O6 (20/10): tek 'Burs'
 *       etiketi → 10.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   L1/L2 patent BAŞVURUSU ve E8 desteklenmeyen proje önerisi — belgeli
 *       olanla aynı kaynağa düşer, motor en yükseği seçeceği için başvuru
 *       sahibini belgeli gibi sayardı.
 *   C4 (konferans kitabı veya dergi özel sayı editörlüğü 20) — kalan
 *       editörlük etiketi yok.
 *   E6 (TEYDEB danışmanlığı 40) — E3.3'ün danışman rolüyle aynı kayda
 *       düşerdi.
 *   H8/H9 (çalıştay yürütücülüğü), H10 (bölüm içi seminer), H11 (yarışma
 *       danışmanlığı), M3 (girişimcilik sertifikası), N8 (ETÜ adresli dergi
 *       editörlüğü), O12 (ETÜ ödül yönergesi) — sözlükte karşılıksız ya da
 *       kuruma özel.
 *   Çeviri kitap ve kitap bölümü — EK'te karşılık gelen satır yok.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   K bölümünün tamamı "son 5 yıl geçerli olup YIL ÇARPANDIR" diyor
 *       (20×yıl, 15×yıl…); yıl biriktirmesi motorda yok, tek yıl değeri
 *       girildi ve kurumsal katkı puanı ÇOK DÜŞÜK görünür. Zorunlu başvuru
 *       koşullarının K barajları (10 ile 40 puan arası) bu yüzden
 *       olduğundan zor görünür.
 *   C2/C7 dipnotu "aynı eserde en fazla iki bölüm puanlanır", C5/C9
 *       dipnotu "aynı eserde en fazla iki madde" — eser bazlı tavan.
 *   H3 dipnotu "aktif görevde bulunduğu son iki yılda en fazla 30 puan" —
 *       pencere bağımlı tavan; grup tavanı olarak yazıldı ama iki yıllık
 *       pencere uygulanmıyor.
 *   E7 "her ay için 5 puan olmak üzere en fazla 20 puan" — ay biriktirmesi
 *       motorda yok.
 *
 * Yönerge: yonerge/erzurum-teknik.php
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 */
$kapsamNotu = 'Puanlar Erzurum Teknik Üniversitesi "EK: Etkinlik Puanları" listesinden. '
        .'Yazar çarpanı yönergenin çok yazarlı çalışmalar tablosuna göre işliyor (tek yazar '
        .'1,00; beşten fazla yazarlı çalışmada 0,30). Yazar listesini boş bırakırsanız çarpan '
        .'hiç uygulanmaz ve puanınız olduğundan YÜKSEK görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: KURUMSAL KATKI (K grubu) puanı '
        .'yönergede yıl çarpanıyla veriliyor (20×yıl gibi) ama yıl biriktirmesi '
        .'hesaplanamadığı için görev başına tek yıl değeri sayılıyor — K grubu barajları bu '
        .'yüzden olduğundan zor görünür. Ayrıca AHCI dergilerindeki yayınlar çeyreklik bilgisi '
        .'olmadığı için en düşük çeyreklikten; tamamlanmış ve devam eden tez danışmanlıkları '
        .'tek satırdan; kongre başkanlığı, oturum başkanlığı ve düzenleme kurulu üyeliği en '
        .'düşük değerden; bütün hakemlik kalemleri tek satırdan (1 puan) sayılıyor. Çeviri '
        .'kitap, çalıştay yürütücülüğü ve girişimcilik sertifikası kalemleri hiç girilemedi. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünebilir: aynı eserden ikiden fazla '
        .'bölümünüz varsa hepsi sayılır; ders puanının "son iki yıl" penceresi uygulanmıyor. '
        .'Patent ve proje BAŞVURULARINIZI kaydetmeyin: yönerge onlara ayrı ve düşük puan '
        .'veriyor ama kayıt türü belgeli olandan ayrılamadığı için o satırlar girilmedi.';

// "Çok Yazarlı Çalışmalarda Katkı Oranları" tablosu.
$yazarKatsayisi = [
    'haric' => ['atif', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev',
        'odul', 'editorluk', 'toplumsal_katki'],
    'roller' => (function (): array {
        $ilk = ['kademeler' => [1 => 1.00, 2 => 0.95, 3 => 0.90, 4 => 0.85, 5 => 0.80], 'sonrasi' => 0.75];

        return [
            'tek' => ['kademeler' => [1 => 1.0]],
            'ilk' => $ilk,
            'baslica' => $ilk,
            'yazar_2' => ['kademeler' => [2 => 0.85, 3 => 0.80, 4 => 0.75, 5 => 0.70], 'sonrasi' => 0.65],
            'yazar_3' => ['kademeler' => [3 => 0.75, 4 => 0.70, 5 => 0.65], 'sonrasi' => 0.60],
            'yazar_4' => ['kademeler' => [4 => 0.60, 5 => 0.55], 'sonrasi' => 0.50],
            'yazar_5' => ['kademeler' => [5 => 0.50], 'sonrasi' => 0.45],
            'yazar_6' => ['sonrasi' => 0.30],
            'ortak' => ['kademeler' => [1 => 1.00, 2 => 0.85, 3 => 0.75, 4 => 0.60, 5 => 0.50], 'sonrasi' => 0.30],
        ];
    })(),
];

$maddeler = [
    // ══ A. MAKALELER ══
    'A1.1' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya A&HCI indeksli Q1 dergide makale ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 30],
    'A1.2' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya A&HCI indeksli Q2 dergide makale ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 25],
    'A1.3' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya A&HCI indeksli Q3 dergide makale ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 20],
    'A1.4' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya A&HCI indeksli Q4 dergide makale ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 15],
    'A2.1' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya A&HCI indeksli Q1 dergide editöre mektup, özet, teknik not veya vaka incelemesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 15],
    'A2.2' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya A&HCI indeksli Q2 dergide editöre mektup, özet, teknik not veya vaka incelemesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 12],
    'A2.3' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya A&HCI indeksli Q3 dergide editöre mektup, özet, teknik not veya vaka incelemesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 10],
    'A2.4' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya A&HCI indeksli Q4 dergide editöre mektup, özet, teknik not veya vaka incelemesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 7],
    'A3' => ['baslik' => 'ÜAK ya da Senato tarafından tanımlanan alan indeksli uluslararası dergide yayın', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 12],
    'A4' => ['baslik' => 'ÜAK ya da Senato tarafından tanımlanan alan indeksli uluslararası dergide editöre mektup, özet, teknik not veya vaka incelemesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 8],
    'A5' => ['baslik' => 'Diğer indekslerce taranan uluslararası dergide yayın', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 6],
    'A6' => ['baslik' => 'Diğer indekslerce taranan uluslararası dergide editöre mektup, özet, teknik not veya vaka incelemesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 4],
    'A7' => ['baslik' => 'Üniversitelerarası Kurulun tanımladığı ulusal hakemli dergide yayın', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 8],
    'A8' => ['baslik' => 'Ulusal hakemli dergide yayın', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 6],

    // ══ B. KONGRE ÇALIŞMALARI ══
    'B1-B7' => ['baslik' => 'Hakemli konferansta kongre başkanlığı, oturum başkanlığı ya da düzenleme kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Diğer', 'Toplantı Düzenleme Başkanlığı (Uluslararası)', 'Toplantı Düzenleme Başkanlığı (Ulusal)', 'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)', 'Oturum Başkanlığı (Uluslararası)', 'Oturum Başkanlığı (Ulusal)'], 'puan' => 10],
    'B3' => ['baslik' => 'Uluslararası hakemli konferansta sunulan ve tam metin yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 10],
    'B4-B5' => ['baslik' => 'Uluslararası hakemli konferansta özet olarak yayımlanan ya da poster olarak sunulan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 3],
    'B8' => ['baslik' => 'Ulusal hakemli konferansta sunulan ve tam metin yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 5],
    'B9-B10' => ['baslik' => 'Ulusal hakemli konferansta özet olarak yayımlanan ya da poster olarak sunulan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 1],
    'B-DAVETLI' => ['baslik' => 'Hakemli konferansta davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 10],

    // ══ C. KİTAPLAR ══
    'C1' => ['baslik' => 'Uluslararası yayınevince yayımlanan bilimsel, mesleki veya ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 60],
    'C2' => ['baslik' => 'Uluslararası yayınevince yayımlanan kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 30],
    'C3' => ['baslik' => 'Uluslararası yayınevince yayımlanan bilimsel kitabın editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 25],
    'C5-C9' => ['baslik' => 'Bilimsel nitelikli ansiklopedide madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 15],
    'C6' => ['baslik' => 'Ulusal yayınevince yayımlanan bilimsel, mesleki veya ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı'], 'puan' => 40],
    'C7' => ['baslik' => 'Ulusal yayınevince yayımlanan kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 20],
    'C8' => ['baslik' => 'Ulusal yayınevince yayımlanan bilimsel kitabın editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 15],

    // ══ D. TASARIM VE SANAT ETKİNLİKLERİ ══
    'D1' => ['baslik' => 'Mimari proje, rölöve, restitüsyon veya restorasyon projesinde müellif', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif', 'Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)'], 'puan' => 20],
    'D2' => ['baslik' => 'Mimari proje, rölöve, restitüsyon veya restorasyon projesinde ekip üyeliği ya da danışmanlık', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman'], 'puan' => 10],
    'D3' => ['baslik' => 'Bilimsel yayınla tescillenmiş tasarım veya proje', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)', 'Özgün Eser / Beste / Tasarım'], 'puan' => 20],
    'D4' => ['baslik' => 'Alanınızda özgün proje, tasarım ya da eserle uluslararası sergiye katılım', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Uluslararası)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt Dışı)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Elektronik Karma Sergi (Uluslararası)'], 'puan' => 10],
    'D5' => ['baslik' => 'Alanınızda özgün proje, tasarım ya da eserle ulusal sergiye katılım', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Karma/Jürili Etkinlik (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Eserin Müzeye Kabulü (Yurt İçi)', 'Elektronik Kişisel Sergi (Ulusal)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 6],

    // ══ E. ARAŞTIRMA PROJELERİ ══
    'E1.1' => ['baslik' => 'Uluslararası kuruluşça desteklenen projede yürütücü ya da koordinatör', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 100],
    'E1.2' => ['baslik' => 'Uluslararası kuruluşça desteklenen projede araştırmacı, uzman veya bursiyer', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 50],
    'E3.1' => ['baslik' => 'TÜBİTAK, bakanlık ya da kurum dışı destekli projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 70],
    'E3.2' => ['baslik' => 'TÜBİTAK, bakanlık ya da kurum dışı destekli projede araştırmacı, uzman veya bursiyer', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 35],
    'E3.3' => ['baslik' => 'TÜBİTAK, bakanlık ya da kurum dışı destekli projede danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['danisman'], 'puan' => 15],
    'E5.1' => ['baslik' => 'Üniversite BAP birimince desteklenen temel araştırma projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 10],
    'E5.2' => ['baslik' => 'Üniversite BAP birimince desteklenen temel araştırma projesinde araştırmacı, uzman veya bursiyer', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 5],

    // ══ F. SOSYAL SORUMLULUK PROJELERİ ══
    'F' => ['baslik' => 'Sosyal sorumluluk kapsamındaki projede yürütücü, araştırmacı ya da danışman', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi', 'Kamu/STK Danışmanlığı', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 3],

    // ══ G. ATIFLAR ══
    'G1' => ['baslik' => 'SSCI, SCI, SCI-Expanded veya AHCI tarafından taranan dergilerdeki yayınlarda atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 5],
    'G2-G4' => ['baslik' => 'Diğer uluslararası ya da bilimsel dergilerdeki yayınlarda atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],
    'G3' => ['baslik' => 'Ulusal dergilerdeki yayınlarda atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
    'G5-G6' => ['baslik' => 'Yayımlanan kitaplarda atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 3],

    // ══ H. EĞİTİM ETKİNLİKLERİ ══
    'H1.1' => ['baslik' => 'Doktora tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 15],
    'H1.2' => ['baslik' => 'Doktora tez eş danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 5],
    'H2.1' => ['baslik' => 'Tamamlanmış yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 15],
    'H2.2' => ['baslik' => 'Tamamlanmış yüksek lisans tez eş danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'roller' => ['es_danisman'], 'puan' => 5],
    'H3.1' => ['baslik' => 'Lisansüstü programda verilen her bir ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 5],
    'H3.2' => ['baslik' => 'Lisans veya hazırlık programında verilen her bir ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 3],
    'H5-H7' => ['baslik' => 'Sertifika programı ya da toplumsal katkıyı önceleyen eğitim faaliyeti düzenlemek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Akreditasyon Faaliyeti'], 'puan' => 5],

    // ══ K. KURUMSAL KATKI (yıl çarpanı uygulanamadı, tek yıl değeri) ══
    'K1' => ['baslik' => 'Rektörlük ya da rektör yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı'], 'puan' => 20],
    'K3' => ['baslik' => 'Dekanlık, enstitü ya da yüksekokul müdürlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü'], 'puan' => 15],
    'K4' => ['baslik' => 'Uygulama ve araştırma merkezi müdürlüğü ya da koordinatörlük', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 10],
    'K5' => ['baslik' => 'Dekan yardımcılığı, enstitü ya da yüksekokul müdür yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 10],
    'K7' => ['baslik' => 'Kurul üyelikleri', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 3],
    'K9' => ['baslik' => 'Bölüm başkanlığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 10],
    'K11' => ['baslik' => 'Bölüm başkan yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı'], 'puan' => 5],
    'K10-K12' => ['baslik' => 'Anabilim dalı başkanlığı ya da koordinatörlük', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 3],

    // ══ L. FİKRİ VE SINAİ MÜLKİYET (başvuru satırları girilmedi) ══
    'L3' => ['baslik' => 'Ulusal patent belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 75],
    'L4' => ['baslik' => 'Uluslararası patent belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 150],
    'L5' => ['baslik' => 'Faydalı model belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 50],
    'L6' => ['baslik' => 'Endüstriyel tasarım belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım', 'Yazılım'], 'puan' => 50],
    'M1-M2' => ['baslik' => 'Firma kurmak ya da firma ortağı olmak', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 35],

    // ══ N. ÜYELİK VE HAKEMLİK ══
    'N1' => ['baslik' => 'Q1, Q2 veya Q3 kategorisindeki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)'], 'puan' => 30],
    'N2' => ['baslik' => 'Q4 kategorisindeki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q4)'], 'puan' => 10],
    'N3-N6' => ['baslik' => 'Dergi hakemliği, proje hakemliği ya da panel üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik', 'Yayın Kurulu Üyeliği'], 'puan' => 1],
    'N4' => ['baslik' => 'Uluslararası mimarlık, planlama, sanat ve tasarım etkinliklerinde jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], 'puan' => 10],
    'N5' => ['baslik' => 'Üniversitelerarası Kurulun tanımladığı dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi', 'TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 15],
    'N7' => ['baslik' => 'Ulusal mimarlık, planlama, sanat ve tasarım etkinliklerinde jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 5],

    // ══ O. ÖDÜLLER ══
    'O1' => ['baslik' => 'Sürekli olarak verilen jürili uluslararası bilim veya sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü'], 'puan' => 100],
    'O3' => ['baslik' => 'Tanınmış uluslararası kuruluşlarca verilen ödül', 'kategori' => 'odul', 'kaynaklar' => ['Ufuk Avrupa / ERC Ödülü'], 'puan' => 20],
    'O2-O10' => ['baslik' => 'Yarışmada dereceye girmek ya da bilimsel etkinlikten ödül almak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 5],
    'O5-O6' => ['baslik' => 'Uluslararası eğitim veya araştırma bursu', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 10],
    'O7' => ['baslik' => 'TÜBİTAK veya TÜBA bilim ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü'], 'puan' => 80],
    'O8' => ['baslik' => 'TÜBİTAK veya TÜBA teşvik ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 40],
    'O11' => ['baslik' => 'Tanınmış ulusal kuruluşlarca verilen ödül', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'YÖK Ödülü'], 'puan' => 10],
];

// Zorunlu başvuru koşullarının andığı harf grupları.
$gruplar = [
    'A' => ['A1.*', 'A2.*', 'A3', 'A4', 'A5', 'A6', 'A7', 'A8'],
    'A1' => ['A1.*'],
    'A1-A3' => ['A1.*', 'A2.*', 'A3'],
    'B' => ['B*'],
    'C' => ['C*'],
    'D' => ['D*'],
    'E' => ['E*'],
    'F' => ['F'],
    'G' => ['G*'],
    'H' => ['H*'],
    'H1' => ['H1.*'],
    'H2' => ['H2.*'],
    'H1-H2' => ['H1.*', 'H2.*'],
    'H3' => ['H3.*'],
    'K' => ['K*'],
    'L' => ['L*'],
    'M' => ['M1-M2'],
    'E-M' => ['E*', 'M1-M2'],
    'N' => ['N*'],
    'O' => ['O*'],
];

/**
 * TAVANLAR (BİRİM × KADRO) MATRİSİ.
 *
 * Zorunlu başvuru koşulları tablosu her fakülte için dört kadro sütunu
 * veriyor ve tavanları koşul metninin İÇİNE yazıyor ("G grubu
 * etkinliklerinden en az 10 puan almış olmak. Bu gruptan en fazla 20 puan
 * alınabilir."). Kaynağın sütun düzeni iç içe geçtiği için `pdftotext`
 * güvenilir okumuyor — parantez içindeki tavanları büsbütün atlıyor. Yedi
 * fakülte sayfası 170 dpi görüntüye çevrilip GÖZLE okundu.
 *
 * EĞİTİM (H) VE KURUMSAL KATKI (K) TAVANI YEDİ FAKÜLTEDE DE AYNI, yalnız
 * kadroya göre değişiyor. ATIF (G) ise hem birime hem kadroya bağlı; bu
 * yüzden cetvel (birim × kadro) varyantlarıyla üretiliyor.
 *
 * @var array<string, array<string, int>>
 */
$kadroTavani = [
    'profesorluk' => ['H' => 150],
    'docentlik' => ['H' => 40, 'K' => 30],
    'dr_ogr_uyesi' => [],
    'dr_ogr_uyesi_yeniden' => ['H' => 30, 'K' => 20],
];

/**
 * Atıf (G) tavanı: birim → kadro → tavan. Hücre yoksa yönerge o kadroda G'ye
 * üst sınır koymuyor, yalnız alt baraj var.
 *
 * @var array<string, array<string, int>>
 */
$gTavani = [
    'edebiyat' => ['profesorluk' => 20, 'docentlik' => 20, 'dr_ogr_uyesi' => 10, 'dr_ogr_uyesi_yeniden' => 10],
    'fen-matematik' => ['profesorluk' => 30, 'docentlik' => 30, 'dr_ogr_uyesi' => 20],
    'fen-diger' => ['profesorluk' => 100, 'docentlik' => 30, 'dr_ogr_uyesi' => 20],
    'iibf' => ['profesorluk' => 20, 'docentlik' => 20, 'dr_ogr_uyesi' => 20],
    'mimarlik' => ['dr_ogr_uyesi' => 20, 'dr_ogr_uyesi_yeniden' => 20],
    'muhendislik' => ['profesorluk' => 100, 'docentlik' => 30, 'dr_ogr_uyesi' => 20],
    'saglik' => ['profesorluk' => 100, 'docentlik' => 30, 'dr_ogr_uyesi' => 20],
    'spor' => ['profesorluk' => 20, 'docentlik' => 20, 'dr_ogr_uyesi' => 20],
    'yabanci-diller' => ['profesorluk' => 20, 'docentlik' => 20, 'dr_ogr_uyesi_yeniden' => 10],
];

$cetveller = [];

foreach ($gTavani as $birim => $kadrolar) {
    foreach (array_keys($kadroTavani) as $kadro) {
        // H3'ün kendi dipnotu kadrodan bağımsız: "aktif görevde bulunduğu son
        // iki yılda en fazla 30 puan".
        $tavan = $kadroTavani[$kadro] + ['H3' => 30];

        if (isset($kadrolar[$kadro])) {
            $tavan['G'] = $kadrolar[$kadro];
        }

        $cetveller["erzurum-teknik-2024-{$birim}-{$kadro}"] = [
            'kapsam_notu' => $kapsamNotu,
            'yazar_katsayisi' => $yazarKatsayisi,
            'maddeler' => $maddeler,
            'gruplar' => $gruplar,
            'grup_tavanlari' => $tavan,
        ];
    }
}

return ['cetveller' => $cetveller];
