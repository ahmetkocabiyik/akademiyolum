<?php

/**
 * KOCAELİ SAĞLIK VE TEKNOLOJİ ÜNİVERSİTESİ (KOSTÜ) — EK-1: Akademik Başarı
 * Değerlendirmesinde Dikkate Alınacak Faaliyetlerin Türü ve Puanlama Çizelgesi
 * Kaynak: pdf/17537102172.kocaelisaglikveteknolojiuniversitesi.pdf
 *
 * BELGEDE TARİH YOK: MADDE 15 yürürlüğü Senato kabulü ve YÖK onayına bağlıyor
 * ama tarih vermiyor. Dosya adındaki 2023, PDF'in oluşturma tarihi (05/05/2023).
 *
 * ── ÜÇ KADRO VARYANTI: MADDE 14'ÜN TAVANI KADROYA BAĞLI ──
 * "Lisansüstü tez yönetiminden ve kurum içi projelerinden elde edilecek puanın
 * ilgili kadronun gerektirdiği ASGARİ PUANIN %50'sini aşan kısmı dikkate
 * alınmaz." Motor yalnızca sabit grup tavanı tanıyor, ama asgari puanlar
 * yönergede yazılı olduğu için yüzde sabit sayıya çevrilebiliyor:
 *
 *   kostu-2023-dr        20 puanın %50'si  →  TEZ-PROJE tavanı  10
 *   kostu-2023-docent   120 puanın %50'si  →  TEZ-PROJE tavanı  60
 *   kostu-2023-profesor 250 puanın %50'si  →  TEZ-PROJE tavanı 125
 *
 * Cetvel gövdesi üçünde de aynı; yalnızca tavan değişiyor. Işık'taki çarpanlı
 * ve çarpansız varyant üretiminin aynısı.
 *
 * MADDE 14'ÜN KAPSAMI: "lisansüstü tez yönetimi" 36-38, "kurum içi projeler"
 * ise üniversite fonlarınca desteklenen projeler (46-47) olarak okundu; TÜBİTAK
 * ve uluslararası projeler kurum dışı kaynaklı olduğu için tavana girmedi.
 *
 * ── YAZAR ÇARPANI YALNIZCA 1-13 ARASI SATIRLARA ──
 * Çizelgenin dipnotu açık: "1.-13. sıradaki YAYIN FAALİYETLERİNDE verilen puan
 * … tek yazar tarafından yapıldığında yazara verilen puandır." Yani çarpan
 * makale (1-10), atıf (11-12) ve ilk bildiri satırına (13) uygulanıyor;
 * KİTAP, EDİTÖRLÜK, TEZ, PROJE, PATENT VE ÖDÜL satırlarına UYGULANMIYOR.
 * `haric` bu yüzden alışılmadık biçimde geniş: yalnızca makale, bildiri ve
 * atıf kategorileri çarpan alıyor.
 *
 * Sonucu dikkat çekici: 75 puanlık uluslararası kitabın altı yazarı da 75
 * puanın tamamını alıyor. Kaynağın kendi tercihi, olduğu gibi girildi.
 *
 * Tablo 1 iki boyutlu — hem yazar sırası hem yazar sayısı:
 *   1. yazar 1,00 · 0,90 · 0,80 · 0,70 · 0,60 · 0,50 (bir-beş ve üzeri yazar)
 *   6. yazar ve sonrası daima 0,20
 * Sıra bilinmiyorsa o yazar sayısındaki en düşük satır uygulanır.
 *
 * ── ÇİZELGE KENDİ İÇİNDE TEKRAR EDİYOR, DÜŞÜK OLAN GİRİLDİ ──
 *   Atıflar iki kez tanımlı: 11-12 (A bölümü, 5/7/1 puan) ve 27-29 (D bölümü,
 *       2/5/1). Aynı olayın iki satırı → D bölümü girildi (uluslararası dergi
 *       atfı 5 yerine 2). 12(b)'nin "maksimum toplam 20 puan" kaydı ulusal
 *       atıf tavanı olarak korundu.
 *   Bildiri 4 ile 13 aynı kalemi tarif ediyor ve ikisi de 10 puan; 13 girildi
 *       (B bölümünün doğal yeri ve çarpan kapsamının içinde).
 *   Satır 3'ün "vaka raporu, özet, teknik not" payı (6) ile satır 5 (5) aynı
 *       kalem → satır 5.
 *
 * ── AYNI KAYNAĞA DÜŞEN SATIRLARDA DAİMA DÜŞÜĞÜ GİRİLDİ ──
 *   Kitap 20 uluslararası yabancı dilde (75) / 22 Türkçe telif (30): kaynak
 *       kaydı kitabın DİLİNİ tutmuyor → 22. Bölümde 21 (30) / 23 (20) → 23.
 *       Kitap editörlüğünde 34 (20) / 35 (10) → 35.
 *   Bildiri özeti 14 SCI kapsamında (5) / 17 SCI dışı (3) → 17.
 *   Davetli konuşmacı 18 uluslararası (10) / 19 ulusal (5) → 19.
 *   Burs 56 (1-3 ay, 5) / 57 (>3 ay, 10) / 58 (>1 yıl, 20): süre kayıtta yok
 *       → 56.
 *   Ödül 53 uluslararası (30) / 54 ulusal (20): 'Yarışma Derecesi / Mansiyon'
 *       düzeyini söylemiyor → 54.
 *   Dergi görevi 30'un üç alt şıkkı (editörlük 30 / yayın kurulu 20 /
 *       hakemlik 5): 'WoS Dergi (Qn)' derginin düzeyini söylüyor, görevi
 *       değil → 30.c. Ulusalda 33'ün iki şıkkı (3 / 2) → 33.b.
 *
 * ── ESCI DERGİLERİNDE GÖREV GİRİLEMEDİ ──
 * Satır 31 yalnızca "editörlük ve editör yardımcılığı" diyor; ISI taranan ama
 * SCI kapsamı dışındaki dergiler için HAKEMLİK SATIRI YOK. 'ESCI / Scopus
 * Dergi' kaynağı adayın görevini söylemediği için editörlük varsayılamazdı;
 * satır boş bırakıldı. O dergilerdeki göreviniz puan almıyor.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   Satır 50 "Son beş yılda üniversite eğitim biriminde idari görevde
 *       bulunmak" — KAYNAKTA PUAN SÜTUNU BOŞ, yalnızca "?" yazıyor. İdari
 *       görev puanı bu yüzden hiç girilemedi.
 *   Satır 24 (Türkçe el-cep kitabı), 26 (adayın adıyla anılan denklem, şema,
 *       sendrom), 55 (üniversite ödülleri), 59 ve 60 (kongre başkanlığı),
 *       39-41 (yardımcı tez danışmanlığı) — sözlükte karşılığı yok.
 *   Satır 4'ün "editöre mektup" payı (5).
 *   G bölümünde yalnızca patent var; faydalı model, endüstriyel tasarım,
 *       yazılım ve ıslahçı hakkı satırı yok.
 *   SANATSAL ETKİNLİK SATIRI HİÇ YOK. KOSTÜ sağlık ve teknoloji odaklı;
 *       sergi, konser, tasarım ve sahne çalışmaları çizelgede geçmiyor.
 *   'Topluma Hizmet Projesi' ve 'Bilim İletişimi / Popüler Yayın' — karşılık
 *       satırı yok; yalnızca "kurum ya da kuruluş tarafından talep edilen
 *       bilimsel raporlar" (48) girilebildi.
 *   Çizelgenin sonundaki "diğer faaliyetler" hükmü (dekan teklifi ve rektör
 *       onayıyla yılda 0-18 puan) takdire bağlı; koşula çevrilemez.
 *
 * ── DERS PUANI OLDUĞUNDAN YÜKSEK ÇIKAR ──
 * Satır 49 "SON BEŞ YILDA önlisans, lisans ve/veya lisansüstü düzeyde ders
 * verme" diyor; motor madde bazında kayan pencere tutmuyor, kısıt uygulanmadı.
 *
 * Yönerge: yonerge/kostu.php
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 */
$kapsamNotu = 'Puanlar KOSTÜ EK-1 çizelgesinden. YAZAR ÇARPANI YALNIZCA MAKALE, BİLDİRİ VE '
    .'ATIF KALEMLERİNE uygulanır — çizelgenin dipnotu çarpanı "1.-13. sıradaki yayın '
    .'faaliyetleri" ile sınırlıyor, kitap, editörlük, tez, proje, patent ve ödül satırları '
    .'bölünmüyor. Çarpan hem kaçıncı yazar olduğunuza hem yazar sayısına bağlı (1. yazar tek '
    .'yazarlıda 1,00 · beş yazarlıda 0,60 · altı ve üzerinde 0,50; 6. yazar ve sonrası daima '
    .'0,20). Sıranızı seçmezseniz o yazar sayısındaki en düşük satır uygulanır; yazar '
    .'listesini boş bırakırsanız çarpan hiç uygulanmaz ve puanınız olduğundan YÜKSEK görünür. '
    .'Lisansüstü tez danışmanlığı ile üniversite fonlarınca desteklenen projelerden '
    .'gelecek puan, başvurduğunuz kadronun asgari puanının yarısını aşamaz (Madde 14); ulusal '
    .'atıflardan da en çok 20 puan alınabilir. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: SANATSAL ETKİNLİK SATIRI HİÇ YOK '
    .'(sergi, konser, tasarım, sahne çalışmaları çizelgede geçmiyor) — Güzel Sanatlar '
    .'adaylarını en çok bu etkiler. İDARİ GÖREV PUANI DA GİRİLEMEDİ: çizelgenin ilgili '
    .'satırında puan yerine soru işareti var. ESCI kapsamındaki dergilerde hakemlik satırı '
    .'bulunmadığı ve kaydınız görevinizi söylemediği için o dergilerdeki göreviniz de puan '
    .'almıyor. Yardımcı tez danışmanlığı, el-cep kitabı, kongre başkanlığı, üniversite '
    .'ödülleri, faydalı model ve tasarım tescilleri de girilemedi. Kitabın dilini, bursun '
    .'süresini ve dergi görevinizi kaydınız tutmadığı için o kalemlerde düşük satır '
    .'kullanıldı. '
    .'Puanınız yalnızca derslerde OLDUĞUNDAN YÜKSEK çıkabilir: çizelge "son beş yılda verilen '
    .'dersler" diyor, bu pencere uygulanamıyor.';

// Tablo 1: satır = yazar sırası, sütun = yazar sayısı. Yalnızca 1-13 arası
// satırlara, yani makale, atıf ve ilk bildiri kalemine uygulanır.
$yazarKatsayisi = [
    'haric' => ['kitap', 'editorluk', 'tez_danismanligi', 'proje', 'patent', 'odul',
        'egitim_ogretim', 'idari_gorev', 'toplumsal_katki', 'sanatsal_etkinlik', 'tez_yayini'],
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.0]],
        'ilk' => ['kademeler' => [1 => 1.0, 2 => 0.90, 3 => 0.80, 4 => 0.70, 5 => 0.60], 'sonrasi' => 0.50],
        'yazar_2' => ['kademeler' => [2 => 0.80, 3 => 0.70, 4 => 0.60, 5 => 0.50], 'sonrasi' => 0.40],
        'yazar_3' => ['kademeler' => [3 => 0.60, 4 => 0.50, 5 => 0.40], 'sonrasi' => 0.35],
        'yazar_4' => ['kademeler' => [4 => 0.40, 5 => 0.35], 'sonrasi' => 0.30],
        'yazar_5' => ['kademeler' => [5 => 0.30], 'sonrasi' => 0.25],
        'yazar_6' => ['sonrasi' => 0.20],
        // Sıra belirtilmemişse o yazar sayısındaki en düşük satır.
        'baslica' => ['kademeler' => [1 => 1.0, 2 => 0.80, 3 => 0.60, 4 => 0.40, 5 => 0.30], 'sonrasi' => 0.20],
        'ortak' => ['kademeler' => [1 => 1.0, 2 => 0.80, 3 => 0.60, 4 => 0.40, 5 => 0.30], 'sonrasi' => 0.20],
    ],
];

$maddeler = [
    // ══ A- BİLİMSEL DERGİLERDE YAYINLAR ══
    '1' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI kapsamındaki dergide makale ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 30],
    '2' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI kapsamındaki dergide vaka takdimi, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 15],
    '3' => ['baslik' => 'ISI taranan, SCI kapsamı dışındaki uluslararası indeksli dergide makale ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 10],
    '5' => ['baslik' => 'ISI taranan, SCI kapsamı dışındaki uluslararası indeksli dergide vaka takdimi, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 5],
    '6' => ['baslik' => 'ULAKBİM TR Dizin ya da alan endeksli dergide makale ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 10],
    '7' => ['baslik' => 'ULAKBİM TR Dizin ya da alan endeksli dergide vaka takdimi, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 5],
    '8' => ['baslik' => 'Diğer hakemli ve süreli dergilerde makale ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 6],
    // Kaynak 9'u tek satırda iki puanla veriyor; alt kodlar (a-b) bize ait.
    '9.a' => ['baslik' => 'ISI kapsamı dışındaki uluslararası indeksli dergide makale ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 7],
    '9.b' => ['baslik' => 'ISI kapsamı dışındaki uluslararası indeksli dergide vaka raporu, özet ya da mektup', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 3],
    '10' => ['baslik' => 'Diğer hakemli ve süreli dergilerde vaka takdimi, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 3],

    // ══ B- KONGRE, SEMPOZYUM VE BENZERİ TOPLANTI SUNUMLARI ══
    '13' => ['baslik' => 'Uluslararası kongrede sunulan, tam metni indeksli dergi ya da kongre kitabında yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 10],
    '15' => ['baslik' => 'Uluslararası kongrede sunulan, tam metni yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin'], 'puan' => 5],
    '16' => ['baslik' => 'Ulusal kongrede sunulan, tam metni yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 3],
    '17' => ['baslik' => 'Ulusal ya da uluslararası kongrede sunulan, özeti yayımlanan bildiri veya poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster', 'Ulusal Özet/Poster'], 'puan' => 3],
    '19' => ['baslik' => 'Kongrede davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 5],

    // ══ C- TELİF YA DA TERCÜME KİTAP ══
    '22' => ['baslik' => 'Telif kitap (araştırma ya da ders kitabı)', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'BKCI / Scopus Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı'], 'puan' => 30],
    '23' => ['baslik' => 'Telif kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'BKCI / Scopus Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 20],
    // Kaynak 25'i tek satırda iki puanla veriyor ("15/5"); alt kodlar bize ait.
    '25.a' => ['baslik' => 'Ders kitabı çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 15],
    '25.b' => ['baslik' => 'Ders kitabı bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 5],

    // ══ D- ATIFLAR ══
    // A bölümündeki 11-12 satırları aynı kalemleri daha yüksek puanla
    // tekrarlıyor; kural gereği bu bölüm girildi.
    '27' => ['baslik' => 'Uluslararası atıf indekslerindeki dergilerde yayınlarınıza yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 2],
    '28' => ['baslik' => 'Yabancı dilde referans kitaplarda yayınlarınıza yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 5],
    '29' => ['baslik' => 'Ulusal dergi ve kitaplarda yayınlarınıza yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Patent', 'Diğer'], 'puan' => 1],

    // ══ E- EDİTÖRLÜK VE HAKEMLİK ══
    // Kaynak 30'u üç alt şıkla veriyor (editörlük 30 / yayın kurulu 20 /
    // hakemlik 5); alt kodlar bize ait, kayıt görevi ayırmadığı için en düşüğü.
    '30.c' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI kapsamındaki dergide hakemlik, yayın kurulu üyeliği ya da editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 5],
    // 32 (ulusal dergi editörlüğü, 5) girilmedi: kaydınız görevi söylemediği
    // için ulusal dergilerdeki bütün görevler 33'ün düşük şıkkına düştü.
    '33.b' => ['baslik' => 'Ulusal hakemli dergilerde hakemlik, editör yardımcılığı ya da yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi', 'Hakemlik', 'Yayın Kurulu Üyeliği'], 'puan' => 2],
    // 34 yabancı dilde (20) / 35 Türkçe (10): kaydınız kitabın dilini
    // tutmadığı için düşük satır.
    '35' => ['baslik' => 'Kitaplarda editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü', 'BKCI Kitap'], 'puan' => 10],

    // ══ F- TEZ DANIŞMANLIĞI VE PROJE YÜRÜTÜCÜLÜĞÜ ══
    '36' => ['baslik' => 'Sonuçlanmış yüksek lisans tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 10],
    '37' => ['baslik' => 'Sonuçlanmış doktora tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi'], 'puan' => 20],
    '38' => ['baslik' => 'Sonuçlanmış tıpta uzmanlık tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 15],
    '42' => ['baslik' => 'Sonuçlanmış uluslararası destekli projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 60],
    '43' => ['baslik' => 'Sonuçlanmış uluslararası destekli projede araştırmacı ya da yardımcı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
    '44' => ['baslik' => 'Sonuçlanmış TÜBİTAK ya da benzeri destekli projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 30],
    '45' => ['baslik' => 'Sonuçlanmış TÜBİTAK ya da benzeri destekli projede araştırmacı ya da yardımcı', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
    '46' => ['baslik' => 'Üniversite fonu ya da dernek destekli projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 15],
    '47' => ['baslik' => 'Üniversite fonu ya da dernek destekli projede araştırmacı ya da yardımcı', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 5],
    '48' => ['baslik' => 'Bir kurum ya da kuruluş tarafından talep edilen bilimsel rapor', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı'], 'puan' => 5],
    '49' => ['baslik' => 'Ön lisans, lisans ya da lisansüstü düzeyde ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 2],

    // ══ G- BİLİMSEL BULUŞ PATENTLERİ ══
    '51' => ['baslik' => 'Bilimsel buluşa uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 100],
    '52' => ['baslik' => 'Bilimsel buluşa ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 50],

    // ══ H- ÖDÜLLER VE DİĞER HİZMETLER ══
    '53' => ['baslik' => 'Uluslararası ödül', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 30],
    '54' => ['baslik' => 'Ulusal ödül', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü', 'Ulusal Bilim/Sanat Ödülü', 'Yarışma Derecesi / Mansiyon'], 'puan' => 20],
    '56' => ['baslik' => 'Uluslararası araştırma bursu', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 5],
];

$gruplar = [
    // Madde 7/c ve 8/b'nin andığı "EK-1'de yer alan yayınlar": makale, bildiri
    // ve kitap satırları. Atıf, editörlük, proje ve ödül yayın değil.
    'YAYIN' => ['1', '2', '3', '5', '6', '7', '8', '9.a', '9.b', '10',
        '13', '15', '16', '17', '19', '22', '23', '25.a', '25.b'],

    // Madde 14'ün tavanı: lisansüstü tez yönetimi ve kurum içi projeler.
    'TEZ-PROJE' => ['36', '37', '38', '46', '47'],

    // Satır 12(b)'nin kendi kaydı: "maksimum toplam 20 puan alınabilir".
    'ULUSAL-ATIF' => ['29'],
];

/**
 * Madde 14'ün yüzdesel tavanı kadroya göre değişiyor; cetvel başına tek tavan
 * tanımlanabildiği için üç varyant üretiliyor.
 *
 * @var array<string, int> $asgariPuanlar
 */
$asgariPuanlar = ['dr' => 20, 'docent' => 120, 'profesor' => 250];

$cetveller = [];

foreach ($asgariPuanlar as $kadro => $asgari) {
    $cetveller["kostu-2023-{$kadro}"] = [
        'kapsam_notu' => $kapsamNotu,
        'yazar_katsayisi' => $yazarKatsayisi,
        'maddeler' => $maddeler,
        'gruplar' => $gruplar,
        'grup_tavanlari' => [
            'TEZ-PROJE' => intdiv($asgari, 2),
            'ULUSAL-ATIF' => 20,
        ],
    ];
}

return ['cetveller' => $cetveller];
