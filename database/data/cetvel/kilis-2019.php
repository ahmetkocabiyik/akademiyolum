<?php

/**
 * KİLİS 7 ARALIK ÜNİVERSİTESİ — Akademik Kadrolara Yükseltilme ve Atanma
 * Esaslarına İlişkin Puanlama Çizelgesi
 * Kaynak: pdf/17537001432.kilis7aralikuniverstesi.pdf
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
 * SANAT VE TASARIM BÖLÜMLERİ 01.09.2026'DA OKUNDU. 9-33 arası bölümler "puan
 * sütunları ayrıştırılamadı" diye kayıtlıydı ve Sanat ve Tasarım Dalları için
 * hiç eşik yazılmamıştı. `pdftotext -q -layout` ile çizelge eksiksiz çıkıyor;
 * sütun yalnızca başlığı iki-üç satıra taşan satırlarda kayıyor (19, 26, 27,
 * 28'in son satırı, 31, 33) ve orada da değer başlığın ORTA satırının
 * hizasında duruyor. Bölümler girildi, alan açıldı; bkz. yonerge/kilis.php.
 *
 * ── 34. BÖLÜMÜN PUANLARI YANLIŞTI, DÜZELTİLDİ ──
 * Bölüm "Uluslararası bilim ödülü 40 · Ulusal bilim ödülü 25 · Yabancı
 * ülkelerden alınan patent 20 · Ulusal patent ya da çeşit tescili 10" diyor.
 * Cetvelde uluslararası patent 30, ulusal patent 20 ve tek bir ödül satırı 10
 * puanla duruyordu: PATENTLER FAZLA, ÖDÜLLER EKSİK SAYIYORDU. Dört satır
 * kaynağa göre yeniden yazıldı. Faydalı model, endüstriyel tasarım, yazılım ve
 * ticarileştirme çıkarıldı — çizelge yalnızca "patent ya da çeşit tescili"
 * diyor. Burs satırı da çıkarıldı; çizelgede karşılığı yok.
 *
 * ── SANATSAL ÖDÜL İLE BİLİM ÖDÜLÜ AYRILAMIYOR ──
 * 22. bölüm sanatsal ödülleri 20/15/10/5, 34. bölüm bilim ödüllerini 40/25
 * puanlıyor; kayıtta ikisi tek 'Uluslararası/Ulusal Bilim/Sanat Ödülü'
 * etiketine düşüyor. §0 uyarınca genel ödül etiketleri 22'nin DÜŞÜK
 * değerlerinden (20 ve 5) sayılıyor; yalnız TÜBİTAK, TÜBA, YÖK ve ERC gibi
 * kendi etiketi olan bilim ödülleri 34'ten (40 ve 25) sayılıyor. 22. bölüm
 * sanat alt barajının saydığı kümede DEĞİL, yalnız genel toplama giriyor.
 *
 * AYNI KAYNAĞA DÜŞEN KALEMLERDE DÜŞÜK OLAN GİRİLDİ:
 *   'Kitap Editörlüğü' uluslararası/ulusal ayırmıyor → ulusal satır (40).
 *   'Ansiklopedi Maddesi' aynı şekilde → 10 (iki satır da 10).
 *   'Davetli Konuşmacı' ulusal/uluslararası ayırmıyor → ulusal çağrılı
 *       konuşma (4).
 *
 * ── SANAT BÖLÜMLERİNDE GİRİLMEYEN SATIRLAR ──
 *   9'da Devlet Resim ve Heykel Sergisi, üniversitelerin düzenlediği sergiler,
 *       kamu ve özel kuruluş sergileri — kayıt sergiyi düzenleyene göre
 *       ayırmıyor, hepsi karma/grup sergi etiketlerine düşüyor.
 *   18 (festival çalışmaları), 19 (belge çözümlenmesi ve yayını), 21
 *       (dia ve multivizyon gösterileri), 24 (tiyatro çalışmaları) ve 35
 *       (Erasmus) — sözlükte karşılık yok. 18, 19, 21 ve 24 zaten alt barajın
 *       saydığı kümede de değil.
 *   30'un karma dinleti, eşlikçi tanıtım ve Radyo-TV etkinliği satırları ile
 *       32'nin dinleti hazırlığı satırları — etiketleri 9 ve 25'te daha düşük
 *       değerle zaten bağlı; ikinci satır fazla sayardı.
 *   33'ün sonundaki "Ulusal bilimsel dergilerde hakemlik" satırı kaynakta
 *       yanlış bölüme düşmüş bir kopyala-yapıştır artığı; hakemlik 8.c'de
 *       zaten puanlanıyor, ikinci kez yazmak çifte sayım olurdu.
 */

return [
    'kapsam_notu' => 'Puanlar Kilis 7 Aralık Üniversitesi Puanlama Çizelgesinden. Yayın puanı '
        .'yazar sayısına göre paylaştırılır: iki isimlide her iki yazar da %80, üç isimlide '
        .'birinci veya corresponding yazar %80 diğerleri %60, daha fazlasında birinci %50 ve '
        .'kalan %50 eşit paylaşılıyor. PROJEDE ARAŞTIRMACI PUANINIZ GÖRÜNMEZ: yönerge yardımcı '
        .'araştırıcı puanını araştırıcı sayısına bölüyor, bu bölme faaliyet kaydından '
        .'türetilemediği için yalnızca yürütücü satırları girildi. SANATSAL ÖDÜL PUANINIZ '
        .'DÜŞÜK GÖRÜNEBİLİR: çizelge sanatsal ödülleri (22. bölüm) ile bilim ödüllerini '
        .'(34. bölüm) ayrı puanlıyor, faaliyet kaydı ikisini ayırmadığı için genel ödül '
        .'kayıtlarınız düşük olan sanatsal ödül değerinden sayılıyor.',

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
        '2.a' => ['baslik' => 'Uluslararası yayımlanan mesleki kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 50],
        '2.b' => ['baslik' => 'Ulusal yayımlanan mesleki kitap yazarlığı veya editörlüğü', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 40],
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
        // ══ 9. SERGİLER ══
        '9.a' => ['baslik' => 'Yurt içinde bireysel (kişisel) sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 20],
        '9.b' => ['baslik' => 'Yurt dışında bireysel (kişisel) sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)'], 'puan' => 20],
        '9.c' => ['baslik' => 'Ulusal bienal veya trienal', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 10],
        '9.ç' => ['baslik' => 'Uluslararası bienal veya trienal', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 25],
        '9.d' => ['baslik' => 'Yurt içinde grup sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Grup Etkinliği (Ulusal)'], 'puan' => 10],
        // Yurt dışı grup sergi (10) ile uluslararası grup sergi (15) tek etikete düşüyor; §0 uyarınca 10.
        '9.e' => ['baslik' => 'Yurt dışında grup sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Grup Etkinliği (Uluslararası)'], 'puan' => 10],
        '9.f' => ['baslik' => 'Yurt içinde karma sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 5],
        '9.g' => ['baslik' => 'Yurt dışında karma sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Karma Sergi (Uluslararası)'], 'puan' => 5],

        // ══ 10. KOLEKSİYON ══
        '10.a' => ['baslik' => 'Kumaş, giysi ya da aksesuar koleksiyonu tasarımı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulanmış Tasarım / Koleksiyon'], 'puan' => 20],
        // Resmî koleksiyon (10) ile özel koleksiyon (5) tek etikete düşüyor; §0 uyarınca 5.
        '10.b' => ['baslik' => 'Eserin koleksiyonda yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Yayında Yer Alması / Satın Alınması'], 'puan' => 5],

        // ══ 11. MÜZİK TEKNOLOJİSİ — UYGULAMA ══
        // Tonmaysterlik projesi (20), ses sistemi projesi (15) ve projeye katılım (5) tek etikette; §0 uyarınca 5.
        '11.a' => ['baslik' => 'Müzik teknolojisi uygulaması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Müzik Teknolojisi Uygulaması'], 'puan' => 5],

        // ══ 12. MÜZİK KOMPOZİSYONLARI ══
        '12.a' => ['baslik' => 'Sahne yapıtı (opera, bale, oratoryo vb.)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera/Bale Kompozisyonu', 'Orkestralı Sahne Eseri'], 'puan' => 25],
        '12.b' => ['baslik' => 'Senfonik yapıt (senfoni, konçerto vb.)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Küçük Ölçekli Orkestra Eseri'], 'puan' => 20],
        '12.c' => ['baslik' => 'Oda müziği, koro ya da solo yapıt', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)'], 'puan' => 15],
        '12.ç' => ['baslik' => 'Düzenleme', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi'], 'puan' => 10],
        '12.d' => ['baslik' => 'Elektronik müzik yapıtı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)'], 'puan' => 15],
        '12.e' => ['baslik' => 'Oyun için özgün müzik yapıtı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne/Ekran Müziği'], 'puan' => 10],

        // ══ 13-17. FİLM, DİZİ, PROGRAM VE REKLAM ══
        // Her bölümde yönetmen, görüntü yönetmeni ve yazar satırları tek etikete düşüyor; §0 uyarınca en düşüğü.
        '13.a' => ['baslik' => 'Uzun metrajlı filmde yönetmen, görüntü yönetmeni, kurgu ya da senaryo', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uzun Metrajlı Film / Belgesel (Uluslararası)', 'Uzun Metrajlı Film / Belgesel (Ulusal)'], 'puan' => 20],
        '14.a' => ['baslik' => 'Kısa film veya belgeselde yönetmen ya da görüntü yönetmeni', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)'], 'puan' => 10],
        '15.a' => ['baslik' => 'TV filmi veya dizisinde yönetmen, görüntü yönetmeni ya da senaryo yazarı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['TV Filmi / Dizisi (Uluslararası)', 'TV Filmi / Dizisi (Ulusal)'], 'puan' => 10],
        '16.a' => ['baslik' => 'TV programında yönetmen, kameraman ya da metin yazarı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['TV Programı (Uluslararası)', 'TV Programı (Ulusal)'], 'puan' => 5],
        '17.a' => ['baslik' => 'Reklam veya tanıtım filminde yönetmen, kameraman ya da metin yazarı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Reklam / Tanıtım Filmi (Uluslararası)', 'Reklam / Tanıtım Filmi (Ulusal)'], 'puan' => 3],

        // ══ 20. RESTORASYON ══
        // Taşınmaz (15) ile taşınabilir (10) eski eser ayrımı kayıtta yok; §0 uyarınca 10.
        '20.a' => ['baslik' => 'Eski eser restorasyonu', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)'], 'puan' => 10],

        // ══ 22. SANATSAL ÖDÜLLER ══ (sanat alt barajının SAYMADIĞI bölüm; yalnız toplama giriyor)
        // Kayıt bilim ödülü ile sanat ödülünü ayırmıyor; 34. bölümün 40/25 satırlarıyla çakışan
        // genel ödül etiketleri §0 uyarınca buradaki DÜŞÜK değerlerden sayılıyor.
        '22.a' => ['baslik' => 'Uluslararası sanatsal ödül', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü'], 'puan' => 20],
        '22.b' => ['baslik' => 'Ulusal sanatsal ödül', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 5],

        // ══ 25. OYUN YAZARLIĞI ══
        // Uzun oyun (20), kısa oyun (10) ve dizi-drama (5) tek etikete düşüyor; §0 uyarınca 5.
        '25.a' => ['baslik' => 'Sahne, radyo, TV ya da sinema için oyun veya senaryo yazarlığı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'], 'puan' => 5],

        // ══ 26. SAHNE VE KOSTÜM TASARIMI ══
        // 26 (dekor) ve 27 (kostüm) tek etikete düşüyor; dört satırın en düşüğü 10.
        '26.a' => ['baslik' => 'Oyun, film ya da televizyon prodüksiyonunda dekor veya kostüm tasarımı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne Tasarımı (Dekor, Kostüm, Işık)'], 'puan' => 10],

        // ══ 28-29. MİMARLIK YARIŞMALARI VE JÜRİLİKLER ══
        '28.a' => ['baslik' => 'Mimarlık proje yarışmasında derece ya da mansiyon', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 10],
        // 23. bölümün jüri satırları (20/10) ile aynı etikette; §0 uyarınca 10.
        '29.a' => ['baslik' => 'Sanatsal ya da mimari yarışmada jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 10],

        // ══ 30-31. SANATSAL ETKİNLİKLER ══ (31: aynı etkinlik yurt dışındaysa +5 ek puan)
        '30.a' => ['baslik' => 'Yurt içinde bireysel dinleti', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Ulusal)'], 'puan' => 20],
        '30.b' => ['baslik' => 'Yurt içinde orkestra, opera ya da balede solistlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Solistlik (Ulusal)'], 'puan' => 20],
        '30.c' => ['baslik' => 'Yurt içinde oda müziği dinletisi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Ulusal)'], 'puan' => 15],
        '30.ç' => ['baslik' => 'Orkestra (tutti), opera korosu ya da bale topluluğunda yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra / Koro Üyeliği', 'Corps de Ballet (Uluslararası)', 'Corps de Ballet (Ulusal)'], 'puan' => 5],
        '30.d' => ['baslik' => 'Audio yayını (kaset, CD)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)', 'Karma Albüm / CD-DVD Katkısı', 'Eğitim Müziği Albümü'], 'puan' => 20],
        '31.a' => ['baslik' => 'Yurt dışında bireysel dinleti', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Uluslararası)'], 'puan' => 25],
        '31.b' => ['baslik' => 'Yurt dışında orkestra, opera ya da balede solistlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Solistlik (Uluslararası)'], 'puan' => 25],
        '31.c' => ['baslik' => 'Yurt dışında oda müziği dinletisi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Uluslararası)'], 'puan' => 20],

        // ══ 32-33. YÖNETİLEN SANATSAL FAALİYETLER ══
        // Bölümün en düşük satırı orkestra/opera/bale etkinliği hazırlama (3); şeflik
        // etiketleri tür ayrımı taşımadığı için §0 uyarınca hepsi oradan sayılıyor.
        '32.a' => ['baslik' => 'Yurt içinde orkestra, opera, bale, koro ya da topluluk şefliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra Şefliği (Ulusal)', 'Opera Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Ulusal)', 'Koro Şefliği (Ulusal)', 'Grup Şefliği (Ulusal)'], 'puan' => 3],
        '33.a' => ['baslik' => 'Yurt dışında orkestra, opera, bale, koro ya da topluluk şefliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra Şefliği (Uluslararası)', 'Opera Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Uluslararası)', 'Koro Şefliği (Uluslararası)', 'Grup Şefliği (Uluslararası)'], 'puan' => 8],

        // ══ 34. ÖDÜLLER, PATENTLER ══
        '34.a' => ['baslik' => 'Uluslararası bilim ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ufuk Avrupa / ERC Ödülü'], 'puan' => 40],
        '34.b' => ['baslik' => 'Ulusal bilim ödülü (TÜBİTAK, TÜBA, TDK vb.) ya da ilanlı ve jürili ödül', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 25],
        '34.c' => ['baslik' => 'Yabancı ülkelerden alınan patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
        '34.ç' => ['baslik' => 'Ulusal patent ya da çeşit tescili', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 10],

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
        // Madde 7/3-c'nin birebir saydığı küme. 18, 19, 22, 23, 24 ve 35 KASITLI OLARAK
        // DIŞARIDA: yönerge o numaraları saymıyor, satırları yalnız genel toplama giriyor.
        // 21 (dia ve multivizyon gösterileri) sayılan küme içinde ama sözlükte
        // karşılığı yok, satırı yazılmadı; 27 (kostüm tasarımı) 26.a'ya birleşti.
        '9-34' => ['9.*', '10.*', '11.*', '12.*', '13.*', '14.*', '15.*', '16.*', '17.*',
            '20.*', '25.*', '26.*', '28.*', '29.*', '30.*', '31.*', '32.*', '33.*', '34.*'],
        'ULUSLARARASI_MAKALE' => ['1.a', '1.c'],
        'ULUSAL_MAKALE' => ['1.d', '1.f'],
        'SCI_MAKALE' => ['1.a'],
    ],

    'grup_tavanlari' => [],
];
