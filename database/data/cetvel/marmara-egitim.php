<?php

/**
 * MARMARA ÜNİVERSİTESİ — Tablo 1
 * "Eğitim Bilimleri ve Öğretmen Yetiştirme Temel Alanı Puanlama Formu"
 * Kaynak: pdf/17537003632.marmarauniverstesi.pdf (s. 12-13)
 *
 * MADDE NUMARALARI yönergenin kendi numaralandırmasıdır ve koşullar bunlara
 * ARALIK olarak atıf yapıyor: "en az 50 puanı 1-11 numaralı faaliyetlerinden
 * olmak üzere 17-27, 34-37, 49-50 faaliyetlerden toplam 70 puan" (md. 7/d-1).
 *
 * MAKALE VE DERLEME AYNI SATIRDA: Tablo 1, Tablo 2'den farklı olarak "makale
 * ve derleme" diyor ve ikisine aynı puanı veriyor. Bu yüzden 1/3/7/11
 * satırlarında `turler` kısıtı yok.
 *
 * TABLO 1'DE 51 ve 52 SATIRI YOK (diğer tablolardaki "diğer faaliyetler" ve
 * "görev süresi"). Spor Bilimleri bu tabloyu Tablo 7'nin ek satırlarıyla
 * birlikte kullanıyor; o birleşim marmara-spor.php'de.
 *
 * GİRİLMEYEN SATIRLAR: 27 (akademik organizasyon yöneticiliği ve
 * düzenleme kurulu üyeliği — kaynak sözlüğünde kongre düzenleme etiketi yok;
 * geniş bir "Diğer" kovasına bağlamak §0'a aykırı olurdu, fazla sayardı),
 * 16 (sorumlu yazar çarpanı) ve 43 (yükseltme jürisi
 * görevleri) — kayıt karşılığı yok. Tablo 8'in idari faaliyetleri de
 * girilmedi.
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 */

return [
    'kapsam_notu' => 'Puanlar Marmara Üniversitesi Tablo 1\'den (Eğitim Bilimleri ve Öğretmen '
        .'Yetiştirme). Belge 2018 öncesi terminoloji kullanıyor; kadro adları güncel '
        .'karşılıklarına eşlendi. Akademik organizasyon yöneticiliği (27), sorumlu yazar çarpanı, yükseltme jürisi görevleri ve idari '
        .'faaliyetler (Tablo 8) girilmedi. Gerçek toplamınız burada görünenden yüksek '
        .'olabilir, düşük olamaz.',

    'maddeler' => [
        // ── MAKALE ve DERLEME ── (1-15) · Tablo 1 ikisini ayırmıyor
        '1' => ['baslik' => 'Birincil indekslerde taranan dergide makale veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'puan' => 48],
        '3' => ['baslik' => 'İkincil indekslerde taranan dergide makale veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 36],
        '7' => ['baslik' => 'Hakemli ulusal dergide yabancı dilde makale veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'puan' => 20],
        '11' => ['baslik' => 'Hakemli ulusal dergide Türkçe makale veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 18],
        '15' => ['baslik' => 'Hakemsiz dergide makale veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 5],

        // ── LİSANSÜSTÜ TEZDEN ÜRETİLMİŞ YAYINLAR ── (yarım puan)
        // Md. 7/d-1 dipnotu: "Yaptığı lisansüstü tez(ler)den üretilen yayınlar
        // ölçütlerde gösterilen mevcut puanın YARISI ile değerlendirilir."
        // Kayıt tezden üretilmiş yayını `tez_yayini` kategorisinde ayrı
        // tuttuğu için kural yazılabiliyor: her satır karşılığının yarısı.
        // Kural YALNIZ Eğitim Bilimleri bendinde geçiyor; Spor da Tablo 1'i
        // kullanıyor ama kendi bendinde (7/d-11) böyle bir hüküm yok, o
        // yüzden marmara-spor.php'de bu satırlar yok.
        '1-tez' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, birincil indeksli dergide makale veya derleme', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 24],
        '3-tez' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, ikincil indeksli dergide makale veya derleme', 'kategori' => 'tez_yayini', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 18],
        '11-tez' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, hakemli ulusal dergide makale veya derleme', 'kategori' => 'tez_yayini', 'kaynaklar' => ['TR Dizin'], 'puan' => 9],
        '15-tez' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, hakemsiz dergide makale veya derleme', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Diğer'], 'puan' => 2],
        '17-tez' => ['baslik' => 'Lisansüstü tezinizden üretilmiş uluslararası kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 50],
        '18-tez' => ['baslik' => 'Lisansüstü tezinizden üretilmiş uluslararası kitapta bölüm', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 30],
        '19-tez' => ['baslik' => 'Lisansüstü tezinizden üretilmiş ulusal kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 35],
        '20-tez' => ['baslik' => 'Lisansüstü tezinizden üretilmiş ulusal kitapta bölüm', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 10],
        '23-tez' => ['baslik' => 'Lisansüstü tezinizden üretilmiş uluslararası kongre bildirisi', 'kategori' => 'tez_yayini', 'kaynaklar' => ['CPCI Bildiri'], 'puan' => 12],

        // ── KİTAP ── (17-21)
        '17' => ['baslik' => 'Uzmanlık alanında uluslararası kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 100],
        '18' => ['baslik' => 'Uzmanlık alanında uluslararası kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 60],
        '18b' => ['baslik' => 'Uzmanlık alanında uluslararası kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 60],
        '19' => ['baslik' => 'Uzmanlık alanında ulusal kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı'], 'puan' => 70],
        '20' => ['baslik' => 'Uzmanlık alanında ulusal kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 20],
        '20b' => ['baslik' => 'Uzmanlık alanında ulusal kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 20],
        '21' => ['baslik' => 'Uzmanlık alanında kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 50],
        '21b' => ['baslik' => 'Uzmanlık alanında makale veya bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 15],

        // ── BİLDİRİ ── (23-26)
        '23' => ['baslik' => 'Uluslararası kongrede tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 24],
        '24' => ['baslik' => 'Uluslararası kongrede özet bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 18],
        '25' => ['baslik' => 'Ulusal kongrede tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 20],
        '26' => ['baslik' => 'Ulusal kongrede özet bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 12],

        // ── DERS ── (32)
        '32' => ['baslik' => 'Verdiği lisansüstü ders (yarıyıl başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Yabancı Dilde Ders'], 'puan' => 4],
        '32b' => ['baslik' => 'Verdiği lisans/önlisans dersi (yarıyıl başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Değişim Programı Dersi'], 'puan' => 2],

        // ── PROJE ── (34-37)
        '34' => ['baslik' => 'Tamamlanmış uluslararası projede yöneticilik', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 30],
        '34b' => ['baslik' => 'Tamamlanmış ulusal projede yöneticilik', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 25],
        '34c' => ['baslik' => 'Tamamlanmış kurumsal projede yöneticilik', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 15],
        '36' => ['baslik' => 'Tamamlanmış uluslararası projede katılımcılık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],
        '36b' => ['baslik' => 'Tamamlanmış ulusal projede katılımcılık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
        '36c' => ['baslik' => 'Tamamlanmış kurumsal projede katılımcılık', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 8],

        // ── DAVETLİ KONUŞMACI, JÜRİ ve EDİTÖRLÜK ── (38-42)
        '38-39' => ['baslik' => 'Kongre ya da sempozyumda davetli konuşmacı', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 15],
        '40' => ['baslik' => 'Uluslararası yarışmada jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], 'puan' => 20],
        '40b' => ['baslik' => 'Ulusal yarışmada jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 10],
        '41' => ['baslik' => 'Uluslararası dergide yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 10],
        '41b' => ['baslik' => 'Ulusal dergide yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi', 'Yayın Kurulu Üyeliği'], 'puan' => 2],
        // Yönergenin her alan tablosunda bu satırlar ULUSLARARASI/ULUSAL diye
        // ikiye ayrılıyor; faaliyet kaydı dergi ya da bursun düzeyini taşımadığı
        // için §0 uyarınca ulusal değerden sayılıyor (01.09.2026).
        '42' => ['baslik' => 'Dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 5],

        // ── ÖDÜL ve BURS ── (45-46)
        '45' => ['baslik' => 'Uluslararası başarı ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 35],
        '45b' => ['baslik' => 'Ulusal başarı ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'YÖK Ödülü', 'Yarışma Derecesi / Mansiyon'], 'puan' => 20],
        '46' => ['baslik' => 'Araştırma bursu', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 10],

        // ── ATIF ── (47)
        '47' => ['baslik' => 'Uluslararası bilim, kültür, sanat veya tasarım dergisi ya da kitabında atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 40],
        '47b' => ['baslik' => 'Ulusal bilimsel dergi veya kitapta atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 20],

        // ── TEZ DANIŞMANLIĞI ── (49)
        '49' => ['baslik' => 'Tamamlanmış doktora tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 25],
        '49b' => ['baslik' => 'Tamamlanmış yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 20],
        '49c' => ['baslik' => 'Tez jüri üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 4],
        '31a2' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 20],
        '31b2' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 15],
    ],

    'gruplar' => [
        // Koşulların birebir kullandığı ARALIKLAR (md. 7/d-1, 8/b-1, 13/a, 18/2-a).
        '1-11' => ['1', '3', '7', '11', '1-tez', '3-tez', '11-tez'],
        '17-27' => ['17', '18', '18b', '19', '20', '20b', '21', '21b', '23', '24', '25', '26',
            '17-tez', '18-tez', '19-tez', '20-tez', '23-tez'],
        '34-37' => ['34', '34b', '34c', '36', '36b', '36c'],
        '49-50' => ['49', '49b'],
        '49-52' => ['49', '49b', '49c'],
        // "27, 32-52 numaralı faaliyetler" — doçentlik koşulu (md. 13/a).
        '27,32-52' => ['32', '32b', '34', '34b', '34c', '36', '36b', '36c', '38', '40', '40b', '41', '41b', '42', '45', '45b', '46', '47', '47b', '49', '49b', '49c'],
        // "17, 18, 27, 34, 41, 49, 50" — profesörlük koşulu (md. 18/2-a).
        'PROF-CEKIRDEK' => ['17', '18', '18b', '34', '34b', '34c', '41', '41b', '49', '49b'],
        // Md. 8/b-1'in üçüncü yenileme koşulu: birincil indeksli tek yazarlı makale.
        'BIRINCIL' => ['1'],
    ],

    'grup_tavanlari' => [],
];
