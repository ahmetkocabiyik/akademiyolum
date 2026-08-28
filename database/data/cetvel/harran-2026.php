<?php

/**
 * HARRAN ÜNİVERSİTESİ — Ek-1 Akademik Faaliyet Puanlama Tablosu
 * Kaynak: pdf/1782307205408.harran-kriter-18052026.pdf (18.05.2026'dan
 * itibaren yürürlükte)
 *
 * Madde kodları Ek-1'in bölüm ve bent numaralarından türetildi (A1a.q1 =
 * A bölümünün 1. maddesinin a bendindeki Q1 satırı; B ve C bölümleri
 * eğitim-öğretim ve idari faaliyetler).
 *
 * ── BÖLÜM KATSAYILARI SATIR PUANLARINA GÖMÜLDÜ ──
 * Yönergenin "TOPLAM PUAN HESAPLAMA" tablosu bölüm toplamlarını çarpıyor:
 * A (Akademik) × 0,7; B (Eğitim-Öğretim) × 0,3; C (İdari) × 0,3. Motorda
 * bölüm katsayısı alanı olmadığı için çarpan her satıra gömüldü ve çarpımdan
 * SONRA bir kez aşağı yuvarlandı (KONVANSIYONLAR §"Koşula bağlı çarpanı
 * cetvele göm"). Bunun iki sonucu var:
 *   1) Cetveldeki puanlar yönergenin ham tablosundan düşük görünür; eşikler
 *      de zaten çarpılmış toplam üzerinden yazıldığı için karşılaştırma
 *      tutarlı.
 *   2) Ham puanı 1 olan satırlar (ders kredisi, jüri üyelikleri, kurul
 *      üyelikleri, seminer) çarpımdan sonra sıfıra düştüğü için hiç
 *      yazılmadı. EĞİTİM-ÖĞRETİM bölümünden yalnızca doktora tez
 *      danışmanlığı puan üretiyor; ders, jüri ve kurul faaliyetleriniz
 *      toplama katkı vermiyor.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   A1'in "Q1 ilk %10" (90) ile "Q1" (60) satırları tek 'SCIE/SSCI (Q1)'
 *       etiketine düşüyor → 60 (çarpımla 42).
 *   ESCI (10) ile Scopus Q1-Q4 (50-10) tek 'ESCI / Scopus' etiketine
 *       düşüyor → 10 (çarpımla 7). Çeyreği kayıtta olmayan AHCI dergileri
 *       için a bendinin en düşük kademesi (Q4, 20 → 14) kullanıldı.
 *   Kitaplarda BKCI (70) ile Scopus kitap (50) → 50; uluslararası (20) ile
 *       ulusal kitap (10) → 10; uluslararası (10) ile ulusal bölüm (5) → 5.
 *   Ödüllerde yurtiçi kamu (10), kongre kurulu (10/5) ve özel kuruluş (5)
 *       ödülleri tek etikete düşüyor → 5; yarışma ödülleri → 2.
 *   Müzeyle ilgili restorasyon satırlarında çalışmayı üstlenmek (20/10),
 *       ekipte yer almak (10/5) ve düzenleme kurulunda görev almak (5/3)
 *       ayrılamıyor → uluslararası 5, ulusal 3.
 *   Albüm ve ses kaydı satırları (A30/c 20, A33/l 15, A34/h 20) tek etikete
 *       düşüyor → 15; şeflik satırları (A33/a 50, A33/g 20) → 20.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   Çarpımdan sonra sıfıra düşen satırlar: B bölümünün ders, çalıştay,
 *       yüksek lisans tez danışmanlığı, jüri üyelikleri, kurul üyelikleri,
 *       değişim programı ve sertifika satırları; A10'un hakemlik, yayın
 *       kurulu ve ulusal dergi editörlüğü satırları; A7'nin toplantı
 *       düzenleme ve seminer satırları; A8'in "diğer atıflar" satırı;
 *       C bölümünün soruşturma komisyonu satırı.
 *   Adayın LİSANSÜSTÜ TEZİNDEN ÜRETİLMİŞ makale satırları (A1/ı-k) —
 *       faaliyet kaydı yayının tez kökenli olup olmadığını taşımıyor;
 *       tezden üretilmiş yayınlarınız normal makale satırlarından
 *       puanlanıyor ve toplamınız olduğundan YÜKSEK çıkabilir.
 *   Harran Üniversitesi dergilerine özgü satırlar (A1/g, A2/ç, A10/ı, j, l,
 *       m) ile hakemsiz dergi satırları (A1/n, o; A2/e, f).
 *   A3 (çağrılı derleme, teknik not, editöre mektup) — A1/e ve A1/l ile
 *       aynı yayın türlerine düşüyor, mükerrer sayımı önlemek için
 *       yazılmadı.
 *   A4'ün patent ve faydalı model BAŞVURUSU satırları, marka tescili,
 *       TTO buluş bildirimi ve danışmanlık satırları.
 *   A5'in arkeolojik kazı ve yüzey araştırması satırları (g-k).
 *   A11 SPORTİF BAŞARI VE TEMSİL bölümünün tamamı (madalya, antrenörlük,
 *       millî sporcu, federasyon kurulu).
 *   A8/d h-indeksi satırı; A14 (laboratuvar ve tasarım çalışmaları),
 *       A15'in yarışma ödülü ve uygulanmış proje satırları, A22-A25
 *       (televizyon programları, reklam filmleri, festival çalışmaları,
 *       belge çözümlenmesi), A31, A32, A36, A38, A39 ve A40 (Türk müziği
 *       kompozisyon-yorumculuk, müzikoloji, klasik bale, çağdaş dans, halk
 *       dansları) — sözlükte ayrışan karşılığı yok.
 *   A17'nin "sergi içeriğinde en az 15 adet özgün eser barındıran kişisel
 *       sergi" satırları (a, b) — puan tek esere değil serginin tamamına
 *       veriliyor.
 *   B4 dil puanı (85 üzeri yabancı dil sınavı, 25 puan) — faaliyet değil,
 *       aday profilindeki sınav puanı.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   A4'ün "patent puanı tüm araştırmacılar arasında EŞİT paylaşılır",
 *       A15'in "ödül puanları araştırıcı sayısına eşit bölünür" ve A16 ile
 *       A18'in "puanlar ekip arasında eşit paylaşılır" kuralları: bu
 *       satırlara da Ek-1/A'nın yazar sırası tablosu uygulanıyor, yani
 *       çok kişili patent ve ödüllerde puanınız olduğundan YÜKSEK çıkar.
 *   A17'nin "jürili ya da küratörlü sergilerde puan iki katı" kuralı ile
 *       "bir önceki çalışmaların en fazla %25'i bir sonraki etkinlikte yer
 *       alabilir" sınırı.
 *   A6'nın "editörlük yapılan kitapta en fazla bir bölüm yazarlığı" ve
 *       "aynı kitapta ikiden fazla bölümden en fazla biri" sınırları.
 *   A1/g, A2/ç ve A5/f gibi "en fazla n adet" sınırları.
 *
 * Yönerge: yonerge/harran.php
 */
$TAM = ['ozgun_makale'];
$DERLEME = ['derleme'];
$KISA = ['kisa_makale'];
$VAKA = ['vaka_teknik_not'];
$WOS = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];
$WOS_SCOPUS = [...$WOS, 'ESCI / Scopus'];

$maddeler = [
    // ══ A1. ARAŞTIRMA MAKALESİ (ham puan × 0,7) ══
    'A1a.q1' => ['baslik' => 'WoS SCI-E, SSCI veya AHCI kapsamındaki Q1 dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $TAM, 'puan' => 42],
    'A1a.q2' => ['baslik' => 'WoS SCI-E, SSCI veya AHCI kapsamındaki Q2 dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $TAM, 'puan' => 31],
    'A1a.q3' => ['baslik' => 'WoS SCI-E, SSCI veya AHCI kapsamındaki Q3 dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $TAM, 'puan' => 21],
    'A1a.q4' => ['baslik' => 'WoS SCI-E, SSCI veya AHCI kapsamındaki Q4 dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $TAM, 'puan' => 14],
    'A1a.ahci' => ['baslik' => 'AHCI kapsamındaki dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => $TAM, 'puan' => 14],
    'A1b' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $TAM, 'puan' => 7],
    'A1c' => ['baslik' => 'TR Dizin kapsamındaki dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TAM, 'puan' => 7],
    'A1d' => ['baslik' => 'Diğer uluslararası indekslerde taranan dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $TAM, 'puan' => 3],
    'A1f' => ['baslik' => 'TR Dizin kapsamı dışındaki diğer ulusal hakemli dergide araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => 3],
    'A1e' => ['baslik' => 'İndeksli ya da TR Dizin dergilerde yayımlanmış editöre mektup, araştırma notu, özet veya kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => [...$WOS_SCOPUS, 'TR Dizin'], 'turler' => $KISA, 'puan' => 2],
    'A1h' => ['baslik' => 'Diğer ulusal hakemli dergilerde yayımlanmış editöre mektup, araştırma notu, özet veya kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli', 'Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 1],
    'A1l' => ['baslik' => 'WoS SCI-E, SSCI veya AHCI kapsamındaki dergide vaka takdimi (olgu sunumu)', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $VAKA, 'puan' => 5],
    'A1m' => ['baslik' => 'Diğer dergilerde vaka takdimi (olgu sunumu)', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'TR Dizin', 'Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'], 'turler' => $VAKA, 'puan' => 2],

    // ══ A2. DERLEME MAKALESİ ══
    'A2a' => ['baslik' => 'SCI-E, SSCI, AHCI, ESCI veya Scopus kapsamındaki dergide derleme makalesi', 'kategori' => 'makale', 'kaynaklar' => $WOS_SCOPUS, 'turler' => $DERLEME, 'puan' => 14],
    'A2b' => ['baslik' => 'Diğer uluslararası hakemli dergilerde derleme makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $DERLEME, 'puan' => 4],
    'A2c' => ['baslik' => 'TR Dizin kapsamındaki dergilerde derleme makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $DERLEME, 'puan' => 4],
    'A2d' => ['baslik' => 'Ulusal hakemli dergilerde derleme makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $DERLEME, 'puan' => 2],

    // ══ A4. GİRİŞİMCİLİK VE YENİLİKÇİLİK ══
    'A4a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 28],
    'A4b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 14],
    'A4c' => ['baslik' => 'Tescil edilmiş faydalı model ya da endüstriyel tasarım', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım'], 'puan' => 11],
    'A4i' => ['baslik' => 'Teknoloji geliştirme bölgelerinde firma sahibi ya da ortağı olmak', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 5],
    'A4k' => ['baslik' => 'Üniversite-toplum ve üniversite-sanayi iş birliği çerçevesinde sosyal sorumluluk çalışma ve projelerinde görev almak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın', 'Kamu/STK Danışmanlığı'], 'puan' => 4],

    // ══ A5. ARAŞTIRMA PROJESİ ══
    'A5a.y' => ['baslik' => 'AB Çerçeve Programı ya da Ufuk Avrupa araştırma projesinde koordinatörlük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 84],
    'A5a.a' => ['baslik' => 'AB Çerçeve Programı ya da Ufuk Avrupa araştırma projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 42],
    'A5a.d' => ['baslik' => 'AB Çerçeve Programı ya da Ufuk Avrupa araştırma projesinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['danisman'], 'puan' => 21],
    'A5b.y' => ['baslik' => 'TÜBİTAK bilimsel araştırma projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 42],
    'A5b.a' => ['baslik' => 'TÜBİTAK bilimsel araştırma projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 21],
    'A5b.d' => ['baslik' => 'TÜBİTAK bilimsel araştırma projesinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['danisman'], 'puan' => 10],
    'A5c' => ['baslik' => 'Uluslararası destekli bilimsel araştırma projesi', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'puan' => 7],
    'A5d' => ['baslik' => 'Üniversiteler dışındaki kamu kurumu ya da özel kuruluşla yapılan Ar-Ge, Ür-Ge projesi', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'puan' => 7],
    'A5e' => ['baslik' => 'Üniversite BAP projesi', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'puan' => 4],

    // ══ A6. KİTAPLAR ══
    'A6a' => ['baslik' => 'BKCI ya da Scopus kitap endekslerinde dizinlenen kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 35],
    'A6a.b' => ['baslik' => 'BKCI ya da Scopus kitap endekslerinde dizinlenen kitap bölümü', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 35],
    'A6e' => ['baslik' => 'Uluslararası ya da ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı'], 'puan' => 7],
    'A6f' => ['baslik' => 'Uluslararası ya da ulusal yayınevi tarafından yayımlanmış kitap bölümü', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 3],
    'A6g' => ['baslik' => 'Tahkik (tenkitli metin neşri) türünde uluslararası ya da ulusal kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Tahkik (Tenkitli Metin)'], 'puan' => 7],
    'A6h' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 7],
    'A6i' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitap editörlüğü (çeviri editörü dahil)', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 3],
    'A6j' => ['baslik' => 'Tam kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap', 'Çeviri Kitap Bölümü'], 'puan' => 5],

    // ══ A7. BİLİMSEL TOPLANTI FAALİYETLERİ ══
    'A7a' => ['baslik' => 'CPCI konferans endekslerinde dizinlenen bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 10],
    'A7c' => ['baslik' => 'Uluslararası bilimsel toplantıda tam metni ya da özeti bildiri kitapçığında yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin'], 'puan' => 3],
    'A7d' => ['baslik' => 'Uluslararası bilimsel toplantıda poster bildiri ya da özet', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 2],
    'A7e' => ['baslik' => 'Ulusal bilimsel toplantıda tam metni ya da özeti bildiri kitapçığında yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 2],
    'A7f' => ['baslik' => 'Ulusal bilimsel toplantıda poster bildiri ya da özet', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 1],
    'A7g' => ['baslik' => 'Kongre, konferans ve sempozyumlarda davetli konuşmacı', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 2],

    // ══ A8. ATIFLAR ══
    'A8a' => ['baslik' => 'SCI-E, SSCI, AHCI, ESCI veya Scopus taranan dergilerdeki eserlere yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 2],
    'A8b' => ['baslik' => 'BKCI kapsamındaki kitapta yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 1],
    'A8c' => ['baslik' => 'TR Dizin kapsamındaki dergilerde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 1],

    // ══ A9. ÖDÜLLER ══
    'A9a' => ['baslik' => 'YÖK yılın doktora ya da üstün başarı ödülü, TÜBİTAK bilim ya da teşvik ödülü, TÜBA GEBİP ya da TESEP ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 17],
    'A9f' => ['baslik' => 'Alanında yurt dışı kurum veya kuruluşlardan alınan bilim, sanat ya da tasarım ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 10],
    'A9g' => ['baslik' => 'Alanında yurt içi kamu, özel kurum ya da etkinlik kurullarından alınan bilim, sanat veya tasarım ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 3],
    'A9j' => ['baslik' => 'Ulusal ya da uluslararası hakemli yarışmalarda alınan ödül', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 1],

    // ══ A10. EDİTÖRLÜK VE HAKEMLİK ══
    'A10a' => ['baslik' => 'SCI-E, SSCI, AHCI, ESCI veya Scopus kapsamındaki dergide editörlük (her sayı için)', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 2],
    'A10b' => ['baslik' => 'TR Dizin kapsamındaki dergide editörlük (her sayı için)', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 1],

    // ══ A12. SANATSAL UYGULAMA VE ETKİNLİK ══
    'A12a' => ['baslik' => 'Dinî musiki formlarında özgün beste sunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım'], 'puan' => 3],
    'A12c' => ['baslik' => 'Dijital platformlarda yayımlanmış en az 30 dakikalık ses ya da video kaydı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 3],

    // ══ A13. ŞEHİRCİLİK VE MİMARİ UYGULAMA PROJESİ ══
    'A13b.y' => ['baslik' => 'Şehircilik ve mimari proje, rölöve, restitüsyon, restorasyon, imar planı çalışmalarında proje yürütücülüğü', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif'], 'puan' => 14],
    'A13b.e' => ['baslik' => 'Şehircilik ve mimari proje çalışmalarında proje ekibinde yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Ekip'], 'puan' => 7],
    'A13b.ey' => ['baslik' => 'Şehircilik ve mimari proje çalışmalarında proje ekibi yardımcılığı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Ekip Yardımcısı'], 'puan' => 3],
    'A13b.d' => ['baslik' => 'Şehircilik ve mimari proje çalışmalarında danışmanlık', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Danışman'], 'puan' => 4],

    // ══ A15. MİMARLIK PROJE YARIŞMALARI VE ÖDÜLLER ══
    'A15c' => ['baslik' => 'Proje ve yapım yönetimi, tasarım ya da planlama alanlarında yazılım üreticisi olmak', 'kategori' => 'patent', 'kaynaklar' => ['Yazılım'], 'puan' => 10],

    // ══ A16. MÜZE, KAZI BULUNTUSU VE KOLEKSİYON RESTORASYONU ══
    'A16a' => ['baslik' => 'Yurt dışında müze, koleksiyon, film arşivi ve sinematografik malzemelerin restorasyon ve konservasyon çalışmalarında görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koruma-Onarım Uygulaması (Uluslararası)'], 'puan' => 3],
    'A16c' => ['baslik' => 'Ulusal müze, koleksiyon, film arşivi ve sinematografik malzemelerin restorasyon ve konservasyon çalışmalarında görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koruma-Onarım Uygulaması (Ulusal)'], 'puan' => 2],

    // ══ A17. SERGİLER ══
    'A17c' => ['baslik' => 'Uluslararası sergi, çalıştay, bienal, defile, gösteri, performans ya da festival türündeki karma etkinlikte eseriyle yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Karma Sergi (Uluslararası)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)'], 'puan' => 4],
    'A17d' => ['baslik' => 'Ulusal sergi, çalıştay, bienal, defile, gösteri, performans ya da festival türündeki karma etkinlikte eseriyle yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 2],
    'A17e' => ['baslik' => 'Eserinizin kamusal alanda sürekli sergilenmesi ya da bir koleksiyona girmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Haber Olması (Uluslararası)', 'Eserin Haber Olması (Ulusal)'], 'puan' => 3],
    'A17f' => ['baslik' => 'Devlet resim ve heykel sergisi ile yurt içi kamu ve özel kuruluşlarca düzenlenen sergilerde yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Kişisel Sergi (Uluslararası)'], 'puan' => 3],
    'A17g' => ['baslik' => 'Uluslararası kişisel etkinlik ve gösterilerde yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)'], 'puan' => 7],

    // ══ A19-A21. FİLM, DİZİ VE TELEVİZYON ══
    'A19' => ['baslik' => 'Uzun ya da orta metrajlı filmde yönetmenlik, görüntü yönetmenliği veya senaryo yazarlığı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Yönetmenlik (Sahne/Ekran)'], 'puan' => 7],
    'A20' => ['baslik' => 'Kısa metrajlı film ya da belgeselde yönetmenlik veya görüntü yönetmenliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)'], 'puan' => 3],
    'A21' => ['baslik' => 'Televizyon filmi ya da dizide yönetmenlik, görüntü yönetmenliği veya senaryo yazarlığı; sahne, radyo, televizyon ve sinema dallarında özgün oyun metni yazmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'], 'puan' => 10],

    // ══ A27. TİYATRO ÇALIŞMALARI ══
    'A27b' => ['baslik' => 'Ödenekli ya da ulusal tiyatroda rol almak; dansçı veya performans icracısı olarak sahnelenen eserde yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Dansçı / Performans İcracısı (Uluslararası)', 'Dansçı / Performans İcracısı (Ulusal)', 'Bale Başrol (Uluslararası)', 'Bale Başrol (Ulusal)'], 'puan' => 7],
    'A27c' => ['baslik' => 'Ödenekli ya da ulusal tiyatroda oyun sahnelemek; opera eseri sahnelemek (reji)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisörlük (Uluslararası)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Opera Şefliği (Uluslararası)', 'Opera Şefliği (Ulusal)'], 'puan' => 17],
    'A27d' => ['baslik' => 'Atölye ya da ustalık sınıfı çalışması yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Masterclass (Uluslararası)', 'Masterclass (Ulusal)', 'Müzikoloji Atölyesi', 'Eğitici Konser Programı (Uluslararası)', 'Eğitici Konser Programı (Ulusal)'], 'puan' => 3],
    'A27e' => ['baslik' => 'Rejisör yardımcılığı yapmış olmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisör Yardımcılığı (Uluslararası)', 'Rejisör Yardımcılığı (Ulusal)', 'Rejisör Yardımcılığı (Konservatuvar)'], 'puan' => 3],

    // ══ A29. SAHNE TASARIMI ══
    'A29' => ['baslik' => 'Sahnelenmiş oyun, sinema ya da dizi platolarında özgün sahne, dekor, kostüm ve ışık tasarımı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne Tasarımı (Dekor, Kostüm, Işık)', 'Koreografi', 'Bale/Dans Koreograflığı (Uluslararası)', 'Bale/Dans Koreograflığı (Ulusal)', 'Tüm Perde Koreograflığı (Uluslararası)', 'Tüm Perde Koreograflığı (Ulusal)', 'Bölüm Koreograflığı (Uluslararası)', 'Bölüm Koreograflığı (Ulusal)'], 'puan' => 5],

    // ══ A33. YURT İÇİ MÜZİKSEL ETKİNLİKLER ══
    'A33g' => ['baslik' => 'Yurt içinde bireysel dinleti vermek ya da orkestra, koro ve grup şefliği yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra Şefliği (Ulusal)', 'Koro Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Ulusal)', 'Grup Şefliği (Ulusal)', 'Resital (Ulusal)'], 'puan' => 14],
    'A33c' => ['baslik' => 'Opera şarkıcılığı: opera eserinde solist icracı olarak bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera Birinci Rol (Ulusal)', 'Opera Birinci Rol (Uluslararası)', 'Şan Resitali (Ulusal)', 'Şan Resitali (Uluslararası)', 'Oratoryo/Kantat Solistliği (Ulusal)', 'Oratoryo/Kantat Solistliği (Uluslararası)'], 'puan' => 17],
    'A33i' => ['baslik' => 'Yurt içinde orkestra ya da koroda solist olarak yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Solistlik (Ulusal)'], 'puan' => 10],
    'A33j' => ['baslik' => 'Yurt içinde oda müziği dinletilerinde yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Ulusal)', 'Başkemancılık (Ulusal)'], 'puan' => 10],
    'A33k' => ['baslik' => 'Orkestra ya da koroda yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra / Koro Üyeliği', 'Corps de Ballet (Uluslararası)', 'Corps de Ballet (Ulusal)', 'Opera İkinci Rol (Uluslararası)', 'Opera İkinci Rol (Ulusal)', 'Bale Solist Rol (Uluslararası)', 'Bale Solist Rol (Ulusal)'], 'puan' => 4],
    'A33l' => ['baslik' => 'Audio yayınları ve albüm (bandrollü ya da dijital DVD, CD, kaset, plak kaydı)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)', 'Karma Albüm / CD-DVD Katkısı', 'Eğitim Müziği Albümü'], 'puan' => 10],

    // ══ A34. YURT DIŞI MÜZİKSEL ETKİNLİKLER ══
    'A34a' => ['baslik' => 'Yurt dışında bireysel dinleti vermek ya da orkestra, koro ve grup şefliği yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra Şefliği (Uluslararası)', 'Koro Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Uluslararası)', 'Grup Şefliği (Uluslararası)', 'Resital (Uluslararası)'], 'puan' => 21],
    'A34d' => ['baslik' => 'Yurt dışında orkestra ya da koroda solist olarak yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Solistlik (Uluslararası)'], 'puan' => 14],
    'A34e' => ['baslik' => 'Yurt dışında oda müziği dinletilerinde yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Uluslararası)', 'Başkemancılık (Uluslararası)'], 'puan' => 14],

    // ══ A35. MÜZİK TEKNOLOJİLERİ VE UYGULAMA ══
    'A35a' => ['baslik' => 'Görsel ya da işitsel yapımda müzik üretimi, ses tasarımı, kayıt, miks ve mastering süreçlerini yürütmek; özgün çalgı ya da yazılım tasarlamak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne/Ekran Müziği'], 'puan' => 7],

    // ══ A37. MÜZİK KOMPOZİSYONLARI ══
    'A37a' => ['baslik' => 'Sahne yapıtı bestelemek (opera, bale, oratoryo vb.)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera/Bale Kompozisyonu', 'Orkestralı Sahne Eseri'], 'puan' => 14],
    'A37b' => ['baslik' => 'Senfonik yapıt bestelemek (senfoni, konçerto vb.)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Küçük Ölçekli Orkestra Eseri'], 'puan' => 14],
    'A37c' => ['baslik' => 'Oda müziği, koro ya da solo yapıt bestelemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)'], 'puan' => 10],
    'A37d' => ['baslik' => 'Düzenleme, orkestrasyon ve transkripsiyon', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi'], 'puan' => 7],
    'A37e' => ['baslik' => 'Elektronik müzik yapıtı bestelemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)'], 'puan' => 7],

    // ══ B. EĞİTİM, ÖĞRETİM VE DİĞER FAALİYETLER (ham puan × 0,3) ══
    'B1c' => ['baslik' => 'Tamamlanmış ya da devam eden doktora, sanatta yeterlik veya uzmanlık tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 1],

    // ══ C. İDARİ FAALİYETLER (ham puan × 0,3) ══
    'C1' => ['baslik' => 'Rektör, rektör yardımcısı, dekan, enstitü müdürü, yüksekokul ya da meslek yüksekokulu müdürü, başhekim (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü'], 'puan' => 3],
    'C2' => ['baslik' => 'Bölüm başkanı, dekan yardımcısı, anabilim dalı başkanı, merkez müdürü, senato ve yönetim kurulu üyeliği (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı', 'Bölüm Başkan Yardımcısı', 'Dekan Yrd. / Müdür Yrd.', 'Anabilim Dalı Başkanı / Koordinatörlük', 'Uygulama ve Araştırma Merkezi Müdürü', 'Senato / Üniversite Yönetim Kurulu Üyesi'], 'puan' => 1],
    'C9' => ['baslik' => 'Üniversite birimlerinde komisyon ve kurul başkanlığı ile üyeliği (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 1],
];

$kodlar = fn (string ...$onekler): array => array_values(array_filter(
    array_keys($maddeler),
    fn (string $kod): bool => array_reduce($onekler, fn (bool $t, string $o): bool => $t || str_starts_with($kod, $o), false)
));

/** Ek-1'in A1 bendindeki WoS ve Scopus araştırma makalesi satırları. */
$WOS_SCOPUS_MAKALE = ['A1a.q1', 'A1a.q2', 'A1a.q3', 'A1a.q4', 'A1a.ahci', 'A1b'];
/** Ulusal ya da uluslararası hakemli dergilerde araştırma makalesi. */
$HAKEMLI_MAKALE = [...$WOS_SCOPUS_MAKALE, 'A1c', 'A1d', 'A1f'];
/** MADDE 8/E-1: WoS, Scopus, alan indeksleri veya TR Dizin. */
$INDEKS_TR = [...$WOS_SCOPUS_MAKALE, 'A1c', 'A1d'];
/** MADDE 8/E-2-a: makale, bilimsel kitap ya da kitap bölümü. */
$KURAMSAL_ESER = [...$HAKEMLI_MAKALE, ...$kodlar('A6')];

return [
    'kapsam_notu' => 'Puanlar Harran Üniversitesi Ek-1 Akademik Faaliyet Puanlama Tablosundan '
        .'(18.05.2026). Yönerge bölüm toplamlarını çarpıyor (Akademik ×0,7; Eğitim-Öğretim ×0,3; '
        .'İdari ×0,3); motorda bölüm katsayısı olmadığı için çarpan satır puanlarına gömüldü, '
        .'yani buradaki puanlar ham tablodan düşük ama eşiklerle aynı ölçekte. Ortak '
        .'çalışmalarda Ek-1/A tablosu uygulanıyor: tek yazarlıda tam puan; iki yazarlıda birinci '
        .'isim %85, ikinci %60; üç yazarlıda %80, %50, %40; dört ve daha fazla yazarlıda %75, '
        .'%40, %20, %15 ve beşinci isimden sonrası %10. Yazar listesini boş bırakırsanız çarpan '
        .'uygulanmaz ve puanınız olduğundan yüksek görünür. Atıflardan en fazla 21, ödüllerden '
        .'28, editörlük ve hakemlikten 14, kitapların editörlük-çeviri-tahkik satırlarından 28, '
        .'bildirilerin CPCI dışı satırlarından 17, projelerin AB-TÜBİTAK dışı satırlarından 7, '
        .'idari faaliyetlerden 28 puan sayılıyor (hepsi çarpılmış değerler). Puanınız şu '
        .'kalemlerde OLDUĞUNDAN DÜŞÜK görünür: ham puanı 1 olan satırlar çarpımdan sonra sıfıra '
        .'düştüğü için EĞİTİM-ÖĞRETİM bölümünden yalnızca doktora tez danışmanlığı sayılıyor; '
        .'ders, jüri ve kurul faaliyetleriniz toplama girmiyor. A11 sportif başarı bölümünün '
        .'tamamı, arkeolojik kazı satırları, televizyon programları, festival çalışmaları, '
        .'Türk müziği kompozisyon-yorumculuk, klasik bale, çağdaş dans ve halk dansları '
        .'bölümleri faaliyet kaydında karşılıksız. Serginin en az 15 özgün eser barındırmasını '
        .'isteyen kişisel sergi satırları puanı serginin tamamına verdiği için girilmedi. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünür: lisansüstü tezden üretilmiş '
        .'yayınlar için yönergenin öngördüğü düşük satırlar ayrılamıyor; patent, ödül ve ekip '
        .'çalışmalarında yönergenin istediği EŞİT paylaşım yerine yazar sırası tablosu '
        .'uygulanıyor.',

    // EK-1/A: Yazar/eser sahibi sıralamasına göre puanlama tablosu.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'editorluk', 'proje', 'tez_danismanligi', 'tez_yayini',
            'egitim_ogretim', 'idari_gorev', 'toplumsal_katki', 'diger'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.85, 3 => 0.80], 'sonrasi' => 0.75],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.85, 3 => 0.80], 'sonrasi' => 0.75],
            'yazar_2' => ['kademeler' => [2 => 0.60, 3 => 0.50], 'sonrasi' => 0.40],
            'yazar_3' => ['kademeler' => [3 => 0.40], 'sonrasi' => 0.20],
            'yazar_4' => ['sonrasi' => 0.15],
            'ortak' => ['sonrasi' => 0.10],
        ],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        'TOPLAM' => array_keys($maddeler),
        // MADDE 8'in alan bazlı makale koşulları.
        'WOS-SCOPUS-MAKALE' => $WOS_SCOPUS_MAKALE,
        'HAKEMLI-MAKALE' => $HAKEMLI_MAKALE,
        'INDEKS-TR' => $INDEKS_TR,
        'KURAMSAL-ESER' => $KURAMSAL_ESER,
        // MADDE 9, 10 ve 11'in bölüm bazlı koşulları.
        'A4' => $kodlar('A4'),
        'A5' => $kodlar('A5'),
        'A17-29' => ['A17c', 'A17d', 'A17e', 'A17f', 'A17g', 'A19', 'A20', 'A21',
            'A27b', 'A27c', 'A27d', 'A27e', 'A29'],
        'A33-35' => ['A33g', 'A33c', 'A33i', 'A33j', 'A33k', 'A33l', 'A34a', 'A34d', 'A34e', 'A35a'],
        'A37' => $kodlar('A37'),
        // Tavan grupları.
        'ATIF' => $kodlar('A8'),
        'ODUL' => $kodlar('A9'),
        'EDITORLUK' => $kodlar('A10'),
        'KITAP-DIGER' => ['A6g', 'A6h', 'A6i', 'A6j'],
        'BILDIRI-DIGER' => ['A7c', 'A7d', 'A7e', 'A7f', 'A7g'],
        'PROJE-DIGER' => ['A5c', 'A5d', 'A5e'],
        'SANAT-UYGULAMA' => ['A12a', 'A12c'],
        'MIMARI-PROJE' => $kodlar('A13'),
        'RESTORASYON' => $kodlar('A16'),
        'SERGI' => $kodlar('A17'),
        'FILM' => ['A19'],
        'KISA-FILM' => ['A20'],
        'DIZI' => ['A21'],
        'TIYATRO' => $kodlar('A27'),
        'SAHNE-TASARIMI' => ['A29'],
        'MUZIK-YURTICI' => $kodlar('A33'),
        'MUZIK-YURTDISI' => $kodlar('A34'),
        'MUZIK-TEKNOLOJI' => $kodlar('A35'),
        'IDARI' => $kodlar('C'),
    ],

    // Tavanlar yönergenin bölüm bazlı sınırlarının 0,7 (A) ve 0,3 (C) ile
    // çarpılmış hâli. A17-29, A33-35 ve A37 aralıkları eşik grubu; bunlara
    // TOPLU bir tavan konmadı, çünkü yönergenin sınırları her bölüm için
    // ayrı yazılmış.
    'grup_tavanlari' => [
        'ATIF' => 21,
        'ODUL' => 28,
        'EDITORLUK' => 14,
        'KITAP-DIGER' => 28,
        'BILDIRI-DIGER' => 17,
        'PROJE-DIGER' => 7,
        'SANAT-UYGULAMA' => 14,
        'MIMARI-PROJE' => 14,
        'RESTORASYON' => 21,
        'SERGI' => 21,
        'FILM' => 21,
        'KISA-FILM' => 21,
        'DIZI' => 21,
        'TIYATRO' => 14,
        'SAHNE-TASARIMI' => 14,
        'MUZIK-YURTICI' => 35,
        'MUZIK-YURTDISI' => 35,
        'MUZIK-TEKNOLOJI' => 35,
        'A37' => 42,
        'IDARI' => 28,
    ],
];
