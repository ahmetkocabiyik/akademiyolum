<?php

/**
 * BANDIRMA ONYEDİ EYLÜL ÜNİVERSİTESİ — Tablo 2: Faaliyetler ve Puanlama Tablosu
 * Kaynak: pdf/17536931052.bandirmaonyedieyluluniverstesi.pdf
 *
 * TEK ORTAK PUAN TABLOSU, ALAN GRUBUNA GÖRE FARKLI ALT BARAJ KÜMESİ. Koşullar
 * tabloya kod aralığıyla atıf yapıyor ("A1-A13 kapsamına giren maddelerden en
 * az 100 puan", "A1-A14, B1-B6, B8c ve C1-C7 maddeleri kapsamına giren
 * yayınlardan"), bu yüzden kodlar birebir korundu.
 *
 * İKİ ALAN GRUBUNUN ALT BARAJI FARKLI KÜMEDEN SAYIYOR:
 *   Sağlık, Mühendislik, Fen        yalnızca A1-A13 (ULUSLARARASI yayınlar)
 *   Sosyal, Spor, Mimarlık, Tasarım A1-A14 + B1-B6 + B8c + C1-C7
 * Yani fen grubunda ulusal yayın alt baraja hiç sayılmıyor; sosyal grupta
 * TR Dizin makaleleri, ulusal kitaplar ve projeler de sayılıyor.
 *
 * ETKİ FAKTÖRÜ ÇARPANI GİRİLEMEDİ: A3 satırı "Web of Science Q1:2, Q2:1.5,
 * Q3:1.25, Q4:1 ile çarpılarak hesaplanır" diyor. Motor çeyrekliğe bağlı çarpan
 * tanımlamıyor; kural gereği EN DÜŞÜK çarpan (Q4 = 1) uygulandı, yani A3.a
 * 50 puan olarak duruyor. Q1 makaleniz varsa gerçek puanınız iki katı; bu
 * korpusta ender bir eksik sayım, aday notunda uyarıldı.
 *
 * YAZAR ÇARPANI SAYI × SIRA MATRİSİ (Tablo 1): 5 yazara kadar kademeli, 5'ten
 * sonraki isimler tam puanın %35'i. "Corresponding author" 1. isim gibi
 * değerlendiriliyor.
 *
 * PROJE YÜRÜTÜCÜSÜ ORANI (Madde 10/h): C3-C4 kalemlerinde proje yürütücüsü
 * proje puanının %70'ini alıyor. Bu oran madde puanlarına gömüldü.
 *
 * AYNI KAYNAĞA DÜŞEN KALEMLERDE DÜŞÜK OLAN GİRİLDİ:
 *   'Kitap Editörlüğü' uluslararası/ulusal ayırmıyor → A5 (40) yerine B7.a (15).
 *   'Hakemlik' dergi düzeyi taşımıyor → B7.ç (1).
 *   'Yayın Kurulu Üyeliği' aynı şekilde → B7.c (5).
 *
 * GİRİLMEYEN KALEMLER: A9-A10, A14, B9-B10, B12 (alana özgü kalemler),
 * C1 (h-indeksi — profilde tutulmuyor), C6 (sertifika programları),
 * C8 (sosyal sorumluluk projeleri) ve D bölümü.
 *
 * C2 (TEZ DANIŞMANLIĞI) KOŞULA BAĞLI: puan yalnızca tezden ÜRETİLMİŞ yayın
 * varsa veriliyor ("Danışmanlığında yürütülen tezlerden üretilmiş yayınlar").
 * Faaliyet kaydı bir tezin yayına dönüşüp dönüşmediğini tutmadığı için EN
 * DÜŞÜK satırlar girildi (doktora 5, yüksek lisans 10 yerine ulusal hakemli
 * satırları).
 */

return [
    'kapsam_notu' => 'Puanlar Bandırma Onyedi Eylül Üniversitesi Tablo 2\'den. Puan yazar '
        .'sayınıza ve sıranıza göre azaltılır (Tablo 1); sorumlu yazar 1. isim gibi sayılır. '
        .'SCI/SSCI/AHCI MAKALELERİNİZDE PUANINIZ DÜŞÜK GÖRÜNEBİLİR: yönerge bu satırı '
        .'çeyrekliğe göre çarpıyor (Q1:2, Q2:1,5, Q3:1,25, Q4:1) ama motor çeyrekliğe bağlı '
        .'çarpan tanımlamıyor; en düşük çarpan uygulandı. Tez danışmanlığı puanı yalnızca '
        .'tezden üretilmiş yayın varsa veriliyor, bu bilgi kayıtta tutulmadığı için en düşük '
        .'satırlar girildi. h-indeksi (C1), sertifika programları (C6) ve sosyal sorumluluk '
        .'projeleri (C8) girilemedi.',

    // Tablo 1 — yazar sayısı × sıra; 5'ten sonrası tam puanın %35'i.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'proje', 'patent', 'editorluk', 'odul', 'egitim_ogretim',
            'tez_danismanligi', 'idari_gorev', 'toplumsal_katki'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.0]],
            'ilk' => ['kademeler' => [1 => 1.0, 2 => 0.90, 3 => 0.80, 4 => 0.70, 5 => 0.60], 'sonrasi' => 0.35],
            // "Corresponding author" 1. isim gibi değerlendirilir.
            'baslica' => ['kademeler' => [1 => 1.0, 2 => 0.90, 3 => 0.80, 4 => 0.70, 5 => 0.60], 'sonrasi' => 0.35],
            'yazar_2' => ['kademeler' => [2 => 0.80, 3 => 0.70, 4 => 0.60, 5 => 0.50], 'sonrasi' => 0.35],
            'yazar_3' => ['kademeler' => [3 => 0.60, 4 => 0.50, 5 => 0.40], 'sonrasi' => 0.35],
            'yazar_4' => ['kademeler' => [4 => 0.40, 5 => 0.40], 'sonrasi' => 0.35],
            'yazar_5' => ['kademeler' => [5 => 0.40], 'sonrasi' => 0.35],
            'yazar_6' => ['sonrasi' => 0.35],
            'ortak' => ['kademeler' => [1 => 1.0, 2 => 0.80, 3 => 0.60, 4 => 0.40, 5 => 0.40], 'sonrasi' => 0.35],
        ],
    ],

    'maddeler' => [
        // ══ A — ULUSLARARASI YAYIN VE ETKİNLİKLER ══
        'A1' => ['baslik' => 'Tanınmış uluslararası yayınevinde bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 75],
        'A2' => ['baslik' => 'Tanınmış uluslararası yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 35],
        // Çeyreklik çarpanı uygulanamadığı için en düşük değer (Q4 × 1).
        'A3.a' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI dergide özgün araştırma, makale ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 50],
        'A3.b' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI dergide editöre mektup, teknik not ya da vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 20],
        'A4.a' => ['baslik' => 'ESCI dergide özgün araştırma, makale ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 40],
        'A4.b' => ['baslik' => 'ESCI dergide editöre mektup, teknik not ya da vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 15],
        'A6.a' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI dergide sorumlu editör ya da baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 40],
        'A7.a' => ['baslik' => 'ESCI dergide sorumlu editör ya da baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 20],
        'A8.b' => ['baslik' => 'Uluslararası alan indeksli hakemli dergide yayın', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 25],
        'A11.a' => ['baslik' => 'Diğer uluslararası hakemli dergide sorumlu editör ya da baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi (Uluslararası)'], 'puan' => 15],
        'A12.a' => ['baslik' => 'Uluslararası toplantıda sözlü sunulan ve tam metni yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Uluslararası Tam Metin (CPCI)'], 'puan' => 15],
        'A12.b' => ['baslik' => 'Uluslararası toplantıda özet metni yayımlanan bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 8],
        'A13.a' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI dergisinde atıf', 'kategori' => 'atif', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 10],
        'A13.b' => ['baslik' => 'ESCI, SCOPUS ya da diğer uluslararası alan indekslerince taranan dergilerde atıf', 'kategori' => 'atif', 'kaynaklar' => ['ESCI', 'Scopus', 'Diğer (Uluslararası)'], 'puan' => 8],
        'A13.ç' => ['baslik' => 'Tanınmış uluslararası yayınevi kitabında atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 4],

        // ══ B — ULUSAL YAYIN VE ETKİNLİKLER ══
        'B1' => ['baslik' => 'Tanınmış ulusal yayınevinde bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı'], 'puan' => 50],
        'B2' => ['baslik' => 'Tanınmış ulusal yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 20],
        'B3.a' => ['baslik' => 'TÜBİTAK-ULAKBİM TR Dizin dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 20],
        'B3.b' => ['baslik' => 'TR Dizin dergide derleme, editöre mektup, teknik not ya da vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 10],
        'B4.a' => ['baslik' => 'Diğer yurt içi hakemli dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale'], 'puan' => 10],
        'B4.b' => ['baslik' => 'Diğer yurt içi hakemli dergide derleme, editöre mektup ya da teknik not', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['derleme', 'vaka_teknik_not', 'kisa_makale'], 'puan' => 5],
        'B5' => ['baslik' => 'Bilimsel ansiklopedide madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 10],
        'B6.a' => ['baslik' => 'Ulusal toplantıda sözlü sunulan ve tam metni yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 6],
        'B6.b' => ['baslik' => 'Ulusal toplantıda özet metni yayımlanan bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 4],
        'B7.a' => ['baslik' => 'Ulusal dergide veya kitapta sorumlu editör ya da baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Kitap Editörlüğü', 'BKCI Kitap'], 'puan' => 15],
        'B7.c' => ['baslik' => 'Dergide yayın kurulu üyeliği veya editör yardımcılığı', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 5],
        'B7.ç' => ['baslik' => 'Dergi hakemliği (her dergi için en fazla 5 hakemlik)', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 1],
        'B8.a' => ['baslik' => 'Bilimsel kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 20],
        'B8.b' => ['baslik' => 'Bilimsel kitapta bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 5],
        'B11.a' => ['baslik' => 'Yurt içi kitap, monografi veya TR Dizin dergisinde atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
        'B11.b' => ['baslik' => 'Diğer atıflar (en fazla 20 puan)', 'kategori' => 'atif', 'kaynaklar' => ['Diğer'], 'puan' => 1],

        // ══ C — GİRİŞİMCİ VE YENİLİKÇİ ÜNİVERSİTE FAALİYETLERİ ══
        // C2 puanı yalnızca tezden üretilmiş yayın varsa; en düşük satırlar girildi.
        'C2.c' => ['baslik' => 'Doktora, tıpta uzmanlık veya sanatta yeterlik tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 15],
        'C2.ç' => ['baslik' => 'Doktora tezinde ikinci danışmanlık veya tez izleme komitesi üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi', 'Tez İzleme / Jüri Üyeliği'], 'roller' => ['es_danisman'], 'puan' => 5],
        'C2.f' => ['baslik' => 'Yüksek lisans tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 10],
        // Madde 10/h: C3-C4'te proje yürütücüsü proje puanının %70'ini alır.
        'C3.b' => ['baslik' => 'TÜBİTAK Ar-Ge destek programından alınan projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 70],
        // Yürütücü %70'i aldığına göre kalan %30 diğer görevlilere düşüyor;
        // yönerge bu payı kişi sayısına bölüyor mu belirtmediği için tamamı
        // yazıldı, yani çok araştırmacılı projede puan yüksek görünebilir.
        'C3.b2' => ['baslik' => 'TÜBİTAK Ar-Ge destek programından alınan projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 30],
        'C3.c' => ['baslik' => 'Cumhurbaşkanlığı, bakanlık veya kalkınma ajansı destekli proje', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'puan' => 70],
        'C3.ç' => ['baslik' => 'Üniversite-sanayi kontratlı Ar-Ge projesi', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'puan' => 49],
        'C3.e' => ['baslik' => 'Üniversite Bilimsel Araştırma Projeleri (BAP) kapsamında proje', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'puan' => 21],
        'C4.b' => ['baslik' => 'Avrupa Birliği Ar-Ge destek programından alınan proje', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'puan' => 140],
        'C4.c' => ['baslik' => 'AB dışında uluslararası Ar-Ge programından alınan proje', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'puan' => 105],
        'C5.c' => ['baslik' => 'Ulusal patent belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 100],
        'C5.ç' => ['baslik' => 'Uluslararası patent belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 200],
        'C5.d' => ['baslik' => 'Faydalı model veya endüstriyel tasarım belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 100],
        'C7.a' => ['baslik' => 'Uluslararası bilimsel kuruluşlarca verilen bilim veya sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 100],
        'C7.b' => ['baslik' => 'TÜBİTAK veya TÜBA bilim ödülü (yayın teşvik ödülü hariç)', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü', 'Ulusal Bilim/Sanat Ödülü'], 'puan' => 50],
        'C7.c' => ['baslik' => 'Ulusal veya uluslararası araştırma bursu', 'kategori' => 'odul', 'kaynaklar' => ['Burs', 'Yarışma Derecesi / Mansiyon'], 'puan' => 20],

        // ══ D — EĞİTİM-ÖĞRETİM (ders kalemleri) ══
        'D1' => ['baslik' => 'Verilen ders (dönem ve ders başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 2],
        'E4.a' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Ulusal)'], 'puan' => 8],
        // Kaynak E1.a uluslararası kongre 15 · E2.a uluslararası çalıştay 10 · E3.a ulusal kongre 10 · E4.a ULUSAL çalıştay 8 diyor; her etiket kendi kapsamının en düşüğünü alır.
        'E4.a-bsk-u' => ['baslik' => 'Uluslararası bilimsel ya da sanatsal toplantı düzenleme kurulu başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 10],
        'E4.a-bsk-n' => ['baslik' => 'Ulusal bilimsel ya da sanatsal toplantı düzenleme kurulu başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Ulusal)'], 'puan' => 8],
        // Kurul üyeliği kaynakta iki bende dağılmış: E*.c düzenleme kurulu (8/5/5/4) ve E*.ç bilim kurulu (3/2/2/2). Etiket ikisini birden taşıdığı için uluslararası min(8,5,3,2)=2, ulusal min(5,4,2,2)=2.
        'E4.c-kur-u' => ['baslik' => 'Uluslararası bilimsel ya da sanatsal toplantı düzenleme ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 2],
        'E4.c-kur-n' => ['baslik' => 'Ulusal bilimsel ya da sanatsal toplantı düzenleme ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 2],
        // `Davetli Konuşmacı` A12.b'de (uluslararası özet/poster bildiri, 8)
        // duruyordu; oysa kaynağın davetli satırları E bölümünde ve düzenleme
        // kurulu üyeliğiyle AYNI bende bağlı: E1.c uluslararası kongre 8 ·
        // E2.c uluslararası çalıştay 5 · E3.c ulusal kongre 5 · E4.c ulusal
        // çalıştay 4. Etiket kapsam taşımadığı için §0 uyarınca 4.
        'E4.c-davetli' => ['baslik' => 'Bilimsel ya da sanatsal etkinlikte davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 4],
        'E2.ç' => ['baslik' => 'Bilimsel toplantıda oturum başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Uluslararası)', 'Oturum Başkanlığı (Ulusal)'], 'puan' => 2],
    ],

    'gruplar' => [
        // Koşulların birebir andığı kod aralıkları.
        'A1-A13' => ['A1', 'A2', 'A3.*', 'A4.*', 'A6.*', 'A7.*', 'A8.*', 'A11.*', 'A12.*', 'A13.*'],
        'A1-A14 B1-B6 B8c C1-C7' => ['A1', 'A2', 'A3.*', 'A4.*', 'A6.*', 'A7.*', 'A8.*',
            'A11.*', 'A12.*', 'A13.*', 'B1', 'B2', 'B3.*', 'B4.*', 'B5', 'B6.*', 'B8.*',
            'C2.*', 'C3.*', 'C4.*', 'C5.*', 'C7.*'],
        'SCI_MAKALE' => ['A3.a'],
        'SCI_ESCI_MAKALE' => ['A3.a', 'A4.a'],
        'SCI_ESCI_KITAP' => ['A3.a', 'A4.a', 'A1', 'A2'],
        'ULUSAL_MAKALE_KITAP' => ['A3.a', 'A4.a', 'A8.b', 'B3.a', 'B4.a', 'A1', 'A2', 'B1', 'B2'],
        'ALAN_INDEKS' => ['A8.b'],
        'PROJE_PATENT' => ['C3.*', 'C4.*', 'C5.*'],
        'DIGER_ATIF' => ['B11.b'],
    ],

    /*
     * "B11.b) Diğer atıflar (En fazla 20 puan dikkate alınır.)" — satırın
     * başlığında yazılıydı ama tavan girilmemişti; atıf başına 1 puan, yani
     * yüz atfı olan aday 100 puan görüyordu (§0 ihlali).
     *
     * Kaynağın öteki tavanı ("B10 yurt içi hakemli olmayan dergilerdeki
     * akademik yayınlar, en fazla 10 puan") girilmedi: B10 satırı cetvelde
     * yok.
     */
    'grup_tavanlari' => [
        'DIGER_ATIF' => 20,
    ],
];
