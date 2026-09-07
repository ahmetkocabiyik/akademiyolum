<?php

use App\Enums\Kategori;

/**
 * NEVŞEHİR HACI BEKTAŞ VELİ ÜNİVERSİTESİ — EK 1 Puanlama Tablosu
 * Kaynak: pdf/17537005202.nevsehirhacıbektasiveliuniverstesi.pdf
 * (30 sayfa)
 *
 * Madde kodları tablonun kendi numaralandırması (A.1, C.2.5, E.17 …).
 *
 * ── ÜÇ CETVEL: A.11 ve A.12 ALANA GÖRE DEĞİŞİYOR ──
 * A.11 dipnotu "Hukuk, İlahiyat ve Filoloji alanları için bu puan 20
 * olarak kabul edilecektir", A.12 dipnotu "Hukuk alanı için 10, İlahiyat
 * ve Filoloji alanları için 5" diyor. Tablonun geri kalanı bütün
 * alanlarda aynı:
 *   `nevsehir-2021`           A.11 = 5,  A.12 = 3
 *   `nevsehir-2021-hukuk`     A.11 = 20, A.12 = 10
 *   `nevsehir-2021-ilahiyat`  A.11 = 20, A.12 = 5 (İlahiyat ve Filoloji)
 *
 * ── AYNI ETİKETE DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   A.13 ansiklopedi bölümü (2) ile A.14 sözlük maddesi (1) → 1.
 *   B bölümünde bütün editörlük, yayın kurulu üyeliği ve hakemlik
 *       satırları 1-2 puan; SCI dergilerinde editörlük 2, kalan her şey
 *       1 puandan.
 *   D.1'de ödüller 25'ten 3'e iniyor; etiketin ayırabildiği yerde
 *       ayrıldı, ayıramadığı yerde en düşükten.
 *   D.7 idari görevlerde "birden fazla görev olması hâlinde sadece en
 *       yüksek puanlı görev puanlanır" kuralı uygulanmıyor.
 *   E bölümünde sanat etkinliklerinin uluslararası ve ulusal ayrımı
 *       etiketten okunabildiği yerde ayrıldı.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   D.5 (h-indeksi puanı) — faaliyet satırı değil, profil ölçütü.
 *   A.25 (kişiye özgü denklem, şema, şekil), C.3 (talep edilen bilimsel
 *       rapor), D.6 ("Doğal ve Kültürel Miras Turizmi" ihtisaslaşma
 *       görevi), D.8 (üniversite tanıtım etkinliği) — sözlükte karşılık
 *       yok.
 *   D.2.4 patent BAŞVURUSU (2) — tescilliden ayrılamıyor.
 *   E.16-E.21 (spor branşlarında sporcu yetiştirme, millî takım
 *       antrenörlüğü; 5-30 puan) — sözlükte karşılık yok.
 *
 * ── MOTORUN KARŞILAYAMADIĞI SINIRLAR ──
 * "C.4 toplamda en fazla 6 puan" ve "C.5 en fazla 10 puan", "D.4 en
 * fazla 5 puan" (tavan olarak yazıldı); "aynı sanat yapıtının
 * tekrarlanan gösterimlerinden alınan puan özgün üretimin puanını
 * aşamaz"; "son iki yılda verilen dersler" penceresi; D.2'nin
 * "patentlerde puan kişi sayısına bölünür" kuralı (EK 2 çarpanı
 * uygulanıyor, ayrıca bölme yapılmıyor).
 *
 * Yönerge: yonerge/nevsehir.php
 */
$SCI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)'];
$TAM = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];

$sanatSatinU = ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Haber Olması (Uluslararası)',
    'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Belgesel/Kısa Film (Uluslararası)'];
$sanatSatinN = ['Eserin Satın Alınması (Yurt İçi)', 'Eserin Haber Olması (Ulusal)',
    'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Belgesel/Kısa Film (Ulusal)',
    'Yönetmenlik (Sahne/Ekran)'];
$sanatKarmaU = ['Karma/Jürili Etkinlik (Uluslararası)', 'Elektronik Karma Sergi (Uluslararası)',
    'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)'];
$sanatKarmaN = ['Karma/Jürili Etkinlik (Ulusal)', 'Elektronik Karma Sergi (Ulusal)',
    'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Jürisiz, Ulusal)',
    'Karma Etkinlik (Yurt Dışı, Jürisiz)'];
$sanatKisiselU = ['Kişisel Etkinlik (Uluslararası)', 'Elektronik Kişisel Sergi (Uluslararası)',
    'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)'];
$sanatKisiselN = ['Kişisel Etkinlik (Ulusal)', 'Elektronik Kişisel Sergi (Ulusal)',
    'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)'];
$sanatJuri = ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)',
    'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'];
$sanatMuzeU = ['Eserin Müzeye Kabulü (Yurt Dışı)'];
$sanatMuzeN = ['Eserin Müzeye Kabulü (Yurt İçi)'];
$sanatSempozyumU = ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Masterclass (Uluslararası)'];
$sanatSempozyumN = ['Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Masterclass (Ulusal)'];
$sanatSahne = ['Koreografi', 'Bale/Dans Koreograflığı (Uluslararası)',
    'Bale/Dans Koreograflığı (Ulusal)', 'Rejisörlük (Uluslararası)', 'Rejisörlük (Ulusal)',
    'Rejisörlük (Konservatuvar)', 'Tüm Perde Koreograflığı (Uluslararası)',
    'Tüm Perde Koreograflığı (Ulusal)'];

$sanatKullanilan = array_merge($sanatSatinU, $sanatSatinN, $sanatKarmaU, $sanatKarmaN,
    $sanatKisiselU, $sanatKisiselN, $sanatJuri, $sanatMuzeU, $sanatMuzeN,
    $sanatSempozyumU, $sanatSempozyumN, $sanatSahne);
$sanatKalan = array_values(array_diff(Kategori::SanatselEtkinlik->kaynaklar(), $sanatKullanilan));

/**
 * @return array<string, array<string, mixed>>
 */
$govde = fn (int $a11, int $a12): array => [
    // ══ A. YAYINLAR VE ATIFLAR — ULUSLARARASI MAKALE ══
    'A.1-Q1' => ['baslik' => 'SCI, SCIE ya da SSCI indeksli Q1 dergide yayımlanan tam metin makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $TAM, 'puan' => 30],
    'A.1-Q2' => ['baslik' => 'SCI, SCIE ya da SSCI indeksli Q2 dergide yayımlanan tam metin makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $TAM, 'puan' => 20],
    'A.1-Q3' => ['baslik' => 'SCI, SCIE ya da SSCI indeksli Q3 dergide yayımlanan tam metin makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $TAM, 'puan' => 15],
    'A.1-Q4' => ['baslik' => 'SCI, SCIE ya da SSCI indeksli Q4 dergide yayımlanan tam metin makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $TAM, 'puan' => 10],
    'A.2' => ['baslik' => 'AHCI indeksli dergide yayımlanan tam metin makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => $TAM, 'puan' => 20],
    'A.3' => ['baslik' => 'ESCI ya da Scopus indeksli dergide yayımlanan tam metin makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $TAM, 'puan' => 10],
    'A.4' => ['baslik' => 'Diğer uluslararası indekslerde taranan dergide yayımlanan tam metin makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $TAM, 'puan' => 5],
    'A.5' => ['baslik' => 'Uluslararası indeksli dergide yayımlanan teknik not, editöre mektup, kısa metin ya da makale/kitap eleştirisi', 'kategori' => 'makale', 'kaynaklar' => [...$SCI, 'AHCI', 'ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 3],

    // ══ ULUSAL MAKALE ══
    'A.6' => ['baslik' => 'TR Dizin indeksli dergide yayımlanan tam metin makale (derleme dâhil)', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TAM, 'puan' => 10],
    'A.7' => ['baslik' => 'Diğer hakemli dergilerde yayımlanan tam metin makale (derleme dâhil)', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => 4],
    'A.8' => ['baslik' => 'Ulusal hakemli dergilerde yayımlanan teknik not, makale/kitap kritiği ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 2],

    // ══ KİTAP ══
    'A.9' => ['baslik' => 'Web of Science Book Citation Index kapsamındaki kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
    'A.10' => ['baslik' => 'Web of Science Book Citation Index kapsamındaki kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 10],
    'A.11' => ['baslik' => 'Diğer uluslararası ya da ulusal kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı'], 'puan' => $a11],
    'A.12' => ['baslik' => 'Diğer uluslararası ya da ulusal kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => $a12],
    'A.14' => ['baslik' => 'Ansiklopedide bölüm ya da madde, sözlükte madde tanımlaması', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 1],

    // ══ ATIF ══
    'A.15' => ['baslik' => 'SCI, SCIE, SSCI, AHCI, ESCI ya da Scopus indeksli dergilerde eserinize yapılan her bir atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
    'A.16' => ['baslik' => 'BKCI kapsamındaki kitapta eserinize yapılan her bir atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
    'A.17' => ['baslik' => 'TR Dizin indeksli dergilerde eserinize yapılan her bir atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
    'A.18' => ['baslik' => 'Diğer uluslararası ya da ulusal dergilerde veya kitaplarda eserinize yapılan her bir atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],

    // ══ BİLİMSEL TOPLANTILAR ══
    'A.19' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan, tam metni ya da özeti CPCI\'de yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 5],
    'A.20' => ['baslik' => 'Diğer uluslararası ya da ulusal bilimsel toplantıda sunulan, tam metni veya özeti yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Uluslararası Özet/Poster', 'Ulusal Tam Metin', 'Ulusal Özet/Poster'], 'puan' => 3],
    'A.21' => ['baslik' => 'Uluslararası ya da ulusal bilimsel toplantılarda davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 3],

    // ══ ÇEVİRİ ══
    'A.22' => ['baslik' => 'Kitap çevirisi ya da aktarması', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 5],
    'A.23' => ['baslik' => 'Makale, kitap bölümü ya da diğer metinlerin çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 2],

    // ══ B. DERGİ HAKEMLİĞİ VE EDİTÖRLÜK ══
    'B.1.1' => ['baslik' => 'SCI, SCIE, SSCI ve AHCI kapsamındaki dergilerde baş editörlük ya da editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 2],
    'B.3.2' => ['baslik' => 'Dergilerde editörlük, editör yardımcılığı, yayın kurulu üyeliği ya da hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi', 'TR Dizin Dergi', 'Diğer Hakemli Dergi', 'Yayın Kurulu Üyeliği', 'Hakemlik', 'BKCI Kitap', 'Kitap Editörlüğü'], 'puan' => 1],

    // ══ C. EĞİTİM VE ARAŞTIRMA FAALİYETLERİ ══
    'C.1.1' => ['baslik' => 'Sonuçlandırılmış doktora, tıpta uzmanlık ya da sanatta yeterlik tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman', 'es_danisman'], 'puan' => 5],
    'C.1.2' => ['baslik' => 'Sonuçlandırılmış yüksek lisans ya da uzmanlık tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman', 'es_danisman'], 'puan' => 3],
    'C.6.1' => ['baslik' => 'Tez jüri üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 1],
    'C.2.1' => ['baslik' => 'Uluslararası ya da ulusal kuruluşlarca desteklenmiş araştırma projesinde yürütücü veya koordinatör olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon', 'TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 15],
    'C.2.2' => ['baslik' => 'Uluslararası ya da ulusal kuruluşlarca desteklenmiş araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon', 'TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 10],
    'C.2.3' => ['baslik' => 'Uluslararası ya da ulusal kuruluşlarca desteklenmiş araştırma projesinde danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon', 'TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['danisman'], 'puan' => 5],
    'C.2.4' => ['baslik' => 'Kamu kurumu ya da özel kuruluşla yapılan Ar-Ge projesinde yürütücü, araştırmacı veya danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'puan' => 5],
    'C.2.5' => ['baslik' => 'Üniversitenin BAP ya da ihtisaslaşma birimince desteklenmiş araştırma projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 5],
    'C.2.6' => ['baslik' => 'Üniversitenin BAP ya da ihtisaslaşma birimince desteklenmiş araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 4],
    'C.4' => ['baslik' => 'Son iki yılda ön lisans, lisans ya da lisansüstü düzeyde ders vermek (haftalık ders saati başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders'], 'puan' => 1],
    'C.5' => ['baslik' => 'Yurt dışında ders ya da seminer vermek veya çağrılı konuşmacı olmak', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Değişim Programı Dersi'], 'puan' => 3],

    // ══ D. ÖDÜLLER VE DİĞER HİZMETLER ══
    'D.1.2' => ['baslik' => 'YÖK Üstün Başarı, TÜBİTAK Bilim ya da TÜBİTAK Teşvik Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü', 'TÜBİTAK / TÜBA Ödülü'], 'puan' => 25],
    'D.1.4' => ['baslik' => 'TÜBA Üstün Başarılı Genç Bilim İnsanı (GEBİP) Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 15],
    'D.1.5' => ['baslik' => 'TÜBA Bilimsel Telif Eser Ödülü ve diğer akademik ödüller', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ulusal Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü', 'Yarışma Derecesi / Mansiyon', 'Burs'], 'puan' => 5],
    'D.2.1' => ['baslik' => 'Uluslararası tescilli patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
    'D.2.2' => ['baslik' => 'Ulusal tescilli patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 10],
    'D.2.3' => ['baslik' => 'Tescil edilmiş faydalı model, endüstriyel tasarım ya da yazılım', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili', 'Ticarileştirme'], 'puan' => 5],
    'D.4.2' => ['baslik' => 'Bilimsel toplantıların düzenleyenler listesinde bulunmak (konferans başkanlığı, düzenleme kurulu, bilim kurulu, sekretarya)', 'kategori' => 'diger', 'kaynaklar' => ['Diğer', 'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 1],
    'D.6' => ['baslik' => 'Kurum ya da kuruluşlarca talep edilen bilimsel rapor ve toplumsal katkı çalışmaları', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı', 'Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 2],
    'D.7.1' => ['baslik' => 'Enstitü ya da yüksekokul müdürlüğü görevleri (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü'], 'puan' => 5],
    'D.7.2' => ['baslik' => 'Dekan yardımcılığı, bölüm başkanlığı, merkez müdürlüğü ya da koordinatörlük (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkanı', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 4],
    'D.7.3' => ['baslik' => 'Bölüm başkan yardımcılığı, koordinatör yardımcılığı ya da anabilim dalı başkanlığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 3],
    'D.7.4' => ['baslik' => 'Kurul ve komisyonlarda görev almak (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 2],

    // ══ E. SANAT VE SPOR FAALİYETLERİ ══
    'E.1' => ['baslik' => 'Özgün sanat eserinizin, bestenizin ya da tasarımınızın yurt dışında satın alınması, yayın organlarında yer alması veya uygulanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatSatinU, 'puan' => 30],
    'E.2' => ['baslik' => 'Özgün sanat eserinizin, bestenizin ya da tasarımınızın yurt içinde satın alınması, yayın organlarında yer alması veya uygulanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatSatinN, 'puan' => 20],
    'E.3' => ['baslik' => 'Uluslararası jürili karma sanat ve tasarım etkinliğine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKarmaU, 'puan' => 7],
    'E.4' => ['baslik' => 'Jürili karma sanat ve tasarım etkinliklerinde jüri üyeliği yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatJuri, 'puan' => 1],
    'E.5' => ['baslik' => 'Ulusal jürili karma sanat ve tasarım etkinliğine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => [...$sanatKarmaN, ...$sanatKalan], 'puan' => 4],
    'E.6' => ['baslik' => 'Yurt dışında kişisel sanat etkinliğinde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKisiselU, 'puan' => 5],
    'E.7' => ['baslik' => 'Yurt içinde kişisel sanat etkinliğinde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKisiselN, 'puan' => 3],
    'E.11.1' => ['baslik' => 'Eserinizin yurt içi müzeler tarafından kabul edilmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatMuzeN, 'puan' => 15],
    'E.11.2' => ['baslik' => 'Eserinizin yurt dışı müzeler tarafından kabul edilmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatMuzeU, 'puan' => 30],
    'E.12' => ['baslik' => 'Uluslararası sempozyum, festival, çalıştay, bienal ya da trienal gibi sanat etkinliklerine eserlerinizle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatSempozyumU, 'puan' => 15],
    'E.13' => ['baslik' => 'Ulusal sempozyum, festival, çalıştay, bienal ya da trienal gibi sanat etkinliklerine eserlerinizle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatSempozyumN, 'puan' => 10],
    'E.15' => ['baslik' => 'Sahne sanatlarında sanat grubu hazırlamak ve gösterilerin sunumunu sağlamak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatSahne, 'puan' => 10],
];

$KAPSAM = 'Puanlar Nevşehir Hacı Bektaş Veli Üniversitesi EK 1 Puanlama Tablosundan. Yazar '
    .'çarpanı EK 2\'ye göre hem yazar sayısına hem sıraya bakıyor: iki yazarlıda ilk isim 0,90; '
    .'üç yazarlıda 0,80/0,75/0,70; beşten fazla yazarlıda ilk isim 0,50, beşinciden sonrası '
    .'0,20. Yazar listesini boş bırakırsanız çarpan hiç uygulanmaz ve puanınız olduğundan '
    .'YÜKSEK görünür. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: D.5 (son beş yıldaki h-indeksi puanı) '
    .'faaliyet satırına çevrilemediği için hiç girilmedi. Ansiklopedi ve sözlük maddeleri 1 '
    .'puandan, SCI dışı bütün editörlük, yayın kurulu üyeliği ve hakemlikler 1 puandan '
    .'sayılıyor. A.25 (kişiye özgü denklem, şema, şekil), C.3 (talep edilen bilimsel rapor), '
    .'D.8 (üniversite tanıtım etkinliği) ile E.16-E.21 (spor branşlarında sporcu yetiştirme ve '
    .'millî takım antrenörlüğü; 5-30 puan) sözlükte karşılıksız olduğu için girilemedi. Patent '
    .'BAŞVURUNUZU kaydetmeyin: yönerge ona 2 puan veriyor ama kayıt türü tescilliden '
    .'ayrılamadığı için o satır girilmedi. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünebilir: D.7\'nin "birden fazla idari görev '
    .'varsa sadece en yüksek puanlı görev puanlanır" kuralı, D.2\'nin "patentlerde puan kişi '
    .'sayısına bölünür" kuralı (EK 2 çarpanı uygulanıyor, ayrıca bölme yapılmıyor), "aynı sanat '
    .'yapıtının tekrarlanan gösterimlerinden alınan puan özgün üretimin puanını aşamaz" kuralı '
    .'ve "son iki yılda verilen dersler" penceresi uygulanmıyor.';

// EK 2: Ortak çalışmalarda puan dağılımı (yazar sayısı × isim sırası).
$YAZAR = [
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.00]],
        'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.80, 4 => 0.70, 5 => 0.60], 'sonrasi' => 0.50],
        'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.80, 4 => 0.70, 5 => 0.60], 'sonrasi' => 0.50],
        'yazar_2' => ['kademeler' => [2 => 0.85, 3 => 0.75, 4 => 0.65, 5 => 0.55], 'sonrasi' => 0.45],
        'yazar_3' => ['kademeler' => [3 => 0.70, 4 => 0.60, 5 => 0.50], 'sonrasi' => 0.40],
        'yazar_4' => ['kademeler' => [4 => 0.55, 5 => 0.45], 'sonrasi' => 0.35],
        'yazar_5' => ['kademeler' => [5 => 0.40], 'sonrasi' => 0.30],
        'yazar_6' => ['sonrasi' => 0.20],
        'ortak' => ['kademeler' => [1 => 1.00, 2 => 0.85, 3 => 0.70, 4 => 0.55, 5 => 0.40], 'sonrasi' => 0.20],
    ],
];

$GRUPLAR = [
    // Koşulların atıf yaptığı indeks kümeleri.
    'SCI-Q123' => ['A.1-Q1', 'A.1-Q2', 'A.1-Q3'],
    'SCI' => ['A.1-Q1', 'A.1-Q2', 'A.1-Q3', 'A.1-Q4'],
    'SCI-AHCI' => ['A.1-Q1', 'A.1-Q2', 'A.1-Q3', 'A.1-Q4', 'A.2'],
    'SCI-ESCI' => ['A.1-Q1', 'A.1-Q2', 'A.1-Q3', 'A.1-Q4', 'A.2', 'A.3'],
    'ULUSLARARASI' => ['A.1-Q1', 'A.1-Q2', 'A.1-Q3', 'A.1-Q4', 'A.2', 'A.3', 'A.4'],
    'TRDIZIN' => ['A.6'],
    'ULUSAL' => ['A.6', 'A.7'],
    // "Uluslararası indekslerde/TR Dizin kapsamındaki dergilerde" (yeniden atanma).
    'ULUSLARARASI-TRDIZIN' => ['A.1-Q1', 'A.1-Q2', 'A.1-Q3', 'A.1-Q4', 'A.2', 'A.3', 'A.4', 'A.6'],
    'DIGER-TRDIZIN' => ['A.4', 'A.6'],
    'KITAP' => ['A.9', 'A.11'],
    'KITAP-BOLUM' => ['A.10', 'A.12'],
    'BILDIRI' => ['A.19', 'A.20', 'A.21'],
    'PROJE' => ['C.2.1', 'C.2.2', 'C.2.3', 'C.2.5'],
    // Tavan grupları.
    'DERS' => ['C.4'],
    'YURTDISI-DERS' => ['C.5'],
    'ORGANIZASYON' => ['D.4.2'],
];

// C.4 "toplamda en fazla 6 puan", C.5 "en fazla 10 puan", D.4 "en fazla 5 puan".
$TAVANLAR = ['DERS' => 6, 'YURTDISI-DERS' => 10, 'ORGANIZASYON' => 5];

$cetveller = [];

foreach ([
    'nevsehir-2021' => [5, 3],
    'nevsehir-2021-hukuk' => [20, 10],
    'nevsehir-2021-ilahiyat' => [20, 5],
] as $anahtar => [$a11, $a12]) {
    $cetveller[$anahtar] = [
        'kapsam_notu' => $KAPSAM,
        'yazar_katsayisi' => $YAZAR,
        'maddeler' => $govde($a11, $a12),
        'gruplar' => $GRUPLAR,
        'grup_tavanlari' => $TAVANLAR,
    ];
}

return ['cetveller' => $cetveller];
