<?php

/**
 * BAYBURT ÜNİVERSİTESİ — Akademik Yükseltilme ve Atanma Puan Tablosu
 * Kaynak: pdf/17536931482.bayburtuniverstesi.pdf (Bölüm 4)
 *
 * TEK ORTAK PUAN TABLOSU. Koşullar tabloya BÖLÜM NUMARASIYLA atıf yapıyor
 * ("4. maddesinden en az 20 puan, 1. ve 4. maddelerinden en az 60 puan,
 * 1., 2., 3., 4., 5. ve 6. maddelerinden en az 100 puan"), bu yüzden numaralar
 * birebir korundu.
 *
 * NUMARALAR TEK HANELİ; GRUP DESENİNDE NOKTA ŞART: '1*' deseni 10-12'yi de
 * yakalar. Bütün gruplarda '1.*' biçimi kullanıldı.
 *
 * ÜÇ KATMANLI ALT BARAJ — korpusta ender bir yapı. Her kadroda üç ayrı alt
 * baraj üst üste biniyor: yalnızca projelerden (4), makale ve projelerden
 * (1+4), sonra bütün yayın kalemlerinden (1-6). Yani proje üretmeyen aday
 * puanı ne olursa olsun geçemiyor.
 *
 * YAZAR PAYLAŞIMI FORMÜLLE VERİLMİŞ (Tanım 3): tek yazarlı tam puan; iki
 * yazarlıda başlıca yazar 0,8 ve ikinci yazar 0,5; üç ve daha fazla yazarlıda
 * başlıca yazar yarısını, diğerleri kalan yarıyı EŞİT PAYLAŞIYOR. Son kural
 * motorun `bol` alanıyla girildi: 0,5 / (n − 1).
 *
 * KİTAP VE BİLDİRİDE FARKLI KURAL UYGULANMIYOR: Tanım 3/ç "diğer yayınlarda
 * (bildiri, kitap, kitap bölümü) toplam puan yazarlar arasında eşit olarak
 * bölünür" diyor, yani 1/n. Motor cetvel başına tek bir yazar matrisi
 * tanımlıyor; makale kuralı uygulandığı için ÇOK YAZARLI KİTAP VE BİLDİRİDE
 * PUAN OLDUĞUNDAN YÜKSEK görünür.
 *
 * 11(2) VE 12. BÖLÜMLER 01.09.2026'DA OKUNDU. İkisi de "puan sütunu
 * ayrıştırılamadı" diye kayıtlıydı ve Güzel Sanatlar alanı bu yüzden hiç
 * girilmemişti. `pdftotext -layout` ile tablo eksiksiz çıkıyor; puan sütununun
 * kaydığı tek yer başlığı iki satıra taşan satırlar (11.2.1.a, 11.2.7.a-ç,
 * 11.2.9.d-g, 11.2.10.a-b), orada da değer başlığın ORTA satırının hizasında
 * duruyor. Sanat ve tasarım etkinlikleri (11.2) ve toplumsal katkı (12)
 * girildi; Güzel Sanatlar eşikleri açıldı, bkz. yonerge/bayburt.php.
 *
 * AYNI KAYNAĞA DÜŞEN KALEMLERDE DÜŞÜK OLAN GİRİLDİ:
 *   'Kitap Editörlüğü' uluslararası/ulusal ayırmıyor → 2.1.c (50) yerine
 *       2.2.e (15).
 *   'Hakemlik' dergi düzeyi taşımıyor → 8.2.ç (2).
 *   'Yayın Kurulu Üyeliği' aynı şekilde → 8.2.b (10).
 *
 * 11.2'DE AYNI ETİKETE DÜŞÜP DÜŞÜĞÜ GİRİLEN ÇİFTLER (§0): restorasyonda
 * "yapmak ve üstlenmek" ile "ekipte yer almak" (11.2.7.a/b ve c/ç), film
 * gösterisinde "uluslararası etkinlik" ile "yurt dışı etkinlik" (11.2.8.a/b),
 * mimari projede yurt dışı ile yurt içi yürütücülük (11.2.9.a/c — 11.2.9.f ve
 * g de aynı etikete düşüyor), orkestra üyeliğinde yurt dışı ile yurt içi
 * (11.2.10.d/e) ve senfonik özgün eserde yurt dışı ile yurt içi (11.2.10.j/k).
 *
 * GİRİLMEYEN BÖLÜMLER: 11.1 (spor bilimleri) — sözlükte spor kategorisi yok.
 * 11.2.8.e-h (film yaratıcı kadrosunda yer almak) ve 11.2.9.e (logo, afiş,
 * poster, kapak tasarımı) — sözlükte karşılıkları yok, geniş bir kovaya
 * bağlamak fazla sayardı. 12. bölümün 12.a-12.h satırları (uluslararası ve
 * ulusal kuruluş üyelikleri, teknopark, bilirkişilik, jüri üyelikleri) de
 * karşılıksız; toplumsal katkı kategorisinin üç etiketi 12.ı, 12.j ve 12.k'ye
 * bağlandı.
 */

return [
    'kapsam_notu' => 'Puanlar Bayburt Üniversitesi Akademik Yükseltilme ve Atanma Puan '
        .'Tablosundan. Makale puanı yazar sayısına göre paylaştırılır (Tanım 3: iki yazarlıda '
        .'başlıca 0,8 ikinci 0,5; üç ve daha fazlada başlıca yarısını, diğerleri kalan yarıyı '
        .'eşit paylaşır). ÇOK YAZARLI KİTAP VE BİLDİRİDE PUANINIZ YÜKSEK GÖRÜNÜR: yönerge o '
        .'kalemlerde puanı yazar sayısına eşit bölüyor, motor cetvel başına tek matris '
        .'tanımladığı için makale kuralı uygulandı. Spor bilimleri (11.1) bölümü girilemedi; '
        .'toplumsal katkı (12) bölümünden yalnızca danışmanlık, topluma yönelik etkinlik ve '
        .'yayın satırları girildi.',

    // Tanım 3 — Ortak Yazar Puan Dağılımı.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'proje', 'patent', 'editorluk', 'odul', 'egitim_ogretim',
            'tez_danismanligi', 'idari_gorev', 'toplumsal_katki'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.0]],
            'ilk' => ['kademeler' => [1 => 1.0, 2 => 0.80], 'sonrasi' => 0.50],
            'baslica' => ['kademeler' => [1 => 1.0, 2 => 0.80], 'sonrasi' => 0.50],
            // Üç ve daha fazla yazarlıda diğerleri kalan yarıyı eşit paylaşır.
            'yazar_2' => ['kademeler' => [2 => 0.50], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
            'yazar_3' => ['bol' => ['pay' => 0.5, 'eksi' => 1]],
            'yazar_4' => ['bol' => ['pay' => 0.5, 'eksi' => 1]],
            'yazar_5' => ['bol' => ['pay' => 0.5, 'eksi' => 1]],
            'yazar_6' => ['bol' => ['pay' => 0.5, 'eksi' => 1]],
            'ortak' => ['kademeler' => [1 => 1.0, 2 => 0.50], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
        ],
    ],

    'maddeler' => [
        // ══ 1. MAKALE ══
        '1.1.a' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI Q1 dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 180],
        '1.1.b' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI Q2 dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 140],
        '1.1.c' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI Q3 dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 100],
        '1.1.ç' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI Q4 dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 60],
        '1.1.d' => ['baslik' => 'ESCI veya alan indeksli dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 40],
        '1.1.f' => ['baslik' => 'SCI, SSCI veya AHCI Q1-Q3 dergide teknik not, editöre mektup ya da vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 30],
        '1.1.g' => ['baslik' => 'Q4, ESCI veya alan indeksli dergide teknik not, editöre mektup ya da vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI', 'ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 20],
        '1.2.a' => ['baslik' => 'ULAKBİM TR Dizin dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 40],
        '1.2.b' => ['baslik' => 'Diğer ulusal hakemli dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 5],
        '1.2.c' => ['baslik' => 'Ulusal hakemli dergide teknik not, editöre mektup ya da vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 10],

        // ══ 2. KİTAP VE ÇEVİRİLER ══
        '2.1.a' => ['baslik' => 'Uluslararası kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 150],
        '2.1.b' => ['baslik' => 'Uluslararası kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 30],
        '2.2.a' => ['baslik' => 'Ulusal bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 100],
        '2.2.b' => ['baslik' => 'Ulusal bilimsel kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 20],
        '2.2.ç' => ['baslik' => 'Ulusal ders kitabı yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 50],
        '2.2.e' => ['baslik' => 'Kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 15],
        '2.3.c' => ['baslik' => 'Türkçe yayımlanan bilimsel kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 140],
        '2.3.ç' => ['baslik' => 'Türkçe yayımlanan bilimsel kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 30],

        // ══ 3. BİLİMSEL TOPLANTI ══
        '3.1.a' => ['baslik' => 'Uluslararası toplantıda sözlü sunulan ve tam metni yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Uluslararası Tam Metin (CPCI)'], 'puan' => 40],
        '3.1.b' => ['baslik' => 'Uluslararası toplantıda sözlü sunulan ve özeti yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 20],
        '3.2.ç' => ['baslik' => 'Bilimsel toplantıda davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 15],
        '3.2.a' => ['baslik' => 'Ulusal toplantıda sözlü sunulan ve tam metni yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 20],
        '3.2.b' => ['baslik' => 'Ulusal toplantıda sözlü sunulan ve özeti yayımlanan bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 10],

        // ══ 4. BİLİMSEL ARAŞTIRMA PROJESİ ══
        '4.1.a' => ['baslik' => 'BM, Dünya Bankası veya AB Çerçeve destekli projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 200],
        '4.1.b' => ['baslik' => 'AB Çerçeve destekli projede araştırmacı veya danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 100],
        '4.1.ç' => ['baslik' => 'Diğer uluslararası bilimsel araştırma projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 50],
        '4.1.d' => ['baslik' => 'Diğer uluslararası bilimsel araştırma projesinde araştırmacı veya danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
        '4.2.ç' => ['baslik' => 'TÜBİTAK veya bakanlık destekli projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 100],
        '4.2.d' => ['baslik' => 'TÜBİTAK veya bakanlık destekli projede araştırmacı ya da danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 50],
        '4.2.e' => ['baslik' => 'TÜBİTAK 2209 gibi öğrenci projelerinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'puan' => 10],
        '4.2.g' => ['baslik' => 'Diğer kurumlardan destekli bilimsel projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 20],
        '4.2.ğ' => ['baslik' => 'Diğer kurumlardan destekli bilimsel projede araştırmacı ya da danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
        '4.2.i' => ['baslik' => 'Üniversite BAP projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 50],
        '4.2.l' => ['baslik' => 'Üniversite BAP projesinde araştırmacı, danışman ya da bursiyer olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 25],

        // ══ 5. PATENTLER VE TESCİL BELGESİ ══
        '5.a' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 200],
        '5.b' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 100],
        '5.ç' => ['baslik' => 'Faydalı model veya endüstriyel tasarımın belgelendirilmesi', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 50],

        // ══ 6. ATIF ══
        '6.a' => ['baslik' => 'SSCI, SCI-Expanded veya AHCI dergisinde atıf', 'kategori' => 'atif', 'kaynaklar' => ['SCIE/SSCI/AHCI', 'ESCI'], 'puan' => 5],
        '6.c' => ['baslik' => 'ULAKBİM TR Dizin dergisinde atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
        '6.ç' => ['baslik' => 'Diğer ulusal hakemli dergide atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer'], 'puan' => 1],
        '6.d' => ['baslik' => 'Uluslararası kitapta atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 5],

        // ══ 7. EĞİTİM VE ÖĞRETİME KATKI ══
        '7.ç' => ['baslik' => 'Tamamlanmış doktora tezinde asıl danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 100],
        '7.d' => ['baslik' => 'Tamamlanmış doktora tezinde eş danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 25],
        '7.e' => ['baslik' => 'Tamamlanmış yüksek lisans tezinde asıl danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 25],
        '7.f' => ['baslik' => 'Tamamlanmış yüksek lisans tezinde eş danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 10],
        '7.g' => ['baslik' => 'Tez izleme komitesi veya jüri üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 2],
        '7.h' => ['baslik' => 'Verilen ders (dönem ve ders başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 1],

        // ══ 8. EDİTÖRLÜK VE HAKEMLİK ══
        '8.1.a' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI dergide baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 200],
        '8.1.ç' => ['baslik' => 'ESCI veya alan indeksli dergide baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 50],
        '8.1.f' => ['baslik' => 'Diğer uluslararası dergide baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi (Uluslararası)'], 'puan' => 20],
        '2.1.e' => ['baslik' => 'Yabancı dilde uluslararası bilimsel ders kitabı editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 30],
        '8.2.a' => ['baslik' => 'ULAKBİM TR Dizin dergide baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 50],
        '8.2.b' => ['baslik' => 'Dergide editör kurulu üyeliği veya dil editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 10],
        '8.2.ç' => ['baslik' => 'Dergi hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 2],

        // ══ 9. ÖDÜL ══
        '9.a' => ['baslik' => 'TÜBİTAK veya TÜBA bilim ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 200],
        '9.b' => ['baslik' => 'YÖK Doktora Tezi Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü'], 'puan' => 140],
        '9.c' => ['baslik' => 'Uluslararası bilimsel yarışmada ilk üç derece', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 50],
        '9.f' => ['baslik' => 'Ulusal bilimsel yarışmada derece veya ulusal kurumlarca verilen ödül', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'Yarışma Derecesi / Mansiyon', 'Burs'], 'puan' => 20],

        // ══ 10. KURUMSAL KATKI (en az 1 yıl görev şartıyla) ══
        '10.c' => ['baslik' => 'Dekanlık, yüksekokul veya enstitü müdürlüğü (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü', 'Rektör', 'Rektör Yardımcısı'], 'puan' => 10],
        '10.ç' => ['baslik' => 'Dekan yardımcılığı veya müdür yardımcılığı (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkanı', 'Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 5],
        '10.d' => ['baslik' => 'Uygulama ve araştırma merkezi müdürlüğü (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 10],

        // ══ 11.2. SANAT VE TASARIM ETKİNLİKLERİ ══
        // Güzel Sanatlar alt barajının saydığı bölüm (Madde 10 a.3/b.2/c.3/ç.2).
        '11.2.1.a' => ['baslik' => 'Yurt dışında tanınmış müze, kültür merkezi ya da sanat galerisinde kişisel sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)'], 'puan' => 80],
        '11.2.1.b' => ['baslik' => 'Yurt içinde tanınmış müze, kültür merkezi ya da sanat galerisinde kişisel sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 60],
        '11.2.2.a' => ['baslik' => 'Yurt dışında tanınmış müze veya büyük koleksiyonda yapıtının yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)'], 'puan' => 60],
        '11.2.2.b' => ['baslik' => 'Yurt içinde tanınmış müze veya büyük koleksiyonda yapıtının yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Yayında Yer Alması / Satın Alınması'], 'puan' => 30],
        '11.2.3.a' => ['baslik' => 'Yurt dışında kamusal ya da özel alanda sergilenen sanat veya tasarım ürünü', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kamusal Alanda Uygulanmış Yapıt (Yurt Dışı)'], 'puan' => 60],
        '11.2.3.b' => ['baslik' => 'Yurt içinde kamusal ya da özel alanda sergilenen sanat veya tasarım ürünü', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kamusal Alanda Uygulanmış Yapıt (Yurt İçi)'], 'puan' => 30],
        '11.2.4.a' => ['baslik' => 'Uluslararası karma sergi veya çalıştay', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Karma Sergi (Uluslararası)'], 'puan' => 30],
        '11.2.4.b' => ['baslik' => 'Ulusal karma sergi veya çalıştay', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 15],
        '11.2.5.a' => ['baslik' => 'Çağrılı veya jürili uluslararası sergi, bienal, trienal, festival, uygulamalı sempozyum ya da gösteri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 40],
        '11.2.5.b' => ['baslik' => 'Çağrılı veya jürili ulusal sergi, bienal, trienal, festival, uygulamalı sempozyum ya da gösteri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 20],
        '11.2.6.a' => ['baslik' => 'Yurt dışı sanatsal faaliyetlerin düzenleyiciliği, kuruculuğu veya küratörlüğü', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sergi Küratörlüğü (Uluslararası)', 'Festival Koordinatörlüğü (Uluslararası)'], 'puan' => 40],
        '11.2.6.b' => ['baslik' => 'Ulusal sanatsal faaliyetlerin düzenleyiciliği, kuruculuğu veya küratörlüğü', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sergi Küratörlüğü (Ulusal)', 'Festival Koordinatörlüğü (Ulusal)'], 'puan' => 20],
        // 11.2.7.a (60) ile 11.2.7.b (30) tek etikete düşüyor; §0 uyarınca 30. Aynısı c (30) ile ç (15) için.
        '11.2.7.b' => ['baslik' => 'Yurt dışında müze, kazı buluntusu, koleksiyon ya da film arşivi restorasyon ve konservasyon çalışmasında görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koruma-Onarım Uygulaması (Uluslararası)'], 'puan' => 30],
        '11.2.7.ç' => ['baslik' => 'Ulusal müze, kazı buluntusu, koleksiyon ya da film arşivi restorasyon ve konservasyon çalışmasında görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koruma-Onarım Uygulaması (Ulusal)'], 'puan' => 15],
        // 11.2.8.a (uluslararası etkinlik, 60) ile 11.2.8.b (yurt dışı etkinlik, 40) tek etikete düşüyor; §0 uyarınca 40.
        '11.2.8.b' => ['baslik' => 'Yurt dışı etkinliklerde film gösterisi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Uluslararası)', 'Uzun Metrajlı Film / Belgesel (Uluslararası)'], 'puan' => 40],
        '11.2.8.c' => ['baslik' => 'Ulusal etkinliklerde film gösterisi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Ulusal)', 'Uzun Metrajlı Film / Belgesel (Ulusal)'], 'puan' => 30],
        '11.2.8.ç' => ['baslik' => 'Yurt dışında kitle iletişim araçlarıyla yapılan yayınlarda filminin yayımlanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'TV Filmi / Dizisi (Uluslararası)', 'TV Programı (Uluslararası)'], 'puan' => 50],
        '11.2.8.d' => ['baslik' => 'Ulusal yayınlarda filminin yayımlanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'TV Filmi / Dizisi (Ulusal)', 'TV Programı (Ulusal)'], 'puan' => 30],
        // 11.2.9.a (yurt dışı, 30) ile 11.2.9.c (yurt içi, 20) tek 'müellif' etiketine düşüyor; §0 uyarınca 20.
        // 11.2.9.f ve 11.2.9.g de aynı etikete düşüyor (60 ve 30) ve zaten 20 geçerli.
        '11.2.9.c' => ['baslik' => 'Mimari proje, planlama ya da tasarım çalışmasında yürütücü olmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif'], 'puan' => 20],
        '11.2.9.ç' => ['baslik' => 'Mimari proje, planlama ya da tasarım çalışmasında görevli olmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman'], 'puan' => 10],
        '11.2.9.d' => ['baslik' => 'Kamu kurumları ile özel hukuk tüzel kişileri bünyesinde uygulamaya konmuş sanatsal tasarım', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulanmış Tasarım / Koleksiyon'], 'puan' => 15],
        '11.2.10.a' => ['baslik' => 'Yurt dışında sahne sanatlarında sanat grubu hazırlamak ve gösterisini sunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Grup Etkinliği (Uluslararası)'], 'puan' => 60],
        '11.2.10.b' => ['baslik' => 'Yurt içinde sahne sanatlarında sanat grubu hazırlamak ve gösterisini sunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Grup Etkinliği (Ulusal)'], 'puan' => 30],
        '11.2.10.c' => ['baslik' => 'Yurt dışı orkestra eşliğinde solistlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Solistlik (Uluslararası)'], 'puan' => 80],
        '11.2.10.ç' => ['baslik' => 'Yurt içi orkestra eşliğinde solistlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Solistlik (Ulusal)'], 'puan' => 40],
        // 11.2.10.d (yurt dışı, 60) ile 11.2.10.e (yurt içi, 30) tek etikete düşüyor; §0 uyarınca 30.
        '11.2.10.e' => ['baslik' => 'Orkestra içinde görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra / Koro Üyeliği'], 'puan' => 30],
        '11.2.10.f' => ['baslik' => 'Yurt dışı resital', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Uluslararası)'], 'puan' => 60],
        '11.2.10.g' => ['baslik' => 'Yurt içi resital', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Ulusal)'], 'puan' => 40],
        '11.2.10.ğ' => ['baslik' => 'Yurt dışı etkinliklerde şeflik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Grup Şefliği (Uluslararası)', 'Orkestra Şefliği (Uluslararası)', 'Koro Şefliği (Uluslararası)', 'Opera Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Uluslararası)'], 'puan' => 80],
        '11.2.10.h' => ['baslik' => 'Yurt içi etkinliklerde şeflik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Grup Şefliği (Ulusal)', 'Orkestra Şefliği (Ulusal)', 'Koro Şefliği (Ulusal)', 'Opera Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Ulusal)'], 'puan' => 40],
        '11.2.10.ı' => ['baslik' => 'Yurt dışı oda müziği konserinde grup üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Uluslararası)'], 'puan' => 80],
        '11.2.10.i' => ['baslik' => 'Yurt içi oda müziği konserinde grup üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Ulusal)'], 'puan' => 40],
        // 11.2.10.j (yurt dışı, 80) ile 11.2.10.k (yurt içi, 60) tek etikete düşüyor; §0 uyarınca 60.
        '11.2.10.k' => ['baslik' => 'Senfonik yapıt (senfoni, konçerto vb.) türünde özgün eser', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir'], 'puan' => 60],
        '11.2.10.l' => ['baslik' => 'Metotlaştırılmış etüt, egzersiz vb. eğitim müziği dizini', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eğitim Müziği Düzenlemesi', 'Eğitim Müziği Albümü'], 'puan' => 60],

        // ══ 12. TOPLUMSAL KATKI ══
        '12.ı' => ['baslik' => 'Özel sektör, kamu ya da STK danışmanlığı', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı'], 'puan' => 5],
        '12.j' => ['baslik' => 'Topluma yönelik eğitim, seminer ya da çalıştay düzenlemek veya görev almak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi'], 'puan' => 5],
        '12.k' => ['baslik' => 'Topluma yönelik yayın, sunum ya da konferans', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Bilim İletişimi / Popüler Yayın'], 'puan' => 5],
        '11.1.b' => ['baslik' => 'Uluslararası spor federasyonunun yönetim, teknik, eğitim ya da hakem kurulunda görev', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Spor Federasyonu Kurul Üyeliği (Uluslararası)'], 'puan' => 50],
        '11.1.p' => ['baslik' => 'Ulusal spor federasyonunun yönetim, teknik, eğitim ya da hakem kurulunda görev', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Spor Federasyonu Kurul Üyeliği (Ulusal)'], 'puan' => 8],
        '3.1.d' => ['baslik' => 'Uluslararası bilimsel toplantı düzenleme kurulu başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 70],
        '3.2.d' => ['baslik' => 'Ulusal bilimsel toplantı düzenleme kurulu başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Ulusal)'], 'puan' => 35],
        '3.1.g' => ['baslik' => 'Uluslararası bilimsel toplantı düzenleme ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 20],
        '3.2.g' => ['baslik' => 'Ulusal bilimsel toplantı düzenleme ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 8],
        '3.1.h' => ['baslik' => 'Uluslararası bilimsel toplantıda oturum başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Uluslararası)'], 'puan' => 10],
        '3.2.h' => ['baslik' => 'Ulusal bilimsel toplantıda oturum başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Ulusal)'], 'puan' => 5],
        '10.l' => ['baslik' => 'BAP bilimsel komisyonu ya da benzeri kurul üyeliği (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 2],
    ],

    'gruplar' => [
        // Koşulların birebir andığı bölüm kümeleri. Nokta ŞART: '1*' deseni
        // 10-12'yi de yakalar.
        '4' => ['4.*'],
        '1 ve 4' => ['1.*', '4.*'],
        '1-6' => ['1.*', '2.*', '3.*', '4.*', '5.*', '6.*'],
        // Güzel Sanatlar alt kümesi: aynı bölümler + sanat ve tasarım etkinlikleri.
        '1-6 ve 11.2' => ['1.*', '2.*', '3.*', '4.*', '5.*', '6.*', '11.2.*'],
        'MAKALE' => ['1.1.a', '1.1.b', '1.1.c', '1.1.ç', '1.1.d', '1.2.a', '1.2.b'],
    ],

    'grup_tavanlari' => [],
];
