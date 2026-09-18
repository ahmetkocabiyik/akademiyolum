<?php

/**
 * BOLU ABANT İZZET BAYSAL ÜNİVERSİTESİ — Madde 8: Akademik Etkinlik Puan Tablosu
 * Kaynak: pdf/17536991342.boluabantizzetbaysaluniversitesi.pdf
 *
 * TEK ORTAK PUAN TABLOSU, ALAN GRUBUNA GÖRE AYRI EŞİK. Koşullar tabloya
 * "A1-A8", "A" ve "I" gibi harf-numara aralıklarıyla atıf yaptığı için kodlar
 * birebir korundu.
 *
 * BİTLİS EREN İLE AYNI ŞABLON, FARKLI PUANLAR. İki yönerge de aynı EK
 * düzenini (A yayınlar, B toplantılar, C editörlük, D Ar-Ge, E eğitim,
 * F diğer, G toplumsal katkı, H akademik görev, I sanat, J mimari tasarım)
 * kullanıyor; Bolu'nun kitap kalemleri belirgin biçimde yüksek (A.7.1 70'e
 * karşı 50), makale kalemleri aynı.
 *
 * SANAT BÖLÜMÜ (I) GİRİLDİ — Bitlis'te girilememişti. Güzel Sanatlar
 * koşullarının yarısı bu bölümü sayıyor ("puanın %25'i A, %25'i I"), bu yüzden
 * Güzel Sanatlar eşikleri burada eksiksiz duruyor.
 *
 * YAZAR ÇARPANI SAYI × SIRA MATRİSİ (Madde 10/1): 1 yazarlı %100 … 11 ve üzeri
 * yazarlıda 1. isim %50, 3. isim ve sonrası taban %20. Atıflar açıkça hariç.
 * "Diğer durumlarda çevirmen, raportör, proje yapanlar, editör, ödül alanlar,
 * patent sahibi veya düzenleyici sayısına eşit olarak bölünecektir" kuralı
 * faaliyet kaydından türetilemediği için o kalemlerde çarpan uygulanmıyor —
 * puanınız olduğundan YÜKSEK görünebilir.
 *
 * AYNI KAYNAĞA DÜŞEN KALEMLERDE DÜŞÜK OLAN GİRİLDİ:
 *   'Kitap Editörlüğü' uluslararası/ulusal ayırmıyor → A.7.2 (50) yerine
 *       A.8.2 (30).
 *   'Ansiklopedi Maddesi' aynı şekilde → A.7.5 (8) yerine A.8.7 (4).
 *   'Yayın Kurulu Üyeliği' dergi düzeyi taşımıyor → C.1.2 (20) yerine
 *       C.5.2 (7); 'Hakemlik' aynı şekilde C.5.3 (1).
 *
 * GİRİLMEYEN KALEMLER: A.4 (indeks kapsamı dışındaki uluslararası dergiler —
 * sözlükte karşılığı yok, A.3 ile aynı kaynağa düşerdi), C.3/C.4 (dergi düzeyi
 * ayrılamıyor), D.2 (bilimsel rapor), D.3.8-D.3.11 (mimari ve sanat yarışma
 * dereceleri), D.4 (burslar dışında kalanlar), F (etkinlik düzenleme kurulları),
 * G (toplumsal katkı alt kırılımları), H (jüri üyelikleri), J (mimari tasarım)
 * ve I bölümünün metot yazarlığı, derleme, okul müziği gibi alt kalemleri.
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 */

return [
    'kapsam_notu' => 'Puanlar Bolu Abant İzzet Baysal Üniversitesi Madde 8 tablosundan. Makale, '
        .'bildiri, kitap ve sanat kalemlerinde puan yazar sayınıza ve sıranıza göre azaltılır '
        .'(Madde 10/1); yazar listesini boş bırakırsanız uygulanamaz. Proje, patent, editörlük '
        .'ve ödül kalemlerindeki "kişi sayısına eşit bölünür" kuralı faaliyet kaydından '
        .'türetilemediği için uygulanmıyor; o kalemlerde puanınız olduğundan yüksek görünebilir. '
        .'Etkinlik düzenleme kurulları (F), toplumsal katkı (G), jüri üyelikleri (H) ve mimari '
        .'tasarım (J) bölümleri girilmedi.',

    // Madde 10/1 — Eserdeki yazar sayısına ve sıraya göre tam puanın yüzdesi.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'egitim_ogretim',
            'tez_danismanligi', 'idari_gorev', 'toplumsal_katki'],
        // Yönerge makale dışındaki kalemler için AYRI bir kural veriyor:
        // "Diğer durumlarda ise çevirmen, raportör, proje yapanlar, editör,
        // ödül alanlar, patent sahibi veya düzenleyici sayısına eşit olarak
        // bölünecektir." Yani makalenin sıraya bağlı kademe tablosu değil,
        // düz 1/n. Bunları `haric`te bırakmak FAZLA SAYMAK olurdu (§0).
        'kategoriler' => [
            'proje' => ['sonrasi_pay' => 1.0],
            'patent' => ['sonrasi_pay' => 1.0],
            'editorluk' => ['sonrasi_pay' => 1.0],
            'odul' => ['sonrasi_pay' => 1.0],
        ],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.0]],
            'ilk' => ['kademeler' => [1 => 1.0, 2 => 1.0, 3 => 0.90, 4 => 0.85, 5 => 0.80,
                6 => 0.75, 7 => 0.70, 8 => 0.65, 9 => 0.60, 10 => 0.55], 'sonrasi' => 0.50],
            'baslica' => ['kademeler' => [1 => 1.0, 2 => 1.0, 3 => 0.90, 4 => 0.85, 5 => 0.80,
                6 => 0.75, 7 => 0.70, 8 => 0.65, 9 => 0.60, 10 => 0.55], 'sonrasi' => 0.50],
            'yazar_2' => ['kademeler' => [2 => 0.90, 3 => 0.80, 4 => 0.75, 5 => 0.70, 6 => 0.65,
                7 => 0.60, 8 => 0.55, 9 => 0.50, 10 => 0.45], 'sonrasi' => 0.40],
            'yazar_3' => ['kademeler' => [3 => 0.70, 4 => 0.65, 5 => 0.60, 6 => 0.55, 7 => 0.40,
                8 => 0.30, 9 => 0.25], 'sonrasi' => 0.20],
            'yazar_4' => ['kademeler' => [4 => 0.55, 5 => 0.50, 6 => 0.45, 7 => 0.30,
                8 => 0.25], 'sonrasi' => 0.20],
            'yazar_5' => ['kademeler' => [5 => 0.40, 6 => 0.35, 7 => 0.20], 'sonrasi' => 0.20],
            'yazar_6' => ['kademeler' => [6 => 0.25], 'sonrasi' => 0.20],
            // Sırasını belirtmeyen aday o yazar sayısındaki en düşük yüzdeyi alır.
            'ortak' => ['kademeler' => [1 => 1.0, 2 => 0.90, 3 => 0.70, 4 => 0.55, 5 => 0.40,
                6 => 0.25], 'sonrasi' => 0.20],
        ],
    ],

    'maddeler' => [
        // ══ A — YAYINLAR VE ATIFLAR ══
        'A.1.1' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergide makale (derleme dâhil)', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 50],
        'A.1.2' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergide olgu sunumu, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 25],
        'A.2.1' => ['baslik' => 'Web of Science taranan diğer (ESCI) dergide makale (derleme dâhil)', 'kategori' => 'makale', 'kaynaklar' => ['ESCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 30],
        'A.2.2' => ['baslik' => 'Web of Science taranan diğer (ESCI) dergide olgu sunumu, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['ESCI'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 15],
        'A.3.1' => ['baslik' => 'Diğer uluslararası indeksli dergide makale (derleme dâhil)', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 20],
        'A.3.2' => ['baslik' => 'Diğer uluslararası indeksli dergide olgu sunumu, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Scopus'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 10],
        'A.5.1' => ['baslik' => 'ULAKBİM TR Dizin dergide makale (derleme dâhil)', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 20],
        'A.5.2' => ['baslik' => 'TR Dizin dergide olgu sunumu, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 10],
        'A.6.1' => ['baslik' => 'TR Dizin dışı ulusal hakemli dergide makale (derleme dâhil)', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 10],
        'A.6.2' => ['baslik' => 'TR Dizin dışı ulusal dergide olgu sunumu, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 5],
        'A.7.1' => ['baslik' => 'Uluslararası yayınevince yabancı dilde basılmış kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 70],
        'A.7.3' => ['baslik' => 'Uluslararası yayınevi kitabında bölüm yazarlığı veya kitapçık', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 40],
        'A.8.1' => ['baslik' => 'Ulusal yayınevince Türkçe basılmış kitap veya ders kitabı yazarlığı (en az 50 sayfa)', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı'], 'puan' => 40],
        'A.8.2' => ['baslik' => 'Kitap editörlüğü (en az 50 sayfa)', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 30],
        'A.8.3' => ['baslik' => 'Kitapçık veya kitap bölümü yazarlığı (50 sayfadan az)', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 20],
        'A.8.4' => ['baslik' => 'Kitap çevirmenliği (en az 50 sayfa)', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 10],
        'A.8.6' => ['baslik' => 'Kitap bölümü, kitapçık veya makale çevirmenliği (50 sayfadan az)', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 5],
        'A.8.7' => ['baslik' => 'Ansiklopedi madde tanımlaması', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 4],
        'A.9.1' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergisinde atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
        'A.9.4' => ['baslik' => 'Uluslararası kitapta atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 3],
        'A.10.1' => ['baslik' => 'TR Dizin dergisinde atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 1],
        'A.10.3' => ['baslik' => 'Ulusal kitapta veya diğer hakemli dergide atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer'], 'puan' => 1],

        // ══ B — BİLİMSEL TOPLANTILAR ══
        'B.1.1' => ['baslik' => 'Uluslararası etkinlikte sunulan ve indeksli dergide/kitapta yayımlanan tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Uluslararası Tam Metin (CPCI)'], 'puan' => 10],
        'B.1.5' => ['baslik' => 'Uluslararası bilimsel etkinlikte yayımlanan bildiri özeti veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 6],
        'B.1.7' => ['baslik' => 'Bilimsel etkinlikte çağrılı veya davetli bildiri sunmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 12],
        'B.2.1' => ['baslik' => 'Ulusal bilimsel etkinlik kitabında sözlü tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 7],
        'B.2.3' => ['baslik' => 'Ulusal bilimsel etkinlik kitabında bildiri özeti veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 4],

        // ══ C — DERGİ EDİTÖRLÜĞÜ, YAYIN KURULU ÜYELİĞİ VE HAKEMLİK ══
        'C.1.1' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergide baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 30],
        'C.2.1' => ['baslik' => 'Web of Science taranan diğer (ESCI) dergide baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 15],
        'C.5.1' => ['baslik' => 'Ulusal hakemli dergide baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 10],
        'C.5.2' => ['baslik' => 'Dergide yayın kurulu üyeliği, editörlük veya özel sayı editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 7],
        'C.5.3' => ['baslik' => 'Dergi hakemliği (makale başına)', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 1],
        'C.6' => ['baslik' => 'Kitap editörlüğü (uluslararası yayınevi)', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 10],

        // ══ D — ARAŞTIRMA-GELİŞTİRMEYE DAYALI FAALİYETLER ══
        'D.1.1' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 40],
        'D.1.2' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
        'D.1.3' => ['baslik' => 'TÜBİTAK, bakanlık veya kalkınma ajansı projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 30],
        'D.1.4' => ['baslik' => 'TÜBİTAK, bakanlık veya kalkınma ajansı projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],
        'D.1.5' => ['baslik' => 'Üniversite veya yerel kuruluşlarca desteklenen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 10],
        'D.1.6' => ['baslik' => 'Üniversite veya yerel kuruluşlarca desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 5],
        'D.3.1' => ['baslik' => 'Uluslararası bilimsel kuruluşlarca verilen bilim, teşvik veya hizmet ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 50],
        'D.3.2' => ['baslik' => 'TÜBİTAK veya TÜBA gibi ulusal kuruluşlarca verilen bilim, teşvik veya hizmet ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 30],
        'D.3.6' => ['baslik' => 'Ulusal kuruluşlarca verilen bilim, kültür, sanat veya spor ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'Yarışma Derecesi / Mansiyon'], 'puan' => 10],
        'D.4.2.1' => ['baslik' => 'Bilimsel araştırma amaçlı burs (üç ay ve üzeri)', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 10],
        'D.5.1' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 60],
        'D.5.2' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım'], 'puan' => 30],

        // ══ E — EĞİTİM-ÖĞRETİM FAALİYETLERİ ══
        'E.1.1' => ['baslik' => 'Tamamlanan yüksek lisans tezinde danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 10],
        'E.1.2' => ['baslik' => 'Tamamlanan yüksek lisans tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 5],
        'E.1.2.1' => ['baslik' => 'Tamamlanan doktora, uzmanlık veya sanatta yeterlik tezinde danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 20],
        'E.1.2.2' => ['baslik' => 'Doktora tezinde ikinci danışmanlık veya tez izleme komitesi üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi', 'Tez İzleme / Jüri Üyeliği'], 'roller' => ['es_danisman'], 'puan' => 10],
        'E.2' => ['baslik' => 'Verilen ders (dönem başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 2],

        // ══ I — SANAT ÇALIŞMALARI ══
        // I-1 Müzik ve Müzik Eğitimi
        'I.1.1.1' => ['baslik' => 'Senfonik yapıt (senfoni, konçerto vb.)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Orkestralı Sahne Eseri', 'Opera/Bale Kompozisyonu'], 'puan' => 30],
        'I.1.1.2' => ['baslik' => 'En az 15 dakikalık oda müziği, orkestra veya koro eseri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda/Koro Müziği Eseri (≥15 dk)', 'Elektronik Müzik Eseri (≥15 dk)'], 'puan' => 20],
        'I.1.1.3' => ['baslik' => '15 dakikadan kısa oda müziği, orkestra veya koro eseri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Küçük Ölçekli Orkestra Eseri', 'Özgün Eser / Beste / Tasarım'], 'puan' => 12],
        'I.1.1.4' => ['baslik' => 'Özgün kullanım müziği (film, televizyon dizisi vb.)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne/Ekran Müziği'], 'puan' => 8],
        'I.1.1.5' => ['baslik' => 'Orta ölçekli eser düzenleme', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi'], 'puan' => 6],
        'I.1.1.6' => ['baslik' => 'Eğitim amaçlı özgün çalgı veya ses albümü besteleme (en az 10 parça)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eğitim Müziği Albümü'], 'puan' => 20],
        'I.1.2.1' => ['baslik' => 'Eserlerinin uluslararası müzik topluluklarınca kaydının yayımlanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)', 'Karma Albüm / CD-DVD Katkısı'], 'puan' => 10],
        'I.1.4.5' => ['baslik' => 'Seçici kurullu uluslararası müzik etkinliğinde resital veya solo gösteri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Uluslararası)', 'Şan Resitali (Uluslararası)', 'Solistlik (Uluslararası)', 'Oratoryo/Kantat Solistliği (Uluslararası)'], 'puan' => 16],
        'I.1.4.6' => ['baslik' => 'Seçici kurullu ulusal müzik etkinliğinde resital veya solo gösteri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Ulusal)', 'Şan Resitali (Ulusal)', 'Solistlik (Ulusal)', 'Oratoryo/Kantat Solistliği (Ulusal)'], 'puan' => 8],
        'I.1.4.9' => ['baslik' => 'Yurt dışında veya uluslararası etkinlikte koro ya da orkestra yönetimi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koro Şefliği (Uluslararası)', 'Orkestra Şefliği (Uluslararası)', 'Opera Şefliği (Uluslararası)', 'Grup Şefliği (Uluslararası)'], 'puan' => 8],
        'I.1.4.10' => ['baslik' => 'Yurt içinde koro veya orkestra yönetimi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koro Şefliği (Ulusal)', 'Orkestra Şefliği (Ulusal)', 'Opera Şefliği (Ulusal)', 'Grup Şefliği (Ulusal)'], 'puan' => 4],
        'I.1.4.11' => ['baslik' => 'Yurt dışında veya uluslararası etkinlikte topluluk üyesi olarak toplu konser', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Uluslararası)'], 'puan' => 8],
        'I.1.4.12' => ['baslik' => 'Yurt içinde topluluk üyesi olarak toplu konser veya gösteri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Ulusal)', 'Orkestra / Koro Üyeliği'], 'puan' => 4],
        'I.1.5.1' => ['baslik' => 'Sahada geleneksel müzik eseri derleme', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Müzikoloji Atölyesi'], 'puan' => 10],
        // I-2 Görsel ve Plastik Sanatlar
        'I.2.1.1' => ['baslik' => 'Yurt dışında özgün yapıtlarından oluşan kişisel sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)'], 'puan' => 20],
        'I.2.1.2' => ['baslik' => 'Yurt içinde özgün yapıtlarından oluşan kişisel sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)'], 'puan' => 10],
        'I.2.1.3' => ['baslik' => 'Seçici kurullu uluslararası sanat etkinliğinde (bienal, trienal) yapıtıyla yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 16],
        'I.2.1.4' => ['baslik' => 'Seçici kurullu ulusal sanat etkinliğinde yapıtıyla yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 8],
        'I.2.1.5' => ['baslik' => 'Yurt dışında özgün yapıtlarının yer aldığı karma sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Jürisiz)'], 'puan' => 10],
        'I.2.1.6' => ['baslik' => 'Yurt içinde özgün yapıtlarının yer aldığı karma sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Jürisiz, Ulusal)'], 'puan' => 5],
        'I.2.1.7' => ['baslik' => 'Elektronik ortamda kişisel sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Elektronik Kişisel Sergi (Ulusal)', 'Elektronik Kişisel Sergi (Uluslararası)'], 'puan' => 8],
        'I.2.1.8' => ['baslik' => 'Elektronik ortamda karma sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Elektronik Karma Sergi (Ulusal)', 'Elektronik Karma Sergi (Uluslararası)'], 'puan' => 4],
        'I.2.2.1' => ['baslik' => 'Eserlerinin yurt dışındaki müzelerce satın alınması veya koleksiyona kabulü', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)'], 'puan' => 26],
        'I.2.2.2' => ['baslik' => 'Eserlerinin yurt içindeki müzelerce satın alınması veya koleksiyona kabulü', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Yayında Yer Alması / Satın Alınması'], 'puan' => 13],
        'I.2.3.1' => ['baslik' => 'Yapıtlarının uluslararası yayında yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Haber Olması (Uluslararası)'], 'puan' => 10],
        'I.2.3.2' => ['baslik' => 'Yapıtlarının ulusal yayında yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Haber Olması (Ulusal)'], 'puan' => 5],
        'I.2.4.1' => ['baslik' => 'Uluslararası sanat etkinliğinde jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Uluslararası)'], 'puan' => 10],
        'I.2.4.2' => ['baslik' => 'Ulusal sanat etkinliğinde jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Üyeliği (Ulusal)', 'Jüri Başkanlığı (Ulusal)'], 'puan' => 5],
        'I.2.5.1' => ['baslik' => 'Yurt dışında veya uluslararası etkinlikte sanat çalıştayı ya da atölye liderliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Masterclass (Uluslararası)'], 'puan' => 12],
        'I.2.5.4' => ['baslik' => 'Yurt içinde sanat çalıştayı veya atölye liderliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Masterclass (Ulusal)', 'Eğitim Amaçlı Sanat Etkinliği'], 'puan' => 6],
        'G.2.3' => ['baslik' => 'Bilimsel ya da mesleki kurum ve kuruluşların yönetiminde, kurullarında veya komisyonlarında görev', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dış Kuruluş Kurul Üyeliği (Ulusal)'], 'puan' => 5],
        // F BÖLÜMÜ DÖRT BLOK: F.1 uluslararası kongre · F.2 uluslararası
        // çalıştay · F.3 ulusal kongre · F.4 ulusal çalıştay; her blokta üç
        // rol ayrı puanlı. Her etiket KENDİ KAPSAMININ iki bloğunun en
        // düşüğünü alır (başkanlık 15/10 · kurul üyeliği 8/5 · oturum 3/2).
        // Önce altısı da F.4'e (ULUSAL ÇALIŞTAY) yazılmıştı.
        'F.1.1' => ['baslik' => 'Uluslararası bilimsel toplantı düzenleme kurulu başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 15],
        'F.4.1' => ['baslik' => 'Ulusal bilimsel toplantı düzenleme kurulu başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Ulusal)'], 'puan' => 10],
        'F.1.3' => ['baslik' => 'Uluslararası bilimsel toplantı düzenleme ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 8],
        'F.4.3' => ['baslik' => 'Ulusal bilimsel toplantı düzenleme ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 5],
        // Kaynak F.1.4 uluslararası kongre 5, F.2.4 uluslararası çalıştay 3, F.3.4 ulusal kongre 3, F.4.4 ulusal çalıştay 2.
        'F.4.4' => ['baslik' => 'Uluslararası bilimsel ya da sanatsal toplantıda oturum başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Uluslararası)'], 'puan' => 3],
        'F.4.4-ulusal' => ['baslik' => 'Ulusal bilimsel ya da sanatsal toplantıda oturum başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Ulusal)'], 'puan' => 2],
    ],

    'gruplar' => [
        // Nokta ŞART: 'A.1*' deseni 'A.10.1' atıf kalemini de yakalar.
        'A1-A8' => ['A.1.*', 'A.2.*', 'A.3.*', 'A.5.*', 'A.6.*', 'A.7.*', 'A.8.*'],
        'A' => ['A.*'],
        'I' => ['I.*'],
    ],

    'grup_tavanlari' => [],
];
