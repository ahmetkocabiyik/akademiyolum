<?php

/**
 * ABDULLAH GÜL ÜNİVERSİTESİ — 3. AGÜ Akademik Değerlendirme Puan Tablosu
 * Kaynak: pdf/177867736535.abdullah-gul-kriter-13052026.pdf (17 sayfa)
 *
 * TEK TABLO, DÖRT BİRİM. Bölüm 3'teki puan tablosu üniversitenin tamamı için
 * ortak; ayrım birimlerin (Bölüm 4) her biri için TOPLAM barajında ve
 * ARAŞTIRMA/EĞİTİM/KATKI alt taban puanlarında. Yönerge madde numarası
 * vermiyor, tablo satır başlıklarından oluşuyor; MADDE KODLARI TAMAMEN BİZE
 * AİT (ön ek: M makale, B bildiri, K kitap, AT atıf, P proje, PT patent,
 * OD ödül, D ders, TZ tez danışmanlığı, TK toplumsal katkı, BM bilimsel
 * alana/mesleğe katkı, I idari görev/kuruma katkı).
 *
 * ── YAZAR FORMÜLÜ: SABİT DEĞİL, KADEMELİ + AYRICA ROL BONUSU ──
 * Dipnot 1 (makale, bildiri, kitap/kitap bölümü VE PATENTLER için): tek
 * yazarlı P, iki yazarlı HER BİR yazar için 0,8×P, üç ve üzeri yazarlı HER
 * BİR yazar için 1,8×P/n (n = yazar sayısı — yani üç ve üzeri yazarlıda
 * dağıtılan TOPLAM puan yazar sayısından bağımsız olarak sabit 1,8×P kalıyor,
 * yalnızca kişi başı pay küçülüyor).
 *
 * Dipnot 2 AYRICA bir bonus ekliyor: "Adayın tek yazar, ilk yazar/eş ilk
 * yazar veya sorumlu yazar olarak belirtildiği yayınlarda +%20 puan
 * uygulanır." Bu, yazar formülünün ÜSTÜNE biniyor. Motorun `roller` alanı
 * role göre AYRI kademe tablosu tanımlayabildiği için bonus, `ilk` ve
 * `baslica` rollerinin kademelerini (0,8→0,96 iki yazarlıda; 1,8→2,16 üç ve
 * üzeri yazarlıda pay olarak) doğrudan yükselterek uygulandı — tek yazarda
 * zaten 1,0 olduğu için motorun `min(1.0, …)` sınırı bonusu görünmez kılıyor,
 * gerçekte de tek yazarlı bir eserde %20 fazlası mantıksız olurdu.
 *
 * Dipnot 3 (uluslararası ortaklı / disiplinler arası / sanayi ortaklı +%20)
 * ve Dipnot 4'ün Q1 DIŞINDAKİ derlemelere bonus VERMEMESİ ayrı bir konu;
 * ikisi de aşağıda GİRİLMEYEN bölümünde.
 *
 * ── Q1 DERLEME BONUSU MADDEYE GÖMÜLDÜ ──
 * Dipnot 4: "Q1 dergilerde yayınlanan derleme makalelere … +%20 puan
 * uygulanır." Bu yalnızca Q1'de geçerli; Q2-Q4 derlemeleri özgün makaleyle
 * AYNI satırdan puanlanıyor (tabloda derleme için ayrı satır yok). Q1 için
 * ayrı bir madde açıldı (M-Q1-DERLEME, 30×1,2=36); diğer çeyreklerde
 * `turler` alanına 'derleme' de eklenerek özgün makaleyle aynı satıra alındı.
 *
 * ── KİTAPTA A/B GRUBU VE ULUSAL/2,5 SÖZLÜKTE AYRILAMADI ──
 * Tablo her kitap faaliyetini (yazarlık, bölüm, editörlük, hakemlik, çeviri,
 * bölüm çevirisi) "A grubu uluslararası yayınevi" ve "B grubu uluslararası
 * yayınevi" diye ikiye ayırıyor, üstüne "ulusal yayınevi kitap faaliyetleri:
 * Uluslararası/2,5" diyerek üçüncü bir kademe daha ekliyor. `Kategori::Kitap`
 * sözlüğünde yalnızca 'BKCI / Scopus Kitap' (Scopus/WoS indeksli, net A grubu
 * karşılığı) ile genel 'Uluslararası/Ulusal Kitap' (B grubu ile ulusalı
 * ayıramayan tek etiket) var. A grubu satırı 'BKCI / Scopus Kitap'a bağlandı;
 * geri kalan üç kademe (B grubu uluslararası, ulusal A/2,5, ulusal B/2,5) TEK
 * 'Uluslararası/Ulusal Kitap' etiketine düşüyor — üçünün EN DÜŞÜĞÜ girildi
 * (aşağı yuvarlanmış ulusal B: 25/2,5=10). Aynı sorun editörlük, çeviri ve
 * bölüm çevirisinde tekrarlanıyor; her birinde üç kademenin en düşüğü girildi.
 * Kitap hakemliği bu yüzden hiç girilmedi: `editorluk` kategorisinin tek
 * 'Hakemlik' etiketi zaten dergi ve proje hakemliğini taşıyor, kitap
 * hakemliğinin 5/3/2/1 kademesini de aynı etikete eklemek dergi hakemliğini
 * (2 puan) 1'e düşürürdü.
 *
 * ── PROJE: A/B GRUBU AYRIMI BİR KISMI GİRİLEMEDİ ──
 * "B grubu projeler: A Grubu / 2" diyor ama `Proje` sözlüğünün kaynak
 * etiketleri A/B ayrımı taşımıyor; B grubu (TÜBİTAK 1002, 3001, 1512, 1812 ve
 * TÜSEB'in KENDİ "A grubu" AR-Ge projeleri — burada TÜSEB'in içindeki A/B/C/D
 * derecelendirmesi AGÜ'nün A/B ayrımından FARKLI, TÜSEB'in A grubu AGÜ'de B
 * grubuna düşüyor) ayrı bir etikete bağlanamadığı için hiç girilmedi. "Çok
 * Ortaklı" yöneticilik/koordinatörlük kademeleri (uluslararası 50, ulusal 30)
 * ile "Sanayi Ortaklı" kademeleri de aynı sebeple (etiket çakışması) hiç
 * girilmedi; genel yürütücü/araştırmacı satırları girildi. BAP destekli tez
 * projeleri ("Normal BAP Proje Puanı/2") de aynı çakışma yüzünden ayrılamadı.
 *
 * ── PATENTTE ULUSLARARASI/ULUSAL LİSANS TEK SATIRDA ──
 * `Patent` sözlüğünde "lisans" (patentin ticarileştirilmesi) kavramına en
 * yakın etiket 'Ticarileştirme'. Uluslararası lisans (50) ile ulusal lisans
 * (25) bu tek etikete düşüyor; düşük olan (25) girildi.
 *
 * ── AYNI KAYNAĞA DÜŞEN SATIRLARDA DAİMA DÜŞÜĞÜ GİRİLDİ ──
 *   Tez danışmanlığı: "Tek danışman" (YL 5, doktora 10) ile "Asıl danışman"
 *       (YL 3, doktora 6) `danisman` rolünde ayrılamıyor → asıl danışman
 *       değeri (3/6) girildi.
 *   Ödül/Proje yarışması: uluslararası mansiyon (10) ile ulusal mansiyon (5)
 *       tek 'Yarışma Derecesi / Mansiyon' etiketine düşüyor → 5.
 *   Dergi editörlüğü, yardımcı editörlük, editör kurulu üyeliği ve özel sayı
 *       editörlüğü TAMAMI GİRİLMEDİ: `editorluk` kategorisinin çeyrekliğe
 *       göre ayrılan tek grup etiketi ('WoS Dergi (Qx)') ana editörlüğü
 *       (40/20/10) yardımcı editörlükten (10/5/3) ve kurul üyeliğinden (5/3/2)
 *       ayıramıyor; en düşüğü girmek bile (Q1'de 4 puan) neredeyse değersiz
 *       bir satır üretiyordu, o yüzden bölüm hiç girilmedi. Sadece dergi/proje
 *       hakemliği ('Hakemlik' etiketi, tek başına çakışmasız) girildi.
 *
 * ── İDARİ GÖREVLERDE İKİ FARKLI KADEME TEK ETİKETE DÜŞTÜ ──
 * `IdariGorev` sözlüğü "Dekan / Enstitü-YO Müdürü" ile "Dekan Yrd. / Müdür
 * Yrd." etiketlerini tek satırda tutuyor ama AGÜ dekanlığı (40/20) ile
 * enstitü/yüksekokul müdürlüğünü (30/15) ayrı puanlıyor; düşük olan (30/15)
 * girildi. Yönergenin "ilk yıldan sonraki her yıl için birikimli ek puan"
 * formülü (dipnot 16) motorda uygulanamıyor; yalnızca ilk yıl değeri girildi.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   Atıf b ve c satırları (0,5 ve 0,3 puan) — motorun `puan` alanı tam sayı,
 *       aşağı yuvarlanınca 0 ediyor. Yalnızca a satırı (1 puan) girildi.
 *   Bildirilerin "Diğer" satırı (p/6 formülü) — formül motorda yok.
 *   Ders yükü üstü saat başı puan, öğrenci değerlendirmesi yüzdelik dilimi,
 *       yaz-kış okulu, birden fazla şubeli ders koordinatörlüğü, aktif
 *       öğrenme uygulaması — hiçbiri Faaliyet kaydında karşılık bulamadı.
 *   Post-doc danışmanlığı, eğitim ödülleri (AGÜ ödülleri, GLB ders ödülü) —
 *       sözlükte karşılıksız.
 *   Toplumsal katkının çoğu: STK görevleri (uluslararası/ulusal), bilirkişi
 *       raportörlüğü, teknik rapor, şirket kurma, teknopark projeleri, AGÜ
 *       Akademi (saat başı) — `toplumsal_katki` kategorisinin yalnızca üç
 *       etiketi var; danışmanlık projeleri, seminer düzenleme ve
 *       yayın/sunum satırları bu üç etikete bağlandı, gerisi girilmedi.
 *   Bilimsel Alana ve Mesleğe Katkı'nın kongre/toplantı düzenleme kurulu
 *       (başkanlık/üyelik/bilimsel kurul), akademik yükseltme jüri üyeliği,
 *       yarışma jüri üyeliği, yayımlanmış proje/fikir projesi, uluslararası
 *       kuruluş komisyon üyeliği, bilimsel üst kuruluş üyeliği, sergi
 *       küratörlüğü, seçici kurul üyeliği — hiçbirinin sözlükte karşılığı
 *       yok. Yalnızca hakemlik (dergi+proje, birleşik) ve davetli konuşmacı
 *       girildi.
 *   Senato/Üniversite Yönetim Kurulu üyeliği, Araştırma ve Uygulama Merkezi
 *       müdür yardımcılığı, öğrenci kulübü danışmanlığı — AGÜ'nün kendi
 *       tablosunda bu satırlardan ilki hiç yok, ikincisi ve üçüncüsü sözlükte
 *       karşılıksız.
 *
 * Yönerge: yonerge/abdullah-gul.php
 *
 * KODLAR TAMAMEN BİZE AİT — KAYNAĞIN TABLOSUNDA SATIR KODU YOK. Puan
 * tablosu satırları düz metin açıklamalar hâlinde, numarasız veriliyor;
 * kodlar okunabilirlik için türetildi. Bu yüzden bir satırı kaynakla
 * eşlemenin tek yolu BAŞLIK METNİDİR — kod bir çapa değil.
 */

return [
    'kapsam_notu' => 'Puanlar AGÜ Akademik Değerlendirme Puan Tablosundan (Bölüm 3). '
        .'Yazar çarpanı makale, bildiri, kitap ve patentte uygulanıyor: tek yazar tam puan, '
        .'iki yazarlı her biri 0,8 kat, üç ve üzeri yazarlı her biri 1,8/n kat alır; tek yazar, '
        .'ilk yazar veya sorumlu yazar olduğunuz eserlerde bu çarpan ayrıca yükseltiliyor. '
        .'Yazar listesini boş bırakırsanız çarpan hiç uygulanmaz ve puanınız olduğundan '
        .'YÜKSEK görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: dergi editörlüğü ve yardımcı '
        .'editörlük hiç girilemedi (kaynak etiketi ana editörlüğü kurul üyeliğinden ayıramadığı '
        .'için); kitabın A/B grubu ve ulusal/uluslararası ayrımının çoğu tek etikete düştüğü '
        .'için en düşük kademe girildi; B grubu proje ve çok ortaklı/sanayi ortaklı proje '
        .'kademeleri, uluslararası ortaklı yayın bonusu (+%20), atıf b/c satırları (0,5/0,3 '
        .'puan), toplumsal katkının çoğu ve bilimsel alana/mesleğe katkının çoğu (kongre '
        .'düzenleme, jüri üyelikleri, sergi küratörlüğü) hiç girilmedi. İdari görevlerin yıl '
        .'biriktirme bonusu uygulanmıyor; yalnızca ilk yıl değeri sayılıyor. '
        .'Doktora/doçentlik sonrası dönem koşulu olan kalemlerde faaliyet tarihi girilmemişse '
        .'o kalem BELİRSİZ görünür.',

    // Dipnot 1: makale, bildiri, kitap/kitap bölümü ve patentte tek yazar P,
    // iki yazarlı her biri 0,8P, üç ve üzeri her biri 1,8P/n. Dipnot 2: tek
    // yazar/ilk yazar/eş ilk yazar/sorumlu yazarda +%20 (motorun min(1.0,…)
    // sınırı yüzünden tek yazarda görünmez, iki ve üzeri yazarlıda kademeler
    // yükseltilerek uygulandı: 0,8→0,96, 1,8→2,16).
    'yazar_katsayisi' => [
        'haric' => ['proje', 'atif', 'tez_danismanligi', 'egitim_ogretim',
            'idari_gorev', 'odul', 'editorluk', 'toplumsal_katki'],
        'roller' => (function (): array {
            $normal = ['kademeler' => [1 => 1.0, 2 => 0.8], 'bol' => ['pay' => 1.8]];
            $bonus = ['kademeler' => [1 => 1.0, 2 => 0.96], 'bol' => ['pay' => 2.16]];

            return [
                'tek' => ['kademeler' => [1 => 1.0]],
                'ilk' => $bonus,
                'baslica' => $bonus,
                'yazar_2' => $normal,
                'yazar_3' => $normal,
                'yazar_4' => $normal,
                'yazar_5' => $normal,
                'yazar_6' => $normal,
                'ortak' => $normal,
            ];
        })(),
    ],

    'maddeler' => [
        // ══ MAKALE ══
        'M-Q1' => ['baslik' => 'WoS Core Collection Q1 dergide özgün makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale'], 'puan' => 30],
        'M-Q1-DERLEME' => ['baslik' => 'WoS Core Collection Q1 dergide derleme makale (+%20 bonuslu)', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['derleme'], 'puan' => 36],
        'M-Q2' => ['baslik' => 'WoS Core Collection Q2 dergide özgün veya derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 20],
        'M-Q3Q4' => ['baslik' => 'WoS Core Collection Q3 veya Q4 dergide özgün veya derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 15],
        'M-Q1-KISA' => ['baslik' => 'WoS Core Collection Q1 dergide editöre mektup, teknik not veya vaka incelemesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 5],
        'M-Q2-KISA' => ['baslik' => 'WoS Core Collection Q2 dergide editöre mektup, teknik not veya vaka incelemesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 3],
        'M-Q3Q4-KISA' => ['baslik' => 'WoS Core Collection Q3 veya Q4 dergide editöre mektup, teknik not veya vaka incelemesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 2],
        'M-MIMARLIK-INDEKS' => ['baslik' => 'Architectural Publications Index, Art Index, Avery Index veya Scopus kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 15],
        'M-DIGERINDEKS' => ['baslik' => 'ISI indeksi dışındaki uluslararası indeksli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'puan' => 10],
        'M-TRDIZIN' => ['baslik' => "TR Dizin'de taranan ulusal hakemli dergide makale", 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 6],

        // ══ BİLDİRİ ══
        'B-ULUSTAM' => ['baslik' => 'Uluslararası hakemli kongre/çalıştay bildirisi (basılı tam metin)', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 4],
        'B-ULUSOZET' => ['baslik' => 'Uluslararası hakemli kongre/çalıştay bildirisi (basılı özet, sözlü veya poster)', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 3],
        'B-ULUSALTAM' => ['baslik' => 'Hakemli ulusal kongre/çalıştay bildirisi (basılı tam metin)', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 3],
        'B-ULUSALOZET' => ['baslik' => 'Hakemli ulusal kongre/çalıştay bildirisi (basılı özet, sözlü veya poster)', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 1],

        // ══ KİTAP (A grubu Scopus/BKCI indeksli; geri kalanı tek etikette en düşük kademe) ══
        'K-A-YAZAR' => ['baslik' => 'A grubu (Scopus/BKCI indeksli) uluslararası yayınevinde kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 40],
        'K-DIGER-YAZAR' => ['baslik' => 'B grubu uluslararası yayınevinde veya ulusal yayınevinde kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 10],
        'K-A-BOLUM' => ['baslik' => 'A grubu (Scopus/BKCI indeksli) uluslararası yayınevi kitabında bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 15],
        'K-DIGER-BOLUM' => ['baslik' => 'B grubu uluslararası yayınevi veya ulusal yayınevi kitabında bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 4],
        'K-CEVIRI' => ['baslik' => 'Kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 4],
        'K-BOLUM-CEVIRI' => ['baslik' => 'Kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 2],
        'K-EDIT-A' => ['baslik' => 'A grubu (Scopus/BKCI indeksli) uluslararası yayınevi kitabında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 15],
        'K-EDIT-DIGER' => ['baslik' => 'B grubu uluslararası yayınevi veya ulusal yayınevi kitabında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 4],

        // ══ ATIF ══
        'AT-A' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergide ya da tanınmış uluslararası yayınevi kitabında, yazar olmadığınız bir esere yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 1],

        // ══ BİLİMSEL ARAŞTIRMA PROJESİ ══
        'P-ULUS-COK-YONETICI' => ['baslik' => 'Çok ortaklı uluslararası projede (EU, NSF, Newton, Marie Curie vb.) yönetici veya koordinatör', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 50],
        'P-ULUS-YURUTUCU' => ['baslik' => 'A grubu uluslararası projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 30],
        'P-ULUS-ARASTIRMACI' => ['baslik' => 'A grubu uluslararası projede araştırmacı veya danışman', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman'], 'puan' => 15],
        'P-ULUSAL-YURUTUCU' => ['baslik' => 'A grubu ulusal projede (TÜBİTAK, TÜSEB, bakanlık vb.) yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 20],
        'P-ULUSAL-ARASTIRMACI' => ['baslik' => 'A grubu ulusal projede araştırmacı veya danışman', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman'], 'puan' => 10],
        'P-BAP-YURUTUCU' => ['baslik' => 'Üniversite Destekli Proje (BAP) yürütücüsü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 5],
        'P-BAP-ARASTIRMACI' => ['baslik' => 'Üniversite Destekli Proje (BAP) araştırmacı veya danışman', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['arastirmaci', 'danisman'], 'puan' => 2],
        'P-OGRENCI-DANISMAN' => ['baslik' => 'Dış kaynaklı öğrenci projesinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'roller' => ['danisman'], 'puan' => 2],
        'P-DIGERKURUM-YURUTUCU' => ['baslik' => 'Diğer kurum ve kuruluşlarca desteklenen projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 5],
        'P-DIGERKURUM-ARASTIRMACI' => ['baslik' => 'Diğer kurum ve kuruluşlarca desteklenen projede araştırmacı veya danışman', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman'], 'puan' => 2],

        // ══ PATENTLER ══
        'PT-ULUS-PATENT' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 40],
        'PT-LISANS' => ['baslik' => 'Patentin uluslararası veya ulusal lisanslanması', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 25],
        'PT-ULUSAL-PATENT' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 20],
        'PT-FAYDALI-MODEL' => ['baslik' => 'Araştırma raporu düzenlenmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 5],

        // ══ ÖDÜLLER / PROJE YARIŞMASI ══
        'OD-ULUSLARARASI' => ['baslik' => 'Sürekli düzenlenen bir uluslararası yarışmada alanınızda kazanılan ödül veya ilk üçe girme derecesi', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü'], 'puan' => 20],
        'OD-ULUSAL' => ['baslik' => 'Sürekli düzenlenen bir ulusal yarışmada alanınızda kazanılan ödül veya ilk üçe girme derecesi', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 10],
        'OD-MANSIYON' => ['baslik' => 'Meslek kuruluşlarınca onaylanan yarışmada mansiyon', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 5],

        // ══ EĞİTİM — DERSLER ══
        'D-YENI-DERS' => ['baslik' => 'Yeni lisans, yüksek lisans veya doktora dersi açmak ve yürütmek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Lisansüstü Ders', 'Yabancı Dilde Ders'], 'puan' => 3],

        // ══ EĞİTİM — TEZ YÖNETİMİ ══
        'TZ-YL-DANISMAN' => ['baslik' => 'Yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 3],
        'TZ-YL-YARDIMCI' => ['baslik' => 'Yüksek lisans tez yardımcı danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 3],
        'TZ-DOKTORA-DANISMAN' => ['baslik' => 'Doktora tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 6],
        'TZ-DOKTORA-YARDIMCI' => ['baslik' => 'Doktora tez yardımcı danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 6],
        'TZ-JURI' => ['baslik' => 'Doktora tez jürisi veya tez izleme komitesi üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 1],

        // ══ KATKI — TOPLUMSAL KATKI ══
        'TK-DANISMANLIK' => ['baslik' => 'Özel, kamu veya STK profesyonel danışmanlık projesi', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı'], 'puan' => 5],
        'TK-SEMINER' => ['baslik' => 'Topluma yönelik eğitim, seminer veya çalıştay düzenlemek ya da görev almak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi'], 'puan' => 2],
        'TK-YAYIN' => ['baslik' => 'Topluma yönelik yayın veya sunum', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Bilim İletişimi / Popüler Yayın'], 'puan' => 3],

        // ══ KATKI — BİLİMSEL ALANA VE MESLEĞE KATKI ══
        'BM-HAKEMLIK' => ['baslik' => 'Bilimsel dergi veya proje hakemliği, panelistlik ya da denetçilik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 2],
        'BM-KONUSMACI' => ['baslik' => 'Davetli konuşmacı', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 5],

        // ══ KATKI — KURUMA KATKI (idari görev; yıl biriktirme bonusu uygulanmıyor) ══
        'I-REKTOR' => ['baslik' => 'Rektörlük', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör'], 'puan' => 100],
        'I-REKTOR-YRD' => ['baslik' => 'Rektör yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör Yardımcısı'], 'puan' => 50],
        'I-DEKAN' => ['baslik' => 'Dekanlık, enstitü müdürlüğü veya yüksekokul müdürlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü'], 'puan' => 30],
        'I-DEKAN-YRD' => ['baslik' => 'Dekan yardımcılığı, enstitü müdür yardımcılığı veya yüksekokul müdür yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 15],
        'I-BOLUM-BASKANI' => ['baslik' => 'Bölüm başkanlığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 30],
        'I-BOLUM-BASKAN-YRD' => ['baslik' => 'Bölüm başkan yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı'], 'puan' => 15],
        'I-MERKEZ-MUDUR' => ['baslik' => 'Araştırma ve Uygulama Merkezi müdürlüğü veya koordinatörlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 20],
        'I-ABD-BASKANI' => ['baslik' => 'Anabilim dalı başkanlığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 10],
        'I-KOMISYON' => ['baslik' => 'Komisyonlarda görev almak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 2],
    ],

    'gruplar' => [
        // Dipnot 2'nin tanımladığı "yayın" kümesi: makale + bildiri + kitap
        // (yazarlık/bölüm/çeviri/bölüm çevirisi — editörlük hariç) + patent.
        // Genel atıf (AT-A) bu kümenin DIŞINDA tutuldu; dipnot yalnızca
        // "patentlerden alınan atıfları" anıyor, dergi/kitap atfını değil.
        'YAYIN' => ['M-*', 'B-*', 'K-A-YAZAR', 'K-DIGER-YAZAR', 'K-A-BOLUM',
            'K-DIGER-BOLUM', 'K-CEVIRI', 'K-BOLUM-CEVIRI', 'PT-*'],

        // Doçentlik/profesörlük dipnotlarının "en az bir/iki/üç tanesi SCI…
        // dergide yayımlanmış olmalı" şartı — kısa makale/editöre mektup
        // hariç, yalnızca özgün ve derleme makaleler.
        'SCI-DERGI' => ['M-Q1', 'M-Q1-DERLEME', 'M-Q2', 'M-Q3Q4'],

        // Proje yürütücülüğü satırlarının tamamı (adet koşulu için).
        'PROJE-YURUTUCU' => ['P-ULUS-COK-YONETICI', 'P-ULUS-YURUTUCU', 'P-ULUSAL-YURUTUCU'],
        'PROJE' => ['P-*'],

        'EGITIM' => ['D-*', 'TZ-*'],
        'KATKI' => ['TK-*', 'BM-*', 'I-*'],

        // Mühendislik biriminin proje telafisinde kullanılan makale kümesi
        // ("eksik kalan kısmın en az 2 katı puan Q1 ve Q2 dergi makalelerinden").
        'M-Q1Q2' => ['M-Q1', 'M-Q2'],

        // Tez danışmanlığının tamamı (adet koşulu için).
        'TEZ-DANISMANLIK' => ['TZ-YL-DANISMAN', 'TZ-YL-YARDIMCI', 'TZ-DOKTORA-DANISMAN', 'TZ-DOKTORA-YARDIMCI'],
    ],
];
