<?php

/**
 * ESKİŞEHİR TEKNİK ÜNİVERSİTESİ — EK-3: Yükseltilme ve Atanma Yönergesi
 * Ölçütleri
 * Kaynak: pdf/17536994022.eskisehirteknikuniversitesi.pdf (16 sayfa;
 * MADDE 13 uyarınca 2/1/2026'da yürürlüğe girer)
 *
 * MADDE KODLARI YÖNERGENİN KENDİSİ (1a-1ğ, 2a-2b, 3a-3b, 4a1-4d, 5a-5b,
 * 6a, 7a-7e, 8a-8e, 9a-9c, 10a-10ç, 11a-11ç, 12a-12e). EK-5'in asgari
 * koşul tabloları bu kodlara ve madde numaralarına atıf yapıyor
 * ("1a-ç kapsamında 240 puan", "1, 2, 7 ve 8 maddelerinden 400 puan").
 *
 * ── PROJE PUANI AY BAŞINA: MOTORDA HESAPLANAMIYOR ──
 * 4. maddenin bütün satırları "[(20)x(ay)]" biçiminde, yani puan proje
 * süresiyle çarpılıyor. Faaliyet kaydında projenin ay sayısı yok; satırlar
 * AY BAŞINA değerle girildi. Yirmi dört aylık bir AB projesi yürütücülüğü
 * gerçekte 480 puan ederken burada 20 puan sayılıyor — bu, korpustaki en
 * büyük tek sapma ve kapsam notunun ilk cümlesi bunu söylüyor.
 * Aynı sorun 6a (haftalık ders saati çarpanı), 10a-10c (yıl çarpanı) ve
 * 12ç (yıl çarpanı) satırlarında da var.
 *
 * "Biten/Devam eden" ayrımı da kayıtta yok; §0 uyarınca DEVAM EDEN
 * (düşük) değer girildi.
 *
 * ── AYNI KAYNAĞA DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   1ğ (kısa yayınlar) "yukarıdaki puanların %25'i" diyor; her basamak
 *       için ayrı satır açmak yerine EN DÜŞÜK basamağın (1g = 50) %25'i
 *       olan 12 puanla tek satırda toplandı.
 *   2a kitap yazarlığı ile bölüm yazarlığı (300/75) ayrı etiketlerde;
 *       2b'nin dört değeri (kitap 100 / çeviri 60 / bölüm 25 / bölüm
 *       çevirisi 15) kendi etiketlerine dağıtıldı.
 *   3a CPCI tam metin ve özet (75/30), 3b diğer toplantı (35/15): tam
 *       metin ve özet etiketleri ayrı olduğu için dördü de girildi.
 *   8. maddenin "Tescillenmiş / Olumlu araştırma raporu almış" çiftleri:
 *       kayıt bu ayrımı taşımadığı için DÜŞÜK (araştırma raporu) değer
 *       girildi (uluslararası patent 150, ulusal 80, faydalı model 75/40).
 *   10a-10c editörlük ile yayın kurulu üyeliği (300/100, 150/50, 75/25):
 *       'Yayın Kurulu Üyeliği' tek etiket olduğu için en düşük değerde
 *       (25) toplandı; editörlük basamakları kendi dergi etiketlerinde.
 *   11c/11ç etkinlik ve yükseköğretim kurumu ödülleri (50/30, 50) → 30.
 *   12a düzenleme kurulu başkanlığı, eş başkanlığı ve üyeliği
 *       (80/40/20) → 20.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   7b (uygulanmış tasarım projesi hakkında yazılmış makale/kitap) ve 7c
 *       (yazılım üreticiliği) — 7ç ile aynı 'Uygulama Projesi' etiket
 *       ailesine düşerlerdi; 7ç 200 puanla o etiketleri aldı.
 *   12b (eğitim sertifika programı), 12d (öğrenci takımı danışmanlığı) —
 *       sözlükte karşılıksız ya da yıl çarpanına bağlı.
 *   1ğ dışındaki tür ayrımları: yönerge derleme ile araştırma makalesini
 *       ayrı fiyatlandırmıyor, ikisi de aynı satırdan sayılıyor.
 *
 * ── UYGULANAN TAVANLAR ──
 * Madde 6 (eğitim faaliyetleri) 400 · Madde 9'un b ve c bentleri 200 ·
 * Madde 10 (editörlük ve hakemlik) 600, hakemlik alt kalemi 100 — hepsi
 * maddelerin kendi açıklamalarından.
 *
 * ── MOTORUN KARŞILAYAMADIĞI DİĞER KURALLAR ──
 *   EK-4/IX: "uluslararası iş birliğiyle yapılan çalışmalardan alınan
 *       puanlar 1,25 ile çarpılır" ve EK-4/X: "disiplinlerarası
 *       çalışmalarda 1,25 ile çarpılır" — ortak yazarın adresi ve bölümü
 *       kayıtta yok; iki çarpan da uygulanmadı, puan DÜŞÜK görünür.
 *   6a'nın "İngilizce ders 1,5 ile çarpılır" ve "öğrenci memnuniyeti 3,5
 *       üzerindeyse 1,5 ile çarpılır" kuralları.
 *   2b açıklaması "aynı kitapta en fazla 2 bölüm", 3b açıklaması "aynı
 *       toplantıda en fazla 2 sunum", 7d açıklaması "aynı eser bir kez" —
 *       eser bazlı tavanlar.
 *   5. madde açıklaması "devam eden tezlerde öngörülen puanın yarısı" ve
 *       "ikinci danışman yarısını alır" — ikincisi `es_danisman` rolüyle
 *       karşılandı, birincisi (devam eden tez) kayıtta yok.
 *
 * Yönerge: yonerge/eskisehir-teknik.php
 */

return [
    'kapsam_notu' => 'Puanlar Eskişehir Teknik Üniversitesi EK-3 ölçütler çizelgesinden. '
        .'EN ÖNEMLİ SINIRLAMA: yönerge proje puanlarını AY BAŞINA veriyor ("20 × ay"), ders '
        .'puanını haftalık ders saatiyle, editörlük puanını görev yılıyla çarpıyor. Faaliyet '
        .'kaydında süre bilgisi olmadığı için bu satırlar tek ay, tek saat ve tek yıl değeriyle '
        .'girildi; proje, ders ve editörlük puanınız gerçekte olduğundan ÇOK DÜŞÜK görünür. '
        .'Bu kalemlere bağlı barajlar (özellikle doçentlik ve profesörlükteki proje koşulu) '
        .'olduğundan çok zor görünür. '
        .'Yazar çarpanı EK-4/VIII\'e göre işliyor: tam puan × [1 − 0,1 × (yazar sayısı − 1)]; '
        .'on yazardan fazlasında her yazar tam puanın onda birini alır. Yazar listesini boş '
        .'bırakırsanız çarpan hiç uygulanmaz ve puanınız olduğundan YÜKSEK görünür. '
        .'Puanınız ayrıca şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: patent ve faydalı model '
        .'satırlarında "tescillenmiş" ile "olumlu araştırma raporu almış" ayrımı kayıtta '
        .'olmadığı için düşük değer sayılıyor; projelerde "biten" ile "devam eden" ayrımı da '
        .'aynı sebeple devam eden değerinden; yayın kurulu üyeliği en düşük basamaktan; '
        .'uluslararası iş birliği ve disiplinlerarası çalışma için verilen 1,25 çarpanları '
        .'uygulanmıyor. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünebilir: aynı kitaptan ikiden fazla '
        .'bölümünüz ya da aynı toplantıda ikiden fazla sunumunuz varsa hepsi sayılır.',

    // EK-4/VIII: tam puan × [1 − 0,1 × (yazar sayısı − 1)], 10'dan fazlada 0,1.
    // Katsayı isim sırasına bakmıyor, bütün yazarlar aynı çarpanı alıyor.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev',
            'odul', 'editorluk', 'toplumsal_katki'],
        'roller' => (function (): array {
            $tablo = ['kademeler' => [
                1 => 1.0, 2 => 0.9, 3 => 0.8, 4 => 0.7, 5 => 0.6,
                6 => 0.5, 7 => 0.4, 8 => 0.3, 9 => 0.2, 10 => 0.1,
            ], 'sonrasi' => 0.1];

            return [
                'tek' => ['kademeler' => [1 => 1.0]],
                'ilk' => $tablo,
                'baslica' => $tablo,
                'yazar_2' => $tablo,
                'yazar_3' => $tablo,
                'yazar_4' => $tablo,
                'yazar_5' => $tablo,
                'yazar_6' => $tablo,
                'ortak' => $tablo,
            ];
        })(),
    ],

    'maddeler' => [
        // ══ 1. MAKALE ══
        '1a' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q1 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 300],
        '1b' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q2 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 250],
        '1c' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q3 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 200],
        '1ç' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q4 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 150],
        '1d' => ['baslik' => 'AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 250],
        '1e' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 100],
        '1f' => ['baslik' => 'TR Dizin kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 75],
        '1g' => ['baslik' => 'Diğer ulusal veya uluslararası indekslerde taranan hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 50],
        '1ğ' => ['baslik' => 'Hakemli dergide yayımlanmış editöre mektup, araştırma notu, özet, vaka raporu, teknik not veya kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI', 'ESCI / Scopus', 'TR Dizin', 'Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 12],

        // Lisansüstü tezden üretilmiş yayınlar için ayna satırlar. EK-5'in
        // "Lisansüstü Tezlerden Üretilmiş Yayın Sayısı" sütunu 1a-g kod
        // aralığına atıf yapıyor ama motorda tez yayını ayrı bir kategori;
        // koşul değerlendirilebilsin diye aynı basamaklar `tez_yayini`
        // kategorisinde de açıldı. `tez_yayini` kaynak sözlüğü çeyreklik
        // taşımadığı için Q1-Q4 tek satırda ve EN DÜŞÜK değerde (150)
        // toplandı: tezinden Q1 makale üreten aday bu satırdan 300 yerine
        // 150 puan alır.
        '1a-ç-tez' => ['baslik' => 'Tezinizden üretilmiş, SCIE, SSCI veya AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 150],
        '1e-tez' => ['baslik' => 'Tezinizden üretilmiş, ESCI veya Scopus kapsamındaki dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 100],
        '1f-tez' => ['baslik' => 'Tezinizden üretilmiş, TR Dizin kapsamındaki dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['TR Dizin'], 'puan' => 75],
        '1g-tez' => ['baslik' => 'Tezinizden üretilmiş, diğer indekslerde taranan hakemli dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Diğer', 'CPCI Bildiri'], 'puan' => 50],

        // ══ 2. KİTAP ══
        '2a-kitap' => ['baslik' => 'Web of Science BKCI kapsamındaki bilimsel veya mesleki kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 300],
        '2a-bolum' => ['baslik' => 'Web of Science BKCI kapsamındaki kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 75],
        '2b-kitap' => ['baslik' => 'Diğer bilimsel veya mesleki kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı'], 'puan' => 100],
        '2b-ceviri' => ['baslik' => 'Kitap çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 60],
        '2b-bolum' => ['baslik' => 'Diğer bilimsel veya mesleki kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 25],
        '2b-bolum-ceviri' => ['baslik' => 'Kitap bölümü çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 15],

        // ══ 3. BİLİMSEL TOPLANTI ══
        '3a-tam' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan ve CPCI\'da tam metin yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 75],
        '3a-ozet' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan ve CPCI\'da özet yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 30],
        '3b-tam' => ['baslik' => 'Diğer uluslararası veya ulusal bilimsel toplantıda sunulan ve tam metin yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Ulusal Tam Metin'], 'puan' => 35],
        '3b-ozet' => ['baslik' => 'Diğer uluslararası veya ulusal bilimsel toplantıda sunulan ve özet yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster', 'Davetli Konuşmacı'], 'puan' => 15],

        // ══ 4. PROJELER (ay çarpanı uygulanamadı, AY BAŞINA değer) ══
        '4a1' => ['baslik' => 'Uluslararası kuruluşça desteklenen araştırma projesinde koordinatör, yönetici ya da yürütücü (ay başına)', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 10],
        '4a2' => ['baslik' => 'Uluslararası kuruluşça desteklenen araştırma projesinde araştırmacı ya da uzman (ay başına)', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci'], 'puan' => 8],
        '4a3' => ['baslik' => 'Uluslararası kuruluşça desteklenen araştırma projesinde danışman ya da bursiyer (ay başına)', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 3],
        '4b1' => ['baslik' => 'TÜBİTAK, TÜBA, TÜSEB, bakanlık ya da eşdeğer kurumlarca desteklenen projede yürütücü (ay başına)', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 4],
        '4b2' => ['baslik' => 'TÜBİTAK, TÜBA, TÜSEB, bakanlık ya da eşdeğer kurumlarca desteklenen projede araştırmacı ya da uzman (ay başına)', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci'], 'puan' => 3],
        '4b3' => ['baslik' => 'TÜBİTAK, TÜBA, TÜSEB, bakanlık ya da eşdeğer kurumlarca desteklenen projede danışman ya da bursiyer (ay başına)', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 2],
        '4c1' => ['baslik' => 'Girişimcilik, bilim insanı destekleme ya da öğrenci projelerinde koordinatör veya yürütücü (ay başına)', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 3],
        '4c2' => ['baslik' => 'Girişimcilik, bilim insanı destekleme ya da öğrenci projelerinde araştırmacı veya uzman (ay başına)', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 1],
        '4ç1' => ['baslik' => 'Yükseköğretim kurumları dışındaki kamu ya da özel kuruluşlarca desteklenen Ar-Ge projesinde yürütücü (ay başına)', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 6],
        '4ç2' => ['baslik' => 'Yükseköğretim kurumları dışındaki kamu ya da özel kuruluşlarca desteklenen Ar-Ge projesinde araştırmacı (ay başına)', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 2],
        '4d' => ['baslik' => 'Üniversite BAP komisyonunca desteklenen sonuçlanmış araştırma projesinde görev almak (ay başına)', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'puan' => 1],

        // ══ 5. TEZ DANIŞMANLIĞI ══
        '5a' => ['baslik' => 'Tamamlanmış doktora veya sanatta yeterlik tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 150],
        '5a-es' => ['baslik' => 'Tamamlanmış doktora veya sanatta yeterlik tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 75],
        '5b' => ['baslik' => 'Tamamlanmış tezli yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 75],
        '5b-es' => ['baslik' => 'Tamamlanmış tezli yüksek lisans tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'roller' => ['es_danisman'], 'puan' => 37],

        // ══ 6. EĞİTİM FAALİYETLERİ (grup tavanı 400, saat çarpanı uygulanamadı) ══
        '6a' => ['baslik' => 'Lisansüstü, lisans veya ön lisans düzeyinde ders vermek (haftalık ders saati başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi', 'Akreditasyon Faaliyeti'], 'puan' => 3],

        // ══ 7. PLANLAMA, TASARIM VE SANAT FAALİYETLERİ ══
        '7a-uluslararasi' => ['baslik' => 'Alanınızda uluslararası kişisel sergi açmak ya da koleksiyon hazırlayıp sunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)'], 'puan' => 200],
        '7a-ulusal' => ['baslik' => 'Alanınızda ulusal kişisel sergi açmak ya da koleksiyon hazırlayıp sunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 125],
        '7ç' => ['baslik' => 'Alanınızda özgün tasarım ya da tasarım, planlama veya koruma projesi yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman', 'Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)', 'Özgün Eser / Beste / Tasarım'], 'puan' => 200],
        '7d-uluslararasi' => ['baslik' => 'Jürili uluslararası mimarlık, planlama, tasarım veya sanat etkinliğine eserinizle kabul edilerek yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Karma Sergi (Uluslararası)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], 'puan' => 75],
        '7d-ulusal' => ['baslik' => 'Jürili ulusal mimarlık, planlama, tasarım veya sanat etkinliğine eserinizle kabul edilerek yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 50],
        '7e-uluslararasi' => ['baslik' => 'Eserinizin uluslararası bir müze, kültür merkezi ya da koleksiyonda kalıcı olarak yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Yayında Yer Alması / Satın Alınması'], 'puan' => 100],
        '7e-ulusal' => ['baslik' => 'Eserinizin ulusal bir müze, kültür merkezi ya da koleksiyonda kalıcı olarak yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Satın Alınması (Yurt İçi)'], 'puan' => 75],

        // ══ 8. FİKRİ HAKLAR (tescil/araştırma raporu ayrımı yok, düşük değer) ══
        '8a' => ['baslik' => 'Alanınızda uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 150],
        '8b' => ['baslik' => 'Alanınızda ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 80],
        '8c-8ç' => ['baslik' => 'Alanınızda faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 40],
        '8d-8e' => ['baslik' => 'Alanınızda tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım', 'Yazılım', 'Ticarileştirme'], 'puan' => 50],

        // ══ 9. ATIF (b ve c bentleri için grup tavanı 200) ══
        '9a' => ['baslik' => 'Patentte, SCIE, SSCI, AHCI dergilerinde ya da BKCI kitaplarında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap', 'Patent'], 'puan' => 5],
        '9b' => ['baslik' => 'ESCI veya Scopus dergilerinde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 3],
        '9c' => ['baslik' => 'Diğer indekslerde taranan dergilerde ve kitaplarda yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer'], 'puan' => 2],

        // ══ 10. EDİTÖRLÜK VE HAKEMLİK (grup tavanı 600, yıl çarpanı yok) ══
        '10a' => ['baslik' => 'SCIE, SSCI veya AHCI dergilerinde editörlük (görev yılı başına)', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 300],
        '10b' => ['baslik' => 'ESCI, BKCI, Scopus veya TR Dizin dergilerinde ya da kitaplarda editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi', 'TR Dizin Dergi', 'BKCI Kitap'], 'puan' => 150],
        '10c' => ['baslik' => 'Diğer indeksli dergilerde, ders kitaplarında ya da bildiri kitaplarında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi', 'Kitap Editörlüğü'], 'puan' => 75],
        '10a-kurul' => ['baslik' => 'Dergi yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 25],
        '10ç' => ['baslik' => 'Dergi hakemliği ya da makale editörlüğü (makale başına)', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 5],

        // ══ 11. ÖDÜL ══
        '11a' => ['baslik' => 'TÜBA, YÖK veya TÜBİTAK\'tan alınan bilim, üstün başarı, teşvik ya da genç bilim insanı ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 1000],
        '11b-uluslararasi' => ['baslik' => 'Uluslararası kurum ya da kuruluşlarca verilen bilim, teknoloji, sanat veya tasarım ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 200],
        '11b-ulusal' => ['baslik' => 'Ulusal kurum ya da kuruluşlarca verilen bilim, teknoloji, sanat veya tasarım ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 100],
        '11c-11ç' => ['baslik' => 'Kongre, sempozyum, yarışma veya festival gibi etkinliklerin bilim, tasarım ya da sanat kurulunca verilen ödül', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon', 'Burs'], 'puan' => 30],

        // ══ 12. DİĞER FAALİYETLER ══
        '12a' => ['baslik' => 'Bilimsel toplantı, çalıştay, tasarım ya da sanat etkinliği düzenleme kurulunda görev almak', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 20],
        '12c' => ['baslik' => 'Kamu ya da özel kurum-kuruluşlar için danışmanlık yapmak veya eğitim vermek', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 15],
        '12ç' => ['baslik' => 'Birim ya da alt birim yöneticiliği veya yardımcılığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü', 'Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkanı', 'Bölüm Başkan Yardımcısı', 'Uygulama ve Araştırma Merkezi Müdürü', 'Senato / Üniversite Yönetim Kurulu Üyesi', 'Kurul / Komisyon Üyeliği', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 60],
        '12e' => ['baslik' => 'Üniversite-toplum ya da üniversite-endüstri işbirliği çerçevesinde sosyal sorumluluk çalışmasında görev almak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi'], 'puan' => 10],
    ],

    // EK-5'in asgari koşul tablolarının andığı kod aralıkları ve maddeler.
    'gruplar' => [
        '1a-ç' => ['1a', '1b', '1c', '1ç'],
        '1a-d' => ['1a', '1b', '1c', '1ç', '1d'],
        '1a-e' => ['1a', '1b', '1c', '1ç', '1d', '1e'],
        '1a-f' => ['1a', '1b', '1c', '1ç', '1d', '1e', '1f'],
        '1a-g' => ['1a', '1b', '1c', '1ç', '1d', '1e', '1f', '1g'],
        // EK-5'in "Lisansüstü Tezlerden Üretilmiş Yayın Sayısı" sütunu.
        'TEZ-YAYINI' => ['1a-ç-tez', '1e-tez', '1f-tez', '1g-tez'],
        '1f' => ['1f'],
        '1' => ['1*'],
        '2' => ['2*'],
        '1-2' => ['1*', '2*'],
        '1-2-7-8' => ['1*', '2*', '7*', '8*'],
        '4' => ['4*'],
        '4-YURUTUCU' => ['4a1', '4b1', '4c1', '4ç1'],
        '5' => ['5*'],
        '5-ILK-DANISMAN' => ['5a', '5b'],
        '6' => ['6*'],
        '7' => ['7*'],
        '8' => ['8*'],
        '9-BC' => ['9b', '9c'],
        '10' => ['10*'],
        '10-HAKEMLIK' => ['10ç'],
        // Başlıca eser: 1a-d kapsamındaki dergilerde araştırma makalesi ya da kitap.
        'BASLICA-ESER' => ['1a', '1b', '1c', '1ç', '1d', '2a-kitap', '2b-kitap'],
    ],

    'grup_tavanlari' => [
        '6' => 400,
        '9-BC' => 200,
        '10' => 600,
        '10-HAKEMLIK' => 100,
    ],
];
