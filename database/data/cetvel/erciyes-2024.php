<?php

/**
 * ERCİYES ÜNİVERSİTESİ — Tablo 7: Akademik Faaliyet Türü ve Puanlama Tablosu
 * Kaynak: pdf/17536993342.erciyesuniverstesi.pdf
 *
 * TEK ORTAK PUANLAMA TABLOSU, ALTI ALAN İÇİN AYRI ASGARİ TABLO. Tablo 1-6
 * alan grubu başına asgari/azami puanları verirken faaliyet türlerinin
 * puanları burada, Tablo 7'de tanımlı. Bu yüzden tek cetvel yeterli — Marmara
 * gibi alan başına ayrı tablo yok.
 *
 * MAKALE ÜÇ TÜRE AYRILMIŞ ve üçü de aynı çeyreklik kırılımını taşıyor:
 *   1  özgün araştırma makalesi ve derleme   80/60/40/30/20/15/10/6
 *   2  short / brief communication            60/45/30/20/15/12/8/4
 *   3  vaka raporu, teknik not, editöre mektup 40/30/20/15/10/…
 * `turler` boyutu tam bunun için var; üçü de girildi.
 *
 * "EN ÜST %10'LUK DİLİM" AYRI BİR KADEME: Q1'in de üstünde, 80 puan. Kaynak
 * sözlüğünde bu ayrım yok; 1a girilmedi çünkü Q1 etiketine düşer ve `puan()`
 * en yükseği aldığı için her Q1 makale 80 sayılırdı.
 *
 * GİRİLMEYEN BÖLÜMLER: 5 (bilimsel toplantı), 6 (atıf), 7 (proje), 9 (ödül).
 * Bunlar Tablo 1-6'da yalnızca AZAMİ sınırla anılıyor, asgari koşul
 * üretmiyorlar; toplam puana katkıları girilmediği için hesaplanan toplam
 * eksik kalabilir.
 *
 * KODLAR BİZE AİT — KAYNAKTA SATIR KODU YOK. Cetvel kodlarının SAYISAL
 * ÇEKİRDEĞİ kaynağın madde/bölüm numarasıdır; baştaki harf tabloyu ya da
 * eki, sondaki harf şıkkı gösterir ve ikisi de bizim eklediğimiz parçadır.
 * Koşullar bu kodlara atıf yaptığı için değiştirilmemeli; kaynakla
 * karşılaştırırken kodun sayısal çekirdeğine bakılmalı.
 */

return [
    'kapsam_notu' => 'Puanlar Erciyes Üniversitesi Tablo 7\'den. Bilimsel toplantı, atıf, proje ve '
        .'ödül bölümleri girilmedi; yönergede yalnızca azami sınır taşıyorlar. Ayrıca "en üst '
        .'%10\'luk dilim" kademesi kaynak sözlüğünde Q1\'den ayrılamadığı için girilmedi. Gerçek '
        .'toplamınız burada görünenden yüksek olabilir, düşük olamaz.',

    'maddeler' => [
        // ── 1. BİLİMSEL MAKALE (özgün araştırma ve derleme) ──
        // Sözlük 17.09.2026'da dilim kademesini açtı.
        '1a' => ['baslik' => 'WoS en üst %10\'luk dilimli dergide özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (İlk %10)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 80],
        '1b' => ['baslik' => 'WoS Q1 dergide özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 60],
        '1c' => ['baslik' => 'WoS Q2 dergide özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 40],
        '1ç' => ['baslik' => 'WoS Q3 dergide özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 30],
        '1d' => ['baslik' => 'WoS Q4 dergide özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 20],
        '1e' => ['baslik' => 'WoS diğer veya uluslararası alan indeksli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 15],
        '1f' => ['baslik' => 'ULAKBİM TR Dizin veya diğer uluslararası indeksli yayın', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Uluslararası İndeks', 'Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 10],
        '1g' => ['baslik' => 'Diğer ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 6],

        // ── 2. BİLİMSEL MAKALE (short / brief communication) ──
        '2b' => ['baslik' => 'WoS Q1 dergide kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['kisa_makale'], 'puan' => 45],
        '2c' => ['baslik' => 'WoS Q2 dergide kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['kisa_makale'], 'puan' => 30],
        '2ç' => ['baslik' => 'WoS Q3 dergide kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['kisa_makale'], 'puan' => 20],
        '2d' => ['baslik' => 'WoS Q4 dergide kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['kisa_makale'], 'puan' => 15],
        '2e' => ['baslik' => 'WoS diğer veya alan indeksli dergide kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI'], 'turler' => ['kisa_makale'], 'puan' => 12],
        '2f' => ['baslik' => 'TR Dizin veya diğer indeksli kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Uluslararası İndeks', 'Scopus'], 'turler' => ['kisa_makale'], 'puan' => 8],
        '2g' => ['baslik' => 'Diğer ulusal hakemli dergide kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['kisa_makale'], 'puan' => 4],

        // ── 3. BİLİMSEL MAKALE (vaka raporu, teknik not, editöre mektup) ──
        '3b' => ['baslik' => 'WoS Q1 dergide vaka raporu, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['vaka_teknik_not'], 'puan' => 30],
        '3c' => ['baslik' => 'WoS Q2 dergide vaka raporu, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['vaka_teknik_not'], 'puan' => 20],
        '3ç' => ['baslik' => 'WoS Q3 dergide vaka raporu, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['vaka_teknik_not'], 'puan' => 15],
        '3d' => ['baslik' => 'WoS Q4 dergide vaka raporu, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['vaka_teknik_not'], 'puan' => 10],

        // ── 4. KİTAP ──
        '4a' => ['baslik' => 'Özgün kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası/Ulusal Kitap'], 'puan' => 40],
        '4c' => ['baslik' => 'Özgün kitap bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Kitap Bölümü'], 'puan' => 20],
        '4ç' => ['baslik' => 'Özgün ders kitabı yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 30],
        '4f' => ['baslik' => 'Çeviri kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 20],
        '4ğ' => ['baslik' => 'Çeviri kitap bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 5],
        '4h' => ['baslik' => 'Ansiklopedide konu veya madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 5],
        '4b' => ['baslik' => 'Özgün kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 30],
        '4g' => ['baslik' => 'Çeviri kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 10],

        // ── 8. FİKRÎ SINAİ MÜLKİYET HAKLARI ──
        '8a' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 80],
        '8b' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 40],
        '8c' => ['baslik' => 'Faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 20],
        '8ç' => ['baslik' => 'Endüstriyel tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım'], 'puan' => 20],
        // Kaynak 5/d düzenleme kurulu başkanlığını "Uluslararası: 10,
        // Ulusal: 5" diye yazıyor; iki kapsam tek satırda 5 puanla
        // birleşmişti.
        '8d-u' => ['baslik' => 'Uluslararası bilimsel toplantı düzenleme kurulu başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 10],
        '8d' => ['baslik' => 'Ulusal bilimsel toplantı düzenleme kurulu başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Ulusal)'], 'puan' => 5],
        '8e' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 3],
        '8e-u' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 5],
    ],

    'gruplar' => [
        // Tablo 1-6'nın asgari puan satırlarının birebir kullandığı aralıklar.
        // 1(a-d): en üst %10 dilim + Q1-Q4. 1a girilmediği için Q1-Q4 kalıyor.
        '1(a-d)' => ['1b', '1c', '1ç', '1d'],
        '1(e-g)' => ['1e', '1f', '1g'],
        '2(a-g)' => ['2*'],
        '3(a-g)' => ['3*'],
        '4(a-h)' => ['4*'],
        '8(a-ç)' => ['8*'],
        'MAKALE' => ['1*', '2*', '3*'],
    ],

    'grup_tavanlari' => [
        // Tablo 1'in azami sütunundan: 1(e-g), 2, 3 ve 4 birlikte en çok 50
        // (Dr/Doçent) — profesörde 100. Motor kadro bazlı tavan uygulamadığı
        // için en yüksek kadronun sınırı kayıtlı.
        '4(a-h)' => 100,
    ],
];
