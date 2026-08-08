<?php

/*
|--------------------------------------------------------------------------
| Doğrulanmış Yönerge Eşikleri (üniversite atama kriterleri)
|--------------------------------------------------------------------------
|
| PDF'lerden elle çıkarılmış gerçek asgari koşullar; kadro ve temel alana göre.
| [üniversite_ad, kadro, alan, min_toplam, yayin_min, index_min, yds_min, notlar].
| kadro: dr_ogr_uyesi | docentlik | profesorluk. Kaynak = pdf → "Doğrulandı" rozeti.
| 9. eleman (opsiyonel): yapısal alt-koşullar (adet/yazarlık/veya/bilgi).
|
| DOSYA DÜZENİ: her üniversite kendi bloğunda, blok içinde kadro sırasıyla
| (Dr. Öğr. Üyesi → Doçent → Profesör). Yeni üniversite eklerken dosyanın
| sonuna yeni bir blok açın; mevcut blokların arasına satır serpiştirmeyin.
|
| 3. eleman (alan) DİZİ de olabilir: yönerge o eşiği birden çok temel alan için
| ortak tanımlıyorsa (ör. Akdeniz "GRUP 1: Sağlık, Ziraat, Mühendislik, Fen"),
| grubu tek satırda yazarsınız; dosya sonunda alan başına ayrı satıra açılır.
| Böylece motorun tarafında hiçbir gruplama/fallback mantığı kalmaz — eşleşme
| daima tam (kadro + alan) eşleşmesidir.
|
| KOŞUL AÇIKLAMALARI (`aciklama`) kullanıcıya gösterilir: yönergenin kendi madde
| numarasını ("1.1'den 2 makale") DEĞİL, içeriği yazın ("SCIE/SSCI/AHCI kapsamında
| en az 2 makale"). Madde numaralandırması her üniversitede farklıdır (1.1, A-1,
| a.1 ...) ve okuyan için bir şey ifade etmez. Numara ↔ indeks eşlemesini, satırları
| girerken referans olsun diye üniversite bloklarının başındaki yorumda tutun.
|
| YÖNERGE NOTU (`notlar`) belirsizliğin kayıt yeridir. Bir yönerge çelişkili ya da
| yoruma açık bir şey söylüyorsa (aynı baraj için iki farklı rakam, motorun
| hesaplayamadığı bir koşul, alan adı uyuşmazlığı...) kendi yorumunuzu değil,
| YÖNERGENİN İLGİLİ CÜMLESİNİ BİREBİR TIRNAK İÇİNDE yazın. Böyle bir notu okuyan
| kişi kararı kendi verebilsin; "çelişiyor" demek yerine neyin çeliştiğini gösterin.
|
*/

// ── Ortak indeks kümeleri (yönergelerin atıf yaptığı dergi grupları) ──
$idxUluslararasi = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];
$idxQ1Q3 = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)'];
$idxEsci = ['ESCI / Scopus'];
$idxTrDizin = ['TR Dizin'];
$idxUluslararasiVeEsci = [...$idxUluslararasi, ...$idxEsci];
$idxUluslararasiEsciTrDizin = [...$idxUluslararasi, ...$idxEsci, ...$idxTrDizin];
$makaleTum = [...$idxUluslararasiEsciTrDizin, 'Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'];
$kitapTum = ['BKCI / Scopus Kitap', 'Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)'];
$kitapBolumTum = ['Kitap Bölümü', 'BKCI / Scopus Kitap Bölümü'];

$satirlar = [
    /*
    ╔══════════════════════════════════════════════════════════════════════════╗
    ║  Akdeniz Üniversitesi
    ╚══════════════════════════════════════════════════════════════════════════╝
    | Kaynak: pdf/17536928172.akdenizuniversitesi.pdf
    | GRUP 1: Sağlık Bilimleri, Ziraat, Mühendislik, Fen Bilimleri
    | GRUP 2: Sosyal/Beşeri/İdari, Eğitim Bilimleri, Spor Bilimleri, Mimarlık Planlama ve Tasarım
    | GRUP 3: Hukuk, İlahiyat, Güzel Sanatlar  (barajlar Grup 2 ile aynı, alt koşulları farklı)
    | GRUP 5: Diğer Temel Alanlar — gruplarda adı geçmeyenler; Akdeniz'de Filoloji buraya düşer.
    | Tüm kadrolarda YDS en az 70.
    */

    // ── Dr. Öğr. Üyesi ──
    // "GRUP 1: Sağlık Bilimleri, Ziraat, Mühendislik, Fen Bilimleri"
    [
        'Akdeniz Üniversitesi', 'dr_ogr_uyesi', ['fen', 'muhendislik', 'saglik', 'ziraat'], 100, null, null, 70,
        'Grup 1 (Sağlık/Ziraat/Mühendislik/Fen): en az 3 yayın ve toplamda en az 100 puan. YDS en az 70.',
    ],
    // "GRUP 2: Sosyal, Beşeri ve İdari Bilimler, Eğitim, Spor ve Mimarlık, Planlama ve Tasarım"
    [
        'Akdeniz Üniversitesi', 'dr_ogr_uyesi', ['sosyal', 'egitim', 'spor', 'mimarlik'], 100, null, null, 70,
        'Grup 2 (Sosyal/Eğitim/Spor/Mimarlık): en az 2 yayın ve toplamda en az 100 puan; Tablo dipnotu: "Bu puanın en az yarısı 1. Bölüm: Bilimsel Makaleler\'den karşılanmış olmalıdır." YDS en az 70.',
        [
            ['aciklama' => 'En az 1 makalede başlıca yazar', 'kategori' => 'makale', 'kaynaklar' => $makaleTum, 'yazar' => 'baslica', 'min_adet' => 1],
            ['aciklama' => 'Yayınlardan biri lisansüstü tezden üretilmiş olmalı', 'bilgi' => true],
            ['aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden', 'bilgi' => true],
        ],
    ],
    // "GRUP 3. Hukuk, İlahiyat ve Güzel Sanatlar" — barajlar Grup 2 ile aynı, alt koşulları farklı.
    [
        'Akdeniz Üniversitesi', 'dr_ogr_uyesi', ['hukuk', 'ilahiyat', 'guzel_sanatlar'], 100, null, null, 70,
        'Grup 3 (Hukuk/İlahiyat/Güzel Sanatlar): en az 2 yayın ve toplamda en az 100 puan. Tablo dipnotları: "Hukuk ve İlahiyat Temel Alanı için bu puanın en az yarısı 1. Bölüm: Bilimsel Makaleler\'den karşılanmış olmalıdır." ve "Güzel Sanatlar Temel Alanı için bu puanın en az %40\'ı 1. Bölüm: Bilimsel Makaleler\'den karşılanmış olmalıdır." YDS en az 70.',
        [
            ['aciklama' => 'En az 1 makalede başlıca yazar', 'kategori' => 'makale', 'kaynaklar' => $makaleTum, 'yazar' => 'baslica', 'min_adet' => 1],
            ['aciklama' => 'Yayınlardan biri lisansüstü tezden üretilmiş olmalı', 'bilgi' => true],
        ],
    ],
    // "GRUP 5: Diğer Temel Alanlar" — yönergedeki gruplarda adı geçmeyen alanlar
    // buraya düşer; Akdeniz'de Filoloji bu kapsamdadır.
    [
        'Akdeniz Üniversitesi', 'dr_ogr_uyesi', 'filoloji', 100, null, null, 70,
        'Grup 5 (Diğer Temel Alanlar): en az 2 yayın ve toplamda en az 100 puan; Tablo dipnotu: "Bu puanın en az yarısı 1. Bölüm: Bilimsel Makaleler\'den karşılanmış olmalıdır." YDS en az 70.',
        [
            ['aciklama' => 'En az 1 makalede başlıca yazar', 'kategori' => 'makale', 'kaynaklar' => $makaleTum, 'yazar' => 'baslica', 'min_adet' => 1],
            ['aciklama' => 'Yayınlardan biri lisansüstü tezden üretilmiş olmalı', 'bilgi' => true],
        ],
    ],

    // ── Doçent ──
    // Not: Üniversite doçent KADROSU barajı — ÜAK doçent unvanının (asgari 100) üstüne ek şarttır.
    [
        'Akdeniz Üniversitesi', 'docentlik', ['fen', 'muhendislik', 'saglik', 'ziraat'], 300, null, null, 70,
        'Grup 1 (Sağlık/Ziraat/Mühendislik/Fen): toplamda en az 300 puan; Tablo dipnotu: "Bu puanın en az yarısı 1. Bölüm: Bilimsel Makaleler\'den karşılanmış olmalıdır." YDS en az 70.',
        [
            ['aciklama' => 'Doçentlik sonrası en az 2 makalede başlıca yazar', 'kategori' => 'makale', 'kaynaklar' => $makaleTum, 'yazar' => 'baslica', 'min_adet' => 2],
            ['aciklama' => 'BAP/dış kaynaklı projede yürütücülük (doçentlik ≥1, profesörlük ≥2)', 'bilgi' => true],
            ['aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden', 'bilgi' => true],
            ['aciklama' => 'Yayınların en az 4\'ü doktora sonrası ve son 7 yılda', 'bilgi' => true],
        ],
    ],
    [
        'Akdeniz Üniversitesi', 'docentlik', ['sosyal', 'egitim', 'spor', 'mimarlik'], 300, null, null, 70,
        'Grup 2 (Sosyal/Eğitim/Spor/Mimarlık): toplamda en az 300 puan; Tablo dipnotu: "Bu puanın en az yarısı 1. Bölüm: Bilimsel Makaleler\'den karşılanmış olmalıdır." YDS en az 70.',
        [
            ['aciklama' => 'Doçentlik sonrası en az 2 makalede başlıca yazar', 'kategori' => 'makale', 'kaynaklar' => $makaleTum, 'yazar' => 'baslica', 'min_adet' => 2],
            ['aciklama' => 'BAP/dış kaynaklı projede yürütücülük (doçentlik ≥1, profesörlük ≥2)', 'bilgi' => true],
            ['aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden', 'bilgi' => true],
            ['aciklama' => 'Yayınların en az 2\'si doktora sonrası ve son 7 yılda', 'bilgi' => true],
        ],
    ],
    // Grup 3: baraj Grup 2 ile aynı, fark alt koşullarda ("en az 2" yerine "en az 4" yayın).
    [
        'Akdeniz Üniversitesi', 'docentlik', ['hukuk', 'ilahiyat', 'guzel_sanatlar'], 300, null, null, 70,
        'Grup 3 (Hukuk/İlahiyat/Güzel Sanatlar): toplamda en az 300 puan. Tablo dipnotları: "Hukuk ve İlahiyat Temel Alanı için bu puanın en az yarısı 1. Bölüm: Bilimsel Makaleler\'den karşılanmış olmalıdır." ve "Güzel Sanatlar Temel Alanı için bu puanın en az %40\'ı 1. Bölüm: Bilimsel Makaleler\'den karşılanmış olmalıdır." YDS en az 70.',
        [
            ['aciklama' => 'Doktora/sanatta yeterlik sonrası en az 2 makalede başlıca yazar', 'kategori' => 'makale', 'kaynaklar' => $makaleTum, 'yazar' => 'baslica', 'min_adet' => 2],
            ['aciklama' => 'Yayınların en az 4\'ü doktora/sanatta yeterlik sonrası ve son 7 yılda', 'bilgi' => true],
        ],
    ],
    [
        'Akdeniz Üniversitesi', 'docentlik', 'filoloji', 300, null, null, 70,
        'Grup 5 (Diğer Temel Alanlar): toplamda en az 300 puan; Tablo dipnotu: "Bu puanın en az yarısı 1. Bölüm: Bilimsel Makaleler\'den karşılanmış olmalıdır." YDS en az 70.',
        [
            ['aciklama' => 'Doktora/sanatta yeterlik sonrası en az 2 makalede başlıca yazar', 'kategori' => 'makale', 'kaynaklar' => $makaleTum, 'yazar' => 'baslica', 'min_adet' => 2],
            ['aciklama' => 'Yayınların en az 4\'ü doktora/sanatta yeterlik sonrası ve son 7 yılda', 'bilgi' => true],
        ],
    ],

    // ── Profesör ──
    [
        'Akdeniz Üniversitesi', 'profesorluk', ['fen', 'muhendislik', 'saglik', 'ziraat'], 500, null, null, 70,
        'Grup 1 (Sağlık/Ziraat/Mühendislik/Fen): toplamda en az 500 puan; Tablo dipnotu: "Bu puanın en az yarısı 1. Bölüm: Bilimsel Makaleler\'den karşılanmış olmalıdır." YDS en az 70.',
        [
            ['aciklama' => 'Doçentlik sonrası en az 2 makalede başlıca yazar', 'kategori' => 'makale', 'kaynaklar' => $makaleTum, 'yazar' => 'baslica', 'min_adet' => 2],
            ['aciklama' => 'BAP/dış kaynaklı projede yürütücülük (doçentlik ≥1, profesörlük ≥2)', 'bilgi' => true],
            ['aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden', 'bilgi' => true],
            ['aciklama' => 'Yayınların en az 4\'ü doçentlik sonrası ve son 7 yılda', 'bilgi' => true],
        ],
    ],
    [
        'Akdeniz Üniversitesi', 'profesorluk', ['sosyal', 'egitim', 'spor', 'mimarlik'], 500, null, null, 70,
        'Grup 2 (Sosyal/Eğitim/Spor/Mimarlık): toplamda en az 500 puan; Tablo dipnotu: "Bu puanın en az yarısı 1. Bölüm: Bilimsel Makaleler\'den karşılanmış olmalıdır." YDS en az 70.',
        [
            ['aciklama' => 'Doçentlik sonrası en az 2 makalede başlıca yazar', 'kategori' => 'makale', 'kaynaklar' => $makaleTum, 'yazar' => 'baslica', 'min_adet' => 2],
            ['aciklama' => 'BAP/dış kaynaklı projede yürütücülük (doçentlik ≥1, profesörlük ≥2)', 'bilgi' => true],
            ['aciklama' => 'Toplam puanın en az yarısı bilimsel makalelerden', 'bilgi' => true],
            ['aciklama' => 'Yayınların en az 2\'si doçentlik sonrası ve son 7 yılda', 'bilgi' => true],
        ],
    ],
    [
        'Akdeniz Üniversitesi', 'profesorluk', ['hukuk', 'ilahiyat', 'guzel_sanatlar'], 500, null, null, 70,
        'Grup 3 (Hukuk/İlahiyat/Güzel Sanatlar): toplamda en az 500 puan. Tablo dipnotları: "Hukuk ve İlahiyat Temel Alanı için bu puanın en az yarısı 1. Bölüm: Bilimsel Makaleler\'den karşılanmış olmalıdır." ve "Güzel Sanatlar Temel Alanı için bu puanın en az %40\'ı 1. Bölüm: Bilimsel Makaleler\'den karşılanmış olmalıdır." YDS en az 70.',
        [
            ['aciklama' => 'Doçentlik sonrası en az 2 makalede başlıca yazar', 'kategori' => 'makale', 'kaynaklar' => $makaleTum, 'yazar' => 'baslica', 'min_adet' => 2],
            ['aciklama' => 'Yayınların en az 4\'ü doçentlik sonrası ve son 7 yılda', 'bilgi' => true],
        ],
    ],
    [
        'Akdeniz Üniversitesi', 'profesorluk', 'filoloji', 500, null, null, 70,
        'Grup 5 (Diğer Temel Alanlar): toplamda en az 500 puan; Tablo dipnotu: "Bu puanın en az yarısı 1. Bölüm: Bilimsel Makaleler\'den karşılanmış olmalıdır." YDS en az 70.',
        [
            ['aciklama' => 'Doçentlik sonrası en az 2 makalede başlıca yazar', 'kategori' => 'makale', 'kaynaklar' => $makaleTum, 'yazar' => 'baslica', 'min_adet' => 2],
            ['aciklama' => 'Yayınların en az 4\'ü doçentlik sonrası ve son 7 yılda', 'bilgi' => true],
        ],
    ],

    /*
    ╔══════════════════════════════════════════════════════════════════════════╗
    ║  Afyon Kocatepe Üniversitesi
    ╚══════════════════════════════════════════════════════════════════════════╝
    | Kaynak: pdf/17536927832.afyonkocatepeuniversitesi.pdf
    | Ek-1 madde numarası → indeks:  1.1 SCI/SCI-E/SSCI/AHCI · 1.1a/b/c Q1/Q2/Q3 (1.1d Q4)
    |                                1.2 ESCI veya SCOPUS · 1.3 TR Dizin · 3.1/3.2 kitap · 9.x sanatsal
    | Tablo 1/2/3 alan grupları: Eğitim+Spor · Sağlık · Fen+Mühendislik+Ziraat ·
    |   Mimarlık+Matematik+İstatistik · Sosyal · Filoloji+İlahiyat · Hukuk · Güzel Sanatlar
    | DİKKAT: yönerge iki farklı baraj veriyor. Tabloların "Asgari Başvuru Puanı" sütunu ile
    |   madde metnindeki toplam uyuşmuyor. Tablo değeri alındı; madde değeri notlarda.
    | Not: Afyon Matematik/İstatistik'i Mimarlık ile grupluyor; projede tek `fen` alanı olduğu için
    |   `fen`, Fen Bilimleri satırına bağlandı (puanlar aynı, alt koşullar farklı).
    | YDS koşulu yok (yalnızca yabancı dille öğretim yapan programlar için aranıyor).
    */

    // ── Dr. Öğr. Üyesi ──
    [
        'Afyon Kocatepe Üniversitesi', 'dr_ogr_uyesi', ['egitim', 'spor'], 180, null, null, null,
        'Tablo 1 (Eğitim/Spor Bilimleri): Asgari Başvuru Puanı 180. Madde 7/1-ç ise şunu istiyor: "İlk kez yapılacak atamalarda; Tablo 1\'de belirtilen alanlara göre asgari yayın koşullarının karşılanması kaydıyla Ek-1\'de yer alan tablodaki maddelerden toplamda en az 200 puan almış olmak."',
        [
            ['aciklama' => 'SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 1 makale', 'kategori' => 'makale', 'kaynaklar' => $idxUluslararasiVeEsci, 'min_adet' => 1],
            ['aciklama' => 'TR Dizin kapsamında en az 2 makale', 'kategori' => 'makale', 'kaynaklar' => $idxTrDizin, 'min_adet' => 2],
            ['aciklama' => 'TR Dizin koşulu yerine SCIE/SSCI/AHCI veya ESCI/Scopus makalesi de kabul edilir', 'bilgi' => true],
        ],
    ],
    [
        'Afyon Kocatepe Üniversitesi', 'dr_ogr_uyesi', 'saglik', 180, null, null, null,
        'Tablo 1 (Sağlık Bilimleri): Asgari Başvuru Puanı 180. Madde 7/1-ç ise şunu istiyor: "İlk kez yapılacak atamalarda; Tablo 1\'de belirtilen alanlara göre asgari yayın koşullarının karşılanması kaydıyla Ek-1\'de yer alan tablodaki maddelerden toplamda en az 200 puan almış olmak."',
        [
            ['aciklama' => 'SCIE/SSCI/AHCI kapsamında en az 2 makale', 'kategori' => 'makale', 'kaynaklar' => $idxUluslararasi, 'min_adet' => 2],
            ['aciklama' => 'TR Dizin kapsamında en az 1 makale', 'kategori' => 'makale', 'kaynaklar' => $idxTrDizin, 'min_adet' => 1],
            ['aciklama' => 'TR Dizin koşulu yerine SCIE/SSCI/AHCI veya ESCI/Scopus makalesi de kabul edilir', 'bilgi' => true],
        ],
    ],
    [
        'Afyon Kocatepe Üniversitesi', 'dr_ogr_uyesi', ['fen', 'muhendislik', 'ziraat'], 180, null, null, null,
        'Tablo 1 (Fen/Mühendislik/Ziraat): Asgari Başvuru Puanı 180. Madde 7/1-ç ise şunu istiyor: "İlk kez yapılacak atamalarda; Tablo 1\'de belirtilen alanlara göre asgari yayın koşullarının karşılanması kaydıyla Ek-1\'de yer alan tablodaki maddelerden toplamda en az 200 puan almış olmak."',
        [
            ['aciklama' => 'SCIE/SSCI/AHCI kapsamında en az 2 makale', 'kategori' => 'makale', 'kaynaklar' => $idxUluslararasi, 'min_adet' => 2],
            ['aciklama' => 'TR Dizin kapsamında en az 1 makale', 'kategori' => 'makale', 'kaynaklar' => $idxTrDizin, 'min_adet' => 1],
            ['aciklama' => 'TR Dizin koşulu yerine SCIE/SSCI/AHCI veya ESCI/Scopus makalesi de kabul edilir', 'bilgi' => true],
        ],
    ],
    [
        'Afyon Kocatepe Üniversitesi', 'dr_ogr_uyesi', 'mimarlik', 180, null, null, null,
        'Tablo 1 (Mimarlık/Matematik/İstatistik): Asgari Başvuru Puanı 180. Madde 7/1-ç ise şunu istiyor: "İlk kez yapılacak atamalarda; Tablo 1\'de belirtilen alanlara göre asgari yayın koşullarının karşılanması kaydıyla Ek-1\'de yer alan tablodaki maddelerden toplamda en az 200 puan almış olmak."',
        [
            ['aciklama' => 'SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 2 makale', 'kategori' => 'makale', 'kaynaklar' => $idxUluslararasiVeEsci, 'min_adet' => 2],
            ['aciklama' => 'Bunlardan en az 1 tanesi SCIE/SSCI/AHCI kapsamında olmalı', 'kategori' => 'makale', 'kaynaklar' => $idxUluslararasi, 'min_adet' => 1],
            ['aciklama' => 'TR Dizin kapsamında en az 1 makale', 'kategori' => 'makale', 'kaynaklar' => $idxTrDizin, 'min_adet' => 1],
            ['aciklama' => 'TR Dizin koşulu yerine SCIE/SSCI/AHCI veya ESCI/Scopus makalesi de kabul edilir', 'bilgi' => true],
        ],
    ],
    [
        'Afyon Kocatepe Üniversitesi', 'dr_ogr_uyesi', 'sosyal', 180, null, null, null,
        'Tablo 1 (Sosyal, Beşeri ve İdari Bilimler): Asgari Başvuru Puanı 180. Madde 7/1-ç ise şunu istiyor: "İlk kez yapılacak atamalarda; Tablo 1\'de belirtilen alanlara göre asgari yayın koşullarının karşılanması kaydıyla Ek-1\'de yer alan tablodaki maddelerden toplamda en az 200 puan almış olmak."',
        [
            ['aciklama' => 'SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 1 makale', 'kategori' => 'makale', 'kaynaklar' => $idxUluslararasiVeEsci, 'min_adet' => 1],
            ['aciklama' => 'TR Dizin kapsamında en az 2 makale', 'kategori' => 'makale', 'kaynaklar' => $idxTrDizin, 'min_adet' => 2],
            ['aciklama' => 'TR Dizin koşulu yerine SCIE/SSCI/AHCI veya ESCI/Scopus makalesi de kabul edilir', 'bilgi' => true],
        ],
    ],
    [
        'Afyon Kocatepe Üniversitesi', 'dr_ogr_uyesi', ['filoloji', 'ilahiyat'], 180, null, null, null,
        'Tablo 1 (Filoloji/İlahiyat): Asgari Başvuru Puanı 180. Madde 7/1-ç ise şunu istiyor: "İlk kez yapılacak atamalarda; Tablo 1\'de belirtilen alanlara göre asgari yayın koşullarının karşılanması kaydıyla Ek-1\'de yer alan tablodaki maddelerden toplamda en az 200 puan almış olmak."',
        [
            ['aciklama' => 'SCIE/SSCI/AHCI, ESCI/Scopus veya TR Dizin kapsamında en az 4 makale', 'kategori' => 'makale', 'kaynaklar' => $idxUluslararasiEsciTrDizin, 'min_adet' => 4],
        ],
    ],
    [
        'Afyon Kocatepe Üniversitesi', 'dr_ogr_uyesi', 'hukuk', 180, null, null, null,
        'Tablo 1 (Hukuk): üç seçenekten biri + Asgari Başvuru Puanı 180. Madde 7/1-ç ise şunu istiyor: "İlk kez yapılacak atamalarda; Tablo 1\'de belirtilen alanlara göre asgari yayın koşullarının karşılanması kaydıyla Ek-1\'de yer alan tablodaki maddelerden toplamda en az 200 puan almış olmak." Üç seçeneğin sonuncusu iki koşulu "ve" ile bağladığı için otomatik değerlendirilemiyor: "1.3. maddesinden yayımlanmış en az 2 makalesi olmak ve 3.1 veya 3.2 maddelerinden yayımlanmış tek yazarlı özgün bilimsel en az 1 kitabı olmak."',
        [
            [
                'aciklama' => 'SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 2 makale YA DA TR Dizin kapsamında en az 4 makale',
                'veya' => [
                    ['kategori' => 'makale', 'kaynaklar' => $idxUluslararasiVeEsci, 'min_adet' => 2],
                    ['kategori' => 'makale', 'kaynaklar' => $idxTrDizin, 'min_adet' => 4],
                ],
            ],
            ['aciklama' => '3. seçenek: TR Dizin kapsamında 2 makale ve tek yazarlı 1 kitap (belge ile)', 'bilgi' => true],
            ['aciklama' => 'TR Dizin koşulu yerine SCIE/SSCI/AHCI veya ESCI/Scopus makalesi de kabul edilir', 'bilgi' => true],
        ],
    ],
    [
        'Afyon Kocatepe Üniversitesi', 'dr_ogr_uyesi', 'guzel_sanatlar', 180, null, null, null,
        'Tablo 1 (Güzel Sanatlar): Asgari Başvuru Puanı 180. Madde 7/1-ç ise şunu istiyor: "İlk kez yapılacak atamalarda; Tablo 1\'de belirtilen alanlara göre asgari yayın koşullarının karşılanması kaydıyla Ek-1\'de yer alan tablodaki maddelerden toplamda en az 200 puan almış olmak."',
        [
            ['aciklama' => 'SCIE/SSCI/AHCI, ESCI/Scopus veya TR Dizin kapsamında en az 3 makale', 'kategori' => 'makale', 'kaynaklar' => $idxUluslararasiEsciTrDizin, 'min_adet' => 3],
            ['aciklama' => 'Sanatsal etkinliklerden (sergi, gösterim, tasarım) en az 60 puan', 'bilgi' => true],
        ],
    ],

    // ── Doçent ──
    [
        'Afyon Kocatepe Üniversitesi', 'docentlik', ['egitim', 'spor'], 500, null, null, null,
        'Tablo 2 (Eğitim/Spor Bilimleri): Asgari Başvuru Puanı 500, doktora sonrası çalışmalarla. Madde 8/1-ç ise şunu istiyor: "Doçent unvanını aldığı ÜAK doçentlik temel alanında, Tablo 2\'de belirtilen alanlara göre asgari yayın koşullarının karşılanması kaydıyla Ek-1\'de yer alan tablodaki maddelerden doktora sonrası yapılan çalışmalarla toplamda güzel sanatlar alanı için en az 450 puan, diğer alanlar için en az 600 puan almış olmak."',
        [
            ['aciklama' => 'SCIE/SSCI/AHCI kapsamında en az 2 makale', 'kategori' => 'makale', 'kaynaklar' => $idxUluslararasi, 'min_adet' => 2],
            ['aciklama' => 'Bunların en az 1 tanesinde SCIE/SSCI Q1-Q3 kapsamında başlıca yazar', 'kategori' => 'makale', 'kaynaklar' => $idxQ1Q3, 'yazar' => 'baslica', 'min_adet' => 1],
            ['aciklama' => 'TR Dizin kapsamında en az 4 makale', 'kategori' => 'makale', 'kaynaklar' => $idxTrDizin, 'min_adet' => 4],
            ['aciklama' => 'Bunların en az 2 tanesinde başlıca yazar', 'kategori' => 'makale', 'kaynaklar' => $idxTrDizin, 'yazar' => 'baslica', 'min_adet' => 2],
            ['aciklama' => 'TR Dizin koşulu yerine SCIE/SSCI/AHCI veya ESCI/Scopus makalesi de kabul edilir', 'bilgi' => true],
        ],
    ],
    [
        'Afyon Kocatepe Üniversitesi', 'docentlik', 'saglik', 500, null, null, null,
        'Tablo 2 (Sağlık Bilimleri): Asgari Başvuru Puanı 500, doktora sonrası çalışmalarla. Madde 8/1-ç ise şunu istiyor: "Doçent unvanını aldığı ÜAK doçentlik temel alanında, Tablo 2\'de belirtilen alanlara göre asgari yayın koşullarının karşılanması kaydıyla Ek-1\'de yer alan tablodaki maddelerden doktora sonrası yapılan çalışmalarla toplamda güzel sanatlar alanı için en az 450 puan, diğer alanlar için en az 600 puan almış olmak."',
        [
            ['aciklama' => 'SCIE/SSCI Q1-Q3 kapsamında en az 4 makale', 'kategori' => 'makale', 'kaynaklar' => $idxQ1Q3, 'min_adet' => 4],
            ['aciklama' => 'Bunların en az 3 tanesinde başlıca yazar', 'kategori' => 'makale', 'kaynaklar' => $idxQ1Q3, 'yazar' => 'baslica', 'min_adet' => 3],
            ['aciklama' => 'TR Dizin kapsamında başlıca yazar olduğu en az 2 makale', 'kategori' => 'makale', 'kaynaklar' => $idxTrDizin, 'yazar' => 'baslica', 'min_adet' => 2],
            ['aciklama' => 'TR Dizin koşulu yerine SCIE/SSCI/AHCI veya ESCI/Scopus makalesi de kabul edilir', 'bilgi' => true],
        ],
    ],
    [
        'Afyon Kocatepe Üniversitesi', 'docentlik', ['fen', 'muhendislik', 'ziraat'], 500, null, null, null,
        'Tablo 2 (Fen/Mühendislik/Ziraat): Asgari Başvuru Puanı 500, doktora sonrası çalışmalarla. Madde 8/1-ç ise şunu istiyor: "Doçent unvanını aldığı ÜAK doçentlik temel alanında, Tablo 2\'de belirtilen alanlara göre asgari yayın koşullarının karşılanması kaydıyla Ek-1\'de yer alan tablodaki maddelerden doktora sonrası yapılan çalışmalarla toplamda güzel sanatlar alanı için en az 450 puan, diğer alanlar için en az 600 puan almış olmak."',
        [
            ['aciklama' => 'SCIE/SSCI Q1-Q3 kapsamında en az 4 makale', 'kategori' => 'makale', 'kaynaklar' => $idxQ1Q3, 'min_adet' => 4],
            ['aciklama' => 'Bunların en az 2 tanesinde başlıca yazar', 'kategori' => 'makale', 'kaynaklar' => $idxQ1Q3, 'yazar' => 'baslica', 'min_adet' => 2],
            ['aciklama' => 'TR Dizin kapsamında başlıca yazar olduğu en az 2 makale', 'kategori' => 'makale', 'kaynaklar' => $idxTrDizin, 'yazar' => 'baslica', 'min_adet' => 2],
            ['aciklama' => 'TR Dizin koşulu yerine SCIE/SSCI/AHCI veya ESCI/Scopus makalesi de kabul edilir', 'bilgi' => true],
        ],
    ],
    [
        'Afyon Kocatepe Üniversitesi', 'docentlik', 'mimarlik', 500, null, null, null,
        'Tablo 2 (Mimarlık/Matematik/İstatistik): Asgari Başvuru Puanı 500, doktora sonrası çalışmalarla. Madde 8/1-ç ise şunu istiyor: "Doçent unvanını aldığı ÜAK doçentlik temel alanında, Tablo 2\'de belirtilen alanlara göre asgari yayın koşullarının karşılanması kaydıyla Ek-1\'de yer alan tablodaki maddelerden doktora sonrası yapılan çalışmalarla toplamda güzel sanatlar alanı için en az 450 puan, diğer alanlar için en az 600 puan almış olmak."',
        [
            ['aciklama' => 'SCIE/SSCI Q1-Q3 kapsamında en az 4 makale', 'kategori' => 'makale', 'kaynaklar' => $idxQ1Q3, 'min_adet' => 4],
            ['aciklama' => 'Bunların en az 1 tanesinde başlıca yazar', 'kategori' => 'makale', 'kaynaklar' => $idxQ1Q3, 'yazar' => 'baslica', 'min_adet' => 1],
            ['aciklama' => 'TR Dizin kapsamında başlıca yazar olduğu en az 2 makale', 'kategori' => 'makale', 'kaynaklar' => $idxTrDizin, 'yazar' => 'baslica', 'min_adet' => 2],
            ['aciklama' => 'TR Dizin koşulu yerine SCIE/SSCI/AHCI veya ESCI/Scopus makalesi de kabul edilir', 'bilgi' => true],
        ],
    ],
    [
        'Afyon Kocatepe Üniversitesi', 'docentlik', 'sosyal', 500, null, null, null,
        'Tablo 2 (Sosyal, Beşeri ve İdari Bilimler): Asgari Başvuru Puanı 500, doktora sonrası çalışmalarla. Madde 8/1-ç ise şunu istiyor: "Doçent unvanını aldığı ÜAK doçentlik temel alanında, Tablo 2\'de belirtilen alanlara göre asgari yayın koşullarının karşılanması kaydıyla Ek-1\'de yer alan tablodaki maddelerden doktora sonrası yapılan çalışmalarla toplamda güzel sanatlar alanı için en az 450 puan, diğer alanlar için en az 600 puan almış olmak."',
        [
            ['aciklama' => 'SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında başlıca yazar olduğu en az 1 makale', 'kategori' => 'makale', 'kaynaklar' => $idxUluslararasiVeEsci, 'yazar' => 'baslica', 'min_adet' => 1],
            ['aciklama' => 'TR Dizin kapsamında en az 5 makale', 'kategori' => 'makale', 'kaynaklar' => $idxTrDizin, 'min_adet' => 5],
            ['aciklama' => 'Bunların en az 3 tanesi tek yazarlı', 'kategori' => 'makale', 'kaynaklar' => $idxTrDizin, 'yazar' => 'tek', 'min_adet' => 3],
            [
                'aciklama' => 'En az 1 kitap veya en az 2 kitap bölümü',
                'veya' => [
                    ['kategori' => 'kitap', 'kaynaklar' => $kitapTum, 'min_adet' => 1],
                    ['kategori' => 'kitap', 'kaynaklar' => $kitapBolumTum, 'min_adet' => 2],
                ],
            ],
            ['aciklama' => 'TR Dizin koşulu yerine SCIE/SSCI/AHCI veya ESCI/Scopus makalesi de kabul edilir', 'bilgi' => true],
        ],
    ],
    [
        'Afyon Kocatepe Üniversitesi', 'docentlik', 'ilahiyat', 500, null, null, null,
        'Tablo 2 (İlahiyat): Asgari Başvuru Puanı 500, doktora sonrası çalışmalarla. Madde 8/1-ç ise şunu istiyor: "Doçent unvanını aldığı ÜAK doçentlik temel alanında, Tablo 2\'de belirtilen alanlara göre asgari yayın koşullarının karşılanması kaydıyla Ek-1\'de yer alan tablodaki maddelerden doktora sonrası yapılan çalışmalarla toplamda güzel sanatlar alanı için en az 450 puan, diğer alanlar için en az 600 puan almış olmak."',
        [
            ['aciklama' => 'SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında başlıca yazar olduğu en az 1 makale', 'kategori' => 'makale', 'kaynaklar' => $idxUluslararasiVeEsci, 'yazar' => 'baslica', 'min_adet' => 1],
            ['aciklama' => 'TR Dizin kapsamında en az 5 makale', 'kategori' => 'makale', 'kaynaklar' => $idxTrDizin, 'min_adet' => 5],
            ['aciklama' => 'Bunların en az 3 tanesi tek yazarlı', 'kategori' => 'makale', 'kaynaklar' => $idxTrDizin, 'yazar' => 'tek', 'min_adet' => 3],
            ['aciklama' => 'Tek yazarlı en az 1 kitap', 'kategori' => 'kitap', 'kaynaklar' => $kitapTum, 'yazar' => 'tek', 'min_adet' => 1],
            ['aciklama' => 'TR Dizin koşulu yerine SCIE/SSCI/AHCI veya ESCI/Scopus makalesi de kabul edilir', 'bilgi' => true],
        ],
    ],
    [
        'Afyon Kocatepe Üniversitesi', 'docentlik', 'filoloji', 500, null, null, null,
        'Tablo 2 (Filoloji): Asgari Başvuru Puanı 500, doktora sonrası çalışmalarla. Madde 8/1-ç ise şunu istiyor: "Doçent unvanını aldığı ÜAK doçentlik temel alanında, Tablo 2\'de belirtilen alanlara göre asgari yayın koşullarının karşılanması kaydıyla Ek-1\'de yer alan tablodaki maddelerden doktora sonrası yapılan çalışmalarla toplamda güzel sanatlar alanı için en az 450 puan, diğer alanlar için en az 600 puan almış olmak."',
        [
            ['aciklama' => 'SCIE/SSCI/AHCI, ESCI/Scopus veya TR Dizin kapsamında en az 6 makale', 'kategori' => 'makale', 'kaynaklar' => $idxUluslararasiEsciTrDizin, 'min_adet' => 6],
            ['aciklama' => 'Bunların en az 3 tanesi tek yazarlı', 'kategori' => 'makale', 'kaynaklar' => $idxUluslararasiEsciTrDizin, 'yazar' => 'tek', 'min_adet' => 3],
            ['aciklama' => 'Tek yazarlı en az 1 kitap', 'kategori' => 'kitap', 'kaynaklar' => $kitapTum, 'yazar' => 'tek', 'min_adet' => 1],
        ],
    ],
    [
        'Afyon Kocatepe Üniversitesi', 'docentlik', 'hukuk', 500, null, null, null,
        'Tablo 2 (Hukuk): Asgari Başvuru Puanı 500, doktora sonrası çalışmalarla. Madde 8/1-ç ise şunu istiyor: "Doçent unvanını aldığı ÜAK doçentlik temel alanında, Tablo 2\'de belirtilen alanlara göre asgari yayın koşullarının karşılanması kaydıyla Ek-1\'de yer alan tablodaki maddelerden doktora sonrası yapılan çalışmalarla toplamda güzel sanatlar alanı için en az 450 puan, diğer alanlar için en az 600 puan almış olmak."',
        [
            ['aciklama' => 'SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 1 makale', 'kategori' => 'makale', 'kaynaklar' => $idxUluslararasiVeEsci, 'min_adet' => 1],
            ['aciklama' => 'TR Dizin kapsamında en az 6 makale', 'kategori' => 'makale', 'kaynaklar' => $idxTrDizin, 'min_adet' => 6],
            ['aciklama' => 'Bunların en az 4 tanesi tek yazarlı', 'kategori' => 'makale', 'kaynaklar' => $idxTrDizin, 'yazar' => 'tek', 'min_adet' => 4],
            ['aciklama' => 'Tek yazarlı en az 1 kitap', 'kategori' => 'kitap', 'kaynaklar' => $kitapTum, 'yazar' => 'tek', 'min_adet' => 1],
            ['aciklama' => 'TR Dizin koşulu yerine SCIE/SSCI/AHCI veya ESCI/Scopus makalesi de kabul edilir', 'bilgi' => true],
        ],
    ],
    [
        'Afyon Kocatepe Üniversitesi', 'docentlik', 'guzel_sanatlar', 350, null, null, null,
        'Tablo 2 (Güzel Sanatlar): Asgari Başvuru Puanı 350, doktora sonrası çalışmalarla. Madde 8/1-ç ise şunu istiyor: "Doçent unvanını aldığı ÜAK doçentlik temel alanında, Tablo 2\'de belirtilen alanlara göre asgari yayın koşullarının karşılanması kaydıyla Ek-1\'de yer alan tablodaki maddelerden doktora sonrası yapılan çalışmalarla toplamda güzel sanatlar alanı için en az 450 puan, diğer alanlar için en az 600 puan almış olmak."',
        [
            ['aciklama' => 'Sanatsal etkinliklerden (sergi, gösterim, tasarım) en az 100 puan (ÜAK özel koşullarına uygun)', 'bilgi' => true],
            ['aciklama' => 'SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında başlıca yazar olduğu en az 1 makale', 'kategori' => 'makale', 'kaynaklar' => $idxUluslararasiVeEsci, 'yazar' => 'baslica', 'min_adet' => 1],
            ['aciklama' => 'TR Dizin kapsamında en az 2 makale', 'kategori' => 'makale', 'kaynaklar' => $idxTrDizin, 'min_adet' => 2],
            ['aciklama' => 'Bunların en az 1 tanesi tek yazarlı', 'kategori' => 'makale', 'kaynaklar' => $idxTrDizin, 'yazar' => 'tek', 'min_adet' => 1],
            ['aciklama' => 'TR Dizin koşulu yerine SCIE/SSCI/AHCI veya ESCI/Scopus makalesi de kabul edilir', 'bilgi' => true],
        ],
    ],

    // ── Profesör ──
    [
        'Afyon Kocatepe Üniversitesi', 'profesorluk', ['egitim', 'spor'], 600, null, null, null,
        'Tablo 3 (Eğitim/Spor Bilimleri): Asgari Başvuru Puanı 600, doçentlik sonrası çalışmalarla + Tablo 4 ek faaliyet. Madde 9/1-g ise şunu istiyor: "Doçent unvanını aldığı ÜAK doçentlik temel alanında olmak kaydıyla, Tablo 3\'te belirtilen alanlara göre asgari yayın koşullarının karşılanmasına ilave olarak; Ek-1\'de yer alan tablodaki maddelerden doçentlik unvanının alınmasından sonra yapılan çalışmalarla toplamda güzel sanatlar alanı için en az 550 puan, diğer alanlar için en az 700 puan almış olmak ve Tablo 4\'teki faaliyetlerden en az birini gerçekleştirmiş olmak."',
        [
            ['aciklama' => 'SCIE/SSCI/AHCI kapsamında en az 2 makale', 'kategori' => 'makale', 'kaynaklar' => $idxUluslararasi, 'min_adet' => 2],
            ['aciklama' => 'Bunların en az 1 tanesinde SCIE/SSCI Q1-Q3 kapsamında başlıca yazar', 'kategori' => 'makale', 'kaynaklar' => $idxQ1Q3, 'yazar' => 'baslica', 'min_adet' => 1],
            ['aciklama' => 'SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında başlıca yazar olduğu en az 1 makale', 'kategori' => 'makale', 'kaynaklar' => $idxUluslararasiVeEsci, 'yazar' => 'baslica', 'min_adet' => 1],
            ['aciklama' => 'TR Dizin kapsamında en az 3 makale', 'kategori' => 'makale', 'kaynaklar' => $idxTrDizin, 'min_adet' => 3],
            ['aciklama' => 'Bunların en az 2 tanesinde başlıca yazar', 'kategori' => 'makale', 'kaynaklar' => $idxTrDizin, 'yazar' => 'baslica', 'min_adet' => 2],
            ['aciklama' => 'Tablo 4: proje/patent/yurt dışı araştırma vb. en az 1 ek faaliyet', 'bilgi' => true],
            ['aciklama' => 'TR Dizin koşulu yerine SCIE/SSCI/AHCI veya ESCI/Scopus makalesi de kabul edilir', 'bilgi' => true],
        ],
    ],
    [
        'Afyon Kocatepe Üniversitesi', 'profesorluk', ['saglik', 'fen', 'muhendislik', 'ziraat', 'mimarlik'], 600, null, null, null,
        'Tablo 3 (Sağlık/Fen/Mühendislik/Ziraat/Mimarlık): Asgari Başvuru Puanı 600, doçentlik sonrası çalışmalarla + Tablo 4 ek faaliyet. Madde 9/1-g ise şunu istiyor: "Doçent unvanını aldığı ÜAK doçentlik temel alanında olmak kaydıyla, Tablo 3\'te belirtilen alanlara göre asgari yayın koşullarının karşılanmasına ilave olarak; Ek-1\'de yer alan tablodaki maddelerden doçentlik unvanının alınmasından sonra yapılan çalışmalarla toplamda güzel sanatlar alanı için en az 550 puan, diğer alanlar için en az 700 puan almış olmak ve Tablo 4\'teki faaliyetlerden en az birini gerçekleştirmiş olmak."',
        [
            ['aciklama' => 'SCIE/SSCI Q1-Q3 kapsamında en az 5 makale', 'kategori' => 'makale', 'kaynaklar' => $idxQ1Q3, 'min_adet' => 5],
            ['aciklama' => 'Bunların en az 3 tanesinde başlıca yazar', 'kategori' => 'makale', 'kaynaklar' => $idxQ1Q3, 'yazar' => 'baslica', 'min_adet' => 3],
            ['aciklama' => 'TR Dizin kapsamında başlıca yazar olduğu en az 2 makale', 'kategori' => 'makale', 'kaynaklar' => $idxTrDizin, 'yazar' => 'baslica', 'min_adet' => 2],
            ['aciklama' => 'Tablo 4: proje/patent/yurt dışı araştırma vb. en az 1 ek faaliyet', 'bilgi' => true],
            ['aciklama' => 'TR Dizin koşulu yerine SCIE/SSCI/AHCI veya ESCI/Scopus makalesi de kabul edilir', 'bilgi' => true],
        ],
    ],
    [
        'Afyon Kocatepe Üniversitesi', 'profesorluk', ['sosyal', 'ilahiyat'], 600, null, null, null,
        'Tablo 3 (Sosyal, Beşeri ve İdari Bilimler / İlahiyat): Asgari Başvuru Puanı 600, doçentlik sonrası çalışmalarla + Tablo 4 ek faaliyet. Madde 9/1-g ise şunu istiyor: "Doçent unvanını aldığı ÜAK doçentlik temel alanında olmak kaydıyla, Tablo 3\'te belirtilen alanlara göre asgari yayın koşullarının karşılanmasına ilave olarak; Ek-1\'de yer alan tablodaki maddelerden doçentlik unvanının alınmasından sonra yapılan çalışmalarla toplamda güzel sanatlar alanı için en az 550 puan, diğer alanlar için en az 700 puan almış olmak ve Tablo 4\'teki faaliyetlerden en az birini gerçekleştirmiş olmak."',
        [
            ['aciklama' => 'SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında en az 2 makale', 'kategori' => 'makale', 'kaynaklar' => $idxUluslararasiVeEsci, 'min_adet' => 2],
            ['aciklama' => 'Bunların en az 1 tanesinde başlıca yazar', 'kategori' => 'makale', 'kaynaklar' => $idxUluslararasiVeEsci, 'yazar' => 'baslica', 'min_adet' => 1],
            ['aciklama' => 'TR Dizin kapsamında en az 5 makale', 'kategori' => 'makale', 'kaynaklar' => $idxTrDizin, 'min_adet' => 5],
            ['aciklama' => 'Bunların en az 3 tanesi tek yazarlı', 'kategori' => 'makale', 'kaynaklar' => $idxTrDizin, 'yazar' => 'tek', 'min_adet' => 3],
            ['aciklama' => 'Tablo 4: proje/patent/yurt dışı araştırma vb. en az 1 ek faaliyet', 'bilgi' => true],
            ['aciklama' => 'TR Dizin koşulu yerine SCIE/SSCI/AHCI veya ESCI/Scopus makalesi de kabul edilir', 'bilgi' => true],
        ],
    ],
    [
        'Afyon Kocatepe Üniversitesi', 'profesorluk', 'filoloji', 600, null, null, null,
        'Tablo 3 (Filoloji): Asgari Başvuru Puanı 600, doçentlik sonrası çalışmalarla + Tablo 4 ek faaliyet. Madde 9/1-g ise şunu istiyor: "Doçent unvanını aldığı ÜAK doçentlik temel alanında olmak kaydıyla, Tablo 3\'te belirtilen alanlara göre asgari yayın koşullarının karşılanmasına ilave olarak; Ek-1\'de yer alan tablodaki maddelerden doçentlik unvanının alınmasından sonra yapılan çalışmalarla toplamda güzel sanatlar alanı için en az 550 puan, diğer alanlar için en az 700 puan almış olmak ve Tablo 4\'teki faaliyetlerden en az birini gerçekleştirmiş olmak."',
        [
            ['aciklama' => 'SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında başlıca yazar olduğu en az 1 makale', 'kategori' => 'makale', 'kaynaklar' => $idxUluslararasiVeEsci, 'yazar' => 'baslica', 'min_adet' => 1],
            ['aciklama' => 'TR Dizin kapsamında en az 6 makale', 'kategori' => 'makale', 'kaynaklar' => $idxTrDizin, 'min_adet' => 6],
            ['aciklama' => 'Bunların en az 3 tanesi tek yazarlı', 'kategori' => 'makale', 'kaynaklar' => $idxTrDizin, 'yazar' => 'tek', 'min_adet' => 3],
            ['aciklama' => 'Tablo 4: proje/patent/yurt dışı araştırma vb. en az 1 ek faaliyet', 'bilgi' => true],
            ['aciklama' => 'TR Dizin koşulu yerine SCIE/SSCI/AHCI veya ESCI/Scopus makalesi de kabul edilir', 'bilgi' => true],
        ],
    ],
    [
        'Afyon Kocatepe Üniversitesi', 'profesorluk', 'hukuk', 600, null, null, null,
        'Tablo 3 (Hukuk): Asgari Başvuru Puanı 600, doçentlik sonrası çalışmalarla + Tablo 4 ek faaliyet. Madde 9/1-g ise şunu istiyor: "Doçent unvanını aldığı ÜAK doçentlik temel alanında olmak kaydıyla, Tablo 3\'te belirtilen alanlara göre asgari yayın koşullarının karşılanmasına ilave olarak; Ek-1\'de yer alan tablodaki maddelerden doçentlik unvanının alınmasından sonra yapılan çalışmalarla toplamda güzel sanatlar alanı için en az 550 puan, diğer alanlar için en az 700 puan almış olmak ve Tablo 4\'teki faaliyetlerden en az birini gerçekleştirmiş olmak."',
        [
            ['aciklama' => 'SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında başlıca yazar olduğu en az 1 makale', 'kategori' => 'makale', 'kaynaklar' => $idxUluslararasiVeEsci, 'yazar' => 'baslica', 'min_adet' => 1],
            ['aciklama' => 'TR Dizin kapsamında en az 6 makale', 'kategori' => 'makale', 'kaynaklar' => $idxTrDizin, 'min_adet' => 6],
            ['aciklama' => 'Bunların en az 4 tanesi tek yazarlı', 'kategori' => 'makale', 'kaynaklar' => $idxTrDizin, 'yazar' => 'tek', 'min_adet' => 4],
            ['aciklama' => 'Tablo 4: proje/patent/yurt dışı araştırma vb. en az 1 ek faaliyet', 'bilgi' => true],
            ['aciklama' => 'TR Dizin koşulu yerine SCIE/SSCI/AHCI veya ESCI/Scopus makalesi de kabul edilir', 'bilgi' => true],
        ],
    ],
    [
        'Afyon Kocatepe Üniversitesi', 'profesorluk', 'guzel_sanatlar', 450, null, null, null,
        'Tablo 3 (Güzel Sanatlar): Asgari Başvuru Puanı 450, doçentlik sonrası çalışmalarla + Tablo 4 ek faaliyet. Madde 9/1-g ise şunu istiyor: "Doçent unvanını aldığı ÜAK doçentlik temel alanında olmak kaydıyla, Tablo 3\'te belirtilen alanlara göre asgari yayın koşullarının karşılanmasına ilave olarak; Ek-1\'de yer alan tablodaki maddelerden doçentlik unvanının alınmasından sonra yapılan çalışmalarla toplamda güzel sanatlar alanı için en az 550 puan, diğer alanlar için en az 700 puan almış olmak ve Tablo 4\'teki faaliyetlerden en az birini gerçekleştirmiş olmak."',
        [
            ['aciklama' => 'Sanatsal etkinliklerden (sergi, gösterim, tasarım) en az 100 puan (ÜAK özel koşullarına uygun)', 'bilgi' => true],
            ['aciklama' => 'SCIE/SSCI/AHCI veya ESCI/Scopus kapsamında başlıca yazar olduğu en az 1 makale', 'kategori' => 'makale', 'kaynaklar' => $idxUluslararasiVeEsci, 'yazar' => 'baslica', 'min_adet' => 1],
            ['aciklama' => 'TR Dizin kapsamında en az 4 makale', 'kategori' => 'makale', 'kaynaklar' => $idxTrDizin, 'min_adet' => 4],
            ['aciklama' => 'Bunların en az 1 tanesi tek yazarlı', 'kategori' => 'makale', 'kaynaklar' => $idxTrDizin, 'yazar' => 'tek', 'min_adet' => 1],
            ['aciklama' => 'Tablo 4: metot/albüm çalışması vb. en az 1 ek faaliyet', 'bilgi' => true],
            ['aciklama' => 'TR Dizin koşulu yerine SCIE/SSCI/AHCI veya ESCI/Scopus makalesi de kabul edilir', 'bilgi' => true],
        ],
    ],

    /*
    ╔══════════════════════════════════════════════════════════════════════════╗
    ║  Atatürk Üniversitesi
    ╚══════════════════════════════════════════════════════════════════════════╝
    | Kaynak: pdf/17536930072.ataturkuniversitesi.pdf
    | Ek 1 iki tablo hâlinde, ÜAK temel alanlarına göre:
    |   A) Fen Bilimleri ve Matematik · Mimarlık Planlama ve Tasarım · Mühendislik · Sağlık · Ziraat
    |   B) Eğitim · Filoloji · Güzel Sanatlar · Hukuk · İlahiyat · Sosyal Beşeri İdari · Spor
    | Puanlar Atatürk'ün kendi "bölge/gösterge" setinden (Ek 2) toplanır.
    | MADDE 6: tüm kadrolarda merkezi yabancı dil sınavından en az 70 puan.
    | A grubunda indeks kümesi SCIE/SSCI/AHCI — motorun index_min'i bunu birebir sayar.
    | B grubunda küme SCIE/SSCI/AHCI/ESCI/SCOPUS; motor ESCI/Scopus'u indeks saymadığı için
    |   o koşullar index_min yerine "belge ile" (bilgi) koşulu olarak yazıldı.
    */

    // ── Dr. Öğr. Üyesi ──
    [
        'Atatürk Üniversitesi', 'dr_ogr_uyesi', ['fen', 'muhendislik', 'saglik', 'ziraat'], 100, 40, 18, 70,
        'A grubu (Fen/Mühendislik/Sağlık/Ziraat): 0 ve 2. bölgelerden toplam en az 100 puan; makalelerden en az 40 puan. YDS en az 70. Tablo dipnotu: "En az 18 puanın SCIE, SSCI veya AHCI kapsamındaki dergilerde yapılan tam metin makalelerden alınması gerekir. İç Mimarlık, Mimarlık, Şehir ve Bölge Planlama, Matematik ve İstatistik bölümleri için en az 9 puanın SCIE, SSCI veya AHCI kapsamındaki dergilerde yapılan yayınlardan alınması gerekir."',
    ],
    // Mimarlık için indeks alt sınırı düşük: "İç Mimarlık, Mimarlık, Şehir ve Bölge Planlama,
    // Matematik ve İstatistik bölümleri için en az 9 puan".
    [
        'Atatürk Üniversitesi', 'dr_ogr_uyesi', 'mimarlik', 100, 40, 9, 70,
        'A grubu (Mimarlık, Planlama ve Tasarım): toplam en az 100 puan; makalelerden en az 40 puan, bunun en az 9 puanı SCIE/SSCI/AHCI dergilerden. YDS en az 70.',
    ],
    [
        'Atatürk Üniversitesi', 'dr_ogr_uyesi', ['sosyal', 'egitim', 'filoloji', 'guzel_sanatlar', 'ilahiyat', 'spor'], 100, 30, null, 70,
        'B grubu (Sosyal/Eğitim/Filoloji/Güzel Sanatlar/İlahiyat/Spor): 0 ve 2. bölgelerden toplam en az 100 puan; makalelerden en az 30 puan. YDS en az 70. Tablo dipnotu: "En az 12 puanın SCIE, SSCI, AHCI, ESCI veya SCOPUS kapsamındaki dergilerde yapılan yayınlardan alınması gerekir."',
        [
            ['aciklama' => 'Makale puanının en az 12 puanı SCIE/SSCI/AHCI/ESCI/Scopus kapsamında olmalı', 'bilgi' => true],
        ],
    ],
    // Hukuk'ta indeks alt sınırı 12 yerine 5.
    [
        'Atatürk Üniversitesi', 'dr_ogr_uyesi', 'hukuk', 100, 30, null, 70,
        'B grubu (Hukuk): toplam en az 100 puan; makalelerden en az 30 puan. YDS en az 70. Tablo dipnotu: "Hukuk temel alanı için en az 5 puanın SCIE, SSCI, AHCI, ESCI veya SCOPUS kapsamındaki dergilerde yapılan yayınlardan alınması gerekir."',
        [
            ['aciklama' => 'Makale puanının en az 5 puanı SCIE/SSCI/AHCI/ESCI/Scopus kapsamında olmalı', 'bilgi' => true],
        ],
    ],

    // ── Doçent ──
    [
        'Atatürk Üniversitesi', 'docentlik', ['fen', 'mimarlik', 'muhendislik', 'saglik', 'ziraat'], 100, null, null, 70,
        'A grubu: ÜAK doçent unvanı + doçentlik havuz puanından toplam en az 100 puan. YDS en az 70.',
        [
            ['aciklama' => 'SCIE/SSCI/AHCI kapsamında en az 2 tam metin makale', 'kategori' => 'makale', 'kaynaklar' => $idxUluslararasi, 'min_adet' => 2],
            ['aciklama' => 'AR-GE projelerinden en az 30 puan: "Aday, bu puanın tamamını ya yürütücüsü olduğu ulusal/uluslararası AR-GE projelerinden sağlamak ya da en az bir yürütücü olduğu AR-GE projesi olmak şartıyla, kalan puanı Q1 veya Q2 kategorisindeki dergilerde yapmış olduğu yayınlardan alması gerekir."', 'bilgi' => true],
            ['aciklama' => '"Doçentlik havuz puanından alınması gereken puanlara, ÜAK doçentlik başvuru asgari şartlarını sağlamak için kullanılan makaleler dahil edilmez."', 'bilgi' => true],
        ],
    ],
    [
        'Atatürk Üniversitesi', 'docentlik', ['sosyal', 'egitim', 'filoloji', 'guzel_sanatlar', 'hukuk', 'ilahiyat', 'spor'], 80, null, null, 70,
        'B grubu: ÜAK doçent unvanı + doçentlik havuz puanından toplam en az 80 puan. YDS en az 70.',
        [
            ['aciklama' => 'SCIE/SSCI/AHCI/ESCI/Scopus kapsamında en az 1 tam metin makale', 'kategori' => 'makale', 'kaynaklar' => $idxUluslararasiVeEsci, 'min_adet' => 1],
            ['aciklama' => 'AR-GE projelerinden en az 20 puan: "Aday, bu puanın tamamını ya yürütücüsü olduğu ulusal/uluslararası AR-GE projelerinden sağlamak ya da en az bir yürütücü olduğu AR-GE projesi olmak şartıyla, kalan puanı Q1 veya Q2 kategorisindeki dergilerde yapmış olduğu yayınlardan alması gerekir."', 'bilgi' => true],
            ['aciklama' => '"Doçentlik havuz puanından alınması gereken puanlara, ÜAK doçentlik başvuru asgari şartlarını sağlamak için kullanılan makaleler dahil edilmez."', 'bilgi' => true],
        ],
    ],

    // ── Profesör ──
    [
        'Atatürk Üniversitesi', 'profesorluk', ['fen', 'muhendislik', 'saglik', 'ziraat'], 250, 60, 30, 70,
        'A grubu: ÜAK doçentlik belgesi + tüm bölgelerden toplam en az 250 puan; makalelerden en az 60 puan. YDS en az 70. Tablo dipnotu: "En az 30 puanın SCIE, SSCI veya AHCI kapsamındaki dergilerde yapılan tam metin makalelerden alınması gerekir. İç Mimarlık, Mimarlık, Şehir ve Bölge Planlama, Matematik ve İstatistik bölümleri için en az 20 puanın SCIE, SSCI veya AHCI kapsamındaki dergilerde yapılan yayınlardan alınması gereklidir."',
        [
            ['aciklama' => 'AR-GE projelerinden en az 40 puan: "Aday, bu puanın tamamını ya yürütücüsü olduğu ulusal/uluslararası AR-GE projelerinden sağlamak ya da en az bir yürütücü olduğu AR-GE projesi olmak şartıyla, kalan puanı Q1 veya Q2 kategorisindeki dergilerde yapmış olduğu yayınlardan alması gerekir."', 'bilgi' => true],
            ['aciklama' => '7. bölgeden en az 30 puan alınmalı', 'bilgi' => true],
        ],
    ],
    [
        'Atatürk Üniversitesi', 'profesorluk', 'mimarlik', 250, 60, 20, 70,
        'A grubu (Mimarlık, Planlama ve Tasarım): toplam en az 250 puan; makalelerden en az 60 puan, bunun en az 20 puanı SCIE/SSCI/AHCI dergilerden. YDS en az 70.',
        [
            ['aciklama' => 'AR-GE projelerinden en az 40 puan: "Aday, bu puanın tamamını ya yürütücüsü olduğu ulusal/uluslararası AR-GE projelerinden sağlamak ya da en az bir yürütücü olduğu AR-GE projesi olmak şartıyla, kalan puanı Q1 veya Q2 kategorisindeki dergilerde yapmış olduğu yayınlardan alması gerekir."', 'bilgi' => true],
            ['aciklama' => '7. bölgeden en az 30 puan alınmalı', 'bilgi' => true],
        ],
    ],
    [
        'Atatürk Üniversitesi', 'profesorluk', ['sosyal', 'egitim', 'filoloji', 'guzel_sanatlar', 'hukuk', 'ilahiyat', 'spor'], 200, 30, null, 70,
        'B grubu: ÜAK doçentlik belgesi + tüm bölgelerden toplam en az 200 puan; makalelerden en az 30 puan. YDS en az 70. Tablo dipnotları: "En az 20 puanın SCIE, SSCI, AHCI, ESCI veya SCOPUS kapsamındaki dergilerde yapılan yayınlardan alınması gerekir." ve diğer çalışmalar için "01.03, 01.04, 06.05 veya 06.10 nolu alandan olmalı veya ÜAK tarafından doçentlik başvurusunda ilgili alan için kabul edilen alan endekslerinde yer alan dergilerde yapılan yayınlardan alınması gerekir."',
        [
            ['aciklama' => 'Makale puanının en az 20 puanı SCIE/SSCI/AHCI/ESCI/Scopus kapsamında olmalı', 'bilgi' => true],
            ['aciklama' => 'AR-GE projelerinden en az 20 puan: "Aday, bu puanın tamamını ya yürütücüsü olduğu ulusal/uluslararası AR-GE projelerinden sağlamak ya da en az bir yürütücü olduğu AR-GE projesi olmak şartıyla, kalan puanı Q1 veya Q2 kategorisindeki dergilerde yapmış olduğu yayınlardan alması gerekir."', 'bilgi' => true],
            ['aciklama' => 'Diğer çalışmalardan en az 20 puan (ÜAK alan endeksi dergileri)', 'bilgi' => true],
            ['aciklama' => '7. bölgeden en az 20 puan alınmalı', 'bilgi' => true],
        ],
    ],
];

// Grup satırlarını (3. eleman dizi olanlar) alan başına ayrı satıra açar.
$esikler = [];

foreach ($satirlar as $satir) {
    foreach ((array) $satir[2] as $alan) {
        $satir[2] = $alan;
        $esikler[] = $satir;
    }
}

return $esikler;
