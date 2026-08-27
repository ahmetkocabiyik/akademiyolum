<?php

/**
 * AFYONKARAHİSAR SAĞLIK BİLİMLERİ ÜNİVERSİTESİ — EK 1: Yayınların
 * Değerlendirilmesi ve Eğitim-Öğretim, Araştırma Faaliyetleri Puan Cetveli
 * Kaynak: pdf/17536927672.afyonkarahisarsaglikbilimleriuniversitesi.pdf
 * (14 sayfa, Senato 2018/…)
 *
 * FONT KODLAMASI KISMEN BOZUK: yalnızca BAŞLIK/KALIN metinde büyük İ harfi
 * `Ġ` (U+0120), büyük Ş harfi `Ģ` (U+0122) olarak çıkıyor ("AFYONKARAHĠSAR",
 * "BaĢlıca" gibi); gövde metninde İ/Ş doğru çıkıyor (aynı belgede iki farklı
 * font alt kümesi var). Puan tablosu ve rakamlar gövde fontunda, etkilenmedi.
 * Çankaya'daki tam font bozulmasından farklı: burada yalnızca iki harf,
 * yalnızca başlıklarda ve tutarlı bir kaymayla bozuk, madde metinlerini
 * okumaya engel değildi.
 *
 * MADDE KODLARI YÖNERGENİN KENDİSİ: A-L bölüm harfleri + sıra numarası.
 * "İ" harfiyle başlayan bölüm (Sonuçlandırılmış Araştırma Projeleri) İ.1-İ.6
 * olarak yazılmış (yönergenin kendi numaralandırması, İ harfi kasıtlı).
 *
 * ── A.1/A.2 VE F.1/F.2 ÇAKIŞMASI: SCI İLE SCI-EXPANDED AYRI PUANLI ──
 * Yönerge SCI (orijinal) ile SCI-Expanded'i AYRI puanlıyor: A.1 (SCI, SSCI,
 * AHCI) 180 puan, A.2 (yalnızca SCI-Expanded) 150 puan. Kaynak sözlüğünün
 * 'SCIE/SSCI (Qx)' etiketi ikisini ayırmıyor (SCIE zaten SCI-Expanded'i
 * kapsıyor); motor aynı kaynağa düşen maddelerden en yükseğini seçeceği
 * için A.1 ve A.2 TEK maddede, düşük olan puanla (150) birleştirildi. Aynı
 * çakışma F.1 (SCI editörlüğü, 180) ile F.2 (SCI-Expanded dışı uluslararası,
 * 150) arasında da var; aynı gerekçeyle 150 girildi.
 *
 * ── AYNI KAYNAĞA DÜŞEN DİĞER SATIRLARDA DAİMA DÜŞÜĞÜ GİRİLDİ ──
 *   B.1/B.2 bildiri: "b) özet metin" ile "c) kitapçıkta yayımlanmamış poster/
 *       sözlü sunum" aynı 'Uluslararası Özet/Poster' / 'Ulusal Özet/Poster'
 *       etiketine düşüyor (60/30 uluslararası, 40/20 ulusal) → c) değeri
 *       (30, 20) girildi.
 *   C.1 kitap yazarlığı: "b) ulusal/diğer uluslararası" (180) ile "c) ders
 *       kitabı" (b veya a'nın yarısı) aynı 'Uluslararası/Ulusal Kitap'
 *       etiketine düşüyor → ders kitabı değeri (90) girildi; ayrıca ders
 *       kitabı için özel 'Ders / Metot Kitabı' etiketi VARDI, o da aynı 90
 *       puanla ayrıca açıldı (iki kaynak, aynı düşük değer).
 *   C.2 kitap bölümü: "b) ulusal/diğer uluslararası" (90) ile "c) ders
 *       kitabı bölümü" (b'nin yarısı, 45) aynı 'Kitap Bölümü' etiketine
 *       düşüyor → 45 girildi; kitap bölümü için ayrı bir "ders kitabı"
 *       etiketi sözlükte yok.
 *   G.2/G.3 atıf: SCI/SSCI/AHCI atfı (15) ile diğer indeks atfı (9) aynı
 *       'WoS / Scopus' etiketine düşüyor → 9 girildi.
 *   H.1 ders: lisans (4) ile ön lisans (3) aynı 'Lisans/Önlisans Ders'
 *       etiketine düşüyor → 3 girildi.
 *   J.5/J.6 burs: uluslararası (15) ile ulusal (10) aynı 'Burs' etiketine
 *       düşüyor → 10 girildi.
 *   L.2/L.3 idari görev: dekanlık/enstitü müdürlüğü (15) ile yüksekokul
 *       müdürlüğü/başhekimlik (12) aynı 'Dekan / Enstitü-YO Müdürü'
 *       etiketine düşüyor → 12 girildi (1 yıllık taban).
 *
 * ── PATENT TÜRLERİ TEK SATIRDA BİRLEŞTİRİLDİ ──
 * D.1-D.4 aynı patentin dört farklı aşamasını puanlıyor (rüçhanlı incelemeli
 * 300, rüçhansız incelemeli 250, incelemesiz uygulamalı 200, incelemeli
 * uygulamasız 120); kaynak sözlüğü bu aşamaları ayırmıyor, yalnızca
 * uluslararası/ulusal patent ayrımı var. Dördü tek maddede, en düşük değerle
 * (120) birleştirildi.
 *
 * ── TABLO 1: YAZAR SIRASI × YAZAR SAYISI MATRİSİ (11 SIRAYA KADAR) ──
 * Kaynak tablo 11 yazara kadar her sıra için ayrı yüzde veriyor, 11 ve
 * üzerini 11. satırla özdeşleştiriyor. Motorun rol kelime dağarcığı yalnızca
 * 6. sıraya kadar ayrım tanıyor ("6. yazar veya sonrası" tek seçenek); bu
 * roldeki bir faaliyetin GERÇEK sırası (6-11 arası) bilinmediği için her
 * yazar SAYISINDA o sayı için 6+ sıradaki TÜM olası satırların EN DÜŞÜĞÜ
 * kademeye yazıldı (ör. 7 yazarlı bir eserde 6. sıra %30, 7. sıra %25 —
 * `yazar_6` rolü kademesi 7 için %25 aldı, %30 değil). `ortak` (sırası
 * belirtilmeyen) her sayıda TÜM sütunların en düşüğünü alır.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   A.6 (diğer bilimsel/sanatsal dergi ya da görsel/işitsel üretim, 60) —
 *       sözlükte "görsel/işitsel üretim" için makale kategorisinde karşılık
 *       yok.
 *   D bölümünün "Rüçhanlı/rüçhansız/incelemeli/incelemesiz" ayrımı yukarıda
 *       anlatıldığı gibi tek satıra indirgendi; kayıp yok, yalnızca düşük.
 *   G.1 (Web of Science h faktörü × 20) — formül tabanlı puan, motorun
 *       `puan` alanı sabit sayı; girilmedi.
 *   İ.1/İ.2 ile İ.3/İ.4'ün "uluslararası" ve "ulusal" kaynak ayrımı
 *       yapıldı; ayrı bir çakışma yok.
 *   J.1-J.4, J.7/b-c (kongre başkanlığı/görev alma, adayın çalışmaları
 *       hakkında yayın yapılmış olması, bilimsel toplantıya yalnızca
 *       katılmak, hizmet içi eğitime katılmak) — hiçbiri sözlükte karşılık
 *       bulamadı.
 *   L.5/L.6 (Erasmus/Farabi/Mevlana ve eğitim koordinatörlüğü), L.9
 *       (soruşturma/inceleme görevi), L.11-L.14 (uluslararası/ulusal
 *       meslek kuruluşu yönetim kurulu/üyelik) — `idari_gorev`
 *       sözlüğünün üniversite-içi görev odaklı etiketleri bu kalemleri
 *       karşılamıyor.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   H.1 "her yarıyılda en fazla 5 ders" ve F.7 "her yıl en fazla 5 adet
 *       hakemlik" — YIL/DÖNEM BAŞINA adet tavanı; motor yalnızca kariyer
 *       boyunca sabit grup tavanı tanıyor, yıl bazlı olanı uygulayamıyor.
 *       Bu iki kalemde puan YÜKSEK görünebilir.
 *   C.2 "aynı kitapta en çok 2 bölüm değerlendirilir" — eser bazlı tavan,
 *       motorda yok; aynı kitaptan 3+ bölümü olan adayın puanı YÜKSEK
 *       görünebilir.
 *   I.1/d "devam etmekte olan tezlerde puanın %30'u" — devam eden/
 *       tamamlanmış ayrımı faaliyet kaydında yok; yalnızca tamamlanmış tez
 *       danışmanlığı girildi.
 *   L bölümünün TAMAMI "her yıl için" diyor; motorun `puan` alanı sabit,
 *       yalnızca 1 yıllık taban değeri girildi, çok yıllık idari görevlerde
 *       puan DÜŞÜK görünür.
 *
 * Yönerge: yonerge/afyon-saglik.php
 */

return [
    'kapsam_notu' => 'Puanlar Afyonkarahisar Sağlık Bilimleri Üniversitesi EK 1 tablosundan. '
        .'Yazar çarpanı Tablo 1\'deki sıra × yazar-sayısı matrisine göre işliyor (tek yazar tam '
        .'puan; 6. ve sonraki sıradaki yazarlar için gerçek sıranız bilinemediğinden en düşük '
        .'olası pay verildi). Yazar listesini boş bırakırsanız çarpan hiç uygulanmaz ve puanınız '
        .'olduğundan YÜKSEK görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: SCI dergisi ile SCI-Expanded dergisi '
        .'aynı satırdan (düşük olan SCI-Expanded değeriyle) sayılıyor; dört patent aşaması '
        .'(rüçhanlı/rüçhansız, incelemeli/incelemesiz) tek satırda en düşük değerle birleşti; '
        .'h-indeksi puanı (h×20), kongre başkanlığı/görev alma, uluslararası/ulusal meslek '
        .'kuruluşu üyelikleri ve idari görevlerin yıl biriktirmesi hiç uygulanamadı. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünebilir: aynı kitaptan ikiden fazla '
        .'bölümünüz varsa hepsi sayılır; yıl/dönem başına konan ders ve hakemlik tavanları '
        .'(yarıyılda en fazla 5 ders, yılda en fazla 5 hakemlik) uygulanmıyor.',

    // Tablo 1: 1 isimli 100; 2 isimli 100/90; 3 isimli 90/80/70; 4 isimli
    // 85/75/65/55; 5 isimli 80/70/60/50/40; 6 isimli 80/70/60/50/40/30;
    // 7 isimli 80/70/60/50/40/30/25; 8-10 isimli 70/60/50/40/30/25/25/25(/25/25);
    // 11 ve üzeri 60/50/40/30/30/25/25/25/25/25/25 (11. sıradan sonrası hep
    // 11. satırla aynı).
    'yazar_katsayisi' => [
        'haric' => ['proje', 'atif', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev',
            'odul', 'editorluk', 'toplumsal_katki', 'patent'],
        'roller' => (function (): array {
            $ilk = ['kademeler' => [
                1 => 1.00, 2 => 1.00, 3 => 0.90, 4 => 0.85, 5 => 0.80, 6 => 0.80,
                7 => 0.80, 8 => 0.70, 9 => 0.70, 10 => 0.70, 11 => 0.60,
            ], 'sonrasi' => 0.60];
            $yazar2 = ['kademeler' => [
                2 => 0.90, 3 => 0.80, 4 => 0.75, 5 => 0.70, 6 => 0.70,
                7 => 0.70, 8 => 0.60, 9 => 0.60, 10 => 0.60, 11 => 0.50,
            ], 'sonrasi' => 0.50];
            $yazar3 = ['kademeler' => [
                3 => 0.70, 4 => 0.65, 5 => 0.60, 6 => 0.60,
                7 => 0.60, 8 => 0.50, 9 => 0.50, 10 => 0.50, 11 => 0.40,
            ], 'sonrasi' => 0.40];
            $yazar4 = ['kademeler' => [
                4 => 0.55, 5 => 0.50, 6 => 0.50,
                7 => 0.50, 8 => 0.40, 9 => 0.40, 10 => 0.40, 11 => 0.30,
            ], 'sonrasi' => 0.30];
            $yazar5 = ['kademeler' => [
                5 => 0.40, 6 => 0.40,
                7 => 0.40, 8 => 0.30, 9 => 0.30, 10 => 0.30, 11 => 0.30,
            ], 'sonrasi' => 0.30];
            // 6. ve sonraki sıradaki yazarın GERÇEK sırası bilinmiyor; her
            // yazar sayısında 6+ sıradaki en düşük olası değer kullanıldı.
            $yazar6 = ['kademeler' => [
                6 => 0.30, 7 => 0.25, 8 => 0.25, 9 => 0.25, 10 => 0.25, 11 => 0.25,
            ], 'sonrasi' => 0.25];
            $ortak = ['kademeler' => [
                1 => 1.00, 2 => 0.90, 3 => 0.70, 4 => 0.55, 5 => 0.40,
                6 => 0.30, 7 => 0.25, 8 => 0.25, 9 => 0.25, 10 => 0.25, 11 => 0.25,
            ], 'sonrasi' => 0.25];

            return [
                'tek' => ['kademeler' => [1 => 1.0]],
                'ilk' => $ilk,
                'baslica' => $ilk,
                'yazar_2' => $yazar2,
                'yazar_3' => $yazar3,
                'yazar_4' => $yazar4,
                'yazar_5' => $yazar5,
                'yazar_6' => $yazar6,
                'ortak' => $ortak,
            ];
        })(),
    ],

    'maddeler' => [
        // ══ A. MAKALELER (teknik not/editöre mektup/vaka/özet A.7'de yarı puanlı) ══
        'A.1-A.2' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 150],
        'A.1-A.2-YARIM' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergide teknik not, editöre mektup veya benzeri', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 75],
        'A.3' => ['baslik' => 'SCI/SCI-E/SSCI/AHCI dışındaki indeks veya özlerde taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale'], 'puan' => 120],
        'A.3-YARIM' => ['baslik' => 'SCI/SCI-E/SSCI/AHCI dışındaki indeks veya özlerde teknik not, editöre mektup veya benzeri', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 60],
        'A.4' => ['baslik' => 'ULAKBİM tarafından taranan ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 100],
        'A.4-YARIM' => ['baslik' => 'ULAKBİM tarafından taranan ulusal hakemli dergide teknik not, editöre mektup veya benzeri', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 50],
        'A.5' => ['baslik' => 'Diğer ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale'], 'puan' => 80],
        'A.5-YARIM' => ['baslik' => 'Diğer ulusal hakemli dergide teknik not, editöre mektup veya benzeri', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 40],

        // ══ B. BİLDİRİLER ══
        'B.1.a' => ['baslik' => 'Uluslararası bilimsel/sanatsal toplantıda tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 90],
        'B.1.b' => ['baslik' => 'Uluslararası bilimsel/sanatsal toplantıda özet metin veya program dışı poster/sözlü sunum', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 30],
        'B.2.a' => ['baslik' => 'Ulusal bilimsel/sanatsal toplantıda tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 60],
        'B.2.b' => ['baslik' => 'Ulusal bilimsel/sanatsal toplantıda özet metin veya program dışı poster/sözlü sunum', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 20],

        // ══ C. KİTAPLAR ══
        'C.1.a' => ['baslik' => 'Tanınmış uluslararası yayınevince yayımlanan kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 300],
        'C.1.b' => ['baslik' => 'Tanınmış ulusal kurum/yayınevi veya diğer uluslararası yayınevince yayımlanan kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 90],
        'C.1.c' => ['baslik' => 'Ders kitabı yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 90],
        'C.2.a' => ['baslik' => 'Tanınmış uluslararası yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 150],
        'C.2.b' => ['baslik' => 'Tanınmış ulusal kurum/yayınevi veya diğer uluslararası yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 45],

        // ══ D. PATENT / TESCİLLİ BULUŞ / FAYDALI MODEL ══
        'D-PATENT' => ['baslik' => 'Rüçhanlı veya rüçhansız, incelemeli veya incelemesiz patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Uluslararası Patent'], 'puan' => 120],
        'D.5' => ['baslik' => 'Faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 150],
        'D.6' => ['baslik' => 'Endüstriyel tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım'], 'puan' => 100],
        'D.7' => ['baslik' => 'Çeşit veya ırk tescili', 'kategori' => 'patent', 'kaynaklar' => ['Islahçı Hakkı / Çeşit Tescili'], 'puan' => 100],
        'D.8' => ['baslik' => 'Alanında orijinal bilgisayar programı yazarlığı', 'kategori' => 'patent', 'kaynaklar' => ['Yazılım'], 'puan' => 100],

        // ══ E. ÇEVİRİLER ══
        'E.1' => ['baslik' => 'Kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 50],
        'E.2' => ['baslik' => 'Makale, kitap bölümü veya karar tahlili çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 20],

        // ══ F. EDİTÖRLER VE HAKEMLİKLER ══
        'F.1-F.2' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergide editörlük (yıllık)', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 150],
        'F.3' => ['baslik' => 'ULAKBİM tarafından taranan dergide editörlük (yıllık)', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 120],
        'F.4-F.5' => ['baslik' => 'Diğer bilimsel/sanatsal/mesleki dergide editörlük (yıllık)', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 45],
        'F.6' => ['baslik' => 'Yardımcı editörlük veya konuk editörlük (yıllık)', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 22],
        'F.7' => ['baslik' => 'Dergi hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 9],
        'F.8.a' => ['baslik' => 'Uluslararası yayınevince yayımlanan kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 150],
        'F.8.b' => ['baslik' => 'Tanınmış ulusal kurum/yayınevi kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 90],

        // ══ G. ATIFLAR ══
        'G.2-G.3' => ['baslik' => 'Yazar olarak yer almadığınız dergi yayınlarında, adayın atıf yapılan eseri', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 9],
        'G.4' => ['baslik' => 'Hakemli dergi, tez veya bilimsel kitapta, adayın atıf yapılan eseri', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'BKCI Kitap'], 'puan' => 6],
        'G.5' => ['baslik' => 'Diğer yayınlarda, adayın atıf yapılan eseri', 'kategori' => 'atif', 'kaynaklar' => ['Diğer'], 'puan' => 3],

        // ══ H. EĞİTİM-ÖĞRETİM FAALİYETLERİ ══
        'H.1-lisansustu' => ['baslik' => 'Lisansüstü ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 5],
        'H.1-lisans' => ['baslik' => 'Lisans veya ön lisans ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 3],

        // ══ I. TEZ YÖNETİMİ ══
        'I.1.a' => ['baslik' => 'Danışmanlığında tamamlanmış doktora veya uzmanlık tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 100],
        'I.1.a-es' => ['baslik' => 'Doktora veya uzmanlık tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 50],
        'I.1.b' => ['baslik' => 'Danışmanlığında tamamlanmış yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 50],
        'I.1.b-es' => ['baslik' => 'Yüksek lisans tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 25],

        // ══ İ. SONUÇLANDIRILMIŞ ARAŞTIRMA PROJELERİ ══
        'İ.1' => ['baslik' => 'Uluslararası kuruluşça desteklenen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 300],
        'İ.2' => ['baslik' => 'Uluslararası kuruluşça desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman'], 'puan' => 100],
        'İ.3' => ['baslik' => 'Ulusal kuruluşça desteklenen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 120],
        'İ.4' => ['baslik' => 'Ulusal kuruluşça desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman'], 'puan' => 40],
        'İ.5' => ['baslik' => 'BAPK tarafından desteklenen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 60],
        'İ.6' => ['baslik' => 'BAPK tarafından desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['arastirmaci', 'danisman'], 'puan' => 20],

        // ══ J. DİĞER BİLİMSEL VE TASARIMA YÖNELİK ETKİNLİKLER ══
        'J.5-J.6' => ['baslik' => 'Alanınızla ilgili bilimsel/tasarım araştırması için burs almak', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 10],
        'J.7.a' => ['baslik' => 'Bilimsel toplantı veya programda konuşmacı ya da panelist olarak görev almak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 20],

        // ══ K. ÖDÜLLER (yayın teşvikleri hariç) ══
        'K.1' => ['baslik' => 'Alanında uluslararası bilimsel nitelikli ödül', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü'], 'puan' => 150],
        'K.2' => ['baslik' => 'Alanında ulusal bilimsel nitelikli ödül', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 100],

        // ══ L. İDARİ GÖREV VE FAALİYETLER (idari görev toplamda en fazla 100 puan; yalnızca 1 yıllık taban değeri) ══
        'L.1' => ['baslik' => 'Rektörlük/vekâlet veya rektör yardımcılığı yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı'], 'puan' => 20],
        'L.2-L.3' => ['baslik' => 'Dekanlık, enstitü müdürlüğü, yüksekokul müdürlüğü veya başhekimlik yapmak/vekâlet etmek', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü'], 'puan' => 12],
        'L.4' => ['baslik' => 'Dekan/müdür/başhekim yardımcılığı veya bölüm başkanlığı yapmak/vekâlet etmek', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkanı'], 'puan' => 10],
        'L.7' => ['baslik' => 'Rektörlüğe bağlı birim veya araştırma merkezi müdürlüğü yapmak/vekâlet etmek', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 5],
        'L.8' => ['baslik' => 'Üniversite/fakülte yönetim kurulu üyesi veya fakülte kurulu/senato seçilmiş üyesi olmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Senato / Üniversite Yönetim Kurulu Üyesi'], 'puan' => 5],
        'L.10' => ['baslik' => 'Anabilim dalı başkanlığı veya bölüm başkan yardımcılığı yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük', 'Bölüm Başkan Yardımcısı'], 'puan' => 5],
    ],

    'gruplar' => [
        // Madde V/1-d, VI/1-ç: "Ek-1 A-E maddelerinden" — yayın grubu.
        'A-E' => ['A.*', 'B.*', 'C.*', 'D-PATENT', 'D.5', 'D.6', 'D.7', 'D.8', 'E.*'],

        // Madde VII/1-e,f,g,h'nin andığı makale kümeleri.
        'A1-A2' => ['A.1-A.2'],
        'A1-A2-TRDIZIN' => ['A.1-A.2', 'A.4'],
        'A1-A2-A3' => ['A.1-A.2', 'A.3'],

        'IDARI-GOREV' => ['L.*'],
    ],

    // L bölümünün kendi notu: idari görevden toplamda en fazla 100 puan.
    'grup_tavanlari' => [
        'IDARI-GOREV' => 100,
    ],
];
