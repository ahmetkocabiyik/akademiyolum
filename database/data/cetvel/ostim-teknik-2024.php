<?php

/**
 * OSTİM TEKNİK ÜNİVERSİTESİ — Ek-1/IV Atama ve Yükseltme Puanlama Ölçütleri
 * Kaynak: pdf/17634009071.Ostim Teknik Üniversitesi Kriter.pdf
 *
 * Madde kodları Ek-1/IV'ün kendi numaralarını izliyor (1.a.1, 3.2.b …).
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   1.a bendi SCOPUS'un yalnız Q1 dilimini kapsıyor; kayıtta Scopus ile
 *       ESCI aynı etikette ve ESCI bu bentte sayılmıyor. 'ESCI / Scopus'
 *       etiketi bu yüzden 1.b/4'ün "diğer uluslararası alan indeksleri"
 *       değerinden (5 puan) sayılıyor. Scopus Q1 makaleleriniz varsa
 *       puanınız burada belirgin biçimde DÜŞÜK çıkar.
 *   Bildiride WoS-Scopus posteri (15) ile diğer uluslararası poster (5)
 *       aynı etikete düşüyor → 5; davetli konuşmacılıkta uluslararası (10)
 *       ile ulusal (5) → 5.
 *   Tez danışmanlığında danışmanlık (10 ve 5) ile eş danışmanlık (8 ve 3)
 *       ayrışmıyor → doktorada 8, yüksek lisansta 3.
 *   Projelerde ulusal yöneticilik (20) ile görev alma (15) rol üzerinden
 *       ayrıldı; diğer kurum projelerinde hakemlik ve danışmanlık 7.
 *   Ödülde ulusal jürili ödül (5) ile TÜBİTAK-TÜBA ve YÖK ödülleri aynı
 *       etikete düşüyor → 5. Burslarda uluslararası (20) ile ulusal (10)
 *       → 10.
 *   Teknokent satırlarında şirket kurma (25), yönetimde görev (15), ortak
 *       olma (10) ve araştırmacılık (10) tek 'Ticarileştirme' etiketinde
 *       → 10.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   5.b/1 (son iki yılda verilen derslerin her AKTS'si için 2 puan) —
 *       kayıt dersin AKTS değerini taşımıyor; ders kayıtlarınız toplam
 *       puana katkı vermiyor. Bu bölümden en fazla 25 puan alınabiliyordu.
 *   TR Dizin dışındaki ulusal hakemli dergiler — puanlama ölçütlerinde
 *       yalnız TR Dizin satırı var; 'Diğer Ulusal Hakemli' etiketine
 *       hiçbir satır bağlanmadı. (Yeniden atamanın "ulusal veya
 *       uluslararası hakemli dergide bir makale" koşulunda bu makaleler
 *       sayılamıyor.)
 *   Çeviri kitap ve kitap bölümü satırları ile SANATSAL ETKİNLİK ve
 *       TOPLUMSAL KATKI kalemlerinin tamamı — ölçütlerde hiç yok.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   "Üniversite-iş dünyası iş birliğine yönelik ise ilgili puanlara 5'er
 *       puan eklenir" kuralı (bildiri, davetli konuşma ve proje
 *       satırlarında): kayıt iş birliği niteliğini taşımıyor, ek puan
 *       uygulanmıyor.
 *   Açıklamalar bölümünün "bir bildiri ya da makale aynı etkinlik
 *       çerçevesinde yalnız bir kez puanlanır" kuralı.
 *
 * Yönerge: yonerge/ostim-teknik.php
 */
$OZGUN = ['ozgun_makale'];
$DERLEME = ['derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];
$WOS = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];

$maddeler = [
    // ══ 1. YAYINLAR ══
    '1.a.1' => ['baslik' => 'SCI, SCI-Expanded, SSCI, AHCI ya da Scopus (Q1) kapsamındaki hakemli dergide tam metinli özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $OZGUN, 'puan' => 70],
    '1.a.2' => ['baslik' => 'SCI, SCI-Expanded, SSCI, AHCI ya da Scopus (Q1) kapsamındaki hakemli dergide derleme makale', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $DERLEME, 'puan' => 50],
    '1.a.3' => ['baslik' => 'SCI, SCI-Expanded, SSCI, AHCI ya da Scopus (Q1) kapsamındaki hakemli dergide editöre mektup, özet ve benzeri yazı', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $KISA, 'puan' => 30],
    '1.b.1' => ['baslik' => 'İtibarlı uluslararası indekslerde (Index Copernicus, Ulrich\'s, EI Compendex vb.) taranan hakemli dergide tam metinli özgün araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $OZGUN, 'puan' => 15],
    '1.b.2' => ['baslik' => 'İtibarlı uluslararası indekslerde taranan hakemli dergide derleme makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $DERLEME, 'puan' => 10],
    '1.b.3' => ['baslik' => 'İtibarlı uluslararası indekslerde taranan hakemli dergide editöre mektup, özet ve benzeri yazı', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $KISA, 'puan' => 5],
    '1.b.4' => ['baslik' => 'Diğer uluslararası alan indekslerinde taranan hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 5],
    '1.c.1' => ['baslik' => 'TR Dizin kapsamındaki hakemli dergide tam metinli özgün araştırma makalesi ya da derleme', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => [...$OZGUN, ...$DERLEME], 'puan' => 15],
    '1.c.3' => ['baslik' => 'TR Dizin kapsamındaki hakemli dergide editöre mektup, özet ve benzeri yazı', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $KISA, 'puan' => 5],

    // ══ 2. KONGRE YAYINLARI VE AKTİVİTELERİ ══
    '2.a.1' => ['baslik' => 'WoS (CPCI) ya da Scopus kapsamındaki uluslararası bilimsel toplantıda sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 25],
    '2.b.1' => ['baslik' => 'WoS ve Scopus kapsamı dışındaki uluslararası bilimsel toplantıda sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin'], 'puan' => 10],
    '2.b.2' => ['baslik' => 'Uluslararası bilimsel toplantıda poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 5],
    '2.c.1' => ['baslik' => 'Ulusal bilimsel toplantıda sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 5],
    '2.c.2' => ['baslik' => 'Ulusal bilimsel toplantıda poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 3],
    '2.d.1' => ['baslik' => 'Bilimsel toplantılarda davetli konuşmacı ya da moderatör olmak; Erasmus kapsamında yurt dışında ders, seminer ve konferans vermek', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 5],

    // ══ 3. KİTAPLAR ══
    '3.1.a' => ['baslik' => 'WoS ya da Scopus veri tabanlarında yer alan uluslararası kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 50],
    '3.1.b' => ['baslik' => 'WoS ya da Scopus veri tabanlarında yer alan uluslararası kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 30],
    '3.1.c' => ['baslik' => 'WoS ya da Scopus veri tabanlarında yer alan uluslararası kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 25],
    '3.2.a' => ['baslik' => 'Ulusal alanda yayımlanan kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı'], 'puan' => 15],
    '3.2.b' => ['baslik' => 'Ulusal alanda yayımlanan kitabın derleyiciliği ya da editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 10],
    '3.2.c' => ['baslik' => 'Ulusal alanda yayımlanan kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 10],

    // ══ 4. ATIFLAR ══
    '4.a.1' => ['baslik' => 'WoS ya da Scopus\'ta taranan kitap, dergi ve bildirilerde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 3],
    '4.a.2' => ['baslik' => 'TR Dizin\'de taranan dergilerde eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 1],

    // ══ 5. EĞİTİM-ÖĞRETİM FAALİYETLERİ ══
    '5.a.2' => ['baslik' => 'Doktora tezi danışmanlığı ya da eş danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 8],
    '5.a.1' => ['baslik' => 'Yüksek lisans tezi danışmanlığı ya da eş danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 3],
    '5.b.7' => ['baslik' => 'Doktora ya da tezli yüksek lisans tez jürisinde bulunmak', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 5],

    // ══ 6. PROJELER ══
    '6.a.1' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen sonuçlandırılmış projede yöneticilik', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 30],
    '6.a.2' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen sonuçlandırılmış projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 20],
    '6.b.1' => ['baslik' => 'Ulusal kuruluşlarca (TÜBİTAK, kalkınma ajansları vb.) desteklenen sonuçlandırılmış projede yöneticilik', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 20],
    '6.b.2' => ['baslik' => 'Ulusal kuruluşlarca desteklenen sonuçlandırılmış projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],
    '6.b.4' => ['baslik' => 'Diğer kurum ve kuruluşların desteklediği projelerde görev, hakemlik, danışmanlık ya da izleyicilik', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'], 'puan' => 7],

    // ══ 7. DİĞER BİLİMSEL FAALİYETLER ══
    '7.a' => ['baslik' => 'Alanında bilimsel araştırma ve çalışmalar için burs almak', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 10],

    // ══ 8. PATENT VE FAYDALI MODEL ══
    '8.a.1' => ['baslik' => 'Yurt dışında alınmış patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 50],
    '8.a.2' => ['baslik' => 'Yurt içinde alınmış patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 25],
    '8.b.2' => ['baslik' => 'Faydalı model ya da tasarım tescili', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım'], 'puan' => 15],

    // ══ 9. ÖDÜLLER ══
    '9.a.1' => ['baslik' => 'Jüri seçimine dayalı uluslararası bilimsel ödül; uluslararası hakemli dergiden alınan yayın ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 20],
    '9.a.2' => ['baslik' => 'Jüri seçimine dayalı ulusal bilimsel ödül', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü', 'Yarışma Derecesi / Mansiyon'], 'puan' => 5],

    // ══ 10. ÖZEL KONULAR ══
    '10.a' => ['baslik' => 'Teknokent ya da teknoparkta şirket kurmak, ortağı olmak, yönetiminde görev almak ya da araştırmacı olarak çalışmak', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 10],

    // ══ 11. İDARİ GÖREVLER ══
    '11.a.1' => ['baslik' => 'Rektörlük, rektör yardımcılığı, dekanlık ya da müdürlük', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü'], 'puan' => 25],
    '11.a.2' => ['baslik' => 'Dekan yardımcılığı, müdür yardımcılığı, bölüm başkanlığı, anabilim dalı başkanlığı ya da merkez müdürlüğü', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkanı', 'Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük', 'Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 15],
    '11.a.3' => ['baslik' => 'Yükseköğretim üst kurullarında, üniversite organlarında ya da rektörlükçe kurulan komisyon ve kurullarda görev almak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 10],
];

return [
    'kapsam_notu' => 'Puanlar OSTİM Teknik Üniversitesi Öğretim Üyesi Atama ve Yükseltme '
        .'Yönergesinin Ek-1/IV puanlama ölçütlerinden. Çok yazarlı yayınlarda puan yazar '
        .'sayısına göre çarpılıyor: tek yazarlı ×1, iki yazarlı ×0,8, üç yazarlı ×0,6, dört '
        .'yazarlı ×0,4, beş ve üzeri ×0,2; yazar sırasının etkisi yok. Yazar listesini boş '
        .'bırakırsanız çarpan uygulanmaz ve puanınız olduğundan yüksek görünür. İtibarlı '
        .'uluslararası indekslerden ve TR Dizin\'den en fazla 75\'er, ulusal kitaplardan 30, '
        .'atıflardan 20, tez yönetiminden 25, projelerden 40 (ulusal projelerden 25), diğer '
        .'bilimsel faaliyetlerden 20, patentten 50, ödüllerden 20, özel konulardan 40 ve idari '
        .'görevlerden 25 puan alınabiliyor. Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: '
        .'ölçütlerin 1.a bendi Scopus\'un yalnız Q1 dilimini kapsıyor ve kayıtta Scopus ile '
        .'ESCI aynı etikette olduğu için bu makaleler 5 puandan sayılıyor; ders puanı AKTS '
        .'başına verildiği için ders kayıtlarınız hiç sayılmıyor; TR Dizin dışındaki ulusal '
        .'hakemli dergiler, çeviriler, sanatsal etkinlikler ve toplumsal katkı kalemleri '
        .'ölçütlerde hiç yok; "üniversite-iş dünyası iş birliği" için verilen 5\'er puanlık '
        .'ekler uygulanamıyor.',

    // Açıklamalar bölümü: tek yazarlı ×1, iki ×0,8, üç ×0,6, dört ×0,4,
    // beş ve üstü ×0,2. Yazar sırası dikkate alınmıyor.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'editorluk', 'proje', 'tez_danismanligi', 'tez_yayini',
            'egitim_ogretim', 'idari_gorev', 'toplumsal_katki', 'odul', 'sanatsal_etkinlik', 'diger'],
        'kademeler' => [1 => 1.00, 2 => 0.80, 3 => 0.60, 4 => 0.40],
        'sonrasi' => 0.20,
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        'TOPLAM' => array_keys($maddeler),
        // Ek-1/I-2 ve II-3: "Web of Science (SCI-Expanded, SSCI, AHCI)
        // indekslerinde makale".
        'WOS' => ['1.a.1', '1.a.2', '1.a.3'],
        // Ek-1/III-1-b: "tam metinli makale, editöre mektup vb.".
        'MAKALE' => ['1.a.1', '1.a.2', '1.a.3', '1.b.1', '1.b.2', '1.b.3', '1.b.4', '1.c.1', '1.c.3'],
        // Ek-1/III-1-b: "en az biri özgün araştırma makalesi".
        'OZGUN' => ['1.a.1', '1.b.1', '1.c.1'],
        // Tavan grupları.
        'ULUSLARARASI-INDEKS' => ['1.b.1', '1.b.2', '1.b.3', '1.b.4'],
        'TR-DIZIN' => ['1.c.1', '1.c.3'],
        'ULUSAL-KITAP' => ['3.2.a', '3.2.b', '3.2.c'],
        'ATIF' => ['4.a.1', '4.a.2'],
        'TEZ' => ['5.a.1', '5.a.2', '5.b.7'],
        'PROJE' => ['6.a.1', '6.a.2', '6.b.1', '6.b.2', '6.b.4'],
        'ULUSAL-PROJE' => ['6.b.1', '6.b.2', '6.b.4'],
        'BURS' => ['7.a'],
        'PATENT' => ['8.a.1', '8.a.2', '8.b.2'],
        'ODUL' => ['9.a.1', '9.a.2'],
        'TEKNOKENT' => ['10.a'],
        'IDARI' => ['11.a.1', '11.a.2', '11.a.3'],
    ],

    'grup_tavanlari' => [
        'ULUSLARARASI-INDEKS' => 75,
        'TR-DIZIN' => 75,
        'ULUSAL-KITAP' => 30,
        'ATIF' => 20,
        'TEZ' => 25,
        'PROJE' => 40,
        'ULUSAL-PROJE' => 25,
        'BURS' => 20,
        'PATENT' => 50,
        'ODUL' => 20,
        'TEKNOKENT' => 40,
        'IDARI' => 25,
    ],
];
