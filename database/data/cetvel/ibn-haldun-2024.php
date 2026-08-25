<?php

/**
 * İBN HALDUN ÜNİVERSİTESİ — D. FAALİYET PUANLARI
 * Kaynak: pdf/17537098452.ibnhaldununiversitesi.pdf
 *
 * İKİ CETVEL BİR DOSYADA. Tablonun iki puan sütunu var ve fark yalnızca
 * SANATSAL bölümde: 2.1 ve 2.2 kalemleri "İİF, İTBF, HF, EBF, YBF, MEDİT"
 * sütununda **GD (Geçerli Değil)**, "MTGF, İF" sütununda puanlı. Yayın
 * kalemlerinin puanı iki sütunda birebir aynı.
 *
 *   ibn-haldun-2024          İslami İlimler, İnsan ve Toplum, Hukuk, Eğitim,
 *                            Yönetim Bilimleri, MEDİT (sanatsal kalemler yok)
 *   ibn-haldun-2024-sanat    Mimarlık-Tasarım-Güzel Sanatlar ve İletişim
 *
 * ── DERGİ GRUPLARI ÇEYREKLİĞE BAĞLI (dipnot d) ──
 * "A, B, C ve D grubu yayınlar, WOS/JCR sınıflandırmasına göre birinci
 * çeyrekte ise A, ikinci çeyrekte ise B, üçüncü çeyrekte ise C ve dördüncü
 * çeyrekte ise D grubu olarak sınıflandırılır." E grubu (dipnot e) en az üç
 * uluslararası alan endeksi tarafından taranan dergiler — Scopus da o listede,
 * bu yüzden 'ESCI / Scopus' E grubuna bağlandı.
 *
 * AHCI'nin çeyrekliği yok; JCR sınıflandırmasına girmediği için en düşük
 * indeksli satıra (E, 15 puan) kondu — adayın puanını fazla göstermeyen taraf.
 *
 * ── ATIF PUANLARI KESİRLİ ──
 * 1.1.10.1 WOS atfı 0,5 · 1.1.10.2 ve 1.2.10.1 diğer endeksler 0,2 puan.
 * Motor tam sayı tuttuğu için ÜÇÜ DE 0'a yuvarlandı: atıflarınız bu cetvelde
 * puan getirmez. Toplam barajları 150-250 arasında olduğu için etki sınırlı
 * ama yönü belli — puan DÜŞÜK görünür.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   1.1.1.6         editöre mektup, teknik not, vaka analizi — makale
 *                   türlerinden ayrı satır ama tür bilgisi çeyreklikle
 *                   birleşince kaynak sözlüğünde karşılık kalmıyor.
 *   1.1.8.1/1.2.8.1 tarihi eserlerin latinizasyonu (300 sayfa başına).
 *   1.1.9/1.2.9     makale ve kitap bölümü çevirileri (1 puan).
 *   1.1.11/1.2.11   başkalarının çalışmaları hakkında kritik.
 *   1.1.7/1.2.7     dergi özel sayısı ve konferans kitapçığı editörlüğü —
 *                   sözlük özel sayı editörlüğünü ayırmıyor, kitap
 *                   editörlüğü satırları kullanıldı.
 *   Proje, patent, idari görev ve ders bölümleri TABLODA HİÇ YOK; o
 *   kategorilerdeki kayıtlar 0 puan alır.
 *
 * Yönerge: yonerge/ibn-haldun.php
 */
$kapsamNotu = 'Puanlar İbn Haldun Üniversitesi Faaliyet Puanları tablosundan. '
    .'Çok yazarlı çalışmalarda puan yönergenin dipnotuna göre azaltılır (iki kişi 0,8; üç kişi '
    .'0,6; üçten fazla 0,5) ve bu yalnızca yazar listesini doldurduğunuzda uygulanabiliyor; '
    .'liste boşsa çarpan uygulanmaz ve puanınız olduğundan yüksek görünür. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: atıf puanları yönergede kesirli '
    .'(WoS 0,5; diğer endeksler 0,2) ve motor tam sayı tuttuğu için sıfıra yuvarlandı, '
    .'atıflarınız puan getirmiyor. Çeviriler, kritikler, dergi özel sayısı editörlüğü ve '
    .'tarihi eser latinizasyonu kaynakta ayrılamadığı için girilmedi. AHCI dergilerinin '
    .'çeyrekliği olmadığı için en düşük indeks satırına kondu. '
    .'Yönergenin tablosunda PROJE, PATENT, İDARİ GÖREV ve DERS bölümü hiç yok; o '
    .'kayıtlarınız puan getirmez.';

// ── ORTAK GÖVDE: yayın kalemleri iki sütunda da aynı ────────────────────────
$maddeler = [
    // ══ 1.1 ULUSLARARASI ══
    // 1.1.1 Dergi makaleleri — A/B/C/D çeyreklik, E alan endeksi.
    '1.1.1.1' => ['baslik' => 'WoS birinci çeyrek (Q1) dergide tam metin makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'puan' => 35],
    '1.1.1.2' => ['baslik' => 'WoS ikinci çeyrek (Q2) dergide tam metin makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'puan' => 30],
    '1.1.1.3' => ['baslik' => 'WoS üçüncü çeyrek (Q3) dergide tam metin makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'puan' => 25],
    '1.1.1.4' => ['baslik' => 'WoS dördüncü çeyrek (Q4) dergide tam metin makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'puan' => 20],
    '1.1.1.5' => ['baslik' => 'En az üç uluslararası alan endeksinde taranan dergide tam metin makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'AHCI', 'Diğer Uluslararası İndeks'], 'puan' => 15],

    // 1.1.2 Kitaplar
    '1.1.2.1' => ['baslik' => 'Tanınmış uluslararası yayınevinde bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 40],
    '1.1.2.2' => ['baslik' => 'Tanınmış yayınevinde tarihi yazma eserin tahkikli neşri', 'kategori' => 'kitap', 'kaynaklar' => ['Tahkik (Tenkitli Metin)'], 'puan' => 35],
    '1.1.2.3' => ['baslik' => 'Tanınmış uluslararası yayınevinde mesleki kitap veya ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 30],

    // 1.1.3 Kitap bölümleri
    '1.1.3.1' => ['baslik' => 'Uluslararası bilimsel kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 15],
    '1.1.3.3' => ['baslik' => 'Ansiklopedi konu veya madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 5],

    // 1.1.4 Kitap editörlüğü
    '1.1.4.1' => ['baslik' => 'Uluslararası bilimsel kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 15],

    // 1.1.5-1.1.6 Konferans
    '1.1.5.1' => ['baslik' => 'Uluslararası hakemli konferansta tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 6],
    '1.1.5.2' => ['baslik' => 'Uluslararası hakemli konferansta bildiri özeti', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 3],
    '1.1.6.1' => ['baslik' => 'Uluslararası konferansta sunulmuş basılmamış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 2],

    // 1.1.8 Kitap çevirisi
    '1.1.8.2' => ['baslik' => 'Tercüme edilip yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 15],

    // 1.1.10 Atıflar — yönergede 0,5 ve 0,2; motor tam sayı tuttuğu için 0.
    '1.1.10.1' => ['baslik' => 'WoS kapsamındaki yayınlarda yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 0],
    '1.1.10.2' => ['baslik' => 'Diğer atıf endekslerindeki yayınlarda yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 0],

    // ══ 1.2 ULUSAL ══
    '1.2.1.1' => ['baslik' => 'ULAKBİM taranan ulusal hakemli dergide tam metin makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'puan' => 10],
    '1.2.2.1' => ['baslik' => 'Tanınmış ulusal yayınevinde bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 25],
    '1.2.3.1' => ['baslik' => 'Ulusal bilimsel kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 6],
    '1.2.4.1' => ['baslik' => 'Ulusal bilimsel kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 8],
    '1.2.5.1' => ['baslik' => 'Ulusal hakemli konferansta tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 3],
    '1.2.5.2' => ['baslik' => 'Ulusal hakemli konferansta bildiri özeti', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 1],
    '1.2.8.2' => ['baslik' => 'Tercüme edilip yayımlanmış ulusal kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 10],

    // Tez danışmanlığı tabloda puanlı satır olarak YOK; koşullar sayı
    // istiyor. Kod yalnızca sayının çözülebilmesi için duruyor, puanı 0.
    'TEZ' => ['baslik' => 'Tamamlanmış lisansüstü tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi', 'Yüksek Lisans Tezi'], 'roller' => ['danisman', 'es_danisman'], 'puan' => 0],
];

// ── 2. SANATSAL FAALİYETLER (yalnızca MTGF ve İF) ───────────────────────────
$sanatsal = [
    '2.1.1' => ['baslik' => 'Özgün sanat eserinin yurt dışında satın alınması, yayın organlarında yer alması veya tasarım projesinin dış ülkelerde uygulanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Müzeye Kabulü (Yurt Dışı)', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)'], 'puan' => 40],
    '2.1.2' => ['baslik' => 'Uluslararası karma sanat ve tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)'], 'puan' => 20],
    '2.1.3' => ['baslik' => 'Ulusal jüri elemesinden geçip yurt dışı etkinliğe katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 10],
    '2.1.4' => ['baslik' => 'Yurt dışında kişisel sanat etkinliğinde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)'], 'puan' => 10],
    '2.1.5' => ['baslik' => 'Yurt dışında karma veya grup sanat etkinliğine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Jürisiz)'], 'puan' => 5],
    '2.2.1' => ['baslik' => 'Özgün sanat eserinin yurt içinde satın alınması, yayın organlarında yer alması veya tasarım projesinin uygulanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Satın Alınması (Yurt İçi)', 'Eserin Müzeye Kabulü (Yurt İçi)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'], 'puan' => 20],
    '2.2.2' => ['baslik' => 'Yurt içinde jürili karma sanat ve tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)'], 'puan' => 10],
    '2.2.3' => ['baslik' => 'Yurt içinde kişisel sanat etkinliğinde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Özgün Eser / Beste / Tasarım'], 'puan' => 10],
    '2.2.4' => ['baslik' => 'Yurt içinde karma veya grup sanat etkinliğine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Jürisiz, Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 3],
];

// Dipnot c — ortak çalışmalarda puan dağılımı:
// tek kişi p · iki kişi 0,8p · üç kişi 0,6p · üçten fazla 0,5p.
// Yönerge SIRAYA ya da sorumlu yazarlığa hiç bakmıyor; bütün roller aynı
// kademeyi paylaşır.
$kademeler = ['kademeler' => [1 => 1.0, 2 => 0.8, 3 => 0.6], 'sonrasi' => 0.5];

$yazarKatsayisi = [
    // Atıf ve tez danışmanlığı "ortak çalışma" değil.
    'haric' => ['atif', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev', 'toplumsal_katki'],
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.0]],
        'ilk' => $kademeler,
        'baslica' => $kademeler,
        'yazar_2' => $kademeler,
        'yazar_3' => $kademeler,
        'yazar_4' => $kademeler,
        'yazar_5' => $kademeler,
        'yazar_6' => $kademeler,
        'ortak' => $kademeler,
    ],
];

$gruplar = [
    // Koşulların adıyla andığı kod kümeleri.
    '1.1' => ['1.1.*'],
    '1.2' => ['1.2.*'],
    '1.1.1' => ['1.1.1.1', '1.1.1.2', '1.1.1.3', '1.1.1.4', '1.1.1.5'],
    'TOPLAM-1' => ['1.1.*', '1.2.*'],
    'TEZ' => ['TEZ'],
];

return ['cetveller' => [
    // ══════════ İİF, İTBF, HF, EBF, YBF, MEDİT — sanatsal kalemler GD ══════════
    'ibn-haldun-2024' => [
        'kapsam_notu' => $kapsamNotu,
        'yazar_katsayisi' => $yazarKatsayisi,
        'maddeler' => $maddeler,
        'gruplar' => $gruplar,
    ],

    // ══════════ MTGF ve İF — sanatsal kalemler puanlı ══════════
    'ibn-haldun-2024-sanat' => [
        'kapsam_notu' => $kapsamNotu.' Bu birimde yönergenin sanatsal faaliyet bölümü (2.1 ve '
            .'2.2) da sayılıyor; diğer fakültelerde o satırlar "Geçerli Değil".',
        'yazar_katsayisi' => $yazarKatsayisi,
        'maddeler' => $maddeler + $sanatsal,
        'gruplar' => $gruplar + [
            '2.1' => ['2.1.*'],
            '2.2' => ['2.2.*'],
            // Koşullar "(1.1) ve/veya (2.1)" diye yazıyor.
            '1.1-2.1' => ['1.1.*', '2.1.*'],
            '1.1.1-2.1.1' => ['1.1.1.1', '1.1.1.2', '1.1.1.3', '1.1.1.4', '1.1.1.5', '2.1.1'],
            'TOPLAM-1-2' => ['1.1.*', '1.2.*', '2.1.*', '2.2.*'],
        ],
    ],
]];
