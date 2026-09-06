<?php

/**
 * İSTANBUL NİŞANTAŞI ÜNİVERSİTESİ — EK-1: Profesör, Doçent ve Doktor Öğretim
 * Üyesi Kadrolarına Atamada Aranacak Ek Koşullar Puan Sistemi
 * Kaynak: pdf/17537100182.istanbulnisantasiuniversitesi.pdf (Senato 2025/16)
 *
 * MADDE KODLARI yönergenin kendi bölüm harflerini (A-J) ve satır numaralarını
 * birebir korur; koşullar tabloya bölüm harfiyle atıf yapıyor ("Ek 1-A'da yer
 * alan yayın ve faaliyetlerden asgari 120 puan", "Ek1'de (1a-2a-3a-5a)").
 * Alt şık harfleri de kaynaktan: 'A.5.a', 'İ.1.b'.
 *
 * İKİ AYRI BÖLÜM HARFİ: yönergede hem "I. BİLİMSEL ÖDÜLLER" hem "İ. ARAŞTIRMA
 * PROJELERİ" var. Kodlar ayrı tutuldu ('I.1' ödül, 'İ.1.a' proje); UTF-8'de
 * 'I' ile 'İ' farklı baytlar olduğu için önek eşleşmesi ikisini karıştırmıyor.
 *
 * ── YAZAR MATRİSİ İKİ BOYUTLU ──
 * "Ortak Çalışmalar İçin Puan Dağılımı" tablosu çarpanı hem İSİM SIRASINA hem
 * YAZAR SAYISINA bağlıyor (1. isim tek yazarlı 100 · beş yazarlı 80 · altı+
 * 75; 6. ve sonraki isimler daima 35). Korpusta çoğu yönerge yalnızca birine
 * bakıyor; burada her rol kendi `kademeler` satırını taşıyor.
 * Sorumlu yazara ayrıcalık YOK — tablo yalnızca isim sırasından söz ediyor —
 * bu yüzden `baslica` ve sırasını belirtmeyen `ortak`, o yazar sayısındaki EN
 * DÜŞÜK satırı alır (kural: eksik say, fazla sayma).
 *
 * ── AYNI KAYNAĞA DÜŞEN SATIRLARDA DAİMA DÜŞÜĞÜ GİRİLDİ ──
 *   Kitap A.2 (yurt dışı yayınevi, 30) / A.3 (Türkiye yayınevi, 20):
 *       'Uluslararası/Ulusal Kitap' ikisini ayıramıyor → A.3.a.
 *       Bölüm yazarlığında ikisi de 10, ayrım gereksiz → A.3.b.
 *   Bildiri B.1.b (WoS/Scopus poster, 3) / B.2.b (poster, 2): 'Uluslararası
 *       Özet/Poster' indeks bilgisi taşımıyor → B.2.b.
 *   Sanat ödülü C.4 (uluslararası jürili, 20) / C.5 (ulusal, 10) / E.8
 *       (uluslararası yarışma derecesi, 20) / E.10 (ulusal birincilik, 10):
 *       'Yarışma Derecesi / Mansiyon' hiçbirini ayıramıyor → C.5.
 *   Editörlük F.2 (yurt dışı yayınevi, 20) / F.3 (Türkiye, 10):
 *       'Kitap Editörlüğü' ayıramıyor → F.3.
 *   Dergi görevi F.4.a editörlük (20) / F.4.b kurul (10) / F.4.c hakemlik (5):
 *       'WoS Dergi (Q1-Q4)' kaynağı derginin düzeyini söylüyor, adayın
 *       görevini söylemiyor → F.4.c. Aynı gerekçeyle F.5.a/b/c → F.5.c.
 *   Atıf G.1 (WoS, 3) / G.2 (Scopus, 2): 'WoS / Scopus' tek kaynak → G.2.
 *       'BKCI Kitap' ve 'Patent' atıfları hangi indekse düştüğünü söylemediği
 *       için en düşük satıra (G.3) yazıldı.
 *   Patent H.1 (üçlü patent, 50) / H.2 (uluslararası, 40): 'Uluslararası
 *       Patent' ABD+AB+Japonya üçlüsünü ayıramıyor → H.2.
 *   Kayıt E.7.a solo (20) / E.7.b kısa solo (10) / E.7.c orkestra (5):
 *       'Albüm / Konser Kaydı' ve 'Bandrollü Kayıt' icra biçimini
 *       söylemiyor → E.7.c.
 *   Tez J.1.a tek başına (10) / J.1.b asıl yürütücü (8): 'Doktora Tezi'
 *       ikisini ayıramıyor → J.1.b.
 *   Proje İ.4 (bakanlık Ar-Ge, 60) / İ.5 (diğer ulusal kurum, 10): 'Diğer
 *       Kamu Kurumu' hangisi olduğunu söylemiyor → İ.5. Adı geçen TÜSEB
 *       kaynağı yönergede sayıldığı için İ.4'te kaldı.
 *
 * ── BÖLÜMLER ARASI EŞLEŞTİRMEDE SÖZCÜĞÜ BİREBİR TUTAN SATIR SEÇİLDİ ──
 * Yukarıdaki kural bölüm İÇİNDEKİ gerçek belirsizlikler için. Yönergenin
 * kendisi C, D, E bölümlerini yalnızca "sanat, müzik ve spor alanında çalışan"
 * adaylara açtığı için bu bölümler bilimsel bölümlerle yarışmıyor; iki bölümde
 * birden geçebilecek iki kaynakta metin karşılığı birebir olan satır alındı:
 *   'Uluslararası Bilim/Sanat Ödülü' → I.1 "bilim ve sanat ödülleri" (80),
 *       E.9 "yarışma kapsamı dışındaki uluslararası ödüller" (10) değil.
 *   'Sahne, TV, Radyo, Sinema Yapıtı (…)' → C.1 "sanat eserinin … sinema,
 *       televizyon, radyo gibi yayın organlarında yer alması", E.13 "radyo
 *       veya televizyon programı YAPIMCILIĞI" (8) değil.
 *
 * ── SPOR BÖLÜMÜ (D) HİÇ GİRİLEMEDİ ──
 * D'nin on altı satırı da antrenörlük, hakemlik, milli takım görevi ve
 * federasyon kurulu üyeliği; kaynak sözlüğünde (`Kategori::kaynaklar()`)
 * bunların hiçbirinin karşılığı yok. Spor Bilimleri adayının puanı olduğundan
 * DÜŞÜK çıkar ve yönergenin "spor alanında çalışanlar asgari koşulu Ek1-D'den
 * tamamlayabilir" alternatifi bu adaya fiilen kapalı.
 *
 * ── GİRİLMEYEN DİĞER KALEMLER ──
 *   A.2.a  yurt dışı yayınevi kitap yazarlığı — A.3.a'ya düştü (yukarıda).
 *   C.6    küratörlük, sergi komiserliği — sözlükte karşılığı yok.
 *   E.6    orkestra konserinde üyelik — düşük satırın puanı 0,5; motor tam
 *          sayı tutuyor, aşağı yuvarlanınca 0 ediyordu.
 *   E.13   radyo/TV programı yapımcılığı — kaynak C.1'e verildi.
 *   G.4    "H-index × 5" — motorun `puan` alanı sabit sayı tutuyor, formül
 *          tabanlı satır girilemez.
 *   İ.6    jürili yarışmalara katılmak (30) — 'Karma/Jürili Etkinlik'
 *          kaynağı C.2'ye düştü, kalan ayrı bir kaynak yok.
 *   'Diğer Ulusal Hakemli' dergi, 'ESCI / Scopus Dergi' ve 'Diğer Hakemli
 *          Dergi' hakemliği, 'Burs', 'Yazılım', 'Islahçı Hakkı', 'Ticarileştirme',
 *          'Tez İzleme / Jüri Üyeliği' — yönergede karşılık satırı YOK,
 *          uydurulmadı.
 *   Konservatuvar kaynakları (opera, bale, koreografi, rejisörlük, orkestra ve
 *          koro şefliği, beste ve kompozisyon türleri) — Nişantaşı'nın E
 *          bölümü icra ağırlıklı, bu satırlar tabloda yok.
 *   İDARİ GÖREV, DERS VE TOPLUMSAL KATKI bölümü yönergede HİÇ YOK; bu üç
 *          kategorinin hiçbir faaliyeti puan almıyor. Madde 8 bunları
 *          "değerlendirmede dikkate alınır" diyor ama puanlamıyor.
 *
 * ── PATENT PUANI BEŞ AŞAMADA VERİLİYOR ──
 * H bölümünün dipnotu puanı başvuru (%10), bülten (%20), araştırma raporu
 * (%30), inceleme raporu (%30) ve belge (%10) diye bölüyor. Faaliyet kaydı
 * aşama tutmuyor; satırların kendisi "almak" dediği için TESCİL EDİLMİŞ
 * varsayıldı ve tam puan yazıldı. Başvurusu süren adayın puanı olduğundan
 * YÜKSEK görünür.
 *
 * ── F.5'İN d BENDİ ──
 * "Jürili yarışmalarda danışmanlık veya jüri üyeliği — 60" kaynakta TR Dizin
 * dergileri alt şıkkının (a-b-c: 10/5/2) dördüncü bendi olarak numaralanmış,
 * oysa dergilerle ilgisi yok ve puanı bölümün on katı. Numaralandırma hatası
 * gibi duruyor ama puan İ.6'nın "yarışmaya katılmak 30" satırıyla tutarlı
 * (jüri olmak katılmanın iki katı), yani kasıtlı. Kaynaktaki kod ve puan
 * olduğu gibi korundu.
 *
 * ── TEZDEN ÜRETİLMİŞ YAYIN ──
 * Yönerge tez yayınlarını ayrı puanlamıyor. Faaliyetini "tez yayını"
 * kategorisiyle kaydeden adayın o çalışması hiçbir satıra uymaz ve 0 puan
 * alır; makale ya da kitap olarak kaydedilmeli. Kapsam notunda söylendi.
 *
 * Yönerge: yonerge/nisantasi.php
 */

return [
    'kapsam_notu' => 'Puanlar İstanbul Nişantaşı Üniversitesi EK-1 tablosundan (Senato 2025/16). '
        .'Yazar çarpanı hem kaçıncı isim olduğunuza hem yazar sayısına bağlı (1. isim tek '
        .'yazarlıda 1,00 · beş yazarlıda 0,80 · altı ve üzerinde 0,75; 6. ve sonraki isimler '
        .'daima 0,35). Sıranızı seçmezseniz o yazar sayısındaki en düşük satır uygulanır; '
        .'yazar listesini boş bırakırsanız çarpan hiç uygulanmaz ve puanınız olduğundan YÜKSEK '
        .'görünür. Atıflarda yönerge gereği çarpan uygulanmaz. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: sportif performans bölümünün '
        .'tamamı (antrenörlük, hakemlik, milli takım görevleri) kaynak sözlüğünde karşılıksız '
        .'olduğu için girilemedi — Spor Bilimleri adaylarını en çok bu etkiler; küratörlük, '
        .'orkestra üyeliği, radyo-TV yapımcılığı ve h-indeksi puanı da girilemedi. '
        .'Uluslararası ile ulusal ayrımını taşımayan kalemlerde (kitap, poster, sanat ödülü, '
        .'kitap editörlüğü, atıf, patent, kayıt, tez danışmanlığı) düşük satır kullanıldı. '
        .'Dergi hakemliği ve editörlüğünde kaydınız görevinizi değil derginin düzeyini '
        .'tuttuğu için en düşük görev satırı uygulanır. '
        .'Puanınız yalnızca patentte OLDUĞUNDAN YÜKSEK çıkabilir: yönerge puanı beş aşamaya '
        .'bölüyor, kayıt aşamayı tutmadığı için tescil tamamlanmış sayıldı. '
        .'Yönergede idari görev, verilen ders ve toplumsal katkı için puan satırı YOK; bu '
        .'faaliyetleriniz toplama girmez. Tez yayını olarak kaydettiğiniz çalışmalar da '
        .'karşılıksız kalır, makale ya da kitap olarak kaydedin.',

    // "Ortak Çalışmalar İçin Puan Dağılımı" tablosu: satır = isim sırası,
    // sütun = yazar sayısı. Her rol kendi satırını taşır.
    'yazar_katsayisi' => [
        // Atıfta yönergenin kendi dipnotu: "Bilimsel atıflarda her sıradaki
        // yazar aynı puanı alır." Proje, tez ve hakemlik satırları paylaşımı
        // zaten rolle (yürütücü / görev alan, tek başına / asıl yürütücü)
        // ayırıyor; ödül ve idari kalemler ortak çalışma değil.
        'haric' => ['atif', 'proje', 'tez_danismanligi', 'editorluk', 'odul',
            'idari_gorev', 'egitim_ogretim', 'toplumsal_katki'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.0]],
            'ilk' => ['kademeler' => [1 => 1.0, 2 => 0.95, 3 => 0.90, 4 => 0.85, 5 => 0.80], 'sonrasi' => 0.75],
            'yazar_2' => ['kademeler' => [2 => 0.85, 3 => 0.80, 4 => 0.75, 5 => 0.70], 'sonrasi' => 0.65],
            'yazar_3' => ['kademeler' => [3 => 0.75, 4 => 0.70, 5 => 0.65], 'sonrasi' => 0.60],
            'yazar_4' => ['kademeler' => [4 => 0.60, 5 => 0.55], 'sonrasi' => 0.50],
            'yazar_5' => ['kademeler' => [5 => 0.50], 'sonrasi' => 0.45],
            // "6. ve daha sonraki isimler" satırı yazar sayısından bağımsız.
            'yazar_6' => ['sonrasi' => 0.35],
            // Yönerge sorumlu yazara ayrıcalık tanımıyor; sırası bilinmeyen
            // aday o yazar sayısındaki en düşük satırı alır.
            'baslica' => ['kademeler' => [1 => 1.0, 2 => 0.85, 3 => 0.75, 4 => 0.60, 5 => 0.50], 'sonrasi' => 0.35],
            'ortak' => ['kademeler' => [1 => 1.0, 2 => 0.85, 3 => 0.75, 4 => 0.60, 5 => 0.50], 'sonrasi' => 0.35],
        ],
    ],

    'maddeler' => [
        // ══ A. BİLİMSEL YAYINLAR ══
        'A.1.a' => ['baslik' => 'WoS Book Citation Index veya Scopus taranan kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 60],
        'A.1.b' => ['baslik' => 'WoS Book Citation Index veya Scopus taranan kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 30],
        'A.3.a' => ['baslik' => 'ISBN\'li, indeksli yayınevinde kitap veya ders kitabı yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı', 'Tahkik (Tenkitli Metin)'], 'puan' => 20],
        'A.3.b' => ['baslik' => 'ISBN\'li, indeksli yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 10],
        'A.3.c' => ['baslik' => 'ISBN\'li, indeksli yayınevi kitabının çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap', 'Çeviri Kitap Bölümü'], 'puan' => 10],
        'A.4' => ['baslik' => 'Ansiklopedilerde madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 3],
        'A.5.a' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI taranan dergide makale ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 40],
        'A.5.b' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI taranan dergide vaka takdimi, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 10],
        'A.6.a' => ['baslik' => 'ESCI veya Scopus taranan dergide makale ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 30],
        'A.6.b' => ['baslik' => 'ESCI veya Scopus taranan dergide vaka takdimi, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 10],
        'A.7.a' => ['baslik' => 'Diğer uluslararası indekslerde taranan hakemli dergide makale ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 10],
        'A.7.b' => ['baslik' => 'Diğer uluslararası indekslerde taranan dergide vaka takdimi, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 5],
        'A.8.a' => ['baslik' => 'TÜBİTAK ULAKBİM TR Dizin dergisinde makale ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 20],
        'A.8.b' => ['baslik' => 'TÜBİTAK ULAKBİM TR Dizin dergisinde vaka takdimi, teknik not veya editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 10],

        // ══ B. BİLDİRİLER ══
        'B.1.a' => ['baslik' => 'WoS veya Scopus\'ta listelenen kongrede sunulan sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 6],
        'B.2.a' => ['baslik' => 'Hakem kurulu olan kongrede sunulan sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Ulusal Tam Metin', 'Davetli Konuşmacı'], 'puan' => 4],
        'B.2.b' => ['baslik' => 'Hakem kurulu olan kongrede tam metni veya özeti yayımlanan poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster', 'Ulusal Özet/Poster'], 'puan' => 2],

        // ══ C. SANAT TASARIM PERFORMANSI ══
        'C.1.a' => ['baslik' => 'Eserinizin yurt dışında satın alınması, desteklenmesi ya da yayın organlarında yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Eserin Müzeye Kabulü (Yurt Dışı)', 'Belgesel/Kısa Film (Uluslararası)'], 'puan' => 30],
        'C.1.b' => ['baslik' => 'Eserinizin yurt içinde satın alınması, desteklenmesi ya da yayın organlarında yer alması; tasarım projenizin uygulanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Eserin Müzeye Kabulü (Yurt İçi)', 'Belgesel/Kısa Film (Ulusal)', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Yayında Yer Alması / Satın Alınması', 'Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman'], 'puan' => 15],
        'C.2.a' => ['baslik' => 'Yurt dışında gerçekleşen sanat veya tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 20],
        'C.2.b' => ['baslik' => 'Yurt içinde gerçekleşen sanat veya tasarım etkinliğine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Elektronik Karma Sergi (Uluslararası)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 10],
        'C.3.a' => ['baslik' => 'Yurt dışında kişisel sanat etkinliği (sergi, festival, dinleti, gösterim)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)'], 'puan' => 20],
        'C.3.b' => ['baslik' => 'Yurt içinde kişisel sanat etkinliği (sergi, festival, dinleti, gösterim)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 10],
        'C.5' => ['baslik' => 'Jürili sanat ve tasarım etkinliğinde eserinizle ödül almak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 10],
        'C.7' => ['baslik' => 'Kamusal alanda özgün sanat yapıtı gerçekleştirmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım'], 'puan' => 10],

        // ══ E. MÜZİK VE SAHNE PERFORMANSI ══
        // (D. Sportif Performans bölümünün on altı satırının hiçbiri kaynak
        //  sözlüğünde karşılık bulmadığı için girilemedi; dosya başlığına bak.)
        'E.1.a' => ['baslik' => 'Yurt dışında orkestra eşliğinde solistlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Solistlik (Uluslararası)'], 'puan' => 20],
        'E.1.b' => ['baslik' => 'Yurt içinde orkestra eşliğinde solistlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Solistlik (Ulusal)'], 'puan' => 10],
        'E.2.a' => ['baslik' => 'Yurt dışında resital', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Uluslararası)', 'Şan Resitali (Uluslararası)'], 'puan' => 10],
        'E.2.b' => ['baslik' => 'Yurt içinde resital', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Ulusal)', 'Şan Resitali (Ulusal)'], 'puan' => 5],
        'E.3.a' => ['baslik' => 'Yurt dışında oda müziği konserinde grup üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Uluslararası)'], 'puan' => 8],
        'E.3.b' => ['baslik' => 'Yurt içinde oda müziği konserinde grup üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Ulusal)'], 'puan' => 4],
        'E.4.a' => ['baslik' => 'Yurt dışında orkestra konserinde başkemancılık', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Başkemancılık (Uluslararası)'], 'puan' => 4],
        'E.4.b' => ['baslik' => 'Yurt içinde orkestra konserinde başkemancılık', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Başkemancılık (Ulusal)'], 'puan' => 2],
        'E.5.a' => ['baslik' => 'Yurt dışında orkestra konserinde grup şefliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Grup Şefliği (Uluslararası)'], 'puan' => 2],
        'E.5.b' => ['baslik' => 'Yurt içinde orkestra konserinde grup şefliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Grup Şefliği (Ulusal)'], 'puan' => 1],
        'E.7.c' => ['baslik' => 'CD, DVD ve benzeri kayıt ortamlarında performans', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)', 'Karma Albüm / CD-DVD Katkısı'], 'puan' => 5],
        'E.11.a' => ['baslik' => 'Yurt dışında bilimsel etkinlik açılışında mini konser', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eğitici Konser Programı (Uluslararası)'], 'puan' => 8],
        'E.11.b' => ['baslik' => 'Yurt içinde bilimsel etkinlik açılışında mini konser', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eğitici Konser Programı (Ulusal)'], 'puan' => 4],
        'E.12.a' => ['baslik' => 'Yurt dışında masterclass ya da atölye yönetimi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Masterclass (Uluslararası)'], 'puan' => 8],
        'E.12.b' => ['baslik' => 'Yurt içinde masterclass ya da atölye yönetimi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Masterclass (Ulusal)', 'Müzikoloji Atölyesi', 'Eğitim Amaçlı Sanat Etkinliği'], 'puan' => 4],

        // ══ F. HAKEMLİK, EDİTÖRLÜK VE DİĞER ETKİNLİKLER ══
        'F.1' => ['baslik' => 'WoS Book Citation Index veya Scopus taranan kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 30],
        'F.3' => ['baslik' => 'ISBN\'li, indeksli yayınevi kitabında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 10],
        'F.4.c' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI taranan dergide hakemlik, kurul üyeliği ya da editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 5],
        'F.5.c' => ['baslik' => 'TÜBİTAK ULAKBİM dergisinde hakemlik, kurul üyeliği ya da editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Hakemlik', 'Yayın Kurulu Üyeliği'], 'puan' => 2],
        // Kaynakta TR Dizin şıkkının "d" bendi olarak numaralanmış; kod
        // korundu, gerekçe dosya başlığında.
        'F.5.d' => ['baslik' => 'Jürili yarışmalarda danışmanlık ya da jüri üyeliği yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 60],

        // ══ G. BİLİMSEL ATIFLAR ══
        'G.2' => ['baslik' => 'WoS veya Scopus\'ta yayınlarınıza verilen her bir atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 2],
        'G.3' => ['baslik' => 'ULAKBİM\'de ve diğer kaynaklarda yayınlarınıza verilen her bir atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'BKCI Kitap', 'Patent', 'Diğer'], 'puan' => 1],

        // ══ H. PATENTLER ══
        'H.2' => ['baslik' => 'Uluslararası patent almak', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 40],
        'H.3' => ['baslik' => 'Ulusal patent almak', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 20],
        'H.4' => ['baslik' => 'Faydalı model almak', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 20],
        'H.5' => ['baslik' => 'Endüstriyel tasarım tescili almak', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım'], 'puan' => 10],

        // ══ I. BİLİMSEL ÖDÜLLER ══
        'I.1' => ['baslik' => 'Uluslararası kurumlarca verilen bilim ve sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 80],
        'I.2' => ['baslik' => 'Ulusal bilim ve sanat ödülü (TÜBİTAK, YÖK, TÜBA GEBİP vb.)', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü', 'Ulusal Bilim/Sanat Ödülü'], 'puan' => 80],

        // ══ İ. ARAŞTIRMA PROJELERİ ══
        'İ.1.a' => ['baslik' => 'AB Çerçeve Programı projesinde (Erasmus+ dâhil) yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 100],
        'İ.1.b' => ['baslik' => 'AB Çerçeve Programı projesinde (Erasmus+ dâhil) görev almak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 50],
        'İ.2.a' => ['baslik' => 'Yurt dışı kaynaklı uluslararası katılımlı projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 60],
        'İ.2.b' => ['baslik' => 'Yurt dışı kaynaklı uluslararası katılımlı projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 30],
        'İ.3.a' => ['baslik' => 'TÜBİTAK projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 60],
        'İ.3.b' => ['baslik' => 'TÜBİTAK projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 30],
        'İ.4.a' => ['baslik' => 'Bakanlık, SSB veya TÜSEB Ar-Ge projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 60],
        'İ.4.b' => ['baslik' => 'Bakanlık, SSB veya TÜSEB Ar-Ge projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['TÜSEB'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 30],
        'İ.5.a' => ['baslik' => 'Diğer ulusal kurum ya da kuruluşlarca desteklenen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK', 'BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 10],
        'İ.5.b' => ['baslik' => 'Diğer ulusal kurum ya da kuruluşlarca desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK', 'BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 5],

        // ══ J. TEZ DANIŞMANLIĞI ══
        'J.1.b' => ['baslik' => 'Tamamlanmış doktora, sanatta yeterlik veya tıpta uzmanlık tezi yürütücülüğü', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 8],
        'J.2' => ['baslik' => 'Tamamlanmış yüksek lisans tezi yürütücülüğü', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 5],
        'K.13' => ['baslik' => 'Uluslararası spor federasyonunun yönetim, teknik, eğitim ya da hakem kurulunda görev', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Spor Federasyonu Kurul Üyeliği (Uluslararası)'], 'puan' => 10],
        'K.14' => ['baslik' => 'Ulusal spor federasyonunun yönetim, teknik, eğitim ya da hakem kurulunda görev', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Spor Federasyonu Kurul Üyeliği (Ulusal)'], 'puan' => 5],
    ],

    'gruplar' => [
        // Koşulların birebir andığı bölüm harfleri. Nokta zorunlu: 'A*' deseni
        // ileride eklenecek başka bir A-başlangıçlı kodu da yakalardı.
        'A' => ['A.*'],
        'C' => ['C.*'],
        'E' => ['E.*'],
        // Madde 4-5-6'nın "sanat, müzik ve spor alanında çalışanlar Ek1-C, D,
        // E'den tamamlayabilir" alternatifi. D bölümü girilemediği için küme
        // C ve E'den ibaret; aday notunda söylendi.
        'C-E' => ['C.*', 'E.*'],
        // Madde 6/b'nin başlıca araştırma eseri kümesi: "(1a-2a-3a-5a)".
        // 2a (yurt dışı yayınevi kitabı) 3a'ya düştüğü için burada yok.
        'BASLICA-ESER' => ['A.1.a', 'A.3.a', 'A.5.a'],
        // Madde 6/a'nın lisansüstü tez yürütücülüğü koşulu.
        'TEZ' => ['J.*'],
    ],

    // Yönerge hiçbir bölüme tavan koymuyor.
    'grup_tavanlari' => [],
];
