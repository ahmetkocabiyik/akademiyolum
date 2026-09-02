<?php

/**
 * KADİR HAS ÜNİVERSİTESİ — EK-1: Öğretim Üyeliğine Yükseltilmelerde
 * Kullanılacak Sistem (kategori taksonomisi)
 * Kaynak: pdf/17537102022.kadirhasuniversitesi.pdf
 *
 * PUANSIZ CETVEL. Kadir Has'ın esaslarında puan tablosu YOK: EK-1 dört gruba
 * ayrılmış bir kategori listesi (A-S), EK-4 ise adayın her kategoriye kaç
 * çalışma düştüğünü yıl yıl yazdığı bir SAYIM formu. Bütün sayısal ölçütler
 * EK-3'te fakülte fakülte ve hep "en az N adet şu kategoriden yayın" biçiminde.
 * `puan` anahtarı bu yüzden hiçbir satırda yok (motor 0 sayar; hiçbir koşul
 * puana bakmıyor). Korpustaki Samsun, İzmir Demokrasi ve Bursa Uludağ
 * cetvelleriyle aynı şerit.
 *
 * MADDE KODLARI yönergenin kendi harf-numara etiketleri (A-1, D-3, N-2.a);
 * EK-3 koşulları tabloya birebir bu kodlarla atıf yapıyor ("A-1 türü makale",
 * "D1, D3 türü yabancı dilde yayınlanmış kitap veya kitapta bölüm").
 *
 * ── DİL AYRIMI KAYITTA YOK, İNDEKS BİLGİSİYLE VEKÂLET EDİLDİ ──
 * Koşulların çoğu "D1, D3 türü YABANCI DİLDE yayınlanmış kitap veya kitapta
 * bölüm" diyor; faaliyet kaydı kitabın dilini tutmuyor. EK-2 D-1'i "hakem
 * süzgecinden geçtiği kanıtlanmış, uluslararası saygınlığı olan yayınevlerince
 * basılmış" diye tanımladığı için yalnızca 'BKCI / Scopus Kitap' ve
 * 'BKCI / Scopus Kitap Bölümü' D-1 ve D-3'e yazıldı; dili belirsiz kalan
 * 'Uluslararası/Ulusal Kitap' ve 'Kitap Bölümü' Türkçe satırlara (D-2, D-4)
 * düştü. Sosyal Bilimler ve Güzel Sanatlar koşulları D-1 ile D-3'e dayandığı
 * için bu ayrım doğrudan eşiği etkiliyor: indeksli olmayan yabancı dilde bir
 * kitabınız varsa koşul OLDUĞUNDAN ZOR görünür.
 *
 * ── AYNI KAYNAĞA DÜŞEN SATIRLARDA DAİMA DÜŞÜĞÜ GİRİLDİ ──
 * Puan olmadığı için "düşük" burada koşula daha az yarayan satır demek:
 *   'Yarışma Derecesi / Mansiyon' düzeyini söylemiyor → ulusal satır N-3.b.
 *   'Yayın Kurulu Üyeliği' derginin düzeyini taşımıyor → yurt içi satır G-3.
 *   'Uluslararası/Ulusal Kitap' ve 'Kitap Bölümü' → D-2 ve D-4 (yukarıda).
 *
 * ── GİRİLMEYEN KATEGORİLER ──
 *   A-3 (A-1 ve A-2 dışında kalan uluslararası hakemli dergiler): kaynak
 *       sözlüğünde indekssiz uluslararası dergi kademesi yok; 'ESCI / Scopus'
 *       ve 'Diğer Uluslararası İndeks' A-2'ye düştü. A-3'ün boş kalması
 *       koşulları etkilemiyor — hiçbir koşul A-2 ile A-3'ü ayırmıyor, ikisi de
 *       "A kategorisi" kümesinin içinde.
 *   C-1 ve C-2 (adayın adıyla anılan formül, şema, şekil): sözlükte yok.
 *   O-1 ve O-2 (bilimsel toplantı düzenleme kurulunda görev almak): sözlükte
 *       kongre düzenleme kaynağı yok.
 *   M bölümünde yalnızca patent var; faydalı model, endüstriyel tasarım,
 *       yazılım ve ıslahçı hakkı satırı yok, girilmedi. Hiçbir koşul M'ye
 *       dayanmadığı için sonucu etkilemiyor.
 *   L bölümü yalnızca YÜRÜTÜCÜLÜĞÜ sayıyor ("Araştırma Projelerinde Yürütücü
 *       Olmak"); araştırmacı ve danışman olarak yer aldığınız projeler
 *       kategorilere hiç girmiyor.
 *   'Tez İzleme / Jüri Üyeliği' — K bölümü tez YÖNETİMİ, jüri üyeliği değil.
 *
 * ── ATIFTA KENDİ ATFI AYIKLANAMIYOR ──
 * EK-2 B bölümü "Yazarın kendi eserine yaptığı atıf göz önüne alınmaz" diyor;
 * faaliyet kaydı atfın kime ait olduğunu tutmuyor. Profesörlükteki "çalışmalarının
 * atıflar almış olması" koşulu bu yüzden olduğundan KOLAY görünür.
 *
 * Yönerge: yonerge/kadir-has.php
 */

return [
    'kapsam_notu' => 'Kadir Has Üniversitesi\'nin esaslarında PUAN TABLOSU YOK: EK-1 bir '
        .'kategori listesi, EK-4 ise sayım formu. Bütün ölçütler "en az N adet şu '
        .'kategoriden yayın" biçiminde ve fakülteye göre değişiyor (EK-3). Bu yüzden burada '
        .'toplam puan göremezsiniz; koşullar yayın sayısına bakar. '
        .'KİTAPLARDA DİL AYRIMI: koşullar yabancı dilde yayımlanmış kitap ve kitap bölümü '
        .'istiyor, kaydınız kitabın dilini tutmuyor. Yalnızca BKCI ya da Scopus taranan '
        .'kitaplarınız yabancı dil satırına yazıldı; başka bir yabancı dil kitabınız varsa '
        .'koşul olduğundan zor görünür, başvurunuzda belgeleyin. '
        .'Şu kalemler kategorilere hiç girmiyor: projede araştırmacı ya da danışman olmak '
        .'(yönerge yalnızca yürütücülüğü sayıyor), bilimsel toplantı düzenleme kurulunda '
        .'görev almak, adınızla anılan formül ve şekiller, faydalı model ve tasarım '
        .'tescilleri, tez izleme komitesi üyeliği. '
        .'Atıflarda kendi eserinize yaptığınız atıflar sayılmamalı ama kaydınız bunu '
        .'ayırt etmiyor; atıf koşulu olduğundan kolay görünür.',

    'maddeler' => [
        // ══ GRUP-1: Bilimsel Faaliyetler ══
        // A- Uluslararası Makaleler
        'A-1' => ['baslik' => 'SCI, SSCI veya AHCI kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI']],
        'A-2' => ['baslik' => 'Diğer uluslararası indekslerce taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks']],

        // B- Atıflar
        'B' => ['baslik' => 'Yayınlarınıza yapılan atıflar', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap', 'TR Dizin', 'Patent', 'Diğer']],

        // D- Kitap Yazarlığı
        'D-1' => ['baslik' => 'Yabancı dilde kitap yazarlığı (uluslararası saygın yayınevi)', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap']],
        'D-2' => ['baslik' => 'Türkçe kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı']],
        'D-3' => ['baslik' => 'Yabancı dilde kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü']],
        'D-4' => ['baslik' => 'Türkçe kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi']],

        // E- Kitaplarda Editörlük
        'E-1' => ['baslik' => 'Yabancı dilde kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap']],
        'E-2' => ['baslik' => 'Türkçe kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü']],

        // F- Kitap Çevirmenliği
        'F' => ['baslik' => 'Kitap çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap', 'Çeviri Kitap Bölümü']],

        // G- Yayın Danışma Kurulu Üyeliği (EK-2: hakemlik görevi)
        'G-1' => ['baslik' => 'SCI, SSCI veya AHCI kapsamındaki yabancı dergide hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)']],
        'G-2' => ['baslik' => 'Diğer yabancı dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi']],
        'G-3' => ['baslik' => 'Yurt içi dergilerde hakemlik ya da yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi', 'Hakemlik', 'Yayın Kurulu Üyeliği']],

        // H- Bilimsel/Sanatsal Toplantılarda Sunulan ve Özü Basılmış Bildiriler
        'H-1' => ['baslik' => 'Uluslararası bilimsel toplantıda bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin', 'Uluslararası Özet/Poster', 'Davetli Konuşmacı']],
        'H-2' => ['baslik' => 'Ulusal bilimsel toplantıda bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin', 'Ulusal Özet/Poster']],

        // I- Yurtiçi Dergilerde Yayınlanan Makaleler
        'I-1' => ['baslik' => 'Yurt içi hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin']],
        'I-2' => ['baslik' => 'Diğer yurt içi dergilerde makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli']],

        // ══ GRUP-2: Eğitim-Öğretim ve Bilim Adamı Yetiştirme ══
        'J' => ['baslik' => 'Ön lisans, lisans ve lisansüstü düzeyde ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi']],
        'K-1' => ['baslik' => 'Yönettiğiniz yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi']],
        'K-2' => ['baslik' => 'Yönettiğiniz doktora ya da sanatta yeterlik tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi']],

        // ══ GRUP-3: Uygulamaya Yönelik Çalışmalar ══
        // L yalnızca yürütücülüğü sayıyor.
        'L-1' => ['baslik' => 'Uluslararası kuruluş destekli araştırma projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu']],
        'L-2' => ['baslik' => 'TÜBİTAK ya da benzeri ulusal kuruluş destekli projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu']],
        'L-3' => ['baslik' => 'Üniversite ya da diğer yurt içi kuruluş destekli projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu']],
        'M-1' => ['baslik' => 'Yurt dışı patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent']],
        'M-2' => ['baslik' => 'Yurt içi patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent']],
        'N-1' => ['baslik' => 'Jürili uluslararası bilim ya da sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü']],
        'N-2.a' => ['baslik' => 'TÜBİTAK ya da TÜBA bilim ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü']],
        'N-2.b' => ['baslik' => 'TÜBİTAK ya da TÜBA teşvik ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü']],
        'N-2.c' => ['baslik' => 'Diğer jürili ulusal bilim ya da sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü', 'Ulusal Bilim/Sanat Ödülü', 'Burs']],
        'N-3.b' => ['baslik' => 'Yarışmada derece, mansiyon ya da satın alma', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon']],

        // ══ GRUP-4: Diğer Bilimsel Etkinlikler ══
        'P-1' => ['baslik' => 'Eserinizin yurt dışında müzede ya da eşdeğer kurumda yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)']],
        'P-2' => ['baslik' => 'Eserinizin yurt içinde müzede ya da eşdeğer kurumda yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)']],
        'R-1' => ['baslik' => 'Yurt dışında özgün bireysel sanat ya da tasarım etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Solistlik (Uluslararası)', 'Resital (Uluslararası)', 'Şan Resitali (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Belgesel/Kısa Film (Uluslararası)']],
        // R-2 kaynakta tek satır; alt kodlar (1-2) BİZE AİT. Güzel Sanatlar
        // Fakültesi'nin (b2) koşulu ("bir uygulama projesi yaparak yayınlamış
        // olmak") yalnızca uygulama projelerine dayandığı için ayrıldı.
        'R-2.1' => ['baslik' => 'Yasa ve yönetmelikler çerçevesinde yapılmış uygulama projesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman']],
        'R-2.2' => ['baslik' => 'Yurt içinde özgün bireysel sanat ya da tasarım etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)', 'Solistlik (Ulusal)', 'Resital (Ulusal)', 'Şan Resitali (Ulusal)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Belgesel/Kısa Film (Ulusal)', 'Özgün Eser / Beste / Tasarım', 'Koreografi']],
        'S-1' => ['baslik' => 'Seçici kurulu olan uluslararası etkinliğe yapıtınızın kabul edilmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)']],
        'S-2' => ['baslik' => 'Seçici kurulu olan ulusal etkinliğe yapıtınızın kabul edilmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Karma Sergi (Uluslararası)', 'Elektronik Karma Sergi (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)']],
    ],

    'gruplar' => [
        // EK-3'ün andığı kümeler. "A kategorisi" A-1, A-2 ve A-3'ü kapsıyor;
        // A-3 kaynaksız kaldığı için kümede yok (gerekçe dosya başlığında).
        'A' => ['A-1', 'A-2'],

        // "A-1 türü makale ve/veya D1, D3 türü yabancı dilde kitap veya bölüm"
        // — Sosyal Bilimler'in yardımcı doçentlik ve doçentlik koşulu.
        'A-1+D1-D3' => ['A-1', 'D-1', 'D-3'],

        // "A kategorisinde makale ve/veya D1, D3" — Güzel Sanatlar'ın ve
        // Sosyal Bilimler profesörlüğünün saydığı küme.
        'A+D1-D3' => ['A-1', 'A-2', 'D-1', 'D-3'],

        // Sosyal Bilimler profesörlüğünün alternatifi: "E kategorisinde editörlük".
        'E' => ['E-1', 'E-2'],

        // Hukuk profesörlüğünün istediği "özgün bilimsel kitap".
        'KITAP' => ['D-1', 'D-2'],

        // Profesörlükte "lisansüstü çalışmaların yürütücülüğünü üstlenmiş ve
        // sonuçlandırmış olmak" (Madde 11/c).
        'K' => ['K-1', 'K-2'],

        // Güzel Sanatlar (b1): yarışmada derece ya da mansiyon.
        'N-3' => ['N-3.b'],

        // Güzel Sanatlar (b2): uygulama projesi.
        'R-UYGULAMA' => ['R-2.1'],
    ],
];
