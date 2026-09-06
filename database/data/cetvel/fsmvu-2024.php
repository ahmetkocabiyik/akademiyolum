<?php

/**
 * FATİH SULTAN MEHMET VAKIF ÜNİVERSİTESİ — Ek-1 Puan Tablosu
 * Kaynak: pdf/17634002431.Fatih Sultan Mehmet Vakıf Üniversitesi Kriter.pdf
 * (YÖK Genel Kurulu onay tarihi 24.10.2024)
 *
 * Madde kodları Ek-1'in kendi numaraları (A1.1.a, A5.2.d …).
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   Kitaplarda uluslararası ile ulusal satırlar aynı etikete düşüyor: tüm
 *       kitap yazarlığı 70/40 → 40; bölüm yazarlığı 25/15 → 15; ansiklopedi
 *       maddesi 15/7 → 7; kitap çevirisi 40/20 → 20; bölüm çevirisi 15/7 → 7.
 *   Bildiride poster (15) ile özet (5) → 5; davetli konuşmacıda uluslararası
 *       (10) ile ulusal (7) → 7.
 *   Atıfta diğer uluslararası indeks (4), alan indeksi dışı dergi (3) ve
 *       TR Dizin dışı ulusal dergi (2) tek 'Diğer' etiketine düşüyor → 2.
 *   Yayın kurulu üyeliği ve makale hakemliğinin beş kademesi (10'dan 3'e)
 *       iki etikete düşüyor → 3.
 *   Tez danışmanlığında tek danışmanlı (10/8) ile iki danışmanlı (5/4)
 *       tezler ayrılamıyor → doktorada 5, yüksek lisansta 4.
 *   Ödüllerde birincilikten mansiyona dört kademe tek etikete düşüyor →
 *       uluslararası 20, ulusal 7.
 *   Bilimsel toplantı görevleri (bildiri kitabı editörlüğü, bilim kurulu
 *       üyeliği, oturum başkanlığı; 10'dan 3'e) tek 'Diğer' etiketine
 *       düşüyor → 3.
 *   A5.1.c ile A5.2.c görsel tasarım satırları (15/10) → 10.
 *   A4'ün üç rapor satırı (uluslararası 15, ulusal 7, bilirkişi 5) tek
 *       maddede toplandı → 5.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   A1.4 (uluslararası alan indekslerine girmeyen hakemli dergiler, 40/10) —
 *       indekssiz uluslararası derginin sözlükte karşılığı yok; 'Diğer Ulusal
 *       Hakemli' etiketi A2.2'ye bağlı. A2.3 (hakemsiz ulusal dergi, 10/3) da
 *       aynı sebeple girilmedi.
 *   Çok ciltli kitap ve çeviri satırları (A1.6.b, A1.7.b, A1.7.f, A2.5.b),
 *       A1.7.h makale ve ansiklopedi maddesi çevirisi, A9.2.c tezsiz yüksek
 *       lisans bitirme projesi.
 *   A8.4 başvurulan fakat kabul edilmeyen projeler — faaliyet kaydı proje
 *       başvurusunu taşımıyor.
 *   A10'un sergileme satırları (20/10) — aynı sergi A5'te zaten puanlanıyor,
 *       çift sayımı önlemek için yazılmadı.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   A8.1 ve A8.2'nin "sözleşmede belirlenen süreyle sınırlı olmak üzere HER
 *       BİR EĞİTİM-ÖĞRETİM YILI için" kuralı: kayıt projenin kaç yıl
 *       sürdüğünü taşımadığı için proje bir kez sayılıyor; çok yıllı
 *       projeleriniz olduğundan düşük puanlanır.
 *   A5'in "aynı sergi için bir defa puan alınır" ve A1.6/A2.5'in "birinci
 *       baskı esastır" kuralları.
 *
 * Yönerge: yonerge/fsmvu.php
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 */
$TAM = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];
$WOS = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];
$ULUSL_PROJE = ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'];
$ULUSAL_PROJE = ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'];
$BAP = ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'];

$maddeler = [
    // ══ A1. ULUSLARARASI YAYINLAR ══
    'A1.1.a' => ['baslik' => 'SCIE, SSCI veya AHCI kapsamındaki dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $TAM, 'puan' => 150],
    'A1.1.b' => ['baslik' => 'SCIE, SSCI veya AHCI kapsamındaki dergide editöre mektup, teknik not, vaka incelemesi, tartışma ya da kitap incelemesi', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $KISA, 'puan' => 40],
    'A1.2.a' => ['baslik' => 'ESCI veya SCOPUS kapsamındaki dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $TAM, 'puan' => 100],
    'A1.2.b' => ['baslik' => 'ESCI veya SCOPUS kapsamındaki dergide editöre mektup, teknik not, vaka incelemesi, tartışma ya da kitap incelemesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $KISA, 'puan' => 25],
    'A1.3.a' => ['baslik' => 'Diğer uluslararası alan indekslerinde taranan dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $TAM, 'puan' => 60],
    'A1.3.b' => ['baslik' => 'Diğer uluslararası alan indekslerinde taranan dergide editöre mektup, teknik not, vaka incelemesi, tartışma ya da kitap incelemesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 15],
    'A1.5.a' => ['baslik' => 'Uluslararası bilimsel toplantıda tam metni ya da özeti CPCI\'da yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 40],
    'A1.5.b' => ['baslik' => 'Uluslararası bilimsel toplantıda bildiriler kitabında tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin'], 'puan' => 25],
    'A1.5.d' => ['baslik' => 'Uluslararası bilimsel toplantıda poster sunumu ya da bildiriler kitabında özet', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 5],
    'A1.6.a' => ['baslik' => 'BKCI veya SCOPUS kapsamındaki kitabın tüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 150],
    'A1.6.c' => ['baslik' => 'BKCI veya SCOPUS kapsamındaki kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 80],
    'A1.7.a' => ['baslik' => 'Uluslararası ya da ulusal bir yayınevince yayımlanan özgün bilimsel kitabın tüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 40],
    'A1.7.c' => ['baslik' => 'Uluslararası ya da ulusal bir yayınevince yayımlanan kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 15],
    'A1.7.d' => ['baslik' => 'Ansiklopedide madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 7],
    'A1.7.e' => ['baslik' => 'Tüm kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 20],
    'A1.7.g' => ['baslik' => 'Bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 7],

    // ══ A2. ULUSAL YAYINLAR ══
    'A2.1.a' => ['baslik' => 'TR Dizin kapsamındaki dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TAM, 'puan' => 60],
    'A2.1.b' => ['baslik' => 'TR Dizin kapsamındaki dergide editöre mektup, teknik not, vaka incelemesi, tartışma, kitap incelemesi ya da eleştiri', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $KISA, 'puan' => 15],
    'A2.2.a' => ['baslik' => 'Diğer hakemli ulusal dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => 30],
    'A2.2.b' => ['baslik' => 'Diğer hakemli ulusal dergide editöre mektup, teknik not, vaka incelemesi, tartışma, kitap incelemesi ya da eleştiri', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 10],
    'A2.4.a' => ['baslik' => 'Ulusal bilimsel toplantıda bildiriler kitabında tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 10],
    'A2.4.b' => ['baslik' => 'Ulusal bilimsel toplantıda poster ya da bildiriler kitabında özet', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 3],
    'A2.5.c' => ['baslik' => 'Mesleki veya ders kitabı yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 30],

    // ══ A3. ATIFLAR ══
    'A3.1.a' => ['baslik' => 'SCIE, SSCI, AHCI, ESCI veya Scopus kapsamında eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 10],
    'A3.1.b' => ['baslik' => 'BKCI kapsamındaki kitapta eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 7],
    'A3.1.e' => ['baslik' => 'TR Dizin kapsamındaki dergilerde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 3],
    'A3.1.f' => ['baslik' => 'Diğer dergilerde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 2],

    // ══ A4. RAPORLAR ══
    'A4.1' => ['baslik' => 'Uluslararası ya da ulusal bir kuruluş için yayımlanmış uzmanlık raporu veya hakem heyeti ya da mahkeme için hazırlanmış bilirkişi raporu', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı', 'Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 5],

    // ══ A5. SANATSAL FAALİYETLER (Sanat, Tasarım ve Mimarlık alanları) ══
    'A5.1.a' => ['baslik' => 'Uluslararası özgün kişisel sergi, proje tasarımı ve uygulaması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Uygulama Projesi — Müellif'], 'puan' => 60],
    'A5.1.b' => ['baslik' => 'Uluslararası bilimsel toplantıda eser çalışması yapmak ve sergilemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Elektronik Karma Sergi (Uluslararası)'], 'puan' => 25],
    'A5.1.c' => ['baslik' => 'Basılmış ya da yayımlanmış afiş, katalog, broşür vb. görsel tasarım', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım'], 'puan' => 10],
    'A5.1.d' => ['baslik' => 'Eserinizin uluslararası kurum ve kuruluşların koleksiyonlarında ya da sahnelerinde daimî olarak yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Yayında Yer Alması / Satın Alınması'], 'puan' => 100],
    'A5.1.e' => ['baslik' => 'Uluslararası atölye, ustalık sınıfı ve çalıştaylarda eğitmenlik ile sergilerde küratörlük', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Masterclass (Uluslararası)'], 'puan' => 40],
    'A5.2.a' => ['baslik' => 'Ulusal özgün kişisel sergi, proje tasarımı ve uygulaması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Kişisel Sergi (Ulusal)', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman'], 'puan' => 30],
    'A5.2.b' => ['baslik' => 'Ulusal bilimsel toplantıda eser çalışması yapmak ve sergilemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 15],
    'A5.2.d' => ['baslik' => 'Eserinizin ulusal kurum ve kuruluşların koleksiyonlarında ya da sahnelerinde daimî olarak yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Satın Alınması (Yurt İçi)'], 'puan' => 70],
    'A5.2.e' => ['baslik' => 'Ulusal atölye, ustalık sınıfı ve çalıştaylarda eğitmenlik ile sergilerde küratörlük', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Masterclass (Ulusal)'], 'puan' => 20],

    // ══ A6. DİĞER MESLEKİ FAALİYETLER ══
    'A6.1.a' => ['baslik' => 'SCIE, SSCI, AHCI, ESCI veya Scopus kapsamındaki dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 30],
    'A6.1.b' => ['baslik' => 'BKCI veya SCOPUS kapsamındaki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 20],
    'A6.1.c' => ['baslik' => 'TR Dizin kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 20],
    'A6.1.d' => ['baslik' => 'Üniversite bilimsel dergilerinde editörlük (TR Dizin hariç)', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 10],
    'A6.1.e' => ['baslik' => 'Uluslararası ya da ulusal bir yayınevince yayımlanan bilimsel, mesleki eser veya ders kitabında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 20],
    'A6.2' => ['baslik' => 'Yayın kurulu üyeliği ya da makale hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği', 'Hakemlik'], 'puan' => 3],
    'A6.3.d' => ['baslik' => 'Bilimsel toplantıda davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 7],
    'A6.3' => ['baslik' => 'Bilimsel toplantılarda bildiri kitabı editörlüğü, bilim/danışma/düzenleme kurulu üyeliği ya da oturum başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Diğer', 'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)', 'Oturum Başkanlığı (Uluslararası)', 'Oturum Başkanlığı (Ulusal)'], 'puan' => 3],

    // ══ A7. FİKRİ MÜLKİYET ══
    'A7.1.a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 120],
    'A7.1.b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 80],
    'A7.1.c' => ['baslik' => 'Tescil edilmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Yazılım'], 'puan' => 40],
    'A7.1.d' => ['baslik' => 'Tescilli tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım'], 'puan' => 25],

    // ══ A8. PROJE FAALİYETLERİ ══
    'A8.1.a' => ['baslik' => 'Uluslararası destekli ve katılımlı projede yürütücülük ya da eş yürütücülük', 'kategori' => 'proje', 'kaynaklar' => $ULUSL_PROJE, 'roller' => ['yurutucu'], 'puan' => 100],
    'A8.1.b' => ['baslik' => 'Uluslararası destekli ve katılımlı projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => $ULUSL_PROJE, 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 50],
    'A8.1.c' => ['baslik' => 'Uluslararası destekli ve katılımlı projede izleyicilik, hakemlik ya da danışmanlık', 'kategori' => 'proje', 'kaynaklar' => $ULUSL_PROJE, 'roller' => ['danisman'], 'puan' => 20],
    'A8.2.a' => ['baslik' => 'Ulusal kuruluşlarca (TÜBİTAK, TÜBA vb.) desteklenen projede yürütücülük ya da eş yürütücülük', 'kategori' => 'proje', 'kaynaklar' => $ULUSAL_PROJE, 'roller' => ['yurutucu'], 'puan' => 70],
    'A8.2.b' => ['baslik' => 'Ulusal kuruluşlarca desteklenen projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => $ULUSAL_PROJE, 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 40],
    'A8.2.c' => ['baslik' => 'Ulusal kuruluşlarca desteklenen projede izleyicilik, hakemlik ya da danışmanlık', 'kategori' => 'proje', 'kaynaklar' => $ULUSAL_PROJE, 'roller' => ['danisman'], 'puan' => 10],
    'A8.3.a' => ['baslik' => 'Üniversite tarafından desteklenen (BAP) projede yürütücülük ya da eş yürütücülük', 'kategori' => 'proje', 'kaynaklar' => $BAP, 'roller' => ['yurutucu'], 'puan' => 20],
    'A8.3.b' => ['baslik' => 'Üniversite tarafından desteklenen (BAP) projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => $BAP, 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
    'A8.5.a' => ['baslik' => 'Diğer üniversite ve kuruluşlar (TEKNOFEST vb.) tarafından desteklenen proje ve faaliyetlerdeki görevler', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'puan' => 15],
    'A8.5.b' => ['baslik' => 'Teknopark ya da TEKMER\'de şirket kurmak', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 30],

    // ══ A9. TEZ DANIŞMANLIKLARI ══
    'A9.1' => ['baslik' => 'Doktora tezi ya da sanatta yeterlik çalışması yönetmek', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 5],
    'A9.2' => ['baslik' => 'Yüksek lisans tezi ya da eseri yönetmek', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 4],

    // ══ A10. ÖDÜLLER ══
    'A10.1' => ['baslik' => 'Uluslararası kurum ve kuruluşlarca düzenlenen profesyonel organizasyonlarda verilen derece ya da mansiyon ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 20],
    'A10.2' => ['baslik' => 'Ulusal resmî ve profesyonel kuruluşlarca düzenlenen organizasyonlarda verilen derece ya da mansiyon ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü', 'Yarışma Derecesi / Mansiyon'], 'puan' => 7],
    'A10.1.e' => ['baslik' => 'Uluslararası organizasyonlarda jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], 'puan' => 10],
    'A10.2.e' => ['baslik' => 'Ulusal organizasyonlarda jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 5],
];

$kodlar = fn (string ...$onekler): array => array_values(array_filter(
    array_keys($maddeler),
    fn (string $kod): bool => array_reduce($onekler, fn (bool $t, string $o): bool => $t || str_starts_with($kod, $o), false)
));

return [
    'kapsam_notu' => 'Puanlar Fatih Sultan Mehmet Vakıf Üniversitesi Öğretim Üyeliğine '
        .'Yükseltilme ve Atanma Yönergesinin Ek-1 puan tablosundan (YÖK onayı 24.10.2024). '
        .'Yıldızlı satırlarda (makale, kitap, bildiri, patent, ödül ve sanatsal faaliyetler) '
        .'ortak çalışma çarpanı uygulanıyor: tek kişide tam puan, iki kişide %80, ikiden fazla '
        .'kişide 1,8 × puan / kişi sayısı. Yazar listesini boş bırakırsanız çarpan uygulanmaz ve '
        .'puanınız olduğundan yüksek görünür. Atıflardan en fazla 250, raporlardan 20, '
        .'uluslararası sergileme faaliyetlerinden 50, ulusal sergileme faaliyetlerinden 60 puan '
        .'alınabiliyor. Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: A1.4 (uluslararası '
        .'indekslere girmeyen hakemli dergiler) ve A2.3 (hakemsiz ulusal dergiler) sözlükte '
        .'karşılıksız; çok ciltli kitap ve çeviri satırları, makale çevirisi, tezsiz yüksek '
        .'lisans projesi ve proje BAŞVURUSU satırları girilemedi; kitap, bildiri, atıf, tez '
        .'danışmanlığı, ödül, hakemlik ve toplantı görevlerinin yüksek kademeleri düşük '
        .'kademelerinden ayrılamadığı için en düşük değerden sayılıyor; çok yıllı projeler '
        .'yönergedeki gibi her yıl için ayrı puanlanamıyor.',

    // Ek-1 dipnotu: "Katkıda bulunan bir kişi ise P; iki kişi ise 0,8 × P;
    // ikiden fazla ise 1,8 × P / n." Atıf, rapor, editörlük, proje ve tez
    // satırlarında yıldız yok; çarpan onlara uygulanmıyor.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'editorluk', 'proje', 'tez_danismanligi', 'tez_yayini',
            'egitim_ogretim', 'idari_gorev', 'toplumsal_katki', 'diger'],
        'kademeler' => [1 => 1.00, 2 => 0.80],
        'sonrasi_pay' => 1.80,
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        // Tablo 1'in "A1, A2 ve A5" sütunu.
        'A1-A2-A5' => $kodlar('A1.', 'A2.', 'A5.'),
        // Tablo 1'in "Toplam" sütunu: tablonun tamamı.
        'TOPLAM' => array_keys($maddeler),
        // Tablo 1'in yıldız dipnotu: "çalışmalardan en az bir tanesinin
        // SSCI/SCIE/AHCI/ESCI/SCOPUS tarafından taranan dergilerde
        // yayımlanmış olması gerekir".
        'INDEKSLI' => ['A1.1.a', 'A1.1.b', 'A1.2.a', 'A1.2.b'],
        // MADDE 6/2-a: "ULAKBİM tarafından taranan hakemli ulusal bir dergide
        // veya hakemli uluslararası bir dergide en az 1 makale (veya özgün
        // bilimsel kitap bölümü)".
        'DR-MAKALE' => ['A1.1.a', 'A1.2.a', 'A1.3.a', 'A2.1.a', 'A1.6.c', 'A1.7.c'],
        // MADDE 17/8: tez danışmanlığı koşulu.
        'TEZ-DOKTORA' => ['A9.1'],
        'TEZ-YL' => ['A9.2'],
        // Tavan grupları.
        'ATIF' => $kodlar('A3.'),
        'RAPOR' => ['A4.1'],
        'SANAT-TOPLANTI-ULUSL' => ['A5.1.b'],
        'SANAT-TOPLANTI-ULUSAL' => ['A5.2.b'],
    ],

    'grup_tavanlari' => [
        'ATIF' => 250,
        'RAPOR' => 20,
        'SANAT-TOPLANTI-ULUSL' => 50,
        'SANAT-TOPLANTI-ULUSAL' => 60,
    ],
];
