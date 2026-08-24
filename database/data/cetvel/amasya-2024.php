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
 * KİTAP VE PROJE PAY KURALLARI GİRİLMEDİ: B ve D bölümleri puanı "yazar
 * sayısına bölünür", "her bir araştırmacıya" gibi kendi paylaşım cümleleriyle
 * veriyor. Bu bölme faaliyet kaydından türetilemediği için uygulanmıyor; çok
 * yazarlı kitap ve çok araştırmacılı projede puan olduğundan YÜKSEK görünür.
 *
 * GİRİLMEYEN BÖLÜMLER: H (mesleki/bilimsel organizasyon görevleri), I ve
 * sonrası idari görev ve ödül kalemleri, K sanatsal etkinlik alt kırılımları.
 * Kaynak sözlüğünde karşılıkları yok.
 */

return [
    'kapsam_notu' => 'Puanlar Amasya Üniversitesi Çizelge 1\'den. Makale, kongre ve atıf '
        .'kalemlerinde puan yazar sayısına ve sıranıza göre azaltılır (Çizelge 2) — bu hesap '
        .'uygulanıyor, ancak YAZAR LİSTESİNİ BOŞ BIRAKTIĞINIZ faaliyetlerde uygulanamaz. Kitap '
        .'ve proje kalemlerindeki "yazar sayısına bölünür" kuralı faaliyet kaydından '
        .'türetilemediği için uygulanmıyor; o kalemlerde puanınız olduğundan yüksek görünebilir. '
        .'Organizasyon görevleri ve sanatsal etkinlik alt kırılımları girilmedi.',

    // Çizelge 2 — yalnızca makale, kongre ve atıf kalemlerinde geçerli.
    'yazar_katsayisi' => [
        'haric' => ['kitap', 'proje', 'patent', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev'],
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
        'B3' => ['baslik' => 'Bilimsel kitap veya nadir eser çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap', 'Çeviri Kitap Bölümü'], 'puan' => 75],
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
        'D1' => ['baslik' => 'Uluslararası destekli araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'puan' => 150],
        'D2' => ['baslik' => 'TÜBİTAK, TÜSEB veya kamu destekli araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'puan' => 50],
        'D7' => ['baslik' => 'Üniversite (BAP) destekli araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'puan' => 30],
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
    ],

    'grup_tavanlari' => [],
];
