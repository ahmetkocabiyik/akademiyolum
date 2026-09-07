<?php

/**
 * SİİRT ÜNİVERSİTESİ — Ek-I Puan Tablosu
 * Kaynak: pdf/17634009071.Siirt Üniversitesi Kriter.pdf
 * (Senato kararı 26.02.2025/2025-03 ile değişik hâli)
 *
 * Madde kodları Ek-I'in kendi numaralarını izliyor (1.a, 7.ç …).
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   AHCI dergilerinin çeyrek dilimi kayıtta bulunmadığı için 1. maddenin
 *       en düşük kademesi (Q4, 40 puan) uygulandı.
 *   1.e (uluslararası alan endeksleri, 20) ile 1.g (diğer uluslararası
 *       hakemli dergiler, 10) tek 'Diğer Uluslararası İndeks' etiketine
 *       düşüyor → 10.
 *   Atıfta SCI-SSCI-AHCI dışı endeksler (2) ile ulusal hakemli dergiler
 *       ve kitaplar (1) ayrışmıyor → 1.
 *   Tez danışmanlığında ikinci ve eş danışmanlık puanın yarısı olduğundan
 *       doktorada 10, yüksek lisansta 5 girildi.
 *   Hakemlikte üç kademe (6, 4, 3) tek 'Hakemlik' etiketine düşüyor → 3.
 *   Davetli konuşmacılıkta uluslararası (5) ile ulusal (3) → 3; kongre
 *       düzenleme kurulu görevlerinin altı kademesi (10'dan 1'e) tek
 *       'Diğer' etiketine düşüyor → 1.
 *   İdari görevlerde rektörlük komisyonları (7) ile birim komisyonları
 *       (5) → 5.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   Ek-I'in 2. MADDESİNİN TAMAMI (lisansüstü tezlerden üretilmiş
 *       yayınlar, 40'tan 2 puana) — faaliyet kaydı yayının tez kökenli
 *       olup olmadığını taşımıyor; hem 1 hem 2. maddeyi yazmak aynı
 *       makaleyi iki kez saydırırdı. Eşiklerin makale barajı 1. maddeye
 *       yazıldığı için o madde girildi; tezinizden ürettiğiniz yayınlar
 *       olduğundan YÜKSEK puanlanıyor.
 *   13.d (kurum içi ya da dışı alınan bilimsel ödüller, 4 puan) —
 *       sözlükte karşılıksız.
 *   EK-2'NİN TAMAMI (Sinema, Plastik Sanatlar, Tasarım, Geleneksel Türk
 *       Sanatları, Müzik-Kompozisyon, Yorumculuk, Türk Müziği, Dans ve
 *       Koreografi, Halk Dansları bölümleri) — her bölüm ayrı bir sanat
 *       dalına kilitli, koşullar "tüm şartlar zorunludur" biçiminde
 *       kurgulanmış ve puanlar tek esere değil dosyanın tamamına
 *       veriliyor. Güzel Sanatlar alanından başvuran adayın sanatsal
 *       etkinlikleri bu yüzden hiç sayılmıyor.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   4. maddenin "patentlerde puan kişi sayısına bölünür" kuralı: MADDE
 *       11'in yazar oranları patent satırlarına da uygulanıyor, yani çok
 *       kişili patentlerde puanınız olduğundan YÜKSEK çıkar.
 *   3. maddenin "aynı kitaptan en fazla 20 (uluslararası) ya da 10
 *       (ulusal) puan" sınırı ile 9. maddenin "aynı toplantıda sunulan en
 *       fazla bir bildiri puanlanır" kuralı.
 *   14. maddenin "her yıl için hesaplanır" kuralı: kayıt görev süresini
 *       taşımadığı için her idari görev bir kez sayılıyor.
 *
 * Yönerge: yonerge/siirt.php
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 */
$TAM = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];
$TUM_DERGI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI',
    'ESCI / Scopus', 'TR Dizin', 'Diğer Uluslararası İndeks', 'Diğer Ulusal Hakemli'];

$maddeler = [
    // ══ 1. MAKALELER ══
    '1.a' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI kapsamındaki Q1 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $TAM, 'puan' => 60],
    '1.b' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI kapsamındaki Q2 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $TAM, 'puan' => 50],
    '1.c' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI kapsamındaki Q3 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $TAM, 'puan' => 45],
    '1.ç' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI kapsamındaki Q4 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => $TAM, 'puan' => 40],
    '1.d' => ['baslik' => 'ESCI veya SCOPUS kapsamında taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $TAM, 'puan' => 30],
    '1.f' => ['baslik' => 'ULAKBİM TR Dizin tarafından taranan ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TAM, 'puan' => 16],
    '1.g' => ['baslik' => 'Uluslararası alan endekslerinde ya da diğer uluslararası hakemli dergilerde makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $TAM, 'puan' => 10],
    '1.ğ' => ['baslik' => 'Ulusal hakemli diğer dergilerde makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => 8],
    '3.g' => ['baslik' => 'Kitap kritiği, editöre mektup, özet ya da teknik not', 'kategori' => 'makale', 'kaynaklar' => $TUM_DERGI, 'turler' => $KISA, 'puan' => 5],

    // ══ 3. KİTAP ══
    '3.a' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 50],
    '3.b' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 20],
    '3.c' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 20],
    '3.ç' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı'], 'puan' => 30],
    '3.d' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 15],
    '3.e' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 10],
    '3.f' => ['baslik' => 'Kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 15],
    '3.ğ' => ['baslik' => 'Kitapta bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 5],

    // ══ 4. PATENT ══
    '4.a' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 60],
    '4.b' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 30],
    '4.c' => ['baslik' => 'Faydalı model, endüstriyel tasarım ya da yazılım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Ticarileştirme'], 'puan' => 20],

    // ══ 5. ATIFLAR ══
    '5.a' => ['baslik' => 'SCI, SCI-Expanded, SSCI ve AHCI dergilerinde ya da uluslararası yayınevi kitaplarında eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 3],
    '5.c' => ['baslik' => 'Ulusal hakemli dergilerde ve ulusal yayınevi kitaplarında eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 1],

    // ══ 6. LİSANSÜSTÜ TEZ DANIŞMANLIĞI ══
    '6.a' => ['baslik' => 'Tamamlanmış doktora tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 10],
    '6.b' => ['baslik' => 'Tamamlanmış yüksek lisans tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'puan' => 5],

    // ══ 7. BİLİMSEL ARAŞTIRMA PROJESİ ══
    '7.a' => ['baslik' => 'AB Çerçeve Programı, UNICEF ya da UNESCO destekli projede koordinatörlük, baş araştırmacılık ya da yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 100],
    '7.b' => ['baslik' => 'AB Çerçeve Programı, UNICEF ya da UNESCO destekli projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 50],
    '7.c' => ['baslik' => 'Uluslararası destekli sosyal projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'puan' => 50],
    '7.ç' => ['baslik' => 'TÜBİTAK destekli bilimsel araştırma projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 50],
    '7.d' => ['baslik' => 'TÜBİTAK destekli bilimsel araştırma projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 25],
    '7.e' => ['baslik' => 'TÜBİTAK destekli bilimsel araştırma projesinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['danisman'], 'puan' => 10],
    '7.f' => ['baslik' => 'Üniversite dışındaki kamu kurumlarıyla tamamlanmış projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 40],
    '7.g' => ['baslik' => 'Üniversite dışındaki kamu kurumlarıyla tamamlanmış projede araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
    '7.ğ' => ['baslik' => 'Tamamlanmış BAP ya da ihtisaslaşma projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 10],
    '7.h' => ['baslik' => 'Tamamlanmış BAP ya da ihtisaslaşma projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 5],

    // ══ 8. DERGİLERDE EDİTÖRLÜK VE HAKEMLİK ══
    '8.i.a' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 10],
    '8.ii.a' => ['baslik' => 'Uluslararası hakemli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 8],
    '8.iii.a' => ['baslik' => 'Ulusal hakemli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 6],
    '8.iii.b' => ['baslik' => 'Hakemli dergilerde hakemlik ya da yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik', 'Yayın Kurulu Üyeliği'], 'puan' => 3],

    // ══ 9. BİLİMSEL TOPLANTI FAALİYETİ ══
    '9.a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan ve tam metni ya da özeti yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 8],
    '9.b' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 4],
    '9.c' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan ve tam metni ya da özeti yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 6],
    '9.ç' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 3],
    '10.ç' => ['baslik' => 'Kongre ve sempozyumlarda davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 3],
    '10.a' => ['baslik' => 'Kongre ve sempozyumlarda düzenleme kurulu başkanlığı, oturum başkanlığı ya da düzenleme kurulunda görev almak', 'kategori' => 'diger', 'kaynaklar' => ['Diğer', 'Toplantı Düzenleme Başkanlığı (Uluslararası)', 'Toplantı Düzenleme Başkanlığı (Ulusal)', 'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 1],
    // Kaynak 10/b uluslararası kongrede panel veya oturum başkanlığı 5, 11/b ULUSAL kongrede 3 diyor.
    '10.a-otr' => ['baslik' => 'Uluslararası bilimsel ya da sanatsal toplantıda oturum başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Uluslararası)'], 'puan' => 5],
    '10.a-otr-ulusal' => ['baslik' => 'Ulusal bilimsel ya da sanatsal toplantıda oturum başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Ulusal)'], 'puan' => 3],

    // ══ 12. EĞİTİM ÖĞRETİM FAALİYETİ ══
    '12.a' => ['baslik' => 'Bir dönem yüksek lisans ya da doktora dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
    '12.b' => ['baslik' => 'Bir dönem önlisans ya da lisans dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 2],

    // ══ 13. ÖDÜL ══
    '13.a' => ['baslik' => 'Alanında yurt dışı kurum ve kuruluşlardan alınan bilim ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 60],
    '13.b' => ['baslik' => 'YÖK, TÜBA veya TÜBİTAK\'tan alınan bilim ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 50],
    // 13.c (10) ile 13.d (4) AYNI ETİKETLERE düşüyor: kaynak ödülü veren
    // kuruma göre ayırıyor (meslek odası/vakıf ↔ kurum içi/dışı), sözlük
    // ayırmıyor. `puan()` en yükseği aldığı için etiket 13.c'de kalsaydı
    // sıradan bir kurum ödülü de 10 sayılırdı; etiketler en düşük kademeye,
    // 13.d'ye taşındı ve 13.c bilerek ölü bırakıldı (§0).
    '13.c' => ['baslik' => 'Meslek odaları ya da bilimsel amaçlı vakıflar tarafından verilen ödül', 'kategori' => 'odul', 'kaynaklar' => [], 'puan' => 10],
    '13.d' => ['baslik' => 'Kurum içi ya da dışından alınan bilimsel ödül', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'Burs'], 'puan' => 4],
    '13.ç' => ['baslik' => 'Kongre ve sempozyumlarda kazanılan ödül', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 5],

    // ══ 14. İDARİ GÖREV VE KOMİSYONLAR ══
    '14.a' => ['baslik' => 'Rektörlük, dekanlık, meslek yüksekokulu, yüksekokul ya da enstitü müdürlüğü (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü'], 'puan' => 8],
    '14.c' => ['baslik' => 'Dekan yardımcılığı, bölüm başkanlığı, uygulama ve araştırma merkezi müdürlüğü ya da müdür yardımcılığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkanı', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 7],
    '14.d' => ['baslik' => 'Anabilim dalı başkanlığı, komisyon ve koordinatörlüklerde görev almak (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük', 'Bölüm Başkan Yardımcısı', 'Kurul / Komisyon Üyeliği'], 'puan' => 5],
];

$MAKALE = ['1.a', '1.b', '1.c', '1.ç', '1.d', '1.f', '1.g', '1.ğ', '3.g'];
$KITAP = ['3.a', '3.b', '3.c', '3.ç', '3.d', '3.e', '3.f', '3.ğ'];

return [
    'kapsam_notu' => 'Puanlar Siirt Üniversitesi Akademik Yükseltilme ve Atanma Kriterleri '
        .'Yönergesinin Ek-I puan tablosundan (26.02.2025 tarihli Senato kararıyla değişik). '
        .'Ortak çalışmalarda MADDE 11 uygulanıyor: tek yazarlı çalışmada tam puan; birden fazla '
        .'yazar varsa birinci isim %90, ikinci %80, üçüncü %70, dördüncü %60, beşinci ve '
        .'sonraki isimler %50 alıyor. Sorumlu yazar ya da senyör yazar isim sırasına '
        .'bakılmaksızın %90 alıyor. Atıf ve proje satırlarına bu oranlar uygulanmıyor. Yazar '
        .'listesini boş bırakırsanız oran uygulanmaz ve puanınız olduğundan yüksek görünür. '
        .'Atıflardan, tez danışmanlığından, editörlük ve hakemlikten, bilimsel toplantıdan ve '
        .'idari görevden her atama döneminde en fazla 30\'ar; kongre görevlerinden 10\'ar; '
        .'eğitim öğretimden 15 puan alınabiliyor. Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK '
        .'görünür: AHCI dergilerinin çeyreği kayıtta olmadığı için en düşük kademeden (40) '
        .'sayılıyor; uluslararası alan endeksleri diğer uluslararası dergilerden ayrışmadığı '
        .'için 10 puandan sayılıyor; EK-2\'nin sanat bölümlerinin tamamı girilemedi, Güzel '
        .'Sanatlar adayının sanatsal etkinlikleri hiç sayılmıyor. Puanınız şu kalemlerde '
        .'OLDUĞUNDAN YÜKSEK görünür: lisansüstü tezinizden ürettiğiniz yayınlar için 2. '
        .'maddedeki düşük satırlar uygulanamıyor; patentte "puan kişi sayısına bölünür" kuralı '
        .'yerine MADDE 11\'in yazar oranları işliyor.',

    // MADDE 11: tek yazar %100; birinci isim %90, ikinci %80, üçüncü %70,
    // dördüncü %60, beşinci ve sonrası %50. Sorumlu ya da senyör yazar sıraya
    // bakılmaksızın %90. Atıf ve projeler bu orandan muaf.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'proje', 'tez_danismanligi', 'tez_yayini', 'egitim_ogretim',
            'idari_gorev', 'toplumsal_katki', 'odul', 'diger'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00], 'sonrasi' => 0.90],
            'baslica' => ['kademeler' => [1 => 1.00], 'sonrasi' => 0.90],
            'yazar_2' => ['sonrasi' => 0.80],
            'yazar_3' => ['sonrasi' => 0.70],
            'yazar_4' => ['sonrasi' => 0.60],
            'ortak' => ['sonrasi' => 0.50],
        ],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        'TOPLAM' => array_keys($maddeler),
        // Ek-I 1. maddenin dipnotu: "bu alandan en az 8 puan almış olmak
        // zorunludur".
        'MAKALE' => $MAKALE,
        // MADDE 8/b: "etkinliğin puanının yarısını yayınlardan (makale ve
        // kitap) sağlamak zorunludur".
        'YAYIN' => [...$MAKALE, ...$KITAP],
        // Tavan grupları.
        'ATIF' => ['5.a', '5.c'],
        'TEZ' => ['6.a', '6.b'],
        'EDITORLUK' => ['8.i.a', '8.ii.a', '8.iii.a', '8.iii.b'],
        'BILDIRI' => ['9.a', '9.b', '9.c', '9.ç'],
        'KONGRE' => ['10.a', '10.ç'],
        'DERS' => ['12.a', '12.b'],
        'IDARI' => ['14.a', '14.c', '14.d'],
    ],

    'grup_tavanlari' => [
        'ATIF' => 30,
        'TEZ' => 30,
        'EDITORLUK' => 30,
        'BILDIRI' => 30,
        'KONGRE' => 10,
        'DERS' => 15,
        'IDARI' => 30,
    ],
];
