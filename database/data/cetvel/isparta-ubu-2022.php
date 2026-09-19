<?php

/**
 * ISPARTA UYGULAMALI BİLİMLER ÜNİVERSİTESİ (ISUBÜ) — MADDE 10 Tabloları
 * Kaynak: pdf/17536996862.ispartauygulamalibilimleruniverstesi.pdf
 * (11 sayfa; Senato 20.10.2020-57/09, 2022/86-04 sayılı Senato Kararı
 * değişiklikleriyle)
 *
 * ── MADDE KODLARI BİZE AİT ──
 * Yönergenin üç tablosunda satır numarası YOK; satırlar yalnızca "Türü /
 * Tanımı / Puanı" sütunlarıyla veriliyor. Koşullar tabloya kodla değil
 * ADIYLA atıf yapıyor ("Tablo 1'den en az 40 puan"), bu yüzden kodlar
 * `T1-`, `T2-`, `T3-` önekleriyle bizim tarafımızdan üretildi ve tablo
 * bölümlerine `T1`, `T2`, `T3` grupları karşılık geliyor. Tek istisna
 * Tablo 3'ün 'A' bölümü: MADDE 6/6-b o bölümün maddelerini NUMARAYLA
 * anıyor ("4 üncü maddesindeki minimum puan", "diğer maddelerden (1, 2, 3
 * ve 5 numaralı maddeler)"), o yüzden A1-A5 numaraları birebir korundu.
 *
 * ── ÜÇ TABLO, ÜÇ AYRI BARAJ KÜMESİ ──
 * Barajlar tablonun tamamına değil BÖLÜMÜNE bağlı: Fen/Mühendislik ve
 * Sosyal adayları "Tablo 1 ve Tablo 2"den, Güzel Sanatlar adayları
 * "Tablo 2 ve Tablo 3"ten toplam alıyor. Bu yüzden `Kalip::toplam`
 * çağrılarının hepsi `maddeler` grubu ve düz Türkçe `liste` adı taşıyor;
 * cetvelin tamamı hiçbir barajda kullanılmıyor.
 *
 * Aynı faaliyet iki tabloda birden karşılık bulabilir (bir makale hem
 * Tablo 1'in "Araştırma makalesi" satırına hem Tablo 3'ün A4 satırına
 * düşer). Motor her grubun İÇİNDEKİ en iyi kodu seçtiği için bu doğru
 * çalışıyor: Fen adayının makalesi Tablo 1 satırından, Güzel Sanatlar
 * adayının makalesi A4'ten puanlanıyor.
 *
 * ── TEZ YAYINI AYNA SATIRLARI ──
 * Yönerge tezden üretilmiş yayınları ayırmıyor (MADDE 8/1-b tam tersini
 * söylüyor: "Lisansüstü tezlerinden üretilen yayın zorunluluğu tekrar
 * aranmaz"). Faaliyet kaydında `tez_yayini` kategorisi ayrı durduğu için
 * puanı sıfırlanmasın diye Tablo 1'in makale ve kitap satırlarının
 * `tez_yayini` aynaları açıldı (`T1-TEZ-*`); puanlar karşılık geldikleri
 * satırlarla birebir aynı. Aynı ayna Tablo 3 için de var (`T3-A4-tez`).
 *
 * ── AYNI KAYNAĞA DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   Patent: "incelemeli (başvuru sonuçlanmış) 20" ile "incelemesiz
 *       (başvuru sonuçlanmış) 10" arasındaki inceleme farkı kayıtta yok
 *       → 10.
 *   Üniversite destekli projeler: münferit (4), doktora tez projesi (3),
 *       yüksek lisans tez projesi (2) ve alt yapı projesi (4) tek
 *       'BAP (Üniversite)' etiketine düşüyor → 2 (araştırmacıda 1).
 *   Davetli konuşmacılık: uluslararası 5, ulusal 3, çalıştay 1 → tek
 *       'Davetli Konuşmacı' etiketi → 1.
 *   Dergi görevleri: uluslararası editörlük 8 / yardımcı editörlük 6 /
 *       misafir editörlük 2 tek indeks etiketine düşüyor → 2; ulusalda
 *       6 / 4 / 1 → 1.
 *   İdari görevlerde 'Dekan / Enstitü-YO Müdürü' etiketi dekanlığı (10)
 *       ve enstitü/yüksekokul müdürlüğünü (8) birlikte taşıyor → 8.
 *   Bilimsel toplantı görevleri (düzenleme kurulu başkanlığı 6, üyeliği 4,
 *       bilim kurulu üyeliği 2, sekretarya 2; ulusalda 4/2/1/1): tek
 *       'Diğer' etiketi → 1.
 *   Tablo 3'te aynı türden satır alt disipline göre farklı puan taşıyor
 *       (özgün makale müzikolojide 20, klasik balede 5; kitap
 *       müzikolojide 40, plastik sanatlarda 12,5). Kayıt adayın alt
 *       disiplinini taşımadığı için her tür EN DÜŞÜK değerden girildi.
 *
 * ── §0 UYARINCA AŞAĞI YUVARLANAN KESİRLİ PUANLAR ──
 * Tablo 3'ün kesirli puanları aşağı yuvarlandı: 7,5 → 7 · 12,5 → 12 ·
 * 6,25 → 6 · 2,5 → 2. (Barajlar tersine, YUKARI: MADDE 6/6-b'nin
 * "A bölümünün 4 üncü maddesindeki minimum puan" eşiği 12,5 → 13.)
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   Tablo 1: hakemsiz dergilerde yayın (1), Teknoloji Transfer Ofisine
 *       buluş bildirimi (5) — sözlükte karşılık yok.
 *   Tablo 1: "Kurumlarca desteklenen lisans öğrencilerine yönelik
 *       projeler" MADDE 5/a ile AÇIKÇA dışlandığı için
 *       'Öğrenci Projesi (2209 vb.)' etiketine hiç satır yazılmadı.
 *   Tablo 2: öğrenci proje yarışması danışmanlığı (1), öğrenci
 *       kulübü/topluluğu danışmanlığı (1) — sözlükte karşılık yok.
 *   Tablo 3: puanı bir PORTFÖYE bağlı satırlar (B/a-1 "en az 6 eser",
 *       B/b-1 "en az üç saatlik iki resital", B/c-1 "en az dört saatlik
 *       kayıt", B/e-1, C/1-1, C/2-1, C/3-1 gibi) girilmedi: kayıt eser
 *       başına tutuluyor, portföy puanı esere bölünemiyor. Orkestra ve
 *       koro şefliği kalemleri bu yüzden yalnızca B/ç-9'un konser
 *       satırından (10 puan) sayılıyor.
 *   Endüstriyel tasarım, yazılım, ıslahçı hakkı, ticarileştirme,
 *       ansiklopedi maddesi, akreditasyon faaliyeti — tablolarda satır
 *       yok.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   Eğitim öğretim ("son 5 yılda en fazla 10 puan"), değişim programları
 *       ("son 5 yılda en fazla 10 puan") ve araştırma bursu ("en fazla 10
 *       puan") tavanları grup tavanı olarak yazıldı ama BEŞ YILLIK
 *       PENCERE uygulanmıyor; bu kalemlerde puan olduğundan yüksek
 *       görünebilir.
 *   "En çok 3 adet/yıl" (bildiri, hakemlik) ve "en çok 2 adet/yıl"
 *       (proje danışmanlığı, düzenleme kurulu) yıl başına adet tavanları
 *       — motorda yıl biriktirmesi yok.
 *   İdari görev ve dergi görevleri "her bir yıl için" veriliyor; yıl
 *       çarpanı olmadığı için görev başına tek yıl sayılıyor, puan
 *       olduğundan DÜŞÜK görünür.
 *   MADDE 5/d "Tablo 1 ve Tablo 2'den alınacak toplam puanlar için
 *       küsuratlı rakamlar yukarıya yuvarlanır" — motor puanları tam sayı
 *       tuttuğu için yuvarlama zaten aşağı yönde; adayın lehine olan bu
 *       kural uygulanmıyor.
 *   MADDE 5/e (askerlik, sağlık, doğum izni nedeniyle görevde
 *       bulunulamayan sürenin düşülmesi) — profilde yok.
 *
 * Yönerge: yonerge/isparta-ubu.php
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 *
 * KİTAPTA DÜZEY SÜTUNU (19.09.2026): Tablo 1'in kitap bloğu her kalemi
 * "Düzeyi" sütunuyla uluslararası ↔ ulusal diye ikiye ayırıyor (bilimsel kitap
 * 20/15, ders kitabı 15/10, bölüm katkısı 10/8, editörlük 10/8); tanımlar
 * maddesi (c) ve (ç) ayrımı yayınevine bağlıyor, indeks aramıyor. Üst satırlar
 * yalnız BKCI/Scopus etiketiyle yazıldığı için indekssiz uluslararası kitap 20
 * yerine 15, bölümü 10 yerine 8, editörlüğü 10 yerine 8 puandaydı. Ders
 * kitabının uluslararası kademesi (T1-K3u, 15) bu turda açıldı.
 */

// MADDE 9: puan bölüşümü TEMEL ALANA göre değişiyor. Fen/Mühendislikte
// başlıca yazar iki yazarlıda 0,8 · üç ve daha fazla yazarlıda toplam
// puanın yarısı, diğerleri kalan yarıyı eşit paylaşıyor; başlıca yazar
// belirtilmemişse ve diğer yayınlarda (bildiri, kitap) eşit bölüşme var.
// Sosyalde bölüşme daima eşit. Cetvel başına tek matris tanımlanabildiği
// için her rolde İKİ KURALIN DÜŞÜK OLANI yazıldı: bu, üç ve daha fazla
// yazarlı çalışmalarda her rolü 1/n'e indiriyor (Fen'de başlıca yazarın
// alacağı 1/2 yerine). Fen/Mühendislik adayının çok yazarlı yayın puanı
// bu yüzden OLDUĞUNDAN DÜŞÜK görünür.
$esitBolusme = ['sonrasi_pay' => 1.0];

$yazarKatsayisi = [
    'haric' => ['atif', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev',
        'odul', 'editorluk', 'toplumsal_katki', 'proje', 'patent'],
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.0]],
        'ilk' => $esitBolusme,
        'baslica' => ['kademeler' => [1 => 1.0, 2 => 0.8], 'sonrasi_pay' => 1.0],
        'yazar_2' => ['kademeler' => [1 => 1.0, 2 => 0.5], 'sonrasi_pay' => 1.0],
        'yazar_3' => $esitBolusme,
        'yazar_4' => $esitBolusme,
        'yazar_5' => $esitBolusme,
        'yazar_6' => $esitBolusme,
        'ortak' => $esitBolusme,
    ],
];

$maddeler = [
    // ══════════════ TABLO 1: BİLİMSEL YAYINLAR ══════════════
    // Derleme (Review)
    'T1-D1' => ['baslik' => 'SSCI, AHCI, SCI veya SCI-Expanded kapsamındaki dergide yayımlanmış derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme'], 'puan' => 12],
    'T1-D2' => ['baslik' => 'Diğer indekslere giren uluslararası dergide yayımlanmış derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['derleme'], 'puan' => 8],
    'T1-D3' => ['baslik' => 'ULAKBİM tarafından taranan ulusal hakemli dergide yayımlanmış derleme', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['derleme'], 'puan' => 6],
    'T1-D4' => ['baslik' => 'Ulusal veya uluslararası hakemli dergide yayımlanmış derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['derleme'], 'puan' => 4],

    // Araştırma makalesi — A1 çeyrekliğe göre ikiye bölündü, çünkü MADDE
    // 7/2-b-7 ve 8/2-b-5 yalnızca Q1 ve Q2 dergileri sayıyor. Puanlar aynı.
    'T1-A1a' => ['baslik' => 'SSCI, AHCI, SCI veya SCI-Expanded kapsamındaki Q1 ya da Q2 dergide yayımlanmış araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale'], 'puan' => 20],
    'T1-A1b' => ['baslik' => 'SSCI, AHCI, SCI veya SCI-Expanded kapsamındaki Q3, Q4 ya da AHCI dergisinde yayımlanmış araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 20],
    'T1-A2' => ['baslik' => 'E-SCI veya SCOPUS kapsamındaki dergide yayımlanmış araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale'], 'puan' => 12],
    'T1-A3' => ['baslik' => 'Diğer indekslere giren uluslararası dergide yayımlanmış araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale'], 'puan' => 10],
    'T1-A4' => ['baslik' => 'ULAKBİM tarafından taranan ulusal hakemli dergide yayımlanmış araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 8],
    'T1-A5' => ['baslik' => 'Ulusal veya uluslararası hakemli dergide yayımlanmış araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale'], 'puan' => 6],

    // Diğer çalışmalar (teknik not, yorum, vaka takdimi, editöre mektup, kitap kritiği)
    'T1-C1' => ['baslik' => 'SSCI, AHCI, SCI veya SCI-Expanded kapsamındaki dergide yayımlanmış teknik not, vaka takdimi, editöre mektup ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 6],
    'T1-C2' => ['baslik' => 'E-SCI kapsamındaki dergide yayımlanmış teknik not, vaka takdimi, editöre mektup ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 4],
    'T1-C3' => ['baslik' => 'Ulusal ya da uluslararası hakemli dergide yayımlanmış teknik not, vaka takdimi, editöre mektup ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 2],

    // Patent
    'T1-P1' => ['baslik' => 'Ulusal veya uluslararası patent (başvuru sonuçlanmış)', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent', 'Ulusal Patent'], 'puan' => 10],
    'T1-P2' => ['baslik' => 'Faydalı model ya da yeni ürün (başvuru sonuçlanmış)', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 5],

    // Araştırma projesi — "Açıklama" satırı rolü yüzdeyle veriyor
    // (yürütücü %100, araştırmacı öğretim üyesi %75); araştırmacı satırları
    // yüzdeden hesaplanıp §0 uyarınca aşağı yuvarlandı.
    'T1-PR1' => ['baslik' => 'AB Çerçeve Programı bilimsel araştırma projesinde koordinatör ya da baş araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 15],
    'T1-PR2' => ['baslik' => 'AB Çerçeve Programı bilimsel araştırma projesinde ortak araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
    'T1-PR3' => ['baslik' => 'Diğer uluslararası destekli bilimsel araştırma projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 8],
    'T1-PR4' => ['baslik' => 'Diğer uluslararası destekli bilimsel araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 6],
    'T1-PR5' => ['baslik' => 'Üniversite dışındaki kamu kurumlarıyla yapılan bilimsel araştırma projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 6],
    'T1-PR6' => ['baslik' => 'Üniversite dışındaki kamu kurumlarıyla yapılan bilimsel araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 4],
    'T1-PR7' => ['baslik' => 'Üniversite destekli tamamlanmış projede yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 2],
    'T1-PR8' => ['baslik' => 'Üniversite destekli tamamlanmış projede araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 1],

    // Diğer projeler
    'T1-TK' => ['baslik' => 'Başarıyla tamamlanmış eğitim ya da toplumsal katkı projesinde görev almak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi', 'Kamu/STK Danışmanlığı', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 2],

    // Bildiriler ve davetli konuşmacılık
    'T1-B1' => ['baslik' => 'Uluslararası toplantıda sunulmuş ve tam metni yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 3],
    'T1-B2' => ['baslik' => 'Ulusal toplantıda sunulmuş ve tam metni yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 2],
    'T1-B3' => ['baslik' => 'Uluslararası toplantıda poster ya da özet bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 2],
    'T1-B4' => ['baslik' => 'Ulusal toplantıda poster ya da özet bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 1],
    'T1-B5' => ['baslik' => 'Kongre, konferans, sempozyum, çalıştay ya da mesleki kursta davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 1],

    // Kitap
    'T1-K1' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası Kitap'], 'puan' => 20],
    'T1-K2' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 15],
    'T1-K3u' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası Ders / Metot Kitabı'], 'puan' => 15],
    'T1-K3' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Ders / Metot Kitabı'], 'puan' => 10],
    'T1-K4' => ['baslik' => 'Uluslararası yayınevi kitabına bölüm düzeyinde katkı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Uluslararası Kitap Bölümü'], 'puan' => 10],
    'T1-K5' => ['baslik' => 'Ulusal yayınevi kitabına bölüm düzeyinde katkı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap Bölümü'], 'puan' => 8],
    'T1-K6' => ['baslik' => 'Uluslararası kitapta editörlük (çeviri editörlüğü dâhil)', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Uluslararası Kitap Editörlüğü'], 'puan' => 10],
    'T1-K7' => ['baslik' => 'Ulusal kitapta editörlük (çeviri editörlüğü dâhil)', 'kategori' => 'editorluk', 'kaynaklar' => ['Ulusal Kitap Editörlüğü', 'Kitap Editörlüğü'], 'puan' => 8],
    'T1-K8' => ['baslik' => 'Yabancı dilde basılmış bilimsel ya da edebi eserin Türkçeye tam kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 15],
    'T1-K9' => ['baslik' => 'Yabancı dilde basılmış bilimsel ya da edebi eserin Türkçeye bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 8],

    // Tez yayını aynaları — kodlar bize ait, puanlar karşılıklarıyla aynı.
    'T1-TEZ-A1' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, SSCI, AHCI, SCI veya SCI-Expanded kapsamındaki dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 20],
    'T1-TEZ-A2' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, E-SCI veya SCOPUS kapsamındaki dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 12],
    'T1-TEZ-A4' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, ULAKBİM tarafından taranan ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['TR Dizin'], 'puan' => 8],
    'T1-TEZ-A5' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, ulusal ya da uluslararası hakemli dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Diğer'], 'puan' => 6],
    'T1-TEZ-K1' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
    'T1-TEZ-K2' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 15],
    'T1-TEZ-K4' => ['baslik' => 'Lisansüstü tezinizden üretilmiş kitap bölümü (uluslararası)', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 10],
    'T1-TEZ-K5' => ['baslik' => 'Lisansüstü tezinizden üretilmiş kitap bölümü (ulusal)', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 8],
    'T1-TEZ-B1' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, tam metni yayımlanmış bildiri', 'kategori' => 'tez_yayini', 'kaynaklar' => ['CPCI Bildiri'], 'puan' => 3],

    // ══════════════ TABLO 2: EĞİTİM-ÖĞRETİM, İDARİ VE DİĞER ══════════════
    'T2-AT1' => ['baslik' => 'SCI, AHCI, SSCI, SCI-Expanded dergilerinde ya da uluslararası yayınevi kitaplarında adınıza yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 3],
    'T2-AT2' => ['baslik' => 'Diğer indekslere giren dergilerde ya da uluslararası basılmış kongre bildirilerinde adınıza yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer (Uluslararası)'], 'puan' => 2],
    'T2-AT3' => ['baslik' => 'Hakemli dergiler, tezler, kongre özetleri, bildiri kitapları ve kitaplarda adınıza yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Patent'], 'puan' => 1],

    'T2-ED1' => ['baslik' => 'Uluslararası indekslerde taranan süreli hakemli dergide editörlük, yardımcı editörlük ya da misafir editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 2],
    'T2-ED2' => ['baslik' => 'Ulusal süreli hakemli dergide editörlük, yardımcı editörlük ya da misafir editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 1],
    'T2-ED3' => ['baslik' => 'Süreli hakemli dergide yayın kurulu, bilim kurulu ya da komisyon üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 2],
    'T2-ED4' => ['baslik' => 'Süreli hakemli dergide hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 1],

    'T2-TOP' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu, bilim kurulu ya da sekretarya görevi', 'kategori' => 'diger', 'kaynaklar' => ['Diğer', 'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 1],

    'T2-ID1' => ['baslik' => 'Rektör ya da rektör yardımcısı olarak görev yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı'], 'puan' => 10],
    'T2-ID2' => ['baslik' => 'Dekan, yüksekokul, meslek yüksekokulu, enstitü ya da merkez müdürü olarak görev yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 8],
    'T2-ID3' => ['baslik' => 'Dekan yardımcısı, müdür yardımcısı ya da bölüm başkanı olarak görev yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkanı'], 'puan' => 6],
    'T2-ID4' => ['baslik' => 'Üniversite yönetim kurulu, senato ya da diğer kurul üyeliği; bölüm başkan yardımcılığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı'], 'puan' => 4],
    'T2-ID5' => ['baslik' => 'Koordinatörlük, koordinatör yardımcılığı ya da anabilim/bilim dalı başkanlığı', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 3],
    'T2-ID6' => ['baslik' => 'Komisyon, çalışma grubu ve benzeri üyelikler', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 1],

    'T2-EG1' => ['baslik' => 'Lisansüstü ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
    'T2-EG2' => ['baslik' => 'Ön lisans ya da lisans dersi vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders'], 'puan' => 2],
    'T2-DG' => ['baslik' => 'Uluslararası ya da ulusal değişim programı (Erasmus, Mevlana, Farabi) kapsamında hareketlilik, ders ya da anlaşma', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Değişim Programı Dersi'], 'puan' => 3],

    'T2-DA1' => ['baslik' => 'Yönetiminde tamamlanmış doktora tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 4],
    'T2-DA2' => ['baslik' => 'Yönetiminde tamamlanmış doktora tezinde eş ya da ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 2],
    'T2-DA3' => ['baslik' => 'Yönetiminde tamamlanmış yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 2],
    'T2-DA4' => ['baslik' => 'Yönetiminde tamamlanmış yüksek lisans tezinde eş ya da ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 1],
    'T2-DA5' => ['baslik' => 'Tez izleme komitesi ya da tez jürisi üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 1],

    'T2-BU' => ['baslik' => 'YÖK ya da TÜBİTAK araştırma veya eğitim bursu almış olmak', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 5],

    // ══════════════ TABLO 3: GÜZEL SANATLAR ══════════════
    // A bölümünün 1-5 numaraları yönergenin kendisi; alt kırılımlar bize ait.
    'A1' => ['baslik' => 'Özgün sanat eseri, tasarım ya da yorum çalışmasıyla kişisel etkinlikte (sergi, bienal, gösteri, dinleti, festival, gösterim) bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 20],
    'A2' => ['baslik' => 'Karma ya da ortak etkinliğe katılmak; eserinizin kamusal alanda daimi sergilenmesi ya da satın alınması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Karma Sergi (Uluslararası)', 'Elektronik Karma Sergi (Ulusal)', 'Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Haber Olması (Uluslararası)', 'Eserin Haber Olması (Ulusal)'], 'puan' => 5],
    'A3' => ['baslik' => 'Sempozyum, festival, workshop ya da bienal gibi etkinliklere eserinizle katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 5],
    'A4-kitap' => ['baslik' => 'Alanınızla ilgili kitap yayımlamak', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı'], 'puan' => 12],
    'A4-bolum' => ['baslik' => 'Alanınızla ilgili kitap bölümü yayımlamak', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Kitap Bölümü'], 'puan' => 10],
    'A4-makale' => ['baslik' => 'Alanınızla ilgili makale yayımlamak', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI', 'ESCI / Scopus', 'TR Dizin', 'Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'], 'puan' => 5],
    'A4-tez' => ['baslik' => 'Lisansüstü tezinizden üretilmiş yayın', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI', 'ESCI / Scopus', 'TR Dizin', 'BKCI / Scopus Kitap', 'BKCI / Scopus Kitap Bölümü', 'Uluslararası/Ulusal Kitap', 'Kitap Bölümü', 'CPCI Bildiri', 'Diğer'], 'puan' => 5],
    'A4-ceviri-kitap' => ['baslik' => 'Alanınızla ilgili çeviri kitap yayımlamak', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 6],
    'A4-ceviri-makale' => ['baslik' => 'Alanınızla ilgili çeviri makale yayımlamak', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 2],
    'A5' => ['baslik' => 'Sempozyum, kongre ve panel gibi bilimsel ya da sanatsal toplantıya bildiriyle katılmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin', 'Uluslararası Özet/Poster', 'Ulusal Tam Metin', 'Ulusal Özet/Poster', 'Davetli Konuşmacı'], 'puan' => 5],

    // B ve C bölümlerinin ESER BAŞINA verilen satırları. Portföye bağlı
    // satırlar (bkz. başlık) girilmedi.
    'T3-BESTE' => ['baslik' => 'Özgün eser bestelemek ya da tasarlamak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım', 'Opera/Bale Kompozisyonu', 'Orkestralı Sahne Eseri', 'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Küçük Ölçekli Orkestra Eseri', 'Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Sahne/Ekran Müziği', 'Eğitim Müziği Albümü', 'Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi'], 'puan' => 30],
    'T3-KONSER' => ['baslik' => 'Bireysel ya da grup içinde dinleti, resital veya konser vermek; şeflik yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Uluslararası)', 'Resital (Ulusal)', 'Solistlik (Uluslararası)', 'Solistlik (Ulusal)', 'Oda Müziği Grup Üyeliği (Uluslararası)', 'Oda Müziği Grup Üyeliği (Ulusal)', 'Başkemancılık (Uluslararası)', 'Başkemancılık (Ulusal)', 'Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)', 'Karma Albüm / CD-DVD Katkısı', 'Orkestra / Koro Üyeliği', 'Orkestra Şefliği (Uluslararası)', 'Orkestra Şefliği (Ulusal)', 'Opera Şefliği (Uluslararası)', 'Opera Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Ulusal)', 'Koro Şefliği (Uluslararası)', 'Koro Şefliği (Ulusal)', 'Grup Şefliği (Uluslararası)', 'Grup Şefliği (Ulusal)'], 'puan' => 10],
    'T3-REJI' => ['baslik' => 'Oyun sahnelemek (reji) ya da yönetmenlik yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisörlük (Uluslararası)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Rejisör Yardımcılığı (Uluslararası)', 'Rejisör Yardımcılığı (Ulusal)', 'Rejisör Yardımcılığı (Konservatuvar)', 'Yönetmenlik (Sahne/Ekran)'], 'puan' => 30],
    'T3-SAHNE' => ['baslik' => 'Sahne, TV, radyo ya da sinema yapıtında performans göstermek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)'], 'puan' => 20],
    'T3-TASARIM' => ['baslik' => 'Oyun, film ya da gösteride sahne tasarımı (dekor, kostüm, ışık) yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne Tasarımı (Dekor, Kostüm, Işık)'], 'puan' => 15],
    'T3-JURI' => ['baslik' => 'Sanat ya da tasarım etkinliğinde jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 10],
    'T3-OPERA' => ['baslik' => 'Opera solisti olmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera Birinci Rol (Uluslararası)', 'Opera Birinci Rol (Ulusal)', 'Opera İkinci Rol (Uluslararası)', 'Opera İkinci Rol (Ulusal)', 'Şan Resitali (Uluslararası)', 'Şan Resitali (Ulusal)', 'Oratoryo/Kantat Solistliği (Uluslararası)', 'Oratoryo/Kantat Solistliği (Ulusal)'], 'puan' => 20],
    'T3-BALE' => ['baslik' => 'Seçkin kurumda solist olarak önemli rol almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bale Başrol (Uluslararası)', 'Bale Başrol (Ulusal)', 'Bale Solist Rol (Uluslararası)', 'Bale Solist Rol (Ulusal)'], 'puan' => 7],
    'T3-DANS' => ['baslik' => 'Dansçı olarak bir dans eserinde önemli rol almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Dansçı / Performans İcracısı (Uluslararası)', 'Dansçı / Performans İcracısı (Ulusal)', 'Corps de Ballet (Uluslararası)', 'Corps de Ballet (Ulusal)', 'Sahneleme/Repetitörlük — Tüm Perde (Uluslararası)', 'Sahneleme/Repetitörlük — Tüm Perde (Ulusal)', 'Sahneleme/Repetitörlük — Bölüm (Uluslararası)', 'Sahneleme/Repetitörlük — Bölüm (Ulusal)'], 'puan' => 6],
    'T3-KOREO' => ['baslik' => 'Koreografisini yaptığınız eseri sahnelemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koreografi', 'Bale/Dans Koreograflığı (Uluslararası)', 'Bale/Dans Koreograflığı (Ulusal)', 'Tüm Perde Koreograflığı (Uluslararası)', 'Tüm Perde Koreograflığı (Ulusal)', 'Bölüm Koreograflığı (Uluslararası)', 'Bölüm Koreograflığı (Ulusal)'], 'puan' => 2],
    'T3-DERS' => ['baslik' => 'Konservatuvar ya da dengi kurumda meslek dersi vermek, masterclass ya da eğitici konser programı yürütmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Masterclass (Uluslararası)', 'Masterclass (Ulusal)', 'Eğitim Amaçlı Sanat Etkinliği', 'Müzikoloji Atölyesi', 'Eğitici Konser Programı (Uluslararası)', 'Eğitici Konser Programı (Ulusal)'], 'puan' => 2],
    'T3-TEZ' => ['baslik' => 'Yürütücüsü olduğunuz ve sonuçlandırılmış lisansüstü tez ya da eser metin danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi', 'Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'puan' => 2],
    'T3-KORUMA' => ['baslik' => 'Taşınabilir kültür varlığı ya da sanat eseri restorasyon ve konservasyon uygulaması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)', 'Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman'], 'puan' => 5],
];

$gruplar = [
    'T1' => ['T1-*'],
    'T2' => ['T2-*'],
    'T3' => ['A1', 'A2', 'A3', 'A4-*', 'A5', 'T3-*'],
    'A4' => ['A4-*'],

    // MADDE 6/2-a, 6/4-b, 7/2-b-7, 8/2-b-5'in andığı makale kümeleri.
    'SCI-MAKALE' => ['T1-A1a', 'T1-A1b', 'T1-TEZ-A1'],
    'SCI-Q1Q2' => ['T1-A1a'],
    'DIGER-INDEKS-MAKALE' => ['T1-A2', 'T1-A3', 'T1-A4', 'T1-A5', 'T1-TEZ-A2', 'T1-TEZ-A4', 'T1-TEZ-A5'],
    'ISI-SCOPUS-MAKALE' => ['T1-A1a', 'T1-A1b', 'T1-A2', 'T1-TEZ-A1', 'T1-TEZ-A2'],
    'ULAKBIM-MAKALE' => ['T1-A4', 'T1-TEZ-A4'],
    'TUM-MAKALE' => ['T1-A1a', 'T1-A1b', 'T1-A2', 'T1-A3', 'T1-A4', 'T1-A5',
        'T1-TEZ-A1', 'T1-TEZ-A2', 'T1-TEZ-A4', 'T1-TEZ-A5'],

    // MADDE 6/2-c-5, 7/2-b-6, 7/3-b-5, 8/2-b-4, 8/3-b-5: kitap ve kitap bölümü.
    'KITAP' => ['T1-K1', 'T1-K2', 'T1-K3', 'T1-K3u', 'T1-K4', 'T1-K5', 'T1-TEZ-K1', 'T1-TEZ-K2', 'T1-TEZ-K4', 'T1-TEZ-K5'],
    'KITAP-EDITOR' => ['T1-K6', 'T1-K7'],

    // Proje kümeleri.
    'PROJE-AB' => ['T1-PR1', 'T1-PR2'],
    'PROJE-KAMU-Y' => ['T1-PR5'],
    'PROJE-KAMU-A' => ['T1-PR6'],
    'PROJE-Y' => ['T1-PR1', 'T1-PR3', 'T1-PR5', 'T1-PR7'],
    'PROJE-A' => ['T1-PR2', 'T1-PR4', 'T1-PR6', 'T1-PR8'],
    'PROJE-BAP-Y' => ['T1-PR7'],

    // Tamamlanmış tez danışmanlıkları (eş danışmanlık hariç).
    'TEZ-DOKTORA' => ['T2-DA1'],
    'TEZ-YL' => ['T2-DA3'],
];

$grupTavanlari = [
    // "Atıflardan en fazla 30 puan alınabilir."
    'ATIF' => 30,
    // "İdari görevler (her bir yıl için) (en fazla 15 puan)"
    'IDARI' => 15,
    // "Eğitim öğretim faaliyetleri son 5 yılda en fazla 10 puan"
    'EGITIM' => 10,
    // "Değişim programları (son 5 yılda, en fazla 10 puan)"
    'DEGISIM' => 10,
    // "Araştırma ve Eğitim Bursları (en fazla 10 puan)"
    'BURS' => 10,
];

$gruplar['ATIF'] = ['T2-AT1', 'T2-AT2', 'T2-AT3'];
$gruplar['IDARI'] = ['T2-ID1', 'T2-ID2', 'T2-ID3', 'T2-ID4', 'T2-ID5', 'T2-ID6'];
$gruplar['EGITIM'] = ['T2-EG1', 'T2-EG2'];
$gruplar['DEGISIM'] = ['T2-DG'];
$gruplar['BURS'] = ['T2-BU'];

return [
    'kapsam_notu' => 'Puanlar Isparta Uygulamalı Bilimler Üniversitesi Akademik Yükseltilme ve '
        .'Atanma Ölçütleri Yönergesi MADDE 10\'daki üç tablodan. Barajlar tablonun tamamına değil '
        .'BÖLÜMÜNE bağlı: Fen/Mühendislik ve Sosyal adayları Tablo 1 ile Tablo 2\'den, Güzel '
        .'Sanatlar adayları Tablo 2 ile Tablo 3\'ten puan topluyor. '
        .'Yazar çarpanı MADDE 9\'a göre işliyor. Yönerge iki farklı bölüşme kuralı veriyor '
        .'(Fen/Mühendislikte başlıca yazara ayrıcalık, Sosyalde eşit bölüşme); cetvel başına tek '
        .'matris tanımlanabildiği için her rolde İKİ KURALIN DÜŞÜĞÜ yazıldı — Fen/Mühendislik '
        .'adayının üç ve daha fazla yazarlı yayın puanı OLDUĞUNDAN DÜŞÜK görünür. Yazar listesini '
        .'boş bırakırsanız çarpan hiç uygulanmaz ve puanınız olduğundan YÜKSEK görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: idari görev ve dergi editörlükleri '
        .'yönergede "her bir yıl için" verildiği hâlde yıl biriktirmesi hesaplanamadığı için görev '
        .'başına tek yıl sayılıyor; patentte inceleme türü, dergi görevlerinde editör ile yardımcı '
        .'ve misafir editör ayrımı, davetli konuşmalarda uluslararası ile ulusal ayrımı kayıttan '
        .'okunamadığı için hepsi en düşük değerden sayılıyor; üniversite destekli bütün projeler '
        .'(münferit, tez ve alt yapı projeleri) tek satırdan en düşük değerle sayılıyor. Güzel '
        .'Sanatlar adaylarında Tablo 3\'ün alt disiplinleri (plastik sanatlar, müzik, sahne '
        .'sanatları) aynı türe farklı puan veriyor; kayıt alt disiplini taşımadığı için her tür '
        .'EN DÜŞÜK değerden sayılıyor ve puanı bir PORTFÖYE bağlı satırlar (altı eserlik beste '
        .'dosyası, üç saatlik resital dizisi, dört saatlik şeflik kaydı gibi) hiç girilemedi. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünebilir: eğitim öğretim, değişim programı '
        .'ve burs tavanları uygulanıyor ama yönergenin "son 5 yıl" penceresi uygulanmıyor; '
        .'bildiri ve hakemlikteki "yılda en çok 3 adet" sınırları da uygulanmıyor. '
        .'Patent ve proje BAŞVURULARINIZI kaydetmeyin: yönerge onlara ayrı ve düşük puan veriyor '
        .'ama kayıt türü sonuçlanmış olandan ayrılamadığı için o satırlar girilmedi. Lisans '
        .'öğrencilerine yönelik projeler MADDE 5/a ile açıkça dışlandığı için hiç sayılmıyor.',
    'yazar_katsayisi' => $yazarKatsayisi,
    'maddeler' => $maddeler,
    'gruplar' => $gruplar,
    'grup_tavanlari' => $grupTavanlari,
];
