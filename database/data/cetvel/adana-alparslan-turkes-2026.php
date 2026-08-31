<?php

/**
 * ADANA ALPARSLAN TÜRKEŞ BİLİM VE TEKNOLOJİ ÜNİVERSİTESİ — EK-II: Öğretim
 * Üyeliği Kadrolarına Yükseltilme ve Atanmada Esas Alınacak Puanlama ve
 * Değerlendirme Tablosu
 * Kaynak: pdf/1785505475250.Adana Alparslan Türkeş Bilim ve Teknoloji
 * Üniversitesi Kriter Değişikliği.pdf (15 sayfa, Senato 15/05/2026, 2026/13-3)
 *
 * DOSYA ADI "Kriter Değişikliği" DESE DE TAM YÖNERGE: 14 madde, EK-I (yazar
 * formülü) ve EK-II (bu cetvel) eksiksiz. Madde 13/1 yürürlüğü ikiye
 * bölüyor: Madde 10 (profesörlük) YÖK Genel Kurul onayından sonra, diğer her
 * şey 01.01.2027'de yürürlüğe giriyor — dosya adı muhtemelen üniversitenin
 * kendi arşivleme kuralından geliyor.
 *
 * MADDE KODLARI YÖNERGENİN KENDİSİ: A-P bölüm harfleri + sıra numarası
 * (A1-A6, B1-B2, C1-C2, D1-D7, E1-E3, F1-F16, G1-G15, H1-H2, I1-I3, J1-J8,
 * K1-K5, L1-L5, M1-M3, N1-N8, O1, P1-P11). Kod aynen korundu.
 *
 * ── ÇEYREKLİK VE TÜR ALT KODLARI (a-f) BİZE AİT ──
 * A1 tablo satırı çeyrekliğe göre dört değer veriyor (Q1 120, Q2 100, Q3 80,
 * Q4 60); kaynak sözlüğü çeyrekliği ayrı etiket olarak tuttuğu için dört alt
 * kod açıldı (A1-Q1 … A1-Q4). A1-A5 satırlarının hepsi ayrıca A6'nın
 * "teknik not, editöre mektup, tartışma, vaka takdimi, özet, derleme ve
 * kitap kritiği türünden yayınlarda YARISI" kuralına tabi; her satırın yarı
 * puanlı bir eşleniği `turler` alanıyla açıldı (…-YARIM, turler:
 * derleme/kisa_makale/vaka_teknik_not; ana satırlar turler: ozgun_makale).
 *
 * ── YAZAR FORMÜLÜ (EK-I): SIRA × SAYI MATRİSİ ──
 * 1 yazar 100, 2 yazar (1. 90 / 2. 80), 3 yazar (1. 80 / 2. 70 / 3. 60),
 * 4 yazar (1. 70 / 2. 60 / 3. 50 / 4. 40); 5 ve üzeri yazarlıda sıraya
 * bakılmaksızın herkes %30. Motorun `kademeler` + `sonrasi` ikilisi bunu
 * birebir karşılıyor: her rolün kendi sıra sütunu `kademeler`e yazıldı,
 * `sonrasi` hepsinde 0,30 (5. ve sonrası kişi sayısında sıra ne olursa
 * olsun aynı sabit). `ortak` (sırası belirtilmeyen) her sayıda o sütunun EN
 * DÜŞÜK (son) satırını alır — 2 kişide 0,80, 3 kişide 0,60, 4 kişide 0,40.
 * "Başlıca yazar ilk isimle aynı puanı alır" hükmü gereği `baslica` ile
 * `ilk` birebir aynı tabloyu paylaşıyor.
 *
 * ── GİRİLMEYEN YAZAR BONUSLARI ──
 * EK-I'nin uluslararası/ulusal iş birliği dipnotları: ATÜ araştırmacısının
 * yurt dışı üniversiteyle ortak yazdığı makalede 1. yazarın 1,5 katı puan
 * alması, yurt içi başka üniversiteyle ortak yazdığında ilk yazarla eşit
 * puan alması — ortak yazarın kurumu faaliyet kaydında yok, girilmedi
 * (puan DÜŞÜK görünür). Son dipnot: çeyrekliği olmayan dergide başvuru
 * yılındaki çeyrekliğin
 * esas alınması — form her faaliyete tek bir kaynak etiketi verdiği için bu
 * zaten örtük olarak adayın kendi seçimine kalıyor, ayrıca kural yazılmadı.
 *
 * ── AYNI KAYNAĞA DÜŞEN SATIRLARDA DAİMA DÜŞÜĞÜ GİRİLDİ (motor aynı kaynağa
 * düşen maddelerden en yükseğini seçtiği için tek satır kalmalıydı) ──
 *   D5/D6 ansiklopedi madde yazarlığı (uluslararası 20 / ulusal 10):
 *       `Kitap` sözlüğünün tek 'Ansiklopedi Maddesi' etiketi ayıramıyor → 10.
 *   G1-G3 (A1'de baş editör 150 / yardımcı editör 50 / yayın kurulu 20):
 *       çeyrekliğe göre gruplanan tek `WoS Dergi (Qx)` etiketi editörlük
 *       rolünü ayıramıyor → yalnızca G3 (20) girildi, G1/G2 hiç girilmedi.
 *   G4-G6 (A1 dışı+TR Dizin baş editör 50 / yardımcı 20 / yayın kurulu 10):
 *       aynı sebep → yalnızca G6 (10) girildi.
 *   G10/G11 (A1'de hakemlik 10 / diğer hakemli dergide hakemlik 5): tek
 *       'Hakemlik' etiketi → 5.
 *   J3 (yarışma derecesi 100 / mansiyon 50): tek 'Yarışma Derecesi /
 *       Mansiyon' etiketi → 50 (mansiyon değeri).
 *   J6/J7 (yurt dışı burs 30 / yurt içi burs 20): tek 'Burs' etiketi → 20.
 *   K1/K2'nin WoS/Scopus kısmı (A1-A2 atfı 4 / A3 atfı 2): tek 'WoS /
 *       Scopus' etiketi → 2. K2'nin TR Dizin kısmı (A4 atfı) ayrı kaldı
 *       çünkü 'TR Dizin' bağımsız bir etiket.
 *   K4/K5 (uluslararası kitap atfı 4 / ulusal kitap atfı 2): tek 'BKCI
 *       Kitap' etiketi → 2.
 *   M1/M3 (bölüm dışı lisans dersi 15 / bölüm içi lisans dersi 10): tek
 *       'Lisans/Önlisans Ders' etiketi → 10.
 *   P7/P8 (Enstitü ABD Başkanlığı 10×yıl / ABD Başkanlığı 3×yıl): tek
 *       'Anabilim Dalı Başkanı / Koordinatörlük' etiketi → 3 (1 yıllık).
 *
 * ── PROJE ROLLERİ: "ARAŞTIRMACI YARISINI, DANIŞMAN ÇEYREĞİNİ ALIR (N6
 * HARİÇ)" ──
 * N4/N5/N8'in yürütücü/araştırmacı/danışman satırları bu orana göre ayrı
 * madde koduyla açıldı (roller birbirinden bağımsız satırlar olduğu için
 * çakışma yok — motorun "aynı kaynağa en yüksek puanı ver" davranışı yalnızca
 * AYNI rol+kaynak+kategori üçlüsünde devreye giriyor, roller farklıysa
 * `roller` filtresi zaten ayırıyor). N6 istisnası: yürütücü ve danışman AYNI
 * puanı (30) alıyor, iki satır aynı değerle açıldı. N1 (koordinatör/baş
 * araştırmacı, yalnızca yürütücü) ve N2 (ortak araştırmacı, yalnızca
 * araştırmacı) zaten kendi başlarına tam satır; oran kuralı bunlara
 * uygulanmadı çünkü tablo onları zaten ayrı satır olarak tanımlamış.
 * "N4, N5, N6, N7, N8'den puan alınabilmesi için TAMAMLANMIŞ olması şartı" —
 * tamamlanma durumu faaliyet kaydında yok, uygulanamadı (puan YÜKSEK
 * görünebilir).
 *
 * ── GİRİLMEYEN KALEMLER (sözlükte karşılıksız) ──
 *   A6'nın kısaltılmış türleri zaten yukarıda (…-YARIM alt kodlarıyla)
 *       girildi; E3 (hakemli dergide çeviri makale, 10 puan) — `Makale`
 *       kategorisinin `turler` seçenekleri arasında "çeviri" yok, girilmedi.
 *   D7 (D1-D3 eserlerin genişletilmiş ek baskısı, 20 puan) — "ek baskı"
 *       niteliği faaliyet kaydında yok.
 *   F16 (etkinlik düzenleme/yürütücülük, en fazla 30 puan toplamda) ve
 *       G12 (sanat/sergi katalog yazarlığı, 20 puan) — sözlükte karşılıksız.
 *   H1/H2 (basılmış bilimsel/sanatsal rapor, 50/30 puan) — `Kategori`
 *       enumunda "rapor" diye bir tür yok, hiç girilmedi.
 *   J8 (kongrede ilk üçe giren sunum, 20 puan) — J3'ün kullandığı 'Yarışma
 *       Derecesi / Mansiyon' etiketiyle çakışacağı için (J3=50 zaten en
 *       düşük) ayrı girilmedi.
 *   L4/L5 (üniversite-sanayi protokollü tez danışmanlığı, 35/20 puan) —
 *       normal tez danışmanlığıyla (L1/L2) aynı kaynağa düşüyor ve daha
 *       yüksek puanlı; protokol bilgisi faaliyet kaydında yok, girilirse
 *       her tez danışmanlığı yüksek satırdan sayılırdı (fazla sayma riski),
 *       o yüzden hiç girilmedi.
 *   O1 (yurt dışı en az 3 ay araştırma, 30 puan) — bu bir SÜRE ölçütü,
 *       `Profil::yurtdisiAy` alanı var ama motorda metrik koşulu PUANA
 *       çevrilemiyor (yalnızca kendi başına eşik koşulu olabiliyor);
 *       cetvele puan olarak girilemedi.
 *   P10/P11 (yarışma/TÜBİTAK öğrenci proje danışmanlığı/jüri üyeliği, 3
 *       puan) — `Kategori` enumunda bu tür danışmanlık/jüri için karşılık
 *       yok, girilmedi.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   P bölümünün TAMAMI "yıl ile çarpılır" (P1-P9, son 5 yıl geçerli).
 *       Motorun `puan` alanı sabit; yalnızca 1 yıllık taban değeri girildi,
 *       birden çok yıl görev yapanların puanı DÜŞÜK görünür. "Yardımcılar
 *       yarısını alır", "6 aydan az görev yapanlar yarısını alır", "kalite
 *       komisyonunda 3 katı alır" alt kuralları da aynı sebeple uygulanamadı.
 *   D2/E2 "bir eserde en fazla 2 bölüm puanlanabilir" — motor eser bazlı
 *       tavan tanımıyor (yalnızca kategori/grup bazlı toplam tavanı var);
 *       aynı kitaptan 3+ bölümü olan bir adayın puanı YÜKSEK görünebilir.
 *   B/C (bildiri) grup tavanı Mimarlık'ta kadroya göre değişiyor (doçentlik
 *       150, profesörlük 250) ama İİSBF'de sabit (100); motorun
 *       `grup_tavanlari` tek cetvelde tek değer tutuyor, kadro bazlı
 *       varyant üretmek yerine EN DÜŞÜK ortak değer (100) evrensel
 *       uygulandı — Mimarlık adayının B/C katkısı TOPLAM'a olduğundan az
 *       yansır, "eksik say" yönünde güvenli bir sapma.
 *
 * Yönerge: yonerge/adana-alparslan-turkes.php
 */

return [
    'kapsam_notu' => 'Puanlar Adana Alparslan Türkeş Bilim ve Teknoloji Üniversitesi EK-II '
        .'Puanlama ve Değerlendirme Tablosundan. Yazar çarpanı sıra × yazar sayısı matrisine '
        .'göre işliyor (1 yazar tam puan; 5 ve üzeri yazarlıda sıraya bakılmaksızın herkes '
        .'%30); yazar listesini boş bırakırsanız çarpan hiç uygulanmaz ve puanınız olduğundan '
        .'YÜKSEK görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: dergi editörlüğünün üst kademeleri '
        .'(baş editör, yardımcı editör), uluslararası ortaklı/yurt içi ortaklı yayın bonusları, '
        .'üniversite-sanayi protokollü tez danışmanlığı, yurt dışı araştırma tecrübesi (30 '
        .'puan) hiç girilemedi; kurumsal katkı (idari görev) kalemlerinde yalnızca ilk yıl '
        .'değeri sayılıyor, sonraki yıllar için yıl çarpanı uygulanmıyor; Mimarlık ve Tasarım '
        .'Fakültesi\'nde bildiri (B/C) kategorisinin tavanı diğer birimlerle aynı (100) '
        .'sayıldı, oysa kaynakta doçentlikte 150 ulusal, profesörlükte 250. '
        .'Puanınız şu kalemde OLDUĞUNDAN YÜKSEK görünebilir: aynı kitaptan/dergiden alınan '
        .'ikiden fazla bölüm/atıf, kaynağın "bir eserde en fazla 2" sınırına rağmen hepsi '
        .'sayılır; tamamlanmamış (devam eden) bazı proje türleri de tamamlanmış gibi sayılır.',

    // EK-I: 1 yazar 100; 2 yazarlı 1. 90 / 2. 80; 3 yazarlı 1. 80 / 2. 70 /
    // 3. 60; 4 yazarlı 1. 70 / 2. 60 / 3. 50 / 4. 40; 5+ yazarlıda sıraya
    // bakılmaksızın herkes %30. "Başlıca yazar ilk isimle aynı puanı alır."
    'yazar_katsayisi' => [
        'haric' => ['atif', 'editorluk', 'odul', 'egitim_ogretim', 'idari_gorev',
            'toplumsal_katki', 'patent', 'sanatsal_etkinlik'],
        'roller' => (function (): array {
            $ilk = ['kademeler' => [1 => 1.0, 2 => 0.90, 3 => 0.80, 4 => 0.70], 'sonrasi' => 0.30];
            $yazar2 = ['kademeler' => [2 => 0.80, 3 => 0.70, 4 => 0.60], 'sonrasi' => 0.30];
            $yazar3 = ['kademeler' => [3 => 0.60, 4 => 0.50], 'sonrasi' => 0.30];
            $yazar4 = ['kademeler' => [4 => 0.40], 'sonrasi' => 0.30];
            $ortak = ['kademeler' => [1 => 1.0, 2 => 0.80, 3 => 0.60, 4 => 0.40], 'sonrasi' => 0.30];

            return [
                'tek' => ['kademeler' => [1 => 1.0]],
                'ilk' => $ilk,
                'baslica' => $ilk,
                'yazar_2' => $yazar2,
                'yazar_3' => $yazar3,
                'yazar_4' => $yazar4,
                'yazar_5' => ['sonrasi' => 0.30],
                'yazar_6' => ['sonrasi' => 0.30],
                'ortak' => $ortak,
            ];
        })(),
    ],

    'maddeler' => [
        // ══ A. MAKALELER ══
        'A1-Q1' => ['baslik' => "SCI-E veya SSCI'de taranan Q1 dergide makale", 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale'], 'puan' => 120],
        'A1-Q1-YARIM' => ['baslik' => "SCI-E veya SSCI'de taranan Q1 dergide teknik not, editöre mektup, derleme veya benzeri", 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 60],
        'A1-Q2' => ['baslik' => "SCI-E veya SSCI'de taranan Q2 dergide makale", 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale'], 'puan' => 100],
        'A1-Q2-YARIM' => ['baslik' => "SCI-E veya SSCI'de taranan Q2 dergide teknik not, editöre mektup, derleme veya benzeri", 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 50],
        'A1-Q3' => ['baslik' => "SCI-E veya SSCI'de taranan Q3 dergide makale", 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale'], 'puan' => 80],
        'A1-Q3-YARIM' => ['baslik' => "SCI-E veya SSCI'de taranan Q3 dergide teknik not, editöre mektup, derleme veya benzeri", 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 40],
        'A1-Q4' => ['baslik' => "SCI-E veya SSCI'de taranan Q4 dergide makale", 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => ['ozgun_makale'], 'puan' => 60],
        'A1-Q4-YARIM' => ['baslik' => "SCI-E veya SSCI'de taranan Q4 dergide teknik not, editöre mektup, derleme veya benzeri", 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 30],
        'A2' => ['baslik' => "AHCI'de taranan dergide makale", 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 120],
        'A2-YARIM' => ['baslik' => "AHCI'de taranan dergide teknik not, editöre mektup, derleme veya benzeri", 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 60],
        'A3' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale'], 'puan' => 60],
        'A3-YARIM' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide teknik not, editöre mektup, derleme veya benzeri', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 30],
        'A4' => ['baslik' => "ULAKBİM TR Dizin'de taranan dergide makale", 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 40],
        'A4-YARIM' => ['baslik' => "ULAKBİM TR Dizin'de taranan dergide teknik not, editöre mektup, derleme veya benzeri", 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 20],
        'A5' => ['baslik' => 'A1-A4 dışındaki ulusal veya uluslararası hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale'], 'puan' => 20],
        'A5-YARIM' => ['baslik' => 'A1-A4 dışındaki dergide teknik not, editöre mektup, derleme veya benzeri', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 10],

        // ══ B. ULUSLARARASI BİLDİRİLER ══
        'B1' => ['baslik' => 'Uluslararası sempozyum/kongre/konferansta sunulan sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 30],
        'B2' => ['baslik' => 'Uluslararası sempozyum/kongre/konferansta sunulan poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 20],

        // ══ C. ULUSAL BİLDİRİLER ══
        'C1' => ['baslik' => 'Ulusal sempozyum/kongre/konferansta sunulan sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 20],
        'C2' => ['baslik' => 'Ulusal sempozyum/kongre/konferansta sunulan poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 10],

        // ══ D. KİTAPLAR ══
        'D1' => ['baslik' => 'BKCI kapsamındaki kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 100],
        'D2' => ['baslik' => 'BKCI kapsamındaki kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 50],
        'D3' => ['baslik' => 'Diğer uluslararası veya ulusal kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 50],
        'D4' => ['baslik' => 'Diğer uluslararası veya ulusal kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 25],
        'D5' => ['baslik' => 'Ansiklopedide madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 10],

        // ══ E. ÇEVİRİLER ══
        'E1' => ['baslik' => 'Kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 50],
        'E2' => ['baslik' => 'Kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 10],

        // ══ F. SANAT VE TASARIM ETKİNLİKLERİ ══
        'F1' => ['baslik' => 'Özgün eserin yurt dışında satın alınması, yayın organında yer alması veya gösterime girmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)'], 'puan' => 100],
        'F2' => ['baslik' => 'Özgün eserin yurt içinde satın alınması, yayın organında yer alması veya gösterime girmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)'], 'puan' => 80],
        'F3' => ['baslik' => 'Uluslararası jürili karma sanat ve tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)'], 'puan' => 70],
        'F4' => ['baslik' => 'Ulusal jürili yurt dışı karma sanat ve tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Ulusal Jürili)'], 'puan' => 50],
        'F5' => ['baslik' => 'Yurt içinde jürili karma sanat ve tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)'], 'puan' => 35],
        'F6' => ['baslik' => 'Yurt dışında kişisel sanat/tasarım etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)'], 'puan' => 100],
        'F7' => ['baslik' => 'Yurt içinde kişisel sanat/tasarım etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)'], 'puan' => 65],
        'F8' => ['baslik' => 'Yurt dışında karma veya grup sanat/tasarım etkinliğine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Jürisiz)'], 'puan' => 35],
        'F9' => ['baslik' => 'Yurt içinde karma veya grup sanat/tasarım etkinliğine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Jürisiz, Ulusal)'], 'puan' => 25],
        'F10' => ['baslik' => 'Uluslararası sempozyum, festival, çalıştay, bienal veya trienale eserle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 40],
        'F11' => ['baslik' => 'Ulusal sempozyum, festival, çalıştay, bienal veya trienale eserle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 30],
        'F12' => ['baslik' => 'Sahne sanatlarında yönetmen, sanat yönetmeni, koreograf veya performans sanatçısı olarak yurt dışı sunum', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Yönetmenlik (Sahne/Ekran)'], 'puan' => 65],
        'F14' => ['baslik' => 'Bireysel ses/görüntü yayımı (kaset, CD, albüm)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Albüm / Konser Kaydı'], 'puan' => 65],
        'F15' => ['baslik' => 'Karma ses/görüntü yayımı (kaset, CD, albüm)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Albüm / CD-DVD Katkısı'], 'puan' => 35],

        // ══ G. EDİTÖR VE HAKEMLİKLER ══
        'G3' => ['baslik' => 'A1 kategorisindeki dergide yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 20],
        'G6' => ['baslik' => 'A1 dışındaki uluslararası endeksli veya ULAKBİM taranan ulusal dergide yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi', 'TR Dizin Dergi'], 'puan' => 10],
        'G7' => ['baslik' => 'Endekse girmeyen ulusal veya uluslararası hakemli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 15],
        'G8' => ['baslik' => 'Uluslararası yayınevince yabancı dilde basılan kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 75],
        'G9' => ['baslik' => 'Ulusal yayınevince basılan bilimsel veya mesleki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 50],
        'G11' => ['baslik' => 'Ulusal veya uluslararası hakemli dergide hakemlik yapmak', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 5],
        'G13' => ['baslik' => 'Uluslararası sanat etkinliklerinde jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], 'puan' => 20],
        'G14' => ['baslik' => 'Ulusal sanat etkinliklerinde jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 10],
        'G15' => ['baslik' => 'Doktora veya yüksek lisans tezlerinde jüri üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 5],

        // ══ I. PATENTLER ══
        'I1' => ['baslik' => 'TPE, EPO veya USPTO tarafından incelemeli kabul edilen patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 250],
        'I2' => ['baslik' => 'TPE tarafından kabul edilen faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 100],
        'I3' => ['baslik' => 'TPE tarafından kabul edilen endüstriyel tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım'], 'puan' => 80],

        // ══ J. ÖDÜLLER ══
        'J1' => ['baslik' => 'TÜBİTAK / TÜBA bilim ödülü veya YÖK Ödülleri', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'YÖK Ödülü'], 'puan' => 300],
        'J2' => ['baslik' => 'TÜBİTAK / TÜBA teşvik ödülü (yayın teşvik ödülleri hariç)', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 150],
        'J3' => ['baslik' => 'Planlama, mimarlık, kentsel/peyzaj/iç mimari tasarım veya endüstri ürünleri tasarımı yarışmasında mansiyon', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 50],
        'J4' => ['baslik' => 'Uluslararası bilim, sanat veya tasarım ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü'], 'puan' => 100],
        'J5' => ['baslik' => 'Ulusal bilim, sanat veya tasarım ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 50],
        'J7' => ['baslik' => 'Bilimsel/sanatsal araştırma için 3 aydan uzun süreli burs (yurt içi veya yurt dışı)', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 20],

        // ══ K. ATIFLAR ══
        'K2' => ['baslik' => 'A1-A3 kapsamındaki dergilerde veya A1-A3 yayınlarında yazar olmadığınız bir esere yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 2],
        'K3' => ['baslik' => 'K1/K2 dışındaki diğer bilimsel/sanatsal hakemli dergide yazar olmadığınız bir esere yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer'], 'puan' => 1],
        'K4' => ['baslik' => 'Yazar olmadığınız uluslararası veya ulusal yayınevi kitabında adayın atıf yapılan eseri', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
        'A4-ATIF' => ['baslik' => "ULAKBİM TR Dizin'de taranan dergide yazar olmadığınız bir esere yapılan atıf", 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],

        // ══ L. TEZ YÖNETİMİ ══
        'L1' => ['baslik' => 'Yönetiminde tamamlanan doktora veya sanatta yeterlik tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 30],
        'L2' => ['baslik' => 'Yönetiminde tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 15],
        'L3-DOKTORA' => ['baslik' => 'Tamamlanmış doktora veya sanatta yeterlik tezinde eş danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 15],
        'L3-YL' => ['baslik' => 'Tamamlanmış yüksek lisans tezinde eş danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 7],

        // ══ M. ÖĞRETİME KATKI ══
        'M2' => ['baslik' => 'Lisansüstü düzeyde ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 10],
        'M3' => ['baslik' => 'Lisans veya ön lisans düzeyinde ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 10],

        // ══ N. PROJELER ══
        'N1' => ['baslik' => 'AB Çerçeve Programı projesinde koordinatör veya baş araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 250],
        'N2' => ['baslik' => 'AB Çerçeve Programı projesinde ortak araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci'], 'puan' => 200],
        'N3-YURUTUCU' => ['baslik' => 'Diğer uluslararası destekli bilimsel araştırma projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 200],
        'N3-ARASTIRMACI' => ['baslik' => 'Diğer uluslararası destekli bilimsel araştırma projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci'], 'puan' => 100],
        'N3-DANISMAN' => ['baslik' => 'Diğer uluslararası destekli bilimsel araştırma projesinde danışman', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['danisman'], 'puan' => 50],
        'N4-YURUTUCU' => ['baslik' => 'TÜBİTAK, TÜSEB veya benzeri ulusal kurum projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 150],
        'N4-ARASTIRMACI' => ['baslik' => 'TÜBİTAK, TÜSEB veya benzeri ulusal kurum projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci'], 'puan' => 75],
        'N4-DANISMAN' => ['baslik' => 'TÜBİTAK, TÜSEB veya benzeri ulusal kurum projesinde danışman', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['danisman'], 'puan' => 37],
        'N5-YURUTUCU' => ['baslik' => 'Diğer bakanlık, kalkınma ajansı veya belediye destekli projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 40],
        'N5-ARASTIRMACI' => ['baslik' => 'Diğer bakanlık, kalkınma ajansı veya belediye destekli projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['arastirmaci'], 'puan' => 20],
        'N5-DANISMAN' => ['baslik' => 'Diğer bakanlık, kalkınma ajansı veya belediye destekli projede danışman', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['danisman'], 'puan' => 10],
        'N6-YURUTUCU' => ['baslik' => 'Üniversite-sanayi iş birliği kapsamında projede yürütücü veya danışman', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu', 'danisman'], 'puan' => 30],
        'N7' => ['baslik' => 'Üniversite BAP biriminin desteklediği bireysel projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 20],
        'N8-YURUTUCU' => ['baslik' => 'Uluslararası/ulusal kuruluş veya üniversite destekli eğitim/sosyal içerikli projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 15],
        'N8-ARASTIRMACI' => ['baslik' => 'Uluslararası/ulusal kuruluş veya üniversite destekli eğitim/sosyal içerikli projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci'], 'puan' => 7],
        'N8-DANISMAN' => ['baslik' => 'Uluslararası/ulusal kuruluş veya üniversite destekli eğitim/sosyal içerikli projede danışman', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'roller' => ['danisman'], 'puan' => 3],

        // ══ P. KURUMSAL KATKI (idari görev; yalnızca 1 yıllık taban değeri) ══
        'P1' => ['baslik' => 'Dekan, Enstitü Müdürü, Yüksekokul Müdürü veya Meslek Yüksekokulu Müdürlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü'], 'puan' => 15],
        'P2' => ['baslik' => 'Merkez müdürlüğü veya kurum düzeyinde koordinatörlük', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 10],
        'P3' => ['baslik' => 'Senato üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Senato / Üniversite Yönetim Kurulu Üyesi'], 'puan' => 5],
        'P4' => ['baslik' => 'Kurul üyeliği veya birim/bölüm düzeyinde komisyon, koordinatörlük ya da lisans danışmanlığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 3],
        'P6' => ['baslik' => 'Bölüm başkanlığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 10],
        'P8' => ['baslik' => 'Anabilim dalı başkanlığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 3],
    ],

    'gruplar' => [
        'A1' => ['A1-*'],
        'A1-Q1-Q2-Q3' => ['A1-Q1', 'A1-Q1-YARIM', 'A1-Q2', 'A1-Q2-YARIM', 'A1-Q3', 'A1-Q3-YARIM'],
        'A1-A2' => ['A1-*', 'A2', 'A2-YARIM'],
        'A1-A2-A3' => ['A1-*', 'A2', 'A2-YARIM', 'A3', 'A3-YARIM'],
        'A1-A2-A3-A4' => ['A1-*', 'A2', 'A2-YARIM', 'A3', 'A3-YARIM', 'A4', 'A4-YARIM'],
        'A1-A2-A3-A4-A5' => ['A1-*', 'A2', 'A2-YARIM', 'A3', 'A3-YARIM', 'A4', 'A4-YARIM', 'A5', 'A5-YARIM'],
        'A1-A3' => ['A1-*', 'A3', 'A3-YARIM'],
        'A1-A3-A4' => ['A1-*', 'A3', 'A3-YARIM', 'A4', 'A4-YARIM'],
        'A1-A2-A3-A4-A5-A6' => ['A1-*', 'A2', 'A2-YARIM', 'A3', 'A3-YARIM', 'A4', 'A4-YARIM', 'A5', 'A5-YARIM'],
        'B-C' => ['B1', 'B2', 'C1', 'C2'],
        'D1-D2-D3-D4' => ['D1', 'D2', 'D3', 'D4'],
        'K' => ['K2', 'K3', 'K4', 'A4-ATIF'],
        'G-HAKEM' => ['G11'],
        'M' => ['M2', 'M3'],
        'N-YURUTUCU' => ['N1', 'N3-YURUTUCU', 'N4-YURUTUCU', 'N5-YURUTUCU', 'N6-YURUTUCU', 'N7', 'N8-YURUTUCU'],
    ],

    // K'dan toplam en fazla 200, G10/G11'den (yalnızca G11 girildi) en fazla
    // 100, M'den en fazla 120 — genel tabloda evrensel notlar. D grubunun
    // 150 tavanı yalnızca İİSBF doçentlik bağlamında kullanılıyor (başka
    // hiçbir eşik D grubuna referans vermiyor); B-C'nin tavanı kaynakta
    // fakülte/kadroya göre değişiyor (İİSBF 100, Mimarlık doçentlik 150,
    // profesörlük 250) ama motor tek cetvelde tek tavan tutabildiği için en
    // düşük ortak değer (100) evrensel uygulandı — Mimarlık adayının B/C
    // katkısı olduğundan az yansır, güvenli yönde bir sapma.
    'grup_tavanlari' => [
        'K' => 200,
        'G-HAKEM' => 100,
        'M' => 120,
        'D1-D2-D3-D4' => 150,
        'B-C' => 100,
    ],
];
