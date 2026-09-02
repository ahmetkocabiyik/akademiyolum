<?php

/**
 * AMASYA ÜNİVERSİTESİ — Çizelge 1: Değerlendirmeye Esas Teşkil Edecek
 * Faaliyet Puanlama Tablosu
 * Kaynak: pdf/17536928612.amasyauniversitesi.pdf
 *
 * TEK ORTAK PUAN TABLOSU, TEMEL ALANA GÖRE AYRI EŞİK. Koşullar tabloya harf ve
 * numara aralığıyla atıf yapıyor: "en az 20 puanı A1-A16 kategorilerinden",
 * "125 puanı A1-A16 ve K1-K9 kategorilerinden". Kodlar bu yüzden birebir
 * korundu.
 *
 * YAZAR SIRASI ÇARPANI VAR (Çizelge 2) ve yalnızca MAKALE, KONGRE ve ATIF
 * kalemlerine uygulanıyor — kitap, proje ve patent kalemlerinde yönerge kendi
 * paylaşım kuralını yazıyor ("yazar sayısına bölünür"). Motorun `haric` alanı
 * tam bunun için: çarpan kitap, proje, patent ve tez kalemlerinde uygulanmıyor.
 *
 * KİTAPTA PAY KURALI MAKALEDEN BAŞKA: B bölümü "çok yazarlı kitaplarda
 * kitabın toplam puanı yazar sıralamasına bakılmaksızın yazar sayısına
 * bölünür" diyor — sıra hiç sayılmıyor, düz 1/n. Makalenin sıraya bağlı
 * kademe tablosu burada geçerli değil; `yazar_katsayisi.kategoriler` ile ayrı
 * yazıldı.
 *
 * PROJE VE PATENTTE BÖLME YOK: D.1-D.2 ve G.1-G.4 "araştırmacıların HER
 * BİRİNE" sabit puan veriyor, yani çok araştırmacılı projede kimsenin puanı
 * düşmüyor. İkisi de `haric` listesinde.
 *
 * KİTAPTAKİ EDİTÖRLÜK PAYI GİRİLEMEDİ: "her bir editörlük görevi +1 yazarlık
 * olarak değerlendirilir" bölen sayısını artırıyor; kayıt editör sayısını
 * yazar listesinden ayıramıyor. Editörlü kitaplarda puan bir miktar YÜKSEK
 * kalıyor.
 *
 * GİRİLMEYEN BÖLÜMLER: H (mesleki/bilimsel organizasyon görevleri), I ve
 * sonrası idari görev ve ödül kalemleri, K sanatsal etkinlik alt kırılımları.
 * Kaynak sözlüğünde karşılıkları yok.
 */

return [
    'kapsam_notu' => 'Puanlar Amasya Üniversitesi Çizelge 1\'den. Makale, kongre ve atıf '
        .'kalemlerinde puan yazar sayısına ve sıranıza göre azaltılır (Çizelge 2) — bu hesap '
        .'uygulanıyor, ancak YAZAR LİSTESİNİ BOŞ BIRAKTIĞINIZ faaliyetlerde uygulanamaz. Kitap '
        .'Kitapta puan yazar sayısına bölünüyor (sıra sayılmaz); projede ve patentte bölme '
        .'yok, yönerge her araştırmacıya sabit puan veriyor. Kitaptaki "her editörlük +1 '
        .'yazarlık" payı kayıttan türetilemediği için editörlü kitaplarda puanınız bir miktar '
        .'yüksek kalabilir. '
        .'Organizasyon görevleri ve sanatsal etkinlik alt kırılımları girilmedi.',

    // Çizelge 2 — yalnızca makale, kongre ve atıf kalemlerinde geçerli.
    'yazar_katsayisi' => [
        'haric' => ['proje', 'patent', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev'],
        // Kitapta kural makaleden BAŞKA: "çok yazarlı kitaplarda kitabın
        // toplam puanı yazar sıralamasına bakılmaksızın yazar sayısına
        // bölünür" (B.1, B.2, B.5). Sıra hiç sayılmıyor, düz 1/n.
        //
        // Proje ve patent `haric` kalıyor çünkü onlarda bölme yok: yönerge
        // "araştırmacıların HER BİRİNE" sabit puan veriyor (D.1-D.2, G.1-G.4).
        'kategoriler' => [
            'kitap' => ['sonrasi_pay' => 1.0],
        ],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.0]],
            'ilk' => ['kademeler' => [1 => 1.0, 2 => 0.95, 3 => 0.90, 4 => 0.85, 5 => 0.80], 'sonrasi' => 0.75],
            'baslica' => ['kademeler' => [1 => 1.0, 2 => 0.95, 3 => 0.90, 4 => 0.85, 5 => 0.80], 'sonrasi' => 0.75],
            'yazar_2' => ['kademeler' => [2 => 0.85, 3 => 0.80, 4 => 0.75, 5 => 0.70], 'sonrasi' => 0.65],
            'yazar_3' => ['kademeler' => [3 => 0.70, 4 => 0.65, 5 => 0.60], 'sonrasi' => 0.55],
            'yazar_4' => ['kademeler' => [4 => 0.55, 5 => 0.50], 'sonrasi' => 0.45],
            'yazar_5' => ['kademeler' => [5 => 0.50], 'sonrasi' => 0.45],
            'yazar_6' => ['sonrasi' => 0.45],
            // Sırasını belirtmeyen aday o yazar sayısındaki en düşük satırı alır.
            'ortak' => ['kademeler' => [1 => 1.0, 2 => 0.85, 3 => 0.70, 4 => 0.55, 5 => 0.50], 'sonrasi' => 0.45],
        ],
    ],

    'maddeler' => [
        // ── A. MAKALELER ──
        'A1' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 80],
        'A2' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergide kısa bildirim veya brief report', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 40],
        'A3' => ['baslik' => 'Uluslararası alan indeksli dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale'], 'puan' => 40],
        'A5' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme'], 'puan' => 25],
        'A7' => ['baslik' => 'Uluslararası alan indeksli dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['derleme'], 'puan' => 15],
        'A12' => ['baslik' => 'ULAKBİM TR Dizin ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 40],
        'A13' => ['baslik' => 'Ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 25],

        // ── B. KİTAPLAR ──
        'B1' => ['baslik' => 'Uluslararası yayınevi tarafından yabancı dilde yayımlanan bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 150],
        'B2' => ['baslik' => 'Uluslararası yayınevi kitabında bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 35],
        'B3' => ['baslik' => 'Bilimsel kitap veya nadir eser çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 75],
        // B.4 bölüm çevirisi ayrı bir satır (20); 01.09.2026'ya kadar kitap
        // çevirisiyle birlikte 75 puandan sayılıyordu.
        'B4' => ['baslik' => 'Bilimsel kitapta bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 20],
        'B5' => ['baslik' => 'Uluslararası kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 125],
        'B8' => ['baslik' => 'Ulusal kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 20],
        'B10' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanan ISBN\'li kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı'], 'puan' => 15],
        'B11' => ['baslik' => 'Ulusal yayınevi kitabında bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 5],

        // ── C. KONGRE VE KONFERANSLAR ──
        'C1' => ['baslik' => 'Uluslararası hakemli konferansta sözlü sunulan ve tam metin yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin', 'Davetli Konuşmacı'], 'puan' => 25],
        'C3' => ['baslik' => 'Uluslararası hakemli konferansta özet veya poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 10],
        'C5' => ['baslik' => 'Ulusal hakemli konferansta sözlü sunulan ve tam metin yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 15],
        'C7' => ['baslik' => 'Ulusal hakemli konferansta özet veya poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 5],

        // ── D. PROJELER ──
        // D bölümünün her satırı DÖRT ROLE ayrılıyor (yürütücü / araştırmacı /
        // danışman / bursiyer); cetvel rol ayrımı yapmıyordu ve bursiyer bile
        // yürütücü puanını alıyordu (01.09.2026'da ayrıldı).
        'D.1.a' => ['baslik' => 'AB, UN, NSF, UNESCO gibi uluslararası kuruluş destekli projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 150],
        'D.1.b' => ['baslik' => 'AB, UN, NSF, UNESCO gibi uluslararası kuruluş destekli projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci'], 'puan' => 50],
        'D.1.c' => ['baslik' => 'AB, UN, NSF, UNESCO gibi uluslararası kuruluş destekli projede danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['danisman'], 'puan' => 25],
        'D.1.d' => ['baslik' => 'AB, UN, NSF, UNESCO gibi uluslararası kuruluş destekli projede bursiyerlik', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['bursiyer'], 'puan' => 10],
        'D.2.a' => ['baslik' => 'Diğer yabancı kurum ve üniversite destekli projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 50],
        'D.2.b' => ['baslik' => 'Diğer yabancı kurum ve üniversite destekli projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci'], 'puan' => 25],
        'D.2.c' => ['baslik' => 'Diğer yabancı kurum ve üniversite destekli projede danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['danisman'], 'puan' => 10],
        'D.2.d' => ['baslik' => 'Diğer yabancı kurum ve üniversite destekli projede bursiyerlik', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['bursiyer'], 'puan' => 5],
        'D.3.a' => ['baslik' => 'Kalkınma ajansı veya kamu kurumu destekli projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 100],
        'D.3.b' => ['baslik' => 'Kalkınma ajansı veya kamu kurumu destekli projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci'], 'puan' => 50],
        'D.3.c' => ['baslik' => 'Kalkınma ajansı veya kamu kurumu destekli projede danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['danisman'], 'puan' => 30],
        'D.3.d' => ['baslik' => 'Kalkınma ajansı veya kamu kurumu destekli projede bursiyerlik', 'kategori' => 'proje', 'kaynaklar' => ['TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['bursiyer'], 'puan' => 10],
        // TÜBİTAK projesi normal destek (D.3: 100/50/30/10) ile Hızlı Destek
        // (D.4: 50/30/10/5) arasında ayrılamıyor; §0 uyarınca Hızlı Destek'ten.
        'D.4.a' => ['baslik' => 'TÜBİTAK destekli projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 50],
        'D.4.b' => ['baslik' => 'TÜBİTAK destekli projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['arastirmaci'], 'puan' => 30],
        'D.4.c' => ['baslik' => 'TÜBİTAK destekli projede danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['danisman'], 'puan' => 10],
        'D.4.d' => ['baslik' => 'TÜBİTAK destekli projede bursiyerlik', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['bursiyer'], 'puan' => 5],
        'D.5.a' => ['baslik' => 'Üniversite (BAP) destekli projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 30],
        'D.5.b' => ['baslik' => 'Üniversite (BAP) destekli projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
        'D.6.a' => ['baslik' => 'Bakanlık, resmî kurum ya da tasarım-planlama projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 50],
        'D.6.b' => ['baslik' => 'Bakanlık, resmî kurum ya da tasarım-planlama projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci'], 'puan' => 20],
        'D.6.c' => ['baslik' => 'Bakanlık, resmî kurum ya da tasarım-planlama projesinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['danisman'], 'puan' => 10],
        'D.6.d' => ['baslik' => 'Bakanlık, resmî kurum ya da tasarım-planlama projesinde bursiyerlik', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['bursiyer'], 'puan' => 5],
        'D8' => ['baslik' => 'TÜBİTAK öğrenci projesi danışmanlığı', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'puan' => 20],

        // ── E. ATIFLAR ──
        'E1' => ['baslik' => 'Yayınlarınıza yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap', 'TR Dizin', 'Diğer', 'Patent'], 'puan' => 3],

        // ── F. TEZ YÖNETİMİ VE DERSLER ──
        'F1' => ['baslik' => 'Tamamlanmış doktora veya uzmanlık tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 15],
        'F4' => ['baslik' => 'Tamamlanmış yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 10],
        'F7' => ['baslik' => 'Lisansüstü tez jüri üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 4],
        'F9' => ['baslik' => 'Verdiğiniz dersler', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi', 'Akreditasyon Faaliyeti'], 'puan' => 5],
        'F11' => ['baslik' => 'Komisyon, kurul veya koordinatörlük görevi', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Senato / Üniversite Yönetim Kurulu Üyesi', 'Dekan / Enstitü-YO Müdürü', 'Dekan Yrd. / Müdür Yrd.', 'Uygulama ve Araştırma Merkezi Müdürü', 'Bölüm Başkanı', 'Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük', 'Kurul / Komisyon Üyeliği'], 'puan' => 5],

        // ── G. PATENTLER ──
        'G1' => ['baslik' => 'Uluslararası lisans sözleşmesi yapılmış patent', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 200],
        'G2' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 100],
        'G4' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 75],
        'G5' => ['baslik' => 'Ulusal patent veya faydalı model müracaatı', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 10],
    ],

    'gruplar' => [
        // Koşulların birebir andığı kategori aralıkları.
        'A1-A16' => ['A*'],
        'A1' => ['A1'],
        // "A1-A16 ve K1-K9 kategorilerinden" koşulu Eğitim'in Resim/Müzik
        // bilim alanları ile Güzel Sanatlar'da geçiyor. K bölümü (sanatsal
        // etkinlikler) kaynak sözlüğünde karşılıksız olduğu için girilmedi;
        // o koşullar yalnızca A1-A16'yı sayıyor, yani baraj olduğundan zor
        // görünür.
        'MAKALE' => ['A*'],

        'TEZ-JURI' => ['F7'],
        'DERSLER' => ['F9'],
    ],

    /*
     * F bölümünün iki ara başlığı tavan taşıyor; ikisi de girilmemişti ve
     * tavansız bölüm doğrudan fazla saydırır (§0).
     *
     *   "Tez Jüri Üyeliği (… en fazla 20 puan alınabilir)"
     *   "Dersler (Son beş yılda verilen derslerden en fazla 40 puan alınabilir)"
     */
    'grup_tavanlari' => [
        'TEZ-JURI' => 20,
        'DERSLER' => 40,
    ],
];
