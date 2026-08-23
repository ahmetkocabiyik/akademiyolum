<?php

/**
 * ANADOLU ÜNİVERSİTESİ — Öğretim Üyeliği Kadrolarına Yükseltme ve Atama
 * Ölçütleri puanlama tablosu
 * Kaynak: pdf/17536928752.anadoluuniversitesi.pdf (01/08/2023 yürürlük)
 *
 * TEK ORTAK PUAN TABLOSU, İKİ ALAN GRUBU İÇİN AYRI EŞİK. 59 numaralı ölçüt
 * bütün temel alanlarda aynı puanı taşıyor; değişen yalnızca toplam baraj ve
 * hangi madde aralığından ne kadar puan isteneceği (yonerge/anadolu.php).
 *
 * KODLAR YÖNERGENİN KENDİ NUMARALARI. Koşullar bu numaraları aralık olarak
 * anıyor ("41‒45. maddelerden en az 30 puan", "28-40. maddelerden en az 150
 * puan"), o yüzden numaraların birebir korunması şart.
 *
 * YAZAR SAYISI KATSAYISI GİRİLMEDİ: yönerge tek yazarlı eserde tam puan, iki
 * yazarlıda 0,8; üç yazarlıda 0,6; dört ve üzeri için "2,0 × Puan / Yazar
 * Sayısı" diyor. Motor yazar sayısına göre puan bölmüyor, bu yüzden hesaplanan
 * toplam çok yazarlı eserlerde GERÇEKTEN YÜKSEK çıkar — bu, diğer
 * cetvellerdeki eksik-say kuralının tersi yönde bir sapma, kapsam notunda
 * açıkça belirtildi.
 *
 * GİRİLMEYEN ÖLÇÜTLER: editörlük ve hakemlik satırları (18-23) puanı metin
 * içinde "120/60" gibi çift değerle veriyor ve baş/alan editörlüğü ayrımı
 * kaynak sözlüğünde yok; 33-38 sanatsal etkinlik alt kırılımları, 46-50 jüri
 * ve düzenleme kurulu görevleri, 53 görsel-işitsel yapım rolleri. Bunların
 * sözlükte karşılığı yok.
 */

return [
    'kapsam_notu' => 'Puanlar Anadolu Üniversitesi puanlama tablosundan (01/08/2023). DİKKAT: yönerge '
        .'çok yazarlı eserlerde puanı yazar sayısına göre azaltıyor (iki yazarlıda 0,8; üç yazarlıda '
        .'0,6; dört ve üzeri için 2,0×Puan/Yazar Sayısı); bu hesap uygulanmadığı için çok yazarlı '
        .'eserlerde toplamınız burada OLDUĞUNDAN YÜKSEK görünür. Ayrıca editörlük/hakemlik, jüri ve '
        .'düzenleme kurulu kalemleri kaynak sözlüğünde karşılıksız olduğu için girilmedi.',

    'maddeler' => [
        '1' => ['baslik' => 'SCI (Science Citation Index), SCI‐Expanded (Science Citation Index‐ Expanded), SSCI (Social Sciences Cit', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 150],
        '2' => ['baslik' => 'Emerging Sources Citation Index (ESCI) veya SCOPUS tarafından taranan dergilerde yayımlanan teknik not, ', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 100],
        '3' => ['baslik' => 'ULAKBİM (TR-Dizin) tarafından taranan hakemli dergilerde veya ÜAK tarafından yayımlanan doçentlik başvur', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 70],
        '4' => ['baslik' => 'Diğer uluslararası ve ulusal hakemli dergilerde yayımlanan teknik not, editöre mektup, tartışma vaka tak', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 45],
        '6a' => ['baslik' => 'Web of Science Conference Proceedings Citation Index’te taranan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 45],
        '6b' => ['baslik' => 'Uluslararası bilimsel toplantılarda sunulmuş ve tam metni basılmış sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin'], 'puan' => 30],
        '6c' => ['baslik' => 'Uluslararası bilimsel toplantılarda sunulmuş ve özet metni basılmış sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 15],
        '6e' => ['baslik' => 'Ulusal bilimsel toplantılarda sunulmuş ve tam metni basılmış sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 20],
        '6f' => ['baslik' => 'Ulusal bilimsel toplantılarda sunulmuş ve özet metni basılmış sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 10],
        '7a' => ['baslik' => 'Web of Science Book Citation Index’te taranan uluslararası yayınevleri tarafından yayımlanmış kitap yaza', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 150],
        '7c' => ['baslik' => 'Web of Science Book Citation Index’te taranan uluslararası yayınevleri tarafından yayımlanmış bölüm yaza', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 60],
        '7d' => ['baslik' => 'Ulusal yayınevleri veya Web of Science Book Citation Index’te taranmayan diğer uluslararası yayınevleri ', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 90],
        '7f' => ['baslik' => 'Ulusal yayınevleri veya Web of Science Book Citation Index’te taranmayan diğer uluslararası yayınevleri ', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 30],
        '7g' => ['baslik' => 'Alanında bilimsel kitap çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 60],
        '7h' => ['baslik' => 'Alanında bilimsel makale, kitap bölümü ve karar tahlili çevirmenliği * Bu madde kapsamında aynı kitapta ', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 20],
        '8' => ['baslik' => 'Başarıyla tamamlanmış AB Araştırma ve Çerçeve Programı Projesinde koordinatör / baş araştırmacı / yürütü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 200],
        '9' => ['baslik' => 'Başarıyla tamamlanmış AB Çerçeve programı bilimsel araştırma projesinde ortak araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 150],
        '10' => ['baslik' => 'Başarıyla tamamlanmış uluslararası destekli araştırma projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 120],
        '11' => ['baslik' => 'Başarıyla tamamlanmış uluslararası destekli araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 60],
        '12' => ['baslik' => 'Üniversite dışı kaynaklarca (TÜBİTAK, Kalkınma Ajansı, Bakanlıklar ve diğer kamu kurumları) desteklenen ', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 120],
        '13' => ['baslik' => 'Üniversite dışı kaynaklarca (TÜBİTAK, Kalkınma Ajansı, Bakanlıklar ve diğer kamu kurumları) desteklenen ', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 60],
        '15' => ['baslik' => 'Üniversiteler tarafından desteklenen Bilimsel Araştırma Projesinde (BAP) yürütücü olmak (Yayın ve Araştı', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 50],
        '16' => ['baslik' => 'Üniversiteler tarafından desteklenen Bilimsel Araştırma Projesinde (BAP) araştırmacı olmak (Yayın ve Ara', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
        '17a' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 250],
        '17b' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 150],
        '17c' => ['baslik' => 'Faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 90],
        '17d' => ['baslik' => 'Tasarım tescili Uluslararası Patent: Uluslararası araştırma ofisleri tarafından (PCT-Patent Cooperation ', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım'], 'puan' => 90],
        '24' => ['baslik' => 'SCI, SCI-Expanded, SSCI ve AHCI tarafından taranan dergilerde; uluslararası yayınevleri tarafından yayım', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 15],
        '25' => ['baslik' => 'Emerging Sources Citation Index (ESCI) veya SCOPUS tarafından taranan dergilerde; uluslararası yayınevle', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 9],
        '26' => ['baslik' => 'ULAKBİM (TR-Dizin) tarafından taranan hakemli dergilerde veya ÜAK tarafından yayımlanan doçentlik başvur', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer'], 'puan' => 5],
        '28' => ['baslik' => 'Özgün sanat eserlerinin, tasarımların ya da yorum çalışmalarının yurt dışında sanat, eğitim ve kültür ku', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)'], 'puan' => 150],
        '29' => ['baslik' => 'Özgün sanat eserlerinin, tasarımların ya da yorum çalışmalarının yurt içinde sanat, eğitim ve kültür kur', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)'], 'puan' => 50],
        '30' => ['baslik' => 'Özgün sanat eserleri, tasarımlar ya da yorum çalışmaları ile uluslararası jürili karma sanat ve tasarım ', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)'], 'puan' => 25],
        '31' => ['baslik' => 'Özgün sanat eserleri, tasarımlar ya da yorum çalışmaları ile ulusal jürili yurt dışında karma sanat ve t', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)'], 'puan' => 20],
        '39' => ['baslik' => 'Uluslararası jürili sanat ve tasarım etkinliklerinde eserleriyle ödül almış olmak', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü'], 'puan' => 90],
        '40' => ['baslik' => 'Ulusal jürili sanat ve tasarım etkinliklerinde eserleriyle ödül almış olmak (*) Afiş, ilan, pankart, pos', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 50],
        '41' => ['baslik' => 'Son 5 yılda (doktor öğretim üyesi atamasında son atama döneminde) her türlü ortamda verilmiş dersler; he', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi', 'Akreditasyon Faaliyeti'], 'puan' => 5],
        '42a' => ['baslik' => 'Doktora/Sanatta Yeterlik', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 24],
        '42b' => ['baslik' => 'Tezli Yüksek Lisans', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 12],
        '44' => ['baslik' => 'Tamamlanan her tez için doktora/sanatta yeterlik tez izleme komitesinde görev almak', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 4],
        '51' => ['baslik' => 'Yurtdışı yayınlarda adayın kendi alanında bilimsel, sanatsal çalışmaları hakkında yayın yapılmış olması ', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Bilim İletişimi / Popüler Yayın'], 'puan' => 10],
        '54' => ['baslik' => 'Alanında saygın uluslararası kuruluşlar tarafından verilen bilimsel/sanatsal nitelikli ödül almak', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 200],
        '55' => ['baslik' => 'Alanında (TÜBA, TÜBİTAK, YÖK) ulusal bilimsel/sanatsal nitelikli ödül almak', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'YÖK Ödülü'], 'puan' => 100],
        '56' => ['baslik' => 'Kamu kurum ve kuruluşları ile sivil toplum kuruluşları tarafından verilen bilimsel/sanatsal nitelikli öd', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 40],
        '57' => ['baslik' => 'Dekanlık, enstitü/yüksekokul/meslek yüksekokulu müdürlüğü, üniversite yönetim kurulu üyeliği, senato üye', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü', 'Senato / Üniversite Yönetim Kurulu Üyesi'], 'puan' => 20],
        '58' => ['baslik' => 'Araştırma merkezi müdürlüğü, Rektörlüğe bağlı koordinatörlüklerde koordinatörlük, bölüm başkan yardımcıl', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü', 'Anabilim Dalı Başkanı / Koordinatörlük', 'Bölüm Başkanı'], 'puan' => 10],
        '59' => ['baslik' => 'Birim kurul üyeliği, birim yönetim kurulu üyeliği, Rektörlük uhdesinde görev yapan komisyon veya kurulla', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği', 'Bölüm Başkan Yardımcısı', 'Dekan Yrd. / Müdür Yrd.'], 'puan' => 7],
    ],

    'gruplar' => [
        // Koşulların birebir andığı madde aralıkları.
        '1-2' => ['1', '2'],
        '1-3' => ['1', '2', '3'],
        '28-40' => ['28', '29', '30', '31', '39', '40'],
        '41-45' => ['41', '42a', '42b', '44'],
        'MAKALE' => ['1', '2', '3', '4'],
    ],

    'grup_tavanlari' => [],
];
