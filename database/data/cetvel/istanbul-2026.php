<?php

/**
 * İSTANBUL ÜNİVERSİTESİ — TABLO 1: Tüm Akademik Birimlerde Değerlendirmeye
 * Alınacak Faaliyetler ve Puanları (+ Mimarlık Fakültesi için TABLO 4)
 * Kaynak: pdf/1784016632886.istanbul-universitesi-kriter.pdf
 * Yürürlük: Madde 17 — 01.06.2026
 *
 * BU PDF `-layout` İLE OKUNMUYOR, RAW MODLA OKUNUYOR. Alan tabloları dört
 * sütunlu (profesör / doçent / Dr. ilk / Dr. yeniden) ve sütunlar arasında
 * tam boş şerit yok; `pdftotext -layout` sütunları birbirine karıştırıyor.
 * `-layout` OLMADAN çalıştırıldığında pdftotext hücreleri okuma sırasına göre
 * tek tek döküyor ve sütunlar temiz ayrılıyor.
 *
 * İKİ CETVEL: Mimarlık Fakültesi'nin Tablo 4'ü (meslek ödülleri, mesleki
 * uygulamalar, eğitim-öğretim faaliyetleri) Tablo 1'in ÜSTÜNE geliyor, o
 * yüzden mimarlık ayrı bir varyant.
 *
 * ── FORMÜLLÜ KALEMLER GİRİLEMEDİ ──
 *   2.a/2.b  SCIE/SSCI/AHCI makale puanı "taban + (IF × 5)". Faaliyet kaydı
 *       derginin etki faktörünü tutmuyor; yalnızca TABAN puan girildi
 *       (Q1 60, Q2 50, Q3 45, Q4 40). Puan olduğundan DÜŞÜK görünür.
 *   11.a  h-indeksi × 10 (sosyal bilimlerde h-indeksi² × 5).
 *   11.b  ikinci yabancı dil sınavı 20 puan.
 * Toplam puan barajları (400/600/800) bu eksiklerle hesaplanıyor; adayın
 * gerçek toplamı burada görünenden yüksek olabilir, düşük olamaz.
 *
 * ── KENDİ ÜRETTİĞİMİZ ALT KODLAR ──
 *   `2.a.1`-`2.a.4`, `2.b.1`-`2.b.4`  yönerge çeyrekliği tek satırda dört
 *       değerle veriyor; her çeyreklik ayrı satır oldu.
 *   `*.tz` ekli kodlar  ADAYIN KENDİ TEZİNDEN üretilmiş yayınlar. Yönergenin
 *       6.c-f satırları adayın DANIŞMANLIK YAPTIĞI tezlerden üretilen
 *       yayınları puanlıyor; faaliyet kaydı tezin kime ait olduğunu tutmadığı
 *       için o satırlar girilmedi. Adayın kendi tezinden ürettiği yayın ise
 *       sıradan yayın gibi puanlanıyor (aynı değerler), yalnızca ayrı
 *       kategoride durduğu için ayrı kod aldı. Dr. ilk atamadaki "en az 1'i
 *       doktora tezinden üretilmiş" koşulu bu kodlara bakıyor.
 *   `7.*.a/.b`  proje puanı role göre bölünüyor (yürütücü %70, araştırmacı
 *       %50, danışman ve bursiyer %20). Yönerge yürütücü TEK KİŞİYSE %100
 *       diyor; kayıt bunu söylemediği için düşük olan %70 alındı.
 *
 * ── AYNI KAYNAĞA DÜŞEN İKİ SATIRDA DAİMA DÜŞÜĞÜ GİRİLDİ ──
 *   Kitap 1.d uluslararası (60) / 1.g ulusal (50)            → 1.g
 *   Kitap bölümü 1.e (25) / 1.h (20)                         → 1.h
 *   Ansiklopedi 1.f (10) / 1.i (7)                           → 1.i
 *   Çeviri 1.j (30) / 1.k (20)                               → 1.k
 *   Makale 2.c Scopus çeyreklikli (45-30) / 2.e ESCI (30)    → 2.e
 *   Atıf 3.a (4) / 3.b (3)                                   → 3.b
 *   Toplantı kurul üyeliği 4.e-4.f (2) / 4.i-4.j (1)         → 4.i
 *   Kitap editörlüğü 5.d (30) / 5.g (20)                     → 5.g
 *   Yayın kurulu üyeliği 5.n (5) / 5.r (3) / 5.v (1)         → 5.v
 *   Hakemlik 5.m (10) / 5.q (7) / 5.u (3)                    → 5.u
 *   Ders 8.c yıllık (4) / 8.d dönemlik (2)                   → 8.d
 *   Ödül 9.a-9.h (100-20) / 9.i-9.j (10)                     → 9.i
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   1.c kitap değerlendirmesi · 1.m karar tahlilleri (hukuk) ·
 *   2.m hakemsiz dergi yazısı · 2.n makale çevirisi ·
 *   3.c, 3.f, 3.h atıf alt türleri · 6.c-f danışmanlık yapılan tezlerden
 *   üretilen yayınlar · 7.a, 7.h proje ÖNERİLERİ · 7.k-7.m dış kurum
 *   projelerinde görev, Mevlâna · 7.n-7.o patent BAŞVURUSU (yönerge asgari
 *   kriterde kullanılamaz diyor) · 8.a-8.b sertifika · 11.c-11.e teknokent
 *   şirketi ve bilirkişilik. Hepsinin ortak sebebi: kaynak sözlüğünde ayırt
 *   edici etiket yok.
 *
 * Yönerge: yonerge/istanbul.php
 */
$kapsamNotu = 'Puanlar İstanbul Üniversitesi 2026 kriterlerinin TABLO 1\'inden. '
    .'Çok yazarlı yayınlarda puan yönergenin Madde 7 dağılımına göre azaltılır; çarpan hem '
    .'yazar sayısına hem sıranıza bağlı olduğu için faaliyetinizde kaçıncı yazar olduğunuzu '
    .'seçmeniz gerekir. Sırayı belirtmezseniz o yazar sayısındaki en düşük çarpan uygulanır; '
    .'yazar listesini boş bırakırsanız çarpan hiç uygulanmaz ve puanınız olduğundan yüksek '
    .'görünür. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: indeksli dergi makalelerinin puanı '
    .'yönergede "taban + etki faktörü × 5"; kayıt derginin etki faktörünü tutmadığı için '
    .'yalnızca taban puan sayılıyor. h-indeksi puanı (h × 10), ikinci yabancı dil puanı, '
    .'danışmanlık yaptığınız tezlerden üretilen yayınlar, proje önerileri ve patent '
    .'başvuruları da girilmedi. Projelerde yürütücü payı %70 alındı; yönerge tek kişilik '
    .'projede %100 veriyor. Ödüllerde ayırt edici etiket olmadığı için en düşük satır '
    .'kullanıldı. Gerçek toplamınız burada görünenden yüksek olabilir, düşük olamaz.';

// Madde 7 + Tablo A. Katsayı ANA MERKEZDEKİ yazar sayısına bağlı (sorumlu
// yazarın bulunduğu kurum); farklı merkezdeki yazarlar için ayrı bir tablo (B)
// var. Faaliyet kaydı yazarların kurumunu tutmadığı için TOPLAM yazar sayısı
// kullanıldı — toplam, ana merkezdeki sayıdan büyük olduğu için katsayı
// olduğundan DÜŞÜK çıkar, yani puan fazla gösterilmez.
//
//   sayı        1     2     3     4     5     6   7-10  11-20   ≥21
//   Sorumlu   1,00  0,80  0,60  0,50  0,40  0,40  0,40  0,40  0,40
//   Diğer       -   0,50  0,25  0,20  0,15  0,12  0,10  0,06  0,04
//
// Yönerge yalnızca SORUMLU YAZAR ile diğerlerini ayırıyor, sıraya bakmıyor.
// Bu yüzden "ilk yazar" da diğer yazarlar satırını alır; sorumlu yazarlık
// formda ayrı bir seçenek ("Başlıca / sorumlu yazar").
$yazarKatsayisi = [
    'haric' => ['atif', 'bildiri', 'proje', 'patent', 'tez_danismanligi',
        'egitim_ogretim', 'idari_gorev', 'odul', 'toplumsal_katki'],
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.0]],
        'baslica' => ['kademeler' => [1 => 1.0, 2 => 0.80, 3 => 0.60, 4 => 0.50, 5 => 0.40], 'sonrasi' => 0.40],
        'ilk' => ['kademeler' => $diger = [
            1 => 1.0, 2 => 0.50, 3 => 0.25, 4 => 0.20, 5 => 0.15, 6 => 0.12,
            7 => 0.10, 8 => 0.10, 9 => 0.10, 10 => 0.10,
            11 => 0.06, 12 => 0.06, 13 => 0.06, 14 => 0.06, 15 => 0.06,
            16 => 0.06, 17 => 0.06, 18 => 0.06, 19 => 0.06, 20 => 0.06,
        ], 'sonrasi' => 0.04],
        'yazar_2' => ['kademeler' => $diger, 'sonrasi' => 0.04],
        'yazar_3' => ['kademeler' => $diger, 'sonrasi' => 0.04],
        'yazar_4' => ['kademeler' => $diger, 'sonrasi' => 0.04],
        'yazar_5' => ['kademeler' => $diger, 'sonrasi' => 0.04],
        'yazar_6' => ['kademeler' => $diger, 'sonrasi' => 0.04],
        'ortak' => ['kademeler' => $diger, 'sonrasi' => 0.04],
    ],
];

// ── TABLO 1 ─────────────────────────────────────────────────────────────────
$maddeler = [
    // ══ 1. ULUSLARARASI VE ULUSAL KİTAP ══
    '1.a' => ['baslik' => 'Web of Science Book Citation Index kapsamında bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 100],
    '1.b' => ['baslik' => 'Web of Science Book Citation Index kapsamında kitap içinde bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 35],
    '1.g' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanan bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı'], 'puan' => 50],
    '1.h' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanan kitap içinde bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 20],
    '1.i' => ['baslik' => 'Bilimsel ansiklopedide madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 7],
    '1.k' => ['baslik' => 'Bilimsel kitap çevirisi veya edisyon kritik', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 20],
    '1.l' => ['baslik' => 'Bilimsel kitap içinde bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 7],

    // ══ 2. MAKALE VE DİĞER YAYINLAR ══
    // Yönergedeki değer "taban + (IF × 5)"; yalnızca taban girildi.
    '2.a.1' => ['baslik' => 'SCIE, SSCI veya AHCI kapsamındaki Q1 dergide özgün araştırma veya derleme makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 60],
    '2.a.2' => ['baslik' => 'SCIE, SSCI veya AHCI kapsamındaki Q2 dergide özgün araştırma veya derleme makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 50],
    '2.a.3' => ['baslik' => 'SCIE, SSCI veya AHCI kapsamındaki Q3 dergide özgün araştırma veya derleme makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 45],
    '2.a.4' => ['baslik' => 'SCIE, SSCI veya AHCI kapsamındaki Q4 dergide özgün araştırma veya derleme makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 40],
    '2.b.1' => ['baslik' => 'SCIE, SSCI veya AHCI kapsamındaki Q1 dergide editöre mektup, teknik not veya vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 22],
    '2.b.2' => ['baslik' => 'SCIE, SSCI veya AHCI kapsamındaki Q2 dergide editöre mektup, teknik not veya vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 20],
    '2.b.3' => ['baslik' => 'SCIE, SSCI veya AHCI kapsamındaki Q3 dergide editöre mektup, teknik not veya vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 18],
    '2.b.4' => ['baslik' => 'SCIE, SSCI veya AHCI kapsamındaki Q4 dergide editöre mektup, teknik not veya vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 15],
    '2.e' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide özgün araştırma veya derleme makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 30],
    '2.f' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide editöre mektup, teknik not veya vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 10],
    '2.g' => ['baslik' => 'Diğer uluslararası alan indeksli hakemli dergide özgün araştırma veya derleme makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 20],
    '2.h' => ['baslik' => 'Diğer uluslararası alan indeksli hakemli dergide editöre mektup veya teknik not', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 7],
    '2.i' => ['baslik' => 'TÜBİTAK-ULAKBİM TR Dizinde taranan dergide özgün araştırma veya derleme makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 25],
    '2.j' => ['baslik' => 'TÜBİTAK-ULAKBİM TR Dizinde taranan dergide editöre mektup veya teknik not', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 8],
    '2.k' => ['baslik' => 'Diğer yurt içi hakemli dergide özgün araştırma veya derleme makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 10],
    '2.l' => ['baslik' => 'Diğer yurt içi hakemli dergide editöre mektup veya teknik not', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 5],

    // ── Adayın KENDİ tezinden üretilmiş yayınlar (kodlar bize ait) ──
    // Sıradan yayınla aynı puanı alır; ayrı kategori olduğu için ayrı satır.
    '1.a.tz' => ['baslik' => 'Doktora tezinden üretilmiş, uluslararası indeksli yayınevinde kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 100],
    '1.b.tz' => ['baslik' => 'Doktora tezinden üretilmiş, uluslararası indeksli yayınevinde kitap bölümü', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 35],
    '1.g.tz' => ['baslik' => 'Doktora tezinden üretilmiş ulusal kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 50],
    '1.h.tz' => ['baslik' => 'Doktora tezinden üretilmiş ulusal kitap bölümü', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 20],
    '2.a.tz' => ['baslik' => 'Doktora tezinden üretilmiş, SCIE, SSCI veya AHCI kapsamındaki dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 40],
    '2.e.tz' => ['baslik' => 'Doktora tezinden üretilmiş, ESCI veya Scopus kapsamındaki dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 30],
    '2.i.tz' => ['baslik' => 'Doktora tezinden üretilmiş, TR Dizinde taranan dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['TR Dizin'], 'puan' => 25],

    // ══ 3. ATIFLAR (bölüm tavanı 75 puan) ══
    // Sözlük 16.09.2026'da atıfta ESCI'yi çekirdek indeksten ayırdı.
    '3.a' => ['baslik' => 'SCIE, SSCI ya da AHCI kapsamındaki dergilerde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 4],
    '3.b' => ['baslik' => 'WoS-ESCI ya da SCOPUS kapsamındaki dergilerde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 3],
    '3.d' => ['baslik' => 'TR Dizin kapsamındaki dergilerde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 1],
    '3.e' => ['baslik' => 'BKCI kapsamındaki kitapta yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 4],
    '3.g' => ['baslik' => 'Ulusal kitap veya tezlerde yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'Patent'], 'puan' => 1],

    // ══ 4. BİLİMSEL TOPLANTILAR (bölüm tavanı 50 puan) ══
    '4.a' => ['baslik' => 'Sözlü sunulan ve CPCI\'da yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 8],
    '4.c' => ['baslik' => 'Uluslararası toplantıda sözlü sunulan ve yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Davetli Konuşmacı'], 'puan' => 5],
    '4.d' => ['baslik' => 'Uluslararası toplantıda yayımlanan poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 3],
    '4.g' => ['baslik' => 'Ulusal toplantıda sözlü sunulan ve yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 4],
    '4.h' => ['baslik' => 'Ulusal toplantıda yayımlanan poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 2],
    '4.i' => ['baslik' => 'Bilimsel toplantı düzenleme komitesi veya bilim kurulu üyeliği', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 1],
    '4.ik' => ['baslik' => 'Bilimsel toplantı düzenleme komitesi veya bilim kurulu üyeliği (kurul görevi)', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 1],

    // ══ 5. EDİTÖRLÜK VE DİĞER GÖREVLER ══
    '5.a' => ['baslik' => 'BKCI kapsamındaki bilimsel kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 40],
    '5.g' => ['baslik' => 'Bilimsel kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 20],
    '5.k' => ['baslik' => 'SCIE, SSCI veya AHCI kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 40],
    '5.o' => ['baslik' => 'Scopus veya WoS-ESCI kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 30],
    '5.s' => ['baslik' => 'TR Dizin veya uluslararası indeksli hakemli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi (Uluslararası)'], 'puan' => 15],
    '5.u' => ['baslik' => 'Dergide hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 3],
    '5.v' => ['baslik' => 'Dergi yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 1],

    // ══ 6. LİSANSÜSTÜ TEZLER ══
    '6.a' => ['baslik' => 'Danışmanlığında tamamlanmış doktora, uzmanlık veya sanatta yeterlik tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman', 'es_danisman'], 'puan' => 10],
    '6.b' => ['baslik' => 'Danışmanlığında tamamlanmış yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman', 'es_danisman'], 'puan' => 5],

    // ══ 7. ARAŞTIRMA PROJELERİ VE FİKRİ MÜLKİYET HAKLARI ══
    // Rol payı: yürütücü %70 (tek kişiyse %100, ayrılamıyor), araştırmacı
    // %50, danışman ve bursiyer %20.
    '7.b' => ['baslik' => 'TÜBİTAK veya TÜSEB destek programından alınan projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 70],
    '7.b.a' => ['baslik' => 'TÜBİTAK veya TÜSEB projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci'], 'puan' => 50],
    '7.b.b' => ['baslik' => 'TÜBİTAK veya TÜSEB projesinde danışmanlık veya bursiyerlik', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 20],
    '7.c' => ['baslik' => 'Cumhurbaşkanlığı veya bakanlık kuruluşlarından alınan Ar-Ge projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 56],
    '7.c.a' => ['baslik' => 'Cumhurbaşkanlığı veya bakanlık Ar-Ge projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['arastirmaci'], 'puan' => 40],
    '7.c.b' => ['baslik' => 'Cumhurbaşkanlığı veya bakanlık Ar-Ge projesinde danışmanlık veya bursiyerlik', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 16],
    '7.d' => ['baslik' => 'Üniversite-sanayi kontratlı Ar-Ge projesinde yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 56],
    '7.d.a' => ['baslik' => 'Üniversite-sanayi kontratlı Ar-Ge projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci'], 'puan' => 40],
    '7.d.b' => ['baslik' => 'Üniversite-sanayi kontratlı Ar-Ge projesinde danışmanlık veya bursiyerlik', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 16],
    // 7.g bölüm tavanı 100 puan; yönerge BAP projelerinden yalnızca birinin
    // sayılacağını ve asgari kriterde kullanılamayacağını söylüyor.
    '7.g' => ['baslik' => 'Diğer özel veya kamu kurumundan alınan projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 14],
    '7.g.a' => ['baslik' => 'Diğer özel veya kamu kurumu projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci'], 'puan' => 10],
    '7.g.b' => ['baslik' => 'Diğer özel veya kamu kurumu projesinde danışmanlık veya bursiyerlik', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 4],
    '7.i' => ['baslik' => 'Avrupa Birliği Ar-Ge destek programından alınan projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 140],
    '7.i.a' => ['baslik' => 'Avrupa Birliği Ar-Ge projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci'], 'puan' => 100],
    '7.i.b' => ['baslik' => 'Avrupa Birliği Ar-Ge projesinde danışmanlık veya bursiyerlik', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 40],
    '7.j' => ['baslik' => 'Avrupa Birliği dışında uluslararası Ar-Ge programından alınan projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 105],
    '7.j.a' => ['baslik' => 'Avrupa Birliği dışında uluslararası Ar-Ge projesinde araştırmacılık', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci'], 'puan' => 75],
    '7.j.b' => ['baslik' => 'Avrupa Birliği dışında uluslararası Ar-Ge projesinde danışmanlık veya bursiyerlik', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 30],
    // Fikrî ve sınai mülkiyet hakları (p-v): koşullarda adıyla anılıyor.
    '7.p' => ['baslik' => 'Ulusal patent belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 100],
    '7.q' => ['baslik' => 'Uluslararası patent belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 200],
    '7.r' => ['baslik' => 'Faydalı model belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 100],
    '7.s' => ['baslik' => 'Endüstriyel tasarım belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 100],
    '7.t' => ['baslik' => 'Ticarileştirilmiş patent belgesi', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 200],

    // ══ 8. EĞİTİM ÖĞRETİM FAALİYETLERİ (bölüm tavanı 50 puan) ══
    '8.d' => ['baslik' => 'Lisans veya lisansüstü ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 2],

    // ══ 9. BİLİMSEL ÖDÜL (bölüm tavanı 100 puan) ══
    '9.a' => ['baslik' => 'Cumhurbaşkanlığı, TÜBA veya TÜBİTAK Bilim Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü'], 'puan' => 100],
    '9.d' => ['baslik' => 'YÖK ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü'], 'puan' => 50],
    '9.f' => ['baslik' => 'TÜBA GEBİP veya TÜBİTAK Teşvik Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 50],
    '9.i' => ['baslik' => 'Diğer bilimsel ödül veya burs', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü', 'Ulusal Bilim/Sanat Ödülü', 'Yarışma Derecesi / Mansiyon', 'Burs'], 'puan' => 10],

    // ══ 10. İDARİ GÖREVLER (bölüm tavanı 40 puan) ══
    '10.a' => ['baslik' => 'Dekan, enstitü, yüksekokul veya konservatuvar müdürlüğü (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan / Enstitü-YO Müdürü'], 'puan' => 8],
    '10.b' => ['baslik' => 'Dekan veya müdür yardımcılığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.'], 'puan' => 4],
    '10.c' => ['baslik' => 'Merkez müdürlüğü (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 4],
    '10.d' => ['baslik' => 'Bölüm, anabilim veya anasanat dalı başkanlığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı', 'Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 3],
    '10.g' => ['baslik' => 'Kamu kurum ve kuruluşlarında alınan görev (yıl başına)', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı', 'Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 1],
];

// ── TABLO 4 (yalnızca Mimarlık Fakültesi) ───────────────────────────────────
$tablo4 = [
    // MESLEK BAŞARI ÖDÜLÜ ≠ BİLİM/SANAT ÖDÜLÜ. İki satır da ilk girişte genel
    // ödül etiketlerini taşıyordu; ortak tablonun 9.i satırı ("Diğer bilimsel
    // ödül veya burs", 10 puan) aynı etiketleri taşıdığı için `puan()` en
    // yükseği alıyor ve mimarlık adayının HERHANGİ bir uluslararası bilim
    // ödülü 100 puan sayılıyordu. Etiket sözlükte "Bilim/Sanat" diyor, satır
    // ise mesleki başarıyı; ayrım kayıtta yok, bu yüzden etiketler ortak
    // tablonun düşük satırında bırakıldı (§0). Konservatuvar ekindeki
    // T2.7.a/T2.7.e AYNI DURUMDA DEĞİL: onların başlığı da "sanat ödülü",
    // yani etiketin birebir karşılığı; oradaki 50/40 doğru.
    'T4.1.a' => ['baslik' => 'Uluslararası meslek başarı ödülü', 'kategori' => 'odul', 'kaynaklar' => [], 'puan' => 100],
    'T4.1.b' => ['baslik' => 'Ulusal meslek başarı ödülü', 'kategori' => 'odul', 'kaynaklar' => [], 'puan' => 50],
    'T4.1.h' => ['baslik' => 'Yarışmada derece, mansiyon veya satın alma ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 15],
    // Kaynak e) ULUSLARARASI yarışmalarda jüri üyeliği 15, i) ULUSAL 10
    // diyor; iki kapsam tek satırda 10 puanla birleşmişti.
    'T4.1.e' => ['baslik' => 'Uluslararası yarışmada jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)'], 'puan' => 15],
    'T4.1.i' => ['baslik' => 'Ulusal yarışmada jüri üyeliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 10],
    'T4.2.c' => ['baslik' => 'Ulusal düzeyde proje, planlama veya tasarım sürecini yürütmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif'], 'puan' => 20],
    'T4.2.d' => ['baslik' => 'Ulusal düzeyde proje, planlama veya tasarım sürecinde ekip üyesi olmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman'], 'puan' => 10],
    'T4.3.f' => ['baslik' => 'Eğitime yönelik atölye veya yaz okulu düzenlemek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Akreditasyon Faaliyeti'], 'puan' => 5],
];

// ══════════════════════════════════════════════════════════════════════
// TABLO 2 — Devlet Konservatuvarı
// Madde 13-15'in bütün eşikleri Tablo 1 ile Tablo 2'yi birlikte sayıyor;
// bu tablo yalnız `istanbul-2026-konservatuvar` varyantında var.
//
// Uluslararası ve ulusal satırlar kayıtta ayrı etiket taşımayan kalemlerde
// (orkestra/koro üyeliği, audio yayın, yarışma derecesi) tek satıra düştü ve
// §0 uyarınca ULUSAL değer alındı.
// 2. maddenin çeviri bentleri (tam uzunlukta 10, kısa oyun 5) ile 4/6.
// maddelerin karma ve oda müziği organizasyonu bentleri kayıtta karşılıksız;
// girilmedi.
// ══════════════════════════════════════════════════════════════════════
$tablo2 = [
    // ══ 1. MÜZİK KOMPOZİSYONLARI ══
    'T2.1.a' => ['baslik' => 'Sahne yapıtı bestelemek (opera, bale, müzikal tiyatro, oratoryo vb.)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera/Bale Kompozisyonu', 'Orkestralı Sahne Eseri'], 'puan' => 50],
    'T2.1.b' => ['baslik' => 'Senfonik yapıt bestelemek (senfoni, konçerto vb.)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Senfoni Kompozisyonu', 'Konçerto/Senfonik Şiir'], 'puan' => 50],
    'T2.1.c' => ['baslik' => 'Oda müziği yapıtı, koro yapıtı ya da solo yapıt bestelemek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda/Koro Müziği Eseri (≥15 dk)', 'Oda/Koro Müziği Eseri (<15 dk)', 'Küçük Ölçekli Orkestra Eseri', 'Özgün Eser / Beste / Tasarım'], 'puan' => 35],
    'T2.1.d' => ['baslik' => 'Düzenleme', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi'], 'puan' => 15],
    'T2.1.e' => ['baslik' => 'Elektronik müzik yapıtı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Elektronik Müzik Eseri (≥15 dk)', 'Elektronik Müzik Eseri (<15 dk)'], 'puan' => 25],

    // ══ 3 ve 5. ULUSLARARASI / ULUSAL SANATSAL ETKİNLİKLER ══
    'T2.3.a' => ['baslik' => 'Ödenekli ya da özel sanat kurumunda tam uzunlukta tiyatro oyunu, müzikal ya da bale eseri yönetmek (uluslararası)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisörlük (Uluslararası)'], 'puan' => 20],
    'T2.5.a' => ['baslik' => 'Ödenekli ya da özel sanat kurumunda tiyatro oyunu, müzikal ya da bale eseri yönetmek (ulusal)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)'], 'puan' => 15],
    'T2.3.c' => ['baslik' => 'Bireysel dinleti (solo resital) — uluslararası', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Uluslararası)', 'Şan Resitali (Uluslararası)'], 'puan' => 40],
    'T2.5.c' => ['baslik' => 'Bireysel dinleti (solo resital) — ulusal', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Resital (Ulusal)', 'Şan Resitali (Ulusal)'], 'puan' => 30],
    'T2.3.d' => ['baslik' => 'Karma dinleti — uluslararası', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)'], 'puan' => 25],
    'T2.5.d' => ['baslik' => 'Karma dinleti — ulusal', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)'], 'puan' => 15],
    'T2.3.e' => ['baslik' => 'Eşlikçi (korrepetitör) olarak katılım — uluslararası', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahneleme/Repetitörlük — Tüm Perde (Uluslararası)', 'Sahneleme/Repetitörlük — Bölüm (Uluslararası)'], 'puan' => 30],
    'T2.5.e' => ['baslik' => 'Eşlikçi (korrepetitör) olarak katılım — ulusal', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahneleme/Repetitörlük — Tüm Perde (Ulusal)', 'Sahneleme/Repetitörlük — Bölüm (Ulusal)'], 'puan' => 20],
    'T2.3.f' => ['baslik' => 'Tiyatro, opera ya da balede başrol oynamak — uluslararası', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera Birinci Rol (Uluslararası)', 'Bale Başrol (Uluslararası)', 'Oratoryo/Kantat Solistliği (Uluslararası)'], 'puan' => 30],
    'T2.5.f' => ['baslik' => 'Tiyatro, opera ya da balede başrol oynamak — ulusal', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera Birinci Rol (Ulusal)', 'Bale Başrol (Ulusal)', 'Oratoryo/Kantat Solistliği (Ulusal)'], 'puan' => 20],
    'T2.3.g' => ['baslik' => 'Tiyatro, opera ya da balede yardımcı rol oynamak — uluslararası', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera İkinci Rol (Uluslararası)', 'Bale Solist Rol (Uluslararası)'], 'puan' => 15],
    'T2.5.g' => ['baslik' => 'Tiyatro, opera ya da balede yardımcı rol oynamak — ulusal', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Opera İkinci Rol (Ulusal)', 'Bale Solist Rol (Ulusal)'], 'puan' => 10],
    'T2.3.h' => ['baslik' => 'Orkestrada solist olarak yer almak — uluslararası', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Solistlik (Uluslararası)'], 'puan' => 35],
    'T2.5.h' => ['baslik' => 'Senfoni orkestrasında solist olarak yer almak — ulusal', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Solistlik (Ulusal)'], 'puan' => 25],
    'T2.3.i' => ['baslik' => 'Oda müziği dinletisi — uluslararası', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Uluslararası)'], 'puan' => 35],
    'T2.5.i' => ['baslik' => 'Oda müziği dinletisi — ulusal', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Oda Müziği Grup Üyeliği (Ulusal)'], 'puan' => 25],
    'T2.3.j' => ['baslik' => 'Corps de ballet olarak yer almak — uluslararası', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Corps de Ballet (Uluslararası)'], 'puan' => 20],
    'T2.5.j' => ['baslik' => 'Orkestrada (tutti), operada (koro) ya da balede (corps de ballet) yer almak — ulusal', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Corps de Ballet (Ulusal)', 'Orkestra / Koro Üyeliği'], 'puan' => 10],
    'T2.3.k' => ['baslik' => 'Orkestra dinletisinde şeflik — uluslararası', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra Şefliği (Uluslararası)', 'Opera Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Uluslararası)'], 'puan' => 40],
    'T2.5.k' => ['baslik' => 'Orkestra dinletisinde şeflik — ulusal', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Orkestra Şefliği (Ulusal)', 'Opera Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Ulusal)'], 'puan' => 30],
    'T2.3.l' => ['baslik' => 'Koro dinletisinde şeflik — uluslararası', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koro Şefliği (Uluslararası)'], 'puan' => 35],
    'T2.5.l' => ['baslik' => 'Koro dinletisinde şeflik — ulusal', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Koro Şefliği (Ulusal)'], 'puan' => 25],
    'T2.3.m' => ['baslik' => 'Yönetmen yardımcılığı, reji asistanlığı ya da sahne amirliği — uluslararası', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisör Yardımcılığı (Uluslararası)'], 'puan' => 10],
    'T2.5.m' => ['baslik' => 'Yönetmen yardımcılığı, reji asistanlığı ya da sahne amirliği — ulusal', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Rejisör Yardımcılığı (Ulusal)', 'Rejisör Yardımcılığı (Konservatuvar)'], 'puan' => 5],
    'T2.5.n' => ['baslik' => 'Radyo ya da televizyon etkinliğine katılmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'], 'puan' => 5],
    'T2.5.o' => ['baslik' => 'Bireysel audio yayın (CD ya da dijital platformlarda)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Bandrollü Kayıt (CD/DVD)', 'Albüm / Konser Kaydı'], 'puan' => 20],
    'T2.5.p' => ['baslik' => 'Karma audio yayın (CD ya da dijital platformlarda)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Albüm / CD-DVD Katkısı'], 'puan' => 10],

    // ══ 2. ESER YAZIMI ══
    'T2.2.b' => ['baslik' => 'Ödenekli ya da özel sanat kurumunda sahnelenmek kaydıyla tiyatro oyunu, libretto ya da müzikal tiyatro oyunu yazımı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Yönetmenlik (Sahne/Ekran)'], 'puan' => 15],

    // ══ 4 ve 6. ORGANİZASYON ETKİNLİKLERİ ══
    'T2.4.a' => ['baslik' => 'Bireysel dinleti organize etmek — uluslararası', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eğitici Konser Programı (Uluslararası)', 'Müzikoloji Atölyesi'], 'puan' => 20],
    'T2.6.a' => ['baslik' => 'Bireysel dinleti organize etmek — ulusal', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eğitici Konser Programı (Ulusal)', 'Eğitim Amaçlı Sanat Etkinliği'], 'puan' => 10],

    // ══ 7. SANATSAL ÖDÜLLER ══
    'T2.7.a' => ['baslik' => 'Uluslararası sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü'], 'puan' => 50],
    'T2.7.e' => ['baslik' => 'Ulusal sanat ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü'], 'puan' => 40],
    'T2.7.d' => ['baslik' => 'Yarışma ödülü (derece)', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 20],
];

$gruplar = [
    // Koşulların adıyla andığı dergi kümeleri.
    'SCIE' => ['2.a.1', '2.a.2', '2.a.3', '2.a.4'],
    'Q1-Q2' => ['2.a.1', '2.a.2'],
    'Q1-Q3' => ['2.a.1', '2.a.2', '2.a.3'],
    'WOS' => ['2.a.1', '2.a.2', '2.a.3', '2.a.4', '2.e'],
    'WOS-SCOPUS' => ['2.a.1', '2.a.2', '2.a.3', '2.a.4', '2.e'],
    'WOS-SCOPUS-TRDIZIN' => ['2.a.1', '2.a.2', '2.a.3', '2.a.4', '2.e', '2.i'],
    // Sosyal Bilimler ve Mimarlık'ta uluslararası kitap/kitap bölümü de
    // makale yerine sayılıyor.
    'MAKALE-VEYA-KITAP' => ['2.a.1', '2.a.2', '2.a.3', '2.a.4', '2.e', '2.i', '1.a', '1.b'],
    'MIMARLIK-MAKALE' => ['2.a.1', '2.a.2', '2.a.3', '2.a.4', '2.e', '2.g', '1.a', '1.b'],
    'TEK-YAZARLI-KITAP' => ['1.a', '1.g'],
    // Adayın kendi doktora tezinden üretilmiş yayınlar.
    'DOKTORA-TEZINDEN' => ['1.a.tz', '1.b.tz', '1.g.tz', '1.h.tz', '2.a.tz', '2.e.tz', '2.i.tz'],

    // Koşulların kod aralığıyla andığı kümeler.
    'FSMH' => ['7.p', '7.q', '7.r', '7.s', '7.t'],
    'DIS-KAYNAKLI-PROJE' => ['7.b', '7.b.a', '7.c', '7.c.a', '7.d', '7.d.a', '7.i', '7.i.a', '7.j', '7.j.a'],
    'DIS-KAYNAKLI-PROJE-YURUTUCU' => ['7.b', '7.c', '7.d', '7.i', '7.j'],
    'TEZ' => ['6.a', '6.b'],
    'DOKTORA-TEZI' => ['6.a'],
    'YUKSEK-LISANS-TEZI' => ['6.b'],

    // Bölüm tavanı taşıyan kümeler.
    'ATIF' => ['3.*'],
    'TOPLANTI' => ['4.*'],
    'BAP' => ['7.g', '7.g.a', '7.g.b'],
    'EGITIM' => ['8.*'],
    'ODUL' => ['9.*'],
    'IDARI' => ['10.*'],

    // Yeniden atamada Tablo 1'in 8, 10 ve 11. maddeleri sayılmıyor.
    'TABLO1-YENIDEN' => ['1.*', '2.*', '3.*', '4.*', '5.*', '6.*', '7.*'],
];

$tavanlar = [
    'ATIF' => 75,
    'TOPLANTI' => 50,
    'BAP' => 100,
    'EGITIM' => 50,
    'ODUL' => 100,
    'IDARI' => 40,
    'YUKSEK-LISANS-TEZI' => 25,
];

return ['cetveller' => [
    'istanbul-2026' => [
        'kapsam_notu' => $kapsamNotu,
        'yazar_katsayisi' => $yazarKatsayisi,
        'maddeler' => $maddeler,
        'gruplar' => $gruplar,
        'grup_tavanlari' => $tavanlar,
    ],
    'istanbul-2026-konservatuvar' => [
        'kapsam_notu' => $kapsamNotu.' Devlet Konservatuvarı bölümlerinde TABLO 2 (müzik '
            .'kompozisyonları, sanatsal etkinlikler, organizasyon etkinlikleri ve sanatsal '
            .'ödüller) de sayılıyor. Tablo 2\'nin uluslararası ve ulusal satırları kayıtta ayrı '
            .'etiketi olmayan kalemlerde (orkestra ve koro üyeliği, audio yayın, radyo-televizyon '
            .'katılımı, yarışma derecesi) tek satıra düştü ve ULUSAL değerden sayılıyor; '
            .'2. maddenin çeviri bentleri (10 ve 5) ile 4 ve 6. maddelerin karma dinleti ve oda '
            .'müziği organizasyonu bentleri (25, 25, 15, 15) kayıtta karşılıksız olduğu için '
            .'girilmedi. Tablo 2\'nin kendi madde tavanları (2. madde 50/30/20/10; 3.m ve 3.n 20; '
            .'5.m ve 5.n 10) uygulanıyor.',
        'yazar_katsayisi' => $yazarKatsayisi,
        'maddeler' => $maddeler + $tablo2,
        'gruplar' => $gruplar + [
            'TABLO-1' => array_keys($maddeler),
            'TABLO-2' => array_keys($tablo2),
            'T2-YAZIM' => ['T2.2.b'],
            'T2-3M' => ['T2.3.m'],
            'T2-3N' => ['T2.5.n'],
            'T2-5M' => ['T2.5.m'],
        ],
        'grup_tavanlari' => $tavanlar + [
            'T2-YAZIM' => 30, 'T2-3M' => 20, 'T2-3N' => 20, 'T2-5M' => 10,
        ],
    ],
    'istanbul-2026-mimarlik' => [
        'kapsam_notu' => $kapsamNotu.' Mimarlık Fakültesi için TABLO 4 (meslek ödülleri, '
            .'mesleki uygulamalar, eğitim-öğretim faaliyetleri) de sayılıyor; o tablonun '
            .'kaynakta karşılığı olmayan satırları (uluslararası mesleki uygulama, atölye '
            .'yönetimi, uluslararası kuruluş görevleri) girilemedi.',
        'yazar_katsayisi' => $yazarKatsayisi,
        'maddeler' => $maddeler + $tablo4,
        'gruplar' => $gruplar + [
            'T4-YARISMA' => ['T4.1.a', 'T4.1.b', 'T4.1.h', 'T4.1.i'],
            'T4-MESLEKI-UYGULAMA' => ['T4.2.c', 'T4.2.d'],
            'T4-EGITIM' => ['T4.3.f'],
            'MESLEKI-CALISMA' => ['T4.1.a', 'T4.1.b', 'T4.1.h', 'T4.1.i', 'T4.2.c', 'T4.2.d',
                '7.p', '7.q', '7.r', '7.s', '7.t'],
        ],
        'grup_tavanlari' => $tavanlar + ['T4-YARISMA' => 100, 'T4-EGITIM' => 50],
    ],
]];
