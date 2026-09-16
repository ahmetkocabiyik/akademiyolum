<?php

/**
 * YALOVA ÜNİVERSİTESİ — EK-A…EK-E DEĞERLENDİRME PUAN TABLOLARI (01.07.2024)
 * Kaynak: pdf/17537010472.yalovauniverstesi.pdf
 *
 * ALTI ALAN, ALTI TABLO. Yönerge her temel alan için ayrı bir ek veriyor:
 *   EK-A Sosyal, Beşerî ve İdari Bilimler   EK-Ç Mimarlık, Planlama ve Tasarım
 *   EK-B Mühendislik                         EK-D Güzel Sanatlar
 *   EK-C Sağlık Bilimleri                    EK-E Spor Bilimleri
 *
 * Tablolar aynı bölüm iskeletini paylaşıyor (1 uluslararası makale · 2 ulusal
 * makale · 3 tezden üretilmiş yayın · 4 kitap · 5 atıf · 6 tez danışmanlığı ·
 * 7 proje · 8 bilimsel toplantı · 9 eğitim-öğretim · 10 patent · 11 ödül) ama
 * hem birim puanlar hem bölüm tavanları hem de son bölümler alana göre
 * değişiyor. Dosya EK-A'yı ortak gövde alıp beş varyant türetiyor.
 *
 * ── YAZAR PAYI (MADDE 10/4) ──
 * "Tek yazarlı makalelerde yazar tam puan alır. İki yazarlı makalelerde
 * başlıca yazar tam puanın 0.8'ini, ikinci yazar 0.5'ini alır. Üç veya daha
 * fazla yazarlı makalelerde ise, başlıca yazar toplam puanın yarısını alır,
 * diğer yazarlar ise diğer yarısını eşit paylaşır. Başlıca yazarın
 * belirtilmediği iki veya daha fazla yazarlı makalelerde toplam puan yazarlar
 * arasında eşit olarak bölünür. Diğer yayınlarda (bildiri, kitap) ise toplam
 * puan yazarlar arasında eşit olarak bölünür."
 *
 * İki ayrı kural var: makalede başlıca yazara ayrıcalık, kitap ve bildiride
 * eşit bölüşme. Motor kategoriye göre farklı yazar tablosu tanımıyor; her rol
 * için İKİ KURALDAN DÜŞÜK OLANI yazıldı:
 *   başlıca yazar → makale kuralı 2 yazarda 0.8, eşit bölüşme 0.5; her yazar
 *                   sayısında eşit bölüşme daha düşük olduğu için 1/n.
 *   ikinci ve sonraki → makale kuralı 0.5/(n-1); n≥3'te eşit bölüşmeden düşük,
 *                   n=2'de ona eşit. Bu yüzden 0.5/(n-1) yazıldı.
 * "Başlıca yazar" işaretlenmemiş ilk yazar da yönergeye göre eşit pay aldığı
 * için `ilk` rolü de 1/n.
 *
 * ── UYGULANMAYAN KURALLAR ──
 *   MADDE 10/3: Q1 veya Q2 dergideki makaleye %50 fazla puan, ama EN FAZLA
 *   İKİ YAYIN için. Motor "en çok iki yayına uygulanan çarpan" tanımıyor;
 *   ek puan hiç verilmedi, Q1/Q2 makaleleriniz düz puanla sayılıyor.
 *
 *   Kitabın %30 tavanı: "Aynı ISBN'ye sahip eserde b, c, e, f, h, ı
 *   maddelerinden alınacak toplam puan başvuru şartında istenen asgari puanın
 *   %30'undan fazlasını karşılayamaz." Bu bir KATEGORİ tavanı değil, AYNI
 *   ESERE özgü; kayıt aynı ISBN'li kalemleri birbirine bağlamadığı için
 *   uygulanamadı. Aynı kitabın birden çok satırından puan alan adayın kitap
 *   puanı olduğundan yüksek görünebilir.
 *
 *   Atıf (%20) ve tez danışmanlığı (%10) tavanları ise gerçek kategori
 *   tavanı; asgari puana uygulanıp sabit sayıya çevrildi ve UYGULANIYOR
 *   (bkz. dosya sonundaki varyant üretimi).
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   Kitap bölümünün "Yalova Üniversitesi Yayın Komisyonu onayıyla yayımlanmış
 *   kitap" (4f, 15 puan) ve çeviri kitap editörlüğü (4ı, 4j) satırları —
 *   kaynak sözlüğünde ayrı karşılıkları yok.
 *   Patent BAŞVURUSU (10ç, 2 puan) — sözlük tescil ile başvuruyu ayırmıyor.
 *   Bilimsel toplantıda başkanlık (8c) — sözlükte karşılıksız.
 *   Sosyal, Mühendislik ve Sağlık tablolarının "12. Diğer" bölümü (h-indeksi,
 *   yurt dışı araştırma, film festivali jüriliği, yönetmenlik).
 *   Her alanın "İdari Görev Faaliyeti" bölümü (görev başına 3, en çok 9 puan).
 *   Mimarlık ve Güzel Sanatlar'ın 14. bölümü ("Mesleki ve Diğer Araştırma
 *   Geliştirme Etkinlikleri": düzenleme kurulu, sekreterlik, küratörlük,
 *   oturum başkanlığı, danışmanlık).
 *   Sosyal tablosunun 11c bendi kaynakta "Tescil edilmiş faydalı model 25"
 *   yazıyor; diğer beş tabloda aynı yerde "TÜBİTAK Bilim Ödülü" var, yani
 *   kopyala-yapıştır hatası. Faydalı model zaten 10c'de 5 puan aldığı için
 *   satır Sosyal varyantına HİÇ konmadı; TÜBİTAK Bilim Ödülü yalnızca metnin
 *   onu açıkça yazdığı alanlara girildi.
 *
 * Yönerge: yonerge/yalova.php
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 */
$kapsamNotu = 'Puanlar Yalova Üniversitesi\'nin alanınıza ait Değerlendirme Puan Tablosundan. '
    .'Çok yazarlı eserlerde MADDE 10/4 yazar payı uygulandı; yönerge makale ile kitap-bildiri '
    .'için iki ayrı kural verdiği ve motor kategoriye göre ayrı tablo tanımadığı için her rolde '
    .'İKİ KURALIN DÜŞÜK OLANI kullanıldı — başlıca yazar olduğunuz iki yazarlı makalelerde '
    .'puanınız yönergenin verdiğinden düşük görünür. '
    .'Q1/Q2 dergilerdeki en çok iki yayına verilen %50 ek puan (MADDE 10/3) da uygulanmadı. '
    .'Bölüm tavanları uygulanıyor; atıf (%20) ve tez danışmanlığı (%10) tavanları asgari '
    .'puandan hesaplanıp uygulandı. Yalnız aynı ISBN\'li kitabın %30 sınırı uygulanamadı — '
    .'kayıt aynı esere ait kalemleri birbirine bağlamıyor; bir kitabın birden çok satırından '
    .'puan aldıysanız kitap puanınız YÜKSEK görünebilir. '
    .'Patent başvurusu, toplantı başkanlığı, "Diğer" bölümü (h-indeksi, yurt dışı araştırma) '
    .'ve idari görev satırları kaynak sözlüğünde karşılıksız olduğu için girilmedi. '
    .'ÖZET BİLDİRİLERİNİZ SAYILMAZ: yönerge bildiri satırlarını "poster hariç" diye '
    .'tanımlıyor, faaliyet kaydında ise özet ile poster tek etikette birleşik. İkisi '
    .'ayrılamadığı için etiket hiç sayılmadı; özet bildiriniz varsa bildiri puanınız ve '
    .'bildiri SAYINIZ olduğundan düşük görünür.';

// MADDE 10/4 — iki kuralın düşüğü. Yayın dışı kalemlerde yönerge sessiz.
$yazarKatsayisi = [
    'haric' => ['atif', 'proje', 'tez_danismanligi', 'editorluk', 'odul',
        'egitim_ogretim', 'patent', 'sanatsal_etkinlik', 'idari_gorev', 'diger'],
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.0]],
        'ilk' => ['sonrasi_pay' => 1.0],
        'baslica' => ['sonrasi_pay' => 1.0],
        'yazar_2' => ['kademeler' => [1 => 1.0], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
        'yazar_3' => ['kademeler' => [1 => 1.0], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
        'yazar_4' => ['kademeler' => [1 => 1.0], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
        'yazar_5' => ['kademeler' => [1 => 1.0], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
        'yazar_6' => ['kademeler' => [1 => 1.0], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
        'ortak' => ['kademeler' => [1 => 1.0], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
    ],
];

// ── ORTAK GÖVDE (EK-A: Sosyal, Beşerî ve İdari Bilimler) ────────────────────
$maddeler = [
    // ══ 1. ULUSLARARASI MAKALE (lisansüstü tezlerden üretilmemiş) ══
    '1a' => ['baslik' => 'SCIE, SSCI veya AHCI kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 20],
    '1b' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 10],
    // 1c'nin yıldız dipnotu KAPALI BİR LİSTE: "Diğer Uluslararası Alan
    // İndeksleri" başlığı altında AATA'dan Current Law Index'e uzanan ÜAK
    // listesi. 1ç ise o listenin DIŞINDA kalan her indeks. Sözlükteki tek
    // `Diğer Uluslararası İndeks` etiketi ikisini ayıramıyor; `puan()` en
    // yükseği aldığı için etiket burada da dursaydı listede olmayan bir
    // indeksteki makale 1c'nin puanını alırdı (§0). Etiket 1ç'de duruyor,
    // 1c bilerek ölü. Aynı sebeple mimarlık doçentliğinin "1. madde (1ç
    // hariç)" koşulu bu etiketle sağlanamıyor — eksik sayma, serbest.
    '1c' => ['baslik' => 'Diğer uluslararası alan indekslerinde taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => [], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 8],
    '1ç' => ['baslik' => 'Diğer uluslararası indekslerde taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 5],
    '1d' => ['baslik' => 'Uluslararası dergide editöre mektup, araştırma notu, özet veya kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI', 'ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 3],

    // ══ 2. ULUSAL MAKALE ══
    '2a' => ['baslik' => 'TR Dizin kapsamındaki ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 10],
    '2b' => ['baslik' => 'Diğer ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 5],
    '2c' => ['baslik' => 'Ulusal hakemli dergide editöre mektup, araştırma notu, özet veya kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 2],

    // ══ 3. LİSANSÜSTÜ TEZLERDEN ÜRETİLMİŞ YAYIN ══
    '3a' => ['baslik' => 'Tezden üretilmiş, SCIE, SSCI veya AHCI kapsamındaki dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 20],
    '3b' => ['baslik' => 'Tezden üretilmiş, ESCI veya Scopus kapsamındaki dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 10],
    '3c' => ['baslik' => 'Tezden üretilmiş, TR Dizin kapsamındaki dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['TR Dizin'], 'puan' => 8],
    '3ç' => ['baslik' => 'Tezden üretilmiş, diğer uluslararası indeksli dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Diğer (Uluslararası)'], 'puan' => 5],
    '3d' => ['baslik' => 'Tezden üretilmiş, uluslararası yayınevinde kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 10],
    '3e' => ['baslik' => 'Tezden üretilmiş, uluslararası yayınevinde kitap bölümü', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 5],
    '3f' => ['baslik' => 'Tezden üretilmiş, ulusal yayınevinde kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 3],
    '3g' => ['baslik' => 'Tezden üretilmiş, ulusal yayınevinde kitap bölümü', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 2],
    '3ğ' => ['baslik' => 'Tezden üretilmiş, bilimsel toplantıda sunulmuş çalışma', 'kategori' => 'tez_yayini', 'kaynaklar' => ['CPCI Bildiri'], 'puan' => 3],

    // ══ 4. KİTAP ══
    '4a' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
    '4b' => ['baslik' => 'Uluslararası yayınevi kitabında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 10],
    '4c' => ['baslik' => 'Uluslararası yayınevi kitabında bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 8],
    '4ç' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı', 'Tahkik (Tenkitli Metin)'], 'puan' => 15],
    '4d' => ['baslik' => 'Ulusal yayınevi kitabında bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 4],
    '4e' => ['baslik' => 'Ulusal yayınevi kitabında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 4],
    '4g' => ['baslik' => 'Alana özgü ansiklopedide madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 3],
    '4h' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış çeviri kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 10],
    '4k' => ['baslik' => 'Çeviri kitapta bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 4],

    // ══ 5. ATIFLAR ══
    '5a' => ['baslik' => 'SCIE, SSCI, AHCI, ESCI veya Scopus kapsamındaki dergilerde atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
    '5b' => ['baslik' => 'TR Dizin, diğer uluslararası alan indeksi veya uluslararası kitapta atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'BKCI Kitap'], 'puan' => 2],
    '5c' => ['baslik' => 'Ulusal kitap veya diğer dergilerde atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],

    // ══ 6. LİSANSÜSTÜ TEZ DANIŞMANLIĞI ══
    '6a' => ['baslik' => 'Doktora tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 5],
    '6b' => ['baslik' => 'Yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 3],

    // ══ 7. BİLİMSEL ARAŞTIRMA PROJESİ ══
    '7a' => ['baslik' => 'AB Çerçeve Programı projesinde koordinatör veya baş araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 15],
    '7b' => ['baslik' => 'AB Çerçeve Programı projesinde ortak araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
    '7c' => ['baslik' => 'Diğer uluslararası destekli projede yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 6],
    '7ç' => ['baslik' => 'Diğer uluslararası destekli projede araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 4],
    '7d' => ['baslik' => 'TÜBİTAK projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 10],
    '7e' => ['baslik' => 'TÜBİTAK projesinde araştırmacı veya danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 6],
    '7f' => ['baslik' => 'Üniversiteler dışındaki kamu kurumu projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 6],
    '7g' => ['baslik' => 'Üniversiteler dışındaki kamu kurumu projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 4],
    '7ğ' => ['baslik' => 'BAP projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 3],
    '7h' => ['baslik' => 'BAP projesinde araştırmacı veya danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 1],
    '7ı' => ['baslik' => 'Şirket veya sivil kurum protokolüyle yürütülen projede yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 4],
    '7i' => ['baslik' => 'Şirket veya sivil kurum protokolüyle yürütülen projede araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 2],

    // ══ 8. BİLİMSEL TOPLANTI VE BİLİMSEL FAALİYET GÖREVLERİ ══
    // POSTER ETİKETİ BİLEREK YOK. Kaynak 8a ve 8b'yi "tam metni veya özeti
    // … yayımlanmış bildiri (POSTER HARİÇ)" diye tanımlıyor. Sözlükteki
    // 'Uluslararası Özet/Poster' etiketi özeti (kaynağın SAYDIĞI) posterle
    // (kaynağın SAYMADIĞI) birleştiriyor ve ikisi ayrılamıyor; §0 uyarınca
    // dışlayan kol seçildi. Özet bildiriniz bu iki satırdan puan almaz ve
    // bildiri SAYISI koşullarına da girmez — puanınız olduğundan düşük
    // görünür. Poster sayılsaydı ters yönde, yani yasak yönde saparlardı.
    '8a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan bildiri (poster hariç)', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 5],
    '8b' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan bildiri (poster hariç)', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 3],
    '8ç' => ['baslik' => 'Uluslararası bilimsel toplantıda davetli konuşmacı olarak sunum', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 4],
    '8d' => ['baslik' => 'SCIE, SSCI, AHCI veya ESCI kapsamındaki dergide baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 6],
    '8e' => ['baslik' => 'Alan indeksli diğer dergilerde baş editörlük veya editör yardımcılığı', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi', 'Yayın Kurulu Üyeliği'], 'puan' => 4],
    '8f' => ['baslik' => 'SCIE, SSCI, AHCI veya ESCI kapsamındaki dergide hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 3],

    // ══ 9. EĞİTİM-ÖĞRETİM FAALİYETİ ══
    '9a' => ['baslik' => 'Bir dönem yüksek lisans veya doktora dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
    '9b' => ['baslik' => 'Bir dönem ön lisans veya lisans dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 2],

    // ══ 10. PATENT / FAYDALI MODEL ══
    '10a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent', 'Ticarileştirme'], 'puan' => 20],
    '10b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 10],
    '10c' => ['baslik' => 'Tescil edilmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 5],

    // ══ 11. ÖDÜL ══
    '11a' => ['baslik' => 'YÖK Yılın Doktora Tezi veya Üstün Başarı Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü'], 'puan' => 25],
    '11ç' => ['baslik' => 'TÜBİTAK Teşvik Ödülü (UBYT hariç)', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü', 'Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 15],
    '11d' => ['baslik' => 'TÜBA GEBİP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 5],
    '11e' => ['baslik' => 'TÜBA TESEP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon', 'Burs'], 'puan' => 3],
];

// Sosyal dışındaki tabloların 11c bendi.
$tubitakBilim = ['11c' => ['baslik' => 'TÜBİTAK Bilim Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü'], 'puan' => 25]];

// ── SANAT ALANLARININ ORTAK 11 ve 12. BÖLÜMÜ (Mimarlık, Güzel Sanatlar) ─────
$sanatOdulJuri = [
    '11a' => ['baslik' => 'Uluslararası bilim, sanat, tasarım veya proje yarışmasında derece', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü'], 'puan' => 25],
    '11b' => ['baslik' => 'Uluslararası yarışmada mansiyon', 'kategori' => 'odul', 'kaynaklar' => ['Ufuk Avrupa / ERC Ödülü'], 'puan' => 20],
    '11ç' => ['baslik' => 'Ulusal bilim, sanat, tasarım veya proje yarışmasında derece', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü'], 'puan' => 20],
    '11d' => ['baslik' => 'Ulusal yarışmada mansiyon veya diğer ödül', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 15],
    '11g' => ['baslik' => 'Kamuoyunda kabul görmüş kurumlarca verilen ulusal ödül', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 5],
    '12a' => ['baslik' => 'Uluslararası sanat ve tasarım etkinliğinde jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], 'puan' => 25],
    '12b' => ['baslik' => 'Ulusal sanat ve tasarım etkinliğinde jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 20],
];

// ── GÜZEL SANATLAR — 13. bölüm: SANATSAL FAALİYETLER (13.1–13.6) ────────────
$sanatsal = [
    '13.1a' => ['baslik' => 'Uluslararası bireysel sanat etkinliği (sergi, bienal, dinleti, gösterim)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Solistlik (Uluslararası)', 'Resital (Uluslararası)', 'Elektronik Kişisel Sergi (Uluslararası)'], 'puan' => 25],
    '13.1b' => ['baslik' => 'Ulusal bireysel sanat etkinliği (sergi, bienal, dinleti, gösterim)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Solistlik (Ulusal)', 'Resital (Ulusal)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 20],
    '13.1c' => ['baslik' => 'Uluslararası karma-ortak etkinliğe katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Karma Sergi (Uluslararası)', 'Orkestra / Koro Üyeliği', 'Oda Müziği Grup Üyeliği (Uluslararası)'], 'puan' => 10],
    '13.1ç' => ['baslik' => 'Ulusal karma-ortak etkinliğe katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Ulusal)', 'Oda Müziği Grup Üyeliği (Ulusal)', 'Karma Albüm / CD-DVD Katkısı'], 'puan' => 5],
    '13.1d' => ['baslik' => 'Uluslararası seçici kurullu sergi, sempozyum, festival veya bienale katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 15],
    '13.1e' => ['baslik' => 'Ulusal seçici kurullu sergi, sempozyum, festival veya bienale katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 12],
    '13.2a' => ['baslik' => 'Yurt dışı tanınmış müze veya büyük koleksiyonda yapıtının yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Yayında Yer Alması / Satın Alınması'], 'puan' => 20],
    '13.2b' => ['baslik' => 'Yurt içi tanınmış müze veya büyük koleksiyonda yapıtının yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Satın Alınması (Yurt İçi)'], 'puan' => 15],
    '13.4a' => ['baslik' => 'Uluslararası tasarım alanında üretime girmiş çalışma veya koleksiyon', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım', 'Opera/Bale Kompozisyonu', 'Senfoni Kompozisyonu'], 'puan' => 25],
    '13.4c' => ['baslik' => 'Ulusal tasarım alanında üretime girmiş çalışma veya koleksiyon', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Konçerto/Senfonik Şiir', 'Küçük Ölçekli Orkestra Eseri', 'Oda/Koro Müziği Eseri (≥15 dk)'], 'puan' => 15],
    '13.5a' => ['baslik' => 'Uluslararası etkinlikte film gösterisi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Belgesel/Kısa Film (Uluslararası)'], 'puan' => 25],
    '13.5c' => ['baslik' => 'Ulusal etkinlikte film gösterisi veya ulusal yayında filminin yayımlanması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Belgesel/Kısa Film (Ulusal)', 'Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)'], 'puan' => 15],
    '13.5e' => ['baslik' => 'Uluslararası etkinlikte gösterilen filmin yaratıcı kadrosunda yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Yönetmenlik (Sahne/Ekran)', 'Koreografi', 'Sahne Tasarımı (Dekor, Kostüm, Işık)'], 'puan' => 10],
    '13.6a' => ['baslik' => 'Uluslararası görsel-işitsel tasarım gösterisi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Dansçı / Performans İcracısı (Uluslararası)', 'Grup Şefliği (Uluslararası)', 'Başkemancılık (Uluslararası)'], 'puan' => 25],
    '13.6c' => ['baslik' => 'Ulusal görsel-işitsel tasarım gösterisi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Dansçı / Performans İcracısı (Ulusal)', 'Grup Şefliği (Ulusal)', 'Başkemancılık (Ulusal)'], 'puan' => 15],
];

// ── MİMARLIK — 13. bölüm: YARIŞMA, PROJE VE YAZILIM ─────────────────────────
$mimarlikEk = [
    '13a' => ['baslik' => 'Yasa ve yönetmelik çerçevesinde düzenlenmiş tasarım yarışmasında ödül veya mansiyon', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Karma/Jürili Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Ulusal)'], 'puan' => 15],
    '13b' => ['baslik' => 'Uygulanmış veya tamamlanmış tasarım, planlama ya da koruma projesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman', 'Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)'], 'puan' => 10],
];

$gruplar = [
    // Önek eşleşmesi ('1*') 10 ve 11. bölümü de yakaladığı için bölümler
    // açıkça sayıldı. Bir varyantta bulunmayan kod sessizce atlanır.
    '1' => ['1a', '1b', '1c', '1ç', '1d', '1e', '1f'],
    '1a' => ['1a'],
    '1a-1b' => ['1a', '1b'],
    // Mimarlık doçentlik koşulu: "1. madde (1ç bendi hariç)".
    '1-1ç-haric' => ['1a', '1b', '1c', '1d'],
    '2' => ['2a', '2b', '2c', '2ç'],
    '2a' => ['2a'],
    '3' => ['3a', '3b', '3c', '3ç', '3d', '3e', '3f', '3g', '3ğ'],
    '3a' => ['3a'],
    '4' => ['4a', '4b', '4c', '4ç', '4d', '4e', '4g', '4h', '4k'],
    '5' => ['5a', '5b', '5c'],
    '6' => ['6a', '6b'],
    '7' => ['7a', '7b', '7c', '7ç', '7d', '7e', '7f', '7g', '7ğ', '7h', '7ı', '7i'],
    // Profesörlükte "7. maddeden (7ğ-7h hariç)".
    '7-bap-haric' => ['7a', '7b', '7c', '7ç', '7d', '7e', '7f', '7g', '7ı', '7i'],
    '8' => ['8a', '8b', '8ç', '8d', '8e', '8f'],
    '9' => ['9a', '9b'],
    '10' => ['10a', '10b', '10c'],
    '11' => ['11a', '11b', '11c', '11ç', '11d', '11e', '11g'],
    // Koşul metinlerinin andığı bileşik kümeler.
    '1-2' => ['1', '2'],
    '1-2-3' => ['1', '2', '3'],
    '1-2-3-4' => ['1', '2', '3', '4'],
    '1-2-3-4-5-8' => ['1', '2', '3', '4', '5', '8'],
    '1-2-3-4-8' => ['1', '2', '3', '4', '8'],
    '1-2-3-4-7-10' => ['1', '2', '3', '4', '7', '10'],
    '1-2-3-5-8' => ['1', '2', '3', '5', '8'],
    '1-2-4' => ['1', '2', '4'],
    '1-2-4-7-8' => ['1', '2', '4', '7', '8'],
];

/**
 * @param  array<string, array<string, mixed>>  $fark
 * @param  array<string, array<string, mixed>>  $ek
 * @param  array<string, list<string>>  $ekGrup
 * @param  array<string, int>  $tavanlar
 * @param  list<string>  $sil
 * @return array<string, mixed>
 */
$cetvel = function (string $notEki, array $tavanlar, array $fark = [], array $ek = [], array $ekGrup = [], array $sil = []) use ($kapsamNotu, $maddeler, $gruplar, $yazarKatsayisi): array {
    foreach ($sil as $kod) {
        unset($maddeler[$kod]);
    }

    foreach ($fark as $kod => $degisiklik) {
        $maddeler[$kod] = array_replace($maddeler[$kod] ?? [], $degisiklik);
    }

    return [
        'kapsam_notu' => $kapsamNotu.$notEki,
        'maddeler' => $maddeler + $ek,
        'gruplar' => $gruplar + $ekGrup,
        'grup_tavanlari' => $tavanlar,
        'yazar_katsayisi' => $yazarKatsayisi,
    ];
};

/**
 * YÜZDE TABANLI TAVANLAR: ASGARİ PUANA GÖRE VARYANT.
 *
 * Sosyal (EK-A) ve Mimarlık (EK-Ç) tabloları atıf ve tez danışmanlığı
 * tavanını mutlak sayıyla değil YÜZDEYLE veriyor: "Bu madde kapsamında ibraz
 * edilen puan; başvuru şartlarında istenen asgari puanın %20'sinden (tez
 * danışmanlığında %10'undan) fazlasını karşılayamaz." Motor mutlak tavan
 * aldığı için yüzde, kadronun asgari puanına uygulanıp sabit sayıya
 * çevriliyor — Acıbadem'in atıf tavanında yaptığının aynısı.
 *
 * Yalova'nın asgari puanları: dr. öğr. üyeliği ilk atama 50, yeniden atanma
 * 40, doçentlik ve profesörlük 150. Mimarlık'ın tez tavanı zaten mutlak (20),
 * o yüzden yalnız atıf tavanı türetiliyor.
 *
 * DİĞER TABLOLARDA GEREKMİYOR: Mühendislik, Sağlık, Güzel Sanatlar ve Spor
 * tabloları atıf ve tez tavanını zaten mutlak sayıyla veriyor.
 *
 * @var list<int>
 */
$asgariPuanlar = [40, 50, 150];

$cetveller = [
    // ══════════ EK-A Sosyal, Beşerî ve İdari Bilimler ══════════
    'yalova-2024-sosyal' => $cetvel(
        ' Sosyal tablosunda şirket protokolüyle yürütülen proje satırı yok.',
        ['7' => 20, '8' => 10, '9' => 10, '11' => 25],
        [],
        [],
        [],
        ['7ı', '7i'],
    ),

    // ══════════ EK-B Mühendislik ══════════
    'yalova-2024-muhendislik' => $cetvel(
        ' Mühendislik tablosunda diğer ulusal hakemli dergi makalesi 5 yerine 4 puan.',
        ['5' => 20, '6' => 10, '7' => 20, '8' => 10, '9' => 10, '11' => 25],
        ['2b' => ['puan' => 4]] + $tubitakBilim,
        [],
        [],
        ['7ı', '7i'],
    ),

    // ══════════ EK-C Sağlık Bilimleri ══════════
    'yalova-2024-saglik' => $cetvel(
        ' Sağlık tablosunda olgu sunumu ve derleme için ayrı satırlar var; şirket ve sivil '
        .'kurum projeleri de puanlanıyor.',
        ['3' => 20, '4' => 20, '5' => 20, '6' => 10, '7' => 20, '9' => 10, '11' => 25],
        [
            // Sağlık tablosu derlemeyi özgün makaleden ayırıp daha düşük
            // puanlıyor (1e, 1f, 2c, 2ç); diğer tablolarda böyle bir ayrım yok.
            //
            // OLGU SUNUMU İLE EDİTÖRE MEKTUP AYNI TÜR KOVASINDA. Sözlüğün
            // `vaka_teknik_not` türü "vaka sunumu, teknik not, editöre mektup"
            // demek; kaynak ise ikisini AYIRIP ÇAPRAZLIYOR: SSCI/SCIE/AHCI'de
            // olgu sunumu 5 · editöre mektup 3, ESCI/Scopus ve alan indeksinde
            // olgu sunumu 2 · editöre mektup 3. Hangi satıra bağlansa bir
            // yönde fazla sayardı (§0), bu yüzden `vaka_teknik_not` 1e/1f'ten
            // ÇIKARILDI ve 1d indeks kademesine göre ikiye bölündü:
            // indeksli dergilerde 3, ESCI/Scopus ve alan indeksinde 2.
            '1d' => ['baslik' => 'SCIE, SSCI veya AHCI kapsamındaki dergide editöre mektup, araştırma notu, özet, kitap kritiği ya da olgu sunumu', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'puan' => 3],
            '1a' => ['turler' => ['ozgun_makale']],
            '1b' => ['turler' => ['ozgun_makale']],
            '1c' => ['turler' => ['ozgun_makale']],
            '1ç' => ['turler' => ['ozgun_makale']],
            '2a' => ['turler' => ['ozgun_makale']],
            '2b' => ['puan' => 4, 'turler' => ['ozgun_makale']],
            // TR Dizin'de editöre mektup/özet/kitap kritiği satırı YOK (2d
            // yalnız "diğer ulusal hakemli" diyor); `vaka_teknik_not` bu
            // satırda kalsaydı karşılıksız bir puan verirdi.
            '2c' => ['baslik' => 'TR Dizin kapsamındaki dergide olgu sunumu veya derleme', 'kaynaklar' => ['TR Dizin'], 'turler' => ['derleme'], 'puan' => 3],
        ] + $tubitakBilim,
        [
            '1e' => ['baslik' => 'SCIE, SSCI veya AHCI kapsamındaki dergide derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme'], 'puan' => 5],
            '1f' => ['baslik' => 'ESCI, Scopus veya alan indeksli dergide olgu sunumu veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['derleme', 'vaka_teknik_not'], 'puan' => 2],
            // 1d'nin ESCI/Scopus ve alan indeksi kolu: olgu sunumu 2, editöre
            // mektup 3 → §0 uyarınca 2.
            '1d2' => ['baslik' => 'ESCI, Scopus veya alan indeksli dergide editöre mektup, araştırma notu, özet ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 2],
            '2ç' => ['baslik' => 'Diğer ulusal hakemli dergide olgu sunumu veya derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['derleme', 'vaka_teknik_not'], 'puan' => 2],
            'e' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Ulusal)'], 'puan' => 5],
            'c' => ['baslik' => 'Bilimsel toplantı düzenleme kurulu başkanlığı (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 15],
            'f' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 5],
            'd' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 10],
            'o' => ['baslik' => 'Bilimsel toplantıda oturum başkanlığı (ulusal)', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Ulusal)'], 'puan' => 3],
            'n' => ['baslik' => 'Bilimsel toplantıda oturum başkanlığı (uluslararası)', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Uluslararası)'], 'puan' => 5],
        ],
    ),

    // ══════════ EK-Ç Mimarlık, Planlama ve Tasarım ══════════
    'yalova-2024-mimarlik' => $cetvel(
        ' Mimarlık tablosunda ödül bölümü yarışma derecelerine göre kurulu; ayrıca jüri '
        .'üyeliği ile yarışma-proje-yazılım bölümleri var.',
        ['6' => 20, '7' => 30, '8' => 20, '9' => 10],
        ['1c' => ['puan' => 6], '1ç' => ['puan' => 4], '2b' => ['puan' => 6]] + $sanatOdulJuri,
        $mimarlikEk,
        ['12' => ['12a', '12b'], '13' => ['13*']],
        ['11ç', '11e', '7ı', '7i'],
    ),

    // ══════════ EK-D Güzel Sanatlar ══════════
    'yalova-2024-guzel-sanatlar' => $cetvel(
        ' Güzel Sanatlar tablosunun on üçüncü bölümü sanatsal faaliyetlere ayrılmış; koşullar '
        .'da puanın büyük kısmını o bölümden istiyor. On üçüncü bölümün alt tabloları '
        .'(13.3 kamusal alanda sergilenen ürün, 13.5 film yaratıcı kadrosunun ulusal '
        .'satırları) sözlükte ayrı karşılıkları olmadığı için tam girilemedi.',
        ['5' => 20, '7' => 20, '8' => 20, '9' => 10, '11' => 25],
        ['1c' => ['puan' => 6], '1ç' => ['puan' => 4], '2b' => ['puan' => 6]] + $sanatOdulJuri,
        $sanatsal,
        ['12' => ['12a', '12b'], '13' => ['13*']],
        ['11ç', '11e', '7ı', '7i'],
    ),

    // ══════════ EK-E Spor Bilimleri ══════════
    'yalova-2024-spor' => $cetvel(
        ' Spor tablosunda ödül bölümü yalnızca dört satır; TÜBA ödülleri yer almıyor.',
        ['4' => 20, '5' => 20, '6' => 10, '7' => 20, '8' => 10, '9' => 10, '11' => 25],
        ['5a' => ['baslik' => 'SCIE, SSCI, AHCI, ESCI, SPORT Discus veya Scopus kapsamındaki dergilerde atıf']] + $tubitakBilim,
        [],
        [],
        ['11d', '11e'],
    ),
];

// Sosyal ve Mimarlık'ın yüzde tabanlı tavanları asgari puana göre sabit
// sayıya çevriliyor; her kadro kendi varyantına bağlanıyor.
foreach ($asgariPuanlar as $asgari) {
    $atif = (int) round($asgari * 0.20);
    $tez = (int) round($asgari * 0.10);

    $cetveller["yalova-2024-sosyal-a{$asgari}"] = array_replace_recursive(
        $cetveller['yalova-2024-sosyal'],
        ['grup_tavanlari' => ['5' => $atif, '6' => $tez]],
    );

    // Mimarlık'ın tez tavanı zaten mutlak (20); yalnız atıf türetiliyor.
    $cetveller["yalova-2024-mimarlik-a{$asgari}"] = array_replace_recursive(
        $cetveller['yalova-2024-mimarlik'],
        ['grup_tavanlari' => ['5' => $atif]],
    );
}

return ['cetveller' => $cetveller];
