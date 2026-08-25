<?php

/**
 * KİLİS 7 ARALIK ÜNİVERSİTESİ — Akademik Kadrolara Yükseltilme ve Atanma
 * Esaslarına İlişkin Puanlama Çizelgesi
 * Kaynak: pdf/17537001102.kilis7aralikuniverstesi.pdf
 *
 * TEK ORTAK ÇİZELGE. Koşullar çizelgeye SIRA NUMARASIYLA atıf yapıyor
 * ("en az 50 puanı 1, 2, 3, 4, 5 ve 6 numaralı maddelerden"), bu yüzden
 * numaralar birebir korundu. Sanat ve tasarım alanlarında sayılan küme çok daha
 * geniş: 9, 10, 11, 12, 13, 14, 15, 16, 17, 20, 21, 25-34.
 *
 * NUMARALAR TEK HANELİ; GRUP DESENİNDE NOKTA ŞART: '1*' deseni 10-19'u da
 * yakalar. Bütün gruplarda '1.*' biçimi kullanıldı.
 *
 * YAZAR PAYLAŞIMI FORMÜLLE VERİLMİŞ: tek isimli tam puan; İKİ İSİMLİDE HER İKİ
 * YAZAR DA %80 alıyor (korpusta ender — çoğu yönerge ikinci yazarı daha aşağı
 * çekiyor); üç isimlide birinci veya corresponding yazar %80, diğerleri %60;
 * daha fazlasında birinci veya corresponding %50, kalan %50 diğer yazarlar
 * arasında eşit paylaşılıyor.
 *
 * PROJE PAYLAŞIMI DA FORMÜLLE VERİLMİŞ (5. madde başlığı): "Yürütücü tam puan
 * alır. Yardımcı araştırıcılar için puanlama, toplam puanın yardımcı araştırıcı
 * sayısına bölünmesiyle hesaplanır." Bu bölme faaliyet kaydından türetilemediği
 * için araştırmacı satırları girilmedi; yalnızca YÜRÜTÜCÜ puanları duruyor.
 * Projede araştırmacı olarak görev aldıysanız o puan burada görünmez.
 *
 * DÜZENLEME KURULU ÜYELİĞİ DE BÖLÜMLÜ (7. madde: "15/n", "8/n"); aynı nedenle
 * girilmedi.
 *
 * SANAT VE TASARIM BÖLÜMLERİ (9-34) GİRİLMEDİ: puan sütunları kaynak PDF'te
 * ayrıştırılamadı. Sanat ve Tasarım Dalları için ayrı bir eşik yazılmadı;
 * bkz. yonerge/kilis.php.
 *
 * AYNI KAYNAĞA DÜŞEN KALEMLERDE DÜŞÜK OLAN GİRİLDİ:
 *   'Kitap Editörlüğü' uluslararası/ulusal ayırmıyor → ulusal satır (40).
 *   'Ansiklopedi Maddesi' aynı şekilde → 10 (iki satır da 10).
 *   'Davetli Konuşmacı' ulusal/uluslararası ayırmıyor → ulusal çağrılı
 *       konuşma (4).
 */

return [
    'kapsam_notu' => 'Puanlar Kilis 7 Aralık Üniversitesi Puanlama Çizelgesinden. Yayın puanı '
        .'yazar sayısına göre paylaştırılır: iki isimlide her iki yazar da %80, üç isimlide '
        .'birinci veya corresponding yazar %80 diğerleri %60, daha fazlasında birinci %50 ve '
        .'kalan %50 eşit paylaşılıyor. PROJEDE ARAŞTIRMACI PUANINIZ GÖRÜNMEZ: yönerge yardımcı '
        .'araştırıcı puanını araştırıcı sayısına bölüyor, bu bölme faaliyet kaydından '
        .'türetilemediği için yalnızca yürütücü satırları girildi. Sanat ve tasarım bölümleri '
        .'(9-34) puan sütunu ayrıştırılamadığı için girilemedi.',

    // Çizelge başlığındaki ortak çalışma kuralı.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'proje', 'patent', 'editorluk', 'odul', 'egitim_ogretim',
            'tez_danismanligi', 'idari_gorev', 'toplumsal_katki'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.0]],
            // İki isimlide HER İKİ yazar da %80.
            'ilk' => ['kademeler' => [1 => 1.0, 2 => 0.80, 3 => 0.80], 'sonrasi' => 0.50],
            'baslica' => ['kademeler' => [1 => 1.0, 2 => 0.80, 3 => 0.80], 'sonrasi' => 0.50],
            'yazar_2' => ['kademeler' => [2 => 0.80, 3 => 0.60], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
            'yazar_3' => ['kademeler' => [3 => 0.60], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
            'yazar_4' => ['bol' => ['pay' => 0.5, 'eksi' => 1]],
            'yazar_5' => ['bol' => ['pay' => 0.5, 'eksi' => 1]],
            'yazar_6' => ['bol' => ['pay' => 0.5, 'eksi' => 1]],
            'ortak' => ['kademeler' => [1 => 1.0, 2 => 0.80, 3 => 0.60], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
        ],
    ],

    'maddeler' => [
        // ══ 1. MAKALELER ══
        '1.a' => ['baslik' => 'Uluslararası atıf endeksli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI', 'ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 40],
        '1.b' => ['baslik' => 'Uluslararası atıf endeksli dergide vaka takdimi, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI', 'ESCI / Scopus'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 20],
        '1.c' => ['baslik' => 'Diğer uluslararası hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 20],
        '1.ç' => ['baslik' => 'Diğer uluslararası dergide vaka takdimi, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 10],
        '1.d' => ['baslik' => 'Ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 20],
        '1.e' => ['baslik' => 'Ulusal hakemli dergide vaka takdimi, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 7],
        '1.f' => ['baslik' => 'Ulusal hakemsiz dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 5],

        // ══ 2. KİTAPLAR ══
        '2.a' => ['baslik' => 'Uluslararası yayımlanan mesleki kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI Kitap', 'BKCI / Scopus Kitap'], 'puan' => 50],
        '2.b' => ['baslik' => 'Ulusal yayımlanan mesleki kitap yazarlığı veya editörlüğü', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Kitap Editörlüğü'], 'puan' => 40],
        '2.c' => ['baslik' => 'Uluslararası mesleki kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Kitap Bölümü'], 'puan' => 20],
        '2.ç' => ['baslik' => 'Yardımcı ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 15],
        '2.d' => ['baslik' => 'Çeviri kitap (en az 50 sayfa)', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap', 'Çeviri Kitap Bölümü'], 'puan' => 10],
        '2.e' => ['baslik' => 'Ansiklopedide madde yazarlığı (en çok üç madde)', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 10],

        // ══ 3. BİLDİRİLER ══
        '3.a' => ['baslik' => 'Makale düzeninde tam metni yayımlanmış uluslararası bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Uluslararası Tam Metin (CPCI)'], 'puan' => 15],
        '3.b' => ['baslik' => 'Özet metni yayımlanmış uluslararası bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 5],
        '3.c' => ['baslik' => 'Makale düzeninde tam metni yayımlanmış ulusal bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 10],
        '3.ç' => ['baslik' => 'Özet metni yayımlanmış ulusal bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 4],

        // ══ 4. ATIFLAR (kendine atıf hariç) ══
        '4.a' => ['baslik' => 'Uluslararası kaynak kitap veya atıf endeksli dergide atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 6],
        '4.b' => ['baslik' => 'Ulusal kaynak kitap, dergi veya doktora tezinde atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer'], 'puan' => 2],

        // ══ 5. ARAŞTIRMA PROJESİ YÖNETİCİLİĞİ (yalnızca yürütücü satırları) ══
        '5.a' => ['baslik' => 'Uluslararası destekli projede (NATO, AB, BM, Dünya Bankası) yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 30],
        '5.b' => ['baslik' => 'TÜBİTAK veya kalkınma bakanlığı projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 20],
        '5.c' => ['baslik' => 'Bakanlık destekli projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 8],
        '5.ç' => ['baslik' => 'Üniversite araştırma fonu (BAP) desteğiyle yürütülen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 8],
        '5.d' => ['baslik' => 'Ulusal özel kuruluş veya vakıf desteğiyle yürütülen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 5],

        // ══ 6. KONFERANS, SEMİNER, PANEL (en fazla 5 faaliyet) ══
        '6.a' => ['baslik' => 'Çağrılı konuşmacı olarak konferans, seminer veya panele katılmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 4],

        // ══ 8. EDİTÖRLÜK VE HAKEMLİK ══
        '8.a' => ['baslik' => 'Uluslararası indeksli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 15],
        '8.b' => ['baslik' => 'Ulusal hakemli dergide editörlük veya yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi', 'Yayın Kurulu Üyeliği', 'BKCI Kitap'], 'puan' => 8],
        '8.c' => ['baslik' => 'Dergi hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 2],

        // ══ 34. ÖDÜLLER, PATENTLER ══
        '34.a' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 30],
        '34.b' => ['baslik' => 'Ulusal patent, faydalı model veya endüstriyel tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Patent', 'Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 20],
        '34.c' => ['baslik' => 'Bilim, sanat veya tasarım ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü', 'Yarışma Derecesi / Mansiyon', 'Burs', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 10],

        // ══ 36. EĞİTİM-ÖĞRETİM FAALİYETLERİ ══
        '36.a' => ['baslik' => 'Tamamlanmış doktora veya uzmanlık tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 10],
        '36.b' => ['baslik' => 'Tamamlanmış yüksek lisans tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 5],
        '36.c' => ['baslik' => 'Tez izleme komitesi veya jüri üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 2],
        '36.ç' => ['baslik' => 'Verilen ders (dönem ve ders başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 2],
    ],

    'gruplar' => [
        // Koşulların birebir andığı küme. Nokta ŞART: '1*' deseni 10-19'u da
        // yakalar.
        '1-6' => ['1.*', '2.*', '3.*', '4.*', '5.*', '6.*'],
        'ULUSLARARASI_MAKALE' => ['1.a', '1.c'],
        'ULUSAL_MAKALE' => ['1.d', '1.f'],
        'SCI_MAKALE' => ['1.a'],
    ],

    'grup_tavanlari' => [],
];
