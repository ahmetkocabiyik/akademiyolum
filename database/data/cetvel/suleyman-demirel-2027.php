<?php

/**
 * SÜLEYMAN DEMİREL ÜNİVERSİTESİ — Ek-1 Eser Puan Tablosu
 * Kaynak: pdf/17855054481.Süleyman Demirel Üniversitesi Kriter Değişikliği.pdf
 * (Senato 28.01.2026 tarih ve 658/6 sayılı kararı; 01.01.2027'de yürürlüğe
 * giriyor)
 *
 * Madde kodları Ek-1'in kendi numaralarını izliyor (1.a, 7.a, 15.1.d …).
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   1/b (SCOPUS, çeyreğe göre 40-20) ile 1/c (ESCI ve SPORT Discus, 20)
 *       tek 'ESCI / Scopus' etiketine düşüyor → 20. Scopus Q1
 *       makaleleriniz olduğundan düşük puanlanır ve 1/b kolu ayrı
 *       değerlendirilemez.
 *   AHCI dergilerinin çeyreği kayıtta bulunmadığı için 1/a'nın en düşük
 *       kademesi (Q4, 20 puan) uygulandı.
 *   Tez danışmanlığında ikinci ve eş danışmanlık puanın yarısı olduğundan
 *       doktorada 2, yüksek lisansta 1 girildi.
 *   Editörlükte dergi editörlüğü (2), kitap editörlüğü (1), TR Dizin
 *       editörlüğü (1) ve hakemlik (1) birbirinden ayrı; yayın kurulu
 *       üyeliği tabloda yok, hakemlik değerinden (1) sayılıyor.
 *   Sanat bölümünde film yönetmenliği (20) ile görüntü yönetmenliği (10)
 *       ve karma etkinlik (5) satırları ayrı etiketlere bağlandı; müzikte
 *       Klasik Batı Müziği (10) ile Türk müziği (5) özgün eser satırları
 *       aynı etikete düştüğü için 5 girildi.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   Ek-1'in 3. MADDESİNİN TAMAMI (lisansüstü tezlerden üretilmiş yayınlar)
 *       — faaliyet kaydı yayının tez kökenli olup olmadığını taşımıyor; hem
 *       1, 2 ve 4. maddeleri hem de 3. maddeyi yazmak aynı yayını iki kez
 *       saydırırdı. Tablo 2'nin "3/a veya 3/b maddelerinden en az bir
 *       makale" koşulları bu yüzden yönergenin kendi alternatif koluyla
 *       (1/a-1/c'den bir makale) değerlendiriliyor.
 *   9. madde (eğitim-öğretim): puan tek derse değil "dört farklı yarıyılda
 *       ders vermiş olmak" bloğuna veriliyor; satır yazılmadı, koşul
 *       doçentlik ve profesörlükte ders yarıyılı metriğine çevrildi.
 *   10/d (değerlendirmeye alınmış patent başvurusu, 2 puan) — tescilden
 *       ayrılamıyor.
 *   14. madde SPORTİF BAŞARI VE TEMSİL bölümünün tamamı (olimpiyat
 *       madalyası, millî sporcu belgesi, antrenörlük kademesi, hakemlik
 *       belgesi) — faaliyet kaydında karşılığı yok. Spor Bilimlerinin bu
 *       bölüme bağlı 10 puanlık koşulu yönergede `hesaplanamiyor`.
 *   15.1/a (sergi içeriğinde en az 15 özgün eser barındıran kişisel sergi,
 *       20 puan) — puan tek esere değil serginin tamamına veriliyor ve
 *       "en az 15 eser" koşulu kayıtta doğrulanamıyor.
 *   15.2'nin orkestra şefliği, dans, koreografi ve halk oyunları alt
 *       bölümleri ile 15.1'in ödül ve küratörlük dışı ayrıntıları.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   MADDE 9/4'ün "yurt dışındaki üniversite ya da kurumlarda görev yapan
 *       araştırmacılarla ortak yazarlı çalışmalara 1,25 kat puan" kuralı:
 *       kayıt ortak yazarın kurumunu taşımıyor, ek çarpan uygulanmıyor.
 *   10. maddenin "patentlerde puan kişi sayısına bölünür" kuralı: Tablo
 *       1'in yazar oranları patent satırlarına da uygulanıyor.
 *   4. maddenin "aynı kitapta en fazla bir bölüm", 5. maddenin "aynı
 *       yayında birden fazla atıf tek atıf sayılır" ve 8. maddenin "aynı
 *       toplantıda en fazla bir çalışma" sınırları.
 *   12. maddenin "her yıl için puanlanabilir" kuralı: editörlük görev
 *       süresi kayıtta olmadığı için bir kez sayılıyor.
 *
 * Yönerge: yonerge/suleyman-demirel.php
 */
$TAM = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale'];
$VAKA = ['vaka_teknik_not'];
$ULUSLARARASI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI',
    'ESCI / Scopus', 'Diğer Uluslararası İndeks'];

$maddeler = [
    // ══ 1. ULUSLARARASI MAKALE ══
    '1.a.q1' => ['baslik' => 'SCIE, SSCI veya AHCI kapsamındaki Q1 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $TAM, 'puan' => 50],
    '1.a.q2' => ['baslik' => 'SCIE, SSCI veya AHCI kapsamındaki Q2 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $TAM, 'puan' => 40],
    '1.a.q3' => ['baslik' => 'SCIE, SSCI veya AHCI kapsamındaki Q3 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $TAM, 'puan' => 30],
    '1.a.q4' => ['baslik' => 'SCIE, SSCI veya AHCI kapsamındaki Q4 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => $TAM, 'puan' => 20],
    '1.bc' => ['baslik' => 'SCOPUS, ESCI veya SPORT Discus kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $TAM, 'puan' => 20],
    '1.d' => ['baslik' => 'Diğer uluslararası indekslerde taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $TAM, 'puan' => 5],
    '1.e' => ['baslik' => 'Uluslararası dergide yayımlanmış editöre mektup, araştırma notu, özet ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => $ULUSLARARASI, 'turler' => $KISA, 'puan' => 3],
    '1.f' => ['baslik' => 'Uluslararası dergide yayımlanmış vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => $ULUSLARARASI, 'turler' => $VAKA, 'puan' => 5],

    // ══ 2. ULUSAL MAKALE ══
    '2.a' => ['baslik' => 'TR Dizin kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TAM, 'puan' => 10],
    '2.b' => ['baslik' => 'Diğer hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => 4],
    '2.c' => ['baslik' => 'Ulusal hakemli dergide yayımlanmış editöre mektup, araştırma notu, özet ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => [...$KISA, ...$VAKA], 'puan' => 2],

    // ══ 4. KİTAP ══
    '4.a' => ['baslik' => 'BKCI veya Scopus kapsamındaki kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
    '4.b' => ['baslik' => 'BKCI veya Scopus kapsamındaki kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 10],
    '4.c' => ['baslik' => 'Diğer uluslararası ya da ulusal özgün bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 5],
    '4.d' => ['baslik' => 'Diğer uluslararası ya da ulusal kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 3],

    // ══ 5. ATIF ══
    '5.a' => ['baslik' => 'SCIE, SSCI, AHCI, ESCI veya SCOPUS kapsamında eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
    '5.b' => ['baslik' => 'BKCI kapsamındaki kitapta eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
    '5.c' => ['baslik' => 'TR Dizin kapsamındaki dergide eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
    '5.d' => ['baslik' => 'Diğer uluslararası ya da ulusal kitap, kitap bölümü veya dergide eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],

    // ══ 6. LİSANSÜSTÜ TEZ DANIŞMANLIĞI ══
    '6.a' => ['baslik' => 'Tamamlanmış doktora, sanatta yeterlik ya da uzmanlık tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 2],
    '6.b' => ['baslik' => 'Tamamlanmış yüksek lisans tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'puan' => 1],

    // ══ 7. BİLİMSEL ARAŞTIRMA PROJESİ ══
    '7.a.y' => ['baslik' => 'AB Çerçeve Programı, COST ya da TÜBİTAK projesinde koordinatörlük veya yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 30],
    '7.a.a' => ['baslik' => 'AB Çerçeve Programı, COST ya da TÜBİTAK projesinde araştırmacılık veya uzmanlık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 20],
    '7.a.d' => ['baslik' => 'AB Çerçeve Programı, COST ya da TÜBİTAK projesinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK', 'TÜSEB'], 'roller' => ['danisman'], 'puan' => 10],
    '7.b' => ['baslik' => 'Uluslararası destekli bilimsel araştırma projesinde yürütücülük, araştırmacılık ya da danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'puan' => 20],
    '7.c' => ['baslik' => 'Üniversiteler dışındaki kamu kurumu ya da özel kuruluşla yapılan Ar-Ge projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK', 'BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'puan' => 10],

    // ══ 8. BİLİMSEL TOPLANTI ══
    '8.a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan ve CPCI\'da yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 5],
    '8.b' => ['baslik' => 'Diğer uluslararası ya da ulusal bilimsel toplantıda sunulan ve yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Uluslararası Özet/Poster', 'Ulusal Tam Metin', 'Ulusal Özet/Poster', 'Davetli Konuşmacı'], 'puan' => 3],

    // ══ 10. PATENT / FAYDALI MODEL ══
    '10.a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
    '10.b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 10],
    '10.c' => ['baslik' => 'Tescil edilmiş faydalı model, endüstriyel tasarım ya da yazılım', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Ticarileştirme'], 'puan' => 5],

    // ══ 11. ÖDÜL ══
    '11.a' => ['baslik' => 'YÖK üstün başarı ödülü, TÜBİTAK bilim ya da teşvik ödülü, TÜBA GEBİP ya da TESEP ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 25],

    // ══ 12. EDİTÖRLÜK ══
    '12.a' => ['baslik' => 'SCIE, SSCI, AHCI, ESCI veya SCOPUS kapsamındaki dergide baş editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 2],
    '12.b' => ['baslik' => 'BKCI veya SCOPUS kapsamındaki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Kitap Editörlüğü'], 'puan' => 1],
    '12.c' => ['baslik' => 'TR Dizin kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 1],
    '12.d' => ['baslik' => 'Akademik yayınlarda hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik', 'Yayın Kurulu Üyeliği'], 'puan' => 1],

    // ══ 13. YARIŞMA, PROJE VE YAZILIM ══
    '13.a' => ['baslik' => 'Mimarlık, planlama, kentsel tasarım, peyzaj, iç mimari ya da endüstri ürünleri tasarımı yarışmalarında ödül veya mansiyon almak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon', 'Uluslararası Bilim/Sanat Ödülü', 'Ulusal Bilim/Sanat Ödülü'], 'puan' => 15],
    '13.b' => ['baslik' => 'Uygulanmış ya da tamamlanmış tasarım, planlama veya koruma projesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman', 'Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)'], 'puan' => 10],
    '13.c' => ['baslik' => 'Proje ve yapım yönetimi, tasarım ya da planlama alanlarında yazılım üreticisi olmak', 'kategori' => 'patent', 'kaynaklar' => ['Yazılım'], 'puan' => 15],

    // ══ 15. SANAT VE TASARIM FAALİYETLERİ ══
    '15.1.b' => ['baslik' => 'Film festivaline seçilen ya da özel gösterimi yapılan orta veya uzun metrajlı filmin yönetmenliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)'], 'puan' => 20],
    '15.1.c' => ['baslik' => 'Film festivaline seçilen ya da özel gösterimi yapılan filmin görüntü yönetmenliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Yönetmenlik (Sahne/Ekran)'], 'puan' => 10],
    '15.1.d' => ['baslik' => 'Uluslararası ya da ulusal sergi, çalıştay, bienal, defile, gösteri, performans veya festival türündeki karma etkinlikte eseriyle yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Karma Sergi (Uluslararası)', 'Elektronik Karma Sergi (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)'], 'puan' => 5],
    '15.1.e' => ['baslik' => 'Sanatsal etkinlikte gösterimi yapılmış filmin ekibinde yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'], 'puan' => 5],
    '15.1.f' => ['baslik' => 'Eserinizin kamusal alanda sürekli olarak sergilenmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Haber Olması (Uluslararası)', 'Eserin Haber Olması (Ulusal)'], 'puan' => 5],
    '15.1.h' => ['baslik' => 'Reklam ya da tanıtım filmi, müzik klibi yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisörlük (Uluslararası)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Rejisör Yardımcılığı (Uluslararası)', 'Rejisör Yardımcılığı (Ulusal)', 'Rejisör Yardımcılığı (Konservatuvar)'], 'puan' => 5],
    '15.2.a' => ['baslik' => 'Özgün müzik eseri sunmak (solo çalgı, oda müziği, orkestra, sahne müziği, vokal topluluğu, elektronik müzik ya da Türk müziği türlerinde)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım', 'Opera/Bale Kompozisyonu', 'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Orkestralı Sahne Eseri', 'Küçük Ölçekli Orkestra Eseri', 'Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Sahne/Ekran Müziği', 'Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi'], 'puan' => 5],
    '15.2.b' => ['baslik' => 'Solo konser, resital ya da orkestra eşliğinde canlı solo konser vermek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Uluslararası)', 'Resital (Ulusal)', 'Şan Resitali (Uluslararası)', 'Şan Resitali (Ulusal)', 'Solistlik (Uluslararası)', 'Solistlik (Ulusal)', 'Oratoryo/Kantat Solistliği (Uluslararası)', 'Oratoryo/Kantat Solistliği (Ulusal)', 'Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Elektronik Kişisel Sergi (Ulusal)'], 'puan' => 10],
    '15.2.c' => ['baslik' => 'Bandrollü ya da dijital yayımlanmış solo albüm', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bandrollü Kayıt (CD/DVD)'], 'puan' => 20],
    '15.2.d' => ['baslik' => 'Dijital müzik platformunda yayımlanmış albüm', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Albüm / Konser Kaydı', 'Eğitim Müziği Albümü'], 'puan' => 10],
    '15.2.f' => ['baslik' => 'Oda müziği konserinde icracı olarak bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Uluslararası)', 'Oda Müziği Grup Üyeliği (Ulusal)', 'Başkemancılık (Uluslararası)', 'Başkemancılık (Ulusal)'], 'puan' => 10],
    '15.2.e' => ['baslik' => 'Karma ya da koro konserinde icracı olarak bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra / Koro Üyeliği', 'Karma Albüm / CD-DVD Katkısı', 'Corps de Ballet (Uluslararası)', 'Corps de Ballet (Ulusal)', 'Dansçı / Performans İcracısı (Uluslararası)', 'Dansçı / Performans İcracısı (Ulusal)'], 'puan' => 5],
    'SPOR-FED' => ['baslik' => 'Olimpik spor federasyonunun yönetim, teknik, eğitim ya da hakem kurulunda görev', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Spor Federasyonu Kurul Üyeliği (Uluslararası)'], 'puan' => 4],
];

$MAKALE_1A = ['1.a.q1', '1.a.q2', '1.a.q3', '1.a.q4'];
$MAKALE_1ABC = [...$MAKALE_1A, '1.bc'];
$KITAP_4AB = ['4.a', '4.b'];

return [
    'kapsam_notu' => 'Puanlar Süleyman Demirel Üniversitesi Öğretim Üyeliği Kadrolarına '
        .'Başvurma, Atanma ve Yükseltilme Kriterlerine İlişkin Yönergenin Ek-1 Eser Puan '
        .'Tablosundan (28.01.2026 Senato kararı; 01.01.2027\'de yürürlüğe giriyor). Ortak '
        .'çalışmalarda Tablo 1 uygulanıyor: tek yazarlıda tam puan; iki yazarlıda birinci ya da '
        .'başlıca yazar %80, ikinci %50; üç yazarlıda %60, %40, %30; dört ve daha fazla yazarlıda '
        .'birinci yazar %50 alıyor, kalan yazarlar tam puanın %80\'ini eşit paylaşıyor. Yazar '
        .'listesini boş bırakırsanız oran uygulanmaz ve puanınız olduğundan yüksek görünür. '
        .'Kitaptan en fazla 30 (diğer kitap satırlarından 15), atıftan 10, tez danışmanlığından '
        .'10, bilimsel toplantıdan 10, ödülden 25, editörlükten 6 puan alınabiliyor. Puanınız şu '
        .'kalemlerde OLDUĞUNDAN DÜŞÜK görünür: SCOPUS makaleleri ESCI ile aynı etikette olduğu '
        .'için çeyreğine bakılmaksızın 20 puandan sayılıyor; AHCI dergileri en düşük kademeden '
        .'(20) sayılıyor; eş danışmanlık ayrışmadığı için tez danışmanlığı yarı değerden '
        .'girildi; 14. madde sportif başarı bölümünün tamamı ile 15.1/a (en az 15 eser '
        .'barındıran kişisel sergi) ve eğitim-öğretim satırları girilemedi; yurt dışı ortak '
        .'yazarlık için verilen 1,25 kat ek puan uygulanamıyor. Puanınız şu kalemde OLDUĞUNDAN '
        .'YÜKSEK görünür: lisansüstü tezinizden ürettiğiniz yayınlar için Ek-1\'in 3. '
        .'maddesindeki düşük satırlar ve o maddenin 40 puanlık sınırı uygulanamıyor.',

    // Tablo 1: Eserlere katkıda bulunan kişilerin puan hesap tablosu.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'editorluk', 'proje', 'tez_danismanligi', 'tez_yayini',
            'egitim_ogretim', 'idari_gorev', 'toplumsal_katki', 'diger'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.80, 3 => 0.60], 'sonrasi' => 0.50],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.80, 3 => 0.60], 'sonrasi' => 0.50],
            'yazar_2' => ['kademeler' => [2 => 0.50, 3 => 0.40], 'bol' => ['pay' => 0.8, 'eksi' => 1]],
            'yazar_3' => ['kademeler' => [3 => 0.30], 'bol' => ['pay' => 0.8, 'eksi' => 1]],
            'ortak' => ['bol' => ['pay' => 0.8, 'eksi' => 1]],
        ],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        'TOPLAM' => array_keys($maddeler),
        // Tablo 2, 3 ve 4'ün atıf yaptığı madde kümeleri.
        '1A' => $MAKALE_1A,
        '1A-Q123' => ['1.a.q1', '1.a.q2', '1.a.q3'],
        '1ABC' => $MAKALE_1ABC,
        '2A' => ['2.a'],
        '1ABC-2A' => [...$MAKALE_1ABC, '2.a'],
        '1ABC-2A-4AB' => [...$MAKALE_1ABC, '2.a', ...$KITAP_4AB],
        '4AB' => $KITAP_4AB,
        'PROJE' => ['7.a.y', '7.a.a', '7.a.d', '7.b', '7.c'],
        'YARISMA' => ['13.a', '13.b', '13.c'],
        'SANAT' => ['15.1.b', '15.1.c', '15.1.d', '15.1.e', '15.1.f', '15.1.h',
            '15.2.a', '15.2.b', '15.2.c', '15.2.d', '15.2.e', '15.2.f'],
        // Tavan grupları.
        'KITAP' => ['4.a', '4.b', '4.c', '4.d'],
        'KITAP-DIGER' => ['4.c', '4.d'],
        'ATIF' => ['5.a', '5.b', '5.c', '5.d'],
        'TEZ' => ['6.a', '6.b'],
        'BILDIRI' => ['8.a', '8.b'],
        'ODUL' => ['11.a'],
        'EDITORLUK' => ['12.a', '12.b', '12.c', '12.d'],
    ],

    'grup_tavanlari' => [
        'KITAP' => 30,
        'KITAP-DIGER' => 15,
        'ATIF' => 10,
        'TEZ' => 10,
        'BILDIRI' => 10,
        'ODUL' => 25,
        'EDITORLUK' => 6,
    ],
];
