<?php

/**
 * GAZİANTEP ÜNİVERSİTESİ — EK Puanlama Tablosu
 * Kaynak: pdf/1768888754547.gaziantep-kriter-19012026.pdf (19/01/2026)
 *
 * TEK ORTAK PUAN TABLOSU, DÖRT BİLİM ALANI İÇİN AYRI EŞİK. Koşullar tabloya
 * madde numarasıyla atıf yapıyor ("1(a) maddesi kapsamında en az 120 puan",
 * "4 numaralı maddeden en az 12", "5 nolu maddeden BAP hariç en az 45"), o
 * yüzden madde numaraları birebir korundu.
 *
 * PROJE ORANLARI MADDEYE GÖMÜLDÜ. Yönerge proje puanını görev türüne göre
 * çarpıyor: koordinatör/yürütücü %100, araştırmacı/uzman %60, danışman/bursiyer
 * %20. Motor tarafında ayrı bir çarpan mekanizması yok; her proje kalemi üç
 * role bölünüp puanı önceden çarpıldı (5-tubitak-y / -a / -d gibi). Böylece
 * `roller` filtresi zaten var olan alanla çalışıyor.
 *
 * "DEVAM EDEN PROJELER İÇİN TOPLAM PUANIN %50'Sİ" kuralı uygulanamadı:
 * faaliyet kaydı projenin tamamlanıp tamamlanmadığını tutmuyor. Devam eden
 * projelerde puan olduğundan YÜKSEK görünür.
 *
 * TÜBİTAK PROGRAMLARI TEK ETİKETE DÜŞÜYOR (çağrılı 150, 1001 120, 1005/3501
 * 100, 1002-A/3001 60, BİDEB 15…), kaynak sözlüğünde hepsi 'TÜBİTAK'. Aynı
 * etikete düşen kalemlerde daima EN DÜŞÜK puan tutuldu.
 *
 * GİRİLMEYENLER: sanatsal etkinlik bölümleri (12-32 arası maddeler; tiyatro,
 * opera, icra, bestecilik, şeflik, müzik teknolojisi), burslar, jüri üyelikleri
 * ve sportif etkinlikler — kaynak sözlüğünde karşılıkları yok.
 *
 * KODLAR BİZE AİT — KAYNAKTA SATIR KODU YOK. Cetvel kodlarının SAYISAL
 * ÇEKİRDEĞİ kaynağın madde/bölüm numarasıdır; baştaki harf tabloyu ya da
 * eki, sondaki harf şıkkı gösterir ve ikisi de bizim eklediğimiz parçadır.
 * Koşullar bu kodlara atıf yaptığı için değiştirilmemeli; kaynakla
 * karşılaştırırken kodun sayısal çekirdeğine bakılmalı.
 */

return [
    'kapsam_notu' => 'Puanlar Gaziantep Üniversitesi EK Puanlama Tablosundan (19/01/2026). Proje '
        .'puanı görev türüne göre çarpılır (yürütücü tam, araştırmacı %60, danışman/bursiyer %20) '
        .'ve bu hesap uygulanıyor; ancak DEVAM EDEN projelerde yönergenin öngördüğü %50 indirimi '
        .'uygulanamıyor, o kalemler tam puanla görünür. Sanatsal etkinlik, burs, jüri ve sportif '
        .'etkinlik bölümlerinin kaynak sözlüğünde karşılığı olmadığı için girilmedi.',

    'maddeler' => [
        '1a-Q1' => ['baslik' => 'SCIE, SSCI veya AHCI dergide özgün araştırma veya derleme makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 80],
        '1a-Q2' => ['baslik' => 'SCIE, SSCI veya AHCI dergide özgün araştırma veya derleme makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 60],
        '1a-Q3' => ['baslik' => 'SCIE, SSCI veya AHCI dergide özgün araştırma veya derleme makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 45],
        '1a-Q4' => ['baslik' => 'SCIE, SSCI veya AHCI dergide özgün araştırma veya derleme makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 30],
        '1b-Q1' => ['baslik' => 'SCIE, SSCI veya AHCI dergide editöre mektup, kısa bildirim, olgu sunumu veya teknik not', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 25],
        '1b-Q2' => ['baslik' => 'SCIE, SSCI veya AHCI dergide editöre mektup, kısa bildirim, olgu sunumu veya teknik not', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 15],
        '1b-Q3' => ['baslik' => 'SCIE, SSCI veya AHCI dergide editöre mektup, kısa bildirim, olgu sunumu veya teknik not', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 10],
        '1b-Q4' => ['baslik' => 'SCIE, SSCI veya AHCI dergide editöre mektup, kısa bildirim, olgu sunumu veya teknik not', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 5],
        '1c' => ['baslik' => 'ESCI veya SCOPUS dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 20],
        '1d' => ['baslik' => 'ESCI veya SCOPUS dergide editöre mektup, olgu sunumu veya teknik not', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 7],
        '1e' => ['baslik' => 'TR-Dizin ulusal hakemli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 15],
        '1g' => ['baslik' => 'Uluslararası hakemli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 5],
        '1h' => ['baslik' => 'Ulusal hakemli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 4],
        '2a' => ['baslik' => 'SSCI, SCIE veya AHCI dergilerde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 2],
        '2b' => ['baslik' => 'Kitaplarda ve diğer yayınlarda yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap', 'TR Dizin', 'Diğer', 'Patent'], 'puan' => 1],
        '3a' => ['baslik' => 'ACQWEB veya Books Citation Index taranan uluslararası kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 100],
        '3b' => ['baslik' => 'ACQWEB veya BKCI taranan uluslararası kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 30],
        '3c' => ['baslik' => 'Diğer uluslararası yayınevi kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 40],
        '3d' => ['baslik' => 'Diğer uluslararası yayınevi kitabında bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 10],
        '3g' => ['baslik' => 'Uluslararası kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 10],
        '3h' => ['baslik' => 'Uluslararası kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 4],
        '4a1' => ['baslik' => 'Uluslararası etkinlikte tam metin basılmış sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 4],
        '4a2' => ['baslik' => 'Uluslararası etkinlikte özeti basılmış sözlü bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 2],
        '4a4' => ['baslik' => 'Belgelendirilmiş davetli konuşmacı olma', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 5],
        '4b1' => ['baslik' => 'Ulusal etkinlikte tam metin basılmış sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 3],
        '4b3' => ['baslik' => 'Ulusal etkinlikte özeti basılmış sözlü bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 1],
        '5-tubitak-y' => ['baslik' => 'TÜBİTAK Ar-Ge destek programı projesi (yürütücü)', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 15],
        '5-tubitak-a' => ['baslik' => 'TÜBİTAK Ar-Ge destek programı projesi (araştırmacı)', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci'], 'puan' => 9],
        '5-tubitak-d' => ['baslik' => 'TÜBİTAK Ar-Ge destek programı projesi (danışman veya bursiyer)', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 3],
        '5-ab-y' => ['baslik' => 'Avrupa Birliği Ar-Ge veya hibe programı projesi (yürütücü)', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 50],
        '5-ab-a' => ['baslik' => 'Avrupa Birliği Ar-Ge veya hibe programı projesi (araştırmacı)', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci'], 'puan' => 30],
        '5-ab-d' => ['baslik' => 'Avrupa Birliği Ar-Ge veya hibe programı projesi (danışman veya bursiyer)', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 10],
        '5-ulus-y' => ['baslik' => 'NATO, UNDP, UNESCO veya Dünya Bankası gibi uluslararası program projesi (yürütücü)', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 150],
        '5-ulus-a' => ['baslik' => 'NATO, UNDP, UNESCO veya Dünya Bankası gibi uluslararası program projesi (araştırmacı)', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci'], 'puan' => 90],
        '5-ulus-d' => ['baslik' => 'NATO, UNDP, UNESCO veya Dünya Bankası gibi uluslararası program projesi (danışman veya bursiyer)', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 30],
        '5-kamu-y' => ['baslik' => 'Kamu kurum ve kuruluşlarından alınan proje (yürütücü)', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 15],
        '5-kamu-a' => ['baslik' => 'Kamu kurum ve kuruluşlarından alınan proje (araştırmacı)', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['arastirmaci'], 'puan' => 9],
        '5-kamu-d' => ['baslik' => 'Kamu kurum ve kuruluşlarından alınan proje (danışman veya bursiyer)', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 3],
        '5-sanayi-y' => ['baslik' => 'Üniversite-sanayi iş birliği projesi (yürütücü)', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 30],
        '5-sanayi-a' => ['baslik' => 'Üniversite-sanayi iş birliği projesi (araştırmacı)', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci'], 'puan' => 18],
        '5-sanayi-d' => ['baslik' => 'Üniversite-sanayi iş birliği projesi (danışman veya bursiyer)', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 6],
        '5-bap-y' => ['baslik' => 'BAP projesi (yürütücü)', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 10],
        '5-bap-a' => ['baslik' => 'BAP projesi (araştırmacı)', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['arastirmaci'], 'puan' => 6],
        '5-bap-d' => ['baslik' => 'BAP projesi (danışman veya bursiyer)', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 2],
        '5n' => ['baslik' => 'Tescillenmiş uluslararası patent (incelemeli)', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 140],
        '5o' => ['baslik' => 'Tescillenmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 60],
        '5r' => ['baslik' => 'Tescillenmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım'], 'puan' => 40],
        '6a' => ['baslik' => 'ACQWEB veya BKCI taranan uluslararası kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 80],
        '6b' => ['baslik' => 'Diğer uluslararası yayınevi kitabında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 30],
        '6d' => ['baslik' => 'Ders kitabı editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 30],
        '6i' => ['baslik' => 'Dergilerde baş editörlük veya yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi', 'TR Dizin Dergi', 'Yayın Kurulu Üyeliği'], 'puan' => 3],
        '7a' => ['baslik' => 'Hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 2],
        '8a1' => ['baslik' => 'Yönettiği tamamlanmış doktora veya uzmanlık tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 60],
        '8a2' => ['baslik' => 'Yönettiği tamamlanmış yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 30],
        '8b' => ['baslik' => 'Her yıl için verilen her ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 4],
    ],

    'gruplar' => [
        // Koşulların birebir andığı madde numaraları.
        '1a' => ['1a-*'],
        '4' => ['4*'],
        // "5 nolu maddeden (BAP hariç)" — BAP kalemleri kümenin dışında.
        '5-BAP-haric' => ['5-tubitak-*', '5-ab-*', '5-ulus-*', '5-kamu-*', '5-sanayi-*', '5n', '5o', '5r'],
        '8a' => ['8a*'],
        'MAKALE' => ['1*'],

        // Yalnızca tavan taşıyan kümeler.
        'ATIF' => ['2*'],
        '3c-KITAP' => ['3c'],
        '3d-BOLUM' => ['3d'],
        '5-KAMU' => ['5-kamu-*'],
        '5-SANAYI' => ['5-sanayi-*'],
        '5-BAP' => ['5-bap-*'],
        '6b-EDITORLUK' => ['6b'],
        'EDITORLUK-KURUL' => ['6*'],
        'HAKEMLIK' => ['7*'],
    ],

    /*
     * Kaynağın tavanları. 01.09.2026'ya kadar yalnızca "8) Eğitime Katkı
     * (Toplamda en fazla 200 puan)" girilmişti; kalan dokuzu tavansızdı ve
     * tavansız bölüm doğrudan fazla saydırır (§0).
     *
     * En pahalısı ATIF: kaynak "Not 1: Atıflardan en fazla 200 puan
     * hesaplamada kullanılabilir" diyor, cetvel sınırsız sayıyordu.
     *
     * EDİTÖRLÜK İKİ KATMANLI: 6b'nin kendi tavanı (100) var, ayrıca "Not 2:
     * Editörlük ve Yayın Kurulu Üyeliği kısmından en fazla 150 puan
     * hesaplamada kullanılabilir" bölümün tamamını 150'de kesiyor. Hakemlik
     * (7) ayrı bir bölüm, 150'nin dışında.
     *
     * Cetvelde satırı olmadığı için girilmeyenler: 3e-3f (ulusal kitap
     * 28/20), 5f TGB (40), 5ı Bilim ve Toplum (50), 5i BİDEB (40), 6c ulusal
     * kitap editörlüğü (100) ve "DİĞER PUANLAMALAR" bölümünün 80/20'lik
     * tavanları (ödül satırları girilmedi).
     */
    'grup_tavanlari' => [
        'ATIF' => 200,              // "Not 1: Atıflardan en fazla 200 puan"
        '3c-KITAP' => 120,          // "Bu kapsamda en fazla 120 puan alınabilir."
        '3d-BOLUM' => 40,           // "Bu kapsamında en fazla 40 puan alınabilir."
        '5-KAMU' => 50,             // "ğ) Diğer kamu kurum … (en fazla 50 puan)"
        '5-SANAYI' => 50,           // "h) Üniversite-Sanayi İşbirliği (en fazla 50 puan)"
        '5-BAP' => 50,              // "j) BAP (en fazla 50 puan alınabilir)"
        '6b-EDITORLUK' => 100,      // "b) … editörlük. (Bu kapsamda en fazla 100 puan)"
        'EDITORLUK-KURUL' => 150,   // "Not 2: Editörlük ve Yayın Kurulu Üyeliği kısmından en fazla 150 puan"
        'HAKEMLIK' => 20,           // "7) Hakemlik (Bu kapsamda en fazla 20 puan alınabilir)"
        '8a' => 200,                // "8) Eğitime Katkı (Toplamda en fazla 200 puan)"
    ],
];
