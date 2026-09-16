<?php

/**
 * KÜTAHYA SAĞLIK BİLİMLERİ ÜNİVERSİTESİ — EK-1 Faaliyetler ve Puanlama
 * Sistemi
 * Kaynak: pdf/17634002431.Kütahya Sağlık Bilimleri Üniversitesi Kriter.pdf
 * (24 sayfa; Senato 07.09.2023-19/01, ek: 27.09.2024-09/04 ve YÖK
 * G.K. 24.10.2024)
 *
 * Tek puanlama tablosu; koşullar yalnız PROFESÖRLÜKTE temel alana göre
 * ayrılıyor, cetvel bütün alanlarda aynı. Madde kodları tablonun kendi
 * harf düzeni (A.1 → `A1`, J.5 → `J5`).
 *
 * ── %50'LİK SATIRLAR AÇILDI ──
 * A.4 ve F.3 "söz konusu maddelerde belirtilen puanların %50'si" diyor;
 * teknik not, editöre mektup, tartışma, derleme, vaka takdimi ve özet
 * türleri için ayrı satırlara açıldı (`A4-*`, `F3-*`).
 *
 * ── AHCI DERGİLERİ Q4'TEN SAYILIYOR ──
 * A.1 çeyrekliğe göre 140/120/100/90 puan veriyor. Kayıt AHCI için
 * çeyrek taşımadığından §0 uyarınca en düşük çeyreğe (Q4, 90) eklendi.
 *
 * ── AYNI ETİKETE DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   K'da editör yardımcılığı "puanın %25'i"; kayıt editörlükten
 *       ayıramadığı için 'Yayın Kurulu Üyeliği' etiketi F.2 dergi
 *       editörlüğünün dörtte birinden (5) sayılıyor.
 *   L'de A.1 dergisi hakemliği (20) ile A.2 (15) → 15.
 *   P.1/P.2 kongre başkanlığı (50/25) → 25; P.3/P.4 davetli konuşmacılık
 *       (20/10) → 10.
 *   I'de yurt dışı patent (150) ile yurt içi (75) ayrı satırlarda ama
 *       faydalı model ikisinde de aynı puanı aldığı için 'Faydalı Model'
 *       yurt içi satırından (75) sayılıyor.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   D.2 (çeviri kitap editörlüğü, 20) — sözlükte karşılık yok.
 *   K'nın F.2 satırı (diğer ulusal indeksli dergi editörlüğü, 20) —
 *       'Diğer Hakemli Dergi' etiketi A.3 uluslararası dergi
 *       editörlüğüne (30) karşılık geliyor, ulusal karşılığı ayrılamıyor.
 *   Endüstriyel tasarım, yazılım, ıslahçı hakkı ve ticarileştirme —
 *       I bölümü yalnız patent ve faydalı modeli sayıyor.
 *   İdari görevler ve sanatsal etkinlikler — tabloda hiç yok, bu
 *       kayıtlarınız 0 puandır.
 *
 * ── MOTORUN KARŞILAYAMADIĞI SINIRLAR ──
 * "Son iki yılda verilen en fazla 15 ders" (tavan puana çevrildi),
 * "tamamlanmış en fazla 3 tez" (tavan puana çevrildi), "bir kitapta en
 * fazla 2 bölüm çevirisi", "aynı dergide hem editörlük hem hakemlik
 * varsa biri sayılır", "kurum akademik veri yönetim sistemine yüklenmiş
 * ve doğru kurum adı kullanılmış olmak".
 *
 * Yönerge: yonerge/ksbu.php
 */
$KISA = ['derleme', 'kisa_makale', 'vaka_teknik_not'];
$TAM = ['ozgun_makale'];

return [
    'kapsam_notu' => 'Puanlar Kütahya Sağlık Bilimleri Üniversitesi Öğretim Üyeliğine '
        .'Yükseltilme ve Atanma Yönergesinin EK-1 puanlama tablosundan. Yazar çarpanı Tablo 1\'e '
        .'göre hem yazar sayısına hem yazar sırasına bakıyor: ilk sırada iki yazarlıda 0,90; üç '
        .'yazarlıda 0,85; dört ve üzerinde 0,75. İkinci sırada 0,75/0,70/0,60; üçüncü sırada '
        .'0,55/0,50; dördüncü ve sonrasında 0,35. Yazar listesini boş bırakırsanız çarpan hiç '
        .'uygulanmaz ve puanınız olduğundan YÜKSEK görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: AHCI dergileri çeyrek taşımadığı için '
        .'en düşük çeyrekten (Q4, 90 puan) sayılıyor. Dergi editör yardımcılığı ve yayın kurulu '
        .'üyeliği 5 puandan, hakemlikler 15 puandan, kongre başkanlığı 25 puandan, davetli '
        .'konuşmacılık 10 puandan sayılıyor. Çeviri kitap editörlüğü (20 puan), endüstriyel '
        .'tasarım, yazılım ve ticarileştirme kalemleri sözlükte karşılıksız olduğu için '
        .'girilmedi. İdari görevler ve sanatsal etkinlikler EK-1\'de hiç yok; bu kayıtlarınız '
        .'0 puandır. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünebilir: C.1, C.2, D.1, D.2 ve H '
        .'maddeleri kitap ve editörlük puanının YAZAR SAYISINA BÖLÜNMESİNİ istiyor; motorun '
        .'yazar tablosu kategori ayrımı taşımadığı için bütün kitap kalemlerinde Tablo 1 '
        .'katsayıları kullanılıyor. Dört yazarlı bir kitapta bu 0,25 yerine 0,35-0,75 arasında '
        .'bir çarpan demek. Ayrıca "bir kitapta en fazla iki bölüm çevirisi" ve "aynı dergide '
        .'hem editörlük hem hakemlik varsa biri sayılır" sınırları uygulanmıyor.',

    // EK-1 Genel İlke 4 ve Tablo 1: "A-J maddeleri arasındaki yayınların
    // puanı, yayındaki yazar sayısına ve yazarın yayındaki yazar sırasına
    // göre katsayı ile çarpılır." N (ödüller) için de "yazar çarpanı
    // alınacak" deniyor.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'patent', 'proje', 'editorluk', 'tez_danismanligi',
            'egitim_ogretim', 'toplumsal_katki', 'idari_gorev', 'sanatsal_etkinlik', 'diger'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.85], 'sonrasi' => 0.75],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.85], 'sonrasi' => 0.75],
            'yazar_2' => ['kademeler' => [2 => 0.75, 3 => 0.70], 'sonrasi' => 0.60],
            'yazar_3' => ['kademeler' => [3 => 0.55], 'sonrasi' => 0.50],
            'yazar_4' => ['sonrasi' => 0.35],
            'yazar_5' => ['sonrasi' => 0.35],
            'yazar_6' => ['sonrasi' => 0.35],
            'ortak' => ['kademeler' => [1 => 1.00, 2 => 0.75, 3 => 0.55], 'sonrasi' => 0.35],
        ],
    ],

    'maddeler' => [
        // ══ A. ULUSLARARASI MAKALELER ══
        'A1-Q1' => ['baslik' => 'SCI-Expanded, SSCI ya da AHCI tarafından taranan Q1 dergide yayımlanmış tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $TAM, 'puan' => 140],
        'A1-Q2' => ['baslik' => 'SCI-Expanded, SSCI ya da AHCI tarafından taranan Q2 dergide yayımlanmış tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $TAM, 'puan' => 120],
        'A1-Q3' => ['baslik' => 'SCI-Expanded, SSCI ya da AHCI tarafından taranan Q3 dergide yayımlanmış tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $TAM, 'puan' => 100],
        'A1-Q4' => ['baslik' => 'SCI-Expanded, SSCI ya da AHCI tarafından taranan Q4 dergide yayımlanmış tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => $TAM, 'puan' => 90],
        'A2-esci' => ['baslik' => 'ESCI kapsamındaki dergide yayımlanmış tam makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $TAM, 'puan' => 80],
        'A2-diger' => ['baslik' => 'Diğer uluslararası alan indeksleri tarafından taranan dergide yayımlanmış tam makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $TAM, 'puan' => 60],
        'A3' => ['baslik' => 'Diğer uluslararası hakemli dergide yayımlanmış tam makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => 30],
        'A4-Q1' => ['baslik' => 'Q1 dergide yayımlanmış teknik not, editöre mektup, tartışma, derleme, vaka takdimi ya da özet', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $KISA, 'puan' => 70],
        'A4-Q2' => ['baslik' => 'Q2 dergide yayımlanmış teknik not, editöre mektup, tartışma, derleme, vaka takdimi ya da özet', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $KISA, 'puan' => 60],
        'A4-Q3' => ['baslik' => 'Q3 dergide yayımlanmış teknik not, editöre mektup, tartışma, derleme, vaka takdimi ya da özet', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $KISA, 'puan' => 50],
        'A4-Q4' => ['baslik' => 'Q4 dergide yayımlanmış teknik not, editöre mektup, tartışma, derleme, vaka takdimi ya da özet', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => $KISA, 'puan' => 45],
        'A4-esci' => ['baslik' => 'ESCI kapsamındaki dergide yayımlanmış teknik not, editöre mektup, tartışma, derleme, vaka takdimi ya da özet', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $KISA, 'puan' => 40],
        'A4-diger' => ['baslik' => 'Diğer uluslararası alan indeksli dergide yayımlanmış teknik not, editöre mektup, tartışma, derleme, vaka takdimi ya da özet', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 30],
        'A4-a3' => ['baslik' => 'Diğer hakemli dergide yayımlanmış teknik not, editöre mektup, tartışma, derleme, vaka takdimi ya da özet', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 15],

        // ══ B. ULUSLARARASI BİLDİRİLER ══
        'B1' => ['baslik' => 'Uluslararası bilimsel toplantıda sözlü olarak sunulan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 40],
        'B2' => ['baslik' => 'Uluslararası bilimsel toplantıda poster olarak sergilenen bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 20],

        // ══ C. ULUSLARARASI KİTAPLAR ══
        'C1' => ['baslik' => 'Yurt dışında tanınmış yayınevlerince yayımlanan kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 60],
        'C2' => ['baslik' => 'Yurt dışında tanınmış yayınevlerince yayımlanan kitabın editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 30],
        'C3' => ['baslik' => 'Yurt dışında tanınmış yayınevlerince yayımlanan kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 20],

        // ══ D. ÇEVİRİLER ══
        'D1' => ['baslik' => 'Yurt dışında tanınmış yayınevlerince yayımlanmış kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 40],
        'D3' => ['baslik' => 'Yurt dışında tanınmış yayınevlerince yayımlanmış kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 10],

        // ══ E. ATIFLAR ══
        'E1' => ['baslik' => 'SCI-Expanded, SSCI ya da AHCI tarafından taranan dergilerde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 10],
        'E2' => ['baslik' => 'Diğer uluslararası alan indeksli dergiler ile kitap ve kitap bölümlerinde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 5],
        'E3' => ['baslik' => 'Ulusal indekslerde taranan dergilerde ve bildirilerde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 3],

        // ══ F. ULUSAL MAKALELER ══
        'F1' => ['baslik' => 'TR Dizinde indekslenen dergide yayımlanmış tam makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TAM, 'puan' => 30],
        'F3-f1' => ['baslik' => 'TR Dizinde indekslenen dergide yayımlanmış teknik not, editöre mektup, tartışma, derleme, vaka takdimi ya da özet', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $KISA, 'puan' => 15],

        // ══ G. ULUSAL BİLDİRİLER ══
        'G1' => ['baslik' => 'Ulusal bilimsel toplantıda sözlü olarak sunulan ve özet ya da tam metin olarak yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 20],
        'G2' => ['baslik' => 'Ulusal bilimsel toplantıda poster olarak yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 10],

        // ══ H. ULUSAL KİTAPLAR ══
        'H1' => ['baslik' => 'Alanınızda tanınmış yayınevlerince yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı'], 'puan' => 30],
        'H2' => ['baslik' => 'Alanınızda tanınmış yayınevlerince yayımlanmış kitabın editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 15],
        'H3' => ['baslik' => 'Alanınızda tanınmış yayınevlerince yayımlanmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 10],

        // ══ I. PATENT VE FAYDALI MODEL ══
        'I1' => ['baslik' => 'Yurt dışı patent ya da faydalı model almak', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 150],
        'I2' => ['baslik' => 'Yurt içi patent ya da faydalı model almak', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Faydalı Model'], 'puan' => 75],

        // ══ İ. ERASMUS ÖĞRETİM ELEMANI DEĞİŞİMİ ══
        'IE' => ['baslik' => 'Erasmus kapsamında öğretim elemanı değişim aktivitesi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Değişim Programı Dersi', 'Yabancı Dilde Ders'], 'puan' => 10],

        // ══ J. ARAŞTIRMA PROJELERİ ══
        'J1' => ['baslik' => 'Uluslararası kurum ve kuruluşlarca desteklenen projede yürütücü ya da yönetici olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 100],
        'J2' => ['baslik' => 'Uluslararası kurum ve kuruluşlarca desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 50],
        'J3' => ['baslik' => 'TÜBİTAK, TÜSEB, TÜBA ve eşdeğer ulusal kurumlarca desteklenen projede yürütücü ya da yönetici olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 60],
        'J4' => ['baslik' => 'TÜBİTAK, TÜSEB, TÜBA ve eşdeğer ulusal kurumlarca desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 30],
        'J5' => ['baslik' => 'Üniversite bilimsel araştırma projesinde (BAP) yürütücü ya da yönetici olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 30],
        'J6' => ['baslik' => 'Üniversite bilimsel araştırma projesinde (BAP) görev almak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],

        // ══ K. DERGİ EDİTÖRLÜĞÜ ══
        'K-a1' => ['baslik' => 'SCI-Expanded, SSCI ya da AHCI dergisinde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 100],
        'K-a2' => ['baslik' => 'Uluslararası alan indeksli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 80],
        'K-a3' => ['baslik' => 'Diğer uluslararası hakemli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi (Uluslararası)'], 'puan' => 30],
        'K-f1' => ['baslik' => 'TR Dizin dergisinde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 50],
        'K-yrd' => ['baslik' => 'Dergi editör yardımcılığı ya da yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 5],

        // ══ L. DERGİ HAKEMLİĞİ ══
        'L' => ['baslik' => 'Uluslararası indeksli dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 15],

        // ══ M. TEZ YÖNETİMİ ══
        'M1' => ['baslik' => 'Tamamlanmış doktora, tıpta uzmanlık ya da diş hekimliğinde uzmanlık tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 30],
        'M3' => ['baslik' => 'Tamamlanmış doktora, tıpta uzmanlık ya da diş hekimliğinde uzmanlık tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 20],
        'M2' => ['baslik' => 'Tamamlanmış yüksek lisans tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 15],
        'M4' => ['baslik' => 'Tamamlanmış yüksek lisans tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'roller' => ['es_danisman'], 'puan' => 10],

        // ══ N. ÖDÜLLER ══
        'N1' => ['baslik' => 'Alanınızda uluslararası bilimsel nitelikli ödül almak', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 100],
        'N2' => ['baslik' => 'Alanınızda ulusal bilimsel nitelikli ödül almak', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 50],

        // ══ O. ÖĞRETİME KATKI ══
        'O1' => ['baslik' => 'Lisansüstü ya da uzmanlık düzeyinde verilen her bir ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
        'O3' => ['baslik' => 'Lisans ya da ön lisans düzeyinde verilen her bir ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders'], 'puan' => 2],

        // ══ P. DİĞER AKADEMİK VE BİLİMSEL ETKİNLİKLER ══
        'P2' => ['baslik' => 'Sempozyum ve kongrelerde başkanlık yapmak', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 25],
        'P4' => ['baslik' => 'Sempozyum ve kongrelerde davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 10],
        'P5' => ['baslik' => 'Sosyal sorumluluk projeleri kapsamında yapılan çalışma', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın', 'Kamu/STK Danışmanlığı'], 'puan' => 2],
    ],

    'gruplar' => [
        // Koşulların atıf yaptığı kategoriler: "A ve F kategorilerinden".
        'A' => ['A1-Q1', 'A1-Q2', 'A1-Q3', 'A1-Q4', 'A2-esci', 'A2-diger', 'A3',
            'A4-Q1', 'A4-Q2', 'A4-Q3', 'A4-Q4', 'A4-esci', 'A4-diger', 'A4-a3'],
        'F' => ['F1', 'F3-f1'],
        'A-F' => ['A1-Q1', 'A1-Q2', 'A1-Q3', 'A1-Q4', 'A2-esci', 'A2-diger', 'A3',
            'A4-Q1', 'A4-Q2', 'A4-Q3', 'A4-Q4', 'A4-esci', 'A4-diger', 'A4-a3', 'F1', 'F3-f1'],
        // 11.c: "A1 kategorisinde en az bir eserde başlıca yazar olmak".
        'A1' => ['A1-Q1', 'A1-Q2', 'A1-Q3', 'A1-Q4'],
        // 9.e.7 ve 11.f.6: "Q1 veya Q2 kategorisinde yer alan en az 1 makale".
        'A1-Q12' => ['A1-Q1', 'A1-Q2', 'A4-Q1', 'A4-Q2'],

        'TEZ' => ['M1', 'M2', 'M3', 'M4'],
        'TEZ-DOKTORA' => ['M1', 'M3'],
        'TEZ-YL' => ['M2', 'M4'],
        'PATENT' => ['I1', 'I2'],
        // 9.e.4 ve 11.f.4: TÜBİTAK, TÜSEB, AB ya da eşdeğer kurum projeleri.
        'PROJE-DIS-Y' => ['J1', 'J3'],
        'PROJE-DIS-A' => ['J2', 'J4'],
        'PROJE-DIS' => ['J1', 'J2', 'J3', 'J4'],
        // 9.e.5 ve 11.f.5: yükseköğretim kurumlarınca desteklenmiş projeler.
        'PROJE-BAP-Y' => ['J5'],
        'PROJE-BAP' => ['J5', 'J6'],
        'ODUL' => ['N1', 'N2'],
        // 11.f.8: Web of Science ya da Scopus atıfları.
        'ATIF-WOS' => ['E1', 'E2'],

        // Tavan grupları.
        'DERS' => ['O1', 'O3'],
        'SOSYAL' => ['P5'],
    ],

    'grup_tavanlari' => [
        'TEZ' => 90,   // M: "Tamamlanmış en fazla 3 tez için" (3 × 30).
        'DERS' => 45,  // O: "son iki yılda verilen her ders için, en fazla 15 ders" (15 × 3).
        'SOSYAL' => 10, // P.5: "bir atama döneminde en fazla 10 puan".
    ],
];
