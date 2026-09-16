<?php

/**
 * ANKARA SOSYAL BİLİMLER ÜNİVERSİTESİ — Bilimsel Yayın, Araştırma ve
 * Etkinlik Puan Tablosu
 * Kaynak: pdf/17634002431.Ankara Sosyal Bilimler Üniversitesi Kriter.pdf
 *
 * Madde kodları esasların kendi kodlaması (A.1, B.3, G.7 …); projelerde
 * rol ayrımı zaten kodlarda var.
 *
 * ── ÖDÜL SATIRLARI ÜÇÜNCÜLÜK DEĞERİYLE GİRİLDİ (§0) ──
 * F bölümünün dipnotu "birincilik ödülü için puanın tamamı, ikincilik
 * için %80'i, üçüncülük için %70'i kabul edilir" diyor. Kayıt ödülün
 * derecesini taşımadığı için bütün ödül satırlarına %70 uygulandı:
 * F.1 30 → 21, F.2 20 → 14, F.3 5 → 3, F.5 2 → 1.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   Kitapta B.3 (uluslararası, 15) ile B.5 (ulusal, 20) tek
 *       'Uluslararası/Ulusal Kitap' etiketine düşüyor → 15; bölümde B.4
 *       ile B.6 zaten aynı puanda (10).
 *   Kitap editörlüğünde C.2 (15) ile C.3 (10) → 10.
 *   Atıfta I.1 (SCI, 3) ile I.3 (ESCI-Scopus, 2) tek 'WoS / Scopus'
 *       etiketine düşüyor → 2.
 *   Bildiride 'Davetli Konuşmacı' etiketinin karşılığı yok; en düşük
 *       bildiri satırından (E.4, 2 puan) sayılıyor.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   D.11 (projelere başvuruda bulunmuş olmak, 2 puan) — kabul edilmiş
 *       projeden ayrılamıyor.
 *   G.1 (doktora sonrası dünyada ilk 500 üniversitede iki dönem bulunmak,
 *       10 puan) — faaliyet değil süre ölçütü.
 *   C.8 ve C.9 (uluslararası ve ulusal konferans kitabı editörlüğü, 3 ve
 *       2 puan) ile H.1 (makale çevirisi, 5 puan) — sözlükte karşılıksız.
 *   Ders kitapları ve özgün nitelikte olmayan derleme kitaplar — B ve C
 *       bölümlerinin dipnotu bunları AÇIKÇA dışlıyor, bu yüzden
 *       'Ders / Metot Kitabı' etiketine hiçbir satır bağlanmadı: ders
 *       kitabı bu üniversitede puansız.
 *   PATENT, SANATSAL ETKİNLİK ve TOPLUMSAL KATKI kalemlerinin tamamı —
 *       tabloda hiç yok; bu kayıtlarınız toplam puana katkı vermiyor.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   Yayınevi tanımlarındaki "en az dört yıl düzenli faaliyet", "dünyada
 *       ilk 500 üniversite kütüphanesinde kataloglanmış" ve "aynı alanda
 *       en az 20 kitap yayımlamış" şartları.
 *   Doktor öğretim üyeliğine yeniden atamada "asgari yayın şartları
 *       lisansüstü tezlerden üretilmemiş olmalıdır" kaydı — kayıt yayının
 *       tezden üretildiğini taşımıyor, beyan olarak yazıldı.
 *
 * Yönerge: yonerge/asbu.php
 */
$TAM = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];
$WOS = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];
$ALAN_INDEKS = ['ESCI / Scopus', 'Diğer Uluslararası İndeks'];
$BAP = ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'];
$KAMU_OZEL = ['TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'];

return [
    'kapsam_notu' => 'Puanlar Ankara Sosyal Bilimler Üniversitesi Öğretim Üyeliğine Atama ve '
        .'Yükseltme Esaslarının Bilimsel Yayın, Araştırma ve Etkinlik Puan Tablosundan. '
        .'Çok yazarlı yayınlarda puan yazar sayısına EŞİT olarak bölünüyor; yazar listesini boş '
        .'bırakırsanız bölme uygulanmaz ve puanınız olduğundan yüksek görünür. Verilen '
        .'derslerden en fazla 15, çevirilerden en fazla 15, atıflardan en fazla 25 puan '
        .'alınabiliyor. '
        .'Tabloda PATENT, SANATSAL ETKİNLİK ve TOPLUMSAL KATKI satırı YOK; bu kayıtlarınız '
        .'toplam puanınıza katkı vermiyor. B ve C bölümlerinin dipnotu ders kitaplarını ve '
        .'özgün olmayan derleme kitapları açıkça dışladığı için ders kitabı da puansız. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: ödül satırlarına, kayıt ödülün '
        .'derecesini taşımadığı için üçüncülük değeri (%70) uygulanıyor; uluslararası kitap '
        .'(15) ile ulusal kitap (20) tek etikete düştüğü için düşük olan, SCI atıfları (3) ile '
        .'ESCI-Scopus atıfları (2) tek etikete düştüğü için yine düşük olan uygulanıyor; proje '
        .'BAŞVURUSU satırı, yurt dışında iki dönem bulunma satırı, konferans kitabı editörlüğü '
        .'ve makale çevirisi girilemedi.',

    // "Çok yazarlı yayınlarda puanlar yazar sayısına göre eşit olarak
    // dağıtılır." Sıra ayrımı yok; bütün roller 1/n alıyor. Kural
    // yayınlara ilişkin olduğu için proje, ödül, ders, idari görev, tez
    // danışmanlığı ve atıf dışarıda bırakıldı.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'proje', 'odul', 'tez_danismanligi', 'egitim_ogretim',
            'idari_gorev', 'toplumsal_katki', 'diger', 'sanatsal_etkinlik', 'patent'],
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
    ],

    'maddeler' => [
        // ══ A. MAKALE ══
        'A.1' => ['baslik' => 'SSCI, SCI, SCI-Expanded ya da AHCI kategorisindeki dergide yayımlanmış tam makale', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $TAM, 'puan' => 30],
        'A.2' => ['baslik' => 'ESCI, Scopus, MLA ya da doçentlik başvurularında kabul edilen diğer alan indeksleri kapsamındaki dergide yayımlanmış tam makale', 'kategori' => 'makale', 'kaynaklar' => $ALAN_INDEKS, 'turler' => $TAM, 'puan' => 25],
        'A.3' => ['baslik' => 'TR Dizin indeksli dergide yayımlanmış tam makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TAM, 'puan' => 15],
        'A.4' => ['baslik' => 'Diğer indeksli dergide yayımlanmış tam makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => 5],
        'A.5' => ['baslik' => 'SSCI, SCI, SCI-Expanded ya da AHCI kategorisindeki dergide yayımlanmış teknik not, editöre mektup, vaka incelemesi, tartışma veya kitap incelemesi', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $KISA, 'puan' => 5],
        'A.6' => ['baslik' => 'ESCI, Scopus, MLA, TR Dizin ya da diğer indeksli dergide yayımlanmış teknik not, editöre mektup, vaka incelemesi, tartışma veya kitap incelemesi', 'kategori' => 'makale', 'kaynaklar' => [...$ALAN_INDEKS, 'TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 2],

        // ══ B. ULUSAL / ULUSLARARASI KİTAP ══
        'B.1' => ['baslik' => 'Book Citation Index kapsamındaki yayınevinde yayımlanmış uluslararası bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 35],
        'B.2' => ['baslik' => 'Book Citation Index kapsamındaki yayınevinde yayımlanmış uluslararası bilimsel kitap bölümü yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 20],
        'B.3' => ['baslik' => 'YÖK\'ün kabul ettiği şartları taşıyan uluslararası ya da ulusal bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 15],
        'B.4' => ['baslik' => 'YÖK\'ün kabul ettiği şartları taşıyan uluslararası ya da ulusal bilimsel kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 10],

        // ══ C. KİTAP VE DERGİ EDİTÖRLÜĞÜ ══
        'C.1' => ['baslik' => 'Book Citation Index kapsamındaki yayınevinde yayımlanmış uluslararası bilimsel kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 20],
        'C.3' => ['baslik' => 'YÖK\'ün kabul ettiği şartları taşıyan uluslararası ya da ulusal bilimsel kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 10],
        'C.4' => ['baslik' => 'SSCI, SCI, SCI-Expanded ya da AHCI kategorisindeki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 15],
        'C.5' => ['baslik' => 'Scopus, MLA, ESCI ya da diğer alan indeksleri kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 10],
        'C.6' => ['baslik' => 'TR Dizin kapsamındaki dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 5],
        'C.7' => ['baslik' => 'Diğer indeksli dergide editörlük, yayın kurulu üyeliği ya da hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi', 'Yayın Kurulu Üyeliği', 'Hakemlik'], 'puan' => 2],

        // ══ D. ULUSAL / ULUSLARARASI PROJE ══
        'D.1' => ['baslik' => 'Birleşmiş Milletler, Dünya Bankası ya da Avrupa Birliği araştırma fonları gibi uluslararası kuruluşlarca desteklenmiş ve başarıyla tamamlanmış projede koordinatör veya yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 30],
        'D.2' => ['baslik' => 'Birleşmiş Milletler, Dünya Bankası ya da Avrupa Birliği araştırma fonları gibi uluslararası kuruluşlarca desteklenmiş projede araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],
        'D.3' => ['baslik' => 'Diğer uluslararası resmî kurum ve kuruluşlarca desteklenmiş projede koordinatör veya yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 20],
        'D.4' => ['baslik' => 'Diğer uluslararası resmî kurum ve kuruluşlarca desteklenmiş projede araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
        'D.5' => ['baslik' => 'TÜBİTAK destekli bilimsel araştırma projesinde koordinatör veya yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 25],
        'D.6' => ['baslik' => 'TÜBİTAK destekli bilimsel araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
        'D.7' => ['baslik' => 'BAP destekli bilimsel araştırma projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => $BAP, 'roller' => ['yurutucu'], 'puan' => 5],
        'D.8' => ['baslik' => 'BAP destekli bilimsel araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => $BAP, 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 3],
        'D.9' => ['baslik' => 'Diğer kamu ya da özel kuruluşlarca desteklenmiş bilimsel projede koordinatör veya yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => $KAMU_OZEL, 'roller' => ['yurutucu'], 'puan' => 5],
        'D.10' => ['baslik' => 'Diğer kamu ya da özel kuruluşlarca desteklenmiş bilimsel projede araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => $KAMU_OZEL, 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 2],

        // ══ E. KONGRE BİLDİRİSİ ══
        'E.1' => ['baslik' => 'Uluslararası kongrede sunulmuş tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 7],
        'E.2' => ['baslik' => 'Uluslararası kongrede sunulmuş ve özeti yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 5],
        'E.3' => ['baslik' => 'Ulusal kongrede sunulmuş tam metin bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 5],
        'E.4' => ['baslik' => 'Ulusal kongrede sunulmuş ve özeti yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster', 'Davetli Konuşmacı'], 'puan' => 2],

        // ══ F. ÖDÜL (üçüncülük değeriyle) ══
        'F.1' => ['baslik' => 'Uluslararası bilimsel kuruluşlarca verilen en iyi bilim insanı ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 21],
        'F.2' => ['baslik' => 'TÜBA, TÜBİTAK ya da YÖK tarafından verilen en iyi bilim insanı ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü', 'YÖK Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 14],
        'F.3' => ['baslik' => 'Diğer ulusal kuruluşlarca verilen en iyi bilim insanı ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'Burs'], 'puan' => 3],
        'F.5' => ['baslik' => 'Tanınmış bir organizasyon tarafından tamamlanan bilimsel çalışmaya verilen ödül', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 1],

        // ══ G. DERS VE İDARİ GÖREV ══
        'G.2' => ['baslik' => 'Lisans dersi vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 1],
        'G.3' => ['baslik' => 'Yüksek lisans ya da doktora dersi vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 2],
        'G.4' => ['baslik' => 'Sonuçlandırılmış yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi', 'Tez İzleme / Jüri Üyeliği'], 'puan' => 2],
        'G.5' => ['baslik' => 'Sonuçlandırılmış doktora tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 4],
        'G.6' => ['baslik' => 'Rektör, dekan, dekan yardımcısı, enstitü müdürü ya da yüksekokul müdürü olarak görev yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü', 'Dekan Yrd. / Müdür Yrd.'], 'puan' => 4],
        'G.7' => ['baslik' => 'Bölüm başkanı, anabilim dalı başkanı, komisyon üyesi, koordinatör ya da merkez müdürü olarak görev yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı', 'Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük', 'Kurul / Komisyon Üyeliği', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 3],

        // ══ H. ÇEVİRİ ══
        'H.2' => ['baslik' => 'Kitap bölümü çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 5],
        'H.3' => ['baslik' => 'Kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 10],

        // ══ I. ATIF ══
        'I.2' => ['baslik' => 'Book Citation Index kapsamındaki uluslararası bilimsel kitapta atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 3],
        // Sözlük 16.09.2026'da atıfta ESCI'yi çekirdek indeksten ayırdı.
        'I.1' => ['baslik' => 'SSCI, SCI, SCI-Expanded ya da AHCI kategorisindeki dergilerde veya kitapta atıf', 'kategori' => 'atif', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 3],
        'I.3' => ['baslik' => 'ESCI, Scopus ya da MLA kapsamındaki dergilerde atıf', 'kategori' => 'atif', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 2],
        'I.5' => ['baslik' => 'Ulusal bilimsel kitapta ya da TR Dizinli ulusal hakemli dergide atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 1],
    ],

    'gruplar' => [
        // Yayın şartlarının atıf yaptığı kümeler.
        'A1-B1-B2' => ['A.1', 'B.1', 'B.2'],
        'A2-A3-B3-B4-B5-B6' => ['A.2', 'A.3', 'B.3', 'B.4'],
        // Tavan grupları.
        'G-DERS' => ['G.2', 'G.3'],
        'H-CEVIRI' => ['H.2', 'H.3'],
        'I-ATIF' => ['I.2', 'I.3', 'I.5'],
    ],

    'grup_tavanlari' => [
        'G-DERS' => 15,
        'H-CEVIRI' => 15,
        'I-ATIF' => 25,
    ],
];
