<?php

/**
 * KTO KARATAY ÜNİVERSİTESİ — Puanlama Tablosu
 * Kaynak: pdf/17537102502.ktokaratayuniversitesi.pdf
 *
 * BELGEDE TARİH YOK: MADDE 11 yürürlüğü Senato kabulü ve YÖK onayına bağlıyor
 * ama tarih vermiyor. Dosya adındaki 2024, PDF'in oluşturma tarihi (17/05/2024).
 *
 * ── İKİ ALAN VARYANTI: ATIF PUANI ALAN GRUBUNA GÖRE DEĞİŞİYOR ──
 * A.6 satırı aynı atfı iki farklı puanla veriyor:
 *   A.1 kapsamındaki dergilerde her atıf — Fen/Müh/Sağlık 4, Sosyal/Eğitim/
 *       Spor/Güzel Sanatlar 8
 *   A.1 dışındaki uluslararası dergilerde — 2 ve 4
 * Cetvel başına tek puan tanımlanabildiği için iki varyant üretildi:
 *   karatay-2024-fen     (Fen, Mühendislik, Sağlık)
 *   karatay-2024-sosyal  (Sosyal, Eğitim, Spor, Güzel Sanatlar)
 * Gövde ikisinde de aynı; yalnızca uluslararası atıf puanı değişiyor.
 *
 * ── PUAN SÜTUNU A.5'TE BİR SATIR KAYMIŞ ──
 * Bildiri bloğunda puanlar başlık satırından başlıyor: 40 başlığın hizasında,
 * 30/20/10 ise a/b/c şıklarında, d şıkkı boş kalıyor. Dört şık ve dört değer
 * var, değerler azalan sırada; a=40, b=30, c=20, d=10 olarak okundu.
 * Konvansiyonlardaki "puan çoğu zaman kodun bir ÜSTÜNDEKİ satırda durur"
 * tuzağının aynısı.
 *
 * ── YAZAR TABLOSU YALNIZCA DİPNOT 2 İŞARETLİ SATIRLARA ──
 * Tablo dipnot 2'yi taşıyan satırlarda uygulanıyor: bütün makale, bildiri ve
 * patent satırları (A) ile kitap satırları (B). ATIF (A.6, A.7, B.12, B.13),
 * ÖDÜL, PROJE, EDİTÖRLÜK, SANAT ETKİNLİĞİ (C) ve EĞİTİM (D) satırlarında
 * dipnot yok, çarpan uygulanmıyor.
 *
 * Tablo iki boyutlu (yazar sayısı × isim sırası) ve korpusta ender bir
 * cömertlik taşıyor: İKİ YAZARLI BİR YAYINDA BİRİNCİ İSİM TAM PUAN ALIYOR
 * (%100), ikinci isim %90. SORUMLU YAZAR BİRİNCİ İSİMLE AYNI sayılıyor
 * (dipnot 2), yani `baslica` rolü `ilk` ile aynı kademeleri paylaşıyor.
 *
 * ── SAYI TAVANI PUAN TAVANINA ÇEVRİLDİ ──
 * C.40 ve C.41 jüri üyeliğini "en fazla 6" ile sınırlıyor; adet tavanı motorda
 * yok ama satır puanı sabit olduğu için puana çevrilebiliyor: 6 × 5 = 30 ve
 * 6 × 2 = 12. D.1 ve D.2'nin "her yıl için en fazla 10 / 5 ders" kaydı ise
 * YIL BAŞINA olduğu için çevrilemedi; ders puanı YÜKSEK çıkar.
 *
 * ── AYNI KAYNAĞA DÜŞEN SATIRLARDA DAİMA DÜŞÜĞÜ GİRİLDİ ──
 *   Kitap B.2 uluslararası yayınevi (100) / B.6 Türkçe (80): kaynak kaydı
 *       yayınevini ve dili tutmuyor → B.6. Bölümde B.4 (50) / B.8 (20) → B.8;
 *       editörlükte B.4 (50) / B.9 (20) → B.9.
 *   Atıf A.6.a (A.1 dergileri) / A.6.b (A.1 dışı): 'WoS / Scopus' ikisini
 *       ayıramıyor → A.6.b.
 *   Dergi görevi C.27-C.28 editörlük ve kurul üyeliği (75/40) ile C.33
 *       hakemlik (10): 'WoS Dergi (Qn)' derginin düzeyini söylüyor, görevi
 *       değil → C.33. A.1 dışı dergilerde C.29-C.32 (50/30/20/10) ile C.34
 *       hakemlik (5) → C.34; ulusal dergi kaynakları da oraya düştü.
 *   Burs C.24 uluslararası (30) / C.25 ulusal (20) → C.25.
 *   Ödül C.19, C.22, C.55, C.56 (50/30/50/25): 'Yarışma Derecesi / Mansiyon'
 *       ne düzeyi ne türü söylüyor → C.56.
 *   Grup faaliyeti C.52 yurt dışı (25) / C.54 yurt içi (10) → C.54.
 *   Görsel-işitsel program C.5 (40) / C.59 (10) → C.59.
 *   Uygulama projesi ve eserin yayında yer alması: C.46 yurt dışı (40) /
 *       C.47 yurt içi (20) → C.47.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   B.1, B.3, B.5 (adayın adıyla anılan formül, şema, tasarım ve eserler),
 *       B.10 ve B.11 (sanat eseri hakkında eleştirel yayın), B.13 (ulusal
 *       kitapta atıf — 'BKCI Kitap' zaten B.12'ye düştü).
 *   C.5-C.17'nin çoğu (uzun ve kısa metraj film, multimedya CD, web tasarımı,
 *       afiş ve fotoğraf baskısı, reklam kampanyası, fotoğraf ve grafik
 *       sergisi), C.26 (eğitim alma, gün başına), C.35-C.38 (çalıştay ve
 *       kongre başkanlığı ile oturum başkanlığı), C.48-C.49 (şahsi faaliyet
 *       tekrarları), C.57-C.58 (yarışma jürisi — C.40/C.41 ile aynı kalem),
 *       C.61-C.64 (CD, gazete ve kurumsal kimlik tasarımı).
 *   D.4, D.5, D.6 (e-öğrenme materyali, yeni öğretim yöntemi, sektör bilgisi
 *       aktarımı) — belgeye ve takdire bağlı, sözlükte karşılığı yok.
 *   C.21'in "bilimsel araştırma projeleri hariç" kaydı yüzünden üniversite
 *       destekli projeler (BAP) ve öğrenci projeleri hiç girilmedi.
 *   'Çeviri Kitap Bölümü' — tabloda yalnızca "kitap başına" çevirmenlik var.
 *   Konservatuvara özgü icra kaynakları (opera, bale, şeflik, koreografi,
 *       kompozisyon, rejisörlük) — C bölümü sergi, festival ve şahsi
 *       faaliyet üzerine kurulu, icra satırı yok.
 *   'Kurul / Komisyon Üyeliği'
 *       — D.9 yalnızca akademik birim yöneticiliği ve yardımcılığını sayıyor.
 *
 * ── ATIFTA KENDİ ATFI AYIKLANAMIYOR ──
 * MADDE 5/g "adayın kendi adının bulunduğu eserlere yaptığı atıflar
 * değerlendirmeye alınmaz" ve "bir esere aynı eserde yapılan birden fazla
 * atıflar bir atıf sayılır" diyor; faaliyet kaydı ikisini de ayırt etmiyor.
 * Atıf puanı OLDUĞUNDAN YÜKSEK çıkar.
 *
 * Yönerge: yonerge/karatay.php
 *
 * KODLAR BİZE AİT — KAYNAKTA SATIR KODU YOK. Cetvel kodlarının SAYISAL
 * ÇEKİRDEĞİ kaynağın madde/bölüm numarasıdır; baştaki harf tabloyu ya da
 * eki, sondaki harf şıkkı gösterir ve ikisi de bizim eklediğimiz parçadır.
 * Koşullar bu kodlara atıf yaptığı için değiştirilmemeli; kaynakla
 * karşılaştırırken kodun sayısal çekirdeğine bakılmalı.
 */
$kapsamNotu = 'Puanlar KTO Karatay Üniversitesi Puanlama Tablosundan. Çok yazarlı '
    .'çalışmalarda yönergenin tablosu uygulanır ve tablo korpusta ender bir cömertlik '
    .'taşıyor: İKİ YAZARLI BİR YAYINDA BİRİNCİ İSİM TAM PUAN alır, ikinci isim %90. '
    .'Üç yazarlıda %90/%80/%70, altı ve üzerinde %75\'ten %25\'e iner. Sorumlu yazarsanız '
    .'birinci isimle aynı sayılırsınız. Çarpan yalnızca makale, bildiri, patent ve kitap '
    .'kalemlerine uygulanır; atıf, ödül, proje, editörlük, sanat etkinliği ve ders '
    .'satırları bölünmüyor. Yazar listesini boş bırakırsanız çarpan hiç uygulanmaz ve '
    .'puanınız olduğundan YÜKSEK görünür. '
    .'Uluslararası ve ulusal jüri üyeliğinden en çok 30 ve 12 puan alınabilir (yönergenin '
    .'"en fazla 6 jüri üyeliği" kaydı puana çevrildi). '
    .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: uzun ve kısa metraj film, multimedya '
    .'ve web tasarımı, afiş ve fotoğraf baskısı, reklam kampanyası, fotoğraf ve grafik '
    .'sergisi, çalıştay ve kongre başkanlığı ile oturum başkanlığı, adınızla anılan formül '
    .'ve tasarımlar, sanat eseri hakkında eleştirel yayınlar girilemedi. Üniversite destekli '
    .'bilimsel araştırma projeleri (BAP) de girilmedi: yönerge ulusal proje satırında bu '
    .'projeleri açıkça dışarıda bırakıyor. Yurt dışı ile yurt içi ya da editörlük ile '
    .'hakemlik ayrımını taşımayan kalemlerde (kitap, kitap bölümü, dergi görevi, burs, ödül, '
    .'grup faaliyeti) düşük satır kullanıldı. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK çıkabilir: atıflarda kendi yayınlarınıza '
    .'yaptığınız atıflar sayılmamalı ve aynı eserdeki birden çok atıf tek atıf sayılmalı, '
    .'kaydınız ikisini de ayırt etmiyor; ders puanında da "her yıl için en fazla 10 ve 5 '
    .'ders" sınırı uygulanamıyor.';

// Dipnot 2'nin tablosu: satır = yazar sayısı, sütun = isim sırası.
// "Bir makalenin sorumlu yazarı (corresponding author) 1inci isimle aynı
// şekilde değerlendirilir" — `baslica` bu yüzden `ilk` ile aynı.
$ilkKademeler = ['kademeler' => [1 => 1.0, 2 => 1.0, 3 => 0.90, 4 => 0.85, 5 => 0.80], 'sonrasi' => 0.75];

$yazarKatsayisi = [
    // Çarpan yalnızca dipnot 2 taşıyan satırlara: makale, bildiri, patent (A)
    // ve kitap (B). Atıf, ödül, proje, editörlük, sanat ve eğitim satırlarında
    // dipnot yok.
    'haric' => ['atif', 'odul', 'proje', 'editorluk', 'egitim_ogretim', 'tez_danismanligi',
        'idari_gorev', 'toplumsal_katki', 'sanatsal_etkinlik', 'tez_yayini'],
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.0]],
        'ilk' => $ilkKademeler,
        'baslica' => $ilkKademeler,
        'yazar_2' => ['kademeler' => [2 => 0.90, 3 => 0.80, 4 => 0.75, 5 => 0.70], 'sonrasi' => 0.65],
        'yazar_3' => ['kademeler' => [3 => 0.70, 4 => 0.65, 5 => 0.60], 'sonrasi' => 0.55],
        'yazar_4' => ['kademeler' => [4 => 0.55, 5 => 0.50], 'sonrasi' => 0.45],
        'yazar_5' => ['kademeler' => [5 => 0.40], 'sonrasi' => 0.35],
        'yazar_6' => ['sonrasi' => 0.25],
        // Sıra belirtilmemişse o yazar sayısındaki en düşük satır.
        'ortak' => ['kademeler' => [1 => 1.0, 2 => 0.90, 3 => 0.70, 4 => 0.55, 5 => 0.40], 'sonrasi' => 0.25],
    ],
];

/**
 * Cetvelin ortak gövdesi. `$uluslararasiAtif` alan grubuna göre değişen tek
 * değer (A.6.b).
 *
 * @return array<string, array<string, mixed>>
 */
$maddeler = fn (int $uluslararasiAtif): array => [
    // ══ A. YAYIN, ATIFLAR ve PATENTLER ══
    'A.1.a' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI taranan dergide makale ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 80],
    'A.1.b' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI taranan dergide teknik not, vaka takdimi ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 50],
    'A.2.a' => ['baslik' => 'Diğer uluslararası indeksli dergide makale ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 60],
    'A.2.b' => ['baslik' => 'Diğer uluslararası indeksli dergide teknik not, vaka takdimi ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 40],
    'A.3.a' => ['baslik' => 'TÜBİTAK taranan ulusal hakemli dergide makale ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 50],
    'A.3.b' => ['baslik' => 'TÜBİTAK taranan ulusal hakemli dergide teknik not, vaka takdimi ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 30],
    'A.4.a' => ['baslik' => 'Diğer hakemli dergide makale ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 30],
    'A.4.b' => ['baslik' => 'Diğer hakemli dergide teknik not, vaka takdimi ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 20],
    'A.5.a' => ['baslik' => 'Uluslararası bilimsel faaliyet kitabında yayımlanan tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 40],
    'A.5.b' => ['baslik' => 'Ulusal bilimsel faaliyet kitabında yayımlanan tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 30],
    'A.5.c' => ['baslik' => 'Uluslararası bilimsel faaliyet kitabında yayımlanan özet bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 20],
    'A.5.d' => ['baslik' => 'Ulusal bilimsel faaliyet kitabında yayımlanan özet bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 10],
    // A.6.a (A.1 dergilerindeki atıf) kaynak ayrımı taşımadığı için girilmedi.
    'A.6.b' => ['baslik' => 'Uluslararası dergilerde yayınlarınıza yapılan her bir atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => $uluslararasiAtif],
    'A.7.a' => ['baslik' => 'TÜBİTAK taranan ulusal dergilerde yayınlarınıza yapılan her bir atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
    'A.7.b' => ['baslik' => 'Diğer ulusal dergilerde yayınlarınıza yapılan her bir atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],
    'A.8.a' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 150],
    'A.8.b' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 100],
    'A.8.c' => ['baslik' => 'Faydalı model ve tesciller', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili', 'Ticarileştirme'], 'puan' => 60],

    // ══ B. DİĞER YAYIN FAALİYETLERİ ══
    'B.6' => ['baslik' => 'Bilimsel, sanatsal ya da ders kitabı yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'BKCI / Scopus Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı'], 'puan' => 80],
    'B.7' => ['baslik' => 'Alanınızda kitap çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 40],
    'B.8' => ['baslik' => 'Bilimsel, sanatsal ya da ders kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'BKCI / Scopus Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 20],
    'B.9' => ['baslik' => 'Kitap editörlüğü ya da görsel yönetmenlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü', 'BKCI Kitap'], 'puan' => 20],
    'B.12' => ['baslik' => 'Kitaplarda yayınlarınıza yapılan her bir atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 10],

    // ══ C. DİĞER BİLİMSEL FAALİYETLER ══
    'C.1' => ['baslik' => 'Uluslararası kuruluşlarca verilen bilim, sanat ya da hizmet ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 100],
    'C.3' => ['baslik' => 'Ulusal kuruluşlarca verilen bilim, sanat ya da hizmet ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'YÖK Ödülü', 'Ulusal Bilim/Sanat Ödülü'], 'puan' => 80],
    'C.4' => ['baslik' => 'Ulusal kuruluşlarca verilen teşvik ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 60],
    'C.15' => ['baslik' => 'Halkla ilişkiler, toplumsal sorumluluk ya da tanıtım çalışması', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın', 'Kamu/STK Danışmanlığı'], 'puan' => 10],
    'C.18' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen projede yöneticilik', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 60],
    'C.20' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],
    'C.21' => ['baslik' => 'Ulusal kuruluşlarca yürütülen projede yöneticilik', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 40],
    'C.23' => ['baslik' => 'Ulusal kuruluşlarca desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
    'C.25' => ['baslik' => 'Bilimsel ya da sanatsal amaçlı burs', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 20],
    'C.33' => ['baslik' => 'SCI, SSCI veya AHCI kapsamındaki dergide hakemlik, editörlük ya da yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 10],
    'C.34' => ['baslik' => 'Diğer dergilerde hakemlik, editörlük ya da yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi', 'TR Dizin Dergi', 'Diğer Hakemli Dergi', 'Hakemlik', 'Yayın Kurulu Üyeliği'], 'puan' => 5],
    'C.39' => ['baslik' => 'Panel, konferans, seminer ya da çalıştayda konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 10],
    'C.40' => ['baslik' => 'Uluslararası alanda jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], 'puan' => 5],
    'C.41' => ['baslik' => 'Ulusal alanda jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 2],
    'C.42' => ['baslik' => 'Uluslararası jürili ya da küratörlü karma faaliyete kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)'], 'puan' => 30],
    'C.43' => ['baslik' => 'Uluslararası festival faaliyetine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 25],
    'C.44' => ['baslik' => 'Ulusal jürili ya da küratörlü karma faaliyete kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)'], 'puan' => 20],
    'C.45' => ['baslik' => 'Ulusal festival faaliyetine kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 15],
    'C.46' => ['baslik' => 'Yurt dışında şahsi faaliyet (sergi, gösteri, dinleti, gösterim)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Solistlik (Uluslararası)', 'Resital (Uluslararası)', 'Şan Resitali (Uluslararası)'], 'puan' => 40],
    'C.47' => ['baslik' => 'Yurt içinde şahsi faaliyet (sergi, proje uygulama, gösteri, dinleti)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)', 'Solistlik (Ulusal)', 'Resital (Ulusal)', 'Şan Resitali (Ulusal)', 'Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman', 'Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt İçi)'], 'puan' => 20],
    'C.50' => ['baslik' => 'Ulusal jürili yurt dışı faaliyete kabul edilmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Ulusal Jürili)'], 'puan' => 25],
    'C.51' => ['baslik' => 'Yurt dışında karma faaliyete katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Karma Sergi (Uluslararası)'], 'puan' => 15],
    'C.53' => ['baslik' => 'Yurt içinde karma faaliyete katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 5],
    'C.54' => ['baslik' => 'Grup faaliyetine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra / Koro Üyeliği', 'Oda Müziği Grup Üyeliği (Uluslararası)', 'Oda Müziği Grup Üyeliği (Ulusal)'], 'puan' => 10],
    'C.56' => ['baslik' => 'Jürili faaliyette ödül almış olmak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 25],
    'C.59' => ['baslik' => 'Yayınlanmış görsel-işitsel program (yapım, yönetim, senaryo)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)'], 'puan' => 10],

    // ══ D. EĞİTİM-ÖĞRETİM ══
    'D.1' => ['baslik' => 'Ön lisans ya da lisans düzeyinde ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 4],
    'D.2' => ['baslik' => 'Lisansüstü düzeyde ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 4],
    'D.3' => ['baslik' => 'Tez savunma jüri üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 1],
    'D.7' => ['baslik' => 'Tamamlanmış doktora ya da tıpta uzmanlık tezi yönetimi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 10],
    'D.8' => ['baslik' => 'Tamamlanmış yüksek lisans tezi yönetimi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 5],
    'D.9.a' => ['baslik' => 'Akademik birim yöneticiliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü', 'Bölüm Başkanı', 'Uygulama ve Araştırma Merkezi Müdürü', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 2],
    'D.9.b' => ['baslik' => 'Akademik birim yönetici yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkan Yardımcısı'], 'puan' => 1],
];

// Koşulların andığı kümeler. Nokta zorunlu: 'A.1*' deseni olmayan bir 'A.10'
// kodunu da yakalardı.
$gruplar = [
    // Fen, Mühendislik ve Sağlık'ın alt kapısı: yalnızca A.1.
    'A.1' => ['A.1.*'],

    // Sosyal, Eğitim, Spor ve Güzel Sanatlar'ın alt kapısı: A bölümünün tamamı.
    'A.1-A.8' => ['A.*'],

    // Yeniden atanmanın orta kapısı: A, B ve C kategorileri (D hariç).
    'A-C' => ['A.*', 'B.*', 'C.*'],

    // C.40 ve C.41'in "en fazla 6 jüri üyeliği" kaydı puana çevrildi.
    'JURI-ULUSLARARASI' => ['C.40'],
    'JURI-ULUSAL' => ['C.41'],
];

$grupTavanlari = ['JURI-ULUSLARARASI' => 30, 'JURI-ULUSAL' => 12];

return ['cetveller' => [
    // A.6 atıf puanı Fen, Mühendislik ve Sağlık'ta 2, ötekilerde 4.
    'karatay-2024-fen' => [
        'kapsam_notu' => $kapsamNotu,
        'yazar_katsayisi' => $yazarKatsayisi,
        'maddeler' => $maddeler(2),
        'gruplar' => $gruplar,
        'grup_tavanlari' => $grupTavanlari,
    ],
    'karatay-2024-sosyal' => [
        'kapsam_notu' => $kapsamNotu,
        'yazar_katsayisi' => $yazarKatsayisi,
        'maddeler' => $maddeler(4),
        'gruplar' => $gruplar,
        'grup_tavanlari' => $grupTavanlari,
    ],
]];
