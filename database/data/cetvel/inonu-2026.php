<?php

/**
 * İNÖNÜ ÜNİVERSİTESİ — EK-1: Akademik Yükseltilme ve Atanmalarda Dikkate
 * Alınacak Puanlama Tablosu
 * Kaynak: pdf/178160788251.inonu-kriter-15042026.pdf (2026 sürümü)
 * Yürürlük: Madde 20 — YÖK onayı üzerine 1/6/2026
 *
 * KORPUSUN EN GENİŞ KATEGORİ UZAYI: A-T arası on dokuz bölüm (makale, bildiri,
 * kitap, çeviri, atıf, adayın adıyla anılan buluş, editörlük, kongre
 * düzenleme, eğitim, tez, proje, girişimcilik/TTO, FSMH, ödül, güzel sanatlar,
 * spor, idari görev, iletişim, toplumsal katkı). Koşullar bu bölümlere KOD
 * ARALIĞIYLA atıf yapıyor ("A Puanı", "Proje Puanı (K1-K12)", "Patent
 * (M1-M5)"), o yüzden kodlar birebir korundu.
 *
 * KENDİ ÜRETTİĞİMİZ ALT KODLAR:
 *   `A.6.1`-`A.6.8`  A.6 tek satırda "A.1-A.5'teki dergilerde yayımlanan
 *       teknik not, editöre mektup, tartışma, vaka takdimi, özet ve kitap
 *       incelemesi için belirtilen puanın 1/3'ü alınır" diyor; 1/3 her dergi
 *       kademesinde farklı bir sayı ettiği için sekiz satıra açıldı
 *       (aşağı yuvarlandı: 200/3 → 66).
 *   `C.1.a.1`, `C.3.a.1`, `C.3.a.2`  "Kitap bölümleri eşdeğer kitap puanının
 *       1/3'ü, ansiklopedi maddesi 1/6'sı" notunun karşılığı.
 *   `D.3.a.1`  "Kitap bölümü çevirileri eşdeğer çeviri puanının 1/3'ü".
 *   `K.*.a/.b/.c`  Proje puanı role göre bölünüyor (yürütücü 1,0 · araştırmacı
 *       0,5 · danışman 0,3 · bursiyer 0,2); motor kod başına tek puan tuttuğu
 *       için her proje satırı dört role ayrıldı.
 *
 * DEVAM EDEN PROJE KATSAYISI UYGULANDI: "K.1-K.10 kategorisinde süreci devam
 * eden projelerin puan değeri 0,75 ile, biten projeler ise 1 ile çarpılır."
 * Faaliyet kaydı projenin bitip bitmediğini tutmuyor, bu yüzden K.2-K.9
 * satırlarında DEVAM EDEN katsayısı (0,75) kullanıldı — biten projesi olan
 * aday puanını olduğundan düşük görür. K.13 ve K.14 bu notun dışında.
 *
 * ── AYNI KAYNAĞA DÜŞEN İKİ SATIRDA DAİMA DÜŞÜĞÜ GİRİLDİ ──
 *   Kitap C.1.a (200) / C.2.a (100) / C.3.a (50): sözlük yayınevinin
 *       uluslararası indeksli olup olmadığını ayırıyor ama "diğer
 *       uluslararası" ile "ulusal"ı ayırmıyor → 'Uluslararası/Ulusal Kitap'
 *       C.3.a'ya (50) kondu.
 *   Ders kitabı C.1.b (150) / C.2.b (50) / C.3.b (30) → C.3.b.
 *   Çeviri D.1.a (50) / D.2.a (30) / D.3.a (20) → D.3.a.
 *   Bildiri: 'Davetli Konuşmacı' B.1.a (30) / B.2.a (20) / B.3.a (15) → B.3.a.
 *       'Uluslararası Özet/Poster' B.1.c (15) / B.2.c (10) → B.2.c.
 *   Yayın kurulu üyeliği G.1.b (25) / G.2.b (15) / G.3.b (10) → G.3.b.
 *   Hakemlik G.1.d (10) / G.2.c (5) / G.3.d (2) → G.3.d.
 *   Kitap editörlüğü G.4.a-f: indeksli olan G.4.a'ya, kalanı en düşük
 *       satıra (G.4.f, 10).
 *   Burs N.3 (100) / N.4 (50) → N.4. Yarışma derecesi N.5 (30) / N.6 (20) → N.6.
 *
 * ── GİRİLMEYEN BÖLÜMLER ──
 *   F   adayın adıyla anılan formül, şema, buluş — kaynak sözlüğünde yok.
 *   H   kongre ve sempozyum DÜZENLEME — sözlükte organizatörlük etiketi yok.
 *   İ.1-İ.3  eğiticinin eğitimi sertifikası, topluma hizmet dersi, hizmet içi
 *       eğitim eğiticiliği.
 *   L   GİRİŞİMCİLİK, TGB, TTO ve İŞ DÜNYASI (L.1-L.18) — on sekiz satırın
 *       yalnızca biri (L.18, öğrenci projesi danışmanlığı) sözlükte karşılık
 *       buluyor. "L1-L18 Puanı" koşulu bu yüzden ŞART AĞACINA HİÇ YAZILMADI;
 *       yarısı eksik bir baraj adaya sağlayamayacağı bir hedef gösterirdi.
 *   P   SPORTİF FAALİYETLER (P.1-P.8) — sporculuk, antrenörlük, hakemlik:
 *       sözlükte hiçbiri yok. Spor Bilimleri adayının toplamı bu yüzden
 *       olduğundan düşük çıkar.
 *   S   İLETİŞİM BİLİMLERİ (S.1-S.4) — yayın koordinatörlüğü, film
 *       festivali, kişisel etkinlik rolleri.
 *   J.1 uluslararası öğrenci tezi — kayıt öğrencinin uyruğunu tutmuyor.
 *   M.3, M.5, M.6, M.7, M.11-M.13  patent/telif BAŞVURUSU ve hizmet buluşu
 *       kararları — sözlük tescil ile başvuruyu ayırmıyor, tescil satırları
 *       yazıldı.
 *   O bölümünün konservatuvara özgü ince ayrımları (solistlik, rejisörlük,
 *       koreografi, opera rolleri) — İnönü tablosunda karşılık satırı yok.
 *
 * ── UYGULANAMAYAN ÇARPANLAR (hepsi puanı DÜŞÜK gösterir) ──
 *   Madde 5(4)  QS ilk 100 ortaklı çalışma ×2, ilk 500 ×1,6, diğer
 *       uluslararası ortaklı ×1,4, ulusal ortaklı ×1,2.
 *   J notu      Sanayi iş birliği projesi kapsamında tamamlanan tezler ×2.
 *   M notu      TTO/Teknokent belgeli iş dünyası iş birliği faaliyetleri ×1,5.
 *   S notu      İletişim etkinliklerinin uluslararası olması hâlinde ×2.
 *
 * Yönerge: yonerge/inonu.php
 *
 * İNDEKS KADEMESİ KAPSAM ETİKETİNE DE AÇILDI (19.09.2026, kullanıcı kararı):
 * kaynağın uluslararası kitap satırı indeks kapsamına bağlı (BKCI/Scopus/WoS)
 * ama kaynakta İNDEKSSİZ uluslararası kitabın ayrı bir satırı YOK; alternatif
 * ULUSAL satır. Kapsam etiketi bu yüzden uluslararası satıra bağlandı, ulusal
 * satırlar daraltıldı. Kaynağın indeksli/indekssiz ayrımı motorda artık
 * uygulanmıyor: indekssiz uluslararası kitabınız indeksli kitapla aynı puanı
 * alır, yani puanınız OLDUĞUNDAN YÜKSEK görünebilir.
 */

return [
    'kapsam_notu' => 'Puanlar İnönü Üniversitesi 2026 yönergesinin EK-1 puanlama tablosundan. '
        .'Çok yazarlı yayınlarda puan yönergenin Tablo 1 dağılımına göre azaltılır; çarpan hem '
        .'yazar sayısına hem sıranıza bağlı olduğu için faaliyetinizde kaçıncı yazar olduğunuzu '
        .'seçmeniz gerekir. Sırayı belirtmezseniz o yazar sayısındaki en düşük çarpan uygulanır; '
        .'yazar listesini boş bırakırsanız çarpan hiç uygulanmaz ve puanınız olduğundan yüksek '
        .'görünür. Çarpan yalnızca makale, bildiri, kitap ve çeviri kalemlerinde işler — yönerge '
        .'çarpanı A-D bölümleriyle sınırlıyor. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: girişimcilik, teknopark ve teknoloji '
        .'transfer faaliyetleri (yönergenin L bölümü), sportif faaliyetler (P bölümü), iletişim '
        .'bilimleri etkinlikleri (S bölümü) ve kongre düzenleme (H bölümü) kaynakta '
        .'ayrılamadığı için hiç girilmedi; projelerde "devam ediyor" katsayısı (0,75) '
        .'kullanıldı, tamamlanmış projeniz varsa gerçek puanınız daha yüksek; yönergenin ortak '
        .'çalışma çarpanları (QS ilk 100 ortağı ×2, sanayi iş birlikli tez ×2) uygulanmıyor. '
        .'Incites/SciVal dilim çarpanı (%1 ×3, %10 ×1,5) uygulanıyor: makalenizi ilgili dilim '
        .'etiketiyle girin. '
        .'Spor Bilimleri adayları en çok etkilenir: sportif faaliyet bölümünün tamamı dışarıda '
        .'kaldı. Girişimcilik bölümü girilemediği için yönergenin "L1-L18 Puanı" barajı hiçbir '
        .'kadroda gösterilmiyor; gerçek başvuruda o baraj da aranacak.'
        .' KİTAPTA İNDEKS KOŞULU DENETLENMİYOR: uluslararası yayınevi kitabınız yönergenin BKCI/Scopus taranan kitap satırından sayılıyor. Kitabınız bu kapsamda değilse puanınız olduğundan YÜKSEK görünür.',

    // Madde 12 + Tablo 1. Çarpan YALNIZCA A-D bölümlerine (makale, bildiri,
    // kitap, çeviri) uygulanır; yönergenin kendi sınırı bu.
    //
    //   sıra \ sayı   1.isim 2.isim 3.isim 4.isim 5.isim 6.isim ve sonrası
    //   1              100
    //   2               95     85
    //   3               90     80     70
    //   4               85     75     65     55
    //   5               80     70     60     50     40
    //   ≥6              75     65     55     45     35            25
    //
    // Madde 4(b): "Başlıca yazar: tek yazarlı makalelerde yazarın kendisini,
    // çok yazarlı makalelerde birinci isim olan yazarı … ifade eder."
    // `baslica` bu yüzden `ilk` ile aynı satırda.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'proje', 'patent', 'editorluk', 'odul', 'egitim_ogretim',
            'tez_danismanligi', 'idari_gorev', 'sanatsal_etkinlik', 'toplumsal_katki'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.0]],
            'ilk' => ['kademeler' => [1 => 1.0, 2 => 0.95, 3 => 0.90, 4 => 0.85, 5 => 0.80], 'sonrasi' => 0.75],
            'baslica' => ['kademeler' => [1 => 1.0, 2 => 0.95, 3 => 0.90, 4 => 0.85, 5 => 0.80], 'sonrasi' => 0.75],
            'yazar_2' => ['kademeler' => [2 => 0.85, 3 => 0.80, 4 => 0.75, 5 => 0.70], 'sonrasi' => 0.65],
            'yazar_3' => ['kademeler' => [3 => 0.70, 4 => 0.65, 5 => 0.60], 'sonrasi' => 0.55],
            'yazar_4' => ['kademeler' => [4 => 0.55, 5 => 0.50], 'sonrasi' => 0.45],
            'yazar_5' => ['kademeler' => [5 => 0.40], 'sonrasi' => 0.35],
            'yazar_6' => ['sonrasi' => 0.25],
            'ortak' => ['kademeler' => [1 => 1.0, 2 => 0.85, 3 => 0.70, 4 => 0.55, 5 => 0.40], 'sonrasi' => 0.25],
        ],
    ],

    'maddeler' => [
        // ══ A. MAKALELER ══
        // Q değeri olmayan AHCI, en düşük çeyreklik satırına kondu.
        // DERLEME: A.1 "özgün makaleler" diyor, A.6 ise derlemeyi saymıyor.
        // Kaynak ayrımı olmadığı için derleme A.6 satırlarına (1/3) kondu.
        // ── MADDE 7(2) ÇARPANI SATIRA ÇEVRİLDİ ──
        // "Makalenin puan değeri … %1'lik dilimde yer alması hâlinde 3,
        // %10'luk dilimde yer alması hâlinde 1,5 ile çarpılır." Motorun satır
        // bazlı çarpanı yok ama sözlük 17.09.2026'da dilim eksenini açtı;
        // çarpım ÖNCEDEN yapılıp ayrı satır olarak yazıldı. Dilim kademesi
        // tanımı gereği Q1'in içinde, o yüzden yalnız Q1 satırları çarpılır.
        'A.1.a.d1' => ['baslik' => 'Incites/SciVal ilk %1\'lik dilimdeki Q1 dergide özgün makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (İlk %1)'], 'turler' => ['ozgun_makale'], 'puan' => 600],
        'A.1.a.d10' => ['baslik' => 'Incites/SciVal ilk %10\'luk dilimdeki Q1 dergide özgün makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (İlk %10)'], 'turler' => ['ozgun_makale'], 'puan' => 300],
        'A.1.a' => ['baslik' => 'SCI-E, SSCI veya AHCI kapsamındaki Q1 dergide özgün makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale'], 'puan' => 200],
        'A.1.b' => ['baslik' => 'SCI-E, SSCI veya AHCI kapsamındaki Q2 dergide özgün makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale'], 'puan' => 150],
        'A.1.c' => ['baslik' => 'SCI-E, SSCI veya AHCI kapsamındaki Q3 dergide özgün makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale'], 'puan' => 90],
        'A.1.d' => ['baslik' => 'SCI-E, SSCI veya AHCI kapsamındaki Q4 dergide özgün makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 60],
        'A.2' => ['baslik' => 'ESCI, Scopus veya SPORTDiscus kapsamındaki dergide özgün makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale'], 'puan' => 50],
        'A.3' => ['baslik' => 'ULAKBİM TR Dizin kapsamındaki dergide özgün makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 40],
        'A.4' => ['baslik' => 'Diğer uluslararası hakemli dergide özgün makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale'], 'puan' => 30],
        'A.5' => ['baslik' => 'Ulusal hakemli dergide özgün makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale'], 'puan' => 20],
        // A.6 — aynı dergilerde derleme, teknik not, editöre mektup, tartışma,
        // vaka takdimi, özet ve kitap incelemesi: satır puanının 1/3'ü.
        // Çarpan derleme/kısa makale satırına da işliyor (66 → 198 / 99).
        'A.6.1.d1' => ['baslik' => 'Incites/SciVal ilk %1\'lik dilimdeki Q1 dergide derleme, teknik not, editöre mektup, vaka takdimi veya özet', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (İlk %1)'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 198],
        'A.6.1.d10' => ['baslik' => 'Incites/SciVal ilk %10\'luk dilimdeki Q1 dergide derleme, teknik not, editöre mektup, vaka takdimi veya özet', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (İlk %10)'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 99],
        'A.6.1' => ['baslik' => 'Q1 dergide derleme, teknik not, editöre mektup, vaka takdimi veya özet', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 66],
        'A.6.2' => ['baslik' => 'Q2 dergide derleme, teknik not, editöre mektup, vaka takdimi veya özet', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 50],
        'A.6.3' => ['baslik' => 'Q3 dergide derleme, teknik not, editöre mektup, vaka takdimi veya özet', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 30],
        'A.6.4' => ['baslik' => 'Q4 veya AHCI dergide derleme, teknik not, editöre mektup, vaka takdimi veya özet', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 20],
        'A.6.5' => ['baslik' => 'ESCI, Scopus veya SPORTDiscus dergide derleme, teknik not, editöre mektup veya özet', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 16],
        'A.6.6' => ['baslik' => 'TR Dizin dergide derleme, teknik not, editöre mektup veya özet', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 13],
        'A.6.7' => ['baslik' => 'Diğer uluslararası hakemli dergide derleme, teknik not, editöre mektup veya özet', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 10],
        'A.6.8' => ['baslik' => 'Ulusal hakemli dergide derleme, teknik not, editöre mektup veya özet', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 6],

        // ══ B. BİLDİRİLER ══
        'B.1.b' => ['baslik' => 'CPCI veya Scopus kapsamındaki toplantıda tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 20],
        'B.2.b' => ['baslik' => 'Diğer uluslararası toplantıda tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin'], 'puan' => 15],
        'B.2.c' => ['baslik' => 'Uluslararası toplantıda özet bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 10],
        'B.3.a' => ['baslik' => 'Bilimsel toplantıda davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 15],
        'B.3.b' => ['baslik' => 'Ulusal toplantıda tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 10],
        'B.3.c' => ['baslik' => 'Ulusal toplantıda özet bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 5],

        // ══ C. KİTAPLAR ══
        'C.1.a' => ['baslik' => 'BKCI veya Scopus taranan uluslararası yayınevinde bilimsel/mesleki kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası Kitap'], 'puan' => 200],
        'C.1.a.1' => ['baslik' => 'BKCI veya Scopus taranan uluslararası yayınevinde kitap bölümü', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Uluslararası Kitap Bölümü'], 'puan' => 66],
        'C.3.a' => ['baslik' => 'Ulusal yayınevinde bilimsel/mesleki kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap'], 'puan' => 50],
        'C.3.a.1' => ['baslik' => 'Ulusal yayınevinde kitap bölümü', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap Bölümü'], 'puan' => 16],
        'C.3.a.2' => ['baslik' => 'Ansiklopedi maddesi', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 8],
        'C.3.b' => ['baslik' => 'Ulusal yayınevinde ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Ders / Metot Kitabı'], 'puan' => 30],

        // ══ D. ÇEVİRİLER ══
        'D.3.a' => ['baslik' => 'Bilimsel veya mesleki kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 20],
        'D.3.a.1' => ['baslik' => 'Kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 6],

        // ══ E. ATIFLAR (kendi eserlerine yapılan atıflar hariç) ══
        'E.1' => ['baslik' => 'SCI-E, SSCI, AHCI dergilerinde veya BKCI/Scopus kitaplarında her bir atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 4],
        'E.3' => ['baslik' => 'TR Dizin dergilerinde veya ulusal kitaplarda her bir atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 1],
        // E.5 yönergede 0,5 puan; motor tam sayı tuttuğu için aşağı yuvarlandı.
        'E.5' => ['baslik' => 'Ulusal hakemli dergilerde her bir atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer'], 'puan' => 0],

        // ══ G. EDİTÖRLÜK VE HAKEMLİK ══
        'G.1.a' => ['baslik' => 'SCI-E, SSCI veya AHCI kapsamındaki dergide editörlük (yıl başına)', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 50],
        'G.2.a' => ['baslik' => 'ESCI, Scopus, SPORTDiscus veya TR Dizin dergide editörlük (yıl başına)', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi', 'TR Dizin Dergi'], 'puan' => 30],
        'G.3.a' => ['baslik' => 'Diğer hakemli dergide editörlük (yıl başına)', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 20],
        'G.3.b' => ['baslik' => 'Derginin yayın kurulunda veya editörler listesinde yer almak (yıl başına)', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 10],
        'G.3.d' => ['baslik' => 'Makale veya proje hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 2],
        'G.4.a' => ['baslik' => 'BKCI veya Scopus taranan uluslararası yayınevi kitabında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Uluslararası Kitap Editörlüğü'], 'puan' => 40],
        'G.4.f' => ['baslik' => 'Kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 10],

        // ══ İ. EĞİTİM VE ÖĞRETİM FAALİYETİ ══
        // İ.4 bölüm tavanı 200 puan (yönergenin kendi dipnotu).
        'İ.4' => ['baslik' => 'Zorunlu ders yükü dışında yürütülen ders (dönem başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 5],

        // ══ J. LİSANSÜSTÜ TEZ YÖNETİMİ ══
        'J.2.a' => ['baslik' => 'Yönetilmiş doktora, sanatta yeterlik veya uzmanlık tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 40],
        'J.2.b' => ['baslik' => 'Yönetilmiş yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 20],

        // ══ K. PROJELER ══
        // Rol katsayısı: yürütücü 1,0 · araştırmacı 0,5 · danışman 0,3 ·
        // bursiyer 0,2. K.2-K.9'da ayrıca "devam eden" katsayısı 0,75.
        'K.2' => ['baslik' => 'Horizon Europe veya uluslararası destek programı projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 262],
        'K.2.a' => ['baslik' => 'Horizon Europe veya uluslararası destek programı projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci'], 'puan' => 131],
        'K.2.b' => ['baslik' => 'Horizon Europe veya uluslararası destek programı projesinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['danisman'], 'puan' => 78],
        'K.2.c' => ['baslik' => 'Horizon Europe veya uluslararası destek programı projesinde bursiyerlik', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['bursiyer'], 'puan' => 52],
        'K.3' => ['baslik' => 'TÜSEB veya uluslararası fonlu araştırma projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜSEB', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 225],
        'K.3.a' => ['baslik' => 'TÜSEB veya uluslararası fonlu araştırma projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['TÜSEB', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci'], 'puan' => 112],
        'K.3.b' => ['baslik' => 'TÜSEB veya uluslararası fonlu araştırma projesinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['TÜSEB', 'Diğer Uluslararası Fon'], 'roller' => ['danisman'], 'puan' => 67],
        'K.3.c' => ['baslik' => 'TÜSEB veya uluslararası fonlu araştırma projesinde bursiyerlik', 'kategori' => 'proje', 'kaynaklar' => ['TÜSEB', 'Diğer Uluslararası Fon'], 'roller' => ['bursiyer'], 'puan' => 45],
        'K.4' => ['baslik' => 'Bakanlık, Cumhurbaşkanlığı veya eşdeğer kamu kurumu projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 187],
        'K.4.a' => ['baslik' => 'Bakanlık, Cumhurbaşkanlığı veya eşdeğer kamu kurumu projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['arastirmaci'], 'puan' => 93],
        'K.4.b' => ['baslik' => 'Bakanlık, Cumhurbaşkanlığı veya eşdeğer kamu kurumu projesinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['danisman'], 'puan' => 56],
        'K.4.c' => ['baslik' => 'Bakanlık, Cumhurbaşkanlığı veya eşdeğer kamu kurumu projesinde bursiyerlik', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['bursiyer'], 'puan' => 37],
        'K.9' => ['baslik' => 'TÜBİTAK ARDEB veya TEYDEB projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 112],
        'K.9.a' => ['baslik' => 'TÜBİTAK ARDEB veya TEYDEB projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['arastirmaci'], 'puan' => 56],
        'K.9.b' => ['baslik' => 'TÜBİTAK ARDEB veya TEYDEB projesinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['danisman'], 'puan' => 33],
        'K.9.c' => ['baslik' => 'TÜBİTAK ARDEB veya TEYDEB projesinde bursiyerlik', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['bursiyer'], 'puan' => 22],
        'K.13' => ['baslik' => 'Üniversite-sanayi iş birliği projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 60],
        'K.13.a' => ['baslik' => 'Üniversite-sanayi iş birliği projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci'], 'puan' => 30],
        'K.13.b' => ['baslik' => 'Üniversite-sanayi iş birliği projesinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['danisman'], 'puan' => 18],
        'K.13.c' => ['baslik' => 'Üniversite-sanayi iş birliği projesinde bursiyerlik', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['bursiyer'], 'puan' => 12],
        'K.14' => ['baslik' => 'BAP birimince desteklenen tamamlanmış projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 20],
        'K.14.a' => ['baslik' => 'BAP birimince desteklenen tamamlanmış projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['arastirmaci'], 'puan' => 10],
        'K.14.b' => ['baslik' => 'BAP birimince desteklenen tamamlanmış projede danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['danisman'], 'puan' => 6],
        'K.14.c' => ['baslik' => 'BAP birimince desteklenen tamamlanmış projede bursiyerlik', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['bursiyer'], 'puan' => 4],

        // ══ L. GİRİŞİMCİLİK, TGB, TTO ══ (yalnızca sözlükte karşılığı olan satır)
        'L.18' => ['baslik' => 'Öğrenci destek projelerinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'puan' => 5],

        // ══ M. FİKRİ SINAİ MÜLKİYET HAKLARI ══
        'M.1' => ['baslik' => 'Lisans satışı veya kiralaması gerçekleştirilmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 600],
        'M.2' => ['baslik' => 'Uluslararası veya PCT patent tescili', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 500],
        'M.4' => ['baslik' => 'Ulusal tescillenmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 350],
        'M.8' => ['baslik' => 'Tescillenmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 150],
        'M.9' => ['baslik' => 'Endüstriyel tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım'], 'puan' => 100],
        'M.10' => ['baslik' => 'Yazılım geliştirme', 'kategori' => 'patent', 'kaynaklar' => ['Yazılım'], 'puan' => 100],

        // ══ N. ÖDÜLLER ══
        'N.1' => ['baslik' => 'YÖK, TÜBİTAK veya TÜBA Bilim Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'YÖK Ödülü'], 'puan' => 400],
        'N.2' => ['baslik' => 'YÖK, TÜBİTAK veya TÜBA Teşvik Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 200],
        'N.3' => ['baslik' => 'Yurt dışı ödül', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 100],
        'N.4' => ['baslik' => 'Doktora sonrası araştırma bursu', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 50],
        'N.6' => ['baslik' => 'Kongrelerde ilk üç dereceye giren araştırma veya sunum', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 20],
        'N.8' => ['baslik' => 'Diğer bilimsel ödüller', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 10],

        // ══ O. GÜZEL SANATLAR İLE İLGİLİ FAALİYETLER ══
        'O.1.c' => ['baslik' => 'Uluslararası karma sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)'], 'puan' => 20],
        'O.2.a' => ['baslik' => 'Yurt dışı bireysel sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)'], 'puan' => 40],
        'O.3.a' => ['baslik' => 'Yurt içi bireysel sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)'], 'puan' => 30],
        'O.3.e' => ['baslik' => 'Yurt içi karma sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)'], 'puan' => 10],
        'O.4.d' => ['baslik' => 'Özgün müzik eseri veya tasarım', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım'], 'puan' => 20],
        'O.6.a' => ['baslik' => 'Uluslararası sanatsal ödül', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], 'puan' => 40],
        'O.6.d' => ['baslik' => 'Ulusal sanatsal ödül', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 10],
        'O.7.a' => ['baslik' => 'Orkestra, opera veya balede solist olarak yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Solistlik (Uluslararası)', 'Solistlik (Ulusal)'], 'puan' => 20],
        'O.7.c' => ['baslik' => 'Audio yayını veya albüm', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)'], 'puan' => 20],
        'O.7.f' => ['baslik' => 'Orkestra, opera korosu veya balede topluluk üyesi olarak yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra / Koro Üyeliği', 'Karma Albüm / CD-DVD Katkısı'], 'puan' => 10],

        // ══ R. İDARİ GÖREV, DANIŞMANLIK, KOMİSYON VE KURUL ÜYELİĞİ ══
        'R.1' => ['baslik' => 'Rektörlük veya rektör yardımcılığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı'], 'puan' => 50],
        'R.2' => ['baslik' => 'Dekanlık, yüksekokul/enstitü müdürlüğü, yardımcılıkları ve başhekimlik (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü', 'Dekan Yrd. / Müdür Yrd.'], 'puan' => 40],
        // R.4 BAŞKANLIK satırı; bölüm başkan YARDIMCILIĞI için kaynakta karşılık
        // yok, satırdan çıkarıldı. 'Anabilim Dalı Başkanı / Koordinatörlük'
        // etiketi anabilim dalı başkanlığını (R.4, 30) koordinatörlükle (R.5,
        // 20) birleştiriyor; §0 uyarınca R.5'e alındı (01.09.2026).
        'R.4' => ['baslik' => 'Anabilim dalı, bölüm, program başkanlığı veya merkez müdürlüğü (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 30],
        'R.5' => ['baslik' => 'Dekanlık veya müdürlükçe oluşturulan komisyon ve kurullarda görev (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 20],
        'R.6' => ['baslik' => 'Kamu veya özel sektörde danışmanlık ve eğiticilik', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı'], 'puan' => 10],

        // ══ T. TOPLUMSAL KATKI ══ (bölüm tavanı 200 puan)
        'T.2' => ['baslik' => 'Toplumsal katkı çalışmasında görev almak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 10],
    ],

    'gruplar' => [
        // Koşulların adıyla andığı kümeler. NOKTA ZORUNLU: 'A.1*' deseni
        // 'A.10' olsaydı onu da yakalardı; 'K.1*' ise K.13 ve K.14'ü yakalar,
        // o yüzden proje grupları tek tek sayıldı.
        'A' => ['A.*'],
        'Q1-Q3' => ['A.1.a', 'A.1.a.d1', 'A.1.a.d10', 'A.1.b', 'A.1.c'],
        'SCI-E' => ['A.1.a', 'A.1.a.d1', 'A.1.a.d10', 'A.1.b', 'A.1.c', 'A.1.d'],
        'ESCI' => ['A.2'],
        'TR-DIZIN' => ['A.3'],
        'BKCI-KITAP' => ['C.1.a'],

        // K1-K12: BAP ÜSİP (K.13) ve BAP (K.14) hariç bütün proje satırları.
        'K1-K12' => ['K.2', 'K.2.a', 'K.2.b', 'K.2.c', 'K.3', 'K.3.a', 'K.3.b', 'K.3.c',
            'K.4', 'K.4.a', 'K.4.b', 'K.4.c', 'K.9', 'K.9.a', 'K.9.b', 'K.9.c'],
        'K1-K14' => ['K.2', 'K.2.a', 'K.2.b', 'K.2.c', 'K.3', 'K.3.a', 'K.3.b', 'K.3.c',
            'K.4', 'K.4.a', 'K.4.b', 'K.4.c', 'K.9', 'K.9.a', 'K.9.b', 'K.9.c',
            'K.13', 'K.13.a', 'K.13.b', 'K.13.c', 'K.14', 'K.14.a', 'K.14.b', 'K.14.c'],
        // "Dış kaynaklı proje (K1-K10) yürütücülüğü" — yalnızca yürütücü kodları.
        'K1-K10-YURUTUCU' => ['K.2', 'K.3', 'K.4', 'K.9'],

        // "Patent (M1-M5) sayısı" — M.3 (uluslararası başvuru) ve M.5 (telif
        // tescili) kaynak sözlüğünde karşılıksız olduğu için kümede yok.
        'M1-M5' => ['M.1', 'M.2', 'M.4'],

        'DERS' => ['İ.4'],
        'TOPLUMSAL-KATKI' => ['T.2'],
    ],

    'grup_tavanlari' => [
        // Yönergenin kendi dipnotları.
        'DERS' => 200,
        'TOPLUMSAL-KATKI' => 200,
    ],
];
