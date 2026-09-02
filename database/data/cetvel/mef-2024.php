<?php

/**
 * MEF ÜNİVERSİTESİ — Akademik Faaliyet Puanları
 * Kaynak: pdf/17537102972.mefuniversitesi.pdf
 *
 * BELGEDE TARİH YOK; dosya adındaki 2024 PDF'in oluşturma tarihinden
 * (23/12/2024).
 *
 * ── ON BEŞ VARYANT: TAVANLAR FAKÜLTE × KADRO ──
 * Korpusun en katmanlı cetveli. Tek bir puan tablosu var ama tablonun her
 * bölümünün altında fakülte fakülte tavan notları duruyor ve tavanlar kadroya
 * göre de değişiyor ("Mühendislik Fakültesi: Doçent kadrosuna atanabilmek için
 * bu bölümden en fazla 30 puan alınabilir. Profesör kadrosuna atanabilmek için
 * en fazla 50 puan"). Beş fakülte × üç kadro = 15 varyant üretildi:
 *   mef-2024-{muhendislik|mimarlik|hukuk|sosyal|egitim}-{dr|docent|profesor}
 *
 * Gövde hepsinde aynı; değişen iki şey var: `grup_tavanlari` ve Hukuk
 * Fakültesinde 4.c ile 4.d satırlarının puanı (tabloda "5 - 20 (Hukuk)" ve
 * "3 - 10 (Hukuk)" diye yazılı).
 *
 * 13. bölüm yalnızca Mimarlık'a, 14. bölüm yalnızca Eğitim Fakültesine açık
 * ("Diğer Fakülteler: Bu bölümden puan alamaz"); öteki varyantlarda o
 * grupların tavanı sıfır.
 *
 * ── YAZAR FORMÜLÜ FAKÜLTEYE GÖRE İKİ FARKLI ──
 * "Hukuk Fakültesi: Tek yazarlı yayınlarda yazar tam puan alır. Çok yazarlı
 * yayınlarda puan yazarlar arasında eşit olarak bölünür." → p/n.
 * "Diğer Fakülteler: tek kişi p · iki kişi 0,8p · üç ile beş kişi arası
 * 1,8p/n · altı ve daha fazla kişi p/n." → kademeler (1,00/0,80/0,60/0,45/
 * 0,36) ve altıdan sonrası için `bol`. İkisi de yalnızca kişi sayısına bakıyor,
 * sıraya değil.
 *
 * ── AYNI KAYNAĞA DÜŞEN SATIRLARDA DAİMA DÜŞÜĞÜ GİRİLDİ ──
 *   Kitap 4.a BKCI (20) / 4.c diğer (5): 'BKCI / Scopus Kitap' indekslendiğini
 *       söylüyor, 4.a'ya yazıldı; dili ve yayınevini taşımayan
 *       'Uluslararası/Ulusal Kitap' 4.c'ye düştü. Bölümde aynı ayrım
 *       (4.b ↔ 4.d).
 *   Atıf 5.a (3) / 5.b (2) / 5.c (2) / 5.d (1): kaynak etiketleri indeksi
 *       söylediği için her biri kendi satırına gitti, belirsiz kalan 'Diğer'
 *       ve 'Patent' en düşük satıra (5.d).
 *   Toplantı 8.a CPCI (5) / 8.b diğer (3): CPCI etiketi taşımayan bütün
 *       bildiriler ve davetli konuşmacılık 8.b'ye düştü.
 *
 * ── LİSANSÜSTÜ TEZ YAYINI KORPUSTA İLK KEZ GERÇEKTEN KULLANILIYOR ──
 * 3. bölüm tamamen "lisansüstü tezlerden üretilmiş yayın" için; faaliyet
 * kaydının `tez_yayini` kategorisi burada birebir karşılık buluyor. Aynı
 * çalışmayı makale olarak kaydeden aday 1. bölümden, tez yayını olarak
 * kaydeden 3. bölümden puan alır — ikisi farklı tavanlara tabi.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   14. BÖLÜMÜN TAMAMI (Eğitim Fakültesi özel şartları: okullarla iş birliği
 *       çerçevesinde öğretmenlik, psikolojik danışmanlık, aday öğretmen
 *       denetimi). Sözlükte karşılığı yok. Eğitim Fakültesinin doçentlik ve
 *       profesörlük koşullarından biri doğrudan bu bölümün c bendine
 *       dayanıyor; o koşul yönerge dosyasında `hesaplanamiyor` olarak duruyor.
 *   15. bölüm (h-indeksi ≥ 5 ve altı aylık yurt dışı araştırma): ikisi de
 *       profil verisi, faaliyet kaydında satırı yok.
 *   2.d (MEF Hukuk Fakültesi Dergisi) — tek bir derginin adı, kayıt dergi
 *       adını tutmuyor.
 *   3.c (diğer uluslararası indeksli tez yayını) — `tez_yayini` kaynak listesi
 *       o kademeyi taşımıyor; 'Diğer' en düşük satıra (3.j) düştü.
 *   6.c (lisans/lisansüstü bitirme projesi), 10.d (patent başvurusu),
 *       13.b (uygulanmış proje hakkında yayın), 13.d (yazılım üreticiliği —
 *       'Yazılım' kaynağı zaten 10.c'ye düşüyor).
 *   11. bölüm YALNIZCA ALTI ADI GEÇEN ÖDÜLÜ sayıyor (YÖK Doktora Tezi, YÖK
 *       Üstün Başarı, TÜBİTAK Bilim, TÜBİTAK Teşvik, TÜBA GEBİP, TÜBA TESEP);
 *       uluslararası ödüller, yarışma dereceleri ve burslar tabloda YOK.
 *   Dergi hakemliği ve yayın kurulu üyeliği için satır yok; 12. bölüm yalnızca
 *       editörlüğü sayıyor. Kaydınız görevi ayırmadığı için dergi düzeyi
 *       kaynakları editörlük satırlarına yazıldı — puanları 1-2 ve tavanları
 *       4/8 olduğu için sapma önemsiz.
 *   Sanatsal etkinlik, sahne ve icra kalemleri: MEF'in beş fakültesi arasında
 *       güzel sanatlar yok, tabloda da satırı yok.
 *
 * ── ATIFTA KENDİ ATFI AYIKLANAMIYOR ──
 * "Adayın kendi eserlerine yaptığı atıf değerlendirmeye alınmaz. Adayın bir
 * eserine aynı yayında birden fazla atıf tek atıf sayılır." Kayıt ikisini de
 * ayırt etmiyor; atıf puanı OLDUĞUNDAN YÜKSEK çıkar. Bölüm tavanları (5-20
 * puan) sapmayı sınırlıyor.
 *
 * Yönerge: yonerge/mef.php
 */
$kapsamNotu = 'Puanlar MEF Üniversitesi Akademik Faaliyet Puanları tablosundan. TAVANLAR '
    .'FAKÜLTENİZE VE BAŞVURDUĞUNUZ KADROYA GÖRE DEĞİŞİYOR: tablonun her bölümünün altında '
    .'fakülte fakülte "bu bölümden en fazla N puan alınabilir" notları var ve N doçentlikte '
    .'bir, profesörlükte başka. Burada kendi fakülteniz ve kadronuz için geçerli tavanlar '
    .'uygulanır. '
    .'Çok yazarlı çalışmalarda Hukuk Fakültesinde puan yazarlar arasında eşit bölünür; '
    .'öteki fakültelerde tek yazarlı tam puan, iki yazarlı %80, üç ile beş yazarlı '
    .'1,8 × puan / yazar sayısı, altı ve daha fazlasında puan / yazar sayısı. Formül yazar '
    .'sırasına bakmıyor; yazar listesini boş bırakırsanız uygulanamaz ve puanınız olduğundan '
    .'YÜKSEK görünür. Atıf, proje, tez danışmanlığı, editörlük, ödül ve ders kalemleri '
    .'bölünmez. '
    .'LİSANSÜSTÜ TEZİNİZDEN ÜRETTİĞİNİZ YAYINLARI "tez yayını" olarak kaydedin: yönergenin '
    .'3. bölümü tam olarak bunun için ve kendi tavanına tabi. Aynı çalışmayı makale olarak '
    .'kaydederseniz 1. bölümden sayılır. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: Eğitim Fakültesinin okullarla iş '
    .'birliği bölümü (öğretmenlik, psikolojik danışmanlık, aday öğretmen denetimi) kaynak '
    .'sözlüğünde karşılıksız — Eğitim Fakültesi adaylarını en çok bu etkiler. h-indeksi ve '
    .'yurt dışı araştırma puanı, bitirme projesi danışmanlığı, patent başvurusu ve dergi '
    .'hakemliği de girilemedi. Ödül bölümü yalnızca altı adı geçen ulusal ödülü sayıyor; '
    .'uluslararası ödülleriniz, yarışma dereceleriniz ve burslarınız tabloda yer almıyor. '
    .'Puanınız yalnızca atıflarda OLDUĞUNDAN YÜKSEK çıkabilir: kendi yayınlarınıza yaptığınız '
    .'atıflar sayılmamalı ve aynı yayındaki birden çok atıf tek atıf sayılmalı, kaydınız '
    .'ikisini de ayırt etmiyor.';

/** Hukuk dışındaki fakülteler: 1 → p · 2 → 0,8p · 3-5 → 1,8p/n · 6+ → p/n. */
$yazarGenel = [
    'haric' => ['atif', 'proje', 'tez_danismanligi', 'editorluk', 'odul', 'egitim_ogretim',
        'idari_gorev', 'toplumsal_katki', 'sanatsal_etkinlik'],
    'kademeler' => [1 => 1.0, 2 => 0.8, 3 => 0.6, 4 => 0.45, 5 => 0.36],
    'bol' => ['pay' => 1.0],
];

/** Hukuk Fakültesi: çok yazarlı yayınlarda puan eşit bölünür. */
$yazarHukuk = [
    'haric' => $yazarGenel['haric'],
    'bol' => ['pay' => 1.0],
];

/**
 * @return array<string, array<string, mixed>>
 */
$maddeler = function (bool $hukuk): array {
    $ulusIndeks = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI', 'ESCI / Scopus', 'Diğer Uluslararası İndeks'];
    $tamMetin = ['ozgun_makale', 'derleme'];
    $kisa = ['vaka_teknik_not', 'kisa_makale'];

    return [
        // ══ 1. ULUSLARARASI MAKALE ══
        // 1.a çeyrekliğe bölünüyor; alt kodlar (1-4) bize ait.
        '1.a.1' => ['baslik' => 'Q1 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $tamMetin, 'puan' => 30],
        '1.a.2' => ['baslik' => 'Q2 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $tamMetin, 'puan' => 20],
        '1.a.3' => ['baslik' => 'Q3 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $tamMetin, 'puan' => 15],
        '1.a.4' => ['baslik' => 'Q4 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $tamMetin, 'puan' => 10],
        '1.b' => ['baslik' => 'AHCI kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => $tamMetin, 'puan' => 20],
        '1.c' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $tamMetin, 'puan' => 10],
        '1.d' => ['baslik' => 'Diğer uluslararası indeksli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $tamMetin, 'puan' => 5],
        '1.e' => ['baslik' => 'Uluslararası dergide editöre mektup, araştırma notu, özet ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => $ulusIndeks, 'turler' => $kisa, 'puan' => 3],

        // ══ 2. ULUSAL MAKALE ══
        '2.a' => ['baslik' => 'TR Dizin kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $tamMetin, 'puan' => 10],
        '2.b' => ['baslik' => 'Diğer hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $tamMetin, 'puan' => 4],
        '2.c' => ['baslik' => 'Ulusal dergide editöre mektup, araştırma notu, özet ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => $kisa, 'puan' => 2],

        // ══ 3. LİSANSÜSTÜ TEZLERDEN ÜRETİLMİŞ YAYIN ══
        '3.a' => ['baslik' => 'Tezinizden üretilmiş, SCI, SCIE, SSCI veya AHCI dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 20],
        '3.b' => ['baslik' => 'Tezinizden üretilmiş, ESCI veya Scopus dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 10],
        '3.d' => ['baslik' => 'Tezinizden üretilmiş, TR Dizin dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['TR Dizin'], 'puan' => 8],
        '3.e' => ['baslik' => 'Tezinizden üretilmiş, BKCI kapsamındaki kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
        '3.f' => ['baslik' => 'Tezinizden üretilmiş, BKCI kapsamındaki kitapta bölüm', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 10],
        '3.g' => ['baslik' => 'Tezinizden üretilmiş, diğer kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 5],
        '3.h' => ['baslik' => 'Tezinizden üretilmiş, diğer kitapta bölüm', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 3],
        // Kaynak bu iki şıkkı "I)" ve "i)" diye basmış; kodlar okunurluk için
        // 3.i ve 3.j yapıldı.
        '3.i' => ['baslik' => 'Tezinizden üretilmiş, CPCI\'da yayımlanan bildiri', 'kategori' => 'tez_yayini', 'kaynaklar' => ['CPCI Bildiri'], 'puan' => 3],
        '3.j' => ['baslik' => 'Tezinizden üretilmiş, diğer bilimsel toplantı çalışması', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Diğer'], 'puan' => 2],

        // ══ 4. KİTAP ══
        // 4.c ve 4.d Hukuk Fakültesinde 20 ve 10, ötekilerde 5 ve 3.
        '4.a' => ['baslik' => 'BKCI kapsamındaki kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
        '4.b' => ['baslik' => 'BKCI kapsamındaki kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 10],
        '4.c' => ['baslik' => 'Diğer uluslararası ya da ulusal kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => $hukuk ? 20 : 5],
        '4.d' => ['baslik' => 'Diğer uluslararası ya da ulusal kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => $hukuk ? 10 : 3],

        // ══ 5. ATIF ══
        '5.a' => ['baslik' => 'Web of Science ya da Scopus kapsamında yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
        '5.b' => ['baslik' => 'BKCI kapsamındaki kitapta yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
        '5.c' => ['baslik' => 'TR Dizin kapsamındaki dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
        '5.d' => ['baslik' => 'Diğer kitap ya da dergide yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],

        // ══ 6. TEZ DANIŞMANLIĞI ══
        '6.a' => ['baslik' => 'Tamamlanmış doktora tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 5],
        '6.b' => ['baslik' => 'Tamamlanmış yüksek lisans tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 3],

        // ══ 7. BİLİMSEL ARAŞTIRMA PROJESİ ══
        // 7.a tek satırda üç puan taşıyor ("15/10/5"); alt kodlar bize ait.
        '7.a.1' => ['baslik' => 'AB Çerçeve ya da TÜBİTAK projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 15],
        '7.a.2' => ['baslik' => 'AB Çerçeve ya da TÜBİTAK projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 10],
        '7.a.3' => ['baslik' => 'AB Çerçeve ya da TÜBİTAK projesinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['danisman'], 'puan' => 5],
        '7.b' => ['baslik' => 'Uluslararası destekli bilimsel araştırma projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'puan' => 10],
        '7.c' => ['baslik' => 'Kamu kurumu ya da özel kuruluşla yapılan Ar-Ge projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'puan' => 5],
        '7.d' => ['baslik' => 'MEF BAP projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 3],

        // ══ 8. BİLİMSEL TOPLANTI ══
        '8.a' => ['baslik' => 'CPCI\'da yayımlanmış uluslararası bilimsel toplantı çalışması', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 5],
        '8.b' => ['baslik' => 'Diğer bilimsel toplantıda yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Ulusal Tam Metin', 'Uluslararası Özet/Poster', 'Ulusal Özet/Poster', 'Davetli Konuşmacı'], 'puan' => 3],

        // ══ 9. EĞİTİM-ÖĞRETİM ══
        '9.a' => ['baslik' => 'Lisans ya da lisansüstü ders vermiş olmak', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 2],

        // ══ 10. PATENT / FAYDALI MODEL ══
        '10.a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
        '10.b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 10],
        '10.c' => ['baslik' => 'Tescil edilmiş faydalı model ya da tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili', 'Ticarileştirme'], 'puan' => 5],

        // ══ 11. ÖDÜL ══
        // Tablo yalnızca bu altı ödülü sayıyor; uluslararası ödüller, yarışma
        // dereceleri ve burslar tabloda yok.
        '11.b' => ['baslik' => 'YÖK Doktora Tezi ya da Üstün Başarı Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü'], 'puan' => 25],
        '11.c' => ['baslik' => 'TÜBİTAK Bilim ya da Teşvik Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü'], 'puan' => 25],
        '11.e' => ['baslik' => 'TÜBA GEBİP ya da TESEP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 25],

        // ══ 12. EDİTÖRLÜK ══
        '12.a' => ['baslik' => 'Uluslararası indeksli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 2],
        '12.b' => ['baslik' => 'BKCI veya Scopus kapsamındaki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Kitap Editörlüğü'], 'puan' => 1],
        '12.c' => ['baslik' => 'TR Dizin kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi', 'Hakemlik', 'Yayın Kurulu Üyeliği'], 'puan' => 1],

        // ══ 13. YARIŞMA, PROJE VE YAZILIM (yalnızca Mimarlık Fakültesi) ══
        '13.a' => ['baslik' => 'Mimarlık, planlama ya da tasarım yarışmasında ödül veya mansiyon', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 15],
        '13.c' => ['baslik' => 'Kamu yararı gözeten proje yürütmüş ve uygulanmasına katkı vermiş olmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman'], 'puan' => 15],
    ];
};

$gruplar = [
    // Bölüm kümeleri (tavanlar ve koşullar için). Nokta zorunlu.
    '1' => ['1.*'],
    '1.a' => ['1.a.*'],
    '1.a-Q123' => ['1.a.1', '1.a.2', '1.a.3'],
    '1.ab' => ['1.a.*', '1.b'],
    '1.abc' => ['1.a.*', '1.b', '1.c'],
    '1.abcd' => ['1.a.*', '1.b', '1.c', '1.d'],
    '2' => ['2.*'],
    '2.ab' => ['2.a', '2.b'],
    '3' => ['3.*'],
    '3.a-h' => ['3.a', '3.b', '3.d', '3.e', '3.f', '3.g', '3.h'],
    '3.gh' => ['3.g', '3.h'],
    '4' => ['4.*'],
    '4.ac' => ['4.a', '4.c'],
    '4.cd' => ['4.c', '4.d'],
    '5' => ['5.*'],
    '6' => ['6.*'],
    '7' => ['7.*'],
    '8' => ['8.*'],
    '9' => ['9.*'],
    '10.ab' => ['10.a', '10.b'],
    '11' => ['11.*'],
    '12' => ['12.*'],
    '13' => ['13.*'],
    '13.a' => ['13.a'],
    '13.c' => ['13.c'],

    // Fakültelerin "başlıca eser" tanımları.
    'BASLICA-MUH' => ['1.a.*', '1.b', '3.a'],
    'BASLICA-MIM' => ['1.a.*', '1.b', '1.c', '1.d', '2.a', '3.a', '3.b', '3.e', '3.f',
        '3.g', '3.h', '4.*', '10.a', '10.b'],
    'BASLICA-MIM-CEKIRDEK' => ['1.a.*', '1.b', '1.c', '1.d', '2.a', '3.a', '3.b', '3.e',
        '3.f', '3.g', '3.h'],
];

/**
 * Fakülte × kadro tavan matrisi. Tabloda her bölümün altında fakülte fakülte
 * yazılı; burada bir yere toplandı. Boş bırakılan bölümde tavan yok.
 *
 * 13 ve 14. bölümler yalnızca kendi fakültelerine açık ("Diğer Fakülteler: Bu
 * bölümden puan alamaz"), ötekilerde tavan sıfır.
 *
 * @var array<string, array<string, array<string, int>>>
 */
$tavanlar = [
    'muhendislik' => [
        'dr' => ['13' => 0],
        'docent' => ['3' => 20, '4' => 20, '4.cd' => 5, '5' => 10, '6' => 10, '7' => 30, '8' => 10, '9' => 6, '11' => 25, '12' => 4, '13' => 0],
        'profesor' => ['3' => 30, '4' => 40, '4.cd' => 10, '5' => 20, '6' => 20, '7' => 50, '8' => 20, '9' => 12, '11' => 50, '12' => 8, '13' => 0],
    ],
    'mimarlik' => [
        'dr' => ['2.b' => 8, '2.c' => 2, '4.cd' => 15, '5' => 10],
        'docent' => ['2.b' => 8, '2.c' => 2, '4.cd' => 15, '5' => 10, '6' => 10, '8' => 10, '9' => 6, '11' => 25, '12' => 4, '13.a' => 15, '13.c' => 15],
        'profesor' => ['2.b' => 8, '2.c' => 2, '4.cd' => 30, '5' => 20, '6' => 20, '7' => 60, '8' => 20, '9' => 12, '11' => 50, '12' => 8, '13.a' => 30, '13.c' => 30],
    ],
    'hukuk' => [
        'dr' => ['5' => 5, '13' => 0],
        'docent' => ['3' => 20, '3.gh' => 10, '5' => 10, '6' => 10, '8' => 10, '9' => 6, '11' => 25, '12' => 4, '13' => 0],
        'profesor' => ['3' => 40, '5' => 20, '6' => 20, '8' => 20, '9' => 12, '11' => 50, '12' => 8, '13' => 0],
    ],
    'sosyal' => [
        'dr' => ['13' => 0],
        'docent' => ['3' => 20, '3.gh' => 5, '4' => 20, '4.cd' => 5, '5' => 10, '6' => 10, '7' => 20, '8' => 10, '9' => 6, '11' => 25, '12' => 4, '13' => 0],
        'profesor' => ['3' => 40, '3.gh' => 10, '4' => 40, '4.cd' => 10, '5' => 20, '6' => 20, '7' => 40, '8' => 20, '9' => 12, '11' => 50, '12' => 8, '13' => 0],
    ],
    'egitim' => [
        'dr' => ['13' => 0],
        'docent' => ['3' => 20, '3.gh' => 5, '4' => 20, '4.cd' => 5, '5' => 10, '6' => 10, '7' => 15, '8' => 10, '9' => 6, '11' => 25, '12' => 4, '13' => 0],
        'profesor' => ['3' => 40, '3.gh' => 10, '4' => 40, '4.cd' => 10, '5' => 20, '6' => 20, '7' => 30, '8' => 20, '9' => 12, '11' => 50, '12' => 8, '13' => 0],
    ],
];

$cetveller = [];

foreach ($tavanlar as $fakulte => $kadrolar) {
    foreach ($kadrolar as $kadro => $tavan) {
        $cetveller["mef-2024-{$fakulte}-{$kadro}"] = [
            'kapsam_notu' => $kapsamNotu,
            'yazar_katsayisi' => $fakulte === 'hukuk' ? $yazarHukuk : $yazarGenel,
            'maddeler' => $maddeler($fakulte === 'hukuk'),
            'gruplar' => $gruplar,
            'grup_tavanlari' => $tavan,
        ];
    }
}

return ['cetveller' => $cetveller];
