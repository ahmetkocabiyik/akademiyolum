<?php

/**
 * BİNGÖL ÜNİVERSİTESİ — EK 1: Puanlama Listesi
 * Kaynak: pdf/17536988712.bingoluniverstesi.pdf
 *
 * TEK ORTAK PUAN TABLOSU, ALAN GRUBUNA GÖRE FARKLI ZORUNLU MADDE KÜMESİ.
 * Koşullar tabloya SIRA NUMARASIYLA atıf yapıyor ("en az 100 puanı 1, 2, 6, 10,
 * 11, 12, 13 ve 52 numaralı maddelerden"), bu yüzden numaralar birebir korundu;
 * bir maddenin a/b/c şıkları varsa nokta ile eklendi (1.a, 1.b, …).
 *
 * NUMARALAR TEK HANELİ OLDUĞU İÇİN GRUP DESENİNDE NOKTA ŞART: '1*' deseni
 * 10-19 arası maddeleri de yakalar. Bütün gruplarda '1.*' biçimi kullanıldı.
 *
 * YAZAR ÇARPANI YALNIZCA SIRAYA BAĞLI (Madde 8): 1. isim %100, 2. %90, 3. %80,
 * 4. %70, 5. ve sonrası %50. Yazar sayısı hiç rol oynamıyor. Sorumlu yazar
 * (corresponding author) ve senyör yazar sıraya bakılmaksızın %100 alıyor —
 * `baslica` rolü bu yüzden tam puan taşıyor. Atıflar açıkça hariç.
 *
 * PROJELERDE AYRI ORAN (Madde 8/c): yürütücü %100, araştırmacı veya danışman
 * %80. Bu oran madde puanlarına gömüldü (ör. 20.a yürütücü 75, araştırmacı 60).
 *
 * ATIF TAVANI 30 PUAN (Madde 8/3) — grup tavanı olarak uygulandı.
 *
 * İHTİSASLAŞMA KALEMİ (52) GİRİLEMEDİ: "Tarım ve Havza Bazlı Kalkınma"
 * programındaki koordinatörlük ve proje görevleri kaynak sözlüğünde
 * karşılıksız. Bu kalem fen ve sosyal alanların ZORUNLU kümesinde yer aldığı
 * için o baraj olduğundan zor görünür.
 *
 * AYNI KAYNAĞA DÜŞEN KALEMLERDE DÜŞÜK OLAN GİRİLDİ:
 *   'Kitap Editörlüğü' uluslararası/ulusal ayırmıyor → 14.a (60) yerine
 *       15.a (10).
 *   'Hakemlik' dergi düzeyi taşımıyor → 8.d (2).
 *   'Yayın Kurulu Üyeliği' aynı şekilde → 16.h (1).
 *   'Davetli Konuşmacı' ulusal/uluslararası ayırmıyor → 6.f (15).
 *
 * GİRİLMEYEN KALEMLER: 4-5 (eserlerine yer verilmesi), 7 (oturum başkanlığı),
 * 9 (kamu-üniversite-sanayi işbirliği), 23-24 (koordinatörlük ve kongre
 * düzenleme), 26-28, 32-42 (film, TV, tiyatro, sahne ve kostüm tasarımı),
 * 49-51. Kaynak sözlüğünde karşılıkları yok ya da ayırt edilemiyor.
 */

return [
    'kapsam_notu' => 'Puanlar Bingöl Üniversitesi EK 1 Puanlama Listesinden. Puan yazar '
        .'SIRANIZA göre azaltılır (Madde 8: 1. isim %100 … 5. ve sonrası %50); yazar sayısı '
        .'rol oynamıyor, sorumlu ve senyör yazar sıraya bakılmaksızın tam puan alıyor. Atıf '
        .'puanı 30 ile sınırlı (Madde 8/3) ve bu sınır uygulanıyor. Üniversitenin ihtisaslaşma '
        .'kalemi (52 — Tarım ve Havza Bazlı Kalkınma programı görevleri) girilemedi; bu kalem '
        .'fen ve sosyal alanların zorunlu kümesinde olduğu için o baraj olduğundan zor görünür. '
        .'Film, TV, tiyatro ve sahne tasarımı kalemleri (32-42) de girilmedi.',

    // Madde 8 — çarpan yalnızca sıraya bağlı.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'proje', 'patent', 'editorluk', 'odul', 'egitim_ogretim',
            'tez_danismanligi', 'idari_gorev', 'toplumsal_katki'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.0]],
            'ilk' => ['sonrasi' => 1.0],
            // Sorumlu ve senyör yazar sıraya bakılmaksızın %100.
            'baslica' => ['sonrasi' => 1.0],
            'yazar_2' => ['sonrasi' => 0.90],
            'yazar_3' => ['sonrasi' => 0.80],
            'yazar_4' => ['sonrasi' => 0.70],
            'yazar_5' => ['sonrasi' => 0.50],
            'yazar_6' => ['sonrasi' => 0.50],
            'ortak' => ['kademeler' => [1 => 1.0], 'sonrasi' => 0.50],
        ],
    ],

    'maddeler' => [
        // ══ 1. TAM ARAŞTIRMA MAKALESİ VEYA DERLEME ══
        '1.a' => ['baslik' => 'SSCI, SCI-Expanded veya AHCI dergide tam araştırma makalesi ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 40],
        '1.b' => ['baslik' => 'ESCI dergide tam araştırma makalesi ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 35],
        '1.c' => ['baslik' => 'Alan indeksli dergide tam araştırma makalesi ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 30],
        '1.d' => ['baslik' => 'Diğer hakemli ulusal veya uluslararası dergide tam araştırma makalesi ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 20],

        // ══ 2. TEKNİK NOT, KISA MAKALE, VAKA TAKDİMİ ══
        '2.a' => ['baslik' => 'SSCI, SCI-Expanded veya AHCI dergide teknik not, vaka takdimi ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 10],
        '2.b' => ['baslik' => 'ESCI dergide teknik not, vaka takdimi ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 8],
        '2.c' => ['baslik' => 'Diğer indeksli veya ulusal dergide teknik not, vaka takdimi ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 6],

        // ══ 3. ATIFLAR (kişi sayısı dikkate alınmaz, tavan 30) ══
        '3.a' => ['baslik' => 'Uluslararası kitapta atıf (atıf başına)', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 8],
        '3.c' => ['baslik' => 'SSCI, SCI-Expanded veya AHCI dergisinde atıf (atıf başına)', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 4],
        '3.f' => ['baslik' => 'Hakemli ulusal dergide atıf (atıf başına)', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer'], 'puan' => 2],

        // ══ 6. TEBLİĞLER ══
        '6.b' => ['baslik' => 'Uluslararası toplantıda sözlü sunulan ve tam metin yayımlanan tebliğ', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Uluslararası Tam Metin (CPCI)'], 'puan' => 20],
        '6.c' => ['baslik' => 'Uluslararası toplantıda sunulan ve özet metin yayımlanan tebliğ veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 10],
        '6.f' => ['baslik' => 'Kongre veya sempozyumda davetli tebliğ sunmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 15],
        '6.g' => ['baslik' => 'Ulusal toplantıda sözlü sunulan ve tam metin yayımlanan tebliğ', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 10],
        '6.h' => ['baslik' => 'Ulusal toplantıda sunulan ve özet metin yayımlanan tebliğ veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 5],

        // ══ 8. HAKEMLİK ══
        '8.d' => ['baslik' => 'Dergi hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 2],
        '8.g' => ['baslik' => 'Lisansüstü tez savunma jürisinde görev almak', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 2],

        // ══ 10-13. KİTAPLAR ══
        '10.a' => ['baslik' => 'Alanında ulusal yayımlanmış çeviri kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 30],
        '10.b' => ['baslik' => 'Alanında ulusal yayımlanmış derleme veya ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 45],
        '10.c' => ['baslik' => 'Alanında ulusal yayımlanmış özgün araştırma veya bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 60],
        '11.c' => ['baslik' => 'Alanında uluslararası yayımlanmış özgün araştırma veya bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI Kitap', 'BKCI / Scopus Kitap'], 'puan' => 100],
        '12.a' => ['baslik' => 'Ulusal yayımlanmış kitapta çeviri bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 15],
        '12.c' => ['baslik' => 'Ulusal yayımlanmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 30],
        '13.c' => ['baslik' => 'Uluslararası yayımlanmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 35],

        // ══ 15-16. EDİTÖRLÜK ══
        '15.a' => ['baslik' => 'Bilimsel veya ders kitabında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü', 'BKCI Kitap'], 'puan' => 10],
        '16.a' => ['baslik' => 'SSCI, SCI-Expanded veya AHCI dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 30],
        '16.b' => ['baslik' => 'ESCI dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 15],
        '16.d' => ['baslik' => 'Diğer hakemli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 5],
        '16.h' => ['baslik' => 'Dergide editörler kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 1],

        // ══ 17. ÖDÜLLER ══
        '17.a' => ['baslik' => 'TÜBA veya TÜBİTAK ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 100],
        '17.b' => ['baslik' => 'Yurt içi kamu kurum veya kuruluşundan alınan bilim ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 80],
        '17.d' => ['baslik' => 'Uluslararası kongre veya festival bilim kurulunca verilen ödül', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü', 'Yarışma Derecesi / Mansiyon'], 'puan' => 30],

        // ══ 18-19. TEZ YÖNETİMİ (ikinci danışman yarı puan) ══
        '18' => ['baslik' => 'Sonuçlandırılmış yüksek lisans tezi yönetmek', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 8],
        '18.b' => ['baslik' => 'Sonuçlandırılmış yüksek lisans tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 4],
        '19' => ['baslik' => 'Sonuçlandırılmış doktora veya tıpta uzmanlık tezi yönetmek', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 16],
        '19.b' => ['baslik' => 'Doktora veya uzmanlık tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 8],

        // ══ 20-21. PROJELER (yürütücü %100, araştırmacı/danışman %80) ══
        '20.a' => ['baslik' => 'TÜBA, TÜBİTAK, SAN-TEZ veya bakanlık destekli projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 75],
        '20.a2' => ['baslik' => 'TÜBA, TÜBİTAK, SAN-TEZ veya bakanlık destekli projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 60],
        '20.b' => ['baslik' => 'Diğer kamu veya yükseköğretim kurumlarınca desteklenmiş projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 35],
        '20.b2' => ['baslik' => 'Diğer kamu veya yükseköğretim kurumlarınca desteklenmiş projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 28],
        '20.c' => ['baslik' => 'Özel kuruluşlarca desteklenmiş projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 20],
        '20.c2' => ['baslik' => 'Özel kuruluşlarca desteklenmiş projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 16],
        '21.a' => ['baslik' => 'Dünya Bankası, Avrupa Birliği veya Avrupa Konseyi destekli projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 100],
        '21.a2' => ['baslik' => 'Dünya Bankası, Avrupa Birliği veya Avrupa Konseyi destekli projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 80],
        '21.b' => ['baslik' => 'Diğer uluslararası kurumca desteklenmiş projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 80],
        '21.b2' => ['baslik' => 'Diğer uluslararası kurumca desteklenmiş projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 64],

        // ══ 23. İDARİ VE AKADEMİK GÖREVLER ══
        '23.c' => ['baslik' => 'Uygulama ve araştırma merkezi müdürlüğü veya koordinatörlük', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü', 'Anabilim Dalı Başkanı / Koordinatörlük', 'Bölüm Başkanı', 'Dekan / Enstitü-YO Müdürü', 'Dekan Yrd. / Müdür Yrd.', 'Rektör', 'Rektör Yardımcısı'], 'puan' => 10],
        '23.g' => ['baslik' => 'Üniversite veya bağlı birimlerinde kurul ya da komisyon üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği', 'Senato / Üniversite Yönetim Kurulu Üyesi', 'Bölüm Başkan Yardımcısı'], 'puan' => 4],

        // ══ 25. SERGİ ══
        '25.a' => ['baslik' => 'Uluslararası özgün kişisel sanat etkinliği veya sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Elektronik Kişisel Sergi (Uluslararası)'], 'puan' => 60],
        '25.b' => ['baslik' => 'Ulusal özgün kişisel sanat etkinliği veya sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 30],
        '25.c' => ['baslik' => 'Davetli veya yarışmalı uluslararası karma etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Elektronik Karma Sergi (Uluslararası)'], 'puan' => 15],
        '25.d' => ['baslik' => 'Davetli veya yarışmalı ulusal karma etkinlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 10],

        // ══ 29. MÜZİK KOMPOZİSYONLARI ══
        '29.a' => ['baslik' => 'Sahne yapıtı bestelemek (opera, bale, oratoryo)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera/Bale Kompozisyonu', 'Orkestralı Sahne Eseri', 'Sahne/Ekran Müziği'], 'puan' => 25],
        '29.b' => ['baslik' => 'Senfonik yapıt bestelemek (senfoni, konçerto)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir'], 'puan' => 20],
        '29.c' => ['baslik' => 'Oda müziği, koro veya solo yapıt bestelemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)', 'Küçük Ölçekli Orkestra Eseri', 'Özgün Eser / Beste / Tasarım'], 'puan' => 15],
        '29.d' => ['baslik' => 'Eser düzenlemesi yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi'], 'puan' => 10],
        '29.e' => ['baslik' => 'Elektronik müzik yapıtı bestelemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)'], 'puan' => 15],

        // ══ 30-31. FİLM ══
        '30.a' => ['baslik' => 'Uzun metrajlı filmde yönetmenlik, görüntü yönetmenliği veya senaryo yazarlığı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Yönetmenlik (Sahne/Ekran)', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'], 'puan' => 20],
        '31.a' => ['baslik' => 'Kısa film veya belgeselde yönetmenlik ya da görüntü yönetmenliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)'], 'puan' => 10],

        // ══ 43. YURT İÇİ SANATSAL ETKİNLİKLER ══
        '43.a' => ['baslik' => 'Bireysel dinleti veya resital vermek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Ulusal)', 'Resital (Uluslararası)', 'Şan Resitali (Ulusal)', 'Şan Resitali (Uluslararası)'], 'puan' => 20],
        '43.b' => ['baslik' => 'Karma dinleti veya eşlikçi olarak katılım', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eğitici Konser Programı (Ulusal)', 'Eğitici Konser Programı (Uluslararası)'], 'puan' => 15],
        '43.d' => ['baslik' => 'Orkestra, opera veya balede solist olarak yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Solistlik (Ulusal)', 'Solistlik (Uluslararası)', 'Opera Birinci Rol (Ulusal)', 'Opera Birinci Rol (Uluslararası)', 'Oratoryo/Kantat Solistliği (Ulusal)', 'Oratoryo/Kantat Solistliği (Uluslararası)', 'Bale Başrol (Ulusal)', 'Bale Başrol (Uluslararası)'], 'puan' => 20],
        '43.e' => ['baslik' => 'Oda müziği dinletisinde yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Ulusal)', 'Oda Müziği Grup Üyeliği (Uluslararası)'], 'puan' => 15],
        '43.f' => ['baslik' => 'Orkestra, koro veya balede topluluk üyesi olarak yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra / Koro Üyeliği', 'Corps de Ballet (Ulusal)', 'Corps de Ballet (Uluslararası)', 'Opera İkinci Rol (Ulusal)', 'Opera İkinci Rol (Uluslararası)'], 'puan' => 5],
        '43.h' => ['baslik' => 'Audio yayını (kaset, CD) yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)', 'Karma Albüm / CD-DVD Katkısı', 'Eğitim Müziği Albümü'], 'puan' => 20],

        // ══ 45. YÖNETTİĞİ SANATSAL FAALİYETLER ══
        '45.a' => ['baslik' => 'Dinleti veya konser hazırlamak ve yönetmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koro Şefliği (Ulusal)', 'Koro Şefliği (Uluslararası)', 'Orkestra Şefliği (Ulusal)', 'Orkestra Şefliği (Uluslararası)', 'Opera Şefliği (Ulusal)', 'Opera Şefliği (Uluslararası)', 'Grup Şefliği (Ulusal)', 'Grup Şefliği (Uluslararası)'], 'puan' => 15],
        '45.f' => ['baslik' => 'Sanat çalıştayı, atölye veya masterclass yürütmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Masterclass (Ulusal)', 'Masterclass (Uluslararası)', 'Müzikoloji Atölyesi', 'Eğitim Amaçlı Sanat Etkinliği'], 'puan' => 5],

        // ══ 47. TESCİLLENMİŞ FİKRÎ MÜLKİYET ══
        '47.a' => ['baslik' => 'Alanında uluslararası tescillenmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 100],
        '47.b' => ['baslik' => 'Alanında ulusal tescillenmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Patent'], 'puan' => 80],
        '47.d' => ['baslik' => 'Belgelendirilmiş faydalı model veya endüstriyel tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 40],
    ],

    'gruplar' => [
        // Zorunlu maddeler. Nokta ŞART: '1*' deseni 10-19'u da yakalar.
        // 52 (ihtisaslaşma) cetvele girmedi, bu yüzden kümede yok.
        'ZORUNLU' => ['1.*', '2.*', '6.*', '10.*', '11.*', '12.*', '13.*'],
        'GS_UYGULAMALI' => ['25.*', '29.*', '30.*', '31.*', '43.*'],
        'MUZIK_SANATCILIK' => ['43.*', '45.*'],
        'KOMPOZISYON' => ['29.*'],
        'TEZ_YONETIMI' => ['18', '18.b', '19', '19.b'],
        '1.a' => ['1.a'],
        '1.c' => ['1.c'],
        'ATIF' => ['3.*'],
    ],

    // Madde 8/3: puanlama listesinde atıfların en fazla 30 puanı dikkate alınır.
    'grup_tavanlari' => [
        'ATIF' => 30,
    ],
];
