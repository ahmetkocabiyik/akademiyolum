<?php

/**
 * ANKARA MÜZİK VE GÜZEL SANATLAR ÜNİVERSİTESİ — Bilimsel Yayın, Araştırma ve
 * Etkinlik Puan Tablosu (MADDE 6)
 * Kaynak: pdf/17536929002.ankaramuzikveguzelsanatlaruniversitesi.pdf
 * (26 sayfa, YÖK 03.10.2022/71759 sayılı yazısına dayanılarak hazırlandı,
 * yürürlük 01.01.2026)
 *
 * MADDE KODLARI YÖNERGENİN KENDİSİ: A1.1-A2.5, B1/B2/B3, C, D, E, F, G, H, I,
 * J1-J12, K, L, M, N. Bize ait olan tek şey Q çeyrekliğine ve
 * uluslararası/ulusal ayrımına göre bölünen satırların ekleri
 * (`A1.1-Q1`, `J1.3-uluslararasi`) ile birleştirilen satırların tire ile
 * yazılmış çift kodları (`C.1-C.5`).
 *
 * ── KONSERVATUVAR CETVELİ: SÖZLÜK BURADA DARALIYOR ──
 * Bu, korpustaki en ince ayrımlı sanat tablosu: J bölümü tek başına 60'tan
 * fazla satır taşıyor (icra, eğiticilik, etkinlik düzenleme, jüri, bestecilik,
 * şeflik, müzik teknolojisi, çalgı teknolojisi, sergi, radyo-TV-sinema, sahne
 * sanatları, tasarım). `Kategori` sözlüğü Mersin konservatuvar tablosu için
 * kurulduğundan çoğunu karşılıyor, ama bazı satır çiftleri TEK etikete
 * düşüyor. Bu durumların hepsinde DÜŞÜK puanlı satır girildi (bkz. aşağıdaki
 * liste); puan bu kalemlerde olduğundan DÜŞÜK görünür.
 *
 * ── AYNI KAYNAĞA DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   F.1/F.3 patent (bireysel 200-100 / grup 150-75): 'Uluslararası Patent' ve
 *       'Ulusal Patent' etiketleri bireysel-grup ayrımı taşımıyor → 150 / 75.
 *   F.2/F.4 faydalı model (bireysel 150-75 / grup 100-50): tek 'Faydalı Model'
 *       etiketi, uluslararası-ulusal ayrımı da yok → 50.
 *   C.1/C.5 (WoS dergi editörlüğü 50 / yardımcı editörlük 25) → 25.
 *   C.2/C.6 (ESCI-Scopus-TR Dizin editörlük 30 / yardımcı editörlük 15) → 15.
 *   C.3/C.8 (BKCI kitap editörlük 50 / yardımcı editörlük 25) → 25.
 *   C.4/C.7 (diğer yayınevi kitap editörlük 20 / yardımcı editörlük 10) → 10.
 *   C.9/C.10 (yayın kurulu üyeliği 10 / 5): tek 'Yayın Kurulu Üyeliği' → 5.
 *   Tüm L bölümü (hakemlik ve proje değerlendiriciliği, 20 ile 10 arası): tek
 *       'Hakemlik' etiketi → 10.
 *   K.4/K.6 atıf (WoS makalede 30 / ESCI-Scopus makalede 20-10): 'WoS /
 *       Scopus' etiketi ikisini birden kapsıyor → 10.
 *   H.3/H.4 (dekanlık 40 / enstitü-YO müdürlüğü 30): tek 'Dekan / Enstitü-YO
 *       Müdürü' etiketi → 30.
 *   I.2/I.3 (akredite programda öğretim 20 / YÖKAK kurulunda görev 100×yıl):
 *       tek 'Akreditasyon Faaliyeti' etiketi → 20.
 *   J1.9 grup şefi: satır metni "Ulusal: 10" derken puan sütunu "20-15"
 *       yazıyor (kaynak tutarsızlığı) → ulusal satır 10 alındı.
 *   J1.10 orkestra/koro üyeliği (10-5): tek etiket → 5.
 *   J3.1/J3.2 etkinlik düzenleme (başkanlık 90-45 / yardımcılık 60-30): tek
 *       'Sempozyum/Çalıştay/Bienal' çifti → 60 / 30.
 *   J6.2/J6.3 şeflik (senfoni 100-50 / oda orkestrası 60-30): tek 'Orkestra
 *       Şefliği' çifti → 60 / 30.
 *   J10.1/J10.5 yönetmenlik (sinema filmi 150-75 / reklam filmi 60-30): tek
 *       'Yönetmenlik (Sahne/Ekran)' etiketi, uluslararası-ulusal ayrımı da yok
 *       → 30.
 *   J10.3/J10.4 belgesel-kısa film (yönetmenlik 80-40 / diğer görevler 70-35):
 *       tek 'Belgesel/Kısa Film' çifti → 70 / 35.
 *   J11.1/J11.2 sahne oyunu özgün eser (tam 100 / kısa 50) → 50. Bu satır
 *       ayrıca sözlüğün GENEL 'Özgün Eser / Beste / Tasarım' etiketini taşıyor;
 *       bestesini bu genel seçenekle kaydeden aday J5'in kendi satırından değil
 *       buradan (50) sayılır — kapsam notu bunu söylüyor.
 *   J11.4/J11.5 tiyatro rolü (tam oyun 50-25 / kısa eser 30-15) → 30 / 15.
 *   J11.6/J11.8 rejisörlük (60-30 / kısa oyunda 30-15) → 30 / 15.
 *   J11.7/J11.9 rejisör yardımcılığı (50-25 / kısa oyunda 20-10) → 20 / 10.
 *   J11.10/J11.11 sahne-hareket tasarımı (20-10 / eğitim kurumunda 10-5): tek
 *       'Sahne Tasarımı' etiketi → 5.
 *   M.2/M.3 sosyal sorumluluk (yürütücülük 20 / görev alma 10): tek 'Topluma
 *       Hizmet Projesi' etiketi → 10.
 *   N.1/N.3/N.4/N.5/N.6/N.9 (40-20 ile 10-5 arası): `Diger` kategorisinin tek
 *       'Diğer' etiketi → 5.
 *
 * ── MGÜ'NÜN KENDİ YAYINLARI GİRİLEMEDİ ──
 * A1.5, A2.5(MGÜ), B1.4, B1.6, B2.3, B2.5, B3.3, B3.5, J10.11, J10.12, M.1 —
 * hepsi "MGÜ tarafından yayımlanan / MGÜ stüdyolarında / MGÜ SEM bünyesinde"
 * niteliğine bağlı. Bir yayının hangi kurum tarafından çıkarıldığı faaliyet
 * kaydında yok; kurum yayınlarını ayıramadığımız için bu satırlar hiç
 * girilmedi. Puan bu kalemlerde olduğundan DÜŞÜK görünür.
 *
 * ── DERS KİTABI BÖLÜMÜ GİRİLEMEDİ ──
 * Sözlükte 'Ders / Metot Kitabı' tek etiket; ders kitabı ile ders kitabı
 * BÖLÜMÜ ayrılamıyor. B2.1/B2.4 (ders kitabı, 180 ve 45) tek satırda düşük
 * değerle (45) girildi; B2.2/B2.6 (ders kitabı bölümü, 90 ve 20) hiç
 * girilmedi — 'Kitap Bölümü' etiketine koymak B1.5'i (25) 90'a çıkarır ve
 * fazla sayım doğururdu.
 *
 * ── GİRİLMEYEN DİĞER KALEMLER (sözlükte karşılıksız) ──
 *   D.10, F.7, F.9 — proje/tasarım/patent BAŞVURUSU. Tescilliyle aynı kaynağa
 *       düşer, motor en yükseği seçeceği için başvuru sahibi tescilli gibi
 *       sayılırdı.
 *   E.7 (bilimsel toplantıda sözlü sunum) — 'Davetli Konuşmacı' etiketi N.2'de
 *       kullanıldı; sözlü sunum davetli konuşmacılık değil.
 *   F.8 (yurtdışında gözlem ve araştırma faaliyeti).
 *   I.4, I.5 (eğitici eğitimi ve alan eğitimi belgesine sahip olma) — belge
 *       sahipliği bir profil özelliği, faaliyet kaydı değil.
 *   J1.7 (eşlikçilik), J2.2 (yetiştirilen öğrencinin ödül alması), J3.3
 *       (öğrenci çalışmalarında danışmanlık), J7.1-J7.4 ve J7.6-J7.8 (müzik
 *       teknolojisi: kayıt/mix/mastering, MIDI, akustik yalıtım, gürültü
 *       ölçümü, ses tasarımı, tonmaysterlik), J8.1 (çalgı teknolojisi),
 *       J10.6-J10.10 (gazete yönetmenliği, TV/radyo program görevleri),
 *       J12.5/J12.6 (logo, afiş-poster-kapak tasarımı).
 *   K.7 (H-indeksi × 40) — h-indeksi bir PROFİL özelliği; motor puanı yalnızca
 *       faaliyetlerden topluyor.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   B bölümü dipnotu "aynı kitapta en fazla iki bölüm", K.1/K.2 dipnotu "aynı
 *       kitapta en fazla bir bölüm", J1 dipnotu "içerikleri aynı olan sanatsal
 *       faaliyetler yalnızca iki defa", J9 dipnotu "her esere sadece bir kez
 *       sergileme puanı" — hepsi ESER BAZLI tavan; motorda yok, puan bu
 *       durumlarda YÜKSEK görünebilir.
 *   H dipnotu "her yıl için bir görev, en fazla 5 yıl" ve G dipnotu "her dönem,
 *       verilen ders başına" — yıl/dönem biriktirmesi motorda yok. İdari görev
 *       ve derslerde yalnızca tek görev/tek ders değeri girildi, puan DÜŞÜK
 *       görünür.
 *   I.3 "100 × yıl" — aynı sebeple tek yıl değerine indi (üstelik I.2 ile
 *       birleştiği için 20'ye).
 *   K.1/K.2 dipnotu "puan yazar sayısına EŞİT olarak bölünür" — cetvel başına
 *       tek yazar matrisi tanımlanabiliyor ve genel formül birinci yazara pay
 *       üstü ilave veriyor. Çeviri satırlarında puan YÜKSEK görünebilir.
 *   J5.5/J5.6 süre eşiği: yönerge 5 dakikada, sözlük 15 dakikada ayırıyor.
 *       Etiketler sıralamayı koruyor (uzun eser 50, kısa eser 30) ama süre
 *       sınırı birebir aynı değil.
 *
 * ── UYGULANAN TAVANLAR ──
 * E (bilimsel toplantı) 20, K atıfları 100, M (toplumsal destek) 20 kendi
 * dipnotlarından; J1-EŞLİK-ÜYELİK (eşlikçi, başkemancı, grup şefi,
 * orkestra/koro üyeliği) 20 J1'in ikinci dipnotundan; K-ÇEVİRİ 300, "en çok
 * 3 adet çeviri" adet tavanının puana çevrilmiş hâli (3 × 100).
 *
 * Yönerge: yonerge/ankara-mgu.php
 */

return [
    'kapsam_notu' => 'Puanlar Ankara Müzik ve Güzel Sanatlar Üniversitesi MADDE 6 puan '
        .'tablosundan. Yazar çarpanı yönergenin formülüne göre işliyor (sorumlu yazar 1. isim '
        .'sayılır; 1. isim 1,4/n + %20, 2. isim 1,4/n + %10, 3. isim 1,4/n + %5, 4. isim ve '
        .'sonrası 1,4/n) ve atıf, tez danışmanlığı, ders, idari görev, ödül, editörlük ile '
        .'toplumsal katkı dışındaki her kaleme uygulanıyor. Yazar listesini boş bırakırsanız '
        .'çarpan hiç uygulanmaz ve puanınız olduğundan YÜKSEK görünür. '
        .'BESTE, SAHNE ESERİ VE TASARIMLARINIZI TÜRÜNE UYGUN SEÇENEKLE KAYDEDİN: genel '
        .'"Özgün Eser / Beste / Tasarım" seçeneği sahne oyunu satırından (50 puan) sayılır, '
        .'bestecilik satırlarından değil. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: editörlük ile yardımcı editörlük, '
        .'bireysel ile grup patent, dekanlık ile müdürlük, sinema ile reklam filmi '
        .'yönetmenliği gibi satır çiftleri tek kayıt türüne düştüğü için düşük olan değerle '
        .'sayılıyor; bütün hakemlik kalemleri tek satırda (10 puan) toplandı; SCI atıfları da '
        .'diğer atıflarla aynı satıra (10 puan) düştü; üniversitenin kendi yayınevi ve '
        .'dergileri, ders kitabı bölümleri, müzik ve çalgı teknolojisi kalemleri, eşlikçilik, '
        .'TV/radyo program görevleri, logo-afiş tasarımı ve h-indeksi puanı hiç girilemedi; '
        .'idari görevlerin ve derslerin yıl/dönem biriktirmesi uygulanmıyor. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünebilir: aynı kitaptan ikiden fazla '
        .'bölümünüz, aynı içerikli ikiden fazla sanatsal faaliyetiniz ya da aynı eserin '
        .'birden fazla sergilemesi varsa hepsi sayılır; çeviri puanı yönergenin eşit bölme '
        .'kuralı yerine genel yazar formülüyle hesaplanıyor.'
        .' KİTAPTA İNDEKS KOŞULU DENETLENMİYOR: uluslararası yayınevi kitabınız yönergenin BKCI/Scopus taranan kitap satırından sayılıyor. Kitabınız bu kapsamda değilse puanınız olduğundan YÜKSEK görünür; yönerge o kitabı daha düşük bir satırda sayıyor olabilir.',

    // MADDE 6 PUANLAMA b bendi: 1. isim / sorumlu yazar (1,4×P / n) + 0,20×P;
    // 2. isim + 0,10×P; 3. isim + 0,05×P; 4. isim ve sonrası yalnızca 1,4×P/n.
    // Motor çarpanı 1.0'da kestiği için tek yazarlı eser tam puan alır.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev',
            'odul', 'editorluk', 'toplumsal_katki'],
        'roller' => (function (): array {
            $ilk = ['bol' => ['pay' => 1.4, 'ek' => 0.20]];
            $dorduncuVeSonrasi = ['bol' => ['pay' => 1.4]];

            return [
                'tek' => ['kademeler' => [1 => 1.0]],
                'ilk' => $ilk,
                // "Sorumlu yazarın ismi birinci isim olarak alınır" (b bendi).
                'baslica' => $ilk,
                'yazar_2' => ['bol' => ['pay' => 1.4, 'ek' => 0.10]],
                'yazar_3' => ['bol' => ['pay' => 1.4, 'ek' => 0.05]],
                'yazar_4' => $dorduncuVeSonrasi,
                'yazar_5' => $dorduncuVeSonrasi,
                'yazar_6' => $dorduncuVeSonrasi,
                // Sırasını belirtmeyen aday en düşük satırı alır.
                'ortak' => $dorduncuVeSonrasi,
            ];
        })(),
    ],

    'maddeler' => [
        // ══ A.1 ARAŞTIRMA MAKALESİ ══
        'A1.1-Q1' => ['baslik' => 'SCI, SCIE veya SSCI kapsamındaki Q1 dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale'], 'puan' => 300],
        'A1.1-Q2' => ['baslik' => 'SCI, SCIE veya SSCI kapsamındaki Q2 dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale'], 'puan' => 200],
        'A1.1-Q3' => ['baslik' => 'SCI, SCIE veya SSCI kapsamındaki Q3 dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale'], 'puan' => 150],
        'A1.1-Q4' => ['baslik' => 'SCI, SCIE veya SSCI kapsamındaki Q4 dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => ['ozgun_makale'], 'puan' => 100],
        'A1.2' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI kapsamındaki Q faktörü bulunmayan dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 200],
        'A1.3' => ['baslik' => 'ESCI, Scopus veya TR Dizin kapsamındaki dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 100],
        'A1.4' => ['baslik' => 'Uluslararası diğer indeksler kapsamındaki dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale'], 'puan' => 50],
        'A1.6' => ['baslik' => 'Ulusal diğer indeksler kapsamındaki hakemli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale'], 'puan' => 40],
        'A1.7' => ['baslik' => 'SCI, SCIE, SSCI, AHCI, ESCI, Scopus, TR Dizin veya uluslararası diğer indeksli dergide editöre mektup, araştırma notu, olgu sunumu, kitap eleştirisi veya özet', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI', 'ESCI / Scopus', 'TR Dizin', 'Diğer Uluslararası İndeks'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 30],
        'A1.8' => ['baslik' => 'Ulusal diğer indeksler kapsamındaki hakemli dergide editöre mektup, araştırma notu, olgu sunumu, kitap eleştirisi veya özet', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 20],

        // ══ A.2 DERLEME MAKALE ══
        'A2.1-Q1' => ['baslik' => 'SCI, SCIE veya SSCI kapsamındaki Q1 dergide derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['derleme'], 'puan' => 280],
        'A2.1-Q2' => ['baslik' => 'SCI, SCIE veya SSCI kapsamındaki Q2 dergide derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['derleme'], 'puan' => 180],
        'A2.1-Q3' => ['baslik' => 'SCI, SCIE veya SSCI kapsamındaki Q3 dergide derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['derleme'], 'puan' => 140],
        'A2.1-Q4' => ['baslik' => 'SCI, SCIE veya SSCI kapsamındaki Q4 dergide derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => ['derleme'], 'puan' => 90],
        'A2.2' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI kapsamındaki Q faktörü bulunmayan dergide derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => ['derleme'], 'puan' => 180],
        'A2.3' => ['baslik' => 'ESCI, Scopus veya TR Dizin kapsamındaki dergide derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'TR Dizin'], 'turler' => ['derleme'], 'puan' => 90],
        'A2.4' => ['baslik' => 'Uluslararası diğer indeksler kapsamındaki dergide derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['derleme'], 'puan' => 45],
        // Kaynakta iki satır birden "A2.5" kodlu; MGÜ dergisi satırı
        // girilemediği için kod çakışması doğmadı.
        'A2.5' => ['baslik' => 'Ulusal diğer indeksler kapsamındaki dergide derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['derleme'], 'puan' => 35],

        // ══ B.1 KİTAP ══
        'B1.1' => ['baslik' => 'BKCI kapsamındaki kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası Kitap'], 'puan' => 200],
        'B1.2' => ['baslik' => 'BKCI kapsamındaki kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Uluslararası Kitap Bölümü'], 'puan' => 100],
        'B1.3' => ['baslik' => 'Diğer uluslararası veya ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 50],
        'B1.5' => ['baslik' => 'Diğer uluslararası veya ulusal yayınevi tarafından yayımlanan kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 25],

        // ══ B.2 DERS KİTABI (bölüm satırları girilemedi) ══
        'B2.1-B2.4' => ['baslik' => 'Uluslararası veya ulusal yayınevi tarafından yayımlanmış ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 45],

        // ══ B.3 LİSANSÜSTÜ TEZLERDEN ÜRETİLMİŞ KİTAP ══
        'B3.1' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, BKCI kapsamındaki kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 100],
        'B3.2' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, BKCI kapsamındaki kitapta bölüm', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 50],
        'B3.4' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, diğer uluslararası veya ulusal yayınevi kitabı', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 25],
        'B3.6' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, diğer uluslararası veya ulusal yayınevi kitabında bölüm', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 15],

        // ══ C. EDİTÖRLÜK, YARDIMCI EDİTÖRLÜK, YAYIN KURULU ÜYELİĞİ ══
        'C.1-C.5' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI kapsamındaki dergide editörlük ya da yardımcı editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 25],
        'C.2-C.6' => ['baslik' => 'ESCI, Scopus veya TR Dizin kapsamındaki dergide editörlük ya da yardımcı editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi', 'TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 15],
        'C.3-C.8' => ['baslik' => 'BKCI kapsamındaki kitapta editörlük ya da yardımcı editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Uluslararası Kitap Editörlüğü'], 'puan' => 25],
        'C.4-C.7' => ['baslik' => 'Diğer uluslararası veya ulusal yayınevi kitabında editörlük ya da yardımcı editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 10],
        'C.9-C.10' => ['baslik' => 'Dergi yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 5],

        // ══ D. PROJE ══
        'D.1' => ['baslik' => 'Uluslararası kuruluşça desteklenen ve başarıyla tamamlanan projede yürütücülük veya koordinatörlük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 150],
        'D.2' => ['baslik' => 'Uluslararası kuruluşça desteklenen ve başarıyla tamamlanan projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 100],
        'D.3' => ['baslik' => 'Uluslararası kuruluşça desteklenen ve başarıyla tamamlanan projede danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['danisman'], 'puan' => 50],
        'D.4' => ['baslik' => 'Ulusal kuruluşça (TÜBİTAK, bakanlık vb.) desteklenen ve başarıyla tamamlanan projede yürütücülük veya koordinatörlük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 120],
        'D.5' => ['baslik' => 'Ulusal kuruluşça desteklenen ve başarıyla tamamlanan projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 80],
        'D.6' => ['baslik' => 'Ulusal kuruluşça desteklenen ve başarıyla tamamlanan projede danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['danisman'], 'puan' => 40],
        'D.7' => ['baslik' => 'Üniversite BAP birimince desteklenen ve başarıyla tamamlanan projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 60],
        'D.8' => ['baslik' => 'Üniversite BAP birimince desteklenen ve başarıyla tamamlanan projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 40],
        'D.9' => ['baslik' => 'Üniversite BAP birimince desteklenen ve başarıyla tamamlanan projede danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['danisman'], 'puan' => 20],

        // ══ E. BİLİMSEL TOPLANTI (grup tavanı 20) ══
        'E.1' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan ve bildiri kitabında yayımlanmış tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 50],
        'E.2' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan ve bildiri kitapçığında yayımlanmış özet bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 25],
        'E.3' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan ve bildiri kitabında yayımlanmış tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 30],
        'E.4' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan ve bildiri kitapçığında yayımlanmış özet bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 15],

        // ══ F. PATENT, FAYDALI MODEL, ÖDÜL, TASARIM ══
        'F.1-F.3-uluslararasi' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 150],
        'F.1-F.3-ulusal' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 75],
        'F.2-F.4' => ['baslik' => 'Tescil edilmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 50],
        'F.5-uluslararasi' => ['baslik' => 'Uluslararası bilim veya sanat kurumundan alınan ödül', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 300],
        'F.5-ulusal' => ['baslik' => 'Ulusal bilim veya sanat kurumundan alınan ödül', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü', 'Yarışma Derecesi / Mansiyon'], 'puan' => 250],
        'F.6' => ['baslik' => 'Endüstriyel, çevresel veya grafiksel tasarım; sahne, moda ya da çalgı tasarımı', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım', 'Yazılım', 'Ticarileştirme'], 'puan' => 100],

        // ══ G. TEZ DANIŞMANLIĞI VE DERSLER ══
        'G.1' => ['baslik' => 'Tamamlanmış doktora veya sanatta yeterlik tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman', 'es_danisman'], 'puan' => 20],
        'G.2' => ['baslik' => 'Tamamlanmış yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'roller' => ['danisman', 'es_danisman'], 'puan' => 10],
        'G.3' => ['baslik' => 'Lisansüstü dersi vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Değişim Programı Dersi'], 'puan' => 4],
        'G.4-G.5' => ['baslik' => 'Lisans veya ön lisans dersi vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders'], 'puan' => 2],

        // ══ H. İDARİ GÖREVLER (yalnızca tek görev / tek yıl değeri) ══
        'H.1' => ['baslik' => 'Rektörlük', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör'], 'puan' => 100],
        'H.2' => ['baslik' => 'Rektör yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör Yardımcısı'], 'puan' => 60],
        'H.3-H.4' => ['baslik' => 'Dekanlık, enstitü, yüksekokul veya meslek yüksekokulu müdürlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü'], 'puan' => 30],
        'H.5' => ['baslik' => 'Dekan yardımcılığı, müdür yardımcılığı, bölüm veya anabilim dalı başkanlığı, komisyon başkanlığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkanı', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 10],
        'H.6' => ['baslik' => 'Uygulama ve araştırma merkezi müdürlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 20],
        'H.7' => ['baslik' => 'Bölüm başkan yardımcılığı veya komisyon üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı', 'Kurul / Komisyon Üyeliği'], 'puan' => 10],

        // ══ I. AKREDİTASYON VE EĞİTİM-ÖĞRETİM ══
        'I.1' => ['baslik' => 'Yabancı dilde ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Yabancı Dilde Ders'], 'puan' => 20],
        'I.2-I.3' => ['baslik' => 'Akredite programda eğitim-öğretim faaliyetinde bulunmak veya akreditasyon kurul ve komisyonlarında görev almak', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Akreditasyon Faaliyeti'], 'puan' => 20],

        // ══ J.1 İCRA ══
        'J1.1' => ['baslik' => 'Bandrollü veya dijital yayımlanmış solo albüm', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)'], 'puan' => 200],
        'J1.2' => ['baslik' => 'Bandrollü veya dijital yayımlanmış albümde yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Albüm / CD-DVD Katkısı'], 'puan' => 120],
        'J1.3-uluslararasi' => ['baslik' => 'Uluslararası solo sahne performansı (resital, dinleti)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Uluslararası)', 'Şan Resitali (Uluslararası)'], 'puan' => 100],
        'J1.3-ulusal' => ['baslik' => 'Ulusal solo sahne performansı (resital, dinleti)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Ulusal)', 'Şan Resitali (Ulusal)'], 'puan' => 50],
        'J1.4-uluslararasi' => ['baslik' => 'Uluslararası orkestra eşlikli solo konser', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Solistlik (Uluslararası)', 'Oratoryo/Kantat Solistliği (Uluslararası)'], 'puan' => 80],
        'J1.4-ulusal' => ['baslik' => 'Ulusal orkestra eşlikli solo konser', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Solistlik (Ulusal)', 'Oratoryo/Kantat Solistliği (Ulusal)'], 'puan' => 40],
        'J1.5-uluslararasi' => ['baslik' => 'Uluslararası oda müziği veya topluluk konseri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Uluslararası)'], 'puan' => 70],
        'J1.5-ulusal' => ['baslik' => 'Ulusal oda müziği veya topluluk konseri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Ulusal)'], 'puan' => 35],
        'J1.8-uluslararasi' => ['baslik' => 'Uluslararası etkinlikte başkemancı veya başsazende olarak yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Başkemancılık (Uluslararası)'], 'puan' => 30],
        'J1.8-ulusal' => ['baslik' => 'Ulusal etkinlikte başkemancı veya başsazende olarak yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Başkemancılık (Ulusal)'], 'puan' => 15],
        'J1.9-uluslararasi' => ['baslik' => 'Uluslararası etkinlikte grup şefliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Grup Şefliği (Uluslararası)'], 'puan' => 20],
        'J1.9-ulusal' => ['baslik' => 'Ulusal etkinlikte grup şefliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Grup Şefliği (Ulusal)'], 'puan' => 10],
        'J1.10' => ['baslik' => 'Orkestra veya koro üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra / Koro Üyeliği'], 'puan' => 5],

        // ══ J.2 EĞİTİCİLİK ══
        'J2.1-uluslararasi' => ['baslik' => 'Uluslararası platformda ustalık sınıfı veya atölye çalışması eğiticiliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Masterclass (Uluslararası)'], 'puan' => 120],
        'J2.1-ulusal' => ['baslik' => 'Ulusal platformda ustalık sınıfı veya atölye çalışması eğiticiliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Masterclass (Ulusal)', 'Müzikoloji Atölyesi'], 'puan' => 60],

        // ══ J.3 SANATSAL-BİLİMSEL ETKİNLİK DÜZENLEME ══
        'J3.1-J3.2-uluslararasi' => ['baslik' => 'Uluslararası festival, yarışma, çalıştay, bienal, sempozyum veya kongre düzenlemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 60],
        'J3.1-J3.2-ulusal' => ['baslik' => 'Ulusal festival, yarışma, çalıştay, bienal, sempozyum veya kongre düzenlemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 30],

        // ══ J.4 JÜRİ ÜYELİĞİ ══
        'J4.1-uluslararasi' => ['baslik' => 'Uluslararası etkinlikte jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], 'puan' => 30],
        'J4.1-ulusal' => ['baslik' => 'Ulusal etkinlikte jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 15],

        // ══ J.5 BESTECİLİK ══
        'J5.1' => ['baslik' => 'Opera kompozisyonu', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera/Bale Kompozisyonu'], 'puan' => 150],
        'J5.2' => ['baslik' => 'Oratoryo, bale veya benzeri sahne eseri kompozisyonu', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestralı Sahne Eseri'], 'puan' => 100],
        'J5.3' => ['baslik' => 'Orkestra için senfonik eser kompozisyonu', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir'], 'puan' => 100],
        'J5.4' => ['baslik' => 'Film, dizi veya tiyatro müziği kompozisyonu', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne/Ekran Müziği'], 'puan' => 50],
        'J5.5' => ['baslik' => 'Solo çalgı, ses, koro, oda müziği veya elektronik müzik kompozisyonu (uzun)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda/Koro Müziği Eseri (≥15 dk)', 'Elektronik Müzik Eseri (≥15 dk)', 'Küçük Ölçekli Orkestra Eseri'], 'puan' => 50],
        'J5.6' => ['baslik' => 'Solo çalgı, ses, koro, oda müziği veya elektronik müzik kompozisyonu (kısa)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (<15 dk)'], 'puan' => 30],
        'J5.7' => ['baslik' => 'Eğitim müziği kompozisyonu (albüm, kitap, CD)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eğitim Müziği Albümü'], 'puan' => 20],
        'J5.8' => ['baslik' => 'Orkestrasyon veya transkripsiyon', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestrasyon/Transkripsiyon'], 'puan' => 10],
        'J5.9' => ['baslik' => 'Eğitim müziği eserlerinde düzenleme', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eğitim Müziği Düzenlemesi'], 'puan' => 5],

        // ══ J.6 ŞEFLİK ══
        'J6.1-uluslararasi' => ['baslik' => 'Uluslararası opera, opera repertuvarı veya bale temsilinde orkestra şefliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Uluslararası)'], 'puan' => 150],
        'J6.1-ulusal' => ['baslik' => 'Ulusal opera, opera repertuvarı veya bale temsilinde orkestra şefliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Ulusal)'], 'puan' => 75],
        'J6.2-J6.3-uluslararasi' => ['baslik' => 'Uluslararası senfoni veya oda orkestrası şefliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra Şefliği (Uluslararası)'], 'puan' => 60],
        'J6.2-J6.3-ulusal' => ['baslik' => 'Ulusal senfoni veya oda orkestrası şefliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra Şefliği (Ulusal)'], 'puan' => 30],
        'J6.4-uluslararasi' => ['baslik' => 'Uluslararası koro şefliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koro Şefliği (Uluslararası)'], 'puan' => 50],
        'J6.4-ulusal' => ['baslik' => 'Ulusal koro şefliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koro Şefliği (Ulusal)'], 'puan' => 25],

        // ══ J.7 MÜZİK TEKNOLOJİSİ (yalnızca patentli yazılım girilebildi) ══
        // J7.5 F.6 ile aynı 'Yazılım' etiketine düşüyor ve ikisi de 100 puan;
        // ayrı satır açmaya gerek kalmadı, bkz. F.6.

        // ══ J.9 SERGİ, BİENAL, PERFORMANS ══
        'J9.1-uluslararasi' => ['baslik' => 'Uluslararası bireysel etkinlik (bienal, çalıştay, festival, koleksiyon, sergi, performans, enstalasyon)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Eserin Müzeye Kabulü (Yurt Dışı)'], 'puan' => 100],
        'J9.1-ulusal' => ['baslik' => 'Ulusal bireysel etkinlik (bienal, çalıştay, festival, koleksiyon, sergi, performans, enstalasyon)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)', 'Eserin Müzeye Kabulü (Yurt İçi)'], 'puan' => 50],
        'J9.2-uluslararasi' => ['baslik' => 'Uluslararası karma etkinlik (bienal, çalıştay, festival, gösterim, koleksiyon, sergi, performans, enstalasyon)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Karma Sergi (Uluslararası)'], 'puan' => 50],
        'J9.2-ulusal' => ['baslik' => 'Ulusal karma etkinlik (bienal, çalıştay, festival, gösterim, koleksiyon, sergi, performans, enstalasyon)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 25],

        // ══ J.10 RADYO, TV VE SİNEMA ══
        'J10.1-J10.5' => ['baslik' => 'Gösterime girmiş sinema veya reklam filminde yönetmenlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Yönetmenlik (Sahne/Ekran)'], 'puan' => 30],
        'J10.2-uluslararasi' => ['baslik' => 'Uluslararası gösterime girmiş sinema filminde yapımcılık, yönetmen yardımcılığı, görsel yönetmenlik, kurgu veya senaristlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)'], 'puan' => 100],
        'J10.2-ulusal' => ['baslik' => 'Ulusal gösterime girmiş sinema filminde yapımcılık, yönetmen yardımcılığı, görsel yönetmenlik, kurgu veya senaristlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'], 'puan' => 50],
        'J10.3-J10.4-uluslararasi' => ['baslik' => 'Uluslararası gösterime girmiş belgesel veya kısa metrajlı filmde görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Uluslararası)'], 'puan' => 70],
        'J10.3-J10.4-ulusal' => ['baslik' => 'Ulusal gösterime girmiş belgesel veya kısa metrajlı filmde görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Ulusal)'], 'puan' => 35],

        // ══ J.11 SAHNE SANATLARI ══
        'J11.1-J11.2' => ['baslik' => 'Sahne oyunu türünde yazılmış özgün eser', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım'], 'puan' => 50],
        'J11.3' => ['baslik' => 'Koreografi alanında özgün eser', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koreografi', 'Tüm Perde Koreograflığı (Uluslararası)', 'Tüm Perde Koreograflığı (Ulusal)', 'Bölüm Koreograflığı (Uluslararası)', 'Bölüm Koreograflığı (Ulusal)', 'Bale/Dans Koreograflığı (Uluslararası)', 'Bale/Dans Koreograflığı (Ulusal)'], 'puan' => 100],
        'J11.4-J11.5-uluslararasi' => ['baslik' => 'Uluslararası tiyatro oyununda rol almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Dansçı / Performans İcracısı (Uluslararası)', 'Opera Birinci Rol (Uluslararası)', 'Opera İkinci Rol (Uluslararası)', 'Bale Başrol (Uluslararası)', 'Bale Solist Rol (Uluslararası)', 'Corps de Ballet (Uluslararası)'], 'puan' => 30],
        'J11.4-J11.5-ulusal' => ['baslik' => 'Ulusal tiyatro oyununda rol almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Dansçı / Performans İcracısı (Ulusal)', 'Opera Birinci Rol (Ulusal)', 'Opera İkinci Rol (Ulusal)', 'Bale Başrol (Ulusal)', 'Bale Solist Rol (Ulusal)', 'Corps de Ballet (Ulusal)'], 'puan' => 15],
        'J11.6-J11.8-uluslararasi' => ['baslik' => 'Uluslararası oyunda rejisörlük', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisörlük (Uluslararası)', 'Sahneleme/Repetitörlük — Tüm Perde (Uluslararası)', 'Sahneleme/Repetitörlük — Bölüm (Uluslararası)'], 'puan' => 30],
        'J11.6-J11.8-ulusal' => ['baslik' => 'Ulusal oyunda rejisörlük', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Sahneleme/Repetitörlük — Tüm Perde (Ulusal)', 'Sahneleme/Repetitörlük — Bölüm (Ulusal)'], 'puan' => 15],
        'J11.7-J11.9-uluslararasi' => ['baslik' => 'Uluslararası oyunda rejisör yardımcılığı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisör Yardımcılığı (Uluslararası)'], 'puan' => 20],
        'J11.7-J11.9-ulusal' => ['baslik' => 'Ulusal oyunda rejisör yardımcılığı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisör Yardımcılığı (Ulusal)', 'Rejisör Yardımcılığı (Konservatuvar)'], 'puan' => 10],
        'J11.10-J11.11' => ['baslik' => 'Sahnelenmiş oyunda sahne tasarımı, hareket tasarımı veya dramaturgi uygulaması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne Tasarımı (Dekor, Kostüm, Işık)'], 'puan' => 5],

        // ══ J.12 TASARIM ══
        'J12.1' => ['baslik' => 'Rölöve, restitüsyon veya restorasyon projesinde ekip üyeliği ya da danışmanlık', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)'], 'puan' => 100],
        'J12.2' => ['baslik' => 'Kamu kurumu veya özel hukuk tüzel kişisi bünyesinde uygulamaya konmuş sanatsal tasarım', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif'], 'puan' => 100],
        'J12.3' => ['baslik' => 'Bilimsel yayınla tescillenmiş sanatsal tasarım', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Haber Olması (Uluslararası)', 'Eserin Haber Olması (Ulusal)'], 'puan' => 100],
        'J12.4' => ['baslik' => 'Diğer sanatsal tasarım', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman', 'Eğitim Amaçlı Sanat Etkinliği', 'Eğitici Konser Programı (Uluslararası)', 'Eğitici Konser Programı (Ulusal)'], 'puan' => 90],

        // ══ K. ÇEVİRİ VE ATIFLAR ══
        'K.1' => ['baslik' => 'Kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 100],
        'K.2' => ['baslik' => 'Makale veya kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 50],
        'K.3' => ['baslik' => 'Uluslararası veya ulusal yayınevince yayımlanmış bilimsel kitapta atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 10],
        // Sözlük 16.09.2026'da atıfta ESCI'yi çekirdek indeksten ayırdı; üç
        // satır da kendi değerinde. K.6 kapsamına göre ikiye bölünüyor
        // (kaynak: "Uluslararası: 20, Ulusal: 10"), TR Dizin ulusal kademede.
        'K.4' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI kapsamındaki dergilerde yayımlanmış makalelerde atıf', 'kategori' => 'atif', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 30],
        'K.6-u' => ['baslik' => 'ESCI ya da Scopus kapsamındaki makalelerde atıf', 'kategori' => 'atif', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 20],
        'K.6-n' => ['baslik' => 'TR Dizin kapsamındaki makalelerde atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 10],
        'K.5' => ['baslik' => 'Diğer indeksler kapsamındaki dergide atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 10],

        // ══ L. HAKEMLİK (bütün satırlar tek kayıt türüne düşüyor) ══
        'L' => ['baslik' => 'Dergi, kitap veya proje hakemliği ya da değerlendiriciliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 10],

        // ══ M. TOPLUMSAL DESTEK FAALİYETLERİ (grup tavanı 20) ══
        'M.2-M.3' => ['baslik' => 'Sosyal sorumluluk çalışması veya projesinde yürütücülük ya da görev almak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi'], 'puan' => 10],

        // ══ N. DİĞER ══
        'N.2' => ['baslik' => 'Bilimsel veya sanatsal toplantıda davetli konuşmacılık', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 10],
        'N.7' => ['baslik' => 'Kurumsal danışmanlık', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı'], 'puan' => 20],
        'N.8' => ['baslik' => 'Alanıyla ilgili seminer veya hizmet içi eğitim vermek', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Bilim İletişimi / Popüler Yayın'], 'puan' => 15],
        'N.1-N.3-N.4-N.5-N.6-N.9' => ['baslik' => 'Bilimsel veya sanatsal toplantıda düzenleme, bilim kurulu, oturum başkanlığı ya da sekreterlik görevi; bilirkişilik; yayımlanmış ders notu', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 5],
        'N.1-u' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 40],
        'N.1-n' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Ulusal)'], 'puan' => 20],
        'N.3-u' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 10],
        'N.3-n' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 5],
        'N.4-u' => ['baslik' => 'Bilimsel toplantıda oturum başkanlığı (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Uluslararası)'], 'puan' => 10],
        'N.4-n' => ['baslik' => 'Bilimsel toplantıda oturum başkanlığı (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Ulusal)'], 'puan' => 5],
    ],

    // Koşulların andığı kümeler. NOKTA ZORUNLU: 'J1.*' deseni J10/J11/J12'yi
    // yakalamasın diye her grup nokta ile yazıldı, J bütünü ise alt bölümleri
    // tek tek sayarak kuruldu.
    'gruplar' => [
        'A1' => ['A1.*'],
        'A2' => ['A2.*'],
        'A1-A2' => ['A1.*', 'A2.*'],
        // Makale ADEDİ koşullarının saydığı kümeler ("SCI/SCIE/SSCI/AHCI
        // kapsamındaki dergilerde en az N özgün makale" vb.). Yalnızca A1
        // satırları: yönerge "özgün makale" diyor, derleme A2'de.
        'A1.1-A1.2' => ['A1.1-Q1', 'A1.1-Q2', 'A1.1-Q3', 'A1.1-Q4', 'A1.2'],
        'A1.3-A1.4' => ['A1.3', 'A1.4'],
        'B' => ['B1.*', 'B2.*', 'B3.*'],
        'B1' => ['B1.*'],
        'B2' => ['B2.*'],
        'B1-B2' => ['B1.*', 'B2.*'],
        'C' => ['C.*'],
        'D' => ['D.*'],
        'E' => ['E.*'],
        'F' => ['F.*'],
        'G' => ['G.*'],
        'H' => ['H.*'],
        'I' => ['I.*'],
        'J' => ['J1.*', 'J2.*', 'J3.*', 'J4.*', 'J5.*', 'J6.*', 'J9.*', 'J10.*', 'J11.*', 'J12.*'],
        'J1' => ['J1.*'],
        'J1.3' => ['J1.3-uluslararasi', 'J1.3-ulusal'],
        'J1.5' => ['J1.5-uluslararasi', 'J1.5-ulusal'],
        'J1.3-J1.5' => ['J1.3-uluslararasi', 'J1.3-ulusal', 'J1.5-uluslararasi', 'J1.5-ulusal'],
        // J1'in ikinci dipnotu: eşlikçi, başkemancı/başsazende, grup şefliği ve
        // orkestra/koro üyeliğinden en çok 20 puan.
        'J1-EŞLİK-ÜYELİK' => ['J1.8-uluslararasi', 'J1.8-ulusal', 'J1.9-uluslararasi', 'J1.9-ulusal', 'J1.10'],
        'J5' => ['J5.*'],
        'J6' => ['J6.*'],
        'J11.4-J11.5' => ['J11.4-J11.5-uluslararasi', 'J11.4-J11.5-ulusal'],
        'J12' => ['J12.*'],
        'K' => ['K.*'],
        'K-ÇEVİRİ' => ['K.1', 'K.2'],
        'K-ATIF' => ['K.3', 'K.4', 'K.6-u', 'K.6-n', 'K.5'],
        'K3-K6' => ['K.3', 'K.4', 'K.6-u', 'K.6-n', 'K.5'],
        'L' => ['L'],
        'M' => ['M.*'],
        'N' => ['N.*'],
    ],

    // Dipnotlardan gelen sabit tavanlar. K-ÇEVİRİ, "en çok 3 adet çeviri"
    // adet tavanının puana çevrilmiş hâli (3 × 100).
    'grup_tavanlari' => [
        'E' => 20,
        'J1-EŞLİK-ÜYELİK' => 20,
        'K-ATIF' => 100,
        'K-ÇEVİRİ' => 300,
        'M' => 20,
    ],
];
