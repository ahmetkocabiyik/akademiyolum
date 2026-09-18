<?php

/**
 * ZONGULDAK BÜLENT ECEVİT ÜNİVERSİTESİ — Ek-2 Akademik Faaliyet Puan Tablosu
 * Kaynak: pdf/17634009071.Zonguldak Bülent Ecevit Üniversitesi Kriter.pdf
 * (24.10.2024 YÖK Genel Kurulu; 01.01.2026'da yürürlüğe giriyor)
 *
 * Madde kodları Ek-2'nin kendi numaralarını izliyor (1.a.q1, 13.ç …).
 *
 * ── TEZDEN ÜRETİLMİŞ SATIRLAR YAZILMADI, ÇÜNKÜ DEĞERLERİ AYNI ──
 * Ek-2'nin 3. maddesi (lisansüstü tezlerden üretilmiş makaleler) 1 ve 2.
 * maddelerle BİREBİR AYNI puanları veriyor; 4. madde (tezden üretilmiş
 * kitaplar) da 5. madde ile aynı. Faaliyet kaydı yayının tez kökenli olup
 * olmadığını taşımadığı için 3 ve 4. maddeler yazılmadı; puan açısından
 * fark yok, yalnız 3. maddenin kendi tavanı (kitaplarda 60) uygulanmıyor.
 * Madde 9 ve 10'un "1(a)'dan bir + 3(a)'dan bir" biçimindeki koşulları bu
 * yüzden yönergenin diğer koluyla (yalnız 1. maddeden gereken sayıda
 * yayın) değerlendiriliyor.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   Editörlükte SCIE-SSCI-AHCI-ESCI dergilerinde editörlük (50), editör
 *       yardımcılığı (20) ve yayın kurulu üyeliği (15) ayrı etiketlerde;
 *       diğer alan indekslerinde editörlük (15), TR Dizin editörlüğü (10)
 *       ve diğer uluslararası indeks editörlüğü (10) da öyle. Yayın kurulu
 *       üyeliğinin dört kademesi (15, 5, 3, 2) tek etikete düşüyor → 2.
 *   Hakemlikte dört kademe (3, 2, 1, 1) tek 'Hakemlik' etiketine düşüyor
 *       → 1.
 *   Etkinlik bölümünün otuz satırı (düzenleme kurulu başkanlığı 50'den
 *       mezuniyet töreni görevine 1'e) tek 'Diğer' etiketine düşüyor → 1;
 *       davetli konuşmacılıkta uluslararası (20) ile ulusal (5) → 5.
 *   Ödüllerde Cumhurbaşkanlığı (80), TÜBİTAK Bilim (75), YÖK Üstün Başarı
 *       (75), TÜBİTAK Teşvik (40), GEBİP (30), TESEP (25) ve YÖK Yılın
 *       Doktora Tezi (20) ödülleri etiket bazında ayrıldı; rektörlük
 *       ödülleri (5) sözlükte karşılıksız.
 *   Jüri üyeliklerinde uluslararası (15) ile ulusal kademeler (3, 2, 1)
 *       → 1; sanat ve tasarım jüri üyeliğinde uluslararası (10) ile ulusal
 *       (5) → 5.
 *   Burslarda dört kademe (7, 3, 2, 1) → 1.
 *   Tez danışmanlığında ikinci danışman puanın yarısını aldığı için
 *       doktorada 3, yüksek lisansta 1 girildi.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   3 ve 4. maddeler (tezden üretilmiş makale ve kitaplar) — yukarıda
 *       açıklandı.
 *   16. madde (döner sermaye projesi, tutara göre 1-6 puan) ile 18. madde
 *       (h-index × 1-3) ve 19. madde (yabancı dilde ders verebilme
 *       yeterliliği, 10 puan) — faaliyet değil profil ya da tutar ölçütü.
 *   Doçentlik ölçütlerindeki EBSCO kolu — sözlükte karşılığı yok.
 *   12/ğ (rektörlük tarafından verilen ödül, takdir ve teşekkür belgeleri)
 *       ile 15. maddenin üniversiteye özgü satırları (mezuniyet töreni,
 *       Sürekli Eğitim Merkezi, işbirliği anlaşmaları) 'Diğer' etiketinde
 *       toplandı.
 *   22. maddenin "sergi içeriğinde en az 15 özgün eser barındıran kişisel
 *       sergi" satırları (a ve b) — puan tek esere değil serginin
 *       tamamına veriliyor; ğ ve ı bentlerindeki kişisel sergi satırları
 *       (35 ve 15) girildi.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   Tavanların çoğu "doçentlik öncesi ve sonrası AYRI AYRI dikkate alınır
 *       (25+25, 40+40, 50+50 …)" biçiminde yazılmış; motor tek bir tavan
 *       tanıdığı için tavanlar tek katı uygulanıyor ve bu kalemlerde
 *       puanınız OLDUĞUNDAN DÜŞÜK çıkar.
 *   11. maddenin "patentte puan kişi sayısına bölünür" kuralı: Ek-1'in
 *       yazar sırası tablosu patent satırlarına da uygulanıyor.
 *   17. maddenin "atama dönemini kapsayan her bir yıl için" çarpanı ile
 *       15. maddenin "en fazla 5 etkinlik" gibi adet sınırları.
 *
 * Yönerge: yonerge/zbeu.php
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 */
$TAM = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];
$WOS = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];
$DIGER_INDEKS = ['ESCI / Scopus', 'Diğer Uluslararası İndeks'];

$maddeler = [
    // ══ 1. ULUSLARARASI MAKALE ══
    '1.a.q1' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q1 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $TAM, 'puan' => 90],
    '1.a.q2' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q2 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $TAM, 'puan' => 60],
    '1.a.q3' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q3 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $TAM, 'puan' => 30],
    '1.a.q4' => ['baslik' => 'SCIE veya SSCI kapsamındaki Q4 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $TAM, 'puan' => 25],
    '1.b' => ['baslik' => 'AHCI kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => $TAM, 'puan' => 60],
    '1.c' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $TAM, 'puan' => 20],
    '1.ç' => ['baslik' => 'Diğer uluslararası indekslerde taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $TAM, 'puan' => 15],
    '1.d' => ['baslik' => 'SCIE, SSCI veya AHCI dergilerinde editöre mektup, araştırma notu, özet, vaka takdimi, teknik not ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $KISA, 'puan' => 10],
    '1.e' => ['baslik' => 'ESCI, Scopus ya da diğer uluslararası indeks dergilerinde editöre mektup, araştırma notu, özet, vaka takdimi, teknik not ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => $DIGER_INDEKS, 'turler' => $KISA, 'puan' => 5],

    // ══ 2. ULUSAL MAKALE ══
    '2.a' => ['baslik' => 'TR Dizin kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TAM, 'puan' => 15],
    '2.b' => ['baslik' => 'Diğer hakemli dergilerde makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => 5],
    '2.c' => ['baslik' => 'Diğer hakemli dergilerde editöre mektup, araştırma notu, özet, vaka takdimi, teknik not ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 2],

    // ══ 5. KİTAPLAR ══
    '5.a' => ['baslik' => 'BKCI kapsamındaki kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 50],
    '5.c' => ['baslik' => 'BKCI veya Scopus kapsamındaki kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 35],
    '5.d' => ['baslik' => 'Diğer uluslararası ya da ulusal kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı', 'Çeviri Kitap'], 'puan' => 25],
    '5.e' => ['baslik' => 'Diğer uluslararası ya da ulusal kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi', 'Çeviri Kitap Bölümü'], 'puan' => 10],

    // ══ 6. ATIFLAR ══
    // Sözlük 16.09.2026'da atıfta ESCI'yi çekirdek indeksten ayırdı.
    '6.a' => ['baslik' => 'SCIE, SSCI veya AHCI kapsamında eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 3],
    '6.b' => ['baslik' => 'ESCI veya Scopus kapsamında eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 2],
    '6.c' => ['baslik' => 'BKCI kapsamındaki kitapta eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
    '6.ç' => ['baslik' => 'TR Dizin kapsamındaki dergide eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 1],
    '6.d' => ['baslik' => 'Diğer uluslararası ya da ulusal kitap veya dergide eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],

    // ══ 7. TEZ DANIŞMANLIĞI ══
    '7.a' => ['baslik' => 'Tamamlanmış doktora, uzmanlık ya da sanatta yeterlik tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 3],
    '7.b' => ['baslik' => 'Tamamlanmış yüksek lisans tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 1],

    // ══ 8. BİLİMSEL ARAŞTIRMA PROJELERİ ══
    '8.a' => ['baslik' => 'AB Çerçeve Programı projesinde yürütücülük, koordinatörlük ya da baş araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 75],
    '8.b' => ['baslik' => 'AB Çerçeve Programı projesinde araştırmacılık ya da danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 30],
    '8.c' => ['baslik' => 'TÜBİTAK ya da TÜSEB Ar-Ge projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 20],
    '8.ç' => ['baslik' => 'TÜBİTAK ya da TÜSEB Ar-Ge projesinde araştırmacılık veya danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 5],
    '8.f' => ['baslik' => 'TÜBİTAK öğrenci projelerinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'puan' => 3],
    '8.g' => ['baslik' => 'Diğer uluslararası destekli bilimsel araştırma projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'puan' => 7],
    '8.ğ' => ['baslik' => 'Üniversite dışındaki ulusal kamu kurumlarıyla ve sanayi kuruluşlarıyla yapılan projelerde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'puan' => 3],
    '8.h' => ['baslik' => 'Üniversite bilimsel araştırma projesinde (BAP) yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 3],
    '8.ı' => ['baslik' => 'Üniversite bilimsel araştırma projesinde (BAP) araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 1],

    // ══ 9. BİLİMSEL TOPLANTI ══
    '9.a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan ve CPCI\'da yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 8],
    '9.b' => ['baslik' => 'Diğer uluslararası bilimsel toplantıda sunulan ve yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Uluslararası Özet/Poster'], 'puan' => 5],
    '9.c' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan ve yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin', 'Ulusal Özet/Poster'], 'puan' => 2],
    '15.ç' => ['baslik' => 'Kongrelerde davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 5],

    // ══ 10. EĞİTİM-ÖĞRETİM ══
    '10.a' => ['baslik' => 'Önlisans dersi vermiş olmak', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders'], 'puan' => 1],
    '10.c' => ['baslik' => 'Lisansüstü ders vermiş olmak', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 3],

    // ══ 11. PATENT / FAYDALI MODEL ══
    '11.a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 75],
    '11.b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 40],
    '11.c' => ['baslik' => 'Tescil edilmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Yazılım'], 'puan' => 20],
    '11.ç' => ['baslik' => 'Endüstriyel tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım'], 'puan' => 10],
    '11.d' => ['baslik' => 'Teknoloji geliştirme bölgelerinde şirket sahibi olmak', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 5],

    // ══ 12. ÖDÜL ══
    '12.b' => ['baslik' => 'TÜBİTAK bilim ödülü, YÖK üstün başarı ödülü ya da Cumhurbaşkanlığı ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'YÖK Ödülü'], 'puan' => 20],
    '12.d' => ['baslik' => 'TÜBA GEBİP ya da TESEP ödülü, TÜBİTAK teşvik ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 25],
    '12.g' => ['baslik' => 'Uluslararası jürili sanat ve tasarım etkinliklerinde ya da yarışmalarda alınan derece ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ulusal Bilim/Sanat Ödülü', 'Yarışma Derecesi / Mansiyon', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 10],

    // ══ 13. EDİTÖRLÜK ══
    '13.a' => ['baslik' => 'SCIE, SSCI, AHCI veya ESCI kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI Dergi'], 'puan' => 50],
    '13.f' => ['baslik' => 'TR Dizin kapsamındaki ya da diğer uluslararası indekslerde taranan dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi (Uluslararası)', 'Scopus Dergi'], 'puan' => 10],
    '13.ğ' => ['baslik' => 'Dergilerde yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 2],
    '13.j' => ['baslik' => 'BKCI veya Scopus kapsamındaki kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 10],
    '13.l' => ['baslik' => 'Uluslararası ya da ulusal yayınevi kitabında editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 3],
    '14.a' => ['baslik' => 'Hakemli dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 1],

    // ══ 15. ETKİNLİK ══
    '15.a' => ['baslik' => 'Bilimsel ve sanatsal kongre, sergi, konser ve etkinliklerin düzenleme ya da bilim kurullarında görev almak; oturum başkanlığı, seminer, değişim ve iş birliği faaliyetleri', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 1],
    // Kaynak 15/a uluslararası düzenleme kurulu başkanlığı 50 · 15/d ULUSAL 20 · 15/b-c uluslararası kurul üyeliği 15/10 → 10 · 15/e-f ULUSAL 5/2 → 2 diyor.
    '15.a-bsk-u' => ['baslik' => 'Uluslararası bilimsel ya da sanatsal toplantı düzenleme kurulu başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Uluslararası)'], 'puan' => 50],
    '15.a-bsk-n' => ['baslik' => 'Ulusal bilimsel ya da sanatsal toplantı düzenleme kurulu başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Toplantı Düzenleme Başkanlığı (Ulusal)'], 'puan' => 20],
    '15.a-kur-u' => ['baslik' => 'Uluslararası bilimsel ya da sanatsal toplantı düzenleme ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'], 'puan' => 10],
    '15.a-kur-n' => ['baslik' => 'Ulusal bilimsel ya da sanatsal toplantı düzenleme ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 2],
    // Kaynak 15/c uluslararası kongrede bilim kurulu üyeliği veya oturum başkanlığı 10, 15/f ULUSAL kongrede 2 diyor.
    '15.a-otr' => ['baslik' => 'Uluslararası bilimsel ya da sanatsal toplantıda oturum başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Uluslararası)'], 'puan' => 10],
    '15.a-otr-ulusal' => ['baslik' => 'Ulusal bilimsel ya da sanatsal toplantıda oturum başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Oturum Başkanlığı (Ulusal)'], 'puan' => 2],
    '15.u' => ['baslik' => 'Topluma yönelik akademik ve sosyal sorumluluk çalışmalarında yer almak; bakanlık ve kamu kurumlarının bilim komisyonlarında görev almak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın', 'Kamu/STK Danışmanlığı'], 'puan' => 1],

    // ══ 17. BİRİM YÖNETİCİLİĞİ ══
    '17.a' => ['baslik' => 'Anabilim dalı başkanlığı ya da rektörlüğe bağlı koordinatörlükte görev (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 1],
    '17.b' => ['baslik' => 'Bölüm başkanlığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 5],
    '17.c' => ['baslik' => 'Bölüm başkan yardımcılığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı'], 'puan' => 2],
    '17.ı' => ['baslik' => 'Dekanlık, enstitü, yüksekokul ya da meslek yüksekokulu müdürlüğü, başhekimlik (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü'], 'puan' => 7],
    '17.i' => ['baslik' => 'Dekan yardımcılığı, enstitü ve yüksekokul müdür yardımcılığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 3],
    '17.j' => ['baslik' => 'Rektörlük ya da rektör yardımcılığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı'], 'puan' => 20],
    '17.l' => ['baslik' => 'Senato ve üniversite yönetim kurulu üyeliği ile komisyon ve kurul görevleri (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 1],
    '17.m' => ['baslik' => 'Merkez müdürlüğü (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 4],

    // ══ 20. BİLİMSEL AMAÇLI BURSLAR ══
    '20.ç' => ['baslik' => 'Bilimsel amaçlı burs', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 1],

    // ══ 21. JÜRİ ÜYELİKLERİ ══
    '21.a' => ['baslik' => 'Tez, atama ve unvan jürilerinde üyelik', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 1],
    '21.s' => ['baslik' => 'Sanat ve tasarım alanında jüri üyeliği ya da küratörlük', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 5],

    // ══ 22. SANATSAL ETKİNLİKLER ══
    '22.ğ' => ['baslik' => 'Özgün sanat eseri, tasarım ya da yorum çalışmalarıyla uluslararası kişisel sergi açmak; uluslararası resital, konser ve solistlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Elektronik Kişisel Sergi (Uluslararası)', 'Resital (Uluslararası)', 'Şan Resitali (Uluslararası)', 'Solistlik (Uluslararası)', 'Oratoryo/Kantat Solistliği (Uluslararası)', 'Opera Birinci Rol (Uluslararası)', 'Bale Başrol (Uluslararası)'], 'puan' => 30],
    '22.ı' => ['baslik' => 'Özgün sanat eseri, tasarım ya da yorum çalışmalarıyla ulusal kişisel sergi açmak; ulusal resital, konser ve solistlik', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Kişisel Sergi (Ulusal)', 'Resital (Ulusal)', 'Şan Resitali (Ulusal)', 'Solistlik (Ulusal)', 'Oratoryo/Kantat Solistliği (Ulusal)', 'Opera Birinci Rol (Ulusal)', 'Bale Başrol (Ulusal)'], 'puan' => 15],
    '22.c' => ['baslik' => 'Uluslararası sergi, çalıştay, bienal, defile, gösteri, performans ya da festival türündeki karma etkinlikte eseriyle yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Elektronik Karma Sergi (Uluslararası)', 'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Oda Müziği Grup Üyeliği (Uluslararası)', 'Başkemancılık (Uluslararası)'], 'puan' => 20],
    '22.ç' => ['baslik' => 'Ulusal sergi, çalıştay, bienal, defile, gösteri, performans ya da festival türündeki karma etkinlikte eseriyle yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)', 'Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Ulusal)', 'Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Oda Müziği Grup Üyeliği (Ulusal)', 'Başkemancılık (Ulusal)', 'Orkestra / Koro Üyeliği', 'Corps de Ballet (Uluslararası)', 'Corps de Ballet (Ulusal)', 'Dansçı / Performans İcracısı (Uluslararası)', 'Dansçı / Performans İcracısı (Ulusal)'], 'puan' => 10],
    '22.d' => ['baslik' => 'Resmî ya da özel kurumlarda sanat alanında atölye çalışması yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Masterclass (Uluslararası)', 'Masterclass (Ulusal)', 'Müzikoloji Atölyesi', 'Eğitici Konser Programı (Uluslararası)', 'Eğitici Konser Programı (Ulusal)'], 'puan' => 7],
    '22.e' => ['baslik' => 'Eserinizin kamusal alanda sürekli olarak sergilenmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Haber Olması (Uluslararası)', 'Eserin Haber Olması (Ulusal)'], 'puan' => 15],
    '22.f' => ['baslik' => 'Kamu kurumları ve tüzel kişiler bünyesinde uygulanan tasarımı olmak; uygulama ve koruma-onarım projelerinde yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman', 'Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)'], 'puan' => 10],
    '22.m.b' => ['baslik' => 'Solo çalgı, oda müziği, orkestra, sahne müziği, vokal topluluğu ya da elektronik müzik türlerinde özgün eser sunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Özgün Eser / Beste / Tasarım', 'Opera/Bale Kompozisyonu', 'Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir', 'Orkestralı Sahne Eseri', 'Küçük Ölçekli Orkestra Eseri', 'Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)', 'Sahne/Ekran Müziği', 'Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi', 'Koreografi'], 'puan' => 25],
    '22.m.ç' => ['baslik' => 'Bandrollü ya da dijital yayımlanmış solo albüm', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bandrollü Kayıt (CD/DVD)', 'Albüm / Konser Kaydı'], 'puan' => 30],
    '22.m.d' => ['baslik' => 'Karma icra olarak dijital yayımlanmış albüm', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Albüm / CD-DVD Katkısı', 'Eğitim Müziği Albümü'], 'puan' => 15],
    '22.m.s' => ['baslik' => 'Sahne, televizyon, radyo ve sinema yapıtlarında yönetmenlik, rejisörlük ya da tasarım', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Yönetmenlik (Sahne/Ekran)', 'Rejisörlük (Uluslararası)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)', 'Rejisör Yardımcılığı (Uluslararası)', 'Rejisör Yardımcılığı (Ulusal)', 'Rejisör Yardımcılığı (Konservatuvar)', 'Sahne Tasarımı (Dekor, Kostüm, Işık)', 'Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)', 'Orkestra Şefliği (Uluslararası)', 'Orkestra Şefliği (Ulusal)', 'Koro Şefliği (Uluslararası)', 'Koro Şefliği (Ulusal)', 'Opera Şefliği (Uluslararası)', 'Opera Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Ulusal)', 'Grup Şefliği (Uluslararası)', 'Grup Şefliği (Ulusal)', 'Bale/Dans Koreograflığı (Uluslararası)', 'Bale/Dans Koreograflığı (Ulusal)', 'Tüm Perde Koreograflığı (Uluslararası)', 'Tüm Perde Koreograflığı (Ulusal)', 'Bölüm Koreograflığı (Uluslararası)', 'Bölüm Koreograflığı (Ulusal)', 'Opera İkinci Rol (Uluslararası)', 'Opera İkinci Rol (Ulusal)', 'Bale Solist Rol (Uluslararası)', 'Bale Solist Rol (Ulusal)'], 'puan' => 15],
    '22.l' => ['baslik' => 'Spor federasyonunun yönetim, teknik, eğitim ya da hakem kurulunda görev', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Spor Federasyonu Kurul Üyeliği (Uluslararası)'], 'puan' => 15],
    '22.l-ulusal' => ['baslik' => 'Spor federasyonunun yönetim, teknik, eğitim ya da hakem kurulunda görev', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Spor Federasyonu Kurul Üyeliği (Ulusal)'], 'puan' => 15],
];

$MAKALE_1 = ['1.a.q1', '1.a.q2', '1.a.q3', '1.a.q4', '1.b', '1.c', '1.ç'];

return [
    'kapsam_notu' => 'Puanlar Zonguldak Bülent Ecevit Üniversitesi Öğretim Üyeliğine '
        .'Yükseltilme ve Atanma Ölçütleri Yönergesinin Ek-2 tablosundan (24.10.2024 YÖK Genel '
        .'Kurulu; 01.01.2026\'da yürürlükte). Ortak yayınlarda Ek-1 tablosu uygulanıyor: iki '
        .'yazarlıda %90 ve %80; üç yazarlıda %80, %70, %60; dört yazarlıda %70\'ten %40\'a; beş '
        .'yazarlıda %60\'tan %20\'ye; altı ve daha fazla yazarlıda birinci yazar %50, diğer her '
        .'yazar %20 alıyor. Yazar listesini boş bırakırsanız oran uygulanmaz ve puanınız '
        .'olduğundan yüksek görünür. Kitaplardan en fazla 120, atıflardan 40, tez '
        .'danışmanlığından 25, bilimsel toplantıdan 25, eğitim-öğretimden 25, patentten 75, '
        .'ödülden 80, editörlükten 50, hakemlikten 15, etkinlikten 50, birim yöneticiliğinden '
        .'50, burstan 7, jüri üyeliğinden 15 ve sanatsal etkinlikten 150 puan alınabiliyor. '
        .'Yönerge bu tavanların "doçentlik öncesi ve sonrası AYRI AYRI" uygulanacağını söylüyor '
        .'(25+25, 40+40 gibi); motor tek tavan tanıdığı için tavanlar tek katı uygulanıyor ve bu '
        .'kalemlerde puanınız OLDUĞUNDAN DÜŞÜK çıkar. Puanınız ayrıca şu kalemlerde düşük '
        .'görünür: 16. madde (döner sermaye projesi), 18. madde (h-index) ve 19. madde (yabancı '
        .'dilde ders verebilme yeterliliği) faaliyet değil profil ya da tutar ölçütü olduğu için '
        .'girilemedi; hakemlik, yayın kurulu üyeliği, etkinlik görevleri, jüri üyelikleri ve '
        .'burslar aynı etikete düştüğü için en düşük değerden sayılıyor; 22. maddenin "en az 15 '
        .'özgün eser barındıran kişisel sergi" satırları puanı serginin tamamına verdiği için '
        .'yazılmadı. Puanınız şu kalemde OLDUĞUNDAN YÜKSEK görünür: lisansüstü tezinizden '
        .'ürettiğiniz yayınlar için Ek-2\'nin 3 ve 4. maddelerindeki ayrı tavanlar uygulanmıyor '
        .'(puan değerleri zaten aynı).',

    // Ek-1: Yayınlarda birden fazla kişi bulunması durumunda puanlama
    // dağılımı tablosu.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'editorluk', 'proje', 'tez_danismanligi', 'tez_yayini',
            'egitim_ogretim', 'idari_gorev', 'toplumsal_katki', 'odul', 'diger'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.80, 4 => 0.70, 5 => 0.60], 'sonrasi' => 0.50],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.80, 4 => 0.70, 5 => 0.60], 'sonrasi' => 0.50],
            'yazar_2' => ['kademeler' => [2 => 0.80, 3 => 0.70, 4 => 0.60, 5 => 0.50], 'sonrasi' => 0.20],
            'yazar_3' => ['kademeler' => [3 => 0.60, 4 => 0.50, 5 => 0.40], 'sonrasi' => 0.20],
            'yazar_4' => ['kademeler' => [4 => 0.40, 5 => 0.30], 'sonrasi' => 0.20],
            'ortak' => ['sonrasi' => 0.20],
        ],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        'TOPLAM' => array_keys($maddeler),
        // Madde 9, 10, 11 ve 12'nin atıf yaptığı makale kümeleri.
        '1.A' => ['1.a.q1', '1.a.q2', '1.a.q3', '1.a.q4'],
        '1.A-Q123' => ['1.a.q1', '1.a.q2', '1.a.q3'],
        '1.A-Q123-AHCI' => ['1.a.q1', '1.a.q2', '1.a.q3', '1.b'],
        '1.A-Ç' => $MAKALE_1,
        '1.A-B' => ['1.a.q1', '1.a.q2', '1.a.q3', '1.a.q4', '1.b'],
        '2.A' => ['2.a'],
        '2.A-B' => ['2.a', '2.b'],
        '2.A-1.A-Ç' => [...$MAKALE_1, '2.a'],
        'SCOPUS' => ['1.c'],
        // Madde 11/2 ve 12/3'ün proje koşulu.
        'PROJE-YURUTUCU' => ['8.a', '8.c', '8.h'],
        'PROJE-ARASTIRMACI' => ['8.b', '8.ç', '8.g', '8.ğ', '8.ı'],
        // Tavan grupları.
        'KITAP' => ['5.a', '5.c', '5.d', '5.e'],
        'ATIF' => ['6.a', '6.c', '6.ç', '6.d'],
        'TEZ' => ['7.a', '7.b'],
        'BILDIRI' => ['9.a', '9.b', '9.c', '15.ç'],
        'DERS' => ['10.a', '10.c'],
        'PATENT' => ['11.a', '11.b', '11.c', '11.ç', '11.d'],
        'ODUL' => ['12.b', '12.d', '12.g'],
        'EDITORLUK' => ['13.a', '13.f', '13.ğ', '13.j', '13.l'],
        'HAKEMLIK' => ['14.a'],
        'ETKINLIK' => ['15.a', '15.u'],
        'YONETICILIK' => ['17.a', '17.b', '17.c', '17.ı', '17.i', '17.j', '17.l', '17.m'],
        'BURS' => ['20.ç'],
        'JURI' => ['21.a', '21.s'],
        'SANAT' => ['22.ğ', '22.ı', '22.c', '22.ç', '22.d', '22.e', '22.f',
            '22.m.b', '22.m.ç', '22.m.d', '22.m.s'],
    ],

    'grup_tavanlari' => [
        'KITAP' => 120,
        'ATIF' => 40,
        'TEZ' => 25,
        'BILDIRI' => 25,
        'DERS' => 25,
        'PATENT' => 75,
        'ODUL' => 80,
        'EDITORLUK' => 50,
        'HAKEMLIK' => 15,
        'ETKINLIK' => 50,
        'YONETICILIK' => 50,
        'BURS' => 7,
        'JURI' => 15,
        'SANAT' => 150,
    ],
];
