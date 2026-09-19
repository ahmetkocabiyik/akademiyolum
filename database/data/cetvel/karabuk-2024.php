<?php

/**
 * KARABÜK ÜNİVERSİTESİ — EK-1 Puanlama ve Değerlendirme Tablosu
 * Kaynak: pdf/17536999092.karabukuniverstesi.pdf
 *
 * TEK ORTAK PUAN TABLOSU, TEMEL ALAN AYRIMI YOK. Karabük bütün alanlardan aynı
 * puanı istiyor; tek istisna tıp/diş/eczacılık/veterinerlik fakülteleri için
 * düşük tutulan Dr. Öğr. Üyesi barajı (bkz. yonerge/karabuk.php).
 *
 * KOŞULLAR TABLOYA BÖLÜM NUMARASIYLA ATIF YAPIYOR ("en az 400 puanı 4.1, 4.2,
 * 4.3, 4.4, 4.5 ve 4.6 kısımlarından"), bu yüzden madde kodları birebir
 * korundu.
 *
 * YAZAR ÇARPANI SIRAYA BAĞLI, SAYIYA DEĞİL (Madde 9): tek yazarlı çalışmada tam
 * puan; çok yazarlıda 1. yazar 0,95 · 2. yazar 0,85 · 3. ve sonraki yazarlar
 * 0,75. Yazar sayısı hiç rol oynamıyor — korpustaki diğer üniversitelerin
 * çoğundan farklı, cömert bir kural.
 *
 * ATIF PUANI "HER ESER İÇİN" VERİLİYOR, HER ATIF İÇİN DEĞİL (4.10). Yönerge
 * "adayın atıf aldığı her eser için" diyor; faaliyet kaydı ise atıf sayısını
 * tutuyor. Bu ayrım kayıttan türetilemediği için atıf puanı OLDUĞUNDAN YÜKSEK
 * çıkar; aday notunda uyarıldı.
 *
 * AYNI KAYNAĞA DÜŞEN KALEMLERDE DÜŞÜK OLAN GİRİLDİ (kural: eksik say, fazla
 * sayma):
 *   'Hakemlik' kaynağı dergi düzeyi taşımıyor → 4.7.8 (5) ve 4.7.9 (3) yerine
 *       4.7.10 (2) girildi.
 *   'Kitap Editörlüğü' uluslararası/ulusal ayrımı taşımıyor → 4.7.6 (50) yerine
 *       4.7.7 (30).
 *   'WoS / Scopus' atıf kaynağı SCI ile alan indeksini ayırmıyor → 4.10.1 (5)
 *       yerine 4.10.2 (4).
 *   'Lisans/Önlisans Ders' iki düzeyi birleştiriyor → 4.12.2 (4) yerine
 *       4.12.3 (3).
 *   'Burs' kaynağı yurt içi/dışı ayırmıyor → 4.9.2 (50) yerine 4.9.9 (20).
 *   'Davetli Konuşmacı' ulusal/uluslararası ayırmıyor → 4.18.1 (40) yerine
 *       4.18.3 (20).
 *   'Eserin Yayında Yer Alması / Satın Alınması' yurt içi/dışı ayırmıyor →
 *       4.6.1 (150) yerine 4.6.2 (125).
 *
 * GİRİLMEYEN KALEMLER (kaynak sözlüğünde karşılığı yok): 4.1.5'in bir kısmı,
 * 4.2.3 ve 4.3.3 (yayınlanmamış bildiri), 4.5.2 (transkripsiyon), 4.6.12-4.6.21
 * (sahne sanatları grup çalışmaları ve bütün spor kalemleri), 4.7.11-4.7.12
 * (yarışma jüriliği), 4.8.4 (patent müracaatı), 4.9.6 (diğer bilimsel ödüller),
 * 4.10.5 (ulusal kitap atfı), 4.13.2-4.13.3, 4.14.5-4.14.6, 4.15.1/3/4,
 * 4.18'in belge-sertifika ve danışmanlık kalemleri.
 *
 * SPOR KALEMLERİ TAMAMEN GİRİLEMEDİ (4.6.14-4.6.21: antrenörlük, hakemlik,
 * milli takım). Spor Bilimleri adayının 4.1-4.6 alt barajı bu yüzden olduğundan
 * ZOR görünür.
 *
 * KİTAPTA YAYINEVİ KAPSAMI (19.09.2026): 4.4 bloğunun dört satırı yalnız
 * yayınevinin uluslararası ya da ulusal olmasına bakıyor; tanımlar maddesi (c)
 * ve (ç) yayınevini süre, kütüphane kataloglaması ve kitap sayısıyla
 * tanımlıyor, indeks aranmıyor. Uluslararası satırlar yalnız BKCI/Scopus
 * etiketiyle yazıldığı için indekssiz uluslararası kitap 100 yerine 80,
 * bölümü 30 yerine 20 puan alıyordu.
 */

return [
    'kapsam_notu' => 'Puanlar Karabük Üniversitesi EK-1 tablosundan. Makale, bildiri ve kitap '
        .'kalemlerinde yazar sıranıza göre çarpan uygulanır (Madde 9: 1. yazar 0,95 · 2. yazar '
        .'0,85 · 3. ve sonrası 0,75); yazar listesini boş bırakırsanız uygulanamaz. ATIF '
        .'PUANINIZ OLDUĞUNDAN YÜKSEK ÇIKAR: yönerge puanı "atıf aldığınız her ESER için" '
        .'veriyor, kayıt ise atıf sayısını tutuyor. Sahne sanatları grup çalışmaları ve bütün '
        .'spor kalemleri (4.6.12-4.6.21) girilemedi; Spor Bilimleri adaylarında 4.1-4.6 barajı '
        .'olduğundan zor görünür.',

    // Madde 9 — çarpan yalnızca sıraya bağlı, yazar sayısından bağımsız.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'proje', 'patent', 'editorluk', 'odul', 'egitim_ogretim',
            'tez_danismanligi', 'idari_gorev', 'toplumsal_katki', 'sanatsal_etkinlik'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.0]],
            'ilk' => ['kademeler' => [1 => 1.0], 'sonrasi' => 0.95],
            'baslica' => ['kademeler' => [1 => 1.0], 'sonrasi' => 0.95],
            'yazar_2' => ['sonrasi' => 0.85],
            'yazar_3' => ['sonrasi' => 0.75],
            'yazar_4' => ['sonrasi' => 0.75],
            'yazar_5' => ['sonrasi' => 0.75],
            'yazar_6' => ['sonrasi' => 0.75],
            // Sırasını belirtmeyen aday en düşük kademeyi alır.
            'ortak' => ['kademeler' => [1 => 1.0], 'sonrasi' => 0.75],
        ],
    ],

    'maddeler' => [
        // ── 4.1 MAKALELER ──
        // Madde 1 dört çeyreklik satırı taşıyor; kodlar (a-d) bize ait.
        '4.1.1a' => ['baslik' => 'SCI-E, SSCI veya AHCI Q1 dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale'], 'puan' => 200],
        '4.1.1b' => ['baslik' => 'SCI-E, SSCI veya AHCI Q2 dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale'], 'puan' => 175],
        '4.1.1c' => ['baslik' => 'SCI-E, SSCI veya AHCI Q3 dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale'], 'puan' => 150],
        // AHCI çeyreklik taşımadığı için en düşük satıra (Q4) yazıldı.
        '4.1.1d' => ['baslik' => 'SCI-E, SSCI veya AHCI Q4 dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 125],
        '4.1.2' => ['baslik' => 'Uluslararası alan indeksli dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale'], 'puan' => 100],
        '4.1.3' => ['baslik' => 'ULAKBİM TR Dizin dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 75],
        '4.1.4' => ['baslik' => 'Diğer uluslararası veya ulusal dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale'], 'puan' => 30],
        // Madde 5: derleme, vaka takdimi, teknik not vb. için "adı geçen
        // maddelerde belirtilen puanların yarısı". Yarımlar aşağı yuvarlandı.
        '4.1.5a' => ['baslik' => 'SCI-E, SSCI veya AHCI Q1 dergide derleme, vaka takdimi veya teknik not', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 100],
        '4.1.5b' => ['baslik' => 'SCI-E, SSCI veya AHCI Q2 dergide derleme, vaka takdimi veya teknik not', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 87],
        '4.1.5c' => ['baslik' => 'SCI-E, SSCI veya AHCI Q3 dergide derleme, vaka takdimi veya teknik not', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 75],
        '4.1.5d' => ['baslik' => 'SCI-E, SSCI veya AHCI Q4 dergide derleme, vaka takdimi veya teknik not', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 62],
        '4.1.5e' => ['baslik' => 'Uluslararası alan indeksli dergide derleme, vaka takdimi veya teknik not', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 50],
        '4.1.5f' => ['baslik' => 'TR Dizin dergide derleme, vaka takdimi veya teknik not', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 37],
        '4.1.5g' => ['baslik' => 'Diğer dergide derleme, vaka takdimi veya teknik not', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 15],

        // ── 4.2 ULUSLARARASI BİLDİRİLER ──
        '4.2.1' => ['baslik' => 'Uluslararası bildiri kitabında tam metin poster veya sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Uluslararası Tam Metin (CPCI)'], 'puan' => 40],
        '4.2.2' => ['baslik' => 'Uluslararası bildiri kitabında özet metin poster veya sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 20],

        // ── 4.3 ULUSAL BİLDİRİLER ──
        '4.3.1' => ['baslik' => 'Ulusal bildiri kitabında tam metin poster veya sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 20],
        '4.3.2' => ['baslik' => 'Ulusal bildiri kitabında özet metin poster veya sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 15],

        // ── 4.4 KİTAPLAR ──
        '4.4.1' => ['baslik' => 'Uluslararası yayınevince yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası Kitap', 'Uluslararası Ders / Metot Kitabı'], 'puan' => 100],
        '4.4.2' => ['baslik' => 'Uluslararası yayınevi kitabında bölüm yazarlığı (aynı kitapta en fazla 2 bölüm)', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Uluslararası Kitap Bölümü'], 'puan' => 30],
        '4.4.3' => ['baslik' => 'Ulusal yayınevince yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap', 'Ulusal Ders / Metot Kitabı'], 'puan' => 80],
        '4.4.4' => ['baslik' => 'Ulusal yayınevi kitabında bölüm yazarlığı (aynı kitapta en fazla 2 bölüm)', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap Bölümü'], 'puan' => 20],

        // ── 4.5 ÇEVİRİLER ──
        '4.5.1' => ['baslik' => 'Alanında makale veya kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 50],
        '4.5.3' => ['baslik' => 'Alanında kitap bölümü çevirisi (aynı kitapta en fazla 2 bölüm)', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 20],

        // ── 4.6 SANAT VE SPOR ETKİNLİKLERİ (spor kalemleri girilemedi) ──
        '4.6.2' => ['baslik' => 'Özgün eserin satın alınması veya yayın organında yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Satın Alınması (Yurt İçi)', 'Eserin Yayında Yer Alması / Satın Alınması'], 'puan' => 125],
        '4.6.3' => ['baslik' => 'Uluslararası jürili karma sanat ve tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)'], 'puan' => 100],
        '4.6.4' => ['baslik' => 'Ulusal jürili yurt dışı karma sanat ve tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Ulusal Jürili)'], 'puan' => 70],
        '4.6.5' => ['baslik' => 'Yurt içinde jürili karma sanat ve tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)'], 'puan' => 50],
        '4.6.6' => ['baslik' => 'Yurt dışında kişisel sanat etkinliğinde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)'], 'puan' => 100],
        '4.6.7' => ['baslik' => 'Yurt içinde kişisel sanat etkinliğinde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)'], 'puan' => 50],
        '4.6.8' => ['baslik' => 'Yurt dışında karma veya grup sanat etkinliğine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Jürisiz)'], 'puan' => 40],
        '4.6.9' => ['baslik' => 'Yurt içinde karma veya grup sanat etkinliğine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Jürisiz, Ulusal)'], 'puan' => 30],
        '4.6.10' => ['baslik' => 'Uluslararası sempozyum, festival veya bienale eserle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 50],
        '4.6.11' => ['baslik' => 'Ulusal sempozyum, festival veya bienale eserle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 40],

        // ── 4.7 EDİTÖRLÜK VE HAKEMLİKLER ──
        '4.7.1' => ['baslik' => 'SCI-E, SSCI veya AHCI dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 100],
        '4.7.2' => ['baslik' => 'Uluslararası indeksli diğer dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 80],
        '4.7.3' => ['baslik' => 'ULAKBİM TR Dizin dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 60],
        '4.7.4' => ['baslik' => 'Diğer bilimsel veya sanatsal dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 40],
        '4.7.7' => ['baslik' => 'Kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü', 'BKCI Kitap'], 'puan' => 30],
        '4.7.10' => ['baslik' => 'Dergi hakemliği (yılda en fazla 5 makale)', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 2],

        // ── 4.8 PATENTLER ──
        '4.8.1' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 200],
        '4.8.2' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 150],
        '4.8.3' => ['baslik' => 'Faydalı model veya endüstriyel tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 100],

        // ── 4.9 ÖDÜLLER ──
        '4.9.1' => ['baslik' => 'Uluslararası bilim, sanat veya tasarım ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü'], 'puan' => 100],
        '4.9.4' => ['baslik' => 'TÜBİTAK veya TÜBA bilim ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü'], 'puan' => 60],
        '4.9.5' => ['baslik' => 'TÜBİTAK veya TÜBA teşvik ödülü (gençlik ödülleri dâhil)', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 50],
        '4.9.7' => ['baslik' => 'Ulusal bilim, sanat veya tasarım ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 50],
        '4.9.9' => ['baslik' => 'Bilimsel araştırma bursu (üç aydan uzun süreli)', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 20],

        // ── 4.10 ATIFLAR (yönerge "her eser için" diyor, kayıt atıf sayısını tutuyor) ──
        '4.10.2' => ['baslik' => 'Uluslararası indeksli dergide atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 4],
        '4.10.3' => ['baslik' => 'TR Dizin veya diğer hakemli dergide atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer'], 'puan' => 3],
        '4.10.4' => ['baslik' => 'Uluslararası kitapta atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 4],

        // ── 4.11 TEZ YÖNETİMİ (ikinci danışmanlıkta puanların yarısı) ──
        '4.11.1' => ['baslik' => 'Yönetiminde tamamlanan doktora tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 40],
        '4.11.1b' => ['baslik' => 'Tamamlanan doktora tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 20],
        '4.11.2' => ['baslik' => 'Yönetiminde tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 20],
        '4.11.2b' => ['baslik' => 'Tamamlanan yüksek lisans tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 10],

        // ── 4.12 ÖĞRETİME KATKI ──
        '4.12.1' => ['baslik' => 'Lisansüstü seviyede verilen ders (dönem başına, en fazla 3 ders)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 5],
        '4.12.3' => ['baslik' => 'Lisans veya ön lisans seviyesinde verilen ders (dönem başına, en fazla 3 ders)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 3],

        // ── 4.13 ÜNİVERSİTE SEKTÖR İŞ BİRLİĞİ ──
        '4.13.1' => ['baslik' => 'Uzmanlık alanıyla ilgili sektöre verilen danışmanlık (hizmet başına)', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı'], 'puan' => 15],
        '4.13.5' => ['baslik' => 'Toplumsal sorumluluk projesinde görev almak (görev başına)', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi'], 'puan' => 20],

        // ── 4.14 ARAŞTIRMA PROJELERİ ──
        '4.14.1' => ['baslik' => 'AB Çerçeve gibi uluslararası destekli projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 100],
        '4.14.2' => ['baslik' => 'AB Çerçeve gibi uluslararası destekli projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 80],
        '4.14.3' => ['baslik' => 'TÜBİTAK veya kalkınma ajansı projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 70],
        '4.14.4' => ['baslik' => 'TÜBİTAK veya kalkınma ajansı projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 50],
        '4.14.7' => ['baslik' => 'TÜBİTAK öğrenci proje danışmanlığı', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'puan' => 10],
        '4.14.8' => ['baslik' => 'BAP kapsamında desteklenen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 40],
        '4.14.10' => ['baslik' => 'BAP kapsamındaki projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],

        // ── 4.15 KOORDİNATÖRLÜK VE ÜYELİKLER ──
        '4.15.2' => ['baslik' => 'Eğitim, kalite vb. komisyon üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 2],

        // ── 4.16 JÜRİ ÜYELİKLERİ ──
        '4.16.1' => ['baslik' => 'Tez, yeterlik veya atama jüri üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 2],

        // ── 4.17 YÖNETİCİLİK (her bir yıl için) ──
        '4.17.1' => ['baslik' => 'Rektör veya rektör yardımcılığı (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı'], 'puan' => 20],
        '4.17.2' => ['baslik' => 'Dekan veya müdürlük (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü'], 'puan' => 15],
        '4.17.3' => ['baslik' => 'Dekan veya müdür yardımcılığı (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 10],
        '4.17.4' => ['baslik' => 'Bölüm, anabilim veya anasanat dalı başkanlığı (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 10],
        '4.17.5' => ['baslik' => 'Uygulama ve araştırma merkezi müdürlüğü (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 10],
        '4.17.6' => ['baslik' => 'Bölüm başkan yardımcılığı (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı'], 'puan' => 5],

        // ── 4.18 DİĞER BİLİMSEL VE İDARİ FAALİYETLER ──
        '4.18.3' => ['baslik' => 'Sempozyum, kongre veya konferansta davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 20],
        '4.18.4' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)', 'Toplantı Düzenleme Başkanlığı (Ulusal)'], 'puan' => 30],
        '4.18.5' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 20],
    ],

    'gruplar' => [
        // Madde 6, 7 ve 8'in andığı alt baraj kümesi.
        '4.1-4.6' => ['4.1.*', '4.2.*', '4.3.*', '4.4.*', '4.5.*', '4.6.*'],
    ],

    // 4.4.2/4.4.4 "aynı kitapta en fazla 2 bölüm", 4.7.8-10 "yılda en fazla 5
    // makale", 4.12 "en fazla 3 ders", 4.18.13 "en fazla 20 puan" gibi sınırlar
    // faaliyet kaydından türetilemiyor; uygulanmıyor.
    'grup_tavanlari' => [],
];
