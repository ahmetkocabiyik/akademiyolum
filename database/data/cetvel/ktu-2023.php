<?php

/**
 * KARADENİZ TEKNİK ÜNİVERSİTESİ — EK-15 "Değerlendirmede Kullanılacak
 * Puanlar Tablosu" ve EK-2…EK-14 fakülte tavanları
 * Kaynak: pdf/17536999312.karadenizteknikuniverstesi.pdf (48 sayfa,
 *         Senato 09.02.2023/336-5, değişiklik 17.10.2023/342)
 *
 * KAYNAK TARANMIŞ GÖRÜNTÜ PDF'İ: `pdftotext` 48 bayt üretiyor, hazır OCR
 * metni `pdf-ocr/` altında. OCR puan sütununu düzenli bozduğu için
 * ("Q1" → "Ol", "100 P" → "1000 P", "15 P" → "I5 P") hem EK-15 hem
 * EK-2…EK-14 tablolarının TAMAMI sayfa GÖRÜNTÜSÜNDEN okundu.
 *
 * TEK PUAN TABLOSU, DOKUZ VARYANT. EK-15 bütün fakülteler için ortak;
 * fakülteye göre değişen şey her bölümün "En Fazla" tavanı (EK-2…EK-14).
 * On üç fakülte üç tavan ailesine iniyor:
 *
 *   fen     → Mühendislik, Of Teknoloji, Fen, Eczacılık, Orman,
 *             Sağlık Bilimleri, Diş Hekimliği, Tıp, Sürmene Deniz Bilimleri
 *   sosyal  → Edebiyat, İktisadi ve İdari Bilimler
 *   mimarlik→ Mimarlık (Orman'ın Peyzaj Mimarlığı Bölümü de buraya tabi)
 *
 * Fakülteler arasındaki geri kalan fark (dr. öğr. üyesinin makale barajı
 * 50/70/80, Tıp'ın toplantı barajı) tavan değil BARAJ farkı; yönergede.
 *
 * EK-14 (enstitü, yüksekokul, MYO) kendi sayısını vermiyor: "adayın
 * bulunduğu bilim alanı ile ilgili fakülte koşulları geçerlidir".
 *
 * "TAM MAKALE / DİĞER MAKALE" AYRIMI `turler` EKSENİNDE. Kaynak her dergi
 * kademesini ikiye ayırıyor (Q1 45/35, Q2 35/30 …) ve dipnotu "diğer
 * makale"yi derleme, teknik not, kısa makale, vaka takdimi, editöre mektup,
 * özet, kitap kritiği ve araştırma notu diye tanımlıyor — yani sözlüğün
 * `ozgun_makale` dışındaki üç türünün tamamı. Bu yüzden her kademe İKİ
 * satır: tam makale `ozgun_makale`, diğer makale öteki üç tür.
 *
 * KESİRLİ PUANLAR AŞAĞI YUVARLANDI (§0): atıf 2,5 → 2 · 1,5 → 1;
 * hakemlik 1,5 → 1; kurul üyeliği 1,5 → 1.
 *
 * GİRİLEMEYEN:
 *   · "En fazla iki kitap", "aynı kitapta en fazla iki bölüm", "aynı
 *     toplantıda sunulan bildirilerden yalnızca ikisi" gibi KALEME ÖZGÜ
 *     sayı sınırları — motor tavanı gruba uyguluyor, esere değil.
 *   · Proje puanlarının bütçe kademeleri (kamu projesinde 45/40/30/25/20).
 *     Faaliyet kaydı proje bütçesini taşımıyor; her fon etiketi kendi
 *     kademelerinin EN DÜŞÜĞÜNE yazıldı.
 *   · "Ar-Ge niteliğinde olmayan projelerde puanın 3/5'i" indirimi.
 *   · Doktor Öğretim Üyesi'nin "KTÜ 50/d doktora mezunu" ve "yeniden
 *     atanma" sütunları (motor bu iki kadroyu ayırt etmiyor).
 */
$yazarKatsayisi = [
    // Çizelge 1 "Ortak Çalışmalar İçin Puan Dağılımı (Kitaplar hariç)".
    // Başlıca yazar SIRAYA BAKILMAKSIZIN tam puan alıyor (1. maddenin
    // birinci dipnotu), bu yüzden `baslica` kademesiz 1,0.
    // Kitaplarda çizelge geçerli değil: "birden fazla yazar ve editörlük
    // olması durumunda puanlar EŞİT olarak bölünür" → `kitap` kategorisi
    // düz 1/n ile hesaplanıyor.
    'haric' => ['atif', 'proje', 'patent', 'tez_danismanligi', 'egitim_ogretim',
        'idari_gorev', 'odul', 'editorluk', 'toplumsal_katki', 'sanatsal_etkinlik', 'diger'],
    'kategoriler' => [
        'kitap' => ['sonrasi_pay' => 1.0],
    ],
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.0]],
        'baslica' => ['kademeler' => [1 => 1.0], 'sonrasi' => 1.0],
        'ilk' => ['kademeler' => [1 => 1.0, 2 => 0.95, 3 => 0.90, 4 => 0.85, 5 => 0.80], 'sonrasi' => 0.75],
        'yazar_2' => ['kademeler' => [2 => 0.85, 3 => 0.80, 4 => 0.75, 5 => 0.70], 'sonrasi' => 0.65],
        'yazar_3' => ['kademeler' => [3 => 0.75, 4 => 0.70, 5 => 0.65], 'sonrasi' => 0.60],
        'yazar_4' => ['kademeler' => [4 => 0.60, 5 => 0.55], 'sonrasi' => 0.50],
        'yazar_5' => ['kademeler' => [5 => 0.50], 'sonrasi' => 0.45],
        'yazar_6' => ['sonrasi' => 0.35],
        // Sırası belirtilmemiş ortak yazar: çizelgenin en düşük satırı
        // ("9. ve daha sonraki isimler" 25).
        'ortak' => ['kademeler' => [1 => 1.0, 2 => 0.85, 3 => 0.75, 4 => 0.60, 5 => 0.50], 'sonrasi' => 0.25],
    ],
];

$TAM = ['ozgun_makale'];
$DIGER = ['derleme', 'kisa_makale', 'vaka_teknik_not'];

$maddeler = [
    // ══ 1. MAKALE ══
    // Kaynak her dergi kademesini TAM MAKALE / DİĞER MAKALE diye ikiye
    // bölüyor ve dipnotta tanımlıyor: "Tam makale: verilerin ayrıntılı
    // verildiği ve tartışıldığı 'diğer makale' kapsamı dışındaki araştırma
    // makalesi; Diğer makale: teknik not, kısa (brief communication), yorum,
    // vaka takdimi, vaka serisi, editöre mektup, özet, kitap kritiği,
    // araştırma notu, DERLEME makale." Yani "diğer makale" sözlüğün
    // `ozgun_makale` DIŞINDAKİ üç türünün tamamını kapsıyor.
    '1.a' => ['baslik' => 'Q1 dergide yayımlanmış tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $TAM, 'puan' => 45],
    '1.b' => ['baslik' => 'Q2 dergide yayımlanmış tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $TAM, 'puan' => 35],
    '1.c' => ['baslik' => 'Q3 dergide yayımlanmış tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $TAM, 'puan' => 30],
    '1.ç' => ['baslik' => 'Q4 ya da AHCI kapsamındaki dergide yayımlanmış tam makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => $TAM, 'puan' => 25],
    '1.e' => ['baslik' => 'ESCI ya da Scopus indeksindeki dergide yayımlanmış tam makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $TAM, 'puan' => 20],
    '1.f' => ['baslik' => 'Diğer hakemli uluslararası ya da TR Dizin kapsamındaki dergide tam makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => 15],
    '1.a-d' => ['baslik' => 'Q1 dergide yayımlanmış derleme, kısa makale, vaka takdimi, editöre mektup ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $DIGER, 'puan' => 35],
    '1.b-d' => ['baslik' => 'Q2 dergide yayımlanmış derleme, kısa makale, vaka takdimi, editöre mektup ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $DIGER, 'puan' => 30],
    '1.c-d' => ['baslik' => 'Q3 dergide yayımlanmış derleme, kısa makale, vaka takdimi, editöre mektup ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $DIGER, 'puan' => 25],
    '1.ç-d' => ['baslik' => 'Q4 ya da AHCI kapsamındaki dergide yayımlanmış derleme, kısa makale, vaka takdimi, editöre mektup ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => $DIGER, 'puan' => 20],
    '1.e-d' => ['baslik' => 'ESCI ya da Scopus indeksindeki dergide yayımlanmış derleme, kısa makale, vaka takdimi, editöre mektup ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $DIGER, 'puan' => 15],
    '1.f-d' => ['baslik' => 'Diğer hakemli uluslararası ya da TR Dizin kapsamındaki dergide derleme, kısa makale, vaka takdimi, editöre mektup ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'], 'turler' => $DIGER, 'puan' => 5],
    // 1.g-ı: dizinli dergide yayımlanmış kongre bildirisinin TAM METNİ/ÖZETİ
    // (Q1 20/10 · Q2 15/8 · Q3 10/5 · Q4 5/3). Etiket "Tam Metin (CPCI)"
    // olduğu için tam metin kolonunun en düşüğü (Q4, 5) yazıldı; önce iki
    // kolonun birden en düşüğü (özet Q4, 3) alınmıştı.
    '1.g' => ['baslik' => 'Dizinli dergide yayımlanmış kongre bildirisi tam metni', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 5],

    // ══ 2. KİTAP ══
    '2.a' => ['baslik' => 'WoS Book Citation Index kapsamındaki kitapta yazarlık ya da editörlük', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 60],
    '2.b' => ['baslik' => 'Tanınmış yayınevince yayımlanmış kitapta yazarlık', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı'], 'puan' => 40],
    '2.c' => ['baslik' => 'WoS Book Citation Index kapsamındaki kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 40],
    '2.ı' => ['baslik' => 'Tanınmış yayınevince yayımlanmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 10],
    '2.g' => ['baslik' => 'Tanınmış yayınevince yayımlanmış kitapta editörlük ya da çeviri editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 20],
    '2.j' => ['baslik' => 'Bilimsel kitap çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 15],
    '2.k' => ['baslik' => 'Bilimsel kitap bölümü çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 10],
    '2.l' => ['baslik' => 'Tahkik, neşir, araştırma notu ya da detaylı kitap kritiği', 'kategori' => 'kitap', 'kaynaklar' => ['Tahkik (Tenkitli Metin)'], 'puan' => 5],

    // ══ 3. ATIF ══
    // Kaynağın 3. ATIF tablosu (sayfa 42, görüntüden okundu — PDF taranmış):
    //   a) SCI, SCI-Exp, SSCI, AHCI          3
    //   b) (a) dışındaki WOS all databases / SCOPUS   3/2
    // Yani ESCI (WOS all databases içinde) 3, SCOPUS 2. Sözlükteki
    // `ESCI / Scopus` etiketi ikisini birden taşıdığı için §0 uyarınca DÜŞÜK
    // olan (2) yazıldı; ESCI atfı olan aday 3 yerine 2 görür.
    '3.a' => ['baslik' => 'SCI, SCI-Expanded, SSCI ya da AHCI dergilerinde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 3],
    '3.b' => ['baslik' => 'WoS All Databases ya da Scopus kapsamındaki dergilerde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 2],
    '3.ç' => ['baslik' => 'WoS Book Citation Index kapsamındaki kitapta yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 3],
    '3.c' => ['baslik' => 'TR Dizin ya da diğer dergilerde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer'], 'puan' => 1],
    '3.f' => ['baslik' => 'İncelemeli patentte yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Patent'], 'puan' => 1],

    // ══ 4. TEZ DANIŞMANLIĞI ══
    '4.b' => ['baslik' => 'Tamamlanmış doktora, uzmanlık ya da sanatta yeterlik tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 20],
    '4.c' => ['baslik' => 'Tamamlanmış tezli yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 10],
    '10.B.j' => ['baslik' => 'Lisansüstü tez jüri üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 1],

    // ══ 5. BİLİMSEL ARAŞTIRMA PROJESİ ══
    '5.b' => ['baslik' => 'AB Çerçeve Programı destekli projede koordinatörlük ya da yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'puan' => 20],
    '5.ç' => ['baslik' => 'Diğer uluslararası kuruluş destekli projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'puan' => 15],
    '5.e' => ['baslik' => 'TÜBİTAK ya da TÜBA destekli projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'puan' => 10],
    '5.g' => ['baslik' => 'Kamu kuruluşu destekli Ar-Ge projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'TÜSEB'], 'puan' => 10],
    '5.h' => ['baslik' => 'Yükseköğretim kurumu destekli projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'puan' => 5],
    '5.i' => ['baslik' => 'Özel kuruluş destekli Ar-Ge ya da tasarım projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'puan' => 5],
    '5.d' => ['baslik' => 'TÜBİTAK 2209 gibi öğrenci projesinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'puan' => 3],

    // ══ 6. BİLİMSEL TOPLANTI ══
    '6.ç' => ['baslik' => 'Bilimsel toplantıda davetli konuşmacı olarak sunum', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 8],
    '6.b' => ['baslik' => 'Uluslararası bilimsel toplantıda sözlü sunulmuş tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin'], 'puan' => 12],
    '6.c' => ['baslik' => 'Uluslararası bilimsel toplantıda özet ya da poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 4],
    '6.d' => ['baslik' => 'Ulusal bilimsel toplantıda sözlü sunulmuş tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 6],
    '6.e' => ['baslik' => 'Ulusal bilimsel toplantıda özet ya da poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 2],

    // ══ 7. EDİTÖRLÜK ve HAKEMLİK ══
    '7.a' => ['baslik' => 'SCI, SSCI, AHCI ya da Scopus dergisinde dergi editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 20],
    '7.c' => ['baslik' => 'ESCI ya da Scopus dergisinde dergi editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 8],
    '7.ç' => ['baslik' => 'Diğer hakemli dergide dergi editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 5],
    '7.g' => ['baslik' => 'Dergi hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 1],

    // ══ 8. ÖDÜL ══
    '8.a' => ['baslik' => 'TÜBA ya da TÜBİTAK bilim, teşvik, sanat veya araştırma ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 60],
    '8.b' => ['baslik' => 'Yurt dışı kurum ya da kuruluştan alınan bilim, sanat veya araştırma ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 50],
    '8.c' => ['baslik' => 'Yurt içi kamu kurumundan alınan ödül ya da YÖK ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'YÖK Ödülü'], 'puan' => 25],
    '8.ç' => ['baslik' => 'Meslek alanına yönelik yarışma ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 10],

    // ══ 9. PATENT, FAYDALI MODEL, TASARIM ══
    '9.a' => ['baslik' => 'Kendisi buluş sahibi olmak şartıyla ticarileştirilmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 70],
    '9.b' => ['baslik' => 'Uluslararası tescillenmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 60],
    '9.c' => ['baslik' => 'Ulusal tescillenmiş patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 40],
    '9.c2' => ['baslik' => 'Tescillenmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 20],
    '9.c3' => ['baslik' => 'Tescillenmiş tasarım ya da telif hakkı', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım', 'Yazılım'], 'puan' => 5],

    // ══ 10. DİĞER ETKİNLİKLER ══
    '10.A.a' => ['baslik' => 'Uluslararası yayın, değerlendirme kurulu ya da ödül jürisi üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dış Kuruluş Kurul Üyeliği (Uluslararası)'], 'puan' => 3],
    '10.A.b' => ['baslik' => 'Ulusal yayın kurulu, kamu kurumu ya da meslek kuruluşu komisyon üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dış Kuruluş Kurul Üyeliği (Ulusal)', 'Spor Federasyonu Kurul Üyeliği (Uluslararası)', 'Spor Federasyonu Kurul Üyeliği (Ulusal)'], 'puan' => 1],
    '10.A.b2' => ['baslik' => 'Dergide yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 1],
    '10.A.c' => ['baslik' => 'Sergi küratörlüğü ya da sanat ve tasarım yarışmalarında jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 1],
    '10.A.ç' => ['baslik' => 'Bilimsel toplantı başkanlığı ya da düzenleme kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)', 'Toplantı Düzenleme Başkanlığı (Ulusal)', 'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)', 'Oturum Başkanlığı (Uluslararası)', 'Oturum Başkanlığı (Ulusal)'], 'puan' => 1],
    '10.A.h' => ['baslik' => 'Alanıyla ilgili radyo ya da televizyon söyleşisi, panelde konuşmacılık', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Bilim İletişimi / Popüler Yayın'], 'puan' => 2],
    '10.B.k' => ['baslik' => 'Kamu ya da özel sektörde danışmanlık, etik kurul üyeliği, resmî görevlendirme (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 1],
    '10.B.k2' => ['baslik' => 'Kamu ya da sivil toplum kuruluşuna danışmanlık', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı'], 'puan' => 1],
    '10.B.l' => ['baslik' => 'Bölüm ya da anabilim dalı başkanlığı, rektörlükçe görevlendirilen koordinatörlük (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü', 'Dekan Yrd. / Müdür Yrd.', 'Uygulama ve Araştırma Merkezi Müdürü', 'Bölüm Başkanı', 'Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 3],
    '10.B.m' => ['baslik' => 'Kredili ders vermek (dönem başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 2],
    '10.C.o' => ['baslik' => 'Sosyal sorumluluk ya da eğitim projesinde yürütücülük veya görev', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi'], 'puan' => 5],
];

$gruplar = [
    'MAKALE' => ['1.*'],
    // EK'lerin "en az … (1a-1ç) maddesinden" koşulunun kümesi: Q1-Q4 ve AHCI.
    '1a-1ç' => ['1.a', '1.b', '1.c', '1.ç', '1.a-d', '1.b-d', '1.c-d', '1.ç-d'],
    // Edebiyat, İİBF ve Sağlık Bilimleri'nin kullandığı geniş küme: + ESCI/Scopus.
    '1a-1e' => ['1.a', '1.b', '1.c', '1.ç', '1.e', '1.a-d', '1.b-d', '1.c-d', '1.ç-d', '1.e-d'],
    'KITAP' => ['2.*'],
    'ATIF' => ['3.*'],
    'TEZ' => ['4.*'],
    'PROJE' => ['5.*'],
    'TOPLANTI' => ['6.*'],
    // "(6a), (6b), (6c) maddeleri kapsamında en az N puan" — kaynağın 6a/6b/6c'si
    // ULUSLARARASI toplantı satırları. `Davetli Konuşmacı` etiketi ulusal/uluslararası
    // ayrımı taşımadığı için 6.ç'de duruyor ve bu kümeye ALINMADI (§0).
    '6a-6c' => ['6.b', '6.c'],
    'EDITORLUK' => ['7.*'],
    'ODUL' => ['8.*'],
    'PATENT' => ['9.*'],
    'DIGER' => ['10.*'],
];

/**
 * EK-2…EK-13'ün "Zorunlu / En Fazla" sütunundaki En Fazla değerleri.
 * "---" yazan bölümlerde (makale, proje, ödül, patent) tavan yok.
 *
 * @return array<string, int>
 */
$tavanlar = static function (string $aile, string $kadro): array {
    $kitap = match ($aile) {
        'sosyal' => ['profesor' => 120, 'docent' => 90, 'dr' => 60],
        'mimarlik' => ['profesor' => 80, 'docent' => 80, 'dr' => 60],
        default => ['profesor' => 60, 'docent' => 60, 'dr' => 60],
    };
    $atif = match ($aile) {
        'sosyal', 'mimarlik' => ['profesor' => 160, 'docent' => 160, 'dr' => 15],
        default => ['profesor' => 160, 'docent' => 120, 'dr' => 15],
    };
    $toplanti = match ($aile) {
        'sosyal' => ['profesor' => 50, 'docent' => 50, 'dr' => 40],
        'mimarlik' => ['profesor' => 70, 'docent' => 70, 'dr' => 50],
        default => ['profesor' => 50, 'docent' => 50, 'dr' => 40],
    };

    $tavan = [
        'KITAP' => $kitap[$kadro],
        'ATIF' => $atif[$kadro],
        'TOPLANTI' => $toplanti[$kadro],
        'EDITORLUK' => $kadro === 'dr' ? 10 : 20,
        'DIGER' => $kadro === 'dr' ? 15 : 30,
    ];

    // Tez danışmanlığı tavanı yalnız profesör ve doçentte var; dr. öğr.
    // üyesi sütunu "0 P / ---" diyor.
    if ($kadro !== 'dr') {
        $tavan['TEZ'] = 30;
    }

    return $tavan;
};

$cetveller = [];

foreach (['fen', 'sosyal', 'mimarlik'] as $aile) {
    foreach (['dr', 'docent', 'profesor'] as $kadro) {
        $cetveller["ktu-2023-{$aile}-{$kadro}"] = [
            'yazar_katsayisi' => $yazarKatsayisi,
            'maddeler' => $maddeler,
            'gruplar' => $gruplar,
            'grup_tavanlari' => $tavanlar($aile, $kadro),
        ];
    }
}

return ['cetveller' => $cetveller];
