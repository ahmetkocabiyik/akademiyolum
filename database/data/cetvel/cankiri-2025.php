<?php

/**
 * ÇANKIRI KARATEKİN ÜNİVERSİTESİ — Tablo 1 Bilimsel Yayın ve Faaliyet
 * Puanlama Tablosu
 * Kaynak: pdf/1764310250467.cankiri-karatekin-kriter-26112025.pdf
 * (YÖK onayı 30.10.2025)
 *
 * Madde kodları Tablo 1'in kendi numaralandırması (1.1, 7.8, 11.23 …);
 * projelerde ve tez yönetiminde rol ayrımı zaten kodlarda var.
 *
 * ── DEVAM EDEN PROJE VE TEZLERE ÜÇTE BİR PUAN (§0) ──
 * Tablo 1'in 7. başlığı "sonuçlandırılmış araştırma projeleri" diyor ve
 * "devam eden araştırma projelerinde bu puanların ÜÇTE BİRİ dikkate
 * alınır" notunu düşüyor; tez yönetiminde de aynı not var. Faaliyet
 * kaydı projenin ya da tezin tamamlanıp tamamlanmadığını taşımadığı için
 * bütün proje ve tez satırlarına ÜÇTE BİR değerler yazıldı: uluslararası
 * ve TÜBİTAK proje yürütücülüğü 100 yerine 33, doktora tez yöneticiliği
 * 30 yerine 10, yüksek lisans 20 yerine 6.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   Editörlük ve yayın kurulu üyeliği aynı satırda puanlanıyor; sözlükte
 *       ayrı etiketler olduğu için ikisine de aynı puan verildi.
 *   Ödülde uluslararası bilim ödülü (100), proje ödülü (80), teşvik (60)
 *       ve diğer (40) tek 'Uluslararası Bilim/Sanat Ödülü' etiketine
 *       düşüyor → 40; ulusal karşılıkları (60/40/15/10) → 10.
 *   Sanatsal etkinliklerde kişisel etkinlik uluslararası 50 ile ulusal 40
 *       ayrı etiketlerde; karma etkinlikte uluslararası jürili (40),
 *       ulusal jürili uluslararası karma (25), ulusal jürili (20) ve
 *       jürisiz karma (30/10) kademeleri sözlükteki etiketlere göre
 *       dağıtıldı, ayrılamayanlarda düşük olan yazıldı.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   7.14 ve 7.15 (üniversitenin ihtisaslaşma alanı projeleri) — kayıt
 *       projenin ihtisaslaşma alanında olduğunu taşımıyor.
 *   12 (televizyon ve radyo röportajları) 'Bilim İletişimi / Popüler
 *       Yayın' etiketinde girildi; 13 (bilimsel kazı etkinlikleri) ve 14
 *       (ÇAKÜ Açık Erişim kayıtları) sözlükte karşılıksız.
 *   11.16-11.22 (mobil arayüz, web, reklam sayfası, afiş ve kurumsal
 *       kimlik tasarımları) ile 11.25-11.40'ın stüdyo kaydı, tonmaysterlik
 *       ve topluluk icrası kademelerinin çoğu — sözlükte karşılıksız;
 *       eşleşen müzik ve sahne etiketleri girildi.
 *   10.5 (tescil edilmiş marka) — sözlükte karşılıksız.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   7.1'in "yıllık şeklinde verilen dersler iki katı ile puanlandırılır"
 *       ve "son beş yılda verilen her bir ders" kuralları.
 *   5.1-5.4 ile 15. başlığın "her atama dönemi için en az 1 yıl yürütmek
 *       kaydıyla" ve 15.1-15.3'ün "görev süresi 2-3 yıldan fazla olmak
 *       kaydıyla" koşulları.
 *   11.23-11.39'un "aynı eserden ve aynı repertuardan bir kriter
 *       dâhilinde sadece bir kez puan alınabilir" kuralları.
 *   MADDE 9(2): önceki atanmalarda puanlanmış yayınların yeniden
 *       atanmada kullanılamaması.
 *
 * Yönerge: yonerge/cankiri.php
 */
$TAM = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];
$WOS = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];
$ULUSLARARASI_FON = ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'];
$ULUSAL_FON = ['TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'];
$BAP = ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'];

$maddeler = [
    // ══ 1. MAKALELER ══
    '1.1' => ['baslik' => 'SCIE, SSCI ya da AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $TAM, 'puan' => 200],
    '1.2' => ['baslik' => 'SCOPUS ya da ESCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $TAM, 'puan' => 100],
    '1.3' => ['baslik' => 'Diğer uluslararası indekslerde taranan dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $TAM, 'puan' => 60],
    '1.4' => ['baslik' => 'SCIE, SSCI, AHCI, ESCI ya da SCOPUS kapsamındaki dergide yayımlanmış teknik not, editöre mektup, tartışma, vaka takdimi, kitap tanıtımı veya özet', 'kategori' => 'makale', 'kaynaklar' => [...$WOS, 'ESCI / Scopus'], 'turler' => $KISA, 'puan' => 30],
    '1.5' => ['baslik' => 'Diğer uluslararası indekslerde taranan dergide yayımlanmış teknik not, editöre mektup, tartışma, vaka takdimi, kitap tanıtımı veya özet', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 15],
    '1.6' => ['baslik' => 'TR Dizin kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TAM, 'puan' => 60],
    '1.7' => ['baslik' => 'TR Dizin kapsamındaki dergide yayımlanmış teknik not, editöre mektup, tartışma, vaka takdimi, kitap tanıtımı veya özet', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $KISA, 'puan' => 15],
    // Kaynak 1.8'i açıkça "(özgün araştırma makalesi ve derleme)" diye
    // tanımlıyor ve bu kademe için teknik not/editöre mektup satırı YOK;
    // tür kısıtı olmadığı için editöre mektup 20 puan alıyordu (§0 ihlali).
    '1.8' => ['baslik' => 'Diğer bilimsel hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 20],

    // ══ 2. BİLDİRİLER ══
    '2.1' => ['baslik' => 'Uluslararası bilimsel toplantıda sözlü sunulan ve tam metin olarak yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 40],
    '2.2' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan özet ya da poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 10],
    '2.5' => ['baslik' => 'Ulusal bilimsel toplantıda sözlü sunulan ve tam metin olarak yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 20],
    '2.6' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan özet ya da poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 5],

    // ══ 3. KİTAPLAR ══
    '3.1' => ['baslik' => 'WOS BKCI ya da SCOPUS kapsamındaki kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 200],
    '3.2' => ['baslik' => 'Alanında diğer uluslararası yayınevlerince yayımlanmış özgün kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 50],
    '3.3' => ['baslik' => 'WOS BKCI ya da SCOPUS kapsamındaki kitapta özgün bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 80],
    '3.6' => ['baslik' => 'Alanında yayımlanmış kitapta özgün bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 25],

    // ══ 4. ÇEVİRİLER ══
    '4.1' => ['baslik' => 'Alanında yayımlanmış kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 40],
    '4.2' => ['baslik' => 'Alanında yayımlanmış kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 20],

    // ══ 5. EDİTÖRLÜK VE HAKEMLİKLER ══
    '5.1' => ['baslik' => 'SCIE, SSCI, AHCI, ESCI ya da SCOPUS kapsamındaki dergide editörlük veya yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 40],
    '5.4' => ['baslik' => 'Diğer uluslararası ya da ulusal hakemli dergide editörlük veya yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi', 'Yayın Kurulu Üyeliği'], 'puan' => 10],
    '5.8' => ['baslik' => 'Bilimsel dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 5],
    '5.9' => ['baslik' => 'WOS BKCI ya da SCOPUS kapsamındaki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 40],
    '5.11' => ['baslik' => 'Alanında yayımlanmış kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 10],

    // ══ 6. ATIFLAR ══
    '6.1' => ['baslik' => 'SCIE, SSCI, AHCI, ESCI ya da SCOPUS kapsamındaki dergilerde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 5],
    '6.3' => ['baslik' => 'Diğer uluslararası indeksler ya da TR Dizin kapsamındaki dergilerde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 3],
    '6.4' => ['baslik' => 'WOS BKCI ya da SCOPUS kapsamındaki kitaplarda eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 5],

    // ══ 7. EĞİTİM, ÖĞRETİM VE ARAŞTIRMA FAALİYETLERİ ══
    '7.1' => ['baslik' => 'Ön lisans, lisans ya da lisansüstü ders vermek (son beş yılda verilen her bir ders için)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 3],
    '7.2' => ['baslik' => 'Yönetiminde doktora ya da sanatta yeterlik tezi (devam eden değerle)', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 10],
    '7.3' => ['baslik' => 'Yönetiminde yüksek lisans tezi (devam eden değerle)', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 6],
    '7.4' => ['baslik' => 'İkinci danışman olarak görev aldığınız lisansüstü tez (devam eden değerle)', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi', 'Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 3],
    '7.5' => ['baslik' => 'Doktora yeterlik, tez izleme komitesi ya da tez savunma jürilerinde bulunmak', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 5],
    '7.6' => ['baslik' => 'Uluslararası kamu ya da özel kurum ve kuruluşlarca desteklenen projede yürütücülük (devam eden değerle)', 'kategori' => 'proje', 'kaynaklar' => $ULUSLARARASI_FON, 'roller' => ['yurutucu'], 'puan' => 33],
    '7.7' => ['baslik' => 'Uluslararası kamu ya da özel kurum ve kuruluşlarca desteklenen projede yürütücülük dışında görev (devam eden değerle)', 'kategori' => 'proje', 'kaynaklar' => $ULUSLARARASI_FON, 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
    '7.8' => ['baslik' => 'TÜBİTAK tarafından desteklenen projede yürütücülük (devam eden değerle)', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 33],
    '7.9' => ['baslik' => 'TÜBİTAK tarafından desteklenen projede yürütücülük dışında görev (devam eden değerle)', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
    '7.10' => ['baslik' => 'Yükseköğretim kurumlarınca desteklenen bilimsel araştırma projesinde yürütücülük (devam eden değerle)', 'kategori' => 'proje', 'kaynaklar' => $BAP, 'roller' => ['yurutucu'], 'puan' => 13],
    '7.11' => ['baslik' => 'Yükseköğretim kurumlarınca desteklenen bilimsel araştırma projesinde yürütücülük dışında görev (devam eden değerle)', 'kategori' => 'proje', 'kaynaklar' => $BAP, 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 6],
    '7.12' => ['baslik' => 'Diğer ulusal kamu ya da özel kurum ve kuruluşlarca desteklenen projede yürütücülük (devam eden değerle)', 'kategori' => 'proje', 'kaynaklar' => $ULUSAL_FON, 'roller' => ['yurutucu'], 'puan' => 13],
    '7.13' => ['baslik' => 'Diğer ulusal kamu ya da özel kurum ve kuruluşlarca desteklenen projede yürütücülük dışında görev (devam eden değerle)', 'kategori' => 'proje', 'kaynaklar' => $ULUSAL_FON, 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 6],

    // ══ 8. BİLİMSEL, YÖNETSEL VE SANATSAL ETKİNLİKLERDE GÖREV ALMA ══
    '8.3' => ['baslik' => 'Panel, çalıştay ya da konferanslarda davetli konuşmacı veya moderatör olarak yer almak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 10],
    '8.6' => ['baslik' => 'Sempozyum, kongre ya da sanat etkinliklerinde düzenleme veya bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Diğer', 'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 10],
    '8.9' => ['baslik' => 'Ulusal ya da uluslararası sanat ve tasarım yarışmalarında jüri olarak görev almak veya küratörlük yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 10],

    // ══ 9. ÖDÜLLER ══
    '9.4' => ['baslik' => 'Uluslararası bilim, sanat, proje ya da teşvik ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 40],
    '9.8' => ['baslik' => 'Ulusal bilim, sanat, proje ya da teşvik ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü', 'Burs'], 'puan' => 10],

    // ══ 10. PATENT / FAYDALI MODEL ══
    '10.1' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 300],
    '10.2' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 200],
    '10.3' => ['baslik' => 'Tescil edilmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 100],
    '10.4' => ['baslik' => 'Tescil edilmiş endüstriyel tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım', 'Yazılım', 'Ticarileştirme'], 'puan' => 50],

    // ══ 11. SANATSAL ETKİNLİKLER ══
    '11.1' => ['baslik' => 'Özgün sanat eserinin uluslararası sanat, eğitim ve kültür kurumlarınca satın alınması ya da yayın organlarında yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Haber Olması (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Belgesel/Kısa Film (Uluslararası)', 'Uygulama Projesi — Müellif', 'Koruma-Onarım Uygulaması (Uluslararası)'], 'puan' => 60],
    '11.3' => ['baslik' => 'Özgün sanat eserleriyle uluslararası kişisel etkinliklerde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)'], 'puan' => 50],
    '11.4' => ['baslik' => 'Özgün sanat eserleriyle ulusal düzeyde kişisel etkinliklerde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 40],
    '11.5' => ['baslik' => 'Özgün sanat eserinin ulusal sanat, eğitim ve kültür kurumlarınca satın alınması ya da yayın organlarında yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Satın Alınması (Yurt İçi)', 'Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Haber Olması (Ulusal)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Belgesel/Kısa Film (Ulusal)', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman', 'Koruma-Onarım Uygulaması (Ulusal)'], 'puan' => 35],
    '11.2' => ['baslik' => 'Özgün sanat eserleriyle uluslararası jürili karma sanat ve tasarım etkinliklerine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)'], 'puan' => 40],
    '11.7' => ['baslik' => 'Özgün sanat eserleriyle ulusal düzeyde jürili karma sanat ve tasarım etkinliklerine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)'], 'puan' => 20],
    '11.9' => ['baslik' => 'Özgün sanat eserleriyle karma ya da grup sanat ve tasarım etkinliklerine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Uluslararası)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 10],
    '11.11' => ['baslik' => 'Sempozyum, festival, kurs, workshop, bienal ya da trienal gibi sanat etkinliklerine eserleriyle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Masterclass (Uluslararası)', 'Masterclass (Ulusal)', 'Eğitici Konser Programı (Uluslararası)', 'Eğitici Konser Programı (Ulusal)', 'Müzikoloji Atölyesi', 'Eğitim Amaçlı Sanat Etkinliği'], 'puan' => 15],
    '11.13' => ['baslik' => 'Jürili sanat ve tasarım etkinliklerinde eserleriyle ödül almış olmak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 25],
    '11.23' => ['baslik' => 'Özgün eserin ya da düzenlemenin sanatsal amaçlı konser, dinleti veya yayın etkinliklerinde seslendirilmesi, kaydının yayımlanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım', 'Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)', 'Karma Albüm / CD-DVD Katkısı', 'Eğitim Müziği Albümü', 'Opera/Bale Kompozisyonu', 'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Orkestralı Sahne Eseri', 'Küçük Ölçekli Orkestra Eseri', 'Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Sahne/Ekran Müziği', 'Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi'], 'puan' => 10],
    '11.33' => ['baslik' => 'Sanatsal amaçlı organizasyonlarda bireysel ya da müzik topluluğu yöneticisi olarak konser nitelikli müzik etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Uluslararası)', 'Resital (Ulusal)', 'Solistlik (Uluslararası)', 'Solistlik (Ulusal)', 'Şan Resitali (Uluslararası)', 'Şan Resitali (Ulusal)', 'Oratoryo/Kantat Solistliği (Uluslararası)', 'Oratoryo/Kantat Solistliği (Ulusal)', 'Orkestra Şefliği (Uluslararası)', 'Orkestra Şefliği (Ulusal)', 'Opera Şefliği (Uluslararası)', 'Opera Şefliği (Ulusal)', 'Koro Şefliği (Uluslararası)', 'Koro Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Ulusal)', 'Grup Şefliği (Uluslararası)', 'Grup Şefliği (Ulusal)', 'Opera Birinci Rol (Uluslararası)', 'Opera Birinci Rol (Ulusal)', 'Bale Başrol (Uluslararası)', 'Bale Başrol (Ulusal)', 'Rejisörlük (Uluslararası)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Yönetmenlik (Sahne/Ekran)', 'Sahne Tasarımı (Dekor, Kostüm, Işık)', 'Koreografi'], 'puan' => 30],
    '11.35' => ['baslik' => 'Sanatsal amaçlı organizasyonlarda topluluk üyesi ya da eşlikçi olarak konser nitelikli müzik etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Uluslararası)', 'Oda Müziği Grup Üyeliği (Ulusal)', 'Orkestra / Koro Üyeliği', 'Başkemancılık (Uluslararası)', 'Başkemancılık (Ulusal)', 'Corps de Ballet (Uluslararası)', 'Corps de Ballet (Ulusal)', 'Opera İkinci Rol (Uluslararası)', 'Opera İkinci Rol (Ulusal)', 'Bale Solist Rol (Uluslararası)', 'Bale Solist Rol (Ulusal)', 'Dansçı / Performans İcracısı (Uluslararası)', 'Dansçı / Performans İcracısı (Ulusal)', 'Rejisör Yardımcılığı (Uluslararası)', 'Rejisör Yardımcılığı (Ulusal)', 'Rejisör Yardımcılığı (Konservatuvar)', 'Tüm Perde Koreograflığı (Uluslararası)', 'Tüm Perde Koreograflığı (Ulusal)', 'Bölüm Koreograflığı (Uluslararası)', 'Bölüm Koreograflığı (Ulusal)', 'Bale/Dans Koreograflığı (Uluslararası)', 'Bale/Dans Koreograflığı (Ulusal)', 'Sahneleme/Repetitörlük — Tüm Perde (Uluslararası)', 'Sahneleme/Repetitörlük — Tüm Perde (Ulusal)', 'Sahneleme/Repetitörlük — Bölüm (Uluslararası)', 'Sahneleme/Repetitörlük — Bölüm (Ulusal)'], 'puan' => 15],

    // ══ 12. TELEVİZYON VE RADYO RÖPORTAJLARI ══
    '12.1' => ['baslik' => 'Televizyon ve radyo röportajları, topluma yönelik bilim iletişimi çalışmaları', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Bilim İletişimi / Popüler Yayın', 'Topluma Hizmet Projesi', 'Kamu/STK Danışmanlığı'], 'puan' => 5],

    // ══ 15. AKADEMİK VE İDARİ GÖREVLER ══
    '15.1' => ['baslik' => 'Rektörlük', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör'], 'puan' => 100],
    '15.2' => ['baslik' => 'Rektör yardımcılığı ya da dekanlık', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör Yardımcısı'], 'puan' => 60],
    '15.5' => ['baslik' => 'Dekan yardımcılığı, enstitü, yüksekokul ya da meslek yüksekokulu müdürlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü', 'Dekan Yrd. / Müdür Yrd.'], 'puan' => 40],
    '15.7' => ['baslik' => 'Bölüm ya da anabilim dalı başkanlığı, merkez müdürlüğü, rektörlüğe bağlı koordinatörlük', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı', 'Anabilim Dalı Başkanı / Koordinatörlük', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 20],
    '15.8' => ['baslik' => 'Bölüm başkan yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı'], 'puan' => 10],
    '15.12' => ['baslik' => 'Komisyon ya da kurullarda yer almak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 2],
];

$kodlar = fn (string $onek): array => array_values(array_filter(
    array_keys($maddeler),
    fn (string $kod): bool => str_starts_with($kod, $onek)
));

return [
    'kapsam_notu' => 'Puanlar Çankırı Karatekin Üniversitesi Öğretim Üyeliğine Yükseltilme ve '
        .'Atanma Yönergesinin Tablo 1 çizelgesinden (YÖK onayı 30.10.2025). Çok yazarlı '
        .'yayınlarda puan yazar sayısı × isim sırası matrisine göre bölünüyor: iki isimli bir '
        .'eserde birinci yazar tam puan, ikinci %90; sekiz ve daha fazla isimlide birinci yazar '
        .'%65\'e, sekizinci isim %5\'e iner. Tescilli patent ve faydalı modellerde puan kişi '
        .'sayısına bölünüyor. Yazar listesini boş bırakırsanız çarpan uygulanmaz ve puanınız '
        .'olduğundan yüksek görünür. Hakemlikten en fazla 50, atıflardan 100, derslerden 30, '
        .'idari görevlerden 100 puan alınabiliyor. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: proje ve tez satırlarına "devam '
        .'eden" değerleri (tam puanın üçte biri) uygulandı, çünkü kayıt projenin ya da tezin '
        .'tamamlanıp tamamlanmadığını taşımıyor — tamamlanmış bir TÜBİTAK proje yürütücülüğü '
        .'100 yerine 33 puandan sayılıyor. Ödüllerde uluslararası bilim ödülü (100), proje '
        .'ödülü (80) ve teşvik ödülü (60) tek etikete düştüğü için 40 puandan; ulusal '
        .'karşılıkları 10 puandan sayılıyor. Üniversitenin ihtisaslaşma alanı projeleri, '
        .'bilimsel kazı etkinlikleri, açık erişim kayıtları, marka tescili ve grafik tasarım '
        .'satırlarının çoğu girilemedi. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünür: derslerin "son beş yılda verilen" '
        .'penceresi, "yıllık dersler iki katı" kuralı ve idari görevlerin süre koşulları '
        .'uygulanamıyor.',

    // Puanlama Sistemi tablosu: yazar sayısı × isim sırası.
    'yazar_katsayisi' => [
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 1.00, 3 => 0.90, 4 => 0.85, 5 => 0.80,
                6 => 0.75, 7 => 0.70], 'sonrasi' => 0.65],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 1.00, 3 => 0.90, 4 => 0.85, 5 => 0.80,
                6 => 0.75, 7 => 0.70], 'sonrasi' => 0.65],
            'yazar_2' => ['kademeler' => [2 => 0.90, 3 => 0.80, 4 => 0.75, 5 => 0.70, 6 => 0.65,
                7 => 0.60], 'sonrasi' => 0.55],
            'yazar_3' => ['kademeler' => [3 => 0.70, 4 => 0.65, 5 => 0.60, 6 => 0.55, 7 => 0.50],
                'sonrasi' => 0.45],
            'yazar_4' => ['kademeler' => [4 => 0.55, 5 => 0.50, 6 => 0.45, 7 => 0.40],
                'sonrasi' => 0.35],
            'yazar_5' => ['kademeler' => [5 => 0.40, 6 => 0.35, 7 => 0.30], 'sonrasi' => 0.25],
            'yazar_6' => ['kademeler' => [6 => 0.25, 7 => 0.20], 'sonrasi' => 0.15],
            // Sırasını belirtmeyen aday için o yazar sayısındaki en düşük satır.
            'ortak' => ['kademeler' => [2 => 0.90, 3 => 0.70, 4 => 0.55, 5 => 0.40, 6 => 0.25,
                7 => 0.10], 'sonrasi' => 0.05],
        ],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        // Asgari koşulların atıf yaptığı kümeler.
        '1.1' => ['1.1'],
        '1.2' => ['1.2'],
        '1.6' => ['1.6'],
        '1.1-1.2' => ['1.1', '1.2'],
        '1.1-1.2-1.6' => ['1.1', '1.2', '1.6'],
        '1.1-1.8' => $kodlar('1.'),
        // "Tablo 1'de yer alan 1-6 numaralı kategoriler".
        'KATEGORI-1-6' => [...$kodlar('1.'), ...$kodlar('2.'), ...$kodlar('3.'),
            ...$kodlar('4.'), ...$kodlar('5.'), ...$kodlar('6.')],
        // Puan telafisi koşullarının atıf yaptığı kümeler.
        'PROJE-YURUTUCU' => ['7.6', '7.8'],
        'PATENT-TESCIL' => ['10.1', '10.2', '10.3'],
        // Tavan grupları.
        'HAKEMLIK' => ['5.8'],
        'ATIF' => $kodlar('6.'),
        'DERS' => ['7.1'],
        'IDARI' => $kodlar('15.'),
    ],

    'grup_tavanlari' => [
        'HAKEMLIK' => 50,
        'ATIF' => 100,
        'DERS' => 30,
        'IDARI' => 100,
    ],
];
