<?php

/**
 * SİNOP ÜNİVERSİTESİ — Atama ve Yükseltme Kriterleri Tabloları (EK-1-12)
 * Kaynak: pdf/17537008012.sinopuniverstesi.pdf (88 sayfa; SNÜ-YNG-011,
 * Senato 15.01.2025-2025/09, değişiklik 16.01.2025-2025/11 ve
 * 03.06.2025-2025/71; YÖK'ün 28/05/2025 E.349314 yazısı ile uygun
 * görüldü, MADDE 11 uyarınca 01.10.2025'te yürürlüğe girdi.)
 *
 * ── ON İKİ TEMEL ALAN, ON İKİ AYRI TABLO ──
 * Yönerge her temel alana kendi puan tablosunu veriyor (Tablo EB1, FM1,
 * FL1, GS1-GS2, H1, İLA1, MP1, MÜ1, SB1, SBİ1, SP1, ZOS1). Tablolar iki
 * aileye ayrılıyor:
 *   A ailesi (Eğitim, Fen, Mühendislik, Sağlık, Spor, Ziraat)
 *       1. Uluslararası Makale · 2. Ulusal Makale · 3. Kitap · 4. Atıf ·
 *       5. Tez Danışmanlığı · 6. Proje · 7. Bilimsel Toplantı ·
 *       8. Eğitim-Öğretim · 9. Patent · 10. Ödül · 11. Editörlük ·
 *       12. Diğer   (Spor'da 12. Sportif, 13. Diğer)
 *   B ailesi (Filoloji, Hukuk, İlahiyat, Mimarlık, Sosyal)
 *       1. Makale (TR Dizin bu maddenin d bendi) · 2. Kitap · 3. Atıf ·
 *       4. Tez Danışmanlığı · 5. Proje · 6. Bilimsel Toplantı ·
 *       7. Eğitim-Öğretim · 8. Patent · 9. Ödül · 10. Editörlük ·
 *       11. Diğer   (Mimarlık'ta 11. Tasarım/Yarışma/Yazılım, 12. Diğer)
 * Madde kodları her tablonun KENDİ numaralandırması. Yalnız 1. maddenin
 * (a) bendinin çeyreklik alt kodları (`1a-Q1` …) ve rol/eş danışman
 * ayrımı için açılan `-yur`, `-ars`, `-dan`, `-es`, `-yd` ekleri bize ait.
 *
 * ── GÜZEL SANATLAR GİRİLMEDİ ──
 * Tablo GS2 (Sanatsal Faaliyetler) dört bilim/sanat alanına ayrılıyor ve
 * satırlarının puanı tek esere değil DOSYAYA veriliyor ("a veya b
 * bentlerinden en az 50 puan", "farklı dönemlere ait opera eserlerinde
 * solist icracı olarak bulunmak"). Güzel Sanatlar temel alanının BÜTÜN
 * kadrolarında GS2'den asgari puan zorunlu; koşulun tamamı girilemeyen
 * bir tabloya dayandığı için §0 uyarınca bu alanda HİÇ eşik yazılmadı.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   Bilimsel toplantının "Sinop Üniversitesinde gerçekleştirilen
 *       toplantı" satırı (4 puan) girilmedi; kayıt toplantının yerini
 *       tutmuyor, diğer toplantı satırı (3) uygulanıyor.
 *   Editörlükte "Sinop Üniversitesi birimlerince yayımlanan dergilerde
 *       editörlük" (5) girilmedi; 'Diğer Hakemli Dergi' etiketi bütün
 *       hakemli dergileri kapsıyor.
 *   Patentte "değerlendirmeye alınmış başvuru" (2) girilmedi; sözlük
 *       tescil ile başvuruyu ayırmıyor.
 *   Ödülün altı bendi de 25 puan olduğu için tek satırda birleşti.
 *
 * ── PROJEDE ROL ──
 * 6/5. maddenin (a) bendi puanı role göre bölüyor (yürütücü 20 ya da 15,
 * araştırmacı 15 ya da 10, danışman 5); satır üç koda ayrıldı. ROLÜ
 * GİRİLMEMİŞ proje bu satırlara uymaz ve 0 puan alır. (b) ve (c)
 * bentlerinin puanı role bakmıyor; profesörlükteki "yürütücü veya
 * danışman olmak" koşulu için aynı puanlı AYNA satırlar (`-yd`) açıldı.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   Diğer Faaliyetler: h-indeksi (5) ve yurt dışı araştırma (4) faaliyet
 *       değil ölçüt; öğrenci kulübü danışmanlığı ve SEM sertifika
 *       programı dersi sözlükte karşılıksız.
 *   İlahiyat 11. maddesi (Sanatsal Uygulama/Etkinlik) — hiçbir eşik bu
 *       maddeye atıf yapmıyor, satırları girilmedi.
 *   Spor Bilimleri 12. maddesi (Sportif Faaliyetler) — sözlükte
 *       karşılıksız; hiçbir eşik atıf yapmıyor.
 *
 * ── KAYNAKTAKİ BELİRSİZLİK ──
 * İlahiyat tablosunun Kitap maddesinde "d ve e bentleri kapsamında en
 * fazla 20 puan alınabilir" yazıyor ama maddenin (e) bendi yok.
 * Tavan (c) ve (d) bentlerine uygulandı; kaynak metni düzeltilmedi.
 *
 * Yönerge: yonerge/sinop.php
 */
$SCI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)'];
$TAM = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];
$WOS_DERGI = ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'];
$IDARI = ['Rektör', 'Rektör Yardımcısı', 'Senato / Üniversite Yönetim Kurulu Üyesi',
    'Dekan / Enstitü-YO Müdürü', 'Dekan Yrd. / Müdür Yrd.', 'Uygulama ve Araştırma Merkezi Müdürü',
    'Bölüm Başkanı', 'Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük'];
$PROJE_KAMU = ['Diğer Kamu Kurumu', 'Özel Sektör / STK'];
$PROJE_AB = ['AB Çerçeve / Ufuk', 'TÜBİTAK', 'TÜSEB'];

/**
 * Bir temel alanın cetvelini üretir.
 *
 * @param  array<string, int>  $p  Alan başına değişen puanlar
 * @param  array<string, int>  $tavan  Grup tavanları
 * @return array<string, mixed>
 */
$aileA = function (array $p, array $tavan, string $dp) use ($SCI, $TAM, $KISA, $WOS_DERGI, $IDARI, $PROJE_AB, $PROJE_KAMU): array {
    $maddeler = [
        // ══ 1. ULUSLARARASI MAKALE ══
        '1a-Q1' => ['baslik' => 'SCIE ya da SSCI kapsamındaki Q1 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $TAM, 'puan' => 30],
        '1a-Q2' => ['baslik' => 'SCIE ya da SSCI kapsamındaki Q2 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $TAM, 'puan' => 20],
        '1a-Q3' => ['baslik' => 'SCIE ya da SSCI kapsamındaki Q3 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $TAM, 'puan' => 15],
        '1a-Q4' => ['baslik' => 'SCIE ya da SSCI kapsamındaki Q4 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $TAM, 'puan' => 10],
        '1b' => ['baslik' => 'AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => $TAM, 'puan' => 20],
        '1c' => ['baslik' => 'ESCI ya da Scopus kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $TAM, 'puan' => 10],
        '1d' => ['baslik' => 'Diğer uluslararası indekslerde taranan dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $TAM, 'puan' => 5],
        '1e' => ['baslik' => 'Uluslararası indekslerde taranan dergide yayımlanmış editöre mektup, araştırma notu, özet ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => [...$SCI, 'AHCI', 'ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 3],

        // ══ 2. ULUSAL MAKALE ══
        '2a' => ['baslik' => 'TR Dizin kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TAM, 'puan' => 10],
        '2b' => ['baslik' => 'Diğer hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => $p['2b']],
        '2c' => ['baslik' => 'Ulusal hakemli dergide yayımlanmış editöre mektup, araştırma notu, özet ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => $p['2c']],

        // ══ 3. KİTAP ══
        '3a' => ['baslik' => 'BKCI kapsamındaki kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
        '3b' => ['baslik' => 'BKCI kapsamındaki kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 10],
        '3c' => ['baslik' => 'Diğer uluslararası ya da ulusal kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Çeviri Kitap'], 'puan' => 5],
        '3d' => ['baslik' => 'Diğer uluslararası ya da ulusal kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi', 'Çeviri Kitap Bölümü'], 'puan' => 3],

        // ══ 4. ATIF ══
        '4a' => ['baslik' => 'SCIE, SSCI, AHCI, ESCI ya da Scopus kapsamında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
        '4b' => ['baslik' => 'BKCI kapsamındaki kitapta yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
        '4c' => ['baslik' => 'TR Dizin kapsamındaki dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
        '4d' => ['baslik' => 'Diğer uluslararası ya da ulusal kitap veya dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],

        // ══ 5. LİSANSÜSTÜ TEZ DANIŞMANLIĞI ══
        '5a' => ['baslik' => 'Danışmanlığınızda tamamlanan doktora ya da uzmanlık tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 5],
        '5a-es' => ['baslik' => 'Eş danışmanlığınızda tamamlanan doktora ya da uzmanlık tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 2],
        '5b' => ['baslik' => 'Danışmanlığınızda tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 3],
        '5b-es' => ['baslik' => 'Eş danışmanlığınızda tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 1],

        // ══ 6. PROJE ══
        '6a-yur' => ['baslik' => 'AB Çerçeve Programı ya da TÜBİTAK destekli, başarı ile tamamlanmış projede koordinatör veya yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => $PROJE_AB, 'roller' => ['yurutucu'], 'puan' => $p['6a1']],
        '6a-ars' => ['baslik' => 'AB Çerçeve Programı ya da TÜBİTAK destekli, başarı ile tamamlanmış projede araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => $PROJE_AB, 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => $p['6a2']],
        '6a-dan' => ['baslik' => 'AB Çerçeve Programı ya da TÜBİTAK destekli, başarı ile tamamlanmış projede danışman olmak', 'kategori' => 'proje', 'kaynaklar' => $PROJE_AB, 'roller' => ['danisman'], 'puan' => 5],
        '6b' => ['baslik' => 'Başarı ile tamamlanmış uluslararası destekli bilimsel araştırma projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'puan' => 10],
        '6b-yd' => ['baslik' => 'Başarı ile tamamlanmış uluslararası destekli bilimsel araştırma projesinde yürütücü ya da danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu', 'danisman'], 'puan' => 10],
        '6c' => ['baslik' => 'Kamu kurumu ya da özel kuruluşla yapılan, başarı ile tamamlanmış Ar-Ge projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => $PROJE_KAMU, 'puan' => 7],
        '6c-yd' => ['baslik' => 'Kamu kurumu ya da özel kuruluşla yapılan, başarı ile tamamlanmış Ar-Ge projesinde yürütücü ya da danışman olmak', 'kategori' => 'proje', 'kaynaklar' => $PROJE_KAMU, 'roller' => ['yurutucu', 'danisman'], 'puan' => 7],
        '6d' => ['baslik' => 'Üniversitedeki BAP projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 3],
        '6e' => ['baslik' => 'TÜBİTAK öğrenci projelerinde ya da TEKNOFEST gibi jürili öğrenci yarışmalarında eğitmen, danışman veya yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'puan' => 3],

        // ══ 7. BİLİMSEL TOPLANTI ══
        '7a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan, tam metni ya da özeti CPCI\'da yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 5],
        '7b' => ['baslik' => 'Diğer uluslararası ya da ulusal bilimsel toplantıda sunulan, tam metni veya özeti yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Uluslararası Özet/Poster', 'Ulusal Tam Metin', 'Ulusal Özet/Poster'], 'puan' => 3],

        // ══ 8. EĞİTİM-ÖĞRETİM FAALİYETLERİ ══
        '8-ders' => ['baslik' => 'Lisansüstü, lisans, ön lisans, hazırlık ya da formasyon programında verilen her bir ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 2],

        // ══ 9. PATENT / FAYDALI MODEL ══
        '9a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
        '9b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 10],
        '9c' => ['baslik' => 'Tescil edilmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Islahçı Hakkı / Çeşit Tescili', 'Endüstriyel Tasarım'], 'puan' => 5],

        // ══ 10. ÖDÜL ══ (altı bendin de puanı 25)
        '10a-f' => ['baslik' => 'YÖK Yılın Doktora Tezi, YÖK Üstün Başarı, TÜBİTAK Bilim, TÜBİTAK Teşvik, TÜBA GEBİP ya da TÜBA TESEP ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 25],

        // ══ 11. EDİTÖRLÜK ══
        '11a' => ['baslik' => 'SCIE, SSCI, AHCI, ESCI ya da Scopus kapsamındaki dergide editörlük veya alan editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => $WOS_DERGI, 'puan' => 10],
        '11b' => ['baslik' => 'BKCI ya da Scopus kapsamındaki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 5],
        '11c' => ['baslik' => 'TR Dizin kapsamındaki dergide editörlük veya alan editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 5],

        // ══ DİĞER FAALİYETLER ══
        "{$dp}c" => ['baslik' => 'Uluslararası bilimsel toplantıya davetli konuşmacı olarak katılmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 2],
        "{$dp}e" => ['baslik' => 'Üniversitede faaliyet gösteren komisyonlarda görev almak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 3],
        "{$dp}f" => ['baslik' => 'Sosyal sorumluluk koordinatörlüğünce kabul edilen projelerde görev almak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi'], 'puan' => 2],
        "{$dp}g" => ['baslik' => 'Üniversitenin düzenlediği kongre ya da sempozyumlarda görev almak', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 2],
        "{$dp}h" => ['baslik' => 'Panel, konferans, seminer, çalıştay gibi etkinliklerde konuşmacı olmak ya da basın yayın organlarında uzmanlık alanınızla ilgili konuşma yapmak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Bilim İletişimi / Popüler Yayın'], 'puan' => 2],
        "{$dp}i" => ['baslik' => 'Bilimsel, sanatsal ya da proje yarışmalarında akademik danışmanlık, hakemlik veya jüri üyeliği yapmak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı'], 'puan' => 2],
        "{$dp}j" => ['baslik' => 'İdari görev yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => $IDARI, 'puan' => 2],
        "{$dp}k" => ['baslik' => 'Bilimsel dergilerde dil, mizanpaj ya da istatistik editörlüğü, redaktörlük gibi görevler almak', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 2],
        "{$dp}l" => ['baslik' => 'Kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 3],
        "{$dp}m" => ['baslik' => 'Bilimsel dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik', 'Diğer Hakemli Dergi'], 'puan' => 1],
    ];

    $gruplar = [
        'MAKALE-A' => ['1a-Q1', '1a-Q2', '1a-Q3', '1a-Q4'],
        'MAKALE-A-NOQ4' => ['1a-Q1', '1a-Q2', '1a-Q3'],
        'MAKALE-Q12' => ['1a-Q1', '1a-Q2'],
        'MAKALE-ABC' => ['1a-Q1', '1a-Q2', '1a-Q3', '1a-Q4', '1b', '1c'],
        'MAKALE-ULUSLARARASI' => ['1a-Q1', '1a-Q2', '1a-Q3', '1a-Q4', '1b', '1c', '1d', '1e'],
        'MAKALE-ULUSAL' => ['2a', '2b', '2c'],
        'KITAP' => ['3a', '3b', '3c', '3d'],
        'KITAP-CD' => ['3c', '3d'],
        'ATIF' => ['4a', '4b', '4c', '4d'],
        'TEZ' => ['5a', '5a-es', '5b', '5b-es'],
        'PROJE' => ['6a-yur', '6a-ars', '6a-dan', '6b', '6c', '6d', '6e'],
        'PROJE-ABCD' => ['6a-yur', '6a-ars', '6a-dan', '6b', '6c', '6d'],
        'PROJE-ABCD-YD' => ['6a-yur', '6a-dan', '6b-yd', '6c-yd', '6d'],
        'PROJE-E' => ['6e'],
        'BILDIRI' => ['7a', '7b'],
        'EGITIM' => ['8-ders'],
        'EDITORLUK' => ['11a', '11b', '11c'],
        'DIGER' => ["{$dp}c", "{$dp}e", "{$dp}f", "{$dp}g", "{$dp}h", "{$dp}i", "{$dp}j", "{$dp}k", "{$dp}l", "{$dp}m"],
    ];

    return ['maddeler' => $maddeler, 'gruplar' => $gruplar, 'grup_tavanlari' => $tavan];
};

/**
 * B ailesi (Filoloji, Hukuk, İlahiyat, Mimarlık, Sosyal) cetvel gövdesi.
 *
 * @param  array<string, int>  $p
 * @param  array<string, int>  $tavan
 * @return array<string, mixed>
 */
$aileB = function (array $p, array $tavan, string $dp, bool $tasarim) use ($SCI, $TAM, $KISA, $WOS_DERGI, $IDARI, $PROJE_AB, $PROJE_KAMU): array {
    $maddeler = [
        // ══ 1. MAKALE ══
        '1a-Q1' => ['baslik' => 'SCIE ya da SSCI kapsamındaki Q1 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $TAM, 'puan' => 30],
        '1a-Q2' => ['baslik' => 'SCIE ya da SSCI kapsamındaki Q2 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $TAM, 'puan' => 20],
        '1a-Q3' => ['baslik' => 'SCIE ya da SSCI kapsamındaki Q3 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $TAM, 'puan' => 15],
        '1a-Q4' => ['baslik' => 'SCIE ya da SSCI kapsamındaki Q4 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $TAM, 'puan' => 10],
        '1b' => ['baslik' => 'AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => $TAM, 'puan' => 20],
        '1c' => ['baslik' => 'ESCI ya da Scopus kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $TAM, 'puan' => 10],
        '1d' => ['baslik' => 'TR Dizin kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TAM, 'puan' => 10],
        '1e' => ['baslik' => 'Diğer uluslararası ya da ulusal indekslerde taranan dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => 5],
        '1f' => ['baslik' => 'Hakemli dergide yayımlanmış editöre mektup, araştırma notu, özet ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => [...$SCI, 'AHCI', 'ESCI / Scopus', 'TR Dizin', 'Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 3],

        // ══ 2. KİTAP ══
        '2a' => ['baslik' => 'BKCI ya da Scopus kapsamındaki kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
        '2b' => ['baslik' => 'BKCI ya da Scopus kapsamındaki kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 10],
        '2c' => ['baslik' => 'Diğer uluslararası ya da ulusal kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Çeviri Kitap'], 'puan' => $p['2c']],
        '2d' => ['baslik' => 'Diğer uluslararası ya da ulusal kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi', 'Çeviri Kitap Bölümü'], 'puan' => $p['2d']],

        // ══ 3. ATIF ══
        '3a' => ['baslik' => 'SCIE, SSCI, AHCI, ESCI ya da Scopus kapsamında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
        '3b' => ['baslik' => 'BKCI kapsamındaki kitapta yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
        '3c' => ['baslik' => 'TR Dizin kapsamındaki dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
        '3d' => ['baslik' => 'Diğer uluslararası ya da ulusal kitap veya dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],

        // ══ 4. LİSANSÜSTÜ TEZ DANIŞMANLIĞI ══
        '4a' => ['baslik' => 'Danışmanlığınızda tamamlanan doktora ya da uzmanlık tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 5],
        '4a-es' => ['baslik' => 'Eş danışmanlığınızda tamamlanan doktora ya da uzmanlık tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 2],
        '4b' => ['baslik' => 'Danışmanlığınızda tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 3],
        '4b-es' => ['baslik' => 'Eş danışmanlığınızda tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 1],

        // ══ 5. PROJE ══
        '5a-yur' => ['baslik' => 'AB Çerçeve Programı ya da TÜBİTAK destekli, başarı ile tamamlanmış projede koordinatör veya yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => $PROJE_AB, 'roller' => ['yurutucu'], 'puan' => $p['5a1']],
        '5a-ars' => ['baslik' => 'AB Çerçeve Programı ya da TÜBİTAK destekli, başarı ile tamamlanmış projede araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => $PROJE_AB, 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => $p['5a2']],
        '5a-dan' => ['baslik' => 'AB Çerçeve Programı ya da TÜBİTAK destekli, başarı ile tamamlanmış projede danışman olmak', 'kategori' => 'proje', 'kaynaklar' => $PROJE_AB, 'roller' => ['danisman'], 'puan' => 5],
        '5b' => ['baslik' => 'Başarı ile tamamlanmış uluslararası destekli bilimsel araştırma projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'puan' => 10],
        '5b-yd' => ['baslik' => 'Başarı ile tamamlanmış uluslararası destekli bilimsel araştırma projesinde yürütücü ya da danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu', 'danisman'], 'puan' => 10],
        '5c' => ['baslik' => 'Kamu kurumu ya da özel kuruluşla yapılan, başarı ile tamamlanmış Ar-Ge projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => $PROJE_KAMU, 'puan' => 7],
        '5c-yd' => ['baslik' => 'Kamu kurumu ya da özel kuruluşla yapılan, başarı ile tamamlanmış Ar-Ge projesinde yürütücü ya da danışman olmak', 'kategori' => 'proje', 'kaynaklar' => $PROJE_KAMU, 'roller' => ['yurutucu', 'danisman'], 'puan' => 7],
        '5d' => ['baslik' => 'Üniversitedeki BAP projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 3],
        '5e' => ['baslik' => 'TÜBİTAK öğrenci projelerinde ya da TEKNOFEST gibi jürili öğrenci yarışmalarında eğitmen, danışman veya yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'puan' => 3],

        // ══ 6. BİLİMSEL TOPLANTI ══
        '6a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan, tam metni ya da özeti CPCI\'da yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 5],
        '6b' => ['baslik' => 'Diğer uluslararası ya da ulusal bilimsel toplantıda sunulan, tam metni veya özeti yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Uluslararası Özet/Poster', 'Ulusal Tam Metin', 'Ulusal Özet/Poster'], 'puan' => 3],

        // ══ 7. EĞİTİM-ÖĞRETİM FAALİYETLERİ ══
        '7-ders' => ['baslik' => 'Lisansüstü, lisans, ön lisans, hazırlık ya da formasyon programında verilen her bir ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 2],

        // ══ 8. PATENT / FAYDALI MODEL ══
        '8a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
        '8b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 10],
        '8c' => ['baslik' => 'Tescil edilmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 5],

        // ══ 9. ÖDÜL ══
        '9a-f' => ['baslik' => 'YÖK Yılın Doktora Tezi, YÖK Üstün Başarı, TÜBİTAK Bilim, TÜBİTAK Teşvik, TÜBA GEBİP ya da TÜBA TESEP ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 25],

        // ══ 10. EDİTÖRLÜK ══
        '10a' => ['baslik' => 'SCIE, SSCI, AHCI, ESCI ya da Scopus kapsamındaki dergide editörlük veya alan editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => $WOS_DERGI, 'puan' => 10],
        '10b' => ['baslik' => 'BKCI ya da Scopus kapsamındaki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 5],
        '10c' => ['baslik' => 'TR Dizin kapsamındaki dergide editörlük veya alan editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 5],

        // ══ DİĞER FAALİYETLER ══
        "{$dp}c" => ['baslik' => 'Uluslararası bilimsel toplantıya davetli konuşmacı olarak katılmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 2],
        "{$dp}e" => ['baslik' => 'Üniversitede faaliyet gösteren komisyonlarda görev almak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 3],
        "{$dp}f" => ['baslik' => 'Sosyal sorumluluk koordinatörlüğünce kabul edilen projelerde görev almak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi'], 'puan' => 2],
        "{$dp}g" => ['baslik' => 'Üniversitenin düzenlediği kongre ya da sempozyumlarda görev almak', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 2],
        "{$dp}h" => ['baslik' => 'Panel, konferans, seminer, çalıştay gibi etkinliklerde konuşmacı olmak ya da basın yayın organlarında uzmanlık alanınızla ilgili konuşma yapmak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Bilim İletişimi / Popüler Yayın'], 'puan' => 2],
        "{$dp}i" => ['baslik' => 'Bilimsel, sanatsal ya da proje yarışmalarında akademik danışmanlık, hakemlik veya jüri üyeliği yapmak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı'], 'puan' => 2],
        "{$dp}j" => ['baslik' => 'İdari görev yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => $IDARI, 'puan' => 2],
        "{$dp}k" => ['baslik' => 'Bilimsel dergilerde dil, mizanpaj ya da istatistik editörlüğü, redaktörlük gibi görevler almak', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 2],
        "{$dp}l" => ['baslik' => 'Kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 3],
        "{$dp}m" => ['baslik' => 'Bilimsel dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik', 'Diğer Hakemli Dergi'], 'puan' => 1],
    ];

    if ($tasarim) {
        // Mimarlık tablosunun 11. maddesi: Tasarım/Planlama/Koruma Projesi,
        // Yarışma ve Yazılım. Doçentlik ve profesörlükte zorunlu.
        $maddeler['11a'] = ['baslik' => 'Mimarlık, planlama, kentsel tasarım, peyzaj, iç mimari ya da endüstri ürünleri tasarımı yarışmasında ödül veya mansiyon alan ekipte yer almak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 15];
        $maddeler['11b'] = ['baslik' => 'Uygulanmış ya da tamamlanmış tasarım, planlama veya koruma projesi hakkında makale, kitap bölümü veya kitap yazılmış olmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip'], 'puan' => 10];
        $maddeler['11c'] = ['baslik' => 'Proje ve yapım yönetimi, tasarım ya da planlama alanlarında yazılım üreticisi olmak', 'kategori' => 'patent', 'kaynaklar' => ['Yazılım'], 'puan' => 15];
    }

    $gruplar = [
        'MAKALE-A' => ['1a-Q1', '1a-Q2', '1a-Q3', '1a-Q4'],
        'MAKALE-Q12' => ['1a-Q1', '1a-Q2'],
        'MAKALE-Q123' => ['1a-Q1', '1a-Q2', '1a-Q3'],
        'MAKALE-ABC' => ['1a-Q1', '1a-Q2', '1a-Q3', '1a-Q4', '1b', '1c'],
        'MAKALE-ABCD' => ['1a-Q1', '1a-Q2', '1a-Q3', '1a-Q4', '1b', '1c', '1d'],
        'MAKALE' => ['1a-Q1', '1a-Q2', '1a-Q3', '1a-Q4', '1b', '1c', '1d', '1e', '1f'],
        'MAKALE-EF' => ['1e', '1f'],
        'KITAP' => ['2a', '2b', '2c', '2d'],
        'KITAP-AC' => ['2a', '2c'],
        'KITAP-CD' => ['2c', '2d'],
        'KITAP-D' => ['2d'],
        'ATIF' => ['3a', '3b', '3c', '3d'],
        'TEZ' => ['4a', '4a-es', '4b', '4b-es'],
        'PROJE' => ['5a-yur', '5a-ars', '5a-dan', '5b', '5c', '5d', '5e'],
        'PROJE-ABCD' => ['5a-yur', '5a-ars', '5a-dan', '5b', '5c', '5d'],
        'PROJE-ABCD-YD' => ['5a-yur', '5a-dan', '5b-yd', '5c-yd', '5d'],
        'PROJE-E' => ['5e'],
        'BILDIRI' => ['6a', '6b'],
        'EGITIM' => ['7-ders'],
        'EDITORLUK' => ['10a', '10b', '10c'],
        'DIGER' => ["{$dp}c", "{$dp}e", "{$dp}f", "{$dp}g", "{$dp}h", "{$dp}i", "{$dp}j", "{$dp}k", "{$dp}l", "{$dp}m"],
    ];

    if ($tasarim) {
        $gruplar['TASARIM'] = ['11a', '11b', '11c'];
    }

    return ['maddeler' => $maddeler, 'gruplar' => $gruplar, 'grup_tavanlari' => $tavan];
};

// Tablo dipnotu (bütün tablolarda aynı): "Tek yazarlı yayınlarda (makale,
// bildiri ve kitap) yazar tam puan alır. Çok yazarlı yayınlarda puan
// yazarlar arasında eşit olarak bölünür."
$yazarKatsayisi = [
    'haric' => ['atif', 'proje', 'patent', 'tez_danismanligi', 'egitim_ogretim', 'odul',
        'idari_gorev', 'toplumsal_katki', 'diger', 'editorluk', 'sanatsal_etkinlik'],
    'bol' => ['pay' => 1.0],
];

$kapsamNotu = 'Puanlar Sinop Üniversitesi Öğretim Üyeliğine Yükseltilme ve Atanma Ölçütleri '
    .'Yönergesinin temel alan tablolarından (SNÜ-YNG-011, 01.10.2025 yürürlük). Yazar çarpanı '
    .'tablo dipnotundan: tek yazarlı makale, bildiri ve kitapta tam puan, çok yazarlıda puan '
    .'yazarlar arasında eşit bölünür. Yazar listesini boş bırakırsanız çarpan hiç uygulanmaz ve '
    .'puanınız olduğundan YÜKSEK görünür. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: Sinop Üniversitesinde gerçekleştirilen '
    .'bilimsel toplantı satırı (4 puan) girilmedi, bildirileriniz diğer toplantı satırından '
    .'(3 puan) sayılıyor; Sinop Üniversitesi dergilerinde editörlük (5 puan), değerlendirmeye '
    .'alınmış patent başvurusu (2 puan), h-indeksi (5 puan), yurt dışı araştırma (4 puan), '
    .'öğrenci kulübü danışmanlığı (3 puan) ve Sürekli Eğitim Merkezi dersi (3 puan) satırları '
    .'sözlükte karşılıksız olduğu için girilmedi. Rolü girilmemiş AB Çerçeve ve TÜBİTAK '
    .'projeleri 0 puan alır; rolü mutlaka seçin. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünür: aynı dergideki en fazla üç çalışmanın, '
    .'aynı bilimsel toplantıdaki en fazla iki çalışmanın ve aynı kitaptaki tek bölümün '
    .'puanlanması kuralları uygulanmıyor; ders kitapları da kitap satırlarından sayılıyor.';

/**
 * Alan başına değişen puanlar ve tavanlar.
 * A ailesi: 2b/2c ulusal makale puanı, 6a proje rol puanları.
 * B ailesi: 2c/2d kitap puanı, 5a proje rol puanları.
 */
$cetveller = [];

$aTanimlar = [
    'egitim' => [['2b' => 4, '2c' => 2, '6a1' => 20, '6a2' => 15], ['KITAP-CD' => 10, 'BILDIRI' => 15, 'EGITIM' => 20, 'DIGER' => 15], '12'],
    'fen' => [['2b' => 4, '2c' => 2, '6a1' => 15, '6a2' => 10], ['KITAP-CD' => 10, 'BILDIRI' => 15, 'EGITIM' => 15, 'DIGER' => 15], '12'],
    'muhendislik' => [['2b' => 4, '2c' => 2, '6a1' => 15, '6a2' => 10], ['KITAP-CD' => 10, 'BILDIRI' => 15, 'EGITIM' => 15, 'DIGER' => 15], '12'],
    'saglik' => [['2b' => 4, '2c' => 2, '6a1' => 15, '6a2' => 10], ['KITAP-CD' => 10, 'BILDIRI' => 15, 'EGITIM' => 15, 'DIGER' => 15], '12'],
    'spor' => [['2b' => 6, '2c' => 4, '6a1' => 15, '6a2' => 10], ['KITAP-CD' => 10, 'BILDIRI' => 15, 'EGITIM' => 15, 'DIGER' => 15], '13'],
    'ziraat' => [['2b' => 4, '2c' => 2, '6a1' => 15, '6a2' => 10], ['KITAP-CD' => 10, 'BILDIRI' => 15, 'EGITIM' => 15, 'DIGER' => 15], '12'],
];

foreach ($aTanimlar as $alan => [$p, $tavan, $dp]) {
    $cetveller["sinop-2025-{$alan}"] = [
        'kapsam_notu' => $kapsamNotu,
        'yazar_katsayisi' => $yazarKatsayisi,
        ...$aileA($p, $tavan, $dp),
    ];
}

$bTanimlar = [
    'filoloji' => [['2c' => 20, '2d' => 5, '5a1' => 20, '5a2' => 15], ['MAKALE-EF' => 10, 'TEZ' => 20, 'BILDIRI' => 15, 'EGITIM' => 20, 'DIGER' => 15], '11', false],
    'hukuk' => [['2c' => 20, '2d' => 10, '5a1' => 20, '5a2' => 15], ['MAKALE-EF' => 10, 'KITAP-D' => 10, 'TEZ' => 20, 'BILDIRI' => 10, 'EGITIM' => 20, 'DIGER' => 15], '11', false],
    'ilahiyat' => [['2c' => 20, '2d' => 5, '5a1' => 20, '5a2' => 15], ['MAKALE-EF' => 10, 'KITAP-CD' => 20, 'TEZ' => 20, 'BILDIRI' => 10, 'EGITIM' => 20, 'EDITORLUK' => 20, 'DIGER' => 15], '12', false],
    'mimarlik' => [['2c' => 5, '2d' => 3, '5a1' => 20, '5a2' => 15], ['MAKALE-EF' => 5, 'KITAP-CD' => 5, 'TEZ' => 20, 'BILDIRI' => 15, 'EGITIM' => 20, 'DIGER' => 15], '12', true],
    'sosyal' => [['2c' => 5, '2d' => 3, '5a1' => 20, '5a2' => 15], ['MAKALE-EF' => 10, 'KITAP-D' => 6, 'TEZ' => 20, 'BILDIRI' => 10, 'EGITIM' => 20, 'DIGER' => 15], '11', false],
];

foreach ($bTanimlar as $alan => [$p, $tavan, $dp, $tasarim]) {
    $cetveller["sinop-2025-{$alan}"] = [
        'kapsam_notu' => $kapsamNotu,
        'yazar_katsayisi' => $yazarKatsayisi,
        ...$aileB($p, $tavan, $dp, $tasarim),
    ];
}

return ['cetveller' => $cetveller];
