<?php

/**
 * İSTANBUL BEYKENT ÜNİVERSİTESİ — Ek-1 Puanlama Sistemi
 * Kaynak: pdf/17537097252.beykentuniversitesi.pdf (Senato 10.01.2025,
 * YÖK onayı 11.02.2025)
 *
 * Madde kodları Ek-1'in kendi kodları (A-1, C-2, İ-4, L-7 …). Bize ait
 * olanlar: kısa yayınlar için açılan ".k" alt kodları ile projelerde ve
 * tez yönetiminde rol ayrımı için açılan kodlar.
 *
 * ── KISA YAYINLARA %60 ORANI SATIRA GÖMÜLDÜ ──
 * Açıklamalar bölümü "kısa bildiri, teknik not, vaka takdimi, tartışma ve
 * editöre mektup gibi ön duyuru niteliğindeki yayınlar ilgili bölümler
 * için verilmiş puanların %60'ı ile değerlendirilir" diyor. Kayıt yayın
 * türünü taşıdığı için oran satıra gömüldü: A-1 için 9, A-2 için 7
 * (12 × 0,6 = 7,2 → 7), A-3 için 5 (9 × 0,6 = 5,4 → 5) puan.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   Patentte LİSANSLANAN belge ile başvuru ya da belge ayrımı kayıtta
 *       yok: uluslararası patent 50/20 → 20, ulusal patent 25/10 → 10,
 *       faydalı model 20/10 → 10, endüstriyel tasarım 20/10 → 10.
 *   Yayın kurulu üyeliğinin dört kademesi (20/15/10/5) tek 'Yayın Kurulu
 *       Üyeliği' etiketine düşüyor → 5; hakemliğin dört kademesi
 *       (3/2/1/1) → 1.
 *   Uluslararası bildiride özet (5) ile poster (3) → 3; ulusal bildiride
 *       özet (2) ile poster (1) → 1.
 *   Diğer alan indekslerinde editörlük (25) ile ulusal hakemli dergide
 *       editörlük (20) tek etikete düşmediği hâlde 'Diğer Hakemli Dergi'
 *       için düşük olan (20) yazıldı.
 *   Bilimsel ve sanatsal toplantı düzenlemenin altı kademesi (20'den
 *       2'ye) tek 'Diğer' etiketine düşüyor → 2.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   A-4 ve D-3 (kitap eleştirisi), D-4 (yargısal karar tahlili) — sözlükte
 *       karşılıksız.
 *   P-1 (eğitime katkı, kredi başına 0,5 puan) — faaliyet kaydı ders
 *       kredisini taşımıyor; ders kayıtlarınız toplam puana katkı vermiyor.
 *   K bölümünün televizyon, radyo, gazete ve öğrenci uygulama satırlarının
 *       çoğu — sözlükte karşılıksız; sinema ve belgesel satırları girildi.
 *   'Ticarileştirme' etiketi — Ek-1'de karşılığı yok.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   H bölümünün "her bir dergi için en fazla 5 hakemlik" sınırı ve
 *       editörlüklerin "en az bir yıl süreyle yürütülmüş olması" koşulu.
 *   K-10, K-11 ve K-12'nin "en az sekiz bölüm yayınlanmış olma" koşulu.
 *   O bölümünün "en fazla 2 tez" sınırı grup tavanıyla karşılandı.
 *
 * Yönerge: yonerge/beykent.php
 *
 * TANINMIŞ YAYINEVİ AYRIMI KAPSAM ETİKETİNE BAĞLANDI (19.09.2026): kaynak
 * kitabı, bölümü ve editörlüğü "TANINMIŞ ULUSLARARASI yayınevi" ↔ "TANINMIŞ
 * ULUSAL yayınevi" diye ayırıyor; sıfat İKİ KADEMEDE DE aynı, ayrımı yapan tek
 * şey yayınevinin kapsamı. Üst satırlar yalnız BKCI/Scopus etiketiyle
 * yazıldığı için adayın indekssiz uluslararası kitabı ULUSAL satırdan
 * sayılıyordu. Kapsamlı etiketler bağlandı, ulusal satırlar daraltıldı.
 */
$TAM = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];
$WOS = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];
$A_PROJE = ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'];
$B_PROJE = ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'];
$C_PROJE = ['Özel Sektör / STK', 'BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'];

$maddeler = [
    // ══ A: ULUSLARARASI YAYINLAR ══
    'A-1' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $TAM, 'puan' => 15],
    'A-1.k' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergide yayımlanmış kısa bildiri, teknik not, vaka takdimi, tartışma veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $KISA, 'puan' => 9],
    'A-2' => ['baslik' => 'ESCI ya da SCOPUS indeksleri kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $TAM, 'puan' => 12],
    'A-2.k' => ['baslik' => 'ESCI ya da SCOPUS indeksleri kapsamındaki dergide yayımlanmış kısa bildiri, teknik not, vaka takdimi, tartışma veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $KISA, 'puan' => 7],
    'A-3' => ['baslik' => 'Diğer uluslararası hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $TAM, 'puan' => 9],
    'A-3.k' => ['baslik' => 'Diğer uluslararası hakemli dergide yayımlanmış kısa bildiri, teknik not, vaka takdimi, tartışma veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 5],

    // ══ B: ULUSLARARASI BİLDİRİLER ══
    'B-1' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulmuş ve tam metni basılmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 8],
    'B-3' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulmuş özet bildiri ya da poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 3],
    'B-4' => ['baslik' => 'Uluslararası bilimsel toplantıda keynote speaker ya da davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı (Uluslararası)'], 'puan' => 2],

    // ══ C: ULUSLARARASI KİTAP ══
    'C-1' => ['baslik' => 'Tanınmış uluslararası yayınevi tarafından yayımlanan özgün bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası Kitap'], 'puan' => 30],
    'C-2' => ['baslik' => 'Tanınmış uluslararası yayınevi tarafından yayımlanan özgün bilimsel kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Uluslararası Kitap Bölümü'], 'puan' => 10],
    'C-3' => ['baslik' => 'Tanınmış uluslararası yayınevi tarafından yayımlanan özgün bilimsel kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Uluslararası Kitap Editörlüğü'], 'puan' => 10],

    // ══ D: ULUSAL ARAŞTIRMA YAYINLARI ══
    'D-1' => ['baslik' => 'ULAKBİM TR Dizin tarafından taranan ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 8],
    'D-2' => ['baslik' => 'Ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 5],

    // ══ E: ULUSAL BİLDİRİLER ══
    'E-1' => ['baslik' => 'Ulusal bilimsel toplantıda sunulmuş ve tam metni basılmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 3],
    'E-3' => ['baslik' => 'Ulusal bilimsel toplantıda sunulmuş özet bildiri ya da poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 1],

    // ══ F: ULUSAL KİTAP ══
    'F-1' => ['baslik' => 'Tanınmış ulusal yayınevi tarafından yayımlanan özgün bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap', 'Ders / Metot Kitabı', 'Tahkik (Tenkitli Metin)'], 'puan' => 10],
    'F-2' => ['baslik' => 'Tanınmış ulusal yayınevi tarafından yayımlanan özgün bilimsel kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 5],
    'F-3' => ['baslik' => 'Tanınmış ulusal yayınevi tarafından yayımlanan özgün bilimsel kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü', 'Ulusal Kitap Editörlüğü'], 'puan' => 5],
    'F-4' => ['baslik' => 'Bilimsel kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 5],
    'F-5' => ['baslik' => 'Bilimsel kitap içinde bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 3],

    // ══ G: ATIFLAR ══
    'G-1' => ['baslik' => 'SCI, SCI-Expanded, SSCI, AHCI, ESCI ya da SCOPUS kapsamındaki dergilerde ve tanınmış uluslararası yayınevlerinin kitaplarında eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 3],
    'G-2' => ['baslik' => 'Bu indekslerin dışındaki dergilerde ve kitap bölümlerinde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer'], 'puan' => 2],
    'G-3' => ['baslik' => 'Ulusal hakemli dergilerde ve tanınmış yayınevlerinin kitaplarında eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Patent'], 'puan' => 1],

    // ══ H: EDİTÖRLÜK VE HAKEMLİK ══
    'H-1' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergide en az bir yıl süreyle yürütülen editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 50],
    'H-4' => ['baslik' => 'SCOPUS ya da ESCI kapsamındaki dergide en az bir yıl süreyle yürütülen editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 35],
    'H-10' => ['baslik' => 'Ulusal ya da diğer uluslararası hakemli dergide en az bir yıl süreyle yürütülen editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 20],
    'H-11' => ['baslik' => 'Hakemli dergide en az bir yıl süreyle yapılan yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 5],
    'H-12' => ['baslik' => 'Hakemli dergilerde ya da uluslararası konferanslarda hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 1],

    // ══ I: BASILMIŞ BİLİMSEL RAPOR ══
    'I-1' => ['baslik' => 'Uluslararası ya da ulusal kuruluşlarca desteklenen araştırmaların bilimsel sonuçlarını yansıtan basılmış rapor, bilirkişi ya da teknik rapor', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı', 'Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 5],

    // ══ İ: PATENTLER ══
    'İ-1' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
    'İ-3' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 10],
    'İ-5' => ['baslik' => 'Faydalı model belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 10],
    'İ-7' => ['baslik' => 'Endüstriyel tasarım belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili', 'Yazılım'], 'puan' => 10],

    // ══ J: ARAŞTIRMA PROJELERİ ══
    'J-1' => ['baslik' => 'NATO, COST, EUREKA, UN, NSF ya da AB Komisyonu gibi kuruluşlarca desteklenen projede koordinatör veya yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => $A_PROJE, 'roller' => ['yurutucu'], 'puan' => 30],
    'J-2' => ['baslik' => 'NATO, COST, EUREKA, UN, NSF ya da AB Komisyonu gibi kuruluşlarca desteklenen projede araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => $A_PROJE, 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 20],
    'J-3' => ['baslik' => 'NATO, COST, EUREKA, UN, NSF ya da AB Komisyonu gibi kuruluşlarca desteklenen projede danışman olmak', 'kategori' => 'proje', 'kaynaklar' => $A_PROJE, 'roller' => ['danisman'], 'puan' => 10],
    'J-4' => ['baslik' => 'TÜBİTAK, TTGV, DPT ya da araştırma fonu projesinde koordinatör veya yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => $B_PROJE, 'roller' => ['yurutucu'], 'puan' => 15],
    'J-5' => ['baslik' => 'TÜBİTAK, TTGV, DPT ya da araştırma fonu projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => $B_PROJE, 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 10],
    'J-6' => ['baslik' => 'TÜBİTAK, TTGV, DPT ya da araştırma fonu projesinde danışman olmak', 'kategori' => 'proje', 'kaynaklar' => $B_PROJE, 'roller' => ['danisman'], 'puan' => 5],
    'J-7' => ['baslik' => 'Dünya Bankası, sanayi-üniversite iş birliği, özel ve kamu kuruluşları ya da BAP projesinde koordinatör veya yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => $C_PROJE, 'roller' => ['yurutucu'], 'puan' => 6],
    'J-8' => ['baslik' => 'Dünya Bankası, sanayi-üniversite iş birliği, özel ve kamu kuruluşları ya da BAP projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => $C_PROJE, 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 4],
    'J-9' => ['baslik' => 'Dünya Bankası, sanayi-üniversite iş birliği, özel ve kamu kuruluşları ya da BAP projesinde danışman olmak', 'kategori' => 'proje', 'kaynaklar' => $C_PROJE, 'roller' => ['danisman'], 'puan' => 2],

    // ══ K: GÖRSEL ETKİNLİKLER ══
    'K-3' => ['baslik' => 'Uluslararası sinema, belgesel ya da kısa metrajlı kurmaca film yönetmenliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)'], 'puan' => 10],
    'K-7' => ['baslik' => 'Ulusal sinema, belgesel ya da kısa metrajlı kurmaca filmde yönetmenlik veya görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Ulusal)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Yönetmenlik (Sahne/Ekran)', 'Rejisörlük (Uluslararası)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Rejisör Yardımcılığı (Uluslararası)', 'Rejisör Yardımcılığı (Ulusal)', 'Rejisör Yardımcılığı (Konservatuvar)'], 'puan' => 5],

    // ══ L: SANAT VE TASARIMLA İLGİLİ ETKİNLİKLER ══
    'L-1' => ['baslik' => 'Uluslararası özgün sanat ve tasarım çalışmalarının müzelerde ya da eşdeğer kurumlarda yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Haber Olması (Uluslararası)'], 'puan' => 30],
    'L-2' => ['baslik' => 'Ulusal özgün sanat ve tasarım çalışmalarının müzelerde ya da eşdeğer kurumlarda yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Haber Olması (Ulusal)'], 'puan' => 10],
    'L-3' => ['baslik' => 'Uluslararası seçici kurulu olan etkinliklere yapıtlarının kabul edilmiş olması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)'], 'puan' => 10],
    'L-4' => ['baslik' => 'Ulusal seçici kurulu olan etkinliklere yapıtlarının kabul edilmiş olması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)'], 'puan' => 5],
    'L-5' => ['baslik' => 'Uluslararası özgün bireysel sanat ya da tasarım etkinliği (kişisel sergi, uygulanmış tasarım, gösteri, performans)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Uygulama Projesi — Müellif', 'Koruma-Onarım Uygulaması (Uluslararası)', 'Resital (Uluslararası)', 'Solistlik (Uluslararası)', 'Şan Resitali (Uluslararası)', 'Oratoryo/Kantat Solistliği (Uluslararası)', 'Orkestra Şefliği (Uluslararası)', 'Opera Şefliği (Uluslararası)', 'Koro Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Uluslararası)', 'Opera Birinci Rol (Uluslararası)', 'Bale Başrol (Uluslararası)'], 'puan' => 10],
    'L-6' => ['baslik' => 'Ulusal özgün bireysel sanat ya da tasarım etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman', 'Koruma-Onarım Uygulaması (Ulusal)', 'Resital (Ulusal)', 'Solistlik (Ulusal)', 'Şan Resitali (Ulusal)', 'Oratoryo/Kantat Solistliği (Ulusal)', 'Orkestra Şefliği (Ulusal)', 'Opera Şefliği (Ulusal)', 'Koro Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Ulusal)', 'Opera Birinci Rol (Ulusal)', 'Bale Başrol (Ulusal)', 'Özgün Eser / Beste / Tasarım', 'Opera/Bale Kompozisyonu', 'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Orkestralı Sahne Eseri', 'Küçük Ölçekli Orkestra Eseri', 'Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Sahne/Ekran Müziği', 'Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi', 'Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)', 'Karma Albüm / CD-DVD Katkısı', 'Eğitim Müziği Albümü', 'Sahne Tasarımı (Dekor, Kostüm, Işık)', 'Koreografi'], 'puan' => 5],
    'L-7' => ['baslik' => 'Uluslararası sanat ya da tasarım fuarında veya bienalinde karma sergiye katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Karma Sergi (Uluslararası)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Oda Müziği Grup Üyeliği (Uluslararası)', 'Grup Şefliği (Uluslararası)', 'Başkemancılık (Uluslararası)', 'Corps de Ballet (Uluslararası)', 'Opera İkinci Rol (Uluslararası)', 'Bale Solist Rol (Uluslararası)', 'Dansçı / Performans İcracısı (Uluslararası)', 'Masterclass (Uluslararası)', 'Eğitici Konser Programı (Uluslararası)', 'Tüm Perde Koreograflığı (Uluslararası)', 'Bölüm Koreograflığı (Uluslararası)', 'Bale/Dans Koreograflığı (Uluslararası)', 'Sahneleme/Repetitörlük — Tüm Perde (Uluslararası)', 'Sahneleme/Repetitörlük — Bölüm (Uluslararası)'], 'puan' => 5],
    'L-8' => ['baslik' => 'Ulusal sanat ya da tasarım fuarında veya bienalinde karma sergiye katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Oda Müziği Grup Üyeliği (Ulusal)', 'Orkestra / Koro Üyeliği', 'Grup Şefliği (Ulusal)', 'Başkemancılık (Ulusal)', 'Corps de Ballet (Ulusal)', 'Opera İkinci Rol (Ulusal)', 'Bale Solist Rol (Ulusal)', 'Dansçı / Performans İcracısı (Ulusal)', 'Masterclass (Ulusal)', 'Eğitici Konser Programı (Ulusal)', 'Müzikoloji Atölyesi', 'Eğitim Amaçlı Sanat Etkinliği', 'Tüm Perde Koreograflığı (Ulusal)', 'Bölüm Koreograflığı (Ulusal)', 'Bale/Dans Koreograflığı (Ulusal)', 'Sahneleme/Repetitörlük — Tüm Perde (Ulusal)', 'Sahneleme/Repetitörlük — Bölüm (Ulusal)'], 'puan' => 2],
    'L-12' => ['baslik' => 'Ulusal ya da uluslararası sergilerde küratörlük', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Başkanlığı (Ulusal)'], 'puan' => 10],

    // ══ M: ÖDÜLLER ══
    'M-1' => ['baslik' => 'Sürekli ve periyodik olarak verilen jürili uluslararası bilim ya da sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 40],
    'M-2' => ['baslik' => 'Sürekli ve periyodik olarak verilen jürili ulusal bilim ya da sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 10],
    'M-4' => ['baslik' => 'YÖK, TÜBİTAK ya da TÜBA bilim veya teşvik ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 25],
    'M-5' => ['baslik' => 'Burs ya da fellowship (post-doc, visiting scholarship, Fulbright, grant vb.)', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 20],
    'M-10' => ['baslik' => 'Ulusal ya da uluslararası yarışmalarda derece veya mansiyon', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 2],
    'M-11' => ['baslik' => 'Ulusal ya da uluslararası yarışmalarda jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Üyeliği (Uluslararası)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 2],

    // ══ N: BİLİMSEL VE SANATSAL TOPLANTI DÜZENLEME ══
    'N-5' => ['baslik' => 'Ulusal ya da uluslararası bilimsel veya sanatsal toplantılarda yürütücülük, üyelik ya da seçici kurul üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 2],

    // ══ O: TEZ YÖNETİMİ ══
    'O-1' => ['baslik' => 'Tamamlanmış doktora, sanatta yeterlik ya da uzmanlık tezi danışmanlığı veya eş danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 6],
    'O-2' => ['baslik' => 'Tamamlanmış yüksek lisans tezi danışmanlığı veya eş danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'puan' => 3],
    'N-6' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 2],
    'N-3' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 5],
];

return [
    'kapsam_notu' => 'Puanlar İstanbul Beykent Üniversitesi Öğretim Üyeliğine Yükseltme ve Atama '
        .'Yönergesinin Ek-1 puanlama sisteminden (YÖK onayı 11.02.2025). '
        .'Ortak çalışmalarda puan A-F kategorilerinde şöyle bölünüyor: iki yazarlıda birinci '
        .'yazar %60, ikinci yazar %40; üç ve daha fazla yazarlıda birinci yazar %40, kalan %60 '
        .'öbür yazarlar arasında eşit bölüşülüyor. Sorumlu yazar birinci isim değilse toplam '
        .'puanın %10\'u kadar ilave alıyor; motor tek bir çarpan tablosu tanımlayabildiği için '
        .'"başlıca yazar" seçeneğinde birinci yazarlık ile sorumlu yazarlığın DÜŞÜK olanı '
        .'uygulanıyor. Yazar listesini boş bırakırsanız bölme hiç yapılmaz ve puanınız '
        .'olduğundan yüksek görünür. '
        .'Kısa bildiri, teknik not, vaka takdimi ve editöre mektup gibi yayınlara verilen %60 '
        .'oranı satıra gömüldü. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: patentlerde LİSANSLANAN belge ile '
        .'başvuru ya da belge ayrımı kayıtta olmadığı için düşük satırlar uygulanıyor '
        .'(uluslararası patent 50 yerine 20, ulusal 25 yerine 10); yayın kurulu üyeliği, '
        .'hakemlik ve toplantı düzenleme kalemlerinin yüksek kademeleri sözlükte ayrılamadığı '
        .'için en düşük değerden sayılıyor; P-1 (eğitime katkı) ders kredisi kayıtta '
        .'taşınmadığı için hiç girilemedi, ders kayıtlarınız toplam puana katkı vermiyor; '
        .'kitap eleştirisi ve yargısal karar tahlili satırları sözlükte karşılıksız. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünür: "her bir dergi için en fazla beş '
        .'hakemlik" sınırı ve editörlüklerin "en az bir yıl süreyle yürütülmüş olması" koşulu '
        .'uygulanamıyor.',

    // "Puanlamada Yazar Sayısının Etkisi": iki yazarlıda 1. yazar %60,
    // 2. yazar %40; üç ve daha fazla yazarlıda 1. yazar %40, kalan %60
    // öbür yazarlar arasında eşit bölüşülür. Sorumlu yazar birinci isim
    // değilse toplam puanın %10'u ilave verilir; 'baslica' rolünde iki
    // okumadan düşük olanı yazıldı (§0). Kural yalnız A-F kategorileri
    // için geçerli.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'editorluk', 'proje', 'patent', 'sanatsal_etkinlik', 'odul',
            'idari_gorev', 'toplumsal_katki', 'diger', 'egitim_ogretim', 'tez_danismanligi'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.60], 'sonrasi' => 0.40],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.50], 'bol' => ['pay' => 0.6, 'eksi' => 1, 'ek' => 0.10]],
            'yazar_2' => ['kademeler' => [2 => 0.40], 'bol' => ['pay' => 0.6, 'eksi' => 1]],
            'yazar_3' => ['kademeler' => [2 => 0.40], 'bol' => ['pay' => 0.6, 'eksi' => 1]],
            'yazar_4' => ['kademeler' => [2 => 0.40], 'bol' => ['pay' => 0.6, 'eksi' => 1]],
            'yazar_5' => ['kademeler' => [2 => 0.40], 'bol' => ['pay' => 0.6, 'eksi' => 1]],
            'yazar_6' => ['kademeler' => [2 => 0.40], 'bol' => ['pay' => 0.6, 'eksi' => 1]],
            'ortak' => ['kademeler' => [2 => 0.40], 'bol' => ['pay' => 0.6, 'eksi' => 1]],
        ],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        'A' => ['A-1', 'A-1.k', 'A-2', 'A-2.k', 'A-3', 'A-3.k'],
        'A-1' => ['A-1', 'A-1.k'],
        'C' => ['C-1', 'C-2', 'C-3'],
        // MADDE 5/b ve 5/c: "A veya C maddesinde tanımlı uluslararası yayın".
        'A-C' => ['A-1', 'A-1.k', 'A-2', 'A-2.k', 'A-3', 'A-3.k', 'C-1', 'C-2', 'C-3'],
        // MADDE 6/2-b: "toplam 2 adet ULUSLARARASI yayın". Kaynak uluslararası
        // bölümleri (A: uluslararası makale, B: uluslararası bildiri,
        // C: uluslararası kitap) ulusal bölümlerden (D, E, F) ayrı yazıyor ve
        // her ikisini birden kastettiği yerde "uluslararası ya da ulusal"
        // diyor (6/2-c hukuk, 6/2-ç sağlık). Bu koşul öyle demiyor.
        'A-B-C' => ['A-1', 'A-1.k', 'A-2', 'A-2.k', 'A-3', 'A-3.k', 'B-1', 'B-3', 'B-4',
            'C-1', 'C-2', 'C-3'],
        // MADDE 5/ç: "A, B, C, D veya F maddelerinde tanımlı yayın".
        'A-B-C-D-F' => ['A-1', 'A-1.k', 'A-2', 'A-2.k', 'A-3', 'A-3.k', 'B-1', 'B-3', 'B-4',
            'C-1', 'C-2', 'C-3', 'D-1', 'D-2', 'F-1', 'F-2', 'F-3', 'F-4', 'F-5'],
        // MADDE 6/ç: "A, B, C, D, E veya F maddelerinde tanımlı yayın".
        'A-B-C-D-E-F' => ['A-1', 'A-1.k', 'A-2', 'A-2.k', 'A-3', 'A-3.k', 'B-1', 'B-3', 'B-4',
            'C-1', 'C-2', 'C-3', 'D-1', 'D-2', 'E-1', 'E-3', 'F-1', 'F-2', 'F-3', 'F-4', 'F-5'],
        'L' => ['L-1', 'L-2', 'L-3', 'L-4', 'L-5', 'L-6', 'L-7', 'L-8', 'L-12'],
        // Tavan grupları.
        'A-4-TAVAN' => ['B-4'],
        'G-1-TAVAN' => ['G-1'],
        'G-2-TAVAN' => ['G-2'],
        'G-3-TAVAN' => ['G-3'],
        'H-HAKEMLIK' => ['H-12'],
        'I-TAVAN' => ['I-1'],
        'J-A-YURUTUCU' => ['J-1'],
        'J-A-ARASTIRMACI' => ['J-2'],
        'J-A-DANISMAN' => ['J-3'],
        'J-B-YURUTUCU' => ['J-4'],
        'J-B-ARASTIRMACI' => ['J-5'],
        'J-B-DANISMAN' => ['J-6'],
        'J-C-YURUTUCU' => ['J-7'],
        'J-C-ARASTIRMACI' => ['J-8'],
        'J-C-DANISMAN' => ['J-9'],
        'O-1-TAVAN' => ['O-1'],
        'O-2-TAVAN' => ['O-2'],
    ],

    // Ek-1'in satır başına yazdığı azami puanlar.
    'grup_tavanlari' => [
        'A-4-TAVAN' => 6,
        'G-1-TAVAN' => 30,
        'G-2-TAVAN' => 10,
        'G-3-TAVAN' => 10,
        'H-HAKEMLIK' => 5,
        'I-TAVAN' => 10,
        'J-A-YURUTUCU' => 60,
        'J-A-ARASTIRMACI' => 40,
        'J-A-DANISMAN' => 20,
        'J-B-YURUTUCU' => 30,
        'J-B-ARASTIRMACI' => 20,
        'J-B-DANISMAN' => 10,
        'J-C-YURUTUCU' => 12,
        'J-C-ARASTIRMACI' => 8,
        'J-C-DANISMAN' => 4,
        'O-1-TAVAN' => 12,
        'O-2-TAVAN' => 6,
    ],
];
