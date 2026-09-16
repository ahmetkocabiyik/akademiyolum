<?php

/**
 * RECEP TAYYİP ERDOĞAN ÜNİVERSİTESİ — EK-1 Değerlendirme Ölçütleri
 * Kaynak: pdf/17537006352.receptayyiperdoganuniversitesi.pdf
 * (50 sayfa; 31 Temmuz 2024 tarihli Senato Yönergesi, Sayı 215;
 * 30.01.2025 tarihli YÖK Genel Kurulu değişiklikleriyle; MADDE 14
 * uyarınca 1/5/2025'te yürürlüğe girdi.)
 *
 * Madde kodları EK-1'in kendi numaralandırması (1a, 3g, 13k …). Yalnız
 * 1. maddenin (a) bendi çeyrekliğe göre dört satıra bölündüğü için
 * `1a-Q1 … 1a-Q4` alt kodları bize ait.
 *
 * ── ATIF TAVANI ALAN × KADRO ──
 * EK-2'nin her temel alan cetveli "4. madde kapsamındaki faaliyetlerden
 * en fazla N puan alınabilir" diyor ve N alana ve kadroya göre değişiyor
 * (Eğitim doçentlik 70 / profesörlük 80; Sağlık 100 / 125; İlahiyat
 * 40 / 60 …). İlahiyat ayrıca kitap bölümüne 30 tavanı koyuyor. Tavan
 * matrisi dosyanın başında tek dizide duruyor ve her (alan, kadro) çifti
 * için bir cetvel varyantı üretiliyor. Tavan bildirmeyen alanlar
 * (Filoloji, Hukuk) ile doktor öğretim üyeliği kadroları tavansız
 * `rte-2025` varyantını kullanıyor.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   3c uluslararası yayınevi kitabı (15) ile 3e ulusal yayınevi kitabı
 *       (10) → sözlükte tek 'Uluslararası/Ulusal Kitap' etiketi var;
 *       3e (10) girildi, 3c girilmedi.
 *   3d uluslararası kitapta bölüm (8) ile 3f ulusal kitapta bölüm (5)
 *       → tek 'Kitap Bölümü' etiketi; 3f (5) girildi.
 *   4b SCIE/SSCI/AHCI atfı (4) ile 4c ESCI/SCOPUS atfı (3) → tek
 *       'WoS / Scopus' etiketi; 4c (3) girildi, 4b girilmedi.
 *   5b TÜBİTAK 1071 (40), 1001 grubu (30) ve 1501 grubu (20) ile 5c
 *       TÜSEB (20) → sözlükte program numarası yok, tek 'TÜBİTAK' ve
 *       'TÜSEB' etiketi var. Yönergenin kendi kuralı "b ve c bentleri
 *       dışındaki TÜBİTAK ve TÜSEB projeleri e bendi kapsamında
 *       puanlandırılır" dediği için ikisi de 5e satırına (10) bağlandı.
 *   7e uluslararası yayınevi kitabında editörlük (5) ile 7f ulusal
 *       (3) → tek 'Kitap Editörlüğü' etiketi; 7f (3) girildi.
 *   8c TÜBİTAK Bilim (40), 8d TÜBİTAK Teşvik (30) ve 8f TÜBA TESEP (15)
 *       → tek 'TÜBİTAK / TÜBA Ödülü' etiketi; en düşük satır (15)
 *       girildi. 8a ve 8b tek 'YÖK Ödülü' etiketine düştüğü için ikisi
 *       '8ab' kodunda birleşti (puanları zaten 40 ile aynı).
 *   13k TÜBİTAK bilim/toplum projesi (6) ile 13m toplumsal destek
 *       projesi (3) → toplumsal katkı etiketleri ayrışmıyor; '13k-m'
 *       kodunda 3 puanla birleşti.
 *
 * ── PROJEDE ROL BÖLÜNMESİ ──
 * EK-1'in 5. maddesi "yürütücü/koordinatör için 1/1, araştırmacı/uzman
 * için 1/3 ve danışman için 1/4" diyor. Motor rolü madde satırında
 * tuttuğu için her proje satırı üç koda bölündü (`5a`, `5a-ar`,
 * `5a-dan`) ve bölünmüş puanlar aşağı yuvarlandı. ROLÜ GİRİLMEMİŞ bir
 * proje hiçbir satıra uymaz ve 0 puan alır; §0'ın istediği yön.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   11. madde (Sportif Başarı ve Temsil) — olimpiyat madalyası, milli
 *       sporcu belgesi ve antrenörlük belgesi sözlükte karşılıksız.
 *       Hiçbir eşik bu maddeye atıf yapmıyor.
 *   13a (en az 15 özgün eser barındıran kişisel sergi, 20) — puan tek
 *       esere değil DOSYAYA veriliyor, kayıt eser başına tutuluyor.
 *   13e (h-indeksi en az 5, 5 puan), 13f ve 13g (yurt dışı araştırma
 *       6 ay 10 / 2-6 ay 5) — faaliyet değil ölçüt; motorun `h_indeksi`
 *       ve `yurtdisi_ay` metrikleri var ama bunlar puana çevrilemiyor.
 *   13n (eğiticilerin eğitimi sertifikası, 2) — sözlükte karşılıksız.
 *   5f (Atatürk Kültür, Dil ve Tarih Yüksek Kurumu projesi, 8) — 'Diğer
 *       Kamu Kurumu' etiketi 5e tarafından kullanılıyor.
 *   6. maddede 'Endüstriyel Tasarım', 'Yazılım' ve 'Ticarileştirme'
 *       etiketleri; 7. maddede 'Diğer Hakemli Dergi', 'Yayın Kurulu
 *       Üyeliği' ve 'Hakemlik'; 9. maddede 'Akreditasyon Faaliyeti';
 *       10. maddede 'Tez İzleme / Jüri Üyeliği'; 12. maddede 'Rektör',
 *       'Rektör Yardımcısı' ve 'Kurul / Komisyon Üyeliği' — yönergenin
 *       ilgili maddesi bu kalemleri saymıyor.
 *   3. maddenin ansiklopedi kuralı ("üç veya daha çok madde bir kitap
 *       bölümü kabul edilir") — motorda "N kayıt = 1 kalem" yok.
 *
 * ── MOTORUN KARŞILAYAMADIĞI ÇARPANLAR ──
 *   Rize tarihi, kültürü ve edebiyatı konulu kitaplarda ×1,5; çay
 *   ihtisas alanındaki proje ve tezlerde ×1,5; TÜBİTAK destekli tezlerde
 *   ×1,5, BAP destekli tezlerde ×1,3. Kayıt bu nitelikleri taşımıyor;
 *   hiçbiri uygulanmıyor, puan düşük kalıyor.
 *
 * Yönerge: yonerge/rte.php
 */
$SCI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)'];
$TAM = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];

$WOS_DERGI = ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'];

$BESTE = ['Özgün Eser / Beste / Tasarım', 'Opera/Bale Kompozisyonu', 'Orkestralı Sahne Eseri',
    'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Küçük Ölçekli Orkestra Eseri',
    'Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)',
    'Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)',
    'Sahne/Ekran Müziği', 'Orkestrasyon/Transkripsiyon'];

$KONSER = ['Solistlik (Uluslararası)', 'Solistlik (Ulusal)', 'Resital (Uluslararası)',
    'Resital (Ulusal)', 'Şan Resitali (Uluslararası)', 'Şan Resitali (Ulusal)',
    'Opera Birinci Rol (Uluslararası)', 'Opera Birinci Rol (Ulusal)',
    'Oratoryo/Kantat Solistliği (Uluslararası)', 'Oratoryo/Kantat Solistliği (Ulusal)',
    'Orkestra Şefliği (Uluslararası)', 'Orkestra Şefliği (Ulusal)',
    'Opera Şefliği (Uluslararası)', 'Opera Şefliği (Ulusal)',
    'Bale Orkestra Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Ulusal)',
    'Koro Şefliği (Uluslararası)', 'Koro Şefliği (Ulusal)'];

$JURI = ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)',
    'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'];

$EKRAN = ['Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)',
    'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'];

$maddeler = [
    // ══ 1. MAKALE ══ (a bendinin çeyreklik alt kodları bize ait)
    '1a-Q1' => ['baslik' => 'SCIE ya da SSCI kapsamındaki Q1 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $TAM, 'puan' => 30],
    '1a-Q2' => ['baslik' => 'SCIE ya da SSCI kapsamındaki Q2 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $TAM, 'puan' => 20],
    '1a-Q3' => ['baslik' => 'SCIE ya da SSCI kapsamındaki Q3 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $TAM, 'puan' => 15],
    '1a-Q4' => ['baslik' => 'SCIE ya da SSCI kapsamındaki Q4 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $TAM, 'puan' => 10],
    '1b' => ['baslik' => 'AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => $TAM, 'puan' => 20],
    '1c' => ['baslik' => 'ESCI, SCOPUS ya da SPORTDiscus kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $TAM, 'puan' => 10],
    '1d' => ['baslik' => 'TR Dizin kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TAM, 'puan' => 8],
    '1e' => ['baslik' => 'Diğer ulusal ya da uluslararası hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => 4],
    '1f' => ['baslik' => 'SCIE, SSCI, AHCI, ESCI ya da SCOPUS kapsamındaki dergide yayımlanmış editöre mektup, araştırma notu, teknik not, vaka takdimi, özet ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => [...$SCI, 'AHCI', 'ESCI / Scopus'], 'turler' => $KISA, 'puan' => 5],
    '1g' => ['baslik' => 'Diğer ulusal ya da uluslararası hakemli dergide yayımlanmış editöre mektup, araştırma notu, teknik not, vaka takdimi, özet ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 3],

    // ══ 2. BİLİMSEL TOPLANTI ══
    '2a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan, tam metni ya da özeti CPCI\'da yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 6],
    '2b-tam' => ['baslik' => 'Diğer uluslararası bilimsel toplantıda sunulan, tam metin olarak yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Davetli Konuşmacı (Uluslararası)'], 'puan' => 4],
    '2b-ozet' => ['baslik' => 'Diğer uluslararası bilimsel toplantıda özet metin ya da poster olarak yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 3],
    '2c-tam' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan, tam metin olarak yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 3],
    '2c-ozet' => ['baslik' => 'Ulusal bilimsel toplantıda özet metin ya da poster olarak yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 2],

    // ══ 3. KİTAP ══ (3c ve 3d sözlükte 3e / 3f ile aynı etikete düşüyor)
    '3a' => ['baslik' => 'BKCI kapsamındaki kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 30],
    '3b' => ['baslik' => 'BKCI kapsamındaki kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 15],
    '3e' => ['baslik' => 'Ulusal ya da uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 10],
    '3f' => ['baslik' => 'Ulusal ya da uluslararası yayınevi tarafından yayımlanmış kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 5],
    '3g' => ['baslik' => 'Tahkik (tenkitli metin neşri) türünde uluslararası ya da ulusal kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Tahkik (Tenkitli Metin)'], 'puan' => 10],

    // ══ 4. ATIF ══ (4b sözlükte 4c ile aynı etikete düşüyor)
    '4a' => ['baslik' => 'BKCI kapsamındaki kitapta yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 4],
    // Sözlük 16.09.2026'da atıfta ESCI'yi çekirdek indeksten ayırdı.
    '4b' => ['baslik' => 'SCIE, SSCI veya AHCI kapsamında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 4],
    '4c' => ['baslik' => 'ESCI, SCOPUS veya SPORTDiscus kapsamında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 3],
    '4d' => ['baslik' => 'TR Dizin kapsamındaki dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
    '4e' => ['baslik' => 'Diğer uluslararası ya da ulusal kitap veya dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],

    // ══ 5. BİLİMSEL ARAŞTIRMA PROJESİ ══ (rol bölünmesi: 1/1, 1/3, 1/4)
    '5a' => ['baslik' => 'Başarı ile tamamlanmış AB Çerçeve Programı destekli bilimsel araştırma projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 40],
    '5a-ar' => ['baslik' => 'Başarı ile tamamlanmış AB Çerçeve Programı destekli bilimsel araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 13],
    '5a-dan' => ['baslik' => 'Başarı ile tamamlanmış AB Çerçeve Programı destekli bilimsel araştırma projesinde danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['danisman'], 'puan' => 10],
    '5d' => ['baslik' => 'Başarı ile tamamlanmış diğer uluslararası destekli bilimsel araştırma projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 10],
    '5d-ar' => ['baslik' => 'Başarı ile tamamlanmış diğer uluslararası destekli bilimsel araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 3],
    '5d-dan' => ['baslik' => 'Başarı ile tamamlanmış diğer uluslararası destekli bilimsel araştırma projesinde danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['danisman'], 'puan' => 2],
    '5e' => ['baslik' => 'Kamu kurumu ya da özel kuruluşla yapılan, başarı ile tamamlanmış araştırma projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 10],
    '5e-ar' => ['baslik' => 'Kamu kurumu ya da özel kuruluşla yapılan, başarı ile tamamlanmış araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 3],
    '5e-dan' => ['baslik' => 'Kamu kurumu ya da özel kuruluşla yapılan, başarı ile tamamlanmış araştırma projesinde danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['danisman'], 'puan' => 2],
    '5g' => ['baslik' => 'Üniversitenin BAP birimince desteklenen, başarı ile tamamlanmış projede yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 5],

    // ══ 6. PATENT / FAYDALI MODEL / ÇEŞİT ══
    '6a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 50],
    '6b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 30],
    '6c' => ['baslik' => 'Tescil edilmiş faydalı model ya da çeşit', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 15],

    // ══ 7. EDİTÖRLÜK ══ (bu maddeden en fazla 20 puan)
    '7a' => ['baslik' => 'SCIE, SSCI ya da AHCI kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => $WOS_DERGI, 'puan' => 20],
    '7b' => ['baslik' => 'ESCI ya da SCOPUS kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 15],
    '7c' => ['baslik' => 'BKCI ya da SCOPUS kapsamındaki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 10],
    '7d' => ['baslik' => 'TR Dizin kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 10],
    '7f' => ['baslik' => 'Ulusal ya da uluslararası yayınevi tarafından yayımlanmış kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 3],

    // ══ 8. ÖDÜL ══
    '8ab' => ['baslik' => 'YÖK Yılın Doktora Tezi Ödülü ya da YÖK Üstün Başarı Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü'], 'puan' => 40],
    '8cdf' => ['baslik' => 'TÜBİTAK Bilim Ödülü, TÜBİTAK Teşvik Ödülü ya da TÜBA TESEP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü'], 'puan' => 15],
    '8e' => ['baslik' => 'TÜBA GEBİP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 20],

    // ══ 9. EĞİTİM-ÖĞRETİM ══ (bu bölümden en fazla 30 puan)
    '9a' => ['baslik' => 'Lisansüstü ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
    '9b' => ['baslik' => 'Lisans ya da ön lisans dersi vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 2],

    // ══ 10. LİSANSÜSTÜ TEZ DANIŞMANLIĞI ══ (eş danışmanlıkta yarısı)
    '10a' => ['baslik' => 'Yönetiminizde tamamlanan doktora ya da uzmanlık tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 6],
    '10a-es' => ['baslik' => 'Eş danışmanlığınızda tamamlanan doktora ya da uzmanlık tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 3],
    '10b' => ['baslik' => 'Yönetiminizde tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 3],
    '10b-es' => ['baslik' => 'Eş danışmanlığınızda tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 1],

    // ══ 12. İDARİ GÖREVLER ══ (en az bir yıl; en fazla üç yıl için puan)
    '12a' => ['baslik' => 'Dekanlık, enstitü, yüksekokul ya da meslek yüksekokulu müdürlüğü, üniversite yönetim kurulu üyeliği, senato üyeliği, dekan yardımcılığı ya da müdür yardımcılığı yapmış olmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü', 'Dekan Yrd. / Müdür Yrd.'], 'puan' => 10],
    '12b' => ['baslik' => 'Araştırma merkezi müdürlüğü, koordinatörlük, bölüm başkanlığı, bölüm başkan yardımcılığı ya da anabilim dalı başkanlığı yapmış olmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü', 'Bölüm Başkanı', 'Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 5],

    // ══ 13. DİĞER FAALİYETLER ══
    '13b' => ['baslik' => 'Uluslararası ya da ulusal bir etkinlikte icra edilmiş veya edisyonlar tarafından yayımlanmış özgün eser bestelemiş olmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $BESTE, 'puan' => 20],
    '13c' => ['baslik' => 'Orkestra eşliğinde solist olarak konser vermek, orkestra yönetmek, operada solist olarak yer almak, bireysel dinleti ya da soliste piyano eşliği yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $KONSER, 'puan' => 10],
    '13d' => ['baslik' => 'Mimarlık, planlama, kentsel tasarım, peyzaj, iç mimari ya da endüstri ürünleri tasarımı yarışmasında ödül veya mansiyon almak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 10],
    '13h' => ['baslik' => 'Ulusal ya da uluslararası film festivalinde jüri üyeliği, yürütücülük, koordinatörlük veya danışmanlık yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $JURI, 'puan' => 5],
    '13i' => ['baslik' => 'Ulusal televizyon, sinema ya da dijital platformda yayınlanmış dizi, belgesel, müzik klibi veya reklam filmi içeriklerinde bilim alanınızla ilgili görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $EKRAN, 'puan' => 5],
    '13j' => ['baslik' => 'Ulusal ya da uluslararası kongre, sempozyum, panel veya çalıştay düzenlenmesinde başkanlık ya da düzenleme kurulu üyeliği yapmak', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 5],
    '13k-m' => ['baslik' => 'Başarı ile tamamlanmış bilim ve toplum projesinde ya da en az iki ay süreli toplumsal destek projesinde görev almak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın', 'Kamu/STK Danışmanlığı'], 'puan' => 3],
    '13l' => ['baslik' => 'TÜBİTAK 2209-A, 2209-B ya da TEKNOFEST destekli öğrenci projesinde danışman olarak görev yapmak', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'puan' => 3],
    '13j-kurul' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı ya da kurul üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)', 'Toplantı Düzenleme Başkanlığı (Ulusal)', 'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 5],
];

$gruplar = [
    // 1. maddenin bentleri — koşulların en çok kullandığı kümeler.
    'MAKALE-A' => ['1a-Q1', '1a-Q2', '1a-Q3', '1a-Q4'],
    'MAKALE-A-Q12' => ['1a-Q1', '1a-Q2'],
    'MAKALE-A-Q123' => ['1a-Q1', '1a-Q2', '1a-Q3'],
    'MAKALE-AB' => ['1a-Q1', '1a-Q2', '1a-Q3', '1a-Q4', '1b'],
    'MAKALE-ABC' => ['1a-Q1', '1a-Q2', '1a-Q3', '1a-Q4', '1b', '1c'],
    'MAKALE-ABCD' => ['1a-Q1', '1a-Q2', '1a-Q3', '1a-Q4', '1b', '1c', '1d'],
    // 2. madde.
    'BILDIRI' => ['2a', '2b-tam', '2b-ozet', '2c-tam', '2c-ozet'],
    'BILDIRI-AB' => ['2a', '2b-tam', '2b-ozet'],
    // 3. madde — 3c ve 3d girilmediği için kümelerde yok.
    'KITAP' => ['3a', '3b', '3e', '3f', '3g'],
    'KITAP-ACE' => ['3a', '3e'],
    'KITAP-AF' => ['3a', '3b', '3e', '3f'],
    // 4. madde — 4b girilmediği için kümelerde yok.
    'ATIF' => ['4a', '4c', '4d', '4e'],
    'ATIF-ABC' => ['4a', '4c'],
    'ATIF-ABCD' => ['4a', '4c', '4d'],
    // 5, 9, 10. maddeler.
    'PROJE' => ['5a', '5a-ar', '5a-dan', '5d', '5d-ar', '5d-dan', '5e', '5e-ar', '5e-dan', '5g'],
    'EGITIM' => ['9a', '9b'],
    'TEZ' => ['10a', '10a-es', '10b', '10b-es'],
    // Tavan grupları.
    'EDITORLUK' => ['7a', '7b', '7c', '7d', '7f'],
    'IDARI' => ['12a', '12b'],
];

// EK-1'in 1. ve 7. madde dipnotları: "Tek yazarlı makalelerde yazar tam
// puan alır. İki yazarlı makalelerde başlıca yazar tam puanın 0,8 katını,
// ikinci yazar 0,5 katını alır. Üç ve daha fazla yazarlı makalelerde;
// başlıca yazar puanın yarısını alır, diğer yazarlar ise diğer yarısını
// eşit paylaşır."
$yazarKatsayisi = [
    'haric' => ['atif', 'proje', 'patent', 'tez_danismanligi', 'egitim_ogretim',
        'odul', 'idari_gorev', 'toplumsal_katki', 'diger', 'sanatsal_etkinlik'],
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.00]],
        'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.80], 'sonrasi' => 0.50],
        'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.80], 'sonrasi' => 0.50],
        'yazar_2' => ['kademeler' => [2 => 0.50], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
        'yazar_3' => ['bol' => ['pay' => 0.5, 'eksi' => 1]],
        'yazar_4' => ['bol' => ['pay' => 0.5, 'eksi' => 1]],
        'yazar_5' => ['bol' => ['pay' => 0.5, 'eksi' => 1]],
        'yazar_6' => ['bol' => ['pay' => 0.5, 'eksi' => 1]],
        'ortak' => ['bol' => ['pay' => 0.5, 'eksi' => 1]],
    ],
];

$kapsamNotu = 'Puanlar Recep Tayyip Erdoğan Üniversitesi Öğretim Üyeliğine Yükseltilme ve Atanma '
    .'Yönergesinin EK-1 Değerlendirme Ölçütlerinden (31 Temmuz 2024 Senato Yönergesi, 1/5/2025 '
    .'yürürlük). Yazar çarpanı 1. madde dipnotundan: tek yazarlıda tam puan; iki yazarlıda '
    .'başlıca yazar %80, ikinci yazar %50; üç ve daha fazla yazarlıda başlıca yazar puanın '
    .'yarısını alır, diğerleri kalan yarıyı eşit paylaşır. Yazar listesini boş bırakırsanız '
    .'çarpan hiç uygulanmaz ve puanınız olduğundan YÜKSEK görünür. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünür: Q4 dergilerde yayımlanan makaleler tam '
    .'puanla sayılıyor, oysa yönerge editöryal veya basım sürecinde ücret talep eden Q4 '
    .'dergileri (branş derneği, üniversite ya da bilimsel kurum yayını olanlar hariç) '
    .'saymıyor; YÖK\'ün yağmacı veya şaibeli dergi listesi ile DOI zorunluluğu da '
    .'uygulanmıyor. Bildiri, kitap ve patentte yönerge puanı yazar sayısına EŞİT böler, motor '
    .'ise makale çarpanını uygular; başlıca yazar olduğunuz üç ve daha fazla yazarlı '
    .'bildiri, kitap ve patentlerde puanınız birkaç puan fazla, ortak yazar olduklarınızda ise '
    .'eksik görünür. Başlıca yazar puanı yalnız araştırma makalelerinde geçerli olduğu hâlde '
    .'motor derlemelerde de uyguluyor. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: uluslararası yayınevi kitabı (15) ve '
    .'kitap bölümü (8) ulusal karşılıklarının puanıyla (10 ve 5), SCIE/SSCI/AHCI atfı (4) '
    .'ESCI/SCOPUS atfının puanıyla (3), TÜBİTAK ve TÜSEB projeleri yönergenin (e) bendi '
    .'puanıyla (yürütücü 10) sayılıyor — kaynak sözlüğü bu ayrımları taşımıyor. Rolü '
    .'girilmemiş projeler 0 puan alır. 11. madde (sportif başarı ve temsil), 13.a (kişisel '
    .'sergi), 13.e (h-indeksi), 13.f-g (yurt dışı araştırma) ve 13.n (eğiticilerin eğitimi) '
    .'satırları girilmedi. Rize tarihi ve kültürü konulu kitaplarda ×1,5, çay ihtisas alanı '
    .'proje ve tezlerinde ×1,5, TÜBİTAK destekli tezlerde ×1,5 ve BAP destekli tezlerde ×1,3 '
    .'çarpanları uygulanmıyor. İdari görevler yılda bir kez değil, kayıt başına bir kez '
    .'puanlanıyor.';

// EK-2'nin temel alan cetvellerindeki "en fazla N puan alınabilir" notları.
// Tavan bildirmeyen alanlar (Filoloji, Hukuk) ve doktor öğretim üyeliği
// kadroları tavansız `rte-2025` varyantını kullanır.
$TABAN = ['EDITORLUK' => 20, 'EGITIM' => 30, 'IDARI' => 30];

$tavanMatrisi = [
    'egitim' => ['doc' => ['ATIF' => 70], 'prof' => ['ATIF' => 80]],
    'fen' => ['doc' => ['ATIF' => 100], 'prof' => ['ATIF' => 120]],
    'ilahiyat' => ['doc' => ['ATIF' => 40, 'KITAP' => 30], 'prof' => ['ATIF' => 60, 'KITAP' => 30]],
    'mimarlik' => ['doc' => ['ATIF' => 40], 'prof' => ['ATIF' => 50]],
    'muhendislik' => ['doc' => ['ATIF' => 100], 'prof' => ['ATIF' => 120]],
    'saglik' => ['doc' => ['ATIF' => 100], 'prof' => ['ATIF' => 125]],
    'sosyal' => ['doc' => ['ATIF' => 100], 'prof' => ['ATIF' => 125]],
    'spor' => ['doc' => ['ATIF' => 60], 'prof' => ['ATIF' => 80]],
    'ziraat' => ['doc' => ['ATIF' => 100], 'prof' => ['ATIF' => 120]],
];

$cetveller = [
    'rte-2025' => [
        'kapsam_notu' => $kapsamNotu,
        'yazar_katsayisi' => $yazarKatsayisi,
        'maddeler' => $maddeler,
        'gruplar' => $gruplar,
        'grup_tavanlari' => $TABAN,
    ],
];

foreach ($tavanMatrisi as $alan => $kadrolar) {
    foreach ($kadrolar as $kadro => $ek) {
        $cetveller["rte-2025-{$alan}-{$kadro}"] = [
            'kapsam_notu' => $kapsamNotu,
            'yazar_katsayisi' => $yazarKatsayisi,
            'maddeler' => $maddeler,
            'gruplar' => $gruplar,
            'grup_tavanlari' => [...$TABAN, ...$ek],
        ];
    }
}

return ['cetveller' => $cetveller];
