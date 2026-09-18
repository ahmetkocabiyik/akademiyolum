<?php

use App\Enums\Kategori;

/**
 * İZMİR KÂTİP ÇELEBİ ÜNİVERSİTESİ — EK-A/B/C/D Değerlendirme Puan Tabloları
 * Kaynak: pdf/17536998122.izmirkatipcelebiuniversitesi.pdf
 * (28 sayfa; 02.02.2023 tarih ve 2023/03-01 sayılı Senato kararı eki)
 *
 * ── DÖRT ALAN, DÖRT AYRI TABLO ──
 * Yönerge her temel alan grubuna kendi ekini ve kendi puan tablosunu
 * veriyor; tablolar hem madde numaralandırması hem puan olarak birbirinden
 * tamamen farklı, ortak gövde yok:
 *   ikcu-2023-sosyal-*  → EK-A (Sosyal Bilimler Alanı)
 *   ikcu-2023-fen       → EK-B (Fen Bilimleri Alanı)
 *   ikcu-2023-saglik    → EK-C (Sağlık Bilimleri Alanı)
 *   ikcu-2023-gsf       → EK-D (Güzel Sanatlar Alanı)
 *
 * MADDE KODLARI YÖNERGENİN KENDİSİ (`A1.1.a`, `B3.c`, `C11.a`, `D-G7.a`).
 * Ek harfi öne eklendi çünkü dört tablo tek dosyada duruyor ve numaralar
 * çakışıyor; nokta zorunluluğu yüzünden desenlerde yıldız kullanılmadı,
 * her grup kodlarını tek tek sayıyor.
 *
 * ── EK-A'NIN TAVANLARI YÜZDEYE BAĞLI → KADRO VARYANTI ──
 * EK-A'nın 3., 4., 5. ve 7. maddeleri "başvuru şartlarında istenen asgari
 * puanın %30/%25/%10/%20'sinden fazlasını karşılayamaz" diyor. Asgari puan
 * kadroya göre yazılı olduğu için (Dr. 50, profesör 200) tavan sabit sayıya
 * iniyor ve EK-A üç kadro varyantında üretildi (KONVANSIYONLAR §"Grup
 * tavanları" KOSTÜ istisnası). Tavanlar §0 uyarınca AŞAĞI yuvarlandı
 * (50'nin %25'i 12,5 → 12).
 * DOÇENTLİKTE asgari puan yönergede yazılı DEĞİL: "kurul tarafından ilan
 * edilen asgari puan şartının en az %80'i" deniyor, yani sayı ilanla
 * belirleniyor. O varyantta yüzdeye bağlı tavanlar hiç uygulanamadı ve
 * doçentlik puan barajı `Kalip::hesaplanamiyor` ile işaretlendi.
 *
 * ── EK-A MADDE 2 YALNIZCA DR. ÖĞRETİM ÜYELİĞİNDE GEÇERLİ ──
 * Tablo başlığı "Lisansüstü Tezlerden Üretilmiş Yayın (Yalnızca Doktor
 * Öğretim Üyesi Atamalarında Geçerlidir)" diyor. Satırlar silinmedi;
 * doçent ve profesör varyantlarında grup tavanı 0 yazıldı (KONVANSIYONLAR
 * §"Tavan FAKÜLTE × KADRO ise cetveli çarpanla üret").
 *
 * ── EK-B VE EK-C ÇEYREKLİK ──
 * EK-B'nin 1.a satırı çeyrekliğe göre dört ayrı puan taşıyor (Q1 40 · Q2 30
 * · Q3 20 · Q4 10); dört satır olarak girildi. AHCI dergilerinin çeyrekliği
 * kayıtta olmadığı için en düşük satıra (Q4) bağlandı.
 * EK-C çeyrekliği ÇARPAN olarak veriyor ("Q1 2 kat, Q2 1.5 kat, Q3 ve Q4
 * 1 kat"); çarpım cetvele gömüldü ve §0 uyarınca aşağı yuvarlandı
 * (5 × 1,5 = 7,5 → 7). Çarpan yalnızca yıldızlı satırlara uygulanıyor;
 * `tez_yayini` kategorisinde çeyreklik ayrımı olmadığı için EK-C 3.a
 * satırı çarpansız (1 kat) girildi — tezden üretilmiş Q1 makalesi olan
 * adayın puanı OLDUĞUNDAN DÜŞÜK görünür.
 *
 * ── AYNI KAYNAĞA DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   EK-A 3.h/3.i ansiklopedi maddesi (5/3) → 3; 3.j/3.l çeviri kitap
 *       (10/8) → 8; 3.n/3.o çeviri bölümü (5/3) → 3; 3.b/3.k uluslararası
 *       kitap editörlüğü (15/10) → 10; 3.f/3.m ulusal kitap editörlüğü
 *       (10/5) → 5.
 *   EK-A 4.a (SCI dergilerde ve uluslararası kitaplarda atıf, 4) ile 4.b
 *       (uluslararası kitaplarda atıf, 3): kitap atfı iki satırda birden →
 *       'BKCI Kitap' etiketi 3'e bağlandı.
 *   EK-A 7.c (uluslararası özet bildiri 4) ile 7.i (uluslararası poster 1):
 *       tek 'Uluslararası Özet/Poster' etiketi → 1. Aynı şekilde 7.e
 *       (ulusal özet 4) ile 7.f (ulusal sözlü 3) → 3.
 *   EK-A 7.j/7.k davetli konuşmacı (4/2) → 2; 7.n/7.p/7.r hakemlik
 *       (3/2/3) → 2.
 *   EK-B 8.f/8.g davetli konuşmacı (4/2) → 2.
 *   EK-C 8.f/8.g davetli konuşmacı (8/4) → 4; 8.i/8.j editörlük (6/3) — iki
 *       ayrı etiket olduğu için ikisi de korundu.
 *   EK-D 5.b'nin iki kez "b" kodu taşıması (ESCI atıf 4 · uluslararası
 *       kitapta atıf 3) kaynak hatası; ikisi de ayrı satır olarak girildi.
 *   Patent satırlarında faydalı model, endüstriyel tasarım ve yazılım
 *       ayrımı olmayan tablolarda (EK-A) 'Ticarileştirme' dışındaki patent
 *       etiketlerine satır yok.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   EK-A 3.g (İKÇÜ Yayın Komisyonu onaylı kitap 25) — 3.d ile aynı kayda
 *       düşer, yüksek olanı yazmak çifte sayım olurdu.
 *   EK-A 3. maddenin dipnotu "sadece ders kitabı niteliği DIŞINDAKİ özgün
 *       bilimsel kitaplar puanlanabilir" dediği için 'Ders / Metot Kitabı'
 *       etiketine hiçbir satır bağlanmadı: ders kitabınız bu üniversitede
 *       puansız.
 *   EK-A 5.c (tezsiz yüksek lisans proje danışmanlığı 1) ve tez izleme
 *       komitesi — sözlükte karşılık yok.
 *   EK-A 10 (arazi çalışmaları) — 6.g/6.h ile aynı kayda düşer ve daha
 *       düşük puanlı.
 *   EK-B 9.d ("en iyi öğretici" ödülü) — kuruma özel.
 *   EK-C 12.c/12.d (üniversite sosyal sorumluluk birimi onaylı projeler) —
 *       12.b ile aynı kayda düşer.
 *   EK-D özel başvuru şartlarının portföye bağlı satırları (en az 10 eserlik
 *       kişisel sergi, dört saatlik şeflik kaydı, iki opera eseri gibi)
 *       eser başına bölünemediği için girilmedi; "her bir etkinlik için"
 *       okunabilen satırlar girildi.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   "Aynı ISBN'ye sahip eserde b, c, e, f, h, i maddelerinden alınacak
 *       toplam puan asgari puanın %30'undan fazlasını karşılayamaz" (EK-A)
 *       ve "aynı kitaptaki bölümlerden en fazla ikisi dikkate alınır"
 *       (EK-C) — eser bazlı tavan; grup tavanı olarak yazıldı ama ESER
 *       bazında uygulanmıyor.
 *   "Aynı toplantıda sunulan en fazla bir bildiri puanlanır" — kayıt
 *       toplantı kimliğini tutmuyor.
 *   Dergi görevlerinin "her sayı için" / "her yıl için" çarpanları ve
 *       idari görevin süre çarpanı — yıl/sayı biriktirmesi motorda yok;
 *       görev başına tek değer sayılıyor, puan olduğundan DÜŞÜK görünür.
 *   EK-B 4. maddenin "ticarileşme gerçekleşmişse puan 3 ile çarpılır"
 *       kuralı — ticarileşme ayrı bir kayıt türü olduğu için çarpan
 *       uygulanmıyor; 'Ticarileştirme' etiketi kendi satırından sayılıyor.
 *   EK-B 3. madde ve EK-D 11. madde "puan isim sayısına bölünür" derken
 *       yönergenin genel yazar kuralı yok; bölme yazar katsayısı matrisi
 *       üzerinden 1/n olarak uygulandı.
 *
 * Yönerge: yonerge/ikcu.php
 *
 * KODLAR BİZE AİT — KAYNAKTA SATIR KODU YOK. Cetvel kodlarının SAYISAL
 * ÇEKİRDEĞİ kaynağın madde/bölüm numarasıdır; baştaki harf tabloyu ya da
 * eki, sondaki harf şıkkı gösterir ve ikisi de bizim eklediğimiz parçadır.
 * Koşullar bu kodlara atıf yaptığı için değiştirilmemeli; kaynakla
 * karşılaştırırken kodun sayısal çekirdeğine bakılmalı.
 */

/** Yazar sayısına eşit bölen matris — yönerge sıraya bağlı bir kural vermiyor. */
$esitBolusme = ['sonrasi_pay' => 1.0];

$yazarKatsayisi = [
    'haric' => ['atif', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev',
        'odul', 'editorluk', 'toplumsal_katki', 'proje', 'diger'],
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.0]],
        'ilk' => $esitBolusme,
        'baslica' => $esitBolusme,
        'yazar_2' => $esitBolusme,
        'yazar_3' => $esitBolusme,
        'yazar_4' => $esitBolusme,
        'yazar_5' => $esitBolusme,
        'yazar_6' => $esitBolusme,
        'ortak' => $esitBolusme,
    ],
];

$SCI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];
$IDARI = ['Rektör', 'Rektör Yardımcısı',
    'Dekan / Enstitü-YO Müdürü', 'Dekan Yrd. / Müdür Yrd.', 'Uygulama ve Araştırma Merkezi Müdürü',
    'Bölüm Başkanı', 'Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük',
    'Kurul / Komisyon Üyeliği'];
$TOPLUM = ['Topluma Hizmet Projesi', 'Kamu/STK Danışmanlığı', 'Bilim İletişimi / Popüler Yayın'];

// EK-A'nın 12. maddesi (yalnızca İletişim Bilimleri) film ve TV yapımlarını
// puanlıyor; uluslararası/ulusal ayrımı taşımayan sanat etiketleri en düşük
// satıra düşer.
$iletisimUluslararasi = ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)',
    'Belgesel/Kısa Film (Uluslararası)', 'Yönetmenlik (Sahne/Ekran)'];
$iletisimUlusal = ['Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Belgesel/Kısa Film (Ulusal)'];
$iletisimDiger = array_values(array_diff(
    Kategori::SanatselEtkinlik->kaynaklar(), $iletisimUluslararasi, $iletisimUlusal,
));

// ══════════════════════════════════════════════════════════════════════════
// EK-A — SOSYAL BİLİMLER ALANI
// ══════════════════════════════════════════════════════════════════════════

$A = [
    'A1.1.a' => ['baslik' => 'SSCI, SCI, SCI-E veya AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 25],
    'A1.1.b' => ['baslik' => 'Uluslararası alan endekslerinde taranan dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 15],
    'A1.1.c' => ['baslik' => 'Uluslararası dergide yayımlanmış kitap kritiği ya da benzeri kısa yayın', 'kategori' => 'makale', 'kaynaklar' => [...$SCI, 'ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 8],
    'A1.2.a' => ['baslik' => 'ULAKBİM TR Dizin tarafından taranan ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 15],
    'A1.2.b' => ['baslik' => 'Diğer ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 5],

    'A2.a' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
    'A2.b' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, uluslararası yayınevi kitabında bölüm', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 10],
    'A2.c' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 10],
    'A2.d' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, ulusal yayınevi kitabında bölüm', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 5],
    'A2.e' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, SSCI, SCI, SCI-E veya AHCI kapsamındaki dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 20],
    'A2.f' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, uluslararası alan endeksli dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 10],
    'A2.g' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, ULAKBİM TR Dizin taranan dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['TR Dizin', 'Diğer'], 'puan' => 10],

    'A3.a' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 30],
    'A3.b' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitabın (ya da çeviri kitabın) editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 10],
    'A3.c' => ['baslik' => 'Uluslararası yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 15],
    'A3.d' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış özgün bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 20],
    'A3.e' => ['baslik' => 'Ulusal yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 10],
    'A3.f' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitabın (ya da çeviri kitabın) editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 5],
    'A3.h' => ['baslik' => 'Alana özgü ansiklopedi maddesi', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 3],
    'A3.j' => ['baslik' => 'Çeviri kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 8],
    'A3.n' => ['baslik' => 'Çeviri kitapta bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 3],

    'A4.a' => ['baslik' => 'SCI, SCI-E, SSCI, AHCI dergilerinde adınıza yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 4],
    'A4.b' => ['baslik' => 'Uluslararası yayınevi kitaplarında adınıza yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 3],
    'A4.c' => ['baslik' => 'Diğer endeksli dergilerde adınıza yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer', 'ESCI', 'Scopus'], 'puan' => 2],
    'A4.d' => ['baslik' => 'Ulusal hakemli dergilerde ya da ulusal yayınevi kitaplarında adınıza yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Patent'], 'puan' => 1],

    'A5.a' => ['baslik' => 'Tamamlanmış doktora tezinde asıl danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 4],
    'A5.a-es' => ['baslik' => 'Tamamlanmış doktora tezinde ikinci/eş danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 2],
    'A5.b' => ['baslik' => 'Tamamlanmış yüksek lisans tezinde asıl danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 2],
    'A5.b-es' => ['baslik' => 'Tamamlanmış yüksek lisans tezinde ikinci/eş danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 1],

    'A6.a' => ['baslik' => 'AB Çerçeve Programı projesinde koordinatör ya da baş araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 20],
    'A6.b' => ['baslik' => 'AB Çerçeve Programı projesinde ortak araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],
    'A6.c' => ['baslik' => 'Diğer uluslararası destekli projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 15],
    'A6.d' => ['baslik' => 'Diğer uluslararası destekli projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
    'A6.e' => ['baslik' => 'TÜBİTAK projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 15],
    'A6.f' => ['baslik' => 'TÜBİTAK projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
    'A6.g' => ['baslik' => 'Üniversite dışındaki kamu kurumlarıyla yapılan projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 10],
    'A6.h' => ['baslik' => 'Üniversite dışındaki kamu kurumlarıyla yapılan projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 8],
    'A6.i' => ['baslik' => 'BAP projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 8],
    'A6.j' => ['baslik' => 'BAP projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 6],
    'A6.k' => ['baslik' => 'Şirket ya da sivil toplum kuruluşu protokolüyle yürütülen projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 6],
    'A6.l' => ['baslik' => 'Şirket ya da sivil toplum kuruluşu protokolüyle yürütülen projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 4],

    'A7.a' => ['baslik' => 'Uluslararası bilimsel toplantıda tam metin yayımlanmış sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 10],
    'A7.c' => ['baslik' => 'Uluslararası bilimsel toplantıda özet bildiri ya da poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 1],
    'A7.d' => ['baslik' => 'Ulusal bilimsel toplantıda tam metin yayımlanmış sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 6],
    'A7.e' => ['baslik' => 'Ulusal bilimsel toplantıda özet bildiri ya da sözlü sunum', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 3],
    'A7.g' => ['baslik' => 'Bilimsel toplantı hazırlıklarında başkanlık ya da üyelik', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 2],
    'A7.j' => ['baslik' => 'Bilimsel toplantıda davetli ya da keynote konuşmacı olarak sunum', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 2],
    'A7.l' => ['baslik' => 'SCI, SCI-E, SSCI veya AHCI kapsamındaki dergide baş editörlük ya da editör yardımcılığı', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 4],
    'A7.m' => ['baslik' => 'Alan indeksli dergide baş editörlük ya da editör yardımcılığı', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi', 'Diğer Hakemli Dergi'], 'puan' => 3],
    'A7.o' => ['baslik' => 'ULAKBİM TR Dizin kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Yayın Kurulu Üyeliği'], 'puan' => 2],
    'A7.n' => ['baslik' => 'Dergi ya da kitap hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 2],

    'A8.a' => ['baslik' => 'Bir yarıyıl yüksek lisans veya doktora dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
    'A8.b' => ['baslik' => 'Bir yarıyıl ön lisans veya lisans dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 1],

    'A9' => ['baslik' => 'Üniversitenin akademik ve idari birimlerinde görev yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => $IDARI, 'puan' => 5],

    'A11.a' => ['baslik' => 'Teknopark ya da TEK-MER şirketinde kuluçka veya start-up şirketi kurmak', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 15],
    'A11.b' => ['baslik' => 'Kamu yararına çalışan vakıf, dernek ya da sivil toplum örgütünde toplum faydasına faaliyet', 'kategori' => 'toplumsal_katki', 'kaynaklar' => $TOPLUM, 'puan' => 5],

    'A12.a' => ['baslik' => 'Uluslararası yarışmalara katılan sinema ya da belgesel filminde yönetmenlik, yapımcılık veya senaryo yazarlığı (yalnızca İletişim Bilimleri)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $iletisimUluslararasi, 'puan' => 10],
    'A12.b' => ['baslik' => 'Ulusal yarışmalara katılan sinema ya da belgesel filminde yönetmenlik, yapımcılık veya senaryo yazarlığı (yalnızca İletişim Bilimleri)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $iletisimUlusal, 'puan' => 5],
    'A12.c' => ['baslik' => 'TV, gazete ya da tanıtım filmi yapımcılığı, yönetmenliği veya editörlüğü (yalnızca İletişim Bilimleri)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $iletisimDiger, 'puan' => 2],
];

$AGruplari = [
    'A1' => ['A1.1.a', 'A1.1.b', 'A1.1.c', 'A1.2.a', 'A1.2.b'],
    'A1.1' => ['A1.1.a', 'A1.1.b'],
    'A1.2.a' => ['A1.2.a'],
    'A2' => ['A2.a', 'A2.b', 'A2.c', 'A2.d', 'A2.e', 'A2.f', 'A2.g'],
    'A3' => ['A3.a', 'A3.b', 'A3.c', 'A3.d', 'A3.e', 'A3.f', 'A3.h', 'A3.j', 'A3.n'],
    'A4' => ['A4.a', 'A4.b', 'A4.c', 'A4.d'],
    'A5' => ['A5.a', 'A5.a-es', 'A5.b', 'A5.b-es'],
    'A6' => ['A6.a', 'A6.b', 'A6.c', 'A6.d', 'A6.e', 'A6.f', 'A6.g', 'A6.h', 'A6.i', 'A6.j', 'A6.k', 'A6.l'],
    'A7' => ['A7.a', 'A7.c', 'A7.d', 'A7.e', 'A7.g', 'A7.j', 'A7.l', 'A7.m', 'A7.o', 'A7.n'],
    'A8' => ['A8.a', 'A8.b'],
    'A9' => ['A9'],
    'A11' => ['A11.a', 'A11.b'],
    'A12' => ['A12.a', 'A12.b', 'A12.c'],
    'A-DR-TOPLAM' => ['A1', 'A2', 'A3', 'A4', 'A7'],
    'A-1-3-6' => ['A1', 'A3', 'A6'],
];

// ══════════════════════════════════════════════════════════════════════════
// EK-B — FEN BİLİMLERİ ALANI
// ══════════════════════════════════════════════════════════════════════════

$B = [
    'B1.a-Q1' => ['baslik' => 'SCI, SCI-E, SSCI veya AHCI kapsamındaki Q1 dergide tam araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale'], 'puan' => 40],
    'B1.a-Q2' => ['baslik' => 'SCI, SCI-E, SSCI veya AHCI kapsamındaki Q2 dergide tam araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale'], 'puan' => 30],
    'B1.a-Q3' => ['baslik' => 'SCI, SCI-E, SSCI veya AHCI kapsamındaki Q3 dergide tam araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => ['ozgun_makale'], 'puan' => 20],
    'B1.a-Q4' => ['baslik' => 'SCI, SCI-E, SSCI veya AHCI kapsamındaki Q4 dergide tam araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 10],
    'B1.b' => ['baslik' => 'Diğer uluslararası hakemli dergide tam araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale'], 'puan' => 10],
    'B1.c' => ['baslik' => 'ULAKBİM TR Dizin tarafından taranan ulusal hakemli dergide tam araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 10],
    'B1.d' => ['baslik' => 'SCI, SCI-E, SSCI veya AHCI kapsamındaki dergide kısa makale, derleme, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 10],
    'B1.e' => ['baslik' => 'Diğer uluslararası hakemli dergide kısa makale, derleme, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 4],
    'B1.f' => ['baslik' => 'ULAKBİM TR Dizin taranan dergide derleme, teknik not ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 2],

    'B2.a' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, SCI, SCI-E, SSCI veya AHCI kapsamındaki dergide tam araştırma makalesi', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 10],
    'B2.b' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, diğer uluslararası hakemli dergide tam araştırma makalesi', 'kategori' => 'tez_yayini', 'kaynaklar' => ['ESCI / Scopus', 'Diğer (Uluslararası)'], 'puan' => 5],
    'B2.c' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, ULAKBİM TR Dizin taranan dergide tam araştırma makalesi', 'kategori' => 'tez_yayini', 'kaynaklar' => ['TR Dizin'], 'puan' => 5],

    'B3.a' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanan özgün ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası Ders / Metot Kitabı'], 'puan' => 40],
    'B3.b' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanan bilimsel referans kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 30],
    'B3.c' => ['baslik' => 'Uluslararası yayınevi kitabında bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 20],
    'B3.d' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanan özgün bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 15],

    'B4.a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 40],
    'B4.b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 30],
    'B4.c' => ['baslik' => 'Faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 5],

    'B5.a' => ['baslik' => 'SCI, SCI-E, SSCI ve AHCI dergilerinde ya da uluslararası yayınevi kitaplarında adınıza yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 3],
    'B5.b' => ['baslik' => 'Diğer indeksli dergilerde adınıza yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer'], 'puan' => 2],
    'B5.c' => ['baslik' => 'Ulusal hakemli dergilerde ya da bildiri kitaplarında adınıza yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Patent'], 'puan' => 1],

    'B6.a' => ['baslik' => 'Tamamlanmış doktora tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 4],
    'B6.b' => ['baslik' => 'Tamamlanmış yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 2],

    'B7.a' => ['baslik' => 'AB Çerçeve Programı projesinde koordinatör ya da baş araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 30],
    'B7.b' => ['baslik' => 'AB Çerçeve Programı projesinde ortak araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],
    'B7.c' => ['baslik' => 'Diğer uluslararası destekli projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 16],
    'B7.d' => ['baslik' => 'Diğer uluslararası destekli projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 8],
    'B7.e' => ['baslik' => 'TÜBİTAK projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 16],
    'B7.f' => ['baslik' => 'TÜBİTAK projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 8],
    'B7.g' => ['baslik' => 'Üniversite dışındaki kamu kurumlarıyla yapılan projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 10],
    'B7.h' => ['baslik' => 'Üniversite dışındaki kamu kurumlarıyla yapılan projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 4],
    'B7.i' => ['baslik' => 'Üniversite dışındaki kamu kurumlarıyla yapılan projede danışman', 'kategori' => 'proje', 'kaynaklar' => ['TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['danisman'], 'puan' => 2],
    'B7.j' => ['baslik' => 'BAP projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 4],
    'B7.k' => ['baslik' => 'BAP projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 2],

    'B8.a' => ['baslik' => 'Uluslararası bilimsel toplantıda sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 3],
    'B8.b' => ['baslik' => 'Ulusal bilimsel toplantıda sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 2],
    'B8.c' => ['baslik' => 'Bilimsel toplantıda başkanlık, organizasyon, bilim ya da yönlendirme komitesi üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 2],
    'B8.e' => ['baslik' => 'Bilimsel toplantıda poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster', 'Ulusal Özet/Poster'], 'puan' => 1],
    'B8.f' => ['baslik' => 'Bilimsel toplantıda davetli ya da keynote konuşmacı olarak sunum', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 2],
    'B8.h' => ['baslik' => 'SCI, SCI-E, SSCI veya AHCI kapsamındaki dergide baş editörlük ya da editör yardımcılığı', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 6],
    'B8.i' => ['baslik' => 'Diğer uluslararası dergide baş editörlük, editör yardımcılığı ya da yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi', 'TR Dizin Dergi', 'Diğer Hakemli Dergi (Uluslararası)', 'Yayın Kurulu Üyeliği', 'BKCI Kitap', 'Kitap Editörlüğü'], 'puan' => 3],
    'B8.j' => ['baslik' => 'SCI, SCI-E, SSCI veya AHCI kapsamındaki dergide hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 2],

    'B9.a' => ['baslik' => 'Bir yarıyıl yüksek lisans veya doktora dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 4],
    'B9.b' => ['baslik' => 'Bir yarıyıl lisans dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 2],

    'B10' => ['baslik' => 'Üniversitenin akademik ve idari birimlerinde görev yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => $IDARI, 'puan' => 5],
];

$BGruplari = [
    'B1' => ['B1.a-Q1', 'B1.a-Q2', 'B1.a-Q3', 'B1.a-Q4', 'B1.b', 'B1.c', 'B1.d', 'B1.e', 'B1.f'],
    'B1.a' => ['B1.a-Q1', 'B1.a-Q2', 'B1.a-Q3', 'B1.a-Q4'],
    'B1.a-Q1Q2' => ['B1.a-Q1', 'B1.a-Q2'],
    'B1.a-Q3Q4' => ['B1.a-Q3', 'B1.a-Q4'],
    'B1.abc' => ['B1.a-Q1', 'B1.a-Q2', 'B1.a-Q3', 'B1.a-Q4', 'B1.b', 'B1.c'],
    'B2' => ['B2.a', 'B2.b', 'B2.c'],
    'B3' => ['B3.a', 'B3.b', 'B3.c', 'B3.d'],
    'B4' => ['B4.a', 'B4.b', 'B4.c'],
    'B5' => ['B5.a', 'B5.b', 'B5.c'],
    'B6' => ['B6.a', 'B6.b'],
    'B7' => ['B7.a', 'B7.b', 'B7.c', 'B7.d', 'B7.e', 'B7.f', 'B7.g', 'B7.h', 'B7.i', 'B7.j', 'B7.k'],
    'B7-TUBITAK-ULUSLARARASI' => ['B7.a', 'B7.b', 'B7.c', 'B7.d', 'B7.e', 'B7.f'],
    'B7-ULUSAL-YURUTUCU' => ['B7.g', 'B7.j'],
    'B7-HERHANGI' => ['B7.a', 'B7.b', 'B7.c', 'B7.d', 'B7.e', 'B7.f', 'B7.g', 'B7.h', 'B7.i', 'B7.j', 'B7.k'],
    'B8' => ['B8.a', 'B8.b', 'B8.c', 'B8.e', 'B8.f', 'B8.h', 'B8.i', 'B8.j'],
    'B9' => ['B9.a', 'B9.b'],
    'B10' => ['B10'],
];

$BTavanlari = ['B2' => 20, 'B3' => 45, 'B5' => 30, 'B7' => 40, 'B8' => 10, 'B9' => 10, 'B10' => 10];

// ══════════════════════════════════════════════════════════════════════════
// EK-C — SAĞLIK BİLİMLERİ ALANI (çeyreklik çarpanı cetvele gömüldü)
// ══════════════════════════════════════════════════════════════════════════

$C = [
    'C1.a-Q1' => ['baslik' => 'SSCI, SCI, SCI-E veya AHCI kapsamındaki Q1 dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['ozgun_makale'], 'puan' => 40],
    'C1.a-Q2' => ['baslik' => 'SSCI, SCI, SCI-E veya AHCI kapsamındaki Q2 dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['ozgun_makale'], 'puan' => 30],
    'C1.a-Q34' => ['baslik' => 'SSCI, SCI, SCI-E veya AHCI kapsamındaki Q3 ya da Q4 dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale'], 'puan' => 20],
    'C1.b' => ['baslik' => 'Diğer uluslararası indeksli dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale'], 'puan' => 10],
    'C1.c-Q1' => ['baslik' => 'SSCI, SCI, SCI-E veya AHCI kapsamındaki Q1 dergide olgu sunumu ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['derleme'], 'puan' => 10],
    'C1.c-Q2' => ['baslik' => 'SSCI, SCI, SCI-E veya AHCI kapsamındaki Q2 dergide olgu sunumu ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['derleme'], 'puan' => 7],
    'C1.c-Q34' => ['baslik' => 'SSCI, SCI, SCI-E veya AHCI kapsamındaki Q3 ya da Q4 dergide olgu sunumu ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['derleme'], 'puan' => 5],
    'C1.d' => ['baslik' => 'Diğer uluslararası indeksli dergide olgu sunumu ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['derleme'], 'puan' => 3],
    'C1.e-Q1' => ['baslik' => 'SSCI, SCI, SCI-E veya AHCI kapsamındaki Q1 dergide editöre mektup ya da kısa yayın', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 4],
    'C1.e-Q2' => ['baslik' => 'SSCI, SCI, SCI-E veya AHCI kapsamındaki Q2 dergide editöre mektup ya da kısa yayın', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 3],
    'C1.e-Q34' => ['baslik' => 'SSCI, SCI, SCI-E veya AHCI kapsamındaki Q3 ya da Q4 dergide editöre mektup ya da kısa yayın', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI', 'ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 2],

    'C2.a' => ['baslik' => 'ULAKBİM TR Dizin taranan ulusal hakemli dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 10],
    'C2.b' => ['baslik' => 'Diğer ulusal hakemli dergide özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale'], 'puan' => 6],
    'C2.c' => ['baslik' => 'ULAKBİM TR Dizin taranan ulusal hakemli dergide olgu sunumu ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 5],
    'C2.d' => ['baslik' => 'Diğer ulusal hakemli dergide olgu sunumu ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['derleme', 'kisa_makale', 'vaka_teknik_not'], 'puan' => 3],

    'C3.a' => ['baslik' => 'Lisansüstü ya da tıpta uzmanlık tezinizden üretilmiş, SSCI, SCI, SCI-E veya AHCI dergide özgün araştırma makalesi', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 10],
    'C3.b' => ['baslik' => 'Tezinizden üretilmiş, uluslararası alan indeksli dergide özgün araştırma makalesi', 'kategori' => 'tez_yayini', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 5],
    'C3.c' => ['baslik' => 'Tezinizden üretilmiş, ULAKBİM taranan dergide özgün araştırma makalesi', 'kategori' => 'tez_yayini', 'kaynaklar' => ['TR Dizin'], 'puan' => 5],
    'C3.d' => ['baslik' => 'Tezinizden üretilmiş, diğer ulusal hakemli dergide özgün araştırma makalesi', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Diğer'], 'puan' => 3],
    'C3.e' => ['baslik' => 'Tezinizden üretilmiş, sempozyum ya da kongrede sunulmuş bildiri', 'kategori' => 'tez_yayini', 'kaynaklar' => ['CPCI Bildiri'], 'puan' => 1],
    'C3.k' => ['baslik' => 'Tezinizden üretilmiş kitap ya da kitap bölümü', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap', 'BKCI / Scopus Kitap Bölümü', 'Uluslararası/Ulusal Kitap', 'Kitap Bölümü'], 'puan' => 3],

    'C4.a' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
    'C4.b' => ['baslik' => 'Uluslararası yayınevi kitabının (ya da çeviri kitabın) editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 6],
    'C4.c' => ['baslik' => 'Uluslararası yayınevi kitabında (ya da çeviri kitapta) bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 6],
    'C4.d' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı'], 'puan' => 15],
    'C4.e' => ['baslik' => 'Ulusal yayınevi kitabının editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 5],
    'C4.f' => ['baslik' => 'Ulusal yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 6],
    'C4.h' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış çeviri kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 8],
    'C4.j' => ['baslik' => 'Çeviri kitapta bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 6],

    'C5.a' => ['baslik' => 'SCI, SCI-E, SSCI ve AHCI dergilerinde ya da uluslararası yayınevi kitaplarında eserlerinize yapılan her atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 1],

    'C6.a' => ['baslik' => 'Tamamlanmış doktora ya da tıpta uzmanlık tezinde asıl danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 8],
    'C6.a-es' => ['baslik' => 'Tamamlanmış doktora ya da tıpta uzmanlık tezinde ikinci/eş danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 4],
    'C6.b' => ['baslik' => 'Tamamlanmış yüksek lisans tezinde asıl danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 4],
    'C6.b-es' => ['baslik' => 'Tamamlanmış yüksek lisans tezinde ikinci/eş danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 2],

    'C7.a' => ['baslik' => 'AB Çerçeve Programı projesinde koordinatör ya da baş araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 20],
    'C7.b' => ['baslik' => 'AB Çerçeve Programı projesinde ortak araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],
    'C7.c' => ['baslik' => 'Diğer uluslararası destekli projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 15],
    'C7.j' => ['baslik' => 'Uluslararası klinik projede araştırmacı ya da yardımcı araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
    'C7.d' => ['baslik' => 'TÜBİTAK ya da TÜSEB projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 12],
    'C7.e' => ['baslik' => 'TÜBİTAK ya da TÜSEB projesinde araştırmacı veya danışman', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
    'C7.f' => ['baslik' => 'Üniversite dışındaki kamu kurumlarıyla yapılan projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 10],
    'C7.g' => ['baslik' => 'Üniversite dışındaki kamu kurumlarıyla yapılan projede araştırmacı veya danışman', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 8],
    'C7.h' => ['baslik' => 'BAP projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 4],
    'C7.i' => ['baslik' => 'BAP projesinde araştırmacı veya danışman', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 2],

    'C8.a' => ['baslik' => 'Uluslararası bilimsel toplantıda sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 10],
    'C8.b' => ['baslik' => 'Ulusal bilimsel toplantıda sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 5],
    'C8.c' => ['baslik' => 'Bilimsel toplantı düzenleme kurulunda ya da başkanlığında görev almak', 'kategori' => 'diger', 'kaynaklar' => ['Diğer', 'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 2],
    'C8.d' => ['baslik' => 'Uluslararası bilimsel toplantıda poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 5],
    'C8.e' => ['baslik' => 'Ulusal bilimsel toplantıda poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 3],
    'C8.f' => ['baslik' => 'Bilimsel toplantıda davetli konuşmacı olarak sunum', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 4],
    'C8.i' => ['baslik' => 'SCI, SCI-E, SSCI veya AHCI kapsamındaki dergide baş editörlük, editör yardımcılığı ya da editörler kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 6],
    'C8.j' => ['baslik' => 'Diğer dergilerde baş editörlük, editör yardımcılığı, editörler kurulu üyeliği ya da hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi', 'TR Dizin Dergi', 'Diğer Hakemli Dergi', 'Yayın Kurulu Üyeliği', 'Hakemlik'], 'puan' => 3],

    'C9.a' => ['baslik' => 'Bir dönem yüksek lisans, doktora ya da tıpta uzmanlık dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
    'C9.b' => ['baslik' => 'Bir dönem ön lisans veya lisans dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 2],

    'C10' => ['baslik' => 'Üniversitenin akademik ve idari birimlerinde görev yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => $IDARI, 'puan' => 5],

    'C11.a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 40],
    'C11.b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 30],
    'C11.c' => ['baslik' => 'Faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 5],

    'C12.a' => ['baslik' => 'Teknopark ya da TEK-MER şirketinde kuluçka veya start-up şirketi kurmak', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 20],
    'C12.b' => ['baslik' => 'Kamu yararına çalışan vakıf, dernek ya da sivil toplum kuruluşunda görev almak; sosyal sorumluluk projesi yürütmek', 'kategori' => 'toplumsal_katki', 'kaynaklar' => $TOPLUM, 'puan' => 5],
];

$CGruplari = [
    'C1' => ['C1.a-Q1', 'C1.a-Q2', 'C1.a-Q34', 'C1.b', 'C1.c-Q1', 'C1.c-Q2', 'C1.c-Q34', 'C1.d', 'C1.e-Q1', 'C1.e-Q2', 'C1.e-Q34'],
    'C1.a' => ['C1.a-Q1', 'C1.a-Q2', 'C1.a-Q34'],
    'C1.b' => ['C1.b'],
    'C2' => ['C2.a', 'C2.b', 'C2.c', 'C2.d'],
    'C3' => ['C3.a', 'C3.b', 'C3.c', 'C3.d', 'C3.e', 'C3.k'],
    'C3.a' => ['C3.a'],
    'C4' => ['C4.a', 'C4.b', 'C4.c', 'C4.d', 'C4.e', 'C4.f', 'C4.h', 'C4.j'],
    'C5' => ['C5.a'],
    'C6' => ['C6.a', 'C6.a-es', 'C6.b', 'C6.b-es'],
    'C7' => ['C7.a', 'C7.b', 'C7.c', 'C7.j', 'C7.d', 'C7.e', 'C7.f', 'C7.g', 'C7.h', 'C7.i'],
    'C8' => ['C8.a', 'C8.b', 'C8.c', 'C8.d', 'C8.e', 'C8.f', 'C8.i', 'C8.j'],
    'C9' => ['C9.a', 'C9.b'],
    'C10' => ['C10'],
    'C11' => ['C11.a', 'C11.b', 'C11.c'],
    'C12' => ['C12.a', 'C12.b'],
    'C1-C2' => ['C1', 'C2'],
];

$CTavanlari = ['C4' => 35, 'C5' => 50, 'C6' => 20, 'C7' => 30, 'C8' => 15, 'C9' => 15, 'C10' => 10, 'C11' => 50, 'C12' => 25];

// ══════════════════════════════════════════════════════════════════════════
// EK-D — GÜZEL SANATLAR ALANI (genel + özel başvuru şartları)
// ══════════════════════════════════════════════════════════════════════════

$dKisisel = ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Ulusal)',
    'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)',
    'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)',
    'Elektronik Kişisel Sergi (Uluslararası)', 'Elektronik Kişisel Sergi (Ulusal)'];
$dFilm = ['Belgesel/Kısa Film (Uluslararası)', 'Belgesel/Kısa Film (Ulusal)',
    'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)',
    'Yönetmenlik (Sahne/Ekran)'];
$dKarmaUluslararasi = ['Karma/Jürili Etkinlik (Uluslararası)', 'Elektronik Karma Sergi (Uluslararası)',
    'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)',
    'Sempozyum/Çalıştay/Bienal (Yurt Dışı)'];
$dKarmaUlusal = ['Karma/Jürili Etkinlik (Ulusal)', 'Elektronik Karma Sergi (Ulusal)',
    'Karma Etkinlik (Jürisiz, Ulusal)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)',
    'Sempozyum/Çalıştay/Bienal (Yurt İçi)'];
$dDaimi = ['Eserin Müzeye Kabulü (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt İçi)',
    'Eserin Yayında Yer Alması / Satın Alınması', 'Eserin Satın Alınması (Yurt İçi)',
    'Eserin Haber Olması (Uluslararası)', 'Eserin Haber Olması (Ulusal)'];
$dTasarim = ['Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip',
    'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman',
    'Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)'];
$dAtolye = ['Masterclass (Uluslararası)', 'Masterclass (Ulusal)', 'Müzikoloji Atölyesi',
    'Eğitim Amaçlı Sanat Etkinliği', 'Eğitici Konser Programı (Uluslararası)',
    'Eğitici Konser Programı (Ulusal)'];
$dBeste = ['Opera/Bale Kompozisyonu', 'Orkestralı Sahne Eseri', 'Senfoni Kompozisyonu',
    'Konçerto/Senfonik Şiir', 'Küçük Ölçekli Orkestra Eseri', 'Oda/Koro Müziği Eseri (≥15 dk)',
    'Oda/Koro Müziği Eseri (<15 dk)', 'Elektronik Müzik Eseri (≥15 dk)',
    'Elektronik Müzik Eseri (<15 dk)', 'Sahne/Ekran Müziği'];
$dEgitimMuzigi = ['Eğitim Müziği Albümü', 'Orkestrasyon/Transkripsiyon', 'Eğitim Müziği Düzenlemesi'];
$dAlbum = ['Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)'];
$dSolo = ['Solistlik (Uluslararası)', 'Solistlik (Ulusal)', 'Resital (Uluslararası)', 'Resital (Ulusal)',
    'Şan Resitali (Uluslararası)', 'Şan Resitali (Ulusal)'];
$dKarmaKonser = ['Oda Müziği Grup Üyeliği (Uluslararası)', 'Oda Müziği Grup Üyeliği (Ulusal)',
    'Orkestra / Koro Üyeliği', 'Karma Albüm / CD-DVD Katkısı',
    'Başkemancılık (Uluslararası)', 'Başkemancılık (Ulusal)'];
$dSeflik = ['Orkestra Şefliği (Uluslararası)', 'Orkestra Şefliği (Ulusal)',
    'Opera Şefliği (Uluslararası)', 'Opera Şefliği (Ulusal)',
    'Bale Orkestra Şefliği (Uluslararası)', 'Bale Orkestra Şefliği (Ulusal)',
    'Koro Şefliği (Uluslararası)', 'Koro Şefliği (Ulusal)',
    'Grup Şefliği (Uluslararası)', 'Grup Şefliği (Ulusal)'];
$dOpera = ['Opera Birinci Rol (Uluslararası)', 'Opera Birinci Rol (Ulusal)',
    'Opera İkinci Rol (Uluslararası)', 'Opera İkinci Rol (Ulusal)',
    'Oratoryo/Kantat Solistliği (Uluslararası)', 'Oratoryo/Kantat Solistliği (Ulusal)'];
$dReji = ['Rejisörlük (Uluslararası)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)',
    'Rejisör Yardımcılığı (Uluslararası)', 'Rejisör Yardımcılığı (Ulusal)',
    'Rejisör Yardımcılığı (Konservatuvar)'];

$dKullanilan = array_merge($dKisisel, $dFilm, $dKarmaUluslararasi, $dKarmaUlusal, $dDaimi,
    $dTasarim, $dAtolye, $dBeste, $dEgitimMuzigi, $dAlbum, $dSolo, $dKarmaKonser, $dSeflik,
    $dOpera, $dReji);
$dKalan = array_values(array_diff(Kategori::SanatselEtkinlik->kaynaklar(), $dKullanilan));

$D = [
    // ── GENEL BAŞVURU ŞARTLARI ──
    'D-G1.a' => ['baslik' => 'SCI, SCIE, SSCI veya AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 30],
    'D-G1.b' => ['baslik' => 'ESCI, Scopus veya ERIC kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 20],
    'D-G1.c' => ['baslik' => 'Diğer uluslararası indekslerde taranan dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 10],
    'D-G1.d' => ['baslik' => 'Uluslararası dergide editöre mektup, araştırma notu, özet ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => [...$SCI, 'ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 2],
    'D-G2.a' => ['baslik' => 'ULAKBİM TR Dizin kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 10],
    'D-G2.b' => ['baslik' => 'Diğer ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 6],

    'D-G3.a' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, SCI-E, SSCI veya AHCI kapsamındaki dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 25],
    'D-G3.b' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, ESCI, Scopus veya ERIC kapsamındaki dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 15],
    'D-G3.c' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, diğer uluslararası indeksli dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Diğer (Uluslararası)', 'CPCI Bildiri'], 'puan' => 10],
    'D-G3.d' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, ULAKBİM TR Dizin kapsamındaki dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['TR Dizin'], 'puan' => 5],
    'D-G3.e' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, uluslararası yayınevi kitabı', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 10],
    'D-G3.f' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, uluslararası yayınevi kitabında bölüm', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 8],
    'D-G3.g' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, ulusal yayınevi kitabı', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 5],
    'D-G3.h' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, ulusal yayınevi kitabında bölüm', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 4],

    'D-G4.a' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 30],
    'D-G4.b' => ['baslik' => 'Uluslararası yayınevi tarafından yayımlanmış kitabın editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 15],
    'D-G4.c' => ['baslik' => 'Uluslararası yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 15],
    'D-G4.d' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı', 'Çeviri Kitap'], 'puan' => 10],
    'D-G4.e' => ['baslik' => 'Ulusal yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Çeviri Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 5],
    'D-G4.f' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitabın editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 5],

    'D-G5.a' => ['baslik' => 'SCI-E, SSCI, AHCI dergilerinde eserlerinize yapılan her atıf', 'kategori' => 'atif', 'kaynaklar' => ['SCIE/SSCI/AHCI', 'ESCI'], 'puan' => 5],
    'D-G5.b' => ['baslik' => 'ESCI, Scopus veya ERIC dergilerinde eserlerinize yapılan her atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer'], 'puan' => 4],
    'D-G5.c' => ['baslik' => 'Uluslararası kitaplarda ya da TR Dizin dergilerinde eserlerinize yapılan her atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap', 'TR Dizin'], 'puan' => 3],
    'D-G5.d' => ['baslik' => 'Diğer uluslararası ya da ulusal kitap ve dergilerde eserlerinize yapılan her atıf', 'kategori' => 'atif', 'kaynaklar' => ['Patent'], 'puan' => 1],

    'D-G6.a' => ['baslik' => 'Danışmanlığınızda tamamlanan doktora tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 4],
    'D-G6.b' => ['baslik' => 'Danışmanlığınızda tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 2],
    'D-G6.c' => ['baslik' => 'Tez izleme komitesi ya da jüri üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 1],

    'D-G7.a-y' => ['baslik' => 'AB Çerçeve Programı ya da TÜBİTAK projesinde koordinatör veya yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 20],
    'D-G7.a-a' => ['baslik' => 'AB Çerçeve Programı ya da TÜBİTAK projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 15],
    'D-G7.a-d' => ['baslik' => 'AB Çerçeve Programı ya da TÜBİTAK projesinde danışman', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['danisman'], 'puan' => 5],
    'D-G7.b' => ['baslik' => 'Uluslararası destekli araştırma projesinde yürütücü, araştırmacı ya da danışman', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'puan' => 10],
    'D-G7.c' => ['baslik' => 'Kamu kurumu ya da özel kuruluşla yapılan Ar-Ge projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => ['TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'puan' => 5],
    'D-G7.d' => ['baslik' => 'BAP projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 3],
    'D-G7.e' => ['baslik' => 'BAP projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 2],

    'D-G8.a' => ['baslik' => 'Uluslararası bilimsel toplantıda tam metin yayımlanmış sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 8],
    'D-G8.b' => ['baslik' => 'Uluslararası bilimsel toplantıda özet bildiri ya da poster', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 1],
    'D-G8.c' => ['baslik' => 'Ulusal bilimsel toplantıda tam metin yayımlanmış sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 6],
    'D-G8.d' => ['baslik' => 'Ulusal bilimsel toplantıda özet bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 3],
    'D-G8.e' => ['baslik' => 'Bilimsel toplantı hazırlıklarında görev almak', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 4],
    'D-G8.g' => ['baslik' => 'Bilimsel toplantıda davetli ya da keynote konuşmacı olarak sunum', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 2],

    'D-G9.a' => ['baslik' => 'Bir yarıyıl yüksek lisans veya doktora dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 2],
    'D-G9.b' => ['baslik' => 'Bir yarıyıl ön lisans, lisans ya da üniversite ortak seçmeli dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 2],

    'D-G10' => ['baslik' => 'Üniversitenin akademik ve idari birimlerinde görev yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => $IDARI, 'puan' => 5],

    'D-G11.a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 40],
    'D-G11.b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 30],
    'D-G11.c' => ['baslik' => 'Faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili', 'Ticarileştirme'], 'puan' => 5],

    'D-G12.a' => ['baslik' => 'YÖK Yılın Doktora Tezi ya da Üstün Başarı Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü'], 'puan' => 25],
    'D-G12.c' => ['baslik' => 'TÜBİTAK Bilim ya da Teşvik Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü'], 'puan' => 15],
    'D-G12.e' => ['baslik' => 'TÜBA GEBİP ya da TESEP Ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBA GEBİP / TWAS Teşvik Ödülü', 'Ufuk Avrupa / ERC Ödülü', 'Uluslararası Bilim/Sanat Ödülü', 'Ulusal Bilim/Sanat Ödülü', 'Yarışma Derecesi / Mansiyon', 'Burs'], 'puan' => 5],

    // ── ÖZEL BAŞVURU ŞARTLARI (sanatsal etkinlik) ──
    'D-O1.a' => ['baslik' => 'Özgün sanat eseri, tasarım ya da yorum çalışmalarıyla kişisel sergi açmak veya koleksiyon sunumu yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $dKisisel, 'puan' => 20],
    'D-O1.b' => ['baslik' => 'Festivale seçilmiş ya da özel gösterimi yapılmış filmde yönetmenlik veya görüntü yönetmenliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $dFilm, 'puan' => 10],
    'D-O1.c' => ['baslik' => 'Workshop düzenlemek, yönetmek ya da workshopta yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $dAtolye, 'puan' => 5],
    'D-O1.d' => ['baslik' => 'Uluslararası statüde karma etkinlikte eserlerinizle yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $dKarmaUluslararasi, 'puan' => 8],
    'D-O1.e' => ['baslik' => 'Ulusal statüde karma etkinlikte eserlerinizle yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $dKarmaUlusal, 'puan' => 5],
    'D-O1.f' => ['baslik' => 'Eserinizin kamusal alanda veya müzede daimî olarak sergilenmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $dDaimi, 'puan' => 5],
    'D-O1.g' => ['baslik' => 'Kamu kurumları ya da tüzel kişiler bünyesinde tasarım yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $dTasarim, 'puan' => 5],
    'D-O2.a' => ['baslik' => 'Özgün eser üretmek (solo çalgı, oda müziği, orkestra, sahne, vokal ya da elektronik müzik)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $dBeste, 'puan' => 20],
    'D-O2.b' => ['baslik' => 'Eğitim müziği dağarcığı, düzenleme ya da transkripsiyon üretmek', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $dEgitimMuzigi, 'puan' => 10],
    'D-O3.b' => ['baslik' => 'Bandrollü ya da dijital albüm yayımlamak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $dAlbum, 'puan' => 15],
    'D-O3.d' => ['baslik' => 'Solo, karma ya da koro konserinde icracı olarak bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => [...$dSolo, ...$dKarmaKonser], 'puan' => 5],
    'D-O6.a' => ['baslik' => 'Orkestra, opera, bale ya da koro şefliği yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $dSeflik, 'puan' => 20],
    'D-O9.a' => ['baslik' => 'Sahnelenmiş opera eserinde solist icracı olarak bulunmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $dOpera, 'puan' => 20],
    'D-O9.b' => ['baslik' => 'Opera eseri sahnelemek (rejisörlük)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $dReji, 'puan' => 20],
    'D-O9.d' => ['baslik' => 'Sahne etkinliğinde icracı ya da yürütücü olarak yer almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $dKalan, 'puan' => 5],
];

$DGruplari = [
    'D-G1' => ['D-G1.a', 'D-G1.b', 'D-G1.c', 'D-G1.d'],
    'D-G1.ab' => ['D-G1.a', 'D-G1.b'],
    'D-G1.c' => ['D-G1.c'],
    'D-G2' => ['D-G2.a', 'D-G2.b'],
    'D-G2.a' => ['D-G2.a'],
    'D-G3' => ['D-G3.a', 'D-G3.b', 'D-G3.c', 'D-G3.d', 'D-G3.e', 'D-G3.f', 'D-G3.g', 'D-G3.h'],
    'D-G4' => ['D-G4.a', 'D-G4.b', 'D-G4.c', 'D-G4.d', 'D-G4.e', 'D-G4.f'],
    'D-G4.a' => ['D-G4.a'],
    'D-G4.c' => ['D-G4.c'],
    'D-G5' => ['D-G5.a', 'D-G5.b', 'D-G5.c', 'D-G5.d'],
    'D-G6' => ['D-G6.a', 'D-G6.b', 'D-G6.c'],
    'D-G7' => ['D-G7.a-y', 'D-G7.a-a', 'D-G7.a-d', 'D-G7.b', 'D-G7.c', 'D-G7.d', 'D-G7.e'],
    'D-G8' => ['D-G8.a', 'D-G8.b', 'D-G8.c', 'D-G8.d', 'D-G8.e', 'D-G8.g'],
    'D-G9' => ['D-G9.a', 'D-G9.b'],
    'D-G10' => ['D-G10'],
    'D-G11' => ['D-G11.a', 'D-G11.b', 'D-G11.c'],
    'D-G12' => ['D-G12.a', 'D-G12.c', 'D-G12.e'],
    'D-GENEL' => ['D-G1', 'D-G2', 'D-G3', 'D-G4', 'D-G5', 'D-G6', 'D-G7', 'D-G8', 'D-G9',
        'D-G10', 'D-G11', 'D-G12'],
    'D-G1-G2' => ['D-G1', 'D-G2'],

    // Özel başvuru şartları: plastik sanatlar 1. madde, müzik 2a-9a bentleri.
    'D-O1' => ['D-O1.a', 'D-O1.b', 'D-O1.c', 'D-O1.d', 'D-O1.e', 'D-O1.f', 'D-O1.g'],
    'D-O1.a' => ['D-O1.a'],
    'D-MUZIK' => ['D-O2.a', 'D-O2.b', 'D-O3.b', 'D-O3.d', 'D-O6.a', 'D-O9.a', 'D-O9.b', 'D-O9.d'],
    'D-MUZIK-ANA' => ['D-O2.a', 'D-O3.b', 'D-O6.a', 'D-O9.a', 'D-O9.b'],
    'D-OZEL' => ['D-O1', 'D-MUZIK'],
];

$DTavanlari = ['D-G5' => 20, 'D-G6' => 10, 'D-G7' => 30, 'D-G9' => 10, 'D-G10' => 10];

// ══════════════════════════════════════════════════════════════════════════

$not = fn (string $ek, string $ozel): string => 'Puanlar İzmir Kâtip Çelebi Üniversitesi Akademik '
    ."Atama ve Yükseltme Kriterleri {$ek} Değerlendirme Puan Tablosundan. Yönerge çok yazarlı "
    .'çalışmalarda sıraya bağlı bir kural vermiyor; kitap ve patent satırlarındaki "puan isim '
    .'sayısına bölünür" kuralı bütün yayın kalemlerine 1/n olarak uygulandı. Yazar listesini boş '
    .'bırakırsanız çarpan hiç uygulanmaz ve puanınız olduğundan YÜKSEK görünür. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: dergi editörlüklerinin "her sayı/her yıl '
    .'için" çarpanı ve idari görevin süre çarpanı hesaplanamadığı için görev başına tek değer '
    .'sayılıyor; editör, editör yardımcısı ve misafir editör ayrımı ile davetli konuşmalarda '
    .'uluslararası-ulusal ayrımı kayıttan okunamadığı için en düşük değerden sayılıyor. '
    .$ozel
    .' Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünebilir: "aynı toplantıda en fazla bir bildiri '
    .'puanlanır" ve "aynı ISBN\'li eserde en fazla iki bölüm" gibi ESER BAZLI sınırlar '
    .'uygulanmıyor; atıf puanı yönergede eser başına verilirken kayıt atıf başına tutuluyor.';

$cetveller = [];

// EK-A üç kadro varyantı: yüzdeye bağlı tavanlar asgari puandan hesaplandı.
$AVaryantlari = [
    'dr' => [
        'tavan' => ['A3' => 15, 'A4' => 12, 'A5' => 5, 'A7' => 10],
        'not' => 'Yönergenin yüzdeye bağlı tavanları bu kadronun asgari puanına (50) göre sayıya '
            .'çevrildi ve aşağı yuvarlandı: kitap 15, atıf 12, tez danışmanlığı 5, bilimsel '
            .'toplantı 10 puan.',
    ],
    'docent' => [
        'tavan' => ['A2' => 0],
        'not' => 'DİKKAT: EK-A doçentlik başvurusunda asgari puan yönergede yazılı değil, "kurul '
            .'tarafından ilan edilen asgari puan" deniyor; bu yüzden 3., 4., 5. ve 7. maddelerin '
            .'yüzdeye bağlı tavanları (asgari puanın %30/%25/%10/%20\'si) uygulanamadı ve '
            .'doçentlik puan barajı hesaplanamıyor olarak işaretlendi. Tablonun 2. maddesi '
            .'(lisansüstü tezlerden üretilmiş yayın) yalnızca Dr. Öğretim Üyesi atamalarında '
            .'geçerli olduğu için bu kadroda hiç sayılmıyor.',
    ],
    'profesor' => [
        'tavan' => ['A3' => 60, 'A4' => 50, 'A5' => 20, 'A7' => 40, 'A2' => 0],
        'not' => 'Yönergenin yüzdeye bağlı tavanları bu kadronun asgari puanına (200) göre sayıya '
            .'çevrildi: kitap 60, atıf 50, tez danışmanlığı 20, bilimsel toplantı 40 puan. '
            .'Tablonun 2. maddesi (lisansüstü tezlerden üretilmiş yayın) yalnızca Dr. Öğretim '
            .'Üyesi atamalarında geçerli olduğu için bu kadroda hiç sayılmıyor.',
    ],
];

foreach ($AVaryantlari as $kadro => $varyant) {
    $cetveller["ikcu-2023-sosyal-{$kadro}"] = [
        'kapsam_notu' => $not('EK-A (Sosyal Bilimler Alanı)', $varyant['not']),
        'yazar_katsayisi' => $yazarKatsayisi,
        'maddeler' => $A,
        'gruplar' => $AGruplari,
        'grup_tavanlari' => array_merge(
            ['A8' => 12, 'A9' => 10, 'A11' => 15, 'A12' => 15],
            $varyant['tavan'],
        ),
    ];
}

$cetveller['ikcu-2023-fen'] = [
    'kapsam_notu' => $not('EK-B (Fen Bilimleri Alanı)',
        'EK-B\'de eş danışmanlığa, ulusal yayınevi kitap bölümüne, kitap editörlüğüne, çeviri '
        .'kitaba ve ansiklopedi maddesine karşılık gelen satır YOK; bu kalemler yönergede '
        .'gerçekten puansız. Ticarileşen patentin puanının 3 ile çarpılması kuralı da '
        .'uygulanmıyor.'),
    'yazar_katsayisi' => $yazarKatsayisi,
    'maddeler' => $B,
    'gruplar' => $BGruplari,
    'grup_tavanlari' => $BTavanlari,
];

$cetveller['ikcu-2023-saglik'] = [
    'kapsam_notu' => $not('EK-C (Sağlık Bilimleri Alanı)',
        'Çeyreklik çarpanı (Q1 2 kat, Q2 1,5 kat) cetvele gömüldü ve çarpım §0 uyarınca aşağı '
        .'yuvarlandı. Tezden üretilmiş yayınlarda çeyreklik bilgisi kayıtta olmadığı için çarpan '
        .'HİÇ uygulanmıyor; tezinizden üretilmiş Q1 makalenizin puanı olduğundan düşük görünür. '
        .'Atıf bölümünde yalnızca 1 puanlık satır girilebildi: 0,5 puanlık atıf satırları aşağı '
        .'yuvarlandığında sıfırlandığı için yazılmadı, bu yüzden SCI dışı atıflarınız hiç '
        .'sayılmıyor.'),
    'yazar_katsayisi' => $yazarKatsayisi,
    'maddeler' => $C,
    'gruplar' => $CGruplari,
    'grup_tavanlari' => $CTavanlari,
];

$cetveller['ikcu-2023-gsf'] = [
    'kapsam_notu' => $not('EK-D (Güzel Sanatlar Alanı)',
        'EK-D özel başvuru şartlarının puanı bir PORTFÖYE bağlı satırları (en az 10 eserlik '
        .'kişisel sergi, dört saatlik şeflik kaydı, iki opera eseri gibi) eser başına '
        .'bölünemediği için etkinlik başına en düşük okunabilir değerden girildi. Alt disiplin '
        .'(plastik sanatlar, müzik, sahne) kayıtta tutulmadığı için aynı türe farklı puan veren '
        .'satırlarda en düşük değer alındı: solo ve karma konser icracılığı 5 puandan '
        .'sayılıyor.'),
    'yazar_katsayisi' => $yazarKatsayisi,
    'maddeler' => $D,
    'gruplar' => $DGruplari,
    'grup_tavanlari' => $DTavanlari,
];

return ['cetveller' => $cetveller];
