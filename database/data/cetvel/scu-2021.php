<?php

/**
 * SİVAS CUMHURİYET ÜNİVERSİTESİ — EK-1 Akademik Faaliyet Puan Tablosu
 * Kaynak: pdf/17537008552.sivascumhuriyetuniverstesi.pdf (32 sayfa;
 * 10.12.2021 tarihli yönerge metni, YÖK onayıyla yürürlüğe girer.)
 *
 * Madde kodları EK-1'in kendi harf-numara düzeni (A1, C4, G6, İ2 …).
 * Yalnız çeyrekliğe göre bölünen A1 ve A2 satırlarının alt kodları,
 * projelerdeki rol ayrımı (`-yur`, `-ars`, `-dan`) ve tez yayını ayna
 * satırları (`T…`) bize ait.
 *
 * ── BÖLÜM TAVANLARI KADRONUN ASGARİ PUANINA BAĞLI ──
 * Tablonun altındaki not: "Bazı akademik faaliyetlerden alınabilecek
 * puanlar yüzde ifadesiyle sınırlandırılmıştır. İlgili puanın
 * hesaplanması için ifade edilen toplam puan, adaydan atanması için
 * istenilen asgari puan anlamına gelmektedir." Asgari puan kadroya göre
 * değiştiği için cetvelin üç varyantı üretildi:
 *   `scu-2021-50`   doktor öğretim üyeliğine ilk atama, sekiz temel
 *                   alanda yeniden atanma ve profesörlük (50 puan)
 *   `scu-2021-60`   Fen, Mühendislik, Ziraat ve Sağlık temel alanlarında
 *                   yeniden atanma (60 puan)
 *   `scu-2021-300`  doçentlik (300 puan)
 * Yüzdeler aşağı yuvarlandı (50 × %25 = 12,5 → 12); tavanı düşük tutmak
 * adayın puanını fazla göstermez.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   A1 ve A2 satırları AHCI için çeyreklik vermiyor; AHCI en düşük
 *       çeyrek (Q4) satırından sayılıyor.
 *   A5 (Üniversitenin tanıdığı alan endeksleri, 10) ile A6 (diğer
 *       uluslararası hakemli dergi, 8) → tek etiket; 8 girildi.
 *   B2'nin özet bildiri değeri (4) ile B3'ün poster özeti (2) → tek
 *       'Uluslararası Özet/Poster' etiketi; 2 girildi. B5 (4) ile B6
 *       (1) ulusal karşılığında 1 girildi. B1 uluslararası davetli
 *       konuşmacı (12) ile B4 ulusal davetli konuşmacı (8) → 8.
 *   D5 ulusal atıf 1,5 puan → tam sayıya yuvarlanarak 1.
 *   E2 (SCI dergide hakemlik, 5) ile E4 (diğer dergide hakemlik, 3) →
 *       tek 'Hakemlik' etiketi; 3 girildi.
 *   J2 uluslararası burs (15) ile J5 ulusal burs (8) → tek 'Burs'
 *       etiketi; 8 girildi.
 *   L1'in dekanlık (30) ile L2'nin enstitü/yüksekokul müdürlüğü (25)
 *       değerleri tek 'Dekan / Enstitü-YO Müdürü' etiketine düşüyor;
 *       25 girildi.
 *   H bölümünün mimari proje satırları (40, 36, 24, 18) tek 'Uygulama
 *       Projesi' etiketlerine düşüyor; 18 girildi. Bandrollü kayıt
 *       satırları (50, 40, 40, 30) → 30.
 *
 * ── TEZ YAYINI AYNA SATIRLARI ──
 * MADDE 16 doktor öğretim üyeliğine ilk atamada "adayın hazırladığı
 * lisansüstü tez konusuyla ilgili en az 1 makale" istiyor ama EK-1'de
 * bu nitelik için ayrı satır yok. Koşulun değerlendirilebilmesi için
 * `tez_yayini` kategorisinde puanları karşılıklarıyla birebir aynı ayna
 * satırlar açıldı (T1, T3, T4, T6, TB, TC1, TC2, TC4, TC6). Adayın
 * tezinden üretilmiş çalışmayı "tez yayını" olarak kaydetmesi gerekir.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   A8 (Üniversiteye bağlı hakemli dergilerde makale, 10) — sözlükte
 *       karşılıksız. MADDE 12(b)'nin "A8 kapsamında en az 2 makale"
 *       seçeneği bu yüzden yönergeye girmedi; aynı bendin A1/A3/A4
 *       seçeneği girildi.
 *   K bölümünün tamamı (kazı ve yüzey araştırması faaliyetleri) —
 *       sözlükte karşılıksız.
 *   E5-E9 (proje ve sanat etkinliği hakemliği), F4-F5 (firma sahipliği),
 *       G7 (teknopark danışmanlığı), H1-H4'ün bir kısmı, H5 ve H9
 *       (yarışma jüriliği; E10-E11 satırlarıyla karşılandı) — sözlükte
 *       karşılıksız ya da aynı etikete düşüyor. 06.09.2026'da yeniden
 *       bakıldı: H9 ("Meslek Odaları, Yerel Yönetimler, Bakanlıklar vb.
 *       mimari proje yarışmalarında jüri üyeliği", 16 puan) bir KURUL
 *       ÜYELİĞİ değil JÜRİ ÜYELİĞİ satırı; E11 ile aynı etikete düştüğü ve
 *       E11 daha düşük olduğu için etiket 5'te kalıyor (§0 doğrultusunda).
 *   D bölümünün "bir yayın için en fazla 10 atıf" kuralı ve E
 *       bölümünün "yardımcı editöre yarısı, alan editörüne üçte biri"
 *       kuralı motorda yok.
 *
 * Yönerge: yonerge/scu.php
 */
$TAM = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];

$SANAT_ULUSLARARASI_KISISEL = ['Kişisel Etkinlik (Uluslararası)', 'Elektronik Kişisel Sergi (Uluslararası)',
    'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)',
    'Resital (Uluslararası)', 'Solistlik (Uluslararası)', 'Şan Resitali (Uluslararası)',
    'Opera Birinci Rol (Uluslararası)', 'Oratoryo/Kantat Solistliği (Uluslararası)',
    'Orkestra Şefliği (Uluslararası)', 'Opera Şefliği (Uluslararası)', 'Koro Şefliği (Uluslararası)',
    'Bale Orkestra Şefliği (Uluslararası)', 'Bale Başrol (Uluslararası)', 'Bale Solist Rol (Uluslararası)',
    'Dansçı / Performans İcracısı (Uluslararası)', 'Rejisörlük (Uluslararası)',
    'Tüm Perde Koreograflığı (Uluslararası)', 'Bale/Dans Koreograflığı (Uluslararası)',
    'Koruma-Onarım Uygulaması (Uluslararası)', 'Masterclass (Uluslararası)'];
$SANAT_ULUSLARARASI_KARMA = ['Karma/Jürili Etkinlik (Uluslararası)', 'Elektronik Karma Sergi (Uluslararası)',
    'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)',
    'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Oda Müziği Grup Üyeliği (Uluslararası)',
    'Başkemancılık (Uluslararası)', 'Grup Şefliği (Uluslararası)', 'Corps de Ballet (Uluslararası)',
    'Opera İkinci Rol (Uluslararası)', 'Rejisör Yardımcılığı (Uluslararası)',
    'Bölüm Koreograflığı (Uluslararası)', 'Sahneleme/Repetitörlük — Tüm Perde (Uluslararası)',
    'Sahneleme/Repetitörlük — Bölüm (Uluslararası)', 'Eğitici Konser Programı (Uluslararası)'];
$SANAT_ULUSAL_KISISEL = ['Kişisel Etkinlik (Ulusal)', 'Elektronik Kişisel Sergi (Ulusal)',
    'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)',
    'Resital (Ulusal)', 'Solistlik (Ulusal)', 'Şan Resitali (Ulusal)', 'Opera Birinci Rol (Ulusal)',
    'Oratoryo/Kantat Solistliği (Ulusal)', 'Orkestra Şefliği (Ulusal)', 'Opera Şefliği (Ulusal)',
    'Koro Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Ulusal)', 'Bale Başrol (Ulusal)',
    'Bale Solist Rol (Ulusal)', 'Dansçı / Performans İcracısı (Ulusal)', 'Rejisörlük (Ulusal)',
    'Rejisörlük (Konservatuvar)', 'Tüm Perde Koreograflığı (Ulusal)', 'Bale/Dans Koreograflığı (Ulusal)',
    'Koruma-Onarım Uygulaması (Ulusal)', 'Masterclass (Ulusal)', 'Koreografi'];
$SANAT_ULUSAL_KARMA = ['Karma/Jürili Etkinlik (Ulusal)', 'Elektronik Karma Sergi (Ulusal)',
    'Karma Etkinlik (Jürisiz, Ulusal)', 'Oda Müziği Grup Üyeliği (Ulusal)', 'Başkemancılık (Ulusal)',
    'Grup Şefliği (Ulusal)', 'Corps de Ballet (Ulusal)', 'Opera İkinci Rol (Ulusal)',
    'Rejisör Yardımcılığı (Ulusal)', 'Rejisör Yardımcılığı (Konservatuvar)',
    'Bölüm Koreograflığı (Ulusal)', 'Sahneleme/Repetitörlük — Tüm Perde (Ulusal)',
    'Sahneleme/Repetitörlük — Bölüm (Ulusal)', 'Eğitici Konser Programı (Ulusal)',
    'Orkestra / Koro Üyeliği', 'Karma Albüm / CD-DVD Katkısı', 'Müzikoloji Atölyesi',
    'Eğitim Amaçlı Sanat Etkinliği', 'Sahne Tasarımı (Dekor, Kostüm, Işık)',
    'Yönetmenlik (Sahne/Ekran)', 'Özgün Eser / Beste / Tasarım'];

$maddeler = [
    // ══ A. MAKALELER ══ (çeyreklik alt kodları bize ait)
    'A1-Q1' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki Q1 dergide yayımlanmış özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $TAM, 'puan' => 60],
    'A1-Q2' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki Q2 dergide yayımlanmış özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $TAM, 'puan' => 50],
    'A1-Q3' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki Q3 dergide yayımlanmış özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $TAM, 'puan' => 40],
    'A1-Q4' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki Q4 dergide yayımlanmış özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => $TAM, 'puan' => 30],
    'A2-Q1' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki Q1 dergide yayımlanmış editöre mektup, olgu sunumu, teknik not ya da yorum', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $KISA, 'puan' => 30],
    'A2-Q2' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki Q2 dergide yayımlanmış editöre mektup, olgu sunumu, teknik not ya da yorum', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $KISA, 'puan' => 25],
    'A2-Q3' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki Q3 dergide yayımlanmış editöre mektup, olgu sunumu, teknik not ya da yorum', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $KISA, 'puan' => 20],
    'A2-Q4' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki Q4 dergide yayımlanmış editöre mektup, olgu sunumu, teknik not ya da yorum', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => $KISA, 'puan' => 15],
    'A3' => ['baslik' => 'ESCI kapsamındaki dergide yayımlanmış tam makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $TAM, 'puan' => 25],
    'A4' => ['baslik' => 'TR Dizin kapsamındaki dergide yayımlanmış özgün araştırma makalesi veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TAM, 'puan' => 15],
    'A6' => ['baslik' => 'Diğer uluslararası hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $TAM, 'puan' => 8],
    'A7' => ['baslik' => 'Diğer ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => 6],
    'A9' => ['baslik' => 'ESCI, TR Dizin ya da alan endeksi kapsamındaki dergide yayımlanmış editöre mektup, olgu sunumu, teknik not ya da yorum', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'TR Dizin', 'Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 8],

    // ══ Tez yayını ayna satırları (kodlar bize ait) ══
    'T1' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 30],
    'T3' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, ESCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 25],
    'T4' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, TR Dizin kapsamındaki dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['TR Dizin'], 'puan' => 15],
    'T6' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, diğer hakemli dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Diğer'], 'puan' => 8],
    'TB' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, bildiri kitabında yayımlanmış çalışma', 'kategori' => 'tez_yayini', 'kaynaklar' => ['CPCI Bildiri'], 'puan' => 8],
    'TC1' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 50],
    'TC2' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, uluslararası yayınevi kitabında bölüm', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 20],
    'TC4' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 25],
    'TC6' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, ulusal yayınevi kitabında bölüm', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 10],

    // ══ B. BİLDİRİLER ══
    'B1' => ['baslik' => 'Bilimsel toplantıda davetli konuşmacı olarak sunulan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 8],
    'B2' => ['baslik' => 'Uluslararası bilimsel toplantıda sözlü sunulan ve tam metin olarak yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 8],
    'B3' => ['baslik' => 'Uluslararası bilimsel toplantıda özet olarak yayımlanan bildiri ya da poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 2],
    'B5' => ['baslik' => 'Ulusal bilimsel toplantıda sözlü sunulan ve tam metin olarak yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 4],
    'B6' => ['baslik' => 'Ulusal bilimsel toplantıda özet olarak yayımlanan bildiri ya da poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 1],

    // ══ C. KİTAP ══
    'C1' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış bilimsel, mesleki ya da ders kitabı yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 50],
    'C2' => ['baslik' => 'Uluslararası yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 20],
    'C3' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanan bilimsel ya da mesleki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 20],
    'C4' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanan bilimsel, mesleki ya da ders kitabı yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı', 'Tahkik (Tenkitli Metin)'], 'puan' => 25],
    'C5' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanan bilimsel ya da mesleki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 10],
    'C6' => ['baslik' => 'Ulusal yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 10],
    'C7' => ['baslik' => 'Uluslararası yayınevi tarafından yabancı dilde yayımlanan bilimsel kitabın çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 20],
    'C8' => ['baslik' => 'Uluslararası yayınevi tarafından yabancı dilde yayımlanan bilimsel kitabın bölüm çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 5],

    // ══ D. ATIFLAR ══
    'D1' => ['baslik' => 'SCI, SCI-Expanded, SSCI, AHCI ya da ESCI kapsamındaki dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
    'D2' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitapta yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 3],
    'D5' => ['baslik' => 'Ulusal hakemli dergide ya da ulusal yayınevi kitabında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 1],

    // ══ E. DERGİ EDİTÖRLÜĞÜ VE HAKEMLİK ══
    'E1' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 25],
    'E3' => ['baslik' => 'Diğer ulusal ya da uluslararası endekslerce taranan dergide editörlük veya editör kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi', 'TR Dizin Dergi', 'Diğer Hakemli Dergi', 'Yayın Kurulu Üyeliği'], 'puan' => 15],
    'E4' => ['baslik' => 'Hakemli dergide makale hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 3],
    'E10' => ['baslik' => 'Uluslararası sanat ve tasarım etkinliklerinde jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], 'puan' => 10],
    'E11' => ['baslik' => 'Ulusal sanat ve tasarım etkinliklerinde jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 5],

    // ══ F. PATENT ══
    'F1' => ['baslik' => 'Uluslararası tescillenmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 100],
    'F2' => ['baslik' => 'Ulusal tescillenmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 50],
    'F2-fm' => ['baslik' => 'Tescillenmiş faydalı model ya da tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım'], 'puan' => 25],
    'F3' => ['baslik' => 'Teknoloji transfer ofisi üzerinden firmalara verilen danışmanlık ve projenin başarıyla tamamlanması', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 50],

    // ══ G. BİLİMSEL ARAŞTIRMA PROJESİ ══ (yürütücü tam, araştırmacı yarım)
    'G1-yur' => ['baslik' => 'Birleşmiş Milletler, Dünya Bankası, Avrupa Birliği, OECD, NATO ya da EMA destekli, sonuçlandırılmış projede koordinatör olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 100],
    'G1-ars' => ['baslik' => 'Birleşmiş Milletler, Dünya Bankası, Avrupa Birliği, OECD, NATO ya da EMA destekli, sonuçlandırılmış projede araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 50],
    'G2-yur' => ['baslik' => 'Diğer uluslararası resmî kurum ve kuruluşlarca desteklenen, sonuçlandırılmış projede koordinatör olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 80],
    'G2-ars' => ['baslik' => 'Diğer uluslararası resmî kurum ve kuruluşlarca desteklenen, sonuçlandırılmış projede araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 40],
    'G3-yur' => ['baslik' => 'Üniversite-sanayi iş birliği kapsamındaki projede yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 60],
    'G4-dan' => ['baslik' => 'Üniversite-sanayi iş birliği kapsamındaki projede danışman ya da araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
    'G5-yur' => ['baslik' => 'Diğer ulusal resmî kurumlarca desteklenen projede yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 30],
    'G5-ars' => ['baslik' => 'Diğer ulusal resmî kurumlarca desteklenen projede araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],
    'G6-yur' => ['baslik' => 'TÜBİTAK ya da TÜBA tarafından desteklenen projede yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 80],
    'G6-ars' => ['baslik' => 'TÜBİTAK ya da TÜBA tarafından desteklenen projede araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 40],
    'G8-dan' => ['baslik' => 'Bakanlık ya da TÜBİTAK tarafından desteklenen projede eğitmen veya danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['danisman'], 'puan' => 15],
    'G9-yur' => ['baslik' => 'Üniversitenin BAP projelerinde yürütücülük yapmış olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 20],
    'G9-ars' => ['baslik' => 'Üniversitenin BAP projelerinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],

    // ══ H. BİLİMSEL, SANATSAL, MİMARİ VE TASARIMA YÖNELİK ETKİNLİKLER ══
    'H4' => ['baslik' => 'Yürütücüsü olduğunuz özgün uygulanmış mimari projenin kitapta ya da mesleki dergide kendi isminizle yayımlanmış olması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman'], 'puan' => 18],
    'H7' => ['baslik' => 'Uluslararası sempozyum, kongre, festival ya da bienal gibi etkinliklerde görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 12],
    'H8' => ['baslik' => 'Yurt dışı yayınlarda kendi alanınızdaki bilimsel ya da sanatsal çalışmalarınız hakkında yayın yapılmış olması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Haber Olması (Uluslararası)', 'Eserin Haber Olması (Ulusal)'], 'puan' => 6],
    'H11' => ['baslik' => 'Özgün sanat yapıtlarınızın satın alınması, yayın organlarında yer alması ya da tasarım projelerinizin uygulamaya konulması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt İçi)', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'], 'puan' => 40],
    'H12' => ['baslik' => 'Uluslararası alanda kişisel sanat ya da tasarım etkinliğinde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $SANAT_ULUSLARARASI_KISISEL, 'puan' => 40],
    'H13' => ['baslik' => 'Uluslararası alanda karma ya da ortak sanat ve tasarım etkinliğinde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $SANAT_ULUSLARARASI_KARMA, 'puan' => 30],
    'H14' => ['baslik' => 'Ulusal alanda kişisel sanat ya da tasarım etkinliğinde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $SANAT_ULUSAL_KISISEL, 'puan' => 30],
    'H15' => ['baslik' => 'Ulusal alanda karma ya da ortak sanat ve tasarım etkinliğinde bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $SANAT_ULUSAL_KARMA, 'puan' => 20],
    'H19' => ['baslik' => 'Sanatsal performansa dayalı yayımlanmış özgün ses ya da görüntü kaydı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bandrollü Kayıt (CD/DVD)', 'Albüm / Konser Kaydı', 'Eğitim Müziği Albümü'], 'puan' => 30],

    // ══ I. TEZ DANIŞMANLIĞI VE JÜRİ ÜYELİĞİ ══
    'I1' => ['baslik' => 'Tamamlanmış doktora, tıpta/diş hekimliğinde uzmanlık ya da sanatta yeterlik tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 30],
    'I2' => ['baslik' => 'Tamamlanmış doktora, uzmanlık ya da sanatta yeterlik tez eş danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 15],
    'I3' => ['baslik' => 'Tamamlanmış yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 10],
    'I4' => ['baslik' => 'Tamamlanmış yüksek lisans tez eş danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 5],
    'I6' => ['baslik' => 'Lisansüstü tez izleme komitesi ya da tez jürisi üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 2],

    // ══ İ. EĞİTİME KATKI ══
    'İ1' => ['baslik' => 'Lisansüstü düzeyde ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 4],
    'İ2' => ['baslik' => 'Lisans ya da ön lisans düzeyinde ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 2],

    // ══ J. ÖDÜL, YARIŞMA, UYGULAMA, YAZILIM ══
    'J1' => ['baslik' => 'Alanınızda uluslararası jürili bilimsel ya da sanatsal etkinlikte ödül almak', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü'], 'puan' => 30],
    'J2' => ['baslik' => 'Alanınızda uluslararası proje ya da teşvik ödülü almak', 'kategori' => 'odul', 'kaynaklar' => ['Ufuk Avrupa / ERC Ödülü'], 'puan' => 15],
    'J3' => ['baslik' => 'TÜBİTAK ya da TÜBA gibi ulusal bilimsel kuruluşlarca verilen bilim, teşvik veya hizmet ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 20],
    'J4' => ['baslik' => 'Alanınızda ulusal jürili bilimsel ya da sanatsal etkinlikte ödül almak', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'YÖK Ödülü'], 'puan' => 15],
    'J5' => ['baslik' => 'Üç aydan uzun süreli araştırma bursu almak', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 8],
    'J6' => ['baslik' => 'Planlama, mimarlık, kentsel tasarım, peyzaj ya da endüstri ürünleri tasarımı yarışmalarında derece almak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 15],
    'J7' => ['baslik' => 'Proje ve yapım yönetimi, tasarım ya da planlama alanlarında yazılım üreticisi olmak', 'kategori' => 'patent', 'kaynaklar' => ['Yazılım'], 'puan' => 15],
    'J10' => ['baslik' => 'Çeşit ya da ırk tescili', 'kategori' => 'patent', 'kaynaklar' => ['Islahçı Hakkı / Çeşit Tescili'], 'puan' => 7],

    // ══ L. İDARİ VE DİĞER GÖREVLER ══
    'L1' => ['baslik' => 'Rektör ya da rektör yardımcısı olarak görev yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı'], 'puan' => 30],
    'L2' => ['baslik' => 'Dekan, enstitü, yüksekokul, meslek yüksekokulu ya da merkez müdürü olarak görev yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 25],
    'L3' => ['baslik' => 'Dekan yardımcısı, müdür yardımcısı ya da başhekim yardımcısı olarak görev yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 20],
    'L4' => ['baslik' => 'Üniversite yönetim kurulu, senato veya diğer kurul üyeliği ya da bölüm başkanlığı yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Senato / Üniversite Yönetim Kurulu Üyesi', 'Bölüm Başkanı'], 'puan' => 10],
    'L5' => ['baslik' => 'Koordinatörlük, komisyon üyeliği, bölüm başkan yardımcılığı ya da anabilim dalı başkanlığı yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük', 'Kurul / Komisyon Üyeliği'], 'puan' => 5],
];

$gruplar = [
    'A1' => ['A1-Q1', 'A1-Q2', 'A1-Q3', 'A1-Q4'],
    'A1-A2' => ['A1-Q1', 'A1-Q2', 'A1-Q3', 'A1-Q4', 'A2-Q1', 'A2-Q2', 'A2-Q3', 'A2-Q4'],
    'A1-A3' => ['A1-Q1', 'A1-Q2', 'A1-Q3', 'A1-Q4', 'A3'],
    'A1-A3-A4' => ['A1-Q1', 'A1-Q2', 'A1-Q3', 'A1-Q4', 'A3', 'A4'],
    'A1-A4' => ['A1-Q1', 'A1-Q2', 'A1-Q3', 'A1-Q4', 'A2-Q1', 'A2-Q2', 'A2-Q3', 'A2-Q4', 'A3', 'A4'],
    'A4-A5' => ['A4'],
    'MAKALE' => ['A1-Q1', 'A1-Q2', 'A1-Q3', 'A1-Q4', 'A3', 'A4', 'A6', 'A7'],
    'TEZ-YAYINI' => ['T1', 'T3', 'T4', 'T6', 'TB', 'TC1', 'TC2', 'TC4', 'TC6'],
    'B' => ['B1', 'B2', 'B3', 'B5', 'B6'],
    'C' => ['C1', 'C2', 'C3', 'C4', 'C5', 'C6', 'C7', 'C8'],
    'C-KITAP' => ['C1', 'C4'],
    'C-BOLUM' => ['C2', 'C6'],
    'C-EDITOR' => ['C3', 'C5'],
    'D' => ['D1', 'D2', 'D5'],
    'E' => ['E1', 'E3', 'E4', 'E10', 'E11'],
    'F' => ['F1', 'F2', 'F2-fm', 'F3', 'J7', 'J10'],
    'F-PATENT' => ['F1', 'F2'],
    'G' => ['G1-yur', 'G1-ars', 'G2-yur', 'G2-ars', 'G3-yur', 'G4-dan', 'G5-yur', 'G5-ars',
        'G6-yur', 'G6-ars', 'G8-dan', 'G9-yur', 'G9-ars'],
    'G-YURUTUCU' => ['G1-yur', 'G2-yur', 'G3-yur', 'G5-yur', 'G6-yur', 'G9-yur'],
    'G-ARASTIRMACI' => ['G1-ars', 'G2-ars', 'G4-dan', 'G5-ars', 'G6-ars', 'G8-dan', 'G9-ars'],
    'H' => ['H4', 'H7', 'H8', 'H11', 'H12', 'H13', 'H14', 'H15', 'H19'],
    'I' => ['I1', 'I2', 'I3', 'I4', 'I6'],
    'I-DOKTORA' => ['I1', 'I2'],
    'I-YUKSEKLISANS' => ['I3', 'I4'],
    'EGITIM' => ['İ1', 'İ2'],
    'J' => ['J1', 'J2', 'J3', 'J4', 'J5', 'J6'],
    'L' => ['L1', 'L2', 'L3', 'L4', 'L5'],
];

// EK-2: Bilimsel faaliyetlerde (A, B, C, F, H ve J maddelerinde)
// kullanılacak katkı oranları. Sorumlu yazara tekabül eden puanın %15'i
// ilave edilir; motor çarpanı 1,0'ın üstüne çıkarmaz.
$yazarKatsayisi = [
    'haric' => ['atif', 'editorluk', 'proje', 'tez_danismanligi', 'egitim_ogretim',
        'idari_gorev', 'toplumsal_katki', 'diger', 'tez_yayini'],
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.00]],
        'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.85, 3 => 0.75, 4 => 0.70], 'sonrasi' => 0.60],
        'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.97, 3 => 0.86, 4 => 0.80], 'sonrasi' => 0.69],
        'yazar_2' => ['kademeler' => [2 => 0.70, 3 => 0.60, 4 => 0.60], 'sonrasi' => 0.50],
        'yazar_3' => ['kademeler' => [3 => 0.50, 4 => 0.50], 'sonrasi' => 0.40],
        'yazar_4' => ['kademeler' => [4 => 0.40], 'sonrasi' => 0.30],
        'yazar_5' => ['sonrasi' => 0.20],
        'yazar_6' => ['sonrasi' => 0.10],
        'ortak' => ['sonrasi' => 0.10],
    ],
];

$kapsamNotu = 'Puanlar Sivas Cumhuriyet Üniversitesi Öğretim Üyeliği Kadrolarına Başvurma, '
    .'Yükseltilme ve Atanma Yönergesinin EK-1 Akademik Faaliyet Puan Tablosundan (10.12.2021). '
    .'Yazar çarpanı EK-2\'deki katkı oranları tablosundan: iki yazarlıda birinci %85, ikinci '
    .'%70; üç yazarlıda %75, %60, %50; dört yazarlıda %70, %60, %50, %40; beş ve daha fazla '
    .'yazarlıda %60\'tan %10\'a iner. Sorumlu yazara tekabül eden puanın %15\'i ilave edilir. '
    .'Çarpan yalnız makale, bildiri, kitap, patent, sanatsal etkinlik ve ödül kalemlerine '
    .'uygulanır; atıf, proje, editörlük, tez danışmanlığı, ders ve idari görev bölünmez. Yazar '
    .'listesini boş bırakırsanız çarpan hiç uygulanmaz ve puanınız olduğundan YÜKSEK görünür. '
    .'Bölüm tavanları kadronun asgari puanına bağlı yüzdelerden hesaplandı ve aşağı yuvarlandı. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünür: yardımcı editörlüğe baş editörlüğün '
    .'yarısı, alan editörlüğüne üçte biri verilmesi kuralı uygulanmıyor; bir yayına yapılan '
    .'atıflardan en fazla 10\'unun sayılması, aynı etkinlikte en fazla 2 bildirinin sayılması ve '
    .'derslerde "son 4 yılda her yarıyıl en fazla 4 ders" sınırı uygulanmıyor. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: Üniversiteye bağlı hakemli dergilerdeki '
    .'makaleler (10 puan) ve K bölümünün tamamı (kazı ve yüzey araştırması faaliyetleri) '
    .'sözlükte karşılıksız olduğu için girilmedi; uluslararası davetli konuşmacı 12 yerine 8, '
    .'uluslararası sözlü özet bildiri 4 yerine 2, uluslararası bursu 15 yerine 8, mimari proje '
    .'yayınları 40 yerine 18 puanla sayılıyor. Rolü girilmemiş projeler 0 puan alır.';

/** Bölüm tavanları: EK-1'in yüzdeleri × kadronun asgari puanı, aşağı yuvarlanmış. */
$tavanlar = function (int $asgari): array {
    $yuzde = fn (int $y): int => (int) floor($asgari * $y / 100);

    return [
        'B' => $yuzde(25), 'C' => $yuzde(25), 'D' => $yuzde(25), 'E' => $yuzde(25),
        'F' => $yuzde(40), 'G' => $yuzde(30), 'H' => $yuzde(25), 'I' => $yuzde(15),
        'EGITIM' => $yuzde(15), 'J' => $yuzde(20), 'L' => $yuzde(15),
    ];
};

$cetveller = [];

foreach ([50, 60, 300] as $asgari) {
    $cetveller["scu-2021-{$asgari}"] = [
        'kapsam_notu' => $kapsamNotu,
        'yazar_katsayisi' => $yazarKatsayisi,
        'maddeler' => $maddeler,
        'gruplar' => $gruplar,
        'grup_tavanlari' => $tavanlar($asgari),
    ];
}

return ['cetveller' => $cetveller];
