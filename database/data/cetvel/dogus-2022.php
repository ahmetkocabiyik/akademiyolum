<?php

/**
 * DOĞUŞ ÜNİVERSİTESİ — Ek-1 Puanlama Sistemi
 * Kaynak: pdf/17537098002.dogusuniversitesi.pdf (Senato ve Mütevelli
 * Heyet kararı 19.12.2022)
 *
 * Madde kodları Ek-1'in kendi harf kodları (A-1, C, S …); satır içindeki
 * kalemler için açılan alt kodlar ile ".k" (kısa yazı) eki bize ait.
 *
 * ── KISA YAYINLARA %60 ORANI SATIRA GÖMÜLDÜ ──
 * Açıklamalar bölümü "kısa bildiri, teknik not, tartışma ve editöre
 * mektup gibi ön duyuru niteliğindeki yayınlar ilgili bölümler için
 * verilmiş puanların %60'ı ile değerlendirilir" diyor. Kayıt yayın türünü
 * taşıdığı için oran satıra gömüldü: A-1 için 9, A-2 için 5 (9 × 0,6 =
 * 5,4 → 5) puan.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   Hakemlikte uluslararası (3) ile ulusal (1) → 1; yayın kurulu
 *       üyeliğinde uluslararası (20) ile ulusal (5) → 5.
 *   Ödülde uluslararası bilim ve sanat ödülü (40) ile TÜBİTAK-TÜBA bilim
 *       ödülü (40) ayrı etiketlerde; yarışma derecesi (10/5) ile mansiyon
 *       (4/2) tek 'Yarışma Derecesi / Mansiyon' etiketine düşüyor → 2.
 *       Yarışma jüri üyeliğinde uluslararası (4) ile ulusal (2) → 2.
 *   Bilimsel toplantı düzenlemenin altı kademesi (20'den 2'ye) tek
 *       'Diğer' etiketine düşüyor → 2.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   A-3 (yukarıdaki kategorilere girmeyen uluslararası hakemli dergiler,
 *       6 puan) — indekssiz uluslararası derginin sözlükte karşılığı yok;
 *       'Diğer Uluslararası İndeks' etiketi A-2'ye bağlı.
 *   A-4 ve D'nin kitap eleştirisi ile yargısal karar tahlili satırları —
 *       sözlükte karşılıksız.
 *   U (eğitime katkı, ders KREDİSİ başına 0,5 puan) — faaliyet kaydı ders
 *       kredisini taşımıyor; ders kayıtlarınız toplam puana katkı vermiyor.
 *   V bölümünün gazete yayın yönetmenliği, televizyon ve radyo programı
 *       satırları — sözlükte karşılıksız; sinema, sergi ve sanat
 *       etkinliği satırları girildi.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   O maddesinin "en fazla 5 tez" sınırı grup tavanıyla karşılandı
 *       (doktorada 30, yüksek lisansta 15 puan).
 *   V bölümünün "çalışmanın özgünlüğüne bağlı olarak daha az puanla da
 *       değerlendirilebilir" takdir yetkisi.
 *
 * Yönerge: yonerge/dogus.php
 *
 * TANINMIŞ YAYINEVİ AYRIMI KAPSAM ETİKETİNE BAĞLANDI (19.09.2026): kaynak
 * kitabı ve bölümü "ULUSLARARASI SAYGINLIĞI OLAN yayınevi" ↔ "ULUSAL yayınevi" diye ayırıyor; sıfat iki kademede de aynı, ayrımı yapan tek şey
 * yayınevinin kapsamı. Kapsamlı etiketler üst satırlara bağlandı, ulusal
 * satırlar daraltıldı.
 */
$TAM = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];
$WOS = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];
$INDEKS = ['ESCI / Scopus', 'Diğer Uluslararası İndeks'];
$A_PROJE = ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'];
$B_PROJE = ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'];
$C_PROJE = ['BAP (Üniversite)', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'];

$maddeler = [
    // ══ A. ULUSLARARASI MAKALELER ══
    'A-1' => ['baslik' => 'SCI-Expanded, SSCI ya da AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $TAM, 'puan' => 15],
    'A-1.k' => ['baslik' => 'SCI-Expanded, SSCI ya da AHCI kapsamındaki dergide yayımlanmış kısa bildiri, teknik not, tartışma veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $KISA, 'puan' => 9],
    'A-2' => ['baslik' => 'SCOPUS, ESCI ya da ÜAK\'ın belirlediği diğer uluslararası alan indeksli dergilerde yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => $INDEKS, 'turler' => $TAM, 'puan' => 9],
    'A-2.k' => ['baslik' => 'SCOPUS, ESCI ya da diğer uluslararası alan indeksli dergilerde yayımlanmış kısa bildiri, teknik not, tartışma veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => $INDEKS, 'turler' => $KISA, 'puan' => 5],

    // ══ B. ULUSLARARASI BİLDİRİLER ══
    'B-1' => ['baslik' => 'Hakemli uluslararası bilimsel toplantıda sunulan ve bildiriler kitabında yayımlanan tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 5],
    'B-2' => ['baslik' => 'Hakemli uluslararası bilimsel toplantıda sunulan özet ya da poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 2],
    'B-4' => ['baslik' => 'Uluslararası bilimsel toplantıda keynote speaker ya da davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı (Uluslararası)'], 'puan' => 2],

    // ══ C. ULUSLARARASI KİTAP ══
    'C-1' => ['baslik' => 'Uluslararası saygınlığı olan yayınevince basılmış kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası Kitap'], 'puan' => 30],
    'C-2' => ['baslik' => 'Uluslararası saygınlığı olan yayınevince basılmış kitapta bölüm ya da ansiklopedi maddesi yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Uluslararası Kitap Bölümü'], 'puan' => 10],
    'C-3' => ['baslik' => 'Uluslararası saygınlığı olan yayınevince basılmış kitabın editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Uluslararası Kitap Editörlüğü'], 'puan' => 10],

    // ══ D. ULUSAL ARAŞTIRMA YAYINLARI ══
    'D-1' => ['baslik' => 'Ulusal hakemli dergide yayımlanmış araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'puan' => 5],

    // ══ E. ULUSAL BİLDİRİLER ══
    'E-1' => ['baslik' => 'Hakemli ulusal bilimsel toplantıda sunulan ve bildiriler kitabında yayımlanan tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 3],
    'E-2' => ['baslik' => 'Hakemli ulusal bilimsel toplantıda sunulan özet ya da poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 1],

    // ══ F. ULUSAL KİTAP ══
    'F-1' => ['baslik' => 'Ulusal yayınevince basılmış kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 10],
    'F-2' => ['baslik' => 'Ulusal yayınevince basılmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 3],
    'F-3' => ['baslik' => 'Ulusal yayınevince basılmış kitabın editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü', 'Ulusal Kitap Editörlüğü'], 'puan' => 5],
    'F-4' => ['baslik' => 'Çeviri kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap', 'Çeviri Kitap Bölümü'], 'puan' => 5],

    // ══ G. BASILMIŞ BİLİMSEL RAPOR ══
    'G' => ['baslik' => 'Uluslararası ya da ulusal kuruluşlarca desteklenen araştırmaların sonuçlarını yansıtan basılmış bilimsel rapor', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı', 'Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 5],

    // ══ H. ATIFLAR ══
    'H-1' => ['baslik' => 'Uluslararası yayınlarda eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 3],
    'H-2' => ['baslik' => 'Ulusal yayınlarda eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 1],

    // ══ I-N. HAKEMLİK, YAYIN KURULU VE EDİTÖRLÜK ══
    'J' => ['baslik' => 'Uluslararası konferans ya da dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 1],
    'L' => ['baslik' => 'Hakemli dergilerin yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 5],
    'M' => ['baslik' => 'Uluslararası hakemli dergi editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 50],
    'N' => ['baslik' => 'Ulusal hakemli dergi editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 20],

    // ══ O. TEZ YÖNETİMİ ══
    'O-1' => ['baslik' => 'Tamamlanmış doktora tezi danışmanlığı ya da eş danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 6],
    'O-2' => ['baslik' => 'Tamamlanmış yüksek lisans tezi danışmanlığı ya da eş danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'puan' => 3],

    // ══ P. PATENTLER ══
    'P-1' => ['baslik' => 'Yurt dışı patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 50],
    'P-2' => ['baslik' => 'Yurt içi patent, faydalı model ya da tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili', 'Yazılım', 'Ticarileştirme'], 'puan' => 25],

    // ══ R. ÖDÜLLER ══
    'R-1' => ['baslik' => 'Sürekli ve periyodik olarak verilen jürili uluslararası bilim ya da sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 40],
    'R-2' => ['baslik' => 'Sürekli ve periyodik olarak verilen jürili ulusal bilim ya da sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 10],
    'R-3' => ['baslik' => 'TÜBİTAK ya da TÜBA bilim ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'YÖK Ödülü'], 'puan' => 40],
    'R-4' => ['baslik' => 'TÜBİTAK ya da TÜBA teşvik ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 25],
    'R-5' => ['baslik' => 'Burs ya da fellowship (post-doc, visiting scholarship, Fulbright, grant vb.)', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 20],
    'R-6' => ['baslik' => 'Ulusal ya da uluslararası yarışmada derece veya mansiyon', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 2],
    'R-7' => ['baslik' => 'Yarışma jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 2],

    // ══ S. ARAŞTIRMA PROJELERİ ══
    'S-1' => ['baslik' => 'A türü projede (NATO, COST, EUREKA, UN, NSF, AB Komisyonu vb.) yürütücülük', 'kategori' => 'proje', 'kaynaklar' => $A_PROJE, 'roller' => ['yurutucu'], 'puan' => 30],
    'S-2' => ['baslik' => 'A türü projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => $A_PROJE, 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 20],
    'S-3' => ['baslik' => 'A türü projede danışmanlık', 'kategori' => 'proje', 'kaynaklar' => $A_PROJE, 'roller' => ['danisman'], 'puan' => 10],
    'S-4' => ['baslik' => 'B türü projede (TÜBİTAK, TTGV, DPT, Araştırma Fonu vb.) yürütücülük', 'kategori' => 'proje', 'kaynaklar' => $B_PROJE, 'roller' => ['yurutucu'], 'puan' => 15],
    'S-5' => ['baslik' => 'B türü projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => $B_PROJE, 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 10],
    'S-6' => ['baslik' => 'B türü projede danışmanlık', 'kategori' => 'proje', 'kaynaklar' => $B_PROJE, 'roller' => ['danisman'], 'puan' => 5],
    'S-7' => ['baslik' => 'C türü (diğer yurt içi) projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => $C_PROJE, 'roller' => ['yurutucu'], 'puan' => 6],
    'S-8' => ['baslik' => 'C türü (diğer yurt içi) projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => $C_PROJE, 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 4],
    'S-9' => ['baslik' => 'C türü (diğer yurt içi) projede danışmanlık', 'kategori' => 'proje', 'kaynaklar' => $C_PROJE, 'roller' => ['danisman'], 'puan' => 2],

    // ══ T. BİLİMSEL VE SANATSAL TOPLANTI DÜZENLEME ══
    'T' => ['baslik' => 'Bilimsel ya da sanatsal toplantı düzenleme kurulunda veya seçici/bilim kurulunda görev almak', 'kategori' => 'diger', 'kaynaklar' => ['Diğer', 'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 2],

    // ══ V. SANAT İLE İLGİLİ BİLİM DALLARI ETKİNLİKLERİ ══
    'V-1' => ['baslik' => 'Özgün sanat ve tasarım çalışmalarının uluslararası müzelerde ya da eşdeğer kurumlarda yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Haber Olması (Uluslararası)'], 'puan' => 20],
    'V-2' => ['baslik' => 'Özgün sanat ve tasarım çalışmalarının ulusal müzelerde ya da eşdeğer kurumlarda yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Haber Olması (Ulusal)'], 'puan' => 10],
    'V-3' => ['baslik' => 'Uluslararası seçici kurulu olan etkinliklere yapıtlarının kabul edilmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)'], 'puan' => 10],
    'V-4' => ['baslik' => 'Ulusal seçici kurulu olan etkinliklere yapıtlarının kabul edilmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)'], 'puan' => 5],
    'V-5' => ['baslik' => 'Özgün bireysel sanat ya da tasarım etkinliği (kişisel sergi, uygulanmış tasarım, gösteri, performans, belgesel, sinema)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Elektronik Kişisel Sergi (Ulusal)', 'Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman', 'Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)', 'Resital (Uluslararası)', 'Resital (Ulusal)', 'Solistlik (Uluslararası)', 'Solistlik (Ulusal)', 'Şan Resitali (Uluslararası)', 'Şan Resitali (Ulusal)', 'Oratoryo/Kantat Solistliği (Uluslararası)', 'Oratoryo/Kantat Solistliği (Ulusal)', 'Orkestra Şefliği (Uluslararası)', 'Orkestra Şefliği (Ulusal)', 'Opera Şefliği (Uluslararası)', 'Opera Şefliği (Ulusal)', 'Koro Şefliği (Uluslararası)', 'Koro Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Ulusal)', 'Opera Birinci Rol (Uluslararası)', 'Opera Birinci Rol (Ulusal)', 'Bale Başrol (Uluslararası)', 'Bale Başrol (Ulusal)', 'Özgün Eser / Beste / Tasarım', 'Opera/Bale Kompozisyonu', 'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Orkestralı Sahne Eseri', 'Küçük Ölçekli Orkestra Eseri', 'Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Sahne/Ekran Müziği', 'Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi', 'Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)', 'Karma Albüm / CD-DVD Katkısı', 'Eğitim Müziği Albümü', 'Sahne Tasarımı (Dekor, Kostüm, Işık)', 'Koreografi'], 'puan' => 10],
    'V-6' => ['baslik' => 'Karma sergi ve gösterilere katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Uluslararası)', 'Elektronik Karma Sergi (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Oda Müziği Grup Üyeliği (Uluslararası)', 'Oda Müziği Grup Üyeliği (Ulusal)', 'Orkestra / Koro Üyeliği', 'Grup Şefliği (Uluslararası)', 'Grup Şefliği (Ulusal)', 'Başkemancılık (Uluslararası)', 'Başkemancılık (Ulusal)', 'Corps de Ballet (Uluslararası)', 'Corps de Ballet (Ulusal)', 'Opera İkinci Rol (Uluslararası)', 'Opera İkinci Rol (Ulusal)', 'Bale Solist Rol (Uluslararası)', 'Bale Solist Rol (Ulusal)', 'Dansçı / Performans İcracısı (Uluslararası)', 'Dansçı / Performans İcracısı (Ulusal)', 'Masterclass (Uluslararası)', 'Masterclass (Ulusal)', 'Eğitici Konser Programı (Uluslararası)', 'Eğitici Konser Programı (Ulusal)', 'Müzikoloji Atölyesi', 'Eğitim Amaçlı Sanat Etkinliği'], 'puan' => 2],
    'V-7' => ['baslik' => 'Sinema filmi yönetmenliği ya da sinema filminde görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Yönetmenlik (Sahne/Ekran)', 'Rejisörlük (Uluslararası)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Rejisör Yardımcılığı (Uluslararası)', 'Rejisör Yardımcılığı (Ulusal)', 'Rejisör Yardımcılığı (Konservatuvar)', 'Tüm Perde Koreograflığı (Uluslararası)', 'Tüm Perde Koreograflığı (Ulusal)', 'Bölüm Koreograflığı (Uluslararası)', 'Bölüm Koreograflığı (Ulusal)', 'Bale/Dans Koreograflığı (Uluslararası)', 'Bale/Dans Koreograflığı (Ulusal)', 'Sahneleme/Repetitörlük — Tüm Perde (Uluslararası)', 'Sahneleme/Repetitörlük — Tüm Perde (Ulusal)', 'Sahneleme/Repetitörlük — Bölüm (Uluslararası)', 'Sahneleme/Repetitörlük — Bölüm (Ulusal)'], 'puan' => 5],
];

$kodlar = fn (string $onek): array => array_values(array_filter(
    array_keys($maddeler),
    fn (string $kod): bool => str_starts_with($kod, $onek)
));

$A = $kodlar('A-');
$B = $kodlar('B-');
$C = $kodlar('C-');
$D = $kodlar('D-');
$E = $kodlar('E-');
$F = $kodlar('F-');
$S = $kodlar('S-');
$V = $kodlar('V-');

return [
    'kapsam_notu' => 'Puanlar Doğuş Üniversitesi Akademik Yükseltme ve Atama Yönergesinin Ek-1 '
        .'puanlama sisteminden (19.12.2022). Ortak çalışmalarda A-H maddelerinde yazar sayısı '
        .'ikiyi aşarsa puan 2 ile çarpılıp yazar sayısına bölünüyor; beş ve daha fazla yazarlı '
        .'yayınlara dört yazarlı puanlaması uygulanıyor. Yani üç yazarlıda puanın üçte ikisini, '
        .'dört ve daha fazla yazarlıda yarısını alıyorsunuz. Yazar listesini boş bırakırsanız '
        .'bölme uygulanmaz ve puanınız olduğundan yüksek görünür. Atıflardan en fazla 50, '
        .'doktora tez danışmanlığından 30, yüksek lisanstan 15 puan alınabiliyor. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: U maddesi (eğitime katkı) ders '
        .'KREDİSİ başına puanlandığı ve kayıt krediyi taşımadığı için girilemedi, ders '
        .'kayıtlarınız toplam puana katkı vermiyor; A-3 (indekssiz uluslararası hakemli '
        .'dergiler), kitap eleştirisi ve yargısal karar tahlili satırları sözlükte karşılıksız; '
        .'hakemlik, yayın kurulu üyeliği, yarışma derecesi ve toplantı düzenleme kalemlerinin '
        .'yüksek kademeleri düşük kademelerinden ayrılamadığı için en düşük değerden sayılıyor.'
        .' KİTAPTA "TANINMIŞ YAYINEVİ" KOŞULU DENETLENMİYOR: uluslararası yayınevi kitabınız yönergenin tanınmış uluslararası yayınevi satırından sayılıyor. Yayıneviniz yönergenin tanımına (faaliyet süresi, kütüphane kataloglaması, kitap sayısı) girmiyorsa puanınız olduğundan YÜKSEK görünür; başvurunuzda yayınevini belgeleyin.',

    // "A, B, C, D, E, F, G ve H maddelerinde, yazar sayısının 2'yi aştığı
    // durumlarda puan 2 ile çarpılıp yazar sayısına bölünür. 5 ve daha
    // fazla yazarlı yayınlara 4 yazarlı puanlaması uygulanır."
    'yazar_katsayisi' => [
        'haric' => ['proje', 'odul', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev',
            'diger', 'sanatsal_etkinlik', 'patent'],
        'kademeler' => [1 => 1.00, 2 => 1.00, 3 => 0.66, 4 => 0.50],
        'sonrasi' => 0.50,
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        'A' => $A,
        'A-B-C' => [...$A, ...$B, ...$C],
        // MADDE 6/1-a: "A, B, C, D, E, F, S maddelerinde tanımlanmış etkinlikler".
        'ASGARI' => [...$A, ...$B, ...$C, ...$D, ...$E, ...$F, ...$S],
        // MADDE 6/2-b: sanat alanlarında V maddesi de dahil.
        'ASGARI-SANAT' => [...$A, ...$B, ...$C, ...$D, ...$E, ...$F, ...$S, ...$V],
        // MADDE 6/2-c: hukuk alanlarında G, H, J, L, N maddeleri de dahil.
        'ASGARI-HUKUK' => [...$A, ...$B, ...$C, ...$D, ...$E, ...$F, ...$S,
            'G', 'H-1', 'H-2', 'J', 'L', 'N'],
        'V' => $V,
        // MADDE 10/7-3'ün "yurt dışı etkinlik" koşulu: yalnızca uluslararası
        // olduğu satırdan kesin olan kalemler.
        'V-YURTDISI' => ['V-1', 'V-3'],
        // Tavan grupları.
        'ATIF' => $kodlar('H-'),
        'TEZ-DOKTORA' => ['O-1'],
        'TEZ-YL' => ['O-2'],
    ],

    'grup_tavanlari' => [
        'ATIF' => 50,
        'TEZ-DOKTORA' => 30,
        'TEZ-YL' => 15,
    ],
];
