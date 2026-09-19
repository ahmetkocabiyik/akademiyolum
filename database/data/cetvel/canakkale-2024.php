<?php

/**
 * ÇANAKKALE ONSEKİZ MART ÜNİVERSİTESİ — Tablo-2: Değerlendirmede Dikkate
 * Alınacak Faaliyetlerin Türü ve Puanlama Tablosu
 * Kaynak: pdf/17536992142.canakkaleonsekizmartuniversitesi.pdf (20 sayfa,
 * yürürlük 01.01.2024; Madde 10 uyarınca bir kısım fıkra 01.01.2025'ten
 * itibaren geçerli — bugünkü tarih itibarıyla 2025 değerleri uygulanır)
 *
 * MADDE KODLARI YÖNERGENİN KENDİSİ: Tablo-2'nin bölüm numarası + bendi
 * (`1.a`, `3.ı`, `10.a1`). Bize ait olan tek şey çeyrekliğe ve
 * uluslararası/ulusal ayrımına göre bölünen satırların ekleri (`1.a-Q1`)
 * ile birleştirilen satırların tire ile yazılmış çift kodları (`2.a-2.d`).
 *
 * ── KOŞULLAR BU CETVELİN BÖLÜM NUMARALARINA ATIF YAPIYOR ──
 * Madde 6-9'un yayın şartları "1(a), 1(d) veya 1(f) maddelerinden en az
 * dört yayın" gibi doğrudan Tablo-2'nin ALT BENTLERİNE atıf yapıyor; %65
 * kuralı ile doçentlik/profesörlük puan barajları ise "Tablo 2'de yer alan
 * 1-5 maddeleri" kümesine. Bu yüzden madde kodları birebir korundu ve
 * `gruplar` altında hem tek bentler (`1.a`, `1.d`, `1.f`) hem 1-5 kümesi
 * tanımlandı.
 *
 * ── AYNI KAYNAĞA DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   1.a/1.b/1.c'nin AHCI satırı: AHCI dergilerinin çeyrekliği kayıtta yok,
 *       her üç türde de EN DÜŞÜK çeyreklik değeri alındı (90 / 70 / 50).
 *   2.a/2.d davetli konuşmacılık (uluslararası 45 / ulusal 35): tek
 *       'Davetli Konuşmacı' etiketi → 35.
 *   2.b'nin özet dalı (20), 2.c poster (25/10): tek 'Uluslararası
 *       Özet/Poster' etiketi → 10. Aynı şekilde 2.e özet (15) ile 2.f
 *       (20/8) → 8.
 *   3.d ulusal kitap (100) ile 3.ı/3.i ders kitabı (100/80): 'Ders / Metot
 *       Kitabı' etiketi → 80.
 *   4.a WoS atıf (10) ile 4.b ESCI-Scopus atıf (6): tek 'WoS / Scopus'
 *       etiketi → 6.
 *   6.e/6.f tez izleme ve jüri üyeliği (2 / 1) → 1.
 *   7.b WoS hakemliği (25-10), 7.d diğer dergi hakemliği (10), 7.e/7.f/7.g
 *       proje hakemliği (20/15/10): tek 'Hakemlik' etiketi → 10.
 *   7.h/7.ı sanat hakemliği (20/10) ile 7.i/7.j sanat jüri üyeliği (15/10):
 *       'Jüri Başkanlığı/Üyeliği' çiftleri → 15 / 10.
 *   8.d/8.e etkinlik ödülü (20 / 15): tek 'Yarışma Derecesi / Mansiyon'
 *       etiketi → 15.
 *   9. bölüm notu "faydalı model veya tasarımdan puanın %50'si alınır":
 *       uluslararası 50, ulusal 30; kayıt ikisini ayıramadığı için tek
 *       satırda 30.
 *   13.p/13.r/13.s yayın kurulu üyeliği (8 / 4 / 2) → 2.
 *   13.d-13.h toplantı düzenleme görevleri (25 ile 10 arası): `Diger`
 *       kategorisinin tek 'Diğer' etiketi → 10.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   1.f'nin derleme ve kısa yazı türleri — Tablo-2 yalnızca özgün araştırma
 *       makalesini fiyatlandırıyor.
 *   Madde 4/i'nin tanımladığı "ulusal hakemli dergi" — Tablo-2 yalnızca
 *       ULAKBİM taranan dergileri fiyatlandırıyor; ULAKBİM dışı ulusal
 *       hakemli dergide yayını olan aday o kalemden puan almaz.
 *   11. ve 12. bölümün (Devlet Konservatuvarı ve Güzel Sanatlar
 *       etkinlikleri) çoğu bendi — sözlükteki sanat etiketleri 10. bölümde
 *       kullanıldı; ikisi aynı kayıt türlerine düştüğü için 11-12'nin ayrı
 *       satırları açılamadı. Metot çalışması, albüm, radyo-TV programı ve
 *       öğrenci ödülü kalemleri karşılıksız.
 *   13.a/13.b (yabancı dil sınav puanı) — profil özelliği, faaliyet değil.
 *   13.t/13.u dışındaki teknopark ve girişimcilik kalemleri.
 *   Türkçe verilen dersler — Tablo-2 yalnızca YABANCI DİLDE verilen dersi
 *       (13.m) fiyatlandırıyor.
 *
 * ── UYGULANAN TAVANLAR ──
 * 6. bölüm (tez danışmanlığı ve jüri) 50; 13.k yöneticilik 100 ve kurul
 * üyeliği 50; 13.m yabancı dilde ders 10 — hepsi kendi dipnotlarından.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   13.k idari görev puanı YIL BAŞINA (30 ve 10); yıl biriktirmesi motorda
 *       yok, görev başına tek yıl değeri girildi. Grup tavanları yine de
 *       yazıldı, çünkü dipnotta sabit puan olarak veriliyorlar.
 *   7.a "en fazla iki adet", 7.b "en fazla on adet" gibi ADET tavanları:
 *       satır puanı çeyrekliğe göre değiştiği için puana çevrilemedi
 *       (KONVANSIYONLAR'ın "sabit puanlı satırda çevrilebilir" istisnası
 *       burada geçerli değil). Puan bu kalemlerde YÜKSEK görünebilir.
 *   2. bölüm notu "aynı toplantıda sunulan çoklu bildirilerden yalnızca
 *       ikisi puanlanır" — eser bazlı tavan, motorda yok.
 *
 * Yönerge: yonerge/canakkale.php
 *
 * TANINMIŞ YAYINEVİ AYRIMI KAPSAM ETİKETİNE BAĞLANDI (19.09.2026): kaynak
 * kitabı, bölümü ve editörlüğü "ULUSLARARASI TANINIRLIĞI OLAN yayınevi" ↔ "ULUSAL
 * TANINIRLIĞI OLAN yayınevi" diye ayırıyor; sıfat İKİ KADEMEDE DE aynı, ayrımı yapan tek
 * şey yayınevinin kapsamı. Üst satırlar yalnız BKCI/Scopus etiketiyle
 * yazıldığı için adayın indekssiz uluslararası kitabı ULUSAL satırdan
 * sayılıyordu. Kapsamlı etiketler bağlandı, ulusal satırlar daraltıldı.
 */

return [
    'kapsam_notu' => 'Puanlar Çanakkale Onsekiz Mart Üniversitesi Tablo-2 puanlama tablosundan. '
        .'Yazar çarpanı Tablo-1\'in isim sırası × yazar sayısı matrisine göre işliyor (tek yazar '
        .'1,00; altı yazarlıda 0,25, yedi ve üzerinde 0,20). Yazar listesini boş bırakırsanız '
        .'çarpan hiç uygulanmaz ve puanınız olduğundan YÜKSEK görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: AHCI dergilerindeki yayınlar '
        .'çeyreklik bilgisi olmadığı için en düşük çeyreklikten sayılıyor; WoS atıfları '
        .'ESCI-Scopus atıflarıyla, bütün hakemlik türleri tek satırda, davetli konuşmacılık ve '
        .'poster bildiriler düşük olan değerle birleşti; ULAKBİM dışı ulusal hakemli dergi '
        .'yayınları, Türkçe verilen dersler, konservatuvar ve güzel sanatlar bölümlerinin metot '
        .'çalışması, albüm ve radyo-TV kalemleri girilemedi; idari görevlerin yıl biriktirmesi '
        .'uygulanmıyor. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünebilir: editörlük "en fazla iki adet", '
        .'hakemlik "en fazla on adet" gibi adet tavanları uygulanamıyor; aynı toplantıda '
        .'sunulan bildirilerden yalnızca ikisinin sayılması kuralı da işlemiyor.'
        .' KİTAPTA "TANINMIŞ YAYINEVİ" KOŞULU DENETLENMİYOR: uluslararası yayınevi kitabınız yönergenin tanınmış uluslararası yayınevi satırından sayılıyor. Yayıneviniz yönergenin tanımına (faaliyet süresi, kütüphane kataloglaması, kitap sayısı) girmiyorsa puanınız olduğundan YÜKSEK görünür; başvurunuzda yayınevini belgeleyin.',

    // Tablo-1: ortak çalışmalar için puan dağılımı.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev',
            'odul', 'editorluk', 'toplumsal_katki'],
        'roller' => (function (): array {
            $ilk = ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.80, 4 => 0.70, 5 => 0.60, 6 => 0.25], 'sonrasi' => 0.20];

            return [
                'tek' => ['kademeler' => [1 => 1.0]],
                'ilk' => $ilk,
                'baslica' => $ilk,
                'yazar_2' => ['kademeler' => [2 => 0.80, 3 => 0.70, 4 => 0.60, 5 => 0.50, 6 => 0.25], 'sonrasi' => 0.20],
                'yazar_3' => ['kademeler' => [3 => 0.60, 4 => 0.50, 5 => 0.40, 6 => 0.25], 'sonrasi' => 0.20],
                'yazar_4' => ['kademeler' => [4 => 0.40, 5 => 0.30, 6 => 0.25], 'sonrasi' => 0.20],
                'yazar_5' => ['kademeler' => [5 => 0.30, 6 => 0.25], 'sonrasi' => 0.20],
                'yazar_6' => ['kademeler' => [6 => 0.25], 'sonrasi' => 0.20],
                'ortak' => ['kademeler' => [1 => 1.00, 2 => 0.80, 3 => 0.60, 4 => 0.40, 5 => 0.30, 6 => 0.25], 'sonrasi' => 0.20],
            ];
        })(),
    ],

    'maddeler' => [
        // ══ 1. MAKALE ══
        '1.a-Q1' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI Q1 dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale'], 'puan' => 125],
        '1.a-Q2' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI Q2 dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale'], 'puan' => 110],
        '1.a-Q3' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI Q3 dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale'], 'puan' => 100],
        '1.a-Q4' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI Q4 dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 90],
        '1.b-Q1' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI Q1 dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['derleme'], 'puan' => 100],
        '1.b-Q2' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI Q2 dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['derleme'], 'puan' => 90],
        '1.b-Q3' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI Q3 dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['derleme'], 'puan' => 80],
        '1.b-Q4' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI Q4 dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme'], 'puan' => 70],
        '1.c-Q1' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI Q1 dergide editöre mektup, olgu sunumu, teknik not veya yorum', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 80],
        '1.c-Q2' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI Q2 dergide editöre mektup, olgu sunumu, teknik not veya yorum', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 70],
        '1.c-Q3' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI Q3 dergide editöre mektup, olgu sunumu, teknik not veya yorum', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 60],
        '1.c-Q4' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI Q4 dergide editöre mektup, olgu sunumu, teknik not veya yorum', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 50],
        '1.d' => ['baslik' => 'ESCI, Scopus gibi diğer uluslararası alan indekslerince taranan dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale'], 'puan' => 70],
        '1.e' => ['baslik' => 'ESCI, Scopus gibi diğer uluslararası alan indekslerince taranan dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['derleme'], 'puan' => 70],
        '1.f' => ['baslik' => 'Diğer uluslararası dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale'], 'puan' => 65],
        '1.g' => ['baslik' => 'ESCI, Scopus gibi diğer uluslararası alan indekslerince taranan dergide editöre mektup, olgu sunumu, teknik not veya yorum', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 35],
        '1.h1' => ['baslik' => 'ULAKBİM tarafından taranan ulusal dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 60],
        '1.h2' => ['baslik' => 'ULAKBİM tarafından taranan ulusal dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['derleme'], 'puan' => 50],
        '1.h3' => ['baslik' => 'ULAKBİM tarafından taranan ulusal dergide editöre mektup, olgu sunumu, teknik not veya yorum', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 30],

        // ══ 2. BİLİMSEL TOPLANTI ══
        '2.a-2.d' => ['baslik' => 'Bilimsel toplantıda davetli konuşmacı olarak sunulan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 35],
        '2.b' => ['baslik' => 'Uluslararası bilimsel toplantıda sözlü sunulan ve tam metin yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Uluslararası Tam Metin (CPCI)'], 'puan' => 40],
        '2.c' => ['baslik' => 'Uluslararası bilimsel toplantıda özet olarak yayımlanan ya da poster olarak sunulan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 10],
        '2.e' => ['baslik' => 'Ulusal bilimsel toplantıda sözlü sunulan ve tam metin yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 30],
        '2.f' => ['baslik' => 'Ulusal bilimsel toplantıda özet olarak yayımlanan ya da poster olarak sunulan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 8],

        // ══ 3. KİTAP ══
        '3.a' => ['baslik' => 'Uluslararası tanınırlığı olan yayınevince yayımlanan bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası Kitap'], 'puan' => 150],
        '3.b' => ['baslik' => 'Uluslararası tanınırlığı olan yayınevince yayımlanan bilimsel kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Uluslararası Kitap Bölümü'], 'puan' => 100],
        '3.c' => ['baslik' => 'Uluslararası tanınırlığı olan yayınevince yayımlanan bilimsel kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Uluslararası Kitap Editörlüğü'], 'puan' => 100],
        '3.d' => ['baslik' => 'Ulusal tanınırlığı olan yayınevince yayımlanan bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 100],
        '3.e' => ['baslik' => 'Ulusal tanınırlığı olan yayınevince yayımlanan bilimsel kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 40],
        '3.f' => ['baslik' => 'Ulusal tanınırlığı olan yayınevince yayımlanan bilimsel kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü', 'Ulusal Kitap Editörlüğü'], 'puan' => 60],
        '3.g' => ['baslik' => 'Yabancı dilde yayımlanan bilimsel kitap çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 30],
        '3.h' => ['baslik' => 'Yabancı dilde yayımlanan bilimsel kitap bölümü çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 15],
        '3.i' => ['baslik' => 'Alanında yayımlanan ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 80],

        // ══ 4. ATIF ══
        '4.a-4.b' => ['baslik' => 'SCI, SCI-Expanded, SSCI, AHCI, ESCI veya Scopus dergilerinde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 6],
        '4.c' => ['baslik' => 'Diğer uluslararası dergilerde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer (Uluslararası)'], 'puan' => 5],
        '4.ç' => ['baslik' => 'ULAKBİM tarafından taranan ulusal dergilerde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 4],
        '4.d' => ['baslik' => 'Kitaplarda yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 7],
        '4.e' => ['baslik' => 'İncelemeli patent atıfları', 'kategori' => 'atif', 'kaynaklar' => ['Patent'], 'puan' => 5],

        // ══ 5. BİLİMSEL ARAŞTIRMA PROJESİ ══
        '5.a1-a2' => ['baslik' => 'Uluslararası kuruluşça desteklenen araştırma projesinde koordinatör ya da yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 200],
        '5.a3' => ['baslik' => 'Uluslararası kuruluşça desteklenen araştırma projesinde araştırıcı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 140],
        '5.a4' => ['baslik' => 'Uluslararası kuruluşça desteklenen araştırma projesinde danışman', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['danisman'], 'puan' => 120],
        '5.b1' => ['baslik' => 'TÜBİTAK, TÜBA, bakanlık veya eşdeğer üniversite dışı kurumca desteklenen projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 140],
        '5.b2' => ['baslik' => 'TÜBİTAK, TÜBA, bakanlık veya eşdeğer üniversite dışı kurumca desteklenen projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci'], 'puan' => 120],
        '5.b3-b4' => ['baslik' => 'TÜBİTAK, TÜBA, bakanlık veya eşdeğer üniversite dışı kurumca desteklenen projede danışman ya da bursiyer', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 100],
        '5.c1' => ['baslik' => 'Üniversiteler dışındaki özel kurum ve kuruluşlarca desteklenen projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 80],
        '5.c2' => ['baslik' => 'Üniversiteler dışındaki özel kurum ve kuruluşlarca desteklenen projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 40],
        '5.d1' => ['baslik' => 'Üniversite BAP birimince desteklenen araştırma projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 40],
        '5.d2' => ['baslik' => 'Üniversite BAP birimince desteklenen araştırma projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman'], 'puan' => 20],
        '5.d3' => ['baslik' => 'Üniversite BAP birimince desteklenen araştırma projesinde bursiyer', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['bursiyer'], 'puan' => 10],

        // ══ 6. TEZ DANIŞMANLIĞI VE JÜRİ ÜYELİĞİ (grup tavanı 50) ══
        '6.a' => ['baslik' => 'Tamamlanmış doktora, uzmanlık veya sanatta yeterlik tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 10],
        '6.b' => ['baslik' => 'Tamamlanmış doktora, uzmanlık veya sanatta yeterlik tez eş danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 5],
        '6.c' => ['baslik' => 'Tamamlanmış yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 5],
        '6.d' => ['baslik' => 'Tamamlanmış yüksek lisans tez eş danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 2],
        '6.e-6.f' => ['baslik' => 'Tez izleme komitesi üyeliği veya lisansüstü tez jürisi üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 1],

        // ══ 7. DERGİ EDİTÖRLÜĞÜ VE HAKEMLİK ══
        '7.a-Q1' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI Q1 dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)'], 'puan' => 150],
        '7.a-Q2' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI Q2 dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q2)'], 'puan' => 130],
        '7.a-Q3' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI Q3 dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q3)'], 'puan' => 110],
        '7.a-Q4' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI Q4 dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q4)'], 'puan' => 100],
        '7.c' => ['baslik' => 'ESCI, Scopus veya ULAKBİM tarafından taranan dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi', 'TR Dizin Dergi'], 'puan' => 90],
        '7.ç' => ['baslik' => 'Diğer uluslararası dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi (Uluslararası)'], 'puan' => 50],
        '7.b-7.g' => ['baslik' => 'Dergi veya proje hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 10],
        '7.h-7.i' => ['baslik' => 'Uluslararası sanat ve tasarım etkinliklerinde hakemlik veya jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], 'puan' => 15],
        '7.ı-7.j' => ['baslik' => 'Ulusal sanat ve tasarım etkinliklerinde hakemlik veya jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 10],

        // ══ 8. ÖDÜL ══
        '8.a' => ['baslik' => 'TÜBA veya TÜBİTAK\'tan alınan bilim ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 250],
        '8.b' => ['baslik' => 'Uluslararası tanınırlığı olan bilim veya sanat kurumunca verilen bilim, sanat, tasarım ya da araştırma ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 350],
        '8.c' => ['baslik' => 'Ulusal tanınırlığı olan bilim veya sanat kurumunca verilen bilim, sanat, tasarım ya da araştırma ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'YÖK Ödülü'], 'puan' => 150],
        '8.d-8.e' => ['baslik' => 'Kongre, sempozyum, yarışma veya festival gibi etkinliklerin bilim/sanat kurulunca verilen ödül', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 15],

        // ══ 9. PATENT ══
        '9.a' => ['baslik' => 'Alanınızda uluslararası tescillenmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 100],
        '9.b' => ['baslik' => 'Alanınızda ulusal tescillenmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 60],
        '9-faydali-model' => ['baslik' => 'Tescillenmiş faydalı model veya tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili', 'Yazılım'], 'puan' => 30],

        // ══ 10. DİSİPLİNLERE ÖZGÜ ETKİNLİKLER ══
        '10.a1-uluslararasi' => ['baslik' => 'Özgün sanat eseri veya tasarımın uluslararası kişisel sanat/tasarım etkinliğinde yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)'], 'puan' => 100],
        '10.a1-ulusal' => ['baslik' => 'Özgün sanat eseri veya tasarımın ulusal kişisel sanat/tasarım etkinliğinde yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 70],
        '10.a2-uluslararasi' => ['baslik' => 'Özgün sanat eseri veya tasarımın uluslararası karma sanat/tasarım etkinliğinde yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Karma Sergi (Uluslararası)'], 'puan' => 50],
        '10.a2-ulusal' => ['baslik' => 'Özgün sanat eseri veya tasarımın ulusal karma sanat/tasarım etkinliğinde yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 25],
        '10.b-uluslararasi' => ['baslik' => 'Özgün sanat eserinin yurt dışında koleksiyona girmesi, satın alınması ya da yayın organlarında yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Yayında Yer Alması / Satın Alınması', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)'], 'puan' => 80],
        '10.b-ulusal' => ['baslik' => 'Özgün sanat eserinin yurt içinde koleksiyona girmesi, satın alınması ya da yayın organlarında yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Satın Alınması (Yurt İçi)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'], 'puan' => 40],
        '10.f-uluslararasi' => ['baslik' => 'Uluslararası sergi, bienal, festival, çalıştay veya uygulamalı sempozyuma eserle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 70],
        '10.f-ulusal' => ['baslik' => 'Ulusal sergi, bienal, festival, çalıştay veya uygulamalı sempozyuma eserle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 30],
        '10.g' => ['baslik' => 'Sahne tasarımı ile ilgili etkinlikler', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne Tasarımı (Dekor, Kostüm, Işık)', 'Koreografi'], 'puan' => 40],
        '10.h-uluslararasi' => ['baslik' => 'Uluslararası gösteri, organizasyon veya görsel-işitsel tasarımda yaratıcı kadroda yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Dansçı / Performans İcracısı (Uluslararası)', 'Rejisörlük (Uluslararası)', 'Rejisör Yardımcılığı (Uluslararası)'], 'puan' => 80],
        '10.h-ulusal' => ['baslik' => 'Ulusal gösteri, organizasyon veya görsel-işitsel tasarımda yaratıcı kadroda yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Dansçı / Performans İcracısı (Ulusal)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Rejisör Yardımcılığı (Ulusal)', 'Rejisör Yardımcılığı (Konservatuvar)'], 'puan' => 40],
        '10.i' => ['baslik' => 'Uzun metrajlı sinema filmi yönetmenliği veya yapımcılığı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Yönetmenlik (Sahne/Ekran)'], 'puan' => 40],
        '10.k-uluslararasi' => ['baslik' => 'Uluslararası kısa film, belgesel veya animasyon yönetmenliği ya da yaratıcı kadroda görev', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Uluslararası)'], 'puan' => 60],
        '10.k-ulusal' => ['baslik' => 'Ulusal kısa film, belgesel veya animasyon yönetmenliği ya da yaratıcı kadroda görev', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Ulusal)'], 'puan' => 30],
        '10-ozgun-eser' => ['baslik' => 'Özgün sanat eseri, beste veya tasarım', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım', 'Albüm / Konser Kaydı', 'Karma Albüm / CD-DVD Katkısı', 'Bandrollü Kayıt (CD/DVD)'], 'puan' => 25],

        // ══ 13. DİĞER ETKİNLİKLER ══
        '13.c' => ['baslik' => 'Erasmus, Mevlana veya Farabi gibi öğretim elemanı değişim programına katılmak', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Değişim Programı Dersi'], 'puan' => 6],
        '13.m' => ['baslik' => 'Yabancı dilde lisans, lisansüstü veya uzmanlık dersi vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Yabancı Dilde Ders'], 'puan' => 10],
        '13.d-13.h' => ['baslik' => 'Bilimsel toplantı düzenleme kurulunda görev almak ya da bildiri kitabı editörlüğü yapmak', 'kategori' => 'diger', 'kaynaklar' => ['Diğer', 'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 10],
        '13.ı' => ['baslik' => 'Üniversite-toplum veya üniversite-endüstri işbirliği çerçevesinde sosyal sorumluluk çalışmasında görev almak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi'], 'puan' => 4],
        '13.u' => ['baslik' => 'Teknoparklarda veya sanayi kuruluşlarının AR-GE birimlerinde danışmanlık hizmeti', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı'], 'puan' => 6],
        '13.n-13.o' => ['baslik' => 'Sertifikalı bir eğitim kursuna eğitici olarak katılmak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Bilim İletişimi / Popüler Yayın'], 'puan' => 5],
        '13.p-13.s' => ['baslik' => 'Dergi yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 2],
        '13.t' => ['baslik' => 'Teknoparklarda firma sahibi ya da firmanın ortağı olmak', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 10],
        // 13.k: yıl başına 30 puan, en fazla 100; kurul üyeliği yıl başına 10,
        // en fazla 50. Yıl biriktirmesi motorda yok, tek yıl değeri girildi.
        '13.k1' => ['baslik' => 'Üniversite birimlerinde yöneticilik veya yönetici yardımcılığı yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü', 'Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkanı', 'Bölüm Başkan Yardımcısı', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 30],
        '13.k2' => ['baslik' => 'Üniversite birimlerinde kurul, koordinatörlük veya komisyon üyeliği yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük', 'Kurul / Komisyon Üyeliği'], 'puan' => 10],
    ],

    'gruplar' => [
        // Madde 6-9'un yayın şartlarının andığı bentler.
        '1.a' => ['1.a-Q1', '1.a-Q2', '1.a-Q3', '1.a-Q4'],
        '1.d' => ['1.d'],
        '1.f' => ['1.f'],
        '1.a-1.d' => ['1.a-Q1', '1.a-Q2', '1.a-Q3', '1.a-Q4', '1.d'],
        '1.a-1.d-1.f' => ['1.a-Q1', '1.a-Q2', '1.a-Q3', '1.a-Q4', '1.d', '1.f'],
        // "1(a, b, c, d, e, f, g, h)" — 1. bölümün tamamı.
        '1-TUM' => ['1.*'],
        '3-TUM' => ['3.*'],
        // "3(a, b, c, d, e)" ve "3(a, b, c, d, e, f)" kitap bentleri.
        '3.a-3.e' => ['3.a', '3.b', '3.c', '3.d', '3.e'],
        '3.a-3.f' => ['3.a', '3.b', '3.c', '3.d', '3.e', '3.f'],
        // %65 kuralı ve doçentlik/profesörlük puan barajlarının kümesi.
        '1-5' => ['1.*', '2.*', '3.*', '4.*', '5.*'],
        // Güzel sanatlar, iletişim, mimarlık-tasarım ve konservatuvarda
        // kümeye 10. ve 11. bölüm de dâhil (11. bölüm cetvele giremediği
        // için yalnızca 10 eklendi).
        '1-5-10' => ['1.*', '2.*', '3.*', '4.*', '5.*', '10.*'],
        // Madde 6/1, 7/3, 8/1-2, 9/4-5: "BAP dışında dış kaynaklı proje".
        'PROJE-DIS' => ['5.a1-a2', '5.a3', '5.a4', '5.b1', '5.b2', '5.b3-b4', '5.c1', '5.c2'],
        'PROJE-TUM' => ['5.*'],
        // Madde 6/10-11 ve 8/11-12: güzel sanatlar kişisel etkinlik ve
        // sempozyum-festival katılımı.
        'SANAT-KISISEL' => ['10.a1-uluslararasi', '10.a1-ulusal'],
        'SANAT-ETKINLIK' => ['10.f-uluslararasi', '10.f-ulusal', '2.b', '2.c', '2.e', '2.f'],
        'TEZ' => ['6.*'],
        'IDARI-YONETICI' => ['13.k1'],
        'IDARI-KURUL' => ['13.k2'],
        'YABANCI-DIL-DERS' => ['13.m'],
    ],

    'grup_tavanlari' => [
        'TEZ' => 50,
        'IDARI-YONETICI' => 100,
        'IDARI-KURUL' => 50,
        'YABANCI-DIL-DERS' => 10,
    ],
];
