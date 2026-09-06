<?php

/**
 * BİTLİS EREN ÜNİVERSİTESİ — EK-1 Akademik Etkinlik Puan Tablosu
 * Kaynak: pdf/17536932232.bitliserenuniverstesi.pdf
 *
 * TEK ORTAK PUAN TABLOSU, ALAN GRUBUNA GÖRE AYRI EŞİK. Yönergenin koşulları
 * tabloya "A.1-A.8", "A.1-A.10", "A" ve "I" gibi harf-numara aralıklarıyla atıf
 * yaptığı için kodlar birebir korundu.
 *
 * YAZAR SAYISI ÇARPANI VAR (Dipnot 1): tam puanın yüzdesi hem yazar sayısına
 * hem de adayın sırasına göre değişiyor (1 yazarlı %100 … 10+ yazarlı 1. isim
 * %55, 3. isim ve sonrası %20). Bu matris motora girildi.
 *
 * ÇARPAN YALNIZCA YAZARLI ESERLERE UYGULANDI. Dipnot 1 atıfları açıkça dışarıda
 * bırakıyor; "diğer durumlarda çevirmen, raportör, proje yapanlar, editör, ödül
 * alanlar, patent sahibi veya düzenleyici sayısına eşit olarak bölünecektir"
 * diyor. Bu eşit bölme faaliyet kaydından türetilemediği için proje, patent,
 * editörlük ve ödül kalemlerinde uygulanmıyor — o kalemlerde puanınız
 * OLDUĞUNDAN YÜKSEK görünebilir.
 *
 * GİRİLMEYEN KALEMLER (kaynak sözlüğünde karşılığı yok):
 *   A.4 (indeks kapsamı dışındaki uluslararası hakemli dergiler) — sözlükte
 *       "indekssiz uluslararası dergi" diye bir kaynak yok; A.3 ile aynı kaynağa
 *       düşerdi ve yüksek olanı seçilirdi. Girilmedi, yani puan eksik sayılır.
 *   A.7.2 (uluslararası yayınevi kitap editörlüğü, 30) ve A.7.4/A.7.5
 *       (ansiklopedi) — sözlükteki "Kitap Editörlüğü" ve "Ansiklopedi Maddesi"
 *       kaynakları ulusal/uluslararası ayrımı taşımıyor. Kural gereği DÜŞÜK
 *       olan ulusal karşılıkları (A.8.2, A.8.7) girildi.
 *   C.3, C.4 (uluslararası dergi editörlükleri), G (toplumsal katkı), H (jüri),
 *       I (sanatsal etkinlikler), J (mimari tasarım) — sözlükte karşılıksız.
 *   D.2, D.3, D.4 (bilirkişilik, ödül, burs) ve E, F bölümlerinin bir kısmı.
 *
 * GÜZEL SANATLAR EKSİK KALIR: yönerge bu alanda puanın %25'ini "I"
 * kategorilerinden istiyor, I bölümü girilemedi. Bkz. yonerge/bitlis.php.
 */

return [
    'kapsam_notu' => 'Puanlar Bitlis Eren Üniversitesi EK-1 tablosundan. Makale, bildiri ve '
        .'kitap kalemlerinde puan yazar sayınıza ve sıranıza göre azaltılır (Dipnot 1) — bu '
        .'hesap uygulanıyor, ancak YAZAR LİSTESİNİ BOŞ BIRAKTIĞINIZ faaliyetlerde '
        .'uygulanamaz. Proje, patent, editörlük ve ödül kalemlerindeki "kişi sayısına eşit '
        .'bölünür" kuralı faaliyet kaydından türetilemediği için uygulanmıyor; o kalemlerde '
        .'puanınız olduğundan yüksek görünebilir. Sanatsal etkinlik (I) ve mimari tasarım (J) '
        .'bölümleri girilmedi.',

    // Dipnot 1 — Eserdeki yazar sayısına ve sıraya göre tam puanın yüzdesi.
    // Satır = yazar sayısı, sütun = adayın sırası.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'egitim_ogretim',
            'tez_danismanligi', 'idari_gorev', 'toplumsal_katki'],
        // Yönerge makale dışındaki kalemler için AYRI bir kural veriyor:
        // "Diğer durumlarda ise çevirmen, raportör, proje yapanlar, editör,
        // ödül alanlar, patent sahibi veya düzenleyici sayısına eşit olarak
        // bölünecektir." Yani makalenin sıraya bağlı kademe tablosu değil,
        // düz 1/n. Bunları `haric`te bırakmak FAZLA SAYMAK olurdu (§0).
        'kategoriler' => [
            'proje' => ['sonrasi_pay' => 1.0],
            'patent' => ['sonrasi_pay' => 1.0],
            'editorluk' => ['sonrasi_pay' => 1.0],
            'odul' => ['sonrasi_pay' => 1.0],
        ],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.0]],
            // 1. isim: 100, 100, 90, 85, 80, 75, 70, 65, 60, sonrası 55.
            'ilk' => ['kademeler' => [1 => 1.0, 2 => 1.0, 3 => 0.90, 4 => 0.85, 5 => 0.80,
                6 => 0.75, 7 => 0.70, 8 => 0.65, 9 => 0.60], 'sonrasi' => 0.55],
            'baslica' => ['kademeler' => [1 => 1.0, 2 => 1.0, 3 => 0.90, 4 => 0.85, 5 => 0.80,
                6 => 0.75, 7 => 0.70, 8 => 0.65, 9 => 0.60], 'sonrasi' => 0.55],
            'yazar_2' => ['kademeler' => [2 => 0.90, 3 => 0.80, 4 => 0.75, 5 => 0.70,
                6 => 0.65, 7 => 0.60, 8 => 0.55, 9 => 0.50], 'sonrasi' => 0.45],
            'yazar_3' => ['kademeler' => [3 => 0.70, 4 => 0.65, 5 => 0.60, 6 => 0.55,
                7 => 0.40, 8 => 0.30, 9 => 0.25], 'sonrasi' => 0.20],
            'yazar_4' => ['kademeler' => [4 => 0.55, 5 => 0.50, 6 => 0.45, 7 => 0.30,
                8 => 0.25], 'sonrasi' => 0.20],
            'yazar_5' => ['kademeler' => [5 => 0.40, 6 => 0.35, 7 => 0.20], 'sonrasi' => 0.20],
            'yazar_6' => ['kademeler' => [6 => 0.25], 'sonrasi' => 0.20],
            // Sırasını belirtmeyen aday o yazar sayısındaki EN DÜŞÜK yüzdeyi alır.
            'ortak' => ['kademeler' => [1 => 1.0, 2 => 0.90, 3 => 0.70, 4 => 0.55, 5 => 0.40,
                6 => 0.25], 'sonrasi' => 0.20],
        ],
    ],

    'maddeler' => [
        // ── A.1 SCI-E, SSCI ve AHCI kapsamındaki dergilerde yayınlar ──
        'A.1.1' => ['baslik' => 'SCI-E, SSCI veya AHCI dergide makale (derleme dâhil)', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 50],
        'A.1.2' => ['baslik' => 'SCI-E, SSCI veya AHCI dergide olgu sunumu, teknik not, editöre mektup, kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 25],

        // ── A.2 Uluslararası alan indeksleri (ISI Database veya Scopus) ──
        'A.2.1' => ['baslik' => 'Uluslararası alan indeksli (ESCI/Scopus) dergide makale (derleme dâhil)', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 30],
        'A.2.2' => ['baslik' => 'Uluslararası alan indeksli dergide olgu sunumu, teknik not, editöre mektup, kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 15],

        // ── A.3 Alan indeksleri dışındaki diğer indeksli dergiler ──
        'A.3.1' => ['baslik' => 'Diğer uluslararası indeksli dergide makale (derleme dâhil)', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 15],
        'A.3.2' => ['baslik' => 'Diğer uluslararası indeksli dergide olgu sunumu, teknik not, editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 8],

        // ── A.5 ULAKBİM-TR Dizin ──
        'A.5.1' => ['baslik' => 'TR Dizin dergide makale (derleme dâhil)', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 20],
        'A.5.2' => ['baslik' => 'TR Dizin dergide olgu sunumu, teknik not, editöre mektup, kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 10],

        // ── A.6 TR Dizin dışı ulusal hakemli dergiler ──
        'A.6.1' => ['baslik' => 'TR Dizin dışı ulusal hakemli dergide makale (derleme dâhil)', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 10],
        'A.6.2' => ['baslik' => 'TR Dizin dışı ulusal hakemli dergide olgu sunumu, teknik not, editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 5],

        // ── A.7 Uluslararası yayınevi kitapları ──
        'A.7.1' => ['baslik' => 'Uluslararası yayınevince basılmış kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 50],
        'A.7.3' => ['baslik' => 'Uluslararası yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 25],

        // ── A.8 Ulusal yayınevi kitapları ──
        'A.8.1' => ['baslik' => 'Ulusal yayınevince basılmış kitap veya ders kitabı yazarlığı (en az 50 sayfa)', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı'], 'puan' => 40],
        'A.8.2' => ['baslik' => 'Kitap editörlüğü (en az 50 sayfa)', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 25],
        'A.8.3' => ['baslik' => 'Kitap bölümü yazarlığı veya kitapçık (50 sayfadan az)', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 20],
        'A.8.4' => ['baslik' => 'Kitap çevirmenliği (en az 50 sayfa)', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 10],
        'A.8.6' => ['baslik' => 'Kitap bölümü, kitapçık veya makale çevirmenliği (50 sayfadan az)', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 5],
        'A.8.7' => ['baslik' => 'Ansiklopedi madde tanımlaması', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 4],

        // ── A.9 Uluslararası atıflar (adayın kendi atıfları hariç, atıf başına) ──
        'A.9.1' => ['baslik' => 'SCI-E, SSCI veya AHCI dergisinde atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
        'A.9.4' => ['baslik' => 'Uluslararası kitapta atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 3],

        // ── A.10 Ulusal atıflar ──
        'A.10.1' => ['baslik' => 'TR Dizin dergisinde atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
        'A.10.2' => ['baslik' => 'TR Dizin dışı hakemli dergide atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer'], 'puan' => 1],

        // ── B. BİLİMSEL TOPLANTILAR ──
        'B.1.1' => ['baslik' => 'Uluslararası bilimsel etkinlik kitabında sözlü tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Uluslararası Tam Metin (CPCI)'], 'puan' => 10],
        'B.1.3' => ['baslik' => 'Uluslararası bilimsel etkinlik kitabında bildiri özeti veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 6],
        'B.1.5' => ['baslik' => 'Uluslararası bilimsel etkinliğe çağrılı bildiri sunmak üzere davet edilmek', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 10],
        'B.2.1' => ['baslik' => 'Ulusal bilimsel etkinlik kitabında sözlü tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 7],
        'B.2.3' => ['baslik' => 'Ulusal bilimsel etkinlik kitabında bildiri özeti veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 4],

        // ── C. EDİTÖRLÜK, HAKEMLİK ──
        'C.1.1' => ['baslik' => 'SCI-E, SSCI veya AHCI dergide baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 30],
        'C.2.1' => ['baslik' => 'Uluslararası alan indeksli dergide baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 15],
        'C.5.1' => ['baslik' => 'Ulusal hakemli dergide baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 10],
        'C.5.2' => ['baslik' => 'Dergide yayın kurulu üyeliği, editörlük veya özel sayı editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 7],
        'C.5.3' => ['baslik' => 'Dergi hakemliği (makale başına)', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 1],

        // ── D. ARAŞTIRMA-GELİŞTİRME (tez projeleri hariç, Dipnot 3) ──
        'D.1.1' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen bilimsel projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 40],
        'D.1.2' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen bilimsel projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
        'D.1.3' => ['baslik' => 'TÜBİTAK, bakanlık veya kalkınma ajansı projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 30],
        'D.1.4' => ['baslik' => 'TÜBİTAK, bakanlık veya kalkınma ajansı projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],
        'D.1.5' => ['baslik' => 'Üniversite veya yerel kuruluşlarca desteklenen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 10],
        'D.1.6' => ['baslik' => 'Üniversite veya yerel kuruluşlarca desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 5],
        'D.5.1' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 60],
        'D.5.2' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 30],

        // ── E. EĞİTİM-ÖĞRETİM (Dipnot 4: toplam puanın %10'unu geçemez) ──
        'E.1.1' => ['baslik' => 'Tamamlanmış yüksek lisans tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 10],
        'E.1.2' => ['baslik' => 'Tamamlanmış doktora, uzmanlık veya sanatta yeterlik tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 20],
        'G.1.1' => ['baslik' => 'Bilimsel ya da mesleki kurum ve kuruluşların yönetiminde, kurullarında veya komisyonlarında görev', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dış Kuruluş Kurul Üyeliği (Ulusal)'], 'puan' => 8],
        'F.4.1' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)', 'Toplantı Düzenleme Başkanlığı (Ulusal)'], 'puan' => 10],
        'F.4.3' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 5],
        'F.4.4' => ['baslik' => 'Bilimsel toplantıda oturum başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Uluslararası)', 'Oturum Başkanlığı (Ulusal)'], 'puan' => 2],
    ],

    'gruplar' => [
        // Koşulların birebir andığı kategori aralıkları.
        // Nokta ŞART: 'A.1*' deseni 'A.10.1' atıf kalemini de yakalar ve atıflar
        // A.1-A.8 grubuna sızar. 'A.1.*' yalnızca A.1 altını eşler.
        'A.1-A.8' => ['A.1.*', 'A.2.*', 'A.3.*', 'A.5.*', 'A.6.*', 'A.7.*', 'A.8.*'],
        'A.1-A.10' => ['A.*'],
        'A' => ['A.*'],
        'A.1' => ['A.1.*'],
        'A.2' => ['A.2.*'],
        'A.5' => ['A.5.*'],
        'A.7.1' => ['A.7.1'],
    ],

    // Dipnot 4: E.1 ve E.2 kapsamındaki puanların toplamı, beyan edilen toplam
    // puanın %10'unu geçemez. Motor yüzdeye bağlı tavan tanımıyor; bu sınır
    // uygulanmıyor, tez danışmanlığı puanınız olduğundan yüksek görünebilir.
    'grup_tavanlari' => [],
];
