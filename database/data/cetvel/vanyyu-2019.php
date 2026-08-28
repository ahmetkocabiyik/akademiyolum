<?php

/**
 * VAN YÜZÜNCÜ YIL ÜNİVERSİTESİ — Faaliyet Türü Kataloğu
 * Kaynak: pdf/17537010282.vanyuzuncuyiluniverstesi.pdf (15 sayfa;
 * Senato 21/09/2018-2018/27-1, değişiklik 11/03/2019-2019/5-13.)
 *
 * ── BU YÖNERGEDE PUAN YOK ──
 * Van YYÜ yönergesi puan cetveli kullanmıyor. Koşullar "şu türden en az
 * N faaliyet" ve "EK-1/2/3'teki seçmeli kriterlerden en az K tanesini
 * sağlamak" biçiminde SAYI şartı. Bu dosya bir puan cetveli değil,
 * koşulların bağlanabileceği bir FAALİYET TÜRÜ kataloğu: satırların
 * puanı yok, yalnız kaynak etiketlerini kümeliyorlar. Madde kodları
 * bize ait ve yönergede karşılığı yok; kodlar yalnız koşulların
 * kümelere bağlanmasına yarıyor.
 *
 * Yönerge: yonerge/vanyyu.php
 */
$SCI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];

$SANAT_ETKINLIK = ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Ulusal)',
    'Karma/Jürili Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Ulusal)',
    'Elektronik Kişisel Sergi (Uluslararası)', 'Elektronik Kişisel Sergi (Ulusal)',
    'Elektronik Karma Sergi (Uluslararası)', 'Elektronik Karma Sergi (Ulusal)',
    'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)',
    'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)',
    'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)',
    'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Jürisiz, Ulusal)',
    'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)',
    'Resital (Uluslararası)', 'Resital (Ulusal)', 'Solistlik (Uluslararası)', 'Solistlik (Ulusal)',
    'Şan Resitali (Uluslararası)', 'Şan Resitali (Ulusal)', 'Opera Birinci Rol (Uluslararası)',
    'Opera Birinci Rol (Ulusal)', 'Opera İkinci Rol (Uluslararası)', 'Opera İkinci Rol (Ulusal)',
    'Bale Başrol (Uluslararası)', 'Bale Başrol (Ulusal)', 'Bale Solist Rol (Uluslararası)',
    'Bale Solist Rol (Ulusal)', 'Corps de Ballet (Uluslararası)', 'Corps de Ballet (Ulusal)',
    'Oda Müziği Grup Üyeliği (Uluslararası)', 'Oda Müziği Grup Üyeliği (Ulusal)',
    'Orkestra / Koro Üyeliği', 'Grup Şefliği (Uluslararası)', 'Grup Şefliği (Ulusal)',
    'Orkestra Şefliği (Uluslararası)', 'Orkestra Şefliği (Ulusal)', 'Koro Şefliği (Uluslararası)',
    'Koro Şefliği (Ulusal)', 'Opera Şefliği (Uluslararası)', 'Opera Şefliği (Ulusal)',
    'Bale Orkestra Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Ulusal)',
    'Dansçı / Performans İcracısı (Uluslararası)', 'Dansçı / Performans İcracısı (Ulusal)',
    'Masterclass (Uluslararası)', 'Masterclass (Ulusal)', 'Eğitim Amaçlı Sanat Etkinliği',
    'Eğitici Konser Programı (Uluslararası)', 'Eğitici Konser Programı (Ulusal)',
    'Albüm / Konser Kaydı', 'Karma Albüm / CD-DVD Katkısı', 'Bandrollü Kayıt (CD/DVD)',
    'Müzikoloji Atölyesi', 'Başkemancılık (Uluslararası)', 'Başkemancılık (Ulusal)'];

$SANAT_ESER = ['Özgün Eser / Beste / Tasarım', 'Opera/Bale Kompozisyonu', 'Orkestralı Sahne Eseri',
    'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Küçük Ölçekli Orkestra Eseri',
    'Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)',
    'Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Sahne/Ekran Müziği',
    'Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi', 'Eğitim Müziği Albümü',
    'Koreografi', 'Tüm Perde Koreograflığı (Uluslararası)', 'Tüm Perde Koreograflığı (Ulusal)',
    'Bölüm Koreograflığı (Uluslararası)', 'Bölüm Koreograflığı (Ulusal)',
    'Bale/Dans Koreograflığı (Uluslararası)', 'Bale/Dans Koreograflığı (Ulusal)',
    'Sahne Tasarımı (Dekor, Kostüm, Işık)'];

$SANAT_EKRAN = ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)',
    'Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)', 'Yönetmenlik (Sahne/Ekran)',
    'Rejisörlük (Uluslararası)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)',
    'Rejisör Yardımcılığı (Uluslararası)', 'Rejisör Yardımcılığı (Ulusal)',
    'Rejisör Yardımcılığı (Konservatuvar)', 'Sahneleme/Repetitörlük — Tüm Perde (Uluslararası)',
    'Sahneleme/Repetitörlük — Tüm Perde (Ulusal)', 'Sahneleme/Repetitörlük — Bölüm (Uluslararası)',
    'Sahneleme/Repetitörlük — Bölüm (Ulusal)'];

$PROJE_DIS = ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon', 'TÜBİTAK', 'TÜSEB',
    'Diğer Kamu Kurumu', 'Özel Sektör / STK'];
$PROJE_HEPSI = [...$PROJE_DIS, 'BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'];

return [
    'kapsam_notu' => 'Van Yüzüncü Yıl Üniversitesi Öğretim Üyeliğine Yükseltilme ve Atanma '
        .'Yönergesi PUAN CETVELİ KULLANMIYOR. Koşullar "şu türden en az N faaliyet" ve '
        .'"EK-1, EK-2 ya da EK-3\'teki seçmeli kriterlerden en az K tanesini sağlamak" biçiminde '
        .'sayı şartı. Bu yüzden burada puan görmezsiniz; kayıtlarınız yalnız koşulların istediği '
        .'türlere göre sayılır. Seçmeli kriterlerin çoğu kayıt alanlarıyla eşleşmediği için '
        .'"beyan" olarak soruluyor; hangi kriterleri sağladığınızı başvuru dosyanızda '
        .'belgelemeniz gerekiyor. Yönergenin "1.1., 2.1. ve 3.1. dışındaki her kriterden en '
        .'fazla üç etkinlik sayılır" ve "bir eser aynı kategoride yalnız bir kez kullanılır" '
        .'kuralları motorda yok.',

    'maddeler' => [
        // ── Makaleler ──
        'M-SCI' => ['baslik' => 'SCI, SCI-Expanded, SSCI, AHCI ya da ESCI kapsamındaki dergide yayımlanmış tam metinli araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => [...$SCI, 'ESCI / Scopus']],
        'M-ALAN' => ['baslik' => 'Alan indeksleri kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks']],
        'M-TR' => ['baslik' => 'TR Dizin kapsamındaki ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin']],
        'M-DIGER' => ['baslik' => 'Diğer ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli']],

        // ── Tez yayını ──
        'TY' => ['baslik' => 'Doktora, sanatta yeterlik ya da uzmanlık tezinizden üretilmiş yayın', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI', 'ESCI / Scopus', 'TR Dizin', 'BKCI / Scopus Kitap', 'BKCI / Scopus Kitap Bölümü', 'Uluslararası/Ulusal Kitap', 'Kitap Bölümü', 'CPCI Bildiri', 'Diğer']],

        // ── Kitap ──
        'K-KITAP' => ['baslik' => 'Ulusal ya da uluslararası yayınevi tarafından yayımlanmış bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı']],
        'K-BOLUM' => ['baslik' => 'Ulusal ya da uluslararası yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Kitap Bölümü']],
        'K-CEVIRI' => ['baslik' => 'Bilimsel kitap ya da kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap', 'Çeviri Kitap Bölümü']],
        'K-ANSIKLOPEDI' => ['baslik' => 'Sözlük ya da ansiklopedide madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi']],

        // ── Editörlük ve hakemlik ──
        'E-DERGI' => ['baslik' => 'Hakemli dergide editörlük, bölüm editörlüğü ya da editör yardımcılığı', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi', 'TR Dizin Dergi', 'Diğer Hakemli Dergi']],
        'E-KITAP' => ['baslik' => 'Bilimsel kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Kitap Editörlüğü']],
        'E-KURUL' => ['baslik' => 'Hakemli bir derginin yayın kurulunda bulunmak', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği']],
        'E-HAKEM' => ['baslik' => 'Bilimsel dergide hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik']],

        // ── Bildiri ──
        'B-SOZLU' => ['baslik' => 'Bilimsel toplantıda sözlü sunulan ve tam metni yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin', 'Ulusal Tam Metin']],
        'B-POSTER' => ['baslik' => 'Bilimsel toplantıda sunulan poster ya da özet bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster', 'Ulusal Özet/Poster']],
        'B-DAVETLI' => ['baslik' => 'Bilimsel etkinlikte davetli konuşmacı olarak yer almak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı']],

        // ── Atıf ──
        'A' => ['baslik' => 'Çalışmalarınıza yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap', 'TR Dizin', 'Patent', 'Diğer']],
        'A-KITAP' => ['baslik' => 'Uluslararası bilimsel kitapta yayınlarınıza yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap']],

        // ── Proje ──
        'P-YUR' => ['baslik' => 'Araştırma ya da uygulama projesinde yürütücü olarak görev almak', 'kategori' => 'proje', 'kaynaklar' => $PROJE_HEPSI, 'roller' => ['yurutucu']],
        'P-ARS' => ['baslik' => 'Araştırma ya da uygulama projesinde yardımcı araştırmacı olarak görev almak', 'kategori' => 'proje', 'kaynaklar' => $PROJE_HEPSI, 'roller' => ['arastirmaci', 'danisman', 'bursiyer']],
        'P-DIS' => ['baslik' => 'Üniversite dışından kaynak sağlanarak yürütülen araştırma projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => $PROJE_DIS],
        'P-BAP' => ['baslik' => 'Üniversite destekli bilimsel araştırma projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)']],

        // ── Patent ──
        'PT' => ['baslik' => 'Tescil edilmiş patent ya da faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent', 'Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili', 'Yazılım', 'Ticarileştirme']],

        // ── Tez danışmanlığı ──
        'TD-DOKTORA' => ['baslik' => 'Doktora, sanatta yeterlik ya da tıpta uzmanlık tezi yönetmek', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi']],
        'TD-YL' => ['baslik' => 'Yüksek lisans tezi yönetmek', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi']],
        'TD-JURI' => ['baslik' => 'Lisansüstü tez izleme komitesinde ya da tez jürisinde görev almak', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği']],

        // ── Ödül ──
        'O' => ['baslik' => 'Bilim, bilim teşvik, proje teşvik ya da araştırma ödülü almak', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü', 'Ufuk Avrupa / ERC Ödülü', 'Yarışma Derecesi / Mansiyon']],
        'O-BURS' => ['baslik' => 'Bilimsel etkinlikler için burs kazanmak', 'kategori' => 'odul', 'kaynaklar' => ['Burs']],

        // ── Eğitim-öğretim ──
        'EG-DERS' => ['baslik' => 'Ön lisans, lisans ya da lisansüstü düzeyde ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Akreditasyon Faaliyeti']],
        'EG-YABANCI' => ['baslik' => 'Yabancı dilde gerçekleştirilen programlarda ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Yabancı Dilde Ders']],
        'EG-DEGISIM' => ['baslik' => 'Öğretim elemanı değişim programlarına katılmak', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Değişim Programı Dersi']],

        // ── Sanatsal etkinlik ──
        'S-ETKINLIK' => ['baslik' => 'Ulusal ya da uluslararası nitelikli sanatsal etkinliğe katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $SANAT_ETKINLIK],
        'S-ESER' => ['baslik' => 'Özgün sanat eseri, beste ya da tasarım üretmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $SANAT_ESER],
        'S-EKRAN' => ['baslik' => 'Televizyon programı, dizi ya da belgeselde yönetmen, görüntü yönetmeni veya senaryo yazarı olarak yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $SANAT_EKRAN],
        'S-JURI' => ['baslik' => 'Proje ya da sanatsal etkinlik jürisinde görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)']],
        'S-SATIN' => ['baslik' => 'Özgün sanat eserlerinizin satın alınması ya da daimî olarak sergilenmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Haber Olması (Uluslararası)', 'Eserin Haber Olması (Ulusal)']],
        'S-KORUMA' => ['baslik' => 'Tarihî eserlerin restorasyon ya da konservasyon çalışmalarında yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)']],
        'S-TASARIM' => ['baslik' => 'Üretime girmiş tasarım çalışması ya da uygulama projesi sahibi olmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman']],

        // ── Toplumsal katkı, idari görev, diğer ──
        'TK' => ['baslik' => 'Topluma yönelik sosyal sorumluluk çalışması ya da projesinde yer almak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın', 'Kamu/STK Danışmanlığı']],
        'ID' => ['baslik' => 'Üniversite ya da birim yönetiminde, kurul veya komisyonlarda görev almak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Senato / Üniversite Yönetim Kurulu Üyesi', 'Dekan / Enstitü-YO Müdürü', 'Dekan Yrd. / Müdür Yrd.', 'Uygulama ve Araştırma Merkezi Müdürü', 'Bölüm Başkanı', 'Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük', 'Kurul / Komisyon Üyeliği']],
        'D' => ['baslik' => 'Bilimsel etkinliğin düzenleme ya da bilimsel değerlendirme komitesinde yer almak', 'kategori' => 'diger', 'kaynaklar' => ['Diğer']],
    ],

    'gruplar' => [
        'INDEKSLI-MAKALE' => ['M-SCI', 'M-ALAN'],
        'SCI-MAKALE' => ['M-SCI'],
        'ALAN-INDEKS' => ['M-ALAN'],
        'HAKEMLI-MAKALE' => ['M-SCI', 'M-ALAN', 'M-TR', 'M-DIGER'],
        'TEZ-YAYINI' => ['TY'],
        'KITAP' => ['K-KITAP', 'K-BOLUM'],
        'KITAP-BOLUM' => ['K-BOLUM'],
        'CEVIRI' => ['K-CEVIRI'],
        'ANSIKLOPEDI' => ['K-ANSIKLOPEDI'],
        'EDITOR' => ['E-DERGI'],
        'EDITOR-KITAP' => ['E-KITAP'],
        'YAYIN-KURULU' => ['E-KURUL'],
        'HAKEMLIK' => ['E-HAKEM'],
        'BILDIRI' => ['B-SOZLU', 'B-POSTER'],
        'BILDIRI-SOZLU' => ['B-SOZLU'],
        'BILDIRI-POSTER' => ['B-POSTER'],
        'DAVETLI' => ['B-DAVETLI'],
        'ATIF' => ['A'],
        'ATIF-KITAP' => ['A-KITAP'],
        'PROJE' => ['P-YUR', 'P-ARS', 'P-DIS', 'P-BAP'],
        'PROJE-YURUTUCU' => ['P-YUR'],
        'PROJE-ARASTIRMACI' => ['P-ARS'],
        'PROJE-DIS' => ['P-DIS'],
        'PROJE-BAP' => ['P-BAP'],
        'PATENT' => ['PT'],
        'TEZ-DOKTORA' => ['TD-DOKTORA'],
        'TEZ-YL' => ['TD-YL'],
        'TEZ-JURI' => ['TD-JURI'],
        'ODUL' => ['O'],
        'BURS' => ['O-BURS'],
        'DERS' => ['EG-DERS'],
        'YABANCI-DILDE-DERS' => ['EG-YABANCI'],
        'DEGISIM' => ['EG-DEGISIM'],
        'SANAT' => ['S-ETKINLIK', 'S-ESER', 'S-EKRAN', 'S-SATIN', 'S-KORUMA', 'S-TASARIM'],
        'SANAT-ETKINLIK' => ['S-ETKINLIK'],
        'SANAT-ESER' => ['S-ESER', 'S-EKRAN'],
        'EKRAN' => ['S-EKRAN'],
        'SANAT-JURI' => ['S-JURI'],
        'SANAT-SATIN' => ['S-SATIN'],
        'SANAT-KORUMA' => ['S-KORUMA'],
        'SANAT-TASARIM' => ['S-TASARIM'],
        'TOPLUMSAL' => ['TK'],
        'IDARI' => ['ID'],
        'ETKINLIK-KOMITE' => ['D'],
    ],
];
