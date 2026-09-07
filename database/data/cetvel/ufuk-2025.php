<?php

/**
 * UFUK ÜNİVERSİTESİ — Ek-2 Referans Puan Tablosu
 * Kaynak: pdf/17634009071.Ufuk Üniversitesi Kriter.pdf
 * (Senato 03.01.2025; YÖK Genel Kurulu 30.04.2025)
 *
 * Madde kodları Ek-2'nin kendi numaralarını izliyor (1.a, 9.c …).
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   "Davetli derleme" (uluslararası 15, ulusal 5) ile normal derleme,
 *       teknik rapor, editöre mektup ve vaka sunumu satırları (5, 3, 2)
 *       kayıtta ayrışmıyor → uluslararası indekslerde 5 ve 3, TR Dizin'de
 *       2, diğer ulusal dergilerde 2.
 *   Kitaplarda Sense Ranking of Academic Publishers A-E kategorileri
 *       kayıtta yok; uluslararası kitap yazarlığında en düşük kategori
 *       (D-E, 50), editörlükte 30, bölüm yazarlığında 8 girildi.
 *   Tez danışmanlığında danışmanlık (4) ile ikinci danışmanlık (2)
 *       ayrışmıyor → doktorada 2, yüksek lisansta zaten 2.
 *   Dergi görevlerinde yayın kurulu üyeliği ve hakemlik dört kademeye
 *       yayılıyor (8, 4, 2, 1) → yayın kurulu üyeliği 2, hakemlik 1;
 *       WoS-Scopus dışı dergilerde editörlük 3.
 *   Bilimsel etkinliklerde düzenleme kurulu başkanlığı ve üyeliği ile
 *       oturum başkanlığı (5'ten 1'e) tek 'Diğer' etiketine düşüyor → 1;
 *       davetli konuşmacılıkta uluslararası (5) ile ulusal (3) → 3.
 *   Ödüllerde kongre ödülleri (5 ve 3) → 3; burslarda uluslararası (15)
 *       ile ulusal (10) → 10; YÖK ödüllerinin dört kademesi (15-6) → 6.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   7. MADDENİN TAMAMI (atıflar): puan atıf sayısının 0,5 ve 0,3 katı
 *       olarak veriliyor; motor tam sayı taşıdığı için bu satırlar
 *       girilemedi. ATIFLARINIZ TOPLAM PUANA HİÇ KATKI VERMİYOR.
 *   11. maddenin a-f bentleri (ders puanı dönemlik ders SAATİ ile
 *       çarpılıyor, katsayılar 0,025-0,15) — kayıt ders saatini taşımıyor.
 *   4. MADDENİN TAMAMI (lisansüstü tezlerden üretilen yayınlar) — faaliyet
 *       kaydı yayının tez kökenli olup olmadığını taşımıyor; 1, 2 ve 3.
 *       maddelerle birlikte yazmak aynı yayını iki kez saydırırdı.
 *       Tezinizden ürettiğiniz yayınlar tam satırlardan puanlanıyor ve
 *       toplamınız olduğundan YÜKSEK çıkar.
 *   1 ve 2. maddelerin "h-indeksi 5 ve üzerindeyse h × 0,1 puan eklenir"
 *       kuralı ile 14/a (yabancı dil sınav başarısı), 14/c (etki faktörü 5
 *       üzeri dergi ya da WoS Q1 yayını — 1. maddeyle çakıştığı için),
 *       14/e-f (yeterlilik sertifikaları), 14/g (yeni birim kurulmasında
 *       çalışmak), 14/m (yurt dışında üç ay) ve 14/o (atama jürisi
 *       üyeliği) satırları.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   Yayın ve kitap satırlarında iki ayrı ortak yazar kuralı var: yayınlarda
 *       iki yazarlı eserde ilk yazar %80, ikinci %50; kitaplarda iki
 *       yazarlı eserde HER yazar %80, ikiden çok yazarlıda her yazar %50.
 *       Motorda kategori bazlı ayrı çarpan tanımlanamadığı için §0 gereği
 *       düşük olan yayın kuralı her ikisine uygulandı; çok yazarlı
 *       kitaplarda puanınız olduğundan DÜŞÜK çıkar.
 *   8. maddenin "devam eden tezler için tamamlanmış tez danışmanlığının
 *       %50'si" kuralı ile 12/g'nin "yılda ikiden fazla puanlandırılamaz"
 *       ve 14/h-l'nin "her akademik yıl için" çarpanları.
 *
 * Yönerge: yonerge/ufuk.php
 *
 * 06.09.2026: bilimsel toplantı organizasyonu ailesi için altı etiket
 * açıldı (başkanlık · düzenleme/bilim kurulu üyeliği · oturum başkanlığı,
 * her biri uluslararası/ulusal). Yukarıdaki "sözlükte karşılıksız" notları
 * bu satırlar için artık geçerli değil.
 */
$OZGUN = ['ozgun_makale'];
$DIGER_TUR = ['derleme', 'kisa_makale', 'vaka_teknik_not'];
$WOS = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];
$ULUSLARARASI_INDEKS = ['ESCI / Scopus', 'Diğer Uluslararası İndeks'];
$AB_PROJE = ['AB Çerçeve / Ufuk'];
$ULUSLARARASI_PROJE = ['Diğer Uluslararası Fon'];
$KAMU_PROJE = ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'];
$BAP_PROJE = ['BAP (Üniversite)', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'];

$maddeler = [
    // ══ 1. ULUSLARARASI YAYINLAR ══
    '1.a' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI\'de yayımlanmış özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $OZGUN, 'puan' => 20],
    '1.c' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI\'de yayımlanmış derleme, teknik rapor, editöre mektup, vaka sunumu ya da kitap değerlendirmesi', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $DIGER_TUR, 'puan' => 5],
    '1.d' => ['baslik' => 'Diğer uluslararası indekslerde taranan hakemli dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => $ULUSLARARASI_INDEKS, 'turler' => $OZGUN, 'puan' => 12],
    '1.f' => ['baslik' => 'Diğer uluslararası indekslerde taranan hakemli dergide derleme, teknik rapor, editöre mektup, vaka sunumu ya da kitap değerlendirmesi', 'kategori' => 'makale', 'kaynaklar' => $ULUSLARARASI_INDEKS, 'turler' => $DIGER_TUR, 'puan' => 3],

    // ══ 2. ULUSAL YAYINLAR ══
    '2.a' => ['baslik' => 'ULAKBİM (TR Dizin) tarafından taranan dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $OZGUN, 'puan' => 10],
    '2.c' => ['baslik' => 'ULAKBİM tarafından taranan dergide derleme, teknik rapor, editöre mektup, vaka sunumu ya da kitap değerlendirmesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $DIGER_TUR, 'puan' => 2],
    '2.d' => ['baslik' => 'Diğer ulusal hakemli dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $OZGUN, 'puan' => 5],
    '2.e' => ['baslik' => 'Diğer ulusal hakemli dergide davetli derleme ya da benzeri yazı', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $DIGER_TUR, 'puan' => 2],

    // ══ 3. KONGRE SUNUM VE BİLDİRİLERİ ══
    '3.a' => ['baslik' => 'Uluslararası kongrede sunulan, tam ya da özet metni basılan sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 3],
    '3.b' => ['baslik' => 'Uluslararası kongrede sunulan poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 2],
    '3.c' => ['baslik' => 'Ulusal kongrede sunulan, tam ya da özet metni basılan sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 2],
    '3.d' => ['baslik' => 'Ulusal kongrede sunulan poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 1],

    // ══ 5. KİTAP ══
    '5.c' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 50],
    '5.f' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitap editörlüğü ya da editör yardımcılığı', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 30],
    '5.i' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 8],
    '5.j' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış ansiklopedide madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 5],
    '5.k' => ['baslik' => 'Tanınmış ulusal yayınevi tarafından yayımlanmış kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı'], 'puan' => 25],
    '5.l' => ['baslik' => 'Tanınmış ulusal yayınevi tarafından yayımlanmış kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 15],
    '5.m' => ['baslik' => 'Tanınmış ulusal yayınevi tarafından yayımlanmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 8],
    '5.n' => ['baslik' => 'Tanınmış yayınevi tarafından yayımlanmış bilimsel kitap çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 10],
    '5.p' => ['baslik' => 'Tanınmış yayınevi tarafından yayımlanmış bilimsel kitapta bölüm çevirmenliği', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 5],

    // ══ 6. PATENT ══
    '6.a' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 45],
    '6.b' => ['baslik' => 'Ulusal patent, faydalı model ya da tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili', 'Ticarileştirme'], 'puan' => 25],

    // ══ 8. LİSANSÜSTÜ TEZ DANIŞMANLIĞI ══
    '8.a' => ['baslik' => 'Tamamlanmış doktora ya da tıpta uzmanlık tezinde danışmanlık veya ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 2],
    '8.c' => ['baslik' => 'Tamamlanmış yüksek lisans tezinde danışmanlık ya da eş danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'puan' => 2],

    // ══ 9. ARAŞTIRMA PROJELERİ ══
    '9.a' => ['baslik' => 'Tamamlanmış AB Çerçeve Programı projesinde koordinatörlük, baş araştırmacılık ya da yürütücülük', 'kategori' => 'proje', 'kaynaklar' => $AB_PROJE, 'roller' => ['yurutucu'], 'puan' => 40],
    '9.b' => ['baslik' => 'Tamamlanmış AB Çerçeve Programı projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => $AB_PROJE, 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
    '9.c' => ['baslik' => 'Tamamlanmış diğer uluslararası araştırma projesinde koordinatörlük, baş araştırmacılık ya da yürütücülük', 'kategori' => 'proje', 'kaynaklar' => $ULUSLARARASI_PROJE, 'roller' => ['yurutucu'], 'puan' => 30],
    '9.d' => ['baslik' => 'Tamamlanmış diğer uluslararası araştırma projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => $ULUSLARARASI_PROJE, 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],
    '9.e' => ['baslik' => 'Üniversite dışı kamu kurumlarıyla gerçekleştirilen tamamlanmış projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => $KAMU_PROJE, 'roller' => ['yurutucu'], 'puan' => 20],
    '9.f' => ['baslik' => 'Üniversite dışı kamu kurumlarıyla gerçekleştirilen tamamlanmış projede görev almak', 'kategori' => 'proje', 'kaynaklar' => $KAMU_PROJE, 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
    '9.g' => ['baslik' => 'Tamamlanmış üniversite bilimsel araştırma projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => $BAP_PROJE, 'roller' => ['yurutucu'], 'puan' => 15],
    '9.h' => ['baslik' => 'Tamamlanmış üniversite bilimsel araştırma projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => $BAP_PROJE, 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 8],

    // ══ 10. BİLİMSEL ETKİNLİKLERDE GÖREV ALMA ══
    '10.g' => ['baslik' => 'Toplantılarda davetli konuşmacı olarak sunum yapmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 3],
    '10.a' => ['baslik' => 'Kongre, kurs ve çalıştaylarda bilimsel düzenleme kurulu başkanlığı, üyeliği ya da oturum başkanlığı', 'kategori' => 'diger', 'kaynaklar' => ['Diğer', 'Toplantı Düzenleme Başkanlığı (Uluslararası)', 'Toplantı Düzenleme Başkanlığı (Ulusal)', 'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)', 'Oturum Başkanlığı (Uluslararası)', 'Oturum Başkanlığı (Ulusal)'], 'puan' => 1],
    '10.l' => ['baslik' => 'Jürili yarışmalarda danışmanlık ya da jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 4],

    // ══ 11. EĞİTİM-ÖĞRETİM FAALİYETLERİ ══
    '11.h' => ['baslik' => 'Sertifikalı bir kursta eğitici olarak katılmak; üniversitenin onayladığı programlarda eğiticilik', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Akreditasyon Faaliyeti'], 'puan' => 2],
    '11.j' => ['baslik' => 'Eğitim-öğretimle ilgili komisyon, kurul ve komitelerde görev almak; koordinatörlük ve ders kurulu sorumluluğu', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 1],

    // ══ 12. DERGİ GÖREVLERİ ══
    '12.a' => ['baslik' => 'WoS, Scopus ya da Sobiad dergilerinde editörlük veya editör yardımcılığı', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 10],
    '12.c' => ['baslik' => 'Diğer uluslararası dergilerde ya da ULAKBİM tarafından taranan dergilerde editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 3],
    '12.d' => ['baslik' => 'Dergilerde yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 2],
    '12.g' => ['baslik' => 'Hakemli dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 1],

    // ══ 13. ÖDÜLLER VE BURSLAR ══
    '13.a' => ['baslik' => 'Uluslararası tanınırlığı olan bilim kurullarınca verilen bilim, teşvik ya da araştırma ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 10],
    '13.b' => ['baslik' => 'TÜBİTAK, TÜBA gibi ulusal bilim kurullarınca verilen bilim, teşvik ya da araştırma ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 8],
    '13.d' => ['baslik' => 'Kongrelerde derneklerce bilimsel araştırma ve sunumlara verilen ödül', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 3],
    '13.f' => ['baslik' => 'Alanında bilimsel araştırma ve çalışmalar için burs almak', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 10],
    '13.j' => ['baslik' => 'YÖK topluma hizmet, uluslararası iş birliği, üniversite-sanayi iş birliği ya da yerel kalkınmaya katkı ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü'], 'puan' => 6],

    // ══ 14. DİĞER FAALİYETLER ══
    '14.d' => ['baslik' => 'Üniversite-toplum ya da üniversite-endüstri iş birliği çerçevesinde sosyal sorumluluk projelerinde görev almak; öğrenci topluluklarına danışmanlık', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın', 'Kamu/STK Danışmanlığı'], 'puan' => 2],
    '14.h' => ['baslik' => 'Rektörlük ya da rektör yardımcılığı görevinde bulunmak (akademik yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı'], 'puan' => 6],
    '14.i' => ['baslik' => 'Enstitü müdürlüğü, dekanlık, yüksekokul müdürlüğü, başhekimlik ya da merkez müdürlüğü (akademik yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 5],
    '14.j' => ['baslik' => 'Enstitü, dekanlık, yüksekokul ve merkez müdür yardımcılıkları (akademik yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 3],
    '14.k' => ['baslik' => 'Bölüm başkanlığı, bölüm başkan yardımcılığı ya da anabilim dalı başkanlığı (akademik yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı', 'Bölüm Başkan Yardımcısı'], 'puan' => 2],
    '14.l' => ['baslik' => 'Rektörlük bünyesindeki merkezi komisyon, komite ve kurul üyelikleri', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 2],
];

return [
    'kapsam_notu' => 'Puanlar Ufuk Üniversitesi Öğretim Üyeliğine Yükseltilme ve Atanma '
        .'Yönergesinin Ek-2 Referans Puan Tablosundan (YÖK Genel Kurulu 30.04.2025). Ortak '
        .'yayınlarda yayın kuralı uygulanıyor: tek yazarlı eserde tam puan, iki yazarlıda ilk '
        .'yazar %80 ve ikinci yazar %50, üç ve daha çok yazarlıda ilk yazar %50 alıyor ve kalan '
        .'puanı diğer yazarlar eşit paylaşıyor. Kitaplarda yönerge daha cömert bir kural '
        .'öngörüyor (iki yazarlıda her yazar %80, ikiden çoksa her yazar %50) ama motor kategori '
        .'bazlı ayrı çarpan tanımlayamadığından §0 gereği düşük olan yayın kuralı uygulandı; çok '
        .'yazarlı kitaplarda puanınız olduğundan düşük çıkar. Yazar listesini boş bırakırsanız '
        .'hiçbir çarpan uygulanmaz ve puanınız olduğundan yüksek görünür. Puanınız şu kalemlerde '
        .'OLDUĞUNDAN DÜŞÜK görünür: ATIF SATIRLARININ TAMAMI (puan atıf sayısının 0,5 ve 0,3 '
        .'katı olarak veriliyor, motor tam sayı taşıyor) ve DERS SATIRLARININ TAMAMI (puan '
        .'dönemlik ders saatiyle çarpılıyor) girilemedi; h-indeksi eklentisi, yabancı dil sınav '
        .'başarısı, yeterlilik sertifikaları ve yurt dışı süresi satırları da girilemedi; '
        .'kitaplarda Sense Ranking kategorileri ayrışmadığı için en düşük kategoriden '
        .'sayılıyor; davetli derleme, hakemlik, kurul üyeliği ve ödül kademeleri aynı etikete '
        .'düştüğü için en düşük değerden sayılıyor. Puanınız şu kalemde OLDUĞUNDAN YÜKSEK '
        .'görünür: lisansüstü tezinizden ürettiğiniz yayınlar için 4. maddedeki düşük satırlar '
        .'uygulanamıyor.',

    // Ek-2 dipnotu (*): tek yazar tam puan; iki yazarlı eserde ilk yazar
    // %80, ikinci %50; üç ve daha çok yazarlıda ilk yazar %50, diğerleri
    // kalan puanı eşit paylaşır.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'editorluk', 'proje', 'tez_danismanligi', 'tez_yayini',
            'egitim_ogretim', 'idari_gorev', 'toplumsal_katki', 'odul', 'sanatsal_etkinlik', 'diger'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.80], 'sonrasi' => 0.50],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.80], 'sonrasi' => 0.50],
            'ortak' => ['kademeler' => [2 => 0.50], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
        ],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        'TOPLAM' => array_keys($maddeler),
        // Ek-1'in doktor öğretim üyeliği kriterleri: 1, 2 ve 3. maddeler
        // (4. madde cetvele girilemedi).
        'DR-KRITER' => ['1.a', '1.c', '1.d', '1.f', '2.a', '2.c', '2.d', '2.e',
            '3.a', '3.b', '3.c', '3.d'],
        // Ek-1'in profesörlük kriterleri: "uluslararası indekslere ait
        // maddeler kapsamındaki a-f numaralı dergiler" ve "ulusal yayınlara
        // ait maddeler kapsamındaki dergiler".
        'ULUSLARARASI-YAYIN' => ['1.a', '1.c', '1.d', '1.f'],
        'ULUSAL-YAYIN' => ['2.a', '2.c', '2.d', '2.e'],
    ],

    'grup_tavanlari' => [],
];
