<?php

/**
 * PİRİ REİS ÜNİVERSİTESİ — EK-1 Öğretim Üyeliğine Yükseltilme ve Atanmalarda
 * Kullanılacak Puanlar
 * Kaynak: pdf/17634009071.Piri Reis Üniversitesi Kriter.pdf (25 sayfa;
 *         Senato 16.04.2025 tarih ve 2025/08 sayılı kararı)
 *
 * KAYNAK PDF TARANMIŞ VE EK-1 TABLOSU YAN YATIK BASILMIŞ; 200 dpi görüntüden
 * `tesseract -l tur` ile okundu, dört sütunlu puan bloğu sayfa görüntüleri
 * döndürülüp gözle doğrulandı. 19. SAYFA 180° TERS BASILMIŞ (`sips -r 180`
 * ile çevrildi) — R bölümünün puanları ancak öyle okunabildi.
 *
 * TABLO DÖRT TEMEL ALANA AYRI SÜTUN VERİYOR ama sütunlar neredeyse birebir
 * aynı. Gerçek fark yalnız İKİ YERDE:
 *   1. HUKUK'ta E.1 kapsamı dışındaki uluslararası kitap ve ulusal kitap
 *      satırları dört kat yüksek: kitap yazarlığı 5 yerine 20, bölüm
 *      yazarlığı 3 yerine 10.
 *   2. BÖLÜM TAVANLARI alana ve kadroya göre değişiyor (aşağıda).
 *
 * ALTI CETVEL VARYANTI ÜRETİYOR. Yazar matrisi, satır değerleri ve tavanlar
 * birlikte değiştiği için (alan grubu × kadro) çarpımı gerekti:
 *   piri-reis-2025-fen     · -fen-prof      Mühendislik ve Fen (kademeli matris)
 *   piri-reis-2025-sosyal  · -sosyal-prof   Sosyal (eşit bölüşme)
 *   piri-reis-2025-hukuk   · -hukuk-prof    Hukuk (eşit bölüşme + yüksek kitap)
 *
 * BÖLÜM TAVANLARI (Dr. Öğr. Üyesi ve doçentlik aynı, profesörlük iki katı):
 *   Bildiri (C+D)   10 · 20
 *   Kitap (E+F)     20 · 40 — Hukuk'ta 30 · 60
 *   Atıf (G)        yalnız profesörlükte 20; alt kadrolarda tavan yok
 *   Hakemlik (I)    20 (her kadroda)
 *   Editörlük (J)    4 ·  8
 *   Tez (K)         10 · 20
 *   Ödül (M)        25 · 50
 *   İdari (O)        6 · 12
 *   Proje (P)       30 · 60 — Sosyal ve Hukuk'ta 20 · 40
 *   Diğer (R)       10 · 20
 *
 * İKİ AYRI YAZAR KURALI ÇATIŞIYOR; MADDE 9 SEÇİLDİ. MADDE 4/2 basit bir
 * merdiven veriyor (tek 1,00 · iki yazarlı 0,80 · üç yazarlı 0,60 · dört ve
 * üzeri 0,40); MADDE 9 ise "Puanlama" başlığı altında temel alana göre iki
 * ayrı kural yazıyor. Sonraki ve daha ÖZEL olan MADDE 9 uygulandı; çatışma
 * `kapsam_notu`'nda söyleniyor. MADDE 9'a göre:
 *   Mühendislik ve Fen — MAKALEDE başlıca yazar ayrıcalıklı (iki yazarlıda
 *     0,8; üç ve daha fazlada yarısı, kalan yarıyı diğerleri paylaşır);
 *     "diğer yayınlarda (bildiri, kitap)" eşit bölüşme.
 *   Sosyal ve Hukuk — bütün yayınlarda eşit bölüşme.
 * §1'in Acıbadem istisnası uyarınca cetvelin tek matrisi MAKALE kuralına
 * göre yazıldı: Piri Reis'in bütün alt barajları makale kalemleri üzerine
 * kurulu. Ters yöndeki sapma kitap ve bildiride kalıyor.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR (§0) ──
 *   AHCI dergilerinin Scopus/WoS çeyreği olmadığı için A.1.d'den (Q4, 10) sayılıyor.
 *   C.1.b (genişletilmiş özet 2) ile C.1.c (özet 1) tek "Uluslararası
 *       Özet/Poster" etiketine düşüyor → 1.
 *   E.2.a (E1 dışı uluslararası kitap) ile F.1.a (ulusal kitap) aynı değeri
 *       taşıyor; tek "Uluslararası/Ulusal Kitap" etiketi F.1.a'ya bağlandı.
 *   I.1.a (WoS hakemliği 4) ile I.1.b ve I.2.a (3) tek "Hakemlik" etiketine
 *       düşüyor → 3.
 *   J.1.a (2) ile J.2.a ve J.3.a (1) — WoS ve Scopus dergileri ayrı etiketi
 *       olduğu için 2'den, TR Dizin dergisi 1'den sayılıyor.
 *   K'nin eş danışman yarım puanı ayrı kodlarla girildi (2 ve 1; kesirler
 *       aşağı yuvarlandı).
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   N. EĞİTİME KATKI BÖLÜMÜNÜN TAMAMI: puan derse değil BLOĞA veriliyor
 *       ("dönemlik programlarda DÖRT FARKLI YARIYILDA ders vermiş olmak, 2
 *       puan"). Tek bir ders kaydını 2 puanla ödüllendirmek bloğu dört katına
 *       çıkarırdı; §0 uyarınca satır hiç yazılmadı ve profesörlüğün "dört
 *       dönem ders vermiş olmak" koşulu eşiklerde beyan olarak duruyor.
 *   H. h-indeksi (h × 1), B.2 Piri Reis Üniversitesi dergileri (6),
 *       L.1.d patent BAŞVURUSU (2), R.1.a yurt dışı araştırma (5),
 *       R.1.b-R.1.e toplantı düzenleme ve bilim kurulu üyelikleri (5/4/3/2).
 *   M bölümü YALNIZCA YÖK, TÜBİTAK ve TÜBA ödüllerini sayıyor; başka hiçbir
 *       bilim ya da sanat ödülünün satırı yok.
 *   "Lisansüstü tezlerden üretilmiş yayın" koşulları: tabloda tez yayınına
 *       ayrı satır yok, koşullar eşiklerde `hesaplanamiyor` olarak duruyor.
 *
 * Yönerge: yonerge/piri-reis.php
 */
$TAM = ['ozgun_makale'];
$KISA = ['derleme', 'kisa_makale', 'vaka_teknik_not'];

/**
 * Kitap satırları: Hukuk temel alanında dört kat yüksek.
 *
 * @return array<string, array<string, mixed>>
 */
$kitapSatirlari = fn (int $kitap, int $bolum): array => [
    'F.1.a' => ['baslik' => 'Ulusal ya da E.1 kapsamı dışındaki uluslararası kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => $kitap],
    'F.1.c' => ['baslik' => 'Ulusal ya da E.1 kapsamı dışındaki uluslararası kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => $bolum],
];

$ortak = [
    // ══ A. ULUSLARARASI MAKALE ══
    'A.1.a' => ['baslik' => 'Q1 olarak taranan uluslararası dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $TAM, 'puan' => 30],
    'A.1.b' => ['baslik' => 'Q2 olarak taranan uluslararası dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $TAM, 'puan' => 20],
    'A.1.c' => ['baslik' => 'Q3 olarak taranan uluslararası dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $TAM, 'puan' => 15],
    'A.1.d' => ['baslik' => 'Q4 olarak taranan uluslararası dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => $TAM, 'puan' => 10],
    'A.1.e' => ['baslik' => 'Q puanına sahip uluslararası dergide editöre mektup, araştırma notu, derleme, özet ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => $KISA, 'puan' => 3],
    'A.2.a' => ['baslik' => 'Q puanı olmayan uluslararası hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $TAM, 'puan' => 5],
    'A.2.b' => ['baslik' => 'Q puanı olmayan uluslararası hakemli dergide editöre mektup, araştırma notu, derleme, özet ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 3],

    // ══ B. ULUSAL MAKALE ══
    'B.1' => ['baslik' => 'TR Dizinde taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TAM, 'puan' => 10],
    'B.3' => ['baslik' => 'TR Dizinde olmayan diğer hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => 4],
    'B.4' => ['baslik' => 'Ulusal hakemli dergide editöre mektup, araştırma notu, derleme, özet ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 2],

    // ══ C-D. BİLDİRİLER ══
    'C.1.a' => ['baslik' => 'Hakemli uluslararası bilimsel toplantıda tam metinli bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 5],
    'C.1.c' => ['baslik' => 'Hakemli uluslararası bilimsel toplantıda özet ya da poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 1],
    'D.1.a' => ['baslik' => 'Hakemli ulusal bilimsel toplantıda tam metinli bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 3],
    'D.1.b' => ['baslik' => 'Hakemli ulusal bilimsel toplantıda özet ya da poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 1],

    // ══ E. ULUSLARARASI KİTAP (Scopus ya da BKCI yayınevi) ══
    'E.1.a' => ['baslik' => 'Scopus ya da BKCI kapsamındaki yayınevinden kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
    'E.1.b' => ['baslik' => 'Scopus ya da BKCI kapsamındaki yayınevinden çıkan kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 10],
    'E.1.c' => ['baslik' => 'Scopus ya da BKCI kapsamındaki yayınevinden çıkan kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 1],

    // ══ F. ULUSAL KİTAP (ders notu hariç) — F.1.a ve F.1.c varyanta göre ══
    'F.1.b' => ['baslik' => 'Kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 3],
    'F.1.d' => ['baslik' => 'Kitap içinde bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 2],
    'F.1.e' => ['baslik' => 'Ulusal kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 1],

    // ══ G. ATIF ══
    'G.1.a' => ['baslik' => 'SCIE, SSCI, AHCI, ESCI ya da Scopus kapsamında eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
    'G.1.b' => ['baslik' => 'BKCI kapsamındaki kitapta eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
    'G.1.c' => ['baslik' => 'TR Dizin kapsamındaki dergide eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
    'G.1.d' => ['baslik' => 'Diğer uluslararası ya da ulusal kitap veya dergide eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],

    // ══ I. HAKEMLİK ══
    'I.1.b' => ['baslik' => 'Uluslararası ya da ulusal dergide hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 3],

    // ══ J. EDİTÖRLÜK VE EDİTÖR KURULU ÜYELİĞİ ══
    'J.1.a' => ['baslik' => 'SCIE, SSCI, AHCI, ESCI ya da Scopus kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 2],
    'J.1.b' => ['baslik' => 'Dergi ya da kitapta editör kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 1],
    'J.3.a' => ['baslik' => 'TR Dizin kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 1],

    // ══ K. TEZ YÖNETİMİ ══
    'K.1.a' => ['baslik' => 'Danışman olarak yönetilmiş doktora ya da sanatta yeterlik tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 5],
    'K.1.b' => ['baslik' => 'Danışman olarak yönetilmiş yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 3],
    'K.1.ae' => ['baslik' => 'Eş danışman olarak yönetilmiş doktora ya da sanatta yeterlik tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 2],
    'K.1.be' => ['baslik' => 'Eş danışman olarak yönetilmiş yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 1],

    // ══ L. PATENT VE FAYDALI MODEL ══
    'L.1.a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
    'L.1.b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 10],
    'L.1.c' => ['baslik' => 'Tescil edilmiş faydalı model, endüstriyel tasarım ya da çeşit tescili', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili', 'Yazılım'], 'puan' => 5],

    // ══ M. ÖDÜL ══
    'M.1' => ['baslik' => 'YÖK, TÜBİTAK ya da TÜBA ödülü (Yılın Doktora Tezi, Üstün Başarı, Bilim, Teşvik, GEBİP, TESEP)', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 25],

    // ══ O. İDARİ GÖREVLER VE KOMİSYON ÇALIŞMALARI ══
    'O.1' => ['baslik' => 'İdari görev (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü', 'Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkanı', 'Bölüm Başkan Yardımcısı', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 3],
    'O.2' => ['baslik' => 'Komisyon, yönetim kurulu ya da program yürütme kurulu çalışması (her yıl için)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 1],

    // ══ P. ARAŞTIRMA PROJESİ ══
    'P.1.a' => ['baslik' => 'AB Çerçeve Programı ya da TÜBİTAK projesinde koordinatör veya yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 20],
    'P.1.b' => ['baslik' => 'AB Çerçeve Programı ya da TÜBİTAK projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 10],
    'P.1.c' => ['baslik' => 'AB Çerçeve Programı ya da TÜBİTAK projesinde danışman', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK', 'TÜSEB'], 'roller' => ['danisman'], 'puan' => 5],
    'P.2' => ['baslik' => 'Uluslararası destekli bilimsel araştırma projesinde görev', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'puan' => 10],
    'P.3' => ['baslik' => 'Üniversite dışındaki kamu kurumu ya da özel kuruluşla yapılan Ar-Ge projesinde görev', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'puan' => 5],
    'P.4' => ['baslik' => 'Üniversitedeki BAP ya da teknopark projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 3],

    // ══ R. DİĞER AKADEMİK FAALİYETLER ══
    'R.1.f' => ['baslik' => 'Jürili yarışmalara katılmak, danışmanlık yapmak ya da jüri üyesi olarak görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 2],
    // R.1.f katılmayı da sayıyor ama 'Yarışma Derecesi / Mansiyon' etiketi
    // `odul` kategorisinde; aynı bendin ikinci satırı olmadan yarışmaya
    // katılan aday hiç puan almıyordu.
    'R.1.f-katilim' => ['baslik' => 'Jürili yarışmaya katılmak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 2],
];

$A1 = ['A.1.a', 'A.1.b', 'A.1.c', 'A.1.d'];
$A1ABC = ['A.1.a', 'A.1.b', 'A.1.c'];
$A_TUM = [...$A1, 'A.1.e', 'A.2.a'];              // A (A.2.b hariç)
$B_13 = ['B.1'];                                   // B (B.3 ve B.4 hariç)
$B_3 = ['B.1', 'B.4'];                             // B (B.3 hariç)
$CD = ['C.1.a', 'C.1.c', 'D.1.a', 'D.1.b'];
$E = ['E.1.a', 'E.1.b', 'E.1.c'];
$F = ['F.1.a', 'F.1.b', 'F.1.c', 'F.1.d', 'F.1.e'];
$G = ['G.1.a', 'G.1.b', 'G.1.c', 'G.1.d'];
$J = ['J.1.a', 'J.1.b', 'J.3.a'];
$K = ['K.1.a', 'K.1.b', 'K.1.ae', 'K.1.be'];
$M = ['M.1'];
$O = ['O.1', 'O.2'];
$P = ['P.1.a', 'P.1.b', 'P.1.c', 'P.2', 'P.3', 'P.4'];
$R = ['R.1.f'];

/** MADDE 9/a ve 9/d — Mühendislik ve Fen: makalede başlıca yazar ayrıcalıklı. */
$digerYazar = ['kademeler' => [1 => 1.00], 'bol' => ['pay' => 0.5, 'eksi' => 1]];
$katkiFen = [
    'haric' => ['atif', 'proje', 'patent', 'tez_danismanligi', 'egitim_ogretim', 'editorluk',
        'odul', 'idari_gorev', 'toplumsal_katki', 'diger'],
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.00]],
        'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.80], 'sonrasi' => 0.50],
        'ilk' => $digerYazar,
        'yazar_2' => $digerYazar,
        'yazar_3' => $digerYazar,
        'yazar_4' => $digerYazar,
        'yazar_5' => $digerYazar,
        'yazar_6' => $digerYazar,
        'ortak' => $digerYazar,
    ],
];

/** MADDE 9/b ve 9/c — Sosyal ve Hukuk: bütün yayınlarda eşit bölüşme. */
$esit = ['bol' => ['pay' => 1.0]];
$katkiSosyal = [
    'haric' => $katkiFen['haric'],
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.00]],
        'ilk' => $esit,
        'baslica' => $esit,
        'yazar_2' => $esit,
        'yazar_3' => $esit,
        'yazar_4' => $esit,
        'yazar_5' => $esit,
        'yazar_6' => $esit,
        'ortak' => $esit,
    ],
];

$ortakNot = 'Puanlar Piri Reis Üniversitesi Öğretim Üyeliğine Yükseltilme ve Atanma Ölçütlerine '
    .'İlişkin Senato Esaslarının EK-1 tablosundan (16.04.2025 tarihli 2025/08 sayılı Senato '
    .'kararı). Kaynak PDF taranmış ve tablo yan yatık basılmış; görüntüden OCR ile okundu, puan '
    .'sütunları döndürülüp gözle doğrulandı. '
    .'YAZAR KURALINDA İKİ MADDE ÇATIŞIYOR: MADDE 4/2 basit bir merdiven veriyor (iki yazarlı '
    .'0,80 · üç yazarlı 0,60 · dört ve üzeri 0,40), MADDE 9 ise temel alana göre iki ayrı kural '
    .'yazıyor. Burada sonraki ve daha özel olan MADDE 9 uygulanıyor. '
    .'PUANINIZ ŞU KALEMLERDE OLDUĞUNDAN DÜŞÜK GÖRÜNÜR: EĞİTİME KATKI bölümünün tamamı '
    .'girilemedi — puan derse değil BLOĞA veriliyor ("dört farklı yarıyılda ders vermiş olmak, '
    .'2 puan"), tek bir ders kaydını 2 puanla saymak bloğu dört katına çıkarırdı. h-indeksi, '
    .'Piri Reis Üniversitesi dergilerindeki yayınlar, patent BAŞVURULARI, yurt dışı araştırma '
    .'süresi ile bilimsel toplantı düzenleme ve bilim kurulu üyelikleri de kayıtta karşılıksız '
    .'kaldı. Ödül bölümü YALNIZCA YÖK, TÜBİTAK ve TÜBA ödüllerini sayıyor; başka bilim ya da '
    .'sanat ödüllerinin tabloda satırı yok. Aynı etikete düşen satırlarda düşüğü sayılıyor: '
    .'genişletilmiş özet bildiri özet değerinden (1), WoS hakemliği diğer hakemlikten (3). '
    .'AHCI dergilerinin Scopus/WoS çeyreği olmadığı için Q4 değerinden (10) sayılıyor. '
    .'PUANINIZ ŞU KALEMDE OLDUĞUNDAN YÜKSEK GÖRÜNEBİLİR: Mühendislik ve Fen alanlarında '
    .'yönerge kitap ve bildiride puanı EŞİT bölerken makalede kademeli bölüyor; motor cetvel '
    .'başına tek matris tanımladığı için makale kuralı seçildi (bütün alt barajlar makale '
    .'üzerine kurulu).';

$cetveller = [];

foreach ([
    'fen' => [$katkiFen, 5, 3, 20, 30],
    'sosyal' => [$katkiSosyal, 5, 3, 20, 20],
    'hukuk' => [$katkiSosyal, 20, 10, 30, 20],
] as $alanEk => [$katki, $kitapPuan, $bolumPuan, $kitapTavan, $projeTavan]) {
    $tablo = array_merge($ortak, $kitapSatirlari($kitapPuan, $bolumPuan));

    $gruplar = [
        'TUM' => array_keys($tablo),
        'A1' => $A1,
        'A1-abc' => $A1ABC,
        'A' => $A_TUM,
        'B1' => $B_13,
        'B' => $B_3,
        'A-B' => array_merge($A_TUM, $B_3),
        'CD' => $CD,
        'EF' => array_merge($E, $F),
        'EF-yazarlik' => ['E.1.a', 'F.1.a'],
        'G' => $G,
        'J' => $J,
        'K' => $K,
        'M' => $M,
        'O' => $O,
        'P' => $P,
        'R' => $R,
        'PR' => array_merge($P, $R),
    ];

    foreach ([false, true] as $profesor) {
        $c = $profesor ? 2 : 1;
        $anahtar = "piri-reis-2025-{$alanEk}".($profesor ? '-prof' : '');

        $tavanlar = [
            'CD' => 10 * $c,
            'EF' => $kitapTavan * $c,
            'J' => 4 * $c,
            'K' => 10 * $c,
            'M' => 25 * $c,
            'O' => 6 * $c,
            'P' => $projeTavan * $c,
            'R' => 10 * $c,
        ];

        // Hakemlik tavanı kadroya göre değişmiyor; atıf tavanı yalnız profesörlükte var.
        $tavanlar['I'] = 20;
        $gruplar['I'] = ['I.1.b'];

        if ($profesor) {
            $tavanlar['G'] = 20;
        }

        $cetveller[$anahtar] = [
            'kapsam_notu' => $ortakNot
                .($alanEk === 'hukuk'
                    ? ' Hukuk temel alanında kitap yazarlığı 5 yerine 20, kitap bölümü 3 yerine '
                        .'10 puan; kitap tavanı da 20 yerine 30 (profesörlükte 60).'
                    : '')
                .($profesor
                    ? ' Profesörlük varyantı: bölüm tavanları iki katı, atıf bölümüne 20 puanlık '
                        .'tavan uygulanıyor.'
                    : ' Atıf bölümüne tavan yok; yönerge atıf tavanını yalnız profesörlük için '
                        .'koyuyor.'),
            'yazar_katsayisi' => $katki,
            'maddeler' => $tablo,
            'gruplar' => $gruplar,
            'grup_tavanlari' => $tavanlar,
        ];
    }
}

return ['cetveller' => $cetveller];
