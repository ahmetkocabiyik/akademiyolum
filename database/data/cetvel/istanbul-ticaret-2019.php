<?php

/**
 * İSTANBUL TİCARET ÜNİVERSİTESİ — Ek 1: Öğretim Elemanı Değerlendirme
 * Kriterleri
 * Kaynak: pdf/17537101122.istanbulticaretuniversitesi.pdf
 *
 * KOŞULLAR ROMEN RAKAMLI BÖLÜMLERE ATIF YAPIYOR ("Değerlendirme
 * Kriterlerindeki I no'lu faaliyetlerden 250 puan"), bu yüzden bölüm numaraları
 * (I, II, III) ve içindeki alt numaralar korundu. Kodlar `I.B.1` biçiminde:
 * bölüm · alt başlık · sıra.
 *
 * "I NO'LU FAALİYETLER" = YAYINLAR bölümünün tamamı: makaleler, bildiriler,
 * kitaplar, çeviriler, editörlük ve atıflar. Yani üç kadroda da aranan alt
 * baraj yalnızca yayın tarafını sayıyor; eğitim-öğretim, proje ve ödüller
 * (II) yalnızca genel toplama giriyor.
 *
 * YAZAR ÇARPANI SADECE KİŞİ SAYISINA BAĞLI (I/A-2): iki yazarlı 0,8; üç
 * yazarlı 0,6; dört ve daha fazla yazarlı 0,5. Sıra rol oynamıyor, bu yüzden
 * bütün roller aynı kademeleri kullanıyor.
 *
 * ÇOK DEĞERLİ SATIRLAR EN DÜŞÜĞÜNDEN GİRİLDİ. Yönergenin birçok kalemi
 * "a. Yurtdışında yayımlanan … b. Yurtiçinde yayımlanan" biçiminde iki değer
 * taşıyor ve PDF'te yalnızca ilki ayrıştırılabildi. Kural gereği ikinci
 * (düşük) değerin bilinmediği yerlerde kalem tek satır olarak, bilinen
 * değerle girildi; bu, yurt içi yayınlarda puanı OLDUĞUNDAN YÜKSEK gösterir.
 * Etkilenen kalemler dosyada `çift değerli` yorumuyla işaretlendi.
 *
 * TAVANLAR UYGULANMIYOR: tez yönetimi ve jüri kalemlerinde yönerge "(Toplamı …
 * puanı geçemez)" diyor ama sınır değeri PDF'te kesilmiş. Bilinmeyen bir tavanı
 * tahmin etmek yerine hiç uygulanmadı.
 *
 * GİRİLMEYEN KALEMLER: II/A (öğretim faaliyetleri — ders yükü ayrıntısı
 * ayrıştırılamadı), II/D-5 ve II/D-6 (panel ve söyleşi katılımı),
 * III bölümünün alt kırılımları.
 */

return [
    'kapsam_notu' => 'Puanlar İstanbul Ticaret Üniversitesi Ek 1 Değerlendirme Kriterlerinden. '
        .'Puan KİŞİ SAYISINA göre azaltılır (iki yazarlı 0,8 · üç yazarlı 0,6 · dört ve '
        .'fazlası 0,5); sıranız fark etmiyor. YURT İÇİ YAYINLARDA PUANINIZ YÜKSEK GÖRÜNEBİLİR: '
        .'yönergenin kitap, çeviri ve editörlük kalemleri yurt dışı/yurt içi diye ikiye '
        .'ayrılıyor, PDF\'te yalnızca yurt dışı değeri okunabildi. Tez ve jüri kalemlerindeki '
        .'toplam tavanları da kaynakta kesik olduğu için uygulanmıyor.',

    // I/A-2 — çok yazarlı çalışmalarda puan oranı; yalnızca kişi sayısına bağlı.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'proje', 'patent', 'editorluk', 'odul', 'egitim_ogretim',
            'tez_danismanligi', 'idari_gorev', 'toplumsal_katki', 'sanatsal_etkinlik'],
        'roller' => (function (): array {
            $k = ['kademeler' => [1 => 1.0, 2 => 0.80, 3 => 0.60], 'sonrasi' => 0.50];

            return [
                'tek' => ['kademeler' => [1 => 1.0]],
                'ilk' => $k, 'baslica' => $k, 'yazar_2' => $k, 'yazar_3' => $k,
                'yazar_4' => $k, 'yazar_5' => $k, 'yazar_6' => $k, 'ortak' => $k,
            ];
        })(),
    ],

    'maddeler' => [
        // ══ I/B — MAKALELER ══
        'I.B.1' => ['baslik' => 'SCI, SSCI veya AHCI dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 60],
        'I.B.2' => ['baslik' => 'Diğer indeksli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 40],
        'I.B.3' => ['baslik' => 'Hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 25],
        'I.B.4' => ['baslik' => 'Diğer bilimsel dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 10],
        // I/B-5: teknik not, editöre mektup ve özet türü yayınlar için yukarıdaki
        // puanların bir oranı; oran PDF'te kesik olduğu için en düşük satırın
        // değeriyle tek kalem olarak girildi.
        'I.B.5' => ['baslik' => 'Teknik not, editöre mektup, vaka takdimi veya özet türü yayın', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI', 'ESCI / Scopus', 'Diğer Uluslararası İndeks', 'TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 5],

        // ══ I/C — BİLDİRİLER ══
        'I.C.1' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan ve yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Uluslararası Tam Metin (CPCI)', 'Uluslararası Özet/Poster'], 'puan' => 20],
        'I.C.2' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan ve yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin', 'Ulusal Özet/Poster', 'Davetli Konuşmacı'], 'puan' => 8],

        // ══ I/D — KİTAPLAR, ÇEVİRİLER, EDİTÖRLÜK, ATIFLAR ══
        // çift değerli: yurt dışı 100 / yurt içi değeri kaynakta okunamadı
        'I.D.1' => ['baslik' => 'Alanında kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI Kitap', 'BKCI / Scopus Kitap', 'Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı'], 'puan' => 100],
        // çift değerli
        'I.D.2' => ['baslik' => 'Alanında kitapta bölüm veya ünite yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 30],
        'I.D.3' => ['baslik' => 'Derleme kitap çalışması', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 10],
        // çift değerli
        'I.D.4' => ['baslik' => 'Alanında kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap', 'Çeviri Kitap Bölümü'], 'puan' => 40],
        // çift değerli: SCI/SSCI/AHCI dergide editörlük 120, diğerleri okunamadı
        'I.D.5' => ['baslik' => 'Dergi editörlüğü veya hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi', 'TR Dizin Dergi', 'Diğer Hakemli Dergi', 'Yayın Kurulu Üyeliği', 'Hakemlik', 'BKCI Kitap'], 'puan' => 120],
        'I.D.6' => ['baslik' => 'SCI, SSCI veya AHCI dergisinde atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap', 'TR Dizin', 'Diğer'], 'puan' => 10],

        // ══ II/B — TEZ YÖNETİMİ VE JÜRİ ══
        'II.B.1' => ['baslik' => 'Yönetiminde tamamlanan tez', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi', 'Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 75],
        'II.B.2' => ['baslik' => 'Yönetiminde bir yıldan fazla yürütülen, tamamlanmamış doktora tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi'], 'roller' => ['es_danisman'], 'puan' => 4],
        'II.B.4' => ['baslik' => 'Jüride bulunulan ve savunulan tez', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 50],

        // ══ II/C — SONUÇLANDIRILMIŞ ARAŞTIRMA PROJELERİ ══
        'II.C.1' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 30],
        'II.C.2' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 12],
        'II.C.3' => ['baslik' => 'Ulusal kuruluşlarca desteklenen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'BAP (Üniversite)', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 15],
        'II.C.4' => ['baslik' => 'Ulusal kuruluşlarca desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'BAP (Üniversite)', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 8],

        // ══ II/D — DİĞER BİLİMSEL ETKİNLİKLER ══
        'II.D.3' => ['baslik' => 'Alanında bilimsel araştırma için uluslararası burs almak', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 10],
        // çift değerli: uluslararası 50 / ulusal değeri kaynakta okunamadı
        'II.D.7' => ['baslik' => 'Patentlenmiş buluş', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent', 'Ulusal Patent', 'Patent', 'Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 50],

        // ══ II/E — ÖDÜLLER ══
        'II.E.1' => ['baslik' => 'Alanında uluslararası bilimsel nitelikli ödül', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 50],
        'II.E.2' => ['baslik' => 'Alanında ulusal bilimsel nitelikli ödül', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü', 'Yarışma Derecesi / Mansiyon'], 'puan' => 20],

        // ══ III — SANATSAL ETKİNLİKLER ══
        'III.2' => ['baslik' => 'Uluslararası seçici kurullu sergi, festival, bienal veya gösteri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Resital (Uluslararası)', 'Solistlik (Uluslararası)', 'Masterclass (Uluslararası)'], 'puan' => 20],
        'III.3' => ['baslik' => 'Ulusal seçici kurullu sergi, festival, bienal veya gösteri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Resital (Ulusal)', 'Solistlik (Ulusal)', 'Masterclass (Ulusal)'], 'puan' => 8],
        'III.4' => ['baslik' => 'Eserin seçici kurullu müzede veya eşdeğer kurumda yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Yayında Yer Alması / Satın Alınması'], 'puan' => 100],
        'III.5' => ['baslik' => 'Alanında özgün bireysel sanat veya tasarım etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Özgün Eser / Beste / Tasarım'], 'puan' => 30],
    ],

    'gruplar' => [
        // Koşulların andığı "I no'lu faaliyetler" = Yayınlar bölümünün tamamı.
        'I' => ['I.*'],
    ],

    'grup_tavanlari' => [],
];
