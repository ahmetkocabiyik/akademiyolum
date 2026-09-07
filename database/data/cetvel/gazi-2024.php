<?php

/**
 * GAZİ ÜNİVERSİTESİ — EK-1 Etkinlikler ve Puanlama Tablosu
 * Kaynak: pdf/17536994742.gaziuniverstesi.pdf (01.01.2024 kalıcı sürüm)
 *
 * MADDE KODLARI yönergenin kendi numaralandırmasıdır; zorunlu kriterler
 * doğrudan bunlara atıf yapıyor ("MAKALELER etkinliğinden 1a-c kapsamında en
 * az dört yayının olması şartıyla 1-5 kapsamında en az 200 puan almak").
 *
 * MAKALELER 1-5 BEŞ AYRI TÜRÜ AYNI ÇEYREKLİK KIRILIMIYLA PUANLIYOR:
 *   1. özgün araştırma makalesi   40/35/30/20
 *   2. derleme                    40/35/30/20
 *   3. kısa makale                35/30/25/15
 *   4. vaka incelemesi, teknik not, editöre mektup, kitap incelemesi  20/15/10/5
 *   5. kongre bildirisi (WoS dergide)  20/10, 15/7, 10/5, 5/3
 *
 * 1-4 blokları `turler` alanıyla girildi: aynı dergideki çalışma türüne göre
 * ayrı puanlanıyor. Faaliyetin türü girilmemişse özgün araştırma makalesi
 * sayılır (formun varsayılanı da bu).
 *
 * 5. blok (WoS dergide kongre bildirisi) GİRİLMEDİ: değerleri "20/10" gibi
 * tam metin/özet ikilisi ve bildiri kategorisiyle çakışıyor.
 *
 * GİRİLMEYEN BÖLÜMLER: EĞİTİM/ÖĞRETİM (tavan 20 puan), idari görevler ve
 * ödüller — kaynak sözlüğünde karşılığı olmayan ya da metrik olan kalemler.
 * Hesaplanan toplam bu kadar EKSİK kalabilir, fazla değil.
 */

return [
    'kapsam_notu' => 'Puanlar Gazi Üniversitesi EK-1 tablosundan (01.01.2024 sürümü). '
        .'Eğitim-öğretim ve idari görev kalemleri hesaba katılmadı. Gerçek toplamınız burada '
        .'görünenden yüksek olabilir, düşük olamaz.',

    'maddeler' => [
        // ── MAKALELER 1 · WoS özgün araştırma makalesi ──
        '1a' => ['baslik' => 'WoS Q1 dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale'], 'puan' => 40],
        '1b' => ['baslik' => 'WoS Q2 dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale'], 'puan' => 35],
        '1c' => ['baslik' => 'WoS Q3 dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale'], 'puan' => 30],
        '1d' => ['baslik' => 'WoS Q4 dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => ['ozgun_makale'], 'puan' => 20],

        // ── MAKALELER 2-4 · aynı dergiler, farklı yayın türü ──
        // `turler` boyutu eklenene kadar girilemiyorlardı.
        '2a' => ['baslik' => 'WoS Q1 dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['derleme'], 'puan' => 40],
        '2b' => ['baslik' => 'WoS Q2 dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['derleme'], 'puan' => 35],
        '2c' => ['baslik' => 'WoS Q3 dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['derleme'], 'puan' => 30],
        '2d' => ['baslik' => 'WoS Q4 dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => ['derleme'], 'puan' => 20],
        '3a' => ['baslik' => 'WoS Q1 dergide kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['kisa_makale'], 'puan' => 35],
        '3b' => ['baslik' => 'WoS Q2 dergide kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['kisa_makale'], 'puan' => 30],
        '3c' => ['baslik' => 'WoS Q3 dergide kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['kisa_makale'], 'puan' => 25],
        '3d' => ['baslik' => 'WoS Q4 dergide kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => ['kisa_makale'], 'puan' => 15],
        '4a' => ['baslik' => 'WoS Q1 dergide vaka incelemesi, teknik not, editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['vaka_teknik_not'], 'puan' => 20],
        '4b' => ['baslik' => 'WoS Q2 dergide vaka incelemesi, teknik not, editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['vaka_teknik_not'], 'puan' => 15],
        '4c' => ['baslik' => 'WoS Q3 dergide vaka incelemesi, teknik not, editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['vaka_teknik_not'], 'puan' => 10],
        '4d' => ['baslik' => 'WoS Q4 dergide vaka incelemesi, teknik not, editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => ['vaka_teknik_not'], 'puan' => 5],

        // ── MAKALELER 6-9 · çeyrekliksiz indeks kümeleri ──
        // 6-9 bölümlerinin de 1-4'teki gibi tam a/b/c/d merdiveni var (özgün
        // makale · derleme · kısa makale · vaka incelemesi-teknik not-editöre
        // mektup-kitap incelemesi); yalnız "a" satırı girilmiş ve tür kısıtı
        // olmadığı için editöre mektup kaydeden aday SCOPUS'ta 5 yerine 20
        // puan alıyordu (§0 ihlali). a ve b aynı puanda olduğu için tek
        // satırda birleştirildi.
        '6a' => ['baslik' => 'WoS All Databases / SCOPUS dergide özgün araştırma makalesi ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 20],
        '6c' => ['baslik' => 'WoS All Databases / SCOPUS dergide kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['kisa_makale'], 'puan' => 15],
        '6d' => ['baslik' => 'WoS All Databases / SCOPUS dergide vaka incelemesi, teknik not, editöre mektup ya da kitap incelemesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['vaka_teknik_not'], 'puan' => 5],
        '6e-tam' => ['baslik' => 'SCOPUS dergide kongre bildirisi tam metni', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 5],
        '6e-ozet' => ['baslik' => 'SCOPUS dergide kongre bildirisi özeti', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 3],
        '7a' => ['baslik' => 'Uluslararası alan indeksli dergide özgün araştırma makalesi ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 20],
        '7c' => ['baslik' => 'Uluslararası alan indeksli dergide kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['kisa_makale'], 'puan' => 15],
        '7d' => ['baslik' => 'Uluslararası alan indeksli dergide vaka incelemesi, teknik not, editöre mektup ya da kitap incelemesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['vaka_teknik_not'], 'puan' => 5],
        '8a' => ['baslik' => 'TR-Dizin veya diğer uluslararası indeksli dergide özgün araştırma makalesi ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 15],
        '8c' => ['baslik' => 'TR-Dizin veya diğer uluslararası indeksli dergide kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['kisa_makale'], 'puan' => 10],
        '8d' => ['baslik' => 'TR-Dizin veya diğer uluslararası indeksli dergide vaka incelemesi, teknik not, editöre mektup ya da kitap incelemesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['vaka_teknik_not'], 'puan' => 4],
        '8e-tam' => ['baslik' => 'TR-Dizin dergide kongre bildirisi tam metni', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 4],
        '8e-ozet' => ['baslik' => 'TR-Dizin dergide kongre bildirisi özeti', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 2],
        '9a' => ['baslik' => 'Üniversite Senatosunca kabul edilmiş uluslararası dergide özgün araştırma makalesi ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 6],
        '9c' => ['baslik' => 'Üniversite Senatosunca kabul edilmiş uluslararası dergide kısa makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['kisa_makale'], 'puan' => 3],
        '9d' => ['baslik' => 'Üniversite Senatosunca kabul edilmiş uluslararası dergide vaka incelemesi, teknik not, editöre mektup ya da kitap incelemesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['vaka_teknik_not'], 'puan' => 2],

        // ── KİTAP ── (bölüm tavanı 60 puan)
        'K1a' => ['baslik' => 'Uluslararası yayınevinden yabancı dilde kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 60],
        'K1b' => ['baslik' => 'Uluslararası yayınevinden yabancı dilde kitap bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 15],
        'K1d' => ['baslik' => 'Yabancı dilde yayımlanan bilimsel kitap çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 20],
        'K1e' => ['baslik' => 'Yabancı dilde yayımlanan bilimsel kitap bölümü çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 5],
        'K1g' => ['baslik' => 'Türkçe yayımlanan bilimsel/mesleki kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 30],
        'K1h' => ['baslik' => 'Türkçe yayımlanan bilimsel/mesleki kitap bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 10],
        'K2h' => ['baslik' => 'Tahkikli neşir / araştırma notu / detaylı kitap kritiği', 'kategori' => 'kitap', 'kaynaklar' => ['Tahkik (Tenkitli Metin)'], 'puan' => 5],

        // Kitap editörlükleri editörlük kategorisinde:
        'K1f' => ['baslik' => 'Yabancı dilde yayımlanan bilimsel kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 30],
        'K2f' => ['baslik' => 'Ulusal yayınevinden bilimsel/mesleki kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 15],

        // ── PROJELER ── (yönergede "30/15" = yürütücü/araştırmacı)
        'Pa-y' => ['baslik' => 'NATO/NSF/AB Çerçeve destekli projede koordinatör veya yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 30],
        'Pa-a' => ['baslik' => 'NATO/NSF/AB Çerçeve destekli projede araştırmacı veya bursiyer', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],
        'Pb-y' => ['baslik' => 'Diğer uluslararası destekli projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 20],
        'Pb-a' => ['baslik' => 'Diğer uluslararası destekli projede araştırmacı veya bursiyer', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
        'Pc-y' => ['baslik' => 'TÜBİTAK/KOSGEB/Bakanlık destekli projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 20],
        'Pc-a' => ['baslik' => 'TÜBİTAK/KOSGEB/Bakanlık destekli projede araştırmacı, danışman veya bursiyer', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
        'Pd-y' => ['baslik' => 'Özel kurum destekli projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 15],
        'Pd-a' => ['baslik' => 'Özel kurum destekli projede araştırmacı, danışman veya bursiyer', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 5],
        'Pe-y' => ['baslik' => 'BAP destekli projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 5],
        'Pe-a' => ['baslik' => 'BAP destekli projede araştırmacı veya bursiyer', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 2],

        // ── BİLİMSEL/SANATSAL TOPLANTI ── (bölüm tavanı 40 puan)
        'Ta' => ['baslik' => 'Uluslararası bilimsel/sanatsal toplantıda davetli konuşmacı', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 12],
        'Kk' => ['baslik' => 'Kamu kurum ve kuruluşlarında uzmanlığınızla ilgili komisyonlarda görev (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dış Kuruluş Kurul Üyeliği (Ulusal)'], 'puan' => 2],
        'Kb2' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 8],
        'Kd2' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 5],
        'Ke2' => ['baslik' => 'Bilimsel toplantıda oturum başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Uluslararası)', 'Oturum Başkanlığı (Ulusal)'], 'puan' => 3],
    ],

    'gruplar' => [
        // Zorunlu kriterlerin birebir kullandığı atıflar.
        '1a-b' => ['1a', '1b'],
        '1a-c' => ['1a', '1b', '1c'],
        '1a-d' => ['1a', '1b', '1c', '1d'],
        '1-5' => ['1*', '2*', '3*', '4*'],
        '1-4 ve 6a' => ['1*', '2*', '3*', '4*', '6a'],
        '1-5, 6a-b, 7a-b' => ['1*', '2*', '3*', '4*', '6a', '7a'],
        '1-5, 6a-b, 7a-b, 8a-b' => ['1*', '2*', '3*', '4*', '6a', '7a', '8a'],
        '1a-d, 6a-b, 7a-b' => ['1a', '1b', '1c', '1d', '6a', '7a'],
        'KITAP 1a-k' => ['K1*'],
        // "PROJELER etkinliğinde (e maddesi hariç)" — BAP dışı projeler.
        'PROJE-e-haric' => ['Pa-y', 'Pa-a', 'Pb-y', 'Pb-a', 'Pc-y', 'Pc-a', 'Pd-y', 'Pd-a'],
        'PROJE-e-haric-yurutucu' => ['Pa-y', 'Pb-y', 'Pc-y', 'Pd-y'],
        'MAKALE' => ['1*', '6*', '7*', '8*', '9*'],
        'KITAP' => ['K*'],
    ],

    'grup_tavanlari' => [
        // "KİTAP (En fazla 60 puan alınabilir.)"
        'KITAP' => 60,
        // "BİLİMSEL/SANATSAL TOPLANTI (En fazla 40 puan alınabilir.)"
        'Ta' => 40,
    ],
];
