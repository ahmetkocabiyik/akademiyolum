<?php

/**
 * BURSA TEKNİK ÜNİVERSİTESİ — TABLO 2: Genel Toplam Puan İçin Faaliyet
 * Türleri ve Puanları
 * Kaynak: pdf/17536991712.bursateknikuniverstesi.pdf (89 sayfa, Senato
 * 27/05/2024-2024-9/1, YÖK onayı 24/10/2024, uygulama 15 Haziran 2025)
 *
 * MADDE KODLARI YÖNERGENİN KENDİSİ (A.1-A.11, B.1-B.9, C.1-C.8, D.1-D.7,
 * E, F, G, H, I, J, K, L). Bize ait olan tek şey rol başına bölünen proje
 * satırlarının ekleri (`D.1-yurutucu`) ve birleştirilen satırların tire ile
 * yazılmış çift kodları (`H.2-H.3`).
 *
 * ── TABLO 2 YALNIZCA "GENEL TOPLAM PUAN" İÇİN ──
 * Bu cetvel, Tablo 1'in her kadro tablosundaki SON aktivitesini (Dr. ilk
 * atanmada Aktivite 4, diğerlerinde Aktivite 5) besliyor: "Tablo 2'de verilen
 * faaliyetler kapsamında toplam N PUAN alınmalıdır". Tablo 1'in ADET
 * koşulları (Aktivite 1 ve 3) da bu cetvelin makale ve kitap satırlarına
 * bağlandı; proje koşulu (Aktivite 2) D satırlarını kullanıyor.
 *
 * ── AYNI KAYNAĞA DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   A.7 (TR Dizin veya diğer uluslararası hakemli 10) ile A.8 (A1-A6 dışı
 *       uluslararası hakemli 5): iki satır aynı kümeyi anıyor. 'TR Dizin'
 *       etiketi A.7'de (10), 'Diğer Uluslararası İndeks' A.8'de (5) kaldı.
 *   C.1/C.4 davetli konuşmacılık (uluslararası 10 / ulusal 8): tek 'Davetli
 *       Konuşmacı' etiketi → 8.
 *   D bölümünün 2,5 ve 1 puanlık rolleri: motorun `puan` alanı tam sayı,
 *       kesirli puan §0 uyarınca AŞAĞI yuvarlandı (2,5 → 2).
 *   F.1 tez danışmanlığı: "tamamlanmış" (5 / 3) ile "devam eden" (3 / 2)
 *       satırları ayrı puanlı ama faaliyet kaydında tezin bittiği bilgisi
 *       yok → doktora 3, yüksek lisans 2.
 *   F.2 tez jüri üyeliği (doktora 2 / yüksek lisans 1): tek 'Tez İzleme /
 *       Jüri Üyeliği' etiketi → 1.
 *   H.2 (uluslararası patent ABD-AB-Japonya 50) ile H.3 (diğer uluslararası
 *       40): kayıt patentin ülkesini taşımıyor → 40.
 *   H.5 (lisanslanan faydalı model/endüstriyel tasarım 30) ile H.7 (faydalı
 *       model/endüstriyel tasarım 10) → 10.
 *   I.3/I.5 burs (yurtdışı 15 / yurtiçi 10) ile L.2 (yönergede listelenen
 *       burslar 5): tek 'Burs' etiketi → 5.
 *   I.6/I.7/I.9 etkinlik ve yarışma ödülleri (5 / 2 / 5): tek 'Yarışma
 *       Derecesi / Mansiyon' etiketi → 2.
 *   J.1/J.2/J.3'ün aynı indeks basamağındaki satırları (baş editörlük,
 *       özel sayı editörlüğü, yardımcı editörlük): WoS-Scopus basamağı
 *       10/5/5 → 5; TR Dizin basamağı 5/3/3 → 3; diğer uluslararası
 *       basamağı 3/2/2 → 2.
 *   J.4 yayın kurulu üyeliği (3 / 2 / 1): tek 'Yayın Kurulu Üyeliği'
 *       etiketi → 1.
 *   J.9/J.10 hakemlik (kitap-makale 2/1, proje 4/2): tek 'Hakemlik'
 *       etiketi → 1.
 *   B.4 (Türkçe kitapta bölüm/editörlük 10) ile B.9 (diğer kitapta bölüm 3):
 *       'Kitap Bölümü' etiketi B.4'te kaldı, B.9'a 'Ansiklopedi Maddesi'
 *       verildi.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   E bölümünün TAMAMI (atıf ve h-endeksi). E.1 puanı "atıf katsayısı × 2"
 *       ve atıf katsayısı = toplam atıf / atıf alan yayın sayısı; bu bir
 *       ORTALAMA, faaliyet başına puan değil. Motor puanı faaliyet başına
 *       topladığı için her atıfa puan yazmak toplamı kat kat şişirirdi.
 *       E.2 (h-endeksi) zaten bir profil özelliği. Atıf kaydı olan adayın
 *       puanı bu yüzden olduğundan DÜŞÜK görünür.
 *   B.7 (ders notu 3), B.8 (laboratuvar kılavuzu 2) — sözlükte karşılıksız;
 *       'Ders / Metot Kitabı' etiketi B.2'de kullanıldı.
 *   C.8 (diğer uluslararası/ulusal toplantı çalışması 2) — kalan bildiri
 *       etiketi yok.
 *   D.6/D.7 (destek alamamış proje başvurusu 2) — desteklenen projeyle aynı
 *       kaynağa düşer, motor en yükseği seçeceği için başvuru sahibini
 *       destekli gibi sayardı.
 *   H.6 (patent başvurusu 10) — aynı sebeple.
 *   I.8, I.10, J.5-J.8, J.13-J.15 (topluluk ödülü, düzenleme ve bilim kurulu
 *       görevleri, sanayi danışmanlığı, TÜBA-TÜBİTAK üyelikleri) — `Diger`
 *       kategorisinin tek 'Diğer' etiketine düşerlerdi ve birbirlerini en
 *       düşük değere (2) çekerlerdi; J.5-J.8 bu etikette toplandı, kalanlar
 *       girilmedi.
 *   L.1 (dokuz ay yurt dışı araştırma 10) ve L.3 (sabbatical, ay başına 1)
 *       — süreye bağlı; sözlükte karşılıksız.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   K bölümü (idari görev) puanı AY BAŞINA veriliyor (1 ile 0,3 arası) ve
 *       "görev yapılan ay sayısı faaliyet puanı ile çarpılır" diyor. Motorda
 *       ay biriktirmesi yok ve kesirli puan tam sayıya yuvarlanıyor; satırlar
 *       görev başına 1 puanla girildi. İdari görev puanı olduğundan ÇOK
 *       DÜŞÜK görünür — buna karşılık satırların var olması, idari görev
 *       kayıtlarının tamamen kaybolmasını önlüyor.
 *   G bölümü "son beş yılda verilen dersler (ders başına)" diyor; pencere
 *       uygulanmıyor, ders başına puan veriliyor.
 *   H notu "puanlar patent alan fikri hak sahibi sayısına bölünür" — patent
 *       kategorisi yazar matrisinin dışında tutulmadığı için bu bölme genel
 *       katkı oranı tablosuyla yaklaşıklandı.
 *
 * Yönerge: yonerge/bursa-teknik.php
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 *
 * KİTAPTA İKİ EKSEN BİRBİRİNE KARIŞIYORDU (19.09.2026): B.1/B.2 puan satırları
 * DİLE göre ayrılıyor ("yabancı dilde yayımlanan" ↔ "Türkçe yayımlanan") ve
 * ikisi de ulusal VE uluslararası yayınevini kapsıyor; 4D/4E koşulları ise
 * YAYINEVİNİN KAPSAMINA bakıyor ("uluslararası yayınevleri tarafından
 * yayımlanan kitap/kitap bölümü yazarlığı" ↔ "ulusal yayınevleri…").
 *
 * Cetvel iki ekseni tek satır ailesinde topladığı için uluslararası yayınevinin
 * TÜRKÇE kitabı 4E (ulusal) koşulunu sağlıyor, 4D'yi sağlamıyordu. Aynı puanlı
 * ikinci satırlar açıldı (B.2-u, B.4-u, B.4-editorluk-u): puan B.2 ile aynı
 * (20/10/10, §0 — kitabın dili kayıtta yok) ama koşul tarafında
 * `ULUSLARARASI-KITAP` kümesine giriyorlar.
 */

return [
    'kapsam_notu' => 'Puanlar Bursa Teknik Üniversitesi TABLO 2 (Genel Toplam Puan İçin Faaliyet '
        .'Türleri ve Puanları) tablosundan. Yazar çarpanı TABLO 3\'ün isim sırası × yazar sayısı '
        .'matrisine göre işliyor (başlıca yazar birinci isim sayılır; tek yazar 1,00, beşten '
        .'fazla yazarlı çalışmada altıncı ve sonraki isimler 0,25). Yazar listesini boş '
        .'bırakırsanız çarpan hiç uygulanmaz ve puanınız olduğundan YÜKSEK görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: ATIF ve h-endeksi puanı hiç '
        .'girilemedi (yönerge bunu "atıf katsayısı × 2" diye, yani yayın başına düşen ortalama '
        .'atıf üzerinden hesaplıyor; faaliyet başına puan olarak yazılamıyor); idari görev '
        .'puanı ay başına verildiği için görev başına 1 puana indi; tamamlanmış ve devam eden '
        .'tez danışmanlıkları tek satıra düştü; editörlük ile yardımcı editörlük, hakemlik '
        .'türleri, uluslararası ile ulusal davetli konuşmacılık ve patent türleri düşük olan '
        .'değerle birleşti; ders notu, laboratuvar kılavuzu, sanayi danışmanlığı, TÜBA-TÜBİTAK '
        .'üyelikleri ve yurt dışı araştırma süresi kalemleri girilemedi. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünebilir: derslerde "son beş yıl" '
        .'penceresi uygulanmıyor; patent puanının fikri hak sahibi sayısına bölünmesi genel '
        .'yazar katkı oranıyla yaklaşıklandı. '
        .'Patent ve proje BAŞVURULARINIZI kaydetmeyin: yönerge onlara ayrı ve düşük puan '
        .'veriyor ama kayıt türü desteklenen/tescilli olandan ayrılamadığı için o satırlar hiç '
        .'girilmedi.',

    // TABLO 3: isim sırası × yazar sayısı. Not: "Aday başlıca yazarı olduğu
    // tüm yayınlarda birinci isim olarak değerlendirilir."
    'yazar_katsayisi' => [
        'haric' => ['atif', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev',
            'odul', 'editorluk', 'toplumsal_katki'],
        'roller' => (function (): array {
            $ilk = ['kademeler' => [1 => 1.00, 2 => 0.95, 3 => 0.90, 4 => 0.85, 5 => 0.80], 'sonrasi' => 0.75];

            return [
                'tek' => ['kademeler' => [1 => 1.0]],
                'ilk' => $ilk,
                'baslica' => $ilk,
                'yazar_2' => ['kademeler' => [2 => 0.85, 3 => 0.80, 4 => 0.75, 5 => 0.70], 'sonrasi' => 0.65],
                'yazar_3' => ['kademeler' => [3 => 0.70, 4 => 0.65, 5 => 0.60], 'sonrasi' => 0.55],
                'yazar_4' => ['kademeler' => [4 => 0.55, 5 => 0.50], 'sonrasi' => 0.45],
                'yazar_5' => ['kademeler' => [5 => 0.40], 'sonrasi' => 0.35],
                'yazar_6' => ['sonrasi' => 0.25],
                // Sırasını belirtmeyen aday o yazar sayısındaki en düşük satırı alır.
                'ortak' => ['kademeler' => [1 => 1.00, 2 => 0.85, 3 => 0.70, 4 => 0.55, 5 => 0.40], 'sonrasi' => 0.25],
            ];
        })(),
    ],

    'maddeler' => [
        // ══ A. YAYIN ══
        'A.1' => ['baslik' => 'WoS Q1 kategorisindeki dergide yayın', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 55],
        'A.2' => ['baslik' => 'WoS Q2 kategorisindeki dergide yayın', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 45],
        'A.3' => ['baslik' => 'WoS Q3 kategorisindeki dergide yayın', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 35],
        'A.4' => ['baslik' => 'WoS Q4 kategorisindeki dergide yayın', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 25],
        'A.5' => ['baslik' => 'AHCI kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 45],
        'A.6' => ['baslik' => 'ESCI veya Scopus endekslerince taranan dergide yayın', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 20],
        'A.7' => ['baslik' => 'ULAKBİM TR Dizin dergisinde yayın', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 10],
        'A.8' => ['baslik' => 'Diğer uluslararası hakemli dergide yayın', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 5],
        'A.9' => ['baslik' => 'Ulusal hakemli dergide yayın', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 5],
        'A.10' => ['baslik' => 'WoS veya AHCI kapsamındaki dergide editöre mektup, araştırma notu, özet veya kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 5],
        'A.11' => ['baslik' => 'ESCI, Scopus, TR Dizin veya ulusal hakemli dergide editöre mektup, araştırma notu, özet veya kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'TR Dizin', 'Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 2],

        // ══ B. KİTAP ══
        'B.1' => ['baslik' => 'BKCI kapsamında ya da ulusal/uluslararası yayınevince yabancı dilde yayımlanan bilimsel, mesleki veya ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 30],
        'B.2' => ['baslik' => 'Ulusal yayınevince Türkçe yayımlanan bilimsel, mesleki veya ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı'], 'puan' => 20],
        // B.2 iki yayınevi kapsamını birden sayıyor; 4D/4E koşulları ise kapsamı
        // ayırıyor. Aynı puanlı ikinci satır, uluslararası yayınevinin Türkçe
        // kitabını doğru KOŞULA (4D) sokuyor.
        'B.2-u' => ['baslik' => 'Uluslararası yayınevince Türkçe yayımlanan bilimsel, mesleki veya ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası Kitap', 'Uluslararası Ders / Metot Kitabı'], 'puan' => 20],
        'B.3' => ['baslik' => 'Yabancı dilde yayımlanan kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 15],
        'B.3-editorluk' => ['baslik' => 'Yabancı dilde yayımlanan kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 15],
        'B.4' => ['baslik' => 'Ulusal yayınevinin Türkçe kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap Bölümü'], 'puan' => 10],
        'B.4-u' => ['baslik' => 'Uluslararası yayınevinin Türkçe kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası Kitap Bölümü'], 'puan' => 10],
        'B.4-editorluk' => ['baslik' => 'Ulusal yayınevinin Türkçe kitabında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Ulusal Kitap Editörlüğü', 'Kitap Editörlüğü'], 'puan' => 10],
        'B.4-editorluk-u' => ['baslik' => 'Uluslararası yayınevinin Türkçe kitabında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Uluslararası Kitap Editörlüğü'], 'puan' => 10],
        'B.5' => ['baslik' => 'Yabancı dilde yayımlanan bir kitabın yayımlanmış çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 10],
        'B.6' => ['baslik' => 'Yabancı dilde yayımlanan bir kitabın yayımlanmış bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 5],
        'B.9' => ['baslik' => 'Diğer uluslararası veya ulusal kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 3],

        // ══ C. BİLDİRİ ══
        'C.1-C.4' => ['baslik' => 'Hakemli bir etkinlikte davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 8],
        'C.2' => ['baslik' => 'Uluslararası hakemli bir etkinlikte sunulan ve tam metni yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin'], 'puan' => 8],
        'C.3' => ['baslik' => 'Uluslararası hakemli bir etkinlikte sunulan ve özet metni yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 4],
        'C.5' => ['baslik' => 'Ulusal hakemli bir etkinlikte sunulan ve tam metni yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 4],
        'C.6' => ['baslik' => 'Ulusal hakemli bir etkinlikte sunulan ve özet metni yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 2],
        'C.7' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan ve CPCI\'da yayımlanan çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 8],

        // ══ D. PROJE (kesirli puanlar aşağı yuvarlandı) ══
        'D.1-yurutucu' => ['baslik' => 'TÜBİTAK 1001-1007, 2232, 2236, 3501, 1711, TEYDEB 1505, COST, Horizon veya Erasmus projesinde yürütücü ya da koordinatör', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 20],
        'D.1-arastirmaci' => ['baslik' => 'TÜBİTAK 1001-1007, 2232, 2236, 3501, 1711, TEYDEB 1505, COST, Horizon veya Erasmus projesinde araştırmacı ya da danışman', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman'], 'puan' => 10],
        'D.1-bursiyer' => ['baslik' => 'TÜBİTAK 1001-1007, 2232, 2236, 3501, 1711, TEYDEB 1505, COST, Horizon veya Erasmus projesinde bursiyer', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'AB Çerçeve / Ufuk'], 'roller' => ['bursiyer'], 'puan' => 5],
        'D.2-yurutucu' => ['baslik' => 'Diğer TÜBİTAK, kamu destekli veya Erasmus K2 projesinde yürütücü ya da koordinatör', 'kategori' => 'proje', 'kaynaklar' => ['TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 10],
        'D.2-arastirmaci' => ['baslik' => 'Diğer TÜBİTAK, kamu destekli veya Erasmus K2 projesinde araştırmacı ya da danışman', 'kategori' => 'proje', 'kaynaklar' => ['TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman'], 'puan' => 5],
        'D.2-bursiyer' => ['baslik' => 'Diğer TÜBİTAK, kamu destekli veya Erasmus K2 projesinde bursiyer', 'kategori' => 'proje', 'kaynaklar' => ['TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['bursiyer'], 'puan' => 2],
        'D.3-yurutucu' => ['baslik' => 'TÜBİTAK ve kamu dışındaki uluslararası fon sağlayan kurumla yapılan projede yürütücü ya da koordinatör', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 20],
        'D.3-arastirmaci' => ['baslik' => 'TÜBİTAK ve kamu dışındaki uluslararası fon sağlayan kurumla yapılan projede araştırmacı ya da danışman', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman'], 'puan' => 10],
        'D.3-bursiyer' => ['baslik' => 'TÜBİTAK ve kamu dışındaki uluslararası fon sağlayan kurumla yapılan projede bursiyer', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['bursiyer'], 'puan' => 5],
        'D.4-yurutucu' => ['baslik' => 'TÜBİTAK dışındaki ulusal fon sağlayan kurumla yapılan proje veya BAP projesinde yürütücü ya da koordinatör', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 5],
        'D.4-arastirmaci' => ['baslik' => 'TÜBİTAK dışındaki ulusal fon sağlayan kurumla yapılan proje veya BAP projesinde araştırmacı ya da danışman', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman'], 'puan' => 2],
        'D.4-bursiyer' => ['baslik' => 'TÜBİTAK dışındaki ulusal fon sağlayan kurumla yapılan proje veya BAP projesinde bursiyer', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK'], 'roller' => ['bursiyer'], 'puan' => 1],
        'D.5' => ['baslik' => 'TÜBİTAK 2209-A veya 2209-B danışmanlığı ya da Erasmus K1 projesi', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'puan' => 2],

        // ══ F. TEZ ══
        'F.1-doktora' => ['baslik' => 'Doktora tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman', 'es_danisman'], 'puan' => 3],
        'F.1-yukseklisans' => ['baslik' => 'Yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman', 'es_danisman'], 'puan' => 2],
        'F.2' => ['baslik' => 'Tez jüri üyeliği (danışmanı olduğunuz öğrencinin tezi hariç)', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 1],

        // ══ G. DERS ══
        'G.1' => ['baslik' => 'İngilizce verilen ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Yabancı Dilde Ders'], 'puan' => 4],
        'G.2' => ['baslik' => 'Türkçe verilen ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Değişim Programı Dersi'], 'puan' => 2],

        // ══ H. PATENT (başvuru satırları girilmedi) ══
        'H.1' => ['baslik' => 'Lisanslanan uluslararası veya ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 60],
        'H.2-H.3' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 40],
        'H.4' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 40],
        'H.5-H.7' => ['baslik' => 'Faydalı model veya endüstriyel tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili', 'Yazılım'], 'puan' => 10],

        // ══ I. ÖDÜL ══
        'I.1' => ['baslik' => 'YÖK, TÜBA veya TÜBİTAK\'tan alınan bilim ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 40],
        'I.2' => ['baslik' => 'Alanınızda yurt dışı kurum veya kuruluşlardan alınan bilim, sanat ya da tasarım ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 20],
        'I.4' => ['baslik' => 'Alanınızda yurt içi kamu kurum ve kuruluşlarından alınan bilim, sanat ya da tasarım ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 10],
        'I.3-I.5-L.2' => ['baslik' => 'Alanınızda alınan eğitim veya araştırma bursu', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 5],
        'I.6-I.7-I.9' => ['baslik' => 'Bilimsel etkinliklerin bilim, sanat ya da tasarım kurulunca verilen ödül veya yarışma derecesi', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 2],

        // ══ J. AKADEMİK GÖREV ══
        'J.1-J.3-a' => ['baslik' => 'WoS, Scopus, AHCI veya ESCI kapsamındaki dergide baş editörlük, özel sayı editörlüğü ya da yardımcı editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 5],
        'J.1-J.3-b' => ['baslik' => 'ULAKBİM TR Dizin ya da diğer uluslararası alan endeksli hakemli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 3],
        'J.1-J.3-c' => ['baslik' => 'Diğer uluslararası hakemli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi (Uluslararası)'], 'puan' => 2],
        'J.4' => ['baslik' => 'Dergi yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 1],
        'J.9-J.10' => ['baslik' => 'Kitap, makale veya proje hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 1],
        'J.11-uluslararasi' => ['baslik' => 'Uluslararası proje yarışmasında jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], 'puan' => 4],
        'J.11-ulusal' => ['baslik' => 'Ulusal proje yarışmasında jüri üyeliği (Teknofest dâhil)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 2],
        'J.12-uluslararasi' => ['baslik' => 'Uluslararası sergi küratörlüğü ve sergiye ilişkin yayınların yazarlığı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Kişisel Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Uluslararası)'], 'puan' => 4],
        'J.12-ulusal' => ['baslik' => 'Ulusal sergi küratörlüğü ve sergiye ilişkin yayınların yazarlığı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Kişisel Etkinlik (Ulusal)', 'Karma/Jürili Etkinlik (Ulusal)'], 'puan' => 2],
        'J.5-J.8' => ['baslik' => 'Bilimsel etkinlikte düzenleme kurulu, bilim kurulu, oturum başkanlığı ya da panelistlik', 'kategori' => 'diger', 'kaynaklar' => ['Diğer', 'Oturum Başkanlığı (Uluslararası)', 'Oturum Başkanlığı (Ulusal)'], 'puan' => 2],

        // ══ K. İDARİ GÖREV (ay biriktirmesi uygulanamadı, görev başına 1) ══
        'K.1' => ['baslik' => 'Rektörlük, rektör yardımcılığı, enstitü, yüksekokul, merkezi araştırma laboratuvarı müdürlüğü, BAP koordinatörlüğü, TTO veya teknokent müdürlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü'], 'puan' => 1],
        'K.2' => ['baslik' => 'Uygulama ve araştırma merkezi müdürlüğü, bölüm başkanlığı, dekan yardımcılığı veya müdür yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü', 'Bölüm Başkanı', 'Dekan Yrd. / Müdür Yrd.'], 'puan' => 1],
        'K.4' => ['baslik' => 'Senato üyeliği veya rektörlük bünyesinde koordinatörlük', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 1],
        'K.6' => ['baslik' => 'Komisyon üyeliği, bölüm başkan yardımcılığı, fakülte kurulu üyeliği veya öğrenci topluluk danışmanlığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği', 'Bölüm Başkan Yardımcısı'], 'puan' => 1],

        // ══ TOPLUMSAL KATKI (Tablo 2'de karşılığı olmayan kayıt türleri) ══
        // J.13 sanayi danışmanlığı ay başına 0,5 puan; tam sayıya inince 0
        // olduğu için puansız bırakıldı ama satır duruyor, aksi hâlde bu
        // kayıtlar hiçbir maddeye uymayıp adayın listesinden düşerdi.
        'J.13' => ['baslik' => 'Uzmanlık alanınızla ilgili sanayiye verilen danışmanlık hizmeti', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı', 'Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 0],
    ],

    // Tablo 1'in Aktivite koşullarının andığı kümeler.
    'gruplar' => [
        '*TUM' => ['*'],
        // Aktivite 1/3'ün "WoS Q1-Q2 yayın" satırı.
        'Q1-Q2' => ['A.1', 'A.2'],
        // "AHCI, WoS Q1-Q2-Q3 yayın" satırı. Mühendislik fakültesinin
        // tablolarında AHCI anılmıyor ama küme aynı kaldı: AHCI dergisi
        // mühendislik adayında zaten çıkmıyor.
        'AHCI-Q1-Q3' => ['A.1', 'A.2', 'A.3', 'A.5'],
        // "WoS Q4 veya ESCI veya Scopus veya TR Dizin yayınları veya
        // Ulusal/uluslararası kitap/kitap bölümü veya uluslararası hakemli
        // konferanslarda sözlü olarak sunulmuş tam metin bildiri" ek kümesi.
        'EK-KUME' => ['A.4', 'A.6', 'A.7', 'B.1', 'B.2', 'B.2-u', 'B.3', 'B.4', 'B.4-u', 'B.9', 'C.2', 'C.7'],
        // Mühendislik Fakültesi'nin tabloları AHCI'yi anmıyor, yalnızca
        // "WoS Q1-Q2-Q3 yayın" diyor.
        'Q1-Q3' => ['A.1', 'A.2', 'A.3'],
        // Mimarlık, Tasarım ve Peyzaj tablolarının ek kümesi, EK-KUME'ye
        // "A/B tipi (ACQ Web) uluslararası yayınevi kitabı" ile
        // "ulusal/uluslararası mesleki yarışmalarda ilk üç ödül"ü ekliyor.
        'EK-KUME-TASARIM' => ['A.4', 'A.6', 'A.7', 'B.1', 'B.2', 'B.2-u', 'B.3', 'B.4', 'B.4-u', 'B.9', 'C.2', 'C.7', 'I.6-I.7-I.9'],
        // "ESCI, Scopus, WoS Q1-Q2-Q3-Q4 yayın" (İnsan ve Toplum 1D).
        'ESCI-Q1-Q4' => ['A.1', 'A.2', 'A.3', 'A.4', 'A.6'],
        // "Uluslararası endekslerde yayımlanmış makale veya TR Dizin makale
        // veya ulusal/uluslararası kitap/kitap bölümü" (İnsan ve Toplum 1E).
        'GENIS-YAYIN' => ['A.1', 'A.2', 'A.3', 'A.4', 'A.5', 'A.6', 'A.7', 'A.8', 'B.1', 'B.2', 'B.2-u', 'B.3', 'B.4', 'B.4-u', 'B.9'],
        // Aktivite 2'nin puan topladığı proje ve tescil kümesi.
        'PROJE' => ['D.*'],
        'PROJE-ODUL' => ['D.*', 'H.1', 'H.2-H.3', 'H.4', 'H.5-H.7', 'I.1', 'I.2', 'I.4', 'I.3-I.5-L.2', 'I.6-I.7-I.9'],
        // Aktivite 4'ün alt ölçütlerinin andığı kümeler.
        'TEZ' => ['F.1-doktora', 'F.1-yukseklisans'],
        'DAVETLI' => ['C.1-C.4'],
        'TAM-METIN-BILDIRI' => ['C.2', 'C.7', 'C.5'],
        'ULUSLARARASI-KITAP' => ['B.1', 'B.2-u', 'B.3', 'B.3-editorluk', 'B.4-u', 'B.4-editorluk-u'],
        'ULUSAL-KITAP' => ['B.2', 'B.4', 'B.4-editorluk', 'B.9'],
        'EDITORLUK' => ['J.1-J.3-a', 'J.1-J.3-b', 'J.1-J.3-c', 'J.4'],
        'ODUL' => ['I.1', 'I.2', 'I.4', 'I.6-I.7-I.9'],
        'BURS' => ['I.3-I.5-L.2'],
        'PATENT' => ['H.1', 'H.2-H.3', 'H.4', 'H.5-H.7'],
        'BUYUK-PROJE' => ['D.1-yurutucu', 'D.1-arastirmaci', 'D.1-bursiyer'],
        // Aktivite 4/4F: "en az 6 dönem lisans veya lisansüstü ders".
        'TUM-DERS' => ['G.1', 'G.2'],
        'IDARI' => ['K.*'],
    ],
];
