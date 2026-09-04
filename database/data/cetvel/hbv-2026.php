<?php

/**
 * ANKARA HACI BAYRAM VELİ ÜNİVERSİTESİ — Tablo 1 Puan Tablosu
 * Kaynak: pdf/1772448652440.ankara-haci-bayram-veli-kriter-020232026.pdf
 * (33 sayfa; Akademik Yükseltilme ve Atanma Kriterleri Yönergesi.)
 *
 * Madde kodları Tablo 1'in kendi numaralandırması (1.a, 3.e, 10.c …);
 * çeyreklik ve rol ayrımı için açılan alt kodlar bize ait.
 *
 * ── İKİ CETVEL VARYANTI: YAZAR PAYI TEMEL ALANA GÖRE DEĞİŞİYOR ──
 * Madde 6/o yazar payını iki rejime ayırıyor:
 *   EŞİT BÖLÜŞME — Eğitim Bilimleri, Filoloji, Güzel Sanatlar, Hukuk,
 *       İlahiyat ile Sosyal, Beşerî ve İdari Bilimler temel alanlarında
 *       çok yazarlı yayınlarda puan yazarlar arasında eşit bölünür.
 *   BAŞLICA YAZAR AĞIRLIKLI — Fen Bilimleri ve Matematik, Mimarlık,
 *       Mühendislik, Sağlık, Spor ile Ziraat temel alanlarında iki
 *       yazarlı makalede başlıca yazar 0,8, ikinci yazar 0,5 alır; üç ve
 *       daha fazla yazarlıda başlıca yazar puanın yarısını, öbür yazarlar
 *       kalan yarısını eşit paylaşır. Başlıca yazar belirtilmemişse puan
 *       eşit bölünür.
 * Motor cetvel başına tek matris tanımlayabildiği için cetvelin iki
 * varyantı üretildi: `hbv-2026-esit` ve `hbv-2026-baslica`.
 *
 * İkinci rejim yönergede açıkça "MAKALELERDE" diye tanımlanmış. Madde 6/ö
 * kitapta ve madde 10 patentte puanın yazar/kişi sayısına EŞİT bölünmesini
 * istiyor. Tek matris kuralı yüzünden `hbv-2026-baslica` varyantında kitap
 * ve patent de makale matrisiyle hesaplanıyor; çok yazarlı kitap ve
 * patentte başlıca yazarın puanı bu yüzden OLDUĞUNDAN YÜKSEK görünür.
 * Matris, alan zorunlu kriterlerinin neredeyse tamamının yazıldığı MAKALE
 * kalemi için doğru (KONVANSIYONLAR §1'deki istisna).
 *
 * ── EĞİTİM-ÖĞRETİM (MADDE 9) PUAN SATIRI OLARAK GİRİLMEDİ ──
 * Madde 9 puanı esere değil BLOĞA veriyor: "dönemlik programlarda DÖRT
 * FARKLI YARIYILDA ders vermiş olmak — 2 puan". Kafkas'ta olduğu gibi
 * satır cetvele hiç yazılmadı; yönergede bu maddeye bağlı "en az 2 puan"
 * koşulu `metrik('ders_yariyil', 4)`'e çevrildi.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   Madde 5'te SCIE, SSCI, AHCI, ESCI ve Scopus atıfları 3 puan; sözlükte
 *       tek 'WoS / Scopus' etiketi var, o satır 3 puandan girildi.
 *   Madde 10'da faydalı model (5), endüstriyel tasarım ve ıslahçı hakkı
 *       tek satırda; patent BAŞVURUSU satırı (2) girilmedi.
 *   Madde 12'de BKCI-Scopus kitap editörlüğü (1) ile TR Dizin dergi
 *       editörlüğü (1) aynı puanda; 'Kitap Editörlüğü' ve 'Diğer Hakemli
 *       Dergi' etiketleri de 1 puandan sayılıyor.
 *   Madde 13'ün c-g bentleri (film festivali jürisi, yönetmenlik, TV ve
 *       dijital içerik, karma sanat etkinliği, uygulanmış tasarım) 5\'er
 *       puan; hepsi sanatsal etkinlik satırlarında toplandı.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   Madde 13/a (h-indeksi en az 5 → 5 puan) ve 13/b (ilk 300 üniversitede
 *       en az altı ay yurt dışı araştırma → 5 puan) — faaliyet değil
 *       profil ve süre ölçütü.
 *   Madde 13/h (en az iki yıl kesintisiz idari görev → 5 puan, en fazla
 *       10) — kayıt görev süresini taşımıyor; idari görev kayıtları bu
 *       yüzden puan getirmiyor.
 *   Madde 13/ı ve 13/i (ikinci yabancı dilden 65, bir yabancı dilden 80
 *       puan → 2\'şer puan) — faaliyet değil sınav sonucu.
 *   Madde 10/d (kişisel patent başvurusu, 2 puan) — tescilliden
 *       ayrılamıyor.
 *   SANATSAL FAALİYETLER tablosunun tamamı ve SPORTİF FAALİYETLER
 *       tablosunun tamamı — ikisi de BİLİM/SANAT DALINA kilitli
 *       (Güzel Sanatlarda El Sanatları, Müzik, Sahne Sanatları ve Sanat
 *       Yönetimi için ayrı ayrı; Spor Bilimlerinde olimpiyat madalyası ve
 *       antrenörlük belgesi). Profil adayın bilim/sanat dalını taşımadığı
 *       için satırlar girilemedi; Güzel Sanatlar ile Spor Bilimlerinin bu
 *       tablolara bağlı koşulları yönergede `hesaplanamiyor` olarak
 *       duruyor.
 *   Madde 14 (İlahiyat Dînî Musıkî) ve madde 15'in "uygulanmış proje
 *       hakkında yazılmış kitap/makale" bendi — sözlükte karşılıksız ya
 *       da bilim dalına kilitli.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   Madde 6/h: eserlerin ADAYIN ALANIYLA ilgili olması; 6/ı: her eserin
 *       yalnızca bir kez puanlanması (motorun zaten yaptığı şey).
 *   Madde 4'ün "aynı kitaptaki bölümlerden sadece biri puanlanabilir" ve
 *       "üç ansiklopedi maddesi bir kitap bölümü sayılır" kuralları.
 *   Madde 8'in "aynı bilimsel toplantıda sunulan en fazla bir çalışma
 *       puanlanabilir" kuralı.
 *
 * Yönerge: yonerge/hbv.php
 */
$TAM = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];
$AB_TUBITAK = ['AB Çerçeve / Ufuk', 'TÜBİTAK'];

$maddeler = [
    // ══ 1. ULUSLARARASI MAKALE ══
    '1.a.q1' => ['baslik' => 'SCIE veya SSCI kapsamında Q1 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $TAM, 'puan' => 30],
    '1.a.q2' => ['baslik' => 'SCIE veya SSCI kapsamında Q2 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $TAM, 'puan' => 20],
    '1.a.q3' => ['baslik' => 'SCIE veya SSCI kapsamında Q3 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $TAM, 'puan' => 15],
    '1.a.q4' => ['baslik' => 'SCIE veya SSCI kapsamında Q4 dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $TAM, 'puan' => 10],
    '1.b' => ['baslik' => 'AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => $TAM, 'puan' => 20],
    '1.c' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $TAM, 'puan' => 10],
    '1.d' => ['baslik' => 'Diğer uluslararası indekslerde taranan dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $TAM, 'puan' => 5],
    '1.e' => ['baslik' => 'Uluslararası dergide yayımlanmış editöre mektup, araştırma notu, özet veya kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI', 'ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 3],

    // ══ 2. ULUSAL MAKALE ══
    '2.a' => ['baslik' => 'TR Dizin kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TAM, 'puan' => 10],
    '2.b' => ['baslik' => 'Diğer hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => 5],
    '2.c' => ['baslik' => 'Ulusal hakemli dergide yayımlanmış editöre mektup, araştırma notu, özet veya kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 2],

    // ══ 3. LİSANSÜSTÜ TEZLERDEN ÜRETİLMİŞ YAYIN ══
    '3.a' => ['baslik' => 'Lisansüstü tezden üretilmiş, SCIE, SSCI veya AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 20],
    '3.b' => ['baslik' => 'Lisansüstü tezden üretilmiş, ESCI veya Scopus kapsamındaki dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 10],
    '3.c' => ['baslik' => 'Lisansüstü tezden üretilmiş, diğer uluslararası indekslerde taranan dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Diğer'], 'puan' => 5],
    '3.d' => ['baslik' => 'Lisansüstü tezden üretilmiş, TR Dizin kapsamındaki dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['TR Dizin'], 'puan' => 10],
    '3.e' => ['baslik' => 'Lisansüstü tezden üretilmiş, BKCI kapsamındaki kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
    '3.f' => ['baslik' => 'Lisansüstü tezden üretilmiş, BKCI kapsamındaki kitapta bölüm', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 10],
    '3.g' => ['baslik' => 'Lisansüstü tezden üretilmiş, diğer uluslararası ya da ulusal kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 5],
    '3.h' => ['baslik' => 'Lisansüstü tezden üretilmiş, diğer uluslararası ya da ulusal kitapta bölüm', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 5],
    '3.i' => ['baslik' => 'Lisansüstü tezden üretilmiş, uluslararası bilimsel toplantıda sunulup CPCI\'da yayımlanmış çalışma', 'kategori' => 'tez_yayini', 'kaynaklar' => ['CPCI Bildiri'], 'puan' => 5],

    // ══ 4. KİTAP ══
    '4.a' => ['baslik' => 'BKCI kapsamındaki kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 25],
    '4.b' => ['baslik' => 'BKCI kapsamındaki kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 8],
    '4.c' => ['baslik' => 'Diğer uluslararası ya da ulusal kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Çeviri Kitap'], 'puan' => 20],
    '4.d' => ['baslik' => 'Diğer uluslararası ya da ulusal kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi', 'Çeviri Kitap Bölümü'], 'puan' => 6],

    // ══ 5. ATIF ══
    '5.a' => ['baslik' => 'SCIE, SSCI, AHCI, ESCI veya Scopus kapsamında eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
    '5.b' => ['baslik' => 'BKCI kapsamındaki kitapta eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
    '5.c' => ['baslik' => 'TR Dizin kapsamındaki dergide eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
    '5.d' => ['baslik' => 'Diğer uluslararası ya da ulusal kitap veya dergide eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],

    // ══ 6. LİSANSÜSTÜ TEZ DANIŞMANLIĞI ══
    '6.a' => ['baslik' => 'Danışmanlığını yürüttüğünüz tamamlanmış doktora tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 5],
    '6.a.es' => ['baslik' => 'İkinci ya da eş danışmanı olduğunuz tamamlanmış doktora tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 2],
    '6.b' => ['baslik' => 'Danışmanlığını yürüttüğünüz tamamlanmış yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'roller' => ['danisman'], 'puan' => 3],
    '6.b.es' => ['baslik' => 'İkinci ya da eş danışmanı olduğunuz tamamlanmış yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 1],

    // ══ 7. BİLİMSEL ARAŞTIRMA PROJESİ ══
    '7.a.1' => ['baslik' => 'Başarıyla tamamlanmış AB Çerçeve Programı ya da TÜBİTAK bilimsel araştırma projesinde koordinatör veya yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => $AB_TUBITAK, 'roller' => ['yurutucu'], 'puan' => 15],
    '7.a.2' => ['baslik' => 'Başarıyla tamamlanmış AB Çerçeve Programı ya da TÜBİTAK bilimsel araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => $AB_TUBITAK, 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 10],
    '7.a.3' => ['baslik' => 'Başarıyla tamamlanmış AB Çerçeve Programı ya da TÜBİTAK bilimsel araştırma projesinde danışman olmak', 'kategori' => 'proje', 'kaynaklar' => $AB_TUBITAK, 'roller' => ['danisman'], 'puan' => 5],
    '7.b' => ['baslik' => 'Başarıyla tamamlanmış uluslararası destekli bilimsel araştırma projesinde yürütücü, araştırmacı ya da danışman olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'puan' => 10],
    '7.c' => ['baslik' => 'Üniversiteler dışındaki kamu kurumu ya da özel kuruluşla yapılan, başarıyla tamamlanmış Ar-Ge projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'puan' => 5],
    '7.d' => ['baslik' => 'Başarıyla tamamlanmış üniversite BAP projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 3],

    // ══ 8. BİLİMSEL TOPLANTI ══
    '8.a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulup tam metni ya da özeti CPCI\'da yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 5],
    '8.b' => ['baslik' => 'Diğer uluslararası ya da ulusal bilimsel toplantıda sunulup tam metni veya özeti yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Uluslararası Özet/Poster', 'Ulusal Tam Metin', 'Ulusal Özet/Poster', 'Davetli Konuşmacı'], 'puan' => 3],

    // ══ 10. PATENT / FAYDALI MODEL ══
    '10.a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
    '10.b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 10],
    '10.c' => ['baslik' => 'Tescil edilmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili', 'Yazılım', 'Ticarileştirme'], 'puan' => 5],

    // ══ 11. ÖDÜL ══
    '11.a' => ['baslik' => 'YÖK Yılın Doktora Tezi ya da Üstün Başarı Ödülü, TÜBİTAK Bilim veya Teşvik Ödülü, TÜBA GEBİP ya da TESEP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'Uluslararası Bilim/Sanat Ödülü', 'Ulusal Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 25],

    // ══ 12. EDİTÖRLÜK ══
    '12.a' => ['baslik' => 'SCIE, SSCI, AHCI, ESCI veya Scopus kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 2],
    '12.b' => ['baslik' => 'BKCI ya da Scopus kapsamındaki kitapta editörlük, TR Dizin kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Kitap Editörlüğü', 'TR Dizin Dergi', 'Diğer Hakemli Dergi', 'Yayın Kurulu Üyeliği', 'Hakemlik'], 'puan' => 1],

    // ══ 13. DİĞER ══
    '13.f' => ['baslik' => 'Film festivalinde jüri üyeliği, film yönetmenliği, televizyon ya da dijital platform içeriğinde görev almak, karma sanat etkinliğinde eseriyle yer almak veya uygulanmış tasarımı olmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)', 'Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)', 'Yönetmenlik (Sahne/Ekran)', 'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Karma/Jürili Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Uluslararası)', 'Elektronik Karma Sergi (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman', 'Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 5],

    // ══ 15. YARIŞMA, PROJE VE YAZILIM (Mimarlık, Planlama ve Tasarım) ══
    '15.a' => ['baslik' => 'Mimarlık, planlama, kentsel tasarım, peyzaj, iç mimari ya da endüstri ürünleri tasarımı yarışmalarında ödül veya mansiyon alan ekip yürütücüsü veya üyesi olmak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 15],
];

$kodlar = fn (string $onek): array => array_values(array_filter(
    array_keys($maddeler),
    fn (string $kod): bool => str_starts_with($kod, $onek)
));

$TEZ_YAYINI = $kodlar('3.');
$HEPSI = array_keys($maddeler);

$gruplar = [
    // Alan zorunlu kriterlerinin atıf yaptığı Tablo 1 maddeleri.
    'M1' => $kodlar('1.'),
    '1.a' => ['1.a.q1', '1.a.q2', '1.a.q3', '1.a.q4'],
    '1.a.q1-q3' => ['1.a.q1', '1.a.q2', '1.a.q3'],
    '1.a-b' => ['1.a.q1', '1.a.q2', '1.a.q3', '1.a.q4', '1.b'],
    '1.a-c' => ['1.a.q1', '1.a.q2', '1.a.q3', '1.a.q4', '1.b', '1.c'],
    '1.a-d' => ['1.a.q1', '1.a.q2', '1.a.q3', '1.a.q4', '1.b', '1.c', '1.d'],
    'M2' => $kodlar('2.'),
    '2.a' => ['2.a'],
    'M3' => $TEZ_YAYINI,
    'M4' => $kodlar('4.'),
    '4.a-c' => ['4.a', '4.c'],
    '4.b-d' => ['4.b', '4.d'],
    'M5' => $kodlar('5.'),
    'M8' => $kodlar('8.'),
    'M15' => ['15.a'],
    // Toplam puan barajları "Lisansüstü Tezlerden Üretilmiş Yayınlardan
    // alınacak puanlar hariç" hesaplanıyor (MADDE 7/B-3, C-2, Ç-1).
    'TEZ-HARIC' => array_values(array_diff($HEPSI, $TEZ_YAYINI)),
];

$grupTavanlari = [
    'M4' => 40,   // Kitap maddesinden en fazla 40 puan
    'M5' => 10,   // Atıf maddesinden en fazla 10 puan
    'M6' => 10,   // Tez danışmanlığından en fazla 10 puan
    'M7' => 15,   // Bilimsel araştırma projesinden en fazla 15 puan
    'M8' => 10,   // Bilimsel toplantıdan en fazla 10 puan
    'M10' => 20,  // Patent maddesinden en fazla 20 puan
    'M11' => 25,  // Ödül maddesinden en fazla 25 puan
    'M12' => 4,   // Editörlük maddesinden en fazla 4 puan
    'M13' => 20,  // Diğer maddesinden en fazla 20 puan
];
$gruplar['M6'] = $kodlar('6.');
$gruplar['M7'] = $kodlar('7.');
$gruplar['M10'] = $kodlar('10.');
$gruplar['M11'] = ['11.a'];
$gruplar['M12'] = $kodlar('12.');
$gruplar['M13'] = ['13.f'];

$kapsamNotu = 'Puanlar Ankara Hacı Bayram Veli Üniversitesi Akademik Yükseltilme ve Atanma '
    .'Kriterleri Yönergesinin Tablo 1 Puan Tablosundan. Maddelerin çoğunda azami puan var: '
    .'kitap 40, ödül 25, patent ve diğer 20, proje 15, atıf, tez danışmanlığı ve bilimsel '
    .'toplantı 10\'ar, editörlük 4 puan. Toplam puan barajları LİSANSÜSTÜ TEZLERDEN ÜRETİLMİŞ '
    .'YAYIN puanları hariç hesaplanıyor; o kalem yalnız kendi zorunlu koşulunu karşılıyor. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: Madde 9 (eğitim-öğretim) puanı dört '
    .'farklı yarıyılda ders vermiş olma BLOĞUNA verildiği için satır olarak girilemedi; ders '
    .'kayıtlarınız toplam puana katkı vermiyor, o maddeye bağlı koşul ise ders yarıyılı '
    .'sayısından kontrol ediliyor. Madde 13\'ün h-indeksi, yurt dışı araştırma, idari görev ve '
    .'yabancı dil puanı bentleri de faaliyet olarak kaydedilemediği için girilmedi. Patent '
    .'BAŞVURUSU satırı tescilliden ayrılamadığı için girilmedi. SANATSAL FAALİYETLER ve '
    .'SPORTİF FAALİYETLER tablolarının tamamı bilim/sanat dalına kilitli olduğu için '
    .'girilemedi; Güzel Sanatlar ve Spor Bilimleri adaylarının bu tablolara bağlı koşulları '
    .'yönergede hesaplanamıyor olarak işaretli. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünür: "aynı kitaptaki bölümlerden sadece '
    .'biri", "aynı bilimsel toplantıda en fazla bir çalışma" ve "üç ansiklopedi maddesi bir '
    .'kitap bölümü sayılır" kuralları uygulanamıyor.';

// MADDE 6/o: yazar payı temel alana göre iki rejim. Eşit bölüşme rejiminde
// bütün roller 1/n alır.
$esitBolusme = [
    'haric' => ['atif', 'tez_danismanligi', 'proje', 'odul', 'editorluk', 'idari_gorev',
        'toplumsal_katki', 'egitim_ogretim', 'diger', 'sanatsal_etkinlik'],
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.00]],
        'ilk' => ['sonrasi_pay' => 1.0],
        'baslica' => ['sonrasi_pay' => 1.0],
        'yazar_2' => ['sonrasi_pay' => 1.0],
        'yazar_3' => ['sonrasi_pay' => 1.0],
        'yazar_4' => ['sonrasi_pay' => 1.0],
        'yazar_5' => ['sonrasi_pay' => 1.0],
        'yazar_6' => ['sonrasi_pay' => 1.0],
        'ortak' => ['sonrasi_pay' => 1.0],
    ],
];

// Başlıca yazar ağırlıklı rejim: iki yazarlıda başlıca 0,8 ve ikinci 0,5;
// üç ve daha fazla yazarlıda başlıca puanın yarısını, öbürleri kalan
// yarıyı eşit paylaşır. 'ortak' rolünde başlıca yazarın belirtilip
// belirtilmediği bilinmediği için iki okumanın düşük olanı yazıldı (§0).
$baslicaAgirlikli = [
    'haric' => ['atif', 'tez_danismanligi', 'proje', 'odul', 'editorluk', 'idari_gorev',
        'toplumsal_katki', 'egitim_ogretim', 'diger', 'sanatsal_etkinlik'],
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.00]],
        'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.80], 'sonrasi' => 0.50],
        'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.80], 'sonrasi' => 0.50],
        'yazar_2' => ['kademeler' => [2 => 0.50], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
        'yazar_3' => ['kademeler' => [2 => 0.50], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
        'yazar_4' => ['kademeler' => [2 => 0.50], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
        'yazar_5' => ['kademeler' => [2 => 0.50], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
        'yazar_6' => ['kademeler' => [2 => 0.50], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
        'ortak' => ['kademeler' => [2 => 0.50], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
    ],
];

/*
 * 15. BÖLÜM YALNIZCA MİMARLIK TEMEL ALANINDA (04.09.2026'da düzeltildi).
 *
 * Kaynağın bölüm başlığı: "15. Yarışma, Proje ve Yazılım (Mimarlık, Planlama
 * ve Tasarım Temel Alanı İçin)". Kısıt doğrudan TEMEL ALANA bağlı, yani
 * motorun `alan` ekseniyle birebir ifade edilebiliyor — ama 15.a satırı iki
 * varyantta da duruyordu. `hbv-2026-esit` mimarlığı hiç içermiyor (eğitim,
 * filoloji, hukuk, ilahiyat, sosyal, güzel sanatlar), `hbv-2026-baslica` ise
 * mimarlığın yanında fen, mühendislik, sağlık, spor ve ziraatı da taşıyor:
 * yarışma derecesi kaydı olan her aday kaynağın vermediği 15 puanı alıyordu
 * (§0). Üçüncü varyant açıldı; yazar rejimi `baslica` ile aynı.
 */
$cetvel = fn (array $yazar, bool $mimarlik = false): array => [
    'kapsam_notu' => $kapsamNotu,
    'yazar_katsayisi' => $yazar,
    'maddeler' => $mimarlik
        ? $maddeler
        : array_filter($maddeler, fn (string $kod): bool => ! str_starts_with($kod, '15.'), ARRAY_FILTER_USE_KEY),
    'gruplar' => $gruplar,
    'grup_tavanlari' => $grupTavanlari,
];

return ['cetveller' => [
    'hbv-2026-esit' => $cetvel($esitBolusme),
    'hbv-2026-baslica' => $cetvel($baslicaAgirlikli),
    'hbv-2026-mimarlik' => $cetvel($baslicaAgirlikli, true),
]];
