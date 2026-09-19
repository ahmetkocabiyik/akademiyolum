<?php

/**
 * İSTANBUL GEDİK ÜNİVERSİTESİ — EK-2 puanlama tablosu
 * Kaynak: pdf/17537099642.istanbulgedikuniversitesi.pdf (7 sayfa)
 *
 * Yönergenin tek bir puanlama tablosu var; temel alana göre bölünmüyor.
 * Madde kodları tablonun kendi harfleri (A-J), satır sırası eklendi.
 *
 * ── EN ÇOK PUAN KAYBETTİREN KARARLAR ──
 *   ÜNİVERSİTE İÇİ (BAP) PROJELERİ HİÇ SAYILMIYOR. G bölümü yalnız
 *       "uluslararası kaynaklı" ve "üniversite dışı kaynaklı" projeleri
 *       puanlıyor; kendi üniversitesinin BAP projesine satır yok.
 *   J bölümünün "(*) son iki yılda alınan dersler verilecektir" kaydı
 *       uygulanamıyor: motor tek bir satıra kendi zaman penceresini
 *       koyamıyor. Daha eski derslerinizi de sayıyor, puanınız bu
 *       kalemde OLDUĞUNDAN YÜKSEK görünür.
 *   LİSANSÜSTÜ TEZDEN ÜRETİLMİŞ YAYIN, İDARİ GÖREV, TOPLUMSAL KATKI ve
 *       (yarışma dışındaki) ÖDÜL kalemlerinin tabloda hiç karşılığı yok;
 *       bu kayıtlar toplama girmiyor.
 *   EŞ DANIŞMANLIK girilmedi: F bölümü yalnız "danışmanlığını yürüttüğü"
 *       tamamlanmış tezleri sayıyor, ikinci danışmanlık için satır yok.
 *   TEZSİZ yüksek lisans danışmanlığı (1 puan) kayıtta tezliden
 *       ayrılamadığı için girilmedi; tezli satırından (2) sayılıyor.
 *
 * ── AYNI ETİKETE DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   "Tanınmış uluslararası yayınevi" ile "tanınmış ulusal yayınevi"
 *       ayrımı kayıtta yok. BKCI/Scopus etiketi uluslararası (20/10),
 *       öteki kitap etiketleri ulusal (10/5) satırından sayılıyor.
 *   Patentte yalnız uluslararası/ulusal ayrımı var; faydalı model,
 *       endüstriyel tasarım ve yazılım ulusal satırından (10) sayılıyor.
 *   E bölümü "tam metni basılmış SÖZLÜ bildiri", H bölümü ise genel
 *       "sunulan bildiri" diyor; tam metin kayıtları E'den (5 ve 3),
 *       özet ve poster kayıtları H'den (3 ve 2) sayılıyor.
 *   I bölümünün "jüri üyeliği vb. diğer faaliyetler" satırı (1) tez
 *       izleme ve atama jürilerini de topluyor.
 *
 * ── YAZAR ÇARPANI ──
 * Tablonun 5. açıklaması: "İkiden fazla yazarlı yayınlarda puan yazar
 * sayısına bölünür." Tek ve iki yazarlı eserlerde tam puan; üç ve daha
 * fazla yazarlıda puan/yazar sayısı. Sıraya göre ayrım yok, bu yüzden
 * çarpan rol tablosuz tek kademe olarak yazıldı.
 *
 * Yönerge: yonerge/istanbul-gedik.php
 *
 * TANINMIŞ YAYINEVİ AYRIMI KAPSAM ETİKETİNE BAĞLANDI (19.09.2026): sıfat iki
 * kademede de aynı, ayrımı yapan tek şey yayınevinin kapsamı. Kapsamlı
 * etiketler üst satırlara bağlandı, ulusal satırlar daraltıldı.
 *
 * B3 (uluslararası kitap editörlüğü) kapsamsız `Kitap Editörlüğü` etiketini de
 * taşımayı sürdürüyor: kaynakta ULUSAL kitap editörlüğü satırı yok, kapsamsız
 * kayıt başka bir satıra düşemiyor.
 */
$SCI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)'];
$ULUSLARARASI_PROJE = ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'];
$DIS_PROJE = ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'];

$maddeler = [
    // ══ A. MAKALELER ══
    'A1' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI kapsamındaki dergilerde yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => [...$SCI, 'AHCI'], 'puan' => 20],
    'A2' => ['baslik' => 'Diğer uluslararası hakemli dergilerde yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'puan' => 10],
    'A3' => ['baslik' => 'ULAKBİM tarafından taranan ulusal hakemli dergilerde yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 8],
    'A4' => ['baslik' => 'Ulusal hakemli dergilerde yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 5],

    // ══ B. KİTAPLAR ══
    'B1' => ['baslik' => 'Tanınmış uluslararası yayınevleri tarafından yayımlanan özgün bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası Kitap'], 'puan' => 20],
    'B2' => ['baslik' => 'Tanınmış uluslararası yayınevleri tarafından yayımlanan özgün bilimsel kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Uluslararası Kitap Bölümü'], 'puan' => 10],
    'B4' => ['baslik' => 'Tanınmış ulusal yayınevleri tarafından yayımlanan özgün bilimsel kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap', 'Ders / Metot Kitabı', 'Tahkik (Tenkitli Metin)', 'Çeviri Kitap'], 'puan' => 10],
    'B5' => ['baslik' => 'Tanınmış ulusal yayınevleri tarafından yayımlanan özgün bilimsel kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap Bölümü', 'Ansiklopedi Maddesi', 'Çeviri Kitap Bölümü'], 'puan' => 5],
    'B3' => ['baslik' => 'Tanınmış uluslararası yayınevleri tarafından yayımlanan özgün bilimsel kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Kitap Editörlüğü', 'Uluslararası Kitap Editörlüğü'], 'puan' => 10],

    // ══ C. PATENT, YARIŞMA ══
    'C1' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
    'C2' => ['baslik' => 'Ulusal patent, faydalı model, endüstriyel tasarım ya da yazılım', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili', 'Ticarileştirme'], 'puan' => 10],
    'C3' => ['baslik' => 'Planlama, mimarlık, kentsel tasarım, peyzaj, iç mimari ya da endüstri ürünleri tasarımı yarışmalarında derece veya mansiyon', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon', 'Uluslararası Bilim/Sanat Ödülü', 'Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü', 'Ufuk Avrupa / ERC Ödülü', 'Burs'], 'puan' => 15],
    'C4' => ['baslik' => 'Jürili yarışmalara katılmak, danışmanlık yapmak ya da jüri üyesi olarak görev yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)', 'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'], 'puan' => 10],

    // ══ D. ATIFLAR ══
    'D1' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI kapsamındaki dergilerde ve tanınmış uluslararası yayınevlerinin kitaplarında eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
    'D2' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI kapsamı dışındaki dergilerde ve kitap bölümlerinde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
    'D3' => ['baslik' => 'Ulusal hakemli dergilerde ve kitaplarda eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 1],

    // ══ E. KONGRE / SEMPOZYUM (TAM METİN) — H. BİLİMSEL TOPLANTI ══
    'E1' => ['baslik' => 'Uluslararası sempozyum ya da kongrede sunulmuş, tam metni basılmış sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 5],
    'E2' => ['baslik' => 'Ulusal sempozyum ya da kongrede sunulmuş, tam metni basılmış sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 3],
    'H1' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster', 'Davetli Konuşmacı'], 'puan' => 3],
    'H2' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 2],

    // ══ F. LİSANSÜSTÜ TEZ DANIŞMANLIĞI ══
    'F1' => ['baslik' => 'Danışmanlığınızda tamamlanmış doktora tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 4],
    'F2' => ['baslik' => 'Danışmanlığınızda tamamlanmış tezli yüksek lisans', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 2],

    // ══ G. BİLİMSEL ARAŞTIRMA PROJESİ ══
    'G1' => ['baslik' => 'Devam eden ya da başarıyla tamamlanmış uluslararası kaynaklı bilimsel araştırma projesinde yürütücü veya koordinatör olmak', 'kategori' => 'proje', 'kaynaklar' => $ULUSLARARASI_PROJE, 'roller' => ['yurutucu'], 'puan' => 15],
    'G2' => ['baslik' => 'Devam eden ya da başarıyla tamamlanmış uluslararası kaynaklı bilimsel araştırma projesinde ortak araştırıcı olmak', 'kategori' => 'proje', 'kaynaklar' => $ULUSLARARASI_PROJE, 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
    'G3' => ['baslik' => 'Devam eden ya da başarıyla tamamlanmış üniversite dışı kaynaklı bilimsel araştırma projesinde araştırıcı olmak', 'kategori' => 'proje', 'kaynaklar' => $DIS_PROJE, 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 8],
    'G4' => ['baslik' => 'Devam eden ya da başarıyla tamamlanmış üniversite dışı kaynaklı bilimsel araştırma projesinde yürütücü veya koordinatör olmak', 'kategori' => 'proje', 'kaynaklar' => $DIS_PROJE, 'roller' => ['yurutucu'], 'puan' => 6],

    // ══ I. DİĞER FAALİYETLER ══
    'I1' => ['baslik' => 'Dergi editörlüğü ya da genel yayın yönetmenliği', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi', 'TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 10],
    'I2' => ['baslik' => 'Kongre ya da sempozyum düzenleme kurulu üyeliği, jüri üyeliği ve benzeri diğer faaliyetler', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği', 'Hakemlik'], 'puan' => 1],
    'I3' => ['baslik' => 'Tez izleme komitesi ya da atama jürisi üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 1],

    // ══ J. EĞİTİM-ÖĞRETİM FAALİYETLERİ ══
    'J1' => ['baslik' => 'Bir dönem verilen lisansüstü ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
    'J2' => ['baslik' => 'Bir dönem verilen lisans ya da ön lisans dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 1],
    'J3' => ['baslik' => 'Bilimsel toplantı düzenleme ya da bilim kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 1],
];

return [
    'kapsam_notu' => 'Puanlar İstanbul Gedik Üniversitesi Akademik Yükseltme ve Atama Yönergesinin '
        .'EK-2 puanlama tablosundan. Yazar çarpanı: tek ve iki yazarlı eserlerde tam puan, üç ve daha '
        .'fazla yazarlıda puan yazar sayısına bölünür (tablo açıklama 5). Yazar listesini boş '
        .'bırakırsanız çarpan hiç uygulanmaz ve puanınız olduğundan YÜKSEK görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: üniversitenin kendi BAP projeleri '
        .'tabloda hiç geçmiyor; lisansüstü tezden üretilmiş yayın, idari görev, toplumsal katkı ve '
        .'yarışma dışındaki ödüller için satır yok; eş danışmanlık ile tezsiz yüksek lisans '
        .'danışmanlığı girilmedi. Faydalı model, endüstriyel tasarım ve '
        .'yazılım ulusal patent satırından (10) sayılıyor. '
        .'Puanınız şu kalemde OLDUĞUNDAN YÜKSEK görünür: J bölümünün "son iki yılda alınan '
        .'dersler" kaydı motorda satır bazlı bir zaman penceresine çevrilemediği için daha eski '
        .'dersleriniz de toplama giriyor.'
        .' KİTAPTA "TANINMIŞ YAYINEVİ" KOŞULU DENETLENMİYOR: uluslararası yayınevi kitabınız yönergenin tanınmış uluslararası yayınevi satırından sayılıyor. Yayıneviniz yönergenin tanımına (faaliyet süresi, kütüphane kataloglaması, kitap sayısı) girmiyorsa puanınız olduğundan YÜKSEK görünür; başvurunuzda yayınevini belgeleyin.',

    'yazar_katsayisi' => [
        'haric' => ['atif', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev', 'odul',
            'editorluk', 'toplumsal_katki', 'proje', 'patent', 'sanatsal_etkinlik', 'diger'],
        'kademeler' => [1 => 1.00, 2 => 1.00],
        'bol' => ['pay' => 1.0],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        'TUM' => array_keys($maddeler),
        // MADDE 6.1: "uluslararası alan indekslerinde taranan dergilerde
        // yayınlanmış araştırma makalesi".
        'MAKALE-ULUS' => ['A1', 'A2'],
        'MAKALE' => ['A1', 'A2', 'A3', 'A4'],
        'KITAP' => ['B1', 'B2', 'B4', 'B5'],
        // MADDE 6.3'ün yarışma seçeneği.
        'YARISMA' => ['C3', 'C4'],
    ],

    'grup_tavanlari' => [],
];
