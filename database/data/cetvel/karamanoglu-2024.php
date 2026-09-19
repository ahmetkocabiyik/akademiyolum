<?php

/**
 * KARAMANOĞLU MEHMETBEY ÜNİVERSİTESİ — Akademik Etkinlikler ve Puanlar
 * Listesi (A-L türleri)
 * Kaynak: pdf/17536999512.karamanoglumehmetbeyuniverstesi.pdf (15 sayfa)
 *
 * KAYNAK PDF TARANMIŞ; 300 dpi görüntüden `tesseract -l tur` ile okundu.
 * OCR "%" işaretini yer yer "90", "96" ya da "©0" olarak okumuş; koşul
 * metnindeki bütün yüzdeler bu düzeltmeyle alındı (ör. "9050'si" → %50).
 *
 * MADDE KODLARI yönergenin kendi harf-numara kodları. Koşullar tabloya
 * TÜR HARFİYLE atıf yapıyor ("A, C, F, H ve İ türü aktivitelerden en az
 * %50"), bu yüzden harf grupları `gruplar` altında ayrı ayrı duruyor.
 *
 * ── EN ÇOK PUAN KAYBETTİREN KARARLAR ──
 *   h-İNDEKSİ KOŞULLARI EŞİKTE `beyan` OLARAK DURUYOR. Yönerge dört alan
 *       grubunun her kadrosunda "WoS h-indeksi en az N" seçeneğini bir
 *       alternatif olarak sunuyor; h-indeksi faaliyet değil profil
 *       ölçütü olduğu için cetvelde satırı yok.
 *   A-12 (hakemli olmayan sanatsal ve mesleki dergilerdeki yazılar, 3),
 *       G-4 (danışmanı olmadığı tez savunma jürilerinde bulunma, 5) ve
 *       J-7 (üniversite komisyonlarında bir yıl görev, 5) dışında bütün
 *       satırlar girildi; bu üçünün kayıtta ayırt edici etiketi yok.
 *   G bölümünün "devam eden tezlerde puanın üçte biri" kuralı
 *       uygulanmıyor; kayıt yalnız tamamlanmış tezi tutuyor.
 *   L bölümünün on alt başlığından yalnız kayıtta karşılığı olanlar
 *       girildi; film ekibi, görsel-işitsel yaratıcı kadro ve sahne
 *       tasarımı alt kırılımlarının bir bölümü karşılıksız kaldı.
 *
 * ── AYNI ETİKETE DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   E bölümünde baş editörlük (50/30/20), yardımcı editörlük ve yayın
 *       kurulu üyeliği (25/15/10) ile hakemlik (10/8/5) dergi türüne göre
 *       üç kademe; "Yayın Kurulu Üyeliği" ve "Hakemlik" etiketleri tek
 *       olduğu için en düşükten sayılıyor.
 *   H bölümünün "yürütücü puanın %100'ünü, araştırmacı %50'sini alır"
 *       kuralı satır puanına gömüldü: her proje türü için yürütücü ve
 *       araştırmacı ayrı satır oldu.
 *   I-5 (fikri mülkiyet, prototip, faydalı model, üretim izni, tescil,
 *       100) ile I-4 (yurt içi patent, 50) kayıtta ayrılamayan etiketleri
 *       paylaşmıyor; ikisi de ayrı girildi.
 *   L bölümünde uluslararası (60), yurt dışı (40) ve ulusal (30) üç
 *       kademe; kayıt yalnız uluslararası/ulusal ayrımı taşıdığı için
 *       yurt dışı kademesi ulusal değerden sayılıyor.
 *
 * ── YAZAR ÇARPANI YOK ──
 * Yönerge çok yazarlı eserlerde puanı bölen bir kural taşımıyor; yalnız
 * "başlıca yazar" tanımı var (MADDE 4/ç). Cetvelde `yazar_katsayisi`
 * tanımlanmadı, puanlar yazar sayısından bağımsız.
 *
 * Yönerge: yonerge/karamanoglu.php
 *
 * KİTAP BÖLÜMÜNDE KAPSAM AYRIMI (19.09.2026): C-3 "uluslararası yayınevleri
 * tarafından yayımlanan kitap bölümü" (40), C-4 ulusal karşılığı (20); E-7 ile
 * E-8 aynı ayrımı kitap editörlüğünde yapıyor (40/20). Üst satırlar yalnız
 * BKCI/Scopus etiketiyle yazıldığı için indekssiz uluslararası kitap bölümü 40
 * yerine 20, editörlüğü 40 yerine 20 puandaydı.
 *
 * C-1 (BKCI kapsamındaki yayınevi, 90) İNDEKSE bağlı olduğu için BKCI
 * etiketinde kaldı; C-2 zaten "ulusal ya da uluslararası … Türkçe ya da
 * yabancı dilde" diyen TORBA satır ve genel etiketi doğru taşıyor.
 */
$OZGUN = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];
$WOS = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];

$maddeler = [
    // ══ A. MAKALELER ══
    'A-1' => ['baslik' => 'SCI-Expanded ya da SSCI kapsamında taranan Q1 dilimli dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $OZGUN, 'puan' => 70],
    'A-2' => ['baslik' => 'SCI-Expanded ya da SSCI kapsamında taranan Q2 dilimli dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $OZGUN, 'puan' => 60],
    'A-3' => ['baslik' => 'SCI-Expanded ya da SSCI kapsamında taranan Q3 dilimli dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $OZGUN, 'puan' => 50],
    'A-4' => ['baslik' => 'SCI-Expanded ya da SSCI kapsamında taranan Q4 dilimli dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $OZGUN, 'puan' => 40],
    'A-5' => ['baslik' => 'AHCI kapsamında taranan dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => $OZGUN, 'puan' => 60],
    'A-6' => ['baslik' => 'Uluslararası alan indeksleri tarafından taranan dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $OZGUN, 'puan' => 40],
    'A-7' => ['baslik' => 'TR Dizin kapsamında taranan dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $OZGUN, 'puan' => 35],
    'A-8' => ['baslik' => 'Diğer ulusal ya da uluslararası hakemli dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $OZGUN, 'puan' => 30],
    'A-9' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergide teknik not, editöre mektup, tartışma, vaka takdimi ya da özet', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $KISA, 'puan' => 30],
    'A-10' => ['baslik' => 'Diğer uluslararası indekslerde taranan dergide teknik not, editöre mektup, tartışma, vaka takdimi ya da özet', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 20],
    'A-11' => ['baslik' => 'Ulusal hakemli dergide teknik not, editöre mektup, tartışma, vaka takdimi ya da özet', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 10],

    // ══ B. BİLDİRİLER ══
    'B-1' => ['baslik' => 'Uluslararası bilimsel toplantıda sözlü sunulan ve tam metni yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 20],
    'B-2' => ['baslik' => 'Uluslararası bilimsel toplantıda poster olarak sunulan ya da özet olarak yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 10],
    'B-3' => ['baslik' => 'Ulusal bilimsel toplantıda sözlü sunulan ve tam metni yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 10],
    'B-4' => ['baslik' => 'Ulusal bilimsel toplantıda poster olarak sunulan ya da özet olarak yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 5],

    // ══ C. KİTAPLAR ══
    'C-1' => ['baslik' => 'Web of Science Book Citation Index kapsamındaki yayınevinde yayımlanan kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 90],
    'C-2' => ['baslik' => 'Alanında ulusal ya da uluslararası yayımlanan kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı', 'Tahkik (Tenkitli Metin)'], 'puan' => 70],
    'C-3' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanan kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Uluslararası Kitap Bölümü'], 'puan' => 40],
    'C-4' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanan kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 20],

    // ══ D. ÇEVİRİLER ══
    'D-1' => ['baslik' => 'Alanında yayımlanmış kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 30],
    'D-2' => ['baslik' => 'Alanında yayımlanmış makale ya da kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 10],

    // ══ E. EDİTÖRLÜK VE HAKEMLİK ══
    'E-1' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergide baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 50],
    'E-2' => ['baslik' => 'Diğer uluslararası indekslerde taranan dergide baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 30],
    'E-3' => ['baslik' => 'Diğer bilimsel, sanatsal ya da mesleki hakemli dergide baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 20],
    'E-6' => ['baslik' => 'Dergide yardımcı editörlük ya da yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 10],
    'E-7' => ['baslik' => 'Alanında yurt dışında yayımlanan kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Uluslararası Kitap Editörlüğü'], 'puan' => 40],
    'E-8' => ['baslik' => 'Alanında yurt içinde yayımlanan kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Ulusal Kitap Editörlüğü', 'Kitap Editörlüğü'], 'puan' => 20],
    'E-11' => ['baslik' => 'Dergi, kitap ya da proje hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 5],

    // ══ F. ATIFLAR ══
    'F-1' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki yayınlarda eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 5],
    'F-4' => ['baslik' => 'Web of Science Book Citation Index kapsamındaki kitaplarda eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 5],
    'F-3' => ['baslik' => 'Hakemli dergilerde ve yurt içinde yayımlanan kitaplarda eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent', 'ESCI', 'Scopus'], 'puan' => 2],

    // ══ G. TEZ YÖNETİMİ ══
    'G-1' => ['baslik' => 'Yönetiminizde tamamlanmış doktora, tıpta uzmanlık ya da sanatta yeterlik tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 30],
    'G-2' => ['baslik' => 'Yönetiminizde tamamlanmış yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 10],
    'G-3' => ['baslik' => 'İkinci danışman olarak görev aldığınız tamamlanmış tez', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi', 'Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 10],
    'G-4' => ['baslik' => 'Tez izleme komitesi ya da tez savunma jürisi üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 5],

    // ══ H. SONUÇLANDIRILMIŞ ARAŞTIRMA PROJELERİ ══
    'H-1.y' => ['baslik' => 'Avrupa Birliği tarafından desteklenen araştırma projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 80],
    'H-1.a' => ['baslik' => 'Avrupa Birliği tarafından desteklenen araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 40],
    'H-2.y' => ['baslik' => 'TÜBİTAK tarafından desteklenen araştırma projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 60],
    'H-2.a' => ['baslik' => 'TÜBİTAK tarafından desteklenen araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 30],
    'H-4.y' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen diğer projede yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 20],
    'H-4.a' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen diğer projede araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
    'H-5.y' => ['baslik' => 'Ulusal kuruluşlarca desteklenen diğer projede yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK', 'BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 10],
    'H-5.a' => ['baslik' => 'Ulusal kuruluşlarca desteklenen diğer projede araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK', 'BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 5],

    // ══ I. ÖDÜL, PATENT, ÜRÜN ══
    'I-1' => ['baslik' => 'Alanında uluslararası bilimsel nitelikli ödül almak', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 80],
    'I-2' => ['baslik' => 'Alanında ulusal bilimsel nitelikli ödül almak', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü', 'Yarışma Derecesi / Mansiyon', 'Burs'], 'puan' => 40],
    'I-3' => ['baslik' => 'Yurt dışında patentlenmiş buluş', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 100],
    'I-4' => ['baslik' => 'Yurt içinde patentlenmiş buluş', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 50],
    'I-5' => ['baslik' => 'Fikri mülkiyet hak sahipliği olan ürün, prototip, faydalı model, üretim izni ya da tescil', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 100],
    'I-6' => ['baslik' => 'Spin-off, start-up ya da teknoparkta şirket kurmak', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 100],

    // ══ J. DİĞER ETKİNLİKLER ══
    'J-5' => ['baslik' => 'Alanıyla ilgili panel, konferans, seminer ya da söyleşide konuşmacı veya panelist olarak görev almak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 5],
    'J-7' => ['baslik' => 'Üniversitenin kalite, BAP ve benzeri komisyonlarında bir yıl süreyle görev almak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği', 'Anabilim Dalı Başkanı / Koordinatörlük', 'Bölüm Başkanı', 'Bölüm Başkan Yardımcısı', 'Dekan / Enstitü-YO Müdürü', 'Dekan Yrd. / Müdür Yrd.', 'Uygulama ve Araştırma Merkezi Müdürü', 'Rektör', 'Rektör Yardımcısı'], 'puan' => 5],
    'J-6' => ['baslik' => 'Toplumsal katkı çalışması, kamu ya da sivil toplum kuruluşu danışmanlığı', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi', 'Kamu/STK Danışmanlığı', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 5],

    // ══ K. ÖĞRETİM FAALİYETLERİ (en çok 30 puan) ══
    'K-1' => ['baslik' => 'Son üç yılda verilen ön lisans, lisans ya da lisansüstü ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 3],

    // ══ L. SANAT VE TASARIM ETKİNLİKLERİ ══
    'L.1.1' => ['baslik' => 'Yurt dışında tanınmış müze, kültür merkezi ya da sanat galerisinde kişisel sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)'], 'puan' => 60],
    'L.1.2' => ['baslik' => 'Yurt içinde tanınmış müze, kültür merkezi ya da sanat galerisinde kişisel sergi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 30],
    'L.2.1' => ['baslik' => 'Yurt dışı tanınmış müze ya da büyük koleksiyonlarda yapıtınızın yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)'], 'puan' => 60],
    'L.2.2' => ['baslik' => 'Yurt içi tanınmış müze ya da büyük koleksiyonlarda yapıtınızın yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)'], 'puan' => 40],
    'L.3' => ['baslik' => 'Karma ya da jürili sanat ve tasarım etkinliğine katılım', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Elektronik Karma Sergi (Uluslararası)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 30],
    'L.4' => ['baslik' => 'Tasarım alanında üretime girmiş çalışma ya da koleksiyon', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım', 'Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip'], 'puan' => 30],
    'L.5' => ['baslik' => 'Film gösterimi, belgesel ya da kısa film', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)', 'Yönetmenlik (Sahne/Ekran)'], 'puan' => 30],
    'L.6' => ['baslik' => 'Görsel-işitsel tasarım, gösteri ya da defile', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Dansçı / Performans İcracısı (Uluslararası)', 'Dansçı / Performans İcracısı (Ulusal)', 'Koreografi'], 'puan' => 30],
    'L.7' => ['baslik' => 'Sahne tasarımı ile ilgili etkinlikler', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne Tasarımı (Dekor, Kostüm, Işık)', 'Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)'], 'puan' => 30],
    'L.8.1' => ['baslik' => 'Uluslararası gösteride orkestra ile solistlik ya da temsil, koreografi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Solistlik (Uluslararası)', 'Opera Birinci Rol (Uluslararası)', 'Bale Başrol (Uluslararası)', 'Orkestra Şefliği (Uluslararası)', 'Koro Şefliği (Uluslararası)', 'Opera Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Uluslararası)', 'Rejisörlük (Uluslararası)', 'Tüm Perde Koreograflığı (Uluslararası)'], 'puan' => 60],
    'L.8.3' => ['baslik' => 'Uluslararası gösteride solo resital ya da solo dans', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Uluslararası)', 'Şan Resitali (Uluslararası)', 'Bale Solist Rol (Uluslararası)', 'Bölüm Koreograflığı (Uluslararası)', 'Bale/Dans Koreograflığı (Uluslararası)'], 'puan' => 40],
    'L.8.11' => ['baslik' => 'Ulusal gösteride orkestra ile solistlik, temsil ya da koreografi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Solistlik (Ulusal)', 'Opera Birinci Rol (Ulusal)', 'Bale Başrol (Ulusal)', 'Orkestra Şefliği (Ulusal)', 'Koro Şefliği (Ulusal)', 'Opera Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Ulusal)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Tüm Perde Koreograflığı (Ulusal)'], 'puan' => 30],
    'L.8.13' => ['baslik' => 'Ulusal gösteride solo resital ya da solo dans', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Ulusal)', 'Şan Resitali (Ulusal)', 'Bale Solist Rol (Ulusal)', 'Bölüm Koreograflığı (Ulusal)', 'Bale/Dans Koreograflığı (Ulusal)'], 'puan' => 20],
    'L.8.14' => ['baslik' => 'Oda müziği konseri, bestelenmiş yapıtın seslendirilmesi ya da grup dansı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Uluslararası)', 'Oda Müziği Grup Üyeliği (Ulusal)', 'Corps de Ballet (Uluslararası)', 'Corps de Ballet (Ulusal)', 'Bandrollü Kayıt (CD/DVD)', 'Albüm / Konser Kaydı', 'Karma Albüm / CD-DVD Katkısı'], 'puan' => 15],
    'L.8.15' => ['baslik' => 'Gösteride orkestra ya da koro üyesi olarak yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra / Koro Üyeliği', 'Başkemancılık (Uluslararası)', 'Başkemancılık (Ulusal)', 'Grup Şefliği (Uluslararası)', 'Grup Şefliği (Ulusal)'], 'puan' => 2],
    'L.9' => ['baslik' => 'Sanat ve tasarım etkinliklerinde jüri üyeliği, küratörlük ya da masterclass', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)', 'Masterclass (Uluslararası)', 'Masterclass (Ulusal)', 'Eğitim Amaçlı Sanat Etkinliği', 'Müzikoloji Atölyesi', 'Eğitici Konser Programı (Uluslararası)', 'Eğitici Konser Programı (Ulusal)', 'Eserin Haber Olması (Uluslararası)', 'Eserin Haber Olması (Ulusal)', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman', 'Opera İkinci Rol (Uluslararası)', 'Opera İkinci Rol (Ulusal)', 'Oratoryo/Kantat Solistliği (Uluslararası)', 'Oratoryo/Kantat Solistliği (Ulusal)', 'Rejisör Yardımcılığı (Uluslararası)', 'Rejisör Yardımcılığı (Ulusal)', 'Rejisör Yardımcılığı (Konservatuvar)', 'Sahneleme/Repetitörlük — Tüm Perde (Uluslararası)', 'Sahneleme/Repetitörlük — Tüm Perde (Ulusal)', 'Sahneleme/Repetitörlük — Bölüm (Uluslararası)', 'Sahneleme/Repetitörlük — Bölüm (Ulusal)', 'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Küçük Ölçekli Orkestra Eseri', 'Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Opera/Bale Kompozisyonu', 'Orkestralı Sahne Eseri', 'Sahne/Ekran Müziği', 'Eğitim Müziği Albümü', 'Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi'], 'puan' => 10],
    'L.17.6' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Ulusal)'], 'puan' => 15],
    'L.17.3' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 30],
    'L.17.2' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 15],
    // Kaynak L.17.17 uluslararası 8, L.17.18 ULUSAL 5 diyor.
    'L.17.18' => ['baslik' => 'Uluslararası bilimsel ya da sanatsal toplantıda oturum başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Uluslararası)'], 'puan' => 8],
    'L.17.18-ulusal' => ['baslik' => 'Ulusal bilimsel ya da sanatsal toplantıda oturum başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Ulusal)'], 'puan' => 5],
];

$A = ['A-1', 'A-2', 'A-3', 'A-4', 'A-5', 'A-6', 'A-7', 'A-8', 'A-9', 'A-10', 'A-11'];
$B = ['B-1', 'B-2', 'B-3', 'B-4'];
$C = ['C-1', 'C-2', 'C-3', 'C-4'];
$D = ['D-1', 'D-2'];
$F = ['F-1', 'F-4', 'F-3'];
$G = ['G-1', 'G-2', 'G-3', 'G-4'];
$H = ['H-1.y', 'H-1.a', 'H-2.y', 'H-2.a', 'H-4.y', 'H-4.a', 'H-5.y', 'H-5.a'];
$I = ['I-1', 'I-2', 'I-3', 'I-4', 'I-5', 'I-6'];
$L = ['L.1.1', 'L.1.2', 'L.2.1', 'L.2.2', 'L.3', 'L.4', 'L.5', 'L.6', 'L.7',
    'L.8.1', 'L.8.3', 'L.8.11', 'L.8.13', 'L.8.14', 'L.8.15', 'L.9'];

return [
    'kapsam_notu' => 'Puanlar Karamanoğlu Mehmetbey Üniversitesi Öğretim Üyeliğine Yükseltilme '
        .'ve Atanma Yönergesinin Akademik Etkinlikler ve Puanlar Listesinden. Kaynak PDF '
        .'taranmış; 300 dpi görüntüden OCR ile okundu. YÖNERGE ÇOK YAZARLI ESERLERDE PUANI '
        .'BÖLMÜYOR: yalnız "başlıca yazar" tanımı var, puanlar yazar sayısından bağımsız. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: h-indeksi koşulları faaliyet değil '
        .'profil ölçütü olduğu için cetvelde satırı yok (eşiklerde beyan olarak duruyor); '
        .'A-12 (hakemsiz sanatsal ve mesleki dergilerdeki yazılar, 3) girilmedi; G bölümünün '
        .'"devam eden tezlerde puanın üçte biri" kuralı uygulanmıyor; L bölümünün film ekibi ve '
        .'görsel-işitsel yaratıcı kadro alt kırılımlarının bir bölümü kayıtta karşılıksız kaldı. '
        .'E bölümünde yardımcı editörlük ve yayın kurulu üyeliği (25/15/10) ile hakemlik '
        .'(10/8/5) dergi türüne göre üç kademe; etiket ayrımı olmadığı için en düşükten '
        .'sayılıyor. L bölümünde uluslararası (60), yurt dışı (40) ve ulusal (30) üç kademe '
        .'var; kayıt yalnız uluslararası/ulusal ayrımı taşıdığı için yurt dışı kademesi ulusal '
        .'değerden sayılıyor. K bölümünün 30 puanlık tavanı uygulanıyor.',

    'yazar_katsayisi' => null,

    'maddeler' => $maddeler,

    'gruplar' => [
        'TUM' => array_keys($maddeler),
        'A' => $A,
        'K' => ['K-1'],
        // Koşulların harf harf andığı tür kümeleri.
        'ACFHI' => array_merge($A, $C, $F, $H, $I),
        'ABCFHI' => array_merge($A, $B, $C, $F, $H, $I),
        'ACFHIL' => array_merge($A, $C, $F, $H, $I, $L),
        'ABCFHIL' => array_merge($A, $B, $C, $F, $H, $I, $L),
        'ABCFGHI' => array_merge($A, $B, $C, $F, $G, $H, $I),
        'ABCDFGHIL' => array_merge($A, $B, $C, $D, $F, $G, $H, $I, $L),
        // Yayın koşullarının andığı dergi kümeleri.
        'WOS' => ['A-1', 'A-2', 'A-3', 'A-4', 'A-5'],
        'Q1' => ['A-1'],
        'Q2' => ['A-2'],
        'Q3' => ['A-3'],
        'ALAN-INDEKSI' => ['A-6'],
        'HAKEMLI-MAKALE' => ['A-1', 'A-2', 'A-3', 'A-4', 'A-5', 'A-6', 'A-7', 'A-8'],
        // "TÜBİTAK, AB veya dış destekli en az dokuz ay süreli proje".
        'PROJE-9AY' => ['H-1.y', 'H-1.a', 'H-2.y', 'H-2.a', 'H-4.y', 'H-4.a', 'H-5.y', 'H-5.a'],
        'KISISEL-SERGI' => ['L.1.1', 'L.1.2'],
        'KITAP' => ['C-1', 'C-2'],
    ],

    'grup_tavanlari' => ['K' => 30],
];
