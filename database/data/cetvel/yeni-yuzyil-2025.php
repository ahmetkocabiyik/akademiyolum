<?php

/**
 * İSTANBUL YENİ YÜZYIL ÜNİVERSİTESİ — Puanlama Ölçütleri
 * Kaynak: pdf/17537101482.istanbulyeniyuzyiluniversitesi.pdf
 * (Senato 15.11.2024 · 2024/07 ve 28.03.2025 · 2025/03; YÖK onayı 30.04.2025)
 *
 * MADDE KODLARI yönergenin kendi bölüm kodunu ve satır numarasını birleştiriyor:
 * tablo bölümleri "1.A", "2.B", "3.C" … diye kodlanmış, satırlar her bölümde
 * 1'den başlıyor. Koşullar bu ikisini bitişik yazıyor ("1.A1-18", "2.B15-31");
 * cetvelde araya nokta konarak '1.A.18' biçiminde ayrıldı.
 *
 * NOKTA ZORUNLU, ARALIKLAR ELLE SAYILDI: satır numaraları 1'den 42'ye gidiyor,
 * yani '1.A.1*' deseni 1.A.10-1.A.19'u da yakalardı. Koşulların andığı her
 * aralık `gruplar` altında tek tek sayıldı; aralık deseni ('..') de
 * kullanılmadı çünkü o cetveldeki SIRAYA bakıyor ve aralığın uç kodu
 * girilemediğinde sessizce boş küme veriyor.
 *
 * ── YAZAR TABLOSU: 1,8p/n, n ALTIDA SABİTLENİYOR ──
 * "Katkıda bulunan tek kişi ise p · iki kişi ise 0,8p · ikiden fazla ise
 * 1,8p/n (n 6'dan fazlaysa n=6 alınır)". Tavanın kendisi motorun `bol`
 * alanında ifade edilemediği için kademeler elle yazıldı:
 *   1 → 1,00 · 2 → 0,80 · 3 → 0,60 · 4 → 0,45 · 5 → 0,36 · 6 ve üzeri → 0,30
 * Düz `bol` (pay 1.8) yazılsaydı yedi yazarlı yayında 0,257 çıkardı; yönerge
 * 0,30 diyor.
 *
 * SORUMLU YAZARA SIRADAN BAĞIMSIZ 0,9: "(2) Çok yazarlı bilimsel makaleler
 * için sorumlu yazara sırasına bakılmaksızın 0.9*(p) puan verilir." `baslica`
 * rolü bu yüzden yazar sayısından bağımsız 0,9 alıyor — korpusta sorumlu
 * yazarın ortak yazardan YÜKSEK pay aldığı ender örneklerden.
 *
 * Tablo yalnızca KİŞİ SAYISINA bakıyor, sıraya değil; bu yüzden `ilk`,
 * `yazar_2` … `ortak` rollerinin hepsi aynı kademeleri paylaşıyor. Yönergenin
 * "(3) eşit katkılı yazar ifadelerine yer verilmiş olsa dahi isim
 * sıralamasına göre değerlendirme yapılır" hükmü de bu yüzden sonucu
 * değiştirmiyor.
 *
 * ── SABİT GRUP TAVANLARI ──
 * Üç tavan motorun tanıdığı biçimde, yani sabit sayı: atıflardan en çok 30,
 * doktora tez danışmanlığından en çok 30, yüksek lisans tez danışmanlığından
 * en çok 25 puan. Tezsiz lisansüstü danışmanlığının 20 puanlık tavanı ise
 * satırı girilemediği için konusuz kaldı.
 *
 * ── AYNI KAYNAĞA DÜŞEN SATIRLARDA DAİMA DÜŞÜĞÜ GİRİLDİ ──
 *   'AHCI' kaynağı çeyreklik taşımıyor; Q1-Q4 satırlarının en düşüğüne
 *       (Q4: 1.A.4 tam makale, 1.A.8 derleme, 1.A.12 kısa makale) yazıldı.
 *   Kitap 1.A.19 WoS/SENSE(A-B) 80 / 1.A.20 SCOPUS-SENSE(C) 60 /
 *       1.A.21 SENSE(D-E) 30: 'BKCI / Scopus Kitap' etiketi WoS ile Scopus'u
 *       ayıramıyor ama SENSE sınıflandırmasını da ima etmiyor → 1.A.20.
 *       Bölüm yazarlığında aynı gerekçeyle 1.A.26.
 *   'Uluslararası/Ulusal Kitap' ve 'Tahkik' yayın yerini söylemiyor →
 *       ulusal satır 1.A.41; 'Kitap Bölümü' → 1.A.42.
 *   Çeviri 1.A.22-24 (40/30/20) ve bölüm çevirisi 1.A.28-30 (20/15/10):
 *       'Çeviri Kitap' ve 'Çeviri Kitap Bölümü' yayınevi kademesini
 *       taşımıyor → 1.A.24 ve 1.A.30. Ulusal çeviri satırı yönergede yok.
 *   Atıf 1.A.36 SCI-SSCI-AHCI (3) / 1.A.37 Scopus-ESCI (2): 'WoS / Scopus'
 *       ikisini ayıramıyor → 1.A.37. ULAKBİM atıflarında 1.A.38-40
 *       (2/2/1) → 1.A.40; 'Diğer' atıf kaynağı da oraya düştü.
 *   Dergi görevi 3.C.3-6 editörlük (20/15/10/7) ile 3.C.10-13 hakemlik
 *       (4/3/2/1) aynı çeyrekliğe bakıyor; 'WoS Dergi (Qn)' kaynağı derginin
 *       düzeyini söylüyor, adayın görevini söylemiyor → hakemlik satırları.
 *       'ESCI / Scopus Dergi' için hakemlik satırı yok, en düşük editörlük
 *       satırı 3.C.9 (4) alındı.
 *   Burs 3.C.14 araştırma (5) / 3.C.15 lisansüstü (3): 'Burs' amacını
 *       taşımıyor → 3.C.15.
 *   Ödül 3.C.21 TÜBA Akademi (15) / 3.C.28 TÜBİTAK Bilim (15) / 3.C.31
 *       TÜBİTAK Teşvik (12): 'TÜBİTAK / TÜBA Ödülü' hangisi olduğunu
 *       söylemiyor → 3.C.31. 'YÖK Ödülü' için 3.C.16 (15) ile 3.C.17-20 (12)
 *       arasında aynı belirsizlik → 3.C.17.
 *
 * ── ESER İLE ETKİNLİK AYRIMI KORUNDU ──
 * Tabloda sanat kalemleri iki bölüme dağılmış ve puanları çok farklı:
 * 2.B.15 "sergi, bienal, gösteri, dinleti türünde ÖZGÜN ESER" 25 puan;
 * 5.E.21 "özgün yapıtlarla KİŞİSEL SERGİ VEYA GÖSTERİ GERÇEKLEŞTİRMEK"
 * 5 puan. İkisi aynı şey değil — biri eserin kendisi, öteki eserle yapılan
 * etkinlik. Kaynak sözlüğü de ikisini ayırıyor ('Özgün Eser / Beste /
 * Tasarım' ↔ 'Kişisel Etkinlik …'), bu yüzden düşük satıra toplama kuralı
 * burada uygulanmadı; her kaynak kendi karşılığına yazıldı. Aynı ayrım jürili
 * kabul (2.B.18, 15) ile jürisiz karma katılım (5.E.22, 3) arasında da var.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   4.D SPORTİF KARİYER BÖLÜMÜNÜN TAMAMI (milli sporcu belgesi, antrenör
 *       belgeleri): kaynak sözlüğünde karşılığı yok. Spor Bilimleri adayının
 *       puanı DÜŞÜK çıkar.
 *   1.A.18 SPORT Discus makalesi — 'Diğer Uluslararası İndeks' zaten 1.A.16
 *       ve 1.A.17'ye düşüyor, ayrı bir kaynak yok.
 *   1.A.32 dışındaki bildiriler: satır yalnızca "uluslararası bilimsel
 *       indekslerce taranan bildiri kitaplarında yer alan" bildiriyi
 *       sayıyor, bu yüzden yalnızca 'Uluslararası Tam Metin (CPCI)' girildi.
 *       İndekslenmemiş uluslararası bildiriler, bütün ulusal bildiriler ve
 *       davetli konuşmacılık puan almıyor.
 *   1.A.35 diğer uluslararası kitapta atıf — puanı 0,5; motor tam sayı
 *       tutuyor, aşağı yuvarlanınca 0 ediyordu. Aynı sebeple 5.E.14 (kısa
 *       oyunda rejisör yardımcılığı) ve 5.E.5 (eğitim amaçlı TV programı).
 *   2.B.2 lisans anlaşmalı patent ve 2.B.4 / 2.B.7 lisans anlaşmalı tasarım:
 *       kayıt lisans anlaşmasını tutmuyor; 'Ticarileştirme' ulusal patent
 *       satırına (2.B.5) yazıldı, 'Endüstriyel Tasarım' en düşük tasarım
 *       satırına (2.B.7).
 *   2.B.22 / 2.B.23 mimari projede ortak müellif ve yürütücü, 2.B.28-31
 *       grafik tasarım kalemleri, 2.B.16 sahne oyunu metni, 2.B.20 sinema ve
 *       tiyatroda görev almak.
 *   5.E'nin kongre organizasyonu (1-2), kurum dergisi görevleri (3-6),
 *       sahne sanatları performans blokları (7-20), küratörlük (23) ve
 *       festival düzenleyiciliği (24-25) satırları.
 *   6.F'nin tez danışmanlığı dışındaki tamamı: klinik ve saha eğitimi saat
 *       bazlı, sertifikalı kurs 0,2 puan/saat, öğrenci kulübü danışmanlığı
 *       sözlükte karşılıksız. DERS VERMEK İÇİN PUAN SATIRI HİÇ YOK —
 *       lisans, ön lisans ve lisansüstü dersleriniz toplama girmiyor.
 *   6.F.2 / 6.F.3 ve 6.F.5 / 6.F.6 asıl ve eş danışmanlık: kayıt danışmanlık
 *       türünü tutmuyor, tek danışman satırı kullanıldı.
 *   'Yazılım', 'Islahçı Hakkı / Çeşit Tescili', 'Uluslararası Bilim/Sanat
 *       Ödülü', 'Ulusal Bilim/Sanat Ödülü', 'Kitap Editörlüğü', 'BKCI Kitap'
 *       (kitap editörlüğü), 'TR Dizin Dergi', 'Diğer Hakemli Dergi',
 *       'Hakemlik', 'Tez İzleme / Jüri Üyeliği', 'Topluma Hizmet Projesi',
 *       'Bilim İletişimi / Popüler Yayın', 'Kamu/STK Danışmanlığı' — tabloda
 *       karşılık satırı YOK. Yönerge ulusal dergi editörlüğü ve hakemliğini,
 *       kitap editörlüğünü ve toplumsal katkıyı hiç puanlamıyor.
 *
 * ── YÖNETİMSEL PUAN HERKESE UYGULANDI ──
 * 7.G bölümünün başlığı puanı "İstanbul Yeni Yüzyıl Üniversitesi akademik
 * kadrosunda olup yükseltilerek veya yeniden atanmalarda" değerlendirmeye
 * bağlıyor. Adayın hangi kurumda görev yaptığı faaliyet kaydından
 * çıkarılamıyor; kısıt uygulanamadı, dışarıdan başvuran adayın idari puanı
 * OLDUĞUNDAN YÜKSEK görünür.
 *
 * Yönerge: yonerge/yeni-yuzyil.php
 */

return [
    'kapsam_notu' => 'Puanlar İstanbul Yeni Yüzyıl Üniversitesi Puanlama Ölçütleri tablosundan '
        .'(YÖK onayı 30.04.2025). Çok yazarlı çalışmalarda yönergenin tablosu uygulanır: tek '
        .'yazarlı tam puan, iki yazarlı %80, üçten fazlasında 1,8 × puan / yazar sayısı — '
        .'yazar sayısı altıdan fazlaysa altı kabul edilir, yani taban çarpan 0,30. Sorumlu '
        .'yazarsanız sıranıza bakılmaksızın puanın %90\'ını alırsınız. Yazar listesini boş '
        .'bırakırsanız çarpan hiç uygulanmaz ve puanınız olduğundan YÜKSEK görünür. '
        .'Atıflardan en çok 30, doktora tez danışmanlığından en çok 30, yüksek lisans tez '
        .'danışmanlığından en çok 25 puan alınabilir. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: sportif kariyer bölümünün tamamı '
        .'(milli sporcu ve antrenör belgeleri) kaynak sözlüğünde karşılıksız — Spor Bilimleri '
        .'adaylarını en çok bu etkiler. BİLDİRİLERDE yalnızca uluslararası indeksli bildiri '
        .'kitabında yer alanlar puan alıyor; indekslenmemiş uluslararası bildiriler, bütün '
        .'ulusal bildiriler ve davetli konuşmacılık sayılmıyor. DERS VERMEK İÇİN PUAN SATIRI '
        .'HİÇ YOK; lisans, ön lisans ve lisansüstü dersleriniz toplama girmiyor. Ulusal dergi '
        .'editörlüğü ve hakemliği, kitap editörlüğü, toplumsal katkı, küratörlük, sahne '
        .'sanatları performansları ve grafik tasarım kalemleri de tabloda satırı olmadığı için '
        .'girilmedi. Yurt dışı ile yurt içi ya da lisans anlaşmalı ile tescilli ayrımını '
        .'taşımayan kalemlerde (kitap, çeviri, atıf, patent, tasarım, burs, ödül) düşük satır '
        .'kullanıldı; dergi görevlerinde kaydınız görevinizi değil derginin çeyrekliğini '
        .'tuttuğu için hakemlik satırı uygulanır. '
        .'Puanınız yalnızca yönetimsel görevlerde OLDUĞUNDAN YÜKSEK çıkabilir: yönerge bu '
        .'puanı sadece bu üniversitenin kendi kadrosundaki adaylara veriyor, kaydınız '
        .'görevin hangi kurumda yapıldığını tutmuyor.',

    // "Tablo 1. Yayın puanının yazar sayısına göre hesaplanması": tek kişi p,
    // iki kişi 0,8p, ikiden fazlası 1,8p/n (n > 6 ise n = 6). Tavanlı bölme
    // motorda yok, kademeler elle yazıldı.
    'yazar_katsayisi' => [
        // Yönergenin kuralı "yayın puanı" başlığı altında. Proje, tez ve
        // sanat projesi satırları paylaşımı zaten rolle ayırıyor (yürütücü /
        // araştırmacı / danışman, danışman / eş danışman, müellif / ekip);
        // atıf, ödül, burs, dergi görevi ve idari görev kişiye veriliyor.
        'haric' => ['atif', 'proje', 'tez_danismanligi', 'editorluk', 'odul',
            'idari_gorev', 'egitim_ogretim', 'toplumsal_katki'],
        'kademeler' => [1 => 1.0, 2 => 0.8, 3 => 0.6, 4 => 0.45, 5 => 0.36, 6 => 0.3],
        'sonrasi' => 0.3,
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.0], 'sonrasi' => 0.3],
            // Tablo yalnızca kişi sayısına bakıyor, sıraya değil.
            'ilk' => ['kademeler' => [1 => 1.0, 2 => 0.8, 3 => 0.6, 4 => 0.45, 5 => 0.36, 6 => 0.3], 'sonrasi' => 0.3],
            'yazar_2' => ['kademeler' => [1 => 1.0, 2 => 0.8, 3 => 0.6, 4 => 0.45, 5 => 0.36, 6 => 0.3], 'sonrasi' => 0.3],
            'yazar_3' => ['kademeler' => [1 => 1.0, 2 => 0.8, 3 => 0.6, 4 => 0.45, 5 => 0.36, 6 => 0.3], 'sonrasi' => 0.3],
            'yazar_4' => ['kademeler' => [1 => 1.0, 2 => 0.8, 3 => 0.6, 4 => 0.45, 5 => 0.36, 6 => 0.3], 'sonrasi' => 0.3],
            'yazar_5' => ['kademeler' => [1 => 1.0, 2 => 0.8, 3 => 0.6, 4 => 0.45, 5 => 0.36, 6 => 0.3], 'sonrasi' => 0.3],
            'yazar_6' => ['kademeler' => [1 => 1.0, 2 => 0.8, 3 => 0.6, 4 => 0.45, 5 => 0.36, 6 => 0.3], 'sonrasi' => 0.3],
            'ortak' => ['kademeler' => [1 => 1.0, 2 => 0.8, 3 => 0.6, 4 => 0.45, 5 => 0.36, 6 => 0.3], 'sonrasi' => 0.3],
            // MADDE (2): sorumlu yazara sırasına bakılmaksızın 0,9p.
            'baslica' => ['kademeler' => [1 => 1.0], 'sonrasi' => 0.9],
        ],
    ],

    'maddeler' => [
        // ══ 1.A YAYINLAR ve ATIFLAR ══
        // 'AHCI' çeyreklik taşımadığı için Q4 satırlarına düştü.
        '1.A.1' => ['baslik' => 'Q1 dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale'], 'puan' => 50],
        '1.A.2' => ['baslik' => 'Q2 dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale'], 'puan' => 40],
        '1.A.3' => ['baslik' => 'Q3 dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale'], 'puan' => 30],
        '1.A.4' => ['baslik' => 'Q4 dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 20],
        '1.A.5' => ['baslik' => 'Q1 dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['derleme'], 'puan' => 30],
        '1.A.6' => ['baslik' => 'Q2 dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['derleme'], 'puan' => 20],
        '1.A.7' => ['baslik' => 'Q3 dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['derleme'], 'puan' => 10],
        '1.A.8' => ['baslik' => 'Q4 dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme'], 'puan' => 8],
        '1.A.9' => ['baslik' => 'Q1 dergide kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 25],
        '1.A.10' => ['baslik' => 'Q2 dergide kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 25],
        '1.A.11' => ['baslik' => 'Q3 dergide kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 15],
        '1.A.12' => ['baslik' => 'Q4 dergide kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 10],
        '1.A.13' => ['baslik' => 'ESCI kapsamındaki dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale'], 'puan' => 15],
        '1.A.14' => ['baslik' => 'ESCI kapsamındaki dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['derleme'], 'puan' => 10],
        '1.A.15' => ['baslik' => 'ESCI kapsamındaki dergide kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 8],
        '1.A.16' => ['baslik' => 'Uluslararası alan indeksli dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale'], 'puan' => 10],
        '1.A.17' => ['baslik' => 'Uluslararası alan indeksli dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['derleme'], 'puan' => 10],
        '1.A.20' => ['baslik' => 'Uluslararası yayınevinde kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 60],
        '1.A.24' => ['baslik' => 'Uluslararası yayınevinde kitap çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 20],
        '1.A.26' => ['baslik' => 'Uluslararası yayınevinde kitap bölümü yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 30],
        '1.A.30' => ['baslik' => 'Uluslararası yayınevinde kitap bölümü çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 10],
        '1.A.31' => ['baslik' => 'TÜBİTAK ULAKBİM TR Dizin dergisinde tam makale ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 10],
        '1.A.32' => ['baslik' => 'Uluslararası indeksli bildiri kitabında yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 10],
        '1.A.33' => ['baslik' => 'Uluslararası patentlerde yayınlarınıza yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Patent'], 'puan' => 10],
        '1.A.34' => ['baslik' => 'WoS taranan kitapta yayınlarınıza yapılan her bir atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 3],
        '1.A.37' => ['baslik' => 'Uluslararası indeksli dergide yayınlarınıza yapılan her bir atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 2],
        '1.A.40' => ['baslik' => 'ULAKBİM taranan dergide yayınlarınıza yapılan her bir atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer'], 'puan' => 1],
        '1.A.41' => ['baslik' => 'Ulusal yayınevinde kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı'], 'puan' => 30],
        '1.A.42' => ['baslik' => 'Ulusal yayınevinde kitap bölümü yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 15],

        // ══ 2.B PATENT, PROJE, SANAT ESERLERİ ve TASARIM ══
        '2.B.1' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 40],
        '2.B.3' => ['baslik' => 'Tescil edilmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 20],
        '2.B.5' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Ticarileştirme'], 'puan' => 15],
        '2.B.7' => ['baslik' => 'Tescil edilmiş tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım'], 'puan' => 18],
        '2.B.8' => ['baslik' => 'Yurt dışı kaynaklı projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 50],
        '2.B.9' => ['baslik' => 'Yurt dışı kaynaklı projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 30],
        '2.B.10' => ['baslik' => 'Yurt dışı kaynaklı projede danışman', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['danisman'], 'puan' => 20],
        '2.B.11' => ['baslik' => 'Kamu ya da özel kurumla yapılan araştırma projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 30],
        '2.B.12' => ['baslik' => 'Kamu ya da özel kurumla yapılan araştırma projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 20],
        '2.B.13' => ['baslik' => 'Kamu ya da özel kurumla yapılan araştırma projesinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['danisman'], 'puan' => 10],
        '2.B.14' => ['baslik' => 'Üniversite araştırma fonu destekli projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'puan' => 5],
        '2.B.15' => ['baslik' => 'Sergi, bienal, gösteri, dinleti ya da festival türünde özgün eser', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım', 'Opera/Bale Kompozisyonu', 'Orkestralı Sahne Eseri', 'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Küçük Ölçekli Orkestra Eseri', 'Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Sahne/Ekran Müziği'], 'puan' => 25],
        '2.B.17' => ['baslik' => 'Koreografi alanında özgün eser', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koreografi', 'Bale/Dans Koreograflığı (Uluslararası)', 'Bale/Dans Koreograflığı (Ulusal)', 'Tüm Perde Koreograflığı (Uluslararası)', 'Tüm Perde Koreograflığı (Ulusal)', 'Bölüm Koreograflığı (Uluslararası)', 'Bölüm Koreograflığı (Ulusal)'], 'puan' => 20],
        '2.B.18' => ['baslik' => 'Seçici kurulu olan etkinliğe yapıtınızın kabul edilmiş olması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)'], 'puan' => 15],
        '2.B.21' => ['baslik' => 'Mimari projenin müellifi olmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif'], 'puan' => 50],
        '2.B.24' => ['baslik' => 'Mimari projenin ekibinde üye olmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman'], 'puan' => 20],
        '2.B.26' => ['baslik' => 'Mimari eser ya da sanat eseri restorasyon tasarımı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)'], 'puan' => 25],

        // ══ 3.C BAŞARILAR ve TANINIRLIK ══
        '3.C.1' => ['baslik' => 'Proje yarışmasından alınan ödül', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 20],
        '3.C.2' => ['baslik' => 'Bilimsel dergilerdeki görevler', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 15],
        '3.C.9' => ['baslik' => 'ESCI ya da alan indeksli dergide editörlük veya hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 4],
        '3.C.10' => ['baslik' => 'Q1 dergide hakemlik ya da editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)'], 'puan' => 4],
        '3.C.11' => ['baslik' => 'Q2 dergide hakemlik ya da editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q2)'], 'puan' => 3],
        '3.C.12' => ['baslik' => 'Q3 dergide hakemlik ya da editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q3)'], 'puan' => 2],
        '3.C.13' => ['baslik' => 'Q4 dergide hakemlik ya da editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q4)'], 'puan' => 1],
        '3.C.15' => ['baslik' => 'Uluslararası kuruluştan alınan üç aydan uzun süreli burs', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 3],
        '3.C.17' => ['baslik' => 'YÖK ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü'], 'puan' => 12],
        '3.C.22' => ['baslik' => 'TÜBA GEBİP ya da TÜBİTAK TWAS Teşvik Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 12],
        '3.C.31' => ['baslik' => 'TÜBİTAK ya da TÜBA ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü'], 'puan' => 12],
        '3.C.32' => ['baslik' => 'TÜBİTAK Ufuk Programı eşik üstü ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ufuk Avrupa / ERC Ödülü'], 'puan' => 8],

        // ══ 5.E BİLİMSEL VE MESLEKİ ETKİNLİKLER ══
        // 2.B.15 eserin kendisini, 5.E.21 eserle yapılan etkinliği puanlıyor.
        '5.E.21' => ['baslik' => 'Özgün yapıtlarınızla kişisel sergi ya da gösteri gerçekleştirmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Elektronik Kişisel Sergi (Ulusal)', 'Solistlik (Uluslararası)', 'Solistlik (Ulusal)', 'Resital (Uluslararası)', 'Resital (Ulusal)', 'Şan Resitali (Uluslararası)', 'Şan Resitali (Ulusal)'], 'puan' => 5],
        '5.E.22' => ['baslik' => 'Özgün çalışmalarınızla karma sanat etkinliğine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Jürisiz, Ulusal)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Karma Sergi (Uluslararası)', 'Elektronik Karma Sergi (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 3],

        // ══ 6.F EĞİTİM FAALİYETLERİ ══
        '6.F.1' => ['baslik' => 'Tamamlanmış doktora ya da uzmanlık tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 6],
        '6.F.4' => ['baslik' => 'Tamamlanmış yüksek lisans tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 3],

        // ══ 7.G YÖNETİMSEL ve KURUMA KATKI FAALİYETLERİ ══
        '7.G.1' => ['baslik' => 'Rektörlük', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör'], 'puan' => 50],
        '7.G.2' => ['baslik' => 'Rektör yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör Yardımcısı'], 'puan' => 40],
        '7.G.3' => ['baslik' => 'Dekanlık, enstitü ya da meslek yüksekokulu müdürlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü'], 'puan' => 30],
        '7.G.6' => ['baslik' => 'Bölüm başkanlığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 10],
        '7.G.7' => ['baslik' => 'Birim koordinatörlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 10],
        '7.G.8' => ['baslik' => 'Uygulama ve araştırma merkezi müdürlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 10],
        '7.G.9' => ['baslik' => 'Dekan, enstitü ya da meslek yüksekokulu müdür yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 15],
        '7.G.12' => ['baslik' => 'Bölüm başkan yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı'], 'puan' => 5],
        '7.G.18' => ['baslik' => 'Çalışma grubu, komisyon ya da kurul üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Senato / Üniversite Yönetim Kurulu Üyesi', 'Kurul / Komisyon Üyeliği'], 'puan' => 3],
    ],

    // Koşulların andığı aralıklar. Satır numaraları 1'den 42'ye gittiği için
    // önek deseni kullanılamaz ('1.A.1*' → 1.A.10-19'u da yakalar); girilebilen
    // kodlar tek tek sayıldı. Parantez içindeki kodlar kaynakta var ama
    // cetvele girilemedi (gerekçeleri dosya başlığında).
    'gruplar' => [
        // MADDE 8, Sağlık/Fen/Mühendislik (a): 1.A1-18 ve 1.A31. (1.A.18 yok.)
        '1.A.1-18+31' => ['1.A.1', '1.A.2', '1.A.3', '1.A.4', '1.A.5', '1.A.6', '1.A.7', '1.A.8',
            '1.A.9', '1.A.10', '1.A.11', '1.A.12', '1.A.13', '1.A.14', '1.A.15', '1.A.16',
            '1.A.17', '1.A.31'],

        // MADDE 8, Sağlık/Fen/Mühendislik (b): 1.A1-31. (18, 19, 21-23, 25, 27-29 yok.)
        '1.A.1-31' => ['1.A.1', '1.A.2', '1.A.3', '1.A.4', '1.A.5', '1.A.6', '1.A.7', '1.A.8',
            '1.A.9', '1.A.10', '1.A.11', '1.A.12', '1.A.13', '1.A.14', '1.A.15', '1.A.16',
            '1.A.17', '1.A.20', '1.A.24', '1.A.26', '1.A.30', '1.A.31'],

        // MADDE 8, Sosyal-Hukuk ve Sanat: 1.A1-21 · 1.A25-27 · 1.A31.
        '1.A.1-21' => ['1.A.1', '1.A.2', '1.A.3', '1.A.4', '1.A.5', '1.A.6', '1.A.7', '1.A.8',
            '1.A.9', '1.A.10', '1.A.11', '1.A.12', '1.A.13', '1.A.14', '1.A.15', '1.A.16',
            '1.A.17', '1.A.20'],
        '1.A.25-27' => ['1.A.26'],

        // MADDE 8, Spor (1.A1-27 ve 1.A31) ve MADDE 10/b (1.A1-27).
        '1.A.1-27' => ['1.A.1', '1.A.2', '1.A.3', '1.A.4', '1.A.5', '1.A.6', '1.A.7', '1.A.8',
            '1.A.9', '1.A.10', '1.A.11', '1.A.12', '1.A.13', '1.A.14', '1.A.15', '1.A.16',
            '1.A.17', '1.A.20', '1.A.24', '1.A.26'],
        '1.A.1-27+31' => ['1.A.1-27', '1.A.31'],

        // MADDE 10/a: 1.A1-8, yani WoS ve Scopus çeyrekliklerindeki tam makale
        // ve derlemeler.
        '1.A.1-8' => ['1.A.1', '1.A.2', '1.A.3', '1.A.4', '1.A.5', '1.A.6', '1.A.7', '1.A.8'],

        // MADDE 11/a: 1.A1-40 veya 2.B1-31.
        '1.A.1-40' => ['1.A.1-27', '1.A.30', '1.A.31', '1.A.32', '1.A.33', '1.A.34', '1.A.37',
            '1.A.40'],
        '2.B.1-31' => ['2.B.1', '2.B.3', '2.B.5', '2.B.7', '2.B.8', '2.B.9', '2.B.10', '2.B.11',
            '2.B.12', '2.B.13', '2.B.14', '2.B.15', '2.B.17', '2.B.18', '2.B.21', '2.B.24',
            '2.B.26'],
        '1.A.1-40|2.B.1-31' => ['1.A.1-40', '2.B.1-31'],

        // MADDE 8, Sanat (b): 2.B15-31.
        '2.B.15-31' => ['2.B.15', '2.B.17', '2.B.18', '2.B.21', '2.B.24', '2.B.26'],

        // Tavan grupları.
        'ATIF' => ['1.A.33', '1.A.34', '1.A.37', '1.A.40'],
        'DOKTORA-TEZ' => ['6.F.1'],
        'YL-TEZ' => ['6.F.4'],
    ],

    // Tablonun kendi sabit tavanları: "Atıflardan toplam 30 puan alınabilir",
    // "TAMAMLANMIŞ DOKTORA veya UZMANLIK TEZİ (En fazla 30 puan alınabilir)",
    // "TAMAMLANMIŞ YÜKSEKLİSANS TEZİ (En fazla 25 puan alınabilir)".
    'grup_tavanlari' => [
        'ATIF' => 30,
        'DOKTORA-TEZ' => 30,
        'YL-TEZ' => 25,
    ],
];
