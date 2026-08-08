<?php

/*
|--------------------------------------------------------------------------
| MADDE KATALOGLARI — yönergelerin kendi puan cetvelleri
|--------------------------------------------------------------------------
|
| Şart ağacı (`esikler-agac.php`) `kaynak` etiketlerine değil MADDE KODUNA
| bağlanır, çünkü yönergeler alt-koşullarını kendi kod uzaylarıyla yazıyor:
| "1. Bölüm'den en az yarısı", "1.1c maddesinden 4 makale", "en az 18 puan
| SCIE/SSCI/AHCI kapsamındaki dergilerden".
|
| Her madde: ['baslik', 'kategori'?, 'kaynaklar'?, 'puan'?].
|   - 'kategori' yoksa kategori aranmaz.
|   - 'kaynaklar' yoksa o kategorideki tüm kaynaklar eşleşir.
|   - 'kaynaklar' => [] ise madde hiçbir faaliyetle eşleşmez (bkz. PROJEKSİYON).
|
| Bir faaliyet birden çok maddeye giriyorsa puanı EN YÜKSEK maddeden alınır —
| yönergelerin ortak kuralı ({@see MaddeKatalogu::puan()}).
|
|
| ── PROJEKSİYON NOTU ────────────────────────────────────────────────────────
|
| Uygulamanın `kaynak` sözlüğü (12 etiket) yönergelerin madde ayrımından DAHA
| KABA. Eşleyemediğimiz yerler aşağıda birebir sayılıdır; hiçbiri sessizce
| yuvarlanmadı:
|
|   1. AHCI'de çeyreklik yok. Uygulamada 'AHCI' tek etiket; cetvellerde Q2
|      karşılığına bağlandı (kodun ÜAK/İlahiyat setindeki 20 puanlık konumuyla
|      tutarlı olsun diye).
|   2. 'ESCI / Scopus' tek etiket, oysa Akdeniz ESCI'yi (50) ve SCOPUS'u (30)
|      ayırıyor. Puanı ŞİŞİRMEMEK için düşük olana (SCOPUS) bağlandı.
|   3. Akdeniz 1.1 ("ilk %10'luk kategori") ve Afyon 1.5/1.6 gibi maddelerin
|      karşılığı yok; 'kaynaklar' => [] ile tanımlı bırakıldı — kod cetvelde
|      duruyor ama hiçbir faaliyet eşleşmiyor.
|   4. Atatürk Ek-2'nin 150+ maddesinden yalnızca eşiklerin atıf yaptığı makale
|      ve kitap blokları (02.01, 02.02, 02.04) girildi. Proje/atıf/idari
|      maddeler girilmediği için o koşullar ağaçta `beyan` olarak duruyor.
|      (Akdeniz ve Afyon'un proje/patent/tez/bildiri blokları girildi.)
|
| Bir madde `roller` taşıyabilir: yönergeler proje ve tez danışmanlığı puanını
| adayın rolüne göre ayırıyor (Akdeniz 6.1 yürütücü 200 ↔ 6.2 araştırıcı 50).
|
| Kalıcı çözüm, kullanıcının genel bir `kaynak` etiketi yerine doğrudan
| yönergenin maddesini seçmesidir; bu katalog o adımın veri tarafıdır.
|
*/

return [

    /*
    ╔══════════════════════════════════════════════════════════════════════════╗
    ║  akdeniz-2026 — Akdeniz Üniversitesi Genel Akademik Faaliyet ve Puan Tablosu
    ╚══════════════════════════════════════════════════════════════════════════╝
    | Kaynak: pdf/17536928172.akdenizuniversitesi.pdf
    | 1. BÖLÜM: BİLİMSEL MAKALELER · 2. BÖLÜM: KİTAP · 3. BÖLÜM: ATIF
    | Kitap bölümü puanı, yönerge dipnotu gereği kitap puanının yarısıdır.
    */
    'akdeniz-2026' => [
        'maddeler' => [
            '1.1' => ['baslik' => 'SCI-Expanded/SSCI/AHCI ilk %10 dergide makale', 'kategori' => 'makale', 'kaynaklar' => [], 'puan' => 450],
            '1.2' => ['baslik' => 'SCI-Expanded/SSCI/AHCI Q1 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'puan' => 300],
            '1.3' => ['baslik' => 'SCI-Expanded/SSCI/AHCI Q2 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)', 'AHCI'], 'puan' => 150],
            '1.4' => ['baslik' => 'SCI-Expanded/SSCI/AHCI Q3 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'puan' => 90],
            '1.5' => ['baslik' => 'SCI-Expanded/SSCI/AHCI Q4 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'puan' => 75],
            '1.6' => ['baslik' => 'ESCI dergide makale', 'kategori' => 'makale', 'kaynaklar' => [], 'puan' => 50],
            '1.7' => ['baslik' => 'SCOPUS dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 30],
            '1.8' => ['baslik' => 'TR-Dizin dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 15],
            '1.9' => ['baslik' => 'SOBIAD/EBSCO/DOAJ/Index Copernicus dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'], 'puan' => 10],

            '2.6' => ['baslik' => 'Uluslararası yayınevi kitap editörlüğü/yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası/Ulusal Kitap'], 'puan' => 30],
            '2.6b' => ['baslik' => 'Uluslararası yayınevi kitap bölümü (kitabın yarısı)', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 15],
            '2.7' => ['baslik' => 'Ulusal yayınevi kitap editörlüğü/yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Tahkik (Tenkitli Metin)'], 'puan' => 20],
            '2.7b' => ['baslik' => 'Ulusal yayınevi kitap bölümü (kitabın yarısı)', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 10],

            '3.1' => ['baslik' => 'SCI-Expanded/SSCI/AHCI dergilerde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 5],
            '3.2' => ['baslik' => 'SENSE kategorisindeki kitaplarda yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 4],
            '3.3' => ['baslik' => 'Diğer kitap/hakemli dergilerde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 2],

            // 4. BÖLÜM: PATENT ve GİRİŞİMCİLİK
            '4.2' => ['baslik' => 'Uluslararası patent tescili', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 250],
            '4.6' => ['baslik' => 'Çeşit tescili / ıslahçı hakkı', 'kategori' => 'patent', 'kaynaklar' => ['Islahçı Hakkı / Çeşit Tescili'], 'puan' => 200],
            '4.3' => ['baslik' => 'Ulusal patent tescili', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 50],
            '4.9' => ['baslik' => 'Ticarileştirilmiş endüstriyel/sanatsal/mimari tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım', 'Yazılım', 'Ticarileştirme'], 'puan' => 30],
            '4.10' => ['baslik' => 'Ticarileştirilmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 25],

            // 5. BÖLÜM: LİSANSÜSTÜ TEZ DANIŞMANLIĞI
            '5.1' => ['baslik' => 'Doktora tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi'], 'puan' => 15],
            '5.2' => ['baslik' => 'Tıpta/diş/sanatta yeterlik tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 10],
            '5.3' => ['baslik' => 'Yüksek lisans tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 7],

            // 6. BÖLÜM: BİLİMSEL ARAŞTIRMA PROJELERİ — puan fon kaynağı × role göre
            '6.1' => ['baslik' => 'Uluslararası fonlu projede yürütücü/koordinatör', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 200],
            '6.2' => ['baslik' => 'Uluslararası fonlu projede araştırıcı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 50],
            '6.3' => ['baslik' => 'Ulusal fonlu projede yürütücü/koordinatör', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 50],
            '6.4' => ['baslik' => 'Ulusal fonlu projede araştırmacı veya bursiyer', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],
            '6.5' => ['baslik' => 'BAP projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 20],
            '6.6' => ['baslik' => 'BAP projesinde araştırıcı', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 5],

            // 7. BÖLÜM: BİLİMSEL TOPLANTI FAALİYETİ
            '7.1' => ['baslik' => 'SCI-Expanded/SSCI/AHCI dergide yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 8],
            '7.2' => ['baslik' => 'Uluslararası kongrede tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Davetli Konuşmacı'], 'puan' => 4],
            '7.3' => ['baslik' => 'Uluslararası kongrede özet bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 2],
            '7.4' => ['baslik' => 'Ulusal kongrede tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 2],
            '7.5' => ['baslik' => 'Ulusal kongrede özet bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 1],

            'T.1' => ['baslik' => 'Lisansüstü tezden üretilmiş yayın', 'kategori' => 'tez_yayini', 'puan' => 15],
        ],
        'gruplar' => [
            // Yönergenin dipnotlarının atıf yaptığı bölüm adları.
            'BOLUM_1_MAKALE' => ['1.*'],
            'BOLUM_2_KITAP' => ['2.*'],
            'BOLUM_3_ATIF' => ['3.*'],
            'BOLUM_4_PATENT' => ['4.*'],
            'BOLUM_5_TEZ' => ['5.*'],
            'BOLUM_6_PROJE' => ['6.*'],
            'BOLUM_7_BILDIRI' => ['7.*'],
            'YAYIN' => ['1.*', '2.*', 'T.1'],
        ],
    ],

    /*
    ╔══════════════════════════════════════════════════════════════════════════╗
    ║  afyon-2026 — Afyon Kocatepe Üniversitesi EK-1 Puanlama Tablosu
    ╚══════════════════════════════════════════════════════════════════════════╝
    | Kaynak: pdf/17536927832.afyonkocatepeuniversitesi.pdf, EK-1
    | 1. MAKALELER · 2. BİLDİRİLER · 3. KİTAPLAR · 9. SANAT VE TASARIM
    */
    'afyon-2026' => [
        'maddeler' => [
            '1.1a' => ['baslik' => 'Q1 kategorisinde özgün makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'puan' => 160],
            '1.1b' => ['baslik' => 'Q2 kategorisinde özgün makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)', 'AHCI'], 'puan' => 140],
            '1.1c' => ['baslik' => 'Q3 kategorisinde özgün makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'puan' => 120],
            '1.1d' => ['baslik' => 'Q4 kategorisinde özgün makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'puan' => 100],
            '1.2' => ['baslik' => 'ESCI veya SCOPUS dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 80],
            '1.3' => ['baslik' => 'TR Dizin dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 80],
            '1.4' => ['baslik' => 'Diğer hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'], 'puan' => 40],

            // 2. BİLDİRİLER
            '2.1' => ['baslik' => 'Uluslararası toplantıda tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin', 'Davetli Konuşmacı'], 'puan' => 10],
            '2.2' => ['baslik' => 'Uluslararası toplantıda özet bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 5],
            '2.3' => ['baslik' => 'Ulusal toplantıda tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 8],
            '2.4' => ['baslik' => 'Ulusal toplantıda özet bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 4],

            '3.1' => ['baslik' => 'Uluslararası yayınevi kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası/Ulusal Kitap'], 'puan' => 100],
            '3.2' => ['baslik' => 'Ulusal yayınevi kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Tahkik (Tenkitli Metin)'], 'puan' => 80],
            '3.3' => ['baslik' => 'Uluslararası yayınevi kitap bölümü', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 45],
            '3.4' => ['baslik' => 'Ulusal yayınevi kitap bölümü', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 40],

            'T.1' => ['baslik' => 'Lisansüstü tezden üretilmiş yayın', 'kategori' => 'tez_yayini', 'puan' => 40],
        ],
        'gruplar' => [
            // "1.1" yönergede başlık maddesi; alt bentleri 1.1a-d.
            '1.1' => ['1.1a', '1.1b', '1.1c', '1.1d'],
            'ULUSLARARASI' => ['1.1a', '1.1b', '1.1c', '1.1d'],
            'ULUSLARARASI_VE_ESCI' => ['1.1a', '1.1b', '1.1c', '1.1d', '1.2'],
            'Q1_Q3' => ['1.1a', '1.1b', '1.1c'],
            'MAKALE' => ['1.*'],
            'BILDIRI' => ['2.*'],
            'KITAP' => ['3.1', '3.2'],
            'KITAP_BOLUM' => ['3.3', '3.4'],
        ],
    ],

    /*
    ╔══════════════════════════════════════════════════════════════════════════╗
    ║  ataturk-2026 — Atatürk Üniversitesi Ek-2 Gösterge Tablosu (kısmi)
    ╚══════════════════════════════════════════════════════════════════════════╝
    | Kaynak: pdf/17536930072.ataturkuniversitesi.pdf, Ek-2
    | Yalnızca eşiklerin atıf yaptığı bloklar girildi:
    |   02.01 Uluslararası hakemli dergide makale
    |   02.02 Ulusal dergide makale
    |   02.04 Kitap
    | Proje (02.03), atıf ve idari görev blokları henüz girilmedi; o koşullar
    | ağaçta `beyan` düğümü olarak duruyor.
    */
    'ataturk-2026' => [
        'maddeler' => [
            '02.01.01' => ['baslik' => 'SCIE/SSCI/AHCI Q1 dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'puan' => 30],
            '02.01.02' => ['baslik' => 'SCIE/SSCI/AHCI Q2 veya SCOPUS Q1 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)', 'AHCI'], 'puan' => 24],
            '02.01.03' => ['baslik' => 'SCIE/SSCI/AHCI Q3 veya SCOPUS Q2 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'puan' => 16],
            '02.01.04' => ['baslik' => 'SCIE/SSCI/AHCI Q4 veya SCOPUS Q3 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'puan' => 10],
            '02.01.06' => ['baslik' => 'SCOPUS Q4, ESCI veya alan endeksi dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 8],
            '02.01.08' => ['baslik' => 'Diğer uluslararası hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'puan' => 5],
            '02.02.01' => ['baslik' => 'TR Dizin dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 6],
            '02.02.03' => ['baslik' => 'Diğer ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 4],

            '02.04.01' => ['baslik' => 'Kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 20],
            '02.04.02' => ['baslik' => 'Kitap bölümü yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Kitap Bölümü'], 'puan' => 10],

            'T.1' => ['baslik' => 'Lisansüstü tezden üretilmiş yayın', 'kategori' => 'tez_yayini', 'puan' => 10],
        ],
        'gruplar' => [
            'MAKALE' => ['02.01.*', '02.02.*'],
            // "SCIE, SSCI veya AHCI kapsamındaki dergilerde yapılan tam metin makaleler" (A grubu dipnotu)
            'INDEKS_SCIE_SSCI_AHCI' => ['02.01.01', '02.01.02', '02.01.03', '02.01.04'],
            // "SCIE, SSCI, AHCI, ESCI veya SCOPUS kapsamındaki dergiler" (B grubu dipnotu)
            'INDEKS_GENIS' => ['02.01.01', '02.01.02', '02.01.03', '02.01.04', '02.01.06'],
            'KITAP' => ['02.04.*'],
            'YAYIN' => ['02.01.*', '02.02.*', '02.04.*', 'T.1'],
        ],
    ],

];
