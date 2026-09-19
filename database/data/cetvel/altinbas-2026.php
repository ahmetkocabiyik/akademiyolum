<?php

/**
 * ALTINBAŞ ÜNİVERSİTESİ — Yükseltilme ve Atanma Puan Tablosu
 * Kaynak: pdf/1770903886868.altinbasak-kriter-12022026.pdf (12.02.2026)
 *
 * Madde kodları tablonun kendi numaralandırması (1.1.1.0.1, 4.0.1.1.2,
 * 7.0.1.1 …). Bize ait olanlar:
 *   - 1.1.1.0.1'in çeyrekliğe göre bölünmüş .a-.e alt kodları. Puanları
 *     BİREBİR AYNI (30); tek işlevleri profesörlük koşulundaki "SCI, SSCI
 *     ya da A&HCI dizinli dergide Q1 ya da Q2 sınıfı yayın" kümesini
 *     kurabilmek. Yönerge bu satırı çeyrekliğe göre ayırmıyor.
 *   - Projede ve tez danışmanlığında rol ayrımı için açılan alt kodlar.
 *
 * ── ATIF SATIRLARI GİRİLEMEDİ, KOŞULLARI HESAPLANAMIYOR ──
 * Uluslararası atıf 0,5 ve ulusal atıf 0,3 puan. §0 kesirli puanı aşağı
 * yuvarlamayı emrediyor, ikisi de SIFIRA düşüyor. Sıfır puanlı bir atıf
 * satırı "Atıflardan 15 puan" koşulunu asla sağlatamayacağı için satırlar
 * hiç girilmedi ve atıf koşulları yönergede `hesaplanamiyor` olarak
 * duruyor; adaya "bu koşulu kendiniz kontrol edin" diyor.
 *
 * ── DERS YÜKÜ GİRİLEMEDİ ──
 * 4.0.2.1.1 "yılda verilen her bir AKTS = 0,5 puan". Faaliyet kaydı ders
 * saatini ya da AKTS'sini taşımıyor, yalnız yarıyıl sayısını tutuyor;
 * AKTS'yi yarıyıla çevirmek ders başına AKTS varsayımı gerektirirdi.
 * Satır girilmedi, "Verilen Dersler 30 puan" koşulları yönergede
 * `hesaplanamiyor` olarak duruyor. Eğitim-öğretim kategorisinde başka
 * puanlı satır olmadığı için ders kayıtlarınız toplam puana katkı vermiyor.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   Kitapta "tanınmış yayınevi" ile "diğer yayınevi" ayrımı yalnız BKCI
 *       ve SCOPUS kapsamındaki kitaplarda güvenilir biçimde yapılabiliyor;
 *       öbür kitaplarda 1.1.3.0.1 (50), 1.1.3.0.2 (25), 1.2.3.0.1 (40) ve
 *       1.2.3.0.2 (20) tek etikete düşüyor → 20. Kitap bölümünde 20/15/15/10
 *       → 10, editörlükte 30/20/25/15 → 15 (BKCI editörlüğü ayrı, 30).
 *   Kitap çevirisi 1.1.8.0.1 (10) ile 1.2.8.0.1 (6) → 6.
 *   Tez danışmanlığında "tek danışman" ile "esas danışman" ayrılamıyor:
 *       doktorada 10/6 → 6, yüksek lisansta 5/3 → 3.
 *   Yarışmada ilk üç derece (50/30) ile mansiyon (40/20) tek 'Yarışma
 *       Derecesi / Mansiyon' etiketine düşüyor → 20.
 *   Editörler kurulu üyeliği 5.1.2.0.1 (10) ile 5.2.2.0.1 (5), üniversite
 *       dergisi yayın kurulu üyeliği 7.0.1.1 (3) → 3.
 *   Konferans düzenleyiciliği 7.1.2.0.1 (15) ile 7.2.2.0.1 (6) → 6.
 *   Kamu kurullarında üyelik (5), bilirkişilik (3) ve danışmanlık 3.2.4.0.1
 *       (3) tek 'Kamu/STK Danışmanlığı' etiketine düşüyor → 3.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   1.1.1.0.3 ve 1.2.1.0.3 (C türü dergiler) — "kitap kritiği yapılmış
 *       makale" ve "A ve B dışında kalan diğer dergiler" tanımları
 *       sözlükte karşılıksız.
 *   1.1.6.0.1 ve 1.2.6.0.1 (basılmamış bildiri) — basılı bildiriden
 *       ayrılamıyor.
 *   1.1.11 ve 1.2.1.1 (kritikler), 1.1.7 ve 1.2.7 (konferans kitapçığı
 *       editörlüğü), 3.1.3 ve 3.2.3 (bilirkişi raporu, mütalaa),
 *       5.1.3.0.2-3 ve 5.2.3.0.2-3 (kitap hakemliği), 4.0.1.3
 *       (yüksek lisans projesi), 4.0.3 (ders ve program geliştirme),
 *       7.0.3 (sürekli eğitim semineri) — sözlükte karşılıksız.
 *   5.1.3.0.1 ve 5.2.3.0.1 (makale/proje hakemliği, 1 ve 0,5 puan) —
 *       düşük olan aşağı yuvarlanınca sıfırlanıyor.
 *   3.1.2.0.2 ve 3.2.2.0.2 (proje ÖNERİSİ sunma) — kabul edilen projeden
 *       ayrılamıyor; girilseydi öneri sahibi proje yürütücüsü gibi
 *       sayılırdı.
 *   Faydalı model, endüstriyel tasarım, ıslahçı hakkı, yazılım ve
 *       ticarileştirme — yönerge yalnız patenti puanlıyor.
 *   2.1.2, 2.1.3, 2.1.4 ile 2.2.2, 2.2.3, 2.2.4 (ödül kazanmış,
 *       hakkında yazı yazılmış ve gerçekleştirilmemiş çalışmalar) ve
 *       6.1.1.0.7 (koleksiyona girmek) — sözlükte karşılıksız.
 *   Müzik ve sahne sanatları etiketleri (resital, solistlik, orkestra
 *       şefliği, opera rolleri, koreografi kademeleri) — yönergenin
 *       sanatsal etkinlik bölümü yalnız görsel sanat ve tasarım
 *       etkinliklerini sayıyor.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   "Bir kitapta birden fazla bölüm: (1+k/c)p" — kitaptaki toplam bölüm
 *       sayısı kayıtta yok, çarpan uygulanmadı.
 *   "Bir görevden gelen doğal üyelikler için puan yazılmaz."
 *   4.0.2.1.2 (yılda 250 öğrencinin üstüne her öğrenci 0,02 puan).
 *   Afiş, logo gibi tasarımların "en az üç çalışmadan oluşması" koşulu.
 *
 * Yönerge: yonerge/altinbas.php
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
$A_TURU = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];
$B_TURU = ['ESCI / Scopus', 'Diğer Uluslararası İndeks'];
$ULUSAL_PROJE = ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'BAP (Üniversite)',
    'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'];
$ULUSLARARASI_PROJE = ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'];
$DOKTORA_TEZ = ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'];

$maddeler = [
    // ══ 1.1. ULUSLARARASI YAYINLAR ══
    // A türü: SSCI, SCI, SCI-Expanded ya da AHCI dergilerinde yayımlanmış
    // makale. Çeyreklik alt kodları bize ait; puanları aynı (30).
    '1.1.1.0.1.a' => ['baslik' => 'SCI, SCI-Expanded ya da SSCI kapsamındaki Q1 dergide yayımlanmış tam metin makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $TAM, 'puan' => 30],
    '1.1.1.0.1.b' => ['baslik' => 'SCI, SCI-Expanded ya da SSCI kapsamındaki Q2 dergide yayımlanmış tam metin makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $TAM, 'puan' => 30],
    '1.1.1.0.1.c' => ['baslik' => 'SCI, SCI-Expanded ya da SSCI kapsamındaki Q3 dergide yayımlanmış tam metin makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $TAM, 'puan' => 30],
    '1.1.1.0.1.d' => ['baslik' => 'SCI, SCI-Expanded ya da SSCI kapsamındaki Q4 dergide yayımlanmış tam metin makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $TAM, 'puan' => 30],
    '1.1.1.0.1.e' => ['baslik' => 'AHCI kapsamındaki dergide yayımlanmış tam metin makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => $TAM, 'puan' => 30],
    '1.1.1.0.2' => ['baslik' => 'Uluslararası alan indekslerinde taranan dergide yayımlanmış tam metin makale', 'kategori' => 'makale', 'kaynaklar' => $B_TURU, 'turler' => $TAM, 'puan' => 25],
    '1.1.1.0.4' => ['baslik' => 'Uluslararası dergide yayımlanmış editöre mektup, teknik not, vaka analizi ya da tartışma', 'kategori' => 'makale', 'kaynaklar' => [...$A_TURU, ...$B_TURU], 'turler' => $KISA, 'puan' => 6],
    '1.1.2.0.1' => ['baslik' => 'Tanınmış uluslararası yayınevi tarafından basılmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Uluslararası Kitap Bölümü'], 'puan' => 20],
    '1.1.3.0.1' => ['baslik' => 'Tanınmış uluslararası yayınevi tarafından basılmış bilimsel ya da mesleki kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası Kitap'], 'puan' => 50],
    '1.1.4.0.1' => ['baslik' => 'Tanınmış uluslararası yayınevi tarafından basılmış kitabın editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Uluslararası Kitap Editörlüğü'], 'puan' => 30],
    '1.1.5.0.1' => ['baslik' => 'Uluslararası hakemli konferansta sunulmuş ve konferans kitabında basılmış tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 10],
    '1.1.5.0.2' => ['baslik' => 'Uluslararası hakemli konferansta sunulmuş ve konferans kitabında basılmış bildiri özeti', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster', 'Davetli Konuşmacı'], 'puan' => 5],

    // ══ 1.2. ULUSAL YAYINLAR ══
    '1.2.1.0.1' => ['baslik' => 'ULAKBİM TR Dizin tarafından taranan ulusal hakemli dergide yayımlanmış tam metin makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TAM, 'puan' => 20],
    '1.2.1.0.2' => ['baslik' => 'Diğer ulusal hakemli dergide yayımlanmış tam metin makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => 15],
    '1.2.2.0.2' => ['baslik' => 'Ulusal yayınevi tarafından basılmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 10],
    '1.2.3.0.2' => ['baslik' => 'Ulusal yayınevi tarafından basılmış bilimsel, mesleki ya da ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap', 'Ders / Metot Kitabı', 'Tahkik (Tenkitli Metin)'], 'puan' => 20],
    '1.2.4.0.2' => ['baslik' => 'Ulusal yayınevi tarafından basılmış kitabın editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü', 'Ulusal Kitap Editörlüğü'], 'puan' => 15],
    '1.2.5.0.1' => ['baslik' => 'Ulusal hakemli konferansta sunulmuş ve konferans kitapçığında basılmış tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 7],
    '1.2.5.0.2' => ['baslik' => 'Ulusal hakemli konferansta sunulmuş ve konferans kitapçığında basılmış bildiri özeti', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 5],
    '1.2.8.0.1' => ['baslik' => 'Tercüme edilip yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 6],
    '1.2.9.0.1' => ['baslik' => 'Tercüme edilip yayımlanmış makale ya da kitap bölümü', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 3],

    // ══ 2. MİMARİ ve SANATSAL ÖDÜLLER ══
    '2.1.1.0.4' => ['baslik' => 'Uluslararası düzeyde gerçekleştirilen jürili yarışmaya katılmak, danışmanlık yapmak ya da jüri üyesi olarak görev yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], 'puan' => 15],
    '2.2.1.0.2' => ['baslik' => 'Meslek örgütlerince ya da Bakanlıklarca düzenlenen yarışmalarda ilk üç derece veya mansiyon', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 20],
    '2.2.1.0.4' => ['baslik' => 'Ulusal düzeyde gerçekleştirilen jürili yarışmaya katılmak, danışmanlık yapmak ya da jüri üyesi olarak görev yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 10],

    // ══ 3. MESLEKİ VE DİĞER ARAŞTIRMA ETKİNLİKLERİ ══
    '3.1.1.0.1' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 75],
    '3.1.2.0.1' => ['baslik' => 'Kabul edilmiş uluslararası projede yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => $ULUSLARARASI_PROJE, 'roller' => ['yurutucu'], 'puan' => 40],
    '3.1.2.0.3' => ['baslik' => 'Kabul edilmiş uluslararası projede araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => $ULUSLARARASI_PROJE, 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
    '3.2.1.0.1' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 50],
    '3.2.2.0.1' => ['baslik' => 'Kabul edilmiş ulusal projede yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => $ULUSAL_PROJE, 'roller' => ['yurutucu'], 'puan' => 30],
    '3.2.2.0.3' => ['baslik' => 'Kabul edilmiş ulusal projede araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => $ULUSAL_PROJE, 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
    '3.2.4.0.1' => ['baslik' => 'Kamu kurumları ya da meslek kuruluşları için danışmanlık, kurul üyeliği veya bilirkişilik yapmak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı', 'Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 3],

    // ══ 4. EĞİTİM ETKİNLİKLERİ ══
    '4.0.1.1.2' => ['baslik' => 'Tamamlanmış doktora ya da uzmanlık tezinde danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => $DOKTORA_TEZ, 'roller' => ['danisman'], 'puan' => 6],
    '4.0.1.1.3' => ['baslik' => 'Tamamlanmış doktora ya da uzmanlık tezinde yardımcı danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => $DOKTORA_TEZ, 'roller' => ['es_danisman'], 'puan' => 4],
    '4.0.1.2.2' => ['baslik' => 'Tamamlanmış yüksek lisans tezinde danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'roller' => ['danisman'], 'puan' => 3],
    '4.0.1.2.3' => ['baslik' => 'Tamamlanmış yüksek lisans tezinde yardımcı danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 2],

    // ══ 5. ÜYELİKLER VE ÖDÜLLER ══
    '5.1.1.0.1' => ['baslik' => 'Düzenli bir uluslararası ödül yarışmasında alanıyla ilgili ödül kazanmak', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 40],
    '5.2.1.0.1' => ['baslik' => 'Düzenli bir ulusal ödül yarışmasında alanıyla ilgili ödül kazanmak', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü', 'Burs'], 'puan' => 20],
    '5.2.2.0.1' => ['baslik' => 'Editörler kurulu, değerlendirme kurulu ya da ödül jürisi üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 3],

    // ══ 6. SANATSAL ETKİNLİKLER ══
    '6.1.1.0.1' => ['baslik' => 'Özgün sanat eserinin, tasarımın ya da yorum çalışmasının yurt dışında satın alınması, yayın organlarında yer alması veya tasarım projesinin dış ülkelerde uygulanmış olması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Yayında Yer Alması / Satın Alınması', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Koruma-Onarım Uygulaması (Uluslararası)', 'Uygulama Projesi — Müellif', 'Belgesel/Kısa Film (Uluslararası)'], 'puan' => 30],
    '6.1.1.0.2' => ['baslik' => 'Özgün sanat eserleri, tasarımlar ya da yorum çalışmalarıyla uluslararası jürili karma sanat ve tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)'], 'puan' => 15],
    '6.1.1.0.4' => ['baslik' => 'Özgün sanat eserleri, tasarımlar ya da yorum çalışmalarıyla yurt dışında kişisel etkinlikte bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Elektronik Kişisel Sergi (Uluslararası)'], 'puan' => 30],
    '6.1.1.0.5' => ['baslik' => 'Özgün sanat eserleri, tasarımlar ya da yorum çalışmalarıyla yurt dışında karma veya grup sanat ve tasarım etkinliğine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Karma Sergi (Uluslararası)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 5],
    '6.1.1.0.6' => ['baslik' => 'Özgün sanat eserleri, tasarımlar ya da yorum çalışmalarıyla tanınmış sanat müzelerine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Haber Olması (Uluslararası)'], 'puan' => 30],
    '6.2.1.0.1' => ['baslik' => 'Özgün sanat eserinin, tasarımın ya da yorum çalışmasının yurt içinde satın alınması veya yayın organlarında yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Satın Alınması (Yurt İçi)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Koruma-Onarım Uygulaması (Ulusal)', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman', 'Belgesel/Kısa Film (Ulusal)', 'Özgün Eser / Beste / Tasarım'], 'puan' => 20],
    '6.2.1.0.2' => ['baslik' => 'Özgün sanat eserleri, tasarımlar ya da yorum çalışmalarıyla yurt içinde jürili karma sanat ve tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 10],
    '6.2.1.0.3' => ['baslik' => 'Özgün sanat eserleri, tasarımlar ya da yorum çalışmalarıyla yurt içinde kişisel etkinlikte bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 10],
    '6.2.1.0.4' => ['baslik' => 'Özgün sanat eserleri, tasarımlar ya da yorum çalışmalarıyla yurt içinde karma veya grup sanat ve tasarım etkinliğine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Jürisiz, Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Eğitim Amaçlı Sanat Etkinliği'], 'puan' => 2],
    '6.2.1.0.5' => ['baslik' => 'Özgün sanat eserleri, tasarımlar ya da yorum çalışmalarıyla yurt içinde tanınmış sanat müzelerine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Haber Olması (Ulusal)'], 'puan' => 15],

    // ══ 7. DİĞER ETKİNLİKLER ══
    '7.0.1.1.1' => ['baslik' => 'Rektör yardımcılığı, dekanlık, enstitü ya da yüksekokul müdürlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü'], 'puan' => 20],
    '7.0.1.1.2' => ['baslik' => 'Dekan yardımcılığı, müdür yardımcılığı, bölüm başkanlığı, uygulama ve araştırma merkezi müdürlüğü ya da bilimsel dergilerde editörlük', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkanı', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 10],
    '7.0.1.1.3' => ['baslik' => 'Anabilim dalı başkanlığı, koordinatörlük, senato, yönetim kurulu ya da komisyon üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük', 'Kurul / Komisyon Üyeliği', 'Bölüm Başkan Yardımcısı'], 'puan' => 5],
    '7.0.1.1.4' => ['baslik' => 'Bilimsel dergilerde editörlük ya da yazı işleri müdürlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi', 'TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 10],
    '7.2.2.0.1' => ['baslik' => 'Konferans düzenleyiciliği', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 6],
];

return [
    'kapsam_notu' => 'Puanlar Altınbaş Üniversitesi Yükseltilme ve Atanma Puan Tablosundan '
        .'(12.02.2026). Ortak çalışmalarda puan dağılımı yazar SIRASINA değil yalnız KİŞİ '
        .'SAYISINA bakıyor: tek kişide tam puan, iki kişide %80, ikiden fazla kişide 1,8 × puan '
        .'/ kişi sayısı. Yazar listesini boş bırakırsanız bölme hiç uygulanmaz ve puanınız '
        .'olduğundan yüksek görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: ATIFLAR hiç sayılmıyor — uluslararası '
        .'atıf 0,5, ulusal atıf 0,3 puan olduğu ve motor tam sayı puan tuttuğu için satırlar '
        .'girilemedi; yönergenin "Atıflardan 15 puan" gibi koşulları bu yüzden hesaplanamıyor '
        .'olarak işaretli, kendiniz kontrol etmelisiniz. VERİLEN DERSLER de sayılmıyor: yönerge '
        .'AKTS başına 0,5 puan veriyor, faaliyet kaydı ise AKTS taşımıyor. '
        .'Tez danışmanlığında "tek danışman" ile "esas danışman" '
        .'ayrılamadığı için düşük satır uygulanıyor (doktorada 10 yerine 6). Proje ÖNERİSİ '
        .'sunma, kritikler, bilirkişi raporları, kitap hakemliği, yüksek lisans projeleri, ders '
        .'ve program geliştirme ile sürekli eğitim seminerleri girilmedi. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünür: "bir kitapta birden fazla bölüm" '
        .'için öngörülen (1 + k/c) çarpanı uygulanmıyor ve idari görevler yıl başına değil kayıt '
        .'başına puanlanıyor.'
        .' KİTAPTA "TANINMIŞ YAYINEVİ" KOŞULU DENETLENMİYOR: uluslararası yayınevi kitabınız yönergenin tanınmış uluslararası yayınevi satırından sayılıyor. Yayıneviniz yönergenin tanımına (faaliyet süresi, kütüphane kataloglaması, kitap sayısı) girmiyorsa puanınız olduğundan YÜKSEK görünür; başvurunuzda yayınevini belgeleyin.',

    // ORTAK ÇALIŞMALARDA PUAN DAĞILIMI: tek kişi p, iki kişi 0,8p, ikiden
    // fazla kişi 1,8p/n. Yazar SIRASINA bakılmadığı için bütün roller aynı
    // tabloyu paylaşıyor.
    'yazar_katsayisi' => [
        'kademeler' => [1 => 1.00, 2 => 0.80],
        'bol' => ['pay' => 1.8],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        // Doçentlik ve profesörlük yayın koşullarının atıf yaptığı kümeler.
        'A-TURU' => ['1.1.1.0.1.*'],
        'Q1' => ['1.1.1.0.1.a'],
        'Q1-Q2' => ['1.1.1.0.1.a', '1.1.1.0.1.b'],
        // Doçentlikte ve Sosyal ile Hukuk profesörlüğünde yayın kümesi:
        // (1.1.1.0.1), (1.1.2.0.1), (1.2.1.0.1) ve (1.2.2.0.1).
        'DOC-YAYIN' => ['1.1.1.0.1.*', '1.1.2.0.1', '1.2.1.0.1', '1.2.2.0.2'],
        // Fen, Sağlık ve Mühendislik profesörlüğünde kümeye (1.1.1.0.2) de
        // giriyor; Mimarlıkta ayrıca 2.1 (uluslararası mimari ve sanatsal
        // ödüller).
        'PROF-YAYIN-FSM' => ['1.1.1.0.1.*', '1.1.1.0.2', '1.1.2.0.1', '1.2.1.0.1', '1.2.2.0.2'],
        'PROF-YAYIN-MIMARLIK' => ['1.1.1.0.1.*', '1.1.1.0.2', '1.1.2.0.1', '1.2.1.0.1',
            '1.2.2.0.2', '2.1.1.0.4'],
        // Hukukta profesörlüğün ilk barajı: (1.1.1.0.1), (1.2.1.0.1) ve
        // (1.2.3.0.1); ulusal barajı: (1.2.1.0.1), (1.2.2.0.1), (1.2.3.0.1).
        'HUKUK-PROF-A' => ['1.1.1.0.1.*', '1.2.1.0.1', '1.2.3.0.2'],
        'ULUSAL-MAKALE-KITAP' => ['1.2.1.0.1', '1.2.2.0.2', '1.2.3.0.2'],
        'KITAP-ULUSLARARASI' => ['1.1.3.0.1', '1.2.3.0.2'],
        'KITAP-VE-EDITORLUK' => ['1.1.3.0.1', '1.1.4.0.1', '1.2.3.0.2', '1.2.4.0.2'],
        'TEZ-YONETIMI' => ['4.0.1.1.2', '4.0.1.1.3', '4.0.1.2.2', '4.0.1.2.3'],
        'TEZ-DOKTORA' => ['4.0.1.1.2', '4.0.1.1.3'],
        'TEZ-YUKSEK-LISANS' => ['4.0.1.2.2', '4.0.1.2.3'],
        // Ana yürütücülük ya da ortak kurum koordinatörlüğü koşulu.
        'PROJE-YURUTUCU' => ['3.1.2.0.1', '3.2.2.0.1'],
    ],

    'grup_tavanlari' => [],
];
